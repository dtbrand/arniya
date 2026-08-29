<?php

namespace DTBrand;

/**
 * DiscountEngine — Coupon, Promo Code & Tiered Discount Validation
 * DT Brand's & Jai Hanuman Tex
 *
 * Live `coupons` schema: code, discount_type ENUM('percentage','flat'),
 * discount_value, min_order_value, max_discount, status ENUM('active','expired').
 * There is no channel / expiry / usage-limit column in production.
 */
class DiscountEngine
{
    /**
     * Built-in fallback coupons — mirror the live `coupons` seed exactly so
     * validation behaves identically whether or not MySQL is reachable.
     */
    private static array $defaultCoupons = [
        'FESTIVE25' => [
            'type' => 'percentage',
            'value' => 25.0,
            'min_order' => 1999.0,
            'max_discount' => 1500.0,
        ],
        'VIPRESELLER' => [
            'type' => 'percentage',
            'value' => 15.0,
            'min_order' => 3000.0,
            'max_discount' => 2000.0,
        ],
        'BULK50' => [
            'type' => 'percentage',
            'value' => 50.0,
            'min_order' => 20000.0,
            'max_discount' => 10000.0,
        ],
    ];

    /**
     * Apply a coupon code to a subtotal.
     *
     * The live coupons table has no channel column, so $channel is retained only
     * for backward compatibility with existing call sites and no longer filters.
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

        // 1. Authoritative check against the live database
        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("SELECT * FROM coupons WHERE code = ? AND status = 'active' LIMIT 1");
                $stmt->execute([$code]);
                $dbCoupon = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($dbCoupon) {
                    $minOrder = (float)($dbCoupon['min_order_value'] ?? 0);
                    if ($subtotal < $minOrder) {
                        return [
                            'valid' => false,
                            'discount' => 0.0,
                            'message' => 'Minimum order value of ₹' . number_format($minOrder, 2) . ' required for this coupon.'
                        ];
                    }

                    $val = (float)($dbCoupon['discount_value'] ?? 0);
                    if (($dbCoupon['discount_type'] ?? 'percentage') === 'flat') {
                        $discount = min($subtotal, $val);
                    } else {
                        $discount = round($subtotal * ($val / 100.0), 2);
                        if (!empty($dbCoupon['max_discount']) && (float)$dbCoupon['max_discount'] > 0) {
                            $discount = min($discount, (float)$dbCoupon['max_discount']);
                        }
                    }

                    return [
                        'valid' => true,
                        'code' => $code,
                        'discount' => $discount,
                        'title' => 'Coupon ' . $code,
                        'message' => 'Coupon ' . $code . ' applied! You saved ₹' . number_format($discount, 2) . '.'
                    ];
                }

                // Connected to the DB but no such active coupon — this is authoritative.
                return [
                    'valid' => false,
                    'discount' => 0.0,
                    'message' => 'Invalid or expired coupon code: ' . $code
                ];
            } catch (\Exception $e) {
                // Query failed (e.g. table missing) — fall through to the in-memory dictionary.
            }
        }

        // 2. Fallback dictionary (mock mode / DB unreachable)
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
                'message' => 'Minimum order value of ₹' . number_format($minOrder, 2) . ' required for this coupon.'
            ];
        }

        $val = (float)($coupon['value'] ?? 0);
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
            'title' => 'Coupon ' . $code,
            'message' => 'Coupon ' . $code . ' applied! You saved ₹' . number_format($discount, 2) . '.'
        ];
    }
}
