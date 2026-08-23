<?php

namespace DTBrand;

/**
 * DiscountEngine — Coupon, Promo Code & Tiered Discount Validation
 * DT Brand's & Jai Hanuman Tex
 */
class DiscountEngine
{
    /**
     * Apply coupon code to subtotal
     */
    public static function applyCoupon(string $code, float $subtotal, array $availableCoupons): array
    {
        $code = strtoupper(trim($code));

        if (!isset($availableCoupons[$code])) {
            return [
                'valid' => false,
                'discount' => 0.0,
                'message' => 'Coupon code does not exist'
            ];
        }

        $coupon = $availableCoupons[$code];

        if ($subtotal < ($coupon['min_order'] ?? 0)) {
            return [
                'valid' => false,
                'discount' => 0.0,
                'message' => 'Minimum order value of ₹' . number_format($coupon['min_order']) . ' required'
            ];
        }

        $discount = 0.0;
        if ($coupon['type'] === 'percent') {
            $discount = round($subtotal * ($coupon['value'] / 100), 2);
            if (isset($coupon['max_discount']) && $coupon['max_discount'] > 0) {
                $discount = min($discount, $coupon['max_discount']);
            }
        } elseif ($coupon['type'] === 'flat') {
            $discount = min($subtotal, $coupon['value']);
        }

        return [
            'valid' => true,
            'code' => $code,
            'discount' => $discount,
            'message' => 'Coupon applied successfully'
        ];
    }
}
