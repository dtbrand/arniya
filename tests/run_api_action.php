<?php
/**
 * run_api_action.php — Robust CLI Test Harness for arbitrary API endpoints
 * Usage: php run_api_action.php [GET|POST] [uri] [base64_or_json_payload]
 */
$method = $argv[1] ?? 'GET';
$uri = $argv[2] ?? 'api/integrations.php?action=stats';
$rawPost = $argv[3] ?? '';

$_SERVER['REQUEST_METHOD'] = strtoupper($method);
$_SERVER['REQUEST_URI'] = '/' . ltrim($uri, '/');
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

$parsed = parse_url($_SERVER['REQUEST_URI']);
$path = ltrim($parsed['path'] ?? '', '/');
$queryString = $parsed['query'] ?? '';

$_GET = [];
parse_str($queryString, $_GET);

$_POST = [];
if (!empty($rawPost)) {
    $decoded = json_decode($rawPost, true);
    if (!is_array($decoded)) {
        $fromB64 = base64_decode($rawPost, true);
        if ($fromB64 !== false) {
            $decoded = json_decode($fromB64, true);
        }
    }
    if (is_array($decoded)) {
        $_POST = $decoded;
    }
}

$target = __DIR__ . '/../' . $path;
if (is_file($target)) {
    require $target;
} else {
    echo json_encode(['success' => false, 'message' => "File not found: {$target}"]);
}
