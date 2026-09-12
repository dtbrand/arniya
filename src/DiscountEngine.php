<?php

namespace DTBrand;

require_once __DIR__ . '/Database.php';

/**
 * DiscountEngine — Coupon, Promo Code, Tiered Discounts & Redemptions Engine
 * DT Brand's & Jai Hanuman Tex — Section 26 Master Architecture
 *
 * Validates:
 * - Coupon Code & Status (active / inactive / expired)
 * - Start Date & End Date (starts_at / expires_at)
 * - Minimum Order Spend (min_order_value / min_order_amount)
 * - Discount Benefit (percentage with optional max_discount cap, or flat amount)
 * - Total Usage Limit & Real Used Count
 * - Per-User Limit (by customer phone / customer ID)
 * - Role / Channel Restrictions (all, customer, retailer, reseller, wholesaler)
 * - Real Redemption Logging & Audit Trail
 */
class DiscountEngine
{
    /**
     * Apply a coupon code to a subtotal with full Section 26 rules.
     *
     * @param string $code Coupon voucher code
     * @param float $subtotal Current cart/order subtotal
     * @param array|null $availableCoupons Optional preloaded coupons (kept for backward compatibility)
     * @param string $channel Purchasing role/channel: 'all', 'customer', 'retailer', 'reseller', 'wholesaler'
     * @param string|null $customerPhone Customer phone number for per-user limit check
     * @param int|null $customerId Customer ID
     * @return array Result array with valid, code, discount, title, message
     */
    public static function applyCoupon(
        string $code,
        float $subtotal,
        ?array $availableCoupons = null,
        string $channel = 'all',
        ?string $customerPhone = null,
        ?int $customerId = null
    ): array {
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
            $stmt = $pdo->prepare("SELECT * FROM coupons WHERE code = ? LIMIT 1");
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

        // 1. Status Check
        $status = strtolower((string)($dbCoupon['status'] ?? 'active'));
        if ($status !== 'active') {
            return [
                'valid' => false,
                'discount' => 0.0,
                'message' => 'Invalid or expired coupon code: ' . $code
            ];
        }

        $now = time();

        // 2. Start Date Check
        if (!empty($dbCoupon['starts_at'])) {
            $startTime = strtotime((string)$dbCoupon['starts_at']);
            if ($startTime !== false && $now < $startTime) {
                return [
                    'valid' => false,
                    'discount' => 0.0,
                    'message' => 'Coupon ' . $code . ' is scheduled for a future promotion and is not yet active.'
                ];
            }
        }

        // 3. Expiry Date Check
        if (!empty($dbCoupon['expires_at'])) {
            $expiryTime = strtotime((string)$dbCoupon['expires_at']);
            if ($expiryTime !== false && $now > $expiryTime) {
                // Auto-sync status to expired if connected
                try {
                    $pdo->prepare("UPDATE coupons SET status = 'expired' WHERE id = ?")->execute([$dbCoupon['id']]);
                } catch (\Throwable $e) {}
                return [
                    'valid' => false,
                    'discount' => 0.0,
                    'message' => 'Invalid or expired coupon code: ' . $code
                ];
            }
        }

        // 4. Role / Channel Restriction Check
        $couponChannel = strtolower(trim((string)($dbCoupon['channel'] ?? 'all')));
        $userChannel = strtolower(trim($channel));
        if ($couponChannel !== '' && $couponChannel !== 'all' && $userChannel !== 'all') {
            $normalizedCouponChannel = ($couponChannel === 'retail') ? 'customer' : $couponChannel;
            $normalizedUserChannel = ($userChannel === 'retail' || $userChannel === 'guest') ? 'customer' : $userChannel;

            if ($normalizedCouponChannel !== $normalizedUserChannel) {
                $roleLabel = ucfirst($normalizedCouponChannel);
                return [
                    'valid' => false,
                    'discount' => 0.0,
                    'message' => "Coupon {$code} is exclusively reserved for {$roleLabel} partners."
                ];
            }
        }

        // 5. Total Usage Limit Check
        $usageLimit = isset($dbCoupon['usage_limit']) ? (int)$dbCoupon['usage_limit'] : 0;
        $usedCount = (int)($dbCoupon['used_count'] ?? $dbCoupon['times_used'] ?? 0);
        if ($usageLimit > 0 && $usedCount >= $usageLimit) {
            return [
                'valid' => false,
                'discount' => 0.0,
                'message' => "Coupon {$code} has reached its maximum total redemption limit."
            ];
        }

        // 6. Per-User Limit Check (if customer info provided and table exists)
        $perUserLimit = isset($dbCoupon['per_user_limit']) ? (int)$dbCoupon['per_user_limit'] : 0;
        if ($perUserLimit > 0 && (!empty($customerPhone) || !empty($customerId))) {
            try {
                $phoneQuery = !empty($customerPhone) ? preg_replace('/\D+/', '', $customerPhone) : '';
                if (strlen($phoneQuery) > 10) {
                    $phoneQuery = substr($phoneQuery, -10);
                }
                $userUsageSql = "SELECT COUNT(*) FROM coupon_usages WHERE coupon_code = ? AND (
                    (customer_id IS NOT NULL AND customer_id = ?) OR 
                    (customer_phone IS NOT NULL AND customer_phone LIKE ?)
                )";
                $userStmt = $pdo->prepare($userUsageSql);
                $userStmt->execute([$code, (int)$customerId, '%' . $phoneQuery]);
                $userUsed = (int)$userStmt->fetchColumn();
                if ($userUsed >= $perUserLimit) {
                    return [
                        'valid' => false,
                        'discount' => 0.0,
                        'message' => "You have already used coupon {$code} the maximum allowed times ({$perUserLimit})."
                    ];
                }
            } catch (\Throwable $e) {
                // Table might not be populated or offline, allow fallback
            }
        }

