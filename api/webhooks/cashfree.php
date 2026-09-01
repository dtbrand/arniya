<?php
/**
 * cashfree.php — Official Cashfree Server-to-Server Webhook Receiver
 * Handles PAYMENT_SUCCESS_WEBHOOK, ORDER_PAID, etc.
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/PaymentManager.php';

use DTBrand\Database;
use DTBrand\PaymentManager;

$rawBody = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_WEBHOOK_SIGNATURE'] ?? '';
$timestamp = $_SERVER['HTTP_X_WEBHOOK_TIMESTAMP'] ?? '';

if (empty($rawBody)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Empty webhook payload']);
    exit;
}

$cfGate = PaymentManager::getGateway('cashfree');
$cfg = $cfGate['config'] ?? [];
$webhookSecret = trim((string)($cfg['webhook_secret'] ?? ''));

if (!empty($webhookSecret) && !empty($signature) && !empty($timestamp)) {
    $expected = base64_encode(hash_hmac('sha256', $timestamp . $rawBody, $webhookSecret, true));
    if (!hash_equals($expected, $signature)) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Invalid Cashfree webhook signature']);
        exit;
    }
}

$event = json_decode($rawBody, true) ?: [];
$eventData = $event['data'] ?? [];
$orderData = $eventData['order'] ?? [];
$paymentData = $eventData['payment'] ?? [];

$orderId = $orderData['order_id'] ?? '';
$orderParts = explode('_', $orderId);
$orderNumber = $orderParts[0] ?? $orderId;
$cfPaymentId = $paymentData['cf_payment_id'] ?? '';
$amount = (float)($orderData['order_amount'] ?? 0);
$paymentStatus = $paymentData['payment_status'] ?? ($event['type'] ?? '');

$db = Database::getConnection();

if (!empty($orderNumber)) {
    try {
        if ($paymentStatus === 'SUCCESS' || $paymentStatus === 'PAYMENT_SUCCESS_WEBHOOK') {
            // 1. Mark order paid and adjust stock
            PaymentManager::markOrderPaidAndAdjustStock($orderNumber, 'cashfree', $cfPaymentId, $event);

            // 2. Record transaction ledger
            PaymentManager::recordTransaction([
                'order_number'        => $orderNumber,
                'gateway'             => 'cashfree',
                'payment_method'      => $paymentData['payment_group'] ?? 'cashfree_pg',
                'amount'              => $amount,
                'currency'            => $orderData['order_currency'] ?? 'INR',
                'status'              => 'captured',
                'gateway_order_id'    => $orderId,
                'gateway_payment_id'  => $cfPaymentId,
                'webhook_payload'     => $event,
                'notes'               => "Cashfree webhook: {$paymentStatus}"
            ]);
        }
    } catch (\Throwable $e) {
        error_log("Cashfree webhook error: " . $e->getMessage());
    }
}

http_response_code(200);
echo json_encode(['status' => 'success']);
