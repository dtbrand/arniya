<?php
/**
 * topbar.php — ARNIYA Admin Top Navigation Bar
 * Global search, date presets, quick action center, notifications, and user profile
 */
?>
<header class="adm-topbar" id="admTopbar">
    <div class="adm-topbar-left">
        <!-- Mobile Hamburger Toggle -->
        <button type="button" class="adm-mob-toggle-btn" id="admMobToggleBtn" title="Toggle Navigation">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2.2" fill="none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>

        <!-- Command Search Bar (Strict Left Icon Placement Standard) -->
        <div class="adm-search-wrap" id="admSearchWrap">
            <svg class="adm-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" id="admGlobalSearchInput" class="adm-search-input" placeholder="Search orders, sarees, customers, SKUs (e.g. KLN-SR-111)..." autocomplete="off">
            <kbd class="adm-cmd-shortcut" title="Press ⌘K or Ctrl+K to search">⌘K</kbd>
            <button type="button" id="admSearchClearBtn" class="adm-search-clear" title="Clear Search">✕</button>
        </div>
    </div>

    <div class="adm-topbar-right">
        <!-- Live Cloud Sync Pulse -->
        <div class="adm-live-badge" title="Live WebSocket / API Sync Connected">
            <span class="adm-pulse-dot"></span>
            <span>Live Sync</span>
        </div>

        <!-- Quick Action Trigger -->
        <div class="adm-dropdown-wrap">
            <button type="button" class="adm-topbar-btn adm-quick-btn" id="admQuickActionBtn" title="Quick Actions">
                <svg viewBox="0 0 24 24" width="15" height="15" stroke="currentColor" stroke-width="2.5" fill="none"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Quick Action</span>
            </button>
            <div class="adm-dropdown-menu" id="admQuickActionMenu">
                <div class="adm-dropdown-header">QUICK CREATION</div>
                <a href="/Admin/products/add.php" class="adm-dropdown-item">🛍️ Add Product</a>
                <a href="/Admin/orders/add.php" class="adm-dropdown-item">📦 Create Order</a>
                <a href="/Admin/products/categories.php" class="adm-dropdown-item">📁 Add Category</a>
                <a href="/Admin/pricing/coupons.php" class="adm-dropdown-item">🎟️ Add Coupon</a>
                <a href="/Admin/notifications/" class="adm-dropdown-item">🔔 Send Broadcast</a>
                <a href="/Admin/inventory/adjustment.php" class="adm-dropdown-item">⚖️ Stock Adjustment</a>
            </div>
        </div>

        <!-- Notification Bell -->
        <button type="button" class="adm-icon-btn" id="admNotifBtn" title="3 New Notifications" onclick="window.showToast && window.showToast('🔔 3 new wholesale B2B consignments received today!')">
            <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
            <span class="adm-icon-badge">3</span>
        </button>

        <!-- Messages / WhatsApp CRM -->
        <a href="/Admin/notifications/" class="adm-icon-btn" title="WhatsApp CRM Messages">
            <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
            <span class="adm-icon-badge green">14</span>
        </a>

        <!-- Help Documentation -->
        <a href="/Admin/cms/faq.php" class="adm-icon-btn" title="Knowledge Base & Documentation">
            <svg viewBox="0 0 24 24" width="17" height="17" stroke="currentColor" stroke-width="2" fill="none"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
        </a>

        <!-- Admin Profile Pill & Dropdown -->
        <div class="adm-profile-wrap">
            <div class="adm-profile-pill" id="admProfileTrigger" title="Super Admin Account">
                <img src="/Shared/Asset/images/profile.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" alt="Gautam Sethi" class="adm-profile-avatar">
                <div class="adm-profile-info">
                    <span class="adm-profile-name">Gautam Sethi</span>
                    <span class="adm-profile-role">Super Admin</span>
                </div>
                <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
            <div class="adm-profile-menu" id="admProfileMenu">
                <div class="adm-profile-menu-head">
                    <div class="adm-pm-name">Gautam Sethi</div>
                    <div class="adm-pm-email">gautam@jaihanumantex.in</div>
                    <span class="adm-pm-badge">Master Console • Tier 1</span>
                </div>
                <div class="adm-pm-divider"></div>
                <a href="/Admin/settings/company.php" class="adm-pm-item">🏢 Store Profile</a>
                <a href="/Admin/users/roles.php" class="adm-pm-item">🛡️ Roles & Permissions</a>
                <a href="/Admin/system/health.php" class="adm-pm-item">⚡ System Health</a>
                <a href="/Admin/settings/" class="adm-pm-item">⚙️ General Settings</a>
                <div class="adm-pm-divider"></div>
                <a href="/Frontend/Shop/shop.php" target="_blank" class="adm-pm-item">🛍️ View B2C Shop ↗</a>
                <a href="/Frontend/Wholesale/wholesale.php" target="_blank" class="adm-pm-item">📦 Wholesale Portal ↗</a>
                <a href="/Frontend/Reseller/reseller.php" target="_blank" class="adm-pm-item">🤝 Reseller Hub ↗</a>
                <div class="adm-pm-divider"></div>
                <a href="/Frontend/Admin/adminlogin.php?action=logout" class="adm-pm-item danger">🚪 Sign Out</a>
            </div>
        </div>
    </div>
</header>
