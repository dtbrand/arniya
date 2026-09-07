<?php
/**
 * api/customer_addresses.php — Admin Customer Address Management API
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 *
 * Dedicated endpoint for viewing, creating, updating, setting default shipping,
 * setting default billing, and deleting addresses for any customer in the CRM.
 */

header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../src/CustomerManager.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\Database;
use DTBrand\Auth;
use DTBrand\CustomerManager;

// Admin authentication required
dt_api_require_admin('manage customer addresses');

function dt_addr_json(int $code, array $payload): void
{
    http_response_code($code);
    echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

$pdo = Database::getConnection();
if ($pdo === null || Database::isMockMode()) {
    dt_addr_json(503, [
        'success' => false,
        'message' => 'Database connection unavailable. Please check database configuration.'
    ]);
}

$method = $_SERVER['REQUEST_METHOD'];

// ── 1. GET: Fetch all addresses for a customer ──
if ($method === 'GET') {
    $customerId = (int)($_GET['customer_id'] ?? 0);
    if ($customerId <= 0) {
        dt_addr_json(400, ['success' => false, 'message' => 'Valid customer_id is required.']);
    }

    try {
        $addresses = Auth::getCustomerAddresses($customerId);
        dt_addr_json(200, [
            'success' => true,
            'customer_id' => $customerId,
            'count' => count($addresses),
            'addresses' => $addresses
        ]);
    } catch (\Throwable $e) {
        dt_addr_json(500, ['success' => false, 'message' => 'Failed to load addresses: ' . $e->getMessage()]);
    }
}

// ── 2. POST: Save / Set Default / Delete ──
if ($method === 'POST') {
    $rawInput = file_get_contents('php://input');
    $jsonData = json_decode($rawInput, true) ?: [];
    $data = array_merge($_POST, $jsonData);

    $action = trim((string)($data['action'] ?? 'save'));
    $customerId = (int)($data['customer_id'] ?? ($_GET['customer_id'] ?? 0));

    if ($customerId <= 0) {
        dt_addr_json(400, ['success' => false, 'message' => 'Valid customer_id is required.']);
    }

    // ── 2A. SAVE (Add or Edit Address) ──
    if ($action === 'save') {
        $addr1 = trim((string)($data['address_line1'] ?? ($data['address'] ?? '')));
        $city  = trim((string)($data['city'] ?? ''));
        $state = trim((string)($data['state'] ?? ''));
        $pin   = trim((string)($data['pincode'] ?? ''));

        if ($addr1 === '' || $city === '' || $pin === '') {
            dt_addr_json(400, [
                'success' => false,
                'message' => 'Address line 1, city, and 6-digit PIN code are required.'
            ]);
        }

        $res = Auth::saveAddress($customerId, $data);
        if (!$res['success']) {
            dt_addr_json(400, $res);
        }

        $updatedAddresses = Auth::getCustomerAddresses($customerId);
        dt_addr_json(200, [
            'success' => true,
            'message' => 'Address successfully saved to database!',
            'address_id' => $res['address_id'] ?? 0,
            'address' => $res['address'] ?? null,
            'addresses' => $updatedAddresses
        ]);
    }

    // ── 2B. SET AS DEFAULT SHIPPING ──
    if ($action === 'set_default_shipping') {
        $addressId = (int)($data['id'] ?? ($data['address_id'] ?? 0));
        if ($addressId <= 0) {
            dt_addr_json(400, ['success' => false, 'message' => 'Valid address ID is required.']);
        }

        try {
            // Unset other shipping addresses as default
            $unsetDefault = $pdo->prepare("UPDATE addresses SET is_default = 0 WHERE customer_id = ? AND address_type != 'billing'");
            $unsetDefault->execute([$customerId]);

            // Set chosen address as default shipping
            $setStmt = $pdo->prepare("UPDATE addresses SET is_default = 1 WHERE id = ? AND customer_id = ?");
            $setStmt->execute([$addressId, $customerId]);

            $updatedAddresses = Auth::getCustomerAddresses($customerId);
            dt_addr_json(200, [
                'success' => true,
                'message' => 'Default shipping destination updated successfully!',
                'addresses' => $updatedAddresses
            ]);
        } catch (\Throwable $e) {
            dt_addr_json(500, ['success' => false, 'message' => 'Failed to update default shipping: ' . $e->getMessage()]);
        }
    }

    // ── 2C. SET AS DEFAULT BILLING ──
    if ($action === 'set_default_billing') {
        $addressId = (int)($data['id'] ?? ($data['address_id'] ?? 0));
        if ($addressId <= 0) {
            dt_addr_json(400, ['success' => false, 'message' => 'Valid address ID is required.']);
        }

        try {
            // Find address
            $fStmt = $pdo->prepare("SELECT * FROM addresses WHERE id = ? AND customer_id = ? LIMIT 1");
            $fStmt->execute([$addressId, $customerId]);
            $addrRow = $fStmt->fetch(\PDO::FETCH_ASSOC);

            if (!$addrRow) {
                dt_addr_json(404, ['success' => false, 'message' => 'Address not found for this customer.']);
            }

            // Unset previous billing address
            $unsetBilling = $pdo->prepare("UPDATE addresses SET address_type = 'shipping' WHERE customer_id = ? AND address_type = 'billing'");
            $unsetBilling->execute([$customerId]);

            // Mark this address as billing and default
            $setBilling = $pdo->prepare("UPDATE addresses SET address_type = 'billing', is_default = 1 WHERE id = ? AND customer_id = ?");
            $setBilling->execute([$addressId, $customerId]);

            // Synchronize with customers table
            $upCust = $pdo->prepare("
                UPDATE customers 
                SET name = CASE WHEN ? != '' THEN ? ELSE name END,
                    city = CASE WHEN ? != '' THEN ? ELSE city END,
                    state = CASE WHEN ? != '' THEN ? ELSE state END
                WHERE id = ?
            ");
            $recName = (string)($addrRow['recipient_name'] ?? '');
            $cCity = (string)($addrRow['city'] ?? '');
            $cState = (string)($addrRow['state'] ?? '');
            $upCust->execute([$recName, $recName, $cCity, $cCity, $cState, $cState, $customerId]);

            $updatedAddresses = Auth::getCustomerAddresses($customerId);
            dt_addr_json(200, [
                'success' => true,
                'message' => 'Registered GST Billing Address updated successfully!',
                'addresses' => $updatedAddresses
            ]);
        } catch (\Throwable $e) {
            dt_addr_json(500, ['success' => false, 'message' => 'Failed to update billing address: ' . $e->getMessage()]);
        }
    }

    // ── 2D. DELETE ADDRESS ──
    if ($action === 'delete') {
        $addressId = (int)($data['id'] ?? ($data['address_id'] ?? 0));
        if ($addressId <= 0) {
            dt_addr_json(400, ['success' => false, 'message' => 'Valid address ID is required.']);
        }

        try {
            // Prevent deleting the sole address
            $cntStmt = $pdo->prepare("SELECT COUNT(*) FROM addresses WHERE customer_id = ?");
            $cntStmt->execute([$customerId]);
            $total = (int)$cntStmt->fetchColumn();

            if ($total <= 1) {
                dt_addr_json(400, [
                    'success' => false,
                    'message' => 'Cannot delete the only saved address. A customer must have at least one registered address.'
                ]);
            }

            $delStmt = $pdo->prepare("DELETE FROM addresses WHERE id = ? AND customer_id = ?");
            $delStmt->execute([$addressId, $customerId]);

            $updatedAddresses = Auth::getCustomerAddresses($customerId);
            dt_addr_json(200, [
                'success' => true,
                'message' => 'Address removed successfully!',
                'addresses' => $updatedAddresses
            ]);
        } catch (\Throwable $e) {
            dt_addr_json(500, ['success' => false, 'message' => 'Failed to delete address: ' . $e->getMessage()]);
        }
    }

    dt_addr_json(400, ['success' => false, 'message' => 'Unrecognized action: ' . htmlspecialchars($action)]);
}

dt_addr_json(405, ['success' => false, 'message' => 'Method not allowed.']);
