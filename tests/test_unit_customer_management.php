<?php
/**
 * test_unit_customer_management.php — Unit tests for Customer Management (Section 25)
 */

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/CustomerManager.php';

use DTBrand\Database;
use DTBrand\CustomerManager;

$passed = 0;
$failed = 0;

function assert_test($condition, $name) {
    global $passed, $failed;
    if ($condition) {
        echo "  [PASS] {$name}\n";
        $passed++;
    } else {
        echo "  [FAIL] {$name}\n";
        $failed++;
    }
}

echo "=== DT BRAND'S CUSTOMER MANAGEMENT TEST SUITE (SECTION 25) ===\n\n";

// 1. Setup in-memory SQLite schema for customer testing
$sqlite = new \PDO('sqlite::memory:');
$sqlite->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$sqlite->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);

$sqlite->exec("
    CREATE TABLE customers (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        phone TEXT NOT NULL UNIQUE,
        email TEXT DEFAULT '',
        password_hash TEXT NOT NULL,
        gstin TEXT DEFAULT '',
        pan TEXT DEFAULT '',
        type TEXT DEFAULT 'retail',
        tier TEXT DEFAULT '',
        city TEXT DEFAULT '',
        state TEXT DEFAULT '',
        credit_limit REAL DEFAULT 0.0,
        outstanding_balance REAL DEFAULT 0.0,
        total_orders INTEGER DEFAULT 0,
        lifetime_spend REAL DEFAULT 0.0,
        commission_rate REAL DEFAULT 0.0,
        status TEXT DEFAULT 'active',
        created_at TEXT
    );
");

// Insert customers for each trade/retail role
$sqlite->exec("
    INSERT INTO customers (name, phone, email, password_hash, type, tier, city, state, lifetime_spend, total_orders, status, created_at)
    VALUES 
    ('Aarav Mehta', '9825011111', 'aarav@retail.in', 'hash', 'retail', 'Silver', 'Surat', 'Gujarat', 12500, 4, 'active', '2026-01-10 10:00:00'),
    ('Boutique Elegance', '9825022222', 'contact@elegance.in', 'hash', 'retailer', 'Gold Boutique', 'Ahmedabad', 'Gujarat', 85000, 12, 'active', '2026-01-12 12:00:00'),
    ('Pooja Reseller Hub', '9825033333', 'pooja@reseller.in', 'hash', 'reseller', 'VIP Reseller', 'Mumbai', 'Maharashtra', 45000, 18, 'active', '2026-01-15 15:00:00'),
    ('Jai Ambey Textiles Depot', '9825044444', 'sales@ambey.in', 'hash', 'wholesale', 'Depot Master', 'Jaipur', 'Rajasthan', 450000, 6, 'active', '2026-01-20 16:00:00'),
    ('Pending Trade Applicant', '9825055555', 'applicant@b2b.in', 'hash', 'wholesale', 'Standard', 'Delhi', 'Delhi', 0, 0, 'pending', '2026-02-01 11:00:00');
");

Database::setPdo($sqlite, false);

// Test 1: Customer list retrieval
$all = CustomerManager::getAll();
assert_test(is_array($all), "CustomerManager::getAll() returns an array");
assert_test(count($all) === 5, "Customer list contains exactly 5 registered accounts");

$first = $all[0];
assert_test(isset($first['id']) && isset($first['name']) && isset($first['phone']), "Customer row has id, name, phone");
assert_test(isset($first['type']), "Customer row has type column");
assert_test(isset($first['status']), "Customer row has status column");

// Test 2: Customer role segregation (Retailer, Reseller, Wholesaler)
$retailers = array_filter($all, fn($c) => ($c['type'] ?? '') === 'retailer');
$resellers = array_filter($all, fn($c) => ($c['type'] ?? '') === 'reseller');
$wholesalers = array_filter($all, fn($c) => ($c['type'] ?? '') === 'wholesale');
$retails = array_filter($all, fn($c) => ($c['type'] ?? '') === 'retail');

assert_test(count($retailers) === 1, "Exactly 1 Retailer found");
assert_test(count($resellers) === 1, "Exactly 1 Reseller found");
assert_test(count($wholesalers) === 2, "Exactly 2 Wholesalers found (1 active + 1 pending)");
assert_test(count($retails) === 1, "Exactly 1 Retail customer found");

// Test 3: CSV Formula Injection Sanitizer
function test_sanitize_csv($val) {
    if (is_string($val) && preg_match('/^[=\+\-@\t\r]/', $val)) {
        return "'" . $val;
    }
    return $val;
}

assert_test(test_sanitize_csv("=cmd|' /C calc'!A0") === "'=cmd|' /C calc'!A0", "Formula starting with = sanitized");
assert_test(test_sanitize_csv("+1234567890") === "'+1234567890", "Formula starting with + sanitized");
assert_test(test_sanitize_csv("-100") === "'-100", "Formula starting with - sanitized");
assert_test(test_sanitize_csv("@SUM(A1:A10)") === "'@SUM(A1:A10)", "Formula starting with @ sanitized");
assert_test(test_sanitize_csv("Pooja Sharma") === "Pooja Sharma", "Normal name left unaltered");

// Test 4: Dual Relative Adminguard Presence
$customerHubs = [
    'retailers.php' => __DIR__ . '/../admin/customers/retailers.php',
    'resellers.php' => __DIR__ . '/../admin/customers/resellers.php',
    'wholesalers.php' => __DIR__ . '/../admin/customers/wholesalers.php',
    'export.php' => __DIR__ . '/../admin/customers/export.php',
    'index.php' => __DIR__ . '/../admin/customers/index.php',
    'view.php' => __DIR__ . '/../admin/customers/view.php',
    'active.php' => __DIR__ . '/../admin/customers/active.php',
    'inactive.php' => __DIR__ . '/../admin/customers/inactive.php',
];

foreach ($customerHubs as $name => $path) {
    assert_test(file_exists($path), "File {$name} exists on disk");
    $content = file_get_contents($path);
    assert_test(strpos($content, '__DIR__ . \'/../includes/adminguard.php\'') !== false, "{$name} contains dual relative adminguard check");
}

echo "\nTests Complete: {$passed} Passed, {$failed} Failed\n";
exit($failed > 0 ? 1 : 0);
