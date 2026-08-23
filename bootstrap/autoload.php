<?php
/**
 * bootstrap/autoload.php — Universal PSR-4 Autoloader
 * DT Brand's & Jai Hanuman Tex
 */

if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once __DIR__ . '/../vendor/autoload.php';
}

spl_autoload_register(function ($class) {
    // App namespace mapping
    if (str_starts_with($class, 'App\\')) {
        $relPath = str_replace(['App\\', '\\'], ['', '/'], $class) . '.php';
        $fullPath = __DIR__ . '/../app/' . $relPath;
        if (file_exists($fullPath)) {
            require_once $fullPath;
            return;
        }
    }

    // DTBrand namespace mapping
    if (str_starts_with($class, 'DTBrand\\')) {
        $relPath = str_replace(['DTBrand\\', '\\'], ['', '/'], $class) . '.php';
        $fullPath = __DIR__ . '/../src/' . $relPath;
        if (file_exists($fullPath)) {
            require_once $fullPath;
            return;
        }
    }
});
