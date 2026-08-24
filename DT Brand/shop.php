<?php
/**
 * DT Brand/shop.php — Master E-Commerce Shop Page
 * DT Brand's & Jai Hanuman Tex
 */

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/ProductCatalog.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$products = ProductCatalog::getAll();
$categoriesDetails = ProductCatalog::getCategoriesWithDetails();
$selectedCategory = isset($_GET['category']) ? $_GET['category'] : 'All';
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="Shop all authentic pure handloom sarees, kurtis, and ethnic wear direct from Surat mills at DT Brand's." />
    <title>Shop Collections &bull; DT Brand's &bull; Jai Hanuman Tex</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="/DT Brand/assets/css/main.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/DT Brand/assets/css/header.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/DT Brand/assets/css/shop.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/DT Brand/assets/css/modals.css?v=<?= time() ?>">

    <script>
        window.allProducts = <?= json_encode(array_values($products)) ?>;
        window.allCategories = <?= json_encode($categoriesDetails) ?>;
        window.initialCategory = "<?= htmlspecialchars($selectedCategory) ?>";
        window.initialSearch = "<?= htmlspecialchars($searchQuery) ?>";
    </script>
</head>
<body>

    <!-- Master Header with Amazon-Style Search & Attached Gold Subnav -->
    <?php include_once __DIR__ . '/includes/header.php'; ?>

    <main class="dt-shop-main" style="padding-top:16px;">

        <!-- Category Rail Carousel -->
        <section class="dt-category-rail-section">
            <div class="dt-category-rail-track" id="dtCatRailTrack">
                <button type="button" class="dt-cat-circle-item <?= (empty($selectedCategory) || strtolower($selectedCategory) === 'all') ? 'active' : '' ?>" data-cat="All" onclick="filterByBanner('All')">
                    <div class="dt-cat-circle-ring">
                        <div class="dt-cat-circle-inner">
                            <span class="cat-icon">✦</span>
                        </div>
                    </div>
                    <span class="dt-cat-circle-label">All Collections</span>
                </button>
                <?php foreach ($categoriesDetails as $cat): 
                    $isActive = (strtolower($selectedCategory) === strtolower($cat['name']) || strtolower(str_replace('-', ' ', $selectedCategory)) === strtolower($cat['name']));
                ?>
                <button type="button" class="dt-cat-circle-item <?= $isActive ? 'active' : '' ?>" data-cat="<?= htmlspecialchars($cat['name']) ?>" onclick="filterByBanner('<?= htmlspecialchars(addslashes($cat['name'])) ?>')">
                    <div class="dt-cat-circle-ring">
                        <div class="dt-cat-circle-inner">
                            <img src="<?= htmlspecialchars($cat['image']) ?>" alt="<?= htmlspecialchars($cat['name']) ?>" loading="lazy" />
                        </div>
                    </div>
                    <span class="dt-cat-circle-label"><?= htmlspecialchars($cat['name']) ?></span>
                </button>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Shop Layout: Sidebar + Master Product Grid -->
        <section class="dt-shop-layout">
            
            <!-- Left Sidebar Filter -->
            <aside class="dt-filter-sidebar">
                <div class="dt-sf-header">
                    <h3 class="dt-sf-title">Filter Collections</h3>
                    <button type="button" class="dt-sf-clear-btn" onclick="clearAllFilters()">Reset All</button>
                </div>

                <!-- Fabric Filter -->
                <div class="dt-sf-section">
                    <div class="dt-sf-section-header">Fabric Type</div>
                    <div class="dt-sf-chips">
                        <button type="button" class="dt-sf-chip" data-group="fabric" data-val="Silk">Pure Silk</button>
                        <button type="button" class="dt-sf-chip" data-group="fabric" data-val="Cotton">Mulmul Cotton</button>
                        <button type="button" class="dt-sf-chip" data-group="fabric" data-val="Organza">Glass Organza</button>
                        <button type="button" class="dt-sf-chip" data-group="fabric" data-val="Georgette">Viscose Georgette</button>
                        <button type="button" class="dt-sf-chip" data-group="fabric" data-val="Velvet">Micro Velvet</button>
                    </div>
                </div>

                <!-- Price Slider -->
                <div class="dt-sf-section">
                    <div class="dt-sf-section-header">Maximum Price</div>
                    <div class="dt-price-slider-wrap">
                        <div class="dt-price-display-row">
                            <span>₹500</span>
                            <span id="dtPriceMaxDisplay">₹35,000</span>
                        </div>
                        <input type="range" class="dt-range-input" id="dtPriceRange" min="500" max="35000" step="500" value="35000" />
                    </div>
                </div>

                <!-- Color Swatches -->
                <div class="dt-sf-section">
                    <div class="dt-sf-section-header">Color Palette</div>
                    <div class="dt-sf-swatches">
                        <div class="dt-swatch-pill" data-color="Red"><span class="dt-swatch-dot" style="background:#DC2626;"></span> Red</div>
                        <div class="dt-swatch-pill" data-color="Gold"><span class="dt-swatch-dot" style="background:#D4AF37;"></span> Gold</div>
                        <div class="dt-swatch-pill" data-color="Blue"><span class="dt-swatch-dot" style="background:#1D4ED8;"></span> Blue</div>
                        <div class="dt-swatch-pill" data-color="Green"><span class="dt-swatch-dot" style="background:#15803D;"></span> Green</div>
                        <div class="dt-swatch-pill" data-color="Yellow"><span class="dt-swatch-dot" style="background:#EAB308;"></span> Yellow</div>
                        <div class="dt-swatch-pill" data-color="Wine"><span class="dt-swatch-dot" style="background:#701A75;"></span> Wine</div>
                    </div>
                </div>

            </aside>

            <!-- Products Grid Area -->
            <div class="dt-products-area">
                <div class="dt-products-top-bar">
                    <div class="dt-ptb-count" id="dtPtbCount">Showing <?= count($products) ?> Products</div>
                    <div class="dt-ptb-sort-wrap">
                        <span class="dt-ptb-sort-label">Sort By:</span>
                        <select class="dt-ptb-sort-select" id="dtPtbSortSelect">
                            <option value="recommended">Recommended</option>
                            <option value="price_asc">Price: Low to High</option>
                            <option value="price_desc">Price: High to Low</option>
                            <option value="discount">Highest Discount</option>
                        </select>
                    </div>
                </div>

                <!-- Active Filter Tags Bar -->
                <div class="dt-active-tags-bar" id="dtActiveTagsBar"></div>

                <!-- Master Products Grid -->
                <div class="dt-products-grid" id="dtProductsGrid">
                    <?php foreach ($products as $p): ?>
                    <div class="dt-product-card" 
                        data-id="<?= $p['id'] ?>"
                        data-category="<?= htmlspecialchars($p['category']) ?>"
                        data-fabric="<?= htmlspecialchars($p['fabric'] ?? '') ?>"
                        data-price="<?= $p['price'] ?>"
                        data-colors="<?= htmlspecialchars(implode(',', $p['colors'] ?? [])) ?>"
                        data-sizes="<?= htmlspecialchars(implode(',', $p['size'] ?? [])) ?>"
                        data-title="<?= htmlspecialchars($p['title'] ?? $p['name']) ?>"
                        data-sku="<?= htmlspecialchars($p['sku'] ?? '') ?>"
                        data-discount="<?= $p['discount'] ?? 0 ?>"
                    >
                        <div class="dt-card-img-wrap">
                            <span class="dt-card-badge"><?= htmlspecialchars($p['badge'] ?? 'Bestseller') ?></span>
                            
                            <button type="button" class="dt-card-wishlist-btn" onclick="toggleWishlist(<?= htmlspecialchars(json_encode($p)) ?>)" aria-label="Save to Wishlist">
                                <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                            </button>

                            <button type="button" class="dt-card-share-btn" onclick="openSmartShare(<?= $p['id'] ?>)" aria-label="Share on WhatsApp">
                                <svg viewBox="0 0 24 24"><path fill="#15803D" d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2z"/></svg>
                            </button>

                            <span class="dt-card-cat-tag"><?= htmlspecialchars($p['category']) ?></span>

                            <a href="/DT Brand/product.php?id=<?= $p['id'] ?>">
                                <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name'] ?? $p['title']) ?>" class="dt-card-img" loading="lazy" />
                            </a>
                        </div>

                        <div class="dt-card-body">
                            <a href="/DT Brand/product.php?id=<?= $p['id'] ?>" class="dt-card-title"><?= htmlspecialchars($p['name'] ?? $p['title']) ?></a>
                            
                            <div class="dt-card-info-row">
                                <span>★ <?= $p['rating'] ?? '4.9' ?> (<?= $p['reviews_count'] ?? 120 ?>)</span>
                                <span>&bull;</span>
                                <span><?= htmlspecialchars($p['fabric'] ?? 'Pure Silk') ?></span>
                            </div>

                            <div class="dt-card-price-row">
                                <span class="dt-card-price">₹<?= number_format($p['price']) ?></span>
                                <?php if (!empty($p['old_price'])): ?>
                                <span class="dt-card-old-price">₹<?= number_format($p['old_price']) ?></span>
                                <span class="dt-card-discount"><?= $p['discount'] ?>% OFF</span>
                                <?php endif; ?>
                            </div>

                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:6px; margin-top:10px;">
                                <button type="button" class="dt-btn-gold" style="padding:6px 8px; font-size:0.75rem;" onclick="addToCart(<?= htmlspecialchars(json_encode($p)) ?>, 1, 'single')">
                                    <span>Add to Bag</span>
                                </button>
                                <button type="button" class="dt-btn-pale" style="padding:6px 8px; font-size:0.75rem;" onclick="openQuickView(<?= $p['id'] ?>)">
                                    <span>Quick View</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>

        </section>

    </main>

    <!-- Master Footer -->
    <?php include_once __DIR__ . '/includes/footer.php'; ?>

    <!-- Mobile Floating Bottom App Bar -->
    <?php include_once __DIR__ . '/includes/mobile_bottom_nav.php'; ?>

    <!-- Shared Modals (Cart, Wishlist, Checkout, Auth, QuickView, SmartShare, Reels) -->
    <?php include_once __DIR__ . '/shared/cart_drawer.php'; ?>
    <?php include_once __DIR__ . '/shared/wishlist_drawer.php'; ?>
    <?php include_once __DIR__ . '/shared/checkout_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/auth_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/quickview_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/smart_share_modal.php'; ?>
    <?php include_once __DIR__ . '/shared/reels_modal.php'; ?>

    <!-- Master Scripts -->
    <script src="/DT Brand/assets/js/core.js?v=<?= time() ?>"></script>
    <script src="/DT Brand/assets/js/header.js?v=<?= time() ?>"></script>
    <script src="/DT Brand/assets/js/shop.js?v=<?= time() ?>"></script>
    <script src="/DT Brand/assets/js/modals.js?v=<?= time() ?>"></script>

</body>
</html>
