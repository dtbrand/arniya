<?php
/**
 * admin/includes/auth.php — Admin Auth Guard
 * DT Brand's & Jai Hanuman Tex
 */
use App\Middleware\AuthMiddleware;
AuthMiddleware::requireAdmin();
