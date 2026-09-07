<?php
/**
 * api/reseller.php — Reseller Margin Sharing, CRM Customer Management & Database API
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

    // ── 1. GET RESELLER DASHBOARD & REAL DATABASE ORDERS (GET/POST) ──
    if ($action === 'get_dashboard') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? ($_GET['user_id'] ?? 0)));
        $cust = null;
        $orders = [];
        $crmContacts = [];
        $kpis = [
            'total_orders' => 0,
            'lifetime_spend' => 0.0,
            'total_earnings' => 0.0,
            'pending_orders' => 0,
            'tier' => 'Verified Reseller Partner',
            'commission_rate' => 15.0
        ];

        if ($userId > 0 && $pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("SELECT id, name, phone, email, type, city, state, tier, gstin, pan, commission_rate, kyc_status, created_at FROM customers WHERE id = ? LIMIT 1");
                $stmt->execute([$userId]);
                $cust = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($cust) {
                    // Fetch real orders
                    $orderStmt = $pdo->prepare("SELECT id, order_number, channel, total_amount, payment_status, status, items, shipping_address, created_at, tracking_number, courier FROM orders WHERE customer_id = ? OR phone = ? ORDER BY id DESC LIMIT 50");
                    $orderStmt->execute([$userId, $cust['phone'] ?? '']);
                    $rawOrders = $orderStmt->fetchAll(\PDO::FETCH_ASSOC);

                    $spend = 0.0;
                    $pending = 0;
                    $commRate = (float)($cust['commission_rate'] ?? 15.0);
                    if ($commRate <= 0) $commRate = 15.0;

                    foreach ($rawOrders as $ro) {
                        $amt = (float)($ro['total_amount'] ?? 0);
                        $spend += $amt;
                        $st = strtolower((string)($ro['status'] ?? ''));
                        if (in_array($st, ['pending', 'processing', 'in_transit', 'dispatched'], true)) {
                            $pending++;
                        }
                        $orders[] = [
                            'id' => (int)$ro['id'],
                            'order_number' => (string)($ro['order_number'] ?? ('DT-RS-' . $ro['id'])),
                            'channel' => (string)($ro['channel'] ?? 'reseller'),
                            'total_amount' => $amt,
                            'estimated_margin' => round($amt * ($commRate / 100), 2),
                            'payment_status' => (string)($ro['payment_status'] ?? 'pending'),
                            'status' => (string)($ro['status'] ?? 'pending'),
                            'items_count' => is_array(json_decode($ro['items'] ?? '[]', true)) ? count(json_decode($ro['items'] ?? '[]', true)) : 1,
                            'shipping_address' => (string)($ro['shipping_address'] ?? ''),
                            'tracking_number' => (string)($ro['tracking_number'] ?? ''),
                            'courier' => (string)($ro['courier'] ?? 'Delhivery Surface'),
                            'date' => (string)($ro['created_at'] ?? '')
                        ];
                    }

                    $kpis['total_orders'] = count($orders);
                    $kpis['lifetime_spend'] = round($spend, 2);
                    $kpis['total_earnings'] = round($spend * ($commRate / 100), 2);
                    $kpis['pending_orders'] = $pending;
                    $kpis['tier'] = !empty($cust['tier']) ? $cust['tier'] : 'Verified Reseller Partner';
                    $kpis['commission_rate'] = $commRate;
                }
            } catch (\Throwable $e) {
                error_log('Reseller get_dashboard error: ' . $e->getMessage());
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

    // ── 2. CALCULATE MARGIN & GENERATE SMART SHARE LINK (GET/POST) ──
    if ($action === 'calculate' || $action === 'calculate_margin') {
        $productId = (int)($data['product_id'] ?? ($_GET['product_id'] ?? 0));
        $marginPercent = max(5, min(50, (float)($data['margin_percent'] ?? ($_GET['margin_percent'] ?? 15.0))));

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

        $resellerBase = (float)($product['effective_reseller_price'] ?? ($product['reseller_price'] ?? 0));
        if ($resellerBase <= 0) {
            $resellerBase = (float)($product['retail_price'] ?? 0);
        }

        $marginAmount = round($resellerBase * ($marginPercent / 100), 2);
        $finalSellingPrice = $resellerBase + $marginAmount;
        $userName = $currentUser['name'] ?? 'Reseller Partner';

        echo json_encode([
            'success' => true,
            'product' => [
                'id' => $product['id'],
                'name' => $product['name'] ?? ($product['title'] ?? ''),
                'reseller_base_price' => $resellerBase,
                'margin_percent' => $marginPercent,
                'reseller_profit' => $marginAmount,
                'final_customer_price' => $finalSellingPrice,
                'smart_share_url' => "https://jaihanumantex.in/product.php?id={$product['id']}&ref=reseller_" . ($currentUser['id'] ?? 'vip'),
                'whatsapp_share_text' => "🌟 *Exclusive Pure Silk Handloom Collection* 🌟\n\n🛍️ *Product:* " . ($product['name'] ?? 'Silk Saree') . "\n✨ *Fabric:* " . ($product['fabric'] ?? 'Pure Silk') . "\n💰 *Special Boutique Price:* ₹" . number_format($finalSellingPrice) . " / pc (Free Delivery)\n\n📦 *Order Directly via WhatsApp:*\nhttps://wa.me/917046363528?text=" . urlencode("Hello, I want to order " . ($product['name'] ?? 'product') . " at Rs " . $finalSellingPrice . " via Reseller Partner.") . "\n\n— {$userName} (DT Brand's Verified Partner)"
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
            'message' => 'Reseller partner profile updated successfully in live database',
            'user' => $freshUser
        ]);
        exit;
    }

    // ── 3B. UPDATE GST & TAX PROFILE (POST) ──
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

    // ── 3C. SAVE ADDRESS BOOK (POST) ──
    if ($action === 'save_address') {
        $userId = (int)($currentUser['id'] ?? ($data['user_id'] ?? 0));

        // If not authenticated in session, resolve via phone number
        if ($userId <= 0 && !empty($data['phone'])) {
            $foundCust = CustomerManager::getByPhone((string)$data['phone']);
            if ($foundCust && !empty($foundCust['id'])) {
                $userId = (int)$foundCust['id'];
                $_SESSION['user'] = $foundCust;
                $_SESSION['user_type'] = $foundCust['type'] ?? 'reseller';
            }
        }

        // If still 0, resolve to default reseller customer
        if ($userId <= 0 && $pdo !== null) {
            $cCheck = $pdo->query("SELECT id FROM customers WHERE type = 'reseller' ORDER BY id ASC LIMIT 1");
            $defaultReseller = $cCheck ? $cCheck->fetch(\PDO::FETCH_ASSOC) : null;
            if ($defaultReseller && !empty($defaultReseller['id'])) {
                $userId = (int)$defaultReseller['id'];
            }
        }

        // If still 0, auto-create reseller record
        if ($userId <= 0) {
            $createRes = CustomerManager::create([
                'name' => !empty($data['company_name']) ? $data['company_name'] : 'Reseller Partner',
                'phone' => !empty($data['phone']) ? $data['phone'] : '917046363528',
                'type' => 'reseller',
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

    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid reseller action specified']);
    exit;

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Reseller API error: ' . $e->getMessage()]);
    exit;
}
