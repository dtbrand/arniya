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
    $rawInput = file_get_contents('php://input');
    $jsonData = json_decode($rawInput, true);
    if (is_array($jsonData)) {
        $_POST = array_merge($_POST, $jsonData);
    }
    $action = $_POST['action'] ?? $action;

    if ($action === 'create' || $action === 'add' || $action === 'update' || $action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $slug = trim($_POST['slug'] ?? strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name)));
        $desc = trim($_POST['description'] ?? '');
        $image = trim($_POST['image'] ?? '/Frontend/Shop/Asset/images/product1.png');
        $status = trim($_POST['status'] ?? 'active');

        if (empty($name)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Category name is required.']);
            exit;
        }

        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                if ($id > 0) {
                    $stmt = $pdo->prepare("UPDATE categories SET name = ?, slug = ?, description = ?, image = ?, status = ? WHERE id = ?");
                    $stmt->execute([$name, $slug, $desc, $image, $status, $id]);
                    echo json_encode([
                        'success' => true,
                        'message' => 'Category updated successfully.',
                        'category' => ['id' => $id, 'name' => $name, 'slug' => $slug, 'description' => $desc, 'image' => $image, 'status' => $status]
                    ]);
                    exit;
                } else {
                    $orderStmt = $pdo->query("SELECT COALESCE(MAX(display_order), 0) + 1 AS next_order FROM categories");
                    $nextOrder = (int)$orderStmt->fetchColumn();

                    $stmt = $pdo->prepare("INSERT INTO categories (name, slug, description, image, display_order, status, products_count) VALUES (?, ?, ?, ?, ?, ?, 0)");
                    $stmt->execute([$name, $slug, $desc, $image, $nextOrder, $status]);
                    $newId = (int)$pdo->lastInsertId();
                    echo json_encode([
                        'success' => true,
                        'message' => 'Category created successfully.',
                        'category' => ['id' => $newId, 'name' => $name, 'slug' => $slug, 'description' => $desc, 'image' => $image, 'display_order' => $nextOrder]
                    ]);
                    exit;
                }
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
                exit;
            }
        }

        echo json_encode([
            'success' => true,
            'message' => 'Category saved successfully.',
            'category' => ['id' => $id ?: rand(10, 99), 'name' => $name, 'slug' => $slug, 'description' => $desc, 'image' => $image]
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

    if ($action === 'bulk_delete') {
        $ids = $_POST['ids'] ?? [];
        if (is_string($ids)) {
            $ids = array_map('intval', explode(',', $ids));
        }
        $ids = array_filter(array_map('intval', (array)$ids));

        if (!empty($ids)) {
            $pdo = Database::getConnection();
            if ($pdo !== null && !Database::isMockMode()) {
                try {
                    $inPlaceholders = implode(',', array_fill(0, count($ids), '?'));
                    $stmt = $pdo->prepare("DELETE FROM categories WHERE id IN ($inPlaceholders)");
                    $stmt->execute(array_values($ids));
                } catch (\Exception $e) {}
            }
        }

        echo json_encode(['success' => true, 'message' => count($ids) . ' categories deleted successfully.']);
        exit;
    }

    if ($action === 'reorder') {
        $order = $_POST['order'] ?? [];
        if (is_string($order)) {
            $order = json_decode($order, true) ?: explode(',', $order);
        }
        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode() && is_array($order)) {
            try {
                $stmt = $pdo->prepare("UPDATE categories SET display_order = ? WHERE id = ?");
                foreach ($order as $pos => $catId) {
                    $stmt->execute([(int)$pos + 1, (int)$catId]);
                }
            } catch (\Exception $e) {}
        }
        echo json_encode(['success' => true, 'message' => 'Category display order updated.']);
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

