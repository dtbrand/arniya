<?php
ob_start();
/**
 * test_admin_suite_comprehensive.php — Autonomous End-to-End Test Suite for Admin Console
 * DT Brand's & Jai Hanuman Tex
 */

$_SERVER['DOCUMENT_ROOT'] = dirname(__DIR__);
$_SERVER['REQUEST_URI'] = '/admin';

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/../src/CustomerManager.php';
require_once __DIR__ . '/../src/OrderManager.php';
require_once __DIR__ . '/../src/ReviewManager.php';
require_once __DIR__ . '/../src/DiscountEngine.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;
use DTBrand\CustomerManager;
use DTBrand\OrderManager;
use DTBrand\ReviewManager;
use DTBrand\DiscountEngine;

$passed = 0;
$failed = 0;
$errors = [];

function assertTest($name, $condition, $failMsg = '') {
    global $passed, $failed, $errors;
    if ($condition) {
        $passed++;
        echo "  [PASS] {$name}\n";
    } else {
        $failed++;
        $errors[] = "{$name}: {$failMsg}";
        echo "  [FAIL] {$name} - {$failMsg}\n";
    }
}

echo "================================================================================\n";
echo "1. ADMIN SIDEBAR NAVIGATION & ROUTE RESOLUTION TEST\n";
echo "================================================================================\n";

$sidebarFile = __DIR__ . '/../admin/includes/adminsidebar.php';
assertTest("Sidebar file exists", file_exists($sidebarFile), "adminsidebar.php missing");

$sidebarContent = file_get_contents($sidebarFile);
preg_match_all('/href=["\']([^"\']+)["\']/', $sidebarContent, $matches);
$hrefs = array_unique($matches[1] ?? []);

$testedLinks = 0;
$brokenLinks = [];

foreach ($hrefs as $h) {
    $hClean = trim($h);
    if (!$hClean || strpos($hClean, '#') === 0 || strpos($hClean, 'javascript:') === 0) continue;
    
    $cleanPath = explode('?', $hClean)[0];
    if (strpos($cleanPath, '/admin/') === 0) {
        $rel = 'admin/' . substr($cleanPath, 7);
    } elseif (strpos($cleanPath, 'admin/') === 0) {
        $rel = $cleanPath;
    } elseif (strpos($cleanPath, '/') === 0) {
        $rel = ltrim($cleanPath, '/');
    } else {
        $rel = 'admin/' . $cleanPath;
    }

    $fullPath = __DIR__ . '/../' . $rel;
    $exists = false;
    if (is_file($fullPath)) {
        $exists = true;
    } elseif (is_dir($fullPath) && is_file($fullPath . '/index.php')) {
        $exists = true;
    } elseif (is_file($fullPath . '.php')) {
        $exists = true;
    } elseif (is_file($fullPath . '/index.php')) {
        $exists = true;
    }

    if ($exists) {
        $testedLinks++;
    } else {
        $brokenLinks[] = "{$hClean} -> {$rel}";
    }
}

assertTest("All extracted sidebar links resolve to physical files ({$testedLinks} valid)", count($brokenLinks) === 0, implode(", ", $brokenLinks));

// Verify specific required submenus exist in sidebar
assertTest("WhatsApp CRM has Live Concierge & Chat submenu", strpos($sidebarContent, 'Live Concierge &amp; Chat') !== false || strpos($sidebarContent, 'Live Concierge & Chat') !== false);
assertTest("WhatsApp CRM has Broadcast Studio submenu", strpos($sidebarContent, 'Broadcast Studio') !== false);
assertTest("WhatsApp CRM has Lead Pipeline submenu", strpos($sidebarContent, 'Lead Pipeline') !== false);
assertTest("WhatsApp CRM has Message Templates submenu", strpos($sidebarContent, 'Message Templates') !== false);

assertTest("Store Settings has General Profile submenu", strpos($sidebarContent, 'Store Profile &amp; General') !== false || strpos($sidebarContent, 'Store Profile & General') !== false);
assertTest("Store Settings has Company Profile submenu", strpos($sidebarContent, 'Company &amp; Legal Profile') !== false || strpos($sidebarContent, 'Company & Legal Profile') !== false);
assertTest("Store Settings has Payment Gateways submenu", strpos($sidebarContent, 'Payment Gateways Setup') !== false);
assertTest("Store Settings has Shipping Setup submenu", strpos($sidebarContent, 'Shipping Logistics Setup') !== false || strpos($sidebarContent, 'Shipping &amp; Logistics Setup') !== false || strpos($sidebarContent, 'Shipping & Logistics Setup') !== false);

