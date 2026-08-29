<?php
/**
 * api/retailer.php — Retailer & Wholesale B2B Onboarding, GSTIN KYC Verification API
 * DT Brand's & Jai Hanuman Tex
 */

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if (!headers_sent()) {
    header('Content-Type: application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
}

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\Database;
use DTBrand\Auth;

try {
    $pdo = Database::getConnection();
    $rawInput = file_get_contents('php://input');
    $jsonData = json_decode($rawInput, true) ?: [];
    $data = !empty($jsonData) ? $jsonData : $_REQUEST;

    $action = $data['action'] ?? ($_GET['action'] ?? 'check_status');

    // ── 1. SUBMIT KYC APPLICATION (POST) ──
    if ($action === 'apply_kyc' || ($method === 'POST' && empty($data['action']))) {
        $name = trim((string)($data['name'] ?? ''));
        $shopName = trim((string)($data['shop_name'] ?? ''));
        $phone = trim((string)($data['phone'] ?? ''));
        $email = trim((string)($data['email'] ?? ''));
        $gstin = strtoupper(trim((string)($data['gstin'] ?? '')));
        $pan = strtoupper(trim((string)($data['pan'] ?? '')));
        $city = trim((string)($data['city'] ?? ''));
        $state = trim((string)($data['state'] ?? ''));
        $businessType = trim((string)($data['business_type'] ?? 'retailer'));

        if (empty($phone) || empty($name)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Customer name and phone number are required']);
            exit;
        }

        if (!empty($gstin) && !preg_match('/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/', $gstin)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid GSTIN format (e.g. 24AAAAA0000A1Z5)']);
            exit;
        }

        if ($pdo !== null) {
            $stmt = $pdo->prepare("
                INSERT INTO customers 
                (name, phone, email, type, city, state, gstin, pan, kyc_status, tier, status, created_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', 'B2B Verified Tier 1', 'active', NOW())
                ON DUPLICATE KEY UPDATE 
                name = VALUES(name), email = VALUES(email), gstin = VALUES(gstin), pan = VALUES(pan),
                city = VALUES(city), state = VALUES(state), kyc_status = 'pending'
            ");
            $stmt->execute([
                $name . ($shopName ? " ({$shopName})" : ''),
                $phone,
                $email ?: null,
                $businessType,
                $city,
                $state,
                $gstin ?: null,
                $pan ?: null
            ]);
        }

        echo json_encode([
            'success' => true,
            'message' => 'B2B Wholesale / Retailer KYC application submitted successfully. Verification completes in 2–4 hours.',
            'status' => 'pending',
            'phone' => $phone
        ]);
        exit;
    }

    // ── 2. CHECK KYC VERIFICATION STATUS (GET) ──
    if ($action === 'check_status') {
        $phone = trim((string)($data['phone'] ?? ($_GET['phone'] ?? '')));
        $cust = null;

        if (!empty($phone) && $pdo !== null && !Database::isMockMode()) {
            $stmt = $pdo->prepare("SELECT id, name, phone, email, type, city, state, gstin, kyc_status, tier FROM customers WHERE phone = ?");
            $stmt->execute([$phone]);
            $cust = $stmt->fetch();
        }

        if ($cust) {
            echo json_encode([
                'success' => true,
                'customer' => $cust,
                'kyc_status' => $cust['kyc_status'] ?? 'unverified',
                'is_verified' => ($cust['kyc_status'] === 'verified')
            ]);
        } else {
            echo json_encode([
                'success' => true,
                'kyc_status' => 'unverified',
                'is_verified' => false,
                'message' => 'No active KYC on file for this mobile number'
            ]);
        }
        exit;
    }

    // ── 3. APPROVE / REJECT KYC (ADMIN ONLY) ──
    if ($action === 'approve_kyc' || $action === 'reject_kyc') {
        dt_api_require_admin('moderate retailer KYC');

        $customerId = (int)($data['customer_id'] ?? 0);
        $newStatus = ($action === 'approve_kyc') ? 'verified' : 'rejected';
        $tier = ($newStatus === 'verified') ? 'Wholesale Gold Partner' : 'Standard';
        $type = ($newStatus === 'verified') ? 'wholesale' : 'retail';

        if ($customerId > 0 && $pdo !== null) {
            $stmt = $pdo->prepare("UPDATE customers SET kyc_status = ?, tier = ?, type = ? WHERE id = ?");
            $stmt->execute([$newStatus, $tier, $type, $customerId]);
        }

        echo json_encode([
            'success' => true,
            'message' => "Customer KYC {$newStatus} successfully",
            'customer_id' => $customerId,
            'kyc_status' => $newStatus
        ]);
        exit;
    }

    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid retailer action']);
    exit;

} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Retailer API error: ' . $e->getMessage()]);
    exit;
}
