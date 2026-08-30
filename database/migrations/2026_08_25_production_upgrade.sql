-- ==============================================================================
-- DT BRAND'S & JAI HANUMAN TEX — PRODUCTION UPGRADE MIGRATION
-- Version: 3.1.0 Enterprise Reseller, Wholesale, Coupon & Audit System
-- ==============================================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+05:30";

-- ── 1. COUPONS TABLE ──
CREATE TABLE IF NOT EXISTS `coupons` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(50) NOT NULL UNIQUE,
    `title` VARCHAR(150) NOT NULL,
    `discount_type` ENUM('percentage', 'fixed') NOT NULL DEFAULT 'percentage',
    `discount_value` DECIMAL(10,2) NOT NULL,
    `min_order_amount` DECIMAL(10,2) DEFAULT 0.00,
    `max_discount` DECIMAL(10,2) DEFAULT NULL,
    `usage_limit` INT DEFAULT 1000,
    `used_count` INT DEFAULT 0,
    `channel` ENUM('all', 'retail', 'wholesale', 'reseller') DEFAULT 'all',
    `status` ENUM('active', 'inactive', 'expired') DEFAULT 'active',
    `starts_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `expires_at` DATETIME DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_coupon_code` (`code`),
    INDEX `idx_coupon_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 2. ORDER STATUS HISTORY (AUDIT TRAIL) ──
CREATE TABLE IF NOT EXISTS `order_status_history` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT NOT NULL,
    `previous_status` VARCHAR(50),
    `new_status` VARCHAR(50) NOT NULL,
    `comment` TEXT,
    `updated_by` VARCHAR(100) DEFAULT 'system',
    `notify_customer` TINYINT(1) DEFAULT 1,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_history_order` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 3. RESELLER WALLETS & COMMISSION LEDGER ──
CREATE TABLE IF NOT EXISTS `wallets` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `customer_id` INT NOT NULL UNIQUE,
    `balance` DECIMAL(12,2) DEFAULT 0.00,
    `pending_payout` DECIMAL(12,2) DEFAULT 0.00,
    `lifetime_earned` DECIMAL(12,2) DEFAULT 0.00,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_wallet_customer` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `wallet_transactions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `wallet_id` INT NOT NULL,
    `customer_id` INT NOT NULL,
    `order_id` INT DEFAULT NULL,
    `transaction_type` ENUM('credit', 'debit', 'payout', 'adjustment') NOT NULL,
    `amount` DECIMAL(10,2) NOT NULL,
    `balance_after` DECIMAL(12,2) NOT NULL,
    `reference_note` VARCHAR(255),
    `status` ENUM('completed', 'pending', 'cancelled') DEFAULT 'completed',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_wtx_customer` (`customer_id`),
    INDEX `idx_wtx_order` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 4. ACTIVITY & AUDIT LOGS ──
CREATE TABLE IF NOT EXISTS `activity_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT DEFAULT NULL,
    `user_role` VARCHAR(50) DEFAULT 'guest',
    `action` VARCHAR(100) NOT NULL,
    `module` VARCHAR(100) NOT NULL,
    `record_id` INT DEFAULT NULL,
    `details` TEXT,
    `ip_address` VARCHAR(45),
    `user_agent` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_log_module` (`module`),
    INDEX `idx_log_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 5. WHATSAPP NOTIFICATION LOGS ──
CREATE TABLE IF NOT EXISTS `whatsapp_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `recipient_phone` VARCHAR(20) NOT NULL,
    `recipient_name` VARCHAR(100),
    `template_type` VARCHAR(50) NOT NULL,
    `message_content` TEXT NOT NULL,
    `order_id` INT DEFAULT NULL,
    `status` ENUM('sent', 'failed', 'delivered', 'read') DEFAULT 'sent',
    `response_payload` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_wa_phone` (`recipient_phone`),
    INDEX `idx_wa_order` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 6. B2B WHOLESALE QUOTATIONS ──
CREATE TABLE IF NOT EXISTS `quotations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `quote_number` VARCHAR(50) NOT NULL UNIQUE,
    `customer_id` INT DEFAULT NULL,
    `company_name` VARCHAR(150) NOT NULL,
    `contact_person` VARCHAR(150) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `email` VARCHAR(150),
    `gst_number` VARCHAR(20),
    `total_pieces` INT NOT NULL,
    `estimated_total` DECIMAL(12,2) NOT NULL,
    `discount_offered` DECIMAL(10,2) DEFAULT 0.00,
    `final_quoted_amount` DECIMAL(12,2) NOT NULL,
    `delivery_location` VARCHAR(150),
    `status` ENUM('pending', 'approved', 'converted_to_order', 'rejected') DEFAULT 'pending',
    `notes` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_quote_phone` (`phone`),
    INDEX `idx_quote_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 7. SEED INITIAL ACTIVE COUPONS ──
INSERT IGNORE INTO `coupons` (`code`, `discount_type`, `discount_value`, `min_order_value`, `max_discount`, `status`)
VALUES 
('DTHANDLOOM10', 'percentage', 10.00, 1500.00, 1000.00, 'active'),
('FESTIVE500', 'flat', 500.00, 5000.00, 500.00, 'active'),
('RESELLERVIP', 'percentage', 15.00, 2000.00, 2500.00, 'active');

SET FOREIGN_KEY_CHECKS = 1;
