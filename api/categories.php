<?php
/**
 * api/categories.php — Category Tree & Seasonal Lookbooks Feed
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, OPTIONS');

require_once __DIR__ . '/../src/ProductCatalog.php';
use DTBrand\ProductCatalog;

$categories = [
    [
        'id' => 1,
        'name' => 'Kanjivaram Silk',
        'slug' => 'kanjivaram-silk',
        'item_count' => 140,
        'image' => '/Frontend/Shop/Asset/images/category-kanjivaram.jpg',
        'subcategories' => ['Pure Mulberry', 'Bridal Korvai', 'Traditional Temple Zari', 'Tissue Brocade']
    ],
    [
        'id' => 2,
        'name' => 'Banarasi Silk',
        'slug' => 'banarasi-silk',
        'item_count' => 125,
        'image' => '/Frontend/Shop/Asset/images/category-banarasi.jpg',
        'subcategories' => ['Katan Silk', 'Georgette Kadwa', 'Tanchoi Weave', 'Organza Zari']
    ],
    [
        'id' => 3,
        'name' => 'Paithani',
        'slug' => 'paithani',
        'item_count' => 84,
        'image' => '/Frontend/Shop/Asset/images/category-paithani.jpg',
        'subcategories' => ['Yeola Handloom', 'Peacock Pallu', 'Single Muniya', 'Double Pallu']
    ],
    [
        'id' => 4,
        'name' => 'Chanderi',
        'slug' => 'chanderi',
        'item_count' => 96,
        'image' => '/Frontend/Shop/Asset/images/category-chanderi.jpg',
        'subcategories' => ['Pattu Silk Cotton', 'Gold Boori', 'Block Print', 'Zari Border']
    ],
    [
        'id' => 5,
        'name' => 'Organza',
        'slug' => 'organza',
        'item_count' => 112,
        'image' => '/Frontend/Shop/Asset/images/category-organza.jpg',
        'subcategories' => ['Handpainted Floral', 'Thread Embroidery', 'Cutwork Scallop', 'Pastel Festive']
    ],
    [
        'id' => 6,
        'name' => 'Patola',
        'slug' => 'patola',
        'item_count' => 45,
        'image' => '/Frontend/Shop/Asset/images/category-patola.jpg',
        'subcategories' => ['Rajkot Double Ikkat', 'Patan Pure Silk', 'Navratna Weave', 'Shikargah']
    ]
];

echo json_encode([
    'success' => true,
    'count' => count($categories),
    'categories' => $categories
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
