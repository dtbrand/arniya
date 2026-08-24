<?php
/**
 * db.php — Centralized Database Connection Bridge
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/PricingCalculator.php';
require_once __DIR__ . '/src/DiscountEngine.php';
require_once __DIR__ . '/src/ProductCatalog.php';
require_once __DIR__ . '/src/OrderManager.php';
require_once __DIR__ . '/src/CustomerManager.php';

use DTBrand\Database;

$pdo = Database::getConnection();
$is_db_connected = ($pdo !== null);
