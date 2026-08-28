<?php
/**
 * shop.php — MAIN PAGE (single complete HTML document)
 * Includes shophader.php and shopbottomfotoer.php as partials.
 * Premium Ethnic-Wear Shop — DT Brand's
 */

require_once __DIR__ . '/src/ProductCatalog.php';
require_once __DIR__ . '/src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

// ── Dynamic Database-First Catalog Loader ──
$products = ProductCatalog::getAll();

$selectedCategory = isset($_GET['category']) ? trim($_GET['category']) : '';
$shopNoImage = ProductCatalog::NO_IMAGE;
if ($selectedCategory !== '' && strtolower($selectedCategory) !== 'all') {
    $filtered = [];
    foreach ($products as $p) {
        $catName = strtolower($p['category'] ?? ($p['category_name'] ?? ''));
        $catSlug = strtolower(str_replace(' ', '-', $catName));
        $targetSlug = strtolower(str_replace(' ', '-', $selectedCategory));
        if ($catName !== '' && ($catName === strtolower($selectedCategory) || $catSlug === $targetSlug || strpos($catSlug, $targetSlug) !== false || strpos($targetSlug, $catSlug) !== false)) {
            $filtered[] = $p;
        }
    }
    // The filter is applied even when it matches nothing. This used to keep the
    // unfiltered list whenever $filtered was empty, so asking for a category
    // with no products showed the whole catalogue as if it belonged to it.
    $products = $filtered;
}

$categories = array_unique(array_merge(['All'], ProductCatalog::getCategories()));
$categoriesDetails = ProductCatalog::getCategoriesWithDetails();
$total_products = count($products);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="description" content="Shop premium Indian ethnic wear — silk sarees, kurtis, lehengas and designer gowns at DT Brand's." />
<title>Shop — DT Brand's | Ethnic Luxury</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

<link rel="stylesheet" href="/assets/css/shop.css?v=1787019062">

    <!-- ════════════ GLOBAL PRODUCTS & MODAL ENGINE BOOTSTRAP ════════════ -->
    <script>
        window.allProducts = <?php echo json_encode(isset($products) ? array_values($products) : []); ?>;
        window.catalogProducts = window.allProducts;
        window.products = window.allProducts;
        window.shopProductsData = window.allProducts;
        window.allCategories = <?php echo json_encode($categoriesDetails); ?>;
        window.initialCategory = <?php echo json_encode($selectedCategory ?: 'All'); ?>;
        window.openQuickView = function(id) { if(typeof window.openQV === 'function') window.openQV(id); };
        window.openQuickViewModal = function(id) { if(typeof window.openQV === 'function') window.openQV(id); };
    </script>
</head>
<body>

<!-- ════════════ HEADER PARTIAL ════════════ -->
<?php include_once __DIR__ . '/includes/shophader.php'; ?>

