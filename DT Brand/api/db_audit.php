<?php
/**
 * db_audit.php — Live Database Table & Schema Auditor & Auto-Migration Engine
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../src/Database.php';
use DTBrand\Database;

$token = $_GET['token'] ?? ($_POST['token'] ?? '');
if ($token !== 'DTBrand_Secret_2026') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.'], JSON_PRETTY_PRINT);
    exit;
}

try {
    $pdo = Database::getConnection();
    if ($pdo === null || Database::isMockMode()) {
        echo json_encode(['success' => false, 'message' => 'Database connection unavailable or in mock mode.'], JSON_PRETTY_PRINT);
        exit;
    }

    // 1. Get all current tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(\PDO::FETCH_COLUMN);

    // 2. Ensure all Recommended DT Brand ERP Tables Exist
    $recommended_tables_sql = [
        "categories" => "CREATE TABLE IF NOT EXISTS `categories` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(255) NOT NULL,
            `slug` VARCHAR(255) NOT NULL UNIQUE,
            `description` TEXT NULL,
            `image` VARCHAR(500) NULL,
            `display_order` INT DEFAULT 0,
            `status` ENUM('active', 'inactive') DEFAULT 'active',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "products" => "CREATE TABLE IF NOT EXISTS `products` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `title` VARCHAR(255) NOT NULL,
            `slug` VARCHAR(255) NOT NULL UNIQUE,
            `sku` VARCHAR(100) NOT NULL UNIQUE,
            `category` VARCHAR(100) NOT NULL,
            `fabric` VARCHAR(255) NULL,
            `description` TEXT NULL,
            `price` DECIMAL(10,2) NOT NULL,
            `retail_price` DECIMAL(10,2) NOT NULL,
            `wholesale_price` DECIMAL(10,2) NOT NULL,
            `reseller_price` DECIMAL(10,2) NULL,
            `mrp` DECIMAL(10,2) NULL,
            `old_price` DECIMAL(10,2) NULL,
            `stock_qty` INT DEFAULT 0,
            `moq` INT DEFAULT 1,
            `rating` DECIMAL(3,2) DEFAULT 5.00,
            `reviews_count` INT DEFAULT 0,
            `image` VARCHAR(500) NULL,
            `status` ENUM('in_stock', 'low_stock', 'out_of_stock', 'draft', 'active') DEFAULT 'in_stock',
            `featured` TINYINT(1) DEFAULT 0,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "customers" => "CREATE TABLE IF NOT EXISTS `customers` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(255) NOT NULL,
            `business_name` VARCHAR(255) NULL,
            `phone` VARCHAR(20) NOT NULL UNIQUE,
            `email` VARCHAR(255) NULL,
            `tier` ENUM('retail', 'wholesale', 'reseller', 'vip') DEFAULT 'retail',
            `status` ENUM('active', 'pending', 'suspended') DEFAULT 'active',
            `credit_limit` DECIMAL(12,2) DEFAULT 0.00,
            `outstanding_balance` DECIMAL(12,2) DEFAULT 0.00,
            `lifetime_spend` DECIMAL(12,2) DEFAULT 0.00,
            `orders_count` INT DEFAULT 0,
            `gstin` VARCHAR(50) NULL,
            `city` VARCHAR(100) NULL,
            `state` VARCHAR(100) NULL,
            `address` TEXT NULL,
            `pincode` VARCHAR(20) NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "orders" => "CREATE TABLE IF NOT EXISTS `orders` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `order_number` VARCHAR(50) NOT NULL UNIQUE,
            `customer_id` INT NULL,
            `customer_name` VARCHAR(255) NOT NULL,
            `customer_phone` VARCHAR(20) NOT NULL,
            `customer_email` VARCHAR(255) NULL,
            `channel` ENUM('retail', 'wholesale', 'reseller') DEFAULT 'retail',
            `status` ENUM('pending', 'confirmed', 'processing', 'packed', 'dispatched', 'delivered', 'cancelled') DEFAULT 'pending',
            `payment_status` ENUM('unpaid', 'paid', 'partially_paid', 'refunded') DEFAULT 'unpaid',
            `payment_method` VARCHAR(50) DEFAULT 'cod',
            `subtotal` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
            `discount` DECIMAL(12,2) DEFAULT 0.00,
            `coupon_code` VARCHAR(50) NULL,
            `tax` DECIMAL(12,2) DEFAULT 0.00,
            `shipping_fee` DECIMAL(12,2) DEFAULT 0.00,
            `total` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
            `shipping_address` TEXT NULL,
            `tracking_number` VARCHAR(100) NULL,
            `courier_partner` VARCHAR(100) NULL,
            `notes` TEXT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "order_items" => "CREATE TABLE IF NOT EXISTS `order_items` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `order_id` INT NOT NULL,
            `product_id` INT NULL,
            `sku` VARCHAR(100) NULL,
            `product_name` VARCHAR(255) NOT NULL,
            `unit_price` DECIMAL(10,2) NOT NULL,
            `quantity` INT NOT NULL DEFAULT 1,
            `total_price` DECIMAL(12,2) NOT NULL,
            `color` VARCHAR(50) NULL,
            `size` VARCHAR(50) NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "coupons" => "CREATE TABLE IF NOT EXISTS `coupons` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `code` VARCHAR(50) NOT NULL UNIQUE,
            `type` ENUM('percentage', 'fixed') DEFAULT 'percentage',
            `value` DECIMAL(10,2) NOT NULL,
            `min_spend` DECIMAL(10,2) DEFAULT 0.00,
            `max_discount` DECIMAL(10,2) NULL,
            `channel` ENUM('all', 'retail', 'wholesale', 'reseller') DEFAULT 'all',
            `usage_limit` INT DEFAULT NULL,
            `usage_count` INT DEFAULT 0,
            `start_date` DATETIME NULL,
            `end_date` DATETIME NULL,
            `status` ENUM('active', 'inactive') DEFAULT 'active',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "order_status_history" => "CREATE TABLE IF NOT EXISTS `order_status_history` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `order_id` INT NOT NULL,
            `from_status` VARCHAR(50) NULL,
            `to_status` VARCHAR(50) NOT NULL,
            `notes` TEXT NULL,
            `created_by` VARCHAR(100) DEFAULT 'System',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "wallets" => "CREATE TABLE IF NOT EXISTS `wallets` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `customer_id` INT NOT NULL UNIQUE,
            `balance` DECIMAL(12,2) DEFAULT 0.00,
            `currency` VARCHAR(10) DEFAULT 'INR',
            `status` ENUM('active', 'frozen') DEFAULT 'active',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "wallet_transactions" => "CREATE TABLE IF NOT EXISTS `wallet_transactions` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `wallet_id` INT NOT NULL,
            `type` ENUM('credit', 'debit') NOT NULL,
            `amount` DECIMAL(12,2) NOT NULL,
            `reference_type` VARCHAR(50) NULL,
            `reference_id` VARCHAR(100) NULL,
            `description` VARCHAR(255) NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "quotations" => "CREATE TABLE IF NOT EXISTS `quotations` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `quote_number` VARCHAR(50) NOT NULL UNIQUE,
            `customer_id` INT NULL,
            `customer_name` VARCHAR(255) NOT NULL,
            `customer_phone` VARCHAR(20) NOT NULL,
            `items_json` LONGTEXT NULL,
            `subtotal` DECIMAL(12,2) NOT NULL,
            `tax` DECIMAL(12,2) DEFAULT 0.00,
            `discount` DECIMAL(12,2) DEFAULT 0.00,
            `total` DECIMAL(12,2) NOT NULL,
            `valid_until` DATE NULL,
            `status` ENUM('draft', 'sent', 'accepted', 'expired', 'converted') DEFAULT 'draft',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "whatsapp_logs" => "CREATE TABLE IF NOT EXISTS `whatsapp_logs` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `recipient_phone` VARCHAR(20) NOT NULL,
            `template_name` VARCHAR(100) NULL,
            `message_type` ENUM('template', 'text', 'media', 'order_update') DEFAULT 'text',
            `payload` TEXT NULL,
            `status` ENUM('queued', 'sent', 'delivered', 'read', 'failed') DEFAULT 'queued',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "activity_logs" => "CREATE TABLE IF NOT EXISTS `activity_logs` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `admin_id` INT NULL,
            `action` VARCHAR(100) NOT NULL,
            `module` VARCHAR(100) NOT NULL,
            `entity_id` INT NULL,
            `details` TEXT NULL,
            `ip_address` VARCHAR(45) NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "reviews" => "CREATE TABLE IF NOT EXISTS `reviews` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `product_id` INT NOT NULL,
            `customer_name` VARCHAR(255) NOT NULL,
            `rating` INT NOT NULL DEFAULT 5,
            `review_title` VARCHAR(255) NULL,
            `review_text` TEXT NULL,
            `status` ENUM('approved', 'pending', 'rejected') DEFAULT 'approved',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "brands" => "CREATE TABLE IF NOT EXISTS `brands` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(255) NOT NULL,
            `slug` VARCHAR(255) NOT NULL UNIQUE,
            `logo` VARCHAR(500) NULL,
            `description` TEXT NULL,
            `status` ENUM('active', 'inactive') DEFAULT 'active',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "attributes" => "CREATE TABLE IF NOT EXISTS `attributes` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(100) NOT NULL,
            `slug` VARCHAR(100) NOT NULL UNIQUE,
            `type` ENUM('color', 'size', 'fabric', 'weave', 'work') NOT NULL,
            `values_json` TEXT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "settings" => "CREATE TABLE IF NOT EXISTS `settings` (
            `key_name` VARCHAR(100) PRIMARY KEY,
            `value_text` LONGTEXT NULL,
            `category` VARCHAR(50) DEFAULT 'general',
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    ];

    $created_or_verified = [];
    foreach ($recommended_tables_sql as $tName => $sql) {
        $pdo->exec($sql);
        $created_or_verified[] = $tName;
    }

    // Refresh table list
    $stmt = $pdo->query("SHOW TABLES");
    $all_current_tables = $stmt->fetchAll(\PDO::FETCH_COLUMN);

    // Audit each table count and columns
    $table_details = [];
    foreach ($all_current_tables as $tbl) {
        $cStmt = $pdo->query("SELECT COUNT(*) FROM `$tbl`");
        $rowCount = (int)$cStmt->fetchColumn();

        $dStmt = $pdo->query("DESCRIBE `$tbl`");
        $columns = $dStmt->fetchAll(\PDO::FETCH_COLUMN);

        $table_details[$tbl] = [
            'rows' => $rowCount,
            'column_count' => count($columns),
            'columns' => $columns
        ];
    }

    echo json_encode([
        'success' => true,
        'database' => 'u602484543_demodt121',
        'host' => 'localhost:3306',
        'total_tables' => count($all_current_tables),
        'tables' => $all_current_tables,
        'table_details' => $table_details,
        'verified_tables' => $created_or_verified
    ], JSON_PRETTY_PRINT);

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ], JSON_PRETTY_PRINT);
}
