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
require_once __DIR__ . '/../src/Auth.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;
use DTBrand\CustomerManager;
use DTBrand\OrderManager;
use DTBrand\ReviewManager;
use DTBrand\DiscountEngine;
use DTBrand\Auth;

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

// ============================================================================
// 8. CUSTOMER ADDRESS BOOK & MULTI-DESTINATION MANAGEMENT TEST
// ============================================================================
echo "\n================================================================================\n";
echo "8. CUSTOMER ADDRESS BOOK & MULTI-DESTINATION MANAGEMENT TEST\n";
echo "================================================================================\n";

// 1. Save warehouse shipping address
$addrRes1 = Auth::saveAddress(1, [
    'recipient_name' => 'Surat Central Depot Godown',
    'phone' => '+91 91704 63528',
    'address_line1' => 'Plot 88, GIDC Industrial Estate, Pandesara',
    'address_line2' => 'Behind Central Bank',
    'city' => 'Surat',
    'state' => 'Gujarat',
    'pincode' => '394221',
    'address_type' => 'warehouse',
    'is_default' => 0
]);
assertTest("Auth::saveAddress saves customer warehouse destination", isset($addrRes1['success']) && $addrRes1['success'] === true, json_encode($addrRes1));

// 2. Save official billing address
$addrRes2 = Auth::saveAddress(1, [
    'recipient_name' => 'Rajesh Wholesalers Corporate HQ',
    'phone' => '+91 98250 12345',
    'address_line1' => 'Shop 104, Millennium Textile Market, Ring Road',
    'address_line2' => 'Tower A, 1st Floor',
    'city' => 'Surat',
    'state' => 'Gujarat',
    'pincode' => '395002',
    'address_type' => 'billing',
    'is_default' => 1
]);
assertTest("Auth::saveAddress saves customer official billing address", isset($addrRes2['success']) && $addrRes2['success'] === true, json_encode($addrRes2));

// 3. Retrieve all saved addresses
$allAddresses = Auth::getCustomerAddresses(1);
assertTest("Auth::getCustomerAddresses retrieves all saved addresses", is_array($allAddresses) && count($allAddresses) >= 2);
assertTest("First address in list is designated billing address", isset($allAddresses[0]['address_type']) && $allAddresses[0]['address_type'] === 'billing');
assertTest("Billing address has is_default set to 1", !empty($allAddresses[0]['is_default']));

// ============================================================================
// 9. DEVELOPER & API ADMINISTRATION SUITE (SECTION 37) VALIDATION TEST
// ============================================================================
echo "\n================================================================================\n";
echo "9. DEVELOPER & API ADMINISTRATION SUITE (SECTION 37) VALIDATION TEST\n";
echo "================================================================================\n";

require_once __DIR__ . '/../src/DeveloperManager.php';
use DTBrand\DeveloperManager;

$devManager = DeveloperManager::getInstance();

// 1. API Registry Catalog
$registry = $devManager->getApiRegistry();
assertTest("DeveloperManager::getApiRegistry returns non-empty catalog", is_array($registry) && count($registry) >= 10);
assertTest("DeveloperManager::getApiRegistry contains /api/health.php", isset($registry['/api/health.php']));

// 2. Base URL resolution & dynamic cURL snippet
$baseUrl = DeveloperManager::getBaseUrl();
assertTest("DeveloperManager::getBaseUrl returns valid URL format", filter_var($baseUrl, FILTER_VALIDATE_URL) !== false || strpos($baseUrl, 'http') === 0);
$curlSnippet = $devManager->generateCurlSnippet('/api/health.php');
assertTest("DeveloperManager::generateCurlSnippet outputs dynamic cURL command", strpos($curlSnippet, 'curl -X GET') !== false);

// 3. API Health & Latency Telemetry
$apiHealth = $devManager->getApiHealth();
assertTest("DeveloperManager::getApiHealth computes health score", isset($apiHealth['health_score']) && is_numeric($apiHealth['health_score']));
assertTest("DeveloperManager::getApiHealth computes uptime percent", isset($apiHealth['uptime_percent']) && is_numeric($apiHealth['uptime_percent']));

// 4. Queue Stats & Job Execution
$queueStats = $devManager->getQueueStats();
assertTest("DeveloperManager::getQueueStats returns stats structure", isset($queueStats['pending']) && isset($queueStats['completed']));
$queueJobs = $devManager->getQueueJobs('all', 10);
assertTest("DeveloperManager::getQueueJobs returns job list", is_array($queueJobs));

