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

use DTBrand\OrderManager;
use DTBrand\Database;

try {
    $method = $_SERVER['REQUEST_METHOD'];

    // Track order or list orders
    if ($method === 'GET') {
        $action = trim($_GET['action'] ?? '');
        if ($action === 'analytics') {
            $range = $_GET['range'] ?? '1M';
            $pdo = Database::getConnection();
            $totalSales = 0.0;
            $orderCount = 0;
            if ($pdo !== null && !Database::isMockMode()) {
                try {
                    $totalSales = (float)$pdo->query("SELECT COALESCE(SUM(total), 0) FROM `orders` WHERE status != 'cancelled'")->fetchColumn();
                    $orderCount = (int)$pdo->query("SELECT COUNT(*) FROM `orders` WHERE status != 'cancelled'")->fetchColumn();
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

    // Create Order
    if ($method === 'POST') {
        $rawInput = file_get_contents('php://input');
        $data = json_decode($rawInput, true) ?: $_POST;

        if (empty($data['items']) || !is_array($data['items'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Order must contain items.']);
            exit;
        }

        $res = OrderManager::createOrder($data);
        if ($res['success']) {
            echo json_encode($res, JSON_PRETTY_PRINT);
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
