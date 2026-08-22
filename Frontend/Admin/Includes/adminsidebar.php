<?php
/**
 * adminsidebar.php — Luxury Wholesaler-Style Admin Sidebar Navigation with Real SVG Icons
 * DT Brand's & Jai Hanuman Tex
 */
$req_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';

if (isset($active_nav) && !empty($active_nav)) {
    $current_nav = $active_nav;
} elseif (strpos($req_uri, '/catalogue/') !== false) {
    $current_nav = 'catalogue';
} elseif (strpos($req_uri, '/products/') !== false) {
    $current_nav = 'products';
} elseif (strpos($req_uri, '/orders/') !== false) {
    $current_nav = 'orders';
} elseif (strpos($req_uri, '/pricing/') !== false) {
    $current_nav = 'pricing';
} elseif (strpos($req_uri, '/reviews/') !== false) {
    $current_nav = 'reviews';
} elseif (strpos($req_uri, '/wholesalers/') !== false) {
    $current_nav = 'wholesalers';
} elseif (strpos($req_uri, '/resellers/') !== false) {
    $current_nav = 'resellers';
} elseif (strpos($req_uri, '/retailers/') !== false) {
    $current_nav = 'retailers';
} elseif (strpos($req_uri, '/customers/') !== false) {
    $current_nav = 'customers';
} elseif (strpos($req_uri, '/inventory/') !== false) {
    $current_nav = 'inventory';
} elseif (strpos($req_uri, '/shipping/') !== false) {
    $current_nav = 'shipping';
} elseif (strpos($req_uri, '/payments/') !== false) {
    $current_nav = 'payments';
} elseif (strpos($req_uri, '/marketing/') !== false) {
    $current_nav = 'marketing';
} elseif (strpos($req_uri, '/cms/') !== false) {
    $current_nav = 'cms';
} elseif (strpos($req_uri, '/media/') !== false) {
    $current_nav = 'media';
} elseif (strpos($req_uri, '/notifications/') !== false) {
    $current_nav = 'notifications';
} elseif (strpos($req_uri, '/reports/') !== false) {
    $current_nav = 'reports';
} elseif (strpos($req_uri, '/users/') !== false) {
    $current_nav = 'users';
} elseif (strpos($req_uri, '/settings/') !== false) {
    $current_nav = 'settings';
} elseif (strpos($req_uri, '/system/') !== false) {
    $current_nav = 'system';
} elseif (strpos($req_uri, '/whatsapp/') !== false) {
    $current_nav = 'whatsapp';
} else {
    $current_nav = 'dashboard';
}

if (isset($active_subnav) && !empty($active_subnav)) {
    $current_subnav = $active_subnav;
} else {
    $current_subnav = '';
}
?>
<!-- ══ Mobile Sidebar Backdrop ══ -->
<div class="adm-sidebar-backdrop" id="admSidebarBackdrop" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); z-index:99998; backdrop-filter:blur(3px);"></div>

