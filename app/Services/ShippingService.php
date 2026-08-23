<?php

namespace App\Services;

/**
 * ShippingService
 * DT Brand's & Jai Hanuman Tex
 */
class ShippingService
{
    public function calculateShippingFee(float $orderSubtotal): float
    {
        if ($orderSubtotal >= 1999.00 || $orderSubtotal === 0.0) {
            return 0.0;
        }
        return 150.00;
    }
}
