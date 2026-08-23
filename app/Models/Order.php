<?php

namespace App\Models;

use DTBrand\OrderManager;

/**
 * Order Model
 * DT Brand's & Jai Hanuman Tex
 */
class Order
{
    public static function create(array $data): array
    {
        return OrderManager::createOrder($data);
    }
}
