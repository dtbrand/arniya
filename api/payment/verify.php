<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/PaymentManager.php';

use DTBrand\Database;
use DTBrand\PaymentManager;

$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true) ?: $_POST;

$gateway = trim((string)($input['gateway'] ?? ''));
$orderNumber = trim((string)($input['order_number'] ?? ''));

if (empty($gateway) || empty($orderNumber)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing gateway or order number']);
    exit;
}

$db = Database::getConnection();

try {
    switch ($gateway) {
        case 'razorpay':
            $rzpOrderId = trim((string)($input['razorpay_order_id'] ?? ''));
            $rzpPaymentId = trim((string)($input['razorpay_payment_id'] ?? ''));
            $rzpSignature = trim((string)($input['razorpay_signature'] ?? ''));

            if (empty($rzpOrderId) || empty($rzpPaymentId) || empty($rzpSignature)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Incomplete Razorpay signature payload']);
                exit;
            }

            $isValid = PaymentManager::verifyRazorpaySignature($rzpOrderId, $rzpPaymentId, $rzpSignature);
            if ($isValid) {
                // Update transaction in DB
                if ($db) {
                    $stmt = $db->prepare("
                        UPDATE `payment_transactions` 
                        SET `status` = 'captured', `gateway_payment_id` = :pid, `gateway_signature` = :sig, `updated_at` = NOW()
                        WHERE `order_number` = :ord AND `gateway` = 'razorpay'
                    ");
                    $stmt->execute([':pid' => $rzpPaymentId, ':sig' => $rzpSignature, ':ord' => $orderNumber]);

                    // Update order
                    $stmtOrder = $db->prepare("
                        UPDATE `orders` 
                        SET `payment_status` = 'paid', `payment_gateway` = 'razorpay', `gateway_payment_id` = :pid
                        WHERE `order_number` = :ord
                    ");
                    $stmtOrder->execute([':pid' => $rzpPaymentId, ':ord' => $orderNumber]);
                }

                echo json_encode([
                    'success'            => true,
                    'message'            => 'Razorpay payment verified and captured successfully',
                    'gateway_payment_id' => $rzpPaymentId
                ]);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Invalid Razorpay payment signature']);
            }
            break;

        case 'direct_upi':
            $utr = trim((string)($input['utr_reference'] ?? ($input['utr'] ?? '')));
            if (empty($utr)) {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Please provide the 12-digit UPI UTR / Transaction Reference Number']);
                exit;
            }

            if ($db) {
                $stmt = $db->prepare("
                    UPDATE `payment_transactions` 
                    SET `utr_reference` = :utr, `status` = 'authorized', `notes` = 'Customer submitted UTR reference', `updated_at` = NOW()
                    WHERE `order_number` = :ord AND `gateway` = 'direct_upi'
                ");
                $stmt->execute([':utr' => $utr, ':ord' => $orderNumber]);

                $stmtOrder = $db->prepare("
                    UPDATE `orders` 
                    SET `payment_status` = 'pending', `payment_gateway` = 'direct_upi', `payment_utr` = :utr
                    WHERE `order_number` = :ord
                ");
                $stmtOrder->execute([':utr' => $utr, ':ord' => $orderNumber]);
            }

            echo json_encode([
                'success' => true,
                'message' => 'UPI UTR reference recorded successfully. Order awaiting admin verification.',
                'utr'     => $utr
            ]);
            break;

        case 'cashfree':
            $cfOrderId = trim((string)($input['cf_order_id'] ?? ''));
            $cfPaymentId = trim((string)($input['cf_payment_id'] ?? ''));
            $status = trim((string)($input['status'] ?? 'captured'));

            if ($db) {
                $stmt = $db->prepare("
                    UPDATE `payment_transactions` 
                    SET `status` = 'captured', `gateway_payment_id` = :pid, `updated_at` = NOW()
                    WHERE `order_number` = :ord AND `gateway` = 'cashfree'
                ");
                $stmt->execute([':pid' => $cfPaymentId, ':ord' => $orderNumber]);

                $stmtOrder = $db->prepare("
                    UPDATE `orders` 
                    SET `payment_status` = 'paid', `payment_gateway` = 'cashfree', `gateway_payment_id` = :pid
                    WHERE `order_number` = :ord
                ");
                $stmtOrder->execute([':pid' => $cfPaymentId, ':ord' => $orderNumber]);
            }

            echo json_encode([
                'success' => true,
                'message' => 'Cashfree payment recorded successfully'
            ]);
            break;

        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Unsupported payment verification gateway: ' . $gateway]);
    }
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
