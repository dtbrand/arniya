<?php
/**
 * shopbottomfotoer.php — PARTIAL INCLUDE
 * Mobile: Fixed bottom bar + Myntra-style full-screen filter overlay
 * Desktop: Bottom bar hidden (sidebar handles filters)
 */
?>
<style>
/* ════════════════════════════════════════════════════
   LUXURY SMART MOBILE BOTTOM FOOTER (ROUNDED HOME STYLE)
════════════════════════════════════════════════════ */
.shop-smart-bottom-footer {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    padding: 0 12px;
    padding-bottom: max(8px, env(safe-area-inset-bottom, 8px));
    pointer-events: none;
    transition: transform 0.32s cubic-bezier(0.34, 1.25, 0.64, 1), opacity 0.28s ease, visibility 0.28s ease;
    transform: translateY(0);
    opacity: 1;
    visibility: visible;
}

.shop-smart-bottom-footer.is-hidden {
    transform: translateY(140%) !important;
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
}

/* Auto-hide via body classes when any overlay, drawer, sheet, or modal is active */
body.mf-open .shop-smart-bottom-footer,
body.sort-open .shop-smart-bottom-footer,
body.more-open .shop-smart-bottom-footer,
body.cart-open .shop-smart-bottom-footer,
body.wishlist-open .shop-smart-bottom-footer,
body.modal-open .shop-smart-bottom-footer,
body.reels-open .shop-smart-bottom-footer,
body.reels-modal-open .shop-smart-bottom-footer,
body.drawer-open .shop-smart-bottom-footer {
    transform: translateY(140%) !important;
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
}

@media (max-width: 1023px) {
    .shop-smart-bottom-footer {
        display: block;
    }
    body {
        padding-bottom: 0 !important;
    }
}
@media (min-width: 1024px) {
    .shop-smart-bottom-footer {
        display: none !important;
    }
}

@property --dt-border-angle {
    syntax: "<angle>";
    inherits: false;
    initial-value: 0deg;
}

@keyframes dtGoldPlatinumRun {
    to {
        --dt-border-angle: 360deg;
    }
}

.shop-smart-nav-wrapper {
    position: relative;
    max-width: 440px;
    margin: 0 auto;
    border: 2px solid transparent !important;
    border-radius: 30px !important;
    background: linear-gradient(180deg, #221D18 0%, #14110E 100%) padding-box,
                conic-gradient(from var(--dt-border-angle), #D4AF37 0deg, #FFFFFF 60deg, #E2E8F0 120deg, #D4AF37 180deg, #FFFFFF 240deg, #B8860B 300deg, #D4AF37 360deg) border-box !important;
    animation: dtGoldPlatinumRun 2.5s linear infinite !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.55), 0 0 16px rgba(212, 175, 55, 0.35) !important;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    pointer-events: auto;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: space-around;
    padding: 0 4px;
    user-select: none;
    -webkit-user-select: none;
}

.shop-smart-nav-item {
    position: relative;
    flex: 1;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-end;
    padding-bottom: 9px;
    text-decoration: none;
    color: #A89F91;
    z-index: 5;
    transition: color 0.25s ease, transform 0.2s ease;
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
    border: none;
    background: transparent;
}

.shop-smart-nav-icon-box {
    position: relative;
    width: 32px;
    height: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 3px;
    transition: transform 0.25s ease, color 0.25s ease;
}

.shop-smart-nav-svg {
    width: 22px;
    height: 22px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    transition: all 0.25s ease;
}

.shop-smart-nav-label {
    font-family: var(--font-sans, 'Inter', -apple-system, sans-serif);
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    margin: 0;
    line-height: 1;
    transition: color 0.25s ease, font-weight 0.25s ease;
    opacity: 0.9;
    white-space: nowrap;
    color: inherit;
}

.shop-smart-nav-item:hover,
.shop-smart-nav-item:active,
.shop-smart-nav-item.active {
    color: #F5D77F;
}

.shop-smart-nav-item:hover .shop-smart-nav-svg,
.shop-smart-nav-item:active .shop-smart-nav-svg,
.shop-smart-nav-item.active .shop-smart-nav-svg {
    stroke: #F5D77F;
    transform: translateY(-2px) scale(1.08);
}

.shop-smart-nav-item.active .shop-smart-nav-label {
    color: #F5D77F;
    font-weight: 800;
    opacity: 1;
}

/* ── PERMANENT HERO REELS (Elevated Center Floating Bubble with Animated 🔥 HOT Badge) ── */
.shop-smart-nav-hero-reels {
    position: relative;
    flex: 1.15;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-end;
    padding-bottom: 7px;
    text-decoration: none;
    color: #F5D77F;
    z-index: 10;
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
}

.shop-smart-hero-bubble {
    position: absolute;
    top: -20px;
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #F5D77F 0%, #D4AF37 40%, #8A681F 100%);
    box-shadow: 0 8px 24px rgba(212, 175, 55, 0.55), 0 2px 8px rgba(0, 0, 0, 0.4), inset 0 2px 5px rgba(255, 255, 255, 0.5);
    border: 3.5px solid #181512;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.28s ease;
}

.shop-smart-hero-bubble svg {
    width: 24px;
    height: 24px;
    stroke: #FFFFFF;
    stroke-width: 2.2;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.35));
    animation: shopReelsPulse 2.4s infinite ease-in-out;
}

.shop-smart-nav-hero-reels:hover .shop-smart-hero-bubble,
.shop-smart-nav-hero-reels:active .shop-smart-hero-bubble {
    transform: translateY(-4px) scale(1.08);
    box-shadow: 0 12px 28px rgba(212, 175, 55, 0.7), 0 4px 12px rgba(0, 0, 0, 0.5);
}

@keyframes shopReelsPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.08); }
}

