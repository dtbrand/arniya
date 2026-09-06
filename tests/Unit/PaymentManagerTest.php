<?php

namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTBrand\PaymentManager;
use DTBrand\Database;
use PDO;

/**
 * PaymentManagerTest — Enterprise Unit tests for the Multi-Gateway Payment Processing Suite.
 * 
 * Verifies:
 * 1. Gateway catalog discovery and public configuration secret masking.
 * 2. Direct UPI NPCI spec URI generation, formatted Rupee amounts, and 1-tap mobile app deep links.
 * 3. Razorpay HMAC-SHA256 verification and Cashfree webhook signature verification.
 * 4. In-memory SQLite transaction ledger auditing (`payment_transactions`).
 * 5. Order payment status updates and inventory stock decrement audit protections.
 * 6. Gateway configuration persistence and retrieval (`payment_gateways`).
 */
class PaymentManagerTest extends TestCase
{
    private ?PDO $sqlitePdo = null;

    protected function setUp(): void
    {
        parent::setUp();
        Database::setPdo(null, true);
    }

    protected function tearDown(): void
    {
        Database::reset();
        $this->sqlitePdo = null;
        parent::tearDown();
    }

    /**
     * Build an in-memory SQLite database matching DT Brand's payment schema.
     */
    private function createSqliteDatabase(): PDO
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        if (method_exists($pdo, 'sqliteCreateFunction')) {
            $pdo->sqliteCreateFunction('NOW', static fn() => date('Y-m-d H:i:s'));
            $pdo->sqliteCreateFunction('now', static fn() => date('Y-m-d H:i:s'));
            $pdo->sqliteCreateFunction('GREATEST', static fn(...$args) => max($args));
            $pdo->sqliteCreateFunction('greatest', static fn(...$args) => max($args));
        }

        $pdo->exec("
            CREATE TABLE payment_gateways (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                gateway_key TEXT NOT NULL UNIQUE,
                name TEXT NOT NULL,
                description TEXT DEFAULT '',
                is_active INTEGER DEFAULT 1,
                is_test_mode INTEGER DEFAULT 0,
                is_recommended INTEGER DEFAULT 0,
                config_json TEXT DEFAULT '{}',
                sort_order INTEGER DEFAULT 0,
                created_at TEXT,
                updated_at TEXT
            );

            CREATE TABLE payment_transactions (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_id INTEGER DEFAULT NULL,
                order_number TEXT NOT NULL,
                customer_id INTEGER DEFAULT NULL,
                customer_name TEXT DEFAULT NULL,
                customer_phone TEXT DEFAULT NULL,
                gateway TEXT NOT NULL,
                payment_method TEXT DEFAULT 'upi',
                amount REAL DEFAULT 0.0,
                currency TEXT DEFAULT 'INR',
                status TEXT DEFAULT 'pending',
                gateway_order_id TEXT DEFAULT NULL,
                gateway_payment_id TEXT DEFAULT NULL,
                gateway_signature TEXT DEFAULT NULL,
                utr_reference TEXT DEFAULT NULL,
                webhook_payload TEXT DEFAULT NULL,
                notes TEXT DEFAULT NULL,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP,
                updated_at TEXT DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE orders (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_number TEXT NOT NULL UNIQUE,
                payment_status TEXT DEFAULT 'pending',
                payment_gateway TEXT DEFAULT NULL,
                gateway_payment_id TEXT DEFAULT NULL,
                updated_at TEXT
            );

            CREATE TABLE order_items (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_id INTEGER NOT NULL,
                product_id INTEGER NOT NULL,
                quantity INTEGER NOT NULL DEFAULT 1
            );

            CREATE TABLE products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title TEXT NOT NULL,
                stock_qty INTEGER NOT NULL DEFAULT 0
            );
        ");

        $this->sqlitePdo = $pdo;
        Database::setPdo($pdo, false);
        return $pdo;
    }