// 5. Webhook Events & Dispatch
$webhooks = $devManager->getWebhookEvents();
assertTest("DeveloperManager::getWebhookEvents returns event ledger", is_array($webhooks) && count($webhooks) >= 1);

// 6. Route Map & Audit
$routes = $devManager->getRouteMap();
assertTest("DeveloperManager::getRouteMap returns comprehensive route table", is_array($routes) && count($routes) >= 20);

// 7. Migrations Status & Normalized Ledger
$migStatus = $devManager->getMigrationStatus();
assertTest("DeveloperManager::getMigrationStatus returns total canonical migrations", isset($migStatus['total_canonical']) && $migStatus['total_canonical'] > 0);
$migrationsList = $devManager->getMigrations();
assertTest("DeveloperManager::getMigrations returns normalized migration list", is_array($migrationsList) && count($migrationsList) > 0);
assertTest("First migration item has valid file, checksum, and status", !empty($migrationsList[0]['file']) && !empty($migrationsList[0]['checksum']) && !empty($migrationsList[0]['status']));

// 8. Diagnostics Engine
$diagnostics = $devManager->getDiagnostics();
assertTest("DeveloperManager::getDiagnostics evaluates system health status", isset($diagnostics['overall_status']) && in_array($diagnostics['overall_status'], ['optimal', 'degraded', 'warning']));

// 9. API Keys Lifecycle
$apiKeys = $devManager->getApiKeys();
assertTest("DeveloperManager::getApiKeys retrieves API key credentials", is_array($apiKeys));
$testKey = $devManager->createApiKey('Test Suite Runner Key', 'read_only', ['catalog:read'], 60, 1);
assertTest("DeveloperManager::createApiKey generates encrypted key record", isset($testKey['key_record']['id']) && !empty($testKey['plain_token']));
if (!empty($testKey['key_record']['id'])) {
    $revokeOk = $devManager->revokeApiKey((int)$testKey['key_record']['id']);
    assertTest("DeveloperManager::revokeApiKey deactivates test key", $revokeOk === true);
}

// ============================================================================
// 10. SYSTEM GOVERNANCE & HIGH-AVAILABILITY SUITE (SECTION 36) VALIDATION TEST
// ============================================================================
echo "\n================================================================================\n";
echo "10. SYSTEM GOVERNANCE & HIGH-AVAILABILITY SUITE (SECTION 36) VALIDATION TEST\n";
echo "================================================================================\n";

require_once __DIR__ . '/../src/SystemManager.php';
use DTBrand\SystemManager;

$sysManager = SystemManager::getInstance();
assertTest("SystemManager::getInstance initializes singleton", $sysManager instanceof SystemManager);

// 1. 8-Pillar Health Checks
$health = $sysManager->runHealthChecks();
assertTest("SystemManager::runHealthChecks returns 8 operational pillars", isset($health['pillars']) && count($health['pillars']) >= 8);
assertTest("SystemManager::runHealthChecks computes overall status", isset($health['overall']) && in_array($health['overall'], ['pass', 'warn', 'fail']));

// 2. Telemetry & Environment
$envInfo = $sysManager->getEnvironmentInfo();
assertTest("SystemManager::getEnvironmentInfo returns PHP runtime details", !empty($envInfo['php_version']) && !empty($envInfo['os']));

// 3. Storage Analysis
$storage = $sysManager->getStorageInfo();
assertTest("SystemManager::getStorageInfo returns disk usage metrics", isset($storage['disk_free_gb']) && isset($storage['directories']));

// 4. Migration Governance
$migrations = $sysManager->getMigrationHistory();
assertTest("SystemManager::getMigrationHistory returns verified migrations ledger", is_array($migrations) && count($migrations) > 0);
assertTest("First migration history record has valid applied status", ($migrations[0]['status'] ?? '') === 'applied');

// 5. Cache & OPcache
$cacheStats = $sysManager->getCacheStats();
assertTest("SystemManager::getCacheStats evaluates OPcache telemetry", isset($cacheStats['opcache']['enabled']));
$purgeRes = $sysManager->purgeCache();
assertTest("SystemManager::purgeCache purges OPcache and application cache", !empty($purgeRes['success']));

