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
        if (!empty($_SESSION['admin_user_id']) || !empty($_SESSION['admin_id'])) {
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

if (!function_exists('dt_api_require_csrf')) {
    /**
     * Enforce CSRF token verification on mutating requests.
     * Checks input payload ('csrf_token', '_csrf'), POST params, or HTTP headers.
     */
    function dt_api_require_csrf(?string $token = null, ?array $payload = null): void
    {
        $sessConfig = __DIR__ . '/../config/session.php';
        if (file_exists($sessConfig)) {
            require_once $sessConfig;
        }

        if ($token === null) {
            if (!empty($payload['csrf_token'])) {
                $token = (string)$payload['csrf_token'];
            } elseif (!empty($payload['_csrf'])) {
                $token = (string)$payload['_csrf'];
            } elseif (!empty($_POST['csrf_token'])) {
                $token = (string)$_POST['csrf_token'];
            } elseif (!empty($_POST['_csrf'])) {
                $token = (string)$_POST['_csrf'];
            } elseif (!empty($_SERVER['HTTP_X_CSRF_TOKEN'])) {
                $token = (string)$_SERVER['HTTP_X_CSRF_TOKEN'];
            } elseif (!empty($_SERVER['HTTP_X_XSRF_TOKEN'])) {
                $token = (string)$_SERVER['HTTP_X_XSRF_TOKEN'];
            }
        }

        $isValid = false;
        if (function_exists('dt_csrf_validate')) {
            $isValid = dt_csrf_validate($token);
        } elseif (class_exists('DTBrand\\Auth')) {
            $isValid = \DTBrand\Auth::validateCsrfToken($token);
        } elseif (!empty($_SESSION['csrf_token']) && !empty($token)) {
            $isValid = hash_equals((string)$_SESSION['csrf_token'], (string)$token);
        }

        if ($isValid) {
            return;
        }

        if (!headers_sent()) {
            http_response_code(403);
            header('Content-Type: application/json; charset=utf-8');
        }
        echo json_encode([
            'success' => false,
            'error'   => 'csrf_invalid',
            'message' => 'Invalid or missing CSRF security token. Please refresh and try again.'
        ]);
        exit;
    }
}

if (!function_exists('dt_api_error_response')) {
    /**
     * Return a standardized, safe JSON error response for uncaught exceptions.
     * Generates a correlation request ID, logs diagnostic details internally,
     * and guarantees that database credentials, SQL queries, and filesystem paths
     * are never leaked to the public response.
     */
    function dt_api_error_response(\Throwable $e, int $httpCode = 500, string $context = '', bool $exit = true): void
    {
        $requestId = 'req_' . substr(md5(uniqid((string)mt_rand(), true)), 0, 12);
        error_log("[{$requestId}] API Error in {$context}: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());

        if (!headers_sent()) {
            http_response_code($httpCode);
            header('Content-Type: application/json; charset=utf-8');
        }

        $isDev = in_array(strtolower((string)(getenv('APP_ENV') ?: (getenv('ENVIRONMENT') ?: ''))), ['local', 'development', 'dev', 'testing'], true);

        echo json_encode([
            'success'    => false,
            'error'      => 'server_error',
            'message'    => 'An unexpected system error occurred. Please try again shortly, or message our official WhatsApp concierge at +91 70463 63528.',
            'request_id' => $requestId,
            'detail'     => $isDev ? $e->getMessage() : null
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if ($exit) {
            exit;
        }
    }
}


