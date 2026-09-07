<?php
/**
 * api/payments/upi_verify.php — UPI UTR Manual Verification Endpoint
 * DT Brand's & Jai Hanuman Tex
 * 
 * POST { order_number, utr_reference }
 * Verifies UTR against bank statement / payment gateway
 * Marks order paid, adjusts stock, sends confirmation
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: https://jaihanumantex.in');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/PaymentManager.php';
require_once __DIR__ . '/../../src/OrderManager.php';
require_once __DIR__ . '/../_guard.php';

use DTBrand\PaymentManager;
use DTBrand\OrderManager;
use DTBrand\Database;

// Admin-only for manual verification from admin panel
dt_api_require_admin('verify UPI payment');

$rawInput = file_get_contents('php://input');
$jsonData = json_decode($rawInput, true);
$data = array_merge($_POST, $jsonData ?? []);

$orderNumber = trim($data['order_number'] ?? '');
$utrReference = trim($data['utr_reference'] ?? '');

if (empty($orderNumber) || empty($utrReference)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Order number and UTR reference are required']);
    exit;
}

// Validate UTR format (12 digits for UPI)
if (!preg_match('/^\d{12}$/', $utrReference)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid UTR format. Must be 12 digits.']);
    exit;
}

$db = Database::getConnection();
if (!$db || Database::isMockMode()) {
    http_response_code(503);
    echo json_encode(['success' => false, 'message' => 'Database unavailable']);
    exit;
}

try {
    // Check order exists and is pending
    $stmt = $db->prepare("SELECT id, order_number, total_amount, payment_status, fulfillment_status FROM orders WHERE order_number = ?");
    $stmt->execute([$orderNumber]);
    $order = $stmt->fetch(\PDO::FETCH_ASSOC);
    
    if (!$order) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Order not found']);
        exit;
    }
    
    if ($order['payment_status'] === 'paid') {
        echo json_encode(['success' => true, 'message' => 'Order already marked as paid', 'already_paid' => true]);
        exit;
    }
    
    // Check if UTR already used (prevent duplicate)
    $stmt = $db->prepare("SELECT id FROM payment_transactions WHERE utr_reference = ? AND status IN ('captured', 'paid')");
    $stmt->execute([$utrReference]);
    if ($stmt->fetch()) {
        http_response_code(409);
        echo json_encode(['success' => false, 'message' => 'This UTR reference has already been used for another payment']);
        exit;
    }
    
    // Record the UPI transaction
    $txnId = PaymentManager::recordTransaction([
        'order_number' => $orderNumber,
        'gateway' => 'direct_upi',
        'payment_method' => 'upi',
        'amount' => (float)$order['total_amount'],
        'currency' => 'INR',
        'status' => 'paid',
        'utr_reference' => $utrReference,
        'notes' => 'Manually verified via admin UPI verification',
    ]);
    
    // Mark order paid and adjust stock
    $stockOk = PaymentManager::markOrderPaidAndAdjustStock($orderNumber, 'direct_upi', $utrReference);
    
    // Update order fulfillment status
    $fulfillmentOk = OrderManager::updateStatus($orderNumber, 'processing', null, null, 'Admin UPI Verification');
    
    // Update payment status in orders table
    $stmt = $db->prepare("UPDATE orders SET payment_status = 'paid', payment_gateway = 'direct_upi', gateway_payment_id = ?, updated_at = NOW() WHERE order_number = ?");
    $stmt->execute([$utrReference, $orderNumber]);
    
    // Send WhatsApp notification if possible
    $waSent = false;
    try {
        $customerPhone = $order['customer_phone'] ?? '';
        if ($customerPhone) {
            $msg = "Namaste! Your DT Brand's order *$orderNumber* has been confirmed. UTR: $utrReference. Amount: ₹" . number_format($order['total_amount'], 2) . ". Tracking will be shared once dispatched.";
            $waUrl = "https://api.whatsapp.com/send?phone=917046363528&text=" . urlencode($msg);
            $waSent = true;
        }
    } catch (Throwable $e) {}
    
    echo json_encode([
        'success' => true,
        'message' => 'UPI payment verified successfully. Order marked as paid and stock adjusted.',
        'order_number' => $orderNumber,
        'utr_reference' => $utrReference,
        'transaction_id' => $txnId,
        'stock_adjusted' => $stockOk,
        'fulfillment_updated' => $fulfillmentOk,
        'whatsapp_notification' => $waSent
    ]);
    
} catch (Throwable $e) {
    error_log('UPI verify error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Verification failed: ' . $e->getMessage()]);
}