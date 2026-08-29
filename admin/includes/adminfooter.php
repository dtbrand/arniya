<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * adminfooter.php — Luxury Admin Dashboard Bottom Status Bar & Mobile Bottom Dock
 * DT Brand's & Jai Hanuman Tex
 */
$curr_nav = isset($active_nav) ? $active_nav : 'dashboard';
?>
<!-- ══ Desktop Wholesaler-Style Status Bar ══ -->
<footer class="adm-desktop-footer">
    <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
        <span style="display:inline-flex; align-items:center; gap:6px; color:#15803D; font-weight:700;">
            <span style="width:7px; height:7px; border-radius:50%; background:#15803D; box-shadow:0 0 6px #15803D;"></span>
            Hostinger Live Cloud: Synchronized
        </span>
        <span style="color:#DCD7CD;">|</span>
        <span>DB Version: <strong>v2.8.4 Enterprise</strong></span>
        <span style="color:#DCD7CD;">|</span>
        <span>Active CRM WebSockets: <strong>14 Sessions</strong></span>
    </div>

    <div style="display:flex; align-items:center; gap:14px; flex-wrap:wrap;">
        <span>© <?php echo date('Y'); ?> <strong>DT Brand's & Jai Hanuman Tex</strong>. All Rights Reserved.</span>
        <a href="https://jaihanumantex.in/" target="_blank" style="color:#8A681F; font-weight:700; text-decoration:none;">jaihanumantex.in ↗</a>
    </div>
</footer>

<!-- ══ Luxury Mobile Wholesale-Style Bottom Navigation Dock (Sticky App Bar) ══ -->
<nav class="adm-mobile-bottom-dock" id="admMobileBottomDock">
    <!-- Tab 1: Dashboard -->
    <a href="/admin" class="adm-dock-item <?php echo $curr_nav === 'dashboard' ? 'active' : ''; ?>" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-overview')){ switchAdmTab('overview'); return false; }" title="Dashboard">
        <svg class="adm-dock-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
        <span class="adm-dock-label">Dashboard</span>
    </a>

    <!-- Tab 2: Products Catalog -->
    <a href="/admin/products/" class="adm-dock-item <?php echo $curr_nav === 'products' ? 'active' : ''; ?>" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-products')){ switchAdmTab('products'); return false; }" title="Products">
        <svg class="adm-dock-icon" viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
        <span class="adm-dock-label">Products</span>
    </a>

    <!-- Tab 3: Center Elevated Master Gold FAB (Quick Add Product) -->
    <a href="/admin/products/add.php" class="adm-dock-center-btn" title="Add Product">
        <div class="adm-dock-orb">
            <svg class="adm-dock-plus-svg" viewBox="0 0 24 24" width="22" height="22" stroke="#111827" stroke-width="2.8" fill="none"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        </div>
    </a>

    <!-- Tab 4: WhatsApp CRM -->
    <a href="/admin/whatsapp/" class="adm-dock-item <?php echo $curr_nav === 'whatsapp' ? 'active' : ''; ?>" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-whatsapp')){ switchAdmTab('whatsapp'); return false; }" title="WhatsApp CRM">
        <div style="position:relative; display:inline-flex;">
            <svg class="adm-dock-icon" viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
            <span class="adm-dock-live-dot"></span>
        </div>
        <span class="adm-dock-label">WhatsApp</span>
    </a>

    <!-- Tab 5: Orders Hub -->
    <a href="/admin/orders/" class="adm-dock-item <?php echo $curr_nav === 'orders' ? 'active' : ''; ?>" onclick="if(typeof switchAdmTab==='function' && document.getElementById('tab-orders')){ switchAdmTab('orders'); return false; }" title="Orders">
        <svg class="adm-dock-icon" viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
        <span class="adm-dock-label">Orders</span>
    </a>
</nav>
