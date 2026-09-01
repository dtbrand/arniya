<?php
/**
 * account.php — Dedicated Ultra-Luxury Customer Account & VIP Hub
 * DT Brand's & Jai Hanuman Tex — Master Architecture Standard
 * 100% Fluid Responsive with Editorial Split-Hero Layout, Next-Gen Auth Studio,
 * Dynamic Real-Time Live Order History, and Official Shop Header/Footer Integration.
 */

require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/Auth.php';
require_once __DIR__ . '/src/ProductCatalog.php';

$page_title = "My Account & VIP Lounge — DT Brand's | Ethnic Luxury";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    
    <!-- Google Fonts: Inter & Plus Jakarta Sans & Cinzel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800;900&family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Master Brand Theme CSS -->
    <link rel="stylesheet" href="/assets/css/home.css?v=<?php echo time(); ?>">

    <style>
        :root {
            --dt-gold: #8A681F;
            --dt-gold-bright: #D4AF37;
            --dt-gold-light: #E6CA65;
            --dt-gold-pale: #FAF5E8;
            --dt-gold-border: rgba(138, 104, 31, 0.25);
            --dt-dark: #181512;
            --dt-dark-soft: #2A241E;
            --dt-text-main: #111827;
            --dt-text-sub: #4B5563;
            --dt-text-muted: #64748B;
            --dt-bg-canvas: #F8FAF9;
            --dt-white: #FFFFFF;
            --font-serif: 'Cinzel', Georgia, serif;
            --font-sans: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            --radius-lg: 16px;
            --radius-xl: 22px;
            --shadow-subtle: 0 4px 20px rgba(0,0,0,0.06);
            --shadow-gold: 0 10px 30px rgba(138,104,31,0.18);
        }

        @property --dt-border-angle {
            syntax: "<angle>";
            inherits: false;
            initial-value: 0deg;
        }
        @keyframes dtBorderRotate {
            to { --dt-border-angle: 360deg; }
        }
        @keyframes dtGoldPlatinumGlow {
            0% { box-shadow: 0 0 8px rgba(212, 175, 55, 0.35); }
            100% { box-shadow: 0 0 18px rgba(212, 175, 55, 0.65); }
        }

        body {
            font-family: var(--font-sans);
            background: var(--dt-bg-canvas);
            color: var(--dt-text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            margin: 0;
            padding: 0;
        }

        .page-wrapper {
            flex: 1;
            width: 100%;
        }

        /* ── Main Canvas Wrapper ── */
        .ac-main-canvas {
            width: 100%;
            max-width: 1240px;
            margin: 0 auto;
            padding: clamp(20px, 4vw, 40px) clamp(16px, 3vw, 32px);
            box-sizing: border-box;
        }

        /* ── Breadcrumb Bar ── */
        .ac-breadcrumb-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            font-size: 0.82rem;
        }
        .ac-breadcrumb-list {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--dt-text-muted);
            font-weight: 600;
        }
        .ac-breadcrumb-list a {
            color: var(--dt-text-muted);
            text-decoration: none;
            transition: color 0.15s ease;
        }
        .ac-breadcrumb-list a:hover {
            color: var(--dt-gold);
        }
        .ac-breadcrumb-sep {
            color: #CBD5E1;
        }
        .ac-breadcrumb-current {
            color: var(--dt-gold);
            font-weight: 700;
        }
        .ac-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            border: 1.2px solid var(--dt-gold-border);
            background: var(--dt-white);
            color: var(--dt-gold);
            font-size: 0.78rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .ac-back-btn:hover {
            background: var(--dt-gold-pale);
            border-color: var(--dt-gold);
            transform: translateY(-1px);
        }

        /* ═══════════════════════════════════════════════════════════════════
           VIEW 1: NEXT-GEN LUXURY SPLIT AUTH EXPERIENCE (GUEST USERS)
        ═══════════════════════════════════════════════════════════════════ */
        .ac-auth-split-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 28px;
            align-items: stretch;
        }
        @media (min-width: 960px) {
            .ac-auth-split-grid {
                grid-template-columns: 1.05fr 1fr;
                gap: 36px;
            }
        }

        /* ── Left Designer E-Commerce Showcase ── */
        .ac-hero-showcase {
            background: linear-gradient(145deg, #FFFFFF 0%, #FAF6EE 50%, #F5EDE0 100%);
            border-radius: var(--radius-xl);
            border: 1.5px solid var(--dt-gold-border);
            padding: clamp(24px, 4vw, 36px);
            color: var(--dt-text-main);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(138,104,31,0.08);
        }
        .ac-hero-showcase::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3.5px;
            background: linear-gradient(90deg, #8A681F, #D4AF37, #E6CA65, #D4AF37, #8A681F);
        }
        .ac-showcase-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            background: #FAF5E8;
            border: 1px solid var(--dt-gold);
            color: var(--dt-gold);
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            width: fit-content;
            margin-bottom: 14px;
        }
        .ac-showcase-title {
            font-family: var(--font-serif);
            font-size: clamp(1.35rem, 3vw, 1.85rem);
            font-weight: 800;
            color: #181512;
            letter-spacing: 0.02em;
            line-height: 1.2;
            margin: 0 0 6px 0;
        }
        .ac-showcase-subtitle {
            font-size: 0.85rem;
            color: #64748B;
            font-weight: 600;
            line-height: 1.4;
            margin: 0 0 22px 0;
        }
        .ac-benefits-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 22px;
        }
        .ac-benefit-card {
            display: flex;
            align-items: center;
            gap: 14px;
            background: #FFFFFF;
            border: 1.2px solid rgba(138,104,31,0.2);
            border-radius: 12px;
            padding: 12px 16px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }
        .ac-benefit-card:hover {
            background: #FAF8F4;
            border-color: var(--dt-gold);
            transform: translateX(3px);
            box-shadow: 0 4px 14px rgba(138,104,31,0.1);
        }
        .ac-benefit-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, #FAF5E8 0%, #F5ECCE 100%);
            border: 1.2px solid var(--dt-gold);
            color: var(--dt-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 6px rgba(138,104,31,0.15);
        }
        .ac-benefit-icon svg {
            width: 18px;
            height: 18px;
            stroke: var(--dt-gold);
            stroke-width: 2.2;
            fill: none;
        }
        .ac-benefit-title {
            font-size: 0.88rem;
            font-weight: 800;
            color: #181512;
            margin-bottom: 2px;
        }
        .ac-benefit-desc {
            font-size: 0.76rem;
            color: #64748B;
            font-weight: 500;
            line-height: 1.35;
        }
        .ac-showcase-footer {
            border-top: 1px dashed var(--dt-gold-border);
            padding-top: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.75rem;
            color: #64748B;
            font-weight: 600;
        }
        .ac-trust-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #16A34A;
            display: inline-block;
            margin-right: 6px;
            box-shadow: 0 0 8px #16A34A;
        }

        /* ── Right Auth Studio Card ── */
        .ac-auth-card {
            background: #FFFFFF;
            border-radius: var(--radius-xl);
            border: 1.5px solid var(--dt-gold);
            box-shadow: 0 12px 40px rgba(138,104,31,0.12), 0 0 0 1px rgba(255,255,255,0.6) inset;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .ac-auth-card-head {
            padding: 24px 28px 16px;
            border-bottom: 1.5px solid #F1ECE1;
            background: #FAF8F4;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .ac-brand-lockup {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .ac-brand-logo-img {
            height: 38px;
            width: auto;
            max-width: 170px;
            object-fit: contain;
        }
        .ac-security-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.68rem;
            font-weight: 700;
            color: #15803D;
            background: #DCFCE7;
            padding: 3px 8px;
            border-radius: 12px;
            border: 1px solid #86EFAC;
        }

        /* ── Segmented Gold Pill Switcher (Sign In | Create Account) ── */
        .ac-pill-switcher {
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #EFE8D6;
            border-radius: 30px;
            padding: 4px;
            border: 1px solid var(--dt-gold-border);
        }
        .ac-pill-btn {
            padding: 10px 16px;
            border: none;
            border-radius: 26px;
            background: transparent;
            font-family: var(--font-sans);
            font-size: 0.84rem;
            font-weight: 800;
            color: #635A4D;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-align: center;
        }
        .ac-pill-btn.active {
            background: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%);
            color: #111827;
            box-shadow: 0 4px 14px rgba(184,134,11,0.35);
            transform: scale(1.01);
        }

        /* ── Form Body & Floating Inputs ── */
        .ac-auth-card-body {
            padding: 24px 28px 28px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .ac-form-pane {
            display: none;
            flex-direction: column;
            gap: 16px;
            animation: acFadeIn 0.2s ease-out;
        }
        .ac-form-pane.active {
            display: flex;
        }
        @keyframes acFadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .ac-field-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            position: relative;
        }
        .ac-field-label {
            font-size: 0.76rem;
            font-weight: 800;
            color: #1F2937;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .ac-field-label .req {
            color: #DC2626;
            margin-left: 2px;
        }

        .ac-input-wrapper {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
        }
        .ac-input-icon {
            position: absolute;
            left: 14px;
            width: 18px;
            height: 18px;
            stroke: var(--dt-gold);
            stroke-width: 2.2;
            fill: none;
            pointer-events: none;
            opacity: 0.85;
        }
        .ac-text-input {
            width: 100%;
            height: 48px;
            border-radius: 10px;
            border: 1.5px solid #D1D5DB;
            background: #FFFFFF;
            padding: 0 14px 0 42px;
            font-family: var(--font-sans);
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--dt-text-main);
            outline: none;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }
        .ac-text-input.no-icon {
            padding-left: 14px;
        }
        .ac-text-input:focus {
            outline: none !important;
            border: 2px solid transparent !important;
            background: linear-gradient(#FFFFFF, #FFFFFF) padding-box,
                        conic-gradient(from var(--dt-border-angle), #D4AF37 0deg, #FFFFFF 60deg, #E2E8F0 120deg, #D4AF37 180deg, #FFFFFF 240deg, #B8860B 300deg, #D4AF37 360deg) border-box !important;
            animation: dtBorderRotate 2s linear infinite, dtGoldPlatinumGlow 1.5s ease-in-out infinite alternate !important;
            color: #111827 !important;
        }

        .ac-pwd-toggle {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--dt-text-muted);
            display: flex;
            align-items: center;
            padding: 4px;
        }
        .ac-pwd-toggle svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        /* ── Country Flag Dropdown ── */
        .ac-custom-select {
            position: relative;
            width: 100%;
        }
        .ac-select-trigger {
            width: 100%;
            height: 48px;
            border: 1.5px solid #D1D5DB;
            border-radius: 10px;
            padding: 0 14px;
            background: #FFFFFF;
            color: var(--dt-text-main);
            font-size: 0.9rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: all 0.2s ease;
            box-sizing: border-box;
        }
        .ac-select-trigger:hover, .ac-custom-select.active .ac-select-trigger {
            border-color: var(--dt-gold);
            box-shadow: 0 0 0 3px rgba(138,104,31,0.15);
        }
        .ac-select-menu {
            position: absolute;
            top: calc(100% + 4px);
            left: 0; right: 0;
            background: #FFFFFF;
            border: 1.5px solid var(--dt-gold);
            border-radius: 12px;
            box-shadow: 0 12px 36px rgba(0,0,0,0.18);
            max-height: 260px;
            z-index: 1000;
            display: none;
            flex-direction: column;
            overflow: hidden;
        }
        .ac-custom-select.active .ac-select-menu {
            display: flex;
        }
        .ac-select-search {
            padding: 8px 12px;
            background: #FAF8F4;
            border-bottom: 1px solid #E2DFD7;
        }
        .ac-select-search input {
            width: 100%;
            height: 34px;
            border: 1px solid #CBD5E1;
            border-radius: 6px;
            padding: 0 10px;
            font-size: 0.82rem;
            font-weight: 600;
            outline: none;
            box-sizing: border-box;
        }
        .ac-select-options {
            overflow-y: auto;
            flex: 1;
            max-height: 200px;
        }
        .ac-select-option {
            padding: 9px 14px;
            font-size: 0.86rem;
            font-weight: 600;
            color: #1F2937;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.15s ease;
        }
        .ac-select-option:hover {
            background: var(--dt-gold-pale);
            color: var(--dt-gold);
        }
        .ac-flag-img {
            width: 22px;
            height: 15px;
            border-radius: 2px;
            object-fit: cover;
            border: 1px solid rgba(0,0,0,0.1);
        }

        /* ── WhatsApp Phone Input Group ── */
        .ac-phone-input-group {
            display: flex;
            border: 1.5px solid #D1D5DB;
            border-radius: 10px;
            overflow: hidden;
            background: #FFFFFF;
            transition: all 0.2s ease;
        }
        .ac-phone-input-group:focus-within {
            border-color: var(--dt-gold);
            box-shadow: 0 0 0 3px rgba(138,104,31,0.18);
        }
        .ac-phone-prefix {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 0 12px;
            background: #FAF5E8;
            border-right: 1.5px solid #E2DFD7;
            font-size: 0.86rem;
            font-weight: 800;
            color: var(--dt-gold);
            user-select: none;
            flex-shrink: 0;
        }
        .ac-phone-input {
            flex: 1;
            height: 48px;
            border: none;
            outline: none;
            padding: 0 14px;
            font-family: var(--font-sans);
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--dt-text-main);
            width: 100%;
            background: transparent;
        }

        /* ── Role Selection Pill Cards ── */
        .ac-role-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }
        .ac-role-card {
            border: 1.5px solid #E2DFD7;
            background: #FAF8F4;
            border-radius: 10px;
            padding: 10px 6px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
        }
        .ac-role-card:hover {
            border-color: var(--dt-gold);
            background: var(--dt-gold-pale);
        }
        .ac-role-card.active {
            border-color: var(--dt-gold);
            background: #FAF5E8;
            box-shadow: 0 2px 8px rgba(138,104,31,0.25);
        }
        .ac-role-icon {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ac-role-icon svg {
            width: 22px;
            height: 22px;
        }
        .ac-role-name {
            font-size: 0.74rem;
            font-weight: 800;
            color: #1F2937;
        }
        .ac-role-card.active .ac-role-name {
            color: var(--dt-gold);
        }

        /* ── 100% Styled Master Primary Button ── */
        .dt-btn-gold {
            width: 100%;
            height: 48px;
            border-radius: 10px;
            border: 1px solid #8A681F;
            background: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%);
            color: #111827;
            font-family: var(--font-sans);
            font-size: 0.9rem;
            font-weight: 800;
            letter-spacing: -0.011em;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.4), 0 2px 8px rgba(184,134,11,0.35);
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .dt-btn-gold:hover {
            background: linear-gradient(135deg, #C59312 0%, #DFC04E 50%, #F0D77B 100%);
            transform: translateY(-1px);
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.5), 0 4px 14px rgba(184,134,11,0.48);
        }
        .dt-btn-emerald {
            width: 100%;
            height: 44px;
            border-radius: 10px;
            border: 1px solid #15803D;
            background: linear-gradient(135deg, #15803D 0%, #16A34A 100%);
            color: #FFFFFF;
            font-family: var(--font-sans);
            font-size: 0.86rem;
            font-weight: 800;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(21,128,61,0.3);
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .dt-btn-emerald:hover {
            background: linear-gradient(135deg, #166534 0%, #15803D 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(21,128,61,0.42);
        }

        /* ═══════════════════════════════════════════════════════════════════
           VIEW 2: LOGGED-IN VIP DASHBOARD
        ═══════════════════════════════════════════════════════════════════ */
        .ac-dashboard-wrap {
            display: none;
            flex-direction: column;
            gap: 24px;
        }
        .ac-dashboard-wrap.active {
            display: flex;
        }

        .ac-profile-card {
            background: linear-gradient(145deg, #181512 0%, #2A241E 60%, #15120E 100%);
            border-radius: var(--radius-xl);
            border: 1.5px solid var(--dt-gold);
            padding: clamp(20px, 4vw, 32px);
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            box-shadow: 0 12px 36px rgba(0,0,0,0.18);
            position: relative;
            overflow: hidden;
        }
        .ac-profile-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .ac-avatar-ring {
            width: clamp(56px, 10vw, 72px);
            height: clamp(56px, 10vw, 72px);
            border-radius: 50%;
            background: linear-gradient(135deg, #B8860B 0%, #D4AF37 100%);
            color: #111827;
            font-family: var(--font-serif);
            font-size: clamp(1.4rem, 3.5vw, 1.8rem);
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #FFFFFF;
            box-shadow: 0 4px 16px rgba(184,134,11,0.4);
            flex-shrink: 0;
        }
        .ac-profile-name {
            font-family: var(--font-serif);
            font-size: clamp(1.2rem, 3.5vw, 1.5rem);
            font-weight: 800;
            color: #FAF5E8;
            margin: 0 0 4px 0;
        }
        .ac-profile-phone {
            font-size: 0.85rem;
            color: #D6CCA8;
            font-weight: 600;
        }
        .ac-tier-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 12px;
            background: rgba(212, 175, 55, 0.2);
            border: 1px solid var(--dt-gold-bright);
            color: #E6CA65;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-top: 6px;
        }
        .ac-logout-btn {
            padding: 8px 18px;
            border-radius: 20px;
            border: 1.2px solid rgba(255,255,255,0.4);
            background: rgba(255,255,255,0.08);
            color: #FFFFFF;
            font-size: 0.78rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .ac-logout-btn:hover {
            background: #DC2626;
            border-color: #DC2626;
        }

        /* Dashboard Grid */
        .ac-dash-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }
        @media (min-width: 900px) {
            .ac-dash-grid {
                grid-template-columns: 2fr 1fr;
            }
        }

        .ac-card-panel {
            background: #FFFFFF;
            border: 1.5px solid var(--dt-gold-border);
            border-radius: var(--radius-lg);
            padding: clamp(18px, 3.5vw, 24px);
            box-shadow: var(--shadow-subtle);
        }
        .ac-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 14px;
            margin-bottom: 18px;
            border-bottom: 1.5px dashed var(--dt-gold-border);
        }
        .ac-card-title {
            font-family: var(--font-serif);
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--dt-gold);
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }
        .ac-card-title svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
        }

        /* Order Box Styling */
        .order-box {
            background: #FAF8F4;
            border: 1.2px solid #E2DFD7;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 14px;
            transition: all 0.2s ease;
        }
        .order-box:hover {
            border-color: var(--dt-gold);
            background: #FFFFFF;
            box-shadow: 0 4px 14px rgba(138,104,31,0.08);
        }
        .order-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #EAE6DC;
            margin-bottom: 12px;
        }
        .order-id {
            font-family: var(--font-serif);
            font-size: 0.95rem;
            font-weight: 800;
            color: #111827;
        }
        .order-status-badge {
            padding: 3px 10px;
            border-radius: 14px;
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .status-pending { background: #FEF3C7; color: #92400E; border: 1px solid #FCD34D; }
        .status-confirmed { background: #EFF6FF; color: #1E40AF; border: 1px solid #BFDBFE; }
        .status-processing { background: #FFF3E0; color: #E65100; border: 1px solid #FFE082; }
        .status-packed { background: #FAF5E8; color: #8A681F; border: 1px solid #D4AF37; }
        .status-shipped { background: #F0FDF4; color: #166534; border: 1px solid #BBF7D0; }
        .status-out-for-delivery, .status-out_for_delivery { background: #EEF2FF; color: #3730A3; border: 1px solid #C7D2FE; }
        .status-delivered { background: #E8F5E9; color: #2E7D32; border: 1px solid #A5D6A7; }
        .status-cancelled { background: #FEF2F2; color: #991B1B; border: 1px solid #FECACA; }
        .status-refunded { background: #F5F3FF; color: #5B21B6; border: 1px solid #DDD6FE; }

        .order-thumb {
            width: 48px;
            height: 62px;
            aspect-ratio: 3 / 4;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid #E2DFD7;
        }

        /* Stat tiles */
        .ac-stat-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 20px;
        }
        .ac-stat-card {
            background: #FFFFFF;
            border: 1.5px solid var(--dt-gold-border);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            text-decoration: none;
            color: var(--dt-text-main);
            transition: all 0.2s ease;
        }
        .ac-stat-card:hover {
            border-color: var(--dt-gold);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(138,104,31,0.12);
        }
        .ac-stat-num {
            font-family: var(--font-serif);
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--dt-gold);
            margin-bottom: 2px;
        }
        .ac-stat-lbl {
            font-size: 0.76rem;
            font-weight: 700;
            color: var(--dt-text-muted);
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <!-- ════════════ OFFICIAL MASTER SHOP HEADER ════════════ -->
    <?php include_once __DIR__ . '/includes/shophader.php'; ?>

    <div class="page-wrapper">
        <!-- ════════════ MAIN CONTENT CANVAS ════════════ -->
        <main class="ac-main-canvas">
            
            <!-- Breadcrumb & Return Bar -->
            <div class="ac-breadcrumb-bar">
                <div class="ac-breadcrumb-list">
                    <a href="/">Home</a>
                    <span class="ac-breadcrumb-sep">/</span>
                    <span class="ac-breadcrumb-current" id="acBreadcrumbTitle">My Account</span>
                </div>
                <a href="/shop.php" class="ac-back-btn">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    <span>Back to Shop</span>
                </a>
            </div>

            <!-- ════════════ VIEW 1: AUTHENTICATION FOR GUESTS ════════════ -->
            <div id="authCardWrap" class="ac-auth-split-grid">
                
                <!-- Left Designer E-Commerce Showcase -->
                <div class="ac-hero-showcase">
                    <div>
                        <div class="ac-showcase-badge">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <span>VIP Member Privileges</span>
                        </div>
                        <h1 class="ac-showcase-title">Welcome to DT Brand's</h1>
                        <p class="ac-showcase-subtitle">Surat's Premier Silk Handloom &amp; Wholesale Depot</p>

                        <div class="ac-benefits-list">
                            <div class="ac-benefit-card">
                                <div class="ac-benefit-icon">
                                    <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                </div>
                                <div>
                                    <div class="ac-benefit-title">100% Silk Mark Certified</div>
                                    <div class="ac-benefit-desc">Authentic pure handloom weaves with tested zari.</div>
                                </div>
                            </div>

                            <div class="ac-benefit-card">
                                <div class="ac-benefit-icon">
                                    <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                                </div>
                                <div>
                                    <div class="ac-benefit-title">Wholesale &amp; Reseller Margins</div>
                                    <div class="ac-benefit-desc">Exclusive direct mill-rate bulk pricing &amp; GST invoices.</div>
                                </div>
                            </div>

                            <div class="ac-benefit-card">
                                <div class="ac-benefit-icon">
                                    <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                </div>
                                <div>
                                    <div class="ac-benefit-title">Express Dispatch &amp; Live Tracking</div>
                                    <div class="ac-benefit-desc">Instant live courier AWB updates via WhatsApp.</div>
                                </div>
                            </div>

                            <div class="ac-benefit-card">
                                <div class="ac-benefit-icon">
                                    <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                </div>
                                <div>
                                    <div class="ac-benefit-title">Personal Fashion Concierge</div>
                                    <div class="ac-benefit-desc">1-on-1 styling, custom tailoring &amp; video lot view.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ac-showcase-footer">
                        <div><span class="ac-trust-dot"></span> 25,000+ Happy Clients • 1,400+ Boutiques</div>
                        <div style="font-weight: 800; color: #8A681F;">Surat Loom Depot</div>
                    </div>
                </div>

                <!-- Right Auth Studio Form Card -->
                <div class="ac-auth-card">
                    <div class="ac-auth-card-head">
                        <div class="ac-brand-lockup">
                            <img src="/assets/images/logo.png" onerror="this.src='/assets/images/logo.png';" alt="DT Brand's" class="ac-brand-logo-img">
                            <span class="ac-security-badge">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                <span>256-Bit SSL</span>
                            </span>
                        </div>

                        <!-- Smooth Segmented Pill Switcher -->
                        <div class="ac-pill-switcher">
                            <button type="button" class="ac-pill-btn active" id="tabBtnLogin" onclick="switchAuthTab('login')">Sign In</button>
                            <button type="button" class="ac-pill-btn" id="tabBtnRegister" onclick="switchAuthTab('register')">Create Account</button>
                        </div>
                    </div>

                    <div class="ac-auth-card-body">
                        
                        <!-- 1. SIGN IN FORM -->
                        <form id="loginForm" class="ac-form-pane active" onsubmit="event.preventDefault(); handleLoginSubmit();">
                            <div class="ac-field-group">
                                <label class="ac-field-label" for="loginPhone">WhatsApp Number or Email <span class="req">*</span></label>
                                <div class="ac-input-wrapper">
                                    <svg class="ac-input-icon" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                    <input type="text" id="loginPhone" class="ac-text-input" placeholder="e.g. 7046363528 or client@example.com" required autocomplete="username">
                                </div>
                            </div>

                            <div class="ac-field-group">
                                <label class="ac-field-label" for="loginPass">
                                    <span>Password <span class="req">*</span></span>
                                    <a href="javascript:void(0)" onclick="switchAuthTab('forgot')" style="color:var(--dt-gold); font-weight:700; text-decoration:underline; font-size:0.75rem;">Forgot Password?</a>
                                </label>
                                <div class="ac-input-wrapper">
                                    <svg class="ac-input-icon" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input type="password" id="loginPass" class="ac-text-input" placeholder="Enter your secret password" required autocomplete="current-password">
                                    <button type="button" class="ac-pwd-toggle" onclick="togglePwdVisibility('loginPass', this)" title="Show/Hide Password">
                                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="dt-btn-gold" id="loginSubmitBtn">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                                <span>Sign In to VIP Lounge</span>
                            </button>

                            <div style="display:flex; align-items:center; gap:10px; margin: 4px 0;">
                                <div style="flex:1; height:1px; background:#E2DFD7;"></div>
                                <span style="font-size:0.74rem; color:#94A3B8; font-weight:700; text-transform:uppercase;">Or Instant Connect</span>
                                <div style="flex:1; height:1px; background:#E2DFD7;"></div>
                            </div>

                            <a href="https://api.whatsapp.com/send?phone=917046363528&text=Hi%20DT%20Brand%27s%2C%20I%20would%20like%20to%20sign%20in%20to%20my%20account" target="_blank" class="dt-btn-emerald">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                <span>Sign In via WhatsApp Concierge</span>
                            </a>
                        </form>

                        <!-- 2. CREATE ACCOUNT FORM -->
                        <form id="registerForm" class="ac-form-pane" onsubmit="event.preventDefault(); handleRegisterSubmit();">
                            
                            <!-- Full Name -->
                            <div class="ac-field-group">
                                <label class="ac-field-label" for="regName">Full Name <span class="req">*</span></label>
                                <div class="ac-input-wrapper">
                                    <svg class="ac-input-icon" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <input type="text" id="regName" class="ac-text-input" placeholder="e.g. Radhika Sharma" required autocomplete="name">
                                </div>
                            </div>

                            <!-- Country Selection Dropdown -->
                            <div class="ac-field-group">
                                <label class="ac-field-label">Country <span class="req">*</span></label>
                                <div class="ac-custom-select" id="countrySelectBox">
                                    <div class="ac-select-trigger" onclick="toggleDropdown('countrySelectBox')">
                                        <div style="display:flex; align-items:center; gap:8px;">
                                            <img src="https://flagcdn.com/w40/in.png" alt="India" class="ac-flag-img" id="displayCountryFlag">
                                            <span id="displayCountryText">India (+91)</span>
                                        </div>
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                    </div>
                                    <div class="ac-select-menu" id="countryDropdownMenu">
                                        <div class="ac-select-search">
                                            <input type="text" id="countrySearchInput" placeholder="🔍 Search world countries..." oninput="filterCountryOptions(this.value)" onclick="event.stopPropagation()">
                                        </div>
                                        <div class="ac-select-options" id="countryOptionsList">
                                            <!-- Dynamically Populated -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Mobile Number Input -->
                            <div class="ac-field-group">
                                <label class="ac-field-label" for="regPhone">
                                    <span>WhatsApp Number <span class="req">*</span></span>
                                    <span id="digitCountHint" style="font-size:0.7rem; color:var(--dt-text-muted); font-weight:600;">10-digit number</span>
                                </label>
                                <div class="ac-phone-input-group">
                                    <div class="ac-phone-prefix">
                                        <img id="waFlagImg" class="ac-flag-img" src="https://flagcdn.com/w40/in.png" alt="Flag">
                                        <span id="waDialCode">+91</span>
                                    </div>
                                    <input type="tel" id="regPhone" class="ac-phone-input" placeholder="10-digit WhatsApp number" maxlength="12" required autocomplete="tel" oninput="validateWhatsAppDigits()">
                                </div>
                                <div id="phoneErrorMsg" style="display:none; color:#DC2626; font-size:0.72rem; font-weight:700; margin-top:2px;">
                                    ⚠️ Please enter a valid 10-digit WhatsApp number.
                                </div>
                            </div>

                            <!-- City & State Row -->
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                                <div class="ac-field-group">
                                    <label class="ac-field-label" for="regCity">City <span class="req">*</span></label>
                                    <input type="text" id="regCity" class="ac-text-input no-icon" placeholder="e.g. Surat" value="Surat" required>
                                </div>
                                <div class="ac-field-group">
                                    <label class="ac-field-label">State <span class="req">*</span></label>
                                    <div class="ac-custom-select" id="stateSelectBox">
                                        <div class="ac-select-trigger" onclick="toggleDropdown('stateSelectBox')">
                                            <span id="displayStateText" style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Gujarat</span>
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                        </div>
                                        <div class="ac-select-menu" id="stateDropdownMenu">
                                            <div class="ac-select-search">
                                                <input type="text" id="stateSearchInput" placeholder="🔍 Search state..." oninput="filterStateOptions(this.value)" onclick="event.stopPropagation()">
                                            </div>
                                            <div class="ac-select-options" id="stateOptionsList">
                                                <!-- Dynamically Populated -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Account Role Selector -->
                            <div class="ac-field-group">
                                <label class="ac-field-label">Select Account Type <span class="req">*</span></label>
                                <input type="hidden" id="regRole" name="role" value="Retailer">
                                <div class="ac-role-grid">
                                    <div class="ac-role-card active" data-role="Retailer" onclick="selectRole('Retailer')">
                                        <div class="ac-role-icon">
                                            <svg viewBox="0 0 24 24" fill="none"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4H6z" fill="#EFF6FF" stroke="#1D4ED8" stroke-width="2"/><line x1="3" y1="6" x2="21" y2="6" stroke="#1D4ED8" stroke-width="2"/><path d="M16 10a4 4 0 0 1-8 0" stroke="#1D4ED8" stroke-width="2"/></svg>
                                        </div>
                                        <span class="ac-role-name">Retailer</span>
                                    </div>
                                    <div class="ac-role-card" data-role="Wholesaler" onclick="selectRole('Wholesaler')">
                                        <div class="ac-role-icon">
                                            <svg viewBox="0 0 24 24" fill="none"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" fill="#FEF3C7" stroke="#B45309" stroke-width="2"/><polyline points="3.27 6.96 12 12.01 20.73 6.96" stroke="#B45309" stroke-width="2"/><line x1="12" y1="22.08" x2="12" y2="12" stroke="#B45309" stroke-width="2"/></svg>
                                        </div>
                                        <span class="ac-role-name">Wholesale</span>
                                    </div>
                                    <div class="ac-role-card" data-role="Reseller" onclick="selectRole('Reseller')">
                                        <div class="ac-role-icon">
                                            <svg viewBox="0 0 24 24" fill="none"><rect x="2" y="7" width="20" height="14" rx="2" fill="#DCFCE7" stroke="#15803D" stroke-width="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" stroke="#15803D" stroke-width="2"/><line x1="12" y1="12" x2="12" y2="15" stroke="#15803D" stroke-width="2"/></svg>
                                        </div>
                                        <span class="ac-role-name">Reseller</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Trade Application Notice -->
                            <div id="regTradeNoteGroup" style="display:none; background:#FAF8F4; border:1px solid var(--dt-gold-border); border-radius:8px; padding:10px 12px; font-size:0.75rem; color:#475569; line-height:1.45;">
                                Trade accounts are verified on WhatsApp before wholesale pricing is activated. You can shop at retail rates immediately while approval is pending.
                            </div>

                            <!-- Password -->
                            <div class="ac-field-group">
                                <label class="ac-field-label" for="regPass">Choose Password <span class="req">*</span></label>
                                <div class="ac-input-wrapper">
                                    <svg class="ac-input-icon" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input type="password" id="regPass" class="ac-text-input" placeholder="Minimum 6 characters" required autocomplete="new-password">
                                    <button type="button" class="ac-pwd-toggle" onclick="togglePwdVisibility('regPass', this)" title="Show/Hide Password">
                                        <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" class="dt-btn-gold" id="regSubmitBtn">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                                <span>Create VIP Account</span>
                            </button>
                        </form>

                        <!-- 3. FORGOT PASSWORD PANE -->
                        <form id="forgotForm" class="ac-form-pane" onsubmit="event.preventDefault(); handleForgotSubmit();">
                            <p style="font-size:0.84rem; color:var(--dt-text-sub); margin:0 0 10px 0; line-height:1.45;">
                                Enter your registered WhatsApp Number or Email and our Concierge will instantly send you an authenticated password recovery link.
                            </p>
                            <div class="ac-field-group">
                                <label class="ac-field-label" for="forgotInput">WhatsApp Number / Email <span class="req">*</span></label>
                                <div class="ac-input-wrapper">
                                    <svg class="ac-input-icon" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                    <input type="text" id="forgotInput" class="ac-text-input" placeholder="e.g. 7046363528" required>
                                </div>
                            </div>
                            <button type="submit" class="dt-btn-gold">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 2L11 13"></path><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                <span>Send Recovery via WhatsApp</span>
                            </button>
                            <div style="text-align:center;">
                                <a href="javascript:void(0)" onclick="switchAuthTab('login')" style="color:var(--dt-gold); font-size:0.8rem; font-weight:700; text-decoration:none;">← Back to Sign In</a>
                            </div>
                        </form>

                    </div>
                </div>

            </div>

            <!-- ════════════ VIEW 2: LOGGED-IN VIP DASHBOARD ════════════ -->
            <div id="dashboardWrap" class="ac-dashboard-wrap">
                
                <!-- Hero Profile Banner -->
                <div class="ac-profile-card">
                    <div class="ac-profile-left">
                        <div class="ac-avatar-ring" id="dashUserInitials">DT</div>
                        <div>
                            <h2 class="ac-profile-name" id="dashUserName">Valued Client</h2>
                            <div class="ac-profile-phone" id="dashUserPhone">+91 70463 63528</div>
                            <div class="ac-tier-badge" id="dashUserRoleBadge">👑 VIP Member</div>
                        </div>
                    </div>

                    <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                        <a href="/wholesale.php" id="dashHeroPortalBtn" style="display:none;" class="dt-btn-gold">
                            <span>📦 Open Wholesale Depot</span>
                            <span>→</span>
                        </a>
                        <button type="button" class="ac-logout-btn" onclick="handleLogoutClick()">
                            Sign Out
                        </button>
                    </div>
                </div>

                <!-- 2-Column Dashboard Grid -->
                <div class="ac-dash-grid">
                    
                    <!-- Left: Dynamic Live Orders -->
                    <div class="ac-card-panel">
                        <div class="ac-card-header">
                            <h3 class="ac-card-title">
                                <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                                <span>Recent Orders &amp; Dispatches</span>
                            </h3>
                            <a href="https://api.whatsapp.com/send?phone=917046363528&text=Hi%20DT%20Brand%27s%2C%20I%20would%20like%20to%20inquire%20about%20my%20orders" target="_blank" style="color:#15803D; font-size:0.78rem; font-weight:800; text-decoration:none; display:flex; align-items:center; gap:4px;">
                                <span>WhatsApp Support</span>
                            </a>
                        </div>

                        <div id="dashOrdersList">
                            <!-- Populated dynamically by window.loadCustomerLiveOrders() -->
                            <div style="padding: 24px; text-align: center; color: var(--dt-gold); font-weight: 700;">
                                <span>Loading your live orders...</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Quick Stat Tiles & Concierge -->
                    <div style="display:flex; flex-direction:column; gap:20px;">
                        
                        <div class="ac-stat-grid">
                            <a href="/cart.php" class="ac-stat-card" onclick="if(typeof window.openCartDrawer==='function'){window.openCartDrawer();return false;}">
                                <div class="ac-stat-num" id="dashCartCount">0</div>
                                <div class="ac-stat-lbl">Bag Items</div>
                            </a>
                            <a href="/wishlist.php" class="ac-stat-card" onclick="if(typeof window.openWishlistDrawer==='function'){window.openWishlistDrawer();return false;}">
                                <div class="ac-stat-num" id="dashWishCount">0</div>
                                <div class="ac-stat-lbl">Saved Items</div>
                            </a>
                        </div>

                        <!-- Personal Concierge Card -->
                        <div class="ac-card-panel" style="background: linear-gradient(135deg, #FAF8F4 0%, #FAF5EA 100%); border: 1.5px solid var(--dt-gold);">
                            <h4 style="font-family:var(--font-serif); color:var(--dt-gold); margin:0 0 6px 0; font-size:1.05rem;">Royal Fashion Concierge</h4>
                            <p style="font-size:0.8rem; color:#475569; margin:0 0 14px 0; line-height:1.45;">
                                Need custom saree blouse stitching, bridal lot matching, or direct wholesale GST invoicing? Our master fashion stylists are at your service.
                            </p>
                            <a href="https://api.whatsapp.com/send?phone=917046363528&text=Hi%20DT%20Brand%27s%2C%20I%20would%20like%20VIP%20styling%20support" target="_blank" class="dt-btn-emerald" style="text-decoration:none;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                <span>WhatsApp Fashion Stylist</span>
                            </a>
                        </div>

                        <a href="/shop.php" class="dt-btn-gold" style="text-decoration:none; text-align:center;">
                            Browse Luxury Catalog →
                        </a>

                    </div>

                </div>

            </div>

        </main>
    </div>

    <!-- ════════════ OFFICIAL MASTER SHOP FOOTER ════════════ -->
    <?php include_once __DIR__ . '/includes/shopbottomfotoer.php'; ?>

    <!-- ════════════ JAVASCRIPT CONTROLLER ════════════ -->
    <script>
    (function() {
        'use strict';

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
                    'Jammu & Kashmir', 'Ladakh', 'Chandigarh', 'Puducherry'
                ]
            },
            { code: 'ae', name: 'United Arab Emirates', flagImg: 'https://flagcdn.com/w40/ae.png', dial: '+971', digits: 9, states: ['Dubai', 'Abu Dhabi', 'Sharjah', 'Ajman', 'Ras Al Khaimah', 'Fujairah', 'Umm Al Quwain'] },
            { code: 'us', name: 'United States', flagImg: 'https://flagcdn.com/w40/us.png', dial: '+1', digits: 10, states: ['California', 'Texas', 'New York', 'Florida', 'Illinois', 'New Jersey', 'Georgia', 'Washington', 'Ohio', 'Pennsylvania'] },
            { code: 'gb', name: 'United Kingdom', flagImg: 'https://flagcdn.com/w40/gb.png', dial: '+44', digits: 10, states: ['Greater London', 'England', 'Scotland', 'Wales', 'Northern Ireland', 'Manchester', 'West Midlands'] },
            { code: 'ca', name: 'Canada', flagImg: 'https://flagcdn.com/w40/ca.png', dial: '+1', digits: 10, states: ['Ontario', 'British Columbia', 'Quebec', 'Alberta', 'Manitoba', 'Saskatchewan'] },
            { code: 'au', name: 'Australia', flagImg: 'https://flagcdn.com/w40/au.png', dial: '+61', digits: 9, states: ['New South Wales', 'Victoria', 'Queensland', 'Western Australia', 'South Australia'] },
            { code: 'sg', name: 'Singapore', flagImg: 'https://flagcdn.com/w40/sg.png', dial: '+65', digits: 8, states: ['Central Region', 'East Region', 'North Region', 'West Region'] },
            { code: 'my', name: 'Malaysia', flagImg: 'https://flagcdn.com/w40/my.png', dial: '+60', digits: 9, states: ['Kuala Lumpur', 'Selangor', 'Penang', 'Johor', 'Perak', 'Sabah', 'Sarawak'] },
            { code: 'sa', name: 'Saudi Arabia', flagImg: 'https://flagcdn.com/w40/sa.png', dial: '+966', digits: 9, states: ['Riyadh', 'Makkah', 'Eastern Province', 'Madinah', 'Jeddah'] },
            { code: 'qa', name: 'Qatar', flagImg: 'https://flagcdn.com/w40/qa.png', dial: '+974', digits: 8, states: ['Doha', 'Al Rayyan', 'Al Wakrah', 'Al Khor'] }
        ];

        var selectedCountry = ALL_WORLD_COUNTRIES[0];
        var selectedState = 'Gujarat';
        var selectedRole = 'Retailer';

        window.toggleDropdown = function(boxId) {
            var box = document.getElementById(boxId);
            if (!box) return;
            var isActive = box.classList.contains('active');
            document.querySelectorAll('.ac-custom-select').forEach(function(el){ el.classList.remove('active'); });
            if (!isActive) box.classList.add('active');
        };

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.ac-custom-select')) {
                document.querySelectorAll('.ac-custom-select').forEach(function(el){ el.classList.remove('active'); });
            }
        });

        function renderCountryDropdown() {
            var listEl = document.getElementById('countryOptionsList');
            if (!listEl) return;
            var html = '';
            ALL_WORLD_COUNTRIES.forEach(function(c) {
                html += '<div class="ac-select-option" onclick="selectCountry(\'' + c.code + '\')">' +
                    '<img src="' + c.flagImg + '" alt="' + c.name + '" class="ac-flag-img">' +
                    '<span>' + c.name + ' (' + c.dial + ')</span>' +
                '</div>';
            });
            listEl.innerHTML = html;
            renderStatesDropdown(selectedCountry);
        }

        function renderStatesDropdown(country) {
            var listEl = document.getElementById('stateOptionsList');
            if (!listEl) return;
            var html = '';
            var states = country.states || ['Central Province', 'Region 1'];
            states.forEach(function(st) {
                html += '<div class="ac-select-option" onclick="selectState(\'' + st.replace(/'/g, "\\'") + '\')">' +
                    '<span>' + st + '</span>' +
                '</div>';
            });
            listEl.innerHTML = html;
        }

        window.selectCountry = function(code) {
            var c = ALL_WORLD_COUNTRIES.find(function(item) { return item.code === code; }) || ALL_WORLD_COUNTRIES[0];
            selectedCountry = c;
            
            var dFlag = document.getElementById('displayCountryFlag');
            var dText = document.getElementById('displayCountryText');
            var wFlag = document.getElementById('waFlagImg');
            var wDial = document.getElementById('waDialCode');
            var dHint = document.getElementById('digitCountHint');

            if (dFlag) dFlag.src = c.flagImg;
            if (dText) dText.textContent = c.name + ' (' + c.dial + ')';
            if (wFlag) wFlag.src = c.flagImg;
            if (wDial) wDial.textContent = c.dial;
            if (dHint) dHint.textContent = c.digits + '-digit number';
            
            var phoneInput = document.getElementById('regPhone');
            if (phoneInput) {
                phoneInput.placeholder = c.digits + '-digit WhatsApp number';
                phoneInput.maxLength = c.digits + 2;
            }

            renderStatesDropdown(c);
            selectedState = (c.states && c.states[0]) ? c.states[0] : 'Surat';
            var sText = document.getElementById('displayStateText');
            if (sText) sText.textContent = selectedState;

            var cBox = document.getElementById('countrySelectBox');
            if (cBox) cBox.classList.remove('active');
        };

        window.selectState = function(st) {
            selectedState = st;
            var sText = document.getElementById('displayStateText');
            if (sText) sText.textContent = st;
            var sBox = document.getElementById('stateSelectBox');
            if (sBox) sBox.classList.remove('active');
        };

        window.filterCountryOptions = function(query) {
            var q = (query || '').toLowerCase().trim();
            var listEl = document.getElementById('countryOptionsList');
            if (!listEl) return;
            var filtered = ALL_WORLD_COUNTRIES.filter(function(c) {
                return c.name.toLowerCase().includes(q) || c.dial.includes(q);
            });
            var html = '';
            filtered.forEach(function(c) {
                html += '<div class="ac-select-option" onclick="selectCountry(\'' + c.code + '\')">' +
                    '<img src="' + c.flagImg + '" alt="' + c.name + '" class="ac-flag-img">' +
                    '<span>' + c.name + ' (' + c.dial + ')</span>' +
                '</div>';
            });
            listEl.innerHTML = html;
        };

        window.filterStateOptions = function(query) {
            var q = (query || '').toLowerCase().trim();
            var listEl = document.getElementById('stateOptionsList');
            if (!listEl) return;
            var states = selectedCountry.states || [];
            var filtered = states.filter(function(st) { return st.toLowerCase().includes(q); });
            var html = '';
            filtered.forEach(function(st) {
                html += '<div class="ac-select-option" onclick="selectState(\'' + st.replace(/'/g, "\\'") + '\')">' +
                    '<span>' + st + '</span>' +
                '</div>';
            });
            listEl.innerHTML = html;
        };

        window.selectRole = function(role) {
            selectedRole = role;
            document.querySelectorAll('.ac-role-card').forEach(function(el) {
                el.classList.toggle('active', el.getAttribute('data-role') === role);
            });
            var roleInput = document.getElementById('regRole');
            if (roleInput) roleInput.value = role;

            var note = document.getElementById('regTradeNoteGroup');
            if (note) {
                note.style.display = (role === 'Wholesaler' || role === 'Reseller') ? 'block' : 'none';
            }
        };

        window.togglePwdVisibility = function(inputId, btn) {
            var input = document.getElementById(inputId);
            if (!input) return;
            if (input.type === 'password') {
                input.type = 'text';
                btn.innerHTML = '<svg viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>';
            } else {
                input.type = 'password';
                btn.innerHTML = '<svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>';
            }
        };

        window.validateWhatsAppDigits = function() {
            var phoneEl = document.getElementById('regPhone');
            var errorEl = document.getElementById('phoneErrorMsg');
            if (!phoneEl) return;
            var val = phoneEl.value.replace(/\D/g, '');
            phoneEl.value = val;
            var expected = selectedCountry.digits || 10;
            if (val.length > 0 && val.length !== expected) {
                if (errorEl) errorEl.style.display = 'block';
            } else {
                if (errorEl) errorEl.style.display = 'none';
            }
        };

        window.switchAuthTab = function(tab) {
            var btnLogin = document.getElementById('tabBtnLogin');
            var btnReg = document.getElementById('tabBtnRegister');
            var loginForm = document.getElementById('loginForm');
            var regForm = document.getElementById('registerForm');
            var forgotForm = document.getElementById('forgotForm');

            if (btnLogin) btnLogin.classList.toggle('active', tab === 'login');
            if (btnReg) btnReg.classList.toggle('active', tab === 'register');

            if (loginForm) loginForm.classList.toggle('active', tab === 'login');
            if (regForm) regForm.classList.toggle('active', tab === 'register');
            if (forgotForm) forgotForm.classList.toggle('active', tab === 'forgot');

            if (tab === 'register') {
                renderCountryDropdown();
            }
        };

        window.checkUserAuth = function() {
            var user = null;
            try {
                user = JSON.parse(localStorage.getItem('dtbrands_user'));
            } catch(e) {}

            var authWrap = document.getElementById('authCardWrap');
            var dashWrap = document.getElementById('dashboardWrap');
            var breadcrumbTitle = document.getElementById('acBreadcrumbTitle');

            if (user && (user.id || user.phone)) {
                if (authWrap) authWrap.style.display = 'none';
                if (dashWrap) {
                    dashWrap.style.display = 'flex';
                    dashWrap.classList.add('active');
                }
                if (breadcrumbTitle) breadcrumbTitle.textContent = 'Member Dashboard';

                var nameEl = document.getElementById('dashUserName');
                var phoneEl = document.getElementById('dashUserPhone');
                var roleEl = document.getElementById('dashUserRoleBadge');
                var initEl = document.getElementById('dashUserInitials');

                if (nameEl) nameEl.textContent = user.name || 'Valued Member';
                if (phoneEl) phoneEl.textContent = user.phone || '+91 70463 63528';
                if (roleEl) roleEl.textContent = '👑 ' + (user.role || 'VIP Member');

                if (initEl) {
                    var parts = (user.name || 'Member').split(' ');
                    var initials = parts[0].charAt(0) + (parts[1] ? parts[1].charAt(0) : '');
                    initEl.textContent = initials.toUpperCase();
                }

                // Update Bag / Saved Counts
                var cart = JSON.parse(localStorage.getItem('dtbrands_cart') || '[]');
                var wish = JSON.parse(localStorage.getItem('dtbrands_wishlist') || '[]');
                var cEl = document.getElementById('dashCartCount');
                var wEl = document.getElementById('dashWishCount');
                if (cEl) cEl.textContent = cart.reduce(function(s, i){ return s + (i.qty||1); }, 0);
                if (wEl) wEl.textContent = wish.length;

                // Portal button
                var heroBtn = document.getElementById('dashHeroPortalBtn');
                var roleLower = (user.role || '').toLowerCase();
                if (heroBtn) {
                    if (roleLower.includes('wholesale')) {
                        heroBtn.style.display = 'inline-flex';
                        heroBtn.href = '/wholesale.php';
                        heroBtn.innerHTML = '<span>📦 Open Wholesale Depot</span><span>→</span>';
                    } else if (roleLower.includes('reseller')) {
                        heroBtn.style.display = 'inline-flex';
                        heroBtn.href = '/reseller.php';
                        heroBtn.innerHTML = '<span>💼 Open Reseller Hub</span><span>→</span>';
                    } else if (roleLower.includes('retailer')) {
                        heroBtn.style.display = 'inline-flex';
                        heroBtn.href = '/retailer.php';
                        heroBtn.innerHTML = '<span>🛍️ Open Retailer Hub</span><span>→</span>';
                    } else {
                        heroBtn.style.display = 'none';
                    }
                }

                // Load real-time orders dynamically from database
                window.loadCustomerLiveOrders(user.phone || user.rawPhone || '');
            } else {
                if (authWrap) authWrap.style.display = 'grid';
                if (dashWrap) {
                    dashWrap.style.display = 'none';
                    dashWrap.classList.remove('active');
                }
                if (breadcrumbTitle) breadcrumbTitle.textContent = 'Sign In / Register';
                renderCountryDropdown();
            }
        };

        window.loadCustomerLiveOrders = function(phone) {
            var listEl = document.getElementById('dashOrdersList');
            if (!listEl) return;

            listEl.innerHTML = '<div style="padding: 24px; text-align: center; color: #8A681F; font-weight: 700;"><div style="display:inline-block; width:20px; height:20px; border:2px solid #8A681F; border-top-color:transparent; border-radius:50%; animation:dtSpin 0.8s linear infinite; margin-bottom:8px;"></div><div>Loading your live orders...</div></div><style>@keyframes dtSpin{to{transform:rotate(360deg);}}</style>';

            var url = '/api/orders.php?action=my_orders' + (phone ? ('&phone=' + encodeURIComponent(phone)) : '');

            fetch(url, { credentials: 'same-origin' })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (!data || !data.success || !Array.isArray(data.orders) || data.orders.length === 0) {
                        listEl.innerHTML = '<div style="padding: 32px 16px; text-align: center; background: #FAF8F4; border: 1.5px dashed #D4AF37; border-radius: 12px;"><svg viewBox="0 0 24 24" width="38" height="38" fill="none" stroke="#8A681F" stroke-width="2" style="margin-bottom: 10px;"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg><h4 style="margin: 0 0 6px 0; font-size: 1.05rem; font-weight: 800; color: #181512;">No orders placed yet</h4><p style="margin: 0 0 16px 0; font-size: 0.82rem; color: #64748B;">Explore our pure handloom silk sarees, bridal lehengas, and designer fabrics.</p><a href="/shop.php" class="dt-btn-gold" style="display: inline-flex; width: auto; padding: 10px 24px; font-size: 0.84rem; text-decoration: none; margin: 0 auto;">Explore Luxury Collection →</a></div>';
                        return;
                    }

                    var html = '';
                    data.orders.forEach(function(ord) {
                        var st = (ord.fulfillment_status || ord.status || 'processing').toLowerCase();
                        var stClass = 'status-' + st.replace(/_/g, '-');
                        var stLabel = st.replace(/_/g, ' ').toUpperCase();
                        var ordNum = ord.order_number || ('DTB-' + ord.id);
                        var created = ord.created_at ? new Date(ord.created_at).toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' }) : 'Recent';
                        var amount = parseFloat(ord.total_amount || ord.amount || 0).toLocaleString('en-IN');
                        var waMsg = encodeURIComponent("Namaste DT Brand's! 🙏 Please share tracking update for Order #" + ordNum);
                        var waUrl = "https://api.whatsapp.com/send?phone=917046363528&text=" + waMsg;

                        var items = Array.isArray(ord.items) ? ord.items : [];
                        var itemsHtml = '';

                        if (items.length > 0) {
                            items.forEach(function(it) {
                                var title = it.product_title || it.name || 'Handloom Ethnic Silk Saree';
                                var thumb = it.img || it.primary_image || '/assets/images/product1.png';
                                var varText = [];
                                if (it.variant_color) varText.push('Color: ' + it.variant_color);
                                if (it.variant_size) varText.push('Size: ' + it.variant_size);
                                if (it.selling_type === 'full_set') varText.push('Catalogue Set (Full)');
                                var qty = it.quantity || it.qty || 1;
                                var price = parseFloat(it.unit_price || it.price || 0).toLocaleString('en-IN');

                                itemsHtml += '<div style="display:flex; align-items:center; gap:12px; margin-bottom:8px; border-bottom:1px dashed rgba(0,0,0,0.06); padding-bottom:8px;"><img src="' + thumb + '" alt="' + title + '" class="order-thumb" onerror="this.src=\'/assets/images/product1.png\';"><div style="flex:1;"><div style="font-weight:800; color:#111827; font-size:0.88rem;">' + title + '</div><div style="font-size:0.75rem; color:#64748B; margin-top:2px;">' + (varText.length ? varText.join(' • ') + ' • ' : '') + 'Qty: ' + qty + ' • ₹' + price + '</div></div></div>';
                            });
                        } else {
                            itemsHtml = '<div style="display:flex; align-items:center; gap:12px;"><img src="/assets/images/product1.png" alt="Saree" class="order-thumb"><div><div style="font-weight:800; color:#111827;">Luxury Silk Handloom Lot</div><div style="font-size:0.75rem; color:#64748B; margin-top:2px;">Authentic Zari Craft • Qty: 1</div></div></div>';
                        }

                        html += '<div class="order-box">' +
                            '<div class="order-top">' +
                                '<div>' +
                                    '<span class="order-id">Order #' + ordNum + '</span>' +
                                    '<div style="font-size:0.74rem; color:#64748B; margin-top:2px;">Placed on ' + created + '</div>' +
                                '</div>' +
                                '<span class="order-status-badge ' + stClass + '">' + stLabel + '</span>' +
                            '</div>' +
                            '<div>' + itemsHtml + '</div>' +
                            (ord.tracking_number ? ('<div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:6px 10px; font-size:0.75rem; display:flex; justify-content:space-between; align-items:center; margin:8px 0;"><span style="color:#64748B;">Courier: <strong style="color:#181512;">' + (ord.courier_name || 'VRL Logistics / Delhivery') + '</strong></span><span style="font-family:monospace; font-weight:700; color:#8A681F;">AWB: ' + ord.tracking_number + '</span></div>') : '') +
                            '<div style="margin-top:10px; padding-top:10px; border-top:1.5px solid #F1ECE1; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">' +
                                '<div style="font-size:0.88rem; font-weight:700; color:#111827;">' +
                                    'Total: <span style="color:#8A681F; font-size:1.05rem; font-weight:800;">₹' + amount + '</span>' +
                                '</div>' +
                                '<div style="display:flex; gap:8px;">' +
                                    '<a href="' + waUrl + '" target="_blank" class="dt-btn-emerald" style="display:inline-flex; width:auto; padding:6px 14px; font-size:0.75rem; height:auto; text-decoration:none;">' +
                                        '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>' +
                                        '<span>Track on WhatsApp</span>' +
                                    '</a>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
                    });

                    listEl.innerHTML = html;
                })
                .catch(function(err) {
                    console.error("Orders load error:", err);
                    listEl.innerHTML = '<div style="padding:20px; text-align:center; color:#DC2626; font-size:0.85rem;">Could not load live order history. Please check your network connection.</div>';
                });
        };

        window.handleLoginSubmit = function() {
            var input = document.getElementById('loginPhone').value.trim();
            var passEl = document.getElementById('loginPass');
            var pass = passEl ? passEl.value.trim() : '';
            if (!input || !pass) {
                alert('Please enter your phone/email and password.');
                return;
            }

            var btn = document.getElementById('loginSubmitBtn');
            if (btn) btn.innerHTML = '<span>Verifying credentials...</span>';

            var params = new URLSearchParams();
            params.append('action', 'login');
            params.append('identity', input);
            params.append('password', pass);

            fetch('/api/auth.php', {
                method: 'POST',
                body: params
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (btn) btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg><span>Sign In to VIP Lounge</span>';
                
                if (data.success && data.user) {
                    var u = data.user;
                    var lType = (u.type || 'retail').toLowerCase();
                    var roleName = lType === 'wholesale' ? 'Wholesaler' : (lType === 'reseller' ? 'Reseller' : 'Retailer');
                    var userData = {
                        id: u.id,
                        name: u.name,
                        phone: u.phone,
                        email: u.email || 'member@dtbrands.in',
                        role: roleName,
                        tier: u.tier || 'Standard',
                        country: 'India',
                        state: u.state || 'Gujarat',
                        city: u.city || 'Surat'
                    };
                    localStorage.setItem('dtbrands_user', JSON.stringify(userData));
                    checkUserAuth();
                } else {
                    alert(data.message || 'Login failed. Please verify your credentials.');
                }
            })
            .catch(function() {
                if (btn) btn.innerHTML = '<span>Sign In to VIP Lounge</span>';
                alert('Unable to reach server. Please check your connection.');
            });
        };

        window.handleRegisterSubmit = function() {
            var name = document.getElementById('regName').value.trim();
            var phone = document.getElementById('regPhone').value.trim();
            var city = document.getElementById('regCity').value.trim();
            var passEl = document.getElementById('regPass');
            var pass = passEl ? passEl.value.trim() : '';

            if (!name) { alert('Please enter your full name.'); return; }
            if (pass.length < 6) { alert('Password must be at least 6 characters.'); return; }
            var expected = selectedCountry.digits || 10;
            if (!phone || phone.length !== expected) {
                alert('Please enter a valid ' + expected + '-digit WhatsApp number.');
                return;
            }

            var typeCode = selectedRole === 'Wholesaler' ? 'wholesale' : (selectedRole === 'Reseller' ? 'reseller' : 'retailer');
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

            var regBtn = document.getElementById('regSubmitBtn');
            if (regBtn) regBtn.innerHTML = '<span>Creating VIP Profile...</span>';

            fetch('/api/auth.php', {
                method: 'POST',
                body: params
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (regBtn) regBtn.innerHTML = '<span>Create VIP Account</span>';
                if (data && data.success && data.pending_approval) {
                    alert(data.message || 'Your trade account application has been received. We will confirm on WhatsApp once approved.');
                    return;
                }
                if (data.success && data.user) {
                    var u = data.user;
                    var srvType = (u.type || 'retail').toLowerCase();
                    var srvRole = srvType === 'wholesale' ? 'Wholesaler' : (srvType === 'reseller' ? 'Reseller' : 'Retailer');
                    var userData = {
                        id: u.id,
                        name: u.name,
                        phone: u.phone,
                        rawPhone: phone,
                        role: srvRole,
                        tier: u.tier || 'Standard',
                        country: selectedCountry.name,
                        state: selectedState,
                        city: city || 'Surat'
                    };
                    localStorage.setItem('dtbrands_user', JSON.stringify(userData));
                    checkUserAuth();
                } else {
                    alert(data.message || 'Registration failed.');
                }
            })
            .catch(function() {
                if (regBtn) regBtn.innerHTML = '<span>Create VIP Account</span>';
                alert('Unable to reach server. Please try again.');
            });
        };

        window.handleForgotSubmit = function() {
            var input = document.getElementById('forgotInput').value.trim();
            if (!input) return;
            var waUrl = "https://api.whatsapp.com/send?phone=917046363528&text=" + encodeURIComponent("Hi DT Brand's, I need a password reset link for account: " + input);
            window.open(waUrl, '_blank');
            alert('📩 Password reset request sent to WhatsApp Concierge!');
        };

        window.handleLogoutClick = function() {
            fetch('/api/auth.php?action=logout', {
                method: 'POST',
                credentials: 'same-origin'
            })
            .catch(function(){})
            .then(function() {
                localStorage.removeItem('dtbrands_user');
                checkUserAuth();
            });
        };

        document.addEventListener('DOMContentLoaded', function() {
            checkUserAuth();

            fetch('/api/auth.php?action=session', { credentials: 'same-origin' })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data && data.authenticated && data.user) {
                        var u = data.user;
                        var t = (u.type || 'retail').toLowerCase();
                        var stored = {};
                        try { stored = JSON.parse(localStorage.getItem('dtbrands_user')) || {}; } catch(e){}
                        stored.id = u.id;
                        stored.name = u.name || stored.name;
                        stored.phone = u.phone || stored.phone;
                        stored.role = t === 'wholesale' ? 'Wholesaler' : (t === 'reseller' ? 'Reseller' : 'Retailer');
                        stored.tier = u.tier || stored.tier || 'Standard';
                        localStorage.setItem('dtbrands_user', JSON.stringify(stored));
                        checkUserAuth();
                    } else if (localStorage.getItem('dtbrands_user')) {
                        localStorage.removeItem('dtbrands_user');
                        checkUserAuth();
                    }
                })
                .catch(function(){});
        });

    })();
    </script>

    <!-- ════════════ MASTER MODAL SYSTEM INTEGRATIONS ════════════ -->
    <?php include_once __DIR__ . '/Shared/quickview.php'; ?>
    <?php include_once __DIR__ . '/Shared/smartshare.php'; ?>
    <?php include_once __DIR__ . '/Shared/reels.php'; ?>
    <?php include_once __DIR__ . '/Shared/cart.php'; ?>
    <?php include_once __DIR__ . '/Shared/wishlist.php'; ?>
    <?php include_once __DIR__ . '/Shared/checkout.php'; ?>
</body>
</html>
