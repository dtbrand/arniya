<?php
/**
 * singleproduct.php — Dedicated Luxury Single Product Page (PDP)
 * Fully responsive on Mobile and Desktop with touch-swipe gallery,
 * Size Chart Modal, Pincode Estimator, WhatsApp Order, and Cart Integration.
 */

require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

// ── Dynamic Database-First PDP Catalog Loader ──
$catalogProducts = ProductCatalog::getAll();
$products = [];
foreach ($catalogProducts as $cp) {
    $products[$cp['id']] = $cp;
}
if (empty($products)) {
$products = [
    1 => [
        'id'       => 1,
        'name'     => 'Nilambari Silk Saree',
        'category' => 'Sarees',
        'price'    => 4899,
        'old_price'=> 6500,
        'discount' => 25,
        'image'    => '/Frontend/Single-Product/Asset/images/product1.png',
        'badge'    => 'New',
        'rating'   => 4.8,
        'reviews'  => 142,
        'color'    => 'Navy',
        'colors'   => ['Navy', 'Royal Blue', 'Midnight Black'],
        'size'     => ['Free Size', 'M', 'L'],
        'fabric'   => 'Pure Kanchipuram Silk',
        'in_stock' => true,
        'sku'      => 'KN-SAR-001',
        'desc'     => 'An exquisite masterpiece from our Royal Heritage edit. The Nilambari Silk Saree features pure gold zari brocade work along the pallu, finished with artisanal floral buttas and rich temple borders.'
    ],
    2 => [
        'id'       => 2,
        'name'     => 'Banarasi Zari Saree',
        'category' => 'Sarees',
        'price'    => 8499,
        'old_price'=> 11000,
        'discount' => 23,
        'image'    => '/Frontend/Single-Product/Asset/images/product2.png',
        'badge'    => 'Bestseller',
        'rating'   => 4.9,
        'reviews'  => 218,
        'color'    => 'Maroon',
        'colors'   => ['Maroon', 'Deep Wine', 'Ruby Red'],
        'size'     => ['Free Size', 'S', 'M'],
        'fabric'   => 'Pure Banarasi Katan Silk',
        'in_stock' => true,
        'sku'      => 'KN-SAR-002',
        'desc'     => 'Handwoven in Varanasi using centuries-old kadhwa weaving techniques. Adorned with delicate antique gold floral jaal, this saree exudes regal Indian heritage.'
    ],
    3 => [
        'id'       => 3,
        'name'     => 'Kanjivaram Temple Silk',
        'category' => 'Sarees',
        'price'    => 12999,
        'old_price'=> 16500,
        'discount' => 21,
        'image'    => '/Frontend/Single-Product/Asset/images/product3.png',
        'badge'    => 'Heritage',
        'rating'   => 5.0,
        'reviews'  => 96,
        'color'    => 'Yellow',
        'colors'   => ['Yellow', 'Golden Ochre', 'Emerald Green'],
        'size'     => ['Free Size', 'L', 'XL'],
        'fabric'   => 'Pure Mulberry Silk (3-Ply)',
        'in_stock' => true,
        'sku'      => 'KN-SAR-003',
        'desc'     => 'Woven with three-ply twisted silk yarn and dipped in pure metallic gold zari. Features monumental temple gopuram motifs along the double-wide contrast border.'
    ],
    4 => [
        'id'       => 4,
        'name'     => 'Georgette Bloom Saree',
        'category' => 'Sarees',
        'price'    => 3299,
        'old_price'=> 4200,
        'discount' => 21,
        'image'    => '/Frontend/Single-Product/Asset/images/product4.png',
        'badge'    => null,
        'rating'   => 4.6,
        'reviews'  => 74,
        'color'    => 'Pink',
        'colors'   => ['Pink', 'Blush Peach', 'Rose'],
        'size'     => ['Free Size', 'S', 'M', 'L'],
        'fabric'   => 'Viscose Georgette',
        'in_stock' => true,
        'sku'      => 'KN-SAR-004',
        'desc'     => 'Lightweight, fluid, and romantic. Decorated with hand-embroidered resham florals and delicate scalloped borders for celebratory evening soirees.'
    ],
    5 => [
        'id'       => 5,
        'name'     => 'Royal Anarkali Kurti',
        'category' => 'Kurtis',
        'price'    => 2799,
        'old_price'=> 3900,
        'discount' => 28,
        'image'    => '/Frontend/Single-Product/Asset/images/product5.png',
        'badge'    => 'New',
        'rating'   => 4.7,
        'reviews'  => 89,
        'color'    => 'Green',
        'colors'   => ['Green', 'Teal', 'Mint'],
        'size'     => ['XS', 'S', 'M', 'L', 'XL'],
        'fabric'   => 'Chanderi Silk Cotton',
        'in_stock' => true,
        'sku'      => 'KN-KUR-005',
        'desc'     => 'Flared 32-kali royal floor-length anarkali silhouette with intricate gota patti handwork on the yoke and bell sleeves.'
    ],
    6 => [
        'id'       => 6,
        'name'     => 'Bridal Zardosi Lehenga',
        'category' => 'Lehengas',
        'price'    => 24999,
        'old_price'=> 32000,
        'discount' => 22,
        'image'    => '/Frontend/Single-Product/Asset/images/product6.png',
        'badge'    => 'Bridal',
        'rating'   => 5.0,
        'reviews'  => 310,
        'color'    => 'Red',
        'colors'   => ['Red', 'Crimson', 'Maroon'],
        'size'     => ['S', 'M', 'L', 'XL'],
        'fabric'   => 'Raw Silk & Velvet Dupatta',
        'in_stock' => true,
        'sku'      => 'KN-LEH-006',
        'desc'     => 'A couture bridal creation featuring 180 hours of meticulous dabka, nakshi, and zardozi bullion embroidery over deep crimson silk, complete with dual dupattas.'
    ],
    7 => [
        'id'       => 7,
        'name'     => 'Mustard Block Print Saree',
        'category' => 'Sarees',
        'price'    => 1899,
        'old_price'=> 2600,
        'discount' => 27,
        'image'    => '/Frontend/Single-Product/Asset/images/product7.png',
        'badge'    => null,
        'rating'   => 4.5,
        'reviews'  => 56,
        'color'    => 'Orange',
        'colors'   => ['Orange', 'Mustard', 'Rust Gold'],
        'size'     => ['Free Size', 'M'],
        'fabric'   => 'Mulmul Cotton',
        'in_stock' => true,
        'sku'      => 'KN-SAR-007',
        'desc'     => 'Authentic Bagru hand block printed natural vegetable dyes on airy mulmul cotton. Perfect for daytime cultural gatherings and warm weather celebrations.'
    ],
    8 => [
        'id'       => 8,
        'name'     => 'Ivory Designer Gown',
        'category' => 'Gowns',
        'price'    => 7499,
        'old_price'=> 9500,
        'discount' => 21,
        'image'    => '/Frontend/Single-Product/Asset/images/product8.png',
        'badge'    => 'Trending',
        'rating'   => 4.8,
        'reviews'  => 115,
        'color'    => 'White',
        'colors'   => ['White', 'Ivory', 'Pearl Cream'],
        'size'     => ['S', 'M', 'L', 'XXL'],
        'fabric'   => 'Organza & Silk Crepe',
        'in_stock' => true,
        'sku'      => 'KN-GWN-008',
        'desc'     => 'Dramatic cape-sleeved indo-western evening gown embellished with swarovski crystals and tone-on-tone pearl embroidery.'
    ],
];
}

