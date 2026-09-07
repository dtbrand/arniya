<?php
/**
 * api/payments/razorpay_webhook.php — Razorpay Payment Webhook Handler
 * DT Brand's & Jai Hanuman Tex
 * 
 * Handles: payment.captured, payment.failed, order.paid
 * Verifies HMAC-SHA256 signature using webhook secret
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
$signature = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '';

if (empty($rawBody) || empty($signature)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing payload or signature']);
    exit;
}

// Verify webhook signature
if (!PaymentManager::verifyRazorpayWebhookSignature($rawBody, $signature)) {
    error_log('Razorpay webhook: Invalid signature');
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

$event = $payload['event'] ?? '';
$entity = $payload['payload'] ?? [];
$paymentEntity = $entity['payment'] ?? $entity['order'] ?? [];

// Log webhook event
$db = Database::getConnection();
if ($db && !Database::isMockMode()) {
    try {
        $stmt = $db->prepare("INSERT INTO webhook_events (provider, event_id, payload, signature_valid, status, received_at) VALUES (?, ?, ?, 1, 'received', NOW())");
        $stmt->execute(['razorpay', $payload['id'] ?? uniqid('evt_'), json_encode($payload)]);
    } catch (Throwable $e) {
        error_log('Webhook event log failed: ' . $e->getMessage());
    }
}

try {
    switch ($event) {
        case 'payment.captured':
        case 'payment.authorized':
            handlePaymentCaptured($paymentEntity);
            break;
            
        case 'payment.failed':
            handlePaymentFailed($paymentEntity);
            break;
            
        case 'order.paid':
            handleOrderPaid($entity['order'] ?? []);
            break;
            
        default:
            // Acknowledge other events but don't process
            error_log("Razorpay webhook: Unhandled event type: $event");
    }
    
    echo json_encode(['success' => true, 'message' => 'Webhook processed']);
    
} catch (Throwable $e) {
    error_log('Razorpay webhook processing error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Processing failed']);
}

function handlePaymentCaptured(array $payment): void
{
    $rzpOrderId = $payment['order_id'] ?? '';
    $rzpPaymentId = $payment['id'] ?? '';
    $rzpSignature = $payment['signature'] ?? '';
    $amount = (float)($payment['amount'] ?? 0) / 100; // Convert from paise
    $currency = $payment['currency'] ?? 'INR';
    $email = $payment['email'] ?? '';
    $phone = $payment['contact'] ?? '';
    $notes = $payment['notes'] ?? [];
    $orderNumber = $notes['order_number'] ?? '';
    
    if (empty($orderNumber) || empty($rzpOrderId) || empty($rzpPaymentId)) {
        error_log('Razorpay: Missing order_number or payment IDs');
        return;
    }
    
    // Verify payment signature
    if (!PaymentManager::verifyRazorpaySignature($rzpOrderId, $rzpPaymentId, $rzpSignature)) {
        error_log("Razorpay: Signature verification failed for order $orderNumber");
        return;
    }
    
    // Record transaction
    PaymentManager::recordTransaction([
        'order_number' => $orderNumber,
        'gateway' => 'razorpay',
        'payment_method' => $payment['method'] ?? 'card',
        'amount' => $amount,
        'currency' => $currency,
        'status' => 'captured',
        'gateway_order_id' => $rzpOrderId,
        'gateway_payment_id' => $rzpPaymentId,
        'gateway_signature' => $rzpSignature,
        'customer_name' => $notes['customer_name'] ?? '',
        'customer_phone' => $phone,
        'customer_email' => $email,
    ]);
    
    // Mark order paid and adjust stock
    PaymentManager::markOrderPaidAndAdjustStock($orderNumber, 'razorpay', $rzpPaymentId);
    
    // Update order fulfillment status
    OrderManager::updateStatus($orderNumber, 'processing', null, null, 'Razorpay Webhook');
}

function handlePaymentFailed(array $payment): void
{
    $rzpOrderId = $payment['order_id'] ?? '';
    $rzpPaymentId = $payment['id'] ?? '';
    $errorCode = $payment['error_code'] ?? '';
    $errorDescription = $payment['error_description'] ?? '';
    $notes = $payment['notes'] ?? [];
    $orderNumber = $notes['order_number'] ?? '';
    
    if (empty($orderNumber)) {
        error_log('Razorpay failed payment: No order_number in notes');
        return;
    }
    
    // Record failed transaction
    PaymentManager::recordTransaction([
        'order_number' => $orderNumber,
        'gateway' => 'razorpay',
        'payment_method' => $payment['method'] ?? 'card',
        'amount' => (float)($payment['amount'] ?? 0) / 100,
        'currency' => $payment['currency'] ?? 'INR',
        'status' => 'failed',
        'gateway_order_id' => $rzpOrderId,
        'gateway_payment_id' => $rzpPaymentId,
        'notes' => "Error: $errorCode - $errorDescription",
    ]);
    
    // Update order payment status
    $db = Database::getConnection();
    if ($db && !Database::isMockMode()) {
        $stmt = $db->prepare("UPDATE orders SET payment_status = 'failed' WHERE order_number = ?");
        $stmt->execute([$orderNumber]);
    }
}

function handleOrderPaid(array $order): void
{
    $rzpOrderId = $order['id'] ?? '';
    $notes = $order['notes'] ?? [];
    $orderNumber = $notes['order_number'] ?? '';
    
    if (empty($orderNumber) || empty($rzpOrderId)) {
        return;
    }
    
    // Order is fully paid - ensure stock is adjusted
    $db = Database::getConnection();
    if ($db && !Database::isMockMode()) {
        $stmt = $db->prepare("SELECT payment_status FROM orders WHERE order_number = ?");
        $stmt->execute([$orderNumber]);
        $current = $stmt->fetchColumn();
        
        if ($current !== 'paid') {
            $stmt2 = $db->prepare("UPDATE orders SET payment_status = 'paid', gateway_payment_id = ? WHERE order_number = ?");
            $stmt2->execute([$rzpOrderId, $orderNumber]);
            PaymentManager::markOrderPaidAndAdjustStock($orderNumber, 'razorpay', $rzpOrderId);
        }
    }
}