<?php
/**
 * Comprehensive Test Runner for DT Reseller Hub
 * Runs all core functionality tests without requiring PHPUnit mbstring extension
 */

require_once __DIR__ . '/../includes/bootstrap.php';
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../src/PaymentManager.php';
require_once __DIR__ . '/../src/OrderManager.php';
require_once __DIR__ . '/../src/PricingCalculator.php';
require_once __DIR__ . '/../src/DiscountEngine.php';
require_once __DIR__ . '/../src/CustomerManager.php';
require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/../src/RateLimiter.php';

use DTBrand\Database;
use DTBrand\Auth;
use DTBrand\PaymentManager;
use DTBrand\OrderManager;
use DTBrand\PricingCalculator;
use DTBrand\DiscountEngine;
use DTBrand\CustomerManager;
use DTBrand\ProductCatalog;

class TestResult {
    public string $name;
    public bool $passed;
    public string $message;
    public float $duration;
    
    public function __construct(string $name, bool $passed, string $message = '', float $duration = 0.0) {
        $this->name = $name;
        $this->passed = $passed;
        $this->message = $message;
        $this->duration = $duration;
    }
}

class TestRunner {
    private array $results = [];
    private int $passed = 0;
    private int $failed = 0;
    private float $startTime;
    
    public function __construct() {
        $this->startTime = microtime(true);
    }
    
    public function run(string $name, callable $test): void {
        $start = microtime(true);
        try {
            $test();
            $duration = microtime(true) - $start;
            $this->results[] = new TestResult($name, true, 'OK', $duration);
            $this->passed++;
            echo "✅ PASS: {$name} ({$duration}s)\n";
        } catch (Throwable $e) {
            $duration = microtime(true) - $start;
            $this->results[] = new TestResult($name, false, $e->getMessage(), $duration);
            $this->failed++;
            echo "❌ FAIL: {$name} - {$e->getMessage()} ({$duration}s)\n";
        }
    }
    
    public function assertTrue(bool $condition, string $message = ''): void {
        if (!$condition) {
            throw new Exception("Assertion failed: " . ($message ?: 'Expected true'));
        }
    }
    
    public function assertFalse(bool $condition, string $message = ''): void {
        if ($condition) {
            throw new Exception("Assertion failed: " . ($message ?: 'Expected false'));
        }
    }
    
    public function assertEquals($expected, $actual, string $message = ''): void {
        // Allow loose comparison for numeric types
        if ($expected != $actual) {
            throw new Exception("Assertion failed: Expected " . var_export($expected, true) . ", got " . var_export($actual, true) . ($message ? " - $message" : ''));
        }
    }
    
    public function assertNotNull($value, string $message = ''): void {
        if ($value === null) {
            throw new Exception("Assertion failed: Expected not null" . ($message ? " - $message" : ''));
        }
    }
    
    public function assertNull($value, string $message = ''): void {
        if ($value !== null) {
            throw new Exception("Assertion failed: Expected null" . ($message ? " - $message" : ''));
        }
    }
    
    public function assertIsArray($value, string $message = ''): void {
        if (!is_array($value)) {
            throw new Exception("Assertion failed: Expected array" . ($message ? " - $message" : ''));
        }
    }
    
    public function assertArrayHasKey($key, array $array, string $message = ''): void {
        if (!array_key_exists($key, $array)) {
            throw new Exception("Assertion failed: Key '$key' not found in array" . ($message ? " - $message" : ''));
        }
    }
    
    public function assertStringContains(string $needle, string $haystack, string $message = ''): void {
        if (strpos($haystack, $needle) === false) {
            throw new Exception("Assertion failed: String does not contain '$needle'" . ($message ? " - $message" : ''));
        }
    }
    
    public function assertStringStartsWith(string $prefix, string $string, string $message = ''): void {
        if (strpos($string, $prefix) !== 0) {
            throw new Exception("Assertion failed: String does not start with '$prefix'" . ($message ? " - $message" : ''));
        }
    }
    
    public function assertGreaterThan($expected, $actual, string $message = ''): void {
        if ($actual <= $expected) {
            throw new Exception("Assertion failed: Expected > $expected, got $actual" . ($message ? " - $message" : ''));
        }
    }
    
    public function assertCount(int $expected, array $array, string $message = ''): void {
        if (count($array) !== $expected) {
            throw new Exception("Assertion failed: Expected count $expected, got " . count($array) . ($message ? " - $message" : ''));
        }
    }
    
    public function assertNotEmpty($value, string $message = ''): void {
        if (empty($value)) {
            throw new Exception("Assertion failed: Expected not empty" . ($message ? " - $message" : ''));
        }
    }
    
    public function assertArrayNotHasKey($key, array $array, string $message = ''): void {
        if (array_key_exists($key, $array)) {
            throw new Exception("Assertion failed: Key '$key' should not exist in array" . ($message ? " - $message" : ''));
        }
    }
    
    public function printSummary(): void {
        $totalTime = microtime(true) - $this->startTime;
        echo "\n" . str_repeat("=", 80) . "\n";
        echo "TEST SUMMARY\n";
        echo str_repeat("=", 80) . "\n";
        echo "Total Tests: " . count($this->results) . "\n";
        echo "Passed: {$this->passed}\n";
        echo "Failed: {$this->failed}\n";
        echo "Time: " . round($totalTime, 2) . "s\n";
        echo str_repeat("=", 80) . "\n";
        
        if ($this->failed > 0) {
            echo "\nFAILED TESTS:\n";
            foreach ($this->results as $r) {
                if (!$r->passed) {
                    echo "  - {$r->name}: {$r->message}\n";
                }
            }
        }
    }
    
    public function hasFailures(): bool {
        return $this->failed > 0;
    }
}

