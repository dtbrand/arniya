<?php

namespace DTBrand;

/**
 * DiscountEngine — Coupon, Promo Code & Tiered Discount Validation
 * DT Brand's & Jai Hanuman Tex
 */
class DiscountEngine
{
    /**
     * Standard built-in fallback coupons
     */
    private static array $defaultCoupons = [
        'DTHANDLOOM10' => [
            'type' => 'percentage',
            'value' => 10.0,
            'min_order' => 1500.0,
            'max_discount' => 1000.0,
            'channel' => 'all'
        ],
        'FESTIVE500' => [
            'type' => 'fixed',
            'value' => 500.0,
            'min_order' => 5000.0,
            'max_discount' => 500.0,
            'channel' => 'all'
        ],
        'RESELLERVIP' => [
            'type' => 'percentage',
            'value' => 15.0,
            'min_order' => 2000.0,
            'max_discount' => 2500.0,
            'channel' => 'reseller'
        ]
    ];

    /**
     * Apply coupon code to subtotal with channel filtering
     */
    public static function applyCoupon(string $code, float $subtotal, ?array $availableCoupons = null, string $channel = 'all'): array
    {
        $code = strtoupper(trim($code));

        if (empty($code)) {
            return [
                'valid' => false,
                'discount' => 0.0,
                'message' => 'Please enter a coupon code.'
            ];
        }

        // 1. Try querying live database
        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("
                    SELECT * FROM coupons 
                    WHERE code = ? 
                      AND status = 'active' 
                      AND (starts_at IS NULL OR starts_at <= NOW()) 
                      AND (expires_at IS NULL OR expires_at >= NOW()) 
                      AND (used_count < usage_limit)
                    LIMIT 1
                ");
                $stmt->execute([$code]);
                $dbCoupon = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($dbCoupon) {
                    // Check channel restriction
                    if ($dbCoupon['channel'] !== 'all' && $channel !== 'all' && $dbCoupon['channel'] !== $channel) {
                        return [
                            'valid' => false,
                            'discount' => 0.0,
                            'message' => "This coupon is exclusively valid for {$dbCoupon['channel']} orders."
                        ];
                    }

                    $minOrder = (float)($dbCoupon['min_order_amount'] ?? 0);
                    if ($subtotal < $minOrder) {
                        return [
                            'valid' => false,
                            'discount' => 0.0,
                            'message' => 'Minimum order value of ₹' . number_format($minOrder, 2) . ' required.'
                        ];
                    }

                    $discount = 0.0;
                    $val = (float)$dbCoupon['discount_value'];
                    if ($dbCoupon['discount_type'] === 'percentage' || $dbCoupon['discount_type'] === 'percent') {
                        $discount = round($subtotal * ($val / 100.0), 2);
                        if (!empty($dbCoupon['max_discount']) && (float)$dbCoupon['max_discount'] > 0) {
                            $discount = min($discount, (float)$dbCoupon['max_discount']);
                        }
                    } else {
                        $discount = min($subtotal, $val);
                    }

                    return [
                        'valid' => true,
                        'code' => $code,
                        'discount' => $discount,
                        'title' => $dbCoupon['title'] ?? 'Coupon Discount',
                        'message' => 'Coupon ' . $code . ' applied successfully! You saved ₹' . number_format($discount, 2) . '.'
                    ];
                }
            } catch (\Exception $e) {
                // Fallback to in-memory dictionary
            }
        }

        // 2. Fallback dictionary check
        $coupons = $availableCoupons ?? self::$defaultCoupons;
        if (!isset($coupons[$code])) {
            return [
                'valid' => false,
                'discount' => 0.0,
                'message' => 'Invalid or expired coupon code: ' . $code
            ];
        }

        $coupon = $coupons[$code];
        $minOrder = (float)($coupon['min_order'] ?? 0);
        if ($subtotal < $minOrder) {
            return [
                'valid' => false,
                'discount' => 0.0,
                'message' => 'Minimum order value of ₹' . number_format($minOrder, 2) . ' required.'
            ];
        }

        $discount = 0.0;
        $val = (float)$coupon['value'];
        $type = $coupon['type'] ?? 'percentage';
        if ($type === 'percentage' || $type === 'percent') {
            $discount = round($subtotal * ($val / 100.0), 2);
            if (isset($coupon['max_discount']) && (float)$coupon['max_discount'] > 0) {
                $discount = min($discount, (float)$coupon['max_discount']);
            }
        } else {
            $discount = min($subtotal, $val);
        }

        return [
            'valid' => true,
            'code' => $code,
            'discount' => $discount,
            'title' => 'Festive Coupon',
            'message' => 'Coupon ' . $code . ' applied successfully! You saved ₹' . number_format($discount, 2) . '.'
        ];
    }
}

