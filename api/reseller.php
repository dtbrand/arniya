<?php
/**
 * api/reseller.php — Reseller Margin Sharing, CRM Customer Management & Database API
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
            'message' => 'Reseller partner profile updated successfully in live database',
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

    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid reseller action specified']);
    exit;

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Reseller API error: ' . $e->getMessage()]);
    exit;
}
