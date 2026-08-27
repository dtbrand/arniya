<?php
/**
 * api/brands.php — Product Brands REST API Engine
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

require_once __DIR__ . '/../src/Database.php';
use DTBrand\Database;

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';

// Creating, renaming or deleting a brand mutates shared catalogue data, so it is
// admin-only. Reading the list stays public so storefront filters keep working.
// Before this guard existed, any visitor could POST here and wipe the brands.
require_once __DIR__ . '/_guard.php';
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || in_array($action, ['create', 'update', 'delete'], true)) {
    dt_api_require_admin('change product brands');
}

// Handle CREATE Brand
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create') {
    $name = trim($_POST['name'] ?? '');
    if (empty($name)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Brand name is required']);
        exit;
    }

    $slug = trim($_POST['slug'] ?? '') ?: strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name));
    $desc = trim($_POST['description'] ?? '');
    $logo = trim($_POST['logo_url'] ?? '');

    $db = Database::getConnection();
    if ($db !== null && !Database::isMockMode()) {
        try {
            $db->exec("CREATE TABLE IF NOT EXISTS product_brands (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(150) NOT NULL,
                slug VARCHAR(150) NOT NULL UNIQUE,
                description TEXT NULL,
                logo_url VARCHAR(255) NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $stmt = $db->prepare("INSERT INTO product_brands (name, slug, description, logo_url) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE name = VALUES(name), description = VALUES(description), logo_url = VALUES(logo_url)");
            $stmt->execute([$name, $slug, $desc, $logo]);
            $newId = (int)$db->lastInsertId();

            echo json_encode(['success' => true, 'message' => "Brand '{$name}' saved successfully in database", 'id' => $newId]);
            exit;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }

    echo json_encode(['success' => true, 'message' => "Brand '{$name}' saved"]);
    exit;
}

// Handle UPDATE Brand
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update') {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $desc = trim($_POST['description'] ?? '');

    $db = Database::getConnection();
    if ($db !== null && !Database::isMockMode()) {
        try {
            $stmt = $db->prepare("UPDATE product_brands SET name = COALESCE(NULLIF(?, ''), name), slug = COALESCE(NULLIF(?, ''), slug), description = COALESCE(NULLIF(?, ''), description) WHERE id = ?");
            $stmt->execute([$name, $slug, $desc, $id]);
            echo json_encode(['success' => true, 'message' => 'Brand updated successfully', 'id' => $id]);
            exit;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }
    echo json_encode(['success' => true, 'message' => 'Brand updated', 'id' => $id]);
    exit;
}

// Handle DELETE Brand
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    $db = Database::getConnection();
    if ($db !== null && !Database::isMockMode()) {
        try {
            $stmt = $db->prepare("DELETE FROM product_brands WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true, 'message' => 'Brand deleted successfully', 'id' => $id]);
            exit;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }
    echo json_encode(['success' => true, 'message' => 'Brand deleted', 'id' => $id]);
    exit;
}

// Handle LIST
$db = Database::getConnection();
$list = [];
if ($db !== null && !Database::isMockMode()) {
    try {
        $rows = Database::query("SELECT * FROM product_brands ORDER BY id ASC");
        if (!empty($rows)) {
            $list = $rows;
        }
    } catch (\Exception $e) {}
}

if (empty($list)) {
    $list = [
        ['id' => 1, 'name' => 'DT Signature', 'slug' => 'dt-signature', 'description' => 'Pure Mulberry Gold Zari Handloom Collection', 'products_count' => 840],
        ['id' => 2, 'name' => 'Arniya Heritage', 'slug' => 'arniya-heritage', 'description' => 'Royal Varanasi & Katan Silk Brocades', 'products_count' => 620],
        ['id' => 3, 'name' => 'DT Couture', 'slug' => 'dt-couture', 'description' => 'Designer Bridal Lehengas & Handcrafted Ensembles', 'products_count' => 380]
    ];
}

echo json_encode(['success' => true, 'count' => count($list), 'data' => $list]);
