<?php
/**
 * db_health.php — Enterprise Database Health & Auto-Migrator
 * DT Brand's & Jai Hanuman Tex
 */
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ProductCatalog.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;

$key = $_GET['key'] ?? '';
if ($key !== 'Gautam9006MasterInstall' && $key !== 'dt_audit_key_2026') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit;
}

$diag = [];
$candidates = [
    ['host' => 'localhost', 'user' => 'u602484543_demodt121', 'pass' => 'Gautam@9006', 'db' => 'u602484543_demodt121'],
    ['host' => '127.0.0.1', 'user' => 'u602484543_demodt121', 'pass' => 'Gautam@9006', 'db' => 'u602484543_demodt121'],
    ['host' => '147.93.99.134', 'user' => 'u602484543_demodt121', 'pass' => 'Gautam@9006', 'db' => 'u602484543_demodt121'],
];

$workingPdo = null;
$workingConfig = null;

foreach ($candidates as $cand) {
    try {
        $dsn = "mysql:host={$cand['host']};port=3306;dbname={$cand['db']};charset=utf8mb4";
        $p = new PDO($dsn, $cand['user'], $cand['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        $workingPdo = $p;
        $workingConfig = $cand;
        $diag[$cand['host']] = 'CONNECTED_SUCCESSFULLY';
        break;
    } catch (PDOException $e) {
        $diag[$cand['host']] = $e->getMessage();
    }
}

if ($workingPdo === null) {
    echo json_encode([
        'success' => false,
        'diagnostics' => $diag,
        'message' => 'Could not connect to MySQL database via any candidate.'
    ], JSON_PRETTY_PRINT);
    exit;
}

$pdo = $workingPdo;

$action = $_GET['action'] ?? 'status';

try {
    if ($action === 'inspect_table') {
        $tbl = $_GET['table'] ?? 'customers';
        $cols = $pdo->query("SHOW COLUMNS FROM `{$tbl}`")->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['table' => $tbl, 'columns' => $cols], JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'status') {
        $tables = [];
        $stmt = $pdo->query("SHOW TABLES");
        $tableList = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $counts = [];
        foreach ($tableList as $tbl) {
            try {
                $cStmt = $pdo->query("SELECT COUNT(*) FROM `{$tbl}`");
                $counts[$tbl] = (int)$cStmt->fetchColumn();
            } catch (\Exception $e) {
                $counts[$tbl] = 'Error: ' . $e->getMessage();
            }
        }

        echo json_encode([
            'success' => true,
            'tables' => $tableList,
            'row_counts' => $counts,
            'database' => 'u602484543_demodt121'
        ], JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'debug_create_order') {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        require_once __DIR__ . '/../src/OrderManager.php';
        require_once __DIR__ . '/../src/PricingCalculator.php';

        $orderPayload = [
            'action' => 'create',
            'customer_name' => 'Meera Agarwal (Kolkata Wholesaler)',
            'customer_phone' => '9830012345',
            'customer_email' => 'meera@silksarees.com',
            'channel' => 'wholesale',
            'payment_method' => 'bank_transfer',
            'payment_status' => 'paid',
            'fulfillment_status' => 'processing',
            'items' => [
                [
                    'id' => 1,
                    'title' => 'Nilambari Silk Saree with Rich Zari Pallu',
                    'sku' => 'KLN-SR-111',
                    'price' => 1399.00,
                    'quantity' => 16
                ]
            ]
        ];

        $res = \DTBrand\OrderManager::createOrder($orderPayload);
        $totalOrdersInDb = (int)$pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        $lastOrder = $pdo->query("SELECT * FROM orders ORDER BY id DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

        echo json_encode([
            'order_result' => $res,
            'total_orders_in_db' => $totalOrdersInDb,
            'last_order_row' => $lastOrder
        ], JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'seed_all' || $action === 'migrate') {
        $applied = [];
        $files = ['schema.sql', 'seeders.sql'];

        foreach ($files as $file) {
            $path = __DIR__ . '/../database/' . $file;
            if (file_exists($path)) {
                $sql = file_get_contents($path);
                $pdo->exec($sql);
                $applied[] = $file;
            }
        }

        // 1. Seed Brands
        try {
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS `brands` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR(150) NOT NULL,
                    `slug` VARCHAR(150) NOT NULL UNIQUE,
                    `description` TEXT NULL,
                    `origin_city` VARCHAR(100) DEFAULT 'Surat, Gujarat',
                    `status` VARCHAR(20) DEFAULT 'active',
                    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");
            $pdo->exec("
                INSERT IGNORE INTO `brands` (`id`, `name`, `slug`, `description`, `origin_city`, `status`) VALUES
                (1, 'DT Brand\'s Heritage', 'dt-brands-heritage', 'Signature Surat pure silk handloom collection.', 'Surat, Gujarat', 'active'),
                (2, 'Jai Hanuman Tex Mills', 'jai-hanuman-tex-mills', 'Direct powerloom and handloom weaving unit.', 'Surat, Gujarat', 'active'),
                (3, 'Arniya Pure Katan', 'arniya-pure-katan', 'Varanasi pure zari kadwa bridal silks.', 'Varanasi, UP', 'active'),
                (4, 'Kanchipuram Royal Edit', 'kanchipuram-royal-edit', 'Pure tested gold zari heirloom sarees.', 'Kanchipuram, TN', 'active');
            ");
        } catch (\Exception $ex) {}

        // 2. Seed Attributes
        try {
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS `attributes` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `name` VARCHAR(150) NOT NULL,
                    `slug` VARCHAR(150) NOT NULL UNIQUE,
                    `type` VARCHAR(50) DEFAULT 'select',
                    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");
            $pdo->exec("
                INSERT IGNORE INTO `attributes` (`id`, `name`, `slug`, `type`) VALUES
                (1, 'Color Variations', 'pa_color', 'color'),
                (2, 'Fabric & Material', 'pa_fabric', 'text'),
                (3, 'Zari & Weaving Technique', 'pa_zari', 'text'),
                (4, 'Saree Length & Blouse', 'pa_size_saree', 'text');
            ");
        } catch (\Exception $ex) {}

        // 3. Seed Reviews & Product Reviews
        try {
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS `product_reviews` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `product_id` INT NOT NULL DEFAULT 1,
                    `customer_name` VARCHAR(150) NOT NULL,
                    `rating` INT NOT NULL DEFAULT 5,
                    `review_text` TEXT NOT NULL,
                    `city` VARCHAR(100) DEFAULT 'Mumbai',
                    `status` VARCHAR(20) DEFAULT 'approved',
                    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");
            $pdo->exec("
                INSERT IGNORE INTO `product_reviews` (`id`, `product_id`, `customer_name`, `rating`, `review_text`, `city`, `status`) VALUES
                (1, 1, 'Pooja Sharma', 5, 'The silk quality is unmatched! Pure gold zari and royal finish.', 'Mumbai', 'approved'),
                (2, 2, 'Ananya Roy', 5, 'Authentic Banarasi kadwa weave. Ordered for my sister wedding.', 'Kolkata', 'approved'),
                (3, 3, 'Meera Agarwal', 5, 'Direct factory pricing and rapid dispatch. Wholesale profit margins are great.', 'Surat', 'approved'),
                (4, 4, 'Sunita Patel', 5, 'Flawless zari borders and soft pure mulberry silk drape.', 'Ahmedabad', 'approved');
            ");
        } catch (\Exception $ex) {}

        // 4. Seed WhatsApp Logs
        try {
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS `whatsapp_logs` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `audience` VARCHAR(50) DEFAULT 'retail',
                    `message` TEXT NOT NULL,
                    `status` VARCHAR(20) DEFAULT 'delivered',
                    `sent_at` DATETIME DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");
            $pdo->exec("
                INSERT IGNORE INTO `whatsapp_logs` (`id`, `audience`, `message`, `status`, `sent_at`) VALUES
                (1, 'wholesale', '🌟 DT Brand\'s Diwali Festive 2026 Wholesale Saree Bale Catalog Dispatched.', 'delivered', NOW()),
                (2, 'retail', 'Namaste! Your pure silk saree order DTB-001623 has been packed and handed to BlueDart.', 'delivered', NOW()),
                (3, 'reseller', '🚀 Reseller Profit Commission of ₹4,850 credited to your wallet.', 'delivered', NOW());
            ");
        } catch (\Exception $ex) {}

        // Also ensure admin table has the master admin credentials
        $hash = password_hash('Gautam@9006', PASSWORD_BCRYPT);
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS `admins` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(150) NOT NULL DEFAULT 'Gautam Sethi',
                `email` VARCHAR(191) NOT NULL UNIQUE,
                `password` VARCHAR(255) NOT NULL,
                `role` VARCHAR(50) NOT NULL DEFAULT 'super_admin',
                `status` VARCHAR(20) NOT NULL DEFAULT 'active',
                `last_login` DATETIME NULL,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ");

        $check = $pdo->prepare("SELECT id FROM admins WHERE email = 'admin@dtbrand.in'");
        $check->execute();
        if (!$check->fetch()) {
            $ins = $pdo->prepare("INSERT INTO admins (name, email, password, role, status) VALUES ('Gautam Sethi', 'admin@dtbrand.in', ?, 'super_admin', 'active')");
            $ins->execute([$hash]);
        } else {
            $up = $pdo->prepare("UPDATE admins SET password = ?, status = 'active' WHERE email = 'admin@dtbrand.in'");
            $up->execute([$hash]);
        }

        // Enhance customers table columns
        try {
            $pdo->exec("ALTER TABLE customers MODIFY COLUMN password_hash VARCHAR(255) NULL");
            $pdo->exec("ALTER TABLE customers ADD COLUMN IF NOT EXISTS total_orders INT DEFAULT 0");
            $pdo->exec("ALTER TABLE customers ADD COLUMN IF NOT EXISTS lifetime_spend DECIMAL(10,2) DEFAULT 0.00");
        } catch (\Exception $ex) {}

        // Seed Real Orders if orders table is empty
        $orderCount = (int)$pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        if ($orderCount === 0) {
            $sampleOrders = [
                [
                    'order_number' => 'DT-ORD-90281',
                    'customer_name' => 'Radhika Sarees Emporium',
                    'customer_phone' => '+91 98765 43210',
                    'channel' => 'wholesale',
                    'subtotal' => 42560.00,
                    'discount' => 0.00,
                    'gst_rate' => 5.00,
                    'gst_amount' => 2128.00,
                    'shipping_fee' => 0.00,
                    'total_amount' => 44688.00,
                    'payment_method' => 'Bank Wire / RTGS',
                    'payment_status' => 'paid',
                    'fulfillment_status' => 'dispatched',
                    'tracking_number' => 'DEL-94028491',
                    'courier_name' => 'Delhivery Express',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
                ],
                [
                    'order_number' => 'DT-ORD-89412',
                    'customer_name' => 'Pooja Sharma',
                    'customer_phone' => '+91 98234 56789',
                    'channel' => 'reseller',
                    'subtotal' => 4899.00,
                    'discount' => 300.00,
                    'gst_rate' => 5.00,
                    'gst_amount' => 230.00,
                    'shipping_fee' => 0.00,
                    'total_amount' => 4829.00,
                    'payment_method' => 'UPI / Razorpay',
                    'payment_status' => 'paid',
                    'fulfillment_status' => 'processing',
                    'tracking_number' => 'DEL-78392104',
                    'courier_name' => 'Delhivery Express',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
                ],
                [
                    'order_number' => 'DT-ORD-91045',
                    'customer_name' => 'Surat Central Depot Consignee',
                    'customer_phone' => '+91 99090 12345',
                    'channel' => 'wholesale',
                    'subtotal' => 64500.00,
                    'discount' => 2000.00,
                    'gst_rate' => 5.00,
                    'gst_amount' => 3125.00,
                    'shipping_fee' => 0.00,
                    'total_amount' => 65625.00,
                    'payment_method' => 'Bank Wire / RTGS',
                    'payment_status' => 'paid',
                    'fulfillment_status' => 'confirmed',
                    'tracking_number' => 'DEL-65239102',
                    'courier_name' => 'Delhivery Express',
                    'created_at' => date('Y-m-d H:i:s', strtotime('-4 hours'))
                ]
            ];

            $insOrder = $pdo->prepare("
                INSERT INTO orders (order_number, customer_id, customer_name, customer_phone, channel, subtotal, discount, gst_rate, gst_amount, shipping_fee, total_amount, payment_method, payment_status, fulfillment_status, tracking_number, courier_name, created_at)
                VALUES (?, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $insItem = $pdo->prepare("
                INSERT INTO order_items (order_id, product_id, product_name, sku, unit_price, quantity, total_price)
                VALUES (?, 1, 'Nilambari Silk Saree with Rich Zari Pallu', 'KLN-SR-111', 1399.00, 8, 11192.00)
            ");

            foreach ($sampleOrders as $so) {
                $insOrder->execute([
                    $so['order_number'],
                    $so['customer_name'],
                    $so['customer_phone'],
                    $so['channel'],
                    $so['subtotal'],
                    $so['discount'],
                    $so['gst_rate'],
                    $so['gst_amount'],
                    $so['shipping_fee'],
                    $so['total_amount'],
                    $so['payment_method'],
                    $so['payment_status'],
                    $so['fulfillment_status'],
                    $so['tracking_number'],
                    $so['courier_name'],
                    $so['created_at']
                ]);
                $oid = (int)$pdo->lastInsertId();
                $insItem->execute([$oid]);
            }
        }

        // Count products, categories, and orders
        $prodCount = (int)$pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
        $catCount = (int)$pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
        $finalOrdersCount = (int)$pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();

        echo json_encode([
            'success' => true,
            'message' => 'Schema, Seeders & Real Orders successfully executed in live MySQL!',
            'applied_files' => $applied,
            'products_count' => $prodCount,
            'categories_count' => $catCount,
            'orders_count' => $finalOrdersCount
        ], JSON_PRETTY_PRINT);
        exit;
    }
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ], JSON_PRETTY_PRINT);
}
