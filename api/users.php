<?php
/**
 * api/users.php — Admin & Staff Account Management API
 * DT Brand's & Jai Hanuman Tex
 *
 * Backs admin/users/. The roster pages were hardcoded (Gautam Sethi +
 * "Surat Dispatch Manager" literals, KPIs like "2 Accounts / 4 Accounts /
 * 2FA Active" from nowhere) and the Invite/Edit buttons only raised toasts.
 * The `users` table already exists (Auth::adminLogin authenticates against
 * it) — this endpoint makes it manageable.
 *
 * Writes are super-admin-only: an 'admin' or 'staff' login must not be able
 * to promote itself or delete the owner. Reads are admin-session gated.
 *
 * Actions (POST): create | update | delete | reset_password
 * Action (GET):   list (default)
 */

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\Database;

dt_api_require_admin('manage admin users');

// Only a super_admin may change account records.
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'GET') {
    $sessionRole = strtolower((string)($_SESSION['admin_user']['role'] ?? ''));
    if ($sessionRole !== 'super_admin') {
        http_response_code(403);
        echo json_encode(['success' => false, 'message' => 'Only a Super Admin may create, edit or delete staff accounts.']);
        exit;
    }
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$action = $_POST['action'] ?? $_GET['action'] ?? 'list';
$pdo = Database::getConnection();

if ($pdo === null || Database::isMockMode()) {
    http_response_code(503);
    echo json_encode(['success' => false, 'error' => 'database_unavailable', 'message' => 'The database is unreachable, so the request was not processed.']);
    exit;
}

// Self-heal the table on installs that predate the migration (same DDL Auth uses).
try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS `users` (
        `id` INT AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(150) NOT NULL,
        `email` VARCHAR(150) NOT NULL UNIQUE,
        `phone` VARCHAR(20) DEFAULT NULL,
        `password_hash` VARCHAR(255) NOT NULL,
        `role` ENUM('super_admin', 'admin', 'manager', 'staff') DEFAULT 'admin',
        `status` ENUM('active', 'inactive') DEFAULT 'active',
        `last_login` TIMESTAMP NULL DEFAULT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
} catch (\Throwable $e) {
    // If the table truly cannot be created the queries below will report it.
}

$validRoles = ['super_admin', 'admin', 'manager', 'staff'];

if ($method === 'POST' && $action === 'create') {
    $name = trim((string)($_POST['name'] ?? ''));
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $phone = trim((string)($_POST['phone'] ?? ''));
    $role = strtolower(trim((string)($_POST['role'] ?? 'staff')));
    $password = (string)($_POST['password'] ?? '');

    if ($name === '' || $email === '' || strlen($password) < 8) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Name, email and a password of at least 8 characters are required.']);
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'That email address is not valid.']);
        exit;
    }
    if (!in_array($role, $validRoles, true)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Unknown role.']);
        exit;
    }

    $dup = Database::fetchOne('SELECT id FROM users WHERE email = ? LIMIT 1', [$email]);
    if ($dup) {
        http_response_code(409);
        echo json_encode(['success' => false, 'message' => 'An account with that email already exists.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, phone, password_hash, role, status, created_at) VALUES (?, ?, ?, ?, ?, 'active', NOW())");
        $stmt->execute([$name, $email, $phone !== '' ? $phone : null, password_hash($password, PASSWORD_BCRYPT), $role]);
        echo json_encode(['success' => true, 'id' => (int)$pdo->lastInsertId(), 'message' => "Account '{$name}' created with role {$role}."]);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

if ($method === 'POST' && $action === 'update') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Account id is required.']);
        exit;
    }

    $row = Database::fetchOne('SELECT id, role FROM users WHERE id = ? LIMIT 1', [$id]);
    if (!$row) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'No such account.']);
        exit;
    }

    $sets = [];
    $params = [];
    $name = trim((string)($_POST['name'] ?? ''));
    if ($name !== '') { $sets[] = 'name = ?'; $params[] = $name; }
    $role = strtolower(trim((string)($_POST['role'] ?? '')));
    if ($role !== '') {
        if (!in_array($role, $validRoles, true)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Unknown role.']);
            exit;
        }
        // Never let the last super_admin be demoted by this endpoint.
        if ($row['role'] === 'super_admin' && $role !== 'super_admin') {
            $cnt = Database::fetchOne("SELECT COUNT(*) AS c FROM users WHERE role = 'super_admin' AND status = 'active'");
            if ((int)($cnt['c'] ?? 0) <= 1) {
                http_response_code(409);
                echo json_encode(['success' => false, 'message' => 'Cannot demote the only Super Admin account.']);
                exit;
            }
        }
        $sets[] = 'role = ?'; $params[] = $role;
    }
    $status = strtolower(trim((string)($_POST['status'] ?? '')));
    if ($status !== '') {
        if (!in_array($status, ['active', 'inactive'], true)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Unknown status.']);
            exit;
        }
        if ($id === (int)($_SESSION['admin_user']['id'] ?? 0) && $status === 'inactive') {
            http_response_code(409);
            echo json_encode(['success' => false, 'message' => 'You cannot deactivate your own signed-in account.']);
            exit;
        }
        $sets[] = 'status = ?'; $params[] = $status;
    }

    if (empty($sets)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Nothing to update.']);
        exit;
    }
    $params[] = $id;
    try {
        $stmt = $pdo->prepare('UPDATE users SET ' . implode(', ', $sets) . ' WHERE id = ?');
        $stmt->execute($params);
        echo json_encode(['success' => true, 'id' => $id, 'message' => 'Account updated.']);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

if ($method === 'POST' && $action === 'reset_password') {
    $id = (int)($_POST['id'] ?? 0);
    $password = (string)($_POST['password'] ?? '');
    if ($id <= 0 || strlen($password) < 8) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Account id and a password of at least 8 characters are required.']);
        exit;
    }
    try {
        $stmt = $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
        $stmt->execute([password_hash($password, PASSWORD_BCRYPT), $id]);
        echo json_encode(['success' => true, 'id' => $id, 'message' => 'Password reset. Share it with the staff member over a secure channel.']);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

if ($method === 'POST' && $action === 'delete') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Account id is required.']);
        exit;
    }
    if ($id === (int)($_SESSION['admin_user']['id'] ?? 0)) {
        http_response_code(409);
        echo json_encode(['success' => false, 'message' => 'You cannot delete your own signed-in account.']);
        exit;
    }
    $row = Database::fetchOne('SELECT id, role FROM users WHERE id = ? LIMIT 1', [$id]);
    if (!$row) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'No such account.']);
        exit;
    }
    if ($row['role'] === 'super_admin') {
        $cnt = Database::fetchOne("SELECT COUNT(*) AS c FROM users WHERE role = 'super_admin' AND status = 'active'");
        if ((int)($cnt['c'] ?? 0) <= 1) {
            http_response_code(409);
            echo json_encode(['success' => false, 'message' => 'Cannot delete the only Super Admin account.']);
            exit;
        }
    }
    try {
        $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'id' => $id, 'message' => 'Account deleted.']);
    } catch (\Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

// GET list — real rows only, no invented roster.
$accounts = Database::query(
    "SELECT id, name, email, phone, role, status, last_login, created_at
     FROM users ORDER BY (role = 'super_admin') DESC, id ASC"
);

$totalAccounts = count($accounts);
$superAdmins = 0;
$staff = 0;
$activeLast24h = 0;
foreach ($accounts as $a) {
    if ($a['role'] === 'super_admin') $superAdmins++;
    else $staff++;
    if (!empty($a['last_login']) && strtotime((string)$a['last_login']) > (time() - 86400)) $activeLast24h++;
}

echo json_encode([
    'success' => true,
    'count' => $totalAccounts,
    'super_admins' => $superAdmins,
    'staff' => $staff,
    'active_last_24h' => $activeLast24h,
    'data' => $accounts,
]);