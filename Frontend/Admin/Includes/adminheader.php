<?php
/**
 * adminheader.php — Luxury Top Header with Left-Aligned Search Standard & Wholesaler UI Elements
 * DT Brand's & Jai Hanuman Tex
 */
?>
<header class="adm-header">
    <div class="adm-header-left">
        <!-- Luxury Mobile Toggle Hamburger Button -->
        <button class="adm-mobile-menu-btn" id="admMobileMenuBtn" title="Toggle Navigation Menu">
            <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2.4" fill="none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>

        <!-- Mobile Brand Logo Link -->
        <a href="/Frontend/Admin/admin.php" class="adm-mobile-brand-link" title="DT Brand's Admin CRM">
            <img src="/Shared/Asset/images/logo.png" onerror="this.src='/Frontend/Shop/Asset/images/logo.png';" alt="DT Brand's" class="adm-mobile-logo-img">
            <span class="adm-mobile-brand-title">DT Brand's</span>
        </a>

        <!-- Command Search Bar (Icon strictly on the LEFT, Clear button on the RIGHT, ⌘K badge) -->
        <div class="adm-search-box">
            <svg class="adm-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" id="admGlobalSearch" class="adm-search-input" placeholder="Search orders, sarees, customers, SKUs (e.g. KLN-SR-111)..." autocomplete="off">
            <span class="adm-cmd-badge" style="position:absolute; right:32px; top:50%; transform:translateY(-50%); pointer-events:none;">⌘K</span>
            <button type="button" id="admGlobalSearchClear" class="adm-search-clear" title="Clear Search">✕</button>
        </div>
    </div>

    <div class="adm-header-right">
        <!-- Live WhatsApp CRM Status Indicator -->
        <div class="adm-live-wa-pill" title="WhatsApp Business Cloud Gateway Connected">
            <span class="adm-pulse-dot"></span>
            <span class="adm-wa-text">WhatsApp Live</span>
        </div>

        <!-- Notification Bell -->
        <button class="adm-hdr-btn" title="Notifications" onclick="if(typeof window.showToast==='function') window.showToast('🔔 3 new wholesale orders received today!')">
            <svg viewBox="0 0 24 24" width="17" height="17" stroke="currentColor" stroke-width="2.2" fill="none"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
            <span class="adm-hdr-badge">3</span>
        </button>

        <!-- Fast Action: + Add Product -->
        <a href="/Frontend/Admin/products/add.php" class="adm-btn-primary" title="Add Product">
            <svg viewBox="0 0 24 24" width="14" height="14" stroke="#181512" stroke-width="2.8" fill="none"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            <span class="adm-btn-text">+ Add Product</span>
        </a>

        <!-- Fast Action: + Broadcast (Desktop) -->
        <button class="adm-btn-secondary" onclick="if(typeof switchAdmTab==='function') switchAdmTab('whatsapp'); else window.location.href='/Frontend/Admin/whatsapp/';" title="Broadcast">
            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
            <span>Broadcast</span>
        </button>

        <!-- Admin Profile Pill -->
        <div class="adm-hdr-profile" onclick="if(typeof switchAdmTab==='function') switchAdmTab('settings');" title="Super Admin">
            <img src="/Shared/Asset/images/profile.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" alt="Gautam Sethi" class="adm-hdr-avatar">
            <div class="adm-hdr-user-text">
                <span class="adm-hdr-name">Gautam Sethi</span>
                <span class="adm-hdr-title">Super Admin</span>
            </div>
            <svg viewBox="0 0 24 24" width="13" height="13" stroke="currentColor" stroke-width="2.2" fill="none" class="adm-hdr-caret"><polyline points="6 9 12 15 18 9"></polyline></svg>
        </div>
    </div>
</header>
