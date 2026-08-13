<?php
/**
 * shop.php — MAIN PAGE (single complete HTML document)
 * Includes shophader.php and shopbottomfotoer.php as partials.
 * Premium Ethnic-Wear Shop — Kalaniketan
 */

$products = [
    [
        'id'       => 1,
        'name'     => 'Nilambari Silk Saree',
        'category' => 'Sarees',
        'price'    => 4899,
        'old_price'=> 6500,
        'discount' => 25,
        'image'    => 'images/product1.png',
        'badge'    => 'New',
        'rating'   => 4.8,
        'color'    => 'Navy',
        'colors'   => ['Navy', 'Royal Blue', 'Midnight Black'],
        'size'     => ['Free Size', 'M', 'L'],
        'fabric'   => 'Pure Silk',
        'in_stock' => true
    ],
    [
        'id'       => 2,
        'name'     => 'Banarasi Zari Saree',
        'category' => 'Sarees',
        'price'    => 8499,
        'old_price'=> 11000,
        'discount' => 23,
        'image'    => 'images/product2.png',
        'badge'    => 'Bestseller',
        'rating'   => 4.9,
        'color'    => 'Maroon',
        'colors'   => ['Maroon', 'Deep Wine', 'Ruby Red'],
        'size'     => ['Free Size', 'S', 'M'],
        'fabric'   => 'Pure Silk',
        'in_stock' => true
    ],
    [
        'id'       => 3,
        'name'     => 'Kanjivaram Temple Silk',
        'category' => 'Sarees',
        'price'    => 12999,
        'old_price'=> 16500,
        'discount' => 21,
        'image'    => 'images/product3.png',
        'badge'    => 'Heritage',
        'rating'   => 5.0,
        'color'    => 'Yellow',
        'colors'   => ['Yellow', 'Golden Ochre', 'Emerald Green'],
        'size'     => ['Free Size', 'L', 'XL'],
        'fabric'   => 'Pure Silk',
        'in_stock' => true
    ],
    [
        'id'       => 4,
        'name'     => 'Georgette Bloom Saree',
        'category' => 'Sarees',
        'price'    => 3299,
        'old_price'=> null,
        'discount' => 0,
        'image'    => 'images/product4.png',
        'badge'    => null,
        'rating'   => 4.6,
        'color'    => 'Pink',
        'colors'   => ['Pink', 'Blush Peach', 'Rose'],
        'size'     => ['Free Size', 'S', 'M', 'L'],
        'fabric'   => 'Georgette',
        'in_stock' => true
    ],
    [
        'id'       => 5,
        'name'     => 'Royal Anarkali Kurti',
        'category' => 'Kurtis',
        'price'    => 2799,
        'old_price'=> 3900,
        'discount' => 28,
        'image'    => 'images/product5.png',
        'badge'    => 'New',
        'rating'   => 4.7,
        'color'    => 'Green',
        'colors'   => ['Green', 'Teal', 'Mint'],
        'size'     => ['XS', 'S', 'M', 'L'],
        'fabric'   => 'Cotton',
        'in_stock' => true
    ],
    [
        'id'       => 6,
        'name'     => 'Bridal Zardosi Lehenga',
        'category' => 'Lehengas',
        'price'    => 24999,
        'old_price'=> 32000,
        'discount' => 22,
        'image'    => 'images/product6.png',
        'badge'    => 'Bridal',
        'rating'   => 5.0,
        'color'    => 'Red',
        'colors'   => ['Red', 'Crimson', 'Maroon'],
        'size'     => ['S', 'M', 'L', 'XL'],
        'fabric'   => 'Organza',
        'in_stock' => true
    ],
    [
        'id'       => 7,
        'name'     => 'Mustard Block Print Saree',
        'category' => 'Sarees',
        'price'    => 1899,
        'old_price'=> 2600,
        'discount' => 27,
        'image'    => 'images/product7.png',
        'badge'    => null,
        'rating'   => 4.5,
        'color'    => 'Orange',
        'colors'   => ['Orange', 'Mustard', 'Rust Gold'],
        'size'     => ['Free Size', 'M'],
        'fabric'   => 'Cotton',
        'in_stock' => true
    ],
    [
        'id'       => 8,
        'name'     => 'Ivory Designer Gown',
        'category' => 'Gowns',
        'price'    => 7499,
        'old_price'=> 9500,
        'discount' => 21,
        'image'    => 'images/product8.png',
        'badge'    => 'Trending',
        'rating'   => 4.8,
        'color'    => 'White',
        'colors'   => ['White', 'Ivory', 'Pearl Cream'],
        'size'     => ['S', 'M', 'L', 'XXL'],
        'fabric'   => 'Chiffon',
        'in_stock' => true
    ],
];

$categories     = ['All','Sarees','Kurtis','Gowns','Lehengas','New Arrivals'];
$total_products = count($products);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="description" content="Shop premium Indian ethnic wear — silk sarees, kurtis, lehengas and designer gowns at Kalaniketan." />
<title>Shop — Kalaniketan | Ethnic Luxury</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

<style>
/* ════════════════════════════════════════════════════
   DESIGN TOKENS & UTILITIES
════════════════════════════════════════════════════ */
:root {
    --off-white:      #F8F6F0;
    --off-white-2:    #F2EFE8;
    --off-white-3:    #EAE7DF;
    --dark-gold:      #8A681F;
    --deep-gold:      #6F5218;
    --gold-light:     #B8921F;
    --gold-pale:      #F5EDD6;
    --platinum:       #C8C8C8;
    --soft-platinum:  #E5E3DE;
    --dark-text:      #24211C;
    --mid-text:       #5A5348;
    --light-text:     #9A9490;

    --font-serif:     'Cinzel', serif;
    --font-sans:      'Inter', 'Montserrat', sans-serif;

    --header-h:       64px;
    --bottom-bar-h:   68px;
    --radius-card:    12px;
    --radius-sm:      6px;
    --transition:     0.28s cubic-bezier(0.4, 0, 0.2, 1);
    --shadow-card:    0 2px 20px rgba(0,0,0,0.06);
    --shadow-hover:   0 12px 36px rgba(138,104,31,0.14);
}

/* ── Reset ── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body {
    background: var(--off-white);
    font-family: var(--font-sans);
    color: var(--dark-text);
    -webkit-font-smoothing: antialiased;
    overflow-x: hidden;
}
img   { display: block; max-width: 100%; }
a     { text-decoration: none; color: inherit; }
ul    { list-style: none; }
button { cursor: pointer; border: none; background: none; font-family: inherit; }

/* ════════════════════════════════════════════════════
   PAGE WRAPPER & LAYOUT
════════════════════════════════════════════════════ */
.page-wrapper {
    padding-top: 0;
    padding-bottom: calc(var(--bottom-bar-h, 44px) + 16px);
    min-height: 100vh;
}
@media (min-width: 1024px) {
    .page-wrapper { padding-top: 0; padding-bottom: 0; }
}

.shop-layout {
    display: block;
}
@media (min-width: 1024px) {
    .shop-layout {
        display: flex;
        align-items: flex-start;
    }
}

