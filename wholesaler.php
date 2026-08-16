<?php
/**
 * wholesaler.php — DT Arniya / Kalaniketan Luxury B2B Wholesale Hub
 * Mobile-First & Desktop Dashboard matching reference UI with signature Gold brand system.
 * 
 * Key Elements:
 * - Brand Header with Hamburger Drawer, Logo & Active Cart/Notification Badges
 * - Welcome VIP User Banner Card with Verified Badge & Crown Seal
 * - 4 Metric Stat Cards (Total Orders, Total Purchases, Total Savings, Wallet Balance)
 * - 8 Quick Action Tiles (New Order, Categories, Products, My Orders, Wallet, Invoices, Stock Update, Payment)
 * - Big Sale Offer Promo Carousel with Gold Shimmer & 3D Packaging Visuals
 * - Recent Orders Section with Multi-Product Collage, Price & Delivery Status Badges
 * - Master B2B Product Catalog with Tier Pricing, MOQ & Bulk Order System
 * - Full Wholesale Sidebar / Drawer (Profile, Price Tier, Nav Links, Refer & Earn, WhatsApp Help)
 * - Mobile Fixed Bottom Navigation Bar (Dashboard, Categories, Orders, Products, Account)
 */

$catalogProducts = [
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
    <title>DT Arniya Wholesale Hub — B2B Procurement Portal</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            /* ── Signature Heritage Gold Brand Colors ── */
            --ws-gold: #8A681F;
            --ws-gold-dark: #6E5114;
            --ws-gold-light: #C5A859;
            --ws-gold-pale: #FAF6ED;
            --ws-gold-bg: #FDFBF7;
            --ws-gold-border: rgba(138, 104, 31, 0.22);
            --ws-gold-glow: rgba(197, 168, 89, 0.35);

            --ws-dark: #16130F;
            --ws-dark-card: #201B15;
            --ws-text-main: #1C1917;
            --ws-text-sub: #4A443D;
            --ws-text-muted: #78716C;
            --ws-border: #EAE5DC;
            --ws-card-bg: #FFFFFF;
            --ws-page-bg: #F8F6F0;

            --ws-purple: #6366F1;
            --ws-purple-bg: #EEF2FF;
            --ws-blue: #0EA5E9;
            --ws-blue-bg: #E0F2FE;
            --ws-green: #10B981;
            --ws-green-bg: #D1FAE5;
            --ws-orange: #F59E0B;
            --ws-orange-bg: #FEF3C7;
            --ws-red: #EF4444;
            --ws-red-bg: #FEE2E2;

            --ws-font-sans: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --ws-font-serif: 'Cinzel', serif;

            --ws-radius-sm: 8px;
            --ws-radius-md: 14px;
            --ws-radius-lg: 18px;
            --ws-radius-xl: 24px;
            --ws-shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.04);
            --ws-shadow-md: 0 4px 16px rgba(138, 104, 31, 0.08);
            --ws-shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: var(--ws-font-sans);
            background: var(--ws-page-bg);
            color: var(--ws-text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Top Header Navigation Bar ── */
        .ws-header {
            position: sticky;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            background: #FFFFFF;
            border-bottom: 1.5px solid var(--ws-gold-border);
            box-shadow: var(--ws-shadow-sm);
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 16px;
        }
        .ws-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .ws-header-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            color: var(--ws-text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            transition: all 0.2s ease;
        }
        .ws-header-btn:hover {
            background: var(--ws-gold-pale);
            color: var(--ws-gold);
        }
        .ws-header-btn svg {
            width: 22px;
            height: 22px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
        }
        .ws-brand-title {
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .ws-brand-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--ws-gold) 0%, var(--ws-gold-dark) 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            box-shadow: 0 2px 8px var(--ws-gold-glow);
        }
        .ws-brand-icon svg {
            width: 18px;
            height: 18px;
            fill: currentColor;
        }
        .ws-brand-text h1 {
            font-family: var(--ws-font-serif);
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--ws-gold-dark);
            letter-spacing: 0.06em;
            line-height: 1.1;
        }
        .ws-brand-text span {
            font-size: 0.58rem;
            font-weight: 700;
            color: var(--ws-text-muted);
            letter-spacing: 0.16em;
            text-transform: uppercase;
            display: block;
        }

        .ws-header-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .ws-icon-badge-btn {
            position: relative;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            border: 1px solid var(--ws-border);
            background: var(--ws-card-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ws-text-sub);
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .ws-icon-badge-btn:hover {
            border-color: var(--ws-gold);
            color: var(--ws-gold);
            transform: translateY(-1px);
        }
        .ws-icon-badge-btn svg {
            width: 19px;
            height: 19px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }
        .ws-count-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 18px;
            height: 18px;
            padding: 0 4px;
            border-radius: 9px;
            background: var(--ws-red);
            color: #FFFFFF;
            font-size: 0.64rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #FFFFFF;
            box-shadow: 0 2px 4px rgba(0,0,0,0.15);
        }
        .ws-count-badge.gold {
            background: var(--ws-gold);
        }

        /* ── Main App Layout Grid ── */
        .ws-app-container {
            width: 100%;
            max-width: 1380px;
            margin: 0 auto;
            padding: 16px;
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 20px;
            flex: 1;
        }
        @media (max-width: 1024px) {
            .ws-app-container {
                grid-template-columns: 1fr;
                padding: 12px 12px 80px;
                gap: 16px;
            }
        }

        /* ── Left Content Main Column ── */
        .ws-main-feed {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* 1. Welcome VIP User Banner Card */
        .ws-vip-banner-card {
            background: #FFFFFF;
            border-radius: var(--ws-radius-lg);
            border: 1px solid var(--ws-gold-border);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--ws-shadow-sm);
            position: relative;
            overflow: hidden;
        }
        .ws-vip-banner-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 4px; height: 100%;
            background: linear-gradient(180deg, var(--ws-gold) 0%, var(--ws-gold-light) 100%);
        }
        .ws-vip-meta {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .ws-vip-greeting {
            font-size: 0.8rem;
            color: var(--ws-text-muted);
            font-weight: 500;
        }
        .ws-vip-name-row {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .ws-vip-name {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--ws-text-main);
            letter-spacing: -0.01em;
        }
        .ws-verified-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 12px;
            background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
            color: #FFFFFF;
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            box-shadow: 0 2px 6px rgba(99, 102, 241, 0.25);
        }
        .ws-verified-pill.gold {
            background: linear-gradient(135deg, var(--ws-gold) 0%, var(--ws-gold-dark) 100%);
            box-shadow: 0 2px 6px var(--ws-gold-glow);
        }
        .ws-vip-sub {
            font-size: 0.74rem;
            color: var(--ws-text-muted);
            font-weight: 500;
        }
        .ws-vip-seal-box {
            width: 64px;
            height: 64px;
            background: var(--ws-dark);
            border-radius: var(--ws-radius-md);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            border: 1px solid var(--ws-gold);
            box-shadow: 0 4px 14px rgba(0,0,0,0.15);
            flex-shrink: 0;
            text-align: center;
            padding: 6px;
        }
        .ws-vip-seal-box svg {
            width: 22px;
            height: 22px;
            color: var(--ws-gold-light);
            margin-bottom: 2px;
        }
        .ws-vip-seal-text {
            font-family: var(--ws-font-serif);
            font-size: 0.62rem;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: 0.08em;
            line-height: 1.1;
        }
        .ws-vip-seal-sub {
            font-size: 0.44rem;
            color: var(--ws-gold-light);
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        /* 2. 4 Metric Stat Cards */
        .ws-metrics-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }
        @media (max-width: 767px) {
            .ws-metrics-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        .ws-metric-card {
            background: #FFFFFF;
            border-radius: var(--ws-radius-md);
            border: 1px solid var(--ws-border);
            padding: 16px 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 8px;
            box-shadow: var(--ws-shadow-sm);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .ws-metric-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--ws-shadow-md);
            border-color: var(--ws-gold-border);
        }
        .ws-metric-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        .ws-metric-icon.purple { background: var(--ws-purple-bg); color: var(--ws-purple); }
        .ws-metric-icon.blue { background: var(--ws-blue-bg); color: var(--ws-blue); }
        .ws-metric-icon.green { background: var(--ws-green-bg); color: var(--ws-green); }
        .ws-metric-icon.orange { background: var(--ws-orange-bg); color: var(--ws-orange); }
        
        .ws-metric-value {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--ws-text-main);
            letter-spacing: -0.02em;
        }
        .ws-metric-label {
            font-size: 0.72rem;
            color: var(--ws-text-muted);
            font-weight: 600;
        }
        .ws-metric-footer {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--ws-text-sub);
        }
        .ws-metric-footer a {
            color: var(--ws-gold);
            text-decoration: none;
            font-weight: 700;
        }

        /* 3. Quick Actions Grid (8 Tiles) */
        .ws-section-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--ws-text-main);
            margin-top: 4px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .ws-quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }
        .ws-action-tile {
            background: #FFFFFF;
            border-radius: var(--ws-radius-md);
            border: 1px solid var(--ws-border);
            padding: 16px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            cursor: pointer;
            box-shadow: var(--ws-shadow-sm);
            transition: all 0.2s ease;
        }
        .ws-action-tile:hover {
            transform: translateY(-3px);
            border-color: var(--ws-gold);
            box-shadow: var(--ws-shadow-md);
        }
        .ws-action-tile:active {
            transform: scale(0.96);
        }
        .ws-action-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            transition: transform 0.2s ease;
        }
        .ws-action-tile:hover .ws-action-icon {
            transform: scale(1.1);
        }
        .ws-action-icon.c1 { background: #F3E8FF; color: #9333EA; }
        .ws-action-icon.c2 { background: #E0F2FE; color: #0284C7; }
        .ws-action-icon.c3 { background: #DCFCE7; color: #16A34A; }
        .ws-action-icon.c4 { background: #FFEDD5; color: #EA580C; }
        .ws-action-icon.c5 { background: #FCE7F3; color: #DB2777; }
        .ws-action-icon.c6 { background: #E0E7FF; color: #4F46E5; }
        .ws-action-icon.c7 { background: #F5F3FF; color: #7C3AED; }
        .ws-action-icon.c8 { background: #E0F2FE; color: #0891B2; }

        .ws-action-label {
            font-size: 0.74rem;
            font-weight: 700;
            color: var(--ws-text-main);
            text-align: center;
            white-space: nowrap;
        }

        /* 4. Big Sale Promo Banner Carousel */
        .ws-promo-carousel {
            position: relative;
            border-radius: var(--ws-radius-lg);
            overflow: hidden;
            background: linear-gradient(135deg, #4338CA 0%, #6366F1 50%, #818CF8 100%);
            color: #FFFFFF;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.25);
            padding: 24px 20px;
        }
        .ws-promo-carousel.gold-theme {
            background: linear-gradient(135deg, #5A4210 0%, #8A681F 50%, #C5A859 100%);
            box-shadow: 0 8px 24px var(--ws-gold-glow);
        }
        .ws-promo-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        .ws-promo-text h2 {
            font-family: var(--ws-font-serif);
            font-size: 1.35rem;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: 0.04em;
            margin-bottom: 4px;
        }
        .ws-promo-text p {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 14px;
            line-height: 1.35;
        }
        .ws-promo-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #FFFFFF;
            color: var(--ws-gold-dark);
            font-size: 0.76rem;
            font-weight: 800;
            padding: 8px 18px;
            border-radius: 20px;
            text-decoration: none;
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
            transition: all 0.2s ease;
        }
        .ws-promo-btn:hover {
            transform: scale(1.04);
            background: var(--ws-gold-pale);
        }
        .ws-promo-graphic {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .ws-promo-gift-bag {
            width: 80px;
            height: 90px;
            background: linear-gradient(135deg, #D4AF37 0%, #8A681F 100%);
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
            border: 1.5px solid rgba(255,255,255,0.4);
            transform: rotate(-4deg);
        }
        .ws-promo-gift-bag span {
            font-size: 1.6rem;
        }
        .ws-promo-gift-bag b {
            font-size: 0.58rem;
            letter-spacing: 0.08em;
            font-family: var(--ws-font-serif);
        }
        .ws-promo-dots {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 14px;
        }
        .ws-pdot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(255,255,255,0.4);
            transition: all 0.2s;
        }
        .ws-pdot.active {
            width: 18px;
            border-radius: 8px;
            background: #FFFFFF;
        }

        /* 5. Recent Orders Section */
        .ws-card-container {
            background: #FFFFFF;
            border-radius: var(--ws-radius-lg);
            border: 1px solid var(--ws-border);
            padding: 16px;
            box-shadow: var(--ws-shadow-sm);
        }
        .ws-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }
        .ws-card-title {
            font-size: 1rem;
            font-weight: 800;
            color: var(--ws-text-main);
        }
        .ws-card-link {
            font-size: 0.74rem;
            font-weight: 700;
            color: var(--ws-gold);
            text-decoration: none;
        }
        .ws-card-link:hover {
            text-decoration: underline;
        }

        .ws-orders-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .ws-order-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px;
            border-radius: var(--ws-radius-md);
            background: var(--ws-gold-bg);
            border: 1px solid var(--ws-border);
            transition: all 0.2s ease;
            gap: 12px;
        }
        .ws-order-row:hover {
            background: #FFFFFF;
            border-color: var(--ws-gold-border);
            box-shadow: var(--ws-shadow-sm);
        }
        .ws-order-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .ws-thumb-collage {
            display: flex;
            align-items: center;
            gap: 3px;
            flex-shrink: 0;
        }
        .ws-thumb-img {
            width: 32px;
            height: 42px;
            border-radius: 4px;
            object-fit: cover;
            border: 1px solid rgba(0,0,0,0.08);
            background: #EFEFEF;
        }
        .ws-order-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .ws-order-id {
            font-size: 0.84rem;
            font-weight: 800;
            color: var(--ws-text-main);
        }
        .ws-order-price {
            font-size: 0.88rem;
            font-weight: 800;
            color: var(--ws-gold-dark);
        }
        .ws-order-sub {
            font-size: 0.68rem;
            color: var(--ws-text-muted);
            font-weight: 500;
        }

        .ws-order-right {
            text-align: right;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
            flex-shrink: 0;
        }
        .ws-order-date {
            font-size: 0.68rem;
            color: var(--ws-text-muted);
            font-weight: 600;
        }
        .ws-status-badge {
            font-size: 0.68rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 8px;
            display: inline-block;
        }
        .ws-status-badge.delivered {
            color: var(--ws-green);
            background: var(--ws-green-bg);
        }
        .ws-status-badge.processing {
            color: var(--ws-orange);
            background: var(--ws-orange-bg);
        }
        .ws-status-badge.shipped {
            color: var(--ws-blue);
            background: var(--ws-blue-bg);
        }

        /* ── Right Sidebar / Navigation Panel ── */
        .ws-sidebar-panel {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* Profile & Price Tier Card */
        .ws-profile-card {
            background: linear-gradient(180deg, #4338CA 0%, #312E81 100%);
            border-radius: var(--ws-radius-lg);
            color: #FFFFFF;
            padding: 20px 16px;
            box-shadow: var(--ws-shadow-md);
        }
        .ws-profile-card.gold-theme {
            background: linear-gradient(180deg, #2D2314 0%, #17130E 100%);
            border: 1px solid var(--ws-gold-border);
        }
        .ws-profile-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }
        .ws-profile-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #000000;
            border: 2px solid var(--ws-gold-light);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ws-gold-light);
            font-family: var(--ws-font-serif);
            font-size: 0.8rem;
            font-weight: 800;
            flex-shrink: 0;
        }
        .ws-profile-details {
            flex: 1;
            overflow: hidden;
        }
        .ws-profile-name {
            font-size: 0.95rem;
            font-weight: 800;
            color: #FFFFFF;
        }
        .ws-profile-email {
            font-size: 0.72rem;
            color: rgba(255,255,255,0.7);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 4px;
        }
        .ws-verified-tag {
            display: inline-block;
            font-size: 0.62rem;
            font-weight: 700;
            color: #FFFFFF;
            background: rgba(255,255,255,0.18);
            backdrop-filter: blur(4px);
            padding: 2px 8px;
            border-radius: 10px;
        }

        /* Tier Box inside Profile */
        .ws-tier-box {
            background: rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(197, 168, 89, 0.4);
            border-radius: var(--ws-radius-md);
            padding: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .ws-tier-box:hover {
            background: rgba(0, 0, 0, 0.5);
            border-color: var(--ws-gold-light);
        }
        .ws-tier-title {
            font-size: 0.68rem;
            color: rgba(255,255,255,0.7);
            font-weight: 600;
        }
        .ws-tier-name {
            font-size: 0.84rem;
            font-weight: 800;
            color: var(--ws-gold-light);
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .ws-tier-validity {
            font-size: 0.62rem;
            color: rgba(255,255,255,0.6);
        }
        .ws-tier-arrow {
            font-size: 1.1rem;
            color: var(--ws-gold-light);
        }

        /* Sidebar Nav List */
        .ws-nav-menu-card {
            background: #FFFFFF;
            border-radius: var(--ws-radius-lg);
            border: 1px solid var(--ws-border);
            padding: 8px 0;
            box-shadow: var(--ws-shadow-sm);
        }
        .ws-nav-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 18px;
            color: var(--ws-text-main);
            text-decoration: none;
            font-size: 0.84rem;
            font-weight: 600;
            transition: all 0.15s ease;
            cursor: pointer;
        }
        .ws-nav-item:hover {
            background: var(--ws-gold-pale);
            color: var(--ws-gold-dark);
        }
        .ws-nav-item.active {
            background: var(--ws-gold-pale);
            color: var(--ws-gold-dark);
            font-weight: 800;
            border-left: 3px solid var(--ws-gold);
        }
        .ws-nav-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .ws-nav-icon {
            font-size: 1.05rem;
            width: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ws-nav-arrow {
            font-size: 0.85rem;
            color: var(--ws-text-muted);
        }
        .ws-nav-badge {
            background: var(--ws-red);
            color: #FFFFFF;
            font-size: 0.64rem;
            font-weight: 800;
            padding: 1px 6px;
            border-radius: 10px;
            margin-left: auto;
            margin-right: 8px;
        }

        /* Refer & Earn Banner */
        .ws-refer-card {
            background: linear-gradient(135deg, #EDE9FE 0%, #DDD6FE 100%);
            border-radius: var(--ws-radius-lg);
            border: 1px solid #C4B5FD;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }
        .ws-refer-card.gold-theme {
            background: linear-gradient(135deg, #FAF5E8 0%, #F5EBD0 100%);
            border: 1px solid var(--ws-gold-border);
        }
        .ws-refer-info h3 {
            font-size: 0.9rem;
            font-weight: 800;
            color: var(--ws-gold-dark);
            margin-bottom: 2px;
        }
        .ws-refer-info p {
            font-size: 0.72rem;
            color: var(--ws-text-sub);
            margin-bottom: 8px;
            line-height: 1.3;
        }
        .ws-refer-btn {
            display: inline-block;
            background: var(--ws-gold-dark);
            color: #FFFFFF;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 14px;
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(110, 81, 20, 0.3);
        }
        .ws-refer-graphic {
            font-size: 2.2rem;
        }

        /* Support / WhatsApp Card */
        .ws-support-card {
            background: #FFFFFF;
            border-radius: var(--ws-radius-lg);
            border: 1px solid var(--ws-border);
            padding: 16px;
            box-shadow: var(--ws-shadow-sm);
            text-align: center;
        }
        .ws-support-card h3 {
            font-size: 0.9rem;
            font-weight: 800;
            color: var(--ws-text-main);
            margin-bottom: 4px;
        }
        .ws-support-card p {
            font-size: 0.72rem;
            color: var(--ws-text-muted);
            margin-bottom: 12px;
            line-height: 1.3;
        }
        .ws-whatsapp-btn {
            width: 100%;
            background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
            color: #FFFFFF;
            font-size: 0.82rem;
            font-weight: 800;
            padding: 10px 16px;
            border-radius: var(--ws-radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.28);
            transition: transform 0.2s ease;
        }
        .ws-whatsapp-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(37, 211, 102, 0.35);
        }
        .ws-phone-link {
            display: inline-block;
            margin-top: 10px;
            font-size: 0.76rem;
            font-weight: 700;
            color: var(--ws-gold-dark);
            text-decoration: none;
        }

        /* Sidebar Footer Seal */
        .ws-sidebar-footer {
            background: var(--ws-dark);
            border-radius: var(--ws-radius-md);
            padding: 14px;
            text-align: center;
            color: #FFFFFF;
        }
        .ws-sidebar-footer svg {
            width: 24px;
            height: 24px;
            color: var(--ws-gold-light);
            margin-bottom: 4px;
        }
        .ws-sidebar-footer h4 {
            font-family: var(--ws-font-serif);
            font-size: 0.74rem;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: 0.08em;
        }
        .ws-sidebar-footer p {
            font-size: 0.62rem;
            color: rgba(255,255,255,0.65);
            margin-top: 2px;
            line-height: 1.3;
        }

        /* ── Mobile Drawer Slider for Sidebar ── */
        .ws-drawer-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(4px);
            z-index: 999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .ws-drawer-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }
        .ws-mobile-drawer {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 86%;
            max-width: 340px;
            background: var(--ws-page-bg);
            z-index: 1000;
            overflow-y: auto;
            transform: translateX(-100%);
            transition: transform 0.3s cubic-bezier(0.25, 1, 0.5, 1);
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            box-shadow: 4px 0 24px rgba(0,0,0,0.3);
        }
        .ws-mobile-drawer.open {
            transform: translateX(0);
        }
        .ws-drawer-close-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(0,0,0,0.1);
            border: none;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ws-text-main);
            cursor: pointer;
            z-index: 10;
        }

        /* ── Mobile Fixed Bottom Navigation Bar ── */
        .ws-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: #FFFFFF;
            border-top: 1.5px solid var(--ws-border);
            z-index: 90;
            box-shadow: 0 -4px 16px rgba(0,0,0,0.06);
            padding-bottom: env(safe-area-inset-bottom);
        }
        @media (max-width: 1024px) {
            .ws-bottom-nav {
                display: flex;
                align-items: center;
                justify-content: space-around;
            }
            .ws-sidebar-panel {
                display: none;
            }
        }
        .ws-bnav-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            text-decoration: none;
            color: var(--ws-text-muted);
            font-size: 0.65rem;
            font-weight: 700;
            padding: 6px 0;
            transition: color 0.15s ease;
        }
        .ws-bnav-item svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }
        .ws-bnav-item.active {
            color: var(--ws-gold-dark);
        }
        .ws-bnav-item.active svg {
            stroke: var(--ws-gold-dark);
            stroke-width: 2.4;
        }

        /* ── Master B2B Product Catalog Grid ── */
        .ws-catalog-section {
            background: #FFFFFF;
            border-radius: var(--ws-radius-lg);
            border: 1px solid var(--ws-border);
            padding: 16px;
            box-shadow: var(--ws-shadow-sm);
        }
        .ws-catalog-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-top: 14px;
        }
        @media (max-width: 767px) {
            .ws-catalog-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }
        }
        .ws-product-card {
            border: 1px solid var(--ws-border);
            border-radius: var(--ws-radius-md);
            overflow: hidden;
            background: #FFFFFF;
            display: flex;
            flex-direction: column;
            transition: all 0.2s ease;
        }
        .ws-product-card:hover {
            transform: translateY(-2px);
            border-color: var(--ws-gold);
            box-shadow: var(--ws-shadow-md);
        }
        .ws-prod-img-box {
            position: relative;
            width: 100%;
            aspect-ratio: 3/4;
            background: var(--ws-gold-pale);
            overflow: hidden;
        }
        .ws-prod-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .ws-product-card:hover .ws-prod-img-box img {
            transform: scale(1.05);
        }
        .ws-prod-badge {
            position: absolute;
            top: 8px; left: 8px;
            background: rgba(138, 104, 31, 0.9);
            backdrop-filter: blur(4px);
            color: #FFFFFF;
            font-size: 0.58rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 2px 7px;
            border-radius: 10px;
        }
        .ws-prod-body {
            padding: 10px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
        }
        .ws-prod-name {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--ws-text-main);
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .ws-prod-pricing {
            display: flex;
            align-items: baseline;
            gap: 6px;
            margin-top: 2px;
        }
        .ws-price-ws {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--ws-gold-dark);
        }
        .ws-price-mrp {
            font-size: 0.7rem;
            color: var(--ws-text-muted);
            text-decoration: line-through;
        }
        .ws-moq-tag {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--ws-purple);
            background: var(--ws-purple-bg);
            padding: 2px 6px;
            border-radius: 6px;
            display: inline-block;
            width: fit-content;
        }
        .ws-add-cart-btn {
            margin-top: 8px;
            width: 100%;
            background: var(--ws-gold);
            color: #FFFFFF;
            border: none;
            border-radius: 8px;
            font-size: 0.74rem;
            font-weight: 700;
            padding: 7px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            transition: all 0.2s ease;
        }
        .ws-add-cart-btn:hover {
            background: var(--ws-gold-dark);
        }

        /* Toast Popup */
        .ws-toast {
            position: fixed;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%) translateY(30px);
            background: var(--ws-dark);
            color: #FFFFFF;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 10px 20px;
            border-radius: 20px;
            border: 1px solid var(--ws-gold);
            box-shadow: 0 4px 18px rgba(0,0,0,0.3);
            z-index: 9999;
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
        }
        .ws-toast.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }
    </style>
