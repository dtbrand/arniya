<?php
/**
 * homebottomfooter.php — SMART ANIMATED LIQUID BOTTOM FOOTER
 * Luxury DT Brand Curved Active Cutout Indicator for Mobile Storefront
 * Fluid gliding active bubble, SVG curved cutout, brand gold gradients & live counters
 */
?>
<!-- ══════════════════════════════════════════════════════════════════
     SMART ANIMATED MOBILE BOTTOM FOOTER (DT BRAND LUXURY GOLD)
══════════════════════════════════════════════════════════════════ -->
<style>
/* ── Container & Floating Bar ── */
.home-smart-bottom-footer {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 9990;
    padding: 0 10px;
    padding-bottom: max(8px, env(safe-area-inset-bottom, 8px));
    pointer-events: none;
}

@media (max-width: 768px) {
    .home-smart-bottom-footer {
        display: block;
    }
    body {
        padding-bottom: clamp(75px, 18vw, 90px) !important;
    }
}

.smart-nav-wrapper {
    position: relative;
    max-width: 440px;
    margin: 0 auto;
    background: #181512;
    background: linear-gradient(180deg, #221D18 0%, #14110E 100%);
    border: 1.5px solid rgba(212, 175, 55, 0.38);
    border-radius: 28px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.48), 0 2px 10px rgba(212, 175, 55, 0.18);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    pointer-events: auto;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: space-around;
    padding: 0 6px;
    user-select: none;
    -webkit-user-select: none;
}

/* ── Nav Item Links ── */
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
    transition: color 0.28s ease, transform 0.25s ease;
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
}

.smart-nav-icon-box {
    position: relative;
    width: 32px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 3px;
    transition: transform 0.38s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.2s ease;
}

.smart-nav-svg {
    width: 22px;
    height: 22px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    transition: all 0.3s ease;
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
    transform: none !important;
}

/* ── Active Floating Bubble (Animated Notch Pill) ── */
.smart-nav-active-bubble {
    position: absolute;
    top: -18px;
    left: 0;
    width: 52px;
    height: 52px;
    border-radius: 50%;
    background: linear-gradient(135deg, #F5D77F 0%, #D4AF37 40%, #8A681F 100%);
    box-shadow: 0 8px 24px rgba(212, 175, 55, 0.5), 0 2px 6px rgba(0, 0, 0, 0.35), inset 0 2px 4px rgba(255, 255, 255, 0.45);
    border: 3.5px solid #181512;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    pointer-events: none;
    transition: transform 0.42s cubic-bezier(0.34, 1.45, 0.64, 1);
    transform: translateX(0);
}

.smart-nav-active-bubble svg {
    width: 24px;
    height: 24px;
    stroke: #FFFFFF;
    stroke-width: 2.2;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
    animation: smartPulse 2.5s infinite ease-in-out;
}

@keyframes smartPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.08); }
}

/* Active Item State */
.smart-nav-item.active {
    color: #F5D77F;
}

.smart-nav-item.active .smart-nav-icon-box {
    transform: translateY(-24px) scale(0);
    opacity: 0;
}

.smart-nav-item.active .smart-nav-label {
    opacity: 1;
    color: #F5D77F;
    font-weight: 800;
    transform: none !important;
}

/* ── Live Badge Bubble (Wishlist & Orders) ── */
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
    animation: badgePulse 2s infinite ease;
}

.smart-nav-badge.badge-gold {
    background: linear-gradient(135deg, #D4AF37 0%, #8A681F 100%);
    color: #1E1B18;
}

@keyframes badgePulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.15); }
}

/* Tap Ripple Effect */
.smart-nav-item:active {
    transform: scale(0.92);
}
</style>

