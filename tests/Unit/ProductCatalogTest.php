<?php

namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTBrand\ProductCatalog;

class ProductCatalogTest extends TestCase
{
    public function testGetAllProductsReturnsValidArray(): void
    {
        $products = ProductCatalog::getAll();
        $this->assertIsArray($products);
        $this->assertNotEmpty($products);
        $this->assertGreaterThanOrEqual(5, count($products));
    }

    public function testGetProductById(): void
    {
        $product = ProductCatalog::getById(1);
        $this->assertNotNull($product);
        $this->assertEquals(1, $product['id']);
        $this->assertEquals('DT-KANJI-001', $product['sku']);
        $this->assertArrayHasKey('wholesale_price', $product);
        $this->assertArrayHasKey('retail_price', $product);
    }

    public function testFilterByCategory(): void
    {
        $results = ProductCatalog::filter(['category' => 'Kanjivaram Silk']);
        $this->assertNotEmpty($results);
        foreach ($results as $p) {
            $this->assertEquals('Kanjivaram Silk', $p['category']);
        }
    }

    public function testFilterBySearch(): void
    {
        $results = ProductCatalog::filter(['search' => 'Banarasi']);
        $this->assertNotEmpty($results);
        $this->assertStringContainsString('Banarasi', $results[0]['title']);
    }

    public function testGetCategoriesList(): void
    {
        $cats = ProductCatalog::getCategories();
        $this->assertIsArray($cats);
        $this->assertContains('Kanjivaram Silk', $cats);
        $this->assertContains('Banarasi Silk', $cats);
    }
}
