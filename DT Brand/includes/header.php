<?php
/**
 * DT Brand/includes/header.php — Universal Master Responsive Header
 * DT Brand's & Jai Hanuman Tex
 */
$currentScript = basename($_SERVER['PHP_SELF'] ?? '');
$isHome = ($currentScript === 'index.php' || $currentScript === 'home.php');
?>
<header class="dt-master-header" id="dtMasterHeader">

    <!-- Top Announcement Auto-Sliding Bar -->
    <div class="dt-top-ticker" id="dtTopTicker">
        <button type="button" class="dt-ticker-arrow prev" onclick="if(typeof slideDtTicker==='function') slideDtTicker(-1)" aria-label="Previous announcement">‹</button>
        <div class="dt-ticker-track" id="dtTickerTrack">
            <div class="dt-ticker-slide active">
                <span class="dt-ticker-icon">✨</span>
                <span class="dt-ticker-text"><strong>100% Original Product</strong> &bull; Certified Pure Handloom Silk</span>
            </div>
            <div class="dt-ticker-slide">
                <span class="dt-ticker-icon">⚡</span>
                <span class="dt-ticker-text"><strong>Fast Delivery in 3–5 Days</strong> &bull; All India Express Dispatch</span>
            </div>
            <div class="dt-ticker-slide">
                <span class="dt-ticker-icon">💎</span>
                <span class="dt-ticker-text"><strong>7-Day Fast Exchange</strong> &bull; Zero-Hassle Doorstep Pickup</span>
            </div>
            <div class="dt-ticker-slide">
                <span class="dt-ticker-icon">🎁</span>
                <span class="dt-ticker-text"><strong>Luxury Gift Box</strong> &bull; Complimentary Royal Packaging</span>
            </div>
        </div>
        <button type="button" class="dt-ticker-arrow next" onclick="if(typeof slideDtTicker==='function') slideDtTicker(1)" aria-label="Next announcement">›</button>
    </div>

    <!-- Main Navigation Header Row -->
    <div class="dt-header-main" id="dtHeaderMain">
        <!-- Left: Brand Logo & Back to Home (Non-home pages) -->
        <div class="dt-header-left">
            <?php if (!$isHome): ?>
            <a href="/" class="dt-header-back-btn" aria-label="Back to Home">
                <svg viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                <span>Home</span>
            </a>
            <?php endif; ?>

            <a href="/" class="dt-brand-link" aria-label="DT Brand's Home">
                <img src="/assets/images/logo.png" onerror="this.src='/assets/images/logo.png';" alt="DT Brand's" class="dt-brand-logo" />
            </a>
        </div>

        <!-- Center: Amazon-Style Always-Open Desktop Search Bar -->
        <div class="dt-search-amazon" id="dtSearchAmazon">
            <div class="dt-search-cat-dropdown">
                <select class="dt-search-cat-select" id="dtSearchCatSelect" aria-label="Select Category">
                    <option value="All">All Categories</option>
                    <option value="Kanjivaram Silk">Kanjivaram</option>
                    <option value="Banarasi Silk">Banarasi</option>
                    <option value="Paithani">Paithani</option>
                    <option value="Designer Kurtis">Kurtis</option>
                    <option value="Organza Sarees">Organza</option>
                    <option value="Georgette & Chiffon">Georgette</option>
                </select>
                <svg class="dt-select-arrow" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>

            <div class="dt-search-input-wrap">
                <input
                    type="text"
                    class="dt-search-input"
                    id="dtSearchInput"
                    placeholder="Search silk sarees, kurtis, lehengas, wholesale lots..."
                    autocomplete="off"
                    aria-label="Search Catalog"
                />
                <button type="button" class="dt-search-clear" id="dtSearchClear" aria-label="Clear Search">✕</button>
                <div class="dt-search-suggestions" id="dtSearchSuggestions" style="display:none;"></div>
            </div>

            <button type="button" class="dt-search-submit" id="dtSearchSubmit" aria-label="Search">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>
        </div>

        <!-- Right: Actions (Mobile Search Trigger, Account, Wishlist, Cart) -->
        <div class="dt-header-actions">
            <!-- Mobile Search Icon Trigger Button -->
            <button type="button" class="dt-icon-btn dt-mobile-search-btn" id="dtMobileSearchTrigger" aria-label="Open Search">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>

            <!-- Account Dropdown Button -->
            <div class="dt-account-wrap" id="dtAccountWrap">
                <a href="javascript:void(0)" onclick="if(typeof openAuthModal==='function') openAuthModal('profile'); else if(typeof openAccountModal==='function') openAccountModal('login'); else window.location.href='/account.php';" class="dt-account-btn" id="dtAccountBtn" aria-label="Account">
                    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <span id="dtAccountLabel">Account</span>
                </a>
                <div class="dt-account-dropdown" id="dtAccountDropdown">
                    <a href="/" class="dt-drop-item" style="color:var(--dark-gold, #8A681F); font-weight:800;">
                        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                        <span>Home</span>
                    </a>
                    <a href="/shop.php" class="dt-drop-item">
                        <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        <span>Shop Catalog</span>
                    </a>
                    <a href="/wholesale.php" class="dt-drop-item" style="color:#8A681F; font-weight:700;">
                        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>Wholesale Hub</span>
                    </a>
                    <a href="/reseller.php" class="dt-drop-item" style="color:#8A681F; font-weight:700;">
                        <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <span>Reseller Portal</span>
                    </a>
                    <a href="/account.php" class="dt-drop-item" id="dtDropAccountOrders">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>My Account & Orders</span>
                    </a>
                    <a href="javascript:void(0)" onclick="if(typeof openAuthModal==='function') openAuthModal('login');" class="dt-drop-item" id="dtDropLogin">
                        <svg viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                        <span>Sign In / Register</span>
                    </a>
                    <div class="dt-drop-divider" id="dtDropDivider" style="display:none;"></div>
                    <a href="javascript:void(0)" class="dt-drop-item" id="dtDropLogout" style="display:none; color:#DC2626;" onclick="localStorage.removeItem('dtbrands_user'); window.location.reload();">
                        <svg viewBox="0 0 24 24" style="stroke:#DC2626;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <span>Log Out</span>
                    </a>
                </div>
            </div>

            <!-- Wishlist Button -->
            <button type="button" class="dt-icon-btn" id="dtWishlistBtn" aria-label="Saved Wishlist" onclick="if(typeof openWishlistDrawer==='function') openWishlistDrawer();">
                <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
                <span class="dt-badge" id="dtWishlistCount" style="display:none;">0</span>
            </button>

            <!-- Shopping Bag / Cart Button -->
            <button type="button" class="dt-icon-btn" id="dtCartBtn" aria-label="Shopping Cart" onclick="if(typeof openCartDrawer==='function') openCartDrawer();">
                <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                <span class="dt-badge" id="dtCartCount" style="display:none;">0</span>
            </button>
        </div>
    </div>

    <!-- Mobile Full-Header Search Bar Overlay -->
    <div class="dt-mobile-search-bar" id="dtMobileSearchBar">
        <div class="dt-mobile-search-inner">
            <input
                type="text"
                class="dt-mobile-search-input"
                id="dtMobileSearchInput"
                placeholder="Search sarees, kurtis, lehengas..."
                autocomplete="off"
                aria-label="Search"
            />
            <button type="button" class="dt-mobile-search-clear" id="dtMobileSearchClear" aria-label="Clear Search">✕</button>
            <button type="button" class="dt-mobile-search-submit" id="dtMobileSearchSubmit" aria-label="Submit Search">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>
        </div>
        <button type="button" class="dt-mobile-search-close" id="dtMobileSearchClose" aria-label="Close Search">✕</button>
    </div>

    <!-- Attached Amazon-Style Luxury Gold Sub-Navigation Bar -->
    <?php include_once __DIR__ . '/subnav.php'; ?>

</header>