assertTest("Reports has GST & GSTR-1 Ledger submenu", strpos($sidebarContent, 'GST &amp; GSTR-1 Ledger') !== false || strpos($sidebarContent, 'GST & GSTR-1 Ledger') !== false);
assertTest("Users has Audit & Activity Logs submenu", strpos($sidebarContent, 'Audit &amp; Activity Logs') !== false || strpos($sidebarContent, 'Audit & Activity Logs') !== false);
assertTest("CMS Pages has Homepage CMS submenu", strpos($sidebarContent, 'Homepage CMS') !== false);

echo "\n================================================================================\n";
echo "2. CORE BUSINESS ENGINE & DATA MANAGERS TEST\n";
echo "================================================================================\n";

// In local CLI test environment where remote Hostinger MySQL 3306 is not bound locally,
// establish an in-memory SQLite test fixture for full CRUD and business logic verification.
$activePdo = Database::getConnection();
if ($activePdo === null || Database::isMockMode()) {
    $sqlite = new \PDO('sqlite::memory:');
    $sqlite->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $sqlite->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    if (method_exists($sqlite, 'sqliteCreateFunction')) {
        $sqlite->sqliteCreateFunction('NOW', function() { return date('Y-m-d H:i:s'); });
    }

    $sqlite->exec("
        CREATE TABLE IF NOT EXISTS categories (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT,
            slug TEXT,
            description TEXT,
            image TEXT,
            banner_image TEXT,
            display_order INTEGER DEFAULT 0,
            status TEXT DEFAULT 'active'
        );
        CREATE TABLE IF NOT EXISTS products (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT,
            sku TEXT,
            category TEXT,
            category_id INTEGER DEFAULT 1,
            category_name TEXT DEFAULT 'Paithani',
            sub_category TEXT,
            mrp REAL,
            price REAL,
            retail_price REAL,
            wholesale_price REAL,
            reseller_price REAL,
            customer_price REAL,
            stock_qty INTEGER DEFAULT 100,
            status TEXT DEFAULT 'in_stock',
            primary_image TEXT,
            created_at TEXT
        );
        CREATE TABLE IF NOT EXISTS product_variants (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            product_id INTEGER,
            sku TEXT,
            color_name TEXT,
            size_name TEXT,
            stock_qty INTEGER DEFAULT 50,
            price REAL,
            retail_price REAL,
            wholesale_price REAL,
            reseller_price REAL,
            selling_type TEXT DEFAULT 'single_piece',
            image TEXT
        );
        CREATE TABLE IF NOT EXISTS product_media (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            product_id INTEGER,
            image_url TEXT,
            is_primary INTEGER DEFAULT 0,
            sort_order INTEGER DEFAULT 0
        );
        CREATE TABLE IF NOT EXISTS customers (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT,
            phone TEXT UNIQUE,
            email TEXT,
            password TEXT,
            password_hash TEXT,
            type TEXT DEFAULT 'customer',
            tier TEXT,
            city TEXT,
            state TEXT,
            gstin TEXT,
            pan TEXT,
            credit_limit REAL DEFAULT 0,
            outstanding_balance REAL DEFAULT 0,
            total_orders INTEGER DEFAULT 0,
            lifetime_spend REAL DEFAULT 0,
            commission_rate REAL DEFAULT 0,
            status TEXT DEFAULT 'active',
            created_at TEXT
        );
        CREATE TABLE IF NOT EXISTS addresses (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            customer_id INTEGER,
            recipient_name TEXT,
            phone TEXT,
            address_line1 TEXT,
            address_line2 TEXT,
            city TEXT,
            state TEXT,
            pincode TEXT,
            address_type TEXT,
            is_default INTEGER DEFAULT 1,
            created_at TEXT
        );
        CREATE TABLE IF NOT EXISTS orders (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_number TEXT UNIQUE,
            customer_id INTEGER,
            customer_name TEXT,
            customer_phone TEXT,
            customer_email TEXT,
            channel TEXT DEFAULT 'retail',
            shipping_address TEXT,
            subtotal REAL DEFAULT 0,
            discount REAL DEFAULT 0,
            gst_rate REAL DEFAULT 5,
            gst_amount REAL DEFAULT 0,
            shipping_fee REAL DEFAULT 0,
            total_amount REAL,
            payment_method TEXT,
            payment_status TEXT,
            fulfillment_status TEXT,
            courier_name TEXT,
            tracking_number TEXT,
            notes TEXT,
            idempotency_key TEXT,
            stock_decremented INTEGER DEFAULT 0,
            created_at TEXT,
            updated_at TEXT
        );
        CREATE TABLE IF NOT EXISTS order_items (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_id INTEGER,
            product_id INTEGER,
            variant_id INTEGER DEFAULT 0,
            product_title TEXT,
            sku TEXT,
            selling_type TEXT DEFAULT 'single_piece',
            variant_color TEXT,
            variant_size TEXT,
            quantity INTEGER,
            unit_price REAL,
            subtotal REAL,
            total_price REAL
        );
        CREATE TABLE IF NOT EXISTS order_status_history (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_id INTEGER,
            status TEXT,
            notes TEXT,
            created_at TEXT
        );
        CREATE TABLE IF NOT EXISTS payment_transactions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            order_id INTEGER,
            order_number TEXT,
            transaction_id TEXT,
            amount REAL,
            status TEXT,
            created_at TEXT
        );
        CREATE TABLE IF NOT EXISTS reviews (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            product_id INTEGER,
            customer_id INTEGER DEFAULT 1,
            customer_name TEXT,
            rating REAL,
            review_title TEXT,
            review_text TEXT,
            store_reply TEXT,
            status TEXT DEFAULT 'approved',
            verified_buyer INTEGER DEFAULT 1,
            created_at TEXT
        );
        CREATE TABLE IF NOT EXISTS review_audit_logs (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            review_id INTEGER,
            action TEXT,
            moderator_name TEXT,
            reason TEXT,
            previous_status TEXT,
            new_status TEXT,
            created_at TEXT
        );
        CREATE TABLE IF NOT EXISTS coupons (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            code TEXT UNIQUE,
            title TEXT,
            description TEXT,
            discount_type TEXT,
            discount_value REAL,
            max_discount REAL,
            min_order_value REAL,
            starts_at TEXT,
            expires_at TEXT,
            total_usage_limit INTEGER,
            used_count INTEGER DEFAULT 0,
            times_used INTEGER DEFAULT 0,
            channel TEXT DEFAULT 'all',
            status TEXT DEFAULT 'active',
            created_at TEXT
        );
        CREATE TABLE IF NOT EXISTS settings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            key_name TEXT UNIQUE,
            value TEXT,
            updated_at TEXT
        );
    ");

    $sqlite->exec("
        INSERT INTO categories (name, slug, status)
        VALUES ('Paithani', 'paithani', 'active'), ('Kanjivaram', 'kanjivaram', 'active'), ('Banarasi', 'banarasi', 'active');

        INSERT INTO products (title, sku, category, category_id, category_name, mrp, price, retail_price, wholesale_price, reseller_price, customer_price, stock_qty, status, primary_image, created_at)
        VALUES ('Virasat Paithani Silk Saree', 'PAITHANI-001', 'Paithani', 1, 'Paithani', 4999.00, 2499.00, 2499.00, 1850.00, 2100.00, 2499.00, 50, 'in_stock', '/assets/images/paithani-1.jpg', datetime('now'));
        
        INSERT INTO product_variants (product_id, sku, color_name, size_name, stock_qty, price, retail_price, wholesale_price, reseller_price, selling_type)
        VALUES (1, 'PAITHANI-001-RED', 'Royal Red', 'Free Size', 50, 2499.00, 2499.00, 1850.00, 2100.00, 'single_piece');

        INSERT INTO customers (name, phone, email, password_hash, type, tier, city, state, status, created_at)
        VALUES ('Rajesh Wholesalers', '+91 98250 12345', 'rajesh@example.com', 'test_hash', 'wholesale', 'Diamond Elite', 'Surat', 'Gujarat', 'active', datetime('now'));

        INSERT INTO orders (order_number, customer_id, customer_name, customer_phone, total_amount, payment_method, payment_status, fulfillment_status, created_at)
        VALUES ('DTB-000101', 1, 'Rajesh Wholesalers', '+91 98250 12345', 18500.00, 'Direct UPI', 'paid', 'processing', datetime('now'));

        INSERT INTO order_items (order_id, product_id, product_title, sku, quantity, unit_price, subtotal)
        VALUES (1, 1, 'Virasat Paithani Silk Saree', 'PAITHANI-001-RED', 10, 1850.00, 18500.00);

        INSERT INTO reviews (product_id, customer_name, rating, review_title, review_text, status, verified_buyer, created_at)
        VALUES (1, 'Pooja Sharma', 5.0, 'Luxury Weave', 'Outstanding authentic weave! Pure luxury.', 'approved', 1, datetime('now'));

        INSERT INTO coupons (code, title, discount_type, discount_value, min_order_value, status, created_at)
        VALUES ('FESTIVE500', 'Festive Offer ₹500 OFF', 'flat', 500.00, 2999.00, 'active', datetime('now'));
    ");

    Database::setPdo($sqlite, false);
    ProductCatalog::invalidateCache();
}