        // 7. Minimum Spend Check
        $minOrder = (float)($dbCoupon['min_order_value'] ?? $dbCoupon['min_order_amount'] ?? 0);
        if ($subtotal < $minOrder) {
            return [
                'valid' => false,
                'discount' => 0.0,
                'message' => 'Minimum order value of ₹' . number_format($minOrder, 2) . ' required for this coupon.'
            ];
        }

        // 8. Discount Calculation
        $val = (float)($dbCoupon['discount_value'] ?? 0);
        $type = strtolower((string)($dbCoupon['discount_type'] ?? 'percentage'));
        if ($type === 'flat' || $type === 'fixed') {
            $discount = min($subtotal, $val);
        } else {
            $discount = round($subtotal * ($val / 100.0), 2);
            if (!empty($dbCoupon['max_discount']) && (float)$dbCoupon['max_discount'] > 0) {
                $discount = min($discount, (float)$dbCoupon['max_discount']);
            }
        }

        // Never exceed cart subtotal
        $discount = max(0.0, min($discount, $subtotal));

        return [
            'valid' => true,
            'id' => (int)$dbCoupon['id'],
            'code' => $code,
            'discount' => $discount,
            'discount_type' => $type,
            'discount_value' => $val,
            'title' => !empty($dbCoupon['title']) ? (string)$dbCoupon['title'] : ('Coupon ' . $code),
            'message' => 'Coupon ' . $code . ' applied! You saved ₹' . number_format($discount, 2) . '.'
        ];
    }

    /**
     * Record a verified coupon redemption in the database.
     * Atomically increments used_count and inserts an audited usage row.
     */
    public static function recordRedemption(
        string $code,
        ?int $orderId = null,
        ?string $orderNumber = null,
        ?int $customerId = null,
        ?string $customerPhone = null,
        ?string $customerName = null,
        float $discountAmount = 0.0,
        float $orderSubtotal = 0.0,
        string $channel = 'customer'
    ): bool {
        $code = strtoupper(trim($code));
        if ($code === '' || $discountAmount <= 0) {
            return false;
        }

        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return false;
        }

        try {
            // 1. Fetch coupon ID
            $stmt = $pdo->prepare("SELECT id FROM coupons WHERE code = ? LIMIT 1");
            $stmt->execute([$code]);
            $couponId = (int)$stmt->fetchColumn();

            // 2. Increment used_count & times_used
            $updateSql = "UPDATE coupons SET 
                used_count = COALESCE(used_count, 0) + 1,
                times_used = COALESCE(times_used, 0) + 1
                WHERE code = ?";
            $pdo->prepare($updateSql)->execute([$code]);

            // 3. Record in coupon_usages
            try {
                $insSql = "INSERT INTO coupon_usages 
                    (coupon_id, coupon_code, order_id, order_number, customer_id, customer_phone, customer_name, order_subtotal, discount_amount, channel)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $pdo->prepare($insSql)->execute([
                    $couponId ?: null,
                    $code,
                    $orderId,
                    $orderNumber,
                    $customerId,
                    $customerPhone,
                    $customerName,
                    $orderSubtotal,
                    $discountAmount,
                    $channel
                ]);
            } catch (\Throwable $e) {
                error_log('[DiscountEngine] coupon_usages insert skipped: ' . $e->getMessage());
            }

            // 4. Log Audit
            self::logAudit($code, 'redeemed', 'System', "Redeemed for order {$orderNumber} (Discount: ₹{$discountAmount})", $couponId ?: null);

            return true;
        } catch (\Throwable $e) {
            error_log('[DiscountEngine] recordRedemption failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Log a coupon administrative or security event in coupon_audit_logs.
     */
    public static function logAudit(string $code, string $action, string $actor = 'Admin', ?string $details = null, ?int $couponId = null): void
    {
        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return;
        }

        try {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
            $sql = "INSERT INTO coupon_audit_logs (coupon_id, coupon_code, action, actor, ip_address, details) VALUES (?, ?, ?, ?, ?, ?)";
            $pdo->prepare($sql)->execute([
                $couponId,
                strtoupper(trim($code)),
                $action,
                $actor,
                $ip,
                $details
            ]);
        } catch (\Throwable $e) {
            // Table might not exist yet, ignore gracefully
        }
    }

    /**
     * Retrieve active promotional coupons for storefront / checkout display.
     */
    public static function getActiveCoupons(int $limit = 10, string $channel = 'all'): array
    {
        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return [];
        }

        try {
            $stmt = $pdo->query("SELECT * FROM coupons WHERE status = 'active' ORDER BY id DESC");
            $allActive = $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
            
            $now = time();
            $filtered = [];
            foreach ($allActive as $c) {
                // Future check
                if (!empty($c['starts_at'])) {
                    $st = strtotime((string)$c['starts_at']);
                    if ($st !== false && $now < $st) {
                        continue;
                    }
                }
                // Expiry check
                if (!empty($c['expires_at'])) {
                    $ex = strtotime((string)$c['expires_at']);
                    if ($ex !== false && $now > $ex) {
                        continue;
                    }
                }
                // Channel check
                if ($channel !== 'all' && !empty($c['channel']) && $c['channel'] !== 'all') {
                    $nc = ($c['channel'] === 'retail') ? 'customer' : $c['channel'];
                    $nu = ($channel === 'retail' || $channel === 'guest') ? 'customer' : $channel;
                    if ($nc !== $nu) {
                        continue;
                    }
                }
                $filtered[] = $c;
                if (count($filtered) >= max(1, $limit)) {
                    break;
                }
            }
            return $filtered;
        } catch (\Throwable $e) {
            error_log('[DiscountEngine] getActiveCoupons failed: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Retrieve all coupons for administrative overview and coupon management studio.
     */
    public static function getAllCoupons(int $limit = 100): array
    {
        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return [];
        }

        try {
            $stmt = $pdo->prepare("SELECT * FROM coupons ORDER BY id DESC LIMIT ?");
            $stmt->bindValue(1, max(1, $limit), \PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC) ?: [];
        } catch (\Throwable $e) {
            error_log('[DiscountEngine] getAllCoupons failed: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Format a luxury readable discount badge from coupon record.
     */
    public static function formatDiscountBadge(array $coupon): string
    {
        $type = strtolower((string)($coupon['discount_type'] ?? 'percentage'));
        $val = (float)($coupon['discount_value'] ?? 0);
        $max = (float)($coupon['max_discount'] ?? 0);

        if ($type === 'flat' || $type === 'fixed') {
            return '₹' . number_format($val, 0) . ' FLAT OFF';
        }

        if ($max > 0) {
            return number_format($val, 0) . '% OFF (Up to ₹' . number_format($max, 0) . ')';
        }

        return number_format($val, 0) . '% OFF';
    }

    /**
     * Calculate discount amount without full payload wrapper.
     */
    public static function calculateCartDiscount(string $code, float $subtotal, string $channel = 'all'): float
    {
        $result = self::applyCoupon($code, $subtotal, null, $channel);
        return $result['valid'] ? (float)($result['discount'] ?? 0.0) : 0.0;
    }
}