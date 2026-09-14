-- ==============================================================================
-- DT BRAND'S & JAI HANUMAN TEX — MIGRATION: ADD SUBCATEGORY COLUMNS TO PRODUCTS
-- Version: 3.2.1
-- Adds subcategory_id and subcategory to products table with index
-- ==============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Add subcategory_id if not exists
SET @col_exists = 0;
SELECT COUNT(*) INTO @col_exists FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'products' AND COLUMN_NAME = 'subcategory_id';

SET @stmt = IF(@col_exists = 0, 
    'ALTER TABLE `products` ADD COLUMN `subcategory_id` INT DEFAULT NULL AFTER `category_id`', 
    'SELECT 1');
PREPARE stmt FROM @stmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 2. Add subcategory text if not exists
SET @col_exists = 0;
SELECT COUNT(*) INTO @col_exists FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'products' AND COLUMN_NAME = 'subcategory';

SET @stmt = IF(@col_exists = 0, 
    'ALTER TABLE `products` ADD COLUMN `subcategory` VARCHAR(100) DEFAULT NULL AFTER `subcategory_id`', 
    'SELECT 1');
PREPARE stmt FROM @stmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 3. Add index on subcategory_id if not exists
SET @idx_exists = 0;
SELECT COUNT(*) INTO @idx_exists FROM INFORMATION_SCHEMA.STATISTICS 
WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'products' AND INDEX_NAME = 'idx_products_subcategory';

SET @stmt = IF(@idx_exists = 0, 
    'ALTER TABLE `products` ADD INDEX `idx_products_subcategory` (`subcategory_id`)', 
    'SELECT 1');
PREPARE stmt FROM @stmt;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET FOREIGN_KEY_CHECKS = 1;
