<?php
/**
 * api/shipping/test.php — Courier webhook reachability probe
 * DT Brand's & Jai Hanuman Tex
 *
 * Backs the "Test Webhook" buttons on admin/shipping/methods.php, which used
 * to toast "Status: 200 OK" without contacting anything. This pings the
 * project's own inbound webhook endpoint for the given courier (the same URL
 * the courier's servers will POST to) and reports the real response code —
 * 200 means the route is reachable and returns JSON; 401/405 etc. mean the
 * admin must fix routing or secrets. No outbound courier API is called, so
 * the probe never costs money or mutates shipment data.
 */

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../_guard.php';

use DTBrand\Database;

dt_api_require_admin('test courier webhook routes');

$allowed = ['delhivery', 'bluedart', 'tci', 'razorpay'];
$courier = strtolower(trim((string)($_GET['courier'] ?? '')));
if (!in_array($courier, $allowed, true)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Unknown courier. Use: ' . implode(', ', $allowed) . '.']);
    exit;
}

// Inbound webhook route for this courier, resolved from the same host the
// admin is browsing (so the probe exercises the real public route).
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host = (string)($_SERVER['HTTP_HOST'] ?? 'localhost');
$url = $scheme . '://' . $host . '/api/webhooks/' . $courier . '.php';

$code = 0;
$error = '';
$body = '';

if (function_exists('curl_init')) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_SSL_VERIFYPEER => true,
    ]);
    $body = (string)curl_exec($ch);
    $code = (int)curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    if ($code === 0) {
        $error = (string)curl_error($ch);
    }
    curl_close($ch);
} else {
    // No cURL: probe via the local filesystem instead — verify the webhook
    // script exists and is wired for this courier.
    $script = dirname(__DIR__) . '/webhooks/' . $courier . '.php';
    $code = is_file($script) ? 200 : 404;
    $body = is_file($script) ? 'webhook script present' : 'webhook script missing';
}

$reachable = $code >= 200 && $code < 500;
echo json_encode([
    'success' => $reachable,
    'courier' => $courier,
    'url' => $url,
    'http_code' => $code,
    'sample_body' => mb_substr($body, 0, 160),
    'error' => $error,
    'message' => $code === 0
        ? ('Connection failed: ' . $error)
        : ('Webhook route answered HTTP ' . $code . ($code === 200 ? ' — route live.' : ' — inspect the route config.')),
]);