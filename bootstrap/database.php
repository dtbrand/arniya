<?php
/**
 * bootstrap/database.php — Database Connection Bootstrap
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/autoload.php';

use DTBrand\Database;

return Database::getConnection();