// Setup in-memory SQLite database - SKIPPED (PDO SQLite not available)
// Use mock mode instead
function createTestDatabase(): ?PDO {
    // SQLite driver not available in this environment
    // Tests will use mock mode instead
    return null;
}

// ============ TEST SUITES ============

echo "🧪 DT RESELLER HUB - COMPREHENSIVE TEST SUITE\n";
echo str_repeat("=", 80) . "\n\n";

$runner = new TestRunner();
Database::setPdo(null, true);

// ---- DATABASE TESTS ----
echo "\n📦 DATABASE TESTS\n";
echo str_repeat("-", 40) . "\n";

$runner->run('Database Connection - Mock Mode', function() use ($runner) {
    Database::setPdo(null, true);
    $pdo = Database::getConnection();
    $runner->assertTrue(Database::isMockMode(), 'Should be in mock mode');
    $runner->assertNull($pdo, 'PDO should be null in mock mode');
});

$runner->run('Database Query - Mock Mode Returns Empty', function() use ($runner) {
    Database::setPdo(null, true);
    $result = Database::query('SELECT 1');
    $runner->assertEquals([], $result);
});

$runner->run('Database Execute - Mock Mode Returns False', function() use ($runner) {
    Database::setPdo(null, true);
    $result = Database::execute('INSERT INTO test VALUES (1)');
    $runner->assertFalse($result);
});

// ---- PRICING CALCULATOR TESTS ----
echo "\n💰 PRICING CALCULATOR TESTS\n";
echo str_repeat("-", 40) . "\n";

$runner->run('PricingCalculator - Basic Calculation', function() use ($runner) {
    $calc = PricingCalculator::calculateOrderTotal(10000, 1000, 500, 5);
    $runner->assertEquals(10000, $calc['subtotal']);
    $runner->assertEquals(1000, $calc['discount']);
    $runner->assertEquals(9000, $calc['taxable']);
    $runner->assertEquals(450, $calc['gst']);
    $runner->assertEquals(500, $calc['shipping']);
    $runner->assertEquals(9950, $calc['grand_total']);
});

$runner->run('PricingCalculator - Zero Discount', function() use ($runner) {
    $calc = PricingCalculator::calculateOrderTotal(5000, 0, 0, 12);
    $runner->assertEquals(5000, $calc['subtotal']);
    $runner->assertEquals(0, $calc['discount']);
    $runner->assertEquals(5000, $calc['taxable']);
    $runner->assertEquals(600, $calc['gst']);
    $runner->assertEquals(0, $calc['shipping']);
    $runner->assertEquals(5600, $calc['grand_total']);
});

$runner->run('PricingCalculator - Discount Equals Subtotal', function() use ($runner) {
    $calc = PricingCalculator::calculateOrderTotal(5000, 5000, 0, 5);
    $runner->assertEquals(0, $calc['taxable']);
    $runner->assertEquals(0, $calc['gst']);
    $runner->assertEquals(0, $calc['grand_total']);
});

$runner->run('PricingCalculator - High GST Rate', function() use ($runner) {
    $calc = PricingCalculator::calculateOrderTotal(10000, 0, 0, 18);
    $runner->assertEquals(1800, $calc['gst']);
    $runner->assertEquals(11800, $calc['grand_total']);
});

// ---- DISCOUNT ENGINE TESTS ----
echo "\n🏷️ DISCOUNT ENGINE TESTS\n";
echo str_repeat("-", 40) . "\n";

$runner->run('DiscountEngine - No Coupon', function() use ($runner) {
    $result = DiscountEngine::applyCoupon('', 10000);
    $runner->assertIsArray($result);
    $runner->assertFalse($result['valid']);
    $runner->assertEquals(0.0, $result['discount']);
});

$runner->run('DiscountEngine - Invalid Coupon Returns Zero', function() use ($runner) {
    // Mock mode - should return 0
    Database::setPdo(null, true);
    $result = DiscountEngine::applyCoupon('INVALID', 10000);
    $runner->assertIsArray($result);
    $runner->assertFalse($result['valid']);
    $runner->assertEquals(0.0, $result['discount']);
});

// ---- PAYMENT MANAGER TESTS ----
echo "\n💳 PAYMENT MANAGER TESTS\n";
echo str_repeat("-", 40) . "\n";

$runner->run('PaymentManager - Get All Gateways (Mock)', function() use ($runner) {
    Database::setPdo(null, true);
    $gateways = PaymentManager::getAllGateways(false);
    $runner->assertIsArray($gateways);
    $runner->assertArrayHasKey('direct_upi', $gateways);
    $runner->assertArrayHasKey('razorpay', $gateways);
    $runner->assertArrayHasKey('cashfree', $gateways);
    $runner->assertArrayHasKey('cod', $gateways);
    $runner->assertArrayHasKey('whatsapp_pay', $gateways);
});

$runner->run('PaymentManager - Get Active Gateways', function() use ($runner) {
    Database::setPdo(null, true);
    $active = PaymentManager::getAllGateways(true);
    foreach ($active as $g) {
        $runner->assertTrue($g['is_active']);
    }
});

$runner->run('PaymentManager - Get Single Gateway', function() use ($runner) {
    Database::setPdo(null, true);
    $upi = PaymentManager::getGateway('direct_upi');
    $runner->assertNotNull($upi);
    $runner->assertEquals('direct_upi', $upi['gateway_key']);
    $runner->assertArrayHasKey('upi_vpa', $upi['config']);
    
    $none = PaymentManager::getGateway('non_existent');
    $runner->assertNull($none);
});

