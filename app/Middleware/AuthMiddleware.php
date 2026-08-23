<?php

namespace App\Middleware;

/**
 * AuthMiddleware — Admin & Partner Session Authentication Guard
 * DT Brand's & Jai Hanuman Tex
 */
class AuthMiddleware
{
    public static function checkAdmin(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }

    public static function requireAdmin(): void
    {
        if (!self::checkAdmin()) {
            header('Location: /Frontend/Admin/adminlogin.php');
            exit;
        }
    }
}
