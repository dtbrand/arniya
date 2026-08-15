<?php
/**
 * singelprodut.php — Dedicated Luxury Single Product Page (PDP)
 * Fully responsive on Mobile and Desktop with touch-swipe gallery,
 * Size Chart Modal, Pincode Estimator, WhatsApp Order, and Cart Integration.
 */

$products = [
    1 => [
        'id'       => 1,
        'name'     => 'Nilambari Silk Saree',
        'category' => 'Sarees',
        'price'    => 4899,
        'old_price'=> 6500,
        'discount' => 25,
        'image'    => 'images/product1.png',
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
        'image'    => 'images/product2.png',
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
        'image'    => 'images/product3.png',
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
        'image'    => 'images/product4.png',
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
        'image'    => 'images/product5.png',
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
        'image'    => 'images/product6.png',
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
        'image'    => 'images/product7.png',
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
        'image'    => 'images/product8.png',
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

// Resolve requested product ID (Default to #1)
$pid = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$product = $products[$pid] ?? $products[1];

// Generate variation gallery images
$galleryImages = [
    $product['image'],
    'https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=800&q=80',
    'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?auto=format&fit=crop&w=800&q=80'
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
<title><?= htmlspecialchars($product['name']) ?> — Kalaniketan | Ethnic Luxury</title>
<meta name="description" content="<?= htmlspecialchars(substr($product['desc'], 0, 160)) ?>" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

<style>
/* ── Design Tokens ── */
:root {
    --off-white:      #F8F6F0;
    --off-white-2:    #F2EFE8;
    --dark-gold:      #8A681F;
    --deep-gold:      #6F5218;
    --gold-pale:      #FAF3E0;
    --gold-border:    rgba(138,104,31,0.25);
    --soft-platinum:  #E5E3DE;
    --dark-text:      #24211C;
    --mid-text:       #5A5348;
    --light-text:     #9A9490;
    --font-serif:     'Cinzel', serif;
    --font-sans:      'Inter', sans-serif;
    --transition:     0.28s cubic-bezier(0.4, 0, 0.2, 1);
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body {
    background: var(--off-white);
    font-family: var(--font-sans);
    color: var(--dark-text);
    -webkit-font-smoothing: antialiased;
    overflow-x: hidden;
}
img { display: block; max-width: 100%; }
a { text-decoration: none; color: inherit; }
button { font-family: inherit; cursor: pointer; border: none; background: none; }

/* ── Main Layout ── */
.pdp-main-wrapper {
    max-width: 1240px;
    margin: 0 auto;
    padding: clamp(14px, 3vw, 32px) clamp(12px, 3vw, 28px);
}

.pdp-layout-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: clamp(20px, 4vw, 48px);
    align-items: start;
}
@media (min-width: 900px) {
    .pdp-layout-grid {
        grid-template-columns: 48% 52%;
    }
}

/* ════════════════════════════════════════════════════
   LEFT COLUMN: TOUCH-SWIPEABLE GALLERY & SLIDER
════════════════════════════════════════════════════ */
.pdp-gallery-column {
    display: flex;
    flex-direction: column;
    gap: 14px;
    position: sticky;
    top: 80px;
}

/* Main Image Slider Viewport */
.pdp-gallery-slider {
    position: relative;
    border-radius: 14px;
    overflow: hidden;
    background: var(--off-white-2);
    aspect-ratio: 3/4;
    border: 1.5px solid var(--gold-border);
    box-shadow: 0 8px 30px rgba(0,0,0,0.06);
}

/* Swipeable Track */
.pdp-slider-track {
    display: flex;
    width: 100%;
    height: 100%;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scrollbar-width: none;
    -webkit-overflow-scrolling: touch;
}
.pdp-slider-track::-webkit-scrollbar { display: none; }

.pdp-slide {
    flex: 0 0 100%;
    width: 100%;
    height: 100%;
    scroll-snap-align: start;
    position: relative;
    overflow: hidden;
}
.pdp-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top;
    transition: transform 0.3s ease;
    cursor: zoom-in;
}

/* Slide Counter Badge (Mobile) */
.pdp-slide-counter {
    position: absolute;
    bottom: 14px;
    right: 14px;
    background: rgba(24, 21, 18, 0.75);
    backdrop-filter: blur(6px);
    color: #FFFFFF;
    font-size: 0.72rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    letter-spacing: 0.08em;
    z-index: 5;
}

/* Slider Navigation Arrows */
.pdp-slider-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 38px; height: 38px;
    border-radius: 50%;
    background: rgba(255,255,255,0.9);
    border: 1px solid var(--gold-border);
    color: var(--dark-gold);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    z-index: 6;
    transition: all 0.2s;
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}
.pdp-slider-arrow:hover {
    background: var(--dark-gold);
    color: #FFFFFF;
}
.pdp-slider-arrow.prev { left: 12px; }
.pdp-slider-arrow.next { right: 12px; }
.pdp-slider-arrow svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2.4; }

