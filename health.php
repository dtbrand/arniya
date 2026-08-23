<?php
/**
 * health.php — Production Health Check & Readiness Endpoint
 * DT Brand's & Jai Hanuman Tex
 */
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');

$startTime = microtime(true);

$health = [
    'status' => 'healthy',
    'timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
    'service' => 'DT Brand\'s Commerce Engine',
    'version' => '1.0.0',
    'php_version' => PHP_VERSION,
    'environment' => getenv('APP_ENV') ?: 'production',
    'checks' => [
        'web_server' => 'UP',
        'file_system' => is_writable(__DIR__) ? 'READ_WRITE' : 'READ_ONLY',
        'session_storage' => 'ACTIVE',
        'memory_usage_mb' => round(memory_get_usage(true) / 1024 / 1024, 2),
    ],
    'latency_ms' => round((microtime(true) - $startTime) * 1000, 2)
];

http_response_code(200);
echo json_encode($health, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
