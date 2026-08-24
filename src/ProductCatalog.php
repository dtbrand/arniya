<?php

namespace DTBrand;

/**
 * ProductCatalog — Master Ethnic Saree Inventory & Merchandising Engine
 * DT Brand's & Jai Hanuman Tex — Live Hostinger Production Engine
 */
class ProductCatalog
{
    private static array $products = [
        [
            'id' => 1,
            'sku' => 'KLN-SR-111',
            'title' => 'Nilambari Silk Saree with Rich Zari Pallu',
            'name' => 'Nilambari Silk Saree with Rich Zari Pallu',
            'slug' => 'nilambari-silk-saree-rich-zari-pallu',
            'category' => 'Kanjivaram Silk',
            'fabric' => 'Pure Mulberry Silk',
            'weave' => 'Handloom Korvai Weave',
            'color' => 'Crimson Red & Antique Gold',
            'colors' => ['Navy Blue', 'Royal Blue', 'Midnight Black'],
            'size' => ['Free Size', 'M', 'L'],
            'mrp' => 6500.00,
            'old_price' => 6500.00,
            'price' => 4899.00,
            'retail_price' => 4899.00,
            'wholesale_price' => 1399.00,
            'reseller_price' => 2100.00,
            'reseller_profit' => 2100.00,
            'moq' => 8,
            'stock_qty' => 95,
            'in_stock' => true,
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
            'name' => 'Royal Banarasi Meenakari Silk Saree',
            'slug' => 'royal-banarasi-meenakari-silk-saree',
            'category' => 'Banarasi Silk',
            'fabric' => 'Katan Brocade Silk',
            'weave' => 'Varanasi Kadwa Weave',
            'color' => 'Royal Emerald & Rose Gold',
            'colors' => ['Maroon Red', 'Deep Wine', 'Ruby Red'],
            'size' => ['Free Size', 'S', 'M'],
            'mrp' => 11000.00,
            'old_price' => 11000.00,
            'price' => 8499.00,
            'retail_price' => 8499.00,
            'wholesale_price' => 2499.00,
            'reseller_price' => 3500.00,
            'reseller_profit' => 3500.00,
            'moq' => 6,
            'stock_qty' => 68,
            'in_stock' => true,
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
            'name' => 'Maharani Paithani Handloom Silk Saree',
            'slug' => 'maharani-paithani-handloom-silk-saree',
            'category' => 'Paithani',
            'fabric' => 'Handloom Pure Silk',
            'weave' => 'Yeola Tapestry Technique',
            'color' => 'Peacock Blue & Magenta',
            'colors' => ['Peacock Blue', 'Magenta', 'Golden Yellow'],
            'size' => ['Free Size', 'L', 'XL'],
            'mrp' => 12500.00,
            'old_price' => 12500.00,
            'price' => 9499.00,
            'retail_price' => 9499.00,
            'wholesale_price' => 3199.00,
            'reseller_price' => 4200.00,
            'reseller_profit' => 4200.00,
            'moq' => 4,
            'stock_qty' => 42,
            'in_stock' => true,
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
            'name' => 'Chanderi Foil Printed Festive Kurti Set',
            'slug' => 'chanderi-foil-printed-festive-kurti-set',
            'category' => 'Designer Kurtis',
            'fabric' => 'Chanderi Silk Blend',
            'weave' => 'Tissue Foil Print',
            'color' => 'Sunset Mustard Gold',
            'colors' => ['Mustard Gold', 'Rust Orange', 'Wine Red'],
            'size' => ['Free Size', 'S', 'M', 'L'],
            'mrp' => 3499.00,
            'old_price' => 3499.00,
            'price' => 2290.00,
            'retail_price' => 2290.00,
            'wholesale_price' => 850.00,
            'reseller_price' => 1450.00,
            'reseller_profit' => 1450.00,
            'moq' => 12,
            'stock_qty' => 62,
            'in_stock' => true,
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
            'name' => 'Crimson Bridal Handcrafted Zardosi Lehenga',
            'slug' => 'crimson-bridal-handcrafted-zardosi-lehenga',
            'category' => 'Bridal Lehengas',
            'fabric' => 'Velvet & Raw Silk',
            'weave' => 'Hand Zari Zardosi',
            'color' => 'Crimson Velvet Red',
            'colors' => ['Crimson Red', 'Maroon Velvet', 'Deep Ruby'],
            'size' => ['S', 'M', 'L', 'XL'],
            'mrp' => 24990.00,
            'old_price' => 24990.00,
            'price' => 16490.00,
            'retail_price' => 16490.00,
            'wholesale_price' => 11500.00,
            'reseller_price' => 13800.00,
            'reseller_profit' => 4500.00,
            'moq' => 2,
            'stock_qty' => 18,
            'in_stock' => true,
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
            'name' => 'Organza Glass Tissue Floral Zari Saree',
            'slug' => 'organza-glass-tissue-floral-zari-saree',
            'category' => 'Organza Tissue',
            'fabric' => 'Glass Tissue Organza',
            'weave' => 'Cutwork Scallop Weave',
            'color' => 'Pastel Mint & Silver',
            'colors' => ['Pastel Mint', 'Silver Frost', 'Baby Pink'],
            'size' => ['Free Size', 'M', 'L'],
            'mrp' => 4999.00,
            'old_price' => 4999.00,
            'price' => 3499.00,
            'retail_price' => 3499.00,
            'wholesale_price' => 1150.00,
            'reseller_price' => 1750.00,
            'reseller_profit' => 1750.00,
            'moq' => 8,
            'stock_qty' => 54,
            'in_stock' => true,
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
        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $rows = Database::query("SELECT * FROM products ORDER BY id ASC");
                $list = [];
                if (is_array($rows)) {
                    foreach ($rows as $r) {
                        $mrp = (float)($r['mrp'] ?? 4999.00);
                        $retail = (float)($r['retail_price'] ?? ($mrp * 0.75));
                        $wholesale = (float)($r['wholesale_price'] ?? ($retail * 0.4));
                        $reseller = (float)($r['reseller_price'] ?? ($retail * 0.7));
                        $pid = (int)$r['id'];

                        $img = !empty($r['primary_image']) ? trim($r['primary_image']) : '';
                        if (empty($img) || $img === 'null' || $img === 'undefined') {
                            $img = '/Frontend/Shop/Asset/images/product' . ((($pid - 1) % 8) + 1) . '.png';
                        } elseif (strpos($img, '/') !== 0 && strpos($img, 'http') !== 0) {
                            $img = '/' . $img;
                        }

                        $gallery = [$img];
                        $gallery[] = '/Frontend/Shop/Asset/images/product' . ((($pid) % 8) + 1) . '.png';
                        $gallery[] = '/Frontend/Shop/Asset/images/product' . ((($pid + 1) % 8) + 1) . '.png';

                        $list[] = [
                            'id' => $pid,
                            'sku' => $r['sku'] ?? ('KLN-SR-' . (100 + $pid)),
                            'title' => $r['title'] ?? 'Luxury Handcrafted Ethnic Saree',
                            'name' => $r['title'] ?? 'Luxury Handcrafted Ethnic Saree',
                            'slug' => $r['slug'] ?? ('product-' . $pid),
                            'category' => $r['category_name'] ?? 'Kanjivaram Silk',
                            'fabric' => $r['fabric'] ?? 'Pure Mulberry Silk',
                            'weave' => $r['weave'] ?? 'Handloom Korvai Weave',
                            'color' => $r['color'] ?? 'Royal Silk',
                            'colors' => ['Crimson Red', 'Navy Blue', 'Antique Gold'],
                            'size' => ['Free Size', 'M', 'L'],
                            'mrp' => $mrp,
                            'old_price' => $mrp,
                            'price' => $retail,
                            'retail_price' => $retail,
                            'wholesale_price' => $wholesale,
                            'reseller_price' => $reseller,
                            'reseller_profit' => ($reseller - $wholesale),
                            'moq' => (int)($r['moq_full_set'] ?? 8),
                            'stock_qty' => (int)($r['stock_qty'] ?? 50),
                            'in_stock' => (int)($r['stock_qty'] ?? 50) > 0,
                            'status' => $r['status'] ?? 'in_stock',
                            'rating' => (float)($r['rating'] ?? 4.9),
                            'reviews_count' => (int)($r['reviews_count'] ?? 85),
                            'badge' => !empty($r['badge']) ? $r['badge'] : 'Bestseller',
                            'image' => $img,
                            'gallery' => $gallery,
                            'description' => $r['description'] ?? 'Authentic handwoven pure silk saree with pure tested gold zari weaves.',
                            'moq_lots' => [
                                'single' => (int)($r['moq_single'] ?? 1),
                                'half_set' => (int)($r['moq_half_set'] ?? 4),
                                'full_set' => (int)($r['moq_full_set'] ?? 8),
                                'master_bale' => (int)($r['moq_master_bale'] ?? 24)
                            ]
                        ];
                    }
                    if (!empty($list)) {
                        return $list;
                    }
                }
            } catch (\Exception $e) {
                // fall through
            }
        }
        return self::$products;
    }

    public static function getById(int $id): ?array
    {
        $all = self::getAll();
        foreach ($all as $product) {
            if ($product['id'] === $id) {
                return $product;
            }
        }
        return null;
    }

    public static function getBySku(string $sku): ?array
    {
        $all = self::getAll();
        foreach ($all as $product) {
            if (strcasecmp($product['sku'], $sku) === 0) {
                return $product;
            }
        }
        return null;
    }

    public static function getCategories(): array
    {
        $categories = [];
        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                $rows = Database::query("SELECT name FROM categories WHERE status = 'active' ORDER BY display_order ASC");
                if (!empty($rows)) {
                    foreach ($rows as $r) {
                        if (!empty($r['name'])) {
                            $categories[] = trim($r['name']);
                        }
                    }
                }

                $pRows = Database::query("SELECT DISTINCT category_name FROM products WHERE status != 'trash' AND category_name IS NOT NULL AND category_name != ''");
                if (!empty($pRows)) {
                    foreach ($pRows as $pr) {
                        $cName = trim($pr['category_name']);
                        if (!empty($cName) && !in_array($cName, $categories, true)) {
                            $categories[] = $cName;
                        }
                    }
                }

                if (!empty($categories)) {
                    return array_values(array_unique(array_filter($categories)));
                }
            } catch (\Exception $e) {}
        }

        $all = self::getAll();
        foreach ($all as $product) {
            if (!empty($product['category']) && !in_array($product['category'], $categories, true)) {
                $categories[] = $product['category'];
            }
        }
        return array_values(array_unique(array_filter($categories)));
    }

    public static function getCategoriesWithDetails(): array
    {
        $categories = [];
        $db = Database::getConnection();
        if ($db !== null && !Database::isMockMode()) {
            try {
                $rows = Database::query("SELECT id, name, slug, description, image, products_count FROM categories WHERE status = 'active' ORDER BY display_order ASC, id ASC");
                if (!empty($rows)) {
                    foreach ($rows as $i => $r) {
                        $img = !empty($r['image']) ? $r['image'] : ('/Frontend/Shop/Asset/images/product' . (($i % 6) + 1) . '.png');
                        $categories[] = [
                            'id' => (int)$r['id'],
                            'name' => trim($r['name']),
                            'slug' => trim($r['slug'] ?? ''),
                            'image' => $img,
                            'products_count' => (int)($r['products_count'] ?? 0)
                        ];
                    }
                }
            } catch (\Exception $e) {}
        }
        if (empty($categories)) {
            $catNames = self::getCategories();
            foreach ($catNames as $i => $name) {
                $categories[] = [
                    'id' => $i + 1,
                    'name' => $name,
                    'slug' => strtolower(str_replace(' ', '-', $name)),
                    'image' => '/Frontend/Shop/Asset/images/product' . (($i % 6) + 1) . '.png',
                    'products_count' => 0
                ];
            }
        }
        return $categories;
    }

    /**
     * Get real recommended products
     */
    public static function getRecommendations(int $currentProductId = 0, int $limit = 4): array
    {
        $all = self::getAll();
        $recommended = array_filter($all, function($p) use ($currentProductId) {
            return $p['id'] !== $currentProductId;
        });
        return array_slice(array_values($recommended), 0, $limit);
    }

    public static function filter(array $criteria = []): array
    {
        $all = self::getAll();
        return array_values(array_filter($all, function ($product) use ($criteria) {
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