</head>
<body>

<!-- ════════════ TOP HEADER BAR ════════════ -->
<header class="ws-header">
    <div class="ws-header-left">
        <!-- Hamburger Menu Toggle Button -->
        <button type="button" class="ws-header-btn" id="wsMenuToggleBtn" aria-label="Open Navigation Menu" onclick="toggleWholesaleDrawer(true)">
            <svg viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>

        <!-- Brand Logo -->
        <a href="wholesaler.php" class="ws-brand-title">
            <div class="ws-brand-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <div class="ws-brand-text">
                <h1>DT ARNIYA</h1>
                <span>WHOLESALE HUB</span>
            </div>
        </a>
    </div>

    <div class="ws-header-right">
        <!-- Notification Bell with Count -->
        <button type="button" class="ws-icon-badge-btn" aria-label="Notifications" onclick="showWholesaleToast('🔔 3 New Wholesale Offers Active!')">
            <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
            <span class="ws-count-badge">3</span>
        </button>

        <!-- Shopping Cart / B2B Bag -->
        <button type="button" class="ws-icon-badge-btn" aria-label="Wholesale Bag" onclick="if(typeof window.openCartDrawer==='function') window.openCartDrawer(); else window.location.href='cart.php';">
            <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
            <span class="ws-count-badge gold">5</span>
        </button>
    </div>
