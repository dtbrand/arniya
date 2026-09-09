-- ═══════════════════════════════════════════════════════════════════════════════════════
-- Migration: 2026_09_09_000001_add_master_price_fields.sql
-- Description: Add missing price fields per MASTER SPECIFICATION
--              Single Piece: Reseller/Retailer/Wholesaler Price + Sale Price, Customer Price + Customer Sale Price
--              Full Set: Retailer/Wholesaler Price + Sale Price
--              Per-variant price fields for granular control
-- DT Brand's & Jai Hanuman Tex
-- ═══════════════════════════════════════════════════════════════════════════════════════

SET FOREIGN_KEY_CHECKS = 0;
SET time_zone = "+05:30";

-- ═══════════════════════════════════════════════════════════════════════════════════════
-- 1. PRODUCTS TABLE — Add customer_sale_price
-- ═══════════════════════════════════════════════════════════════════════════════════════

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='customer_sale_price');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `customer_sale_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `customer_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- Ensure sale_price column exists (already added in previous migration but verify)
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='sale_price');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `sale_price` DECIMAL(10,2) NOT NULL DEFAULT 0.00 AFTER `customer_sale_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ════════════════════════════════════════════════════════════════════════════════════════
-- 2. PRODUCT_VARIANTS TABLE — Add role-based price fields per master spec
-- ════════════════════════════════════════════════════════════════════════════════════════

-- Single Piece Price fields
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='product_variants' AND COLUMN_NAME='reseller_price');
SET @s = IF(@x=0, 'ALTER TABLE `product_variants` ADD COLUMN `reseller_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='product_variants' AND COLUMN_NAME='retailer_price');
SET @s = IF(@x=0, 'ALTER TABLE `product_variants` ADD COLUMN `retailer_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `reseller_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='product_variants' AND COLUMN_NAME='retail_price');
SET @s = IF(@x=0, 'ALTER TABLE `product_variants` ADD COLUMN `retail_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `retailer_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='product_variants' AND COLUMN_NAME='wholesale_price');
SET @s = IF(@x=0, 'ALTER TABLE `product_variants` ADD COLUMN `wholesale_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `retail_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- Single Piece Sale Price fields
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='product_variants' AND COLUMN_NAME='reseller_sale_price');
SET @s = IF(@x=0, 'ALTER TABLE `product_variants` ADD COLUMN `reseller_sale_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `wholesale_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='product_variants' AND COLUMN_NAME='retailer_sale_price');
SET @s = IF(@x=0, 'ALTER TABLE `product_variants` ADD COLUMN `retailer_sale_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `reseller_sale_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='product_variants' AND COLUMN_NAME='retail_sale_price');
SET @s = IF(@x=0, 'ALTER TABLE `product_variants` ADD COLUMN `retail_sale_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `retailer_sale_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='product_variants' AND COLUMN_NAME='wholesale_sale_price');
SET @s = IF(@x=0, 'ALTER TABLE `product_variants` ADD COLUMN `wholesale_sale_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `retail_sale_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- Customer Price fields (Guest/Customer)
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='product_variants' AND COLUMN_NAME='customer_price');
SET @s = IF(@x=0, 'ALTER TABLE `product_variants` ADD COLUMN `customer_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `wholesale_sale_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='product_variants' AND COLUMN_NAME='customer_sale_price');
SET @s = IF(@x=0, 'ALTER TABLE `product_variants` ADD COLUMN `customer_sale_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `customer_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- Full Set Price fields (Retailer/Wholesaler only)
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='product_variants' AND COLUMN_NAME='full_set_retailer_price');
SET @s = IF(@x=0, 'ALTER TABLE `product_variants` ADD COLUMN `full_set_retailer_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `customer_sale_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='product_variants' AND COLUMN_NAME='full_set_wholesale_price');
SET @s = IF(@x=0, 'ALTER TABLE `product_variants` ADD COLUMN `full_set_wholesale_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `full_set_retailer_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='product_variants' AND COLUMN_NAME='full_set_retailer_sale_price');
SET @s = IF(@x=0, 'ALTER TABLE `product_variants` ADD COLUMN `full_set_retailer_sale_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `full_set_wholesale_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='product_variants' AND COLUMN_NAME='full_set_wholesale_sale_price');
SET @s = IF(@x=0, 'ALTER TABLE `product_variants` ADD COLUMN `full_set_wholesale_sale_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `full_set_retailer_sale_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- selling_type for variant (single_piece or full_set)
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='product_variants' AND COLUMN_NAME='selling_type');
SET @s = IF(@x=0, "ALTER TABLE `product_variants` ADD COLUMN `selling_type` ENUM('single_piece','full_set') NOT NULL DEFAULT 'single_piece' AFTER `full_set_wholesale_sale_price`", 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- ════════════════════════════════════════════════════════════════════════════════════════
-- 3. PRODUCT_VARIANTS TABLE — Add indexes for performance
-- ════════════════════════════════════════════════════════════════════════════════════════

SET @x = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='product_variants' AND INDEX_NAME='idx_variant_selling_type');
SET @s = IF(@x=0, 'ALTER TABLE `product_variants` ADD INDEX `idx_variant_selling_type` (`selling_type`)', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET @x = (SELECT COUNT(*) FROM information_schema.STATISTICS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='product_variants' AND INDEX_NAME='idx_variant_product_selling');
SET @s = IF(@x=0, 'ALTER TABLE `product_variants` ADD INDEX `idx_variant_product_selling` (`product_id`, `selling_type`)', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET FOREIGN_KEY_CHECKS = 1;