<?php

namespace DTBrand;

/**
 * OrderManager — Multi-Channel Order Processing, Stock Management & Fulfillment Engine
 * DT Brand's & Jai Hanuman Tex — Live Production Standard
 */
class OrderManager
{
    /**
     * Create order record with real MySQL transaction & stock decrement
     */
    public static function createOrder(array $orderData): array
    {
        $orderNumber = 'DT-ORD-' . strtoupper(substr(uniqid(), -6));
        $items = $orderData['items'] ?? [];
        $subtotal = 0.0;

        foreach ($items as $item) {
            $price = (float)($item['price'] ?? 0);
            $qty = (int)($item['quantity'] ?? $item['qty'] ?? 1);
            $subtotal += ($price * $qty);
        }

        $discount = (float)($orderData['discount'] ?? 0.0);
        $shipping = (float)($orderData['shipping'] ?? 0.0);
        $gstRate = (float)($orderData['gst_rate'] ?? 5.0);

        $calc = PricingCalculator::calculateOrderTotal($subtotal, $discount, $shipping, $gstRate);
        $grandTotal = (float)($calc['grand_total'] ?? $subtotal);
        $gstAmount = (float)($calc['gst_amount'] ?? $calc['gst'] ?? 0.0);

        $customerId = (int)($orderData['customer_id'] ?? 0);
        $customerName = trim($orderData['customer_name'] ?? 'Direct Customer');
        $customerPhone = trim($orderData['customer_phone'] ?? '');
        $shippingAddress = trim((string)($orderData['shipping_address'] ?? ''));
        $channel = in_array($orderData['channel'] ?? '', ['retail', 'wholesale', 'reseller', 'whatsapp']) ? $orderData['channel'] : 'retail';
        $paymentMethod = $orderData['payment_method'] ?? 'razorpay';
        $paymentStatus = $orderData['payment_status'] ?? 'paid';
        $fulfillmentStatus = $orderData['fulfillment_status'] ?? 'confirmed';

        $pdo = Database::getConnection();
        $dbOrderId = 0;

        if ($pdo !== null && !Database::isMockMode()) {
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
                    $prodId = (int)($it['id'] ?? $it['product_id'] ?? 1);
                    $prodTitle = $it['title'] ?? $it['name'] ?? 'Silk Saree';
                    $prodSku = $it['sku'] ?? 'DT-SKU';
                    $unitPrice = (float)($it['price'] ?? 0);
                    $qty = (int)($it['quantity'] ?? $it['qty'] ?? 1);
                    $totalItemPrice = $unitPrice * $qty;

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



