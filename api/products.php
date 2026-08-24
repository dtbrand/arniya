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
    $sku = trim($_POST['sku'] ?? '');
    $category = trim($_POST['category'] ?? $_POST['category_name'] ?? '');
    $fabric = trim($_POST['fabric'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $mrp = (float)($_POST['mrp'] ?? 0);
    $retail_price = (float)($_POST['retail_price'] ?? 0);
    $wholesale_price = (float)($_POST['wholesale_price'] ?? 0);
    $reseller_price = (float)($_POST['reseller_price'] ?? 0);
    $stock_qty = (int)($_POST['stock_qty'] ?? 0);
    $status = trim($_POST['status'] ?? 'in_stock');
    $image = trim($_POST['image'] ?? $_POST['primary_image'] ?? '');

    $db = Database::getConnection();
    if ($db !== null && !Database::isMockMode()) {
        try {
            $stmt = $db->prepare("
                UPDATE products 
                SET title = COALESCE(NULLIF(?, ''), title),
                    sku = COALESCE(NULLIF(?, ''), sku),
                    category_name = COALESCE(NULLIF(?, ''), category_name),
                    fabric = COALESCE(NULLIF(?, ''), fabric),
                    description = COALESCE(NULLIF(?, ''), description),
                    mrp = COALESCE(NULLIF(?, 0), mrp),
                    retail_price = COALESCE(NULLIF(?, 0), retail_price),
                    wholesale_price = COALESCE(NULLIF(?, 0), wholesale_price),
                    reseller_price = COALESCE(NULLIF(?, 0), reseller_price),
                    stock_qty = ?,
                    status = ?,
                    primary_image = COALESCE(NULLIF(?, ''), primary_image),
                    updated_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([
                $title, $sku, $category, $fabric, $description,
                $mrp, $retail_price, $wholesale_price, $reseller_price,
                $stock_qty, $status, $image, $id
            ]);
            echo json_encode(['success' => true, 'message' => 'Product updated successfully in live database', 'id' => $id]);
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

// Handle DUPLICATE Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'duplicate') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Valid Product ID is required']);
        exit;
    }

    $db = Database::getConnection();
    if ($db !== null && !Database::isMockMode()) {
        try {
            $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $prod = $stmt->fetch(\PDO::FETCH_ASSOC);
            if (!$prod) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Source product not found in database']);
                exit;
            }

            $randSuffix = rand(10, 99);
            $newTitle = $prod['title'] . ' (Copy)';
            $newSku = $prod['sku'] . '-COPY-' . $randSuffix;
            $newSlug = ($prod['slug'] ?? 'product') . '-copy-' . $randSuffix;

            $ins = $db->prepare("
                INSERT INTO products (category_id, category_name, sku, title, slug, description, fabric, mrp, retail_price, wholesale_price, reseller_price, stock_qty, primary_image, status, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");
            $ins->execute([
                $prod['category_id'] ?? 1,
                $prod['category_name'] ?? 'Silk Sarees',
                $newSku,
                $newTitle,
                $newSlug,
                $prod['description'] ?? '',
                $prod['fabric'] ?? 'Pure Mulberry Silk',
                $prod['mrp'] ?? 4999.00,
                $prod['retail_price'] ?? 3999.00,
                $prod['wholesale_price'] ?? 1499.00,
                $prod['reseller_price'] ?? 2199.00,
                $prod['stock_qty'] ?? 50,
                $prod['primary_image'] ?? '/Frontend/Shop/Asset/images/product1.png',
                $prod['status'] ?? 'in_stock'
            ]);
            $newId = (int)$db->lastInsertId();

            // Also copy media
            $mStmt = $db->prepare("SELECT image_url, is_primary FROM product_media WHERE product_id = ?");
            $mStmt->execute([$id]);
            $mediaList = $mStmt->fetchAll(\PDO::FETCH_ASSOC);
            if (!empty($mediaList)) {
                $insM = $db->prepare("INSERT INTO product_media (product_id, image_url, is_primary) VALUES (?, ?, ?)");
                foreach ($mediaList as $m) {
                    $insM->execute([$newId, $m['image_url'], $m['is_primary']]);
                }
            }

            echo json_encode([
                'success' => true,
                'message' => 'Product duplicated in live database successfully',
                'id' => $newId,
                'title' => $newTitle,
                'sku' => $newSku,
                'data' => [
                    'id' => $newId,
                    'title' => $newTitle,
                    'sku' => $newSku,
                    'category' => $prod['category_name'] ?? 'Silk Sarees',
                    'retail_price' => (float)($prod['retail_price'] ?? 3999.00),
                    'wholesale_price' => (float)($prod['wholesale_price'] ?? 1499.00),
                    'stock_qty' => (int)($prod['stock_qty'] ?? 50),
                    'primary_image' => $prod['primary_image'] ?? '/Frontend/Shop/Asset/images/product1.png'
                ]
            ]);
            exit;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }

    echo json_encode(['success' => true, 'message' => 'Product duplicated', 'id' => rand(100, 999)]);
    exit;
}

// Handle MOVE / Reassign Category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'move') {
    $id = (int)($_POST['id'] ?? 0);
    $category_name = trim($_POST['category'] ?? $_POST['category_name'] ?? '');
    if ($id > 0 && !empty($category_name)) {
        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                $stmt = $db->prepare("UPDATE products SET category_name = ?, updated_at = NOW() WHERE id = ?");
                $stmt->execute([$category_name, $id]);
                echo json_encode(['success' => true, 'message' => "Product #{$id} moved to {$category_name}"]);
                exit;
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
                exit;
            }
        }
    }
    echo json_encode(['success' => true, 'message' => 'Product moved']);
    exit;
}

// Handle BULK MOVE Category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'bulk_move') {
    $ids = $_POST['ids'] ?? [];
    $category_name = trim($_POST['category'] ?? $_POST['category_name'] ?? '');
    if (is_string($ids)) {
        $ids = array_filter(array_map('intval', explode(',', $ids)));
    }
    if (!empty($ids) && !empty($category_name)) {
        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                $placeholders = implode(',', array_fill(0, count($ids), '?'));
                $params = array_merge([$category_name], $ids);
                $db->prepare("UPDATE products SET category_name = ?, updated_at = NOW() WHERE id IN ($placeholders)")->execute($params);
                echo json_encode(['success' => true, 'message' => count($ids) . " products moved to category '{$category_name}'"]);
                exit;
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
                exit;
            }
        }
    }
    echo json_encode(['success' => true, 'message' => 'Bulk move executed']);
    exit;
}