</header>

<!-- ════════════ MAIN APP CONTAINER ════════════ -->
<div class="ws-app-container">

    <!-- ── LEFT CONTENT FEED ── -->
    <main class="ws-main-feed">

        <!-- 1. Welcome VIP User Banner Card -->
        <div class="ws-vip-banner-card">
            <div class="ws-vip-meta">
                <span class="ws-vip-greeting">Welcome,</span>
                <div class="ws-vip-name-row">
                    <span class="ws-vip-name">Wholesale User</span>
                    <span class="ws-verified-pill gold">✓ Verified</span>
                </div>
                <span class="ws-vip-sub">DT Arniya Wholesale Hub • B2B Dashboard</span>
            </div>

            <div class="ws-vip-seal-box">
                <svg viewBox="0 0 24 24"><path fill="currentColor" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                <div class="ws-vip-seal-text">DT</div>
                <div class="ws-vip-seal-sub">ARNIYA</div>
            </div>
        </div>

        <!-- 2. 4 Metric Stat Cards -->
        <div class="ws-metrics-grid">
            <!-- Metric 1: Total Orders -->
            <div class="ws-metric-card">
                <div class="ws-metric-icon purple">🛍️</div>
                <div class="ws-metric-value">₹ 2,48,500</div>
                <div class="ws-metric-label">Total Orders</div>
                <div class="ws-metric-footer">128</div>
            </div>

            <!-- Metric 2: Total Purchases -->
            <div class="ws-metric-card">
                <div class="ws-metric-icon blue">📦</div>
                <div class="ws-metric-value">₹ 1,75,300</div>
                <div class="ws-metric-label">Total Purchases</div>
                <div class="ws-metric-footer">96</div>
            </div>

            <!-- Metric 3: Total Savings -->
            <div class="ws-metric-card">
                <div class="ws-metric-icon green">📊</div>
                <div class="ws-metric-value">₹ 73,200</div>
                <div class="ws-metric-label">Total Savings</div>
                <div class="ws-metric-footer" style="color: var(--ws-green);">This Month</div>
            </div>

            <!-- Metric 4: Wallet Balance -->
            <div class="ws-metric-card">
                <div class="ws-metric-icon orange">👛</div>
                <div class="ws-metric-value">₹ 56,800</div>
                <div class="ws-metric-label">Wallet Balance</div>
                <div class="ws-metric-footer"><a href="#wallet" onclick="showWholesaleToast('💰 Wallet Balance: ₹56,800 Available')">View ›</a></div>
            </div>
        </div>

        <!-- 3. Quick Actions Grid (8 Action Tiles) -->
        <div>
            <div class="ws-section-title">Quick Actions</div>
            <div class="ws-quick-actions-grid" style="margin-top: 10px;">
                <a href="#catalog" class="ws-action-tile">
                    <div class="ws-action-icon c1">🛒</div>
                    <div class="ws-action-label">New Order</div>
                </a>
                <a href="#categories" class="ws-action-tile" onclick="showWholesaleToast('Viewing 6 Wholesale Categories')">
                    <div class="ws-action-icon c2">🔲</div>
                    <div class="ws-action-label">Categories</div>
                </a>
                <a href="#catalog" class="ws-action-tile">
                    <div class="ws-action-icon c3">🛍️</div>
                    <div class="ws-action-label">Products</div>
                </a>
                <a href="#orders" class="ws-action-tile">
                    <div class="ws-action-icon c4">📄</div>
                    <div class="ws-action-label">My Orders</div>
                </a>
                <a href="#wallet" class="ws-action-tile" onclick="showWholesaleToast('💳 B2B Credit Limit: ₹2,00,000')">
                    <div class="ws-action-icon c5">👛</div>
                    <div class="ws-action-label">Wallet</div>
                </a>
                <a href="#invoices" class="ws-action-tile" onclick="showWholesaleToast('📄 12 GST Tax Invoices Ready for Download')">
                    <div class="ws-action-icon c6">🧾</div>
                    <div class="ws-action-label">Invoices</div>
                </a>
                <a href="#stock" class="ws-action-tile" onclick="showWholesaleToast('📦 720+ Units in Fresh Stock')">
                    <div class="ws-action-icon c7">📦</div>
                    <div class="ws-action-label">Stock Update</div>
                </a>
                <a href="#payment" class="ws-action-tile" onclick="showWholesaleToast('💳 Direct UPI / NetBanking / RTGS Active')">
                    <div class="ws-action-icon c8">💳</div>
                    <div class="ws-action-label">Payment</div>
                </a>
            </div>
        </div>

        <!-- 4. Big Sale Promo Banner Carousel -->
        <div class="ws-promo-carousel gold-theme">
            <div class="ws-promo-content">
                <div class="ws-promo-text">
                    <h2>Big Sale Offer!</h2>
                    <p>Get extra 5% OFF on wholesale orders above ₹10,000</p>
                    <a href="#catalog" class="ws-promo-btn">Shop Now ›</a>
                </div>
                <div class="ws-promo-graphic">
                    <div class="ws-promo-gift-bag">
                        <span>🎁</span>
                        <b>DT ARNIYA</b>
                    </div>
                </div>
            </div>
            <div class="ws-promo-dots">
                <div class="ws-pdot active"></div>
                <div class="ws-pdot"></div>
                <div class="ws-pdot"></div>
            </div>
        </div>

        <!-- 5. Recent Orders Section -->
        <div class="ws-card-container" id="orders">
            <div class="ws-card-header">
                <div class="ws-card-title">Recent Orders</div>
                <a href="#all-orders" class="ws-card-link" onclick="showWholesaleToast('Viewing full wholesale orders ledger')">View All</a>
            </div>

            <div class="ws-orders-list">
                <!-- Order 1 -->
                <div class="ws-order-row">
                    <div class="ws-order-left">
                        <div class="ws-thumb-collage">
                            <img src="images/product1.png" alt="Thumb" class="ws-thumb-img" onError="this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=100&q=80'">
                            <img src="images/product2.png" alt="Thumb" class="ws-thumb-img" onError="this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=100&q=80'">
                            <img src="images/product3.png" alt="Thumb" class="ws-thumb-img" onError="this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=100&q=80'">
                        </div>
                        <div class="ws-order-info">
                            <div class="ws-order-id">#ORD12345</div>
                            <div class="ws-order-price">₹ 24,560</div>
                            <div class="ws-order-sub">32 Items • via DT Express</div>
                        </div>
                    </div>
                    <div class="ws-order-right">
                        <div class="ws-order-date">16 Aug 2026</div>
                        <span class="ws-status-badge delivered">Delivered</span>
                    </div>
                </div>

                <!-- Order 2 -->
                <div class="ws-order-row">
                    <div class="ws-order-left">
                        <div class="ws-thumb-collage">
                            <img src="images/product4.png" alt="Thumb" class="ws-thumb-img" onError="this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=100&q=80'">
                            <img src="images/product5.png" alt="Thumb" class="ws-thumb-img" onError="this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=100&q=80'">
                            <img src="images/product6.png" alt="Thumb" class="ws-thumb-img" onError="this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=100&q=80'">
                        </div>
                        <div class="ws-order-info">
                            <div class="ws-order-id">#ORD12344</div>
                            <div class="ws-order-price">₹ 18,750</div>
                            <div class="ws-order-sub">21 Items • via DT Express</div>
                        </div>
                    </div>
                    <div class="ws-order-right">
                        <div class="ws-order-date">15 Aug 2026</div>
                        <span class="ws-status-badge processing">Processing</span>
                    </div>
                </div>

                <!-- Order 3 -->
                <div class="ws-order-row">
                    <div class="ws-order-left">
                        <div class="ws-thumb-collage">
                            <img src="images/product1.png" alt="Thumb" class="ws-thumb-img" onError="this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=100&q=80'">
                            <img src="images/product3.png" alt="Thumb" class="ws-thumb-img" onError="this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=100&q=80'">
                            <img src="images/product5.png" alt="Thumb" class="ws-thumb-img" onError="this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=100&q=80'">
                        </div>
                        <div class="ws-order-info">
                            <div class="ws-order-id">#ORD12343</div>
                            <div class="ws-order-price">₹ 12,300</div>
                            <div class="ws-order-sub">18 Items • via DT Express</div>
                        </div>
                    </div>
                    <div class="ws-order-right">
                        <div class="ws-order-date">14 Aug 2026</div>
                        <span class="ws-status-badge shipped">Shipped</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 6. Master B2B Product Catalog Grid -->
        <div class="ws-catalog-section" id="catalog">
            <div class="ws-card-header">
                <div>
                    <div class="ws-card-title">B2B Master Catalog</div>
                    <span style="font-size: 0.72rem; color: var(--ws-text-muted);">Direct Factory Pricing • Ready to Dispatch</span>
                </div>
                <a href="shop.php" class="ws-card-link">View Retail Shop ›</a>
            </div>

            <div class="ws-catalog-grid">
                <?php foreach ($catalogProducts as $prod): ?>
                <div class="ws-product-card">
                    <div class="ws-prod-img-box">
                        <span class="ws-prod-badge"><?= htmlspecialchars($prod['badge']) ?></span>
                        <img src="<?= htmlspecialchars($prod['image']) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" onError="this.src='https://images.unsplash.com/photo-1610030469983-98e550d6193c?auto=format&fit=crop&w=400&q=80'">
                    </div>
                    <div class="ws-prod-body">
                        <div class="ws-prod-name"><?= htmlspecialchars($prod['name']) ?></div>
                        <div class="ws-prod-pricing">
                            <span class="ws-price-ws">₹<?= number_format($prod['wholesale_price']) ?></span>
                            <span class="ws-price-mrp">₹<?= number_format($prod['retail_price']) ?></span>
                        </div>
                        <span class="ws-moq-tag">MOQ: <?= $prod['moq'] ?> pcs</span>
                        <button type="button" class="ws-add-cart-btn" onclick="addWholesaleBulkToCart(<?= $prod['id'] ?>, '<?= addslashes($prod['name']) ?>', <?= $prod['wholesale_price'] ?>, <?= $prod['moq'] ?>)">
                            <span>🛒 Bulk Add</span>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </main>

    <!-- ── RIGHT SIDEBAR / NAVIGATION PANEL (Desktop View) ── -->
    <aside class="ws-sidebar-panel">

        <!-- User Profile & Price Tier Card -->
        <div class="ws-profile-card gold-theme">
            <div class="ws-profile-header">
                <div class="ws-profile-avatar">DT</div>
                <div class="ws-profile-details">
                    <div class="ws-profile-name">Wholesale User</div>
                    <div class="ws-profile-email">wholesale@dtarniya.com</div>
                    <span class="ws-verified-tag">Verified Wholesale</span>
                </div>
            </div>

            <!-- Price Tier Box -->
            <div class="ws-tier-box" onclick="showWholesaleToast('⭐ Gold Partner Tier: Maximum 45% Margin Unlocked!')">
                <div>
                    <div class="ws-tier-title">Wholesale Price Tier</div>
                    <div class="ws-tier-name">⭐ Gold Partner</div>
                    <div class="ws-tier-validity">Valid Till : 31 Dec 2026</div>
                </div>
                <div class="ws-tier-arrow">›</div>
            </div>
        </div>

        <!-- Navigation Menu List -->
        <nav class="ws-nav-menu-card">
            <a href="wholesaler.php" class="ws-nav-item active">
                <div class="ws-nav-left"><span class="ws-nav-icon">🏠</span><span>Dashboard</span></div>
                <span class="ws-nav-arrow">›</span>
            </a>
            <a href="myaccount.php" class="ws-nav-item">
                <div class="ws-nav-left"><span class="ws-nav-icon">👤</span><span>My Profile</span></div>
                <span class="ws-nav-arrow">›</span>
            </a>
            <a href="#kyc" class="ws-nav-item" onclick="showWholesaleToast('🛡️ GSTIN & Trade License Verified')">
                <div class="ws-nav-left"><span class="ws-nav-icon">🛡️</span><span>KYC & Documents</span></div>
                <span class="ws-nav-arrow">›</span>
            </a>
            <a href="#wallet" class="ws-nav-item" onclick="showWholesaleToast('👛 Wallet Balance: ₹56,800')">
                <div class="ws-nav-left"><span class="ws-nav-icon">👛</span><span>My Wallet</span></div>
                <span class="ws-nav-arrow">›</span>
            </a>
            <a href="#orders" class="ws-nav-item">
                <div class="ws-nav-left"><span class="ws-nav-icon">📄</span><span>My Orders</span></div>
                <span class="ws-nav-arrow">›</span>
            </a>
            <a href="#refund" class="ws-nav-item" onclick="showWholesaleToast('🔄 0 Active Return Requests')">
                <div class="ws-nav-left"><span class="ws-nav-icon">🔄</span><span>Return / Refund</span></div>
                <span class="ws-nav-arrow">›</span>
            </a>
            <a href="#invoices" class="ws-nav-item" onclick="showWholesaleToast('🧾 GST Invoices Ready for Download')">
                <div class="ws-nav-left"><span class="ws-nav-icon">🧾</span><span>My Invoices</span></div>
                <span class="ws-nav-arrow">›</span>
            </a>
            <a href="#catalog" class="ws-nav-item">
                <div class="ws-nav-left"><span class="ws-nav-icon">📦</span><span>Products</span></div>
                <span class="ws-nav-arrow">›</span>
            </a>
            <a href="#catalog" class="ws-nav-item">
                <div class="ws-nav-left"><span class="ws-nav-icon">🔲</span><span>Categories</span></div>
                <span class="ws-nav-arrow">›</span>
            </a>
            <a href="#stock" class="ws-nav-item" onclick="showWholesaleToast('🏭 Direct Factory Stock: 720 Units')">
                <div class="ws-nav-left"><span class="ws-nav-icon">🏭</span><span>Stock Update</span></div>
                <span class="ws-nav-arrow">›</span>
            </a>
            <a href="#offers" class="ws-nav-item" onclick="showWholesaleToast('🏷️ Festival Bulk Discount: Extra 5% Off')">
                <div class="ws-nav-left"><span class="ws-nav-icon">🏷️</span><span>Pricing & Offers</span></div>
                <span class="ws-nav-arrow">›</span>
            </a>
            <a href="#notifications" class="ws-nav-item" onclick="showWholesaleToast('🔔 3 Unread Notifications')">
                <div class="ws-nav-left"><span class="ws-nav-icon">🔔</span><span>Notifications</span></div>
                <span class="ws-nav-badge">3</span>
                <span class="ws-nav-arrow">›</span>
            </a>
            <a href="#support" class="ws-nav-item" onclick="showWholesaleToast('💬 24x7 Wholesaler Support Desk Ready')">
                <div class="ws-nav-left"><span class="ws-nav-icon">💬</span><span>Support Tickets</span></div>
                <span class="ws-nav-arrow">›</span>
            </a>
            <a href="myaccount.php" class="ws-nav-item">
                <div class="ws-nav-left"><span class="ws-nav-icon">⚙️</span><span>Settings</span></div>
                <span class="ws-nav-arrow">›</span>
            </a>
            <a href="shop.php" class="ws-nav-item" style="color: var(--ws-red);">
                <div class="ws-nav-left"><span class="ws-nav-icon">🚪</span><span>Logout</span></div>
                <span class="ws-nav-arrow">›</span>
            </a>
        </nav>

        <!-- Refer & Earn Card -->
        <div class="ws-refer-card gold-theme">
            <div class="ws-refer-info">
                <h3>Refer & Earn</h3>
                <p>Refer another wholesaler and earn up to ₹500</p>
                <a href="#refer" class="ws-refer-btn" onclick="showWholesaleToast('🎉 Referral Code: ARNIYA500 Copied!')">Refer Now</a>
            </div>
            <div class="ws-refer-graphic">🤝</div>
        </div>

        <!-- Need Help? / WhatsApp Card -->
        <div class="ws-support-card">
            <h3>Need Help?</h3>
            <p>Our support team is here to help you<br>10:00 AM - 08:00 PM (Mon - Sat)</p>
            <a href="https://wa.me/917878454545?text=Hello%20DT%20Arniya%20Wholesale%20Team%2C%20I%20need%20assistance" target="_blank" class="ws-whatsapp-btn">
                <span>💬 Chat on WhatsApp</span>
            </a>
            <a href="tel:+917878454545" class="ws-phone-link">📞 +91 78784 54545</a>
        </div>

        <!-- Footer Brand Seal -->
        <div class="ws-sidebar-footer">
            <svg viewBox="0 0 24 24"><path fill="currentColor" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            <h4>DT ARNIYA WHOLESALE HUB</h4>
            <p>Premium Quality | Best Prices | Trusted by Wholesalers</p>
            <p style="margin-top: 4px; font-size: 0.58rem; color: rgba(255,255,255,0.45);">© 2026 DT Arniya. All Rights Reserved.</p>
        </div>

    </aside>