@media (max-width: 767px) {
    .pdp-slider-arrow { display: none; }
}

/* Badge Tag */
.pdp-badge-tag {
    position: absolute;
    top: 14px; left: 14px;
    background: var(--dark-gold);
    color: #FFFFFF;
    font-size: 0.68rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.12em;
    padding: 5px 12px;
    border-radius: 4px;
    z-index: 5;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

/* Fullscreen Zoom Trigger Icon */
.pdp-zoom-btn {
    position: absolute;
    top: 14px; right: 14px;
    width: 36px; height: 36px;
    border-radius: 50%;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(4px);
    border: 1px solid var(--gold-border);
    color: var(--dark-gold);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    z-index: 5;
    transition: all 0.2s;
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}
.pdp-zoom-btn:hover {
    background: var(--dark-gold);
    color: #FFFFFF;
    transform: scale(1.08);
}
.pdp-zoom-btn svg { width: 17px; height: 17px; stroke: currentColor; fill: none; stroke-width: 2.2; }

/* Thumbnails Strip */
.pdp-thumbnails-strip {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    padding: 2px;
    scrollbar-width: none;
}
.pdp-thumbnails-strip::-webkit-scrollbar { display: none; }
.pdp-thumb-item {
    width: 72px;
    height: 94px;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid var(--soft-platinum);
    background: var(--off-white-2);
    cursor: pointer;
    flex-shrink: 0;
    opacity: 0.65;
    transition: all 0.25s ease;
}
.pdp-thumb-item:hover {
    opacity: 0.95;
    border-color: var(--dark-gold);
}
.pdp-thumb-item.active {
    opacity: 1;
    border-color: var(--dark-gold);
    box-shadow: 0 4px 14px rgba(138,104,31,0.28);
    transform: translateY(-2px);
}
.pdp-thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top;
}

/* ════════════════════════════════════════════════════
   RIGHT COLUMN: PRODUCT DETAILS & CONVERSION ACTIONS
════════════════════════════════════════════════════ */
.pdp-details-column {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.pdp-brand-tag {
    font-size: 0.68rem;
    font-weight: 800;
    color: var(--dark-gold);
    letter-spacing: 0.18em;
    text-transform: uppercase;
}
.pdp-title {
    font-family: var(--font-serif);
    font-size: clamp(1.35rem, 3.5vw, 1.95rem);
    font-weight: 800;
    color: var(--dark-text);
    line-height: 1.25;
}

/* Ratings Badge */
.pdp-rating-row {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 0.8rem;
    flex-wrap: wrap;
}
.pdp-rating-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 10px;
    border-radius: 14px;
    background: #1B5E20;
    color: #FFFFFF;
    font-weight: 800;
    font-size: 0.76rem;
}
.pdp-rating-pill svg { width: 13px; height: 13px; fill: #FFFFFF; }
.pdp-review-count {
    color: var(--mid-text);
    font-weight: 600;
}
.pdp-sku-badge {
    margin-left: auto;
    font-size: 0.68rem;
    color: var(--light-text);
    font-weight: 700;
    letter-spacing: 0.06em;
}

/* Price Block */
.pdp-price-card {
    background: #FFFFFF;
    border: 1.5px solid var(--gold-border);
    border-radius: 12px;
    padding: 16px 20px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.03);
}
.pdp-price-main-row {
    display: flex;
    align-items: baseline;
    gap: 12px;
    flex-wrap: wrap;
}
.pdp-price-val {
    font-size: clamp(1.6rem, 4vw, 2.1rem);
    font-weight: 900;
    color: var(--dark-gold);
}
.pdp-mrp-val {
    font-size: 0.95rem;
    color: var(--light-text);
    text-decoration: line-through;
    font-weight: 500;
}
.pdp-discount-badge {
    font-size: 0.82rem;
    font-weight: 800;
    color: #8A681F;
    background: var(--gold-pale);
    padding: 4px 10px;
    border-radius: 6px;
    border: 1px solid var(--gold-border);
}
.pdp-tax-note {
    font-size: 0.72rem;
    color: #2E7D32;
    font-weight: 700;
    margin-top: 4px;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Color Options */
.pdp-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.78rem;
    font-weight: 800;
    color: var(--dark-text);
    letter-spacing: 0.08em;
    text-transform: uppercase;
    margin-bottom: 8px;
}
.pdp-selected-txt {
    color: var(--dark-gold);
    font-weight: 800;
}

