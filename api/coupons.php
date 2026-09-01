<?php
/**
 * coupons.php — Coupon Code Management & Validation API
 * DT Brand's & Jai Hanuman Tex
 *
 * Schema (live `arniya` production):
 *   coupons(id, code, discount_type ENUM('percentage','flat'),
 *           discount_value, min_order_value, max_discount,
 *           status ENUM('active','expired'))
 */
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\Database;

$action = $_REQUEST['action'] ?? 'get_all';
$pdo = Database::getConnection();

// `validate` is the only action the storefront uses (shared/checkout.php sends
// action=validate&code=…&subtotal=…), and a shopper must be able to try a code
// without signing in as an admin, so it stays public.
//
// Everything else is admin-only. Without this, any visitor could POST
// action=create to mint themselves a 100%-off coupon, POST action=delete to
// destroy the campaigns the shop is running, or GET action=get_all to dump every
// unpublished discount code in the table.
if ($action !== 'validate') {
    dt_api_require_admin('manage coupons');
}

/**
 * Compute the discount a coupon grants on a given subtotal.
 * Returns ['ok' => bool, 'discount' => float, 'message' => string].
 */
function dt_coupon_apply(array $c, float $subtotal): array
{
    $status = strtolower($c['status'] ?? 'active');
    if ($status !== 'active') {
        return ['ok' => false, 'discount' => 0.0, 'message' => 'This coupon is no longer active.'];
    }

    $min = (float)($c['min_order_value'] ?? 0);
    if ($subtotal < $min) {
        $needed = $min - $subtotal;
        return ['ok' => false, 'discount' => 0.0, 'message' => 'Add ₹' . number_format($needed, 0) . ' more to use this coupon (min ₹' . number_format($min, 0) . ').'];
    }

    $type = strtolower($c['discount_type'] ?? 'percentage');
    $value = (float)($c['discount_value'] ?? 0);
    $maxDiscount = (float)($c['max_discount'] ?? 0);

    if ($type === 'percentage') {
        $discount = $subtotal * ($value / 100.0);
        if ($maxDiscount > 0) {
            $discount = min($discount, $maxDiscount);
        }
    } else { // 'flat'
        $discount = $value;
    }

    $discount = min($discount, $subtotal); // never exceed the bag value
    $discount = round($discount);

    return ['ok' => true, 'discount' => $discount, 'message' => 'Coupon applied — you saved ₹' . number_format($discount, 0) . '.'];
}

// ── OFFLINE / MOCK MODE ──
// Mirrors the live seed so validation still behaves correctly when MySQL is unreachable.
if ($pdo === null || Database::isMockMode()) {
    $mock = [
        ['id' => 1, 'code' => 'FESTIVE25',   'discount_type' => 'percentage', 'discount_value' => 25.00, 'min_order_value' => 1999.00,  'max_discount' => 1500.00, 'status' => 'active'],
        ['id' => 2, 'code' => 'VIPRESELLER', 'discount_type' => 'percentage', 'discount_value' => 15.00, 'min_order_value' => 3000.00,  'max_discount' => 2000.00, 'status' => 'active'],
        ['id' => 3, 'code' => 'BULK50',      'discount_type' => 'percentage', 'discount_value' => 50.00, 'min_order_value' => 20000.00, 'max_discount' => 10000.00, 'status' => 'active'],
    ];

    if ($action === 'validate') {
        $code = strtoupper(trim($_REQUEST['code'] ?? ''));
        $subtotal = (float)($_REQUEST['subtotal'] ?? 0);
        foreach ($mock as $c) {
            if ($c['code'] === $code) {
                $r = dt_coupon_apply($c, $subtotal);
                echo json_encode(['success' => $r['ok'], 'code' => $code, 'discount' => $r['discount'], 'discount_type' => $c['discount_type'], 'message' => $r['message']]);
                exit;
            }
        }
        echo json_encode(['success' => false, 'discount' => 0, 'message' => 'Invalid coupon code.']);
        exit;
    }

    echo json_encode(['success' => true, 'coupons' => $mock]);
    exit;
}

