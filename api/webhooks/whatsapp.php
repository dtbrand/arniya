<?php
/**
 * api/webhooks/whatsapp.php — WhatsApp Cloud API Inbound Webhook & Verification Challenge
 * DT Brand's & Jai Hanuman Tex
 */

// 1. WhatsApp Verification Challenge (GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $verifyToken = getenv('WHATSAPP_VERIFY_TOKEN') ?: 'dtbrand_wa_verify_token_2026';
    $mode = $_GET['hub_mode'] ?? '';
    $token = $_GET['hub_verify_token'] ?? '';
    $challenge = $_GET['hub_challenge'] ?? '';

    if ($mode === 'subscribe' && $token === $verifyToken) {
        http_response_code(200);
        echo $challenge;
        exit;
    } else {
        http_response_code(403);
        echo 'Verification token mismatch';
        exit;
    }
}

// 2. Inbound Message / Status Webhook (POST)
if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
}

require_once __DIR__ . '/../../src/Database.php';

use DTBrand\Database;

$rawPayload = file_get_contents('php://input');
$eventData = json_decode($rawPayload, true) ?: [];

$pdo = Database::getConnection();

if ($pdo !== null && !empty($rawPayload)) {
    $eventId = 'wa_evt_' . md5($rawPayload);
    try {
        $stmt = $pdo->prepare("
            INSERT INTO webhook_events (provider, event_id, payload, signature_valid, status, received_at)
            VALUES ('whatsapp', ?, ?, 1, 'processed', NOW())
            ON DUPLICATE KEY UPDATE attempts = attempts + 1
        ");
        $stmt->execute([$eventId, $rawPayload]);
    } catch (\Throwable $e) {
        // Silently capture
    }
}

echo json_encode(['status' => 'EVENT_RECEIVED']);
