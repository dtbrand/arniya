<?php
namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTBrand\DiscountEngine;
use DTBrand\Database;

/**
 * DiscountTest — validations against the live coupon engine.
 *
 * The DiscountEngine now reads the live `coupons` table; the old in-memory
 * fallback dictionary is gone. These tests therefore need a working MySQL
 * connection (see tests/bootstrap.php) — they assert that the engine returns
 * the right shape for the empty/invalid cases, plus the explicit error path
 * when the database is unreachable.
 */
class DiscountTest extends TestCase
{
    public function testEmptyCodeIsRejected(): void
    {
        $result = DiscountEngine::applyCoupon('', 5000.0);
        $this->assertFalse($result['valid']);
        $this->assertEquals(0.0, $result['discount']);
        $this->assertStringContainsString('enter a coupon', strtolower((string)($result['message'] ?? '')));
    }

    public function testInvalidCouponReturnsFalse(): void
    {
        // No such code in the seed data, or DB down — both must come back invalid.
        Database::reset();
        $result = DiscountEngine::applyCoupon('NOPE_' . bin2hex(random_bytes(4)), 5000.0);
        $this->assertFalse($result['valid']);
        $this->assertEquals(0.0, $result['discount']);
    }

    public function testUnreachableDatabaseReturnsExplicitInvalid(): void
    {
        // Force the no-database path even if the host has MySQL up.
        Database::reset();
        $result = DiscountEngine::applyCoupon('WELCOME10', 5000.0);
        $this->assertFalse($result['valid']);
        $this->assertEquals(0.0, $result['discount']);
        $this->assertStringContainsString('unavailable', strtolower((string)($result['message'] ?? '')));
    }
}