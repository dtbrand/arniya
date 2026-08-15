<?php
/**
 * singelproduthader.php — PARTIAL INCLUDE
 * Dedicated Luxury Header for Single Product Page (PDP)
 * Features Breadcrumbs, Return to Shop Navigation, Live Wishlist & Cart Counters, and VIP User Status
 */
?>
<style>
/* ── Single Product Header ─────────────────────────────────────────── */
.pdp-header {
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
.pdp-header.scrolled {
    box-shadow: 0 4px 20px rgba(138,104,31,0.14);
}

/* ── Top Announcement Marquee ── */
.pdp-top-ticker {
    background: linear-gradient(90deg, #7A5B18 0%, #9C7724 50%, #7A5B18 100%);
    color: #FFF8EB;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 5px 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    border-bottom: 1px solid #5C4310;
}
.pdp-top-ticker span { display: inline-flex; align-items: center; gap: 6px; }

/* ── Main Nav Container ── */
.pdp-header-main {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    height: 64px;
    padding: 0 clamp(14px, 3vw, 32px);
    gap: 16px;
}

/* ── Left: Back Button & Logo ── */
.pdp-header-left {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-shrink: 0;
}
.pdp-back-btn {
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
}
.pdp-back-btn:hover {
    border-color: var(--dark-gold, #8A681F);
    background: #FFFFFF;
    color: var(--dark-gold, #8A681F);
    transform: translateX(-2px);
    box-shadow: 0 2px 8px rgba(138,104,31,0.15);
}
.pdp-back-btn svg {
    width: 14px;
    height: 14px;
    stroke: currentColor;
    stroke-width: 2.4;
    fill: none;
}

.pdp-brand-seal {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}
.pdp-logo-badge {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--dark-gold, #8A681F) 0%, var(--deep-gold, #6F5218) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FFFFFF;
    box-shadow: 0 2px 8px rgba(138,104,31,0.3);
    flex-shrink: 0;
}
.pdp-logo-badge svg {
    width: 19px;
    height: 19px;
    stroke: currentColor;
    stroke-width: 2.2;
    fill: none;
}
.pdp-brand-text h1 {
    font-family: var(--font-serif, 'Cinzel', serif);
    font-size: 1.15rem;
    font-weight: 800;
    color: var(--dark-gold, #8A681F);
    letter-spacing: 0.12em;
    line-height: 1.1;
    margin: 0;
}
.pdp-brand-text span {
    font-size: 0.58rem;
    font-weight: 700;
    color: var(--light-text, #9A9490);
    letter-spacing: 0.22em;
    text-transform: uppercase;
    display: block;
}

/* ── Center: Breadcrumb Bar (Desktop) ── */
.pdp-breadcrumbs {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.78rem;
    color: var(--mid-text, #5A5348);
    font-weight: 500;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
.pdp-breadcrumbs a {
    color: var(--mid-text, #5A5348);
    text-decoration: none;
    transition: color 0.2s;
}
.pdp-breadcrumbs a:hover {
    color: var(--dark-gold, #8A681F);
    text-decoration: underline;
}
.pdp-breadcrumbs .sep {
    color: var(--light-text, #9A9490);
    font-size: 0.7rem;
}
.pdp-breadcrumbs .current {
    font-weight: 700;
    color: var(--dark-gold, #8A681F);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 220px;
}

/* ── Right Actions ── */
.pdp-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}

/* WhatsApp Help Link */
.pdp-wa-help-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 12px;
    border-radius: 20px;
    background: #E8F5E9;
    color: #2E7D32;
    border: 1.5px solid rgba(46, 125, 50, 0.25);
    font-size: 0.76rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s ease;
}
.pdp-wa-help-btn:hover {
    background: #2E7D32;
    color: #FFFFFF;
}
.pdp-wa-help-btn svg {
    width: 15px; height: 15px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
}

/* Icon Buttons */
.pdp-icon-btn {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px; height: 40px;
    border-radius: 50%;
    border: 1.5px solid var(--soft-platinum, #E5E3DE);
    background: #FAF8F4;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    color: var(--dark-gold, #8A681F);
}
.pdp-icon-btn:hover {
    background: #FFFFFF;
    border-color: var(--dark-gold, #8A681F);
    transform: translateY(-1px);
}
.pdp-icon-btn svg {
    width: 19px; height: 19px;
    stroke: var(--dark-gold, #8A681F);
    stroke-width: 2;
    fill: none;
}
.pdp-badge-count {
    position: absolute;
    top: -4px; right: -4px;
    min-width: 18px; height: 18px;
    padding: 0 4px;
    background: var(--dark-gold, #8A681F);
    color: #FFFFFF;
    font-size: 0.62rem;
    font-weight: 700;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.18);
    transition: transform 0.2s;
}

/* Account Dropdown Pill */
.pdp-account-btn {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 6px 14px;
    border-radius: 20px;
    border: 1.5px solid var(--soft-platinum, #E5E3DE);
    background: #FAF8F4;
    cursor: pointer;
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: 0.78rem;
    font-weight: 700;
    color: var(--dark-text, #24211C);
    text-decoration: none;
    transition: all 0.2s ease;
}
.pdp-account-btn:hover {
    border-color: var(--dark-gold, #8A681F);
    background: #FFFFFF;
    color: var(--dark-gold, #8A681F);
}
.pdp-account-avatar {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: var(--dark-gold, #8A681F);
    color: #FFFFFF;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
    font-weight: 800;
}

@media (max-width: 900px) {
    .pdp-breadcrumbs { display: none; }
}
@media (max-width: 600px) {
    .pdp-brand-text { display: none; }
    .pdp-top-ticker { font-size: 0.62rem; padding: 4px 10px; }
    .pdp-wa-help-btn span { display: none; }
    .pdp-account-btn span { display: none; }
    .pdp-account-btn { padding: 6px; }
}
</style>

<header class="pdp-header" id="pdpHeader">
    <!-- Top Announcement Bar -->
    <div class="pdp-top-ticker">
        <span>✨ 100% Authentic Handloom Silk</span>
        <span>•</span>
        <span>⚡ Fast Express Delivery Across India</span>
        <span>•</span>
        <span>💎 7-Day Fast & Easy Exchange</span>
    </div>

    <!-- Main Navigation Bar -->
    <div class="pdp-header-main">
        <!-- Left: Back Button & Royal Seal -->
        <div class="pdp-header-left">
            <a href="shop.php" class="pdp-back-btn" aria-label="Back to Shop">
                <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                <span>Back to Shop</span>
            </a>

            <a href="shop.php" class="pdp-brand-seal" aria-label="Kalaniketan Home">
                <div class="pdp-logo-badge">
                    <svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                </div>
                <div class="pdp-brand-text">
                    <h1>KALANIKETAN</h1>
                    <span>Ethnic Luxury Couture</span>
                </div>
            </a>
        </div>

        <!-- Center: Breadcrumbs -->
        <nav class="pdp-breadcrumbs" aria-label="Breadcrumb">
            <a href="shop.php">Home</a>
            <span class="sep">›</span>
            <a href="shop.php?cat=<?= urlencode($product['category'] ?? 'Sarees') ?>"><?= htmlspecialchars($product['category'] ?? 'Sarees') ?></a>
            <span class="sep">›</span>
            <span class="current"><?= htmlspecialchars($product['name'] ?? 'Luxury Outfit') ?></span>
        </nav>

        <!-- Right: Actions (WhatsApp, Wishlist, Cart, Account) -->
        <div class="pdp-header-actions">
            <!-- WhatsApp Styling Concierge -->
            <a href="https://api.whatsapp.com/send?phone=919876543210&text=<?= urlencode('Hi Kalaniketan, I need more info regarding ' . ($product['name'] ?? 'this product')) ?>" target="_blank" class="pdp-wa-help-btn" rel="noopener">
                <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                <span>Ask Stylist</span>
            </a>

            <!-- Wishlist Button -->
            <button class="pdp-icon-btn" id="pdpWishlistBtn" aria-label="Wishlist" onclick="if(typeof window.openWishlistDrawer==='function') window.openWishlistDrawer(); else window.location.href='wishlist.php';">
                <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                <span class="pdp-badge-count" id="pdpWishlistCount" style="display:none;">0</span>
            </button>

            <!-- Bag / Cart Button -->
            <button class="pdp-icon-btn" id="pdpCartBtn" aria-label="Shopping Bag" onclick="if(typeof window.openCartDrawer==='function') window.openCartDrawer(); else window.location.href='cart.php';">
                <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <span class="pdp-badge-count" id="pdpCartCount" style="display:none;">0</span>
            </button>

            <!-- Member Account Button -->
            <a href="myaccount.php" class="pdp-account-btn" id="pdpAccountBtn" aria-label="My Account">
                <div class="pdp-account-avatar" id="pdpUserAvatar">👤</div>
                <span id="pdpUserLabel">Account</span>
            </a>
        </div>
    </div>
</header>

<script>
/* ── Single Product Header Sync Engine ── */
(function() {
    'use strict';

    // Header scroll shadow toggle
    window.addEventListener('scroll', function() {
        var header = document.getElementById('pdpHeader');
        if (header) {
            header.classList.toggle('scrolled', window.scrollY > 20);
        }
    }, { passive: true });

    // Sync Badges and User Profile state
    window.syncPdpHeaderState = function() {
        // 1. Sync Cart Badge
        try {
            var cart = JSON.parse(localStorage.getItem('kalaniketan_cart') || '[]');
            var totalQty = cart.reduce(function(sum, item) { return sum + (item.qty || 1); }, 0);
            var cartBadge = document.getElementById('pdpCartCount');
            if (cartBadge) {
                cartBadge.textContent = totalQty;
                cartBadge.style.display = totalQty > 0 ? 'flex' : 'none';
            }
        } catch(e) {}

        // 2. Sync Wishlist Badge
        try {
            var wish = JSON.parse(localStorage.getItem('kalaniketan_wishlist') || '[]');
            var wishBadge = document.getElementById('pdpWishlistCount');
            if (wishBadge) {
                wishBadge.textContent = wish.length;
                wishBadge.style.display = wish.length > 0 ? 'flex' : 'none';
            }
        } catch(e) {}

        // 3. Sync User Profile State
        try {
            var userRaw = localStorage.getItem('kalaniketan_user');
            var userLabel = document.getElementById('pdpUserLabel');
            var userAvatar = document.getElementById('pdpUserAvatar');
            if (userRaw && userLabel && userAvatar) {
                var user = JSON.parse(userRaw);
                var firstName = (user.name || 'Member').split(' ')[0];
                userLabel.textContent = firstName;
                userAvatar.textContent = firstName.charAt(0).toUpperCase();
            } else if (userLabel && userAvatar) {
                userLabel.textContent = 'Account';
                userAvatar.textContent = '👤';
            }
        } catch(e) {}
    };

    document.addEventListener('DOMContentLoaded', window.syncPdpHeaderState);
    window.addEventListener('storage', window.syncPdpHeaderState);
})();
</script>
