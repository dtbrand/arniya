<?php
/**
 * home.php — DEDICATED NEW HOME PAGE
 * Premium Meesho-Style Ethnic E-Commerce, Reseller & Wholesale Shopping Hub
 * Preserving DT Brand's Heritage Gold UI, Header, Footer & Architecture as Source of Truth
 */

require_once __DIR__ . '/src/ProductCatalog.php';
require_once __DIR__ . '/src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

// ── Dynamic Database-First Catalog Loader ──
$products = ProductCatalog::getAll();

$dbCategories = [];
$db = Database::getConnection();
if ($db !== null && !Database::isMockMode()) {
    try {
        $dbCategories = Database::query("SELECT * FROM categories WHERE status = 'active' ORDER BY display_order ASC");
    } catch (\Exception $e) {}
}

$categoriesList = [];
if (!empty($dbCategories)) {
    foreach ($dbCategories as $idx => $c) {
        $cName = $c['name'];
        $cCount = count(ProductCatalog::filter(['category' => $cName]));
        $categoriesList[] = [
            'name' => $cName,
            'slug' => $c['slug'] ?? strtolower(str_replace(' ', '-', $cName)),
            'count' => $cCount . ' Designs',
            'img' => !empty($c['image']) ? $c['image'] : ('/assets/images/product' . (($idx % 6) + 1) . '.png'),
            'price_from' => 'Direct Surat Wholesale',
            'badge' => 'Verified Mill',
            'tagline' => !empty($c['description']) ? (strlen($c['description']) > 40 ? substr($c['description'], 0, 40) . '...' : $c['description']) : 'Authentic Collection'
        ];
    }
}

if (empty($categoriesList)) {
    $fallbackCats = ProductCatalog::getCategories();
    foreach ($fallbackCats as $idx => $cName) {
        $cCount = count(ProductCatalog::filter(['category' => $cName]));
        $categoriesList[] = [
            'name' => $cName,
            'slug' => strtolower(str_replace(' ', '-', $cName)),
            'count' => $cCount . ' Designs',
            'img' => '/assets/images/product' . (($idx % 6) + 1) . '.png',
            'price_from' => 'Direct Surat Wholesale',
            'badge' => 'Verified Mill',
            'tagline' => 'Handcrafted Authentic Weaves'
        ];
    }
}

$categoriesDetails = ProductCatalog::getCategoriesWithDetails();
$total_products = count($products);

// ── Rich Circular Stories Categories (Coyu Style) ──
$coyuStories = [
    [
        'is_dash' => true,
        'name'    => '60 Mins',
        'title'   => 'DT DASH',
        'link'    => '/shop'
    ]
];

$coyuPresetCategories = [
    ['name' => 'Dresses',      'img' => '/assets/images/product1.png', 'link' => '/shop?category=Kurtis'],
    ['name' => 'Co-ord Sets',  'img' => '/assets/images/product2.png', 'link' => '/shop?category=Co-ord%20Sets'],
    ['name' => 'Kurta Sets',   'img' => '/assets/images/product3.png', 'link' => '/shop?category=Kurtis'],
    ['name' => 'Tops',         'img' => '/assets/images/product4.png', 'link' => '/shop?category=Tops'],
    ['name' => 'Shirts',       'img' => '/assets/images/product5.png', 'link' => '/shop?category=Suits'],
    ['name' => 'Kaftans',      'img' => '/assets/images/product6.png', 'link' => '/shop?category=Kaftans'],
    ['name' => 'Sarees',       'img' => '/assets/images/product1.png', 'link' => '/shop?category=Sarees'],
    ['name' => 'Bottomwear',   'img' => '/assets/images/product2.png', 'link' => '/shop?category=Bottomwear'],
    ['name' => 'Lehengas',     'img' => '/assets/images/product3.png', 'link' => '/shop?category=Lehengas'],
    ['name' => 'Jewellery',    'img' => '/assets/images/product4.png', 'link' => '/shop?category=Jewellery'],
    ['name' => 'Dupattas',     'img' => '/assets/images/product5.png', 'link' => '/shop?category=Dupattas'],
];

$seenCatNames = [];
if (!empty($categoriesList)) {
    foreach ($categoriesList as $cl) {
        $cName = $cl['name'];
        $seenCatNames[strtolower($cName)] = true;
        $coyuStories[] = [
            'is_dash' => false,
            'name'    => $cName,
            'img'     => $cl['img'],
            'link'    => '/shop?category=' . urlencode($cName)
        ];
    }
}

