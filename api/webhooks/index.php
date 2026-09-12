<?php
/**
 * api/webhooks/index.php - Inbound webhook endpoint directory.
 */
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'success' => true,
    'module' => 'webhooks',
    'message' => 'Use a concrete provider webhook endpoint.',
    'endpoints' => [
        'razorpay' => '/api/webhooks/razorpay.php',
        'cashfree' => '/api/webhooks/cashfree.php',
        'delhivery' => '/api/webhooks/delhivery.php',
        'bluedart' => '/api/webhooks/bluedart.php',
        'tci' => '/api/webhooks/tci.php',
        'whatsapp' => '/api/webhooks/whatsapp.php',
    ],
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
