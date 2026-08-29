<?php
/**
 * api/webhooks/bluedart.php — BlueDart Tracking Webhook
 * DT Brand's & Jai Hanuman Tex
 */
if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
}
require_once __DIR__ . '/../../src/Database.php';
use DTBrand\Database;

$rawPayload = file_get_contents('php://input');
$pdo = Database::getConnection();
if ($pdo !== null && !empty($rawPayload)) {
    $eventId = 'bd_' . time() . '_' . substr(md5($rawPayload), 0, 8);
    try {
        $stmt = $pdo->prepare("INSERT INTO webhook_events (provider, event_id, payload, status, received_at) VALUES ('bluedart', ?, ?, 'processed', NOW())");
        $stmt->execute([$eventId, $rawPayload]);
    } catch (\Throwable $e) {}
}
echo json_encode(['success' => true, 'status' => 'BLUEDART_WEBHOOK_PROCESSED']);
