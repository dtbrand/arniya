<?php
declare(strict_types=1);

namespace DTBrand;

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Money.php';

/**
 * src/PriceHistoryManager.php — Enterprise Price History Audit & Volatility Tracker
 * Master Specification V2 — Section 43: Price History Audit Standard
 * 
 * Rules:
 * 1. Tracks every price change across Single Piece & Full Set role tiers.
 * 2. Strict Security Isolation: Strictly internal audit data — NEVER exposed to customers/guests.
 * 3. Supports live MySQL persistence with seamless mock fallback.
 */
class PriceHistoryManager
{
    private static ?self $instance = null;
    private ?\PDO $pdo;
    private bool $isMockMode;

    /**
     * In-memory mock ledger for fallback or testing environments.
     */
    private static array $mockLedger = [];

    public function __construct(?\PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Database::getConnection();
        $this->isMockMode = ($this->pdo === null || Database::isMockMode());

        if (empty(self::$mockLedger)) {
            $this->seedInitialMockHistory();
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
     * Security Guard: Ensure caller is authorized admin.
     * Price History is CONFIDENTIAL INTERNAL AUDIT DATA (Section 43).
     */
    public static function assertAdminAccess(?array $user = null): bool
    {
        $adminLogged = !empty($_SESSION['admin_logged_in']) || !empty($_SESSION['admin_user']);
        $role = strtolower(trim((string)($user['role'] ?? ($user['type'] ?? ($_SESSION['user']['role'] ?? '')))));
        
        if ($adminLogged || $role === 'admin' || $role === 'superadmin') {
            return true;
        }

        throw new \RuntimeException("Access Denied: Price history audit records are strictly restricted to authorized administrators.");
    }

    /**
     * Record a single price change event.
     */
    public function recordChange(
        int $productId,
        string $productType,
        string $roleTier,
        string $fieldName,
        ?float $oldPrice,
        float $newPrice,
        string $changedBy = 'admin',
        ?int $changedById = null,
        ?string $reason = null
    ): bool {
        // Only record if there is an actual change
        if ($oldPrice !== null && abs($oldPrice - $newPrice) < 0.001) {
            return false;
        }

        $cleanProductType = in_array(strtolower($productType), ['full_set', 'fullset', 'set'], true) ? 'full_set' : 'single_piece';
        $cleanRoleTier = strtolower(trim($roleTier));
        if ($cleanRoleTier === '') {
            $cleanRoleTier = 'all';
        }

        $oldMoney = $oldPrice !== null ? Money::fromDecimal($oldPrice)->toDecimal() : null;
        $newMoney = Money::fromDecimal($newPrice)->toDecimal();

        if ($this->isMockMode || $this->pdo === null) {
            self::$mockLedger[] = [
                'id' => count(self::$mockLedger) + 1,
                'product_id' => $productId,
                'product_type' => $cleanProductType,
                'role_tier' => $cleanRoleTier,
                'field_name' => $fieldName,
                'old_price' => $oldMoney,
                'new_price' => $newMoney,
                'currency' => 'INR',
                'changed_by' => $changedBy,
                'changed_by_id' => $changedById,
                'change_reason' => $reason,
                'created_at' => date('Y-m-d H:i:s')
            ];
            return true;
        }

        try {
            $sql = "INSERT INTO `product_price_history` 
                (`product_id`, `product_type`, `role_tier`, `field_name`, `old_price`, `new_price`, `currency`, `changed_by`, `changed_by_id`, `change_reason`, `created_at`) 
                VALUES (?, ?, ?, ?, ?, ?, 'INR', ?, ?, ?, NOW())";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $productId,
                $cleanProductType,
                $cleanRoleTier,
                $fieldName,
                $oldMoney,
                $newMoney,
                $changedBy,
                $changedById,
                $reason
            ]);
        } catch (\PDOException $e) {
            error_log("[PRICE HISTORY ERROR] Failed to record price change: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Record batch price modifications when a product or variant is saved.
     * Automatically compares old price dictionary vs new price dictionary.
     */
    public function recordBatchChanges(
        int $productId,
        string $productType,
        array $oldPrices,
        array $newPrices,
        string $changedBy = 'admin',
        ?int $changedById = null,
        ?string $reason = null
    ): int {
        $trackedFields = [
            'mrp' => 'all',
            'price' => 'customer',
            'sale_price' => 'customer',
            'customer_price' => 'customer',
            'customer_sale_price' => 'customer',
            'retail_price' => 'retailer',
            'retailer_price' => 'retailer',
            'retailer_sale_price' => 'retailer',
            'reseller_price' => 'reseller',
            'reseller_sale_price' => 'reseller',
            'wholesale_price' => 'wholesale',
            'wholesale_sale_price' => 'wholesale',
            'wholesale_moq4_price' => 'wholesale',
            'wholesale_moq8_price' => 'wholesale',
            'full_set_retailer_price' => 'retailer',
            'full_set_retailer_sale_price' => 'retailer',
            'full_set_wholesale_price' => 'wholesale',
            'full_set_wholesale_sale_price' => 'wholesale'
        ];

        $recordedCount = 0;
        foreach ($trackedFields as $field => $role) {
            if (isset($newPrices[$field])) {
                $newVal = (float)$newPrices[$field];
                $oldVal = isset($oldPrices[$field]) && $oldPrices[$field] !== '' && $oldPrices[$field] !== null ? (float)$oldPrices[$field] : null;

                if ($oldVal === null || abs($oldVal - $newVal) >= 0.001) {
                    $ok = $this->recordChange(
                        $productId,
                        $productType,
                        $role,
                        $field,
                        $oldVal,
                        $newVal,
                        $changedBy,
                        $changedById,
                        $reason
                    );
                    if ($ok) {
                        $recordedCount++;
                    }
                }
            }
        }
        return $recordedCount;
    }

    /**
     * Get price history for a specific product.
     */
    public function getHistoryForProduct(int $productId, int $limit = 50): array
    {
        if ($this->isMockMode || $this->pdo === null) {
            $filtered = array_filter(self::$mockLedger, fn($row) => (int)$row['product_id'] === $productId);
            usort($filtered, fn($a, $b) => strcmp($b['created_at'], $a['created_at']));
            return array_slice(array_values($filtered), 0, $limit);
        }

        try {
            $sql = "SELECT h.*, p.name AS product_name, p.sku AS product_sku 
                    FROM `product_price_history` h
                    LEFT JOIN `products` p ON p.id = h.product_id
                    WHERE h.product_id = ?
                    ORDER BY h.created_at DESC, h.id DESC
                    LIMIT ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $productId, \PDO::PARAM_INT);
            $stmt->bindValue(2, $limit, \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("[PRICE HISTORY ERROR] Failed to fetch product history: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get paginated and filtered price history ledger.
     */
    public function getAllHistory(array $filters = [], int $page = 1, int $limit = 25): array
    {
        $page = max(1, $page);
        $limit = max(1, min(100, $limit));
        $offset = ($page - 1) * $limit;

        if ($this->isMockMode || $this->pdo === null) {
            $rows = self::$mockLedger;

            if (!empty($filters['product_id'])) {
                $rows = array_filter($rows, fn($r) => (int)$r['product_id'] === (int)$filters['product_id']);
            }
            if (!empty($filters['role_tier']) && $filters['role_tier'] !== 'all') {
                $rows = array_filter($rows, fn($r) => $r['role_tier'] === $filters['role_tier']);
            }
            if (!empty($filters['product_type']) && $filters['product_type'] !== 'all') {
                $rows = array_filter($rows, fn($r) => $r['product_type'] === $filters['product_type']);
            }
            if (!empty($filters['search'])) {
                $q = strtolower(trim($filters['search']));
                $rows = array_filter($rows, fn($r) => 
                    str_contains(strtolower($r['field_name']), $q) || 
                    str_contains(strtolower($r['changed_by']), $q) ||
                    str_contains(strtolower($r['change_reason'] ?? ''), $q)
                );
            }

            usort($rows, fn($a, $b) => strcmp($b['created_at'], $a['created_at']));
            $total = count($rows);
            $slice = array_slice(array_values($rows), $offset, $limit);

            return [
                'items' => $slice,
                'total_items' => $total,
                'total_pages' => (int)ceil($total / $limit),
                'current_page' => $page,
                'limit' => $limit
            ];
        }

        try {
            $where = ['1=1'];
            $params = [];

            if (!empty($filters['product_id'])) {
                $where[] = "h.product_id = ?";
                $params[] = (int)$filters['product_id'];
            }
            if (!empty($filters['role_tier']) && $filters['role_tier'] !== 'all') {
                $where[] = "h.role_tier = ?";
                $params[] = $filters['role_tier'];
            }
            if (!empty($filters['product_type']) && $filters['product_type'] !== 'all') {
                $where[] = "h.product_type = ?";
                $params[] = $filters['product_type'];
            }
            if (!empty($filters['search'])) {
                $where[] = "(p.name LIKE ? OR p.sku LIKE ? OR h.field_name LIKE ? OR h.changed_by LIKE ? OR h.change_reason LIKE ?)";
                $s = '%' . trim($filters['search']) . '%';
                $params[] = $s; $params[] = $s; $params[] = $s; $params[] = $s; $params[] = $s;
            }

            $whereSql = implode(' AND ', $where);

            // Count total
            $countStmt = $this->pdo->prepare("SELECT COUNT(*) FROM `product_price_history` h LEFT JOIN `products` p ON p.id = h.product_id WHERE {$whereSql}");
            $countStmt->execute($params);
            $total = (int)$countStmt->fetchColumn();

            // Fetch items
            $sql = "SELECT h.*, p.name AS product_name, p.sku AS product_sku 
                    FROM `product_price_history` h
                    LEFT JOIN `products` p ON p.id = h.product_id
                    WHERE {$whereSql}
                    ORDER BY h.created_at DESC, h.id DESC
                    LIMIT ? OFFSET ?";
            $stmt = $this->pdo->prepare($sql);
            
            $bindIdx = 1;
            foreach ($params as $param) {
                $stmt->bindValue($bindIdx++, $param);
            }
            $stmt->bindValue($bindIdx++, $limit, \PDO::PARAM_INT);
            $stmt->bindValue($bindIdx++, $offset, \PDO::PARAM_INT);
            $stmt->execute();
            $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return [
                'items' => $items,
                'total_items' => $total,
                'total_pages' => (int)ceil($total / $limit),
                'current_page' => $page,
                'limit' => $limit
            ];
        } catch (\PDOException $e) {
            error_log("[PRICE HISTORY ERROR] Failed to fetch price history ledger: " . $e->getMessage());
            return [
                'items' => [],
                'total_items' => 0,
                'total_pages' => 1,
                'current_page' => 1,
                'limit' => $limit
            ];
        }
    }

    /**
     * Get aggregate statistics for Price History KPI Ribbon.
     */
    public function getSummaryStats(): array
    {
        if ($this->isMockMode || $this->pdo === null) {
            $total = count(self::$mockLedger);
            $uniqueProds = count(array_unique(array_column(self::$mockLedger, 'product_id')));
            return [
                'total_adjustments' => $total,
                'recent_30d_adjustments' => $total,
                'products_impacted' => $uniqueProds,
                'role_tiers_tracked' => 5,
                'currency' => 'INR'
            ];
        }

        try {
            $stats = [
                'total_adjustments' => (int)$this->pdo->query("SELECT COUNT(*) FROM `product_price_history`")->fetchColumn(),
                'recent_30d_adjustments' => (int)$this->pdo->query("SELECT COUNT(*) FROM `product_price_history` WHERE created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY)")->fetchColumn(),
                'products_impacted' => (int)$this->pdo->query("SELECT COUNT(DISTINCT product_id) FROM `product_price_history`")->fetchColumn(),
                'role_tiers_tracked' => 5,
                'currency' => 'INR'
            ];
            return $stats;
        } catch (\PDOException $e) {
            return [
                'total_adjustments' => 0,
                'recent_30d_adjustments' => 0,
                'products_impacted' => 0,
                'role_tiers_tracked' => 5,
                'currency' => 'INR'
            ];
        }
    }

    /**
     * Seed initial mock history for high-fidelity demonstration.
     */
    private function seedInitialMockHistory(): void
    {
        self::$mockLedger = [
            [
                'id' => 1,
                'product_id' => 1,
                'product_type' => 'single_piece',
                'role_tier' => 'wholesale',
                'field_name' => 'wholesale_price',
                'old_price' => '1250.00',
                'new_price' => '1150.00',
                'currency' => 'INR',
                'changed_by' => 'Gautam (Admin)',
                'changed_by_id' => 1,
                'change_reason' => 'B2B Wholesale volume discount for Festive Season',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 hours'))
            ],
            [
                'id' => 2,
                'product_id' => 1,
                'product_type' => 'single_piece',
                'role_tier' => 'reseller',
                'field_name' => 'reseller_price',
                'old_price' => '1399.00',
                'new_price' => '1299.00',
                'currency' => 'INR',
                'changed_by' => 'Gautam (Admin)',
                'changed_by_id' => 1,
                'change_reason' => 'Reseller margin enhancement',
                'created_at' => date('Y-m-d H:i:s', strtotime('-4 hours'))
            ],
            [
                'id' => 3,
                'product_id' => 2,
                'product_type' => 'full_set',
                'role_tier' => 'wholesale',
                'field_name' => 'full_set_wholesale_price',
                'old_price' => '9500.00',
                'new_price' => '8999.00',
                'currency' => 'INR',
                'changed_by' => 'System Engine',
                'changed_by_id' => null,
                'change_reason' => 'Master bale lot rate revision based on raw silk index',
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'id' => 4,
                'product_id' => 3,
                'product_type' => 'single_piece',
                'role_tier' => 'customer',
                'field_name' => 'customer_sale_price',
                'old_price' => '2499.00',
                'new_price' => '2199.00',
                'currency' => 'INR',
                'changed_by' => 'Sunil (Operations)',
                'changed_by_id' => 2,
                'change_reason' => 'End of Season clearance markdown',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ]
        ];
    }
}
