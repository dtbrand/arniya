<?php
/**
 * api/auth.php — Authentication, Profile & Session Management REST API
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/cors.php';
cors_json();

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/_guard.php';

use DTBrand\Auth;
use DTBrand\Database;

try {
    $action = $_GET['action'] ?? ($_POST['action'] ?? 'session');
    $rawInput = file_get_contents('php://input');
    $data = json_decode($rawInput, true) ?: $_POST;

    if ($action === 'login') {
        // Accept any of the field names the storefront forms use for the
        // phone-or-email identity. Auth::login() resolves either against
        // customers.phone / customers.email.
        $phoneOrEmail = trim($data['identity'] ?? ($data['phone'] ?? ($data['email'] ?? '')));
        $password = $data['password'] ?? '';
        $res = Auth::login($phoneOrEmail, $password);
        if (!$res['success']) {
            http_response_code(401);
        }
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'register') {
        $res = Auth::register($data);
        if (!$res['success']) {
            http_response_code(400);
        }
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'logout') {
        Auth::logout();
        echo json_encode(['success' => true, 'message' => 'Logged out successfully.'], JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'update_profile') {
        dt_api_require_csrf(null, $data);
        // The customer id comes from the SERVER session only. Never from the
        // request body — otherwise any visitor could edit anyone's profile by
        // posting a different id.
        $current = Auth::getCurrentUser();
        if ($current === null || empty($current['id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Please sign in to update your profile.']);
            exit;
        }
        $res = Auth::updateProfile((int)$current['id'], [
            'name'  => trim($data['name'] ?? ''),
            'phone' => trim($data['phone'] ?? ''),
            'email' => trim($data['email'] ?? ''),
            'city'  => trim($data['city'] ?? ''),
            'state' => trim($data['state'] ?? ''),
            'gstin' => trim($data['gstin'] ?? ''),
            'pan'   => trim($data['pan'] ?? '')
        ]);
        if (!$res['success']) {
            http_response_code(400);
        } else {
            // Hand the refreshed session user back so the client can re-render
            // from server truth instead of guessing what was saved.
            $res['user'] = Auth::getCurrentUser();
        }
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'get_addresses') {
        $current = Auth::getCurrentUser();
        if ($current === null || empty($current['id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Please sign in to view saved addresses.']);
            exit;
        }
        $addresses = Auth::getCustomerAddresses((int)$current['id']);
        echo json_encode(['success' => true, 'addresses' => $addresses], JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'save_address') {
        dt_api_require_csrf(null, $data);
        $current = Auth::getCurrentUser();
        if ($current === null || empty($current['id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Please sign in to save address.']);
            exit;
        }
        $targetId = (int)($data['id'] ?? ($data['address_id'] ?? 0));
        if ($targetId <= 0 || empty($data['id'])) {
            $data['is_new'] = true;
        }
        $res = Auth::saveAddress((int)$current['id'], $data);
        if (!$res['success']) {
            http_response_code(400);
        } else {
            $res['addresses'] = Auth::getCustomerAddresses((int)$current['id']);
        }
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'set_default_address' || $action === 'set_default_shipping' || $action === 'set_default') {
        dt_api_require_csrf(null, $data);
        $current = Auth::getCurrentUser();
        if ($current === null || empty($current['id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Please sign in to update default address.']);
            exit;
        }
        $addressId = (int)($data['id'] ?? ($data['address_id'] ?? 0));
        $type = ($data['type'] ?? 'shipping') === 'billing' ? 'billing' : 'shipping';
        if ($addressId <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Valid address ID is required.']);
            exit;
        }
        $pdo = Database::getConnection();
        if ($pdo !== null) {
            if ($type === 'billing') {
                $pdo->prepare("UPDATE addresses SET is_billing_default = 0 WHERE customer_id = ?")->execute([(int)$current['id']]);
                $pdo->prepare("UPDATE addresses SET is_billing_default = 1 WHERE id = ? AND customer_id = ?")->execute([$addressId, (int)$current['id']]);
            } else {
                $pdo->prepare("UPDATE addresses SET is_default = 0 WHERE customer_id = ? AND address_type != 'billing'")->execute([(int)$current['id']]);
                $pdo->prepare("UPDATE addresses SET is_default = 1 WHERE id = ? AND customer_id = ?")->execute([$addressId, (int)$current['id']]);
            }
        }
        $addresses = Auth::getCustomerAddresses((int)$current['id']);
        echo json_encode(['success' => true, 'message' => 'Default ' . $type . ' address updated successfully.', 'addresses' => $addresses], JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'delete_address' || $action === 'delete') {
        dt_api_require_csrf(null, $data);
        $current = Auth::getCurrentUser();
        if ($current === null || empty($current['id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Please sign in to delete address.']);
            exit;
        }
        $addressId = (int)($data['id'] ?? ($data['address_id'] ?? 0));
        if ($addressId <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Valid address ID is required.']);
            exit;
        }
        $pdo = Database::getConnection();
        if ($pdo !== null) {
            // Guard: prevent deleting customer's sole shipping address
            $cntStmt = $pdo->prepare("SELECT COUNT(*) FROM addresses WHERE customer_id = ? AND address_type != 'billing'");
            $cntStmt->execute([(int)$current['id']]);
            if ((int)$cntStmt->fetchColumn() <= 1) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => 'Cannot delete your only saved shipping address. A customer must have at least one registered address.'
                ]);
                exit;
            }

            $pdo->prepare("DELETE FROM addresses WHERE id = ? AND customer_id = ? AND address_type != 'billing'")->execute([$addressId, (int)$current['id']]);

            // Promote remaining address if default was deleted
            $defCheck = $pdo->prepare("SELECT COUNT(*) FROM addresses WHERE customer_id = ? AND is_default = 1 AND address_type != 'billing'");
            $defCheck->execute([(int)$current['id']]);
            if ((int)$defCheck->fetchColumn() === 0) {
                $pdo->prepare("UPDATE addresses SET is_default = 1 WHERE customer_id = ? AND address_type != 'billing' ORDER BY id DESC LIMIT 1")->execute([(int)$current['id']]);
            }
        }
        $addresses = Auth::getCustomerAddresses((int)$current['id']);
        echo json_encode(['success' => true, 'message' => 'Address deleted successfully.', 'addresses' => $addresses], JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'change_password') {
        dt_api_require_csrf(null, $data);
        $current = Auth::getCurrentUser();
        if ($current === null || empty($current['id'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Please sign in to change your password.']);
            exit;
        }
        $res = Auth::changePassword(
            (int)$current['id'],
            (string)($data['current_password'] ?? ''),
            (string)($data['new_password'] ?? '')
        );
        if (!$res['success']) {
            http_response_code(400);
        }
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'forgot_password') {
        // Always answers the same way whether or not the account exists, so this
        // cannot be used to enumerate registered phone numbers.
        $identity = trim($data['identity'] ?? ($data['phone'] ?? ($data['email'] ?? '')));
        $res = Auth::requestPasswordReset($identity);
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'admin_login') {
        $email = trim($data['email'] ?? ($data['username'] ?? ($data['phone'] ?? ($data['identity'] ?? ''))));
        $password = $data['password'] ?? '';
        $res = Auth::adminLogin($email, $password);

        if (!$res['success']) {
            http_response_code(401);
        }
        echo json_encode($res, JSON_PRETTY_PRINT);
        exit;
    }

    if ($action === 'session') {
        $user = Auth::getCurrentUser();
        $isAdmin = dt_api_is_admin();
        $admin = $_SESSION['admin_user'] ?? ($_SESSION['admin'] ?? null);
        $csrfToken = Auth::generateCsrfToken();
        echo json_encode([
            'authenticated' => ($user !== null),
            'user' => $user,
            'admin_authenticated' => $isAdmin,
            'admin' => $admin,
            'csrf_token' => $csrfToken
        ], JSON_PRETTY_PRINT);
        exit;
    }

    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid auth action.']);

} catch (\Throwable $e) {
    // The raw exception text used to be returned as the JSON message, so any
    // schema or connection fault surfaced in the storefront's alert box as a
    // PDO string naming tables and columns. Log it, answer plainly.
    error_log('DT api/auth.php failed: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Something went wrong on our side. Please try again shortly, or message us on WhatsApp.']);
}
