<?php
/**
 * db_health.php — Enterprise Database Health & Auto-Migrator
 * DT Brand's & Jai Hanuman Tex
 */
header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;

// Admin-only. This endpoint can run migrations, ALTER the customers table and
// INSERT into `users` (i.e. mint an admin account), so it is one of the most
// powerful routes in the project.
//
// It used to be gated solely by a URL key compared against two string literals
// held in this file:
//     if ($key !== 'Gautam9006MasterInstall' && $key !== 'dt_audit_key_2026')
// Those literals are committed to the repository, so the "secret" was public to
// anyone who could read the source, and it travelled in the query string where
// it lands in browser history, proxy logs and server access logs. It is now
// gated by the same admin session as the console. The single caller is the
// "View JSON Status" link on admin/system/index.php, which is a normal
// same-origin navigation and so carries the session cookie.
dt_api_require_admin('run database diagnostics');

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
        // The table name is interpolated into the statement, so it must be
        // validated against the real table list rather than trusted. It was
        // previously dropped straight into SHOW COLUMNS FROM `{$tbl}`, where a
        // backtick in the parameter breaks out of the quoting.
        $known = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        if (!in_array($tbl, $known, true)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Unknown table.',
                'available' => $known
            ], JSON_PRETTY_PRINT);
            exit;
        }
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
                INSERT IGNORE INTO `brands` (`id`, `name`, `slug`, `logo`, `description`, `status`, `created_at`) VALUES
                (1, 'DT Brand\'s Heritage', 'dt-brands-heritage', '/assets/images/brand-logo.png', 'Signature Surat pure silk handloom collection.', 'active', NOW()),
                (2, 'Jai Hanuman Tex Mills', 'jai-hanuman-tex-mills', '/assets/images/brand-logo.png', 'Direct powerloom and handloom weaving unit.', 'active', NOW()),
                (3, 'Arniya Pure Katan', 'arniya-pure-katan', '/assets/images/brand-logo.png', 'Varanasi pure zari kadwa bridal silks.', 'active', NOW()),
                (4, 'Kanchipuram Royal Edit', 'kanchipuram-royal-edit', '/assets/images/brand-logo.png', 'Pure tested gold zari heirloom sarees.', 'active', NOW());
            ");
        } catch (\Exception $ex) {}

        // 2. Seed Attributes
        try {
            $pdo->exec("
                INSERT IGNORE INTO `attributes` (`id`, `name`, `slug`, `type`) VALUES
                (1, 'Color Variations', 'pa_color', 'color'),
                (2, 'Fabric & Material', 'pa_fabric', 'text'),
                (3, 'Zari & Weaving Technique', 'pa_zari', 'text'),
                (4, 'Saree Length & Blouse', 'pa_size_saree', 'text');
            ");
        } catch (\Exception $ex) {}

        // 3. Seed Reviews
        try {
            $pdo->exec("
                INSERT IGNORE INTO `reviews` (`id`, `product_id`, `customer_name`, `rating`, `review_title`, `review_text`, `verified_buyer`, `status`, `created_at`) VALUES
                (1, 1, 'Pooja Sharma', 5, 'Royal Kanjivaram Silk', 'Pure silk with rich zari borders.', 1, 'approved', NOW()),
                (2, 2, 'Ananya Roy', 5, 'Stunning Banarasi Brocade', 'Great color vibrancy and heavy pallu.', 1, 'approved', NOW());
            ");
        } catch (\Exception $ex) {}

        // 4. Seed WhatsApp Logs
        try {
            $pdo->exec("
                INSERT IGNORE INTO `whatsapp_logs` (`id`, `recipient_phone`, `template_name`, `message_type`, `payload`, `status`, `created_at`) VALUES
                (1, '917046363528', 'dt_order_placed_v1', 'template', '{\"order_id\":\"DTB-001623\"}', 'delivered', NOW()),
                (2, '919822019283', 'b2b_wholesale_quote', 'document', '{\"quote_id\":\"Q-9921\"}', 'delivered', NOW()),
                (3, '919811029381', 'dt_dispatch_tracking_v2', 'template', '{\"awb\":\"DLV-991823\"}', 'delivered', NOW());
            ");
        } catch (\Exception $ex) {}

        // Ensure an administrator exists in the real `users` table (the admin
        // console authenticates against `users`, not a separate `admins` table).
        // Seed only when the table is empty and never overwrite an existing
        // admin's chosen password.
        try {
            $adminCount = (int)$pdo->query("SELECT COUNT(*) FROM `users`")->fetchColumn();
            if ($adminCount === 0) {
                $adminEmail = strtolower(trim(getenv('ADMIN_EMAIL') ?: 'admin@dtbrand.in'));
                $adminPass  = getenv('ADMIN_PASSWORD') ?: 'Gautam@9006';
                $adminName  = getenv('ADMIN_NAME') ?: 'DT Brand Admin';
                $hash = password_hash($adminPass, PASSWORD_BCRYPT);
                $ins = $pdo->prepare("INSERT INTO `users` (name, email, password_hash, role, status, created_at) VALUES (?, ?, ?, 'super_admin', 'active', NOW())");
                $ins->execute([$adminName, $adminEmail, $hash]);
            }
        } catch (\Exception $ex) {}

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
