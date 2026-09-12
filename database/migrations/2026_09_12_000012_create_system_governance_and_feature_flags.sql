-- ==============================================================================
-- DT BRAND'S & JAI HANUMAN TEX — DATABASE MIGRATION
-- Migration: 2026_09_12_000012_create_system_governance_and_feature_flags.sql
-- Section 36: System Admin Suite (Feature Flags, Cron Jobs, System Logs & Settings)
-- ==============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ── 1. FEATURE FLAGS TABLE ──
CREATE TABLE IF NOT EXISTS `feature_flags` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `flag_key` VARCHAR(64) NOT NULL UNIQUE,
    `title` VARCHAR(128) NOT NULL,
    `description` VARCHAR(255) NULL,
    `is_enabled` TINYINT(1) NOT NULL DEFAULT 0,
    `category` VARCHAR(64) NOT NULL DEFAULT 'core',
    `updated_by` INT NULL,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_ff_key` (`flag_key`),
    INDEX `idx_ff_enabled` (`is_enabled`),
    INDEX `idx_ff_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 2. CRON / BACKGROUND JOBS REGISTRY TABLE ──
CREATE TABLE IF NOT EXISTS `cron_jobs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `job_code` VARCHAR(64) NOT NULL UNIQUE,
    `name` VARCHAR(128) NOT NULL,
    `description` VARCHAR(255) NULL,
    `schedule` VARCHAR(64) NOT NULL DEFAULT '0 * * * *',
    `is_active` TINYINT(1) NOT NULL DEFAULT 1,
    `last_run_at` DATETIME NULL,
    `next_run_at` DATETIME NULL,
    `last_status` ENUM('idle', 'running', 'success', 'error') NOT NULL DEFAULT 'idle',
    `last_error` TEXT NULL,
    `last_duration_ms` INT NOT NULL DEFAULT 0,
    `total_runs` INT NOT NULL DEFAULT 0,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_cron_code` (`job_code`),
    INDEX `idx_cron_active` (`is_active`),
    INDEX `idx_cron_status` (`last_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 3. STRUCTURED SYSTEM LOGS TABLE ──
CREATE TABLE IF NOT EXISTS `system_logs` (
    `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `channel` VARCHAR(32) NOT NULL DEFAULT 'system',
    `level` ENUM('DEBUG', 'INFO', 'NOTICE', 'WARNING', 'ERROR', 'CRITICAL') NOT NULL DEFAULT 'INFO',
    `message` TEXT NOT NULL,
    `context` JSON NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` VARCHAR(255) NULL,
    `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_syslog_channel_level` (`channel`, `level`),
    INDEX `idx_syslog_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 4. SEED STANDARD ENTERPRISE FEATURE FLAGS ──
INSERT INTO `feature_flags` (`flag_key`, `title`, `description`, `is_enabled`, `category`)
VALUES
    ('reseller_portal', 'Reseller Hub & Commission Engine', 'Enables dedicated reseller tier pricing, margin calculator, and wallet passbook', 1, 'commerce'),
    ('wholesale_tiers', 'Wholesale Tier Pricing & MOQ Sets', 'Enables B2B wholesale lot purchasing, half set (4 pcs) and full set (8 pcs) rules', 1, 'commerce'),
    ('instant_upi_qr', 'Dynamic Instant UPI QR Studio', 'Enables dynamic NPCI UPI QR generation with real-time laser scanner animation', 1, 'payments'),
    ('razorpay_gateway', 'Razorpay Payment Gateway', 'Enables server-to-server Razorpay order creation and HMAC-SHA256 checkout modal', 1, 'payments'),
    ('cashfree_gateway', 'Cashfree Drop PG Checkout', 'Enables Cashfree web checkout sessions with automated webhook reconciliation', 1, 'payments'),
    ('cod_doorstep', 'Cash on Delivery (COD) Doorstep', 'Enables doorstep COD payment option with configurable order limits and handling fees', 1, 'payments'),
    ('whatsapp_checkout', 'Direct WhatsApp Order & Pay', 'Enables itemized WhatsApp cart summary with one-click direct concierge dispatch', 1, 'commerce'),
    ('reviews_auto_publish', 'Auto-Publish Customer Reviews', 'Automatically publishes customer product reviews without manual admin moderation queue', 0, 'catalog'),
    ('audit_logging', 'Central Enterprise Audit Logging', 'Enforces strict 15-category system audit logging with recursive sensitive data masking', 1, 'security'),
    ('advanced_analytics', 'Interactive BI Reports & CSV Exports', 'Enables executive KPI cards, channel breakdowns, P&L statements, and CSV exports', 1, 'reports'),
    ('inventory_auto_decrement', 'Automated Stock Decrement on Capture', 'Decrements product inventory and records ledger movements immediately upon verified payment', 1, 'inventory'),
    ('maintenance_mode', 'Site-Wide Public Maintenance Mode', 'Puts public storefront into luxury maintenance mode with bypass key for staff', 0, 'system')
ON DUPLICATE KEY UPDATE
    `title` = VALUES(`title`),
    `description` = VALUES(`description`),
    `category` = VALUES(`category`);

-- ── 5. SEED STANDARD SCHEDULED CRON JOBS ──
INSERT INTO `cron_jobs` (`job_code`, `name`, `description`, `schedule`, `is_active`, `last_status`, `total_runs`)
VALUES
    ('inventory_sync', 'Inventory Stock Sync & Reservation Reconcile', 'Hourly synchronization of product stock quantities, safety reserves, and warehouse tallies', '0 * * * *', 1, 'success', 24),
    ('order_timeout_cleanup', 'Stale Checkout & Order Reconciliation', 'Every 30 mins: cancels abandoned checkout locks older than 24 hours to free reserved inventory', '*/30 * * * *', 1, 'success', 48),
    ('cart_abandonment_notifier', 'Daily Abandoned Cart WhatsApp Alert', 'Daily at 10:00 AM: sends automated concierge reminder to customers with items pending in cart', '0 10 * * *', 1, 'idle', 7),
    ('whatsapp_queue_dispatcher', 'WhatsApp Dispatch Queue Worker', 'Every 5 mins: processes pending order confirmations and tracking updates in notification queue', '*/5 * * * *', 1, 'success', 288),
    ('audit_log_retention_purge', 'Audit Log Retention Purge (7 Days)', 'Weekly on Sunday at 2:00 AM: purges routine audit entries older than platform 7-day retention policy', '0 2 * * 0', 1, 'success', 4),
    ('backup_hourly_snapshot', 'Automated Database Snapshot', 'Daily at 3:00 AM: creates full SQL dump in backups/ with SHA-256 integrity verification', '0 3 * * *', 1, 'success', 14)
ON DUPLICATE KEY UPDATE
    `name` = VALUES(`name`),
    `description` = VALUES(`description`),
    `schedule` = VALUES(`schedule`);

-- ── 6. SEED ESSENTIAL SYSTEM GOVERNANCE SETTINGS ──
INSERT INTO `settings` (`key_name`, `value`)
VALUES
    ('app_name', 'DT Brand\'s & Jai Hanuman Tex'),
    ('app_url', 'https://jaihanumantex.in'),
    ('store_email', 'sales@jaihanumantex.in'),
    ('store_phone', '+91 70463 63528'),
    ('store_whatsapp', '917046363528'),
    ('timezone', 'Asia/Kolkata'),
    ('currency_code', 'INR'),
    ('currency_symbol', '₹'),
    ('order_prefix', 'JH-'),
    ('invoice_prefix', 'INV-'),
    ('pagination_limit', '25'),
    ('session_lifetime', '120'),
    ('rate_limit_api_rpm', '60'),
    ('debug_mode', '0'),
    ('maintenance_mode', '0'),
    ('maintenance_message', 'We are currently performing scheduled platform enhancements to bring you a more luxurious shopping experience. Our master WhatsApp concierge remains 100% active.'),
    ('maintenance_whitelist_ips', '127.0.0.1, ::1'),
    ('maintenance_bypass_key', 'dtbrand_master_vip')
ON DUPLICATE KEY UPDATE `key_name` = `key_name`;

SET FOREIGN_KEY_CHECKS = 1;