// Resolve requested product ID, SKU, or Slug
$pid = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
$sku = isset($_GET['sku']) ? trim($_GET['sku']) : '';

$product = null;
if (!empty($sku)) {
    $product = ProductCatalog::getBySku($sku);
}
if (!$product && !empty($slug)) {
    foreach ($catalogProducts as $cp) {
        if (($cp['slug'] ?? '') === $slug) {
            $product = $cp;
            break;
        }
    }
}
if (!$product) {
    $product = ProductCatalog::getById($pid) ?? ($products[$pid] ?? reset($products));
}

// Generate dynamic gallery images and video media from database
$pName = $product['name'] ?? 'Royal Ethnic Saree';
$pdpNoImage = '/assets/images/no-image.svg';

$pdpImages = [];
$rawImgs = array_merge(
    (array)($product['gallery'] ?? []),
    (array)($product['images'] ?? []),
    [!empty($product['image']) ? $product['image'] : '']
);
foreach ($rawImgs as $mImg) {
    $mImg = trim((string)$mImg);
    if ($mImg !== '' && strpos($mImg, 'no-image.svg') === false && substr($mImg, 0, 5) !== 'data:') {
        if (!in_array($mImg, $pdpImages, true)) {
            $pdpImages[] = $mImg;
        }
    }
}
if ($pdpImages === []) {
    $pdpImages[] = $product['image'] ?? '/Frontend/Single-Product/Asset/images/product1.png';
}
$pdpPoster = $pdpImages[0];
$galleryImages = $pdpImages;

// Dynamic Product Videos
$pdpVideos = [];
$rawVids = array_merge(
    (array)($product['videos'] ?? []),
    [!empty($product['video']) ? $product['video'] : '']
);
foreach ($rawVids as $mVid) {
    $mVid = trim((string)$mVid);
    if ($mVid !== '' && substr($mVid, 0, 5) !== 'data:') {
        if (!in_array($mVid, $pdpVideos, true)) {
            $pdpVideos[] = ['kind' => 'video', 'src' => $mVid];
        }
    }
}
foreach ((array)($product['embeds'] ?? []) as $mEmb) {
    $mEmb = trim((string)$mEmb);
    if ($mEmb !== '') {
        $pdpVideos[] = ['kind' => 'embed', 'src' => $mEmb];
    }
}
if (!empty($product['embed'])) {
    $pdpVideos[] = ['kind' => 'embed', 'src' => trim((string)$product['embed'])];
}
$pdpHasVideos = !empty($pdpVideos);
$pdpVideoCount = count($pdpVideos);
$pdpHasMedia = !empty($pdpImages);

// Dynamic Product Specifications from Database
$currentSpecs = [
    ['title' => 'Category', 'val' => $product['category'] ?? 'Silk Sarees'],
    ['title' => 'Fabric', 'val' => $product['fabric'] ?? 'Pure Silk'],
    ['title' => 'Weave / Craft', 'val' => $product['weave'] ?? 'Handloom Korvai'],
    ['title' => 'Primary Color', 'val' => $product['color'] ?? 'Royal Silk'],
    ['title' => 'Blouse Fabric', 'val' => 'Matching Silk Blouse Piece Included'],
    ['title' => 'Border Style', 'val' => 'Pure Tested Gold Zari Jacquard'],
    ['title' => 'Wash Care', 'val' => 'Dry Clean Only'],
    ['title' => 'Net Quantity', 'val' => '1 Piece (With Silk Mark Certification)'],
];

// Dynamic Product Details (Design Details, Size & Fit, Material & Care) from Database
$currentDetails = [
    'design_lines' => [
        htmlspecialchars($product['title'] ?? ($product['name'] ?? 'Royal Ethnic Saree')),
        !empty($product['description']) ? htmlspecialchars($product['description']) : 'Authentic Surat handloom creation woven with pure tested zari and contrast border.',
        'Fabric: ' . htmlspecialchars($product['fabric'] ?? 'Pure Silk'),
        'Weave: ' . htmlspecialchars($product['weave'] ?? 'Handloom Korvai'),
        'Includes unstitched blouse piece with matching border',
        'Direct Surat Factory Wholesale Authenticity Guaranteed'
    ],
    'size_fit' => [
        'Saree Length: 5.5 metres plus 0.8 metre blouse piece',
        'Width: 1.06 metres (approx.)',
        'Available sizes: ' . implode(', ', (array)($product['size'] ?? ['Free Size (6.3m)', 'M', 'L']))
    ],
    'material_care' => [
        'Fabric: ' . htmlspecialchars($product['fabric'] ?? 'Pure Silk'),
        'Wash Care: Dry Clean Only',
        'Origin: Surat Mill Handcrafted'
    ]
];

$customerReviews = [
    [
        'id' => 1,
        'name' => 'Priya Sharma',
        'city' => 'Mumbai, MH',
        'rating' => 5,
        'date' => '2 days ago',
        'occasion' => 'Wedding Sangeet',
        'text' => 'The fabric quality and real zari weave is breathtaking! Arrived in luxury royal gift packaging within 3 days to Mumbai. Wore it for my cousin’s sangeet and received endless compliments.',
        'photo' => '/Frontend/Single-Product/Asset/images/product1.png',
        'helpful' => 38
    ],
    [
        'id' => 2,
        'name' => 'Ananya Mehta',
        'city' => 'Surat, Gujarat',
        'rating' => 5,
        'date' => '4 days ago',
        'occasion' => 'Diwali Festive Puja',
        'text' => 'Exactly as depicted in the photos. The silk drape feels extremely luxurious, pure, and lightweight. The WhatsApp styling concierge was very helpful with size selection.',
        'photo' => '/Frontend/Single-Product/Asset/images/product1.png',
        'helpful' => 29
    ],
    [
        'id' => 3,
        'name' => 'Dr. Radhika Iyer',
        'city' => 'Bengaluru, KA',
        'rating' => 5,
        'date' => '1 week ago',
        'occasion' => 'Temple Inauguration',
        'text' => 'Authentic handloom craftsmanship. You can tell the zari is high standard and pure. Stitching of the blouse piece was flawless. Highly recommend DT Brand\'s!',
        'photo' => null,
        'helpful' => 21
    ],
    [
        'id' => 4,
        'name' => 'Sneha Singhania',
        'city' => 'Delhi NCR',
        'rating' => 5,
        'date' => '1 week ago',
        'occasion' => 'Reception Night',
        'text' => 'The color is deep, royal, and rich under evening chandelier lighting. Everyone asked where I purchased it from. Fast express delivery with zero hassle.',
        'photo' => '/Frontend/Single-Product/Asset/images/product1.png',
        'helpful' => 44
    ],
    [
        'id' => 5,
        'name' => 'Kavita Patel',
        'city' => 'London, UK',
        'rating' => 5,
        'date' => '2 weeks ago',
        'occasion' => 'International Wedding',
        'text' => 'Ordered from London with international DHL shipping. Reached in 5 business days in pristine condition! Truly magnificent quality and authentic silk sheen.',
        'photo' => '/Frontend/Single-Product/Asset/images/product1.png',
        'helpful' => 52
    ],
    [
        'id' => 6,
        'name' => 'Meera Deshmukh',
        'city' => 'Pune, MH',
        'rating' => 4,
        'date' => '3 weeks ago',
        'occasion' => 'Engagement Ceremony',
        'text' => 'Beautiful attire! Heavy royal border and very comfortable to wear all night. Delivery was smooth and packaging was top notch.',
        'photo' => null,
        'helpful' => 17
    ],
    [
        'id' => 7,
        'name' => 'Ritu Kothari',
        'city' => 'Jaipur, RJ',
        'rating' => 5,
        'date' => '1 month ago',
        'occasion' => 'Sister’s Haldi',
        'text' => 'Outstanding royal craftsmanship! The zari sheen is so authentic and looks 10x better in person than online. Everyone at the event kept asking about DT Brand\'s.',
        'photo' => '/Frontend/Single-Product/Asset/images/product1.png',
        'helpful' => 31
    ]
];