<!-- ════════════ PAGE ════════════ -->
<div class="page-wrapper">

    <!-- ════ HERO PROMO BANNER SLIDER (Positioned above round sub-categories) ════ -->
    <section class="hero-banner-section" aria-label="Featured Collections">
        <div class="hero-banner-container" id="heroBannerContainer">
            <div class="hero-banner-track" id="heroBannerTrack">
                
                <!-- Slide 1: Festive Sarees Edit -->
                <div class="hero-banner-slide hero-slide-1" onclick="if(typeof window.filterByBanner==='function') window.filterByBanner('Sarees');">
                    <div class="hero-slide-content">
                        <span class="hero-slide-tag">✨ FESTIVE SILK UTSAV</span>
                        <h2 class="hero-slide-title">Royal Banarasi & Kanjeevaram</h2>
                        <p class="hero-slide-desc">Flat 25% OFF &bull; Pure Zari Heritage Weaves</p>
                        <button class="hero-slide-btn">Explore Sarees &rarr;</button>
                    </div>
                    <div class="hero-slide-img-wrap">
                        <img src="/assets/images/product1.png" alt="Royal Silk Sarees" loading="lazy" />
                    </div>
                </div>

                <!-- Slide 2: Designer Kurtis Extravaganza -->
                <div class="hero-banner-slide hero-slide-2" onclick="if(typeof window.filterByBanner==='function') window.filterByBanner('Kurtis');">
                    <div class="hero-slide-content">
                        <span class="hero-slide-tag">🌸 NEW SEASON DROP</span>
                        <h2 class="hero-slide-title">Designer Anarkali & Kurtis</h2>
                        <p class="hero-slide-desc">From ₹1,499 &bull; Pure Georgette & Cotton</p>
                        <button class="hero-slide-btn">Shop Kurtis &rarr;</button>
                    </div>
                    <div class="hero-slide-img-wrap">
                        <img src="/assets/images/product5.png" alt="Designer Kurtis" loading="lazy" />
                    </div>
                </div>

                <!-- Slide 3: Bridal Lehengas & Gowns -->
                <div class="hero-banner-slide hero-slide-3" onclick="if(typeof window.filterByBanner==='function') window.filterByBanner('Lehengas');">
                    <div class="hero-slide-content">
                        <span class="hero-slide-tag">👑 ROYAL BRIDAL COUTURE</span>
                        <h2 class="hero-slide-title">Velvet & Zardozi Lehengas</h2>
                        <p class="hero-slide-desc">Complimentary Custom Fit Available</p>
                        <button class="hero-slide-btn">View Bridal &rarr;</button>
                    </div>
                    <div class="hero-slide-img-wrap">
                        <img src="/assets/images/product6.png" alt="Bridal Lehengas" loading="lazy" />
                    </div>
                </div>

            </div>

            <!-- Left / Right Navigation Arrows -->
            <button class="hero-banner-arrow prev" id="heroBannerPrevBtn" aria-label="Previous Slide">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <button class="hero-banner-arrow next" id="heroBannerNextBtn" aria-label="Next Slide">
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>

            <!-- Bottom Indicator Dots -->
            <div class="hero-banner-dots" id="heroBannerDots">
                <span class="hero-banner-dot active" data-slide="0"></span>
                <span class="hero-banner-dot" data-slide="1"></span>
                <span class="hero-banner-dot" data-slide="2"></span>
            </div>
        </div>
    </section>

    <!-- ════ ROUND SUB-CATEGORY SLIDER (Positioned directly under Banner Slider) ════ -->
    <nav class="cat-slider-section" aria-label="Sub categories">
        <div class="cat-slider-track" id="catSliderTrack" role="list">
            <!-- Dynamically populated from JS -->
        </div>
    </nav>

    <!-- ════ SHOP LAYOUT: SIDEBAR + PRODUCTS ════ -->
    <div class="shop-layout">

    <!-- ── Desktop Left Sidebar Filter ── -->
    <aside class="filter-sidebar" id="desktopFilterSidebar" aria-label="Filter products">

        <div class="sf-header">
            <span class="sf-title">
                Filters
                <span class="sf-title-badge" id="sfActiveBadge" style="display:none;">0</span>
            </span>
            <button class="sf-clear-all" id="sfClearAll">Clear All</button>
        </div>

        <!-- Category Section -->
        <div class="sf-section open" id="sec-category">
            <button class="sf-section-btn" aria-expanded="true">
                <span class="sf-section-title-wrap">
                    Category
                    <span class="sf-sec-badge" id="badge-category">All</span>
                </span>
                <svg class="sf-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div class="sf-section-body">
                <div class="sf-chips" role="group" aria-label="Category">
                    <?php foreach ($categories as $catItem): 
                        $isAct = ($catItem === 'All' && empty($selectedCategory)) || (strtolower($catItem) === strtolower($selectedCategory));
                    ?>
                    <button class="sf-chip <?= $isAct ? 'active' : '' ?>" data-sf-type="category" data-sf-val="<?= htmlspecialchars($catItem) ?>" aria-pressed="<?= $isAct ? 'true' : 'false' ?>"><?= htmlspecialchars($catItem) ?></button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Price Range Section -->
        <div class="sf-section open" id="sec-price">
            <button class="sf-section-btn" aria-expanded="true">
                <span class="sf-section-title-wrap">
                    Price Range
                    <span class="sf-sec-badge" id="badge-price">Custom</span>
                </span>
                <svg class="sf-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div class="sf-section-body">
                <div class="price-display-card">
                    <div class="price-pill">
                        <span class="price-pill-lbl">MIN</span>
                        <span class="price-pill-val" id="sfPriceMinLabel">₹500</span>
                    </div>
                    <div class="price-pill-sep">—</div>
                    <div class="price-pill">
                        <span class="price-pill-lbl">MAX</span>
                        <span class="price-pill-val" id="sfPriceMaxLabel">₹30,000</span>
                    </div>
                </div>
                <div class="sf-range-track">
                    <div class="sf-range-fill" id="sfRangeFill"></div>
                    <input type="range" class="sf-range" id="sfPriceMin" min="500" max="30000" step="100" value="500" aria-label="Min price" />
                    <input type="range" class="sf-range" id="sfPriceMax" min="500" max="30000" step="100" value="30000" aria-label="Max price" />
                </div>
                <div class="price-presets" role="group" aria-label="Price range presets">
                    <button class="price-preset-chip" data-min="500" data-max="3000">Under ₹3k</button>
                    <button class="price-preset-chip" data-min="3000" data-max="8000">₹3k – ₹8k</button>
                    <button class="price-preset-chip" data-min="8000" data-max="15000">₹8k – ₹15k</button>
                    <button class="price-preset-chip" data-min="15000" data-max="30000">₹15k+</button>
                </div>
            </div>
        </div>

        <!-- Color Section -->
        <div class="sf-section" id="sec-color">
            <button class="sf-section-btn" aria-expanded="false">
                <span class="sf-section-title-wrap">
                    Colour
                    <span class="sf-sec-badge" id="badge-color">0</span>
                </span>
                <svg class="sf-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div class="sf-section-body">
                <div class="sf-swatches" role="group" aria-label="Colour">
                    <div class="sf-swatch-wrapper" data-sf-type="color" data-sf-val="Navy">
                        <span class="sf-swatch-circle" style="background:#1a237e;"></span>
                        <span class="sf-swatch-text">Navy</span>
                    </div>
                    <div class="sf-swatch-wrapper" data-sf-type="color" data-sf-val="Maroon">
                        <span class="sf-swatch-circle" style="background:#880e4f;"></span>
                        <span class="sf-swatch-text">Maroon</span>
                    </div>
                    <div class="sf-swatch-wrapper" data-sf-type="color" data-sf-val="Green">
                        <span class="sf-swatch-circle" style="background:#1b5e20;"></span>
                        <span class="sf-swatch-text">Green</span>
                    </div>
                    <div class="sf-swatch-wrapper" data-sf-type="color" data-sf-val="Pink">
                        <span class="sf-swatch-circle" style="background:#e91e63;"></span>
                        <span class="sf-swatch-text">Pink</span>
                    </div>
                    <div class="sf-swatch-wrapper" data-sf-type="color" data-sf-val="Yellow">
                        <span class="sf-swatch-circle" style="background:#f9a825;"></span>
                        <span class="sf-swatch-text">Yellow</span>
                    </div>
                    <div class="sf-swatch-wrapper" data-sf-type="color" data-sf-val="Red">
                        <span class="sf-swatch-circle" style="background:#b71c1c;"></span>
                        <span class="sf-swatch-text">Red</span>
                    </div>
                    <div class="sf-swatch-wrapper" data-sf-type="color" data-sf-val="Orange">
                        <span class="sf-swatch-circle" style="background:#f57c00;"></span>
                        <span class="sf-swatch-text">Orange</span>
                    </div>
                    <div class="sf-swatch-wrapper" data-sf-type="color" data-sf-val="White">
                        <span class="sf-swatch-circle" style="background:#ffffff;border:1px solid #ccc;"></span>
                        <span class="sf-swatch-text">White</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Size Section -->
        <div class="sf-section" id="sec-size">
            <button class="sf-section-btn" aria-expanded="false">
                <span class="sf-section-title-wrap">
                    Size
                    <span class="sf-sec-badge" id="badge-size">0</span>
                </span>
                <svg class="sf-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div class="sf-section-body">
                <div class="sf-chips" role="group" aria-label="Size">
                    <button class="sf-chip" data-sf-type="size" data-sf-val="XS" aria-pressed="false">XS</button>
                    <button class="sf-chip" data-sf-type="size" data-sf-val="S" aria-pressed="false">S</button>
                    <button class="sf-chip" data-sf-type="size" data-sf-val="M" aria-pressed="false">M</button>
                    <button class="sf-chip" data-sf-type="size" data-sf-val="L" aria-pressed="false">L</button>
                    <button class="sf-chip" data-sf-type="size" data-sf-val="XL" aria-pressed="false">XL</button>
                    <button class="sf-chip" data-sf-type="size" data-sf-val="XXL" aria-pressed="false">XXL</button>
                    <button class="sf-chip" data-sf-type="size" data-sf-val="Free Size" aria-pressed="false">Free Size</button>
                </div>
            </div>
        </div>

        <!-- Fabric Section -->
        <div class="sf-section" id="sec-fabric">
            <button class="sf-section-btn" aria-expanded="false">
                <span class="sf-section-title-wrap">
                    Fabric
                    <span class="sf-sec-badge" id="badge-fabric">0</span>
                </span>
                <svg class="sf-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div class="sf-section-body">
                <div class="sf-chips" role="group" aria-label="Fabric">
                    <button class="sf-chip" data-sf-type="fabric" data-sf-val="Pure Silk" aria-pressed="false">Pure Silk</button>
                    <button class="sf-chip" data-sf-type="fabric" data-sf-val="Georgette" aria-pressed="false">Georgette</button>
                    <button class="sf-chip" data-sf-type="fabric" data-sf-val="Cotton" aria-pressed="false">Cotton</button>
                    <button class="sf-chip" data-sf-type="fabric" data-sf-val="Chiffon" aria-pressed="false">Chiffon</button>
                    <button class="sf-chip" data-sf-type="fabric" data-sf-val="Organza" aria-pressed="false">Organza</button>
                </div>
            </div>
        </div>

        <!-- Discount Section -->
        <div class="sf-section" id="sec-discount">
            <button class="sf-section-btn" aria-expanded="false">
                <span class="sf-section-title-wrap">
                    Discount
                    <span class="sf-sec-badge" id="badge-discount">0</span>
                </span>
                <svg class="sf-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div class="sf-section-body">
                <div class="sf-chips" role="group" aria-label="Discount">
                    <button class="sf-chip" data-sf-type="discount" data-sf-val="10" aria-pressed="false">10% &amp; above</button>
                    <button class="sf-chip" data-sf-type="discount" data-sf-val="20" aria-pressed="false">20% &amp; above</button>
                    <button class="sf-chip" data-sf-type="discount" data-sf-val="25" aria-pressed="false">25% &amp; above</button>
                </div>
            </div>
        </div>

        <!-- Availability Section -->
        <div class="sf-section" id="sec-availability">
            <button class="sf-section-btn" aria-expanded="false">
                <span class="sf-section-title-wrap">
                    Availability
                    <span class="sf-sec-badge" id="badge-availability">Active</span>
                </span>
                <svg class="sf-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            <div class="sf-section-body">
                <div class="sf-chips" role="group" aria-label="Availability">
                    <button class="sf-chip active" data-sf-type="availability" data-sf-val="In Stock" aria-pressed="true">In Stock</button>
                    <button class="sf-chip" data-sf-type="availability" data-sf-val="Pre-Order" aria-pressed="false">Pre-Order</button>
                </div>
            </div>
        </div>

    </aside>

    <!-- ── Products Main Area ── -->
    <div class="products-area">

        <!-- Top Desktop Sort Header -->
        <div class="products-top-bar">
            <span class="ptb-count" id="ptbCount">Showing <?= $total_products ?> Products</span>
            <div class="ptb-sort-wrap">
                <span class="ptb-sort-label">Sort by:</span>
                <select class="ptb-sort-select" id="ptbSortSelect" aria-label="Sort products">
                    <option value="recommended">Recommended</option>
                    <option value="newest">Newest First</option>
                    <option value="price_asc">Price — Low to High</option>
                    <option value="price_desc">Price — High to Low</option>
                    <option value="discount">Best Discount</option>
                </select>
            </div>
        </div>

        <!-- Main Products Listing -->
        <main class="products-section" aria-label="Product listing">

            <!-- Dynamic Active Filter Tags -->
            <div class="active-filter-bar" id="activeFilterBar" role="status" aria-live="polite">
                <span class="active-filter-label">Active Filters:</span>
                <div id="activeFilterTagsWrap" style="display:flex;gap:6px;flex-wrap:wrap;"></div>
            </div>

            <!-- Products Grid -->
            <div class="products-grid" id="productsGrid" role="list">
            <?php foreach ($products as $p): ?>
            <?php
                // Everything below comes from the row. Where a value is genuinely
                // missing the card says so instead of inventing one: the image
                // used to fall back to /assets/images/product1.png, a product
                // with no variants was printed as "1 Colours", and a product
                // with no size rows was printed as "Free Size".
                $pName       = (string)($p['name'] ?? '');
                $badge_class = !empty($p['badge']) ? 'badge-' . strtolower(preg_replace('/[^a-z0-9]+/i', '-', (string)$p['badge'])) : '';
                $pHasPhoto   = !empty($p['has_photo']);
                $pImg        = $pHasPhoto ? (string)$p['image'] : $shopNoImage;
                $pCols       = array_values(array_filter((array)($p['colors'] ?? []), static fn($c) => trim((string)$c) !== ''));
                $pSizes      = array_values(array_filter((array)($p['size'] ?? []), static fn($s) => trim((string)$s) !== ''));
                $size_str    = implode(',', $pSizes);
                $pHasVideo   = !empty($p['has_video']);
                $pSaleDisc   = (float)($p['sale_discount'] ?? ($p['sale_price'] ?? 0));
                $pCustBase   = !empty($p['customer_price']) ? (float)$p['customer_price'] : (float)($p['retail_price'] ?? ($p['price'] ?? 0));
                $pDispPrice  = max(0, $pCustBase - $pSaleDisc);
                $pStrikePrice = ($pSaleDisc > 0) ? $pCustBase : (float)($p['mrp'] ?? ($p['old_price'] ?? 0));
                $pDiscountPct = ($pStrikePrice > $pDispPrice && $pStrikePrice > 0) ? (int)round((($pStrikePrice - $pDispPrice) / $pStrikePrice) * 100) : 0;
            ?>
            <article
                class="product-card"
                role="listitem"
                data-product-id="<?= (int)$p['id'] ?>"
                data-category="<?= htmlspecialchars((string)($p['category'] ?? '')) ?>"
                data-price="<?= (float)$pDispPrice ?>"
                data-color="<?= htmlspecialchars((string)($p['color'] ?? '')) ?>"
                data-size="<?= htmlspecialchars($size_str) ?>"
                data-fabric="<?= htmlspecialchars((string)($p['fabric'] ?? '')) ?>"
                data-discount="<?= (int)$pDiscountPct ?>"
                data-has-video="<?= $pHasVideo ? '1' : '0' ?>"
                data-stock="<?= !empty($p['in_stock']) ? 'In Stock' : 'Pre-Order' ?>"
                aria-label="<?= htmlspecialchars($pName) ?>"
            >
                <div class="card-image-wrap">
                    <a href="/product.php?id=<?= (int)$p['id'] ?>" style="display:block;width:100%;height:100%;">
                        <img src="<?= htmlspecialchars($pImg) ?>" alt="<?= htmlspecialchars($pName) ?>" class="card-img" loading="lazy"<?= $pHasPhoto ? '' : ' style="object-fit:contain;padding:18%;opacity:.6;"' ?> />
                    </a>

                    <?php if (!empty($p['badge'])): ?>
                    <span class="card-badge <?= $badge_class ?>"><?= htmlspecialchars((string)$p['badge']) ?></span>
                    <?php endif; ?>

                    <?php if ($pHasVideo): ?>
                    <span class="card-video-tag" title="This product has a video" style="position:absolute;top:10px;right:52px;z-index:3;display:inline-flex;align-items:center;gap:3px;background:rgba(24,21,18,.82);color:#fff;font-size:10px;font-weight:700;letter-spacing:.4px;padding:3px 7px;border-radius:20px;">
                        <svg viewBox="0 0 24 24" width="9" height="9" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>VIDEO
                    </span>
                    <?php endif; ?>

                    <button class="card-wishlist-btn" data-id="<?= (int)$p['id'] ?>" aria-label="Wishlist <?= htmlspecialchars($pName) ?>" aria-pressed="false">
                        <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    </button>

                    <button class="card-mobile-qv-btn quick-view-btn" data-id="<?= (int)$p['id'] ?>" aria-label="Quick View <?= htmlspecialchars($pName) ?>">
                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>

                    <div class="card-quick-view" aria-hidden="true">
                        <button class="quick-view-btn" data-id="<?= (int)$p['id'] ?>">Quick View</button>
                    </div>

                    <!-- Share Button on Photo (Directly Above Category Tag) -->
                    <button type="button" class="card-share-btn" data-id="<?= (int)$p['id'] ?>" aria-label="Share <?= htmlspecialchars($pName) ?>" title="Share <?= htmlspecialchars($pName) ?>" onclick="event.stopPropagation();event.preventDefault();if(typeof window.shareProductCard==='function'){window.shareProductCard(<?= (int)$p['id'] ?>);}">
                        <svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                    </button>

                    <!-- Category Box on Photo Bottom-Right Corner -->
                    <?php if (trim((string)($p['category'] ?? '')) !== ''): ?>
                    <span class="card-cat-photo-tag"><?= htmlspecialchars((string)$p['category']) ?></span>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <!-- Product Title -->
                    <h2 class="card-name">
                        <a href="/product.php?id=<?= (int)$p['id'] ?>" style="color:inherit;text-decoration:none;">
                            <?= htmlspecialchars($pName) ?>
                        </a>
                    </h2>

                    <!-- Colours and sizes, from product_variants only -->
                    <?php if (!empty($pCols) || !empty($pSizes)): ?>
                    <div class="card-info-text-row">
                        <?php if (!empty($pCols)): ?>
                        <span class="card-colors-text" title="<?= htmlspecialchars(implode(', ', $pCols)) ?>"><?= count($pCols) ?> Colour<?= count($pCols) === 1 ? '' : 's' ?></span>
                        <?php endif; ?>
                        <?php if (!empty($pSizes)): ?>
                        <span class="card-sizes-text"><?= htmlspecialchars(implode(', ', $pSizes)) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <div class="card-price-row">
                        <?php if ($pDispPrice > 0): ?>
                        <span class="card-price">&#8377;<?= number_format($pDispPrice) ?></span>
                        <?php else: ?>
                        <span class="card-price" style="font-size:.82em;">Price on request</span>
                        <?php endif; ?>
                        <?php if ($pStrikePrice > $pDispPrice && $pDispPrice > 0): ?>
                        <span class="card-old-price">&#8377;<?= number_format($pStrikePrice) ?></span>
                        <?php endif; ?>
                        <?php if ($pSaleDisc > 0): ?>
                        <span class="card-price-discount" style="background:#FEF3C7; color:#B45309; font-weight:800; font-size:10px; padding:2px 6px; border-radius:3px;">SAVE &#8377;<?= (int)$pSaleDisc ?></span>
                        <?php elseif ($pDiscountPct > 0): ?>
                        <span class="card-price-discount"><?= $pDiscountPct ?>% OFF</span>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
            </div>

            <!-- No Products Found Message -->
            <div class="no-products-found" id="noProductsMsg" style="<?= $total_products === 0 ? '' : 'display:none;' ?>">
                <h3 class="np-title">No Matching Products</h3>
                <p class="np-desc"><?= $total_products === 0 && $selectedCategory !== '' && strtolower($selectedCategory) !== 'all'
                    ? 'Nothing is listed under &ldquo;' . htmlspecialchars($selectedCategory) . '&rdquo; yet.'
                    : "We couldn't find any items matching your selected filter criteria." ?></p>
                <button class="np-reset-btn" id="npResetBtn">Clear All Filters</button>
            </div>
        </main>

    </div><!-- /.products-area -->
    </div><!-- /.shop-layout -->
