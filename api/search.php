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

$searchTokens = [];
if (!empty($q)) {
    $normalizedQ = strtolower($q);
    $normalizedQ = str_replace(['sarees', 'lehengas', 'gowns', 'kurtis'], ['saree', 'lehenga', 'gown', 'kurti'], $normalizedQ);
    $searchTokens = array_values(array_filter(preg_split('/[\s,\-\+]+/', $normalizedQ), fn($t) => strlen($t) > 0));
}

foreach ($all as $p) {
    if (!empty($category) && strtolower($category) !== 'all') {
        $pCat = strtolower($p['category'] ?? ($p['category_name'] ?? ''));
        $targetCat = strtolower($category);
        $targetCat = str_replace(['sarees', 'lehengas', 'gowns', 'kurtis'], ['saree', 'lehenga', 'gown', 'kurti'], $targetCat);
        if ($pCat !== $targetCat && strpos($pCat, $targetCat) === false && strpos($targetCat, $pCat) === false) {
            continue;
        }
    }

    if (!empty($searchTokens)) {
        $pTitle = strtolower($p['title'] ?? ($p['name'] ?? ''));
        $pSku = strtolower($p['sku'] ?? '');
        $pCat = strtolower($p['category'] ?? ($p['category_name'] ?? ''));
        $pSub = strtolower($p['sub_category'] ?? ($p['subcategory'] ?? ''));
        $pFabric = strtolower($p['fabric'] ?? '');
        $pColor = strtolower($p['color'] ?? '');
        $pDesc = strtolower($p['description'] ?? '');

        // Build comprehensive search corpus including synonyms like banarasi <-> varanasi, silk, zari, katan, kadwa
        $corpus = "{$pTitle} {$pSku} {$pCat} {$pSub} {$pFabric} {$pColor} {$pDesc}";
        if (strpos($corpus, 'varanasi') !== false || strpos($corpus, 'kadwa') !== false || strpos($corpus, 'katan') !== false) {
            $corpus .= ' banarasi banaras';
        }
        if (strpos($corpus, 'kanjivaram') !== false || strpos($corpus, 'brocade') !== false) {
            $corpus .= ' kanchipuram zari silk';
        }
        if (strpos($corpus, 'paithani') !== false) {
            $corpus .= ' yeola silk maharashtra';
        }

        // Token match: check how many tokens match
        $matchedCount = 0;
        foreach ($searchTokens as $token) {
            $tokenBase = (strlen($token) > 3 && substr($token, -1) === 's') ? substr($token, 0, -1) : $token;
            if (strpos($corpus, $token) !== false || strpos($corpus, $tokenBase) !== false) {
                $matchedCount++;
            }
        }

        $minRequired = count($searchTokens) === 1 ? 1 : max(1, (int)ceil(count($searchTokens) * 0.5));
        if ($matchedCount < $minRequired) {
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

// 3. Generate predictive & trending query suggestions from real catalog
$trendingTags = [
    'Kanjivaram Pure Zari Saree',
    'Banarasi Katan Silk Saree',
    'Yeola Paithani Silk Saree',
    'Maharani Velvet Bridal Lehenga',
    'Organza Floral Bridal Lehenga',
    'Floor-Length Evening Gown',
    'Indo-Western Drape Gown',
    'Chanderi Silk 3-Piece Kurti',
    'Pure Muslin Kurti Set',
    'Organza Tissue Handloom Saree'
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