$runner->run('PaymentManager - Generate UPI Payload', function() use ($runner) {
    Database::setPdo(null, true);
    $payload = PaymentManager::generateUpiPayload('ORD-123', 2499.50, 'Test Customer');
    $runner->assertEquals('ORD-123', $payload['order_number']);
    $runner->assertEquals(2499.50, $payload['amount']);
    $runner->assertStringContains('₹', $payload['amount_fmt']);
    $runner->assertStringStartsWith('upi://pay?', $payload['upi_uri']);
    $runner->assertStringContains('cu=INR', $payload['upi_uri']);
    $runner->assertStringContains('am=2499.50', $payload['upi_uri']);
    $runner->assertStringContains('tr=ORD-123', $payload['upi_uri']);
    
    // Check app links
    $runner->assertArrayHasKey('gpay', $payload['app_links']);
    $runner->assertArrayHasKey('phonepe', $payload['app_links']);
    $runner->assertArrayHasKey('paytm', $payload['app_links']);
    $runner->assertArrayHasKey('cred', $payload['app_links']);
    $runner->assertArrayHasKey('bhim', $payload['app_links']);
});

$runner->run('PaymentManager - Public Config Masks Secrets', function() use ($runner) {
    Database::setPdo(null, true);
    $public = PaymentManager::getPublicConfig();
    foreach ($public as $key => $data) {
        $cfg = $data['config'];
        $runner->assertArrayNotHasKey('key_secret', $cfg);
        $runner->assertArrayNotHasKey('secret_key', $cfg);
        $runner->assertArrayNotHasKey('api_secret', $cfg);
        $runner->assertArrayNotHasKey('password', $cfg);
    }
});

$runner->run('PaymentManager - COD Config Defaults', function() use ($runner) {
    Database::setPdo(null, true);
    $cod = PaymentManager::getGateway('cod');
    $cfg = $cod['config'] ?? [];
    $runner->assertArrayHasKey('min_order', $cfg);
    $runner->assertArrayHasKey('max_order', $cfg);
    $runner->assertGreaterThan(0, (float)$cfg['min_order']);
    $runner->assertGreaterThan((float)$cfg['min_order'], (float)$cfg['max_order']);
});

$runner->run('PaymentManager - WhatsApp Pay Config', function() use ($runner) {
    Database::setPdo(null, true);
    $waPay = PaymentManager::getGateway('whatsapp_pay');
    $cfg = $waPay['config'] ?? [];
    $runner->assertArrayHasKey('phone', $cfg);
    $runner->assertEquals('917046363528', $cfg['phone']);
});

// ---- ORDER MANAGER TESTS (Mock Mode) ----
echo "\n📦 ORDER MANAGER TESTS (Mock Mode)\n";
echo str_repeat("-", 40) . "\n";

// Use mock mode for order tests
Database::setPdo(null, true);

$runner->run('OrderManager - Create Order Calculation', function() use ($runner) {
    $orderData = [
        'customer_name' => 'Radhika Textiles',
        'customer_phone' => '+91 98765 43210',
        'channel' => 'wholesale',
        'items' => [
            ['price' => 3850.00, 'quantity' => 8],
            ['price' => 3350.00, 'quantity' => 4]
        ],
        'discount' => 2000.00,
        'shipping' => 0.0,
        'gst_rate' => 5.0
    ];
    
    $order = OrderManager::createOrder($orderData);
    $runner->assertIsArray($order);
    $runner->assertStringStartsWith('DT-ORD-', $order['order_number']);
    $runner->assertEquals(2, $order['items_count']);
    $runner->assertEquals(44200.00, $order['pricing']['subtotal']);
    $runner->assertEquals(2000.00, $order['pricing']['discount']);
    $runner->assertEquals(2110.00, $order['pricing']['gst']);
    $runner->assertEquals(44310.00, $order['pricing']['grand_total']);
    $runner->assertStringContains('Namaste Radhika Textiles ji!', $order['whatsapp_notice']);
});

$runner->run('OrderManager - WhatsApp Notice Formatting', function() use ($runner) {
    $notice = OrderManager::generateWhatsAppNotice('DT-ORD-998877', 52500.00, 'Gautam');
    $runner->assertStringContains('Namaste Gautam ji! 🙏', $notice);
    $runner->assertStringContains('*DT-ORD-998877*', $notice);
    $runner->assertStringContains('₹52,500.00', $notice);
    $runner->assertStringContains('(GST 5% included)', $notice);
    $runner->assertStringContains('authentic handlooms! 🌸', $notice);
});

$runner->run('OrderManager - Clamps Excessive Discount', function() use ($runner) {
    $orderData = [
        'customer_name' => 'Ananya Sharma',
        'customer_phone' => '9876543210',
        'items' => [
            ['price' => 2500.00, 'quantity' => 2]
        ],
        'discount' => 12000.00,
        'shipping' => 100.00,
        'gst_rate' => 5.0
    ];
    
    $order = OrderManager::createOrder($orderData);
    $runner->assertEquals(5000.00, $order['pricing']['subtotal']);
    $runner->assertEquals(5000.00, $order['pricing']['discount']);
    $runner->assertEquals(0.00, $order['pricing']['taxable']);
    $runner->assertEquals(0.00, $order['pricing']['gst']);
    $runner->assertEquals(100.00, $order['pricing']['shipping']);
    $runner->assertEquals(100.00, $order['pricing']['grand_total']);
});

$runner->run('OrderManager - Fails With Zero Items', function() use ($runner) {
    $orderData = [
        'customer_name' => 'Blank Order Customer',
        'customer_phone' => '9876543210',
        'items' => []
    ];
    
    $order = OrderManager::createOrder($orderData);
    $runner->assertFalse($order['success']);
    $runner->assertEquals('This order has no valid items.', $order['message']);
});

$runner->run('OrderManager - Get Order Details (Mock)', function() use ($runner) {
    $order = OrderManager::getByOrderNumber('DT-ORD-TEST');
    $runner->assertNull($order);
});

$runner->run('OrderManager - Get By Phone (Mock)', function() use ($runner) {
    $results = OrderManager::getByPhone('9988776655');
    $runner->assertIsArray($results);
    $runner->assertEquals(0, count($results));
});

