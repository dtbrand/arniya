<?php
/**
 * config/session.php — Secure Session Configuration
 * DT Brand's & Jai Hanuman Tex
 * 
 * Must be called BEFORE session_start() in any script that uses sessions.
 * Include this file at the very top of your PHP scripts.
 */

// Only configure if sessions haven't started yet
if (session_status() === PHP_SESSION_NONE) {
    
    // ─────────────────────────────────────────────────────────────────────────────
    // SECURITY SETTINGS
    // ─────────────────────────────────────────────────────────────────────────────
    
    // Use cookies only (no URL session IDs)
    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_trans_sid', '0');
    
    // Prevent JavaScript access to session cookie (XSS protection)
    ini_set('session.cookie_httponly', '1');
    
    // Secure flag - only transmit over HTTPS (production)
    // On localhost/dev without HTTPS, this will be false
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
               (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    ini_set('session.cookie_secure', $isHttps ? '1' : '0');
    
    // SameSite protection (CSRF mitigation)
    // Lax allows normal navigation, Strict blocks cross-site entirely
    ini_set('session.cookie_samesite', 'Lax');
    
    // Cookie lifetime - 2 hours for active sessions
    ini_set('session.cookie_lifetime', '7200'); // 2 hours
    
    // Garbage collection - clean up old sessions
    ini_set('session.gc_maxlifetime', '7200');
    ini_set('session.gc_probability', '1');
    ini_set('session.gc_divisor', '100');
    
    // ─────────────────────────────────────────────────────────────────────────────
    // SESSION ID SECURITY
    // ─────────────────────────────────────────────────────────────────────────────
    
    // Use stronger hash for session IDs (PHP 7.1+; deprecated in PHP 8.4+)
    @ini_set('session.sid_length', '48');
    @ini_set('session.sid_bits_per_character', '6');
    
    // Strict mode - only accept existing session IDs, never create new ones from URL
    ini_set('session.use_strict_mode', '1');
    
    // ─────────────────────────────────────────────────────────────────────────────
    // CACHE CONTROL
    // ─────────────────────────────────────────────────────────────────────────────
    
    // Prevent caching of authenticated pages
    ini_set('session.cache_limiter', 'nocache');
    ini_set('session.cache_expire', '0');
    
    // ─────────────────────────────────────────────────────────────────────────────
    // CUSTOM SESSION NAME (avoids conflicts with other apps)
    // ─────────────────────────────────────────────────────────────────────────────
    
    session_name('DTBRANDS_SESS');
    
    // ─────────────────────────────────────────────────────────────────────────────
    // SAVE PATH (use custom directory for better isolation)
    // ─────────────────────────────────────────────────────────────────────────────
    
    $configuredSavePath = trim((string)(getenv('DT_SESSION_SAVE_PATH') ?: ''));
    $savePathCandidates = array_filter([
        $configuredSavePath,
        __DIR__ . '/../storage/sessions',
        rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'dtbrands_sessions',
    ]);

    foreach ($savePathCandidates as $candidatePath) {
        if (dt_session_directory_is_writable($candidatePath)) {
            ini_set('session.save_path', $candidatePath);
            break;
        }
    }
}

/**
 * Verify a session directory can really accept files.
 *
 * PHP's is_writable() can be optimistic on Windows ACLs, so a tiny temp-file
 * probe keeps CLI audits and production logins from selecting a broken path.
 */
function dt_session_directory_is_writable(string $path): bool
{
    $path = rtrim($path, "/\\");
    if ($path === '') {
        return false;
    }

    if (!is_dir($path) && !@mkdir($path, 0750, true) && !is_dir($path)) {
        return false;
    }

    $realPath = realpath($path);
    if ($realPath === false) {
        return false;
    }

    $probe = @tempnam($realPath, 'dt_sess_');
    if ($probe === false) {
        return false;
    }

    $probeDir = realpath(dirname($probe));
    @unlink($probe);

    return $probeDir !== false && strcasecmp($probeDir, $realPath) === 0;
}

/**
 * Initialize secure session with all the above settings
 * Call this function instead of session_start() directly
 */
function dt_session_start(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        if (PHP_SAPI === 'cli' && !empty($_SESSION)) {
            // Unit tests and CLI probes often seed $_SESSION directly before
            // exercising auth logic. Starting a failed file-backed session here
            // would wipe those values, so preserve the in-memory request state.
        } elseif (!@session_start()) {
            error_log('DT session start failed; continuing with in-memory session state for this request.');
            if (!isset($_SESSION) || !is_array($_SESSION)) {
                $_SESSION = [];
            }
        }
    }

    if (!isset($_SESSION) || !is_array($_SESSION)) {
        $_SESSION = [];
    }
    
    // Enforce idle timeout (2 hours / 7200s) and absolute timeout (12 hours / 43200s)
    $now = time();
    if (!empty($_SESSION['_last_activity']) && ($now - $_SESSION['_last_activity']) > 7200) {
        // Idle timeout exceeded: invalidate existing session
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }
    if (!empty($_SESSION['_created']) && ($now - $_SESSION['_created']) > 43200) {
        // Absolute timeout exceeded: invalidate existing session
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }

    // Regenerate session ID periodically for security (every 30 minutes)
    if (empty($_SESSION['_created'])) {
        $_SESSION['_created'] = $now;
    } elseif ($now - $_SESSION['_created'] > 1800) {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
        $_SESSION['_created'] = $now;
    }
    
    // Mark session as active
    $_SESSION['_last_activity'] = $now;
}

/**
 * Destroy session completely (logout)
 */
function dt_session_destroy(): void
{
    dt_session_start();
    
    // Unset all session variables
    $_SESSION = [];
    
    // Delete session cookie
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    
    // Destroy session data
    session_destroy();
}

/**
 * Check if session is still valid (not expired)
 */
function dt_session_is_valid(int $maxIdle = 7200): bool
{
    dt_session_start();
    
    if (empty($_SESSION['_last_activity'])) {
        return false;
    }
    
    return (time() - $_SESSION['_last_activity']) < $maxIdle;
}

/**
 * Get CSRF token for forms (double-submit cookie pattern)
 */
function dt_csrf_token(): string
{
    dt_session_start();
    
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

/**
 * Validate CSRF token
 */
function dt_csrf_validate(?string $token): bool
{
    dt_session_start();
    
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Require valid CSRF token (exit on failure)
 */
function dt_csrf_require(?string $token = null): void
{
    $token = $token ?? ($_POST['_csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
    
    if (!dt_csrf_validate($token)) {
        http_response_code(403);
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'error' => 'csrf_invalid',
            'message' => 'Invalid or missing CSRF token. Please refresh the page and try again.'
        ]);
        exit;
    }
}
