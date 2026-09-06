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

    public function testTieredVolumeDiscountDefaultTiers(): void {
        // Standard tier (5 units, 0% volume discount)
        $standard = PricingCalculator::calculateTieredVolumeDiscount(1000.0, 5);
        $this->assertEquals(0.0, $standard['discount_percent']);
        $this->assertEquals(1000.0, $standard['discounted_unit_price']);
        $this->assertEquals(5000.0, $standard['total_price']);
        $this->assertEquals(0.0, $standard['total_discount']);

        // Half Bale (20 units, 5% volume discount)
        $halfBale = PricingCalculator::calculateTieredVolumeDiscount(1000.0, 20);
        $this->assertEquals(5.0, $halfBale['discount_percent']);
        $this->assertEquals(950.0, $halfBale['discounted_unit_price']);
        $this->assertEquals(19000.0, $halfBale['total_price']);
        $this->assertEquals(1000.0, $halfBale['total_discount']);

        // Full Bale (60 units, 10% volume discount)
        $fullBale = PricingCalculator::calculateTieredVolumeDiscount(1000.0, 60);
        $this->assertEquals(10.0, $fullBale['discount_percent']);
        $this->assertEquals(900.0, $fullBale['discounted_unit_price']);
        $this->assertEquals(54000.0, $fullBale['total_price']);
        $this->assertEquals(6000.0, $fullBale['total_discount']);

        // Master Lot (150 units, 15% volume discount)
        $masterLot = PricingCalculator::calculateTieredVolumeDiscount(1000.0, 150);
        $this->assertEquals(15.0, $masterLot['discount_percent']);
        $this->assertEquals(850.0, $masterLot['discounted_unit_price']);
        $this->assertEquals(127500.0, $masterLot['total_price']);
        $this->assertEquals(22500.0, $masterLot['total_discount']);
    }

    public function testResellerMarginCalculation(): void {
        $cost = 800.0;
        $retail = 1200.0;
        $margin = PricingCalculator::calculateResellerMargin($cost, $retail);

        $this->assertEquals(400.0, $margin['margin_amount']);
        $this->assertEquals(50.0, $margin['margin_percent']); // 400 / 800 = 50%
        $this->assertEquals(33.33, $margin['profit_margin_on_sale']); // 400 / 1200 = 33.33%
        $this->assertTrue($margin['is_profitable']);
    }

    public function testGstSplitIntraState(): void {
        // Intra-state Gujarat to Gujarat: CGST 2.5% + SGST 2.5%
        $split = PricingCalculator::calculateGstSplit(10000.0, 5.0, 'Gujarat', 'Gujarat');
        $this->assertFalse($split['is_interstate']);
        $this->assertEquals(2.5, $split['cgst_rate']);
        $this->assertEquals(250.0, $split['cgst_amount']);
        $this->assertEquals(2.5, $split['sgst_rate']);
        $this->assertEquals(250.0, $split['sgst_amount']);
        $this->assertEquals(0.0, $split['igst_amount']);
        $this->assertEquals(500.0, $split['total_gst']);
    }

    public function testGstSplitInterstate(): void {
        // Inter-state Gujarat to Maharashtra: IGST 5%
        $split = PricingCalculator::calculateGstSplit(10000.0, 5.0, 'Maharashtra', 'Gujarat');
        $this->assertTrue($split['is_interstate']);
        $this->assertEquals(0.0, $split['cgst_amount']);
        $this->assertEquals(0.0, $split['sgst_amount']);
        $this->assertEquals(5.0, $split['igst_rate']);
        $this->assertEquals(500.0, $split['igst_amount']);
        $this->assertEquals(500.0, $split['total_gst']);
    }

    public function testFormatInr(): void {
        $this->assertEquals('₹1,500.00', PricingCalculator::formatInr(1500.0));
        $this->assertEquals('₹1,50,000.00', PricingCalculator::formatInr(150000.0));
        $this->assertEquals('₹12,34,56,789.50', PricingCalculator::formatInr(123456789.50));
        $this->assertEquals('-₹5,000.00', PricingCalculator::formatInr(-5000.0));
        $this->assertEquals('1,50,000.00', PricingCalculator::formatInr(150000.0, false));
    }

    public function testInvalidArgumentsThrowExceptions(): void {
        $this->expectException(\InvalidArgumentException::class);
        PricingCalculator::calculateWholesalePrice(-500.0, 10.0);
    }

    public function testInvalidDiscountPercentThrowsException(): void {
        $this->expectException(\InvalidArgumentException::class);
        PricingCalculator::calculateWholesalePrice(2000.0, 150.0);
    }

    public function testNegativeGstThrowsException(): void {
        $this->expectException(\InvalidArgumentException::class);
        PricingCalculator::calculateGst(1000.0, -5.0);
    }

    public function testOrderTotalDiscountExceedingSubtotalClampsToZero(): void {
        $result = PricingCalculator::calculateOrderTotal(500.0, 800.0, 50.0, 5.0);
        $this->assertEquals(0.0, $result['taxable']);
        $this->assertEquals(0.0, $result['gst']);
        $this->assertEquals(50.0, $result['grand_total']);
    }

    public function testTieredVolumeDiscountCustomTiers(): void {
        $customTiers = [
            ['min_qty' => 500, 'discount_percent' => 25.0, 'tier_name' => 'Mega Factory Lot (500+)'],
            ['min_qty' => 200, 'discount_percent' => 20.0, 'tier_name' => 'Wholesale Bale (200+)'],
        ];

        $matched = PricingCalculator::calculateTieredVolumeDiscount(800.0, 250, $customTiers);
        $this->assertEquals(20.0, $matched['discount_percent']);
        $this->assertEquals('Wholesale Bale (200+)', $matched['tier_name']);
        $this->assertEquals(640.0, $matched['discounted_unit_price']);
        $this->assertEquals(160000.0, $matched['total_price']);
        $this->assertEquals(40000.0, $matched['total_discount']);
    }

    public function testResellerMarginUnprofitable(): void {
        $cost = 1000.0;
        $retail = 800.0;
        $margin = PricingCalculator::calculateResellerMargin($cost, $retail);

        $this->assertEquals(-200.0, $margin['margin_amount']);
        $this->assertEquals(-20.0, $margin['margin_percent']);
        $this->assertEquals(-25.0, $margin['profit_margin_on_sale']);
        $this->assertFalse($margin['is_profitable']);
    }

    public function testFormatInrZeroAndSingleDigits(): void {
        $this->assertEquals('₹0.00', PricingCalculator::formatInr(0.0));
        $this->assertEquals('₹5.00', PricingCalculator::formatInr(5.0));
        $this->assertEquals('₹999.00', PricingCalculator::formatInr(999.0));
        $this->assertEquals('0.00', PricingCalculator::formatInr(0.0, false));
    }

    public function testTieredVolumeDiscountExactBoundaryQuantities(): void {
        $base = 2000.0;

        // 9 units -> Standard Lot (0%)
        $q9 = PricingCalculator::calculateTieredVolumeDiscount($base, 9);
        $this->assertEquals(0.0, $q9['discount_percent']);
        $this->assertEquals('Standard Lot (1-9)', $q9['tier_name']);

        // 10 units -> Half Bale (5%)
        $q10 = PricingCalculator::calculateTieredVolumeDiscount($base, 10);
        $this->assertEquals(5.0, $q10['discount_percent']);
        $this->assertEquals('Half Bale (10+)', $q10['tier_name']);

        // 49 units -> Half Bale (5%)
        $q49 = PricingCalculator::calculateTieredVolumeDiscount($base, 49);
        $this->assertEquals(5.0, $q49['discount_percent']);

        // 50 units -> Full Bale (10%)
        $q50 = PricingCalculator::calculateTieredVolumeDiscount($base, 50);
        $this->assertEquals(10.0, $q50['discount_percent']);
        $this->assertEquals('Full Bale (50+)', $q50['tier_name']);

        // 99 units -> Full Bale (10%)
        $q99 = PricingCalculator::calculateTieredVolumeDiscount($base, 99);
        $this->assertEquals(10.0, $q99['discount_percent']);

        // 100 units -> Master Lot (15%)
        $q100 = PricingCalculator::calculateTieredVolumeDiscount($base, 100);
        $this->assertEquals(15.0, $q100['discount_percent']);
        $this->assertEquals('Master Lot (100+)', $q100['tier_name']);
    }

    public function testTieredVolumeDiscountZeroOrNegativeQuantityThrowsException(): void {
        $this->expectException(\InvalidArgumentException::class);
        PricingCalculator::calculateTieredVolumeDiscount(1000.0, 0);
    }

    public function testTieredVolumeDiscountNegativeBasePriceThrowsException(): void {
        $this->expectException(\InvalidArgumentException::class);
        PricingCalculator::calculateTieredVolumeDiscount(-50.0, 10);
    }

    public function testGstSplitCaseInsensitiveAndTrimming(): void {
        // Customer state with spaces and mixed case ' gujarat ' vs seller 'Gujarat'
        $split = PricingCalculator::calculateGstSplit(20000.0, 5.0, ' gujarat ', 'Gujarat');
        $this->assertFalse($split['is_interstate']);
        $this->assertEquals(2.5, $split['cgst_rate']);
        $this->assertEquals(500.0, $split['cgst_amount']);
        $this->assertEquals(500.0, $split['sgst_amount']);
        $this->assertEquals(1000.0, $split['total_gst']);

        // Empty customer state defaults safely to intra-state
        $emptyState = PricingCalculator::calculateGstSplit(10000.0, 5.0, '', 'Gujarat');
        $this->assertFalse($emptyState['is_interstate']);
    }

    public function testGstSplitCustomRates(): void {
        // 12% intra-state (6% CGST + 6% SGST)
        $split12 = PricingCalculator::calculateGstSplit(10000.0, 12.0, 'Gujarat', 'Gujarat');
        $this->assertEquals(6.0, $split12['cgst_rate']);
        $this->assertEquals(600.0, $split12['cgst_amount']);
        $this->assertEquals(6.0, $split12['sgst_rate']);
        $this->assertEquals(600.0, $split12['sgst_amount']);
        $this->assertEquals(1200.0, $split12['total_gst']);

        // 18% inter-state (18% IGST)
        $split18 = PricingCalculator::calculateGstSplit(10000.0, 18.0, 'Karnataka', 'Gujarat');
        $this->assertTrue($split18['is_interstate']);
        $this->assertEquals(18.0, $split18['igst_rate']);
        $this->assertEquals(1800.0, $split18['igst_amount']);
        $this->assertEquals(1800.0, $split18['total_gst']);
    }

    public function testResellerMarginBreakEven(): void {
        $cost = 1500.0;
        $retail = 1500.0;
        $margin = PricingCalculator::calculateResellerMargin($cost, $retail);

        $this->assertEquals(0.0, $margin['margin_amount']);
        $this->assertEquals(0.0, $margin['margin_percent']);
        $this->assertEquals(0.0, $margin['profit_margin_on_sale']);
        $this->assertTrue($margin['is_profitable']);
    }

    public function testResellerMarginInvalidWholesaleCostThrowsException(): void {
        $this->expectException(\InvalidArgumentException::class);
        PricingCalculator::calculateResellerMargin(-100.0, 500.0);
    }

    public function testFormatInrCroresAndTenCrores(): void {
        // 1 Crore = 1,00,00,000.00
        $this->assertEquals('₹1,00,00,000.00', PricingCalculator::formatInr(10000000.0));
        // 10 Crore = 10,00,00,000.00
        $this->assertEquals('₹10,00,00,000.00', PricingCalculator::formatInr(100000000.0));
        // 10.5 Crore with paisa
        $this->assertEquals('₹10,50,75,320.75', PricingCalculator::formatInr(105075320.75));
    }
}

