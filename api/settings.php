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

// In-memory fallback if database is in mock mode or CLI environment
$mockDefaults = [
    'site_name' => "DT Brand's (Jai Hanuman Tex)",
    'store_title' => "DT Brand's (Jai Hanuman Tex)",
    'store_tagline' => 'Premium Ethnic Wear, Reseller & Wholesale Hub',
    'support_phone' => '917046363528',
    'support_email' => 'support@jaihanumantex.in',
    'whatsapp_number' => '+91 70463 63528',
    'company_legal_name' => "Jai Hanuman Tex (DT Brand's)",
    'company_gstin' => '24AAACV1234F1Z5',
    'company_address' => 'Ring Road Textile Market, Surat, Gujarat - 395002',
    'company_state' => 'Gujarat',
    'company_pincode' => '395002',
    'order_prefix' => 'DT-ORD-',
    'free_shipping_threshold' => '0',
    'flat_shipping_retail' => '150',
    'flat_shipping_trade' => '250',
    'default_courier' => 'Delhivery Express'
];

if ($pdo === null || Database::isMockMode()) {
    if ($method === 'POST') {
        $payload = json_decode((string)file_get_contents('php://input'), true) ?: $_POST;
        $kv = $payload['settings'] ?? null;
        if (!is_array($kv) || empty($kv)) {
            if (isset($payload['key_name'])) {
                $kv = [$payload['key_name'] => $payload['value'] ?? ''];
            } elseif (is_array($payload)) {
                $candidate = [];
                foreach ($payload as $k => $v) {
                    if (!in_array($k, ['action', 'csrf_token', 'save_settings'], true) && is_string($k) && strlen($k) <= 100) {
                        $candidate[$k] = $v;
                    }
                }
                if (!empty($candidate)) $kv = $candidate;
            }
        }
        $saved = count($kv ?? []);
        echo json_encode(['success' => true, 'saved' => $saved, 'mock' => true, 'message' => $saved . ' setting(s) saved successfully.']);
        exit;
    }

    $singleKey = trim((string)($_GET['key'] ?? ''));
    if ($singleKey !== '') {
        echo json_encode(['success' => true, 'key' => $singleKey, 'value' => $mockDefaults[$singleKey] ?? null, 'mock' => true]);
        exit;
    }

    echo json_encode(['success' => true, 'count' => count($mockDefaults), 'settings' => $mockDefaults, 'mock' => true]);
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
    if ($sessionRole !== 'super_admin' && $sessionRole !== 'admin') {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Only an Admin may change store settings.']);
        exit;
    }

    $payload = json_decode((string)file_get_contents('php://input'), true) ?: $_POST;
    $kv = $payload['settings'] ?? null;
    if (!is_array($kv) || empty($kv)) {
        if (isset($payload['key_name'])) {
            $kv = [$payload['key_name'] => $payload['value'] ?? ''];
        } elseif (is_array($payload)) {
            $candidate = [];
            foreach ($payload as $k => $v) {
                if (!in_array($k, ['action', 'csrf_token', 'save_settings'], true) && is_string($k) && strlen($k) <= 100) {
                    $candidate[$k] = $v;
                }
            }
            if (!empty($candidate)) {
                $kv = $candidate;
            }
        }
    }

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

        // Trace audit log
        if (file_exists(__DIR__ . '/../src/AuditManager.php')) {
            require_once __DIR__ . '/../src/AuditManager.php';
            try {
                \DTBrand\AuditManager::getInstance()->log('settings', 'update', "Saved {$saved} store setting(s)", [
                    'keys' => array_keys($kv),
                    'admin' => $_SESSION['admin_user']['email'] ?? 'admin'
                ]);
            } catch (\Throwable $ae) {}
        }

        echo json_encode(['success' => true, 'saved' => $saved, 'message' => $saved . ' setting(s) saved successfully.']);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

// GET list or single key
$singleKey = trim((string)($_GET['key'] ?? ''));
if ($singleKey !== '') {
    try {
        $stmt = $pdo->prepare('SELECT `value` FROM settings WHERE key_name = ? LIMIT 1');
        $stmt->execute([$singleKey]);
        $val = $stmt->fetchColumn();
        echo json_encode(['success' => true, 'key' => $singleKey, 'value' => $val !== false ? $val : null]);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

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