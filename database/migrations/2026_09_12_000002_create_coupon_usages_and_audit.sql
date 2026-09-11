-- ==============================================================================
-- DT BRAND'S & JAI HANUMAN TEX — COUPON USAGE, AUDIT & MULTI-CHANNEL DISCOUNTS
-- Migration: 2026_09_12_000002_create_coupon_usages_and_audit.sql
-- Section 26: Master Marketing Architecture — Usage Limits, Channel Security & Audit Ledger
-- ==============================================================================

-- 1. Ensure `coupons` table has all Section 26 fields
CREATE TABLE IF NOT EXISTS `coupons` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `code` VARCHAR(50) NOT NULL UNIQUE,
    `title` VARCHAR(150) NOT NULL DEFAULT '',
    `discount_type` ENUM('percentage', 'flat', 'fixed') NOT NULL DEFAULT 'percentage',
    `discount_value` DECIMAL(10,2) NOT NULL,
    `min_order_value` DECIMAL(10,2) DEFAULT 0.00,
    `min_order_amount` DECIMAL(10,2) DEFAULT 0.00,
    `max_discount` DECIMAL(10,2) DEFAULT NULL,
    `usage_limit` INT DEFAULT 1000,
    `used_count` INT DEFAULT 0,
    `per_user_limit` INT DEFAULT 1,
    `channel` VARCHAR(50) DEFAULT 'all',
    `status` ENUM('active', 'inactive', 'expired') DEFAULT 'active',
    `starts_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `expires_at` DATETIME DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_coupon_code` (`code`),
    INDEX `idx_coupon_status` (`status`),
    INDEX `idx_coupon_channel` (`channel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Coupon Redemptions & Usage Ledger
CREATE TABLE IF NOT EXISTS `coupon_usages` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `coupon_id` INT NULL DEFAULT NULL,
    `coupon_code` VARCHAR(50) NOT NULL,
    `order_id` INT NULL DEFAULT NULL,
    `order_number` VARCHAR(50) NULL DEFAULT NULL,
    `customer_id` INT NULL DEFAULT NULL,
    `customer_phone` VARCHAR(30) NULL DEFAULT NULL,
    `customer_name` VARCHAR(150) NULL DEFAULT NULL,
    `order_subtotal` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `discount_amount` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `channel` VARCHAR(50) DEFAULT 'customer',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_cu_code` (`coupon_code`),
    INDEX `idx_cu_order` (`order_id`),
    INDEX `idx_cu_order_num` (`order_number`),
    INDEX `idx_cu_customer` (`customer_id`),
    INDEX `idx_cu_phone` (`customer_phone`),
    INDEX `idx_cu_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Coupon Security & Integrity Audit Trail
CREATE TABLE IF NOT EXISTS `coupon_audit_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `coupon_id` INT NULL DEFAULT NULL,
    `coupon_code` VARCHAR(50) NOT NULL,
    `action` VARCHAR(50) NOT NULL,
    `actor` VARCHAR(100) DEFAULT 'Admin',
    `ip_address` VARCHAR(45) NULL DEFAULT NULL,
    `details` TEXT NULL DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_ca_code` (`coupon_code`),
    INDEX `idx_ca_action` (`action`),
    INDEX `idx_ca_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
