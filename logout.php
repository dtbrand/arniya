<?php
/**
 * logout.php — Universal Secure Session Logout Controller
 * Clears all active sessions and redirects safely
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

$target = isset($_GET['type']) ? $_GET['type'] : '';
$customRedirect = isset($_GET['redirect']) ? trim($_GET['redirect']) : '';

if (!empty($customRedirect) && (strpos($customRedirect, '/') === 0 || strpos($customRedirect, 'https://') === 0 || strpos($customRedirect, 'http://') === 0)) {
    header("Location: " . $customRedirect);
} elseif ($target === 'admin' || (isset($_GET['admin']) && $_GET['admin'] == '1')) {
    header("Location: /Frontend/Admin/adminlogin.php?logged_out=1");
} else {
    header("Location: /?logged_out=1");
}
exit;