<!-- ══ Left Sidebar Component ══ -->
<aside class="adm-sidebar" id="admSidebar">
    <!-- Brand Logo Box -->
    <div class="adm-sidebar-brand">
        <a href="/Frontend/Admin/admin.php" class="adm-brand-link" title="DT Brand's Executive Admin">
            <img src="/Shared/Asset/images/logo.png" onerror="this.src='/Frontend/Shop/Asset/images/logo.png';" alt="DT Brand's" class="adm-brand-logo-img">
            <div class="adm-brand-seal-mini" title="DT Brand's Admin">DT</div>
            <div class="adm-brand-meta">
                <span class="adm-brand-name">DT Brand's</span>
                <span class="adm-brand-badge">Admin CRM</span>
            </div>
        </a>
        <button type="button" class="adm-sidebar-toggle-btn" id="admSidebarToggleBtn" onclick="if(window.innerWidth <= 1024){ window.closeAdmMobileSidebar(); } else { if(typeof window.toggleSidebarCollapsed==='function') window.toggleSidebarCollapsed(); }" title="Toggle Navigation">
            <svg class="adm-icon-hamburger" viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2.2" fill="none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            <svg class="adm-icon-close" viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2.4" fill="none" style="display:none;"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <!-- Scrollable Navigation Area -->
    <div class="adm-sidebar-scroll">
        <!-- ── 1. MAIN ── -->
        <div class="adm-nav-group">
            <div class="adm-nav-heading">MAIN</div>
            <ul class="adm-nav-list">
                <li>
                    <a href="/Frontend/Admin/admin.php" class="adm-nav-item <?php echo $current_nav === 'dashboard' ? 'active' : ''; ?>" id="navItem-overview" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-overview')) { switchAdmTab('overview'); return false; }" data-title="Dashboard">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span class="adm-nav-label">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/Frontend/Admin/whatsapp/" class="adm-nav-item <?php echo $current_nav === 'whatsapp' ? 'active' : ''; ?>" id="navItem-whatsapp" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-whatsapp')) { switchAdmTab('whatsapp'); return false; }" data-title="WhatsApp CRM">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <span class="adm-nav-label">WhatsApp CRM</span>
                        <span class="adm-nav-badge green">LIVE</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ── 2. COMMERCE ── -->
        <div class="adm-nav-group">
            <div class="adm-nav-heading">COMMERCE</div>
            <ul class="adm-nav-list">
                <!-- PRODUCTS WITH REAL SVG SUBMENU -->
                <li class="adm-nav-has-sub <?php echo $current_nav === 'products' ? 'open' : ''; ?>">
                    <a href="/Frontend/Admin/products/" class="adm-nav-item <?php echo $current_nav === 'products' ? 'active' : ''; ?>" id="navItem-products" data-title="Products (1,240 SKUs)">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <span class="adm-nav-label">Products</span>
                        <span class="adm-nav-badge">1,240</span>
                        <span class="adm-nav-arrow-wrap" onclick="event.preventDefault(); event.stopPropagation(); toggleSidebarSubmenu(this);" title="Toggle submenu">
                            <svg class="adm-nav-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </span>
                    </a>
                    <!-- SUBMENU ITEMS LIST WITH CRISP SVG ICONS -->
                    <ul class="adm-nav-submenu <?php echo $current_nav === 'products' ? 'open' : ''; ?>" id="admSubmenu-products">
                        <li>
                            <a href="/Frontend/Admin/products/" class="adm-nav-subitem <?php echo ($current_nav === 'products' && empty($current_subnav)) ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                <span>All Products</span>
                                <span class="adm-nav-badge">1,240</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/products/add.php" class="adm-nav-subitem <?php echo $current_subnav === 'add' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                <span>Add Product</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/products/categories/" class="adm-nav-subitem <?php echo $current_subnav === 'categories' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                                <span>Categories</span>
                                <span class="adm-nav-badge">16</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/products/brands/" class="adm-nav-subitem <?php echo $current_subnav === 'brands' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><circle cx="7.5" cy="7.5" r="1.5"></circle></svg>
                                <span>Brands</span>
                                <span class="adm-nav-badge">4</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/products/attributes/" class="adm-nav-subitem <?php echo $current_subnav === 'attributes' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path></svg>
                                <span>Attributes</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/products/variants/" class="adm-nav-subitem <?php echo $current_subnav === 'variants' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="16 3 21 3 21 8"></polyline><line x1="4" y1="20" x2="21" y2="3"></line><polyline points="21 16 21 21 16 21"></polyline><line x1="15" y1="15" x2="21" y2="21"></line></svg>
                                <span>Variants Matrix</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/products/media/" class="adm-nav-subitem <?php echo $current_subnav === 'media' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                <span>Media Gallery</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/products/featured/" class="adm-nav-subitem <?php echo $current_subnav === 'featured' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <span>Featured</span>
                                <span class="adm-nav-badge">48</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/products/best-sellers/" class="adm-nav-subitem <?php echo $current_subnav === 'best-sellers' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
                                <span>Best Sellers</span>
                                <span class="adm-nav-badge">32</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/products/new-arrivals/" class="adm-nav-subitem <?php echo $current_subnav === 'new-arrivals' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15 8 21 9 17 14 18 20 12 17 6 20 7 14 3 9 9 8 12 2"></polygon></svg>
                                <span>New Arrivals</span>
                                <span class="adm-nav-badge">64</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/products/reviews/" class="adm-nav-subitem <?php echo $current_subnav === 'reviews' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                <span>Reviews Moderation</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/products/imports/" class="adm-nav-subitem <?php echo $current_subnav === 'imports' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                <span>Import Wizard</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/products/exports/" class="adm-nav-subitem <?php echo $current_subnav === 'exports' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                <span>Export Studio</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- CATALOGUE WITH REAL SVG SUBMENU -->
                <li class="adm-nav-has-sub <?php echo $current_nav === 'catalogue' ? 'open' : ''; ?>">
                    <a href="/Frontend/Admin/catalogue/" class="adm-nav-item <?php echo $current_nav === 'catalogue' ? 'active' : ''; ?>" id="navItem-catalogue" data-title="Catalogue (16 Categories)">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        <span class="adm-nav-label">Catalogue</span>
                        <span class="adm-nav-badge gold">16 Cats</span>
                        <span class="adm-nav-arrow-wrap" onclick="event.preventDefault(); event.stopPropagation(); toggleSidebarSubmenu(this);" title="Toggle submenu">
                            <svg class="adm-nav-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </span>
                    </a>
                    <ul class="adm-nav-submenu <?php echo $current_nav === 'catalogue' ? 'open' : ''; ?>" id="admSubmenu-catalogue">
                        <li>
                            <a href="/Frontend/Admin/catalogue/" class="adm-nav-subitem <?php echo ($current_nav === 'catalogue' && $current_subnav === 'overview') ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                <span>Overview Hub</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/catalogue/hierarchy.php" class="adm-nav-subitem <?php echo $current_subnav === 'hierarchy' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="6" y1="3" x2="6" y2="15"></line><circle cx="18" cy="6" r="3"></circle><circle cx="6" cy="18" r="3"></circle><path d="M18 9a9 9 0 0 1-9 9"></path></svg>
                                <span>Hierarchy Tree</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/catalogue/categories/" class="adm-nav-subitem <?php echo $current_subnav === 'categories' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                                <span>Categories</span>
                                <span class="adm-nav-badge">16</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/catalogue/subcategories/" class="adm-nav-subitem <?php echo $current_subnav === 'subcategories' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                                <span>Subcategories</span>
                                <span class="adm-nav-badge">42</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/catalogue/collections/" class="adm-nav-subitem <?php echo $current_subnav === 'collections' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <span>Collections</span>
                                <span class="adm-nav-badge">8</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/catalogue/featured.php" class="adm-nav-subitem <?php echo $current_subnav === 'featured' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15 8 21 9 17 14 18 20 12 17 6 20 7 14 3 9 9 8 12 2"></polygon></svg>
                                <span>Featured Sections</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/catalogue/banners/" class="adm-nav-subitem <?php echo $current_subnav === 'banners' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                <span>Banners</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/catalogue/navigation.php" class="adm-nav-subitem <?php echo $current_subnav === 'navigation' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                <span>Navigation Builder</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/catalogue/merchandising.php" class="adm-nav-subitem <?php echo $current_subnav === 'merchandising' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                                <span>Merchandising</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/catalogue/seo/" class="adm-nav-subitem <?php echo $current_subnav === 'seo' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <span>SEO Suite</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- ORDERS WITH REAL SVG SUBMENU -->
                <li class="adm-nav-has-sub <?php echo $current_nav === 'orders' ? 'open' : ''; ?>">
                    <a href="/Frontend/Admin/orders/" class="adm-nav-item <?php echo $current_nav === 'orders' ? 'active' : ''; ?>" id="navItem-orders" data-title="Orders (1,624)">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        <span class="adm-nav-label">Orders</span>
                        <span class="adm-nav-badge gold" id="admNavOrdersBadge">1,624</span>
                        <span class="adm-nav-arrow-wrap" onclick="event.preventDefault(); event.stopPropagation(); toggleSidebarSubmenu(this);" title="Toggle submenu">
                            <svg class="adm-nav-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </span>
                    </a>
                    <ul class="adm-nav-submenu <?php echo $current_nav === 'orders' ? 'open' : ''; ?>" id="admSubmenu-orders">
                        <li>
                            <a href="/Frontend/Admin/orders/index.php" class="adm-nav-subitem <?php echo ($current_nav === 'orders' && ($current_subnav === 'all' || empty($current_subnav))) ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                <span>All Orders</span>
                                <span class="adm-nav-badge">1,624</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/orders/pending.php" class="adm-nav-subitem <?php echo $current_subnav === 'pending' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                <span>Pending</span>
                                <span class="adm-nav-badge">18</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/orders/processing.php" class="adm-nav-subitem <?php echo $current_subnav === 'processing' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                                <span>Processing</span>
                                <span class="adm-nav-badge">24</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/orders/shipped.php" class="adm-nav-subitem <?php echo $current_subnav === 'shipped' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                <span>In Transit / Shipped</span>
                                <span class="adm-nav-badge">84</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/orders/delivered.php" class="adm-nav-subitem <?php echo $current_subnav === 'delivered' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20 6L9 17l-5-5"></path></svg>
                                <span>Delivered</span>
                                <span class="adm-nav-badge">1,542</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/orders/returns.php" class="adm-nav-subitem <?php echo $current_subnav === 'returns' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                                <span>RMA Returns</span>
                                <span class="adm-nav-badge">8</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/orders/refunds.php" class="adm-nav-subitem <?php echo $current_subnav === 'refunds' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                                <span>Refunds Ledger</span>
                                <span class="adm-nav-badge">6</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/orders/export.php" class="adm-nav-subitem <?php echo $current_subnav === 'export' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                <span>Export Studio</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="/Frontend/Admin/pricing/" class="adm-nav-item <?php echo $current_nav === 'pricing' ? 'active' : ''; ?>" id="navItem-pricing" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-pricing')) { switchAdmTab('pricing'); return false; }" data-title="Multi-Tier Pricing">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        <span class="adm-nav-label">Pricing & Discounts</span>
                    </a>
                </li>
                <li>
                    <a href="/Frontend/Admin/reviews/" class="adm-nav-item <?php echo $current_nav === 'reviews' ? 'active' : ''; ?>" id="navItem-reviews" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-reviews')) { switchAdmTab('reviews'); return false; }" data-title="Customer Reviews">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <span class="adm-nav-label">Reviews</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ── 3. B2B PARTNERS ── -->
        <div class="adm-nav-group">
            <div class="adm-nav-heading">B2B PARTNERS</div>
            <ul class="adm-nav-list">
                <li>
                    <a href="/Frontend/Admin/wholesalers/" class="adm-nav-item <?php echo $current_nav === 'wholesalers' ? 'active' : ''; ?>" id="navItem-wholesalers" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-partners')) { switchAdmTab('partners'); return false; }" data-title="Wholesale B2B Hub">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        <span class="adm-nav-label">Wholesalers</span>
                        <span class="adm-nav-badge gold">VIP</span>
                    </a>
                </li>
                <li>
                    <a href="/Frontend/Admin/resellers/" class="adm-nav-item <?php echo $current_nav === 'resellers' ? 'active' : ''; ?>" id="navItem-resellers" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-partners')) { switchAdmTab('partners'); return false; }" data-title="Resellers Network">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span class="adm-nav-label">Resellers</span>
                    </a>
                </li>
                <li>
                    <a href="/Frontend/Admin/retailers/" class="adm-nav-item <?php echo $current_nav === 'retailers' ? 'active' : ''; ?>" id="navItem-retailers" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-partners')) { switchAdmTab('partners'); return false; }" data-title="Retailer Accounts">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                        <span class="adm-nav-label">Retailers</span>
                    </a>
                </li>
                <!-- CUSTOMERS WITH REAL SVG SUBMENU -->
                <li class="adm-nav-has-sub <?php echo $current_nav === 'customers' ? 'open' : ''; ?>">
                    <a href="/Frontend/Admin/customers/" class="adm-nav-item <?php echo $current_nav === 'customers' ? 'active' : ''; ?>" id="navItem-customers" data-title="Customers Directory">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span class="adm-nav-label">Customers</span>
                        <span class="adm-nav-badge gold">4,820</span>
                        <span class="adm-nav-arrow-wrap" onclick="event.preventDefault(); event.stopPropagation(); toggleSidebarSubmenu(this);" title="Toggle submenu">
                            <svg class="adm-nav-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </span>
                    </a>
                    <ul class="adm-nav-submenu <?php echo $current_nav === 'customers' ? 'open' : ''; ?>" id="admSubmenu-customers">
                        <li>
                            <a href="/Frontend/Admin/customers/" class="adm-nav-subitem <?php echo ($current_nav === 'customers' && $current_subnav === 'all') ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                <span>All Customers</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/customers/active.php" class="adm-nav-subitem <?php echo $current_subnav === 'active' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                <span>Active Verified</span>
                                <span class="adm-nav-badge green">4,180</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/customers/inactive.php" class="adm-nav-subitem <?php echo $current_subnav === 'inactive' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                <span>Inactive / Dormant</span>
                                <span class="adm-nav-badge">640</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/customers/new.php" class="adm-nav-subitem <?php echo $current_subnav === 'new' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                <span>New Registrations</span>
                                <span class="adm-nav-badge">348</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/customers/segments.php" class="adm-nav-subitem <?php echo $current_subnav === 'segments' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <span>Segments &amp; Cohorts</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/customers/tags.php" class="adm-nav-subitem <?php echo $current_subnav === 'tags' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                                <span>Tags Studio</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/customers/analytics.php" class="adm-nav-subitem <?php echo $current_subnav === 'analytics' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                                <span>Analytics &amp; Growth</span>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/customers/export.php" class="adm-nav-subitem <?php echo $current_subnav === 'export' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                <span>Export Studio</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- ── 4. LOGISTICS & STOCK ── -->
        <div class="adm-nav-group">
            <div class="adm-nav-heading">LOGISTICS & STOCK</div>
            <ul class="adm-nav-list">
                <li>
                    <a href="/Frontend/Admin/inventory/" class="adm-nav-item <?php echo $current_nav === 'inventory' ? 'active' : ''; ?>" id="navItem-inventory" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-inventory')) { switchAdmTab('inventory'); return false; }" data-title="Warehouse Inventory">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"></path><path d="m3.3 7 8.7 5 8.7-5"></path><path d="M12 22V12"></path></svg>
                        <span class="adm-nav-label">Inventory & Stock</span>
                    </a>
                </li>
                <li>
                    <a href="/Frontend/Admin/shipping/" class="adm-nav-item <?php echo $current_nav === 'shipping' ? 'active' : ''; ?>" id="navItem-shipping" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-shipping')) { switchAdmTab('shipping'); return false; }" data-title="Shipping & Courier">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span class="adm-nav-label">Shipping Logistics</span>
                    </a>
                </li>
                <li>
                    <a href="/Frontend/Admin/payments/" class="adm-nav-item <?php echo $current_nav === 'payments' ? 'active' : ''; ?>" id="navItem-payments" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-payments')) { switchAdmTab('payments'); return false; }" data-title="Payments & Gateway">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                        <span class="adm-nav-label">Payments</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ── 5. MARKETING & CMS ── -->
        <div class="adm-nav-group">
            <div class="adm-nav-heading">MARKETING & CMS</div>
            <ul class="adm-nav-list">
                <li>
                    <a href="/Frontend/Admin/marketing/" class="adm-nav-item <?php echo $current_nav === 'marketing' ? 'active' : ''; ?>" id="navItem-marketing" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-marketing')) { switchAdmTab('marketing'); return false; }" data-title="Marketing & Campaigns">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                        <span class="adm-nav-label">Marketing & Offers</span>
                    </a>
                </li>
                <li>
                    <a href="/Frontend/Admin/cms/" class="adm-nav-item <?php echo $current_nav === 'cms' ? 'active' : ''; ?>" id="navItem-cms" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-cms')) { switchAdmTab('cms'); return false; }" data-title="CMS Pages">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span class="adm-nav-label">CMS Pages</span>
                    </a>
                </li>
                <li>
                    <a href="/Frontend/Admin/media/" class="adm-nav-item <?php echo $current_nav === 'media' ? 'active' : ''; ?>" id="navItem-media" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-media')) { switchAdmTab('media'); return false; }" data-title="Media Library">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        <span class="adm-nav-label">Media Library</span>
                    </a>
                </li>
                <li>
                    <a href="/Frontend/Admin/notifications/" class="adm-nav-item <?php echo $current_nav === 'notifications' ? 'active' : ''; ?>" id="navItem-notifications" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-notifications')) { switchAdmTab('notifications'); return false; }" data-title="Notifications Hub">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        <span class="adm-nav-label">Notifications</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ── 6. SYSTEM & INTEL ── -->
        <div class="adm-nav-group">
            <div class="adm-nav-heading">SYSTEM & INTEL</div>
            <ul class="adm-nav-list">
                <li>
                    <a href="/Frontend/Admin/reports/" class="adm-nav-item <?php echo $current_nav === 'reports' ? 'active' : ''; ?>" id="navItem-reports" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-reports')) { switchAdmTab('reports'); return false; }" data-title="Sales & GST Reports">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        <span class="adm-nav-label">Reports & GST</span>
                        <span class="adm-nav-badge gold">NEW</span>
                    </a>
                </li>
                <li>
                    <a href="/Frontend/Admin/users/" class="adm-nav-item <?php echo $current_nav === 'users' ? 'active' : ''; ?>" id="navItem-users" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-users')) { switchAdmTab('users'); return false; }" data-title="Admin Users & Roles">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
                        <span class="adm-nav-label">Users & Roles</span>
                    </a>
                </li>
                <li>
                    <a href="/Frontend/Admin/settings/" class="adm-nav-item <?php echo $current_nav === 'settings' ? 'active' : ''; ?>" id="navItem-settings" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-settings')) { switchAdmTab('settings'); return false; }" data-title="Store Settings">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span class="adm-nav-label">Store Settings</span>
                    </a>
                </li>
                <li>
                    <a href="/Frontend/Admin/system/" class="adm-nav-item <?php echo $current_nav === 'system' ? 'active' : ''; ?>" id="navItem-system" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-system')) { switchAdmTab('system'); return false; }" data-title="System Health & API">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        <span class="adm-nav-label">System Health</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>

