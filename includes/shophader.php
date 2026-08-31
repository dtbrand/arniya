<?php
/**
 * shophader.php  —  PARTIAL INCLUDE
 * Premium Shop Header component for DT Brand's
 * Features Amazon-Style Always-Open Desktop Search Bar & Clean Full-Width Mobile Search Bar with Right Close Button
 */
$reqUri = trim(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH), '/');
$currentPage = basename($_SERVER['PHP_SELF'] ?? '');
$isHomePage = (
    $currentPage === 'home.php' || 
    $currentPage === 'index.php' || 
    $currentPage === '' || 
    $reqUri === '' || 
    $reqUri === 'index.php' || 
    $reqUri === 'home.php' || 
    (isset($hideHeaderSubnav) && $hideHeaderSubnav === true) || 
    (isset($isHome) && $isHome === true) || 
    (isset($isHomePage) && $isHomePage === true)
);
?>
<style>
/* ── Shop Header ─────────────────────────────────────────── */
.shop-header {
    position: sticky;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background: #FFFFFF;
    border-bottom: 1.5px solid var(--soft-platinum, #E5E3DE);
    box-shadow: 0 2px 14px rgba(138,104,31,0.08);
    display: flex;
    flex-direction: column;
    padding: 0;
    transition: box-shadow 0.25s ease;
}
.shop-header.scrolled {
    box-shadow: 0 4px 20px rgba(138,104,31,0.14);
}

/* ── Normal Header Container ── */
.header-normal-view {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    height: 64px;
    padding: 0 28px;
    gap: 20px;
}

/* ── Amazon-Style Attached Sub-Navigation Bar (Royal Gold Luxury Gradient) ── */
.header-attached-subnav {
    width: 100%;
    background: linear-gradient(90deg, #7A5B18 0%, #9C7724 50%, #7A5B18 100%);
    border-top: 1px solid rgba(255, 235, 180, 0.35);
    border-bottom: 1.5px solid #5C4310;
    height: 28px;
    display: flex;
    align-items: center;
    padding: 0 20px;
    box-shadow: 0 2px 8px rgba(122, 91, 24, 0.25);
}

.subnav-scroll-track {
    display: flex;
    align-items: center;
    gap: 5px;
    overflow-x: auto;
    scrollbar-width: none;
    -webkit-overflow-scrolling: touch;
    width: 100%;
    height: 100%;
}
.subnav-scroll-track::-webkit-scrollbar { display: none; }

.subnav-item {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 2px 10px;
    height: 22px;
    border-radius: 4px;
    background: transparent;
    border: 1px solid transparent;
    color: #FFF8EB;
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.03em;
    text-transform: capitalize;
    white-space: nowrap;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
}
.subnav-item:hover {
    border-color: rgba(255, 255, 255, 0.6);
    color: #FFFFFF;
    background: rgba(255, 255, 255, 0.2);
}
.subnav-item.active {
    background: #FFFFFF;
    color: #7A5B18;
    border-color: #FFFFFF;
    font-weight: 800;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.22);
}
.subnav-icon {
    width: 13px; height: 13px;
    stroke: currentColor; stroke-width: 2.2; fill: none;
}
.subnav-reels-btn {
    background: #1C1814;
    color: #F8D67A;
    border: 1px solid rgba(248, 214, 122, 0.4);
    font-weight: 800;
    margin-left: auto;
}
.subnav-reels-btn:hover {
    background: #000000;
    color: #FFFFFF;
    border-color: #FFFFFF;
}

/* ── Left Section: Stylish Plus Button + Brand Logo ── */
.header-left-group {
    display: flex;
    align-items: center;
    gap: 18px;
    flex-shrink: 0;
}

.shop-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    border-radius: 20px;
    border: 1.5px solid var(--soft-platinum, #E5E3DE);
    background: #FAF8F4;
    color: var(--dark-text, #24211C);
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 0.78rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s ease;
    flex-shrink: 0;
}
.shop-back-btn:hover {
    border-color: var(--dark-gold, #8A681F);
    background: #FFFFFF;
    color: var(--dark-gold, #8A681F);
    transform: translateX(-2px);
    box-shadow: 0 2px 8px rgba(138,104,31,0.15);
}
.shop-back-btn svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    stroke-width: 2.4;
    fill: none;
}

.header-brand {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    padding-left: 2px;
}
.header-brand-name {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--dark-gold, #8A681F);
    letter-spacing: 0.12em;
    text-transform: uppercase;
    line-height: 1.15;
    margin: 0;
}
.header-brand-tagline {
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 0.6rem;
    font-weight: 600;
    color: var(--light-text, #9A9490);
    letter-spacing: 0.24em;
    text-transform: uppercase;
    margin-top: 2px;
}

/* ── Center: Amazon-Style Always Open Search Bar (Desktop) ── */
.search-amazon-bar {
    display: flex;
    align-items: center;
    background: #FFFFFF;
    border: 2px solid var(--dark-gold, #8A681F);
    border-radius: 8px;
    height: 44px;
    flex: 1;
    max-width: 600px;
    margin: 0 24px;
    box-shadow: 0 2px 10px rgba(138,104,31,0.06);
    transition: all 0.25s ease;
    position: relative;
}
.search-amazon-bar:focus-within {
    box-shadow: 0 0 0 3px rgba(138,104,31,0.22), 0 6px 20px rgba(0,0,0,0.08);
    border-color: var(--deep-gold, #6F5218);
}

/* Category select pill */
.search-cat-dropdown-wrap {
    position: relative;
    height: 100%;
    display: flex;
    align-items: center;
    border-right: 1.5px solid var(--soft-platinum, #E5E3DE);
    background: #FAF8F4;
    border-radius: 6px 0 0 6px;
    flex-shrink: 0;
}
.search-cat-select {
    appearance: none;
    -webkit-appearance: none;
    background: transparent;
    border: none;
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--dark-text, #24211C);
    padding: 0 28px 0 12px;
    height: 100%;
    cursor: pointer;
    outline: none;
}
.search-cat-arrow {
    position: absolute;
    right: 8px;
    width: 14px; height: 14px;
    stroke: var(--dark-gold, #8A681F);
    stroke-width: 2.2;
    fill: none;
    pointer-events: none;
}

/* Center text input */
.search-input-wrap {
    flex: 1;
    position: relative;
    height: 100%;
    display: flex;
    align-items: center;
}
.search-input-amazon {
    width: 100%;
    height: 100%;
    border: none;
    outline: none;
    padding: 0 34px 0 14px;
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 0.88rem;
    color: var(--dark-text, #24211C);
    background: transparent;
}
.search-input-amazon::placeholder {
    color: var(--light-text, #9A9490);
    font-size: 0.82rem;
}

/* Clear 'x' button */
.search-clear-btn {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    width: 22px; height: 22px;
    display: none;
    align-items: center;
    justify-content: center;
    border: none;
    background: rgba(0,0,0,0.08);
    border-radius: 50%;
    cursor: pointer;
    color: var(--mid-text, #5A5348);
    transition: all 0.2s;
}
.search-clear-btn:hover {
    background: var(--dark-gold, #8A681F);
    color: #FFFFFF;
}
.search-clear-btn svg { width: 12px; height: 12px; stroke: currentColor; fill: none; }

/* Right gold submit button */
.search-submit-btn {
    height: 100%;
    width: 48px;
    background: linear-gradient(135deg, var(--dark-gold, #8A681F) 0%, var(--deep-gold, #6F5218) 100%);
    border: none;
    border-radius: 0 6px 6px 0;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FFFFFF;
    transition: background 0.2s, transform 0.15s;
    flex-shrink: 0;
}
.search-submit-btn:hover {
    background: var(--deep-gold, #6F5218);
}
.search-submit-btn svg {
    width: 19px; height: 19px;
    stroke: #FFFFFF;
    stroke-width: 2.4;
    fill: none;
}

/* ── Right Actions (Wishlist & Cart Buttons) ── */
.header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}

.header-icon-btn {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 42px; height: 42px;
    border-radius: 50%;
    border: 1.5px solid var(--soft-platinum, #E5E3DE);
    background: #FAF8F4;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    color: var(--dark-gold, #8A681F);
}
.header-icon-btn:hover {
    background: #FFFFFF;
    border-color: var(--dark-gold, #8A681F);
    transform: translateY(-1px);
}
.header-icon-btn svg {
    width: 20px; height: 20px;
    stroke: var(--dark-gold, #8A681F);
    stroke-width: 2;
    fill: none;
}
.header-badge {
    position: absolute;
    top: -4px; right: -4px;
    min-width: 19px; height: 19px;
    padding: 0 4px;
    background: var(--dark-gold, #8A681F);
    color: #FFFFFF;
    font-size: 0.65rem;
    font-weight: 700;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #FFFFFF;
}

/* Mobile search trigger button */
.mobile-search-trigger-btn {
    display: none;
}

/* ── Header Account Dropdown (Desktop) ── */
.header-account-wrap {
    position: relative;
    display: none;
}
@media (min-width: 768px) {
    .header-account-wrap {
        display: block;
    }
}
.header-account-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 0 12px;
    height: 38px;
    border-radius: 20px;
    border: 1.5px solid var(--soft-platinum, #E5E3DE);
    background: #FFFFFF;
    color: var(--dark-gold, #8A681F);
    font-family: var(--font-sans);
    font-size: 0.76rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}
.header-account-btn:hover {
    border-color: var(--dark-gold);
    background: #FAF8F4;
    color: var(--deep-gold);
    box-shadow: 0 2px 8px rgba(138,104,31,0.12);
}
.header-account-btn svg {
    width: 17px;
    height: 17px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
}
.header-account-dropdown {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    width: 210px;
    background: #FFFFFF;
    border: 1.5px solid var(--dark-gold, #8A681F);
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    padding: 6px 0;
    display: none;
    flex-direction: column;
    z-index: 1000;
    animation: acDropFade 0.2s cubic-bezier(0.16, 1, 0.3, 1);
}
.header-account-wrap:hover .header-account-dropdown,
.header-account-wrap:focus-within .header-account-dropdown {
    display: flex;
}
@keyframes acDropFade {
    from { opacity: 0; transform: translateY(-4px); }
    to { opacity: 1; transform: translateY(0); }
}
.ac-drop-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 16px;
    color: var(--dark-text, #24211C);
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: background 0.15s ease, color 0.15s ease;
}
.ac-drop-item:hover {
    background: #FAF6ED;
    color: var(--dark-gold, #8A681F);
}
.ac-drop-item svg {
    width: 15px;
    height: 15px;
    stroke: var(--dark-gold, #8A681F);
    stroke-width: 2;
    fill: none;
    flex-shrink: 0;
}
.ac-drop-divider {
    height: 1px;
    background: var(--soft-platinum, #E5E3DE);
    margin: 4px 0;
}

/* ── Mobile In-Header Sticky Search Bar (<768px) ── */
.mobile-full-search-bar {
    display: none;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    height: 38px;
    padding: 0 8px;
    gap: 8px;
    background: #FFFFFF;
    box-sizing: border-box;
    position: relative !important;
    z-index: 10000000 !important;
}

.shop-header.mobile-search-active .header-normal-view {
    display: none !important;
}
.shop-header.mobile-search-active .mobile-full-search-bar {
    display: flex !important;
}

.mobile-search-input-wrap {
    flex: 1;
    height: 28px;
    display: flex;
    align-items: center;
    background: #FAF8F4;
    border: 1.5px solid var(--dark-gold, #8A681F);
    border-radius: 14px;
    padding: 0 8px;
    box-sizing: border-box;
    box-shadow: 0 1px 4px rgba(138,104,31,0.08);
    position: relative !important;
    z-index: 10000001 !important;
    pointer-events: auto !important;
}
.mobile-search-input-wrap:focus-within {
    border-color: var(--deep-gold, #6F5218);
    background: #FFFFFF;
    box-shadow: 0 0 0 2px rgba(212,175,55,0.3);
}

.mobile-search-input-field {
    flex: 1;
    width: 100%;
    height: 100%;
    border: none;
    outline: none;
    background: transparent;
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 0.78rem;
    font-weight: 600;
    color: var(--dark-text, #24211C);
    position: relative !important;
    z-index: 10000002 !important;
    pointer-events: auto !important;
    cursor: text !important;
}
.mobile-search-input-field::placeholder {
    color: var(--light-text, #9A9490);
    font-size: 0.72rem;
}

.mobile-search-clear-btn {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    border: none;
    background: rgba(0,0,0,0.08);
    color: var(--mid-text, #5A5348);
    display: none;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    margin-left: 2px;
    position: relative !important;
    z-index: 10000003 !important;
    pointer-events: auto !important;
}
.mobile-search-clear-btn svg { width: 10px; height: 10px; stroke: currentColor; fill: none; stroke-width: 2.2; }

.mobile-search-submit-icon-btn {
    background: none;
    border: none;
    padding: 0;
    margin-left: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--dark-gold, #8A681F);
    position: relative !important;
    z-index: 10000003 !important;
    pointer-events: auto !important;
}
.mobile-search-submit-icon-btn svg { width: 14px; height: 14px; stroke: currentColor; stroke-width: 2.4; fill: none; }

.mobile-header-close-btn {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 1.5px solid var(--dark-gold, #8A681F);
    background: #FAF8F4;
    color: var(--dark-gold, #8A681F);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
    padding: 0;
    position: relative !important;
    z-index: 10000003 !important;
    pointer-events: auto !important;
}
.mobile-header-close-btn:hover {
    background: #FEF2F2;
    color: #DC2626;
    border-color: #DC2626;
}
.mobile-header-close-btn svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    stroke-width: 2.4;
    fill: none;
}

/* ── Mobile Search Suggestions Dropdown (Opens below header on click/type) ── */
.mobile-search-suggestions-dropdown {
    display: none;
    position: fixed !important;
    top: 38px !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    width: 100vw !important;
    height: calc(100vh - 38px) !important;
    height: calc(100dvh - 38px) !important;
    background: #FFFFFF !important;
    z-index: 9999998 !important;
    flex-direction: column !important;
    overflow: hidden !important;
    box-sizing: border-box !important;
    overscroll-behavior: contain !important;
    animation: dtSuggFadeIn 0.2s ease;
}

body.mobile-search-open {
    overflow: hidden !important;
}

body.mobile-search-open .mobile-search-suggestions-dropdown {
    display: flex !important;
}

body.mobile-search-open .header-attached-subnav {
    display: none !important;
}

/* ══════════════════════════════════════════════════════════
   LUXURY PREDICTIVE AUTOCOMPLETE & PRODUCT SUGGESTIONS DROPDOWN
   ══════════════════════════════════════════════════════════ */
.dt-search-suggestions-dropdown {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    width: 100%;
    background: #FFFFFF;
    border: 1.5px solid var(--dark-gold, #8A681F);
    border-radius: 10px;
    box-shadow: 0 16px 40px rgba(0,0,0,0.18), 0 2px 10px rgba(184,134,11,0.15);
    max-height: 480px;
    overflow-y: auto;
    z-index: 9999;
    padding: 10px 0;
    box-sizing: border-box;
    animation: dtSuggFadeIn 0.2s ease;
    font-family: 'Inter', 'Plus Jakarta Sans', sans-serif;
}
@keyframes dtSuggFadeIn {
    from { opacity: 0; transform: translateY(-6px); }
    to { opacity: 1; transform: translateY(0); }
}

.dt-sugg-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 6px 14px 4px 14px;
    font-size: 0.70rem;
    font-weight: 800;
    letter-spacing: 0.05em;
    color: var(--dark-gold, #8A681F);
    text-transform: uppercase;
    background: #FAF8F4;
    border-top: 1px solid #F1ECE1;
    border-bottom: 1px solid #F1ECE1;
    margin: 6px 0 4px 0;
}
.dt-sugg-section-header:first-child {
    border-top: none;
    margin-top: 0;
}

/* Trending Chips Container */
.dt-sugg-trending-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    padding: 8px 14px;
}
.dt-sugg-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    background: #FAF5E8;
    border: 1px solid #D4AF37;
    border-radius: 16px;
    font-size: 0.76rem;
    font-weight: 600;
    color: #705114;
    cursor: pointer;
    transition: all 0.18s ease;
    text-decoration: none;
}
.dt-sugg-tag:hover {
    background: linear-gradient(135deg, #B8860B 0%, #D4AF37 100%);
    color: #111827;
    border-color: #8A681F;
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(184,134,11,0.25);
}

/* Category Suggestions List */
.dt-sugg-cat-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 7px 14px;
    font-size: 0.80rem;
    font-weight: 600;
    color: #1F2937;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.15s ease;
}
.dt-sugg-cat-item:hover {
    background: #FAF6ED;
    color: #8A681F;
}

/* Product Suggestions List */
.dt-sugg-product-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px 14px;
    border-bottom: 1px solid #F7F5F0;
    text-decoration: none;
    color: inherit;
    cursor: pointer;
    transition: all 0.15s ease;
}
.dt-sugg-product-item:hover {
    background: #FAF6ED;
}
.dt-sugg-thumb {
    width: 48px;
    height: 48px;
    border-radius: 6px;
    object-fit: cover;
    background: #F3F4F6;
    border: 1px solid #E5E7EB;
    flex-shrink: 0;
    transition: transform 0.2s ease;
}
.dt-sugg-product-item:hover .dt-sugg-thumb {
    transform: scale(1.06);
    border-color: #D4AF37;
}
.dt-sugg-info {
    flex: 1;
    min-width: 0;
}
.dt-sugg-title {
    font-size: 0.82rem;
    font-weight: 700;
    color: #111827;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.dt-sugg-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 2px;
    font-size: 0.72rem;
    color: #6B7280;
}
.dt-sugg-badge {
    background: #FAF5E8;
    color: #8A681F;
    font-weight: 700;
    padding: 1px 6px;
    border-radius: 4px;
    border: 0.5px solid #D4AF37;
}
.dt-sugg-pricing {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 2px;
}
.dt-sugg-price {
    font-size: 0.88rem;
    font-weight: 800;
    color: #8A681F;
}
.dt-sugg-mrp {
    font-size: 0.72rem;
    color: #9CA3AF;
    text-decoration: line-through;
}
.dt-sugg-disc {
    font-size: 0.68rem;
    font-weight: 800;
    background: #FEF3C7;
    color: #92400E;
    padding: 0 4px;
    border-radius: 3px;
}
.dt-sugg-view-btn {
    font-size: 0.74rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 14px;
    background: #FAF5E8;
    border: 1px solid #D4AF37;
    color: #705114;
    flex-shrink: 0;
    transition: all 0.15s ease;
}
.dt-sugg-product-item:hover .dt-sugg-view-btn {
    background: linear-gradient(135deg, #B8860B 0%, #D4AF37 100%);
    color: #111827;
    border-color: #8A681F;
}

/* Master Bottom View All Button */
.dt-sugg-footer-btn {
    display: block;
    margin: 8px 14px 4px 14px;
    padding: 8px 14px;
    text-align: center;
    background: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%);
    border: 1px solid #8A681F;
    border-radius: 6px;
    font-size: 0.80rem;
    font-weight: 800;
    color: #111827;
    text-decoration: none;
    cursor: pointer;
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.4), 0 2px 6px rgba(184,134,11,0.25);
    transition: all 0.15s ease;
}
.dt-sugg-footer-btn:hover {
    background: linear-gradient(135deg, #C59312 0%, #DFC04E 50%, #F0D77B 100%);
    transform: translateY(-1px);
    box-shadow: inset 0 1px 0 rgba(255,255,255,0.5), 0 4px 10px rgba(184,134,11,0.35);
}

.dt-search-highlight {
    background: #FEF08A;
    color: #854D0E;
    font-weight: 800;
    border-radius: 2px;
    padding: 0 1px;
}

/* ══════════════════════════════════════════════════════════
   MOBILE NEXT-LEVEL LUXURY SEARCH DRAWER (<768px)
   ══════════════════════════════════════════════════════════ */
/* Lock background page scrolling when search drawer is open */
body.mobile-search-open {
    overflow: hidden !important;
}

.mobile-sugg-content-body {
    flex: 1 !important;
    width: 100% !important;
    height: 100% !important;
    overflow-y: auto !important;
    -webkit-overflow-scrolling: touch !important;
    overscroll-behavior-y: contain !important;
    padding: 10px 12px 100px 12px !important;
    box-sizing: border-box !important;
    background: #FFFFFF !important;
}

/* 1-Line Smooth Horizontal Scrolling for Trending Ethnic Wear on Mobile */
.mobile-sugg-content-body .dt-sugg-trending-wrap {
    display: flex !important;
    flex-wrap: nowrap !important;
    overflow-x: auto !important;
    gap: 8px !important;
    padding: 4px 12px 10px 12px !important;
    margin: 0 -12px 8px -12px !important;
    -webkit-overflow-scrolling: touch !important;
    scrollbar-width: none !important;
}
.mobile-sugg-content-body .dt-sugg-trending-wrap::-webkit-scrollbar {
    display: none !important;
}
.mobile-sugg-content-body .dt-sugg-tag {
    display: inline-flex !important;
    align-items: center !important;
    gap: 5px !important;
    padding: 5px 12px !important;
    background: #FAF8F4 !important;
    border: 1px solid #D4AF37 !important;
    border-radius: 16px !important;
    font-size: 0.74rem !important;
    font-weight: 600 !important;
    color: #5A4210 !important;
    white-space: nowrap !important;
    flex-shrink: 0 !important;
    cursor: pointer !important;
    text-decoration: none !important;
    box-shadow: 0 1px 3px rgba(138,104,31,0.08) !important;
    transition: all 0.15s ease !important;
}
.mobile-sugg-content-body .dt-sugg-tag:hover,
.mobile-sugg-content-body .dt-sugg-tag:active {
    background: linear-gradient(135deg, #B8860B 0%, #D4AF37 100%) !important;
    color: #111827 !important;
    font-weight: 700 !important;
    border-color: #8A681F !important;
}

/* Auto-hide mobile bottom navigation when search drawer is active */
body.mobile-search-open .shop-smart-bottom-footer,
body.mobile-search-open #shopSmartBottomFooter,
body.mobile-search-open .home-smart-bottom-footer,
body.mobile-search-open #homeSmartBottomFooter,
body.mobile-search-open .dt-mobile-bottom-nav,
body.mobile-search-open #dtMobileBottomNav,
body.mobile-search-open .mobile-bottom-nav,
body.mobile-search-open .mobile-nav-bar,
body.mobile-search-open #mobileStickyNav,
body.mobile-search-open #mobileBottomBar {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
    pointer-events: none !important;
    transform: translateY(100%) !important;
}

/* Mobile Suggestion Product Card */
.mobile-sugg-product-card {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px;
    background: #FFFFFF;
    border: 1px solid #F1ECE1;
    border-radius: 8px;
    margin-bottom: 6px;
    text-decoration: none;
    color: inherit;
    transition: all 0.15s ease;
}
.mobile-sugg-product-card:active {
    background: #FAF6ED;
    border-color: #D4AF37;
}
.mobile-sugg-thumb {
    width: 60px;
    height: 60px;
    border-radius: 6px;
    object-fit: cover;
    background: #F9FAFB;
    border: 0.5px solid #E5E7EB;
    flex-shrink: 0;
}
.mobile-sugg-details {
    flex: 1;
    min-width: 0;
}
.mobile-sugg-title {
    font-size: 0.80rem;
    font-weight: 700;
    color: #111827;
    line-height: 1.25;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.mobile-sugg-pricing {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 3px;
}
.mobile-sugg-price {
    font-size: 0.86rem;
    font-weight: 800;
    color: #8A681F;
}
.mobile-sugg-mrp {
    font-size: 0.70rem;
    color: #9CA3AF;
    text-decoration: line-through;
}
.mobile-sugg-disc {
    font-size: 0.65rem;
    font-weight: 800;
    background: #FEF3C7;
    color: #92400E;
    padding: 0 4px;
    border-radius: 3px;
}

/* ── Mobile Layout & Ultra-Compact Zero-Vibration Layout (<768px) ── */
@media (max-width: 767px) {
    .shop-header {
        height: auto;
        padding: 0;
        gap: 0;
        transition: box-shadow 0.25s ease;
    }

    /* Fixed Ultra-Compact 38px Slot for Normal View */
    .header-normal-view {
        height: 38px;
        min-height: 38px;
        max-height: 38px;
        box-sizing: border-box;
        position: relative;
        padding: 0 10px;
        gap: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .header-left-group {
        position: static;
        display: flex;
        align-items: center;
        gap: 8px;
        z-index: 2;
    }
    .header-brand-link {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        margin: 0;
        z-index: 1;
        pointer-events: auto;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .header-brand-real-logo {
        height: 28px !important;
        max-height: 28px !important;
        width: auto !important;
        max-width: 135px !important;
        object-fit: contain;
    }
    .shop-back-btn {
        padding: 4px 9px;
        font-size: 0.70rem;
        gap: 4px;
        border-radius: 14px;
        z-index: 2;
    }
    .shop-back-btn svg {
        width: 12px;
        height: 12px;
    }
    .header-brand-name {
        font-size: 0.92rem;
    }
    .header-brand-tagline {
        font-size: 0.42rem;
        letter-spacing: 0.14em;
        margin-top: 1px;
    }
    .header-actions {
        position: relative;
        z-index: 2;
        gap: 6px;
    }
    .header-icon-btn {
        width: 30px;
        height: 30px;
    }
    .header-icon-btn svg {
        width: 15px;
        height: 15px;
    }
    .header-badge {
        min-width: 14px;
        height: 14px;
        font-size: 0.50rem;
        top: -3px;
        right: -3px;
    }
    .search-amazon-bar {
        display: none !important; /* Hidden on mobile by default */
    }
    .mobile-search-trigger-btn {
        display: flex !important;
    }
    #wishlistBtn {
        display: none !important;
    }

    /* Mobile In-Header Sticky Search Bar (<768px) */
    .mobile-full-search-bar {
        height: 38px !important;
        min-height: 38px !important;
        max-height: 38px !important;
        padding: 0 8px !important;
        gap: 6px !important;
        display: none !important;
        align-items: center !important;
        justify-content: space-between !important;
        box-sizing: border-box !important;
        background: #FFFFFF !important;
    }
    .shop-header.mobile-search-active .mobile-full-search-bar {
        display: flex !important;
    }

    /* Permanently Visible Ultra-Compact Category Subnav (Royal Gold Luxury Gradient) */
    .header-attached-subnav {
        height: 28px;
        min-height: 28px;
        max-height: 28px;
        padding: 0 8px;
        box-sizing: border-box;
        background: linear-gradient(90deg, #7A5B18 0%, #9C7724 50%, #7A5B18 100%);
        border-top: 1px solid rgba(255, 235, 180, 0.35);
        border-bottom: 1.5px solid #5C4310;
        box-shadow: 0 2px 8px rgba(122, 91, 24, 0.25);
    }
    .subnav-item {
        font-size: 0.65rem;
        padding: 2px 8px;
        height: 20px;
        gap: 4px;
        border-radius: 4px;
    }
    .subnav-icon {
        width: 11px;
        height: 11px;
    }
}
</style>

<header class="shop-header" id="shopHeader">

    <!-- ═══ Normal Header Bar (shown on desktop, and mobile default) ═══ -->
    <div class="header-normal-view" id="headerNormalView">
        <!-- Left: Back to Home Button (Shop page only) & Brand Logo -->
        <div class="header-left-group">
            <?php if (!$isHomePage): ?>
            <a href="/" class="shop-back-btn" id="shopBackBtn" aria-label="Back to Home">
                <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                <span>Home</span>
            </a>
            <?php endif; ?>

            <a href="/" class="header-brand-link" style="display:inline-flex; align-items:center; text-decoration:none;">
                <img src="/assets/images/logo.png" onerror="this.onerror=null; this.src='/Shared/Asset/images/logo.png';" alt="DT Brand's Ethnic Luxury" class="header-brand-real-logo" style="height:34px; width:auto; max-width:160px; object-fit:contain;">
            </a>
        </div>

        <!-- Center: Amazon-Style Always-Open Search Bar (Visible on Desktop) -->
        <div class="search-amazon-bar" id="searchAmazonBar">
            <div class="search-cat-dropdown-wrap">
                <?php
                $shCategories = class_exists('\DTBrand\ProductCatalog') ? \DTBrand\ProductCatalog::getCategories() : ['Saree', 'Lehenga', 'Gown', 'Kurti'];
                ?>
                <select class="search-cat-select" id="searchCatSelect" aria-label="Select category">
                    <option value="All">All Categories</option>
                    <?php foreach ($shCategories as $catName): ?>
                    <option value="<?= htmlspecialchars($catName) ?>" <?= (isset($selectedCategory) && strtolower($selectedCategory) === strtolower($catName)) ? 'selected' : '' ?>><?= htmlspecialchars($catName) ?></option>
                    <?php endforeach; ?>
                </select>
                <svg class="search-cat-arrow" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>

            <div class="search-input-wrap">
                <input
                    type="text"
                    class="search-input-amazon"
                    id="searchInput"
                    placeholder="Search luxury silk sarees, designer kurtis, bridal lehengas..."
                    autocomplete="off"
                    aria-label="Search products"
                />
                <button class="search-clear-btn" id="searchClearBtn" aria-label="Clear search">
                    <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>

            <button class="search-submit-btn" id="searchSubmitBtn" aria-label="Search">
                <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>

            <!-- ═══ Luxury Predictive Autocomplete & Product Suggestions Dropdown (Desktop) ═══ -->
            <div class="dt-search-suggestions-dropdown" id="searchSuggestionsDropdown" style="display:none;" role="listbox" aria-label="Search suggestions"></div>
        </div>

        <!-- Right Actions: Mobile Search Trigger, Wishlist, Cart -->
        <div class="header-actions">
            <!-- Mobile Search Icon Trigger Button (Shown on mobile only) -->
            <button class="header-icon-btn mobile-search-trigger-btn" id="mobileSearchTriggerBtn" aria-label="Open Search">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>

            <!-- Desktop Account Dropdown Button -->
            <div class="header-account-wrap" id="headerAccountWrap">
                <a href="javascript:void(0)" onclick="if(typeof window.handleUserWiseAccountNavigation==='function'){window.handleUserWiseAccountNavigation();}else if(typeof window.openAccountModal==='function'){window.openAccountModal('login');}else{window.location.href='/account.php?tab=login';}" class="header-account-btn" id="headerAccountBtn" aria-label="Account Access">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span id="headerAccountLabel">Account</span>
                </a>
                <div class="header-account-dropdown" id="headerAccountDropdown">
                    <a href="/" class="ac-drop-item" style="color:var(--dark-gold, #8A681F); font-weight:800;">
                        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>🏠 Home Page</span>
                    </a>
                    <a href="/shop" class="ac-drop-item">
                        <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        <span>🛍️ Shop All Catalog</span>
                    </a>
                    <a href="javascript:void(0)" onclick="if(typeof window.handleUserWiseAccountNavigation==='function'){window.handleUserWiseAccountNavigation();}else{window.openAccountModal('profile');}" class="ac-drop-item" id="acDropMyAccount">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span style="color:var(--dark-gold, #8A681F); font-weight:700;">My Account & Orders</span>
                    </a>
                    <a href="/wholesale.php" class="ac-drop-item" id="acDropWholesaler" style="display:none; color:#8A681F; font-weight:800;">
                        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>📦 Wholesaler B2B Hub</span>
                    </a>
                    <a href="javascript:void(0)" onclick="if(typeof window.openAccountModal==='function') window.openAccountModal('login');" class="ac-drop-item" id="acDropLogin">
                        <svg viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                        <span>Sign In / Login</span>
                    </a>
                    <a href="javascript:void(0)" onclick="if(typeof window.openAccountModal==='function') window.openAccountModal('register');" class="ac-drop-item" id="acDropRegister">
                        <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                        <span>Create Account</span>
                    </a>
                    <a href="javascript:void(0)" onclick="if(typeof window.openAccountModal==='function') window.openAccountModal('forgot');" class="ac-drop-item" id="acDropForgot">
                        <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        <span>Forgot Password</span>
                    </a>
                    <div class="ac-drop-divider" id="acDropDivider" style="display:none;"></div>
                    <a href="javascript:void(0)" class="ac-drop-item" id="acDropLogout" style="display:none; color:#D32F2F;" onclick="localStorage.removeItem('dtbrands_user'); window.location.href='/shop.php';">
                        <svg viewBox="0 0 24 24" style="stroke:#D32F2F;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <span>Log Out</span>
                    </a>
                </div>
            </div>

            <!-- Wishlist -->
            <a href="javascript:void(0)" onclick="if(typeof window.openWishlistDrawer==='function'){window.openWishlistDrawer();}else if(typeof window.openWishlist==='function'){window.openWishlist();}" class="header-icon-btn" id="wishlistBtn" aria-label="Wishlist">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <span class="header-badge" id="wishlistBadge" style="display:none;">0</span>
            </a>

            <!-- Cart -->
            <a href="javascript:void(0)" onclick="if(typeof window.openCartDrawer==='function'){window.openCartDrawer();}else if(typeof window.openCart==='function'){window.openCart();}" class="header-icon-btn" id="cartBtn" aria-label="Shopping cart">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
                <span class="header-badge" id="cartBadge" style="display:none;">0</span>
            </a>
        </div>
    </div>

    <!-- ═══ Mobile In-Header Sticky Search Bar (Wide & Clean Full-Width, Replaces Normal View on Search/Scroll) ═══ -->
    <div class="mobile-full-search-bar" id="mobileFullSearchBar">
        <!-- Center: Full-Width Search Input Bar with Gold Search Icon & Clear '✕' -->
        <div class="mobile-search-input-wrap">
            <svg class="mobile-search-lead-icon" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4" style="color:var(--dark-gold, #8A681F); flex-shrink:0; margin-right:4px;">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input
                type="text"
                class="mobile-search-input-field"
                id="mobileSearchInput"
                placeholder="Search sarees, lehengas, kurtis, gowns..."
                autocomplete="off"
                aria-label="Search ethnic wear"
            />
            <button type="button" class="mobile-search-clear-btn" id="mobileSearchClearBtn" aria-label="Clear search text">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
            <button type="button" class="mobile-search-submit-icon-btn" id="mobileSearchSubmitIconBtn" aria-label="Search">
                <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
        </div>

        <!-- Right: Close Button (Replaces Cart Icon) -->
        <div class="header-actions" style="gap:4px; flex-shrink:0;">
            <button type="button" class="mobile-header-close-btn" id="mobileSearchHeaderCloseBtn" aria-label="Close search">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
    </div>

    <!-- ═══ Mobile Search Suggestions & Products Dropdown (Opens on click/type) ═══ -->
    <div class="mobile-search-suggestions-dropdown" id="mobileSearchSuggestionsDropdown">
        <!-- Dynamic Scrollable Suggestions & Products Body -->
        <div class="mobile-sugg-content-body" id="mobileSuggContentBody"></div>
    </div>

    <!-- ═══ Amazon-Style Attached Sub-Navigation Bar ═══ -->
    <?php 
    require_once __DIR__ . '/../src/ProductCatalog.php';
    $headerCategories = \DTBrand\ProductCatalog::getCategories();
    ?>
    <?php if (empty($hideHeaderSubnav)): ?>
    <nav class="header-attached-subnav" id="headerAttachedSubnav" aria-label="Attached categories navigation">
        <div class="subnav-scroll-track" id="mainCatSliderTrack" role="tablist">
            <a href="/" class="subnav-item" style="text-decoration:none; display:inline-flex; align-items:center; color:inherit; font-weight:800;">
                <svg class="subnav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span>Home</span>
            </a>
            <a href="/shop" class="subnav-item" style="text-decoration:none; display:inline-flex; align-items:center; color:inherit; font-weight:800;">
                <svg class="subnav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                <span>Shop All</span>
            </a>
            <button class="subnav-item main-cat-tab <?= empty($selectedCategory) || strtolower($selectedCategory) === 'all' ? 'active' : '' ?>" role="tab" data-cat="All" aria-selected="<?= empty($selectedCategory) || strtolower($selectedCategory) === 'all' ? 'true' : 'false' ?>" onclick="if(typeof window.filterByBanner==='function'){window.filterByBanner('All');}else if(typeof window.filterHomeCategory==='function'){window.filterHomeCategory('All');}else{window.location.href='/shop?category=all';}">
                <svg class="subnav-icon" viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                <span>All Categories</span>
            </button>
            <?php foreach ($headerCategories as $hCat): 
                $isCatActive = isset($selectedCategory) && (strtolower($selectedCategory) === strtolower($hCat) || strtolower(str_replace('-', ' ', $selectedCategory)) === strtolower($hCat));
            ?>
            <button class="subnav-item main-cat-tab <?= $isCatActive ? 'active' : '' ?>" role="tab" data-cat="<?= htmlspecialchars($hCat) ?>" aria-selected="<?= $isCatActive ? 'true' : 'false' ?>" onclick="if(typeof window.filterByBanner==='function'){window.filterByBanner('<?= htmlspecialchars(addslashes($hCat)) ?>');}else if(typeof window.filterHomeCategory==='function'){window.filterHomeCategory('<?= htmlspecialchars(addslashes($hCat)) ?>');}else{window.location.href='/shop?category=<?= urlencode($hCat) ?>';}"><?= htmlspecialchars($hCat) ?></button>
            <?php endforeach; ?>
            <button class="subnav-item subnav-reels-btn" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(0);" aria-label="Watch Video Reels">
                <span>🎥 Reels</span>
            </button>
        </div>
    </nav>
    <?php endif; ?>

</header>

<script>
/* Global Cart & Wishlist Drawer Helpers (defined early) */
window.openCartDrawer = function() {
    var modal = document.getElementById('cartDrawerModal');
    if (modal) {
        modal.classList.add('active');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }
};
window.closeCartDrawer = function() {
    var modal = document.getElementById('cartDrawerModal');
    if (modal) {
        modal.classList.remove('active');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }
};
window.openWishlistDrawer = function() {
    var modal = document.getElementById('wishlistDrawerModal');
    if (modal) {
        modal.classList.add('active');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    }
};
window.closeWishlistDrawer = function() {
    var modal = document.getElementById('wishlistDrawerModal');
    if (modal) {
        modal.classList.remove('active');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }
};

(function () {
    /* Sticky scroll shadow */
    var header = document.getElementById('shopHeader');
    window.addEventListener('scroll', function () {
        if (header) header.classList.toggle('scrolled', window.scrollY > 10);
    }, { passive: true });

    /* Desktop Search Elements */
    var searchInput   = document.getElementById('searchInput');
    var searchCat     = document.getElementById('searchCatSelect');
    var searchClear   = document.getElementById('searchClearBtn');
    var searchSubmit  = document.getElementById('searchSubmitBtn');
    var suggDropdown  = document.getElementById('searchSuggestionsDropdown');

    /* Mobile Search Elements */
    var mobileSearchBtn    = document.getElementById('mobileSearchTriggerBtn');
    var mobileSearchClose  = document.getElementById('mobileSearchHeaderCloseBtn');
    var mobileSearchInput  = document.getElementById('mobileSearchInput');
    var mobileSearchClear  = document.getElementById('mobileSearchClearBtn');
    var mobileSearchSubmit = document.getElementById('mobileSearchSubmitIconBtn');
    var mobileSuggDropdown = document.getElementById('mobileSearchSuggestionsDropdown');
    var mobileSuggContent  = document.getElementById('mobileSuggContentBody');

    var searchDebounceTimer = null;
    var currentMobileCat = 'All';

    function performSearch(source, isSubmit) {
        var query = '';
        if (source === 'mobile' && mobileSearchInput) {
            query = mobileSearchInput.value.trim();
            if (searchInput) searchInput.value = query;
        } else if (searchInput) {
            query = searchInput.value.trim();
            if (mobileSearchInput) mobileSearchInput.value = query;
        }

        var cat = (searchCat ? searchCat.value : 'All');

        /* Toggle Clear buttons */
        if (searchClear) searchClear.style.display = query.length > 0 ? 'flex' : 'none';
        if (mobileSearchClear) mobileSearchClear.style.display = query.length > 0 ? 'flex' : 'none';

        if (typeof window.applyMasterFilters === 'function') {
            if (!window.masterFilterState) {
                window.masterFilterState = {
                    category: 'All',
                    colors: [],
                    sizes: [],
                    fabrics: [],
                    minPrice: 500,
                    maxPrice: 30000,
                    minDiscount: 0,
                    availability: [],
                    sortBy: 'recommended',
                    searchQuery: ''
                };
            }
            if (cat && cat !== 'All') {
                window.masterFilterState.category = cat;
            } else if (cat === 'All' && isSubmit) {
                window.masterFilterState.category = 'All';
            }
            window.masterFilterState.searchQuery = query;
            window.applyMasterFilters();

            if (isSubmit) {
                var grid = document.getElementById('productsGrid') || document.querySelector('.products-section');
                if (grid) {
                    var offset = grid.getBoundingClientRect().top + window.pageYOffset - 110;
                    window.scrollTo({ top: Math.max(0, offset), behavior: 'smooth' });
                }
            }
        } else if (isSubmit) {
            var targetUrl = '/shop.php?search=' + encodeURIComponent(query);
            if (cat && cat !== 'All') {
                targetUrl += '&category=' + encodeURIComponent(cat);
            }
            window.location.href = targetUrl;
        }
    }

    /* Desktop Events */
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            var q = searchInput.value.trim();
            performSearch('desktop', false);
            clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(function () {
                fetchSuggestions(q, (searchCat ? searchCat.value : 'All'), false);
            }, 120);
        });

        searchInput.addEventListener('focus', function() {
            var q = searchInput.value.trim();
            fetchSuggestions(q, (searchCat ? searchCat.value : 'All'), false);
        });

        searchInput.addEventListener('click', function() {
            var q = searchInput.value.trim();
            fetchSuggestions(q, (searchCat ? searchCat.value : 'All'), false);
        });

        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                performSearch('desktop', true);
                if (suggDropdown) suggDropdown.style.display = 'none';
                searchInput.blur();
            } else if (e.key === 'Escape') {
                if (suggDropdown) suggDropdown.style.display = 'none';
            }
        });
    }

    if (searchCat) {
        searchCat.addEventListener('change', function() {
            performSearch('desktop', true);
            var q = (searchInput ? searchInput.value.trim() : '');
            fetchSuggestions(q, searchCat.value, false);
        });
    }

    if (searchClear) {
        searchClear.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            if (mobileSearchInput) mobileSearchInput.value = '';
            performSearch('desktop', false);
            fetchSuggestions('', (searchCat ? searchCat.value : 'All'), false);
            if (searchInput) searchInput.focus();
        });
    }

    if (searchSubmit) {
        searchSubmit.addEventListener('click', function(e) {
            e.preventDefault();
            performSearch('desktop', true);
            if (suggDropdown) suggDropdown.style.display = 'none';
        });
    }

    // Close desktop suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#searchAmazonBar') && suggDropdown) {
            suggDropdown.style.display = 'none';
        }
    });

    /* Mobile Search Open / Close Controllers */
    function openMobileSearchDrawer() {
        if (header) header.classList.add('mobile-search-active');
        document.body.classList.add('mobile-search-open');

        var q = (mobileSearchInput ? mobileSearchInput.value.trim() : '');
        fetchSuggestions(q, currentMobileCat, true);
        if (mobileSearchInput) {
            mobileSearchInput.focus();
        }
    }

    function closeMobileSearchDrawer(resetText) {
        document.body.classList.remove('mobile-search-open');
        var sy = window.scrollY || window.pageYOffset || 0;
        if (sy < 45 && header) {
            header.classList.remove('mobile-search-active');
        }
        if (resetText) {
            if (mobileSearchInput) mobileSearchInput.value = '';
            if (searchInput) searchInput.value = '';
            performSearch('mobile', false);
        }
    }

    if (mobileSearchBtn) {
        mobileSearchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            openMobileSearchDrawer();
        });
    }

    if (mobileSearchClose) {
        mobileSearchClose.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeMobileSearchDrawer(false);
        });
    }

    if (mobileSearchSubmit) {
        mobileSearchSubmit.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            performSearch('mobile', true);
            closeMobileSearchDrawer(false);
            if (mobileSearchInput) mobileSearchInput.blur();
        });
    }

    if (mobileSearchInput) {
        mobileSearchInput.addEventListener('input', function() {
            var q = mobileSearchInput.value.trim();
            if (header) header.classList.add('mobile-search-active');
            document.body.classList.add('mobile-search-open');
            performSearch('mobile', false);
            clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(function () {
                fetchSuggestions(q, currentMobileCat, true);
            }, 100);
        });

        mobileSearchInput.addEventListener('focus', function() {
            if (header) header.classList.add('mobile-search-active');
            document.body.classList.add('mobile-search-open');
            var q = mobileSearchInput.value.trim();
            fetchSuggestions(q, currentMobileCat, true);
        });

        mobileSearchInput.addEventListener('click', function(e) {
            e.stopPropagation();
            if (header) header.classList.add('mobile-search-active');
            document.body.classList.add('mobile-search-open');
            var q = mobileSearchInput.value.trim();
            fetchSuggestions(q, currentMobileCat, true);
        });

        mobileSearchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                performSearch('mobile', true);
                closeMobileSearchDrawer(false);
                mobileSearchInput.blur();
            } else if (e.key === 'Escape') {
                closeMobileSearchDrawer(false);
            }
        });
    }

    // Close suggestions dropdown on outside click
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#mobileFullSearchBar') && 
            !e.target.closest('#mobileSearchSuggestionsDropdown') && 
            !e.target.closest('#mobileSearchTriggerBtn') &&
            !e.target.closest('#searchAmazonBar')) {
            if (document.body.classList.contains('mobile-search-open')) {
                closeMobileSearchDrawer(false);
            }
        }
    });

    if (mobileSearchClear) {
        mobileSearchClear.addEventListener('click', function(e) {
            e.stopPropagation();
            if (mobileSearchInput) {
                mobileSearchInput.value = '';
                mobileSearchInput.focus();
            }
            if (searchInput) searchInput.value = '';
            performSearch('mobile', false);
            fetchSuggestions('', currentMobileCat, true);
        });
    }

    // Mobile Category Chips Filter
    if (mobileSuggCatChips && mobileSuggCatChips.length > 0) {
        mobileSuggCatChips.forEach(function (chip) {
            chip.addEventListener('click', function () {
                mobileSuggCatChips.forEach(function (c) { c.classList.remove('active'); });
                this.classList.add('active');
                currentMobileCat = this.dataset.cat || 'All';
                var q = (mobileSearchInput ? mobileSearchInput.value.trim() : '');
                fetchSuggestions(q, currentMobileCat, true);
            });
        });
    }

    /* ══════════════════════════════════════════════════════════
       PREDICTIVE SEARCH & SUGGESTIONS ENGINE (DESKTOP & MOBILE)
       ══════════════════════════════════════════════════════════ */

    function highlightKeywords(text, q) {
        if (!q || !text) return text;
        var rawQ = q.toLowerCase().trim();
        rawQ = rawQ.replace(/\b(sarees|lehengas|gowns|kurtis)\b/g, function(m){ return m.slice(0,-1); });
        var words = rawQ.split(/[\s,\-\+]+/).filter(function(w){ return w.length > 1; });
        if (words.length === 0) return text;

        var regex = new RegExp('(' + words.map(function(w){
            return w.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }).join('|') + ')', 'gi');

        return text.replace(regex, '<mark class="dt-search-highlight">$1</mark>');
    }

    function renderSuggestionsHTML(data, query, isMobile) {
        var html = '';
        var q = (query || '').trim().toLowerCase();

        // 1. Trending searches
        if (data.trending && data.trending.length > 0) {
            html += '<div class="dt-sugg-section-header">🔥 Trending in Ethnic Wear</div>';
            html += '<div class="dt-sugg-trending-wrap">';
            data.trending.forEach(function (tag) {
                html += '<a href="javascript:void(0)" class="dt-sugg-tag" data-tag="' + tag + '">' +
                        '<svg viewBox="0 0 24 24" style="width:12px;height:12px;stroke:#8A681F;fill:none;stroke-width:2.2;"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>' +
                        tag + '</a>';
            });
            html += '</div>';
        }

        // 2. Matching Categories
        if (data.categories && data.categories.length > 0) {
            html += '<div class="dt-sugg-section-header">📁 Matching Categories</div>';
            data.categories.forEach(function (c) {
                var cName = c.name;
                var highlightedName = highlightKeywords(cName, q);
                html += '<a href="/shop.php?category=' + encodeURIComponent(c.name) + '" class="dt-sugg-cat-item">' +
                        '<div style="display:flex;align-items:center;gap:8px;">' +
                        '<svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:#8A681F;fill:none;stroke-width:2.2;"><polyline points="9 18 15 12 9 6"></polyline></svg>' +
                        '<span>' + highlightedName + '</span>' +
                        '</div>' +
                        '<span style="font-size:0.70rem;color:#8A681F;font-weight:700;">Explore Category ➔</span>' +
                        '</a>';
            });
        }

        // 3. Matching Live Products
        if (data.products && data.products.length > 0) {
            html += '<div class="dt-sugg-section-header">💎 ' + (q ? 'Matching Ensembles (' + (data.total || data.products.length) + ')' : 'Popular Handpicked Ensembles') + '</div>';

            if (isMobile) {
                data.products.forEach(function (p) {
                    var pTitle = p.title || p.name;
                    var highlightedTitle = highlightKeywords(pTitle, q);
                    html += '<a href="' + p.url + '" class="mobile-sugg-product-card">' +
                            '<img src="' + p.image + '" class="mobile-sugg-thumb" alt="' + pTitle + '" loading="lazy" onerror="this.src=\'/assets/images/product1.png\';" />' +
                            '<div class="mobile-sugg-details">' +
                            '<div class="mobile-sugg-title">' + highlightedTitle + '</div>' +
                            '<div style="display:flex;gap:4px;margin-top:3px;align-items:center;">' +
                            '<span style="font-size:0.68rem;color:#8A681F;font-weight:700;background:#FAF5E8;padding:1px 5px;border-radius:3px;border:0.5px solid #D4AF37;">' + p.category + '</span>' +
                            (p.fabric ? '<span style="font-size:0.68rem;color:#6B7280;">• ' + p.fabric + '</span>' : '') +
                            '</div>' +
                            '<div class="mobile-sugg-pricing">' +
                            '<span class="mobile-sugg-price">₹' + Number(p.price).toLocaleString('en-IN') + '</span>' +
                            (p.old_price > p.price ? '<span class="mobile-sugg-mrp">₹' + Number(p.old_price).toLocaleString('en-IN') + '</span>' : '') +
                            (p.discount_pct > 0 ? '<span class="mobile-sugg-disc">' + p.discount_pct + '% OFF</span>' : '') +
                            '</div>' +
                            '</div>' +
                            '<div style="font-size:0.70rem;color:#8A681F;font-weight:800;padding:4px 8px;background:#FAF5E8;border:1px solid #D4AF37;border-radius:12px;flex-shrink:0;">View ➔</div>' +
                            '</a>';
                });
            } else {
                data.products.forEach(function (p) {
                    var pTitle = p.title || p.name;
                    var highlightedTitle = highlightKeywords(pTitle, q);
                    html += '<a href="' + p.url + '" class="dt-sugg-product-item">' +
                            '<img src="' + p.image + '" class="dt-sugg-thumb" alt="' + pTitle + '" loading="lazy" onerror="this.src=\'/assets/images/product1.png\';" />' +
                            '<div class="dt-sugg-info">' +
                            '<div class="dt-sugg-title">' + highlightedTitle + '</div>' +
                            '<div class="dt-sugg-meta">' +
                            '<span class="dt-sugg-badge">' + p.category + '</span>' +
                            (p.fabric ? '<span>' + p.fabric + '</span>' : '') +
                            (p.sku ? '<span style="font-family:monospace;font-size:0.68rem;color:#9CA3AF;">' + p.sku + '</span>' : '') +
                            '</div>' +
                            '<div class="dt-sugg-pricing">' +
                            '<span class="dt-sugg-price">₹' + Number(p.price).toLocaleString('en-IN') + '</span>' +
                            (p.old_price > p.price ? '<span class="dt-sugg-mrp">₹' + Number(p.old_price).toLocaleString('en-IN') + '</span>' : '') +
                            (p.discount_pct > 0 ? '<span class="dt-sugg-disc">' + p.discount_pct + '% OFF</span>' : '') +
                            '</div>' +
                            '</div>' +
                            '<span class="dt-sugg-view-btn">View Product ➔</span>' +
                            '</a>';
                });
            }

            // Master Bottom View All Button
            html += '<a href="javascript:void(0)" class="dt-sugg-footer-btn" onclick="if(typeof performSearch===\'function\'){performSearch(\'' + (isMobile ? 'mobile' : 'desktop') + '\', true);}">' +
                    '<span>Explore All ' + (data.total || data.products.length) + ' Results ' + (query ? 'for &ldquo;' + query + '&rdquo;' : '') + ' ➔</span>' +
                    '</a>';
        } else if (q) {
            html += '<div style="padding:24px 16px;text-align:center;color:#6B7280;font-size:0.82rem;">' +
                    '<div style="font-size:1.4rem;margin-bottom:6px;">🔍</div>' +
                    '<div style="font-weight:700;color:#111827;margin-bottom:4px;">No matching ethnic wear found for &ldquo;' + query + '&rdquo;</div>' +
                    '<div>Try searching for <strong>Silk Sarees</strong>, <strong>Bridal Lehengas</strong>, or <strong>Kurtis</strong></div>' +
                    '</div>';
        }

        return html;
    }

    function fetchSuggestions(query, cat, isMobile) {
        var targetContainer = isMobile ? mobileSuggContent : suggDropdown;
        if (!targetContainer) return;

        var url = '/api/search.php?q=' + encodeURIComponent(query || '') + '&cat=' + encodeURIComponent(cat || 'All');
        fetch(url)
            .then(function (r) { return r.json(); })
            .then(function (res) {
                var data = (res.data || res.results || {});
                var html = renderSuggestionsHTML(data, query, isMobile);
                targetContainer.innerHTML = html;
                if (!isMobile && suggDropdown) {
                    suggDropdown.style.display = 'block';
                }

                // Bind click event on trending tags
                targetContainer.querySelectorAll('.dt-sugg-tag').forEach(function (tagEl) {
                    tagEl.addEventListener('click', function (e) {
                        e.preventDefault();
                        var tagVal = this.dataset.tag;
                        if (isMobile && mobileSearchInput) {
                            mobileSearchInput.value = tagVal;
                            if (searchInput) searchInput.value = tagVal;
                            performSearch('mobile', false);
                            fetchSuggestions(tagVal, currentMobileCat, true);
                        } else if (searchInput) {
                            searchInput.value = tagVal;
                            if (mobileSearchInput) mobileSearchInput.value = tagVal;
                            performSearch('desktop', false);
                            fetchSuggestions(tagVal, (searchCat ? searchCat.value : 'All'), false);
                        }
                    });
                });
            })
            .catch(function (err) {
                console.error('Search suggestions error:', err);
            });
    }

    /* Sync Desktop Account Button with Logged In User State */
    function syncHeaderAccountState() {
        var userRaw = localStorage.getItem('dtbrands_user');
        var label = document.getElementById('headerAccountLabel');
        var dropLogin = document.getElementById('acDropLogin');
        var dropRegister = document.getElementById('acDropRegister');
        var dropForgot = document.getElementById('acDropForgot');
        var dropWholesaler = document.getElementById('acDropWholesaler');
        var dropDivider = document.getElementById('acDropDivider');
        var dropLogout = document.getElementById('acDropLogout');

        if (userRaw && label) {
            var user = JSON.parse(userRaw);
            var firstName = (user.name || 'Member').split(' ')[0];
            var role = (user.role || '').toLowerCase();
            label.textContent = firstName;
            if (dropWholesaler) {
                if (role === 'wholesaler') {
                    dropWholesaler.style.display = 'flex';
                    dropWholesaler.href = '/wholesale.php';
                    var span = dropWholesaler.querySelector('span');
                    if (span) span.textContent = '📦 Wholesaler B2B Hub';
                } else if (role === 'retailer') {
                    dropWholesaler.style.display = 'flex';
                    dropWholesaler.href = '/retailer.php';
                    var span = dropWholesaler.querySelector('span');
                    if (span) span.textContent = '🛍️ Retailer B2B Hub';
                } else if (role === 'reseller') {
                    dropWholesaler.style.display = 'flex';
                    dropWholesaler.href = '/reseller.php';
                    var span = dropWholesaler.querySelector('span');
                    if (span) span.textContent = '💼 Reseller B2B Hub';
                } else {
                    dropWholesaler.style.display = 'none';
                }
            }
            if (dropLogin) dropLogin.style.display = 'none';
            if (dropRegister) dropRegister.style.display = 'none';
            if (dropForgot) dropForgot.style.display = 'none';
            if (dropDivider) dropDivider.style.display = 'block';
            if (dropLogout) dropLogout.style.display = 'flex';
        } else if (label) {
            label.textContent = 'Account';
            if (dropWholesaler) dropWholesaler.style.display = 'none';
            if (dropLogin) dropLogin.style.display = 'flex';
            if (dropRegister) dropRegister.style.display = 'flex';
            if (dropForgot) dropForgot.style.display = 'flex';
            if (dropDivider) dropDivider.style.display = 'none';
            if (dropLogout) dropLogout.style.display = 'none';
        }
    }



    /* Smooth Zero-Jitter Scroll Engine */
    var isShopHeaderScrolled = false;
    var scrollTicking = false;

    window.addEventListener('scroll', function() {
        if (!scrollTicking) {
            window.requestAnimationFrame(function() {
                var sy = window.scrollY || window.pageYOffset || 0;
                if (header) {
                    var isMobile = window.innerWidth <= 767;
                    if (sy > 45) {
                        if (!isShopHeaderScrolled) {
                            isShopHeaderScrolled = true;
                            header.classList.add('scrolled');
                        }
                        if (isMobile && !header.classList.contains('mobile-search-active')) {
                            header.classList.add('mobile-search-active');
                        }
                    } else if (sy < 10) {
                        if (isShopHeaderScrolled) {
                            isShopHeaderScrolled = false;
                            header.classList.remove('scrolled');
                        }
                        if (isMobile && !document.body.classList.contains('mobile-search-open') && (!mobileSearchInput || !mobileSearchInput.value.trim())) {
                            header.classList.remove('mobile-search-active');
                        }
                    }
                }
                scrollTicking = false;
            });
            scrollTicking = true;
        }
    }, { passive: true });

    syncHeaderAccountState();
    window.addEventListener('storage', syncHeaderAccountState);
})();
</script>
