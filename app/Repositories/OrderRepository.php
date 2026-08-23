<?php

namespace App\Repositories;

use App\Models\Order;

/**
 * OrderRepository
 * DT Brand's & Jai Hanuman Tex
 */
class OrderRepository
{
    public function save(array $orderData): array
    {
        return Order::create($orderData);
    }
}
