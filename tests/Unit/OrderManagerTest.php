<?php

namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTBrand\OrderManager;

class OrderManagerTest extends TestCase
{
    public function testCreateOrderCalculation(): void
    {
        $orderData = [
            'customer_name' => 'Radhika Textiles',
            'customer_phone' => '+91 98765 43210',
            'channel' => 'wholesale',
            'items' => [
                ['price' => 3850.00, 'quantity' => 8], // 30,800
                ['price' => 3350.00, 'quantity' => 4]  // 13,400 -> subtotal = 44,200
            ],
            'discount' => 2000.00, // discounted subtotal = 42,200
            'shipping' => 0.0,
            'gst_rate' => 5.0 // gst 5% on 42,200 = 2,110 -> grand total = 44,310
        ];

        $order = OrderManager::createOrder($orderData);

        $this->assertIsArray($order);
        $this->assertStringStartsWith('DT-ORD-', $order['order_number']);
        $this->assertEquals(2, $order['items_count']);
        $this->assertEquals(44200.00, $order['pricing']['subtotal']);
        $this->assertEquals(2000.00, $order['pricing']['discount']);
        $this->assertEquals(2110.00, $order['pricing']['gst']);
        $this->assertEquals(44310.00, $order['pricing']['grand_total']);
        $this->assertStringContainsString('Namaste Radhika Textiles ji!', $order['whatsapp_notice']);
    }
}
