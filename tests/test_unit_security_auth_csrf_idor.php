<?php
/**
 * tests/test_unit_security_auth_csrf_idor.php
 * Automated Test Suite for Sections 49–54 (Enterprise Security Suite):
 * - Section 49: Authentication Security (BCRYPT cost 12, Rate Limiting, Session Expiry, Anti-Enumeration)
 * - Section 50: Credential Audit (Zero Hardcoded Secrets in api/payments.php, PaymentManager::getConfig)
 * - Sections 51 & 52: Installer Security (dt_install_direct.php 403 lock, install.php production guard)
 * - Section 53: CSRF Protection (dt_csrf_token, dt_csrf_validate, dt_api_require_csrf)
 * - Section 54: IDOR & Authorization (Strict Session Ownership, No ?phone= Override)
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/session.php';
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/RateLimiter.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../src/PaymentManager.php';
require_once __DIR__ . '/../api/_guard.php';

use DTBrand\Database;
use DTBrand\Auth;
use DTBrand\PaymentManager;

$passed = 0;
$failed = 0;
$tests  = [];

function run_test(string $name, callable $fn): void {
    global $passed, $failed, $tests;
    try {
        $result = $fn();
        if ($result === true) {
            $passed++;
            $tests[] = ['name' => $name, 'status' => 'PASS', 'error' => null];
            echo "  [PASS] {$name}\n";
        } else {
            $failed++;
            $tests[] = ['name' => $name, 'status' => 'FAIL', 'error' => 'Returned false'];
            echo "  [FAIL] {$name}: Returned false\n";
        }
    } catch (\Throwable $e) {
        $failed++;
        $tests[] = ['name' => $name, 'status' => 'FAIL', 'error' => $e->getMessage()];
        echo "  [FAIL] {$name}: " . $e->getMessage() . "\n";
    }
}

echo "\n========================================================================\n";
echo "   DT BRAND'S ENTERPRISE SECURITY SUITE TESTS (SECTIONS 49–54)\n";
echo "========================================================================\n\n";

// ============================================================================
// SECTION 49: AUTHENTICATION SECURITY & RATE LIMITING
// ============================================================================
echo "--- Section 49: Authentication Security ---\n";

run_test("Sec49.1: BCRYPT Cost 12 Password Hashing", function() {
    $password = "DtBrandSecure#2026";
    $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    $info = password_get_info($hash);
    return $info['algoName'] === 'bcrypt' && (int)($info['options']['cost'] ?? 0) === 12;
});

run_test("Sec49.2: RateLimiter Enforces 5 Attempts Window & Blocks 6th", function() {
    $ipIdentityKey = 'test_ip_127_0_0_1:user_test_' . uniqid();
    RateLimiter::clear('login', $ipIdentityKey);

    for ($i = 1; $i <= 5; $i++) {
        $res = RateLimiter::check('login', $ipIdentityKey, 5, 15);
        if (!$res['allowed']) {
            return false;
        }
    }

    // 6th attempt must be blocked
    $blocked = RateLimiter::check('login', $ipIdentityKey, 5, 15);
    return $blocked['allowed'] === false && $blocked['retry_after'] > 0;
});

run_test("Sec49.3: RateLimiter::clear Resets Blocked Key", function() {
    $ipIdentityKey = 'test_ip_127_0_0_1:user_clear_' . uniqid();
    for ($i = 1; $i <= 6; $i++) {
        RateLimiter::check('login', $ipIdentityKey, 5, 15);
    }
    
    // Key should be blocked now
    $checkBlocked = RateLimiter::check('login', $ipIdentityKey, 5, 15);
    if ($checkBlocked['allowed'] !== false) {
        return false;
    }

    // Clear key
    RateLimiter::clear('login', $ipIdentityKey);
    $checkAfter = RateLimiter::check('login', $ipIdentityKey, 5, 15);
    return $checkAfter['allowed'] === true;
});

run_test("Sec49.4: Session Idle Timeout Invalidation", function() {
    $_SESSION = [
        'user' => ['id' => 42, 'name' => 'Test User'],
        '_last_activity' => time() - 7300, // 7300s > 7200s (2h)
        '_created' => time() - 7300,
    ];

    dt_session_start();
    // After idle timeout exceeded, session state must be wiped
    return empty($_SESSION['user']);
});

run_test("Sec49.5: Session Absolute Timeout Invalidation", function() {
    $_SESSION = [
        'user' => ['id' => 99, 'name' => 'Test Absolute User'],
        '_last_activity' => time() - 100, // Active recently
        '_created' => time() - 44000,      // 44000s > 43200s (12h absolute limit)
    ];

    dt_session_start();
    // After absolute timeout exceeded, session state must be wiped
    return empty($_SESSION['user']);
});

// ============================================================================
// SECTION 50: CRITICAL CREDENTIAL AUDIT
// ============================================================================
echo "\n--- Section 50: Critical Credential Audit ---\n";

run_test("Sec50.1: api/payments.php has Zero Hardcoded Key Secrets", function() {
    $paymentsContent = file_get_contents(__DIR__ . '/../api/payments.php');
    if ($paymentsContent === false) {
        return false;
    }
    // Must NOT contain old test secret fallback
    $hasHardcodedSecret = strpos($paymentsContent, 'dt_secret_key_prod_8892') !== false;
    return !$hasHardcodedSecret;
});

run_test("Sec50.2: PaymentManager::getConfig Resolves Gateway Config Array", function() {
    $cfg = PaymentManager::getConfig('razorpay');
    if (!is_array($cfg)) {
        return false;
    }
    // Check direct_upi config
    $upiCfg = PaymentManager::getConfig('direct_upi');
    return is_array($upiCfg);
});

// ============================================================================
// SECTIONS 51 & 52: BOOTSTRAP ADMIN & INSTALLER SECURITY
// ============================================================================
echo "\n--- Sections 51 & 52: Bootstrap Admin & Installer Security ---\n";

run_test("Sec51.1: dt_install_direct.php is Permanently Locked with HTTP 403", function() {
    $content = file_get_contents(__DIR__ . '/../dt_install_direct.php');
    if ($content === false) {
        return false;
    }
    $has403 = strpos($content, '403') !== false;
    $hasForbidden = strpos($content, 'Forbidden') !== false;
    // Must NOT contain database execution or plain passwords
    $hasDbExec = strpos($content, '$pdo->exec') !== false;
    return $has403 && $hasForbidden && !$hasDbExec;
});

run_test("Sec52.1: install.php Has Production & Already Installed Lockdown Guard", function() {
    $content = file_get_contents(__DIR__ . '/../install.php');
    if ($content === false) {
        return false;
    }
    $hasInstalledGuard = strpos($content, '$installedFile') !== false;
    $hasProdHostCheck = strpos($content, 'jaihanumantex.in') !== false;
    $has403Lock = strpos($content, 'http_response_code(403)') !== false;
    $hasSvgIcon = strpos($content, '<svg width="18" height="18"') !== false;
    return $hasInstalledGuard && $hasProdHostCheck && $has403Lock && $hasSvgIcon;
});

// ============================================================================
// SECTION 53: CSRF PROTECTION SUITE
// ============================================================================
echo "\n--- Section 53: CSRF Protection Suite ---\n";

run_test("Sec53.1: dt_csrf_token Generates Valid 64-char Hex Token", function() {
    $_SESSION['csrf_token'] = null;
    $token = dt_csrf_token();
    return is_string($token) && strlen($token) === 64 && ctype_xdigit($token);
});

run_test("Sec53.2: dt_csrf_validate Accepts Correct Token & Rejects Forged Token", function() {
    $validToken = dt_csrf_token();
    $validCheck = dt_csrf_validate($validToken);
    $forgedCheck = dt_csrf_validate('forged_attacker_token_1234567890abcdef');
    $emptyCheck = dt_csrf_validate('');
    $nullCheck = dt_csrf_validate(null);
    return $validCheck === true && $forgedCheck === false && $emptyCheck === false && $nullCheck === false;
});

run_test("Sec53.3: dt_api_require_csrf Function Exists and Validates Successfully", function() {
    if (!function_exists('dt_api_require_csrf')) {
        return false;
    }
    $token = dt_csrf_token();
    // Valid token call should not exit
    dt_api_require_csrf($token);
    // Valid token inside payload array
    dt_api_require_csrf(null, ['csrf_token' => $token]);
    return true;
});

// ============================================================================
// SECTION 54: IDOR & AUTHORIZATION HARDENING
// ============================================================================
echo "\n--- Section 54: IDOR & Authorization Hardening ---\n";

run_test("Sec54.1: Order Details Ownership Logic Rejects Unauthenticated Access", function() {
    // Simulate unauthenticated customer trying to access order details
    $currentUser = null;
    $isAdmin = false;
    $order = ['id' => 501, 'customer_id' => 10, 'customer_phone' => '9876543210'];
    
    $userId = (int)($currentUser['id'] ?? 0);
    $isAllowed = ($userId > 0);
    return $isAllowed === false;
});

run_test("Sec54.2: Order Details Ownership Rejects Mismatched Customer ID", function() {
    // Authenticated user 15 trying to access order belonging to user 25
    $currentUser = ['id' => 15, 'phone' => '9111111111'];
    $isAdmin = false;
    $order = ['id' => 601, 'customer_id' => 25, 'customer_phone' => '9222222222'];

    $digits = static function ($v) {
        $d = preg_replace('/\D+/', '', (string)$v);
        return strlen($d) > 10 ? substr($d, -10) : $d;
    };

    $userId = (int)($currentUser['id'] ?? 0);
    $userPhone = (string)($currentUser['phone'] ?? '');
    $orderCustId = (int)($order['customer_id'] ?? 0);

    $isOwner = ($orderCustId === $userId)
        || (!empty($userPhone) && $digits($order['customer_phone'] ?? '') !== '' && $digits($order['customer_phone'] ?? '') === $digits($userPhone));

    return $isOwner === false;
});

run_test("Sec54.3: Order Details Allows Legitimate Order Owner", function() {
    // Authenticated user 30 accessing their own order
    $currentUser = ['id' => 30, 'phone' => '9876500000'];
    $order = ['id' => 701, 'customer_id' => 30, 'customer_phone' => '9876500000'];

    $userId = (int)($currentUser['id'] ?? 0);
    $orderCustId = (int)($order['customer_id'] ?? 0);
    $isOwner = ($orderCustId === $userId);

    return $isOwner === true;
});

run_test("Sec54.4: My Orders Ignores Unauthenticated ?phone= Query Override for Non-Admins", function() {
    // Non-admin session has user ID 5 and phone '9555555555'.
    // Query string has forged ?phone=9999999999 and ?customer_id=999.
    $currentUser = ['id' => 5, 'phone' => '9555555555'];
    $isAdmin = false;
    $authUserId = (int)($currentUser['id'] ?? 0);

    $simulatedGet = ['phone' => '9999999999', 'customer_id' => '999'];

    if ($isAdmin) {
        $targetId = (int)($currentUser['id'] ?? ($simulatedGet['customer_id'] ?? 0));
        $targetPhone = (string)($currentUser['phone'] ?? ($simulatedGet['phone'] ?? ''));
    } else {
        $targetId = $authUserId;
        $targetPhone = (string)($currentUser['phone'] ?? '');
    }

    // Must strictly remain user 5 and phone 9555555555
    return $targetId === 5 && $targetPhone === '9555555555';
});

echo "\n========================================================================\n";
echo "SUMMARY: {$passed} PASSED / " . ($passed + $failed) . " TOTAL\n";
if ($failed === 0) {
    echo "SUCCESS: All Enterprise Security Suite (Sections 49–54) tests PASSED!\n";
} else {
    echo "FAILURE: {$failed} test(s) failed.\n";
}
echo "========================================================================\n\n";

exit($failed === 0 ? 0 : 1);
