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
            'sku' => 'KLN-SR-111',
            'title' => 'Nilambari Silk Saree with Rich Zari Pallu',
            'slug' => 'nilambari-silk-saree-rich-zari-pallu',
            'category' => 'Kanjivaram Silk',
            'fabric' => 'Pure Mulberry Silk',
            'weave' => 'Handloom Korvai Weave',
            'color' => 'Crimson Red & Antique Gold',
            'mrp' => 6500.00,
            'retail_price' => 4899.00,
            'wholesale_price' => 1399.00,
            'reseller_price' => 2100.00,
            'reseller_profit' => 2100.00,
            'moq' => 8,
            'stock_qty' => 95,
            'status' => 'in_stock',
            'rating' => 4.9,
            'reviews_count' => 142,
            'badge' => 'Bestseller',
            'image' => '/Frontend/Shop/Asset/images/product1.png',
            'gallery' => [
                '/Frontend/Shop/Asset/images/product1.png',
                '/Frontend/Single-Product/Asset/images/product-01.jpg',
            ],
            'description' => 'Authentic handwoven Kanjivaram pure silk saree featuring pure tested gold zari pallu and contrast korvai border.',
            'moq_lots' => ['single' => 1, 'half_set' => 4, 'full_set' => 8, 'master_bale' => 24]
        ],
        [
            'id' => 2,
            'sku' => 'BNR-SR-204',
            'title' => 'Royal Banarasi Meenakari Silk Saree',
            'slug' => 'royal-banarasi-meenakari-silk-saree',
            'category' => 'Banarasi Silk',
            'fabric' => 'Katan Brocade Silk',
            'weave' => 'Varanasi Kadwa Weave',
            'color' => 'Royal Emerald & Rose Gold',
            'mrp' => 11000.00,
            'retail_price' => 8499.00,
            'wholesale_price' => 2499.00,
            'reseller_price' => 3500.00,
            'reseller_profit' => 3500.00,
            'moq' => 6,
            'stock_qty' => 68,
            'status' => 'in_stock',
            'rating' => 4.9,
            'reviews_count' => 98,
            'badge' => 'Heritage',
            'image' => '/Frontend/Shop/Asset/images/product2.png',
            'gallery' => [
                '/Frontend/Shop/Asset/images/product2.png',
                '/Frontend/Single-Product/Asset/images/product-02.jpg',
            ],
            'description' => 'Intricate floral jaal Banarasi katan silk saree crafted with rich gold tested zari weaves.',
            'moq_lots' => ['single' => 1, 'half_set' => 4, 'full_set' => 8, 'master_bale' => 24]
        ],
        [
            'id' => 3,
            'sku' => 'PTH-MH-305',
            'title' => 'Maharani Paithani Handloom Silk Saree',
            'slug' => 'maharani-paithani-handloom-silk-saree',
            'category' => 'Paithani',
            'fabric' => 'Handloom Pure Silk',
            'weave' => 'Yeola Tapestry Technique',
            'color' => 'Peacock Blue & Magenta',
            'mrp' => 12500.00,
            'retail_price' => 9499.00,
            'wholesale_price' => 3199.00,
            'reseller_price' => 4200.00,
            'reseller_profit' => 4200.00,
            'moq' => 4,
            'stock_qty' => 42,
            'status' => 'in_stock',
            'rating' => 5.0,
            'reviews_count' => 86,
            'badge' => 'Royal VIP',
            'image' => '/Frontend/Shop/Asset/images/product3.png',
            'gallery' => [
                '/Frontend/Shop/Asset/images/product3.png',
                '/Frontend/Single-Product/Asset/images/product-03.jpg',
            ],
            'description' => 'Traditional hand-woven Paithani silk saree featuring authentic Asawali motif and kaleidoscopic pallu.',
            'moq_lots' => ['single' => 1, 'half_set' => 4, 'full_set' => 8, 'master_bale' => 24]
        ],
        [
            'id' => 4,
            'sku' => 'CHN-FO-401',
            'title' => 'Chanderi Foil Printed Festive Kurti Set',
            'slug' => 'chanderi-foil-printed-festive-kurti-set',
            'category' => 'Designer Kurtis',
            'fabric' => 'Chanderi Silk Blend',
            'weave' => 'Tissue Foil Print',
            'color' => 'Sunset Mustard Gold',
            'mrp' => 3499.00,
            'retail_price' => 2290.00,
            'wholesale_price' => 850.00,
            'reseller_price' => 1450.00,
            'reseller_profit' => 1450.00,
            'moq' => 12,
            'stock_qty' => 62,
            'status' => 'in_stock',
            'rating' => 4.8,
            'reviews_count' => 68,
            'badge' => 'Hot Deal',
            'image' => '/Frontend/Shop/Asset/images/product4.png',
            'gallery' => [
                '/Frontend/Shop/Asset/images/product4.png',
            ],
            'description' => 'Festive designer kurti set with matching pants and gold foil printed pure dupatta.',
            'moq_lots' => ['single' => 1, 'half_set' => 6, 'full_set' => 12, 'master_bale' => 36]
        ],
        [
            'id' => 5,
            'sku' => 'BRD-LH-902',
            'title' => 'Crimson Bridal Handcrafted Zardosi Lehenga',
            'slug' => 'crimson-bridal-handcrafted-zardosi-lehenga',
            'category' => 'Bridal Lehengas',
            'fabric' => 'Velvet & Raw Silk',
            'weave' => 'Hand Zari Zardosi',
            'color' => 'Crimson Velvet Red',
            'mrp' => 24990.00,
            'retail_price' => 16490.00,
            'wholesale_price' => 11500.00,
            'reseller_price' => 13800.00,
            'reseller_profit' => 4500.00,
            'moq' => 2,
            'stock_qty' => 18,
            'status' => 'in_stock',
            'rating' => 5.0,
            'reviews_count' => 42,
            'badge' => 'Luxury Bride',
            'image' => '/Frontend/Shop/Asset/images/product5.png',
            'gallery' => [
                '/Frontend/Shop/Asset/images/product5.png',
            ],
            'description' => 'Grand royal bridal lehenga with comprehensive hand zardosi, pearl, and dabka needlework.',
            'moq_lots' => ['single' => 1, 'half_set' => 2, 'full_set' => 4]
        ],
        [
            'id' => 6,
            'sku' => 'ORG-TS-508',
            'title' => 'Organza Glass Tissue Floral Zari Saree',
            'slug' => 'organza-glass-tissue-floral-zari-saree',
            'category' => 'Organza Tissue',
            'fabric' => 'Glass Tissue Organza',
            'weave' => 'Cutwork Scallop Weave',
            'color' => 'Pastel Mint & Silver',
            'mrp' => 4999.00,
            'retail_price' => 3499.00,
            'wholesale_price' => 1150.00,
            'reseller_price' => 1750.00,
            'reseller_profit' => 1750.00,
            'moq' => 8,
            'stock_qty' => 54,
            'status' => 'in_stock',
            'rating' => 4.7,
            'reviews_count' => 56,
            'badge' => 'Trending',
            'image' => '/Frontend/Shop/Asset/images/product6.png',
            'gallery' => [
                '/Frontend/Shop/Asset/images/product6.png',
            ],
            'description' => 'Ultra-lightweight modern pastel organza saree with delicate scalloped gold borders.',
            'moq_lots' => ['single' => 1, 'half_set' => 4, 'full_set' => 8, 'master_bale' => 24]
        ]
    ];

    public static function getAll(): array
    {
        return self::$products;
    }

    public static function getById(int $id): ?array
    {
        foreach (self::$products as $product) {
            if ($product['id'] === $id) {
                return $product;
            }
        }
        return null;
    }

    public static function getBySku(string $sku): ?array
    {
        foreach (self::$products as $product) {
            if (strcasecmp($product['sku'], $sku) === 0) {
                return $product;
            }
        }
        return null;
    }

    public static function getCategories(): array
    {
        $categories = [];
        foreach (self::$products as $product) {
            if (!in_array($product['category'], $categories, true)) {
                $categories[] = $product['category'];
            }
        }
        return $categories;
    }

    public static function filter(array $criteria = []): array
    {
        return array_values(array_filter(self::$products, function ($product) use ($criteria) {
            if (!empty($criteria['category']) && strcasecmp($product['category'], $criteria['category']) !== 0) {
                return false;
            }
            if (!empty($criteria['fabric']) && strcasecmp($product['fabric'], $criteria['fabric']) !== 0) {
                return false;
            }
            if (!empty($criteria['max_price']) && $product['retail_price'] > (float)$criteria['max_price']) {
                return false;
            }
            if (!empty($criteria['search'])) {
                $term = strtolower($criteria['search']);
                $title = strtolower($product['title']);
                $sku = strtolower($product['sku']);
                if (strpos($title, $term) === false && strpos($sku, $term) === false) {
                    return false;
                }
            }
            return true;
        }));
    }
}
