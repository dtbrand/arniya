<?php
/**
 * Shared/Auth/logout.php — Shared Auth Logout Controller
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
if ($target === 'admin' || (isset($_GET['admin']) && $_GET['admin'] == '1')) {
    header("Location: /Frontend/Admin/adminlogin.php?logged_out=1");
} else {
    header("Location: /?logged_out=1");
}
exit;
