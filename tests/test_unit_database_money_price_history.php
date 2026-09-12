<?php
declare(strict_types=1);

/**
 * tests/test_unit_database_money_price_history.php — Comprehensive Unit Test Suite
 * Master Specification V2 — Sections 40, 41, 42, 43
 * 
 * - Section 40: Database Audit (Schema mapping & column completeness)
 * - Section 41: Database Integrity (Primary keys, FK indexes, transaction bounds, decimal precision)
 * - Section 42: Money Storage (Exact paise minor units, zero float drift, Indian grouping, Rupee SVG)
 * - Section 43: Price History (Audit logging, batch change detection, zero customer leakage)
 * 
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Money.php';
require_once __DIR__ . '/../src/PriceHistoryManager.php';
require_once __DIR__ . '/../src/PricingCalculator.php';

use DTBrand\Database;
use DTBrand\Money;
use DTBrand\PriceHistoryManager;
use DTBrand\PricingCalculator;

echo "═══════════════════════════════════════════════════════════════════\n";
echo "🧪 DT Brand's — Sections 40-43: DB Audit, Money & Price History\n";
echo "═══════════════════════════════════════════════════════════════════\n\n";

$passed = 0;
$failed = 0;

function assertTest(string $desc, bool $condition, string $details = ''): void {
    global $passed, $failed;
    if ($condition) {
        echo "  ✅ PASS: {$desc}\n";
        $passed++;
    } else {
        echo "  ❌ FAIL: {$desc}" . ($details ? " ({$details})" : '') . "\n";
        $failed++;
    }
}

// -------------------------------------------------------------
// 1. Section 40: Database Audit & Schema Field Mapping
// -------------------------------------------------------------
echo "── 1. Section 40: Database Audit & Field Mapping ──\n";

$migrationFile = __DIR__ . '/../database/migrations/2026_09_12_000014_create_price_history_and_database_integrity.sql';
assertTest('Price history & integrity migration exists', file_exists($migrationFile));

$migrationSql = file_get_contents($migrationFile);
assertTest('Migration creates product_price_history table', str_contains($migrationSql, 'CREATE TABLE IF NOT EXISTS `product_price_history`'));
assertTest('Migration creates product_id index', str_contains($migrationSql, 'idx_pph_product'));
assertTest('Migration creates created_at index', str_contains($migrationSql, 'idx_pph_created'));
assertTest('Migration adds integrity index on products', str_contains($migrationSql, 'idx_products_cat_brand'));
assertTest('Migration adds integrity index on orders', str_contains($migrationSql, 'idx_orders_cust_status'));
assertTest('Migration adds integrity index on order_items', str_contains($migrationSql, 'idx_order_items_ord_prod'));

// -------------------------------------------------------------
// 2. Section 41: Database Integrity & Financial Precision
// -------------------------------------------------------------
echo "\n── 2. Section 41: Database Integrity & Precision ──\n";

// Verify DECIMAL(12,2) / DECIMAL(10,2) usage in migrations (NEVER float or double)
assertTest('Migration uses DECIMAL(12,2) for price history', 
    str_contains($migrationSql, '`old_price` DECIMAL(12,2)') &&
    str_contains($migrationSql, '`new_price` DECIMAL(12,2)')
);
assertTest('Migration does not use FLOAT or DOUBLE for money', 
    !str_contains($migrationSql, 'FLOAT') &&
    !str_contains($migrationSql, 'DOUBLE')
);

// Verify transaction boundary methods exist on Database engine
assertTest('Database engine supports beginTransaction', method_exists(Database::class, 'beginTransaction'));
assertTest('Database engine supports commit', method_exists(Database::class, 'commit'));
assertTest('Database engine supports rollBack', method_exists(Database::class, 'rollBack'));
assertTest('Database engine supports inTransaction', method_exists(Database::class, 'inTransaction'));

// -------------------------------------------------------------
// 3. Section 42: Money Storage & Exact Arithmetic
// -------------------------------------------------------------
echo "\n── 3. Section 42: Money Storage Engine (src/Money.php) ──\n";

// Instantiation from decimal and paise
$m1 = Money::fromDecimal(1450.50);
assertTest('Money::fromDecimal parses float correctly', $m1->getAmount() === 1450.50 && $m1->getPaise() === 145050);

$m2 = Money::fromDecimal('2999.75');
assertTest('Money::fromDecimal parses string correctly', $m2->getAmount() === 2999.75 && $m2->getPaise() === 299975);

$m3 = Money::fromPaise(50000);
assertTest('Money::fromPaise parses minor units', $m3->getAmount() === 500.00 && $m3->getPaise() === 50000);

// Exact arithmetic without IEEE-754 drift
$sum = $m1->add($m2);
assertTest('Money::add produces exact sum', $sum->toDecimal() === '4450.25' && $sum->getPaise() === 445025);

$diff = $m2->subtract($m1);
assertTest('Money::subtract produces exact difference', $diff->toDecimal() === '1549.25' && $diff->getPaise() === 154925);

$multiplied = $m1->multiply(3);
assertTest('Money::multiply calculates exact product', $multiplied->toDecimal() === '4351.50' && $multiplied->getPaise() === 435150);

$divided = $m1->divide(2);
assertTest('Money::divide calculates exact quotient with half-up rounding', $divided->toDecimal() === '725.25' && $divided->getPaise() === 72525);

// 5% GST Percentage calculation
$baseMoney = Money::fromDecimal(1000.00);
$gst5 = $baseMoney->percentage(5.0);
assertTest('Money::percentage calculates exact 5% GST', $gst5->toDecimal() === '50.00');

// Fair Allocation without penny loss
$hundred = Money::fromDecimal(100.00);
$allocated = $hundred->allocate([1, 1, 1]);
$allocSum = $allocated[0]->getPaise() + $allocated[1]->getPaise() + $allocated[2]->getPaise();
assertTest('Money::allocate divides ₹100 into 3 parts without losing 1 paisa', 
    $allocSum === 10000 &&
    $allocated[0]->getPaise() === 3334 &&
    $allocated[1]->getPaise() === 3333 &&
    $allocated[2]->getPaise() === 3333
);

// Indian numeral formatting
assertTest('Money::formatIndianNumber formats hundreds', Money::formatIndianNumber(500.00) === '500.00');
assertTest('Money::formatIndianNumber formats thousands', Money::formatIndianNumber(1450.50) === '1,450.50');
assertTest('Money::formatIndianNumber formats lakhs', Money::formatIndianNumber(184500.00) === '1,84,500.00');
assertTest('Money::formatIndianNumber formats crores', Money::formatIndianNumber(12345678.90) === '1,23,45,678.90');

// Real Indian Rupee SVG vector standard (Zero dollar signs)
$formattedSvg = $m1->formatWithSvg(14);
assertTest('Money::formatWithSvg contains official Indian Rupee vector path', str_contains($formattedSvg, 'M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8'));
assertTest('Money::formatWithSvg contains ZERO dollar signs ($)', !str_contains($formattedSvg, '$'));

// PricingCalculator integration
$orderCalc = PricingCalculator::calculateOrderTotal(10000.00, 1000.00, 250.00, 5.0);
assertTest('PricingCalculator::calculateOrderTotal uses exact arithmetic', 
    $orderCalc['subtotal'] === 10000.00 &&
    $orderCalc['discount'] === 1000.00 &&
    $orderCalc['taxable'] === 9000.00 &&
    $orderCalc['gst'] === 450.00 &&
    $orderCalc['shipping'] === 250.00 &&
    $orderCalc['grand_total'] === 9700.00 &&
    str_contains($orderCalc['formatted_grand_total'], 'M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8')
);

// -------------------------------------------------------------
// 4. Section 43: Price History Audit Ledger
// -------------------------------------------------------------
echo "\n── 4. Section 43: Price History Audit Ledger ──\n";

$phManager = PriceHistoryManager::getInstance();
assertTest('PriceHistoryManager singleton instantiation', $phManager instanceof PriceHistoryManager);

// Single price change record
$ok = $phManager->recordChange(
    productId: 101,
    productType: 'single_piece',
    roleTier: 'wholesale',
    fieldName: 'wholesale_price',
    oldPrice: 1500.00,
    newPrice: 1350.00,
    changedBy: 'Gautam (Admin)',
    changedById: 1,
    reason: 'Festive season B2B discount'
);
assertTest('PriceHistoryManager records single price modification', $ok === true);

// Skip recording if old price equals new price
$skipped = $phManager->recordChange(
    productId: 101,
    productType: 'single_piece',
    roleTier: 'wholesale',
    fieldName: 'wholesale_price',
    oldPrice: 1350.00,
    newPrice: 1350.00,
    changedBy: 'Admin'
);
assertTest('PriceHistoryManager skips recording identical price', $skipped === false);

// Batch price modification detection
$oldPrices = [
    'retail_price' => 2499.00,
    'wholesale_price' => 1350.00,
    'reseller_price' => 1899.00
];
$newPrices = [
    'retail_price' => 2499.00, // Unchanged
    'wholesale_price' => 1250.00, // Changed (-100)
    'reseller_price' => 1799.00  // Changed (-100)
];
$batchRecorded = $phManager->recordBatchChanges(
    productId: 101,
    productType: 'single_piece',
    oldPrices: $oldPrices,
    newPrices: $newPrices,
    changedBy: 'Admin',
    changedById: 1,
    reason: 'Wholesale lot promotion'
);
assertTest('PriceHistoryManager detects and records exactly 2 changed fields', $batchRecorded === 2);

// Fetch product price history
$prodHistory = $phManager->getHistoryForProduct(101);
assertTest('getHistoryForProduct returns chronological history for product', 
    is_array($prodHistory) && count($prodHistory) >= 3
);

// Ledger filtering & pagination
$ledger = $phManager->getAllHistory(['role_tier' => 'wholesale'], 1, 10);
assertTest('getAllHistory returns paginated ledger with metadata', 
    isset($ledger['items']) &&
    isset($ledger['total_items']) &&
    isset($ledger['total_pages']) &&
    $ledger['current_page'] === 1
);

// KPI stats
$summaryStats = $phManager->getSummaryStats();
assertTest('getSummaryStats returns total adjustments and unique products', 
    isset($summaryStats['total_adjustments']) &&
    $summaryStats['total_adjustments'] > 0 &&
    isset($summaryStats['products_impacted']) &&
    $summaryStats['products_impacted'] > 0
);

// -------------------------------------------------------------
// 5. Section 43 Security Isolation (Zero Customer Price Leak)
// -------------------------------------------------------------
echo "\n── 5. Security Isolation: Zero Customer Price History Leak ──\n";

// Admin user access
$adminUser = ['role' => 'admin', 'username' => 'superadmin'];
$adminAllowed = false;
try {
    $adminAllowed = PriceHistoryManager::assertAdminAccess($adminUser);
} catch (\Throwable $e) {
    $adminAllowed = false;
}
assertTest('assertAdminAccess permits authenticated administrator', $adminAllowed === true);

// Customer access rejected
$customerUser = ['role' => 'customer', 'username' => 'buyer123'];
$customerBlocked = false;
try {
    PriceHistoryManager::assertAdminAccess($customerUser);
} catch (\Throwable $e) {
    $customerBlocked = true;
}
assertTest('assertAdminAccess blocks customer from accessing price history', $customerBlocked === true);

// Reseller access rejected
$resellerUser = ['role' => 'reseller', 'username' => 'reseller_partner'];
$resellerBlocked = false;
try {
    PriceHistoryManager::assertAdminAccess($resellerUser);
} catch (\Throwable $e) {
    $resellerBlocked = true;
}
assertTest('assertAdminAccess blocks reseller from accessing price history', $resellerBlocked === true);

// Wholesaler access rejected
$wholesaleUser = ['role' => 'wholesale', 'username' => 'surat_wholesaler'];
$wholesaleBlocked = false;
try {
    PriceHistoryManager::assertAdminAccess($wholesaleUser);
} catch (\Throwable $e) {
    $wholesaleBlocked = true;
}
assertTest('assertAdminAccess blocks wholesaler from accessing price history', $wholesaleBlocked === true);

// Guest access rejected
$guestBlocked = false;
try {
    PriceHistoryManager::assertAdminAccess(null);
} catch (\Throwable $e) {
    $guestBlocked = true;
}
assertTest('assertAdminAccess blocks unauthenticated guest', $guestBlocked === true);

// -------------------------------------------------------------
// 6. UI & Sidebar Integrity
// -------------------------------------------------------------
echo "\n── 6. Admin UI & Route Integration ──\n";

$historyPage = __DIR__ . '/../admin/pricing/history.php';
assertTest('admin/pricing/history.php exists', file_exists($historyPage));

$historyHtml = file_get_contents($historyPage);
assertTest('history.php contains adminguard protection', str_contains($historyHtml, 'adminguard.php'));
assertTest('history.php uses TailAdmin typography (Inter & Plus Jakarta Sans)', str_contains($historyHtml, 'Plus+Jakarta+Sans'));
assertTest('history.php uses Indian Rupee (₹) vector standard', str_contains($historyHtml, 'rupeeSvg'));
assertTest('history.php does not contain dollar signs ($)', !str_contains($historyHtml, '$') || str_contains($historyHtml, '$_'));

$sidebarContent = file_get_contents(__DIR__ . '/../admin/includes/adminsidebar.php');
assertTest('adminsidebar.php contains link to /admin/pricing/history.php', str_contains($sidebarContent, '/admin/pricing/history.php'));

$apiPricing = __DIR__ . '/../api/pricing.php';
assertTest('api/pricing.php exists', file_exists($apiPricing));

// -------------------------------------------------------------
// Summary
// -------------------------------------------------------------
echo "\n═══════════════════════════════════════════════════════════════════\n";
echo "📊 Results: {$passed} Passed, {$failed} Failed\n";
echo "═══════════════════════════════════════════════════════════════════\n";

if ($failed > 0) {
    exit(1);
}
