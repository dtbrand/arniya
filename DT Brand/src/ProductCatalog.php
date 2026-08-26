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
                            $img = '/assets/images/product' . ((($pid - 1) % 8) + 1) . '.png';
                        } elseif (strpos($img, '/') !== 0 && strpos($img, 'http') !== 0) {
                            $img = '/' . $img;
                        }

                        $gallery = [$img];
                        $gallery[] = '/assets/images/product' . ((($pid) % 8) + 1) . '.png';
                        $gallery[] = '/assets/images/product' . ((($pid + 1) % 8) + 1) . '.png';

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
                $rows = Database::query("SELECT name FROM categories WHERE status = 'active' ORDER BY display_order ASC, id ASC");
                if (!empty($rows)) {
                    foreach ($rows as $r) {
                        if (!empty($r['name'])) {
                            $categories[] = trim($r['name']);
                        }
                    }
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
                        $img = !empty($r['image']) ? $r['image'] : ('/assets/images/product' . (($i % 6) + 1) . '.png');
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
                    'image' => '/assets/images/product' . (($i % 6) + 1) . '.png',
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

    /**
     * Create new product in MySQL database
     */
    public static function create(array $data): array
    {
        $title = trim($data['title'] ?? $data['name'] ?? '');
        if (empty($title)) {
            return ['success' => false, 'message' => 'Product title is required.'];
        }

        $slug = trim($data['slug'] ?? '');
        if (empty($slug)) {
            $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $title));
            $slug = trim($slug, '-');
        }

        $sku = trim($data['sku'] ?? '');
        if (empty($sku)) {
            $sku = 'DT-' . strtoupper(substr(uniqid(), -6));
        }

        $mrp = (float)($data['mrp'] ?? 6500.0);
        $retail = (float)($data['retail_price'] ?? $data['price'] ?? 4899.0);
        $wholesale = (float)($data['wholesale_price'] ?? 1399.0);
        $reseller = (float)($data['reseller_price'] ?? ($retail * 0.70));
        $stock = (int)($data['stock_qty'] ?? 50);
        $catName = trim($data['category'] ?? $data['category_name'] ?? 'Silk Sarees');
        $fabric = trim($data['fabric'] ?? 'Pure Silk');
        $weave = trim($data['weave'] ?? 'Handloom Korvai');
        $desc = trim($data['description'] ?? '');
        $img = trim($data['primary_image'] ?? $data['image'] ?? '/assets/images/product1.png');
        $status = in_array($data['status'] ?? '', ['in_stock', 'low_stock', 'out_of_stock', 'draft']) ? $data['status'] : 'in_stock';

        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                // Ensure unique SKU
                $chk = $pdo->prepare("SELECT id FROM products WHERE sku = ? LIMIT 1");
                $chk->execute([$sku]);
                if ($chk->fetch()) {
                    $sku .= '-' . rand(10, 99);
                }

                // Ensure unique Slug
                $chkSlug = $pdo->prepare("SELECT id FROM products WHERE slug = ? LIMIT 1");
                $chkSlug->execute([$slug]);
                if ($chkSlug->fetch()) {
                    $slug .= '-' . rand(100, 999);
                }

                $stmt = $pdo->prepare("
                    INSERT INTO products 
                    (sku, title, slug, category_id, category_name, fabric, weave, mrp, retail_price, wholesale_price, reseller_price, stock_qty, primary_image, status, description, created_at)
                    VALUES (?, ?, ?, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
                ");
                $stmt->execute([$sku, $title, $slug, $catName, $fabric, $weave, $mrp, $retail, $wholesale, $reseller, $stock, $img, $status, $desc]);
                $newId = (int)$pdo->lastInsertId();

                return [
                    'success' => true,
                    'id' => $newId,
                    'sku' => $sku,
                    'slug' => $slug,
                    'message' => 'Product created successfully in database!'
                ];
            } catch (\Exception $e) {
                return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
            }
        }

        return [
            'success' => true,
            'id' => rand(1000, 9999),
            'sku' => $sku,
            'slug' => $slug,
            'message' => 'Product saved successfully!'
        ];
    }

    /**
     * Update existing product in MySQL database
     */
    public static function update(int $id, array $data): array
    {
        if ($id <= 0) {
            return ['success' => false, 'message' => 'Invalid product ID.'];
        }

        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $fields = [];
                $params = [];

                if (isset($data['title']) || isset($data['name'])) {
                    $fields[] = 'title = ?';
                    $params[] = trim($data['title'] ?? $data['name']);
                }
                if (isset($data['sku'])) {
                    $fields[] = 'sku = ?';
                    $params[] = trim($data['sku']);
                }
                if (isset($data['mrp'])) {
                    $fields[] = 'mrp = ?';
                    $params[] = (float)$data['mrp'];
                }
                if (isset($data['retail_price']) || isset($data['price'])) {
                    $fields[] = 'retail_price = ?';
                    $params[] = (float)($data['retail_price'] ?? $data['price']);
                }
                if (isset($data['wholesale_price'])) {
                    $fields[] = 'wholesale_price = ?';
                    $params[] = (float)$data['wholesale_price'];
                }
                if (isset($data['reseller_price'])) {
                    $fields[] = 'reseller_price = ?';
                    $params[] = (float)$data['reseller_price'];
                }
                if (isset($data['stock_qty'])) {
                    $fields[] = 'stock_qty = ?';
                    $params[] = (int)$data['stock_qty'];
                }
                if (isset($data['category']) || isset($data['category_name'])) {
                    $fields[] = 'category_name = ?';
                    $params[] = trim($data['category'] ?? $data['category_name']);
                }
                if (isset($data['fabric'])) {
                    $fields[] = 'fabric = ?';
                    $params[] = trim($data['fabric']);
                }
                if (isset($data['description'])) {
                    $fields[] = 'description = ?';
                    $params[] = trim($data['description']);
                }
                if (isset($data['primary_image']) || isset($data['image'])) {
                    $fields[] = 'primary_image = ?';
                    $params[] = trim($data['primary_image'] ?? $data['image']);
                }
                if (isset($data['status'])) {
                    $fields[] = 'status = ?';
                    $params[] = trim($data['status']);
                }

                if (empty($fields)) {
                    return ['success' => true, 'message' => 'No changes to update.'];
                }

                $params[] = $id;
                $sql = "UPDATE products SET " . implode(', ', $fields) . " WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute($params);

                return ['success' => true, 'id' => $id, 'message' => 'Product updated successfully in database!'];
            } catch (\Exception $e) {
                return ['success' => false, 'message' => 'Database update error: ' . $e->getMessage()];
            }
        }

        return ['success' => true, 'id' => $id, 'message' => 'Product updated successfully!'];
    }

    /**
     * Duplicate an existing product in MySQL database
     */
    public static function duplicate(int $id): array
    {
        if ($id <= 0) {
            return ['success' => false, 'message' => 'Invalid product ID for duplication.'];
        }

        $prod = self::getById($id);
        if (!$prod) {
            return ['success' => false, 'message' => 'Product not found.'];
        }

        $pdo = Database::getConnection();
        $newTitle = ($prod['title'] ?? 'Product') . ' (Copy)';
        $newSku = ($prod['sku'] ?? 'SKU') . '-CP' . rand(10, 99);
        $newSlug = ($prod['slug'] ?? 'product') . '-copy-' . rand(100, 999);
        $catName = $prod['category'] ?? 'Kanjivaram Silk';
        $fabric = $prod['fabric'] ?? 'Pure Mulberry Silk';
        $weave = $prod['weave'] ?? 'Handloom Korvai Weave';
        $mrp = (float)($prod['mrp'] ?? 4999);
        $retail = (float)($prod['retail_price'] ?? ($prod['price'] ?? 3999));
        $wholesale = (float)($prod['wholesale_price'] ?? 1499);
        $reseller = (float)($prod['reseller_price'] ?? 2199);
        $stock = (int)($prod['stock_qty'] ?? 50);
        $img = $prod['image'] ?? '/assets/images/product1.png';
        $desc = $prod['description'] ?? 'Authentic handwoven pure silk saree.';
        $status = 'published';

        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO products 
                    (sku, title, slug, category_id, category_name, fabric, weave, mrp, retail_price, wholesale_price, reseller_price, stock_qty, primary_image, status, description, created_at)
                    VALUES (?, ?, ?, 1, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
                ");
                $stmt->execute([$newSku, $newTitle, $newSlug, $catName, $fabric, $weave, $mrp, $retail, $wholesale, $reseller, $stock, $img, $status, $desc]);
                $newId = (int)$pdo->lastInsertId();

                return [
                    'success' => true,
                    'id' => $newId,
                    'sku' => $newSku,
                    'title' => $newTitle,
                    'message' => 'Product duplicated successfully in database!'
                ];
            } catch (\Exception $e) {
                return ['success' => false, 'message' => 'Database duplicate error: ' . $e->getMessage()];
            }
        }

        return [
            'success' => true,
            'id' => rand(1000, 9999),
            'sku' => $newSku,
            'title' => $newTitle,
            'message' => 'Product duplicated successfully!'
        ];
    }

    /**
     * Delete product permanently from database
     */
    public static function delete(int $id, bool $permanent = true): bool
    {
        if ($id <= 0) return false;

        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
                return $stmt->execute([$id]);
            } catch (\Exception $e) {
                return false;
            }
        }
        return true;
    }

    /**
     * Bulk delete products permanently
     */
    public static function bulkDelete(array $ids, bool $permanent = true): int
    {
        $validIds = array_filter(array_map('intval', $ids));
        if (empty($validIds)) return 0;

        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $placeholders = implode(',', array_fill(0, count($validIds), '?'));
                $stmt = $pdo->prepare("DELETE FROM products WHERE id IN ($placeholders)");
                $stmt->execute($validIds);
                return $stmt->rowCount();
            } catch (\Exception $e) {
                return 0;
            }
        }
        return count($validIds);
    }

    /**
     * Bulk update products
     */
    public static function bulkUpdate(array $ids, array $data): int
    {
        $validIds = array_filter(array_map('intval', $ids));
        if (empty($validIds)) return 0;

        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $fields = [];
                $params = [];

                if (!empty($data['category']) || !empty($data['category_name'])) {
                    $fields[] = 'category_name = ?';
                    $params[] = trim($data['category'] ?? $data['category_name']);
                }
                if (isset($data['stock_status'])) {
                    $fields[] = 'status = ?';
                    $params[] = trim($data['stock_status']);
                }
                if (isset($data['status'])) {
                    $fields[] = 'status = ?';
                    $params[] = trim($data['status']);
                }
                if (isset($data['wholesale_price']) && (float)$data['wholesale_price'] > 0) {
                    $fields[] = 'wholesale_price = ?';
                    $params[] = (float)$data['wholesale_price'];
                }
                if (isset($data['retail_price']) && (float)$data['retail_price'] > 0) {
                    $fields[] = 'retail_price = ?';
                    $params[] = (float)$data['retail_price'];
                }

                if (empty($fields)) return 0;

                $placeholders = implode(',', array_fill(0, count($validIds), '?'));
                $sql = "UPDATE products SET " . implode(', ', $fields) . " WHERE id IN ($placeholders)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(array_merge($params, $validIds));
                return $stmt->rowCount();
            } catch (\Exception $e) {
                return 0;
            }
        }
        return count($validIds);
    }

    /**
     * Update Product Status
     */
    public static function updateStatus(int $id, string $status): bool
    {
        if ($id <= 0) return false;
        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("UPDATE products SET status = ? WHERE id = ?");
                return $stmt->execute([$status, $id]);
            } catch (\Exception $e) {
                return false;
            }
        }
        return true;
    }

    /**
     * Category CRUD: Create
     */
    public static function createCategory(array $data): array
    {
        $name = trim($data['name'] ?? '');
        if (empty($name)) {
            return ['success' => false, 'message' => 'Category name is required.'];
        }
        $slug = trim($data['slug'] ?? strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $name)));
        $desc = trim($data['description'] ?? '');
        $img = trim($data['image'] ?? '/assets/images/product1.png');

        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO categories (name, slug, description, image, status, created_at)
                    VALUES (?, ?, ?, ?, 'active', NOW())
                ");
                $stmt->execute([$name, $slug, $desc, $img]);
                return ['success' => true, 'id' => (int)$pdo->lastInsertId(), 'message' => 'Category created successfully!'];
            } catch (\Exception $e) {
                return ['success' => false, 'message' => $e->getMessage()];
            }
        }
        return ['success' => true, 'id' => rand(10, 99), 'message' => 'Category created!'];
    }

    /**
     * Category CRUD: Delete
     */
    public static function deleteCategory(int $id): bool
    {
        if ($id <= 0) return false;
        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
                return $stmt->execute([$id]);
            } catch (\Exception $e) {
                return false;
            }
        }
        return true;
    }

    /**
     * Category CRUD: Update
     */
    public static function updateCategory(int $id, array $data): array
    {
        if ($id <= 0) return ['success' => false, 'message' => 'Invalid category ID.'];
        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $fields = [];
                $params = [];
                if (isset($data['name'])) {
                    $fields[] = 'name = ?';
                    $params[] = trim($data['name']);
                }
                if (isset($data['slug'])) {
                    $fields[] = 'slug = ?';
                    $params[] = trim($data['slug']);
                }
                if (isset($data['description'])) {
                    $fields[] = 'description = ?';
                    $params[] = trim($data['description']);
                }
                if (isset($data['image'])) {
                    $fields[] = 'image = ?';
                    $params[] = trim($data['image']);
                }
                if (empty($fields)) {
                    return ['success' => true, 'message' => 'No changes.'];
                }
                $params[] = $id;
                $stmt = $pdo->prepare("UPDATE categories SET " . implode(', ', $fields) . " WHERE id = ?");
                $stmt->execute($params);
                return ['success' => true, 'id' => $id, 'message' => 'Category updated successfully!'];
            } catch (\Exception $e) {
                return ['success' => false, 'message' => $e->getMessage()];
            }
        }
        return ['success' => true, 'id' => $id, 'message' => 'Category updated!'];
    }

    /**
     * Category CRUD: Bulk Delete
     */
    public static function bulkDeleteCategories(array $ids): int
    {
        $validIds = array_filter(array_map('intval', $ids));
        if (empty($validIds)) return 0;
        $pdo = Database::getConnection();
        if ($pdo !== null && !Database::isMockMode()) {
            try {
                $placeholders = implode(',', array_fill(0, count($validIds), '?'));
                $stmt = $pdo->prepare("DELETE FROM categories WHERE id IN ($placeholders)");
                $stmt->execute($validIds);
                return $stmt->rowCount();
            } catch (\Exception $e) {
                return 0;
            }
        }
        return count($validIds);
    }
}


