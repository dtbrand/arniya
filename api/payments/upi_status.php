<?php
/**
 * api/payments/upi_status.php — UPI Payment Status Polling Endpoint
 * DT Brand's & Jai Hanuman Tex
 * 
 * GET ?order_number=xxx
 * Returns current payment status for UPI orders
 * Used by frontend to poll for payment completion
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: https://jaihanumantex.in');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/PaymentManager.php';

use DTBrand\PaymentManager;
use DTBrand\Database;

$orderNumber = trim($_GET['order_number'] ?? '');

if (empty($orderNumber)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Order number required']);
    exit;
}

$db = Database::getConnection();
if (!$db || Database::isMockMode()) {
    // In mock mode, return pending status
    echo json_encode([
        'success' => true,
        'order_number' => $orderNumber,
        'payment_status' => 'pending',
        'message' => 'Waiting for payment...'
    ]);
    exit;
}

try {
    // Get order details
    $stmt = $db->prepare("SELECT id, order_number, total_amount, payment_status, payment_gateway, gateway_payment_id, utr_reference, fulfillment_status, updated_at FROM orders WHERE order_number = ?");
    $stmt->execute([$orderNumber]);
    $order = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if (!$order) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Order not found']);
        exit;
    }
    
    $paymentStatus = $order['payment_status'] ?? 'pending';
    $fulfillmentStatus = $order['fulfillment_status'] ?? 'unfulfilled';
    
    // If already paid, return success
    if ($paymentStatus === 'paid') {
        echo json_encode([
            'success' => true,
            'order_number' => $orderNumber,
            'payment_status' => 'paid',
            'fulfillment_status' => $fulfillmentStatus,
            'amount' => (float)$order['total_amount'],
            'gateway' => $order['payment_gateway'] ?? 'direct_upi',
            'reference' => $order['gateway_payment_id'] ?? $order['utr_reference'] ?? '',
            'updated_at' => $order['updated_at'] ?? '',
            'message' => 'Payment confirmed'
        ]);
        exit;
    }
    
    // Check for recent UPI transactions in payment_transactions
    $stmt = $db->prepare("SELECT status, utr_reference, gateway_payment_id, created_at FROM payment_transactions WHERE order_number = ? AND gateway = 'direct_upi' ORDER BY created_at DESC LIMIT 1");
    $stmt->execute([$orderNumber]);
    $txn = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if ($txn) {
        if ($txn['status'] === 'paid' || $txn['status'] === 'captured') {
            // Transaction found but order not updated - sync it
            $db->prepare("UPDATE orders SET payment_status = 'paid', payment_gateway = 'direct_upi', gateway_payment_id = ?, utr_reference = ?, updated_at = NOW() WHERE order_number = ?")
                ->execute([$txn['gateway_payment_id'] ?? $txn['utr_reference'], $txn['utr_reference'], $orderNumber]);
            
            echo json_encode([
                'success' => true,
                'order_number' => $orderNumber,
                'payment_status' => 'paid',
                'fulfillment_status' => 'processing',
                'amount' => (float)$order['total_amount'],
                'gateway' => 'direct_upi',
                'reference' => $txn['utr_reference'] ?? $txn['gateway_payment_id'],
                'message' => 'Payment confirmed via transaction record'
            ]);
            exit;
        }
        
        if ($txn['status'] === 'failed') {
            echo json_encode([
                'success' => true,
                'order_number' => $orderNumber,
                'payment_status' => 'failed',
                'message' => 'Payment failed. Please try again.'
            ]);
            exit;
        }
    }
    
    // Still pending
    echo json_encode([
        'success' => true,
        'order_number' => $orderNumber,
        'payment_status' => 'pending',
        'fulfillment_status' => $fulfillmentStatus,
        'amount' => (float)$order['total_amount'],
        'gateway' => 'direct_upi',
        'message' => 'Waiting for payment...'
    ]);
    
} catch (Throwable $e) {
    error_log('UPI status check error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Status check failed']);
}