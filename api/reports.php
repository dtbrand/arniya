<?php
/**
 * api/reports.php — DT Brand's & Jai Hanuman Tex Reports & Analytics REST API
 * Section 33: Reports / Analytics & Export Suite
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/ReportManager.php';
use DTBrand\ReportManager;

$action = isset($_GET['action']) ? strtolower(trim($_GET['action'])) : (isset($_POST['action']) ? strtolower(trim($_POST['action'])) : 'stats');
$range = isset($_GET['range']) ? trim($_GET['range']) : (isset($_POST['range']) ? trim($_POST['range']) : 'all');
$format = isset($_GET['format']) ? strtolower(trim($_GET['format'])) : 'json';

// Handle Export Action
if ($action === 'export') {
    $type = isset($_GET['type']) ? strtolower(trim($_GET['type'])) : 'sales';
    $channel = isset($_GET['channel']) ? trim($_GET['channel']) : 'all';
    $status = isset($_GET['status']) ? trim($_GET['status']) : 'all';
    $role = isset($_GET['role']) ? trim($_GET['role']) : 'all';

    $filters = ['channel' => $channel, 'status' => $status, 'role' => $role];

    if ($format === 'excel') {
        ReportManager::exportToExcel($type, $range, $filters);
    } else {
        ReportManager::exportToCsv($type, $range, $filters);
    }
    exit;
}

// JSON API Response
header('Content-Type: application/json; charset=utf-8');

try {
    switch ($action) {
        case 'stats':
        case 'summary':
            $data = ReportManager::getSummaryKpis($range);
            echo json_encode(['success' => true, 'action' => $action, 'data' => $data]);
            break;

        case 'sales':
            $channel = isset($_GET['channel']) ? trim($_GET['channel']) : 'all';
            $data = ReportManager::getSalesReport($range, $channel);
            echo json_encode(['success' => true, 'action' => $action, 'data' => $data]);
            break;

        case 'orders':
            $status = isset($_GET['status']) ? trim($_GET['status']) : 'all';
            $data = ReportManager::getOrdersReport($range, $status);
            echo json_encode(['success' => true, 'action' => $action, 'data' => $data]);
            break;

        case 'revenue':
        case 'pnl':
            $data = ReportManager::getRevenueReport($range);
            echo json_encode(['success' => true, 'action' => $action, 'data' => $data]);
            break;

        case 'products':
            $limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 50;
            $data = ReportManager::getProductsPerformanceReport($limit);
            echo json_encode(['success' => true, 'action' => $action, 'data' => $data]);
            break;

        case 'categories':
            $data = ReportManager::getCategoriesReport();
            echo json_encode(['success' => true, 'action' => $action, 'data' => $data]);
            break;

        case 'inventory':
            $data = ReportManager::getInventoryReport();
            echo json_encode(['success' => true, 'action' => $action, 'data' => $data]);
            break;

        case 'customers':
            $role = isset($_GET['role']) ? trim($_GET['role']) : 'all';
            $data = ReportManager::getCustomersReport($role);
            echo json_encode(['success' => true, 'action' => $action, 'data' => $data]);
            break;

        case 'roles':
            $data = ReportManager::getRoleDistributionReport();
            echo json_encode(['success' => true, 'action' => $action, 'data' => $data]);
            break;

        case 'role_detail':
            $role = isset($_GET['role']) ? trim($_GET['role']) : 'retailer';
            $data = ReportManager::getRoleSpecificReport($role);
            echo json_encode(['success' => true, 'action' => $action, 'data' => $data]);
            break;

        case 'payments':
            $data = ReportManager::getPaymentsReport($range);
            echo json_encode(['success' => true, 'action' => $action, 'data' => $data]);
            break;

        case 'shipping':
            $data = ReportManager::getShippingReport($range);
            echo json_encode(['success' => true, 'action' => $action, 'data' => $data]);
            break;

        case 'coupons':
            $data = ReportManager::getCouponsReport();
            echo json_encode(['success' => true, 'action' => $action, 'data' => $data]);
            break;

        case 'returns':
            $data = ReportManager::getReturnsReport();
            echo json_encode(['success' => true, 'action' => $action, 'data' => $data]);
            break;

        default:
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Invalid action requested: ' . htmlspecialchars($action),
                'available_actions' => [
                    'stats', 'sales', 'orders', 'revenue', 'products', 'categories',
                    'inventory', 'customers', 'roles', 'role_detail', 'payments',
                    'shipping', 'coupons', 'returns', 'export'
                ]
            ]);
            break;
    }
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
