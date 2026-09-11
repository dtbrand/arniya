<?php

namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTBrand\OrderManager;
use DTBrand\Database;
use PDO;

/**
 * OrderManagerTest — Enterprise Unit Test Suite for Multi-Channel Order Processing & Stock Engine.
 * 
 * Verifies:
 * 1. Order calculation, GST calculation, discounts, and Indian Rupee WhatsApp dispatch receipts.
 * 2. Offline mock resilience and client discount bounds clamping.
 * 3. In-memory SQLite transaction lifecycle: orders, order_items, customer lifetime spend, and stock decrements.
 * 4. Full set vs single piece trade role authorization.
 * 5. Server-side coupon verification (percentage with max cap, flat, below minimum value, inactive).
 * 6. Order retrieval by order number, phone number formatting resilience, and status audit logging.
 * 7. Safe order deletion and all-orders summary feeds.
 */
class OrderManagerTest extends TestCase
{
    private ?PDO $sqlitePdo = null;

    protected function setUp(): void
    {
        parent::setUp();
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
        }
        Database::setPdo(null, true);
    }

    protected function tearDown(): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
        }
        Database::reset();
        $this->sqlitePdo = null;
        parent::tearDown();
    }

    /**
     * Build an in-memory SQLite database matching DT Brand's live production schema.
     */
    private function createSqliteDatabase(): PDO
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Register MySQL compatibility functions in SQLite
        if (method_exists($pdo, 'sqliteCreateFunction')) {
            $pdo->sqliteCreateFunction('NOW', static fn() => date('Y-m-d H:i:s'));
            $pdo->sqliteCreateFunction('now', static fn() => date('Y-m-d H:i:s'));
            $pdo->sqliteCreateFunction('GREATEST', static fn(...$args) => max($args));
            $pdo->sqliteCreateFunction('greatest', static fn(...$args) => max($args));
        }

        $pdo->exec("
            CREATE TABLE customers (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                phone TEXT NOT NULL,
                email TEXT DEFAULT '',
                password_hash TEXT DEFAULT '',
                type TEXT DEFAULT 'retail',
                status TEXT DEFAULT 'active',
                total_orders INTEGER DEFAULT 0,
                lifetime_spend REAL DEFAULT 0.0,
                created_at TEXT
            );

            CREATE TABLE products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                sku TEXT NOT NULL,
                title TEXT NOT NULL,
                mrp REAL NOT NULL,
                retail_price REAL NOT NULL,
                customer_price REAL DEFAULT 0.0,
                customer_sale_price REAL DEFAULT 0.0,
                sale_price REAL DEFAULT 0.0,
                wholesale_price REAL DEFAULT 0.0,
                reseller_price REAL DEFAULT 0.0,
                stock_qty INTEGER NOT NULL DEFAULT 0,
                status TEXT NOT NULL DEFAULT 'active',
                selling_type TEXT NOT NULL DEFAULT 'single_piece',
                primary_image TEXT DEFAULT '',
                created_at TEXT
            );

            CREATE TABLE product_variants (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                product_id INTEGER NOT NULL,
                color_name TEXT DEFAULT '',
                size_name TEXT DEFAULT '',
                sku TEXT NOT NULL,
                stock_qty INTEGER NOT NULL DEFAULT 0,
                price REAL DEFAULT 0.0,
                created_at TEXT
            );

            CREATE TABLE coupons (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                code TEXT NOT NULL,
                discount_type TEXT NOT NULL DEFAULT 'percentage',
                discount_value REAL NOT NULL DEFAULT 0.0,
                min_order_value REAL DEFAULT 0.0,
                max_discount REAL DEFAULT 0.0,
                status TEXT NOT NULL DEFAULT 'active',
                usage_limit INTEGER DEFAULT 1000,
                used_count INTEGER DEFAULT 0,
                times_used INTEGER DEFAULT 0,
                per_user_limit INTEGER DEFAULT 1,
                channel TEXT DEFAULT 'all',
                starts_at TEXT DEFAULT NULL,
                expires_at TEXT DEFAULT NULL,
                created_at TEXT
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

            CREATE TABLE orders (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_number TEXT NOT NULL UNIQUE,
                customer_id INTEGER DEFAULT 0,
                customer_name TEXT NOT NULL,
                customer_phone TEXT NOT NULL,
                shipping_address TEXT DEFAULT '',
                channel TEXT DEFAULT 'retail',
                subtotal REAL NOT NULL,
                discount REAL DEFAULT 0.0,
                gst_rate REAL DEFAULT 5.0,
                gst_amount REAL DEFAULT 0.0,
                shipping_fee REAL DEFAULT 0.0,
                total_amount REAL NOT NULL,
                payment_method TEXT DEFAULT 'razorpay',
                payment_status TEXT DEFAULT 'paid',
                fulfillment_status TEXT DEFAULT 'processing',
                order_status TEXT DEFAULT 'processing',
                tracking_number TEXT DEFAULT '',
                courier_name TEXT DEFAULT 'Delhivery Express',
                created_at TEXT
            );

            CREATE TABLE order_items (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_id INTEGER NOT NULL,
                product_id INTEGER NOT NULL,
                product_title TEXT NOT NULL,
                sku TEXT NOT NULL,
                selling_type TEXT DEFAULT 'single_piece',
                variant_color TEXT DEFAULT NULL,
                variant_size TEXT DEFAULT NULL,
                unit_price REAL NOT NULL,
                quantity INTEGER NOT NULL,
                total_price REAL NOT NULL
            );

            CREATE TABLE order_status_history (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                order_id INTEGER NOT NULL,
                previous_status TEXT NOT NULL,
                new_status TEXT NOT NULL,
                comment TEXT DEFAULT '',
                updated_by TEXT DEFAULT 'Admin',
                created_at TEXT
            );
        ");

        $this->sqlitePdo = $pdo;
        Database::setPdo($pdo, false);
        return $pdo;
    }

    public function testCreateOrderCalculation(): void
    {
        $orderData = [
            'customer_name' => 'Radhika Textiles',
            'customer_phone' => '+91 98765 43210',
            'channel' => 'wholesale',
            'items' => [
                ['price' => 3850.00, 'quantity' => 8], // 30,800
                ['price' => 3350.00, 'quantity' => 4]  // 13,400 -> subtotal = 44,200
            ],
            'discount' => 2000.00, // discounted subtotal = 42,200
            'shipping' => 0.0,
            'gst_rate' => 5.0 // gst 5% on 42,200 = 2,110 -> grand total = 44,310
        ];

        $order = OrderManager::createOrder($orderData);

        $this->assertIsArray($order);
        $this->assertStringStartsWith('DT-ORD-', $order['order_number']);
        $this->assertEquals(2, $order['items_count']);
        $this->assertEquals(44200.00, $order['pricing']['subtotal']);
        $this->assertEquals(2000.00, $order['pricing']['discount']);
        $this->assertEquals(2110.00, $order['pricing']['gst']);
        $this->assertEquals(44310.00, $order['pricing']['grand_total']);
        $this->assertStringContainsString('Namaste Radhika Textiles ji!', $order['whatsapp_notice']);
    }

    public function testGenerateWhatsAppNoticeFormatting(): void
    {
        $notice = OrderManager::generateWhatsAppNotice('DT-ORD-998877', 52500.00, 'Gautam');

        $this->assertStringContainsString('Namaste Gautam ji! 🙏', $notice);
        $this->assertStringContainsString('*DT-ORD-998877*', $notice);
        $this->assertStringContainsString('₹52,500.00', $notice);
        $this->assertStringContainsString('(GST 5% included)', $notice);
        $this->assertStringContainsString('authentic handlooms! 🌸', $notice);
    }

    public function testOfflineCreateOrderClampsDiscountAboveSubtotal(): void
    {
        $orderData = [
            'customer_name' => 'Ananya Sharma',
            'customer_phone' => '9876543210',
            'items' => [
                ['price' => 2500.00, 'quantity' => 2] // 5,000 subtotal
            ],
            'discount' => 12000.00, // Excessive client discount
            'shipping' => 100.00,
            'gst_rate' => 5.0
        ];

        $order = OrderManager::createOrder($orderData);

        // Clamped to subtotal (5,000)
        $this->assertEquals(5000.00, $order['pricing']['subtotal']);
        $this->assertEquals(5000.00, $order['pricing']['discount']);
        $this->assertEquals(0.00, $order['pricing']['taxable']);
        $this->assertEquals(0.00, $order['pricing']['gst']);
        $this->assertEquals(100.00, $order['pricing']['shipping']);
        $this->assertEquals(100.00, $order['pricing']['grand_total']);
    }

    public function testOfflineCreateOrderFailsWithZeroValidItems(): void
    {
        $orderData = [
            'customer_name' => 'Blank Order Customer',
            'customer_phone' => '9876543210',
            'items' => []
        ];

        $order = OrderManager::createOrder($orderData);

        $this->assertFalse($order['success']);
        $this->assertEquals('This order has no valid items.', $order['message']);
        $this->assertEquals(0, $order['items_count']);
        $this->assertEquals(0.0, $order['total_amount']);
    }

    public function testOfflineCreateOrderWithCustomShippingAndGst(): void
    {
        $orderData = [
            'customer_name' => 'Priya Boutique',
            'customer_phone' => '9123456780',
            'items' => [
                ['price' => 5000.00, 'quantity' => 2] // 10,000 subtotal
            ],
            'discount' => 1000.00, // 9,000 taxable
            'shipping' => 250.00,
            'gst_rate' => 12.0 // 12% GST = 1,080
        ];

        $order = OrderManager::createOrder($orderData);

        $this->assertEquals(10000.00, $order['pricing']['subtotal']);
        $this->assertEquals(1000.00, $order['pricing']['discount']);
        $this->assertEquals(9000.00, $order['pricing']['taxable']);
        $this->assertEquals(1080.00, $order['pricing']['gst']);
        $this->assertEquals(250.00, $order['pricing']['shipping']);
        $this->assertEquals(10330.00, $order['pricing']['grand_total']);
    }

    public function testInMemorySqliteOrderCreationAndStockDecrement(): void
    {
        $pdo = $this->createSqliteDatabase();

        // 1. Insert customer
        $pdo->exec("
            INSERT INTO customers (id, name, phone, email, type, status, total_orders, lifetime_spend, created_at)
            VALUES (101, 'Meera Patel', '9876500001', 'meera@example.com', 'retail', 'active', 0, 0.0, datetime('now'))
        ");

        // 2. Insert single piece product with 50 stock
        $pdo->exec("
            INSERT INTO products (id, sku, title, mrp, retail_price, customer_price, sale_price, wholesale_price, reseller_price, stock_qty, status, selling_type, created_at)
            VALUES (201, 'DT-KANJI-01', 'Pure Kanjivaram Silk Saree', 7500.00, 5200.00, 4800.00, 0.00, 3600.00, 4200.00, 50, 'active', 'single_piece', datetime('now'))
        ");

        $orderData = [
            'customer_id' => 101,
            'customer_name' => 'Meera Patel',
            'customer_phone' => '9876500001',
            'channel' => 'retail',
            'shipping_address' => '12 Gandhi Road, Surat, Gujarat',
            'items' => [
                ['id' => 201, 'quantity' => 5] // 5 * 4,800 = 24,000 -> 5% GST = 1,200 -> grand = 25,200
            ],
            'shipping' => 0.0,
            'gst_rate' => 5.0
        ];

        $order = OrderManager::createOrder($orderData);

        $this->assertTrue($order['success'], 'Order should succeed against in-memory SQLite');
        $this->assertGreaterThan(0, $order['id']);
        $this->assertEquals(24000.00, $order['pricing']['subtotal']);
        $this->assertEquals(1200.00, $order['pricing']['gst']);
        $this->assertEquals(25200.00, $order['total_amount']);

        // Check stock was decremented from 50 to 45
        $stock = (int)$pdo->query("SELECT stock_qty FROM products WHERE id = 201")->fetchColumn();
        $this->assertEquals(45, $stock);

        // Check customer total_orders and lifetime_spend incremented
        $cust = $pdo->query("SELECT total_orders, lifetime_spend FROM customers WHERE id = 101")->fetch();
        $this->assertEquals(1, (int)$cust['total_orders']);
        $this->assertEquals(25200.00, (float)$cust['lifetime_spend']);

        // Check order_items table row
        $itemRow = $pdo->query("SELECT * FROM order_items WHERE order_id = " . (int)$order['id'])->fetch();
        $this->assertNotEmpty($itemRow);
        $this->assertEquals(201, (int)$itemRow['product_id']);
        $this->assertEquals('DT-KANJI-01', $itemRow['sku']);
        $this->assertEquals(4800.00, (float)$itemRow['unit_price']);
        $this->assertEquals(5, (int)$itemRow['quantity']);
        $this->assertEquals(24000.00, (float)$itemRow['total_price']);
    }

    public function testInMemorySqliteOrderCreationWithFullSetSellingType(): void
    {
        $pdo = $this->createSqliteDatabase();

        // 1. Insert product with selling_type = 'full_set'
        $pdo->exec("
            INSERT INTO products (id, sku, title, mrp, retail_price, customer_price, sale_price, wholesale_price, reseller_price, stock_qty, status, selling_type, created_at)
            VALUES (301, 'DT-SET-BANARAS', 'Banarasi Bridal Catalogue Set', 12000.00, 9500.00, 9000.00, 0.00, 6500.00, 7500.00, 40, 'active', 'full_set', datetime('now'))
        ");

        // Insert 4 color variants for this catalogue set
        $pdo->exec("
            INSERT INTO product_variants (product_id, color_name, size_name, sku, stock_qty, price, created_at) VALUES
            (301, 'Ruby Red', 'Free Size', 'DT-SET-BANARAS-RED', 10, 6500.00, datetime('now')),
            (301, 'Emerald Green', 'Free Size', 'DT-SET-BANARAS-GRN', 10, 6500.00, datetime('now')),
            (301, 'Royal Blue', 'Free Size', 'DT-SET-BANARAS-BLU', 10, 6500.00, datetime('now')),
            (301, 'Mustard Gold', 'Free Size', 'DT-SET-BANARAS-GLD', 10, 6500.00, datetime('now'))
        ");

        // A. Retail/Guest channel attempt must fail authorization for full set
        $guestOrder = OrderManager::createOrder([
            'customer_name' => 'Guest Visitor',
            'channel' => 'retail',
            'items' => [['id' => 301, 'quantity' => 1]]
        ]);
        $this->assertFalse($guestOrder['success']);
        $this->assertStringContainsString('Full Set products are exclusively available to verified Retailers & Wholesalers', $guestOrder['message']);

        // B. Verified trade channel order
        $tradeOrder = OrderManager::createOrder([
            'customer_name' => 'Surat B2B Emporium',
            'customer_phone' => '9898000000',
            'channel' => 'wholesale',
            'is_trade_order' => true,
            'items' => [['id' => 301, 'quantity' => 2]] // 2 sets of 4 pieces = 8 total sarees @ 6,500 = 52,000
        ]);

        $this->assertTrue($tradeOrder['success']);
        // Subtotal = 6,500 * 4 pieces * 2 sets = 52,000
        $this->assertEquals(52000.00, $tradeOrder['pricing']['subtotal']);
        $this->assertEquals(2600.00, $tradeOrder['pricing']['gst']); // 5% GST = 2,600
        $this->assertEquals(54600.00, $tradeOrder['total_amount']);

        // Overall product stock decremented by 8 physical pieces (40 - 8 = 32)
        $stock = (int)$pdo->query("SELECT stock_qty FROM products WHERE id = 301")->fetchColumn();
        $this->assertEquals(32, $stock);

        // Each variant stock decremented by 2 (10 - 2 = 8)
        $vStock = (int)$pdo->query("SELECT stock_qty FROM product_variants WHERE product_id = 301 LIMIT 1")->fetchColumn();
        $this->assertEquals(8, $vStock);
    }

    public function testInMemorySqliteOrderCreationRejectsDraftAndOutOfStock(): void
    {
        $pdo = $this->createSqliteDatabase();

        $pdo->exec("
            INSERT INTO products (id, sku, title, mrp, retail_price, stock_qty, status, created_at)
            VALUES 
            (401, 'DT-DRAFT-01', 'Upcoming Festive Launch Saree', 5000.00, 3500.00, 20, 'draft', datetime('now')),
            (402, 'DT-SOLD-01', 'Rare Vintage Brocade Saree', 8000.00, 6000.00, 0, 'out_of_stock', datetime('now'))
        ");

        $draftOrder = OrderManager::createOrder([
            'customer_name' => 'Early Shopper',
            'items' => [['id' => 401, 'quantity' => 1]]
        ]);
        $this->assertFalse($draftOrder['success']);
        $this->assertStringContainsString('not available', $draftOrder['message']);

        $soldOrder = OrderManager::createOrder([
            'customer_name' => 'Late Shopper',
            'items' => [['id' => 402, 'quantity' => 1]]
        ]);
        $this->assertFalse($soldOrder['success']);
        $this->assertStringContainsString('not available', $soldOrder['message']);
    }

    public function testInMemorySqliteOrderCreationMissingProductHandled(): void
    {
        $this->createSqliteDatabase();

        $order = OrderManager::createOrder([
            'customer_name' => 'Lost Item Shopper',
            'items' => [['id' => 9999, 'quantity' => 1]]
        ]);

        $this->assertFalse($order['success']);
        $this->assertStringContainsString('These products are no longer available: #9999', $order['message']);
    }

    public function testInMemorySqliteOrderCreationServerSideCouponValidation(): void
    {
        $pdo = $this->createSqliteDatabase();

        // Active 10% coupon with max discount of 2,000, minimum order 5,000
        $pdo->exec("
            INSERT INTO coupons (id, code, discount_type, discount_value, min_order_value, max_discount, status, created_at)
            VALUES 
            (1, 'DIWALI10', 'percentage', 10.0, 5000.0, 2000.0, 'active', datetime('now')),
            (2, 'FLAT500', 'flat', 500.0, 3000.0, 0.0, 'active', datetime('now')),
            (3, 'EXPIRED20', 'percentage', 20.0, 1000.0, 5000.0, 'inactive', datetime('now'))
        ");

        $pdo->exec("
            INSERT INTO products (id, sku, title, mrp, retail_price, customer_price, stock_qty, status, created_at)
            VALUES (501, 'DT-COUPON-PRD', 'Designer Silk Saree', 10000.00, 8000.00, 8000.00, 50, 'active', datetime('now'))
        ");

        // A. Valid percentage coupon DIWALI10 on 2 units = 16,000 subtotal -> 10% is 1,600 (under 2,000 cap)
        // Client attempts to claim 3,000 discount — server ignores and grants authoritative 1,600
        $order1 = OrderManager::createOrder([
            'customer_name' => 'Coupon Hunter',
            'coupon_code' => 'DIWALI10',
            'discount' => 3000.00, // Tampered client value
            'items' => [['id' => 501, 'quantity' => 2]]
        ]);
        $this->assertTrue($order1['success']);
        $this->assertEquals(16000.00, $order1['pricing']['subtotal']);
        $this->assertEquals(1600.00, $order1['pricing']['discount']);
        $this->assertEquals(14400.00, $order1['pricing']['taxable']);
        $this->assertEquals(720.00, $order1['pricing']['gst']); // 5% of 14,400

        // B. Flat coupon FLAT500 on 1 unit = 8,000 subtotal
        $order2 = OrderManager::createOrder([
            'customer_name' => 'Flat Coupon User',
            'coupon_code' => 'FLAT500',
            'items' => [['id' => 501, 'quantity' => 1]]
        ]);
        $this->assertTrue($order2['success']);
        $this->assertEquals(8000.00, $order2['pricing']['subtotal']);
        $this->assertEquals(500.00, $order2['pricing']['discount']);

        // C. Inactive coupon EXPIRED20 yields 0.00 discount
        $order3 = OrderManager::createOrder([
            'customer_name' => 'Inactive Coupon User',
            'coupon_code' => 'EXPIRED20',
            'items' => [['id' => 501, 'quantity' => 1]]
        ]);
        $this->assertTrue($order3['success']);
        $this->assertEquals(0.00, $order3['pricing']['discount']);
    }

    public function testInMemorySqliteGetOrderDetailsAndLineItems(): void
    {
        $pdo = $this->createSqliteDatabase();

        $pdo->exec("
            INSERT INTO products (id, sku, title, mrp, retail_price, customer_price, stock_qty, status, created_at)
            VALUES (601, 'DT-TEST-01', 'Kalamkari Handloom Saree', 4500.00, 3200.00, 3200.00, 10, 'active', datetime('now'))
        ");

        $created = OrderManager::createOrder([
            'customer_name' => 'Kavita Joshi',
            'customer_phone' => '+91 94280 12345',
            'shipping_address' => '404 Lotus Residency, Ahmedabad',
            'items' => [['id' => 601, 'quantity' => 2]]
        ]);
        $this->assertTrue($created['success']);
        $orderNo = $created['order_number'];

        // Retrieve by order number
        $fetched = OrderManager::getByOrderNumber($orderNo);
        $this->assertNotNull($fetched);
        $this->assertEquals($orderNo, $fetched['order_number']);
        $this->assertEquals('Kavita Joshi', $fetched['customer_name']);
        $this->assertCount(1, $fetched['items']);
        $this->assertEquals('DT-TEST-01', $fetched['items'][0]['sku']);
        $this->assertEquals(2, (int)$fetched['items'][0]['quantity']);

        // Retrieve by DB numeric ID
        $fetchedById = OrderManager::getOrderDetails((int)$fetched['id']);
        $this->assertNotNull($fetchedById);
        $this->assertEquals($orderNo, $fetchedById['order_number']);
    }

    public function testInMemorySqliteGetByPhone(): void
    {
        $pdo = $this->createSqliteDatabase();

        $pdo->exec("
            INSERT INTO products (id, sku, title, mrp, retail_price, customer_price, stock_qty, status, primary_image, created_at)
            VALUES (701, 'DT-TEL-01', 'Patola Silk Saree', 15000.00, 11000.00, 11000.00, 15, 'active', '/assets/images/patola.png', datetime('now'))
        ");

        $order1 = OrderManager::createOrder([
            'customer_name' => 'Rohit Verma',
            'customer_phone' => '+91 99887 76655',
            'items' => [['id' => 701, 'quantity' => 1]]
        ]);
        $this->assertTrue($order1['success']);

        // Query by pure 10 digits
        $results = OrderManager::getByPhone('9988776655');
        $this->assertCount(1, $results);
        $this->assertEquals($order1['order_number'], $results[0]['order_number']);
        $this->assertEquals('/assets/images/patola.png', $results[0]['items'][0]['img']);

        // Query by formatted phone number
        $formattedResults = OrderManager::getByPhone('+91 99887 76655');
        $this->assertCount(1, $formattedResults);
    }

    public function testInMemorySqliteUpdateStatusAndAuditTrail(): void
    {
        $pdo = $this->createSqliteDatabase();

        $pdo->exec("
            INSERT INTO products (id, sku, title, mrp, retail_price, customer_price, stock_qty, status, created_at)
            VALUES (801, 'DT-DISPATCH-01', 'Chanderi Zari Saree', 6000.00, 4200.00, 4200.00, 10, 'active', datetime('now'))
        ");

        $order = OrderManager::createOrder([
            'customer_name' => 'Aarti Shah',
            'customer_phone' => '9876543219',
            'items' => [['id' => 801, 'quantity' => 1]]
        ]);
        $this->assertTrue($order['success']);
        $orderNo = $order['order_number'];

        // Update status to dispatched with courier and AWB tracking
        $updated = OrderManager::updateStatus($orderNo, 'dispatched', 'DEL-AWB-9988', 'Delhivery Express', 'Dispatch Manager');
        $this->assertTrue($updated);

        // Verify orders table
        $stmt = $pdo->prepare("SELECT fulfillment_status, tracking_number, courier_name FROM orders WHERE order_number = ?");
        $stmt->execute([$orderNo]);
        $row = $stmt->fetch();
        $this->assertEquals('dispatched', $row['fulfillment_status']);
        $this->assertEquals('DEL-AWB-9988', $row['tracking_number']);
        $this->assertEquals('Delhivery Express', $row['courier_name']);

        // Verify order_status_history table
        $history = $pdo->query("SELECT * FROM order_status_history WHERE order_id = " . (int)$order['id'])->fetch();
        $this->assertNotEmpty($history);
        $this->assertEquals('dispatched', $history['new_status']);
        $this->assertEquals('Dispatch Manager', $history['updated_by']);
        $this->assertStringContainsString('AWB: DEL-AWB-9988', $history['comment']);
    }

    public function testInMemorySqliteDeleteOrder(): void
    {
        $pdo = $this->createSqliteDatabase();

        $pdo->exec("
            INSERT INTO products (id, sku, title, mrp, retail_price, customer_price, stock_qty, status, created_at)
            VALUES (901, 'DT-DEL-01', 'Paithani Silk Saree', 8000.00, 5500.00, 5500.00, 5, 'active', datetime('now'))
        ");

        $order = OrderManager::createOrder([
            'customer_name' => 'Delete Test Customer',
            'customer_phone' => '9876509876',
            'items' => [['id' => 901, 'quantity' => 1]]
        ]);
        $this->assertTrue($order['success']);
        $orderNo = $order['order_number'];

        $deleteRes = OrderManager::deleteOrder($orderNo);
        $this->assertTrue($deleteRes);

        $check = $pdo->query("SELECT COUNT(*) FROM orders WHERE order_number = '{$orderNo}'")->fetchColumn();
        $this->assertEquals(0, (int)$check);
    }

    public function testInMemorySqliteGetAllOrders(): void
    {
        $pdo = $this->createSqliteDatabase();

        $pdo->exec("
            INSERT INTO products (id, sku, title, mrp, retail_price, customer_price, stock_qty, status, created_at)
            VALUES (1001, 'DT-ALL-01', 'Tussar Silk Saree', 4000.00, 3000.00, 3000.00, 20, 'active', datetime('now'))
        ");

        OrderManager::createOrder([
            'customer_name' => 'Customer Alpha',
            'customer_phone' => '9800000001',
            'items' => [['id' => 1001, 'quantity' => 1]]
        ]);

        OrderManager::createOrder([
            'customer_name' => 'Customer Beta',
            'customer_phone' => '9800000002',
            'items' => [['id' => 1001, 'quantity' => 3]]
        ]);

        $all = OrderManager::getAll();
        $this->assertCount(2, $all);
        $this->assertEquals('Customer Beta', $all[0]['customer']); // Most recent first
        $this->assertEquals('Customer Alpha', $all[1]['customer']);
        $this->assertEquals('Tussar Silk Saree', $all[0]['items_summary']);
    }

    public function testGuestCustomerAutoRegistrationOnCheckout(): void
    {
        $pdo = $this->createSqliteDatabase();

        $pdo->exec("
            INSERT INTO products (id, sku, title, mrp, retail_price, customer_price, stock_qty, status, created_at)
            VALUES (1101, 'DT-AUTO-01', 'Bandhani Silk Saree', 3500.00, 2600.00, 2600.00, 15, 'active', datetime('now'))
        ");

        $order = OrderManager::createOrder([
            'customer_name' => 'New Guest User',
            'customer_phone' => '9777788888',
            'customer_email' => 'guest@example.in',
            'channel' => 'retail',
            'items' => [['id' => 1101, 'quantity' => 1]]
        ]);

        $this->assertTrue($order['success']);

        // Check customer was auto-created
        $cust = $pdo->query("SELECT * FROM customers WHERE phone = '9777788888'")->fetch();
        $this->assertNotEmpty($cust);
        $this->assertEquals('New Guest User', $cust['name']);
        $this->assertEquals('guest@example.in', $cust['email']);
        $this->assertEquals('active', $cust['status']);
        $this->assertEquals(1, (int)$cust['total_orders']);
    }

    public function testChannelResolutionAuthenticatedCustomer(): void
    {
        $pdo = $this->createSqliteDatabase();

        // Reseller customer
        $pdo->exec("
            INSERT INTO customers (id, name, phone, email, type, status, created_at)
            VALUES (1201, 'Vandana Reseller', '9898989898', 'vandana@reseller.in', 'reseller', 'active', datetime('now'))
        ");

        $pdo->exec("
            INSERT INTO products (id, sku, title, mrp, retail_price, customer_price, wholesale_price, reseller_price, stock_qty, status, created_at)
            VALUES (1202, 'DT-RESELL-01', 'Kanchipuram Brocade Saree', 9000.00, 6800.00, 6500.00, 4800.00, 5400.00, 20, 'active', datetime('now'))
        ");

        // Simulate session logged in
        $_SESSION['user'] = ['id' => 1201];

        $order = OrderManager::createOrder([
            'customer_name' => 'Vandana Reseller',
            'items' => [['id' => 1202, 'quantity' => 2]]
        ]);

        $this->assertTrue($order['success']);
        $this->assertEquals('reseller', $order['channel']);
        // Reseller unit price is 5,400 -> subtotal = 10,800
        $this->assertEquals(10800.00, $order['pricing']['subtotal']);
    }

    public function testAdminCanOrderOnAnyAllowedChannel(): void
    {
        $pdo = $this->createSqliteDatabase();

        $pdo->exec("
            INSERT INTO products (id, sku, title, mrp, retail_price, customer_price, wholesale_price, stock_qty, status, created_at)
            VALUES (1301, 'DT-ADMIN-01', 'Zari Border Silk Saree', 7000.00, 5000.00, 4800.00, 3500.00, 30, 'active', datetime('now'))
        ");

        // Admin logged in
        $_SESSION['admin_logged_in'] = true;

        $order = OrderManager::createOrder([
            'customer_name' => 'Manual Phone Booking',
            'customer_phone' => '9900990099',
            'channel' => 'wholesale',
            'items' => [['id' => 1301, 'quantity' => 4]]
        ]);

        $this->assertTrue($order['success']);
        $this->assertEquals('wholesale', $order['channel']);
        // Wholesale unit price is 3,500 -> subtotal = 14,000
        $this->assertEquals(14000.00, $order['pricing']['subtotal']);
    }
}
