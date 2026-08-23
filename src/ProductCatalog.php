<?php

namespace DTBrand;

/**
 * ProductCatalog — Master Ethnic Saree Inventory & Merchandising Engine
 * DT Brand's & Jai Hanuman Tex
 */
class ProductCatalog
{
    private static array $products = [
        [
            'id' => 1,
            'sku' => 'DT-KANJI-001',
            'title' => 'Royal Heritage Kanjivaram Pure Silk Saree',
            'category' => 'Kanjivaram Silk',
            'fabric' => 'Pure Mulberry Silk',
            'color' => 'Crimson Red & Antique Gold',
            'mrp' => 8999.00,
            'retail_price' => 5499.00,
            'wholesale_price' => 3850.00,
            'reseller_price' => 4599.00,
            'stock_qty' => 48,
            'status' => 'in_stock',
            'rating' => 4.9,
            'reviews_count' => 124,
            'image' => '/Frontend/Single-Product/Asset/images/product-01.jpg',
            'gallery' => [
                '/Frontend/Single-Product/Asset/images/product-01.jpg',
                '/Frontend/Single-Product/Asset/images/product-02.jpg',
            ],
            'description' => 'Authentic handwoven Kanjivaram pure silk saree with heavy pure zari pallu and contrast korvai border.',
            'moq_lots' => ['single' => 1, 'half_set' => 4, 'full_set' => 8]
        ],
        [
            'id' => 2,
            'sku' => 'DT-BANARAS-002',
            'title' => 'Imperial Banarasi Katan Silk Brocade Saree',
            'category' => 'Banarasi Silk',
            'fabric' => 'Katan Silk',
            'color' => 'Royal Emerald & Rose Gold',
            'mrp' => 7499.00,
            'retail_price' => 4799.00,
            'wholesale_price' => 3350.00,
            'reseller_price' => 3999.00,
            'stock_qty' => 62,
            'status' => 'in_stock',
            'rating' => 4.8,
            'reviews_count' => 98,
            'image' => '/Frontend/Single-Product/Asset/images/product-02.jpg',
            'gallery' => [
                '/Frontend/Single-Product/Asset/images/product-02.jpg',
                '/Frontend/Single-Product/Asset/images/product-03.jpg',
            ],
            'description' => 'Intricate floral jaal Banarasi katan silk saree crafted with rich gold tested zari weaves.',
            'moq_lots' => ['single' => 1, 'half_set' => 4, 'full_set' => 8]
        ],
        [
            'id' => 3,
            'sku' => 'DT-PAITH-003',
            'title' => 'Maharani Paithani Handloom Silk Saree',
            'category' => 'Paithani',
            'fabric' => 'Handloom Silk',
            'color' => 'Peacock Blue & Magenta',
            'mrp' => 9999.00,
            'retail_price' => 6299.00,
            'wholesale_price' => 4400.00,
            'reseller_price' => 5299.00,
            'stock_qty' => 34,
            'status' => 'in_stock',
            'rating' => 5.0,
            'reviews_count' => 76,
            'image' => '/Frontend/Single-Product/Asset/images/product-03.jpg',
            'gallery' => [
                '/Frontend/Single-Product/Asset/images/product-03.jpg',
                '/Frontend/Single-Product/Asset/images/product-04.jpg',
            ],
            'description' => 'Traditional Yeola Paithani featuring intricate peacock (mor) pallu and oblique square borders.',
            'moq_lots' => ['single' => 1, 'half_set' => 4, 'full_set' => 8]
        ],
        [
            'id' => 4,
            'sku' => 'DT-CHAND-004',
            'title' => 'Festive Chanderi Pattu Silk Cotton Saree',
            'category' => 'Chanderi',
            'fabric' => 'Silk Cotton Blend',
            'color' => 'Mustard Gold & Ruby Red',
            'mrp' => 4999.00,
            'retail_price' => 2999.00,
            'wholesale_price' => 1950.00,
            'reseller_price' => 2450.00,
            'stock_qty' => 85,
            'status' => 'in_stock',
            'rating' => 4.7,
            'reviews_count' => 142,
            'image' => '/Frontend/Single-Product/Asset/images/product-04.jpg',
            'gallery' => [
                '/Frontend/Single-Product/Asset/images/product-04.jpg',
                '/Frontend/Single-Product/Asset/images/product-01.jpg',
            ],
            'description' => 'Lightweight breathable Chanderi silk cotton saree with fine golden zari bootis and sheer texture.',
            'moq_lots' => ['single' => 1, 'half_set' => 6, 'full_set' => 12]
        ],
        [
            'id' => 5,
            'sku' => 'DT-ORG-005',
            'title' => 'Luxury Organza Floral Zari Embroidered Saree',
            'category' => 'Organza',
            'fabric' => 'Pure Organza Silk',
            'color' => 'Blush Pink & Silver',
            'mrp' => 5999.00,
            'retail_price' => 3699.00,
            'wholesale_price' => 2550.00,
            'reseller_price' => 3100.00,
            'stock_qty' => 50,
            'status' => 'in_stock',
            'rating' => 4.8,
            'reviews_count' => 110,
            'image' => '/Frontend/Single-Product/Asset/images/product-01.jpg',
            'gallery' => [
                '/Frontend/Single-Product/Asset/images/product-01.jpg',
                '/Frontend/Single-Product/Asset/images/product-02.jpg',
            ],
            'description' => 'Contemporary pastel organza saree adorned with handcrafted thread embroidery and scalloped border.',
            'moq_lots' => ['single' => 1, 'half_set' => 4, 'full_set' => 8]
        ],
        [
            'id' => 6,
            'sku' => 'DT-PATOLA-006',
            'title' => 'Heritage Rajkot Patola Double Ikkat Silk Saree',
            'category' => 'Patola',
            'fabric' => 'Ikkat Mulberry Silk',
            'color' => 'Wine Purple & Forest Green',
            'mrp' => 8499.00,
            'retail_price' => 5299.00,
            'wholesale_price' => 3690.00,
            'reseller_price' => 4399.00,
            'stock_qty' => 28,
            'status' => 'in_stock',
            'rating' => 4.9,
            'reviews_count' => 65,
            'image' => '/Frontend/Single-Product/Asset/images/product-02.jpg',
            'gallery' => [
                '/Frontend/Single-Product/Asset/images/product-02.jpg',
                '/Frontend/Single-Product/Asset/images/product-03.jpg',
            ],
            'description' => 'Authentic geometric weave Rajkot Patola double ikkat saree crafted by master weavers.',
            'moq_lots' => ['single' => 1, 'half_set' => 4, 'full_set' => 8]
        ]
    ];

