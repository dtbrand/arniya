<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/PaymentManager.php';

use DTBrand\PaymentManager;

try {
    $publicConfigs = PaymentManager::getPublicConfig();
    echo json_encode([
        'success'  => true,
        'gateways' => $publicConfigs,
        'timestamp'=> time()
    ]);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage()
    ]);
}
