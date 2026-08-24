<?php
/**
 * api/customers.php — Customer & B2B Partner Identity & CRM REST API Engine
 * DT Brand's & Jai Hanuman Tex
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/CustomerManager.php';

use DTBrand\CustomerManager;

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'create' || $action === 'add') {
        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $type = trim($_POST['type'] ?? 'retail');
        $tier = trim($_POST['tier'] ?? ($type === 'wholesale' ? 'Diamond Elite' : ($type === 'reseller' ? 'Gold VIP' : 'Silver Consumer')));
        $city = trim($_POST['city'] ?? 'Surat');
        $state = trim($_POST['state'] ?? 'Gujarat');
        $creditLimit = (float)($_POST['credit_limit'] ?? 0.0);

        if (empty($name) || empty($phone)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Customer Name and Phone Number are required.']);
            exit;
        }

        $newCust = CustomerManager::create([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'type' => $type,
            'tier' => $tier,
            'city' => $city,
            'state' => $state,
            'credit_limit' => $creditLimit,
            'status' => 'active'
        ]);

        echo json_encode([
            'success' => true,
            'message' => 'Customer account registered successfully.',
            'customer' => $newCust
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    if ($action === 'update' || $action === 'edit') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Valid Customer ID is required.']);
            exit;
        }

        $data = [];
        foreach (['name', 'phone', 'email', 'type', 'tier', 'city', 'state', 'credit_limit', 'outstanding_balance', 'status'] as $field) {
            if (isset($_POST[$field])) {
                $data[$field] = $_POST[$field];
            }
        }

        $ok = CustomerManager::update($id, $data);
        echo json_encode([
            'success' => $ok,
            'message' => $ok ? 'Customer profile updated successfully.' : 'Failed to update customer profile.'
        ]);
        exit;
    }

    if ($action === 'delete') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Valid Customer ID is required.']);
            exit;
        }

        $ok = CustomerManager::delete($id);
        echo json_encode([
            'success' => $ok,
            'message' => $ok ? 'Customer deleted successfully.' : 'Failed to delete customer.'
        ]);
        exit;
    }
}

// GET queries
if ($action === 'stats') {
    $stats = CustomerManager::getStats();
    echo json_encode(['success' => true, 'stats' => $stats], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

if ($action === 'get') {
    $id = (int)($_GET['id'] ?? 0);
    $cust = CustomerManager::getById($id);
    if ($cust) {
        echo json_encode(['success' => true, 'customer' => $cust], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    } else {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Customer not found.']);
    }
    exit;
}

$type = trim($_GET['type'] ?? '');
if (!empty($type)) {
    $customers = CustomerManager::getByType($type);
} else {
    $customers = CustomerManager::getAll();
}

echo json_encode([
    'success' => true,
    'count' => count($customers),
    'customers' => $customers
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
exit;