.pdp-color-swatches {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
.pdp-color-btn {
    width: 34px; height: 34px;
    border-radius: 50%;
    border: 2.5px solid #FFFFFF;
    outline: 1.5px solid var(--soft-platinum);
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
}
.pdp-color-btn:hover {
    outline-color: var(--dark-gold);
    transform: scale(1.12);
}
.pdp-color-btn.active {
    outline: 2.5px solid var(--dark-gold);
    box-shadow: 0 0 0 3px rgba(138,104,31,0.25), 0 4px 10px rgba(0,0,0,0.2);
    transform: scale(1.15);
}

/* Size Options */
.pdp-size-grid {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.pdp-size-btn {
    min-width: 48px; height: 42px;
    border-radius: 9px;
    border: 1.8px solid var(--soft-platinum);
    background: #FFFFFF;
    font-size: 0.84rem;
    font-weight: 800;
    color: var(--dark-text);
    display: flex; align-items: center; justify-content: center;
    padding: 0 14px;
    transition: all 0.2s ease;
}
.pdp-size-btn:hover {
    border-color: var(--dark-gold);
    color: var(--dark-gold);
}
.pdp-size-btn.active {
    border-color: var(--dark-gold);
    background: var(--dark-gold);
    color: #FFFFFF;
    box-shadow: 0 4px 12px rgba(138,104,31,0.3);
}

.pdp-size-guide-link {
    font-size: 0.74rem;
    font-weight: 700;
    color: var(--dark-gold);
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s;
}
.pdp-size-guide-link:hover { text-decoration: underline; }

/* Quantity & Action CTAs */
.pdp-actions-container {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 6px;
}
.pdp-qty-row {
    display: flex;
    align-items: center;
    gap: 14px;
}
.pdp-qty-box {
    display: inline-flex;
    align-items: center;
    border: 1.8px solid var(--soft-platinum);
    border-radius: 8px;
    background: #FFFFFF;
    overflow: hidden;
}
.pdp-qty-btn {
    width: 36px; height: 38px;
    background: #FAF8F4;
    font-size: 1rem;
    font-weight: 800;
    color: var(--dark-gold);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    transition: background 0.15s;
}
.pdp-qty-btn:hover { background: var(--gold-pale); }
.pdp-qty-num {
    width: 40px;
    text-align: center;
    font-size: 0.88rem;
    font-weight: 800;
}

.pdp-btn-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
.pdp-atc-btn {
    padding: 14px 20px;
    border-radius: 9px;
    border: 2px solid var(--dark-gold);
    background: #FAF4E6;
    color: var(--dark-gold);
    font-family: var(--font-sans);
    font-size: 0.88rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: all 0.2s ease;
    cursor: pointer;
}
.pdp-atc-btn:hover {
    background: #F5E8C8;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(138,104,31,0.2);
}
.pdp-atc-btn svg { width: 19px; height: 19px; stroke: currentColor; fill: none; stroke-width: 2.2; }

.pdp-buy-btn {
    padding: 14px 20px;
    border-radius: 9px;
    border: none;
    background: linear-gradient(135deg, var(--dark-gold) 0%, var(--deep-gold) 100%);
    color: #FFFFFF;
    font-family: var(--font-sans);
    font-size: 0.88rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    box-shadow: 0 4px 16px rgba(138,104,31,0.32);
    transition: all 0.2s ease;
    cursor: pointer;
}
.pdp-buy-btn:hover {
    background: var(--deep-gold);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(138,104,31,0.45);
}
.pdp-buy-btn svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2.2; }

/* Direct WhatsApp Order CTA */
.pdp-wa-order-btn {
    width: 100%;
    padding: 13px;
    border-radius: 9px;
    background: #25D366;
    color: #FFFFFF;
    font-weight: 800;
    font-size: 0.85rem;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    text-decoration: none;
    box-shadow: 0 4px 14px rgba(37,211,102,0.3);
    transition: all 0.2s ease;
}
.pdp-wa-order-btn:hover {
    background: #128C7E;
    transform: translateY(-2px);
}
.pdp-wa-order-btn svg { width: 19px; height: 19px; fill: currentColor; }

/* Pincode Delivery Estimator */
.pdp-delivery-box {
    background: #FFFFFF;
    border: 1.5px solid var(--soft-platinum);
    border-radius: 12px;
    padding: 16px;
}
.pdp-del-title {
    font-size: 0.78rem;
    font-weight: 800;
    color: var(--dark-text);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 10px;
}
.pdp-del-title svg { width: 18px; height: 18px; stroke: var(--dark-gold); fill: none; stroke-width: 2; }
.pdp-pincode-input-row {
    display: flex;
    gap: 8px;
}
.pdp-pincode-input {
    flex: 1;
    height: 40px;
    border: 1.5px solid var(--soft-platinum);
    border-radius: 8px;
    padding: 0 14px;
    font-family: var(--font-sans);
    font-size: 0.86rem;
    font-weight: 600;
    outline: none;
}
.pdp-pincode-input:focus {
    border-color: var(--dark-gold);
}
.pdp-pincode-btn {
    padding: 0 18px;
    height: 40px;
    border-radius: 8px;
    background: var(--dark-gold);
    color: #FFFFFF;
    font-size: 0.8rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    cursor: pointer;
    transition: all 0.2s;
}
.pdp-pincode-btn:hover { background: var(--deep-gold); }
.pdp-pincode-result {
    font-size: 0.76rem;
    font-weight: 600;
    margin-top: 10px;
    display: none;
    line-height: 1.4;
}

/* Accordion / Specifications */
.pdp-accordion-wrap {
    border-top: 1.5px solid var(--soft-platinum);
    margin-top: 6px;
}
.pdp-acc-item {
    border-bottom: 1.5px solid var(--soft-platinum);
}
.pdp-acc-header {
    width: 100%;
    padding: 14px 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.84rem;
    font-weight: 800;
    color: var(--dark-text);
    text-transform: uppercase;
    letter-spacing: 0.06em;
    cursor: pointer;
}
.pdp-acc-icon {
    font-size: 1.1rem;
    color: var(--dark-gold);
    transition: transform 0.25s ease;
}
.pdp-acc-item.open .pdp-acc-icon { transform: rotate(180deg); }
.pdp-acc-body {
    display: none;
    padding: 0 0 16px;
    font-size: 0.82rem;
    color: var(--mid-text);
    line-height: 1.65;
}
.pdp-acc-item.open .pdp-acc-body { display: block; }

.pdp-specs-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-top: 8px;
}
.pdp-spec-box {
    background: #FFFFFF;
    border: 1px solid var(--soft-platinum);
    border-radius: 8px;
    padding: 10px 12px;
}
.pdp-spec-lbl {
    font-size: 0.65rem;
    font-weight: 800;
    color: var(--dark-gold);
    text-transform: uppercase;
    display: block;
    margin-bottom: 2px;
}
.pdp-spec-val {
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--dark-text);
}

