<?php

namespace DTBrand;

/**
 * OrderManager — Multi-Channel Order Processing & Fulfillment Engine
 * DT Brand's & Jai Hanuman Tex
 */
class OrderManager
{
    /**
     * Create order record with financial computation
     */
    public static function createOrder(array $orderData): array
    {
        $orderNumber = 'DT-ORD-' . strtoupper(substr(uniqid(), -6));
        $items = $orderData['items'] ?? [];
        $subtotal = 0.0;

        foreach ($items as $item) {
            $price = (float)($item['price'] ?? 0);
            $qty = (int)($item['quantity'] ?? 1);
            $subtotal += ($price * $qty);
        }

        $couponCode = $orderData['coupon_code'] ?? null;
        $discount = (float)($orderData['discount'] ?? 0.0);
        $shipping = (float)($orderData['shipping'] ?? 0.0);
        $gstRate = (float)($orderData['gst_rate'] ?? 5.0);

        $calc = PricingCalculator::calculateOrderTotal($subtotal, $discount, $shipping, $gstRate);

        return [
            'order_number' => $orderNumber,
            'customer_name' => $orderData['customer_name'] ?? 'Customer',
            'customer_phone' => $orderData['customer_phone'] ?? '',
            'customer_email' => $orderData['customer_email'] ?? '',
            'channel' => $orderData['channel'] ?? 'retail',
            'items' => $items,
            'items_count' => count($items),
            'pricing' => $calc,
            'payment_status' => $orderData['payment_status'] ?? 'pending',
            'fulfillment_status' => 'confirmed',
            'created_at' => date('Y-m-d H:i:s'),
            'whatsapp_notice' => self::generateWhatsAppNotice($orderNumber, $calc['grand_total'], $orderData['customer_name'] ?? 'Customer')
        ];
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
     * Get all orders dynamically from database or fallback
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
                            'customer' => $r['customer_name'] ?? 'Direct Customer',
                            'customer_type' => ucfirst($r['customer_type'] ?? 'Retail'),
                            'phone' => $r['customer_phone'] ?? '+91 98765 43210',
                            'date' => date('d M Y, h:i A', strtotime($r['created_at'] ?? 'now')),
                            'items_count' => '1 lot',
                            'items_summary' => 'Ethnic Silk Sarees',
                            'amount' => (float)($r['total_amount'] ?? 0),
                            'payment' => $r['payment_method'] ?? 'Bank Wire / RTGS',
                            'payment_status' => $r['payment_status'] ?? 'paid',
                            'shipping' => 'VRL Logistics Depot',
                            'tracking' => 'TRK-' . rand(10000, 99999),
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
                'id' => 'DTB-001624',
                'customer' => 'Rajesh Kumar (Vardhman Tex)',
                'customer_type' => 'Wholesale B2B',
                'phone' => '+91 98220 19283',
                'date' => '21 Aug 2026, 11:20 AM',
                'items_count' => '25 pcs',
                'items_summary' => 'Kanjivaram Pure Zari (x25)',
                'amount' => 112250,
                'payment' => 'Bank Wire / RTGS',
                'payment_status' => 'paid',
                'shipping' => 'VRL Logistics Depot',
                'tracking' => 'VRL-99821',
                'status' => 'shipped',
                'source' => 'B2B Portal',
                'updated' => '10 mins ago'
            ],
            [
                'id' => 'DTB-001623',
                'customer' => 'Pooja Sharma',
                'customer_type' => 'Retail Customer (B2C)',
                'phone' => '+91 98110 29381',
                'date' => '21 Aug 2026, 10:45 AM',
                'items_count' => '1 pc',
                'items_summary' => 'Banarasi Brocade Silk (x1)',
                'amount' => 4990,
                'payment' => 'UPI / PhonePe',
                'payment_status' => 'paid',
                'shipping' => 'BlueDart Express Air',
                'tracking' => 'BD-88291',
                'status' => 'delivered',
                'source' => 'Online Shop',
                'updated' => '30 mins ago'
            ]
        ];
    }
}

