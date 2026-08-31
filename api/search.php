<?php
/**
 * api/search.php — Live High-Speed Predictive Autocomplete & Faceted Search API
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ProductCatalog.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;

$q = trim($_GET['q'] ?? ($_GET['query'] ?? ($_GET['search'] ?? '')));
$category = trim($_GET['category'] ?? ($_GET['cat'] ?? ''));

$results = [
    'query' => $q,
    'total' => 0,
    'categories' => [],
    'products' => [],
    'suggestions' => []
];

// 1. Fetch matching categories
$pdo = Database::getConnection();
if ($pdo !== null && !Database::isMockMode()) {
    try {
        if (!empty($q)) {
            $catStmt = $pdo->prepare("SELECT id, name, slug, image, products_count FROM categories WHERE name LIKE ? OR description LIKE ? LIMIT 5");
            $catStmt->execute(["%$q%", "%$q%"]);
            $results['categories'] = $catStmt->fetchAll(\PDO::FETCH_ASSOC);
        } else {
            $catStmt = $pdo->query("SELECT id, name, slug, image, products_count FROM categories ORDER BY display_order ASC LIMIT 6");
            $results['categories'] = $catStmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    } catch (\Exception $e) {}
}

// 2. Fetch matching products or trending products if q is empty
$all = ProductCatalog::getAll();
$matchedProducts = [];

foreach ($all as $p) {
    if (!empty($category) && strtolower($category) !== 'all') {
        $pCat = strtolower($p['category'] ?? ($p['category_name'] ?? ''));
        $targetCat = strtolower($category);
        if ($pCat !== $targetCat && strpos($pCat, $targetCat) === false && strpos($targetCat, $pCat) === false) {
            continue;
        }
    }

    if (!empty($q)) {
        $searchSpace = strtolower(($p['title'] ?? '') . ' ' . ($p['name'] ?? '') . ' ' . ($p['sku'] ?? '') . ' ' . ($p['category'] ?? '') . ' ' . ($p['sub_category'] ?? '') . ' ' . ($p['fabric'] ?? '') . ' ' . ($p['color'] ?? '') . ' ' . ($p['description'] ?? ''));
        if (strpos($searchSpace, strtolower($q)) === false) {
            continue;
        }
    }

    $pName = (string)($p['title'] ?? ($p['name'] ?? ''));
    $pPrice = (float)($p['price'] ?? ($p['customer_price'] ?? ($p['retail_price'] ?? 0)));
    $pOldPrice = (float)($p['old_price'] ?? ($p['mrp'] ?? round($pPrice * 1.35)));
    $pDiscPct = ($pOldPrice > $pPrice && $pOldPrice > 0) ? (int)round((($pOldPrice - $pPrice) / $pOldPrice) * 100) : 0;
    $pImg = !empty($p['image']) ? $p['image'] : (!empty($p['images'][0]) ? $p['images'][0] : '/assets/images/product1.png');

    $matchedProducts[] = [
        'id' => (int)$p['id'],
        'sku' => (string)($p['sku'] ?? ''),
        'title' => $pName,
        'name' => $pName,
        'category' => (string)($p['category'] ?? ($p['category_name'] ?? '')),
        'sub_category' => (string)($p['sub_category'] ?? ($p['subcategory'] ?? '')),
        'fabric' => (string)($p['fabric'] ?? ''),
        'color' => (string)($p['color'] ?? ''),
        'price' => $pPrice,
        'old_price' => $pOldPrice,
        'discount_pct' => $pDiscPct,
        'wholesale_price' => (float)($p['wholesale_price'] ?? round($pPrice * 0.45)),
        'image' => $pImg,
        'has_photo' => !empty($p['has_photo']) || !empty($p['image']),
        'badge' => (string)($p['badge'] ?? ''),
        'rating' => (float)($p['rating'] ?? 4.8),
        'in_stock' => (bool)($p['in_stock'] ?? true),
        'stock_qty' => (int)($p['stock_qty'] ?? 50),
        'url' => '/product.php?id=' . (int)$p['id']
    ];
}

$results['products'] = array_slice($matchedProducts, 0, 15);
$results['total'] = count($matchedProducts);

// 3. Generate predictive & trending query suggestions
$trendingTags = [
    'Banarasi Silk Saree',
    'Bridal Velvet Lehenga',
    'Pure Kanjivaram Zari',
    'Floor-Length Gown',
    '3-Piece Festive Kurti',
    'Yeola Paithani Handloom',
    'Organza Pastel Saree',
    'Wholesale Factory Lots'
];

$suggestions = [];
if (!empty($q)) {
    foreach ($results['categories'] as $c) {
        $suggestions[] = $c['name'];
    }
    foreach ($matchedProducts as $p) {
        $suggestions[] = $p['title'];
        if (!empty($p['fabric']) && !in_array($p['fabric'] . ' Sarees', $suggestions)) {
            $suggestions[] = $p['fabric'] . ' Sarees';
        }
    }
    $results['suggestions'] = array_values(array_unique(array_slice($suggestions, 0, 8)));
} else {
    $results['suggestions'] = $trendingTags;
}
$results['trending'] = $trendingTags;

echo json_encode([
    'success' => true,
    'data' => $results,
    'results' => $results
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
