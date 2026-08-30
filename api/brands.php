<?php
/**
 * api/brands.php — Product Brands REST API & Logo Upload Engine
 * DT Brand's & Jai Hanuman Tex
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');

require_once __DIR__ . '/../src/Database.php';
use DTBrand\Database;

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';

// Creating, renaming or deleting a brand mutates shared catalogue data, so it is admin-only.
require_once __DIR__ . '/_guard.php';
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || in_array($action, ['create', 'update', 'delete', 'upload_logo'], true)) {
    dt_api_require_admin('change product brands');
}

$db = Database::getConnection();

// Helper to handle uploaded brand logo file
function handle_brand_logo_upload(string $slugPrefix = 'brand'): string {
    $uploadedFile = $_FILES['logo'] ?? $_FILES['brand_logo'] ?? $_FILES['logo_file'] ?? null;
    if (!$uploadedFile || !isset($uploadedFile['tmp_name']) || empty($uploadedFile['tmp_name']) || $uploadedFile['error'] !== UPLOAD_ERR_OK) {
        return '';
    }

    $uploadDir = dirname(__DIR__) . '/assets/images/brands';
    if (!is_dir($uploadDir)) {
        @mkdir($uploadDir, 0775, true);
    }

    $filename = basename($uploadedFile['name']);
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allowed = ['png', 'jpg', 'jpeg', 'webp', 'svg', 'gif', 'avif'];
    if (!in_array($ext, $allowed, true)) {
        $ext = 'png';
    }

    $safeSlug = preg_replace('/[^a-z0-9]+/', '_', strtolower($slugPrefix));
    if (empty($safeSlug)) { $safeSlug = 'brand'; }
    $newFilename = $safeSlug . '_' . time() . '_' . substr(bin2hex(random_bytes(4)), 0, 6) . '.' . $ext;
    $targetPath = $uploadDir . '/' . $newFilename;

    if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
        return '/assets/images/brands/' . $newFilename;
    }
    return '';
}

// ── 1. Create Brand ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'create') {
    dt_api_require_admin('change product brands');
    $name = trim((string)($_POST['name'] ?? ''));
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

    $slug = trim((string)($_POST['slug'] ?? '')) ?: strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name));
    $desc = trim((string)($_POST['description'] ?? ''));
    $tier = trim((string)($_POST['tier'] ?? 'Primary Flagship'));
    $status = trim((string)($_POST['status'] ?? 'active'));
    if (!in_array($status, ['active', 'inactive'], true)) { $status = 'active'; }

    // Handle logo file or logo_url
    $uploadedLogo = handle_brand_logo_upload($slug);
    $logo = $uploadedLogo !== '' ? $uploadedLogo : trim((string)($_POST['logo_url'] ?? ''));

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

        $stmt = $db->prepare("INSERT INTO product_brands (name, slug, description, logo_url, tier, status) VALUES (?, ?, ?, ?, ?, ?)
                              ON DUPLICATE KEY UPDATE name = VALUES(name), description = VALUES(description), logo_url = IF(VALUES(logo_url) != '', VALUES(logo_url), logo_url), tier = VALUES(tier), status = VALUES(status)");
        $stmt->execute([$name, $slug, $desc, $logo, $tier, $status]);
        $newId = (int)$db->lastInsertId();

        echo json_encode([
            'success' => true,
            'message' => "Brand '{$name}' saved successfully in database",
            'id' => $newId,
            'logo_url' => $logo
        ]);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

// ── 2. Update Brand ──
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

    $name = trim((string)($_POST['name'] ?? ''));
    $slug = trim((string)($_POST['slug'] ?? ''));
    $desc = trim((string)($_POST['description'] ?? ''));
    $tier = trim((string)($_POST['tier'] ?? ''));
    $status = trim((string)($_POST['status'] ?? ''));

    // Handle logo file or logo_url
    $uploadedLogo = handle_brand_logo_upload($slug ?: ('brand_' . $id));
    $logoUrlInput = trim((string)($_POST['logo_url'] ?? ''));
    $newLogo = $uploadedLogo !== '' ? $uploadedLogo : $logoUrlInput;

    try {
        if ($newLogo !== '') {
            $stmt = $db->prepare("UPDATE product_brands SET
                name = COALESCE(NULLIF(?, ''), name),
                slug = COALESCE(NULLIF(?, ''), slug),
                description = COALESCE(NULLIF(?, ''), description),
                tier = COALESCE(NULLIF(?, ''), tier),
                status = COALESCE(NULLIF(?, ''), status),
                logo_url = ?
                WHERE id = ?");
            $stmt->execute([$name, $slug, $desc, $tier, $status, $newLogo, $id]);
        } else {
            $stmt = $db->prepare("UPDATE product_brands SET
                name = COALESCE(NULLIF(?, ''), name),
                slug = COALESCE(NULLIF(?, ''), slug),
                description = COALESCE(NULLIF(?, ''), description),
                tier = COALESCE(NULLIF(?, ''), tier),
                status = COALESCE(NULLIF(?, ''), status)
                WHERE id = ?");
            $stmt->execute([$name, $slug, $desc, $tier, $status, $id]);
        }

        echo json_encode([
            'success' => true,
            'message' => 'Brand updated successfully',
            'id' => $id,
            'logo_url' => $newLogo
        ]);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

// ── 3. Standalone Logo Upload ──
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'upload_logo') {
    dt_api_require_admin('change product brands');
    $brandId = (int)($_POST['id'] ?? 0);
    $slugPrefix = trim((string)($_POST['slug'] ?? 'brand'));
    $logoUrl = handle_brand_logo_upload($slugPrefix);

    if ($logoUrl === '') {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'No valid image file uploaded']);
        exit;
    }

    if ($brandId > 0 && $db !== null && !Database::isMockMode()) {
        try {
            $stmt = $db->prepare("UPDATE product_brands SET logo_url = ? WHERE id = ?");
            $stmt->execute([$logoUrl, $brandId]);
        } catch (\Throwable $e) {
            // non-fatal, logo still saved on disk
        }
    }

    echo json_encode([
        'success' => true,
        'message' => 'Brand logo uploaded successfully',
        'logo_url' => $logoUrl
    ]);
    exit;
}

// ── 4. Delete Brand ──
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

// ── 5. List Brands (Public Read Path) ──
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