/* ════════════════════════════════════════════════════
   CUSTOMER REVIEWS & BREAKDOWN SECTION
════════════════════════════════════════════════════ */
.pdp-reviews-section {
    margin-top: clamp(36px, 5vw, 60px);
    background: #FFFFFF;
    border: 1.5px solid var(--gold-border);
    border-radius: 16px;
    padding: clamp(20px, 4vw, 36px);
}
.pdp-rev-header-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
    border-bottom: 1.5px solid var(--soft-platinum);
    padding-bottom: 24px;
}
@media (min-width: 768px) {
    .pdp-rev-header-grid {
        grid-template-columns: 240px 1fr;
    }
}
.pdp-overall-score {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: var(--gold-pale);
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    border: 1px solid var(--gold-border);
}
.pdp-big-rating {
    font-size: 2.8rem;
    font-weight: 900;
    color: var(--dark-gold);
    line-height: 1;
}
.pdp-big-stars {
    color: #F59E0B;
    font-size: 1.2rem;
    margin: 6px 0;
}
.pdp-score-sub {
    font-size: 0.75rem;
    color: var(--mid-text);
    font-weight: 600;
}

.pdp-bars-wrap {
    display: flex;
    flex-direction: column;
    gap: 8px;
    justify-content: center;
}
.pdp-bar-row {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.75rem;
    font-weight: 700;
    color: var(--dark-text);
}
.pdp-bar-track {
    flex: 1;
    height: 8px;
    background: var(--soft-platinum);
    border-radius: 4px;
    overflow: hidden;
}
.pdp-bar-fill {
    height: 100%;
    background: var(--dark-gold);
    border-radius: 4px;
}

/* Review Cards */
.pdp-reviews-cards-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
    margin-top: 24px;
}
@media (min-width: 768px) {
    .pdp-reviews-cards-grid {
        grid-template-columns: 1fr 1fr;
    }
}
.pdp-review-card {
    background: var(--off-white);
    border-radius: 12px;
    padding: 16px 18px;
    border: 1px solid var(--soft-platinum);
}
.pdp-rc-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 8px;
}
.pdp-rc-user {
    font-weight: 800;
    font-size: 0.84rem;
    color: var(--dark-text);
    display: flex;
    align-items: center;
    gap: 6px;
}
.pdp-verified-tag {
    font-size: 0.65rem;
    color: #2E7D32;
    background: #E8F5E9;
    padding: 2px 6px;
    border-radius: 4px;
    font-weight: 700;
}
.pdp-rc-stars { color: #F59E0B; font-size: 0.8rem; }
.pdp-rc-text {
    font-size: 0.8rem;
    color: var(--mid-text);
    line-height: 1.5;
}

/* ════════════════════════════════════════════════════
   RELATED PRODUCTS SECTION
════════════════════════════════════════════════════ */
.pdp-bottom-section {
    margin-top: clamp(40px, 6vw, 70px);
}
.pdp-section-title-large {
    font-family: var(--font-serif);
    font-size: clamp(1.2rem, 3vw, 1.6rem);
    font-weight: 800;
    color: var(--dark-text);
    letter-spacing: 0.06em;
    text-align: center;
    margin-bottom: 24px;
    position: relative;
}
.pdp-section-title-large::after {
    content: '';
    display: block;
    width: 50px;
    height: 2px;
    background: var(--dark-gold);
    margin: 8px auto 0;
}

/* Related Products Grid */
.pdp-related-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
}
.pdp-rel-card {
    background: #FFFFFF;
    border-radius: 12px;
    border: 1.5px solid var(--soft-platinum);
    overflow: hidden;
    transition: all 0.25s ease;
    display: flex;
    flex-direction: column;
}
.pdp-rel-card:hover {
    border-color: var(--dark-gold);
    transform: translateY(-4px);
    box-shadow: 0 10px 24px rgba(138,104,31,0.15);
}
.pdp-rel-img-wrap {
    aspect-ratio: 3/4;
    overflow: hidden;
    position: relative;
    background: var(--off-white-2);
}
.pdp-rel-img-wrap img {
    width: 100%; height: 100%; object-fit: cover; object-position: top;
    transition: transform 0.4s ease;
}
.pdp-rel-card:hover .pdp-rel-img-wrap img { transform: scale(1.05); }
.pdp-rel-body {
    padding: 12px;
    display: flex;
    flex-direction: column;
    gap: 4px;
    flex: 1;
}
.pdp-rel-cat {
    font-size: 0.62rem;
    font-weight: 800;
    color: var(--dark-gold);
    text-transform: uppercase;
    letter-spacing: 0.1em;
}
.pdp-rel-title {
    font-family: var(--font-serif);
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--dark-text);
    line-height: 1.3;
}
.pdp-rel-price {
    font-size: 0.95rem;
    font-weight: 900;
    color: var(--dark-gold);
    margin-top: auto;
}