// 6. Maintenance Mode Status & Toggle
$maintStatus = $sysManager->getMaintenanceStatus();
assertTest("SystemManager::getMaintenanceStatus returns active flag and message", isset($maintStatus['active']) && !empty($maintStatus['message']));

// 7. Database Backups
$backups = $sysManager->getBackupHistory();
assertTest("SystemManager::getBackupHistory retrieves snapshot backups list", is_array($backups));

// 8. Settings Management
$settings = $sysManager->getSettings();
assertTest("SystemManager::getSettings returns full configuration dictionary", is_array($settings) && isset($settings['general']));
$generalSettings = $sysManager->getSettings('general');
assertTest("SystemManager::getSettings('general') returns section array", is_array($generalSettings) && !empty($generalSettings['site_name']));

// 9. Dangerous Operations Gatekeeper
$_SESSION['admin_user'] = ['id' => 1, 'role' => 'super_admin', 'name' => 'Gautam Sethi'];
$_SESSION['csrf_token'] = 'test_token_2026';
$verifyDangerous = $sysManager->verifyDangerousOperation('maintenance_toggle', 'Gautam@9006', 'test_token_2026');
assertTest("SystemManager::verifyDangerousOperation verifies super_admin password", !empty($verifyDangerous['verified']) && !empty($verifyDangerous['allowed']));

// 10. Database Optimization
$optRes = $sysManager->optimizeDatabase();
assertTest("SystemManager::optimizeDatabase defragments platform tables", $optRes === true);

// ============================================================================
// 11. STORE SETTINGS & MULTI-GATEWAY STUDIO (SECTION 34) VALIDATION TEST
// ============================================================================
echo "\n================================================================================\n";
echo "11. STORE SETTINGS & MULTI-GATEWAY STUDIO (SECTION 34) VALIDATION TEST\n";
echo "================================================================================\n";

// 1. Files & Structural Integrity
$settingsFiles = [
    'admin/settings/index.php',
    'admin/settings/general.php',
    'admin/settings/company.php',
    'admin/settings/payment.php',
    'admin/settings/shipping.php',
    'admin/settings/_shared.php',
    'admin/settings/settings.css',
    'admin/settings/settings.js',
    'api/settings.php'
];
foreach ($settingsFiles as $sf) {
    assertTest("Settings file exists: {$sf}", file_exists(__DIR__ . '/../' . $sf));
}

// 2. Shared Loader & dt_set Helper
require_once __DIR__ . '/../admin/settings/_shared.php';
$testFallback = dt_set('non_existent_key_for_test', 'Default Value');
assertTest("dt_set helper returns fallback when key absent", $testFallback === 'Default Value');

// 3. Multi-Gateway Payment Configuration
require_once __DIR__ . '/../src/PaymentManager.php';
use DTBrand\PaymentManager;
$gateways = PaymentManager::getAllGateways(false);
assertTest("PaymentManager::getAllGateways returns registered gateways", is_array($gateways) && count($gateways) >= 4);
assertTest("Direct UPI gateway is registered", isset($gateways['direct_upi']));
assertTest("Razorpay gateway is registered", isset($gateways['razorpay']));
assertTest("Cashfree gateway is registered", isset($gateways['cashfree']));
assertTest("Cash on Delivery gateway is registered", isset($gateways['cod']));
assertTest("WhatsApp Pay gateway is registered", isset($gateways['whatsapp_pay']));

$upiVpa = $gateways['direct_upi']['config']['upi_vpa'] ?? $gateways['direct_upi']['config']['upi_id'] ?? '';
assertTest("Direct UPI configured with official merchant VPA", strpos($upiVpa, '917046363528') !== false);

// 4. Zero Raw Browser Dialog Guarantee
$rawConfirmFound = false;
$rawAlertFound = false;
foreach ($settingsFiles as $sf) {
    if (!str_ends_with($sf, '.php') && !str_ends_with($sf, '.js')) continue;
    $content = file_get_contents(__DIR__ . '/../' . $sf);
    if (preg_match('/(?<![a-zA-Z0-9_])confirm\s*\(/', $content)) {
        $rawConfirmFound = true;
    }
    if (preg_match('/(?<![a-zA-Z0-9_])alert\s*\(/', $content)) {
        $rawAlertFound = true;
    }
}
assertTest("Store Settings suite has zero raw confirm() dialogs", !$rawConfirmFound);
assertTest("Store Settings suite has zero raw alert() dialogs", !$rawAlertFound);

