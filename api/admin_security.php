<?php
/**
 * api/admin_security.php — DT Brand's & Jai Hanuman Tex Admin Security & Roles REST API
 * Section 34: Admin Users / Roles / Permissions
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/_guard.php';
require_once __DIR__ . '/../src/AdminSecurityManager.php';

use DTBrand\AdminSecurityManager;

$manager = AdminSecurityManager::getInstance();
$action = isset($_GET['action']) ? strtolower(trim($_GET['action'])) : (isset($_POST['action']) ? strtolower(trim($_POST['action'])) : 'overview');

// For CSV log export action
if ($action === 'export_logs') {
    $type = isset($_GET['type']) ? strtolower(trim($_GET['type'])) : 'login';
    $csv = $manager->exportAuditCsv($type);
    $filename = "security_{$type}_audit_" . date('Ymd_His') . ".csv";

    if (!headers_sent()) {
        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate');
    }
    echo $csv;
    exit;
}

// Ensure admin authentication for all API requests
if (function_exists('dt_api_is_admin') && !dt_api_is_admin() && php_sapi_name() !== 'cli') {
    http_response_code(401);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => false,
        'error' => 'unauthorized',
        'message' => 'Admin sign-in required to access security intelligence.'
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
        case 'overview':
        case 'stats':
            $overview = $manager->getSecurityOverview();
            echo json_encode(['success' => true, 'action' => $action, 'data' => $overview]);
            break;

        case 'users':
            $users = $manager->getAdminUsers();
            echo json_encode(['success' => true, 'action' => $action, 'count' => count($users), 'data' => $users]);
            break;

        case 'create_user':
            if ($sessionRole !== 'super_admin' && php_sapi_name() !== 'cli') {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Only Super Admin may create new administrative staff accounts.']);
                break;
            }
            $res = $manager->createAdminUser($_POST, $adminName);
            echo json_encode($res);
            break;

        case 'update_user':
            if ($sessionRole !== 'super_admin' && php_sapi_name() !== 'cli') {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Only Super Admin may modify administrative accounts.']);
                break;
            }
            $id = (int)($_POST['id'] ?? 0);
            $res = $manager->updateAdminUser($id, $_POST, $adminName);
            echo json_encode($res);
            break;

        case 'toggle_user_status':
            if ($sessionRole !== 'super_admin' && php_sapi_name() !== 'cli') {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Only Super Admin may activate/deactivate accounts.']);
                break;
            }
            $id = (int)($_POST['id'] ?? 0);
            $res = $manager->toggleUserStatus($id, $adminName);
            echo json_encode($res);
            break;

        case 'reset_password':
            if ($sessionRole !== 'super_admin' && php_sapi_name() !== 'cli') {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Only Super Admin may reset staff passwords.']);
                break;
            }
            $id = (int)($_POST['id'] ?? 0);
            $newPass = (string)($_POST['password'] ?? '');
            $res = $manager->resetUserPassword($id, $newPass, $adminName);
            echo json_encode($res);
            break;

        case 'delete_user':
            if ($sessionRole !== 'super_admin' && php_sapi_name() !== 'cli') {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Only Super Admin may delete staff accounts.']);
                break;
            }
            $id = (int)($_POST['id'] ?? 0);
            if ($id === $currentAdminId) {
                echo json_encode(['success' => false, 'message' => 'You cannot delete your own active administrator account.']);
                break;
            }
            $res = $manager->deleteAdminUser($id, $adminName);
            echo json_encode($res);
            break;

        case 'roles':
            $roles = $manager->getRoles();
            echo json_encode(['success' => true, 'action' => $action, 'data' => $roles]);
            break;

        case 'role_permissions':
            $roleSlug = strtolower(trim((string)($_GET['role'] ?? $_POST['role'] ?? 'admin')));
            $perms = $manager->getRolePermissions($roleSlug);
            echo json_encode(['success' => true, 'action' => $action, 'role' => $roleSlug, 'data' => $perms]);
            break;

        case 'save_permissions':
            if ($sessionRole !== 'super_admin' && php_sapi_name() !== 'cli') {
                http_response_code(403);
                echo json_encode(['success' => false, 'message' => 'Only Super Admin may modify the role permission matrix.']);
                break;
            }
            $roleSlug = strtolower(trim((string)($_POST['role'] ?? '')));
            $rawMatrix = $_POST['permissions'] ?? [];
            if (is_string($rawMatrix)) {
                $rawMatrix = json_decode($rawMatrix, true) ?: [];
            }
            $res = $manager->saveRolePermissions($roleSlug, (array)$rawMatrix, $adminName);
            echo json_encode($res);
            break;

        case 'permissions':
            $all = $manager->getAllPermissions();
            echo json_encode(['success' => true, 'action' => $action, 'data' => $all]);
            break;

        case 'sessions':
            $sessions = $manager->getActiveSessions();
            echo json_encode(['success' => true, 'action' => $action, 'count' => count($sessions), 'data' => $sessions]);
            break;

        case 'revoke_session':
            $sessionId = trim((string)($_POST['session_id'] ?? ''));
            if ($sessionId === '') {
                echo json_encode(['success' => false, 'message' => 'Session identifier required.']);
                break;
            }
            $ok = $manager->revokeSession($sessionId, $adminName);
            echo json_encode(['success' => $ok, 'message' => $ok ? 'Session successfully terminated.' : 'Failed to revoke session.']);
            break;

        case 'revoke_all_other_sessions':
            $currentSessId = session_id();
            $count = $manager->revokeAllOtherSessions($currentAdminId, $currentSessId, $adminName);
            echo json_encode(['success' => true, 'revoked_count' => $count, 'message' => "Successfully terminated {$count} other active session(s)."]);
            break;

        case 'login_audit':
            $logins = $manager->getLoginAudit($_GET);
            $loginStats = $manager->getLoginStats();
            echo json_encode(['success' => true, 'action' => $action, 'stats' => $loginStats, 'data' => $logins]);
            break;

        case 'security_events':
            $events = $manager->getSecurityEvents($_GET);
            echo json_encode(['success' => true, 'action' => $action, 'count' => count($events), 'data' => $events]);
            break;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'invalid_action', 'message' => "Unsupported action '{$action}'."]);
            break;
    }
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'server_exception',
        'message' => 'An internal error occurred: ' . $e->getMessage()
    ]);
}
