<?php
/**
 * api/webhooks/delhivery.php — Delhivery Logistics Push Tracking Webhook
 * DT Brand's & Jai Hanuman Tex
 */

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
}

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/OrderManager.php';

use DTBrand\Database;
use DTBrand\OrderManager;

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
                $newOrderStatus = 'out_for_delivery';
            } elseif (strpos($status, 'in transit') !== false || strpos($status, 'dispatched') !== false) {
                $newOrderStatus = 'dispatched';
            }

            if ($newOrderStatus) {
                // Update via OrderManager for history & dual schema columns
                OrderManager::updateStatus($awb, $newOrderStatus, $awb, 'Delhivery Express', 'Delhivery Webhook');

                // Resilient direct fallback
                try {
                    $updStmt = $pdo->prepare("UPDATE orders SET fulfillment_status = ?, updated_at = NOW() WHERE awb_number = ? OR tracking_number = ?");
                    $updStmt->execute([$newOrderStatus, $awb, $awb]);
                } catch (\Throwable $uex) {}
            }
        }

        $markStmt = $pdo->prepare("UPDATE webhook_events SET status = 'processed', processed_at = NOW() WHERE event_id = ?");
        $markStmt->execute([$eventId]);

    } catch (\Throwable $e) {
        // Silently record
    }
}

echo json_encode(['success' => true, 'status' => 'DELHIVERY_WEBHOOK_PROCESSED']);
