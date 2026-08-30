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
require_once __DIR__ . '/_guard.php';
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || in_array($action, ['create', 'update', 'delete'], true)) {
    dt_api_require_admin('change product brands');
}

$db = Database::getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create') {
    dt_api_require_admin('change product brands');
    $name = trim($_POST['name'] ?? '');
    if ($name === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Brand name is required']);
        exit;
    }

    if ($db === null || Database::isMockMode()) {
        http_response_code(503);
        echo json_encode(['success' => false, 'error' => 'database_unavailable', 'message' => 'Brand changes require a live database connection.']);
        exit;
    }

    $slug = trim($_POST['slug'] ?? '') ?: strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name));
    $desc = trim($_POST['description'] ?? '');
    $logo = trim($_POST['logo_url'] ?? '');
    $tier = trim($_POST['tier'] ?? '');

    try {
        $db->exec("CREATE TABLE IF NOT EXISTS product_brands (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(150) NOT NULL,
            slug VARCHAR(150) NOT NULL UNIQUE,
            description TEXT NULL,
            logo_url VARCHAR(255) NULL,
            status ENUM('active','inactive') NOT NULL DEFAULT 'active',
            tier VARCHAR(50) NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

        $stmt = $db->prepare("INSERT INTO product_brands (name, slug, description, logo_url, tier) VALUES (?, ?, ?, ?, ?)
                              ON DUPLICATE KEY UPDATE name = VALUES(name), description = VALUES(description), logo_url = VALUES(logo_url), tier = VALUES(tier)");
        $stmt->execute([$name, $slug, $desc, $logo, $tier]);
        $newId = (int)$db->lastInsertId();

        echo json_encode(['success' => true, 'message' => "Brand '{$name}' saved successfully in database", 'id' => $newId]);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update') {
    dt_api_require_admin('change product brands');
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Brand id is required']);
        exit;
    }
    if ($db === null || Database::isMockMode()) {
        http_response_code(503);
        echo json_encode(['success' => false, 'error' => 'database_unavailable', 'message' => 'Brand changes require a live database connection.']);
        exit;
    }

    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $tier = trim($_POST['tier'] ?? '');

    try {
        $stmt = $db->prepare("UPDATE product_brands SET
            name = COALESCE(NULLIF(?, ''), name),
            slug = COALESCE(NULLIF(?, ''), slug),
            description = COALESCE(NULLIF(?, ''), description),
            tier = COALESCE(NULLIF(?, ''), tier)
            WHERE id = ?");
        $stmt->execute([$name, $slug, $desc, $tier, $id]);
        echo json_encode(['success' => true, 'message' => 'Brand updated successfully', 'id' => $id]);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete') {
    dt_api_require_admin('change product brands');
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Brand id is required']);
        exit;
    }
    if ($db === null || Database::isMockMode()) {
        http_response_code(503);
        echo json_encode(['success' => false, 'error' => 'database_unavailable', 'message' => 'Brand changes require a live database connection.']);
        exit;
    }

    try {
        $stmt = $db->prepare("DELETE FROM product_brands WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Brand deleted successfully', 'id' => $id]);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

// Read path — public. Returns the live brands table only.
header('Content-Type: application/json; charset=utf-8');
if ($db === null || Database::isMockMode()) {
    echo json_encode(['success' => true, 'count' => 0, 'data' => [], 'note' => 'database_unavailable']);
    exit;
}

try {
    $rows = Database::query("SELECT id, name, slug, description, logo_url, status, tier, created_at, updated_at FROM product_brands ORDER BY id ASC");
    echo json_encode(['success' => true, 'count' => count($rows), 'data' => $rows]);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}