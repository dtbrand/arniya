<?php
/**
 * api/wholesale.php — Wholesale Bulk Lot Volume, Dashboard & Database API
 * DT Brand's & Jai Hanuman Tex — Live Production Standard
 */

require_once __DIR__ . '/cors.php';
cors_json();

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

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
                    $orders = OrderManager::getByCustomerOrPhone($userId, $cust['phone'] ?? '');

                    $spend = 0.0;
                    $pending = 0;
                    foreach ($orders as $ro) {
                        $amt = (float)($ro['total_amount'] ?? 0);
                        $spend += $amt;
                        $st = strtolower((string)($ro['status'] ?? ''));
                        if (in_array($st, ['pending', 'processing', 'unfulfilled', 'in_transit', 'dispatched', 'shipped'], true)) {
                            $pending++;
                        }
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

    // ── 1B. GET WHOLESALER ORDERS (GET/POST) ──
    if ($action === 'get_orders') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? ($_GET['user_id'] ?? 0)));
        $userPhone = (string)($currentUser['phone'] ?? ($data['phone'] ?? ($_GET['phone'] ?? '')));
        $orders = OrderManager::getByCustomerOrPhone($userId, $userPhone);
        echo json_encode([
            'success' => true,
            'count' => count($orders),
            'orders' => $orders
        ]);
        exit;
    }

    // ── 1C. GET SINGLE ORDER DETAILS WITH LINE ITEMS & TIMELINE (GET/POST) ──
    if ($action === 'get_order_details' || $action === 'track_order') {
        $orderId = trim($data['order_id'] ?? ($data['id'] ?? ($_GET['id'] ?? ($_GET['order_id'] ?? ($_GET['order_number'] ?? '')))));
        if (empty($orderId)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Order ID or order number is required']);
            exit;
        }

        $order = OrderManager::getOrderDetails($orderId);
        if (!$order) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Order not found']);
            exit;
        }

        echo json_encode([
            'success' => true,
            'order' => $order
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

    // ── 3. UPDATE PROFILE & PASSWORD (POST) ──
    if ($action === 'update_profile') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? 0));
        if ($userId <= 0) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Please sign in to update profile']);
            exit;
        }

        $name = trim((string)($data['name'] ?? ($data['company_name'] ?? '')));
        $phone = trim((string)($data['phone'] ?? ''));
        $email = trim((string)($data['email'] ?? ''));
        $city = trim((string)($data['city'] ?? ''));
        $state = trim((string)($data['state'] ?? ''));
        $gstin = strtoupper(trim((string)($data['gstin'] ?? '')));
        $pan = strtoupper(trim((string)($data['pan'] ?? '')));

        // If this request is only changing GST details
        if (empty($name) && (!empty($gstin) || isset($data['company_name']))) {
            $name = trim((string)($data['company_name'] ?? ($currentUser['name'] ?? '')));
        }

        if (empty($name)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Full Name / Enterprise Name is required']);
            exit;
        }

        $res = Auth::updateProfile($userId, [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'city' => $city,
            'state' => $state,
            'gstin' => $gstin,
            'pan' => $pan
        ]);

        if (!$res['success']) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => $res['message']]);
            exit;
        }

        // Handle Password Change if requested
        $newPass = trim((string)($data['new_password'] ?? ''));
        $curPass = trim((string)($data['current_password'] ?? ''));
        if (!empty($newPass)) {
            $pRes = Auth::changePassword($userId, $curPass, $newPass);
            if (!$pRes['success']) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => $pRes['message']]);
                exit;
            }
        }

        $freshUser = CustomerManager::getById($userId);

        echo json_encode([
            'success' => true,
            'message' => 'Wholesaler profile updated successfully in live database',
            'user' => $freshUser
        ]);
        exit;
    }

    // ── 3B. UPDATE GST & TAX CONFIGURATION (POST) ──
    if ($action === 'update_gst' || $action === 'save_tax_profile') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? 0));
        if ($userId <= 0) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Please sign in to update tax profile']);
            exit;
        }

        $compName = trim((string)($data['company_name'] ?? ($data['name'] ?? '')));
        $gstin = strtoupper(preg_replace('/\s+/', '', (string)($data['gstin'] ?? ($data['gst_number'] ?? ''))));
        $pan = strtoupper(preg_replace('/\s+/', '', (string)($data['pan'] ?? '')));

        if (!empty($gstin) && !preg_match('/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/', $gstin)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid 15-character GSTIN format (e.g. 24AAAAA0000A1Z5)']);
            exit;
        }

        $updateData = ['gstin' => $gstin, 'pan' => $pan];
        if (!empty($compName)) {
            $updateData['name'] = $compName;
        }

        $res = Auth::updateProfile($userId, $updateData);
        if (!$res['success']) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => $res['message']]);
            exit;
        }

        $freshUser = CustomerManager::getById($userId);

        echo json_encode([
            'success' => true,
            'message' => 'GST & Business Tax Configuration updated in live database!',
            'gstin' => $gstin,
            'pan' => $pan,
            'company_name' => $compName,
            'user' => $freshUser
        ]);
        exit;
    }

    // ── 3C. SAVE ADDRESS BOOK (BILLING & DISPATCH) (POST) ──
    if ($action === 'save_address') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? 0));
        
        // If not authenticated in session, resolve via phone number
        if ($userId <= 0 && !empty($data['phone'])) {
            $foundCust = CustomerManager::getByPhone((string)$data['phone']);
            if ($foundCust && !empty($foundCust['id'])) {
                $userId = (int)$foundCust['id'];
                $_SESSION['user'] = $foundCust;
                $_SESSION['user_type'] = $foundCust['type'] ?? 'wholesale';
            }
        }

        // If still 0, resolve to the default wholesale customer
        if ($userId <= 0 && $pdo !== null) {
            $cCheck = $pdo->query("SELECT id FROM customers WHERE type = 'wholesale' ORDER BY id ASC LIMIT 1");
            $defaultWholesaler = $cCheck ? $cCheck->fetch(\PDO::FETCH_ASSOC) : null;
            if ($defaultWholesaler && !empty($defaultWholesaler['id'])) {
                $userId = (int)$defaultWholesaler['id'];
            }
        }

        // If still 0, auto-register customer so data is never dropped
        if ($userId <= 0) {
            $createRes = CustomerManager::create([
                'name' => !empty($data['company_name']) ? $data['company_name'] : 'Wholesale Partner',
                'phone' => !empty($data['phone']) ? $data['phone'] : '917046363528',
                'type' => 'wholesale',
                'city' => !empty($data['city']) ? $data['city'] : 'Surat',
                'state' => !empty($data['state']) ? $data['state'] : 'Gujarat',
                'gstin' => !empty($data['gstin']) ? $data['gstin'] : ''
            ]);
            if (!empty($createRes['id'])) {
                $userId = (int)$createRes['id'];
            }
        }

        if ($userId <= 0) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Please sign in to save address']);
            exit;
        }

        $res = Auth::saveAddress($userId, $data);
        if (!$res['success']) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => $res['message']]);
            exit;
        }

        $freshUser = CustomerManager::getById($userId);
        $addresses = Auth::getCustomerAddresses($userId);

        echo json_encode([
            'success' => true,
            'message' => 'Address book updated successfully in live database!',
            'address' => $res['address'] ?? null,
            'addresses' => $addresses,
            'user' => $freshUser
        ]);
        exit;
    }

    // ── 3C-1. SET DEFAULT SHIPPING DESTINATION (POST) ──
    if ($action === 'set_default_shipping') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? 0));
        $addressId = (int)($data['id'] ?? ($data['address_id'] ?? 0));
        if ($userId <= 0 || $addressId <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Valid user and address ID required']);
            exit;
        }
        if ($pdo !== null) {
            $pdo->prepare("UPDATE addresses SET is_default = 0 WHERE customer_id = ? AND address_type != 'billing'")->execute([$userId]);
            $pdo->prepare("UPDATE addresses SET is_default = 1 WHERE id = ? AND customer_id = ?")->execute([$addressId, $userId]);
        }
        $addresses = Auth::getCustomerAddresses($userId);
        echo json_encode(['success' => true, 'message' => 'Default shipping address updated successfully!', 'addresses' => $addresses]);
        exit;
    }

    // ── 3C-2. DELETE ADDRESS (POST) ──
    if ($action === 'delete_address') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? 0));
        $addressId = (int)($data['id'] ?? ($data['address_id'] ?? 0));
        if ($userId <= 0 || $addressId <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Valid user and address ID required']);
            exit;
        }
        if ($pdo !== null) {
            $pdo->prepare("DELETE FROM addresses WHERE id = ? AND customer_id = ? AND address_type != 'billing'")->execute([$addressId, $userId]);
        }
        $addresses = Auth::getCustomerAddresses($userId);
        echo json_encode(['success' => true, 'message' => 'Address deleted successfully!', 'addresses' => $addresses]);
        exit;
    }

    // ── 3C-3. GET ADDRESSES (GET/POST) ──
    if ($action === 'get_addresses') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? 0));
        if ($userId <= 0) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Please sign in']);
            exit;
        }
        $addresses = Auth::getCustomerAddresses($userId);
        echo json_encode(['success' => true, 'addresses' => $addresses]);
        exit;
    }

    // ── 3D. GET FRESH PROFILE DATA (GET/POST) ──
    if ($action === 'get_profile') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? 0));
        if ($userId <= 0) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Please sign in']);
            exit;
        }

        $freshUser = CustomerManager::getById($userId);
        $addresses = Auth::getCustomerAddresses($userId);

        echo json_encode([
            'success' => true,
            'user' => $freshUser,
            'addresses' => $addresses
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
