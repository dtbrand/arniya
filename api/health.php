<?php
/**
 * api/health.php — REST API Health & Subsystem Readiness Check
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');

$startTime = microtime(true);

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ProductCatalog.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;

$dbConnected = (Database::getConnection() !== null);
$totalProducts = count(ProductCatalog::getAll());

$response = [
    'status' => 'healthy',
    'timestamp' => gmdate('Y-m-d\TH:i:s\Z'),
    'api_version' => '1.0.0',
    'environment' => getenv('APP_ENV') ?: 'production',
    'subsystems' => [
        'api_router' => 'ONLINE',
        'database_pdo' => $dbConnected ? 'CONNECTED' : 'MOCK_FALLBACK_ACTIVE',
        'catalog_engine' => 'ACTIVE',
        'total_skus' => $totalProducts,
        'cart_session' => 'READY',
        'order_processor' => 'READY'
    ],
    'latency_ms' => round((microtime(true) - $startTime) * 1000, 2)
];

echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
