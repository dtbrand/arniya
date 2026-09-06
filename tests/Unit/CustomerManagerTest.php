<?php

namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTBrand\CustomerManager;
use DTBrand\Database;

/**
 * CustomerManagerTest — Unit tests for Customer Identity, Wholesale & Reseller Partner Engine.
 * Tests contract adherence, offline resilience, and metric aggregations.
 */
class CustomerManagerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Database::reset();
    }

    public function testGetAllReturnsArrayShape(): void
    {
        $customers = CustomerManager::getAll();
        $this->assertIsArray($customers);
    }

    public function testGetByTypeReturnsArray(): void
    {
        $wholesale = CustomerManager::getByType('wholesale');
        $this->assertIsArray($wholesale);

        $resellers = CustomerManager::getByType('reseller');
        $this->assertIsArray($resellers);

        $retail = CustomerManager::getByType('retail');
        $this->assertIsArray($retail);
    }

    public function testGetByIdWithInvalidIdReturnsNull(): void
    {
        $result = CustomerManager::getById(-1);
        $this->assertNull($result);

        $result2 = CustomerManager::getById(999999999);
        $this->assertNull($result2);
    }

    public function testCreateRequiresNameAndPhone(): void
    {
        $resNoName = CustomerManager::create(['phone' => '9876543210']);
        $this->assertFalse($resNoName['success']);
        $this->assertStringContainsString('name is required', $resNoName['message']);

        $resNoPhone = CustomerManager::create(['name' => 'Boutique Owner']);
        $this->assertFalse($resNoPhone['success']);
        $this->assertStringContainsString('phone number is required', $resNoPhone['message']);
    }

    public function testGetStatsStructure(): void
    {
        $stats = CustomerManager::getStats();
        $this->assertIsArray($stats);

        $expectedKeys = [
            'total_customers',
            'wholesale_count',
            'reseller_count',
            'retail_count',
            'credit_extended',
            'outstanding_balance'
        ];
        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $stats, "Customer stats missing expected metric '{$key}'.");
            $this->assertGreaterThanOrEqual(0, $stats[$key]);
        }
    }
}
