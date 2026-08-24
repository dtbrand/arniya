<?php
/**
 * api/search.php — Live Autocomplete & Instant Search API
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ProductCatalog.php';

use DTBrand\ProductCatalog;

try {
    $q = trim($_GET['q'] ?? '');
    $category = trim($_GET['cat'] ?? '');

    if (empty($q) && empty($category)) {
        echo json_encode([
            'success' => true,
            'results' => [
                'categories' => ProductCatalog::getCategoriesWithDetails(),
                'products' => array_slice(ProductCatalog::getAll(), 0, 6)
            ]
        ], JSON_PRETTY_PRINT);
        exit;
    }

    $all = ProductCatalog::getAll();
    $matchedProducts = [];
    $term = strtolower($q);

    foreach ($all as $p) {
        $pCat = strtolower($p['category']);
        $pName = strtolower($p['name']);
        $pSku = strtolower($p['sku']);
        $pFabric = strtolower($p['fabric'] ?? '');

        $catMatch = (empty($category) || strtolower($category) === 'all' || $pCat === strtolower($category) || strpos($pCat, strtolower($category)) !== false);

        $textMatch = (empty($term) || strpos($pName, $term) !== false || strpos($pSku, $term) !== false || strpos($pCat, $term) !== false || strpos($pFabric, $term) !== false);

        if ($catMatch && $textMatch) {
            $matchedProducts[] = [
                'id' => $p['id'],
                'name' => $p['name'],
                'category' => $p['category'],
                'price' => $p['price'],
                'old_price' => $p['old_price'] ?? null,
                'discount' => $p['discount'] ?? 0,
                'image' => $p['image'],
                'url' => '/DT Brand/product.php?id=' . $p['id']
            ];
        }
    }

    // Matching categories
    $allCats = ProductCatalog::getCategoriesWithDetails();
    $matchedCategories = [];
    foreach ($allCats as $c) {
        if (empty($term) || strpos(strtolower($c['name']), $term) !== false) {
            $matchedCategories[] = $c;
        }
    }

    echo json_encode([
        'success' => true,
        'query' => $q,
        'category' => $category,
        'count' => count($matchedProducts),
        'results' => [
            'categories' => array_slice($matchedCategories, 0, 5),
            'products' => array_slice($matchedProducts, 0, 10)
        ]
    ], JSON_PRETTY_PRINT);

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
