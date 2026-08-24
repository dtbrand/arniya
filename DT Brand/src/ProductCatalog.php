<?php

namespace DTBrand;

require_once __DIR__ . '/Database.php';

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
            'reseller_profit' => 701.00,
            'discount' => 25,
            'moq' => 8,
            'stock_qty' => 95,
            'in_stock' => true,
            'status' => 'in_stock',
            'rating' => 4.9,
            'reviews_count' => 142,
            'badge' => 'Bestseller',
            'image' => '/assets/images/product1.png',
            'gallery' => [
                '/assets/images/product1.png',
                '/assets/images/product1.webp',
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
            'reseller_price' => 3800.00,
            'reseller_profit' => 1301.00,
            'discount' => 23,
            'moq' => 8,
            'stock_qty' => 60,
            'in_stock' => true,
            'status' => 'in_stock',
            'rating' => 4.9,
            'reviews_count' => 218,
            'badge' => 'Exclusive',
            'image' => '/assets/images/product2.png',
            'gallery' => [
                '/assets/images/product2.png',
                '/assets/images/product2.webp',
            ],
            'description' => 'Royal Banarasi pure silk saree with handcrafted kadwa meenakari motifs and rich gold zari weave.',
            'moq_lots' => ['single' => 1, 'half_set' => 4, 'full_set' => 8, 'master_bale' => 24]
        ],
        [
            'id' => 3,
            'sku' => 'PTH-SR-308',
            'title' => 'Maharani Paithani Pure Silk Saree',
            'name' => 'Maharani Paithani Pure Silk Saree',
            'slug' => 'maharani-paithani-pure-silk-saree',
            'category' => 'Paithani',
            'fabric' => 'Fine Mulberry Silk',
            'weave' => 'Yeola Handloom Weave',
            'color' => 'Deep Wine & Pure Gold',
            'colors' => ['Purple', 'Wine', 'Magenta'],
            'size' => ['Free Size', 'M', 'L', 'XL'],
            'mrp' => 16500.00,
            'old_price' => 16500.00,
            'price' => 12999.00,
            'retail_price' => 12999.00,
            'wholesale_price' => 3999.00,
            'reseller_price' => 5800.00,
            'reseller_profit' => 1801.00,
            'discount' => 21,
            'moq' => 4,
            'stock_qty' => 40,
            'in_stock' => true,
            'status' => 'in_stock',
            'rating' => 5.0,
            'reviews_count' => 96,
            'badge' => 'Heritage',
            'image' => '/assets/images/product3.png',
            'gallery' => [
                '/assets/images/product3.png',
                '/assets/images/product3.webp',
            ],
            'description' => 'Authentic Yeola Paithani pure silk saree with traditional peacock motif pallu and rich zari border.',
            'moq_lots' => ['single' => 1, 'half_set' => 4, 'full_set' => 8, 'master_bale' => 24]
        ],
        [
            'id' => 4,
            'sku' => 'DKR-KT-412',
            'title' => 'Surat Designer Embroidered Anarkali Kurti',
            'name' => 'Surat Designer Embroidered Anarkali Kurti',
            'slug' => 'surat-designer-embroidered-anarkali-kurti',
            'category' => 'Designer Kurtis',
            'fabric' => 'Pure Chanderi Silk & Mulmul Lining',
            'weave' => 'Machine & Hand Zardozi Embroidery',
            'color' => 'Mustard Yellow & Gold',
            'colors' => ['Mustard', 'Dusty Rose', 'Sky Blue'],
            'size' => ['S', 'M', 'L', 'XL', 'XXL'],
            'mrp' => 3999.00,
            'old_price' => 3999.00,
            'price' => 2899.00,
            'retail_price' => 2899.00,
            'wholesale_price' => 850.00,
            'reseller_price' => 1250.00,
            'reseller_profit' => 400.00,
            'discount' => 28,
            'moq' => 12,
            'stock_qty' => 110,
            'in_stock' => true,
            'status' => 'in_stock',
            'rating' => 4.8,
            'reviews_count' => 164,
            'badge' => 'Trending',
            'image' => '/assets/images/product5.png',
            'gallery' => [
                '/assets/images/product5.png',
                '/assets/images/product5.webp',
            ],
            'description' => 'Designer 3-piece Chanderi silk Anarkali Kurti set with intricate gota patti and sequin work.',
            'moq_lots' => ['single' => 1, 'half_set' => 4, 'full_set' => 8, 'master_bale' => 24]
        ],
        [
            'id' => 5,
            'sku' => 'ORG-SR-515',
            'title' => 'Pastel Organza Scallop Embroidered Saree',
            'name' => 'Pastel Organza Scallop Embroidered Saree',
            'slug' => 'pastel-organza-scallop-embroidered-saree',
            'category' => 'Organza Sarees',
            'fabric' => 'Pure Glass Organza Silk',
            'weave' => 'Computerised & Hand Scalloped Embroidery',
            'color' => 'Pastel Peach & Pearl Zari',
            'colors' => ['Peach', 'Mint Green', 'Powder Blue'],
            'size' => ['Free Size', 'M', 'L'],
            'mrp' => 5500.00,
            'old_price' => 5500.00,
            'price' => 3999.00,
            'retail_price' => 3999.00,
            'wholesale_price' => 1199.00,
            'reseller_price' => 1750.00,
            'reseller_profit' => 551.00,
            'discount' => 27,
            'moq' => 8,
            'stock_qty' => 75,
            'in_stock' => true,
            'status' => 'in_stock',
            'rating' => 4.7,
            'reviews_count' => 88,
            'badge' => 'New Arrival',
            'image' => '/assets/images/product4.png',
            'gallery' => [
                '/assets/images/product4.png',
                '/assets/images/product4.webp',
            ],
            'description' => 'Lightweight pure glass organza saree featuring delicate floral cutwork and scalloped gold borders.',
            'moq_lots' => ['single' => 1, 'half_set' => 4, 'full_set' => 8, 'master_bale' => 24]
        ],
        [
            'id' => 6,
            'sku' => 'GGT-SR-620',
            'title' => 'Surat Viscose Georgette Bandhani Saree',
            'name' => 'Surat Viscose Georgette Bandhani Saree',
            'slug' => 'surat-viscose-georgette-bandhani-saree',
            'category' => 'Georgette & Chiffon',
            'fabric' => 'Pure 60-Gram Viscose Georgette',
            'weave' => 'Kutch Traditional Hand Bandhej & Gota Patti',
            'color' => 'Royal Peacock Green & Red',
            'colors' => ['Green', 'Red', 'Yellow'],
            'size' => ['Free Size', 'S', 'M', 'L'],
            'mrp' => 4800.00,
            'old_price' => 4800.00,
            'price' => 3499.00,
            'retail_price' => 3499.00,
            'wholesale_price' => 1050.00,
            'reseller_price' => 1550.00,
            'reseller_profit' => 500.00,
            'discount' => 27,
            'moq' => 8,
            'stock_qty' => 85,
            'in_stock' => true,
            'status' => 'in_stock',
            'rating' => 4.9,
            'reviews_count' => 105,
            'badge' => 'Hot Seller',
            'image' => '/assets/images/product8.png',
            'gallery' => [
                '/assets/images/product8.png',
                '/assets/images/product8.webp',
            ],
            'description' => 'Pure 60-gram georgette saree crafted with authentic Bandhej dots and shimmering hand-stitched gota patti.',
            'moq_lots' => ['single' => 1, 'half_set' => 4, 'full_set' => 8, 'master_bale' => 24]
        ],
        [
            'id' => 7,
            'sku' => 'KN-SAR-007',
            'title' => 'Mustard Hand Block Print Mulmul Saree',
            'name' => 'Mustard Hand Block Print Mulmul Saree',
            'slug' => 'mustard-hand-block-print-mulmul-saree',
            'category' => 'Cotton',
            'fabric' => '100% Breathable Mulmul Cotton',
            'weave' => 'Bagru Dabu Hand Block Printed',
            'color' => 'Mustard Yellow & Rust Red',
            'colors' => ['Mustard', 'Indigo', 'Rust Gold'],
            'size' => ['Free Size', 'M'],
            'mrp' => 2600.00,
            'old_price' => 2600.00,
            'price' => 1899.00,
            'retail_price' => 1899.00,
            'wholesale_price' => 599.00,
            'reseller_price' => 899.00,
            'reseller_profit' => 300.00,
            'discount' => 27,
            'moq' => 12,
            'stock_qty' => 130,
            'in_stock' => true,
            'status' => 'in_stock',
            'rating' => 4.6,
            'reviews_count' => 56,
            'badge' => 'Summer Edit',
            'image' => '/assets/images/product7.png',
            'gallery' => [
                '/assets/images/product7.png',
                '/assets/images/product7.webp',
            ],
            'description' => 'Airy hand block printed pure mulmul cotton saree using natural vegetable dyes for all-day comfort.',
            'moq_lots' => ['single' => 1, 'half_set' => 4, 'full_set' => 8, 'master_bale' => 24]
        ],
        [
            'id' => 8,
            'sku' => 'KN-LEH-006',
            'title' => 'Velvet Zardozi Bridal Couture Lehenga',
            'name' => 'Velvet Zardozi Bridal Couture Lehenga',
            'slug' => 'velvet-zardozi-bridal-couture-lehenga',
            'category' => 'Saree',
            'fabric' => 'Micro Velvet & Net Flared Base',
            'weave' => 'Dabka, Nakshi & Zardozi Hand Embroidery',
            'color' => 'Deep Crimson Red & Antique Bullion Gold',
            'colors' => ['Crimson Red', 'Maroon', 'Ruby'],
            'size' => ['S', 'M', 'L', 'XL'],
            'mrp' => 32000.00,
            'old_price' => 32000.00,
            'price' => 24999.00,
            'retail_price' => 24999.00,
            'wholesale_price' => 7999.00,
            'reseller_price' => 11500.00,
            'reseller_profit' => 3501.00,
            'discount' => 22,
            'moq' => 2,
            'stock_qty' => 25,
            'in_stock' => true,
            'status' => 'in_stock',
            'rating' => 5.0,
            'reviews_count' => 310,
            'badge' => 'Bridal Couture',
            'image' => '/assets/images/product6.png',
            'gallery' => [
                '/assets/images/product6.png',
                '/assets/images/product6.webp',
            ],
            'description' => 'Royal bridal velvet lehenga with over 180 hours of hand-embroidered dabka, nakshi, and zardozi detailing.',
            'moq_lots' => ['single' => 1, 'half_set' => 4, 'full_set' => 8, 'master_bale' => 24]
        ]
    ];

    public static function getAll(): array
    {
        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $rows = Database::query("SELECT * FROM products WHERE status != 'trash' ORDER BY id ASC");
                $list = [];
                if (is_array($rows) && !empty($rows)) {
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

                        $disc = $mrp > 0 ? (int)round((($mrp - $retail) / $mrp) * 100) : 0;

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
                            'discount' => $disc,
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
            if ((int)$product['id'] === $id) {
                return $product;
            }
        }
        return null;
    }

    public static function getBySlug(string $slug): ?array
    {
        $slug = trim(strtolower($slug));
        $all = self::getAll();
        foreach ($all as $product) {
            if (isset($product['slug']) && strtolower($product['slug']) === $slug) {
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
                            'slug' => trim($r['slug'] ?? strtolower(str_replace(' ', '-', $r['name']))),
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

    public static function getRecommendations(int $currentProductId = 0, int $limit = 4): array
    {
        $all = self::getAll();
        $recommended = array_filter($all, function($p) use ($currentProductId) {
            return (int)$p['id'] !== $currentProductId;
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
            if (!empty($criteria['min_price']) && $product['retail_price'] < (float)$criteria['min_price']) {
                return false;
            }
            if (!empty($criteria['search'])) {
                $term = strtolower($criteria['search']);
                $title = strtolower($product['title']);
                $sku = strtolower($product['sku']);
                $cat = strtolower($product['category']);
                if (strpos($title, $term) === false && strpos($sku, $term) === false && strpos($cat, $term) === false) {
                    return false;
                }
            }
            return true;
        }));
    }
}
