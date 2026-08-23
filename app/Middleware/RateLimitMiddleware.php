<?php

namespace App\Middleware;

/**
 * RateLimitMiddleware — Simple In-Memory Rate Limiting Guard
 * DT Brand's & Jai Hanuman Tex
 */
class RateLimitMiddleware
{
    public static function check(int $maxRequests = 120, int $decaySeconds = 60): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $now = time();
        if (!isset($_SESSION['rate_limit_window']) || ($now - $_SESSION['rate_limit_window']) > $decaySeconds) {
            $_SESSION['rate_limit_window'] = $now;
            $_SESSION['rate_limit_count'] = 1;
            return true;
        }

        $_SESSION['rate_limit_count']++;
        return $_SESSION['rate_limit_count'] <= $maxRequests;
    }
}