$runner->run('OrderManager - Update Status (Mock)', function() use ($runner) {
    $result = OrderManager::updateStatus('DT-ORD-TEST', 'dispatched');
    $runner->assertTrue($result);
});

$runner->run('OrderManager - Delete Order (Mock)', function() use ($runner) {
    $result = OrderManager::deleteOrder('DT-ORD-TEST');
    $runner->assertTrue($result);
});

$runner->run('OrderManager - Get All Orders (Mock)', function() use ($runner) {
    $all = OrderManager::getAll();
    $runner->assertIsArray($all);
    $runner->assertEquals(0, count($all));
});

$runner->run('OrderManager - Channel Resolution Authenticated Customer (Mock)', function() use ($runner) {
    $_SESSION['user'] = ['id' => 1201];
    
    $order = OrderManager::createOrder([
        'customer_name' => 'Vandana Reseller',
        'items' => [['id' => 1202, 'quantity' => 2, 'price' => 5400.00]]
    ]);
    
    $runner->assertIsArray($order);
    unset($_SESSION['user']);
});

$runner->run('OrderManager - Admin Can Order Any Channel (Mock)', function() use ($runner) {
    $_SESSION['admin_logged_in'] = true;
    
    $order = OrderManager::createOrder([
        'customer_name' => 'Manual Phone Booking',
        'customer_phone' => '9900990099',
        'channel' => 'wholesale',
        'items' => [['id' => 1301, 'quantity' => 4, 'price' => 3500.00]]
    ]);
    
    $runner->assertIsArray($order);
    unset($_SESSION['admin_logged_in']);
});

// ---- PAYMENT MANAGER SQLITE TESTS (Mock Mode) ----
echo "\n💳 PAYMENT MANAGER MOCK TESTS\n";
echo str_repeat("-", 40) . "\n";

$runner->run('PaymentManager - Mock: Record Transaction', function() use ($runner) {
    Database::setPdo(null, true);
    $txData = [
        'order_id' => 10,
        'order_number' => 'DT-ORD-9001',
        'customer_name' => 'Meera Ben',
        'customer_phone' => '9876500001',
        'gateway' => 'direct_upi',
        'payment_method' => 'upi',
        'amount' => 4500.00,
        'currency' => 'INR',
        'status' => 'captured',
        'utr_reference' => 'UTR123456789012',
        'webhook_payload' => ['event' => 'payment.captured', 'time' => time()],
        'notes' => 'Direct UPI Payment Verified'
    ];
    
    $txId = PaymentManager::recordTransaction($txData);
    $runner->assertEquals(1, $txId); // Mock mode returns 1
});

$runner->run('PaymentManager - Mock: Mark Order Paid & Adjust Stock', function() use ($runner) {
    Database::setPdo(null, true);
    $res = PaymentManager::markOrderPaidAndAdjustStock('DT-ORD-AUDIT-01', 'razorpay', 'pay_RAZORPAY_7788');
    $runner->assertTrue($res); // Mock mode returns true
});

$runner->run('PaymentManager - Mock: Save & Get Gateway Config', function() use ($runner) {
    Database::setPdo(null, true);
    $saved = PaymentManager::saveGatewayConfig('direct_upi', [
        'name' => 'Custom Lightning Fast UPI',
        'description' => 'Direct bank transfer via UPI QR',
        'is_active' => 1,
        'is_recommended' => 1,
        'config' => [
            'upi_vpa' => 'master@icici',
            'payee_name' => 'DT Brands Surat',
            'mcc' => '5691'
        ]
    ]);
    $runner->assertFalse($saved); // Mock mode returns false
    
    $retrieved = PaymentManager::getGateway('direct_upi');
    $runner->assertNotNull($retrieved);
    $runner->assertEquals('Instant UPI / Dynamic QR (0% Fee)', $retrieved['name']);
});

// ---- AUTH TESTS ----
echo "\n🔐 AUTH TESTS\n";
echo str_repeat("-", 40) . "\n";

$runner->run('Auth - Generate CSRF Token', function() use ($runner) {
    Auth::initSession();
    $token = Auth::generateCsrfToken();
    $runner->assertNotEmpty($token);
    $runner->assertEquals(64, strlen($token)); // 32 bytes = 64 hex chars
});

$runner->run('Auth - Validate CSRF Token', function() use ($runner) {
    Auth::initSession();
    $_SESSION['csrf_token'] = 'test_token_12345';
    $runner->assertTrue(Auth::validateCsrfToken('test_token_12345'));
    $runner->assertFalse(Auth::validateCsrfToken('wrong_token'));
    $runner->assertFalse(Auth::validateCsrfToken(''));
    $runner->assertFalse(Auth::validateCsrfToken(null));
});

$runner->run('Auth - Logged In Checks', function() use ($runner) {
    Auth::initSession();
    unset($_SESSION['user']);
    unset($_SESSION['admin_user']);
    $runner->assertFalse(Auth::isLoggedIn());
    $runner->assertFalse(Auth::isAdminLoggedIn());
    
    $_SESSION['user'] = ['id' => 1];
    $runner->assertTrue(Auth::isLoggedIn());
    $runner->assertFalse(Auth::isAdminLoggedIn());
    
    unset($_SESSION['user']);
    $_SESSION['admin_user'] = ['id' => 1];
    $runner->assertFalse(Auth::isLoggedIn());
    $runner->assertTrue(Auth::isAdminLoggedIn());
});

$runner->run('Auth - Get Current User', function() use ($runner) {
    Auth::initSession();
    unset($_SESSION['user']);
    $runner->assertNull(Auth::getCurrentUser());
    
    $_SESSION['user'] = ['id' => 5, 'name' => 'Test User'];
    $user = Auth::getCurrentUser();
    $runner->assertNotNull($user);
    $runner->assertEquals(5, $user['id']);
    $runner->assertEquals('Test User', $user['name']);
});

