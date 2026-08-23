<?php
/**
 * api/orders.php — Order Processing & Checkout API Engine
 * DT Brand's & Jai Hanuman Tex
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

require_once __DIR__ . '/../src/OrderManager.php';
require_once __DIR__ . '/../src/PricingCalculator.php';
use DTBrand\OrderManager;

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create') {
    $customerName = trim($_POST['customer_name'] ?? 'Valued Customer');
    $customerPhone = trim($_POST['customer_phone'] ?? '');
    $customerEmail = trim($_POST['customer_email'] ?? '');
    $channel = trim($_POST['channel'] ?? 'retail');

    $items = $_SESSION['cart_items'] ?? [];
    if (empty($items) && isset($_POST['items'])) {
        $items = json_decode($_POST['items'], true) ?: [];
    }

    if (empty($items)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Cart is empty']);
        exit;
    }

    $discount = (float)($_SESSION['cart_coupon']['discount'] ?? $_POST['discount'] ?? 0.0);
    $order = OrderManager::createOrder([
        'customer_name' => $customerName,
        'customer_phone' => $customerPhone,
        'customer_email' => $customerEmail,
        'channel' => $channel,
        'items' => array_values($items),
        'discount' => $discount,
        'payment_status' => 'pending'
    ]);

    // Clear cart after checkout
    $_SESSION['cart_items'] = [];
    $_SESSION['cart_coupon'] = null;

    echo json_encode([
        'success' => true,
        'message' => 'Order placed successfully',
        'order' => $order
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

echo json_encode([
    'success' => true,
    'message' => 'Order API ready',
    'timestamp' => date('Y-m-d H:i:s')
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
