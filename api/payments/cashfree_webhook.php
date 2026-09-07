<?php
/**
 * api/payments/cashfree_webhook.php — Cashfree Payment Webhook Handler
 * DT Brand's & Jai Hanuman Tex
 * 
 * Handles: ORDER_PAID, ORDER_FAILED, ORDER_EXPIRED
 * Verifies HMAC-SHA256 signature using webhook secret (base64 encoded)
 * Updates order status, records transaction, decrements stock
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/PaymentManager.php';
require_once __DIR__ . '/../../src/OrderManager.php';

use DTBrand\PaymentManager;
use DTBrand\OrderManager;
use DTBrand\Database;

$rawBody = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_WEBHOOK_SIGNATURE'] ?? '';
$timestamp = $_SERVER['HTTP_X_WEBHOOK_TIMESTAMP'] ?? '';

if (empty($rawBody) || empty($signature) || empty($timestamp)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing payload, signature or timestamp']);
    exit;
}

// Verify webhook signature
if (!PaymentManager::verifyCashfreeWebhookSignature($rawBody, $signature, $timestamp)) {
    error_log('Cashfree webhook: Invalid signature');
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Invalid signature']);
    exit;
}

$payload = json_decode($rawBody, true);
if (!$payload) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
    exit;
}

$eventType = $payload['type'] ?? '';
$data = $payload['data'] ?? [];
$order = $data['order'] ?? [];

// Log webhook event
$db = Database::getConnection();
if ($db && !Database::isMockMode()) {
    try {
        $stmt = $db->prepare("INSERT INTO webhook_events (provider, event_id, payload, signature_valid, status, received_at) VALUES (?, ?, ?, 1, 'received', NOW())");
        $stmt->execute(['cashfree', $payload['id'] ?? uniqid('cf_evt_'), json_encode($payload)]);
    } catch (Throwable $e) {
        error_log('Cashfree webhook event log failed: ' . $e->getMessage());
    }
}

try {
    switch ($eventType) {
        case 'ORDER_PAID':
            handleOrderPaid($order);
            break;
            
        case 'ORDER_FAILED':
        case 'ORDER_EXPIRED':
            handleOrderFailed($order, $eventType);
            break;
            
        default:
            error_log("Cashfree webhook: Unhandled event type: $eventType");
    }
    
    echo json_encode(['success' => true, 'message' => 'Webhook processed']);
    
} catch (Throwable $e) {
    error_log('Cashfree webhook processing error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Processing failed']);
}

function handleOrderPaid(array $order): void
{
    $cfOrderId = $order['order_id'] ?? '';
    $cfPaymentId = $data['payment']['cf_payment_id'] ?? ($order['payment_id'] ?? '');
    $amount = (float)($order['order_amount'] ?? 0);
    $currency = $order['order_currency'] ?? 'INR';
    $customerDetails = $order['customer_details'] ?? [];
    $phone = $customerDetails['customer_phone'] ?? '';
    $email = $customerDetails['customer_email'] ?? '';
    $customerName = $customerDetails['customer_name'] ?? '';
    
    // Extract our order number from cf_order_id format: ORDER_NUM_TIMESTAMP
    $ourOrderNumber = '';
    if (strpos($cfOrderId, '_') !== false) {
        $parts = explode('_', $cfOrderId);
        $ourOrderNumber = $parts[0];
    }
    
    if (empty($ourOrderNumber)) {
        // Try to find by payment ID or amount match
        error_log("Cashfree: Could not extract order number from $cfOrderId");
        return;
    }
    
    // Record successful transaction
    PaymentManager::recordTransaction([
        'order_number' => $ourOrderNumber,
        'gateway' => 'cashfree',
        'payment_method' => $data['payment']['payment_method'] ?? 'upi',
        'amount' => $amount,
        'currency' => $currency,
        'status' => 'captured',
        'gateway_order_id' => $cfOrderId,
        'gateway_payment_id' => $cfPaymentId,
        'customer_name' => $customerName,
        'customer_phone' => $phone,
        'customer_email' => $email,
    ]);
    
    // Mark order paid and adjust stock
    PaymentManager::markOrderPaidAndAdjustStock($ourOrderNumber, 'cashfree', $cfPaymentId);
    
    // Update order fulfillment status
    OrderManager::updateStatus($ourOrderNumber, 'processing', null, null, 'Cashfree Webhook');
}

function handleOrderFailed(array $order, string $eventType): void
{
    $cfOrderId = $order['order_id'] ?? '';
    $ourOrderNumber = '';
    if (strpos($cfOrderId, '_') !== false) {
        $parts = explode('_', $cfOrderId);
        $ourOrderNumber = $parts[0];
    }
    
    if (empty($ourOrderNumber)) {
        error_log("Cashfree $eventType: Could not extract order number from $cfOrderId");
        return;
    }
    
    $errorCode = $order['payment_error_code'] ?? '';
    $errorMessage = $order['payment_error_message'] ?? '';
    
    PaymentManager::recordTransaction([
        'order_number' => $ourOrderNumber,
        'gateway' => 'cashfree',
        'payment_method' => $order['payment_method'] ?? 'upi',
        'amount' => (float)($order['order_amount'] ?? 0),
        'currency' => $order['order_currency'] ?? 'INR',
        'status' => 'failed',
        'gateway_order_id' => $cfOrderId,
        'notes' => "$eventType: $errorCode - $errorMessage",
    ]);
    
    $db = Database::getConnection();
    if ($db && !Database::isMockMode()) {
        $stmt = $db->prepare("UPDATE orders SET payment_status = 'failed' WHERE order_number = ?");
        $stmt->execute([$ourOrderNumber]);
    }
}