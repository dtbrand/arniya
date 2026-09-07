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

function cors_headers(): void
{
    global $allowedOrigins;
    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
    
    if (in_array($origin, $allowedOrigins, true)) {
        header('Access-Control-Allow-Origin: ' . $origin);
    } else {
        header('Access-Control-Allow-Origin: https://harmitethnic.com');
    }

    
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400'); // 24 hours
    header('Vary: Origin');
    
    // Security headers
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Content-Security-Policy: default-src \'self\'; script-src \'self\' \'unsafe-inline\' https://fonts.googleapis.com https://fonts.gstatic.com; style-src \'self\' \'unsafe-inline\' https://fonts.googleapis.com; font-src \'self\' https://fonts.gstatic.com; img-src \'self\' data: https:; connect-src \'self\' https://api.razorpay.com https://sandbox.cashfree.com https://api.cashfree.com; frame-src https://api.razorpay.com;');
}

function cors_preflight(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        cors_headers();
        http_response_code(200);
        exit;
    }
}

function cors_json(): void
{
    cors_headers();
    header('Content-Type: application/json; charset=utf-8');
}

// Call preflight handler immediately
cors_preflight();