/* ════════════════════════════════════════════════════
   SIZE GUIDE MODAL
════════════════════════════════════════════════════ */
.pdp-modal-overlay {
    position: fixed; inset: 0; z-index: 10000;
    background: rgba(0,0,0,0.65);
    backdrop-filter: blur(4px);
    display: none; align-items: center; justify-content: center;
    padding: 16px;
}
.pdp-modal-overlay.open { display: flex; }
.pdp-modal-box {
    background: #FFFFFF;
    border-radius: 16px;
    max-width: 580px; width: 100%;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    overflow: hidden;
    border: 1.5px solid var(--gold-border);
    animation: modalPop 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
}
@keyframes modalPop {
    from { opacity: 0; transform: scale(0.92) translateY(20px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}
.pdp-modal-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 16px 22px; border-bottom: 1.5px solid var(--soft-platinum);
    background: #FAF8F4;
}
.pdp-modal-title {
    font-family: var(--font-serif);
    font-size: 1.1rem;
    font-weight: 800;
    color: var(--dark-gold);
    margin: 0;
}
.pdp-modal-close-btn {
    width: 32px; height: 32px; border-radius: 50%;
    background: #FFFFFF; border: 1px solid var(--soft-platinum);
    font-size: 1.2rem; display: flex; align-items: center; justify-content: center;
    cursor: pointer; color: var(--dark-text);
}
.pdp-modal-body {
    padding: 20px 22px;
    max-height: 75vh;
    overflow-y: auto;
}
.pdp-size-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.8rem;
    text-align: center;
    margin-top: 12px;
}
.pdp-size-table th, .pdp-size-table td {
    padding: 10px 8px;
    border: 1px solid var(--soft-platinum);
}
.pdp-size-table th {
    background: var(--gold-pale);
    color: var(--dark-gold);
    font-weight: 800;
}

/* Toast Container */
.toast-container {
    position: fixed; bottom: 84px; left: 50%;
    transform: translateX(-50%); z-index: 100000;
    display: flex; flex-direction: column; align-items: center; gap: 8px;
    pointer-events: none;
}
.toast {
    padding: 10px 22px; border-radius: 30px;
    background: var(--dark-text); color: var(--off-white);
    font-size: 0.78rem; font-weight: 600; letter-spacing: 0.04em;
    box-shadow: 0 4px 24px rgba(0,0,0,0.22); white-space: nowrap;
    opacity: 0; transform: translateY(8px) scale(0.96); transition: all 0.3s ease;
}
.toast.show { opacity: 1; transform: translateY(0) scale(1); }
</style>
</head>
<body>

<!-- ════════════ HEADER PARTIAL ════════════ -->
<?php include 'singelproduthader.php'; ?>