$colorHex = [
    'Navy' => '#1B2A4A', 'Royal Blue' => '#204B8C', 'Midnight Black' => '#1A1A1A',
    'Maroon' => '#6D1A24', 'Deep Wine' => '#4A1521', 'Ruby Red' => '#9E1B32',
    'Yellow' => '#E5A93B', 'Golden Ochre' => '#C68B29', 'Emerald Green' => '#1E5E3A',
    'Pink' => '#E88B9E', 'Blush Peach' => '#F4B2A0', 'Rose' => '#D46A84',
    'Green' => '#2D6A4F', 'Teal' => '#1D6870', 'Mint' => '#74B39B',
    'Red' => '#B22222', 'Crimson' => '#DC143C', 'Orange' => '#D96B27',
    'Mustard' => '#C88A24', 'Rust Gold' => '#A85A1D', 'White' => '#FAF8F5',
    'Ivory' => '#FFFFF0', 'Pearl Cream' => '#EFEBD9'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?= htmlspecialchars($product['name']) ?> — DT Brand's | Ethnic Luxury</title>
<meta name="description" content="<?= htmlspecialchars(substr($product['desc'], 0, 160)) ?>" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

<link rel="stylesheet" href="/Frontend/Single-Product/Asset/css/singleproduct.css?v=1787019062">

    <!-- ════════════ GLOBAL PRODUCTS & MODAL ENGINE BOOTSTRAP ════════════ -->
    <script>
        window.allProducts = <?php echo json_encode(isset($catalogProducts) ? $catalogProducts : (isset($products) ? $products : [])); ?>;
        window.catalogProducts = window.allProducts;
        window.products = window.allProducts;
        window.openQuickView = function(id) { if(typeof window.openQV === 'function') window.openQV(id); };
        window.openQuickViewModal = function(id) { if(typeof window.openQV === 'function') window.openQV(id); };
    </script>
</head>
<body>

<!-- ════════════ HEADER PARTIAL ════════════ -->
<?php include_once __DIR__ . '/Includes/singelproduthader.php'; ?>

<!-- ════════════ MAIN PRODUCT DETAIL CONTENT ════════════ -->
<main class="pdp-main-wrapper">
    <div class="pdp-layout-grid">
        
        <!-- ── Left: Interactive Swipeable Gallery ── -->
        <div class="pdp-gallery-column">
            <div class="pdp-gallery-slider" id="pdpGallerySlider">
                <?php if (!empty($product['badge'])): ?>
                <span class="pdp-badge-tag"><?= htmlspecialchars($product['badge']) ?></span>
                <?php endif; ?>

                <button class="pdp-zoom-btn" title="View Fullscreen Image" onclick="openFullscreenImage()" aria-label="Zoom Image">
                    <svg viewBox="0 0 24 24"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>
                </button>

                <!-- Navigation Arrows (Desktop) -->
                <button class="pdp-slider-arrow prev" id="pdpSlidePrev" aria-label="Previous image" onclick="slidePdpGallery(-1)">
                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <button class="pdp-slider-arrow next" id="pdpSlideNext" aria-label="Next image" onclick="slidePdpGallery(1)">
                    <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </button>

                <!-- Swipeable Track -->
                <div class="pdp-slider-track" id="pdpSliderTrack">
                    <?php if (!$pdpHasMedia): ?>
                    <div class="pdp-slide pdp-slide-empty" data-idx="0">
                        <img src="<?= htmlspecialchars($pdpNoImage) ?>" alt="" style="opacity:.45;" />
                        <span class="pdp-empty-media-note">No photo has been uploaded for this product yet.</span>
                    </div>
                    <?php else: ?>
                    <?php foreach ($pdpImages as $index => $img): ?>
                    <div class="pdp-slide" data-idx="<?= $index ?>">
                        <img
                            src="<?= htmlspecialchars($img) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?> - View <?= $index + 1 ?>"
                            onError="this.src='/Frontend/Single-Product/Asset/images/product1.png'"
                            onclick="openFullscreenImage(<?= $index ?>)"
                            style="cursor: zoom-in;"
                        />
                    </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- 3D Luxury HD Video Pill (Compact & Sleek Sizing) -->
                <?php if ($pdpHasVideos): ?>
                <button type="button" class="pdp-3d-reel-btn" id="pdp3dVideoBtn" onclick="openProductVideosReel(window.currentProductData || <?= htmlspecialchars(json_encode($product, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP), ENT_QUOTES, 'UTF-8') ?>)" aria-label="Watch HD Video">
                    <div class="pdp-3d-pulse-glow"></div>
                    <div class="pdp-3d-btn-capsule">
                        <div class="pdp-3d-icon-disc">
                            <svg viewBox="0 0 24 24" class="pdp-3d-play-svg"><polygon points="7 4 19 12 7 20 7 4"/></svg>
                        </div>
                        <span class="pdp-3d-btn-text">Watch Video <?= $pdpVideoCount > 1 ? '(' . $pdpVideoCount . ')' : '' ?></span>
                        <span class="pdp-3d-live-dot" title="Available in HD"></span>
                    </div>
                </button>
                <?php endif; ?>

                <!-- Slide Index Counter -->
                <div class="pdp-slide-counter" id="pdpSlideCounter">1 / <?= max(1, count($pdpImages)) ?></div>
            </div>

            <!-- Mobile & Desktop Pagination Dots -->
            <div class="pdp-gallery-dots" id="pdpGalleryDots"></div>

            <!-- Multi-Photo & Video Thumbnails -->
            <?php if (count($pdpImages) > 1 || $pdpHasVideos): ?>
            <div class="pdp-thumbnails-strip" id="pdpThumbnailsStrip">
                <?php foreach ($pdpImages as $index => $img): ?>
                <div class="pdp-thumb-item <?= $index === 0 ? 'active' : '' ?>" data-idx="<?= $index ?>" onclick="goToSlide(<?= $index ?>)" title="View Photo <?= $index + 1 ?>">
                    <img src="<?= htmlspecialchars($img) ?>" alt="Thumb <?= $index + 1 ?>" onError="this.src='/Frontend/Single-Product/Asset/images/product1.png'" />
                </div>
                <?php endforeach; ?>
                <?php if ($pdpHasVideos): ?>
                <?php foreach ($pdpVideos as $vIdx => $vItem): ?>
                <div class="pdp-thumb-item pdp-thumb-video" onclick="openProductVideosReel(window.currentProductData || <?= htmlspecialchars(json_encode($product, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP), ENT_QUOTES, 'UTF-8') ?>)" title="Watch Video <?= $vIdx + 1 ?>" aria-label="Watch Video <?= $vIdx + 1 ?>">
                    <img src="<?= htmlspecialchars($pdpPoster) ?>" alt="Video <?= $vIdx + 1 ?>" onError="this.src='/Frontend/Single-Product/Asset/images/product1.png'" />
                    <div class="pdp-thumb-play-overlay">
                        <svg viewBox="0 0 24 24"><polygon points="6 3 20 12 6 21 6 3"/></svg>
                    </div>
                    <div class="pdp-thumb-video-badge">
                        <svg viewBox="0 0 24 24" class="pdp-thumb-video-svg"><polygon points="6 3 20 12 6 21 6 3"/></svg>
                        <span>VIDEO</span>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- ── Right: Product Details & Conversion Actions ── -->
        <div class="pdp-details-column">
            <div>
                <span class="pdp-brand-tag">DT BRAND'S ETHNIC LUXURY</span>
                <h1 class="pdp-title"><?= htmlspecialchars($product['name']) ?></h1>
            </div>

            <!-- Rating Row -->
            <div class="pdp-rating-row">
                <div class="pdp-rating-pill">
                    <span>★ <?= number_format($product['rating'], 1) ?></span>
                </div>
                <span class="pdp-review-count"><?= $product['reviews'] ?> Verified Reviews</span>
                <span class="pdp-sku-badge">SKU: <?= htmlspecialchars($product['sku']) ?></span>
            </div>

            <!-- Price Card (Next-Level Luxury & Clear Visibility) -->
            <div class="pdp-price-card">
                <div class="pdp-price-main-row">
                    <span class="pdp-price-val">₹<?= number_format($product['price']) ?></span>
                    <?php if (!empty($product['old_price'])): ?>
                    <span class="pdp-mrp-val">MRP ₹<?= number_format($product['old_price']) ?></span>
                    <?php endif; ?>
                    <?php if (!empty($product['discount'])): ?>
                    <span class="pdp-discount-badge"><?= $product['discount'] ?>% OFF</span>
                    <?php endif; ?>
                </div>
                <div class="pdp-tax-line">
                    <span>Inclusive of all taxes</span> • <span class="green">⚡ Fast Delivery in 3–5 Days</span>
                </div>
                <!-- Animated Luxury Perks Strip -->
                <div class="pdp-animated-perks-strip">
                    <div class="pdp-perk-badge">
                        <svg viewBox="0 0 24 24" class="pdp-perk-svg pulse" fill="currentColor"><path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/></svg>
                        <span class="pdp-perk-text">100% Handloom Silk</span>
                    </div>
                    <div class="pdp-perk-badge">
                        <svg viewBox="0 0 24 24" class="pdp-perk-svg flash" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        <span class="pdp-perk-text">Fast 24-48h Dispatch</span>
                    </div>
                    <div class="pdp-perk-badge">
                        <svg viewBox="0 0 24 24" class="pdp-perk-svg spin" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                        <span class="pdp-perk-text">7-Day Easy Exchange</span>
                    </div>
                    <div class="pdp-perk-badge">
                        <svg viewBox="0 0 24 24" class="pdp-perk-svg" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="8" width="18" height="13" rx="2"/><path d="M12 8v13"/><path d="M19 12H5"/><path d="M12 3a3 3 0 0 0-3 3v2h6V6a3 3 0 0 0-3-3z"/></svg>
                        <span class="pdp-perk-text">Royal Gift Packaging</span>
                    </div>
                </div>
            </div>

            <!-- Colour Swatches -->
            <div>
                <div class="pdp-section-header">
                    <span>SELECT COLOUR: <strong class="pdp-selected-txt" id="pdpSelectedColorName"><?= htmlspecialchars($product['colors'][0] ?? 'Standard') ?></strong></span>
                </div>
                <div class="pdp-color-swatches" id="pdpColorSwatches">
                    <?php foreach ($product['colors'] as $idx => $c): ?>
                    <?php $hex = $colorHex[$c] ?? '#8A681F'; ?>
                    <button
                        class="pdp-color-btn <?= $idx === 0 ? 'active' : '' ?>"
                        data-color="<?= htmlspecialchars($c) ?>"
                        style="background-color: <?= $hex ?>;"
                        title="<?= htmlspecialchars($c) ?>"
                        onclick="selectPdpColor(this)"
                    ></button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Size Selector -->
            <div>
                <div class="pdp-section-header">
                    <span>SELECT SIZE</span>
                    <span class="pdp-size-guide-link" onclick="openSizeGuideModal()">📏 View Size Chart</span>
                </div>
                <div class="pdp-size-grid" id="pdpSizeGrid">
                    <?php foreach ($product['size'] as $idx => $s): ?>
                    <button class="pdp-size-btn <?= $idx === 0 ? 'active' : '' ?>" data-size="<?= htmlspecialchars($s) ?>" onclick="selectPdpSize(this)">
                        <?= htmlspecialchars($s) ?>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Actions (Quantity, Add to Bag, Buy Now) -->
            <div class="pdp-actions-container">
                <div class="pdp-qty-row">
                    <span style="font-size:0.75rem; font-weight:800; text-transform:uppercase; letter-spacing:0.06em;">Quantity:</span>
                    <div class="pdp-qty-box">
                        <button class="pdp-qty-btn" onclick="updatePdpQty(-1)">−</button>
                        <span class="pdp-qty-num" id="pdpQtyVal">1</span>
                        <button class="pdp-qty-btn" onclick="updatePdpQty(1)">+</button>
                    </div>
                </div>

                <div class="pdp-btn-row">
                    <button class="pdp-atc-btn" onclick="handlePdpAddToCart()">
                        <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                        <span>Add To Bag</span>
                    </button>

                    <button class="pdp-buy-btn" onclick="handlePdpBuyNow()">
                        <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        <span>Buy Now</span>
                    </button>
                </div>

                <!-- Direct WhatsApp Order Checkout Trigger -->
                <button
                    type="button"
                    class="pdp-wa-order-btn"
                    onclick="openPdpWhatsAppOrderModal()"
                    aria-label="Instant Order via WhatsApp"
                >
                    <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    <span>Instant Order via WhatsApp</span>
                </button>
            </div>

            <!-- Pincode Delivery Estimator -->
            <div class="pdp-delivery-box">
                <div class="pdp-del-title">
                    <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    <span>Check Estimated Delivery & COD</span>
                </div>
                <div class="pdp-pincode-input-row">
                    <input type="text" id="pdpPincodeInput" class="pdp-pincode-input" placeholder="Enter 6-digit Pincode (e.g. 395002)" maxlength="6" />
                    <button class="pdp-pincode-btn" onclick="checkPincodeDelivery()">Check</button>
                </div>
                <div class="pdp-pincode-result" id="pdpPincodeResult"></div>
            </div>

            <!-- Accordion Details & Specifications -->
            <div class="pdp-accordion-wrap">
                <!-- 1. Product Details (Myntra Style) -->
                <div class="pdp-acc-item open">
                    <button type="button" class="pdp-acc-header" onclick="togglePdpAcc(this)" aria-expanded="true">
                        <div class="pdp-acc-title-group">
                            <div class="pdp-acc-icon-box">
                                <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                            </div>
                            <span class="pdp-acc-title-text">Product Details</span>
                        </div>
                        <div class="pdp-acc-chevron-wrap">
                            <svg viewBox="0 0 24 24" class="pdp-acc-chevron"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </button>
                    <div class="pdp-acc-body">
                        <div class="pdp-myntra-details-wrap">
                            <!-- Design Details -->
                            <div class="pdp-myntra-section-block">
                                <h4 class="pdp-myntra-heading">Design Details</h4>
                                <div class="pdp-myntra-list">
                                    <?php foreach ($currentDetails['design_lines'] as $line): ?>
                                    <div class="pdp-myntra-list-item"><?= htmlspecialchars($line) ?></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Size & Fit -->
                            <div class="pdp-myntra-section-block">
                                <h4 class="pdp-myntra-heading">Size & Fit</h4>
                                <div class="pdp-myntra-list">
                                    <?php foreach ($currentDetails['size_fit'] as $sf): ?>
                                    <div class="pdp-myntra-list-item"><?= htmlspecialchars($sf) ?></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Material & Care -->
                            <div class="pdp-myntra-section-block">
                                <h4 class="pdp-myntra-heading">Material & Care</h4>
                                <div class="pdp-myntra-list">
                                    <?php foreach ($currentDetails['material_care'] as $mc): ?>
                                    <div class="pdp-myntra-list-item"><?= htmlspecialchars($mc) ?></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Specifications -->
                <div class="pdp-acc-item">
                    <button type="button" class="pdp-acc-header" onclick="togglePdpAcc(this)" aria-expanded="false">
                        <div class="pdp-acc-title-group">
                            <div class="pdp-acc-icon-box">
                                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                            </div>
                            <span class="pdp-acc-title-text">Fabric & Garment Specifications</span>
                        </div>
                        <div class="pdp-acc-chevron-wrap">
                            <svg viewBox="0 0 24 24" class="pdp-acc-chevron"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </button>
                    <div class="pdp-acc-body">
                        <div class="pdp-myntra-spec-grid">
                            <?php foreach ($currentSpecs as $spec): ?>
                            <div class="pdp-myntra-spec-cell">
                                <span class="pdp-myntra-spec-title"><?= htmlspecialchars($spec['title']) ?></span>
                                <span class="pdp-myntra-spec-val"><?= htmlspecialchars($spec['val']) ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- 3. Fast Delivery, 100% Original & Fast Exchange -->
                <div class="pdp-acc-item">
                    <button type="button" class="pdp-acc-header" onclick="togglePdpAcc(this)" aria-expanded="false">
                        <div class="pdp-acc-title-group">
                            <div class="pdp-acc-icon-box">
                                <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                            </div>
                            <span class="pdp-acc-title-text">Fast Delivery, 100% Original & Fast Exchange</span>
                        </div>
                        <div class="pdp-acc-chevron-wrap">
                            <svg viewBox="0 0 24 24" class="pdp-acc-chevron"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </button>
                    <div class="pdp-acc-body">
                        <div class="pdp-trust-cards-list">
                            <div class="pdp-trust-mini-card gold">
                                <div class="pdp-trust-mini-icon">
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/></svg>
                                </div>
                                <div class="pdp-trust-mini-text">
                                    <h5>100% Original Certified Handloom</h5>
                                    <p>Authentic ethnic couture directly sourced from DT Brand's master weavers with silk authenticity guarantee.</p>
                                </div>
                            </div>
                            <div class="pdp-trust-mini-card green">
                                <div class="pdp-trust-mini-icon">
                                    <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                                </div>
                                <div class="pdp-trust-mini-text">
                                    <h5>⚡ Fast Express Priority Dispatch</h5>
                                    <p>Dispatched within 24–48 hours with live SMS/WhatsApp shipment tracking across 19,000+ Indian pincodes.</p>
                                </div>
                            </div>
                            <div class="pdp-trust-mini-card blue">
                                <div class="pdp-trust-mini-icon">
                                    <svg viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                                </div>
                                <div class="pdp-trust-mini-text">
                                    <h5>💎 7-Day Fast Doorstep Exchange</h5>
                                    <p>Zero-hassle size or fit exchanges arranged instantly with doorstep pickup via our dedicated WhatsApp concierge.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ════ CUSTOMER REVIEWS & RATINGS BREAKDOWN ════ -->
    <section class="pdp-reviews-section" id="pdpReviewsSection">
        <h2 class="pdp-section-title-large">Verified Customer Reviews</h2>
        
        <div class="pdp-rev-header-grid">
            <div class="pdp-overall-score">
                <div class="pdp-big-rating"><?= number_format($product['rating'], 1) ?></div>
                <div class="pdp-big-stars">★★★★★</div>
                <div class="pdp-score-sub">Based on <?= $product['reviews'] ?> verified buyer reviews</div>
            </div>

            <div class="pdp-bars-wrap">
                <div class="pdp-bar-row"><span>5 Star</span><div class="pdp-bar-track"><div class="pdp-bar-fill" style="width: 88%;"></div></div><span>88%</span></div>
                <div class="pdp-bar-row"><span>4 Star</span><div class="pdp-bar-track"><div class="pdp-bar-fill" style="width: 9%;"></div></div><span>9%</span></div>
                <div class="pdp-bar-row"><span>3 Star</span><div class="pdp-bar-track"><div class="pdp-bar-fill" style="width: 2%;"></div></div><span>2%</span></div>
                <div class="pdp-bar-row"><span>2 Star</span><div class="pdp-bar-track"><div class="pdp-bar-fill" style="width: 1%;"></div></div><span>1%</span></div>
                <div class="pdp-bar-row"><span>1 Star</span><div class="pdp-bar-track"><div class="pdp-bar-fill" style="width: 0%;"></div></div><span>0%</span></div>
            </div>

            <div style="display:flex; flex-direction:column; gap:10px; align-items:flex-end;">
                <button class="pdp-write-rev-btn" onclick="openWriteReviewModal()">
                    <span>✍️ Write a Review</span>
                </button>
            </div>
        </div>

        <!-- Auto-Sliding Carousel Wrapper -->
        <div class="pdp-reviews-carousel-wrap" id="pdpRevCarouselWrap">
            <button class="pdp-rev-arrow prev" id="pdpRevPrev" aria-label="Previous review" onclick="slidePdpReviews(-1)">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button class="pdp-rev-arrow next" id="pdpRevNext" aria-label="Next review" onclick="slidePdpReviews(1)">
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </button>

            <div class="pdp-reviews-track" id="pdpReviewsTrack">
                <?php foreach ($customerReviews as $idx => $rev): ?>
                <?php 
                $initial = strtoupper(substr($rev['name'], 0, 1));
                ?>
                <article class="pdp-review-card" data-rating="<?= $rev['rating'] ?>">
                    <div class="pdp-rc-top">
                        <div class="pdp-rc-avatar"><?= $initial ?></div>
                        <div class="pdp-rc-meta">
                            <div class="pdp-rc-name">
                                <span><?= htmlspecialchars($rev['name']) ?></span>
                            </div>
                            <span class="pdp-rc-loc-date"><?= htmlspecialchars($rev['city']) ?> • <?= htmlspecialchars($rev['date']) ?></span>
                        </div>
                        <div class="pdp-rc-rating-right">
                            <span class="pdp-verified-badge">✓ Verified</span>
                            <div class="pdp-rc-stars"><?= str_repeat('★', $rev['rating']) ?></div>
                        </div>
                    </div>

                    <?php if (!empty($rev['occasion'])): ?>
                    <span class="pdp-rc-occasion">✨ <?= htmlspecialchars($rev['occasion']) ?></span>
                    <?php endif; ?>

                    <p class="pdp-rc-text">
                        "<?= htmlspecialchars($rev['text']) ?>"
                    </p>

                    <div class="pdp-rc-bottom">
                        <span>Helpful?</span>
                        <button class="pdp-rc-helpful-btn" onclick="toggleHelpful(this, <?= (int)$rev['helpful'] ?>)">
                            <span>👍</span>
                            <span>(<?= (int)$rev['helpful'] ?>)</span>
                        </button>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>

            <!-- Dots -->
            <div class="pdp-rev-dots" id="pdpRevDots"></div>
        </div>
    </section>

    <!-- ════ RELATED PRODUCTS CAROUSEL ════ -->
    <section class="pdp-bottom-section" id="pdpRelatedSection">
        <h2 class="pdp-section-title-large">You May Also Admire</h2>

        <div class="pdp-rel-carousel-wrap" id="pdpRelCarouselWrap">
            <!-- Navigation Arrows (Desktop) -->
            <button class="pdp-rel-arrow prev" id="pdpRelPrev" aria-label="Previous related products" onclick="slidePdpRelated(-1)">
                <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <button class="pdp-rel-arrow next" id="pdpRelNext" aria-label="Next related products" onclick="slidePdpRelated(1)">
                <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
            </button>

            <!-- Scrollable Track (2-show on mobile) -->
            <div class="pdp-rel-track" id="pdpRelTrack">
                <?php 
                $relatedItems = array_filter($products, function($it) use ($product) { return $it['id'] !== $product['id']; });
                foreach ($relatedItems as $rel):
                ?>
                <a href="/product.php?id=<?= $rel['id'] ?>" class="pdp-rel-card">
                    <div class="pdp-rel-img-wrap">
                        <?php if (!empty($rel['badge'])): ?>
                        <span class="pdp-rel-badge"><?= htmlspecialchars($rel['badge']) ?></span>
                        <?php endif; ?>
                        <img src="<?= htmlspecialchars($rel['image']) ?>" alt="<?= htmlspecialchars($rel['name']) ?>" onError="this.src='/Frontend/Single-Product/Asset/images/product1.png'" loading="lazy" />
                    </div>
                    <div class="pdp-rel-body">
                        <span class="pdp-rel-cat"><?= htmlspecialchars($rel['category']) ?></span>
                        <h3 class="pdp-rel-title"><?= htmlspecialchars($rel['name']) ?></h3>
                        <div class="pdp-rel-price-row">
                            <span class="pdp-rel-price">₹<?= number_format($rel['price']) ?></span>
                            <?php if (!empty($rel['old_price'])): ?>
                            <span class="pdp-rel-mrp">₹<?= number_format($rel['old_price']) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($rel['discount'])): ?>
                            <span class="pdp-rel-disc"><?= $rel['discount'] ?>% OFF</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Dots -->
            <div class="pdp-rel-dots" id="pdpRelDots"></div>
        </div>
    </section>
