<?php
/**
 * homebottomfooter.php — SMART MOBILE BOTTOM FOOTER & RESELLER-STYLE MEGA MENU DRAWER
 * Luxury DT Brand Center Elevated Floating Reels Action Button with Animated HOT Badge
 * Luxury Reseller-style slide-in mobile navigation drawer & real vector menu SVG
 */
?>
<!-- ══════════════════════════════════════════════════════════════════
     SMART MOBILE BOTTOM FOOTER & RESELLER-STYLE MEGA MENU DRAWER
══════════════════════════════════════════════════════════════════ -->
<style>
/* ── Container & Floating Bottom Bar ── */
.home-smart-bottom-footer {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 99998 !important;
    padding: 0 12px;
    padding-bottom: max(8px, env(safe-area-inset-bottom, 8px));
    pointer-events: auto !important;
    transition: transform 0.32s cubic-bezier(0.34, 1.25, 0.64, 1), opacity 0.28s ease, visibility 0.28s ease;
    transform: translateY(0);
    opacity: 1;
    visibility: visible;
}

.home-smart-bottom-footer.is-hidden {
    transform: translateY(140%) !important;
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
}

/* Auto-hide via body classes when any overlay, drawer, sheet, or modal is active */
body.reels-open .home-smart-bottom-footer,
body.reels-modal-open .home-smart-bottom-footer,
body.modal-open .home-smart-bottom-footer,
body.cart-open .home-smart-bottom-footer,
body.wishlist-open .home-smart-bottom-footer,
body.drawer-open .home-smart-bottom-footer,
body.menu-open .home-smart-bottom-footer,
body.mf-open .home-smart-bottom-footer,
body.sort-open .home-smart-bottom-footer {
    transform: translateY(140%) !important;
    opacity: 0 !important;
    visibility: hidden !important;
    pointer-events: none !important;
}

@media (max-width: 1024px) {
    .home-smart-bottom-footer {
        display: block !important;
    }
    body {
        padding-bottom: 0 !important;
    }
}
@media (min-width: 1025px) {
    .home-smart-bottom-footer {
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

.smart-nav-wrapper {
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

/* ── Standard Nav Item Links ── */
.smart-nav-item {
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
}

.smart-nav-icon-box {
    position: relative;
    width: 32px;
    height: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 3px;
    transition: transform 0.25s ease, color 0.25s ease;
}

.smart-nav-svg {
    width: 22px;
    height: 22px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    transition: all 0.25s ease;
}

.smart-nav-label {
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    margin: 0;
    line-height: 1;
    transition: color 0.25s ease, font-weight 0.25s ease;
    opacity: 0.9;
    white-space: nowrap;
}

/* Hover & Active States for Standard Items (Color Transition Only) */
.smart-nav-item:hover,
.smart-nav-item:active,
.smart-nav-item.active {
    color: #F5D77F;
}

.smart-nav-item:hover .smart-nav-svg,
.smart-nav-item:active .smart-nav-svg,
.smart-nav-item.active .smart-nav-svg {
    stroke: #F5D77F;
    transform: translateY(-2px) scale(1.08);
}

.smart-nav-item.active .smart-nav-label {
    color: #F5D77F;
    font-weight: 800;
    opacity: 1;
}

/* Subtle Active Glowing Underline Dot */
.smart-nav-item.active::after {
    content: '';
    position: absolute;
    bottom: 3px;
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: #F5D77F;
    box-shadow: 0 0 6px #F5D77F;
}

/* ── PERMANENT HERO REELS BUTTON (Elevated Center Floating Bubble) ── */
.smart-nav-hero-reels {
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

.smart-hero-bubble {
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

.smart-hero-bubble svg {
    width: 24px;
    height: 24px;
    stroke: #FFFFFF;
    stroke-width: 2.2;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.35));
    animation: reelsPulse 2.4s infinite ease-in-out;
}

.smart-nav-hero-reels:hover .smart-hero-bubble,
.smart-nav-hero-reels:active .smart-hero-bubble {
    transform: translateY(-4px) scale(1.08);
    box-shadow: 0 12px 28px rgba(212, 175, 55, 0.7), 0 4px 12px rgba(0, 0, 0, 0.5);
}

@keyframes reelsPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.08); }
}

