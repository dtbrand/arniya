<?php
/**
 * api/auth.php — Authentication, Profile & Session Management REST API
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Auth.php';

use DTBrand\Auth;

try {
    $action = $_GET['action'] ?? ($_POST['action'] ?? 'session');
    $rawInput = file_get_contents('php://input');
    $data = json_decode($rawInput, true) ?: $_POST;

    if ($action === 'login') {
        // Accept any of the field names the storefront forms use for the
        // phone-or-email identity. Auth::login() resolves either against
        // customers.phone / customers.email.
        $phoneOrEmail = trim($data['identity'] ?? ($data['phone'] ?? ($data['email'] ?? '')));
        $password = $data['password'] ?? '';
        $res = Auth::login($phoneOrEmail, $password);
        if (!$res['success']) {
            http_response_code(401);
        }
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'register') {
        $res = Auth::register($data);
        if (!$res['success']) {
            http_response_code(400);
        }
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'logout') {
        Auth::logout();
        echo json_encode(['success' => true, 'message' => 'Logged out successfully.'], JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'update_profile') {
        // The customer id comes from the SERVER session only. Never from the
        // request body — otherwise any visitor could edit anyone's profile by
        // posting a different id.
        $current = Auth::getCurrentUser();
        if ($current === null || empty($current['id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Please sign in to update your profile.']);
            exit;
        }
        $res = Auth::updateProfile((int)$current['id'], [
            'name'  => trim($data['name'] ?? ''),
            'email' => trim($data['email'] ?? ''),
            'city'  => trim($data['city'] ?? ''),
            'state' => trim($data['state'] ?? '')
        ]);
        if (!$res['success']) {
            http_response_code(400);
        } else {
            // Hand the refreshed session user back so the client can re-render
            // from server truth instead of guessing what was saved.
            $res['user'] = Auth::getCurrentUser();
        }
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'change_password') {
        $current = Auth::getCurrentUser();
        if ($current === null || empty($current['id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Please sign in to change your password.']);
            exit;
        }
        $res = Auth::changePassword(
            (int)$current['id'],
            (string)($data['current_password'] ?? ''),
            (string)($data['new_password'] ?? '')
        );
        if (!$res['success']) {
            http_response_code(400);
        }
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'forgot_password') {
        // Always answers the same way whether or not the account exists, so this
        // cannot be used to enumerate registered phone numbers.
        $identity = trim($data['identity'] ?? ($data['phone'] ?? ($data['email'] ?? '')));
        $res = Auth::requestPasswordReset($identity);
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'admin_login') {
        $email = trim($data['email'] ?? ($data['username'] ?? ''));
        $password = $data['password'] ?? '';
        $res = Auth::adminLogin($email, $password);
        if (!$res['success']) {
            http_response_code(401);
        }
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'session') {
        $user = Auth::getCurrentUser();
        $admin = $_SESSION['admin_user'] ?? null;
        echo json_encode([
            'authenticated' => ($user !== null),
            'user' => $user,
            'admin_authenticated' => ($admin !== null),
            'admin' => $admin
        ], JSON_PRETTY_PRINT);
        exit;
    }

    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid auth action.']);

} catch (\Throwable $e) {
    // The raw exception text used to be returned as the JSON message, so any
    // schema or connection fault surfaced in the storefront's alert box as a
    // PDO string naming tables and columns. Log it, answer plainly.
    error_log('DT api/auth.php failed: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Something went wrong on our side. Please try again shortly, or message us on WhatsApp.']);
}
