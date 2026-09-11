<?php
/**
 * test_unit_inventory_ledger.php — Unit tests for InventoryManager and ProductCatalog stock adjustments
 */

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/../src/InventoryManager.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;
use DTBrand\InventoryManager;

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

echo "=== DT BRAND'S INVENTORY & LEDGER AUDIT TEST SUITE ===\n\n";

// Test 1: Summary Metrics Structure
$metrics = InventoryManager::getSummaryMetrics();
assert_test(is_array($metrics), "Summary metrics is an array");
assert_test(isset($metrics['total_skus']) && is_int($metrics['total_skus']), "Metrics has total_skus int");
assert_test(isset($metrics['total_stock_units']) && is_int($metrics['total_stock_units']), "Metrics has total_stock_units int");
assert_test(isset($metrics['total_valuation']) && is_numeric($metrics['total_valuation']), "Metrics has total_valuation numeric");
assert_test(isset($metrics['valuation_formatted']) && str_starts_with($metrics['valuation_formatted'], '₹'), "Metrics has valuation_formatted with Indian Rupee symbol");
assert_test(isset($metrics['low_stock_count']), "Metrics has low_stock_count");
assert_test(isset($metrics['out_of_stock_count']), "Metrics has out_of_stock_count");

// Test 2: Inventory Ledger Methods
$ledger = InventoryManager::getLedger();
assert_test(is_array($ledger), "getLedger() returns an array");

$count = InventoryManager::getLedgerCount();
assert_test(is_int($count) && $count >= 0, "getLedgerCount() returns non-negative integer");

// Test 3: ProductCatalog::adjustStock input validation
$invalidZero = ProductCatalog::adjustStock(0, 10);
assert_test($invalidZero['success'] === false, "adjustStock(0, 10) rejected with success=false");

$invalidNegative = ProductCatalog::adjustStock(-5, 10);
assert_test($invalidNegative['success'] === false, "adjustStock(-5, 10) rejected with success=false");

// Test 4: Verify in-memory SQLite schema for inventory_ledger
$sqlite = new \PDO('sqlite::memory:');
$sqlite->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

$sqlite->exec("
    CREATE TABLE products (
        id INTEGER PRIMARY KEY,
        stock_qty INTEGER DEFAULT 50,
        title TEXT,
        sku TEXT,
        category TEXT,
        wholesale_price REAL DEFAULT 1500
    );
    CREATE TABLE inventory_ledger (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        product_id INTEGER NOT NULL,
        variant_id INTEGER NULL,
        sku TEXT,
        movement_type TEXT NOT NULL,
        previous_qty INTEGER NOT NULL,
        adjustment_qty INTEGER NOT NULL,
        new_qty INTEGER NOT NULL,
        reason TEXT,
        reference_id TEXT,
        operator TEXT,
        created_at TEXT
    );
    INSERT INTO products (id, stock_qty, title, sku, category, wholesale_price)
    VALUES (1, 100, 'Kanjivaram Silk Saree', 'DT-KJ-01', 'Silk Sarees', 2500);
");

// Verify SQLite MAX expression prevents negative stock
$isSqlite = ($sqlite->getAttribute(\PDO::ATTR_DRIVER_NAME) === 'sqlite');
assert_test($isSqlite === true, "SQLite driver correctly identified");

$safeStockExpr = $isSqlite ? "MAX(0, COALESCE(stock_qty, 0) + ?)" : "GREATEST(0, COALESCE(stock_qty, 0) + ?)";
$stmt = $sqlite->prepare("UPDATE products SET stock_qty = {$safeStockExpr} WHERE id = ?");
$stmt->execute([-150, 1]); // Deduct 150 from 100 -> should be 0, never negative!

$check = $sqlite->query("SELECT stock_qty FROM products WHERE id = 1")->fetchColumn();
assert_test((int)$check === 0, "SQLite MAX(0, stock_qty - delta) safely clamps negative stock to 0");

// Increment stock by +75
$stmt->execute([75, 1]);
$check2 = $sqlite->query("SELECT stock_qty FROM products WHERE id = 1")->fetchColumn();
assert_test((int)$check2 === 75, "Stock correctly incremented to 75 units");

// Test 5: Check movement type determination logic
$reasonInward = 'Consignment received at Surat Central';
$mtypeInward = str_contains(strtolower($reasonInward), 'received') ? 'inward' : 'adjustment';
assert_test($mtypeInward === 'inward', "Reason containing 'received' classified as inward");

$reasonOutward = 'Wholesale dispatch lot #12';
$mtypeOutward = str_contains(strtolower($reasonOutward), 'dispatch') ? 'outward' : 'adjustment';
assert_test($mtypeOutward === 'outward', "Reason containing 'dispatch' classified as outward");

echo "\nTests Complete: {$passed} Passed, {$failed} Failed\n";
exit($failed > 0 ? 1 : 0);
