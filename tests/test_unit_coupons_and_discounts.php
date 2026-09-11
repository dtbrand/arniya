<?php
/**
 * test_unit_coupons_and_discounts.php
 * Automated Unit Test Suite for Section 26 (Coupons, Discounts, Channel Isolation & Redemptions)
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/DiscountEngine.php';

use DTBrand\Database;
use DTBrand\DiscountEngine;

$passed = 0;
$failed = 0;

function assertCondition(bool $cond, string $msg): void {
    global $passed, $failed;
    if ($cond) {
        echo "  [PASS] {$msg}\n";
        $passed++;
    } else {
        echo "  [FAIL] {$msg}\n";
        $failed++;
    }
}

echo "=== DT BRAND'S SECTION 26: COUPONS & DISCOUNTS UNIT TESTS ===\n";

// 1. Setup SQLite in-memory database with Section 26 schema
$sqlite = new \PDO('sqlite::memory:');
$sqlite->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

$sqlite->exec("
CREATE TABLE coupons (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    code TEXT NOT NULL UNIQUE,
    title TEXT DEFAULT '',
    discount_type TEXT NOT NULL,
    discount_value REAL NOT NULL,
    min_order_value REAL DEFAULT 0,
    min_order_amount REAL DEFAULT 0,
    max_discount REAL DEFAULT 0,
    usage_limit INTEGER DEFAULT 1000,
    used_count INTEGER DEFAULT 0,
    times_used INTEGER DEFAULT 0,
    per_user_limit INTEGER DEFAULT 1,
    channel TEXT DEFAULT 'all',
    status TEXT DEFAULT 'active',
    starts_at TEXT DEFAULT NULL,
    expires_at TEXT DEFAULT NULL,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE coupon_usages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    coupon_id INTEGER NULL,
    coupon_code TEXT NOT NULL,
    order_id INTEGER NULL,
    order_number TEXT NULL,
    customer_id INTEGER NULL,
    customer_phone TEXT NULL,
    customer_name TEXT NULL,
    order_subtotal REAL DEFAULT 0,
    discount_amount REAL DEFAULT 0,
    channel TEXT DEFAULT 'customer',
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE coupon_audit_logs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    coupon_id INTEGER NULL,
    coupon_code TEXT NOT NULL,
    action TEXT NOT NULL,
    actor TEXT DEFAULT 'Admin',
    ip_address TEXT NULL,
    details TEXT NULL,
    created_at TEXT DEFAULT CURRENT_TIMESTAMP
);
");

// Seed test coupons
$now = date('Y-m-d H:i:s');
$yesterday = date('Y-m-d H:i:s', strtotime('-1 day'));
$tomorrow = date('Y-m-d H:i:s', strtotime('+1 day'));
$lastMonth = date('Y-m-d H:i:s', strtotime('-30 days'));
$nextMonth = date('Y-m-d H:i:s', strtotime('+30 days'));

$sqlite->exec("
INSERT INTO coupons (code, title, discount_type, discount_value, min_order_value, max_discount, usage_limit, used_count, channel, status, starts_at, expires_at)
VALUES 
('UNIVERSAL10', 'Universal 10%', 'percentage', 10, 1000, 500, 100, 5, 'all', 'active', '{$yesterday}', '{$nextMonth}'),
('WHOLESALE500', 'Wholesale Depot Flat', 'flat', 500, 10000, 500, 50, 10, 'wholesaler', 'active', '{$yesterday}', '{$nextMonth}'),
('RESELLER15', 'Reseller VIP Tier', 'percentage', 15, 2000, 1000, 50, 5, 'reseller', 'active', '{$yesterday}', '{$nextMonth}'),
('EXHAUSTED', 'Usage Limit Reached', 'percentage', 20, 500, 0, 10, 10, 'all', 'active', '{$yesterday}', '{$nextMonth}'),
('FUTURECOUPON', 'Upcoming Festival', 'percentage', 30, 500, 0, 100, 0, 'all', 'active', '{$tomorrow}', '{$nextMonth}'),
('PASTEXPIRED', 'Old Expired Promo', 'percentage', 25, 500, 0, 100, 20, 'all', 'active', '{$lastMonth}', '{$yesterday}');
");

Database::setPdo($sqlite, false);

// Test 1: Normal Universal Coupon
$res1 = DiscountEngine::applyCoupon('UNIVERSAL10', 3000.0, null, 'customer');
assertCondition($res1['valid'] === true, "Universal coupon valid for customer role");
assertCondition($res1['discount'] == 300.0, "10% of 3000 = 300 discount");

// Test 2: Percentage Max Cap Enforcement
$res2 = DiscountEngine::applyCoupon('UNIVERSAL10', 10000.0, null, 'customer');
assertCondition($res2['valid'] === true, "Coupon valid for 10000 cart");
assertCondition($res2['discount'] == 500.0, "Discount capped at max_discount 500 (10% of 10000 is 1000, capped to 500)");

// Test 3: Below Minimum Order Spend
$res3 = DiscountEngine::applyCoupon('UNIVERSAL10', 800.0, null, 'customer');
assertCondition($res3['valid'] === false, "Order below minimum (800 < 1000) rejected");
assertCondition(strpos(strtolower($res3['message']), 'minimum order') !== false, "Rejection message explains minimum spend requirement");

// Test 4: Channel / Role Isolation
// Reseller trying to use Wholesale coupon
$res4 = DiscountEngine::applyCoupon('WHOLESALE500', 15000.0, null, 'reseller');
assertCondition($res4['valid'] === false, "Wholesale coupon rejected for Reseller role");
assertCondition(strpos(strtolower($res4['message']), 'wholesaler') !== false, "Error message states coupon is reserved for Wholesaler partners");

// Wholesaler using Wholesale coupon
$res5 = DiscountEngine::applyCoupon('WHOLESALE500', 15000.0, null, 'wholesaler');
assertCondition($res5['valid'] === true, "Wholesale coupon accepted for Wholesaler role");
assertCondition($res5['discount'] == 500.0, "Flat 500 discount applied");

// Test 5: Exhausted Quota (used_count >= usage_limit)
$res6 = DiscountEngine::applyCoupon('EXHAUSTED', 2000.0, null, 'customer');
assertCondition($res6['valid'] === false, "Exhausted coupon rejected");
assertCondition(strpos(strtolower($res6['message']), 'limit') !== false, "Rejection message states limit reached");

// Test 6: Scheduled Future Coupon (starts_at > now)
$res7 = DiscountEngine::applyCoupon('FUTURECOUPON', 2000.0, null, 'customer');
assertCondition($res7['valid'] === false, "Future coupon rejected before start date");
assertCondition(strpos(strtolower($res7['message']), 'future promotion') !== false || strpos(strtolower($res7['message']), 'not yet active') !== false, "Message explains future activation");

// Test 7: Expired Coupon (expires_at < now)
$res8 = DiscountEngine::applyCoupon('PASTEXPIRED', 2000.0, null, 'customer');
assertCondition($res8['valid'] === false, "Past expired coupon rejected");

// Test 8: Case & Whitespace Normalization
$res9 = DiscountEngine::applyCoupon('  universal10  ', 2000.0, null, 'customer');
assertCondition($res9['valid'] === true, "Lowercase code with leading/trailing spaces normalized and accepted");
assertCondition($res9['discount'] == 200.0, "Correct discount of 200 calculated");

// Test 9: Real Redemption Recording & Audit Logging
$recorded = DiscountEngine::recordRedemption(
    'UNIVERSAL10',
    101,
    'DT-ORD-99901',
    42,
    '9876543210',
    'Anjali Sharma',
    200.0,
    2000.0,
    'customer'
);
assertCondition($recorded === true, "recordRedemption executed successfully");

// Verify usage count incremented
$usedCheck = (int)$sqlite->query("SELECT used_count FROM coupons WHERE code = 'UNIVERSAL10'")->fetchColumn();
assertCondition($usedCheck === 6, "used_count incremented from 5 to 6 in coupons table");

// Verify coupon_usages row
$usageRow = $sqlite->query("SELECT * FROM coupon_usages WHERE coupon_code = 'UNIVERSAL10' AND order_number = 'DT-ORD-99901'")->fetch(\PDO::FETCH_ASSOC);
assertCondition(!empty($usageRow), "Row inserted in coupon_usages ledger");
assertCondition((float)$usageRow['discount_amount'] == 200.0, "Discount amount matches 200.00 in ledger");
assertCondition($usageRow['customer_phone'] === '9876543210', "Customer phone recorded in ledger");

// Verify audit log
$auditCount = (int)$sqlite->query("SELECT COUNT(*) FROM coupon_audit_logs WHERE coupon_code = 'UNIVERSAL10'")->fetchColumn();
assertCondition($auditCount >= 1, "Audit log row inserted in coupon_audit_logs");

// Test 10: getActiveCoupons filters
$activeCoupons = DiscountEngine::getActiveCoupons(10, 'all');
$activeCodes = array_column($activeCoupons, 'code');
assertCondition(in_array('UNIVERSAL10', $activeCodes, true), "UNIVERSAL10 present in active coupons list");
assertCondition(!in_array('PASTEXPIRED', $activeCodes, true), "PASTEXPIRED filtered out from active coupons list");
assertCondition(!in_array('FUTURECOUPON', $activeCodes, true), "FUTURECOUPON filtered out from active coupons list");

// Cleanup
Database::setPdo(null, true);

echo "\n=======================================================\n";
echo "Section 26 Test Summary: {$passed} Passed, {$failed} Failed\n";
echo "=======================================================\n";

if ($failed > 0) {
    exit(1);
}
exit(0);
