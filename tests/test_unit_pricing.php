<?php
/**
 * Unit Test Suite for Role-based Pricing & Wholesaler MCQ
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/../src/ProductCatalog.php';
use DTBrand\ProductCatalog;

echo "═══════════════════════════════════════════════════════════\n";
echo "  UNIT PRICING & MCQ TEST SUITE\n";
echo "  DT Brand's & Jai Hanuman Tex\n";
echo "═══════════════════════════════════════════════════════════\n\n";

$testsPassed = 0;
$testsFailed = 0;

function assertEqual($actual, $expected, $desc) {
    global $testsPassed, $testsFailed;
    if ($actual === $expected) {
        echo "  ✅ PASS: $desc (got: " . json_encode($actual) . ")\n";
        $testsPassed++;
    } else {
        echo "  ❌ FAIL: $desc (expected: " . json_encode($expected) . ", got: " . json_encode($actual) . ")\n";
        $testsFailed++;
    }
}

// ── Test 1: Single Piece Product Price Resolution Matrix
echo "[1] Testing Single Piece Product Price Resolution Matrix...\n";

$singleProduct = [
    'id' => 101,
    'selling_type' => 'single_piece',
    'retail_price' => 500,
    'price' => 500,
    'customer_price' => 800,
    'customer_sale_price' => 750,
    'sale_price' => 50,
    'reseller_price' => 450,
    'wholesale_price' => 400,
    'colors' => ['Red', 'Green', 'Blue', 'Yellow'],
    'size' => ['M', 'L'],
    'variants' => []
];

// Guest: should use customer_sale_price (750)
$guestPrice = ProductCatalog::getPriceDisplay($singleProduct, 'guest');
assertEqual($guestPrice['effective_price'], 750.0, 'Guest effective_price equals customer_sale_price');
assertEqual($guestPrice['base_price'], 800.0, 'Guest base_price equals customer_price');
assertEqual($guestPrice['show_sale'], true, 'Guest show_sale is true');
assertEqual($guestPrice['is_purchasable'], true, 'Guest is purchasable for single piece');

// Customer: same as guest
$custPrice = ProductCatalog::getPriceDisplay($singleProduct, 'customer');
assertEqual($custPrice['effective_price'], 750.0, 'Customer effective_price equals customer_sale_price');
assertEqual($custPrice['base_price'], 800.0, 'Customer base_price equals customer_price');

// Retailer: retail_price (500) - sale_price (50) = 450
$retailerPrice = ProductCatalog::getPriceDisplay($singleProduct, 'retailer');
assertEqual($retailerPrice['effective_price'], 450.0, 'Retailer effective_price (500 - 50 = 450)');
assertEqual($retailerPrice['base_price'], 500.0, 'Retailer base_price');

// Reseller: reseller_price (450) - sale_price (50) = 400
$resellerPrice = ProductCatalog::getPriceDisplay($singleProduct, 'reseller');
assertEqual($resellerPrice['effective_price'], 400.0, 'Reseller effective_price (450 - 50 = 400)');
assertEqual($resellerPrice['base_price'], 450.0, 'Reseller base_price');

// Wholesaler: wholesale_price (400) - sale_price (50) = 350
$wholesalePrice = ProductCatalog::getPriceDisplay($singleProduct, 'wholesale');
assertEqual($wholesalePrice['effective_price'], 350.0, 'Wholesaler effective_price (400 - 50 = 350)');
assertEqual($wholesalePrice['base_price'], 400.0, 'Wholesaler base_price');

// Unified B2B Trade Price (Master Spec Sections 7 & 8: wholesale_price & reseller_price omitted/null)
$unifiedProduct = [
    'id' => 103,
    'selling_type' => 'single_piece',
    'retail_price' => 500,
    'customer_price' => 800,
    'customer_sale_price' => 750,
    'sale_price' => 50,
    'colors' => ['Red', 'Green'],
    'size' => ['M', 'L'],
    'variants' => []
];
$uRetailer = ProductCatalog::getPriceDisplay($unifiedProduct, 'retailer');
$uReseller = ProductCatalog::getPriceDisplay($unifiedProduct, 'reseller');
$uWholesale = ProductCatalog::getPriceDisplay($unifiedProduct, 'wholesale');
assertEqual($uRetailer['effective_price'], 450.0, 'Unified Retailer effective_price (500 - 50 = 450)');
assertEqual($uReseller['effective_price'], 450.0, 'Unified Reseller effective_price defaults to retail_price (500 - 50 = 450)');
assertEqual($uWholesale['effective_price'], 450.0, 'Unified Wholesaler effective_price defaults to retail_price (500 - 50 = 450)');
assertEqual(ProductCatalog::resolvePrice($unifiedProduct, 'reseller'), 450.0, 'ProductCatalog::resolvePrice reseller defaults to retail_price');
assertEqual(ProductCatalog::resolvePrice($unifiedProduct, 'wholesale'), 450.0, 'ProductCatalog::resolvePrice wholesaler defaults to retail_price');

// ── Test 2: Full Set Product Access Barrier Matrix
echo "\n[2] Testing Full Set Product Access Barrier Matrix...\n";

$fullSetProduct = [
    'id' => 102,
    'selling_type' => 'full_set',
    'retail_price' => 400,
    'price' => 400,
    'wholesale_price' => 350,
    'full_set_retailer_price' => 400,
    'full_set_wholesale_price' => 350,
    'full_set_pieces' => 8,
    'colors' => ['Red', 'Green', 'Blue', 'Yellow'],
    'size' => ['M', 'L']
];

// Guest: NOT purchasable
$fsGuest = ProductCatalog::getPriceDisplay($fullSetProduct, 'guest');
assertEqual($fsGuest['is_purchasable'], false, 'Guest cannot purchase full_set');

// Customer: NOT purchasable
$fsCust = ProductCatalog::getPriceDisplay($fullSetProduct, 'customer');
assertEqual($fsCust['is_purchasable'], false, 'Customer cannot purchase full_set');

// Reseller: NOT purchasable
$fsReseller = ProductCatalog::getPriceDisplay($fullSetProduct, 'reseller');
assertEqual($fsReseller['is_purchasable'], false, 'Reseller cannot purchase full_set');

// Retailer: Purchasable at retail price
$fsRetailer = ProductCatalog::getPriceDisplay($fullSetProduct, 'retailer');
assertEqual($fsRetailer['is_purchasable'], true, 'Retailer can purchase full_set');
assertEqual($fsRetailer['effective_price'], 400.0, 'Retailer full_set price');

// Wholesaler: Purchasable at wholesale price
$fsWholesale = ProductCatalog::getPriceDisplay($fullSetProduct, 'wholesale');
assertEqual($fsWholesale['is_purchasable'], true, 'Wholesaler can purchase full_set');
assertEqual($fsWholesale['effective_price'], 350.0, 'Wholesaler full_set price');

// ── Test 3: Wholesaler MCQ Calculation
echo "\n[3] Testing Wholesaler MCQ Calculation...\n";

$mcq4Colors2Sizes = ProductCatalog::calculateWholesalerMcq([
    'colors' => 'Red, Green, Blue, Yellow',
    'size' => 'M, L',
    'variants' => []
])['mcq'];
assertEqual($mcq4Colors2Sizes, 8, '4 colors x 2 sizes = MCQ 8');

$mcq4ColorsFreeSize = ProductCatalog::calculateWholesalerMcq([
    'colors' => 'Red, Green, Blue, Yellow',
    'size' => 'Free Size',
    'variants' => []
])['mcq'];
assertEqual($mcq4ColorsFreeSize, 4, '4 colors x 1 Free Size = MCQ 4');

$mcqVariantList = ProductCatalog::calculateWholesalerMcq([
    'variants' => [
        ['color' => 'Red', 'size' => 'M'],
        ['color' => 'Red', 'size' => 'L'],
        ['color' => 'Blue', 'size' => 'M'],
        ['color' => 'Blue', 'size' => 'L'],
        ['color' => 'Green', 'size' => 'M'],
        ['color' => 'Green', 'size' => 'L']
    ]
])['mcq'];
assertEqual($mcqVariantList, 6, 'Variant list with 3 colors x 2 sizes = MCQ 6');

echo "\n═══════════════════════════════════════════════════════════\n";
echo "RESULTS: $testsPassed Passed, $testsFailed Failed\n";
echo "═══════════════════════════════════════════════════════════\n";

if ($testsFailed > 0) {
    exit(1);
}