</div>

<!-- ════════════ MOBILE SLIDE-OUT DRAWER ════════════ -->
<div class="ws-drawer-overlay" id="wsDrawerOverlay" onclick="toggleWholesaleDrawer(false)"></div>
<div class="ws-mobile-drawer" id="wsMobileDrawer">
    <button type="button" class="ws-drawer-close-btn" onclick="toggleWholesaleDrawer(false)" aria-label="Close Menu">✕</button>

    <!-- User Profile Header in Drawer -->
    <div class="ws-profile-card gold-theme" style="margin-top: 24px;">
        <div class="ws-profile-header">
            <div class="ws-profile-avatar">DT</div>
            <div class="ws-profile-details">
                <div class="ws-profile-name">Wholesale User</div>
                <div class="ws-profile-email">wholesale@dtarniya.com</div>
                <span class="ws-verified-tag">Verified Wholesale</span>
            </div>
        </div>

        <div class="ws-tier-box" onclick="showWholesaleToast('⭐ Gold Partner Tier: Maximum 45% Margin Unlocked!')">
            <div>
                <div class="ws-tier-title">Wholesale Price Tier</div>
                <div class="ws-tier-name">⭐ Gold Partner</div>
                <div class="ws-tier-validity">Valid Till : 31 Dec 2026</div>
            </div>
            <div class="ws-tier-arrow">›</div>
        </div>
    </div>

    <!-- Nav list in Drawer -->
    <nav class="ws-nav-menu-card">
        <a href="wholesaler.php" class="ws-nav-item active" onclick="toggleWholesaleDrawer(false)">
            <div class="ws-nav-left"><span class="ws-nav-icon">🏠</span><span>Dashboard</span></div>
            <span class="ws-nav-arrow">›</span>
        </a>
        <a href="myaccount.php" class="ws-nav-item">
            <div class="ws-nav-left"><span class="ws-nav-icon">👤</span><span>My Profile</span></div>
            <span class="ws-nav-arrow">›</span>
        </a>
        <a href="#orders" class="ws-nav-item" onclick="toggleWholesaleDrawer(false)">
            <div class="ws-nav-left"><span class="ws-nav-icon">📄</span><span>My Orders</span></div>
            <span class="ws-nav-arrow">›</span>
        </a>
        <a href="#wallet" class="ws-nav-item" onclick="toggleWholesaleDrawer(false); showWholesaleToast('👛 Wallet Balance: ₹56,800');">
            <div class="ws-nav-left"><span class="ws-nav-icon">👛</span><span>My Wallet</span></div>
            <span class="ws-nav-arrow">›</span>
        </a>
        <a href="#invoices" class="ws-nav-item" onclick="toggleWholesaleDrawer(false); showWholesaleToast('🧾 GST Invoices Ready');">
            <div class="ws-nav-left"><span class="ws-nav-icon">🧾</span><span>My Invoices</span></div>
            <span class="ws-nav-arrow">›</span>
        </a>
        <a href="#catalog" class="ws-nav-item" onclick="toggleWholesaleDrawer(false)">
            <div class="ws-nav-left"><span class="ws-nav-icon">📦</span><span>Products</span></div>
            <span class="ws-nav-arrow">›</span>
        </a>
        <a href="#support" class="ws-nav-item" onclick="toggleWholesaleDrawer(false); showWholesaleToast('💬 Support Desk Active');">
            <div class="ws-nav-left"><span class="ws-nav-icon">💬</span><span>Support Tickets</span></div>
            <span class="ws-nav-arrow">›</span>
        </a>
        <a href="shop.php" class="ws-nav-item" style="color: var(--ws-red);">
            <div class="ws-nav-left"><span class="ws-nav-icon">🚪</span><span>Logout</span></div>
            <span class="ws-nav-arrow">›</span>
        </a>
    </nav>

    <!-- Support Card in Drawer -->
    <div class="ws-support-card">
        <h3>Need Help?</h3>
        <p>Our support team is here to help you (10 AM - 8 PM)</p>
        <a href="https://wa.me/917878454545?text=Hello%20DT%20Arniya%20Wholesale%20Team" target="_blank" class="ws-whatsapp-btn">
            <span>💬 Chat on WhatsApp</span>
        </a>
    </div>
