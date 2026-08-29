<?php
/**
 * api/payments.php — Unified Payment Gateway REST API (Razorpay, COD, Bank Transfer, Wallet)
 * DT Brand's & Jai Hanuman Tex
 */

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, X-CSRF-Token');
}

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Auth.php';

use DTBrand\Database;
use DTBrand\Auth;

$razorpayKeyId = getenv('RAZORPAY_KEY_ID') ?: 'rzp_live_dtbrand_hanuman';
$razorpayKeySecret = getenv('RAZORPAY_KEY_SECRET') ?: 'dt_secret_key_prod_8892';

try {
    $rawInput = file_get_contents('php://input');
    $jsonData = json_decode($rawInput, true) ?: [];
    $data = !empty($jsonData) ? $jsonData : $_POST;
    $action = $data['action'] ?? ($_GET['action'] ?? 'get_methods');

    $pdo = Database::getConnection();

    // ── 1. GET PAYMENT METHODS ──
    if ($action === 'get_methods' || ($method === 'GET' && empty($_GET['action']))) {
        $channel = trim($_GET['channel'] ?? 'retail');
        $methods = [
            [
                'id' => 'razorpay',
                'name' => 'Razorpay Secure (UPI, Cards, NetBanking)',
                'enabled' => true,
                'type' => 'online',
                'key_id' => $razorpayKeyId,
                'channels' => ['retail', 'wholesale', 'reseller', 'retailer']
            ],
            [
                'id' => 'cod',
                'name' => 'Cash on Delivery (COD)',
                'enabled' => true,
                'type' => 'offline',
                'max_limit' => 25000,
                'channels' => ['retail']
            ],
            [
                'id' => 'bank_transfer',
                'name' => 'Direct RTGS / NEFT Bank Transfer',
                'enabled' => true,
                'type' => 'offline',
                'bank_details' => [
                    'account_name' => "JAI HANUMAN TEX / DT BRAND'S",
                    'bank_name' => 'HDFC Bank Ltd',
                    'account_number' => '50200088921102',
                    'ifsc_code' => 'HDFC0000240',
                    'branch' => 'Ring Road Textile Market, Surat'
                ],
                'channels' => ['wholesale', 'reseller', 'retailer']
            ],
            [
                'id' => 'wallet',
                'name' => 'Reseller Wallet Balance',
                'enabled' => true,
                'type' => 'wallet',
                'channels' => ['reseller']
            ]
        ];

        echo json_encode([
            'success' => true,
            'channel' => $channel,
            'methods' => $methods
        ], JSON_PRETTY_PRINT);
        exit;
    }

    // ── 2. CREATE RAZORPAY ORDER ──
    if ($action === 'create_order') {
        $amount = (float)($data['amount'] ?? 0);
        $orderNumber = trim($data['order_number'] ?? ('DT-' . strtoupper(substr(uniqid(), -6))));
        $currency = 'INR';

        if ($amount <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Valid order amount is required']);
            exit;
        }

        $amountInPaise = (int)round($amount * 100);
        $razorpayOrderId = 'order_' . substr(md5(uniqid($orderNumber, true)), 0, 14);

        // If real cURL to Razorpay API is configured
        if (!empty(getenv('RAZORPAY_KEY_ID')) && !empty(getenv('RAZORPAY_KEY_SECRET'))) {
            $ch = curl_init('https://api.razorpay.com/v1/orders');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $razorpayKeyId . ':' . $razorpayKeySecret);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'amount' => $amountInPaise,
                'currency' => $currency,
                'receipt' => $orderNumber,
                'payment_capture' => 1
            ]));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200 && $response) {
                $rzpRes = json_decode($response, true);
                if (!empty($rzpRes['id'])) {
                    $razorpayOrderId = $rzpRes['id'];
                }
            }
        }

        echo json_encode([
            'success' => true,
            'order_id' => $razorpayOrderId,
            'order_number' => $orderNumber,
            'amount' => $amount,
            'amount_paise' => $amountInPaise,
            'currency' => $currency,
            'key_id' => $razorpayKeyId
        ]);
        exit;
    }

    // ── 3. VERIFY PAYMENT SIGNATURE ──
    if ($action === 'verify_signature') {
        $rzpOrderId = trim($data['razorpay_order_id'] ?? '');
        $rzpPaymentId = trim($data['razorpay_payment_id'] ?? '');
        $rzpSignature = trim($data['razorpay_signature'] ?? '');
        $orderNumber = trim($data['order_number'] ?? '');

        if (empty($rzpOrderId) || empty($rzpPaymentId)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Missing Razorpay verification tokens']);
            exit;
        }

        $expectedSig = hash_hmac('sha256', $rzpOrderId . '|' . $rzpPaymentId, $razorpayKeySecret);
        $isValid = hash_equals($expectedSig, $rzpSignature) || (empty($rzpSignature) && Database::isMockMode());

        if ($isValid) {
            if ($pdo !== null && !empty($orderNumber)) {
                $stmt = $pdo->prepare("
                    UPDATE orders 
                    SET payment_status = 'paid', order_status = 'processing', updated_at = NOW() 
                    WHERE order_number = ?
                ");
                $stmt->execute([$orderNumber]);

                // Insert into order_status_history
                $ordStmt = $pdo->prepare("SELECT id FROM orders WHERE order_number = ?");
                $ordStmt->execute([$orderNumber]);
                $ordRow = $ordStmt->fetch();
                if ($ordRow) {
                    $histStmt = $pdo->prepare("
                        INSERT INTO order_status_history 
                        (order_id, previous_status, new_status, comment, updated_by) 
                        VALUES (?, 'pending', 'paid', ?, 'Razorpay Gateway')
                    ");
                    $histStmt->execute([
                        (int)$ordRow['id'],
                        "Payment verified via Razorpay ID: {$rzpPaymentId}"
                    ]);
                }
            }

            echo json_encode([
                'success' => true,
                'verified' => true,
                'message' => 'Payment verified successfully',
                'payment_id' => $rzpPaymentId,
                'order_number' => $orderNumber
            ]);
        } else {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'verified' => false,
                'error' => 'Invalid payment signature'
            ]);
        }
        exit;
    }

    // ── 4. COD ORDER INITIALIZATION ──
    if ($action === 'cod_init') {
        $orderNumber = trim($data['order_number'] ?? '');
        if (empty($orderNumber)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Order number is required']);
            exit;
        }

        if ($pdo !== null) {
            $stmt = $pdo->prepare("
                UPDATE orders 
                SET payment_method = 'cod', payment_status = 'pending', order_status = 'new', updated_at = NOW() 
                WHERE order_number = ?
            ");
            $stmt->execute([$orderNumber]);
        }

        echo json_encode([
            'success' => true,
            'message' => 'Cash on Delivery order confirmed',
            'order_number' => $orderNumber
        ]);
        exit;
    }

    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid payment action']);
    exit;

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Payment processor error: ' . $e->getMessage()]);
    exit;
}
