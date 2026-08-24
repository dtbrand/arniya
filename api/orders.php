<?php
/**
 * api/orders.php — Complete Order Processing, Lifecycle & Status Management API Engine
 * DT Brand's & Jai Hanuman Tex
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/OrderManager.php';
require_once __DIR__ . '/../src/PricingCalculator.php';
require_once __DIR__ . '/../src/Auth.php';

use DTBrand\OrderManager;
use DTBrand\Auth;

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create') {
    $currentUser = Auth::getCurrentUser();
    $customerId = $currentUser['id'] ?? (int)($_POST['customer_id'] ?? 0);
    $customerName = trim($_POST['customer_name'] ?? ($currentUser['name'] ?? 'Direct Customer'));
    $customerPhone = trim($_POST['customer_phone'] ?? ($currentUser['phone'] ?? ''));
    $customerEmail = trim($_POST['customer_email'] ?? ($currentUser['email'] ?? ''));
    $channel = trim($_POST['channel'] ?? ($currentUser['type'] ?? 'retail'));

    $items = $_SESSION['cart_items'] ?? [];
    if (empty($items) && isset($_POST['items'])) {
        $items = json_decode($_POST['items'], true) ?: [];
    }

    if (empty($items)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Cart is empty. Please add products to proceed.']);
        exit;
    }

    $discount = (float)($_SESSION['cart_coupon']['discount'] ?? $_POST['discount'] ?? 0.0);
    $shipping = (float)($_POST['shipping'] ?? 0.0);
    $paymentMethod = trim($_POST['payment_method'] ?? 'razorpay');

    $order = OrderManager::createOrder([
        'customer_id' => $customerId,
        'customer_name' => $customerName,
        'customer_phone' => $customerPhone,
        'customer_email' => $customerEmail,
        'channel' => $channel,
        'items' => array_values($items),
        'discount' => $discount,
        'shipping' => $shipping,
        'payment_method' => $paymentMethod,
        'payment_status' => 'paid',
        'fulfillment_status' => 'confirmed'
    ]);

    // Clear cart session after successful checkout
    $_SESSION['cart_items'] = [];
    $_SESSION['cart_coupon'] = null;

    echo json_encode([
        'success' => true,
        'message' => 'Order placed successfully! Consignment is confirmed.',
        'order' => $order
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update_status') {
    $orderId = trim($_POST['order_id'] ?? $_POST['id'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $tracking = trim($_POST['tracking_number'] ?? '');
    $courier = trim($_POST['courier_name'] ?? '');

    if (empty($orderId) || empty($status)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Order ID and Status are required.']);
        exit;
    }

    $ok = OrderManager::updateStatus($orderId, $status, $tracking ?: null, $courier ?: null);
    echo json_encode([
        'success' => $ok,
        'message' => $ok ? "Order status updated to {$status}" : "Failed to update order status",
        'order_id' => $orderId,
        'status' => $status
    ]);
    exit;
}

if ($action === 'customer_orders') {
    $currentUser = Auth::getCurrentUser();
    $customerId = (int)($_GET['customer_id'] ?? ($currentUser['id'] ?? 0));
    if ($customerId <= 0) {
        http_response_code(401);
        echo json_encode(['success' => false, 'message' => 'Authentication required']);
        exit;
    }

    $orders = OrderManager::getByCustomerId($customerId);
    echo json_encode([
        'success' => true,
        'count' => count($orders),
        'orders' => $orders
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

// Default: List all orders
$orders = OrderManager::getAll();
echo json_encode([
    'success' => true,
    'count' => count($orders),
    'orders' => $orders,
    'timestamp' => date('Y-m-d H:i:s')
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
