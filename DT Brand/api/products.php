<?php
/**
 * api/products.php — High-Performance Product Catalog REST API
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
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $sku = isset($_GET['sku']) ? trim($_GET['sku']) : '';
    $category = isset($_GET['category']) ? trim($_GET['category']) : '';
    $fabric = isset($_GET['fabric']) ? trim($_GET['fabric']) : '';
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $minPrice = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
    $maxPrice = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 0;
    $sort = isset($_GET['sort']) ? trim($_GET['sort']) : 'recommended';
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;

    // Single product by ID
    if ($id > 0) {
        $product = ProductCatalog::getById($id);
        if ($product) {
            $recommendations = ProductCatalog::getRecommendations($id, 4);
            echo json_encode([
                'success' => true,
                'product' => $product,
                'recommendations' => $recommendations
            ], JSON_PRETTY_PRINT);
            exit;
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Product not found.'], JSON_PRETTY_PRINT);
            exit;
        }
    }

    // Single product by SKU
    if (!empty($sku)) {
        $product = ProductCatalog::getBySku($sku);
        if ($product) {
            echo json_encode(['success' => true, 'product' => $product], JSON_PRETTY_PRINT);
            exit;
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Product SKU not found.'], JSON_PRETTY_PRINT);
            exit;
        }
    }

    // Query list
    $criteria = [];
    if (!empty($category) && strtolower($category) !== 'all') {
        $criteria['category'] = $category;
    }
    if (!empty($fabric)) {
        $criteria['fabric'] = $fabric;
    }
    if (!empty($search)) {
        $criteria['search'] = $search;
    }
    if ($minPrice > 0) {
        $criteria['min_price'] = $minPrice;
    }
    if ($maxPrice > 0) {
        $criteria['max_price'] = $maxPrice;
    }

    $products = ProductCatalog::filter($criteria);

    // Apply sorting
    if ($sort === 'price_asc') {
        usort($products, fn($a, $b) => $a['retail_price'] <=> $b['retail_price']);
    } elseif ($sort === 'price_desc') {
        usort($products, fn($a, $b) => $b['retail_price'] <=> $a['retail_price']);
    } elseif ($sort === 'discount') {
        usort($products, fn($a, $b) => ($b['discount'] ?? 0) <=> ($a['discount'] ?? 0));
    } elseif ($sort === 'newest') {
        usort($products, fn($a, $b) => $b['id'] <=> $a['id']);
    }

    if ($limit > 0) {
        $products = array_slice($products, 0, $limit);
    }

    echo json_encode([
        'success' => true,
        'count' => count($products),
        'categories' => ProductCatalog::getCategoriesWithDetails(),
        'products' => $products
    ], JSON_PRETTY_PRINT);

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server Error: ' . $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