$products = ProductCatalog::getAll(true);
assertTest("ProductCatalog::getAll returns products", is_array($products) && count($products) > 0, "Count: " . count($products));

$categories = ProductCatalog::getCategories();
assertTest("ProductCatalog::getCategories returns categories", is_array($categories) && count($categories) > 0, "Count: " . count($categories));

$customers = CustomerManager::getAll();
assertTest("CustomerManager::getAll returns customers", is_array($customers) && count($customers) > 0, "Count: " . count($customers));

$orders = OrderManager::getAll();
assertTest("OrderManager::getAll returns orders", is_array($orders) && count($orders) > 0, "Count: " . count($orders));

$reviews = ReviewManager::getReviews(['limit' => 10]);
assertTest("ReviewManager::getReviews returns reviews", is_array($reviews) && count($reviews) > 0, "Count: " . count($reviews));

$reviewStats = ReviewManager::getReviewStats();
assertTest("ReviewManager::getReviewStats returns valid stats", isset($reviewStats['total']) && isset($reviewStats['avg_rating']));

$discounts = DiscountEngine::getAllCoupons();
assertTest("DiscountEngine::getAllCoupons returns coupon definitions", is_array($discounts) && count($discounts) > 0);

echo "\n================================================================================\n";
echo "3. CUSTOMER CRUD & DELETE LOGIC TEST\n";
echo "================================================================================\n";

