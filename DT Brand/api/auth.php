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

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/Auth.php';

use DTBrand\Auth;

try {
    $action = $_GET['action'] ?? ($_POST['action'] ?? 'session');
    $rawInput = file_get_contents('php://input');
    $data = json_decode($rawInput, true) ?: $_POST;

    if ($action === 'login') {
        $phoneOrEmail = trim($data['phone'] ?? ($data['email'] ?? ''));
        $password = $data['password'] ?? '';
        $res = Auth::login($phoneOrEmail, $password);
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'register') {
        $res = Auth::register($data);
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'logout') {
        $res = Auth::logout();
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'session') {
        $user = Auth::getCurrentUser();
        echo json_encode([
            'authenticated' => ($user !== null),
            'user' => $user
        ], JSON_PRETTY_PRINT);
        exit;
    }

    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid auth action.']);

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