/* ── STYLED ANIMATED 🔥 HOT BADGE ── */
.smart-hero-hot-badge {
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
    animation: hotBadgePulse 1.8s infinite ease-in-out;
    text-transform: uppercase;
}

@keyframes hotBadgePulse {
    0%, 100% { transform: scale(1); box-shadow: 0 2px 8px rgba(239, 68, 68, 0.6); }
    50% { transform: scale(1.14); box-shadow: 0 4px 14px rgba(239, 68, 68, 0.85); }
}

.smart-nav-hero-label {
    font-size: 0.58rem;
    font-weight: 800;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    margin: 0;
    line-height: 1;
    color: #F5D77F;
    white-space: nowrap;
}

/* ── Live Wishlist Counter Badge ── */
.smart-nav-badge {
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
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 3px;
    border: 1.5px solid #181512;
    box-shadow: 0 2px 6px rgba(220, 38, 38, 0.4);
    z-index: 6;
}

/* ══════════════════════════════════════════════════════════════════
   RESELLER-STYLE LUXURY MOBILE MEGA MENU DRAWER
══════════════════════════════════════════════════════════════════ */
.home-menu-drawer-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(15, 12, 10, 0.75);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    z-index: 99999;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.home-menu-drawer-backdrop.active {
    opacity: 1;
    visibility: visible;
}

