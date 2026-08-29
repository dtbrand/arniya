<?php
/**
 * api/webhooks/delhivery.php — Delhivery Logistics Push Tracking Webhook
 * DT Brand's & Jai Hanuman Tex
 */

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
}

require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$rawPayload = file_get_contents('php://input');
$eventData = json_decode($rawPayload, true) ?: [];

$pdo = Database::getConnection();

if ($pdo !== null && !empty($rawPayload)) {
    $awb = $eventData['Shipment']['AWB'] ?? ($eventData['waybill'] ?? '');
    $status = strtolower(trim($eventData['Shipment']['Status']['Status'] ?? ($eventData['status'] ?? '')));
    $eventId = 'dlv_' . ($awb ? $awb . '_' : '') . time();

    try {
        $insStmt = $pdo->prepare("
            INSERT INTO webhook_events (provider, event_id, payload, signature_valid, status, received_at)
            VALUES ('delhivery', ?, ?, 1, 'processing', NOW())
        ");
        $insStmt->execute([$eventId, $rawPayload]);

        if (!empty($awb)) {
            $newOrderStatus = null;
            if (strpos($status, 'delivered') !== false) {
                $newOrderStatus = 'delivered';
            } elseif (strpos($status, 'out for delivery') !== false) {
                $newOrderStatus = 'shipped';
            } elseif (strpos($status, 'in transit') !== false || strpos($status, 'dispatched') !== false) {
                $newOrderStatus = 'shipped';
            }

            if ($newOrderStatus) {
                $updStmt = $pdo->prepare("UPDATE orders SET order_status = ?, updated_at = NOW() WHERE awb_number = ?");
                $updStmt->execute([$newOrderStatus, $awb]);
            }
        }

        $markStmt = $pdo->prepare("UPDATE webhook_events SET status = 'processed', processed_at = NOW() WHERE event_id = ?");
        $markStmt->execute([$eventId]);

    } catch (\Throwable $e) {
        // Silently record
    }
}

echo json_encode(['success' => true, 'status' => 'DELHIVERY_WEBHOOK_PROCESSED']);
