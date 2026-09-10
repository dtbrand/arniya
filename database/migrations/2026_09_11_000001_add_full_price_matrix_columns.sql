-- ═══════════════════════════════════════════════════════════════════════════════════════
-- Migration: 2026_09_11_000001_add_full_price_matrix_columns.sql
-- Description: Add complete role-price matrix columns to `products` table
--              Single Piece: Customer, Reseller, Retailer, Wholesaler Price & Sale Price
--              Full Set: Retailer, Wholesaler Price & Sale Price
-- DT Brand's & Jai Hanuman Tex — Master Specification V2
-- ═══════════════════════════════════════════════════════════════════════════════════════

SET FOREIGN_KEY_CHECKS = 0;
SET time_zone = "+05:30";

-- 1. Single Piece: Retailer Sale Price
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='retailer_sale_price');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `retailer_sale_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `sale_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- 2. Single Piece: Reseller Sale Price
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='reseller_sale_price');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `reseller_sale_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `reseller_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- 3. Single Piece: Wholesale Sale Price
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='wholesale_sale_price');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `wholesale_sale_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `wholesale_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- 4. Full Set: Retailer Price
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='full_set_retailer_price');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `full_set_retailer_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `wholesale_sale_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- 5. Full Set: Retailer Sale Price
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='full_set_retailer_sale_price');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `full_set_retailer_sale_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `full_set_retailer_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- 6. Full Set: Wholesale Price
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='full_set_wholesale_price');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `full_set_wholesale_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `full_set_retailer_sale_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

-- 7. Full Set: Wholesale Sale Price
SET @x = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='products' AND COLUMN_NAME='full_set_wholesale_sale_price');
SET @s = IF(@x=0, 'ALTER TABLE `products` ADD COLUMN `full_set_wholesale_sale_price` DECIMAL(10,2) NULL DEFAULT NULL AFTER `full_set_wholesale_price`', 'SELECT 1');
PREPARE _st FROM @s; EXECUTE _st; DEALLOCATE PREPARE _st;

SET FOREIGN_KEY_CHECKS = 1;