<!-- ════════════ MAIN PRODUCT DETAIL CONTENT ════════════ -->
<main class="pdp-main-wrapper">
    <div class="pdp-layout-grid">
        
        <!-- ── Left: Interactive Swipeable Gallery ── -->
        <div class="pdp-gallery-column">
            <div class="pdp-gallery-slider" id="pdpGallerySlider">
                <?php if (!empty($product['badge'])): ?>
                <span class="pdp-badge-tag"><?= htmlspecialchars($product['badge']) ?></span>
                <?php endif; ?>

                <button class="pdp-zoom-btn" title="View Fullscreen Image" onclick="openFullscreenImage()">
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
                    <?php foreach ($galleryImages as $index => $img): ?>
                    <div class="pdp-slide" data-idx="<?= $index ?>">
                        <img
                            src="<?= htmlspecialchars($img) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?> - View <?= $index + 1 ?>"
                            onError="this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=800&q=80'"
                        />
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Slide Index Counter -->
                <div class="pdp-slide-counter" id="pdpSlideCounter">1 / <?= count($galleryImages) ?></div>
            </div>

            <!-- Multi-Photo Thumbnails -->
            <div class="pdp-thumbnails-strip" id="pdpThumbnailsStrip">
                <?php foreach ($galleryImages as $index => $img): ?>
                <div class="pdp-thumb-item <?= $index === 0 ? 'active' : '' ?>" data-idx="<?= $index ?>" onclick="goToSlide(<?= $index ?>)">
                    <img src="<?= htmlspecialchars($img) ?>" alt="Thumb <?= $index + 1 ?>" onError="this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=200&q=80'" />
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ── Right: Product Details & Conversion Actions ── -->
        <div class="pdp-details-column">
            <div>
                <span class="pdp-brand-tag">KALANIKETAN ETHNIC LUXURY</span>
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

            <!-- Price Card -->
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
                <div class="pdp-tax-note">
                    <svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <span>Inclusive of all taxes • Free express shipping</span>
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

                <!-- Direct WhatsApp Order -->
                <a
                    href="https://api.whatsapp.com/send?phone=919876543210&text=<?= urlencode('Hello Kalaniketan! I would like to order ' . $product['name'] . ' (₹' . number_format($product['price']) . '). Link: https://kalaniketan.in/singelprodut.php?id=' . $product['id']) ?>"
                    target="_blank"
                    class="pdp-wa-order-btn"
                    rel="noopener"
                >
                    <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    <span>Instant Order via WhatsApp</span>
                </a>
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

            <!-- Accordion Details -->
            <div class="pdp-accordion-wrap">
                <!-- 1. Description -->
                <div class="pdp-acc-item open">
                    <button class="pdp-acc-header" onclick="togglePdpAcc(this)">
                        <span>✨ Product Description & Craftsmanship</span>
                        <span class="pdp-acc-icon">▾</span>
                    </button>
                    <div class="pdp-acc-body">
                        <p><?= htmlspecialchars($product['desc']) ?></p>
                    </div>
                </div>

                <!-- 2. Specifications -->
                <div class="pdp-acc-item">
                    <button class="pdp-acc-header" onclick="togglePdpAcc(this)">
                        <span>🧵 Fabric & Garment Specifications</span>
                        <span class="pdp-acc-icon">▾</span>
                    </button>
                    <div class="pdp-acc-body">
                        <div class="pdp-specs-grid">
                            <div class="pdp-spec-box"><span class="pdp-spec-lbl">Fabric</span><span class="pdp-spec-val"><?= htmlspecialchars($product['fabric']) ?></span></div>
                            <div class="pdp-spec-box"><span class="pdp-spec-lbl">Category</span><span class="pdp-spec-val"><?= htmlspecialchars($product['category']) ?></span></div>
                            <div class="pdp-spec-box"><span class="pdp-spec-lbl">Craft / Technique</span><span class="pdp-spec-val">Artisanal Handloom Weaving</span></div>
                            <div class="pdp-spec-box"><span class="pdp-spec-lbl">Care Instructions</span><span class="pdp-spec-val">Dry Clean Only</span></div>
                        </div>
                    </div>
                </div>

                <!-- 3. Shipping & Authenticity -->
                <div class="pdp-acc-item">
                    <button class="pdp-acc-header" onclick="togglePdpAcc(this)">
                        <span>🚚 Free Shipping, Authenticity & Returns</span>
                        <span class="pdp-acc-icon">▾</span>
                    </button>
                    <div class="pdp-acc-body">
                        <p>
                            • <strong>100% Genuine Certified</strong> Handloom Ethnic Couture directly from Kalaniketan master weavers.<br />
                            • <strong>Free Express Shipping</strong> across all pincodes in India.<br />
                            • <strong>7-Day Hassle-Free Exchange</strong>: In case of size or fit discrepancies, exchange requests can be placed via our WhatsApp helpline with zero extra charge.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ════ CUSTOMER REVIEWS & RATINGS BREAKDOWN ════ -->
    <section class="pdp-reviews-section">
        <h2 class="pdp-section-title-large">Customer Ratings & Reviews</h2>
        
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
        </div>

        <div class="pdp-reviews-cards-grid">
            <div class="pdp-review-card">
                <div class="pdp-rc-top">
                    <div class="pdp-rc-user">
                        <span>Priya Sharma</span>
                        <span class="pdp-verified-tag">✓ Verified Buyer</span>
                    </div>
                    <div class="pdp-rc-stars">★★★★★</div>
                </div>
                <p class="pdp-rc-text">
                    "The fabric quality and real zari weave is breathtaking! Arrived in luxury gift packaging within 3 days to Mumbai. Will definitely purchase again for the wedding season."
                </p>
            </div>

            <div class="pdp-review-card">
                <div class="pdp-rc-top">
                    <div class="pdp-rc-user">
                        <span>Ananya Mehta</span>
                        <span class="pdp-verified-tag">✓ Verified Buyer</span>
                    </div>
                    <div class="pdp-rc-stars">★★★★★</div>
                </div>
                <p class="pdp-rc-text">
                    "Exactly as depicted in the photos. The silk drape feels extremely luxurious and lightweight. The WhatsApp concierge was very helpful with size advice."
                </p>
            </div>
        </div>
    </section>

    <!-- ════ RELATED PRODUCTS CAROUSEL ════ -->
    <section class="pdp-bottom-section">
        <h2 class="pdp-section-title-large">You May Also Admire</h2>
        <div class="pdp-related-grid">
            <?php 
            $relatedItems = array_filter($products, function($it) use ($product) { return $it['id'] !== $product['id']; });
            $relatedSlice = array_slice($relatedItems, 0, 4);
            foreach ($relatedSlice as $rel):
            ?>
            <a href="singelprodut.php?id=<?= $rel['id'] ?>" class="pdp-rel-card">
                <div class="pdp-rel-img-wrap">
                    <img src="<?= htmlspecialchars($rel['image']) ?>" alt="<?= htmlspecialchars($rel['name']) ?>" onError="this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=400&q=80'" />
                </div>
                <div class="pdp-rel-body">
                    <span class="pdp-rel-cat"><?= htmlspecialchars($rel['category']) ?></span>
                    <h3 class="pdp-rel-title"><?= htmlspecialchars($rel['name']) ?></h3>
                    <span class="pdp-rel-price">₹<?= number_format($rel['price']) ?></span>
                </div>
            </a>
            <?php endforeach; ?>
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

