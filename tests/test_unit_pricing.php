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

// ── Test 4: Role-Price Leakage Masking Matrix (Sections 12 & 32)
echo "\n[4] Testing Role-Price Leakage Masking Matrix...\n";

$rawProduct = [
    'id' => 201,
    'price' => 500,
    'retail_price' => 500,
    'customer_price' => 800,
    'customer_sale_price' => 750,
    'sale_price' => 50,
    'reseller_price' => 450,
    'wholesale_price' => 400,
    'full_set_retailer_price' => 480,
    'full_set_wholesale_price' => 420,
    'variants' => [
        [
            'id' => 1,
            'color' => 'Red',
            'size' => 'M',
            'price' => 500,
            'retail_price' => 500,
            'customer_price' => 800,
            'customer_sale_price' => 750,
            'reseller_price' => 450,
            'wholesale_price' => 400,
            'full_set_retailer_price' => 480,
            'full_set_wholesale_price' => 420
        ]
    ]
];

// Guest Masking
$guestMasked = $rawProduct;
ProductCatalog::maskRolePrices($guestMasked, 'guest');
assertEqual($guestMasked['wholesale_price'], null, 'Guest cannot see wholesale_price');
assertEqual($guestMasked['retail_price'], null, 'Guest cannot see retail_price');
assertEqual($guestMasked['reseller_price'], null, 'Guest cannot see reseller_price');
assertEqual($guestMasked['full_set_wholesale_price'], null, 'Guest cannot see full_set_wholesale_price');
assertEqual($guestMasked['variants'][0]['wholesale_price'], null, 'Guest cannot see variant wholesale_price');

// Customer Masking
$custMasked = $rawProduct;
ProductCatalog::maskRolePrices($custMasked, 'customer');
assertEqual($custMasked['wholesale_price'], null, 'Customer cannot see wholesale_price');
assertEqual($custMasked['reseller_price'], null, 'Customer cannot see reseller_price');

// Reseller Masking
$resellerMasked = $rawProduct;
ProductCatalog::maskRolePrices($resellerMasked, 'reseller');
assertEqual($resellerMasked['wholesale_price'], null, 'Reseller cannot see wholesale_price');
assertEqual($resellerMasked['customer_price'], null, 'Reseller cannot see customer_price');
assertEqual($resellerMasked['full_set_wholesale_price'], null, 'Reseller cannot see full_set_wholesale_price');

// Retailer Masking
$retailerMasked = $rawProduct;
ProductCatalog::maskRolePrices($retailerMasked, 'retailer');
assertEqual($retailerMasked['wholesale_price'], null, 'Retailer cannot see wholesale_price');
assertEqual($retailerMasked['reseller_price'], null, 'Retailer cannot see reseller_price');
assertEqual($retailerMasked['customer_price'], null, 'Retailer cannot see customer_price');

// Wholesaler Masking
$wholesaleMasked = $rawProduct;
ProductCatalog::maskRolePrices($wholesaleMasked, 'wholesale');
assertEqual($wholesaleMasked['customer_price'], null, 'Wholesaler cannot see customer_price');
assertEqual($wholesaleMasked['reseller_price'], null, 'Wholesaler cannot see reseller_price');
assertEqual($wholesaleMasked['full_set_retailer_price'], null, 'Wholesaler cannot see full_set_retailer_price');

// ── Test 5: Sections 39 & 40 Specification End-to-End Matrix
echo "\n[5] Testing Specification Sections 39 & 40 (Single Piece & Full Set Matrix)...\n";

$spec3Colours4Sizes = [
    'id' => 301,
    'selling_type' => 'single_piece',
    'retail_price' => 500,
    'customer_price' => 800,
    'customer_sale_price' => 750,
    'sale_price' => 50,
    'reseller_price' => 450,
    'wholesale_price' => 400,
    'colors' => ['Red', 'Mehrun', 'Rama'],
    'size' => ['S', 'M', 'L', 'XL'],
    'variants' => []
];

// Verify Section 39 MCQ: 3 colours x 4 sizes = 12
$sec39Mcq = ProductCatalog::calculateWholesalerMcq($spec3Colours4Sizes)['mcq'];
assertEqual($sec39Mcq, 12, 'Section 39: 3 colours x 4 sizes = MCQ 12');

// Single Piece Role Prices:
$spGuest = ProductCatalog::resolvePrice($spec3Colours4Sizes, 'guest');
assertEqual($spGuest, 750.0, 'Section 39 Guest: Customer Sale Price (750)');

$spCust = ProductCatalog::resolvePrice($spec3Colours4Sizes, 'customer');
assertEqual($spCust, 750.0, 'Section 39 Customer: Customer Sale Price (750)');

$spRetailer = ProductCatalog::resolvePrice($spec3Colours4Sizes, 'retailer');
assertEqual($spRetailer, 450.0, 'Section 39 Retailer: Retail Price - Sale Price (500 - 50 = 450)');

$spReseller = ProductCatalog::resolvePrice($spec3Colours4Sizes, 'reseller');
assertEqual($spReseller, 400.0, 'Section 39 Reseller: Reseller Price - Sale Price (450 - 50 = 400)');

$spWholesale = ProductCatalog::resolvePrice($spec3Colours4Sizes, 'wholesale');
assertEqual($spWholesale, 350.0, 'Section 39 Wholesaler: Wholesale Price - Sale Price (400 - 50 = 350)');

// Section 40: Full Set Access & Price
$specFullSet = [
    'id' => 302,
    'selling_type' => 'full_set',
    'retail_price' => 600,
    'wholesale_price' => 520,
    'sale_price' => 20,
    'full_set_retailer_price' => 600,
    'full_set_wholesale_price' => 520,
    'full_set_pieces' => 8,
    'colors' => ['Red', 'Mehrun', 'Rama'],
    'size' => ['S', 'M', 'L', 'XL']
];

$fsRetailer = ProductCatalog::getPriceDisplay($specFullSet, 'retailer');
assertEqual($fsRetailer['is_purchasable'], true, 'Section 40: Retailer can purchase full_set');
assertEqual($fsRetailer['effective_price'], 580.0, 'Section 40: Retailer price (600 - 20 = 580)');

$fsWholesale = ProductCatalog::getPriceDisplay($specFullSet, 'wholesale');
assertEqual($fsWholesale['is_purchasable'], true, 'Section 40: Wholesaler can purchase full_set');
assertEqual($fsWholesale['effective_price'], 500.0, 'Section 40: Wholesaler price (520 - 20 = 500)');

$fsGuest = ProductCatalog::getPriceDisplay($specFullSet, 'guest');
assertEqual($fsGuest['is_purchasable'], false, 'Section 40: Guest cannot purchase full_set');

$fsCust = ProductCatalog::getPriceDisplay($specFullSet, 'customer');
assertEqual($fsCust['is_purchasable'], false, 'Section 40: Customer cannot purchase full_set');

$fsReseller = ProductCatalog::getPriceDisplay($specFullSet, 'reseller');
assertEqual($fsReseller['is_purchasable'], false, 'Section 40: Reseller cannot purchase full_set');

echo "\n═══════════════════════════════════════════════════════════\n";
echo "RESULTS: $testsPassed Passed, $testsFailed Failed\n";
echo "═══════════════════════════════════════════════════════════\n";

if ($testsFailed > 0) {
    exit(1);
}

