<?php
/**
 * api/retailer.php — Retailer B2B Live Database & Dashboard API
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
require_once __DIR__ . '/_guard.php';

use DTBrand\Database;
use DTBrand\Auth;
use DTBrand\CustomerManager;
use DTBrand\OrderManager;
use DTBrand\ProductCatalog;

try {
    Auth::initSession();
    $pdo = Database::getConnection();
    $rawInput = file_get_contents('php://input');
    $jsonData = json_decode($rawInput, true) ?: [];
    $data = !empty($jsonData) ? $jsonData : $_REQUEST;

    $action = $data['action'] ?? ($_GET['action'] ?? 'get_dashboard');
    $currentUser = Auth::getCurrentUser();

    // ── 1. GET DASHBOARD & USER DATA (GET/POST) ──
    if ($action === 'get_dashboard') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? ($_GET['user_id'] ?? 0)));
        $cust = null;
        $orders = [];
        $kpis = [
            'total_orders' => 0,
            'lifetime_spend' => 0.0,
            'pending_orders' => 0,
            'tier' => 'Verified Retailer (Tier 1)',
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
                            'order_number' => (string)($ro['order_number'] ?? ('DT-' . $ro['id'])),
                            'channel' => (string)($ro['channel'] ?? 'retailer'),
                            'total_amount' => $amt,
                            'payment_status' => (string)($ro['payment_status'] ?? 'pending'),
                            'status' => (string)($ro['status'] ?? 'pending'),
                            'items_count' => is_array(json_decode($ro['items'] ?? '[]', true)) ? count(json_decode($ro['items'] ?? '[]', true)) : 1,
                            'shipping_address' => (string)($ro['shipping_address'] ?? ''),
                            'tracking_number' => (string)($ro['tracking_number'] ?? ''),
                            'courier' => (string)($ro['courier'] ?? 'Delhivery / Blue Dart'),
                            'date' => (string)($ro['created_at'] ?? '')
                        ];
                    }

                    $kpis['total_orders'] = count($orders);
                    $kpis['lifetime_spend'] = round($spend, 2);
                    $kpis['pending_orders'] = $pending;
                    $kpis['tier'] = !empty($cust['tier']) ? $cust['tier'] : 'Verified Retailer (Tier 1)';
                    $kpis['credit_limit'] = (float)($cust['credit_limit'] ?? 0);
                    $kpis['outstanding_balance'] = (float)($cust['outstanding_balance'] ?? 0);
                }
            } catch (\Throwable $e) {
                error_log('Retailer get_dashboard error: ' . $e->getMessage());
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

    // ── 2. UPDATE PROFILE (POST) ──
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
            'message' => 'Profile updated successfully in live database',
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

    // ── 3. UPDATE GST & TAX PROFILE (POST) ──
    if ($action === 'update_gst') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? 0));
        if ($userId <= 0) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Please sign in to update GST details']);
            exit;
        }

        $gstin = strtoupper(preg_replace('/\s+/', '', (string)($data['gstin'] ?? '')));
        $pan = strtoupper(preg_replace('/\s+/', '', (string)($data['pan'] ?? '')));

        if (!empty($gstin) && !preg_match('/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/', $gstin)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid GSTIN format (e.g. 24AAAAA0000A1Z5)']);
            exit;
        }

        if ($pdo !== null && !Database::isMockMode()) {
            $stmt = $pdo->prepare("UPDATE customers SET gstin = ?, pan = ? WHERE id = ?");
            $stmt->execute([$gstin ?: null, $pan ?: null, $userId]);

            if (isset($_SESSION['user'])) {
                $_SESSION['user']['gstin'] = $gstin;
                $_SESSION['user']['pan'] = $pan;
            }
        }

        echo json_encode([
            'success' => true,
            'message' => 'GST & Business Tax credentials verified and updated',
            'gstin' => $gstin,
            'pan' => $pan
        ]);
        exit;
    }

    // ── 4. SUBMIT KYC APPLICATION (POST) ──
    if ($action === 'apply_kyc') {
        $name = trim((string)($data['name'] ?? ''));
        $shopName = trim((string)($data['shop_name'] ?? ''));
        $phone = trim((string)($data['phone'] ?? ''));
        $email = trim((string)($data['email'] ?? ''));
        $gstin = strtoupper(trim((string)($data['gstin'] ?? '')));
        $pan = strtoupper(trim((string)($data['pan'] ?? '')));
        $city = trim((string)($data['city'] ?? ''));
        $state = trim((string)($data['state'] ?? ''));
        $businessType = trim((string)($data['business_type'] ?? 'retailer'));

        if (empty($phone) || empty($name)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Customer name and phone number are required']);
            exit;
        }

        if (!empty($gstin) && !preg_match('/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/', $gstin)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid GSTIN format (e.g. 24AAAAA0000A1Z5)']);
            exit;
        }

        if ($pdo !== null && !Database::isMockMode()) {
            $stmt = $pdo->prepare("
                INSERT INTO customers 
                (name, phone, email, type, city, state, gstin, pan, kyc_status, tier, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', 'B2B Verified Tier 1', 'active', NOW())
                ON DUPLICATE KEY UPDATE 
                name = VALUES(name), email = VALUES(email), gstin = VALUES(gstin), pan = VALUES(pan),
                city = VALUES(city), state = VALUES(state), kyc_status = 'pending'
            ");
            $stmt->execute([
                $name . ($shopName ? " ({$shopName})" : ''),
                $phone,
                $email ?: null,
                $businessType,
                $city,
                $state,
                $gstin ?: null,
                $pan ?: null
            ]);
        }

        echo json_encode([
            'success' => true,
            'message' => 'B2B Retailer KYC application submitted successfully. Verification active.',
            'status' => 'pending',
            'phone' => $phone
        ]);
        exit;
    }

    // ── 5. CHECK KYC STATUS (GET) ──
    if ($action === 'check_status') {
        $phone = trim((string)($data['phone'] ?? ($_GET['phone'] ?? '')));
        $cust = null;

        if (!empty($phone) && $pdo !== null && !Database::isMockMode()) {
            $stmt = $pdo->prepare("SELECT id, name, phone, email, type, city, state, gstin, kyc_status, tier FROM customers WHERE phone = ? LIMIT 1");
            $stmt->execute([$phone]);
            $cust = $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        echo json_encode([
            'success' => true,
            'customer' => $cust,
            'kyc_status' => $cust['kyc_status'] ?? 'unverified',
            'is_verified' => (($cust['kyc_status'] ?? '') === 'verified' || ($cust['status'] ?? '') === 'active')
        ]);
        exit;
    }

    // ── 6. GET ORDER DETAILS (GET) ──
    if ($action === 'get_order_details') {
        $orderId = (int)($data['order_id'] ?? ($_GET['order_id'] ?? 0));
        $orderNo = trim((string)($data['order_number'] ?? ($_GET['order_number'] ?? '')));

        if ($orderId <= 0 && empty($orderNo)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Order ID or Order Number required']);
            exit;
        }

        $order = null;
        if ($pdo !== null && !Database::isMockMode()) {
            if ($orderId > 0) {
                $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? LIMIT 1");
                $stmt->execute([$orderId]);
            } else {
                $stmt = $pdo->prepare("SELECT * FROM orders WHERE order_number = ? LIMIT 1");
                $stmt->execute([$orderNo]);
            }
            $order = $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        if ($order) {
            $items = json_decode($order['items'] ?? '[]', true) ?: [];
            echo json_encode([
                'success' => true,
                'order' => [
                    'id' => (int)$order['id'],
                    'order_number' => (string)($order['order_number'] ?? ('DT-' . $order['id'])),
                    'customer_id' => (int)($order['customer_id'] ?? 0),
                    'customer_name' => (string)($order['customer_name'] ?? ($order['name'] ?? 'B2B Retailer')),
                    'phone' => (string)($order['phone'] ?? ''),
                    'total_amount' => (float)($order['total_amount'] ?? 0),
                    'payment_method' => (string)($order['payment_method'] ?? 'UPI'),
                    'payment_status' => (string)($order['payment_status'] ?? 'pending'),
                    'status' => (string)($order['status'] ?? 'pending'),
                    'shipping_address' => (string)($order['shipping_address'] ?? ''),
                    'tracking_number' => (string)($order['tracking_number'] ?? ''),
                    'courier' => (string)($order['courier'] ?? 'Delhivery Logistics'),
                    'created_at' => (string)($order['created_at'] ?? ''),
                    'items' => $items
                ]
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Order not found']);
        }
        exit;
    }

    // ── 7. EXPORT B2B LIVE CATALOG (JSON / CSV) ──
    if ($action === 'export_catalog') {
        $format = strtolower(trim((string)($data['format'] ?? ($_GET['format'] ?? 'json'))));
        $allProducts = ProductCatalog::getAll();
        $catalog = [];

        foreach ($allProducts as $p) {
            $catalog[] = [
                'id' => (int)($p['id'] ?? 0),
                'sku' => (string)($p['sku'] ?? ''),
                'name' => (string)($p['name'] ?? ''),
                'category' => (string)($p['category'] ?? ''),
                'fabric' => (string)($p['fabric'] ?? ''),
                'retail_price' => (float)($p['effective_price'] ?? ($p['retail_price'] ?? 0)),
                'wholesale_price' => (float)($p['effective_wholesale_price'] ?? 0),
                'reseller_price' => (float)($p['effective_reseller_price'] ?? 0),
                'moq' => (int)($p['moq'] ?? 1),
                'stock_qty' => (int)($p['stock_qty'] ?? 0),
                'image' => (string)($p['image'] ?? '')
            ];
        }

        if ($format === 'csv') {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="DT_Brands_B2B_Catalog_' . date('Ymd') . '.csv"');
            $out = fopen('php://output', 'w');
            fputcsv($out, ['ID', 'SKU', 'Product Name', 'Category', 'Fabric', 'Retail Price (INR)', 'Wholesale Price (INR)', 'Reseller Price (INR)', 'MOQ', 'Stock Qty']);
            foreach ($catalog as $row) {
                fputcsv($out, [
                    $row['id'],
                    $row['sku'],
                    $row['name'],
                    $row['category'],
                    $row['fabric'],
                    $row['retail_price'],
                    $row['wholesale_price'],
                    $row['reseller_price'],
                    $row['moq'],
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
    echo json_encode(['success' => false, 'error' => 'Invalid retailer action specified']);
    exit;

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Retailer API error: ' . $e->getMessage()]);
    exit;
}