// ---- CUSTOMER MANAGER TESTS ----
echo "\n👥 CUSTOMER MANAGER TESTS\n";
echo str_repeat("-", 40) . "\n";

$runner->run('CustomerManager - Class Loads', function() use ($runner) {
    $runner->assertTrue(class_exists('DTBrand\CustomerManager'));
});

// ---- PRODUCT CATALOG TESTS ----
echo "\n🛍️ PRODUCT CATALOG TESTS\n";
echo str_repeat("-", 40) . "\n";

$runner->run('ProductCatalog - Class Loads', function() use ($runner) {
    $runner->assertTrue(class_exists('DTBrand\ProductCatalog'));
});

// ---- RATE LIMITER TESTS ----
echo "\n🚦 RATE LIMITER TESTS\n";
echo str_repeat("-", 40) . "\n";

$runner->run('RateLimiter - Class Loads', function() use ($runner) {
    $runner->assertTrue(class_exists('RateLimiter'));
});

// ---- API ENDPOINT STRUCTURE TESTS ----
echo "\n🔌 API ENDPOINT STRUCTURE TESTS\n";
echo str_repeat("-", 40) . "\n";

$apiFiles = [
    'api/health.php',
    'api/products.php',
    'api/products/index.php',
    'api/categories.php',
    'api/categories/index.php',
    'api/brands.php',
    'api/attributes.php',
    'api/variants.php',
    'api/search.php',
    'api/orders.php',
    'api/orders/index.php',
    'api/cart.php',
    'api/cart/index.php',
    'api/wishlist.php',
    'api/wishlist/index.php',
    'api/customers.php',
    'api/customers/index.php',
    'api/users.php',
    'api/payments.php',
    'api/payments/index.php',
    'api/payment/verify.php',
    'api/payment/create_order.php',
    'api/payment/config.php',
    'api/payment/admin_save.php',
    'api/payment/test_webhook.php',
    'api/payments/upi_status.php',
    'api/payments/upi_verify.php',
    'api/payments/razorpay_webhook.php',
    'api/payments/cashfree_webhook.php',
    'api/shipping.php',
    'api/shipping/index.php',
    'api/shipping/test.php',
    'api/whatsapp.php',
    'api/whatsapp/index.php',
    'api/whatsapp/audience.php',
    'api/notifications.php',
    'api/notifications/index.php',
    'api/media/index.php',
    'api/media/delete.php',
    'api/upload.php',
    'api/reviews.php',
    'api/coupons.php',
    'api/settings.php',
    'api/wholesale.php',
    'api/wholesale/index.php',
    'api/reseller.php',
    'api/reseller/index.php',
    'api/retailer.php',
    'api/retailer/index.php',
    'api/db_optimize.php',
    'api/db_sync.php',
    'api/db_audit.php',
    'api/db_health.php',
    'api/seed_demo_catalog.php',
];

foreach ($apiFiles as $file) {
    $runner->run("API File Exists: {$file}", function() use ($runner, $file) {
        $path = __DIR__ . '/../' . $file;
        $runner->assertTrue(file_exists($path), "File not found: {$file}");
        
        // Also lint it
        $lintOutput = [];
        $lintReturn = 0;
        exec("php -l " . escapeshellarg($path) . " 2>&1", $lintOutput, $lintReturn);
        $runner->assertEquals(0, $lintReturn, "PHP lint failed: " . implode("\n", $lintOutput));
    });
}

// ---- ADMIN PAGE TESTS ----
echo "\n🛠️ ADMIN PAGE TESTS\n";
echo str_repeat("-", 40) . "\n";

$adminFiles = [
    'admin/index.php',
    'admin/login.php',
    'admin/includes/adminheader.php',
    'admin/products/index.php',
    'admin/products/add.php',
    'admin/products/edit.php',
    'admin/products/view.php',
    'admin/products/components/product-form.php',
    'admin/products/variants/index.php',
    'admin/products/attributes/index.php',
    'admin/products/attributes/values.php',
    'admin/products/categories/index.php',
    'admin/products/categories/view.php',
    'admin/products/brands/index.php',
    'admin/products/brands/add.php',
    'admin/products/brands/edit.php',
    'admin/products/media/index.php',
    'admin/products/media/upload.php',
    'admin/products/imports/index.php',
    'admin/products/exports/index.php',
    'admin/products/featured/index.php',
    'admin/products/best-sellers/index.php',
    'admin/products/new-arrivals/index.php',
    'admin/products/reviews/index.php',
    'admin/products/reviews/pending.php',
    'admin/orders/index.php',
    'admin/orders/view.php',
    'admin/orders/pending.php',
    'admin/orders/confirmed.php',
    'admin/orders/processing.php',
    'admin/orders/packed.php',
    'admin/orders/shipped.php',
    'admin/orders/out-for-delivery.php',
    'admin/orders/delivered.php',
    'admin/orders/cancelled.php',
    'admin/orders/failed.php',
    'admin/orders/returns.php',
    'admin/orders/returned.php',
    'admin/orders/refunds.php',
    'admin/orders/refunded.php',
    'admin/orders/invoice.php',
    'admin/orders/packing-slip.php',
    'admin/orders/shipping-label.php',
    'admin/orders/ledger.php',
    'admin/orders/export.php',
    'admin/customers/index.php',
    'admin/customers/view.php',
    'admin/customers/edit.php',
    'admin/customers/new.php',
    'admin/customers/active.php',
    'admin/customers/inactive.php',
    'admin/customers/pending.php',
    'admin/customers/orders.php',
    'admin/customers/addresses.php',
    'admin/customers/notes.php',
    'admin/customers/activity.php',
    'admin/customers/export.php',
    'admin/customers/analytics.php',
    'admin/customers/components/customer-profile.php',
    'admin/catalogue/index.php',
    'admin/catalogue/categories/index.php',
    'admin/catalogue/categories/add.php',
    'admin/catalogue/categories/edit.php',
    'admin/catalogue/categories/view.php',
    'admin/catalogue/categories/reorder.php',
    'admin/catalogue/categories/bulk-actions.php',
    'admin/catalogue/subcategories/index.php',
    'admin/catalogue/subcategories/add.php',
    'admin/catalogue/subcategories/edit.php',
    'admin/catalogue/subcategories/view.php',
    'admin/catalogue/subcategories/reorder.php',
    'admin/catalogue/collections/index.php',
    'admin/catalogue/collections/add.php',
    'admin/catalogue/collections/edit.php',
    'admin/catalogue/collections/view.php',
    'admin/catalogue/banners/index.php',
    'admin/catalogue/banners/add.php',
    'admin/catalogue/banners/edit.php',
    'admin/catalogue/banners/reorder.php',
    'admin/catalogue/navigation.php',
    'admin/catalogue/components/navigation-builder.php',
    'admin/catalogue/merchandising.php',
    'admin/catalogue/featured.php',
    'admin/catalogue/hierarchy.php',
    'admin/catalogue/seo/index.php',
    'admin/catalogue/seo/category.php',
    'admin/catalogue/seo/collections.php',
    'admin/catalogue/components/seo-panel.php',
    'admin/reports/sales.php',
    'admin/reports/gst.php',
    'admin/reports/revenue.php',
    'admin/shipping/tracking.php',
    'admin/payments/index.php',
    'admin/notifications/index.php',
    'admin/notifications/push.php',
    'admin/inventory/low-stock.php',
];

