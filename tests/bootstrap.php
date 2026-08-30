<?php
/**
 * PHPUnit Test Bootstrap
 * DT Brand's & Jai Hanuman Tex
 *
 * Loads every source class the tests reach into, then starts an in-memory
 * session so Auth::logout() / Auth::isLoggedIn() can run from CLI. Without
 * this, every Auth test fails with "session already started" warnings.
 */

declare(strict_types=1);

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Auth.php';
require_once __DIR__ . '/../src/PricingCalculator.php';
require_once __DIR__ . '/../src/DiscountEngine.php';
require_once __DIR__ . '/../src/ProductCatalog.php';
require_once __DIR__ . '/../src/OrderManager.php';
require_once __DIR__ . '/../src/CustomerManager.php';

if (session_status() === PHP_SESSION_NONE && PHP_SAPI === 'cli') {
    @session_set_save_handler(new \SessionHandler(), true);
    @session_start();
}