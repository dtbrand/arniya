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
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
        return !empty($_SESSION['admin_logged_in'])
            && $_SESSION['admin_logged_in'] === true
            && !empty($_SESSION['admin_user']['id']);
    }
}

if (!function_exists('dt_api_require_admin')) {
    /**
     * Stop the request with a JSON 401 unless an admin is signed in.
     *
     * Deliberately fails CLOSED — unlike the console guard, refusing an API
     * call cannot lock the owner out of anything, so there is no reason to be
     * lenient here.
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
