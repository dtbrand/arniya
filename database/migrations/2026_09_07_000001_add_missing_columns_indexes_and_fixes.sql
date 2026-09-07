-- ══════════════════════════════════════════════════════════════════════════════════
-- Migration: 2026_09_07_000001_add_missing_columns_indexes_and_fixes.sql
-- Description: FULLY IDEMPOTENT — uses information_schema gates for ALL column
--              additions and CHANGE COLUMN operations. Safe for any MySQL/MariaDB.
-- DT Brand's & Jai Hanuman Tex
-- ══════════════════════════════════════════════════════════════════════════════════

SET FOREIGN_KEY_CHECKS = 0;
SET time_zone = "+05:30";

-- ═════════════════════════════════════════════════════════════════════════════════
-- HELPER: All column additions use information_schema guard (no IF NOT EXISTS needed)
-- HELPER: CHANGE COLUMN also gated — only runs if column exists
-- ═════════════════════════════════════════════════════════════════════════════════

-- ─── PRODUCTS: customer_price ───────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='customer_price');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `customer_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `mrp`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── PRODUCTS: selling_type ──────────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='selling_type');
SET @s = IF(@x=0, "ALTER TABLE `products` ADD COLUMN `selling_type` ENUM('single_piece','full_set') NOT NULL DEFAULT 'single_piece' AFTER `status`", 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── PRODUCTS: sale_price ────────────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='sale_price');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `sale_price` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `reseller_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── PRODUCTS: moq_single ────────────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='moq_single');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `moq_single` INT NOT NULL DEFAULT 1', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── PRODUCTS: moq_half_set ──────────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='moq_half_set');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `moq_half_set` INT NOT NULL DEFAULT 0', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── PRODUCTS: moq_full_set ──────────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='moq_full_set');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `moq_full_set` INT NOT NULL DEFAULT 0', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── PRODUCTS: moq_master_bale ───────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='moq_master_bale');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `moq_master_bale` INT NOT NULL DEFAULT 0', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── PRODUCTS: is_featured ───────────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='is_featured');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `is_featured` TINYINT(1) NOT NULL DEFAULT 0', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── PRODUCTS: is_bestseller ─────────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='is_bestseller');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `is_bestseller` TINYINT(1) NOT NULL DEFAULT 0', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── PRODUCTS: category_id ───────────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='category_id');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `category_id` INT DEFAULT 1', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── PRODUCTS: slug ──────────────────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='slug');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `slug` VARCHAR(255) NULL DEFAULT NULL', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── PRODUCTS: primary_image ─────────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='primary_image');
SET @s = IF(@x=0, "ALTER TABLE `products` ADD COLUMN `primary_image` VARCHAR(255) NOT NULL DEFAULT '/assets/images/product1.png'", 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── PRODUCTS: retail_price ──────────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='retail_price');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `retail_price` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `mrp`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ═════════════════════════════════════════════════════════════════════════════════
-- 2. ORDERS TABLE — All changes fully gated
-- ═════════════════════════════════════════════════════════════════════════════════

