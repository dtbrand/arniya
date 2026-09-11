<?php
/**
 * DT Brand's & Jai Hanuman Tex — Section 32: Integrations REST API
 * Secure management endpoint for third-party integrations, health checks,
 * safe diagnostics, and connection testing.
 *
 * Mandate: NEVER expose API secrets, passwords, tokens, or private keys.
 */

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
}

// Security Guard & Session
$is_cli = (php_sapi_name() === 'cli' || empty($_SERVER['REMOTE_ADDR']));
if (!$is_cli) {
    $guardFile = __DIR__ . '/../admin/includes/adminguard.php';
    if (!is_file($guardFile)) {
        $guardFile = ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/admin/includes/adminguard.php';
    }
    if (is_file($guardFile)) {
        require_once $guardFile;
    }
}

// Database Connection
$pdo = null;
$dbFile = __DIR__ . '/../config/database.php';
if (!is_file($dbFile)) {
    $dbFile = __DIR__ . '/../includes/db.php';
}
if (is_file($dbFile)) {
    try {
        require_once $dbFile;
        if (isset($pdo) && $pdo instanceof PDO) {
            // using existing $pdo
        } elseif (isset($conn) && $conn instanceof PDO) {
            $pdo = $conn;
        } elseif (defined('DB_HOST') && defined('DB_NAME') && defined('DB_USER') && defined('DB_PASS')) {
            $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }
    } catch (Exception $e) {
        $pdo = null;
    }
}

require_once __DIR__ . '/../src/IntegrationManager.php';
use DT\Services\IntegrationManager;

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
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