echo "\n================================================================================\n";
echo "12. WHATSAPP CRM SUITE & CLOUD API VERIFICATION\n";
echo "================================================================================\n";

$waFiles = [
    'admin/whatsapp/index.php',
    'admin/whatsapp/broadcast.php',
    'admin/whatsapp/leads.php',
    'admin/whatsapp/templates.php',
    'admin/whatsapp/whatsapp.css',
    'admin/whatsapp/whatsapp.js',
    'api/whatsapp.php',
    'api/whatsapp/audience.php',
    'api/whatsapp/index.php'
];

foreach ($waFiles as $f) {
    assertTest("WhatsApp suite file exists: {$f}", file_exists(__DIR__ . '/../' . $f));
}

// Subprocess runner for testing api/whatsapp.php
function callWaApiSuite(array $params, string $method = 'GET'): array {
    $descriptor = [0 => ["pipe", "r"], 1 => ["pipe", "w"], 2 => ["pipe", "w"]];
    $cmd = 'php ' . escapeshellarg(__DIR__ . '/run_wa_action.php');
    $proc = proc_open($cmd, $descriptor, $pipes);
    if (!is_resource($proc)) return [];
    fwrite($pipes[0], json_encode(['method' => $method, 'params' => $params]));
    fclose($pipes[0]);
    $out = stream_get_contents($pipes[1]);
    fclose($pipes[1]);
    fclose($pipes[2]);
    proc_close($proc);
    return json_decode($out, true) ?: [];
}

$waInfo = callWaApiSuite(['action' => 'get_info']);
assertTest("WhatsApp API get_info returns success", ($waInfo['success'] ?? false) === true);
assertTest("WhatsApp API official number is 917046363528", ($waInfo['whatsapp_number'] ?? '') === '917046363528');

$waBcast = callWaApiSuite(['action' => 'broadcast', 'audience' => 'wholesale', 'message' => 'Festive Silk Alert'], 'POST');
assertTest("WhatsApp API broadcast returns success and queued status", ($waBcast['success'] ?? false) === true && ($waBcast['status'] ?? '') === 'queued');
assertTest("WhatsApp API broadcast returns recipient count", ($waBcast['recipients_count'] ?? 0) > 0);

$waPing = callWaApiSuite(['action' => 'test_ping']);
assertTest("WhatsApp API test_ping returns operational status", ($waPing['success'] ?? false) === true && ($waPing['status'] ?? '') === 'operational');

$waTpls = callWaApiSuite(['action' => 'get_templates']);
assertTest("WhatsApp API get_templates returns verified templates", ($waTpls['success'] ?? false) === true && count($waTpls['templates'] ?? []) >= 3);

// Zero raw dialogs in WhatsApp CRM files
$waRawConfirm = false;
$waRawAlert = false;
foreach ($waFiles as $f) {
    if (!str_ends_with($f, '.php') && !str_ends_with($f, '.js')) continue;
    $c = file_get_contents(__DIR__ . '/../' . $f);
    if (preg_match('/(?<![a-zA-Z0-9_])confirm\s*\(/', $c)) $waRawConfirm = true;
    if (preg_match('/(?<![a-zA-Z0-9_])alert\s*\(/', $c)) $waRawAlert = true;
}
assertTest("WhatsApp CRM suite has zero raw confirm() dialogs", !$waRawConfirm);
assertTest("WhatsApp CRM suite has zero raw alert() dialogs", !$waRawAlert);

// Sidebar Consolidation
$sb = file_get_contents(__DIR__ . '/../admin/includes/adminsidebar.php');
assertTest("Sidebar consolidates Master WhatsApp CRM", strpos($sb, 'id="navItem-whatsapp"') !== false);
assertTest("Sidebar includes Broadcast Studio", strpos($sb, '/admin/whatsapp/broadcast.php') !== false);
assertTest("Sidebar includes Lead Pipeline", strpos($sb, '/admin/whatsapp/leads.php') !== false);
assertTest("Sidebar includes Message Templates & HSM", strpos($sb, '/admin/whatsapp/templates.php') !== false);
assertTest("Sidebar includes Cloud API Gateway", strpos($sb, '/admin/whatsapp/templates.php?tab=gateway') !== false);

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