</div>

<!-- ════════════ MOBILE FIXED BOTTOM NAVIGATION BAR ════════════ -->
<nav class="ws-bottom-nav">
    <a href="wholesaler.php" class="ws-bnav-item active">
        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
        <span>Dashboard</span>
    </a>
    <a href="#categories" class="ws-bnav-item" onclick="document.getElementById('catalog').scrollIntoView({behavior:'smooth'});">
        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
        <span>Categories</span>
    </a>
    <a href="#orders" class="ws-bnav-item" onclick="document.getElementById('orders').scrollIntoView({behavior:'smooth'});">
        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        <span>Orders</span>
    </a>
    <a href="#catalog" class="ws-bnav-item" onclick="document.getElementById('catalog').scrollIntoView({behavior:'smooth'});">
        <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
        <span>Products</span>
    </a>
    <button type="button" class="ws-bnav-item" style="background:none; border:none; cursor:pointer;" onclick="toggleWholesaleDrawer(true)">
        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
        <span>Account</span>
    </button>
</nav>

<!-- ════════════ TOAST NOTIFICATION ════════════ -->
<div class="ws-toast" id="wsToast"></div>

<!-- ════════════ SCRIPTS ════════════ -->
<script>
(function() {
    'use strict';

    // Toast helper
    var toastTimer = null;
    window.showWholesaleToast = function(msg) {
        var t = document.getElementById('wsToast');
        if (!t) return;
        t.textContent = msg;
        t.classList.add('show');
        if (toastTimer) clearTimeout(toastTimer);
        toastTimer = setTimeout(function() {
            t.classList.remove('show');
        }, 2600);
    };

    // Mobile Drawer Toggle
    window.toggleWholesaleDrawer = function(open) {
        var d = document.getElementById('wsMobileDrawer');
        var o = document.getElementById('wsDrawerOverlay');
        if (d && o) {
            if (open) {
                d.classList.add('open');
                o.classList.add('open');
                document.body.style.overflow = 'hidden';
            } else {
                d.classList.remove('open');
                o.classList.remove('open');
                document.body.style.overflow = '';
            }
        }
    };

    // Add Bulk to Cart Helper
    window.addWholesaleBulkToCart = function(id, name, price, moq) {
        try {
            var cart = JSON.parse(localStorage.getItem('kalaniketan_cart') || '[]');
            var existing = cart.find(function(item) { return item.id === id; });
            if (existing) {
                existing.qty = (existing.qty || 0) + moq;
            } else {
                cart.push({
                    id: id,
                    name: name,
                    price: price,
                    qty: moq,
                    isWholesale: true,
                    moq: moq
                });
            }
            localStorage.setItem('kalaniketan_cart', JSON.stringify(cart));
            window.showWholesaleToast('🛍️ Added ' + moq + ' pcs of ' + name + ' to Wholesale Bag!');
        } catch (e) {
            window.showWholesaleToast('🛍️ Added MOQ ' + moq + ' pcs to Bag');
        }
    };

})();
</script>

</body>
</html>
