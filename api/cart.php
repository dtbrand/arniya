<?php
/**
 * api/cart.php — Server-Side Cart Calculation & Lot Validation API
 * Master Specification V2: Section 44 (Cart Audit)
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/cors.php';
cors_json();

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/../src/PricingCalculator.php';
require_once __DIR__ . '/../src/DiscountEngine.php';
require_once __DIR__ . '/../src/CartManager.php';
require_once __DIR__ . '/../src/Auth.php';

use DTBrand\ProductCatalog;
use DTBrand\PricingCalculator;
use DTBrand\DiscountEngine;
use DTBrand\CartManager;
use DTBrand\Database;
use DTBrand\Auth;

try {
    $rawInput = file_get_contents('php://input');
    $data = json_decode($rawInput, true) ?: $_POST;

    $items = $data['items'] ?? ($data['cart'] ?? []);
    if (!is_array($items)) {
        $items = [];
    }

    // Session-Authoritative Role Resolution (Section 14 & 33: Never trust client-submitted role)
    Auth::initSession();
    $currentUser = Auth::getCurrentUser() ?? ($_SESSION['user'] ?? null);
    $rawUserType = strtolower(trim((string)($data['user_type'] ?? '')));
    if (!empty($_SESSION['admin_logged_in'])) {
        $userType = in_array($rawUserType, ['wholesale', 'retailer', 'reseller', 'customer'], true) ? $rawUserType : 'wholesale';
    } elseif (!empty($currentUser['id'])) {
        $uid = (int)$currentUser['id'];
        $db = Database::getConnection();
        $verifiedType = 'customer';
        if ($db) {
            try {
                $uStmt = $db->prepare("SELECT type, status FROM customers WHERE id = ? LIMIT 1");
                $uStmt->execute([$uid]);
                $uRow = $uStmt->fetch(\PDO::FETCH_ASSOC);
                if ($uRow && ($uRow['status'] ?? '') === 'active') {
                    $verifiedType = strtolower(trim((string)$uRow['type']));
                }
            } catch (\Throwable $e) {}
        }
        if ($verifiedType === 'wholesaler') { $verifiedType = 'wholesale'; }
        if ($verifiedType === 'retail') { $verifiedType = 'customer'; }
        $userType = in_array($verifiedType, ['wholesale', 'retailer', 'reseller'], true) ? $verifiedType : 'customer';
    } else {
        $userType = 'guest';
    }

    $couponCode = trim((string)($data['coupon'] ?? ($data['coupon_code'] ?? '')));
    $gstRate = isset($data['gst_rate']) ? (float)$data['gst_rate'] : 5.0;

    // Call CartManager for authoritative recalculation
    $cartResult = CartManager::validateAndRecalculateCart($items, $userType, $couponCode, $gstRate);

    // If there are validation errors (e.g. MCQ violation, unauthorized Full Set, stale products)
    if (!$cartResult['success'] && !empty($cartResult['errors'])) {
        $hasRoleForbidden = false;
        foreach ($cartResult['errors'] as $err) {
            if (stripos($err, 'exclusively available to verified') !== false) {
                $hasRoleForbidden = true;
                break;
            }
        }

        http_response_code($hasRoleForbidden ? 403 : 400);
        echo json_encode([
            'success'               => false,
            'message'               => implode(' ', $cartResult['errors']),
            'errors'                => $cartResult['errors'],
            'warnings'              => $cartResult['warnings'],
            'user_type'             => $userType,
            'item_count'            => $cartResult['item_count'],
            'total_qty'             => $cartResult['total_physical_pieces'],
            'items'                 => $cartResult['items'],
            'cart'                  => $cartResult['cart'],
            'pricing'               => $cartResult['pricing'],
            'subtotal'              => $cartResult['subtotal'],
            'discount'              => $cartResult['discount'],
            'shipping'              => $cartResult['shipping'],
            'grand_total'           => $cartResult['grand_total'],
            'free_shipping'         => $cartResult['shipping_info']['is_free'],
            'free_shipping_threshold' => $cartResult['shipping_info']['free_at'],
            'shipping_rate'         => $cartResult['shipping_info']['standard_rate']
        ], JSON_PRETTY_PRINT);
        exit;
    }

    // Success response with full authoritative financial breakdown
    echo json_encode([
        'success'                 => true,
        'user_type'               => $userType,
        'item_count'              => $cartResult['item_count'],
        'total_qty'               => $cartResult['total_physical_pieces'],
        'items'                   => $cartResult['items'],
        'cart'                    => $cartResult['cart'],
        'pricing'                 => $cartResult['pricing'],
        'subtotal'                => $cartResult['subtotal'],
        'discount'                => $cartResult['discount'],
        'shipping'                => $cartResult['shipping'],
        'grand_total'             => $cartResult['grand_total'],
        'coupon_info'             => $cartResult['coupon_info'],
        'free_shipping'           => $cartResult['shipping_info']['is_free'],
        'free_shipping_threshold' => $cartResult['shipping_info']['free_at'],
        'shipping_rate'           => $cartResult['shipping_info']['standard_rate'],
        'warnings'                => $cartResult['warnings']
    ], JSON_PRETTY_PRINT);

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