</main>

<!-- ════ SIZE GUIDE MODAL ════ -->
<div class="pdp-modal-overlay" id="pdpSizeChartModal" role="dialog" aria-modal="true" aria-label="Size Guide">
    <div class="pdp-modal-box">
        <div class="pdp-modal-header">
            <h3 class="pdp-modal-title">📏 Royal Size & Measurement Guide</h3>
            <button class="pdp-modal-close-btn" onclick="closeSizeGuideModal()">&times;</button>
        </div>
        <div class="pdp-modal-body">
            <p style="font-size:0.8rem; color:var(--mid-text); line-height:1.5;">
                All measurements are tailored with standard Indian ethnic comfort allowances. Custom sizing adjustments can also be requested via our WhatsApp stylist.
            </p>
            <table class="pdp-size-table">
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>Bust (Inches)</th>
                        <th>Waist (Inches)</th>
                        <th>Hip (Inches)</th>
                        <th>Garment Length</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td><strong>XS</strong></td><td>32" - 34"</td><td>26" - 28"</td><td>36"</td><td>Standard 54"</td></tr>
                    <tr><td><strong>S</strong></td><td>34" - 36"</td><td>28" - 30"</td><td>38"</td><td>Standard 54"</td></tr>
                    <tr><td><strong>M</strong></td><td>36" - 38"</td><td>30" - 32"</td><td>40"</td><td>Standard 55"</td></tr>
                    <tr><td><strong>L</strong></td><td>38" - 40"</td><td>32" - 34"</td><td>42"</td><td>Standard 55"</td></tr>
                    <tr><td><strong>XL</strong></td><td>40" - 42"</td><td>34" - 36"</td><td>44"</td><td>Standard 56"</td></tr>
                    <tr><td><strong>Free Size</strong></td><td>34" - 44"</td><td>Adjustable</td><td>Free</td><td>Saree 5.5m + 0.8m Blouse</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ════ WRITE A REVIEW MODAL ════ -->
