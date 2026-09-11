-- ==============================================================================
-- DT BRAND'S & JAI HANUMAN TEX — DATABASE MIGRATION
-- Migration: 2026_09_12_000010_create_admin_security_roles_and_permissions_tables.sql
-- Description: Creates Enterprise Admin Security, Roles, Granular Permissions,
--              Active Sessions, Login Audit, and Security Events tables.
-- ==============================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- ── 1. ADMIN ROLES TABLE ──
CREATE TABLE IF NOT EXISTS `admin_roles` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `slug` VARCHAR(50) NOT NULL UNIQUE,
    `name` VARCHAR(100) NOT NULL,
    `description` VARCHAR(255) DEFAULT NULL,
    `is_system` TINYINT(1) DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_admin_roles_slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 2. ADMIN PERMISSIONS CATALOG TABLE ──
CREATE TABLE IF NOT EXISTS `admin_permissions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `module` VARCHAR(50) NOT NULL,
    `action` VARCHAR(50) NOT NULL,
    `description` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `uq_module_action` (`module`, `action`),
    INDEX `idx_perm_module` (`module`),
    INDEX `idx_perm_action` (`action`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 3. ADMIN ROLE PERMISSIONS MAPPING TABLE ──
CREATE TABLE IF NOT EXISTS `admin_role_permissions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `role_slug` VARCHAR(50) NOT NULL,
    `module` VARCHAR(50) NOT NULL,
    `action` VARCHAR(50) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY `uq_role_module_action` (`role_slug`, `module`, `action`),
    INDEX `idx_role_perm_slug` (`role_slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 4. ADMIN ACTIVE SESSIONS TABLE ──
CREATE TABLE IF NOT EXISTS `admin_sessions` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `session_id` VARCHAR(128) NOT NULL UNIQUE,
    `user_id` INT NOT NULL,
    `user_name` VARCHAR(150) NOT NULL,
    `role` VARCHAR(50) NOT NULL,
    `ip_address` VARCHAR(45) NOT NULL,
    `user_agent` TEXT,
    `device_type` VARCHAR(50) DEFAULT 'desktop',
    `location` VARCHAR(100) DEFAULT 'Surat, Gujarat, IN',
    `status` ENUM('active', 'revoked', 'expired') DEFAULT 'active',
    `last_activity` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_asess_user` (`user_id`),
    INDEX `idx_asess_status` (`status`),
    INDEX `idx_asess_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 5. ADMIN LOGIN AUDIT LEDGER TABLE ──
CREATE TABLE IF NOT EXISTS `admin_login_audit` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT DEFAULT NULL,
    `attempted_identity` VARCHAR(150) NOT NULL,
    `ip_address` VARCHAR(45) NOT NULL,
    `user_agent` TEXT,
    `status` ENUM('success', 'failed_password', 'account_inactive', 'user_not_found', 'session_revoked', 'rate_limited') NOT NULL,
    `failure_reason` VARCHAR(255) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_ala_identity` (`attempted_identity`),
    INDEX `idx_ala_ip` (`ip_address`),
    INDEX `idx_ala_status` (`status`),
    INDEX `idx_ala_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── 6. SECURITY EVENTS & THREAT MONITORING TABLE ──
CREATE TABLE IF NOT EXISTS `security_events` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `category` ENUM('auth', 'permission_denied', 'session_revoked', 'role_changed', 'password_changed', 'account_created', 'account_deactivated', 'brute_force_alert', 'sensitive_export', 'security_policy') NOT NULL,
    `severity` ENUM('info', 'warning', 'critical') DEFAULT 'info',
    `actor_id` INT DEFAULT NULL,
    `actor_name` VARCHAR(150) DEFAULT 'system',
    `target_type` VARCHAR(50) DEFAULT NULL,
    `target_id` VARCHAR(50) DEFAULT NULL,
    `description` TEXT NOT NULL,
    `metadata_json` JSON DEFAULT NULL,
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `user_agent` TEXT DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_sec_category` (`category`),
    INDEX `idx_sec_severity` (`severity`),
    INDEX `idx_sec_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── SEED INITIAL ADMIN ROLES ──
INSERT INTO `admin_roles` (`slug`, `name`, `description`, `is_system`) VALUES
('super_admin', 'Super Admin', 'Full system privilege with staff user management, role definition, and system security bypass.', 1),
('admin', 'Administrator', 'Full commercial operations management across catalog, orders, customers, inventory, and marketing.', 1),
('manager', 'Operations Manager', 'Supervision over orders, inventory fulfillment, shipping dispatch, and payment reconciliation.', 1),
('catalog_staff', 'Catalog Staff', 'Management of products, fabric categories, variants, and wholesale tier pricing.', 1),
('support_staff', 'Customer Support Staff', 'Assistance for customer orders, tracking, review moderation, and customer communication.', 1)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `description` = VALUES(`description`);

-- ── SEED INITIAL PERMISSIONS ──
INSERT IGNORE INTO `admin_permissions` (`module`, `action`, `description`) VALUES
('products', 'view', 'View product catalog and pricing matrix'),
('products', 'create', 'Add new saree / garment designs to catalog'),
('products', 'edit', 'Modify product details, fabrics, and images'),
('products', 'delete', 'Remove products from active catalog'),
('products', 'export', 'Export product list with pricing tiers to CSV/Excel'),
('orders', 'view', 'View wholesale and retail customer orders'),
('orders', 'edit', 'Update order progress stages and address info'),
('orders', 'approve', 'Approve pending wholesale B2B credit orders'),
('orders', 'refund', 'Initiate order refund or reverse credit'),
('orders', 'export', 'Export customer orders with GST and shipping notes'),
('customers', 'view', 'View customer list and B2B profiles'),
('customers', 'edit', 'Update customer business tiers and details'),
('customers', 'approve', 'Approve wholesale / retailer verification tickets'),
('customers', 'export', 'Export customer directories with lifetime revenue'),
('inventory', 'view', 'View warehouse stock balance and ledger'),
('inventory', 'adjust_stock', 'Perform physical count stock corrections'),
('inventory', 'export', 'Export inventory valuation and low-stock reports'),
('payments', 'view', 'View payment transactions and gateway settlements'),
('payments', 'refund', 'Process gateway refund for cancelled orders'),
('payments', 'export', 'Export payment reconciliation reports'),
('shipping', 'view', 'View carrier manifests, tracking and rate zones'),
('shipping', 'edit', 'Update courier partner settings and dispatch states'),
('marketing', 'view', 'View marketing banners and discount campaigns'),
('marketing', 'create', 'Create promotional discount codes and sliders'),
('marketing', 'edit', 'Modify banner copy and coupon restrictions'),
('reviews', 'view', 'View customer product ratings and comments'),
('reviews', 'approve', 'Approve customer feedback for storefront display'),
('reviews', 'delete', 'Remove spam or offensive customer feedback'),
('reports', 'view', 'Access executive dashboards and analytics'),
('reports', 'export', 'Export sensitive financial and operational analytics'),
('users', 'view', 'View administrator and staff user roster'),
('users', 'manage_users', 'Create, update, deactivate, and delete staff accounts'),
('system', 'view_logs', 'Inspect audit trails and security event logs'),
('system', 'manage_settings', 'Modify master site configuration and maintenance');

-- ── SEED ROLE PERMISSIONS (ADMIN) ──
INSERT IGNORE INTO `admin_role_permissions` (`role_slug`, `module`, `action`) VALUES
('admin', 'products', 'view'), ('admin', 'products', 'create'), ('admin', 'products', 'edit'), ('admin', 'products', 'export'),
('admin', 'orders', 'view'), ('admin', 'orders', 'edit'), ('admin', 'orders', 'approve'), ('admin', 'orders', 'refund'), ('admin', 'orders', 'export'),
('admin', 'customers', 'view'), ('admin', 'customers', 'edit'), ('admin', 'customers', 'approve'), ('admin', 'customers', 'export'),
('admin', 'inventory', 'view'), ('admin', 'inventory', 'adjust_stock'), ('admin', 'inventory', 'export'),
('admin', 'payments', 'view'), ('admin', 'payments', 'refund'), ('admin', 'payments', 'export'),
('admin', 'shipping', 'view'), ('admin', 'shipping', 'edit'),
('admin', 'marketing', 'view'), ('admin', 'marketing', 'create'), ('admin', 'marketing', 'edit'),
('admin', 'reviews', 'view'), ('admin', 'reviews', 'approve'), ('admin', 'reviews', 'delete'),
('admin', 'reports', 'view'), ('admin', 'reports', 'export'),
('admin', 'users', 'view'),
('admin', 'system', 'view_logs');

-- ── SEED ROLE PERMISSIONS (OPERATIONS MANAGER) ──
INSERT IGNORE INTO `admin_role_permissions` (`role_slug`, `module`, `action`) VALUES
('manager', 'products', 'view'),
('manager', 'orders', 'view'), ('manager', 'orders', 'edit'), ('manager', 'orders', 'export'),
('manager', 'customers', 'view'),
('manager', 'inventory', 'view'), ('manager', 'inventory', 'adjust_stock'), ('manager', 'inventory', 'export'),
('manager', 'payments', 'view'), ('manager', 'payments', 'export'),
('manager', 'shipping', 'view'), ('manager', 'shipping', 'edit'),
('manager', 'reports', 'view');

-- ── SEED ROLE PERMISSIONS (CATALOG STAFF) ──
INSERT IGNORE INTO `admin_role_permissions` (`role_slug`, `module`, `action`) VALUES
('catalog_staff', 'products', 'view'), ('catalog_staff', 'products', 'create'), ('catalog_staff', 'products', 'edit'), ('catalog_staff', 'products', 'export'),
('catalog_staff', 'inventory', 'view'),
('catalog_staff', 'marketing', 'view'),
('catalog_staff', 'reviews', 'view');

-- ── SEED ROLE PERMISSIONS (SUPPORT STAFF) ──
INSERT IGNORE INTO `admin_role_permissions` (`role_slug`, `module`, `action`) VALUES
('support_staff', 'products', 'view'),
('support_staff', 'orders', 'view'),
('support_staff', 'customers', 'view'),
('support_staff', 'shipping', 'view'),
('support_staff', 'reviews', 'view'), ('support_staff', 'reviews', 'approve');

-- ── SEED SAMPLE LOGIN AUDIT ROWS ──
INSERT IGNORE INTO `admin_login_audit` (`user_id`, `attempted_identity`, `ip_address`, `user_agent`, `status`, `failure_reason`, `created_at`) VALUES
(1, 'admin@dtbrand.in', '147.93.99.134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0.0.0', 'success', NULL, DATE_SUB(NOW(), INTERVAL 15 MINUTE)),
(1, 'admin@dtbrand.in', '103.241.226.11', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Safari/605.1.15', 'success', NULL, DATE_SUB(NOW(), INTERVAL 3 HOUR)),
(NULL, 'test_intruder@gmail.com', '185.220.101.5', 'Python-urllib/3.11', 'user_not_found', 'User identity does not exist', DATE_SUB(NOW(), INTERVAL 6 HOUR)),
(1, 'admin@dtbrand.in', '147.93.99.134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)', 'success', NULL, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(NULL, 'staff@dtbrand.in', '45.133.1.88', 'curl/7.88.1', 'failed_password', 'Invalid credentials provided', DATE_SUB(NOW(), INTERVAL 2 DAY));

-- ── SEED SAMPLE SECURITY EVENTS ──
INSERT IGNORE INTO `security_events` (`category`, `severity`, `actor_id`, `actor_name`, `target_type`, `target_id`, `description`, `ip_address`, `created_at`) VALUES
('auth', 'info', 1, 'DT Brand Admin', 'session', 'sess_master_001', 'Master Administrator authenticated via secure console', '147.93.99.134', DATE_SUB(NOW(), INTERVAL 15 MINUTE)),
('security_policy', 'info', 1, 'DT Brand Admin', 'security_matrix', 'roles_all', 'Granular Role-Permission matrix initialized and calibrated', '147.93.99.134', DATE_SUB(NOW(), INTERVAL 1 HOUR)),
('brute_force_alert', 'warning', NULL, 'Firewall Guardian', 'ip_block', '185.220.101.5', 'Multiple failed admin authentication attempts detected and throttled', '185.220.101.5', DATE_SUB(NOW(), INTERVAL 6 HOUR)),
('sensitive_export', 'info', 1, 'DT Brand Admin', 'report', 'revenue_pl', 'Executive P&L Financial Statement exported to CSV with formula protection', '147.93.99.134', DATE_SUB(NOW(), INTERVAL 12 HOUR)),
('role_changed', 'info', 1, 'DT Brand Admin', 'user', '2', 'Updated permissions for Operations Manager role', '147.93.99.134', DATE_SUB(NOW(), INTERVAL 1 DAY));

SET FOREIGN_KEY_CHECKS = 1;
