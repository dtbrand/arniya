<?php
/**
 * sidebar.php — ARNIYA Modular Left Sidebar Navigation
 * 21 Modules with Collapse/Expand, Tooltips, Notification Badges & Active Highlighting
 */
if (!isset($active_nav)) {
    $active_nav = 'dashboard';
}
?>
<!-- ══ Mobile Sidebar Overlay ══ -->
<div class="adm-sidebar-overlay" id="admSidebarOverlay"></div>

<!-- ══ Left Navigation Sidebar ══ -->
<aside class="adm-sidebar" id="admSidebar">
    <!-- Brand Header -->
    <div class="adm-sidebar-brand">
        <a href="/Admin/dashboard/" class="adm-brand-link" title="ARNIYA Executive Admin">
            <div class="adm-brand-seal-mini" title="ARNIYA Command Center">AR</div>
            <div class="adm-brand-full">
                <span class="adm-brand-title">ARNIYA</span>
                <span class="adm-brand-subtitle">Executive Suite</span>
            </div>
        </a>
        <button type="button" class="adm-sidebar-toggle-btn" id="admSidebarToggleBtn" title="Collapse / Expand Sidebar (Alt + [ )">
            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2.2" fill="none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
    </div>

    <!-- Scrollable Navigation Groups -->
    <div class="adm-sidebar-scroll" id="admSidebarScroll">

        <!-- ── Category: MAIN ── -->
        <div class="adm-nav-group">
            <div class="adm-nav-heading">MAIN</div>
            <ul class="adm-nav-list">
                <li>
                    <a href="/Admin/dashboard/" class="adm-nav-item <?php echo ($active_nav === 'dashboard') ? 'active' : ''; ?>" data-title="Dashboard" id="nav-dashboard">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span class="adm-nav-label">Dashboard</span>
                        <span class="adm-nav-badge gold">Live</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ── Category: COMMERCE ── -->
        <div class="adm-nav-group">
            <div class="adm-nav-heading">COMMERCE</div>
            <ul class="adm-nav-list">
                <li>
                    <a href="/Admin/products/" class="adm-nav-item <?php echo ($active_nav === 'products') ? 'active' : ''; ?>" data-title="Products" id="nav-products">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <span class="adm-nav-label">Products</span>
                        <span class="adm-nav-badge">1,240</span>
                    </a>
                </li>
                <li>
                    <a href="/Admin/products/categories.php" class="adm-nav-item <?php echo ($active_nav === 'catalogue') ? 'active' : ''; ?>" data-title="Catalogue" id="nav-catalogue">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        <span class="adm-nav-label">Catalogue</span>
                    </a>
                </li>
                <li>
                    <a href="/Admin/orders/" class="adm-nav-item <?php echo ($active_nav === 'orders') ? 'active' : ''; ?>" data-title="Orders" id="nav-orders">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        <span class="adm-nav-label">Orders</span>
                        <span class="adm-nav-badge rose">18 New</span>
                    </a>
                </li>
                <li>
                    <a href="/Admin/customers/" class="adm-nav-item <?php echo ($active_nav === 'customers') ? 'active' : ''; ?>" data-title="Customers" id="nav-customers">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span class="adm-nav-label">Customers</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ── Category: B2B PARTNERS ── -->
        <div class="adm-nav-group">
            <div class="adm-nav-heading">B2B PARTNERS</div>
            <ul class="adm-nav-list">
                <li>
                    <a href="/Admin/resellers/" class="adm-nav-item <?php echo ($active_nav === 'resellers') ? 'active' : ''; ?>" data-title="Resellers" id="nav-resellers">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                        <span class="adm-nav-label">Resellers</span>
                        <span class="adm-nav-badge gold">5 Pending</span>
                    </a>
                </li>
                <li>
                    <a href="/Admin/retailers/" class="adm-nav-item <?php echo ($active_nav === 'retailers') ? 'active' : ''; ?>" data-title="Retailers" id="nav-retailers">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span class="adm-nav-label">Retailers</span>
                    </a>
                </li>
                <li>
                    <a href="/Admin/wholesalers/" class="adm-nav-item <?php echo ($active_nav === 'wholesalers') ? 'active' : ''; ?>" data-title="Wholesalers" id="nav-wholesalers">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span class="adm-nav-label">Wholesalers</span>
                        <span class="adm-nav-badge green">Tier 1</span>
                    </a>
                </li>
                <li>
                    <a href="/Admin/pricing/" class="adm-nav-item <?php echo ($active_nav === 'pricing') ? 'active' : ''; ?>" data-title="Pricing" id="nav-pricing">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        <span class="adm-nav-label">Pricing & Tiers</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ── Category: LOGISTICS & INVENTORY ── -->
        <div class="adm-nav-group">
            <div class="adm-nav-heading">LOGISTICS & STOCK</div>
            <ul class="adm-nav-list">
                <li>
                    <a href="/Admin/inventory/" class="adm-nav-item <?php echo ($active_nav === 'inventory') ? 'active' : ''; ?>" data-title="Inventory" id="nav-inventory">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                        <span class="adm-nav-label">Inventory</span>
                        <span class="adm-nav-badge amber">3 Low</span>
                    </a>
                </li>
                <li>
                    <a href="/Admin/shipping/" class="adm-nav-item <?php echo ($active_nav === 'shipping') ? 'active' : ''; ?>" data-title="Shipping" id="nav-shipping">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span class="adm-nav-label">Shipping</span>
                    </a>
                </li>
                <li>
                    <a href="/Admin/payments/" class="adm-nav-item <?php echo ($active_nav === 'payments') ? 'active' : ''; ?>" data-title="Payments" id="nav-payments">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        <span class="adm-nav-label">Payments</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ── Category: MARKETING & CONTENT ── -->
        <div class="adm-nav-group">
            <div class="adm-nav-heading">MARKETING & CMS</div>
            <ul class="adm-nav-list">
                <li>
                    <a href="/Admin/marketing/" class="adm-nav-item <?php echo ($active_nav === 'marketing') ? 'active' : ''; ?>" data-title="Marketing" id="nav-marketing">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        <span class="adm-nav-label">Marketing & Deals</span>
                    </a>
                </li>
                <li>
                    <a href="/Admin/reviews/" class="adm-nav-item <?php echo ($active_nav === 'reviews') ? 'active' : ''; ?>" data-title="Reviews" id="nav-reviews">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <span class="adm-nav-label">Reviews</span>
                        <span class="adm-nav-badge gold">4.9 ★</span>
                    </a>
                </li>
                <li>
                    <a href="/Admin/cms/" class="adm-nav-item <?php echo ($active_nav === 'cms') ? 'active' : ''; ?>" data-title="CMS" id="nav-cms">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span class="adm-nav-label">CMS Pages</span>
                    </a>
                </li>
                <li>
                    <a href="/Admin/media/" class="adm-nav-item <?php echo ($active_nav === 'media') ? 'active' : ''; ?>" data-title="Media" id="nav-media">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        <span class="adm-nav-label">Media Library</span>
                    </a>
                </li>
                <li>
                    <a href="/Admin/notifications/" class="adm-nav-item <?php echo ($active_nav === 'notifications') ? 'active' : ''; ?>" data-title="Notifications" id="nav-notifications">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <span class="adm-nav-label">Notifications & SMS</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ── Category: INTELLIGENCE & SYSTEM ── -->
        <div class="adm-nav-group">
            <div class="adm-nav-heading">SYSTEM & INTEL</div>
            <ul class="adm-nav-list">
                <li>
                    <a href="/Admin/reports/" class="adm-nav-item <?php echo ($active_nav === 'reports') ? 'active' : ''; ?>" data-title="Reports" id="nav-reports">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        <span class="adm-nav-label">Reports & GST</span>
                    </a>
                </li>
                <li>
                    <a href="/Admin/users/" class="adm-nav-item <?php echo ($active_nav === 'users') ? 'active' : ''; ?>" data-title="Users & Roles" id="nav-users">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span class="adm-nav-label">Users & Roles</span>
                    </a>
                </li>
                <li>
                    <a href="/Admin/settings/" class="adm-nav-item <?php echo ($active_nav === 'settings') ? 'active' : ''; ?>" data-title="Settings" id="nav-settings">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span class="adm-nav-label">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="/Admin/system/" class="adm-nav-item <?php echo ($active_nav === 'system') ? 'active' : ''; ?>" data-title="System Health" id="nav-system">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
                        <span class="adm-nav-label">System Health</span>
                        <span class="adm-nav-badge green">OK</span>
                    </a>
                </li>
            </ul>
        </div>

    </div>
</aside>
