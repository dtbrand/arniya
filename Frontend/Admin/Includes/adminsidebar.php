<?php
/**
 * adminsidebar.php — Luxury Wholesaler-Style Admin Sidebar Navigation
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ══ Mobile Sidebar Backdrop ══ -->
<div class="adm-sidebar-backdrop" id="admSidebarBackdrop" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); z-index:999; backdrop-filter:blur(3px);"></div>

<!-- ══ Left Sidebar Component ══ -->
<aside class="adm-sidebar" id="admSidebar">
    <!-- Brand Logo Box -->
    <div class="adm-sidebar-brand">
        <a href="/Frontend/Admin/admin.php" class="adm-brand-link">
            <img src="/Shared/Asset/images/logo.png" onerror="this.src='/Frontend/Shop/Asset/images/logo.png';" alt="DT Brand's" class="adm-brand-logo-img">
            <div class="adm-brand-meta">
                <span class="adm-brand-name">DT Brand's</span>
                <span class="adm-brand-badge">Admin CRM</span>
            </div>
        </a>
        <button class="adm-sidebar-toggle-btn" id="admSidebarToggleBtn" title="Toggle Sidebar Collapse">
            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2.2" fill="none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
    </div>

    <!-- Scrollable Navigation Area -->
    <div class="adm-sidebar-scroll">
        <!-- Wholesaler-Style VIP Super Admin User Card -->
        <div class="adm-side-user-card" onclick="switchAdmTab('settings')" title="Super Admin Profile">
            <img src="/Shared/Asset/images/profile.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" alt="Super Admin" class="adm-side-user-avatar">
            <div class="adm-side-user-details">
                <div class="adm-side-user-name">Gautam Sethi</div>
                <div class="adm-side-user-tag">
                    <span>★ Master Admin</span>
                </div>
            </div>
            <span class="adm-side-user-tier">Tier 1</span>
        </div>

        <!-- Section 1: MENU -->
        <div class="adm-nav-group">
            <div class="adm-nav-heading">MENU</div>
            <ul class="adm-nav-list">
                <li>
                    <a class="adm-nav-item active" id="navItem-overview" onclick="switchAdmTab('overview')">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span class="adm-nav-label">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="adm-nav-item" id="navItem-orders" onclick="switchAdmTab('orders')">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        <span class="adm-nav-label">Orders</span>
                        <span class="adm-nav-badge gold" id="admNavOrdersBadge">5 New</span>
                    </a>
                </li>
                <li>
                    <a class="adm-nav-item" id="navItem-products" onclick="switchAdmTab('products')">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <span class="adm-nav-label">Catalog</span>
                        <span class="adm-nav-badge">160+</span>
                    </a>
                </li>
                <li>
                    <a class="adm-nav-item" id="navItem-reports" onclick="switchAdmTab('reports')">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        <span class="adm-nav-label">Reports</span>
                        <span class="adm-nav-badge gold">NEW</span>
                    </a>
                </li>
                <li>
                    <a class="adm-nav-item" id="navItem-whatsapp" onclick="switchAdmTab('whatsapp')">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <span class="adm-nav-label">WhatsApp CRM</span>
                        <span class="adm-nav-badge green">LIVE</span>
                    </a>
                </li>
                <li>
                    <a class="adm-nav-item" id="navItem-partners" onclick="switchAdmTab('partners')">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span class="adm-nav-label">Partners Network</span>
                    </a>
                </li>
                <li>
                    <a class="adm-nav-item" id="navItem-customers" onclick="switchAdmTab('customers')">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span class="adm-nav-label">Customers</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Section 2: SETTINGS -->
        <div class="adm-nav-group">
            <div class="adm-nav-heading">SETTINGS</div>
            <ul class="adm-nav-list">
                <li>
                    <a class="adm-nav-item" id="navItem-settings" onclick="switchAdmTab('settings')">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span class="adm-nav-label">Store Profile & API</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
