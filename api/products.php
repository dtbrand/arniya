<?php
/**
 * api/products.php — REST & AJAX Product Search, Filter & Catalog Feed
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

require_once __DIR__ . '/../src/ProductCatalog.php';
use DTBrand\ProductCatalog;

$action = $_GET['action'] ?? 'list';

if (isset($_GET['id'])) {
    $product = ProductCatalog::getById((int)$_GET['id']);
    if ($product) {
        echo json_encode(['success' => true, 'data' => $product], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    } else {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Product not found']);
    }
    exit;
}

$filters = [
    'category' => $_GET['category'] ?? '',
    'search' => $_GET['search'] ?? '',
    'max_price' => $_GET['max_price'] ?? ''
];

$products = ProductCatalog::filter($filters);

echo json_encode([
    'success' => true,
    'count' => count($products),
    'categories' => ProductCatalog::getCategories(),
    'data' => $products
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
