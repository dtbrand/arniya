<?php

namespace DTBrand\Tests\Unit;

use PHPUnit\Framework\TestCase;
use DTBrand\ProductCatalog;
use DTBrand\Database;
use PDO;

/**
 * ProductCatalogTest — Enterprise Unit Test Suite for DT Brand's Ethnic Saree Merchandising Engine.
 * 
 * Verifies:
 * 1. Offline empty-grid resilience (honest empty catalogue rather than fake merchandise when DB is down).
 * 2. Helper algorithms: slugify, embedUrl (YouTube/Instagram/Vimeo), colorHex & swatches.
 * 3. In-memory SQLite fixture with authentic ethnic saree rows, gallery media, variants, and reviews.
 * 4. Merchandising computations: discount %, effective customer/wholesale/reseller prices, boutique margins.
 * 5. Full set vs single piece selling types, active variant piece counting, and wholesale MOQ lot tiers.
 * 6. Category & subcategory real-count aggregation (products table as source of truth).
 * 7. Verified reviews and star histogram breakdown (5..1).
 * 8. Search, category, fabric, and price filtering.
 * 9. Product creation validation, unique SKU/slug generation, and partial field updates without gallery loss.
 */
class ProductCatalogTest extends TestCase
{
    private ?PDO $sqlitePdo = null;

    protected function setUp(): void
    {
        parent::setUp();
        ProductCatalog::invalidateCache();
        Database::setPdo(null, true);
    }

    protected function tearDown(): void
    {
        ProductCatalog::invalidateCache();
        Database::reset();
        $this->sqlitePdo = null;
        parent::tearDown();
    }

    /**
     * Build an in-memory SQLite database matching DT Brand's catalog schema.
     */
    private function createSqliteCatalog(): PDO
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // Register MySQL NOW() compatibility function
        if (method_exists($pdo, 'sqliteCreateFunction')) {
            $pdo->sqliteCreateFunction('NOW', static fn() => date('Y-m-d H:i:s'));
            $pdo->sqliteCreateFunction('now', static fn() => date('Y-m-d H:i:s'));
        }

        $pdo->exec("
            CREATE TABLE products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                sku TEXT NOT NULL,
                title TEXT NOT NULL,
                slug TEXT NOT NULL,
                category_id INTEGER DEFAULT 0,
                category_name TEXT DEFAULT '',
                fabric TEXT DEFAULT '',
                weave TEXT DEFAULT '',
                zari_type TEXT DEFAULT '',
                pallu_style TEXT DEFAULT '',
                blouse_piece TEXT DEFAULT '',
                occasion TEXT DEFAULT '',
                mrp REAL DEFAULT 0,
                retail_price REAL DEFAULT 0,
                customer_price REAL DEFAULT NULL,
                customer_sale_price REAL DEFAULT NULL,
                sale_price REAL DEFAULT 0,
                wholesale_price REAL DEFAULT 0,
                reseller_price REAL DEFAULT 0,
                moq_single INTEGER DEFAULT 1,
                moq_half_set INTEGER DEFAULT 0,
                moq_full_set INTEGER DEFAULT 0,
                moq_master_bale INTEGER DEFAULT 0,
                stock_qty INTEGER DEFAULT 0,
                rating REAL DEFAULT 0,
                reviews_count INTEGER DEFAULT 0,
                primary_image TEXT DEFAULT '',
                badge TEXT DEFAULT '',
                is_featured INTEGER DEFAULT 0,
                is_bestseller INTEGER DEFAULT 0,
                status TEXT DEFAULT 'in_stock',
                selling_type TEXT DEFAULT 'single_piece',
                description TEXT DEFAULT '',
                created_at TEXT
            );

            CREATE TABLE product_media (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                product_id INTEGER NOT NULL,
                image_url TEXT NOT NULL,
                is_primary INTEGER DEFAULT 0,
                sort_order INTEGER DEFAULT 0
            );