<div class="pdp-modal-overlay" id="pdpWriteReviewModal" role="dialog" aria-modal="true" aria-label="Write a Review">
    <div class="pdp-modal-box" style="max-width: 520px;">
        <div class="pdp-modal-header">
            <h3 class="pdp-modal-title">✍️ Write a Customer Review</h3>
            <button class="pdp-modal-close-btn" onclick="closeWriteReviewModal()">&times;</button>
        </div>
        <div class="pdp-modal-body">
            <form id="pdpReviewForm" onsubmit="submitCustomerReview(event)" style="display:flex; flex-direction:column; gap:14px;">
                <div>
                    <label style="font-size:0.75rem; font-weight:800; text-transform:uppercase; color:var(--dark-text); display:block; margin-bottom:6px;">Your Overall Rating</label>
                    <div id="pdpStarRatingSelector" style="display:flex; gap:6px; font-size:1.6rem; color:#F59E0B; cursor:pointer;">
                        <span data-val="1" onclick="setReviewRating(1)">★</span>
                        <span data-val="2" onclick="setReviewRating(2)">★</span>
                        <span data-val="3" onclick="setReviewRating(3)">★</span>
                        <span data-val="4" onclick="setReviewRating(4)">★</span>
                        <span data-val="5" onclick="setReviewRating(5)">★</span>
                    </div>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; text-transform:uppercase; color:var(--dark-text); display:block; margin-bottom:4px;">Full Name *</label>
                    <input type="text" id="revName" required placeholder="e.g. Radhika Sharma" style="width:100%; height:40px; border:1.5px solid var(--soft-platinum); border-radius:8px; padding:0 12px; font-family:var(--font-sans); font-size:0.85rem;" />
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; text-transform:uppercase; color:var(--dark-text); display:block; margin-bottom:4px;">City / State</label>
                        <input type="text" id="revCity" placeholder="e.g. Mumbai, MH" style="width:100%; height:40px; border:1.5px solid var(--soft-platinum); border-radius:8px; padding:0 12px; font-family:var(--font-sans); font-size:0.85rem;" />
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; text-transform:uppercase; color:var(--dark-text); display:block; margin-bottom:4px;">Occasion Worn</label>
                        <input type="text" id="revOccasion" placeholder="e.g. Wedding Sangeet" style="width:100%; height:40px; border:1.5px solid var(--soft-platinum); border-radius:8px; padding:0 12px; font-family:var(--font-sans); font-size:0.85rem;" />
                    </div>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; text-transform:uppercase; color:var(--dark-text); display:block; margin-bottom:4px;">Your Review Narrative *</label>
                    <textarea id="revText" required rows="3" placeholder="Describe the silk fabric texture, zari brilliance, fitting, and packaging..." style="width:100%; border:1.5px solid var(--soft-platinum); border-radius:8px; padding:10px 12px; font-family:var(--font-sans); font-size:0.85rem; resize:vertical;"></textarea>
                </div>

                <button type="submit" class="pdp-buy-btn" style="width:100%; padding:12px; border-radius:8px; font-size:0.82rem;">Submit Verified Review</button>
            </form>
        </div>
    </div>