<!-- ══ Mobile Sidebar & Submenu Self-Executing Controller ══ -->
<script>
(function() {
    'use strict';

    // Mobile Sidebar Drawer Toggle (Always Full 285px Mode)
    window.toggleAdmMobileSidebar = function(e) {
        if (e) { 
            e.preventDefault(); 
            e.stopPropagation(); 
        }
        const sidebar = document.getElementById('admSidebar') || document.querySelector('.adm-sidebar');
        const backdrop = document.getElementById('admSidebarBackdrop');
        if (sidebar) {
            sidebar.classList.remove('collapsed'); // Never allow collapsed on mobile
            const isOpen = sidebar.classList.toggle('mobile-open');
            if (backdrop) {
                backdrop.style.display = isOpen ? 'block' : 'none';
            }
            if (isOpen) {
                document.body.classList.add('adm-mobile-sidebar-active');
            } else {
                document.body.classList.remove('adm-mobile-sidebar-active');
            }
        }
    };

    window.closeAdmMobileSidebar = function(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        const sidebar = document.getElementById('admSidebar') || document.querySelector('.adm-sidebar');
        const backdrop = document.getElementById('admSidebarBackdrop');
        if (sidebar) sidebar.classList.remove('mobile-open');
        if (backdrop) backdrop.style.display = 'none';
        document.body.classList.remove('adm-mobile-sidebar-active');
    };

    // Desktop Collapse Toggle Function
    window.toggleSidebarCollapsed = function() {
        const sidebar = document.getElementById('admSidebar') || document.querySelector('.adm-sidebar');
        if (!sidebar) return;
        
        if (window.innerWidth <= 1024) {
            window.closeAdmMobileSidebar();
            return;
        }

        const willCollapse = !sidebar.classList.contains('collapsed');
        if (willCollapse) {
            sidebar.classList.add('collapsed');
            // Auto-close any open submenus when closing the sidebar!
            document.querySelectorAll('.adm-nav-has-sub.open').forEach(function(li) {
                li.classList.remove('open');
                const sub = li.querySelector('.adm-nav-submenu');
                if (sub) sub.classList.remove('open');
            });
            try { localStorage.setItem('dt_adm_sidebar_collapsed', '1'); } catch(err) {}
        } else {
            sidebar.classList.remove('collapsed');
            try { localStorage.setItem('dt_adm_sidebar_collapsed', '0'); } catch(err) {}
        }
    };

    // Submenu Toggle with Auto-Expand on Closed Sidebar
    window.toggleSidebarSubmenu = function(item) {
        const sidebar = document.getElementById('admSidebar') || document.querySelector('.adm-sidebar');
        
        // If sidebar is currently collapsed on desktop, AUTO-EXPAND it when opening any submenu!
        if (sidebar && sidebar.classList.contains('collapsed')) {
            sidebar.classList.remove('collapsed');
            try { localStorage.setItem('dt_adm_sidebar_collapsed', '0'); } catch(err) {}
        }

        const parent = item.closest('.adm-nav-has-sub');
        if (parent) {
            const isOpen = parent.classList.contains('open');
            if (isOpen) {
                parent.classList.remove('open');
                const sub = parent.querySelector('.adm-nav-submenu');
                if (sub) sub.classList.remove('open');
            } else {
                // Auto-close any other open submenus first (Smart Luxury Accordion)
                document.querySelectorAll('.adm-nav-has-sub').forEach(function(li) {
                    if (li !== parent) {
                        li.classList.remove('open');
                        const otherSub = li.querySelector('.adm-nav-submenu');
                        if (otherSub) otherSub.classList.remove('open');
                    }
                });
                parent.classList.add('open');
                const sub = parent.querySelector('.adm-nav-submenu');
                if (sub) sub.classList.add('open');
            }
        }
    };

    function initAdmSidebar() {
        const sidebar = document.getElementById('admSidebar') || document.querySelector('.adm-sidebar');
        const backdrop = document.getElementById('admSidebarBackdrop');
        const toggleBtn = document.getElementById('admSidebarToggleBtn');
        const sealMini = document.querySelector('.adm-brand-seal-mini');

        // On screen size check: On mobile (<= 1024px), strictly remove collapsed
        function checkResponsiveSidebar() {
            if (window.innerWidth <= 1024) {
                if (sidebar) sidebar.classList.remove('collapsed');
            } else {
                if (sidebar && localStorage.getItem('dt_adm_sidebar_collapsed') === '1') {
                    sidebar.classList.add('collapsed');
                }
            }
        }

        checkResponsiveSidebar();
        window.addEventListener('resize', checkResponsiveSidebar);

        // Bind Submenu Row Click for Mobile & Tablet
        document.querySelectorAll('.adm-nav-has-sub > a').forEach(function(link) {
            link.addEventListener('click', function(e) {
                if (window.innerWidth <= 1024 || e.target.closest('.adm-nav-arrow-wrap') || (sidebar && sidebar.classList.contains('collapsed'))) {
                    e.preventDefault();
                    window.toggleSidebarSubmenu(this);
                }
            });
        });

        // Close mobile drawer when pressing ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && window.innerWidth <= 1024) {
                window.closeAdmMobileSidebar();
            }
        });

        if (backdrop) {
            backdrop.onclick = function(e) {
                window.closeAdmMobileSidebar(e);
            };
        }

        if (toggleBtn && sidebar) {
            toggleBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                window.toggleSidebarCollapsed();
            };
        }

        if (sealMini && sidebar) {
            sealMini.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                sidebar.classList.remove('collapsed');
                try { localStorage.setItem('dt_adm_sidebar_collapsed', '0'); } catch(err) {}
            };
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAdmSidebar);
    } else {
        initAdmSidebar();
    }
})();
</script>
