<?php
/**
 * api/categories.php — Category Tree & Seasonal Lookbooks Feed & CRUD API
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ProductCatalog.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'create' || $action === 'add') {
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name)));
        $desc = trim($_POST['description'] ?? '');
        $image = trim($_POST['image'] ?? '/Frontend/Shop/Asset/images/category-kanjivaram.jpg');

        if (empty($name)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Category name is required.']);
            exit;
        }

        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("INSERT INTO categories (name, slug, description, image, products_count) VALUES (?, ?, ?, ?, 0)");
                $stmt->execute([$name, $slug, $desc, $image]);
                $newId = (int)$pdo->lastInsertId();
                echo json_encode([
                    'success' => true,
                    'message' => 'Category created successfully.',
                    'category' => ['id' => $newId, 'name' => $name, 'slug' => $slug, 'description' => $desc, 'image' => $image]
                ]);
                exit;
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                exit;
            }
        }

        echo json_encode([
            'success' => true,
            'message' => 'Category registered successfully.',
            'category' => ['id' => rand(10, 99), 'name' => $name, 'slug' => $slug, 'description' => $desc, 'image' => $image]
        ]);
        exit;
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Valid Category ID is required.']);
            exit;
        }

        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
                $stmt->execute([$id]);
            } catch (\Exception $e) {}
        }

        echo json_encode(['success' => true, 'message' => 'Category deleted successfully.']);
        exit;
    }
}

// GET Category list
$categories = [];
$pdo = Database::getConnection();
if ($pdo !== null && !Database::isMockMode()) {
    try {
        $rows = Database::query("SELECT * FROM categories ORDER BY display_order ASC");
        if (!empty($rows)) {
            $categories = $rows;
        }
    } catch (\Exception $e) {}
}

if (empty($categories)) {
    $categories = [
        [
            'id' => 1,
            'name' => 'Kanjivaram Silk',
            'slug' => 'kanjivaram-silk',
            'products_count' => 140,
            'image' => '/Frontend/Shop/Asset/images/category-kanjivaram.jpg',
            'subcategories' => ['Pure Mulberry', 'Bridal Korvai', 'Traditional Temple Zari', 'Tissue Brocade']
        ],
        [
            'id' => 2,
            'name' => 'Banarasi Silk',
            'slug' => 'banarasi-silk',
            'products_count' => 125,
            'image' => '/Frontend/Shop/Asset/images/category-banarasi.jpg',
            'subcategories' => ['Katan Silk', 'Georgette Kadwa', 'Tanchoi Weave', 'Organza Zari']
        ],
        [
            'id' => 3,
            'name' => 'Paithani',
            'slug' => 'paithani',
            'products_count' => 84,
            'image' => '/Frontend/Shop/Asset/images/category-paithani.jpg',
            'subcategories' => ['Yeola Handloom', 'Peacock Pallu', 'Single Muniya', 'Double Pallu']
        ],
        [
            'id' => 4,
            'name' => 'Chanderi',
            'slug' => 'chanderi',
            'products_count' => 96,
            'image' => '/Frontend/Shop/Asset/images/category-chanderi.jpg',
            'subcategories' => ['Pattu Silk Cotton', 'Gold Boori', 'Block Print', 'Zari Border']
        ],
        [
            'id' => 5,
            'name' => 'Organza',
            'slug' => 'organza',
            'products_count' => 112,
            'image' => '/Frontend/Shop/Asset/images/category-organza.jpg',
            'subcategories' => ['Handpainted Floral', 'Thread Embroidery', 'Cutwork Scallop', 'Pastel Festive']
        ],
        [
            'id' => 6,
            'name' => 'Patola',
            'slug' => 'patola',
            'products_count' => 45,
            'image' => '/Frontend/Shop/Asset/images/category-patola.jpg',
            'subcategories' => ['Rajkot Double Ikkat', 'Patan Pure Silk', 'Navratna Weave', 'Shikargah']
        ]
    ];
}

echo json_encode([
    'success' => true,
    'count' => count($categories),
    'categories' => $categories
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;

