<?php
/**
 * coupons.php — Section 26 Coupon Code Management, Validation & Audit API
 * DT Brand's & Jai Hanuman Tex
 *
 * Actions:
 *   - validate (Public / Storefront): Checks code validity, subtotal, role/channel, limits
 *   - get_all (Admin): Lists coupons with full stats and status
 *   - create (Admin): Mints new coupon with Section 26 rules
 *   - update (Admin): Updates coupon properties or toggles status
 *   - delete (Admin): Permanently removes coupon
 *   - usages (Admin): Lists coupon redemptions / usage ledger
 *   - audit (Admin): Returns coupon security audit trail and policy check
 *   - extend (Admin): Extends expiration or resets limits
 */
require_once __DIR__ . '/cors.php';
cors_json();
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/DiscountEngine.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\Database;
use DTBrand\DiscountEngine;

$action = $_REQUEST['action'] ?? 'get_all';
$pdo = Database::getConnection();

// Storefront checkout validation is public. Everything else requires admin.
if ($action !== 'validate') {
    dt_api_require_admin('manage coupons');
}

// ── OFFLINE / MOCK MODE ──
if ($pdo === null || Database::isMockMode()) {
    $mock = [
        ['id' => 1, 'code' => 'FESTIVE25',   'title' => 'Festive Silk Promo', 'discount_type' => 'percentage', 'discount_value' => 25.00, 'min_order_value' => 1999.00,  'max_discount' => 1500.00, 'usage_limit' => 500, 'used_count' => 142, 'channel' => 'all', 'status' => 'active', 'starts_at' => '2026-01-01 00:00:00', 'expires_at' => '2026-12-31 23:59:59'],
        ['id' => 2, 'code' => 'VIPRESELLER', 'title' => 'VIP Dropship Boost', 'discount_type' => 'percentage', 'discount_value' => 15.00, 'min_order_value' => 3000.00,  'max_discount' => 2000.00, 'usage_limit' => 200, 'used_count' => 88, 'channel' => 'reseller', 'status' => 'active', 'starts_at' => '2026-01-01 00:00:00', 'expires_at' => '2026-12-31 23:59:59'],
        ['id' => 3, 'code' => 'BULK50',      'title' => 'Wholesale Depot Incentive', 'discount_type' => 'percentage', 'discount_value' => 50.00, 'min_order_value' => 20000.00, 'max_discount' => 10000.00, 'usage_limit' => 50, 'used_count' => 19, 'channel' => 'wholesaler', 'status' => 'active', 'starts_at' => '2026-01-01 00:00:00', 'expires_at' => '2026-12-31 23:59:59'],
        ['id' => 4, 'code' => 'SUMMEREXPIRED', 'title' => 'Old Summer Saree Sale', 'discount_type' => 'flat', 'discount_value' => 500.00, 'min_order_value' => 2500.00, 'max_discount' => 500.00, 'usage_limit' => 100, 'used_count' => 100, 'channel' => 'all', 'status' => 'expired', 'starts_at' => '2025-06-01 00:00:00', 'expires_at' => '2025-08-31 23:59:59'],
    ];

    if ($action === 'validate') {
        $code = strtoupper(trim($_REQUEST['code'] ?? ''));
        $subtotal = (float)($_REQUEST['subtotal'] ?? 0);
        $channel = trim($_REQUEST['channel'] ?? 'all');
        foreach ($mock as $c) {
            if ($c['code'] === $code) {
                if ($c['status'] !== 'active') {
                    echo json_encode(['success' => false, 'discount' => 0, 'message' => 'This coupon is expired or inactive.']);
                    exit;
                }
                $r = DiscountEngine::applyCoupon($code, $subtotal, null, $channel);
                echo json_encode([
                    'success' => $r['valid'],
                    'code' => $code,
                    'discount' => $r['discount'],
                    'discount_type' => $c['discount_type'],
                    'message' => $r['message']
                ]);
                exit;
            }
        }
        echo json_encode(['success' => false, 'discount' => 0, 'message' => 'Invalid coupon code.']);
        exit;
    }

    if ($action === 'usages') {
        echo json_encode([
            'success' => true,
            'usages' => [
                ['id' => 1, 'coupon_code' => 'FESTIVE25', 'order_number' => 'DT-ORD-90281', 'customer_name' => 'Meera Ben', 'customer_phone' => '9825100000', 'order_subtotal' => 4500.00, 'discount_amount' => 1125.00, 'channel' => 'customer', 'created_at' => '2026-09-10 14:20:00'],
                ['id' => 2, 'coupon_code' => 'VIPRESELLER', 'order_number' => 'DT-ORD-90280', 'customer_name' => 'Pooja Fashion Hub', 'customer_phone' => '917046363528', 'order_subtotal' => 8900.00, 'discount_amount' => 1335.00, 'channel' => 'reseller', 'created_at' => '2026-09-09 11:15:00']
            ]
        ]);
        exit;
    }

    if ($action === 'audit') {
        echo json_encode([
            'success' => true,
            'audit' => [
                ['id' => 1, 'coupon_code' => 'FESTIVE25', 'action' => 'created', 'actor' => 'Super Admin', 'details' => 'Created Festive Silk Promo (25% off up to ₹1,500)', 'created_at' => '2026-09-01 10:00:00'],
                ['id' => 2, 'coupon_code' => 'VIPRESELLER', 'action' => 'status_changed', 'actor' => 'Super Admin', 'details' => 'Activated VIP Dropship Boost', 'created_at' => '2026-09-02 12:30:00']
            ]
        ]);
        exit;
    }

    echo json_encode(['success' => true, 'coupons' => $mock]);
    exit;
}