.shop-smart-hero-hot-badge {
    position: absolute;
    top: -5px;
    right: -6px;
    background: linear-gradient(135deg, #EF4444 0%, #DC2626 50%, #991B1B 100%);
    color: #FFFFFF;
    font-size: 0.48rem;
    font-weight: 900;
    letter-spacing: 0.05em;
    padding: 1.5px 5.5px;
    border-radius: 12px;
    border: 1.5px solid #181512;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.6), 0 0 8px rgba(239, 68, 68, 0.4);
    display: inline-flex;
    align-items: center;
    gap: 2px;
    z-index: 12;
    animation: shopHotBadgePulse 1.8s infinite ease-in-out;
    text-transform: uppercase;
}

@keyframes shopHotBadgePulse {
    0%, 100% { transform: scale(1); box-shadow: 0 2px 8px rgba(239, 68, 68, 0.6); }
    50% { transform: scale(1.14); box-shadow: 0 4px 14px rgba(239, 68, 68, 0.85); }
}

.shop-smart-nav-hero-label {
    font-family: var(--font-sans, 'Inter', -apple-system, sans-serif);
    font-size: 0.58rem;
    font-weight: 800;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    margin: 0;
    line-height: 1;
    color: #F5D77F;
    white-space: nowrap;
}

.shop-smart-nav-badge {
    position: absolute;
    top: -2px;
    right: -4px;
    background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
    color: #FFFFFF;
    font-size: 0.50rem;
    font-weight: 900;
    min-width: 15px;
    height: 15px;
    border-radius: 10px;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 0 3px;
    border: 1.5px solid #181512;
    box-shadow: 0 2px 6px rgba(220, 38, 38, 0.4);
    z-index: 6;
}

/* ════════════════════════════════════════════════════
   MYNTRA MOBILE FILTER (full-screen overlay)
════════════════════════════════════════════════════ */
.mf-overlay {
    position: fixed; inset: 0;
    z-index: 2000;
    display: flex;
    flex-direction: column;
    background: var(--off-white);
    transform: translateY(100%);
    transition: transform 0.36s cubic-bezier(0.32,0.72,0,1);
}
.mf-overlay.open { transform: translateY(0); }
@media (min-width: 1024px) { .mf-overlay { display: none !important; } }

/* Top bar */
.mf-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 18px;
    height: 54px;
    border-bottom: 1px solid var(--soft-platinum);
    flex-shrink: 0;
    background: var(--off-white);
}
.mf-title-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
}
.mf-title {
    font-family: var(--font-serif);
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--dark-text);
    letter-spacing: 0.1em;
    text-transform: uppercase;
}
.mf-title-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 18px;
    height: 18px;
    padding: 0 6px;
    border-radius: 9px;
    background: var(--dark-gold);
    color: #fff;
    font-family: var(--font-sans);
    font-size: 0.62rem;
    font-weight: 700;
}
.mf-close-btn {
    width: 34px; height: 34px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 50%;
    border: 1.5px solid var(--soft-platinum);
    background: transparent;
    color: var(--mid-text);
    cursor: pointer;
    transition: all var(--transition);
}
.mf-close-btn:hover { border-color: var(--dark-gold); color: var(--dark-gold); }
.mf-close-btn svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; }

/* Body: left tabs + right content */
.mf-body {
    display: flex;
    flex: 1;
    overflow: hidden;
}

/* Left tab list */
.mf-tabs {
    width: 120px;
    flex-shrink: 0;
    background: #EDEAE3;
    border-right: 1px solid var(--soft-platinum);
    overflow-y: auto;
    scrollbar-width: none;
}
.mf-tabs::-webkit-scrollbar { display: none; }
.mf-tab {
    display: block;
    width: 100%;
    padding: 16px 12px;
    border: none;
    background: transparent;
    font-family: var(--font-sans);
    font-size: 0.72rem;
    font-weight: 600;
    color: var(--mid-text);
    text-align: left;
    cursor: pointer;
    border-left: 3.5px solid transparent;
    transition: all 0.2s;
    letter-spacing: 0.04em;
    line-height: 1.3;
    position: relative;
}
.mf-tab:hover { color: var(--dark-gold); background: rgba(138,104,31,0.04); }
.mf-tab.active {
    background: var(--off-white);
    color: var(--dark-gold);
    font-weight: 700;
    border-left-color: var(--dark-gold);
}
.mf-tab-dot {
    display: inline-block;
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--dark-gold);
    margin-left: 4px;
    vertical-align: middle;
    opacity: 0;
    transition: opacity 0.2s;
}
.mf-tab.has-selection .mf-tab-dot { opacity: 1; }

/* Right content panel */
.mf-content {
    flex: 1;
    overflow-y: auto;
    padding: 16px 16px 12px;
    scrollbar-width: none;
}
.mf-content::-webkit-scrollbar { display: none; }

.mf-panel { display: none; }
.mf-panel.active { display: block; }
.mf-panel-title {
    font-family: var(--font-sans);
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--light-text);
    letter-spacing: 0.18em;
    text-transform: uppercase;
    margin-bottom: 14px;
}

.mf-options { display: flex; flex-wrap: wrap; gap: 8px; }
.mf-chip {
    padding: 8px 14px;
    border-radius: 20px;
    border: 1.5px solid var(--soft-platinum);
    background: var(--off-white);
    font-size: 0.75rem; font-weight: 500;
    color: var(--mid-text);
    cursor: pointer;
    transition: all var(--transition);
    letter-spacing: 0.04em;
}
.mf-chip:hover { border-color: var(--dark-gold); color: var(--dark-gold); }
.mf-chip.active {
    border-color: var(--dark-gold);
    background: var(--dark-gold);
    color: var(--off-white);
    font-weight: 600;
}

/* Color swatches in panel */
.mf-swatches { display: flex; flex-wrap: wrap; gap: 10px; padding-top: 4px; }
.mf-swatch-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 12px;
    border-radius: 20px;
    border: 1.5px solid var(--soft-platinum);
    background: var(--off-white);
    cursor: pointer;
    transition: all var(--transition);
}
.mf-swatch-item.active {
    border-color: var(--dark-gold);
    background: var(--gold-pale);
}
.mf-swatch-circle {
    width: 18px; height: 18px; border-radius: 50%;
    border: 1px solid rgba(0,0,0,0.12);
    flex-shrink: 0;
}
.mf-swatch-label { font-size: 0.73rem; font-weight: 600; color: var(--dark-text); }

