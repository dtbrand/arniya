<?php
/**
 * index.php — ARNIYA Master Executive Admin Dashboard UI
 * Complete 38-Section Production-Quality Command Center
 * DT Brand's & Jai Hanuman Tex
 */

$page_title = 'Dashboard';
$active_nav = 'dashboard';
$extra_css = ['/Admin/dashboard/dashboard.css'];
$extra_js = ['/Admin/dashboard/dashboard.js'];

include_once __DIR__ . '/../includes/header.php';
include_once __DIR__ . '/../includes/sidebar.php';
?>

<!-- ══ MAIN CONTENT WRAPPER ══ -->
<div class="adm-main">
    <?php include_once __DIR__ . '/../includes/topbar.php'; ?>

    <main class="adm-content-container">

        <!-- ═══════════════════════════════════════════════════════════
             1. DASHBOARD HEADER & GLOBAL CONTROLS
        ════════════════════════════════════════════════════════════ -->
        <section class="adm-dash-header">
            <div class="adm-dash-title-group">
                <?php include_once __DIR__ . '/../includes/breadcrumbs.php'; ?>
                <h1 class="adm-dash-title">
                    <span>Dashboard</span>
                    <span class="adm-badge gold" style="font-size:0.68rem;">ARNIYA Master Console</span>
                </h1>
                <p class="adm-dash-subtitle">Overview of your ARNIYA business • Surat B2B Wholesale, Resellers, Retailers & B2C Commerce.</p>
            </div>

            <!-- Date Range Controls & Actions -->
            <div class="adm-dash-controls">
                <div class="adm-date-pills">
                    <button type="button" class="adm-date-pill" data-range="today">Today</button>
                    <button type="button" class="adm-date-pill" data-range="yesterday">Yesterday</button>
                    <button type="button" class="adm-date-pill" data-range="7d">7 Days</button>
                    <button type="button" class="adm-date-pill active" data-range="30d">30 Days</button>
                    <button type="button" class="adm-date-pill" data-range="this_month">This Month</button>
                    <button type="button" class="adm-date-pill" data-range="last_month">Last Month</button>
                    <button type="button" class="adm-date-pill" data-range="this_year">This Year</button>
                </div>
                <button type="button" class="adm-btn-secondary" onclick="window.openAdmModal('admCustomizeModal')" title="Customize Widgets">
                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    <span>Customize</span>
                </button>
                <button type="button" class="adm-btn-primary" onclick="window.openAdmModal('admExportModal')">
                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Export Dashboard</span>
                </button>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════════════════
             2. LIVE BUSINESS STATUS TICKER
        ════════════════════════════════════════════════════════════ -->
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

        <!-- ═══════════════════════════════════════════════════════════
             3. MAIN 22 KPI CARDS (DIVERSE VISUAL HIERARCHY)
        ════════════════════════════════════════════════════════════ -->
        <section class="adm-kpi-grid">
            <!-- 1. Total Revenue (Primary Highlight) -->
            <div class="adm-kpi-card primary" onclick="location.href='/Admin/reports/revenue.php'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Total Revenue</span>
                    <div class="adm-kpi-icon-box">💰</div>
                </div>
                <div class="adm-kpi-value">₹42,85,900</div>
                <div class="adm-kpi-bottom">
                    <span class="adm-kpi-trend up">↑ +18.4%</span>
                    <div class="adm-kpi-sparkline" data-trend="up"></div>
                </div>
            </div>

            <!-- 2. Today's Revenue -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/reports/sales.php'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Today's Revenue</span>
                    <div class="adm-kpi-icon-box emerald">💵</div>
                </div>
                <div class="adm-kpi-value">₹1,84,500</div>
                <div class="adm-kpi-bottom">
                    <span class="adm-kpi-trend up">↑ +12.1%</span>
                    <div class="adm-kpi-sparkline" data-trend="up"></div>
                </div>
            </div>

            <!-- 3. Monthly Revenue -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/reports/revenue.php'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Monthly Revenue</span>
                    <div class="adm-kpi-icon-box">📈</div>
                </div>
                <div class="adm-kpi-value">₹38,20,000</div>
                <div class="adm-kpi-bottom">
                    <span class="adm-kpi-trend up">↑ +24.8%</span>
                    <div class="adm-kpi-sparkline" data-trend="up"></div>
                </div>
            </div>

            <!-- 4. Gross Profit -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/reports/'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Gross Profit</span>
                    <div class="adm-kpi-icon-box emerald">📊</div>
                </div>
                <div class="adm-kpi-value">₹14,92,400</div>
                <div class="adm-kpi-bottom">
                    <span class="adm-kpi-trend up">↑ +15.2% (34.8%)</span>
                    <div class="adm-kpi-sparkline" data-trend="up"></div>
                </div>
            </div>

            <!-- 5. Net Profit -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/reports/'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Net Profit</span>
                    <div class="adm-kpi-icon-box">💎</div>
                </div>
                <div class="adm-kpi-value">₹11,45,200</div>
                <div class="adm-kpi-bottom">
                    <span class="adm-kpi-trend up">↑ +11.8% (26.7%)</span>
                    <div class="adm-kpi-sparkline" data-trend="up"></div>
                </div>
            </div>

            <!-- 6. Total Orders -->
            <div class="adm-kpi-card primary" onclick="location.href='/Admin/orders/'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Total Orders</span>
                    <div class="adm-kpi-icon-box sky">📦</div>
                </div>
                <div class="adm-kpi-value">1,624</div>
                <div class="adm-kpi-bottom">
                    <span class="adm-kpi-trend up">↑ +14.6%</span>
                    <div class="adm-kpi-sparkline" data-trend="up"></div>
                </div>
            </div>

            <!-- 7. Today's Orders -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/orders/'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Today's Orders</span>
                    <div class="adm-kpi-icon-box sky">⚡</div>
                </div>
                <div class="adm-kpi-value">38</div>
                <div class="adm-kpi-bottom">
                    <span class="adm-kpi-trend up">↑ +8 vs Yest.</span>
                    <div class="adm-kpi-sparkline" data-trend="up"></div>
                </div>
            </div>

            <!-- 8. Pending Orders -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/orders/pending.php'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Pending Orders</span>
                    <div class="adm-kpi-icon-box rose">⏳</div>
                </div>
                <div class="adm-kpi-value" style="color:var(--adm-rose);">18</div>
                <div class="adm-kpi-bottom">
                    <span>Requires Dispatch</span>
                    <span class="adm-badge rose">Action Needed</span>
                </div>
            </div>

            <!-- 9. Completed Orders -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/orders/delivered.php'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Completed Orders</span>
                    <div class="adm-kpi-icon-box emerald">✅</div>
                </div>
                <div class="adm-kpi-value">1,542</div>
                <div class="adm-kpi-bottom">
                    <span class="adm-kpi-trend up">94.9% Success</span>
                    <div class="adm-kpi-sparkline" data-trend="up"></div>
                </div>
            </div>

            <!-- 10. Cancelled Orders -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/orders/cancelled.php'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Cancelled Orders</span>
                    <div class="adm-kpi-icon-box rose">❌</div>
                </div>
                <div class="adm-kpi-value">64</div>
                <div class="adm-kpi-bottom">
                    <span class="adm-kpi-trend down">↓ 3.9% Rate</span>
                    <div class="adm-kpi-sparkline" data-trend="down"></div>
                </div>
            </div>

            <!-- 11. Total Customers -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/customers/'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Total Customers</span>
                    <div class="adm-kpi-icon-box violet">👥</div>
                </div>
                <div class="adm-kpi-value">4,820</div>
                <div class="adm-kpi-bottom">
                    <span class="adm-kpi-trend up">↑ +210 This Mo</span>
                    <div class="adm-kpi-sparkline" data-trend="up"></div>
                </div>
            </div>

            <!-- 12. New Customers -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/customers/'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">New Customers (30D)</span>
                    <div class="adm-kpi-icon-box violet">✨</div>
                </div>
                <div class="adm-kpi-value">348</div>
                <div class="adm-kpi-bottom">
                    <span class="adm-kpi-trend up">↑ +18.2%</span>
                    <div class="adm-kpi-sparkline" data-trend="up"></div>
                </div>
            </div>

            <!-- 13. Total Resellers -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/resellers/'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Total Resellers</span>
                    <div class="adm-kpi-icon-box violet">🤝</div>
                </div>
                <div class="adm-kpi-value">348</div>
                <div class="adm-kpi-bottom">
                    <span class="adm-kpi-trend up">₹4.8L Payouts</span>
                    <span class="adm-badge gold">Active Hub</span>
                </div>
            </div>

            <!-- 14. Total Retailers -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/retailers/'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Total Retailers</span>
                    <div class="adm-kpi-icon-box sky">🏬</div>
                </div>
                <div class="adm-kpi-value">124</div>
                <div class="adm-kpi-bottom">
                    <span class="adm-kpi-trend up">↑ +12% Growth</span>
                    <div class="adm-kpi-sparkline" data-trend="up"></div>
                </div>
            </div>

            <!-- 15. Total Wholesalers -->
            <div class="adm-kpi-card primary" onclick="location.href='/Admin/wholesalers/'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Total Wholesalers</span>
                    <div class="adm-kpi-icon-box">🏢</div>
                </div>
                <div class="adm-kpi-value">46</div>
                <div class="adm-kpi-bottom">
                    <span class="adm-kpi-trend up">68 Consignments</span>
                    <span class="adm-badge emerald">Tier 1 VIP</span>
                </div>
            </div>

            <!-- 16. Total Products -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/products/'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Total Products</span>
                    <div class="adm-kpi-icon-box">👗</div>
                </div>
                <div class="adm-kpi-value">1,240</div>
                <div class="adm-kpi-bottom">
                    <span>16 Categories</span>
                    <span class="adm-badge gold">Surat Catalog</span>
                </div>
            </div>

            <!-- 17. Active Products -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/products/'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Active In Stock</span>
                    <div class="adm-kpi-icon-box emerald">🟢</div>
                </div>
                <div class="adm-kpi-value">1,185</div>
                <div class="adm-kpi-bottom">
                    <span class="adm-kpi-trend up">95.5% In Stock</span>
                    <div class="adm-kpi-sparkline" data-trend="up"></div>
                </div>
            </div>

            <!-- 18. Low Stock Items -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/inventory/low-stock.php'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Low Stock</span>
                    <div class="adm-kpi-icon-box" style="background:#FEF3C7; color:#D97706;">⚠️</div>
                </div>
                <div class="adm-kpi-value" style="color:var(--adm-amber);">14</div>
                <div class="adm-kpi-bottom">
                    <span>Threshold &lt; 5 pcs</span>
                    <span class="adm-badge amber">Re-order</span>
                </div>
            </div>

            <!-- 19. Out of Stock -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/inventory/out-of-stock.php'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Out of Stock</span>
                    <div class="adm-kpi-icon-box rose">🛑</div>
                </div>
                <div class="adm-kpi-value" style="color:var(--adm-rose);">41</div>
                <div class="adm-kpi-bottom">
                    <span>Restock Pending</span>
                    <span class="adm-badge rose">Urgent</span>
                </div>
            </div>

            <!-- 20. Pending Payments -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/payments/pending.php'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Pending Payments</span>
                    <div class="adm-kpi-icon-box">💳</div>
                </div>
                <div class="adm-kpi-value">₹48,200</div>
                <div class="adm-kpi-bottom">
                    <span>14 Invoices</span>
                    <span class="adm-badge gold">Net 15</span>
                </div>
            </div>

            <!-- 21. Refund Requests -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/payments/refunds.php'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Refund Requests</span>
                    <div class="adm-kpi-icon-box rose">🔄</div>
                </div>
                <div class="adm-kpi-value">3</div>
                <div class="adm-kpi-bottom">
                    <span>₹6,400 Value</span>
                    <span class="adm-badge rose">Pending</span>
                </div>
            </div>

            <!-- 22. Return Requests -->
            <div class="adm-kpi-card" onclick="location.href='/Admin/orders/returns.php'">
                <div class="adm-kpi-top">
                    <span class="adm-kpi-label">Return Requests</span>
                    <div class="adm-kpi-icon-box rose">↩️</div>
                </div>
                <div class="adm-kpi-value">5</div>
                <div class="adm-kpi-bottom">
                    <span>Quality Inspection</span>
                    <span class="adm-badge rose">Pending</span>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════════════════
             4. PRIMARY SALES & REVENUE ANALYTICS INTERACTIVE CHART
        ════════════════════════════════════════════════════════════ -->
        <section class="adm-grid-2col">
            <!-- Left: Sales Chart -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <div class="adm-card-title-wrap">
                        <h2 class="adm-card-title">📈 Multi-Channel Revenue & Profit Analytics</h2>
                        <span class="adm-badge gold">Interactive</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <div class="adm-date-pills">
                            <button type="button" class="adm-date-pill adm-metric-toggle active" data-metric="revenue">Revenue</button>
                            <button type="button" class="adm-date-pill adm-metric-toggle" data-metric="orders">Orders</button>
                            <button type="button" class="adm-date-pill adm-metric-toggle" data-metric="profit">Profit</button>
                        </div>
                    </div>
                </div>
                <div class="adm-chart-box">
                    <canvas id="admRevenueChart"></canvas>
                </div>
                <div class="adm-chart-legend" style="margin-top:14px; justify-content:center;">
                    <div class="adm-legend-item"><span class="adm-legend-dot" style="background:#8A681F;"></span> <span>Wholesale B2B (Gold)</span></div>
                    <div class="adm-legend-item"><span class="adm-legend-dot" style="background:#7C3AED;"></span> <span>Reseller Network (Purple)</span></div>
                    <div class="adm-legend-item"><span class="adm-legend-dot" style="background:#16A34A;"></span> <span>Direct B2C Shop (Green)</span></div>
                </div>
            </div>

            <!-- Right: Sales by Category Donut -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <div class="adm-card-title-wrap">
                        <h2 class="adm-card-title">👗 Sales by Category</h2>
                    </div>
                    <a href="/Admin/products/categories.php" class="adm-tbl-action-btn">View All</a>
                </div>
                <div class="adm-chart-box">
                    <canvas id="admCategoryChart"></canvas>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-top:12px; font-size:0.72rem;">
                    <div><span style="color:#8A681F; font-weight:800;">● 45%</span> Silk Sarees</div>
                    <div><span style="color:#D4AF37; font-weight:800;">● 25%</span> Bridal Lehengas</div>
                    <div><span style="color:#16A34A; font-weight:800;">● 18%</span> Kurtis & Sets</div>
                    <div><span style="color:#0284C7; font-weight:800;">● 12%</span> Fabrics</div>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════════════════
             5. ORDER STATUS PIPELINE VISUALIZATION
        ════════════════════════════════════════════════════════════ -->
        <section class="adm-card" style="margin-bottom:24px;">
            <div class="adm-card-head">
                <div class="adm-card-title-wrap">
                    <h2 class="adm-card-title">📦 Order Status Fulfillment Pipeline</h2>
                    <span class="adm-card-subtitle">Real-time order workflow across all channels</span>
                </div>
                <a href="/Admin/orders/" class="adm-tbl-action-btn">All Orders ↗</a>
            </div>
            <div class="adm-pipeline-wrap">
                <div class="adm-pipeline-step active" onclick="location.href='/Admin/orders/'">
                    <span class="adm-pipe-name">New</span>
                    <span class="adm-pipe-count">18</span>
                    <span class="adm-pipe-meta">Today</span>
                </div>
                <div class="adm-pipeline-step" onclick="location.href='/Admin/orders/pending.php'">
                    <span class="adm-pipe-name">Pending</span>
                    <span class="adm-pipe-count">12</span>
                    <span class="adm-pipe-meta">Payment Conf.</span>
                </div>
                <div class="adm-pipeline-step" onclick="location.href='/Admin/orders/processing.php'">
                    <span class="adm-pipe-name">Confirmed</span>
                    <span class="adm-pipe-count">42</span>
                    <span class="adm-pipe-meta">Warehouse</span>
                </div>
                <div class="adm-pipeline-step" onclick="location.href='/Admin/orders/processing.php'">
                    <span class="adm-pipe-name">Processing</span>
                    <span class="adm-pipe-count">29</span>
                    <span class="adm-pipe-meta">Picking</span>
                </div>
                <div class="adm-pipeline-step" onclick="location.href='/Admin/orders/shipped.php'">
                    <span class="adm-pipe-name">Packed</span>
                    <span class="adm-pipe-count">35</span>
                    <span class="adm-pipe-meta">Label Generated</span>
                </div>
                <div class="adm-pipeline-step" onclick="location.href='/Admin/orders/shipped.php'">
                    <span class="adm-pipe-name">Shipped</span>
                    <span class="adm-pipe-count">84</span>
                    <span class="adm-pipe-meta">In Transit</span>
                </div>
                <div class="adm-pipeline-step" onclick="location.href='/Admin/orders/shipped.php'">
                    <span class="adm-pipe-name">Out for Delivery</span>
                    <span class="adm-pipe-count">21</span>
                    <span class="adm-pipe-meta">Courier Hub</span>
                </div>
                <div class="adm-pipeline-step" onclick="location.href='/Admin/orders/delivered.php'">
                    <span class="adm-pipe-name">Delivered</span>
                    <span class="adm-pipe-count" style="color:var(--adm-emerald);">1,542</span>
                    <span class="adm-pipe-meta">94.9% Success</span>
                </div>
                <div class="adm-pipeline-step" onclick="location.href='/Admin/orders/cancelled.php'">
                    <span class="adm-pipe-name">Cancelled</span>
                    <span class="adm-pipe-count" style="color:var(--adm-rose);">64</span>
                    <span class="adm-pipe-meta">3.9% Rate</span>
                </div>
                <div class="adm-pipeline-step" onclick="location.href='/Admin/orders/returns.php'">
                    <span class="adm-pipe-name">Returned</span>
                    <span class="adm-pipe-count" style="color:var(--adm-amber);">5</span>
                    <span class="adm-pipe-meta">RTO Return</span>
                </div>
                <div class="adm-pipeline-step" onclick="location.href='/Admin/payments/refunds.php'">
                    <span class="adm-pipe-name">Refunded</span>
                    <span class="adm-pipe-count">3</span>
                    <span class="adm-pipe-meta">Settled</span>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════════════════
             6. SALES BY USER TYPE & CART FUNNEL ANALYTICS
        ════════════════════════════════════════════════════════════ -->
        <section class="adm-grid-equal-2col">
            <!-- Left: Sales by User Type -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <div class="adm-card-title-wrap">
                        <h2 class="adm-card-title">👥 Sales by User Type</h2>
                        <span class="adm-card-subtitle">Volume & growth across tiers</span>
                    </div>
                </div>
                <div class="adm-chart-box compact">
                    <canvas id="admUserTypeChart"></canvas>
                </div>
                <div style="display:flex; justify-content:space-between; margin-top:14px; padding-top:12px; border-top:1px solid var(--adm-border-card); font-size:0.75rem;">
                    <div>Average B2B Order: <strong style="color:var(--adm-gold);">₹64,500</strong></div>
                    <div>Average Reseller Order: <strong style="color:var(--adm-violet);">₹3,850</strong></div>
                    <div>Average B2C Order: <strong style="color:var(--adm-emerald);">₹2,299</strong></div>
                </div>
            </div>

            <!-- Right: Cart & Checkout Conversion Funnel -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <div class="adm-card-title-wrap">
                        <h2 class="adm-card-title">🛒 Cart & Checkout Conversion Funnel</h2>
                        <span class="adm-card-subtitle">Visitor journey drop-off analysis</span>
                    </div>
                    <span class="adm-badge emerald">7.8% Net Conversion</span>
                </div>
                <div class="adm-funnel-list">
                    <div class="adm-funnel-step">
                        <div class="adm-funnel-info">
                            <span>1. Product Views</span>
                            <span>28,400 visitors (100%)</span>
                        </div>
                        <div class="adm-funnel-bar-bg"><div class="adm-funnel-bar-fill" style="width:100%;"></div></div>
                    </div>
                    <div class="adm-funnel-step">
                        <div class="adm-funnel-info">
                            <span>2. Add to Cart</span>
                            <span>6,840 carts (24.1%)</span>
                        </div>
                        <div class="adm-funnel-bar-bg"><div class="adm-funnel-bar-fill" style="width:68%;"></div></div>
                    </div>
                    <div class="adm-funnel-step">
                        <div class="adm-funnel-info">
                            <span>3. Initiated Checkout</span>
                            <span>3,920 checkouts (13.8%)</span>
                        </div>
                        <div class="adm-funnel-bar-bg"><div class="adm-funnel-bar-fill" style="width:48%;"></div></div>
                    </div>
                    <div class="adm-funnel-step">
                        <div class="adm-funnel-info">
                            <span>4. Payment Attempt</span>
                            <span>2,410 attempts (8.5%)</span>
                        </div>
                        <div class="adm-funnel-bar-bg"><div class="adm-funnel-bar-fill" style="width:34%;"></div></div>
                    </div>
                    <div class="adm-funnel-step">
                        <div class="adm-funnel-info">
                            <span>5. Successful Order Completed</span>
                            <span style="color:var(--adm-emerald); font-weight:800;">1,624 orders (7.8%)</span>
                        </div>
                        <div class="adm-funnel-bar-bg"><div class="adm-funnel-bar-fill" style="width:25%; background:linear-gradient(90deg, #16A34A, #4ADE80);"></div></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════════════════
             7. TOP SELLING PRODUCTS & LOW STOCK CENTER
        ════════════════════════════════════════════════════════════ -->
        <section class="adm-grid-2col">
            <!-- Top Selling Products -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <div class="adm-card-title-wrap">
                        <h2 class="adm-card-title">🔥 Top Selling Products</h2>
                    </div>
                    <a href="/Admin/products/" class="adm-tbl-action-btn">Catalog ↗</a>
                </div>
                <div class="adm-table-wrap">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Units Sold</th>
                                <th>Revenue</th>
                                <th>Stock</th>
                                <th>Rating</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="adm-searchable-row">
                                <td>
                                    <div class="adm-tbl-product">
                                        <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="adm-tbl-thumb" alt="Saree">
                                        <div>
                                            <div class="adm-tbl-prod-name">Kanjivaram Pure Silk Saree</div>
                                            <div class="adm-tbl-sku">SKU: KLN-SR-111</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Silk Sarees</td>
                                <td><strong>342 pcs</strong></td>
                                <td>₹15,35,580</td>
                                <td><span class="adm-badge emerald">45 in stock</span></td>
                                <td>4.9 ★</td>
                                <td><span class="adm-badge emerald">Bestseller</span></td>
                            </tr>
                            <tr class="adm-searchable-row">
                                <td>
                                    <div class="adm-tbl-product">
                                        <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" class="adm-tbl-thumb" alt="Saree">
                                        <div>
                                            <div class="adm-tbl-prod-name">Banarasi Brocade Weave Saree</div>
                                            <div class="adm-tbl-sku">SKU: BNR-SR-204</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Banarasi</td>
                                <td><strong>218 pcs</strong></td>
                                <td>₹10,87,820</td>
                                <td><span class="adm-badge emerald">28 in stock</span></td>
                                <td>4.8 ★</td>
                                <td><span class="adm-badge emerald">Active</span></td>
                            </tr>
                            <tr class="adm-searchable-row">
                                <td>
                                    <div class="adm-tbl-product">
                                        <img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" class="adm-tbl-thumb" alt="Lehenga">
                                        <div>
                                            <div class="adm-tbl-prod-name">Crimson Bridal Zardosi Lehenga</div>
                                            <div class="adm-tbl-sku">SKU: BRD-LH-902</div>
                                        </div>
                                    </div>
                                </td>
                                <td>Bridal Lehengas</td>
                                <td><strong>84 pcs</strong></td>
                                <td>₹13,85,160</td>
                                <td><span class="adm-badge amber">4 left</span></td>
                                <td>5.0 ★</td>
                                <td><span class="adm-badge amber">Low Stock</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Low Stock Center -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <div class="adm-card-title-wrap">
                        <h2 class="adm-card-title">⚠️ Low Stock Warning Center</h2>
                    </div>
                    <a href="/Admin/inventory/low-stock.php" class="adm-tbl-action-btn">Inventory Hub ↗</a>
                </div>
                <div class="adm-table-wrap">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Item & SKU</th>
                                <th>Available</th>
                                <th>Threshold</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <strong>Chanderi Cotton Saree</strong>
                                    <div class="adm-tbl-sku">SKU: CHD-CT-109</div>
                                </td>
                                <td><strong style="color:var(--adm-rose);">2 pcs</strong></td>
                                <td>10 pcs</td>
                                <td><span class="adm-badge rose">Critical</span></td>
                                <td><a href="/Admin/inventory/adjustment.php" class="adm-tbl-action-btn">+ Restock</a></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Bridal Zardosi Lehenga</strong>
                                    <div class="adm-tbl-sku">SKU: BRD-LH-902</div>
                                </td>
                                <td><strong style="color:var(--adm-amber);">4 pcs</strong></td>
                                <td>8 pcs</td>
                                <td><span class="adm-badge amber">Low</span></td>
                                <td><a href="/Admin/inventory/adjustment.php" class="adm-tbl-action-btn">+ Restock</a></td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Georgette Printed Saree</strong>
                                    <div class="adm-tbl-sku">SKU: GRG-PT-404</div>
                                </td>
                                <td><strong style="color:var(--adm-amber);">3 pcs</strong></td>
                                <td>12 pcs</td>
                                <td><span class="adm-badge amber">Low</span></td>
                                <td><a href="/Admin/inventory/adjustment.php" class="adm-tbl-action-btn">+ Restock</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════════════════
             8. RECENT ORDERS TABLE (ENTERPRISE SEARCH & PAGINATION)
        ════════════════════════════════════════════════════════════ -->
        <section class="adm-card" style="margin-bottom:24px;">
            <div class="adm-card-head">
                <div class="adm-card-title-wrap">
                    <h2 class="adm-card-title">📦 Recent Orders & Consignments</h2>
                    <span class="adm-card-subtitle">Latest transactions across B2B Wholesale, Reseller & Direct Shop</span>
                </div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <a href="/Admin/orders/" class="adm-tbl-action-btn">View All Orders ↗</a>
                </div>
            </div>
            <div class="adm-table-wrap">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer / Partner</th>
                            <th>User Type</th>
                            <th>Items</th>
                            <th>Amount</th>
                            <th>Payment</th>
                            <th>Order Status</th>
                            <th>Shipping</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="adm-searchable-row">
                            <td><strong style="color:var(--adm-gold);">#ORD-9842</strong></td>
                            <td>
                                <div class="adm-tbl-user">
                                    <img src="/Shared/Asset/images/profile.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="adm-tbl-avatar" alt="Avatar">
                                    <div>
                                        <div style="font-weight:700;">Rajesh Kumar (Vardhman)</div>
                                        <div class="adm-tbl-sku">+91 98220 19283 • Surat, GJ</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="adm-badge gold">Wholesaler</span></td>
                            <td>Kanjivaram Silks (Qty: 25)</td>
                            <td><strong>₹1,12,250</strong></td>
                            <td><span class="adm-badge emerald">NEFT Paid</span></td>
                            <td><span class="adm-badge emerald">Processing</span></td>
                            <td>TCI Freight Cargo</td>
                            <td>Today, 11:20 AM</td>
                            <td><a href="/Admin/orders/view.php?id=9842" class="adm-tbl-action-btn">View ↗</a></td>
                        </tr>
                        <tr class="adm-searchable-row">
                            <td><strong style="color:var(--adm-gold);">#ORD-9841</strong></td>
                            <td>
                                <div class="adm-tbl-user">
                                    <img src="/Shared/Asset/images/profile.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" class="adm-tbl-avatar" alt="Avatar">
                                    <div>
                                        <div style="font-weight:700;">Pooja Sharma</div>
                                        <div class="adm-tbl-sku">+91 98110 29381 • Delhi, DL</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="adm-badge sky">B2C Shop</span></td>
                            <td>Banarasi Brocade (Qty: 1)</td>
                            <td><strong>₹4,990</strong></td>
                            <td><span class="adm-badge emerald">UPI Paid</span></td>
                            <td><span class="adm-badge emerald">Delivered</span></td>
                            <td>BlueDart Express</td>
                            <td>Today, 09:45 AM</td>
                            <td><a href="/Admin/orders/view.php?id=9841" class="adm-tbl-action-btn">View ↗</a></td>
                        </tr>
                        <tr class="adm-searchable-row">
                            <td><strong style="color:var(--adm-gold);">#ORD-9840</strong></td>
                            <td>
                                <div class="adm-tbl-user">
                                    <img src="/Shared/Asset/images/profile.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" class="adm-tbl-avatar" alt="Avatar">
                                    <div>
                                        <div style="font-weight:700;">Ananya Roy</div>
                                        <div class="adm-tbl-sku">+91 97118 23901 • Jaipur, RJ</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="adm-badge violet">Reseller</span></td>
                            <td>Rayon Kurtis (Qty: 3)</td>
                            <td><strong>₹2,997</strong></td>
                            <td><span class="adm-badge amber">COD</span></td>
                            <td><span class="adm-badge gold">Confirmed</span></td>
                            <td>Delhivery Surface</td>
                            <td>Yesterday, 04:15 PM</td>
                            <td><a href="/Admin/orders/view.php?id=9840" class="adm-tbl-action-btn">View ↗</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="adm-pagination">
                <div>Showing <strong>1 to 3</strong> of 1,624 orders</div>
                <div class="adm-pg-btns">
                    <button type="button" class="adm-pg-btn active">1</button>
                    <button type="button" class="adm-pg-btn">2</button>
                    <button type="button" class="adm-pg-btn">3</button>
                    <button type="button" class="adm-pg-btn">Next →</button>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════════════════════
             9. PENDING APPROVALS, RECENT ACTIVITY & SYSTEM HEALTH
        ════════════════════════════════════════════════════════════ -->
        <section class="adm-grid-3col">
            <!-- 1. Pending Approvals Center -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <div class="adm-card-title-wrap">
                        <h2 class="adm-card-title">📋 Pending Approval Center</h2>
                    </div>
                    <span class="adm-badge rose">8 Total</span>
                </div>
                <div style="display:flex; flex-direction:column; gap:10px;">
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:8px 12px; background:#FAF8F4; border-radius:6px;">
                        <span>🤝 Reseller KYC Applications</span>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="adm-badge gold">5 Pending</span>
                            <a href="/Admin/resellers/pending.php" class="adm-tbl-action-btn">Review</a>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:8px 12px; background:#FAF8F4; border-radius:6px;">
                        <span>🏢 Wholesaler GST Verification</span>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="adm-badge gold">2 Pending</span>
                            <a href="/Admin/wholesalers/pending.php" class="adm-tbl-action-btn">Review</a>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:8px 12px; background:#FAF8F4; border-radius:6px;">
                        <span>⭐ Product Reviews Moderation</span>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="adm-badge emerald">1 Pending</span>
                            <a href="/Admin/reviews/pending.php" class="adm-tbl-action-btn">Review</a>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; justify-content:space-between; padding:8px 12px; background:#FAF8F4; border-radius:6px;">
                        <span>↩️ Customer Return Requests</span>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="adm-badge rose">3 Pending</span>
                            <a href="/Admin/orders/returns.php" class="adm-tbl-action-btn">Review</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Recent Audit Timeline -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <div class="adm-card-title-wrap">
                        <h2 class="adm-card-title">🕒 Recent Activity Timeline</h2>
                    </div>
                    <a href="/Admin/users/activity-logs.php" class="adm-tbl-action-btn">Logs ↗</a>
                </div>
                <div class="adm-timeline-list">
                    <div class="adm-timeline-item">
                        <span class="adm-timeline-dot"></span>
                        <div class="adm-timeline-title">Admin Gautam Sethi logged in</div>
                        <div class="adm-timeline-time">10 mins ago • IP 147.93.99.134</div>
                    </div>
                    <div class="adm-timeline-item">
                        <span class="adm-timeline-dot"></span>
                        <div class="adm-timeline-title">Bulk consignment #ORD-9842 dispatched</div>
                        <div class="adm-timeline-time">25 mins ago • Warehouse Surat Hub</div>
                    </div>
                    <div class="adm-timeline-item">
                        <span class="adm-timeline-dot"></span>
                        <div class="adm-timeline-title">New Reseller KYC submitted (Simran Tex)</div>
                        <div class="adm-timeline-time">1 hour ago • Phone 9711823944</div>
                    </div>
                    <div class="adm-timeline-item">
                        <span class="adm-timeline-dot"></span>
                        <div class="adm-timeline-title">Stock Adjusted: Kanjivaram Silks (+50 pcs)</div>
                        <div class="adm-timeline-time">2 hours ago • Supplier Surat Weave</div>
                    </div>
                </div>
            </div>

            <!-- 3. System Health & Diagnostics -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <div class="adm-card-title-wrap">
                        <h2 class="adm-card-title">⚡ System Health & API Status</h2>
                    </div>
                    <a href="/Admin/system/health.php" class="adm-tbl-action-btn">Diagnostics ↗</a>
                </div>
                <div class="adm-sys-health-grid">
                    <div class="adm-sys-item">
                        <span class="adm-sys-name">PHP Engine</span>
                        <span class="adm-sys-status">● v8.2 OK</span>
                    </div>
                    <div class="adm-sys-item">
                        <span class="adm-sys-name">MySQL DB</span>
                        <span class="adm-sys-status">● 1.2ms OK</span>
                    </div>
                    <div class="adm-sys-item">
                        <span class="adm-sys-name">WhatsApp API</span>
                        <span class="adm-sys-status">● 99.98%</span>
                    </div>
                    <div class="adm-sys-item">
                        <span class="adm-sys-name">Storage</span>
                        <span class="adm-sys-status">● 42% Free</span>
                    </div>
                    <div class="adm-sys-item">
                        <span class="adm-sys-name">Cache</span>
                        <span class="adm-sys-status">● Redis OK</span>
                    </div>
                    <div class="adm-sys-item">
                        <span class="adm-sys-name">Cron Jobs</span>
                        <span class="adm-sys-status">● Active</span>
                    </div>
                    <div class="adm-sys-item">
                        <span class="adm-sys-name">SSL 256-bit</span>
                        <span class="adm-sys-status">● Valid</span>
                    </div>
                    <div class="adm-sys-item">
                        <span class="adm-sys-name">Backups</span>
                        <span class="adm-sys-status">● Hourly OK</span>
                    </div>
                </div>
            </div>
        </section>

    </main>
<?php
include_once __DIR__ . '/../includes/footer.php';
?>
