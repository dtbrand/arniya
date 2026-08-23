<?php

namespace App\Services;

use DTBrand\DiscountEngine;

/**
 * DiscountService
 * DT Brand's & Jai Hanuman Tex
 */
class DiscountService
{
    public function applyCoupon(string $code, float $orderSubtotal, array $couponDatabase): array
    {
        return DiscountEngine::applyCoupon($code, $orderSubtotal, $couponDatabase);
    }
}
