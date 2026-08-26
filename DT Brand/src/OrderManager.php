<?php

namespace DTBrand;

/**
 * OrderManager — Multi-Channel Order Processing, Stock Management & Fulfillment Engine
 * DT Brand's & Jai Hanuman Tex — Live Production Standard
 */
class OrderManager
{
    /**
     * Resolve the real discount a coupon grants for a given subtotal, read
     * straight from the live `coupons` table. This is the authoritative
     * server-side computation — it mirrors dt_coupon_apply() in
     * /api/coupons.php so the storefront preview and the stored order always
     * agree, and a tampered client "discount" value can never be honoured.
     * Returns 0.0 for any unknown / inactive / below-minimum / offline case.
     */
    private static function resolveCouponDiscount(string $code, float $subtotal): float
    {
        $code = strtoupper(trim($code));
        if ($code === '') {
            return 0.0;
        }
        $pdo = Database::getConnection();
        if ($pdo === null || Database::isMockMode()) {
            return 0.0;
        }
        try {
            $stmt = $pdo->prepare("SELECT * FROM `coupons` WHERE `code` = ? LIMIT 1");
            $stmt->execute([$code]);
            $c = $stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            return 0.0;
        }
        if (!$c || strtolower((string)($c['status'] ?? 'active')) !== 'active') {
            return 0.0;
        }
        $min = (float)($c['min_order_value'] ?? 0);
        if ($subtotal < $min) {
            return 0.0;
        }
        $type = strtolower((string)($c['discount_type'] ?? 'percentage'));
        $value = (float)($c['discount_value'] ?? 0);
        $maxDiscount = (float)($c['max_discount'] ?? 0);
        if ($type === 'percentage') {
            $discount = $subtotal * ($value / 100.0);
            if ($maxDiscount > 0) {
                $discount = min($discount, $maxDiscount);
            }
        } else { // 'flat'
            $discount = $value;
        }
        $discount = min($discount, $subtotal); // never exceed the bag value
        return round($discount, 2);
    }

    /**
     * Decide which channel an order is really placed on.
     *
     * The channel selects the price tier, so it can never come from the
     * request: otherwise a retail visitor could post channel=wholesale and buy
     * at bulk rates. Back-office staff genuinely do raise orders on any
     * channel, so an authenticated admin session is still trusted.
     */
    private static function resolveChannel(array $orderData): string
    {
        $requested = strtolower(trim((string)($orderData['channel'] ?? '')));
        $allowed = ['retail', 'wholesale', 'reseller', 'whatsapp'];

        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }

        if (!empty($_SESSION['admin_logged_in'])) {
            return in_array($requested, $allowed, true) ? $requested : 'retail';
        }

        // A storefront visitor gets the tier their own account was granted.
        $type = strtolower((string)($_SESSION['user']['type'] ?? ''));
        if ($type === 'wholesale' || $type === 'reseller') {
            return $type;
        }

