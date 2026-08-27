<?php
/**
 * api/customers.php — Customer, Partner, Wholesale & Reseller Identity API
 * DT Brand's & Jai Hanuman Tex
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/CustomerManager.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\CustomerManager;
use DTBrand\Database;

// Admin-only in full. Every action here touches customer records — names,
// phone numbers, GSTINs, credit limits and outstanding balances — so even the
// read side is privileged. This endpoint previously had no authentication at
// all: anyone who knew the URL could list the entire customer book or edit and
// delete records. Customers manage their own profile through /api/auth.php,
// which scopes every change to their own session.
dt_api_require_admin('manage customers');

try {
    $method = $_SERVER['REQUEST_METHOD'];

    // ── 1. WRITE ACTIONS (POST / PUT / DELETE) ──
    if ($method === 'POST' || $method === 'PUT' || $method === 'DELETE') {
        $rawInput = file_get_contents('php://input');
        $jsonData = json_decode($rawInput, true) ?: [];
        $data = array_merge($_POST, $jsonData);

        $action = trim($data['action'] ?? ($method === 'DELETE' ? 'delete' : 'create'));
        $targetId = (int)($data['id'] ?? ($_GET['id'] ?? 0));

        if ($action === 'create') {
            $res = CustomerManager::create($data);
            if ($res['success']) {
                http_response_code(201);
                echo json_encode($res, JSON_PRETTY_PRINT);
            } else {
                http_response_code(400);
                echo json_encode($res, JSON_PRETTY_PRINT);
            }
            exit;
        }

        if ($action === 'update') {
            if ($targetId <= 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Customer ID required.'], JSON_PRETTY_PRINT);
                exit;
            }
            $res = CustomerManager::update($targetId, $data);
            echo json_encode($res, JSON_PRETTY_PRINT);
            exit;
        }

        if ($action === 'delete') {
            if ($targetId <= 0) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Customer ID required.'], JSON_PRETTY_PRINT);
                exit;
            }
            $ok = CustomerManager::delete($targetId);
            echo json_encode(['success' => $ok, 'id' => $targetId, 'message' => $ok ? 'Customer deleted.' : 'Failed to delete.'], JSON_PRETTY_PRINT);
            exit;
        }

        if ($action === 'update_status') {
            if ($targetId <= 0 || empty($data['status'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Customer ID and status required.'], JSON_PRETTY_PRINT);
                exit;
            }
            $newStatus = strtolower(trim($data['status']));
            if (!in_array($newStatus, ['active', 'pending', 'suspended'], true)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Status must be active, pending or suspended.'], JSON_PRETTY_PRINT);
                exit;
            }
            $ok = CustomerManager::updateStatus($targetId, $newStatus);
            if (!$ok) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'id' => $targetId,
                    'message' => 'That customer could not be updated — the account may no longer exist.',
                ], JSON_PRETTY_PRINT);
                exit;
            }
            echo json_encode(['success' => true, 'id' => $targetId, 'status' => $newStatus], JSON_PRETTY_PRINT);
            exit;
        }

        if ($action === 'update_credit') {
            if ($targetId <= 0 || !isset($data['credit_limit'])) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Customer ID and credit limit required.'], JSON_PRETTY_PRINT);
                exit;
            }
            $ok = CustomerManager::updateCreditLimit($targetId, (float)$data['credit_limit']);
            echo json_encode(['success' => $ok, 'id' => $targetId, 'credit_limit' => $data['credit_limit']], JSON_PRETTY_PRINT);
            exit;
        }
    }

    // ── 2. READ ACTIONS (GET) ──
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $type = isset($_GET['type']) ? trim($_GET['type']) : '';
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    if ($id > 0) {
        $customer = CustomerManager::getById($id);
        if ($customer) {
            echo json_encode(['success' => true, 'customer' => $customer], JSON_PRETTY_PRINT);
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Customer not found.'], JSON_PRETTY_PRINT);
        }
        exit;
    }

    if (!empty($type) && $type !== 'all') {
        $customers = CustomerManager::getByType($type);
    } else {
        $customers = CustomerManager::getAll();
    }

    if (!empty($search)) {
        $term = strtolower($search);
        $customers = array_values(array_filter($customers, function($c) use ($term) {
            return strpos(strtolower($c['name'] ?? ''), $term) !== false ||
                   strpos(strtolower($c['phone'] ?? ''), $term) !== false ||
                   strpos(strtolower($c['email'] ?? ''), $term) !== false ||
                   strpos(strtolower($c['city'] ?? ''), $term) !== false;
        }));
    }

    echo json_encode([
        'success' => true,
        'count' => count($customers),
        'stats' => CustomerManager::getStats(),
        'customers' => $customers
    ], JSON_PRETTY_PRINT);

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Customer API Error: ' . $e->getMessage()], JSON_PRETTY_PRINT);
}