-- ─── ORDERS: payment_method (add if missing, then change type safely) ─────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='orders' AND COLUMN_NAME='payment_method');
SET @s = IF(@x=0, "ALTER TABLE `orders` ADD COLUMN `payment_method` VARCHAR(50) NOT NULL DEFAULT 'razorpay'", 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- Change payment_method to VARCHAR if it's still an ENUM (safe: MODIFY COLUMN)
SET @col_type = (SELECT DATA_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='orders' AND COLUMN_NAME='payment_method');
SET @s = IF(@col_type = 'enum', "ALTER TABLE `orders` MODIFY COLUMN `payment_method` VARCHAR(50) NOT NULL DEFAULT 'razorpay'", 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── ORDERS: payment_status (fix ENUM values) ─────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='orders' AND COLUMN_NAME='payment_status');
SET @s = IF(@x=0, "ALTER TABLE `orders` ADD COLUMN `payment_status` ENUM('pending','paid','credit','refunded') NOT NULL DEFAULT 'pending'", 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── ORDERS: fulfillment_status ───────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='orders' AND COLUMN_NAME='fulfillment_status');
SET @s = IF(@x=0, "ALTER TABLE `orders` ADD COLUMN `fulfillment_status` ENUM('unfulfilled','processing','dispatched','delivered','cancelled') NOT NULL DEFAULT 'unfulfilled'", 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── ORDERS: courier_name ─────────────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='orders' AND COLUMN_NAME='courier_name');
SET @s = IF(@x=0, "ALTER TABLE `orders` ADD COLUMN `courier_name` VARCHAR(100) DEFAULT 'Delhivery Express'", 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── ORDERS: tracking_number ──────────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='orders' AND COLUMN_NAME='tracking_number');
SET @s = IF(@x=0, 'ALTER TABLE `orders` ADD COLUMN `tracking_number` VARCHAR(100) NULL', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── ORDERS: shipping_address ─────────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='orders' AND COLUMN_NAME='shipping_address');
SET @s = IF(@x=0, 'ALTER TABLE `orders` ADD COLUMN `shipping_address` TEXT NULL', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ─── ORDERS: payment_gateway ──────────────────────────────────────────────────
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='orders' AND COLUMN_NAME='payment_gateway');
SET @s = IF(@x=0, "ALTER TABLE `orders` ADD COLUMN `payment_gateway` VARCHAR(50) DEFAULT 'razorpay'", 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ═════════════════════════════════════════════════════════════════════════════════
-- 3. ORDER ITEMS TABLE
-- ═════════════════════════════════════════════════════════════════════════════════

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='order_items' AND COLUMN_NAME='variant_color');
SET @s = IF(@x=0, 'ALTER TABLE `order_items` ADD COLUMN `variant_color` VARCHAR(50) NULL', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='order_items' AND COLUMN_NAME='variant_size');
SET @s = IF(@x=0, 'ALTER TABLE `order_items` ADD COLUMN `variant_size` VARCHAR(50) NULL', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='order_items' AND COLUMN_NAME='selling_type');
SET @s = IF(@x=0, "ALTER TABLE `order_items` ADD COLUMN `selling_type` ENUM('single_piece','full_set') NOT NULL DEFAULT 'single_piece'", 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='order_items' AND COLUMN_NAME='total_price');
SET @s = IF(@x=0, 'ALTER TABLE `order_items` ADD COLUMN `total_price` DECIMAL(12,2) NOT NULL DEFAULT 0.00', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='order_items' AND COLUMN_NAME='sku');
SET @s = IF(@x=0, 'ALTER TABLE `order_items` ADD COLUMN `sku` VARCHAR(50) NULL', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ═════════════════════════════════════════════════════════════════════════════════
-- 4. CUSTOMERS TABLE
-- ═════════════════════════════════════════════════════════════════════════════════

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='customers' AND COLUMN_NAME='customer_price');
SET @s = IF(@x=0, 'ALTER TABLE `customers` ADD COLUMN `customer_price` DECIMAL(10,2) NULL DEFAULT NULL', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='customers' AND COLUMN_NAME='status');
SET @s = IF(@x=0, "ALTER TABLE `customers` ADD COLUMN `status` ENUM('active','pending','suspended') DEFAULT 'active'", 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ═════════════════════════════════════════════════════════════════════════════════
-- 5. ORDER STATUS HISTORY TABLE
-- ═════════════════════════════════════════════════════════════════════════════════

CREATE TABLE IF NOT EXISTS `order_status_history` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT UNSIGNED NOT NULL,
    `previous_status` VARCHAR(50) NOT NULL,
    `new_status` VARCHAR(50) NOT NULL,
    `comment` TEXT NULL,
    `updated_by` VARCHAR(100) NOT NULL DEFAULT 'system',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_osh_order` (`order_id`),
    INDEX `idx_osh_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ═════════════════════════════════════════════════════════════════════════════════
-- 6. PERFORMANCE INDEXES — Fully gated via information_schema
-- ═════════════════════════════════════════════════════════════════════════════════

-- orders indexes
SET @x = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='orders' AND INDEX_NAME='idx_orders_channel_status');
SET @s = IF(@x=0, 'ALTER TABLE `orders` ADD INDEX `idx_orders_channel_status` (`channel`, `fulfillment_status`)', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='orders' AND INDEX_NAME='idx_orders_created_channel');
SET @s = IF(@x=0, 'ALTER TABLE `orders` ADD INDEX `idx_orders_created_channel` (`created_at`, `channel`)', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='orders' AND INDEX_NAME='idx_orders_customer_created');
SET @s = IF(@x=0, 'ALTER TABLE `orders` ADD INDEX `idx_orders_customer_created` (`customer_id`, `created_at`)', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='orders' AND INDEX_NAME='idx_orders_payment_gateway');
SET @s = IF(@x=0, 'ALTER TABLE `orders` ADD INDEX `idx_orders_payment_gateway` (`payment_gateway`, `payment_status`)', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- order_items indexes
SET @x = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='order_items' AND INDEX_NAME='idx_oi_order_selling');
SET @s = IF(@x=0, 'ALTER TABLE `order_items` ADD INDEX `idx_oi_order_selling` (`order_id`, `selling_type`)', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- products indexes
SET @x = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND INDEX_NAME='idx_products_selling_type');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD INDEX `idx_products_selling_type` (`selling_type`)', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND INDEX_NAME='idx_products_stock_status');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD INDEX `idx_products_stock_status` (`stock_qty`, `status`)', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND INDEX_NAME='idx_products_featured');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD INDEX `idx_products_featured` (`is_featured`, `status`)', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND INDEX_NAME='idx_products_bestseller');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD INDEX `idx_products_bestseller` (`is_bestseller`, `status`)', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- customers indexes
SET @x = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='customers' AND INDEX_NAME='idx_customers_type_status');
SET @s = IF(@x=0, 'ALTER TABLE `customers` ADD INDEX `idx_customers_type_status` (`type`, `status`)', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='customers' AND INDEX_NAME='idx_customers_city_state');
SET @s = IF(@x=0, 'ALTER TABLE `customers` ADD INDEX `idx_customers_city_state` (`city`, `state`)', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- reviews index
SET @x = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='reviews' AND INDEX_NAME='idx_reviews_product_status');
SET @s = IF(@x=0, 'ALTER TABLE `reviews` ADD INDEX `idx_reviews_product_status` (`product_id`, `status`)', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ═════════════════════════════════════════════════════════════════════════════════
-- 7. ENSURE users TABLE has correct columns for admin seeding
-- ═════════════════════════════════════════════════════════════════════════════════

CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` ENUM('super_admin','admin','staff','viewer') NOT NULL DEFAULT 'staff',
    `status` ENUM('active','inactive','suspended') NOT NULL DEFAULT 'active',
    `last_login` TIMESTAMP NULL DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_users_email` (`email`),
    INDEX `idx_users_role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='users' AND COLUMN_NAME='username');
SET @s = IF(@x=0, 'ALTER TABLE `users` ADD COLUMN `username` VARCHAR(50) NULL UNIQUE', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ═════════════════════════════════════════════════════════════════════════════════
-- 8. ENSURE settings TABLE exists with correct schema
-- ═════════════════════════════════════════════════════════════════════════════════

CREATE TABLE IF NOT EXISTS `settings` (
    `key` VARCHAR(100) PRIMARY KEY,
    `value` TEXT,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;