try {
    if ($action === 'validate') {
        $code = strtoupper(trim($_REQUEST['code'] ?? ''));
        $subtotal = (float)($_REQUEST['subtotal'] ?? 0);
        if ($code === '') {
            echo json_encode(['success' => false, 'discount' => 0, 'message' => 'Please enter a coupon code.']);
            exit;
        }
        $stmt = $pdo->prepare("SELECT * FROM `coupons` WHERE `code` = ? LIMIT 1");
        $stmt->execute([$code]);
        $c = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$c) {
            echo json_encode(['success' => false, 'discount' => 0, 'message' => 'Invalid coupon code.']);
            exit;
        }
        $r = dt_coupon_apply($c, $subtotal);
        echo json_encode(['success' => $r['ok'], 'code' => $code, 'discount' => $r['discount'], 'discount_type' => $c['discount_type'], 'message' => $r['message']]);
        exit;
    }

    if ($action === 'get_all') {
        $stmt = $pdo->query("SELECT * FROM `coupons` ORDER BY `id` DESC");
        $coupons = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'coupons' => $coupons]);
        exit;
    }

    if ($action === 'create') {
        $code = strtoupper(trim($_POST['code'] ?? ''));
        // Storefront enum is ('percentage','flat'); the admin UIs historically
        // submit 'fixed' for a flat-amount coupon, so treat it as 'flat'.
        $rawType = strtolower(trim($_POST['discount_type'] ?? 'percentage'));
        $type = ($rawType === 'flat' || $rawType === 'fixed') ? 'flat' : 'percentage';
        $val = (float)($_POST['discount_value'] ?? 10);
        $min = (float)($_POST['min_order_value'] ?? $_POST['min_order_amount'] ?? 0);
        $maxDiscount = (float)($_POST['max_discount'] ?? $_POST['max_discount_amount'] ?? 0);

        if (empty($code)) {
            echo json_encode(['success' => false, 'message' => 'Coupon code is required.']);
            exit;
        }

        $stmt = $pdo->prepare("
            INSERT INTO `coupons` (`code`, `discount_type`, `discount_value`, `min_order_value`, `max_discount`, `status`)
            VALUES (?, ?, ?, ?, ?, 'active')
            ON DUPLICATE KEY UPDATE discount_type=VALUES(discount_type), discount_value=VALUES(discount_value), min_order_value=VALUES(min_order_value), max_discount=VALUES(max_discount), status='active'
        ");
        $stmt->execute([$code, $type, $val, $min, $maxDiscount]);

        echo json_encode(['success' => true, 'message' => "Coupon {$code} saved successfully!"]);
        exit;
    }

    if ($action === 'update') {
        // Toggle / edit from admin/pricing/discounts.php. Status is the only
        // field the UI changes today, but the guard block above already
        // requires an admin session for anything reaching here.
        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'A coupon ID is required.']);
            exit;
        }
        $status = strtolower(trim((string)($_POST['status'] ?? '')));
        if (!in_array($status, ['active', 'expired'], true)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Status must be active or expired.']);
            exit;
        }
        $stmt = $pdo->prepare("UPDATE `coupons` SET `status` = ? WHERE `id` = ?");
        $stmt->execute([$status, $id]);
        if ($stmt->rowCount() === 0) {
            // Same row-state or missing id; distinguish honestly.
            $row = $pdo->prepare("SELECT status FROM `coupons` WHERE `id` = ?");
            $row->execute([$id]);
            $existing = $row->fetch(\PDO::FETCH_ASSOC);
            if (!$existing) {
                http_response_code(404);
                echo json_encode(['success' => false, 'id' => $id, 'message' => 'That coupon does not exist.']);
                exit;
            }
        }
        echo json_encode(['success' => true, 'id' => $id, 'message' => "Coupon set to {$status}."]);
        exit;
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'A coupon ID is required.']);
            exit;
        }
        $stmt = $pdo->prepare("DELETE FROM `coupons` WHERE `id` = ?");
        $stmt->execute([$id]);
        // Report what actually happened. This used to echo success even when the
        // id was missing or matched no row, so the admin list removed the row and
        // toasted "deleted from database" for a coupon that was still live.
        if ($stmt->rowCount() === 0) {
            http_response_code(404);
            echo json_encode(['success' => false, 'id' => $id, 'message' => 'That coupon no longer exists.']);
            exit;
        }
        echo json_encode(['success' => true, 'id' => $id, 'message' => 'Coupon removed successfully.']);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
} catch (\Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
