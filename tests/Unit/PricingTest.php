<?php
namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTBrand\PricingCalculator;

class PricingTest extends TestCase {
    
    public function testCalculateWholesalePrice(): void {
        $mrp = 2500.0;
        $discount = 20.0;
        $wholesale = PricingCalculator::calculateWholesalePrice($mrp, $discount);
        $this->assertEquals(2000.0, $wholesale);
    }

    public function testCalculateGst(): void {
        $amount = 10000.0;
        $gst = PricingCalculator::calculateGst($amount, 5.0);
        $this->assertEquals(500.0, $gst);
    }

    public function testCalculateOrderTotal(): void {
        $result = PricingCalculator::calculateOrderTotal(10000.0, 1000.0, 150.0, 5.0);
        $this->assertEquals(10000.0, $result['subtotal']);
        $this->assertEquals(1000.0, $result['discount']);
        $this->assertEquals(9000.0, $result['taxable']);
        $this->assertEquals(450.0, $result['gst']);
        $this->assertEquals(150.0, $result['shipping']);
        $this->assertEquals(9600.0, $result['grand_total']);
    }
}
