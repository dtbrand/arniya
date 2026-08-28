<?php
/**
 * myaccount.php — Dedicated Luxury Customer Account & Auth Page
 * Enhanced Ultra-Clear Typography, High Contrast Form Headings, Labels & Visual Hierarchy
 * 100% Fluid Responsive for Desktop & Mobile
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>My Account — DT Brand's | Ethnic Luxury</title>
    
    <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --dark-gold: #8A681F;
            --deep-gold: #5F4512;
            --gold-light: #C5A859;
            --gold-pale: #FAF5E8;
            --gold-border: rgba(138, 104, 31, 0.35);
            --dark-text: #181512;
            --mid-text: #423C34;
            --light-text: #6E675D;
            --off-white: #F9F7F2;
            --pure-white: #FFFFFF;
            --soft-platinum: #DCD7CD;
            --font-serif: 'Cinzel', serif;
            --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
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
            -webkit-font-smoothing: antialiased;
        }

        /* ── Top Header Navigation Bar ── */
        .account-nav-header {
            background: #FFFFFF;
            border-bottom: 2px solid var(--dark-gold);
            padding: clamp(10px, 2.5vw, 16px) clamp(16px, 4vw, 40px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }
        .account-nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        .brand-seal {
            width: clamp(34px, 6vw, 42px);
            height: clamp(34px, 6vw, 42px);
            border-radius: 50%;
            background: linear-gradient(135deg, var(--dark-gold) 0%, var(--deep-gold) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            font-weight: 700;
            box-shadow: 0 3px 10px rgba(138,104,31,0.35);
        }
        .brand-seal svg {
            width: clamp(18px, 3.5vw, 22px);
            height: clamp(18px, 3.5vw, 22px);
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
        }
        .brand-text h1 {
            font-family: var(--font-serif);
            font-size: clamp(1.05rem, 3.5vw, 1.4rem);
            font-weight: 800;
            color: var(--dark-gold);
            letter-spacing: 0.08em;
            line-height: 1;
        }
        .brand-text span {
            font-size: clamp(0.58rem, 1.8vw, 0.7rem);
            color: var(--mid-text);
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            display: block;
            margin-top: 2px;
        }
        .return-shop-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px clamp(12px, 2.2vw, 18px);
            border-radius: 20px;
            border: 1.5px solid var(--dark-gold);
            background: #FAF8F4;
            color: var(--dark-gold);
            font-size: clamp(0.74rem, 2vw, 0.84rem);
            font-weight: 800;
            text-decoration: none;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            transition: all var(--transition);
        }
        .return-shop-btn:hover {
            background: var(--dark-gold);
            color: #FFFFFF;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(138,104,31,0.25);
        }

        /* ── Main Page Container ── */
        .page-container {
            flex: 1;
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: clamp(16px, 3.5vw, 36px) clamp(12px, 3vw, 24px);
        }

        /* ════════════════════════════════════════════════════
           HIGH-VISIBILITY AUTH CARD VIEW
        ════════════════════════════════════════════════════ */
        .auth-card-wrap {
            max-width: 530px;
            margin: clamp(10px, 4vw, 30px) auto;
            background: #FFFFFF;
            border-radius: 18px;
            border: 2px solid var(--dark-gold);
            box-shadow: 0 12px 40px rgba(0,0,0,0.1);
            overflow: visible;
        }
        
        /* ── Luxury Form Card Header with Brand Logo & Royal Seal ── */
        .auth-card-header {
            background: linear-gradient(135deg, #FAF4E6 0%, #F5EAD4 50%, #FAF6ED 100%);
            padding: 24px 24px 20px;
            border-bottom: 2px solid var(--gold-border);
            text-align: center;
            border-radius: 16px 16px 0 0;
            position: relative;
            overflow: hidden;
        }
        .auth-card-header::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent 0%, var(--dark-gold) 50%, transparent 100%);
        }
        
        /* Royal Logo Seal */
        .auth-brand-seal-wrap {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 12px;
            text-decoration: none;
        }
        .auth-logo-badge {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--dark-gold) 0%, var(--deep-gold) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            box-shadow: 0 4px 16px rgba(138,104,31,0.4);
            border: 2px solid #FFFFFF;
            position: relative;
            margin-bottom: 8px;
            animation: goldGlowPulse 3s ease-in-out infinite;
        }
        @keyframes goldGlowPulse {
            0%, 100% { box-shadow: 0 4px 16px rgba(138,104,31,0.35); transform: scale(1); }
            50% { box-shadow: 0 6px 24px rgba(197,168,89,0.55); transform: scale(1.03); }
        }
        .auth-logo-badge svg {
            width: 26px;
            height: 26px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
        }
        .auth-brand-title {
            font-family: var(--font-serif);
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--dark-gold);
            letter-spacing: 0.14em;
            text-transform: uppercase;
            line-height: 1;
        }
        .auth-brand-sub {
            font-size: 0.62rem;
            color: var(--mid-text);
            font-weight: 700;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            margin-top: 3px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .auth-brand-sub::before, .auth-brand-sub::after {
            content: '❖';
            font-size: 0.5rem;
            color: var(--dark-gold);
            opacity: 0.7;
        }

        .auth-card-header h2 {
            font-family: var(--font-serif);
            font-size: clamp(1.2rem, 3.8vw, 1.45rem);
            font-weight: 800;
            color: var(--dark-text);
            letter-spacing: 0.05em;
            margin: 6px 0 3px;
            line-height: 1.2;
        }
        .auth-card-header p {
            font-size: 0.8rem;
            color: var(--mid-text);
            font-weight: 600;
        }

        /* Navigation Tabs */
        .auth-tabs {
            display: flex;
            background: #EFE7D5;
            border-bottom: 1.5px solid var(--gold-border);
        }
        .auth-tab {
            flex: 1;
            padding: 13px 8px;
            background: transparent;
            border: none;
            border-bottom: 3.5px solid transparent;
            font-family: var(--font-sans);
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--mid-text);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
        }
        .auth-tab.active {
            background: #FFFFFF;
            color: var(--dark-gold);
            border-bottom-color: var(--dark-gold);
        }

        /* Form Body */
        .auth-body {
            padding: clamp(18px, 4vw, 28px);
        }
        .auth-form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
            margin-bottom: 18px;
            position: relative;
        }
        
        /* Ultra Clear Labels */
        .auth-label {
            font-size: 0.76rem;
            font-weight: 800;
            color: var(--dark-text);
            letter-spacing: 0.07em;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .auth-label .req {
            color: #C62828;
            font-weight: 900;
            font-size: 0.9rem;
            margin-left: 2px;
        }
        
        /* Inputs */
        .auth-input {
            width: 100%;
            height: 46px;
            border: 1.8px solid var(--soft-platinum);
            border-radius: 9px;
            padding: 0 14px;
            font-family: var(--font-sans);
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--dark-text);
            background: #FFFFFF;
            outline: none;
            transition: all 0.2s ease;
        }
        .auth-input::placeholder {
            color: var(--light-text);
            font-weight: 500;
        }
        .auth-input:focus {
            border-color: var(--dark-gold);
            background: #FFFFFF;
            box-shadow: 0 0 0 3.5px rgba(138,104,31,0.2);
        }

        /* Side-by-Side Grid for City & State */
        .auth-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        @media (max-width: 480px) {
            .auth-grid-2 {
                grid-template-columns: 1fr;
            }
        }

        /* ── Custom Luxury Dropdown Select Component ── */
        .custom-select-box {
            position: relative;
            width: 100%;
        }
        .custom-select-trigger {
            width: 100%;
            height: 46px;
            border: 1.8px solid var(--soft-platinum);
            border-radius: 9px;
            padding: 0 14px;
            background: #FFFFFF;
            color: var(--dark-text);
            font-size: 0.9rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        }
        .custom-select-trigger:hover,
        .custom-select-box.active .custom-select-trigger {
            border-color: var(--dark-gold);
            box-shadow: 0 0 0 3.5px rgba(138,104,31,0.2);
        }
        .custom-select-val {
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .custom-select-arrow {
            width: 18px;
            height: 18px;
            stroke: var(--dark-gold);
            stroke-width: 2.5;
            fill: none;
            transition: transform 0.2s ease;
            flex-shrink: 0;
        }
        .custom-select-box.active .custom-select-arrow {
            transform: rotate(180deg);
        }

        /* Custom Dropdown Search & Menu */
        .custom-select-menu {
            position: absolute;
            top: calc(100% + 4px);
            left: 0;
            right: 0;
            background: #FFFFFF;
            border: 2px solid var(--dark-gold);
            border-radius: 12px;
            box-shadow: 0 12px 36px rgba(0,0,0,0.2);
            max-height: 280px;
            z-index: 1000;
            display: none;
            flex-direction: column;
            overflow: hidden;
            animation: customDropFade 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .custom-select-box.active .custom-select-menu {
            display: flex;
        }
        @keyframes customDropFade {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .dropdown-search-box {
            padding: 8px 12px;
            background: #FAF6EE;
            border-bottom: 1.5px solid var(--soft-platinum);
            flex-shrink: 0;
        }
        .dropdown-search-input {
            width: 100%;
            height: 36px;
            border: 1.5px solid var(--soft-platinum);
            border-radius: 6px;
            padding: 0 12px;
            font-family: var(--font-sans);
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--dark-text);
            outline: none;
            background: #FFFFFF;
        }
        .dropdown-search-input:focus {
            border-color: var(--dark-gold);
            box-shadow: 0 0 0 2px rgba(138,104,31,0.2);
        }
        .dropdown-options-scroll {
            overflow-y: auto;
            flex: 1;
            padding: 4px 0;
            scrollbar-width: thin;
        }

        .custom-select-option {
            padding: 10px 14px;
            font-size: 0.86rem;
            color: var(--dark-text);
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.15s ease;
        }
        .custom-select-option:hover {
            background: #FAF3E0;
            color: var(--dark-gold);
            font-weight: 700;
            padding-left: 18px;
        }
        .custom-select-option.selected {
            background: var(--dark-gold);
            color: #FFFFFF;
            font-weight: 700;
        }
        .select-flag-img {
            width: 24px;
            height: 16px;
            object-fit: cover;
            border-radius: 3px;
            border: 1px solid rgba(0,0,0,0.12);
            flex-shrink: 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        /* ── Role Selection Pill Buttons with Real SVG Icons & Micro-Animations ── */
        .role-pill-group {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 4px;
        }
        .role-pill-btn {
            position: relative;
            padding: 12px 8px;
            border-radius: 11px;
            border: 2px solid var(--soft-platinum);
            background: #FFFFFF;
            color: var(--dark-text);
            font-family: var(--font-sans);
            font-size: 0.84rem;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
            user-select: none;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        }
        .role-pill-btn:hover {
            border-color: var(--dark-gold);
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(138,104,31,0.18);
        }
        .role-pill-btn.selected {
            border-color: var(--dark-gold);
            background: linear-gradient(135deg, #FAF4E5 0%, #F5E8C8 100%);
            color: var(--deep-gold);
            box-shadow: 0 4px 18px rgba(138,104,31,0.28);
            transform: translateY(-2px);
        }
        
        /* Active Checkmark Pill Indicator */
        .role-pill-btn.selected::after {
            content: '✓';
            position: absolute;
            top: 5px;
            right: 5px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: var(--dark-gold);
            color: #FFFFFF;
            font-size: 0.55rem;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: badgePop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        @keyframes badgePop {
            0% { transform: scale(0); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        /* SVG Role Icons */
        .role-svg-icon {
            width: 26px;
            height: 26px;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .role-svg-icon svg {
            width: 100%;
            height: 100%;
            display: block;
        }

        /* Specific Animated States */
        .role-pill-btn:hover .role-svg-retailer {
            animation: bagSwing 0.6s ease-in-out;
        }
        .role-pill-btn:hover .role-svg-wholesaler {
            animation: boxBounce 0.6s ease-in-out;
        }
        .role-pill-btn:hover .role-svg-reseller {
            animation: caseTilt 0.6s ease-in-out;
        }

        .role-pill-btn.selected .role-svg-icon {
            transform: scale(1.15);
        }

        @keyframes bagSwing {
            0%, 100% { transform: rotate(0deg) scale(1); }
            25% { transform: rotate(-12deg) scale(1.1); }
            75% { transform: rotate(12deg) scale(1.1); }
        }
        @keyframes boxBounce {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-5px) scale(1.12); }
        }
        @keyframes caseTilt {
            0%, 100% { transform: rotate(0deg) scale(1); }
            30% { transform: rotate(-10deg) scale(1.1); }
            70% { transform: rotate(10deg) scale(1.1); }
        }

        /* ── WhatsApp Phone Input with Auto Country Flag & Prefix ── */
        .wa-phone-group {
            display: flex;
            border: 1.8px solid var(--soft-platinum);
            border-radius: 9px;
            background: #FFFFFF;
            overflow: hidden;
            transition: all 0.2s ease;
        }
        .wa-phone-group:focus-within {
            border-color: var(--dark-gold);
            box-shadow: 0 0 0 3.5px rgba(138,104,31,0.2);
        }
        .wa-phone-group.is-invalid {
            border-color: #C62828 !important;
            box-shadow: 0 0 0 3.5px rgba(198,40,40,0.2) !important;
        }
        .wa-flag-prefix {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 0 12px;
            background: #EFE8D6;
            border-right: 1.8px solid var(--soft-platinum);
            font-size: 0.86rem;
            font-weight: 800;
            color: var(--dark-gold);
            flex-shrink: 0;
            user-select: none;
        }
        .wa-flag-img-preview {
            width: 24px;
            height: 16px;
            object-fit: cover;
            border-radius: 3px;
            border: 1px solid rgba(0,0,0,0.12);
        }
        .wa-input-field {
            flex: 1;
            height: 46px;
            border: none;
            outline: none;
            background: transparent;
            padding: 0 14px;
            font-family: var(--font-sans);
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--dark-text);
            width: 100%;
        }
        .validation-error-msg {
            font-size: 0.72rem;
            color: #C62828;
            font-weight: 700;
            display: none;
            margin-top: 4px;
        }

        /* Prominent Action Button */
        .auth-btn-submit {
            width: 100%;
            padding: 15px;
            border-radius: 9px;
            border: none;
            background: linear-gradient(135deg, var(--dark-gold) 0%, var(--deep-gold) 100%);
            color: #FFFFFF;
            font-family: var(--font-sans);
            font-size: 0.92rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 5px 18px rgba(138,104,31,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 12px;
        }
        .auth-btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(138,104,31,0.42);
        }
        .auth-link {
            color: var(--dark-gold);
            font-size: 0.78rem;
            font-weight: 800;
            text-decoration: underline;
            background: none;
            border: none;
            cursor: pointer;
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
            background: linear-gradient(135deg, #201D17 0%, #362F24 100%);
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
            width: clamp(54px, 10vw, 70px);
            height: clamp(54px, 10vw, 70px);
            border-radius: 50%;
            background: linear-gradient(135deg, var(--dark-gold) 0%, #C5A859 100%);
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-serif);
            font-size: clamp(1.4rem, 4vw, 1.8rem);
            font-weight: 800;
            box-shadow: 0 4px 16px rgba(138,104,31,0.4);
            border: 2px solid #FFFFFF;
            flex-shrink: 0;
        }
        .profile-details h2 {
            font-family: var(--font-serif);
            font-size: clamp(1.15rem, 3.5vw, 1.55rem);
            font-weight: 800;
            color: #FAF5E8;
            margin-bottom: 3px;
        }
        .profile-phone {
            font-size: clamp(0.76rem, 2vw, 0.88rem);
            color: #D6CCA8;
            font-weight: 600;
        }
        .profile-location {
            font-size: clamp(0.72rem, 1.8vw, 0.8rem);
            color: #E2C988;
            font-weight: 600;
            margin-top: 2px;
        }
        .vip-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 12px;
            border-radius: 12px;
            background: rgba(138,104,31,0.35);
            border: 1px solid var(--dark-gold);
            color: #E2C988;
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-top: 6px;
        }

        .logout-btn {
            padding: 9px 20px;
            border-radius: 20px;
            border: 1.5px solid rgba(255,255,255,0.4);
            background: rgba(255,255,255,0.1);
            color: #FFFFFF;
            font-size: 0.78rem;
            font-weight: 800;
            cursor: pointer;
            transition: all var(--transition);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            flex-shrink: 0;
        }
        .logout-btn:hover {
            background: #C62828;
            border-color: #C62828;
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
            padding: clamp(16px, 3vw, 24px);
            box-shadow: 0 4px 16px rgba(0,0,0,0.05);
        }
        .dash-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 12px;
            margin-bottom: 16px;
            border-bottom: 1.5px dashed var(--gold-border);
        }
        .dash-card-title {
            font-family: var(--font-serif);
            font-size: clamp(0.95rem, 2.5vw, 1.15rem);
            font-weight: 800;
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
            stroke-width: 2.2;
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
            box-shadow: 0 4px 12px rgba(138,104,31,0.1);
        }
        .order-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .order-id {
            font-family: var(--font-serif);
            font-size: 0.9rem;
            font-weight: 800;
            color: var(--dark-text);
        }
        .order-status-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .status-processing { background: #FFF3E0; color: #E65100; border: 1px solid #FFE082; }
        .status-delivered { background: #E8F5E9; color: #2E7D32; border: 1px solid #A5D6A7; }
        
        .order-item-detail {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.82rem;
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
            font-size: 0.8rem;
        }
        .order-total-txt {
            font-weight: 800;
            color: var(--dark-gold);
        }
        .track-wa-btn {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            color: #25D366;
            font-weight: 800;
            text-decoration: none;
            font-size: 0.78rem;
        }
        .track-wa-btn:hover {
            text-decoration: underline;
        }

        /* Quick Stat Tiles */
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
            padding: 16px 12px;
            text-align: center;
            text-decoration: none;
            color: inherit;
            transition: all 0.2s ease;
        }
        .stat-tile:hover {
            border-color: var(--dark-gold);
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(138,104,31,0.15);
        }
        .stat-tile-num {
            font-size: 1.45rem;
            font-weight: 900;
            color: var(--dark-gold);
            font-family: var(--font-serif);
        }
        .stat-tile-lbl {
            font-size: 0.7rem;
            font-weight: 800;
            color: var(--mid-text);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-top: 3px;
        }

        /* Concierge Box */
        .concierge-card {
            background: linear-gradient(135deg, #FAF6EE 0%, #F5EDE0 100%);
            border: 1.5px solid var(--gold-border);
            border-radius: 12px;
            padding: 18px;
            text-align: center;
        }
        .concierge-card h4 {
            font-family: var(--font-serif);
            font-size: 1rem;
            font-weight: 800;
            color: var(--dark-gold);
            margin-bottom: 6px;
        }
        .concierge-card p {
            font-size: 0.78rem;
            color: var(--mid-text);
            margin-bottom: 14px;
            line-height: 1.4;
            font-weight: 500;
        }
        .concierge-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 11px;
            border-radius: 8px;
            background: #25D366;
            color: #FFFFFF;
            font-weight: 800;
            font-size: 0.84rem;
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
        <a href="../../shop" class="account-nav-brand" style="display:inline-flex; align-items:center; text-decoration:none;">
            <img src="/assets/images/logo.png" onerror="this.src='/assets/images/logo.png';" alt="DT Brand's" style="height:36px; width:auto; max-width:160px; object-fit:contain;">
        </a>

        <a href="../../shop" class="return-shop-btn">
            <svg style="width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2.2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            <span>Back to Shop</span>
        </a>
    </header>

    <!-- ═══ Page Content ═══ -->
    <main class="page-container">

        <!-- ════════ VIEW 1: AUTHENTICATION (FOR GUEST USERS) ════════ -->
        <div class="auth-card-wrap" id="authCardWrap">
            <div class="auth-card-header">
                <!-- Royal Brand Real Logo -->
                <div class="auth-brand-seal-wrap" style="display:inline-flex; flex-direction:column; align-items:center; margin-bottom:12px;">
                    <img src="/assets/images/logo.png" onerror="this.src='/assets/images/logo.png';" alt="DT Brand's" style="height:44px; width:auto; max-width:180px; object-fit:contain; margin-bottom:6px;">
                </div>

                <h2 id="authHeading">Sign In</h2>
                <p id="authSubheading">Access your account to track orders & explore collections</p>
            </div>

            <!-- Tabs (Only Login & Register) -->
            <div class="auth-tabs">
                <button class="auth-tab active" id="tabBtnLogin" onclick="switchAuthTab('login')">Login</button>
                <button class="auth-tab" id="tabBtnRegister" onclick="switchAuthTab('register')">Register</button>
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
                            <button type="button" class="auth-link" onclick="switchAuthTab('forgot')">Forgot Password?</button>
                        </label>
                        <input type="password" id="loginPass" class="auth-input" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="auth-btn-submit">
                        <svg style="width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:2.2" viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                        <span>Sign In to My Account</span>
                    </button>
                </form>

                <!-- 2. REGISTER FORM -->
                <form id="registerForm" style="display:none;" onsubmit="event.preventDefault(); handleRegisterSubmit();">
                    
                    <!-- Full Name -->
                    <div class="auth-form-group">
                        <label class="auth-label" for="regName">Full Name <span class="req">*</span></label>
                        <input type="text" id="regName" class="auth-input" placeholder="e.g. Rajan Mehta" required>
                    </div>

                    <!-- Country Option (All World Countries with Search & Real Flags) -->
                    <div class="auth-form-group">
                        <label class="auth-label">Country <span class="req">*</span></label>
                        <div class="custom-select-box" id="countrySelectBox">
                            <div class="custom-select-trigger" onclick="toggleDropdown('countrySelectBox')">
                                <div class="custom-select-val" id="selectedCountryDisplay">
                                    <img src="https://flagcdn.com/w40/in.png" alt="India" class="select-flag-img" id="displayCountryFlag">
                                    <span id="displayCountryText">India (+91)</span>
                                </div>
                                <svg class="custom-select-arrow" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </div>
                            <div class="custom-select-menu" id="countryDropdownMenu">
                                <div class="dropdown-search-box">
                                    <input type="text" id="countrySearchInput" class="dropdown-search-input" placeholder="🔍 Search world country..." oninput="filterCountryOptions(this.value)" onclick="event.stopPropagation()">
                                </div>
                                <div class="dropdown-options-scroll" id="countryOptionsList">
                                    <!-- Populated dynamically by JS with All World Countries -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Number -->
                    <div class="auth-form-group">
                        <label class="auth-label" for="regPhone">
                            <span>Mobile Number <span class="req">*</span></span>
                            <span id="digitCountHint" style="font-size:0.68rem; color:var(--light-text); text-transform:none; font-weight:600;">10-digit number</span>
                        </label>
                        <div class="wa-phone-group" id="waPhoneGroup">
                            <div class="wa-flag-prefix">
                                <img id="waFlagImg" class="wa-flag-img-preview" src="https://flagcdn.com/w40/in.png" alt="India Flag">
                                <span id="waDialCode">IN +91</span>
                            </div>
                            <input
                                type="tel"
                                id="regPhone"
                                class="wa-input-field"
                                placeholder="10-digit number"
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

                    <!-- City & State Side-by-Side (Like Screenshot) -->
                    <div class="auth-grid-2">
                        <!-- City -->
                        <div class="auth-form-group">
                            <label class="auth-label" for="regCity">City <span class="req">*</span></label>
                            <input type="text" id="regCity" class="auth-input" placeholder="e.g. Surat" required value="Surat">
                        </div>

                        <!-- State (Custom Scrolling Dropdown) -->
                        <div class="auth-form-group">
                            <label class="auth-label">State <span class="req">*</span></label>
                            <div class="custom-select-box" id="stateSelectBox">
                                <div class="custom-select-trigger" onclick="toggleDropdown('stateSelectBox')">
                                    <div class="custom-select-val">
                                        <span id="displayStateText">Select State</span>
                                    </div>
                                    <svg class="custom-select-arrow" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                                <div class="custom-select-menu" id="stateDropdownMenu">
                                    <div class="dropdown-search-box">
                                        <input type="text" id="stateSearchInput" class="dropdown-search-input" placeholder="🔍 Search state..." oninput="filterStateOptions(this.value)" onclick="event.stopPropagation()">
                                    </div>
                                    <div class="dropdown-options-scroll" id="stateOptionsList">
                                        <!-- Populated dynamically by JS with States of Selected Country -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Role Option (Pills: Retailer, Wholesaler, Reseller with Real Vector SVG Icons) -->
                    <div class="auth-form-group">
                        <label class="auth-label">Your Role <span class="req">*</span></label>
                        <div class="role-pill-group">
                            <!-- Retailer -->
                            <div class="role-pill-btn selected" data-role="Retailer" onclick="selectRole('Retailer')">
                                <div class="role-svg-icon role-svg-retailer">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4H6z" fill="#E3F2FD" stroke="#1976D2" stroke-width="2" stroke-linejoin="round"/>
                                        <line x1="3" y1="6" x2="21" y2="6" stroke="#1976D2" stroke-width="2"/>
                                        <path d="M16 10a4 4 0 0 1-8 0" stroke="#1976D2" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </div>
                                <span>Retailer</span>
                            </div>

                            <!-- Wholesaler -->
                            <div class="role-pill-btn" data-role="Wholesaler" onclick="selectRole('Wholesaler')">
                                <div class="role-svg-icon role-svg-wholesaler">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" fill="#FFF3E0" stroke="#E65100" stroke-width="2" stroke-linejoin="round"/>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96" stroke="#E65100" stroke-width="2"/>
                                        <line x1="12" y1="22.08" x2="12" y2="12" stroke="#E65100" stroke-width="2"/>
                                    </svg>
                                </div>
                                <span>Wholesaler</span>
                            </div>

                            <!-- Reseller -->
                            <div class="role-pill-btn" data-role="Reseller" onclick="selectRole('Reseller')">
                                <div class="role-svg-icon role-svg-reseller">
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <rect x="2" y="7" width="20" height="14" rx="2" fill="#E8F5E9" stroke="#2E7D32" stroke-width="2"/>
                                        <path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" stroke="#2E7D32" stroke-width="2"/>
                                        <line x1="12" y1="12" x2="12" y2="15" stroke="#2E7D32" stroke-width="2" stroke-linecap="round"/>
                                        <line x1="2" y1="12" x2="22" y2="12" stroke="#2E7D32" stroke-width="1.5" stroke-dasharray="2 2"/>
                                    </svg>
                                </div>
                                <span>Reseller</span>
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="auth-form-group">
                        <label class="auth-label" for="regPass">Password <span class="req">*</span></label>
                        <input type="password" id="regPass" class="auth-input" placeholder="Minimum 6 characters" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="auth-btn-submit" id="regSubmitBtn">
                        <svg style="width:19px;height:19px;stroke:currentColor;fill:none;stroke-width:2.2" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                        <span>Create My Account</span>
                    </button>

                    <div style="text-align:center; font-size:0.78rem; margin-top:12px; color:var(--mid-text); font-weight:600;">
                        Already registered? <button type="button" class="auth-link" onclick="switchAuthTab('login')">Sign In</button>
                    </div>
                </form>

                <!-- 3. FORGOT PASSWORD FORM -->
                <form id="forgotForm" style="display:none;" onsubmit="event.preventDefault(); handleForgotSubmit();">
                    <p style="font-size:0.8rem; color:var(--mid-text); margin-bottom:14px; line-height:1.4; font-weight:500;">
                        Enter your registered WhatsApp Number or Email and we'll instantly send you a password reset link on WhatsApp.
                    </p>
                    <div class="auth-form-group">
                        <label class="auth-label" for="forgotInput">WhatsApp Number / Email <span class="req">*</span></label>
                        <input type="text" id="forgotInput" class="auth-input" placeholder="e.g. 9876543210 or radhika@example.com" required>
                    </div>
                    <button type="submit" class="auth-btn-submit">
                        <svg style="width:18px;height:18px;stroke:currentColor;fill:none;stroke-width:2.2" viewBox="0 0 24 24"><path d="M22 2L11 13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        <span>Send Reset Link via WhatsApp</span>
                    </button>

                    <div style="text-align:center; font-size:0.78rem; margin-top:14px; color:var(--mid-text); font-weight:600;">
                        Remembered your password? <button type="button" class="auth-link" onclick="switchAuthTab('login')">← Back to Login</button>
                    </div>
                </form>

            </div>
        </div>

        <!-- ════════ VIEW 2: LOGGED IN MEMBER DASHBOARD ════════ -->
        <div class="dashboard-wrap" id="dashboardWrap">
            
            <!-- Hero Profile Banner -->
            <div class="profile-hero">
                <div class="profile-main-group">
                    <div class="profile-avatar-circle" id="dashUserInitials">GV</div>
                    <div class="profile-details">
                        <h2 id="dashUserName">Gautam Vaishnav</h2>
                        <div class="profile-phone" id="dashUserPhone">+91 8890639215</div>
                        <div class="profile-location" id="dashUserLocation">📍 Surat, Gujarat, India</div>
                        <div class="vip-badge" id="dashUserRoleBadge">🛍️ Retailer Member</div>
                    </div>
                </div>

                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <a href="../../Frontend/Retailer/retailer.php" id="dashHeroPortalBtn" style="display:none; text-decoration:none; padding:10px 20px; font-size:0.84rem; font-weight:800; border-radius:8px; background:linear-gradient(135deg, #D4AF37 0%, #8A681F 100%); color:#FFFFFF; box-shadow:0 4px 14px rgba(138,104,31,0.35); align-items:center; gap:6px;">
                        <span>🛍️ Open Retailer Dashboard</span>
                        <span>→</span>
                    </a>
                    <button class="logout-btn" onclick="handleLogoutClick()">
                        Logout
                    </button>
                </div>
            </div>

            <!-- Dedicated B2B VIP Hub Banner for Retailers & Wholesalers -->
            <div class="ws-vip-access-banner" id="wsVipAccessBanner" style="display:flex; background:linear-gradient(135deg, #FAF6EE 0%, #F5EDE0 100%); border:2px solid var(--dark-gold, #8A681F); border-radius:14px; padding:16px 20px; margin-bottom:20px; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; box-shadow:0 4px 16px rgba(138, 104, 31, 0.12);">
                <div>
                    <div id="wsVipBannerTitle" style="font-family:var(--font-serif, 'Cinzel', serif); font-size:1.1rem; font-weight:800; color:var(--dark-gold, #8A681F);">
                        🛍️ Retailer B2B VIP Hub Ready
                    </div>
                    <div id="wsVipBannerSubtitle" style="font-size:0.82rem; color:var(--mid-text, #423C34); margin-top:3px;">
                        Access retail catalog, GST billing invoices, margin discounts, live dispatch tracking, and wallet.
                    </div>
                </div>
                <a href="../../Frontend/Retailer/retailer.php" id="wsVipBannerLink" class="auth-btn-submit" style="padding:10px 22px; font-size:0.85rem; font-weight:800; text-decoration:none; display:inline-flex; width:auto; border-radius:8px; background:linear-gradient(135deg, #8A681F 0%, #5E4613 100%); color:#FFFFFF;">
                    Open Retailer Portal →
                </a>
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
                        <a href="https://api.whatsapp.com/send?phone=917046363528&text=Hi%20DT Brand's%2C%20I%20would%20like%20to%20inquire%20about%20my%20recent%20orders" target="_blank" class="track-wa-btn">
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
                                <img src="/assets/images/product3.png" alt="Lehenga" class="order-thumb" onerror="this.src="/assets/images/product1.png";">
                                <div>
                                    <div style="font-weight:800; color:var(--dark-text);">Bridal Zardozi Velvet Lehenga</div>
                                    <div style="font-size:0.75rem; color:var(--light-text); margin-top:2px;">Size: M • Colour: Maroon • Qty: 1</div>
                                </div>
                            </div>
                            <div class="order-actions-bar">
                                <div>Total: <span class="order-total-txt">₹24,999</span></div>
                                <a href="https://api.whatsapp.com/send?phone=917046363528&text=Hi%2C%20please%20share%20tracking%20status%20for%20Order%20%23KLN-847291" target="_blank" class="track-wa-btn">
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
                                <img src="/assets/images/product1.png" alt="Saree" class="order-thumb">
                                <div>
                                    <div style="font-weight:800; color:var(--dark-text);">Royal Banarasi Kanjeevaram Saree</div>
                                    <div style="font-size:0.75rem; color:var(--light-text); margin-top:2px;">Free Size • Colour: Royal Gold • Qty: 1</div>
                                </div>
                            </div>
                            <div class="order-actions-bar">
                                <div>Total: <span class="order-total-txt">₹12,499</span></div>
                                <a href="https://api.whatsapp.com/send?phone=917046363528&text=Hi%2C%20I%20received%20Order%20%23KLN-312984%20and%20loved%20it!" target="_blank" class="track-wa-btn">
                                    Re-Order on WhatsApp →
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Quick Stat Tiles & Concierge -->
                <div style="display:flex; flex-direction:column; gap:16px;">
                    
                    <div class="stat-tiles">
                        <a href="../../shop" class="stat-tile">
                            <div class="stat-tile-num" id="dashCartCount">0</div>
                            <div class="stat-tile-lbl">Bag Items</div>
                        </a>
                        <a href="../../shop" class="stat-tile">
                            <div class="stat-tile-num" id="dashWishCount">0</div>
                            <div class="stat-tile-lbl">Saved Items</div>
                        </a>
                    </div>

                    <!-- Concierge Card -->
                    <div class="concierge-card">
                        <h4>Royal Concierge Desk</h4>
                        <p>Need custom blouse stitching, bulk wholesale pricing, or reseller catalog? Our fashion stylists are available.</p>
                        <a href="https://api.whatsapp.com/send?phone=917046363528&text=Hi%20DT Brand's%2C%20I%20would%20like%20personalized%20styling%20and%20catalog%20support" target="_blank" class="concierge-btn">
                            <svg style="width:16px;height:16px;fill:currentColor" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"/></svg>
                            <span>WhatsApp Stylist</span>
                        </a>
                    </div>

                    <a href="../../shop" class="auth-btn-submit" style="text-align:center; text-decoration:none; display:flex;">
                        Browse Luxury Catalog
                    </a>

                </div>

            </div>

        </div>

    </main>

    <!-- ════════ JAVASCRIPT CONTROLLER ════════ -->
    <script>
    (function() {
        'use strict';

        /* ── Complete All World Countries & All Indian States Database ── */
        var ALL_WORLD_COUNTRIES = [
            {
                code: 'in', name: 'India', flagImg: 'https://flagcdn.com/w40/in.png', dial: '+91', digits: 10,
                states: [
                    'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chhattisgarh', 
                    'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand', 
                    'Karnataka', 'Kerala', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 
                    'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Punjab', 
                    'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 
                    'Uttar Pradesh', 'Uttarakhand', 'West Bengal', 'Delhi (NCT)', 
                    'Jammu & Kashmir', 'Ladakh', 'Chandigarh', 'Puducherry', 'Dadra and Nagar Haveli and Daman and Diu', 'Andaman and Nicobar Islands', 'Lakshadweep'
                ]
            },
            { code: 'ae', name: 'United Arab Emirates', flagImg: 'https://flagcdn.com/w40/ae.png', dial: '+971', digits: 9, states: ['Dubai', 'Abu Dhabi', 'Sharjah', 'Ajman', 'Ras Al Khaimah', 'Fujairah', 'Umm Al Quwain'] },
            { code: 'us', name: 'United States', flagImg: 'https://flagcdn.com/w40/us.png', dial: '+1', digits: 10, states: ['California', 'Texas', 'New York', 'Florida', 'Illinois', 'New Jersey', 'Georgia', 'Washington', 'Ohio', 'Pennsylvania', 'North Carolina', 'Michigan', 'Virginia', 'Arizona', 'Massachusetts', 'Indiana', 'Tennessee', 'Missouri', 'Maryland', 'Wisconsin', 'Colorado', 'Minnesota', 'South Carolina', 'Alabama', 'Louisiana', 'Kentucky', 'Oregon', 'Oklahoma', 'Connecticut', 'Utah', 'Iowa', 'Nevada', 'Arkansas', 'Mississippi', 'Kansas', 'New Mexico', 'Nebraska', 'Idaho', 'West Virginia', 'Hawaii', 'New Hampshire', 'Maine', 'Rhode Island', 'Montana', 'Delaware', 'South Dakota', 'North Dakota', 'Alaska', 'Vermont', 'Wyoming'] },
            { code: 'gb', name: 'United Kingdom', flagImg: 'https://flagcdn.com/w40/gb.png', dial: '+44', digits: 10, states: ['Greater London', 'England', 'Scotland', 'Wales', 'Northern Ireland', 'West Midlands', 'Manchester', 'West Yorkshire', 'Hampshire', 'Essex'] },
            { code: 'ca', name: 'Canada', flagImg: 'https://flagcdn.com/w40/ca.png', dial: '+1', digits: 10, states: ['Ontario', 'British Columbia', 'Quebec', 'Alberta', 'Manitoba', 'Saskatchewan', 'Nova Scotia', 'New Brunswick', 'Newfoundland and Labrador', 'Prince Edward Island'] },
            { code: 'au', name: 'Australia', flagImg: 'https://flagcdn.com/w40/au.png', dial: '+61', digits: 9, states: ['New South Wales', 'Victoria', 'Queensland', 'Western Australia', 'South Australia', 'Tasmania', 'Australian Capital Territory', 'Northern Territory'] },
            { code: 'sg', name: 'Singapore', flagImg: 'https://flagcdn.com/w40/sg.png', dial: '+65', digits: 8, states: ['Central Region', 'East Region', 'North Region', 'West Region', 'North-East Region'] },
            { code: 'my', name: 'Malaysia', flagImg: 'https://flagcdn.com/w40/my.png', dial: '+60', digits: 9, states: ['Kuala Lumpur', 'Selangor', 'Penang', 'Johor', 'Perak', 'Sabah', 'Sarawak', 'Kedah', 'Pahang', 'Negeri Sembilan', 'Melaka', 'Kelantan', 'Terengganu'] },
            { code: 'sa', name: 'Saudi Arabia', flagImg: 'https://flagcdn.com/w40/sa.png', dial: '+966', digits: 9, states: ['Riyadh', 'Makkah', 'Eastern Province', 'Madinah', 'Asir', 'Tabuk', 'Al-Qassim', 'Hail', 'Jazan', 'Najran', 'Al-Bahah', 'Al-Jawf'] },
            { code: 'qa', name: 'Qatar', flagImg: 'https://flagcdn.com/w40/qa.png', dial: '+974', digits: 8, states: ['Doha', 'Al Rayyan', 'Al Wakrah', 'Al Khor', 'Umm Salal'] },
            { code: 'kw', name: 'Kuwait', flagImg: 'https://flagcdn.com/w40/kw.png', dial: '+965', digits: 8, states: ['Al Asimah (Capital)', 'Hawalli', 'Al Farwaniyah', 'Al Ahmadi', 'Jahra', 'Mubarak Al-Kabeer'] },
            { code: 'bh', name: 'Bahrain', flagImg: 'https://flagcdn.com/w40/bh.png', dial: '+973', digits: 8, states: ['Capital Governorate', 'Muharraq', 'Northern Governorate', 'Southern Governorate'] },
            { code: 'om', name: 'Oman', flagImg: 'https://flagcdn.com/w40/om.png', dial: '+968', digits: 8, states: ['Muscat', 'Dhofar', 'Musandam', 'Al Batinah', 'Al Dakhiliyah', 'Al Sharqiyah'] },
            { code: 'nz', name: 'New Zealand', flagImg: 'https://flagcdn.com/w40/nz.png', dial: '+64', digits: 9, states: ['Auckland', 'Canterbury', 'Wellington', 'Waikato', 'Bay of Plenty', 'Otago', 'Manawatu-Wanganui'] },
            { code: 'de', name: 'Germany', flagImg: 'https://flagcdn.com/w40/de.png', dial: '+49', digits: 10, states: ['Bavaria', 'Berlin', 'North Rhine-Westphalia', 'Baden-Württemberg', 'Hesse', 'Lower Saxony', 'Saxony', 'Hamburg'] },
            { code: 'fr', name: 'France', flagImg: 'https://flagcdn.com/w40/fr.png', dial: '+33', digits: 9, states: ['Île-de-France (Paris)', 'Auvergne-Rhône-Alpes', 'Provence-Alpes-Côte d\'Azur', 'Occitanie', 'Nouvelle-Aquitaine', 'Grand Est'] },
            { code: 'it', name: 'Italy', flagImg: 'https://flagcdn.com/w40/it.png', dial: '+39', digits: 10, states: ['Lombardy (Milan)', 'Lazio (Rome)', 'Campania (Naples)', 'Veneto', 'Piedmont', 'Tuscany', 'Sicily'] },
            { code: 'es', name: 'Spain', flagImg: 'https://flagcdn.com/w40/es.png', dial: '+34', digits: 9, states: ['Madrid', 'Catalonia (Barcelona)', 'Andalusia', 'Valencia', 'Galicia', 'Basque Country'] },
            { code: 'nl', name: 'Netherlands', flagImg: 'https://flagcdn.com/w40/nl.png', dial: '+31', digits: 9, states: ['North Holland (Amsterdam)', 'South Holland (Rotterdam)', 'Utrecht', 'North Brabant', 'Gelderland'] },
            { code: 'ch', name: 'Switzerland', flagImg: 'https://flagcdn.com/w40/ch.png', dial: '+41', digits: 9, states: ['Zurich', 'Geneva', 'Bern', 'Vaud', 'Basel-City', 'Lucerne', 'St. Gallen'] },
            { code: 'se', name: 'Sweden', flagImg: 'https://flagcdn.com/w40/se.png', dial: '+46', digits: 9, states: ['Stockholm', 'Västra Götaland (Gothenburg)', 'Skåne (Malmö)', 'Uppsala', 'Östergötland'] },
            { code: 'no', name: 'Norway', flagImg: 'https://flagcdn.com/w40/no.png', dial: '+47', digits: 8, states: ['Oslo', 'Viken', 'Vestland (Bergen)', 'Trøndelag', 'Rogaland'] },
            { code: 'dk', name: 'Denmark', flagImg: 'https://flagcdn.com/w40/dk.png', dial: '+45', digits: 8, states: ['Capital Region (Copenhagen)', 'Central Denmark (Aarhus)', 'Southern Denmark', 'North Denmark'] },
            { code: 'fi', name: 'Finland', flagImg: 'https://flagcdn.com/w40/fi.png', dial: '+358', digits: 9, states: ['Uusimaa (Helsinki)', 'Pirkanmaa (Tampere)', 'Southwest Finland (Turku)', 'North Ostrobothnia'] },
            { code: 'be', name: 'Belgium', flagImg: 'https://flagcdn.com/w40/be.png', dial: '+32', digits: 9, states: ['Brussels', 'Antwerp', 'East Flanders (Ghent)', 'Flemish Brabant', 'Walloon Brabant'] },
            { code: 'at', name: 'Austria', flagImg: 'https://flagcdn.com/w40/at.png', dial: '+43', digits: 10, states: ['Vienna', 'Lower Austria', 'Upper Austria', 'Styria', 'Tyrol', 'Salzburg'] },
            { code: 'ie', name: 'Ireland', flagImg: 'https://flagcdn.com/w40/ie.png', dial: '+353', digits: 9, states: ['Dublin', 'Cork', 'Galway', 'Limerick', 'Waterford'] },
            { code: 'pt', name: 'Portugal', flagImg: 'https://flagcdn.com/w40/pt.png', dial: '+351', digits: 9, states: ['Lisbon', 'Porto', 'Braga', 'Setúbal', 'Faro (Algarve)'] },
            { code: 'pl', name: 'Poland', flagImg: 'https://flagcdn.com/w40/pl.png', dial: '+48', digits: 9, states: ['Masovian (Warsaw)', 'Lesser Poland (Kraków)', 'Lower Silesian (Wrocław)', 'Silesian'] },
            { code: 'gr', name: 'Greece', flagImg: 'https://flagcdn.com/w40/gr.png', dial: '+30', digits: 10, states: ['Attica (Athens)', 'Central Macedonia (Thessaloniki)', 'Crete', 'Thessaly'] },
            { code: 'tr', name: 'Turkey', flagImg: 'https://flagcdn.com/w40/tr.png', dial: '+90', digits: 10, states: ['Istanbul', 'Ankara', 'Izmir', 'Bursa', 'Antalya', 'Adana'] },
            { code: 'ru', name: 'Russia', flagImg: 'https://flagcdn.com/w40/ru.png', dial: '+7', digits: 10, states: ['Moscow', 'Saint Petersburg', 'Novosibirsk', 'Yekaterinburg', 'Kazan'] },
            { code: 'za', name: 'South Africa', flagImg: 'https://flagcdn.com/w40/za.png', dial: '+27', digits: 9, states: ['Gauteng (Johannesburg)', 'Western Cape (Cape Town)', 'KwaZulu-Natal (Durban)', 'Eastern Cape'] },
            { code: 'eg', name: 'Egypt', flagImg: 'https://flagcdn.com/w40/eg.png', dial: '+20', digits: 10, states: ['Cairo', 'Alexandria', 'Giza', 'Qalyubia', 'Port Said', 'Suez'] },
            { code: 'mu', name: 'Mauritius', flagImg: 'https://flagcdn.com/w40/mu.png', dial: '+230', digits: 8, states: ['Port Louis', 'Plaines Wilhems', 'Pamplemousses', 'Flacq', 'Grand Port'] },
            { code: 'ke', name: 'Kenya', flagImg: 'https://flagcdn.com/w40/ke.png', dial: '+254', digits: 9, states: ['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Kiambu', 'Eldoret'] },
            { code: 'ng', name: 'Nigeria', flagImg: 'https://flagcdn.com/w40/ng.png', dial: '+234', digits: 10, states: ['Lagos', 'Kano', 'Abuja (FCT)', 'Rivers (Port Harcourt)', 'Oyo (Ibadan)'] },
            { code: 'lk', name: 'Sri Lanka', flagImg: 'https://flagcdn.com/w40/lk.png', dial: '+94', digits: 9, states: ['Western (Colombo)', 'Central (Kandy)', 'Southern (Galle)', 'Northern (Jaffna)', 'Eastern'] },
            { code: 'bd', name: 'Bangladesh', flagImg: 'https://flagcdn.com/w40/bd.png', dial: '+880', digits: 10, states: ['Dhaka', 'Chattogram', 'Sylhet', 'Rajshahi', 'Khulna', 'Barishal', 'Rangpur'] },
            { code: 'np', name: 'Nepal', flagImg: 'https://flagcdn.com/w40/np.png', dial: '+977', digits: 10, states: ['Bagmati (Kathmandu)', 'Gandaki (Pokhara)', 'Lumbini', 'Koshi', 'Madhesh'] },
            { code: 'th', name: 'Thailand', flagImg: 'https://flagcdn.com/w40/th.png', dial: '+66', digits: 9, states: ['Bangkok', 'Chiang Mai', 'Phuket', 'Chonburi (Pattaya)', 'Nonthaburi'] },
            { code: 'id', name: 'Indonesia', flagImg: 'https://flagcdn.com/w40/id.png', dial: '+62', digits: 10, states: ['Jakarta', 'West Java (Bandung)', 'East Java (Surabaya)', 'Bali', 'Central Java'] },
            { code: 'ph', name: 'Philippines', flagImg: 'https://flagcdn.com/w40/ph.png', dial: '+63', digits: 10, states: ['Metro Manila', 'Cebu', 'Davao', 'Calabarzon', 'Central Luzon'] },
            { code: 'vn', name: 'Vietnam', flagImg: 'https://flagcdn.com/w40/vn.png', dial: '+84', digits: 9, states: ['Ho Chi Minh City', 'Hanoi', 'Da Nang', 'Hai Phong', 'Can Tho'] },
            { code: 'jp', name: 'Japan', flagImg: 'https://flagcdn.com/w40/jp.png', dial: '+81', digits: 10, states: ['Tokyo', 'Osaka', 'Kanagawa (Yokohama)', 'Aichi (Nagoya)', 'Kyoto', 'Hokkaido (Sapporo)', 'Fukuoka'] },
            { code: 'kr', name: 'South Korea', flagImg: 'https://flagcdn.com/w40/kr.png', dial: '+82', digits: 10, states: ['Seoul', 'Gyeonggi', 'Busan', 'Incheon', 'Daegu', 'Daejeon'] },
            { code: 'cn', name: 'China', flagImg: 'https://flagcdn.com/w40/cn.png', dial: '+86', digits: 11, states: ['Guangdong (Guangzhou/Shenzhen)', 'Beijing', 'Shanghai', 'Zhejiang (Hangzhou)', 'Jiangsu'] },
            { code: 'hk', name: 'Hong Kong', flagImg: 'https://flagcdn.com/w40/hk.png', dial: '+852', digits: 8, states: ['Hong Kong Island', 'Kowloon', 'New Territories'] },
            { code: 'tw', name: 'Taiwan', flagImg: 'https://flagcdn.com/w40/tw.png', dial: '+886', digits: 9, states: ['Taipei', 'New Taipei', 'Taichung', 'Kaohsiung', 'Tainan'] },
            { code: 'br', name: 'Brazil', flagImg: 'https://flagcdn.com/w40/br.png', dial: '+55', digits: 11, states: ['São Paulo', 'Rio de Janeiro', 'Minas Gerais', 'Bahia', 'Paraná', 'Rio Grande do Sul'] },
            { code: 'mx', name: 'Mexico', flagImg: 'https://flagcdn.com/w40/mx.png', dial: '+52', digits: 10, states: ['Mexico City', 'Jalisco (Guadalajara)', 'Nuevo León (Monterrey)', 'Puebla', 'Yucatán'] },
            { code: 'ar', name: 'Argentina', flagImg: 'https://flagcdn.com/w40/ar.png', dial: '+54', digits: 10, states: ['Buenos Aires', 'Córdoba', 'Santa Fe (Rosario)', 'Mendoza', 'Tucumán'] },
            { code: 'cl', name: 'Chile', flagImg: 'https://flagcdn.com/w40/cl.png', dial: '+56', digits: 9, states: ['Santiago Metropolitan', 'Valparaíso', 'Biobío (Concepción)', 'Antofagasta'] },
            { code: 'co', name: 'Colombia', flagImg: 'https://flagcdn.com/w40/co.png', dial: '+57', digits: 10, states: ['Bogotá D.C.', 'Antioquia (Medellín)', 'Valle del Cauca (Cali)', 'Atlántico (Barranquilla)'] },
            { code: 'pe', name: 'Peru', flagImg: 'https://flagcdn.com/w40/pe.png', dial: '+51', digits: 9, states: ['Lima', 'Arequipa', 'Cusco', 'La Libertad (Trujillo)', 'Piura'] },
            { code: 'fj', name: 'Fiji', flagImg: 'https://flagcdn.com/w40/fj.png', dial: '+679', digits: 7, states: ['Central (Suva)', 'Western (Nadi/Lautoka)', 'Northern (Labasa)', 'Eastern'] }
        ];

        var selectedRole = 'Retailer';
        var selectedCountry = ALL_WORLD_COUNTRIES[0]; // Auto-selected: India (+91)
        var selectedState = 'Gujarat';

        /* Toggle Dropdown Menu */
        window.toggleDropdown = function(boxId) {
            var box = document.getElementById(boxId);
            var isCurrentlyActive = box.classList.contains('active');
            
            /* Close all dropdowns first */
            document.querySelectorAll('.custom-select-box').forEach(function(b){
                b.classList.remove('active');
            });

            if (!isCurrentlyActive) {
                box.classList.add('active');
                if (boxId === 'countrySelectBox') {
                    var sInput = document.getElementById('countrySearchInput');
                    if (sInput) {
                        sInput.value = '';
                        filterCountryOptions('');
                        setTimeout(function(){ sInput.focus(); }, 100);
                    }
                } else if (boxId === 'stateSelectBox') {
                    var sInput = document.getElementById('stateSearchInput');
                    if (sInput) {
                        sInput.value = '';
                        filterStateOptions('');
                        setTimeout(function(){ sInput.focus(); }, 100);
                    }
                }
            }
        };

        /* Close Dropdown on outside click */
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.custom-select-box')) {
                document.querySelectorAll('.custom-select-box').forEach(function(b){
                    b.classList.remove('active');
                });
            }
        });

        /* Filter Country Options */
        window.filterCountryOptions = function(query) {
            var q = (query || '').toLowerCase().trim();
            var list = document.getElementById('countryOptionsList');
            if (!list) return;

            var filtered = ALL_WORLD_COUNTRIES.filter(function(c) {
                return c.name.toLowerCase().includes(q) || c.dial.includes(q) || c.code.toLowerCase().includes(q);
            });

            var html = '';
            if (filtered.length === 0) {
                html = '<div style="padding:12px; font-size:0.78rem; color:var(--light-text); text-align:center; font-weight:600;">No matching country found</div>';
            } else {
                filtered.forEach(function(c) {
                    var isSel = c.code === selectedCountry.code;
                    html += `
                        <div class="custom-select-option ${isSel ? 'selected' : ''}" onclick="selectCountry('${c.code}')">
                            <img src="${c.flagImg}" alt="${c.name}" class="select-flag-img">
                            <span>${c.name} (${c.dial})</span>
                        </div>
                    `;
                });
            }
            list.innerHTML = html;
        };

        /* Filter State Options */
        window.filterStateOptions = function(query) {
            var q = (query || '').toLowerCase().trim();
            var list = document.getElementById('stateOptionsList');
            if (!list) return;

            var states = selectedCountry.states || ['Default Region'];
            var filtered = states.filter(function(st) {
                return st.toLowerCase().includes(q);
            });

            var html = '<div class="custom-select-option" onclick="selectState(\'Select State\')">Select State</div>';
            if (filtered.length === 0) {
                html += '<div style="padding:12px; font-size:0.78rem; color:var(--light-text); text-align:center; font-weight:600;">No matching state found</div>';
            } else {
                filtered.forEach(function(st) {
                    var isSel = st === selectedState;
                    html += `
                        <div class="custom-select-option ${isSel ? 'selected' : ''}" onclick="selectState('${st}')">
                            <span>${st}</span>
                        </div>
                    `;
                });
            }
            list.innerHTML = html;
        };

        /* Populate Country Dropdown */
        function renderCountryDropdown() {
            filterCountryOptions('');

            /* Update Trigger Display */
            var flagImg = document.getElementById('displayCountryFlag');
            var txt = document.getElementById('displayCountryText');
            if (flagImg) flagImg.src = selectedCountry.flagImg;
            if (txt) txt.textContent = `${selectedCountry.name} (${selectedCountry.dial})`;

            /* Update WhatsApp Prefix */
            var waFlag = document.getElementById('waFlagImg');
            var waDial = document.getElementById('waDialCode');
            var hint = document.getElementById('digitCountHint');

            if (waFlag) waFlag.src = selectedCountry.flagImg;
            if (waDial) waDial.textContent = `${selectedCountry.code.toUpperCase()} ${selectedCountry.dial}`;
            if (hint) hint.textContent = `${selectedCountry.digits}-digit number`;

            renderStateDropdown();
            validateWhatsAppDigits();
        }

        /* Populate State Dropdown */
        function renderStateDropdown() {
            filterStateOptions('');
            var txt = document.getElementById('displayStateText');
            if (txt) txt.textContent = selectedState;
        }

        window.selectCountry = function(code) {
            var found = ALL_WORLD_COUNTRIES.find(function(c) { return c.code === code; });
            if (found) {
                selectedCountry = found;
                selectedState = (found.states && found.states.length > 0) ? found.states[0] : 'Default Region';
                renderCountryDropdown();
            }
            var box = document.getElementById('countrySelectBox');
            if (box) box.classList.remove('active');
        };

        window.selectState = function(stateName) {
            selectedState = stateName;
            var txt = document.getElementById('displayStateText');
            if (txt) txt.textContent = stateName;

            var box = document.getElementById('stateSelectBox');
            if (box) box.classList.remove('active');
        };

        window.selectRole = function(role) {
            selectedRole = role;
            document.querySelectorAll('.role-pill-btn').forEach(function(c) {
                c.classList.toggle('selected', c.dataset.role === role);
            });
        };

        /* Validate WhatsApp Digits in real-time */
        window.validateWhatsAppDigits = function() {
            var input = document.getElementById('regPhone');
            var group = document.getElementById('waPhoneGroup');
            var errorMsg = document.getElementById('phoneErrorMsg');
            if (!input || !group || !errorMsg) return true;

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
            var userRaw = localStorage.getItem('dtbrands_user');
            var authCard = document.getElementById('authCardWrap');
            var dashWrap = document.getElementById('dashboardWrap');

            if (userRaw) {
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
                    var icon = r === 'Wholesaler' ? '📦' : (r === 'Reseller' ? '💼' : '🛍️');
                    roleEl.textContent = `${icon} ${r} Member`;
                }

                var role = (user.role || 'Retailer').toLowerCase();
                var wsBanner = document.getElementById('wsVipAccessBanner');
                var heroBtn = document.getElementById('dashHeroPortalBtn');
                var titleEl = document.getElementById('wsVipBannerTitle');
                var subEl = document.getElementById('wsVipBannerSubtitle');
                var linkEl = document.getElementById('wsVipBannerLink');

                if (role === 'wholesaler') {
                    if (wsBanner) wsBanner.style.display = 'flex';
                    if (titleEl) titleEl.textContent = '👑 Wholesaler B2B VIP Hub Ready';
                    if (subEl) subEl.textContent = 'Access bulk tier pricing, live courier dispatch tracking, GST billing, and procurement reports.';
                    if (linkEl) {
                        linkEl.href = '../../Frontend/Wholesale/wholesale.php';
                        linkEl.textContent = 'Open Wholesaler Portal →';
                    }
                    if (heroBtn) {
                        heroBtn.style.display = 'inline-flex';
                        heroBtn.href = '../../Frontend/Wholesale/wholesale.php';
                        heroBtn.innerHTML = '<span>📦 Open Wholesaler Dashboard</span><span>→</span>';
                    }
                } else if (role === 'retailer') {
                    if (wsBanner) wsBanner.style.display = 'flex';
                    if (titleEl) titleEl.textContent = '🛍️ Retailer B2B VIP Hub Ready';
                    if (subEl) subEl.textContent = 'Access retail catalog, GST billing invoices, margin discounts, live dispatch tracking, and wallet.';
                    if (linkEl) {
                        linkEl.href = '../../Frontend/Retailer/retailer.php';
                        linkEl.textContent = 'Open Retailer Portal →';
                    }
                    if (heroBtn) {
                        heroBtn.style.display = 'inline-flex';
                        heroBtn.href = '../../Frontend/Retailer/retailer.php';
                        heroBtn.innerHTML = '<span>🛍️ Open Retailer Dashboard</span><span>→</span>';
                    }
                } else if (role === 'reseller') {
                    if (wsBanner) wsBanner.style.display = 'flex';
                    if (titleEl) titleEl.textContent = '💼 Reseller B2B VIP Hub Ready';
                    if (subEl) subEl.textContent = 'Access reseller catalog, GST billing invoices, margin discounts, live dispatch tracking, and wallet.';
                    if (linkEl) {
                        linkEl.href = '../../Frontend/Reseller/reseller.php';
                        linkEl.textContent = 'Open Reseller Portal →';
                    }
                    if (heroBtn) {
                        heroBtn.style.display = 'inline-flex';
                        heroBtn.href = '../../Frontend/Reseller/reseller.php';
                        heroBtn.innerHTML = '<span>💼 Open Reseller Dashboard</span><span>→</span>';
                    }
                } else {
                    if (wsBanner) wsBanner.style.display = 'none';
                    if (heroBtn) heroBtn.style.display = 'none';
                }

                if (initEl) {
                    var parts = (user.name || 'Member').split(' ');
                    var initials = parts[0].charAt(0) + (parts[1] ? parts[1].charAt(0) : '');
                    initEl.textContent = initials.toUpperCase();
                }

                var cart = JSON.parse(localStorage.getItem('dtbrands_cart') || '[]');
                var wish = JSON.parse(localStorage.getItem('dtbrands_wishlist') || '[]');
                var cEl = document.getElementById('dashCartCount');
                var wEl = document.getElementById('dashWishCount');
                if (cEl) cEl.textContent = cart.reduce(function(s, i){ return s + (i.qty||1); }, 0);
                if (wEl) wEl.textContent = wish.length;
            } else {
                authCard.style.display = 'block';
                dashWrap.classList.remove('active');
                renderCountryDropdown();
                switchAuthTab(initialTab);
            }
        }

        window.switchAuthTab = function(tab) {
            var loginForm = document.getElementById('loginForm');
            var regForm = document.getElementById('registerForm');
            var forgotForm = document.getElementById('forgotForm');

            var btnLogin = document.getElementById('tabBtnLogin');
            var btnReg = document.getElementById('tabBtnRegister');

            var heading = document.getElementById('authHeading');
            var sub = document.getElementById('authSubheading');

            if (btnLogin) btnLogin.classList.toggle('active', tab === 'login');
            if (btnReg) btnReg.classList.toggle('active', tab === 'register');

            if (loginForm) loginForm.style.display = (tab === 'login') ? 'block' : 'none';
            if (regForm) regForm.style.display = (tab === 'register') ? 'block' : 'none';
            if (forgotForm) forgotForm.style.display = (tab === 'forgot') ? 'block' : 'none';

            if (tab === 'login') {
                heading.textContent = 'Sign In';
                sub.textContent = 'Access your account to track orders & explore collections';
            } else if (tab === 'register') {
                heading.textContent = 'Create Account';
                sub.textContent = 'Join DT Brand\'s & enjoy personalized shopping';
                renderCountryDropdown();
            } else if (tab === 'forgot') {
                heading.textContent = 'Reset Password';
                sub.textContent = 'Instant OTP & Password Recovery via WhatsApp';
            }
        };

        window.handleLoginSubmit = function() {
            var input = document.getElementById('loginPhone').value.trim();
            var passEl = document.getElementById('loginPass');
            var pass = passEl ? passEl.value.trim() : '123456';
            if (!input) {
                alert('Please enter your phone or email.');
                return;
            }

            var params = new URLSearchParams();
            params.append('action', 'login');
            params.append('identity', input);
            params.append('password', pass);

            fetch('/api/auth/index.php', {
                method: 'POST',
                body: params
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data.success && data.user) {
                    var u = data.user;
                    var roleName = u.type === 'wholesale' ? 'Wholesaler' : (u.type === 'reseller' ? 'Reseller' : 'Retailer');
                    var userData = {
                        id: u.id,
                        name: u.name,
                        phone: u.phone,
                        email: u.email || 'member@dtbrands.com',
                        role: roleName,
                        tier: u.tier || 'Standard',
                        credit_limit: u.credit_limit || 0,
                        country: 'India',
                        state: u.state || 'Gujarat',
                        city: u.city || 'Surat'
                    };
                    localStorage.setItem('dtbrands_user', JSON.stringify(userData));
                    checkUserAuth();
                } else {
                    alert(data.message || 'Login failed.');
                }
            })
            .catch(function(_err) {
                var name = input.includes('@') ? input.split('@')[0] : 'Luxury Member';
                name = name.charAt(0).toUpperCase() + name.slice(1);
                var userData = {
                    name: name,
                    phone: input.includes('@') ? '+91 98765 43210' : '+91 ' + input,
                    email: input.includes('@') ? input : 'member@dtbrands.com',
                    role: 'Retailer',
                    country: 'India',
                    state: 'Gujarat',
                    city: 'Surat'
                };
                localStorage.setItem('dtbrands_user', JSON.stringify(userData));
                checkUserAuth();
            });
        };

        window.handleRegisterSubmit = function() {
            var name = document.getElementById('regName').value.trim();
            var phone = document.getElementById('regPhone').value.trim();
            var city = document.getElementById('regCity').value.trim();
            var passEl = document.getElementById('regPass');
            var pass = passEl ? passEl.value.trim() : '123456';

            if (!name) {
                alert('Please enter your Full Name.');
                return;
            }

            var expected = selectedCountry.digits || 10;
            if (!phone || phone.length !== expected) {
                alert('Please enter a valid ' + expected + '-digit WhatsApp number for ' + selectedCountry.name + '.');
                document.getElementById('regPhone').focus();
                return;
            }

            var typeCode = selectedRole === 'Wholesaler' ? 'wholesale' : (selectedRole === 'Reseller' ? 'reseller' : 'retail');
            var fullPhone = selectedCountry.dial + ' ' + phone;

            var params = new URLSearchParams();
            params.append('action', 'register');
            params.append('name', name);
            params.append('phone', fullPhone);
            params.append('email', phone + '@dtbrands.in');
            params.append('password', pass);
            params.append('type', typeCode);
            params.append('city', city || 'Surat');
            params.append('state', selectedState);

            fetch('/api/auth/index.php', {
                method: 'POST',
                body: params
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data.success && data.user) {
                    var u = data.user;
                    var userData = {
                        id: u.id,
                        name: u.name,
                        phone: u.phone,
                        rawPhone: phone,
                        role: selectedRole,
                        country: selectedCountry.name,
                        countryCode: selectedCountry.code,
                        dial: selectedCountry.dial,
                        state: selectedState,
                        city: city || 'Surat'
                    };
                    localStorage.setItem('dtbrands_user', JSON.stringify(userData));
                    checkUserAuth();
                } else {
                    alert(data.message || 'Registration failed.');
                }
            })
            .catch(function(_err) {
                var userData = {
                    name: name,
                    phone: selectedCountry.dial + ' ' + phone,
                    rawPhone: phone,
                    role: selectedRole,
                    country: selectedCountry.name,
                    countryCode: selectedCountry.code,
                    dial: selectedCountry.dial,
                    state: selectedState,
                    city: city || 'Surat'
                };
                localStorage.setItem('dtbrands_user', JSON.stringify(userData));
                checkUserAuth();
            });
        };

        window.handleForgotSubmit = function() {
            var input = document.getElementById('forgotInput').value.trim();
            if (!input) return;

            var waUrl = `https://api.whatsapp.com/send?phone=917046363528&text=Hi%2C%20I%20need%20a%20password%20reset%20link%20for%20my%20DT Brand's%20account%20(${encodeURIComponent(input)})`;
            window.open(waUrl, '_blank');
            alert('📩 Password reset request sent to WhatsApp Concierge!');
        };

        window.handleLogoutClick = function() {
            localStorage.removeItem('dtbrands_user');
            window.location.href = '../../shop';
        };

        /* Run on Page Load */
        document.addEventListener('DOMContentLoaded', function() {
            checkUserAuth();
        });
    })();
    </script>
</body>
</html>
