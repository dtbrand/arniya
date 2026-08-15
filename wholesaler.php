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
    <title>Wholesaler B2B Dashboard — Kalaniketan Couture</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
            padding: 16px 18px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid var(--ws-border-light);
            flex-shrink: 0;
        }
        .ws-sidebar-close-btn {
            display: none;
            margin-left: auto;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1.2px solid var(--ws-gold-border);
            background: var(--ws-gold-light);
            color: var(--ws-gold-primary);
            font-size: 1.1rem;
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
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--ws-gold-accent) 0%, var(--ws-gold-primary) 50%, var(--ws-gold-deep) 100%);
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 1rem;
            box-shadow: 0 2px 8px rgba(138,104,31,0.3);
            border: 1.2px solid #FFFFFF;
        }
        .ws-side-brand-title {
            font-family: var(--ws-font-serif);
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
            letter-spacing: 0.06em;
        }

        .ws-nav-category {
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--ws-text-muted);
            padding: 14px 20px 6px;
        }
        .ws-nav-list {
            list-style: none;
            padding: 6px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
        }
        .ws-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 9px 14px;
            border-radius: 10px;
            color: var(--ws-text-sub);
            font-size: 0.84rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: var(--ws-transition);
            border: 1px solid transparent;
            user-select: none;
        }
        .ws-nav-item:hover {
            background: var(--ws-gold-light);
            color: var(--ws-gold-primary);
        }
        .ws-nav-item.active {
            background: var(--ws-gold-light);
            color: var(--ws-gold-primary);
            border-color: var(--ws-gold-border);
            font-weight: 800;
            box-shadow: 0 2px 6px rgba(138,104,31,0.08);
        }
        .ws-nav-item svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
            flex-shrink: 0;
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
           TAILADMIN TOP STAT METRIC CARDS (4 Cards Grid)
        ════════════════════════════════════════════════════ */
        .ws-metric-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(clamp(200px, 22vw, 260px), 1fr));
            gap: clamp(12px, 1.8vw, 20px);
            margin-bottom: clamp(16px, 2vw, 24px);
        }
        .ws-stat-box {
            background: var(--ws-bg-card);
            border: 1.5px solid var(--ws-border);
            border-radius: var(--ws-radius-lg);
            padding: clamp(16px, 2vw, 22px);
            box-shadow: var(--ws-shadow-card);
            transition: var(--ws-transition);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .ws-stat-box:hover {
            box-shadow: var(--ws-shadow-hover);
            border-color: var(--ws-gold-primary);
            transform: translateY(-2px);
        }
        .ws-stat-label {
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--ws-text-muted);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .ws-stat-val-row {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 10px;
        }
        .ws-stat-val-num {
            font-size: clamp(1.45rem, 2.5vw, 1.75rem);
            font-weight: 800;
            color: var(--ws-text-main);
            letter-spacing: -0.02em;
            line-height: 1.1;
        }
        .ws-trend-pill {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 700;
        }
        .ws-trend-pill.up {
            background: var(--ws-success-bg);
            color: var(--ws-success);
        }
        .ws-trend-pill.down {
            background: var(--ws-danger-bg);
            color: var(--ws-danger);
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

        /* ── Bar Chart Canvas & Grid (Gold Bars) ── */
        .ws-bar-chart-container {
            position: relative;
            height: 200px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            padding: 10px 0 24px 34px;
            border-bottom: 1px solid var(--ws-border);
        }
        .ws-chart-y-axis {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            font-size: 0.68rem;
            font-weight: 600;
            color: var(--ws-text-muted);
        }
        .ws-bar-col {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            flex: 1;
            position: relative;
            cursor: pointer;
        }
        .ws-bar-pill {
            width: 14px;
            background: linear-gradient(180deg, var(--ws-gold-accent) 0%, var(--ws-gold-primary) 100%);
            border-radius: 6px 6px 0 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        .ws-bar-col:hover .ws-bar-pill {
            background: linear-gradient(180deg, #EBDCB2 0%, var(--ws-gold-primary) 100%);
            transform: scaleY(1.05);
            box-shadow: 0 4px 12px rgba(138,104,31,0.35);
        }
        .ws-bar-col.active .ws-bar-pill {
            background: linear-gradient(180deg, #D4AF37 0%, var(--ws-gold-deep) 100%);
            box-shadow: 0 0 10px rgba(212,175,55,0.45);
        }
        .ws-bar-month {
            position: absolute;
            bottom: -20px;
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--ws-text-muted);
        }

        /* ── Semi-Circular Target Gauge Arc (Heritage Gold) ── */
        .ws-gauge-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin: 10px 0 16px;
        }
        .ws-gauge-svg {
            width: 190px;
            height: 105px;
            overflow: visible;
        }
        .ws-gauge-bg-arc {
            fill: none;
            stroke: #EAE5DB;
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
            transition: stroke-dashoffset 1s ease;
        }
        .ws-gauge-center-text {
            font-size: 1.55rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
            margin-top: -30px;
            font-family: var(--ws-font-serif);
        }
        .ws-gauge-badge {
            display: inline-flex;
            align-items: center;
            gap: 3px;
            padding: 2px 8px;
            border-radius: 12px;
            background: #ECFDF5;
            color: #10B981;
            font-size: 0.70rem;
            font-weight: 700;
            margin-top: 4px;
        }
        .ws-gauge-desc {
            font-size: 0.78rem;
            color: var(--ws-text-muted);
            margin-top: 14px;
            line-height: 1.45;
            max-width: 280px;
        }
        .ws-gauge-stats-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            border-top: 1px solid var(--ws-border);
            padding-top: 14px;
            margin-top: auto;
            text-align: center;
            gap: 6px;
        }
        .ws-g-stat-label {
            font-size: 0.70rem;
            color: var(--ws-text-muted);
            font-weight: 600;
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
        .ws-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
        }
        .ws-sec-title-box h3 {
            font-size: 1.1rem;
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
        .ws-status-badge.delivered { background: #DCFCE7; color: #15803D; }
        .ws-status-badge.processing { background: #FEF3C7; color: #B45309; }
        .ws-status-badge.shipped { background: #DBEAFE; color: #1D4ED8; }
        .ws-status-badge.confirmed { background: #F3E8FF; color: #6B21A8; }
        .ws-status-badge.returned { background: #FEE2E2; color: #B91C1C; }
        .ws-status-badge.refund { background: #FFE4E6; color: #9F1239; }

        /* ── Mobile Order Cards ── */
        .ws-mobile-order-cards {
            display: none;
            flex-direction: column;
            gap: 12px;
        }
        .ws-mob-order-card {
            background: #FFFFFF;
            border: 1.5px solid var(--ws-border);
            border-radius: var(--ws-radius-md);
            padding: 14px;
            box-shadow: var(--ws-shadow-card);
        }
        .ws-mob-order-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px dashed var(--ws-border);
        }
        .ws-mob-order-body {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
        }
        .ws-mob-order-img {
            width: 56px;
            height: 70px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid var(--ws-border);
            flex-shrink: 0;
        }
        .ws-mob-order-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .ws-mob-order-title {
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--ws-text-main);
            line-height: 1.25;
        }
        .ws-mob-order-meta {
            font-size: 0.75rem;
            color: var(--ws-text-muted);
            font-weight: 500;
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

        .ws-product-card {
            flex: 0 0 calc((100% - 48px) / 5); /* 5 visible on desktop */
            min-width: 170px;
            background: #FFFFFF;
            border: 1.5px solid var(--ws-border);
            border-radius: var(--ws-radius-md);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: var(--ws-transition);
            box-shadow: var(--ws-shadow-card);
            scroll-snap-align: start;
        }
        .ws-product-card:hover {
            border-color: var(--ws-gold-primary);
            transform: translateY(-3px);
            box-shadow: var(--ws-shadow-hover);
        }
        .ws-prod-img-wrap {
            position: relative;
            width: 100%;
            height: 180px;
            background: #FAF8F4;
            overflow: hidden;
        }
        .ws-prod-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            transition: transform 0.3s ease;
        }
        .ws-product-card:hover .ws-prod-img { transform: scale(1.05); }
        .ws-prod-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: var(--ws-gold-primary);
            color: #FFFFFF;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 4px;
            letter-spacing: 0.04em;
        }
        .ws-prod-moq {
            position: absolute;
            bottom: 6px;
            right: 6px;
            background: rgba(20, 17, 14, 0.88);
            color: #FBBF24;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
        }
        .ws-prod-body {
            padding: 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
        }
        .ws-prod-cat {
            font-size: 0.68rem;
            font-weight: 600;
            color: var(--ws-text-muted);
            text-transform: uppercase;
        }
        .ws-prod-name {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--ws-text-main);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .ws-prod-price-row {
            margin-top: auto;
            padding-top: 6px;
            display: flex;
            align-items: baseline;
            justify-content: space-between;
        }
        .ws-prod-ws-price {
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
        }
        .ws-prod-ret-price {
            font-size: 0.74rem;
            color: var(--ws-text-light);
            text-decoration: line-through;
        }
        .ws-prod-order-btn {
            margin-top: 8px;
            width: 100%;
            padding: 8px;
            border-radius: var(--ws-radius-sm);
            background: var(--ws-gold-light);
            border: 1px solid var(--ws-gold-border);
            color: var(--ws-gold-primary);
            font-size: 0.76rem;
            font-weight: 700;
            cursor: pointer;
            text-align: center;
            transition: var(--ws-transition);
        }
        .ws-prod-order-btn:hover {
            background: var(--ws-gold-primary);
            color: #FFFFFF;
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

        /* ── Support Ticket Card ── */
        .ws-ticket-card {
            border: 1.5px solid var(--ws-border);
            border-radius: var(--ws-radius-md);
            padding: 14px;
            background: #FFFFFF;
            margin-bottom: 10px;
        }
        .ws-ticket-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
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
            border-top: 1.5px solid var(--ws-gold-border);
            padding: 6px 12px calc(6px + env(safe-area-inset-bottom));
            z-index: 1500;
            box-shadow: 0 -2px 14px rgba(138,104,31,0.08);
            justify-content: space-around;
            align-items: center;
        }
        .ws-dock-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            color: var(--ws-text-muted);
            font-size: 0.65rem;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 8px;
            border: none;
            background: transparent;
            transition: var(--ws-transition);
        }
        .ws-dock-btn svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
        }
        .ws-dock-btn.active {
            color: var(--ws-gold-primary);
            transform: translateY(-2px);
        }
        .ws-dock-btn.active svg { stroke: var(--ws-gold-primary); }

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
           RESPONSIVE MOBILE BREAKPOINTS
        ════════════════════════════════════════════════════ */
        @media (max-width: 992px) {
            .ws-analytics-grid {
                grid-template-columns: 1fr;
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
            .ws-product-card {
                flex: 0 0 calc((100% - 24px) / 3);
                min-width: 140px;
            }
        }

        @media (max-width: 600px) {
            .ws-header {
                padding: 0 12px;
                height: 56px;
            }
            .ws-main-content {
                padding: 12px 10px 80px;
            }
            .ws-table-container {
                display: none;
            }
            .ws-mobile-order-cards {
                display: flex;
            }
            .ws-gst-selector-grid {
                grid-template-columns: 1fr;
            }
            .ws-product-card {
                flex: 0 0 calc((100% - 16px) / 3);
                min-width: 105px;
            }
            .ws-prod-img-wrap {
                height: 125px;
            }
            .ws-prod-name {
                font-size: 0.74rem;
            }
            .ws-prod-ws-price {
                font-size: 0.82rem;
            }
            .ws-prod-ret-price {
                display: none;
            }
            
            /* Slide-Up Bottom Sheet on Mobile */
            .ws-modal-overlay {
                padding: 0;
                align-items: flex-end;
            }
            .ws-modal-box {
                max-height: 94vh;
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

            <!-- Command Search Bar -->
            <div class="ws-cmd-search-wrap">
                <svg class="ws-cmd-search-icon" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" class="ws-cmd-search-input" id="globalSearchInput" placeholder="Search order, product, HSN, invoice..." oninput="handleGlobalQuickSearch(this)">
                <span class="ws-cmd-badge">⌘K</span>
            </div>
        </div>

        <div class="ws-header-right">
            <!-- Dark Mode Toggle -->
            <button class="ws-hdr-icon-btn" title="Toggle Theme" onclick="window.showWsToast('🌙 Dark mode toggle ready!')">
                <svg viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
            </button>

            <!-- Notifications Bell -->
            <button class="ws-hdr-icon-btn" title="Notifications" onclick="window.showWsToast('🔔 2 new consignment dispatches in transit')">
                <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                <span class="ws-notif-dot"></span>
            </button>

            <!-- User Profile Pill -->
            <div class="ws-user-profile-btn" onclick="switchWsTab('details')">
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
                
                <!-- Top 4 Primary Metric Stat Cards (Matching TailAdmin Sizing with Gold Palette) -->
                <div class="ws-metric-cards-grid">
                    
                    <!-- Metric Card 1: Account Tier -->
                    <div class="ws-stat-box">
                        <div class="ws-stat-label">B2B Account Tier</div>
                        <div class="ws-stat-val-row">
                            <div class="ws-stat-val-num" style="color:var(--ws-gold-primary); font-family:var(--ws-font-serif);">VIP Tier 1</div>
                            <span class="ws-trend-pill up">↑ 11.01%</span>
                        </div>
                    </div>

                    <!-- Metric Card 2: Orders -->
                    <div class="ws-stat-box">
                        <div class="ws-stat-label">Total Orders</div>
                        <div class="ws-stat-val-row">
                            <div class="ws-stat-val-num" id="statTotalOrders">6</div>
                            <span class="ws-trend-pill up">↑ 14.20%</span>
                        </div>
                    </div>

                    <!-- Metric Card 3: Total Quantity -->
                    <div class="ws-stat-box">
                        <div class="ws-stat-label">Total Quantity (Units)</div>
                        <div class="ws-stat-val-row">
                            <div class="ws-stat-val-num" id="statTotalQty">48 <span style="font-size:0.95rem; font-weight:600; color:var(--ws-text-muted);">Pcs</span></div>
                            <span class="ws-trend-pill up">↑ 8.50%</span>
                        </div>
                    </div>

                    <!-- Metric Card 4: Total Revenue Turnover -->
                    <div class="ws-stat-box">
                        <div class="ws-stat-label">Total B2B Turnover</div>
                        <div class="ws-stat-val-row">
                            <div class="ws-stat-val-num" id="statTotalAmount" style="color:var(--ws-gold-primary);">₹2,05,062</div>
                            <span class="ws-trend-pill up">↑ 18.40%</span>
                        </div>
                    </div>

                </div>

                <!-- Middle Analytics Grid (Monthly Sales Bar Chart + Target Gauge) -->
                <div class="ws-analytics-grid">
                    
                    <!-- Left: Monthly Sales Bar Chart (Heritage Gold Gradient Bars) -->
                    <div class="ws-analytics-card">
                        <div class="ws-card-top-bar">
                            <h3>Monthly Sales</h3>
                            <button class="ws-dots-btn">⋮</button>
                        </div>

                        <div class="ws-bar-chart-container">
                            <div class="ws-chart-y-axis">
                                <span>400</span>
                                <span>300</span>
                                <span>200</span>
                                <span>100</span>
                                <span>0</span>
                            </div>

                            <!-- 12-Month Bars (Jan - Dec) with Heritage Gold Gradients -->
                            <div class="ws-bar-col" title="Jan: ₹160K"><div class="ws-bar-pill" style="height: 40%;"></div><span class="ws-bar-month">Jan</span></div>
                            <div class="ws-bar-col" title="Feb: ₹380K"><div class="ws-bar-pill" style="height: 95%;"></div><span class="ws-bar-month">Feb</span></div>
                            <div class="ws-bar-col" title="Mar: ₹190K"><div class="ws-bar-pill" style="height: 48%;"></div><span class="ws-bar-month">Mar</span></div>
                            <div class="ws-bar-col" title="Apr: ₹290K"><div class="ws-bar-pill" style="height: 72%;"></div><span class="ws-bar-month">Apr</span></div>
                            <div class="ws-bar-col" title="May: ₹180K"><div class="ws-bar-pill" style="height: 45%;"></div><span class="ws-bar-month">May</span></div>
                            <div class="ws-bar-col" title="Jun: ₹190K"><div class="ws-bar-pill" style="height: 48%;"></div><span class="ws-bar-month">Jun</span></div>
                            <div class="ws-bar-col" title="Jul: ₹280K"><div class="ws-bar-pill" style="height: 70%;"></div><span class="ws-bar-month">Jul</span></div>
                            <div class="ws-bar-col" title="Aug: ₹100K"><div class="ws-bar-pill" style="height: 25%;"></div><span class="ws-bar-month">Aug</span></div>
                            <div class="ws-bar-col" title="Sep: ₹210K"><div class="ws-bar-pill" style="height: 52%;"></div><span class="ws-bar-month">Sep</span></div>
                            <div class="ws-bar-col active" title="Oct: ₹390K"><div class="ws-bar-pill" style="height: 98%;"></div><span class="ws-bar-month">Oct</span></div>
                            <div class="ws-bar-col" title="Nov: ₹270K"><div class="ws-bar-pill" style="height: 68%;"></div><span class="ws-bar-month">Nov</span></div>
                            <div class="ws-bar-col" title="Dec: ₹110K"><div class="ws-bar-pill" style="height: 28%;"></div><span class="ws-bar-month">Dec</span></div>
                        </div>
                    </div>

                    <!-- Right: Semi-Circular Target Gauge (Royal Gold Arc) -->
                    <div class="ws-analytics-card">
                        <div class="ws-gauge-wrap">
                            <svg class="ws-gauge-svg" viewBox="0 0 200 110">
                                <defs>
                                    <linearGradient id="goldGaugeGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" stop-color="#8A681F"/>
                                        <stop offset="100%" stop-color="#C5A859"/>
                                    </linearGradient>
                                </defs>
                                <path class="ws-gauge-bg-arc" d="M 20 100 A 80 80 0 0 1 180 100"></path>
                                <path class="ws-gauge-fill-arc" d="M 20 100 A 80 80 0 0 1 180 100"></path>
                            </svg>
                            <div class="ws-gauge-center-text">75.55%</div>
                            <div class="ws-gauge-badge">+10%</div>
                            <p class="ws-gauge-desc">You earned <strong>₹32,870</strong> today, it's higher than last month. Keep up your wholesale growth!</p>
                        </div>

                        <div class="ws-gauge-stats-row">
                            <div>
                                <div class="ws-g-stat-label">Target</div>
                                <div class="ws-g-stat-val" style="color:var(--ws-danger);">₹50K ↓</div>
                            </div>
                            <div>
                                <div class="ws-g-stat-label">Revenue</div>
                                <div class="ws-g-stat-val" style="color:var(--ws-success);">₹48.5K ↑</div>
                            </div>
                            <div>
                                <div class="ws-g-stat-label">Today</div>
                                <div class="ws-g-stat-val" style="color:var(--ws-gold-primary);">₹18.2K ↑</div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Statistics & Segmented Controls Bar -->
                <div class="ws-section-header">
                    <div class="ws-sec-title-box">
                        <h3>Statistics</h3>
                        <p>Target you've set for each month</p>
                    </div>

                    <div class="ws-sec-actions-row">
                        <div class="ws-segmented-control">
                            <button class="ws-seg-btn active" onclick="setOverviewFilter('overview', this)">Overview</button>
                            <button class="ws-seg-btn" onclick="setOverviewFilter('sales', this)">Sales</button>
                            <button class="ws-seg-btn" onclick="setOverviewFilter('revenue', this)">Revenue</button>
                        </div>
                        <div class="ws-date-range-pill">
                            <span>📅</span>
                            <span>Aug 10 - Aug 16</span>
                        </div>
                    </div>
                </div>

                <!-- Trending Catalog Carousel (5 on Desktop, 3 on Mobile) -->
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group">
                            <svg style="width:18px;height:18px;stroke:var(--ws-gold-primary);fill:none;stroke-width:2;" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            <h3>Trending Wholesale Catalog (MOQ Ready)</h3>
                        </div>
                        <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="switchWsTab('trending')">
                            View All (<?= count($catalogProducts) ?>) →
                        </button>
                    </div>

                    <div class="ws-slider-wrap">
                        <button class="ws-slider-nav-btn prev" onclick="slideTrendingProducts(-1)" aria-label="Previous">❮</button>
                        <div class="ws-slider-track" id="wsTrendingSliderTrack">
                            <?php foreach ($catalogProducts as $prod): ?>
                            <div class="ws-product-card">
                                <div class="ws-prod-img-wrap">
                                    <span class="ws-prod-badge"><?= $prod['badge_icon'] ?? '🔥' ?> <?= htmlspecialchars($prod['badge']) ?></span>
                                    <span class="ws-prod-moq">MOQ: <?= $prod['moq'] ?> Pcs</span>
                                    <img src="<?= htmlspecialchars($prod['image']) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" class="ws-prod-img" onerror="this.src='images/product1.png';" loading="lazy">
                                </div>
                                <div class="ws-prod-body">
                                    <span class="ws-prod-cat"><?= htmlspecialchars($prod['category']) ?> • HSN: <?= $prod['hsn'] ?></span>
                                    <h4 class="ws-prod-name"><?= htmlspecialchars($prod['name']) ?></h4>
                                    <div class="ws-prod-price-row">
                                        <span class="ws-prod-ws-price">₹<?= number_format($prod['wholesale_price']) ?> <span style="font-size:0.70rem; font-weight:600; color:var(--ws-text-muted);">/ Pc</span></span>
                                        <span class="ws-prod-ret-price">₹<?= number_format($prod['retail_price']) ?></span>
                                    </div>
                                    <button class="ws-prod-order-btn" onclick="openQuickOrderModal(<?= htmlspecialchars(json_encode($prod)) ?>)">
                                        ⚡ WhatsApp Lot Order
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button class="ws-slider-nav-btn next" onclick="slideTrendingProducts(1)" aria-label="Next">❯</button>
                    </div>
                </div>

                <!-- Recent Orders Snapshot -->
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group">
                            <svg style="width:18px;height:18px;stroke:var(--ws-gold-primary);fill:none;stroke-width:2;" viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            <h3>Recent Wholesale Dispatches</h3>
                        </div>
                        <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="switchWsTab('orders')">
                            Full Order Book →
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
                            
                            <div class="ws-form-group full">
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
                    <div class="ws-card-header">
                        <div class="ws-card-title-group">
                            <h3>All Wholesale Orders & Consignments</h3>
                        </div>
                        <a href="shop.php" class="ws-btn ws-btn-primary ws-btn-sm">
                            + Place New Bulk Lot
                        </a>
                    </div>

                    <!-- Search & Filter Controls -->
                    <div style="display:flex; justify-content:space-between; gap:10px; flex-wrap:wrap; margin-bottom:16px;">
                        <input type="text" id="wsOrdersSearchInput" class="ws-input" style="max-width:320px;" placeholder="Search Order ID, Product, Courier..." oninput="filterOrdersTable()">

                        <div style="display:flex; gap:6px;">
                            <button class="ws-btn ws-btn-secondary ws-btn-sm active" onclick="setOrderStatusFilter('all', this)">All</button>
                            <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="setOrderStatusFilter('Shipped', this)">Shipped</button>
                            <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="setOrderStatusFilter('Delivered', this)">Delivered</button>
                            <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="setOrderStatusFilter('Processing', this)">Processing</button>
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
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group">
                            <h3>Wholesale B2B Sales & Procurement Reports</h3>
                        </div>
                        <div style="display:flex; gap:8px;">
                            <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="exportReportsToCsv()">
                                📥 Export CSV
                            </button>
                            <button class="ws-btn ws-btn-primary ws-btn-sm" onclick="window.print()">
                                🖨️ Print Report
                            </button>
                        </div>
                    </div>

                    <div class="ws-table-container">
                        <table class="ws-table">
                            <thead>
                                <tr>
                                    <th>Consignment</th>
                                    <th>Date</th>
                                    <th>HSN</th>
                                    <th>Item Summary</th>
                                    <th>Qty (Pcs)</th>
                                    <th>Taxable Value</th>
                                    <th>GST (5%)</th>
                                    <th>Net Total</th>
                                    <th>Payment Mode</th>
                                </tr>
                            </thead>
                            <tbody id="wsReportsTbody">
                                <!-- Populated dynamically by JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>


            <!-- ═══════════════════════════════════════
                 TAB 7: LIVE SHIPMENT TRACKING
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneTracking">
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group">
                            <h3>Live Heavy Logistics & Parcel Tracking</h3>
                        </div>
                        <span class="ws-status-badge shipped">⚡ BlueDart Air Express</span>
                    </div>

                    <div style="background:#FAF8F4; border:1.5px solid var(--ws-border); border-radius:10px; padding:16px; margin-bottom:16px;">
                        <div style="display:flex; justify-content:space-between; flex-wrap:wrap; gap:10px;">
                            <div>
                                <h4 style="font-size:1rem; font-weight:800; color:var(--ws-gold-primary); font-family:var(--ws-font-serif);">
                                    Order #KLN-WS-8021
                                </h4>
                                <div style="font-size:0.80rem; color:var(--ws-text-muted); margin-top:2px;">
                                    Nilambari Silk Saree (Pack of 12) • AWB: <strong>884729104</strong>
                                </div>
                            </div>
                            <div style="text-align:right;">
                                <div style="font-size:0.74rem; color:var(--ws-text-muted);">Estimated Delivery</div>
                                <div style="font-size:0.95rem; font-weight:800; color:var(--ws-success);">Tomorrow, 17 Aug 2026</div>
                            </div>
                        </div>

                        <!-- 5-Stage Logistics Timeline -->
                        <div class="ws-track-timeline">
                            <div class="ws-timeline-step completed">
                                <div class="ws-timeline-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                                <div class="ws-timeline-title">Order Confirmed & Proforma Invoiced</div>
                                <div class="ws-timeline-date">Kalaniketan Head Atelier, Surat • 14 Aug, 10:30 AM</div>
                            </div>
                            <div class="ws-timeline-step completed">
                                <div class="ws-timeline-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                                <div class="ws-timeline-title">QC Inspection & Bale Packaging Completed</div>
                                <div class="ws-timeline-date">Zari & Silk Warehouse • 14 Aug, 03:45 PM</div>
                            </div>
                            <div class="ws-timeline-step active">
                                <div class="ws-timeline-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                                <div class="ws-timeline-title">In Transit — Arrived at Regional Distribution Hub</div>
                                <div class="ws-timeline-date">Mumbai Sort Facility • 16 Aug, 01:15 AM (Live Update)</div>
                            </div>
                            <div class="ws-timeline-step">
                                <div class="ws-timeline-dot"></div>
                                <div class="ws-timeline-title">Out for Delivery to Warehouse</div>
                                <div class="ws-timeline-date">Expected 17 Aug, by 04:00 PM</div>
                            </div>
                        </div>

                        <div style="margin-top:14px;">
                            <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%2C%20please%20share%20driver%20contact%20for%20consignment%20KLN-WS-8021" target="_blank" class="ws-btn ws-btn-wa ws-btn-sm">
                                💬 WhatsApp Driver Desk
                            </a>
                        </div>
                    </div>
                </div>
            </section>


            <!-- ═══════════════════════════════════════
                 TAB 8: SUPPORT & TICKETS
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneSupport">
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group">
                            <h3>B2B Wholesaler Concierge & Ticket Desk</h3>
                        </div>
                        <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%20Kalaniketan%2C%20I%20am%20a%20registered%20Wholesaler%20and%20require%20urgent%20support" target="_blank" class="ws-btn ws-btn-wa ws-btn-sm">
                            ⚡ Instant WhatsApp Stylist
                        </a>
                    </div>

                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(clamp(260px, 45vw, 320px), 1fr)); gap:16px;">
                        
                        <!-- Open New Ticket Form -->
                        <div style="background:#FAF8F4; padding:16px; border-radius:12px; border:1.5px solid var(--ws-border);">
                            <h4 style="font-size:0.95rem; font-weight:700; color:var(--ws-gold-primary); margin-bottom:12px; font-family:var(--ws-font-serif);">
                                ✍️ Create New Support Ticket
                            </h4>

                            <form id="wsTicketForm" onsubmit="handleCreateTicket(event)">
                                <div class="ws-form-group">
                                    <label class="ws-label" for="ticketOrderId">Related Order ID <span class="req">*</span></label>
                                    <select id="ticketOrderId" class="ws-select" required>
                                        <option value="KLN-WS-8021">KLN-WS-8021 (Nilambari Silk 12 Pcs)</option>
                                        <option value="KLN-WS-7914">KLN-WS-7914 (Banarasi Zari 8 Pcs)</option>
                                        <option value="General Inquiry">General / Custom Catalog Inquiry</option>
                                    </select>
                                </div>

                                <div class="ws-form-group">
                                    <label class="ws-label" for="ticketCategory">Issue Category <span class="req">*</span></label>
                                    <select id="ticketCategory" class="ws-select" required>
                                        <option value="Delivery Delay">Logistics & Dispatch Inquiry</option>
                                        <option value="Bulk Pricing Negotiation">Bulk Lot Pricing & Discount Enquiry</option>
                                        <option value="GST Tax Invoice Issue">GST Input Tax Credit Invoice Query</option>
                                    </select>
                                </div>

                                <div class="ws-form-group">
                                    <label class="ws-label" for="ticketMessage">Detailed Issue Narrative <span class="req">*</span></label>
                                    <textarea id="ticketMessage" class="ws-textarea" required placeholder="Describe your inquiry or order feedback in detail..."></textarea>
                                </div>

                                <button type="submit" class="ws-btn ws-btn-primary" style="width:100%;">
                                    Submit Ticket
                                </button>
                            </form>
                        </div>

                        <!-- Ticket History List -->
                        <div>
                            <h4 style="font-size:0.95rem; font-weight:700; color:var(--ws-gold-primary); margin-bottom:12px; font-family:var(--ws-font-serif);">
                                📋 My Open & Resolved Tickets
                            </h4>

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
                        <div class="ws-card-title-group">
                            <h3>B2B Wholesale Master Catalog (Wholesale Tier Pricing)</h3>
                        </div>
                        <a href="shop.php" class="ws-btn ws-btn-secondary ws-btn-sm">
                            Browse Retail Store →
                        </a>
                    </div>

                    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(clamp(145px, 28vw, 200px), 1fr)); gap:12px;">
                        <?php foreach ($catalogProducts as $prod): ?>
                        <div class="ws-product-card" style="flex:auto; min-width:auto;">
                            <div class="ws-prod-img-wrap">
                                <span class="ws-prod-badge"><?= $prod['badge_icon'] ?? '🔥' ?> <?= htmlspecialchars($prod['badge']) ?></span>
                                <span class="ws-prod-moq">MOQ: <?= $prod['moq'] ?> Pcs</span>
                                <img src="<?= htmlspecialchars($prod['image']) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" class="ws-prod-img" onerror="this.src='images/product1.png';" loading="lazy">
                            </div>
                            <div class="ws-prod-body">
                                <span class="ws-prod-cat"><?= htmlspecialchars($prod['category']) ?> • HSN: <?= $prod['hsn'] ?></span>
                                <h4 class="ws-prod-name"><?= htmlspecialchars($prod['name']) ?></h4>
                                <div class="ws-prod-price-row">
                                    <span class="ws-prod-ws-price">₹<?= number_format($prod['wholesale_price']) ?> / Pc</span>
                                    <span class="ws-prod-ret-price">₹<?= number_format($prod['retail_price']) ?></span>
                                </div>
                                <button class="ws-prod-order-btn" onclick="openQuickOrderModal(<?= htmlspecialchars(json_encode($prod)) ?>)">
                                    ⚡ Instant WhatsApp Lot Order
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
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
        <button class="ws-dock-btn" id="dockBtnDetails" onclick="switchWsTab('details')">
            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            <span>Profile</span>
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
            var fieldWrap = document.getElementById('gstNumberFieldWrap');
            var gstInput = document.getElementById('wsGstNumber');

            if (mode === 'gst') {
                if (cardGst) cardGst.classList.add('selected');
                if (cardNonGst) cardNonGst.classList.remove('selected');
                if (fieldWrap) fieldWrap.style.display = 'flex';
                if (gstInput) gstInput.required = true;
            } else {
                if (cardGst) cardGst.classList.remove('selected');
                if (cardNonGst) cardNonGst.classList.add('selected');
                if (fieldWrap) fieldWrap.style.display = 'none';
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

        /* ── Save Wholesaler Details ── */
        window.handleSaveWholesalerDetails = function(e) {
            e.preventDefault();
            var name = document.getElementById('wsProfName').value.trim();
            var phone = document.getElementById('wsProfPhone').value.trim();
            var email = document.getElementById('wsProfEmail').value.trim();
            var newPass = document.getElementById('wsNewPass').value.trim();

            if (!name) { alert('Please enter representative name'); return; }
            if (phone.length !== 10) { alert('Please enter a valid 10-digit WhatsApp number'); return; }

            var userRaw = localStorage.getItem('kalaniketan_user');
            var user = userRaw ? JSON.parse(userRaw) : {};
            user.name = name;
            user.phone = '+91 ' + phone;
            user.rawPhone = phone;
            user.email = email;
            if (newPass) user.password = newPass;

            localStorage.setItem('kalaniketan_user', JSON.stringify(user));
            loadSavedWholesalerData();
            window.showWsToast('🎉 Profile details saved successfully!');
        };

        /* ── Save GST Profile ── */
        window.handleSaveGstProfile = function(e) {
            e.preventDefault();
            var company = document.getElementById('wsCompanyName').value.trim();
            var gstNum = document.getElementById('wsGstNumber').value.trim().toUpperCase();

            if (!company) { alert('Please enter legal business company name'); return; }
            if (activeGstMode === 'gst' && gstNum.length !== 15) {
                alert('Please enter a valid 15-character GSTIN number');
                return;
            }

            var userRaw = localStorage.getItem('kalaniketan_user');
            var user = userRaw ? JSON.parse(userRaw) : {};
            user.companyName = company;
            user.gst_type = activeGstMode;
            user.gst_number = activeGstMode === 'gst' ? gstNum : '';

            localStorage.setItem('kalaniketan_user', JSON.stringify(user));
            loadSavedWholesalerData();
            window.showWsToast('🛡️ Business Tax Profile saved successfully!');
        };

        /* ── Save Address ── */
        window.handleSaveAddress = function(e) {
            e.preventDefault();
            var addr = document.getElementById('wsFullAddress').value.trim();
            var city = document.getElementById('wsCity').value.trim();
            var state = document.getElementById('wsStateSelect').value;
            var pin = document.getElementById('wsPincode').value.trim();

            if (!addr || !city || !pin) { alert('Please complete all address fields'); return; }
            if (pin.length !== 6) { alert('Please enter a valid 6-digit Indian PIN code'); return; }

            var userRaw = localStorage.getItem('kalaniketan_user');
            var user = userRaw ? JSON.parse(userRaw) : {};
            user.address = addr;
            user.city = city;
            user.state = state;
            user.pincode = pin;

            localStorage.setItem('kalaniketan_user', JSON.stringify(user));
            loadSavedWholesalerData();
            window.showWsToast('📍 Wholesale Dispatch Address updated!');
        };

        /* ── Render Orders Table & Mobile Cards ── */
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
                var statusClass = o.status.toLowerCase();

                // 1. Desktop Row
                var tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="ws-order-id-cell">${o.id}</td>
                    <td style="color:#6B6358; font-weight:600; font-size:0.78rem;">${o.date}</td>
                    <td>
                        <div class="ws-prod-mini-cell">
                            <img src="${o.image}" alt="${o.productName}" class="ws-prod-mini-img" onerror="this.src='images/product1.png';">
                            <div>
                                <strong style="font-size:0.84rem; color:var(--ws-text-main);">${o.productName}</strong>
                                <div style="font-size:0.74rem; color:var(--ws-text-muted);">SKU: ${o.sku} • ${o.courier}</div>
                            </div>
                        </div>
                    </td>
                    <td><strong style="font-size:0.84rem;">${o.qty} Pcs</strong></td>
                    <td><strong style="color:var(--ws-gold-primary); font-size:0.92rem;">₹${Number(o.total).toLocaleString('en-IN')}</strong></td>
                    <td><span class="ws-status-badge ${statusClass}">${o.status}</span></td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick='viewOrderDetails(${JSON.stringify(o)})'>
                                Details
                            </button>
                            <button class="ws-btn ws-btn-primary ws-btn-sm" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                                📄 Bill PDF
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
                        <span class="ws-order-id-cell" style="font-size:0.88rem;">${o.id}</span>
                        <span class="ws-status-badge ${statusClass}">${o.status}</span>
                    </div>
                    <div class="ws-mob-order-body">
                        <img src="${o.image}" alt="${o.productName}" class="ws-mob-order-img" onerror="this.src='images/product1.png';">
                        <div class="ws-mob-order-info">
                            <h4 class="ws-mob-order-title">${o.productName}</h4>
                            <div class="ws-mob-order-meta">${o.date} • Lot: <strong>${o.qty} Pcs</strong></div>
                            <div class="ws-mob-order-meta">${o.courier} (AWB: ${o.awb})</div>
                            <div class="ws-mob-order-price-row">
                                <span class="ws-mob-order-price">₹${Number(o.total).toLocaleString('en-IN')}</span>
                            </div>
                        </div>
                    </div>
                    <div class="ws-mob-order-actions">
                        <button class="ws-btn ws-btn-secondary ws-btn-sm" style="flex:1;" onclick='viewOrderDetails(${JSON.stringify(o)})'>
                            View Details
                        </button>
                        <button class="ws-btn ws-btn-primary ws-btn-sm" style="flex:1;" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                            📄 GST Bill
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
                    var statusClass = o.status.toLowerCase();
                    var card = document.createElement('div');
                    card.className = 'ws-mob-order-card';
                    card.innerHTML = `
                        <div class="ws-mob-order-top">
                            <span class="ws-order-id-cell" style="font-size:0.88rem;">${o.id}</span>
                            <span class="ws-status-badge ${statusClass}">${o.status}</span>
                        </div>
                        <div class="ws-mob-order-body">
                            <img src="${o.image}" alt="${o.productName}" class="ws-mob-order-img" onerror="this.src='images/product1.png';">
                            <div class="ws-mob-order-info">
                                <h4 class="ws-mob-order-title">${o.productName}</h4>
                                <div class="ws-mob-order-meta">${o.date} • Lot: <strong>${o.qty} Pcs</strong></div>
                                <div class="ws-mob-order-price-row">
                                    <span class="ws-mob-order-price">₹${Number(o.total).toLocaleString('en-IN')}</span>
                                    <button class="ws-btn ws-btn-primary ws-btn-sm" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                                        📄 GST Bill
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

        /* ── Filter Orders Controller ── */
        window.filterOrdersTable = function() {
            var search = (document.getElementById('wsOrdersSearchInput').value || '').toLowerCase().trim();
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

        window.setOrderStatusFilter = function(status, btn) {
            currentOrderStatusFilter = status;
            btn.parentElement.querySelectorAll('button').forEach(function(b) {
                b.classList.remove('active');
            });
            if (btn) btn.classList.add('active');
            filterOrdersTable();
        };

        window.setOverviewFilter = function(mode, btn) {
            btn.parentElement.querySelectorAll('button').forEach(function(b) {
                b.classList.remove('active');
            });
            btn.classList.add('active');
            window.showWsToast('📊 Switched to ' + mode.toUpperCase() + ' analytics mode');
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

        /* ── Render Reports Table ── */
        function renderReportsView(orders) {
            var tbody = document.getElementById('wsReportsTbody');
            if (!tbody) return;
            tbody.innerHTML = '';

            orders.forEach(function(o) {
                var tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="ws-order-id-cell">${o.id}</td>
                    <td style="font-size:0.78rem; color:#6B6358;">${o.date}</td>
                    <td><span style="font-family:monospace; background:var(--ws-gold-light); color:var(--ws-gold-primary); padding:2px 6px; border-radius:4px; font-weight:700;">${o.hsn}</span></td>
                    <td><strong>${o.productName}</strong></td>
                    <td><strong>${o.qty}</strong></td>
                    <td>₹${Number(o.subtotal).toLocaleString('en-IN')}</td>
                    <td style="color:#10B981; font-weight:700;">₹${Number(o.tax).toLocaleString('en-IN')}</td>
                    <td><strong style="color:var(--ws-gold-primary); font-size:0.90rem;">₹${Number(o.total).toLocaleString('en-IN')}</strong></td>
                    <td style="font-size:0.76rem; color:var(--ws-text-muted);">${o.payment}</td>
                `;
                tbody.appendChild(tr);
            });
        }

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
                var statusColor = t.status === 'Resolved' ? '#10B981' : '#F59E0B';
                var card = document.createElement('div');
                card.className = 'ws-ticket-card';
                card.innerHTML = `
                    <div class="ws-ticket-head">
                        <span style="font-size:0.80rem; font-weight:800; color:var(--ws-gold-primary);">Ticket #${t.id}</span>
                        <span style="font-size:0.70rem; font-weight:800; color:${statusColor}; background:#F8FAFC; padding:2px 8px; border-radius:12px; border:1px solid ${statusColor};">${t.status}</span>
                    </div>
                    <div style="font-size:0.80rem; font-weight:700; color:var(--ws-text-main);">Order Ref: ${t.orderId} • ${t.category}</div>
                    <p style="font-size:0.78rem; color:var(--ws-text-muted); margin-top:4px;">"${t.message}"</p>
                    <div style="font-size:0.72rem; color:var(--ws-text-light); margin-top:6px; display:flex; justify-content:space-between;">
                        <span>📅 ${t.date}</span>
                        <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%2C%20following%20up%20on%20Wholesaler%20Ticket%20%23${t.id}" target="_blank" style="color:#25D366; font-weight:800; text-decoration:none;">
                            WhatsApp Followup →
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

            title.textContent = `Order Details #${o.id}`;
            body.innerHTML = `
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; padding-bottom:12px; border-bottom:1px solid var(--ws-border);">
                    <div>
                        <div style="font-size:0.76rem; color:var(--ws-text-muted);">Consignment Placed</div>
                        <strong style="font-size:0.92rem; color:var(--ws-text-main);">${o.date}</strong>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:0.76rem; color:var(--ws-text-muted);">Current Status</div>
                        <span class="ws-status-badge ${o.status.toLowerCase()}">${o.status}</span>
                    </div>
                </div>

                <div style="display:flex; gap:14px; margin-bottom:14px; background:#FAF8F4; border:1px solid var(--ws-border); border-radius:10px; padding:12px;">
                    <img src="${o.image}" alt="${o.productName}" style="width:72px; height:90px; border-radius:8px; object-fit:cover; border:1px solid var(--ws-border); flex-shrink:0;">
                    <div style="flex:1;">
                        <h4 style="font-size:0.95rem; font-weight:800; color:var(--ws-text-main); margin-bottom:4px; line-height:1.25;">${o.productName}</h4>
                        <div style="font-size:0.78rem; color:var(--ws-text-muted);">SKU: ${o.sku} • HSN Code: ${o.hsn}</div>
                        <div style="font-size:0.78rem; color:var(--ws-text-muted);">Color: ${o.color} • Size: ${o.size}</div>
                        <div style="font-size:0.86rem; font-weight:800; color:var(--ws-gold-primary); margin-top:6px;">
                            ${o.qty} Pcs @ ₹${Number(o.unitPrice).toLocaleString('en-IN')} / Pc
                        </div>
                    </div>
                </div>

                <div style="background:#FAF8F4; border:1px solid var(--ws-border); border-radius:10px; padding:14px; margin-bottom:14px; font-size:0.82rem;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <span style="color:var(--ws-text-muted);">Taxable Item Total</span>
                        <strong style="color:var(--ws-text-main);">₹${Number(o.subtotal).toLocaleString('en-IN')}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <span style="color:var(--ws-text-muted);">CGST (2.5%) + SGST (2.5%)</span>
                        <strong style="color:#10B981;">₹${Number(o.tax).toLocaleString('en-IN')}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                        <span style="color:var(--ws-text-muted);">Wholesale Volume Discount</span>
                        <strong style="color:#10B981;">-₹${Number(o.discount).toLocaleString('en-IN')}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding-top:8px; border-top:1px solid var(--ws-border); font-size:1.05rem; font-weight:900; color:var(--ws-gold-primary);">
                        <span>Total Paid / Payable</span>
                        <span>₹${Number(o.total).toLocaleString('en-IN')}</span>
                    </div>
                </div>

                <div style="font-size:0.80rem; color:var(--ws-text-sub); line-height:1.5; background:#FFFFFF; border:1px solid var(--ws-border); border-radius:8px; padding:10px 14px;">
                    <p><strong>Logistics Partner:</strong> ${o.courier} (AWB: ${o.awb})</p>
                    <p><strong>Payment Instrument:</strong> ${o.payment}</p>
                </div>
            `;

            if (footer) {
                footer.innerHTML = `
                    <button class="ws-btn ws-btn-primary" style="flex:1;" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                        📄 Download GST Bill PDF
                    </button>
                    <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%2C%20I%20would%20like%20to%20repeat%20wholesale%20lot%20order%20for%20${encodeURIComponent(o.productName)}%20(${o.qty}%20Pcs)" target="_blank" class="ws-btn ws-btn-wa" style="flex:1;">
                        💬 Repeat Wholesale Lot
                    </a>
                `;
            }

            modal.classList.add('active');
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

        /* ── Trending Products Slider Scrolling ── */
        window.slideTrendingProducts = function(dir) {
            var track = document.getElementById('wsTrendingSliderTrack');
            if (!track) return;
            var scrollAmount = track.offsetWidth * 0.75 * dir;
            track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        };

        /* ── Quick Wholesale Lot WhatsApp Order ── */
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

            activeOrdersList = SAMPLE_ORDERS.slice();
            activeTicketsList = SAMPLE_TICKETS.slice();

            loadSavedWholesalerData();
            renderOrdersView(activeOrdersList);
            renderReportsView(activeOrdersList);
            renderTicketsView();
        }

        document.addEventListener('DOMContentLoaded', initWholesalerApp);
        window.addEventListener('storage', function(e) {
            if (e.key === 'kalaniketan_user') {
                initWholesalerApp();
            }
        });

    })();
    </script>
</body>
</html>