/* ════════════════════════════════════════════════════
   HERO PROMO BANNER SLIDER (Auto Sizing & Fluid Layout)
════════════════════════════════════════════════════ */
.hero-banner-section {
    padding: clamp(4px, 1.5vw, 12px) clamp(8px, 2vw, 24px) 2px;
    background: #FAF8F4;
    position: relative;
}
.hero-banner-container {
    position: relative;
    width: 100%;
    max-width: 1360px;
    margin: 0 auto;
    border-radius: clamp(8px, 2vw, 12px);
    overflow: hidden;
    box-shadow: 0 3px 14px rgba(138, 104, 31, 0.12);
    border: 1px solid rgba(138, 104, 31, 0.2);
}
.hero-banner-track {
    display: flex;
    transition: transform 0.45s cubic-bezier(0.25, 1, 0.5, 1);
    width: 100%;
    touch-action: pan-y;
}
.hero-banner-slide {
    flex: 0 0 100%;
    width: 100%;
    min-height: clamp(105px, 26vw, 165px);
    height: auto;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: clamp(8px, 2.2vw, 20px) clamp(10px, 2.8vw, 32px);
    color: #FFFFFF;
    box-sizing: border-box;
    cursor: pointer;
    overflow: hidden;
}
.hero-slide-1 { background: linear-gradient(135deg, #1F150C 0%, #452D14 55%, #8A681F 100%); }
.hero-slide-2 { background: linear-gradient(135deg, #12211C 0%, #224236 55%, #7C5E1B 100%); }
.hero-slide-3 { background: linear-gradient(135deg, #2D0F18 0%, #52182B 55%, #946F1D 100%); }

.hero-slide-content {
    display: flex;
    flex-direction: column;
    gap: clamp(2px, 0.6vw, 4px);
    z-index: 2;
    max-width: 66%;
    padding-right: 6px;
}
.hero-slide-tag {
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: clamp(0.48rem, 1.6vw, 0.65rem);
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #F8D67A;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    line-height: 1.1;
}
.hero-slide-title {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: clamp(0.82rem, 2.8vw, 1.38rem);
    font-weight: 700;
    color: #FFFFFF;
    margin: 0;
    line-height: 1.18;
    text-shadow: 0 2px 6px rgba(0,0,0,0.6);
}
.hero-slide-desc {
    font-size: clamp(0.56rem, 1.8vw, 0.8rem);
    color: rgba(255, 255, 255, 0.85);
    margin: 0;
    font-weight: 500;
    line-height: 1.2;
}
.hero-slide-btn {
    align-self: flex-start;
    margin-top: clamp(2px, 0.8vw, 6px);
    padding: clamp(2px, 0.6vw, 5px) clamp(8px, 2vw, 14px);
    border-radius: 14px;
    background: #F8D67A;
    color: #382506;
    border: none;
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: clamp(0.54rem, 1.6vw, 0.7rem);
    font-weight: 800;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    transition: all 0.2s ease;
}
.hero-slide-btn:hover {
    background: #FFFFFF;
    transform: translateX(2px);
}

.hero-slide-img-wrap {
    height: clamp(90px, 23vw, 135px);
    width: clamp(68px, 17vw, 105px);
    border-radius: 6px;
    overflow: hidden;
    border: 1.5px solid rgba(248, 214, 122, 0.4);
    box-shadow: 0 3px 10px rgba(0,0,0,0.4);
    flex-shrink: 0;
    z-index: 2;
}
.hero-slide-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top;
    transition: transform 0.4s ease;
}
.hero-banner-slide:hover .hero-slide-img-wrap img {
    transform: scale(1.06);
}

/* Banner Dots */
.hero-banner-dots {
    position: absolute;
    bottom: 5px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 5px;
    z-index: 5;
}
.hero-banner-dot {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.4);
    cursor: pointer;
    transition: all 0.25s ease;
}
.hero-banner-dot.active {
    width: 14px;
    border-radius: 3px;
    background: #F8D67A;
    box-shadow: 0 0 6px rgba(248, 214, 122, 0.8);
}

/* Banner Navigation Arrows (Hidden on mobile, shown on desktop) */
.hero-banner-arrow {
    display: none;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.4);
    border: 1px solid rgba(255, 255, 255, 0.25);
    color: #FFFFFF;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 5;
    transition: all 0.2s ease;
}
.hero-banner-arrow:hover {
    background: var(--dark-gold, #8A681F);
    color: #FFFFFF;
}
.hero-banner-arrow.prev { left: 8px; }
.hero-banner-arrow.next { right: 8px; }
.hero-banner-arrow svg {
    width: 14px; height: 14px; stroke: currentColor; stroke-width: 2.2; fill: none;
}

@media (min-width: 768px) {
    .hero-banner-arrow { display: flex; }
    .hero-banner-dot { width: 6px; height: 6px; }
    .hero-banner-dot.active { width: 18px; }
}

/* ════════════════════════════════════════════════════
   ROUND SUB-CATEGORY SLIDER
════════════════════════════════════════════════════ */
.cat-slider-section {
    background: #FAF8F4;
    border-bottom: 1px solid var(--soft-platinum, #E5E3DE);
    padding: 10px 0 8px;
    position: relative;
}

.cat-slider-track {
    display: flex;
    gap: 4px;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    padding: 2px 14px 4px;
}
.cat-slider-track::-webkit-scrollbar { display: none; }

.cat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
    scroll-snap-align: start;
    cursor: pointer;
    padding: 0 8px;
    background: none;
    border: none;
    font-family: var(--font-sans);
    transition: transform var(--transition);
}
.cat-item:active { transform: scale(0.93); }
.cat-item:hover .cat-ring { border-color: var(--dark-gold); }
.cat-item:hover .cat-label { color: var(--dark-gold); }

.cat-ring {
    width: clamp(48px, 13vw, 62px);
    height: clamp(48px, 13vw, 62px);
    border-radius: 50%;
    border: 2px solid var(--soft-platinum, #E5E3DE);
    padding: 2.5px;
    transition: all 0.25s ease;
    position: relative;
}
.cat-item.active .cat-ring {
    border-color: var(--dark-gold, #8A681F);
    box-shadow: 0 0 0 2px rgba(138,104,31,0.3);
}

.cat-circle {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    overflow: hidden;
    position: relative;
    background: var(--off-white-2, #F5F2EB);
    display: flex;
    align-items: center;
    justify-content: center;
}
.cat-circle img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: top;
    border-radius: 50%;
    transition: transform 0.4s ease;
}
.cat-item:hover .cat-circle img { transform: scale(1.1); }

.cat-circle.gradient-1  { background: linear-gradient(135deg, #D4AF6A 0%, #8A681F 100%); }
.cat-circle.gradient-6  { background: linear-gradient(135deg, #E8D4A0 0%, #B8921F 100%); }

.cat-icon {
    font-size: 1.2rem;
    line-height: 1;
    color: #fff;
    opacity: 0.95;
}

.cat-item.active .cat-ring::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 50%;
    transform: translateX(-50%);
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: var(--dark-gold, #8A681F);
    border: 1px solid #FFFFFF;
}

.cat-label {
    font-size: 0.65rem;
    font-weight: 600;
    color: var(--mid-text, #5A5348);
    letter-spacing: 0.04em;
    text-align: center;
    white-space: nowrap;
    transition: color var(--transition);
    max-width: 74px;
    overflow: hidden;
    text-overflow: ellipsis;
}
.cat-item.active .cat-label {
    color: var(--dark-gold, #8A681F);
    font-weight: 800;
}

@media (min-width: 768px) {
    .main-cat-slider-track { padding: 4px 28px; gap: 10px; }
    .main-cat-tab { font-size: 0.78rem; padding: 7px 18px; }
    .cat-slider-track { padding: 4px 28px 6px; gap: 8px; }
    .cat-ring { width: 68px; height: 68px; }
    .cat-item { padding: 0 10px; }
    .cat-label { font-size: 0.7rem; }
}

/* ════════════════════════════════════════════════════
   DESKTOP STICKY SIDEBAR FILTER
════════════════════════════════════════════════════ */
.filter-sidebar {
    display: none;
}
@media (min-width: 1024px) {
    .filter-sidebar {
        display: flex;
        flex-direction: column;
        width: 260px;
        flex-shrink: 0;
        border-right: 1px solid var(--soft-platinum);
        position: sticky;
        top: var(--header-h);
        height: calc(100vh - var(--header-h));
        overflow-y: auto;
        background: var(--off-white);
        scrollbar-width: thin;
        scrollbar-color: var(--soft-platinum) transparent;
    }
    .filter-sidebar::-webkit-scrollbar { width: 4px; }
    .filter-sidebar::-webkit-scrollbar-thumb { background: var(--soft-platinum); border-radius: 2px; }
}

.sf-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px 14px;
    border-bottom: 1px solid var(--soft-platinum);
    flex-shrink: 0;
    position: sticky;
    top: 0;
    background: rgba(248,246,240,0.96);
    backdrop-filter: blur(8px);
    z-index: 5;
}
.sf-title {
    font-family: var(--font-serif);
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--dark-text);
    letter-spacing: 0.1em;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    gap: 6px;
}
.sf-title-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 18px;
    height: 18px;
    padding: 0 5px;
    border-radius: 9px;
    background: var(--dark-gold);
    color: #fff;
    font-family: var(--font-sans);
    font-size: 0.62rem;
    font-weight: 700;
}
.sf-clear-all {
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--dark-gold);
    letter-spacing: 0.08em;
    text-transform: uppercase;
    cursor: pointer;
    background: none;
    border: none;
    font-family: var(--font-sans);
    transition: color var(--transition);
}
.sf-clear-all:hover { color: var(--deep-gold); text-decoration: underline; }

.sf-section {
    border-bottom: 1px solid var(--soft-platinum);
}
.sf-section-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 14px 20px;
    background: none;
    border: none;
    cursor: pointer;
    font-family: var(--font-sans);
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--dark-text);
    letter-spacing: 0.08em;
    text-transform: uppercase;
    transition: background var(--transition);
    text-align: left;
}
.sf-section-btn:hover { background: var(--off-white-2); }
.sf-section-title-wrap {
    display: flex;
    align-items: center;
    gap: 6px;
}
.sf-sec-badge {
    font-size: 0.65rem;
    color: var(--dark-gold);
    font-weight: 700;
    background: var(--gold-pale);
    padding: 2px 6px;
    border-radius: 10px;
    display: none;
}
.sf-section.has-active .sf-sec-badge { display: inline-block; }

.sf-chevron {
    width: 15px; height: 15px;
    stroke: var(--mid-text); fill: none; stroke-width: 2.5;
    transition: transform 0.25s ease;
    flex-shrink: 0;
}
.sf-section.open .sf-chevron { transform: rotate(180deg); }
.sf-section-body {
    display: none;
    padding: 4px 20px 16px;
}
.sf-section.open .sf-section-body { display: block; }

/* Filter chips */
.sf-chips { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 6px; }
.sf-chip {
    padding: 6px 14px;
    border-radius: 20px;
    border: 1.5px solid var(--soft-platinum);
    background: var(--off-white);
    font-size: 0.73rem; font-weight: 500;
    color: var(--mid-text);
    cursor: pointer;
    transition: all var(--transition);
    letter-spacing: 0.04em;
}
.sf-chip:hover { border-color: var(--dark-gold); color: var(--dark-gold); background: var(--gold-pale); }
.sf-chip.active { border-color: var(--dark-gold); background: var(--dark-gold); color: var(--off-white); font-weight: 600; }

/* Swatches */
.sf-swatches { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 8px; }
.sf-swatch-wrapper {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 4px 8px;
    border-radius: 16px;
    border: 1px solid var(--soft-platinum);
    cursor: pointer;
    transition: all var(--transition);
    background: var(--off-white);
}
.sf-swatch-wrapper:hover { border-color: var(--dark-gold); }
.sf-swatch-wrapper.active { border-color: var(--dark-gold); background: var(--gold-pale); }

.sf-swatch-circle {
    width: 18px; height: 18px; border-radius: 50%;
    flex-shrink: 0;
    position: relative;
    border: 1px solid rgba(0,0,0,0.1);
}
.sf-swatch-text {
    font-size: 0.7rem; font-weight: 500; color: var(--dark-text);
}

/* Luxury Price Display Card & Presets */
.price-display-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--gold-pale);
    border: 1px solid rgba(138, 104, 31, 0.28);
    border-radius: 10px;
    padding: 8px 14px;
    margin: 6px 0 16px;
    box-shadow: inset 0 1px 3px rgba(138,104,31,0.06);
}
.price-pill {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.price-pill-lbl {
    font-size: 0.58rem;
    font-weight: 700;
    color: var(--mid-text);
    letter-spacing: 0.12em;
    text-transform: uppercase;
}
.price-pill-val {
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--dark-gold);
    font-family: var(--font-sans);
}
.price-pill-sep {
    font-size: 0.85rem;
    color: var(--dark-gold);
    font-weight: 600;
    opacity: 0.5;
}

.sf-range-track {
    position: relative;
    height: 10px;
    background: #E2DFD7;
    border: 1px solid #D4D0C5;
    border-radius: 5px;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
    margin: 26px 4px 20px 4px;
}
.sf-range-fill {
    position: absolute;
    height: 100%;
    background: linear-gradient(90deg, #6F5218 0%, #8A681F 50%, #B8921F 100%);
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(138, 104, 31, 0.45);
    left: 0%; right: 0%;
    transition: left 0.08s ease, right 0.08s ease;
}
input[type=range].sf-range {
    position: absolute;
    top: -7px; left: 0;
    width: 100%; height: 10px;
    appearance: none;
    background: transparent;
    cursor: pointer;
    pointer-events: none;
    z-index: 3;
}
input[type=range].sf-range::-webkit-slider-thumb {
    pointer-events: auto;
    appearance: none;
    width: 24px; height: 24px;
    border-radius: 50%;
    background: #FFFFFF;
    border: 3.5px solid var(--dark-gold);
    box-shadow: 0 3px 12px rgba(138, 104, 31, 0.45), 0 1px 3px rgba(0,0,0,0.15);
    cursor: grab;
    transition: transform 0.2s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.2s ease, border-color 0.2s ease;
}
input[type=range].sf-range::-webkit-slider-thumb:hover,
input[type=range].sf-range::-webkit-slider-thumb:active {
    transform: scale(1.25);
    box-shadow: 0 0 0 7px rgba(138, 104, 31, 0.22), 0 4px 14px rgba(0, 0, 0, 0.22);
    border-color: var(--deep-gold);
    cursor: grabbing;
}
input[type=range].sf-range::-moz-range-thumb {
    pointer-events: auto;
    width: 24px; height: 24px;
    border-radius: 50%;
    background: #FFFFFF;
    border: 3.5px solid var(--dark-gold);
    box-shadow: 0 3px 12px rgba(138, 104, 31, 0.45);
    cursor: grab;
}

.price-presets {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 12px;
}
.price-preset-chip {
    flex: 1 1 calc(50% - 6px);
    padding: 6px 6px;
    border-radius: 6px;
    border: 1px solid var(--soft-platinum);
    background: var(--off-white);
    font-size: 0.68rem;
    font-weight: 600;
    color: var(--mid-text);
    text-align: center;
    cursor: pointer;
    transition: all var(--transition);
}
.price-preset-chip:hover {
    border-color: var(--dark-gold);
    color: var(--dark-gold);
    background: var(--gold-pale);
}
.price-preset-chip.active {
    border-color: var(--dark-gold);
    background: var(--dark-gold);
    color: var(--off-white);
    box-shadow: 0 2px 8px rgba(138,104,31,0.25);
}

/* ════════════════════════════════════════════════════
   PRODUCTS AREA & GRID
════════════════════════════════════════════════════ */
.products-area {
    flex: 1;
    min-width: 0;
}

/* Desktop Sort Header */
.products-top-bar {
    display: none;
}
@media (min-width: 1024px) {
    .products-top-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 24px;
        border-bottom: 1px solid var(--soft-platinum);
        background: var(--off-white);
    }
    .ptb-count { font-size: 0.8rem; font-weight: 600; color: var(--mid-text); letter-spacing: 0.04em; }
    .ptb-sort-wrap { display: flex; align-items: center; gap: 8px; }
    .ptb-sort-label { font-size: 0.74rem; color: var(--light-text); font-weight: 500; }
    .ptb-sort-select {
        padding: 7px 14px;
        border-radius: 6px; border: 1.5px solid var(--soft-platinum);
        background: var(--off-white); color: var(--dark-text);
        font-family: var(--font-sans); font-size: 0.78rem; font-weight: 600;
        outline: none; cursor: pointer; transition: border-color var(--transition);
    }
    .ptb-sort-select:focus { border-color: var(--dark-gold); }
}

.products-section { padding: 16px 12px 24px; }
@media (min-width: 600px) { .products-section { padding: 20px 20px; } }
@media (min-width: 1024px) { .products-section { padding: 24px 28px; } }

/* Active filter bar tags */
.active-filter-bar {
    display: none;
    align-items: center; gap: 8px;
    padding: 4px 0 16px; overflow-x: auto; scrollbar-width: none;
}
.active-filter-bar.has-tags { display: flex; }
.active-filter-bar::-webkit-scrollbar { display: none; }
.active-filter-label { font-size: 0.72rem; color: var(--light-text); font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; flex-shrink: 0; }
.active-filter-tag {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 12px; border-radius: 20px;
    background: var(--gold-pale); border: 1px solid rgba(138,104,31,0.25);
    font-size: 0.72rem; font-weight: 600; color: var(--dark-gold);
    white-space: nowrap; flex-shrink: 0;
}
.active-filter-tag button {
    display: flex; align-items: center; justify-content: center;
    width: 14px; height: 14px; border-radius: 50%;
    color: var(--dark-gold); background: rgba(138,104,31,0.15);
    font-size: 0.65rem; border: none; cursor: pointer; transition: background 0.2s;
}
.active-filter-tag button:hover { background: var(--dark-gold); color: #fff; }

/* Grid Responsive Columns */
.products-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
}
@media (min-width: 600px) { .products-grid { grid-template-columns: repeat(3, 1fr); gap: 16px; } }
@media (min-width: 1024px) { .products-grid { grid-template-columns: repeat(3, 1fr); gap: 20px; } }
@media (min-width: 1280px) { .products-grid { grid-template-columns: repeat(4, 1fr); gap: 22px; } }

/* No products found state */
.no-products-found {
    grid-column: 1 / -1;
    text-align: center;
    padding: 60px 20px;
    background: var(--off-white-2);
    border-radius: 12px;
    border: 1px dashed var(--soft-platinum);
}
.np-title { font-family: var(--font-serif); font-size: 1.1rem; color: var(--dark-text); font-weight: 600; margin-bottom: 6px; }
.np-desc { font-size: 0.8rem; color: var(--mid-text); margin-bottom: 16px; }
.np-reset-btn {
    padding: 8px 20px; border-radius: 20px; background: var(--dark-gold); color: #fff;
    font-size: 0.75rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase;
}

/* ════════════════════════════════════════════════════
   PRODUCT CARD DESIGN & TYPOGRAPHY STYLES
════════════════════════════════════════════════════ */
.product-card {
    position: relative;
    background: #FFFFFF;
    border-radius: var(--radius-card);
    border: 1px solid var(--soft-platinum);
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
    transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    display: flex; flex-direction: column;
}
.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    border-color: rgba(138,104,31,0.3);
}

.card-image-wrap {
    position: relative; overflow: hidden;
    background: var(--off-white-2);
    aspect-ratio: 3 / 4;
}
.card-img {
    width: 100%; height: 100%;
    object-fit: cover; object-position: top center;
    transition: transform 0.55s cubic-bezier(0.25, 1, 0.5, 1);
}
.product-card:hover .card-img { transform: scale(1.06); }

.card-badge {
    position: absolute; bottom: 8px; left: 8px; top: auto;
    padding: 3px 8px; border-radius: 12px;
    font-size: 0.52rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;
    z-index: 2; background: rgba(138, 104, 31, 0.85); color: #FFFFFF;
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 2px 8px rgba(0,0,0,0.18);
    width: auto; max-width: calc(100% - 40px);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    line-height: 1.2;
}
@media (min-width: 600px) {
    .card-badge {
        top: 10px; left: 10px; bottom: auto;
        padding: 3.5px 9px; border-radius: 14px;
        font-size: 0.56rem; letter-spacing: 0.1em;
    }
}
.card-badge.badge-new       { background: rgba(248, 246, 240, 0.92); color: var(--dark-gold); border-color: rgba(138,104,31,0.4); }
.card-badge.badge-bridal    { background: rgba(122, 40, 77, 0.88); color: #ffffff; border-color: rgba(255,255,255,0.35); }
.card-badge.badge-heritage  { background: rgba(94, 67, 20, 0.88); color: #ffffff; border-color: rgba(255,255,255,0.35); }
.card-badge.badge-bestseller{ background: rgba(36, 33, 28, 0.85); color: #ffffff; border-color: rgba(255,255,255,0.3); }
.card-badge.badge-trending  { background: rgba(184, 107, 40, 0.88); color: #ffffff; border-color: rgba(255,255,255,0.35); }

/* ── Wishlist Button ── */
.card-wishlist-btn {
    position: absolute;
    top: clamp(4px, 1.5vw, 8px);
    right: clamp(4px, 1.5vw, 8px);
    width: clamp(24px, 7.5vw, 32px);
    height: clamp(24px, 7.5vw, 32px);
    border-radius: 50%;
    background: rgba(248,246,240,0.88);
    border: 1px solid rgba(255,255,255,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 3;
    transition: all var(--transition);
    backdrop-filter: blur(6px);
    box-shadow: 0 2px 6px rgba(0,0,0,0.12);
}
.card-wishlist-btn:hover { background: var(--gold-pale); border-color: var(--dark-gold); transform: scale(1.08); }
.card-wishlist-btn.active { background: #FDE8E8; border-color: #E57373; }
.card-wishlist-btn svg {
    width: clamp(10px, 3.2vw, 14px);
    height: clamp(10px, 3.2vw, 14px);
    stroke: var(--dark-gold);
    stroke-width: 2;
    fill: none;
    transition: all var(--transition);
}
.card-wishlist-btn.active svg { stroke: #E53935; fill: #E53935; }

/* ── Mobile Quick View Icon Button (Stacked directly below Wishlist on Mobile) ── */
.card-mobile-qv-btn {
    position: absolute;
    top: clamp(32px, 10vw, 44px);
    right: clamp(4px, 1.5vw, 8px);
    width: clamp(24px, 7.5vw, 32px) !important;
    height: clamp(24px, 7.5vw, 32px) !important;
    min-width: clamp(24px, 7.5vw, 32px) !important;
    min-height: clamp(24px, 7.5vw, 32px) !important;
    max-width: clamp(24px, 7.5vw, 32px) !important;
    max-height: clamp(24px, 7.5vw, 32px) !important;
    border-radius: 50% !important;
    padding: 0 !important;
    margin: 0 !important;
    background: rgba(248,246,240,0.88);
    border: 1px solid rgba(255,255,255,0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 3;
    transition: all var(--transition);
    backdrop-filter: blur(6px);
    box-shadow: 0 2px 6px rgba(0,0,0,0.12);
    cursor: pointer;
}
.card-mobile-qv-btn:hover, .card-mobile-qv-btn:active { background: var(--gold-pale); border-color: var(--dark-gold); transform: scale(1.08); }
.card-mobile-qv-btn svg {
    width: clamp(10px, 3.2vw, 14px);
    height: clamp(10px, 3.2vw, 14px);
    stroke: var(--dark-gold);
    stroke-width: 2;
    fill: none;
    flex-shrink: 0;
}

@media (min-width: 1024px) {
    .card-wishlist-btn {
        top: 8px; right: 8px;
        width: 34px; height: 34px;
        background: rgba(248,246,240,0.92);
        border-color: var(--soft-platinum);
    }
    .card-wishlist-btn svg { width: 14px; height: 14px; }
    .card-mobile-qv-btn { display: none !important; }
}

@media (max-width: 1023px) {
    .card-quick-view { display: none !important; }
}
.card-quick-view {
    position: absolute; bottom: 0; left: 0; right: 0;
    padding: 10px 12px;
    background: linear-gradient(to top, rgba(32,28,22,0.75) 0%, transparent 100%);
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transform: translateY(6px); transition: all var(--transition); z-index: 2;
}
.product-card:hover .card-quick-view { opacity: 1; transform: translateY(0); }
.quick-view-btn {
    font-family: var(--font-sans); font-size: 0.68rem; font-weight: 700;
    letter-spacing: 0.12em; text-transform: uppercase;
    color: var(--dark-text); padding: 7px 18px; border-radius: 20px;
    border: 1px solid rgba(138,104,31,0.3);
    background: rgba(248,246,240,0.95); backdrop-filter: blur(8px);
    transition: all var(--transition); cursor: pointer;
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}
.quick-view-btn:hover { background: var(--dark-gold); color: #fff; border-color: var(--dark-gold); }

.card-body {
    padding: clamp(6px, 1.8vw, 12px);
    display: flex;
    flex-direction: column;
    gap: 3px;
    flex: 1;
}

.card-fabric-tag {
    font-size: clamp(0.5rem, 1.5vw, 0.6rem);
    font-weight: 600;
    color: var(--dark-gold);
    letter-spacing: 0.1em;
    text-transform: uppercase;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.card-name {
    font-family: var(--font-serif);
    font-size: clamp(0.74rem, 2.2vw, 0.86rem);
    font-weight: 600;
    color: var(--dark-text);
    line-height: 1.25;
    letter-spacing: 0.01em;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    white-space: normal;
    min-height: 2.5em;
    transition: color var(--transition);
}
.product-card:hover .card-name { color: var(--dark-gold); }

.card-cat-photo-tag {
    position: absolute;
    bottom: 6px;
    right: 6px;
    font-family: var(--font-sans);
    font-size: clamp(0.48rem, 1.4vw, 0.58rem);
    font-weight: 700;
    color: var(--dark-gold);
    background: rgba(255, 255, 255, 0.92);
    border: 1px solid rgba(138, 104, 31, 0.38);
    border-radius: 4px;
    padding: 2px 6px;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    line-height: 1.1;
    backdrop-filter: blur(8px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    z-index: 2;
    pointer-events: none;
}

.card-info-text-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: clamp(0.56rem, 1.7vw, 0.68rem);
    color: var(--mid-text);
    font-weight: 600;
    margin: 2px 0 4px;
    gap: 4px;
    flex-wrap: wrap;
}
.card-colors-text {
    color: var(--dark-gold);
    font-weight: 700;
    font-size: inherit;
    white-space: nowrap;
}
.card-sizes-text {
    color: var(--light-text);
    font-size: inherit;
    white-space: nowrap;
}

.card-price-row {
    display: flex;
    align-items: center;
    gap: clamp(3px, 1.2vw, 6px);
    margin-top: auto;
    flex-wrap: wrap;
}
.card-price {
    font-family: var(--font-sans);
    font-size: clamp(0.8rem, 2.4vw, 0.96rem);
    font-weight: 700;
    color: var(--dark-gold);
}
.card-old-price {
    font-size: clamp(0.62rem, 1.8vw, 0.72rem);
    color: var(--light-text);
    text-decoration: line-through;
}
.card-price-discount {
    font-size: clamp(0.5rem, 1.5vw, 0.6rem);
    font-weight: 700;
    color: #2E7D32;
    background: #E8F5E9;
    padding: 1.5px 5px;
    border-radius: 3px;
    margin-left: auto;
    letter-spacing: 0.02em;
    white-space: nowrap;
}

/* ════════════════════════════════════════════════════
   MYNTRA-STYLE QUICK VIEW MODAL & DESKTOP STYLES
════════════════════════════════════════════════════ */
.modal-overlay {
    position: fixed; inset: 0;
    background: rgba(20, 18, 14, 0.68);
    z-index: 3000;
    display: flex; align-items: flex-end; justify-content: center;
    opacity: 0; pointer-events: none;
    transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(8px);
}
.modal-overlay.open { opacity: 1; pointer-events: all; }

.quick-modal {
    width: 100%; max-width: 500px; background: var(--off-white);
    border-radius: 20px 20px 0 0;
    transform: translateY(100%) scale(0.96);
    transition: transform 0.38s cubic-bezier(0.32, 0.72, 0, 1);
    max-height: 90vh; overflow-y: auto;
    box-shadow: 0 24px 64px rgba(0,0,0,0.35);
    position: relative;
}
.modal-overlay.open .quick-modal { transform: translateY(0) scale(1); }

@media (min-width: 1024px) {
    .modal-overlay {
        align-items: center;
        padding: 40px 20px;
    }
    .quick-modal {
        max-width: 860px;
        border-radius: 16px;
        transform: scale(0.92);
        opacity: 0;
        transition: transform 0.35s cubic-bezier(0.34, 1.4, 0.64, 1), opacity 0.3s ease;
        max-height: 86vh;
        border: 1px solid var(--soft-platinum);
    }
    .modal-overlay.open .quick-modal {
        transform: scale(1);
        opacity: 1;
    }
}

.modal-handle { width: 36px; height: 4px; background: var(--soft-platinum); border-radius: 2px; margin: 12px auto 4px; }
@media (min-width: 1024px) { .modal-handle { display: none; } }

.modal-close-btn {
    position: absolute; top: 16px; right: 16px;
    width: 36px; height: 36px; border-radius: 50%;
    border: 1.5px solid var(--soft-platinum); background: var(--off-white);
    display: flex; align-items: center; justify-content: center;
    color: var(--mid-text); cursor: pointer; transition: all var(--transition);
    z-index: 10;
}
.modal-close-btn:hover { border-color: var(--dark-gold); color: var(--dark-gold); transform: rotate(90deg); }
.modal-close-btn svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

.modal-content { padding: 20px 20px 30px; position: relative; }
@media (min-width: 1024px) {
    .modal-content {
        padding: 32px 36px;
        display: grid;
        grid-template-columns: 340px 1fr;
        gap: 32px;
        align-items: center;
    }
}

.modal-image-wrap {
    border-radius: 12px; overflow: hidden;
    background: var(--off-white-2); aspect-ratio: 3/4;
    position: relative; box-shadow: 0 6px 24px rgba(0,0,0,0.08);
}
.modal-image-wrap img { width: 100%; height: 100%; object-fit: cover; object-position: top; }
.modal-badge-tag {
    position: absolute; top: 12px; left: 12px;
    padding: 4px 10px; border-radius: 4px;
    font-size: 0.62rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase;
    background: var(--dark-gold); color: var(--off-white);
}

.modal-details {
    display: flex; flex-direction: column; gap: 10px; text-align: left;
}

.modal-brand-name {
    font-size: 0.72rem; font-weight: 700; color: var(--dark-gold);
    letter-spacing: 0.22em; text-transform: uppercase;
}
.modal-name {
    font-family: var(--font-serif); font-size: 1.45rem; font-weight: 600;
    color: var(--dark-text); line-height: 1.25; margin-top: -2px;
}

/* Myntra Rating Box Pill */
.modal-rating-box {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 10px; border-radius: 4px;
    border: 1px solid var(--soft-platinum);
    background: var(--off-white-2); width: fit-content;
    font-size: 0.73rem; font-weight: 600; color: var(--dark-text);
}
.m-rating-num { color: var(--dark-gold); font-weight: 700; }
.m-rating-sep { color: var(--platinum); font-size: 0.7rem; }
.m-rating-count { color: var(--mid-text); font-weight: 500; font-size: 0.7rem; }

.modal-divider { width: 100%; height: 1px; background: var(--soft-platinum); margin: 2px 0; }

/* Myntra Price Block */
.modal-price-block { display: flex; flex-direction: column; gap: 2px; }
.modal-price-row { display: flex; align-items: baseline; gap: 10px; }
.modal-price { font-size: 1.45rem; font-weight: 700; color: var(--dark-text); font-family: var(--font-sans); }
.modal-mrp { font-size: 0.85rem; color: var(--light-text); font-weight: 500; }
.modal-old-price { text-decoration: line-through; }
.modal-discount-tag { font-size: 0.85rem; font-weight: 700; color: #C07B39; letter-spacing: 0.04em; }
.modal-tax-note { font-size: 0.68rem; font-weight: 600; color: #2E7D32; letter-spacing: 0.05em; text-transform: uppercase; }

/* Myntra Size Selection */
.modal-size-section { display: flex; flex-direction: column; gap: 8px; margin-top: 4px; }
.modal-size-header { display: flex; align-items: center; justify-content: space-between; width: 100%; font-size: 0.75rem; font-weight: 700; color: var(--dark-text); letter-spacing: 0.12em; text-transform: uppercase; }
.modal-product-details-btn {
    font-size: 0.68rem;
    color: var(--dark-gold);
    font-weight: 700;
    cursor: pointer;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    position: relative;
    padding-bottom: 2px;
    margin-left: auto;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    gap: 4px;
    user-select: none;
}
.modal-product-details-btn::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 1.5px;
    background: var(--dark-gold);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), background-color 0.3s;
    transform-origin: left;
}
.modal-product-details-btn:hover {
    color: var(--deep-gold);
    transform: translateX(2px);
}
.modal-product-details-btn:hover::after {
    background: var(--deep-gold);
    transform: scaleX(1.1);
}
.modal-product-details-btn:active {
    transform: scale(0.96);
}
.modal-size-pills { display: flex; gap: 8px; flex-wrap: wrap; }
.m-size-btn {
    min-width: 42px; height: 42px; border-radius: 50%;
    border: 1.5px solid var(--soft-platinum); background: var(--off-white);
    font-size: 0.75rem; font-weight: 700; color: var(--dark-text);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all var(--transition);
    padding: 0 10px;
}
.m-size-btn:hover { border-color: var(--dark-gold); color: var(--dark-gold); }
.m-size-btn.active { border-color: var(--dark-gold); background: var(--dark-gold); color: var(--off-white); box-shadow: 0 2px 8px rgba(138,104,31,0.25); }

/* Myntra Dual Action Buttons (Add to Bag + Wishlist) */
.modal-actions-myntra { display: flex; gap: 12px; margin-top: 8px; }
.modal-add-bag-btn {
    flex: 2; padding: 14px 16px; border-radius: 6px;
    background: var(--dark-gold); color: var(--off-white);
    font-family: var(--font-sans); font-size: 0.82rem; font-weight: 700;
    letter-spacing: 0.14em; text-transform: uppercase;
    transition: all var(--transition); border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.modal-add-bag-btn:hover { background: var(--deep-gold); box-shadow: 0 4px 18px rgba(138,104,31,0.32); }
.modal-add-bag-btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

.modal-wishlist-btn {
    flex: 1; padding: 14px 14px; border-radius: 6px;
    background: var(--off-white); color: var(--dark-text);
    border: 1.5px solid var(--soft-platinum);
    font-family: var(--font-sans); font-size: 0.78rem; font-weight: 700;
    letter-spacing: 0.12em; text-transform: uppercase;
    transition: all var(--transition); cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 6px;
}
.modal-wishlist-btn:hover { border-color: var(--dark-gold); color: var(--dark-gold); background: var(--gold-pale); }
.modal-wishlist-btn.active { border-color: #E53935; color: #E53935; background: #FDE8E8; }
.modal-wishlist-btn svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }
.modal-wishlist-btn.active svg { fill: #E53935; }

/* Myntra Delivery Perks */
.modal-perks { display: flex; flex-direction: column; gap: 6px; margin-top: 6px; padding-top: 10px; border-top: 1px dashed var(--soft-platinum); }
.m-perk-item { display: flex; align-items: center; gap: 8px; font-size: 0.72rem; color: var(--mid-text); font-weight: 500; }
.m-perk-item svg { width: 14px; height: 14px; stroke: var(--dark-gold); fill: none; stroke-width: 2; flex-shrink: 0; }

/* ── Luxury Product Details Modal (Gold Theme & Line Accents) ── */
.product-details-backdrop {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(24, 20, 16, 0.78); backdrop-filter: blur(10px);
    display: flex; align-items: center; justify-content: center;
    z-index: 10000; opacity: 0; visibility: hidden;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1); padding: 16px;
}
.product-details-backdrop.active { opacity: 1; visibility: visible; }
.product-details-content {
    background: linear-gradient(180deg, #FFFFFF 0%, #FAF6EE 100%); width: 100%; max-width: 560px;
    border-radius: 16px; border: 1.5px solid rgba(138,104,31,0.35);
    border-top: 4px solid var(--dark-gold);
    box-shadow: 0 24px 48px rgba(0,0,0,0.3), 0 0 20px rgba(138,104,31,0.15); overflow: hidden;
    transform: translateY(24px) scale(0.96); transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.product-details-backdrop.active .product-details-content { transform: translateY(0) scale(1); }
.pd-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 18px 22px; border-bottom: 2px solid var(--dark-gold);
    background: #FFFFFF;
}
.pd-title { font-family: var(--font-serif); font-size: 1.25rem; color: var(--dark-gold); font-weight: 700; margin: 0; letter-spacing: 0.04em; }
.pd-subtitle { font-size: 0.68rem; color: var(--mid-text); font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; display: block; margin-top: 2px; }
.pd-close-btn { background: none; border: none; font-size: 1.6rem; color: var(--dark-gold); cursor: pointer; transition: all 0.25s; line-height: 1; padding: 0 4px; }
.pd-close-btn:hover { color: var(--dark-text); transform: scale(1.15) rotate(90deg); }
.pd-body { padding: 20px 22px; display: flex; flex-direction: column; gap: 14px; max-height: 80vh; overflow-y: auto; }

.pd-hero-box { display: flex; gap: 16px; background: #FFFFFF; padding: 16px; border-radius: 12px; border: 1px solid rgba(138,104,31,0.25); border-left: 3px solid var(--dark-gold); align-items: center; box-shadow: 0 4px 12px rgba(138,104,31,0.06); }
.pd-hero-img { width: 92px; height: 118px; object-fit: cover; border-radius: 8px; border: 1.5px solid rgba(138,104,31,0.25); flex-shrink: 0; }
.pd-hero-info { display: flex; flex-direction: column; gap: 7px; flex: 1; }

.pd-price-row { display: flex; align-items: baseline; gap: 10px; flex-wrap: wrap; }
.pd-price { font-size: 1.4rem; font-weight: 800; color: var(--dark-gold); font-family: var(--font-sans); }
.pd-old-price { font-size: 0.82rem; color: var(--light-text); text-decoration: line-through; }
.pd-tag { font-size: 0.68rem; font-weight: 700; color: #8A681F; background: #FAF3E0; padding: 3px 10px; border-radius: 12px; border: 1px solid rgba(138,104,31,0.35); }

.pd-meta-row { display: flex; align-items: center; gap: 8px; font-size: 0.72rem; flex-wrap: wrap; }
.pd-meta-label { font-weight: 700; color: var(--dark-gold); text-transform: uppercase; font-size: 0.65rem; letter-spacing: 0.08em; }
.pd-size-pills { display: flex; gap: 5px; flex-wrap: wrap; }
.pd-size-pill { font-size: 0.65rem; font-weight: 700; background: #FAF3E0; color: var(--dark-gold); padding: 3px 10px; border-radius: 12px; border: 1px solid rgba(138,104,31,0.3); }
.pd-color-badge { display: flex; align-items: center; gap: 6px; font-weight: 700; color: var(--dark-text); }
.pd-color-dot { width: 11px; height: 11px; border-radius: 50%; border: 1px solid rgba(0,0,0,0.25); display: inline-block; box-shadow: 0 0 4px rgba(0,0,0,0.2); }

.pd-desc-box { background: #FFFFFF; padding: 16px; border-radius: 12px; border: 1px solid rgba(138,104,31,0.25); border-left: 3px solid var(--dark-gold); }
.pd-section-title { font-size: 0.8rem; font-weight: 700; color: var(--dark-gold); text-transform: uppercase; letter-spacing: 0.1em; margin: 0 0 8px; border-bottom: 1.5px solid rgba(138,104,31,0.2); padding-bottom: 5px; }
.pd-full-desc { font-size: 0.8rem; color: var(--dark-text); margin: 0; line-height: 1.65; }

.pd-specs-section { background: #FFFFFF; padding: 16px; border-radius: 12px; border: 1px solid rgba(138,104,31,0.25); border-left: 3px solid var(--dark-gold); }
.pd-specs-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
.pd-spec-item { display: flex; flex-direction: column; gap: 2px; }
.pd-spec-label { font-size: 0.65rem; color: var(--dark-gold); font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; }
.pd-spec-val { font-size: 0.8rem; color: var(--dark-text); font-weight: 600; }
.pd-assurance-box { display: flex; flex-direction: column; gap: 9px; background: rgba(138,104,31,0.06); border: 1.5px solid rgba(138,104,31,0.25); border-radius: 12px; padding: 14px 16px; }
.pd-assure-item { display: flex; align-items: center; gap: 10px; font-size: 0.75rem; color: var(--dark-text); font-weight: 700; }
.pd-assure-item svg { width: 15px; height: 15px; stroke: var(--dark-gold); fill: none; stroke-width: 2; flex-shrink: 0; }

/* ── Cart Drawer & Wishlist Drawer Modals ── */
.cart-drawer-backdrop, .wishlist-drawer-backdrop {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(24, 20, 16, 0.78); backdrop-filter: blur(10px);
    display: flex; align-items: center; justify-content: flex-end;
    z-index: 999999 !important; opacity: 0; visibility: hidden;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.cart-drawer-backdrop.active, .wishlist-drawer-backdrop.active { opacity: 1; visibility: visible; }

.cart-drawer-content, .wishlist-drawer-content {
    background: linear-gradient(180deg, #FFFFFF 0%, #FAF6EE 100%);
    width: 100%; max-width: 440px; height: 100%;
    box-shadow: -10px 0 30px rgba(0,0,0,0.25);
    display: flex; flex-direction: column;
    transform: translateX(100%); transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    border-left: 3px solid var(--dark-gold);
}
.cart-drawer-backdrop.active .cart-drawer-content,
.wishlist-drawer-backdrop.active .wishlist-drawer-content {
    transform: translateX(0);
}

.cd-header, .wd-header { display: flex; align-items: center; justify-content: space-between; padding: 18px 22px; border-bottom: 2px solid var(--dark-gold); background: #FFFFFF; }
.cd-title, .wd-title { font-family: var(--font-serif); font-size: 1.2rem; color: var(--dark-gold); font-weight: 700; margin: 0; }
.cd-subtitle, .wd-subtitle { font-size: 0.68rem; color: var(--mid-text); font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; display: block; margin-top: 2px; }
.cd-close-btn, .wd-close-btn { background: none; border: none; font-size: 1.6rem; color: var(--dark-gold); cursor: pointer; transition: all 0.2s; line-height: 1; }
.cd-close-btn:hover, .wd-close-btn:hover { color: var(--dark-text); transform: rotate(90deg); }

.cd-body, .wd-body { padding: 18px 22px; flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 14px; }

.cd-item, .wd-item { display: flex; gap: 14px; background: #FFFFFF; padding: 12px; border-radius: 12px; border: 1px solid rgba(138,104,31,0.2); align-items: center; }
.cd-item-img, .wd-item-img { width: 72px; height: 94px; object-fit: cover; border-radius: 8px; border: 1px solid rgba(138,104,31,0.2); flex-shrink: 0; }
.cd-item-info, .wd-item-info { display: flex; flex-direction: column; gap: 4px; flex: 1; }
.cd-item-title, .wd-item-title { font-family: var(--font-serif); font-size: 0.92rem; font-weight: 700; color: var(--dark-text); margin: 0; }
.cd-item-meta, .wd-item-meta { font-size: 0.7rem; color: var(--mid-text); font-weight: 500; }
.cd-price-row { display: flex; align-items: baseline; gap: 8px; }
.cd-item-price, .wd-item-price { font-size: 0.95rem; font-weight: 800; color: var(--dark-gold); }
.cd-item-old, .wd-item-old { font-size: 0.75rem; color: var(--light-text); text-decoration: line-through; }

.cd-qty-wrap { display: flex; align-items: center; gap: 8px; margin-top: 4px; }
.cd-qty-btn { width: 26px; height: 26px; border-radius: 6px; border: 1px solid var(--dark-gold); background: #FAF3E0; color: var(--dark-gold); font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; }
.cd-qty-num { font-size: 0.8rem; font-weight: 700; color: var(--dark-text); min-width: 16px; text-align: center; }
.cd-remove-btn, .wd-remove-btn { border: none; background: none; color: #E53935; font-size: 0.72rem; font-weight: 600; cursor: pointer; margin-left: auto; }
.wd-actions { display: flex; align-items: center; gap: 8px; margin-top: 6px; }
.wd-move-bag-btn { padding: 6px 12px; border-radius: 6px; background: var(--dark-gold); color: #FFF; border: none; font-size: 0.68rem; font-weight: 700; letter-spacing: 0.08em; cursor: pointer; }

.cd-footer { padding: 18px 22px; border-top: 2px solid var(--dark-gold); background: #FFFFFF; display: flex; flex-direction: column; gap: 10px; }
.cd-summary-row { display: flex; align-items: center; justify-content: space-between; font-size: 0.85rem; font-weight: 700; color: var(--dark-text); }
.cd-total-val { font-size: 1.2rem; color: var(--dark-gold); }
.cd-shipping { font-size: 0.75rem; color: var(--mid-text); font-weight: 500; }
.cd-free-txt { color: #2E7D32; font-weight: 700; }
.cd-checkout-btn { width: 100%; padding: 14px; border-radius: 8px; background: var(--dark-gold); color: #FFF; border: none; font-family: var(--font-sans); font-size: 0.85rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 14px rgba(138,104,31,0.25); }
.cd-checkout-btn:hover { background: var(--deep-gold); }

.modal-content { padding: 20px 20px 30px; position: relative; }
@media (min-width: 1024px) {
    .modal-content {
        padding: 32px 36px;
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 28px;
        align-items: center;
    }
}

.modal-image-wrap {
    border-radius: 12px; overflow: hidden;
    background: var(--off-white-2); aspect-ratio: 3/4;
    position: relative; box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}
.modal-image-wrap img { width: 100%; height: 100%; object-fit: cover; object-position: top; }
.modal-desc { font-size: 0.8rem; color: var(--mid-text); line-height: 1.65; margin-bottom: 18px; }
.modal-atc-btn {
    width: 100%; padding: 13px; border-radius: 8px;
    background: var(--dark-gold); color: var(--off-white);
    font-family: var(--font-sans); font-size: 0.82rem; font-weight: 700;
    letter-spacing: 0.16em; text-transform: uppercase;
    transition: all var(--transition);
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.modal-atc-btn:hover { background: var(--deep-gold); }
.modal-atc-btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2; }

/* Toast */
.toast-container {
    position: fixed; bottom: calc(var(--bottom-bar-h) + 16px); left: 50%;
    transform: translateX(-50%); z-index: 5000;
    display: flex; flex-direction: column; align-items: center; gap: 8px;
    pointer-events: none;
}
.toast {
    padding: 10px 22px; border-radius: 30px;
    background: var(--dark-text); color: var(--off-white);
    font-size: 0.78rem; font-weight: 500; letter-spacing: 0.04em;
    box-shadow: 0 4px 24px rgba(0,0,0,0.22); white-space: nowrap;
    opacity: 0; transform: translateY(8px) scale(0.96); transition: all 0.3s ease;
}
.toast.show { opacity: 1; transform: translateY(0) scale(1); }
</style>
</head>
<body>

<!-- ════════════ HEADER PARTIAL ════════════ -->
<?php include 'shophader.php'; ?>

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
                        <img src="images/product1.png" alt="Royal Silk Sarees" loading="lazy" />
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
                        <img src="images/product5.png" alt="Designer Kurtis" loading="lazy" />
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
                        <img src="images/product6.png" alt="Bridal Lehengas" loading="lazy" />
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
                    <button class="sf-chip active" data-sf-type="category" data-sf-val="All" aria-pressed="true">All</button>
                    <button class="sf-chip" data-sf-type="category" data-sf-val="Sarees" aria-pressed="false">Sarees</button>
                    <button class="sf-chip" data-sf-type="category" data-sf-val="Kurtis" aria-pressed="false">Kurtis</button>
                    <button class="sf-chip" data-sf-type="category" data-sf-val="Gowns" aria-pressed="false">Gowns</button>
                    <button class="sf-chip" data-sf-type="category" data-sf-val="Lehengas" aria-pressed="false">Lehengas</button>
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
                $badge_class = !empty($p['badge']) ? 'badge-'.strtolower($p['badge']) : '';
                $stars_full  = floor($p['rating']);
                $stars_empty = 5 - $stars_full;
                $size_str    = implode(',', $p['size']);
            ?>
            <article
                class="product-card"
                role="listitem"
                data-product-id="<?= $p['id'] ?>"
                data-category="<?= htmlspecialchars($p['category']) ?>"
                data-price="<?= $p['price'] ?>"
                data-color="<?= htmlspecialchars($p['color']) ?>"
                data-size="<?= htmlspecialchars($size_str) ?>"
                data-fabric="<?= htmlspecialchars($p['fabric']) ?>"
                data-discount="<?= $p['discount'] ?>"
                data-stock="<?= $p['in_stock'] ? 'In Stock' : 'Pre-Order' ?>"
                aria-label="<?= htmlspecialchars($p['name']) ?>"
            >
                <div class="card-image-wrap">
                    <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['name']) ?>" class="card-img" loading="lazy" />

                    <?php if (!empty($p['badge'])): ?>
                    <span class="card-badge <?= $badge_class ?>"><?= htmlspecialchars($p['badge']) ?></span>
                    <?php endif; ?>

                    <button class="card-wishlist-btn" data-id="<?= $p['id'] ?>" aria-label="Wishlist <?= htmlspecialchars($p['name']) ?>" aria-pressed="false">
                        <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                    </button>

                    <button class="card-mobile-qv-btn quick-view-btn" data-id="<?= $p['id'] ?>" aria-label="Quick View <?= htmlspecialchars($p['name']) ?>">
                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </button>

                    <div class="card-quick-view" aria-hidden="true">
                        <button class="quick-view-btn" data-id="<?= $p['id'] ?>">Quick View</button>
                    </div>

                    <!-- Category Box on Photo Bottom-Right Corner -->
                    <span class="card-cat-photo-tag"><?= htmlspecialchars($p['category']) ?></span>
                </div>

                <div class="card-body">
                    <!-- Product Title -->
                    <h2 class="card-name"><?= htmlspecialchars($p['name']) ?></h2>

                    <!-- Clean Text Info Row: Available Colours & Sizes -->
                    <?php 
                    $pCols = !empty($p['colors']) ? $p['colors'] : [$p['color']];
                    $pSizes = !empty($p['size']) ? $p['size'] : ['Free Size'];
                    ?>
                    <div class="card-info-text-row">
                        <span class="card-colors-text"><?= count($pCols) ?> Colours</span>
                        <span class="card-sizes-text"><?= htmlspecialchars(implode(', ', $pSizes)) ?></span>
                    </div>

                    <div class="card-price-row">
                        <span class="card-price">₹<?= number_format($p['price']) ?></span>
                        <?php if (!empty($p['old_price'])): ?>
                        <span class="card-old-price">₹<?= number_format($p['old_price']) ?></span>
                        <?php endif; ?>
                        <?php if (!empty($p['discount'])): ?>
                        <span class="card-price-discount"><?= $p['discount'] ?>% OFF</span>
                        <?php endif; ?>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
            </div>

            <!-- No Products Found Message (Hidden by default) -->
            <div class="no-products-found" id="noProductsMsg" style="display:none;">
                <h3 class="np-title">No Matching Products</h3>
                <p class="np-desc">We couldn't find any items matching your selected filter criteria.</p>
                <button class="np-reset-btn" id="npResetBtn">Clear All Filters</button>
            </div>

            </div>
        </main>

    </div><!-- /.products-area -->
    </div><!-- /.shop-layout -->
</div><!-- /.page-wrapper -->

<!-- ════════════ QUICK VIEW PARTIAL ════════════ -->
<?php include 'quickview.php'; ?>

<!-- ════════════ TOAST ════════════ -->
<div class="toast-container" id="toastContainer" aria-live="assertive" aria-atomic="true"></div>

<!-- ════════════ BOTTOM BAR PARTIAL ════════════ -->
<?php include 'shopbottomfotoer.php'; ?>

<!-- ════════════ MASTER SCRIPT ENGINE ════════════ -->
<script>
(function () {
    'use strict';

    var products = <?= json_encode(array_values($products)) ?>;
    window.allProducts = products;

    /* Global Toast helper */
    window.showToast = function (msg) {
        var c = document.getElementById('toastContainer');
        var t = document.createElement('div');
        t.className = 'toast';
        t.textContent = msg;
        c.appendChild(t);
        requestAnimationFrame(function () {
            requestAnimationFrame(function () { t.classList.add('show'); });
        });
        setTimeout(function () {
            t.classList.remove('show');
            setTimeout(function () { t.remove(); }, 400);
        }, 2200);
    };

    /* ════════════════════════════════════════════════════
       MASTER FILTER ENGINE & STATE MANAGEMENT
    ════════════════════════════════════════════════════ */
    window.masterFilterState = {
        category: 'All',
        colors: [],
        sizes: [],
        fabrics: [],
        minPrice: 500,
        maxPrice: 30000,
        minDiscount: 0,
        availability: [],
        sortBy: 'recommended'
    };

    var cardElems = document.querySelectorAll('.product-card');

    /* ── Sub-Category Data for Round Circles ── */
    var subCategoryData = {
        'All': [
            { label: 'All Items', icon: '✦', gradient: 'gradient-1', type: 'all' },
            { label: 'Banarasi', img: 'images/product1.png', type: 'fabric', val: 'Pure Silk' },
            { label: 'Kanjeevaram', img: 'images/product2.png', type: 'fabric', val: 'Art Silk' },
            { label: 'Chanderi', img: 'images/product3.png', type: 'fabric', val: 'Cotton' },
            { label: 'Anarkali', img: 'images/product5.png', type: 'category', val: 'Kurtis' },
            { label: 'Lehengas', img: 'images/product6.png', type: 'category', val: 'Lehengas' },
            { label: 'Royal Gowns', img: 'images/product8.png', type: 'category', val: 'Gowns' },
            { label: 'Straight Cut', img: 'images/product7.png', type: 'fabric', val: 'Georgette' }
        ],
        'Sarees': [
            { label: 'All Sarees', img: 'images/product1.png', type: 'all_sub' },
            { label: 'Banarasi Silk', img: 'images/product1.png', type: 'fabric', val: 'Pure Silk' },
            { label: 'Kanjeevaram', img: 'images/product2.png', type: 'fabric', val: 'Art Silk' },
            { label: 'Chanderi', img: 'images/product3.png', type: 'fabric', val: 'Cotton' },
            { label: 'Organza', img: 'images/product4.png', type: 'fabric', val: 'Organza' },
            { label: 'Georgette', img: 'images/product1.png', type: 'fabric', val: 'Georgette' },
            { label: 'Silk Blend', img: 'images/product2.png', type: 'fabric', val: 'Silk Blend' }
        ],
        'Kurtis': [
            { label: 'All Kurtis', img: 'images/product5.png', type: 'all_sub' },
            { label: 'Anarkali Sets', img: 'images/product5.png', type: 'fabric', val: 'Georgette' },
            { label: 'Straight Cut', img: 'images/product7.png', type: 'fabric', val: 'Cotton' },
            { label: 'Silk Festive', img: 'images/product5.png', type: 'fabric', val: 'Pure Silk' },
            { label: 'Chiffon Print', img: 'images/product7.png', type: 'fabric', val: 'Chiffon' }
        ],
        'Gowns': [
            { label: 'All Gowns', img: 'images/product8.png', type: 'all_sub' },
            { label: 'Indo-Western', img: 'images/product8.png', type: 'fabric', val: 'Georgette' },
            { label: 'Party Wear', img: 'images/product8.png', type: 'fabric', val: 'Silk Blend' },
            { label: 'Zardozi Work', img: 'images/product8.png', type: 'fabric', val: 'Velvet' }
        ],
        'Lehengas': [
            { label: 'All Lehengas', img: 'images/product6.png', type: 'all_sub' },
            { label: 'Bridal Velvet', img: 'images/product6.png', type: 'fabric', val: 'Velvet' },
            { label: 'Silk Festive', img: 'images/product6.png', type: 'fabric', val: 'Pure Silk' },
            { label: 'Georgette', img: 'images/product6.png', type: 'fabric', val: 'Georgette' }
        ],
        'New Arrivals': [
            { label: '★ All New In', icon: '★', gradient: 'gradient-6', type: 'all_sub' },
            { label: 'Silk Sarees', img: 'images/product1.png', type: 'category', val: 'Sarees' },
            { label: 'Bridal Sets', img: 'images/product6.png', type: 'category', val: 'Lehengas' },
            { label: 'Designer Gowns', img: 'images/product8.png', type: 'category', val: 'Gowns' },
            { label: 'Anarkalis', img: 'images/product5.png', type: 'category', val: 'Kurtis' }
        ]
    };

    window.renderSubCategories = function(mainCat) {
        var track = document.getElementById('catSliderTrack');
        if (!track) return;

        var list = subCategoryData[mainCat] || subCategoryData['All'];
        track.innerHTML = list.map(function(item, idx) {
            var isAct = idx === 0;
            var circleContent = '';
            if (item.img) {
                circleContent = '<img src="' + item.img + '" alt="' + item.label + '" loading="lazy" />';
            } else {
                circleContent = '<span class="cat-icon" aria-hidden="true">' + (item.icon || '●') + '</span>';
            }

            return '<button class="cat-item ' + (isAct ? 'active' : '') + '" role="listitem" data-type="' + (item.type || '') + '" data-val="' + (item.val || '') + '" aria-pressed="' + (isAct ? 'true' : 'false') + '" aria-label="' + item.label + '">' +
                '<div class="cat-ring">' +
                    '<div class="cat-circle ' + (item.gradient || '') + '">' + circleContent + '</div>' +
                '</div>' +
                '<span class="cat-label">' + item.label + '</span>' +
            '</button>';
        }).join('');

        // Bind clicks on new round sub-category items
        track.querySelectorAll('.cat-item').forEach(function(btn) {
            btn.addEventListener('click', function() {
                track.querySelectorAll('.cat-item').forEach(function(b) { b.classList.remove('active'); b.setAttribute('aria-pressed','false'); });
                btn.classList.add('active'); btn.setAttribute('aria-pressed','true');
                btn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });

                var type = btn.dataset.type;
                var val  = btn.dataset.val;
                var st   = window.masterFilterState;

                if (type === 'fabric') {
                    st.fabrics = [val];
                } else if (type === 'category') {
                    st.category = val;
                    st.fabrics = [];
                } else {
                    st.fabrics = [];
                }

                window.applyMasterFilters();
                if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
            });
        });
    };

    /* Category Slider Mouse Drag on Desktop */
    function enableDragScroll(selector) {
        var tr = document.querySelector(selector);
        if (!tr) return;
        var isDown = false, startX, scrollLeft;
        tr.style.cursor = 'grab';
        tr.addEventListener('mousedown', function(e) {
            isDown = true;
            tr.style.cursor = 'grabbing';
            startX = e.pageX - tr.offsetLeft;
            scrollLeft = tr.scrollLeft;
        });
        window.addEventListener('mouseup', function() {
            isDown = false;
            if (tr) tr.style.cursor = 'grab';
        });
        tr.addEventListener('mousemove', function(e) {
            if (!isDown) return;
            e.preventDefault();
            var x = e.pageX - tr.offsetLeft;
            var walk = (x - startX) * 1.5;
            tr.scrollLeft = scrollLeft - walk;
        });
    }
    enableDragScroll('.cat-slider-track');
    enableDragScroll('.main-cat-slider-track');

    window.applyMasterFilters = function() {
        var st = window.masterFilterState;
        var total = 0;

        cardElems.forEach(function(card) {
            var catMatch = (st.category === 'All' || st.category === 'New Arrivals' || card.dataset.category === st.category);
            
            var price = parseInt(card.dataset.price);
            var priceMatch = (price >= st.minPrice && price <= st.maxPrice);

            var colorMatch = true;
            if (st.colors.length > 0) {
                colorMatch = st.colors.indexOf(card.dataset.color) !== -1;
            }

            var sizeMatch = true;
            if (st.sizes.length > 0) {
                var cardSizes = card.dataset.size ? card.dataset.size.split(',') : [];
                sizeMatch = st.sizes.some(function(s){ return cardSizes.indexOf(s) !== -1; });
            }

            var fabricMatch = true;
            if (st.fabrics.length > 0) {
                fabricMatch = st.fabrics.indexOf(card.dataset.fabric) !== -1;
            }

            var discount = parseInt(card.dataset.discount || '0');
            var discountMatch = (discount >= st.minDiscount);

            var stockMatch = true;
            if (st.availability.length > 0) {
                stockMatch = st.availability.indexOf(card.dataset.stock) !== -1;
            }

            var searchMatch = true;
            if (st.searchQuery && st.searchQuery.length > 0) {
                var q = st.searchQuery.toLowerCase();
                var cardName = (card.querySelector('.card-title') ? card.querySelector('.card-title').textContent : '').toLowerCase();
                var cardCat = (card.dataset.category || '').toLowerCase();
                var cardFabric = (card.dataset.fabric || '').toLowerCase();
                var cardColor = (card.dataset.color || '').toLowerCase();
                searchMatch = cardName.indexOf(q) !== -1 || cardCat.indexOf(q) !== -1 || cardFabric.indexOf(q) !== -1 || cardColor.indexOf(q) !== -1;
            }

            var isMatch = catMatch && priceMatch && colorMatch && sizeMatch && fabricMatch && discountMatch && stockMatch && searchMatch;

            if (isMatch) {
                card.style.display = '';
                total++;
            } else {
                card.style.display = 'none';
            }
        });

        // Handle sorting if cards are visible
        if (st.sortBy) {
            var grid = document.getElementById('productsGrid');
            var sortedCards = Array.from(cardElems);
            sortedCards.sort(function(a, b) {
                var pA = parseInt(a.dataset.price), pB = parseInt(b.dataset.price);
                var dA = parseInt(a.dataset.discount||'0'), dB = parseInt(b.dataset.discount||'0');
                if (st.sortBy === 'price_asc') return pA - pB;
                if (st.sortBy === 'price_desc') return pB - pA;
                if (st.sortBy === 'discount') return dB - dA;
                return parseInt(a.dataset.productId) - parseInt(b.dataset.productId);
            });
            sortedCards.forEach(function(c){ grid.appendChild(c); });
        }

        // Show/Hide Empty State
        var noMsg = document.getElementById('noProductsMsg');
        if (noMsg) noMsg.style.display = (total === 0) ? 'block' : 'none';

        // Update product count label
        var ptbCount = document.getElementById('ptbCount');
        if (ptbCount) ptbCount.textContent = 'Showing ' + total + ' of ' + products.length + ' Products';

        // Sync Mobile Apply button text if exists
        var mfApplyBtn = document.getElementById('mfApplyBtn');
        if (mfApplyBtn) mfApplyBtn.textContent = 'Apply Filters (' + total + ')';

        // Render Active Filter Tags
        renderActiveTags();

        // Sync Desktop Sidebar badges
        syncSidebarUI();
    };

    function renderActiveTags() {
        var bar = document.getElementById('activeFilterBar');
        var wrap = document.getElementById('activeFilterTagsWrap');
        if (!bar || !wrap) return;

        var st = window.masterFilterState;
        var tags = [];

        if (st.category !== 'All') {
            tags.push({ label: st.category, type: 'category', val: st.category });
        }
        if (st.minPrice > 500 || st.maxPrice < 30000) {
            tags.push({ label: '₹' + st.minPrice.toLocaleString() + ' - ₹' + st.maxPrice.toLocaleString(), type: 'price' });
        }
        st.colors.forEach(function(c){ tags.push({ label: c, type: 'color', val: c }); });
        st.sizes.forEach(function(s){ tags.push({ label: 'Size: ' + s, type: 'size', val: s }); });
        st.fabrics.forEach(function(f){ tags.push({ label: f, type: 'fabric', val: f }); });
        if (st.minDiscount > 0) {
            tags.push({ label: st.minDiscount + '%+ Off', type: 'discount' });
        }
        st.availability.forEach(function(a){ tags.push({ label: a, type: 'availability', val: a }); });

        if (tags.length > 0) {
            bar.classList.add('has-tags');
            wrap.innerHTML = tags.map(function(t) {
                return '<span class="active-filter-tag">' + t.label + 
                       ' <button onclick="removeFilterTag(\'' + t.type + '\', \'' + (t.val || '') + '\')" aria-label="Remove filter">✕</button></span>';
            }).join('');
        } else {
            bar.classList.remove('has-tags');
            wrap.innerHTML = '';
        }
    }

    window.removeFilterTag = function(type, val) {
        var st = window.masterFilterState;
        if (type === 'category') {
            st.category = 'All';
            catItems.forEach(function(ci){ ci.classList.toggle('active', ci.dataset.category === 'All'); });
        } else if (type === 'price') {
            st.minPrice = 500; st.maxPrice = 30000;
            var sfMin = document.getElementById('sfPriceMin'), sfMax = document.getElementById('sfPriceMax');
            if (sfMin) { sfMin.value = 500; sfMax.value = 30000; }
        } else if (type === 'color') {
            st.colors = st.colors.filter(function(x){ return x !== val; });
        } else if (type === 'size') {
            st.sizes = st.sizes.filter(function(x){ return x !== val; });
        } else if (type === 'fabric') {
            st.fabrics = st.fabrics.filter(function(x){ return x !== val; });
        } else if (type === 'discount') {
            st.minDiscount = 0;
        } else if (type === 'availability') {
            st.availability = st.availability.filter(function(x){ return x !== val; });
        }
        window.applyMasterFilters();
        if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
    };

    function syncSidebarUI() {
        var st = window.masterFilterState;
        
        // Active total count badge
        var totalActive = (st.category !== 'All' ? 1 : 0) + st.colors.length + st.sizes.length + st.fabrics.length + (st.minDiscount > 0 ? 1 : 0) + st.availability.length + ((st.minPrice > 500 || st.maxPrice < 30000) ? 1 : 0);
        var mainBadge = document.getElementById('sfActiveBadge');
        if (mainBadge) {
            mainBadge.style.display = totalActive > 0 ? 'inline-flex' : 'none';
            mainBadge.textContent = totalActive;
        }

        // Section Badges
        updateSecBadge('sec-category', 'badge-category', st.category !== 'All', st.category);
        updateSecBadge('sec-price', 'badge-price', st.minPrice > 500 || st.maxPrice < 30000, 'Custom');
        updateSecBadge('sec-color', 'badge-color', st.colors.length > 0, st.colors.length);
        updateSecBadge('sec-size', 'badge-size', st.sizes.length > 0, st.sizes.length);
        updateSecBadge('sec-fabric', 'badge-fabric', st.fabrics.length > 0, st.fabrics.length);
        updateSecBadge('sec-discount', 'badge-discount', st.minDiscount > 0, st.minDiscount + '%+');
        updateSecBadge('sec-availability', 'badge-availability', st.availability.length > 0, st.availability.length);

        // Sidebar Chips state
        document.querySelectorAll('.sf-chip').forEach(function(chip) {
            var type = chip.dataset.sfType;
            var val  = chip.dataset.sfVal;
            var isActive = false;
            if (type === 'category') isActive = (st.category === val);
            if (type === 'size') isActive = st.sizes.indexOf(val) !== -1;
            if (type === 'fabric') isActive = st.fabrics.indexOf(val) !== -1;
            if (type === 'discount') isActive = (st.minDiscount === parseInt(val));
            if (type === 'availability') isActive = st.availability.indexOf(val) !== -1;
            chip.classList.toggle('active', isActive);
            chip.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        });

        // Sidebar Swatches state
        document.querySelectorAll('.sf-swatch-wrapper').forEach(function(sw) {
            var val = sw.dataset.sfVal;
            var isActive = st.colors.indexOf(val) !== -1;
            sw.classList.toggle('active', isActive);
        });
    }

    function updateSecBadge(secId, badgeId, hasActive, text) {
        var sec = document.getElementById(secId);
        var badge = document.getElementById(badgeId);
        if (sec && badge) {
            sec.classList.toggle('has-active', hasActive);
            badge.textContent = text;
        }
    }

    /* Main Category Tabs click */
    document.querySelectorAll('.main-cat-tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.main-cat-tab').forEach(function(t){ t.classList.remove('active'); t.setAttribute('aria-selected','false'); });
            tab.classList.add('active'); tab.setAttribute('aria-selected','true');
            tab.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });

            var cat = tab.dataset.cat;
            window.masterFilterState.category = cat;
            window.masterFilterState.fabrics = []; // reset sub-filter on main category switch
            window.renderSubCategories(cat);
            window.applyMasterFilters();
            if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
        });
    });

    /* Desktop Sidebar Accordion Toggles */
    document.querySelectorAll('.sf-section-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var sec = btn.closest('.sf-section');
            sec.classList.toggle('open');
            btn.setAttribute('aria-expanded', sec.classList.contains('open') ? 'true' : 'false');
        });
    });

    /* Desktop Sidebar Chip clicks */
    document.querySelectorAll('.sf-chip').forEach(function(chip) {
        chip.addEventListener('click', function() {
            var type = chip.dataset.sfType;
            var val  = chip.dataset.sfVal;
            var st   = window.masterFilterState;

            if (type === 'category') {
                st.category = val;
                st.fabrics = [];
                document.querySelectorAll('.main-cat-tab').forEach(function(t){
                    t.classList.toggle('active', t.dataset.cat === val);
                });
                window.renderSubCategories(val);
            } else if (type === 'size') {
                var idx = st.sizes.indexOf(val);
                if (idx === -1) st.sizes.push(val); else st.sizes.splice(idx, 1);
            } else if (type === 'fabric') {
                var idx = st.fabrics.indexOf(val);
                if (idx === -1) st.fabrics.push(val); else st.fabrics.splice(idx, 1);
            } else if (type === 'discount') {
                var dVal = parseInt(val);
                st.minDiscount = (st.minDiscount === dVal) ? 0 : dVal;
            } else if (type === 'availability') {
                var idx = st.availability.indexOf(val);
                if (idx === -1) st.availability.push(val); else st.availability.splice(idx, 1);
            }

            window.applyMasterFilters();
            if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
        });
    });

    /* Desktop Sidebar Swatches clicks */
    document.querySelectorAll('.sf-swatch-wrapper').forEach(function(sw) {
        sw.addEventListener('click', function() {
            var val = sw.dataset.sfVal;
            var st  = window.masterFilterState;
            var idx = st.colors.indexOf(val);
            if (idx === -1) st.colors.push(val); else st.colors.splice(idx, 1);
            
            window.applyMasterFilters();
            if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
        });
    });

    /* Desktop Sidebar Price Range Sliders */
    var sfMin  = document.getElementById('sfPriceMin');
    var sfMax  = document.getElementById('sfPriceMax');
    var sfMinL = document.getElementById('sfPriceMinLabel');
    var sfMaxL = document.getElementById('sfPriceMaxLabel');
    var sfFill = document.getElementById('sfRangeFill');

    function updateSfRange() {
        if (!sfMin || !sfMax) return;
        var mn = parseInt(sfMin.value), mx = parseInt(sfMax.value);
        var lo = parseInt(sfMin.min),   hi = parseInt(sfMin.max);

        if (mn > mx - 500) {
            if (this === sfMin) mn = mx - 500; else mx = mn + 500;
            sfMin.value = mn; sfMax.value = mx;
        }

        sfFill.style.left  = ((mn - lo) / (hi - lo) * 100) + '%';
        sfFill.style.right = (100 - (mx - lo) / (hi - lo) * 100) + '%';
        sfMinL.textContent = '₹' + mn.toLocaleString('en-IN');
        sfMaxL.textContent = '₹' + mx.toLocaleString('en-IN');

        window.masterFilterState.minPrice = mn;
        window.masterFilterState.maxPrice = mx;

        // Sync preset chips
        document.querySelectorAll('.price-preset-chip').forEach(function(chip) {
            var cMin = parseInt(chip.dataset.min), cMax = parseInt(chip.dataset.max);
            var isMatch = (mn === cMin && mx === cMax);
            chip.classList.toggle('active', isMatch);
        });

        window.applyMasterFilters();
        if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
    }

    if (sfMin) {
        sfMin.addEventListener('input', updateSfRange);
        sfMax.addEventListener('input', updateSfRange);
    }

    /* Price Preset Chips click */
    document.querySelectorAll('.price-preset-chip').forEach(function(chip) {
        chip.addEventListener('click', function() {
            var cMin = parseInt(chip.dataset.min), cMax = parseInt(chip.dataset.max);
            if (sfMin && sfMax) {
                sfMin.value = cMin;
                sfMax.value = cMax;
                updateSfRange.call(sfMin);
            }
        });
    });

    /* Desktop Clear All */
    var sfClearAll = document.getElementById('sfClearAll');
    if (sfClearAll) {
        sfClearAll.addEventListener('click', function() {
            resetMasterFilters();
        });
    }

    /* Reset Button in Empty State */
    var npResetBtn = document.getElementById('npResetBtn');
    if (npResetBtn) {
        npResetBtn.addEventListener('click', function() {
            resetMasterFilters();
        });
    }

    function resetMasterFilters() {
        window.masterFilterState = {
            category: 'All',
            colors: [],
            sizes: [],
            fabrics: [],
            minPrice: 500,
            maxPrice: 30000,
            minDiscount: 0,
            availability: [],
            sortBy: 'recommended'
        };
        if (sfMin) { sfMin.value = 500; sfMax.value = 30000; updateSfRange.call(sfMin); }
        document.querySelectorAll('.main-cat-tab').forEach(function(t){ t.classList.toggle('active', t.dataset.cat === 'All'); });
        window.renderSubCategories('All');
        window.applyMasterFilters();
        if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
        showToast('All filters cleared');
    }

    /* Top Sort Selection */
    var ptbSort = document.getElementById('ptbSortSelect');
    if (ptbSort) {
        ptbSort.addEventListener('change', function() {
            window.masterFilterState.sortBy = ptbSort.value;
            window.applyMasterFilters();
        });
    }

    /* Wishlist toggle & Quick View from Grid Cards */
    var pGrid = document.getElementById('productsGrid');
    if (pGrid) {
        pGrid.addEventListener('click', function (e) {
            var wishBtn = e.target.closest('.card-wishlist-btn');
            if (wishBtn) {
                e.stopPropagation();
                e.preventDefault();
                var id = wishBtn.dataset.id;
                var p = products.find(function(x){ return x.id == id; });
                if (p && typeof window.toggleWishlistProduct === 'function') {
                    var added = window.toggleWishlistProduct(p);
                    wishBtn.classList.toggle('active', added);
                    wishBtn.setAttribute('aria-pressed', added ? 'true' : 'false');
                    if (typeof showToast === 'function') showToast(added ? '♡ Saved ' + p.name + ' to wishlist' : 'Removed from wishlist');
                }
                return;
            }

            var qvBtn = e.target.closest('.quick-view-btn, .card-mobile-qv-btn');
            if (qvBtn) {
                e.stopPropagation();
                e.preventDefault();
                var id = qvBtn.dataset.id;
                if (typeof window.openQV === 'function') {
                    window.openQV(id);
                }
                return;
            }
        });
    }

    /* Universal Header and Drawer Open/Close Listeners */
    document.addEventListener('click', function(e) {
        var cartTarget = e.target.closest('#cartBtn, #moreCartAction');
        if (cartTarget) {
            e.preventDefault();
            if (typeof window.openCartDrawer === 'function') window.openCartDrawer();
            return;
        }

        var wishTarget = e.target.closest('#wishlistBtn, #moreWishlistAction');
        if (wishTarget) {
            e.preventDefault();
            if (typeof window.openWishlistDrawer === 'function') window.openWishlistDrawer();
            return;
        }

        var closeCart = e.target.closest('#closeCartDrawerBtn');
        if (closeCart) {
            e.preventDefault();
            if (typeof window.closeCartDrawer === 'function') window.closeCartDrawer();
            return;
        }

        var closeWish = e.target.closest('#closeWishlistDrawerBtn');
        if (closeWish) {
            e.preventDefault();
            if (typeof window.closeWishlistDrawer === 'function') window.closeWishlistDrawer();
            return;
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (typeof window.closeCartDrawer === 'function') window.closeCartDrawer();
            if (typeof window.closeWishlistDrawer === 'function') window.closeWishlistDrawer();
            if (typeof window.closeQV === 'function') window.closeQV();
            if (typeof window.closeProductDetails === 'function') window.closeProductDetails();
            if (typeof window.closeReelsModal === 'function') window.closeReelsModal();
        }
    });

    /* ── Hero Banner Slider Controller ── */
    var bannerTrack = document.getElementById('heroBannerTrack');
    var bannerDots = document.querySelectorAll('.hero-banner-dot');
    var bannerCurrent = 0;
    var bannerTotal = 3;
    var bannerTimer = null;

    function goToBanner(idx) {
        if (!bannerTrack) return;
        bannerCurrent = (idx + bannerTotal) % bannerTotal;
        bannerTrack.style.transform = 'translateX(-' + (bannerCurrent * 100) + '%)';
        bannerDots.forEach(function(dot, dIdx) {
            dot.classList.toggle('active', dIdx === bannerCurrent);
        });
    }

    function startBannerAutoplay() {
        stopBannerAutoplay();
        bannerTimer = setInterval(function() {
            goToBanner(bannerCurrent + 1);
        }, 4500);
    }

    function stopBannerAutoplay() {
        if (bannerTimer) clearInterval(bannerTimer);
    }

    var prevBannerBtn = document.getElementById('heroBannerPrevBtn');
    var nextBannerBtn = document.getElementById('heroBannerNextBtn');
    if (prevBannerBtn) prevBannerBtn.addEventListener('click', function(e) { e.stopPropagation(); goToBanner(bannerCurrent - 1); startBannerAutoplay(); });
    if (nextBannerBtn) nextBannerBtn.addEventListener('click', function(e) { e.stopPropagation(); goToBanner(bannerCurrent + 1); startBannerAutoplay(); });

    bannerDots.forEach(function(dot) {
        dot.addEventListener('click', function(e) {
            e.stopPropagation();
            var s = parseInt(dot.dataset.slide);
            goToBanner(s);
            startBannerAutoplay();
        });
    });

    var bannerContainer = document.getElementById('heroBannerContainer');
    if (bannerContainer) {
        bannerContainer.addEventListener('mouseenter', stopBannerAutoplay);
        bannerContainer.addEventListener('mouseleave', startBannerAutoplay);
        startBannerAutoplay();
    }

    /* Mobile Touch Swipe for Banner */
    if (bannerTrack) {
        var touchStartX = 0, touchEndX = 0;
        bannerTrack.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
            stopBannerAutoplay();
        }, { passive: true });

        bannerTrack.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            var diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 40) {
                if (diff > 0) goToBanner(bannerCurrent + 1);
                else goToBanner(bannerCurrent - 1);
            }
            startBannerAutoplay();
        }, { passive: true });
    }

    window.filterByBanner = function(catName) {
        var st = window.masterFilterState;
        st.category = catName;
        st.fabrics = [];
        document.querySelectorAll('.main-cat-tab').forEach(function(t){
            t.classList.toggle('active', t.dataset.cat === catName);
        });
        window.renderSubCategories(catName);
        window.applyMasterFilters();
        if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
    };

    /* Initial Sub-Categories and Master Filter Execution */
    window.renderSubCategories('All');
    window.applyMasterFilters();

})();
</script>

<!-- ════════════ INSTAGRAM REELS VIDEO FEED PARTIAL ════════════ -->
<?php include 'reels.php'; ?>

<!-- ════════════ CART PARTIAL ════════════ -->
<?php include 'cart.php'; ?>

<!-- ════════════ WISHLIST PARTIAL ════════════ -->
<?php include 'wishlist.php'; ?>

</body>
</html>
