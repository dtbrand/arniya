<?php
/**
 * razorpay.php — Official Razorpay Server-to-Server Webhook Receiver
 * Handles payment.captured, order.paid, payment.failed
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/PaymentManager.php';

use DTBrand\Database;
use DTBrand\PaymentManager;

$rawBody = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '';

if (empty($rawBody)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Empty webhook payload']);
    exit;
}

$rzpGate = PaymentManager::getGateway('razorpay');
$cfg = $rzpGate['config'] ?? [];
$webhookSecret = trim((string)($cfg['webhook_secret'] ?? (getenv('RAZORPAY_WEBHOOK_SECRET') ?: '')));

if (!empty($webhookSecret)) {
    $expected = hash_hmac('sha256', $rawBody, $webhookSecret);
    if (!hash_equals($expected, $signature)) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Invalid webhook signature']);
        exit;
    }
}

$event = json_decode($rawBody, true) ?: [];
$eventType = $event['event'] ?? '';
$payload = $event['payload']['payment']['entity'] ?? ($event['payload']['order']['entity'] ?? []);

$paymentId = $payload['id'] ?? '';
$orderId = $payload['order_id'] ?? '';
$receipt = $payload['receipt'] ?? ($payload['notes']['order_number'] ?? '');
$amount = isset($payload['amount']) ? ($payload['amount'] / 100) : 0;
$status = $payload['status'] ?? '';

$db = Database::getConnection();

if ($db && !empty($receipt)) {
    try {
        if ($eventType === 'payment.captured' || $eventType === 'order.paid') {
            // Mark order paid
            $stmtOrder = $db->prepare("
                UPDATE `orders` 
                SET `payment_status` = 'paid', `payment_gateway` = 'razorpay', `gateway_payment_id` = :pid, `updated_at` = NOW()
                WHERE `order_number` = :ord
            ");
            $stmtOrder->execute([':pid' => $paymentId, ':ord' => $receipt]);

            // Log / Update transaction
            PaymentManager::recordTransaction([
                'order_number'        => $receipt,
                'gateway'             => 'razorpay',
                'payment_method'      => $payload['method'] ?? 'online',
                'amount'              => $amount,
                'currency'            => $payload['currency'] ?? 'INR',
                'status'              => 'captured',
                'gateway_order_id'    => $orderId,
                'gateway_payment_id'  => $paymentId,
                'webhook_payload'     => $event,
                'notes'               => "Webhook event: {$eventType}"
            ]);
        } elseif ($eventType === 'payment.failed') {
            PaymentManager::recordTransaction([
                'order_number'        => $receipt,
                'gateway'             => 'razorpay',
                'payment_method'      => $payload['method'] ?? 'online',
                'amount'              => $amount,
                'currency'            => $payload['currency'] ?? 'INR',
                'status'              => 'failed',
                'gateway_order_id'    => $orderId,
                'gateway_payment_id'  => $paymentId,
                'webhook_payload'     => $event,
                'notes'               => "Payment failed: " . ($payload['error_description'] ?? 'Unknown error')
            ]);
        }
    } catch (\Throwable $e) {
        error_log("Razorpay webhook error: " . $e->getMessage());
    }
}

http_response_code(200);
echo json_encode(['status' => 'success', 'event' => $eventType]);
