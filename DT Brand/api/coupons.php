<?php
/**
 * coupons.php — Coupon Code Management API (CRUD)
 * DT Brand's & Jai Hanuman Tex
 */
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../src/Database.php';

use DTBrand\Database;

$action = $_REQUEST['action'] ?? 'get_all';
$pdo = Database::getConnection();

if ($pdo === null || Database::isMockMode()) {
    echo json_encode([
        'success' => true,
        'coupons' => [
            ['id' => 1, 'code' => 'FESTIVE2026', 'discount_type' => 'percentage', 'discount_value' => 15.00, 'min_order_amount' => 2999.00, 'status' => 'active', 'times_used' => 48],
            ['id' => 2, 'code' => 'B2BWHOLESALE', 'discount_type' => 'fixed', 'discount_value' => 1000.00, 'min_order_amount' => 15000.00, 'status' => 'active', 'times_used' => 22],
            ['id' => 3, 'code' => 'RETAIL5', 'discount_type' => 'percentage', 'discount_value' => 5.00, 'min_order_amount' => 999.00, 'status' => 'active', 'times_used' => 94]
        ]
    ]);
    exit;
}

try {
    // Ensure table exists
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `coupons` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `code` VARCHAR(50) NOT NULL UNIQUE,
            `discount_type` ENUM('percentage', 'fixed') DEFAULT 'percentage',
            `discount_value` DECIMAL(10,2) NOT NULL DEFAULT 10.00,
            `min_order_amount` DECIMAL(10,2) DEFAULT 0.00,
            `max_discount_amount` DECIMAL(10,2) NULL,
            `status` ENUM('active', 'expired', 'disabled') DEFAULT 'active',
            `times_used` INT DEFAULT 0,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    if ($action === 'get_all') {
        $stmt = $pdo->query("SELECT * FROM `coupons` ORDER BY `id` DESC");
        $coupons = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'coupons' => $coupons]);
        exit;
    }

    if ($action === 'create') {
        $code = strtoupper(trim($_POST['code'] ?? ''));
        $type = $_POST['discount_type'] ?? 'percentage';
        $val = (float)($_POST['discount_value'] ?? 10);
        $min = (float)($_POST['min_order_amount'] ?? 0);

        if (empty($code)) {
            echo json_encode(['success' => false, 'message' => 'Coupon code is required.']);
            exit;
        }

        $stmt = $pdo->prepare("
            INSERT INTO `coupons` (`code`, `discount_type`, `discount_value`, `min_order_amount`, `status`, `times_used`)
            VALUES (?, ?, ?, ?, 'active', 0)
            ON DUPLICATE KEY UPDATE discount_type=VALUES(discount_type), discount_value=VALUES(discount_value), min_order_amount=VALUES(min_order_amount), status='active'
        ");
        $stmt->execute([$code, $type, $val, $min]);

        echo json_encode(['success' => true, 'message' => "Coupon {$code} created successfully!"]);
        exit;
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM `coupons` WHERE `id` = ?");
            $stmt->execute([$id]);
        }
        echo json_encode(['success' => true, 'message' => 'Coupon removed successfully.']);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
} catch (\Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
