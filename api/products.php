<?php
/**
 * api/products.php — Complete REST & AJAX Product CRUD, Search & Catalog Feed
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');

require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';

// Handle CREATE Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create') {
    $title = trim($_POST['title'] ?? '');
    if (empty($title)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Product title is required']);
        exit;
    }

    $slug = trim($_POST['slug'] ?? '') ?: strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $title));
    $sku = trim($_POST['sku'] ?? '') ?: ('DT-' . strtoupper(substr(uniqid(), -6)));
    $category_id = (int)($_POST['category_id'] ?? 1);
    $category_name = trim($_POST['category'] ?? $_POST['category_name'] ?? 'Silk Sarees');
    $fabric = trim($_POST['fabric'] ?? 'Pure Mulberry Silk');
    $description = trim($_POST['description'] ?? '');
    $retail_price = (float)($_POST['retail_price'] ?? 0);
    $mrp = (float)($_POST['mrp'] ?? ($retail_price > 0 ? $retail_price * 1.35 : 4999.00));
    $wholesale_price = (float)($_POST['wholesale_price'] ?? ($retail_price * 0.45));
    $reseller_price = (float)($_POST['reseller_price'] ?? ($retail_price * 0.70));
    $stock_qty = (int)($_POST['stock_qty'] ?? 50);
    $image = trim($_POST['image'] ?? $_POST['primary_image'] ?? '/Frontend/Shop/Asset/images/product1.png');
    $status = trim($_POST['status'] ?? 'in_stock');

    $db = Database::getConnection();
    if ($db !== null && !Database::isMockMode()) {
        try {
            $stmt = $db->prepare("
                INSERT INTO products (category_id, category_name, sku, title, slug, description, fabric, mrp, retail_price, wholesale_price, reseller_price, stock_qty, primary_image, status, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");
            $stmt->execute([$category_id, $category_name, $sku, $title, $slug, $description, $fabric, $mrp, $retail_price, $wholesale_price, $reseller_price, $stock_qty, $image, $status]);
            $newId = (int)$db->lastInsertId();

            if (!empty($image)) {
                $mStmt = $db->prepare("INSERT INTO product_media (product_id, image_url, is_primary) VALUES (?, ?, 1)");
                $mStmt->execute([$newId, $image]);
            }

            echo json_encode(['success' => true, 'message' => 'Product added successfully', 'id' => $newId]);
            exit;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }

    echo json_encode(['success' => true, 'message' => 'Product created', 'id' => rand(100, 999)]);
    exit;
}

// Handle UPDATE Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update') {
    $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Valid Product ID is required']);
        exit;
    }

    $title = trim($_POST['title'] ?? '');
    $retail_price = (float)($_POST['retail_price'] ?? 0);
    $wholesale_price = (float)($_POST['wholesale_price'] ?? 0);
    $stock_qty = (int)($_POST['stock_qty'] ?? 0);
    $status = trim($_POST['status'] ?? 'in_stock');

    $db = Database::getConnection();
    if ($db !== null && !Database::isMockMode()) {
        try {
            $stmt = $db->prepare("
                UPDATE products 
                SET title = COALESCE(NULLIF(?, ''), title),
                    retail_price = COALESCE(NULLIF(?, 0), retail_price),
                    wholesale_price = COALESCE(NULLIF(?, 0), wholesale_price),
                    stock_qty = ?,
                    status = ?,
                    updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([$title, $retail_price, $wholesale_price, $stock_qty, $status, $id]);
            echo json_encode(['success' => true, 'message' => 'Product updated successfully', 'id' => $id]);
            exit;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }

    echo json_encode(['success' => true, 'message' => 'Product updated', 'id' => $id]);
    exit;
}

// Handle DELETE Product
if ($action === 'delete' || $_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);
    if ($id > 0) {
        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                $db->prepare("DELETE FROM product_media WHERE product_id = ?")->execute([$id]);
                $db->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);
                echo json_encode(['success' => true, 'message' => 'Product deleted successfully', 'id' => $id]);
                exit;
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
                exit;
            }
        }
    }
    echo json_encode(['success' => true, 'message' => 'Product deleted', 'id' => $id]);
    exit;
}

// Handle SINGLE PRODUCT GET
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

// Handle LIST / FILTER
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
