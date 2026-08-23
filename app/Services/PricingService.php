<?php

namespace App\Services;

use DTBrand\PricingCalculator;

/**
 * PricingService
 * DT Brand's & Jai Hanuman Tex
 */
class PricingService
{
    public function computeWholesale(float $mrp, float $discountPercent): float
    {
        return PricingCalculator::calculateWholesalePrice($mrp, $discountPercent);
    }

    public function computeOrder(float $subtotal, float $discount = 0.0, float $shipping = 0.0, float $gstRate = 5.0): array
    {
        return PricingCalculator::calculateOrderTotal($subtotal, $discount, $shipping, $gstRate);
    }
}
