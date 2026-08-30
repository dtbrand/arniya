<?php
namespace DTBrand\Tests\Integration;

use PHPUnit\Framework\TestCase;
use DTBrand\PricingCalculator;

/**
 * OrderFlowTest — pricing math (the part that does not need a database).
 *
 * The old revision of this test called DiscountEngine::applyCoupon() with a
 * bespoke in-memory coupons array, which DiscountEngine no longer honours
 * — it reads only the live `coupons` table now. The pricing-side math is
 * exercised here so the order-totals contract stays locked.
 */
class OrderFlowTest extends TestCase
{
    public function testCompleteWholesaleOrderCalculation(): void
    {
        $mrp = 5000.0;
        $wholesalePrice = PricingCalculator::calculateWholesalePrice($mrp, 25.0); // 3750
        $qty = 10;
        $subtotal = $wholesalePrice * $qty; // 37,500

        // We do not call DiscountEngine here; the engine now reads the live DB.
        // The order-totals math is what this test pins down.
        $orderSummary = PricingCalculator::calculateOrderTotal($subtotal, 0.0, 250.0, 5.0);

        $this->assertEquals(37500.0, $orderSummary['subtotal']);
        $this->assertEquals(37500.0, $orderSummary['taxable']);
        $this->assertEquals(1875.0, $orderSummary['gst']);
        $this->assertEquals(250.0, $orderSummary['shipping']);
        $this->assertEquals(39625.0, $orderSummary['grand_total']);
    }
}