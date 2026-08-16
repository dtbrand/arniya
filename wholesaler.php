<?php
/**
 * wholesaler.php — Luxury Kalaniketan B2B Wholesaler Dashboard
 * Clean Modern TailAdmin Sizing & Layout + 100% Signature Heritage Gold Brand Colors
 * 
 * Brand Color System:
 * - Primary Gold: #8A681F
 * - Radiant Accent Gold: #C5A859 / #D4AF37
 * - Deep Bronze Gold: #5A4210 / #705114
 * - Pale Gold Background: #FAF5E8 / #FDFBF7
 * - Obsidian Dark: #14110E / #0F172A
 */

$catalogProducts = [
    // ── NEW CATALOGUE / FRESH ARRIVALS (Shown First Always) ──
    [
        'id'              => 111,
        'sku'             => 'KLN-SR-111',
        'hsn'             => '5007',
        'name'            => 'Pure Dola Silk Meenakari Saree',
        'category'        => 'Sarees',
        'retail_price'    => 3499,
        'wholesale_price' => 1399,
        'moq'             => 8,
        'image'           => 'images/product2.png',
        'badge'           => 'New Catalogue',
        'badge_icon'      => '✨',
        'color'           => 'Crimson Rani',
        'fabric'          => 'Dola Silk with Meena Border',
        'in_stock'        => 95,
        'tier_prices'     => '8-15 pcs: ₹1,399 | 16-31 pcs: ₹1,299 | 32+ pcs: ₹1,219'
    ],
    [
        'id'              => 109,
        'sku'             => 'KLN-KT-109',
        'hsn'             => '6204',
        'name'            => 'Party Festive Sharara Suit Set',
        'category'        => 'Kurtis',
        'retail_price'    => 2699,
        'wholesale_price' => 989,
        'moq'             => 8,
        'image'           => 'images/product5.png',
        'badge'           => 'New Arrival',
        'badge_icon'      => '🔥',
        'color'           => 'Teal Blue',
        'fabric'          => 'Chanderi Gotapatti Work',
        'in_stock'        => 125,
        'tier_prices'     => '8-15 pcs: ₹989 | 16-31 pcs: ₹929 | 32+ pcs: ₹869'
    ],
    [
        'id'              => 110,
        'sku'             => 'KLN-SR-110',
        'hsn'             => '5007',
        'name'            => 'Paithani Rich Pallu Saree',
        'category'        => 'Sarees',
        'retail_price'    => 3199,
        'wholesale_price' => 1249,
        'moq'             => 8,
        'image'           => 'images/product1.png',
        'badge'           => 'New Catalogue',
        'badge_icon'      => '💎',
        'color'           => 'Bottle Green',
        'fabric'          => 'Art Silk Peacock Pallu',
        'in_stock'        => 110,
        'tier_prices'     => '8-15 pcs: ₹1,249 | 16-31 pcs: ₹1,169 | 32+ pcs: ₹1,099'
    ],
    [
        'id'              => 112,
        'sku'             => 'KLN-SR-112',
        'hsn'             => '5007',
        'name'            => 'Pure Kanjivaram Bridal Art Silk',
        'category'        => 'Sarees',
        'retail_price'    => 4499,
        'wholesale_price' => 1899,
        'moq'             => 6,
        'image'           => 'images/product3.png',
        'badge'           => 'New Arrival',
        'badge_icon'      => '👑',
        'color'           => 'Copper Gold',
        'fabric'          => 'Heavy Bridal Zari Silk',
        'in_stock'        => 85,
        'tier_prices'     => '6-11 pcs: ₹1,899 | 12-23 pcs: ₹1,779 | 24+ pcs: ₹1,659'
    ],

    // ── SUPER VALUE & BEST MARGIN LOTS ──
    [
        'id'              => 101,
        'sku'             => 'KLN-KT-101',
        'hsn'             => '6204',
        'name'            => 'Jaipuri Printed Cotton Kurti',
        'category'        => 'Kurtis',
        'retail_price'    => 599,
        'wholesale_price' => 249,
        'moq'             => 24,
        'image'           => 'images/product7.png',
        'badge'           => 'Super Value',
        'badge_icon'      => '🚀',
        'color'           => 'Indigo Blue',
        'fabric'          => '100% Pure Cotton',
        'in_stock'        => 320,
        'tier_prices'     => '24-49 pcs: ₹249 | 50-99 pcs: ₹229 | 100+ pcs: ₹199'
    ],
    [
        'id'              => 102,
        'sku'             => 'KLN-DP-102',
        'hsn'             => '5208',
        'name'            => 'Bandhani Silk Touch Dupatta',
        'category'        => 'Dupattas',
        'retail_price'    => 449,
        'wholesale_price' => 189,
        'moq'             => 30,
        'image'           => 'images/product8.png',
        'badge'           => 'Fast Selling',
        'badge_icon'      => '⚡',
        'color'           => 'Ruby Red',
        'fabric'          => 'Art Silk Bandhani',
        'in_stock'        => 450,
        'tier_prices'     => '30-59 pcs: ₹189 | 60-119 pcs: ₹169 | 120+ pcs: ₹149'
    ],
    [
        'id'              => 103,
        'sku'             => 'KLN-KT-103',
        'hsn'             => '6204',
        'name'            => 'Rayon Floral Straight Kurti',
        'category'        => 'Kurtis',
        'retail_price'    => 699,
        'wholesale_price' => 289,
        'moq'             => 20,
        'image'           => 'images/product9.png',
        'badge'           => 'Bestseller',
        'badge_icon'      => '🔥',
        'color'           => 'Mustard Yellow',
        'fabric'          => '14kg Heavy Rayon',
        'in_stock'        => 280,
        'tier_prices'     => '20-39 pcs: ₹289 | 40-79 pcs: ₹269 | 80+ pcs: ₹245'
    ],
    [
        'id'              => 104,
        'sku'             => 'KLN-KT-104',
        'hsn'             => '6204',
        'name'            => 'Chikan Embroidered Rayon Kurti',
        'category'        => 'Kurtis',
        'retail_price'    => 999,
        'wholesale_price' => 399,
        'moq'             => 18,
        'image'           => 'images/product10.png',
        'badge'           => 'Best Margin',
        'badge_icon'      => '⚡',
        'color'           => 'Pastel Mint',
        'fabric'          => 'Lakhnavi Handwork Rayon',
        'in_stock'        => 220,
        'tier_prices'     => '18-35 pcs: ₹399 | 36-71 pcs: ₹369 | 72+ pcs: ₹339'
    ],
    [
        'id'              => 105,
        'sku'             => 'KLN-SR-105',
        'hsn'             => '5407',
        'name'            => 'Digital Floral Georgette Saree',
        'category'        => 'Sarees',
        'retail_price'    => 1299,
        'wholesale_price' => 489,
        'moq'             => 16,
        'image'           => 'images/product12.png',
        'badge'           => 'Trending',
        'badge_icon'      => '🔥',
        'color'           => 'Lavender Rose',
        'fabric'          => '60gm Pure Georgette',
        'in_stock'        => 260,
        'tier_prices'     => '16-31 pcs: ₹489 | 32-63 pcs: ₹449 | 64+ pcs: ₹419'
    ],
    [
        'id'              => 106,
        'sku'             => 'KLN-SR-106',
        'hsn'             => '5007',
        'name'            => 'Chanderi Silk Festive Saree',
        'category'        => 'Sarees',
        'retail_price'    => 1599,
        'wholesale_price' => 649,
        'moq'             => 12,
        'image'           => 'images/product1.png',
        'badge'           => 'Festive Hot',
        'badge_icon'      => '✨',
        'color'           => 'Peacock Green',
        'fabric'          => 'Chanderi Zari Weave',
        'in_stock'        => 190,
        'tier_prices'     => '12-23 pcs: ₹649 | 24-47 pcs: ₹599 | 48+ pcs: ₹559'
    ],
    [
        'id'              => 107,
        'sku'             => 'KLN-SR-107',
        'hsn'             => '5407',
        'name'            => 'Organza Mirror Work Saree',
        'category'        => 'Sarees',
        'retail_price'    => 1899,
        'wholesale_price' => 749,
        'moq'             => 12,
        'image'           => 'images/product2.png',
        'badge'           => 'Party Wear',
        'badge_icon'      => '💎',
        'color'           => 'Blush Pink',
        'fabric'          => 'Glass Organza Silk',
        'in_stock'        => 170,
        'tier_prices'     => '12-23 pcs: ₹749 | 24-47 pcs: ₹699 | 48+ pcs: ₹649'
    ],
    [
        'id'              => 108,
        'sku'             => 'KLN-SR-108',
        'hsn'             => '5007',
        'name'            => 'Banarasi Brocade Semi-Silk',
        'category'        => 'Sarees',
        'retail_price'    => 2499,
        'wholesale_price' => 949,
        'moq'             => 10,
        'image'           => 'images/product3.png',
        'badge'           => 'Bestseller',
        'badge_icon'      => '⭐',
        'color'           => 'Royal Maroon',
        'fabric'          => 'Katan Art Silk',
        'in_stock'        => 140,
        'tier_prices'     => '10-19 pcs: ₹949 | 20-39 pcs: ₹889 | 40+ pcs: ₹829'
    ],
    [
        'id'              => 5,
        'sku'             => 'KLN-KT-005',
        'hsn'             => '6204',
        'name'            => 'Royal Anarkali Kurti Set',
        'category'        => 'Kurtis',
        'retail_price'    => 2799,
        'wholesale_price' => 1799,
        'moq'             => 10,
        'image'           => 'images/product5.png',
        'badge'           => 'Party Wear',
        'badge_icon'      => '💎',
        'color'           => 'Emerald Teal',
        'fabric'          => 'Chanderi Cotton',
        'in_stock'        => 180,
        'tier_prices'     => '10-19 pcs: ₹1,799 | 20-39 pcs: ₹1,599 | 40+ pcs: ₹1,449'
    ],
    [
        'id'              => 4,
        'sku'             => 'KLN-SR-004',
        'hsn'             => '5407',
        'name'            => 'Georgette Bloom Saree',
        'category'        => 'Sarees',
        'retail_price'    => 3299,
        'wholesale_price' => 2199,
        'moq'             => 8,
        'image'           => 'images/product4.png',
        'badge'           => 'Fast Selling',
        'badge_icon'      => '⚡',
        'color'           => 'Blush Peach',
        'fabric'          => 'Pure Georgette',
        'in_stock'        => 210,
        'tier_prices'     => '8-15 pcs: ₹2,199 | 16-30 pcs: ₹1,999 | 31+ pcs: ₹1,799'
    ],
    [
        'id'              => 1,
        'sku'             => 'KLN-SR-001',
        'hsn'             => '5007',
        'name'            => 'Nilambari Silk Saree',
        'category'        => 'Sarees',
        'retail_price'    => 4899,
        'wholesale_price' => 3199,
        'moq'             => 6,
        'image'           => 'images/product1.png',
        'badge'           => 'Bestseller',
        'badge_icon'      => '🔥',
        'color'           => 'Navy Blue',
        'fabric'          => 'Pure Silk Handloom',
        'in_stock'        => 140,
        'tier_prices'     => '6-11 pcs: ₹3,199 | 12-24 pcs: ₹2,999 | 25+ pcs: ₹2,799'
    ],
    [
        'id'              => 2,
        'sku'             => 'KLN-SR-002',
        'hsn'             => '5007',
        'name'            => 'Banarasi Zari Saree',
        'category'        => 'Sarees',
        'retail_price'    => 8499,
        'wholesale_price' => 5499,
        'moq'             => 4,
        'image'           => 'images/product2.png',
        'badge'           => 'Heritage',
        'badge_icon'      => '✨',
        'color'           => 'Maroon Wine',
        'fabric'          => 'Pure Katan Silk',
        'in_stock'        => 95,
        'tier_prices'     => '4-7 pcs: ₹5,499 | 8-15 pcs: ₹5,199 | 16+ pcs: ₹4,899'
    ],
    [
        'id'              => 3,
        'sku'             => 'KLN-SR-003',
        'hsn'             => '5007',
        'name'            => 'Kanjivaram Temple Silk',
        'category'        => 'Sarees',
        'retail_price'    => 12999,
        'wholesale_price' => 8499,
        'moq'             => 3,
        'image'           => 'images/product3.png',
        'badge'           => 'Royal VIP',
        'badge_icon'      => '👑',
        'color'           => 'Golden Yellow',
        'fabric'          => 'Pure Mulberry Silk',
        'in_stock'        => 60,
        'tier_prices'     => '3-5 pcs: ₹8,499 | 6-11 pcs: ₹7,999 | 12+ pcs: ₹7,499'
    ],
    [
        'id'              => 6,
        'sku'             => 'KLN-LH-006',
        'hsn'             => '6204',
        'name'            => 'Bridal Zardosi Lehenga',
        'category'        => 'Lehengas',
        'retail_price'    => 24999,
        'wholesale_price' => 16499,
        'moq'             => 2,
        'image'           => 'images/product6.png',
        'badge'           => 'Bridal Couture',
        'badge_icon'      => '💍',
        'color'           => 'Crimson Red',
        'fabric'          => 'Micro Velvet & Zari',
        'in_stock'        => 35,
        'tier_prices'     => '2-3 pcs: ₹16,499 | 4-7 pcs: ₹15,499 | 8+ pcs: ₹14,299'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Wholesaler B2B Dashboard — Kalaniketan Couture</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* ── Kalaniketan Signature Heritage Gold Brand System ── */
            --ws-gold-primary: #8A681F;
            --ws-gold-accent: #C5A859;
            --ws-gold-deep: #5A4210;
            --ws-gold-light: #FAF5E8;
            --ws-gold-pale: #FDFBF7;
            --ws-gold-border: rgba(138, 104, 31, 0.22);
            --ws-gold-glow: rgba(197, 168, 89, 0.28);

            --ws-bg-page: #FDFBF7;
            --ws-bg-card: #FFFFFF;
            --ws-bg-sidebar: #FFFFFF;
            --ws-border: #E8E2D5;
            --ws-border-light: #F4EFE6;

            --ws-text-main: #14110E;
            --ws-text-sub: #3B352E;
            --ws-text-muted: #6B6358;
            --ws-text-light: #948A7B;

            --ws-success: #15803D;
            --ws-success-bg: #DCFCE7;
            --ws-warning: #B45309;
            --ws-warning-bg: #FEF3C7;
            --ws-danger: #B91C1C;
            --ws-danger-bg: #FEE2E2;

            --ws-font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --ws-font-serif: 'Cinzel', serif;

            --ws-radius-sm: 8px;
            --ws-radius-md: 12px;
            --ws-radius-lg: 14px;
            --ws-radius-xl: 18px;

            --ws-shadow-card: 0 1px 4px rgba(138,104,31,0.06), 0 4px 14px rgba(0,0,0,0.03);
            --ws-shadow-hover: 0 8px 24px rgba(138,104,31,0.12);
            --ws-transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-tap-highlight-color: transparent;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--ws-font-sans);
            background: var(--ws-bg-page);
            color: var(--ws-text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        /* ── Top Header Navigation Bar ── */
        .ws-header {
            background: #FFFFFF;
            border-bottom: 2px solid var(--ws-gold-primary);
            padding: 0 clamp(14px, 2.5vw, 28px);
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(138,104,31,0.06);
        }
        .ws-header-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .ws-menu-toggle-btn {
            width: 38px;
            height: 38px;
            border-radius: var(--ws-radius-sm);
            border: 1.2px solid var(--ws-gold-border);
            background: var(--ws-gold-light);
            color: var(--ws-gold-primary);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--ws-transition);
        }
        .ws-menu-toggle-btn:hover {
            background: var(--ws-gold-primary);
            color: #FFFFFF;
        }
        .ws-menu-toggle-btn svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
        }

        /* ── Command Search Bar (⌘K) ── */
        .ws-cmd-search-wrap {
            position: relative;
            width: clamp(240px, 32vw, 420px);
        }
        .ws-cmd-search-input {
            width: 100%;
            height: 38px;
            padding: 0 54px 0 38px;
            border-radius: 20px;
            border: 1.2px solid var(--ws-border);
            background: #FAF8F4;
            font-size: 0.82rem;
            color: var(--ws-text-main);
            outline: none;
            transition: var(--ws-transition);
        }
        .ws-cmd-search-input:focus {
            background: #FFFFFF;
            border-color: var(--ws-gold-primary);
            box-shadow: 0 0 0 3px var(--ws-gold-glow);
        }
        .ws-cmd-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            stroke: var(--ws-text-muted);
            stroke-width: 2;
            fill: none;
            pointer-events: none;
        }
        .ws-cmd-badge {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            padding: 2px 6px;
            background: #FFFFFF;
            border: 1px solid var(--ws-gold-border);
            border-radius: 6px;
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--ws-gold-primary);
        }

        /* ── Luxury Search Bar Design System (Compact 30px & Right-Side Icon) ── */
        .ws-filter-controls-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 1.5px solid var(--ws-border);
        }
        .ws-luxury-search-wrap {
            position: relative;
            width: clamp(230px, 32vw, 340px);
            display: flex;
            align-items: center;
            border-radius: 16px;
            background: #FFFFFF;
        }
        .ws-luxury-search-wrap::before {
            content: '';
            position: absolute;
            inset: -1.2px;
            border-radius: 18px;
            background: linear-gradient(90deg, rgba(212,175,55,0.3) 0%, #D4AF37 35%, #F59E0B 50%, #D4AF37 65%, rgba(212,175,55,0.3) 100%);
            background-size: 200% 100%;
            animation: searchRunningBorder 3.5s linear infinite;
            z-index: 0;
            pointer-events: none;
        }
        @keyframes searchRunningBorder {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }
        .ws-luxury-search-input {
            position: relative;
            z-index: 1;
            width: 100%;
            height: 30px;
            padding: 0 52px 0 12px;
            border-radius: 16px;
            border: 1px solid transparent;
            background: #FFFFFF;
            font-size: 0.74rem;
            font-weight: 600;
            color: var(--ws-text-main);
            outline: none;
            transition: all 0.25s ease;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.03);
        }
        .ws-luxury-search-input::placeholder {
            color: #9E978E;
            font-weight: 500;
            font-size: 0.72rem;
        }
        .ws-luxury-search-input:focus {
            background: #FFFFFF;
            box-shadow: 0 0 0 2.5px rgba(212,175,55,0.25);
        }
        .ws-luxury-search-icon {
            z-index: 2;
            position: absolute;
            right: 4px;
            top: 50%;
            transform: translateY(-50%);
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--ws-gold-primary) 0%, var(--ws-gold-deep) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 4px rgba(138,104,31,0.25);
            pointer-events: none;
            transition: var(--ws-transition);
            stroke: #FFFFFF;
            stroke-width: 2.4;
            fill: none;
            padding: 4.5px;
            box-sizing: border-box;
        }
        .ws-luxury-search-wrap:focus-within .ws-luxury-search-icon {
            transform: translateY(-50%) scale(1.05);
            box-shadow: 0 2px 8px rgba(138,104,31,0.4);
        }
        .ws-luxury-search-clear {
            z-index: 3;
            position: absolute;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #FAF8F4;
            color: #78716C;
            border: 1px solid rgba(138,104,31,0.25);
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 0.58rem;
            font-weight: 800;
            transition: var(--ws-transition);
        }
        .ws-luxury-search-clear:hover {
            background: var(--ws-gold-primary);
            color: #FFFFFF;
        }

        .ws-header-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .ws-hdr-icon-btn {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 1.2px solid var(--ws-gold-border);
            background: var(--ws-gold-light);
            color: var(--ws-gold-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            transition: var(--ws-transition);
        }
        .ws-hdr-icon-btn:hover {
            background: var(--ws-gold-primary);
            color: #FFFFFF;
        }
        .ws-hdr-icon-btn svg {
            width: 17px;
            height: 17px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }
        .ws-notif-dot {
            position: absolute;
            top: 7px;
            right: 7px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #D97706;
            border: 1.5px solid #FFFFFF;
        }

        .ws-hdr-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 17px;
            height: 17px;
            padding: 0 4px;
            border-radius: 9px;
            background: #DC2626;
            color: #FFFFFF;
            font-size: 0.58rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid #FFFFFF;
            box-shadow: 0 2px 4px rgba(0,0,0,0.15);
            line-height: 1;
        }
        .ws-hdr-badge.gold {
            background: var(--ws-gold-primary);
            color: #FFFFFF;
        }

        .ws-user-profile-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 4px 12px 4px 4px;
            border-radius: 28px;
            border: 1.5px solid var(--ws-gold-border);
            background: var(--ws-gold-light);
            cursor: pointer;
            transition: var(--ws-transition);
        }
        .ws-user-profile-btn:hover {
            border-color: var(--ws-gold-primary);
            box-shadow: 0 2px 8px rgba(138,104,31,0.2);
        }
        .ws-user-avatar-img {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid #FFFFFF;
        }
        .ws-user-name-text {
            font-size: 0.84rem;
            font-weight: 700;
            color: var(--ws-text-main);
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .ws-user-name-text svg {
            width: 14px;
            height: 14px;
            stroke: var(--ws-gold-primary);
            stroke-width: 2.2;
            fill: none;
        }

        .ws-mobile-header-brand {
            display: none;
        }
        .ws-mob-logo-text {
            font-family: var(--ws-font-serif);
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
            letter-spacing: 0.06em;
            white-space: nowrap;
        }

        /* ── Main App Layout Grid ── */
        .ws-app-layout {
            display: flex;
            flex: 1;
            min-height: calc(100vh - 64px);
        }

        /* ── Left Sidebar Navigation (TailAdmin Style with Gold Theme) ── */
        .ws-sidebar {
            width: 250px;
            background: var(--ws-bg-sidebar);
            border-right: 1.5px solid var(--ws-border);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            transition: var(--ws-transition);
            z-index: 900;
            height: 100%;
        }
        .ws-sidebar-brand-box {
            padding: 8px 14px;
            height: 48px;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            gap: 9px;
            border-bottom: 1.5px solid rgba(212,175,55,0.2);
            background: linear-gradient(180deg, #FFFFFF 0%, #FAF8F4 100%);
            flex-shrink: 0;
        }
        .ws-sidebar-close-btn {
            display: none;
            margin-left: auto;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1.2px solid var(--ws-gold-border);
            background: var(--ws-gold-light);
            color: var(--ws-gold-primary);
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            transition: var(--ws-transition);
        }
        .ws-sidebar-close-btn:hover {
            background: var(--ws-gold-primary);
            color: #FFFFFF;
        }
        .ws-sidebar-scroll {
            flex: 1;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            display: flex;
            flex-direction: column;
            scrollbar-width: thin;
        }
        .ws-side-logo-icon {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            background: linear-gradient(135deg, var(--ws-gold-accent) 0%, var(--ws-gold-primary) 50%, var(--ws-gold-deep) 100%);
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 0.84rem;
            box-shadow: 0 2px 6px rgba(138,104,31,0.25);
            border: 1px solid #FFFFFF;
        }
        .ws-side-brand-title {
            font-family: var(--ws-font-serif);
            font-size: 0.96rem;
            font-weight: 900;
            color: var(--ws-gold-primary);
            letter-spacing: 0.05em;
        }

        .ws-nav-category {
            font-size: 0.62rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #A8A29E;
            padding: 10px 16px 4px;
        }
        .ws-nav-list {
            list-style: none;
            padding: 4px 8px;
            display: flex;
            flex-direction: column;
            gap: 3px;
            flex: 1;
        }
        .ws-nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 9px;
            color: var(--ws-text-sub);
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid transparent;
            user-select: none;
        }
        .ws-nav-item:hover {
            background: linear-gradient(90deg, rgba(212,175,55,0.12) 0%, rgba(212,175,55,0.04) 100%);
            color: var(--ws-gold-primary);
            transform: translateX(2px);
        }
        .ws-nav-item.active {
            background: linear-gradient(135deg, #FAF5E8 0%, #F5EDD6 100%);
            color: #785912;
            border-color: rgba(212,175,55,0.45);
            font-weight: 800;
            box-shadow: 0 2px 8px rgba(138,104,31,0.10);
            transform: translateX(2px);
        }
        .ws-nav-item svg {
            width: 17px;
            height: 17px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }
        .ws-nav-item:hover svg,
        .ws-nav-item.active svg {
            transform: scale(1.08);
        }
        .ws-nav-badge {
            margin-left: auto;
            background: #DCFCE7;
            color: #15803D;
            font-size: 0.65rem;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 12px;
        }
        .ws-nav-badge.gold {
            background: var(--ws-gold-light);
            color: var(--ws-gold-primary);
            border: 1px solid var(--ws-gold-border);
        }

        .ws-sidebar-footer {
            padding: 14px 16px;
            border-top: 1px solid var(--ws-border);
        }
        .ws-logout-btn {
            width: 100%;
            padding: 9px 12px;
            border-radius: var(--ws-radius-sm);
            border: 1px solid #FCA5A5;
            background: #FEF2F2;
            color: #DC2626;
            font-size: 0.80rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: var(--ws-transition);
        }
        .ws-logout-btn:hover {
            background: #DC2626;
            color: #FFFFFF;
        }

        /* ── Main Content Area ── */
        .ws-main-content {
            flex: 1;
            padding: clamp(16px, 2.5vw, 28px);
            overflow-y: auto;
            max-width: 1440px;
            margin: 0 auto;
            width: 100%;
        }

        /* ── Tab View Containers ── */
        .ws-tab-pane {
            display: none;
            animation: paneFadeIn 0.22s ease;
        }
        .ws-tab-pane.active {
            display: block;
        }
        @keyframes paneFadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ════════════════════════════════════════════════════
           3D FROSTED GOLD GLASS TOP STAT METRIC CARDS (4 Cards Grid)
        ════════════════════════════════════════════════════ */
        .ws-metric-cards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 16px;
        }
        @media (max-width: 1024px) {
            .ws-metric-cards-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 10px !important;
            }
        }
        @media (max-width: 380px) {
            .ws-metric-cards-grid {
                grid-template-columns: 1fr !important;
            }
        }

        /* Glassmorphic 3D KPI Stat Box */
        .ws-stat-box {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.96) 0%, rgba(254, 250, 238, 0.88) 50%, rgba(248, 238, 210, 0.92) 100%);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1.5px solid rgba(212, 175, 55, 0.45);
            border-radius: 14px;
            padding: 12px 14px;
            min-height: 98px;
            box-sizing: border-box;
            box-shadow: 0 4px 18px rgba(180, 140, 40, 0.08), inset 0 1px 2px #FFFFFF, inset 0 0 12px rgba(245, 215, 130, 0.10);
            transition: all 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(18px);
            animation: wsCardFadeUp 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        .ws-stat-box:nth-child(1) { animation-delay: 0.05s; }
        .ws-stat-box:nth-child(2) { animation-delay: 0.12s; }
        .ws-stat-box:nth-child(3) { animation-delay: 0.19s; }
        .ws-stat-box:nth-child(4) { animation-delay: 0.26s; }

        @keyframes wsCardFadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .ws-stat-box::after {
            content: '';
            position: absolute;
            top: 0; left: -100%; width: 60%; height: 100%;
            background: linear-gradient(105deg, transparent 40%, rgba(255, 255, 255, 0.6) 60%, transparent 80%);
            transition: left 0.6s ease;
            pointer-events: none;
        }
        .ws-stat-box:hover::after {
            left: 150%;
        }
        .ws-stat-box:hover {
            box-shadow: 0 8px 25px rgba(180, 140, 40, 0.16), inset 0 1px 2px #FFFFFF;
            border-color: rgba(212, 175, 55, 0.75);
            transform: translateY(-3px) scale(1.01);
        }
        .ws-stat-head-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
            margin-bottom: 6px;
        }
        .ws-stat-label {
            font-size: clamp(0.66rem, 1.1vw, 0.72rem);
            font-weight: 800;
            color: #8A681F;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .ws-stat-ico-wrap {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        }
        .ws-stat-ico-wrap.tier { background: #FEF3C7; border: 1px solid rgba(217, 119, 6, 0.3); }
        .ws-stat-ico-wrap.orders { background: #EFF6FF; border: 1px solid rgba(37, 99, 235, 0.25); }
        .ws-stat-ico-wrap.qty { background: #ECFDF5; border: 1px solid rgba(16, 185, 129, 0.25); }
        .ws-stat-ico-wrap.turnover { background: #FFFBEB; border: 1px solid rgba(245, 158, 11, 0.35); }

        .ws-anim-stat-ico.crown { animation: crownGlowPulse 2.8s ease-in-out infinite; }
        .ws-anim-stat-ico.box { animation: boxFloatPulse 2.4s ease-in-out infinite; }
        .ws-anim-stat-ico.stack { animation: stackShimmer 2.6s ease-in-out infinite; }
        .ws-anim-stat-ico.turnover { animation: turnoverCoinPulse 2.8s ease-in-out infinite; }
        .ws-anim-flame-star { animation: flameStarPulse 2.4s ease-in-out infinite; }

        @keyframes flameStarPulse {
            0%, 100% { transform: scale(1) rotate(0deg); filter: drop-shadow(0 1px 3px rgba(217,119,6,0.3)); }
            50% { transform: scale(1.15) rotate(6deg); filter: drop-shadow(0 2px 8px rgba(245,158,11,0.6)); }
        }

        @keyframes crownGlowPulse {
            0%, 100% { transform: scale(1) rotate(0deg); filter: drop-shadow(0 1px 3px rgba(212,175,55,0.3)); }
            50% { transform: scale(1.1) rotate(-3deg); filter: drop-shadow(0 2px 8px rgba(212,175,55,0.6)); }
        }
        @keyframes boxFloatPulse {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-2.5px); }
        }
        @keyframes stackShimmer {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); filter: drop-shadow(0 2px 6px rgba(16,185,129,0.35)); }
        }
        @keyframes turnoverCoinPulse {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.1) rotate(4deg); filter: drop-shadow(0 2px 8px rgba(245,158,11,0.5)); }
        }

        /* ── Animated Shimmer Text for 'For You' Header ── */
        .ws-anim-shimmer-title {
            background: linear-gradient(90deg, #785912 0%, #D4AF37 25%, #FEF08A 50%, #D4AF37 75%, #785912 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: goldTextFlow 3.5s linear infinite;
            display: inline-block;
        }
        @keyframes goldTextFlow {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }

        .ws-stat-val-row {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 8px;
        }
        .ws-stat-val-num {
            font-size: clamp(1.22rem, 2.2vw, 1.50rem);
            font-weight: 900;
            color: #16130F;
            letter-spacing: -0.01em;
            line-height: 1.15;
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
        }
        .ws-trend-pill {
            display: inline-flex;
            align-items: center;
            gap: 2px;
            padding: 2.5px 7px;
            border-radius: 6px;
            font-size: 0.62rem;
            font-weight: 800;
            white-space: nowrap;
            letter-spacing: 0.2px;
        }
        .ws-trend-pill.up {
            background: #DCFCE7;
            color: #15803D;
            border: 1px solid rgba(22, 163, 74, 0.25);
        }
        .ws-trend-pill.down {
            background: #FEE2E2;
            color: #DC2626;
            border: 1px solid rgba(220, 38, 38, 0.25);
        }

        /* ── 3D Diagonal Tircha Top-Left Corner Ribbon Tag for Tier Card ── */
        .ws-tier-ribbon-tag {
            position: absolute;
            top: 0;
            left: 0;
            width: 54px;
            height: 54px;
            overflow: hidden;
            pointer-events: none;
            z-index: 10;
            border-top-left-radius: 14px;
        }
        .ws-tier-ribbon-tag span {
            position: absolute;
            display: block;
            width: 78px;
            padding: 1.5px 0;
            background: linear-gradient(135deg, #785912 0%, #D4AF37 40%, #FEF08A 60%, #8A681F 100%);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.25), inset 0 1px 1px rgba(255, 255, 255, 0.7);
            color: #1A1204;
            font-size: 0.42rem;
            font-weight: 900;
            text-transform: uppercase;
            text-align: center;
            left: -20px;
            top: 9px;
            transform: rotate(-45deg);
            letter-spacing: 0.6px;
            border-top: 1px solid rgba(255, 255, 255, 0.7);
            border-bottom: 1px solid rgba(120, 89, 18, 0.5);
            text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }
        .ws-tier-ribbon-tag.non-vip span {
            background: linear-gradient(135deg, #047857 0%, #10B981 40%, #A7F3D0 60%, #059669 100%);
            color: #064E3B;
            border-top-color: rgba(255, 255, 255, 0.8);
            border-bottom-color: rgba(6, 78, 59, 0.5);
        }
        .ws-tier-ribbon-tag.silver span {
            background: linear-gradient(135deg, #475569 0%, #94A3B8 40%, #F1F5F9 60%, #64748B 100%);
            color: #0F172A;
            border-top-color: rgba(255, 255, 255, 0.8);
            border-bottom-color: rgba(15, 23, 42, 0.5);
        }
        .ws-tier-ribbon-tag.gold span {
            background: linear-gradient(135deg, #785912 0%, #D4AF37 40%, #FEF08A 60%, #8A681F 100%);
            color: #1A1204;
            border-top-color: rgba(255, 255, 255, 0.8);
            border-bottom-color: rgba(120, 89, 18, 0.5);
        }
        .ws-tier-ribbon-tag.diamond span {
            background: linear-gradient(135deg, #0369A1 0%, #38BDF8 40%, #E0F2FE 60%, #0284C7 100%);
            color: #082F49;
            border-top-color: rgba(255, 255, 255, 0.8);
            border-bottom-color: rgba(3, 105, 161, 0.5);
        }
        .ws-tier-ribbon-tag.platinum span {
            background: linear-gradient(135deg, #1E1B18 0%, #524738 40%, #D4AF37 60%, #1E1B18 100%);
            color: #FFFFFF;
            border-top-color: rgba(212, 175, 55, 0.8);
            border-bottom-color: rgba(0, 0, 0, 0.8);
            text-shadow: 0 1px 2px rgba(0,0,0,0.8);
        }

        /* ── Roadmap Link with Animated Running Glowing Line ── */
        .ws-roadmap-link-wrap {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            cursor: pointer;
            position: relative;
            padding: 1px 4px;
            text-decoration: none;
            transition: var(--ws-transition);
        }
        .ws-roadmap-link-text {
            font-size: clamp(0.56rem, 1vw, 0.62rem);
            font-weight: 800;
            color: #8A681F;
            letter-spacing: 0.3px;
            line-height: 1.1;
            display: inline-flex;
            align-items: center;
            gap: 2px;
            transition: all 0.2s ease;
        }
        .ws-roadmap-link-wrap:hover .ws-roadmap-link-text {
            color: #B45309;
            transform: translateX(1px);
        }
        .ws-roadmap-running-line {
            width: 100%;
            height: 2px;
            margin-top: 1.5px;
            background: rgba(212, 175, 55, 0.25);
            border-radius: 2px;
            position: relative;
            overflow: hidden;
        }
        .ws-roadmap-running-line::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 70%;
            height: 100%;
            background: linear-gradient(90deg, transparent 0%, #F59E0B 40%, #D4AF37 70%, transparent 100%);
            box-shadow: 0 0 6px #F59E0B;
            border-radius: 2px;
            animation: roadMapRunningLine 1.6s cubic-bezier(0.4, 0, 0.2, 1) infinite;
        }
        @keyframes roadMapRunningLine {
            0% { left: -100%; }
            100% { left: 150%; }
        }

        /* ════════════════════════════════════════════════════
           MIDDLE ANALYTICS ROW (Sales Bar Chart & Target Gauge)
        ════════════════════════════════════════════════════ */
        .ws-analytics-grid {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: clamp(14px, 2vw, 20px);
            margin-bottom: clamp(16px, 2vw, 24px);
        }

        .ws-analytics-card {
            background: var(--ws-bg-card);
            border: 1.5px solid var(--ws-border);
            border-radius: var(--ws-radius-lg);
            padding: clamp(18px, 2vw, 24px);
            box-shadow: var(--ws-shadow-card);
            display: flex;
            flex-direction: column;
            opacity: 0;
            transform: translateY(14px);
            animation: wsCardFadeUp 0.55s cubic-bezier(0.4, 0, 0.2, 1) 0.32s forwards;
            transition: box-shadow 0.25s ease, border-color 0.25s ease;
        }
        .ws-analytics-card:hover {
            box-shadow: var(--ws-shadow-hover);
            border-color: var(--ws-gold-border);
        }
        .ws-card-top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .ws-card-top-bar h3 {
            font-size: 1rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
            font-family: var(--ws-font-serif);
        }
        .ws-dots-btn {
            background: none;
            border: none;
            color: var(--ws-text-muted);
            font-size: 1.2rem;
            cursor: pointer;
            line-height: 1;
            padding: 2px 6px;
            border-radius: 4px;
        }
        .ws-dots-btn:hover {
            background: var(--ws-gold-light);
            color: var(--ws-gold-primary);
        }

        /* ── SVG Zigzag & Spline Line Chart (Luxury Admin Style) ── */
        .ws-chart-wrapper {
            position: relative;
            width: 100%;
            display: flex;
            flex-direction: column;
            margin-top: 10px;
        }
        .ws-chart-svg-container {
            position: relative;
            width: 100%;
            height: 180px;
            display: flex;
            overflow: hidden;
            border-radius: 8px;
        }
        .ws-chart-y-axis {
            position: absolute;
            left: 0;
            top: 2px;
            bottom: 6px;
            width: 32px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--ws-text-muted);
            text-align: right;
            padding-right: 6px;
            z-index: 2;
        }
        .ws-chart-svg {
            width: 100%;
            height: 100%;
            overflow: visible;
        }
        .ws-chart-gridline {
            stroke: #EFEBE4;
            stroke-dasharray: 4, 4;
            stroke-width: 1;
        }
        .ws-chart-zigzag-area {
            fill: url(#wsGoldAreaGrad);
            opacity: 0.85;
            transition: d 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .ws-chart-zigzag-line {
            fill: none;
            stroke: url(#wsGoldLineGrad);
            stroke-width: 3.2;
            stroke-linecap: round;
            stroke-linejoin: round;
            filter: drop-shadow(0 4px 10px rgba(138, 104, 31, 0.35));
            transition: d 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            stroke-dasharray: 1200;
            stroke-dashoffset: 0;
            animation: wsLineDrawIn 1.1s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @keyframes wsLineDrawIn {
            from { stroke-dashoffset: 1200; }
            to { stroke-dashoffset: 0; }
        }
        .ws-chart-node {
            fill: #FFFFFF;
            stroke: var(--ws-gold-primary);
            stroke-width: 2.2;
            r: 4;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .ws-chart-node:hover, .ws-chart-node.active {
            r: 6.5;
            fill: var(--ws-gold-primary);
            stroke: #FFFFFF;
            stroke-width: 2.5;
            filter: drop-shadow(0 0 10px rgba(212, 175, 55, 0.9));
        }
        .ws-chart-x-axis {
            display: flex;
            justify-content: space-between;
            padding: 8px 6px 0 34px;
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--ws-text-muted);
            border-top: 1.5px solid var(--ws-border);
            margin-top: 4px;
        }
        .ws-chart-x-axis span {
            flex: 1;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        .ws-chart-x-axis span:hover, .ws-chart-x-axis span.active {
            color: var(--ws-gold-primary);
            font-weight: 800;
        }

        /* Chart Floating Live Tooltip */
        .ws-chart-tooltip {
            background: #14110E;
            color: #FAF5E8;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.72rem;
            font-weight: 700;
            border: 1px solid var(--ws-gold-accent);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 8px;
            width: fit-content;
            transition: all 0.2s ease;
        }
        .ws-chart-tooltip-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #22C55E;
            box-shadow: 0 0 6px #22C55E;
            flex-shrink: 0;
        }
        .ws-chart-type-pill {
            display: inline-flex;
            background: var(--ws-gold-light);
            border: 1px solid var(--ws-gold-border);
            border-radius: 20px;
            padding: 2px;
            gap: 2px;
        }
        .ws-chart-type-btn {
            background: transparent;
            border: none;
            padding: 3px 9px;
            border-radius: 16px;
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--ws-text-muted);
            cursor: pointer;
            transition: all 0.2s;
        }
        .ws-chart-type-btn.active {
            background: var(--ws-gold-primary);
            color: #FFFFFF;
            box-shadow: 0 2px 6px rgba(138, 104, 31, 0.3);
        }

        /* ── Semi-Circular Target Gauge Arc (Luxury Gold Dashboard) ── */
        .ws-gauge-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin: 6px 0 16px;
            position: relative;
        }
        .ws-gauge-svg {
            width: 200px;
            height: 110px;
            overflow: visible;
        }
        .ws-gauge-bg-arc {
            fill: none;
            stroke: #EDE7DD;
            stroke-width: 14;
            stroke-linecap: round;
        }
        .ws-gauge-fill-arc {
            fill: none;
            stroke: url(#goldGaugeGrad);
            stroke-width: 14;
            stroke-linecap: round;
            stroke-dasharray: 236;
            stroke-dashoffset: 58; /* 75.55% */
            filter: drop-shadow(0 4px 10px rgba(138, 104, 31, 0.4));
            transition: stroke-dashoffset 1.2s cubic-bezier(0.4, 0, 0.2, 1);
            animation: wsGaugeDrawIn 1.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        @keyframes wsGaugeDrawIn {
            from { stroke-dashoffset: 236; }
            to { stroke-dashoffset: 58; }
        }
        .ws-gauge-center-text {
            font-size: 1.65rem;
            font-weight: 900;
            color: var(--ws-gold-primary);
            margin-top: -34px;
            font-family: var(--ws-font-serif);
            letter-spacing: -0.02em;
            text-shadow: 0 2px 8px rgba(138, 104, 31, 0.15);
        }
        .ws-gauge-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 14px;
            background: #ECFDF5;
            color: #10B981;
            font-size: 0.72rem;
            font-weight: 800;
            margin-top: 4px;
            border: 1px solid #A7F3D0;
            box-shadow: 0 2px 6px rgba(16, 185, 129, 0.15);
            animation: wsPulseBadge 2s infinite ease-in-out;
        }
        @keyframes wsPulseBadge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.04); }
        }
        .ws-gauge-desc {
            font-size: 0.78rem;
            color: var(--ws-text-muted);
            margin-top: 12px;
            line-height: 1.45;
            max-width: 290px;
        }
        .ws-gauge-stats-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            border-top: 1.5px solid var(--ws-border);
            padding-top: 14px;
            margin-top: auto;
            text-align: center;
            gap: 8px;
        }
        .ws-gauge-stat-pill {
            background: #FAF8F4;
            border: 1px solid var(--ws-border);
            border-radius: 10px;
            padding: 8px 4px;
            transition: all 0.25s ease;
        }
        .ws-gauge-stat-pill:hover {
            border-color: var(--ws-gold-primary);
            background: #FFFFFF;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(138, 104, 31, 0.1);
        }
        .ws-g-stat-label {
            font-size: 0.68rem;
            color: var(--ws-text-muted);
            font-weight: 700;
            text-transform: uppercase;
        }
        .ws-g-stat-val {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--ws-text-main);
            margin-top: 2px;
        }

        /* ════════════════════════════════════════════════════
           BOTTOM CONTROLS & STATISTICS HEADER (Segmented Tabs)
        ════════════════════════════════════════════════════ */
        /* ── Statistics Comprehensive Card & Multi-Dimensional Grid ── */
        .ws-statistics-card {
            background: #FFFFFF;
            border: 1.5px solid var(--ws-border);
            border-radius: var(--ws-radius-lg);
            padding: clamp(18px, 2.2vw, 24px);
            margin-bottom: clamp(16px, 2vw, 24px);
            box-shadow: var(--ws-shadow-card);
        }
        .ws-stats-grid {
            display: grid;
            grid-template-columns: 1.4fr 1.2fr 1fr;
            gap: 22px;
            margin-top: 18px;
            padding-top: 16px;
            border-top: 1px solid var(--ws-border-light);
        }
        .ws-stats-col-title {
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--ws-text-main);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        /* Category Progress Bars */
        .ws-cat-prog-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .ws-cat-prog-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .ws-cat-prog-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            font-size: 0.80rem;
        }
        .ws-cat-prog-name {
            font-weight: 700;
            color: var(--ws-text-main);
        }
        .ws-cat-prog-val {
            font-weight: 800;
            color: var(--ws-gold-primary);
        }
        .ws-cat-prog-track {
            width: 100%;
            height: 7px;
            background: #F4EFE6;
            border-radius: 4px;
            overflow: hidden;
        }
        .ws-cat-prog-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--ws-gold-primary) 0%, var(--ws-gold-accent) 60%, #FFE082 100%);
            border-radius: 4px;
            width: 0 !important;
            animation: wsProgBarIn 1s cubic-bezier(0.4, 0, 0.2, 1) 0.6s forwards;
        }
        @keyframes wsProgBarIn {
            to { width: var(--prog-w, 75%); }
        }

        /* KPI Cards Grid */
        .ws-kpi-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .ws-kpi-box {
            background: #FAF8F4;
            border: 1px solid var(--ws-border);
            border-radius: 10px;
            padding: 12px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: var(--ws-transition);
        }
        .ws-kpi-box:hover {
            border-color: var(--ws-gold-primary);
            background: #FFFFFF;
            box-shadow: 0 4px 12px rgba(138,104,31,0.08);
        }
        .ws-kpi-label {
            font-size: 0.70rem;
            font-weight: 700;
            color: var(--ws-text-muted);
            text-transform: uppercase;
            line-height: 1.25;
        }
        .ws-kpi-num {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--ws-text-main);
            margin: 4px 0 2px;
        }
        .ws-kpi-sub {
            font-size: 0.68rem;
            color: var(--ws-success);
            font-weight: 700;
        }

        /* Target & Tier Status Box */
        .ws-tier-status-box {
            background: linear-gradient(135deg, #FAF5E8 0%, #FDFBF7 100%);
            border: 1.5px solid var(--ws-gold-border);
            border-radius: 12px;
            padding: 14px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .ws-tier-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--ws-gold-primary);
            color: #FFFFFF;
            font-size: 0.70rem;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 6px;
            align-self: flex-start;
            font-family: var(--ws-font-serif);
        }

        .ws-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .ws-sec-title-box h3 {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
            font-family: var(--ws-font-serif);
        }
        .ws-sec-title-box p {
            font-size: 0.78rem;
            color: var(--ws-text-muted);
            margin-top: 2px;
        }
        .ws-sec-actions-row {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .ws-segmented-control {
            display: flex;
            background: #FFFFFF;
            border: 1.5px solid var(--ws-border);
            border-radius: 24px;
            padding: 3px;
            box-shadow: var(--ws-shadow-card);
        }
        .ws-seg-btn {
            border: none;
            background: transparent;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.76rem;
            font-weight: 700;
            color: var(--ws-text-muted);
            cursor: pointer;
            transition: var(--ws-transition);
        }
        .ws-seg-btn.active {
            background: var(--ws-gold-primary);
            color: #FFFFFF;
            box-shadow: 0 2px 6px rgba(138,104,31,0.25);
        }
        .ws-date-range-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: 20px;
            border: 1.5px solid var(--ws-border);
            background: #FFFFFF;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--ws-text-sub);
            cursor: pointer;
            box-shadow: var(--ws-shadow-card);
        }

        /* ── Real Coded Vector Icons Utility ── */
        .ws-ico {
            width: 15px;
            height: 15px;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
            display: inline-block;
            vertical-align: -2px;
            flex-shrink: 0;
        }
        .ws-ico.gold {
            stroke: var(--ws-gold-primary);
        }
        .ws-ico.gold-fill {
            fill: var(--ws-gold-primary);
            stroke: none;
        }
        .ws-ico-sm {
            width: 13px;
            height: 13px;
        }
        .ws-ico-lg {
            width: 18px;
            height: 18px;
        }

        /* ── Standard Section Cards ── */
        .ws-card {
            background: #FFFFFF;
            border: 1.5px solid var(--ws-border);
            border-radius: var(--ws-radius-lg);
            padding: clamp(16px, 2vw, 24px);
            margin-bottom: clamp(14px, 2vw, 20px);
            box-shadow: var(--ws-shadow-card);
        }
        .ws-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--ws-border);
            flex-wrap: wrap;
            gap: 10px;
        }
        .ws-card-title-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .ws-card-title-group h3 {
            font-size: 1rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
            font-family: var(--ws-font-serif);
        }

        /* ── Form Inputs & Layout ── */
        .ws-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(clamp(200px, 40vw, 280px), 1fr));
            gap: 14px;
        }
        .ws-form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 12px;
        }
        .ws-form-group.full {
            grid-column: 1 / -1;
        }
        .ws-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--ws-text-main);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .ws-label .req { color: var(--ws-danger); }
        .ws-input, .ws-select, .ws-textarea {
            width: 100%;
            height: 42px;
            border: 1.5px solid var(--ws-border);
            border-radius: var(--ws-radius-sm);
            padding: 0 12px;
            font-family: var(--ws-font-sans);
            font-size: 0.85rem;
            color: var(--ws-text-main);
            background: #FAF8F4;
            outline: none;
            transition: var(--ws-transition);
        }
        .ws-textarea {
            height: 90px;
            padding: 10px 12px;
            resize: vertical;
        }
        .ws-input:focus, .ws-select:focus, .ws-textarea:focus {
            border-color: var(--ws-gold-primary);
            background: #FFFFFF;
            box-shadow: 0 0 0 3px var(--ws-gold-glow);
        }
        .ws-input:disabled {
            background: #EFEBE4;
            color: var(--ws-text-muted);
            cursor: not-allowed;
        }

        .ws-phone-wrap {
            display: flex;
            align-items: center;
            border: 1.5px solid var(--ws-border);
            border-radius: var(--ws-radius-sm);
            background: #FAF8F4;
            overflow: hidden;
        }
        .ws-phone-prefix {
            padding: 0 12px;
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--ws-gold-primary);
            background: var(--ws-gold-light);
            height: 42px;
            display: flex;
            align-items: center;
            border-right: 1px solid var(--ws-border);
            flex-shrink: 0;
        }
        .ws-phone-input {
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
        }

        /* ── Action Buttons ── */
        .ws-btn-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 12px;
            flex-wrap: wrap;
        }
        .ws-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 9px 18px;
            border-radius: var(--ws-radius-sm);
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            border: 1.5px solid transparent;
            transition: var(--ws-transition);
            text-decoration: none;
            white-space: nowrap;
        }
        .ws-btn-primary {
            background: linear-gradient(135deg, var(--ws-gold-primary) 0%, var(--ws-gold-deep) 100%);
            color: #FFFFFF;
            border-color: var(--ws-gold-primary);
            box-shadow: 0 2px 8px rgba(138,104,31,0.25);
        }
        .ws-btn-primary:hover {
            background: linear-gradient(135deg, #785A1A 0%, #4D370E 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(138,104,31,0.35);
        }
        .ws-btn-secondary {
            background: #FFFFFF;
            color: var(--ws-text-main);
            border-color: var(--ws-border);
        }
        .ws-btn-secondary:hover {
            background: var(--ws-gold-light);
            border-color: var(--ws-gold-primary);
            color: var(--ws-gold-primary);
        }
        .ws-btn-wa {
            background: #25D366;
            color: #FFFFFF;
            border-color: #25D366;
        }
        .ws-btn-wa:hover {
            background: #128C7E;
        }
        .ws-btn-sm {
            padding: 6px 12px;
            font-size: 0.76rem;
        }

        /* ── Luxury Animated 'New Order' Button ── */
        .ws-btn-new-order {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: linear-gradient(135deg, #D4AF37 0%, #B45309 100%);
            color: #FFFFFF !important;
            font-weight: 800;
            font-size: clamp(0.72rem, 1.2vw, 0.78rem);
            padding: 5px 12px 5px 6px;
            border-radius: 20px;
            text-decoration: none;
            box-shadow: 0 3px 12px rgba(180, 83, 9, 0.32), inset 0 1px 1px rgba(255, 255, 255, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            letter-spacing: 0.2px;
        }
        .ws-btn-new-order::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transform: skewX(-20deg);
            animation: wsBtnShimmer 3s infinite;
        }
        @keyframes wsBtnShimmer {
            0%, 70% { left: -100%; }
            100% { left: 160%; }
        }
        .ws-btn-new-order:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 5px 16px rgba(180, 83, 9, 0.45);
        }
        .ws-new-order-icon-badge {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }
        .ws-anim-plus-bounce {
            width: 12px;
            height: 12px;
            stroke: #FFFFFF;
            animation: plusPulseSpin 3s ease-in-out infinite;
        }
        @keyframes plusPulseSpin {
            0%, 100% { transform: scale(1) rotate(0deg); }
            50% { transform: scale(1.15) rotate(90deg); }
        }

        /* ── GST Radio Cards ── */
        .ws-gst-selector-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 16px;
        }
        .ws-gst-option-card {
            border: 1.5px solid var(--ws-border);
            border-radius: var(--ws-radius-md);
            padding: 14px 16px;
            background: #FAF8F4;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: var(--ws-transition);
            user-select: none;
        }
        .ws-gst-option-card:hover {
            border-color: var(--ws-gold-primary);
            background: #FFFFFF;
        }
        .ws-gst-option-card.selected {
            border-color: var(--ws-gold-primary);
            background: var(--ws-gold-light);
            box-shadow: 0 2px 8px rgba(138,104,31,0.15);
        }
        .ws-radio-dot {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid var(--ws-text-light);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: var(--ws-transition);
        }
        .ws-gst-option-card.selected .ws-radio-dot {
            border-color: var(--ws-gold-primary);
        }
        .ws-gst-option-card.selected .ws-radio-dot::after {
            content: '';
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: var(--ws-gold-primary);
        }

        /* ── Responsive Order Table ── */
        .ws-table-container {
            width: 100%;
            overflow-x: auto;
            border-radius: var(--ws-radius-md);
            border: 1.5px solid var(--ws-border);
        }
        .ws-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.84rem;
            background: #FFFFFF;
        }
        .ws-table th {
            background: var(--ws-gold-light);
            color: var(--ws-gold-primary);
            font-weight: 800;
            font-size: 0.74rem;
            padding: 12px 14px;
            border-bottom: 1.5px solid var(--ws-gold-border);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
            font-family: var(--ws-font-serif);
        }
        .ws-table td {
            padding: 12px 14px;
            border-bottom: 1px solid #F1ECE3;
            color: var(--ws-text-main);
            vertical-align: middle;
        }
        .ws-table tr:hover td {
            background: #FDFBF7;
        }
        .ws-order-id-cell {
            font-weight: 800;
            color: var(--ws-gold-primary);
        }
        .ws-prod-mini-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .ws-prod-mini-img {
            width: 38px;
            height: 48px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid var(--ws-border);
            flex-shrink: 0;
        }

        /* ── Status Badges ── */
        .ws-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 14px;
            font-size: 0.70rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            white-space: nowrap;
        }
        .ws-status-badge.delivered { background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0; }
        .ws-status-badge.processing { background: #FEF3C7; color: #B45309; border: 1px solid #FDE68A; }
        .ws-status-badge.shipped { background: #DBEAFE; color: #1D4ED8; border: 1px solid #BFDBFE; }
        .ws-status-badge.confirmed { background: #F3E8FF; color: #6B21A8; border: 1px solid #E9D5FF; }
        .ws-status-badge.returned { background: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA; }
        .ws-status-badge.refund { background: #FFE4E6; color: #9F1239; border: 1px solid #FECDD3; }

        /* ── Mobile Order Cards ── */
        .ws-mobile-order-cards {
            display: none;
            flex-direction: column;
            gap: 12px;
        }
        .ws-mob-order-card {
            background: linear-gradient(180deg, #FFFFFF 0%, #FEFCF8 100%);
            border: 1.5px solid rgba(212, 175, 55, 0.28);
            border-radius: 12px;
            padding: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .ws-mob-order-card:hover {
            border-color: rgba(212, 175, 55, 0.6);
            box-shadow: 0 4px 14px rgba(138, 104, 31, 0.12);
            transform: translateY(-2px);
        }
        .ws-mob-order-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
            padding-bottom: 8px;
            border-bottom: 1px dashed rgba(212, 175, 55, 0.25);
        }
        .ws-mob-order-body {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        .ws-mob-order-img {
            width: 58px;
            height: 72px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid rgba(212, 175, 55, 0.25);
            flex-shrink: 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.06);
        }
        .ws-mob-order-info {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }
        .ws-mob-order-title {
            font-family: var(--ws-font-serif);
            font-size: clamp(0.84rem, 1.5vw, 0.94rem);
            font-weight: 800;
            color: #1C1917;
            line-height: 1.25;
            letter-spacing: 0.1px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .ws-mob-order-meta {
            font-size: 0.70rem;
            color: #78716C;
            font-weight: 600;
            line-height: 1.3;
        }
        .ws-mob-order-price {
            font-size: 0.96rem;
            font-weight: 900;
            color: var(--ws-gold-primary);
            letter-spacing: 0.2px;
        }
        .ws-mob-order-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }
        .ws-mob-order-price-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 4px;
        }
        .ws-mob-order-price {
            font-size: 0.98rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
        }
        .ws-mob-order-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            padding-top: 10px;
            border-top: 1px solid var(--ws-border-light);
        }

        /* ── Wholesale Reports Tab Styles ── */
        .ws-report-kpis-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 16px;
        }
        /* ── Wholesale Filter Pills Design System ── */
        .ws-orders-filter-btns,
        .ws-filter-pill-group {
            display: flex;
            align-items: center;
            gap: 6px;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            -ms-overflow-style: none;
            flex-wrap: nowrap;
            padding: 2px 2px 4px;
            width: 100%;
            scroll-snap-type: x mandatory;
        }
        .ws-orders-filter-btns::-webkit-scrollbar,
        .ws-filter-pill-group::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }
        .ws-rep-filter-btn {
            background: #FAF8F4;
            color: #57534E;
            border: 1.2px solid rgba(138, 104, 31, 0.22);
            padding: 4.5px 12px;
            border-radius: 18px;
            font-size: clamp(0.70rem, 1.1vw, 0.75rem);
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap !important;
            flex-shrink: 0 !important;
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            gap: 3px;
            line-height: 1;
            height: 28px;
            user-select: none;
            scroll-snap-align: start;
        }
        .ws-rep-filter-btn:hover {
            border-color: var(--ws-gold-primary);
            color: var(--ws-gold-primary);
            background: #FFFFFF;
            transform: translateY(-1px);
        }
        .ws-rep-filter-btn.active {
            background: linear-gradient(135deg, #FAF5E8 0%, #F5EDD6 100%);
            color: #785912;
            border-color: var(--ws-gold-primary);
            box-shadow: 0 2px 6px rgba(138, 104, 31, 0.15);
            font-weight: 800;
            transform: translateY(-1px);
        }
        .ws-mobile-reports-cards {
            display: none;
            flex-direction: column;
            gap: 12px;
        }
        .ws-mob-report-card {
            background: #FFFFFF;
            border: 1.5px solid var(--ws-border);
            border-radius: var(--ws-radius-md);
            padding: 14px;
            box-shadow: var(--ws-shadow-card);
            transition: var(--ws-transition);
        }
        .ws-mob-report-card:hover {
            border-color: var(--ws-gold-border);
            box-shadow: 0 4px 16px rgba(138,104,31,0.12);
        }
        .ws-mob-rep-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px dashed var(--ws-border);
        }
        .ws-mob-rep-body {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
        }
        .ws-mob-rep-img {
            width: 58px;
            height: 74px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid var(--ws-border);
            flex-shrink: 0;
            background: #FAF8F4;
        }
        .ws-mob-rep-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }
        .ws-mob-rep-tax-grid {
            background: #FAF8F4;
            border: 1px solid var(--ws-border);
            border-radius: 8px;
            padding: 10px 12px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            font-size: 0.74rem;
            margin-bottom: 12px;
        }
        .ws-mob-rep-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            padding-top: 10px;
            border-top: 1px solid var(--ws-border-light);
        }

        /* ── Trending Products Slider ── */
        .ws-slider-wrap {
            position: relative;
            margin: 8px 0 20px;
        }
        .ws-slider-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #FFFFFF;
            border: 1.5px solid var(--ws-gold-border);
            color: var(--ws-gold-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--ws-shadow-card);
            z-index: 10;
            transition: var(--ws-transition);
        }
        .ws-slider-nav-btn:hover {
            background: var(--ws-gold-primary);
            color: #FFFFFF;
            border-color: var(--ws-gold-primary);
        }
        .ws-slider-nav-btn.prev { left: -14px; }
        .ws-slider-nav-btn.next { right: -14px; }

        .ws-slider-track {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 6px 2px 14px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            scroll-snap-type: x mandatory;
        }
        .ws-slider-track::-webkit-scrollbar { display: none; }

        /* ════════════════════════════════════════════════════
           EXACT SHOP PAGE PRODUCT CARD DESIGN & RESPONSIVE GRID
        ════════════════════════════════════════════════════ */
        .products-grid, .ws-master-catalog-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            width: 100%;
        }
        @media (min-width: 600px) { 
            .products-grid, .ws-master-catalog-grid { 
                grid-template-columns: repeat(3, 1fr); 
                gap: 14px; 
            } 
        }
        @media (min-width: 1024px) { 
            .products-grid, .ws-master-catalog-grid { 
                grid-template-columns: repeat(4, 1fr); 
                gap: 16px; 
            } 
        }
        @media (min-width: 1280px) { 
            .products-grid, .ws-master-catalog-grid { 
                grid-template-columns: repeat(4, 1fr); 
                gap: 18px; 
            } 
        }

        .ws-master-catalog-grid .product-card {
            width: 100% !important;
            min-width: 0 !important;
            max-width: none !important;
            flex: unset !important;
        }

        .product-card, .ws-product-card {
            position: relative;
            background: #FFFFFF;
            border-radius: 12px;
            border: 1px solid #E5E3DE;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
            display: flex;
            flex-direction: column;
            width: 100%;
        }
        .ws-slider-track .product-card,
        .ws-slider-track .ws-product-card {
            flex: 0 0 calc((100% - 48px) / 5);
            min-width: 155px;
            max-width: 240px;
            scroll-snap-align: start;
        }
        @media (min-width: 1400px) {
            .ws-slider-track .product-card,
            .ws-slider-track .ws-product-card {
                flex: 0 0 calc((100% - 48px) / 5);
            }
        }
        @media (max-width: 1200px) and (min-width: 1024px) {
            .ws-slider-track .product-card,
            .ws-slider-track .ws-product-card {
                flex: 0 0 calc((100% - 40px) / 4.4);
                min-width: 160px;
            }
        }
        @media (max-width: 1023px) {
            .ws-slider-track .product-card,
            .ws-slider-track .ws-product-card {
                flex: 0 0 calc((100% - 24px) / 3.3);
                min-width: 145px;
            }
        }
        @media (max-width: 600px) {
            .ws-slider-track {
                gap: 8px !important;
                padding: 4px 2px 10px !important;
            }
            .ws-slider-track .product-card,
            .ws-slider-track .ws-product-card {
                flex: 0 0 calc((100% - 16px) / 2.38) !important;
                min-width: 125px !important;
                max-width: 160px !important;
                border-radius: 10px !important;
            }
        }

        .product-card:hover, .ws-product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            border-color: rgba(138,104,31,0.3);
        }

        .card-image-wrap, .ws-prod-img-wrap {
            position: relative;
            overflow: hidden;
            background: #FAF8F4;
            aspect-ratio: 3 / 3.75;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            border-radius: 11px 11px 0 0;
        }
        .card-img, .ws-prod-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            transition: transform 0.45s cubic-bezier(0.25, 1, 0.5, 1);
        }

        /* ── Direct Add to Cart '+' Button (Integrated in Price Row) ── */
        .card-price-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 4px;
            margin-top: 4px;
        }
        .card-price-stack {
            display: flex;
            align-items: baseline;
            gap: 4px;
            flex-wrap: wrap;
            flex: 1;
            min-width: 0;
        }
        .card-smart-add-cart-btn {
            width: clamp(24px, 6.5vw, 28px);
            height: clamp(24px, 6.5vw, 28px);
            min-width: clamp(24px, 6.5vw, 28px);
            border-radius: 50%;
            background: linear-gradient(135deg, #D4AF37 0%, #B45309 100%);
            border: 1.5px solid #FFFFFF;
            box-shadow: 0 2px 6px rgba(180, 83, 9, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            color: #FFFFFF;
            padding: 0;
            flex-shrink: 0;
        }
        .card-smart-add-cart-btn:hover {
            transform: scale(1.14) rotate(90deg);
            box-shadow: 0 4px 12px rgba(180, 83, 9, 0.55);
            background: linear-gradient(135deg, #F59E0B 0%, #92400E 100%);
        }
        .card-smart-add-cart-btn:active {
            transform: scale(0.92);
        }
        .card-smart-add-cart-btn.added {
            background: #10B981 !important;
            border-color: #FFFFFF;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.5);
            transform: scale(1.08);
        }
        .card-smart-add-cart-btn svg {
            width: 13px;
            height: 13px;
            stroke: #FFFFFF;
            stroke-width: 2.6;
            fill: none;
            transition: transform 0.2s ease;
        }

        /* ── Procure / Check By Price Smart Slider ── */
        .ws-price-slider-wrap {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
        }
        .ws-price-slider-track {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            padding: 8px 4px 14px;
            width: 100%;
        }
        .ws-price-slider-track::-webkit-scrollbar { display: none; }
        .ws-price-slider-track { -ms-overflow-style: none; scrollbar-width: none; }

        .ws-price-box-card {
            flex: 0 0 calc((100% - 60px) / 6);
            min-width: 140px;
            max-width: 190px;
            scroll-snap-align: start;
            background: linear-gradient(145deg, #FFFFFF 0%, #FAF7F0 100%);
            border: 1.5px solid rgba(138, 104, 31, 0.22);
            border-radius: 14px;
            padding: 14px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(0,0,0,0.05);
            transition: all 0.28s cubic-bezier(0.25, 1, 0.5, 1);
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }
        .ws-price-box-card:hover {
            transform: translateY(-4px);
            border-color: #D4AF37;
            box-shadow: 0 8px 20px rgba(180, 83, 9, 0.18), 0 0 0 1px rgba(212, 175, 55, 0.4);
        }
        .ws-price-box-card.active {
            border-color: #B45309 !important;
            background: linear-gradient(145deg, #FEF3C7 0%, #FDE68A 100%) !important;
            box-shadow: 0 0 0 2.5px #B45309, 0 8px 20px rgba(180, 83, 9, 0.28) !important;
            transform: translateY(-3px);
        }
        .ws-price-box-icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
            border: 1.5px solid rgba(217, 119, 6, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
            box-shadow: 0 3px 8px rgba(217, 119, 6, 0.16);
            transition: transform 0.3s ease;
        }
        .ws-price-box-card:hover .ws-price-box-icon-wrap,
        .ws-price-box-card.active .ws-price-box-icon-wrap {
            transform: scale(1.12);
        }
        .ws-price-box-val {
            font-family: var(--ws-font-serif);
            font-size: 1.05rem;
            font-weight: 800;
            color: #24211C;
            line-height: 1.2;
            margin: 0;
            white-space: nowrap;
        }
        .ws-price-box-card.active .ws-price-box-val {
            color: #92400E;
            font-weight: 900;
        }

        @media (max-width: 1023px) {
            .ws-price-box-card {
                flex: 0 0 calc((100% - 30px) / 3.4);
                min-width: 130px;
            }
        }
        @media (max-width: 600px) {
            .ws-price-slider-track {
                gap: 8px !important;
                padding: 4px 2px 10px !important;
            }
            .ws-price-box-card {
                flex: 0 0 calc((100% - 16px) / 2.38) !important;
                min-width: 115px !important;
                max-width: 145px !important;
                padding: 10px 6px !important;
                border-radius: 12px !important;
            }
            .ws-price-box-icon-wrap {
                width: 36px !important;
                height: 36px !important;
                border-radius: 10px !important;
                margin-bottom: 6px !important;
            }
            .ws-price-box-val {
                font-size: 0.88rem !important;
            }
        }
        .product-card:hover .card-img,
        .product-card:hover .ws-prod-img,
        .ws-product-card:hover .card-img,
        .ws-product-card:hover .ws-prod-img {
            transform: scale(1.05);
        }

        .card-badge, .ws-prod-badge {
            position: absolute;
            bottom: 8px;
            left: 8px;
            top: auto;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.52rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            z-index: 2;
            background: rgba(138, 104, 31, 0.85);
            color: #FFFFFF;
            backdrop-filter: blur(6px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 2px 8px rgba(0,0,0,0.18);
            width: auto;
            max-width: calc(100% - 40px);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
        }
        @media (min-width: 600px) {
            .card-badge, .ws-prod-badge {
                top: 10px;
                left: 10px;
                bottom: auto;
                padding: 3.5px 9px;
                border-radius: 14px;
                font-size: 0.56rem;
                letter-spacing: 0.1em;
            }
        }
        .card-badge.badge-new, .ws-prod-badge.badge-new { background: rgba(248, 246, 240, 0.92); color: var(--ws-gold-primary); border-color: rgba(138,104,31,0.4); }
        .card-badge.badge-bridal, .ws-prod-badge.badge-bridal { background: rgba(122, 40, 77, 0.88); color: #ffffff; border-color: rgba(255,255,255,0.35); }
        .card-badge.badge-heritage, .ws-prod-badge.badge-heritage { background: rgba(94, 67, 20, 0.88); color: #ffffff; border-color: rgba(255,255,255,0.35); }
        .card-badge.badge-bestseller, .ws-prod-badge.badge-bestseller { background: rgba(36, 33, 28, 0.85); color: #ffffff; border-color: rgba(255,255,255,0.3); }
        .card-badge.badge-trending, .card-badge.badge-fast-selling, .ws-prod-badge.badge-trending { background: rgba(184, 107, 40, 0.88); color: #ffffff; border-color: rgba(255,255,255,0.35); }
        .card-badge.badge-royal-vip { background: linear-gradient(135deg, #8A681F, #C5A859); color: #ffffff; border-color: rgba(255,255,255,0.4); }

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
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(6px);
            box-shadow: 0 2px 6px rgba(0,0,0,0.12);
            cursor: pointer;
        }
        .card-wishlist-btn:hover { background: #F5EDD6; border-color: #8A681F; transform: scale(1.08); }
        .card-wishlist-btn.active { background: #FDE8E8; border-color: #E57373; }
        .card-wishlist-btn svg {
            width: clamp(10px, 3.2vw, 14px);
            height: clamp(10px, 3.2vw, 14px);
            stroke: #8A681F;
            stroke-width: 2;
            fill: none;
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
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
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(6px);
            box-shadow: 0 2px 6px rgba(0,0,0,0.12);
            cursor: pointer;
        }
        .card-mobile-qv-btn:hover, .card-mobile-qv-btn:active { background: #F5EDD6; border-color: #8A681F; transform: scale(1.08); }
        .card-mobile-qv-btn svg {
            width: clamp(10px, 3.2vw, 14px);
            height: clamp(10px, 3.2vw, 14px);
            stroke: #8A681F;
            stroke-width: 2;
            fill: none;
            flex-shrink: 0;
        }

        @media (min-width: 1024px) {
            .card-wishlist-btn {
                top: 8px; right: 8px;
                width: 34px; height: 34px;
                background: rgba(248,246,240,0.92);
                border-color: #E5E3DE;
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
            opacity: 0; transform: translateY(6px); transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1); z-index: 2;
        }
        .product-card:hover .card-quick-view,
        .ws-product-card:hover .card-quick-view { opacity: 1; transform: translateY(0); }
        .quick-view-btn {
            font-family: var(--font-sans, 'Plus Jakarta Sans', sans-serif); font-size: 0.68rem; font-weight: 700;
            letter-spacing: 0.12em; text-transform: uppercase;
            color: #24211C; padding: 7px 18px; border-radius: 20px;
            border: 1px solid rgba(138,104,31,0.3);
            background: rgba(248,246,240,0.95); backdrop-filter: blur(8px);
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }
        .quick-view-btn:hover { background: #8A681F; color: #fff; border-color: #8A681F; }

        .card-body {
            padding: clamp(7px, 1.8vw, 10px);
            display: flex;
            flex-direction: column;
            gap: 2px;
            flex: 1;
        }

        .card-fabric-tag {
            font-size: clamp(0.5rem, 1.5vw, 0.58rem);
            font-weight: 600;
            color: #8A681F;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-name {
            font-family: 'Cinzel', serif;
            font-size: clamp(0.72rem, 2.1vw, 0.82rem);
            font-weight: 600;
            color: #24211C;
            line-height: 1.25;
            letter-spacing: 0.01em;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            min-height: auto;
            margin-bottom: 2px;
            transition: color 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .product-card:hover .card-name,
        .ws-product-card:hover .card-name { color: #8A681F; }

        .card-cat-photo-tag {
            position: absolute;
            bottom: 6px;
            right: 6px;
            font-family: var(--font-sans, 'Plus Jakarta Sans', sans-serif);
            font-size: clamp(0.46rem, 1.3vw, 0.54rem);
            font-weight: 700;
            color: #8A681F;
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid rgba(138, 104, 31, 0.38);
            border-radius: 4px;
            padding: 2px 5px;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            line-height: 1.1;
            backdrop-filter: blur(8px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
            z-index: 2;
            pointer-events: none;
        }

        /* ── Share Icon Button on Product Photo (Directly above Category Tag) ── */
        .card-share-btn {
            position: absolute;
            bottom: 28px;
            right: 6px;
            width: clamp(22px, 6.8vw, 28px);
            height: clamp(22px, 6.8vw, 28px);
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(138, 104, 31, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8A681F;
            cursor: pointer;
            z-index: 3;
            transition: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(6px);
            box-shadow: 0 2px 6px rgba(0,0,0,0.12);
        }
        .card-share-btn:hover, .card-share-btn:active {
            background: #8A681F;
            color: #FFFFFF;
            border-color: #8A681F;
            transform: scale(1.1);
        }
        .card-share-btn svg {
            width: clamp(10px, 3vw, 13px);
            height: clamp(10px, 3vw, 13px);
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
        }

        .card-info-text-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: clamp(0.54rem, 1.6vw, 0.64rem);
            color: #5A5348;
            font-weight: 600;
            margin: 1px 0 3px;
            gap: 4px;
            white-space: nowrap;
        }
        .card-colors-text {
            color: #8A681F;
            font-weight: 700;
            font-size: inherit;
            white-space: nowrap;
        }
        .card-sizes-text {
            color: #9A9490;
            font-size: inherit;
            white-space: nowrap;
        }

        .card-price-row {
            display: flex;
            align-items: baseline;
            gap: clamp(3px, 1.2vw, 6px);
            margin-top: auto;
            padding-top: 2px;
            flex-wrap: wrap;
        }
        .card-price {
            font-family: var(--font-sans, 'Plus Jakarta Sans', sans-serif);
            font-size: clamp(0.78rem, 2.3vw, 0.90rem);
            font-weight: 700;
            color: #8A681F;
        }
        .card-old-price {
            font-size: clamp(0.60rem, 1.7vw, 0.68rem);
            color: #9A9490;
            text-decoration: line-through;
        }
        .card-price-discount {
            font-size: clamp(0.48rem, 1.4vw, 0.56rem);
            font-weight: 700;
            color: #2E7D32;
            background: #E8F5E9;
            padding: 1.5px 4.5px;
            border-radius: 3px;
            margin-left: auto;
            letter-spacing: 0.02em;
            white-space: nowrap;
        }

        /* ── Modals Backdrop & Box ── */
        .ws-modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(20, 17, 14, 0.7);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 2000000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.24s ease, visibility 0.24s ease;
            padding: 14px;
        }
        .ws-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .ws-modal-box {
            background: #FFFFFF;
            width: 100%;
            max-width: 620px;
            max-height: 90vh;
            border-radius: var(--ws-radius-lg);
            border: 1.5px solid var(--ws-gold-border);
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transform: translateY(18px) scale(0.98);
            transition: transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .ws-modal-overlay.active .ws-modal-box {
            transform: translateY(0) scale(1);
        }
        .ws-modal-header {
            background: #FFFFFF;
            border-bottom: 1.5px solid var(--ws-gold-border);
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }
        .ws-modal-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: var(--ws-font-serif);
        }
        .ws-modal-close-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid var(--ws-gold-border);
            background: var(--ws-gold-light);
            color: var(--ws-gold-primary);
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--ws-transition);
        }
        .ws-modal-close-btn:hover {
            background: var(--ws-gold-primary);
            color: #FFFFFF;
        }
        .ws-modal-body {
            padding: 18px 20px;
            overflow-y: auto;
            flex: 1;
            -webkit-overflow-scrolling: touch;
        }
        .ws-modal-footer {
            padding: 14px 20px;
            background: #FFFFFF;
            border-top: 1.5px solid var(--ws-border);
            display: flex;
            gap: 10px;
            align-items: center;
            flex-shrink: 0;
        }

        /* ── Live Shipment Timeline ── */
        .ws-track-timeline {
            position: relative;
            padding-left: 28px;
            margin: 18px 0;
        }
        .ws-track-timeline::before {
            content: '';
            position: absolute;
            left: 9px;
            top: 8px;
            bottom: 8px;
            width: 2px;
            background: var(--ws-border);
        }
        .ws-timeline-step {
            position: relative;
            margin-bottom: 18px;
        }
        .ws-timeline-dot {
            position: absolute;
            left: -28px;
            top: 2px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--ws-border);
            border: 3px solid #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ws-timeline-step.completed .ws-timeline-dot { background: #15803D; }
        .ws-timeline-step.active .ws-timeline-dot {
            background: var(--ws-gold-primary);
            box-shadow: 0 0 0 4px var(--ws-gold-glow);
        }
        .ws-timeline-dot svg {
            width: 10px;
            height: 10px;
            stroke: #FFFFFF;
            stroke-width: 3;
            fill: none;
        }
        .ws-timeline-title {
            font-size: 0.86rem;
            font-weight: 700;
            color: var(--ws-text-main);
        }
        .ws-timeline-date {
            font-size: 0.74rem;
            color: var(--ws-text-muted);
            margin-top: 2px;
        }

        /* ── Consignment Tracking Cards & Grid ── */
        .ws-track-order-card {
            background: #FFFFFF;
            border: 1.5px solid var(--ws-border);
            border-radius: var(--ws-radius-md);
            padding: 12px;
            cursor: pointer;
            transition: var(--ws-transition);
            display: flex;
            gap: 12px;
            align-items: center;
        }
        .ws-track-order-card:hover {
            border-color: var(--ws-gold-border);
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(138,104,31,0.12);
        }
        .ws-track-order-card.selected {
            border-color: var(--ws-gold-primary);
            background: #FDFBF7;
            box-shadow: 0 0 0 2px rgba(138,104,31,0.2), 0 4px 14px rgba(138,104,31,0.12);
        }
        .ws-track-order-img {
            width: 54px;
            height: 68px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid var(--ws-border);
            flex-shrink: 0;
            background: #FAF8F4;
        }
        .ws-track-order-info {
            flex: 1;
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }
        .ws-track-order-title {
            font-size: 0.86rem;
            font-weight: 700;
            color: var(--ws-text-main);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .ws-track-orders-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(clamp(260px, 45vw, 360px), 1fr));
            gap: 12px;
        }

        /* ── Auto-Responsive Dual Action Button Grid ── */
        .ws-dual-action-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            width: 100%;
            margin-top: 14px;
            padding-top: 12px;
            border-top: 1px dashed var(--ws-border);
            box-sizing: border-box;
        }
        .ws-dual-action-grid .ws-btn {
            width: 100%;
            height: 42px;
            padding: 8px 8px;
            font-size: clamp(0.72rem, 2.7vw, 0.82rem);
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
            border-radius: 8px;
            gap: 5px;
            box-sizing: border-box;
            text-decoration: none;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .ws-dual-action-grid .ws-btn svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
        }
        @media (max-width: 440px) {
            .ws-dual-action-grid {
                grid-template-columns: 1fr 1fr;
                gap: 6px;
            }
            .ws-dual-action-grid .ws-btn {
                padding: 6px 4px;
                font-size: 0.74rem;
                gap: 4px;
            }
            .ws-dual-action-grid .ws-btn svg {
                width: 13px;
                height: 13px;
            }
        }
        @media (max-width: 350px) {
            .ws-dual-action-grid {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            .ws-dual-action-grid .ws-btn {
                height: 40px;
                font-size: 0.80rem;
            }
        }

        /* ── Support Ticket Card & Animations ── */
        .ws-ticket-card {
            border: 1.5px solid var(--ws-border);
            border-radius: var(--ws-radius-md);
            padding: 14px;
            background: #FFFFFF;
            margin-bottom: 12px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.02);
            transition: all 0.25s ease;
        }
        .ws-ticket-card:hover {
            border-color: var(--ws-gold-border);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(138, 104, 31, 0.08);
        }
        .ws-ticket-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 6px;
        }
        .ws-pulse-dot {
            display: inline-block;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: currentColor;
            margin-right: 4px;
            animation: pulseGlow 1.8s infinite;
        }
        @keyframes pulseGlow {
            0% { transform: scale(0.95); opacity: 0.7; box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
            70% { transform: scale(1.15); opacity: 1; box-shadow: 0 0 0 5px rgba(245, 158, 11, 0); }
            100% { transform: scale(0.95); opacity: 0.7; box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
        }

        /* ── Modern Frosted Gold Glassy Animated B2B Wallet & Coins Strip ── */
        .ws-wallet-strip {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.94) 0%, rgba(254, 250, 238, 0.88) 50%, rgba(248, 238, 210, 0.92) 100%);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border: 1.5px solid rgba(212, 175, 55, 0.55);
            border-radius: 12px;
            padding: 8px 12px 8px 16px;
            margin-bottom: 14px;
            color: #16130F;
            box-shadow: 0 4px 20px rgba(180, 140, 40, 0.12), inset 0 1px 2px rgba(255, 255, 255, 0.95), inset 0 0 16px rgba(245, 215, 130, 0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
            flex-wrap: nowrap;
        }
        /* 3D Diagonal Tircha Corner Ribbon Tag */
        .ws-wallet-ribbon-tag {
            position: absolute;
            top: 0;
            left: 0;
            width: 52px;
            height: 52px;
            overflow: hidden;
            pointer-events: none;
            z-index: 10;
            border-top-left-radius: 12px;
        }
        .ws-wallet-ribbon-tag span {
            position: absolute;
            display: block;
            width: 74px;
            padding: 1.5px 0;
            background: linear-gradient(135deg, #785912 0%, #D4AF37 40%, #FEF08A 60%, #8A681F 100%);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.25), inset 0 1px 1px rgba(255, 255, 255, 0.7);
            color: #1A1204;
            font-size: 0.44rem;
            font-weight: 900;
            text-transform: uppercase;
            text-align: center;
            left: -19px;
            top: 9px;
            transform: rotate(-45deg);
            letter-spacing: 0.6px;
            border-top: 1px solid rgba(255, 255, 255, 0.7);
            border-bottom: 1px solid rgba(120, 89, 18, 0.5);
            text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
        }
        /* Glowing Gold Light Radial Background Orb */
        .ws-wallet-strip::before {
            content: '';
            position: absolute;
            top: -30px;
            right: -20px;
            width: 120px;
            height: 120px;
            background: radial-gradient(circle, rgba(230, 195, 95, 0.35) 0%, rgba(230, 195, 95, 0) 70%);
            pointer-events: none;
            animation: goldOrbPulse 4s ease-in-out infinite alternate;
        }
        @keyframes goldOrbPulse {
            0% { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(1.25); opacity: 0.95; }
        }
        .ws-wallet-metrics-group {
            display: flex;
            align-items: center;
            gap: clamp(8px, 2.5vw, 18px);
            flex-wrap: nowrap;
            position: relative;
            z-index: 2;
            min-width: 0;
        }
        .ws-wallet-metric-item {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }
        .ws-wallet-icon-wrapper {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #FFFFFF 0%, #FEF3C7 60%, #FDE68A 100%);
            border: 1.5px solid rgba(212, 175, 55, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            position: relative;
            box-shadow: 0 3px 10px rgba(180, 140, 40, 0.2), inset 0 1px 2px #FFFFFF;
        }
        .ws-wallet-icon-wrapper.coin {
            background: linear-gradient(135deg, #FFFFFF 0%, #FED7AA 60%, #FDBA74 100%);
            border-color: rgba(245, 158, 11, 0.6);
            box-shadow: 0 3px 10px rgba(245, 158, 11, 0.2), inset 0 1px 2px #FFFFFF;
        }
        .ws-anim-wallet-svg {
            width: 22px;
            height: 22px;
            animation: walletFloat 3s ease-in-out infinite;
        }
        @keyframes walletFloat {
            0%, 100% { transform: translateY(0) scale(1); filter: drop-shadow(0 0 0 rgba(138, 104, 31, 0)); }
            50% { transform: translateY(-1.5px) scale(1.06); filter: drop-shadow(0 2px 6px rgba(180, 140, 40, 0.4)); }
        }
        .ws-anim-coin-svg {
            width: 22px;
            height: 22px;
            animation: coinSpinShimmer 4s ease-in-out infinite;
        }
        @keyframes coinSpinShimmer {
            0%, 100% { transform: rotateY(0deg) scale(1); filter: drop-shadow(0 0 0 rgba(245, 158, 11, 0)); }
            50% { transform: rotateY(180deg) scale(1.08); filter: drop-shadow(0 2px 8px rgba(245, 158, 11, 0.5)); }
        }
        .ws-wallet-metric-content {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .ws-wallet-metric-label {
            font-size: 0.60rem;
            color: #786D5E;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 0.4px;
            line-height: 1;
            margin-bottom: 2px;
            white-space: nowrap;
        }
        .ws-wallet-metric-value {
            font-size: clamp(0.92rem, 2.8vw, 1.25rem);
            font-weight: 900;
            color: #16130F;
            font-family: var(--ws-font-serif);
            letter-spacing: 0.2px;
            line-height: 1.1;
            white-space: nowrap;
        }
        .ws-wallet-metric-value.gold {
            color: #B45309;
        }
        .ws-wallet-strip-actions {
            display: flex;
            align-items: center;
            flex-shrink: 0;
            position: relative;
            z-index: 2;
        }
        .ws-btn-wallet-view-sm {
            background: linear-gradient(135deg, #8A681F 0%, #6E5114 100%);
            color: #FFFFFF !important;
            border: 1px solid #D4AF37;
            font-size: 0.72rem;
            font-weight: 800;
            height: 28px;
            padding: 0 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            cursor: pointer;
            transition: var(--ws-transition);
            white-space: nowrap;
            letter-spacing: 0.2px;
            box-shadow: 0 3px 8px rgba(138, 104, 31, 0.25);
        }
        .ws-btn-wallet-view-sm:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(138, 104, 31, 0.4);
            filter: brightness(1.1);
        }

        @media (max-width: 768px) {
            .ws-wallet-strip {
                padding: 8px 10px 8px 14px;
                gap: 8px;
            }
            .ws-wallet-metrics-group {
                gap: 10px;
            }
        }

        /* ── Fullscreen Compact Responsive Passbook & Wallet Modal on Mobile ── */
        @media (max-width: 640px) {
            #wsFullWalletModal.ws-modal-overlay {
                padding: 0 !important;
                align-items: stretch !important;
            }
            #wsFullWalletModal .ws-modal-box {
                width: 100vw !important;
                max-width: 100vw !important;
                height: 100vh !important;
                max-height: 100vh !important;
                border-radius: 0 !important;
                border: none !important;
                margin: 0 !important;
                display: flex !important;
                flex-direction: column !important;
            }
            #wsFullWalletModal .ws-modal-header {
                padding: 8px 12px !important;
                border-bottom: 1.5px solid var(--ws-gold-border) !important;
            }
            #wsFullWalletModal .ws-modal-title {
                font-size: 0.88rem !important;
            }
            #wsFullWalletModal .ws-modal-close-btn {
                width: 26px !important;
                height: 26px !important;
                font-size: 0.95rem !important;
            }
            #wsFullWalletModal .ws-modal-body {
                flex: 1 1 auto !important;
                overflow-y: auto !important;
                -webkit-overflow-scrolling: touch;
                padding: 8px 10px !important;
            }
            #wsFullWalletModal .ws-full-wallet-card {
                padding: 8px 10px !important;
                border-radius: 10px !important;
            }
            #wsFullWalletModal .ws-full-card-top {
                margin-bottom: 3px !important;
            }
            #wsFullWalletModal .ws-full-card-badge {
                font-size: 0.58rem !important;
            }
            #wsFullWalletModal .ws-full-card-pill {
                font-size: 0.52rem !important;
                padding: 1px 4px !important;
            }
            #wsFullWalletModal .ws-full-card-val {
                font-size: 1.15rem !important;
                margin-bottom: 2px !important;
            }
            #wsFullWalletModal .ws-full-card-sub {
                font-size: 0.60rem !important;
            }
            #wsFullWalletModal .ws-txn-row {
                padding: 6px 8px !important;
                gap: 8px !important;
            }
            #wsFullWalletModal .ws-txn-icon-wrap {
                width: 28px !important;
                height: 28px !important;
                border-radius: 6px !important;
            }
            #wsFullWalletModal .ws-txn-icon-wrap svg {
                width: 13px !important;
                height: 13px !important;
            }
            #wsFullWalletModal .ws-txn-info strong {
                font-size: 0.70rem !important;
            }
            #wsFullWalletModal .ws-txn-info span {
                font-size: 0.58rem !important;
            }
            #wsFullWalletModal .ws-txn-amt strong {
                font-size: 0.76rem !important;
            }
            #wsFullWalletModal .ws-txn-badge {
                font-size: 0.52rem !important;
                padding: 1px 4px !important;
            }
            #wsFullWalletModal .ws-modal-footer {
                padding: 6px 10px calc(8px + env(safe-area-inset-bottom)) !important;
                background: #FFFFFF !important;
                border-top: 1.5px solid var(--ws-border) !important;
                display: grid !important;
                grid-template-columns: 1fr 1fr !important;
                gap: 8px !important;
            }
            #wsFullWalletModal .ws-modal-footer .ws-btn {
                height: 34px !important;
                font-size: 0.70rem !important;
                padding: 0 6px !important;
                border-radius: 6px !important;
            }
            #wsFullWalletModal .ws-modal-footer .ws-btn svg {
                width: 13px !important;
                height: 13px !important;
                margin-right: 4px !important;
            }
        }

        /* ── Styled Full Wallet Modal Component Styles ── */
        .ws-full-wallet-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(254, 250, 238, 0.92) 100%);
            border: 1.5px solid rgba(212, 175, 55, 0.55);
            border-radius: 12px;
            padding: 12px 14px;
            color: #16130F;
            box-shadow: 0 4px 14px rgba(180, 140, 40, 0.08), inset 0 1px 2px #FFFFFF;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .ws-full-wallet-card.coin {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.98) 0%, rgba(254, 243, 225, 0.92) 100%);
            border-color: rgba(245, 158, 11, 0.55);
        }
        .ws-full-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
            margin-bottom: 6px;
        }
        .ws-full-card-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.65rem;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #8A681F;
        }
        .ws-full-card-badge.coin {
            color: #B45309;
        }
        .ws-full-card-pill {
            font-size: 0.58rem;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 4px;
            background: #DCFCE7;
            color: #15803D;
            border: 1px solid rgba(22, 163, 74, 0.3);
            letter-spacing: 0.3px;
            white-space: nowrap;
        }
        .ws-full-card-pill.coin {
            background: #FEF3C7;
            color: #B45309;
            border-color: rgba(217, 119, 6, 0.3);
        }
        .ws-full-card-val {
            font-size: clamp(1.25rem, 3.2vw, 1.45rem);
            font-weight: 900;
            color: #16130F;
            font-family: var(--ws-font-serif);
            letter-spacing: 0.3px;
            line-height: 1.15;
            margin-bottom: 4px;
        }
        .ws-full-card-val.gold {
            color: #B45309;
        }
        .ws-full-card-sub {
            font-size: 0.68rem;
            color: #6B6357;
            line-height: 1.2;
        }
        .ws-full-card-sub strong {
            color: #16130F;
            font-weight: 700;
        }
        .ws-txn-row {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-bottom: 1px solid var(--ws-border);
            transition: var(--ws-transition);
        }
        .ws-txn-row:last-child {
            border-bottom: none;
        }
        .ws-txn-row:hover {
            background: #FAF8F4;
        }
        .ws-txn-icon-wrap {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .ws-txn-icon-wrap.green {
            background: #DCFCE7;
            color: #15803D;
            border: 1px solid rgba(22, 163, 74, 0.25);
        }
        .ws-txn-icon-wrap.red {
            background: #FEE2E2;
            color: #DC2626;
            border: 1px solid rgba(220, 38, 38, 0.25);
        }
        .ws-txn-icon-wrap.amber {
            background: #FEF3C7;
            color: #D97706;
            border: 1px solid rgba(217, 119, 6, 0.25);
        }
        .ws-txn-icon-wrap.blue {
            background: #DBEAFE;
            color: #1D4ED8;
            border: 1px solid rgba(29, 78, 216, 0.25);
        }
        .ws-txn-info strong {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--ws-text-main);
            display: block;
            line-height: 1.2;
            margin-bottom: 2px;
        }
        .ws-txn-info span {
            font-size: 0.66rem;
            color: var(--ws-text-muted);
            display: block;
            line-height: 1.1;
        }
        .ws-txn-amt {
            text-align: right;
            flex-shrink: 0;
        }
        .ws-txn-amt strong {
            font-size: 0.84rem;
            font-weight: 800;
            display: block;
            line-height: 1.2;
        }
        .ws-txn-amt .ws-txn-badge {
            font-size: 0.58rem;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 2px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .ws-txn-badge.green { background: #DCFCE7; color: #15803D; }
        .ws-txn-badge.red { background: #FEE2E2; color: #DC2626; }
        .ws-txn-badge.amber { background: #FEF3C7; color: #D97706; }
        .ws-txn-badge.blue { background: #DBEAFE; color: #1D4ED8; }

        /* Animated Download & Withdraw Action Icons */
        .ws-anim-dl-icon {
            width: 15px;
            height: 15px;
            animation: dlBounce 2s ease-in-out infinite;
        }
        @keyframes dlBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(2.5px); }
        }
        .ws-anim-withdraw-icon {
            width: 15px;
            height: 15px;
            animation: withdrawPulse 2.5s ease-in-out infinite;
        }
        @keyframes withdrawPulse {
            0%, 100% { transform: scale(1) translate(0, 0); }
            50% { transform: scale(1.12) translate(1px, -1px); }
        }

        /* ── VIP Tier Roadmap Modal Component Styles ── */
        .ws-tier-card {
            padding: 10px 12px;
            border: 1.5px solid var(--ws-border);
            border-radius: 10px;
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            transition: var(--ws-transition);
        }
        .ws-tier-card:hover {
            border-color: var(--ws-gold-primary);
            box-shadow: 0 4px 12px rgba(180, 140, 40, 0.08);
            transform: translateY(-1px);
        }
        .ws-tier-card.active {
            border-color: #10B981;
            background: #F0FDF4;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.10);
        }
        .ws-tier-card-left {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }
        .ws-tier-icon-wrap {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .ws-tier-icon-wrap.green { background: #DCFCE7; border: 1px solid rgba(22, 163, 74, 0.3); }
        .ws-tier-icon-wrap.silver { background: #F1F5F9; border: 1px solid rgba(148, 163, 184, 0.35); }
        .ws-tier-icon-wrap.gold { background: #FEF3C7; border: 1px solid rgba(217, 119, 6, 0.35); }
        .ws-tier-icon-wrap.diamond { background: #E0F2FE; border: 1.5px solid rgba(2, 132, 199, 0.4); }
        .ws-tier-icon-wrap.supergold { background: #FEF3C7; border: 1.5px solid rgba(212, 175, 55, 0.5); }
        .ws-tier-icon-wrap.platinum { background: linear-gradient(135deg, #1C1813, #2B2317); border: 1.5px solid #D4AF37; }

        .ws-tier-info strong {
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--ws-text-main);
            display: block;
            line-height: 1.25;
            margin-bottom: 2px;
        }
        .ws-tier-card.active .ws-tier-info strong {
            color: #15803D;
        }
        .ws-tier-info span {
            font-size: 0.68rem;
            color: var(--ws-text-muted);
            display: block;
            line-height: 1.2;
        }
        .ws-tier-badge {
            font-size: 0.60rem;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 4px;
            white-space: nowrap;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }
        .ws-tier-badge.active { background: #DCFCE7; color: #15803D; border: 1px solid rgba(22, 163, 74, 0.3); }
        .ws-tier-badge.silver { background: #F1F5F9; color: #475569; border: 1px solid #CBD5E1; }
        .ws-tier-badge.gold { background: #FEF3C7; color: #B45309; border: 1px solid #FCD34D; }
        .ws-tier-badge.diamond { background: #E0F2FE; color: #0369A1; border: 1px solid #7DD3FC; }
        .ws-tier-badge.supergold { background: #FEF3C7; color: #92400E; border: 1px solid #F59E0B; }
        .ws-tier-badge.platinum { background: linear-gradient(135deg, #8A681F, #6E5114); color: #FFFFFF; }

        @media (max-width: 640px) {
            #wsVipTierModal.ws-modal-overlay {
                padding: 0 !important;
                align-items: stretch !important;
            }
            #wsVipTierModal .ws-modal-box {
                width: 100vw !important;
                max-width: 100vw !important;
                height: 100vh !important;
                max-height: 100vh !important;
                border-radius: 0 !important;
                border: none !important;
                margin: 0 !important;
                display: flex !important;
                flex-direction: column !important;
            }
            #wsVipTierModal .ws-modal-header {
                padding: 8px 12px !important;
                border-bottom: 1.5px solid var(--ws-gold-border) !important;
            }
            #wsVipTierModal .ws-modal-body {
                flex: 1 1 auto !important;
                overflow-y: auto !important;
                -webkit-overflow-scrolling: touch;
                padding: 10px 12px !important;
            }
            #wsVipTierModal .ws-tier-card {
                padding: 8px 10px !important;
                gap: 8px !important;
            }
            #wsVipTierModal .ws-tier-icon-wrap {
                width: 30px !important;
                height: 30px !important;
            }
            #wsVipTierModal .ws-tier-icon-wrap svg {
                width: 15px !important;
                height: 15px !important;
            }
            #wsVipTierModal .ws-tier-info strong {
                font-size: 0.74rem !important;
            }
            #wsVipTierModal .ws-tier-info span {
                font-size: 0.60rem !important;
            }
            #wsVipTierModal .ws-tier-badge {
                font-size: 0.52rem !important;
                padding: 2px 6px !important;
            }
            #wsVipTierModal .ws-modal-footer {
                padding: 8px 12px calc(8px + env(safe-area-inset-bottom)) !important;
            }
        }

        /* ── Printable PDF Bill Styling ── */
        .ws-invoice-sheet {
            background: #FFFFFF;
            border: 1px solid var(--ws-border);
            border-radius: 10px;
            padding: 24px;
            color: var(--ws-text-main);
        }
        .ws-inv-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            border-bottom: 2px solid var(--ws-gold-primary);
            padding-bottom: 16px;
            margin-bottom: 18px;
        }
        .ws-inv-brand h2 {
            font-size: 1.35rem;
            color: var(--ws-gold-primary);
            font-family: var(--ws-font-serif);
            font-weight: 800;
        }
        .ws-inv-brand p {
            font-size: 0.76rem;
            color: var(--ws-text-muted);
            line-height: 1.35;
        }
        .ws-inv-meta {
            text-align: right;
            font-size: 0.78rem;
            line-height: 1.45;
        }
        .ws-inv-parties {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            background: var(--ws-gold-light);
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 0.80rem;
        }
        .ws-inv-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.80rem;
            margin-bottom: 18px;
        }
        .ws-inv-table th {
            background: var(--ws-gold-primary);
            color: #FFFFFF;
            padding: 10px 12px;
            text-align: left;
            font-size: 0.76rem;
        }
        .ws-inv-table td {
            padding: 10px 12px;
            border-bottom: 1px solid var(--ws-border);
        }
        .ws-inv-totals {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 6px;
            font-size: 0.82rem;
            border-top: 2px solid var(--ws-gold-primary);
            padding-top: 12px;
        }
        .ws-inv-grand-total {
            font-size: 1.18rem;
            font-weight: 900;
            color: var(--ws-gold-primary);
        }

        /* ── Role Access Gate Modal ── */
        .ws-gate-box {
            text-align: center;
            padding: 26px 20px;
        }
        .ws-gate-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: var(--ws-gold-light);
            color: var(--ws-gold-primary);
            border: 2px solid var(--ws-gold-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: 0 4px 14px rgba(138,104,31,0.25);
        }
        .ws-gate-icon svg {
            width: 32px;
            height: 32px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }
        .ws-gate-box h3 {
            font-size: 1.2rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
            font-family: var(--ws-font-serif);
            margin-bottom: 8px;
        }
        .ws-gate-box p {
            font-size: 0.84rem;
            color: var(--ws-text-muted);
            margin-bottom: 20px;
            line-height: 1.5;
        }

        /* ── Mobile Floating Bottom App Dock ── */
        .ws-mobile-dock {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #FFFFFF;
            border-top: 1px solid var(--ws-gold-border);
            padding: 3px 6px calc(3px + env(safe-area-inset-bottom));
            z-index: 1500;
            box-shadow: 0 -2px 10px rgba(138,104,31,0.06);
            justify-content: space-around;
            align-items: center;
            height: auto;
            min-height: 46px;
        }
        .ws-dock-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5px;
            color: var(--ws-text-muted);
            font-size: 0.58rem;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            padding: 2px 6px;
            border-radius: 6px;
            border: none;
            background: transparent;
            transition: var(--ws-transition);
        }
        .ws-dock-btn svg {
            width: 17px;
            height: 17px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }
        .ws-dock-btn.active {
            color: var(--ws-gold-primary);
            transform: translateY(-1px);
        }
        .ws-dock-btn.active svg { stroke: var(--ws-gold-primary); }

        .ws-dock-cart-badge {
            position: absolute;
            top: -5px;
            right: -8px;
            min-width: 15px;
            height: 15px;
            padding: 0 3px;
            border-radius: 8px;
            background: var(--ws-gold-primary);
            color: #FFFFFF;
            font-size: 0.54rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.2px solid #FFFFFF;
            box-shadow: 0 2px 4px rgba(138,104,31,0.25);
        }

        /* ── Toast Container ── */
        .ws-toast-container {
            position: fixed;
            bottom: 72px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 3000000;
            display: flex;
            flex-direction: column;
            gap: 8px;
            pointer-events: none;
            width: 90%;
            max-width: 380px;
        }
        .ws-toast {
            background: #14110E;
            color: #FAF5E8;
            padding: 10px 18px;
            border-radius: 30px;
            font-size: 0.80rem;
            font-weight: 700;
            box-shadow: 0 8px 24px rgba(0,0,0,0.25);
            border: 1px solid var(--ws-gold-accent);
            display: flex;
            align-items: center;
            gap: 10px;
            animation: toastPop 0.28s ease;
            justify-content: center;
        }
        @keyframes toastPop {
            from { opacity: 0; transform: translateY(12px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ════════════════════════════════════════════════════
           RESPONSIVE MOBILE BREAKPOINTS & IMPROVEMENTS
        ════════════════════════════════════════════════════ */
        @media (max-width: 1024px) {
            .ws-analytics-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            .ws-stats-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .ws-sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                height: 100vh;
                max-height: 100vh;
                width: clamp(270px, 80vw, 320px);
                background: #FFFFFF;
                transform: translateX(-100%);
                box-shadow: 8px 0 35px rgba(20, 17, 14, 0.35);
                z-index: 2000;
                display: flex;
                flex-direction: column;
                overflow: hidden;
            }
            .ws-sidebar.open {
                transform: translateX(0);
            }
            .ws-sidebar-close-btn {
                display: flex;
            }
            .ws-sidebar-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(20, 17, 14, 0.65);
                backdrop-filter: blur(5px);
                -webkit-backdrop-filter: blur(5px);
                z-index: 1999;
                display: none;
            }
            .ws-sidebar-backdrop.active {
                display: block;
            }
            .ws-sidebar-scroll {
                padding-bottom: calc(60px + env(safe-area-inset-bottom));
            }
            .ws-mobile-dock {
                display: flex;
            }
            .ws-cmd-search-wrap {
                display: none;
            }
            #headerWishlistBtn,
            #headerCartBtn {
                display: none !important;
            }
        }

        @media (max-width: 768px) {
            .ws-header {
                padding: 0 10px;
                height: 48px;
            }
            .ws-menu-toggle-btn {
                width: 32px;
                height: 32px;
            }
            .ws-menu-toggle-btn svg {
                width: 16px;
                height: 16px;
            }
            .ws-mobile-header-brand {
                display: flex;
                align-items: center;
                margin-left: 6px;
            }
            .ws-mob-logo-text {
                font-size: 0.86rem;
            }
            #headerWishlistBtn,
            #headerCartBtn {
                display: none !important;
            }
            .ws-hdr-icon-btn {
                width: 32px;
                height: 32px;
            }
            .ws-hdr-icon-btn svg {
                width: 15px;
                height: 15px;
            }
            .ws-user-name-text {
                display: none;
            }
            .ws-user-profile-btn {
                padding: 2px;
                border-radius: 50%;
            }
            .ws-user-avatar-img {
                width: 28px;
                height: 28px;
            }
            .ws-main-content {
                padding: 10px 8px calc(52px + env(safe-area-inset-bottom));
            }
            .ws-section-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            .ws-sec-actions-row {
                width: 100%;
                flex-direction: column;
                gap: 8px;
            }
            .ws-segmented-control {
                width: 100%;
                display: flex;
            }
            .ws-segmented-control .ws-seg-btn {
                flex: 1;
                text-align: center;
                padding: 7px 8px;
                font-size: 0.74rem;
            }
            .ws-date-range-pill {
                width: 100%;
                justify-content: center;
                padding: 7px 12px;
            }
            .ws-metric-cards-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 8px !important;
                margin-bottom: 10px !important;
            }
            .ws-stat-box {
                padding: 7px 9px !important;
                border-radius: 10px !important;
                min-height: 64px !important;
                height: 64px !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: space-between !important;
                box-sizing: border-box !important;
            }
            .ws-stat-head-row {
                margin-bottom: 0 !important;
                gap: 3px !important;
            }
            .ws-stat-label {
                font-size: 0.54rem !important;
                font-weight: 800 !important;
                letter-spacing: 0.2px !important;
                line-height: 1 !important;
            }
            .ws-stat-ico-wrap {
                width: 20px !important;
                height: 20px !important;
                border-radius: 5px !important;
            }
            .ws-stat-ico-wrap svg {
                width: 11px !important;
                height: 11px !important;
            }
            .ws-stat-val-row {
                gap: 4px !important;
                align-items: baseline !important;
            }
            .ws-stat-val-num {
                font-size: 0.98rem !important;
                font-weight: 900 !important;
                line-height: 1 !important;
            }
            #statVal1 {
                font-size: 0.78rem !important;
            }
            .ws-trend-pill {
                font-size: 0.48rem !important;
                font-weight: 800 !important;
                padding: 1.5px 4px !important;
                border-radius: 4px !important;
            }
            .ws-tier-ribbon-tag {
                width: 40px !important;
                height: 40px !important;
                border-top-left-radius: 10px !important;
                border-top-right-radius: 0 !important;
            }
            .ws-tier-ribbon-tag span {
                width: 58px !important;
                font-size: 0.34rem !important;
                padding: 1px 0 !important;
                left: -16px !important;
                right: auto !important;
                top: 7px !important;
                transform: rotate(-45deg) !important;
            }
            .ws-roadmap-link-text {
                font-size: 0.50rem !important;
            }
            .ws-roadmap-running-line {
                height: 1.5px !important;
            }
            .ws-wallet-strip {
                padding: 6px 10px !important;
                margin-bottom: 10px !important;
                border-radius: 10px !important;
                min-height: 44px !important;
                gap: 6px !important;
            }
            .ws-wallet-icon-wrapper {
                width: 26px !important;
                height: 26px !important;
                border-radius: 7px !important;
            }
            .ws-anim-wallet-svg, .ws-anim-coin-svg {
                width: 15px !important;
                height: 15px !important;
            }
            .ws-wallet-metric-value {
                font-size: 0.88rem !important;
            }
            .ws-wallet-metric-label {
                font-size: 0.50rem !important;
            }
            .ws-btn-wallet-view-sm {
                height: 26px !important;
                font-size: 0.65rem !important;
                padding: 0 8px !important;
            }
            .ws-stats-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }
            .ws-kpi-grid {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }
            .ws-kpi-box {
                padding: 10px;
            }
            .ws-kpi-label {
                font-size: 0.65rem;
            }
            .ws-kpi-num {
                font-size: 0.96rem;
            }
            .ws-kpi-sub {
                font-size: 0.62rem;
            }
            .ws-cat-prog-header {
                font-size: 0.74rem;
            }
            .ws-table-container {
                display: none;
            }
            .ws-mobile-order-cards,
            .ws-mobile-reports-cards {
                display: flex !important;
                flex-direction: column;
                gap: 10px;
            }
            .ws-report-kpis-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 8px;
            }
            .ws-filter-controls-row {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 10px !important;
            }
            .ws-filter-controls-row .ws-luxury-search-wrap,
            .ws-luxury-search-wrap {
                width: 100% !important;
                max-width: 100% !important;
                margin-top: 4px;
                flex: none !important;
            }
            .ws-filter-controls-row .ws-orders-filter-btns,
            .ws-filter-controls-row .ws-filter-pill-group,
            .ws-orders-filter-btns,
            .ws-filter-pill-group {
                width: 100% !important;
                display: flex !important;
                overflow-x: auto !important;
                -webkit-overflow-scrolling: touch !important;
                padding-bottom: 4px !important;
                scrollbar-width: none !important;
                flex-wrap: nowrap !important;
                gap: 8px !important;
            }
            .ws-filter-controls-row .ws-orders-filter-btns::-webkit-scrollbar,
            .ws-filter-controls-row .ws-filter-pill-group::-webkit-scrollbar,
            .ws-orders-filter-btns::-webkit-scrollbar,
            .ws-filter-pill-group::-webkit-scrollbar {
                display: none !important;
            }
            .ws-luxury-search-input {
                height: 30px !important;
                font-size: 0.73rem !important;
                padding: 0 50px 0 10px !important;
            }
            .ws-luxury-search-icon {
                width: 20px !important;
                height: 20px !important;
                right: 3px !important;
                padding: 4px !important;
            }
            .ws-luxury-search-clear {
                width: 15px !important;
                height: 15px !important;
                right: 27px !important;
                font-size: 0.55rem !important;
            }
            .ws-rep-filter-btn {
                white-space: nowrap !important;
                flex-shrink: 0 !important;
                display: inline-flex !important;
                padding: 4px 10px !important;
                font-size: 0.70rem !important;
                height: 26px !important;
            }
            .ws-mob-order-card {
                padding: 12px;
                border-radius: 12px;
            }
            .ws-mob-order-actions {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }
            .ws-mob-order-actions .ws-btn {
                width: 100%;
                justify-content: center;
                padding: 7px 8px;
                font-size: 0.72rem;
            }
            .ws-slider-nav-btn {
                display: none;
            }
            .ws-slider-track {
                gap: 8px !important;
                padding: 4px 2px 10px !important;
            }
            .ws-slider-track .product-card,
            .ws-slider-track .ws-product-card {
                flex: 0 0 calc((100% - 16px) / 2.38) !important;
                min-width: 125px !important;
                max-width: 160px !important;
                border-radius: 10px !important;
            }
            .ws-slider-track .card-name,
            .ws-slider-track .ws-prod-name {
                font-size: 0.72rem !important;
                line-height: 1.2 !important;
            }
            .ws-slider-track .card-price,
            .ws-slider-track .ws-prod-price {
                font-size: 0.82rem !important;
            }
            .ws-slider-track .card-old-price {
                font-size: 0.60rem !important;
            }
            .ws-slider-track .card-price-discount {
                font-size: 0.50rem !important;
                padding: 1px 3.5px !important;
            }
            .ws-slider-track .card-info-text-row {
                font-size: 0.56rem !important;
                gap: 3px !important;
            }
            .ws-slider-track .card-body {
                padding: 7px !important;
                gap: 2px !important;
            }
            .products-grid, .ws-master-catalog-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 10px !important;
            }
            .ws-gst-selector-grid {
                grid-template-columns: 1fr;
            }
            .ws-gauge-stats-row {
                gap: 4px;
            }
            .ws-g-stat-label {
                font-size: 0.64rem;
            }
            .ws-g-stat-val {
                font-size: 0.85rem;
            }

            /* Slide-Up Bottom Sheet on Mobile */
            .ws-modal-overlay {
                padding: 0;
                align-items: flex-end;
            }
            .ws-modal-box {
                max-height: 90vh;
                border-radius: 20px 20px 0 0;
                border-bottom: none;
            }
            .ws-modal-footer {
                padding: 10px 16px calc(12px + env(safe-area-inset-bottom));
                flex-direction: column;
                gap: 8px;
            }
            .ws-modal-footer .ws-btn {
                width: 100%;
                padding: 10px 14px;
            }
        }

        @media (max-width: 380px) {
            .ws-metric-cards-grid {
                grid-template-columns: 1fr;
            }
            .ws-slider-track .product-card,
            .ws-slider-track .ws-product-card {
                flex: 0 0 calc((100% - 14px) / 2.3) !important;
                min-width: 115px !important;
                max-width: none;
            }
            .products-grid, .ws-master-catalog-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
</head>
<body>

    <!-- ═══ Mobile Sidebar Backdrop ═══ -->
    <div class="ws-sidebar-backdrop" id="wsSidebarBackdrop" onclick="toggleSidebar(false)"></div>

    <!-- ═══ Modern Clean Top Header (TailAdmin Style with Gold Brand Theme) ═══ -->
    <header class="ws-header">
        <div class="ws-header-left">
            <button class="ws-menu-toggle-btn" id="wsMenuToggleBtn" onclick="toggleSidebar()" aria-label="Toggle Menu">
                <svg viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>

            <!-- Mobile Brand Title (Center/Left) -->
            <div class="ws-mobile-header-brand">
                <span class="ws-mob-logo-text">KALANIKETAN B2B</span>
            </div>
        </div>

        <div class="ws-header-right">
            <!-- Wishlist Button -->
            <button class="ws-hdr-icon-btn" id="headerWishlistBtn" title="Wholesale Wishlist" onclick="if(typeof window.openWishlistDrawer==='function') window.openWishlistDrawer(); else window.location.href='wishlist.php';" aria-label="Wholesale Wishlist">
                <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                <span class="ws-hdr-badge" id="headerWishlistBadge" style="display:none;">0</span>
            </button>

            <!-- Cart Button -->
            <button class="ws-hdr-icon-btn" id="headerCartBtn" title="Wholesale Cart" onclick="if(typeof window.openCartDrawer==='function') window.openCartDrawer(); else window.location.href='cart.php';" aria-label="Wholesale Cart">
                <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                <span class="ws-hdr-badge gold" id="headerCartBadge" style="display:none;">0</span>
            </button>

            <!-- Notifications Bell -->
            <button class="ws-hdr-icon-btn" title="Notifications" onclick="window.showWsToast('2 new consignment dispatches in transit')">
                <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                <span class="ws-notif-dot"></span>
            </button>

            <!-- User Profile Pill -->
            <div class="ws-user-profile-btn" onclick="switchWsTab('details')" title="Wholesaler Profile">
                <img src="images/profile.png" onerror="this.src='images/product1.png';" alt="User" class="ws-user-avatar-img" id="headerUserAvatar">
                <div class="ws-user-name-text">
                    <span id="headerUserName">Rajesh Kumar</span>
                    <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </div>
            </div>
        </div>
    </header>

    <!-- ═══ Main App Layout Grid ═══ -->
    <div class="ws-app-layout">
        
        <!-- ── Left Sidebar Navigation (TailAdmin Style with Gold Theme) ── -->
        <aside class="ws-sidebar" id="wsSidebar">
            <div class="ws-sidebar-brand-box">
                <div class="ws-side-logo-icon">K</div>
                <div class="ws-side-brand-title">KALANIKETAN</div>
                <button class="ws-sidebar-close-btn" onclick="toggleSidebar(false)" aria-label="Close Menu">✕</button>
            </div>

            <div class="ws-sidebar-scroll">
                <!-- VIP Wholesaler User Card in Sidebar -->
                <div class="ws-side-user-card" onclick="switchWsTab('details'); toggleSidebar(false);" style="margin: 8px 8px 4px; padding: 7px 9px; background: linear-gradient(135deg, #FAF5E8 0%, #FFFFFF 100%); border: 1.2px solid rgba(212,175,55,0.35); border-radius: 9px; display: flex; align-items: center; gap: 8px; cursor: pointer; box-shadow: 0 2px 6px rgba(138,104,31,0.06);">
                    <img src="images/profile.png" onerror="this.src='images/product1.png';" alt="User" style="width: 28px; height: 28px; border-radius: 50%; border: 1.5px solid var(--ws-gold-primary); object-fit: cover; flex-shrink: 0;">
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-size: 0.76rem; font-weight: 800; color: #1C1917; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" id="sideUserName">Rajesh Kumar</div>
                        <div style="font-size: 0.60rem; font-weight: 700; color: #8A681F; display: flex; align-items: center; gap: 2px;">
                            <span>★ Verified Wholesaler</span>
                        </div>
                    </div>
                    <span style="font-size: 0.58rem; font-weight: 800; background: #DCFCE7; color: #15803D; padding: 2px 5px; border-radius: 6px; border: 1px solid #BBF7D0; flex-shrink: 0;">Tier 1</span>
                </div>

                <div class="ws-nav-category">MENU</div>
                <ul class="ws-nav-list">
                    <li>
                        <a class="ws-nav-item active" onclick="switchWsTab('overview')">
                            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a class="ws-nav-item" onclick="switchWsTab('orders')">
                            <svg viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            <span>Orders</span>
                            <span class="ws-nav-badge" id="navOrdersCount">6</span>
                        </a>
                    </li>
                    <li>
                        <a class="ws-nav-item" onclick="switchWsTab('reports')">
                            <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                            <span>Reports</span>
                            <span class="ws-nav-badge gold">NEW</span>
                        </a>
                    </li>
                    <li>
                        <a class="ws-nav-item" onclick="switchWsTab('trending')">
                            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            <span>Catalog</span>
                        </a>
                    </li>
                    <li>
                        <a class="ws-nav-item" onclick="switchWsTab('tracking')">
                            <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                            <span>Live Tracking</span>
                        </a>
                    </li>
                    <li>
                        <a class="ws-nav-item" onclick="switchWsTab('support')">
                            <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            <span>Support Desk</span>
                        </a>
                    </li>
                </ul>

                <div class="ws-nav-category">SETTINGS</div>
                <ul class="ws-nav-list">
                    <li>
                        <a class="ws-nav-item" onclick="switchWsTab('details')">
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="ws-nav-item" onclick="switchWsTab('gst')">
                            <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                            <span>GST Profile</span>
                        </a>
                    </li>
                    <li>
                        <a class="ws-nav-item" onclick="switchWsTab('address')">
                            <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            <span>Address Book</span>
                        </a>
                    </li>
                </ul>

                <div class="ws-sidebar-footer">
                    <button class="ws-logout-btn" onclick="handleWholesalerLogout()">
                        <svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2.2;" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <span>Sign Out</span>
                    </button>
                </div>
            </div>
        </aside>

        <!-- ── Main Content Container ── -->
        <main class="ws-main-content">

            <!-- ═══════════════════════════════════════
                 TAB 1: OVERVIEW DASHBOARD (TAILADMIN SIZES WITH HERITAGE GOLD)
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane active" id="tabPaneOverview">
                
                <!-- Top 4 Primary Metric Stat Cards (3D Frosted Glass Palette with Animated SVGs) -->
                <div class="ws-metric-cards-grid">
                    
                    <!-- Metric Card 1: Account Tier (Interactive VIP Tier Roadmap Modal Trigger) -->
                    <div class="ws-stat-box" onclick="openVipTierModal()" style="cursor:pointer; position:relative;" title="Tap to view VIP Tier Roadmap">
                        <!-- Left Corner 3D Diagonal Tircha Tag -->
                        <div class="ws-tier-ribbon-tag non-vip" id="wsTierRibbonTag">
                            <span id="wsTierRibbonText">★ NON VIP</span>
                        </div>

                        <div class="ws-stat-head-row" style="padding-left:14px;">
                            <div class="ws-stat-label" id="statLabel1">B2B Account Tier</div>
                            <div class="ws-stat-ico-wrap tier">
                                <svg class="ws-anim-stat-ico crown" viewBox="0 0 24 24" width="18" height="18" fill="none"><path d="M2 4l3 12h14l3-12-6 7-4-7-4 7-6-7z" fill="#D4AF37" stroke="#92400E" stroke-width="1.2" stroke-linejoin="round"></path><circle cx="12" cy="3" r="1.5" fill="#F59E0B"></circle><circle cx="4" cy="4" r="1.2" fill="#F59E0B"></circle><circle cx="20" cy="4" r="1.2" fill="#F59E0B"></circle></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val-row">
                            <div class="ws-stat-val-num" id="statVal1" style="color:var(--ws-gold-primary); font-family:var(--ws-font-serif);">Tier 1</div>
                            <div style="display:flex; align-items:center; gap:5px;">
                                <div class="ws-roadmap-link-wrap" onclick="event.stopPropagation(); openVipTierModal();" title="View VIP Roadmap">
                                    <span class="ws-roadmap-link-text">Roadmap ›</span>
                                    <div class="ws-roadmap-running-line"></div>
                                </div>
                                <span class="ws-trend-pill up" id="statPill1">1–50 Orders</span>
                            </div>
                        </div>
                    </div>

                    <!-- Metric Card 2: Orders -->
                    <div class="ws-stat-box">
                        <div class="ws-stat-head-row">
                            <div class="ws-stat-label" id="statLabel2">Total Orders</div>
                            <div class="ws-stat-ico-wrap orders">
                                <svg class="ws-anim-stat-ico box" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#2563EB" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val-row">
                            <div class="ws-stat-val-num" id="statVal2">6</div>
                            <span class="ws-trend-pill up" id="statPill2">↑ 14.20%</span>
                        </div>
                    </div>

                    <!-- Metric Card 3: Total Quantity -->
                    <div class="ws-stat-box">
                        <div class="ws-stat-head-row">
                            <div class="ws-stat-label" id="statLabel3">Total Quantity (Units)</div>
                            <div class="ws-stat-ico-wrap qty">
                                <svg class="ws-anim-stat-ico stack" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val-row">
                            <div class="ws-stat-val-num" id="statVal3">48 <span style="font-size:0.85rem; font-weight:700; color:var(--ws-text-muted);">Pcs</span></div>
                            <span class="ws-trend-pill up" id="statPill3">↑ 8.50%</span>
                        </div>
                    </div>

                    <!-- Metric Card 4: Total Revenue Turnover -->
                    <div class="ws-stat-box">
                        <div class="ws-stat-head-row">
                            <div class="ws-stat-label" id="statLabel4">Total B2B Turnover</div>
                            <div class="ws-stat-ico-wrap turnover">
                                <svg class="ws-anim-stat-ico turnover" viewBox="0 0 24 24" width="18" height="18" fill="none"><circle cx="12" cy="12" r="9" fill="#F59E0B" fill-opacity="0.2" stroke="#D97706" stroke-width="1.5"></circle><path d="M10 8h4M10 11h3.5M10 8v8M12.5 11c1.4 0 1.8 1 1.8 1.8s-.4 1.8-1.8 1.8h-2.5" stroke="#78350F" stroke-width="1.4" stroke-linecap="round"></path></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val-row">
                            <div class="ws-stat-val-num" id="statVal4" style="color:var(--ws-gold-primary);">₹2,05,062</div>
                            <span class="ws-trend-pill up" id="statPill4">↑ 18.40%</span>
                        </div>
                    </div>

                </div>

                <!-- ── Modern Frosted Gold Glassy Animated B2B Wallet & Coins Strip ── -->
                <div class="ws-wallet-strip">
                    <!-- Left Corner Micro 3D Diagonal Tircha Tag -->
                    <div class="ws-wallet-ribbon-tag">
                        <span>★ WALLET</span>
                    </div>

                    <!-- Left: Total Balance & Total Coins Metrics (Frosted Gold Glass Styling) -->
                    <div class="ws-wallet-metrics-group">
                        <!-- Metric 1: Total Balance -->
                        <div class="ws-wallet-metric-item">
                            <div class="ws-wallet-icon-wrapper">
                                <svg class="ws-anim-wallet-svg" viewBox="0 0 28 28" fill="none">
                                    <defs>
                                        <linearGradient id="wsGoldLeather" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#D4AF37"/>
                                            <stop offset="60%" stop-color="#AA8222"/>
                                            <stop offset="100%" stop-color="#785912"/>
                                        </linearGradient>
                                        <linearGradient id="wsGoldCoinShine" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#FFFBEB"/>
                                            <stop offset="50%" stop-color="#FCD34D"/>
                                            <stop offset="100%" stop-color="#D97706"/>
                                        </linearGradient>
                                    </defs>
                                    <!-- Money Bills peeking from top -->
                                    <path d="M7 6V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v2" stroke="#10B981" stroke-width="1.8" fill="rgba(16,185,129,0.2)" stroke-linecap="round"/>
                                    <path d="M9 4.5h8" stroke="#10B981" stroke-width="1.2" stroke-linecap="round"/>
                                    <!-- Wallet main body -->
                                    <rect x="3" y="6" width="22" height="17" rx="3.5" fill="url(#wsGoldLeather)" stroke="#8A681F" stroke-width="1.2"/>
                                    <!-- Wallet inner fold line -->
                                    <path d="M3 10.5h22" stroke="rgba(255,255,255,0.35)" stroke-width="1"/>
                                    <!-- Wallet side clasp / flap -->
                                    <path d="M16 11.5h6.5a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5H16a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2z" fill="#785912" stroke="#D4AF37" stroke-width="1.2"/>
                                    <!-- Golden clasp coin button -->
                                    <circle cx="20.5" cy="14.5" r="1.6" fill="url(#wsGoldCoinShine)" stroke="#FFFFFF" stroke-width="0.8"/>
                                </svg>
                            </div>
                            <div class="ws-wallet-metric-content">
                                <span class="ws-wallet-metric-label">Total Balance</span>
                                <span class="ws-wallet-metric-value" id="walletAvailableBalance">₹1,45,280</span>
                            </div>
                        </div>

                        <!-- Metric 2: Total Coins -->
                        <div class="ws-wallet-metric-item">
                            <div class="ws-wallet-icon-wrapper coin">
                                <svg class="ws-anim-coin-svg" viewBox="0 0 28 28" fill="none">
                                    <defs>
                                        <linearGradient id="wsCoinGradDirect" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#FFFBEB"/>
                                            <stop offset="50%" stop-color="#FCD34D"/>
                                            <stop offset="100%" stop-color="#D97706"/>
                                        </linearGradient>
                                    </defs>
                                    <!-- Outer Golden Coin Ring -->
                                    <circle cx="14" cy="14" r="11" fill="url(#wsCoinGradDirect)" stroke="#8A681F" stroke-width="1.4"/>
                                    <!-- Inner Star/Coin Ring Pattern -->
                                    <circle cx="14" cy="14" r="8.5" stroke="#FFFFFF" stroke-opacity="0.85" stroke-dasharray="2 1.5" stroke-width="1"/>
                                    <!-- Centered Rupee / Silk Emblem -->
                                    <path d="M11 10h6M11 13h5M11 10v7M14 13c1.8 0 2.4 1.4 2.4 2.4s-.8 2-2.4 2h-3" stroke="#78350F" stroke-width="1.6" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <div class="ws-wallet-metric-content">
                                <span class="ws-wallet-metric-label">Total Coins</span>
                                <span class="ws-wallet-metric-value gold" id="walletTotalCoins">3,850</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Small Styled View Button -->
                    <div class="ws-wallet-strip-actions">
                        <button class="ws-btn ws-btn-wallet-view-sm" onclick="openFullWalletModal()">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            <span>View</span>
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    </div>
                </div>

                <!-- Middle Analytics Grid (Monthly Sales Bar Chart + Target Gauge) -->
                <div class="ws-analytics-grid">
                    
                    <!-- Left: Monthly Sales Zigzag Line & Spline Area Chart (Luxury Style) -->
                    <div class="ws-analytics-card">
                        <div class="ws-card-top-bar" style="margin-bottom: 12px;">
                            <div>
                                <h3 id="chartTitle" style="margin:0; font-family:var(--ws-font-serif); font-size:1.02rem; color:var(--ws-gold-primary); font-weight:800;">Monthly Sales Trend</h3>
                                <p style="font-size:0.72rem; color:var(--ws-text-muted); margin-top:2px;" id="chartSubtitle">Consignment units & wholesale turnover</p>
                            </div>
                            <div class="ws-chart-type-pill">
                                <button class="ws-chart-type-btn active" id="btnChartZigzag" onclick="switchSalesChartStyle('zigzag', this)">Zigzag</button>
                                <button class="ws-chart-type-btn" id="btnChartSmooth" onclick="switchSalesChartStyle('smooth', this)">Smooth</button>
                            </div>
                        </div>

                        <!-- Live Tooltip Display -->
                        <div class="ws-chart-tooltip" id="chartLiveTooltip">
                            <span class="ws-chart-tooltip-dot"></span>
                            <span id="chartTooltipText">Aug (Current): ₹2,05,062 • 48 Pcs (↑18.4%)</span>
                        </div>

                        <div class="ws-chart-wrapper" id="salesChartMainWrapper">
                            <div class="ws-chart-svg-container">
                                <!-- Y Axis Labels -->
                                <div class="ws-chart-y-axis">
                                    <span>400k</span>
                                    <span>300k</span>
                                    <span>200k</span>
                                    <span>100k</span>
                                    <span>0k</span>
                                </div>

                                <svg class="ws-chart-svg" viewBox="0 0 600 170" preserveAspectRatio="none" style="padding-left: 34px;">
                                    <defs>
                                        <!-- Gold Gradient for the Line -->
                                        <linearGradient id="wsGoldLineGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                            <stop offset="0%" stop-color="#8A681F" />
                                            <stop offset="35%" stop-color="#C5A859" />
                                            <stop offset="70%" stop-color="#D4AF37" />
                                            <stop offset="100%" stop-color="#6F5218" />
                                        </linearGradient>

                                        <!-- Translucent Gold Area Fill Gradient -->
                                        <linearGradient id="wsGoldAreaGrad" x1="0%" y1="0%" x2="0%" y2="100%">
                                            <stop offset="0%" stop-color="#C5A859" stop-opacity="0.45" />
                                            <stop offset="60%" stop-color="#8A681F" stop-opacity="0.15" />
                                            <stop offset="100%" stop-color="#8A681F" stop-opacity="0.01" />
                                        </linearGradient>
                                    </defs>

                                    <!-- Horizontal Dashed Grid Lines (Clean 400k to 0k Range) -->
                                    <line class="ws-chart-gridline" x1="0" y1="20" x2="600" y2="20" />
                                    <line class="ws-chart-gridline" x1="0" y1="55" x2="600" y2="55" />
                                    <line class="ws-chart-gridline" x1="0" y1="90" x2="600" y2="90" />
                                    <line class="ws-chart-gridline" x1="0" y1="125" x2="600" y2="125" />
                                    <line class="ws-chart-gridline" x1="0" y1="158" x2="600" y2="158" />

                                    <!-- Zigzag Area Gradient Fill -->
                                    <path class="ws-chart-zigzag-area" id="svgAreaPath" 
                                          d="M 40,115 L 86,96 L 132,102 L 178,85 L 224,76 L 270,82 L 316,62 L 362,88 L 408,68 L 454,38 L 500,52 L 546,94 L 546,158 L 40,158 Z" />

                                    <!-- Zigzag Line Stroke -->
                                    <path class="ws-chart-zigzag-line" id="svgLinePath" 
                                          d="M 40,115 L 86,96 L 132,102 L 178,85 L 224,76 L 270,82 L 316,62 L 362,88 L 408,68 L 454,38 L 500,52 L 546,94" />

                                    <!-- 12 Month Interactive Nodes (Proportional Coordinates) -->
                                    <circle class="ws-chart-node" cx="40" cy="115" onmouseover="showChartNodeTooltip(0)" onclick="showChartNodeTooltip(0)" />
                                    <circle class="ws-chart-node" cx="86" cy="96" onmouseover="showChartNodeTooltip(1)" onclick="showChartNodeTooltip(1)" />
                                    <circle class="ws-chart-node" cx="132" cy="102" onmouseover="showChartNodeTooltip(2)" onclick="showChartNodeTooltip(2)" />
                                    <circle class="ws-chart-node" cx="178" cy="85" onmouseover="showChartNodeTooltip(3)" onclick="showChartNodeTooltip(3)" />
                                    <circle class="ws-chart-node" cx="224" cy="76" onmouseover="showChartNodeTooltip(4)" onclick="showChartNodeTooltip(4)" />
                                    <circle class="ws-chart-node" cx="270" cy="82" onmouseover="showChartNodeTooltip(5)" onclick="showChartNodeTooltip(5)" />
                                    <circle class="ws-chart-node" cx="316" cy="62" onmouseover="showChartNodeTooltip(6)" onclick="showChartNodeTooltip(6)" />
                                    <circle class="ws-chart-node active" cx="362" cy="88" onmouseover="showChartNodeTooltip(7)" onclick="showChartNodeTooltip(7)" />
                                    <circle class="ws-chart-node" cx="408" cy="68" onmouseover="showChartNodeTooltip(8)" onclick="showChartNodeTooltip(8)" />
                                    <circle class="ws-chart-node" cx="454" cy="38" onmouseover="showChartNodeTooltip(9)" onclick="showChartNodeTooltip(9)" />
                                    <circle class="ws-chart-node" cx="500" cy="52" onmouseover="showChartNodeTooltip(10)" onclick="showChartNodeTooltip(10)" />
                                    <circle class="ws-chart-node" cx="546" cy="94" onmouseover="showChartNodeTooltip(11)" onclick="showChartNodeTooltip(11)" />
                                </svg>
                            </div>

                            <!-- X Axis Month Labels -->
                            <div class="ws-chart-x-axis">
                                <span onmouseover="showChartNodeTooltip(0)" onclick="showChartNodeTooltip(0)">Jan</span>
                                <span onmouseover="showChartNodeTooltip(1)" onclick="showChartNodeTooltip(1)">Feb</span>
                                <span onmouseover="showChartNodeTooltip(2)" onclick="showChartNodeTooltip(2)">Mar</span>
                                <span onmouseover="showChartNodeTooltip(3)" onclick="showChartNodeTooltip(3)">Apr</span>
                                <span onmouseover="showChartNodeTooltip(4)" onclick="showChartNodeTooltip(4)">May</span>
                                <span onmouseover="showChartNodeTooltip(5)" onclick="showChartNodeTooltip(5)">Jun</span>
                                <span onmouseover="showChartNodeTooltip(6)" onclick="showChartNodeTooltip(6)">Jul</span>
                                <span class="active" onmouseover="showChartNodeTooltip(7)" onclick="showChartNodeTooltip(7)">Aug</span>
                                <span onmouseover="showChartNodeTooltip(8)" onclick="showChartNodeTooltip(8)">Sep</span>
                                <span onmouseover="showChartNodeTooltip(9)" onclick="showChartNodeTooltip(9)">Oct</span>
                                <span onmouseover="showChartNodeTooltip(10)" onclick="showChartNodeTooltip(10)">Nov</span>
                                <span onmouseover="showChartNodeTooltip(11)" onclick="showChartNodeTooltip(11)">Dec</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Semi-Circular Target Gauge (Royal Gold Arc & Animated Glow) -->
                    <div class="ws-analytics-card">
                        <div class="ws-card-top-bar" style="margin-bottom: 8px;">
                            <div>
                                <h3 style="margin:0; font-family:var(--ws-font-serif); font-size:1.02rem; color:var(--ws-gold-primary); font-weight:800;">Procurement Target</h3>
                                <p style="font-size:0.72rem; color:var(--ws-text-muted); margin-top:2px;">Monthly quota & milestone velocity</p>
                            </div>
                            <span class="ws-trend-pill up">75.5% Quota</span>
                        </div>

                        <div class="ws-gauge-wrap">
                            <svg class="ws-gauge-svg" viewBox="0 0 200 110">
                                <defs>
                                    <linearGradient id="goldGaugeGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" stop-color="#8A681F"/>
                                        <stop offset="35%" stop-color="#C5A859"/>
                                        <stop offset="70%" stop-color="#D4AF37"/>
                                        <stop offset="100%" stop-color="#FFE082"/>
                                    </linearGradient>
                                    <filter id="gaugeGlow" x="-20%" y="-20%" width="140%" height="140%">
                                        <feGaussianBlur stdDeviation="4" result="blur" />
                                        <feComposite in="SourceGraphic" in2="blur" operator="over" />
                                    </filter>
                                </defs>
                                <path class="ws-gauge-bg-arc" d="M 20 100 A 80 80 0 0 1 180 100"></path>
                                <path class="ws-gauge-fill-arc" id="targetGaugeFill" d="M 20 100 A 80 80 0 0 1 180 100" style="stroke-dashoffset: 58;"></path>
                                <!-- Glowing Leading Indicator Circle on Arc Tip -->
                                <circle cx="152" cy="43" r="6" fill="#FFE082" stroke="#8A681F" stroke-width="2.5" filter="url(#gaugeGlow)" />
                                <circle cx="152" cy="43" r="2.5" fill="#FFFFFF" />
                            </svg>
                            <div class="ws-gauge-center-text" id="targetGaugeVal">75.55%</div>
                            <div class="ws-gauge-badge" id="targetGaugeBadge">
                                <svg style="width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                                <span>+10.4% vs Target</span>
                            </div>
                            <p class="ws-gauge-desc" id="targetGaugeDesc">You achieved <strong>₹1,84,500</strong> this cycle. Just <strong>₹65,500</strong> left to complete Tier 1 VIP quota!</p>
                        </div>

                        <div class="ws-gauge-stats-row">
                            <div class="ws-gauge-stat-pill">
                                <div class="ws-g-stat-label">Target</div>
                                <div class="ws-g-stat-val" id="gStatTarget" style="color:var(--ws-danger);">₹2.50L</div>
                            </div>
                            <div class="ws-gauge-stat-pill">
                                <div class="ws-g-stat-label">Achieved</div>
                                <div class="ws-g-stat-val" id="gStatRevenue" style="color:var(--ws-success);">₹1.85L ↑</div>
                            </div>
                            <div class="ws-gauge-stat-pill">
                                <div class="ws-g-stat-label">Velocity</div>
                                <div class="ws-g-stat-val" id="gStatToday" style="color:var(--ws-gold-primary);">₹18.2K/d</div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ── Full Comprehensive Statistics & Analytics Card ── -->
                <div class="ws-statistics-card">
                    <div class="ws-section-header" style="margin-bottom:0;">
                        <div class="ws-sec-title-box">
                            <h3 id="statsMainTitle">Statistics & Performance Analytics</h3>
                            <p id="statsSubtitle">Monthly Procurement Targets, Category Mix & Logistics Performance</p>
                        </div>

                        <div class="ws-sec-actions-row">
                            <div class="ws-segmented-control">
                                <button class="ws-seg-btn active" id="statBtnOverview" onclick="setOverviewFilter('overview', this)">Overview</button>
                                <button class="ws-seg-btn" id="statBtnSales" onclick="setOverviewFilter('sales', this)">Sales</button>
                                <button class="ws-seg-btn" id="statBtnRevenue" onclick="setOverviewFilter('revenue', this)">Revenue</button>
                            </div>
                            <div class="ws-date-range-pill" id="dateRangeBtn" onclick="openDateRangePicker()">
                                <svg class="ws-ico gold" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <span id="selectedDateRangeLabel">Aug 10 - Aug 16</span>
                                <svg style="width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2;margin-left:2px;" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </div>
                        </div>
                    </div>

                    <!-- 3-Column Multi-Dimensional Analytics Grid -->
                    <div class="ws-stats-grid" id="statsDynamicContent">
                        
                        <!-- Column 1: Category Volume Mix & Target Fulfillment -->
                        <div>
                            <div class="ws-stats-col-title">
                                <span id="catBreakdownTitle"><svg class="ws-ico gold" style="margin-right:5px;" viewBox="0 0 24 24"><path d="M20.38 3.46L16 2 12 5.5 8 2l-4.38 1.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"></path></svg> Category Procurement Breakdown</span>
                            </div>
                            <div class="ws-cat-prog-list" id="catProgList">
                                <div class="ws-cat-prog-item">
                                    <div class="ws-cat-prog-header">
                                        <span class="ws-cat-prog-name">Pure Silk & Zari Sarees</span>
                                        <span class="ws-cat-prog-val">₹1,14,500 (56%)</span>
                                    </div>
                                    <div class="ws-cat-prog-track">
                                        <div class="ws-cat-prog-fill" style="--prog-w: 88%; animation-delay: 0.6s;"></div>
                                    </div>
                                </div>

                                <div class="ws-cat-prog-item">
                                    <div class="ws-cat-prog-header">
                                        <span class="ws-cat-prog-name">Bridal Velvet & Zardosi Lehengas</span>
                                        <span class="ws-cat-prog-val">₹49,147 (24%)</span>
                                    </div>
                                    <div class="ws-cat-prog-track">
                                        <div class="ws-cat-prog-fill" style="--prog-w: 72%; animation-delay: 0.75s;"></div>
                                    </div>
                                </div>

                                <div class="ws-cat-prog-item">
                                    <div class="ws-cat-prog-header">
                                        <span class="ws-cat-prog-name">Royal Anarkali Kurti Sets</span>
                                        <span class="ws-cat-prog-val">₹25,825 (13%)</span>
                                    </div>
                                    <div class="ws-cat-prog-track">
                                        <div class="ws-cat-prog-fill" style="width: 95%;"></div>
                                    </div>
                                </div>

                                <div class="ws-cat-prog-item">
                                    <div class="ws-cat-prog-header">
                                        <span class="ws-cat-prog-name">Georgette & Chanderi Fabrics</span>
                                        <span class="ws-cat-prog-val">₹15,590 (7%)</span>
                                    </div>
                                    <div class="ws-cat-prog-track">
                                        <div class="ws-cat-prog-fill" style="width: 60%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Column 2: Key Operational Metrics (KPIs) -->
                        <div>
                            <div class="ws-stats-col-title">
                                <span><svg class="ws-ico gold" style="margin-right:5px;" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> Key Wholesale Performance (KPIs)</span>
                            </div>
                            <div class="ws-kpi-grid" id="kpiGrid">
                                <div class="ws-kpi-box">
                                    <div class="ws-kpi-label">Avg. Order Value</div>
                                    <div class="ws-kpi-num">₹34,177</div>
                                    <div class="ws-kpi-sub">↑ 12.4% vs last month</div>
                                </div>
                                <div class="ws-kpi-box">
                                    <div class="ws-kpi-label">Dispatch Turnaround</div>
                                    <div class="ws-kpi-num">1.8 Days</div>
                                    <div class="ws-kpi-sub"><svg class="ws-ico gold ws-ico-sm" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> Priority VIP BlueDart</div>
                                </div>
                                <div class="ws-kpi-box">
                                    <div class="ws-kpi-label">GST Input Tax Credit</div>
                                    <div class="ws-kpi-num">₹10,253</div>
                                    <div class="ws-kpi-sub"><svg class="ws-ico gold ws-ico-sm" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg> 100% GSTR-1 Matched</div>
                                </div>
                                <div class="ws-kpi-box">
                                    <div class="ws-kpi-label">Lot Reorder Rate</div>
                                    <div class="ws-kpi-num">83.3%</div>
                        <div class="ws-kpi-sub"><svg class="ws-ico gold ws-ico-sm" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg> 5 of 6 Lots Repeated</div>
                                </div>
                            </div>
                        </div>

                        <!-- Column 3: VIP Tier Roadmap Milestone -->
                        <div>
                            <div class="ws-stats-col-title">
                                <span><svg class="ws-ico gold" style="margin-right:5px;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg> VIP Tier Milestone</span>
                            </div>
                            <div class="ws-tier-status-box" style="padding:14px; display:flex; flex-direction:column; justify-content:space-between; background:linear-gradient(135deg, #FFFFFF 0%, #FEFAF0 100%); border:1.5px solid rgba(212,175,55,0.45); border-radius:12px;">
                                <div>
                                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                                        <span class="ws-tier-badge active" id="statsMilestoneBadge" style="font-size:0.60rem; font-weight:800;">Tier 1: Non-VIP (Active)</span>
                                        <span id="statsMilestoneOrders" style="font-size:0.66rem; font-weight:800; color:#15803D;">6 / 50 Orders</span>
                                    </div>
                                    <h4 id="statsMilestoneVal" style="font-size:1.10rem; font-weight:900; color:var(--ws-text-main); margin:0 0 6px; font-family:var(--ws-font-serif); letter-spacing:0.2px;">
                                        Tier 1: Non-VIP Member
                                    </h4>
                                    <!-- Progress Bar -->
                                    <div style="height:6px; background:#F1ECE1; border-radius:4px; overflow:hidden; margin-bottom:8px;">
                                        <div id="statsMilestoneBar" style="height:100%; width:12%; background:linear-gradient(90deg, #10B981, #059669); border-radius:4px;"></div>
                                    </div>
                                    <p id="statsMilestoneDesc" style="font-size:0.73rem; color:#57534E; line-height:1.35; margin:0;">
                                        Complete <strong>44 more orders</strong> to automatically unlock <strong>Tier 2: Silver</strong> with a extra margin rebate!
                                    </p>
                                </div>

                                <button class="ws-btn ws-btn-primary ws-btn-sm" style="margin-top:10px; width:100%; justify-content:center;" onclick="openVipTierModal()">
                                    <svg class="ws-ico" style="stroke:#FFFFFF;margin-right:4px;" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg> View VIP Roadmap
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Trending Catalog Carousel (Matches Shop Page Product Cards) -->
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group" style="display:flex; align-items:center; gap:8px;">
                            <div style="width:32px; height:32px; border-radius:9px; background:linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border:1.5px solid rgba(217, 119, 6, 0.35); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 2px 6px rgba(217,119,6,0.15);">
                                <svg class="ws-anim-flame-star" style="width:17px; height:17px;" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2l2.4 5.2 5.6.8-4 4 1 5.6-5-2.8-5 2.8 1-5.6-4-4 5.6-.8L12 2z" fill="url(#goldStarGradCatalog)" stroke="#B45309" stroke-width="1.2" stroke-linejoin="round"></path>
                                    <defs>
                                        <linearGradient id="goldStarGradCatalog" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#FDE047"/>
                                            <stop offset="50%" stop-color="#F59E0B"/>
                                            <stop offset="100%" stop-color="#D97706"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <h3 style="font-family:var(--ws-font-serif); font-size:clamp(1.02rem, 1.8vw, 1.18rem); font-weight:800; color:var(--ws-text-main); margin:0; letter-spacing:0.2px;">
                                Trending Catalog
                            </h3>
                        </div>
                        <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="switchWsTab('trending')" style="font-weight:800; display:inline-flex; align-items:center; gap:4px;">
                            <span>View All (<?= count($catalogProducts) ?>)</span>
                            <span style="font-size:1rem; line-height:1;">→</span>
                        </button>
                    </div>

                    <div class="ws-slider-wrap">
                        <button class="ws-slider-nav-btn prev" onclick="slideTrendingProducts(-1)" aria-label="Previous"><svg style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg></button>
                        <div class="ws-slider-track" id="wsTrendingSliderTrack">
                            <?php foreach ($catalogProducts as $prod): 
                                $badge_raw = $prod['badge'] ?? 'Bestseller';
                                $badge_slug = strtolower(str_replace([' ', '★'], ['-', ''], $badge_raw));
                                $margin_pct = round((($prod['retail_price'] - $prod['wholesale_price']) / $prod['retail_price']) * 100);
                            ?>
                            <article class="product-card" data-product-id="<?= $prod['id'] ?>" role="listitem">
                                <div class="card-image-wrap">
                                    <a href="singelprodut.php?id=<?= $prod['id'] ?>" style="display:block;width:100%;height:100%;">
                                        <img src="<?= htmlspecialchars($prod['image']) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" class="card-img" onerror="this.src='images/product1.png';" loading="lazy">
                                    </a>
                                    <?php if (!empty($prod['badge'])): ?>
                                    <span class="card-badge badge-<?= $badge_slug ?>"><?= htmlspecialchars($prod['badge']) ?></span>
                                    <?php endif; ?>
                                    <!-- Wishlist Button -->
                                    <button type="button" class="card-wishlist-btn" data-id="<?= $prod['id'] ?>" onclick="event.stopPropagation();event.preventDefault();toggleWholesaleWishlist(<?= $prod['id'] ?>, this)" aria-label="Wishlist <?= htmlspecialchars($prod['name']) ?>" aria-pressed="false">
                                        <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                    </button>

                                    <!-- Mobile Quick View Button -->
                                    <button type="button" class="card-mobile-qv-btn quick-view-btn" data-id="<?= $prod['id'] ?>" onclick="event.stopPropagation();event.preventDefault();if(typeof window.openQV==='function'){window.openQV(<?= $prod['id'] ?>);}else{openQuickOrderModal(<?= htmlspecialchars(json_encode($prod)) ?>);}" aria-label="Quick View <?= htmlspecialchars($prod['name']) ?>">
                                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </button>

                                    <!-- Desktop Quick View Overlay -->
                                    <div class="card-quick-view" aria-hidden="true">
                                        <button type="button" class="quick-view-btn" data-id="<?= $prod['id'] ?>" onclick="event.stopPropagation();event.preventDefault();if(typeof window.openQV==='function'){window.openQV(<?= $prod['id'] ?>);}else{openQuickOrderModal(<?= htmlspecialchars(json_encode($prod)) ?>);}">Quick View</button>
                                    </div>

                                    <!-- Share Button on Photo (Directly Above Category Tag) -->
                                    <button type="button" class="card-share-btn" data-id="<?= $prod['id'] ?>" aria-label="Share <?= htmlspecialchars($prod['name']) ?>" title="Share <?= htmlspecialchars($prod['name']) ?>" onclick="event.stopPropagation();event.preventDefault();if(typeof window.shareProductCard==='function'){window.shareProductCard(<?= $prod['id'] ?>);}else{shareWholesaleProduct(<?= htmlspecialchars(json_encode($prod)) ?>);}">
                                        <svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                                    </button>
                                    <span class="card-cat-photo-tag"><?= htmlspecialchars($prod['category']) ?></span>
                                </div>
                                <div class="card-body">
                                    <h2 class="card-name">
                                        <a href="singelprodut.php?id=<?= $prod['id'] ?>" style="color:inherit;text-decoration:none;">
                                            <?= htmlspecialchars($prod['name']) ?>
                                        </a>
                                    </h2>
                                    <div class="card-info-text-row">
                                        <span class="card-colors-text"><?= htmlspecialchars($prod['color']) ?></span>
                                        <span class="card-sizes-text"><?= !empty($prod['moq']) ? 'MOQ: '.$prod['moq'].' Pcs' : 'Free Size' ?></span>
                                    </div>
                                    <div class="card-price-row">
                                        <div class="card-price-stack">
                                            <span class="card-price">₹<?= number_format($prod['wholesale_price']) ?></span>
                                            <?php if (!empty($prod['retail_price'])): ?>
                                            <span class="card-old-price">₹<?= number_format($prod['retail_price']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <!-- Direct Add to Cart '+' Button next to Sale Price -->
                                        <button type="button" class="card-smart-add-cart-btn" data-id="<?= $prod['id'] ?>" onclick="event.stopPropagation();event.preventDefault();directAddWholesaleToCart(<?= htmlspecialchars(json_encode($prod)) ?>, this)" aria-label="Add <?= htmlspecialchars($prod['name']) ?> to Cart" title="Direct Add to Cart">
                                            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                        </button>
                                    </div>
                                </div>
                            </article>
                            <?php endforeach; ?>
                        </div>
                        <button class="ws-slider-nav-btn next" onclick="slideTrendingProducts(1)" aria-label="Next"><svg style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg></button>
                    </div>
                </div>

                <!-- Recent Orders Snapshot -->
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group" style="display:flex; align-items:center; gap:8px;">
                            <div style="width:32px; height:32px; border-radius:9px; background:linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border:1.5px solid rgba(217, 119, 6, 0.35); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 2px 6px rgba(217,119,6,0.15);">
                                <svg style="width:17px; height:17px; stroke:#B45309; fill:none; stroke-width:2.2; stroke-linecap:round; stroke-linejoin:round;" viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            </div>
                            <h3 style="font-family:var(--ws-font-serif); font-size:clamp(1.02rem, 1.8vw, 1.18rem); font-weight:800; color:var(--ws-text-main); margin:0; letter-spacing:0.2px;">
                                Recent Dispatches
                            </h3>
                        </div>
                        <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="switchWsTab('orders')" style="font-weight:800; display:inline-flex; align-items:center; gap:4px;">
                            <span>Full Order Book</span>
                            <span style="font-size:1rem; line-height:1;">→</span>
                        </button>
                    </div>

                    <div id="overviewOrdersContainer">
                        <!-- Populated by JS -->
                    </div>
                </div>

            </section>


            <!-- ═══════════════════════════════════════
                 TAB 2: MY DETAILS
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneDetails">
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group">
                            <h3>Wholesaler Representative Profile</h3>
                        </div>
                    </div>

                    <form id="wsDetailsForm" onsubmit="handleSaveWholesalerDetails(event)">
                        <div class="ws-form-grid">
                            
                            <div class="ws-form-group">
                                <label class="ws-label" for="wsProfName">Full Name / Authorized Rep <span class="req">*</span></label>
                                <input type="text" id="wsProfName" class="ws-input" placeholder="e.g. Rajesh Kumar" required>
                            </div>

                            <div class="ws-form-group">
                                <label class="ws-label" for="wsProfPhone">WhatsApp Mobile Number <span class="req">*</span></label>
                                <div class="ws-phone-wrap">
                                    <div class="ws-phone-prefix">🇮🇳 +91</div>
                                    <input type="tel" id="wsProfPhone" class="ws-input ws-phone-input" placeholder="9876543210" maxlength="10" required>
                                </div>
                            </div>

                            <div class="ws-form-group">
                                <label class="ws-label" for="wsProfEmail">Registered Business Email <span class="req">*</span></label>
                                <input type="email" id="wsProfEmail" class="ws-input" placeholder="e.g. rajesh@shreekrishnasilks.com" required>
                            </div>

                            <div class="ws-form-group">
                                <label class="ws-label">Account Role Designation</label>
                                <input type="text" class="ws-input" value="👑 Wholesaler B2B VIP Tier" disabled>
                            </div>

                        </div>

                        <div style="margin-top: 14px; padding-top: 14px; border-top: 1px dashed var(--ws-border);">
                            <h4 style="font-size:0.95rem; font-weight:700; color:var(--ws-gold-primary); margin-bottom:10px;">
                                🔒 Change Password (Leave blank to keep current)
                            </h4>
                            <div class="ws-form-grid">
                                <div class="ws-form-group">
                                    <label class="ws-label" for="wsCurrentPass">Current Password</label>
                                    <input type="password" id="wsCurrentPass" class="ws-input" placeholder="Enter current password">
                                </div>
                                <div class="ws-form-group">
                                    <label class="ws-label" for="wsNewPass">New Password</label>
                                    <input type="password" id="wsNewPass" class="ws-input" placeholder="Minimum 6 characters">
                                </div>
                            </div>
                        </div>

                        <div class="ws-btn-group">
                            <button type="submit" class="ws-btn ws-btn-primary">
                                Save Profile Changes
                            </button>
                        </div>
                    </form>
                </div>
            </section>


            <!-- ═══════════════════════════════════════
                 TAB 3: GST / NON-GST PROFILE
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneGst">
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group">
                            <h3>GST & Business Tax Configuration</h3>
                        </div>
                    </div>

                    <!-- GST Type Selector Cards -->
                    <div class="ws-gst-selector-grid">
                        <div class="ws-gst-option-card selected" id="gstCardGst" onclick="selectGstMode('gst')">
                            <div class="ws-radio-dot"></div>
                            <div>
                                <strong style="font-size:0.88rem; color:var(--ws-text-main);">Registered with GST (Input Tax Credit)</strong>
                                <p style="font-size:0.75rem; color:var(--ws-text-muted); margin-top:2px;">Get official GSTR-1 compliant tax invoices for input tax credit.</p>
                            </div>
                        </div>

                        <div class="ws-gst-option-card" id="gstCardNonGst" onclick="selectGstMode('non_gst')">
                            <div class="ws-radio-dot"></div>
                            <div>
                                <strong style="font-size:0.88rem; color:var(--ws-text-main);">Unregistered / Non-GST Trader</strong>
                                <p style="font-size:0.75rem; color:var(--ws-text-muted); margin-top:2px;">Retail bills issued under composition or trader exempt threshold.</p>
                            </div>
                        </div>
                    </div>

                    <form id="wsGstForm" onsubmit="handleSaveGstProfile(event)">
                        <div class="ws-form-grid">
                            
                            <div class="ws-form-group full" id="wsCompanyNameFieldWrap">
                                <label class="ws-label" for="wsCompanyName">Registered Legal Trade Name / Firm Name <span class="req">*</span></label>
                                <input type="text" id="wsCompanyName" class="ws-input" placeholder="e.g. Shree Krishna Silks Pvt Ltd" required>
                            </div>

                            <div class="ws-form-group full" id="gstNumberFieldWrap">
                                <label class="ws-label" for="wsGstNumber">
                                    <span>15-Character GSTIN Number <span class="req">*</span></span>
                                    <span id="gstStateDetectTag" style="font-size:0.72rem; color:var(--ws-gold-primary); font-weight:700;">Format: 24AABCU9603R1ZM</span>
                                </label>
                                <input type="text" id="wsGstNumber" class="ws-input" placeholder="e.g. 24AABCU9603R1ZM" maxlength="15" style="text-transform:uppercase; font-family:monospace; letter-spacing:0.08em;" oninput="validateGstinInput(this)">
                            </div>

                            <div class="ws-form-group full" id="nonGstNoticeWrap" style="display:none;">
                                <div style="padding:12px 14px; background:#F8FAFC; border:1.5px solid #E2E8F0; border-radius:8px; font-size:0.80rem; color:#475569; line-height:1.4;">
                                    <strong style="color:#0F172A; display:block; margin-bottom:2px;">ℹ️ Unregistered / Non-GST Mode Active</strong>
                                    No registered company name or GSTIN number is required. Orders will be processed under your personal account.
                                </div>
                            </div>

                        </div>

                        <div class="ws-btn-group">
                            <button type="submit" class="ws-btn ws-btn-primary">
                                Save Tax Profile
                            </button>
                        </div>
                    </form>
                </div>
            </section>


            <!-- ═══════════════════════════════════════
                 TAB 4: MY ADDRESS BOOK
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneAddress">
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group">
                            <h3>Wholesale Delivery & Dispatch Address</h3>
                        </div>
                    </div>

                    <form id="wsAddressForm" onsubmit="handleSaveAddress(event)">
                        <div class="ws-form-grid">
                            
                            <div class="ws-form-group full">
                                <label class="ws-label" for="wsFullAddress">Warehouse / Shop / Godown Address <span class="req">*</span></label>
                                <textarea id="wsFullAddress" class="ws-textarea" placeholder="Shop No, Building Name, Textile Market, Street, Landmark" required></textarea>
                            </div>

                            <div class="ws-form-group">
                                <label class="ws-label" for="wsCity">City / District <span class="req">*</span></label>
                                <input type="text" id="wsCity" class="ws-input" placeholder="e.g. Surat" required>
                            </div>

                            <div class="ws-form-group">
                                <label class="ws-label" for="wsStateSelect">State / UT (India) <span class="req">*</span></label>
                                <select id="wsStateSelect" class="ws-select" required>
                                    <option value="Gujarat">Gujarat (24)</option>
                                    <option value="Maharashtra">Maharashtra (27)</option>
                                    <option value="Rajasthan">Rajasthan (08)</option>
                                    <option value="Delhi">Delhi (07)</option>
                                    <option value="Uttar Pradesh">Uttar Pradesh (09)</option>
                                    <option value="Madhya Pradesh">Madhya Pradesh (23)</option>
                                    <option value="Karnataka">Karnataka (29)</option>
                                    <option value="Tamil Nadu">Tamil Nadu (33)</option>
                                    <option value="Telangana">Telangana (36)</option>
                                    <option value="West Bengal">West Bengal (19)</option>
                                    <option value="Other States">Other Indian State / UT</option>
                                </select>
                            </div>

                            <div class="ws-form-group">
                                <label class="ws-label" for="wsPincode">6-Digit Indian PIN Code <span class="req">*</span></label>
                                <input type="text" id="wsPincode" class="ws-input" placeholder="395002" maxlength="6" pattern="[0-9]{6}" required>
                            </div>

                        </div>

                        <div class="ws-btn-group">
                            <button type="submit" class="ws-btn ws-btn-primary">
                                Save Dispatch Address
                            </button>
                        </div>
                    </form>
                </div>
            </section>


            <!-- ═══════════════════════════════════════
                 TAB 5: ORDER LIST
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneOrders">
                <div class="ws-card">
                    <div class="ws-card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                        <div class="ws-card-title-group" style="display:flex; align-items:center; gap:8px;">
                            <div style="width:32px; height:32px; border-radius:9px; background:linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border:1.5px solid rgba(217, 119, 6, 0.35); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 2px 6px rgba(217,119,6,0.15);">
                                <svg class="ws-anim-stat-ico box" style="width:17px; height:17px;" viewBox="0 0 24 24" fill="none" stroke="#B45309" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                            </div>
                            <h3 style="font-family:var(--ws-font-serif); font-size:clamp(0.96rem, 1.8vw, 1.18rem); font-weight:800; color:var(--ws-text-main); margin:0; letter-spacing:0.2px;">
                                New Catalogue
                            </h3>
                        </div>
                        <a href="shop.php" class="ws-btn-new-order">
                            <span class="ws-new-order-icon-badge">
                                <svg class="ws-anim-plus-bounce" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </span>
                            <span>New Order</span>
                        </a>
                    </div>

                    <!-- Search & Filter Controls -->
                    <div class="ws-filter-controls-row">
                        <!-- Status Filter Pills (1-Line Horizontal Scroll) -->
                        <div class="ws-orders-filter-btns">
                            <button class="ws-rep-filter-btn active" onclick="setOrderStatusFilter('all', this)">All Orders (6)</button>
                            <button class="ws-rep-filter-btn" onclick="setOrderStatusFilter('Shipped', this)">Shipped (2)</button>
                            <button class="ws-rep-filter-btn" onclick="setOrderStatusFilter('Delivered', this)">Delivered (3)</button>
                            <button class="ws-rep-filter-btn" onclick="setOrderStatusFilter('Processing', this)">Processing (1)</button>
                        </div>

                        <!-- Search Bar -->
                        <div class="ws-luxury-search-wrap">
                            <svg class="ws-luxury-search-icon" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" id="wsOrdersSearchInput" class="ws-luxury-search-input" placeholder="Search Order ID, Product, Courier, AWB..." oninput="filterOrdersTable()">
                            <button type="button" class="ws-luxury-search-clear" id="wsOrdersSearchClear" onclick="clearOrdersSearch()" aria-label="Clear Search">✕</button>
                        </div>
                    </div>

                    <!-- Desktop Orders Table -->
                    <div class="ws-table-container">
                        <table class="ws-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Product / Lot Details</th>
                                    <th>Qty</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="wsOrdersTbody">
                                <!-- Populated dynamically by JS -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Orders Card Feed -->
                    <div class="ws-mobile-order-cards" id="wsMobileOrdersCards">
                        <!-- Populated dynamically by JS -->
                    </div>
                </div>
            </section>


            <!-- ═══════════════════════════════════════
                 TAB 6: REPORTS & EXPORT
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneReports">
                <!-- Top 4 KPI Summary Cards for Reports -->
                <div class="ws-report-kpis-grid">
                    <div class="ws-kpi-box">
                        <div class="ws-kpi-label">Total Invoiced Turnover</div>
                        <div class="ws-kpi-num" id="repKpiTurnover" style="color:var(--ws-gold-primary);">₹2,05,062</div>
                        <div class="ws-kpi-sub">100% Cleared GST Invoices</div>
                    </div>
                    <div class="ws-kpi-box">
                        <div class="ws-kpi-label">Input Tax Credit (ITC)</div>
                        <div class="ws-kpi-num" id="repKpiItc" style="color:#10B981;">₹10,253</div>
                        <div class="ws-kpi-sub">GSTR-2B Reconciled (5% GST)</div>
                    </div>
                    <div class="ws-kpi-box">
                        <div class="ws-kpi-label">Total Units Procured</div>
                        <div class="ws-kpi-num" id="repKpiUnits">48 Pcs</div>
                        <div class="ws-kpi-sub">6 Wholesale Consignments</div>
                    </div>
                    <div class="ws-kpi-box">
                        <div class="ws-kpi-label">Avg. Consignment Value</div>
                        <div class="ws-kpi-num" id="repKpiAvg">₹34,177</div>
                        <div class="ws-kpi-sub">Tier 1 Volume Margin Rates</div>
                    </div>
                </div>

                <div class="ws-card">
                    <div class="ws-card-header" style="flex-wrap:wrap; gap:12px; align-items:center;">
                        <div class="ws-card-title-group">
                            <h3>B2B Wholesale Procurement Reports</h3>
                        </div>
                        <div style="display:flex; gap:8px; flex-wrap:wrap;">
                            <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="exportReportsToCsv()">
                                📥 Export CSV
                            </button>
                            <button class="ws-btn ws-btn-primary ws-btn-sm" onclick="printWholesaleReport()">
                                🖨️ Print Report
                            </button>
                        </div>
                    </div>

                    <!-- Filter Pills & Luxury Search Bar -->
                    <div class="ws-filter-controls-row">
                        <div class="ws-filter-pill-group" style="display:flex; gap:6px; flex-wrap:nowrap; overflow-x:auto;">
                            <button class="ws-rep-filter-btn active" onclick="filterReportsByCategory('all', this)">All Categories</button>
                            <button class="ws-rep-filter-btn" onclick="filterReportsByCategory('saree', this)">Sarees</button>
                            <button class="ws-rep-filter-btn" onclick="filterReportsByCategory('lehenga', this)">Lehengas</button>
                            <button class="ws-rep-filter-btn" onclick="filterReportsByCategory('kurti', this)">Kurtis</button>
                            <button class="ws-rep-filter-btn" onclick="filterReportsByCategory('fabric', this)">Fabrics</button>
                        </div>
                        <div class="ws-luxury-search-wrap">
                            <svg class="ws-luxury-search-icon" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" id="reportSearchInput" class="ws-luxury-search-input" placeholder="Search consignment, HSN, SKU, lot..." oninput="handleReportSearch(this.value)">
                            <button type="button" class="ws-luxury-search-clear" id="reportSearchClear" onclick="clearReportSearch()" aria-label="Clear Search">✕</button>
                        </div>
                    </div>

                    <!-- Desktop Reports Table View -->
                    <div class="ws-table-container">
                        <table class="ws-table">
                            <thead>
                                <tr>
                                    <th>Consignment</th>
                                    <th>Date</th>
                                    <th>HSN</th>
                                    <th>Product / Lot Details</th>
                                    <th>Qty</th>
                                    <th>Taxable Value</th>
                                    <th>GST (5%)</th>
                                    <th>Net Total</th>
                                    <th>Payment Mode</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="wsReportsTbody">
                                <!-- Populated dynamically by JS -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Responsive Reports Card Feed -->
                    <div class="ws-mobile-reports-cards" id="wsMobileReportsCards">
                        <!-- Populated dynamically by JS -->
                    </div>
                </div>
            </section>


            <!-- ═══════════════════════════════════════
                 TAB 7: LIVE SHIPMENT & CONSIGNMENT TRACKING
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneTracking">
                <div class="ws-card">
                    <div class="ws-card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:nowrap; gap:10px;">
                        <div class="ws-card-title-group">
                            <h3 style="margin:0; font-size:1.05rem;">Live Consignment Tracking</h3>
                        </div>
                        <span class="ws-status-badge shipped" id="trackHeaderBadge" style="white-space:nowrap; font-size:0.75rem;">⚡ BlueDart Express</span>
                    </div>

                    <!-- Active Tracking Hero Visual Card -->
                    <div id="wsActiveTrackHero" style="background:#FAF8F4; border:1.5px solid var(--ws-gold-border); border-radius:12px; padding:18px; margin-bottom:20px; box-shadow:0 4px 16px rgba(138,104,31,0.08);">
                        <!-- Injected dynamically by JS for active consignment -->
                    </div>

                    <!-- All Consignments Selector Section -->
                    <div style="margin-top:24px; padding-top:18px; border-top:1.5px solid var(--ws-border);">
                        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                            <h4 style="font-size:0.95rem; font-weight:800; color:var(--ws-text-main); font-family:var(--ws-font-serif); margin:0;">
                                Select Consignment to Track
                            </h4>
                            <div class="ws-filter-pill-group" style="display:flex; gap:6px; flex-wrap:nowrap; overflow-x:auto;">
                                <button class="ws-rep-filter-btn active" onclick="filterTrackingOrders('all', this)">All (6)</button>
                                <button class="ws-rep-filter-btn" onclick="filterTrackingOrders('shipped', this)">In Transit</button>
                                <button class="ws-rep-filter-btn" onclick="filterTrackingOrders('delivered', this)">Delivered</button>
                                <button class="ws-rep-filter-btn" onclick="filterTrackingOrders('processing', this)">Processing</button>
                            </div>
                        </div>

                        <!-- Orders Grid for Tracking -->
                        <div class="ws-track-orders-grid" id="wsTrackingOrdersGrid">
                            <!-- Populated dynamically by JS -->
                        </div>
                    </div>
                </div>
            </section>


            <!-- ═══════════════════════════════════════
                 TAB 8: SUPPORT & TICKETS
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneSupport">
                <div class="ws-card">
                    <div class="ws-card-header" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                        <div class="ws-card-title-group">
                            <h3 style="margin:0; font-size:1.05rem;">Wholesale Concierge & Support</h3>
                        </div>
                        <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%20Kalaniketan%2C%20I%20am%20a%20registered%20Wholesaler%20and%20require%20urgent%20support" target="_blank" class="ws-btn ws-btn-wa ws-btn-sm" style="display:inline-flex; align-items:center; gap:6px; font-weight:700;">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M17.472 14.382c-.301-.15-1.78-.879-2.056-.979-.275-.1-.475-.15-.675.15-.2.3-.775.979-.95 1.179-.175.2-.35.225-.65.075-.3-.15-1.267-.467-2.414-1.49-1.049-.935-1.758-2.09-1.963-2.44-.205-.35-.022-.54.128-.69.135-.135.301-.35.451-.525.15-.175.2-.3.3-.5.1-.2.05-.375-.025-.525-.075-.15-.675-1.628-.925-2.228-.244-.585-.492-.505-.675-.515-.175-.01-.375-.01-.575-.01-.2 0-.525.075-.8.375s-1.05 1.028-1.05 2.505 1.075 2.905 1.225 3.105c.15.2 2.115 3.23 5.125 4.53 3.01 1.3 3.01.867 3.56.817.55-.05 1.78-.727 2.03-1.428.25-.7.25-1.3.175-1.428-.075-.128-.275-.203-.575-.353z"/><path d="M12 2C6.477 2 2 6.477 2 12c0 1.891.524 3.662 1.435 5.176L2 22l4.981-1.307C8.423 21.536 10.155 22 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18c-1.63 0-3.14-.492-4.407-1.336l-.316-.209-2.955.775.789-2.88-.228-.363C3.965 14.675 3.5 13.385 3.5 12c0-4.687 3.813-8.5 8.5-8.5s8.5 3.813 8.5 8.5-3.813 8.5-8.5 8.5z"/></svg>
                            <span>WhatsApp Concierge</span>
                        </a>
                    </div>

                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(clamp(260px, 45vw, 320px), 1fr)); gap:16px;">
                        
                        <!-- Open New Ticket Form -->
                        <div style="background:#FAF8F4; padding:18px; border-radius:12px; border:1.5px solid var(--ws-border); box-shadow:0 2px 8px rgba(0,0,0,0.02);">
                            <div style="display:flex; align-items:center; gap:8px; margin-bottom:14px; padding-bottom:10px; border-bottom:1px solid var(--ws-border);">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--ws-gold-primary)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                <h4 style="font-size:0.95rem; font-weight:800; color:var(--ws-gold-primary); margin:0; font-family:var(--ws-font-serif);">
                                    Create Support Ticket
                                </h4>
                            </div>

                            <form id="wsTicketForm" onsubmit="handleCreateTicket(event)">
                                <div class="ws-form-group">
                                    <label class="ws-label" for="ticketOrderId">Related Order ID <span class="req">*</span></label>
                                    <select id="ticketOrderId" class="ws-select" required>
                                        <option value="KLN-WS-8021">KLN-WS-8021 (Nilambari Silk 12 Pcs)</option>
                                        <option value="KLN-WS-7914">KLN-WS-7914 (Banarasi Zari 8 Pcs)</option>
                                        <option value="KLN-WS-6540">KLN-WS-6540 (Bridal Velvet 4 Pcs)</option>
                                        <option value="General Inquiry">General / Custom Catalog Inquiry</option>
                                    </select>
                                </div>

                                <div class="ws-form-group">
                                    <label class="ws-label" for="ticketCategory">Issue Category <span class="req">*</span></label>
                                    <select id="ticketCategory" class="ws-select" required>
                                        <option value="Logistics & Dispatch">Logistics & Dispatch Inquiry</option>
                                        <option value="Bulk Pricing Negotiation">Bulk Lot Pricing & Discount Enquiry</option>
                                        <option value="GST Tax Invoice Issue">GST Input Tax Credit Invoice Query</option>
                                        <option value="Quality Inspection">Sample & Quality Assurance Query</option>
                                    </select>
                                </div>

                                <div class="ws-form-group">
                                    <label class="ws-label" for="ticketMessage">Detailed Issue Narrative <span class="req">*</span></label>
                                    <textarea id="ticketMessage" class="ws-textarea" required placeholder="Describe your inquiry or order feedback in detail..."></textarea>
                                </div>

                                <button type="submit" class="ws-btn ws-btn-primary" style="width:100%; height:42px; font-size:0.86rem; font-weight:700; justify-content:center; border-radius:8px; display:inline-flex; align-items:center; gap:8px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#FFFFFF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                    <span>Submit Support Ticket</span>
                                </button>
                            </form>
                        </div>

                        <!-- Ticket History List -->
                        <div>
                            <div style="display:flex; align-items:center; gap:8px; margin-bottom:14px; padding-bottom:10px; border-bottom:1px solid var(--ws-border);">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="var(--ws-gold-primary)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                                <h4 style="font-size:0.95rem; font-weight:800; color:var(--ws-gold-primary); margin:0; font-family:var(--ws-font-serif);">
                                    Support Ticket History
                                </h4>
                            </div>

                            <div class="ws-ticket-list" id="wsTicketList">
                                <!-- Populated dynamically by JS -->
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <!-- ═══════════════════════════════════════
                 TAB 9: TRENDING CATALOG (FULL VIEW)
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneTrending">
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group" style="display:flex; align-items:center; gap:8px;">
                            <div style="width:32px; height:32px; border-radius:9px; background:linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border:1.5px solid rgba(217, 119, 6, 0.35); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 2px 6px rgba(217,119,6,0.15);">
                                <svg class="ws-anim-flame-star" style="width:17px; height:17px;" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2l2.4 5.2 5.6.8-4 4 1 5.6-5-2.8-5 2.8 1-5.6-4-4 5.6-.8L12 2z" fill="url(#goldStarGradForYou)" stroke="#B45309" stroke-width="1.2" stroke-linejoin="round"></path>
                                    <defs>
                                        <linearGradient id="goldStarGradForYou" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#FDE047"/>
                                            <stop offset="50%" stop-color="#F59E0B"/>
                                            <stop offset="100%" stop-color="#D97706"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <h3 class="ws-anim-shimmer-title" style="font-family:var(--ws-font-serif); font-size:clamp(1.05rem, 1.8vw, 1.25rem); font-weight:900; margin:0; letter-spacing:0.2px;">
                                For You
                            </h3>
                        </div>
                        <a href="shop.php" class="ws-btn ws-btn-secondary ws-btn-sm" style="font-weight:800; display:inline-flex; align-items:center; gap:4px;">
                            <span>Browse Retail Store</span>
                            <span style="font-size:1rem; line-height:1;">→</span>
                        </a>
                    </div>

                    <div class="ws-master-catalog-grid" id="wsForYouSliderTrack">
                        <?php foreach ($catalogProducts as $prod): 
                            $badge_raw = $prod['badge'] ?? 'Bestseller';
                            $badge_slug = strtolower(str_replace([' ', '★'], ['-', ''], $badge_raw));
                            $margin_pct = round((($prod['retail_price'] - $prod['wholesale_price']) / $prod['retail_price']) * 100);
                        ?>
                        <article class="product-card" data-product-id="<?= $prod['id'] ?>" role="listitem">
                            <div class="card-image-wrap">
                                <a href="singelprodut.php?id=<?= $prod['id'] ?>" style="display:block;width:100%;height:100%;">
                                    <img src="<?= htmlspecialchars($prod['image']) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" class="card-img" onerror="this.src='images/product1.png';" loading="lazy">
                                </a>

                                <!-- Status Badge -->
                                <?php if (!empty($prod['badge'])): ?>
                                <span class="card-badge badge-<?= $badge_slug ?>"><?= htmlspecialchars($prod['badge']) ?></span>
                                <?php endif; ?>

                                <!-- Wishlist Button -->
                                <button type="button" class="card-wishlist-btn" data-id="<?= $prod['id'] ?>" onclick="event.stopPropagation();event.preventDefault();toggleWholesaleWishlist(<?= $prod['id'] ?>, this)" aria-label="Wishlist <?= htmlspecialchars($prod['name']) ?>" aria-pressed="false">
                                    <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                                </button>

                                <!-- Mobile Quick View Button -->
                                <button type="button" class="card-mobile-qv-btn quick-view-btn" data-id="<?= $prod['id'] ?>" onclick="event.stopPropagation();event.preventDefault();if(typeof window.openQV==='function'){window.openQV(<?= $prod['id'] ?>);}else{openQuickOrderModal(<?= htmlspecialchars(json_encode($prod)) ?>);}" aria-label="Quick View <?= htmlspecialchars($prod['name']) ?>">
                                    <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </button>

                                <!-- Desktop Quick View Overlay -->
                                <div class="card-quick-view" aria-hidden="true">
                                    <button type="button" class="quick-view-btn" data-id="<?= $prod['id'] ?>" onclick="event.stopPropagation();event.preventDefault();if(typeof window.openQV==='function'){window.openQV(<?= $prod['id'] ?>);}else{openQuickOrderModal(<?= htmlspecialchars(json_encode($prod)) ?>);}">Quick View</button>
                                </div>

                                <!-- Share Button on Photo (Directly Above Category Tag) -->
                                <button type="button" class="card-share-btn" data-id="<?= $prod['id'] ?>" aria-label="Share <?= htmlspecialchars($prod['name']) ?>" title="Share <?= htmlspecialchars($prod['name']) ?>" onclick="event.stopPropagation();event.preventDefault();if(typeof window.shareProductCard==='function'){window.shareProductCard(<?= $prod['id'] ?>);}else{shareWholesaleProduct(<?= htmlspecialchars(json_encode($prod)) ?>);}">
                                    <svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                                </button>

                                <!-- Category Box on Photo Bottom-Right Corner -->
                                <span class="card-cat-photo-tag"><?= htmlspecialchars($prod['category']) ?></span>
                            </div>

                            <div class="card-body">
                                <!-- Product Title -->
                                <h2 class="card-name">
                                    <a href="singelprodut.php?id=<?= $prod['id'] ?>" style="color:inherit;text-decoration:none;">
                                        <?= htmlspecialchars($prod['name']) ?>
                                    </a>
                                </h2>

                                <!-- Clean Text Info Row: Available Colors & Sizes -->
                                <div class="card-info-text-row">
                                    <span class="card-colors-text"><?= htmlspecialchars($prod['color']) ?></span>
                                    <span class="card-sizes-text"><?= !empty($prod['moq']) ? 'MOQ: '.$prod['moq'].' Pcs' : 'Free Size' ?></span>
                                </div>

                                <div class="card-price-row">
                                    <div class="card-price-stack">
                                        <span class="card-price">₹<?= number_format($prod['wholesale_price']) ?></span>
                                        <?php if (!empty($prod['retail_price'])): ?>
                                        <span class="card-old-price">₹<?= number_format($prod['retail_price']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <!-- Direct Add to Cart '+' Button next to Sale Price -->
                                    <button type="button" class="card-smart-add-cart-btn" data-id="<?= $prod['id'] ?>" onclick="event.stopPropagation();event.preventDefault();directAddWholesaleToCart(<?= htmlspecialchars(json_encode($prod)) ?>, this)" aria-label="Add <?= htmlspecialchars($prod['name']) ?> to Cart" title="Direct Add to Cart">
                                        <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    </button>
                                </div>
                            </div>
                        </article>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- ═══ Check / Procure By Price Smart Box Slider Section ═══ -->
                <div class="ws-card" style="margin-top:16px;">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group" style="display:flex; align-items:center; gap:8px;">
                            <div style="width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%); border:1.5px solid rgba(217, 119, 6, 0.35); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 2px 8px rgba(217,119,6,0.18);">
                                <svg class="ws-anim-flame-star" style="width:18px; height:18px;" viewBox="0 0 24 24" fill="none">
                                    <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" fill="url(#priceTagGoldGrad)" stroke="#B45309" stroke-width="1.6" stroke-linejoin="round"></path>
                                    <circle cx="7" cy="7" r="1.5" fill="#FFFFFF"></circle>
                                    <defs>
                                        <linearGradient id="priceTagGoldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#FDE047"/>
                                            <stop offset="50%" stop-color="#F59E0B"/>
                                            <stop offset="100%" stop-color="#D97706"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </div>
                            <div>
                                <h3 class="ws-anim-shimmer-title" style="font-family:var(--ws-font-serif); font-size:clamp(1.05rem, 1.8vw, 1.25rem); font-weight:900; margin:0; letter-spacing:0.2px;">
                                    Procure By Price Store
                                </h3>
                                <p style="font-size:0.72rem; color:var(--ws-text-muted); margin:2px 0 0; font-weight:600;">
                                    Direct Mill Wholesale Lots Filtered by Retailer Budget
                                </p>
                            </div>
                        </div>
                        <a href="shop.php" class="ws-btn ws-btn-secondary ws-btn-sm" style="font-weight:800; display:inline-flex; align-items:center; gap:4px;">
                            <span>All Price Points</span>
                            <span style="font-size:1rem; line-height:1;">→</span>
                        </a>
                    </div>

                    <div class="ws-price-slider-wrap">
                        <button class="ws-slider-nav-btn prev" onclick="slidePriceBoxes(-1)" aria-label="Previous"><svg style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg></button>
                        <div class="ws-price-slider-track" id="wsPriceSliderTrack">

                            <!-- Tier 1: Under ₹300 -->
                            <div class="ws-price-box-card" onclick="filterByPriceTier(300, this)" role="button" tabindex="0">
                                <div class="ws-price-box-icon-wrap">
                                    <svg style="width:24px;height:24px;stroke:#B45309;fill:none;stroke-width:2;" viewBox="0 0 24 24">
                                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                                    </svg>
                                </div>
                                <div class="ws-price-box-val">Under ₹300</div>
                            </div>

                            <!-- Tier 2: Under ₹500 -->
                            <div class="ws-price-box-card" onclick="filterByPriceTier(500, this)" role="button" tabindex="0">
                                <div class="ws-price-box-icon-wrap">
                                    <svg style="width:24px;height:24px;stroke:#B45309;fill:none;stroke-width:2;" viewBox="0 0 24 24">
                                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                                    </svg>
                                </div>
                                <div class="ws-price-box-val">Under ₹500</div>
                            </div>

                            <!-- Tier 3: Under ₹800 -->
                            <div class="ws-price-box-card" onclick="filterByPriceTier(800, this)" role="button" tabindex="0">
                                <div class="ws-price-box-icon-wrap">
                                    <svg style="width:24px;height:24px;stroke:#B45309;fill:none;stroke-width:2;" viewBox="0 0 24 24">
                                        <path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 3z"></path>
                                    </svg>
                                </div>
                                <div class="ws-price-box-val">Under ₹800</div>
                            </div>

                            <!-- Tier 4: Under ₹1,000 -->
                            <div class="ws-price-box-card" onclick="filterByPriceTier(1000, this)" role="button" tabindex="0">
                                <div class="ws-price-box-icon-wrap">
                                    <svg style="width:24px;height:24px;stroke:#B45309;fill:none;stroke-width:2;" viewBox="0 0 24 24">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                    </svg>
                                </div>
                                <div class="ws-price-box-val">Under ₹1,000</div>
                            </div>

                            <!-- Tier 5: Under ₹1,500 -->
                            <div class="ws-price-box-card" onclick="filterByPriceTier(1500, this)" role="button" tabindex="0">
                                <div class="ws-price-box-icon-wrap">
                                    <svg style="width:24px;height:24px;stroke:#B45309;fill:none;stroke-width:2;" viewBox="0 0 24 24">
                                        <path d="M6 3h12l4 6-10 12L2 9z"></path>
                                        <path d="M11 3L8 9l4 12 4-12-3-6"></path>
                                        <path d="M2 9h20"></path>
                                    </svg>
                                </div>
                                <div class="ws-price-box-val">Under ₹1,500</div>
                            </div>

                            <!-- Tier 6: Under ₹2,000 -->
                            <div class="ws-price-box-card" onclick="filterByPriceTier(2000, this)" role="button" tabindex="0">
                                <div class="ws-price-box-icon-wrap">
                                    <svg style="width:24px;height:24px;stroke:#B45309;fill:none;stroke-width:2;" viewBox="0 0 24 24">
                                        <path d="M2 4l3 12h14l3-12-6 7-4-7-4 7-6-7zm3 16h14"></path>
                                    </svg>
                                </div>
                                <div class="ws-price-box-val">Under ₹2,000</div>
                            </div>

                        </div>
                        <button class="ws-slider-nav-btn next" onclick="slidePriceBoxes(1)" aria-label="Next"><svg style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg></button>
                    </div>
                </div>
            </section>

        </main>
    </div>

    <!-- ═══ Mobile Floating Bottom App Dock ═══ -->
    <nav class="ws-mobile-dock" id="wsMobileDock" aria-label="Mobile Navigation">
        <button class="ws-dock-btn active" id="dockBtnOverview" onclick="switchWsTab('overview')">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            <span>Overview</span>
        </button>
        <button class="ws-dock-btn" id="dockBtnOrders" onclick="switchWsTab('orders')">
            <svg viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            <span>Orders</span>
        </button>
        <a href="shop.php" class="ws-dock-btn" id="dockBtnShop">
            <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            <span>Shop</span>
        </a>
        <button class="ws-dock-btn" id="dockBtnReports" onclick="switchWsTab('reports')">
            <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
            <span>Reports</span>
        </button>
        <button class="ws-dock-btn" id="dockBtnCart" onclick="if(typeof window.openCartDrawer==='function') window.openCartDrawer(); else window.location.href='cart.php';" aria-label="Shopping Cart">
            <div style="position:relative; display:inline-flex;">
                <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <span class="ws-dock-cart-badge" id="wsDockCartBadge" style="display:none;">0</span>
            </div>
            <span>Cart</span>
        </button>
    </nav>

    <!-- ═══════════════════════════════════════════
         MODAL 1: FULL ORDER DETAILS MODAL
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsOrderDetailsModal" role="dialog" aria-modal="true">
        <div class="ws-modal-box" style="max-width: 620px;">
            <div class="ws-modal-header">
                <h3 class="ws-modal-title">
                    <svg style="width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:2.2;" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    <span id="modalOrderTitle">Order Details #KLN-WS-8021</span>
                </h3>
                <button class="ws-modal-close-btn" onclick="closeOrderDetailsModal()" aria-label="Close Modal">&times;</button>
            </div>
            <div class="ws-modal-body" id="modalOrderBody">
                <!-- Injected dynamically by JS -->
            </div>
            <div class="ws-modal-footer" id="modalOrderFooter">
                <!-- Action buttons placed cleanly here so they are NEVER cut off -->
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         MODAL 2: PRINTABLE TAX INVOICE BILL PDF
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsBillInvoiceModal" role="dialog" aria-modal="true">
        <div class="ws-modal-box" style="max-width: 720px;">
            <div class="ws-modal-header">
                <h3 class="ws-modal-title">
                    <span>📄 Official GST Tax Invoice Bill</span>
                </h3>
                <div style="display:flex; gap:8px; align-items:center;">
                    <button class="ws-btn ws-btn-primary ws-btn-sm" onclick="printInvoiceSheet()">
                        🖨️ Print / Download PDF
                    </button>
                    <button class="ws-modal-close-btn" onclick="closeBillInvoiceModal()" aria-label="Close Modal">&times;</button>
                </div>
            </div>
            <div class="ws-modal-body">
                <div class="ws-invoice-sheet" id="invoicePrintArea">
                    <!-- Dynamic Invoice Header -->
                    <div class="ws-inv-header">
                        <div class="ws-inv-brand">
                            <h2>KALANIKETAN</h2>
                            <p><strong>Kalaniketan Ethnic Luxury Couture Pvt. Ltd.</strong><br>
                            Millennium Textile Market, Ring Road, Surat, Gujarat - 395002<br>
                            GSTIN: 24AABCK4820P1Z8 | CIN: U17111GJ2018PTC104521</p>
                        </div>
                        <div class="ws-inv-meta">
                            <p><strong>TAX INVOICE</strong></p>
                            <p>Invoice No: <strong id="invNum">INV-2026-8021</strong></p>
                            <p>Invoice Date: <span id="invDate">15 Aug 2026</span></p>
                            <p>Reverse Charge: <strong>No</strong></p>
                        </div>
                    </div>

                    <!-- Parties (Billed To & Shipped To) -->
                    <div class="ws-inv-parties">
                        <div>
                            <strong style="color:var(--ws-gold-primary);">BILLED TO (BUYER):</strong>
                            <div id="invBilledTo" style="margin-top:4px; line-height:1.4;">
                                <strong>Shree Krishna Silks Pvt Ltd</strong><br>
                                GSTIN: 24AABCU9603R1ZM<br>
                                Rajesh Kumar (+91 98765 43210)<br>
                                Shop 402, Ring Road, Surat, Gujarat - 395002
                            </div>
                        </div>
                        <div>
                            <strong style="color:var(--ws-gold-primary);">DISPATCHED / SHIPPED TO:</strong>
                            <div id="invShippedTo" style="margin-top:4px; line-height:1.4;">
                                <strong>Warehouse Central Store</strong><br>
                                Fast Cargo Express<br>
                                Surat, Gujarat - 395002
                            </div>
                        </div>
                    </div>

                    <!-- Products Table -->
                    <table class="ws-inv-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Item Description</th>
                                <th>HSN</th>
                                <th>Qty</th>
                                <th>Unit Rate</th>
                                <th>Taxable Value</th>
                                <th>GST (5%)</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="invItemsTbody">
                            <!-- Populated dynamically -->
                        </tbody>
                    </table>

                    <!-- Totals and Signature -->
                    <div class="ws-inv-totals">
                        <div>Subtotal (Taxable Value): <strong id="invSubtotal">₹38,388</strong></div>
                        <div>CGST (2.5%) + SGST (2.5%): <strong id="invTax">₹1,920</strong></div>
                        <div>Wholesale Volume Discount: <strong style="color:#10B981;">-₹2,000</strong></div>
                        <div class="ws-inv-grand-total">Grand Net Payable: <span id="invGrandTotal">₹38,308</span></div>
                    </div>

                    <div style="margin-top:20px; display:flex; align-items:flex-end; justify-content:space-between; font-size:0.75rem; color:var(--ws-text-muted);">
                        <div>
                            <p>Terms: Payment received against Proforma / Advance NEFT.</p>
                            <p>This is a computer-generated luxury tax invoice.</p>
                        </div>
                        <div style="text-align:center;">
                            <div style="width:110px; border-bottom:1.5px solid var(--ws-gold-primary); margin-bottom:4px;"></div>
                            <strong>Authorized Signatory</strong><br>
                            Kalaniketan Couture
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         MODAL 2.5: FORMAL PRINTABLE WHOLESALE PROCUREMENT AUDIT REPORT
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsPrintableAuditReportModal" role="dialog" aria-modal="true">
        <div class="ws-modal-box" style="max-width: 820px;">
            <div class="ws-modal-header">
                <h3 class="ws-modal-title">
                    <span>📊 Wholesale B2B Sales & Procurement Audit Statement</span>
                </h3>
                <div style="display:flex; gap:8px; align-items:center;">
                    <button class="ws-btn ws-btn-primary ws-btn-sm" onclick="window.print()">
                        🖨️ Print Statement
                    </button>
                    <button class="ws-modal-close-btn" onclick="closePrintableAuditReportModal()" aria-label="Close Modal">&times;</button>
                </div>
            </div>
            <div class="ws-modal-body">
                <div class="ws-invoice-sheet">
                    <div class="ws-inv-header">
                        <div class="ws-inv-brand">
                            <h2>KALANIKETAN B2B</h2>
                            <p><strong>Kalaniketan Wholesale Procurement & Logistics Ledger</strong><br>
                            Surat Silk Cluster, Ring Road, Surat, Gujarat - 395002<br>
                            GSTIN: 24AABCK4820P1Z8 | Input Tax Credit (ITC) Reconciled</p>
                        </div>
                        <div class="ws-inv-meta">
                            <p><strong>PROCUREMENT AUDIT</strong></p>
                            <p>Fiscal Cycle: <strong>FY 2026-27</strong></p>
                            <p>Tax Compliance: <span style="color:#10B981; font-weight:700;">100% GSTR-1 Verified</span></p>
                        </div>
                    </div>

                    <div style="background:#FAF8F4; border:1px solid var(--ws-border); border-radius:8px; padding:12px; margin-bottom:14px; font-size:0.80rem;" id="auditReportBuyerInfo">
                        <!-- Populated by JS -->
                    </div>

                    <div class="ws-inv-items-table-wrap">
                        <table class="ws-inv-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Consignment ID</th>
                                    <th>Date</th>
                                    <th>HSN</th>
                                    <th>Product Details</th>
                                    <th>Qty</th>
                                    <th>Taxable Base</th>
                                    <th>GST (5%)</th>
                                    <th>Net Total</th>
                                    <th>Payment Instrument</th>
                                </tr>
                            </thead>
                            <tbody id="auditReportTbody">
                                <!-- Populated dynamically by JS -->
                            </tbody>
                        </table>
                    </div>

                    <div class="ws-inv-totals-box">
                        <div class="ws-inv-tot-row">
                            <span>Total Procured Units:</span>
                            <strong id="auditTotalQty">48 Pcs</strong>
                        </div>
                        <div class="ws-inv-tot-row">
                            <span>Total Taxable Base:</span>
                            <strong id="auditTotalSub">₹1,95,297</strong>
                        </div>
                        <div class="ws-inv-tot-row">
                            <span>Total GST ITC (5%):</span>
                            <strong id="auditTotalTax" style="color:#10B981;">₹10,253</strong>
                        </div>
                        <div class="ws-inv-tot-row grand">
                            <span>Total Settled Procurement:</span>
                            <span id="auditTotalGrand">₹2,05,062</span>
                        </div>
                    </div>

                    <div class="ws-inv-footer-note">
                        <div>
                            <p>Certified B2B wholesale statement generated for statutory tax filing & ledger accounting.</p>
                            <p>All textiles dispatched comply with Surat Silk Weaver Guild certified standards.</p>
                        </div>
                        <div style="text-align:center;">
                            <div style="width:120px; border-bottom:1.5px solid var(--ws-gold-primary); margin-bottom:4px;"></div>
                            <strong>Chief Logistics Officer</strong><br>
                            Kalaniketan B2B Hub
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         MODAL 2.7: FULL B2B WHOLESALE GOLD WALLET & PASSBOOK
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsFullWalletModal" role="dialog" aria-modal="true">
        <div class="ws-modal-box" style="max-width: 640px;">
            <div class="ws-modal-header">
                <div style="display:flex; align-items:center; gap:8px;">
                    <button class="ws-modal-close-btn" onclick="closeFullWalletModal()" aria-label="Back" title="Back" style="width:30px; height:30px;">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    </button>
                    <h3 class="ws-modal-title" style="margin:0; font-size:0.95rem;">
                        <span>Gold Wallet & Passbook</span>
                    </h3>
                </div>
                <button class="ws-modal-close-btn" onclick="closeFullWalletModal()" aria-label="Close Modal" style="width:30px; height:30px;">&times;</button>
            </div>
            <div class="ws-modal-body">
                <!-- Dual Balance Cards Grid -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:14px;">
                    <!-- Available Balance Card -->
                    <div class="ws-full-wallet-card">
                        <div class="ws-full-card-top">
                            <div class="ws-full-card-badge">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7z"></path><path d="M15 10h5a2 2 0 0 1 2 2v0a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2v0a2 2 0 0 1 2-2z"></path><circle cx="18" cy="12" r="1"></circle></svg>
                                <span>Available Balance</span>
                            </div>
                            <span class="ws-full-card-pill">Active</span>
                        </div>
                        <div class="ws-full-card-val" id="fullModalWalletBal">₹1,45,280</div>
                    </div>

                    <!-- Silk Reward Coins Card -->
                    <div class="ws-full-wallet-card coin">
                        <div class="ws-full-card-top">
                            <div class="ws-full-card-badge coin">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none"><circle cx="12" cy="12" r="9" fill="#F59E0B" stroke="#D97706" stroke-width="1.2"></circle><circle cx="12" cy="12" r="6.5" stroke="#FFFFFF" stroke-dasharray="2 1" stroke-width="0.8"></circle><path d="M10 8h4M10 11h3.5M10 8v8M12.5 11c1.4 0 1.8 1 1.8 1.8s-.4 1.8-1.8 1.8h-2.5" stroke="#78350F" stroke-width="1.3" stroke-linecap="round"></path></svg>
                                <span>Silk Coins</span>
                            </div>
                            <span class="ws-full-card-pill coin">50 Coins = ₹1</span>
                        </div>
                        <div class="ws-full-card-val gold" id="fullModalCoinsBal">3,850 Coins</div>
                        <div class="ws-full-card-sub">Worth <strong>₹77</strong> Cash Discount</div>
                    </div>
                </div>

                <!-- Passbook / Statement Table -->
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <h4 style="font-size:0.86rem; font-weight:800; color:var(--ws-text-main); margin:0; font-family:var(--ws-font-serif); display:flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="var(--ws-gold-primary)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>Recent Passbook Transactions</span>
                    </h4>
                </div>
                <div style="border:1.5px solid var(--ws-border); border-radius:10px; overflow:hidden; background:#FFFFFF; box-shadow:0 2px 8px rgba(0,0,0,0.03);">
                    <!-- Row 1: RTGS Top-Up -->
                    <div class="ws-txn-row">
                        <div class="ws-txn-icon-wrap green">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                        </div>
                        <div class="ws-txn-info">
                            <strong>Wallet Top-Up (RTGS)</strong>
                            <span>14 Aug 2026, 11:20 AM • UTR #RTGS992104</span>
                        </div>
                        <div class="ws-txn-amt">
                            <strong style="color:#15803D;">+₹50,000</strong>
                            <span class="ws-txn-badge green">Credited</span>
                        </div>
                    </div>

                    <!-- Row 2: Order Deduction -->
                    <div class="ws-txn-row">
                        <div class="ws-txn-icon-wrap red">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="19" x2="12" y2="5"></line><polyline points="5 12 12 5 19 12"></polyline></svg>
                        </div>
                        <div class="ws-txn-info">
                            <strong>Order Deduction #KLN-WS-8021</strong>
                            <span>14 Aug 2026, 10:30 AM • 12 Pcs Silk Lot</span>
                        </div>
                        <div class="ws-txn-amt">
                            <strong style="color:#DC2626;">-₹38,308</strong>
                            <span class="ws-txn-badge red">Debited</span>
                        </div>
                    </div>

                    <!-- Row 3: Cashback Coins -->
                    <div class="ws-txn-row">
                        <div class="ws-txn-icon-wrap amber">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"></circle><path d="M12 6v12M15 9.5a2.5 2.5 0 0 0-5 0c0 2.5 5 1.5 5 4a2.5 2.5 0 0 1-5 0"></path></svg>
                        </div>
                        <div class="ws-txn-info">
                            <strong>Silk Cashback Coins Reward</strong>
                            <span>12 Aug 2026, 04:15 PM • Volume Order Bonus</span>
                        </div>
                        <div class="ws-txn-amt">
                            <strong style="color:#D97706;">+500 Coins</strong>
                            <span class="ws-txn-badge amber">Earned</span>
                        </div>
                    </div>

                    <!-- Row 4: Settlement -->
                    <div class="ws-txn-row">
                        <div class="ws-txn-icon-wrap blue">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        </div>
                        <div class="ws-txn-info">
                            <strong>Consignment Advance Settlement</strong>
                            <span>10 Aug 2026, 02:00 PM • Credit Line Release</span>
                        </div>
                        <div class="ws-txn-amt">
                            <strong style="color:#1D4ED8;">+₹1,00,000</strong>
                            <span class="ws-txn-badge blue">Restored</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ws-modal-footer" style="display:grid; grid-template-columns:1fr 1fr; gap:10px; padding:12px 16px; background:#FFFFFF; border-top:1.5px solid var(--ws-border);">
                <!-- Button 1: Download Statement -->
                <button class="ws-btn ws-btn-primary" style="height:42px; justify-content:center; font-size:0.78rem; font-weight:800; padding:0 10px;" onclick="window.showWsToast('📄 Full GSTR Passbook Statement downloaded (PDF)!')">
                    <svg class="ws-anim-dl-icon" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Download Statement</span>
                </button>

                <!-- Button 2: Withdraw Balance -->
                <button class="ws-btn ws-btn-secondary" style="height:42px; justify-content:center; font-size:0.78rem; font-weight:800; padding:0 10px; border:1.5px solid rgba(197, 168, 89, 0.6); color:var(--ws-gold-primary); background:linear-gradient(135deg, #FFFFFF 0%, #FEF3C7 100%);" onclick="requestWalletWithdrawal()">
                    <svg class="ws-anim-withdraw-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><rect x="2" y="4" width="20" height="16" rx="2"></rect><path d="M12 9v6M9 12h6"></path><path d="M16 8l3-3M19 8V5h-3"></path></svg>
                    <span>Withdraw Balance</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         MODAL 2.75: VIP TIER ROADMAP & BENEFITS
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsVipTierModal" role="dialog" aria-modal="true">
        <div class="ws-modal-box" style="max-width: 540px;">
            <div class="ws-modal-header">
                <div style="display:flex; align-items:center; gap:6px;">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none"><path d="M2 4l3 12h14l3-12-6 7-4-7-4 7-6-7z" fill="#D4AF37" stroke="#92400E" stroke-width="1.2" stroke-linejoin="round"></path><circle cx="12" cy="3" r="1.5" fill="#F59E0B"></circle><circle cx="4" cy="4" r="1.2" fill="#F59E0B"></circle><circle cx="20" cy="4" r="1.2" fill="#F59E0B"></circle></svg>
                    <h3 class="ws-modal-title" style="margin:0; font-size:0.92rem; font-weight:800;">
                        <span>VIP Account Tier Roadmap</span>
                    </h3>
                </div>
                <button class="ws-modal-close-btn" onclick="closeVipTierModal()" aria-label="Close Modal" style="width:28px; height:28px;">&times;</button>
            </div>
            <div class="ws-modal-body" style="padding:14px 16px;">
                <!-- Current Active Tier Card -->
                <div style="background:linear-gradient(135deg, #FFFFFF 0%, #FEFAF0 100%); border:1.5px solid rgba(212,175,55,0.55); border-radius:12px; padding:12px 14px; margin-bottom:12px; box-shadow:0 4px 14px rgba(180,140,40,0.08);">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                        <span style="font-size:0.65rem; font-weight:800; text-transform:uppercase; color:#8A681F; letter-spacing:0.5px;">Current Active Tier</span>
                        <span class="ws-txn-badge green" style="font-size:0.58rem; font-weight:800;">6 / 50 Orders Completed</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none"><circle cx="12" cy="12" r="9" fill="#10B981" fill-opacity="0.15" stroke="#10B981" stroke-width="1.5"></circle><path d="M9 12l2 2 4-4" stroke="#10B981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        <div style="font-size:1.15rem; font-weight:900; color:#16130F; letter-spacing:0.2px;">
                            Tier 1: Non-VIP
                        </div>
                    </div>
                    <div style="font-size:0.72rem; color:#57534E; margin-bottom:8px; line-height:1.3;">
                        Complete <strong>44 more orders</strong> to automatically unlock <strong>Tier 2: Silver</strong> with a extra margin rebate!
                    </div>
                    <!-- Progress Bar -->
                    <div style="height:6px; background:#F1ECE1; border-radius:4px; overflow:hidden;">
                        <div style="height:100%; width:12%; background:linear-gradient(90deg, #10B981, #059669); border-radius:4px;"></div>
                    </div>
                </div>

                <!-- 5-Tier Level Cards List with Real Vector SVGs -->
                <div style="display:flex; flex-direction:column; gap:8px;">
                    <!-- Tier 1: Non VIP -->
                    <div class="ws-tier-card active">
                        <div class="ws-tier-card-left">
                            <div class="ws-tier-icon-wrap green">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#15803D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            </div>
                            <div class="ws-tier-info">
                                <strong>Tier 1: Non-VIP (1 to 50 Orders)</strong>
                            </div>
                        </div>
                        <span class="ws-tier-badge active">ACTIVE</span>
                    </div>

                    <!-- Tier 2: Silver (50 to 250 Orders) -->
                    <div class="ws-tier-card">
                        <div class="ws-tier-card-left">
                            <div class="ws-tier-icon-wrap silver">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none"><circle cx="12" cy="12" r="9" fill="#94A3B8" fill-opacity="0.2" stroke="#64748B" stroke-width="1.5"></circle><polygon points="12 6 13.8 9.6 17.8 10.2 14.9 13 15.6 17 12 15.1 8.4 17 9.1 13 6.2 10.2 10.2 9.6" fill="#64748B"></polygon></svg>
                            </div>
                            <div class="ws-tier-info">
                                <strong>Tier 2: Silver (50 to 250 Orders)</strong>
                            </div>
                        </div>
                        <span class="ws-tier-badge silver">50–250 ORDERS</span>
                    </div>

                    <!-- Tier 3: Gold (250 to 450 Orders) -->
                    <div class="ws-tier-card">
                        <div class="ws-tier-card-left">
                            <div class="ws-tier-icon-wrap gold">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none"><circle cx="12" cy="12" r="9" fill="#F59E0B" fill-opacity="0.2" stroke="#D97706" stroke-width="1.5"></circle><path d="M7 15l2-6 3 3 3-3 2 6H7z" fill="#D97706"></path><circle cx="12" cy="7" r="1.5" fill="#B45309"></circle></svg>
                            </div>
                            <div class="ws-tier-info">
                                <strong>Tier 3: Gold (250 to 450 Orders)</strong>
                            </div>
                        </div>
                        <span class="ws-tier-badge gold">250–450 ORDERS</span>
                    </div>

                    <!-- Tier 4: Diamond (450 to 800 Orders) -->
                    <div class="ws-tier-card">
                        <div class="ws-tier-card-left">
                            <div class="ws-tier-icon-wrap diamond">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none"><polygon points="6 3 18 3 22 9 12 22 2 9" stroke="#0284C7" stroke-width="1.5" fill="#38BDF8" fill-opacity="0.3"></polygon><line x1="2" y1="9" x2="22" y2="9" stroke="#0284C7" stroke-width="1.2"></line><line x1="12" y1="22" x2="6" y2="9" stroke="#0284C7" stroke-width="1.2"></line><line x1="12" y1="22" x2="18" y2="9" stroke="#0284C7" stroke-width="1.2"></line></svg>
                            </div>
                            <div class="ws-tier-info">
                                <strong>Tier 4: Diamond (450 to 800 Orders)</strong>
                            </div>
                        </div>
                        <span class="ws-tier-badge diamond">450–800 ORDERS</span>
                    </div>

                    <!-- Tier 5: Platinum Smart (800+ Orders) -->
                    <div class="ws-tier-card" style="background:linear-gradient(135deg, #FFFDF7 0%, #FDF7E7 100%); border-color:rgba(212,175,55,0.6);">
                        <div class="ws-tier-card-left">
                            <div class="ws-tier-icon-wrap platinum">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none"><polygon points="12 2 2 9 12 22 22 9" stroke="#D4AF37" stroke-width="1.5" fill="#F59E0B" fill-opacity="0.3"></polygon><line x1="2" y1="9" x2="22" y2="9" stroke="#D4AF37" stroke-width="1.2"></line><line x1="12" y1="22" x2="12" y2="22" stroke="#D4AF37" stroke-width="1.2"></line></svg>
                            </div>
                            <div class="ws-tier-info">
                                <strong style="color:#8A681F;">Tier 5: Platinum Smart (800+ Orders)</strong>
                            </div>
                        </div>
                        <span class="ws-tier-badge platinum">TOP TIER (800+)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         MODAL 2.8: WHOLESALE WALLET TOP-UP & RECHARGE
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsWalletTopupModal" role="dialog" aria-modal="true">
        <div class="ws-modal-box" style="max-width: 480px;">
            <div class="ws-modal-header">
                <h3 class="ws-modal-title">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="var(--ws-gold-primary)" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><rect x="2" y="5" width="20" height="14" rx="3"></rect><line x1="2" y1="10" x2="22" y2="10"></line></svg>
                    <span>Top-Up B2B Prepaid Wallet</span>
                </h3>
                <button class="ws-modal-close-btn" onclick="closeWalletTopupModal()" aria-label="Close Modal">&times;</button>
            </div>
            <div class="ws-modal-body">
                <div style="background:#FAF8F4; border:1.5px solid var(--ws-gold-border); border-radius:10px; padding:14px; margin-bottom:16px;">
                    <div style="font-size:0.72rem; color:var(--ws-text-muted); text-transform:uppercase; font-weight:700;">Current Available Cash Balance</div>
                    <div style="font-size:1.35rem; font-weight:900; color:var(--ws-gold-primary); font-family:var(--ws-font-serif); margin-top:2px;" id="modalCurrentWalletBal">₹45,280</div>
                </div>

                <label class="ws-label">Select Instant Top-Up Amount</label>
                <div style="display:grid; grid-template-columns:repeat(2, 1fr); gap:8px; margin-bottom:14px;">
                    <button type="button" class="ws-btn ws-btn-secondary" onclick="setTopupAmount(25000, this)">+ ₹25,000</button>
                    <button type="button" class="ws-btn ws-btn-secondary active" onclick="setTopupAmount(50000, this)">+ ₹50,000 (Popular)</button>
                    <button type="button" class="ws-btn ws-btn-secondary" onclick="setTopupAmount(100000, this)">+ ₹1,00,000</button>
                    <button type="button" class="ws-btn ws-btn-secondary" onclick="setTopupAmount(250000, this)">+ ₹2,50,000</button>
                </div>

                <div class="ws-form-group">
                    <label class="ws-label" for="wsTopupAmountInput">Or Enter Custom Amount (₹) <span class="req">*</span></label>
                    <input type="number" id="wsTopupAmountInput" class="ws-input" value="50000" min="5000" step="1000" required>
                </div>

                <div class="ws-form-group">
                    <label class="ws-label">Payment Channel</label>
                    <div style="display:flex; flex-direction:column; gap:6px;">
                        <label style="display:flex; align-items:center; gap:8px; font-size:0.82rem; color:var(--ws-text-main); cursor:pointer;">
                            <input type="radio" name="topupChannel" value="rtgs" checked>
                            <strong>Instant RTGS / NEFT / Net Banking (No Charges)</strong>
                        </label>
                        <label style="display:flex; align-items:center; gap:8px; font-size:0.82rem; color:var(--ws-text-main); cursor:pointer;">
                            <input type="radio" name="topupChannel" value="upi">
                            <strong>Corporate UPI QR (Instant Credit)</strong>
                        </label>
                    </div>
                </div>
            </div>
            <div class="ws-modal-footer">
                <button class="ws-btn ws-btn-primary" style="width:100%; height:42px; font-weight:800; justify-content:center;" onclick="handleProcessWalletTopup()">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#FFFFFF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Proceed to Secure Top-Up</span>
                </button>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         MODAL 3: ROLE GATE ACCESS CONTROL
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsRoleGateModal" role="dialog" aria-modal="true">
        <div class="ws-modal-box" style="max-width: 440px;">
            <div class="ws-gate-box">
                <div class="ws-gate-icon">
                    <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                </div>
                <h3>Wholesaler Authentication Gate</h3>
                <p>This portal is exclusively authorized for verified <strong>Wholesaler B2B Members</strong>. Please sign in with your registered wholesaler account to access bulk tier pricing, order tracking, and GST invoicing.</p>
                
                <div style="display:flex; flex-direction:column; gap:10px;">
                    <button class="ws-btn ws-btn-primary" onclick="loginAsDemoWholesaler()">
                        👑 Continue as Verified Wholesaler
                    </button>
                    <a href="myaccount.php?tab=login" class="ws-btn ws-btn-secondary">
                        Sign In with Other Account
                    </a>
                    <a href="shop.php" style="font-size:0.78rem; color:var(--ws-text-muted); text-decoration:none; margin-top:4px;">
                        ← Return to Retail Store
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════
         MODAL 4: INTERACTIVE DATE RANGE CALENDAR PICKER
    ═══════════════════════════════════════════ -->
    <div class="ws-modal-overlay" id="wsDateRangeModal" role="dialog" aria-modal="true" style="z-index: 2100000;">
        <div class="ws-modal-box" style="max-width: 480px;">
            <div class="ws-modal-header">
                <div class="ws-modal-title">
                    <svg class="ws-ico gold" style="width:18px;height:18px;margin-right:6px;" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    Filter Analytics Date Range
                </div>
                <button class="ws-modal-close-btn" onclick="closeDateRangeModal()" aria-label="Close">✕</button>
            </div>
            <div class="ws-modal-body" style="padding: 16px 20px;">
                <div style="font-size:0.78rem; font-weight:700; color:var(--ws-text-muted); text-transform:uppercase; letter-spacing:0.05em; margin-bottom:8px;">
                    Quick Presets:
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px;" id="datePresetButtons">
                    <button class="ws-btn ws-btn-secondary" style="justify-content: space-between; padding: 10px 14px; font-size: 0.84rem;" onclick="applyDatePreset('today', 'Today (16 Aug)')">
                        <span><svg class="ws-ico gold ws-ico-sm" style="margin-right:5px;" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg> <strong>Today</strong></span>
                        <span style="font-size:0.74rem; color:var(--ws-text-muted);">16 Aug 2026</span>
                    </button>
                    <button class="ws-btn ws-btn-primary" style="justify-content: space-between; padding: 10px 14px; font-size: 0.84rem;" onclick="applyDatePreset('week', 'Aug 10 - Aug 16')">
                        <span><svg class="ws-ico gold ws-ico-sm" style="margin-right:5px;" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> <strong>This Week</strong></span>
                        <span style="font-size:0.74rem; color:var(--ws-gold-light);">10 Aug – 16 Aug 2026 (Live)</span>
                    </button>
                    <button class="ws-btn ws-btn-secondary" style="justify-content: space-between; padding: 10px 14px; font-size: 0.84rem;" onclick="applyDatePreset('month', 'Aug 01 - Aug 31')">
                        <span><svg class="ws-ico gold ws-ico-sm" style="margin-right:5px;" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg> <strong>This Month</strong></span>
                        <span style="font-size:0.74rem; color:var(--ws-text-muted);">August 2026 (Full Month)</span>
                    </button>
                    <button class="ws-btn ws-btn-secondary" style="justify-content: space-between; padding: 10px 14px; font-size: 0.84rem;" onclick="applyDatePreset('last_month', 'Jul 01 - Jul 31')">
                        <span><svg class="ws-ico gold ws-ico-sm" style="margin-right:5px;" viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg> <strong>Last Month</strong></span>
                        <span style="font-size:0.74rem; color:var(--ws-text-muted);">July 2026 (Reconciled)</span>
                    </button>
                    <button class="ws-btn ws-btn-secondary" style="justify-content: space-between; padding: 10px 14px; font-size: 0.84rem;" onclick="applyDatePreset('year', 'FY 2026-27')">
                        <span><svg class="ws-ico gold ws-ico-sm" style="margin-right:5px;" viewBox="0 0 24 24"><polygon points="2 4 5 18 19 18 22 4 16 11 12 2 8 11 2 4"></polygon></svg> <strong>Financial Year</strong></span>
                        <span style="font-size:0.74rem; color:var(--ws-text-muted);">FY 2026-27 (Q1 & Q2)</span>
                    </button>
                </div>

                <!-- Custom Calendar Date Pickers -->
                <div style="margin-top: 14px; padding-top: 12px; border-top: 1px solid var(--ws-border);">
                    <div style="font-size: 0.78rem; font-weight: 700; color: var(--ws-text-main); margin-bottom: 8px;">
                        Custom Calendar Range:
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                        <div>
                            <label style="font-size: 0.70rem; font-weight:600; color: var(--ws-text-muted); display: block; margin-bottom: 3px;">Start Date</label>
                            <input type="date" id="customStartDate" value="2026-08-10" class="ws-input" style="height: 38px; font-size: 0.80rem;">
                        </div>
                        <div>
                            <label style="font-size: 0.70rem; font-weight:600; color: var(--ws-text-muted); display: block; margin-bottom: 3px;">End Date</label>
                            <input type="date" id="customEndDate" value="2026-08-16" class="ws-input" style="height: 38px; font-size: 0.80rem;">
                        </div>
                    </div>
                    <button class="ws-btn ws-btn-primary" style="width: 100%; margin-top: 10px; height: 38px; font-size: 0.82rem;" onclick="applyCustomDateRange()">
                        <svg class="ws-ico" style="stroke:#FFFFFF;margin-right:4px;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg> Apply Calendar Filter
                    </button>
                </div>
            </div>
            <div class="ws-modal-footer">
                <button class="ws-btn ws-btn-secondary ws-btn-full" onclick="closeDateRangeModal()">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- ── Toast Notifications ── -->
    <div class="ws-toast-container" id="wsToastContainer"></div>


    <!-- ═══════════════════════════════════════════
         JAVASCRIPT CONTROLLER & STATE ENGINE
    ═══════════════════════════════════════════ -->
    <script>
    (function() {
        'use strict';

        /* ── Wholesale Initial Sample Orders Data ── */
        var SAMPLE_ORDERS = [
            {
                id: 'KLN-WS-8021',
                date: '14 Aug 2026',
                status: 'Shipped',
                productName: 'Nilambari Silk Saree (Pack of 12)',
                sku: 'KLN-SR-001',
                hsn: '5007',
                image: 'images/product1.png',
                qty: 12,
                unitPrice: 3199,
                subtotal: 38388,
                tax: 1920,
                discount: 2000,
                total: 38308,
                payment: 'Bank NEFT / RTGS (Paid)',
                courier: 'BlueDart Express',
                awb: '884729104',
                color: 'Navy Blue (Lot Assorted)',
                size: 'Free Size'
            },
            {
                id: 'KLN-WS-7914',
                date: '10 Aug 2026',
                status: 'Delivered',
                productName: 'Banarasi Zari Saree (Pack of 8)',
                sku: 'KLN-SR-002',
                hsn: '5007',
                image: 'images/product2.png',
                qty: 8,
                unitPrice: 5499,
                subtotal: 43992,
                tax: 2200,
                discount: 3000,
                total: 43192,
                payment: 'UPI on WhatsApp (Paid)',
                courier: 'Delhivery Surface',
                awb: 'DLV9928174',
                color: 'Maroon & Deep Wine',
                size: 'Free Size'
            },
            {
                id: 'KLN-WS-6540',
                date: '02 Aug 2026',
                status: 'Delivered',
                productName: 'Kanjivaram Temple Silk (Pack of 6)',
                sku: 'KLN-SR-003',
                hsn: '5007',
                image: 'images/product3.png',
                qty: 6,
                unitPrice: 8499,
                subtotal: 50994,
                tax: 2550,
                discount: 4000,
                total: 49544,
                payment: 'Bank NEFT / RTGS (Paid)',
                courier: 'DTDC Priority Cargo',
                awb: 'DTDC773819',
                color: 'Golden Ochre',
                size: 'Free Size'
            },
            {
                id: 'KLN-WS-5912',
                date: '26 Jul 2026',
                status: 'Delivered',
                productName: 'Royal Anarkali Kurti Sets (Pack of 10)',
                sku: 'KLN-KT-005',
                hsn: '6204',
                image: 'images/product5.png',
                qty: 10,
                unitPrice: 1799,
                subtotal: 17990,
                tax: 900,
                discount: 1000,
                total: 17890,
                payment: 'Cash on Delivery (COD)',
                courier: 'BlueDart Express',
                awb: 'BLU6619283',
                color: 'Teal & Emerald Assorted',
                size: 'S, M, L, XL'
            },
            {
                id: 'KLN-WS-4810',
                date: '18 Jul 2026',
                status: 'Processing',
                productName: 'Bridal Zardosi Velvet Lehenga (Pack of 2)',
                sku: 'KLN-LH-006',
                hsn: '6204',
                image: 'images/product6.png',
                qty: 2,
                unitPrice: 16499,
                subtotal: 32998,
                tax: 1650,
                discount: 2000,
                total: 32648,
                payment: 'Advance 50% Deposit (Paid)',
                courier: 'Hand Craft Weaving Unit',
                awb: 'WEAVE-SRT-09',
                color: 'Crimson Red',
                size: 'Custom Tailored'
            },
            {
                id: 'KLN-WS-3120',
                date: '08 Jul 2026',
                status: 'Returned',
                productName: 'Georgette Bloom Saree (Pack of 10)',
                sku: 'KLN-SR-004',
                hsn: '5407',
                image: 'images/product4.png',
                qty: 10,
                unitPrice: 2199,
                subtotal: 21990,
                tax: 1100,
                discount: 1500,
                total: 21590,
                payment: 'Refunded (₹21,590 credited)',
                courier: 'Return Pickup Completed',
                awb: 'RET99381',
                color: 'Peach Bloom',
                size: 'Free Size'
            }
        ];

        /* ── Sample Support Tickets ── */
        var SAMPLE_TICKETS = [
            {
                id: 'TCK-892',
                orderId: 'KLN-WS-8021',
                category: 'Logistics & Dispatch Inquiry',
                status: 'In Progress',
                message: 'Kindly ensure dispatch before Thursday for Surat wedding exhibition lot.',
                date: '14 Aug 2026'
            },
            {
                id: 'TCK-814',
                orderId: 'KLN-WS-7914',
                category: 'GST Input Tax Credit Query',
                status: 'Resolved',
                message: 'Received GSTR-1 invoice reflection in portal. Thank you for prompt assistance.',
                date: '11 Aug 2026'
            }
        ];

        var activeOrdersList = [];
        var activeTicketsList = [];
        var activeGstMode = 'gst';
        var currentOrderStatusFilter = 'all';

        /* ── Toast Helper ── */
        window.showWsToast = function(msg) {
            var container = document.getElementById('wsToastContainer');
            if (!container) return;
            var t = document.createElement('div');
            t.className = 'ws-toast';
            t.innerHTML = '<span>✨</span> ' + msg;
            container.appendChild(t);
            setTimeout(function() {
                t.style.opacity = '0';
                t.style.transform = 'translateY(-10px)';
                setTimeout(function() { t.remove(); }, 300);
            }, 3200);
        };

        /* ── Role & Authentication Security Gate ── */
        function checkWholesalerSecurity() {
            var userRaw = localStorage.getItem('kalaniketan_user');
            var gateModal = document.getElementById('wsRoleGateModal');

            if (!userRaw) {
                if (gateModal) gateModal.classList.add('active');
                return false;
            }

            try {
                var user = JSON.parse(userRaw);
                var role = (user.role || '').toLowerCase();
                
                // Only allow wholesaler role
                if (role !== 'wholesaler') {
                    if (gateModal) gateModal.classList.add('active');
                    return false;
                }

                if (gateModal) gateModal.classList.remove('active');
                return true;
            } catch(e) {
                if (gateModal) gateModal.classList.add('active');
                return false;
            }
        }

        window.loginAsDemoWholesaler = function() {
            var demoWholesaler = {
                name: 'Rajesh Kumar',
                companyName: 'Shree Krishna Silks Pvt Ltd',
                phone: '+91 98765 43210',
                rawPhone: '9876543210',
                email: 'rajesh@shreekrishnasilks.com',
                role: 'Wholesaler',
                gst_type: 'gst',
                gst_number: '24AABCU9603R1ZM',
                address: 'Shop No. 402, 4th Floor, Millennium Textile Market 2, Ring Road',
                city: 'Surat',
                state: 'Gujarat',
                pincode: '395002'
            };
            localStorage.setItem('kalaniketan_user', JSON.stringify(demoWholesaler));
            var gateModal = document.getElementById('wsRoleGateModal');
            if (gateModal) gateModal.classList.remove('active');
            initWholesalerApp();
            window.showWsToast('👑 Logged in as Verified Wholesaler (Rajesh Kumar)!');
        };

        /* ── Tab Navigation Controller ── */
        window.switchWsTab = function(tabName) {
            document.querySelectorAll('.ws-nav-item').forEach(function(el) {
                el.classList.remove('active');
            });
            document.querySelectorAll('.ws-tab-pane').forEach(function(el) {
                el.classList.remove('active');
            });
            document.querySelectorAll('.ws-dock-btn').forEach(function(el) {
                el.classList.remove('active');
            });

            var targetPaneId = 'tabPane' + tabName.charAt(0).toUpperCase() + tabName.slice(1);
            var targetPane = document.getElementById(targetPaneId);
            if (targetPane) targetPane.classList.add('active');

            // Sidebar highlight
            var items = document.querySelectorAll('.ws-nav-item');
            items.forEach(function(btn) {
                if (btn.getAttribute('onclick') && btn.getAttribute('onclick').includes(tabName)) {
                    btn.classList.add('active');
                }
            });

            // Mobile dock highlight
            var dockBtn = document.getElementById('dockBtn' + tabName.charAt(0).toUpperCase() + tabName.slice(1));
            if (dockBtn) dockBtn.classList.add('active');

            // Auto close mobile drawer
            toggleSidebar(false);

            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };

        /* ── Mobile Sidebar Drawer ── */
        window.toggleSidebar = function(force) {
            var sidebar = document.getElementById('wsSidebar');
            var backdrop = document.getElementById('wsSidebarBackdrop');
            if (!sidebar || !backdrop) return;

            var shouldOpen = (typeof force === 'boolean') ? force : !sidebar.classList.contains('open');
            sidebar.classList.toggle('open', shouldOpen);
            backdrop.classList.toggle('active', shouldOpen);
        };

        /* ── Load Wholesaler Profile & State ── */
        window.loadSavedWholesalerData = function() {
            var userRaw = localStorage.getItem('kalaniketan_user');
            var user = userRaw ? JSON.parse(userRaw) : {};

            var name = user.name || 'Rajesh Kumar';
            var company = user.companyName || 'Shree Krishna Silks Pvt Ltd';
            var phone = user.rawPhone || (user.phone ? user.phone.replace(/[^0-9]/g, '').slice(-10) : '9876543210');
            var email = user.email || 'rajesh@shreekrishnasilks.com';
            var gstType = user.gst_type || 'gst';
            var gstNum = user.gst_number || '24AABCU9603R1ZM';
            var address = user.address || 'Shop No. 402, 4th Floor, Millennium Textile Market 2, Ring Road';
            var city = user.city || 'Surat';
            var state = user.state || 'Gujarat';
            var pincode = user.pincode || '395002';

            var hdrName = document.getElementById('headerUserName');
            if (hdrName) hdrName.textContent = name;

            // Populate My Details form
            var profName = document.getElementById('wsProfName');
            var profPhone = document.getElementById('wsProfPhone');
            var profEmail = document.getElementById('wsProfEmail');
            if (profName) profName.value = name;
            if (profPhone) profPhone.value = phone;
            if (profEmail) profEmail.value = email;

            // Populate GST form
            selectGstMode(gstType);
            var compEl = document.getElementById('wsCompanyName');
            var gstEl = document.getElementById('wsGstNumber');
            if (compEl) compEl.value = company;
            if (gstEl) gstEl.value = gstNum;

            // Populate Address form
            var addrEl = document.getElementById('wsFullAddress');
            var cityEl = document.getElementById('wsCity');
            var stateEl = document.getElementById('wsStateSelect');
            var pinEl = document.getElementById('wsPincode');
            if (addrEl) addrEl.value = address;
            if (cityEl) cityEl.value = city;
            if (stateEl) stateEl.value = state;
            if (pinEl) pinEl.value = pincode;
        };

        /* ── GST Mode Toggle ── */
        window.selectGstMode = function(mode) {
            activeGstMode = mode;
            var cardGst = document.getElementById('gstCardGst');
            var cardNonGst = document.getElementById('gstCardNonGst');
            var compFieldWrap = document.getElementById('wsCompanyNameFieldWrap');
            var gstNumberWrap = document.getElementById('gstNumberFieldWrap');
            var nonGstNoticeWrap = document.getElementById('nonGstNoticeWrap');
            var compInput = document.getElementById('wsCompanyName');
            var gstInput = document.getElementById('wsGstNumber');

            if (mode === 'gst') {
                if (cardGst) cardGst.classList.add('selected');
                if (cardNonGst) cardNonGst.classList.remove('selected');
                if (compFieldWrap) compFieldWrap.style.display = 'flex';
                if (gstNumberWrap) gstNumberWrap.style.display = 'flex';
                if (nonGstNoticeWrap) nonGstNoticeWrap.style.display = 'none';
                if (compInput) compInput.required = true;
                if (gstInput) gstInput.required = true;
            } else {
                if (cardGst) cardGst.classList.remove('selected');
                if (cardNonGst) cardNonGst.classList.add('selected');
                if (compFieldWrap) compFieldWrap.style.display = 'none';
                if (gstNumberWrap) gstNumberWrap.style.display = 'none';
                if (nonGstNoticeWrap) nonGstNoticeWrap.style.display = 'block';
                if (compInput) compInput.required = false;
                if (gstInput) gstInput.required = false;
            }
        };

        /* ── Indian GSTIN Validation ── */
        window.validateGstinInput = function(input) {
            var val = input.value.toUpperCase().replace(/[^0-9A-Z]/g, '');
            input.value = val;
            var stateTag = document.getElementById('gstStateDetectTag');

            var stateMap = {
                '01': 'Jammu & Kashmir', '02': 'Himachal Pradesh', '03': 'Punjab', '04': 'Chandigarh',
                '05': 'Uttarakhand', '06': 'Haryana', '07': 'Delhi', '08': 'Rajasthan',
                '09': 'Uttar Pradesh', '10': 'Bihar', '18': 'Assam', '19': 'West Bengal',
                '20': 'Jharkhand', '21': 'Odisha', '22': 'Chhattisgarh', '23': 'Madhya Pradesh',
                '24': 'Gujarat', '27': 'Maharashtra', '29': 'Karnataka', '30': 'Goa',
                '32': 'Kerala', '33': 'Tamil Nadu', '36': 'Telangana', '37': 'Andhra Pradesh'
            };

            if (val.length >= 2) {
                var prefix = val.substring(0, 2);
                var detectedState = stateMap[prefix];
                if (detectedState && stateTag) {
                    stateTag.textContent = '📍 State: ' + detectedState + ' (' + prefix + ')';
                }
            }
        };

        /* ── Render Orders Table & Mobile Cards ── */
        function getWsStatusBadgeHtml(status) {
            var s = (status || '').toLowerCase();
            if (s === 'delivered') {
                return `<span class="ws-status-badge delivered" style="display:inline-flex; align-items:center; gap:3px;"><svg style="width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg> DELIVERED</span>`;
            }
            if (s === 'shipped') {
                return `<span class="ws-status-badge shipped" style="display:inline-flex; align-items:center; gap:3px;"><svg style="width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><path d="M1 3h15v13H1z"></path><path d="M16 8h4l3 3v5h-7V8z"></path><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg> SHIPPED</span>`;
            }
            if (s === 'processing') {
                return `<span class="ws-status-badge processing" style="display:inline-flex; align-items:center; gap:3px;"><svg style="width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> PROCESSING</span>`;
            }
            return `<span class="ws-status-badge ${s}">${status}</span>`;
        }

        function renderOrdersView(orders) {
            var tbody = document.getElementById('wsOrdersTbody');
            var mobContainer = document.getElementById('wsMobileOrdersCards');
            var overviewContainer = document.getElementById('overviewOrdersContainer');

            if (!tbody || !mobContainer) return;

            tbody.innerHTML = '';
            mobContainer.innerHTML = '';

            if (orders.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:30px; color:#6B6358;">No matching wholesale orders found.</td></tr>';
                mobContainer.innerHTML = '<div style="text-align:center; padding:30px; color:#6B6358; font-weight:600;">No matching orders found.</div>';
                return;
            }

            orders.forEach(function(o) {
                var badgeHtml = getWsStatusBadgeHtml(o.status);

                // 1. Desktop Row
                var tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="ws-order-id-cell"><span style="font-weight:800; padding:2px 7px; background:#FAF8F4; border:1px solid rgba(212,175,55,0.3); border-radius:6px;">${o.id}</span></td>
                    <td style="color:#6B6358; font-weight:600; font-size:0.78rem;">${o.date}</td>
                    <td>
                        <div class="ws-prod-mini-cell">
                            <img src="${o.image}" alt="${o.productName}" class="ws-prod-mini-img" onerror="this.src='images/product1.png';">
                            <div>
                                <strong style="font-size:0.84rem; color:var(--ws-text-main); font-family:var(--ws-font-serif);">${o.productName}</strong>
                                <div style="font-size:0.72rem; color:var(--ws-text-muted);">SKU: ${o.sku} • ${o.courier}</div>
                            </div>
                        </div>
                    </td>
                    <td><strong style="font-size:0.84rem;">${o.qty} Pcs</strong></td>
                    <td><strong style="color:var(--ws-gold-primary); font-size:0.92rem;">₹${Number(o.total).toLocaleString('en-IN')}</strong></td>
                    <td>${badgeHtml}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <button class="ws-btn ws-btn-secondary ws-btn-sm" style="font-weight:700;" onclick='viewOrderDetails(${JSON.stringify(o)})'>
                                Details
                            </button>
                            <button class="ws-btn ws-btn-primary ws-btn-sm" style="font-weight:700;" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                                📄 Invoice
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);

                // 2. Mobile Card
                var card = document.createElement('div');
                card.className = 'ws-mob-order-card';
                card.innerHTML = `
                    <div class="ws-mob-order-top">
                        <span class="ws-order-id-cell" style="font-size:0.84rem; font-weight:800; padding:2px 7px; background:#FAF8F4; border:1px solid rgba(212,175,55,0.3); border-radius:6px;">${o.id}</span>
                        ${badgeHtml}
                    </div>
                    <div class="ws-mob-order-body">
                        <img src="${o.image}" alt="${o.productName}" class="ws-mob-order-img" onerror="this.src='images/product1.png';">
                        <div class="ws-mob-order-info">
                            <h4 class="ws-mob-order-title">${o.productName}</h4>
                            <div class="ws-mob-order-meta"><span style="color:#B45309; font-weight:700;">${o.date}</span> • Lot: <strong>${o.qty} Pcs</strong></div>
                            <div class="ws-mob-order-meta">${o.courier} (AWB: ${o.awb})</div>
                            <div class="ws-mob-order-price-row" style="margin-top:2px;">
                                <span class="ws-mob-order-price">₹${Number(o.total).toLocaleString('en-IN')}</span>
                            </div>
                        </div>
                    </div>
                    <div class="ws-mob-order-actions">
                        <button class="ws-btn ws-btn-secondary ws-btn-sm" style="font-weight:700; display:inline-flex; align-items:center; justify-content:center; gap:4px;" onclick='viewOrderDetails(${JSON.stringify(o)})'>
                            <svg style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> Details
                        </button>
                        <button class="ws-btn ws-btn-primary ws-btn-sm" style="font-weight:700; display:inline-flex; align-items:center; justify-content:center; gap:4px;" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                            <svg style="width:13px;height:13px;stroke:#FFFFFF;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg> GST Invoice
                        </button>
                    </div>
                `;
                mobContainer.appendChild(card);
            });

            // Populate Overview Recent Snapshot (First 3)
            if (overviewContainer) {
                overviewContainer.innerHTML = '';
                var recent3 = orders.slice(0, 3);
                var overList = document.createElement('div');
                overList.className = 'ws-mobile-order-cards';
                overList.style.display = 'flex';
                recent3.forEach(function(o) {
                    var badgeHtml = getWsStatusBadgeHtml(o.status);
                    var card = document.createElement('div');
                    card.className = 'ws-mob-order-card';
                    card.innerHTML = `
                        <div class="ws-mob-order-top">
                            <span class="ws-order-id-cell" style="font-size:0.84rem; font-weight:800; padding:2px 7px; background:#FAF8F4; border:1px solid rgba(212,175,55,0.3); border-radius:6px;">${o.id}</span>
                            ${badgeHtml}
                        </div>
                        <div class="ws-mob-order-body">
                            <img src="${o.image}" alt="${o.productName}" class="ws-mob-order-img" onerror="this.src='images/product1.png';">
                            <div class="ws-mob-order-info">
                                <h4 class="ws-mob-order-title">${o.productName}</h4>
                                <div class="ws-mob-order-meta"><span style="color:#B45309; font-weight:700;">${o.date}</span> • Lot: <strong>${o.qty} Pcs</strong></div>
                                <div class="ws-mob-order-meta">${o.courier} (AWB: ${o.awb})</div>
                                <div class="ws-mob-order-price-row" style="margin-top:6px; display:flex; justify-content:space-between; align-items:center;">
                                    <span class="ws-mob-order-price">₹${Number(o.total).toLocaleString('en-IN')}</span>
                                    <button class="ws-btn ws-btn-primary ws-btn-sm" style="font-weight:700; display:inline-flex; align-items:center; gap:4px;" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                                        <svg style="width:12px;height:12px;stroke:#FFFFFF;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg> GST Invoice
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    overList.appendChild(card);
                });
                overviewContainer.appendChild(overList);
            }
        }

        /* ── Helper: Get Tier ── */
        window.getWholesaleTier = function(ordersCount) {
            if (ordersCount >= 800) return { name: 'Tier 5', tag: 'PLATINUM', discount: '15%' };
            if (ordersCount >= 450) return { name: 'Tier 4', tag: 'DIAMOND', discount: '12.5%' };
            if (ordersCount >= 250) return { name: 'Tier 3', tag: 'GOLD', discount: '10%' };
            if (ordersCount >= 50) return { name: 'Tier 2', tag: 'SILVER', discount: '5%' };
            return { name: 'Tier 1', tag: 'NON VIP', discount: '0%' };
        };

        /* ── Helper: Open VIP Modal ── */
        window.openVipTierModal = function() {
            var modal = document.getElementById('wsVipTierModal');
            if (modal) modal.style.display = 'flex';
        };

        /* ── Filter Orders Controller ── */
        window.filterOrdersTable = function() {
            var input = document.getElementById('wsOrdersSearchInput');
            var search = (input ? input.value : '').toLowerCase().trim();
            var clearBtn = document.getElementById('wsOrdersSearchClear');
            if (clearBtn) clearBtn.style.display = search ? 'flex' : 'none';

            var filtered = activeOrdersList.filter(function(o) {
                var matchStatus = (currentOrderStatusFilter === 'all') || (o.status.toLowerCase() === currentOrderStatusFilter.toLowerCase());
                var matchSearch = !search || 
                    o.id.toLowerCase().includes(search) || 
                    o.productName.toLowerCase().includes(search) || 
                    o.courier.toLowerCase().includes(search) || 
                    o.awb.toLowerCase().includes(search);
                return matchStatus && matchSearch;
            });
            renderOrdersView(filtered);
        };

        window.clearOrdersSearch = function() {
            var input = document.getElementById('wsOrdersSearchInput');
            if (input) {
                input.value = '';
                input.focus();
            }
            var clearBtn = document.getElementById('wsOrdersSearchClear');
            if (clearBtn) clearBtn.style.display = 'none';
            filterOrdersTable();
        };

        window.setOrderStatusFilter = function(status, btn) {
            currentOrderStatusFilter = status;
            btn.parentElement.querySelectorAll('button').forEach(function(b) {
                b.classList.remove('active');
            });
            if (btn) btn.classList.add('active');
            filterOrdersTable();
        };

        /* ════════════════════════════════════════════════════
           ANALYTICS ENGINE: MODES (OVERVIEW/SALES/REVENUE) & DATE RANGES
        ════════════════════════════════════════════════════ */
        var analyticsMode = 'overview';
        var currentSelectedDateRange = 'week';

        var WS_ICONS = {
            calendar: '<svg class="ws-ico gold" style="margin-right:4px;" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
            dress: '<svg class="ws-ico gold" style="margin-right:5px;" viewBox="0 0 24 24"><path d="M20.38 3.46L16 2 12 5.5 8 2l-4.38 1.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"></path></svg>',
            lightning: '<svg class="ws-ico gold ws-ico-sm" style="margin-right:3px;" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>',
            target: '<svg class="ws-ico gold ws-ico-sm" style="margin-right:3px;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>',
            crown: '<svg class="ws-ico" style="width:13px;height:13px;margin-right:3px;stroke:#FFFFFF;" viewBox="0 0 24 24"><polygon points="2 4 5 18 19 18 22 4 16 11 12 2 8 11 2 4"></polygon></svg>',
            shield: '<svg class="ws-ico gold ws-ico-sm" style="margin-right:3px;" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>',
            repeat: '<svg class="ws-ico gold ws-ico-sm" style="margin-right:3px;" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg>',
            package: '<svg class="ws-ico" style="width:13px;height:13px;margin-right:3px;stroke:#FFFFFF;" viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>',
            card: '<svg class="ws-ico" style="width:13px;height:13px;margin-right:3px;stroke:#FFFFFF;" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>'
        };

        var ANALYTICS_DATA = {
            'overview': {
                'today': {
                    sub: "Today's Live Wholesale Snapshot & Dispatch Activity",
                    cards: [
                        { label: "B2B Account Tier", val: "Tier 1", pill: "Active", isGold: true },
                        { label: "Today's Orders", val: "1 Lot", pill: "Dispatched", isGold: false },
                        { label: "Today's Quantity", val: "6 Pcs", pill: "100% Packed", isGold: false },
                        { label: "Today's B2B Turnover", val: "₹18,200", pill: "↑ 100%", isGold: true }
                    ],
                    chartTitle: "Today's Hourly Procurement (Units)",
                    barActive: 7,
                    gauge: { pct: "36.4%", offset: 150, badge: "Today", desc: "You generated <strong>₹18,200</strong> in wholesale procurement today.", target: "₹50K", rev: "₹18.2K", today: "₹18.2K" },
                    catTitle: WS_ICONS.dress + " Today's Category Breakdown",
                    cats: [
                        { name: "Pure Silk & Zari Sarees (HSN 5007)", val: "₹18,200 (100%)", fill: 100 }
                    ],
                    kpis: [
                        { label: "Today's Order Value", num: "₹18,200", sub: WS_ICONS.lightning + " 1 Consignment" },
                        { label: "Dispatch Status", num: "In Transit", sub: "AWB: 884729104" },
                        { label: "Today's GST Credit", num: "₹910", sub: "5% GST" },
                        { label: "Delivery ETA", num: "Tomorrow", sub: "Priority Air" }
                    ],
                    milestoneBadge: "Tier 1: Non-VIP (Active)",
                    milestoneVal: "Tier 1: Non-VIP Member",
                    milestoneDesc: "Complete <strong>44 more orders</strong> to automatically unlock <strong>Tier 2: Silver</strong> with a extra margin rebate!"
                },
                'week': {
                    sub: "Weekly Procurement Targets, Category Mix & Logistics Performance",
                    cards: [
                        { label: "B2B Account Tier", val: "Tier 1", pill: "1–50 Orders", isGold: true },
                        { label: "Total Orders", val: "6", pill: "↑ 14.20%", isGold: false },
                        { label: "Total Quantity (Units)", val: "48 Pcs", pill: "↑ 8.50%", isGold: false },
                        { label: "Total B2B Turnover", val: "₹2,05,062", pill: "↑ 18.40%", isGold: true }
                    ],
                    chartTitle: "Monthly Sales",
                    barActive: 7,
                    gauge: { pct: "75.55%", offset: 58, badge: "+10%", desc: "You earned <strong>₹32,870</strong> today, it's higher than last month. Keep up your wholesale growth!", target: "₹50K ↓", rev: "₹48.5K ↑", today: "₹18.2K ↑" },
                    catTitle: WS_ICONS.dress + " Category Procurement Breakdown",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹1,14,500 (56%)", fill: 88 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹49,147 (24%)", fill: 72 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹25,825 (13%)", fill: 95 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹15,590 (7%)", fill: 60 }
                    ],
                    kpis: [
                        { label: "Avg. Turnaround Time", num: "1.8 Days", sub: WS_ICONS.lightning + " Fast Dispatch" },
                        { label: "Weekly Dispatch Reliability", num: "99.2%", sub: WS_ICONS.target + " Target Achieved" },
                        { label: "GST Input Tax Credit", num: "₹10,253", sub: WS_ICONS.shield + " 100% Verified" },
                        { label: "Active Consignments", num: "2 Orders", sub: WS_ICONS.repeat + " In Transit" }
                    ],
                    milestoneBadge: "Tier 1: Non-VIP (Active)",
                    milestoneVal: "Tier 1: Non-VIP Member",
                    milestoneDesc: "Complete <strong>44 more orders</strong> to automatically unlock <strong>Tier 2: Silver</strong> with a extra margin rebate!"
                },
                'month': {
                    sub: "Monthly Procurement Targets, Category Mix & Logistics Performance",
                    cards: [
                        { label: "B2B Account Tier", val: "Tier 1", pill: "1–50 Orders", isGold: true },
                        { label: "Total Orders", val: "14", pill: "↑ 21.00%", isGold: false },
                        { label: "Total Quantity (Units)", val: "112 Pcs", pill: "↑ 16.80%", isGold: false },
                        { label: "Total B2B Turnover", val: "₹4,86,500", pill: "↑ 24.10%", isGold: true }
                    ],
                    chartTitle: "August 2026 Procurement Volume",
                    barActive: 7,
                    gauge: { pct: "97.30%", offset: 7, badge: "+18.2%", desc: "Monthly volume tracking ahead of schedule by <strong>+18.2%</strong>!", target: "₹500K", rev: "₹486.5K ↑", today: "₹32.8K ↑" },
                    catTitle: WS_ICONS.dress + " August Category Procurement Breakdown",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹2,72,000 (56%)", fill: 92 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹1,18,500 (24%)", fill: 84 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹62,000 (13%)", fill: 98 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹34,000 (7%)", fill: 75 }
                    ],
                    kpis: [
                        { label: "Avg. Order Value", num: "₹34,750", sub: "↑ 15.1% growth" },
                        { label: "Avg. Turnaround Time", num: "1.6 Days", sub: WS_ICONS.lightning + " VIP Express" },
                        { label: "Monthly GST ITC", num: "₹24,325", sub: WS_ICONS.shield + " 100% Claimed" },
                        { label: "Repeat Order Index", num: "87.5%", sub: WS_ICONS.repeat + " 12 of 14 Lots Reordered" }
                    ],
                    milestoneBadge: "Tier 1: Non-VIP (Active)",
                    milestoneVal: "Tier 1: Non-VIP Member",
                    milestoneDesc: "Complete <strong>36 more orders</strong> to automatically unlock <strong>Tier 2: Silver</strong> with a extra margin rebate!"
                },
                'last_month': {
                    sub: "July 2026 Reconciled Performance & Procurements",
                    cards: [
                        { label: "B2B Account Tier", val: "Tier 1", pill: "Reconciled", isGold: true },
                        { label: "July Orders", val: "11", pill: "Delivered", isGold: false },
                        { label: "July Quantity", val: "88 Pcs", pill: "100% Received", isGold: false },
                        { label: "July Turnover", val: "₹3,92,400", pill: "Settled", isGold: true }
                    ],
                    chartTitle: "July 2026 Final Settlement",
                    barActive: 6,
                    gauge: { pct: "100%", offset: 0, badge: "100% Done", desc: "July target fully achieved and 100% GST reconciled!", target: "₹350K", rev: "₹392.4K", today: "Closed" },
                    catTitle: WS_ICONS.dress + " July 2026 Category Breakdown",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹2,19,000 (56%)", fill: 100 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹94,000 (24%)", fill: 100 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹51,400 (13%)", fill: 100 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹28,000 (7%)", fill: 100 }
                    ],
                    kpis: [
                        { label: "Avg. Order Value", num: "₹35,672", sub: "Final Settled" },
                        { label: "Total Transit TAT", num: "2.1 Days", sub: "100% Delivered" },
                        { label: "Total GST ITC", num: "₹19,620", sub: "Filed in GSTR-3B" },
                        { label: "Reorder Loyalty", num: "90.9%", sub: WS_ICONS.repeat + " 10 of 11 Lots Repeated" }
                    ],
                    milestoneBadge: "Tier 1: Non-VIP (Reconciled)",
                    milestoneVal: "Tier 1: Non-VIP Member",
                    milestoneDesc: "July 2026 orders settled. Complete <strong>44 more orders</strong> to unlock <strong>Tier 2: Silver</strong>!"
                },
                'year': {
                    sub: "Financial Year 2026-27 Comprehensive B2B Turnover",
                    cards: [
                        { label: "B2B Account Tier", val: "Tier 2", pill: "FY26-27", isGold: true },
                        { label: "Annual Orders", val: "58 Lots", pill: "↑ 34.5%", isGold: false },
                        { label: "Annual Quantity", val: "464 Pcs", pill: "↑ 28.2%", isGold: false },
                        { label: "Annual Turnover", val: "₹19,84,300", pill: "↑ 31.8%", isGold: true }
                    ],
                    chartTitle: "FY 2026-27 Monthly Revenue Peak",
                    barActive: 9,
                    gauge: { pct: "79.37%", offset: 48, badge: "+31.8%", desc: "Annual procurement pace on track to exceed ₹25 Lakhs milestone!", target: "₹2.5M", rev: "₹1.98M ↑", today: "Live" },
                    catTitle: WS_ICONS.dress + " FY 2026-27 Cumulative Category Volume",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹11,10,000 (56%)", fill: 82 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹4,76,000 (24%)", fill: 76 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹2,58,000 (13%)", fill: 90 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹1,40,300 (7%)", fill: 68 }
                    ],
                    kpis: [
                        { label: "Annual Avg. Order", num: "₹34,212", sub: "58 Consignments" },
                        { label: "Fastest Delivery", num: "24 Hours", sub: "Air Priority" },
                        { label: "Total FY ITC Claimed", num: "₹99,215", sub: WS_ICONS.shield + " 100% Verified" },
                        { label: "Wholesale Retention", num: "89.6%", sub: "Top Tier Wholesaler" }
                    ],
                    milestoneBadge: "Tier 2: Silver (Active)",
                    milestoneVal: "Tier 2: Silver Member",
                    milestoneDesc: "Complete <strong>192 more orders</strong> to automatically unlock <strong>Tier 3: Gold (250+ Orders)</strong>!"
                }
            },
            'sales': {
                'today': {
                    sub: "Today's Wholesale Volume & Unit Procurement (Pcs)",
                    cards: [
                        { label: "Active SKUs Today", val: "1 SKU", pill: "Kanjivaram", isGold: true },
                        { label: "Units Dispatched", val: "6 Pcs", pill: "100% QC Passed", isGold: false },
                        { label: "Pending Packaging", val: "0 Pcs", pill: "Cleared", isGold: false },
                        { label: "Delivery Mode", val: "Air Express", pill: "BlueDart", isGold: true }
                    ],
                    chartTitle: "Today's Unit Dispatch (Pcs)",
                    barActive: 7,
                    gauge: { pct: "100%", offset: 0, badge: "100%", desc: "Today's unit dispatch completed with 100% QC stamp.", target: "6 Pcs", rev: "6 Pcs", today: "6 Pcs" },
                    catTitle: WS_ICONS.dress + " Unit Distribution by Craft (Pcs)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "6 Pcs (100%)", fill: 100 }
                    ],
                    kpis: [
                        { label: "Units Dispatched", num: "6 Pcs", sub: "BlueDart Air" },
                        { label: "QC Inspection", num: "100% Passed", sub: "Zari Hallmarked" },
                        { label: "Lot Packaging", num: "Waterproof Bale", sub: "Tamper Evident" },
                        { label: "Consignment Weight", num: "8.4 Kg", sub: "Air Cargo" }
                    ],
                    milestoneBadge: WS_ICONS.package + " Daily Lot Target",
                    milestoneVal: "6 Pcs <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ 10 Pcs</span>",
                    milestoneDesc: "<strong>60%</strong> of daily packaging capacity fulfilled."
                },
                'week': {
                    sub: "Sales Volume & Procurement Lot Distribution (Units / Pcs)",
                    cards: [
                        { label: "Active Catalog SKUs", val: "6 Live Lots", pill: "Top Trending", isGold: true },
                        { label: "Dispatched Volume", val: "48 Pcs", pill: "↑ 22.5%", isGold: false },
                        { label: "Units In Transit", val: "10 Pcs", pill: "Surat Atelier", isGold: false },
                        { label: "Delivered to Warehouse", val: "38 Pcs", pill: "↑ 18.0%", isGold: true }
                    ],
                    chartTitle: "Weekly Unit Sales (Pcs)",
                    barActive: 7,
                    gauge: { pct: "80.00%", offset: 47, badge: "+15%", desc: "48 wholesale units dispatched across 6 distinct craft lots this week.", target: "60 Pcs", rev: "48 Pcs", today: "6 Pcs" },
                    catTitle: WS_ICONS.dress + " Unit Volume Distribution by Category (Pcs)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "26 Pcs (54%)", fill: 86 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "8 Pcs (17%)", fill: 80 },
                        { name: "Royal Anarkali Kurti Sets", val: "10 Pcs (21%)", fill: 100 },
                        { name: "Georgette & Chanderi Fabrics", val: "4 Pcs (8%)", fill: 50 }
                    ],
                    kpis: [
                        { label: "Total Units Dispatched", num: "48 Pcs", sub: "6 Consignments" },
                        { label: "Bale Packaging", num: "100% Sealed", sub: "Moisture Protected" },
                        { label: "Defect Return Rate", num: "0.0%", sub: "Zero Returns" },
                        { label: "Fastest Moving SKU", num: "KLN-SR-003", sub: "Kanjivaram Temple Silk" }
                    ],
                    milestoneBadge: WS_ICONS.package + " Weekly Volume Goal",
                    milestoneVal: "48 Pcs <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ 60 Pcs</span>",
                    milestoneDesc: "<strong>80.0%</strong> of weekly lot volume fulfilled. 12 pcs remaining for weekly bonus lot!"
                },
                'month': {
                    sub: "Monthly Volume & Wholesale Lot Distribution (Units / Pcs)",
                    cards: [
                        { label: "Procured Lots", val: "14 Lots", pill: "↑ 28.0%", isGold: true },
                        { label: "Monthly Units Sold", val: "112 Pcs", pill: "↑ 24.5%", isGold: false },
                        { label: "Units In Transit", val: "14 Pcs", pill: "En Route", isGold: false },
                        { label: "Delivered Quantity", val: "98 Pcs", pill: "↑ 26.0%", isGold: true }
                    ],
                    chartTitle: "August Monthly Unit Volume (Pcs)",
                    barActive: 7,
                    gauge: { pct: "93.33%", offset: 16, badge: "+24.5%", desc: "112 total pieces procured in August, setting a new monthly high.", target: "120 Pcs", rev: "112 Pcs", today: "6 Pcs" },
                    catTitle: WS_ICONS.dress + " August Category Units Breakdown (Pcs)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "62 Pcs (55%)", fill: 94 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "18 Pcs (16%)", fill: 90 },
                        { name: "Royal Anarkali Kurti Sets", val: "24 Pcs (22%)", fill: 100 },
                        { name: "Georgette & Chanderi Fabrics", val: "8 Pcs (7%)", fill: 70 }
                    ],
                    kpis: [
                        { label: "Monthly Units Sold", num: "112 Pcs", sub: "↑ 24.5% MoM" },
                        { label: "Avg Lot Size", num: "8 Pcs / Lot", sub: "Optimal MOQ" },
                        { label: "QC Pass Rate", num: "100%", sub: "Surat Atelier" },
                        { label: "Top Fabric", num: "Mulberry Silk", sub: "62 Units" }
                    ],
                    milestoneBadge: WS_ICONS.package + " Monthly Lot Milestone",
                    milestoneVal: "112 Pcs <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ 120 Pcs</span>",
                    milestoneDesc: "<strong>93.3%</strong> of monthly unit target completed."
                },
                'last_month': {
                    sub: "July 2026 Reconciled Wholesale Volume (Units / Pcs)",
                    cards: [
                        { label: "July Lots Closed", val: "11 Lots", pill: "Delivered", isGold: true },
                        { label: "Units Fulfilled", val: "88 Pcs", pill: "100% Verified", isGold: false },
                        { label: "Transit Dispatches", val: "11 Bales", pill: "Air Cargo", isGold: false },
                        { label: "Defect Incident", val: "0 Units", pill: "Zero Defect", isGold: true }
                    ],
                    chartTitle: "July Unit Fulfillment (Pcs)",
                    barActive: 6,
                    gauge: { pct: "100%", offset: 0, badge: "100%", desc: "88 pieces delivered with 100% customer acceptance and zero defects.", target: "80 Pcs", rev: "88 Pcs", today: "Done" },
                    catTitle: WS_ICONS.dress + " July Category Units Breakdown (Pcs)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "50 Pcs (57%)", fill: 100 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "14 Pcs (16%)", fill: 100 },
                        { name: "Royal Anarkali Kurti Sets", val: "18 Pcs (20%)", fill: 100 },
                        { name: "Georgette & Chanderi Fabrics", val: "6 Pcs (7%)", fill: 100 }
                    ],
                    kpis: [
                        { label: "July Total Delivered", num: "88 Pcs", sub: "11 Consignments" },
                        { label: "Return Rate", num: "0.0%", sub: "Zero Defects" },
                                                { label: "Payment Settlement", num: "₹18,200", sub: "NEFT Verified" }
                    ],
                    milestoneBadge: WS_ICONS.card + " Daily Revenue Target",
                    milestoneVal: "₹18,200 <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ ₹50,000</span>",
                    milestoneDesc: "<strong>36.4%</strong> of daily financial turnover goal achieved."
                },
                'week': {
                    sub: "Gross B2B Revenue, Tax Invoices & ITC Credit Accrual",
                    cards: [
                        { label: "Gross Taxable Value", val: "₹1,95,297", pill: "5% GST Tier", isGold: true },
                        { label: "Input Tax Credit (ITC)", val: "₹10,253", pill: "100% Matched", isGold: false },
                        { label: "VIP Margin Saved", val: "₹13,500", pill: "Tier 1 Rate", isGold: false },
                        { label: "Total Settled Turnover", val: "₹2,05,062", pill: "Paid In Full", isGold: true }
                    ],
                    chartTitle: "Weekly Invoiced Turnover (₹)",
                    barActive: 7,
                    gauge: { pct: "82.02%", offset: 42, badge: "Verified", desc: "₹10,253 in GST Input Tax Credit reconciled for current tax cycle.", target: "₹250K", rev: "₹205K ↑", today: "₹18.2K ↑" },
                    catTitle: WS_ICONS.dress + " Tax Invoiced Turnover by Category (₹)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹1,14,500 (GST: ₹5,725)", fill: 88 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹49,147 (GST: ₹2,457)", fill: 72 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹25,825 (GST: ₹1,291)", fill: 95 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹15,590 (GST: ₹780)", fill: 60 }
                    ],
                    kpis: [
                        { label: "Gross Taxable Value", num: "₹1,95,297", sub: "5% GST Saree/Fabrics" },
                        { label: "Total GST ITC Accrued", num: "₹10,253", sub: WS_ICONS.shield + " 100% GSTR-1 Verified" },
                        { label: "Wholesale Margin Saved", num: "₹13,500", sub: WS_ICONS.crown + " VIP Tier 1 Discount" },
                        { label: "Settlement Status", num: "100% Cleared", sub: "Zero Pending Dues" }
                    ],
                    milestoneBadge: WS_ICONS.crown + " Financial Target",
                    milestoneVal: "₹2,05,062 <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ ₹2,50,000</span>",
                    milestoneDesc: "<strong>82.02%</strong> of your target achieved. Procure <strong>₹44,938</strong> more to unlock <strong>Tier 2 Platinum VIP</strong> with extra 3% margin!"
                },
                'month': {
                    sub: "August 2026 Tax Invoicing & Input Credit Breakdown",
                    cards: [
                        { label: "Monthly Taxable Base", val: "₹4,63,333", pill: "5% GST Base", isGold: true },
                        { label: "Claimable GST ITC", val: "₹23,167", pill: "GSTR-2B Ready", isGold: false },
                        { label: "B2B Margin Saved", val: "₹32,400", pill: "Volume Rebate", isGold: false },
                        { label: "August Settled Total", val: "₹4,86,500", pill: "100% Invoiced", isGold: true }
                    ],
                    chartTitle: "August Gross Invoiced Revenue (₹)",
                    barActive: 7,
                    gauge: { pct: "97.30%", offset: 7, badge: "97.3%", desc: "August gross revenue stands at ₹4,86,500 with ₹24,325 in claimable GST ITC.", target: "₹500K", rev: "₹486.5K", today: "₹32.8K" },
                    catTitle: WS_ICONS.dress + " August Tax Invoiced Breakdown (₹)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹2,72,000 (GST: ₹13,600)", fill: 92 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹1,18,500 (GST: ₹5,925)", fill: 84 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹62,000 (GST: ₹3,100)", fill: 98 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹34,000 (GST: ₹1,700)", fill: 75 }
                    ],
                    kpis: [
                        { label: "Monthly Taxable Value", num: "₹4,63,333", sub: "5% GST Base" },
                        { label: "Monthly GST ITC", num: "₹23,167", sub: WS_ICONS.shield + " Auto E-Way Matched" },
                        { label: "B2B Discount Margin", num: "₹32,400", sub: "VIP Volume Rebate" },
                        { label: "Net Bank Inflow", num: "₹4,86,500", sub: "NEFT & RTGS" }
                    ],
                    milestoneBadge: WS_ICONS.crown + " Monthly Target",
                    milestoneVal: "₹4,86,500 <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ ₹5,00,000</span>",
                    milestoneDesc: "<strong>97.3%</strong> of monthly revenue target achieved. Only ₹13,500 needed to close out target!"
                },
                'last_month': {
                    sub: "July 2026 Settled Invoices & GSTR-3B Tax Filing",
                    cards: [
                        { label: "Audited Taxable Base", val: "₹3,73,714", pill: "Audited", isGold: true },
                        { label: "GST Claimed in 3B", val: "₹18,686", pill: "100% Realized", isGold: false },
                        { label: "July Margin Saved", val: "₹26,800", pill: "Saved on MOQ", isGold: false },
                        { label: "July Gross Settled", val: "₹3,92,400", pill: "Auditor Certified", isGold: true }
                    ],
                    chartTitle: "July Settled Tax Invoices (₹)",
                    barActive: 6,
                    gauge: { pct: "100%", offset: 0, badge: "Audited", desc: "July financial ledger reconciled and filed in GSTR-3B with full ITC clearance.", target: "₹350K", rev: "₹392.4K", today: "Settled" },
                    catTitle: WS_ICONS.dress + " July Tax Invoiced Revenue (₹)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹2,19,000 (GST: ₹10,950)", fill: 100 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹94,000 (GST: ₹4,700)", fill: 100 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹51,400 (GST: ₹2,570)", fill: 100 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹28,000 (GST: ₹1,400)", fill: 100 }
                    ],
                    kpis: [
                        { label: "July Taxable Value", num: "₹3,73,714", sub: "Audited Ledger" },
                        { label: "GST Claimed in 3B", num: "₹18,686", sub: "Full ITC Realized" },
                        { label: "Wholesale Margin", num: "₹26,800", sub: "Saved on MOQ" },
                        { label: "Ledger Reconciliation", num: "100% Done", sub: "Auditor Certified" }
                    ],
                    milestoneBadge: WS_ICONS.crown + " Reconciled Target",
                    milestoneVal: "₹3,92,400 <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ ₹3,50,000</span>",
                    milestoneDesc: "<strong>112.1%</strong> of financial target accomplished in July 2026."
                },
                'year': {
                    sub: "Financial Year 2026-27 B2B Revenue & Tax Compliance",
                    cards: [
                        { label: "Annual Taxable Base", val: "₹18,89,810", pill: "58 Tax Invoices", isGold: true },
                        { label: "Total FY ITC Claimed", val: "₹99,215", pill: "100% GSTR-2B", isGold: false },
                        { label: "Volume Discounts", val: "₹1,45,000", pill: "Saved on B2B", isGold: false },
                        { label: "Annual Gross Total", val: "₹19,84,300", pill: "100% Cleared", isGold: true }
                    ],
                    chartTitle: "FY 2026-27 Revenue Growth (₹)",
                    barActive: 9,
                    gauge: { pct: "79.37%", offset: 48, badge: "+31.8%", desc: "₹99,215 total GST Input Tax Credit accumulated across all consignments in FY26-27.", target: "₹2.5M", rev: "₹1.98M", today: "Live" },
                    catTitle: WS_ICONS.dress + " FY 2026-27 Invoiced Category Revenue (₹)",
                    cats: [
                        { name: "Pure Silk & Zari Sarees", val: "₹11,10,000 (GST: ₹55,500)", fill: 82 },
                        { name: "Bridal Velvet & Zardosi Lehengas", val: "₹4,76,000 (GST: ₹23,800)", fill: 76 },
                        { name: "Royal Anarkali Kurti Sets", val: "₹2,58,000 (GST: ₹12,900)", fill: 90 },
                        { name: "Georgette & Chanderi Fabrics", val: "₹1,40,300 (GST: ₹7,015)", fill: 68 }
                    ],
                    kpis: [
                        { label: "Total Taxable Sales", num: "₹18,89,810", sub: "58 Tax Invoices" },
                        { label: "Total FY ITC Claimed", num: "₹99,215", sub: WS_ICONS.shield + " 100% GSTR-2B Verified" },
                        { label: "Annual Margin Savings", num: "₹1,45,000", sub: "B2B Volume Rates" },
                        { label: "Payment Discipline", num: "100% On-Time", sub: "Zero Penalty" }
                    ],
                    milestoneBadge: WS_ICONS.crown + " Annual VIP Milestone",
                    milestoneVal: "₹19,84,300 <span style='font-size:0.75rem; font-weight:600; color:var(--ws-text-muted);'>/ ₹25,00,000</span>",
                    milestoneDesc: "<strong>79.37%</strong> of Annual Target achieved. Procure ₹5,15,700 more to unlock ₹50L Super Wholesaler Tier!"
                }
            }
        };

        window.updateDashboardAnalytics = function() {
            var data = (ANALYTICS_DATA[analyticsMode] && ANALYTICS_DATA[analyticsMode][currentSelectedDateRange]) 
                ? ANALYTICS_DATA[analyticsMode][currentSelectedDateRange] 
                : ANALYTICS_DATA['overview']['week'];

            // 1. Update Subtitle
            var subEl = document.getElementById('statsSubtitle');
            if (subEl) subEl.textContent = data.sub;

            // 2. Update Top 4 Metric Cards
            for (var i = 0; i < 4; i++) {
                var c = data.cards[i];
                var lbl = document.getElementById('statLabel' + (i + 1));
                var val = document.getElementById('statVal' + (i + 1));
                var pill = document.getElementById('statPill' + (i + 1));
                if (lbl && c) lbl.textContent = c.label;
                if (val && c) {
                    val.innerHTML = c.val;
                    if (c.isGold) {
                        val.style.color = 'var(--ws-gold-primary)';
                    } else {
                        val.style.color = 'var(--ws-text-main)';
                    }
                }
                if (pill && c) pill.textContent = c.pill;
            }

            // Update 3D Corner Tag dynamically based on tier
            var ribbonTag = document.getElementById('wsTierRibbonTag');
            var ribbonText = document.getElementById('wsTierRibbonText');
            if (ribbonTag && ribbonText) {
                var tierVal = (data.cards && data.cards[0] && data.cards[0].val) ? data.cards[0].val.toLowerCase() : '';
                if (tierVal.includes('5') || tierVal.includes('platinum')) {
                    ribbonTag.className = 'ws-tier-ribbon-tag platinum';
                    ribbonText.textContent = '★ PLATINUM';
                } else if (tierVal.includes('4') || tierVal.includes('diamond')) {
                    ribbonTag.className = 'ws-tier-ribbon-tag diamond';
                    ribbonText.textContent = '★ DIAMOND';
                } else if (tierVal.includes('3') || tierVal.includes('gold')) {
                    ribbonTag.className = 'ws-tier-ribbon-tag gold';
                    ribbonText.textContent = '★ GOLD';
                } else if (tierVal.includes('2') || tierVal.includes('silver')) {
                    ribbonTag.className = 'ws-tier-ribbon-tag silver';
                    ribbonText.textContent = '★ SILVER';
                } else {
                    ribbonTag.className = 'ws-tier-ribbon-tag non-vip';
                    ribbonText.textContent = '★ NON VIP';
                }
            }

            // 3. Update Bar Chart Active Column & Title
            var chartTitleEl = document.getElementById('chartTitle');
            if (chartTitleEl) chartTitleEl.innerHTML = data.chartTitle;

            for (var b = 0; b < 12; b++) {
                var col = document.getElementById('barMonth' + b);
                if (col) {
                    col.classList.remove('active');
                    if (b === data.barActive) col.classList.add('active');
                }
            }

            // 4. Update Target Gauge
            var gVal = document.getElementById('targetGaugeVal');
            var gBadge = document.getElementById('targetGaugeBadge');
            var gFill = document.getElementById('targetGaugeFill');
            var gDesc = document.getElementById('targetGaugeDesc');
            var gTarget = document.getElementById('gStatTarget');
            var gRev = document.getElementById('gStatRevenue');
            var gToday = document.getElementById('gStatToday');

            if (gVal) gVal.textContent = data.gauge.pct;
            if (gBadge) gBadge.textContent = data.gauge.badge;
            if (gFill) gFill.style.strokeDashoffset = data.gauge.offset;
            if (gDesc) gDesc.innerHTML = data.gauge.desc;
            if (gTarget) gTarget.textContent = data.gauge.target;
            if (gRev) gRev.textContent = data.gauge.rev;
            if (gToday) gToday.textContent = data.gauge.today;

            // 5. Update Category Breakdown List
            var catTitleEl = document.getElementById('catBreakdownTitle');
            if (catTitleEl) catTitleEl.innerHTML = data.catTitle;

            var catList = document.getElementById('catProgList');
            if (catList && data.cats) {
                catList.innerHTML = '';
                data.cats.forEach(function(item) {
                    var row = document.createElement('div');
                    row.className = 'ws-cat-prog-item';
                    row.innerHTML = `
                        <div class="ws-cat-prog-header">
                            <span class="ws-cat-prog-name">${item.name}</span>
                            <span class="ws-cat-prog-val">${item.val}</span>
                        </div>
                        <div class="ws-cat-prog-track">
                            <div class="ws-cat-prog-fill" style="width: ${item.fill}%;"></div>
                        </div>
                    `;
                    catList.appendChild(row);
                });
            }

            // 6. Update KPIs Grid
            var kpiContainer = document.getElementById('kpiGrid');
            if (kpiContainer && data.kpis) {
                kpiContainer.innerHTML = '';
                data.kpis.forEach(function(k) {
                    var box = document.createElement('div');
                    box.className = 'ws-kpi-box';
                    box.innerHTML = `
                        <div class="ws-kpi-label">${k.label}</div>
                        <div class="ws-kpi-num">${k.num}</div>
                        <div class="ws-kpi-sub">${k.sub}</div>
                    `;
                    kpiContainer.appendChild(box);
                });
            }

            // 7. Update Milestone
            var mBadge = document.getElementById('statsMilestoneBadge');
            var mVal = document.getElementById('statsMilestoneVal');
            var mDesc = document.getElementById('statsMilestoneDesc');
            if (mBadge) mBadge.innerHTML = data.milestoneBadge;
            if (mVal) mVal.innerHTML = data.milestoneVal;
            if (mDesc) mDesc.innerHTML = data.milestoneDesc;
        };

        window.setOverviewFilter = function(mode, btn) {
            analyticsMode = mode;
            if (btn && btn.parentElement) {
                btn.parentElement.querySelectorAll('button').forEach(function(b) {
                    b.classList.remove('active');
                });
                btn.classList.add('active');
            }
            updateDashboardAnalytics();
            window.showWsToast('📊 Switched to ' + mode.toUpperCase() + ' Analytics Mode');
        };

        /* ── Date Range Modal Controller ── */
        window.openDateRangePicker = function() {
            var modal = document.getElementById('wsDateRangeModal');
            if (modal) modal.classList.add('active');
        };

        window.closeDateRangeModal = function() {
            var modal = document.getElementById('wsDateRangeModal');
            if (modal) modal.classList.remove('active');
        };

        window.applyDatePreset = function(presetKey, label) {
            currentSelectedDateRange = presetKey;
            
            var labelEl = document.getElementById('selectedDateRangeLabel');
            if (labelEl) labelEl.textContent = label;

            // Highlight selected button inside modal
            var modalButtons = document.querySelectorAll('#datePresetButtons button');
            modalButtons.forEach(function(b) {
                b.className = 'ws-btn ws-btn-secondary';
                if (b.getAttribute('onclick') && b.getAttribute('onclick').includes(presetKey)) {
                    b.className = 'ws-btn ws-btn-primary';
                }
            });

            closeDateRangeModal();
            updateDashboardAnalytics();
            window.showWsToast('📅 Applied Date Filter: ' + label);
        };

        window.applyCustomDateRange = function() {
            var s = document.getElementById('customStartDate').value;
            var e = document.getElementById('customEndDate').value;
            if (!s || !e) {
                alert('Please select both start and end dates.');
                return;
            }
            if (new Date(s) > new Date(e)) {
                alert('Start date cannot be after end date.');
                return;
            }

            var formatD = function(dStr) {
                var d = new Date(dStr);
                var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                return months[d.getMonth()] + ' ' + String(d.getDate()).padStart(2, '0');
            };

            var label = formatD(s) + ' - ' + formatD(e);
            var labelEl = document.getElementById('selectedDateRangeLabel');
            if (labelEl) labelEl.textContent = label;

            // Reset preset active buttons
            var modalButtons = document.querySelectorAll('#datePresetButtons button');
            modalButtons.forEach(function(b) {
                b.className = 'ws-btn ws-btn-secondary';
            });

            closeDateRangeModal();
            updateDashboardAnalytics();
            window.showWsToast('📅 Applied Custom Calendar Range: ' + label);
        };

        window.handleGlobalQuickSearch = function(input) {
            var val = input.value.trim().toLowerCase();
            if (!val) return;
            var match = activeOrdersList.find(function(o) {
                return o.id.toLowerCase().includes(val) || o.productName.toLowerCase().includes(val) || o.sku.toLowerCase().includes(val);
            });
            if (match) {
                viewOrderDetails(match);
            }
        };

        /* ── Render Reports Table & Mobile Cards ── */
        var currentReportCategoryFilter = 'all';
        var currentReportSearchQuery = '';

        function renderReportsView(orders) {
            var tbody = document.getElementById('wsReportsTbody');
            var mobContainer = document.getElementById('wsMobileReportsCards');
            if (!tbody || !mobContainer) return;

            tbody.innerHTML = '';
            mobContainer.innerHTML = '';

            var filtered = (orders || activeOrdersList).filter(function(o) {
                var matchCat = true;
                if (currentReportCategoryFilter !== 'all') {
                    var prodLow = (o.productName || '').toLowerCase();
                    matchCat = prodLow.includes(currentReportCategoryFilter);
                }
                var matchSearch = true;
                if (currentReportSearchQuery) {
                    var q = currentReportSearchQuery.toLowerCase();
                    matchSearch = (o.id || '').toLowerCase().includes(q) ||
                                  (o.productName || '').toLowerCase().includes(q) ||
                                  (o.sku || '').toLowerCase().includes(q) ||
                                  (o.hsn || '').toLowerCase().includes(q) ||
                                  (o.payment || '').toLowerCase().includes(q);
                }
                return matchCat && matchSearch;
            });

            // Update Report KPIs
            var totalTurnover = filtered.reduce(function(acc, o) { return acc + Number(o.total || 0); }, 0);
            var totalTax = filtered.reduce(function(acc, o) { return acc + Number(o.tax || 0); }, 0);
            var totalUnits = filtered.reduce(function(acc, o) { return acc + Number(o.qty || 0); }, 0);
            var avgValue = filtered.length ? Math.round(totalTurnover / filtered.length) : 0;

            var elTurnover = document.getElementById('repKpiTurnover');
            var elTax = document.getElementById('repKpiItc');
            var elUnits = document.getElementById('repKpiUnits');
            var elAvg = document.getElementById('repKpiAvg');

            if (elTurnover) elTurnover.textContent = '₹' + totalTurnover.toLocaleString('en-IN');
            if (elTax) elTax.textContent = '₹' + totalTax.toLocaleString('en-IN');
            if (elUnits) elUnits.textContent = totalUnits + ' Pcs';
            if (elAvg) elAvg.textContent = '₹' + avgValue.toLocaleString('en-IN');

            if (filtered.length === 0) {
                tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:30px; color:#6B6358;">No matching report consignments found.</td></tr>';
                mobContainer.innerHTML = '<div style="text-align:center; padding:30px; color:#6B6358; font-weight:600;">No matching report consignments found.</div>';
                return;
            }

            filtered.forEach(function(o) {
                // 1. Desktop Table Row
                var tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="ws-order-id-cell">${o.id}</td>
                    <td style="font-size:0.78rem; color:#6B6358; white-space:nowrap;">${o.date}</td>
                    <td><span style="font-family:monospace; background:var(--ws-gold-light); color:var(--ws-gold-primary); padding:2px 6px; border-radius:4px; font-weight:700;">${o.hsn}</span></td>
                    <td>
                        <div class="ws-prod-mini-cell">
                            <img src="${o.image}" alt="${o.productName}" class="ws-prod-mini-img" onerror="this.src='images/product1.png';">
                            <div>
                                <strong style="font-size:0.84rem; color:var(--ws-text-main);">${o.productName}</strong>
                                <div style="font-size:0.72rem; color:var(--ws-text-muted);">SKU: ${o.sku} • ${o.courier}</div>
                            </div>
                        </div>
                    </td>
                    <td><strong style="font-size:0.84rem;">${o.qty}</strong></td>
                    <td>₹${Number(o.subtotal).toLocaleString('en-IN')}</td>
                    <td style="color:#10B981; font-weight:700;">₹${Number(o.tax).toLocaleString('en-IN')}</td>
                    <td><strong style="color:var(--ws-gold-primary); font-size:0.90rem;">₹${Number(o.total).toLocaleString('en-IN')}</strong></td>
                    <td style="font-size:0.76rem; color:var(--ws-text-muted);">${o.payment}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <button class="ws-btn ws-btn-primary ws-btn-sm" onclick='openBillInvoiceModal(${JSON.stringify(o)})' title="Download GST Tax Invoice PDF">
                                📄 Bill
                            </button>
                            <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick='viewOrderDetails(${JSON.stringify(o)})' title="View Details">
                                👁️
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);

                // 2. Mobile Responsive Report Card
                var card = document.createElement('div');
                card.className = 'ws-mob-report-card';
                card.innerHTML = `
                    <div class="ws-mob-rep-top">
                        <div>
                            <span class="ws-order-id-cell" style="font-size:0.90rem;">${o.id}</span>
                            <span style="font-size:0.72rem; color:var(--ws-text-muted); margin-left:6px;">📅 ${o.date}</span>
                        </div>
                        <span class="ws-status-badge delivered" style="font-size:0.65rem;">✓ 5% GST Verified</span>
                    </div>

                    <div class="ws-mob-rep-body">
                        <img src="${o.image}" alt="${o.productName}" class="ws-mob-rep-img" onerror="this.src='images/product1.png';">
                        <div class="ws-mob-rep-info">
                            <h4 style="font-size:0.88rem; font-weight:700; color:var(--ws-text-main); line-height:1.25; margin-bottom:2px;">${o.productName}</h4>
                            <div style="font-size:0.74rem; color:var(--ws-text-muted);">
                                SKU: <strong>${o.sku}</strong> • HSN: <strong style="color:var(--ws-gold-primary); font-family:monospace;">${o.hsn}</strong>
                            </div>
                            <div style="font-size:0.76rem; font-weight:700; color:var(--ws-text-main); margin-top:2px;">
                                Quantity Lot: <span style="color:var(--ws-gold-primary);">${o.qty} Pcs</span>
                            </div>
                        </div>
                    </div>

                    <div class="ws-mob-rep-tax-grid">
                        <div>
                            <span style="color:var(--ws-text-muted); font-size:0.68rem; display:block;">Taxable Base:</span>
                            <strong style="color:var(--ws-text-main);">₹${Number(o.subtotal).toLocaleString('en-IN')}</strong>
                        </div>
                        <div>
                            <span style="color:var(--ws-text-muted); font-size:0.68rem; display:block;">GST ITC Accrued (5%):</span>
                            <strong style="color:#10B981;">₹${Number(o.tax).toLocaleString('en-IN')}</strong>
                        </div>
                        <div>
                            <span style="color:var(--ws-text-muted); font-size:0.68rem; display:block;">Payment Instrument:</span>
                            <span style="color:var(--ws-text-sub); font-size:0.72rem; font-weight:600;">${o.payment.split('(')[0]}</span>
                        </div>
                        <div>
                            <span style="color:var(--ws-text-muted); font-size:0.68rem; display:block;">Total Invoiced:</span>
                            <strong style="color:var(--ws-gold-primary); font-size:0.92rem;">₹${Number(o.total).toLocaleString('en-IN')}</strong>
                        </div>
                    </div>

                    <div class="ws-mob-rep-actions">
                        <button class="ws-btn ws-btn-primary ws-btn-sm" style="width:100%; justify-content:center;" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                            📄 Download GST Bill PDF
                        </button>
                        <button class="ws-btn ws-btn-secondary ws-btn-sm" style="width:100%; justify-content:center;" onclick='viewOrderDetails(${JSON.stringify(o)})'>
                            👁️ View Details
                        </button>
                    </div>
                `;
                mobContainer.appendChild(card);
            });
        }

        window.filterReportsByCategory = function(category, btn) {
            currentReportCategoryFilter = category;
            if (btn && btn.parentElement) {
                btn.parentElement.querySelectorAll('button').forEach(function(b) { b.classList.remove('active'); });
                btn.classList.add('active');
            }
            renderReportsView(activeOrdersList);
        };

        window.handleReportSearch = function(val) {
            currentReportSearchQuery = val.trim();
            var clearBtn = document.getElementById('reportSearchClear');
            if (clearBtn) clearBtn.style.display = val.trim() ? 'flex' : 'none';
            renderReportsView(activeOrdersList);
        };

        window.clearReportSearch = function() {
            var input = document.getElementById('reportSearchInput');
            if (input) {
                input.value = '';
                input.focus();
            }
            var clearBtn = document.getElementById('reportSearchClear');
            if (clearBtn) clearBtn.style.display = 'none';
            currentReportSearchQuery = '';
            renderReportsView(activeOrdersList);
        };

        /* ── Formal Printable Wholesale Procurement Audit Report ── */
        window.printWholesaleReport = function() {
            var modal = document.getElementById('wsPrintableAuditReportModal');
            if (modal) {
                var userRaw = localStorage.getItem('kalaniketan_user');
                var user = userRaw ? JSON.parse(userRaw) : {};
                var comp = user.companyName || 'Shree Krishna Silks Pvt Ltd';
                var gst = user.gst_number || '24AABCU9603R1ZM';
                var rep = user.name || 'Rajesh Kumar';

                var repInfoEl = document.getElementById('auditReportBuyerInfo');
                if (repInfoEl) {
                    repInfoEl.innerHTML = `
                        <strong>${comp}</strong> (GSTIN: <strong>${gst}</strong>)<br>
                        Authorized Wholesaler: ${rep} • Period: FY 2026-27<br>
                        Report Generated: ${new Date().toLocaleDateString('en-IN', { day:'numeric', month:'short', year:'numeric' })}
                    `;
                }

                var tbody = document.getElementById('auditReportTbody');
                if (tbody) {
                    tbody.innerHTML = '';
                    var totalSub = 0, totalTax = 0, totalGrand = 0, totalQty = 0;
                    activeOrdersList.forEach(function(o, idx) {
                        totalSub += Number(o.subtotal || 0);
                        totalTax += Number(o.tax || 0);
                        totalGrand += Number(o.total || 0);
                        totalQty += Number(o.qty || 0);

                        var tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${idx + 1}</td>
                            <td><strong>${o.id}</strong></td>
                            <td>${o.date}</td>
                            <td>${o.hsn}</td>
                            <td>${o.productName}</td>
                            <td>${o.qty} Pcs</td>
                            <td>₹${Number(o.subtotal).toLocaleString('en-IN')}</td>
                            <td>₹${Number(o.tax).toLocaleString('en-IN')}</td>
                            <td><strong>₹${Number(o.total).toLocaleString('en-IN')}</strong></td>
                            <td>${o.payment}</td>
                        `;
                        tbody.appendChild(tr);
                    });

                    document.getElementById('auditTotalSub').textContent = '₹' + totalSub.toLocaleString('en-IN');
                    document.getElementById('auditTotalTax').textContent = '₹' + totalTax.toLocaleString('en-IN');
                    document.getElementById('auditTotalGrand').textContent = '₹' + totalGrand.toLocaleString('en-IN');
                    document.getElementById('auditTotalQty').textContent = totalQty + ' Pcs';
                }

                modal.classList.add('active');
            } else {
                window.print();
            }
        };

        window.closePrintableAuditReportModal = function() {
            var modal = document.getElementById('wsPrintableAuditReportModal');
            if (modal) modal.classList.remove('active');
        };

        /* ── Export Reports to CSV ── */
        window.exportReportsToCsv = function() {
            var headers = ["Consignment ID", "Date", "HSN", "Product Name", "Quantity", "Taxable Value", "GST (5%)", "Net Total", "Payment Mode", "Courier", "AWB"];
            var rows = activeOrdersList.map(function(o) {
                return [
                    `"${o.id}"`,
                    `"${o.date}"`,
                    `"${o.hsn}"`,
                    `"${o.productName.replace(/"/g, '""')}"`,
                    o.qty,
                    o.subtotal,
                    o.tax,
                    o.total,
                    `"${o.payment}"`,
                    `"${o.courier}"`,
                    `"${o.awb}"`
                ];
            });

            var csvContent = "data:text/csv;charset=utf-8," + [headers.join(",")].concat(rows.map(function(e){ return e.join(","); })).join("\n");
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `Kalaniketan_Wholesale_Report_${new Date().toISOString().slice(0,10)}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            window.showWsToast('📁 CSV Spreadsheet downloaded successfully!');
        };

        /* ── Render Support Tickets ── */
        function renderTicketsView() {
            var list = document.getElementById('wsTicketList');
            if (!list) return;
            list.innerHTML = '';

            activeTicketsList.forEach(function(t) {
                var isResolved = t.status === 'Resolved';
                var statusColor = isResolved ? '#15803D' : '#D97706';
                var statusBg = isResolved ? 'rgba(21, 128, 61, 0.08)' : 'rgba(217, 119, 6, 0.08)';
                var statusBorder = isResolved ? 'rgba(21, 128, 61, 0.25)' : 'rgba(217, 119, 6, 0.25)';

                var card = document.createElement('div');
                card.className = 'ws-ticket-card';
                card.innerHTML = `
                    <div class="ws-ticket-head">
                        <div style="display:flex; align-items:center; gap:6px;">
                            <strong class="ws-order-id-cell" style="font-size:0.86rem;">Ticket #${t.id}</strong>
                            <span style="font-size:0.70rem; color:var(--ws-text-muted);">• Ref: <strong>${t.orderId}</strong></span>
                        </div>
                        <span style="font-size:0.70rem; font-weight:800; color:${statusColor}; background:${statusBg}; border:1px solid ${statusBorder}; padding:2px 8px; border-radius:12px; display:inline-flex; align-items:center;">
                            ${isResolved ? '✓ ' + t.status : '<span class="ws-pulse-dot"></span> ' + t.status}
                        </span>
                    </div>
                    <div style="font-size:0.82rem; font-weight:700; color:var(--ws-text-main); margin:4px 0 2px;">${t.category}</div>
                    <p style="font-size:0.78rem; color:var(--ws-text-sub); margin:0; line-height:1.4; background:#FAF8F4; padding:8px 10px; border-radius:6px; border:1px solid var(--ws-border);">"${t.message}"</p>
                    <div style="font-size:0.72rem; color:var(--ws-text-muted); margin-top:8px; display:flex; justify-content:space-between; align-items:center;">
                        <span>📅 ${t.date}</span>
                        <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%2C%20following%20up%20on%20Wholesaler%20Ticket%20%23${t.id}" target="_blank" style="color:#25D366; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M17.472 14.382c-.301-.15-1.78-.879-2.056-.979-.275-.1-.475-.15-.675.15-.2.3-.775.979-.95 1.179-.175.2-.35.225-.65.075-.3-.15-1.267-.467-2.414-1.49-1.049-.935-1.758-2.09-1.963-2.44-.205-.35-.022-.54.128-.69.135-.135.301-.35.451-.525.15-.175.2-.3.3-.5.1-.2.05-.375-.025-.525-.075-.15-.675-1.628-.925-2.228-.244-.585-.492-.505-.675-.515-.175-.01-.375-.01-.575-.01-.2 0-.525.075-.8.375s-1.05 1.028-1.05 2.505 1.075 2.905 1.225 3.105c.15.2 2.115 3.23 5.125 4.53 3.01 1.3 3.01.867 3.56.817.55-.05 1.78-.727 2.03-1.428.25-.7.25-1.3.175-1.428-.075-.128-.275-.203-.575-.353z"/><path d="M12 2C6.477 2 2 6.477 2 12c0 1.891.524 3.662 1.435 5.176L2 22l4.981-1.307C8.423 21.536 10.155 22 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18c-1.63 0-3.14-.492-4.407-1.336l-.316-.209-2.955.775.789-2.88-.228-.363C3.965 14.675 3.5 13.385 3.5 12c0-4.687 3.813-8.5 8.5-8.5s8.5 3.813 8.5 8.5-3.813 8.5-8.5 8.5z"/></svg>
                            <span>WhatsApp Followup →</span>
                        </a>
                    </div>
                `;
                list.appendChild(card);
            });
        }

        window.handleCreateTicket = function(e) {
            e.preventDefault();
            var orderId = document.getElementById('ticketOrderId').value;
            var category = document.getElementById('ticketCategory').value;
            var message = document.getElementById('ticketMessage').value.trim();

            if (!message) { alert('Please enter issue narrative'); return; }

            var newTicket = {
                id: 'TCK-' + Math.floor(100 + Math.random() * 900),
                orderId: orderId,
                category: category,
                status: 'In Progress',
                message: message,
                date: 'Today, ' + new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
            };

            activeTicketsList.unshift(newTicket);
            renderTicketsView();
            document.getElementById('wsTicketForm').reset();
            window.showWsToast('🎫 Support ticket created! Concierge assigned.');
        };

        /* ── Order Details Modal ── */
        window.viewOrderDetails = function(o) {
            var modal = document.getElementById('wsOrderDetailsModal');
            var title = document.getElementById('modalOrderTitle');
            var body = document.getElementById('modalOrderBody');
            var footer = document.getElementById('modalOrderFooter');

            if (!modal || !body) return;

            if (title) title.textContent = `Order Details #${o.id}`;
            body.innerHTML = `
                <!-- Consignment Status Banner -->
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; background:#FAF8F4; border:1.5px solid var(--ws-border); border-radius:10px; padding:12px 16px; margin-bottom:14px;">
                    <div>
                        <div style="font-size:0.72rem; text-transform:uppercase; font-weight:700; letter-spacing:0.5px; color:var(--ws-text-muted);">Consignment Placed</div>
                        <div style="font-size:0.92rem; font-weight:800; color:var(--ws-text-main); margin-top:2px;">${o.date}</div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:0.72rem; text-transform:uppercase; font-weight:700; letter-spacing:0.5px; color:var(--ws-text-muted); margin-bottom:3px;">Consignment Status</div>
                        <span class="ws-status-badge ${o.status.toLowerCase()}" style="font-size:0.75rem; padding:4px 10px;">${o.status}</span>
                    </div>
                </div>

                <!-- Product Details Box -->
                <div style="display:flex; gap:14px; align-items:center; background:#FFFFFF; border:1.5px solid var(--ws-border); border-radius:10px; padding:14px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.03);">
                    <img src="${o.image}" alt="${o.productName}" style="width:72px; height:90px; border-radius:8px; object-fit:cover; border:1px solid var(--ws-border); flex-shrink:0; background:#FAF8F4;" onerror="this.src='images/product1.png';">
                    <div style="flex:1; min-width:0;">
                        <h4 style="font-size:0.96rem; font-weight:800; color:var(--ws-text-main); margin-bottom:4px; line-height:1.3;">${o.productName}</h4>
                        <div style="display:flex; gap:6px; flex-wrap:wrap; margin-bottom:6px;">
                            <span style="font-size:0.72rem; font-weight:600; background:#FAF8F4; padding:2px 6px; border-radius:4px; border:1px solid var(--ws-border); color:var(--ws-text-sub);">SKU: ${o.sku}</span>
                            <span style="font-size:0.72rem; font-weight:600; background:#FAF8F4; padding:2px 6px; border-radius:4px; border:1px solid var(--ws-border); color:var(--ws-text-sub);">HSN: ${o.hsn}</span>
                            <span style="font-size:0.72rem; font-weight:600; background:#FAF8F4; padding:2px 6px; border-radius:4px; border:1px solid var(--ws-border); color:var(--ws-text-sub);">${o.color || 'Silk Assorted'}</span>
                        </div>
                        <div style="font-size:0.88rem; font-weight:800; color:var(--ws-gold-primary);">
                            ${o.qty} Pcs Lot <span style="font-size:0.76rem; font-weight:600; color:var(--ws-text-muted);">(@ ₹${Number(o.unitPrice).toLocaleString('en-IN')} / Pc)</span>
                        </div>
                    </div>
                </div>

                <!-- Price & Tax Breakdown Card -->
                <div style="background:#FAF8F4; border:1.5px solid var(--ws-gold-border); border-radius:10px; padding:14px 16px; margin-bottom:14px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; font-size:0.84rem;">
                        <span style="color:var(--ws-text-sub); font-weight:600;">Taxable Consignment Value</span>
                        <span style="color:var(--ws-text-main); font-weight:700;">₹${Number(o.subtotal).toLocaleString('en-IN')}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; font-size:0.84rem;">
                        <span style="color:var(--ws-text-sub); font-weight:600;">GST Input Tax (5% CGST + SGST)</span>
                        <span style="color:#15803D; font-weight:700;">+₹${Number(o.tax).toLocaleString('en-IN')}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; font-size:0.84rem;">
                        <span style="color:var(--ws-text-sub); font-weight:600;">Wholesale Volume Discount</span>
                        <span style="color:#15803D; font-weight:700;">-₹${Number(o.discount).toLocaleString('en-IN')}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; padding-top:10px; margin-top:4px; border-top:1.5px dashed var(--ws-border); font-size:1.1rem;">
                        <span style="font-weight:800; color:var(--ws-text-main);">Net Amount Paid</span>
                        <span style="font-weight:900; color:var(--ws-gold-primary);">₹${Number(o.total).toLocaleString('en-IN')}</span>
                    </div>
                </div>

                <!-- Logistics & Payment Strip -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; font-size:0.78rem; background:#FFFFFF; border:1px solid var(--ws-border); border-radius:8px; padding:10px 14px;">
                    <div>
                        <div style="color:var(--ws-text-muted); font-size:0.70rem; text-transform:uppercase; font-weight:700;">Courier Partner</div>
                        <div style="font-weight:700; color:var(--ws-text-main); margin-top:2px;">${o.courier} (AWB: ${o.awb})</div>
                    </div>
                    <div>
                        <div style="color:var(--ws-text-muted); font-size:0.70rem; text-transform:uppercase; font-weight:700;">Payment Mode</div>
                        <div style="font-weight:700; color:var(--ws-text-main); margin-top:2px;">${o.payment}</div>
                    </div>
                </div>
            `;

            if (footer) {
                footer.innerHTML = `
                    <div class="ws-dual-action-grid" style="margin-top:0; padding-top:0; border-top:none;">
                        <button class="ws-btn ws-btn-primary" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#FFFFFF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            <span>GST Bill PDF</span>
                        </button>
                        <button class="ws-btn ws-btn-secondary" onclick='repeatWholesaleOrder(${JSON.stringify(o)})'>
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"></polyline><polyline points="10 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                            <span>Re-Order Lot</span>
                        </button>
                    </div>
                `;
            }

            modal.classList.add('active');
        };

        window.repeatWholesaleOrder = function(o) {
            closeOrderDetailsModal();
            try {
                var raw = localStorage.getItem('kalaniketan_cart');
                var cart = raw ? JSON.parse(raw) : [];
                var exists = cart.find(function(item){ return item.id === o.id || item.name === o.productName; });
                if (exists) {
                    exists.qty = (Number(exists.qty) || 1) + 1;
                } else {
                    cart.push({
                        id: o.id || ('PROD-' + Date.now()),
                        name: o.productName,
                        price: o.unitPrice || 3199,
                        wholesale_price: o.unitPrice || 3199,
                        qty: Number(o.qty) || 12,
                        image: o.image || 'images/product1.png',
                        color: o.color || 'Standard',
                        moq: 12
                    });
                }
                localStorage.setItem('kalaniketan_cart', JSON.stringify(cart));
                window.updateWholesaleCartBadge();
                if (typeof window.openCartDrawer === 'function') {
                    window.openCartDrawer();
                } else {
                    window.showWsToast('🛒 ' + o.productName + ' added to wholesale cart!');
                }
            } catch(e) {
                window.showWsToast('🛒 Added to cart!');
            }
        };

        window.closeOrderDetailsModal = function() {
            var modal = document.getElementById('wsOrderDetailsModal');
            if (modal) modal.classList.remove('active');
        };

        /* ── Official Tax Invoice Modal & Print PDF ── */
        window.openBillInvoiceModal = function(o) {
            closeOrderDetailsModal();
            var modal = document.getElementById('wsBillInvoiceModal');
            if (!modal) return;

            var userRaw = localStorage.getItem('kalaniketan_user');
            var user = userRaw ? JSON.parse(userRaw) : {};

            document.getElementById('invNum').textContent = 'INV-2026-' + o.id.replace(/[^0-9]/g, '');
            document.getElementById('invDate').textContent = o.date;

            var comp = user.companyName || 'Shree Krishna Silks Pvt Ltd';
            var gst = user.gst_number || (user.gst_type === 'gst' ? '24AABCU9603R1ZM' : 'URP (Unregistered)');
            var name = user.name || 'Rajesh Kumar';
            var phone = user.phone || '+91 98765 43210';
            var addr = user.address || 'Shop No. 402, 4th Floor, Millennium Textile Market 2, Ring Road';
            var city = user.city || 'Surat';
            var state = user.state || 'Gujarat';
            var pin = user.pincode || '395002';

            document.getElementById('invBilledTo').innerHTML = `
                <strong>${comp}</strong><br>
                GSTIN: <strong>${gst}</strong><br>
                Attn: ${name} (${phone})<br>
                ${addr}, ${city}, ${state} - ${pin}
            `;

            document.getElementById('invShippedTo').innerHTML = `
                <strong>${comp} Warehouse</strong><br>
                Courier: ${o.courier} (AWB: ${o.awb})<br>
                ${addr}, ${city}, ${state} - ${pin}
            `;

            var tbody = document.getElementById('invItemsTbody');
            tbody.innerHTML = `
                <tr>
                    <td>1</td>
                    <td><strong>${o.productName}</strong><br><span style="color:var(--ws-text-muted); font-size:0.72rem;">SKU: ${o.sku} • ${o.color}</span></td>
                    <td>${o.hsn}</td>
                    <td>${o.qty}</td>
                    <td>₹${Number(o.unitPrice).toLocaleString('en-IN')}</td>
                    <td>₹${Number(o.subtotal).toLocaleString('en-IN')}</td>
                    <td>₹${Number(o.tax).toLocaleString('en-IN')}</td>
                    <td><strong>₹${Number(o.total).toLocaleString('en-IN')}</strong></td>
                </tr>
            `;

            document.getElementById('invSubtotal').textContent = `₹${Number(o.subtotal).toLocaleString('en-IN')}`;
            document.getElementById('invTax').textContent = `₹${Number(o.tax).toLocaleString('en-IN')}`;
            document.getElementById('invGrandTotal').textContent = `₹${Number(o.total).toLocaleString('en-IN')}`;

            modal.classList.add('active');
        };

        window.closeBillInvoiceModal = function() {
            var modal = document.getElementById('wsBillInvoiceModal');
            if (modal) modal.classList.remove('active');
        };

        window.printInvoiceSheet = function() {
            window.print();
        };

        /* ── Trending & For You Products Slider Scrolling ── */
        window.slideTrendingProducts = function(dir) {
            var track = document.getElementById('wsTrendingSliderTrack');
            if (!track) return;
            var scrollAmount = track.offsetWidth * 0.75 * dir;
            track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        };

        window.slideForYouProducts = function(dir) {
            var track = document.getElementById('wsForYouSliderTrack');
            if (!track) return;
            var scrollAmount = track.offsetWidth * 0.75 * dir;
            track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        };

        window.slidePriceBoxes = function(dir) {
            var track = document.getElementById('wsPriceSliderTrack');
            if (!track) return;
            var scrollAmount = track.offsetWidth * 0.75 * dir;
            track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        };

        var activePriceTier = null;

        window.filterByPriceTier = function(maxPrice, cardElem) {
            var cards = document.querySelectorAll('.ws-price-box-card');
            
            if (activePriceTier === maxPrice) {
                // Clicking same tier again resets filter
                activePriceTier = null;
                cards.forEach(function(c) { c.classList.remove('active'); });
                resetCatalogFilter();
                if (typeof window.showWsToast === 'function') {
                    window.showWsToast('✓ Showing All Available Wholesale Lots');
                }
                return;
            }

            activePriceTier = maxPrice;
            cards.forEach(function(c) { c.classList.remove('active'); });

            if (cardElem) {
                cardElem.classList.add('active');
            } else {
                cards.forEach(function(c) {
                    if (c.textContent.indexOf('₹' + Number(maxPrice).toLocaleString('en-IN')) !== -1 || (c.getAttribute('onclick') && c.getAttribute('onclick').indexOf(String(maxPrice)) !== -1)) {
                        c.classList.add('active');
                    }
                });
            }

            var tracks = ['wsForYouSliderTrack', 'wsTrendingSliderTrack'];
            var matchCount = 0;

            tracks.forEach(function(trackId) {
                var track = document.getElementById(trackId);
                if (!track) return;
                var productCards = track.querySelectorAll('.product-card');
                productCards.forEach(function(pCard) {
                    var prodId = pCard.getAttribute('data-product-id');
                    var pData = (window.allProducts || []).find(function(item) { return Number(item.id) === Number(prodId); });
                    var price = pData ? (Number(pData.wholesale_price) || Number(pData.price) || 0) : 0;
                    if (price > 0 && price <= maxPrice) {
                        pCard.style.display = 'flex';
                        matchCount++;
                    } else {
                        pCard.style.display = 'none';
                    }
                });
                track.scrollTo({ left: 0, behavior: 'smooth' });
            });

            if (typeof window.showWsToast === 'function') {
                window.showWsToast('🏷️ Filter Active: Under ₹' + Number(maxPrice).toLocaleString('en-IN') + ' (' + matchCount + ' Lots Available)');
            }

            // Smooth scroll up to the catalog container
            var forYouContainer = document.getElementById('wsForYouSliderTrack');
            if (forYouContainer) {
                forYouContainer.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        };

        window.resetCatalogFilter = function() {
            activePriceTier = null;
            document.querySelectorAll('.ws-price-box-card').forEach(function(c) { c.classList.remove('active'); });
            var tracks = ['wsForYouSliderTrack', 'wsTrendingSliderTrack'];
            tracks.forEach(function(trackId) {
                var track = document.getElementById(trackId);
                if (!track) return;
                track.querySelectorAll('.product-card').forEach(function(pCard) {
                    pCard.style.display = 'flex';
                });
                track.scrollTo({ left: 0, behavior: 'smooth' });
            });
            if (typeof window.showWsToast === 'function') {
                window.showWsToast('✓ Showing All Available Wholesale Lots');
            }
        };

        /* ── Smart 1-Line Auto Slider Engine (For Sliders Only) ── */
        function initSmartCatalogAutoSliders() {
            var sliderIds = ['wsTrendingSliderTrack', 'wsPriceSliderTrack'];
            sliderIds.forEach(function(id) {
                var track = document.getElementById(id);
                if (!track) return;
                var isPaused = false;
                track.addEventListener('mouseenter', function() { isPaused = true; });
                track.addEventListener('mouseleave', function() { isPaused = false; });
                track.addEventListener('touchstart', function() { isPaused = true; }, { passive: true });
                track.addEventListener('touchend', function() {
                    setTimeout(function() { isPaused = false; }, 3000);
                }, { passive: true });

                setInterval(function() {
                    if (isPaused || !track.offsetParent) return;
                    var maxScroll = track.scrollWidth - track.clientWidth;
                    if (track.scrollLeft >= maxScroll - 8) {
                        track.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        var card = track.querySelector('.product-card, .ws-price-box-card');
                        var step = card ? (card.offsetWidth + 12) : 200;
                        track.scrollBy({ left: step, behavior: 'smooth' });
                    }
                }, 4000);
            });
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSmartCatalogAutoSliders);
        } else {
            initSmartCatalogAutoSliders();
        }

        /* ── Direct Add Wholesale Lot to Cart with Smart Button Feedback ── */
        window.directAddWholesaleToCart = function(prod, btn) {
            try {
                var raw = localStorage.getItem('kalaniketan_cart');
                var cart = raw ? JSON.parse(raw) : [];
                var prodId = prod.id;
                var exists = cart.find(function(item) { return Number(item.id) === Number(prodId); });
                var addQty = Number(prod.moq) || 12;
                if (exists) {
                    exists.qty = (Number(exists.qty) || addQty) + addQty;
                } else {
                    cart.push({
                        id: prod.id,
                        name: prod.name,
                        price: Number(prod.wholesale_price) || Number(prod.price) || 2199,
                        wholesale_price: Number(prod.wholesale_price) || 2199,
                        retail_price: Number(prod.retail_price) || 3299,
                        qty: addQty,
                        image: prod.image || 'images/product1.png',
                        color: prod.color || 'Standard',
                        moq: addQty,
                        category: prod.category || 'Wholesale'
                    });
                }
                localStorage.setItem('kalaniketan_cart', JSON.stringify(cart));
                window.updateWholesaleCartBadge();

                // Button Ripple & Check Animation
                if (btn) {
                    btn.classList.add('added');
                    btn.innerHTML = '<svg style="width:14px;height:14px;stroke:#FFFFFF;fill:none;stroke-width:2.8;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>';
                    setTimeout(function() {
                        btn.classList.remove('added');
                        btn.innerHTML = '<svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>';
                    }, 1400);
                }

                if (typeof window.showWsToast === 'function') {
                    window.showWsToast('🛍️ Added ' + prod.name + ' (' + addQty + ' Pcs Lot) to Cart!');
                }
            } catch(e) {
                console.error(e);
            }
        };
        window.openQuickOrderModal = function(prod) {
            var userRaw = localStorage.getItem('kalaniketan_user');
            var user = userRaw ? JSON.parse(userRaw) : {};
            var company = user.companyName || 'Wholesale Buyer';
            var gst = user.gst_number || 'Non-GST';

            var text = `👑 *WHOLESALE BULK LOT INQUIRY — KALANIKETAN B2B*\n\n` +
                       `*Product:* ${prod.name} (SKU: ${prod.sku})\n` +
                       `*HSN Code:* ${prod.hsn}\n` +
                       `*Wholesale Price:* ₹${prod.wholesale_price} / Pc\n` +
                       `*Minimum Order Qty (MOQ):* ${prod.moq} Pcs\n` +
                       `*Lot Tier Pricing:* ${prod.tier_prices || 'Volume Tier'}\n\n` +
                       `*Buyer Business:* ${company}\n` +
                       `*GSTIN:* ${gst}\n` +
                       `*Representative:* ${user.name || 'Member'} (${user.phone || ''})\n\n` +
                       `Please confirm lot availability, dispatch turnaround and proforma payment details.`;

            var waUrl = `https://api.whatsapp.com/send?phone=919876543210&text=${encodeURIComponent(text)}`;
            window.open(waUrl, '_blank');
        };

        /* ── Wholesaler Wishlist Controller ── */
        window.toggleWholesaleWishlist = function(productId, btn) {
            var p = (window.allProducts || []).find(function(item) { return Number(item.id) === Number(productId); });
            if (p && typeof window.toggleWishlistProduct === 'function') {
                var added = window.toggleWishlistProduct(p);
                if (btn) {
                    btn.classList.toggle('active', added);
                    btn.setAttribute('aria-pressed', added ? 'true' : 'false');
                }
                if (typeof showToast === 'function') {
                    showToast(added ? '♡ Saved ' + p.name + ' to Wishlist' : 'Removed from Wishlist');
                } else if (typeof window.showWsToast === 'function') {
                    window.showWsToast(added ? '♡ Saved ' + p.name + ' to Wishlist' : 'Removed from Wishlist');
                }
                return;
            }

            var raw = localStorage.getItem('kalaniketan_wishlist');
            var wish = raw ? JSON.parse(raw) : [];
            var idx = wish.findIndex(function(i){ return Number(i.id) === Number(productId); });
            if (idx > -1) {
                wish.splice(idx, 1);
                if (btn) btn.classList.remove('active');
                if (typeof window.showWsToast === 'function') window.showWsToast('Item removed from Procurement Wishlist');
            } else {
                wish.push({ id: productId });
                if (btn) btn.classList.add('active');
                if (typeof window.showWsToast === 'function') window.showWsToast('Saved to B2B Procurement Wishlist');
            }
            localStorage.setItem('kalaniketan_wishlist', JSON.stringify(wish));
        };

        /* ── Share Wholesale Lot (Triggers Smart Share or WhatsApp) ── */
        window.shareWholesaleProduct = function(prod) {
            if (typeof window.shareProductCard === 'function' && prod && prod.id) {
                window.shareProductCard(prod.id);
                return;
            }
            var text = `*KALANIKETAN B2B WHOLESALE LOT*\n\n` +
                       `*Product:* ${prod.name} (SKU: ${prod.sku})\n` +
                       `*Wholesale Price:* ₹${prod.wholesale_price} / Pc (Retail MRP: ₹${prod.retail_price})\n` +
                       `*MOQ:* ${prod.moq} Pcs Pack\n` +
                       `*Fabric:* ${prod.fabric || 'Pure Silk'} • HSN: ${prod.hsn}\n` +
                       `*Tier Rates:* ${prod.tier_prices || 'Volume Discounts Available'}\n\n` +
                       `Explore live wholesale portal: ${window.location.origin}/wholesaler.php`;
            var waUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`;
            window.open(waUrl, '_blank');
        };

        /* ── Global Product Card Share Function (Matches shop.php Smart Share) ── */
        window.shareProductCard = function(productId) {
            var p = (window.allProducts || []).find(function(item) { return Number(item.id) === Number(productId); });
            if (p && typeof window.openSmartShareModal === 'function') {
                var itemData = {
                    id: p.id,
                    name: p.name,
                    category: p.category,
                    price: p.price,
                    old_price: p.old_price,
                    discount: p.discount,
                    image: p.image,
                    fabric: p.fabric || 'Pure Silk',
                    colors: Array.isArray(p.colors) ? p.colors.join(', ') : (p.color || ''),
                    sizes: Array.isArray(p.size) ? p.size.join(', ') : 'Free Size',
                    url: 'singelprodut.php?id=' + p.id
                };
                window.openSmartShareModal(itemData);
            } else if (p) {
                var waUrl = 'https://api.whatsapp.com/send?text=' + encodeURIComponent('Check out ' + p.name + ' Wholesale at Kalaniketan: ' + window.location.origin + '/singelprodut.php?id=' + p.id);
                window.open(waUrl, '_blank');
            }
        };

        /* ── Monthly Sales Chart Data & Interactive Tooltips ── */
        var MONTH_SALES_DATA = [
            { m: 'Jan', val: '₹1,24,000', qty: '32 Pcs', growth: '+5.2%' },
            { m: 'Feb', val: '₹3,42,000', qty: '84 Pcs', growth: '+28.4%' },
            { m: 'Mar', val: '₹1,48,000', qty: '38 Pcs', growth: '+4.1%' },
            { m: 'Apr', val: '₹2,88,000', qty: '72 Pcs', growth: '+19.6%' },
            { m: 'May', val: '₹1,36,000', qty: '35 Pcs', growth: '-2.0%' },
            { m: 'Jun', val: '₹1,65,000', qty: '42 Pcs', growth: '+8.3%' },
            { m: 'Jul', val: '₹2,72,000', qty: '68 Pcs', growth: '+15.2%' },
            { m: 'Aug', val: '₹2,05,062', qty: '48 Pcs', growth: '↑ 18.4%' },
            { m: 'Sep', val: '₹1,90,000', qty: '46 Pcs', growth: '+7.5%' },
            { m: 'Oct', val: '₹3,85,000', qty: '96 Pcs', growth: '+32.0%' },
            { m: 'Nov', val: '₹2,48,000', qty: '62 Pcs', growth: '+12.8%' },
            { m: 'Dec', val: '₹1,15,000', qty: '28 Pcs', growth: '-5.0%' }
        ];

        window.showChartNodeTooltip = function(idx) {
            var item = MONTH_SALES_DATA[idx];
            if (!item) return;
            var el = document.getElementById('chartTooltipText');
            if (el) el.textContent = `${item.m}: ${item.val} • ${item.qty} (${item.growth})`;
            document.querySelectorAll('.ws-chart-node').forEach(function(node, i) {
                node.classList.toggle('active', i === idx);
            });
            document.querySelectorAll('.ws-chart-x-axis span').forEach(function(span, i) {
                span.classList.toggle('active', i === idx);
            });
        };

        window.switchSalesChartStyle = function(type, btn) {
            document.querySelectorAll('.ws-chart-type-btn').forEach(function(b) { b.classList.remove('active'); });
            if (btn) btn.classList.add('active');

            var line = document.getElementById('svgLinePath');
            var area = document.getElementById('svgAreaPath');
            if (!line || !area) return;

            if (type === 'smooth') {
                // Smooth curved spline wave (Luxury Cubic Curve)
                var smoothLine = 'M 40,115 C 63,115 63,96 86,96 C 109,96 109,102 132,102 C 155,102 155,85 178,85 C 201,85 201,76 224,76 C 247,76 247,82 270,82 C 293,82 293,62 316,62 C 339,62 339,88 362,88 C 385,88 385,68 408,68 C 431,68 431,38 454,38 C 477,38 477,52 500,52 C 523,52 523,94 546,94';
                var smoothArea = smoothLine + ' L 546,158 L 40,158 Z';
                line.setAttribute('d', smoothLine);
                area.setAttribute('d', smoothArea);
            } else {
                // Crisp Zigzag Lines (Luxury Style)
                var zigzagLine = 'M 40,115 L 86,96 L 132,102 L 178,85 L 224,76 L 270,82 L 316,62 L 362,88 L 408,68 L 454,38 L 500,52 L 546,94';
                var zigzagArea = zigzagLine + ' L 546,158 L 40,158 Z';
                line.setAttribute('d', zigzagLine);
                area.setAttribute('d', zigzagArea);
            }
        };

        /* ── Animate Target Gauge Percentage Count-up ── */
        window.animateTargetGauge = function(targetPercent) {
            var valEl = document.getElementById('targetGaugeVal');
            var fillEl = document.getElementById('targetGaugeFill');
            if (!valEl) return;

            var target = targetPercent || 75.55;
            var start = performance.now();
            var duration = 1200;

            var targetOffset = Math.round(236 - (236 * (target / 100)));
            if (fillEl) fillEl.style.strokeDashoffset = targetOffset;

            function step(time) {
                var progress = Math.min((time - start) / duration, 1);
                var ease = 1 - Math.pow(1 - progress, 3);
                var val = (ease * target).toFixed(2);
                valEl.textContent = val + '%';
                if (progress < 1) {
                    requestAnimationFrame(step);
                } else {
                    valEl.textContent = target.toFixed(2) + '%';
                }
            }
            requestAnimationFrame(step);
        };

        /* ── Wholesaler Logout ── */
        window.handleWholesalerLogout = function() {
            if (confirm('Are you sure you want to log out of the Wholesaler Portal?')) {
                localStorage.removeItem('kalaniketan_user');
                window.location.href = 'shop.php';
            }
        };

        /* ── Initialize Application ── */
        function initWholesalerApp() {
            if (!checkWholesalerSecurity()) return;

            var products = <?= json_encode(array_map(function($p) {
                return [
                    'id' => $p['id'],
                    'name' => $p['name'],
                    'category' => $p['category'],
                    'price' => $p['wholesale_price'],
                    'old_price' => $p['retail_price'],
                    'discount' => round((($p['retail_price'] - $p['wholesale_price']) / $p['retail_price']) * 100),
                    'image' => $p['image'],
                    'badge' => $p['badge'] ?? null,
                    'rating' => 4.9,
                    'color' => $p['color'] ?? 'Standard',
                    'colors' => [$p['color'] ?? 'Standard'],
                    'size' => ['MOQ: ' . $p['moq'] . ' Pcs Lot', '2x Lot (' . ($p['moq']*2) . ' Pcs)', '5x Lot (' . ($p['moq']*5) . ' Pcs)'],
                    'fabric' => $p['fabric'] ?? 'Pure Silk',
                    'in_stock' => true,
                    'sku' => $p['sku'] ?? 'SKU-'.$p['id'],
                    'hsn' => $p['hsn'] ?? '5007'
                ];
            }, $catalogProducts)) ?>;
            window.allProducts = products;

            activeOrdersList = SAMPLE_ORDERS.slice();
            activeTicketsList = SAMPLE_TICKETS.slice();

            loadSavedWholesalerData();
            renderOrdersView(activeOrdersList);
            renderReportsView(activeOrdersList);
            renderTrackingTab(activeOrdersList);
            renderTicketsView();
            window.animateTargetGauge(75.55);
            window.updateWholesaleCartBadge();
        }

        /* ── Live Shipment Tracking Controller ── */
        var activeTrackOrderId = 'KLN-WS-8021';
        var currentTrackFilter = 'all';

        function renderTrackingTab(orders, selectedId) {
            if (selectedId) activeTrackOrderId = selectedId;
            var heroContainer = document.getElementById('wsActiveTrackHero');
            var gridContainer = document.getElementById('wsTrackingOrdersGrid');
            var headerBadge = document.getElementById('trackHeaderBadge');
            if (!heroContainer || !gridContainer) return;

            var list = orders || activeOrdersList;
            var currentOrder = list.find(function(o){ return o.id === activeTrackOrderId; }) || list[0];
            if (!currentOrder) return;
            activeTrackOrderId = currentOrder.id;

            if (headerBadge) {
                headerBadge.className = 'ws-status-badge ' + currentOrder.status.toLowerCase();
                headerBadge.innerHTML = '⚡ ' + currentOrder.courier;
            }

            // 1. Render Active Hero Card
            var isDelivered = currentOrder.status.toLowerCase() === 'delivered';
            var isProcessing = currentOrder.status.toLowerCase() === 'processing';

            var etaText = isDelivered ? 'Delivered on ' + currentOrder.date : (isProcessing ? 'Dispatching from Atelier' : 'Tomorrow, 17 Aug 2026');
            var etaColor = isDelivered ? '#15803D' : (isProcessing ? '#B45309' : 'var(--ws-gold-primary)');

            heroContainer.innerHTML = `
                <!-- Top Header: Consignment ID + Status Pill + ETA -->
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:12px; padding-bottom:10px; border-bottom:1px dashed var(--ws-border);">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span class="ws-order-id-cell" style="font-size:1.05rem; font-weight:800;">${currentOrder.id}</span>
                        <span class="ws-status-badge ${currentOrder.status.toLowerCase()}" style="font-size:0.75rem; padding:3px 8px;">${currentOrder.status}</span>
                    </div>
                    <div style="font-size:0.80rem; font-weight:800; color:${etaColor};">
                        📅 ${etaText}
                    </div>
                </div>

                <!-- Product & Courier Info Strip -->
                <div style="display:flex; gap:12px; align-items:center; margin-bottom:14px; background:#FFFFFF; border:1px solid var(--ws-border); border-radius:8px; padding:10px 12px; box-shadow:0 1px 3px rgba(0,0,0,0.02);">
                    <img src="${currentOrder.image}" alt="${currentOrder.productName}" style="width:54px; height:68px; border-radius:6px; object-fit:cover; border:1px solid var(--ws-border); flex-shrink:0; background:#FAF8F4;" onerror="this.src='images/product1.png';">
                    <div style="flex:1; min-width:0;">
                        <h4 style="font-size:0.92rem; font-weight:800; color:var(--ws-text-main); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:2px;">${currentOrder.productName}</h4>
                        <div style="font-size:0.74rem; color:var(--ws-text-muted); margin-bottom:4px;">
                            Consignment Lot: <strong>${currentOrder.qty} Pcs</strong> • ${currentOrder.color || 'Standard'}
                        </div>
                        <div style="font-size:0.74rem; color:var(--ws-text-sub); display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                            <span>${currentOrder.courier}</span>
                            <span style="font-family:monospace; background:#FAF8F4; padding:1px 6px; border-radius:4px; border:1px solid var(--ws-border); font-weight:700;">${currentOrder.awb}</span>
                            <button onclick="copyAwbNumber('${currentOrder.awb}')" style="background:transparent; border:none; color:var(--ws-gold-primary); cursor:pointer; display:inline-flex; align-items:center; justify-content:center; padding:2px;" title="Copy AWB">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step-by-Step Logistics Milestones Timeline -->
                <div class="ws-track-timeline">
                    <div class="ws-timeline-step completed">
                        <div class="ws-timeline-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                        <div class="ws-timeline-title">Order Confirmed & Proforma Invoiced</div>
                        <div class="ws-timeline-date">Kalaniketan Head Atelier, Surat • ${currentOrder.date}, 10:30 AM</div>
                    </div>
                    <div class="ws-timeline-step ${isProcessing ? 'active' : 'completed'}">
                        <div class="ws-timeline-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                        <div class="ws-timeline-title">QC Inspection & Sealed Bale Packaging Completed</div>
                        <div class="ws-timeline-date">Zari & Silk Logistics Warehouse • Verified for Transit</div>
                    </div>
                    <div class="ws-timeline-step ${isDelivered ? 'completed' : (isProcessing ? '' : 'active')}">
                        <div class="ws-timeline-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                        <div class="ws-timeline-title">${isDelivered ? 'Transit Completed — Received at Warehouse Godown' : 'In Transit — Dispatched via Priority Air Cargo'}</div>
                        <div class="ws-timeline-date">${currentOrder.courier} (AWB: ${currentOrder.awb}) • Live GPS Tracking Active</div>
                    </div>
                    <div class="ws-timeline-step ${isDelivered ? 'completed' : ''}">
                        <div class="ws-timeline-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                        <div class="ws-timeline-title">${isDelivered ? 'Delivered & Consignment Accepted' : 'Out for Final Delivery'}</div>
                        <div class="ws-timeline-date">${isDelivered ? 'Delivered on ' + currentOrder.date + ' with OTP Verification' : 'Expected delivery window: 10:00 AM - 04:00 PM'}</div>
                    </div>
                </div>

                <!-- Action Buttons: Clean Dual Grid with Auto Sizes -->
                <div class="ws-dual-action-grid">
                    <button class="ws-btn ws-btn-primary" onclick='openBillInvoiceModal(${JSON.stringify(currentOrder)})'>
                        <svg viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>GST Invoice</span>
                    </button>
                    <button class="ws-btn ws-btn-secondary" onclick='viewOrderDetails(${JSON.stringify(currentOrder)})'>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <span>Order Details</span>
                    </button>
                </div>
            `;

            // 2. Render All Consignments List
            gridContainer.innerHTML = '';
            var filteredList = list.filter(function(o) {
                if (currentTrackFilter === 'all') return true;
                return o.status.toLowerCase() === currentTrackFilter.toLowerCase();
            });

            filteredList.forEach(function(o) {
                var isSelected = o.id === activeTrackOrderId;
                var card = document.createElement('div');
                card.className = 'ws-track-order-card' + (isSelected ? ' selected' : '');
                card.onclick = function() {
                    selectTrackingOrder(o.id);
                };
                card.innerHTML = `
                    <img src="${o.image}" alt="${o.productName}" class="ws-track-order-img" onerror="this.src='images/product1.png';">
                    <div class="ws-track-order-info">
                        <div style="display:flex; justify-content:space-between; align-items:center; gap:6px;">
                            <strong class="ws-order-id-cell" style="font-size:0.86rem;">${o.id}</strong>
                            <span class="ws-status-badge ${o.status.toLowerCase()}" style="font-size:0.65rem;">${o.status}</span>
                        </div>
                        <div class="ws-track-order-title">${o.productName}</div>
                        <div style="font-size:0.74rem; color:var(--ws-text-muted);">
                            ${o.date} • <strong>${o.qty} Pcs</strong> • ${o.courier}
                        </div>
                        <div style="font-size:0.72rem; color:var(--ws-gold-primary); font-weight:700; margin-top:2px;">
                            ${isSelected ? '● Currently Tracking' : '⚡ Track Consignment ›'}
                        </div>
                    </div>
                `;
                gridContainer.appendChild(card);
            });
        }

        window.selectTrackingOrder = function(orderId) {
            activeTrackOrderId = orderId;
            renderTrackingTab(activeOrdersList, orderId);
            var hero = document.getElementById('wsActiveTrackHero');
            if (hero) {
                hero.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            window.showWsToast('📍 Loaded tracking timeline for ' + orderId);
        };

        window.filterTrackingOrders = function(status, btn) {
            currentTrackFilter = status;
            if (btn && btn.parentElement) {
                btn.parentElement.querySelectorAll('button').forEach(function(b){ b.classList.remove('active'); });
                btn.classList.add('active');
            }
            renderTrackingTab(activeOrdersList, activeTrackOrderId);
        };

        window.copyAwbNumber = function(awb) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(awb).then(function() {
                    window.showWsToast('📋 AWB ' + awb + ' copied to clipboard!');
                }).catch(function() {
                    window.showWsToast('AWB: ' + awb);
                });
            } else {
                window.showWsToast('AWB: ' + awb);
            }
        };

        /* ── Wholesale VIP Tier Controller ── */
        window.getWholesaleTier = function(orderCount) {
            var count = Number(orderCount) || 0;
            if (count >= 1000) {
                return {
                    tierNum: 5,
                    title: "Tier 5: Platinum",
                    shortTitle: "Platinum (Tier 5)",
                    badgeText: "👑 Platinum VIP",
                    pillText: "1000+ Orders",
                    discount: "15% Margin Rebate",
                    minOrders: 1000,
                    maxOrders: Infinity,
                    nextGoal: "Top VIP Tier Reached"
                };
            } else if (count >= 301) {
                return {
                    tierNum: 4,
                    title: "Tier 4: Gold",
                    shortTitle: "Gold (Tier 4)",
                    badgeText: "⭐ Gold VIP",
                    pillText: "300–500 Orders",
                    discount: "10% Margin Rebate",
                    minOrders: 301,
                    maxOrders: 500,
                    nextGoal: (1000 - count) + " orders to Tier 5 Platinum"
                };
            } else if (count >= 201) {
                return {
                    tierNum: 3,
                    title: "Tier 3: Gold",
                    shortTitle: "Gold (Tier 3)",
                    badgeText: "⭐ Gold VIP",
                    pillText: "200–300 Orders",
                    discount: "7.5% Margin Rebate",
                    minOrders: 201,
                    maxOrders: 300,
                    nextGoal: (301 - count) + " orders to Tier 4 Gold"
                };
            } else if (count >= 51) {
                return {
                    tierNum: 2,
                    title: "Tier 2: Silver",
                    shortTitle: "Silver (Tier 2)",
                    badgeText: "🥈 Silver VIP",
                    pillText: "50–200 Orders",
                    discount: "5% Margin Rebate",
                    minOrders: 51,
                    maxOrders: 200,
                    nextGoal: (201 - count) + " orders to Tier 3 Gold"
                };
            } else {
                return {
                    tierNum: 1,
                    title: "Tier 1: Non VIP",
                    shortTitle: "Non VIP (Tier 1)",
                    badgeText: "Standard Member",
                    pillText: "1–50 Orders",
                    discount: "Standard Wholesale",
                    minOrders: 1,
                    maxOrders: 50,
                    nextGoal: (51 - count) + " orders to Tier 2 Silver"
                };
            }
        };

        window.openVipTierModal = function() {
            var modal = document.getElementById('wsVipTierModal');
            if (modal) modal.classList.add('active');
        };

        window.closeVipTierModal = function() {
            var modal = document.getElementById('wsVipTierModal');
            if (modal) modal.classList.remove('active');
        };

        /* ── Wholesale Wallet Controller ── */
        window.openFullWalletModal = function() {
            var modal = document.getElementById('wsFullWalletModal');
            if (modal) modal.classList.add('active');
        };

        window.closeFullWalletModal = function() {
            var modal = document.getElementById('wsFullWalletModal');
            if (modal) modal.classList.remove('active');
        };

        window.openWalletTopupModal = function() {
            var modal = document.getElementById('wsWalletTopupModal');
            if (modal) modal.classList.add('active');
        };

        window.closeWalletTopupModal = function() {
            var modal = document.getElementById('wsWalletTopupModal');
            if (modal) modal.classList.remove('active');
        };

        window.setTopupAmount = function(amount, btn) {
            var input = document.getElementById('wsTopupAmountInput');
            if (input) input.value = amount;
            if (btn && btn.parentElement) {
                btn.parentElement.querySelectorAll('button').forEach(function(b){ b.classList.remove('active'); });
                btn.classList.add('active');
            }
        };

        window.handleProcessWalletTopup = function() {
            var input = document.getElementById('wsTopupAmountInput');
            var amount = Number(input ? input.value : 50000);
            if (!amount || amount < 1000) {
                alert('Please enter a valid recharge amount (min ₹1,000)');
                return;
            }
            closeWalletTopupModal();
            var current = 45280;
            try {
                var saved = localStorage.getItem('kalaniketan_wallet_cash');
                if (saved) current = Number(saved);
            } catch(e) {}
            var newBal = current + amount;
            localStorage.setItem('kalaniketan_wallet_cash', newBal);
            
            var cashEl = document.getElementById('walletCashBalance');
            var availEl = document.getElementById('walletAvailableBalance');
            var modalBal = document.getElementById('modalCurrentWalletBal');
            if (cashEl) cashEl.textContent = '₹' + newBal.toLocaleString('en-IN');
            if (availEl) availEl.textContent = (newBal + 100000).toLocaleString('en-IN');
            if (modalBal) modalBal.textContent = '₹' + newBal.toLocaleString('en-IN');

            window.showWsToast('💳 Wallet recharged with ₹' + amount.toLocaleString('en-IN') + ' successfully!');
        };

        window.requestCreditLimitBoost = function() {
            window.showWsToast('⚡ Credit Limit Boost Request submitted to Kalaniketan Credit Desk!');
        };

        window.requestWalletWithdrawal = function() {
            window.showWsToast('🏦 Payout withdrawal request for available balance submitted to registered Bank A/C!');
        };

        /* ── Wholesale Cart Badge Synchronization ── */
        window.updateWholesaleCartBadge = function() {
            try {
                var raw = localStorage.getItem('kalaniketan_cart');
                var cart = raw ? JSON.parse(raw) : [];
                var totalCount = 0;
                if (Array.isArray(cart)) {
                    totalCount = cart.reduce(function(acc, item) { return acc + (Number(item.qty) || 1); }, 0);
                }
                var dockBadge = document.getElementById('wsDockCartBadge');
                var hdrBadge = document.getElementById('headerCartBadge');
                [dockBadge, hdrBadge].forEach(function(badge) {
                    if (badge) {
                        if (totalCount > 0) {
                            badge.textContent = totalCount;
                            badge.style.display = 'flex';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                });
            } catch(e) {}
        };

        /* ── Wholesale Wishlist Badge Synchronization ── */
        window.updateWholesaleWishlistBadge = function() {
            try {
                var raw = localStorage.getItem('kalaniketan_wishlist');
                var wishlist = raw ? JSON.parse(raw) : [];
                var count = Array.isArray(wishlist) ? wishlist.length : 0;
                var badge = document.getElementById('headerWishlistBadge');
                if (badge) {
                    if (count > 0) {
                        badge.textContent = count;
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            } catch(e) {}
        };

        document.addEventListener('DOMContentLoaded', function() {
            initWholesalerApp();
            window.updateWholesaleCartBadge();
            window.updateWholesaleWishlistBadge();
        });
        window.addEventListener('storage', function(e) {
            if (e.key === 'kalaniketan_user') {
                initWholesalerApp();
            }
            if (e.key === 'kalaniketan_cart') {
                window.updateWholesaleCartBadge();
            }
            if (e.key === 'kalaniketan_wishlist') {
                window.updateWholesaleWishlistBadge();
            }
        });

    })();
    </script>

    <!-- ════════════ CART DRAWER PARTIAL ════════════ -->
    <?php include 'cart.php'; ?>

    <!-- ════════════ CHECKOUT MODAL PARTIAL ════════════ -->
    <?php include 'checkout.php'; ?>

    <!-- ════════════ QUICK VIEW PARTIAL ════════════ -->
    <?php include 'quickview.php'; ?>

    <!-- ════════════ SMART WHATSAPP SHARE MODAL ════════════ -->
    <?php include 'smartshare.php'; ?>

    <!-- ════════════ WISHLIST PARTIAL ════════════ -->
    <?php include 'wishlist.php'; ?>
</body>
</html>
