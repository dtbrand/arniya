-- ═══════════════════════════════════════════════════════════════════════════════════════
-- Migration: 2026_09_12_000014_create_price_history_and_database_integrity.sql
-- Description: Production Price History Audit Ledger & Database Integrity Indexes
--              Master Specification V2: Sections 40, 41, 42, 43
-- DT Brand's & Jai Hanuman Tex
-- ═══════════════════════════════════════════════════════════════════════════════════════

SET FOREIGN_KEY_CHECKS = 0;
SET time_zone = "+05:30";

-- ═══════════════════════════════════════════════════════════════════════════════════════
-- 1. PRODUCT_PRICE_HISTORY TABLE (Section 43)
-- ═══════════════════════════════════════════════════════════════════════════════════════

CREATE TABLE IF NOT EXISTS `product_price_history` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT UNSIGNED NOT NULL,
    `product_type` ENUM('single_piece', 'full_set') NOT NULL DEFAULT 'single_piece',
    `role_tier` VARCHAR(32) NOT NULL DEFAULT 'all',
    `field_name` VARCHAR(64) NOT NULL,
    `old_price` DECIMAL(12,2) NULL DEFAULT NULL,
    `new_price` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `currency` VARCHAR(3) NOT NULL DEFAULT 'INR',
    `changed_by` VARCHAR(100) NOT NULL DEFAULT 'admin',
    `changed_by_id` INT UNSIGNED NULL DEFAULT NULL,
    `change_reason` VARCHAR(255) NULL DEFAULT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_pph_product` (`product_id`),
    INDEX `idx_pph_created` (`created_at`),
    INDEX `idx_pph_role` (`role_tier`),
    INDEX `idx_pph_type` (`product_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ═══════════════════════════════════════════════════════════════════════════════════════
-- 2. DATABASE INTEGRITY INDEXES (Section 40 & 41)
-- ═══════════════════════════════════════════════════════════════════════════════════════

-- Ensure index on products category and brand
SET @x = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND INDEX_NAME='idx_products_cat_brand');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD INDEX `idx_products_cat_brand` (`category_id`, `brand_id`)', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- Ensure index on orders customer and status
SET @x = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='orders' AND INDEX_NAME='idx_orders_cust_status');
SET @s = IF(@x=0, 'ALTER TABLE `orders` ADD INDEX `idx_orders_cust_status` (`customer_id`, `order_status`)', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- Ensure index on order_items order and product
SET @x = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='order_items' AND INDEX_NAME='idx_order_items_ord_prod');
SET @s = IF(@x=0, 'ALTER TABLE `order_items` ADD INDEX `idx_order_items_ord_prod` (`order_id`, `product_id`)', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET FOREIGN_KEY_CHECKS = 1;
