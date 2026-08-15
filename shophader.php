<?php
/**
 * shophader.php  —  PARTIAL INCLUDE
 * Premium Shop Header component for Kalaniketan
 * Features Amazon-Style Always-Open Desktop Search Bar & Clean Full-Width Mobile Search Bar with Right Close Button
 */
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
    height: 30px;
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

.header-plus-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1.5px solid var(--soft-platinum, #E5E3DE);
    background: #FAF8F4;
    cursor: pointer;
    flex-shrink: 0;
    transition: all 0.28s cubic-bezier(0.34, 1.56, 0.64, 1);
    color: var(--dark-gold, #8A681F);
    text-decoration: none;
}
.header-plus-btn:hover {
    background: var(--dark-gold, #8A681F);
    border-color: var(--dark-gold, #8A681F);
    color: #FFFFFF;
    transform: rotate(90deg) scale(1.08);
    box-shadow: 0 4px 14px rgba(138,104,31,0.28);
}
.header-plus-btn:active {
    transform: rotate(90deg) scale(0.92);
}
.header-plus-btn svg {
    width: 19px; height: 19px;
    stroke: currentColor;
    stroke-width: 2.4;
    fill: none;
    transition: stroke 0.2s ease;
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

/* ── Mobile Full-Header Search Bar Overlay (Takes 100% Header Width) ── */
.mobile-full-search-bar {
    display: none;
    align-items: center;
    width: 100%;
    height: clamp(44px, 12vw, 52px);
    padding: 0 clamp(6px, 2vw, 14px);
    gap: clamp(6px, 2vw, 10px);
    background: #FFFFFF;
    box-sizing: border-box;
    animation: mobileSearchFadeIn 0.22s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes mobileSearchFadeIn {
    from { opacity: 0; transform: translateY(-4px); }
    to { opacity: 1; transform: translateY(0); }
}

.shop-header.mobile-search-active .header-normal-view {
    display: none !important;
}
.shop-header.mobile-search-active .mobile-full-search-bar {
    display: flex !important;
}

.mobile-search-input-wrap {
    flex: 1;
    position: relative;
    height: clamp(32px, 9vw, 38px);
    display: flex;
    align-items: center;
    background: #FAF8F4;
    border: 1.5px solid var(--dark-gold, #8A681F);
    border-radius: 20px;
    padding: 0 clamp(8px, 2.5vw, 14px);
    box-shadow: 0 1px 6px rgba(138,104,31,0.08);
    transition: all 0.2s ease;
}
.mobile-search-input-wrap:focus-within {
    border-color: var(--deep-gold, #6F5218);
    box-shadow: 0 0 0 2.5px rgba(138,104,31,0.2);
    background: #FFFFFF;
}

.mobile-search-submit-icon-btn {
    background: none;
    border: none;
    padding: 0;
    margin-left: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: var(--dark-gold, #8A681F);
    flex-shrink: 0;
    transition: transform 0.15s ease, color 0.15s ease;
}
.mobile-search-submit-icon-btn:hover {
    color: var(--deep-gold, #6F5218);
    transform: scale(1.1);
}
.mobile-search-submit-icon-btn svg {
    width: clamp(14px, 4vw, 17px);
    height: clamp(14px, 4vw, 17px);
    stroke: currentColor;
    stroke-width: 2.2;
    fill: none;
}

.mobile-search-input-field {
    width: 100%; height: 100%;
    border: none; outline: none; background: transparent;
    font-family: var(--font-sans, 'Inter', sans-serif);
    font-size: clamp(0.72rem, 2.8vw, 0.85rem);
    color: var(--dark-text, #24211C);
}
.mobile-search-input-field::placeholder {
    color: var(--light-text, #9A9490);
    font-size: clamp(0.68rem, 2.6vw, 0.82rem);
}

.mobile-search-clear-btn {
    width: 20px; height: 20px;
    border-radius: 50%; border: none;
    background: rgba(0,0,0,0.08);
    color: var(--mid-text, #5A5348);
    display: none; align-items: center; justify-content: center;
    cursor: pointer; flex-shrink: 0; margin-left: 4px;
}
.mobile-search-clear-btn:hover {
    background: var(--dark-gold, #8A681F);
    color: #FFFFFF;
}
.mobile-search-clear-btn svg {
    width: 11px; height: 11px; stroke: currentColor; fill: none; stroke-width: 2;
}

/* Right Close '✕' Button on Mobile Search Bar */
.mobile-search-close-btn {
    width: clamp(28px, 8vw, 36px);
    height: clamp(28px, 8vw, 36px);
    border-radius: 50%;
    border: 1.5px solid var(--soft-platinum, #E5E3DE);
    background: #FAF8F4;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: var(--dark-gold, #8A681F);
    flex-shrink: 0;
    transition: all 0.2s ease;
}
.mobile-search-close-btn:hover {
    background: var(--dark-gold, #8A681F);
    color: #FFFFFF;
    border-color: var(--dark-gold, #8A681F);
}
.mobile-search-close-btn svg {
    width: clamp(12px, 3.2vw, 15px);
    height: clamp(12px, 3.2vw, 15px);
    stroke: currentColor; stroke-width: 2.2; fill: none;
}

/* ── Mobile Layout & Perfectly Stable Zero-Vibration Layout (<768px) ── */
@media (max-width: 767px) {
    .shop-header {
        height: auto;
        padding: 0;
        gap: 0;
        transition: box-shadow 0.25s ease;
    }

    /* Fixed 42px Slot for both Normal View and Search Bar (Zero Reflow) */
    .header-normal-view,
    .mobile-full-search-bar {
        height: 42px;
        min-height: 42px;
        max-height: 42px;
        box-sizing: border-box;
    }

    .header-normal-view {
        padding: 0 10px;
        gap: 8px;
    }
    .header-left-group {
        gap: 8px;
    }
    .header-plus-btn {
        width: 30px;
        height: 30px;
    }
    .header-plus-btn svg {
        width: 14px;
        height: 14px;
    }
    .header-brand-name {
        font-size: 0.95rem;
    }
    .header-brand-tagline {
        font-size: 0.44rem;
        letter-spacing: 0.14em;
        margin-top: 1px;
    }
    .header-actions {
        gap: 6px;
    }
    .header-icon-btn {
        width: 32px;
        height: 32px;
    }
    .header-icon-btn svg {
        width: 16px;
        height: 16px;
    }
    .header-badge {
        min-width: 15px;
        height: 15px;
        font-size: 0.52rem;
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

    /* Open Mobile Search Bar (Matching Exact 42px Height) */
    .mobile-full-search-bar {
        padding: 0 8px;
        gap: 6px;
    }
    .mobile-search-input-wrap {
        height: 32px;
        padding: 0 10px;
    }
    .mobile-search-input-field {
        font-size: 0.78rem;
    }
    .mobile-search-submit-icon-btn svg {
        width: 14px;
        height: 14px;
    }
    .mobile-search-close-btn {
        width: 30px;
        height: 30px;
    }
    .mobile-search-close-btn svg {
        width: 13px;
        height: 13px;
    }

    /* Fixed 26px Subnav (Matching Exact Height) */
    .header-attached-subnav {
        height: 26px;
        min-height: 26px;
        max-height: 26px;
        padding: 0 8px;
        box-sizing: border-box;
    }
    .subnav-item {
        font-size: 0.62rem;
        padding: 1px 7px;
        height: 19px;
    }
    .subnav-icon {
        width: 10px;
        height: 10px;
    }
}
</style>

<header class="shop-header" id="shopHeader">

    <!-- ═══ Normal Header Bar (shown on desktop, and mobile default) ═══ -->
    <div class="header-normal-view" id="headerNormalView">
        <!-- Left: Stylish Plus Button & Brand Logo -->
        <div class="header-left-group">
            <button class="header-plus-btn" id="headerPlusBtn" aria-label="Watch Video Reels" onclick="if(typeof window.openReelsModal==='function'){window.openReelsModal(0);}">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
            </button>

            <div class="header-brand">
                <h1 class="header-brand-name">Kalaniketan</h1>
                <span class="header-brand-tagline">Ethnic Luxury</span>
            </div>
        </div>

        <!-- Center: Amazon-Style Always-Open Search Bar (Visible on Desktop) -->
        <div class="search-amazon-bar" id="searchAmazonBar">
            <div class="search-cat-dropdown-wrap">
                <select class="search-cat-select" id="searchCatSelect" aria-label="Select category">
                    <option value="All">All Categories</option>
                    <option value="Sarees">Sarees</option>
                    <option value="Kurtis">Kurtis</option>
                    <option value="Gowns">Gowns</option>
                    <option value="Lehengas">Lehengas</option>
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
                <a href="myaccount.php" class="header-account-btn" id="headerAccountBtn" aria-label="Account Access">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span id="headerAccountLabel">Account</span>
                </a>
                <div class="header-account-dropdown" id="headerAccountDropdown">
                    <a href="myaccount.php" class="ac-drop-item" id="acDropMyAccount">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span style="color:var(--dark-gold, #8A681F); font-weight:700;">My Account & Orders</span>
                    </a>
                    <a href="myaccount.php?tab=login" class="ac-drop-item" id="acDropLogin">
                        <svg viewBox="0 0 24 24"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path><polyline points="10 17 15 12 10 7"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
                        <span>Sign In / Login</span>
                    </a>
                    <a href="myaccount.php?tab=register" class="ac-drop-item" id="acDropRegister">
                        <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                        <span>Create Account</span>
                    </a>
                    <a href="myaccount.php?tab=forgot" class="ac-drop-item" id="acDropForgot">
                        <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        <span>Forgot Password</span>
                    </a>
                    <div class="ac-drop-divider" id="acDropDivider" style="display:none;"></div>
                    <a href="javascript:void(0)" class="ac-drop-item" id="acDropLogout" style="display:none; color:#D32F2F;" onclick="localStorage.removeItem('kalaniketan_user'); window.location.href='shop.php';">
                        <svg viewBox="0 0 24 24" style="stroke:#D32F2F;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <span>Log Out</span>
                    </a>
                </div>
            </div>

            <!-- Wishlist -->
            <a href="javascript:void(0)" onclick="if(typeof window.openWishlistDrawer==='function') window.openWishlistDrawer();" class="header-icon-btn" id="wishlistBtn" aria-label="Wishlist">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                <span class="header-badge" id="wishlistBadge" style="display:none;">0</span>
            </a>

            <!-- Cart -->
            <a href="javascript:void(0)" onclick="if(typeof window.openCartDrawer==='function') window.openCartDrawer();" class="header-icon-btn" id="cartBtn" aria-label="Shopping cart">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
                <span class="header-badge" id="cartBadge" style="display:none;">0</span>
            </a>
        </div>
    </div>

    <!-- ═══ Mobile Full-Header Search Bar Overlay (Clean 100% Width with Right Close Button) ═══ -->
    <div class="mobile-full-search-bar" id="mobileFullSearchBar">
        <!-- Input Box with Right Search Icon -->
        <div class="mobile-search-input-wrap">
            <input
                type="text"
                class="mobile-search-input-field"
                id="mobileSearchInput"
                placeholder="Search sarees, kurtis, lehengas..."
                autocomplete="off"
                aria-label="Search items"
            />
            <button class="mobile-search-clear-btn" id="mobileSearchClearBtn" aria-label="Clear search text">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
            <button class="mobile-search-submit-icon-btn" id="mobileSearchSubmitIconBtn" aria-label="Search">
                <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
        </div>

        <!-- Right Close '✕' Button -->
        <button class="mobile-search-close-btn" id="mobileSearchCloseBtn" aria-label="Close search">
            <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <!-- ═══ Amazon-Style Attached Sub-Navigation Bar ═══ -->
    <nav class="header-attached-subnav" id="headerAttachedSubnav" aria-label="Attached categories navigation">
        <div class="subnav-scroll-track" id="mainCatSliderTrack" role="tablist">
            <button class="subnav-item main-cat-tab active" role="tab" data-cat="All" aria-selected="true">
                <svg class="subnav-icon" viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                <span>All Categories</span>
            </button>
            <button class="subnav-item main-cat-tab" role="tab" data-cat="Sarees" aria-selected="false">Sarees</button>
            <button class="subnav-item main-cat-tab" role="tab" data-cat="Kurtis" aria-selected="false">Kurtis</button>
            <button class="subnav-item main-cat-tab" role="tab" data-cat="Gowns" aria-selected="false">Gowns</button>
            <button class="subnav-item main-cat-tab" role="tab" data-cat="Lehengas" aria-selected="false">Lehengas</button>
            <button class="subnav-item main-cat-tab" role="tab" data-cat="New Arrivals" aria-selected="false">★ New In</button>
            <button class="subnav-item subnav-reels-btn" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(0);" aria-label="Watch Video Reels">
                <span>🎥 Reels</span>
            </button>
        </div>
    </nav>

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

    /* Mobile Search Elements */
    var mobileSearchBtn    = document.getElementById('mobileSearchTriggerBtn');
    var mobileSearchClose  = document.getElementById('mobileSearchCloseBtn');
    var mobileSearchInput  = document.getElementById('mobileSearchInput');
    var mobileSearchClear  = document.getElementById('mobileSearchClearBtn');
    var mobileSearchSubmit = document.getElementById('mobileSearchSubmitIconBtn');

    function performSearch(source) {
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

        if (window.masterFilterState) {
            if (cat !== 'All') {
                window.masterFilterState.category = cat;
            }
            window.masterFilterState.searchQuery = query;

            if (typeof window.applyMasterFilters === 'function') {
                window.applyMasterFilters();
            }
        }
    }

    /* Desktop Events */
    if (searchInput) {
        searchInput.addEventListener('input', function() { performSearch('desktop'); });
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                performSearch('desktop');
                searchInput.blur();
            }
        });
    }

    if (searchCat) {
        searchCat.addEventListener('change', function() { performSearch('desktop'); });
    }

    if (searchClear) {
        searchClear.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            if (mobileSearchInput) mobileSearchInput.value = '';
            performSearch('desktop');
            if (searchInput) searchInput.focus();
        });
    }

    if (searchSubmit) {
        searchSubmit.addEventListener('click', function(e) {
            e.preventDefault();
            performSearch('desktop');
        });
    }

    /* Mobile Search Open / Close Controllers */
    var userManuallyClosedMobileSearch = false;

    if (mobileSearchBtn) {
        mobileSearchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            userManuallyClosedMobileSearch = false;
            if (header) header.classList.add('mobile-search-active');
            if (mobileSearchInput) {
                setTimeout(function() {
                    mobileSearchInput.focus();
                }, 100);
            }
        });
    }

    if (mobileSearchSubmit) {
        mobileSearchSubmit.addEventListener('click', function(e) {
            e.preventDefault();
            performSearch('mobile');
            if (mobileSearchInput) mobileSearchInput.blur();
        });
    }

    if (mobileSearchClose) {
        mobileSearchClose.addEventListener('click', function(e) {
            e.preventDefault();
            userManuallyClosedMobileSearch = true;
            if (header) header.classList.remove('mobile-search-active');
            if (mobileSearchInput) mobileSearchInput.value = '';
            if (searchInput) searchInput.value = '';
            performSearch('mobile');
        });
    }

    if (mobileSearchInput) {
        mobileSearchInput.addEventListener('input', function() { performSearch('mobile'); });
        mobileSearchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                performSearch('mobile');
                mobileSearchInput.blur();
            } else if (e.key === 'Escape') {
                userManuallyClosedMobileSearch = true;
                if (header) header.classList.remove('mobile-search-active');
            }
        });
    }

    if (mobileSearchClear) {
        mobileSearchClear.addEventListener('click', function() {
            if (mobileSearchInput) {
                mobileSearchInput.value = '';
                mobileSearchInput.focus();
            }
            if (searchInput) searchInput.value = '';
            performSearch('mobile');
        });
    }

    /* Sync Desktop Account Button with Logged In User State */
    function syncHeaderAccountState() {
        var userRaw = localStorage.getItem('kalaniketan_user');
        var label = document.getElementById('headerAccountLabel');
        var dropLogin = document.getElementById('acDropLogin');
        var dropRegister = document.getElementById('acDropRegister');
        var dropForgot = document.getElementById('acDropForgot');
        var dropDivider = document.getElementById('acDropDivider');
        var dropLogout = document.getElementById('acDropLogout');

        if (userRaw && label) {
            var user = JSON.parse(userRaw);
            var firstName = (user.name || 'Member').split(' ')[0];
            label.textContent = firstName;
            if (dropLogin) dropLogin.style.display = 'none';
            if (dropRegister) dropRegister.style.display = 'none';
            if (dropForgot) dropForgot.style.display = 'none';
            if (dropDivider) dropDivider.style.display = 'block';
            if (dropLogout) dropLogout.style.display = 'flex';
        } else if (label) {
            label.textContent = 'Account';
            if (dropLogin) dropLogin.style.display = 'flex';
            if (dropRegister) dropRegister.style.display = 'flex';
            if (dropForgot) dropForgot.style.display = 'flex';
            if (dropDivider) dropDivider.style.display = 'none';
            if (dropLogout) dropLogout.style.display = 'none';
        }
    }

    /* Scroll Header Height Auto-Compress & Auto-Open Search Bar Engine */
    var isShopHeaderScrolled = false;
    var scrollTicking = false;

    window.addEventListener('scroll', function() {
        if (!scrollTicking) {
            window.requestAnimationFrame(function() {
                var sy = window.scrollY || window.pageYOffset || 0;
                if (!header) {
                    scrollTicking = false;
                    return;
                }
                var isMobile = window.innerWidth <= 767;

                if (sy > 45) {
                    if (!isShopHeaderScrolled) {
                        isShopHeaderScrolled = true;
                        header.classList.add('scrolled');
                    }
                    if (isMobile && !userManuallyClosedMobileSearch && !header.classList.contains('mobile-search-active')) {
                        header.classList.add('mobile-search-active');
                    }
                } else if (sy < 15) {
                    if (isShopHeaderScrolled) {
                        isShopHeaderScrolled = false;
                        header.classList.remove('scrolled');
                    }
                    userManuallyClosedMobileSearch = false;
                    if (isMobile && (!mobileSearchInput || !mobileSearchInput.value.trim())) {
                        header.classList.remove('mobile-search-active');
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