try {
    // ── 1. VALIDATE COUPON (Storefront / Checkout API) ──
    if ($action === 'validate') {
        $code = strtoupper(trim($_REQUEST['code'] ?? ''));
        $subtotal = (float)($_REQUEST['subtotal'] ?? 0);
        $channel = trim($_REQUEST['channel'] ?? ($_REQUEST['role'] ?? 'all'));
        $phone = trim($_REQUEST['phone'] ?? ($_REQUEST['customer_phone'] ?? ''));
        $customerId = isset($_REQUEST['customer_id']) ? (int)$_REQUEST['customer_id'] : null;

        if ($code === '') {
            echo json_encode(['success' => false, 'discount' => 0, 'message' => 'Please enter a coupon code.']);
            exit;
        }

        $result = DiscountEngine::applyCoupon($code, $subtotal, null, $channel, $phone, $customerId);

        echo json_encode([
            'success' => $result['valid'],
            'code' => $code,
            'discount' => $result['discount'],
            'discount_type' => $result['discount_type'] ?? 'percentage',
            'discount_value' => $result['discount_value'] ?? 0,
            'title' => $result['title'] ?? '',
            'message' => $result['message']
        ]);
        exit;
    }

    // ── 2. GET ALL COUPONS (Admin) ──
    if ($action === 'get_all') {
        $filterStatus = trim($_GET['status'] ?? '');
        $filterChannel = trim($_GET['channel'] ?? '');

        $sql = "SELECT * FROM `coupons` WHERE 1=1";
        $params = [];

        if (!empty($filterStatus) && $filterStatus !== 'all') {
            $sql .= " AND `status` = ?";
            $params[] = $filterStatus;
        }

        if (!empty($filterChannel) && $filterChannel !== 'all') {
            $sql .= " AND (`channel` = ? OR `channel` = 'all')";
            $params[] = $filterChannel;
        }

        $sql .= " ORDER BY `id` DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $coupons = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        echo json_encode(['success' => true, 'count' => count($coupons), 'coupons' => $coupons]);
        exit;
    }

    // ── 3. CREATE COUPON (Admin) ──
    if ($action === 'create') {
        $code = strtoupper(trim($_POST['code'] ?? ''));
        $title = trim($_POST['title'] ?? ('Coupon ' . $code));
        $rawType = strtolower(trim($_POST['discount_type'] ?? 'percentage'));
        $type = ($rawType === 'flat' || $rawType === 'fixed') ? 'flat' : 'percentage';
        $val = (float)($_POST['discount_value'] ?? 10);
        $min = (float)($_POST['min_order_value'] ?? $_POST['min_order_amount'] ?? 0);
        $maxDiscount = (float)($_POST['max_discount'] ?? $_POST['max_discount_amount'] ?? 0);
        $usageLimit = isset($_POST['usage_limit']) ? (int)$_POST['usage_limit'] : 1000;
        $perUserLimit = isset($_POST['per_user_limit']) ? (int)$_POST['per_user_limit'] : 1;
        $channel = trim($_POST['channel'] ?? 'all');
        $startsAt = !empty($_POST['starts_at']) ? trim($_POST['starts_at']) : date('Y-m-d H:i:s');
        $expiresAt = !empty($_POST['expires_at']) ? trim($_POST['expires_at']) : null;
        $status = strtolower(trim($_POST['status'] ?? 'active'));

        if (empty($code)) {
            echo json_encode(['success' => false, 'message' => 'Coupon code is required.']);
            exit;
        }

        if ($val <= 0) {
            echo json_encode(['success' => false, 'message' => 'Discount value must be greater than zero.']);
            exit;
        }

        $stmt = $pdo->prepare("
            INSERT INTO `coupons` 
            (`code`, `title`, `discount_type`, `discount_value`, `min_order_value`, `min_order_amount`, `max_discount`, `usage_limit`, `per_user_limit`, `channel`, `starts_at`, `expires_at`, `status`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE 
                title=VALUES(title),
                discount_type=VALUES(discount_type),
                discount_value=VALUES(discount_value),
                min_order_value=VALUES(min_order_value),
                min_order_amount=VALUES(min_order_amount),
                max_discount=VALUES(max_discount),
                usage_limit=VALUES(usage_limit),
                per_user_limit=VALUES(per_user_limit),
                channel=VALUES(channel),
                starts_at=VALUES(starts_at),
                expires_at=VALUES(expires_at),
                status=VALUES(status)
        ");
        $stmt->execute([
            $code, $title, $type, $val, $min, $min, $maxDiscount, $usageLimit, $perUserLimit, $channel, $startsAt, $expiresAt, $status
        ]);

        DiscountEngine::logAudit($code, 'created', 'Admin', "Created promo code {$code} with value {$val} ({$type})");

        echo json_encode(['success' => true, 'message' => "Coupon {$code} successfully created in live database!"]);
        exit;
    }

    // ── 4. UPDATE COUPON / TOGGLE STATUS (Admin) ──
    if ($action === 'update') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'A valid coupon ID is required.']);
            exit;
        }

        $stmtFetch = $pdo->prepare("SELECT * FROM `coupons` WHERE `id` = ? LIMIT 1");
        $stmtFetch->execute([$id]);
        $existing = $stmtFetch->fetch(\PDO::FETCH_ASSOC);

        if (!$existing) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Coupon not found in database.']);
            exit;
        }

        $status = isset($_POST['status']) ? strtolower(trim((string)$_POST['status'])) : $existing['status'];
        $title = isset($_POST['title']) ? trim($_POST['title']) : ($existing['title'] ?? '');
        $usageLimit = isset($_POST['usage_limit']) ? (int)$_POST['usage_limit'] : (int)($existing['usage_limit'] ?? 1000);
        $expiresAt = isset($_POST['expires_at']) ? trim($_POST['expires_at']) : ($existing['expires_at'] ?? null);

        $updateStmt = $pdo->prepare("UPDATE `coupons` SET `status` = ?, `title` = ?, `usage_limit` = ?, `expires_at` = ? WHERE `id` = ?");
        $updateStmt->execute([$status, $title, $usageLimit, $expiresAt, $id]);

        DiscountEngine::logAudit($existing['code'], 'updated', 'Admin', "Updated status to {$status}, usage limit to {$usageLimit}", $id);

        echo json_encode(['success' => true, 'id' => $id, 'status' => $status, 'message' => "Coupon {$existing['code']} updated successfully!"]);
        exit;
    }

    // ── 5. DELETE COUPON (Admin) ──
    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'A valid coupon ID is required.']);
            exit;
        }

        $stmtCode = $pdo->prepare("SELECT code FROM `coupons` WHERE `id` = ?");
        $stmtCode->execute([$id]);
        $code = (string)$stmtCode->fetchColumn();

        $stmt = $pdo->prepare("DELETE FROM `coupons` WHERE `id` = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() === 0) {
            http_response_code(404);
            echo json_encode(['success' => false, 'id' => $id, 'message' => 'Coupon no longer exists.']);
            exit;
        }

        DiscountEngine::logAudit($code ?: "ID-{$id}", 'deleted', 'Admin', "Permanently deleted coupon #{$id}", $id);

        echo json_encode(['success' => true, 'id' => $id, 'message' => "Coupon #{$id} ({$code}) removed successfully."]);
        exit;
    }

    // ── 6. USAGES / REDEMPTIONS LEDGER (Admin) ──
    if ($action === 'usages') {
        $search = trim($_GET['search'] ?? '');
        $code = trim($_GET['code'] ?? '');
        $limit = max(1, min(200, (int)($_GET['limit'] ?? 50)));

        try {
            $sql = "SELECT * FROM `coupon_usages` WHERE 1=1";
            $params = [];

            if (!empty($code)) {
                $sql .= " AND `coupon_code` = ?";
                $params[] = strtoupper($code);
            }

            if (!empty($search)) {
                $sql .= " AND (`coupon_code` LIKE ? OR `order_number` LIKE ? OR `customer_phone` LIKE ? OR `customer_name` LIKE ?)";
                $params[] = "%{$search}%";
                $params[] = "%{$search}%";
                $params[] = "%{$search}%";
                $params[] = "%{$search}%";
            }

            $sql .= " ORDER BY `id` DESC LIMIT {$limit}";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $usages = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'count' => count($usages), 'usages' => $usages]);
        } catch (\Throwable $e) {
            echo json_encode(['success' => true, 'count' => 0, 'usages' => []]);
        }
        exit;
    }

    // ── 7. COUPON AUDIT TRAIL (Admin) ──
    if ($action === 'audit') {
        $limit = max(1, min(200, (int)($_GET['limit'] ?? 50)));

        try {
            $stmt = $pdo->prepare("SELECT * FROM `coupon_audit_logs` ORDER BY `id` DESC LIMIT {$limit}");
            $stmt->execute();
            $logs = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            echo json_encode(['success' => true, 'count' => count($logs), 'audit' => $logs]);
        } catch (\Throwable $e) {
            echo json_encode(['success' => true, 'count' => 0, 'audit' => []]);
        }
        exit;
    }

    // ── 8. EXTEND EXPIRY / RESET LIMITS (Admin) ──
    if ($action === 'extend') {
        $id = (int)($_POST['id'] ?? 0);
        $days = max(1, (int)($_POST['days'] ?? 30));
        $addLimit = max(0, (int)($_POST['add_limit'] ?? 500));

        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Coupon ID required.']);
            exit;
        }

        $stmt = $pdo->prepare("
            UPDATE `coupons` 
            SET `status` = 'active',
                `expires_at` = DATE_ADD(GREATEST(COALESCE(expires_at, NOW()), NOW()), INTERVAL ? DAY),
                `usage_limit` = COALESCE(usage_limit, 0) + ?
            WHERE `id` = ?
        ");
        $stmt->execute([$days, $addLimit, $id]);

        echo json_encode(['success' => true, 'message' => "Coupon extended by {$days} days and +{$addLimit} usage quota."]);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Invalid action parameter.']);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