.home-menu-drawer {
    position: fixed;
    top: 0;
    left: 0;
    bottom: 0;
    width: min(85vw, 340px);
    background: #181512;
    background: linear-gradient(180deg, #1F1B16 0%, #14110E 100%);
    border-right: 1.5px solid rgba(212, 175, 55, 0.35);
    box-shadow: 10px 0 40px rgba(0, 0, 0, 0.6);
    z-index: 100000;
    transform: translateX(-100%);
    transition: transform 0.35s cubic-bezier(0.34, 1.25, 0.64, 1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.home-menu-drawer-backdrop.active .home-menu-drawer {
    transform: translateX(0);
}

/* Drawer Header with Logo & Close */
.home-menu-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 18px 14px;
    border-bottom: 1px solid rgba(212, 175, 55, 0.2);
    background: rgba(0, 0, 0, 0.25);
}

.home-menu-logo {
    height: 32px;
    width: auto;
    object-fit: contain;
}

.home-menu-close-btn {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(212, 175, 55, 0.3);
    color: #F5D77F;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.home-menu-close-btn:hover {
    background: rgba(212, 175, 55, 0.2);
    transform: rotate(90deg);
}

/* Scroll Content */
.home-menu-scroll {
    flex: 1;
    overflow-y: auto;
    padding: 12px 14px 24px;
    -webkit-overflow-scrolling: touch;
}

/* Reseller-Style VIP User Card */
.home-menu-user-card {
    background: linear-gradient(135deg, rgba(212, 175, 55, 0.15) 0%, rgba(30, 27, 24, 0.8) 100%);
    border: 1.2px solid rgba(212, 175, 55, 0.4);
    border-radius: 12px;
    padding: 10px 12px;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    transition: transform 0.2s ease;
}

.home-menu-user-card:hover {
    transform: translateY(-1px);
    border-color: #F5D77F;
}

.home-menu-user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 1.5px solid #D4AF37;
    object-fit: cover;
    background: #2A241E;
}

.home-menu-user-info {
    flex: 1;
    min-width: 0;
}

.home-menu-user-name {
    font-size: 0.82rem;
    font-weight: 800;
    color: #FFFFFF;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.home-menu-user-tier {
    font-size: 0.62rem;
    font-weight: 700;
    color: #F5D77F;
    display: flex;
    align-items: center;
    gap: 3px;
    margin-top: 1px;
}

.home-menu-tier-badge {
    font-size: 0.58rem;
    font-weight: 900;
    background: linear-gradient(135deg, #D4AF37 0%, #8A681F 100%);
    color: #1E1B18;
    padding: 2px 6px;
    border-radius: 6px;
    letter-spacing: 0.04em;
    flex-shrink: 0;
}

/* Category Sections (Reseller TailAdmin Style) */
.home-menu-cat-title {
    font-size: 0.60rem;
    font-weight: 900;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #8A681F;
    margin: 14px 4px 6px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.home-menu-list {
    list-style: none;
    padding: 0;
    margin: 0 0 10px;
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.home-menu-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 9px 12px;
    border-radius: 10px;
    text-decoration: none;
    color: #D6CFC7;
    font-size: 0.78rem;
    font-weight: 700;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.home-menu-link:hover,
.home-menu-link.active {
    background: rgba(212, 175, 55, 0.12);
    border-color: rgba(212, 175, 55, 0.3);
    color: #F5D77F;
    transform: translateX(3px);
}

.home-menu-link svg {
    width: 17px;
    height: 17px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    flex-shrink: 0;
    transition: stroke 0.2s ease;
}

.home-menu-link-badge {
    margin-left: auto;
    font-size: 0.56rem;
    font-weight: 900;
    padding: 2px 6px;
    border-radius: 6px;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

.home-menu-link-badge.gold {
    background: linear-gradient(135deg, #F5D77F 0%, #D4AF37 100%);
    color: #1E1B18;
}

.home-menu-link-badge.hot {
    background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
    color: #FFFFFF;
}

.home-menu-link-badge.green {
    background: #10B981;
    color: #FFFFFF;
}

/* Footer Action */
.home-menu-footer {
    padding: 12px 14px;
    border-top: 1px solid rgba(212, 175, 55, 0.2);
    background: rgba(0, 0, 0, 0.25);
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.home-menu-wa-btn {
    width: 100%;
    height: 38px;
    background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
    color: #FFFFFF;
    border-radius: 10px;
    font-size: 0.74rem;
    font-weight: 800;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: none;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
    transition: all 0.2s ease;
}

.home-menu-wa-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 211, 102, 0.45);
}
</style>

<!-- ════════════ RESELLER-STYLE HOME MEGA MENU DRAWER OVERLAY ════════════ -->
<div class="home-menu-drawer-backdrop" id="homeMenuDrawerBackdrop" onclick="toggleHomeMobileMenu(false)">
    <aside class="home-menu-drawer" id="homeMenuDrawer" onclick="event.stopPropagation()">
        <!-- Header with Brand Logo & Close Button -->
        <div class="home-menu-header">
            <a href="/" style="display:flex; align-items:center;">
                <img src="/assets/images/logo.png" onerror="this.onerror=null; this.src='/Shared/Asset/images/logo.png';" alt="DT Brand's" class="home-menu-logo">
            </a>
            <button class="home-menu-close-btn" onclick="toggleHomeMobileMenu(false)" aria-label="Close Menu">✕</button>
        </div>

        <!-- Scrollable Navigation Area -->
        <div class="home-menu-scroll">
            <!-- VIP User Card (Reseller Desktop Menu Inspired) -->
            <div class="home-menu-user-card" onclick="toggleHomeMobileMenu(false); if(typeof window.handleUserWiseAccountNavigation==='function'){window.handleUserWiseAccountNavigation();}else if(typeof window.openAccountModal==='function'){window.openAccountModal('login');}else{window.location.href='/Shared/Auth/myaccount.php?tab=login';}">
                <img src="/assets/images/product1.png" onerror="this.src='/assets/images/product2.png';" alt="Member" class="home-menu-user-avatar">
                <div class="home-menu-user-info">
                    <div class="home-menu-user-name" id="homeMenuUserName">VIP Member / Reseller</div>
                    <div class="home-menu-user-tier">
                        <span>★ Verified Club</span>
                    </div>
                </div>
                <span class="home-menu-tier-badge">GOLD</span>
            </div>

            <!-- SECTION 1: STOREFRONT CATALOG -->
            <div class="home-menu-cat-title">
                <span>STOREFRONT MENU</span>
                <span style="font-size:0.50rem; color:#A89F91;">EXPLORE</span>
            </div>
            <ul class="home-menu-list">
                <li>
                    <a href="/" class="home-menu-link active">
                        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span>Home Storefront</span>
                    </a>
                </li>
                <li>
                    <a href="/shop" class="home-menu-link">
                        <svg viewBox="0 0 24 24"><path d="M3 9l1-5h16l1 5"></path><path d="M3 9a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0"></path><path d="M4 14v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-6"></path><path d="M10 22v-6h4v6"></path></svg>
                        <span>All Products Shop</span>
                        <span class="home-menu-link-badge gold">ALL</span>
                    </a>
                </li>
                <li>
                    <a href="/shop.php?cat=Sarees" class="home-menu-link">
                        <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <span>Silk Sarees</span>
                        <span class="home-menu-link-badge hot">450+</span>
                    </a>
                </li>
                <li>
                    <a href="/shop.php?cat=Kurtis" class="home-menu-link">
                        <svg viewBox="0 0 24 24"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"></path></svg>
                        <span>Designer Kurtis</span>
                    </a>
                </li>
                <li>
                    <a href="/shop.php?cat=Lehengas" class="home-menu-link">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polygon points="12 6 12 12 16 14"></polygon></svg>
                        <span>Bridal Lehengas & Gowns</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="toggleHomeMobileMenu(false); if(typeof window.openReelsModal==='function') window.openReelsModal(0);" class="home-menu-link">
                        <svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="18" rx="4"></rect><line x1="2" y1="8" x2="22" y2="8"></line><polygon points="10 12 15 15 10 18" fill="currentColor"></polygon></svg>
                        <span>Video Reels Stream</span>
                        <span class="home-menu-link-badge hot">🔥 HOT</span>
                    </a>
                </li>
            </ul>

            <!-- SECTION 2: B2B & RESELLER HUB -->
            <div class="home-menu-cat-title">
                <span>B2B & RESELLER HUB</span>
                <span style="font-size:0.50rem; color:#D4AF37;">EARN ₹₹₹</span>
            </div>
            <ul class="home-menu-list">
                <li>
                    <a href="/reseller" class="home-menu-link">
                        <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <span>Reseller Partner Portal</span>
                        <span class="home-menu-link-badge gold">VIP</span>
                    </a>
                </li>
                <li>
                    <a href="/wholesale" class="home-menu-link">
                        <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                        <span>Wholesale Bulk Factory</span>
                        <span class="home-menu-link-badge green">SLABS</span>
                    </a>
                </li>
            </ul>

            <!-- SECTION 3: ACCOUNT & ASSISTANCE -->
            <div class="home-menu-cat-title">
                <span>ACCOUNT & ASSISTANCE</span>
            </div>
            <ul class="home-menu-list">
                <li>
                    <a href="javascript:void(0)" onclick="toggleHomeMobileMenu(false); if(typeof window.openWishlistDrawer==='function') window.openWishlistDrawer();" class="home-menu-link">
                        <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                        <span>My Wishlist</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)" onclick="toggleHomeMobileMenu(false); if(typeof window.handleUserWiseAccountNavigation==='function'){window.handleUserWiseAccountNavigation();}else if(typeof window.openAccountModal==='function'){window.openAccountModal('login');}else{window.location.href='/Shared/Auth/myaccount.php?tab=login';}" class="home-menu-link">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>My Account & Orders</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Footer Action (WhatsApp Concierge) -->
        <div class="home-menu-footer">
            <a href="https://api.whatsapp.com/send?phone=917046363528&text=Hi%2C%20I%20need%20assistance%20with%20DT%20Brand%20catalog." target="_blank" class="home-menu-wa-btn">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="#FFFFFF"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
                <span>WhatsApp Stylist Concierge</span>
            </a>
        </div>
    </aside>
</div>

<!-- ════════════ BOTTOM FIXED FLOATING BAR ════════════ -->
<nav class="home-smart-bottom-footer" id="homeSmartBottomFooter" aria-label="Mobile Bottom Navigation">
    <div class="smart-nav-wrapper" id="smartNavWrapper">

        <!-- 1: MENU / DRAWER (Real Vector Menu SVG with 3-Line Tier Icon) -->
        <a href="javascript:void(0)" class="smart-nav-item" id="smartNavMenu" data-tab="menu" onclick="handleSmartFooterAction(event, '', 'menu')" aria-label="Open Mobile Menu Drawer">
            <div class="smart-nav-icon-box">
                <svg viewBox="0 0 24 24" class="smart-nav-svg">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="16" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </div>
            <span class="smart-nav-label">Menu</span>
        </a>

        <!-- 2: SHOP / BOUTIQUE STORE (Real Storefront Canopy SVG) -->
        <a href="/shop" class="smart-nav-item" id="smartNavShop" data-tab="shop" onclick="handleSmartFooterAction(event, '/shop.php', 'shop')">
            <div class="smart-nav-icon-box">
                <svg viewBox="0 0 24 24" class="smart-nav-svg">
                    <path d="M3 9l1-5h16l1 5"></path>
                    <path d="M3 9a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0"></path>
                    <path d="M4 14v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-6"></path>
                    <path d="M10 22v-6h4v6"></path>
                </svg>
            </div>
            <span class="smart-nav-label">Shop</span>
        </a>

        <!-- 3: PERMANENT HERO REELS (Elevated Center Floating Bubble with 🔥 HOT Badge) -->
        <a href="javascript:void(0)" class="smart-nav-hero-reels" id="smartNavReels" data-tab="reels" onclick="handleSmartFooterAction(event, '', 'reels')" aria-label="Watch Video Reels">
            <div class="smart-hero-bubble">
                <svg viewBox="0 0 24 24">
                    <rect x="2" y="3" width="20" height="18" rx="4"></rect>
                    <line x1="2" y1="8" x2="22" y2="8"></line>
                    <line x1="7" y1="3" x2="5" y2="8"></line>
                    <line x1="13" y1="3" x2="11" y2="8"></line>
                    <line x1="19" y1="3" x2="17" y2="8"></line>
                    <polygon points="10 12 15 15 10 18" fill="currentColor"></polygon>
                </svg>
                <!-- Animated Glowing 🔥 HOT Badge -->
                <span class="smart-hero-hot-badge">🔥 HOT</span>
            </div>
            <span class="smart-nav-hero-label">Reels</span>
        </a>

        <!-- 4: WISHLIST (Slide-over Drawer) -->
        <a href="javascript:void(0)" class="smart-nav-item" id="smartNavWishlist" data-tab="wishlist" onclick="handleSmartFooterAction(event, '', 'wishlist')">
            <div class="smart-nav-icon-box">
                <svg viewBox="0 0 24 24" class="smart-nav-svg">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <span class="smart-nav-badge" id="smartWishlistBadge">0</span>
            </div>
            <span class="smart-nav-label">Wishlist</span>
        </a>

        <!-- 5: MY ACCOUNT / ORDERS (Direct Role-Based Dashboard or Login Modal) -->
        <a href="javascript:void(0)" class="smart-nav-item" id="smartNavAccount" data-tab="account" onclick="handleSmartFooterAction(event, '', 'account')">
            <div class="smart-nav-icon-box">
                <svg viewBox="0 0 24 24" class="smart-nav-svg">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <span class="smart-nav-label">Account</span>
        </a>

    </div>
</nav>

<script>
(function() {
    // Toggle Reseller-style Home Mobile Menu Drawer
    window.toggleHomeMobileMenu = function(show) {
        var backdrop = document.getElementById('homeMenuDrawerBackdrop');
        if (!backdrop) return;
        if (typeof show === 'undefined') {
            backdrop.classList.toggle('active');
        } else if (show) {
            backdrop.classList.add('active');
            document.body.style.overflow = 'hidden';
            syncDrawerUserState();
        } else {
            backdrop.classList.remove('active');
            document.body.style.overflow = '';
        }
    };

    window.handleSmartFooterAction = function(e, targetUrl, actionKey) {
        // 1. MENU ACTION (Open Reseller-Style Mega Menu Drawer)
        if (actionKey === 'menu') {
            if (e) e.preventDefault();
            window.toggleHomeMobileMenu(true);
            return;
        }

        // 2. REELS ACTION (Open Fullscreen Reels Player)
        if (actionKey === 'reels') {
            if (e) e.preventDefault();
            if (typeof window.openReelsModal === 'function') {
                window.openReelsModal(0);
            } else {
                var reelSec = document.getElementById('section-reels');
                if (reelSec) reelSec.scrollIntoView({ behavior: 'smooth' });
            }
            return;
        }

        // 3. WISHLIST ACTION (Open Slide-over Drawer)
        if (actionKey === 'wishlist') {
            if (e) e.preventDefault();
            if (typeof window.openWishlistDrawer === 'function') {
                window.openWishlistDrawer();
            } else if (typeof window.openWishlistModal === 'function') {
                window.openWishlistModal();
            } else if (typeof window.openWishlist === 'function') {
                window.openWishlist();
            } else {
                window.location.href = '/Frontend/Shop/wishlist.php';
            }
            return;
        }

        // 4. MY ACCOUNT ACTION (Role-Based Direct Dashboard or Login Modal)
        if (actionKey === 'account') {
            if (e) e.preventDefault();
            if (typeof window.handleUserWiseAccountNavigation === 'function') {
                window.handleUserWiseAccountNavigation();
            } else if (typeof window.openAccountModal === 'function') {
                window.openAccountModal('login');
            } else {
                window.location.href = '/Shared/Auth/myaccount.php?tab=login';
            }
            return;
        }

        // 5. PAGE NAVIGATION (Smooth scroll to top if already on page)
        var currentPath = window.location.pathname;
        if (targetUrl && (currentPath.endsWith(targetUrl) || (actionKey === 'shop' && currentPath.indexOf('shop.php') !== -1))) {
            if (e) e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
    };

    // Live Wishlist Counter Synchronizer
    function syncSmartWishlistCounter() {
        try {
            var wishlist = JSON.parse(localStorage.getItem('dt_wishlist') || localStorage.getItem('dtbrands_wishlist') || '[]');
            var count = Array.isArray(wishlist) ? wishlist.length : 0;
            var badge = document.getElementById('smartWishlistBadge');
            if (badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'flex' : 'none';
            }
        } catch(err) {}
    }

    // Sync Drawer User Name, Role & Tier
    function syncDrawerUserState() {
        var userRaw = localStorage.getItem('dtbrands_user');
        var nameEl = document.getElementById('homeMenuUserName');
        var tierEl = document.querySelector('.home-menu-user-tier span');
        var badgeEl = document.querySelector('.home-menu-tier-badge');
        if (userRaw && nameEl) {
            try {
                var user = JSON.parse(userRaw);
                nameEl.textContent = user.name || 'VIP Member';
                var role = user.role || 'Reseller';
                if (tierEl) tierEl.textContent = '★ Verified ' + role;
                if (badgeEl) badgeEl.textContent = role.toUpperCase();
            } catch(e) {}
        } else if (nameEl) {
            nameEl.textContent = 'Guest / Sign In';
            if (tierEl) tierEl.textContent = '★ Tap to Login';
            if (badgeEl) badgeEl.textContent = 'LOGIN';
        }
    }

    // Active page highlighter
    function initActivePageTab() {
        var currentPath = window.location.pathname;
        var items = document.querySelectorAll('.smart-nav-item');
        items.forEach(function(item) {
            var tab = item.getAttribute('data-tab');
            var isCurrent = false;
            if (tab === 'home' && (currentPath === '/' || currentPath.endsWith('/') || currentPath.indexOf('home.php') !== -1)) isCurrent = true;
            if (tab === 'shop' && currentPath.indexOf('shop.php') !== -1) isCurrent = true;

            item.classList.toggle('active', isCurrent);
        });

        syncSmartWishlistCounter();
        syncDrawerUserState();
        window.addEventListener('storage', function() {
            syncSmartWishlistCounter();
            syncDrawerUserState();
        });
    }

    window.syncSmartWishlistCounter = syncSmartWishlistCounter;

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initActivePageTab);
    } else {
        initActivePageTab();
    }
})();
</script>
