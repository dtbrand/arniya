-- ══════════════════════════════════════════════════════════════════════════
-- Migration: 2026_09_02_000001_create_payment_gateways_and_webhooks.sql
-- Description: Multi-Gateway Payment System Schema (Cashfree, Razorpay, Instant UPI, COD, WhatsApp Pay)
-- DT Brand's & Jai Hanuman Tex
-- ══════════════════════════════════════════════════════════════════════════

-- 1. Payment Gateways & Configurations Table
CREATE TABLE IF NOT EXISTS `payment_gateways` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `gateway_key` VARCHAR(50) NOT NULL UNIQUE,
    `name` VARCHAR(100) NOT NULL,
    `description` VARCHAR(255) NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `is_test_mode` TINYINT(1) NOT NULL DEFAULT 0,
    `is_recommended` TINYINT(1) NOT NULL DEFAULT 0,
    `config_json` LONGTEXT NULL,
    `sort_order` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_gateway_active` (`is_active`),
    INDEX `idx_gateway_sort` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Payment Transactions & Audit Ledger Table
CREATE TABLE IF NOT EXISTS `payment_transactions` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `order_id` INT UNSIGNED NULL,
    `order_number` VARCHAR(60) NOT NULL,
    `customer_id` INT UNSIGNED NULL,
    `customer_name` VARCHAR(150) NULL,
    `customer_phone` VARCHAR(30) NULL,
    `gateway` VARCHAR(50) NOT NULL,
    `payment_method` VARCHAR(50) NOT NULL DEFAULT 'upi',
    `amount` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    `currency` VARCHAR(10) NOT NULL DEFAULT 'INR',
    `status` ENUM('pending', 'authorized', 'captured', 'failed', 'refunded') NOT NULL DEFAULT 'pending',
    `gateway_order_id` VARCHAR(120) NULL,
    `gateway_payment_id` VARCHAR(120) NULL,
    `gateway_signature` VARCHAR(255) NULL,
    `utr_reference` VARCHAR(100) NULL,
    `webhook_payload` LONGTEXT NULL,
    `notes` TEXT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_tx_order_number` (`order_number`),
    INDEX `idx_tx_gateway` (`gateway`),
    INDEX `idx_tx_status` (`status`),
    INDEX `idx_tx_utr` (`utr_reference`),
    INDEX `idx_tx_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Ensure orders table has payment tracking columns
ALTER TABLE `orders` 
    ADD COLUMN IF NOT EXISTS `payment_gateway` VARCHAR(50) NULL AFTER `payment_method`,
    ADD COLUMN IF NOT EXISTS `payment_utr` VARCHAR(100) NULL AFTER `payment_gateway`,
    ADD COLUMN IF NOT EXISTS `gateway_order_id` VARCHAR(120) NULL AFTER `payment_utr`,
    ADD COLUMN IF NOT EXISTS `gateway_payment_id` VARCHAR(120) NULL AFTER `gateway_order_id`;

-- 4. Seed Default Payment Gateway Configs
INSERT INTO `payment_gateways` (`gateway_key`, `name`, `description`, `is_active`, `is_test_mode`, `is_recommended`, `config_json`, `sort_order`) 
VALUES
(
    'direct_upi',
    'Instant UPI / Dynamic QR (0% Fee)',
    'Direct 1-Click App Auto-Open (Google Pay, PhonePe, Paytm, BHIM, CRED) & Dynamic Desktop QR',
    1,
    0,
    1,
    '{"upi_vpa":"917046363528@okaxis","upi_name":"DT Brands Jai Hanuman Tex","backup_vpa":"dtbrands@icici","mcc":"5691","auto_open_app":true,"dynamic_qr":true,"require_utr":true}',
    1
),
(
    'razorpay',
    'Razorpay Online Payments',
    'Cards, Net Banking (50+ Banks), UPI, Wallets, PayLater & EMI',
    1,
    0,
    0,
    '{"key_id":"","key_secret":"","webhook_secret":"","auto_capture":true,"theme_color":"#8A681F"}',
    2
),
(
    'cashfree',
    'Cashfree Payment Gateway',
    'Fast checkout via Cashfree PG, Instant UPI Intent & Netbanking',
    1,
    0,
    0,
    '{"app_id":"","secret_key":"","webhook_secret":"","theme_color":"#8A681F"}',
    3
),
(
    'cod',
    'Cash on Delivery (COD)',
    'Doorstep cash payment upon delivery with flexible order limits',
    1,
    0,
    0,
    '{"handling_fee":0,"min_order":299,"max_order":25000,"verify_otp":false,"partial_deposit":0}',
    4
),
(
    'whatsapp_pay',
    'Direct WhatsApp Order & Pay',
    '1-Click WhatsApp Concierge order with embedded instant payment link',
    1,
    0,
    0,
    '{"phone":"917046363528","auto_upi_link":true,"welcome_msg":"Namaste! I would like to place an order from DT Brand\'s."}',
    5
)
ON DUPLICATE KEY UPDATE 
    `name` = VALUES(`name`),
    `description` = VALUES(`description`);
