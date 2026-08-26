<?php
/**
 * adminguard.php — Admin console access guard.
 *
 * Blocks unauthenticated access to the admin panel. Designed to run BEFORE any
 * page output, so a redirect via header() is reliable. It is deliberately
 * fail-safe: any internal error is swallowed rather than allowed to 500 an
 * admin page (which would lock the owner out of the whole console).
 *
 * ROLLOUT — this file does nothing until it is invoked. Two supported ways:
 *   (A) Server auto-prepend (single choke point, no per-file edits):
 *         admin/.htaccess  ->  php_value auto_prepend_file "/abs/path/to/admin/Includes/adminguard.php"
 *       (or the equivalent .user.ini directive on PHP-CGI/FPM hosts like Hostinger).
 *   (B) Per-page include — add as the FIRST statement of every admin entry page
 *       (DOCUMENT_ROOT-anchored so it resolves regardless of folder depth):
 *         <?php $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;
 *
 * Public endpoints (login / logout) are always exempted so there is no redirect
 * loop and logout can complete.
 */

if (defined('DT_ADMIN_GUARD_RAN')) {
    return; // already evaluated this request
}
define('DT_ADMIN_GUARD_RAN', true);

(function (): void {
    try {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }

        // Resolve the request path (lower-cased) from the most reliable source.
        $rawUri = $_SERVER['REQUEST_URI'] ?? ($_SERVER['SCRIPT_NAME'] ?? '');
        $path = strtolower((string) (parse_url($rawUri, PHP_URL_PATH) ?: ($_SERVER['SCRIPT_NAME'] ?? '')));
        $script = strtolower((string) ($_SERVER['SCRIPT_NAME'] ?? ''));

        // Only guard admin-area requests. If this is somehow invoked for a
        // non-admin path (e.g. a global auto_prepend), do nothing.
        if (strpos($path, '/admin') === false && strpos($script, '/admin') === false) {
            return;
        }

        // Exempt the public endpoints: any login or logout route. Kept generous
        // on purpose — the cost of exempting an extra "login"-named page is tiny,
        // whereas failing to exempt the real login page causes a redirect loop.
        $haystack = $path . '|' . $script;
        if (strpos($haystack, 'login') !== false || strpos($haystack, 'logout') !== false) {
            return;
        }

        $loggedIn = !empty($_SESSION['admin_logged_in'])
            && $_SESSION['admin_logged_in'] === true
            && !empty($_SESSION['admin_user']['id']);

        if ($loggedIn) {
            return;
        }

        // Not authenticated — send to the login gateway before any output.
        $target = '/admin/login.php';
        if (!headers_sent()) {
            header('Location: ' . $target, true, 302);
        } else {
            // Fallback if output already began (should not happen when prepended).
            echo '<meta http-equiv="refresh" content="0;url=' . $target . '">';
            echo '<script>window.location.replace(' . json_encode($target) . ');</script>';
        }
        exit;
    } catch (\Throwable $e) {
        // Never take the admin console down on a guard failure. Fail open here so
        // a bug in the guard cannot lock the owner out; correctness of the guard
        // is verified before rollout.
    }
})();
