-- ═══════════════════════════════════════════════════════════════════════════════════════
-- Migration: 2026_09_13_000015_add_idempotency_and_stock_safety.sql
-- Description: Idempotency Key, Atomic Stock Decrement Flag & Wishlist Integrity
--              Master Specification V2: Sections 44, 45, 46, 47, 48
-- DT Brand's & Jai Hanuman Tex
-- ═══════════════════════════════════════════════════════════════════════════════════════

SET FOREIGN_KEY_CHECKS = 0;
SET time_zone = "+05:30";

-- ═══════════════════════════════════════════════════════════════════════════════════════
-- 1. ORDERS IDEMPOTENCY KEY (Section 47)
-- ═══════════════════════════════════════════════════════════════════════════════════════

SET @col_exists = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='orders' AND COLUMN_NAME='idempotency_key');
SET @alter_sql = IF(@col_exists = 0, 'ALTER TABLE `orders` ADD COLUMN `idempotency_key` VARCHAR(64) NULL DEFAULT NULL AFTER `order_number`', 'SELECT 1');
PREPARE _st FROM @alter_sql; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @idx_exists = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='orders' AND INDEX_NAME='idx_orders_idempotency');
SET @idx_sql = IF(@idx_exists = 0, 'ALTER TABLE `orders` ADD INDEX `idx_orders_idempotency` (`idempotency_key`)', 'SELECT 1');
PREPARE _st FROM @idx_sql; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ═══════════════════════════════════════════════════════════════════════════════════════
-- 2. ORDERS STOCK DECREMENTED FLAG (Section 48)
-- ═══════════════════════════════════════════════════════════════════════════════════════

SET @col_exists = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='orders' AND COLUMN_NAME='stock_decremented');
SET @alter_sql = IF(@col_exists = 0, 'ALTER TABLE `orders` ADD COLUMN `stock_decremented` TINYINT(1) NOT NULL DEFAULT 0 AFTER `payment_status`', 'SELECT 1');
PREPARE _st FROM @alter_sql; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @idx_exists = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='orders' AND INDEX_NAME='idx_orders_stock_dec');
SET @idx_sql = IF(@idx_exists = 0, 'ALTER TABLE `orders` ADD INDEX `idx_orders_stock_dec` (`stock_decremented`)', 'SELECT 1');
PREPARE _st FROM @idx_sql; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ═══════════════════════════════════════════════════════════════════════════════════════
-- 3. WISHLIST ITEMS INTEGRITY INDEX (Section 45)
-- ═══════════════════════════════════════════════════════════════════════════════════════

CREATE TABLE IF NOT EXISTS `wishlist_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `customer_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `variant_id` INT DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_wishlist_customer` (`customer_id`),
    INDEX `idx_wishlist_product` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET @var_col_exists = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='wishlist_items' AND COLUMN_NAME='variant_id');
SET @alter_var_sql = IF(@var_col_exists = 0, 'ALTER TABLE `wishlist_items` ADD COLUMN `variant_id` INT NULL DEFAULT NULL AFTER `product_id`', 'SELECT 1');
PREPARE _st FROM @alter_var_sql; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @idx_exists = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='wishlist_items' AND INDEX_NAME='idx_wishlist_cust_prod');
SET @idx_sql = IF(@idx_exists = 0, 'ALTER TABLE `wishlist_items` ADD INDEX `idx_wishlist_cust_prod` (`customer_id`, `product_id`, `variant_id`)', 'SELECT 1');
PREPARE _st FROM @idx_sql; EXECUTE _st; DEALLOCATE PREPARE _st;

SET FOREIGN_KEY_CHECKS = 1;