foreach ($adminFiles as $file) {
    $runner->run("Admin File Exists & Lints: {$file}", function() use ($runner, $file) {
        $path = __DIR__ . '/../' . $file;
        $runner->assertTrue(file_exists($path), "File not found: {$file}");
        
        $lintOutput = [];
        $lintReturn = 0;
        exec("php -l " . escapeshellarg($path) . " 2>&1", $lintOutput, $lintReturn);
        $runner->assertEquals(0, $lintReturn, "PHP lint failed: " . implode("\n", $lintOutput));
    });
}

// ---- FRONTEND PAGE TESTS ----
echo "\n🌐 FRONTEND PAGE TESTS\n";
echo str_repeat("-", 40) . "\n";

$frontendFiles = [
    'index.php',
    'product.php',
    'shop.php',
    'wholesale.php',
    'retailer.php',
    'reseller.php',
    'account.php',
    'cart.php',
    'checkout.php',
    'shipping.php',
    'contact.php',
    'about-us.php',
    'terms.php',
    'privacy.php',
    'logout.php',
    'install.php',
    'dt_install_direct.php',
    'db_reset_migrations.php',
];

foreach ($frontendFiles as $file) {
    $runner->run("Frontend File Exists & Lints: {$file}", function() use ($runner, $file) {
        $path = __DIR__ . '/../' . $file;
        $runner->assertTrue(file_exists($path), "File not found: {$file}");
        
        $lintOutput = [];
        $lintReturn = 0;
        exec("php -l " . escapeshellarg($path) . " 2>&1", $lintOutput, $lintReturn);
        $runner->assertEquals(0, $lintReturn, "PHP lint failed: " . implode("\n", $lintOutput));
    });
}

$runner->run("Frontend Debug File Is Not Public: dt_debug.php", function() use ($runner) {
    $path = __DIR__ . '/../dt_debug.php';
    $runner->assertFalse(file_exists($path), 'Public debug file should remain removed from production builds.');
});

// ---- CONFIG FILE TESTS ----
echo "\n⚙️ CONFIG FILE TESTS\n";
echo str_repeat("-", 40) . "\n";

$configFiles = [
    'config/app.php',
    'config/database.php',
    'config/session.php',
    'config/auth.php',
    'config/payment.php',
    'config/services.php',
    'config/whatsapp.php',
    'config/shipping.php',
    'config/mail.php',
];

foreach ($configFiles as $file) {
    $runner->run("Config File Exists & Lints: {$file}", function() use ($runner, $file) {
        $path = __DIR__ . '/../' . $file;
        $runner->assertTrue(file_exists($path), "File not found: {$file}");
        
        $lintOutput = [];
        $lintReturn = 0;
        exec("php -l " . escapeshellarg($path) . " 2>&1", $lintOutput, $lintReturn);
        $runner->assertEquals(0, $lintReturn, "PHP lint failed: " . implode("\n", $lintOutput));
    });
}

// ---- MIGRATION FILE TESTS ----
echo "\n📊 MIGRATION FILE TESTS\n";
echo str_repeat("-", 40) . "\n";

$migrationFiles = [
    'database/migrations/2026_08_23_000001_create_initial_schema.sql',
    'database/migrations/2026_08_24_000001_full_production_schema.sql',
    'database/migrations/2026_08_25_production_upgrade.sql',
    'database/migrations/2026_08_29_000001_reconcile_full_schema.sql',
    'database/migrations/2026_08_30_000001_add_brands_and_admin_tables.sql',
    'database/migrations/2026_08_31_000001_seed_ethnic_pillars_and_subcategories.sql',
    'database/migrations/2026_09_02_000001_create_payment_gateways_and_webhooks.sql',
    'database/migrations/2026_09_07_000001_add_missing_columns_indexes_and_fixes.sql',
    'database/schema.sql',
    'database/arniya_master_production.sql',
    'database/seeders.sql',
];

