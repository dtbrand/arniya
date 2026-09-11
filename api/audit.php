<?php
/**
 * api/audit.php — DT Brand's & Jai Hanuman Tex Central Enterprise Audit REST API
 * Section 35: Central Enterprise Audit Log Admin
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/_guard.php';
require_once __DIR__ . '/../src/AuditManager.php';

use DTBrand\AuditManager;

$auditManager = AuditManager::getInstance();
$action = isset($_GET['action']) ? strtolower(trim($_GET['action'])) : (isset($_POST['action']) ? strtolower(trim($_POST['action'])) : 'logs');

// 1. CSV Stream Export Handler
if ($action === 'export') {
    $filters = [
        'search'         => $_GET['search'] ?? '',
        'entity_type'    => $_GET['entity_type'] ?? '',
        'action'         => $_GET['action_filter'] ?? '',
        'status'         => $_GET['status'] ?? '',
        'actor'          => $_GET['actor'] ?? '',
        'correlation_id' => $_GET['correlation_id'] ?? '',
        'date_from'      => $_GET['date_from'] ?? '',
        'date_to'        => $_GET['date_to'] ?? '',
    ];

    $csv = $auditManager->exportCsv($filters);
    $filename = "audit_log_export_" . date('Ymd_His') . ".csv";

    if (!headers_sent()) {
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate');
    }
    echo $csv;
    exit;
}

// 2. Ensure Admin Authentication for all API queries
if (function_exists('dt_api_is_admin') && !dt_api_is_admin() && php_sapi_name() !== 'cli') {
    http_response_code(401);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => false,
        'error'   => 'unauthorized',
        'message' => 'Administrative privileges required to access audit ledger.'
    ]);
    exit;
}

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
}

$sessionRole = strtolower((string)($_SESSION['admin_user']['role'] ?? $_SESSION['admin_role'] ?? 'admin'));
$adminName = (string)($_SESSION['admin_user']['name'] ?? 'Super Admin');
$currentAdminId = (int)($_SESSION['admin_user']['id'] ?? 1);

try {
    switch ($action) {
        case 'logs':
            $filters = [
                'search'         => $_GET['search'] ?? '',
                'entity_type'    => $_GET['entity_type'] ?? '',
                'action'         => $_GET['action_filter'] ?? '',
                'status'         => $_GET['status'] ?? '',
                'actor'          => $_GET['actor'] ?? '',
                'correlation_id' => $_GET['correlation_id'] ?? '',
                'date_from'      => $_GET['date_from'] ?? '',
                'date_to'        => $_GET['date_to'] ?? '',
                'page'           => isset($_GET['page']) ? (int)$_GET['page'] : 1,
                'limit'          => isset($_GET['limit']) ? (int)$_GET['limit'] : 50,
            ];
            $result = $auditManager->getLogs($filters);
            echo json_encode([
                'success' => true,
                'data'    => $result['items'],
                'total'   => $result['total'],
                'page'    => $result['page'],
                'limit'   => $result['limit'],
                'pages'   => $result['pages'],
            ]);
            break;

        case 'detail':
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if ($id <= 0) {
                echo json_encode(['success' => false, 'message' => 'Invalid audit log ID']);
                break;
            }
            $item = $auditManager->getLogById($id);
            if (!$item) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Audit log event not found']);
                break;
            }
            echo json_encode(['success' => true, 'data' => $item]);
            break;

        case 'stats':
            $stats = $auditManager->getAuditStats();
            echo json_encode(['success' => true, 'data' => $stats]);
            break;

        case 'trace':
            $corrId = trim((string)($_GET['correlation_id'] ?? ''));
            if ($corrId === '') {
                echo json_encode(['success' => false, 'message' => 'Correlation ID required']);
                break;
            }
            $trace = $auditManager->getCorrelationTrace($corrId);
            echo json_encode(['success' => true, 'correlation_id' => $corrId, 'data' => $trace, 'count' => count($trace)]);
            break;

        case 'entity_history':
            $entityType = trim((string)($_GET['entity_type'] ?? ''));
            $entityId = trim((string)($_GET['entity_id'] ?? ''));
            if ($entityType === '' || $entityId === '') {
                echo json_encode(['success' => false, 'message' => 'Entity type and entity ID required']);
                break;
            }
            $history = $auditManager->getEntityHistory($entityType, $entityId);
            echo json_encode(['success' => true, 'entity_type' => $entityType, 'entity_id' => $entityId, 'data' => $history, 'count' => count($history)]);
            break;

        case 'log':
            // Super-admin or staff with appropriate permission can record custom administrative events
            $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            if (empty($input['action']) || empty($input['entity_type']) || empty($input['entity_id'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Action, entity_type, and entity_id are required fields.']);
                break;
            }

            $input['user_id'] = $currentAdminId;
            $input['user_name'] = $adminName;
            $input['actor_role'] = $sessionRole;

            $newId = $auditManager->log($input);
            echo json_encode(['success' => true, 'message' => 'Event recorded in audit ledger.', 'log_id' => $newId]);
            break;

        case 'purge':
            // Super admin check
            if ($sessionRole !== 'super_admin' && $sessionRole !== 'owner') {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Access Denied: Only Super Administrators may execute audit retention purges.']);
                break;
            }

            $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;
            $retentionDays = isset($input['retention_days']) ? (int)$input['retention_days'] : 90;

            try {
                $purged = $auditManager->purgeOldLogs($retentionDays, $adminName);
                echo json_encode([
                    'success' => true,
                    'message' => "Purged {$purged} audit records older than {$retentionDays} days.",
                    'deleted_count' => $purged,
                ]);
            } catch (\InvalidArgumentException $e) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            break;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => "Unsupported audit API action '{$action}'."]);
            break;
    }
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => 'server_error',
        'message' => $e->getMessage(),
    ]);
}