</div>

<!-- ════ INSTANT WHATSAPP QUICK ORDER CHECKOUT MODAL ════ -->
<div class="pdp-modal-overlay" id="pdpWhatsAppOrderModal" role="dialog" aria-modal="true" aria-label="Instant WhatsApp Checkout">
    <div class="pdp-wa-modal-box">
        <!-- Brand Header (Matching checkout.php .co-header) -->
        <div class="pdp-wa-co-header">
            <div class="pdp-wa-co-brand">
                <div class="pdp-wa-co-icon">
                    <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                </div>
                <div class="pdp-wa-co-title-group">
                    <h3>DT BRAND'S</h3>
                    <span>Luxury Ethnic • WhatsApp Checkout</span>
                </div>
            </div>
            <button class="pdp-wa-co-close-btn" onclick="closePdpWhatsAppOrderModal()" aria-label="Close">&times;</button>
        </div>

        <div class="pdp-wa-modal-body">
            <!-- Order Item Summary Card (Matching checkout.php) -->
            <div class="pdp-wa-sec-card">
                <div class="pdp-wa-modal-product">
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="pdp-wa-modal-img" id="pdpWaModalImg" />
                    <div class="pdp-wa-modal-info">
                        <div class="pdp-wa-modal-name"><?= htmlspecialchars($product['name']) ?></div>
                        <div class="pdp-wa-modal-meta">
                            <span>Color: <strong id="pdpWaModalColor" style="color:var(--dark-text);"><?= htmlspecialchars($product['colors'][0] ?? 'Standard') ?></strong></span>
                            <span>Size: <strong id="pdpWaModalSize" style="color:var(--dark-text);"><?= htmlspecialchars($product['size'][0] ?? 'Free Size') ?></strong></span>
                            <span>Qty: <strong id="pdpWaModalQty" style="color:var(--dark-text);">1</strong></span>
                        </div>
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-top:2px;">
                            <span class="pdp-wa-modal-price" id="pdpWaModalPrice">₹<?= number_format($product['price']) ?></span>
                            <span style="font-size:0.65rem; color:#2E7D32; font-weight:800; background:#E8F5E9; padding:2px 7px; border-radius:4px;">⚡ Free Delivery (3–5 Days)</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Checkout Form -->
            <form id="pdpWhatsAppOrderForm" onsubmit="submitPdpWhatsAppOrder(event)" style="display:flex; flex-direction:column; gap:12px;">
                
                <!-- Section 1: Customer Contact Details Card (ALWAYS VISIBLE & OPEN) -->
                <div class="pdp-wa-sec-card">
                    <div class="pdp-wa-card-header">
                        <div class="pdp-wa-card-title">
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span>Customer Contact Details</span>
                        </div>
                    </div>

                    <div class="pdp-wa-input-group">
                        <label class="pdp-wa-label" for="pdpWaName">Customer Full Name <span class="required">*</span></label>
                        <input type="text" id="pdpWaName" required placeholder="Enter Customer Full Name (e.g. Priya Sharma)" class="pdp-wa-input" autocomplete="name" />
                    </div>

                    <div class="pdp-wa-input-group">
                        <label class="pdp-wa-label" for="pdpWaPhone">WhatsApp Mobile Number <span class="required">*</span></label>
                        <div class="pdp-wa-phone-wrap">
                            <div class="pdp-wa-phone-prefix">🇮🇳 +91</div>
                            <input type="text" id="pdpWaPhone" required placeholder="98765 43210" class="pdp-wa-input pdp-wa-phone-input" autocomplete="tel" />
                        </div>
                    </div>
                </div>

                <!-- Section 2: Delivery & Billing Address Card (COLLAPSIBLE / OPTIONAL) -->
                <div class="pdp-wa-sec-card pdp-wa-addr-collapse-wrap" id="pdpWaAddrCollapseWrap">
                    <button type="button" class="pdp-wa-addr-toggle-btn" onclick="togglePdpWaAddressSection()" aria-expanded="false">
                        <div class="pdp-wa-card-title">
                            <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                            <span>Delivery & Billing Address</span>
                            <span style="font-size:0.62rem; background:#FAF5E8; color:#8A681F; padding:2px 6px; border-radius:4px; font-weight:700; border:1px solid rgba(138,104,31,0.2);">Optional</span>
                        </div>
                        <span class="pdp-wa-addr-arrow" id="pdpWaAddrArrow" style="font-size:0.75rem; color:#8A681F; transition:transform 0.25s;">▼</span>
                    </button>

                    <div class="pdp-wa-addr-collapsible-body" id="pdpWaAddrBody" style="display:none; flex-direction:column; gap:9px; margin-top:10px; padding-top:8px; border-top:1px dashed rgba(138,104,31,0.25);">
                        <!-- Full Address -->
                        <div class="pdp-wa-input-group">
                            <label class="pdp-wa-label" for="pdpWaAddress">House / Flat No., Street, Landmark</label>
                            <input type="text" id="pdpWaAddress" placeholder="e.g. Flat 402, Royal Palms, Bandra West" class="pdp-wa-input" autocomplete="street-address" />
                        </div>

                        <!-- City, State & Pincode Grid -->
                        <div class="pdp-wa-loc-grid">
                            <div class="pdp-wa-input-group">
                                <label class="pdp-wa-label" for="pdpWaCity">City</label>
                                <input type="text" id="pdpWaCity" placeholder="e.g. Mumbai" class="pdp-wa-input" />
                            </div>
                            <div class="pdp-wa-input-group">
                                <label class="pdp-wa-label" for="pdpWaState">State</label>
                                <input type="text" id="pdpWaState" placeholder="e.g. Maharashtra" class="pdp-wa-input" />
                            </div>
                            <div class="pdp-wa-input-group pdp-wa-col-pin">
                                <label class="pdp-wa-label" for="pdpWaPincode">Pincode</label>
                                <input type="text" id="pdpWaPincode" placeholder="400050" maxlength="8" class="pdp-wa-input" autocomplete="postal-code" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Payment Preference Card (Matching checkout.php) -->
                <div class="pdp-wa-sec-card">
                    <div class="pdp-wa-card-header">
                        <div class="pdp-wa-card-title">
                            <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                            <span>Payment Preference</span>
                        </div>
                    </div>

                    <div class="pdp-wa-payment-grid">
                        <label class="pdp-wa-pay-card selected" id="pdpWaPayCodCard" onclick="selectPdpWaPayment('cod')">
                            <input type="radio" name="pdpWaPayment" id="pdpWaRadioCod" value="Cash on Delivery (COD)" checked style="display:none;" />
                            <div class="pdp-wa-pay-radio"></div>
                            <div class="pdp-wa-pay-icon cod">
                                <svg viewBox="0 0 24 24"><path d="M21 18v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v1"/><polyline points="10 12 14 12 14 16"/><line x1="10" y1="14" x2="14" y2="14"/><rect x="14" y="6" width="7" height="12" rx="2"/></svg>
                            </div>
                            <div style="flex:1;">
                                <div style="font-size:0.75rem; font-weight:800; color:#24211C; line-height:1.2;">Cash on Delivery</div>
                                <div style="font-size:0.62rem; color:#5A5348;">Pay upon arrival</div>
                            </div>
                        </label>

                        <label class="pdp-wa-pay-card" id="pdpWaPayUpiCard" onclick="selectPdpWaPayment('upi')">
                            <input type="radio" name="pdpWaPayment" id="pdpWaRadioUpi" value="UPI on WhatsApp (GPay / PhonePe / Paytm)" style="display:none;" />
                            <div class="pdp-wa-pay-radio"></div>
                            <div class="pdp-wa-pay-icon upi">
                                <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                            </div>
                            <div style="flex:1;">
                                <div style="font-size:0.75rem; font-weight:800; color:#24211C; line-height:1.2;">UPI on WhatsApp</div>
                                <div style="font-size:0.62rem; color:#5A5348;">Instant scan / pay</div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="pdp-wa-submit-btn">
                    <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    <span>Confirm Order & Send to WhatsApp</span>
                </button>

                <!-- Trust Badges Row (All in 1 Single Line on Mobile) -->
                <div class="pdp-wa-trust-row">
                    <span class="pdp-wa-trust-item">🔒 256-Bit Encrypted</span>
                    <span class="pdp-wa-trust-dot">•</span>
                    <span class="pdp-wa-trust-item">⚡ 3–5 Day Delivery</span>
                    <span class="pdp-wa-trust-dot">•</span>
                    <span class="pdp-wa-trust-item">💎 100% Authentic</span>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ════ TOAST CONTAINER ════ -->
