<?php
/**
 * analytics.php — DT Brand's & Jai Hanuman Tex
 * Wholesale Growth & GMV Velocity Analytics (100% Dynamic)
 */
$page_title = "Wholesale Analytics";
$active_nav = "wholesalers";
$active_subnav = "analytics";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesale Analytics - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/wholesale/assets/css/wholesale.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/wholesale/assets/css/wholesale-pricing.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/wholesale/assets/css/wholesale-analytics.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 18px 20px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-wholesale-container">
                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:4px;">
                    <div>
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span>Wholesale GMV &amp; Sourcing Velocity Analytics</span>
                            <span class="dt-cust-badge emerald" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#DCFCE7; color:#15803D; border:1px solid #86EFAC; font-weight:800;">+24.6% YoY</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Wholesale order trends, average lot order values, and top revenue grossing corporate partners.</p>
                    </div>

                    <!-- Timeframe & Export Toolbar -->
                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <button type="button" class="dt-btn dt-btn-gold dt-btn-sm dt-analytics-tf-btn" data-tf="6m" onclick="changeAnalyticsTimeframe('6m')">Last 6 Months</button>
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm dt-analytics-tf-btn" data-tf="q_festive" onclick="changeAnalyticsTimeframe('q_festive')">Festive Peak</button>
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm dt-analytics-tf-btn" data-tf="fy26" onclick="changeAnalyticsTimeframe('fy26')">FY 2025-26</button>
                        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="exportAnalyticsReport()">
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Export CSV</span>
                        </button>
                    </div>
                </div>

                <div style="display:flex; flex-direction:column; gap:16px;">

                    <!-- ══ 1. 4-CARD ANALYTICS KPI RIBBON ══ -->
                    <div class="dt-pricing-kpi-grid">
                        <div class="dt-pricing-kpi-card">
                            <div class="dt-pricing-kpi-top">
                                <span class="dt-pricing-kpi-label">ANNUAL WHOLESALE GMV</span>
                                <div class="dt-pricing-kpi-icon">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                                </div>
                            </div>
                            <div class="dt-pricing-kpi-val">₹1.42 Crore</div>
                            <div class="dt-pricing-kpi-bot">
                                <span>Gross Dispatched Volume</span>
                                <span style="color:#15803D; font-weight:800;">+24.6% YoY</span>
                            </div>
                        </div>

                        <div class="dt-pricing-kpi-card">
                            <div class="dt-pricing-kpi-top">
                                <span class="dt-pricing-kpi-label">AVERAGE LOT ORDER VALUE</span>
                                <div class="dt-pricing-kpi-icon emerald">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                </div>
                            </div>
                            <div class="dt-pricing-kpi-val" style="color:#15803D;">₹1,18,500</div>
                            <div class="dt-pricing-kpi-bot">
                                <span>Per Commercial Dispatch</span>
                                <span style="color:#15803D; font-weight:800;">+12.4% vs Retail</span>
                            </div>
                        </div>

                        <div class="dt-pricing-kpi-card">
                            <div class="dt-pricing-kpi-top">
                                <span class="dt-pricing-kpi-label">ON-TIME TRADE RECOVERY</span>
                                <div class="dt-pricing-kpi-icon blue">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                </div>
                            </div>
                            <div class="dt-pricing-kpi-val" style="color:#1D4ED8;">99.2% Settle</div>
                            <div class="dt-pricing-kpi-bot">
                                <span>Trade Credit Compliance</span>
                                <span style="color:#1D4ED8; font-weight:800;">Avg 18.4 Days</span>
                            </div>
                        </div>

                        <div class="dt-pricing-kpi-card">
                            <div class="dt-pricing-kpi-top">
                                <span class="dt-pricing-kpi-label">RE-ORDER RETENTION RATE</span>
                                <div class="dt-pricing-kpi-icon">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                                </div>
                            </div>
                            <div class="dt-pricing-kpi-val" style="color:#8A681F;">88.5% Active</div>
                            <div class="dt-pricing-kpi-bot">
                                <span>98 Active B2B Accounts</span>
                                <span style="color:#8A681F; font-weight:800;">High Loyalty</span>
                            </div>
                        </div>
                    </div>

                    <!-- ══ 2. VELOCITY CHART & LEADERBOARD GRID ══ -->
                    <div class="dt-analytics-grid">
                        <!-- Monthly GMV Velocity Chart -->
                        <div class="dt-card">
                            <div class="dt-card-head">
                                <h4 class="dt-card-title">Monthly Wholesale GMV Velocity (₹ Lakhs)</h4>
                                <span id="analyticsTotalPill" class="dt-status-pill-clean gold">₹1.42 Cr Total</span>
                            </div>
                            <div style="padding:16px;">
                                <div id="analyticsChartBarsWrap" class="dt-chart-bars-wrap">
                                    <div class="dt-chart-bar-group">
                                        <span class="dt-chart-bar-val">₹14.2L</span>
                                        <div class="dt-chart-bar-pill" style="height:45%;"></div>
                                        <span class="dt-chart-bar-label">Nov</span>
                                    </div>
                                    <div class="dt-chart-bar-group">
                                        <span class="dt-chart-bar-val">₹18.5L</span>
                                        <div class="dt-chart-bar-pill" style="height:60%;"></div>
                                        <span class="dt-chart-bar-label">Dec</span>
                                    </div>
                                    <div class="dt-chart-bar-group">
                                        <span class="dt-chart-bar-val">₹21.0L</span>
                                        <div class="dt-chart-bar-pill" style="height:68%;"></div>
                                        <span class="dt-chart-bar-label">Jan</span>
                                    </div>
                                    <div class="dt-chart-bar-group">
                                        <span class="dt-chart-bar-val">₹24.8L</span>
                                        <div class="dt-chart-bar-pill" style="height:80%;"></div>
                                        <span class="dt-chart-bar-label">Feb</span>
                                    </div>
                                    <div class="dt-chart-bar-group">
                                        <span class="dt-chart-bar-val">₹28.4L</span>
                                        <div class="dt-chart-bar-pill" style="height:90%;"></div>
                                        <span class="dt-chart-bar-label">Mar</span>
                                    </div>
                                    <div class="dt-chart-bar-group">
                                        <span class="dt-chart-bar-val" style="color:#8A681F; font-weight:900;">₹35.1L</span>
                                        <div class="dt-chart-bar-pill active" style="height:100%;"></div>
                                        <span class="dt-chart-bar-label" style="color:#8A681F; font-weight:900;">Apr (Peak)</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Top 5 Grossing Wholesale Accounts -->
                        <div class="dt-card">
                            <div class="dt-card-head">
                                <h4 class="dt-card-title">Top 5 Grossing Wholesale Accounts</h4>
                                <span class="dt-status-pill-clean emerald">Leaderboard</span>
                            </div>
                            <div style="padding:12px 16px;">
                                <div style="display:flex; flex-direction:column; gap:8px;">
                                    <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 12px; background:#FAF8F4; border-radius:8px; border:1px solid #D4AF37;">
                                        <div>
                                            <a href="/Frontend/Admin/wholesale/view.php?id=WHL-8012" style="font-size:0.82rem; color:#181512; font-weight:800; text-decoration:none;">#1 Shree Balaji Textile Emporium</a>
                                            <small style="font-size:0.7rem; color:#78716C; display:block;">Surat, Gujarat • 64 Orders • WHL-8012</small>
                                        </div>
                                        <strong style="font-size:0.95rem; color:#8A681F; font-weight:900;">₹24,50,000</strong>
                                    </div>

                                    <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 12px; background:#FFFFFF; border-radius:8px; border:1px solid #EAE5D9;">
                                        <div>
                                            <a href="/Frontend/Admin/wholesale/view.php?id=WHL-8013" style="font-size:0.82rem; color:#181512; font-weight:800; text-decoration:none;">#2 Varanasi Weaves &amp; Silks</a>
                                            <small style="font-size:0.7rem; color:#78716C; display:block;">Varanasi, UP • 48 Orders • WHL-8013</small>
                                        </div>
                                        <strong style="font-size:0.95rem; color:#181512; font-weight:900;">₹18,90,000</strong>
                                    </div>

                                    <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 12px; background:#FFFFFF; border-radius:8px; border:1px solid #EAE5D9;">
                                        <div>
                                            <a href="/Frontend/Admin/wholesale/view.php?id=WHL-8014" style="font-size:0.82rem; color:#181512; font-weight:800; text-decoration:none;">#3 Jaipur Royal Saree Distributors</a>
                                            <small style="font-size:0.7rem; color:#78716C; display:block;">Jaipur, Rajasthan • 36 Orders • WHL-8014</small>
                                        </div>
                                        <strong style="font-size:0.95rem; color:#181512; font-weight:900;">₹12,40,000</strong>
                                    </div>

                                    <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 12px; background:#FFFFFF; border-radius:8px; border:1px solid #EAE5D9;">
                                        <div>
                                            <a href="/Frontend/Admin/wholesale/view.php?id=WHL-8015" style="font-size:0.82rem; color:#181512; font-weight:800; text-decoration:none;">#4 Kanchipuram Silk Syndicate</a>
                                            <small style="font-size:0.7rem; color:#78716C; display:block;">Chennai, Tamil Nadu • 28 Orders • WHL-8015</small>
                                        </div>
                                        <strong style="font-size:0.95rem; color:#181512; font-weight:900;">₹9,80,000</strong>
                                    </div>

                                    <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 12px; background:#FFFFFF; border-radius:8px; border:1px solid #EAE5D9;">
                                        <div>
                                            <a href="/Frontend/Admin/wholesale/view.php?id=WHL-8016" style="font-size:0.82rem; color:#181512; font-weight:800; text-decoration:none;">#5 Kolkata Handloom Guild</a>
                                            <small style="font-size:0.7rem; color:#78716C; display:block;">Kolkata, West Bengal • 22 Orders • WHL-8016</small>
                                        </div>
                                        <strong style="font-size:0.95rem; color:#181512; font-weight:900;">₹8,20,000</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ══ 3. FABRIC CATEGORY VOLUME BREAKDOWN ══ -->
                    <div class="dt-card" style="background:#FFFFFF; border:1.5px solid #EAE5D9; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.02); overflow:hidden;">
                        <div class="dt-card-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; background:#FAF8F4;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
                                <h4 class="dt-card-title" style="font-size:0.92rem; font-weight:800; color:#181512; margin:0;">Fabric Category Wholesale Sourcing Distribution</h4>
                            </div>
                            <span class="dt-status-pill-clean gold">High Demand</span>
                        </div>

                        <div style="padding:16px 18px; display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:14px;">
                            <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:12px 14px;">
                                <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.78rem;">
                                    <strong style="color:#181512;">Pure Kanjeevaram &amp; Banarasi</strong>
                                    <strong style="color:#15803D;">42% (₹59.6L)</strong>
                                </div>
                                <div style="height:6px; background:#EAE5D9; border-radius:3px; overflow:hidden; margin-top:8px;">
                                    <div style="width:42%; height:100%; background:linear-gradient(90deg, #15803D, #22C55E); border-radius:3px;"></div>
                                </div>
                            </div>

                            <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:12px 14px;">
                                <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.78rem;">
                                    <strong style="color:#181512;">Surat Dola Silk Jacquard</strong>
                                    <strong style="color:#8A681F;">28% (₹39.7L)</strong>
                                </div>
                                <div style="height:6px; background:#EAE5D9; border-radius:3px; overflow:hidden; margin-top:8px;">
                                    <div style="width:28%; height:100%; background:linear-gradient(90deg, #B8860B, #D4AF37); border-radius:3px;"></div>
                                </div>
                            </div>

                            <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:12px 14px;">
                                <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.78rem;">
                                    <strong style="color:#181512;">Chanderi &amp; Organza Festive</strong>
                                    <strong style="color:#1D4ED8;">18% (₹25.5L)</strong>
                                </div>
                                <div style="height:6px; background:#EAE5D9; border-radius:3px; overflow:hidden; margin-top:8px;">
                                    <div style="width:18%; height:100%; background:linear-gradient(90deg, #1D4ED8, #60A5FA); border-radius:3px;"></div>
                                </div>
                            </div>

                            <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:12px 14px;">
                                <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.78rem;">
                                    <strong style="color:#181512;">Designer Georgette &amp; Kurtis</strong>
                                    <strong style="color:#B45309;">12% (₹17.0L)</strong>
                                </div>
                                <div style="height:6px; background:#EAE5D9; border-radius:3px; overflow:hidden; margin-top:8px;">
                                    <div style="width:12%; height:100%; background:linear-gradient(90deg, #B45309, #F59E0B); border-radius:3px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/wholesale/assets/js/wholesale.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/wholesale/assets/js/wholesale-analytics.js?v=<?php echo time(); ?>"></script>
</body>
</html>

