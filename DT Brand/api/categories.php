<?php
/**
 * api/categories.php — Category Tree & Lookbooks Feed API
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/ProductCatalog.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

try {
    $categories = ProductCatalog::getCategoriesWithDetails();

    echo json_encode([
        'success' => true,
        'count' => count($categories),
        'categories' => $categories
    ], JSON_PRETTY_PRINT);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to load categories: ' . $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
