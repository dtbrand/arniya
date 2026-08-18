<?php
/**
 * homebottomfooter.php — PERMANENT HERO REELS MOBILE BOTTOM FOOTER
 * Luxury DT Brand Center Elevated Floating Reels Action Button with Animated HOT Badge
 * Color-transition hover/active states for Home, Shop, Wishlist, Account
 */
?>
<!-- ══════════════════════════════════════════════════════════════════
     PERMANENT HERO REELS MOBILE BOTTOM FOOTER (DT BRAND LUXURY GOLD)
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
    padding: 0 12px;
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
</style>

<nav class="home-smart-bottom-footer" id="homeSmartBottomFooter" aria-label="Mobile Bottom Navigation">
    <div class="smart-nav-wrapper" id="smartNavWrapper">

        <!-- 1: HOME -->
        <a href="/Frontend/Home/home.php" class="smart-nav-item active" id="smartNavHome" data-tab="home" onclick="handleSmartFooterAction(event, '/Frontend/Home/home.php', 'home')">
            <div class="smart-nav-icon-box">
                <svg viewBox="0 0 24 24" class="smart-nav-svg">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </div>
            <span class="smart-nav-label">Home</span>
        </a>

        <!-- 2: SHOP / BOUTIQUE STORE -->
        <a href="/Frontend/Shop/shop.php" class="smart-nav-item" id="smartNavShop" data-tab="shop" onclick="handleSmartFooterAction(event, '/Frontend/Shop/shop.php', 'shop')">
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

        <!-- 5: MY ACCOUNT / ORDERS (Interactive Modal) -->
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
    window.handleSmartFooterAction = function(e, targetUrl, actionKey) {
        // 1. REELS ACTION (Open Fullscreen Reels Player)
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

        // 2. WISHLIST ACTION (Open Slide-over Drawer)
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

        // 3. MY ACCOUNT ACTION (Open Account Modal)
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

        // 4. PAGE NAVIGATION (Smooth scroll to top if already on page)
        var currentPath = window.location.pathname;
        if (targetUrl && (currentPath.endsWith(targetUrl) || (actionKey === 'home' && currentPath.indexOf('home.php') !== -1))) {
            if (e) e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            return;
        }
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

    // Active page highlighter
    function initActivePageTab() {
        var currentPath = window.location.pathname;
        var items = document.querySelectorAll('.smart-nav-item');
        items.forEach(function(item) {
            var tab = item.getAttribute('data-tab');
            var isCurrent = false;
            if (tab === 'home' && (currentPath.indexOf('home.php') !== -1 || currentPath === '/' || currentPath === '')) isCurrent = true;
            else if (tab === 'shop' && currentPath.indexOf('shop.php') !== -1) isCurrent = true;

            item.classList.toggle('active', isCurrent);
        });

        syncSmartWishlistCounter();
        window.addEventListener('storage', syncSmartWishlistCounter);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initActivePageTab);
    } else {
        initActivePageTab();
    }
})();
</script>