        // 'whatsapp' is a fulfilment route rather than a pricing tier, so a
        // guest may still use it — it prices at retail (see priceColumnFor).
        return ($requested === 'whatsapp') ? 'whatsapp' : 'retail';
    }

    /**
     * Map a channel to the products column holding that tier's unit price.
     * Values are a fixed whitelist, never interpolated from user input.
     */
    private static function priceColumnFor(string $channel): string
    {
        if ($channel === 'wholesale') {
            return 'wholesale_price';
        }
        if ($channel === 'reseller') {
            return 'reseller_price';
        }
        return 'retail_price';
    }

    /**
     * Look up the authoritative unit price, SKU and title for every product in
     * the bag, straight from the products table at the order's tier.
     *
     * Returns [productId => ['price' => float, 'sku' => string, 'title' => string]].
     * Products missing from the result do not exist and must not be sold.
     */
    private static function resolveItemPrices(\PDO $pdo, array $items, string $channel): array
    {
        $ids = [];
        foreach ($items as $it) {
            $id = (int)($it['id'] ?? $it['product_id'] ?? 0);
            if ($id > 0) {
                $ids[$id] = true;
            }
        }
        if (empty($ids)) {
            return [];
        }

        $ids = array_keys($ids);
        $col = self::priceColumnFor($channel);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        try {
            $stmt = $pdo->prepare(
                "SELECT id, sku, title, mrp, retail_price, stock_qty, status, `{$col}` AS tier_price
                 FROM products WHERE id IN ({$placeholders})"
            );
            $stmt->execute($ids);
            $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\Throwable $e) {
            return [];
        }

        $out = [];
        foreach ($rows as $row) {
            // Fall back down the ladder when a tier price was never configured,
            // so a missing wholesale_price cannot silently sell the item for 0.
            $price = (float)$row['tier_price'];
            if ($price <= 0) {
                $price = (float)$row['retail_price'];
            }
            if ($price <= 0) {
                $price = (float)$row['mrp'];
            }
            $out[(int)$row['id']] = [
                'price'  => round($price, 2),
                'sku'    => (string)$row['sku'],
                'title'  => (string)$row['title'],
                'stock'  => (int)$row['stock_qty'],
                'status' => strtolower((string)$row['status']),
            ];
        }
        return $out;
    }

    /**
     * Create order record with real MySQL transaction & stock decrement
     */
    public static function createOrder(array $orderData): array
    {
        $orderNumber = 'DT-ORD-' . strtoupper(substr(uniqid(), -6));
        $items = $orderData['items'] ?? [];

        $pdo = Database::getConnection();
        $liveDb = ($pdo !== null && !Database::isMockMode());

        // Channel first: it decides the price tier, so it must be settled before
        // anything is priced.
        $channel = self::resolveChannel($orderData);

        // Unit prices are read from the products table, never from the request.
        // A tampered "price" (or "mrp"/"total") in the payload is now ignored.
        $catalog = $liveDb ? self::resolveItemPrices($pdo, $items, $channel) : [];

        $subtotal = 0.0;
        $pricedItems = [];
        $missing = [];
        $unavailable = [];

        foreach ($items as $item) {
            $prodId = (int)($item['id'] ?? $item['product_id'] ?? 0);
            $qty = max(1, (int)($item['quantity'] ?? $item['qty'] ?? 1));

            if ($liveDb) {
                if (!isset($catalog[$prodId])) {
                    // Refuse to invent a price for something not in the catalogue.
                    $missing[] = ($prodId > 0 ? ('#' . $prodId) : 'item with no product id');
                    continue;
                }
                $row = $catalog[$prodId];

                // Don't sell drafts, discontinued lines, or more than is on hand —
                // the stock UPDATE below clamps at zero, so without this check an
                // oversold order would look successful.
                if ($row['status'] === 'draft' || $row['status'] === 'out_of_stock') {
                    $unavailable[] = $row['title'] . ' (not available)';
                    continue;
                }
                if ($row['stock'] < $qty) {
                    $unavailable[] = $row['title'] . ' (only ' . $row['stock'] . ' left, you asked for ' . $qty . ')';
                    continue;
                }

                $price = $row['price'];
                $item['price'] = $price;
                $item['sku'] = $row['sku'];
                $item['title'] = $row['title'];
            } else {
                // Offline/demo mode cannot verify anything against the DB.
                $price = (float)($item['price'] ?? 0);
            }

            $item['product_id'] = $prodId;
            $item['quantity'] = $qty;
            $item['line_total'] = round($price * $qty, 2);
            $pricedItems[] = $item;
            $subtotal += ($price * $qty);
        }

        if (!empty($missing)) {
            return [
                'success' => false,
                'order_number' => $orderNumber,
                'message' => 'These products are no longer available: ' . implode(', ', $missing) . '. Please refresh your bag and try again.',
                'items' => $items,
                'items_count' => count($items),
                'total_amount' => 0.0
            ];
        }

        if (!empty($unavailable)) {
            return [
                'success' => false,
                'order_number' => $orderNumber,
                'message' => 'Sorry, we cannot fulfil this order: ' . implode('; ', $unavailable) . '.',
                'items' => $items,
                'items_count' => count($items),
                'total_amount' => 0.0
            ];
        }

        if (empty($pricedItems)) {
            return [
                'success' => false,
                'order_number' => $orderNumber,
                'message' => 'This order has no valid items.',
                'items' => [],
                'items_count' => 0,
                'total_amount' => 0.0
            ];
        }

        $items = $pricedItems;
        $subtotal = round($subtotal, 2);

        // Discount is server-authoritative: never trust a client-supplied
        // amount. It is honoured only when a live, active coupon justifies it
        // for this subtotal. Offline/mock mode cannot verify against the DB, so
        // the demo-only client value is merely clamped to a sane range.
        $couponCode = (string)($orderData['coupon_code'] ?? '');
        if (Database::isMockMode()) {
            $discount = max(0.0, min((float)($orderData['discount'] ?? 0.0), $subtotal));
        } else {
            $discount = self::resolveCouponDiscount($couponCode, $subtotal);
        }
        $shipping = (float)($orderData['shipping'] ?? 0.0);
        $gstRate = (float)($orderData['gst_rate'] ?? 5.0);

        $calc = PricingCalculator::calculateOrderTotal($subtotal, $discount, $shipping, $gstRate);
        $grandTotal = (float)($calc['grand_total'] ?? $subtotal);
        $gstAmount = (float)($calc['gst_amount'] ?? $calc['gst'] ?? 0.0);

        $customerId = (int)($orderData['customer_id'] ?? 0);
        $customerName = trim($orderData['customer_name'] ?? 'Direct Customer');
        $customerPhone = trim($orderData['customer_phone'] ?? '');
        $shippingAddress = trim((string)($orderData['shipping_address'] ?? ''));
        // $channel was already resolved from the session above — do not re-read
        // it from the request here.
        $paymentMethod = $orderData['payment_method'] ?? 'razorpay';
        $paymentStatus = $orderData['payment_status'] ?? 'paid';
        $fulfillmentStatus = $orderData['fulfillment_status'] ?? 'confirmed';

        // A signed-in customer's order always belongs to them, so a posted
        // customer_id cannot be used to attribute spend to somebody else.
        if (empty($_SESSION['admin_logged_in']) && !empty($_SESSION['user']['id'])) {
            $customerId = (int)$_SESSION['user']['id'];
        }

        $dbOrderId = 0;

        if ($liveDb) {
            try {
                $pdo->beginTransaction();

                // If customerId is 0, lookup by phone or insert guest customer
                if ($customerId <= 0 && !empty($customerPhone)) {
                    $cStmt = $pdo->prepare("SELECT id FROM customers WHERE phone = ? LIMIT 1");
                    $cStmt->execute([$customerPhone]);
                    $existing = $cStmt->fetch(\PDO::FETCH_ASSOC);
                    if ($existing) {
                        $customerId = (int)$existing['id'];
                    } else {
                        $custType = in_array($channel, ['retail', 'wholesale', 'reseller'], true) ? $channel : 'retail';
                        $insCust = $pdo->prepare("
                            INSERT INTO customers (name, phone, email, type, status, created_at)
                            VALUES (?, ?, ?, ?, 'active', NOW())
                        ");
                        $insCust->execute([$customerName, $customerPhone, $orderData['customer_email'] ?? '', $custType]);
                        $customerId = (int)$pdo->lastInsertId();
                    }
                }

                // Map and validate status enums
                $validFulfillment = in_array($fulfillmentStatus, ['unfulfilled','processing','dispatched','delivered','cancelled']) ? $fulfillmentStatus : 'processing';
                $validPayment = in_array($paymentStatus, ['pending','paid','credit','refunded']) ? $paymentStatus : 'paid';

                // Insert into orders table. shipping_address is included only when the
                // live table actually has the column, so order creation never fails on a
                // database that predates the column (it self-heals once migrate.php re-runs).
                $trackingNum = 'TRK-' . strtoupper(substr(uniqid(), -8));

                $cols = "order_number, customer_id, customer_name, customer_phone, channel, subtotal, discount, gst_rate, gst_amount, shipping_fee, total_amount, payment_method, payment_status, fulfillment_status, tracking_number, courier_name";
                $vals = "?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Delhivery Express'";
                $orderParams = [
                    $orderNumber,
                    $customerId,
                    $customerName,
                    $customerPhone,
                    $channel,
                    $subtotal,
                    $discount,
                    $gstRate,
                    $gstAmount,
                    $shipping,
                    $grandTotal,
                    $paymentMethod,
                    $validPayment,
                    $validFulfillment,
                    $trackingNum
                ];

                if ($shippingAddress !== '' && self::ordersHasColumn($pdo, 'shipping_address')) {
                    $cols .= ", shipping_address";
                    $vals .= ", ?";
                    $orderParams[] = $shippingAddress;
                }

                $stmt = $pdo->prepare("INSERT INTO orders ({$cols}, created_at) VALUES ({$vals}, NOW())");
                $stmt->execute($orderParams);
                $dbOrderId = (int)$pdo->lastInsertId();

                // Insert order items & update product stock
                $itemStmt = $pdo->prepare("
                    INSERT INTO order_items (order_id, product_id, product_title, sku, unit_price, quantity, total_price)
                    VALUES (?, ?, ?, ?, ?, ?, ?)
                ");

                $stockStmt = $pdo->prepare("
                    UPDATE products 
                    SET stock_qty = GREATEST(0, stock_qty - ?) 
                    WHERE id = ?
                ");

                foreach ($items as $it) {
                    // $items has already been rewritten with catalogue prices,
                    // titles and SKUs, so nothing here comes from the request.
                    $prodId = (int)($it['product_id'] ?? $it['id'] ?? 0);
                    $prodTitle = $it['title'] ?? $it['name'] ?? 'Silk Saree';
                    $prodSku = $it['sku'] ?? 'DT-SKU';
                    $unitPrice = (float)($it['price'] ?? 0);
                    $qty = max(1, (int)($it['quantity'] ?? $it['qty'] ?? 1));
                    $totalItemPrice = round($unitPrice * $qty, 2);

                    $itemStmt->execute([$dbOrderId, $prodId, $prodTitle, $prodSku, $unitPrice, $qty, $totalItemPrice]);
                    $stockStmt->execute([$qty, $prodId]);
                }

                // Update customer total_orders and lifetime_spend
                if ($customerId > 0) {
                    try {
                        $pdo->prepare("
                            UPDATE customers 
                            SET total_orders = COALESCE(total_orders, 0) + 1, 
                                lifetime_spend = COALESCE(lifetime_spend, 0) + ? 
                            WHERE id = ?
                        ")->execute([$grandTotal, $customerId]);
                    } catch (\Exception $ce) {}
                }

                $pdo->commit();
            } catch (\Throwable $e) {
                if ($pdo->inTransaction()) {
                    $pdo->rollBack();
                }
                $dbError = $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
                error_log("[ORDER CREATION ERROR] " . $dbError);
            }
        }

        return [
            'success' => ($dbOrderId > 0),
            'id' => $dbOrderId,
            'db_error' => $dbError ?? null,
            'order_number' => $orderNumber,
            'customer_name' => $customerName,
            'customer_phone' => $customerPhone,
            'shipping_address' => $shippingAddress,
            'customer_email' => $orderData['customer_email'] ?? '',
            'channel' => $channel,
            'items' => $items,
            'items_count' => count($items),
            'pricing' => $calc,
            'total_amount' => $grandTotal,
            'payment_status' => $paymentStatus,
            'fulfillment_status' => $fulfillmentStatus,
            'created_at' => date('Y-m-d H:i:s'),
            'whatsapp_notice' => self::generateWhatsAppNotice($orderNumber, $grandTotal, $customerName)
        ];
    }

    /**
     * Probe (once, cached) whether the live `orders` table has a given column.
     * Lets writes stay compatible with databases created before a column existed.
     */
    private static function ordersHasColumn(\PDO $pdo, string $column): bool
    {
        static $cache = [];
        if (array_key_exists($column, $cache)) {
            return $cache[$column];
        }
        try {
            $stmt = $pdo->prepare("SHOW COLUMNS FROM orders LIKE ?");
            $stmt->execute([$column]);
            $cache[$column] = (bool)$stmt->fetch(\PDO::FETCH_ASSOC);
        } catch (\Exception $e) {
            $cache[$column] = false;
        }
        return $cache[$column];
    }

    /**
     * Get single order by order number
     */
    public static function getByOrderNumber(string $orderNumber): ?array
    {
        return self::getOrderDetails($orderNumber);
    }

    /**
     * Get orders by customer phone number
     */
    public static function getByPhone(string $phone): array
    {
        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                $stmt = $db->prepare("SELECT * FROM orders WHERE customer_phone = ? ORDER BY id DESC");
                $stmt->execute([$phone]);
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            } catch (\Exception $e) {
                return [];
            }
        }
        return [];
    }

    /**
     * Generate official WhatsApp dispatch message
     */
    public static function generateWhatsAppNotice(string $orderNumber, float $grandTotal, string $customerName): string

    {
        $formattedTotal = '₹' . number_format($grandTotal, 2);
        return "Namaste {$customerName} ji! 🙏\n" .
               "Your DT Brand's & Jai Hanuman Tex order *{$orderNumber}* has been confirmed.\n" .
               "Order Total: *{$formattedTotal}* (GST 5% included).\n" .
               "Tracking link will be shared once dispatched.\n" .
               "Thank you for choosing luxury authentic handlooms! 🌸";
    }

    /**
     * Get all orders dynamically from database
     */
    public static function getAll(): array
    {
        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                $rows = Database::query("
                    SELECT o.*, c.name as customer_name, c.phone as customer_phone, c.type as customer_type
                    FROM orders o
                    LEFT JOIN customers c ON o.customer_id = c.id
                    ORDER BY o.id DESC
                ");
                if (!empty($rows)) {
                    $result = [];
                    foreach ($rows as $r) {
                        $result[] = [
                            'id' => $r['order_number'] ?? ('DTB-' . str_pad($r['id'], 6, '0', STR_PAD_LEFT)),
                            'db_id' => (int)$r['id'],
                            'customer' => $r['customer_name'] ?? 'Direct Customer',
                            'customer_type' => ucfirst($r['customer_type'] ?? 'Retail'),
                            'phone' => $r['customer_phone'] ?? '+91 98765 43210',
                            'date' => date('d M Y, h:i A', strtotime($r['created_at'] ?? 'now')),
                            'items_count' => '1 lot',
                            'items_summary' => 'Ethnic Silk Sarees',
                            'amount' => (float)($r['total_amount'] ?? 0),
                            'payment' => $r['payment_method'] ?? 'Bank Wire / RTGS',
                            'payment_status' => $r['payment_status'] ?? 'paid',
                            'shipping' => $r['courier_name'] ?? 'Delhivery Express',
                            'tracking' => $r['tracking_number'] ?? ('DEL-' . rand(10000, 99999)),
                            'status' => $r['fulfillment_status'] ?? 'processing',
                            'source' => ucfirst($r['channel'] ?? 'Online Shop'),
                            'updated' => 'Just now'
                        ];
                    }
                    return $result;
                }
            } catch (\Exception $e) {}
        }

        return [
            [
                'id' => 'DT-ORD-90281',
                'db_id' => 1,
                'customer' => 'Radhika Sarees Emporium',
                'customer_type' => 'Wholesale',
                'phone' => '+91 98765 43210',
                'date' => '21 Aug 2026, 11:20 AM',
                'items_count' => '24 pcs',
                'items_summary' => 'Nilambari & Banarasi Silk (x24)',
                'amount' => 44688,
                'payment' => 'Bank Wire / RTGS',
                'payment_status' => 'paid',
                'shipping' => 'Delhivery Express',
                'tracking' => 'DEL-94028491',
                'status' => 'dispatched',
                'source' => 'Wholesale',
                'updated' => '10 mins ago'
            ],
            [
                'id' => 'DT-ORD-89412',
                'db_id' => 2,
                'customer' => 'Pooja Sharma',
                'customer_type' => 'Reseller',
                'phone' => '+91 98234 56789',
                'date' => '22 Aug 2026, 02:45 PM',
                'items_count' => '1 pc',
                'items_summary' => 'Royal Banarasi Meenakari Silk Saree',
                'amount' => 8399,
                'payment' => 'Razorpay / UPI',
                'payment_status' => 'paid',
                'shipping' => 'Blue Dart Aviation',
                'tracking' => 'BD-84920194',
                'status' => 'delivered',
                'source' => 'Reseller',
                'updated' => '1 hour ago'
            ]
        ];
    }

    /**
     * Get Orders by Customer ID
     */
    public static function getByCustomerId(int $customerId): array
    {
        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                return Database::query("
                    SELECT * FROM orders 
                    WHERE customer_id = ? 
                    ORDER BY id DESC
                ", [$customerId]);
            } catch (\Exception $e) {
                return [];
            }
        }
        return [];
    }

    /**
     * Update Order Fulfillment Status by ID or Order Number with Audit Trail Logging
     */
    public static function updateStatus($orderIdentifier, string $status, ?string $trackingNumber = null, ?string $courier = null, string $updatedBy = 'Admin'): bool
    {
        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                // 1. Get current order state
                $currentOrder = null;
                if (is_numeric($orderIdentifier)) {
                    $cStmt = $db->prepare("SELECT id, fulfillment_status FROM orders WHERE id = ? OR order_number = ? LIMIT 1");
                    $cStmt->execute([(int)$orderIdentifier, (string)$orderIdentifier]);
                    $currentOrder = $cStmt->fetch(\PDO::FETCH_ASSOC);
                } else {
                    $cStmt = $db->prepare("SELECT id, fulfillment_status FROM orders WHERE order_number = ? LIMIT 1");
                    $cStmt->execute([(string)$orderIdentifier]);
                    $currentOrder = $cStmt->fetch(\PDO::FETCH_ASSOC);
                }

                $prevStatus = $currentOrder['fulfillment_status'] ?? 'pending';
                $orderDbId = (int)($currentOrder['id'] ?? 0);

                if (is_numeric($orderIdentifier)) {
                    $stmt = $db->prepare("
                        UPDATE orders 
                        SET fulfillment_status = ?,
                            tracking_number = COALESCE(?, tracking_number),
                            courier_name = COALESCE(?, courier_name)
                        WHERE id = ? OR order_number = ?
                    ");
                    $res = $stmt->execute([$status, $trackingNumber, $courier, (int)$orderIdentifier, (string)$orderIdentifier]);
                } else {
                    $stmt = $db->prepare("
                        UPDATE orders 
                        SET fulfillment_status = ?,
                            tracking_number = COALESCE(?, tracking_number),
                            courier_name = COALESCE(?, courier_name)
                        WHERE order_number = ?
                    ");
                    $res = $stmt->execute([$status, $trackingNumber, $courier, (string)$orderIdentifier]);
                }

                // 2. Log in order_status_history
                if ($res && $orderDbId > 0) {
                    try {
                        $hStmt = $db->prepare("
                            INSERT INTO order_status_history (order_id, previous_status, new_status, comment, updated_by, created_at)
                            VALUES (?, ?, ?, ?, ?, NOW())
                        ");
                        $comment = "Order status updated to " . ucfirst($status) . ($trackingNumber ? " (AWB: {$trackingNumber})" : "");
                        $hStmt->execute([$orderDbId, $prevStatus, $status, $comment, $updatedBy]);
                    } catch (\Exception $ex) {
                        // Safe fallback if history table not yet migrated
                    }
                }

                return $res;
            } catch (\Exception $e) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get Complete Order Details with Items and Status History
     */
    public static function getOrderDetails($orderIdentifier): ?array
    {
        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                $order = null;
                if (is_numeric($orderIdentifier)) {
                    $stmt = $db->prepare("SELECT * FROM orders WHERE id = ? OR order_number = ? LIMIT 1");
                    $stmt->execute([(int)$orderIdentifier, (string)$orderIdentifier]);
                    $order = $stmt->fetch(\PDO::FETCH_ASSOC);
                } else {
                    $stmt = $db->prepare("SELECT * FROM orders WHERE order_number = ? LIMIT 1");
                    $stmt->execute([(string)$orderIdentifier]);
                    $order = $stmt->fetch(\PDO::FETCH_ASSOC);
                }

                if ($order) {
                    $orderId = (int)$order['id'];
                    $itemsStmt = $db->prepare("SELECT * FROM order_items WHERE order_id = ?");
                    $itemsStmt->execute([$orderId]);
                    $order['items'] = $itemsStmt->fetchAll(\PDO::FETCH_ASSOC);

                    // Status history is optional — the live schema has no order_status_history
                    // table, so a missing table must not blank out an otherwise-valid order.
                    $order['history'] = [];
                    try {
                        $histStmt = $db->prepare("SELECT * FROM order_status_history WHERE order_id = ? ORDER BY id ASC");
                        $histStmt->execute([$orderId]);
                        $order['history'] = $histStmt->fetchAll(\PDO::FETCH_ASSOC);
                    } catch (\Exception $he) {
                        // No history table in this deployment — leave as an empty timeline.
                    }

                    return $order;
                }
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    /**
     * Delete Order permanently
     */
    public static function deleteOrder($orderId): bool
    {
        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                if (is_numeric($orderId)) {
                    $stmt = $db->prepare("DELETE FROM orders WHERE id = ? OR order_number = ?");
                    return $stmt->execute([(int)$orderId, (string)$orderId]);
                } else {
                    $stmt = $db->prepare("DELETE FROM orders WHERE order_number = ?");
                    return $stmt->execute([(string)$orderId]);
                }
            } catch (\Exception $e) {
                return false;
            }
        }
        return true;
    }
}



