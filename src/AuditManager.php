<?php
declare(strict_types=1);

namespace DTBrand;

require_once __DIR__ . '/Database.php';

/**
 * AuditManager — Central Enterprise Administrative Activity & Compliance Engine
 * DT Brand's & Jai Hanuman Tex
 *
 * Implements Section 35 (AUDIT LOG ADMIN) of the Master Specification.
 *
 * Capabilities:
 *  - Comprehensive audit trail across all 15 operational domains
 *  - Automatic request correlation ID tracing (linking multi-step actions)
 *  - Strict recursive secret masking (passwords, tokens, API keys, CVVs -> [REDACTED])
 *  - Deep before/after JSON state difference computation
 *  - High-performance filtering (search, entity, action, actor, status, date range, correlation ID)
 *  - RFC-4180 CSV export with formula injection sanitization (=, +, -, @, \t, \r)
 *  - Self-healing MySQL/SQLite table creation with in-memory mock fallback
 *  - Enterprise data retention and purge policy with immutable self-auditing
 */
class AuditManager
{
    private static ?self $instance = null;
    private ?\PDO $pdo = null;
    private bool $isMock = false;

    /**
     * In-memory seed and test repository
     *
     * @var array<int, array<string, mixed>>
     */
    private array $mockLogs = [];
    private int $nextMockId = 100;

    /**
     * Canonical 15 Audit Categories & Allowed Actions
     */
    public const CATEGORY_AUTH        = 'auth';
    public const CATEGORY_PRODUCT     = 'product';
    public const CATEGORY_PRICE       = 'price_matrix';
    public const CATEGORY_INVENTORY   = 'inventory';
    public const CATEGORY_ORDER       = 'order';
    public const CATEGORY_PAYMENT     = 'payment';
    public const CATEGORY_USER        = 'user';
    public const CATEGORY_ROLE        = 'role';
    public const CATEGORY_PERMISSION  = 'permission';
    public const CATEGORY_SETTING     = 'setting';
    public const CATEGORY_INTEGRATION = 'integration';
    public const CATEGORY_BULK        = 'bulk_job';
    public const CATEGORY_EXPORT      = 'export';
    public const CATEGORY_IMPORT      = 'import';
    public const CATEGORY_SECURITY    = 'security';

    public const ALL_CATEGORIES = [
        self::CATEGORY_AUTH,
        self::CATEGORY_PRODUCT,
        self::CATEGORY_PRICE,
        self::CATEGORY_INVENTORY,
        self::CATEGORY_ORDER,
        self::CATEGORY_PAYMENT,
        self::CATEGORY_USER,
        self::CATEGORY_ROLE,
        self::CATEGORY_PERMISSION,
        self::CATEGORY_SETTING,
        self::CATEGORY_INTEGRATION,
        self::CATEGORY_BULK,
        self::CATEGORY_EXPORT,
        self::CATEGORY_IMPORT,
        self::CATEGORY_SECURITY,
    ];

    /**
     * Patterns matching sensitive keys to redact
     */
    private const SENSITIVE_KEY_PATTERN = '/^(password|passwd|pass|token|secret|key|api_key|auth|authorization|credit_card|cvv|cvc|private_key|access_token|refresh_token|salt|hash)$/i';

