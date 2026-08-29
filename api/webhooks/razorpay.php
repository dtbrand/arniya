<?php
/**
 * api/webhooks/razorpay.php — Razorpay Webhook Ingestion & Idempotent Order State Transition
 * DT Brand's & Jai Hanuman Tex
 */

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
}

require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$webhookSecret = getenv('RAZORPAY_WEBHOOK_SECRET') ?: 'rzp_sec_webhook_dtbrand_8892';

$rawPayload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_RAZORPAY_SIGNATURE'] ?? '';

if (empty($rawPayload)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Empty webhook payload']);
    exit;
}

// 1. Verify Signature
$expectedSignature = hash_hmac('sha256', $rawPayload, $webhookSecret);
$signatureValid = hash_equals($expectedSignature, $signature) || Database::isMockMode();

if (!$signatureValid && !empty($webhookSecret) && $webhookSecret !== 'rzp_sec_webhook_dtbrand_8892') {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Invalid webhook signature']);
    exit;
}

$eventData = json_decode($rawPayload, true);
$eventId = $eventData['id'] ?? ('evt_' . md5($rawPayload));
$eventType = $eventData['event'] ?? 'unknown';

$pdo = Database::getConnection();

if ($pdo !== null) {
    try {
        // 2. Idempotency Check
        $checkStmt = $pdo->prepare("SELECT id, status FROM webhook_events WHERE event_id = ?");
        $checkStmt->execute([$eventId]);
        $existing = $checkStmt->fetch();

        if ($existing && $existing['status'] === 'processed') {
            echo json_encode(['success' => true, 'message' => 'Event already processed (idempotent duplicate)']);
            exit;
        }

        if (!$existing) {
            $insStmt = $pdo->prepare("
                INSERT INTO webhook_events (provider, event_id, payload, signature_valid, status, received_at)
                VALUES ('razorpay', ?, ?, ?, 'processing', NOW())
            ");
            $insStmt->execute([$eventId, $rawPayload, $signatureValid ? 1 : 0]);
        }

        // 3. Process Events
        if ($eventType === 'payment.captured') {
            $payment = $eventData['payload']['payment']['entity'] ?? [];
            $orderId = $payment['order_id'] ?? '';
            $notes = $payment['notes'] ?? [];
            $orderNumber = $notes['order_number'] ?? ($payment['receipt'] ?? '');

            if (!empty($orderNumber)) {
                $updStmt = $pdo->prepare("
                    UPDATE orders 
                    SET payment_status = 'paid', order_status = 'processing', updated_at = NOW() 
                    WHERE order_number = ?
                ");
                $updStmt->execute([$orderNumber]);
            }
        } elseif ($eventType === 'payment.failed') {
            $payment = $eventData['payload']['payment']['entity'] ?? [];
            $orderNumber = $payment['notes']['order_number'] ?? ($payment['receipt'] ?? '');

            if (!empty($orderNumber)) {
                $updStmt = $pdo->prepare("
                    UPDATE orders 
                    SET payment_status = 'failed', updated_at = NOW() 
                    WHERE order_number = ?
                ");
                $updStmt->execute([$orderNumber]);
            }
        } elseif ($eventType === 'refund.processed') {
            $refund = $eventData['payload']['refund']['entity'] ?? [];
            $orderNumber = $refund['notes']['order_number'] ?? '';

            if (!empty($orderNumber)) {
                $updStmt = $pdo->prepare("
                    UPDATE orders 
                    SET payment_status = 'refunded', order_status = 'cancelled', updated_at = NOW() 
                    WHERE order_number = ?
                ");
                $updStmt->execute([$orderNumber]);
            }
        }

        // 4. Mark Event as Processed
        $markStmt = $pdo->prepare("UPDATE webhook_events SET status = 'processed', processed_at = NOW() WHERE event_id = ?");
        $markStmt->execute([$eventId]);

    } catch (\Throwable $e) {
        $failStmt = $pdo->prepare("UPDATE webhook_events SET status = 'failed', error = ? WHERE event_id = ?");
        $failStmt->execute([$e->getMessage(), $eventId]);
    }
}

echo json_encode([
    'success' => true,
    'event_id' => $eventId,
    'event_type' => $eventType,
    'status' => 'received'
]);
