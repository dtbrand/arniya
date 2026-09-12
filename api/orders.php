<?php
/**
 * api/orders.php — Order Creation & Tracking API
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/cors.php';
cors_json();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/PricingCalculator.php';
require_once __DIR__ . '/../src/OrderManager.php';
require_once __DIR__ . '/../src/CheckoutManager.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\OrderManager;
use DTBrand\CheckoutManager;
use DTBrand\Database;
use DTBrand\Auth;

try {
    Auth::initSession();
    $method = $_SERVER['REQUEST_METHOD'];

    // Track order or list orders
    if ($method === 'GET') {
        $action = trim($_GET['action'] ?? '');
        if ($action === 'analytics') {
            // Admin-only: shop-wide revenue. The only caller is the admin
            // dashboard chart (admin/Asset/js/admin.js).
            dt_api_require_admin('view order analytics');

            // `range` used to be read and then ignored: both queries below
            // summed the whole order book, so 1W, 1M and 1Y all returned the
            // same lifetime figure. Each range now maps to a real window, and
            // the previous window of equal length comes back with it so the
            // caller can show a genuine growth number.
            $range = strtoupper(trim((string)($_GET['range'] ?? '1M')));
            $windows = ['1W' => 7, '1M' => 30, '1Y' => 365, 'ALL' => 0];
            if (!array_key_exists($range, $windows)) { $range = '1M'; }
            $days = $windows[$range];

            $pdo = Database::getConnection();
            $totalSales = 0.0;
            $orderCount = 0;
            $prevSales  = 0.0;
            $prevCount  = 0;
            // fulfillment_status != 'cancelled' evaluates to NULL, not TRUE, for
            // a NULL row, so NULL-status orders were silently dropped from both
            // aggregates. COALESCE keeps them counted.
            $notCancelled = "COALESCE(`fulfillment_status`, 'unfulfilled') <> 'cancelled'";
            if ($pdo !== null && !Database::isMockMode()) {
                try {
                    $curWhere  = $notCancelled;
                    $prevWhere = null;
                    if ($days > 0) {
                        $curWhere  .= " AND `created_at` >= (CURDATE() - INTERVAL " . ($days - 1) . " DAY)";
                        $prevWhere  = $notCancelled
                            . " AND `created_at` >= (CURDATE() - INTERVAL " . (($days * 2) - 1) . " DAY)"
                            . " AND `created_at` <  (CURDATE() - INTERVAL " . ($days - 1) . " DAY)";
                    }
                    $row = $pdo->query(
                        "SELECT COALESCE(SUM(`total_amount`), 0) AS s, COUNT(*) AS c FROM `orders` WHERE {$curWhere}"
                    )->fetch(\PDO::FETCH_ASSOC) ?: [];
                    $totalSales = (float)($row['s'] ?? 0);
                    $orderCount = (int)($row['c'] ?? 0);

                    if ($prevWhere !== null) {
                        $pRow = $pdo->query(
                            "SELECT COALESCE(SUM(`total_amount`), 0) AS s, COUNT(*) AS c FROM `orders` WHERE {$prevWhere}"
                        )->fetch(\PDO::FETCH_ASSOC) ?: [];
                        $prevSales = (float)($pRow['s'] ?? 0);
                        $prevCount = (int)($pRow['c'] ?? 0);
                    }
                } catch (\Throwable $e) {
                    error_log('Order analytics query failed: ' . $e->getMessage());
                }
            }
            $growth = $prevSales > 0
                ? round((($totalSales - $prevSales) / $prevSales) * 100, 1)
                : ($totalSales > 0 ? 100.0 : 0.0);
            echo json_encode([
                'success'          => true,
                'range'            => $range,
                'days'             => $days,
                'total_sales'      => round($totalSales, 2),
                'order_count'      => $orderCount,
                'prev_total_sales' => round($prevSales, 2),
                'prev_order_count' => $prevCount,
                'growth_pct'       => $growth,
            ]);
            exit;
        }

        // Customer Order History (My Orders) - Requires customer authentication
        if ($action === 'my_orders') {
            $currentUser = Auth::getCurrentUser();
            $isAdmin = dt_api_is_admin();
            $authUserId = (int)($currentUser['id'] ?? 0);

            if ($isAdmin) {
                $targetPhone = (string)($currentUser['phone'] ?? ($_GET['phone'] ?? ''));
                $targetId = (int)($currentUser['id'] ?? ($_GET['customer_id'] ?? 0));

                if ($targetId <= 0 && !empty($targetPhone)) {
                    $pdo = Database::getConnection();
                    if ($pdo !== null && !Database::isMockMode()) {
                        $digits = preg_replace('/\D+/', '', $targetPhone);
                        if (strlen($digits) >= 10) {
                            $pStmt = $pdo->prepare("SELECT id, phone FROM customers WHERE phone LIKE ? LIMIT 1");
                            $pStmt->execute(['%' . substr($digits, -10)]);
                            $pRow = $pStmt->fetch(\PDO::FETCH_ASSOC);
                            if ($pRow && !empty($pRow['id'])) {
                                $targetId = (int)$pRow['id'];
                                $targetPhone = (string)$pRow['phone'];
                            }
                        }
                    }
                }
            } else {
                $targetId = $authUserId;
                $targetPhone = (string)($currentUser['phone'] ?? '');
            }

            if ($targetId <= 0) {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Customer authentication required. Please sign in to view your orders.']);
                exit;
            }
            
            $orders = OrderManager::getByCustomerOrPhone($targetId, $targetPhone);
            echo json_encode([
                'success' => true,
                'count'   => count($orders),
                'orders'  => $orders
            ]);
            exit;
        }

        // Single Order Details with full line items & timeline history
        if ($action === 'details' || $action === 'get_order_details') {
            $orderId = trim($_GET['order_id'] ?? ($_GET['id'] ?? ($_GET['order_number'] ?? '')));
            if ($orderId === '') {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Order ID or order number required.']);
                exit;
            }

            $currentUser = Auth::getCurrentUser();
            $isAdmin = dt_api_is_admin();

            $order = OrderManager::getOrderDetails($orderId);
            if (!$order) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Order not found.']);
                exit;
            }

            // Security verification: must be admin OR verified order owner
            if (!$isAdmin) {
                $userId = (int)($currentUser['id'] ?? 0);
                if ($userId <= 0) {
                    http_response_code(401);
                    echo json_encode(['success' => false, 'message' => 'Sign in required to view order details. For guest order tracking, please use track order with order number and phone number.']);
                    exit;
                }

                $userPhone = (string)($currentUser['phone'] ?? '');
                $digits = static function ($v) {
                    $d = preg_replace('/\D+/', '', (string)$v);
                    return strlen($d) > 10 ? substr($d, -10) : $d;
                };

                $orderCustId = (int)($order['customer_id'] ?? 0);
                $isOwner = ($orderCustId === $userId)
                    || (!empty($userPhone) && $digits($order['customer_phone'] ?? '') !== '' && $digits($order['customer_phone'] ?? '') === $digits($userPhone));

                if (!$isOwner) {
                    http_response_code(403);
                    echo json_encode(['success' => false, 'message' => 'Access denied to this order record.']);
                    exit;
                }
            }

            echo json_encode(['success' => true, 'order' => $order]);
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
        if (empty($data) && !empty($rawInput)) {
            parse_str($rawInput, $data);
        }

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
            $updatedOrder = $ok ? OrderManager::getOrderDetails($orderId) : null;
            echo json_encode([
                'success' => $ok, 
                'order_id' => $orderId, 
                'status' => $status, 
                'order' => $updatedOrder,
                'message' => $ok ? 'Order status updated in live database.' : 'Failed to update order status.'
            ]);
            exit;
        }

        // Delete Order (Single)
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

        // Bulk Delete Orders (Multi-Select)
        if ($action === 'bulk_delete') {
            dt_api_require_admin('bulk delete orders');

            $orderIds = $data['order_ids'] ?? ($data['ids'] ?? []);
            if (!is_array($orderIds) || empty($orderIds)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Valid array of order IDs required for bulk deletion.']);
                exit;
            }
            $result = OrderManager::bulkDeleteOrders($orderIds);
            echo json_encode([
                'success' => $result['success'],
                'deleted_count' => $result['deleted_count'],
                'deleted_ids' => $result['deleted_ids'],
                'message' => $result['success']
                    ? "Successfully permanently deleted {$result['deleted_count']} order(s) from database."
                    : 'Failed to delete some or all selected orders.'
            ]);
            exit;
        }

        // Bulk Update Status (Multi-Select)
        if ($action === 'bulk_update_status') {
            dt_api_require_admin('bulk update order status');

            $orderIds = $data['order_ids'] ?? ($data['ids'] ?? []);
            $status = trim($data['status'] ?? 'processing');

            if (!is_array($orderIds) || empty($orderIds)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Valid array of order IDs required for bulk update.']);
                exit;
            }

            $result = OrderManager::bulkUpdateStatus($orderIds, $status);
            echo json_encode([
                'success' => $result['success'],
                'updated_count' => $result['updated_count'],
                'updated_ids' => $result['updated_ids'],
                'status' => $status,
                'message' => "Successfully updated {$result['updated_count']} order(s) to " . strtoupper(str_replace('_', ' ', $status)) . " in live database."
            ]);
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

        // Check if full checkout payload with shipping address is submitted
        $isFullCheckout = !empty($data['customer_phone']) && (!empty($data['shipping_address']) || !empty($data['address']));
        if ($isFullCheckout && !dt_api_is_admin()) {
            $idempotencyKey = trim((string)($data['idempotency_key'] ?? ''));
            if (empty($idempotencyKey)) {
                $hdrKey = $_SERVER['HTTP_IDEMPOTENCY_KEY'] ?? ($_SERVER['HTTP_X_IDEMPOTENCY_KEY'] ?? '');
                $idempotencyKey = trim((string)$hdrKey);
            }

            $checkoutRes = CheckoutManager::processCheckout($data, $idempotencyKey ?: null);
            if (!empty($checkoutRes['success'])) {
                echo json_encode([
                    'success' => true,
                    'order'   => [
                        'id'             => $checkoutRes['order_id'],
                        'order_number'   => $checkoutRes['order_number'],
                        'customer_name'  => $checkoutRes['customer_name'],
                        'customer_phone' => $checkoutRes['customer_phone'],
                        'total_amount'   => $checkoutRes['grand_total'],
                        'payment_method' => $checkoutRes['payment_method'],
                        'payment_status' => $checkoutRes['payment_status'],
                        'pricing'        => $checkoutRes['pricing'],
                        'reused'         => $checkoutRes['reused_session']
                    ],
                    'checkout' => $checkoutRes,
                    'message'  => $checkoutRes['message']
                ], JSON_PRETTY_PRINT);
            } else {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'step'    => $checkoutRes['step'] ?? null,
                    'message' => $checkoutRes['error'] ?? 'Checkout validation failed.',
                    'errors'  => $checkoutRes['errors'] ?? [$checkoutRes['error'] ?? 'Validation error']
                ], JSON_PRETTY_PRINT);
            }
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