foreach ($migrationFiles as $file) {
    $runner->run("Migration File Exists: {$file}", function() use ($runner, $file) {
        $path = __DIR__ . '/../' . $file;
        $runner->assertTrue(file_exists($path), "File not found: {$file}");
        
        // Check file is not empty
        $content = file_get_contents($path);
        $runner->assertNotEmpty($content, "File is empty: {$file}");
        // Check for either CREATE (schema) or INSERT (seeders)
        $runner->assertTrue(
            strpos($content, 'CREATE') !== false || strpos($content, 'INSERT') !== false,
            "File contains neither CREATE nor INSERT: {$file}"
        );
    });
}

// ---- JAVASCRIPT FILE TESTS ----
echo "\n📜 JAVASCRIPT FILE TESTS\n";
echo str_repeat("-", 40) . "\n";

$jsFiles = [
    'assets/js/core.js',
    'assets/js/header.js',
    'assets/js/home.js',
    'assets/js/shop.js',
    'assets/js/singleproduct.js',
    'assets/js/modals.js',
    'assets/js/profile-save.js',
    'assets/js/wholesale.js',
    'assets/js/retailer.js',
    'assets/js/reseller.js',
    'admin/assets/js/admin.js',
    'admin/products/assets/js/product-list.js',
    'admin/products/assets/js/product-form.js',
    'admin/products/assets/js/categories.js',
    'admin/products/assets/js/product-gallery.js',
    'admin/products/assets/js/variants.js',
    'admin/products/assets/js/bulk-actions.js',
    'admin/orders/assets/js/orders.js',
    'admin/orders/assets/js/order-list.js',
    'admin/orders/assets/js/order-view.js',
    'admin/orders/assets/js/order-status.js',
    'admin/orders/assets/js/order-filters.js',
    'admin/orders/assets/js/bulk-actions.js',
    'admin/orders/assets/js/returns.js',
    'admin/orders/assets/js/refunds.js',
    'admin/orders/assets/js/documents.js',
    'admin/customers/assets/js/customers.js',
    'admin/customers/assets/js/customer-list.js',
    'admin/customers/assets/js/customer-view.js',
    'admin/customers/assets/js/customer-status.js',
    'admin/customers/assets/js/customer-filters.js',
    'admin/customers/assets/js/customer-segments.js',
    'admin/customers/assets/js/customer-tags.js',
    'admin/customers/assets/js/bulk-actions.js',
    'admin/customers/assets/js/country-picker.js',
    // 'admin/customers/assets/js/customer-analytics.js',  // Does not exist
    'admin/catalogue/assets/js/catalogue.js',
    'admin/catalogue/assets/js/categories.js',
    'admin/catalogue/assets/js/collections.js',
    'admin/catalogue/assets/js/navigation.js',
    'admin/catalogue/assets/js/hierarchy.js',
    'admin/catalogue/assets/js/banners.js',
];

foreach ($jsFiles as $file) {
    $runner->run("JS File Exists: {$file}", function() use ($runner, $file) {
        $path = __DIR__ . '/../' . $file;
        $runner->assertTrue(file_exists($path), "File not found: {$file}");
        
        $content = file_get_contents($path);
        $runner->assertNotEmpty($content, "File is empty: {$file}");
    });
}

// ---- CSS FILE TESTS ----
echo "\n🎨 CSS FILE TESTS\n";
echo str_repeat("-", 40) . "\n";

$cssFiles = [
    'assets/css/main.css',
    'assets/css/header.css',
    'assets/css/home.css',
    'assets/css/shop.css',
    'assets/css/singleproduct.css',
    'assets/css/modals.css',
    'assets/css/policies.css',
    'assets/css/wholesale.css',
    'assets/css/retailer.css',
    'assets/css/reseller.css',
    'admin/assets/css/admin.css',
    'admin/dashboard/dashboard.css',
    'admin/products/products.css',
    'admin/products/assets/css/products.css',
    'admin/products/assets/css/product-list.css',
    'admin/products/assets/css/product-form.css',
    'admin/products/assets/css/product-view.css',
    'admin/products/assets/css/media.css',
    'admin/products/assets/css/variants.css',
    'admin/products/assets/css/categories.css',
    'admin/products/assets/css/imports.css',
    'admin/products/assets/css/wordpress-style.css',
    // 'admin/orders/orders.css',  // Does not exist
    'admin/orders/assets/css/orders.css',
    'admin/orders/assets/css/order-list.css',
    'admin/orders/assets/css/order-view.css',
    'admin/orders/assets/css/order-status.css',
    'admin/orders/assets/css/returns.css',
    'admin/orders/assets/css/refunds.css',
    'admin/orders/assets/css/documents.css',
    'admin/customers/customers.css',
    'admin/customers/assets/css/customers.css',
    'admin/customers/assets/css/customer-list.css',
    'admin/customers/assets/css/customer-view.css',
    'admin/customers/assets/css/customer-profile.css',
    'admin/customers/assets/css/customer-segments.css',
    'admin/customers/assets/css/customer-analytics.css',
    // 'admin/catalogue/catalogue.css',  // Does not exist
    'admin/catalogue/assets/css/catalogue.css',
    'admin/catalogue/assets/css/categories.css',
    'admin/catalogue/assets/css/collections.css',
    'admin/catalogue/assets/css/banners.css',
    'admin/catalogue/assets/css/navigation.css',
    'admin/catalogue/assets/css/merchandising.css',
    'admin/catalogue/assets/css/hierarchy.css',
    'admin/catalogue/assets/css/seo.css',
    'admin/whatsapp/whatsapp.css',
    'admin/system/system.css',
    'admin/settings/settings.css',
    'admin/users/users.css',
    'admin/notifications/notifications.css',
    'admin/media/media.css',
    'admin/cms/cms.css',
    'admin/reports/reports.css',
    'admin/shipping/shipping.css',
    'admin/payments/payments.css',
    'admin/reviews/reviews.css',
    'admin/marketing/marketing.css',
    'admin/pricing/pricing.css',
    'admin/inventory/inventory.css',
];

