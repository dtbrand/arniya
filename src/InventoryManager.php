<?php
/**
 * InventoryManager.php — Central Warehouse Inventory, Ledger & Stock Movement Engine
 * DT Brand's & Jai Hanuman Tex — Master Wholesale Architecture
 */

namespace DTBrand;

use PDO;

class InventoryManager
{
    /**
     * Fetch paginated inventory ledger records with flexible filters
     */
    public static function getLedger(array $filters = [], int $limit = 50, int $offset = 0): array
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            return [];
        }

        try {
            $where = ["1=1"];
            $params = [];

            if (!empty($filters['movement_type']) && $filters['movement_type'] !== 'all') {
                $where[] = "l.movement_type = :mtype";
                $params[':mtype'] = trim($filters['movement_type']);
            }

            if (!empty($filters['product_id'])) {
                $where[] = "l.product_id = :pid";
                $params[':pid'] = (int)$filters['product_id'];
            }

            if (!empty($filters['search'])) {
                $where[] = "(l.sku LIKE :q OR l.reason LIKE :q OR l.reference_id LIKE :q OR p.title LIKE :q)";
                $params[':q'] = '%' . trim($filters['search']) . '%';
            }

            if (!empty($filters['from_date'])) {
                $where[] = "l.created_at >= :from_d";
                $params[':from_d'] = trim($filters['from_date']) . ' 00:00:00';
            }

            if (!empty($filters['to_date'])) {
                $where[] = "l.created_at <= :to_d";
                $params[':to_d'] = trim($filters['to_date']) . ' 23:59:59';
            }

            $whereSql = implode(' AND ', $where);

            $stmt = $db->prepare("
                SELECT l.*, 
                       COALESCE(p.title, 'Deleted Product') as product_title,
                       COALESCE(p.category, 'Ethnic Sarees') as category,
                       COALESCE(p.wholesale_price, 0) as wholesale_price
                FROM inventory_ledger l
                LEFT JOIN products p ON l.product_id = p.id
                WHERE {$whereSql}
                ORDER BY l.id DESC
                LIMIT :limit OFFSET :offset
            ");

            foreach ($params as $key => $val) {
                $stmt->bindValue($key, $val);
            }
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (\Throwable $e) {
            error_log("InventoryManager::getLedger error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Count total ledger records for pagination
     */
    public static function getLedgerCount(array $filters = []): int
    {
        $db = Database::getConnection();
        if ($db === null || Database::isMockMode()) {
            return 0;
        }

        try {
            $where = ["1=1"];
            $params = [];

            if (!empty($filters['movement_type']) && $filters['movement_type'] !== 'all') {
                $where[] = "l.movement_type = :mtype";
                $params[':mtype'] = trim($filters['movement_type']);
            }

            if (!empty($filters['product_id'])) {
                $where[] = "l.product_id = :pid";
                $params[':pid'] = (int)$filters['product_id'];
            }

            if (!empty($filters['search'])) {
                $where[] = "(l.sku LIKE :q OR l.reason LIKE :q OR l.reference_id LIKE :q OR p.title LIKE :q)";
                $params[':q'] = '%' . trim($filters['search']) . '%';
            }

            if (!empty($filters['from_date'])) {
                $where[] = "l.created_at >= :from_d";
                $params[':from_d'] = trim($filters['from_date']) . ' 00:00:00';
            }

            if (!empty($filters['to_date'])) {
                $where[] = "l.created_at <= :to_d";
                $params[':to_d'] = trim($filters['to_date']) . ' 23:59:59';
            }

            $whereSql = implode(' AND ', $where);

            $stmt = $db->prepare("
                SELECT COUNT(*) as cnt
                FROM inventory_ledger l
                LEFT JOIN products p ON l.product_id = p.id
                WHERE {$whereSql}
            ");

            foreach ($params as $key => $val) {
                $stmt->bindValue($key, $val);
            }

            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)($row['cnt'] ?? 0);
        } catch (\Throwable $e) {
            error_log("InventoryManager::getLedgerCount error: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Compute summary metrics across all products and recent ledger activity
     */
    public static function getSummaryMetrics(): array
    {
        $allProds = ProductCatalog::getAll(true);
        $totalSkus = count($allProds);
        $totalStockUnits = 0;
        $totalInventoryValuation = 0.0;
        $lowStockCount = 0;
        $outOfStockCount = 0;

        foreach ($allProds as $p) {
            $qty = (int)($p['stock_qty'] ?? 0);
            $wp = (float)($p['wholesale_price'] ?? 0);
            $totalStockUnits += $qty;
            $totalInventoryValuation += ($qty * $wp);
            if ($qty <= 0) {
                $outOfStockCount++;
            } elseif ($qty <= 15) {
                $lowStockCount++;
            }
        }

        $valFormatted = $totalInventoryValuation >= 100000
            ? '₹' . number_format($totalInventoryValuation / 100000, 2) . ' Lakhs'
            : '₹' . number_format($totalInventoryValuation);

        return [
            'total_skus' => $totalSkus,
            'total_stock_units' => $totalStockUnits,
            'total_valuation' => $totalInventoryValuation,
            'valuation_formatted' => $valFormatted,
            'low_stock_count' => $lowStockCount,
            'out_of_stock_count' => $outOfStockCount
        ];
    }
}
