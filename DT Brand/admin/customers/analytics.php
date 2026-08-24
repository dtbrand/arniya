<?php
/**
 * analytics.php — Customer Growth, Retention & Cohort Analytics
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
$page_title = "Customer Analytics & Growth Studio";
$active_nav = "customers";
$active_subnav = "analytics";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/customers/assets/css/customer-analytics.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-customers-container" style="display:flex; flex-direction:column; gap:16px;">
                <!-- Page Header -->
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Customer Analytics &amp; Growth Studio</span>
                            <span class="dt-cust-badge gold">LTV &amp; Cohort Trends</span>
                        </h1>
                        <p class="dt-cust-subtitle">Track customer acquisition velocity, repeat reorder intervals, cohort retention, and lifetime value trajectory.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/DT%20Brand/admin/customers/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                            <span>All Customers</span>
                        </a>
                        <button type="button" class="dt-btn dt-btn-gold" onclick="window.showToast('📊 Exporting Full Customer Analytics PDF / Excel Report...')">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Export Report</span>
                        </button>
                    </div>
                </div>

                <!-- 4-Card Master KPI Ribbon -->
                <div class="dt-cust-kpi-grid" style="grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));">
                    <!-- Card 1: Avg LTV -->
                    <div class="dt-cust-kpi-card active">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">AVG LIFETIME VALUE (LTV)</span>
                            <div class="dt-cust-kpi-icon gold">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val" style="color:#8A681F;">₹18,450</div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta">↑ +14.2% YoY</span>
                            <span style="color:#78716C;">Across 4,820 Shoppers</span>
                        </div>
                    </div>

                    <!-- Card 2: Repeat Rate -->
                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">REPEAT REORDER RATE</span>
                            <div class="dt-cust-kpi-icon emerald">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val" style="color:#15803D;">38.4%</div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta">1,850 Repeat Buyers</span>
                            <span style="color:#15803D; font-weight:800;">+3.8% vs Benchmark</span>
                        </div>
                    </div>

                    <!-- Card 3: Repurchase Interval -->
                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">AVG REPURCHASE INTERVAL</span>
                            <div class="dt-cust-kpi-icon purple">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val">26.4 Days</div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta">High Reorder Velocity</span>
                            <span style="color:#78716C;">Textile Cycle</span>
                        </div>
                    </div>

                    <!-- Card 4: VIP Revenue Share -->
                    <div class="dt-cust-kpi-card">
                        <div class="dt-cust-kpi-top">
                            <span class="dt-cust-kpi-label">VIP REVENUE CONTRIBUTION</span>
                            <div class="dt-cust-kpi-icon gold">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            </div>
                        </div>
                        <div class="dt-cust-kpi-val" style="color:#B8860B;">62.8%</div>
                        <div class="dt-cust-kpi-bot">
                            <span class="dt-cust-kpi-delta">Top 15% VIP Shoppers</span>
                            <span style="color:#78716C;">High Margin</span>
                        </div>
                    </div>
                </div>

                <!-- Row 1: Growth Velocity & Cohort Retention -->
                <div class="dt-analytics-grid">
                    <!-- Growth Waveform Chart -->
                    <div class="dt-analytics-card">
                        <div class="dt-analytics-head">
                            <div>
                                <h3 class="dt-card-title" style="display:flex; align-items:center; gap:8px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                                    <span>New vs Returning Shopper Growth</span>
                                </h3>
                                <p style="font-size:0.72rem; color:#78716C; margin:2px 0 0 0;">Monthly registration velocity vs repeat reorder trajectory (2025–2026)</p>
                            </div>
                            <span class="dt-cust-badge gold" style="font-size:0.65rem;">Live Trajectory</span>
                        </div>

                        <div class="dt-analytics-canvas-wrap">
                            <canvas id="dtCustGrowthCanvas" width="520" height="210"></canvas>
                        </div>

                        <div class="dt-analytics-legend">
                            <div style="display:flex; align-items:center; gap:6px;">
                                <span class="dt-analytics-dot" style="background:#8A681F;"></span>
                                <span>New Shoppers (Avg +348/mo)</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:6px;">
                                <span class="dt-analytics-dot" style="background:#15803D;"></span>
                                <span>Repeat Reorders (38.4% Conversion)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Cohort Retention Heatmap -->
                    <div class="dt-analytics-card">
                        <div class="dt-analytics-head">
                            <div>
                                <h3 class="dt-card-title" style="display:flex; align-items:center; gap:8px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                    <span>Customer Cohort Retention Matrix</span>
                                </h3>
                                <p style="font-size:0.72rem; color:#78716C; margin:2px 0 0 0;">Percentage of shoppers returning in subsequent months</p>
                            </div>
                            <span class="dt-cust-badge emerald" style="font-size:0.65rem;">38.4% 60-Day Ret.</span>
                        </div>

                        <div style="overflow-x:auto; -webkit-overflow-scrolling:touch;">
                            <table class="dt-cohort-table">
                                <thead>
                                    <tr>
                                        <th>Cohort</th>
                                        <th>Shoppers</th>
                                        <th>M0</th>
                                        <th>M1</th>
                                        <th>M2</th>
                                        <th>M3</th>
                                        <th>M4</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="font-weight:800; color:#181512; text-align:left; padding-left:8px;">Nov 2025</td>
                                        <td style="font-weight:700; color:#78716C;">420</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7; color:#15803D;">100%</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7; color:#15803D;">42.8%</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7; color:#15803D;">36.1%</td>
                                        <td class="dt-cohort-cell" style="background:#E2F9E8; color:#166534;">31.4%</td>
                                        <td class="dt-cohort-cell" style="background:#EFFCF3; color:#166534;">28.9%</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:800; color:#181512; text-align:left; padding-left:8px;">Dec 2025</td>
                                        <td style="font-weight:700; color:#78716C;">580</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7; color:#15803D;">100%</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7; color:#15803D;">46.2%</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7; color:#15803D;">39.0%</td>
                                        <td class="dt-cohort-cell" style="background:#E2F9E8; color:#166534;">34.5%</td>
                                        <td style="color:#9CA3AF;">—</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:800; color:#181512; text-align:left; padding-left:8px;">Jan 2026</td>
                                        <td style="font-weight:700; color:#78716C;">610</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7; color:#15803D;">100%</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7; color:#15803D;">44.1%</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7; color:#15803D;">37.8%</td>
                                        <td style="color:#9CA3AF;">—</td>
                                        <td style="color:#9CA3AF;">—</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:800; color:#181512; text-align:left; padding-left:8px;">Feb 2026</td>
                                        <td style="font-weight:700; color:#78716C;">540</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7; color:#15803D;">100%</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7; color:#15803D;">48.5%</td>
                                        <td style="color:#9CA3AF;">—</td>
                                        <td style="color:#9CA3AF;">—</td>
                                        <td style="color:#9CA3AF;">—</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:800; color:#181512; text-align:left; padding-left:8px;">Mar 2026</td>
                                        <td style="font-weight:700; color:#78716C;">690</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7; color:#15803D;">100%</td>
                                        <td style="color:#9CA3AF;">—</td>
                                        <td style="color:#9CA3AF;">—</td>
                                        <td style="color:#9CA3AF;">—</td>
                                        <td style="color:#9CA3AF;">—</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Omnichannel Acquisition & RFM Segmentation -->
                <div class="dt-analytics-grid">
                    <!-- Card 3: Omnichannel Acquisition Share -->
                    <div class="dt-analytics-card">
                        <div class="dt-analytics-head">
                            <div>
                                <h3 class="dt-card-title" style="display:flex; align-items:center; gap:8px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                    <span>Customer Acquisition Channels</span>
                                </h3>
                                <p style="font-size:0.72rem; color:#78716C; margin:2px 0 0 0;">Customer onboarding channels &amp; average channel LTV</p>
                            </div>
                            <span class="dt-cust-badge gold" style="font-size:0.65rem;">4 Channels</span>
                        </div>

                        <div style="display:flex; flex-direction:column; gap:10px;">
                            <!-- Channel 1: WhatsApp -->
                            <div class="dt-channel-item">
                                <div class="dt-channel-meta">
                                    <div style="display:flex; align-items:center; gap:6px;">
                                        <span style="width:8px; height:8px; border-radius:50%; background:#15803D; display:inline-block;"></span>
                                        <span>WhatsApp Catalog Commerce</span>
                                    </div>
                                    <div style="text-align:right;">
                                        <strong>2,506 (52.0%)</strong>
                                        <span style="font-size:0.68rem; color:#8A681F; margin-left:6px;">Avg LTV: ₹22,400</span>
                                    </div>
                                </div>
                                <div class="dt-channel-bar-wrap">
                                    <div class="dt-channel-bar" style="width:52%; background:linear-gradient(90deg, #15803D, #22C55E);"></div>
                                </div>
                            </div>

                            <!-- Channel 2: Showroom -->
                            <div class="dt-channel-item">
                                <div class="dt-channel-meta">
                                    <div style="display:flex; align-items:center; gap:6px;">
                                        <span style="width:8px; height:8px; border-radius:50%; background:#8A681F; display:inline-block;"></span>
                                        <span>Surat Flagship Showroom</span>
                                    </div>
                                    <div style="text-align:right;">
                                        <strong>1,180 (24.5%)</strong>
                                        <span style="font-size:0.68rem; color:#8A681F; margin-left:6px;">Avg LTV: ₹19,800</span>
                                    </div>
                                </div>
                                <div class="dt-channel-bar-wrap">
                                    <div class="dt-channel-bar" style="width:24.5%; background:linear-gradient(90deg, #B8860B, #D4AF37);"></div>
                                </div>
                            </div>

                            <!-- Channel 3: Wholesale Direct -->
                            <div class="dt-channel-item">
                                <div class="dt-channel-meta">
                                    <div style="display:flex; align-items:center; gap:6px;">
                                        <span style="width:8px; height:8px; border-radius:50%; background:#7E22CE; display:inline-block;"></span>
                                        <span>B2B Wholesale Lot Direct</span>
                                    </div>
                                    <div style="text-align:right;">
                                        <strong>748 (15.5%)</strong>
                                        <span style="font-size:0.68rem; color:#8A681F; margin-left:6px;">Avg LTV: ₹48,500</span>
                                    </div>
                                </div>
                                <div class="dt-channel-bar-wrap">
                                    <div class="dt-channel-bar" style="width:15.5%; background:linear-gradient(90deg, #7E22CE, #A855F7);"></div>
                                </div>
                            </div>

                            <!-- Channel 4: Online Web -->
                            <div class="dt-channel-item">
                                <div class="dt-channel-meta">
                                    <div style="display:flex; align-items:center; gap:6px;">
                                        <span style="width:8px; height:8px; border-radius:50%; background:#1D4ED8; display:inline-block;"></span>
                                        <span>Instagram &amp; Web Store</span>
                                    </div>
                                    <div style="text-align:right;">
                                        <strong>386 (8.0%)</strong>
                                        <span style="font-size:0.68rem; color:#8A681F; margin-left:6px;">Avg LTV: ₹14,200</span>
                                    </div>
                                </div>
                                <div class="dt-channel-bar-wrap">
                                    <div class="dt-channel-bar" style="width:8.0%; background:linear-gradient(90deg, #1D4ED8, #60A5FA);"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4: RFM Segmentation Matrix -->
                    <div class="dt-analytics-card">
                        <div class="dt-analytics-head">
                            <div>
                                <h3 class="dt-card-title" style="display:flex; align-items:center; gap:8px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                    <span>RFM Loyalty &amp; Risk Matrix</span>
                                </h3>
                                <p style="font-size:0.72rem; color:#78716C; margin:2px 0 0 0;">Recency, Frequency, Monetary value customer clustering</p>
                            </div>
                            <a href="/DT%20Brand/admin/customers/segments.php" class="dt-btn dt-btn-pale dt-btn-sm" style="padding:2px 8px; font-size:0.7rem; text-decoration:none;">View Segments</a>
                        </div>

                        <div class="dt-rfm-grid">
                            <!-- Tier 1: Champions -->
                            <div class="dt-rfm-tier-card" style="border-left:3px solid #D4AF37;">
                                <div style="display:flex; align-items:center; justify-content:space-between;">
                                    <span style="font-size:0.68rem; font-weight:800; color:#8A681F; text-transform:uppercase;">👑 Champions</span>
                                    <span class="dt-cust-badge gold" style="font-size:0.6rem;">Top Tier</span>
                                </div>
                                <div style="font-size:1.15rem; font-weight:900; color:#181512;">312</div>
                                <div style="font-size:0.65rem; color:#78716C;">LTV &gt; ₹50K • &lt; 15d recency</div>
                            </div>

                            <!-- Tier 2: Loyal Repeaters -->
                            <div class="dt-rfm-tier-card" style="border-left:3px solid #15803D;">
                                <div style="display:flex; align-items:center; justify-content:space-between;">
                                    <span style="font-size:0.68rem; font-weight:800; color:#15803D; text-transform:uppercase;">⭐ Loyalists</span>
                                    <span class="dt-cust-badge emerald" style="font-size:0.6rem;">Core</span>
                                </div>
                                <div style="font-size:1.15rem; font-weight:900; color:#181512;">1,850</div>
                                <div style="font-size:0.65rem; color:#78716C;">3+ Orders • High velocity</div>
                            </div>

                            <!-- Tier 3: Potential -->
                            <div class="dt-rfm-tier-card" style="border-left:3px solid #1D4ED8;">
                                <div style="display:flex; align-items:center; justify-content:space-between;">
                                    <span style="font-size:0.68rem; font-weight:800; color:#1D4ED8; text-transform:uppercase;">🚀 Potential</span>
                                    <span class="dt-cust-badge blue" style="font-size:0.6rem;">Nurture</span>
                                </div>
                                <div style="font-size:1.15rem; font-weight:900; color:#181512;">1,240</div>
                                <div style="font-size:0.65rem; color:#78716C;">1-2 Recent orders</div>
                            </div>

                            <!-- Tier 4: At Risk -->
                            <div class="dt-rfm-tier-card" style="border-left:3px solid #B45309;">
                                <div style="display:flex; align-items:center; justify-content:space-between;">
                                    <span style="font-size:0.68rem; font-weight:800; color:#B45309; text-transform:uppercase;">⚠️ At Risk</span>
                                    <span class="dt-cust-badge amber" style="font-size:0.6rem;">Winback</span>
                                </div>
                                <div style="font-size:1.15rem; font-weight:900; color:#181512;">640</div>
                                <div style="font-size:0.65rem; color:#78716C;">No order &gt; 60 days</div>
                            </div>

                            <!-- Tier 5: Dormant -->
                            <div class="dt-rfm-tier-card" style="border-left:3px solid #DC2626;">
                                <div style="display:flex; align-items:center; justify-content:space-between;">
                                    <span style="font-size:0.68rem; font-weight:800; color:#DC2626; text-transform:uppercase;">💤 Dormant</span>
                                    <span class="dt-cust-badge rose" style="font-size:0.6rem;">Inactive</span>
                                </div>
                                <div style="font-size:1.15rem; font-weight:900; color:#181512;">778</div>
                                <div style="font-size:0.65rem; color:#78716C;">No order &gt; 120 days</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/DT%20Brand/admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('dtCustGrowthCanvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    const dpr = window.devicePixelRatio || 1;
    const w = canvas.parentElement.clientWidth || 480;
    const h = 210;
    canvas.width = w * dpr;
    canvas.height = h * dpr;
    canvas.style.width = w + 'px';
    canvas.style.height = h + 'px';
    ctx.scale(dpr, dpr);

    const labels = ['Nov 2025', 'Dec 2025', 'Jan 2026', 'Feb 2026', 'Mar 2026', 'Apr 2026'];
    const newCust = [420, 580, 610, 540, 690, 720];
    const repeatCust = [180, 268, 270, 262, 330, 360];
    const maxVal = 800;

    const padL = 35, padR = 25, padT = 20, padB = 30;
    const cW = w - padL - padR;
    const cH = h - padT - padB;

    // Grid lines
    ctx.strokeStyle = '#F0ECE1';
    ctx.lineWidth = 1;
    ctx.setLineDash([4, 4]);
    for (let i = 1; i <= 3; i++) {
        const y = padT + (cH / 3) * i;
        ctx.beginPath();
        ctx.moveTo(padL, y);
        ctx.lineTo(w - padR, y);
        ctx.stroke();
    }
    ctx.setLineDash([]);

    // Line 1: New Shoppers
    const grad1 = ctx.createLinearGradient(0, padT, 0, h - padB);
    grad1.addColorStop(0, 'rgba(184, 134, 11, 0.25)');
    grad1.addColorStop(1, 'rgba(184, 134, 11, 0.0)');

    ctx.fillStyle = grad1;
    ctx.beginPath();
    ctx.moveTo(padL, h - padB);
    labels.forEach((lbl, i) => {
        const x = padL + (i * (cW / (labels.length - 1)));
        const y = h - padB - ((newCust[i] / maxVal) * cH);
        ctx.lineTo(x, y);
    });
    ctx.lineTo(w - padR, h - padB);
    ctx.closePath();
    ctx.fill();

    ctx.strokeStyle = '#8A681F';
    ctx.lineWidth = 2.8;
    ctx.beginPath();
    labels.forEach((lbl, i) => {
        const x = padL + (i * (cW / (labels.length - 1)));
        const y = h - padB - ((newCust[i] / maxVal) * cH);
        if (i === 0) ctx.moveTo(x, y);
        else ctx.lineTo(x, y);
    });
    ctx.stroke();

    // Line 2: Repeat Shoppers
    const grad2 = ctx.createLinearGradient(0, padT, 0, h - padB);
    grad2.addColorStop(0, 'rgba(21, 128, 61, 0.2)');
    grad2.addColorStop(1, 'rgba(21, 128, 61, 0.0)');

    ctx.fillStyle = grad2;
    ctx.beginPath();
    ctx.moveTo(padL, h - padB);
    labels.forEach((lbl, i) => {
        const x = padL + (i * (cW / (labels.length - 1)));
        const y = h - padB - ((repeatCust[i] / maxVal) * cH);
        ctx.lineTo(x, y);
    });
    ctx.lineTo(w - padR, h - padB);
    ctx.closePath();
    ctx.fill();

    ctx.strokeStyle = '#15803D';
    ctx.lineWidth = 2.8;
    ctx.beginPath();
    labels.forEach((lbl, i) => {
        const x = padL + (i * (cW / (labels.length - 1)));
        const y = h - padB - ((repeatCust[i] / maxVal) * cH);
        if (i === 0) ctx.moveTo(x, y);
        else ctx.lineTo(x, y);
    });
    ctx.stroke();

    // Dots & Labels
    labels.forEach((lbl, i) => {
        const x = padL + (i * (cW / (labels.length - 1)));
        const y1 = h - padB - ((newCust[i] / maxVal) * cH);
        const y2 = h - padB - ((repeatCust[i] / maxVal) * cH);

        // Dot 1
        ctx.fillStyle = '#8A681F';
        ctx.beginPath();
        ctx.arc(x, y1, 4, 0, Math.PI * 2);
        ctx.fill();

        // Dot 2
        ctx.fillStyle = '#15803D';
        ctx.beginPath();
        ctx.arc(x, y2, 4, 0, Math.PI * 2);
        ctx.fill();

        // X-Axis Labels
        ctx.fillStyle = '#78716C';
        ctx.font = '700 10px Plus Jakarta Sans, sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText(lbl, x, h - padB + 18);
    });
});
</script>
</body>
</html>
