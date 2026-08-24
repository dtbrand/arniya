<?php
/**
 * 👑 DT BRAND'S & JAI HANUMAN TEX — SECURE ADMIN LOGOUT HANDLER
 * Destroys executive session, clears auth cookies, and redirects to login gateway.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Unset all session variables
$_SESSION = [];

// 2. Destroy session cookie if set
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// 3. Clear remember me / admin token cookies
setcookie('dt_admin_remember', '', time() - 3600, '/');
setcookie('dt_admin_token', '', time() - 3600, '/');
setcookie('dt_auth_token', '', time() - 3600, '/');

// 4. Destroy PHP session
session_destroy();

// 5. Handle AJAX/Fetch vs direct navigation
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest' || isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false) {
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'message' => 'Logged out successfully',
        'redirect' => '/admin/login.php?logged_out=1'
    ]);
    exit;
}

// 6. Direct HTTP Redirect
header('Location: /admin/login.php?logged_out=1');
exit;
