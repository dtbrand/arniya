<?php
/**
 * DT Brand's & Jai Hanuman Tex — Section 32: Integrations REST API
 * Secure management endpoint for third-party integrations, health checks,
 * safe diagnostics, and connection testing.
 *
 * Mandate: NEVER expose API secrets, passwords, tokens, or private keys.
 */

require_once __DIR__ . '/cors.php';
cors_json();

require_once __DIR__ . '/_guard.php';
dt_api_require_admin('manage integrations');

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/IntegrationManager.php';

use DTBrand\Database;
use DT\Services\IntegrationManager;

$pdo = Database::getConnection();
$manager = IntegrationManager::getInstance($pdo);

// Request Parsing
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method === 'POST') {
    $rawInput = file_get_contents('php://input');
    if (!empty($rawInput)) {
        $jsonData = json_decode($rawInput, true);
        if (is_array($jsonData)) {
            $_POST = array_merge($_POST, $jsonData);
        }
    }
}

$action = $_POST['action'] ?? ($_GET['action'] ?? 'stats');

if ($method === 'POST' && in_array($action, ['toggle', 'save_config'], true)) {
    dt_api_require_csrf();
}

try {
    switch ($action) {
        case 'stats':
            $stats = $manager->getStats();
            echo json_encode(['success' => true, 'stats' => $stats]);
            break;

        case 'list':
            $category = $_GET['category'] ?? ($_POST['category'] ?? 'all');
            $items = $manager->getAll($category);
            echo json_encode(['success' => true, 'count' => count($items), 'integrations' => $items]);
            break;

        case 'detail':
            $slug = $_GET['slug'] ?? ($_POST['slug'] ?? '');
            if (empty($slug)) {
                echo json_encode(['success' => false, 'message' => 'Missing integration slug']);
                break;
            }
            $item = $manager->getBySlug($slug);
            if (!$item) {
                echo json_encode(['success' => false, 'message' => 'Integration not found']);
                break;
            }
            echo json_encode(['success' => true, 'integration' => $item]);
            break;

        case 'test_connection':
            $slug = $_POST['slug'] ?? ($_GET['slug'] ?? '');
            if (empty($slug)) {
                echo json_encode(['success' => false, 'message' => 'Missing integration slug']);
                break;
            }
            $res = $manager->testConnection($slug);
            echo json_encode($res);
            break;

        case 'diagnostics':
        case 'run_diagnostics':
            $slug = $_GET['slug'] ?? ($_POST['slug'] ?? '');
            if (empty($slug)) {
                echo json_encode(['success' => false, 'message' => 'Missing integration slug']);
                break;
            }
            $diag = $manager->runDiagnostics($slug);
            echo json_encode($diag);
            break;

        case 'toggle':
            $slug = $_POST['slug'] ?? '';
            $enabled = isset($_POST['is_enabled']) ? (bool)$_POST['is_enabled'] : true;
            if (empty($slug)) {
                echo json_encode(['success' => false, 'message' => 'Missing integration slug']);
                break;
            }
            $ok = $manager->toggleStatus($slug, $enabled);
            echo json_encode([
                'success' => $ok,
                'slug' => $slug,
                'is_enabled' => $enabled ? 1 : 0,
                'message' => $ok ? "Integration status successfully updated to " . ($enabled ? 'active' : 'inactive') : "Failed to update status"
            ]);
            break;

        case 'save_config':
            $slug = $_POST['slug'] ?? '';
            $config = $_POST['config'] ?? [];
            if (empty($slug)) {
                echo json_encode(['success' => false, 'message' => 'Missing integration slug']);
                break;
            }
            if (!is_array($config)) {
                $config = json_decode((string)$config, true) ?: [];
            }
            $saved = $manager->saveConfig($slug, $config);
            echo json_encode([
                'success' => $saved,
                'slug' => $slug,
                'message' => $saved ? "Configuration for {$slug} saved securely." : "Failed to save configuration."
            ]);
            break;

        case 'logs':
            $slug = $_GET['slug'] ?? null;
            $status = $_GET['status'] ?? null;
            $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
            $logs = $manager->getLogs($slug, $status, $limit);
            echo json_encode(['success' => true, 'count' => count($logs), 'logs' => $logs]);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Unknown action: ' . htmlspecialchars($action)]);
            break;
    }
} catch (\Throwable $e) {
    dt_api_error_response($e, 500, 'integrations_api');
}
