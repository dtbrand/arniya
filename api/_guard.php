<?php
/**
 * api/_guard.php — Admin authorisation guard for JSON API endpoints.
 * DT Brand's & Jai Hanuman Tex
 *
 * The admin console pages are protected by admin/includes/adminguard.php, which
 * redirects a browser to /admin/login.php. That is the wrong behaviour for an
 * API: a fetch() would silently receive a login page as its "JSON" response.
 * This guard is the API-shaped equivalent — it answers 401 with a JSON body and
 * stops the script.
 *
 * Every endpoint that can WRITE admin-owned data must call dt_api_require_admin()
 * before doing so. Endpoints that mix public reads with admin writes (products,
 * coupons) call it per action rather than at the top of the file, so the
 * storefront keeps working.
 *
 * It reads the same session keys the console guard sets, so one admin login
 * covers both.
 */

if (!function_exists('dt_api_is_admin')) {
    /**
     * True only when this request carries a real, logged-in admin session.
     */
    function dt_api_is_admin(): bool
    {
        // 1. Ensure centralized session configuration is loaded
        $sessConfig = __DIR__ . '/../config/session.php';
        if (file_exists($sessConfig)) {
            require_once $sessConfig;
        }

        if (function_exists('dt_session_start')) {
            dt_session_start();
        } elseif (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }

        // 2. Check standard admin session indicators
        if (!empty($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            return true;
        }
        if (!empty($_SESSION['admin_user']['id'])) {
            return true;
        }
        if (!empty($_SESSION['user']['role']) && in_array(strtolower((string)$_SESSION['user']['role']), ['admin', 'super_admin'], true)) {
            return true;
        }
        if (!empty($_SESSION['admin']) && is_array($_SESSION['admin'])) {
            return true;
        }

        // 3. Check if standard PHPSESSID has the session if different session_name was active
        if (!empty($_COOKIE['PHPSESSID']) && session_name() !== 'PHPSESSID') {
            $currName = session_name();
            @session_write_close();
            session_name('PHPSESSID');
            @session_start();
            $phOk = (!empty($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true)
                 || (!empty($_SESSION['admin_user']['id']))
                 || (!empty($_SESSION['user']['role']) && in_array(strtolower((string)$_SESSION['user']['role']), ['admin', 'super_admin'], true));
            if ($phOk) {
                return true;
            }
            @session_write_close();
            session_name($currName);
            @session_start();
        }

        return false;
    }
}

if (!function_exists('dt_api_require_admin')) {
    /**
     * Stop the request with a JSON 401 unless an admin is signed in.
     */
    function dt_api_require_admin(string $what = ''): void
    {
        if (dt_api_is_admin()) {
            return;
        }

        if (!headers_sent()) {
            http_response_code(401);
            header('Content-Type: application/json; charset=utf-8');
        }
        echo json_encode([
            'success' => false,
            'error'   => 'unauthorized',
            'message' => 'Admin sign-in required' . ($what !== '' ? ' to ' . $what : '') . '. Please sign in at /admin/login.php and try again.'
        ]);
        exit;
    }
}