/* Price Range in Mobile Panel */
.mf-range-track {
    position: relative;
    height: 10px;
    background: #E2DFD7;
    border: 1px solid #D4D0C5;
    border-radius: 5px;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
    margin: 26px 4px 20px 4px;
}
.mf-range-fill {
    position: absolute;
    height: 100%;
    background: linear-gradient(90deg, #6F5218 0%, #8A681F 50%, #B8921F 100%);
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(138, 104, 31, 0.45);
    left: 0%; right: 0%;
    transition: left 0.08s ease, right 0.08s ease;
}
input[type=range].mf-range {
    position: absolute;
    top: -7px; left: 0;
    width: 100%; height: 10px;
    appearance: none;
    background: transparent;
    cursor: pointer;
    pointer-events: none;
    z-index: 3;
}
input[type=range].mf-range::-webkit-slider-thumb {
    pointer-events: auto;
    appearance: none;
    width: 24px; height: 24px;
    border-radius: 50%;
    background: #FFFFFF;
    border: 3.5px solid var(--dark-gold);
    box-shadow: 0 3px 12px rgba(138, 104, 31, 0.45), 0 1px 3px rgba(0,0,0,0.15);
    cursor: grab;
    transition: transform 0.2s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.2s ease;
}
input[type=range].mf-range::-webkit-slider-thumb:hover,
input[type=range].mf-range::-webkit-slider-thumb:active {
    transform: scale(1.25);
    box-shadow: 0 0 0 7px rgba(138, 104, 31, 0.22);
    border-color: var(--deep-gold);
}
input[type=range].mf-range::-moz-range-thumb {
    pointer-events: auto;
    width: 24px; height: 24px;
    border-radius: 50%;
    background: #FFFFFF;
    border: 3.5px solid var(--dark-gold);
    box-shadow: 0 3px 12px rgba(138, 104, 31, 0.45);
}

/* Bottom action bar */
.mf-footer {
    display: flex;
    gap: 0;
    flex-shrink: 0;
    border-top: 1px solid var(--soft-platinum);
    background: var(--off-white);
    padding-bottom: env(safe-area-inset-bottom, 0px);
}
.mf-clear-btn {
    flex: 1; padding: 16px 8px;
    border: none; background: transparent;
    font-family: var(--font-sans);
    font-size: 0.78rem; font-weight: 700;
    letter-spacing: 0.1em; text-transform: uppercase;
    color: var(--mid-text); cursor: pointer;
    border-right: 1px solid var(--soft-platinum);
    transition: color var(--transition);
}
.mf-clear-btn:hover { color: var(--dark-gold); }
.mf-apply-btn {
    flex: 2; padding: 16px 8px;
    border: none;
    background: var(--dark-gold);
    font-family: var(--font-sans);
    font-size: 0.78rem; font-weight: 700;
    letter-spacing: 0.14em; text-transform: uppercase;
    color: var(--off-white); cursor: pointer;
    transition: background var(--transition);
}
.mf-apply-btn:hover { background: var(--deep-gold); }

/* ════════════════════════════════════════════════════
   SORT BOTTOM SHEET
════════════════════════════════════════════════════ */
.sheet-overlay {
    position: fixed; inset: 0;
    background: rgba(36,33,28,0.48);
    z-index: 1100;
    opacity: 0; pointer-events: none;
    transition: opacity var(--transition);
    backdrop-filter: blur(2px);
}
.sheet-overlay.open { opacity: 1; pointer-events: all; }

.bottom-sheet {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    background: var(--off-white);
    border-radius: 20px 20px 0 0;
    z-index: 1200;
    transform: translateY(100%);
    transition: transform 0.36s cubic-bezier(0.32,0.72,0,1);
    padding-bottom: env(safe-area-inset-bottom, 0px);
    max-height: 80vh;
    overflow: hidden;
    display: flex; flex-direction: column;
}
.bottom-sheet.open { transform: translateY(0); }
.sheet-handle { width: 34px; height: 4px; background: var(--soft-platinum); border-radius: 2px; margin: 12px auto 0; flex-shrink: 0; }
.sheet-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 12px 20px 12px; border-bottom: 1px solid var(--soft-platinum); flex-shrink: 0;
}
.sheet-title { font-family: var(--font-serif); font-size: 0.9rem; font-weight: 600; color: var(--dark-text); letter-spacing: 0.08em; }
.sheet-close-btn {
    width: 28px; height: 28px; border-radius: 50%;
    border: 1px solid var(--soft-platinum); background: var(--off-white);
    display: flex; align-items: center; justify-content: center;
    color: var(--mid-text); cursor: pointer; transition: all var(--transition);
}
.sheet-close-btn:hover { border-color: var(--dark-gold); color: var(--dark-gold); }
.sheet-close-btn svg { width: 12px; height: 12px; stroke: currentColor; fill: none; }
.sheet-body { overflow-y: auto; flex: 1; padding: 0 20px 12px; scrollbar-width: none; }
.sheet-body::-webkit-scrollbar { display: none; }

.sort-option {
    display: flex; align-items: center; justify-content: space-between;
    padding: 14px 0;
    border-bottom: 1px solid var(--soft-platinum);
    cursor: pointer; transition: padding-left 0.2s;
}
.sort-option:last-child { border-bottom: none; }
.sort-option:hover { padding-left: 4px; }
.sort-label { font-size: 0.84rem; font-weight: 500; color: var(--dark-text); transition: color 0.2s; }
.sort-option:hover .sort-label { color: var(--dark-gold); }
.sort-check {
    width: 20px; height: 20px; border-radius: 50%;
    border: 2px solid var(--soft-platinum);
    display: flex; align-items: center; justify-content: center;
    transition: all var(--transition); flex-shrink: 0;
}
.sort-option.active .sort-label { color: var(--dark-gold); font-weight: 700; }
.sort-option.active .sort-check { background: var(--dark-gold); border-color: var(--dark-gold); }
.sort-check-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--off-white); display: none; }
.sort-option.active .sort-check-dot { display: block; }

