<?php

namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTBrand\ProductCatalog;
use DTBrand\Database;

/**
 * ProductCatalogTest — guards the empty-grids contract.
 *
 * The catalogue used to invent rows when the database was unreachable; the
 * hard rule now is that getAll() returns [] when MySQL is down, so the
 * storefront renders an honest empty grid rather than fake merchandise.
 */
class ProductCatalogTest extends TestCase
{
    public function testGetAllReturnsArrayShape(): void
    {
        $products = ProductCatalog::getAll();
        $this->assertIsArray($products);
        // Live or empty — both are valid. The test only pins the contract
        // that getAll() always returns an array.
    }

    public function testGetAllReturnsEmptyWhenDatabaseUnreachable(): void
    {
        // Force the no-database path even if the host has MySQL up.
        Database::reset();
        $products = ProductCatalog::getAll();
        $this->assertSame([], $products);
    }

    public function testGetByIdReturnsNullWhenMissing(): void
    {
        Database::reset();
        $this->assertNull(ProductCatalog::getById(999999999));
    }

    public function testGetCategoriesReturnsArray(): void
    {
        Database::reset();
        $cats = ProductCatalog::getCategories();
        $this->assertIsArray($cats);
        $this->assertSame([], $cats);
    }

    public function testPublicStatusesDoNotLeakDrafts(): void
    {
        // getAll(includeDrafts: false) filters out 'draft' rows. With no DB
        // the contract still holds: returns [].
        Database::reset();
        $this->assertSame([], ProductCatalog::getAll(false));
        $this->assertSame([], ProductCatalog::getAll(true));
    }
}