    /**
     * Get all products
     */
    public static function getAll(): array
    {
        return self::$products;
    }

    /**
     * Find product by ID
     */
    public static function getById(int $id): ?array
    {
        foreach (self::$products as $product) {
            if ($product['id'] === $id) {
                return $product;
            }
        }
        return null;
    }

    /**
     * Search and filter products
     */
    public static function filter(array $criteria = []): array
    {
        $filtered = self::$products;

        if (!empty($criteria['category'])) {
            $filtered = array_filter($filtered, fn($p) => strcasecmp($p['category'], $criteria['category']) === 0);
        }

        if (!empty($criteria['search'])) {
            $search = strtolower($criteria['search']);
            $filtered = array_filter($filtered, function($p) use ($search) {
                return str_contains(strtolower($p['title']), $search) ||
                       str_contains(strtolower($p['sku']), $search) ||
                       str_contains(strtolower($p['category']), $search) ||
                       str_contains(strtolower($p['fabric']), $search);
            });
        }

        if (!empty($criteria['max_price'])) {
            $filtered = array_filter($filtered, fn($p) => $p['retail_price'] <= (float)$criteria['max_price']);
        }

        return array_values($filtered);
    }

    /**
     * Get list of unique product categories
     */
    public static function getCategories(): array
    {
        return array_values(array_unique(array_column(self::$products, 'category')));
    }
}
