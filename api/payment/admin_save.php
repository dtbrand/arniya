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

$gatewayKey = trim((string)($input['gateway_key'] ?? ''));
if (empty($gatewayKey)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing gateway_key parameter']);
    exit;
}

try {
    $ok = PaymentManager::saveGatewayConfig($gatewayKey, $input);
    if ($ok) {
        echo json_encode([
            'success' => true,
            'message' => 'Payment gateway settings saved successfully',
            'gateway' => PaymentManager::getGateway($gatewayKey)
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Failed to save gateway configuration']);
    }
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
