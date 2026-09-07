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
    
    // Use stronger hash for session IDs (PHP 7.1+)
    ini_set('session.sid_length', '48');
    ini_set('session.sid_bits_per_character', '6');
    
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
    
    $savePath = __DIR__ . '/../storage/sessions';
    if (!is_dir($savePath)) {
        @mkdir($savePath, 0750, true);
    }
    ini_set('session.save_path', $savePath);
}

/**
 * Initialize secure session with all the above settings
 * Call this function instead of session_start() directly
 */
function dt_session_start(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Regenerate session ID periodically for security
    if (empty($_SESSION['_created'])) {
        $_SESSION['_created'] = time();
    } elseif (time() - $_SESSION['_created'] > 1800) { // 30 minutes
        session_regenerate_id(true);
        $_SESSION['_created'] = time();
    }
    
    // Mark session as active
    $_SESSION['_last_activity'] = time();
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