    public function testGetAllGatewaysReturnsCompleteSuite(): void
    {
        $gateways = PaymentManager::getAllGateways(false);
        $this->assertIsArray($gateways);

        $expectedKeys = ['direct_upi', 'razorpay', 'cashfree', 'cod', 'whatsapp_pay'];
        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $gateways, "Expected gateway key '{$key}' missing from suite.");
            $this->assertNotEmpty($gateways[$key]['name']);
            $this->assertIsArray($gateways[$key]['config']);
        }
    }

    public function testGetActiveGatewaysFiltersProperly(): void
    {
        $activeGateways = PaymentManager::getAllGateways(true);
        $this->assertIsArray($activeGateways);

        foreach ($activeGateways as $k => $g) {
            $this->assertTrue($g['is_active'], "Gateway '{$k}' in active list must have is_active true.");
        }
    }

    public function testGetSingleGatewayByKey(): void
    {
        $upi = PaymentManager::getGateway('direct_upi');
        $this->assertNotNull($upi);
        $this->assertEquals('direct_upi', $upi['gateway_key']);
        $this->assertArrayHasKey('upi_vpa', $upi['config']);

        $cod = PaymentManager::getGateway('cod');
        $this->assertNotNull($cod);
        $this->assertEquals('cod', $cod['gateway_key']);

        $nonExistent = PaymentManager::getGateway('non_existent_gateway_xyz');
        $this->assertNull($nonExistent);
    }

    public function testGetPublicConfigMasksSecrets(): void
    {
        $public = PaymentManager::getPublicConfig();
        $this->assertIsArray($public);

        foreach ($public as $key => $data) {
            $this->assertArrayHasKey('gateway_key', $data);
            $this->assertArrayHasKey('config', $data);

            $cfg = $data['config'];
            // Secrets must never be exposed to public frontend
            $this->assertArrayNotHasKey('key_secret', $cfg, "Secret key leaked in public config for '{$key}'");
            $this->assertArrayNotHasKey('secret_key', $cfg, "Secret key leaked in public config for '{$key}'");
            $this->assertArrayNotHasKey('api_secret', $cfg, "API secret leaked in public config for '{$key}'");
            $this->assertArrayNotHasKey('password', $cfg, "Password leaked in public config for '{$key}'");
        }
    }

    public function testGenerateUpiPayloadStructure(): void
    {
        $orderNo = 'ORD-2026-TEST-99';
        $amount = 2499.50;
        $customerName = 'Boutique Buyer';

        $payload = PaymentManager::generateUpiPayload($orderNo, $amount, $customerName);

        $this->assertEquals($orderNo, $payload['order_number']);
        $this->assertEquals($amount, $payload['amount']);
        $this->assertStringContainsString('₹', $payload['amount_fmt']);
        $this->assertNotEmpty($payload['upi_vpa']);
        $this->assertNotEmpty($payload['payee_name']);

        // Verify NPCI UPI URI Specification
        $upiUri = $payload['upi_uri'];
        $this->assertStringStartsWith('upi://pay?', $upiUri);
        $this->assertStringContainsString('cu=INR', $upiUri);
        $this->assertStringContainsString('am=2499.50', $upiUri);
        $this->assertStringContainsString('tr=' . $orderNo, $upiUri);

        // Verify native mobile app deep links
        $appLinks = $payload['app_links'];
        $this->assertIsArray($appLinks);
        $this->assertArrayHasKey('gpay', $appLinks);
        $this->assertArrayHasKey('phonepe', $appLinks);
        $this->assertArrayHasKey('paytm', $appLinks);
        $this->assertArrayHasKey('cred', $appLinks);
        $this->assertArrayHasKey('bhim', $appLinks);

        $this->assertStringStartsWith('gpay://', $appLinks['gpay']);
        $this->assertStringStartsWith('phonepe://', $appLinks['phonepe']);
        $this->assertStringStartsWith('paytmmp://', $appLinks['paytm']);
        $this->assertStringStartsWith('cred://', $appLinks['cred']);
        $this->assertStringStartsWith('bhim://', $appLinks['bhim']);
    }

    public function testVerifyRazorpaySignatureFailsWhenSecretUnset(): void
    {
        $orderId = 'order_DA1234567890';
        $paymentId = 'pay_DA0987654321';
        $fakeSig = 'fake_signature_hex_digest';

        $result = PaymentManager::verifyRazorpaySignature($orderId, $paymentId, $fakeSig);
        $this->assertFalse($result);
    }

    public function testVerifyRazorpaySignatureWithConfiguredSecret(): void
    {
        $pdo = $this->createSqliteDatabase();

        $secret = 'rzp_sec_test_998811';
        $pdo->exec("
            INSERT INTO payment_gateways (gateway_key, name, is_active, config_json)
            VALUES ('razorpay', 'Razorpay Online', 1, '{\"key_id\":\"rzp_test_123\",\"key_secret\":\"{$secret}\"}')
        ");

        $orderId = 'order_ABC12345';
        $paymentId = 'pay_XYZ98765';
        $validSignature = hash_hmac('sha256', $orderId . '|' . $paymentId, $secret);

        $this->assertTrue(PaymentManager::verifyRazorpaySignature($orderId, $paymentId, $validSignature));
        $this->assertFalse(PaymentManager::verifyRazorpaySignature($orderId, $paymentId, 'invalid_corrupted_signature'));
    }

    public function testVerifyCashfreeWebhookSignature(): void
    {
        $pdo = $this->createSqliteDatabase();

        $cfSecret = 'cf_webhook_sec_445566';
        $pdo->exec("
            INSERT INTO payment_gateways (gateway_key, name, is_active, config_json)
            VALUES ('cashfree', 'Cashfree PG', 1, '{\"app_id\":\"cf_app\",\"secret_key\":\"cf_sec\",\"webhook_secret\":\"{$cfSecret}\"}')
        ");

        $rawBody = '{"data":{"order":{"order_id":"DT_ORD_100","order_amount":3500.00}}}';
        $timestamp = time();
        $validSignature = base64_encode(hash_hmac('sha256', $timestamp . $rawBody, $cfSecret, true));

        $this->assertTrue(PaymentManager::verifyCashfreeWebhookSignature($rawBody, $validSignature, $timestamp));
        $this->assertFalse(PaymentManager::verifyCashfreeWebhookSignature($rawBody, 'invalid_base64_sig', $timestamp));
    }

    public function testVerifyRazorpayWebhookSignature(): void
    {
        $pdo = $this->createSqliteDatabase();

        $rzpSecret = 'rzp_wh_secret_998877';
        $pdo->exec("
            INSERT INTO payment_gateways (gateway_key, name, is_active, config_json)
            VALUES ('razorpay', 'Razorpay PG', 1, '{\"key_id\":\"rzp_key\",\"key_secret\":\"rzp_sec\",\"webhook_secret\":\"{$rzpSecret}\"}')
        ");

        $rawBody = '{"event":"payment.captured","payload":{"payment":{"entity":{"id":"pay_123","amount":50000}}}}';
        $validSignature = hash_hmac('sha256', $rawBody, $rzpSecret);

        $this->assertTrue(PaymentManager::verifyRazorpayWebhookSignature($rawBody, $validSignature));
        $this->assertFalse(PaymentManager::verifyRazorpayWebhookSignature($rawBody, 'invalid_razorpay_sig'));
    }

    public function testInMemorySqliteRecordTransaction(): void
    {
        $pdo = $this->createSqliteDatabase();

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
        $this->assertGreaterThan(0, $txId);

        $row = $pdo->query("SELECT * FROM payment_transactions WHERE id = {$txId}")->fetch();
        $this->assertNotEmpty($row);
        $this->assertEquals('DT-ORD-9001', $row['order_number']);
        $this->assertEquals(4500.00, (float)$row['amount']);
        $this->assertEquals('captured', $row['status']);
        $this->assertEquals('UTR123456789012', $row['utr_reference']);
        $this->assertStringContainsString('payment.captured', $row['webhook_payload']);
    }

    public function testInMemorySqliteMarkOrderPaidAndAdjustStock(): void
    {
        $pdo = $this->createSqliteDatabase();

        // 1. Insert product with stock_qty = 100
        $pdo->exec("INSERT INTO products (id, title, stock_qty) VALUES (1, 'Kanjivaram Silk Saree', 100)");

        // 2. Insert order
        $pdo->exec("INSERT INTO orders (id, order_number, payment_status) VALUES (50, 'DT-ORD-AUDIT-01', 'pending')");

        // 3. Insert order item for product 1 with quantity 15
        $pdo->exec("INSERT INTO order_items (order_id, product_id, quantity) VALUES (50, 1, 15)");

        $res = PaymentManager::markOrderPaidAndAdjustStock('DT-ORD-AUDIT-01', 'razorpay', 'pay_RAZORPAY_7788');
        $this->assertTrue($res);

        // Verify order payment status updated
        $order = $pdo->query("SELECT payment_status, payment_gateway, gateway_payment_id FROM orders WHERE id = 50")->fetch();
        $this->assertEquals('paid', $order['payment_status']);
        $this->assertEquals('razorpay', $order['payment_gateway']);
        $this->assertEquals('pay_RAZORPAY_7788', $order['gateway_payment_id']);

        // Verify product stock decremented from 100 to 85
        $stock = (int)$pdo->query("SELECT stock_qty FROM products WHERE id = 1")->fetchColumn();
        $this->assertEquals(85, $stock);
    }

    public function testInMemorySqliteSaveAndGetGatewayConfig(): void
    {
        $this->createSqliteDatabase();

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
        $this->assertTrue($saved);

        $retrieved = PaymentManager::getGateway('direct_upi');
        $this->assertNotNull($retrieved);
        $this->assertEquals('Custom Lightning Fast UPI', $retrieved['name']);
        $this->assertEquals(1, $retrieved['is_active']);
        $this->assertEquals('master@icici', $retrieved['config']['upi_vpa']);
    }

    public function testCodConfigurationDefaults(): void
    {
        $cod = PaymentManager::getGateway('cod');
        $this->assertNotNull($cod);
        $cfg = $cod['config'] ?? [];

        $this->assertArrayHasKey('min_order', $cfg);
        $this->assertArrayHasKey('max_order', $cfg);
        $this->assertGreaterThan(0, (float)$cfg['min_order']);
        $this->assertGreaterThan((float)$cfg['min_order'], (float)$cfg['max_order']);
    }

    public function testWhatsAppPayConfigurationDefaults(): void
    {
        $waPay = PaymentManager::getGateway('whatsapp_pay');
        $this->assertNotNull($waPay);
        $cfg = $waPay['config'] ?? [];

        $this->assertArrayHasKey('phone', $cfg);
        $this->assertEquals('917046363528', $cfg['phone']);
    }
}
