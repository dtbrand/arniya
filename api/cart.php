<?php
/**
 * api/cart.php — Session Shopping Cart REST & AJAX Engine
 * DT Brand's & Jai Hanuman Tex
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/../src/PricingCalculator.php';
require_once __DIR__ . '/../src/DiscountEngine.php';

use DTBrand\ProductCatalog;
use DTBrand\PricingCalculator;
use DTBrand\DiscountEngine;

if (!isset($_SESSION['cart_items'])) {
    $_SESSION['cart_items'] = [];
}
if (!isset($_SESSION['cart_coupon'])) {
    $_SESSION['cart_coupon'] = null;
}

$availableCoupons = [
    'WELCOME10' => ['type' => 'percent', 'value' => 10, 'min_order' => 2000, 'max_discount' => 1000],
    'FESTIVE20' => ['type' => 'percent', 'value' => 20, 'min_order' => 5000, 'max_discount' => 2500],
    'FLAT500'   => ['type' => 'flat', 'value' => 500, 'min_order' => 4000, 'max_discount' => 500],
    'SILK15'    => ['type' => 'percent', 'value' => 15, 'min_order' => 3000, 'max_discount' => 1500]
];

$method = $_SERVER['REQUEST_METHOD'];
$action = $_POST['action'] ?? $_GET['action'] ?? 'view';

if ($method === 'POST') {
    if ($action === 'add') {
        $productId = (int)($_POST['product_id'] ?? 0);
        $qty = max(1, (int)($_POST['quantity'] ?? 1));
        $product = ProductCatalog::getById($productId);

        if ($product) {
            if (isset($_SESSION['cart_items'][$productId])) {
                $_SESSION['cart_items'][$productId]['quantity'] += $qty;
            } else {
                $_SESSION['cart_items'][$productId] = [
                    'id' => $product['id'],
                    'sku' => $product['sku'],
                    'title' => $product['title'],
                    'category' => $product['category'],
                    'price' => $product['retail_price'],
                    'mrp' => $product['mrp'],
                    'image' => $product['image'],
                    'quantity' => $qty
                ];
            }
        }
    } elseif ($action === 'update') {
        $productId = (int)($_POST['product_id'] ?? 0);
        $qty = (int)($_POST['quantity'] ?? 1);
        if ($qty <= 0) {
            unset($_SESSION['cart_items'][$productId]);
        } elseif (isset($_SESSION['cart_items'][$productId])) {
            $_SESSION['cart_items'][$productId]['quantity'] = $qty;
        }
    } elseif ($action === 'remove') {
        $productId = (int)($_POST['product_id'] ?? 0);
        unset($_SESSION['cart_items'][$productId]);
    } elseif ($action === 'clear') {
        $_SESSION['cart_items'] = [];
        $_SESSION['cart_coupon'] = null;
    } elseif ($action === 'apply_coupon') {
        $code = trim($_POST['coupon_code'] ?? '');
        $subtotal = 0.0;
        foreach ($_SESSION['cart_items'] as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }
        $result = DiscountEngine::applyCoupon($code, $subtotal, $availableCoupons);
        if ($result['valid']) {
            $_SESSION['cart_coupon'] = $result;
        }
    } elseif ($action === 'remove_coupon') {
        $_SESSION['cart_coupon'] = null;
    }
}

// Compute Totals
$items = array_values($_SESSION['cart_items']);
$subtotal = 0.0;
$totalItems = 0;

foreach ($items as $item) {
    $subtotal += ($item['price'] * $item['quantity']);
    $totalItems += $item['quantity'];
}

$discount = 0.0;
if (!empty($_SESSION['cart_coupon'])) {
    $cResult = DiscountEngine::applyCoupon($_SESSION['cart_coupon']['code'], $subtotal, $availableCoupons);
    if ($cResult['valid']) {
        $discount = $cResult['discount'];
    } else {
        $_SESSION['cart_coupon'] = null;
    }
}

$shipping = ($subtotal > 0 && $subtotal < 1999) ? 150.0 : 0.0;
$pricing = PricingCalculator::calculateOrderTotal($subtotal, $discount, $shipping, 5.0);

echo json_encode([
    'success' => true,
    'total_items' => $totalItems,
    'items' => $items,
    'coupon' => $_SESSION['cart_coupon'],
    'pricing' => $pricing
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