            CREATE TABLE product_variants (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                product_id INTEGER NOT NULL,
                color_id INTEGER DEFAULT NULL,
                color_name TEXT DEFAULT NULL,
                size_id INTEGER DEFAULT NULL,
                size_name TEXT DEFAULT NULL,
                sku TEXT DEFAULT '',
                stock_qty INTEGER DEFAULT 0,
                price REAL DEFAULT NULL,
                retail_price REAL DEFAULT NULL,
                retailer_price REAL DEFAULT NULL,
                wholesale_price REAL DEFAULT NULL,
                reseller_price REAL DEFAULT NULL,
                retail_sale_price REAL DEFAULT NULL,
                retailer_sale_price REAL DEFAULT NULL,
                wholesale_sale_price REAL DEFAULT NULL,
                reseller_sale_price REAL DEFAULT NULL,
                customer_price REAL DEFAULT NULL,
                customer_sale_price REAL DEFAULT NULL,
                full_set_retailer_price REAL DEFAULT NULL,
                full_set_wholesale_price REAL DEFAULT NULL,
                full_set_retailer_sale_price REAL DEFAULT NULL,
                full_set_wholesale_sale_price REAL DEFAULT NULL,
                selling_type TEXT DEFAULT 'single_piece',
                image TEXT DEFAULT NULL
            );

            CREATE TABLE reviews (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                product_id INTEGER NOT NULL,
                customer_name TEXT NOT NULL,
                rating INTEGER NOT NULL,
                review_title TEXT DEFAULT '',
                review_text TEXT DEFAULT '',
                verified_buyer INTEGER DEFAULT 0,
                status TEXT DEFAULT 'pending',
                created_at TEXT
            );

            CREATE TABLE categories (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                slug TEXT NOT NULL,
                description TEXT DEFAULT '',
                image TEXT DEFAULT '',
                banner_image TEXT DEFAULT '',
                display_order INTEGER DEFAULT 0,
                status TEXT DEFAULT 'active'
            );

            CREATE TABLE subcategories (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                category_id INTEGER NOT NULL,
                name TEXT NOT NULL,
                slug TEXT NOT NULL,
                description TEXT DEFAULT '',
                status TEXT DEFAULT 'active'
            );

            CREATE TABLE product_colors (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                hex_code TEXT NOT NULL,
                status TEXT DEFAULT 'active'
            );

            CREATE TABLE product_sizes (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                status TEXT DEFAULT 'active'
            );
        ");

