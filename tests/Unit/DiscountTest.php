<?php
namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTBrand\DiscountEngine;

class DiscountTest extends TestCase {
    
    private array $coupons = [
        'FESTIVE20' => [
            'type' => 'percent',
            'value' => 20,
            'min_order' => 2000,
            'max_discount' => 1000
        ],
        'FLAT500' => [
            'type' => 'flat',
            'value' => 500,
            'min_order' => 5000,
            'max_discount' => 500
        ]
    ];

    public function testValidPercentageCoupon(): void {
        $result = DiscountEngine::applyCoupon('FESTIVE20', 3000.0, $this->coupons);
        $this->assertTrue($result['valid']);
        $this->assertEquals(600.0, $result['discount']);
    }

    public function testMaxDiscountCapping(): void {
        $result = DiscountEngine::applyCoupon('FESTIVE20', 10000.0, $this->coupons);
        $this->assertTrue($result['valid']);
        $this->assertEquals(1000.0, $result['discount']);
    }

    public function testBelowMinOrder(): void {
        $result = DiscountEngine::applyCoupon('FESTIVE20', 1500.0, $this->coupons);
        $this->assertFalse($result['valid']);
        $this->assertEquals(0.0, $result['discount']);
    }

    public function testInvalidCoupon(): void {
        $result = DiscountEngine::applyCoupon('INVALIDCODE', 5000.0, $this->coupons);
        $this->assertFalse($result['valid']);
    }
}
