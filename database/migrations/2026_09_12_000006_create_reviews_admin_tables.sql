-- ══════════════════════════════════════════════════════════════════════════
-- Migration: 2026_09_12_000006_create_reviews_admin_tables.sql
-- Description: Section 30 Reviews Admin Moderation Schema & Audit Ledger
-- DT Brand's & Jai Hanuman Tex
-- ══════════════════════════════════════════════════════════════════════════

-- 1. Ensure reviews table exists with complete fields
CREATE TABLE IF NOT EXISTS `reviews` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `product_id` INT UNSIGNED NOT NULL DEFAULT 0,
    `customer_id` INT UNSIGNED NULL,
    `customer_name` VARCHAR(150) NOT NULL DEFAULT 'Customer',
    `customer_email` VARCHAR(150) NULL,
    `customer_phone` VARCHAR(50) NULL,
    `city` VARCHAR(100) NULL,
    `rating` TINYINT UNSIGNED NOT NULL DEFAULT 5,
    `review_title` VARCHAR(255) NULL,
    `review_text` TEXT NOT NULL,
    `images_json` LONGTEXT NULL,
    `verified_buyer` TINYINT(1) NOT NULL DEFAULT 0,
    `status` ENUM('pending', 'approved', 'rejected', 'flagged') NOT NULL DEFAULT 'pending',
    `store_reply` TEXT NULL,
    `store_replied_at` DATETIME NULL,
    `store_replied_by` VARCHAR(100) NULL,
    `moderated_by` VARCHAR(100) NULL,
    `moderated_at` DATETIME NULL,
    `moderation_notes` TEXT NULL,
    `flag_reason` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_rev_product` (`product_id`),
    INDEX `idx_rev_status` (`status`),
    INDEX `idx_rev_rating` (`rating`),
    INDEX `idx_rev_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Conditional Column Additions for older installs
SET @_col1 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='reviews' AND COLUMN_NAME='customer_id');
SET @_sql1 = IF(@_col1=0, 'ALTER TABLE `reviews` ADD COLUMN `customer_id` INT UNSIGNED NULL AFTER `product_id`', 'SELECT 1');
PREPARE _s1 FROM @_sql1; EXECUTE _s1; DEALLOCATE PREPARE _s1;

SET @_col2 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='reviews' AND COLUMN_NAME='customer_email');
SET @_sql2 = IF(@_col2=0, 'ALTER TABLE `reviews` ADD COLUMN `customer_email` VARCHAR(150) NULL AFTER `customer_name`', 'SELECT 1');
PREPARE _s2 FROM @_sql2; EXECUTE _s2; DEALLOCATE PREPARE _s2;

SET @_col3 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='reviews' AND COLUMN_NAME='customer_phone');
SET @_sql3 = IF(@_col3=0, 'ALTER TABLE `reviews` ADD COLUMN `customer_phone` VARCHAR(50) NULL AFTER `customer_email`', 'SELECT 1');
PREPARE _s3 FROM @_sql3; EXECUTE _s3; DEALLOCATE PREPARE _s3;

SET @_col4 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='reviews' AND COLUMN_NAME='city');
SET @_sql4 = IF(@_col4=0, 'ALTER TABLE `reviews` ADD COLUMN `city` VARCHAR(100) NULL AFTER `customer_phone`', 'SELECT 1');
PREPARE _s4 FROM @_sql4; EXECUTE _s4; DEALLOCATE PREPARE _s4;

SET @_col5 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='reviews' AND COLUMN_NAME='review_title');
SET @_sql5 = IF(@_col5=0, 'ALTER TABLE `reviews` ADD COLUMN `review_title` VARCHAR(255) NULL AFTER `rating`', 'SELECT 1');
PREPARE _s5 FROM @_sql5; EXECUTE _s5; DEALLOCATE PREPARE _s5;

SET @_col6 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='reviews' AND COLUMN_NAME='images_json');
SET @_sql6 = IF(@_col6=0, 'ALTER TABLE `reviews` ADD COLUMN `images_json` LONGTEXT NULL AFTER `review_text`', 'SELECT 1');
PREPARE _s6 FROM @_sql6; EXECUTE _s6; DEALLOCATE PREPARE _s6;

SET @_col7 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='reviews' AND COLUMN_NAME='store_reply');
SET @_sql7 = IF(@_col7=0, 'ALTER TABLE `reviews` ADD COLUMN `store_reply` TEXT NULL AFTER `status`', 'SELECT 1');
PREPARE _s7 FROM @_sql7; EXECUTE _s7; DEALLOCATE PREPARE _s7;

SET @_col8 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='reviews' AND COLUMN_NAME='store_replied_at');
SET @_sql8 = IF(@_col8=0, 'ALTER TABLE `reviews` ADD COLUMN `store_replied_at` DATETIME NULL AFTER `store_reply`', 'SELECT 1');
PREPARE _s8 FROM @_sql8; EXECUTE _s8; DEALLOCATE PREPARE _s8;

SET @_col9 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='reviews' AND COLUMN_NAME='store_replied_by');
SET @_sql9 = IF(@_col9=0, 'ALTER TABLE `reviews` ADD COLUMN `store_replied_by` VARCHAR(100) NULL AFTER `store_replied_at`', 'SELECT 1');
PREPARE _s9 FROM @_sql9; EXECUTE _s9; DEALLOCATE PREPARE _s9;

SET @_col10 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='reviews' AND COLUMN_NAME='moderated_by');
SET @_sql10 = IF(@_col10=0, 'ALTER TABLE `reviews` ADD COLUMN `moderated_by` VARCHAR(100) NULL AFTER `store_replied_by`', 'SELECT 1');
PREPARE _s10 FROM @_sql10; EXECUTE _s10; DEALLOCATE PREPARE _s10;

SET @_col11 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='reviews' AND COLUMN_NAME='moderated_at');
SET @_sql11 = IF(@_col11=0, 'ALTER TABLE `reviews` ADD COLUMN `moderated_at` DATETIME NULL AFTER `moderated_by`', 'SELECT 1');
PREPARE _s11 FROM @_sql11; EXECUTE _s11; DEALLOCATE PREPARE _s11;

SET @_col12 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='reviews' AND COLUMN_NAME='moderation_notes');
SET @_sql12 = IF(@_col12=0, 'ALTER TABLE `reviews` ADD COLUMN `moderation_notes` TEXT NULL AFTER `moderated_at`', 'SELECT 1');
PREPARE _s12 FROM @_sql12; EXECUTE _s12; DEALLOCATE PREPARE _s12;

SET @_col13 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='reviews' AND COLUMN_NAME='flag_reason');
SET @_sql13 = IF(@_col13=0, 'ALTER TABLE `reviews` ADD COLUMN `flag_reason` VARCHAR(255) NULL AFTER `moderation_notes`', 'SELECT 1');
PREPARE _s13 FROM @_sql13; EXECUTE _s13; DEALLOCATE PREPARE _s13;

-- 3. Review Moderation Audit Ledger
CREATE TABLE IF NOT EXISTS `review_audit_logs` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `review_id` INT UNSIGNED NOT NULL,
    `action` VARCHAR(50) NOT NULL,
    `performed_by` VARCHAR(100) NOT NULL DEFAULT 'admin',
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `details` TEXT NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_ral_review` (`review_id`),
    INDEX `idx_ral_action` (`action`),
    INDEX `idx_ral_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
