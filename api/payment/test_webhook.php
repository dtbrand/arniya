<?php
header('Content-Type: application/json');
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check admin authentication
if (empty($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized admin access']);
    exit;
}

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/PaymentManager.php';

use DTBrand\PaymentManager;

$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true) ?: $_POST;

$gateway = trim((string)($input['gateway'] ?? 'direct_upi'));
$amount = (float)($input['amount'] ?? 2499.00);
$testOrderNum = 'TEST-' . date('Ymd') . '-' . rand(1000, 9999);

try {
    $txId = PaymentManager::recordTransaction([
        'order_number'        => $testOrderNum,
        'customer_name'       => 'Test Webhook Auditor',
        'customer_phone'      => '917046363528',
        'gateway'             => $gateway,
        'payment_method'      => 'simulation',
        'amount'              => $amount,
        'currency'            => 'INR',
        'status'              => 'captured',
        'gateway_payment_id'  => 'sim_' . time() . '_' . rand(100, 999),
        'utr_reference'       => 'UTR' . date('Ymd') . rand(100000, 999999),
        'webhook_payload'     => [
            'event'     => 'test.payment.captured',
            'simulated' => true,
            'timestamp' => time(),
            'gateway'   => $gateway
        ],
        'notes'               => 'Simulated Webhook Test via Admin Control Studio'
    ]);

    echo json_encode([
        'success'        => true,
        'message'        => "Simulated {$gateway} webhook processed and recorded in ledger!",
        'transaction_id' => $txId,
        'order_number'   => $testOrderNum
    ]);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
