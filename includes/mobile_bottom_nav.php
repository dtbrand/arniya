<?php
/**
 * DT Brand/includes/mobile_bottom_nav.php — Smart Luxury 5-Tab Floating Mobile Navigation Bar
 * DT Brand's & Jai Hanuman Tex
 */
$currentScript = basename($_SERVER['PHP_SELF'] ?? '');
?>
<nav class="dt-mobile-bottom-nav" id="dtMobileBottomNav" aria-label="Mobile Bottom Navigation">
    <div class="dt-bottom-nav-pill">
        <!-- Tab 1: Home -->
        <a href="/" class="dt-bottom-tab <?= $currentScript === 'index.php' || $currentScript === 'home.php' ? 'active' : '' ?>">
            <div class="dt-tab-icon-wrap">
                <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
            </div>
            <span class="dt-tab-label">Home</span>
        </a>

        <!-- Tab 2: Shop -->
        <a href="/shop.php" class="dt-bottom-tab <?= $currentScript === 'shop.php' || $currentScript === 'product.php' ? 'active' : '' ?>">
            <div class="dt-tab-icon-wrap">
                <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            </div>
            <span class="dt-tab-label">Shop</span>
        </a>

        <!-- Tab 3: Reseller -->
        <a href="/reseller.php" class="dt-bottom-tab highlight-tab <?= $currentScript === 'reseller.php' ? 'active' : '' ?>">
            <div class="dt-tab-icon-wrap">
                <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
            </div>
            <span class="dt-tab-label">Resell</span>
        </a>

        <!-- Tab 4: Bag / Cart -->
        <button type="button" class="dt-bottom-tab" id="dtBottomCartTrigger" onclick="if(typeof openCartDrawer==='function') openCartDrawer();">
            <div class="dt-tab-icon-wrap">
                <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                <span class="dt-tab-badge" id="dtBottomCartBadge" style="display:none;">0</span>
            </div>
            <span class="dt-tab-label">Bag</span>
        </button>

        <!-- Tab 5: Account -->
        <a href="/account.php" class="dt-bottom-tab <?= $currentScript === 'account.php' ? 'active' : '' ?>">
            <div class="dt-tab-icon-wrap">
                <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
            </div>
            <span class="dt-tab-label">Account</span>
        </a>
    </div>
</nav>
