<?php

namespace DTBrand;

/**
 * PricingCalculator — Core B2B, Wholesale, and Retail Price Calculation Engine
 * DT Brand's & Jai Hanuman Tex
 */
class PricingCalculator
{
    /**
     * Calculate wholesale price from MRP and discount percentage
     */
    public static function calculateWholesalePrice(float $mrp, float $discountPercent): float
    {
        if ($mrp < 0 || $discountPercent < 0 || $discountPercent > 100) {
            throw new \InvalidArgumentException('Invalid MRP or discount percentage');
        }
        return round($mrp * (1 - ($discountPercent / 100)), 2);
    }

    /**
     * Calculate GST amount
     */
    public static function calculateGst(float $amount, float $gstRate = 5.0): float
    {
        if ($amount < 0 || $gstRate < 0) {
            throw new \InvalidArgumentException('Invalid amount or GST rate');
        }
        return round($amount * ($gstRate / 100), 2);
    }

    /**
     * Calculate Net Total with GST and Gateway Fees
     */
    public static function calculateOrderTotal(float $subtotal, float $discount = 0.0, float $shipping = 0.0, float $gstRate = 5.0): array
    {
        $taxable = max(0, $subtotal - $discount);
        $gst = self::calculateGst($taxable, $gstRate);
        $grandTotal = round($taxable + $gst + $shipping, 2);

        return [
            'subtotal' => round($subtotal, 2),
            'discount' => round($discount, 2),
            'taxable' => round($taxable, 2),
            'gst' => $gst,
            'gst_amount' => $gst,
            'shipping' => round($shipping, 2),
            'grand_total' => $grandTotal
        ];
    }
}
