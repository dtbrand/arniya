-- ==============================================================================
-- Section 32: Integrations Admin Architecture Migration
-- DT Brand's & Jai Hanuman Tex — Production Master Migration
-- Creates: integrations, integration_logs, integration_diagnostics
-- ==============================================================================

CREATE TABLE IF NOT EXISTS `integrations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `slug` VARCHAR(64) UNIQUE NOT NULL,
    `name` VARCHAR(128) NOT NULL,
    `category` VARCHAR(32) NOT NULL DEFAULT 'system',
    `description` TEXT NULL,
    `status` ENUM('active', 'inactive', 'testing', 'error') DEFAULT 'active',
    `is_enabled` TINYINT(1) DEFAULT 1,
    `config_json` TEXT NULL,
    `webhook_url` VARCHAR(255) NULL,
    `webhook_status` ENUM('active', 'inactive', 'unconfigured', 'degraded') DEFAULT 'active',
    `last_request_at` DATETIME NULL,
    `last_request_status` VARCHAR(32) DEFAULT '200 OK',
    `last_error_at` DATETIME NULL,
    `last_error_message` TEXT NULL,
    `last_ping_latency_ms` INT DEFAULT 45,
    `health_score` INT DEFAULT 100,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_category` (`category`),
    INDEX `idx_status` (`status`),
    INDEX `idx_is_enabled` (`is_enabled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `integration_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `integration_slug` VARCHAR(64) NOT NULL,
    `action` VARCHAR(128) NOT NULL,
    `status` ENUM('success', 'failed', 'warning') DEFAULT 'success',
    `http_status` INT DEFAULT 200,
    `latency_ms` INT DEFAULT 45,
    `endpoint` VARCHAR(255) NULL,
    `payload_summary` TEXT NULL,
    `response_summary` TEXT NULL,
    `ip_address` VARCHAR(45) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_slug` (`integration_slug`),
    INDEX `idx_status` (`status`),
    INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `integration_diagnostics` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `integration_slug` VARCHAR(64) NOT NULL,
    `check_name` VARCHAR(128) NOT NULL,
    `status` ENUM('passed', 'warning', 'failed') DEFAULT 'passed',
    `details` TEXT NULL,
    `checked_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_diag_slug` (`integration_slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Default Production Integrations
INSERT INTO `integrations` (`slug`, `name`, `category`, `description`, `status`, `is_enabled`, `config_json`, `webhook_url`, `webhook_status`, `last_request_at`, `last_request_status`, `last_ping_latency_ms`, `health_score`)
VALUES
('razorpay', 'Razorpay Payments', 'payment', 'Primary card, netbanking, and UPI gateway with HMAC webhook verification and instant settlement.', 'active', 1, 
 '{"api_key":"rzp_live_••••••••••••","api_secret":"••••••••••••••••","webhook_secret":"••••••••••••••••","mode":"live","currency":"INR","auto_capture":1}',
 'https://jaihanumantex.in/api/webhooks/razorpay.php', 'active', NOW(), '200 OK', 52, 99),

('cashfree', 'Cashfree Drop PG', 'payment', 'Secondary payment gateway with instant drop checkout, auto-refunds, and UPI rails.', 'active', 1,
 '{"app_id":"CF_LIVE_••••••••••••","secret_key":"••••••••••••••••","environment":"production","currency":"INR"}',
 'https://jaihanumantex.in/api/webhooks/cashfree.php', 'active', NOW(), '200 OK', 68, 98),

('delhivery', 'Delhivery Express Logistics', 'shipping', 'Primary B2C Surface and Express courier partner with real-time AWB generation and tracking.', 'active', 1,
 '{"api_token":"••••••••••••••••","client_id":"DT_DELHIVERY_PROD","warehouse_pincode":"395002","pickup_location":"DT Brands Surat Central Hub","mode":"production"}',
 'https://jaihanumantex.in/api/webhooks/delhivery.php', 'active', NOW(), '200 OK', 84, 96),

('bluedart', 'BlueDart Express', 'shipping', 'High-priority air express delivery for premium orders with automated manifest upload.', 'active', 1,
 '{"customer_code":"BD_••••••••","license_key":"••••••••••••••••","login_id":"••••••••","service_type":"Apex Domestic Air Express","origin_hub":"STV"}',
 'https://jaihanumantex.in/api/webhooks/bluedart.php', 'active', NOW(), '200 OK', 72, 97),

('tci', 'TCI Freight Logistics (B2B)', 'shipping', 'B2B Cargo & Bulk Surface Transport for Wholesaler MCQ lots, full bale dispatches, and LR tracking.', 'active', 1,
 '{"customer_account":"TCI_SURAT_910","auth_token":"••••••••••••••••","branch_code":"SRT-01","vehicle_booking":1,"e_way_bill_sync":1}',
 'https://jaihanumantex.in/api/webhooks/tci.php', 'active', NOW(), '200 OK', 110, 95),

('whatsapp', 'WhatsApp Cloud API', 'messaging', 'Meta Graph API official WhatsApp Business integration for automated order receipts and B2B concierge.', 'active', 1,
 '{"phone_number_id":"1048291049281","waba_id":"918274019284","access_token":"••••••••••••••••","webhook_verify_token":"••••••••••••••••","sender_phone":"917046363528"}',
 'https://jaihanumantex.in/api/webhooks/whatsapp.php', 'active', NOW(), '200 OK', 48, 100),

('email', 'Hostinger Enterprise SMTP', 'messaging', 'High-deliverability transactional email service over SSL port 465 with DKIM, SPF, and DMARC.', 'active', 1,
 '{"smtp_host":"smtp.hostinger.com","smtp_port":465,"encryption":"ssl","username":"info@jaihanumantex.in","password":"••••••••••••••••","from_email":"info@jaihanumantex.in","from_name":"DT Brand\'s & Jai Hanuman Tex"}',
 NULL, 'unconfigured', NOW(), '200 OK', 35, 100),

('sms', 'DLT SMS Gateway (Fast2SMS)', 'messaging', 'TRAI DLT-approved transactional SMS gateway with header DTHNTX for OTP and delivery alerts.', 'active', 1,
 '{"api_key":"••••••••••••••••","sender_id":"DTHNTX","dlt_entity_id":"1701159827382910","route":"dlt_manual","service_provider":"Fast2SMS"}',
 NULL, 'unconfigured', NOW(), '200 OK', 41, 99)
ON DUPLICATE KEY UPDATE `updated_at` = NOW();