<nav class="home-smart-bottom-footer" id="homeSmartBottomFooter" aria-label="Mobile Bottom Navigation">
    <div class="smart-nav-wrapper" id="smartNavWrapper">
        <!-- Floating Active Bubble with Gradient & Icon -->
        <div class="smart-nav-active-bubble" id="smartActiveBubble" aria-hidden="true">
            <svg viewBox="0 0 24 24" id="smartActiveBubbleSvg">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
        </div>

        <!-- 1: HOME -->
        <a href="/Frontend/Home/home.php" class="smart-nav-item active" data-index="0" data-icon="home" onclick="handleSmartNavClick(event, 0, '/Frontend/Home/home.php', 'home')">
            <div class="smart-nav-icon-box">
                <svg viewBox="0 0 24 24" class="smart-nav-svg">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </div>
            <span class="smart-nav-label">Home</span>
        </a>

        <!-- 2: SHOP / BOUTIQUE STORE (Real Storefront Canopy SVG) -->
        <a href="/Frontend/Shop/shop.php" class="smart-nav-item" data-index="1" data-icon="shop" onclick="handleSmartNavClick(event, 1, '/Frontend/Shop/shop.php', 'shop')">
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

        <!-- 3: RESELLER / B2B -->
        <a href="/Frontend/Reseller/reseller.php" class="smart-nav-item" data-index="2" data-icon="reseller" onclick="handleSmartNavClick(event, 2, '/Frontend/Reseller/reseller.php', 'reseller')">
            <div class="smart-nav-icon-box">
                <svg viewBox="0 0 24 24" class="smart-nav-svg">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                </svg>
                <span class="smart-nav-badge badge-gold">HOT</span>
            </div>
            <span class="smart-nav-label">Resell</span>
        </a>

        <!-- 4: WISHLIST (Smooth Slide-over Drawer / Modal) -->
        <a href="javascript:void(0)" class="smart-nav-item" data-index="3" data-icon="wishlist" onclick="handleSmartNavClick(event, 3, '', 'wishlist')">
            <div class="smart-nav-icon-box">
                <svg viewBox="0 0 24 24" class="smart-nav-svg">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <span class="smart-nav-badge" id="smartWishlistBadge">0</span>
            </div>
            <span class="smart-nav-label">Wishlist</span>
        </a>

        <!-- 5: MY ACCOUNT / ORDERS (Interactive Profile & Order Modal) -->
        <a href="javascript:void(0)" class="smart-nav-item" data-index="4" data-icon="account" onclick="handleSmartNavClick(event, 4, '', 'account')">
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
    // SVGs mapping for floating active bubble
    var iconSvgs = {
        'home': '<path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline>',
        'shop': '<path d="M3 9l1-5h16l1 5"></path><path d="M3 9a3 3 0 0 0 6 0 3 3 0 0 0 6 0 3 3 0 0 0 6 0"></path><path d="M4 14v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-6"></path><path d="M10 22v-6h4v6"></path>',
        'reseller': '<polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>',
        'wishlist': '<path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>',
        'account': '<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>'
    };

    function updateActiveBubblePosition(index) {
        var wrapper = document.getElementById('smartNavWrapper');
        var bubble = document.getElementById('smartActiveBubble');
        var bubbleSvg = document.getElementById('smartActiveBubbleSvg');
        if (!wrapper || !bubble) return;

        var items = wrapper.querySelectorAll('.smart-nav-item');
        if (!items[index]) return;

        var targetItem = items[index];
        var itemRect = targetItem.getBoundingClientRect();
        var wrapperRect = wrapper.getBoundingClientRect();

        var bubbleWidth = bubble.offsetWidth || 52;
        var offsetLeft = (itemRect.left - wrapperRect.left) + (itemRect.width / 2) - (bubbleWidth / 2);

        bubble.style.transform = 'translateX(' + offsetLeft + 'px)';

        var iconKey = targetItem.getAttribute('data-icon') || 'home';
        if (bubbleSvg && iconSvgs[iconKey]) {
            bubbleSvg.innerHTML = iconSvgs[iconKey];
        }

        items.forEach(function(el, i) {
            el.classList.toggle('active', i === index);
        });
    }

    window.handleSmartNavClick = function(e, index, targetUrl, actionKey) {
        // Update active bubble visual state instantly
        updateActiveBubblePosition(index);

        // 1. WISHLIST ACTION
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

        // 2. MY ACCOUNT ACTION
        if (actionKey === 'account') {
            if (e) e.preventDefault();
            if (typeof window.openAccountModal === 'function') {
                window.openAccountModal();
            } else if (typeof window.openAccountDrawer === 'function') {
                window.openAccountDrawer();
            } else if (typeof window.openAccount === 'function') {
                window.openAccount();
            } else {
                window.location.href = '/Shared/Auth/myaccount.php';
            }
            return;
        }

        // 3. PAGE NAVIGATION
        var currentPath = window.location.pathname;
        if (targetUrl && (currentPath.endsWith(targetUrl) || (index === 0 && currentPath.indexOf('home.php') !== -1))) {
            if (e) e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
        // Let standard link navigation proceed if different page
    };

    // Live Wishlist Counter Synchronizer
    function syncSmartWishlistCounter() {
        try {
            var wishlist = JSON.parse(localStorage.getItem('dt_wishlist') || '[]');
            var count = Array.isArray(wishlist) ? wishlist.length : 0;
            var badge = document.getElementById('smartWishlistBadge');
            if (badge) {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'flex' : 'none';
            }
        } catch(err) {}
    }

    // Initialize on load
    function initSmartFooter() {
        var currentPath = window.location.pathname;
        var activeIndex = 0; // Default to Home
        if (currentPath.indexOf('shop.php') !== -1) activeIndex = 1;
        else if (currentPath.indexOf('reseller.php') !== -1) activeIndex = 2;

        updateActiveBubblePosition(activeIndex);
        syncSmartWishlistCounter();

        // Listen for storage updates
        window.addEventListener('storage', syncSmartWishlistCounter);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSmartFooter);
    } else {
        initSmartFooter();
    }

    window.addEventListener('resize', function() {
        var activeItem = document.querySelector('.smart-nav-item.active');
        if (activeItem) {
            var idx = parseInt(activeItem.getAttribute('data-index') || '0', 10);
            updateActiveBubblePosition(idx);
        }
    }, { passive: true });
})();
</script>