</div><!-- /.page-wrapper -->

<!-- ════════════ QUICK VIEW PARTIAL ════════════ -->
<?php include_once __DIR__ . '/shared/quickview.php'; ?>

<!-- ════════════ SMART WHATSAPP SHARE MODAL ════════════ -->
<?php include_once __DIR__ . '/shared/smartshare.php'; ?>

<!-- ════════════ TOAST ════════════ -->
<div class="toast-container" id="toastContainer" aria-live="assertive" aria-atomic="true"></div>

<!-- ════════════ BOTTOM BAR PARTIAL ════════════ -->
<?php include_once __DIR__ . '/includes/shopbottomfotoer.php'; ?>

<!-- ════════════ MASTER SCRIPT ENGINE ════════════ -->
<script>
        window.shopProductsData = <?= json_encode(array_values($products)) ?>;
    </script>
    <script src="/assets/js/shop.js?v=1787019062"></script>

<!-- ════════════ INSTAGRAM REELS VIDEO FEED PARTIAL ════════════ -->
<?php include_once __DIR__ . '/shared/reels.php'; ?>

<!-- ════════════ CART PARTIAL ════════════ -->
<?php include_once __DIR__ . '/shared/cart.php'; ?>

<!-- ════════════ WISHLIST PARTIAL ════════════ -->
<?php include_once __DIR__ . '/shared/wishlist.php'; ?>

<!-- ════════════ CHECKOUT MODAL & ORDER SYSTEM ════════════ -->
<?php include_once __DIR__ . '/shared/checkout.php'; ?>

<!-- ════════════ ACCOUNT & AUTH MODAL SYSTEM ════════════ -->
<?php include_once __DIR__ . '/shared/account.php'; ?>

<?php include_once __DIR__ . '/shared/size_chart_modal.php'; ?>
</body>
</html>
