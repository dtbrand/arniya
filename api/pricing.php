<?php
declare(strict_types=1);

/**
 * api/pricing.php — Pricing & Price History Audit REST API
 * Master Specification V2 — Section 40, 41, 42, 43
 * 
 * DT Brand's & Jai Hanuman Tex
 * 
 * STRICT SECURITY: Price History and internal cost data are strictly restricted
 * to authenticated administrators. Non-admin calls are immediately rejected (HTTP 401/403).
 */

require_once __DIR__ . '/cors.php';
cors_json();

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/PriceHistoryManager.php';
require_once __DIR__ . '/../src/Money.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\PriceHistoryManager;
use DTBrand\Money;
use DTBrand\Auth;

header('Content-Type: application/json; charset=utf-8');

try {
    Auth::initSession();

    $isAdmin = !empty($_SESSION['admin_logged_in']) || !empty($_SESSION['admin_user']);
    $user = Auth::getCurrentUser() ?? ($_SESSION['user'] ?? null);
    $role = strtolower(trim((string)($user['role'] ?? ($user['type'] ?? ''))));

    if (!$isAdmin && $role !== 'admin' && $role !== 'superadmin') {
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'error' => 'Forbidden: Price history and internal audit records are restricted to administrators only.'
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    $manager = PriceHistoryManager::getInstance();
    $action = trim((string)($_REQUEST['action'] ?? 'history'));

    if ($action === 'history') {
        $page = (int)($_GET['page'] ?? 1);
        $limit = (int)($_GET['limit'] ?? 25);
        $filters = [
            'product_id' => !empty($_GET['product_id']) ? (int)$_GET['product_id'] : null,
            'role_tier' => !empty($_GET['role_tier']) ? trim((string)$_GET['role_tier']) : null,
            'product_type' => !empty($_GET['product_type']) ? trim((string)$_GET['product_type']) : null,
            'search' => !empty($_GET['search']) ? trim((string)$_GET['search']) : null
        ];

        $data = $manager->getAllHistory($filters, $page, $limit);
        echo json_encode([
            'success' => true,
            'data' => $data
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    if ($action === 'summary') {
        $stats = $manager->getSummaryStats();
        echo json_encode([
            'success' => true,
            'stats' => $stats
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    if ($action === 'product_history') {
        $productId = (int)($_GET['product_id'] ?? 0);
        if ($productId <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Missing or invalid product_id'], JSON_PRETTY_PRINT);
            exit;
        }

        $limit = (int)($_GET['limit'] ?? 50);
        $history = $manager->getHistoryForProduct($productId, $limit);
        echo json_encode([
            'success' => true,
            'product_id' => $productId,
            'history' => $history
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    if ($action === 'record' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // Enforce CSRF token
        $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        $sessionToken = $_SESSION['csrf_token'] ?? '';
        if (empty($token) || !hash_equals($sessionToken, $token)) {
            http_response_code(403);
            echo json_encode(['success' => false, 'error' => 'Forbidden: Invalid or expired CSRF token.'], JSON_PRETTY_PRINT);
            exit;
        }

        $input = json_decode(file_get_contents('php://input'), true) ?? $_POST;

        $productId = (int)($input['product_id'] ?? 0);
        $productType = (string)($input['product_type'] ?? 'single_piece');
        $roleTier = (string)($input['role_tier'] ?? 'all');
        $fieldName = (string)($input['field_name'] ?? '');
        $oldPrice = isset($input['old_price']) && $input['old_price'] !== '' ? (float)$input['old_price'] : null;
        $newPrice = (float)($input['new_price'] ?? 0.0);
        $reason = (string)($input['change_reason'] ?? $input['reason'] ?? '');
        $adminUser = (string)($_SESSION['admin_user']['name'] ?? ($_SESSION['admin_user']['username'] ?? 'admin'));
        $adminId = !empty($_SESSION['admin_user']['id']) ? (int)$_SESSION['admin_user']['id'] : null;

        if ($productId <= 0 || $fieldName === '') {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Missing product_id or field_name'], JSON_PRETTY_PRINT);
            exit;
        }

        $ok = $manager->recordChange(
            $productId,
            $productType,
            $roleTier,
            $fieldName,
            $oldPrice,
            $newPrice,
            $adminUser,
            $adminId,
            $reason
        );

        echo json_encode([
            'success' => $ok,
            'message' => $ok ? 'Price change successfully logged in audit ledger.' : 'No price change detected.'
        ], JSON_PRETTY_PRINT);
        exit;
    }

    http_response_code(400);
    echo json_encode(['success' => false, 'error' => "Unknown action '{$action}'"], JSON_PRETTY_PRINT);

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Server error processing pricing API request.'
    ], JSON_PRETTY_PRINT);
}