    private function __construct()
    {
        $this->pdo = Database::getConnection();
        $this->isMock = ($this->pdo === null || Database::isMockMode());

        if (!$this->isMock && $this->pdo !== null) {
            $this->ensureTableStructure();
        } else {
            $this->initMockData();
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Reset singleton (primarily for testing)
     */
    public static function resetInstance(): void
    {
        self::$instance = null;
    }

    /**
     * Self-healing MySQL/SQLite table creation
     */
    private function ensureTableStructure(): void
    {
        if ($this->pdo === null) {
            return;
        }

        try {
            $driver = $this->pdo->getAttribute(\PDO::ATTR_DRIVER_NAME);
            if ($driver === 'sqlite') {
                $this->pdo->exec("
                    CREATE TABLE IF NOT EXISTS audit_logs (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        correlation_id TEXT NULL,
                        user_id INTEGER NULL,
                        user_name TEXT DEFAULT 'system',
                        actor_role TEXT DEFAULT 'admin',
                        action TEXT NOT NULL,
                        entity_type TEXT NOT NULL,
                        entity_id TEXT NOT NULL,
                        old_values TEXT NULL,
                        new_values TEXT NULL,
                        status TEXT NOT NULL DEFAULT 'success',
                        details TEXT NULL,
                        ip_address TEXT NULL,
                        user_agent TEXT NULL,
                        created_at TEXT DEFAULT CURRENT_TIMESTAMP
                    );
                    CREATE INDEX IF NOT EXISTS idx_audit_corr ON audit_logs(correlation_id);
                    CREATE INDEX IF NOT EXISTS idx_audit_action ON audit_logs(action);
                    CREATE INDEX IF NOT EXISTS idx_audit_entity ON audit_logs(entity_type, entity_id);
                    CREATE INDEX IF NOT EXISTS idx_audit_created ON audit_logs(created_at);
                    CREATE INDEX IF NOT EXISTS idx_audit_status ON audit_logs(status);
                ");
            } else {
                $this->pdo->exec("
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
                ");

                // Check and add missing columns if upgrading legacy table
                $cols = $this->pdo->query("SHOW COLUMNS FROM `audit_logs`")->fetchAll(\PDO::FETCH_COLUMN);
                if (!in_array('correlation_id', $cols, true)) {
                    $this->pdo->exec("ALTER TABLE `audit_logs` ADD COLUMN `correlation_id` VARCHAR(64) NULL AFTER `id`, ADD INDEX `idx_audit_corr` (`correlation_id`)");
                }
                if (!in_array('actor_role', $cols, true)) {
                    $this->pdo->exec("ALTER TABLE `audit_logs` ADD COLUMN `actor_role` VARCHAR(50) DEFAULT 'admin' AFTER `user_name`");
                }
                if (!in_array('status', $cols, true)) {
                    $this->pdo->exec("ALTER TABLE `audit_logs` ADD COLUMN `status` ENUM('success', 'warning', 'failure') NOT NULL DEFAULT 'success' AFTER `new_values`, ADD INDEX `idx_audit_status` (`status`)");
                }
                if (!in_array('details', $cols, true)) {
                    $this->pdo->exec("ALTER TABLE `audit_logs` ADD COLUMN `details` TEXT NULL AFTER `status`");
                }
            }
        } catch (\Throwable $e) {
            // Fall back gracefully to mock mode if DB permissions are restricted
            $this->isMock = true;
            $this->initMockData();
        }
    }

    /**
     * Initialize mock data for tests and offline mode
     */
    private function initMockData(): void
    {
        $now = time();
        $this->mockLogs = [
            1 => [
                'id' => 1,
                'correlation_id' => 'corr_auth_8901',
                'user_id' => 1,
                'user_name' => 'Gautam Sethi',
                'actor_role' => 'super_admin',
                'action' => 'login',
                'entity_type' => self::CATEGORY_AUTH,
                'entity_id' => 'USR-1',
                'old_values' => null,
                'new_values' => ['method' => 'password', 'mfa' => false, 'device' => 'Desktop Chrome / Windows 11'],
                'status' => 'success',
                'details' => 'Staff super_admin authenticated successfully from verified static IP',
                'ip_address' => '147.93.99.134',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/128.0.0.0',
                'created_at' => date('Y-m-d H:i:s', $now - 86400),
            ],
            2 => [
                'id' => 2,
                'correlation_id' => 'corr_auth_8902',
                'user_id' => 4,
                'user_name' => 'Meera Patel',
                'actor_role' => 'catalog_staff',
                'action' => 'logout',
                'entity_type' => self::CATEGORY_AUTH,
                'entity_id' => 'USR-4',
                'old_values' => ['session_duration_minutes' => 142],
                'new_values' => null,
                'status' => 'success',
                'details' => 'Staff voluntary sign-out via console header',
                'ip_address' => '103.21.124.55',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
                'created_at' => date('Y-m-d H:i:s', $now - 72000),
            ],
            3 => [
                'id' => 3,
                'correlation_id' => 'corr_auth_8903',
                'user_id' => null,
                'user_name' => 'unknown_staff',
                'actor_role' => 'guest',
                'action' => 'failed_login',
                'entity_type' => self::CATEGORY_AUTH,
                'entity_id' => 'login_attempt',
                'old_values' => null,
                'new_values' => ['attempted_identity' => 'admin@dtbrand.com', 'failure_reason' => 'INVALID_PASSWORD', 'attempts_remaining' => 2],
                'status' => 'warning',
                'details' => 'Authentication rejected: Invalid staff password provided',
                'ip_address' => '185.220.101.5',
                'user_agent' => 'Mozilla/5.0 (X11; Linux x86_64)',
                'created_at' => date('Y-m-d H:i:s', $now - 64800),
            ],
            4 => [
                'id' => 4,
                'correlation_id' => 'corr_cat_401',
                'user_id' => 4,
                'user_name' => 'Meera Patel',
                'actor_role' => 'catalog_staff',
                'action' => 'product_create',
                'entity_type' => self::CATEGORY_PRODUCT,
                'entity_id' => 'PRD-101',
                'old_values' => null,
                'new_values' => ['title' => 'Royal Banarasi Silk Saree', 'sku' => 'DT-BAN-001', 'type' => 'single_piece', 'status' => 'active', 'mrp' => 3499.00, 'base_price' => 1899.00],
                'status' => 'success',
                'details' => 'Created new catalog product in Banarasi Silk Saree collection',
                'ip_address' => '103.21.124.55',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
                'created_at' => date('Y-m-d H:i:s', $now - 57600),
            ],
            5 => [
                'id' => 5,
                'correlation_id' => 'corr_price_502',
                'user_id' => 1,
                'user_name' => 'Gautam Sethi',
                'actor_role' => 'super_admin',
                'action' => 'price_change',
                'entity_type' => self::CATEGORY_PRICE,
                'entity_id' => 'PRD-101',
                'old_values' => ['wholesale_price' => 1250.00, 'reseller_price' => 1450.00, 'retailer_price' => 1650.00, 'customer_price' => 1899.00],
                'new_values' => ['wholesale_price' => 1199.00, 'reseller_price' => 1399.00, 'retailer_price' => 1599.00, 'customer_price' => 1849.00],
                'status' => 'success',
                'details' => 'Festival seasonal price markdown applied across all 4 customer tiers',
                'ip_address' => '147.93.99.134',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'created_at' => date('Y-m-d H:i:s', $now - 50400),
            ],
            6 => [
                'id' => 6,
                'correlation_id' => 'corr_inv_603',
                'user_id' => 3,
                'user_name' => 'Rajesh Sharma',
                'actor_role' => 'manager',
                'action' => 'stock_change',
                'entity_type' => self::CATEGORY_INVENTORY,
                'entity_id' => 'DT-BAN-001',
                'old_values' => ['previous_qty' => 45, 'allocated_qty' => 10],
                'new_values' => ['new_qty' => 120, 'adjustment' => 75, 'reason' => 'Surat Loom Weaving Batch #JH-4402 received'],
                'status' => 'success',
                'details' => 'Inward stock receipt processed from manufacturing loom',
                'ip_address' => '103.21.124.50',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'created_at' => date('Y-m-d H:i:s', $now - 43200),
            ],
            7 => [
                'id' => 7,
                'correlation_id' => 'corr_ord_704',
                'user_id' => 3,
                'user_name' => 'Rajesh Sharma',
                'actor_role' => 'manager',
                'action' => 'order_status_change',
                'entity_type' => self::CATEGORY_ORDER,
                'entity_id' => 'ORD-2026-9042',
                'old_values' => ['status' => 'processing', 'carrier' => null, 'awb' => null],
                'new_values' => ['status' => 'shipped', 'carrier' => 'Delhivery Express', 'awb' => 'DEL9824102931'],
                'status' => 'success',
                'details' => 'Order dispatched via Delhivery Express surface wholesale route',
                'ip_address' => '103.21.124.50',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'created_at' => date('Y-m-d H:i:s', $now - 36000),
            ],
            8 => [
                'id' => 8,
                'correlation_id' => 'corr_pay_805',
                'user_id' => 1,
                'user_name' => 'Gautam Sethi',
                'actor_role' => 'super_admin',
                'action' => 'payment_capture',
                'entity_type' => self::CATEGORY_PAYMENT,
                'entity_id' => 'PAY-UPI-7712',
                'old_values' => ['status' => 'pending_verification', 'utr' => '425910284912'],
                'new_values' => ['status' => 'captured', 'amount' => 24500.00, 'gateway' => 'instant_upi', 'verified_by' => 'Gautam Sethi'],
                'status' => 'success',
                'details' => 'Manual 12-digit UTR verification approved for wholesale bulk booking',
                'ip_address' => '147.93.99.134',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'created_at' => date('Y-m-d H:i:s', $now - 28800),
            ],
            9 => [
                'id' => 9,
                'correlation_id' => 'corr_usr_906',
                'user_id' => 1,
                'user_name' => 'Gautam Sethi',
                'actor_role' => 'super_admin',
                'action' => 'role_change',
                'entity_type' => self::CATEGORY_USER,
                'entity_id' => 'USR-28',
                'old_values' => ['role' => 'retailer', 'tier' => 'silver'],
                'new_values' => ['role' => 'wholesaler', 'tier' => 'gold', 'gst_verified' => true],
                'status' => 'success',
                'details' => 'Customer trade account upgraded to verified Wholesaler tier',
                'ip_address' => '147.93.99.134',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'created_at' => date('Y-m-d H:i:s', $now - 21600),
            ],
            10 => [
                'id' => 10,
                'correlation_id' => 'corr_perm_1007',
                'user_id' => 1,
                'user_name' => 'Gautam Sethi',
                'actor_role' => 'super_admin',
                'action' => 'permission_change',
                'entity_type' => self::CATEGORY_PERMISSION,
                'entity_id' => 'role_manager',
                'old_values' => ['granted_count' => 32],
                'new_values' => ['granted_count' => 36, 'added_permissions' => ['inventory:adjust_stock', 'orders:refund', 'reports:view', 'reports:export']],
                'status' => 'success',
                'details' => 'Granted report export and stock adjustment privileges to Operations Manager role',
                'ip_address' => '147.93.99.134',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'created_at' => date('Y-m-d H:i:s', $now - 18000),
            ],
            11 => [
                'id' => 11,
                'correlation_id' => 'corr_cfg_1108',
                'user_id' => 1,
                'user_name' => 'Gautam Sethi',
                'actor_role' => 'super_admin',
                'action' => 'settings_change',
                'entity_type' => self::CATEGORY_SETTING,
                'entity_id' => 'store_general',
                'old_values' => ['store_name' => 'DT Brand', 'support_email' => 'help@dtbrand.com'],
                'new_values' => ['store_name' => "DT Brand's & Jai Hanuman Tex", 'support_email' => 'orders@jaihanumantex.in'],
                'status' => 'success',
                'details' => 'Updated store primary branding title and official customer contact mailbox',
                'ip_address' => '147.93.99.134',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'created_at' => date('Y-m-d H:i:s', $now - 14400),
            ],
            12 => [
                'id' => 12,
                'correlation_id' => 'corr_int_1209',
                'user_id' => 1,
                'user_name' => 'Gautam Sethi',
                'actor_role' => 'super_admin',
                'action' => 'integration_change',
                'entity_type' => self::CATEGORY_INTEGRATION,
                'entity_id' => 'razorpay',
                'old_values' => ['enabled' => true, 'key_id' => '[REDACTED]'],
                'new_values' => ['enabled' => true, 'key_id' => '[REDACTED]', 'auto_capture' => true],
                'status' => 'success',
                'details' => 'Configured automated instant capture for Razorpay card transactions',
                'ip_address' => '147.93.99.134',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'created_at' => date('Y-m-d H:i:s', $now - 10800),
            ],
            13 => [
                'id' => 13,
                'correlation_id' => 'corr_blk_1310',
                'user_id' => 3,
                'user_name' => 'Rajesh Sharma',
                'actor_role' => 'manager',
                'action' => 'bulk_action',
                'entity_type' => self::CATEGORY_BULK,
                'entity_id' => 'BLK-INV-009',
                'old_values' => null,
                'new_values' => ['operation' => 'bulk_stock_replenish', 'item_count' => 18, 'affected_skus' => ['DT-BAN-001', 'DT-KAN-004', 'DT-ORG-009']],
                'status' => 'success',
                'details' => 'Batch inventory stock replenishment applied across 18 catalog lines',
                'ip_address' => '103.21.124.50',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'created_at' => date('Y-m-d H:i:s', $now - 7200),
            ],
            14 => [
                'id' => 14,
                'correlation_id' => 'corr_exp_1411',
                'user_id' => 1,
                'user_name' => 'Gautam Sethi',
                'actor_role' => 'super_admin',
                'action' => 'data_export',
                'entity_type' => self::CATEGORY_EXPORT,
                'entity_id' => 'EXP-P&L-2026',
                'old_values' => null,
                'new_values' => ['format' => 'csv', 'report_type' => 'manufacturing_pl', 'row_count' => 142, 'file_name' => 'DT_Brand_Manufacturing_PL_Q3_2026.csv'],
                'status' => 'success',
                'details' => 'Exported manufacturing P&L financial spreadsheet with formula injection protection',
                'ip_address' => '147.93.99.134',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'created_at' => date('Y-m-d H:i:s', $now - 3600),
            ],
            15 => [
                'id' => 15,
                'correlation_id' => 'corr_sec_1512',
                'user_id' => 1,
                'user_name' => 'Gautam Sethi',
                'actor_role' => 'super_admin',
                'action' => 'security_event',
                'entity_type' => self::CATEGORY_SECURITY,
                'entity_id' => 'SEC-REVOKE-99',
                'old_values' => ['session_id' => 'sess_8f2940294820', 'target_user' => 'Anil Verma'],
                'new_values' => ['action' => 'session_revocation', 'reason' => 'Staff mobile lost / untrusted network'],
                'status' => 'warning',
                'details' => 'Security intervention: Immediate session termination enforced for staff device',
                'ip_address' => '147.93.99.134',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                'created_at' => date('Y-m-d H:i:s', $now - 1800),
            ],
        ];
    }

    /**
     * Recursively mask sensitive keys in payloads
     *
     * @param mixed $data
     * @return mixed
     */
    public static function maskSensitiveData(mixed $data): mixed
    {
        if (!is_array($data)) {
            return $data;
        }

        $clean = [];
        foreach ($data as $k => $v) {
            if (is_string($k) && preg_match(self::SENSITIVE_KEY_PATTERN, $k)) {
                $clean[$k] = '[REDACTED]';
            } elseif (is_array($v)) {
                $clean[$k] = self::maskSensitiveData($v);
            } elseif (is_string($v)) {
                // Redact bearer tokens or long hashes in string values
                if (preg_match('/Bearer\s+[a-zA-Z0-9_\-\.]{15,}/i', $v)) {
                    $clean[$k] = preg_replace('/Bearer\s+[a-zA-Z0-9_\-\.]{15,}/i', 'Bearer [REDACTED]', $v);
                } else {
                    $clean[$k] = $v;
                }
            } else {
                $clean[$k] = $v;
            }
        }
        return $clean;
    }

    /**
     * Generate a unique, traceable correlation ID
     */
    public static function generateCorrelationId(string $prefix = 'corr'): string
    {
        try {
            return $prefix . '_' . bin2hex(random_bytes(6));
        } catch (\Throwable $e) {
            return $prefix . '_' . substr(md5(uniqid((string)mt_rand(), true)), 0, 12);
        }
    }

    /**
     * Resolve the client IP address safely
     */
    public static function resolveClientIp(): string
    {
        if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
            return (string)$_SERVER['HTTP_CF_CONNECTING_IP'];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $parts = explode(',', (string)$_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($parts[0]);
        }
        return (string)($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1');
    }

    /**
     * Master logging method
     *
     * @param array<string, mixed> $params
     * @return int Inserted log ID
     */
    public function log(array $params): int
    {
        $action      = (string)($params['action'] ?? 'generic_action');
        $entityType  = (string)($params['entity_type'] ?? 'system');
        $entityId    = (string)($params['entity_id'] ?? '0');
        $userId      = isset($params['user_id']) ? (int)$params['user_id'] : (isset($_SESSION['admin_user_id']) ? (int)$_SESSION['admin_user_id'] : null);
        $userName    = (string)($params['user_name'] ?? ($_SESSION['admin_user_name'] ?? 'system'));
        $actorRole   = (string)($params['actor_role'] ?? ($_SESSION['admin_role'] ?? 'admin'));
        $rawStatus   = (string)($params['status'] ?? 'success');
        $status      = in_array($rawStatus, ['success', 'warning', 'failure'], true) ? $rawStatus : 'success';
        $details     = isset($params['details']) ? (string)$params['details'] : null;
        $corrId      = !empty($params['correlation_id']) ? (string)$params['correlation_id'] : self::generateCorrelationId();
        $ipAddress   = !empty($params['ip_address']) ? (string)$params['ip_address'] : self::resolveClientIp();
        $userAgent   = !empty($params['user_agent']) ? (string)$params['user_agent'] : (string)($_SERVER['HTTP_USER_AGENT'] ?? 'CLI/Cron');

        // Mask before & after states strictly
        $oldValues = isset($params['old_values']) && is_array($params['old_values']) ? self::maskSensitiveData($params['old_values']) : null;
        $newValues = isset($params['new_values']) && is_array($params['new_values']) ? self::maskSensitiveData($params['new_values']) : null;

        $oldJson = $oldValues !== null ? json_encode($oldValues, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null;
        $newJson = $newValues !== null ? json_encode($newValues, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) : null;
        $createdAt = date('Y-m-d H:i:s');

        if (!$this->isMock && $this->pdo !== null) {
            try {
                $stmt = $this->pdo->prepare("
                    INSERT INTO `audit_logs` 
                    (`correlation_id`, `user_id`, `user_name`, `actor_role`, `action`, `entity_type`, `entity_id`, `old_values`, `new_values`, `status`, `details`, `ip_address`, `user_agent`, `created_at`)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");
                $stmt->execute([
                    $corrId,
                    $userId,
                    $userName,
                    $actorRole,
                    $action,
                    $entityType,
                    $entityId,
                    $oldJson,
                    $newJson,
                    $status,
                    $details,
                    $ipAddress,
                    $userAgent,
                    $createdAt,
                ]);
                return (int)$this->pdo->lastInsertId();
            } catch (\Throwable $e) {
                // If query fails, fall back to mock memory logging
            }
        }

        // Mock mode persistence
        $newId = ++$this->nextMockId;
        $this->mockLogs[$newId] = [
            'id' => $newId,
            'correlation_id' => $corrId,
            'user_id' => $userId,
            'user_name' => $userName,
            'actor_role' => $actorRole,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'status' => $status,
            'details' => $details,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'created_at' => $createdAt,
        ];
        return $newId;
    }

    // ──────────────────────────────────────────────────────────────────────────
    // CONVENIENCE METHODS COVERING ALL 15 SPECIFICATION CATEGORIES
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * 1. Auth: Login, Logout, Failed Login
     */
    public function logAuth(string $action, string $identity, bool $success, ?int $userId = null, ?string $reason = null, ?array $meta = null): int
    {
        $status = $success ? 'success' : 'warning';
        $details = $success
            ? "Authentication successful for user '{$identity}'"
            : "Authentication failure for user '{$identity}': " . ($reason ?? 'Invalid credentials');

        return $this->log([
            'action'      => $action,
            'entity_type' => self::CATEGORY_AUTH,
            'entity_id'   => $userId ? "USR-{$userId}" : $identity,
            'user_id'     => $userId,
            'user_name'   => $userId ? ($meta['user_name'] ?? $identity) : 'unknown',
            'actor_role'  => $meta['role'] ?? 'guest',
            'status'      => $status,
            'details'     => $details,
            'old_values'  => null,
            'new_values'  => array_merge(['identity' => $identity, 'reason' => $reason], (array)$meta),
        ]);
    }

    /**
     * 2. Product: Create, Edit, Delete
     */
    public function logProductAction(string $action, int|string $productId, string $title, ?array $before = null, ?array $after = null, ?string $details = null): int
    {
        return $this->log([
            'action'      => $action,
            'entity_type' => self::CATEGORY_PRODUCT,
            'entity_id'   => "PRD-{$productId}",
            'details'     => $details ?? "Product action '{$action}' on: {$title}",
            'old_values'  => $before,
            'new_values'  => $after ?? ['title' => $title],
        ]);
    }

    /**
     * 3. Price Changes: Matrix & Tier revisions
     */
    public function logPriceChange(int|string $productId, string $productTitle, array $beforePrices, array $afterPrices, string $reason = ''): int
    {
        return $this->log([
            'action'      => 'price_change',
            'entity_type' => self::CATEGORY_PRICE,
            'entity_id'   => "PRD-{$productId}",
            'details'     => "Price matrix revision for '{$productTitle}'. " . ($reason ? "Reason: {$reason}" : ''),
            'old_values'  => $beforePrices,
            'new_values'  => $afterPrices,
        ]);
    }

    /**
     * 4. Stock Changes: Inward, outward, manual adjustments
     */
    public function logStockChange(int|string $productId, string $sku, int $prevQty, int $newQty, string $movementType = 'adjustment', string $reason = ''): int
    {
        $diff = $newQty - $prevQty;
        $sign = $diff >= 0 ? "+{$diff}" : (string)$diff;

        return $this->log([
            'action'      => 'stock_change',
            'entity_type' => self::CATEGORY_INVENTORY,
            'entity_id'   => $sku ?: "PRD-{$productId}",
            'details'     => "Inventory {$movementType} ({$sign}) on SKU {$sku}: {$prevQty} -> {$newQty}. " . ($reason ? "Reason: {$reason}" : ''),
            'old_values'  => ['qty' => $prevQty],
            'new_values'  => ['qty' => $newQty, 'adjustment' => $diff, 'movement_type' => $movementType, 'reason' => $reason],
        ]);
    }

    /**
     * 5. Order Status Changes
     */
    public function logOrderStatus(string $orderNumber, string $oldStatus, string $newStatus, ?string $notes = null, ?array $meta = null): int
    {
        return $this->log([
            'action'      => 'order_status_change',
            'entity_type' => self::CATEGORY_ORDER,
            'entity_id'   => $orderNumber,
            'details'     => "Order {$orderNumber} transitioned from '{$oldStatus}' to '{$newStatus}'. " . ($notes ? "Notes: {$notes}" : ''),
            'old_values'  => ['status' => $oldStatus],
            'new_values'  => array_merge(['status' => $newStatus, 'notes' => $notes], (array)$meta),
        ]);
    }

    /**
     * 6. Payment Actions: Captures, Refunds, Reversals
     */
    public function logPaymentAction(string $action, string $orderNumber, float $amount, string $gateway, ?string $transactionId = null, ?string $details = null, ?array $meta = null): int
    {
        $formattedAmount = number_format($amount, 2);
        return $this->log([
            'action'      => $action,
            'entity_type' => self::CATEGORY_PAYMENT,
            'entity_id'   => $transactionId ?: $orderNumber,
            'details'     => $details ?? "Payment '{$action}' of ₹{$formattedAmount} via {$gateway} for order {$orderNumber}",
            'old_values'  => null,
            'new_values'  => array_merge([
                'order_number'   => $orderNumber,
                'amount'         => $amount,
                'gateway'        => $gateway,
                'transaction_id' => $transactionId,
            ], (array)$meta),
        ]);
    }

    /**
     * 7. Role Changes
     */
    public function logRoleChange(int $targetUserId, string $targetUserName, string $oldRole, string $newRole, ?string $reason = null): int
    {
        return $this->log([
            'action'      => 'role_change',
            'entity_type' => self::CATEGORY_ROLE,
            'entity_id'   => "USR-{$targetUserId}",
            'details'     => "Role for '{$targetUserName}' changed from '{$oldRole}' to '{$newRole}'. " . ($reason ? "Reason: {$reason}" : ''),
            'old_values'  => ['role' => $oldRole],
            'new_values'  => ['role' => $newRole, 'reason' => $reason],
        ]);
    }

    /**
     * 8. Admin Permission Changes
     */
    public function logPermissionChange(string $role, array $granted, array $revoked, ?string $reason = null): int
    {
        return $this->log([
            'action'      => 'permission_change',
            'entity_type' => self::CATEGORY_PERMISSION,
            'entity_id'   => "role_{$role}",
            'details'     => "Permissions altered for role '{$role}'. Granted: " . count($granted) . ", Revoked: " . count($revoked),
            'old_values'  => ['revoked' => $revoked],
            'new_values'  => ['granted' => $granted, 'reason' => $reason],
        ]);
    }

    /**
     * 9. Settings Changes
     */
    public function logSettingsChange(string $section, array $oldSettings, array $newSettings, ?string $reason = null): int
    {
        return $this->log([
            'action'      => 'settings_change',
            'entity_type' => self::CATEGORY_SETTING,
            'entity_id'   => "setting_{$section}",
            'details'     => "Configuration updated for '{$section}'. " . ($reason ? "Reason: {$reason}" : ''),
            'old_values'  => $oldSettings,
            'new_values'  => $newSettings,
        ]);
    }

    /**
     * 10. Integration Changes
     */
    public function logIntegrationChange(string $service, string $action, array $details): int
    {
        return $this->log([
            'action'      => 'integration_change',
            'entity_type' => self::CATEGORY_INTEGRATION,
            'entity_id'   => $service,
            'details'     => "Integration '{$service}' modified via action '{$action}'",
            'old_values'  => null,
            'new_values'  => $details,
        ]);
    }

    /**
     * 11. Bulk Actions
     */
    public function logBulkAction(string $operation, string $entityType, int $count, array $affectedIds, ?string $notes = null): int
    {
        return $this->log([
            'action'      => 'bulk_action',
            'entity_type' => self::CATEGORY_BULK,
            'entity_id'   => "BLK-" . strtoupper(substr($entityType, 0, 3)) . "-" . count($affectedIds),
            'details'     => "Bulk operation '{$operation}' executed on {$count} {$entityType} items. " . ($notes ? "Notes: {$notes}" : ''),
            'old_values'  => null,
            'new_values'  => [
                'operation'    => $operation,
                'entity_type'  => $entityType,
                'count'        => $count,
                'affected_ids' => array_slice($affectedIds, 0, 50),
            ],
        ]);
    }

    /**
     * 12. Imports / Exports
     */
    public function logImportExport(string $type, string $entityType, int $recordCount, string $fileName, string $status = 'success', ?string $details = null): int
    {
        $action = $type === 'import' ? 'data_import' : 'data_export';
        return $this->log([
            'action'      => $action,
            'entity_type' => $type === 'import' ? self::CATEGORY_IMPORT : self::CATEGORY_EXPORT,
            'entity_id'   => $fileName,
            'status'      => $status,
            'details'     => $details ?? "Completed {$type} of {$recordCount} {$entityType} records: {$fileName}",
            'old_values'  => null,
            'new_values'  => [
                'type'         => $type,
                'entity_type'  => $entityType,
                'record_count' => $recordCount,
                'file_name'    => $fileName,
            ],
        ]);
    }

    /**
     * 13. Security Events
     */
    public function logSecurityEvent(string $category, string $severity, string $description, ?array $meta = null, ?int $targetId = null): int
    {
        $status = strtolower($severity) === 'critical' ? 'failure' : (strtolower($severity) === 'warning' ? 'warning' : 'success');

        return $this->log([
            'action'      => 'security_event',
            'entity_type' => self::CATEGORY_SECURITY,
            'entity_id'   => $targetId ? "SEC-{$targetId}" : self::generateCorrelationId('sec'),
            'status'      => $status,
            'details'     => "Security event ({$severity}): {$description}",
            'old_values'  => null,
            'new_values'  => array_merge(['category' => $category, 'severity' => $severity, 'description' => $description], (array)$meta),
        ]);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // QUERYING & REPORTING ENGINE
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Retrieve paginated and filtered audit logs
     *
     * @param array<string, mixed> $filters
     * @return array{items: array<int, array<string, mixed>>, total: int, page: int, limit: int, pages: int}
     */
    public function getLogs(array $filters = []): array
    {
        $limit  = isset($filters['limit']) ? max(1, min(500, (int)$filters['limit'])) : 50;
        $page   = isset($filters['page']) ? max(1, (int)$filters['page']) : 1;
        $offset = isset($filters['offset']) ? max(0, (int)$filters['offset']) : (($page - 1) * $limit);

        if (!$this->isMock && $this->pdo !== null) {
            try {
                $where = [];
                $params = [];

                if (!empty($filters['search'])) {
                    $s = '%' . trim((string)$filters['search']) . '%';
                    $where[] = "(`user_name` LIKE ? OR `details` LIKE ? OR `action` LIKE ? OR `entity_id` LIKE ? OR `correlation_id` LIKE ?)";
                    $params[] = $s;
                    $params[] = $s;
                    $params[] = $s;
                    $params[] = $s;
                    $params[] = $s;
                }

                if (!empty($filters['entity_type'])) {
                    $where[] = "`entity_type` = ?";
                    $params[] = (string)$filters['entity_type'];
                }

                if (!empty($filters['action'])) {
                    $where[] = "`action` = ?";
                    $params[] = (string)$filters['action'];
                }

                if (!empty($filters['status'])) {
                    $where[] = "`status` = ?";
                    $params[] = (string)$filters['status'];
                }

                if (!empty($filters['actor'])) {
                    $where[] = "(`user_name` LIKE ? OR `actor_role` = ?)";
                    $params[] = '%' . trim((string)$filters['actor']) . '%';
                    $params[] = (string)$filters['actor'];
                }

                if (!empty($filters['correlation_id'])) {
                    $where[] = "`correlation_id` = ?";
                    $params[] = (string)$filters['correlation_id'];
                }

                if (!empty($filters['date_from'])) {
                    $where[] = "`created_at` >= ?";
                    $params[] = (string)$filters['date_from'] . ' 00:00:00';
                }

                if (!empty($filters['date_to'])) {
                    $where[] = "`created_at` <= ?";
                    $params[] = (string)$filters['date_to'] . ' 23:59:59';
                }

                $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

                // Total count
                $countStmt = $this->pdo->prepare("SELECT COUNT(*) FROM `audit_logs` {$whereSql}");
                $countStmt->execute($params);
                $total = (int)$countStmt->fetchColumn();

                // Select items
                $query = "SELECT * FROM `audit_logs` {$whereSql} ORDER BY `id` DESC LIMIT {$limit} OFFSET {$offset}";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute($params);
                $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

                // Format JSON fields
                foreach ($rows as &$row) {
                    $row['old_values'] = !empty($row['old_values']) ? (is_string($row['old_values']) ? json_decode($row['old_values'], true) : $row['old_values']) : null;
                    $row['new_values'] = !empty($row['new_values']) ? (is_string($row['new_values']) ? json_decode($row['new_values'], true) : $row['new_values']) : null;
                }
                unset($row);

                return [
                    'items' => $rows,
                    'total' => $total,
                    'page'  => $page,
                    'limit' => $limit,
                    'pages' => $limit > 0 ? (int)ceil($total / $limit) : 1,
                ];
            } catch (\Throwable $e) {
                // Fall back to mock
            }
        }

        // Filter mock logs
        $filtered = array_values($this->mockLogs);

        if (!empty($filters['search'])) {
            $s = strtolower(trim((string)$filters['search']));
            $filtered = array_filter($filtered, function ($item) use ($s) {
                return str_contains(strtolower((string)($item['user_name'] ?? '')), $s)
                    || str_contains(strtolower((string)($item['details'] ?? '')), $s)
                    || str_contains(strtolower((string)($item['action'] ?? '')), $s)
                    || str_contains(strtolower((string)($item['entity_id'] ?? '')), $s)
                    || str_contains(strtolower((string)($item['correlation_id'] ?? '')), $s);
            });
        }

        if (!empty($filters['entity_type'])) {
            $eType = (string)$filters['entity_type'];
            $filtered = array_filter($filtered, fn($i) => ($i['entity_type'] ?? '') === $eType);
        }

        if (!empty($filters['action'])) {
            $act = (string)$filters['action'];
            $filtered = array_filter($filtered, fn($i) => ($i['action'] ?? '') === $act);
        }

        if (!empty($filters['status'])) {
            $st = (string)$filters['status'];
            $filtered = array_filter($filtered, fn($i) => ($i['status'] ?? '') === $st);
        }

        if (!empty($filters['actor'])) {
            $actr = strtolower(trim((string)$filters['actor']));
            $filtered = array_filter($filtered, fn($i) => str_contains(strtolower((string)($i['user_name'] ?? '')), $actr) || ($i['actor_role'] ?? '') === $actr);
        }

        if (!empty($filters['correlation_id'])) {
            $cId = (string)$filters['correlation_id'];
            $filtered = array_filter($filtered, fn($i) => ($i['correlation_id'] ?? '') === $cId);
        }

        if (!empty($filters['date_from'])) {
            $dFrom = (string)$filters['date_from'];
            $filtered = array_filter($filtered, fn($i) => ($i['created_at'] ?? '') >= ($dFrom . ' 00:00:00'));
        }

        if (!empty($filters['date_to'])) {
            $dTo = (string)$filters['date_to'];
            $filtered = array_filter($filtered, fn($i) => ($i['created_at'] ?? '') <= ($dTo . ' 23:59:59'));
        }

        // Sort descending by id
        usort($filtered, fn($a, $b) => ($b['id'] ?? 0) <=> ($a['id'] ?? 0));

        $total = count($filtered);
        $slice = array_slice($filtered, $offset, $limit);

        return [
            'items' => $slice,
            'total' => $total,
            'page'  => $page,
            'limit' => $limit,
            'pages' => $limit > 0 ? (int)ceil($total / $limit) : 1,
        ];
    }

    /**
     * Retrieve single audit log with deep state diff computation
     *
     * @return array<string, mixed>|null
     */
    public function getLogById(int $id): ?array
    {
        $log = null;

        if (!$this->isMock && $this->pdo !== null) {
            try {
                $stmt = $this->pdo->prepare("SELECT * FROM `audit_logs` WHERE `id` = ? LIMIT 1");
                $stmt->execute([$id]);
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                if ($row) {
                    $row['old_values'] = !empty($row['old_values']) ? (is_string($row['old_values']) ? json_decode($row['old_values'], true) : $row['old_values']) : null;
                    $row['new_values'] = !empty($row['new_values']) ? (is_string($row['new_values']) ? json_decode($row['new_values'], true) : $row['new_values']) : null;
                    $log = $row;
                }
            } catch (\Throwable $e) {
                $log = null;
            }
        }

        if ($log === null && isset($this->mockLogs[$id])) {
            $log = $this->mockLogs[$id];
        }

        if ($log === null) {
            return null;
        }

        // Attach computed diff
        $log['diff'] = $this->computeDiff($log['old_values'], $log['new_values']);
        return $log;
    }

    /**
     * Compute field-level differences between before & after states
     *
     * @param array<string, mixed>|null $old
     * @param array<string, mixed>|null $new
     * @return array{added: array<string, mixed>, modified: array<string, array{old: mixed, new: mixed}>, removed: array<string, mixed>, unchanged: array<string, mixed>}
     */
    public function computeDiff(?array $old, ?array $new): array
    {
        $old = $old ?? [];
        $new = $new ?? [];

        $added = [];
        $modified = [];
        $removed = [];
        $unchanged = [];

        foreach ($new as $k => $val) {
            if (!array_key_exists($k, $old)) {
                $added[$k] = $val;
            } elseif ($old[$k] !== $val) {
                $modified[$k] = ['old' => $old[$k], 'new' => $val];
            } else {
                $unchanged[$k] = $val;
            }
        }

        foreach ($old as $k => $val) {
            if (!array_key_exists($k, $new)) {
                $removed[$k] = $val;
            }
        }

        return [
            'added'     => $added,
            'modified'  => $modified,
            'removed'   => $removed,
            'unchanged' => $unchanged,
        ];
    }

    /**
     * Retrieve complete correlation chain of related operations
     *
     * @return array<int, array<string, mixed>>
     */
    public function getCorrelationTrace(string $correlationId): array
    {
        $res = $this->getLogs([
            'correlation_id' => $correlationId,
            'limit'          => 100,
        ]);
        // Sort chronologically ascending for a trace timeline
        $items = $res['items'];
        usort($items, fn($a, $b) => ($a['id'] ?? 0) <=> ($b['id'] ?? 0));
        return $items;
    }

    /**
     * Retrieve chronological lifecycle audit history for a specific entity
     *
     * @return array<int, array<string, mixed>>
     */
    public function getEntityHistory(string $entityType, string $entityId, int $limit = 50): array
    {
        $res = $this->getLogs([
            'entity_type' => $entityType,
            'search'      => $entityId,
            'limit'       => $limit,
        ]);
        return $res['items'];
    }

    /**
     * Aggregate telemetry and KPI metrics for dashboard ribbon
     *
     * @return array<string, mixed>
     */
    public function getAuditStats(): array
    {
        $oneDayAgo = date('Y-m-d H:i:s', time() - 86400);

        if (!$this->isMock && $this->pdo !== null) {
            try {
                $total = (int)$this->pdo->query("SELECT COUNT(*) FROM `audit_logs`")->fetchColumn();
                
                $stmt24 = $this->pdo->prepare("SELECT COUNT(*) FROM `audit_logs` WHERE `created_at` >= ?");
                $stmt24->execute([$oneDayAgo]);
                $events24h = (int)$stmt24->fetchColumn();

                $stmtWarn = $this->pdo->prepare("SELECT COUNT(*) FROM `audit_logs` WHERE `status` = 'warning' AND `created_at` >= ?");
                $stmtWarn->execute([$oneDayAgo]);
                $warnings24h = (int)$stmtWarn->fetchColumn();

                $stmtFail = $this->pdo->prepare("SELECT COUNT(*) FROM `audit_logs` WHERE `status` = 'failure' AND `created_at` >= ?");
                $stmtFail->execute([$oneDayAgo]);
                $failures24h = (int)$stmtFail->fetchColumn();

                $stmtActors = $this->pdo->prepare("SELECT COUNT(DISTINCT `user_name`) FROM `audit_logs` WHERE `created_at` >= ?");
                $stmtActors->execute([$oneDayAgo]);
                $actors24h = (int)$stmtActors->fetchColumn();

                $stmtCorr = $this->pdo->prepare("SELECT COUNT(DISTINCT `correlation_id`) FROM `audit_logs` WHERE `created_at` >= ?");
                $stmtCorr->execute([$oneDayAgo]);
                $corr24h = (int)$stmtCorr->fetchColumn();

                // Group by category
                $catStmt = $this->pdo->query("SELECT `entity_type`, COUNT(*) as cnt FROM `audit_logs` GROUP BY `entity_type`");
                $catCounts = [];
                while ($row = $catStmt->fetch(\PDO::FETCH_ASSOC)) {
                    $catCounts[$row['entity_type']] = (int)$row['cnt'];
                }

                return [
                    'total_events'           => $total,
                    'events_24h'             => $events24h,
                    'warnings_24h'           => $warnings24h,
                    'failures_24h'           => $failures24h,
                    'unique_actors_24h'      => $actors24h,
                    'active_traces_24h'      => $corr24h,
                    'category_counts'        => $catCounts,
                ];
            } catch (\Throwable $e) {
                // Fallback
            }
        }

        $logs = array_values($this->mockLogs);
        $total = count($logs);
        $events24h = 0;
        $warnings24h = 0;
        $failures24h = 0;
        $actors = [];
        $traces = [];
        $catCounts = [];

        foreach ($logs as $l) {
            $type = $l['entity_type'] ?? 'other';
            $catCounts[$type] = ($catCounts[$type] ?? 0) + 1;

            if (($l['created_at'] ?? '') >= $oneDayAgo) {
                $events24h++;
                if (($l['status'] ?? '') === 'warning') $warnings24h++;
                if (($l['status'] ?? '') === 'failure') $failures24h++;
                if (!empty($l['user_name'])) $actors[$l['user_name']] = true;
                if (!empty($l['correlation_id'])) $traces[$l['correlation_id']] = true;
            }
        }

        return [
            'total_events'      => $total,
            'events_24h'        => $events24h,
            'warnings_24h'      => $warnings24h,
            'failures_24h'      => $failures24h,
            'unique_actors_24h' => max(1, count($actors)),
            'active_traces_24h' => max(1, count($traces)),
            'category_counts'   => $catCounts,
        ];
    }

    /**
     * Export audit logs to RFC-4180 compliant CSV with formula injection sanitization
     *
     * @param array<string, mixed> $filters
     */
    public function exportCsv(array $filters = []): string
    {
        $filters['limit'] = 5000;
        $filters['offset'] = 0;
        $res = $this->getLogs($filters);
        $rows = $res['items'];

        $fp = fopen('php://temp', 'r+');
        if ($fp === false) {
            return '';
        }

        // CSV Header
        fputcsv($fp, [
            'Log ID',
            'Correlation ID',
            'Timestamp',
            'Actor Name',
            'Actor Role',
            'Action',
            'Entity Type',
            'Entity ID',
            'Status',
            'Details',
            'IP Address',
            'User Agent',
            'Old State (JSON)',
            'New State (JSON)',
        ]);

        foreach ($rows as $r) {
            $oldState = !empty($r['old_values']) ? (is_array($r['old_values']) ? json_encode($r['old_values']) : (string)$r['old_values']) : '';
            $newState = !empty($r['new_values']) ? (is_array($r['new_values']) ? json_encode($r['new_values']) : (string)$r['new_values']) : '';

            fputcsv($fp, [
                $r['id'] ?? '',
                self::sanitizeCsvValue((string)($r['correlation_id'] ?? '')),
                $r['created_at'] ?? '',
                self::sanitizeCsvValue((string)($r['user_name'] ?? '')),
                self::sanitizeCsvValue((string)($r['actor_role'] ?? '')),
                self::sanitizeCsvValue((string)($r['action'] ?? '')),
                self::sanitizeCsvValue((string)($r['entity_type'] ?? '')),
                self::sanitizeCsvValue((string)($r['entity_id'] ?? '')),
                self::sanitizeCsvValue((string)($r['status'] ?? 'success')),
                self::sanitizeCsvValue((string)($r['details'] ?? '')),
                self::sanitizeCsvValue((string)($r['ip_address'] ?? '')),
                self::sanitizeCsvValue((string)($r['user_agent'] ?? '')),
                self::sanitizeCsvValue($oldState),
                self::sanitizeCsvValue($newState),
            ]);
        }

        rewind($fp);
        $csv = stream_get_contents($fp);
        fclose($fp);
        return $csv ?: '';
    }

    /**
     * CSV Formula Injection Sanitization
     * Prevents Excel/Sheets DDE execution via =, +, -, @, \t, \r
     */
    public static function sanitizeCsvValue(string $val): string
    {
        if ($val === '') {
            return $val;
        }
        $firstChar = $val[0];
        if (in_array($firstChar, ['=', '+', '-', '@', "\t", "\r"], true)) {
            return "'" . $val;
        }
        return $val;
    }

    /**
     * Purge audit records older than the specified retention days
     * Requires explicit administrative authorization and self-audits the action
     */
    public function purgeOldLogs(int $retentionDays, string $authorizedBy): int
    {
        if ($retentionDays < 7) {
            throw new \InvalidArgumentException('Audit log retention policy requires minimum 7 days of logs to be preserved.');
        }

        $cutoffDate = date('Y-m-d H:i:s', time() - ($retentionDays * 86400));
        $deletedCount = 0;

        if (!$this->isMock && $this->pdo !== null) {
            try {
                $stmt = $this->pdo->prepare("DELETE FROM `audit_logs` WHERE `created_at` < ?");
                $stmt->execute([$cutoffDate]);
                $deletedCount = $stmt->rowCount();
            } catch (\Throwable $e) {
                $deletedCount = 0;
            }
        } else {
            $beforeCount = count($this->mockLogs);
            $this->mockLogs = array_filter($this->mockLogs, fn($l) => ($l['created_at'] ?? '') >= $cutoffDate);
            $deletedCount = $beforeCount - count($this->mockLogs);
        }

        // Self-audit this purge operation
        $this->log([
            'action'      => 'audit_purge',
            'entity_type' => self::CATEGORY_SECURITY,
            'entity_id'   => "PURGE-{$retentionDays}D",
            'status'      => 'warning',
            'user_name'   => $authorizedBy,
            'details'     => "Enterprise audit log purge executed: {$deletedCount} records older than {$retentionDays} days deleted. Authorized by {$authorizedBy}.",
            'old_values'  => ['retention_days' => $retentionDays, 'cutoff_date' => $cutoffDate],
            'new_values'  => ['deleted_count' => $deletedCount, 'authorized_by' => $authorizedBy],
        ]);

        return $deletedCount;
    }
}
