<?php
/**
 * bootstrap.php — Global Application Bootstrap
 * DT Brand's & Jai Hanuman Tex
 *
 * Loads .env, sets error handling, timezone, and DB connection.
 * Include this as the FIRST thing in every entry point.
 */

// ── 1. Error Reporting (suppress display in production, log only) ──
error_reporting(E_ALL);
@ini_set('display_errors', '0');
@ini_set('log_errors', '1');

// ── 2. Timezone ──
date_default_timezone_set('Asia/Kolkata');

// ── 3. Load .env file (once per request) ──
if (!defined('DT_ENV_LOADED')) {
    define('DT_ENV_LOADED', true);

    $envFile = dirname(__DIR__) . '/.env';
    if (!file_exists($envFile)) {
        // Try relative path (when bootstrap is in includes/ or src/)
        $envFile = dirname(dirname(__DIR__)) . '/.env';
    }
    if (!file_exists($envFile)) {
        $envFile = $_SERVER['DOCUMENT_ROOT'] . '/.env';
    }

    if (file_exists($envFile)) {
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#') {
                continue;
            }
            if (strpos($line, '=') !== false) {
                [$key, $val] = explode('=', $line, 2);
                $key = trim($key);
                $val = trim($val, " \t\"'");
                if (!getenv($key)) {
                    putenv("{$key}={$val}");
                    $_ENV[$key] = $val;
                    $_SERVER[$key] = $val;
                }
            }
        }
    }
}

// ── 4. Session (start if not already running) ──
$sessConfig = dirname(__DIR__) . '/config/session.php';
if (file_exists($sessConfig)) {
    require_once $sessConfig;
}
if (function_exists('dt_session_start')) {
    dt_session_start();
} elseif (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 86400,
        'path'     => '/',
        'secure'   => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}
