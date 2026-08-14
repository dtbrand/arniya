<?php
/**
 * myaccount.php — Dedicated Luxury Customer Account & Auth Page
 * Enhanced with Open Scrolling Slider Drawers for Country & State Selection
 * 100% Fluid Responsive for Desktop & Mobile
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>My Account — Kalaniketan | Ethnic Luxury</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --dark-gold: #8A681F;
            --deep-gold: #6F5218;
            --gold-pale: #FBF7EE;
            --gold-border: rgba(138, 104, 31, 0.25);
            --dark-text: #24211C;
            --mid-text: #5A5348;
            --light-text: #8E877D;
            --off-white: #FAF8F4;
            --pure-white: #FFFFFF;
            --soft-platinum: #E5E3DE;
            --font-serif: 'Cinzel', serif;
            --font-sans: 'Inter', sans-serif;
            --transition: 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-sans);
            background: var(--off-white);
            color: var(--dark-text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Top Header Navigation Bar ── */
        .account-nav-header {
            background: #FFFFFF;
            border-bottom: 1.5px solid var(--dark-gold);
            padding: clamp(10px, 2.5vw, 16px) clamp(16px, 4vw, 40px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .account-nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .brand-seal {
            width: clamp(32px, 6vw, 40px);
            height: clamp(32px, 6vw, 40px);
            border-radius: 50%;
            background: linear-gradient(135deg, var(--dark-gold) 0%, var(--deep-gold) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(138,104,31,0.3);
        }
        .brand-seal svg {
            width: clamp(16px, 3.5vw, 20px);
            height: clamp(16px, 3.5vw, 20px);
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }
        .brand-text h1 {
            font-family: var(--font-serif);
            font-size: clamp(1rem, 3.5vw, 1.35rem);
            font-weight: 700;
            color: var(--dark-gold);
            letter-spacing: 0.08em;
            line-height: 1;
        }
        .brand-text span {
            font-size: clamp(0.55rem, 1.8vw, 0.68rem);
            color: var(--mid-text);
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            display: block;
            margin-top: 2px;
        }
        .return-shop-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px clamp(10px, 2vw, 16px);
            border-radius: 20px;
            border: 1.5px solid var(--dark-gold);
            background: #FAF8F4;
            color: var(--dark-gold);
            font-size: clamp(0.72rem, 2vw, 0.82rem);
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            transition: all var(--transition);
        }
        .return-shop-btn:hover {
            background: var(--dark-gold);
            color: #FFFFFF;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(138,104,31,0.2);
        }

        /* ── Main Page Layout ── */
        .page-container {
            flex: 1;
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: clamp(14px, 3vw, 36px) clamp(12px, 3vw, 24px);
        }

        /* ════════════════════════════════════════════════════
           GUEST / AUTH VIEW (LOGIN / REGISTER / FORGOT)
        ════════════════════════════════════════════════════ */
        .auth-card-wrap {
            max-width: 560px;
            margin: clamp(10px, 4vw, 30px) auto;
            background: #FFFFFF;
            border-radius: 16px;
            border: 1.5px solid var(--dark-gold);
            box-shadow: 0 10px 36px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .auth-card-header {
            background: linear-gradient(135deg, #FAF6EE 0%, #F5EDE0 100%);
            padding: 20px 24px 16px;
            border-bottom: 1.5px solid var(--gold-border);
            text-align: center;
        }
        .auth-card-header h2 {
            font-family: var(--font-serif);
            font-size: clamp(1.15rem, 3.5vw, 1.4rem);
            font-weight: 700;
            color: var(--dark-gold);
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }
        .auth-card-header p {
            font-size: 0.76rem;
            color: var(--mid-text);
            font-weight: 500;
        }
        .auth-tabs {
            display: flex;
            background: #F0EAD8;
            border-bottom: 1px solid var(--gold-border);
        }
        .auth-tab {
            flex: 1;
            padding: 12px;
            background: transparent;
            border: none;
            border-bottom: 3px solid transparent;
            font-family: var(--font-sans);
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--mid-text);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .auth-tab.active {
            background: #FFFFFF;
            color: var(--dark-gold);
            border-bottom-color: var(--dark-gold);
        }
        .auth-body {
            padding: clamp(16px, 3.5vw, 26px);
        }
        .auth-form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 16px;
        }
        .auth-label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--dark-text);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .auth-label .req { color: #D32F2F; margin-left: 2px; }
        
        .auth-input {
            width: 100%;
            height: 42px;
            border: 1.5px solid var(--soft-platinum);
            border-radius: 8px;
            padding: 0 12px;
            font-family: var(--font-sans);
            font-size: 0.86rem;
            color: var(--dark-text);
            background: #FAF9F5;
            outline: none;
            transition: all 0.2s ease;
        }
        .auth-input:focus {
            border-color: var(--dark-gold);
            background: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(138,104,31,0.15);
        }

        /* ── Role Selection Cards (Wholesaler, Retailer, Reseller) ── */
        .role-selector-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-top: 2px;
        }
        .role-card {
            border: 1.5px solid var(--soft-platinum);
            border-radius: 10px;
            padding: 10px 6px;
            text-align: center;
            background: #FAF8F4;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            user-select: none;
        }
        .role-card:hover {
            border-color: var(--dark-gold);
            background: #FFFFFF;
        }
        .role-card.selected {
            border-color: var(--dark-gold);
            background: #FAF3E0;
            box-shadow: 0 2px 10px rgba(138,104,31,0.15);
        }
        .role-icon {
            font-size: 1.3rem;
            display: block;
            margin-bottom: 3px;
        }
        .role-title {
            font-size: clamp(0.72rem, 2vw, 0.8rem);
            font-weight: 700;
            color: var(--dark-text);
            display: block;
        }
        .role-badge {
            font-size: 0.58rem;
            color: var(--dark-gold);
            font-weight: 600;
            display: block;
            margin-top: 2px;
        }

        /* ── Luxury Slider Open Trigger Input ── */
        .slider-trigger-box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 44px;
            padding: 0 14px;
            border-radius: 8px;
            border: 1.5px solid var(--soft-platinum);
            background: #FFFFFF;
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        }
        .slider-trigger-box:hover {
            border-color: var(--dark-gold);
            background: #FAF8F4;
            box-shadow: 0 2px 8px rgba(138,104,31,0.1);
        }
        .slider-trigger-val {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.86rem;
            font-weight: 700;
            color: var(--dark-text);
        }
        .slider-trigger-action {
            font-size: 0.7rem;
            font-weight: 700;
            color: var(--dark-gold);
            display: flex;
            align-items: center;
            gap: 4px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .slider-trigger-action svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
        }

        /* ── Quick Horizontal Scrollable Preview Slider ── */
        .slider-quick-preview {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            padding: 6px 2px 2px;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
        }
        .slider-quick-preview::-webkit-scrollbar { display: none; }
        .quick-pill {
            flex-shrink: 0;
            padding: 5px 12px;
            border-radius: 20px;
            border: 1px solid var(--soft-platinum);
            background: #FFFFFF;
            color: var(--dark-text);
            font-size: 0.72rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }
        .quick-pill:hover { border-color: var(--dark-gold); color: var(--dark-gold); }
        .quick-pill.selected {
            background: var(--dark-gold);
            color: #FFFFFF;
            border-color: var(--dark-gold);
            box-shadow: 0 2px 6px rgba(138,104,31,0.25);
        }

        /* ── WhatsApp Phone Input with Auto Country Flag & Prefix ── */
        .wa-phone-group {
            display: flex;
            border: 1.5px solid var(--soft-platinum);
            border-radius: 8px;
            background: #FAF9F5;
            overflow: hidden;
            transition: all 0.2s ease;
        }
        .wa-phone-group:focus-within {
            border-color: var(--dark-gold);
            background: #FFFFFF;
            box-shadow: 0 0 0 3px rgba(138,104,31,0.15);
        }
        .wa-phone-group.is-invalid {
            border-color: #D32F2F !important;
            box-shadow: 0 0 0 3px rgba(211,47,47,0.15) !important;
        }
        .wa-flag-prefix {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 0 10px;
            background: #F0EAD8;
            border-right: 1px solid var(--soft-platinum);
            font-size: 0.82rem;
            font-weight: 700;
            color: var(--dark-gold);
            flex-shrink: 0;
            user-select: none;
            cursor: pointer;
        }
        .wa-flag-emoji {
            font-size: 1.1rem;
        }
        .wa-input-field {
            flex: 1;
            height: 42px;
            border: none;
            outline: none;
            background: transparent;
            padding: 0 12px;
            font-family: var(--font-sans);
            font-size: 0.88rem;
            color: var(--dark-text);
            width: 100%;
        }
        .validation-error-msg {
            font-size: 0.68rem;
            color: #D32F2F;
            font-weight: 600;
            display: none;
            margin-top: 3px;
        }

        .auth-btn-submit {
            width: 100%;
            padding: 13px;
            border-radius: 8px;
            border: none;
            background: linear-gradient(135deg, var(--dark-gold) 0%, var(--deep-gold) 100%);
            color: #FFFFFF;
            font-family: var(--font-sans);
            font-size: 0.86rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(138,104,31,0.25);
            margin-top: 8px;
        }
        .auth-btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(138,104,31,0.38);
        }
        .auth-link {
            color: var(--dark-gold);
            font-size: 0.74rem;
            font-weight: 700;
            text-decoration: underline;
            background: none;
            border: none;
            cursor: pointer;
        }

        /* ════════════════════════════════════════════════════
           MODAL / BOTTOM SHEET SCROLLING SLIDER PICKER
        ════════════════════════════════════════════════════ */
        .picker-slider-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(20, 16, 12, 0.8);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 1000000;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @media (min-width: 768px) {
            .picker-slider-backdrop {
                align-items: center;
                padding: 20px;
            }
        }
        .picker-slider-backdrop.active {
            opacity: 1;
            visibility: visible;
        }

        .picker-slider-card {
            background: #FFFFFF;
            width: 100%;
            max-width: 600px;
            border-radius: 20px 20px 0 0;
            border: 2px solid var(--dark-gold);
            box-shadow: 0 -10px 40px rgba(0,0,0,0.25);
            display: flex;
            flex-direction: column;
            max-height: 82vh;
            transform: translateY(100%);
            transition: transform 0.32s cubic-bezier(0.34, 1.56, 0.64, 1);
            overflow: hidden;
        }
        @media (min-width: 768px) {
            .picker-slider-card {
                border-radius: 16px;
                transform: scale(0.95) translateY(20px);
                max-height: 580px;
            }
        }
        .picker-slider-backdrop.active .picker-slider-card {
            transform: translateY(0) scale(1);
        }

        .picker-slider-header {
            padding: 14px 18px;
            border-bottom: 1.5px solid var(--gold-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, #FAF6EE 0%, #F5EDE0 100%);
        }
        .picker-slider-title {
            font-family: var(--font-serif);
            font-size: 1rem;
            font-weight: 700;
            color: var(--dark-gold);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .picker-close-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid var(--gold-border);
            background: #FFFFFF;
            color: var(--dark-gold);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        .picker-close-btn:hover {
            background: var(--dark-gold);
            color: #FFFFFF;
        }

        .picker-search-bar {
            padding: 10px 18px;
            border-bottom: 1px solid var(--soft-platinum);
            background: #FAF8F4;
        }
        .picker-search-input {
            width: 100%;
            height: 38px;
            border: 1.5px solid var(--soft-platinum);
            border-radius: 20px;
            padding: 0 14px;
            font-family: var(--font-sans);
            font-size: 0.82rem;
            outline: none;
            background: #FFFFFF;
        }
        .picker-search-input:focus {
            border-color: var(--dark-gold);
            box-shadow: 0 0 0 2px rgba(138,104,31,0.15);
        }

        /* Scrolling Grid / Cards */
        .picker-slider-body {
            padding: 14px 18px 24px;
            overflow-y: auto;
            flex: 1;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 10px;
        }
        .picker-card-item {
            border: 1.5px solid var(--soft-platinum);
            border-radius: 10px;
            padding: 12px 10px;
            background: #FAF8F4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .picker-card-item:hover {
            border-color: var(--dark-gold);
            background: #FFFFFF;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(138,104,31,0.12);
        }
        .picker-card-item.selected {
            border-color: var(--dark-gold);
            background: #FAF3E0;
            box-shadow: 0 0 0 2px rgba(138,104,31,0.3);
        }
        .picker-card-flag {
            font-size: 1.8rem;
            line-height: 1;
        }
        .picker-card-name {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--dark-text);
        }
        .picker-card-dial {
            font-size: 0.68rem;
            font-weight: 600;
            color: var(--dark-gold);
        }

        /* ════════════════════════════════════════════════════
           LOGGED IN MEMBER DASHBOARD VIEW
        ════════════════════════════════════════════════════ */
        .dashboard-wrap {
            display: none;
            flex-direction: column;
            gap: 24px;
        }
        .dashboard-wrap.active {
            display: flex;
        }

        /* VIP Profile Hero Banner */
        .profile-hero {
            background: linear-gradient(135deg, #24211C 0%, #383127 100%);
            border: 2px solid var(--dark-gold);
            border-radius: 16px;
            padding: clamp(16px, 4vw, 28px);
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.18);
            position: relative;
            overflow: hidden;
        }
        .profile-hero::after {
            content: '👑';
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: clamp(3rem, 10vw, 6rem);
            opacity: 0.08;
            pointer-events: none;
        }
        .profile-main-group {
            display: flex;
            align-items: center;
            gap: clamp(12px, 3vw, 20px);
        }
        .profile-avatar-circle {
            width: clamp(52px, 10vw, 68px);
            height: clamp(52px, 10vw, 68px);
            border-radius: 50%;
            background: linear-gradient(135deg, var(--dark-gold) 0%, #C5A859 100%);
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-serif);
            font-size: clamp(1.4rem, 4vw, 1.8rem);
            font-weight: 700;
            box-shadow: 0 4px 16px rgba(138,104,31,0.4);
            border: 2px solid #FFFFFF;
            flex-shrink: 0;
        }
        .profile-details h2 {
            font-family: var(--font-serif);
            font-size: clamp(1.1rem, 3.5vw, 1.5rem);
            font-weight: 700;
            color: #FAF5E8;
            margin-bottom: 3px;
        }
        .profile-phone {
            font-size: clamp(0.74rem, 2vw, 0.85rem);
            color: #C5BBAA;
            font-weight: 500;
        }
        .profile-location {
            font-size: clamp(0.7rem, 1.8vw, 0.78rem);
            color: #E2C988;
            margin-top: 2px;
        }
        .vip-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 12px;
            background: rgba(138,104,31,0.3);
            border: 1px solid var(--dark-gold);
            color: #E2C988;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-top: 6px;
        }

        .logout-btn {
            padding: 8px 18px;
            border-radius: 20px;
            border: 1.5px solid rgba(255,255,255,0.3);
            background: rgba(255,255,255,0.08);
            color: #FFFFFF;
            font-size: 0.75rem;
            font-weight: 700;
            cursor: pointer;
            transition: all var(--transition);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            flex-shrink: 0;
        }
        .logout-btn:hover {
            background: #D32F2F;
            border-color: #D32F2F;
            transform: scale(1.04);
        }

        /* ── Dashboard Content Grid ── */
        .dash-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }
        @media (min-width: 850px) {
            .dash-grid {
                grid-template-columns: 2fr 1fr;
            }
        }

        /* Section Cards */
        .dash-card {
            background: #FFFFFF;
            border: 1.5px solid var(--gold-border);
            border-radius: 14px;
            padding: clamp(14px, 3vw, 22px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
        }
        .dash-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 12px;
            margin-bottom: 16px;
            border-bottom: 1px dashed var(--gold-border);
        }
        .dash-card-title {
            font-family: var(--font-serif);
            font-size: clamp(0.92rem, 2.5vw, 1.1rem);
            font-weight: 700;
            color: var(--dark-gold);
            letter-spacing: 0.05em;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dash-card-title svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        /* Order Cards */
        .order-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .order-box {
            background: var(--off-white);
            border: 1.5px solid var(--soft-platinum);
            border-radius: 10px;
            padding: 14px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            transition: all 0.2s ease;
        }
        .order-box:hover {
            border-color: var(--dark-gold);
            box-shadow: 0 4px 12px rgba(138,104,31,0.08);
        }
        .order-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .order-id {
            font-family: var(--font-serif);
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--dark-text);
        }
        .order-status-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .status-processing { background: #FFF3E0; color: #E65100; border: 1px solid #FFE082; }
        .status-delivered { background: #E8F5E9; color: #2E7D32; border: 1px solid #A5D6A7; }
        
        .order-item-detail {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.8rem;
            color: var(--mid-text);
        }
        .order-thumb {
            width: 44px;
            height: 58px;
            aspect-ratio: 3 / 4;
            border-radius: 6px;
            object-fit: cover;
            object-position: top center;
            border: 1px solid var(--soft-platinum);
        }
        .order-actions-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 8px;
            border-top: 1px solid var(--soft-platinum);
            font-size: 0.78rem;
        }
        .order-total-txt {
            font-weight: 700;
            color: var(--dark-gold);
        }
        .track-wa-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: #25D366;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.75rem;
        }
        .track-wa-btn:hover {
            text-decoration: underline;
        }

        /* Quick Stat Cards */
        .stat-tiles {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 20px;
        }
        .stat-tile {
            background: #FFFFFF;
            border: 1.5px solid var(--gold-border);
            border-radius: 10px;
            padding: 14px 12px;
            text-align: center;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s ease;
        }
        .stat-tile:hover {
            border-color: var(--dark-gold);
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(138,104,31,0.12);
        }
        .stat-tile-num {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--dark-gold);
            font-family: var(--font-serif);
        }
        .stat-tile-lbl {
            font-size: 0.68rem;
            font-weight: 700;
            color: var(--mid-text);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-top: 2px;
        }

        /* Concierge Box */
        .concierge-card {
            background: linear-gradient(135deg, #FAF6EE 0%, #F5EDE0 100%);
            border: 1.5px solid var(--gold-border);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
        }
        .concierge-card h4 {
            font-family: var(--font-serif);
            font-size: 0.95rem;
            color: var(--dark-gold);
            margin-bottom: 6px;
        }
        .concierge-card p {
            font-size: 0.75rem;
            color: var(--mid-text);
            margin-bottom: 12px;
            line-height: 1.4;
        }
        .concierge-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            background: #25D366;
            color: #FFFFFF;
            font-weight: 700;
            font-size: 0.8rem;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            box-shadow: 0 4px 12px rgba(37,211,102,0.3);
        }
        .concierge-btn:hover {
            background: #128C7E;
        }
    </style>