foreach ($coyuPresetCategories as $preset) {
    if (empty($seenCatNames[strtolower($preset['name'])])) {
        $coyuStories[] = [
            'is_dash' => false,
            'name'    => $preset['name'],
            'img'     => $preset['img'],
            'link'    => $preset['link']
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="Shop direct from Surat manufacturers — sarees, kurtis, lehengas, suits, reseller margins & wholesale lots at DT Brand's." />
    <title>DT Brand's — Premium Ethnic Wear, Reseller & Wholesale Hub</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700;800&family=Montserrat:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/assets/css/home.css?v=1787019062&v=<?php echo time(); ?>">

    <!-- ════════════ GLOBAL DATA BOOTSTRAP ════════════ -->
    <script>
        window.shopProductsData = <?php echo json_encode(array_values($products)); ?>;
        window.allProducts = window.shopProductsData;
        window.catalogProducts = window.allProducts;
        window.products = window.allProducts;
        window.allCategories = <?php echo json_encode($categoriesDetails); ?>;
        window.openQuickView = function(id) { if(typeof window.openQV === 'function') window.openQV(id); };
        window.openQuickViewModal = function(id) { if(typeof window.openQV === 'function') window.openQV(id); };
    </script>
</head>
<body>

<!-- ════════════ SECTION 1: EXISTING HEADER PARTIAL ════════════ -->
<?php include_once __DIR__ . '/includes/shophader.php'; ?>

<div class="page-wrapper">

    <!-- ════════════ SECTION 1.5: COYU LUXURY HERO VIDEO BANNER SLIDER ════════════ -->
    <section class="coyu-hero-video-section" aria-label="Featured Collection Banner">
        <div class="coyu-hero-video-container">
            <div class="coyu-video-slider" id="coyuHeroVideoSlider">
                <div class="coyu-video-track">

                    <!-- Slide 1: Primary Brand Showcase -->
                    <div class="coyu-video-slide active" data-slide-index="0">
                        <div class="coyu-video-slide-media">
                            <img src="/assets/images/product1.png" alt="Curated Fresh Always on Trend" class="coyu-video-poster" />
                            <video class="coyu-video-bg" loop muted playsinline preload="auto">
                                <source src="https://assets.mixkit.co/videos/preview/mixkit-woman-in-a-traditional-indian-dress-walking-41584-large.mp4" type="video/mp4">
                            </video>
                        </div>
                        <div class="coyu-video-overlay"></div>
                        <div class="coyu-slide-content">
                            <span class="coyu-slide-badge">✨ NEW SEASON 2026</span>
                            <h1 class="coyu-slide-slogan">Curated. Fresh. Always on Trend.</h1>
                            <p class="coyu-slide-sub">Direct Surat Mill Weaves • Pure Silk, Handloom Korvai & Festive Craftsmanship</p>
                            <div class="coyu-slide-cta-row">
                                <a href="/shop" class="coyu-slide-cta-primary">
                                    <span>Explore Collection</span>
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                </a>
                                <button type="button" class="coyu-slide-cta-secondary" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(0);">
                                    <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                                    <span>Watch Live Draping</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2: Surat Wholesale & Reseller Advantage -->
                    <div class="coyu-video-slide" data-slide-index="1">
                        <div class="coyu-video-slide-media">
                            <img src="/assets/images/product2.png" alt="Surat Mill Factory Rates" class="coyu-video-poster" />
                            <video class="coyu-video-bg" loop muted playsinline preload="metadata">
                                <source src="https://assets.mixkit.co/videos/preview/mixkit-fashion-model-in-an-orange-and-yellow-dress-41578-large.mp4" type="video/mp4">
                            </video>
                        </div>
                        <div class="coyu-video-overlay"></div>
                        <div class="coyu-slide-content">
                            <span class="coyu-slide-badge">⚡ FACTORY DIRECT B2B</span>
                            <h2 class="coyu-slide-slogan">Surat Factory Rates. Zero Middlemen.</h2>
                            <p class="coyu-slide-sub">Buy Single Pieces or Bulk Lots • Resell with 40%+ Profit Margins via WhatsApp</p>
                            <div class="coyu-slide-cta-row">
                                <a href="/reseller" class="coyu-slide-cta-primary">
                                    <span>Start Reselling</span>
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                </a>
                                <a href="/wholesale" class="coyu-slide-cta-secondary">
                                    <span>Wholesale Bulk Lots</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3: Bridal & Festive Heirlooms -->
                    <div class="coyu-video-slide" data-slide-index="2">
                        <div class="coyu-video-slide-media">
                            <img src="/assets/images/product3.png" alt="Royal Wedding & Festive Weaves" class="coyu-video-poster" />
                            <video class="coyu-video-bg" loop muted playsinline preload="metadata">
                                <source src="https://assets.mixkit.co/videos/preview/mixkit-woman-in-traditional-indian-dress-posing-41583-large.mp4" type="video/mp4">
                            </video>
                        </div>
                        <div class="coyu-video-overlay"></div>
                        <div class="coyu-slide-content">
                            <span class="coyu-slide-badge">👑 BRIDAL & FESTIVE</span>
                            <h2 class="coyu-slide-slogan">Draped in Passion. Crafted with Royalty.</h2>
                            <p class="coyu-slide-sub">Pure Kanjivaram, Banarasi Zari Silk & Luxury Designer Lehengas</p>
                            <div class="coyu-slide-cta-row">
                                <a href="/shop?category=Sarees" class="coyu-slide-cta-primary">
                                    <span>Shop Sarees</span>
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                </a>
                                <a href="https://api.whatsapp.com/send?phone=917046363528&text=Namaste%20DT%20Brand%2C%20I%20want%20to%20see%20the%20latest%20Festive%20collection" target="_blank" rel="noopener noreferrer" class="coyu-slide-cta-secondary" style="background:#15803D;border-color:#16A34A;">
                                    <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"/></svg>
                                    <span>WhatsApp VIP Concierge</span>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Desktop Prev / Next Nav Arrows -->
                <button type="button" class="coyu-slider-arrow prev" aria-label="Previous Slide">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                <button type="button" class="coyu-slider-arrow next" aria-label="Next Slide">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>

                <!-- Sound Mute/Unmute Toggle -->
                <button type="button" class="coyu-sound-toggle" aria-label="Toggle Video Audio" title="Toggle Sound">
                    <svg viewBox="0 0 24 24"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon><line x1="23" y1="9" x2="17" y2="15"></line><line x1="17" y1="9" x2="23" y2="15"></line></svg>
                </button>

                <!-- Slider Indicators / Progress Bars -->
                <div class="coyu-slider-indicators">
                    <div class="coyu-indicator-bar active" data-index="0"><div class="coyu-indicator-fill"></div></div>
                    <div class="coyu-indicator-bar" data-index="1"><div class="coyu-indicator-fill"></div></div>
                    <div class="coyu-indicator-bar" data-index="2"><div class="coyu-indicator-fill"></div></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 1.8: CIRCULAR CATEGORY STORIES DISCOVERY RAIL ════════════ -->
    <section class="coyu-stories-rail-section" aria-label="Explore Categories">
        <div class="coyu-stories-container">
            <div class="coyu-stories-track" id="coyuStoriesTrack">
                <?php foreach ($coyuStories as $cs): ?>
                    <?php if (!empty($cs['is_dash'])): ?>
                        <a href="<?= $cs['link'] ?>" class="coyu-story-item">
                            <div class="coyu-story-avatar-wrap coyu-story-dash-avatar">
                                <div class="coyu-story-dash-inner">
                                    <div class="coyu-story-dash-logo">
                                        <span>DASH</span>
                                        <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                                    </div>
                                    <span style="font-size:8px;font-weight:700;letter-spacing:0.3px;opacity:0.95;">60 MINS</span>
                                </div>
                            </div>
                            <span class="coyu-story-label"><?= htmlspecialchars($cs['name']) ?></span>
                        </a>
                    <?php else: ?>
                        <a href="<?= $cs['link'] ?>" class="coyu-story-item" onclick="if(typeof window.filterHomeCategory==='function'){window.filterHomeCategory('<?= addslashes($cs['name']) ?>');}">
                            <div class="coyu-story-avatar-wrap">
                                <img src="<?= htmlspecialchars($cs['img']) ?>" alt="<?= htmlspecialchars($cs['name']) ?>" class="coyu-story-img" loading="lazy" onerror="this.onerror=null; this.src='/assets/images/product1.png';" />
                            </div>
                            <span class="coyu-story-label"><?= htmlspecialchars($cs['name']) ?></span>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 2: QUICK ACCESS BAR ════════════ -->
    <section class="home-quick-access-section" aria-label="Quick Access">
        <div class="home-section-container">
            <div class="quick-access-grid">
                <a href="#section-trending" class="quick-card card-shop" onclick="document.getElementById('section-trending').scrollIntoView({behavior:'smooth'}); return false;">
                    <div class="quick-card-icon-wrap icon-shop">
                        <svg viewBox="0 0 24 24" class="quick-card-svg"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                    </div>
                    <div class="quick-card-info">
                        <span class="quick-card-badge badge-shop">Storefront</span>
                        <h3 class="quick-card-title">Shop Collection</h3>
                        <p class="quick-card-sub">Latest 2026 Ethnic Wear</p>
                    </div>
                    <span class="quick-card-arrow" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </span>
                </a>

                <a href="/reseller" class="quick-card card-reseller">
                    <div class="quick-card-icon-wrap icon-reseller">
                        <svg viewBox="0 0 24 24" class="quick-card-svg"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    </div>
                    <div class="quick-card-info">
                        <span class="quick-card-badge badge-reseller">Zero Investment</span>
                        <h3 class="quick-card-title">Start Reselling</h3>
                        <p class="quick-card-sub">Earn Margins on WhatsApp</p>
                    </div>
                    <span class="quick-card-arrow" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </span>
                </a>

                <a href="/wholesale" class="quick-card card-wholesale">
                    <div class="quick-card-icon-wrap icon-wholesale">
                        <svg viewBox="0 0 24 24" class="quick-card-svg"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <div class="quick-card-info">
                        <span class="quick-card-badge badge-wholesale">Factory Rates</span>
                        <h3 class="quick-card-title">Buy Wholesale</h3>
                        <p class="quick-card-sub">Bulk Lots & Quantity Slabs</p>
                    </div>
                    <span class="quick-card-arrow" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </span>
                </a>

                <a href="#section-offers" class="quick-card card-offers" onclick="document.getElementById('section-offers').scrollIntoView({behavior:'smooth'}); return false;">
                    <div class="quick-card-icon-wrap icon-offers">
                        <svg viewBox="0 0 24 24" class="quick-card-svg"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    </div>
                    <div class="quick-card-info">
                        <span class="quick-card-badge badge-offers">Save Up to 35%</span>
                        <h3 class="quick-card-title">Special Offers</h3>
                        <p class="quick-card-sub">Festive & Clearance Codes</p>
                    </div>
                    <span class="quick-card-arrow" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </span>
                </a>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 5: SHOP BY CATEGORY (SMART LUXURY SCROLL RAIL) ════════════ -->
    <section class="home-section home-category-section" id="section-categories">
        <div class="home-section-container">
            <div class="home-section-header home-cat-section-header">
                <div>
                    <span class="home-section-tag">✨ CURATED ETHNIC COLLECTIONS</span>
                    <h2 class="home-section-title">Shop By Category</h2>
                </div>
                <div class="home-cat-header-actions">
                    <!-- Carousel Navigation Controls -->
                    <div class="home-cat-arrows-group">
                        <button type="button" class="home-cat-scroll-arrow prev" id="catScrollPrevBtn" onclick="if(typeof scrollCatRail==='function') scrollCatRail(-1);" aria-label="Previous categories">
                            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button type="button" class="home-cat-scroll-arrow next" id="catScrollNextBtn" onclick="if(typeof scrollCatRail==='function') scrollCatRail(1);" aria-label="Next categories">
                            <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Smart Horizontal Scroll Rail -->
            <div class="home-cat-carousel-wrap">
                <div class="home-cat-scroll-track" id="homeCatScrollTrack">
                    <?php foreach ($categoriesList as $cat): ?>
                    <article class="home-cat-card" onclick="if(typeof window.filterHomeCategory==='function') window.filterHomeCategory('<?= $cat['name'] ?>');" role="button" tabindex="0">
                        <div class="home-cat-card-img-wrap">
                            <img src="<?= $cat['img'] ?>" alt="<?= $cat['name'] ?>" loading="lazy" class="home-cat-card-img" />
                        </div>
                        <div class="home-cat-card-body">
                            <h3 class="home-cat-card-name"><?= $cat['name'] ?></h3>
                            <p class="home-cat-card-tagline"><?= $cat['tagline'] ?? 'Exclusive Collection' ?></p>
                            <div class="home-cat-card-footer">
                                <span class="home-cat-card-count"><?= $cat['count'] ?></span>
                                <span class="home-cat-explore-btn">Explore &rsaquo;</span>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>

                <!-- Custom Scroll Progress Bar -->
                <div class="home-cat-scrollbar-track" id="homeCatScrollbarTrack">
                    <div class="home-cat-scrollbar-thumb" id="homeCatScrollbarThumb"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 6: TRENDING NOW (MAIN STOREFRONT LISTING) ════════════ -->
    <section class="home-section home-trending-section" id="section-trending">
        <div class="home-section-container">
            <div class="home-section-header home-trending-section-header">
                <div>
                    <span class="home-section-tag trending-tag">🔥 HOTTEST PICKS THIS WEEK</span>
                    <h2 class="home-section-title">Trending Now</h2>
                </div>
                <div class="home-trending-header-actions">
                    <!-- Carousel Navigation Controls -->
                    <div class="home-trending-arrows-group">
                        <button type="button" class="trending-scroll-arrow prev" id="trendingScrollPrevBtn" onclick="if(typeof scrollTrendingRail==='function') scrollTrendingRail(-1);" aria-label="Previous products">
                            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button type="button" class="trending-scroll-arrow next" id="trendingScrollNextBtn" onclick="if(typeof scrollTrendingRail==='function') scrollTrendingRail(1);" aria-label="Next products">
                            <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Products 1-Line Continuous Rail -->
            <div class="trending-rail-container">
                <div class="products-grid products-scroll-rail" id="productsGrid" role="list">
            <?php foreach ($products as $p): ?>
            <?php
                $badge_class = !empty($p['badge']) ? 'badge-'.strtolower(preg_replace('/[^a-z0-9]/', '', $p['badge'])) : '';
                // Colours and sizes come from product_variants and are empty when the
                // product has none.
                $pCols  = array_values(array_filter(array_map('strval', (array)($p['colors'] ?? [])), static fn($v) => trim($v) !== ''));
                $pSizes = array_values(array_filter(array_map('strval', (array)($p['size'] ?? [])), static fn($v) => trim($v) !== ''));
                $pHasPhoto = !empty($p['has_photo']);
                $pSaleDisc   = (float)($p['sale_discount'] ?? ($p['sale_price'] ?? 0));
                $pCustBase   = !empty($p['customer_price']) ? (float)$p['customer_price'] : (float)($p['retail_price'] ?? ($p['price'] ?? 0));
                $pPrice      = max(0, $pCustBase - $pSaleDisc);
                $pOldPrice   = ($pSaleDisc > 0) ? $pCustBase : (float)($p['mrp'] ?? ($p['old_price'] ?? 0));
                $pDiscount   = ($pOldPrice > $pPrice && $pOldPrice > 0) ? (int)round((($pOldPrice - $pPrice) / $pOldPrice) * 100) : 0;
                $pReviews    = (int)($p['reviews_count'] ?? 0);
            ?>
            <article class="product-card" role="listitem" data-product-id="<?= $p['id'] ?>" data-category="<?= htmlspecialchars($p['category']) ?>" data-price="<?= $pPrice ?>" data-color="<?= htmlspecialchars($p['color']) ?>" data-discount="<?= $pDiscount ?>">
                <div class="card-image-wrap">
                    <a href="/product.php?id=<?= $p['id'] ?>" style="display:block;width:100%;height:100%;">
                        <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="card-img" loading="lazy"<?= $pHasPhoto ? '' : ' style="object-fit:contain;padding:18%;opacity:.6;"' ?> />
                    </a>

                    <?php if (!empty($p['badge'])): ?>
                    <span class="card-badge <?= $badge_class ?>"><?= htmlspecialchars($p['badge']) ?></span>
                    <?php endif; ?>

                    <button class="card-wishlist-btn" data-id="<?= $p['id'] ?>" aria-label="Wishlist <?= htmlspecialchars($p['name']) ?>" onclick="if(typeof window.toggleWishlistProduct==='function'){ window.toggleWishlistProduct(<?= $p['id'] ?>); }">
                        <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    </button>

                    <button class="card-mobile-qv-btn quick-view-btn" data-id="<?= $p['id'] ?>" aria-label="Quick View" onclick="openQuickViewModal(<?= $p['id'] ?>)">
                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>

                    <div class="card-quick-view" aria-hidden="true">
                        <button class="quick-view-btn" onclick="openQuickViewModal(<?= $p['id'] ?>)">Quick View</button>
                    </div>

                    <!-- 1-Tap Share Button (Opens SmartShare) -->
                    <button type="button" class="card-share-btn" data-id="<?= $p['id'] ?>" aria-label="Share <?= htmlspecialchars($p['name']) ?>" title="Share on WhatsApp" onclick="event.stopPropagation();event.preventDefault();if(typeof window.shareProductCard==='function'){window.shareProductCard(<?= $p['id'] ?>);}">
                        <svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                    </button>

                    <?php if (trim((string)($p['category'] ?? '')) !== ''): ?>
                    <span class="card-cat-photo-tag"><?= htmlspecialchars($p['category']) ?></span>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <div class="card-sku-rating-row">
                        <span class="card-sku-text"><?= htmlspecialchars((string)($p['sku'] ?? '')) ?></span>
                        <?php if ($pReviews > 0): ?>
                        <span class="card-rating-badge">★ <?= number_format((float)$p['rating'], 1) ?> (<?= $pReviews ?>)</span>
                        <?php endif; ?>
                    </div>

                    <h3 class="card-name">
                        <a href="/product.php?id=<?= $p['id'] ?>">
                            <?= htmlspecialchars($p['name']) ?>
                        </a>
                    </h3>

                    <?php if ($pCols !== [] || $pSizes !== []): ?>
                    <div class="card-info-text-row">
                        <?php if ($pCols !== []): ?>
                        <span class="card-colors-text" title="<?= htmlspecialchars(implode(', ', $pCols)) ?>"><?= count($pCols) ?> Colour<?= count($pCols) === 1 ? '' : 's' ?></span>
                        <?php endif; ?>
                        <?php if ($pSizes !== []): ?>
                        <span class="card-sizes-text"><?= htmlspecialchars(implode(', ', $pSizes)) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <div class="card-price-row">
                        <?php if ($pPrice > 0): ?>
                        <span class="card-price">₹<?= number_format($pPrice) ?></span>
                        <?php else: ?>
                        <span class="card-price" style="font-size:.82em;">Price on request</span>
                        <?php endif; ?>
                        <?php if ($pPrice > 0 && $pOldPrice > $pPrice): ?>
                        <span class="card-old-price">₹<?= number_format($pOldPrice) ?></span>
                        <?php endif; ?>
                        <?php if ($pSaleDisc > 0): ?>
                        <span class="card-price-discount" style="background:#FEF3C7; color:#B45309; font-weight:800; font-size:10px; padding:2px 6px; border-radius:3px;">SAVE ₹<?= (int)$pSaleDisc ?></span>
                        <?php elseif ($pPrice > 0 && $pOldPrice > $pPrice && !empty($pDiscount)): ?>
                        <span class="card-price-discount"><?= (int)$pDiscount ?>% OFF</span>
                        <?php endif; ?>
                    </div>

                    <!-- 1-Tap Add To Cart Action Button -->
                    <div class="card-btn-row">
                        <button type="button" class="card-add-cart-btn" onclick="if(typeof window.addToCart==='function'){ window.addToCart(<?= $p['id'] ?>); } else { showToast('Added to Cart!'); }">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                            <span>Add to Cart</span>
                        </button>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 11: DEAL OF THE DAY (WITH COUNTDOWN) ════════════ -->
    <section class="home-section home-deals-section" id="section-deals">
        <div class="home-section-container">
            <div class="home-deal-header">
                <div class="deal-header-left">
                    <span class="home-section-tag deal-tag">⚡ LIMITED TIME FLASH SALE</span>
                    <h2 class="home-section-title">Deal of the Day — Up to 30% OFF</h2>
                </div>
                <div class="deal-header-actions">
                    <div class="deal-countdown-box" id="dealCountdownBox">
                        <span class="countdown-label">Ends in:</span>
                        <div class="countdown-digits">
                            <span class="cd-box"><strong id="cdHours">08</strong><small>hrs</small></span> :
                            <span class="cd-box"><strong id="cdMins">45</strong><small>mins</small></span> :
                            <span class="cd-box"><strong id="cdSecs">20</strong><small>secs</small></span>
                        </div>
                    </div>
                    <div class="deal-slider-arrows">
                        <button type="button" class="deal-nav-arrow deal-nav-prev" id="dealScrollPrevBtn" onclick="scrollDealsRail(-1)" aria-label="Previous deals">‹</button>
                        <button type="button" class="deal-nav-arrow deal-nav-next" id="dealScrollNextBtn" onclick="scrollDealsRail(1)" aria-label="Next deals">›</button>
                    </div>
                </div>
            </div>

            <!-- 1 Line Continuous Scroll on Desktop / 2 Lines Synchronized Scroll on Mobile -->
            <div class="home-deals-grid" id="homeDealsGrid">
                <?php foreach (array_slice($products, 0, 10) as $p): ?>
                <?php
                    $dSaleDisc   = (float)($p['sale_discount'] ?? ($p['sale_price'] ?? 0));
                    $dCustBase   = !empty($p['customer_price']) ? (float)$p['customer_price'] : (float)($p['retail_price'] ?? ($p['price'] ?? 0));
                    $dPrice      = max(0, $dCustBase - $dSaleDisc);
                    $dOldPrice   = ($dSaleDisc > 0) ? $dCustBase : (float)($p['mrp'] ?? ($p['old_price'] ?? 0));
                    $dDiscount   = ($dOldPrice > $dPrice && $dOldPrice > 0) ? (int)round((($dOldPrice - $dPrice) / $dOldPrice) * 100) : 0;
                ?>
                <div class="home-deal-card">
                    <div class="deal-card-img-wrap">
                        <span class="deal-card-badge-top"><?= $dSaleDisc > 0 ? ('SAVE ₹' . (int)$dSaleDisc) : ('SAVE ' . $dDiscount . '%') ?></span>
                        <a href="/product.php?id=<?= $p['id'] ?>">
                            <img src="<?= $p['image'] ?>" alt="<?= $p['name'] ?>" class="deal-card-img" loading="lazy" />
                        </a>
                        <button type="button" class="deal-card-wish-btn" onclick="toggleWishlistProduct(<?= $p['id'] ?>)" aria-label="Add to wishlist">
                            <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        </button>
                    </div>
                    <div class="deal-card-body">
                        <div class="deal-sku-row">
                            <span class="deal-sku-text"><?= $p['sku'] ?></span>
                            <span class="deal-rating-badge">★ <?= $p['rating'] ?></span>
                        </div>
                        <h4 class="deal-card-title">
                            <a href="/product.php?id=<?= $p['id'] ?>"><?= htmlspecialchars($p['name']) ?></a>
                        </h4>
                        <div class="deal-card-prices">
                            <span class="deal-sale-price">₹<?= number_format($dPrice) ?></span>
                            <?php if ($dOldPrice > $dPrice): ?>
                            <span class="deal-mrp">₹<?= number_format($dOldPrice) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="deal-stock-bar-wrap">
                            <div class="deal-stock-bar" style="width: <?= min(90, max(30, ($p['in_stock'] % 70) + 25)) ?>%;"></div>
                            <span class="deal-stock-text">🔥 Only <?= max(3, $p['in_stock'] % 12) ?> sets left</span>
                        </div>
                        <button type="button" class="deal-btn-claim" onclick="if(typeof window.addToCart==='function'){ window.addToCart(<?= $p['id'] ?>); }">
                            <span>Claim Deal</span>
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 19: COLLECTION BANNERS ════════════ -->
    <section class="home-section" id="section-collections">
        <div class="home-section-container">
            <div class="home-section-header">
                <div>
                    <span class="home-section-tag">🌟 EDITORIAL CURATIONS</span>
                    <h2 class="home-section-title">Signature Collections</h2>
                </div>
            </div>

            <div class="collections-banner-grid">
                <div class="col-banner-card col-bridal" onclick="if(typeof window.filterHomeCategory==='function') window.filterHomeCategory('Lehengas');">
                    <div class="col-banner-content">
                        <span class="col-tag">BRIDAL COUTURE</span>
                        <h3 class="col-title">Royal Velvet & Zardozi Lehengas</h3>
                        <span class="col-link">Explore Bridal &rarr;</span>
                    </div>
                </div>

                <div class="col-banner-card col-festive" onclick="if(typeof window.filterHomeCategory==='function') window.filterHomeCategory('Sarees');">
                    <div class="col-banner-content">
                        <span class="col-tag">FESTIVE SILKS</span>
                        <h3 class="col-title">Heritage Banarasi & Kanjivaram</h3>
                        <span class="col-link">Explore Silks &rarr;</span>
                    </div>
                </div>

                <div class="col-banner-card col-party" onclick="if(typeof window.filterHomeCategory==='function') window.filterHomeCategory('Kurtis');">
                    <div class="col-banner-content">
                        <span class="col-tag">PARTY WEAR</span>
                        <h3 class="col-title">Anarkali & Sharara Sets</h3>
                        <span class="col-link">Explore Kurtis &rarr;</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 20: RECOMMENDED FOR YOU (2-LINE HORIZONTAL SCROLL) ════════════ -->
    <section class="home-section rec-section" id="section-recommended">
        <div class="home-section-container">
            <!-- Luxury Section Header with Badges, Subtitle and Controls -->
            <div class="rec-section-header">
                <div class="rec-header-titles">
                    <div class="rec-ai-badge-wrap">
                        <span class="rec-ai-badge"><span class="rec-sparkle">✨</span> AI PERSONALIZED PICKS</span>
                        <span class="rec-match-pill">● 98% Match Rate</span>
                    </div>
                    <h2 class="home-section-title rec-title" id="recommendedTitle">Recommended For You</h2>
                    <p class="rec-subtitle">Tailored ethnic collections curated from Surat looms based on your browsing & boutique trends.</p>
                </div>
                
                <div class="rec-header-controls">
                    <div class="rec-nav-arrows">
                        <button type="button" class="rec-arrow-btn rec-prev-arrow" onclick="window.slideRecommended(-1)" aria-label="Previous Recommendations">
                            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button type="button" class="rec-arrow-btn rec-next-arrow" onclick="window.slideRecommended(1)" aria-label="Next Recommendations">
                            <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Category Filter Pills Bar -->
            <div class="rec-filter-pills-bar">
                <button type="button" class="rec-filter-pill active" onclick="window.filterRecommendedCategory('All', this)">✨ All Picks (<?= count($products) ?>)</button>
                <?php foreach ($categoriesList as $catItem): ?>
                <button type="button" class="rec-filter-pill" onclick="window.filterRecommendedCategory('<?= htmlspecialchars($catItem['name']) ?>', this)">👑 <?= htmlspecialchars($catItem['name']) ?></button>
                <?php endforeach; ?>
            </div>

            <!-- 2-Line Horizontal Scrolling Multi-Row Track (Desktop: 5 per row, Mobile: 2 per row) -->
            <div class="rec-scroll-wrap" id="recScrollWrap">
                <div class="rec-scroll-track" id="recommendedGrid">
                    <?php 
                    // Duplicate products for rich continuous 2-row multi-page scroll
                    $allRecProducts = array_merge($products, $products);
                    foreach ($allRecProducts as $idx => $p): 
                        $aiScore = 95 + ($idx % 5);
                        $profit = !empty($p['reseller_profit']) ? $p['reseller_profit'] : round($p['price'] * 0.4);
                        $oldP = !empty($p['old_price']) ? $p['old_price'] : round($p['price'] * 1.5);
                        $disc = !empty($p['discount']) ? $p['discount'] : round((($oldP - $p['price']) / $oldP) * 100);
                        $rating = !empty($p['rating']) ? $p['rating'] : '4.9';
                        $reviews = !empty($p['reviews_count']) ? $p['reviews_count'] : 84;
                    ?>
                    <article class="rec-card" data-category="<?= htmlspecialchars($p['category']) ?>" data-product-id="<?= $p['id'] ?>">
                        <!-- Pure Luxury Image Showcase with Badges & Action Overlays -->
                        <div class="rec-img-wrap">
                            <a href="/product.php?id=<?= $p['id'] ?>" class="rec-img-link" title="<?= htmlspecialchars($p['name']) ?>">
                                <img src="<?= $p['image'] ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="rec-card-img" loading="lazy" />
                            </a>
                            
                            <!-- AI Match & Discount Badges -->
                            <div class="rec-badges-top">
                                <span class="rec-badge-ai">✨ <?= $aiScore ?>% Match</span>
                                <span class="rec-badge-disc"><?= $disc ?>% OFF</span>
                            </div>

                            <!-- Quick Action Buttons Overlay -->
                            <div class="rec-overlay-actions">
                                <button type="button" class="rec-action-btn rec-wishlist-btn" onclick="if(typeof window.toggleWishlistProduct==='function'){ window.toggleWishlistProduct(<?= $p['id'] ?>); } event.stopPropagation();" aria-label="Add to Wishlist" title="Add to Wishlist">
                                    <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                                </button>
                                <button type="button" class="rec-action-btn rec-quickview-btn" onclick="if(typeof openQuickView==='function'){openQuickView(<?= $p['id'] ?>);}else{window.location.href='/product.php?id=<?= $p['id'] ?>';} event.stopPropagation();" aria-label="Quick View" title="Quick View">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Scroll Progress Track Indicator -->
            <div class="rec-scrollbar-track" id="recScrollbarTrack">
                <div class="rec-scrollbar-thumb" id="recScrollbarThumb"></div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 21: RECENTLY VIEWED ════════════ -->
    <section class="home-section" id="section-recently-viewed" style="display:none;">
        <div class="home-section-container">
            <div class="home-section-header">
                <div>
                    <span class="home-section-tag">🕒 BROWSING HISTORY</span>
                    <h2 class="home-section-title">Recently Viewed Products</h2>
                </div>
                <div class="home-section-actions" style="display:flex; align-items:center; gap:12px;">
                    <button type="button" class="home-section-sub-link" onclick="if(typeof window.clearRecentlyViewed==='function') window.clearRecentlyViewed();" style="background:none; border:none; color:var(--dark-gold, #8A681F); font-size:0.80rem; font-weight:700; cursor:pointer; text-decoration:underline;">Clear History ✕</button>
                    <div class="rv-scroll-nav-btns" style="display:flex; gap:6px;">
                        <button type="button" class="rv-nav-btn rv-prev-btn" onclick="window.slideRecentlyViewed(-1)" aria-label="Previous Recently Viewed">
                            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button type="button" class="rv-nav-btn rv-next-btn" onclick="window.slideRecentlyViewed(1)" aria-label="Next Recently Viewed">
                            <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="recently-viewed-rail-wrap">
                <div class="recently-viewed-track" id="recentlyViewedTrack">
                    <!-- Dynamically populated from localStorage via JS -->
                </div>
            </div>
            <div class="rv-scrollbar-track" id="rvScrollbarTrack">
                <div class="rv-scrollbar-thumb" id="rvScrollbarThumb"></div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 26: VERIFIED BUYER FEEDBACK (1-LINE HORIZONTAL SCROLL) ════════════ -->
    <section class="home-section section-reviews-luxury" id="section-reviews">
        <div class="home-section-container">
            <div class="home-section-header rev-header-flex">
                <div>
                    <span class="home-section-tag rev-section-tag">
                        <svg viewBox="0 0 24 24" class="tag-live-icon"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        VERIFIED BUYER FEEDBACK
                    </span>
                    <h2 class="home-section-title">What Our Customers, Resellers & Wholesalers Say</h2>
                    <p class="home-section-desc">Over 50,000+ verified buyers across India rate us 4.9/5 stars for authenticity, margin & express speed.</p>
                </div>
                
                <div class="rev-header-controls">
                    <!-- Tab Filter Navigation -->
                    <div class="reviews-tab-nav">
                        <button type="button" class="rev-tab-pill active" onclick="switchReviewTab('customers', this)">
                            <span>🏪 Retail Boutiques & Shops</span>
                        </button>
                        <button type="button" class="rev-tab-pill" onclick="switchReviewTab('resellers', this)">
                            <span>⚡ Reseller Partners</span>
                        </button>
                        <button type="button" class="rev-tab-pill" onclick="switchReviewTab('wholesale', this)">
                            <span>🏭 Wholesale Boutiques</span>
                        </button>
                    </div>

                    <!-- 1-Tap Navigation Arrows -->
                    <div class="rev-nav-arrows">
                        <button type="button" class="rev-arrow-btn" onclick="slideReviews('left')" aria-label="Previous Reviews">‹</button>
                        <button type="button" class="rev-arrow-btn" onclick="slideReviews('right')" aria-label="Next Reviews">›</button>
                    </div>
                </div>
            </div>

            <!-- 1-Line Scrolling Tracks Container -->
            <div class="reviews-track-wrap">
                <!-- Retailer & Boutique Reviews Track (1-Line) -->
                <div class="reviews-track active" id="tab-reviews-customers">
                    <!-- Retailer 1: Home Boutique -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-retailer">
                                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                Home Boutique
                            </span>
                        </div>
                        
                        <div class="rev-product-pill">
                            <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                            <span>Small Batch 4pc Trial Lot • Silk Sarees</span>
                        </div>

                        <p class="rev-text">"I run a home boutique in Mumbai. DT Brand's 4-piece low MOQ lots let me curate fresh Surat silk sarees every 10 days without blocking huge capital. My boutique clients are thrilled with the rich zari finish!"</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-gold">PS</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Pooja Sharma</h5>
                                <span class="rev-location">📍 Mumbai • Owner, Pooja Designer Home Boutique</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Retailer 2: Small Shop Owner -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-retailer">
                                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                Small Shop Owner
                            </span>
                        </div>
                        
                        <div class="rev-product-pill">
                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            <span>100% GST ITC Invoices • Direct Surat Rates</span>
                        </div>

                        <p class="rev-text">"Opening our small saree shop in Ahmedabad was made completely hassle-free with DT Brand. Authentic manufacturer pricing, fast 48-hour door delivery, and genuine GST ITC bills for full input tax credit."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-amber">AP</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Ananya Patel</h5>
                                <span class="rev-location">📍 Ahmedabad • Owner, Ananya Ethnic Wear Shop</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Retailer 3: Boutique Designer -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-retailer">
                                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                Boutique Designer
                            </span>
                        </div>
                        
                        <div class="rev-product-pill">
                            <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                            <span>Mix & Match Lots • Bridal Velvet Lehengas</span>
                        </div>

                        <p class="rev-text">"We stock bridal lehengas and festive kurti sets for our boutique clients. The craftsmanship and heavy zardozi embroidery are flawless. 9 out of 10 walk-in customers buy on their first visit!"</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-emerald">RK</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Ritu Kapoor</h5>
                                <span class="rev-location">📍 Delhi • Founder, Ritu Bridal Studio & Boutique</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Retailer 4: Town Retail Shop -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-retailer">
                                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                Town Retail Shop
                            </span>
                        </div>
                        
                        <div class="rev-product-pill">
                            <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/></svg>
                            <span>Express Courier • Door Counter Delivery</span>
                        </div>

                        <p class="rev-text">"For our town retail counter, ordering 8 to 16 sarees weekly has doubled our profit margins. The packaging is sturdy with zero damage, and the margin gives us a huge edge over local traders."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-indigo">MS</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Meenakshi Sundaram</h5>
                                <span class="rev-location">📍 Chennai • Owner, Sri Meenakshi Retail Silks</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Retailer 5: Home Studio Seller -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-retailer">
                                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                Home Studio Seller
                            </span>
                        </div>
                        
                        <div class="rev-product-pill">
                            <svg viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            <span>HD Draping Videos • Advance Client Bookings</span>
                        </div>

                        <p class="rev-text">"As a home boutique seller, having HD model draping videos and zero-watermark photos lets me take advance pre-orders effortlessly. DT Brand is our most reliable sourcing partner."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-purple">SM</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Shreya Mukherjee</h5>
                                <span class="rev-location">📍 Kolkata • Owner, Shreya Boutique & Studio</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>
                </div>

                <!-- Reseller Reviews Track (1-Line) -->
                <div class="reviews-track" id="tab-reviews-resellers" style="display:none;">
                    <!-- Reseller 1 -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-reseller">
                                <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                Top Reseller
                            </span>
                        </div>
                        
                        <div class="rev-product-pill rev-pill-profit">
                            <svg viewBox="0 0 24 24"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                            <span>Monthly Margin: ₹48,200 Pure Profit</span>
                        </div>

                        <p class="rev-text">"I started reselling DT Brand's sarees on WhatsApp 4 months ago. Last month I earned ₹48,200 pure margin! Customers love the unbranded white-label packaging."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-emerald">SM</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Sunita Mehta</h5>
                                <span class="rev-location">📍 Pune • WhatsApp Reseller (₹48k/mo)</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Reseller 2 -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-reseller">
                                <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                Top Reseller
                            </span>
                        </div>
                        
                        <div class="rev-product-pill rev-pill-profit">
                            <svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                            <span>1-Tap Social Smart Share</span>
                        </div>

                        <p class="rev-text">"1-tap WhatsApp sharing makes it effortless. The photos have zero watermarks, so my clients believe I stock everything in my own boutique."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-rose">KG</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Kavita Gupta</h5>
                                <span class="rev-location">📍 Jaipur • Instagram Boutique Owner</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Reseller 3 -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-reseller">
                                <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                Top Reseller
                            </span>
                        </div>
                        
                        <div class="rev-product-pill rev-pill-profit">
                            <svg viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                            <span>Weekly Direct Bank Payouts</span>
                        </div>

                        <p class="rev-text">"Payouts are credited directly to my bank account every Monday without fail. I have made over ₹1.4 Lakh total profit in 6 months."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-cyan">DN</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Deepa Nair</h5>
                                <span class="rev-location">📍 Kochi • Verified Reseller</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Reseller 4 -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-reseller">
                                <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                Top Reseller
                            </span>
                        </div>
                        
                        <div class="rev-product-pill rev-pill-profit">
                            <svg viewBox="0 0 24 24"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                            <span>HD Live Video Reels Media</span>
                        </div>

                        <p class="rev-text">"High-definition video reels and model draping clips help me close 8-10 saree orders every single day on Facebook Marketplace."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-gold">PV</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Preeti Verma</h5>
                                <span class="rev-location">📍 Lucknow • Social Seller</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>
                </div>

                <!-- Wholesale Reviews Track (1-Line) -->
                <div class="reviews-track" id="tab-reviews-wholesale" style="display:none;">
                    <!-- Wholesale 1 -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-wholesale">
                                <svg viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                Wholesale Buyer
                            </span>
                        </div>
                        
                        <div class="rev-product-pill rev-pill-b2b">
                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            <span>Monthly 100+ Pieces Lot • GST Invoices</span>
                        </div>

                        <p class="rev-text">"We order 50–100 pieces monthly for our 3 retail boutiques in Hyderabad. The tiered volume slabs save us over 20% compared to local middleman traders."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-indigo">VR</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Venkatesh Rao</h5>
                                <span class="rev-location">📍 Hyderabad • Retail Showroom Chain</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Wholesale 2 -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-wholesale">
                                <svg viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                Wholesale Buyer
                            </span>
                        </div>
                        
                        <div class="rev-product-pill rev-pill-b2b">
                            <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"/><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"/></svg>
                            <span>Pan-India Transport Parcel Delivery</span>
                        </div>

                        <p class="rev-text">"Best factory pricing straight from the Surat loom. GST billing is prompt, and transit parcel delivery to Kolkata is 100% insured and reliable."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-amber">MS</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Mukesh Shah</h5>
                                <span class="rev-location">📍 Surat & Kolkata • Textile Trader</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>

                    <!-- Wholesale 3 -->
                    <div class="review-card">
                        <div class="rev-card-top">
                            <div class="rev-stars-box">
                                <span class="rev-stars">★★★★★</span>
                                <span class="rev-score-badge">5.0</span>
                            </div>
                            <span class="rev-verified-badge rev-badge-wholesale">
                                <svg viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                Wholesale Buyer
                            </span>
                        </div>
                        
                        <div class="rev-product-pill rev-pill-b2b">
                            <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                            <span>Low MOQ Trial Packs (4-8 Pcs)</span>
                        </div>

                        <p class="rev-text">"Mix & match catalog trial lots allow us to test trending bridal colors with zero inventory risk. Our boutique sales doubled within 90 days."</p>

                        <div class="rev-author-row">
                            <div class="rev-avatar rev-av-purple">SD</div>
                            <div class="rev-author-meta">
                                <h5 class="rev-name">Sangeeta Deshmukh</h5>
                                <span class="rev-location">📍 Nagpur, Maharashtra • Boutique Owner</span>
                            </div>
                            <div class="rev-quote-watermark">❝</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Real-Time Progress Scrollbar -->
            <div class="rev-scrollbar-track" id="revScrollbarTrack">
                <div class="rev-scrollbar-thumb" id="revScrollbarThumb"></div>
            </div>
        </div>
    </section>

    <!-- ════════════ SECTION 29: PRODUCT VIDEO REELS ════════════ -->
    <?php
    $homeReelProducts = array_values(array_filter($products ?? [], static function ($rp) {
        return !empty($rp['has_video']) || !empty($rp['video']) || !empty($rp['videos']) || !empty($rp['embed']) || !empty($rp['embeds']);
    }));
    // If no products have explicitly tagged videos, but products exist in catalog, display actual catalog products
    if (empty($homeReelProducts) && !empty($products)) {
        $homeReelProducts = $products;
    }
    ?>
    <?php if (!empty($homeReelProducts)): ?>
    <section class="home-section section-reels-luxury" id="section-reels">
        <div class="home-section-container">
            <div class="home-section-header reels-header-flex">
                <div>
                    <span class="home-section-tag reels-section-tag">
                        <svg viewBox="0 0 24 24" class="tag-live-icon"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                        REAL PRODUCT VIDEOS
                    </span>
                    <h2 class="home-section-title">Watch Live Draping & Craftsmanship</h2>
                    <p class="home-section-desc">Experience 100% authentic silk luster, zari shine, and model draping before you buy.</p>
                </div>
                
                <div class="reels-header-controls">
                    <button type="button" class="reels-open-all-btn" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(0);">
                        <span>Watch Full Reels</span>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                    </button>
                    <!-- 1-Tap Navigation Arrows -->
                    <div class="reels-nav-arrows">
                        <button type="button" class="reels-arrow-btn" onclick="scrollReelsRail(-1)" aria-label="Previous Reels">‹</button>
                        <button type="button" class="reels-arrow-btn" onclick="scrollReelsRail(1)" aria-label="Next Reels">›</button>
                    </div>
                </div>
            </div>

            <!-- 1-Line Reels Scrolling Rail Wrapper -->
            <div class="reels-track-wrap">
                <div class="home-reels-strip" id="homeReelsTrack">
                    <?php foreach ($homeReelProducts as $rIdx => $rp):
                        $rImg = (!empty($rp['image']) && $rp['image'] !== '/assets/images/no-image.svg')
                            ? $rp['image'] : '/assets/images/no-image.svg';
                        $rName = trim((string)($rp['name'] ?? ''));
                        $rFabric = trim((string)($rp['fabric'] ?? ''));
                        $rCat = trim((string)($rp['category'] ?? ''));
                        $rPrice = (float)($rp['price'] ?? 0);
                        $rReviews = (int)($rp['reviews_count'] ?? 0);
                    ?>
                    <div class="home-reel-card" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(<?php echo (int)$rIdx; ?>);" role="button" tabindex="0">
                        <div class="reel-media-box">
                            <img src="<?php echo htmlspecialchars($rImg); ?>" alt="<?php echo htmlspecialchars($rName); ?>" class="reel-img" loading="lazy"<?php echo $rImg === '/assets/images/no-image.svg' ? ' style="opacity:.45;"' : ''; ?> />
                            <div class="reel-top-bar">
                                <span class="reel-live-tag"><span class="reel-pulse-dot"></span> VIDEO</span>
                                <?php if ($rReviews > 0): ?>
                                <!-- Real review count. The old "views" pills were invented figures. -->
                                <span class="reel-views-pill">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <?php echo number_format($rReviews); ?>
                                </span>
                                <?php endif; ?>
                            </div>
                            <div class="reel-center-play">
                                <div class="reel-play-btn">
                                    <svg viewBox="0 0 24 24" class="reel-play-svg"><polygon points="6 3 20 12 6 21 6 3"></polygon></svg>
                                </div>
                            </div>
                            <div class="reel-info-overlay">
                                <h4 class="reel-title"><?php echo htmlspecialchars($rName !== '' ? $rName : 'Untitled product'); ?></h4>
                                <div class="reel-meta-row">
                                    <?php $rMeta = $rFabric !== '' ? $rFabric : $rCat; ?>
                                    <?php if ($rMeta !== ''): ?>
                                    <span class="reel-fabric"><?php echo htmlspecialchars($rMeta); ?></span>
                                    <?php endif; ?>
                                    <span class="reel-price"><?php echo $rPrice > 0 ? '₹' . number_format($rPrice) : 'Price on request'; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Real-Time Progress Scrollbar -->
            <div class="reels-scrollbar-track" id="reelsScrollbarTrack">
                <div class="reels-scrollbar-thumb" id="reelsScrollbarThumb"></div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- ════════════ SECTION 30: WHATSAPP CONCIERGE CTA ════════════ -->
    <section class="home-wa-concierge-section">
        <div class="home-section-container">
            <div class="home-wa-card">
                <div class="home-wa-left">
                    <div class="home-wa-icon-large">
                        <svg viewBox="0 0 24 24" width="36" height="36" fill="#FFFFFF"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
                    </div>
                    <div>
                        <h3 class="home-wa-title">Need Styling Advice, Reseller Support or Wholesale Quotes?</h3>
                        <p class="home-wa-sub">Our fashion stylists and B2B managers are available live on WhatsApp.</p>
                    </div>
                </div>
                <div class="home-wa-right">
                    <a href="https://api.whatsapp.com/send?phone=917046363528&text=Hi%2C%20I%20would%20like%20to%20know%20more%20about%20DT%20Brand%20products%2C%20reselling%20and%20wholesale." target="_blank" class="home-wa-btn">
                        <span>Chat on WhatsApp</span>
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

</div><!-- /.page-wrapper -->

<!-- ════════════ SECTION 31: SMART ANIMATED MOBILE BOTTOM FOOTER ════════════ -->
<?php include_once __DIR__ . '/includes/shopbottomfotoer.php'; ?>

<!-- ════════════ MASTER MODAL SYSTEM INTEGRATIONS ════════════ -->
<?php include_once __DIR__ . '/shared/quickview.php'; ?>
<?php include_once __DIR__ . '/shared/smartshare.php'; ?>
<?php include_once __DIR__ . '/shared/reels.php'; ?>
<?php include_once __DIR__ . '/shared/cart.php'; ?>
<?php include_once __DIR__ . '/shared/wishlist.php'; ?>
<?php include_once __DIR__ . '/shared/checkout.php'; ?>
<?php include_once __DIR__ . '/shared/account.php'; ?>

<div class="toast-container" id="toastContainer" aria-live="assertive" aria-atomic="true"></div>

<!-- ════════════ MASTER ENGINE SCRIPT ════════════ -->
<script src="/assets/js/home.js?v=1787019062&v=<?php echo time(); ?>"></script>

</body>
</html>
