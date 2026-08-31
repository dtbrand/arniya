<?php
/**
 * api/settings.php — Store Settings Key-Value API
 * DT Brand's & Jai Hanuman Tex
 *
 * Backs admin/settings/. The four settings pages rendered hardcoded inputs
 * (two of them readonly, the rest with no inputs at all) and Save buttons
 * that only raised toasts. The `settings` key-value table ships with the
 * 2026_08_30 migration — this endpoint makes it usable.
 *
 * Reads are admin-gated (settings can contain operational secrets like
 * dispatch phone numbers). Writes are super_admin-gated, mirroring
 * api/users.php.
 *
 * Actions (POST): save (key_value JSON)   Action (GET): list
 */

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\Database;

dt_api_require_admin('read or change store settings');

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$pdo = Database::getConnection();

if ($pdo === null || Database::isMockMode()) {
    http_response_code(503);
    echo json_encode(['success' => false, 'error' => 'database_unavailable', 'message' => 'The database is unreachable, so the request was not processed.']);
    exit;
}

// Self-heal for installs predating the 2026_08_30 migration.
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `settings` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `key_name` VARCHAR(100) NOT NULL UNIQUE,
        `value` TEXT NULL,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
} catch (\Throwable $e) {
}

if ($method === 'POST') {
    $sessionRole = strtolower((string)($_SESSION['admin_user']['role'] ?? ''));
    if ($sessionRole !== 'super_admin') {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Only a Super Admin may change store settings.']);
        exit;
    }

    $payload = json_decode((string)file_get_contents('php://input'), true) ?: $_POST;
    $kv = $payload['settings'] ?? null;
    if (!is_array($kv) || empty($kv)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'No settings supplied. Send settings: { key: value, … }.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare(
            'INSERT INTO settings (key_name, `value`) VALUES (?, ?)
             ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)'
        );
        $saved = 0;
        foreach ($kv as $k => $v) {
            $key = trim((string)$k);
            if ($key === '' || strlen($key) > 100) continue;
            $stmt->execute([$key, is_scalar($v) ? (string)$v : json_encode($v, JSON_UNESCAPED_UNICODE)]);
            $saved++;
        }
        echo json_encode(['success' => true, 'saved' => $saved, 'message' => $saved . ' setting(s) saved.']);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

// GET list
try {
    $rows = Database::query('SELECT key_name, `value`, updated_at FROM settings ORDER BY key_name ASC');
    $map = [];
    foreach ($rows as $r) {
        $map[$r['key_name']] = $r['value'];
    }
    echo json_encode(['success' => true, 'count' => count($rows), 'settings' => $map, 'rows' => $rows]);
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}