// Test CustomerManager create and delete cycle
$testCustomerData = [
    'name' => 'Agent Autonomous Test Customer',
    'phone' => '+91 98980 00099',
    'email' => 'agent.test.' . time() . '@jaihanumantex.in',
    'type' => 'retail',
    'city' => 'Surat',
    'state' => 'Gujarat',
    'status' => 'active'
];

$createRes = CustomerManager::create($testCustomerData);
assertTest("CustomerManager::create succeeds", isset($createRes['success']) && $createRes['success'] === true, json_encode($createRes));

$newCustId = (int)($createRes['id'] ?? 0);
if ($newCustId > 0) {
    $found = CustomerManager::get($newCustId);
    assertTest("CustomerManager::get finds newly created customer", $found !== null && $found['name'] === $testCustomerData['name']);

    $statusUpdateOk = CustomerManager::updateStatus($newCustId, 'suspended');
    assertTest("CustomerManager::updateStatus suspends customer", $statusUpdateOk === true);

    $deleteOk = CustomerManager::delete($newCustId);
    assertTest("CustomerManager::delete permanently removes customer", $deleteOk === true);
} else {
    assertTest("Customer creation returned valid ID", false, "ID was " . $newCustId);
}

echo "\n================================================================================\n";
echo "4. SETTINGS ENGINE & KEY_NAME DATABASE ALIGNMENT TEST\n";
echo "================================================================================\n";

$settingsFile = __DIR__ . '/../admin/settings/index.php';
$settingsContent = file_get_contents($settingsFile);
assertTest("admin/settings/index.php uses key_name", strpos($settingsContent, 'key_name') !== false);
assertTest("admin/settings/index.php does not reference non-existent column group_name", strpos($settingsContent, "'general', NOW()") === false);

echo "\n================================================================================\n";
echo "5. ORDER CRUD, STATUS & BULK OPERATIONS TEST\n";
echo "================================================================================\n";

// 1. Create a test order
$testOrderData = [
    'customer_name' => 'Agent Test Wholesale Partner',
    'customer_phone' => '+91 91704 63528',
    'customer_email' => 'agent.order.' . time() . '@jaihanumantex.in',
    'channel' => 'retail',
    'shipping_address' => 'Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002',
    'payment_method' => 'direct_upi',
    'payment_status' => 'pending',
    'fulfillment_status' => 'processing',
    'items' => [
        [
            'product_id' => 1,
            'quantity' => 2
        ]
    ]
];

$orderRes = OrderManager::createOrder($testOrderData);
assertTest("OrderManager::createOrder succeeds", isset($orderRes['success']) && $orderRes['success'] === true, json_encode($orderRes));

$testOrderId = (int)($orderRes['id'] ?? 0);
$testOrderNumber = (string)($orderRes['order_number'] ?? '');

