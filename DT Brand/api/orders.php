<?php
/**
 * api/orders.php — Order Creation & Tracking API
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/PricingCalculator.php';
require_once __DIR__ . '/../src/OrderManager.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\OrderManager;
use DTBrand\Database;

try {
    $method = $_SERVER['REQUEST_METHOD'];

    // Track order or list orders
    if ($method === 'GET') {
        $action = trim($_GET['action'] ?? '');
        if ($action === 'analytics') {
            // Admin-only: shop-wide revenue. The only caller is the admin
            // dashboard chart (admin/Asset/js/admin.js).
            dt_api_require_admin('view order analytics');

            $range = $_GET['range'] ?? '1M';
            $pdo = Database::getConnection();
            $totalSales = 0.0;
            $orderCount = 0;
            if ($pdo !== null && !Database::isMockMode()) {
                try {
                    $totalSales = (float)$pdo->query("SELECT COALESCE(SUM(total_amount), 0) FROM `orders` WHERE fulfillment_status != 'cancelled'")->fetchColumn();
                    $orderCount = (int)$pdo->query("SELECT COUNT(*) FROM `orders` WHERE fulfillment_status != 'cancelled'")->fetchColumn();
                } catch (\Exception $e) {}
            }
            echo json_encode([
                'success' => true,
                'range' => $range,
                'total_sales' => $totalSales,
                'order_count' => $orderCount
            ]);
            exit;
        }

        $orderNumber = trim($_GET['order_number'] ?? '');

        $phone = trim($_GET['phone'] ?? '');

        // Self-service order tracking. A buyer must present BOTH the order number
        // and the phone number on that order, so knowing one alone reveals
        // nothing. Order numbers are sequential (DT-ORD-90281, DT-ORD-89412...),
        // so accepting an order number by itself let anyone walk the whole order
        // book — names, phone numbers, addresses and amounts. Requiring the pair
        // keeps the feature usable without making it enumerable.
        if ($orderNumber !== '' && $phone !== '' && !dt_api_is_admin()) {
            $order = OrderManager::getByOrderNumber($orderNumber);
            $digits = static function ($v) {
                $d = preg_replace('/\D+/', '', (string)$v);
                return strlen($d) > 10 ? substr($d, -10) : $d;
            };
            if ($order && $digits($order['customer_phone'] ?? '') !== '' &&
                $digits($order['customer_phone'] ?? '') === $digits($phone)) {
                echo json_encode(['success' => true, 'order' => $order]);
            } else {
                // Deliberately identical for "no such order" and "wrong phone",
                // so this cannot be used to test whether an order exists.
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'No order found for that order number and phone number.']);
            }
            exit;
        }

        // Everything below reads other people's orders in bulk, so it is
        // admin-only. None of these had any authentication: a bare
        // GET /api/orders.php returned OrderManager::getAll() — every order in
        // the shop with customer names, phone numbers and totals — and
        // ?phone= let anyone dump a given customer's full order history.
        dt_api_require_admin('read order records');

        if (!empty($orderNumber)) {
            $order = OrderManager::getByOrderNumber($orderNumber);
            if ($order) {
                echo json_encode(['success' => true, 'order' => $order]);
            } else {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Order not found.']);
            }
            exit;
        }

        if (!empty($phone)) {
            $orders = OrderManager::getByPhone($phone);
            echo json_encode(['success' => true, 'count' => count($orders), 'orders' => $orders]);
            exit;
        }

        echo json_encode(['success' => true, 'orders' => OrderManager::getAll()]);
        exit;

    }

    // Order Actions (Create, Update Status, Delete)
    if ($method === 'POST') {
        $rawInput = file_get_contents('php://input');
        $jsonData = json_decode($rawInput, true);
        $data = is_array($jsonData) ? $jsonData : $_POST;

        $action = trim($data['action'] ?? 'create');

        // Update Order Status / Tracking
        if ($action === 'update_status') {
            // Admin-only: the caller is the admin order screen
            // (admin/orders/assets/js/order-status.js). Unauthenticated, this let
            // anyone mark any order paid, dispatched or cancelled.
            dt_api_require_admin('update an order');

            $orderId = $data['order_id'] ?? ($data['id'] ?? '');
            $status = trim($data['status'] ?? 'processing');
            $tracking = !empty($data['tracking_number']) ? trim($data['tracking_number']) : null;
            $courier = !empty($data['courier_name']) ? trim($data['courier_name']) : null;

            if (empty($orderId)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Order ID required.']);
                exit;
            }

            $ok = OrderManager::updateStatus($orderId, $status, $tracking, $courier);
            echo json_encode(['success' => $ok, 'order_id' => $orderId, 'status' => $status, 'message' => $ok ? 'Order status updated in live database.' : 'Failed to update order status.']);
            exit;
        }

        // Delete Order
        if ($action === 'delete') {
            // Admin-only, and irreversible.
            dt_api_require_admin('delete an order');

            $orderId = $data['order_id'] ?? ($data['id'] ?? '');
            if (empty($orderId)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Order ID required for deletion.']);
                exit;
            }
            $ok = OrderManager::deleteOrder($orderId);
            echo json_encode(['success' => $ok, 'order_id' => $orderId, 'message' => $ok ? 'Order permanently removed from database.' : 'Failed to remove order.']);
            exit;
        }

        // Create Order
        if (!empty($data['items']) && is_string($data['items'])) {
            $data['items'] = json_decode($data['items'], true);
        }

        if (empty($data['items']) || !is_array($data['items'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Order must contain items array.']);
            exit;
        }

        $res = OrderManager::createOrder($data);
        if ($res['success']) {
            echo json_encode([
                'success' => true,
                'order' => $res,
                'message' => 'Order successfully created in live database.'
            ], JSON_PRETTY_PRINT);
        } else {
            http_response_code(400);
            echo json_encode($res, JSON_PRETTY_PRINT);
        }
        exit;
    }

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
