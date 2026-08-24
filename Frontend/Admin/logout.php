<?php
/**
 * logout.php — Admin Console Secure Logout Controller
 * Clears Admin Session and redirects to Admin Login
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

unset($_SESSION['admin_logged_in']);
unset($_SESSION['admin_user']);
unset($_SESSION['user_id']);
unset($_SESSION['user_role']);
unset($_SESSION['user_name']);

// Clear all session variables
$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

header("Location: /Frontend/Admin/adminlogin.php?logged_out=1");
exit;
