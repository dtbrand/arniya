<?php
/**
 * adminheader.php — Luxury Top Header with Shop-Style Clean Desktop & Full-Width Mobile Search Bar
 * DT Brand's & Jai Hanuman Tex
 */
?>
<header class="adm-header" id="admHeaderMain">
    <!-- ══ Normal Header View (Desktop & Mobile Default) ══ -->
    <div class="adm-header-normal-view">
        <div class="adm-header-left">
            <!-- Mobile Toggle Hamburger Button -->
            <button type="button" class="adm-mobile-menu-btn" id="admMobileMenuBtn" title="Toggle Navigation Menu">
                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2.4" fill="none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>

            <!-- Mobile Brand Logo Link -->
            <a href="/Frontend/Admin/admin.php" class="adm-mobile-brand-link" title="DT Brand's Admin CRM">
                <img src="/Shared/Asset/images/logo.png" onerror="this.src='/Frontend/Shop/Asset/images/logo.png';" alt="DT Brand's" class="adm-mobile-logo-img">
                <span class="adm-mobile-brand-title">DT Brand's</span>
            </a>

            <!-- ── Clean Luxury Search Bar with Live Results Dropdown (Desktop) ── -->
            <div class="adm-header-search-container" id="admHeaderSearchContainer">
                <div class="adm-search-amazon-bar" id="admDesktopSearchBox">
                    <svg class="adm-search-icon-left" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.3">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>

                    <div class="adm-search-input-wrap">
                        <input type="text" id="admGlobalSearch" class="adm-search-input-amazon" placeholder="Search orders, sarees, customers, SKUs (e.g. KLN-SR-111)..." autocomplete="off">
                        <button type="button" id="admGlobalSearchClear" class="adm-search-clear-btn" title="Clear Search">✕</button>
                    </div>

                    <button type="button" class="adm-search-submit-btn" id="admGlobalSearchSubmitBtn" aria-label="Search" onclick="if(typeof window.executeGlobalSearch==='function') window.executeGlobalSearch(document.getElementById('admGlobalSearch').value)">
                        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </button>
                </div>

                <!-- Next-Level Live Search Dropdown Popup List -->
                <div class="adm-live-search-dropdown" id="admGlobalSearchResults"></div>
            </div>
        </div>

        <div class="adm-header-right">
            <!-- Mobile Search Trigger Icon Button (Visible on <= 1024px) -->
            <button type="button" class="adm-mobile-search-trigger-btn" id="admMobileSearchTriggerBtn" onclick="window.openAdmMobileSearch()" title="Search Admin CRM">
                <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2.3" fill="none"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>

            <!-- Live WhatsApp CRM Status Indicator -->
            <div class="adm-live-wa-pill" title="WhatsApp Business Cloud Gateway Connected">
                <span class="adm-pulse-dot"></span>
                <span class="adm-wa-text">WhatsApp Live</span>
            </div>

            <!-- Notification Bell -->
            <button type="button" class="adm-hdr-btn" title="Notifications" onclick="if(typeof window.showToast==='function') window.showToast('🔔 3 new wholesale orders received today!')">
                <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2.2" fill="none"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                <span class="adm-hdr-badge">3</span>
            </button>

            <!-- Fast Action: + Add Product -->
            <a href="/Frontend/Admin/products/add.php" class="adm-btn-primary" title="Add Product">
                <svg viewBox="0 0 24 24" width="13" height="13" stroke="#181512" stroke-width="2.8" fill="none"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span class="adm-btn-text">Add Product</span>
            </a>

            <!-- Fast Action: Broadcast -->
            <button type="button" class="adm-btn-secondary" onclick="if(typeof switchAdmTab==='function') switchAdmTab('whatsapp'); else window.location.href='/Frontend/Admin/whatsapp/';" title="Broadcast">
                <svg viewBox="0 0 24 24" width="13" height="13" stroke="currentColor" stroke-width="2.2" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                <span>Broadcast</span>
            </button>

            <!-- Admin Profile Pill -->
            <div class="adm-hdr-profile" onclick="if(typeof switchAdmTab==='function') switchAdmTab('settings');" title="Super Admin">
                <img src="/Shared/Asset/images/profile.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" alt="Gautam Sethi" class="adm-hdr-avatar">
                <div class="adm-hdr-user-text">
                    <span class="adm-hdr-name">Gautam Sethi</span>
                    <span class="adm-hdr-title">Super Admin</span>
                </div>
                <svg viewBox="0 0 24 24" width="12" height="12" stroke="currentColor" stroke-width="2.2" fill="none" class="adm-hdr-caret"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
        </div>
    </div>

    <!-- ══ Mobile Full-Header Search Bar Overlay (Exact Shop Page Header Style) ══ -->
    <div class="adm-mobile-full-search-bar" id="admMobileFullSearchBar">
        <div class="adm-mobile-search-input-wrap">
            <button type="button" class="adm-mobile-search-submit-icon-btn" onclick="if(typeof window.executeGlobalSearch==='function') window.executeGlobalSearch(document.getElementById('admMobileGlobalSearch').value)">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>
            <input type="text" id="admMobileGlobalSearch" class="adm-mobile-search-input-field" placeholder="Search orders, sarees, customers, SKUs..." autocomplete="off">
            <button type="button" id="admMobileGlobalSearchClear" class="adm-mobile-search-clear-btn" title="Clear Search">✕</button>
        </div>
        <button type="button" class="adm-mobile-search-close-btn" onclick="window.closeAdmMobileSearch()" title="Close Search">
            <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
        <!-- Mobile Live Search Dropdown Popup List -->
        <div class="adm-mobile-live-search-dropdown" id="admMobileGlobalSearchResults"></div>
    </div>
</header>

