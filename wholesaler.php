<?php
/**
 * wholesaler.php — Next-Level Luxury Wholesaler User Dashboard (B2B VIP Portal)
 * Kalaniketan Ethnic Luxury Couture
 * 
 * Features:
 * - Strict Wholesaler Role Security Gate (Frontend + Backend validation)
 * - Auto-Sizing Fluid Mobile Architecture (320px to 4K Ultra HD)
 * - Glassmorphic Header & Native-Feel Mobile Navigation Dock
 * - 6 Elevated Real-Time Metric Cards with Trends & Micro-Gradients
 * - "My Details" Profile Management with Indian +91 Validation & Password Toggle
 * - "GST / Non-GST Profile" with Live Indian 15-Char GSTIN Validation & State Code Resolver
 * - "My Address Book" with 36 Indian States/UTs Selection & 6-Digit PIN Validation
 * - "Order List" & "Order Details Modal" with Responsive Desktop Table & Mobile Cards
 * - "Advanced Reports" with Search, Date Presets, Pagination & Instant CSV Export
 * - "Live Shipment Tracking" Engine with Animated Pulse Timeline & WhatsApp Driver Desk
 * - "Support Desk & Ticket System" with Filterable History & VIP WhatsApp Stylist Concierge
 * - "Download Bill PDF" High-Definition GST Tax Invoice with QR & Seal
 * - "Trending Products Slider" (5 visible on Desktop, 3 on Mobile with Snap-Swipe)
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
    <title>Wholesaler B2B VIP Hub — Kalaniketan Luxury Ethnic</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            /* ── Luxury Gold & Obsidian Color System ── */
            --ws-gold-primary: #8A681F;
            --ws-gold-deep: #5A4210;
            --ws-gold-accent: #C5A859;
            --ws-gold-light: #EBDCB2;
            --ws-gold-pale: #FBF8F1;
            --ws-gold-glow: rgba(197, 168, 89, 0.28);
            --ws-gold-border: rgba(138, 104, 31, 0.24);

            --ws-dark-text: #110E0B;
            --ws-mid-text: #3B352E;
            --ws-light-text: #71695F;
            --ws-off-white: #FAF8F5;
            --ws-cream-bg: #F4EFE6;
            --ws-pure-white: #FFFFFF;

            --ws-sidebar-bg: #14110E;
            --ws-sidebar-hover: #221D18;
            --ws-sidebar-active: #8A681F;
            --ws-card-border: #E8E2D5;
            
            --ws-success: #15803D;
            --ws-success-bg: #DCFCE7;
            --ws-warning: #B45309;
            --ws-warning-bg: #FEF3C7;
            --ws-info: #1D4ED8;
            --ws-info-bg: #DBEAFE;
            --ws-danger: #B91C1C;
            --ws-danger-bg: #FEE2E2;

            --ws-font-serif: 'Cinzel', serif;
            --ws-font-sans: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;

            --ws-shadow-sm: 0 2px 6px rgba(0,0,0,0.04);
            --ws-shadow-md: 0 6px 18px rgba(0,0,0,0.06);
            --ws-shadow-lg: 0 14px 38px rgba(0,0,0,0.09);
            --ws-shadow-gold: 0 4px 20px rgba(138, 104, 31, 0.20);

            --ws-radius-sm: 8px;
            --ws-radius-md: 12px;
            --ws-radius-lg: 16px;
            --ws-transition: all 0.24s cubic-bezier(0.4, 0, 0.2, 1);
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
            background: var(--ws-off-white);
            color: var(--ws-dark-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
            padding-bottom: env(safe-area-inset-bottom);
        }

        /* ── Top Header Navigation Bar ── */
        .ws-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 2px solid var(--ws-gold-primary);
            padding: clamp(6px, 1.5vw, 10px) clamp(12px, 3vw, 24px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            height: clamp(52px, 7vw, 62px);
        }
        .ws-header-left {
            display: flex;
            align-items: center;
            gap: clamp(8px, 1.8vw, 14px);
        }
        .ws-menu-toggle-btn {
            display: none;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1.5px solid var(--ws-gold-border);
            background: var(--ws-gold-pale);
            color: var(--ws-gold-primary);
            cursor: pointer;
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
        .ws-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        .ws-brand-seal {
            width: clamp(32px, 4.5vw, 40px);
            height: clamp(32px, 4.5vw, 40px);
            border-radius: 50%;
            background: linear-gradient(135deg, var(--ws-gold-accent) 0%, var(--ws-gold-primary) 50%, var(--ws-gold-deep) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            box-shadow: var(--ws-shadow-gold);
            flex-shrink: 0;
            border: 1.5px solid #FFFFFF;
        }
        .ws-brand-seal svg {
            width: 19px;
            height: 19px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
        }
        .ws-brand-text h1 {
            font-family: var(--ws-font-serif);
            font-size: clamp(0.95rem, 2.2vw, 1.2rem);
            font-weight: 800;
            color: var(--ws-gold-primary);
            letter-spacing: 0.08em;
            line-height: 1;
        }
        .ws-brand-text span {
            font-size: clamp(0.55rem, 1.2vw, 0.65rem);
            color: var(--ws-mid-text);
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 2px;
        }
        .ws-brand-text span .spark {
            color: #D97706;
        }

        .ws-header-right {
            display: flex;
            align-items: center;
            gap: clamp(6px, 1.5vw, 12px);
        }
        .ws-user-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--ws-gold-pale);
            border: 1.5px solid var(--ws-gold-border);
            padding: 4px 12px 4px 5px;
            border-radius: 28px;
            text-decoration: none;
            color: var(--ws-dark-text);
            box-shadow: var(--ws-shadow-sm);
            transition: var(--ws-transition);
        }
        .ws-user-pill:hover {
            border-color: var(--ws-gold-primary);
            box-shadow: var(--ws-shadow-gold);
        }
        .ws-user-avatar {
            width: clamp(28px, 4vw, 32px);
            height: clamp(28px, 4vw, 32px);
            border-radius: 50%;
            background: linear-gradient(135deg, #8A681F 0%, #4D370E 100%);
            color: #FAF5E8;
            font-weight: 900;
            font-size: 0.78rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid #FFFFFF;
            flex-shrink: 0;
        }
        .ws-user-info-brief {
            display: flex;
            flex-direction: column;
            line-height: 1.15;
        }
        .ws-user-name {
            font-size: clamp(0.72rem, 1.5vw, 0.80rem);
            font-weight: 800;
            color: var(--ws-dark-text);
            white-space: nowrap;
            max-width: clamp(90px, 18vw, 180px);
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .ws-user-tag {
            font-size: 0.58rem;
            font-weight: 800;
            color: #8A681F;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .ws-header-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: var(--ws-radius-sm);
            border: 1.2px solid var(--ws-card-border);
            background: #FFFFFF;
            color: var(--ws-mid-text);
            font-size: 0.76rem;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
            transition: var(--ws-transition);
        }
        .ws-header-btn:hover {
            border-color: var(--ws-gold-primary);
            color: var(--ws-gold-primary);
            background: var(--ws-gold-pale);
        }

        /* ── Main App Layout Grid ── */
        .ws-app-layout {
            display: flex;
            flex: 1;
            min-height: calc(100vh - 62px);
        }

        /* ── Sidebar Navigation ── */
        .ws-sidebar {
            width: 260px;
            background: var(--ws-sidebar-bg);
            color: #E7E2D6;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            border-right: 1px solid rgba(197, 168, 89, 0.2);
            transition: var(--ws-transition);
            z-index: 900;
        }
        .ws-sidebar-profile {
            padding: 18px 14px;
            background: rgba(255,255,255,0.03);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .ws-side-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8A681F 0%, #D4AF37 100%);
            color: #14110E;
            font-weight: 900;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #FAF5E8;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }
        .ws-side-profile-info h3 {
            font-family: var(--ws-font-serif);
            font-size: 0.88rem;
            font-weight: 800;
            color: #FAF5E8;
            margin: 0;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 160px;
        }
        .ws-side-profile-info span {
            font-size: 0.62rem;
            color: #C5A859;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            display: inline-block;
            margin-top: 3px;
        }

        .ws-nav-list {
            list-style: none;
            padding: 12px 10px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 5px;
            overflow-y: auto;
        }
        .ws-nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 10px;
            color: #D1C7B7;
            text-decoration: none;
            font-size: 0.80rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--ws-transition);
            border: 1px solid transparent;
            user-select: none;
        }
        .ws-nav-item:hover {
            background: var(--ws-sidebar-hover);
            color: #FFFFFF;
            border-color: rgba(197,168,89,0.25);
            transform: translateX(3px);
        }
        .ws-nav-item.active {
            background: linear-gradient(135deg, #8A681F 0%, #5F4512 100%);
            color: #FFFFFF;
            box-shadow: 0 4px 14px rgba(138,104,31,0.45);
            border-color: #C5A859;
        }
        .ws-nav-item svg {
            width: 17px;
            height: 17px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
            flex-shrink: 0;
        }
        .ws-nav-badge {
            margin-left: auto;
            background: #D97706;
            color: #FFFFFF;
            font-size: 0.64rem;
            font-weight: 800;
            padding: 2px 7px;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }
        .ws-nav-badge.green {
            background: #16A34A;
        }

        .ws-sidebar-footer {
            padding: 12px;
            border-top: 1px solid rgba(255,255,255,0.08);
            background: rgba(0,0,0,0.3);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .ws-logout-btn {
            width: 100%;
            padding: 9px 12px;
            border-radius: var(--ws-radius-sm);
            border: 1px solid rgba(220, 38, 38, 0.4);
            background: rgba(220, 38, 38, 0.12);
            color: #FCA5A5;
            font-size: 0.76rem;
            font-weight: 800;
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
            border-color: #DC2626;
        }

        /* ── Main Content Area ── */
        .ws-main-content {
            flex: 1;
            padding: clamp(12px, 2.5vw, 24px) clamp(12px, 3vw, 28px) clamp(60px, 8vw, 80px);
            overflow-y: auto;
            max-width: 1350px;
            margin: 0 auto;
            width: 100%;
        }

        /* ── Tab View Containers ── */
        .ws-tab-pane {
            display: none;
            animation: paneFadeIn 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .ws-tab-pane.active {
            display: block;
        }
        @keyframes paneFadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── Page Header / Welcome Banner ── */
        .ws-welcome-banner {
            background: linear-gradient(135deg, #FAF6EE 0%, #F5EDE0 100%);
            border: 1.5px solid var(--ws-gold-border);
            border-radius: var(--ws-radius-lg);
            padding: clamp(14px, 2.5vw, 22px) clamp(16px, 3vw, 28px);
            margin-bottom: clamp(14px, 2.2vw, 22px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px;
            box-shadow: var(--ws-shadow-sm);
            position: relative;
            overflow: hidden;
        }
        .ws-welcome-banner::after {
            content: '👑';
            position: absolute;
            right: -10px;
            bottom: -15px;
            font-size: 5.5rem;
            opacity: 0.08;
            pointer-events: none;
        }
        .ws-welcome-left h2 {
            font-family: var(--ws-font-serif);
            font-size: clamp(1.1rem, 2.8vw, 1.45rem);
            font-weight: 800;
            color: var(--ws-gold-primary);
            line-height: 1.2;
        }
        .ws-welcome-left p {
            font-size: clamp(0.74rem, 1.4vw, 0.82rem);
            color: var(--ws-mid-text);
            margin-top: 4px;
            font-weight: 500;
        }
        .ws-welcome-badges {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .ws-tag-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 24px;
            font-size: 0.72rem;
            font-weight: 800;
            background: #FFFFFF;
            border: 1.2px solid var(--ws-gold-border);
            color: var(--ws-gold-primary);
            box-shadow: var(--ws-shadow-sm);
        }
        .ws-tag-pill.verified {
            background: #ECFDF5;
            border-color: #6EE7B7;
            color: #065F46;
        }

        /* ── 6 Statistics Metric Cards Grid ── */
        .ws-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(clamp(135px, 28vw, 185px), 1fr));
            gap: clamp(10px, 1.8vw, 16px);
            margin-bottom: clamp(16px, 2.5vw, 24px);
        }
        .ws-stat-card {
            background: #FFFFFF;
            border: 1.5px solid var(--ws-card-border);
            border-radius: var(--ws-radius-md);
            padding: clamp(12px, 2vw, 16px);
            box-shadow: var(--ws-shadow-sm);
            transition: var(--ws-transition);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .ws-stat-card:hover {
            border-color: var(--ws-gold-primary);
            transform: translateY(-3px);
            box-shadow: var(--ws-shadow-md);
        }
        .ws-stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3.5px;
            background: var(--stat-accent, #8A681F);
        }
        .ws-stat-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .ws-stat-title {
            font-size: clamp(0.64rem, 1.2vw, 0.70rem);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--ws-light-text);
        }
        .ws-stat-icon-wrap {
            width: clamp(26px, 4vw, 32px);
            height: clamp(26px, 4vw, 32px);
            border-radius: 8px;
            background: var(--stat-bg, #FAF5E8);
            color: var(--stat-accent, #8A681F);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .ws-stat-icon-wrap svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
        }
        .ws-stat-val {
            font-family: var(--ws-font-serif);
            font-size: clamp(1.25rem, 3.2vw, 1.60rem);
            font-weight: 900;
            color: var(--ws-dark-text);
            line-height: 1.1;
        }
        .ws-stat-sub {
            font-size: clamp(0.60rem, 1.1vw, 0.68rem);
            color: var(--ws-light-text);
            margin-top: 4px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .ws-stat-trend {
            font-weight: 800;
            font-size: 0.65rem;
            padding: 1px 5px;
            border-radius: 10px;
        }
        .ws-stat-trend.up { background: #DCFCE7; color: #15803D; }
        .ws-stat-trend.neutral { background: #F3F4F6; color: #4B5563; }

        /* ── Standard Section Cards ── */
        .ws-card {
            background: #FFFFFF;
            border: 1.5px solid var(--ws-card-border);
            border-radius: var(--ws-radius-lg);
            padding: clamp(14px, 2.5vw, 22px);
            margin-bottom: clamp(14px, 2.2vw, 20px);
            box-shadow: var(--ws-shadow-sm);
        }
        .ws-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1.5px dashed var(--ws-card-border);
            flex-wrap: wrap;
            gap: 10px;
        }
        .ws-card-title-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .ws-card-title-group svg {
            width: 20px;
            height: 20px;
            stroke: var(--ws-gold-primary);
            stroke-width: 2.2;
            fill: none;
            flex-shrink: 0;
        }
        .ws-card-title-group h3 {
            font-family: var(--ws-font-serif);
            font-size: clamp(0.92rem, 2vw, 1.05rem);
            font-weight: 800;
            color: var(--ws-gold-primary);
            letter-spacing: 0.04em;
        }

        /* ── Form Inputs & Layout ── */
        .ws-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(clamp(200px, 40vw, 280px), 1fr));
            gap: clamp(10px, 2vw, 16px);
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
            font-size: clamp(0.70rem, 1.2vw, 0.75rem);
            font-weight: 800;
            color: var(--ws-dark-text);
            letter-spacing: 0.02em;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .ws-label .req {
            color: var(--ws-danger);
        }
        .ws-input, .ws-select, .ws-textarea {
            width: 100%;
            height: 40px;
            border: 1.5px solid #D5CEBF;
            border-radius: var(--ws-radius-sm);
            padding: 0 12px;
            font-family: var(--ws-font-sans);
            font-size: clamp(0.78rem, 1.4vw, 0.84rem);
            color: var(--ws-dark-text);
            background: #FAF9F5;
            outline: none;
            transition: var(--ws-transition);
        }
        .ws-textarea {
            height: 85px;
            padding: 10px 12px;
            resize: vertical;
        }
        .ws-input:focus, .ws-select:focus, .ws-textarea:focus {
            border-color: var(--ws-gold-primary);
            background: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(138,104,31,0.18);
        }
        .ws-input:disabled {
            background: #EFECE6;
            color: #8C8275;
            cursor: not-allowed;
        }
        .ws-input-helper {
            font-size: 0.65rem;
            color: var(--ws-light-text);
            font-weight: 500;
        }

        .ws-phone-wrap {
            display: flex;
            align-items: center;
            border: 1.5px solid #D5CEBF;
            border-radius: var(--ws-radius-sm);
            background: #FAF9F5;
            overflow: hidden;
            transition: var(--ws-transition);
        }
        .ws-phone-wrap:focus-within {
            border-color: var(--ws-gold-primary);
            background: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(138,104,31,0.18);
        }
        .ws-phone-prefix {
            padding: 0 12px;
            font-size: 0.80rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
            background: #F0EAD8;
            height: 40px;
            display: flex;
            align-items: center;
            border-right: 1px solid #D5CEBF;
            flex-shrink: 0;
        }
        .ws-phone-input {
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            padding: 0 12px !important;
        }

        .ws-pass-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .ws-pass-toggle {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--ws-light-text);
            font-size: 0.75rem;
            font-weight: 700;
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
            gap: 8px;
            padding: 9px 18px;
            border-radius: var(--ws-radius-sm);
            font-size: clamp(0.74rem, 1.4vw, 0.80rem);
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
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
            box-shadow: 0 3px 10px rgba(138,104,31,0.28);
        }
        .ws-btn-primary:hover {
            background: linear-gradient(135deg, #785A1A 0%, #4D370E 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(138,104,31,0.38);
        }
        .ws-btn-secondary {
            background: #FAF8F4;
            color: var(--ws-dark-text);
            border-color: #D5CEBF;
        }
        .ws-btn-secondary:hover {
            background: #FFFFFF;
            border-color: var(--ws-gold-primary);
            color: var(--ws-gold-primary);
        }
        .ws-btn-success {
            background: #16A34A;
            color: #FFFFFF;
        }
        .ws-btn-success:hover {
            background: #15803D;
        }
        .ws-btn-wa {
            background: #25D366;
            color: #FFFFFF;
            border-color: #25D366;
            box-shadow: 0 2px 8px rgba(37, 211, 102, 0.3);
        }
        .ws-btn-wa:hover {
            background: #128C7E;
            box-shadow: 0 4px 14px rgba(37, 211, 102, 0.4);
        }
        .ws-btn-sm {
            padding: 6px 12px;
            font-size: 0.72rem;
        }

        /* ── GST Radio Cards ── */
        .ws-gst-selector-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 16px;
        }
        .ws-gst-option-card {
            border: 1.5px solid var(--ws-card-border);
            border-radius: var(--ws-radius-md);
            padding: 14px 16px;
            background: #FAF9F5;
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
            background: #FCF8EE;
            box-shadow: 0 3px 10px rgba(138,104,31,0.18);
        }
        .ws-radio-dot {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid #A8A095;
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

        /* ── Filter / Search Bar ── */
        .ws-filter-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 16px;
            background: #FAF8F4;
            border: 1px solid var(--ws-card-border);
            padding: 10px 14px;
            border-radius: var(--ws-radius-md);
        }
        .ws-search-input-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
        }
        .ws-search-input-wrap svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            stroke: var(--ws-light-text);
            stroke-width: 2;
            fill: none;
        }
        .ws-search-input {
            padding-left: 36px !important;
            height: 36px !important;
            font-size: 0.80rem !important;
            background: #FFFFFF !important;
        }
        .ws-date-pills {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }
        .ws-date-pill-btn {
            padding: 5px 12px;
            border-radius: 20px;
            border: 1.2px solid #D5CEBF;
            background: #FFFFFF;
            font-size: 0.70rem;
            font-weight: 700;
            color: var(--ws-mid-text);
            cursor: pointer;
            transition: var(--ws-transition);
        }
        .ws-date-pill-btn:hover {
            border-color: var(--ws-gold-primary);
            color: var(--ws-gold-primary);
        }
        .ws-date-pill-btn.active {
            background: var(--ws-gold-primary);
            color: #FFFFFF;
            border-color: var(--ws-gold-primary);
        }

        /* ── Responsive Order Table ── */
        .ws-table-container {
            width: 100%;
            overflow-x: auto;
            border-radius: var(--ws-radius-md);
            border: 1px solid var(--ws-card-border);
        }
        .ws-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.80rem;
            background: #FFFFFF;
        }
        .ws-table th {
            background: #FAF6ED;
            color: var(--ws-gold-primary);
            font-family: var(--ws-font-serif);
            font-weight: 800;
            font-size: 0.72rem;
            padding: 12px 14px;
            border-bottom: 1.5px solid var(--ws-gold-border);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }
        .ws-table td {
            padding: 12px 14px;
            border-bottom: 1px solid #EFEBE4;
            color: var(--ws-dark-text);
            vertical-align: middle;
        }
        .ws-table tr:hover td {
            background: #FCFBF8;
        }
        .ws-order-id-cell {
            font-weight: 800;
            color: var(--ws-gold-primary);
            font-family: var(--ws-font-serif);
        }
        .ws-prod-mini-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .ws-prod-mini-img {
            width: 36px;
            height: 46px;
            border-radius: 4px;
            object-fit: cover;
            border: 1px solid #E7E2D6;
            flex-shrink: 0;
        }

        /* ── Status Badges ── */
        .ws-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 14px;
            font-size: 0.68rem;
            font-weight: 800;
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
        .ws-status-badge.exchange { background: #E0E7FF; color: #3730A3; }

        /* ── Mobile Order Cards ── */
        .ws-mobile-order-cards {
            display: none;
            flex-direction: column;
            gap: 12px;
        }
        .ws-mob-order-card {
            background: #FFFFFF;
            border: 1.5px solid var(--ws-card-border);
            border-radius: var(--ws-radius-md);
            padding: 14px;
            box-shadow: var(--ws-shadow-sm);
        }
        .ws-mob-order-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 8px;
            border-bottom: 1px dashed #EAE5DB;
        }
        .ws-mob-order-body {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
        }
        .ws-mob-order-img {
            width: 52px;
            height: 66px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid #E7E2D6;
            flex-shrink: 0;
        }
        .ws-mob-order-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }
        .ws-mob-order-title {
            font-size: 0.85rem;
            font-weight: 800;
            color: var(--ws-dark-text);
            line-height: 1.25;
        }
        .ws-mob-order-meta {
            font-size: 0.70rem;
            color: var(--ws-light-text);
        }
        .ws-mob-order-price-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 4px;
        }
        .ws-mob-order-price {
            font-size: 0.95rem;
            font-weight: 900;
            color: var(--ws-gold-primary);
        }
        .ws-mob-order-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            padding-top: 10px;
            border-top: 1px solid #F0EBE0;
        }

        /* ── Pagination ── */
        .ws-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 16px;
            font-size: 0.78rem;
            color: var(--ws-light-text);
            flex-wrap: wrap;
            gap: 10px;
        }
        .ws-page-controls {
            display: flex;
            gap: 6px;
        }
        .ws-page-btn {
            min-width: 30px;
            height: 30px;
            border-radius: 6px;
            border: 1px solid var(--ws-card-border);
            background: #FFFFFF;
            color: var(--ws-dark-text);
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--ws-transition);
        }
        .ws-page-btn.active {
            background: var(--ws-gold-primary);
            color: #FFFFFF;
            border-color: var(--ws-gold-primary);
        }
        .ws-page-btn:hover:not(.active) {
            border-color: var(--ws-gold-primary);
            color: var(--ws-gold-primary);
        }

        /* ── Trending Products Slider (5 on Desktop, 3 on Mobile) ── */
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
            border: 1.5px solid var(--ws-gold-primary);
            color: var(--ws-gold-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--ws-shadow-md);
            z-index: 10;
            transition: var(--ws-transition);
        }
        .ws-slider-nav-btn:hover {
            background: var(--ws-gold-primary);
            color: #FFFFFF;
        }
        .ws-slider-nav-btn.prev { left: -16px; }
        .ws-slider-nav-btn.next { right: -16px; }

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
            border: 1.5px solid var(--ws-card-border);
            border-radius: var(--ws-radius-md);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: var(--ws-transition);
            box-shadow: var(--ws-shadow-sm);
            scroll-snap-align: start;
        }
        .ws-product-card:hover {
            border-color: var(--ws-gold-primary);
            transform: translateY(-4px);
            box-shadow: var(--ws-shadow-md);
        }
        .ws-prod-img-wrap {
            position: relative;
            width: 100%;
            height: 185px;
            background: #F5F1E8;
            overflow: hidden;
        }
        .ws-prod-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center top;
            transition: transform 0.4s ease;
        }
        .ws-product-card:hover .ws-prod-img {
            transform: scale(1.06);
        }
        .ws-prod-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: var(--ws-gold-primary);
            color: #FFFFFF;
            font-size: 0.60rem;
            font-weight: 800;
            text-transform: uppercase;
            padding: 2px 7px;
            border-radius: 4px;
            letter-spacing: 0.05em;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }
        .ws-prod-moq {
            position: absolute;
            bottom: 6px;
            right: 6px;
            background: rgba(20,17,14,0.90);
            color: #FBBF24;
            font-size: 0.60rem;
            font-weight: 800;
            padding: 3px 7px;
            border-radius: 4px;
            border: 1px solid rgba(251, 191, 36, 0.3);
        }
        .ws-prod-body {
            padding: 12px;
            display: flex;
            flex-direction: column;
            gap: 5px;
            flex: 1;
        }
        .ws-prod-cat {
            font-size: 0.64rem;
            font-weight: 700;
            color: var(--ws-light-text);
            text-transform: uppercase;
        }
        .ws-prod-name {
            font-family: var(--ws-font-serif);
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--ws-dark-text);
            line-height: 1.25;
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
            font-size: 0.92rem;
            font-weight: 900;
            color: var(--ws-gold-primary);
        }
        .ws-prod-ret-price {
            font-size: 0.70rem;
            color: var(--ws-light-text);
            text-decoration: line-through;
        }
        .ws-prod-order-btn {
            margin-top: 8px;
            width: 100%;
            padding: 7px;
            border-radius: var(--ws-radius-sm);
            background: var(--ws-gold-pale);
            border: 1px solid var(--ws-gold-border);
            color: var(--ws-gold-primary);
            font-size: 0.72rem;
            font-weight: 800;
            cursor: pointer;
            text-align: center;
            transition: var(--ws-transition);
        }
        .ws-prod-order-btn:hover {
            background: var(--ws-gold-primary);
            color: #FFFFFF;
            border-color: var(--ws-gold-primary);
        }

        /* ── Modals Backdrop & Box ── */
        .ws-modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(17, 14, 11, 0.85);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 2000000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.28s ease, visibility 0.28s ease;
            padding: 14px;
        }
        .ws-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .ws-modal-box {
            background: #FCFBF8;
            width: 100%;
            max-width: 620px;
            max-height: 92vh;
            border-radius: var(--ws-radius-lg);
            border: 1.5px solid var(--ws-gold-primary);
            box-shadow: 0 24px 70px rgba(0,0,0,0.4);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transform: translateY(24px) scale(0.97);
            transition: transform 0.32s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .ws-modal-overlay.active .ws-modal-box {
            transform: translateY(0) scale(1);
        }
        .ws-modal-header {
            background: #FFFFFF;
            border-bottom: 1.5px solid var(--ws-gold-border);
            padding: 12px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }
        .ws-modal-title {
            font-family: var(--ws-font-serif);
            font-size: 1rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .ws-modal-close-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid var(--ws-gold-border);
            background: #FAF8F4;
            color: var(--ws-gold-primary);
            font-size: 1.15rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--ws-transition);
        }
        .ws-modal-close-btn:hover {
            background: var(--ws-gold-primary);
            color: #FFFFFF;
            transform: rotate(90deg);
        }
        .ws-modal-body {
            padding: 18px;
            overflow-y: auto;
            flex: 1;
            -webkit-overflow-scrolling: touch;
        }

        /* ── Interactive Shipment Timeline (Live Tracking) ── */
        .ws-track-timeline {
            position: relative;
            padding-left: 32px;
            margin: 18px 0;
        }
        .ws-track-timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 8px;
            bottom: 8px;
            width: 2.5px;
            background: #DDD5C7;
        }
        .ws-timeline-step {
            position: relative;
            margin-bottom: 20px;
        }
        .ws-timeline-step:last-child {
            margin-bottom: 0;
        }
        .ws-timeline-dot {
            position: absolute;
            left: -32px;
            top: 2px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #DDD5C7;
            border: 3px solid #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.12);
        }
        .ws-timeline-step.completed .ws-timeline-dot {
            background: #16A34A;
        }
        .ws-timeline-step.active .ws-timeline-dot {
            background: #8A681F;
            box-shadow: 0 0 0 4px rgba(138,104,31,0.25);
            animation: pulseDot 1.8s infinite;
        }
        @keyframes pulseDot {
            0% { box-shadow: 0 0 0 0 rgba(138,104,31,0.5); }
            70% { box-shadow: 0 0 0 10px rgba(138,104,31,0); }
            100% { box-shadow: 0 0 0 0 rgba(138,104,31,0); }
        }
        .ws-timeline-dot svg {
            width: 11px;
            height: 11px;
            stroke: #FFFFFF;
            stroke-width: 3;
            fill: none;
        }
        .ws-timeline-title {
            font-size: 0.84rem;
            font-weight: 800;
            color: var(--ws-dark-text);
        }
        .ws-timeline-date {
            font-size: 0.68rem;
            color: var(--ws-light-text);
            margin-top: 3px;
        }

        /* ── Support Ticket Chat Items ── */
        .ws-ticket-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .ws-ticket-card {
            border: 1.5px solid var(--ws-card-border);
            border-radius: var(--ws-radius-md);
            padding: 14px;
            background: #FFFFFF;
            transition: var(--ws-transition);
        }
        .ws-ticket-card:hover {
            border-color: var(--ws-gold-primary);
            box-shadow: var(--ws-shadow-sm);
        }
        .ws-ticket-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }
        .ws-ticket-sub {
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--ws-dark-text);
        }
        .ws-ticket-msg {
            font-size: 0.76rem;
            color: var(--ws-mid-text);
            line-height: 1.45;
        }

        /* ── Printable PDF Bill Styling ── */
        .ws-invoice-sheet {
            background: #FFFFFF;
            border: 1px solid #DDD8CD;
            border-radius: 10px;
            padding: 24px;
            font-family: var(--ws-font-sans);
            color: #14110E;
        }
        .ws-inv-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            border-bottom: 2.5px solid #8A681F;
            padding-bottom: 16px;
            margin-bottom: 18px;
        }
        .ws-inv-brand h2 {
            font-family: var(--ws-font-serif);
            font-size: 1.35rem;
            color: #8A681F;
            font-weight: 900;
        }
        .ws-inv-brand p {
            font-size: 0.72rem;
            color: #554E44;
            line-height: 1.35;
        }
        .ws-inv-meta {
            text-align: right;
            font-size: 0.74rem;
            line-height: 1.45;
        }
        .ws-inv-meta strong {
            color: #8A681F;
        }
        .ws-inv-parties {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            background: #FAF8F4;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 0.76rem;
        }
        .ws-inv-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.76rem;
            margin-bottom: 18px;
        }
        .ws-inv-table th {
            background: #8A681F;
            color: #FFFFFF;
            padding: 9px 12px;
            text-align: left;
        }
        .ws-inv-table td {
            padding: 9px 12px;
            border-bottom: 1px solid #E5E0D5;
        }
        .ws-inv-totals {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 5px;
            font-size: 0.78rem;
            border-top: 1.5px solid #8A681F;
            padding-top: 12px;
        }
        .ws-inv-grand-total {
            font-size: 1.15rem;
            font-weight: 900;
            color: #8A681F;
        }

        /* ── Role Access Gate Modal ── */
        .ws-gate-box {
            text-align: center;
            padding: 26px 20px;
        }
        .ws-gate-icon {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: #FAF5E8;
            border: 2px solid var(--ws-gold-primary);
            color: var(--ws-gold-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            box-shadow: var(--ws-shadow-gold);
        }
        .ws-gate-icon svg {
            width: 34px;
            height: 34px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }
        .ws-gate-box h3 {
            font-family: var(--ws-font-serif);
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
            margin-bottom: 10px;
        }
        .ws-gate-box p {
            font-size: 0.82rem;
            color: var(--ws-mid-text);
            margin-bottom: 20px;
            line-height: 1.55;
        }

        /* ── Mobile Floating Bottom App Dock ── */
        .ws-mobile-dock {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(20, 17, 14, 0.95);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-top: 1.5px solid rgba(197, 168, 89, 0.35);
            padding: 6px 12px calc(6px + env(safe-area-inset-bottom));
            z-index: 1500;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.3);
            justify-content: space-around;
            align-items: center;
        }
        .ws-dock-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            color: #A89E90;
            font-size: 0.62rem;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
            padding: 4px 8px;
            border-radius: 8px;
            transition: var(--ws-transition);
            border: none;
            background: transparent;
        }
        .ws-dock-btn svg {
            width: 19px;
            height: 19px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
        }
        .ws-dock-btn.active {
            color: #FBBF24;
            transform: translateY(-2px);
        }
        .ws-dock-btn.active svg {
            stroke: #FBBF24;
        }

        /* ── Toast Container ── */
        .ws-toast-container {
            position: fixed;
            bottom: 68px;
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
            font-size: 0.78rem;
            font-weight: 700;
            box-shadow: 0 8px 24px rgba(0,0,0,0.35);
            border: 1.5px solid #C5A859;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: toastPop 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-align: center;
            justify-content: center;
        }
        @keyframes toastPop {
            from { opacity: 0; transform: translateY(14px) scale(0.9); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ════════════════════════════════════════════════════
           RESPONSIVE MOBILE BREAKPOINTS & AUTO-SIZING
        ════════════════════════════════════════════════════ */
        @media (max-width: 900px) {
            .ws-menu-toggle-btn {
                display: flex;
            }
            .ws-sidebar {
                position: fixed;
                top: 58px;
                left: 0;
                bottom: 0;
                transform: translateX(-100%);
                box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            }
            .ws-sidebar.open {
                transform: translateX(0);
            }
            .ws-sidebar-backdrop {
                position: fixed;
                top: 58px; left: 0; width: 100%; height: calc(100vh - 58px);
                background: rgba(0,0,0,0.65);
                backdrop-filter: blur(4px);
                z-index: 850;
                display: none;
            }
            .ws-sidebar-backdrop.active {
                display: block;
            }
            .ws-mobile-dock {
                display: flex;
            }
            .ws-product-card {
                flex: 0 0 calc((100% - 24px) / 3); /* Exactly 3 items visible on tablet/mobile */
                min-width: 140px;
            }
        }

        @media (max-width: 600px) {
            .ws-header {
                padding: 6px 10px;
                height: 52px;
            }
            .ws-main-content {
                padding: 10px 8px 75px;
            }
            .ws-user-name {
                display: none;
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
                flex: 0 0 calc((100% - 16px) / 3); /* Exactly 3 items visible on phone screen */
                min-width: 105px;
            }
            .ws-prod-img-wrap {
                height: 120px;
            }
            .ws-prod-name {
                font-size: 0.68rem;
            }
            .ws-prod-ws-price {
                font-size: 0.76rem;
            }
            .ws-prod-ret-price {
                display: none;
            }
            .ws-prod-body {
                padding: 8px 6px;
                gap: 3px;
            }
            .ws-prod-order-btn {
                font-size: 0.64rem;
                padding: 5px;
                margin-top: 4px;
            }
            .ws-modal-box {
                max-height: 98vh;
                border-radius: 14px;
            }
            .ws-modal-body {
                padding: 14px;
            }
            .ws-inv-parties {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- ═══ Mobile Sidebar Backdrop ═══ -->
    <div class="ws-sidebar-backdrop" id="wsSidebarBackdrop" onclick="toggleSidebar(false)"></div>

    <!-- ═══ Top Header Navigation ═══ -->
    <header class="ws-header">
        <div class="ws-header-left">
            <button class="ws-menu-toggle-btn" id="wsMenuToggleBtn" onclick="toggleSidebar()" aria-label="Toggle Menu">
                <svg viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>

            <a href="shop.php" class="ws-brand">
                <div class="ws-brand-seal">
                    <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                </div>
                <div class="ws-brand-text">
                    <h1>KALANIKETAN</h1>
                    <span>Wholesaler Portal <span class="spark">✨</span></span>
                </div>
            </a>
        </div>

        <div class="ws-header-right">
            <a href="shop.php" class="ws-header-btn">
                <svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                <span>Shop</span>
            </a>

            <div class="ws-user-pill">
                <div class="ws-user-avatar" id="headerUserAvatar">WS</div>
                <div class="ws-user-info-brief">
                    <span class="ws-user-name" id="headerUserName">Wholesale Member</span>
                    <span class="ws-user-tag">👑 VIP Wholesaler</span>
                </div>
            </div>
        </div>
    </header>

    <!-- ═══ Main App Layout Grid ═══ -->
    <div class="ws-app-layout">
        
        <!-- ── Left Sidebar Navigation ── -->
        <aside class="ws-sidebar" id="wsSidebar">
            <div class="ws-sidebar-profile">
                <div class="ws-side-avatar" id="sideUserAvatar">WS</div>
                <div class="ws-side-profile-info">
                    <h3 id="sideUserName">Shree Krishna Silks</h3>
                    <span id="sideGstBadge">GST Verified</span>
                </div>
            </div>

            <ul class="ws-nav-list">
                <li>
                    <a class="ws-nav-item active" onclick="switchWsTab('overview')">
                        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="ws-nav-item" onclick="switchWsTab('details')">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>My Details</span>
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
                        <span>My Address</span>
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
                    </a>
                </li>
                <li>
                    <a class="ws-nav-item" onclick="switchWsTab('tracking')">
                        <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span>Live Tracking</span>
                        <span class="ws-nav-badge green">Live</span>
                    </a>
                </li>
                <li>
                    <a class="ws-nav-item" onclick="switchWsTab('support')">
                        <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                        <span>Support Desk</span>
                    </a>
                </li>
                <li>
                    <a class="ws-nav-item" onclick="switchWsTab('trending')">
                        <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <span>Trending Catalog</span>
                    </a>
                </li>
            </ul>

            <div class="ws-sidebar-footer">
                <button class="ws-logout-btn" onclick="handleWholesalerLogout()">
                    <svg style="width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2.2;" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    <span>Log Out Wholesaler</span>
                </button>
            </div>
        </aside>

        <!-- ── Main Content Container ── -->
        <main class="ws-main-content">

            <!-- ═══════════════════════════════════════
                 TAB 1: OVERVIEW DASHBOARD
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane active" id="tabPaneOverview">
                
                <!-- Welcome Banner -->
                <div class="ws-welcome-banner">
                    <div class="ws-welcome-left">
                        <h2>Welcome back, <span id="welcomeUserName">Rajesh Kumar</span> 👋</h2>
                        <p>Kalaniketan B2B Wholesaler Hub • Instant bulk inventory, order dispatch tracking, and GST invoicing.</p>
                    </div>
                    <div class="ws-welcome-badges">
                        <span class="ws-tag-pill verified">🛡️ Verified Wholesaler</span>
                        <span class="ws-tag-pill" id="welcomeGstPill">GST: 24AABCU9603R1ZM</span>
                    </div>
                </div>

                <!-- 6 Metric Cards Grid -->
                <div class="ws-stats-grid">
                    
                    <!-- Card 1: Total Orders -->
                    <div class="ws-stat-card" style="--stat-accent:#8A681F; --stat-bg:#FAF5E8;">
                        <div class="ws-stat-head">
                            <span class="ws-stat-title">Total Orders</span>
                            <div class="ws-stat-icon-wrap">
                                <svg viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val" id="statTotalOrders">6</div>
                        <div class="ws-stat-sub">
                            <span class="ws-stat-trend up">+14.2% ↑</span> vs last month
                        </div>
                    </div>

                    <!-- Card 2: Total Quantity -->
                    <div class="ws-stat-card" style="--stat-accent:#2563EB; --stat-bg:#EFF6FF;">
                        <div class="ws-stat-head">
                            <span class="ws-stat-title">Total Quantity</span>
                            <div class="ws-stat-icon-wrap">
                                <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val" id="statTotalQty">48 <span style="font-size:0.75rem; font-family:var(--ws-font-sans); color:var(--ws-light-text);">Pcs</span></div>
                        <div class="ws-stat-sub">
                            <span class="ws-stat-trend up">+8.5% ↑</span> Bulk lots
                        </div>
                    </div>

                    <!-- Card 3: Total Return -->
                    <div class="ws-stat-card" style="--stat-accent:#DC2626; --stat-bg:#FEF2F2;">
                        <div class="ws-stat-head">
                            <span class="ws-stat-title">Total Return</span>
                            <div class="ws-stat-icon-wrap">
                                <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val" id="statTotalReturn">1</div>
                        <div class="ws-stat-sub">
                            <span class="ws-stat-trend neutral">0% Defect</span> Rate
                        </div>
                    </div>

                    <!-- Card 4: Total Refund -->
                    <div class="ws-stat-card" style="--stat-accent:#D97706; --stat-bg:#FFFBEB;">
                        <div class="ws-stat-head">
                            <span class="ws-stat-title">Total Refund</span>
                            <div class="ws-stat-icon-wrap">
                                <svg viewBox="0 0 24 24"><rect x="2" y="6" width="20" height="12" rx="2"></rect><circle cx="12" cy="12" r="2"></circle><path d="M6 12h.01M18 12h.01"></path></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val" id="statTotalRefund">₹21,590</div>
                        <div class="ws-stat-sub">Credited to Bank NEFT</div>
                    </div>

                    <!-- Card 5: Total Exchange -->
                    <div class="ws-stat-card" style="--stat-accent:#7C3AED; --stat-bg:#F5F3FF;">
                        <div class="ws-stat-head">
                            <span class="ws-stat-title">Total Exchange</span>
                            <div class="ws-stat-icon-wrap">
                                <svg viewBox="0 0 24 24"><path d="M7 16V4m0 0L3 8m4-4l4 4m6 4v12m0 0l4-4m-4 4l-4-4"/></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val" id="statTotalExchange">0</div>
                        <div class="ws-stat-sub">Fast Replacement Active</div>
                    </div>

                    <!-- Card 6: Total Amount -->
                    <div class="ws-stat-card" style="--stat-accent:#16A34A; --stat-bg:#F0FDF4;">
                        <div class="ws-stat-head">
                            <span class="ws-stat-title">Total Amount</span>
                            <div class="ws-stat-icon-wrap">
                                <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val" id="statTotalAmount">₹2,05,062</div>
                        <div class="ws-stat-sub">Cumulative B2B Turnover</div>
                    </div>

                </div>

                <!-- Trending Catalog Carousel (5 on Desktop, 3 on Mobile) -->
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group">
                            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
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
                                    <span class="ws-prod-badge"><?= htmlspecialchars($prod['badge']) ?></span>
                                    <span class="ws-prod-moq">MOQ: <?= $prod['moq'] ?> Pcs</span>
                                    <img src="<?= htmlspecialchars($prod['image']) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" class="ws-prod-img" onerror="this.src='images/product1.png';" loading="lazy">
                                </div>
                                <div class="ws-prod-body">
                                    <span class="ws-prod-cat"><?= htmlspecialchars($prod['category']) ?> • HSN: <?= $prod['hsn'] ?></span>
                                    <h4 class="ws-prod-name"><?= htmlspecialchars($prod['name']) ?></h4>
                                    <div class="ws-prod-price-row">
                                        <span class="ws-prod-ws-price">₹<?= number_format($prod['wholesale_price']) ?> <span style="font-size:0.65rem; font-weight:600;">/ Pc</span></span>
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
                            <svg viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
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
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <h3>Wholesaler Representative Details</h3>
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
                                <input type="text" class="ws-input" value="👑 Wholesaler B2B Tier" disabled>
                            </div>

                        </div>

                        <div style="margin-top: 14px; padding-top: 14px; border-top: 1px dashed var(--ws-card-border);">
                            <h4 style="font-family:var(--ws-font-serif); font-size:0.90rem; color:var(--ws-gold-primary); margin-bottom:10px;">
                                🔒 Change Password (Leave blank to keep current)
                            </h4>
                            <div class="ws-form-grid">
                                <div class="ws-form-group">
                                    <label class="ws-label" for="wsCurrentPass">Current Password</label>
                                    <div class="ws-pass-wrap">
                                        <input type="password" id="wsCurrentPass" class="ws-input" placeholder="Enter current password">
                                        <button type="button" class="ws-pass-toggle" onclick="togglePassVisibility('wsCurrentPass')">👁️</button>
                                    </div>
                                </div>
                                <div class="ws-form-group">
                                    <label class="ws-label" for="wsNewPass">New Password</label>
                                    <div class="ws-pass-wrap">
                                        <input type="password" id="wsNewPass" class="ws-input" placeholder="Minimum 6 characters">
                                        <button type="button" class="ws-pass-toggle" onclick="togglePassVisibility('wsNewPass')">👁️</button>
                                    </div>
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
                            <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                            <h3>GST & Business Tax Configuration</h3>
                        </div>
                    </div>

                    <!-- GST Type Selector Cards -->
                    <div class="ws-gst-selector-grid">
                        <div class="ws-gst-option-card selected" id="gstCardGst" onclick="selectGstMode('gst')">
                            <div class="ws-radio-dot"></div>
                            <div>
                                <strong style="font-size:0.85rem; color:var(--ws-dark-text);">Registered with GST (Input Tax Credit)</strong>
                                <p style="font-size:0.70rem; color:var(--ws-light-text); margin-top:2px;">Get official GSTR-1 compliant tax invoices for input tax credit.</p>
                            </div>
                        </div>

                        <div class="ws-gst-option-card" id="gstCardNonGst" onclick="selectGstMode('non_gst')">
                            <div class="ws-radio-dot"></div>
                            <div>
                                <strong style="font-size:0.85rem; color:var(--ws-dark-text);">Unregistered / Non-GST Trader</strong>
                                <p style="font-size:0.70rem; color:var(--ws-light-text); margin-top:2px;">Retail bills issued under composition or trader exempt threshold.</p>
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
                                    <span id="gstStateDetectTag" style="font-size:0.68rem; color:#8A681F; font-weight:700;">Format: 24AABCU9603R1ZM</span>
                                </label>
                                <input type="text" id="wsGstNumber" class="ws-input" placeholder="e.g. 24AABCU9603R1ZM" maxlength="15" style="text-transform:uppercase; font-family:monospace; letter-spacing:0.08em;" oninput="validateGstinInput(this)">
                                <div class="ws-input-helper" id="gstinValidationMsg">Standard 15-character Indian Goods & Services Tax Identification Number.</div>
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
                            <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
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
                                    <option value="Punjab">Punjab (03)</option>
                                    <option value="Haryana">Haryana (06)</option>
                                    <option value="Andhra Pradesh">Andhra Pradesh (37)</option>
                                    <option value="Bihar">Bihar (10)</option>
                                    <option value="Chhattisgarh">Chhattisgarh (22)</option>
                                    <option value="Goa">Goa (30)</option>
                                    <option value="Himachal Pradesh">Himachal Pradesh (02)</option>
                                    <option value="Jharkhand">Jharkhand (20)</option>
                                    <option value="Kerala">Kerala (32)</option>
                                    <option value="Odisha">Odisha (21)</option>
                                    <option value="Assam">Assam (18)</option>
                                    <option value="Jammu & Kashmir">Jammu & Kashmir (01)</option>
                                    <option value="Uttarakhand">Uttarakhand (05)</option>
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
                            <svg viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            <h3>All Wholesale Orders & Consignments</h3>
                        </div>
                        <a href="shop.php" class="ws-btn ws-btn-primary ws-btn-sm">
                            + Place New Bulk Lot
                        </a>
                    </div>

                    <!-- Search & Filter Controls -->
                    <div class="ws-filter-bar">
                        <div class="ws-search-input-wrap">
                            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" id="wsOrdersSearchInput" class="ws-input ws-search-input" placeholder="Search by Order ID, Product, Courier or AWB..." oninput="filterOrdersTable()">
                        </div>

                        <div class="ws-date-pills">
                            <button class="ws-date-pill-btn active" onclick="setOrderStatusFilter('all', this)">All</button>
                            <button class="ws-date-pill-btn" onclick="setOrderStatusFilter('Shipped', this)">Shipped</button>
                            <button class="ws-date-pill-btn" onclick="setOrderStatusFilter('Delivered', this)">Delivered</button>
                            <button class="ws-date-pill-btn" onclick="setOrderStatusFilter('Processing', this)">Processing</button>
                            <button class="ws-date-pill-btn" onclick="setOrderStatusFilter('Returned', this)">Returned</button>
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

                    <!-- Pagination -->
                    <div class="ws-pagination">
                        <span id="wsPaginationInfo">Showing 1 to 6 of 6 orders</span>
                        <div class="ws-page-controls">
                            <button class="ws-page-btn" disabled>«</button>
                            <button class="ws-page-btn active">1</button>
                            <button class="ws-page-btn" disabled>»</button>
                        </div>
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
                            <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
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

                    <!-- Date Range Presets -->
                    <div class="ws-filter-bar">
                        <div class="ws-date-pills">
                            <button class="ws-date-pill-btn active" onclick="setReportDateRange('all', this)">All Time</button>
                            <button class="ws-date-pill-btn" onclick="setReportDateRange('today', this)">Today</button>
                            <button class="ws-date-pill-btn" onclick="setReportDateRange('yesterday', this)">Yesterday</button>
                            <button class="ws-date-pill-btn" onclick="setReportDateRange('this_week', this)">This Week</button>
                            <button class="ws-date-pill-btn" onclick="setReportDateRange('this_month', this)">This Month</button>
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
                            <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                            <h3>Live Heavy Logistics & Parcel Tracking</h3>
                        </div>
                        <span class="ws-status-badge shipped">⚡ BlueDart Air Express</span>
                    </div>

                    <div style="background:#FAF8F4; border:1px solid var(--ws-card-border); border-radius:10px; padding:16px; margin-bottom:16px;">
                        <div style="display:flex; justify-content:space-between; flex-wrap:wrap; gap:10px;">
                            <div>
                                <h4 style="font-family:var(--ws-font-serif); font-size:1.05rem; color:var(--ws-gold-primary);">
                                    Order #KLN-WS-8021
                                </h4>
                                <div style="font-size:0.75rem; color:var(--ws-mid-text); margin-top:2px;">
                                    Nilambari Silk Saree (Pack of 12) • AWB: <strong>884729104</strong>
                                </div>
                            </div>
                            <div style="text-align:right;">
                                <div style="font-size:0.70rem; color:var(--ws-light-text);">Estimated Delivery</div>
                                <div style="font-size:0.92rem; font-weight:800; color:#16A34A;">Tomorrow, 17 Aug 2026</div>
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
                            <div class="ws-timeline-step completed">
                                <div class="ws-timeline-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                                <div class="ws-timeline-title">Handed over to BlueDart Surface Cargo</div>
                                <div class="ws-timeline-date">Surat Airport Logistics Cargo • 15 Aug, 08:20 AM</div>
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

                        <div style="margin-top:14px; display:flex; gap:8px;">
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
                            <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            <h3>B2B Wholesaler Concierge & Ticket Desk</h3>
                        </div>
                        <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%20Kalaniketan%2C%20I%20am%20a%20registered%20Wholesaler%20and%20require%20urgent%20support" target="_blank" class="ws-btn ws-btn-wa ws-btn-sm">
                            ⚡ Instant WhatsApp Stylist
                        </a>
                    </div>

                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(clamp(260px, 45vw, 320px), 1fr)); gap:16px;">
                        
                        <!-- Open New Ticket Form -->
                        <div style="background:#FAF8F4; padding:16px; border-radius:12px; border:1px solid var(--ws-card-border);">
                            <h4 style="font-family:var(--ws-font-serif); font-size:0.90rem; color:var(--ws-gold-primary); margin-bottom:12px;">
                                ✍️ Create New Support Ticket
                            </h4>

                            <form id="wsTicketForm" onsubmit="handleCreateTicket(event)">
                                <div class="ws-form-group">
                                    <label class="ws-label" for="ticketOrderId">Related Order ID <span class="req">*</span></label>
                                    <select id="ticketOrderId" class="ws-select" required>
                                        <option value="KLN-WS-8021">KLN-WS-8021 (Nilambari Silk 12 Pcs)</option>
                                        <option value="KLN-WS-7914">KLN-WS-7914 (Banarasi Zari 8 Pcs)</option>
                                        <option value="KLN-WS-6540">KLN-WS-6540 (Kanjivaram 6 Pcs)</option>
                                        <option value="General Inquiry">General / Custom Catalog Inquiry</option>
                                    </select>
                                </div>

                                <div class="ws-form-group">
                                    <label class="ws-label" for="ticketCategory">Issue Category <span class="req">*</span></label>
                                    <select id="ticketCategory" class="ws-select" required>
                                        <option value="Delivery Delay">Logistics & Dispatch Inquiry</option>
                                        <option value="Bulk Pricing Negotiation">Bulk Lot Pricing & Discount Enquiry</option>
                                        <option value="Damaged Bale Replacement">Damaged / Defect Replacement (Exchange)</option>
                                        <option value="GST Tax Invoice Issue">GST Input Tax Credit Invoice Query</option>
                                        <option value="Custom Dyeing & Sizing">Custom Weaving & Saree Length Specification</option>
                                    </select>
                                </div>

                                <div class="ws-form-group">
                                    <label class="ws-label" for="ticketMessage">Detailed Issue Narrative <span class="req">*</span></label>
                                    <textarea id="ticketMessage" class="ws-textarea" required placeholder="Describe your inquiry, requested resolution, or order feedback in detail..."></textarea>
                                </div>

                                <button type="submit" class="ws-btn ws-btn-primary" style="width:100%;">
                                    Submit Ticket to Concierge
                                </button>
                            </form>
                        </div>

                        <!-- Ticket History List -->
                        <div>
                            <h4 style="font-family:var(--ws-font-serif); font-size:0.90rem; color:var(--ws-gold-primary); margin-bottom:12px;">
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
                            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
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
                                <span class="ws-prod-badge"><?= htmlspecialchars($prod['badge']) ?></span>
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
        <button class="ws-dock-btn" id="dockBtnTracking" onclick="switchWsTab('tracking')">
            <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
            <span>Track</span>
        </button>
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
                    <svg style="width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    <span id="modalOrderTitle">Order Details #KLN-WS-8021</span>
                </h3>
                <button class="ws-modal-close-btn" onclick="closeOrderDetailsModal()">&times;</button>
            </div>
            <div class="ws-modal-body" id="modalOrderBody">
                <!-- Injected dynamically by JS -->
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
                <div style="display:flex; gap:6px;">
                    <button class="ws-btn ws-btn-primary ws-btn-sm" onclick="printInvoiceSheet()">
                        🖨️ Print / Download PDF
                    </button>
                    <button class="ws-modal-close-btn" onclick="closeBillInvoiceModal()">&times;</button>
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
                            <strong style="color:#8A681F;">BILLED TO (BUYER):</strong>
                            <div id="invBilledTo" style="margin-top:3px; line-height:1.35;">
                                <strong>Shree Krishna Silks Pvt Ltd</strong><br>
                                GSTIN: 24AABCU9603R1ZM<br>
                                Rajesh Kumar (+91 98765 43210)<br>
                                Shop 402, Ring Road, Surat, Gujarat - 395002
                            </div>
                        </div>
                        <div>
                            <strong style="color:#8A681F;">DISPATCHED / SHIPPED TO:</strong>
                            <div id="invShippedTo" style="margin-top:3px; line-height:1.35;">
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
                        <div>Wholesale Discount / Rebate: <strong style="color:#16A34A;">-₹2,000</strong></div>
                        <div class="ws-inv-grand-total">Grand Net Payable: <span id="invGrandTotal">₹38,308</span></div>
                    </div>

                    <div style="margin-top:20px; display:flex; align-items:flex-end; justify-content:space-between; font-size:0.68rem; color:#78716C;">
                        <div>
                            <p>Terms: Payment received against Proforma / Advance NEFT.</p>
                            <p>This is a computer-generated luxury tax invoice.</p>
                        </div>
                        <div style="text-align:center;">
                            <div style="width:100px; border-bottom:1px solid #14110E; margin-bottom:4px;"></div>
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
                <h3>Wholesaler Access Authentication Gate</h3>
                <p>This portal is exclusively authorized for verified <strong>Wholesaler B2B Members</strong>. Please sign in with your registered wholesaler account to access bulk tier pricing, order tracking, and GST invoicing.</p>
                
                <div style="display:flex; flex-direction:column; gap:8px;">
                    <button class="ws-btn ws-btn-primary" onclick="loginAsDemoWholesaler()">
                        👑 Continue as Verified Wholesaler
                    </button>
                    <a href="myaccount.php?tab=login" class="ws-btn ws-btn-secondary">
                        Sign In with Other Account
                    </a>
                    <a href="shop.php" style="font-size:0.72rem; color:var(--ws-light-text); text-decoration:none; margin-top:4px;">
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

            // Update Header & Sidebar display
            var hdrName = document.getElementById('headerUserName');
            var sideName = document.getElementById('sideUserName');
            var welcomeName = document.getElementById('welcomeUserName');
            var welcomeGst = document.getElementById('welcomeGstPill');
            var sideGst = document.getElementById('sideGstBadge');
            var hdrAvatar = document.getElementById('headerUserAvatar');
            var sideAvatar = document.getElementById('sideUserAvatar');

            if (hdrName) hdrName.textContent = company || name;
            if (sideName) sideName.textContent = company || name;
            if (welcomeName) welcomeName.textContent = name;
            if (welcomeGst) welcomeGst.textContent = gstType === 'gst' ? ('🛡️ GST: ' + gstNum) : '🏢 Non-GST Business';
            if (sideGst) sideGst.textContent = gstType === 'gst' ? 'GST Verified' : 'Non-GST Trader';

            var initials = name.split(' ').map(function(n){ return n[0]; }).join('').toUpperCase() || 'WS';
            if (hdrAvatar) hdrAvatar.textContent = initials;
            if (sideAvatar) sideAvatar.textContent = initials;

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

        /* ── Live Indian GSTIN Format Validation & State Resolver ── */
        window.validateGstinInput = function(input) {
            var val = input.value.toUpperCase().replace(/[^0-9A-Z]/g, '');
            input.value = val;
            var msg = document.getElementById('gstinValidationMsg');
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

            var gstinRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
            if (val.length === 15) {
                if (gstinRegex.test(val)) {
                    if (msg) {
                        msg.innerHTML = '<span style="color:#16A34A; font-weight:800;">✅ Valid Indian GSTIN format verified!</span>';
                    }
                    input.style.borderColor = '#16A34A';
                } else {
                    if (msg) {
                        msg.innerHTML = '<span style="color:#DC2626; font-weight:800;">⚠️ Invalid GSTIN structure. Expected: 2 digits + 5 chars PAN + 4 digits + 1 char + Z + 1 check digit.</span>';
                    }
                    input.style.borderColor = '#DC2626';
                }
            } else {
                if (msg) {
                    msg.innerHTML = 'Enter 15 characters (' + val.length + '/15)';
                }
                input.style.borderColor = '#D5CEBF';
            }
        };

        /* ── Toggle Password Visibility ── */
        window.togglePassVisibility = function(inputId) {
            var input = document.getElementById(inputId);
            if (!input) return;
            input.type = input.type === 'password' ? 'text' : 'password';
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
            window.showWsToast('🎉 Profile & Security details updated successfully!');
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
                tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:30px; color:#78716C;">No matching wholesale orders found.</td></tr>';
                mobContainer.innerHTML = '<div style="text-align:center; padding:30px; color:#78716C;">No matching orders found.</div>';
                return;
            }

            orders.forEach(function(o) {
                var statusClass = o.status.toLowerCase();
                if (statusClass === 'shipped') statusClass = 'shipped';
                else if (statusClass === 'delivered') statusClass = 'delivered';
                else if (statusClass === 'processing') statusClass = 'processing';
                else if (statusClass === 'returned') statusClass = 'returned';

                // 1. Desktop Row
                var tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="ws-order-id-cell">${o.id}</td>
                    <td style="color:#78716C; font-size:0.75rem;">${o.date}</td>
                    <td>
                        <div class="ws-prod-mini-cell">
                            <img src="${o.image}" alt="${o.productName}" class="ws-prod-mini-img" onerror="this.src='images/product1.png';">
                            <div>
                                <strong style="font-size:0.78rem; color:#1C1917;">${o.productName}</strong>
                                <div style="font-size:0.68rem; color:#78716C;">SKU: ${o.sku} • ${o.courier}</div>
                            </div>
                        </div>
                    </td>
                    <td><strong>${o.qty} Pcs</strong></td>
                    <td><strong style="color:#8A681F; font-size:0.85rem;">₹${Number(o.total).toLocaleString('en-IN')}</strong></td>
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
                        <span class="ws-order-id-cell" style="font-size:0.82rem;">${o.id}</span>
                        <span class="ws-status-badge ${statusClass}">${o.status}</span>
                    </div>
                    <div class="ws-mob-order-body">
                        <img src="${o.image}" alt="${o.productName}" class="ws-mob-order-img" onerror="this.src='images/product1.png';">
                        <div class="ws-mob-order-info">
                            <h4 class="ws-mob-order-title">${o.productName}</h4>
                            <div class="ws-mob-order-meta">Date: ${o.date} • Lot: <strong>${o.qty} Pcs</strong></div>
                            <div class="ws-mob-order-meta">Logistics: ${o.courier} (AWB: ${o.awb})</div>
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
                            <span class="ws-order-id-cell">${o.id}</span>
                            <span class="ws-status-badge ${statusClass}">${o.status}</span>
                        </div>
                        <div class="ws-mob-order-body">
                            <img src="${o.image}" alt="${o.productName}" class="ws-mob-order-img" onerror="this.src='images/product1.png';">
                            <div class="ws-mob-order-info">
                                <h4 class="ws-mob-order-title">${o.productName}</h4>
                                <div class="ws-mob-order-meta">${o.date} • Lot Qty: ${o.qty} Pcs</div>
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
            document.querySelectorAll('#tabPaneOrders .ws-date-pill-btn').forEach(function(b) {
                b.classList.remove('active');
            });
            if (btn) btn.classList.add('active');
            filterOrdersTable();
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
                    <td style="font-size:0.75rem; color:#78716C;">${o.date}</td>
                    <td><span style="font-family:monospace; background:#FAF6ED; padding:2px 6px; border-radius:4px;">${o.hsn}</span></td>
                    <td><strong>${o.productName}</strong></td>
                    <td>${o.qty}</td>
                    <td>₹${Number(o.subtotal).toLocaleString('en-IN')}</td>
                    <td style="color:#16A34A;">₹${Number(o.tax).toLocaleString('en-IN')}</td>
                    <td><strong style="color:#8A681F;">₹${Number(o.total).toLocaleString('en-IN')}</strong></td>
                    <td style="font-size:0.72rem; color:#44403C;">${o.payment}</td>
                `;
                tbody.appendChild(tr);
            });
        }

        window.setReportDateRange = function(range, btn) {
            document.querySelectorAll('#tabPaneReports .ws-date-pill-btn').forEach(function(b) {
                b.classList.remove('active');
            });
            if (btn) btn.classList.add('active');
            // Mock Date Filtering
            renderReportsView(activeOrdersList);
            window.showWsToast('📊 Reports filtered by: ' + range.toUpperCase());
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
                var statusColor = t.status === 'Resolved' ? '#16A34A' : '#D97706';
                var card = document.createElement('div');
                card.className = 'ws-ticket-card';
                card.innerHTML = `
                    <div class="ws-ticket-head">
                        <span style="font-family:var(--ws-font-serif); font-size:0.75rem; font-weight:800; color:#8A681F;">Ticket #${t.id}</span>
                        <span style="font-size:0.65rem; font-weight:800; color:${statusColor}; background:#FAF8F4; padding:2px 8px; border-radius:12px; border:1px solid ${statusColor};">${t.status}</span>
                    </div>
                    <div class="ws-ticket-sub">Order Ref: ${t.orderId} • ${t.category}</div>
                    <p class="ws-ticket-msg" style="margin-top:4px;">"${t.message}"</p>
                    <div style="font-size:0.65rem; color:#78716C; margin-top:6px; display:flex; justify-content:space-between;">
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

            if (!modal || !body) return;

            title.textContent = `Order Details #${o.id}`;
            body.innerHTML = `
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; padding-bottom:10px; border-bottom:1px dashed #DDD8CD;">
                    <div>
                        <div style="font-size:0.75rem; color:#78716C;">Consignment Placed</div>
                        <strong>${o.date}</strong>
                    </div>
                    <div>
                        <div style="font-size:0.75rem; color:#78716C;">Current Status</div>
                        <span class="ws-status-badge ${o.status.toLowerCase()}">${o.status}</span>
                    </div>
                </div>

                <div style="display:flex; gap:14px; margin-bottom:14px;">
                    <img src="${o.image}" alt="${o.productName}" style="width:68px; height:85px; border-radius:6px; object-fit:cover; border:1px solid #E7E2D6;">
                    <div style="flex:1;">
                        <h4 style="font-family:var(--ws-font-serif); font-size:0.92rem; color:#1C1917; margin-bottom:3px;">${o.productName}</h4>
                        <div style="font-size:0.74rem; color:#78716C;">SKU: ${o.sku} • HSN Code: ${o.hsn}</div>
                        <div style="font-size:0.74rem; color:#78716C;">Color: ${o.color} • Size: ${o.size}</div>
                        <div style="font-size:0.80rem; font-weight:800; color:#8A681F; margin-top:4px;">
                            ${o.qty} Pcs @ ₹${Number(o.unitPrice).toLocaleString('en-IN')} / Pc
                        </div>
                    </div>
                </div>

                <div style="background:#FAF8F4; border:1px solid #EAE5DB; border-radius:8px; padding:12px; margin-bottom:14px; font-size:0.76rem;">
                    <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                        <span style="color:#78716C;">Taxable Item Total</span>
                        <strong>₹${Number(o.subtotal).toLocaleString('en-IN')}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                        <span style="color:#78716C;">CGST (2.5%) + SGST (2.5%)</span>
                        <strong style="color:#16A34A;">₹${Number(o.tax).toLocaleString('en-IN')}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                        <span style="color:#78716C;">Wholesale Volume Discount</span>
                        <strong style="color:#16A34A;">-₹${Number(o.discount).toLocaleString('en-IN')}</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; padding-top:6px; border-top:1px solid #DDD8CD; font-size:0.90rem; font-weight:900; color:#8A681F;">
                        <span>Total Paid / Payable</span>
                        <span>₹${Number(o.total).toLocaleString('en-IN')}</span>
                    </div>
                </div>

                <div style="font-size:0.74rem; color:#44403C; margin-bottom:16px;">
                    <p><strong>Logistics Partner:</strong> ${o.courier} (AWB: ${o.awb})</p>
                    <p><strong>Payment Instrument:</strong> ${o.payment}</p>
                </div>

                <div style="display:flex; gap:8px;">
                    <button class="ws-btn ws-btn-primary" style="flex:1;" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                        📄 Download GST Bill PDF
                    </button>
                    <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%2C%20I%20would%20like%20to%20repeat%20wholesale%20lot%20order%20for%20${encodeURIComponent(o.productName)}%20(${o.qty}%20Pcs)" target="_blank" class="ws-btn ws-btn-wa" style="flex:1;">
                        💬 Repeat Wholesale Lot
                    </a>
                </div>
            `;
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
                    <td><strong>${o.productName}</strong><br><span style="color:#78716C; font-size:0.68rem;">SKU: ${o.sku} • ${o.color}</span></td>
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
