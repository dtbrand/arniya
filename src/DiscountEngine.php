<?php

namespace DTBrand;

require_once __DIR__ . '/Database.php';

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
     * Apply a coupon code to a subtotal.
     *
     * Reads the live `coupons` table. When the database is unreachable, returns
     * an explicit `valid: false` result — a fake discount that the user cannot
     * see validated server-side would let a tampered client charge less than
     * the cart actually costs.
     */
    public static function applyCoupon(string $code, float $subtotal, ?array $availableCoupons = null, string $channel = 'all'): array
    {
        $code = strtoupper(trim($code));

        if ($code === '') {
            return [
                'valid' => false,
                'discount' => 0.0,
                'message' => 'Please enter a coupon code.'
            ];
        }

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return [
                'valid' => false,
                'discount' => 0.0,
                'message' => 'Coupon validation is temporarily unavailable. Please try again in a moment.'
            ];
        }

        try {
            $stmt = $pdo->prepare("SELECT * FROM coupons WHERE code = ? AND status = 'active' LIMIT 1");
            $stmt->execute([$code]);
            $dbCoupon = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            error_log('[DiscountEngine] coupon lookup failed: ' . $e->getMessage());
            return [
                'valid' => false,
                'discount' => 0.0,
                'message' => 'Coupon validation is temporarily unavailable. Please try again in a moment.'
            ];
        }

        if (!$dbCoupon) {
            return [
                'valid' => false,
                'discount' => 0.0,
                'message' => 'Invalid or expired coupon code: ' . $code
            ];
        }

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

    /**
     * Retrieve active promotional coupons for storefront / checkout display
     */
    public static function getActiveCoupons(int $limit = 10): array
    {
        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return [];
        }

        try {
            $stmt = $pdo->prepare("SELECT code, discount_type, discount_value, min_order_value, max_discount FROM coupons WHERE status = 'active' ORDER BY id DESC LIMIT " . max(1, (int)$limit));
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        } catch (\Throwable $e) {
            error_log('[DiscountEngine] getActiveCoupons failed: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Format a luxury readable discount badge from coupon record
     */
    public static function formatDiscountBadge(array $coupon): string
    {
        $type = $coupon['discount_type'] ?? 'percentage';
        $val = (float)($coupon['discount_value'] ?? 0);
        $max = (float)($coupon['max_discount'] ?? 0);

        if ($type === 'flat') {
            return '₹' . number_format($val, 0) . ' FLAT OFF';
        }

        if ($max > 0) {
            return number_format($val, 0) . '% OFF (Up to ₹' . number_format($max, 0) . ')';
        }

        return number_format($val, 0) . '% OFF';
    }

    /**
     * Calculate discount amount without full payload wrapper
     */
    public static function calculateCartDiscount(string $code, float $subtotal, string $channel = 'all'): float
    {
        $result = self::applyCoupon($code, $subtotal, null, $channel);
        return $result['valid'] ? (float)($result['discount'] ?? 0.0) : 0.0;
    }
}