<?php

namespace App\Models;

use DTBrand\CustomerManager;

/**
 * Reseller Model
 * DT Brand's & Jai Hanuman Tex
 */
class Reseller
{
    public static function all(): array
    {
        return CustomerManager::getByType('reseller');
    }
}
