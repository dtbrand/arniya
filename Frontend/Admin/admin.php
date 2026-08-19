<?php
/**
 * admin.php — Luxury Executive Admin Dashboard & WhatsApp CRM Control Center
 * DT Brand's & Jai Hanuman Tex
 * 
 * Signature Heritage Gold Theme + Full CRM, Multi-Channel Commerce & Logistics
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Executive Admin Dashboard & CRM — DT Brand's Luxury Ethnic</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Admin CSS Stylesheet -->
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>

<div class="adm-layout">

    <!-- ══ LEFT SIDEBAR NAVIGATION ══ -->
    <?php include_once __DIR__ . '/Includes/adminsidebar.php'; ?>

    <!-- ══ MAIN CONTENT WRAPPER ══ -->
    <div class="adm-main">

        <!-- ══ TOP HEADER ══ -->
        <?php include_once __DIR__ . '/Includes/adminheader.php'; ?>

        <!-- ══ WHOLESALER-STYLE DESKTOP SUBNAV QUICK TABS STRIP ══ -->
        <nav class="adm-subnav-strip" id="admSubnavStrip">
            <ul class="adm-subnav-pills">
                <li>
                    <button class="adm-subnav-item active" id="subnav-overview" onclick="switchAdmTab('overview')">
                        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>Dashboard</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-orders" onclick="switchAdmTab('orders')">
                        <svg viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                        <span>Orders</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-products" onclick="switchAdmTab('products')">
                        <svg viewBox="0 0 24 24"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <span>Catalog</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-reports" onclick="switchAdmTab('reports')">
                        <svg viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        <span>Reports</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-whatsapp" onclick="switchAdmTab('whatsapp')">
                        <svg viewBox="0 0 24 24"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <span>WhatsApp CRM</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-partners" onclick="switchAdmTab('partners')">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                        <span>Partners</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-customers" onclick="switchAdmTab('customers')">
                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span>Customers</span>
                    </button>
                </li>
                <li>
                    <button class="adm-subnav-item" id="subnav-settings" onclick="switchAdmTab('settings')">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                        <span>Settings</span>
                    </button>
                </li>
            </ul>
            <div style="font-size:0.75rem; color:#8A681F; font-weight:700; white-space:nowrap; display:flex; align-items:center; gap:6px;">
                <span>★ Master Admin Console</span>
            </div>
        </nav>

        <!-- ══ TAB PANELS CONTENT CONTAINER ══ -->
        <main class="adm-content">

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 1: EXECUTIVE OVERVIEW DASHBOARD
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel active" id="tab-overview">
                <!-- Page Head -->
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">
                            <span>Executive Command Center</span>
                            <span class="adm-badge gold" style="font-size:0.68rem;">DT Brand's Live</span>
                        </h1>
                        <p class="adm-page-subtitle">Real-time overview of Wholesale B2B, Reseller Margins, B2C Shop, and WhatsApp CRM pipeline.</p>
                    </div>
                    <div class="adm-page-actions">
                        <button class="adm-btn-secondary" onclick="window.exportTableToCSV('orders')">
                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Export Sales CSV</span>
                        </button>
                        <button class="adm-btn-primary" onclick="openAddProductModal()">
                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2.5" fill="none"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>+ Add Product</span>
                        </button>
                    </div>
                </div>

                <!-- ════ LIVE BUSINESS STATUS TICKER ════ -->
                <section class="adm-live-ticker-strip">
                    <div class="adm-live-ticker-item">
                        <div class="adm-live-ticker-icon" style="background:#DCFCE7; color:#15803D;"><span class="adm-pulse-dot"></span></div>
                        <div>
                            <div class="adm-live-ticker-val" id="liveUsersCount">142</div>
                            <div class="adm-live-ticker-lbl">Live Users Online</div>
                        </div>
                    </div>
                    <div class="adm-live-ticker-item">
                        <div class="adm-live-ticker-icon">🛍️</div>
                        <div>
                            <div class="adm-live-ticker-val">18</div>
                            <div class="adm-live-ticker-lbl">Live Orders Today</div>
                        </div>
                    </div>
                    <div class="adm-live-ticker-item">
                        <div class="adm-live-ticker-icon">💳</div>
                        <div>
                            <div class="adm-live-ticker-val">9</div>
                            <div class="adm-live-ticker-lbl">Active Checkouts</div>
                        </div>
                    </div>
                    <div class="adm-live-ticker-item">
                        <div class="adm-live-ticker-icon">⏳</div>
                        <div>
                            <div class="adm-live-ticker-val">₹48,200</div>
                            <div class="adm-live-ticker-lbl">Pending Payments</div>
                        </div>
                    </div>
                    <div class="adm-live-ticker-item">
                        <div class="adm-live-ticker-icon">🛒</div>
                        <div>
                            <div class="adm-live-ticker-val">34</div>
                            <div class="adm-live-ticker-lbl">Active Cart Sessions</div>
                        </div>
                    </div>
                    <div class="adm-live-ticker-item">
                        <div class="adm-live-ticker-icon">👤</div>
                        <div>
                            <div class="adm-live-ticker-val">+12</div>
                            <div class="adm-live-ticker-lbl">New Registrations</div>
                        </div>
                    </div>
                    <div class="adm-live-ticker-item">
                        <div class="adm-live-ticker-icon" style="background:#FEE2E2; color:#DC2626;">⚠️</div>
                        <div>
                            <div class="adm-live-ticker-val">3 Items</div>
                            <div class="adm-live-ticker-lbl">Stock Alert</div>
                        </div>
                    </div>
                </section>

                <!-- ════ 22 MAIN KPI METRIC CARDS ════ -->
                <div class="adm-kpi-grid">
                    <!-- 1. Total Revenue -->
                    <div class="adm-kpi-card primary" onclick="switchAdmTab('reports')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Total Revenue</span>
                            <div class="adm-kpi-icon-box">💰</div>
                        </div>
                        <div class="adm-kpi-val">₹42,85,900</div>
                        <div class="adm-kpi-bottom">
                            <span class="adm-kpi-delta up">↑ +18.4%</span>
                            <div class="adm-kpi-sparkline" data-trend="up"></div>
                        </div>
                    </div>

                    <!-- 2. Today's Revenue -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('reports')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Today's Revenue</span>
                            <div class="adm-kpi-icon-box blue">💵</div>
                        </div>
                        <div class="adm-kpi-val">₹1,84,500</div>
                        <div class="adm-kpi-bottom">
                            <span class="adm-kpi-delta up">↑ +12.1%</span>
                            <div class="adm-kpi-sparkline" data-trend="up"></div>
                        </div>
                    </div>

                    <!-- 3. Monthly Revenue -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('reports')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Monthly Revenue</span>
                            <div class="adm-kpi-icon-box">📈</div>
                        </div>
                        <div class="adm-kpi-val">₹38,20,000</div>
                        <div class="adm-kpi-bottom">
                            <span class="adm-kpi-delta up">↑ +24.8%</span>
                            <div class="adm-kpi-sparkline" data-trend="up"></div>
                        </div>
                    </div>

                    <!-- 4. Gross Profit -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('reports')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Gross Profit</span>
                            <div class="adm-kpi-icon-box green">📊</div>
                        </div>
                        <div class="adm-kpi-val">₹14,92,400</div>
                        <div class="adm-kpi-bottom">
                            <span class="adm-kpi-delta up">↑ +15.2% (34.8%)</span>
                            <div class="adm-kpi-sparkline" data-trend="up"></div>
                        </div>
                    </div>

                    <!-- 5. Net Profit -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('reports')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Net Profit</span>
                            <div class="adm-kpi-icon-box">💎</div>
                        </div>
                        <div class="adm-kpi-val">₹11,45,200</div>
                        <div class="adm-kpi-bottom">
                            <span class="adm-kpi-delta up">↑ +11.8%</span>
                            <div class="adm-kpi-sparkline" data-trend="up"></div>
                        </div>
                    </div>

                    <!-- 6. Total Orders -->
                    <div class="adm-kpi-card primary" onclick="switchAdmTab('orders')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Total Orders</span>
                            <div class="adm-kpi-icon-box blue">📦</div>
                        </div>
                        <div class="adm-kpi-val">1,624</div>
                        <div class="adm-kpi-bottom">
                            <span class="adm-kpi-delta up">↑ +14.6%</span>
                            <div class="adm-kpi-sparkline" data-trend="up"></div>
                        </div>
                    </div>

                    <!-- 7. Today's Orders -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('orders')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Today's Orders</span>
                            <div class="adm-kpi-icon-box blue">⚡</div>
                        </div>
                        <div class="adm-kpi-val">38</div>
                        <div class="adm-kpi-bottom">
                            <span class="adm-kpi-delta up">↑ +8 vs Yest.</span>
                            <div class="adm-kpi-sparkline" data-trend="up"></div>
                        </div>
                    </div>

                    <!-- 8. Pending Orders -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('orders')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Pending Orders</span>
                            <div class="adm-kpi-icon-box purple">⏳</div>
                        </div>
                        <div class="adm-kpi-val" style="color:#DC2626;">18</div>
                        <div class="adm-kpi-bottom">
                            <span class="adm-badge rose">Action Needed</span>
                        </div>
                    </div>

                    <!-- 9. Completed Orders -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('orders')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Completed Orders</span>
                            <div class="adm-kpi-icon-box green">✅</div>
                        </div>
                        <div class="adm-kpi-val">1,542</div>
                        <div class="adm-kpi-bottom">
                            <span class="adm-kpi-delta up">94.9% Success</span>
                            <div class="adm-kpi-sparkline" data-trend="up"></div>
                        </div>
                    </div>

                    <!-- 10. Cancelled Orders -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('orders')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Cancelled Orders</span>
                            <div class="adm-kpi-icon-box purple">❌</div>
                        </div>
                        <div class="adm-kpi-val">64</div>
                        <div class="adm-kpi-bottom">
                            <span class="adm-kpi-delta down">↓ 3.9% Rate</span>
                            <div class="adm-kpi-sparkline" data-trend="down"></div>
                        </div>
                    </div>

                    <!-- 11. Total Customers -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('customers')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Total Customers</span>
                            <div class="adm-kpi-icon-box purple">👥</div>
                        </div>
                        <div class="adm-kpi-val">4,820</div>
                        <div class="adm-kpi-bottom">
                            <span class="adm-kpi-delta up">↑ +210 This Mo</span>
                            <div class="adm-kpi-sparkline" data-trend="up"></div>
                        </div>
                    </div>

                    <!-- 12. New Customers -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('customers')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">New Customers (30D)</span>
                            <div class="adm-kpi-icon-box purple">✨</div>
                        </div>
                        <div class="adm-kpi-val">348</div>
                        <div class="adm-kpi-bottom">
                            <span class="adm-kpi-delta up">↑ +18.2%</span>
                            <div class="adm-kpi-sparkline" data-trend="up"></div>
                        </div>
                    </div>

                    <!-- 13. Total Resellers -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('partners')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Total Resellers</span>
                            <div class="adm-kpi-icon-box purple">🤝</div>
                        </div>
                        <div class="adm-kpi-val">348</div>
                        <div class="adm-kpi-bottom">
                            <span class="adm-kpi-delta up">₹4.8L Payouts</span>
                            <span class="adm-badge gold">Active Hub</span>
                        </div>
                    </div>

                    <!-- 14. Total Retailers -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('partners')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Total Retailers</span>
                            <div class="adm-kpi-icon-box blue">🏬</div>
                        </div>
                        <div class="adm-kpi-val">124</div>
                        <div class="adm-kpi-bottom">
                            <span class="adm-kpi-delta up">↑ +12% Growth</span>
                            <div class="adm-kpi-sparkline" data-trend="up"></div>
                        </div>
                    </div>

                    <!-- 15. Total Wholesalers -->
                    <div class="adm-kpi-card primary" onclick="switchAdmTab('partners')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Total Wholesalers</span>
                            <div class="adm-kpi-icon-box">🏢</div>
                        </div>
                        <div class="adm-kpi-val">46</div>
                        <div class="adm-kpi-bottom">
                            <span class="adm-kpi-delta up">68 Consignments</span>
                            <span class="adm-badge emerald">Tier 1 VIP</span>
                        </div>
                    </div>

                    <!-- 16. Total Products -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('products')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Total Products</span>
                            <div class="adm-kpi-icon-box">👗</div>
                        </div>
                        <div class="adm-kpi-val">1,240</div>
                        <div class="adm-kpi-bottom">
                            <span>16 Categories</span>
                            <span class="adm-badge gold">Surat Catalog</span>
                        </div>
                    </div>

                    <!-- 17. Active In Stock -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('products')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Active In Stock</span>
                            <div class="adm-kpi-icon-box green">🟢</div>
                        </div>
                        <div class="adm-kpi-val">1,185</div>
                        <div class="adm-kpi-bottom">
                            <span class="adm-kpi-delta up">95.5% In Stock</span>
                            <div class="adm-kpi-sparkline" data-trend="up"></div>
                        </div>
                    </div>

                    <!-- 18. Low Stock -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('products')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Low Stock</span>
                            <div class="adm-kpi-icon-box" style="background:#FEF3C7; color:#D97706;">⚠️</div>
                        </div>
                        <div class="adm-kpi-val" style="color:#D97706;">14</div>
                        <div class="adm-kpi-bottom">
                            <span>Threshold &lt; 5 pcs</span>
                            <span class="adm-badge amber">Re-order</span>
                        </div>
                    </div>

                    <!-- 19. Out of Stock -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('products')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Out of Stock</span>
                            <div class="adm-kpi-icon-box purple">🛑</div>
                        </div>
                        <div class="adm-kpi-val" style="color:#DC2626;">41</div>
                        <div class="adm-kpi-bottom">
                            <span class="adm-badge rose">Restock Pending</span>
                        </div>
                    </div>

                    <!-- 20. Pending Payments -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('reports')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Pending Payments</span>
                            <div class="adm-kpi-icon-box">💳</div>
                        </div>
                        <div class="adm-kpi-val">₹48,200</div>
                        <div class="adm-kpi-bottom">
                            <span>14 Invoices</span>
                            <span class="adm-badge gold">Net 15</span>
                        </div>
                    </div>

                    <!-- 21. Refund Requests -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('orders')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Refund Requests</span>
                            <div class="adm-kpi-icon-box purple">🔄</div>
                        </div>
                        <div class="adm-kpi-val">3</div>
                        <div class="adm-kpi-bottom">
                            <span>₹6,400 Value</span>
                            <span class="adm-badge rose">Pending</span>
                        </div>
                    </div>

                    <!-- 22. Return Requests -->
                    <div class="adm-kpi-card" onclick="switchAdmTab('orders')">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Return Requests</span>
                            <div class="adm-kpi-icon-box purple">↩️</div>
                        </div>
                        <div class="adm-kpi-val">5</div>
                        <div class="adm-kpi-bottom">
                            <span>Quality Inspection</span>
                            <span class="adm-badge rose">Pending</span>
                        </div>
                    </div>
                </div>

                <!-- ════ ORDER STATUS PIPELINE FLOW ════ -->
                <div class="adm-card" style="margin-bottom:24px;">
                    <div class="adm-card-head">
                        <h3 class="adm-card-title">
                            <span>📦 Order Status Fulfillment Pipeline</span>
                        </h3>
                        <button type="button" class="adm-btn-secondary adm-btn-sm" onclick="switchAdmTab('orders')">All Orders ↗</button>
                    </div>
                    <div class="adm-pipeline-wrap">
                        <div class="adm-pipeline-step active" onclick="switchAdmTab('orders')">
                            <span class="adm-pipe-name">New</span>
                            <span class="adm-pipe-count">18</span>
                            <span class="adm-pipe-meta">Today</span>
                        </div>
                        <div class="adm-pipeline-step" onclick="switchAdmTab('orders')">
                            <span class="adm-pipe-name">Pending</span>
                            <span class="adm-pipe-count">12</span>
                            <span class="adm-pipe-meta">Payment Conf.</span>
                        </div>
                        <div class="adm-pipeline-step" onclick="switchAdmTab('orders')">
                            <span class="adm-pipe-name">Confirmed</span>
                            <span class="adm-pipe-count">42</span>
                            <span class="adm-pipe-meta">Warehouse</span>
                        </div>
                        <div class="adm-pipeline-step" onclick="switchAdmTab('orders')">
                            <span class="adm-pipe-name">Processing</span>
                            <span class="adm-pipe-count">29</span>
                            <span class="adm-pipe-meta">Picking</span>
                        </div>
                        <div class="adm-pipeline-step" onclick="switchAdmTab('orders')">
                            <span class="adm-pipe-name">Packed</span>
                            <span class="adm-pipe-count">35</span>
                            <span class="adm-pipe-meta">Label Generated</span>
                        </div>
                        <div class="adm-pipeline-step" onclick="switchAdmTab('orders')">
                            <span class="adm-pipe-name">Shipped</span>
                            <span class="adm-pipe-count">84</span>
                            <span class="adm-pipe-meta">In Transit</span>
                        </div>
                        <div class="adm-pipeline-step" onclick="switchAdmTab('orders')">
                            <span class="adm-pipe-name">Out for Delivery</span>
                            <span class="adm-pipe-count">21</span>
                            <span class="adm-pipe-meta">Courier Hub</span>
                        </div>
                        <div class="adm-pipeline-step" onclick="switchAdmTab('orders')">
                            <span class="adm-pipe-name">Delivered</span>
                            <span class="adm-pipe-count" style="color:var(--adm-emerald);">1,542</span>
                            <span class="adm-pipe-meta">94.9% Success</span>
                        </div>
                        <div class="adm-pipeline-step" onclick="switchAdmTab('orders')">
                            <span class="adm-pipe-name">Cancelled</span>
                            <span class="adm-pipe-count" style="color:var(--adm-rose);">64</span>
                            <span class="adm-pipe-meta">3.9% Rate</span>
                        </div>
                        <div class="adm-pipeline-step" onclick="switchAdmTab('orders')">
                            <span class="adm-pipe-name">Returned</span>
                            <span class="adm-pipe-count" style="color:var(--adm-amber);">5</span>
                            <span class="adm-pipe-meta">RTO Return</span>
                        </div>
                        <div class="adm-pipeline-step" onclick="switchAdmTab('orders')">
                            <span class="adm-pipe-name">Refunded</span>
                            <span class="adm-pipe-count">3</span>
                            <span class="adm-pipe-meta">Settled</span>
                        </div>
                    </div>
                </div>

                <!-- ════ CHARTS SECTION ════ -->
                <div class="adm-charts-grid">
                    <!-- Revenue Analytics Chart -->
                    <div class="adm-card">
                        <div class="adm-card-head">
                            <h3 class="adm-card-title">
                                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                                <span>Multi-Channel Revenue Flow (₹)</span>
                            </h3>
                            <div class="adm-card-controls">
                                <div class="adm-pill-btn-group">
                                    <button class="adm-pill-btn active">7D</button>
                                    <button class="adm-pill-btn">30D</button>
                                    <button class="adm-pill-btn">90D</button>
                                </div>
                            </div>
                        </div>
                        <div class="adm-chart-container">
                            <canvas id="admRevenueChart"></canvas>
                        </div>
                        <div style="display:flex; align-items:center; justify-content:center; gap:24px; font-size:0.78rem; font-weight:600;">
                            <div style="display:flex; align-items:center; gap:6px;">
                                <span style="width:12px; height:4px; background:#8A681F; border-radius:2px;"></span>
                                <span>B2B Wholesale (₹28.4L)</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:6px;">
                                <span style="width:12px; height:4px; background:#15803D; border-radius:2px;"></span>
                                <span>B2C Shop & Resellers (₹14.4L)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Category Share Doughnut -->
                    <div class="adm-card">
                        <div class="adm-card-head">
                            <h3 class="adm-card-title">
                                <span>Category Sales</span>
                            </h3>
                            <span class="adm-badge gold">Top Sarees</span>
                        </div>
                        <div class="adm-chart-container" style="display:flex; align-items:center; justify-content:center;">
                            <canvas id="admCategoryChart"></canvas>
                        </div>
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; font-size:0.74rem;">
                            <div style="display:flex; align-items:center; gap:6px;">
                                <span style="width:8px; height:8px; border-radius:50%; background:#8A681F;"></span>
                                <span>Sarees (45%)</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:6px;">
                                <span style="width:8px; height:8px; border-radius:50%; background:#C5A859;"></span>
                                <span>Kurtis (25%)</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:6px;">
                                <span style="width:8px; height:8px; border-radius:50%; background:#100E0C;"></span>
                                <span>Lehengas (18%)</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:6px;">
                                <span style="width:8px; height:8px; border-radius:50%; background:#15803D;"></span>
                                <span>Dress Mat. (12%)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders Preview Table on Overview -->
                <div class="adm-table-card">
                    <div class="adm-table-toolbar">
                        <div>
                            <h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800; color:#181512;">Recent Order Stream</h3>
                            <p style="font-size:0.75rem; color:#7A7266;">Latest B2B & B2C dispatches requiring action</p>
                        </div>
                        <button class="adm-btn-secondary" onclick="switchAdmTab('orders')">
                            <span>View All Orders →</span>
                        </button>
                    </div>
                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer / Business</th>
                                    <th>Channel</th>
                                    <th>Items</th>
                                    <th>Total & Payment</th>
                                    <th>Status</th>
                                    <th>Quick WhatsApp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>ORD-9842</strong><br><small style="color:#8C8478;">Today, 04:30 PM</small></td>
                                    <td><strong>Ananya Sharma</strong><br><small style="color:#8A681F;">+91 9876543210 • Mumbai</small></td>
                                    <td><span style="font-weight:700; background:#F8F6F0; padding:2px 6px; border-radius:4px;">B2C Shop</span></td>
                                    <td>Nilambari Silk Saree (Qty: 1)</td>
                                    <td><strong>₹4,899</strong><br><small style="color:#15803D;">Prepaid (UPI)</small></td>
                                    <td><span class="adm-badge info">In Transit</span></td>
                                    <td>
                                        <button class="adm-action-btn wa" title="Send WhatsApp Tracking" onclick="window.sendOrderWhatsApp('ORD-9842')">
                                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>ORD-9841</strong><br><small style="color:#8C8478;">Today, 02:15 PM</small></td>
                                    <td><strong>Vardhman Textiles (Rajesh K.)</strong><br><small style="color:#8A681F;">+91 9822019283 • Surat</small></td>
                                    <td><span style="font-weight:700; background:#FAF5E8; color:#8A681F; padding:2px 6px; border-radius:4px;">Wholesale B2B</span></td>
                                    <td>Pure Dola Silk Lot (Qty: 24 pcs)</td>
                                    <td><strong>₹33,576</strong><br><small style="color:#15803D;">Bank Wire</small></td>
                                    <td><span class="adm-badge gold">Packed</span></td>
                                    <td>
                                        <button class="adm-action-btn wa" title="Send WhatsApp Tracking" onclick="window.sendOrderWhatsApp('ORD-9841')">
                                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 2: PRODUCTS & CATALOG MANAGEMENT
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-products">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">Products & Inventory Catalog</h1>
                        <p class="adm-page-subtitle">Manage B2C Retail & B2B Wholesale pricing, MOQ rules, stock alerts, and fabric specs.</p>
                    </div>
                    <div class="adm-page-actions">
                        <button class="adm-btn-secondary" onclick="window.exportTableToCSV('products')">
                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Export Catalog CSV</span>
                        </button>
                        <button class="adm-btn-primary" onclick="openAddProductModal()">
                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2.5" fill="none"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>+ Add New Product</span>
                        </button>
                    </div>
                </div>

                <div class="adm-table-card">
                    <!-- Table Search & Filters Toolbar -->
                    <div class="adm-table-toolbar">
                        <!-- Strict Rule: Left Search Icon & Right Clear Button -->
                        <div class="adm-search-box" style="max-width:320px;">
                            <svg class="adm-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="admProdSearch" class="adm-search-input" placeholder="Search product name, SKU, fabric...">
                            <button type="button" id="admProdSearchClear" class="adm-search-clear">✕</button>
                        </div>

                        <div class="adm-table-filters">
                            <select id="admProdCatFilter" class="adm-filter-select" onchange="filterProducts()">
                                <option value="all">All Categories</option>
                                <option value="Sarees">Sarees</option>
                                <option value="Kurtis">Kurtis</option>
                                <option value="Lehengas">Lehengas</option>
                                <option value="Gowns">Gowns</option>
                                <option value="Dress Materials">Dress Materials</option>
                            </select>

                            <select id="admProdStockFilter" class="adm-filter-select" onchange="filterProducts()">
                                <option value="all">All Stock Status</option>
                                <option value="In Stock">In Stock</option>
                                <option value="Low Stock">Low Stock</option>
                                <option value="Out of Stock">Out of Stock</option>
                            </select>
                        </div>
                    </div>

                    <!-- Products Table View -->
                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Product Details</th>
                                    <th>Category</th>
                                    <th>Pricing (Retail / Wholesale)</th>
                                    <th>Wholesale MOQ</th>
                                    <th>Stock Units</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="admProductsTableBody">
                                <!-- Rendered dynamically by admin.js -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 3: ORDERS & LOGISTICS MANAGEMENT
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-orders">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">Multi-Channel Orders & Consignments</h1>
                        <p class="adm-page-subtitle">Track dispatches, print GST invoices, and notify customers via automated WhatsApp links.</p>
                    </div>
                    <div class="adm-page-actions">
                        <button class="adm-btn-secondary" onclick="window.exportTableToCSV('orders')">
                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Export All Orders</span>
                        </button>
                    </div>
                </div>

                <div class="adm-table-card">
                    <div class="adm-table-toolbar">
                        <!-- Strict Rule: Left Search Icon & Right Clear Button -->
                        <div class="adm-search-box" style="max-width:320px;">
                            <svg class="adm-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="admOrderSearch" class="adm-search-input" placeholder="Search order ID, customer, phone...">
                            <button type="button" id="admOrderSearchClear" class="adm-search-clear">✕</button>
                        </div>

                        <div class="adm-table-filters">
                            <select id="admOrderChannelFilter" class="adm-filter-select" onchange="filterOrders()">
                                <option value="all">All Channels</option>
                                <option value="B2C Shop">B2C Shop</option>
                                <option value="Wholesale">Wholesale B2B</option>
                                <option value="Reseller">Reseller</option>
                                <option value="Retailer">Retailer</option>
                            </select>

                            <select id="admOrderStatusFilter" class="adm-filter-select" onchange="filterOrders()">
                                <option value="all">All Statuses</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Packed">Packed</option>
                                <option value="In Transit">In Transit</option>
                                <option value="Delivered">Delivered</option>
                            </select>
                        </div>
                    </div>

                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Order ID & Date</th>
                                    <th>Customer & City</th>
                                    <th>Sales Channel</th>
                                    <th>Order Items</th>
                                    <th>Amount & Payment</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="admOrdersTableBody">
                                <!-- Rendered dynamically by admin.js -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 4: WHATSAPP CRM & BROADCAST CAMPAIGNS
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-whatsapp">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">
                            <span>WhatsApp CRM & Broadcast Hub</span>
                            <span class="adm-badge" style="background:#DCFCE7; color:#15803D;">● Connected</span>
                        </h1>
                        <p class="adm-page-subtitle">Engage customers, convert wholesale catalog inquiries, and broadcast promotional campaigns.</p>
                    </div>
                </div>

                <div class="adm-wa-grid">
                    <!-- Left: Incoming Leads & Inquiries -->
                    <div class="adm-card">
                        <div class="adm-card-head">
                            <h3 class="adm-card-title">
                                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                                <span>Recent WhatsApp Inquiries</span>
                            </h3>
                            <span class="adm-badge green">4 New Leads</span>
                        </div>
                        <div class="adm-wa-lead-list" id="admWaLeadsList">
                            <!-- Rendered dynamically by admin.js -->
                        </div>
                    </div>

                    <!-- Right: Campaign Broadcaster -->
                    <div class="adm-card">
                        <div class="adm-card-head">
                            <h3 class="adm-card-title">
                                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><polygon points="3 11 22 2 13 21 11 13 3 11"></polygon></svg>
                                <span>Broadcast Campaign Composer</span>
                            </h3>
                        </div>

                        <div style="display:flex; flex-direction:column; gap:12px;">
                            <div class="adm-form-group">
                                <label class="adm-form-label">Select Campaign Template</label>
                                <select id="admBroadcastTemplate" class="adm-form-select">
                                    <option value="catalogue">✨ Luxury Ethnic Fresh Catalogue 2026</option>
                                    <option value="festive">🔥 Festive Bonanza — 40% Off Wholesale</option>
                                    <option value="wholesale_drop">💎 Bulk Lot Price Drop Alert</option>
                                </select>
                            </div>

                            <div class="adm-form-group">
                                <label class="adm-form-label">Target Audience Group</label>
                                <select id="admBroadcastAudience" class="adm-form-select">
                                    <option value="all">All Contacts (1,420 Verified)</option>
                                    <option value="wholesalers">Verified Wholesalers Only (285)</option>
                                    <option value="resellers">Active Resellers (420)</option>
                                    <option value="vip">VIP Retail Customers (715)</option>
                                </select>
                            </div>

                            <div class="adm-form-group">
                                <label class="adm-form-label">Message Content (Dynamic Variables Supported)</label>
                                <textarea id="admBroadcastMessage" class="adm-form-textarea" rows="4">✨ *DT BRAND'S LUXURY ETHNIC FRESH CATALOGUE* ✨

Dear {Name},
Explore our latest 2026 Pure Silk Sarees & Designer Lehengas crafted for premium festive collections.

👉 *View & Order Online:* https://jaihanumantex.in/Frontend/Shop/shop.php

_Special 15% VIP Discount Applied!_</textarea>
                            </div>

                            <!-- Live WhatsApp Bubble Preview -->
                            <div class="adm-form-group">
                                <label class="adm-form-label">Live WhatsApp Chat Preview</label>
                                <div class="adm-wa-preview-bubble" id="admBroadcastPreview">
                                    ✨ <strong>DT BRAND'S LUXURY ETHNIC FRESH CATALOGUE</strong> ✨<br><br>
                                    Dear Rajesh Kumar,<br>
                                    Explore our latest 2026 Pure Silk Sarees &amp; Designer Lehengas crafted for premium festive collections.<br><br>
                                    👉 <strong>View &amp; Order Online:</strong> https://jaihanumantex.in/Frontend/Shop/shop.php<br><br>
                                    <em>Special 15% VIP Discount Applied!</em>
                                </div>
                            </div>

                            <button class="adm-btn-primary" style="justify-content:center; padding:12px;" onclick="window.launchBroadcast()">
                                <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2.5" fill="none"><polygon points="3 11 22 2 13 21 11 13 3 11"></polygon></svg>
                                <span>Launch WhatsApp Broadcast</span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 5: WHOLESALERS & RESELLERS PARTNER HUB
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-partners">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">B2B Wholesalers & Reseller Network</h1>
                        <p class="adm-page-subtitle">Verify partner KYC, review GST numbers, assign volume discount tiers, and manage commission payouts.</p>
                    </div>
                </div>

                <div class="adm-table-card">
                    <div class="adm-table-toolbar">
                        <!-- Strict Rule: Left Search Icon & Right Clear Button -->
                        <div class="adm-search-box" style="max-width:320px;">
                            <svg class="adm-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="admPartnerSearch" class="adm-search-input" placeholder="Search partner name, GST, phone...">
                            <button type="button" id="admPartnerSearchClear" class="adm-search-clear">✕</button>
                        </div>
                    </div>

                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Partner ID</th>
                                    <th>Business / Contact Name</th>
                                    <th>Partner Type</th>
                                    <th>Pricing Tier</th>
                                    <th>GSTIN Number</th>
                                    <th>Total Business</th>
                                    <th>KYC Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="admPartnersTableBody">
                                <!-- Rendered dynamically by admin.js -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 6: CUSTOMER CRM DIRECTORY
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-customers">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">Customer CRM Directory</h1>
                        <p class="adm-page-subtitle">Complete directory of B2C and retail buyers with lifetime order history.</p>
                    </div>
                </div>

                <div class="adm-table-card">
                    <div class="adm-table-toolbar">
                        <div class="adm-search-box" style="max-width:320px;">
                            <svg class="adm-search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" id="admCustomerSearch" class="adm-search-input" placeholder="Search customer name or phone...">
                            <button type="button" id="admCustomerSearchClear" class="adm-search-clear">✕</button>
                        </div>
                    </div>

                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>Customer Name</th>
                                    <th>Phone & Email</th>
                                    <th>City & State</th>
                                    <th>Total Orders</th>
                                    <th>Lifetime Value</th>
                                    <th>Customer Tag</th>
                                    <th>Direct Action</th>
                                </tr>
                            </thead>
                            <tbody id="admCustomersTableBody">
                                <tr>
                                    <td><strong>Ananya Sharma</strong></td>
                                    <td>+91 9876543210<br><small style="color:#7A7266;">ananya@gmail.com</small></td>
                                    <td>Mumbai, MH</td>
                                    <td>6 Orders</td>
                                    <td><strong>₹28,450</strong></td>
                                    <td><span class="adm-badge gold">VIP Retail</span></td>
                                    <td>
                                        <button class="adm-action-btn wa" title="WhatsApp Customer" onclick="window.openDirectWhatsApp('9876543210', 'Namaste Ananya ji, regarding your order with DT Brand...')">
                                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Sneha Patel</strong></td>
                                    <td>+91 9428019283<br><small style="color:#7A7266;">sneha.patel@yahoo.com</small></td>
                                    <td>Ahmedabad, GJ</td>
                                    <td>4 Orders</td>
                                    <td><strong>₹16,900</strong></td>
                                    <td><span class="adm-badge info">Frequent Buyer</span></td>
                                    <td>
                                        <button class="adm-action-btn wa" title="WhatsApp Customer" onclick="window.openDirectWhatsApp('9428019283', 'Namaste Sneha ji, from DT Brand...')">
                                            <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 7: SALES & GST REPORTS
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-reports">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">Sales, GST & Tax Reports</h1>
                        <p class="adm-page-subtitle">Monthly HSN-wise tax breakdowns, IGST, CGST, SGST ledgers, and exportable accounts.</p>
                    </div>
                </div>

                <div class="adm-kpi-grid">
                    <div class="adm-kpi-card">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Taxable Turnover</span>
                            <div class="adm-kpi-icon-box">📊</div>
                        </div>
                        <div class="adm-kpi-val">₹38,96,270</div>
                        <div class="adm-kpi-bottom"><span class="adm-kpi-subtext">Current Fiscal Month</span></div>
                    </div>
                    <div class="adm-kpi-card">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Total GST Output (5% / 12%)</span>
                            <div class="adm-kpi-icon-box green">📜</div>
                        </div>
                        <div class="adm-kpi-val">₹2,89,630</div>
                        <div class="adm-kpi-bottom"><span class="adm-kpi-subtext">CGST: ₹1.44L | SGST: ₹1.44L</span></div>
                    </div>
                    <div class="adm-kpi-card">
                        <div class="adm-kpi-top">
                            <span class="adm-kpi-label">Integrated Tax (IGST)</span>
                            <div class="adm-kpi-icon-box blue">🌐</div>
                        </div>
                        <div class="adm-kpi-val">₹1,00,000</div>
                        <div class="adm-kpi-bottom"><span class="adm-kpi-subtext">Inter-state Consignments</span></div>
                    </div>
                </div>

                <div class="adm-table-card" style="margin-top:16px;">
                    <div class="adm-table-toolbar">
                        <h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">HSN Code Wise Tax Breakdown</h3>
                        <button class="adm-btn-secondary" onclick="window.exportTableToCSV('orders')">
                            <span>Download Tax Audit CSV</span>
                        </button>
                    </div>
                    <div class="adm-table-responsive">
                        <table class="adm-table">
                            <thead>
                                <tr>
                                    <th>HSN Code</th>
                                    <th>Description</th>
                                    <th>GST Rate</th>
                                    <th>Total Quantity</th>
                                    <th>Taxable Value</th>
                                    <th>Total Tax Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><code>5007</code></td>
                                    <td>Pure Silk & Handloom Sarees</td>
                                    <td>5%</td>
                                    <td>840 pcs</td>
                                    <td>₹24,50,000</td>
                                    <td><strong>₹1,22,500</strong></td>
                                </tr>
                                <tr>
                                    <td><code>6204</code></td>
                                    <td>Kurtis, Sharara Sets & Lehengas</td>
                                    <td>5% / 12%</td>
                                    <td>620 pcs</td>
                                    <td>₹11,46,270</td>
                                    <td><strong>₹1,17,130</strong></td>
                                </tr>
                                <tr>
                                    <td><code>5208</code></td>
                                    <td>Cotton Dress Materials & Unstitched Suits</td>
                                    <td>5%</td>
                                    <td>390 pcs</td>
                                    <td>₹3,00,000</td>
                                    <td><strong>₹15,000</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- ═══════════════════════════════════════════════════════════
                 TAB 8: STORE & SYSTEM SETTINGS
            ════════════════════════════════════════════════════════════ -->
            <section class="adm-tab-panel" id="tab-settings">
                <div class="adm-page-head">
                    <div class="adm-page-title-group">
                        <h1 class="adm-page-title">Store Profile & Gateway Settings</h1>
                        <p class="adm-page-subtitle">Configure business details, WhatsApp CRM API credentials, and courier shipping integrations.</p>
                    </div>
                </div>

                <div class="adm-charts-grid">
                    <!-- Business Profile Info -->
                    <div class="adm-card">
                        <h3 class="adm-card-title">🏢 Brand & Legal Profile</h3>
                        <form onsubmit="event.preventDefault(); window.showToast('Store settings saved successfully!');" style="display:flex; flex-direction:column; gap:12px;">
                            <div class="adm-form-grid">
                                <div class="adm-form-group">
                                    <label class="adm-form-label">Brand Name</label>
                                    <input type="text" class="adm-form-input" value="DT Brand's (Jai Hanuman Tex)">
                                </div>
                                <div class="adm-form-group">
                                    <label class="adm-form-label">GSTIN Number</label>
                                    <input type="text" class="adm-form-input" value="24AAACR4920M1Z2">
                                </div>
                                <div class="adm-form-group full">
                                    <label class="adm-form-label">Registered Warehouse Address</label>
                                    <input type="text" class="adm-form-input" value="Ring Road Textile Market, Surat, Gujarat - 395002">
                                </div>
                                <div class="adm-form-group">
                                    <label class="adm-form-label">Support WhatsApp Number</label>
                                    <input type="text" class="adm-form-input" value="+91 98220 19283">
                                </div>
                                <div class="adm-form-group">
                                    <label class="adm-form-label">Support Email</label>
                                    <input type="email" class="adm-form-input" value="support@jaihanumantex.in">
                                </div>
                            </div>
                            <button type="submit" class="adm-btn-primary" style="margin-top:10px; align-self:flex-start;">
                                <span>Save Changes</span>
                            </button>
                        </form>
                    </div>

                    <!-- Logistics & WhatsApp Gateways -->
                    <div class="adm-card">
                        <h3 class="adm-card-title">🚚 Courier & WhatsApp Gateways</h3>
                        <div style="display:flex; flex-direction:column; gap:14px; font-size:0.82rem;">
                            <div style="padding:10px; background:#FAF5E8; border:1px solid rgba(212,175,55,0.3); border-radius:8px;">
                                <strong style="color:#8A681F;">WhatsApp Cloud API Status</strong>
                                <p style="font-size:0.75rem; color:#5A4210; margin-top:2px;">Webhook Connected • 99.98% Deliverability</p>
                            </div>
                            <div style="padding:10px; background:#F8F6F0; border:1px solid #E5E1D7; border-radius:8px;">
                                <strong>Logistics Partners Configured</strong>
                                <p style="font-size:0.75rem; color:#7A7266; margin-top:2px;">Delhivery Surface, BlueDart Express, TCI Freight Cargo</p>
                            </div>
                            <div style="padding:10px; background:#DCFCE7; border:1px solid #BBF7D0; border-radius:8px;">
                                <strong style="color:#15803D;">SSL Security & Backup</strong>
                                <p style="font-size:0.75rem; color:#166534; margin-top:2px;">256-bit Encrypted • Hourly Automated Cloud Sync</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </main>

        <!-- ══ BOTTOM STATUS FOOTER ══ -->
        <?php include_once __DIR__ . '/Includes/adminfooter.php'; ?>

    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     MODAL: ADD / EDIT PRODUCT
════════════════════════════════════════════════════════════ -->
<div class="adm-modal-backdrop" id="admProductModal">
    <div class="adm-modal-box">
        <div class="adm-modal-head">
            <h3 class="adm-modal-title" id="admProductModalTitle">Add New Product</h3>
            <button type="button" class="adm-modal-close-btn" onclick="closeAdmModal('admProductModal')">✕</button>
        </div>
        <form onsubmit="saveProductForm(event)">
            <div class="adm-modal-body">
                <input type="hidden" id="admProductId">
                <div class="adm-form-grid">
                    <div class="adm-form-group full">
                        <label class="adm-form-label">Product Title *</label>
                        <input type="text" id="admProductName" class="adm-form-input" placeholder="e.g. Pure Kanjivaram Bridal Art Silk Saree" required>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">SKU Code *</label>
                        <input type="text" id="admProductSku" class="adm-form-input" placeholder="KLN-SR-112" required>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">HSN Code *</label>
                        <input type="text" id="admProductHsn" class="adm-form-input" placeholder="5007" required>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Category *</label>
                        <select id="admProductCategory" class="adm-form-select">
                            <option value="Sarees">Sarees</option>
                            <option value="Kurtis">Kurtis</option>
                            <option value="Lehengas">Lehengas</option>
                            <option value="Gowns">Gowns</option>
                            <option value="Dress Materials">Dress Materials</option>
                        </select>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Fabric Specification</label>
                        <input type="text" id="admProductFabric" class="adm-form-input" placeholder="Pure Silk / Georgette / Rayon">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">B2C Retail Price (₹) *</label>
                        <input type="number" id="admProductRetailPrice" class="adm-form-input" placeholder="3499" required>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">B2B Wholesale Price (₹) *</label>
                        <input type="number" id="admProductWholesalePrice" class="adm-form-input" placeholder="1399" required>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Minimum Order Qty (MOQ)</label>
                        <input type="number" id="admProductMoq" class="adm-form-input" placeholder="8" value="8">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Available Stock (Units)</label>
                        <input type="number" id="admProductStock" class="adm-form-input" placeholder="100" value="50">
                    </div>
                    <div class="adm-form-group full">
                        <label class="adm-form-label">Stock Status</label>
                        <select id="admProductStatus" class="adm-form-select">
                            <option value="In Stock">In Stock</option>
                            <option value="Low Stock">Low Stock</option>
                            <option value="Out of Stock">Out of Stock</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="adm-modal-foot">
                <button type="button" class="adm-btn-secondary" onclick="closeAdmModal('admProductModal')">Cancel</button>
                <button type="submit" class="adm-btn-primary">Save Product</button>
            </div>
        </form>
    </div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     MODAL: GST INVOICE VIEW & PRINT
════════════════════════════════════════════════════════════ -->
<div class="adm-modal-backdrop" id="admInvoiceModal">
    <div class="adm-modal-box" style="max-width:620px;">
        <div class="adm-modal-head">
            <h3 class="adm-modal-title">Tax Invoice — DT Brand's</h3>
            <button type="button" class="adm-modal-close-btn" onclick="closeAdmModal('admInvoiceModal')">✕</button>
        </div>
        <div class="adm-modal-body" style="background:#FFFFFF; font-size:0.84rem;">
            <div style="display:flex; justify-content:space-between; border-bottom:1.5px solid #8A681F; padding-bottom:12px;">
                <div>
                    <h2 style="font-family:var(--adm-font-serif); color:#8A681F; font-size:1.2rem;">DT BRAND'S</h2>
                    <p style="font-size:0.72rem; color:#7A7266;">Jai Hanuman Tex • GSTIN: 24AAACR4920M1Z2<br>Ring Road, Surat, Gujarat</p>
                </div>
                <div style="text-align:right;">
                    <strong>Invoice #: <span id="invOrderNumber">ORD-9842</span></strong><br>
                    <small style="color:#7A7266;">Date: <span id="invOrderDate">Today</span></small>
                </div>
            </div>

            <div style="margin-top:12px; display:flex; justify-content:space-between;">
                <div>
                    <strong style="color:#8A681F; font-size:0.76rem; text-transform:uppercase;">Billed To:</strong><br>
                    <strong id="invCustomerName">Customer Name</strong><br>
                    <span id="invCustomerPhone">+91 9876543210</span><br>
                    <span id="invCustomerCity">City, State</span>
                </div>
                <div style="text-align:right;">
                    <strong style="color:#8A681F; font-size:0.76rem; text-transform:uppercase;">Payment:</strong><br>
                    <span>Status: <strong>PAID</strong></span>
                </div>
            </div>

            <div style="margin-top:16px; border-top:1px solid #E5E1D7; padding-top:12px;">
                <table style="width:100%; font-size:0.8rem; border-collapse:collapse;">
                    <thead>
                        <tr style="border-bottom:1px solid #E5E1D7; color:#7A7266; text-align:left;">
                            <th style="padding:6px 0;">Item Description</th>
                            <th style="padding:6px 0; text-align:right;">Amount (INR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding:10px 0;" id="invItemDesc">Product Name</td>
                            <td style="padding:10px 0; text-align:right;" id="invItemTotal">₹4,899</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="border-top:1.5px solid #8A681F; font-weight:800; font-size:0.95rem;">
                            <td style="padding:10px 0;">Grand Total (Incl. GST):</td>
                            <td style="padding:10px 0; text-align:right; color:#8A681F;" id="invGrandTotal">₹4,899</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="adm-modal-foot">
            <button type="button" class="adm-btn-secondary" onclick="window.print()">🖨️ Print Invoice</button>
            <button type="button" class="adm-btn-primary" onclick="closeAdmModal('admInvoiceModal')">Close</button>
        </div>
    </div>
</div>

<!-- Admin JavaScript Engine -->
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>

</body>
</html>