        return $pdo;
    }

    /**
     * Seed realistic ethnic saree merchandise data into the in-memory database.
     */
    private function seedCatalog(PDO $pdo): void
    {
        // 1. Categories
        $pdo->exec("
            INSERT INTO categories (id, name, slug, display_order, status) VALUES
            (1, 'Pure Silk Sarees', 'pure-silk-sarees', 1, 'active'),
            (2, 'Banarasi Brocade', 'banarasi-brocade', 2, 'active'),
            (3, 'Chanderi Cotton', 'chanderi-cotton', 3, 'active'),
            (4, 'Archived Heritage', 'archived-heritage', 4, 'inactive');
        ");

        // 2. Subcategories
        $pdo->exec("
            INSERT INTO subcategories (id, category_id, name, slug, status) VALUES
            (1, 1, 'Kanjivaram Silk', 'kanjivaram-silk', 'active'),
            (2, 1, 'Mysore Silk', 'mysore-silk', 'active'),
            (3, 2, 'Katan Silk Banarasi', 'katan-silk-banarasi', 'active');
        ");

        // 3. Colors Palette
        $pdo->exec("
            INSERT INTO product_colors (name, hex_code, status) VALUES
            ('Royal Crimson', '#991B1B', 'active'),
            ('Peacock Blue', '#0369A1', 'active'),
            ('Mustard Gold', '#CA8A04', 'active');
        ");

        // 4. Products
        // Product 1: Kanjivaram Bridal Silk (in_stock, single_piece)
        $pdo->exec("
            INSERT INTO products (
                id, sku, title, slug, category_id, category_name, fabric, weave, zari_type,
                pallu_style, blouse_piece, occasion, mrp, retail_price, customer_price, sale_price,
                wholesale_price, reseller_price, moq_single, moq_half_set, moq_full_set, moq_master_bale,
                stock_qty, primary_image, badge, is_featured, is_bestseller, status, selling_type,
                description, created_at
            ) VALUES (
                1, 'DT-KANJI-01', 'Kanjivaram Pure Zari Bridal Saree', 'kanjivaram-pure-zari-bridal-saree',
                1, 'Pure Silk Sarees', 'Kanchipuram Silk', 'Handloom Jacquard', 'Pure Gold Zari',
                'Grand Rich Pallu', 'Unstitched 0.8m', 'Bridal & Wedding', 9999.00, 6999.00, 7499.00, 500.00,
                4800.00, 5400.00, 1, 6, 12, 60,
                35, '/assets/images/kanji-primary.jpg', 'Bestseller', 1, 1, 'in_stock', 'single_piece',
                'Authentic hand-woven pure silk saree with pure zari borders.', '2026-01-01 10:00:00'
            );
        ");

        // Product 2: Banarasi Katan Silk (low_stock, full_set)
        $pdo->exec("
            INSERT INTO products (
                id, sku, title, slug, category_id, category_name, fabric, weave, zari_type,
                pallu_style, blouse_piece, occasion, mrp, retail_price, customer_price, sale_price,
                wholesale_price, reseller_price, moq_single, moq_half_set, moq_full_set, moq_master_bale,
                stock_qty, primary_image, badge, is_featured, is_bestseller, status, selling_type,
                description, created_at
            ) VALUES (
                2, 'DT-BANAR-02', 'Banarasi Katan Floral Jaal Saree', 'banarasi-katan-floral-jaal-saree',
                2, 'Banarasi Brocade', 'Pure Katan Silk', 'Kadwa Handloom', 'Antique Silver Zari',
                'Traditional Floral Pallu', 'Running Blouse 0.8m', 'Festive & Reception', 12500.00, 8999.00, NULL, 0.00,
                6500.00, 7200.00, 1, 4, 8, 48,
                4, '/assets/images/banar-primary.jpg', 'Exclusive', 1, 0, 'low_stock', 'full_set',
                'Regal Banarasi silk masterpiece woven with intricate kadwa floral jaal.', '2026-01-02 11:00:00'
            );
        ");

        // Product 3: Chanderi Cotton Silk (draft — must NOT leak to public storefront)
        $pdo->exec("
            INSERT INTO products (
                id, sku, title, slug, category_id, category_name, fabric, weave, mrp,
                retail_price, stock_qty, status, selling_type, created_at
            ) VALUES (
                3, 'DT-CHAND-03', 'Chanderi Handloom Cotton Silk', 'chanderi-handloom-cotton-silk',
                3, 'Chanderi Cotton', 'Cotton Silk', 'Chanderi Handloom', 3500.00,
                2499.00, 20, 'draft', 'single_piece', '2026-01-03 12:00:00'
            );
        ");

        // 5. Media Gallery for Product 1 (Photos and YouTube embed)
        $pdo->exec("
            INSERT INTO product_media (product_id, image_url, is_primary, sort_order) VALUES
            (1, '/assets/images/kanji-primary.jpg', 1, 0),
            (1, '/assets/images/kanji-pallu.jpg', 0, 1),
            (1, 'https://www.youtube.com/watch?v=saree12345', 0, 2);
        ");

        // 6. Variants for Product 1 (2 colors) and Product 2 (4 set pieces)
        $pdo->exec("
            INSERT INTO product_variants (product_id, color_name, size_name, sku, stock_qty, price) VALUES
            (1, 'Royal Crimson', 'Free Size', 'DT-KANJI-01-CRIMSON', 20, 6999.00),
            (1, 'Peacock Blue', 'Free Size', 'DT-KANJI-01-BLUE', 15, 6999.00),
            (2, 'Mustard Gold', 'Free Size', 'DT-BANAR-02-GOLD', 1, 8999.00),
            (2, 'Ruby Crimson', 'Free Size', 'DT-BANAR-02-RUBY', 1, 8999.00),
            (2, 'Emerald Green', 'Free Size', 'DT-BANAR-02-GREEN', 1, 8999.00),
            (2, 'Royal Violet', 'Free Size', 'DT-BANAR-02-VIOLET', 1, 8999.00);
        ");

        // 7. Reviews for Product 1 (One 5-star, One 4-star, One pending which must not show)
        $pdo->exec("
            INSERT INTO reviews (product_id, customer_name, rating, review_title, review_text, verified_buyer, status, created_at) VALUES
            (1, 'Ananya Sharma', 5, 'Exquisite Kanjivaram!', 'The zari quality and heavy pallu are majestic.', 1, 'approved', '2026-02-01 10:00:00'),
            (1, 'Meera Patel', 4, 'Very elegant', 'Rich silk fabric, exactly as photographed.', 1, 'approved', '2026-02-02 11:00:00'),
            (1, 'Spam Reviewer', 1, 'Fake comment', 'Pending review text', 0, 'pending', '2026-02-03 12:00:00');
        ");
    }

    // ─── Offline Empty-Grid Resilience Tests ─────────────────────────────────

    public function testGetAllReturnsEmptyWhenDatabaseUnreachable(): void
    {
        Database::setPdo(null, true);
        $products = ProductCatalog::getAll();
        $this->assertIsArray($products);
        $this->assertSame([], $products);
    }

    public function testGetByIdReturnsNullWhenMissingOrOffline(): void
    {
        Database::setPdo(null, true);
        $this->assertNull(ProductCatalog::getById(1));
        $this->assertNull(ProductCatalog::getById(-5));
        $this->assertNull(ProductCatalog::getById(0));
    }

    public function testGetBySlugAndSkuReturnNullWhenOffline(): void
    {
        Database::setPdo(null, true);
        $this->assertNull(ProductCatalog::getBySlug('kanjivaram-pure-zari-bridal-saree'));
        $this->assertNull(ProductCatalog::getBySku('DT-KANJI-01'));
        $this->assertNull(ProductCatalog::getBySlug(''));
        $this->assertNull(ProductCatalog::getBySku(''));
    }

    public function testGetCategoriesReturnsEmptyWhenOffline(): void
    {
        Database::setPdo(null, true);
        $this->assertSame([], ProductCatalog::getCategories());
        $this->assertSame([], ProductCatalog::getCategoriesWithDetails());
        $this->assertSame([], ProductCatalog::getSubcategories());
    }

    public function testPublicStatusesDoNotLeakDraftsWhenOffline(): void
    {
        Database::setPdo(null, true);
        $this->assertSame([], ProductCatalog::getAll(false));
        $this->assertSame([], ProductCatalog::getAll(true));
    }

    // ─── Pure Utility & Transformation Tests ─────────────────────────────────

    public function testSlugifyGeneratesCleanAsciiSlugs(): void
    {
        $this->assertEquals('kanjivaram-pure-silk-saree', ProductCatalog::slugify('Kanjivaram Pure Silk Saree'));
        $this->assertEquals('banarasi-zari-brocade', ProductCatalog::slugify('Banarasi Zari & Brocade!'));
        $this->assertEquals('chanderi-cotton-silk-festive-2026', ProductCatalog::slugify('Chanderi Cotton Silk (Festive 2026)'));
        $this->assertEquals('', ProductCatalog::slugify(''));
        $this->assertEquals('', ProductCatalog::slugify('   ---   '));
    }

    public function testEmbedUrlConvertsSupportedSocialVideoLinks(): void
    {
        // Standard YouTube Watch Link
        $ytWatch = ProductCatalog::embedUrl('https://www.youtube.com/watch?v=dQw4w9WgXcQ');
        $this->assertEquals('https://www.youtube.com/embed/dQw4w9WgXcQ', $ytWatch);

        // YouTube Shortened URL (youtu.be)
        $ytShort = ProductCatalog::embedUrl('https://youtu.be/dQw4w9WgXcQ');
        $this->assertEquals('https://www.youtube.com/embed/dQw4w9WgXcQ', $ytShort);

        // YouTube Shorts URL
        $ytShorts = ProductCatalog::embedUrl('https://youtube.com/shorts/abcdef12345');
        $this->assertEquals('https://www.youtube.com/embed/abcdef12345', $ytShorts);

        // Instagram Reels URL
        $igReel = ProductCatalog::embedUrl('https://www.instagram.com/reel/C123456789/');
        $this->assertEquals('https://www.instagram.com/reel/C123456789/embed', $igReel);

        // Instagram Post URL
        $igPost = ProductCatalog::embedUrl('https://www.instagram.com/p/C987654321/');
        $this->assertEquals('https://www.instagram.com/p/C987654321/embed', $igPost);

        // Vimeo URL
        $vimeo = ProductCatalog::embedUrl('https://vimeo.com/12345678');
        $this->assertEquals('https://player.vimeo.com/video/12345678', $vimeo);

        // Unsupported / Invalid / Direct file URLs
        $this->assertEquals('', ProductCatalog::embedUrl('https://example.com/video.mp4'));
        $this->assertEquals('', ProductCatalog::embedUrl(''));
        $this->assertEquals('', ProductCatalog::embedUrl('invalid-url-string'));
    }

    public function testColorHexFallsBackToMasterBrandGoldWhenUnknown(): void
    {
        Database::setPdo(null, true);
        // Default brand gold fallback is #8A681F
        $this->assertEquals('#8A681F', ProductCatalog::colorHex('unknown_custom_shade'));
    }

    public function testCreateValidationsRequireTitleAndSellingPrice(): void
    {
        Database::setPdo(null, true);

        $noTitle = ProductCatalog::create(['title' => '', 'retail_price' => 5000]);
        $this->assertFalse($noTitle['success']);
        $this->assertStringContainsString('title is required', strtolower($noTitle['message']));

        $noPrice = ProductCatalog::create(['title' => 'Kanjivaram Silk', 'retail_price' => 0]);
        $this->assertFalse($noPrice['success']);
        $this->assertStringContainsString('selling price is required', strtolower($noPrice['message']));

        // Offline database guard
        $offlineCreate = ProductCatalog::create(['title' => 'Kanjivaram Silk', 'retail_price' => 5000]);
        $this->assertFalse($offlineCreate['success']);
        $this->assertStringContainsString('database is not reachable', strtolower($offlineCreate['message']));
    }

    // ─── Comprehensive In-Memory SQLite Fixture Tests ───────────────────────

    public function testGetAllFiltersDraftsAndComputesMerchandisingPricing(): void
    {
        $pdo = $this->createSqliteCatalog();
        $this->seedCatalog($pdo);
        Database::setPdo($pdo, false);

        // 1. Public storefront (includeDrafts: false) -> must return only products 1 and 2, omitting draft 3
        $publicCatalog = ProductCatalog::getAll(false);
        $this->assertCount(2, $publicCatalog, "Public catalog must omit draft products.");

        $p1 = $publicCatalog[0];
        $this->assertEquals(1, $p1['id']);
        $this->assertEquals('DT-KANJI-01', $p1['sku']);
        $this->assertEquals('Kanjivaram Pure Zari Bridal Saree', $p1['title']);
        $this->assertEquals('in_stock', $p1['status']);
        $this->assertTrue($p1['in_stock']);
        $this->assertTrue($p1['is_featured']);
        $this->assertTrue($p1['is_bestseller']);
        $this->assertEquals('Bestseller', $p1['badge']);

        // Pricing computations for Product 1:
        // MRP: 9999, Retail: 6999, Sale Discount: 500
        // Effective Trade Price = max(0, 6999 - 500) = 6499
        // Customer Price: 7499 -> Effective Customer Price = max(0, 7499 - 500) = 6999
        // Effective Wholesale Price = max(0, 4800 - 500) = 4300
        // Effective Reseller Price = max(0, 5400 - 500) = 4900
        // Boutique Margin = Effective Customer (6999) - Effective Trade (6499) = 500
        $this->assertEquals(9999.0, $p1['mrp']);
        $this->assertEquals(6999.0, $p1['retail_price']);
        $this->assertEquals(500.0, $p1['sale_price']);
        $this->assertEquals(6499.0, $p1['effective_price']);
        $this->assertEquals(6999.0, $p1['effective_customer_price']);
        $this->assertEquals(4300.0, $p1['effective_wholesale_price']);
        $this->assertEquals(4900.0, $p1['effective_reseller_price']);
        $this->assertEquals(500.0, $p1['boutique_margin']);

        // MRP Discount %: round(((9999 - 6999) / 9999) * 100) = 30%
        $this->assertEquals(30, $p1['discount']);

        // MOQ Lots structure
        $this->assertEquals(1, $p1['moq_lots']['single']);
        $this->assertEquals(6, $p1['moq_lots']['half_set']);
        $this->assertEquals(12, $p1['moq_lots']['full_set']);
        $this->assertEquals(60, $p1['moq_lots']['master_bale']);

        // Selling Type
        $this->assertEquals('single_piece', $p1['selling_type']);
        $this->assertTrue($p1['is_single_piece']);
        $this->assertFalse($p1['is_full_set']);

        // 2. Admin catalog (includeDrafts: true) -> must return all 3 products including draft
        ProductCatalog::invalidateCache();
        $adminCatalog = ProductCatalog::getAll(true);
        $this->assertCount(3, $adminCatalog, "Admin catalog must include drafts.");
        $this->assertEquals('draft', $adminCatalog[2]['status']);
    }

    public function testGetByIdResolvesGalleryVariantsAndReviewStats(): void
    {
        $pdo = $this->createSqliteCatalog();
        $this->seedCatalog($pdo);
        Database::setPdo($pdo, false);

        $product = ProductCatalog::getById(1);
        $this->assertNotNull($product);

        // Media Gallery
        $this->assertTrue($product['has_photo']);
        $this->assertCount(2, $product['images']);
        $this->assertEquals('/assets/images/kanji-primary.jpg', $product['image']);
        $this->assertEquals('/assets/images/kanji-primary.jpg', $product['images'][0]);
        $this->assertEquals('/assets/images/kanji-pallu.jpg', $product['images'][1]);

        // Video embed resolution (YouTube embed URL)
        $this->assertTrue($product['has_video']);
        $this->assertCount(1, $product['embeds']);
        $this->assertEquals('https://www.youtube.com/embed/saree12345', $product['embed']);

        // Variants Matrix
        $this->assertCount(2, $product['variants']);
        $this->assertEquals(['Royal Crimson', 'Peacock Blue'], $product['colors']);
        $this->assertEquals(['Free Size'], $product['sizes']);

        // Approved Reviews & Rating calculation
        // Review 1: 5 stars, Review 2: 4 stars. (Pending review ignored)
        // Count: 2, Average: 4.5
        $this->assertEquals(2, $product['reviews_count']);
        $this->assertEquals(4.5, $product['rating']);
    }

    public function testFullSetSellingTypeAndVariantPieceCount(): void
    {
        $pdo = $this->createSqliteCatalog();
        $this->seedCatalog($pdo);
        Database::setPdo($pdo, false);

        // Product 2: Banarasi Katan (selling_type = full_set)
        $p2 = ProductCatalog::getById(2);
        $this->assertNotNull($p2);

        $this->assertEquals('full_set', $p2['selling_type']);
        $this->assertTrue($p2['is_full_set']);
        $this->assertFalse($p2['is_single_piece']);
        $this->assertEquals(4, $p2['full_set_pieces']);
        $this->assertCount(4, $p2['full_set_variants']);
    }

    public function testGetBySlugAndGetBySkuWithDatabase(): void
    {
        $pdo = $this->createSqliteCatalog();
        $this->seedCatalog($pdo);
        Database::setPdo($pdo, false);

        $bySlug = ProductCatalog::getBySlug('kanjivaram-pure-zari-bridal-saree');
        $this->assertNotNull($bySlug);
        $this->assertEquals(1, $bySlug['id']);

        $bySku = ProductCatalog::getBySku('DT-KANJI-01');
        $this->assertNotNull($bySku);
        $this->assertEquals(1, $bySku['id']);

        $missingSlug = ProductCatalog::getBySlug('non-existent-saree-slug');
        $this->assertNull($missingSlug);

        $missingSku = ProductCatalog::getBySku('DT-NOT-FOUND-999');
        $this->assertNull($missingSku);
    }

    public function testGetCategoriesWithDetailsCalculatesRealProductCounts(): void
    {
        $pdo = $this->createSqliteCatalog();
        $this->seedCatalog($pdo);
        Database::setPdo($pdo, false);

        $categories = ProductCatalog::getCategoriesWithDetails(true);
        $this->assertIsArray($categories);
        // Only active categories returned (3 active, 1 inactive)
        $this->assertCount(3, $categories);

        // Category 1: Pure Silk Sarees has Product 1 (in_stock) -> count = 1
        $this->assertEquals('Pure Silk Sarees', $categories[0]['name']);
        $this->assertEquals(1, $categories[0]['products_count']);

        // Category 2: Banarasi Brocade has Product 2 (low_stock) -> count = 1
        $this->assertEquals('Banarasi Brocade', $categories[1]['name']);
        $this->assertEquals(1, $categories[1]['products_count']);

        // Category 3: Chanderi Cotton has Product 3 (draft -> excluded from public statuses) -> count = 0
        $this->assertEquals('Chanderi Cotton', $categories[2]['name']);
        $this->assertEquals(0, $categories[2]['products_count']);
    }

    public function testGetSubcategoriesFiltersCorrectly(): void
    {
        $pdo = $this->createSqliteCatalog();
        $this->seedCatalog($pdo);
        Database::setPdo($pdo, false);

        // All active subcategories
        $allSubs = ProductCatalog::getSubcategories();
        $this->assertCount(3, $allSubs);

        // Filtered by Category 1 (Pure Silk)
        $silkSubs = ProductCatalog::getSubcategories(1);
        $this->assertCount(2, $silkSubs);
        $this->assertEquals('Kanjivaram Silk', $silkSubs[0]['name']);
        $this->assertEquals('Mysore Silk', $silkSubs[1]['name']);

        // Filtered by Category 2 (Banarasi)
        $banarSubs = ProductCatalog::getSubcategories(2);
        $this->assertCount(1, $banarSubs);
        $this->assertEquals('Katan Silk Banarasi', $banarSubs[0]['name']);
    }

    public function testGetReviewsAndReviewBreakdown(): void
    {
        $pdo = $this->createSqliteCatalog();
        $this->seedCatalog($pdo);
        Database::setPdo($pdo, false);

        // Product 1 has 2 approved reviews
        $reviews = ProductCatalog::getReviews(1);
        $this->assertCount(2, $reviews);
        $this->assertEquals('Meera Patel', $reviews[0]['name']); // Newest first
        $this->assertEquals(4, $reviews[0]['rating']);
        $this->assertEquals('Ananya Sharma', $reviews[1]['name']);
        $this->assertEquals(5, $reviews[1]['rating']);
        $this->assertTrue($reviews[1]['verified']);

        // Star breakdown: 5-star = 1, 4-star = 1, others = 0
        $breakdown = ProductCatalog::reviewBreakdown(1);
        $this->assertEquals(1, $breakdown[5]);
        $this->assertEquals(1, $breakdown[4]);
        $this->assertEquals(0, $breakdown[3]);
        $this->assertEquals(0, $breakdown[2]);
        $this->assertEquals(0, $breakdown[1]);
    }

    public function testColorSwatchesAndColorHex(): void
    {
        $pdo = $this->createSqliteCatalog();
        $this->seedCatalog($pdo);
        Database::setPdo($pdo, false);

        $swatches = ProductCatalog::colorSwatches();
        $this->assertArrayHasKey('royal crimson', $swatches);
        $this->assertEquals('#991B1B', $swatches['royal crimson']);
        $this->assertArrayHasKey('peacock blue', $swatches);
        $this->assertEquals('#0369A1', $swatches['peacock blue']);

        // Exact match
        $this->assertEquals('#991B1B', ProductCatalog::colorHex('Royal Crimson'));
        $this->assertEquals('#0369A1', ProductCatalog::colorHex('peacock blue'));

        // Fallback gold for unknown color
        $this->assertEquals('#8A681F', ProductCatalog::colorHex('Unknown Magenta'));
    }

    public function testFilterByCriteriaAndSearch(): void
    {
        $pdo = $this->createSqliteCatalog();
        $this->seedCatalog($pdo);
        Database::setPdo($pdo, false);

        // Filter by category
        $silkOnly = ProductCatalog::filter(['category' => 'Pure Silk Sarees']);
        $this->assertCount(1, $silkOnly);
        $this->assertEquals('DT-KANJI-01', $silkOnly[0]['sku']);

        // Filter by fabric
        $katanOnly = ProductCatalog::filter(['fabric' => 'Pure Katan Silk']);
        $this->assertCount(1, $katanOnly);
        $this->assertEquals('DT-BANAR-02', $katanOnly[0]['sku']);

        // Filter by price range
        $under7000 = ProductCatalog::filter(['max_price' => 7000]);
        $this->assertCount(1, $under7000);
        $this->assertEquals('DT-KANJI-01', $under7000[0]['sku']);

        // Search term across title
        $searchJaal = ProductCatalog::filter(['search' => 'Jaal']);
        $this->assertCount(1, $searchJaal);
        $this->assertEquals('DT-BANAR-02', $searchJaal[0]['sku']);

        // Search term across SKU
        $searchSku = ProductCatalog::filter(['search' => 'KANJI']);
        $this->assertCount(1, $searchSku);
        $this->assertEquals('DT-KANJI-01', $searchSku[0]['sku']);
    }

    public function testGetRecommendationsExcludesCurrentProduct(): void
    {
        $pdo = $this->createSqliteCatalog();
        $this->seedCatalog($pdo);
        Database::setPdo($pdo, false);

        $recs = ProductCatalog::getRecommendations(1, 4);
        $this->assertCount(1, $recs);
        $this->assertEquals(2, $recs[0]['id']);

        $recsNone = ProductCatalog::getRecommendations(2, 4);
        $this->assertCount(1, $recsNone);
        $this->assertEquals(1, $recsNone[0]['id']);
    }

    public function testCreateProductWithVariantsAndMedia(): void
    {
        $pdo = $this->createSqliteCatalog();
        $this->seedCatalog($pdo);
        Database::setPdo($pdo, false);

        $payload = [
            'title' => 'Paithani Pure Silk Peacock Saree',
            'category_id' => 1,
            'retail_price' => 8499.00,
            'mrp' => 11999.00,
            'wholesale_price' => 5999.00,
            'reseller_price' => 6999.00,
            'fabric' => 'Paithani Silk',
            'stock_qty' => 15,
            'selling_type' => 'single_piece',
            'primary_image' => '/assets/images/paithani-1.jpg',
            'gallery' => ['/assets/images/paithani-1.jpg', '/assets/images/paithani-2.jpg'],
            'variants' => [
                ['color' => 'Mustard Gold', 'size' => 'Free Size', 'stock_qty' => 10, 'hex' => '#CA8A04'],
                ['color' => 'Royal Crimson', 'size' => 'Free Size', 'stock_qty' => 5, 'hex' => '#991B1B']
            ]
        ];

        $res = ProductCatalog::create($payload);
        $this->assertTrue($res['success']);
        $this->assertGreaterThan(0, $res['id']);
        $this->assertNotEmpty($res['sku']);
        $this->assertNotEmpty($res['slug']);
        $this->assertEquals(2, $res['photos']);
        $this->assertEquals(2, $res['variants']);

        // Verify product can be retrieved
        $created = ProductCatalog::getById((int)$res['id']);
        $this->assertNotNull($created);
        $this->assertEquals('Paithani Pure Silk Peacock Saree', $created['title']);
        $this->assertEquals(8499.0, $created['retail_price']);
        $this->assertEquals(15, $created['stock_qty']);
        $this->assertCount(2, $created['images']);
        $this->assertCount(2, $created['variants']);
    }

    public function testUpdateProductPreservesExistingMediaWhenOmitted(): void
    {
        $pdo = $this->createSqliteCatalog();
        $this->seedCatalog($pdo);
        Database::setPdo($pdo, false);

        // Update only title and stock_qty without providing media or variants key
        $updateRes = ProductCatalog::update(1, [
            'title' => 'Kanjivaram Pure Zari Bridal Saree (Updated)',
            'stock_qty' => 50
        ]);

        $this->assertTrue($updateRes['success']);

        $updated = ProductCatalog::getById(1);
        $this->assertNotNull($updated);
        $this->assertEquals('Kanjivaram Pure Zari Bridal Saree (Updated)', $updated['title']);
        $this->assertEquals(50, $updated['stock_qty']);

        // Existing media gallery must be preserved!
        $this->assertCount(2, $updated['images']);
        $this->assertEquals('/assets/images/kanji-primary.jpg', $updated['images'][0]);
    }
}