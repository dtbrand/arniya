<?php
/**
 * api/auth/index.php — Complete JSON REST Authentication Endpoint
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/Auth.php';

use DTBrand\Auth;

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'register':
        $res = Auth::register($_POST);
        if (!$res['success']) {
            http_response_code(400);
        }
        echo json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        break;

    case 'login':
        $identity = $_POST['identity'] ?? $_POST['phone'] ?? $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $res = Auth::login($identity, $password);
        if (!$res['success']) {
            http_response_code(401);
        }
        echo json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        break;

    case 'admin_login':
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $res = Auth::adminLogin($email, $password);
        if (!$res['success']) {
            http_response_code(401);
        }
        echo json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        break;

    case 'logout':
        Auth::logout();
        echo json_encode(['success' => true, 'message' => 'Logged out successfully']);
        break;

    case 'admin_logout':
        Auth::adminLogout();
        echo json_encode(['success' => true, 'message' => 'Admin logged out successfully']);
        break;

    case 'me':
        $user = Auth::getCurrentUser();
        if ($user) {
            echo json_encode(['success' => true, 'user' => $user]);
        } else {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Not authenticated']);
        }
        break;

    case 'update_profile':
        $user = Auth::getCurrentUser();
        if (!$user) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Authentication required']);
            break;
        }
        $res = Auth::updateProfile($user['id'], $_POST);
        echo json_encode($res);
        break;

    case 'change_password':
        $user = Auth::getCurrentUser();
        if (!$user) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Authentication required']);
            break;
        }
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $res = Auth::changePassword($user['id'], $current, $new);
        if (!$res['success']) {
            http_response_code(400);
        }
        echo json_encode($res);
        break;

    case 'forgot_password':
        $identity = $_POST['identity'] ?? $_POST['phone'] ?? $_POST['email'] ?? '';
        $res = Auth::requestPasswordReset($identity);
        echo json_encode($res);
        break;

    default:
        echo json_encode([
            'success' => true,
            'message' => 'Auth API ready',
            'logged_in' => Auth::isLoggedIn(),
            'current_user' => Auth::getCurrentUser()
        ]);
        break;
}
exit;
