-- ══════════════════════════════════════════════════════════════════════════
-- Migration: 2026_09_12_000004_create_payment_admin_tables.sql
-- Description: Section 28 Payment Admin Schema & Webhook Replay Protection
-- DT Brand's & Jai Hanuman Tex
-- ══════════════════════════════════════════════════════════════════════════

-- 1. Webhook Audit & Deduplication Table
CREATE TABLE IF NOT EXISTS `payment_webhooks` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `gateway` VARCHAR(50) NOT NULL,
    `event_id` VARCHAR(120) NULL,
    `event_type` VARCHAR(100) NOT NULL,
    `signature_header` TEXT NULL,
    `payload_json` LONGTEXT NULL,
    `status` VARCHAR(50) NOT NULL DEFAULT 'PROCESSED', -- 'PROCESSED', 'REPLAY_IGNORED', 'FAILED'
    `ip_address` VARCHAR(60) NULL,
    `processed_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_pw_gateway_event` (`gateway`, `event_id`),
    INDEX `idx_pw_status` (`status`),
    INDEX `idx_pw_processed` (`processed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. 3-Way Financial Reconciliation Table
CREATE TABLE IF NOT EXISTS `payment_reconciliations` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `order_number` VARCHAR(60) NOT NULL,
    `gateway` VARCHAR(50) NOT NULL,
    `gateway_ref` VARCHAR(120) NULL,
    `order_amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `gateway_amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `discrepancy_amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `status` VARCHAR(50) NOT NULL DEFAULT 'matched', -- 'matched', 'discrepancy', 'unpaid_order', 'missing_gateway'
    `notes` TEXT NULL,
    `reconciled_by` VARCHAR(100) NOT NULL DEFAULT 'System/Admin',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_pr_order` (`order_number`),
    INDEX `idx_pr_status` (`status`),
    INDEX `idx_pr_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Enhance payment_transactions with failure, recovery, and reconciliation columns
SET @_col1 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='payment_transactions' AND COLUMN_NAME='gateway_event_id');
SET @_sql1 = IF(@_col1=0, 'ALTER TABLE `payment_transactions` ADD COLUMN `gateway_event_id` VARCHAR(120) NULL AFTER `gateway_payment_id`', 'SELECT 1');
PREPARE _s1 FROM @_sql1; EXECUTE _s1; DEALLOCATE PREPARE _s1;

SET @_col2 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='payment_transactions' AND COLUMN_NAME='failure_reason');
SET @_sql2 = IF(@_col2=0, 'ALTER TABLE `payment_transactions` ADD COLUMN `failure_reason` VARCHAR(255) NULL AFTER `status`', 'SELECT 1');
PREPARE _s2 FROM @_sql2; EXECUTE _s2; DEALLOCATE PREPARE _s2;

SET @_col3 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='payment_transactions' AND COLUMN_NAME='is_reconciled');
SET @_sql3 = IF(@_col3=0, 'ALTER TABLE `payment_transactions` ADD COLUMN `is_reconciled` TINYINT(1) NOT NULL DEFAULT 0 AFTER `failure_reason`', 'SELECT 1');
PREPARE _s3 FROM @_sql3; EXECUTE _s3; DEALLOCATE PREPARE _s3;

SET @_col4 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='payment_transactions' AND COLUMN_NAME='reconciled_at');
SET @_sql4 = IF(@_col4=0, 'ALTER TABLE `payment_transactions` ADD COLUMN `reconciled_at` DATETIME NULL AFTER `is_reconciled`', 'SELECT 1');
PREPARE _s4 FROM @_sql4; EXECUTE _s4; DEALLOCATE PREPARE _s4;

SET @_col5 = (SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='payment_transactions' AND COLUMN_NAME='recovered_at');
SET @_sql5 = IF(@_col5=0, 'ALTER TABLE `payment_transactions` ADD COLUMN `recovered_at` DATETIME NULL AFTER `reconciled_at`', 'SELECT 1');
PREPARE _s5 FROM @_sql5; EXECUTE _s5; DEALLOCATE PREPARE _s5;