<!-- ════ TOAST CONTAINER ════ -->
<div class="toast-container" id="toastContainer" aria-live="assertive" aria-atomic="true"></div>

<!-- ════ FOOTER PARTIAL ════ -->
<?php include 'singelprodutbottomfotoer.php'; ?>

<!-- ════ CART DRAWER PARTIAL ════ -->
<?php include 'cart.php'; ?>

<!-- ════ WISHLIST DRAWER PARTIAL ════ -->
<?php include 'wishlist.php'; ?>

<!-- ════ SCRIPT ENGINE ════ -->
<script>
(function() {
    'use strict';

    var currentProduct = <?= json_encode($product) ?>;
    window.currentPdpProduct = currentProduct;

    // Toast helper
    window.showToast = function(msg) {
        var c = document.getElementById('toastContainer');
        if (!c) return;
        var t = document.createElement('div');
        t.className = 'toast';
        t.textContent = msg;
        c.appendChild(t);
        requestAnimationFrame(function() {
            requestAnimationFrame(function() { t.classList.add('show'); });
        });
        setTimeout(function() {
            t.classList.remove('show');
            setTimeout(function() { t.remove(); }, 350);
        }, 2200);
    };

    // Gallery Slider Controls
    var track = document.getElementById('pdpSliderTrack');
    var counter = document.getElementById('pdpSlideCounter');
    var totalSlides = <?= count($galleryImages) ?>;
    var currentSlideIdx = 0;

    window.goToSlide = function(idx) {
        if (!track) return;
        currentSlideIdx = idx;
        var width = track.clientWidth;
        track.scrollTo({ left: idx * width, behavior: 'smooth' });
        updateActiveThumbnail(idx);
        if (counter) counter.textContent = (idx + 1) + ' / ' + totalSlides;
    };

    window.slidePdpGallery = function(delta) {
        var next = currentSlideIdx + delta;
        if (next < 0) next = totalSlides - 1;
        if (next >= totalSlides) next = 0;
        window.goToSlide(next);
    };

    function updateActiveThumbnail(idx) {
        document.querySelectorAll('.pdp-thumb-item').forEach(function(item, i) {
            item.classList.toggle('active', i === idx);
        });
    }

    // Touch Swipe scroll sync listener
    if (track) {
        track.addEventListener('scroll', function() {
            var width = track.clientWidth;
            if (width > 0) {
                var idx = Math.round(track.scrollLeft / width);
                if (idx !== currentSlideIdx && idx >= 0 && idx < totalSlides) {
                    currentSlideIdx = idx;
                    updateActiveThumbnail(idx);
                    if (counter) counter.textContent = (idx + 1) + ' / ' + totalSlides;
                }
            }
        }, { passive: true });
    }

    // Color Selector
    window.selectPdpColor = function(btn) {
        document.querySelectorAll('.pdp-color-btn').forEach(function(b) { b.classList.remove('active'); });
        btn.classList.add('active');
        var nameEl = document.getElementById('pdpSelectedColorName');
        if (nameEl) nameEl.textContent = btn.dataset.color;
    };

    // Size Selector
    window.selectPdpSize = function(btn) {
        document.querySelectorAll('.pdp-size-btn').forEach(function(b) { b.classList.remove('active'); });
        btn.classList.add('active');
    };

    // Quantity Counter
    var currentQty = 1;
    window.updatePdpQty = function(delta) {
        currentQty += delta;
        if (currentQty < 1) currentQty = 1;
        if (currentQty > 10) currentQty = 10;
        var qEl = document.getElementById('pdpQtyVal');
        if (qEl) qEl.textContent = currentQty;
    };

    // Accordion Toggle
    window.togglePdpAcc = function(headerBtn) {
        var parentItem = headerBtn.closest('.pdp-acc-item');
        if (parentItem) {
            parentItem.classList.toggle('open');
        }
    };

    // Add To Bag Function (Integrates directly with Cart Drawer)
    window.handlePdpAddToCart = function() {
        var activeSizeBtn = document.querySelector('.pdp-size-btn.active');
        var selSize = activeSizeBtn ? activeSizeBtn.dataset.size : (currentProduct.size[0] || 'Free Size');

        var activeColorBtn = document.querySelector('.pdp-color-btn.active');
        var selColor = activeColorBtn ? activeColorBtn.dataset.color : (currentProduct.colors[0] || 'Standard');

        if (typeof window.addToCart === 'function') {
            for (var i = 0; i < currentQty; i++) {
                window.addToCart(currentProduct, selSize, selColor);
            }
        } else {
            // Local fallback
            try {
                var cart = JSON.parse(localStorage.getItem('kalaniketan_cart') || '[]');
                cart.push({
                    id: currentProduct.id,
                    name: currentProduct.name,
                    price: currentProduct.price,
                    image: currentProduct.image,
                    size: selSize,
                    color: selColor,
                    qty: currentQty
                });
                localStorage.setItem('kalaniketan_cart', JSON.stringify(cart));
            } catch(e) {}
        }

        window.showToast('🛍️ Added ' + currentProduct.name + ' to Bag!');
        if (typeof window.syncPdpHeaderState === 'function') window.syncPdpHeaderState();
        if (typeof window.openCartDrawer === 'function') {
            window.openCartDrawer();
        }
    };

    // Buy Now (Instant Checkout)
    window.handlePdpBuyNow = function() {
        window.handlePdpAddToCart();
        setTimeout(function() {
            window.location.href = 'checkout.php';
        }, 300);
    };

    // Wishlist Toggle
    window.handlePdpWishlistClick = function() {
        var wishBtn = document.getElementById('pdpMobWishBtn');
        if (typeof window.toggleWishlistProduct === 'function') {
            var added = window.toggleWishlistProduct(currentProduct);
            if (wishBtn) wishBtn.classList.toggle('active', added);
            window.showToast(added ? '♡ Saved to wishlist' : 'Removed from wishlist');
            if (typeof window.syncPdpHeaderState === 'function') window.syncPdpHeaderState();
        }
    };

    // Pincode Delivery Estimator
    window.checkPincodeDelivery = function() {
        var input = document.getElementById('pdpPincodeInput');
        var res = document.getElementById('pdpPincodeResult');
        if (!input || !res) return;

        var pin = input.value.trim();
        if (pin.length !== 6 || isNaN(pin)) {
            res.style.display = 'block';
            res.style.color = '#D32F2F';
            res.textContent = '⚠️ Please enter a valid 6-digit Indian pincode.';
            return;
        }

        var d = new Date();
        d.setDate(d.getDate() + 3);
        var dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var dateString = dayNames[d.getDay()] + ', ' + d.getDate() + ' ' + monthNames[d.getMonth()];

        res.style.display = 'block';
        res.style.color = '#2E7D32';
        res.innerHTML = '✅ <strong>Delivery by ' + dateString + '</strong><br />✨ Free Express Shipping • Cash on Delivery Available for ' + pin;
    };

    // Fullscreen Image Lightbox
    window.openFullscreenImage = function() {
        var activeSlide = document.querySelector('.pdp-slide[data-idx="' + currentSlideIdx + '"] img');
        if (activeSlide) {
            window.open(activeSlide.src, '_blank');
        }
    };

    // Size Guide Modal
    window.openSizeGuideModal = function() {
        var modal = document.getElementById('pdpSizeChartModal');
        if (modal) modal.classList.add('open');
    };
    window.closeSizeGuideModal = function() {
        var modal = document.getElementById('pdpSizeChartModal');
        if (modal) modal.classList.remove('open');
    };

    // Modal background click dismiss
    var sizeModal = document.getElementById('pdpSizeChartModal');
    if (sizeModal) {
        sizeModal.addEventListener('click', function(e) {
            if (e.target === sizeModal) window.closeSizeGuideModal();
        });
    }

})();
</script>
</body>
</html>
