<?php
/**
 * api/cors.php — Centralized CORS Configuration
 * DT Brand's & Jai Hanuman Tex
 * 
 * Include this file at the top of every API endpoint to enforce
 * consistent CORS policy and security headers.
 */

$allowedOrigins = [
    'https://harmitethnic.com',
    'https://www.harmitethnic.com',
    'https://jaihanumantex.in',
    'https://www.jaihanumantex.in',
    'http://localhost',
    'http://localhost:3000',
    'http://localhost:8000',
    'http://127.0.0.1'
];

function dt_send_header(string $header): void
{
    $GLOBALS['__dt_sent_headers'][] = $header;
    if (!headers_sent()) {
        header($header);
    }
}

function cors_get_sent_headers(): array
{
    return $GLOBALS['__dt_sent_headers'] ?? [];
}

function cors_headers(): void
{
    global $allowedOrigins;
    $origins = is_array($allowedOrigins) ? $allowedOrigins : [
        'https://harmitethnic.com',
        'https://www.harmitethnic.com',
        'https://jaihanumantex.in',
        'https://www.jaihanumantex.in',
        'http://localhost',
        'http://localhost:3000',
        'http://localhost:8000',
        'http://127.0.0.1'
    ];
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
    
    if (in_array($origin, $origins, true)) {
        dt_send_header('Access-Control-Allow-Origin: ' . $origin);
    } else {
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $selfOrigin = rtrim($proto . $host, '/');
        if ($host !== '' && in_array($selfOrigin, $origins, true)) {
            dt_send_header('Access-Control-Allow-Origin: ' . $selfOrigin);
        } else {
            dt_send_header('Access-Control-Allow-Origin: https://jaihanumantex.in');
        }
    }

    dt_send_header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    dt_send_header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, X-CSRF-Token, X-XSRF-Token');
    dt_send_header('Access-Control-Allow-Credentials: true');
    dt_send_header('Access-Control-Max-Age: 86400'); // 24 hours
    dt_send_header('Vary: Origin');
    
    // Security headers
    dt_send_header('X-Content-Type-Options: nosniff');
    dt_send_header('X-Frame-Options: SAMEORIGIN');
    dt_send_header('X-XSS-Protection: 1; mode=block');
    dt_send_header('Referrer-Policy: strict-origin-when-cross-origin');
    dt_send_header('Permissions-Policy: geolocation=(), camera=(), microphone=()');
    
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
               (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https');
    if ($isHttps) {
        dt_send_header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    }
    
    dt_send_header('Content-Security-Policy: default-src \'self\'; script-src \'self\' \'unsafe-inline\' https://fonts.googleapis.com https://fonts.gstatic.com; style-src \'self\' \'unsafe-inline\' https://fonts.googleapis.com; font-src \'self\' https://fonts.gstatic.com; img-src \'self\' data: https:; connect-src \'self\' https://api.razorpay.com https://sandbox.cashfree.com https://api.cashfree.com; frame-src \'self\' https://api.razorpay.com;');
}

function cors_preflight(): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
        cors_headers();
        http_response_code(200);
        exit;
    }
}

function cors_json(): void
{
    cors_headers();
    if (!headers_sent()) {
        header('Content-Type: application/json; charset=utf-8');
    }
}

// Call preflight handler immediately
cors_preflight();