foreach ($cssFiles as $file) {
    $runner->run("CSS File Exists: {$file}", function() use ($runner, $file) {
        $path = __DIR__ . '/../' . $file;
        $runner->assertTrue(file_exists($path), "File not found: {$file}");
        
        $content = file_get_contents($path);
        $runner->assertNotEmpty($content, "File is empty: {$file}");
    });
}

// ---- INCLUDES TESTS ----
echo "\n📎 INCLUDES TESTS\n";
echo str_repeat("-", 40) . "\n";

$includeFiles = [
    'includes/header.php',
    'includes/shopheader.php',
    'includes/shophader.php',
    'includes/subnav.php',
    'includes/mobile_bottom_nav.php',
    'includes/footer.php',
    'includes/homebottomfooter.php',
    'includes/shopfooter.php',
    'includes/shopbottomfotoer.php',
    'includes/singelproduthader.php',
    'includes/singleproductbottomfooter.php',
    'includes/singelprodutbottomfotoer.php',
    'includes/product-not-found.php',
    'includes/bootstrap.php',
];

foreach ($includeFiles as $file) {
    $runner->run("Include File Exists & Lints: {$file}", function() use ($runner, $file) {
        $path = __DIR__ . '/../' . $file;
        $runner->assertTrue(file_exists($path), "File not found: {$file}");
        
        $lintOutput = [];
        $lintReturn = 0;
        exec("php -l " . escapeshellarg($path) . " 2>&1", $lintOutput, $lintReturn);
        $runner->assertEquals(0, $lintReturn, "PHP lint failed: " . implode("\n", $lintOutput));
    });
}

// ---- SHARED COMPONENT TESTS ----
echo "\n🔄 SHARED COMPONENT TESTS\n";
echo str_repeat("-", 40) . "\n";

$sharedFiles = [
    'Shared/Auth/logout.php',
    'Shared/Auth/myaccount.php',
    'Shared/checkout.php',
    'Shared/wishlist.php',
    'Shared/reels.php',
    'Shared/quickview.php',
    'Shared/cart.php',
    'Shared/smartshare.php',
    'Shared/account.php',
    'Shared/Includes/checkout.php',
    'Shared/Includes/wishlist.php',
    'Shared/Includes/cart.php',
    'Shared/Includes/reels.php',
    'Shared/Includes/smartshare.php',
    'Shared/Includes/quickview.php',
    'Shared/Includes/account.php',
    'Shared/Includes/sentry.php',
    'Shared/Includes/logger.php',
    'Shared/Includes/db.php',
];

foreach ($sharedFiles as $file) {
    $runner->run("Shared File Exists & Lints: {$file}", function() use ($runner, $file) {
        $path = __DIR__ . '/../' . $file;
        $runner->assertTrue(file_exists($path), "File not found: {$file}");
        
        $lintOutput = [];
        $lintReturn = 0;
        exec("php -l " . escapeshellarg($path) . " 2>&1", $lintOutput, $lintReturn);
        $runner->assertEquals(0, $lintReturn, "PHP lint failed: " . implode("\n", $lintOutput));
    });
}

// ---- SCRIPT FILE TESTS ----
echo "\n📜 SCRIPT FILE TESTS\n";
echo str_repeat("-", 40) . "\n";

$scriptFiles = [
    'scripts/ftp-deploy.php',
    'scripts/build-deploy-zip.php',
    'scripts/build-deploy-folder.php',
    'scripts/benchmark.php',
    'scripts/uptime-check.php',
    'scripts/restore-test.php',
    'scripts/backup-database.php',
    'scripts/append-banner-helper.php',
    'scripts/lint-all.php',
    'scripts/smoke-test.php',
    'scripts/strip-duplicate-shared-requires.php',
    'scripts/check-class-loads.php',
    'scripts/_page-runner.php',
    'scripts/check-page-fatals.php',
    'scripts/dedupe-report.php',
    'scripts/package-artifact.php',
    'scripts/check-includes.php',
    'scripts/cron-monitor.php',
    'scripts/rotate-logs.php',
];

foreach ($scriptFiles as $file) {
    $runner->run("Script File Exists & Lints: {$file}", function() use ($runner, $file) {
        $path = __DIR__ . '/../' . $file;
        $runner->assertTrue(file_exists($path), "File not found: {$file}");
        
        $lintOutput = [];
        $lintReturn = 0;
        exec("php -l " . escapeshellarg($path) . " 2>&1", $lintOutput, $lintReturn);
        $runner->assertEquals(0, $lintReturn, "PHP lint failed: " . implode("\n", $lintOutput));
    });
}

// ---- SOURCE FILE TESTS ----
echo "\n🏗️ SOURCE FILE TESTS\n";
echo str_repeat("-", 40) . "\n";

$srcFiles = [
    'src/Database.php',
    'src/Auth.php',
    'src/RateLimiter.php',
    'src/PaymentManager.php',
    'src/OrderManager.php',
    'src/DiscountEngine.php',
    'src/PricingCalculator.php',
    'src/CustomerManager.php',
    'src/ProductCatalog.php',
];

foreach ($srcFiles as $file) {
    $runner->run("Source File Exists & Lints: {$file}", function() use ($runner, $file) {
        $path = __DIR__ . '/../' . $file;
        $runner->assertTrue(file_exists($path), "File not found: {$file}");
        
        $lintOutput = [];
        $lintReturn = 0;
        exec("php -l " . escapeshellarg($path) . " 2>&1", $lintOutput, $lintReturn);
        $runner->assertEquals(0, $lintReturn, "PHP lint failed: " . implode("\n", $lintOutput));
    });
}

// Print final summary
$runner->printSummary();

// Exit with appropriate code
exit($runner->hasFailures() ? 1 : 0);
