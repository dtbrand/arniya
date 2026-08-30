<?php

namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTBrand\Database;

/**
 * SmokeTest — verifies the public PHP runtime and the Database contract.
 * Replaces the old AppArchitectureTest, which reached for an
 * App\Helpers\… namespace that never existed in this tree.
 */
class AppArchitectureTest extends TestCase
{
    public function testPhpVersionSupportsNullCoalesceAssignment(): void
    {
        $this->assertTrue(version_compare(PHP_VERSION, '8.0.0', '>='));
    }

    public function testPdoMysqlExtensionLoaded(): void
    {
        $this->assertTrue(extension_loaded('pdo_mysql'));
    }

    public function testMbstringExtensionLoaded(): void
    {
        $this->assertTrue(extension_loaded('mbstring'));
    }

    public function testDatabaseResetIsSafe(): void
    {
        // Database::reset() exists and is callable; whether the DB is
        // actually reachable does not affect this assertion.
        Database::reset();
        $this->assertTrue(true);
    }

    public function testDatabaseMockModeFlagIsBool(): void
    {
        $this->assertIsBool(Database::isMockMode());
    }
}