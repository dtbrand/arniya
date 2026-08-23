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
}