<div class="toast-container" id="toastContainer" aria-live="assertive" aria-atomic="true"></div>

<!-- ════ FOOTER PARTIAL ════ -->
<?php include_once __DIR__ . '/Includes/singelprodutbottomfotoer.php'; ?>

<!-- ════ CART DRAWER PARTIAL ════ -->
<?php include_once __DIR__ . '/../../Shared/Includes/quickview.php'; ?>
    <?php include_once __DIR__ . '/../../Shared/Includes/cart.php'; ?>

<!-- ════ WISHLIST DRAWER PARTIAL ════ -->
<?php include_once __DIR__ . '/../../Shared/Includes/wishlist.php'; ?>

<!-- ════ CHECKOUT MODAL PARTIAL ════ -->
<?php include_once __DIR__ . '/../../Shared/Includes/checkout.php'; ?>

<!-- ══════════════════════════════════════════════════════════════
     NEXT-LEVEL LUXURY FULLSCREEN MEDIA VIEWER (LIGHTBOX)
══════════════════════════════════════════════════════════════ -->
<div class="pdp-lightbox-overlay" id="pdpLightboxOverlay" aria-hidden="true" role="dialog" aria-label="Fullscreen Product Media Viewer">
    <!-- Top Header Bar -->
    <div class="pdp-lightbox-header">
        <div class="pdp-lightbox-meta">
            <span class="pdp-lightbox-counter" id="pdpLbCounter">1 / 1</span>
            <span class="pdp-lightbox-title"><?= htmlspecialchars($pName ?? ($product['name'] ?? 'Product View')) ?></span>
        </div>
        <div class="pdp-lightbox-actions">
            <button type="button" class="pdp-lb-act-btn" id="pdpLbZoomOut" onclick="zoomLightbox(-0.25)" title="Zoom Out ( - )" aria-label="Zoom Out">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
            </button>
            <button type="button" class="pdp-lb-act-btn" id="pdpLbZoomIn" onclick="zoomLightbox(0.25)" title="Zoom In ( + )" aria-label="Zoom In">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
            </button>
            <button type="button" class="pdp-lb-act-btn" id="pdpLbZoomReset" onclick="resetLightboxZoom()" title="Reset View" aria-label="Reset View">
                <svg viewBox="0 0 24 24"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>
            </button>
            <button type="button" class="pdp-lb-close-btn" id="pdpLbCloseBtn" onclick="closeFullscreenImage()" title="Close Viewer (Esc)" aria-label="Close">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
    </div>

    <!-- Main Stage Track -->
    <div class="pdp-lightbox-stage" id="pdpLbStage">
        <button type="button" class="pdp-lb-nav-btn prev" id="pdpLbPrev" onclick="navigateLightbox(-1)" aria-label="Previous Media">
            <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        </button>

        <div class="pdp-lightbox-viewport" id="pdpLbViewport">
            <div class="pdp-lightbox-slider" id="pdpLbSlider"></div>
        </div>

        <button type="button" class="pdp-lb-nav-btn next" id="pdpLbNext" onclick="navigateLightbox(1)" aria-label="Next Media">
            <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
        </button>
    </div>

    <!-- Bottom Thumbnail Strip -->
    <div class="pdp-lightbox-footer" id="pdpLbFooter">
        <div class="pdp-lightbox-thumbs-strip" id="pdpLbThumbs"></div>
    </div>
</div>

<!-- ════ SCRIPT ENGINE ════ -->
<script>
    window.currentProductData = <?= json_encode($product, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
    window.totalSlidesCount = <?= max(1, count($pdpImages)) ?>;
    window.pdpVideosData = <?= json_encode($pdpVideos, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
    window.pdpWhatsAppNumber = '917046363528';
</script>
<script src="/Frontend/Single-Product/Asset/js/singleproduct.js?v=<?= time() ?>"></script>

<!-- ════════════ SMART WHATSAPP SHARE & REELS MODALS ════════════ -->
<?php include_once __DIR__ . '/../../Shared/Includes/smartshare.php'; ?>
<?php include_once __DIR__ . '/../../Shared/Includes/reels.php'; ?>
<?php include_once __DIR__ . '/../../Shared/Includes/account.php'; ?>

</body>
</html>
