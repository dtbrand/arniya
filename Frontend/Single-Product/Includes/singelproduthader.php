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
    transition: transform 0.3s cubic-bezier(0.25, 1, 0.5, 1), box-shadow 0.25s ease;
    will-change: transform;
}
.pdp-header.scrolled {
    transform: translateY(-30px);
    box-shadow: 0 4px 20px rgba(138,104,31,0.14);
}

/* ── Top Announcement Slider Bar ── */
.pdp-top-ticker {
    background: linear-gradient(90deg, #705114 0%, #8E6B1F 50%, #705114 100%);
    color: #FFF9EE;
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 0.04em;
    height: 30px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid rgba(255, 255, 255, 0.12);
    user-select: none;
}
.pdp-ticker-track {
    position: relative;
    width: 100%;
    max-width: 650px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.pdp-ticker-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    opacity: 0;
    transform: translateY(100%);
    transition: transform 0.45s cubic-bezier(0.25, 1, 0.5, 1), opacity 0.45s ease;
    white-space: nowrap;
    text-overflow: ellipsis;
    overflow: hidden;
    padding: 0 24px;
}
.pdp-ticker-slide.active {
    opacity: 1;
    transform: translateY(0);
    position: relative;
}
.pdp-ticker-slide.exit-up {
    opacity: 0;
    transform: translateY(-100%);
    position: absolute;
}
.pdp-ticker-icon {
    font-size: 0.82rem;
    display: inline-block;
}
.pdp-ticker-text {
    font-size: 0.68rem;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}
.pdp-ticker-text strong {
    font-weight: 800;
    color: #FFE699;
}
.pdp-ticker-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    color: rgba(255, 255, 255, 0.7);
    font-size: 1.1rem;
    line-height: 1;
    cursor: pointer;
    padding: 0 10px;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    z-index: 2;
}
.pdp-ticker-arrow:hover {
    color: #FFFFFF;
    background: rgba(0, 0, 0, 0.15);
}
.pdp-ticker-arrow.prev { left: 4px; }
.pdp-ticker-arrow.next { right: 4px; }

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
@media (max-width: 767px) {
    .pdp-header.scrolled {
        transform: translateY(-26px);
    }

    /* Mobile Header Layout: Back to Shop (Left) | Brand Logo (Center) | Share Button (Right) */
    .pdp-header-main {
        position: relative;
        height: 48px;
        min-height: 48px;
        padding: 0 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .pdp-top-ticker {
        height: 26px;
        font-size: 0.56rem;
        padding: 0 8px;
        gap: 6px;
        line-height: 1.2;
    }

    .pdp-header-left {
        width: auto;
        display: flex;
        align-items: center;
    }
    .pdp-header-actions {
        display: none !important;
    }

    /* Normal Small Back to Shop Button (Left) */
    .pdp-back-btn {
        padding: 4px 9px;
        font-size: 0.70rem;
        gap: 4px;
        border-radius: 14px;
        z-index: 2;
    }
    .pdp-back-btn svg {
        width: 12px;
        height: 12px;
    }

    /* Perfectly Centered Brand Seal (Mobile) */
    .pdp-brand-seal {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        margin: 0;
        gap: 6px;
        z-index: 1;
        pointer-events: auto;
    }
    .pdp-logo-badge {
        width: 26px;
        height: 26px;
    }
    .pdp-logo-badge svg {
        width: 13px;
        height: 13px;
    }
    .pdp-brand-text h1 {
        font-size: 0.84rem;
    }
    .pdp-brand-text span {
        font-size: 0.44rem;
        letter-spacing: 0.12em;
    }

    /* Right Share Icon Button (Mobile) */
    .pdp-mobile-share-btn {
        display: flex !important;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #FAF8F4;
        border: 1.5px solid var(--soft-platinum, #E5E3DE);
        color: var(--dark-gold, #8A681F);
        cursor: pointer;
        transition: all 0.2s ease;
        flex-shrink: 0;
        z-index: 2;
    }
    .pdp-mobile-share-btn:hover {
        background: #FFFFFF;
        border-color: var(--dark-gold, #8A681F);
        color: var(--dark-gold, #8A681F);
    }
    .pdp-mobile-share-btn svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2.2;
        fill: none;
    }
}
@media (min-width: 768px) {
    .pdp-mobile-share-btn {
        display: none !important;
    }
}
@media (max-width: 480px) {
    .pdp-brand-text span {
        display: none;
    }
}
</style>

<header class="pdp-header" id="pdpHeader">
    <!-- Top Announcement Bar (Auto-Sliding Slider) -->
    <div class="pdp-top-ticker" id="pdpAnnouncementTicker">
        <button type="button" class="pdp-ticker-arrow prev" onclick="slidePdpTicker(-1)" aria-label="Previous announcement">‹</button>
        <div class="pdp-ticker-track" id="pdpTickerTrack">
            <div class="pdp-ticker-slide active">
                <span class="pdp-ticker-icon">✨</span>
                <span class="pdp-ticker-text"><strong>100% Original Product</strong> • Certified Handloom Silk</span>
            </div>
            <div class="pdp-ticker-slide">
                <span class="pdp-ticker-icon">⚡</span>
                <span class="pdp-ticker-text"><strong>Fast Express Delivery</strong> • Dispatched in 24–48 Hours</span>
            </div>
            <div class="pdp-ticker-slide">
                <span class="pdp-ticker-icon">💎</span>
                <span class="pdp-ticker-text"><strong>7-Day Fast Exchange</strong> • Zero-Hassle Doorstep Pickup</span>
            </div>
            <div class="pdp-ticker-slide">
                <span class="pdp-ticker-icon">🎁</span>
                <span class="pdp-ticker-text"><strong>Luxury Gift Box</strong> • Complimentary Royal Packaging</span>
            </div>
        </div>
        <button type="button" class="pdp-ticker-arrow next" onclick="slidePdpTicker(1)" aria-label="Next announcement">›</button>
    </div>

    <!-- Main Navigation Bar -->
    <div class="pdp-header-main">
        <!-- Left: Back Button & Royal Seal -->
        <div class="pdp-header-left">
            <a href="../Shop/shop.php" class="pdp-back-btn" aria-label="Shop">
                <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                <span>Shop</span>
            </a>

                    <a href="/shop" class="pdp-brand-seal" title="Return to DT Brand's Luxury Store" style="display:inline-flex; align-items:center; text-decoration:none;">
            <img src="/Shared/Asset/images/logo.png" onerror="this.src='/Frontend/Single-Product/Asset/images/logo.png';" alt="DT Brand's" class="header-brand-real-logo" style="height:34px; width:auto; max-width:150px; object-fit:contain;">
        </a>
        </div>

        <!-- Center: Breadcrumbs -->
        <nav class="pdp-breadcrumbs" aria-label="Breadcrumb">
            <a href="../Shop/shop.php">Home</a>
            <span class="sep">›</span>
            <a href="../Shop/shop.php?cat=<?= urlencode($product['category'] ?? 'Sarees') ?>"><?= htmlspecialchars($product['category'] ?? 'Sarees') ?></a>
            <span class="sep">›</span>
            <span class="current"><?= htmlspecialchars($product['name'] ?? 'Luxury Outfit') ?></span>
        </nav>

        <!-- Right Share Button (Mobile Only) -->
        <button type="button" class="pdp-mobile-share-btn" id="pdpMobileShareBtn" aria-label="Share Product" title="Share" onclick="if(typeof window.shareCurrentProduct==='function') window.shareCurrentProduct();">
            <svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
        </button>

        <!-- Right: Actions (Share, Wishlist, Cart, Account - Desktop) -->
        <div class="pdp-header-actions">

            <!-- Share Product Button (Desktop) -->
            <button class="pdp-icon-btn pdp-share-btn" id="pdpShareBtn" aria-label="Share Product" title="Share Product" onclick="if(typeof window.shareCurrentProduct==='function') window.shareCurrentProduct();">
                <svg viewBox="0 0 24 24"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
            </button>

            <!-- Wishlist Button -->
            <button class="pdp-icon-btn" id="pdpWishlistBtn" aria-label="Wishlist" onclick="if(typeof window.openWishlistDrawer==='function'){window.openWishlistDrawer();}else if(typeof window.openWishlist==='function'){window.openWishlist();}">
                <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                <span class="pdp-badge-count" id="pdpWishlistCount" style="display:none;">0</span>
            </button>

            <!-- Bag / Cart Button -->
            <button class="pdp-icon-btn" id="pdpCartBtn" aria-label="Shopping Bag" onclick="if(typeof window.openCartDrawer==='function'){window.openCartDrawer();}else if(typeof window.openCart==='function'){window.openCart();}">
                <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <span class="pdp-badge-count" id="pdpCartCount" style="display:none;">0</span>
            </button>

            <!-- Member Account Button -->
            <a href="javascript:void(0)" onclick="if(typeof window.handleUserWiseAccountNavigation==='function'){window.handleUserWiseAccountNavigation();}else if(typeof window.openAccountModal==='function'){window.openAccountModal('login');}else{window.location.href='../../Shared/Auth/myaccount.php?tab=login';}" class="pdp-account-btn" id="pdpAccountBtn" aria-label="My Account">
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

    /* Product Smart Share Handler (Meesho Flow) */
    window.shareCurrentProduct = function() {
        if (typeof window.openSmartShareModal === 'function') {
            var prodData = {
                id: <?= json_encode($product['id'] ?? 1) ?>,
                name: <?= json_encode($product['name'] ?? '') ?>,
                category: <?= json_encode($product['category'] ?? '') ?>,
                price: <?= json_encode($product['price'] ?? 0) ?>,
                old_price: <?= json_encode($product['old_price'] ?? 0) ?>,
                discount: <?= json_encode($product['discount'] ?? 0) ?>,
                image: <?= json_encode($product['image'] ?? '') ?>,
                fabric: <?= json_encode($product['fabric'] ?? '') ?>,
                colors: <?= json_encode(implode(', ', $product['colors'] ?? [$product['color'] ?? ''])) ?>,
                sizes: <?= json_encode(implode(', ', $product['size'] ?? ['Free Size'])) ?>,
                url: window.location.href
            };
            window.openSmartShareModal(prodData);
        } else {
            alert('Opening Smart Share...');
        }
    };

    /* ── Top Announcement Slider Engine ── */
    var pdpTickerIndex = 0;
    var pdpTickerInterval = null;

    window.slidePdpTicker = function(dir) {
        var slides = document.querySelectorAll('#pdpTickerTrack .pdp-ticker-slide');
        if (!slides.length) return;
        
        var currentSlide = slides[pdpTickerIndex];
        pdpTickerIndex = (pdpTickerIndex + dir + slides.length) % slides.length;
        var nextSlide = slides[pdpTickerIndex];

        slides.forEach(function(s) {
            s.classList.remove('active', 'exit-up');
        });

        if (currentSlide && currentSlide !== nextSlide) {
            currentSlide.classList.add('exit-up');
        }
        if (nextSlide) {
            nextSlide.classList.add('active');
        }

        restartPdpTickerTimer();
    };

    function restartPdpTickerTimer() {
        if (pdpTickerInterval) clearInterval(pdpTickerInterval);
        pdpTickerInterval = setInterval(function() {
            window.slidePdpTicker(1);
        }, 3200);
    }

    // Auto-start ticker slider
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', restartPdpTickerTimer);
    } else {
        restartPdpTickerTimer();
    }

    // Zero-vibration header scroll hide/show engine with hysteresis
    var isPdpHeaderScrolled = false;
    window.addEventListener('scroll', function() {
        var sy = window.scrollY || window.pageYOffset || 0;
        var header = document.getElementById('pdpHeader');
        if (!header) return;

        if (sy > 45 && !isPdpHeaderScrolled) {
            isPdpHeaderScrolled = true;
            header.classList.add('scrolled');
        } else if (sy < 10 && isPdpHeaderScrolled) {
            isPdpHeaderScrolled = false;
            header.classList.remove('scrolled');
        }
    }, { passive: true });

    // Sync Badges and User Profile state
    window.syncPdpHeaderState = function() {
        // 1. Sync Cart Badge
        try {
            var cart = JSON.parse(localStorage.getItem('dtbrands_cart') || '[]');
            var totalQty = cart.reduce(function(sum, item) { return sum + (item.qty || 1); }, 0);
            var cartBadge = document.getElementById('pdpCartCount');
            if (cartBadge) {
                cartBadge.textContent = totalQty;
                cartBadge.style.display = totalQty > 0 ? 'flex' : 'none';
            }
        } catch(e) {}

        // 2. Sync Wishlist Badge
        try {
            var wish = JSON.parse(localStorage.getItem('dtbrands_wishlist') || '[]');
            var wishBadge = document.getElementById('pdpWishlistCount');
            if (wishBadge) {
                wishBadge.textContent = wish.length;
                wishBadge.style.display = wish.length > 0 ? 'flex' : 'none';
            }
        } catch(e) {}

        // 3. Sync User Profile State
        try {
            var userRaw = localStorage.getItem('dtbrands_user');
            var userLabel = document.getElementById('pdpUserLabel');
            var userAvatar = document.getElementById('pdpUserAvatar');
            var acBtn = document.getElementById('pdpAccountBtn');
            if (userRaw && userLabel && userAvatar) {
                var user = JSON.parse(userRaw);
                var firstName = (user.name || 'Member').split(' ')[0];
                var role = (user.role || '').toLowerCase();
                userLabel.textContent = firstName;
                userAvatar.textContent = firstName.charAt(0).toUpperCase();
                if (acBtn) {
                    if (role === 'wholesaler') {
                        acBtn.href = '../Wholesale/wholesale.php';
                    } else if (role === 'retailer') {
                        acBtn.href = '../Retailer/retailer.php';
                    } else if (role === 'reseller') {
                        acBtn.href = '../Reseller/reseller.php';
                    } else {
                        acBtn.href = '../../Shared/Auth/myaccount.php';
                    }
                }
            } else if (userLabel && userAvatar) {
                userLabel.textContent = 'Account';
                userAvatar.textContent = '👤';
                if (acBtn) acBtn.href = '../../Shared/Auth/myaccount.php';
            }
        } catch(e) {}
    };

    document.addEventListener('DOMContentLoaded', window.syncPdpHeaderState);
    window.addEventListener('storage', window.syncPdpHeaderState);
})();
</script>
