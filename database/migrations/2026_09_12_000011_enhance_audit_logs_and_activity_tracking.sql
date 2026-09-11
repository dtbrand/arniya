-- ==============================================================================
-- DT Brand's & Jai Hanuman Tex — Section 35 Enterprise Audit Logs Migration
-- Migration: 2026_09_12_000011_enhance_audit_logs_and_activity_tracking.sql
-- Description: Enhances audit_logs table with correlation_id, actor_role, status,
--              details, performance indexes, and seeds realistic multi-category
--              administrative audit logs across all 15 operational categories.
-- ==============================================================================

-- 1. Ensure Table Structure with All Required Enterprise Audit Columns
CREATE TABLE IF NOT EXISTS `audit_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `correlation_id` VARCHAR(64) NULL,
    `user_id` INT DEFAULT NULL,
    `user_name` VARCHAR(100) DEFAULT 'system',
    `actor_role` VARCHAR(50) DEFAULT 'admin',
    `action` VARCHAR(100) NOT NULL,
    `entity_type` VARCHAR(50) NOT NULL,
    `entity_id` VARCHAR(50) NOT NULL,
    `old_values` JSON DEFAULT NULL,
    `new_values` JSON DEFAULT NULL,
    `status` ENUM('success', 'warning', 'failure') NOT NULL DEFAULT 'success',
    `details` TEXT NULL,
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `user_agent` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_audit_corr` (`correlation_id`),
    INDEX `idx_audit_action` (`action`),
    INDEX `idx_audit_entity` (`entity_type`, `entity_id`),
    INDEX `idx_audit_created` (`created_at`),
    INDEX `idx_audit_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Add columns if table already existed without them
DELIMITER $$

DROP PROCEDURE IF EXISTS `upgrade_audit_logs_schema`$$
CREATE PROCEDURE `upgrade_audit_logs_schema`()
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM information_schema.COLUMNS 
        WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'audit_logs' AND COLUMN_NAME = 'correlation_id'
    ) THEN
        ALTER TABLE `audit_logs` ADD COLUMN `correlation_id` VARCHAR(64) NULL AFTER `id`;
        ALTER TABLE `audit_logs` ADD INDEX `idx_audit_corr` (`correlation_id`);
    END IF;

    IF NOT EXISTS (
        SELECT 1 FROM information_schema.COLUMNS 
        WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'audit_logs' AND COLUMN_NAME = 'actor_role'
    ) THEN
        ALTER TABLE `audit_logs` ADD COLUMN `actor_role` VARCHAR(50) DEFAULT 'admin' AFTER `user_name`;
    END IF;

    IF NOT EXISTS (
        SELECT 1 FROM information_schema.COLUMNS 
        WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'audit_logs' AND COLUMN_NAME = 'status'
    ) THEN
        ALTER TABLE `audit_logs` ADD COLUMN `status` ENUM('success', 'warning', 'failure') NOT NULL DEFAULT 'success' AFTER `new_values`;
        ALTER TABLE `audit_logs` ADD INDEX `idx_audit_status` (`status`);
    END IF;

    IF NOT EXISTS (
        SELECT 1 FROM information_schema.COLUMNS 
        WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'audit_logs' AND COLUMN_NAME = 'details'
    ) THEN
        ALTER TABLE `audit_logs` ADD COLUMN `details` TEXT NULL AFTER `status`;
    END IF;
END$$

DELIMITER ;

CALL `upgrade_audit_logs_schema`();
DROP PROCEDURE IF EXISTS `upgrade_audit_logs_schema`;

-- 3. Seed Realistic Multi-Category Enterprise Audit Logs (Covering all 15 required categories)
INSERT INTO `audit_logs` 
(`correlation_id`, `user_id`, `user_name`, `actor_role`, `action`, `entity_type`, `entity_id`, `old_values`, `new_values`, `status`, `details`, `ip_address`, `user_agent`, `created_at`)
VALUES
-- 1. Login
('corr_auth_8901', 1, 'Gautam Sethi', 'super_admin', 'login', 'auth', 'USR-1', NULL, '{"method": "password", "mfa": false, "device": "Desktop Chrome / Windows 11"}', 'success', 'Staff super_admin authenticated successfully from verified static IP', '147.93.99.134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/128.0.0.0 Safari/537.36', DATE_SUB(NOW(), INTERVAL 24 HOUR)),

-- 2. Logout
('corr_auth_8902', 4, 'Meera Patel', 'catalog_staff', 'logout', 'auth', 'USR-4', '{"session_duration_minutes": 142}', NULL, 'success', 'Staff voluntary sign-out via console header', '103.21.124.55', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 Safari/17.4', DATE_SUB(NOW(), INTERVAL 20 HOUR)),

-- 3. Failed Login
('corr_auth_8903', NULL, 'unknown_staff', 'guest', 'failed_login', 'auth', 'login_attempt', NULL, '{"attempted_identity": "admin@dtbrand.com", "failure_reason": "INVALID_PASSWORD", "attempts_remaining": 2}', 'warning', 'Authentication rejected: Invalid staff password provided', '185.220.101.5', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36', DATE_SUB(NOW(), INTERVAL 18 HOUR)),

-- 4. Product Create / Edit / Delete
('corr_cat_401', 4, 'Meera Patel', 'catalog_staff', 'product_create', 'product', 'PRD-101', NULL, '{"title": "Royal Banarasi Silk Saree", "sku": "DT-BAN-001", "type": "single_piece", "status": "active", "mrp": 3499.00, "base_price": 1899.00}', 'success', 'Created new catalog product in Banarasi Silk Saree collection', '103.21.124.55', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 Safari/17.4', DATE_SUB(NOW(), INTERVAL 16 HOUR)),

-- 5. Price Changes (Before / After diff)
('corr_price_502', 1, 'Gautam Sethi', 'super_admin', 'price_change', 'price_matrix', 'PRD-101', '{"wholesale_price": 1250.00, "reseller_price": 1450.00, "retailer_price": 1650.00, "customer_price": 1899.00}', '{"wholesale_price": 1199.00, "reseller_price": 1399.00, "retailer_price": 1599.00, "customer_price": 1849.00}', 'success', 'Festival seasonal price markdown applied across all 4 customer tiers', '147.93.99.134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36', DATE_SUB(NOW(), INTERVAL 14 HOUR)),

-- 6. Stock Changes
('corr_inv_603', 3, 'Rajesh Sharma', 'manager', 'stock_change', 'inventory', 'DT-BAN-001', '{"previous_qty": 45, "allocated_qty": 10}', '{"new_qty": 120, "adjustment": 75, "reason": "Surat Loom Weaving Batch #JH-4402 received"}', 'success', 'Inward stock receipt processed from manufacturing loom', '103.21.124.50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0.0.0', DATE_SUB(NOW(), INTERVAL 12 HOUR)),

-- 7. Order Status Changes
('corr_ord_704', 3, 'Rajesh Sharma', 'manager', 'order_status_change', 'order', 'ORD-2026-9042', '{"status": "processing", "carrier": null, "awb": null}', '{"status": "shipped", "carrier": "Delhivery Express", "awb": "DEL9824102931", "dispatched_at": "2026-09-11 18:30:00"}', 'success', 'Order dispatched via Delhivery Express surface wholesale route', '103.21.124.50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0.0.0', DATE_SUB(NOW(), INTERVAL 10 HOUR)),

-- 8. Payment Actions
('corr_pay_805', 1, 'Gautam Sethi', 'super_admin', 'payment_capture', 'payment', 'PAY-UPI-7712', '{"status": "pending_verification", "utr": "425910284912"}', '{"status": "captured", "amount": 24500.00, "gateway": "instant_upi", "verified_by": "Gautam Sethi"}', 'success', 'Manual 12-digit UTR verification approved for wholesale bulk booking', '147.93.99.134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', DATE_SUB(NOW(), INTERVAL 8 HOUR)),

-- 9. Role Changes
('corr_usr_906', 1, 'Gautam Sethi', 'super_admin', 'role_change', 'user', 'USR-28', '{"role": "retailer", "tier": "silver"}', '{"role": "wholesaler", "tier": "gold", "gst_verified": true, "reason": "GSTIN verified with monthly turnover > 5 Lakhs"}', 'success', 'Customer trade account upgraded to verified Wholesaler tier', '147.93.99.134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', DATE_SUB(NOW(), INTERVAL 6 HOUR)),

-- 10. Admin Permission Changes
('corr_perm_1007', 1, 'Gautam Sethi', 'super_admin', 'permission_change', 'permission', 'role_manager', '{"granted_count": 32}', '{"granted_count": 36, "added_permissions": ["inventory:adjust_stock", "orders:refund", "reports:view", "reports:export"]}', 'success', 'Granted report export and stock adjustment privileges to Operations Manager role', '147.93.99.134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', DATE_SUB(NOW(), INTERVAL 5 HOUR)),

-- 11. Settings Changes (Strict Secret Masking)
('corr_cfg_1108', 1, 'Gautam Sethi', 'super_admin', 'settings_change', 'setting', 'store_general', '{"store_name": "DT Brand", "support_email": "help@dtbrand.com", "tax_rate": 5.0}', '{"store_name": "DT Brand\'s & Jai Hanuman Tex", "support_email": "orders@jaihanumantex.in", "tax_rate": 5.0}', 'success', 'Updated store primary branding title and official customer contact mailbox', '147.93.99.134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', DATE_SUB(NOW(), INTERVAL 4 HOUR)),

-- 12. Integration Changes (Masked API Keys)
('corr_int_1209', 1, 'Gautam Sethi', 'super_admin', 'integration_change', 'integration', 'razorpay', '{"enabled": true, "webhook_url": "https://jaihanumantex.in/api/webhooks/razorpay.php", "key_id": "[REDACTED]"}', '{"enabled": true, "webhook_url": "https://jaihanumantex.in/api/webhooks/razorpay.php", "key_id": "[REDACTED]", "auto_capture": true}', 'success', 'Configured automated instant capture for Razorpay card and netbanking transactions', '147.93.99.134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', DATE_SUB(NOW(), INTERVAL 3 HOUR)),

-- 13. Bulk Actions
('corr_blk_1310', 3, 'Rajesh Sharma', 'manager', 'bulk_action', 'bulk_job', 'BLK-INV-009', NULL, '{"operation": "bulk_stock_replenish", "entity_type": "products", "item_count": 18, "affected_skus": ["DT-BAN-001", "DT-KAN-004", "DT-ORG-009"]}', 'success', 'Batch inventory stock replenishment applied across 18 catalog lines', '103.21.124.50', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', DATE_SUB(NOW(), INTERVAL 2 HOUR)),

-- 14. Imports / Exports
('corr_exp_1411', 1, 'Gautam Sethi', 'super_admin', 'data_export', 'export', 'EXP-P&L-2026', NULL, '{"format": "csv", "report_type": "manufacturing_pl", "row_count": 142, "file_name": "DT_Brand_Manufacturing_PL_Q3_2026.csv", "sanitized": true}', 'success', 'Exported manufacturing P&L financial spreadsheet with formula injection protection', '147.93.99.134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', DATE_SUB(NOW(), INTERVAL 1 HOUR)),

-- 15. Security Events
('corr_sec_1512', 1, 'Gautam Sethi', 'super_admin', 'security_event', 'security', 'SEC-REVOKE-99', '{"session_id": "sess_8f2940294820", "target_user": "Anil Verma"}', '{"action": "session_revocation", "reason": "Staff mobile lost / untrusted network", "revoked_by": "Gautam Sethi"}', 'warning', 'Security intervention: Immediate session termination enforced for staff device', '147.93.99.134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', DATE_SUB(NOW(), INTERVAL 30 MINUTE));
