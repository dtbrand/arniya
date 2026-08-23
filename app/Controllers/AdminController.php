<?php

namespace App\Controllers;

/**
 * AdminController — Executive Admin Control Router
 * DT Brand's & Jai Hanuman Tex
 */
class AdminController
{
    public function dashboard(): void
    {
        require_once __DIR__ . '/../../Frontend/Admin/admin.php';
    }

    public function login(): void
    {
        require_once __DIR__ . '/../../Frontend/Admin/adminlogin.php';
    }
}