</head>
<body>

    <!-- ═══ Navigation Header ═══ -->
    <header class="account-nav-header">
        <a href="shop.php" class="account-nav-brand">
            <div class="brand-seal">
                <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <div class="brand-text">
                <h1>Kalaniketan</h1>
                <span>Ethnic Luxury</span>
            </div>
        </a>

        <a href="shop.php" class="return-shop-btn">
            <svg style="width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>Back to Shop</span>
        </a>
    </header>

    <!-- ═══ Page Content ═══ -->
    <main class="page-container">

        <!-- ════════ VIEW 1: AUTHENTICATION (FOR GUEST USERS) ════════ -->
        <div class="auth-card-wrap" id="authCardWrap">
            <div class="auth-card-header">
                <h2 id="authHeading">VIP Member Sign In</h2>
                <p id="authSubheading">Access your personalized luxury ethnic experience</p>
            </div>

            <!-- Tabs -->
            <div class="auth-tabs">
                <button class="auth-tab active" id="tabBtnLogin" onclick="switchAuthTab('login')">Login</button>
                <button class="auth-tab" id="tabBtnRegister" onclick="switchAuthTab('register')">Register</button>
                <button class="auth-tab" id="tabBtnForgot" onclick="switchAuthTab('forgot')">Forgot Password</button>
            </div>

            <!-- Forms -->
            <div class="auth-body">
                
                <!-- 1. LOGIN FORM -->
                <form id="loginForm" onsubmit="event.preventDefault(); handleLoginSubmit();">
                    <div class="auth-form-group">
                        <label class="auth-label" for="loginPhone">WhatsApp Number or Email <span class="req">*</span></label>
                        <input type="text" id="loginPhone" class="auth-input" placeholder="e.g. 9876543210 or radhika@example.com" required>
                    </div>
                    <div class="auth-form-group">
                        <label class="auth-label" for="loginPass">
                            <span>Password <span class="req">*</span></span>
                            <button type="button" class="auth-link" onclick="switchAuthTab('forgot')">Forgot?</button>
                        </label>
                        <input type="password" id="loginPass" class="auth-input" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="auth-btn-submit">Sign In to My Account</button>
                </form>

                <!-- 2. REGISTER FORM -->
                <form id="registerForm" style="display:none;" onsubmit="event.preventDefault(); handleRegisterSubmit();">
                    
                    <!-- Full Name -->
                    <div class="auth-form-group">
                        <label class="auth-label" for="regName">Full Name <span class="req">*</span></label>
                        <input type="text" id="regName" class="auth-input" placeholder="e.g. Radhika Sharma" required>
                    </div>

                    <!-- Role Option (Retailer, Wholesaler, Reseller) -->
                    <div class="auth-form-group">
                        <label class="auth-label">Account Role / Purpose <span class="req">*</span></label>
                        <div class="role-selector-grid">
                            <div class="role-card selected" data-role="Retailer" onclick="selectRole('Retailer')">
                                <span class="role-icon">🛍️</span>
                                <span class="role-title">Retailer</span>
                                <span class="role-badge">Personal Buyer</span>
                            </div>
                            <div class="role-card" data-role="Wholesaler" onclick="selectRole('Wholesaler')">
                                <span class="role-icon">📦</span>
                                <span class="role-title">Wholesaler</span>
                                <span class="role-badge">Bulk Orders</span>
                            </div>
                            <div class="role-card" data-role="Reseller" onclick="selectRole('Reseller')">
                                <span class="role-icon">💼</span>
                                <span class="role-title">Reseller</span>
                                <span class="role-badge">Boutique Seller</span>
                            </div>
                        </div>
                    </div>

                    <!-- Country Option (Tap to Open Scrolling Slider Styles) -->
                    <div class="auth-form-group">
                        <label class="auth-label">Country <span class="req">*</span></label>
                        <div class="slider-trigger-box" onclick="openPickerSlider('country')">
                            <div class="slider-trigger-val" id="triggerCountryDisplay">
                                <span style="font-size:1.2rem;" id="triggerCountryFlag">🇮🇳</span>
                                <span id="triggerCountryName">India (+91)</span>
                            </div>
                            <div class="slider-trigger-action">
                                <span>Browse Slider</span>
                                <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </div>
                        </div>
                        <div class="slider-quick-preview" id="countryQuickPreview">
                            <!-- Quick selection pills -->
                        </div>
                    </div>

                    <!-- States Option (Tap to Open Scrolling Slider Styles) -->
                    <div class="auth-form-group">
                        <label class="auth-label">State / Province <span class="req">*</span></label>
                        <div class="slider-trigger-box" onclick="openPickerSlider('state')">
                            <div class="slider-trigger-val" id="triggerStateDisplay">
                                <span>📍</span>
                                <span id="triggerStateName">Maharashtra</span>
                            </div>
                            <div class="slider-trigger-action">
                                <span>Browse Slider</span>
                                <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </div>
                        </div>
                        <div class="slider-quick-preview" id="stateQuickPreview">
                            <!-- Quick selection pills -->
                        </div>
                    </div>

                    <!-- City Input / Suggestion -->
                    <div class="auth-form-group">
                        <label class="auth-label" for="regCity">City <span class="req">*</span></label>
                        <input type="text" id="regCity" class="auth-input" placeholder="e.g. Mumbai, Surat, Ahmedabad..." required value="Mumbai">
                    </div>

                    <!-- WhatsApp Number with Auto Flag & Country Code + Digit Validation -->
                    <div class="auth-form-group">
                        <label class="auth-label" for="regPhone">
                            <span>WhatsApp Number <span class="req">*</span></span>
                            <span id="digitCountHint" style="font-size:0.65rem; color:var(--light-text);">10 digits required</span>
                        </label>
                        <div class="wa-phone-group" id="waPhoneGroup">
                            <div class="wa-flag-prefix" onclick="openPickerSlider('country')">
                                <span class="wa-flag-emoji" id="waFlagEmoji">🇮🇳</span>
                                <span id="waDialCode">+91</span>
                            </div>
                            <input
                                type="tel"
                                id="regPhone"
                                class="wa-input-field"
                                placeholder="9876543210"
                                maxlength="12"
                                required
                                autocomplete="tel"
                                oninput="validateWhatsAppDigits()"
                            />
                        </div>
                        <div class="validation-error-msg" id="phoneErrorMsg">
                            ⚠️ Please enter a valid 10-digit WhatsApp number.
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="auth-form-group">
                        <label class="auth-label" for="regEmail">Email Address (Optional for e-Invoice)</label>
                        <input type="email" id="regEmail" class="auth-input" placeholder="radhika@example.com">
                    </div>

                    <!-- Password -->
                    <div class="auth-form-group">
                        <label class="auth-label" for="regPass">Create Password <span class="req">*</span></label>
                        <input type="password" id="regPass" class="auth-input" placeholder="Minimum 6 characters" required>
                    </div>

                    <button type="submit" class="auth-btn-submit" id="regSubmitBtn">Create Luxury Account</button>
                </form>

                <!-- 3. FORGOT PASSWORD FORM -->
                <form id="forgotForm" style="display:none;" onsubmit="event.preventDefault(); handleForgotSubmit();">
                    <p style="font-size:0.78rem; color:var(--mid-text); margin-bottom:14px; line-height:1.4;">
                        Enter your registered WhatsApp Number or Email and we'll instantly send you a password reset link on WhatsApp.
                    </p>
                    <div class="auth-form-group">
                        <label class="auth-label" for="forgotInput">WhatsApp Number / Email</label>
                        <input type="text" id="forgotInput" class="auth-input" placeholder="e.g. 9876543210" required>
                    </div>
                    <button type="submit" class="auth-btn-submit">Send Reset Link via WhatsApp</button>
                </form>

            </div>
        </div>

        <!-- ════════ VIEW 2: LOGGED IN MEMBER DASHBOARD ════════ -->
        <div class="dashboard-wrap" id="dashboardWrap">
            
            <!-- Hero Profile Banner -->
            <div class="profile-hero">
                <div class="profile-main-group">
                    <div class="profile-avatar-circle" id="dashUserInitials">RS</div>
                    <div class="profile-details">
                        <h2 id="dashUserName">Radhika Sharma</h2>
                        <div class="profile-phone" id="dashUserPhone">+91 98765 43210</div>
                        <div class="profile-location" id="dashUserLocation">📍 Mumbai, Maharashtra, India</div>
                        <div class="vip-badge" id="dashUserRoleBadge">👑 Royal Retailer VIP Member</div>
                    </div>
                </div>

                <button class="logout-btn" onclick="handleLogoutClick()">
                    Logout
                </button>
            </div>

            <!-- Dashboard Grid -->
            <div class="dash-grid">
                
                <!-- Left: Orders History & Details -->
                <div class="dash-card">
                    <div class="dash-card-header">
                        <h3 class="dash-card-title">
                            <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                            <span>Recent Orders</span>
                        </h3>
                        <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%20Kalaniketan%2C%20I%20would%20like%20to%20inquire%20about%20my%20recent%20orders" target="_blank" class="track-wa-btn">
                            WhatsApp Support
                        </a>
                    </div>

                    <div class="order-list">
                        <!-- Order 1 -->
                        <div class="order-box">
                            <div class="order-top">
                                <span class="order-id">Order #KLN-847291</span>
                                <span class="order-status-badge status-processing">Processing & Stitching</span>
                            </div>
                            <div class="order-item-detail">
                                <img src="images/product3.png" alt="Lehenga" class="order-thumb" onerror="this.src='images/product1.png';">
                                <div>
                                    <div style="font-weight:700; color:var(--dark-text);">Bridal Zardozi Velvet Lehenga</div>
                                    <div style="font-size:0.72rem; color:var(--light-text); margin-top:2px;">Size: M • Colour: Maroon • Qty: 1</div>
                                </div>
                            </div>
                            <div class="order-actions-bar">
                                <div>Total: <span class="order-total-txt">₹24,999</span></div>
                                <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%2C%20please%20share%20tracking%20status%20for%20Order%20%23KLN-847291" target="_blank" class="track-wa-btn">
                                    Track on WhatsApp →
                                </a>
                            </div>
                        </div>

                        <!-- Order 2 -->
                        <div class="order-box">
                            <div class="order-top">
                                <span class="order-id">Order #KLN-312984</span>
                                <span class="order-status-badge status-delivered">Delivered</span>
                            </div>
                            <div class="order-item-detail">
                                <img src="images/product1.png" alt="Saree" class="order-thumb">
                                <div>
                                    <div style="font-weight:700; color:var(--dark-text);">Royal Banarasi Kanjeevaram Saree</div>
                                    <div style="font-size:0.72rem; color:var(--light-text); margin-top:2px;">Free Size • Colour: Royal Gold • Qty: 1</div>
                                </div>
                            </div>
                            <div class="order-actions-bar">
                                <div>Total: <span class="order-total-txt">₹12,499</span></div>
                                <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%2C%20I%20received%20Order%20%23KLN-312984%20and%20loved%20it!" target="_blank" class="track-wa-btn">
                                    Re-Order on WhatsApp →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Quick Stat Tiles & Concierge -->
                <div style="display:flex; flex-direction:column; gap:16px;">
                    
                    <div class="stat-tiles">
                        <a href="shop.php" class="stat-tile">
                            <div class="stat-tile-num" id="dashCartCount">0</div>
                            <div class="stat-tile-lbl">Bag Items</div>
                        </a>
                        <a href="shop.php" class="stat-tile">
                            <div class="stat-tile-num" id="dashWishCount">0</div>
                            <div class="stat-tile-lbl">Saved Items</div>
                        </a>
                    </div>

                    <!-- Concierge Card -->
                    <div class="concierge-card">
                        <h4>Royal Concierge Desk</h4>
                        <p>Need custom blouse stitching, bulk wholesale pricing, or reseller catalog? Our fashion stylists are available.</p>
                        <a href="https://api.whatsapp.com/send?phone=919876543210&text=Hi%20Kalaniketan%2C%20I%20would%20like%20personalized%20styling%20and%20catalog%20support" target="_blank" class="concierge-btn">
                            <svg style="width:16px;height:16px;fill:currentColor" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"/></svg>
                            <span>WhatsApp Stylist</span>
                        </a>
                    </div>

                    <a href="shop.php" class="auth-btn-submit" style="text-align:center; text-decoration:none; display:block;">
                        Browse Luxury Catalog
                    </a>

                </div>

            </div>

        </div>

    </main>

    <!-- ════════ OPEN SCROLLING SLIDER DRAWER (MODAL PICKER) ════════ -->
    <div class="picker-slider-backdrop" id="pickerSliderBackdrop" onclick="if(event.target===this)closePickerSlider()">
        <div class="picker-slider-card">
            
            <div class="picker-slider-header">
                <h3 class="picker-slider-title" id="pickerTitle">Select Country</h3>
                <button class="picker-close-btn" onclick="closePickerSlider()">✕</button>
            </div>

            <div class="picker-search-bar">
                <input type="text" id="pickerSearchInput" class="picker-search-input" placeholder="Search country or state..." oninput="filterPickerItems()">
            </div>

            <div class="picker-slider-body" id="pickerSliderBody">
                <!-- Cards populated by JS -->
            </div>

        </div>
    </div>

    <!-- ════════ JAVASCRIPT CONTROLLER ════════ -->
    <script>
    (function() {
        'use strict';

        /* ── Complete Country & State Data with Flags ── */
        var COUNTRIES_DATA = [
            {
                code: 'IN',
                name: 'India',
                flag: '🇮🇳',
                dial: '+91',
                digits: 10,
                states: [
                    'Maharashtra', 'Gujarat', 'Rajasthan', 'Delhi (NCT)', 'Karnataka', 
                    'Tamil Nadu', 'Uttar Pradesh', 'West Bengal', 'Telangana', 'Kerala', 
                    'Punjab', 'Andhra Pradesh', 'Madhya Pradesh', 'Bihar', 'Haryana', 
                    'Odisha', 'Assam', 'Goa', 'Jammu & Kashmir', 'Uttarakhand', 
                    'Jharkhand', 'Chhattisgarh', 'Himachal Pradesh', 'Chandigarh', 'Tripura', 'Puducherry'
                ]
            },
            {
                code: 'AE',
                name: 'United Arab Emirates',
                flag: '🇦🇪',
                dial: '+971',
                digits: 9,
                states: ['Dubai', 'Abu Dhabi', 'Sharjah', 'Ajman', 'Ras Al Khaimah', 'Fujairah', 'Umm Al Quwain']
            },
            {
                code: 'US',
                name: 'United States',
                flag: '🇺🇸',
                dial: '+1',
                digits: 10,
                states: ['California', 'Texas', 'New York', 'Florida', 'Illinois', 'New Jersey', 'Georgia', 'Washington', 'Ohio', 'Pennsylvania']
            },
            {
                code: 'GB',
                name: 'United Kingdom',
                flag: '🇬🇧',
                dial: '+44',
                digits: 10,
                states: ['Greater London', 'England', 'Scotland', 'Wales', 'Northern Ireland', 'West Midlands', 'Manchester']
            },
            {
                code: 'CA',
                name: 'Canada',
                flag: '🇨🇦',
                dial: '+1',
                digits: 10,
                states: ['Ontario', 'British Columbia', 'Quebec', 'Alberta', 'Manitoba', 'Saskatchewan']
            },
            {
                code: 'AU',
                name: 'Australia',
                flag: '🇦🇺',
                dial: '+61',
                digits: 9,
                states: ['New South Wales', 'Victoria', 'Queensland', 'Western Australia', 'South Australia']
            },
            {
                code: 'SG',
                name: 'Singapore',
                flag: '🇸🇬',
                dial: '+65',
                digits: 8,
                states: ['Central Region', 'East Region', 'North Region', 'West Region', 'North-East Region']
            },
            {
                code: 'MY',
                name: 'Malaysia',
                flag: '🇲🇾',
                dial: '+60',
                digits: 9,
                states: ['Kuala Lumpur', 'Selangor', 'Penang', 'Johor', 'Perak', 'Sabah', 'Sarawak']
            },
            {
                code: 'SA',
                name: 'Saudi Arabia',
                flag: '🇸🇦',
                dial: '+966',
                digits: 9,
                states: ['Riyadh', 'Makkah', 'Eastern Province', 'Madinah', 'Asir', 'Tabuk']
            },
            {
                code: 'DE',
                name: 'Germany',
                flag: '🇩🇪',
                dial: '+49',
                digits: 10,
                states: ['Bavaria', 'Berlin', 'North Rhine-Westphalia', 'Baden-Württemberg', 'Hesse']
            },
            {
                code: 'NZ',
                name: 'New Zealand',
                flag: '🇳🇿',
                dial: '+64',
                digits: 9,
                states: ['Auckland', 'Canterbury', 'Wellington', 'Waikato', 'Bay of Plenty']
            }
        ];

        var selectedRole = 'Retailer';
        var selectedCountry = COUNTRIES_DATA[0]; // First auto-selected: India (flag, +91)
        var selectedState = selectedCountry.states[0]; // Maharashtra
        var activePickerType = 'country';

        /* Update Form Display */
        function syncRegistrationSelection() {
            /* Country Display */
            var cFlag = document.getElementById('triggerCountryFlag');
            var cName = document.getElementById('triggerCountryName');
            if (cFlag) cFlag.textContent = selectedCountry.flag;
            if (cName) cName.textContent = `${selectedCountry.name} (${selectedCountry.dial})`;

            /* State Display */
            var sName = document.getElementById('triggerStateName');
            if (sName) sName.textContent = selectedState;

            /* WhatsApp Flag & Dial Prefix */
            var waFlag = document.getElementById('waFlagEmoji');
            var waDial = document.getElementById('waDialCode');
            var hint = document.getElementById('digitCountHint');

            if (waFlag) waFlag.textContent = selectedCountry.flag;
            if (waDial) waDial.textContent = selectedCountry.dial;
            if (hint) hint.textContent = `${selectedCountry.digits} digits required`;

            renderQuickPreviews();
            validateWhatsAppDigits();
        }

        /* Quick Pills Preview */
        function renderQuickPreviews() {
            var cTrack = document.getElementById('countryQuickPreview');
            if (cTrack) {
                var cHtml = '';
                COUNTRIES_DATA.forEach(function(c) {
                    var isSel = c.code === selectedCountry.code;
                    cHtml += `<div class="quick-pill ${isSel ? 'selected' : ''}" onclick="selectCountry('${c.code}')"><span>${c.flag}</span><span>${c.name}</span></div>`;
                });
                cTrack.innerHTML = cHtml;
            }

            var sTrack = document.getElementById('stateQuickPreview');
            if (sTrack) {
                var sHtml = '';
                selectedCountry.states.slice(0, 10).forEach(function(st) {
                    var isSel = st === selectedState;
                    sHtml += `<div class="quick-pill ${isSel ? 'selected' : ''}" onclick="selectState('${st}')"><span>📍</span><span>${st}</span></div>`;
                });
                sTrack.innerHTML = sHtml;
            }
        }

        /* Open Scrolling Slider Modal Picker */
        window.openPickerSlider = function(type) {
            activePickerType = type;
            var backdrop = document.getElementById('pickerSliderBackdrop');
            var title = document.getElementById('pickerTitle');
            var search = document.getElementById('pickerSearchInput');
            if (!backdrop) return;

            if (search) search.value = '';

            if (type === 'country') {
                if (title) title.innerHTML = '🌍 Select Country / Region';
                renderPickerItems(COUNTRIES_DATA);
            } else {
                if (title) title.innerHTML = `📍 Select State (${selectedCountry.name})`;
                renderPickerItems(selectedCountry.states);
            }

            backdrop.classList.add('active');
            document.body.style.overflow = 'hidden';
            if (search) setTimeout(function(){ search.focus(); }, 150);
        };

        window.closePickerSlider = function() {
            var backdrop = document.getElementById('pickerSliderBackdrop');
            if (backdrop) backdrop.classList.remove('active');
            document.body.style.overflow = '';
        };

        function renderPickerItems(items) {
            var body = document.getElementById('pickerSliderBody');
            if (!body) return;

            var html = '';
            if (activePickerType === 'country') {
                items.forEach(function(c) {
                    var isSel = c.code === selectedCountry.code;
                    html += `
                        <div class="picker-card-item ${isSel ? 'selected' : ''}" onclick="selectCountry('${c.code}'); closePickerSlider();">
                            <span class="picker-card-flag">${c.flag}</span>
                            <span class="picker-card-name">${c.name}</span>
                            <span class="picker-card-dial">${c.dial} (${c.digits} digits)</span>
                        </div>
                    `;
                });
            } else {
                items.forEach(function(st) {
                    var isSel = st === selectedState;
                    html += `
                        <div class="picker-card-item ${isSel ? 'selected' : ''}" onclick="selectState('${st}'); closePickerSlider();">
                            <span class="picker-card-flag" style="font-size:1.4rem;">📍</span>
                            <span class="picker-card-name">${st}</span>
                            <span class="picker-card-dial" style="color:var(--mid-text);">${selectedCountry.name}</span>
                        </div>
                    `;
                });
            }
            body.innerHTML = html;
        }

        window.filterPickerItems = function() {
            var input = document.getElementById('pickerSearchInput');
            var q = input ? input.value.trim().toLowerCase() : '';

            if (activePickerType === 'country') {
                var filtered = COUNTRIES_DATA.filter(function(c) {
                    return c.name.toLowerCase().includes(q) || c.dial.includes(q) || c.code.toLowerCase().includes(q);
                });
                renderPickerItems(filtered);
            } else {
                var filtered = selectedCountry.states.filter(function(st) {
                    return st.toLowerCase().includes(q);
                });
                renderPickerItems(filtered);
            }
        };

        window.selectCountry = function(code) {
            var found = COUNTRIES_DATA.find(function(c) { return c.code === code; });
            if (found) {
                selectedCountry = found;
                selectedState = found.states[0] || 'Default';
                syncRegistrationSelection();
            }
        };

        window.selectState = function(stateName) {
            selectedState = stateName;
            var cityInput = document.getElementById('regCity');
            if (cityInput && !cityInput.value) {
                cityInput.value = stateName;
            }
            syncRegistrationSelection();
        };

        window.selectRole = function(role) {
            selectedRole = role;
            document.querySelectorAll('.role-card').forEach(function(c) {
                c.classList.toggle('selected', c.dataset.role === role);
            });
        };

        /* Validate WhatsApp Digits in real-time */
        window.validateWhatsAppDigits = function() {
            var input = document.getElementById('regPhone');
            var group = document.getElementById('waPhoneGroup');
            var errorMsg = document.getElementById('phoneErrorMsg');
            if (!input || !group || !errorMsg) return true;

            /* Clean non-numeric characters */
            var clean = input.value.replace(/[^0-9]/g, '');
            input.value = clean;

            var expected = selectedCountry.digits || 10;

            if (clean.length > 0 && clean.length !== expected) {
                group.classList.add('is-invalid');
                errorMsg.style.display = 'block';
                errorMsg.textContent = `⚠️ ${selectedCountry.name} WhatsApp number must be exactly ${expected} digits (currently ${clean.length}).`;
                return false;
            } else {
                group.classList.remove('is-invalid');
                errorMsg.style.display = 'none';
                return clean.length === expected;
            }
        };

        /* Check URL Parameter for Initial Tab (e.g. ?tab=register or ?tab=login) */
        var urlParams = new URLSearchParams(window.location.search);
        var initialTab = urlParams.get('tab') || 'login';

        function checkUserAuth() {
            var userRaw = localStorage.getItem('kalaniketan_user');
            var authCard = document.getElementById('authCardWrap');
            var dashWrap = document.getElementById('dashboardWrap');

            if (userRaw) {
                /* User is Logged In -> Show Dashboard */
                var user = JSON.parse(userRaw);
                authCard.style.display = 'none';
                dashWrap.classList.add('active');

                var nameEl = document.getElementById('dashUserName');
                var phoneEl = document.getElementById('dashUserPhone');
                var initEl = document.getElementById('dashUserInitials');
                var locEl = document.getElementById('dashUserLocation');
                var roleEl = document.getElementById('dashUserRoleBadge');

                if (nameEl) nameEl.textContent = user.name || 'Luxury Member';
                if (phoneEl) phoneEl.textContent = user.phone || '+91 98765 43210';
                if (locEl && user.city && user.state) {
                    locEl.textContent = `📍 ${user.city}, ${user.state}, ${user.country || 'India'}`;
                }
                if (roleEl) {
                    var r = user.role || 'Retailer';
                    var icon = r === 'Wholesaler' ? '📦' : (r === 'Reseller' ? '💼' : '👑');
                    roleEl.textContent = `${icon} Royal ${r} VIP Member`;
                }

                if (initEl) {
                    var parts = (user.name || 'Luxury Member').split(' ');
                    var initials = parts[0].charAt(0) + (parts[1] ? parts[1].charAt(0) : '');
                    initEl.textContent = initials.toUpperCase();
                }

                /* Sync Counts */
                var cart = JSON.parse(localStorage.getItem('kalaniketan_cart') || '[]');
                var wish = JSON.parse(localStorage.getItem('kalaniketan_wishlist') || '[]');
                var cEl = document.getElementById('dashCartCount');
                var wEl = document.getElementById('dashWishCount');
                if (cEl) cEl.textContent = cart.reduce(function(s, i){ return s + (i.qty||1); }, 0);
                if (wEl) wEl.textContent = wish.length;
            } else {
                /* User is Logged Out -> Show Auth Forms */
                authCard.style.display = 'block';
                dashWrap.classList.remove('active');
                syncRegistrationSelection();
                switchAuthTab(initialTab);
            }
        }

        window.switchAuthTab = function(tab) {
            var loginForm = document.getElementById('loginForm');
            var regForm = document.getElementById('registerForm');
            var forgotForm = document.getElementById('forgotForm');

            var btnLogin = document.getElementById('tabBtnLogin');
            var btnReg = document.getElementById('tabBtnRegister');
            var btnForgot = document.getElementById('tabBtnForgot');

            var heading = document.getElementById('authHeading');
            var sub = document.getElementById('authSubheading');

            btnLogin.classList.toggle('active', tab === 'login');
            btnReg.classList.toggle('active', tab === 'register');
            btnForgot.classList.toggle('active', tab === 'forgot');

            loginForm.style.display = (tab === 'login') ? 'block' : 'none';
            regForm.style.display = (tab === 'register') ? 'block' : 'none';
            forgotForm.style.display = (tab === 'forgot') ? 'block' : 'none';

            if (tab === 'login') {
                heading.textContent = 'VIP Member Sign In';
                sub.textContent = 'Access your personalized luxury ethnic experience';
            } else if (tab === 'register') {
                heading.textContent = 'Create Luxury Account';
                sub.textContent = 'Join Kalaniketan VIP Royal Member Club';
                syncRegistrationSelection();
            } else {
                heading.textContent = 'Reset Password';
                sub.textContent = 'Instant OTP & Password Recovery via WhatsApp';
            }
        };

        window.handleLoginSubmit = function() {
            var input = document.getElementById('loginPhone').value.trim();
            if (!input) return;

            var name = input.includes('@') ? input.split('@')[0] : 'Luxury Member';
            name = name.charAt(0).toUpperCase() + name.slice(1);

            var userData = {
                name: name,
                phone: input.includes('@') ? '+91 98765 43210' : '+91 ' + input,
                email: input.includes('@') ? input : 'member@kalaniketan.com',
                role: 'Retailer',
                country: 'India',
                state: 'Maharashtra',
                city: 'Mumbai'
            };
            localStorage.setItem('kalaniketan_user', JSON.stringify(userData));

            /* Switch directly to My Account Dashboard */
            checkUserAuth();
        };

        window.handleRegisterSubmit = function() {
            var name = document.getElementById('regName').value.trim();
            var phone = document.getElementById('regPhone').value.trim();
            var city = document.getElementById('regCity').value.trim();
            var email = document.getElementById('regEmail').value.trim();

            if (!name) {
                alert('Please enter your Full Name.');
                return;
            }

            var expected = selectedCountry.digits || 10;
            if (!phone || phone.length !== expected) {
                alert(`⚠️ Please enter a valid ${expected}-digit WhatsApp number for ${selectedCountry.name}.`);
                document.getElementById('regPhone').focus();
                return;
            }

            var userData = {
                name: name,
                phone: selectedCountry.dial + ' ' + phone,
                rawPhone: phone,
                email: email || 'member@kalaniketan.com',
                role: selectedRole,
                country: selectedCountry.name,
                countryCode: selectedCountry.code,
                flag: selectedCountry.flag,
                dial: selectedCountry.dial,
                state: selectedState,
                city: city || selectedState
            };
            localStorage.setItem('kalaniketan_user', JSON.stringify(userData));

            /* Switch directly to My Account Dashboard */
            checkUserAuth();
        };

        window.handleForgotSubmit = function() {
            var input = document.getElementById('forgotInput').value.trim();
            if (!input) return;

            var waUrl = `https://api.whatsapp.com/send?phone=919876543210&text=Hi%2C%20I%20need%20a%20password%20reset%20link%20for%20my%20Kalaniketan%20account%20(${encodeURIComponent(input)})`;
            window.open(waUrl, '_blank');
            alert('📩 Password reset request sent to WhatsApp Concierge!');
        };

        window.handleLogoutClick = function() {
            /* Clear user session and redirect back to shop.php */
            localStorage.removeItem('kalaniketan_user');
            window.location.href = 'shop.php';
        };

        /* Run on Page Load */
        document.addEventListener('DOMContentLoaded', function() {
            checkUserAuth();
        });
    })();
    </script>
</body>
</html>
