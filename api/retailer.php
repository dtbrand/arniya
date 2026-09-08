<?php
/**
 * api/retailer.php — Retailer B2B Live Database & Dashboard API
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

        if ($userId <= 0 && $pdo !== null && !Database::isMockMode()) {
            $phoneInput = trim((string)($data['phone'] ?? ($_GET['phone'] ?? '')));
            if (!empty($phoneInput)) {
                $digits = preg_replace('/\D+/', '', $phoneInput);
                if (strlen($digits) >= 10) {
                    $pStmt = $pdo->prepare("SELECT id FROM customers WHERE phone LIKE ? AND type IN ('retailer', 'retail') LIMIT 1");
                    $pStmt->execute(['%' . substr($digits, -10)]);
                    $pRow = $pStmt->fetch(\PDO::FETCH_ASSOC);
                    if ($pRow && !empty($pRow['id'])) {
                        $userId = (int)$pRow['id'];
                    }
                }
            }
        }

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

    // ── 1B. GET RETAILER ORDERS (GET/POST) ──
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

    // ── 2. UPDATE PROFILE & PASSWORD (POST) ──
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
            'message' => 'Retailer profile updated successfully in live database',
            'user' => $freshUser
        ]);
        exit;
    }

    // ── 3. UPDATE GST & TAX PROFILE (POST) ──
    if ($action === 'update_gst' || $action === 'save_tax_profile') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? 0));
        if ($userId <= 0) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Please sign in to update GST details']);
            exit;
        }

        $compName = trim((string)($data['company_name'] ?? ($data['name'] ?? '')));
        $gstin = strtoupper(preg_replace('/\s+/', '', (string)($data['gstin'] ?? ($data['gst_number'] ?? ''))));
        $pan = strtoupper(preg_replace('/\s+/', '', (string)($data['pan'] ?? '')));

        if (!empty($gstin) && !preg_match('/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/', $gstin)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid GSTIN format (e.g. 24AAAAA0000A1Z5)']);
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
            'message' => 'GST & Business Tax credentials verified and updated',
            'gstin' => $gstin,
            'pan' => $pan,
            'company_name' => $compName,
            'user' => $freshUser
        ]);
        exit;
    }

    // ── 3B. SAVE ADDRESS BOOK (POST) ──
    if ($action === 'save_address') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? 0));

        // If not authenticated in session, resolve via phone number
        if ($userId <= 0 && !empty($data['phone'])) {
            $foundCust = CustomerManager::getByPhone((string)$data['phone']);
            if ($foundCust && !empty($foundCust['id'])) {
                $userId = (int)$foundCust['id'];
                $_SESSION['user'] = $foundCust;
                $_SESSION['user_type'] = $foundCust['type'] ?? 'retailer';
            }
        }

        // If still 0, resolve to default retailer customer
        if ($userId <= 0 && $pdo !== null) {
            $cCheck = $pdo->query("SELECT id FROM customers WHERE type IN ('retailer', 'retail') ORDER BY id ASC LIMIT 1");
            $defaultRetailer = $cCheck ? $cCheck->fetch(\PDO::FETCH_ASSOC) : null;
            if ($defaultRetailer && !empty($defaultRetailer['id'])) {
                $userId = (int)$defaultRetailer['id'];
            }
        }

        // If still 0, auto-create retailer record
        if ($userId <= 0) {
            $createRes = CustomerManager::create([
                'name' => !empty($data['company_name']) ? $data['company_name'] : 'Retailer Partner',
                'phone' => !empty($data['phone']) ? $data['phone'] : '917046363528',
                'type' => 'retailer',
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

    // ── 3B-1. SET DEFAULT SHIPPING DESTINATION (POST) ──
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

    // ── 3B-2. DELETE ADDRESS (POST) ──
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

    // ── 3B-3. GET ADDRESSES (GET/POST) ──
    if ($action === 'get_addresses') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? ($_GET['user_id'] ?? 0)));
        if ($userId <= 0 && $pdo !== null && !Database::isMockMode()) {
            $phoneInput = trim((string)($data['phone'] ?? ($_GET['phone'] ?? '')));
            if (!empty($phoneInput)) {
                $digits = preg_replace('/\D+/', '', $phoneInput);
                if (strlen($digits) >= 10) {
                    $pStmt = $pdo->prepare("SELECT id FROM customers WHERE phone LIKE ? AND type IN ('retailer', 'retail') LIMIT 1");
                    $pStmt->execute(['%' . substr($digits, -10)]);
                    $pRow = $pStmt->fetch(\PDO::FETCH_ASSOC);
                    if ($pRow && !empty($pRow['id'])) $userId = (int)$pRow['id'];
                }
            }
        }
        if ($userId <= 0) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Please sign in']);
            exit;
        }
        $addresses = Auth::getCustomerAddresses($userId);
        echo json_encode(['success' => true, 'addresses' => $addresses]);
        exit;
    }

    // ── 3C. GET FRESH PROFILE DATA (GET/POST) ──
    if ($action === 'get_profile') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? ($_GET['user_id'] ?? 0)));
        if ($userId <= 0 && $pdo !== null && !Database::isMockMode()) {
            $phoneInput = trim((string)($data['phone'] ?? ($_GET['phone'] ?? '')));
            if (!empty($phoneInput)) {
                $digits = preg_replace('/\D+/', '', $phoneInput);
                if (strlen($digits) >= 10) {
                    $pStmt = $pdo->prepare("SELECT id FROM customers WHERE phone LIKE ? AND type IN ('retailer', 'retail') LIMIT 1");
                    $pStmt->execute(['%' . substr($digits, -10)]);
                    $pRow = $pStmt->fetch(\PDO::FETCH_ASSOC);
                    if ($pRow && !empty($pRow['id'])) $userId = (int)$pRow['id'];
                }
            }
        }
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
