<?php
/**
 * api/attributes.php — Product Attributes & Taxonomies REST API Engine
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

require_once __DIR__ . '/../src/Database.php';
use DTBrand\Database;

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';

// Creating, renaming or deleting an attribute mutates the shared product
// taxonomy, so it is admin-only. Reading the list stays public so storefront
// filters keep working. Before this guard existed, any visitor could POST to
// this endpoint and rewrite or wipe the taxonomy.
require_once __DIR__ . '/_guard.php';
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || in_array($action, ['create', 'update', 'delete', 'add_term', 'remove_term'], true)) {
    dt_api_require_admin('change product attributes');
}

// Handle CREATE Attribute
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create') {
    $name = trim($_POST['name'] ?? '');
    if (empty($name)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Attribute name is required']);
        exit;
    }

    $slug = trim($_POST['slug'] ?? '') ?: strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name));
    $type = trim($_POST['type'] ?? 'Text Badge / Pill');
    $values = trim($_POST['values'] ?? '[]');

    $db = Database::getConnection();
    if ($db !== null && !Database::isMockMode()) {
        try {
            // Check or create table if not exists
            $db->exec("CREATE TABLE IF NOT EXISTS product_attributes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(150) NOT NULL,
                slug VARCHAR(150) NOT NULL UNIQUE,
                type VARCHAR(100) DEFAULT 'Text Badge / Pill',
                values_json TEXT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $stmt = $db->prepare("INSERT INTO product_attributes (name, slug, type, values_json) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE name = VALUES(name), type = VALUES(type), values_json = VALUES(values_json)");
            $stmt->execute([$name, $slug, $type, $values]);
            $newId = (int)$db->lastInsertId();

            echo json_encode(['success' => true, 'message' => "Attribute '{$name}' saved successfully in database", 'id' => $newId]);
            exit;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }

    http_response_code(503);
    echo json_encode(['success' => false, 'error' => 'database_unavailable', 'message' => 'The database is unreachable, so the attribute was not saved.']);
    exit;
}

// Handle UPDATE Attribute
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'update') {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $type = trim($_POST['type'] ?? '');

    $db = Database::getConnection();
    if ($db !== null && !Database::isMockMode()) {
        try {
            $stmt = $db->prepare("UPDATE product_attributes SET name = COALESCE(NULLIF(?, ''), name), slug = COALESCE(NULLIF(?, ''), slug), type = COALESCE(NULLIF(?, ''), type) WHERE id = ?");
            $stmt->execute([$name, $slug, $type, $id]);
            echo json_encode(['success' => true, 'message' => 'Attribute updated successfully', 'id' => $id]);
            exit;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }
    echo json_encode(['success' => false, 'error' => 'database_unavailable', 'message' => 'The database is unreachable, so the attribute was not updated.']);
    exit;
}

// Handle DELETE Attribute
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    $db = Database::getConnection();
    if ($db !== null && !Database::isMockMode()) {
        try {
            $stmt = $db->prepare("DELETE FROM product_attributes WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true, 'message' => 'Attribute deleted successfully', 'id' => $id]);
            exit;
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    }
    echo json_encode(['success' => false, 'error' => 'database_unavailable', 'message' => 'The database is unreachable, so the attribute was not deleted.']);
    exit;
}

// Terms live inside the attribute's values_json column as
// [{"name":"Crimson Red","hex":"#991b1b"}, …]. Add/remove rewrite that JSON.
$db = Database::getConnection();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'add_term' || $action === 'remove_term')) {
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Attribute id is required']);
        exit;
    }
    if ($db === null || Database::isMockMode()) {
        http_response_code(503);
        echo json_encode(['success' => false, 'error' => 'database_unavailable', 'message' => 'The database is unreachable, so the term was not changed.']);
        exit;
    }

    try {
        $row = Database::fetchOne('SELECT values_json FROM product_attributes WHERE id = ? LIMIT 1', [$id]);
        if (!$row) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'No attribute found with id ' . $id . '.']);
            exit;
        }
        $terms = json_decode((string)($row['values_json'] ?? '[]'), true);
        if (!is_array($terms)) {
            $terms = [];
        }

        if ($action === 'add_term') {
            $termName = trim((string)($_POST['term_name'] ?? ''));
            if ($termName === '') {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Term name is required.']);
                exit;
            }
            $hex = trim((string)($_POST['hex'] ?? ''));
            // A term may be a swatch (hex) or a plain value — both are valid.
            $terms[] = ['name' => $termName, 'hex' => $hex !== '' ? $hex : null];
            $msg = 'Term "' . $termName . '" added.';
        } else {
            $termName = trim((string)($_POST['term_name'] ?? ''));
            $hex = trim((string)($_POST['hex'] ?? ''));
            $before = count($terms);
            $terms = array_values(array_filter($terms, static function (array $t) use ($termName, $hex): bool {
                $sameName = strcasecmp((string)($t['name'] ?? ''), $termName) === 0;
                $sameHex = $hex === '' || strcasecmp((string)($t['hex'] ?? ''), $hex) === 0;
                return !($sameName && $sameHex);
            }));
            if (count($terms) === $before) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'No matching term found to remove.']);
                exit;
            }
            $msg = 'Term removed.';
        }

        $stmt = $db->prepare('UPDATE product_attributes SET values_json = ? WHERE id = ?');
        $stmt->execute([json_encode($terms, JSON_UNESCAPED_UNICODE), $id]);
        echo json_encode(['success' => true, 'id' => $id, 'terms' => $terms, 'message' => $msg]);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

// Handle LIST
$db = Database::getConnection();
$list = [];
if ($db !== null && !Database::isMockMode()) {
    try {
        $rows = Database::query("SELECT * FROM product_attributes ORDER BY id ASC");
        if (!empty($rows)) {
            $list = $rows;
        }
    } catch (\Exception $e) {}
}

echo json_encode(['success' => true, 'count' => count($list), 'data' => $list]);