.add-action-item {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 0;
    border-bottom: 1px solid var(--soft-platinum);
    cursor: pointer; transition: padding-left 0.2s;
}
.add-action-item:last-child { border-bottom: none; }
.add-action-item:hover { padding-left: 4px; }
.add-action-icon {
    width: 38px; height: 38px; border-radius: 10px;
    background: var(--gold-pale); border: 1px solid rgba(138,104,31,0.15);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.add-action-icon svg { width: 17px; height: 17px; stroke: var(--dark-gold); fill: none; stroke-width: 1.8; }
.add-action-label { font-size: 0.84rem; font-weight: 600; color: var(--dark-text); }
.add-action-sub { font-size: 0.68rem; color: var(--light-text); margin-top: 1px; }
</style>

<!-- ════ LUXURY SMART MOBILE BOTTOM FOOTER (ROUNDED HOME STYLE WITH REELS) ════ -->
<nav class="shop-smart-bottom-footer" id="shopSmartBottomFooter" aria-label="Shop Mobile Controls">
    <div class="shop-smart-nav-wrapper">
        
        <!-- 1: FILTER -->
        <a href="javascript:void(0)" class="shop-smart-nav-item" id="filterBtn" data-tab="filter" onclick="if(typeof openMobileFilter==='function'){openMobileFilter();}else{var mf=document.getElementById('mfOverlay');if(mf)mf.classList.add('open');}" aria-label="Open Filters">
            <div class="shop-smart-nav-icon-box">
                <svg viewBox="0 0 24 24" class="shop-smart-nav-svg">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                </svg>
            </div>
            <span class="shop-smart-nav-label">Filter</span>
        </a>

        <!-- 2: SORT BY -->
        <a href="javascript:void(0)" class="shop-smart-nav-item" id="sortBtn" data-tab="sort" onclick="if(typeof openSort==='function'){openSort();}else{var ss=document.getElementById('sortSheet');if(ss)ss.classList.add('open');}" aria-label="Sort Products">
            <div class="shop-smart-nav-icon-box">
                <svg viewBox="0 0 24 24" class="shop-smart-nav-svg">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="15" y2="12"></line>
                    <line x1="3" y1="18" x2="9" y2="18"></line>
                </svg>
            </div>
            <span class="shop-smart-nav-label">Sort By</span>
        </a>

        <!-- 3: PERMANENT HERO REELS (Elevated Center Floating Bubble with Animated 🔥 HOT Badge) -->
        <a href="javascript:void(0)" class="shop-smart-nav-hero-reels" id="smartNavReels" data-tab="reels" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(0);" aria-label="Watch Video Reels">
            <div class="shop-smart-hero-bubble">
                <svg viewBox="0 0 24 24">
                    <rect x="2" y="3" width="20" height="18" rx="4"></rect>
                    <line x1="2" y1="8" x2="22" y2="8"></line>
                    <line x1="7" y1="3" x2="5" y2="8"></line>
                    <line x1="13" y1="3" x2="11" y2="8"></line>
                    <line x1="19" y1="3" x2="17" y2="8"></line>
                    <polygon points="10 12 15 15 10 18" fill="currentColor"></polygon>
                </svg>
                <!-- Animated Glowing 🔥 HOT Badge -->
                <span class="shop-smart-hero-hot-badge">🔥 HOT</span>
            </div>
            <span class="shop-smart-nav-hero-label">Reels</span>
        </a>

        <!-- 4: WISHLIST -->
        <a href="javascript:void(0)" class="shop-smart-nav-item" id="smartNavWishlist" data-tab="wishlist" onclick="if(typeof window.openWishlistDrawer==='function') window.openWishlistDrawer();" aria-label="Open Wishlist">
            <div class="shop-smart-nav-icon-box">
                <svg viewBox="0 0 24 24" class="shop-smart-nav-svg">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <span class="shop-smart-nav-badge" id="shopSmartWishlistBadge">0</span>
            </div>
            <span class="shop-smart-nav-label">Wishlist</span>
        </a>

        <!-- 5: MY ACCOUNT -->
        <a href="javascript:void(0)" class="shop-smart-nav-item" id="smartNavAccount" data-tab="account" onclick="if(typeof window.handleUserWiseAccountNavigation==='function'){window.handleUserWiseAccountNavigation();}else if(typeof window.openAccountModal==='function'){window.openAccountModal('login');}else{window.location.href='/account.php?tab=login';}" aria-label="My Account">
            <div class="shop-smart-nav-icon-box">
                <svg viewBox="0 0 24 24" class="shop-smart-nav-svg">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <span class="shop-smart-nav-label">Account</span>
        </a>

    </div>
</nav>

<!-- ════ MYNTRA MOBILE FILTER OVERLAY ════ -->
<div class="mf-overlay" id="mfOverlay" role="dialog" aria-modal="true" aria-label="Filter products" aria-hidden="true">

    <div class="mf-topbar">
        <div class="mf-title-wrap">
            <span class="mf-title">Filters</span>
            <span class="mf-title-badge" id="mfActiveBadge" style="display:none;">0</span>
        </div>
        <button class="mf-close-btn" id="mfCloseBtn" aria-label="Close filters">
            <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="mf-body">

        <nav class="mf-tabs" aria-label="Filter categories">
            <button class="mf-tab active" data-tab="category">Category <span class="mf-tab-dot"></span></button>
            <button class="mf-tab" data-tab="price">Price <span class="mf-tab-dot"></span></button>
            <button class="mf-tab" data-tab="colour">Colour <span class="mf-tab-dot"></span></button>
            <button class="mf-tab" data-tab="size">Size <span class="mf-tab-dot"></span></button>
            <button class="mf-tab" data-tab="fabric">Fabric <span class="mf-tab-dot"></span></button>
            <button class="mf-tab" data-tab="discount">Discount <span class="mf-tab-dot"></span></button>
            <button class="mf-tab" data-tab="availability">Availability <span class="mf-tab-dot"></span></button>
        </nav>

        <div class="mf-content">

            <!-- Category Panel -->
            <div class="mf-panel active" id="mf-panel-category">
                <p class="mf-panel-title">Select Category</p>
                <div class="mf-options">
                    <button class="mf-chip active" data-mf-type="category" data-mf-val="All" aria-pressed="true">All</button>
                    <button class="mf-chip" data-mf-type="category" data-mf-val="Sarees" aria-pressed="false">Sarees</button>
                    <button class="mf-chip" data-mf-type="category" data-mf-val="Kurtis" aria-pressed="false">Kurtis</button>
                    <button class="mf-chip" data-mf-type="category" data-mf-val="Gowns" aria-pressed="false">Gowns</button>
                    <button class="mf-chip" data-mf-type="category" data-mf-val="Lehengas" aria-pressed="false">Lehengas</button>
                </div>
            </div>

            <!-- Price Panel -->
            <div class="mf-panel" id="mf-panel-price">
                <p class="mf-panel-title">Price Range</p>
                <div class="price-display-card">
                    <div class="price-pill">
                        <span class="price-pill-lbl">MIN</span>
                        <span class="price-pill-val" id="mfPriceMinLbl">₹500</span>
                    </div>
                    <div class="price-pill-sep">—</div>
                    <div class="price-pill">
                        <span class="price-pill-lbl">MAX</span>
                        <span class="price-pill-val" id="mfPriceMaxLbl">₹30,000</span>
                    </div>
                </div>
                <div class="mf-range-track">
                    <div class="mf-range-fill" id="mfRangeFill"></div>
                    <input type="range" class="mf-range" id="mfPriceMin" min="500" max="30000" step="100" value="500" aria-label="Min price" />
                    <input type="range" class="mf-range" id="mfPriceMax" min="500" max="30000" step="100" value="30000" aria-label="Max price" />
                </div>
                <div class="price-presets" role="group" aria-label="Price range presets">
                    <button class="price-preset-chip" data-min="500" data-max="3000">Under ₹3k</button>
                    <button class="price-preset-chip" data-min="3000" data-max="8000">₹3k – ₹8k</button>
                    <button class="price-preset-chip" data-min="8000" data-max="15000">₹8k – ₹15k</button>
                    <button class="price-preset-chip" data-min="15000" data-max="30000">₹15k+</button>
                </div>
            </div>

            <!-- Colour Panel -->
            <div class="mf-panel" id="mf-panel-colour">
                <p class="mf-panel-title">Select Colour</p>
                <div class="mf-swatches">
                    <div class="mf-swatch-item" data-mf-type="color" data-mf-val="Navy">
                        <div class="mf-swatch-circle" style="background:#1a237e;"></div>
                        <span class="mf-swatch-label">Navy</span>
                    </div>
                    <div class="mf-swatch-item" data-mf-type="color" data-mf-val="Maroon">
                        <div class="mf-swatch-circle" style="background:#880e4f;"></div>
                        <span class="mf-swatch-label">Maroon</span>
                    </div>
                    <div class="mf-swatch-item" data-mf-type="color" data-mf-val="Green">
                        <div class="mf-swatch-circle" style="background:#1b5e20;"></div>
                        <span class="mf-swatch-label">Green</span>
                    </div>
                    <div class="mf-swatch-item" data-mf-type="color" data-mf-val="Pink">
                        <div class="mf-swatch-circle" style="background:#e91e63;"></div>
                        <span class="mf-swatch-label">Pink</span>
                    </div>
                    <div class="mf-swatch-item" data-mf-type="color" data-mf-val="Yellow">
                        <div class="mf-swatch-circle" style="background:#f9a825;"></div>
                        <span class="mf-swatch-label">Yellow</span>
                    </div>
                    <div class="mf-swatch-item" data-mf-type="color" data-mf-val="Red">
                        <div class="mf-swatch-circle" style="background:#b71c1c;"></div>
                        <span class="mf-swatch-label">Red</span>
                    </div>
                    <div class="mf-swatch-item" data-mf-type="color" data-mf-val="Orange">
                        <div class="mf-swatch-circle" style="background:#f57c00;"></div>
                        <span class="mf-swatch-label">Orange</span>
                    </div>
                    <div class="mf-swatch-item" data-mf-type="color" data-mf-val="White">
                        <div class="mf-swatch-circle" style="background:#ffffff;border:1px solid #ccc;"></div>
                        <span class="mf-swatch-label">White</span>
                    </div>
                </div>
            </div>

            <!-- Size Panel -->
            <div class="mf-panel" id="mf-panel-size">
                <p class="mf-panel-title">Select Size</p>
                <div class="mf-options">
                    <button class="mf-chip" data-mf-type="size" data-mf-val="XS" aria-pressed="false">XS</button>
                    <button class="mf-chip" data-mf-type="size" data-mf-val="S" aria-pressed="false">S</button>
                    <button class="mf-chip" data-mf-type="size" data-mf-val="M" aria-pressed="false">M</button>
                    <button class="mf-chip" data-mf-type="size" data-mf-val="L" aria-pressed="false">L</button>
                    <button class="mf-chip" data-mf-type="size" data-mf-val="XL" aria-pressed="false">XL</button>
                    <button class="mf-chip" data-mf-type="size" data-mf-val="XXL" aria-pressed="false">XXL</button>
                    <button class="mf-chip" data-mf-type="size" data-mf-val="Free Size" aria-pressed="false">Free Size</button>
                </div>
            </div>

            <!-- Fabric Panel -->
            <div class="mf-panel" id="mf-panel-fabric">
                <p class="mf-panel-title">Select Fabric</p>
                <div class="mf-options">
                    <button class="mf-chip" data-mf-type="fabric" data-mf-val="Pure Silk" aria-pressed="false">Pure Silk</button>
                    <button class="mf-chip" data-mf-type="fabric" data-mf-val="Georgette" aria-pressed="false">Georgette</button>
                    <button class="mf-chip" data-mf-type="fabric" data-mf-val="Cotton" aria-pressed="false">Cotton</button>
                    <button class="mf-chip" data-mf-type="fabric" data-mf-val="Chiffon" aria-pressed="false">Chiffon</button>
                    <button class="mf-chip" data-mf-type="fabric" data-mf-val="Organza" aria-pressed="false">Organza</button>
                </div>
            </div>

            <!-- Discount Panel -->
            <div class="mf-panel" id="mf-panel-discount">
                <p class="mf-panel-title">Select Discount</p>
                <div class="mf-options">
                    <button class="mf-chip" data-mf-type="discount" data-mf-val="10" aria-pressed="false">10% &amp; above</button>
                    <button class="mf-chip" data-mf-type="discount" data-mf-val="20" aria-pressed="false">20% &amp; above</button>
                    <button class="mf-chip" data-mf-type="discount" data-mf-val="25" aria-pressed="false">25% &amp; above</button>
                </div>
            </div>

            <!-- Availability Panel -->
            <div class="mf-panel" id="mf-panel-availability">
                <p class="mf-panel-title">Select Availability</p>
                <div class="mf-options">
                    <button class="mf-chip active" data-mf-type="availability" data-mf-val="In Stock" aria-pressed="true">In Stock</button>
                    <button class="mf-chip" data-mf-type="availability" data-mf-val="Pre-Order" aria-pressed="false">Pre-Order</button>
                </div>
            </div>

        </div><!-- /.mf-content -->
    </div><!-- /.mf-body -->

    <div class="mf-footer">
        <button class="mf-clear-btn" id="mfClearBtn">Clear All</button>
        <button class="mf-apply-btn" id="mfApplyBtn">Apply Filters</button>
    </div>

</div><!-- /.mf-overlay -->

<!-- ════ SORT BOTTOM SHEET ════ -->
<div class="sheet-overlay" id="sortOverlay" aria-hidden="true"></div>
<aside class="bottom-sheet" id="sortSheet" role="dialog" aria-modal="true" aria-label="Sort products" aria-hidden="true">
    <div class="sheet-handle" aria-hidden="true"></div>
    <div class="sheet-header">
        <span class="sheet-title">Sort By</span>
        <button class="sheet-close-btn" id="sortCloseBtn" aria-label="Close">
            <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
    <div class="sheet-body">
        <ul role="radiogroup" aria-label="Sort options">
            <li class="sort-option active" data-sort="recommended" role="radio" aria-checked="true" tabindex="0">
                <span class="sort-label">Recommended</span>
                <span class="sort-check"><span class="sort-check-dot"></span></span>
            </li>
            <li class="sort-option" data-sort="newest" role="radio" aria-checked="false" tabindex="0">
                <span class="sort-label">Newest First</span>
                <span class="sort-check"><span class="sort-check-dot"></span></span>
            </li>
            <li class="sort-option" data-sort="price_asc" role="radio" aria-checked="false" tabindex="0">
                <span class="sort-label">Price — Low to High</span>
                <span class="sort-check"><span class="sort-check-dot"></span></span>
            </li>
            <li class="sort-option" data-sort="price_desc" role="radio" aria-checked="false" tabindex="0">
                <span class="sort-label">Price — High to Low</span>
                <span class="sort-check"><span class="sort-check-dot"></span></span>
            </li>
            <li class="sort-option" data-sort="discount" role="radio" aria-checked="false" tabindex="0">
                <span class="sort-label">Best Discount</span>
                <span class="sort-check"><span class="sort-check-dot"></span></span>
            </li>
        </ul>
    </div>
</aside>

<!-- ════ MORE SHEET ════ -->
<div class="sheet-overlay" id="moreOverlay" aria-hidden="true"></div>
<aside class="bottom-sheet" id="addSheet" role="dialog" aria-modal="true" aria-label="More options" aria-hidden="true">
    <div class="sheet-handle" aria-hidden="true"></div>
    <div class="sheet-header">
        <span class="sheet-title">More Options</span>
        <button class="sheet-close-btn" id="addCloseBtn" aria-label="Close">
            <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
        <!-- Account Options -->
        <div style="font-size:0.68rem; font-weight:800; color:var(--dark-gold, #8A681F); text-transform:uppercase; letter-spacing:0.1em; padding:10px 0 4px; border-bottom:1.5px solid rgba(138,104,31,0.2);">
            Customer Account
        </div>
        
        <!-- 1. Logged In User Option: Only My Account & Log Out -->
        <div class="add-action-item" id="moreAccountAction" style="display:none;">
            <div class="add-action-icon"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></div>
            <div>
                <div class="add-action-label" id="moreAccountLabel">My Account & Orders</div>
                <div class="add-action-sub" id="moreAccountSub">View profile, addresses & recent orders</div>
            </div>
        </div>
        <div class="add-action-item" id="moreLogoutAction" style="display:none;">
            <div class="add-action-icon" style="background:#FFEBEE; color:#D32F2F;"><svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg></div>
            <div>
                <div class="add-action-label" style="color:#D32F2F;">Log Out</div>
                <div class="add-action-sub">Sign out of your account</div>
            </div>
        </div>

        <!-- 2. Logged Out (Guest) Option: Only Login & Register -->
        <div class="add-action-item" id="moreLoginAction">
            <div class="add-action-icon"><svg viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg></div>
            <div>
                <div class="add-action-label">Sign In / Login</div>
                <div class="add-action-sub">Access your saved bag & exclusive offers</div>
            </div>
        </div>
        <div class="add-action-item" id="moreRegisterAction">
            <div class="add-action-icon"><svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></div>
            <div>
                <div class="add-action-label">Create Account / Register</div>
                <div class="add-action-sub">Join DT Brand's & enjoy personalized shopping</div>
            </div>
        </div>

        <!-- Bag & Shopping Options -->
        <div style="font-size:0.68rem; font-weight:700; color:var(--dark-gold, #8A681F); text-transform:uppercase; letter-spacing:0.1em; padding:12px 0 4px; border-bottom:1.5px solid rgba(138,104,31,0.2);">
            Navigation & Shopping
        </div>
        <div class="add-action-item" id="moreHomeAction" onclick="window.location.href='/';">
            <div class="add-action-icon"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></div>
            <div><div class="add-action-label" style="color:var(--dark-gold, #8A681F); font-weight:800;">Home Page</div><div class="add-action-sub">Main shopping hub, offers & wholesale</div></div>
        </div>
        <div class="add-action-item" id="moreShopAction" onclick="window.location.href='/shop.php';">
            <div class="add-action-icon"><svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></div>
            <div><div class="add-action-label">Shop All Catalog</div><div class="add-action-sub">Browse full catalogue with filters</div></div>
        </div>
        <div class="add-action-item" id="moreCartAction">
            <div class="add-action-icon"><svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg></div>
            <div><div class="add-action-label" id="moreCartLabel">My Cart (0 Items)</div><div class="add-action-sub">View shopping bag & checkout</div></div>
        </div>
        <div class="add-action-item" id="moreWishlistAction">
            <div class="add-action-icon"><svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></div>
            <div><div class="add-action-label" id="moreWishlistLabel">My Wishlist (0 Items)</div><div class="add-action-sub">View saved favorite items</div></div>
        </div>
        <div class="add-action-item" id="moreShareAction">
            <div class="add-action-icon"><svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg></div>
            <div><div class="add-action-label">Share Collection</div><div class="add-action-sub">Share this page link</div></div>
        </div>
        <div class="add-action-item" id="moreAdviceAction">
            <div class="add-action-icon"><svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg></div>
            <div><div class="add-action-label">Styling Advice</div><div class="add-action-sub">Chat with our stylists on WhatsApp</div></div>
        </div>
</aside>

<!-- ════ MOBILE FILTER CONTROLLER ════ -->
<script>
(function () {
    'use strict';

    var mfOverlay  = document.getElementById('mfOverlay');
    var filterBtn  = document.getElementById('filterBtn');
    var mfCloseBtn = document.getElementById('mfCloseBtn');
    var mfApplyBtn = document.getElementById('mfApplyBtn');
    var mfClearBtn = document.getElementById('mfClearBtn');

    window.openMobileFilter = function() {
        if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
        mfOverlay.classList.add('open');
        mfOverlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        document.body.classList.add('mf-open');
        if (filterBtn) filterBtn.setAttribute('aria-expanded', 'true');
        var bFoot = document.getElementById('shopSmartBottomFooter');
        if (bFoot) bFoot.classList.add('is-hidden');
    };
    window.closeMobileFilter = function() {
        mfOverlay.classList.remove('open');
        mfOverlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        document.body.classList.remove('mf-open');
        if (filterBtn) filterBtn.setAttribute('aria-expanded', 'false');
        var bFoot = document.getElementById('shopSmartBottomFooter');
        if (bFoot) bFoot.classList.remove('is-hidden');
    };

    if (filterBtn) filterBtn.addEventListener('click', window.openMobileFilter);
    if (mfCloseBtn) mfCloseBtn.addEventListener('click', window.closeMobileFilter);

    if (mfApplyBtn) {
        mfApplyBtn.addEventListener('click', function () {
            closeMobileFilter();
            if (typeof showToast === 'function') showToast('Filters applied');
        });
    }

    if (mfClearBtn) {
        mfClearBtn.addEventListener('click', function () {
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
            if (typeof window.applyMasterFilters === 'function') window.applyMasterFilters();
            window.syncMobileFilterUI();
        });
    }

    /* Tab switching */
    var mfTabs = document.querySelectorAll('.mf-tab');
    var mfPanels = document.querySelectorAll('.mf-panel');
    mfTabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            mfTabs.forEach(function(t){ t.classList.remove('active'); });
            mfPanels.forEach(function(p){ p.classList.remove('active'); });
            tab.classList.add('active');
            var panel = document.getElementById('mf-panel-' + tab.dataset.tab);
            if (panel) panel.classList.add('active');
        });
    });

    /* Chip Selection */
    document.querySelectorAll('.mf-chip').forEach(function(chip) {
        chip.addEventListener('click', function() {
            var type = chip.dataset.mfType;
            var val  = chip.dataset.mfVal;
            var st   = window.masterFilterState;

            if (!st) return;

            if (type === 'category') {
                st.category = val;
                var catItems = document.querySelectorAll('.cat-item');
                catItems.forEach(function(ci){ ci.classList.toggle('active', ci.dataset.category === val); });
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

            if (typeof window.applyMasterFilters === 'function') window.applyMasterFilters();
            window.syncMobileFilterUI();
        });
    });

    /* Swatch Selection */
    document.querySelectorAll('.mf-swatch-item').forEach(function(item) {
        item.addEventListener('click', function() {
            var val = item.dataset.mfVal;
            var st  = window.masterFilterState;
            if (!st) return;

            var idx = st.colors.indexOf(val);
            if (idx === -1) st.colors.push(val); else st.colors.splice(idx, 1);

            if (typeof window.applyMasterFilters === 'function') window.applyMasterFilters();
            window.syncMobileFilterUI();
        });
    });

    /* Price Sliders */
    var mfRangeMin = document.getElementById('mfPriceMin');
    var mfRangeMax = document.getElementById('mfPriceMax');
    var mfMinLbl   = document.getElementById('mfPriceMinLbl');
    var mfMaxLbl   = document.getElementById('mfPriceMaxLbl');
    var mfFill     = document.getElementById('mfRangeFill');

    function updateMfRange() {
        if (!mfRangeMin || !mfRangeMax) return;
        var mn = parseInt(mfRangeMin.value), mx = parseInt(mfRangeMax.value);
        var lo = parseInt(mfRangeMin.min),   hi = parseInt(mfRangeMin.max);

        if (mn > mx - 500) {
            if (this === mfRangeMin) mn = mx - 500; else mx = mn + 500;
            mfRangeMin.value = mn; mfRangeMax.value = mx;
        }

        mfFill.style.left  = ((mn - lo) / (hi - lo) * 100) + '%';
        mfFill.style.right = (100 - (mx - lo) / (hi - lo) * 100) + '%';
        mfMinLbl.textContent = '₹' + mn.toLocaleString('en-IN');
        mfMaxLbl.textContent = '₹' + mx.toLocaleString('en-IN');

        if (window.masterFilterState) {
            window.masterFilterState.minPrice = mn;
            window.masterFilterState.maxPrice = mx;
            if (typeof window.applyMasterFilters === 'function') window.applyMasterFilters();
        }
    }

    if (mfRangeMin) {
        mfRangeMin.addEventListener('input', updateMfRange);
        mfRangeMax.addEventListener('input', updateMfRange);
    }

    /* Synchronize Mobile UI with Master State */
    window.syncMobileFilterUI = function() {
        var st = window.masterFilterState;
        if (!st) return;

        // Total active count badge
        var totalActive = (st.category !== 'All' ? 1 : 0) + st.colors.length + st.sizes.length + st.fabrics.length + (st.minDiscount > 0 ? 1 : 0) + st.availability.length + ((st.minPrice > 500 || st.maxPrice < 30000) ? 1 : 0);
        
        var mfBadge = document.getElementById('mfActiveBadge');
        if (mfBadge) {
            mfBadge.style.display = totalActive > 0 ? 'inline-flex' : 'none';
            mfBadge.textContent = totalActive;
        }

        var filterBtn = document.getElementById('filterBtn');
        if (filterBtn) filterBtn.classList.toggle('has-active', totalActive > 0);

        // Mobile Chips state
        document.querySelectorAll('.mf-chip').forEach(function(chip) {
            var type = chip.dataset.mfType;
            var val  = chip.dataset.mfVal;
            var isActive = false;
            if (type === 'category') isActive = (st.category === val);
            if (type === 'size') isActive = st.sizes.indexOf(val) !== -1;
            if (type === 'fabric') isActive = st.fabrics.indexOf(val) !== -1;
            if (type === 'discount') isActive = (st.minDiscount === parseInt(val));
            if (type === 'availability') isActive = st.availability.indexOf(val) !== -1;
            chip.classList.toggle('active', isActive);
            chip.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        });

        // Mobile Swatches state
        document.querySelectorAll('.mf-swatch-item').forEach(function(sw) {
            var val = sw.dataset.mfVal;
            var isActive = st.colors.indexOf(val) !== -1;
            sw.classList.toggle('active', isActive);
        });

        // Sync Sliders
        if (mfRangeMin && mfRangeMax) {
            mfRangeMin.value = st.minPrice;
            mfRangeMax.value = st.maxPrice;
            var lo = parseInt(mfRangeMin.min), hi = parseInt(mfRangeMin.max);
            mfFill.style.left  = ((st.minPrice - lo) / (hi - lo) * 100) + '%';
            mfFill.style.right = (100 - (st.maxPrice - lo) / (hi - lo) * 100) + '%';
            mfMinLbl.textContent = '₹' + st.minPrice.toLocaleString('en-IN');
            mfMaxLbl.textContent = '₹' + st.maxPrice.toLocaleString('en-IN');
        }

        // Tab selection dots
        updateTabDot('category', st.category !== 'All');
        updateTabDot('price', st.minPrice > 500 || st.maxPrice < 30000);
        updateTabDot('colour', st.colors.length > 0);
        updateTabDot('size', st.sizes.length > 0);
        updateTabDot('fabric', st.fabrics.length > 0);
        updateTabDot('discount', st.minDiscount > 0);
        updateTabDot('availability', st.availability.length > 0);
    };

    function updateTabDot(tabName, hasSel) {
        var tab = document.querySelector('.mf-tab[data-tab="'+tabName+'"]');
        if (tab) tab.classList.toggle('has-selection', hasSel);
    }

    /* ─── Sort Sheet ─────────────────────── */
    var sortOverlay  = document.getElementById('sortOverlay');
    var sortSheet    = document.getElementById('sortSheet');
    var sortBtn      = document.getElementById('sortBtn');
    var sortCloseBtn = document.getElementById('sortCloseBtn');

    window.openSort = function() {
        if (!sortSheet || !sortOverlay) return;
        sortSheet.classList.add('open');
        sortOverlay.classList.add('open');
        sortOverlay.setAttribute('aria-hidden','false');
        sortSheet.setAttribute('aria-hidden','false');
        if (sortBtn) sortBtn.setAttribute('aria-expanded','true');
        document.body.style.overflow='hidden';
        document.body.classList.add('sort-open');
        var bFoot = document.getElementById('shopSmartBottomFooter');
        if (bFoot) bFoot.classList.add('is-hidden');
    };
    window.closeSort = function() {
        if (!sortSheet || !sortOverlay) return;
        sortSheet.classList.remove('open');
        sortOverlay.classList.remove('open');
        sortOverlay.setAttribute('aria-hidden','true');
        sortSheet.setAttribute('aria-hidden','true');
        if (sortBtn) sortBtn.setAttribute('aria-expanded','false');
        document.body.style.overflow='';
        document.body.classList.remove('sort-open');
        var bFoot = document.getElementById('shopSmartBottomFooter');
        if (bFoot) bFoot.classList.remove('is-hidden');
    };

    if (sortBtn) sortBtn.addEventListener('click', window.openSort);
    if (sortCloseBtn) sortCloseBtn.addEventListener('click', window.closeSort);
    if (sortOverlay) sortOverlay.addEventListener('click', window.closeSort);

    var sortOptions = document.querySelectorAll('.sort-option');
    sortOptions.forEach(function(opt) {
        function pick() {
            sortOptions.forEach(function(o){ o.classList.remove('active'); o.setAttribute('aria-checked','false'); });
            opt.classList.add('active'); opt.setAttribute('aria-checked','true');
            if (window.masterFilterState) {
                window.masterFilterState.sortBy = opt.dataset.sort;
                var ptbSort = document.getElementById('ptbSortSelect');
                if (ptbSort) ptbSort.value = opt.dataset.sort;
                if (typeof window.applyMasterFilters === 'function') window.applyMasterFilters();
            }
            setTimeout(window.closeSort, 240);
        }
        opt.addEventListener('click', pick);
        opt.addEventListener('keydown', function(e){ if(e.key==='Enter'||e.key===' '){ e.preventDefault(); pick(); }});
    });

    /* ─── More Sheet ─────────────────────── */
    var moreOverlay  = document.getElementById('moreOverlay');
    var addSheet     = document.getElementById('addSheet');
    var addBtn       = document.getElementById('addBtn');
    var addCloseBtn  = document.getElementById('addCloseBtn');

    window.openMore = function() {
        if (!addSheet || !moreOverlay) return;
        if (typeof syncMobileMoreAccountState === 'function') syncMobileMoreAccountState();
        addSheet.classList.add('open');
        moreOverlay.classList.add('open');
        moreOverlay.setAttribute('aria-hidden','false');
        addSheet.setAttribute('aria-hidden','false');
        if (addBtn) addBtn.setAttribute('aria-expanded','true');
        document.body.style.overflow='hidden';
        document.body.classList.add('more-open');
        var bFoot = document.getElementById('shopSmartBottomFooter');
        if (bFoot) bFoot.classList.add('is-hidden');
    };
    window.closeMore = function() {
        if (!addSheet || !moreOverlay) return;
        addSheet.classList.remove('open');
        moreOverlay.classList.remove('open');
        moreOverlay.setAttribute('aria-hidden','true');
        addSheet.setAttribute('aria-hidden','true');
        if (addBtn) addBtn.setAttribute('aria-expanded','false');
        document.body.style.overflow='';
        document.body.classList.remove('more-open');
        var bFoot = document.getElementById('shopSmartBottomFooter');
        if (bFoot) bFoot.classList.remove('is-hidden');
    };

    if (addBtn) addBtn.addEventListener('click', window.openMore);
    if (addCloseBtn) addCloseBtn.addEventListener('click', window.closeMore);
    if (moreOverlay) moreOverlay.addEventListener('click', window.closeMore);

    var accountItem  = document.getElementById('moreAccountAction');
    var logoutItem   = document.getElementById('moreLogoutAction');
    var loginItem    = document.getElementById('moreLoginAction');
    var registerItem = document.getElementById('moreRegisterAction');
    var cartItem     = document.getElementById('moreCartAction');
    var wishItem     = document.getElementById('moreWishlistAction');
    var shareItem    = document.getElementById('moreShareAction');
    var adviceItem   = document.getElementById('moreAdviceAction');

    function syncMobileMoreAccountState() {
        var userRaw = localStorage.getItem('dtbrands_user');
        var accountLabel = document.getElementById('moreAccountLabel');
        var accountSub = document.getElementById('moreAccountSub');

        if (userRaw) {
            var user = JSON.parse(userRaw);
            if (accountLabel) accountLabel.textContent = `${user.name || 'My Account'}`;
            if (accountSub) accountSub.textContent = `Role: ${user.role || 'Retailer'} • View Profile & Orders`;

            if (accountItem) accountItem.style.display = 'flex';
            if (logoutItem) logoutItem.style.display = 'flex';
            if (loginItem) loginItem.style.display = 'none';
            if (registerItem) registerItem.style.display = 'none';
        } else {
            if (accountItem) accountItem.style.display = 'none';
            if (logoutItem) logoutItem.style.display = 'none';
            if (loginItem) loginItem.style.display = 'flex';
            if (registerItem) registerItem.style.display = 'flex';
        }
    }

    function openMore() { 
        syncMobileMoreAccountState();
        addSheet.classList.add('open'); 
        moreOverlay.classList.add('open'); 
        moreOverlay.setAttribute('aria-hidden','false'); 
        addSheet.setAttribute('aria-hidden','false'); 
        addBtn.setAttribute('aria-expanded','true'); 
        document.body.style.overflow='hidden'; 
    }

    if (accountItem) accountItem.addEventListener('click', function(){ closeMore(); if (typeof window.handleUserWiseAccountNavigation==='function'){window.handleUserWiseAccountNavigation();}else if(typeof window.openAccountModal==='function'){window.openAccountModal('profile');}else{window.location.href='/account.php';} });
    if (logoutItem) logoutItem.addEventListener('click', function(){ 
        closeMore(); 
        localStorage.removeItem('dtbrands_user');
        if (typeof window.showToast==='function') window.showToast('You have been logged out.');
        syncMobileMoreAccountState();
        if (typeof window.syncHeaderAccountState === 'function') window.syncHeaderAccountState();
    });
    if (loginItem) loginItem.addEventListener('click', function(){ closeMore(); if (typeof window.openAccountModal==='function'){window.openAccountModal('login');}else{window.location.href='/account.php?tab=login';} });
    if (registerItem) registerItem.addEventListener('click', function(){ closeMore(); if (typeof window.openAccountModal==='function'){window.openAccountModal('register');}else{window.location.href='/account.php?tab=register';} });

    if (cartItem) cartItem.addEventListener('click', function(){ closeMore(); if (typeof window.openCartDrawer==='function') window.openCartDrawer(); });
    if (wishItem) wishItem.addEventListener('click', function(){ closeMore(); if (typeof window.openWishlistDrawer==='function') window.openWishlistDrawer(); });
    if (shareItem) shareItem.addEventListener('click', function(){ closeMore(); if (typeof window.showToast==='function') window.showToast('🔗 Page link copied to clipboard'); });
    if (adviceItem) adviceItem.addEventListener('click', function(){ closeMore(); window.open('https://api.whatsapp.com/send?phone=917046363528&text=Hi%2C%20I%20would%20like%20styling%20advice%20for%20ethnic%20wear', '_blank'); });

    function syncShopBottomFooterBadges() {
        try {
            var wish = JSON.parse(localStorage.getItem('dtbrands_wishlist') || '[]');
            var wBadge = document.getElementById('shopSmartWishlistBadge');
            if (wBadge) {
                var count = Array.isArray(wish) ? wish.length : 0;
                wBadge.textContent = count;
                wBadge.style.display = count > 0 ? 'flex' : 'none';
            }
        } catch(e) {}
    }

    syncShopBottomFooterBadges();
    window.addEventListener('storage', syncShopBottomFooterBadges);
    document.addEventListener('DOMContentLoaded', syncShopBottomFooterBadges);

    syncMobileMoreAccountState();
    window.addEventListener('storage', syncMobileMoreAccountState);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') { closeSort(); closeMore(); closeMobileFilter(); }
    });

})();
</script>
