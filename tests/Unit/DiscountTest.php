<?php
namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTBrand\DiscountEngine;
use DTBrand\Database;

/**
 * DiscountTest — Comprehensive validations for the live coupon engine.
 *
 * Tests contract adherence, offline resilience, SQL coupon validation,
 * percentage caps, flat discounts, minimum order requirements, and expiry checks.
 */
class DiscountTest extends TestCase
{
    private ?\PDO $testPdo = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testPdo = $this->createTestDatabase();
    }

    protected function tearDown(): void
    {
        Database::setPdo(null, true);
        $this->testPdo = null;
        parent::tearDown();
    }

    private function createTestDatabase(): \PDO
    {
        $pdo = new \PDO('sqlite::memory:');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->exec("
            CREATE TABLE coupons (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                code TEXT NOT NULL,
                discount_type TEXT NOT NULL,
                discount_value REAL NOT NULL,
                min_order_value REAL DEFAULT 0,
                max_discount REAL DEFAULT 0,
                status TEXT DEFAULT 'active'
            )
        ");
        $pdo->exec("
            INSERT INTO coupons (code, discount_type, discount_value, min_order_value, max_discount, status) VALUES
            ('SAVE10', 'percentage', 10, 1000, 0, 'active'),
            ('FLAT500', 'flat', 500, 2000, 0, 'active'),
            ('MEGA50CAP', 'percentage', 50, 1000, 1500, 'active'),
            ('EXPIRED20', 'percentage', 20, 500, 0, 'expired')
        ");
        return $pdo;
    }

    public function testEmptyCodeIsRejected(): void
    {
        $result = DiscountEngine::applyCoupon('', 5000.0);
        $this->assertFalse($result['valid']);
        $this->assertEquals(0.0, $result['discount']);
        $this->assertStringContainsString('enter a coupon', strtolower((string)($result['message'] ?? '')));
    }

    public function testInvalidCouponReturnsFalse(): void
    {
        Database::setPdo($this->testPdo);
        $result = DiscountEngine::applyCoupon('NOPE_' . bin2hex(random_bytes(4)), 5000.0);
        $this->assertFalse($result['valid']);
        $this->assertEquals(0.0, $result['discount']);
        $this->assertStringContainsString('invalid or expired', strtolower((string)($result['message'] ?? '')));
    }

    public function testUnreachableDatabaseReturnsExplicitInvalid(): void
    {
        Database::setPdo(null, true);
        $result = DiscountEngine::applyCoupon('SAVE10', 5000.0);
        $this->assertFalse($result['valid']);
        $this->assertEquals(0.0, $result['discount']);
        $this->assertStringContainsString('unavailable', strtolower((string)($result['message'] ?? '')));
    }

    public function testApplyPercentageCouponWithoutCap(): void
    {
        Database::setPdo($this->testPdo);
        $result = DiscountEngine::applyCoupon('SAVE10', 5000.0);
        $this->assertTrue($result['valid']);
        $this->assertEquals(500.0, $result['discount']);
        $this->assertEquals('SAVE10', $result['code']);
        $this->assertStringContainsString('500.00', $result['message']);
    }

    public function testApplyPercentageCouponWithCap(): void
    {
        Database::setPdo($this->testPdo);
        // 50% of 10000 = 5000, but capped at 1500
        $result = DiscountEngine::applyCoupon('MEGA50CAP', 10000.0);
        $this->assertTrue($result['valid']);
        $this->assertEquals(1500.0, $result['discount']);
    }

    public function testApplyFlatCoupon(): void
    {
        Database::setPdo($this->testPdo);
        $result = DiscountEngine::applyCoupon('FLAT500', 3000.0);
        $this->assertTrue($result['valid']);
        $this->assertEquals(500.0, $result['discount']);
    }

    public function testFlatCouponDoesNotExceedSubtotal(): void
    {
        Database::setPdo($this->testPdo);
        // If subtotal is 400 and flat coupon is 500, discount capped at 400
        $this->testPdo->exec("INSERT INTO coupons (code, discount_type, discount_value, min_order_value, max_discount, status) VALUES ('FLATSMALL', 'flat', 500, 100, 0, 'active')");
        $result = DiscountEngine::applyCoupon('FLATSMALL', 400.0);
        $this->assertTrue($result['valid']);
        $this->assertEquals(400.0, $result['discount']);
    }

    public function testMinimumOrderValueEnforced(): void
    {
        Database::setPdo($this->testPdo);
        // FLAT500 requires min 2000; test with 1500
        $result = DiscountEngine::applyCoupon('FLAT500', 1500.0);
        $this->assertFalse($result['valid']);
        $this->assertEquals(0.0, $result['discount']);
        $this->assertStringContainsString('minimum order value', strtolower((string)($result['message'] ?? '')));
    }

    public function testExpiredCouponRejected(): void
    {
        Database::setPdo($this->testPdo);
        $result = DiscountEngine::applyCoupon('EXPIRED20', 2000.0);
        $this->assertFalse($result['valid']);
        $this->assertEquals(0.0, $result['discount']);
        $this->assertStringContainsString('invalid or expired', strtolower((string)($result['message'] ?? '')));
    }

    public function testCodeNormalizationCaseAndWhitespace(): void
    {
        Database::setPdo($this->testPdo);
        $result = DiscountEngine::applyCoupon('  save10  ', 5000.0);
        $this->assertTrue($result['valid']);
        $this->assertEquals(500.0, $result['discount']);
        $this->assertEquals('SAVE10', $result['code']);
    }

    public function testGetActiveCoupons(): void
    {
        Database::setPdo($this->testPdo);
        $coupons = DiscountEngine::getActiveCoupons();
        $this->assertIsArray($coupons);
        // Must contain active coupons, not expired
        $codes = array_column($coupons, 'code');
        $this->assertContains('SAVE10', $codes);
        $this->assertContains('FLAT500', $codes);
        $this->assertContains('MEGA50CAP', $codes);
        $this->assertNotContains('EXPIRED20', $codes);
    }

    public function testFormatDiscountBadge(): void
    {
        $flatCoupon = ['discount_type' => 'flat', 'discount_value' => 500.0];
        $this->assertEquals('₹500 FLAT OFF', DiscountEngine::formatDiscountBadge($flatCoupon));

        $percentWithCap = ['discount_type' => 'percentage', 'discount_value' => 15.0, 'max_discount' => 1000.0];
        $this->assertEquals('15% OFF (Up to ₹1,000)', DiscountEngine::formatDiscountBadge($percentWithCap));

        $purePercent = ['discount_type' => 'percentage', 'discount_value' => 10.0, 'max_discount' => 0.0];
        $this->assertEquals('10% OFF', DiscountEngine::formatDiscountBadge($purePercent));
    }

    public function testCalculateCartDiscountReturnsNumeric(): void
    {
        Database::setPdo($this->testPdo);
        $disc = DiscountEngine::calculateCartDiscount('SAVE10', 5000.0);
        $this->assertEquals(500.0, $disc);

        $discInvalid = DiscountEngine::calculateCartDiscount('INVALID_CODE', 10000.0);
        $this->assertEquals(0.0, $discInvalid);
    }
}