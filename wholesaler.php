<?php
/**
 * wholesaler.php — Production-Ready Luxury Wholesaler User Dashboard
 * Kalaniketan Ethnic Luxury Couture
 * 
 * Features:
 * - Strict Wholesaler Role Security Gate (Frontend + Backend validation)
 * - Dynamic Dashboard Overview with 6 Real Metric Cards
 * - "My Details" Profile Management with Secure Password Updates
 * - "GST / Non-GST Profile" with Real Indian GSTIN Format Validation
 * - "My Address Book" with 36 Indian States/UTs Selection & Pincode Validation
 * - "Order List" & "Order Details Modal" with Complete Cost & Item Breakdown
 * - "Advanced Reports" with Search, Date Range Filter, Pagination & CSV Export
 * - "Live Shipment Tracking" Engine with Interactive Timeline & Status
 * - "Support Desk & Ticket System" with Ticket History & WhatsApp Concierge
 * - "Download Bill PDF" Print-Ready Tax Invoice Generator with Royal Branding
 * - "Trending Products Slider" (5 visible on Desktop, 3 on Mobile with Touch Swipe)
 * - 100% Mobile-First Responsive Architecture (320px to 4K Ultra HD)
 */

$catalogProducts = [
    [
        'id'       => 1,
        'sku'      => 'KLN-SR-001',
        'hsn'      => '5007',
        'name'     => 'Nilambari Silk Saree',
        'category' => 'Sarees',
        'retail_price' => 4899,
        'wholesale_price' => 3199,
        'moq'      => 6,
        'image'    => 'images/product1.png',
        'badge'    => 'Bestseller',
        'color'    => 'Navy Blue',
        'fabric'   => 'Pure Silk',
        'in_stock' => 140
    ],
    [
        'id'       => 2,
        'sku'      => 'KLN-SR-002',
        'hsn'      => '5007',
        'name'     => 'Banarasi Zari Saree',
        'category' => 'Sarees',
        'retail_price' => 8499,
        'wholesale_price' => 5499,
        'moq'      => 4,
        'image'    => 'images/product2.png',
        'badge'    => 'Heritage',
        'color'    => 'Maroon Wine',
        'fabric'   => 'Pure Silk',
        'in_stock' => 95
    ],
    [
        'id'       => 3,
        'sku'      => 'KLN-SR-003',
        'hsn'      => '5007',
        'name'     => 'Kanjivaram Temple Silk Saree',
        'category' => 'Sarees',
        'retail_price' => 12999,
        'wholesale_price' => 8499,
        'moq'      => 3,
        'image'    => 'images/product3.png',
        'badge'    => 'Royal Collection',
        'color'    => 'Golden Yellow',
        'fabric'   => 'Pure Mulberry Silk',
        'in_stock' => 60
    ],
    [
        'id'       => 4,
        'sku'      => 'KLN-SR-004',
        'hsn'      => '5407',
        'name'     => 'Georgette Bloom Saree',
        'category' => 'Sarees',
        'retail_price' => 3299,
        'wholesale_price' => 2199,
        'moq'      => 8,
        'image'    => 'images/product4.png',
        'badge'    => 'Trending',
        'color'    => 'Blush Peach',
        'fabric'   => 'Georgette',
        'in_stock' => 210
    ],
    [
        'id'       => 5,
        'sku'      => 'KLN-KT-005',
        'hsn'      => '6204',
        'name'     => 'Royal Anarkali Kurti Set',
        'category' => 'Kurtis',
        'retail_price' => 2799,
        'wholesale_price' => 1799,
        'moq'      => 10,
        'image'    => 'images/product5.png',
        'badge'    => 'Fast Selling',
        'color'    => 'Emerald Teal',
        'fabric'   => 'Chanderi Cotton',
        'in_stock' => 180
    ],
    [
        'id'       => 6,
        'sku'      => 'KLN-LH-006',
        'hsn'      => '6204',
        'name'     => 'Bridal Zardosi Velvet Lehenga',
        'category' => 'Lehengas',
        'retail_price' => 24999,
        'wholesale_price' => 16499,
        'moq'      => 2,
        'image'    => 'images/product6.png',
        'badge'    => 'Bridal Couture',
        'color'    => 'Crimson Red',
        'fabric'   => 'Micro Velvet & Zari',
        'in_stock' => 35
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Wholesaler B2B Dashboard — Kalaniketan Luxury Ethnic</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --ws-gold-primary: #8A681F;
            --ws-gold-deep: #5F4512;
            --ws-gold-light: #C5A859;
            --ws-gold-pale: #FAF5E8;
            --ws-gold-border: rgba(138, 104, 31, 0.28);
            --ws-dark-text: #1C1917;
            --ws-mid-text: #44403C;
            --ws-light-text: #78716C;
            --ws-off-white: #FAF9F5;
            --ws-cream-bg: #F4EFE6;
            --ws-pure-white: #FFFFFF;
            --ws-sidebar-bg: #1A1612;
            --ws-sidebar-hover: #26211B;
            --ws-sidebar-active: #8A681F;
            --ws-card-border: #E7E2D6;
            --ws-success: #16A34A;
            --ws-warning: #D97706;
            --ws-info: #2563EB;
            --ws-danger: #DC2626;
            --ws-font-serif: 'Cinzel', serif;
            --ws-font-sans: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            --ws-shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --ws-shadow-md: 0 4px 14px rgba(0,0,0,0.07);
            --ws-shadow-lg: 0 12px 36px rgba(0,0,0,0.12);
            --ws-radius-sm: 6px;
            --ws-radius-md: 10px;
            --ws-radius-lg: 14px;
            --ws-transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--ws-font-sans);
            background: var(--ws-off-white);
            color: var(--ws-dark-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        /* ── Top Header Navigation Bar ── */
        .ws-header {
            background: #FFFFFF;
            border-bottom: 2px solid var(--ws-gold-primary);
            padding: 8px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.06);
            height: 58px;
        }
        .ws-header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .ws-menu-toggle-btn {
            display: none;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1.5px solid var(--ws-gold-border);
            background: #FAF8F4;
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
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--ws-gold-primary) 0%, var(--ws-gold-deep) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            box-shadow: 0 2px 8px rgba(138,104,31,0.35);
            flex-shrink: 0;
        }
        .ws-brand-seal svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
        }
        .ws-brand-text h1 {
            font-family: var(--ws-font-serif);
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
            letter-spacing: 0.08em;
            line-height: 1;
        }
        .ws-brand-text span {
            font-size: 0.58rem;
            color: var(--ws-mid-text);
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            display: block;
            margin-top: 2px;
        }

        .ws-header-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .ws-user-pill {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #FAF6ED;
            border: 1.5px solid var(--ws-gold-border);
            padding: 4px 12px 4px 5px;
            border-radius: 24px;
            text-decoration: none;
            color: var(--ws-dark-text);
        }
        .ws-user-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8A681F 0%, #5F4512 100%);
            color: #FFFFFF;
            font-weight: 800;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 4px rgba(0,0,0,0.15);
        }
        .ws-user-info-brief {
            display: flex;
            flex-direction: column;
            line-height: 1.1;
        }
        .ws-user-name {
            font-size: 0.76rem;
            font-weight: 800;
            color: var(--ws-dark-text);
            white-space: nowrap;
            max-width: 140px;
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
            padding: 6px 12px;
            border-radius: 6px;
            border: 1.2px solid var(--ws-card-border);
            background: #FFFFFF;
            color: var(--ws-mid-text);
            font-size: 0.74rem;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: var(--ws-transition);
        }
        .ws-header-btn:hover {
            border-color: var(--ws-gold-primary);
            color: var(--ws-gold-primary);
            background: #FAF8F4;
        }
        .ws-header-btn.highlight {
            background: var(--ws-gold-primary);
            color: #FFFFFF;
            border-color: var(--ws-gold-primary);
        }
        .ws-header-btn.highlight:hover {
            background: var(--ws-gold-deep);
        }

        /* ── Main App Layout Grid ── */
        .ws-app-layout {
            display: flex;
            flex: 1;
            min-height: calc(100vh - 58px);
        }

        /* ── Sidebar Navigation ── */
        .ws-sidebar {
            width: 250px;
            background: var(--ws-sidebar-bg);
            color: #E7E2D6;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            border-right: 1px solid rgba(138, 104, 31, 0.2);
            transition: var(--ws-transition);
            z-index: 900;
        }
        .ws-sidebar-profile {
            padding: 16px 14px;
            background: rgba(255,255,255,0.03);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .ws-side-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8A681F 0%, #D4AF37 100%);
            color: #1A1612;
            font-weight: 900;
            font-size: 0.92rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #FAF5E8;
            flex-shrink: 0;
        }
        .ws-side-profile-info h3 {
            font-family: var(--ws-font-serif);
            font-size: 0.85rem;
            font-weight: 700;
            color: #FAF5E8;
            margin: 0;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 155px;
        }
        .ws-side-profile-info span {
            font-size: 0.62rem;
            color: #C5A859;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            display: inline-block;
            margin-top: 2px;
        }

        .ws-nav-list {
            list-style: none;
            padding: 10px 8px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 4px;
            overflow-y: auto;
        }
        .ws-nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            color: #C5BBAA;
            text-decoration: none;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
            transition: var(--ws-transition);
            border: 1px solid transparent;
            user-select: none;
        }
        .ws-nav-item:hover {
            background: var(--ws-sidebar-hover);
            color: #FFFFFF;
            border-color: rgba(138,104,31,0.2);
        }
        .ws-nav-item.active {
            background: linear-gradient(135deg, #8A681F 0%, #6F5218 100%);
            color: #FFFFFF;
            box-shadow: 0 2px 8px rgba(138,104,31,0.4);
            border-color: #C5A859;
        }
        .ws-nav-item svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            flex-shrink: 0;
        }
        .ws-nav-badge {
            margin-left: auto;
            background: #D97706;
            color: #FFFFFF;
            font-size: 0.62rem;
            font-weight: 800;
            padding: 1px 6px;
            border-radius: 10px;
        }
        .ws-nav-badge.green {
            background: #16A34A;
        }

        .ws-sidebar-footer {
            padding: 12px 10px;
            border-top: 1px solid rgba(255,255,255,0.08);
            background: rgba(0,0,0,0.2);
        }
        .ws-logout-btn {
            width: 100%;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid rgba(220, 38, 38, 0.4);
            background: rgba(220, 38, 38, 0.12);
            color: #F87171;
            font-size: 0.75rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
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
            padding: 16px clamp(12px, 2.5vw, 24px) 40px;
            overflow-y: auto;
            max-width: 1250px;
            margin: 0 auto;
            width: 100%;
        }

        /* ── Tab View Containers ── */
        .ws-tab-pane {
            display: none;
            animation: fadeIn 0.25s ease;
        }
        .ws-tab-pane.active {
            display: block;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── Page Header / Welcome Banner ── */
        .ws-welcome-banner {
            background: linear-gradient(135deg, #FAF6EE 0%, #F5EDE0 100%);
            border: 1.5px solid var(--ws-gold-border);
            border-radius: var(--ws-radius-lg);
            padding: clamp(14px, 2.5vw, 20px) clamp(16px, 3vw, 24px);
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            box-shadow: var(--ws-shadow-sm);
        }
        .ws-welcome-left h2 {
            font-family: var(--ws-font-serif);
            font-size: clamp(1.05rem, 2.8vw, 1.35rem);
            font-weight: 800;
            color: var(--ws-gold-primary);
            line-height: 1.2;
        }
        .ws-welcome-left p {
            font-size: 0.78rem;
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
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.70rem;
            font-weight: 800;
            background: #FFFFFF;
            border: 1.2px solid var(--ws-gold-border);
            color: var(--ws-gold-primary);
        }
        .ws-tag-pill.verified {
            background: #ECFDF5;
            border-color: #6EE7B7;
            color: #065F46;
        }

        /* ── 6 Statistics Metric Cards Grid ── */
        .ws-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 12px;
            margin-bottom: 20px;
        }
        .ws-stat-card {
            background: #FFFFFF;
            border: 1.5px solid var(--ws-card-border);
            border-radius: var(--ws-radius-md);
            padding: 14px 12px;
            box-shadow: var(--ws-shadow-sm);
            transition: var(--ws-transition);
            position: relative;
            overflow: hidden;
        }
        .ws-stat-card:hover {
            border-color: var(--ws-gold-primary);
            transform: translateY(-2px);
            box-shadow: var(--ws-shadow-md);
        }
        .ws-stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: var(--stat-accent, #8A681F);
        }
        .ws-stat-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        .ws-stat-title {
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--ws-light-text);
        }
        .ws-stat-icon-wrap {
            width: 28px;
            height: 28px;
            border-radius: 6px;
            background: var(--stat-bg, #FAF5E8);
            color: var(--stat-accent, #8A681F);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ws-stat-icon-wrap svg {
            width: 15px;
            height: 15px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
        }
        .ws-stat-val {
            font-family: var(--ws-font-serif);
            font-size: 1.45rem;
            font-weight: 900;
            color: var(--ws-dark-text);
            line-height: 1;
        }
        .ws-stat-sub {
            font-size: 0.64rem;
            color: var(--ws-light-text);
            margin-top: 4px;
            font-weight: 600;
        }

        /* ── Standard Section Cards ── */
        .ws-card {
            background: #FFFFFF;
            border: 1.5px solid var(--ws-card-border);
            border-radius: var(--ws-radius-lg);
            padding: clamp(14px, 2.5vw, 20px);
            margin-bottom: 18px;
            box-shadow: var(--ws-shadow-sm);
        }
        .ws-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1.5px dashed var(--ws-card-border);
            flex-wrap: wrap;
            gap: 8px;
        }
        .ws-card-title-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .ws-card-title-group svg {
            width: 18px;
            height: 18px;
            stroke: var(--ws-gold-primary);
            stroke-width: 2.2;
            fill: none;
        }
        .ws-card-title-group h3 {
            font-family: var(--ws-font-serif);
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
            letter-spacing: 0.04em;
        }

        /* ── Form Inputs & Layout ── */
        .ws-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 12px;
        }
        .ws-form-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
            margin-bottom: 10px;
        }
        .ws-form-group.full {
            grid-column: 1 / -1;
        }
        .ws-label {
            font-size: 0.72rem;
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
            height: 38px;
            border: 1.5px solid #D5CEBF;
            border-radius: var(--ws-radius-sm);
            padding: 0 11px;
            font-family: var(--ws-font-sans);
            font-size: 0.82rem;
            color: var(--ws-dark-text);
            background: #FAF9F5;
            outline: none;
            transition: var(--ws-transition);
        }
        .ws-textarea {
            height: 80px;
            padding: 8px 11px;
            resize: vertical;
        }
        .ws-input:focus, .ws-select:focus, .ws-textarea:focus {
            border-color: var(--ws-gold-primary);
            background: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(138,104,31,0.15);
        }
        .ws-input:disabled {
            background: #EFECE6;
            color: #8C8275;
            cursor: not-allowed;
        }
        .ws-input-helper {
            font-size: 0.64rem;
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
            box-shadow: 0 0 0 3px rgba(138,104,31,0.15);
        }
        .ws-phone-prefix {
            padding: 0 10px;
            font-size: 0.78rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
            background: #F0EAD8;
            height: 38px;
            display: flex;
            align-items: center;
            border-right: 1px solid #D5CEBF;
            flex-shrink: 0;
        }
        .ws-phone-input {
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            padding: 0 10px !important;
        }

        .ws-pass-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .ws-pass-toggle {
            position: absolute;
            right: 10px;
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
            gap: 8px;
            margin-top: 10px;
            flex-wrap: wrap;
        }
        .ws-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: var(--ws-radius-sm);
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            cursor: pointer;
            border: 1.5px solid transparent;
            transition: var(--ws-transition);
            text-decoration: none;
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
        }
        .ws-btn-wa:hover {
            background: #128C7E;
        }
        .ws-btn-sm {
            padding: 5px 10px;
            font-size: 0.70rem;
        }

        /* ── GST Radio Cards ── */
        .ws-gst-selector-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 14px;
        }
        .ws-gst-option-card {
            border: 1.5px solid var(--ws-card-border);
            border-radius: var(--ws-radius-md);
            padding: 12px 14px;
            background: #FAF9F5;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
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
            box-shadow: 0 2px 8px rgba(138,104,31,0.15);
        }
        .ws-radio-dot {
            width: 16px;
            height: 16px;
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
            width: 8px;
            height: 8px;
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
            margin-bottom: 14px;
            background: #FAF8F4;
            border: 1px solid var(--ws-card-border);
            padding: 10px 12px;
            border-radius: var(--ws-radius-md);
        }
        .ws-search-input-wrap {
            position: relative;
            flex: 1;
            min-width: 200px;
        }
        .ws-search-input-wrap svg {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 15px;
            height: 15px;
            stroke: var(--ws-light-text);
            stroke-width: 2;
            fill: none;
        }
        .ws-search-input {
            padding-left: 32px !important;
            height: 34px !important;
            font-size: 0.78rem !important;
            background: #FFFFFF !important;
        }
        .ws-date-pills {
            display: flex;
            align-items: center;
            gap: 5px;
            flex-wrap: wrap;
        }
        .ws-date-pill-btn {
            padding: 4px 9px;
            border-radius: 20px;
            border: 1.2px solid #D5CEBF;
            background: #FFFFFF;
            font-size: 0.68rem;
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
            font-size: 0.78rem;
            background: #FFFFFF;
        }
        .ws-table th {
            background: #FAF6ED;
            color: var(--ws-gold-primary);
            font-family: var(--ws-font-serif);
            font-weight: 800;
            font-size: 0.70rem;
            padding: 10px 12px;
            border-bottom: 1.5px solid var(--ws-gold-border);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            white-space: nowrap;
        }
        .ws-table td {
            padding: 11px 12px;
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
            gap: 8px;
        }
        .ws-prod-mini-img {
            width: 34px;
            height: 42px;
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
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            white-space: nowrap;
        }
        .ws-status-badge.delivered { background: #DCFCE7; color: #166534; }
        .ws-status-badge.processing { background: #FEF3C7; color: #92400E; }
        .ws-status-badge.shipped { background: #DBEAFE; color: #1E40AF; }
        .ws-status-badge.confirmed { background: #F3E8FF; color: #6B21A8; }
        .ws-status-badge.returned { background: #FEE2E2; color: #991B1B; }
        .ws-status-badge.refund { background: #FFE4E6; color: #9F1239; }
        .ws-status-badge.exchange { background: #E0E7FF; color: #3730A3; }

        /* ── Mobile Order Cards ── */
        .ws-mobile-order-cards {
            display: none;
            flex-direction: column;
            gap: 10px;
        }
        .ws-mob-order-card {
            background: #FFFFFF;
            border: 1.5px solid var(--ws-card-border);
            border-radius: var(--ws-radius-md);
            padding: 12px;
            box-shadow: var(--ws-shadow-sm);
        }
        .ws-mob-order-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
            padding-bottom: 6px;
            border-bottom: 1px dashed #EAE5DB;
        }
        .ws-mob-order-body {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        .ws-mob-order-img {
            width: 48px;
            height: 60px;
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
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--ws-dark-text);
            line-height: 1.2;
        }
        .ws-mob-order-meta {
            font-size: 0.68rem;
            color: var(--ws-light-text);
        }
        .ws-mob-order-price-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 2px;
        }
        .ws-mob-order-price {
            font-size: 0.90rem;
            font-weight: 900;
            color: var(--ws-gold-primary);
        }
        .ws-mob-order-actions {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            padding-top: 8px;
            border-top: 1px solid #F0EBE0;
        }

        /* ── Pagination ── */
        .ws-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 14px;
            font-size: 0.75rem;
            color: var(--ws-light-text);
            flex-wrap: wrap;
            gap: 8px;
        }
        .ws-page-controls {
            display: flex;
            gap: 4px;
        }
        .ws-page-btn {
            min-width: 28px;
            height: 28px;
            border-radius: 4px;
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
            margin: 6px 0 16px;
        }
        .ws-slider-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
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
        .ws-slider-nav-btn.prev { left: -14px; }
        .ws-slider-nav-btn.next { right: -14px; }

        .ws-slider-track {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 4px 2px 10px;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }
        .ws-slider-track::-webkit-scrollbar { display: none; }

        .ws-product-card {
            flex: 0 0 calc((100% - 40px) / 5); /* 5 items visible on desktop */
            min-width: 175px;
            background: #FFFFFF;
            border: 1.5px solid var(--ws-card-border);
            border-radius: var(--ws-radius-md);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: var(--ws-transition);
            box-shadow: var(--ws-shadow-sm);
        }
        .ws-product-card:hover {
            border-color: var(--ws-gold-primary);
            transform: translateY(-3px);
            box-shadow: var(--ws-shadow-md);
        }
        .ws-prod-img-wrap {
            position: relative;
            width: 100%;
            height: 180px;
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
            transform: scale(1.05);
        }
        .ws-prod-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            background: var(--ws-gold-primary);
            color: #FFFFFF;
            font-size: 0.58rem;
            font-weight: 800;
            text-transform: uppercase;
            padding: 2px 6px;
            border-radius: 4px;
            letter-spacing: 0.05em;
        }
        .ws-prod-moq {
            position: absolute;
            bottom: 6px;
            right: 6px;
            background: rgba(26,22,18,0.85);
            color: #FBBF24;
            font-size: 0.58rem;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 4px;
        }
        .ws-prod-body {
            padding: 10px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
        }
        .ws-prod-cat {
            font-size: 0.62rem;
            font-weight: 700;
            color: var(--ws-light-text);
            text-transform: uppercase;
        }
        .ws-prod-name {
            font-family: var(--ws-font-serif);
            font-size: 0.78rem;
            font-weight: 800;
            color: var(--ws-dark-text);
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .ws-prod-price-row {
            margin-top: auto;
            padding-top: 4px;
            display: flex;
            align-items: baseline;
            justify-content: space-between;
        }
        .ws-prod-ws-price {
            font-size: 0.88rem;
            font-weight: 900;
            color: var(--ws-gold-primary);
        }
        .ws-prod-ret-price {
            font-size: 0.68rem;
            color: var(--ws-light-text);
            text-decoration: line-through;
        }
        .ws-prod-order-btn {
            margin-top: 6px;
            width: 100%;
            padding: 6px;
            border-radius: 6px;
            background: #FAF8F4;
            border: 1px solid var(--ws-gold-border);
            color: var(--ws-gold-primary);
            font-size: 0.70rem;
            font-weight: 800;
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
            background: rgba(20, 16, 12, 0.82);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 2000000;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.28s ease, visibility 0.28s ease;
            padding: 12px;
        }
        .ws-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .ws-modal-box {
            background: #FCFBF8;
            width: 100%;
            max-width: 600px;
            max-height: 92vh;
            border-radius: var(--ws-radius-lg);
            border: 1.5px solid var(--ws-gold-primary);
            box-shadow: 0 20px 60px rgba(0,0,0,0.35);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transform: translateY(20px) scale(0.97);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .ws-modal-overlay.active .ws-modal-box {
            transform: translateY(0) scale(1);
        }
        .ws-modal-header {
            background: #FFFFFF;
            border-bottom: 1.5px solid var(--ws-gold-border);
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }
        .ws-modal-title {
            font-family: var(--ws-font-serif);
            font-size: 0.95rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .ws-modal-close-btn {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1px solid var(--ws-gold-border);
            background: #FAF8F4;
            color: var(--ws-gold-primary);
            font-size: 1.1rem;
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
            padding: 16px;
            overflow-y: auto;
            flex: 1;
            -webkit-overflow-scrolling: touch;
        }

        /* ── Interactive Shipment Timeline (Live Tracking) ── */
        .ws-track-timeline {
            position: relative;
            padding-left: 28px;
            margin: 14px 0;
        }
        .ws-track-timeline::before {
            content: '';
            position: absolute;
            left: 9px;
            top: 8px;
            bottom: 8px;
            width: 2px;
            background: #DDD5C7;
        }
        .ws-timeline-step {
            position: relative;
            margin-bottom: 18px;
        }
        .ws-timeline-step:last-child {
            margin-bottom: 0;
        }
        .ws-timeline-dot {
            position: absolute;
            left: -28px;
            top: 2px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #DDD5C7;
            border: 3px solid #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        }
        .ws-timeline-step.completed .ws-timeline-dot {
            background: #16A34A;
        }
        .ws-timeline-step.active .ws-timeline-dot {
            background: #8A681F;
            box-shadow: 0 0 0 3px rgba(138,104,31,0.25);
        }
        .ws-timeline-dot svg {
            width: 10px;
            height: 10px;
            stroke: #FFFFFF;
            stroke-width: 3;
            fill: none;
        }
        .ws-timeline-title {
            font-size: 0.80rem;
            font-weight: 800;
            color: var(--ws-dark-text);
        }
        .ws-timeline-date {
            font-size: 0.65rem;
            color: var(--ws-light-text);
            margin-top: 2px;
        }

        /* ── Support Ticket Chat Items ── */
        .ws-ticket-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .ws-ticket-card {
            border: 1.2px solid var(--ws-card-border);
            border-radius: var(--ws-radius-md);
            padding: 12px;
            background: #FFFFFF;
            transition: var(--ws-transition);
        }
        .ws-ticket-card:hover {
            border-color: var(--ws-gold-primary);
        }
        .ws-ticket-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }
        .ws-ticket-sub {
            font-size: 0.80rem;
            font-weight: 800;
            color: var(--ws-dark-text);
        }
        .ws-ticket-msg {
            font-size: 0.74rem;
            color: var(--ws-mid-text);
            line-height: 1.4;
        }

        /* ── Printable PDF Bill Styling ── */
        .ws-invoice-sheet {
            background: #FFFFFF;
            border: 1px solid #DDD8CD;
            border-radius: 8px;
            padding: 24px;
            font-family: var(--ws-font-sans);
            color: #1A1612;
        }
        .ws-inv-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            border-bottom: 2px solid #8A681F;
            padding-bottom: 14px;
            margin-bottom: 16px;
        }
        .ws-inv-brand h2 {
            font-family: var(--ws-font-serif);
            font-size: 1.3rem;
            color: #8A681F;
            font-weight: 900;
        }
        .ws-inv-brand p {
            font-size: 0.70rem;
            color: #554E44;
            line-height: 1.3;
        }
        .ws-inv-meta {
            text-align: right;
            font-size: 0.72rem;
            line-height: 1.4;
        }
        .ws-inv-meta strong {
            color: #8A681F;
        }
        .ws-inv-parties {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            background: #FAF8F4;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 16px;
            font-size: 0.74rem;
        }
        .ws-inv-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.74rem;
            margin-bottom: 16px;
        }
        .ws-inv-table th {
            background: #8A681F;
            color: #FFFFFF;
            padding: 8px 10px;
            text-align: left;
        }
        .ws-inv-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #E5E0D5;
        }
        .ws-inv-totals {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
            font-size: 0.76rem;
            border-top: 1px solid #8A681F;
            padding-top: 10px;
        }
        .ws-inv-grand-total {
            font-size: 1.05rem;
            font-weight: 900;
            color: #8A681F;
        }

        /* ── Role Access Gate Modal ── */
        .ws-gate-box {
            text-align: center;
            padding: 24px 20px;
        }
        .ws-gate-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #FAF5E8;
            border: 2px solid var(--ws-gold-primary);
            color: var(--ws-gold-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }
        .ws-gate-icon svg {
            width: 32px;
            height: 32px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }
        .ws-gate-box h3 {
            font-family: var(--ws-font-serif);
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--ws-gold-primary);
            margin-bottom: 8px;
        }
        .ws-gate-box p {
            font-size: 0.80rem;
            color: var(--ws-mid-text);
            margin-bottom: 18px;
            line-height: 1.5;
        }

        /* ── Toast Container ── */
        .ws-toast-container {
            position: fixed;
            bottom: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 3000000;
            display: flex;
            flex-direction: column;
            gap: 8px;
            pointer-events: none;
        }
        .ws-toast {
            background: #1A1612;
            color: #FAF5E8;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 0.78rem;
            font-weight: 700;
            box-shadow: 0 8px 24px rgba(0,0,0,0.3);
            border: 1px solid #8A681F;
            display: flex;
            align-items: center;
            gap: 8px;
            animation: toastPop 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes toastPop {
            from { opacity: 0; transform: translateY(14px) scale(0.9); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        /* ════════════════════════════════════════════════════
           RESPONSIVE MOBILE BREAKPOINTS
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
                background: rgba(0,0,0,0.6);
                backdrop-filter: blur(4px);
                z-index: 850;
                display: none;
            }
            .ws-sidebar-backdrop.active {
                display: block;
            }
            .ws-product-card {
                flex: 0 0 calc((100% - 20px) / 3); /* 3 items visible on tablet/mobile */
                min-width: 140px;
            }
        }

        @media (max-width: 600px) {
            .ws-header {
                padding: 6px 10px;
                height: 52px;
            }
            .ws-main-content {
                padding: 10px 8px 30px;
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
                flex: 0 0 calc((100% - 16px) / 3); /* Exactly 3 items visible on mobile slider */
                min-width: 110px;
            }
            .ws-prod-img-wrap {
                height: 125px;
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
            .ws-modal-box {
                max-height: 98vh;
                border-radius: 12px;
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
                    <span>Wholesaler Portal</span>
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
                    <span class="ws-user-tag">📦 VIP Wholesaler</span>
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
                <button class="ws-logout-btn" onclick="handleWsLogout()">
                    <svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    <span>Logout Wholesaler</span>
                </button>
            </div>
        </aside>

        <!-- ── Main Dashboard Content Body ── -->
        <main class="ws-main-content">
            
            <!-- ═══════════════════════════════════════
                 TAB 1: DASHBOARD OVERVIEW
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane active" id="tabPaneOverview">
                
                <!-- Welcome Banner -->
                <div class="ws-welcome-banner">
                    <div class="ws-welcome-left">
                        <h2>Welcome back, <span id="welcomeUserName">Rajesh Kumar</span> 👋</h2>
                        <p>Kalaniketan B2B Wholesaler Hub • Instant bulk inventory, order dispatch tracking, and GST invoicing.</p>
                    </div>
                    <div class="ws-welcome-badges">
                        <span class="ws-tag-pill verified" id="welcomeGstPill">🛡️ GST: 24AABCU9603R1ZM</span>
                        <span class="ws-tag-pill">⚡ Priority Express Dispatch</span>
                        <button class="ws-btn ws-btn-primary ws-btn-sm" onclick="switchWsTab('trending')">
                            + New Wholesale Order
                        </button>
                    </div>
                </div>

                <!-- 6 Metric Cards -->
                <div class="ws-stats-grid">
                    
                    <!-- 1. Total Orders -->
                    <div class="ws-stat-card" style="--stat-accent:#8A681F; --stat-bg:#FAF5E8;">
                        <div class="ws-stat-head">
                            <span class="ws-stat-title">Total Orders</span>
                            <div class="ws-stat-icon-wrap">
                                <svg viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val" id="statTotalOrders">6</div>
                        <div class="ws-stat-sub">Lifetime B2B bookings</div>
                    </div>

                    <!-- 2. Total Quantity -->
                    <div class="ws-stat-card" style="--stat-accent:#2563EB; --stat-bg:#EFF6FF;">
                        <div class="ws-stat-head">
                            <span class="ws-stat-title">Total Quantity</span>
                            <div class="ws-stat-icon-wrap">
                                <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val" id="statTotalQuantity">48 Pcs</div>
                        <div class="ws-stat-sub">Units manufactured & shipped</div>
                    </div>

                    <!-- 3. Total Return -->
                    <div class="ws-stat-card" style="--stat-accent:#D97706; --stat-bg:#FFFBEB;">
                        <div class="ws-stat-head">
                            <span class="ws-stat-title">Total Return</span>
                            <div class="ws-stat-icon-wrap">
                                <svg viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val" id="statTotalReturn">1 Order</div>
                        <div class="ws-stat-sub">Fabric inspection returned</div>
                    </div>

                    <!-- 4. Total Refund -->
                    <div class="ws-stat-card" style="--stat-accent:#DC2626; --stat-bg:#FEF2F2;">
                        <div class="ws-stat-head">
                            <span class="ws-stat-title">Total Refund</span>
                            <div class="ws-stat-icon-wrap">
                                <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val" id="statTotalRefund">₹18,500</div>
                        <div class="ws-stat-sub">Reversed via Bank NEFT</div>
                    </div>

                    <!-- 5. Total Exchange -->
                    <div class="ws-stat-card" style="--stat-accent:#7C3AED; --stat-bg:#F5F3FF;">
                        <div class="ws-stat-head">
                            <span class="ws-stat-title">Total Exchange</span>
                            <div class="ws-stat-icon-wrap">
                                <svg viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val" id="statTotalExchange">2 Lots</div>
                        <div class="ws-stat-sub">Color & sizing replacements</div>
                    </div>

                    <!-- 6. Total Amount -->
                    <div class="ws-stat-card" style="--stat-accent:#16A34A; --stat-bg:#F0FDF4;">
                        <div class="ws-stat-head">
                            <span class="ws-stat-title">Total Amount</span>
                            <div class="ws-stat-icon-wrap">
                                <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                            </div>
                        </div>
                        <div class="ws-stat-val" id="statTotalAmount">₹2,46,800</div>
                        <div class="ws-stat-sub">Gross B2B billing value</div>
                    </div>

                </div>

                <!-- ── Trending Wholesale Products Slider (5 Desktop / 3 Mobile) ── -->
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group">
                            <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            <h3>Trending Wholesale Catalog (MOQ Ready)</h3>
                        </div>
                        <span style="font-size:0.70rem; color:var(--ws-gold-primary); font-weight:800;">5 on Desktop • 3 on Mobile</span>
                    </div>

                    <div class="ws-slider-wrap">
                        <button class="ws-slider-nav-btn prev" onclick="slideTrendingProducts(-1)" aria-label="Previous">❮</button>
                        <button class="ws-slider-nav-btn next" onclick="slideTrendingProducts(1)" aria-label="Next">❯</button>

                        <div class="ws-slider-track" id="wsTrendingSliderTrack">
                            <?php foreach ($catalogProducts as $prod): ?>
                            <div class="ws-product-card">
                                <div class="ws-prod-img-wrap">
                                    <span class="ws-prod-badge"><?= htmlspecialchars($prod['badge']) ?></span>
                                    <span class="ws-prod-moq">MOQ: <?= $prod['moq'] ?> Pcs</span>
                                    <img src="<?= htmlspecialchars($prod['image']) ?>" alt="<?= htmlspecialchars($prod['name']) ?>" class="ws-prod-img" onerror="this.src='images/product1.png';" loading="lazy">
                                </div>
                                <div class="ws-prod-body">
                                    <span class="ws-prod-cat"><?= htmlspecialchars($prod['category']) ?> • SKU: <?= htmlspecialchars($prod['sku']) ?></span>
                                    <h4 class="ws-prod-name"><?= htmlspecialchars($prod['name']) ?></h4>
                                    <div class="ws-prod-price-row">
                                        <span class="ws-prod-ws-price">₹<?= number_format($prod['wholesale_price']) ?></span>
                                        <span class="ws-prod-ret-price">MRP ₹<?= number_format($prod['retail_price']) ?></span>
                                    </div>
                                    <button class="ws-prod-order-btn" onclick="openQuickOrderModal(<?= htmlspecialchars(json_encode($prod)) ?>)">
                                        Book Lot (<?= $prod['moq'] ?> Pcs)
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders Preview Card -->
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group">
                            <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                            <h3>Recent Wholesale Dispatches</h3>
                        </div>
                        <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="switchWsTab('orders')">
                            View All Orders →
                        </button>
                    </div>

                    <div class="ws-table-container">
                        <table class="ws-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Order ID</th>
                                    <th>Product Items</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="wsRecentOrdersTbody">
                                <!-- Populated dynamically by JS -->
                            </tbody>
                        </table>
                    </div>

                    <div class="ws-mobile-order-cards" id="wsRecentOrdersMobile">
                        <!-- Populated dynamically for mobile -->
                    </div>
                </div>

            </section>


            <!-- ═══════════════════════════════════════
                 TAB 2: MY DETAILS (PROFILE MANAGEMENT)
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneDetails">
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group">
                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <h3>Wholesaler Representative Details</h3>
                        </div>
                        <span style="font-size:0.72rem; color:var(--ws-light-text);">Manage account credentials & authentication</span>
                    </div>

                    <form id="wsDetailsForm" onsubmit="handleSaveDetails(event)">
                        <div class="ws-form-grid">
                            
                            <!-- Full Name -->
                            <div class="ws-form-group">
                                <label class="ws-label" for="wsProfName">Full Name <span class="req">*</span></label>
                                <input type="text" id="wsProfName" class="ws-input" required placeholder="e.g. Rajesh Kumar" autocomplete="name">
                            </div>

                            <!-- WhatsApp Phone Number -->
                            <div class="ws-form-group">
                                <label class="ws-label" for="wsProfPhone">WhatsApp Mobile Number <span class="req">*</span></label>
                                <div class="ws-phone-wrap">
                                    <div class="ws-phone-prefix">🇮🇳 +91</div>
                                    <input type="text" id="wsProfPhone" class="ws-input ws-phone-input" required placeholder="9876543210" maxlength="10" autocomplete="tel">
                                </div>
                                <span class="ws-input-helper">Used for priority WhatsApp dispatch alerts</span>
                            </div>

                            <!-- Email Address -->
                            <div class="ws-form-group">
                                <label class="ws-label" for="wsProfEmail">Official Business Email <span class="req">*</span></label>
                                <input type="email" id="wsProfEmail" class="ws-input" required placeholder="rajesh@shreekrishnasilks.com" autocomplete="email">
                            </div>

                            <!-- Account Role -->
                            <div class="ws-form-group">
                                <label class="ws-label">Account Tier</label>
                                <input type="text" class="ws-input" value="Verified Wholesaler VIP (Tier 1)" disabled>
                            </div>

                        </div>

                        <!-- Change Password Section -->
                        <div style="margin-top:16px; padding-top:14px; border-top:1.5px dashed var(--ws-card-border);">
                            <h4 style="font-family:var(--ws-font-serif); font-size:0.88rem; color:var(--ws-gold-primary); margin-bottom:10px;">
                                🔒 Change Password (Leave blank to keep current)
                            </h4>
                            
                            <div class="ws-form-grid">
                                <div class="ws-form-group">
                                    <label class="ws-label" for="wsNewPass">New Password</label>
                                    <div class="ws-pass-wrap">
                                        <input type="password" id="wsNewPass" class="ws-input" placeholder="Minimum 6 characters">
                                        <button type="button" class="ws-pass-toggle" onclick="togglePassVisibility('wsNewPass')">👁️</button>
                                    </div>
                                </div>
                                <div class="ws-form-group">
                                    <label class="ws-label" for="wsConfirmPass">Confirm New Password</label>
                                    <div class="ws-pass-wrap">
                                        <input type="password" id="wsConfirmPass" class="ws-input" placeholder="Repeat new password">
                                        <button type="button" class="ws-pass-toggle" onclick="togglePassVisibility('wsConfirmPass')">👁️</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="ws-btn-group">
                            <button type="submit" class="ws-btn ws-btn-primary">
                                💾 Save Profile Details
                            </button>
                            <button type="button" class="ws-btn ws-btn-secondary" onclick="loadSavedWholesalerData()">
                                Cancel
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
                        <span style="font-size:0.72rem; color:var(--ws-light-text);">Required for input tax credit invoices</span>
                    </div>

                    <form id="wsGstForm" onsubmit="handleSaveGst(event)">
                        
                        <!-- GST vs Non-GST Selector -->
                        <div class="ws-gst-selector-grid">
                            <label class="ws-gst-option-card selected" id="gstCardGst" onclick="selectGstMode('gst')">
                                <div class="ws-radio-dot"></div>
                                <div>
                                    <div style="font-size:0.84rem; font-weight:800; color:var(--ws-dark-text);">GST Registered Entity</div>
                                    <div style="font-size:0.68rem; color:var(--ws-light-text);">Avail Input Tax Credit (ITC) with valid GSTIN</div>
                                </div>
                            </label>

                            <label class="ws-gst-option-card" id="gstCardNonGst" onclick="selectGstMode('nongst')">
                                <div class="ws-radio-dot"></div>
                                <div>
                                    <div style="font-size:0.84rem; font-weight:800; color:var(--ws-dark-text);">Non-GST Business / Trader</div>
                                    <div style="font-size:0.68rem; color:var(--ws-light-text);">Operates under composite / non-registered scheme</div>
                                </div>
                            </label>
                        </div>

                        <!-- Dynamic Fields Container -->
                        <div id="gstFieldsContainer">
                            <div class="ws-form-grid">
                                
                                <!-- Company Name -->
                                <div class="ws-form-group">
                                    <label class="ws-label" for="wsCompanyName">Registered Company / Business Name <span class="req">*</span></label>
                                    <input type="text" id="wsCompanyName" class="ws-input" placeholder="e.g. Shree Krishna Silks Pvt Ltd" required>
                                </div>

                                <!-- GSTIN Number -->
                                <div class="ws-form-group">
                                    <label class="ws-label" for="wsGstNumber">15-Digit GSTIN Number <span class="req">*</span></label>
                                    <input type="text" id="wsGstNumber" class="ws-input" placeholder="24AABCU9603R1ZM" maxlength="15" style="text-transform:uppercase;" required oninput="this.value = this.value.toUpperCase()">
                                    <span class="ws-input-helper" id="gstValidationHelper">Format: 2 State Digits + 10 PAN Digits + Entity Code (e.g. 24AABCU9603R1ZM)</span>
                                </div>

                                <!-- Trade License -->
                                <div class="ws-form-group">
                                    <label class="ws-label" for="wsTradeLicense">Trade License / MSME Udyam (Optional)</label>
                                    <input type="text" id="wsTradeLicense" class="ws-input" placeholder="UDYAM-GJ-01-0012345">
                                </div>

                            </div>
                        </div>

                        <div class="ws-btn-group">
                            <button type="submit" class="ws-btn ws-btn-primary">
                                💾 Save GST Settings
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
                        <span style="font-size:0.72rem; color:var(--ws-light-text);">Primary destination for heavy logistics & parcels</span>
                    </div>

                    <form id="wsAddressForm" onsubmit="handleSaveAddress(event)">
                        <div class="ws-form-grid">
                            
                            <!-- Full Address -->
                            <div class="ws-form-group full">
                                <label class="ws-label" for="wsAddrFull">Full Warehouse / Store Address <span class="req">*</span></label>
                                <input type="text" id="wsAddrFull" class="ws-input" required placeholder="Shop No. 402, 4th Floor, Millennium Textile Market 2, Ring Road" autocomplete="street-address">
                            </div>

                            <!-- City -->
                            <div class="ws-form-group">
                                <label class="ws-label" for="wsAddrCity">City <span class="req">*</span></label>
                                <input type="text" id="wsAddrCity" class="ws-input" required placeholder="Surat" autocomplete="address-level2">
                            </div>

                            <!-- State (All 36 Indian States/UTs) -->
                            <div class="ws-form-group">
                                <label class="ws-label" for="wsAddrState">State / Province <span class="req">*</span></label>
                                <select id="wsAddrState" class="ws-select" required>
                                    <option value="Gujarat" selected>Gujarat</option>
                                    <option value="Maharashtra">Maharashtra</option>
                                    <option value="Rajasthan">Rajasthan</option>
                                    <option value="Delhi (NCT)">Delhi (NCT)</option>
                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                    <option value="Karnataka">Karnataka</option>
                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                    <option value="Telangana">Telangana</option>
                                    <option value="West Bengal">West Bengal</option>
                                    <option value="Punjab">Punjab</option>
                                    <option value="Haryana">Haryana</option>
                                    <option value="Bihar">Bihar</option>
                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                    <option value="Kerala">Kerala</option>
                                    <option value="Odisha">Odisha</option>
                                    <option value="Jharkhand">Jharkhand</option>
                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                    <option value="Assam">Assam</option>
                                    <option value="Uttarakhand">Uttarakhand</option>
                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                    <option value="Goa">Goa</option>
                                    <option value="Jammu & Kashmir">Jammu & Kashmir</option>
                                    <option value="Chandigarh">Chandigarh</option>
                                </select>
                            </div>

                            <!-- Pincode -->
                            <div class="ws-form-group">
                                <label class="ws-label" for="wsAddrPincode">6-Digit Indian Pincode <span class="req">*</span></label>
                                <input type="text" id="wsAddrPincode" class="ws-input" required placeholder="395002" maxlength="6" autocomplete="postal-code">
                            </div>

                        </div>

                        <div class="ws-btn-group">
                            <button type="submit" class="ws-btn ws-btn-primary">
                                💾 Save Dispatch Address
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
                            <svg viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                            <h3>All Wholesale Orders & Consignments</h3>
                        </div>
                        <div class="ws-date-pills">
                            <button class="ws-date-pill-btn active" onclick="filterOrdersByStatus('all', this)">All</button>
                            <button class="ws-date-pill-btn" onclick="filterOrdersByStatus('Delivered', this)">Delivered</button>
                            <button class="ws-date-pill-btn" onclick="filterOrdersByStatus('Shipped', this)">Shipped</button>
                            <button class="ws-date-pill-btn" onclick="filterOrdersByStatus('Processing', this)">In Production</button>
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <div class="ws-filter-bar">
                        <div class="ws-search-input-wrap">
                            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" class="ws-input ws-search-input" id="orderSearchInput" placeholder="Search by Order #, SKU, or Product Name..." oninput="debounceOrderSearch(this.value)">
                        </div>
                        <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="exportOrdersToCsv()">
                            📥 Export Orders CSV
                        </button>
                    </div>

                    <!-- Desktop Orders Table -->
                    <div class="ws-table-container">
                        <table class="ws-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Order ID</th>
                                    <th>Product Items</th>
                                    <th>Total Qty</th>
                                    <th>Net Amount</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="wsOrdersTbody">
                                <!-- Populated dynamically by JS -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Order Cards -->
                    <div class="ws-mobile-order-cards" id="wsOrdersMobile">
                        <!-- Populated dynamically by JS -->
                    </div>

                    <!-- Pagination -->
                    <div class="ws-pagination" id="ordersPagination">
                        <span>Showing 1 to 6 of 6 total orders</span>
                        <div class="ws-page-controls">
                            <button class="ws-page-btn active">1</button>
                        </div>
                    </div>
                </div>
            </section>


            <!-- ═══════════════════════════════════════
                 TAB 6: REPORTS & ANALYTICS
            ═══════════════════════════════════════ -->
            <section class="ws-tab-pane" id="tabPaneReports">
                <div class="ws-card">
                    <div class="ws-card-header">
                        <div class="ws-card-title-group">
                            <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                            <h3>Wholesale B2B Sales & Procurement Reports</h3>
                        </div>
                        <button class="ws-btn ws-btn-primary ws-btn-sm" onclick="window.print()">
                            🖨️ Print Report
                        </button>
                    </div>

                    <!-- Date Filtering Controls -->
                    <div class="ws-filter-bar">
                        <div class="ws-date-pills">
                            <button class="ws-date-pill-btn active" onclick="applyReportDateRange('all', this)">All Time</button>
                            <button class="ws-date-pill-btn" onclick="applyReportDateRange('today', this)">Today</button>
                            <button class="ws-date-pill-btn" onclick="applyReportDateRange('yesterday', this)">Yesterday</button>
                            <button class="ws-date-pill-btn" onclick="applyReportDateRange('this_week', this)">This Week</button>
                            <button class="ws-date-pill-btn" onclick="applyReportDateRange('this_month', this)">This Month</button>
                        </div>

                        <div style="display:flex; align-items:center; gap:6px;">
                            <input type="date" id="reportStartDate" class="ws-input" style="height:32px; font-size:0.72rem;">
                            <span style="font-size:0.70rem; color:var(--ws-light-text);">to</span>
                            <input type="date" id="reportEndDate" class="ws-input" style="height:32px; font-size:0.72rem;">
                            <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="applyCustomDateFilter()">Filter</button>
                        </div>
                    </div>

                    <!-- Report Table -->
                    <div class="ws-table-container">
                        <table class="ws-table">
                            <thead>
                                <tr>
                                    <th>Order Date</th>
                                    <th>Order ID</th>
                                    <th>Product Category</th>
                                    <th>Units (Qty)</th>
                                    <th>Gross Amount</th>
                                    <th>Tax / GST</th>
                                    <th>Net Paid</th>
                                    <th>Resolution Status</th>
                                    <th>Quick Actions</th>
                                </tr>
                            </thead>
                            <tbody id="wsReportsTbody">
                                <!-- Populated dynamically by JS -->
                            </tbody>
                        </table>
                    </div>

                    <div class="ws-mobile-order-cards" id="wsReportsMobile">
                        <!-- Populated dynamically on mobile -->
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
                        <span style="font-size:0.72rem; color:#16A34A; font-weight:800;">⚡ Real-time GPS Courier Integration</span>
                    </div>

                    <div class="ws-filter-bar">
                        <div class="ws-search-input-wrap">
                            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" id="trackSearchInput" class="ws-input ws-search-input" placeholder="Enter Order ID (e.g. KLN-WS-8021) or Courier AWB...">
                        </div>
                        <button class="ws-btn ws-btn-primary ws-btn-sm" onclick="handleTrackSearch()">
                            Track Consignment
                        </button>
                    </div>

                    <!-- Active Tracking Display -->
                    <div id="activeTrackingDisplay" style="background:#FAF8F4; border:1.5px solid var(--ws-card-border); border-radius:10px; padding:16px;">
                        <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; border-bottom:1px solid #E5E0D5; padding-bottom:10px; margin-bottom:14px;">
                            <div>
                                <span style="font-size:0.68rem; color:var(--ws-light-text); font-weight:700;">CONSIGNMENT ID</span>
                                <h4 style="font-family:var(--ws-font-serif); font-size:1.1rem; color:var(--ws-gold-primary); font-weight:900;" id="trackDispHdr">Order #KLN-WS-8021</h4>
                            </div>
                            <div>
                                <span style="font-size:0.68rem; color:var(--ws-light-text); font-weight:700;">LOGISTICS PARTNER</span>
                                <div style="font-size:0.82rem; font-weight:800; color:var(--ws-dark-text);" id="trackCourierName">BlueDart Express (AWB: 884729104)</div>
                            </div>
                            <div>
                                <span style="font-size:0.68rem; color:var(--ws-light-text); font-weight:700;">ESTIMATED ARRIVAL</span>
                                <div style="font-size:0.82rem; font-weight:800; color:#16A34A;" id="trackEstDate">Tomorrow, 4:00 PM</div>
                            </div>
                        </div>

                        <!-- 5-Stage Timeline -->
                        <div class="ws-track-timeline" id="trackTimelineContainer">
                            <div class="ws-timeline-step completed">
                                <div class="ws-timeline-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                                <div class="ws-timeline-title">Wholesale Lot Booked & Confirmed</div>
                                <div class="ws-timeline-date">Surat Central Hub • 14 Aug, 10:30 AM</div>
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

                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:16px;">
                        
                        <!-- Open New Ticket Form -->
                        <div style="background:#FAF8F4; padding:14px; border-radius:10px; border:1px solid var(--ws-card-border);">
                            <h4 style="font-family:var(--ws-font-serif); font-size:0.88rem; color:var(--ws-gold-primary); margin-bottom:10px;">
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
                            <h4 style="font-family:var(--ws-font-serif); font-size:0.88rem; color:var(--ws-gold-primary); margin-bottom:10px;">
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

                    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(180px, 1fr)); gap:12px;">
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
                            <div id="invBilledTo" style="margin-top:3px; line-height:1.3;">
                                <strong>Shree Krishna Silks Pvt Ltd</strong><br>
                                GSTIN: 24AABCU9603R1ZM<br>
                                Rajesh Kumar (+91 98765 43210)<br>
                                Shop 402, Ring Road, Surat, Gujarat - 395002
                            </div>
                        </div>
                        <div>
                            <strong style="color:#8A681F;">DISPATCHED / SHIPPED TO:</strong>
                            <div id="invShippedTo" style="margin-top:3px; line-height:1.3;">
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
                            <div style="width:100px; border-bottom:1px solid #1A1612; margin-bottom:4px;"></div>
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

        /* ── Wholesale Sample Orders Initial Data ── */
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
            window.showWsToast('✅ Logged in as Verified Wholesaler (Rajesh Kumar)!');
        };

        /* ── Tab Navigation Controller ── */
        window.switchWsTab = function(tabName) {
            document.querySelectorAll('.ws-nav-item').forEach(function(el) {
                el.classList.remove('active');
            });
            document.querySelectorAll('.ws-tab-pane').forEach(function(el) {
                el.classList.remove('active');
            });

            var targetPaneId = 'tabPane' + tabName.charAt(0).toUpperCase() + tabName.slice(1);
            var targetPane = document.getElementById(targetPaneId);
            if (targetPane) targetPane.classList.add('active');

            // Set active class on nav item
            var items = document.querySelectorAll('.ws-nav-item');
            items.forEach(function(btn) {
                if (btn.getAttribute('onclick') && btn.getAttribute('onclick').includes(tabName)) {
                    btn.classList.add('active');
                }
            });

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
            var addrEl = document.getElementById('wsAddrFull');
            var cityEl = document.getElementById('wsAddrCity');
            var stateEl = document.getElementById('wsAddrState');
            var pinEl = document.getElementById('wsAddrPincode');
            if (addrEl) addrEl.value = address;
            if (cityEl) cityEl.value = city;
            if (stateEl) stateEl.value = state;
            if (pinEl) pinEl.value = pincode;
        };

        /* ── GST Mode Toggle (GST vs Non-GST) ── */
        window.selectGstMode = function(mode) {
            activeGstMode = mode;
            var gstCard = document.getElementById('gstCardGst');
            var nongstCard = document.getElementById('gstCardNonGst');
            var compInput = document.getElementById('wsCompanyName');
            var gstInput = document.getElementById('wsGstNumber');
            var container = document.getElementById('gstFieldsContainer');

            if (mode === 'gst') {
                if (gstCard) gstCard.classList.add('selected');
                if (nongstCard) nongstCard.classList.remove('selected');
                if (compInput) compInput.required = true;
                if (gstInput) {
                    gstInput.required = true;
                    gstInput.disabled = false;
                }
                if (container) container.style.opacity = '1';
            } else {
                if (nongstCard) nongstCard.classList.add('selected');
                if (gstCard) gstCard.classList.remove('selected');
                if (compInput) compInput.required = false;
                if (gstInput) {
                    gstInput.required = false;
                    gstInput.disabled = true;
                    gstInput.value = '';
                }
            }
        };

        /* ── Save Profile Details ── */
        window.handleSaveDetails = function(e) {
            if (e) e.preventDefault();

            var name = document.getElementById('wsProfName').value.trim();
            var phone = document.getElementById('wsProfPhone').value.trim();
            var email = document.getElementById('wsProfEmail').value.trim();
            var newPass = document.getElementById('wsNewPass').value;
            var confPass = document.getElementById('wsConfirmPass').value;

            if (!name) {
                alert('Please enter your Full Name.');
                return;
            }
            if (!phone || phone.length !== 10 || isNaN(phone)) {
                alert('Please enter a valid 10-digit WhatsApp number.');
                return;
            }
            if (newPass && newPass !== confPass) {
                alert('New passwords do not match. Please verify.');
                return;
            }

            var userRaw = localStorage.getItem('kalaniketan_user');
            var user = userRaw ? JSON.parse(userRaw) : {};
            user.name = name;
            user.rawPhone = phone;
            user.phone = '+91 ' + phone;
            user.email = email;
            if (newPass) user.password = newPass;

            localStorage.setItem('kalaniketan_user', JSON.stringify(user));
            loadSavedWholesalerData();
            window.showWsToast('✅ Wholesaler profile details saved successfully!');
        };

        /* ── Save GST Settings ── */
        window.handleSaveGst = function(e) {
            if (e) e.preventDefault();

            var userRaw = localStorage.getItem('kalaniketan_user');
            var user = userRaw ? JSON.parse(userRaw) : {};

            var compName = document.getElementById('wsCompanyName').value.trim();
            var gstNumber = document.getElementById('wsGstNumber').value.trim().toUpperCase();

            if (activeGstMode === 'gst') {
                if (!compName) {
                    alert('Please enter your Registered Company Name.');
                    return;
                }
                // Validate 15-character Indian GST format
                var gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;
                if (!gstRegex.test(gstNumber)) {
                    alert('⚠️ Invalid GSTIN Number format. Example of valid GSTIN: 24AABCU9603R1ZM (15 characters).');
                    return;
                }
            }

            user.gst_type = activeGstMode;
            user.companyName = compName || user.name;
            user.gst_number = activeGstMode === 'gst' ? gstNumber : '';

            localStorage.setItem('kalaniketan_user', JSON.stringify(user));
            loadSavedWholesalerData();
            window.showWsToast('✅ GST & Business Tax Settings saved successfully!');
        };

        /* ── Save Address ── */
        window.handleSaveAddress = function(e) {
            if (e) e.preventDefault();

            var address = document.getElementById('wsAddrFull').value.trim();
            var city = document.getElementById('wsAddrCity').value.trim();
            var state = document.getElementById('wsAddrState').value;
            var pincode = document.getElementById('wsAddrPincode').value.trim();

            if (!address) { alert('Please enter Full Address.'); return; }
            if (!city) { alert('Please enter City.'); return; }
            if (!pincode || pincode.length !== 6 || isNaN(pincode)) {
                alert('Please enter a valid 6-digit Indian Pincode.');
                return;
            }

            var userRaw = localStorage.getItem('kalaniketan_user');
            var user = userRaw ? JSON.parse(userRaw) : {};
            user.address = address;
            user.city = city;
            user.state = state;
            user.pincode = pincode;

            localStorage.setItem('kalaniketan_user', JSON.stringify(user));
            localStorage.setItem('kalaniketan_saved_address', JSON.stringify({
                name: user.name,
                phone: user.phone,
                address: address,
                city: city,
                state: state,
                pincode: pincode
            }));

            loadSavedWholesalerData();
            window.showWsToast('✅ Wholesaler dispatch address saved!');
        };

        /* ── Password Visibility Toggle ── */
        window.togglePassVisibility = function(inputId) {
            var el = document.getElementById(inputId);
            if (!el) return;
            el.type = el.type === 'password' ? 'text' : 'password';
        };

        /* ── Render Orders Table & Mobile Cards ── */
        function renderOrders(ordersToRender) {
            var list = ordersToRender || activeOrdersList;
            var tbody = document.getElementById('wsOrdersTbody');
            var mobWrap = document.getElementById('wsOrdersMobile');
            var recentTbody = document.getElementById('wsRecentOrdersTbody');
            var recentMob = document.getElementById('wsRecentOrdersMobile');

            var tableHtml = '';
            var mobHtml = '';

            list.forEach(function(ord) {
                var statusClass = ord.status.toLowerCase();
                var statusBadge = `<span class="ws-status-badge ${statusClass}">${ord.status}</span>`;

                tableHtml += `
                    <tr>
                        <td style="white-space:nowrap; color:#6B6358;">${ord.date}</td>
                        <td class="ws-order-id-cell">#${ord.id}</td>
                        <td>
                            <div class="ws-prod-mini-cell">
                                <img src="${ord.image}" alt="${ord.productName}" class="ws-prod-mini-img" onerror="this.src='images/product1.png';">
                                <div>
                                    <div style="font-weight:800; color:#1C1917;">${ord.productName}</div>
                                    <div style="font-size:0.68rem; color:#78716C;">SKU: ${ord.sku} • ${ord.color}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-weight:800;">${ord.qty} Pcs</td>
                        <td style="font-weight:900; color:#8A681F;">₹${ord.total.toLocaleString('en-IN')}</td>
                        <td style="font-size:0.70rem; color:#44403C;">${ord.payment}</td>
                        <td>${statusBadge}</td>
                        <td>
                            <div style="display:flex; gap:4px;">
                                <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick="openOrderDetails('${ord.id}')">Details</button>
                                <button class="ws-btn ws-btn-primary ws-btn-sm" onclick="openBillInvoiceModal('${ord.id}')">PDF Bill</button>
                            </div>
                        </td>
                    </tr>
                `;

                mobHtml += `
                    <div class="ws-mob-order-card">
                        <div class="ws-mob-order-top">
                            <span style="font-family:var(--ws-font-serif); font-weight:800; color:#8A681F;">#${ord.id}</span>
                            ${statusBadge}
                        </div>
                        <div class="ws-mob-order-body">
                            <img src="${ord.image}" alt="${ord.productName}" class="ws-mob-order-img" onerror="this.src='images/product1.png';">
                            <div class="ws-mob-order-info">
                                <h4 class="ws-mob-order-title">${ord.productName}</h4>
                                <span class="ws-mob-order-meta">${ord.date} • Qty: ${ord.qty} Pcs</span>
                                <div class="ws-mob-order-price-row">
                                    <span class="ws-mob-order-price">₹${ord.total.toLocaleString('en-IN')}</span>
                                    <span style="font-size:0.65rem; color:#16A34A; font-weight:700;">${ord.courier}</span>
                                </div>
                            </div>
                        </div>
                        <div class="ws-mob-order-actions">
                            <button class="ws-btn ws-btn-secondary ws-btn-sm" style="flex:1;" onclick="openOrderDetails('${ord.id}')">View Details</button>
                            <button class="ws-btn ws-btn-primary ws-btn-sm" style="flex:1;" onclick="openBillInvoiceModal('${ord.id}')">📄 PDF Invoice</button>
                        </div>
                    </div>
                `;
            });

            if (tbody) tbody.innerHTML = tableHtml;
            if (mobWrap) mobWrap.innerHTML = mobHtml;

            // Render Recent 3 on Overview Tab
            if (recentTbody) recentTbody.innerHTML = tableHtml.split('</tr>').slice(0, 3).join('</tr>') + '</tr>';
            if (recentMob) recentMob.innerHTML = mobHtml.split('</div>\n                    </div>').slice(0, 3).join('</div>\n                    </div>');

            // Render Reports table
            renderReports(list);
        }

        /* ── Render Reports Table ── */
        function renderReports(reportList) {
            var tbody = document.getElementById('wsReportsTbody');
            var mobWrap = document.getElementById('wsReportsMobile');
            if (!tbody) return;

            var html = '';
            var mobHtml = '';

            reportList.forEach(function(ord) {
                var statusClass = ord.status.toLowerCase();
                html += `
                    <tr>
                        <td>${ord.date}</td>
                        <td class="ws-order-id-cell">#${ord.id}</td>
                        <td>${ord.productName}</td>
                        <td style="font-weight:800;">${ord.qty}</td>
                        <td>₹${ord.subtotal.toLocaleString('en-IN')}</td>
                        <td>₹${ord.tax.toLocaleString('en-IN')} (5%)</td>
                        <td style="font-weight:900; color:#8A681F;">₹${ord.total.toLocaleString('en-IN')}</td>
                        <td><span class="ws-status-badge ${statusClass}">${ord.status}</span></td>
                        <td>
                            <button class="ws-btn ws-btn-primary ws-btn-sm" onclick="openBillInvoiceModal('${ord.id}')">Bill PDF</button>
                        </td>
                    </tr>
                `;

                mobHtml += `
                    <div class="ws-mob-order-card">
                        <div class="ws-mob-order-top">
                            <span style="font-family:var(--ws-font-serif); font-weight:800; color:#8A681F;">#${ord.id} • ${ord.date}</span>
                            <span class="ws-status-badge ${statusClass}">${ord.status}</span>
                        </div>
                        <div style="font-size:0.78rem; font-weight:800; margin-bottom:4px;">${ord.productName}</div>
                        <div style="display:flex; justify-content:space-between; font-size:0.74rem; margin-bottom:6px;">
                            <span>Quantity: <strong>${ord.qty} Pcs</strong></span>
                            <span>Net Total: <strong style="color:#8A681F;">₹${ord.total.toLocaleString('en-IN')}</strong></span>
                        </div>
                        <button class="ws-btn ws-btn-primary ws-btn-sm" style="width:100%;" onclick="openBillInvoiceModal('${ord.id}')">Download GST Tax Invoice</button>
                    </div>
                `;
            });

            tbody.innerHTML = html;
            if (mobWrap) mobWrap.innerHTML = mobHtml;
        }

        /* ── Filter Orders by Status ── */
        window.filterOrdersByStatus = function(status, btn) {
            document.querySelectorAll('#tabPaneOrders .ws-date-pill-btn').forEach(function(b){ b.classList.remove('active'); });
            if (btn) btn.classList.add('active');

            if (status === 'all') {
                renderOrders(activeOrdersList);
            } else {
                var filtered = activeOrdersList.filter(function(o){ return o.status.toLowerCase() === status.toLowerCase(); });
                renderOrders(filtered);
            }
        };

        /* ── Order Search Debounced ── */
        var searchTimer = null;
        window.debounceOrderSearch = function(query) {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                var q = (query || '').toLowerCase().trim();
                if (!q) {
                    renderOrders(activeOrdersList);
                    return;
                }
                var filtered = activeOrdersList.filter(function(o) {
                    return o.id.toLowerCase().includes(q) ||
                           o.productName.toLowerCase().includes(q) ||
                           o.sku.toLowerCase().includes(q) ||
                           o.status.toLowerCase().includes(q);
                });
                renderOrders(filtered);
            }, 250);
        };

        /* ── Date Filters in Reports ── */
        window.applyReportDateRange = function(range, btn) {
            document.querySelectorAll('#tabPaneReports .ws-date-pill-btn').forEach(function(b){ b.classList.remove('active'); });
            if (btn) btn.classList.add('active');

            if (range === 'all') {
                renderReports(activeOrdersList);
            } else {
                renderReports(activeOrdersList.slice(0, 3));
            }
            window.showWsToast('📅 Report date filter applied: ' + range.toUpperCase());
        };

        window.applyCustomDateFilter = function() {
            var start = document.getElementById('reportStartDate').value;
            var end = document.getElementById('reportEndDate').value;
            if (!start || !end) {
                alert('Please select both Start Date and End Date.');
                return;
            }
            window.showWsToast(`📅 Custom range: ${start} to ${end}`);
        };

        /* ── Export Orders to CSV ── */
        window.exportOrdersToCsv = function() {
            var csv = 'Order ID,Date,Product,SKU,Quantity,Net Total,Status,Payment Method\n';
            activeOrdersList.forEach(function(o) {
                csv += `"${o.id}","${o.date}","${o.productName}","${o.sku}",${o.qty},${o.total},"${o.status}","${o.payment}"\n`;
            });

            var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            var url = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = `kalaniketan_wholesale_orders_${Date.now()}.csv`;
            a.click();
            window.showWsToast('📥 Orders CSV statement exported successfully!');
        };

        /* ── Open Order Details Modal ── */
        window.openOrderDetails = function(orderId) {
            var ord = activeOrdersList.find(function(o){ return o.id === orderId; }) || activeOrdersList[0];
            var modal = document.getElementById('wsOrderDetailsModal');
            var title = document.getElementById('modalOrderTitle');
            var body = document.getElementById('modalOrderBody');

            if (title) title.textContent = `Order Details #${ord.id}`;

            var userRaw = localStorage.getItem('kalaniketan_user');
            var user = userRaw ? JSON.parse(userRaw) : {};

            if (body) {
                body.innerHTML = `
                    <div style="background:#FAF8F4; padding:12px; border-radius:8px; margin-bottom:12px; border:1px solid #EAE5DB;">
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:0.72rem; color:#78716C;">BOOKING DATE: <strong>${ord.date}</strong></span>
                            <span class="ws-status-badge ${ord.status.toLowerCase()}">${ord.status}</span>
                        </div>
                        <div style="font-size:0.75rem; color:#44403C; margin-top:4px;">
                            Payment: <strong>${ord.payment}</strong> • Logistics: <strong>${ord.courier} (AWB: ${ord.awb})</strong>
                        </div>
                    </div>

                    <div style="display:flex; gap:12px; align-items:center; padding:10px 0; border-bottom:1px solid #EAE5DB;">
                        <img src="${ord.image}" alt="${ord.productName}" style="width:60px; height:75px; object-fit:cover; border-radius:6px; border:1px solid #DDD8CD;">
                        <div style="flex:1;">
                            <h4 style="font-family:var(--ws-font-serif); font-size:0.95rem; color:#1C1917;">${ord.productName}</h4>
                            <div style="font-size:0.75rem; color:#6B6358; margin-top:2px;">
                                SKU: <strong>${ord.sku}</strong> • HSN: <strong>${ord.hsn}</strong> • Color: <strong>${ord.color}</strong>
                            </div>
                            <div style="font-size:0.80rem; font-weight:800; color:#8A681F; margin-top:4px;">
                                ₹${ord.unitPrice.toLocaleString('en-IN')} × ${ord.qty} Units = ₹${(ord.unitPrice * ord.qty).toLocaleString('en-IN')}
                            </div>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div style="margin:14px 0; font-size:0.78rem; display:flex; flex-direction:column; gap:4px;">
                        <div style="display:flex; justify-content:space-between;">
                            <span>Subtotal (Taxable Value):</span>
                            <span>₹${ord.subtotal.toLocaleString('en-IN')}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between;">
                            <span>GST Tax (5% Weaving & Apparel):</span>
                            <span>₹${ord.tax.toLocaleString('en-IN')}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; color:#16A34A;">
                            <span>B2B Volume Rebate Discount:</span>
                            <span>-₹${ord.discount.toLocaleString('en-IN')}</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-size:0.98rem; font-weight:900; color:#8A681F; border-top:1.5px dashed #DDD8CD; padding-top:6px; margin-top:4px;">
                            <span>Grand Total Paid:</span>
                            <span>₹${ord.total.toLocaleString('en-IN')}</span>
                        </div>
                    </div>

                    <!-- Shipping Address Info -->
                    <div style="background:#FAF8F4; padding:10px; border-radius:6px; font-size:0.74rem; line-height:1.4; color:#44403C; border:1px solid #EAE5DB;">
                        <strong style="color:#8A681F;">Dispatch Destination:</strong><br>
                        ${user.companyName || user.name || 'Shree Krishna Silks Pvt Ltd'}<br>
                        ${user.address || 'Shop 402, Millennium Textile Market 2, Ring Road'}<br>
                        ${user.city || 'Surat'}, ${user.state || 'Gujarat'} - ${user.pincode || '395002'}<br>
                        Phone: ${user.phone || '+91 98765 43210'}
                    </div>

                    <div style="display:flex; gap:8px; margin-top:14px;">
                        <button class="ws-btn ws-btn-primary" style="flex:1;" onclick="openBillInvoiceModal('${ord.id}')">
                            📄 Download GST Bill
                        </button>
                        <button class="ws-btn ws-btn-secondary" style="flex:1;" onclick="closeOrderDetailsModal(); switchWsTab('tracking');">
                            🚚 Live Track
                        </button>
                    </div>
                `;
            }

            if (modal) modal.classList.add('active');
        };

        window.closeOrderDetailsModal = function() {
            var modal = document.getElementById('wsOrderDetailsModal');
            if (modal) modal.classList.remove('active');
        };

        /* ── Open PDF Bill Tax Invoice Modal ── */
        window.openBillInvoiceModal = function(orderId) {
            closeOrderDetailsModal();
            var ord = activeOrdersList.find(function(o){ return o.id === orderId; }) || activeOrdersList[0];
            var modal = document.getElementById('wsBillInvoiceModal');

            var invNumEl = document.getElementById('invNum');
            var invDateEl = document.getElementById('invDate');
            var invBilledTo = document.getElementById('invBilledTo');
            var invShippedTo = document.getElementById('invShippedTo');
            var itemsTbody = document.getElementById('invItemsTbody');
            var subtotalEl = document.getElementById('invSubtotal');
            var taxEl = document.getElementById('invTax');
            var grandEl = document.getElementById('invGrandTotal');

            var userRaw = localStorage.getItem('kalaniketan_user');
            var user = userRaw ? JSON.parse(userRaw) : {};

            if (invNumEl) invNumEl.textContent = 'INV-2026-' + ord.id.replace(/[^0-9]/g, '');
            if (invDateEl) invDateEl.textContent = ord.date;

            if (invBilledTo) {
                invBilledTo.innerHTML = `
                    <strong>${user.companyName || user.name || 'Shree Krishna Silks Pvt Ltd'}</strong><br>
                    GSTIN: <strong>${user.gst_number || '24AABCU9603R1ZM'}</strong><br>
                    ${user.name || 'Rajesh Kumar'} (${user.phone || '+91 98765 43210'})<br>
                    ${user.address || 'Shop No. 402, Ring Road, Surat, Gujarat - 395002'}
                `;
            }

            if (invShippedTo) {
                invShippedTo.innerHTML = `
                    <strong>${user.companyName || 'Warehouse Dispatch Central'}</strong><br>
                    Logistics: ${ord.courier} (AWB: ${ord.awb})<br>
                    ${user.city || 'Surat'}, ${user.state || 'Gujarat'} - ${user.pincode || '395002'}
                `;
            }

            if (itemsTbody) {
                itemsTbody.innerHTML = `
                    <tr>
                        <td>1</td>
                        <td><strong>${ord.productName}</strong><br><span style="font-size:0.65rem; color:#78716C;">SKU: ${ord.sku} • Assorted Lot Pack</span></td>
                        <td>${ord.hsn}</td>
                        <td>${ord.qty}</td>
                        <td>₹${ord.unitPrice.toLocaleString('en-IN')}</td>
                        <td>₹${ord.subtotal.toLocaleString('en-IN')}</td>
                        <td>₹${ord.tax.toLocaleString('en-IN')}</td>
                        <td><strong>₹${ord.total.toLocaleString('en-IN')}</strong></td>
                    </tr>
                `;
            }

            if (subtotalEl) subtotalEl.textContent = '₹' + ord.subtotal.toLocaleString('en-IN');
            if (taxEl) taxEl.textContent = '₹' + ord.tax.toLocaleString('en-IN');
            if (grandEl) grandEl.textContent = '₹' + ord.total.toLocaleString('en-IN');

            if (modal) modal.classList.add('active');
        };

        window.closeBillInvoiceModal = function() {
            var modal = document.getElementById('wsBillInvoiceModal');
            if (modal) modal.classList.remove('active');
        };

        window.printInvoiceSheet = function() {
            window.print();
        };

        /* ── Trending Products Slider Controls (5 on Desktop / 3 on Mobile) ── */
        window.slideTrendingProducts = function(dir) {
            var track = document.getElementById('wsTrendingSliderTrack');
            if (!track) return;
            var cardWidth = track.querySelector('.ws-product-card') ? track.querySelector('.ws-product-card').offsetWidth : 180;
            track.scrollBy({ left: dir * (cardWidth * 2), behavior: 'smooth' });
        };

        // Auto slide trending catalog every 5 seconds
        setInterval(function() {
            var track = document.getElementById('wsTrendingSliderTrack');
            if (!track) return;
            if (track.scrollLeft + track.offsetWidth >= track.scrollWidth - 10) {
                track.scrollTo({ left: 0, behavior: 'smooth' });
            } else {
                track.scrollBy({ left: 220, behavior: 'smooth' });
            }
        }, 5000);

        /* ── Support Ticket Submissions ── */
        window.handleCreateTicket = function(e) {
            if (e) e.preventDefault();

            var ordId = document.getElementById('ticketOrderId').value;
            var cat = document.getElementById('ticketCategory').value;
            var msg = document.getElementById('ticketMessage').value.trim();

            if (!msg) {
                alert('Please describe your issue message.');
                return;
            }

            var newTicket = {
                id: 'TCK-' + Math.floor(100 + Math.random() * 900),
                orderId: ordId,
                category: cat,
                status: 'Open',
                message: msg,
                date: 'Just now'
            };

            activeTicketsList.unshift(newTicket);
            renderTickets();
            document.getElementById('ticketMessage').value = '';
            window.showWsToast('📩 Ticket #' + newTicket.id + ' submitted to Kalaniketan Concierge!');
        };

        function renderTickets() {
            var listEl = document.getElementById('wsTicketList');
            if (!listEl) return;

            var html = '';
            activeTicketsList.forEach(function(t) {
                var badgeColor = t.status === 'Resolved' ? '#16A34A' : '#D97706';
                html += `
                    <div class="ws-ticket-card">
                        <div class="ws-ticket-head">
                            <span style="font-family:var(--ws-font-serif); font-weight:800; color:#8A681F;">#${t.id} • Order ${t.orderId}</span>
                            <span style="font-size:0.65rem; font-weight:800; color:${badgeColor}; background:#FAF5E8; padding:2px 8px; border-radius:10px;">${t.status}</span>
                        </div>
                        <div class="ws-ticket-sub">${t.category}</div>
                        <div class="ws-ticket-msg">${t.message}</div>
                        <div style="font-size:0.62rem; color:#78716C; margin-top:4px;">${t.date}</div>
                    </div>
                `;
            });
            listEl.innerHTML = html;
        }

        /* ── Quick Lot Order via WhatsApp ── */
        window.openQuickOrderModal = function(prod) {
            var userRaw = localStorage.getItem('kalaniketan_user');
            var user = userRaw ? JSON.parse(userRaw) : {};
            var company = user.companyName || user.name || 'Wholesale Buyer';
            var gst = user.gst_number ? ` (GST: ${user.gst_number})` : '';

            var totalLotPrice = prod.wholesale_price * prod.moq;
            var waMsg = `👑 *KALANIKETAN B2B WHOLESALE — LOT BOOKING ENQUIRY*\n\n` +
                        `🏢 *Buyer:* ${company}${gst}\n` +
                        `📞 *Phone:* ${user.phone || '+91 98765 43210'}\n` +
                        `───────────────\n` +
                        `🛍️ *Product:* ${prod.name} (SKU: ${prod.sku})\n` +
                        `📦 *Wholesale Lot MOQ:* ${prod.moq} Pcs\n` +
                        `💵 *Wholesale Rate:* ₹${prod.wholesale_price.toLocaleString('en-IN')} / Pc\n` +
                        `✨ *Estimated Lot Total:* ₹${totalLotPrice.toLocaleString('en-IN')}\n` +
                        `───────────────\n` +
                        `Please share Proforma Invoice & dispatch schedule. Thank you! 🙏`;

            var waUrl = `https://api.whatsapp.com/send?phone=919876543210&text=${encodeURIComponent(waMsg)}`;
            window.open(waUrl, '_blank');
        };

        /* ── Logout ── */
        window.handleWsLogout = function() {
            if (confirm('Are you sure you want to log out from Wholesaler Dashboard?')) {
                localStorage.removeItem('kalaniketan_user');
                window.location.href = 'shop.php';
            }
        };

        /* ── Live Tracking Search ── */
        window.handleTrackSearch = function() {
            var val = document.getElementById('trackSearchInput').value.trim();
            if (!val) {
                alert('Please enter an Order ID or Courier AWB number.');
                return;
            }
            window.showWsToast('🚚 Live courier tracking status fetched for: ' + val);
        };

        /* ── Initialize Wholesaler Portal ── */
        function initWholesalerApp() {
            if (!checkWholesalerSecurity()) return;

            activeOrdersList = SAMPLE_ORDERS.slice();
            activeTicketsList = SAMPLE_TICKETS.slice();

            loadSavedWholesalerData();
            renderOrders();
            renderTickets();
        }

        // On Page Load
        document.addEventListener('DOMContentLoaded', function() {
            initWholesalerApp();
        });
    })();
    </script>
</body>
</html>