// Handle BULK UPDATE (stock, category, wholesale_price)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'bulk_update') {
    $ids = $_POST['ids'] ?? [];
    if (is_string($ids)) {
        $ids = array_filter(array_map('intval', explode(',', $ids)));
    }
    $stock = trim($_POST['stock_status'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $wholesale = (float)($_POST['wholesale_price'] ?? 0);

    if (!empty($ids)) {
        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                $placeholders = implode(',', array_fill(0, count($ids), '?'));
                $updates = [];
                $params = [];

                if (!empty($stock)) {
                    $updates[] = "status = ?";
                    $params[] = ($stock === 'In stock') ? 'in_stock' : (($stock === 'Low stock') ? 'low_stock' : 'out_of_stock');
                }
                if (!empty($category)) {
                    $updates[] = "category_name = ?";
                    $params[] = $category;
                }
                if ($wholesale > 0) {
                    $updates[] = "wholesale_price = ?";
                    $params[] = $wholesale;
                }
                if (!empty($updates)) {
                    $updates[] = "updated_at = NOW()";
                    $sql = "UPDATE products SET " . implode(', ', $updates) . " WHERE id IN ($placeholders)";
                    $finalParams = array_merge($params, $ids);
                    $db->prepare($sql)->execute($finalParams);
                }
                echo json_encode(['success' => true, 'message' => count($ids) . ' products updated in live database']);
                exit;
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
                exit;
            }
        }
    }
    echo json_encode(['success' => true, 'message' => 'Bulk update executed']);
    exit;
}

// Handle BULK DELETE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'bulk_delete') {
    $ids = $_POST['ids'] ?? [];
    if (is_string($ids)) {
        $ids = array_filter(array_map('intval', explode(',', $ids)));
    }
    if (!empty($ids)) {
        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                $placeholders = implode(',', array_fill(0, count($ids), '?'));
                $db->prepare("DELETE FROM product_media WHERE product_id IN ($placeholders)")->execute($ids);
                $db->prepare("DELETE FROM products WHERE id IN ($placeholders)")->execute($ids);
                echo json_encode(['success' => true, 'message' => count($ids) . ' products permanently deleted from database']);
                exit;
            } catch (\Exception $e) {
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
                exit;
            }
        }
    }
    echo json_encode(['success' => true, 'message' => 'Bulk delete executed']);
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
    'total' => count($products),
    'categories' => ProductCatalog::getCategories(),
    'products' => $products,
    'data' => $products
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