if ($testOrderId > 0) {
    // 2. Details lookup
    $details = OrderManager::getOrderDetails($testOrderId);
    assertTest("OrderManager::getOrderDetails fetches full order details", $details !== null && ($details['order_number'] ?? '') === $testOrderNumber);

    // 3. Update Status
    $statusOk = OrderManager::updateStatus($testOrderId, 'shipped', 'AWB-TEST-9901', 'Delhivery Express');
    assertTest("OrderManager::updateStatus updates tracking and fulfillment", $statusOk === true);

    // 4. Bulk Update Status
    $bulkUpdRes = OrderManager::bulkUpdateStatus([$testOrderId], 'delivered');
    assertTest("OrderManager::bulkUpdateStatus updates order to delivered", isset($bulkUpdRes['success']) && $bulkUpdRes['success'] === true && ($bulkUpdRes['updated_count'] ?? 0) >= 1);

    // 5. Delete Order
    $deleteOrderOk = OrderManager::deleteOrder($testOrderId);
    assertTest("OrderManager::deleteOrder permanently removes order", $deleteOrderOk === true);

    // 6. Verify it is gone
    $checkDeleted = OrderManager::getOrderDetails($testOrderId);
    assertTest("Deleted order no longer found in database", $checkDeleted === null);
} else {
    assertTest("Order creation returned valid ID", false, "ID was " . $testOrderId);
}

// ============================================================================
// 6. B2B PRICING CALCULATOR & COUPON ENGINE VALIDATION TEST
// ============================================================================
echo "\n================================================================================\n";
echo "6. B2B PRICING CALCULATOR & COUPON ENGINE VALIDATION TEST\n";
echo "================================================================================\n";

require_once __DIR__ . '/../src/PricingCalculator.php';
use DTBrand\PricingCalculator;

// 1. Coupon validation for FESTIVE25
$couponRes = DiscountEngine::validateCoupon('FESTIVE25', 2500.00);
assertTest("DiscountEngine::validateCoupon validates FESTIVE25", isset($couponRes['valid']) && $couponRes['valid'] === true, json_encode($couponRes));
assertTest("FESTIVE25 applies 25% discount (₹625.00 on ₹2500.00)", (float)($couponRes['discount'] ?? 0) === 625.0);

// 2. Pricing calculation with GST and discount
$calcRes = PricingCalculator::calculateOrderTotal(2500.00, (float)($couponRes['discount'] ?? 0), 100.00, 5.0);
assertTest("PricingCalculator computes taxable amount correctly (₹1875.00)", (float)($calcRes['taxable'] ?? 0) === 1875.0);
assertTest("PricingCalculator computes 5% GST correctly (₹93.75)", (float)($calcRes['gst_amount'] ?? 0) === 93.75);
assertTest("PricingCalculator computes grand total correctly (₹2068.75)", (float)($calcRes['grand_total'] ?? 0) === 2068.75);
assertTest("PricingCalculator outputs real SVG Rupee symbol in formatted total", strpos($calcRes['formatted_grand_total'] ?? '', '<svg') !== false);

// 3. Wholesale tier pricing
$wsTierPrice = PricingCalculator::calculateWholesalePrice(1000.00, 15.0);
assertTest("PricingCalculator calculates wholesale tier price (15% off ₹1000 = ₹850)", $wsTierPrice === 850.0);

// ============================================================================
// 7. REVIEW MODERATION & INSPECTION ENGINE VALIDATION TEST
// ============================================================================
echo "\n================================================================================\n";
echo "7. REVIEW MODERATION & INSPECTION ENGINE VALIDATION TEST\n";
echo "================================================================================\n";

$revStats = ReviewManager::getReviewStats();
assertTest("ReviewManager::getReviewStats returns total count", isset($revStats['total_reviews']) && is_numeric($revStats['total_reviews']));
assertTest("ReviewManager::getReviewStats returns average rating", isset($revStats['average_rating']) && is_numeric($revStats['average_rating']));

$approvedReviews = ReviewManager::getReviews(['status' => 'approved', 'limit' => 10]);
assertTest("ReviewManager::getReviews retrieves approved reviews list", is_array($approvedReviews));

$auditLogs = ReviewManager::getAuditLogs(10);
assertTest("ReviewManager::getAuditLogs retrieves moderation audit trail", is_array($auditLogs));


echo "\n================================================================================\n";
echo "SUMMARY: {$passed} PASSED, {$failed} FAILED\n";
echo "================================================================================\n";

if ($failed > 0) {
    echo "Failed tests detail:\n";
    foreach ($errors as $e) {
        echo "  - {$e}\n";
    }
    exit(1);
} else {
    echo "ALL TESTS PASSED SUCCESSFULLY! (100% SUITE PASS)\n";
    exit(0);
}

