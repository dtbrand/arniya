<?php
/**
 * api/wholesale.php — Wholesale Bulk Lot Volume, Dashboard & Database API
 * DT Brand's & Jai Hanuman Tex — Live Production Standard
 */

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../src/CustomerManager.php';
require_once __DIR__ . '/../src/OrderManager.php';
require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/../src/PricingCalculator.php';

use DTBrand\Database;
use DTBrand\Auth;
use DTBrand\CustomerManager;
use DTBrand\OrderManager;
use DTBrand\ProductCatalog;
use DTBrand\PricingCalculator;

try {
    Auth::initSession();
    $pdo = Database::getConnection();
    $rawInput = file_get_contents('php://input');
    $jsonData = json_decode($rawInput, true) ?: [];
    $data = !empty($jsonData) ? $jsonData : $_REQUEST;

    $action = $data['action'] ?? ($_GET['action'] ?? 'get_dashboard');
    $currentUser = Auth::getCurrentUser();

    // ── 1. GET WHOLESALER DASHBOARD & REAL DATABASE ORDERS (GET/POST) ──
    if ($action === 'get_dashboard') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? ($_GET['user_id'] ?? 0)));
        $cust = null;
        $orders = [];
        $kpis = [
            'total_orders' => 0,
            'lifetime_spend' => 0.0,
            'pending_orders' => 0,
            'tier' => 'Wholesale Gold Partner',
            'credit_limit' => 0.0,
            'outstanding_balance' => 0.0
        ];

        if ($userId > 0 && $pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("SELECT id, name, phone, email, type, city, state, tier, gstin, pan, credit_limit, outstanding_balance, kyc_status, created_at FROM customers WHERE id = ? LIMIT 1");
                $stmt->execute([$userId]);
                $cust = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($cust) {
                    $orderStmt = $pdo->prepare("SELECT id, order_number, channel, total_amount, payment_status, status, items, shipping_address, created_at, tracking_number, courier FROM orders WHERE customer_id = ? OR phone = ? ORDER BY id DESC LIMIT 50");
                    $orderStmt->execute([$userId, $cust['phone'] ?? '']);
                    $rawOrders = $orderStmt->fetchAll(\PDO::FETCH_ASSOC);

                    $spend = 0.0;
                    $pending = 0;
                    foreach ($rawOrders as $ro) {
                        $amt = (float)($ro['total_amount'] ?? 0);
                        $spend += $amt;
                        $st = strtolower((string)($ro['status'] ?? ''));
                        if (in_array($st, ['pending', 'processing', 'in_transit', 'dispatched'], true)) {
                            $pending++;
                        }
                        $orders[] = [
                            'id' => (int)$ro['id'],
                            'order_number' => (string)($ro['order_number'] ?? ('DT-WS-' . $ro['id'])),
                            'channel' => (string)($ro['channel'] ?? 'wholesale'),
                            'total_amount' => $amt,
                            'payment_status' => (string)($ro['payment_status'] ?? 'pending'),
                            'status' => (string)($ro['status'] ?? 'pending'),
                            'items_count' => is_array(json_decode($ro['items'] ?? '[]', true)) ? count(json_decode($ro['items'] ?? '[]', true)) : 1,
                            'shipping_address' => (string)($ro['shipping_address'] ?? ''),
                            'tracking_number' => (string)($ro['tracking_number'] ?? ''),
                            'courier' => (string)($ro['courier'] ?? 'VRL / TCI Freight Logistics'),
                            'date' => (string)($ro['created_at'] ?? '')
                        ];
                    }

                    $kpis['total_orders'] = count($orders);
                    $kpis['lifetime_spend'] = round($spend, 2);
                    $kpis['pending_orders'] = $pending;
                    $kpis['tier'] = !empty($cust['tier']) ? $cust['tier'] : 'Wholesale Gold Partner';
                    $kpis['credit_limit'] = (float)($cust['credit_limit'] ?? 0);
                    $kpis['outstanding_balance'] = (float)($cust['outstanding_balance'] ?? 0);
                }
            } catch (\Throwable $e) {
                error_log('Wholesale get_dashboard error: ' . $e->getMessage());
            }
        }

        echo json_encode([
            'success' => true,
            'is_logged_in' => ($cust !== null),
            'user' => $cust,
            'kpis' => $kpis,
            'orders' => $orders
        ]);
        exit;
    }

    // ── 2. CALCULATE BULK LOT VOLUME (GET/POST) ──
    if ($action === 'calculate_lot') {
        $productId = (int)($data['product_id'] ?? ($_GET['product_id'] ?? 0));
        $lotType = $data['lot_type'] ?? ($_GET['lot_type'] ?? 'half_set');

        if ($productId <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Product ID is required']);
            exit;
        }

        $product = ProductCatalog::getById($productId);
        if (!$product) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Product not found']);
            exit;
        }

        $lotKeys = ['single' => 'single', 'half_set' => 'half_set', 'full_set' => 'full_set', 'master_bale' => 'master_bale'];
        if (!isset($lotKeys[$lotType])) {
            $lotType = 'half_set';
        }
        $qty = (int)($product['moq_lots'][$lotType] ?? 0);
        if ($qty <= 0) {
            echo json_encode([
                'success' => false,
                'lot_type' => $lotType,
                'message' => 'No lot size recorded for this product MOQ.'
            ]);
            exit;
        }

        $unitWholesalePrice = (float)($product['wholesale_price'] ?? ($product['effective_wholesale_price'] ?? 0));
        if ($unitWholesalePrice <= 0) {
            echo json_encode([
                'success' => false,
                'lot_type' => $lotType,
                'pieces' => $qty,
                'message' => 'This product has no wholesale rate set yet.'
            ]);
            exit;
        }

        $mrp = (float)($product['mrp'] ?? ($product['retail_price'] ?? 0));
        $subtotal = $unitWholesalePrice * $qty;
        $orderCalc = PricingCalculator::calculateOrderTotal($subtotal, 0.0, 0.0, 5.0);

        echo json_encode([
            'success' => true,
            'lot_type' => $lotType,
            'pieces' => $qty,
            'product' => [
                'id' => $product['id'],
                'name' => $product['name'] ?? ($product['title'] ?? ''),
                'mrp' => $mrp,
                'lot_discount_percent' => $mrp > 0 ? round((($mrp - $unitWholesalePrice) / $mrp) * 100, 2) : 0,
                'unit_wholesale_price' => $unitWholesalePrice,
                'lot_subtotal' => $orderCalc['subtotal'],
                'gst_amount' => $orderCalc['gst'],
                'lot_grand_total' => $orderCalc['grand_total']
            ]
        ]);
        exit;
    }

    // ── 3. UPDATE PROFILE (POST) ──
    if ($action === 'update_profile') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? 0));
        if ($userId <= 0) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Please sign in to update profile']);
            exit;
        }

        $name = trim((string)($data['name'] ?? ''));
        $email = trim((string)($data['email'] ?? ''));
        $city = trim((string)($data['city'] ?? ''));
        $state = trim((string)($data['state'] ?? ''));

        if (empty($name)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Full Name is required']);
            exit;
        }

        if ($pdo !== null && !Database::isMockMode()) {
            $stmt = $pdo->prepare("UPDATE customers SET name = ?, email = COALESCE(NULLIF(?, ''), email), city = ?, state = ? WHERE id = ?");
            $stmt->execute([$name, $email, $city, $state, $userId]);

            if (isset($_SESSION['user'])) {
                $_SESSION['user']['name'] = $name;
                $_SESSION['user']['email'] = $email;
                $_SESSION['user']['city'] = $city;
                $_SESSION['user']['state'] = $state;
            }
        }

        echo json_encode([
            'success' => true,
            'message' => 'Wholesaler profile updated successfully in live database',
            'user' => [
                'id' => $userId,
                'name' => $name,
                'email' => $email,
                'city' => $city,
                'state' => $state
            ]
        ]);
        exit;
    }

    // ── 4. EXPORT WHOLESALE B2B RATE SHEET (JSON / CSV) ──
    if ($action === 'export_catalog') {
        $format = strtolower(trim((string)($data['format'] ?? ($_GET['format'] ?? 'json'))));
        $allProducts = ProductCatalog::getAll();
        $catalog = [];

        foreach ($allProducts as $p) {
            $wsPrice = (float)($p['effective_wholesale_price'] ?? ($p['wholesale_price'] ?? 0));
            $catalog[] = [
                'id' => (int)($p['id'] ?? 0),
                'sku' => (string)($p['sku'] ?? ''),
                'name' => (string)($p['name'] ?? ''),
                'category' => (string)($p['category'] ?? ''),
                'fabric' => (string)($p['fabric'] ?? ''),
                'wholesale_price' => $wsPrice,
                'single_moq' => (int)($p['moq_lots']['single'] ?? 1),
                'half_set_moq' => (int)($p['moq_lots']['half_set'] ?? 4),
                'full_set_moq' => (int)($p['moq_lots']['full_set'] ?? 8),
                'master_bale_moq' => (int)($p['moq_lots']['master_bale'] ?? 24),
                'stock_qty' => (int)($p['stock_qty'] ?? 0),
                'image' => (string)($p['image'] ?? '')
            ];
        }

        if ($format === 'csv') {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="DT_Brands_Wholesale_Rate_Sheet_' . date('Ymd') . '.csv"');
            $out = fopen('php://output', 'w');
            fputcsv($out, ['ID', 'SKU', 'Product Name', 'Category', 'Fabric', 'Wholesale Rate (INR/pc)', 'Half Set MOQ', 'Full Set MOQ', 'Master Bale MOQ', 'Stock Qty']);
            foreach ($catalog as $row) {
                fputcsv($out, [
                    $row['id'],
                    $row['sku'],
                    $row['name'],
                    $row['category'],
                    $row['fabric'],
                    $row['wholesale_price'],
                    $row['half_set_moq'],
                    $row['full_set_moq'],
                    $row['master_bale_moq'],
                    $row['stock_qty']
                ]);
            }
            fclose($out);
            exit;
        }

        echo json_encode([
            'success' => true,
            'generated_at' => date('Y-m-d H:i:s'),
            'total_products' => count($catalog),
            'catalog' => $catalog
        ]);
        exit;
    }

    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid wholesale action specified']);
    exit;

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Wholesale API error: ' . $e->getMessage()]);
    exit;
}
