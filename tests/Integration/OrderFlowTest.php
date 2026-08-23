<?php
namespace DTBrand\Tests\Integration;

use PHPUnit\Framework\TestCase;
use DTBrand\PricingCalculator;
use DTBrand\DiscountEngine;

class OrderFlowTest extends TestCase {
    
    public function testCompleteWholesaleOrderCalculation(): void {
        $mrp = 5000.0;
        $wholesalePrice = PricingCalculator::calculateWholesalePrice($mrp, 25.0); // 3750
        $qty = 10;
        $subtotal = $wholesalePrice * $qty; // 37500

        $coupons = [
            'BULK5' => ['type' => 'percent', 'value' => 5, 'min_order' => 20000, 'max_discount' => 2000]
        ];

        $couponResult = DiscountEngine::applyCoupon('BULK5', $subtotal, $coupons);
        $this->assertTrue($couponResult['valid']);
        $this->assertEquals(1875.0, $couponResult['discount']);

        $orderSummary = PricingCalculator::calculateOrderTotal($subtotal, $couponResult['discount'], 250.0, 5.0);
        
        $this->assertEquals(37500.0, $orderSummary['subtotal']);
        $this->assertEquals(1875.0, $orderSummary['discount']);
        $this->assertEquals(35625.0, $orderSummary['taxable']);
        $this->assertEquals(1781.25, $orderSummary['gst']);
        $this->assertEquals(250.0, $orderSummary['shipping']);
        $this->assertEquals(37656.25, $orderSummary['grand_total']);
    }
}
