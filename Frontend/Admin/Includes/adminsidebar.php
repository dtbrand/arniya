<?php
/**
 * adminsidebar.php — Luxury Wholesaler-Style Admin Sidebar Navigation with Real SVG Icons
 * DT Brand's & Jai Hanuman Tex
 */
$current_nav = isset($active_nav) ? $active_nav : 'dashboard';
$current_subnav = isset($active_subnav) ? $active_subnav : '';
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
        <button class="adm-sidebar-toggle-btn" id="admSidebarToggleBtn" title="Toggle Sidebar">
            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2.2" fill="none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
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
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span class="adm-nav-label">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/Frontend/Admin/whatsapp/" class="adm-nav-item <?php echo $current_nav === 'whatsapp' ? 'active' : ''; ?>" id="navItem-whatsapp" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-whatsapp')) { switchAdmTab('whatsapp'); return false; }" data-title="WhatsApp CRM">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
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
                <li class="adm-nav-has-sub open">
                    <a href="/Frontend/Admin/products/" class="adm-nav-item <?php echo $current_nav === 'products' ? 'active' : ''; ?>" id="navItem-products" onclick="if(typeof toggleSidebarSubmenu==='function') { toggleSidebarSubmenu(this); } if(typeof switchAdmTab==='function' && document.getElementById('tab-products')) { switchAdmTab('products'); return false; }" data-title="Products Catalog">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <span class="adm-nav-label">Products</span>
                        <span class="adm-nav-badge">1,240</span>
                        <svg class="adm-nav-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </a>
                    <!-- SUBMENU ITEMS LIST WITH CRISP SVG ICONS -->
                    <ul class="adm-nav-submenu open" id="admSubmenu-products">
                        <li>
                            <a href="/Frontend/Admin/products/" class="adm-nav-subitem <?php echo ($current_nav === 'products' && empty($current_subnav)) ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                <span>All Products</span>
                                <small style="color:#C5A859; font-size:0.65rem; margin-left:auto;">1,240</small>
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
                                <small style="color:#C5A859; font-size:0.65rem; margin-left:auto;">16</small>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/products/brands/" class="adm-nav-subitem <?php echo $current_subnav === 'brands' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><circle cx="7.5" cy="7.5" r="1.5"></circle></svg>
                                <span>Brands</span>
                                <small style="color:#C5A859; font-size:0.65rem; margin-left:auto;">4</small>
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
                                <small style="color:#C5A859; font-size:0.65rem; margin-left:auto;">48</small>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/products/best-sellers/" class="adm-nav-subitem <?php echo $current_subnav === 'best-sellers' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
                                <span>Best Sellers</span>
                                <small style="color:#C5A859; font-size:0.65rem; margin-left:auto;">32</small>
                            </a>
                        </li>
                        <li>
                            <a href="/Frontend/Admin/products/new-arrivals/" class="adm-nav-subitem <?php echo $current_subnav === 'new-arrivals' ? 'active' : ''; ?>">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15 8 21 9 17 14 18 20 12 17 6 20 7 14 3 9 9 8 12 2"></polygon></svg>
                                <span>New Arrivals</span>
                                <small style="color:#C5A859; font-size:0.65rem; margin-left:auto;">64</small>
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
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                <span>Export Studio</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="/Frontend/Admin/orders/" class="adm-nav-item <?php echo $current_nav === 'orders' ? 'active' : ''; ?>" id="navItem-orders" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-orders')) { switchAdmTab('orders'); return false; }" data-title="Orders & Shipments">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        <span class="adm-nav-label">Orders</span>
                        <span class="adm-nav-badge gold" id="admNavOrdersBadge">5 New</span>
                    </a>
                </li>
                <li>
                    <a href="/Frontend/Admin/pricing/" class="adm-nav-item <?php echo $current_nav === 'pricing' ? 'active' : ''; ?>" id="navItem-pricing" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-pricing')) { switchAdmTab('pricing'); return false; }" data-title="Multi-Tier Pricing">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path><line x1="12" y1="6" x2="12" y2="18"></line></svg>
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
                <li>
                    <a href="/Frontend/Admin/customers/" class="adm-nav-item <?php echo $current_nav === 'customers' ? 'active' : ''; ?>" id="navItem-customers" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-customers')) { switchAdmTab('customers'); return false; }" data-title="Customers Directory">
                        <svg class="adm-nav-icon" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span class="adm-nav-label">Customers</span>
                    </a>
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
    function initAdmSidebar() {
        const mobileBtn = document.getElementById('admMobileMenuBtn');
        const sidebar = document.getElementById('admSidebar');
        const backdrop = document.getElementById('admSidebarBackdrop');
        const toggleBtn = document.getElementById('admSidebarToggleBtn');

        if (mobileBtn && sidebar) {
            mobileBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                sidebar.classList.toggle('mobile-open');
                if (backdrop) {
                    backdrop.style.display = sidebar.classList.contains('mobile-open') ? 'block' : 'none';
                }
            };
        }

        if (backdrop && sidebar) {
            backdrop.onclick = function(e) {
                e.preventDefault();
                sidebar.classList.remove('mobile-open');
                backdrop.style.display = 'none';
            };
        }

        if (toggleBtn && sidebar) {
            toggleBtn.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                sidebar.classList.toggle('collapsed');
            };
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAdmSidebar);
    } else {
        initAdmSidebar();
    }
})();

function toggleSidebarSubmenu(item) {
    const parent = item.closest('.adm-nav-has-sub');
    if (parent) {
        parent.classList.toggle('open');
        const sub = parent.querySelector('.adm-nav-submenu');
        if (sub) sub.classList.toggle('open');
    }
}
</script>
