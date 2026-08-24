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

    if (isset($_GET['normalize_images']) && $_GET['normalize_images'] == '1') {
        try { $pdo->exec("UPDATE `products` SET `primary_image` = REPLACE(`primary_image`, '/Frontend/Shop/Asset/images/', '/assets/images/')"); } catch (\Exception $e) {}
        try { $pdo->exec("UPDATE `products` SET `primary_image` = REPLACE(`primary_image`, '/Shared/Asset/images/', '/assets/images/')"); } catch (\Exception $e) {}
        try { $pdo->exec("UPDATE `categories` SET `image` = REPLACE(`image`, '/Frontend/Shop/Asset/images/', '/assets/images/')"); } catch (\Exception $e) {}
        try { $pdo->exec("UPDATE `categories` SET `banner_image` = REPLACE(`banner_image`, '/Frontend/Shop/Asset/images/', '/assets/images/')"); } catch (\Exception $e) {}
        try { $pdo->exec("UPDATE `banners` SET `image_url` = REPLACE(`image_url`, '/Frontend/Shop/Asset/images/', '/assets/images/')"); } catch (\Exception $e) {}
        echo json_encode(['success' => true, 'message' => 'Image paths normalized in MySQL database.']);
        exit;
    }


    $doClean = (isset($_GET['clean']) && $_GET['clean'] === '1') || (isset($_GET['clean_refresh']) && $_GET['clean_refresh'] === '1');
    if ($doClean) {
        // Disable foreign key checks for clean purge
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
        $purge_tables = ['orders', 'order_items', 'order_status_history', 'whatsapp_logs', 'activity_logs', 'quotations', 'wallet_transactions', 'wallets', 'reviews', 'product_reviews', 'products', 'customers', 'coupons'];
        foreach ($purge_tables as $pt) {
            try {
                $pdo->exec("TRUNCATE TABLE `$pt`");
            } catch (\Exception $e) {}
        }
        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
    }

    // Auto-Seed Data if Tables are Empty or &seed=1 is requested
    $seeded = [];
    $doSeed = (isset($_GET['seed']) && $_GET['seed'] === '1') || $doClean;


    // 1. Seed Products if empty or requested
    $prodCount = (int)$pdo->query("SELECT COUNT(*) FROM `products`")->fetchColumn();
    if ($prodCount === 0 || $doSeed) {
        $sample_products = [
            ['sku' => 'KLN-SR-111', 'title' => 'Kanjivaram Pure Silk Gold Zari Saree', 'slug' => 'kanjivaram-pure-silk-saree', 'category_id' => 1, 'category_name' => 'Silk Sarees', 'fabric' => 'Mulberry Silk', 'mrp' => 6990, 'retail_price' => 4490, 'wholesale_price' => 2850, 'reseller_price' => 3450, 'stock_qty' => 45, 'rating' => 5.0, 'reviews_count' => 85, 'primary_image' => '/assets/images/product1.png', 'badge' => 'Bestseller', 'is_featured' => 1, 'is_bestseller' => 1, 'description' => 'Pure Mulberry Silk with 24K Gold Zari Korvai Weave'],
            ['sku' => 'BNR-SR-204', 'title' => 'Banarasi Royal Brocade Weave Saree', 'slug' => 'banarasi-royal-brocade-saree', 'category_id' => 2, 'category_name' => 'Banarasi', 'fabric' => 'Katan Silk', 'mrp' => 7490, 'retail_price' => 4990, 'wholesale_price' => 3200, 'reseller_price' => 3850, 'stock_qty' => 28, 'rating' => 4.9, 'reviews_count' => 64, 'primary_image' => '/assets/images/product2.png', 'badge' => 'Royal Heritage', 'is_featured' => 1, 'is_bestseller' => 0, 'description' => 'Handcrafted Katan Silk Floral Jaal & Royal Meenakari'],
            ['sku' => 'BRD-LH-902', 'title' => 'Crimson Bridal Handcrafted Zardosi Lehenga', 'slug' => 'crimson-bridal-zardosi-lehenga', 'category_id' => 6, 'category_name' => 'Bridal Lehengas', 'fabric' => 'Raw Silk', 'mrp' => 24990, 'retail_price' => 16490, 'wholesale_price' => 11500, 'reseller_price' => 13200, 'stock_qty' => 4, 'rating' => 5.0, 'reviews_count' => 19, 'primary_image' => '/assets/images/product3.png', 'badge' => 'Bridal Couture', 'is_featured' => 1, 'is_bestseller' => 1, 'description' => 'Heavy Handcrafted Zardosi & Raw Silk Designer Ensemble'],
            ['sku' => 'CHD-SR-301', 'title' => 'Chanderi Pure Zari Border Saree', 'slug' => 'chanderi-pure-zari-saree', 'category_id' => 4, 'category_name' => 'Silk Sarees', 'fabric' => 'Chanderi Silk', 'mrp' => 4290, 'retail_price' => 2890, 'wholesale_price' => 1750, 'reseller_price' => 2150, 'stock_qty' => 95, 'rating' => 4.8, 'reviews_count' => 42, 'primary_image' => '/assets/images/product4.png', 'badge' => 'Lightweight', 'is_featured' => 0, 'is_bestseller' => 1, 'description' => 'Lightweight Tissue Silk with Gold Foil Zari Butta'],
            ['sku' => 'DSG-KT-408', 'title' => 'Designer Anarkali Embroidered Kurti Set', 'slug' => 'designer-anarkali-kurti-set', 'category_id' => 7, 'category_name' => 'Designer Kurtis', 'fabric' => 'Georgette Foil', 'mrp' => 3990, 'retail_price' => 2490, 'wholesale_price' => 1450, 'reseller_price' => 1850, 'stock_qty' => 62, 'rating' => 4.9, 'reviews_count' => 53, 'primary_image' => '/assets/images/product5.png', 'badge' => 'Festive Ready', 'is_featured' => 0, 'is_bestseller' => 0, 'description' => 'Festive Chanderi Foil Printed Kurti Set with Dupatta'],
            ['sku' => 'PTH-SR-512', 'title' => 'Paithani Peacock Pallu Heritage Silk Saree', 'slug' => 'paithani-peacock-pallu-saree', 'category_id' => 3, 'category_name' => 'Paithani Handloom', 'fabric' => 'Yeola Paithani Silk', 'mrp' => 8990, 'retail_price' => 5490, 'wholesale_price' => 3650, 'reseller_price' => 4250, 'stock_qty' => 34, 'rating' => 4.9, 'reviews_count' => 71, 'primary_image' => '/assets/images/product6.png', 'badge' => 'Heritage Weave', 'is_featured' => 1, 'is_bestseller' => 1, 'description' => 'Maharashtra Heritage Silk with Asawali Peacock Border'],
            ['sku' => 'ORG-SR-618', 'title' => 'Organza Tissue Floral Foil Printed Saree', 'slug' => 'organza-tissue-floral-saree', 'category_id' => 5, 'category_name' => 'Organza Tissue', 'fabric' => 'Glass Organza', 'mrp' => 3490, 'retail_price' => 2190, 'wholesale_price' => 1290, 'reseller_price' => 1650, 'stock_qty' => 80, 'rating' => 4.7, 'reviews_count' => 38, 'primary_image' => '/assets/images/product7.png', 'badge' => 'Party Wear', 'is_featured' => 0, 'is_bestseller' => 0, 'description' => 'Translucent Glass Organza with Handcrafted Embroidery'],
            ['sku' => 'PTL-SR-705', 'title' => 'Patan Patola Double Ikat Traditional Saree', 'slug' => 'patan-patola-double-ikat-saree', 'category_id' => 8, 'category_name' => 'Patola Heritage', 'fabric' => 'Pure Mulberry Silk', 'mrp' => 11490, 'retail_price' => 6890, 'wholesale_price' => 4750, 'reseller_price' => 5450, 'stock_qty' => 18, 'rating' => 5.0, 'reviews_count' => 29, 'primary_image' => '/assets/images/product8.png', 'badge' => 'Double Ikat', 'is_featured' => 1, 'is_bestseller' => 1, 'description' => 'Double Ikat Rajkot & Patan Geometric Weaves']
        ];

        foreach ($sample_products as $sp) {
            try {
                $chk = $pdo->prepare("SELECT id FROM `products` WHERE sku = ?");
                $chk->execute([$sp['sku']]);
                if (!$chk->fetch()) {
                    $ins = $pdo->prepare("
                        INSERT INTO `products` (sku, title, slug, category_id, category_name, fabric, mrp, retail_price, wholesale_price, reseller_price, stock_qty, rating, reviews_count, primary_image, badge, is_featured, is_bestseller, status, description, created_at)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'in_stock', ?, NOW())
                    ");
                    $ins->execute([
                        $sp['sku'], $sp['title'], $sp['slug'], $sp['category_id'], $sp['category_name'], $sp['fabric'],
                        $sp['mrp'], $sp['retail_price'], $sp['wholesale_price'], $sp['reseller_price'],
                        $sp['stock_qty'], $sp['rating'], $sp['reviews_count'], $sp['primary_image'],
                        $sp['badge'], $sp['is_featured'], $sp['is_bestseller'], $sp['description']
                    ]);
                }
            } catch (\Exception $e) {}
        }
        $seeded[] = 'products';
    }

    // 2. Seed Customers if empty
    $custCount = (int)$pdo->query("SELECT COUNT(*) FROM `customers`")->fetchColumn();
    if ($custCount === 0 || $doSeed) {
        $sample_custs = [
            ['name' => 'Ananya Deshmukh', 'phone' => '+91 98201 12345', 'email' => 'ananya.sarees@gmail.com', 'type' => 'wholesale', 'city' => 'Mumbai', 'state' => 'Maharashtra', 'tier' => 'Gold', 'credit_limit' => 250000.00, 'outstanding_balance' => 45000.00, 'total_orders' => 14, 'lifetime_spend' => 380000.00, 'gstin' => '27AAACD1234E1Z1'],
            ['name' => 'Pooja Varma', 'phone' => '+91 98765 23456', 'email' => 'pooja.reseller@gmail.com', 'type' => 'reseller', 'city' => 'Jaipur', 'state' => 'Rajasthan', 'tier' => 'Silver', 'credit_limit' => 100000.00, 'outstanding_balance' => 12000.00, 'total_orders' => 8, 'lifetime_spend' => 145000.00, 'gstin' => '08AAACV5678F1Z2'],
            ['name' => 'Kavita Singhania', 'phone' => '+91 98111 34567', 'email' => 'kavita.textiles@gmail.com', 'type' => 'wholesale', 'city' => 'Kolkata', 'state' => 'West Bengal', 'tier' => 'Platinum', 'credit_limit' => 500000.00, 'outstanding_balance' => 85000.00, 'total_orders' => 26, 'lifetime_spend' => 920000.00, 'gstin' => '19AAACS9012G1Z3']
        ];

        foreach ($sample_custs as $sc) {
            try {
                $chk = $pdo->prepare("SELECT id FROM `customers` WHERE phone = ?");
                $chk->execute([$sc['phone']]);
                if (!$chk->fetch()) {
                    $ins = $pdo->prepare("
                        INSERT INTO `customers` (name, phone, email, type, city, state, tier, credit_limit, outstanding_balance, total_orders, lifetime_spend, gstin, status, created_at)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active', NOW())
                    ");
                    $ins->execute([
                        $sc['name'], $sc['phone'], $sc['email'], $sc['type'], $sc['city'], $sc['state'],
                        $sc['tier'], $sc['credit_limit'], $sc['outstanding_balance'], $sc['total_orders'],
                        $sc['lifetime_spend'], $sc['gstin']
                    ]);
                }
            } catch (\Exception $e) {}
        }
        $seeded[] = 'customers';
    }

    // 3. Seed Coupons if empty
    $coupCount = (int)$pdo->query("SELECT COUNT(*) FROM `coupons`")->fetchColumn();
    if ($coupCount === 0 || $doSeed) {
        $sample_coupons = [
            ['code' => 'WELCOME10', 'discount_type' => 'percentage', 'discount_value' => 10.00, 'min_order_value' => 1999.00, 'max_discount' => 500.00, 'status' => 'active'],
            ['code' => 'WHOLESALE500', 'discount_type' => 'fixed', 'discount_value' => 500.00, 'min_order_value' => 10000.00, 'max_discount' => 500.00, 'status' => 'active'],
            ['code' => 'FESTIVE20', 'discount_type' => 'percentage', 'discount_value' => 20.00, 'min_order_value' => 4999.00, 'max_discount' => 1500.00, 'status' => 'active']
        ];
        foreach ($sample_coupons as $cp) {
            try {
                $chk = $pdo->prepare("SELECT id FROM `coupons` WHERE code = ?");
                $chk->execute([$cp['code']]);
                if (!$chk->fetch()) {
                    $ins = $pdo->prepare("
                        INSERT INTO `coupons` (code, discount_type, discount_value, min_order_value, max_discount, status)
                        VALUES (?, ?, ?, ?, ?, ?)
                    ");
                    $ins->execute([$cp['code'], $cp['discount_type'], $cp['discount_value'], $cp['min_order_value'], $cp['max_discount'], $cp['status']]);
                }
            } catch (\Exception $e) {}
        }
        $seeded[] = 'coupons';
    }


    // 4. Seed Settings if empty
    $setCount = (int)$pdo->query("SELECT COUNT(*) FROM `settings`")->fetchColumn();
    if ($setCount === 0 || $doSeed) {
        $sample_settings = [
            ['key_name' => 'store_name', 'value_text' => "DT Brand's & Jai Hanuman Tex", 'category' => 'general'],
            ['key_name' => 'whatsapp_number', 'value_text' => '+91 93278 12345', 'category' => 'whatsapp'],
            ['key_name' => 'support_email', 'value_text' => 'contact@jaihanumantex.in', 'category' => 'general'],
            ['key_name' => 'gstin_number', 'value_text' => '24AAACJ1234F1Z5', 'category' => 'tax'],
            ['key_name' => 'currency_symbol', 'value_text' => '₹', 'category' => 'pricing']
        ];
        foreach ($sample_settings as $st) {
            try {
                $ins = $pdo->prepare("
                    INSERT INTO `settings` (key_name, value_text, category, updated_at)
                    VALUES (?, ?, ?, NOW())
                    ON DUPLICATE KEY UPDATE value_text = VALUES(value_text)
                ");
                $ins->execute([$st['key_name'], $st['value_text'], $st['category']]);
            } catch (\Exception $e) {}
        }
        $seeded[] = 'settings';
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
