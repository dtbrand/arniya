-- ══════════════════════════════════════════════════════════════════════════
-- Migration: 2026_09_12_000013_create_developer_and_webhook_queue_tables.sql
-- Description: Section 37 Developer & API Admin Suite Tables
--              API Keys, Webhook Events, Queue Jobs, and Telemetry Logs
-- DT Brand's & Jai Hanuman Tex — Production Master Migration
-- ══════════════════════════════════════════════════════════════════════════

-- 1. Developer API Keys & Service Accounts
CREATE TABLE IF NOT EXISTS `developer_api_keys` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `key_prefix` VARCHAR(16) NOT NULL,
    `key_hash` VARCHAR(64) NOT NULL UNIQUE,
    `name` VARCHAR(100) NOT NULL,
    `role` VARCHAR(50) NOT NULL DEFAULT 'read_only',
    `scopes_json` TEXT NULL,
    `rate_limit_rpm` INT NOT NULL DEFAULT 120,
    `last_used_at` DATETIME NULL,
    `expires_at` DATETIME NULL,
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `created_by` INT UNSIGNED NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_dev_key_prefix` (`key_prefix`),
    INDEX `idx_dev_key_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Webhook Events & Delivery Ledger (Inbound & Outbound)
CREATE TABLE IF NOT EXISTS `webhook_events` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `event_id` VARCHAR(64) NOT NULL UNIQUE,
    `event_type` VARCHAR(64) NOT NULL,
    `direction` ENUM('inbound', 'outbound') NOT NULL DEFAULT 'inbound',
    `source_gateway` VARCHAR(50) NOT NULL DEFAULT 'system',
    `target_url` VARCHAR(255) NULL,
    `payload_json` LONGTEXT NULL,
    `headers_json` TEXT NULL,
    `status` ENUM('pending', 'delivered', 'failed') NOT NULL DEFAULT 'pending',
    `http_status` INT NULL,
    `response_body` TEXT NULL,
    `attempts` INT NOT NULL DEFAULT 0,
    `max_attempts` INT NOT NULL DEFAULT 5,
    `next_retry_at` DATETIME NULL,
    `signature` VARCHAR(255) NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_wh_type` (`event_type`),
    INDEX `idx_wh_status` (`status`),
    INDEX `idx_wh_gateway` (`source_gateway`),
    INDEX `idx_wh_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Queue Background Jobs Engine
CREATE TABLE IF NOT EXISTS `queue_jobs` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `job_id` VARCHAR(64) NOT NULL UNIQUE,
    `queue_name` VARCHAR(64) NOT NULL DEFAULT 'default',
    `job_type` VARCHAR(64) NOT NULL,
    `payload_json` LONGTEXT NULL,
    `status` ENUM('pending', 'running', 'completed', 'failed') NOT NULL DEFAULT 'pending',
    `attempts` INT NOT NULL DEFAULT 0,
    `max_attempts` INT NOT NULL DEFAULT 3,
    `reserved_at` DATETIME NULL,
    `completed_at` DATETIME NULL,
    `error_message` TEXT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_q_status` (`status`),
    INDEX `idx_q_queue` (`queue_name`),
    INDEX `idx_q_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. API Request Telemetry & Latency Logs
CREATE TABLE IF NOT EXISTS `api_telemetry_logs` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `endpoint` VARCHAR(255) NOT NULL,
    `method` VARCHAR(10) NOT NULL DEFAULT 'GET',
    `status_code` INT NOT NULL DEFAULT 200,
    `latency_ms` INT NOT NULL DEFAULT 45,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` VARCHAR(255) NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_telem_endpoint` (`endpoint`),
    INDEX `idx_telem_status` (`status_code`),
    INDEX `idx_telem_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Default Production Webhook Events
INSERT INTO `webhook_events` (`event_id`, `event_type`, `direction`, `source_gateway`, `target_url`, `payload_json`, `status`, `http_status`, `attempts`, `max_attempts`)
VALUES
('evt_rzp_01', 'payment.captured', 'inbound', 'razorpay', 'https://jaihanumantex.in/api/webhooks/razorpay.php', '{\"entity\":\"event\",\"event\":\"payment.captured\",\"payload\":{\"payment\":{\"id\":\"pay_live_019283\",\"amount\":450000,\"currency\":\"INR\",\"status\":\"captured\"}}}', 'delivered', 200, 1, 5),
('evt_cfr_02', 'order.paid', 'inbound', 'cashfree', 'https://jaihanumantex.in/api/webhooks/cashfree.php', '{\"type\":\"PAYMENT_SUCCESS_WEBHOOK\",\"data\":{\"order\":{\"order_id\":\"JH-2026-9021\",\"order_amount\":6200.00}}}', 'delivered', 200, 1, 5),
('evt_wa_03', 'message.status', 'inbound', 'whatsapp', 'https://jaihanumantex.in/api/whatsapp/webhook.php', '{\"entry\":[{\"changes\":[{\"field\":\"messages\",\"value\":{\"statuses\":[{\"id\":\"wamid.HBgMOTE3MDQ2MzYzNTI4FQIAERgSRTIwQzUxRjQ4RDhF\",\"status\":\"delivered\"}]}}]}]}', 'delivered', 200, 1, 5),
('evt_out_04', 'order.dispatched', 'outbound', 'shiprocket', 'https://apiv2.shiprocket.in/v1/external/orders/create/adhoc', '{\"order_id\":\"JH-2026-8910\",\"pickup_location\":\"Surat Textile Market\",\"delivery_pincode\":\"395002\"}', 'delivered', 200, 1, 5)
ON DUPLICATE KEY UPDATE `event_type` = VALUES(`event_type`);

-- Seed Default Background Queue Jobs
INSERT INTO `queue_jobs` (`job_id`, `queue_name`, `job_type`, `payload_json`, `status`, `attempts`, `max_attempts`)
VALUES
('job_wa_901', 'notifications', 'send_whatsapp_order_alert', '{\"phone\":\"917046363528\",\"template\":\"order_confirmation_v2\",\"order_id\":\"JH-2026-9021\"}', 'completed', 1, 3),
('job_inv_902', 'inventory', 'reconcile_low_stock_threshold', '{\"category\":\"sarees\",\"timestamp\":1741800000}', 'completed', 1, 3),
('job_mail_903', 'emails', 'send_invoice_pdf_receipt', '{\"email\":\"customer@example.com\",\"order_no\":\"JH-2026-9021\"}', 'completed', 1, 3),
('job_rep_904', 'reports', 'generate_daily_pnl_cache', '{\"date\":\"2026-09-12\"}', 'pending', 0, 3)
ON DUPLICATE KEY UPDATE `job_type` = VALUES(`job_type`);
