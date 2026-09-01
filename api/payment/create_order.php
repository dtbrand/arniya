<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/PaymentManager.php';

use DTBrand\PaymentManager;

$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true) ?: $_POST;

$gateway = trim((string)($input['gateway'] ?? 'direct_upi'));
$amount = (float)($input['amount'] ?? 0);
$orderNumber = trim((string)($input['order_number'] ?? ('ORD-' . time())));
$customerName = trim((string)($input['customer_name'] ?? ''));
$customerPhone = trim((string)($input['customer_phone'] ?? ''));
$customerEmail = trim((string)($input['customer_email'] ?? ''));

if ($amount <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid order amount']);
    exit;
}

try {
    switch ($gateway) {
        case 'direct_upi':
            $payload = PaymentManager::generateUpiPayload($orderNumber, $amount, $customerName);
            // Log pending transaction
            PaymentManager::recordTransaction([
                'order_number'    => $orderNumber,
                'customer_name'   => $customerName,
                'customer_phone'  => $customerPhone,
                'gateway'         => 'direct_upi',
                'payment_method'  => 'upi',
                'amount'          => $amount,
                'currency'        => 'INR',
                'status'          => 'pending',
                'notes'           => 'Direct UPI Intent Generated'
            ]);
            echo json_encode([
                'success' => true,
                'gateway' => 'direct_upi',
                'data'    => $payload
            ]);
            break;

        case 'razorpay':
            $res = PaymentManager::createRazorpayOrder($orderNumber, $amount, $customerEmail, $customerPhone);
            if ($res['success']) {
                PaymentManager::recordTransaction([
                    'order_number'     => $orderNumber,
                    'customer_name'    => $customerName,
                    'customer_phone'   => $customerPhone,
                    'gateway'          => 'razorpay',
                    'payment_method'   => 'online',
                    'amount'           => $amount,
                    'currency'         => 'INR',
                    'status'           => 'pending',
                    'gateway_order_id' => $res['gateway_order_id'] ?? null,
                    'notes'            => 'Razorpay Order Created'
                ]);
                echo json_encode([
                    'success'          => true,
                    'gateway'          => 'razorpay',
                    'gateway_order_id' => $res['gateway_order_id'],
                    'key_id'           => $res['key_id'],
                    'amount_paise'     => $res['amount_paise'],
                    'currency'         => $res['currency']
                ]);
            } else {
                http_response_code(400);
                echo json_encode($res);
            }
            break;

        case 'cashfree':
            $res = PaymentManager::createCashfreeOrder($orderNumber, $amount, $customerPhone, $customerName, $customerEmail);
            if ($res['success']) {
                PaymentManager::recordTransaction([
                    'order_number'     => $orderNumber,
                    'customer_name'    => $customerName,
                    'customer_phone'   => $customerPhone,
                    'gateway'          => 'cashfree',
                    'payment_method'   => 'cashfree_pg',
                    'amount'           => $amount,
                    'currency'         => 'INR',
                    'status'           => 'pending',
                    'gateway_order_id' => $res['cf_order_id'] ?? null,
                    'notes'            => 'Cashfree Session Created'
                ]);
                echo json_encode([
                    'success'            => true,
                    'gateway'            => 'cashfree',
                    'payment_session_id' => $res['payment_session_id'],
                    'cf_order_id'        => $res['cf_order_id'],
                    'environment'        => $res['environment']
                ]);
            } else {
                http_response_code(400);
                echo json_encode($res);
            }
            break;

        case 'cod':
            $codGate = PaymentManager::getGateway('cod');
            $cfg = $codGate['config'] ?? [];
            $fee = (float)($cfg['handling_fee'] ?? 0);
            $totalWithFee = $amount + $fee;

            PaymentManager::recordTransaction([
                'order_number'    => $orderNumber,
                'customer_name'   => $customerName,
                'customer_phone'  => $customerPhone,
                'gateway'         => 'cod',
                'payment_method'  => 'cash_on_delivery',
                'amount'          => $totalWithFee,
                'currency'        => 'INR',
                'status'          => 'pending',
                'notes'           => 'Cash on Delivery Booking'
            ]);

            echo json_encode([
                'success'      => true,
                'gateway'      => 'cod',
                'order_number' => $orderNumber,
                'handling_fee' => $fee,
                'total_amount' => $totalWithFee
            ]);
            break;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Unsupported payment gateway: ' . $gateway]);
    }
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
