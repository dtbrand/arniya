<?php
/**
 * analytics.php — DT Brand's & Jai Hanuman Tex
 * Reseller Analytics & GMV Growth Studio
 */
$page_title = "Reseller Analytics Studio";
$active_nav = "resellers";
$active_subnav = "analytics";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseller Analytics - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/resellers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/reseller-analytics.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/reseller-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-customers-container" style="display:flex; flex-direction:column; gap:14px; margin-bottom:24px;">
                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span>Reseller Growth &amp; GMV Velocity Analytics</span>
                            <span class="dt-cust-badge gold" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:800;">₹48.6L Volume</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Inspect network expansion metrics, commission payouts burn rate, and top grossing partner stores.</p>
                    </div>
                    <div class="dt-cust-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="/Frontend/Admin/resellers/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            <span>Back to Resellers</span>
                        </a>
                        <a href="/Frontend/Admin/resellers/export.php" class="dt-btn dt-btn-gold">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Export Report</span>
                        </a>
                    </div>
                </div>

                <!-- 8-Card KPI Ribbon & Flow Filter Pills -->
                <?php include __DIR__ . '/components/reseller-stats.php'; ?>

                <!-- Analytics Studio Grid -->
                <div class="dt-reseller-analytics-grid">
                    <div class="dt-analytics-chart-card">
                        <h4 class="dt-card-title" style="margin-bottom:12px;">Monthly Network GMV Growth (Last 6 Months)</h4>
                        <div class="dt-chart-bars-wrap">
                            <div class="dt-chart-bar-group">
                                <div class="dt-chart-bar-pill" style="height:45%;"></div>
                                <span class="dt-chart-bar-label">Nov</span>
                            </div>
                            <div class="dt-chart-bar-group">
                                <div class="dt-chart-bar-pill" style="height:60%;"></div>
                                <span class="dt-chart-bar-label">Dec</span>
                            </div>
                            <div class="dt-chart-bar-group">
                                <div class="dt-chart-bar-pill" style="height:72%;"></div>
                                <span class="dt-chart-bar-label">Jan</span>
                            </div>
                            <div class="dt-chart-bar-group">
                                <div class="dt-chart-bar-pill" style="height:68%;"></div>
                                <span class="dt-chart-bar-label">Feb</span>
                            </div>
                            <div class="dt-chart-bar-group">
                                <div class="dt-chart-bar-pill" style="height:84%;"></div>
                                <span class="dt-chart-bar-label">Mar</span>
                            </div>
                            <div class="dt-chart-bar-group">
                                <div class="dt-chart-bar-pill active" style="height:100%;"></div>
                                <span class="dt-chart-bar-label">Apr (₹48.6L)</span>
                            </div>
                        </div>
                    </div>

                    <div class="dt-analytics-chart-card">
                        <h4 class="dt-card-title" style="margin-bottom:12px;">Tier Distribution &amp; Margin Split</h4>
                        <div style="display:flex; flex-direction:column; gap:10px;">
                            <div>
                                <div style="display:flex; justify-content:space-between; font-size:0.75rem; font-weight:700; margin-bottom:4px;">
                                    <span>Platinum Elite (30% Margin)</span>
                                    <span style="color:#8A681F;">42 Partners (12%)</span>
                                </div>
                                <div style="height:8px; background:#F5F2EA; border-radius:4px; overflow:hidden;">
                                    <div style="width:12%; height:100%; background:linear-gradient(90deg, #D4AF37, #B8860B);"></div>
                                </div>
                            </div>

                            <div>
                                <div style="display:flex; justify-content:space-between; font-size:0.75rem; font-weight:700; margin-bottom:4px;">
                                    <span>Gold Partner (22% Margin)</span>
                                    <span style="color:#15803D;">124 Partners (36%)</span>
                                </div>
                                <div style="height:8px; background:#F5F2EA; border-radius:4px; overflow:hidden;">
                                    <div style="width:36%; height:100%; background:linear-gradient(90deg, #22C55E, #15803D);"></div>
                                </div>
                            </div>

                            <div>
                                <div style="display:flex; justify-content:space-between; font-size:0.75rem; font-weight:700; margin-bottom:4px;">
                                    <span>Silver Growth (15% Margin)</span>
                                    <span style="color:#1D4ED8;">130 Partners (37%)</span>
                                </div>
                                <div style="height:8px; background:#F5F2EA; border-radius:4px; overflow:hidden;">
                                    <div style="width:37%; height:100%; background:linear-gradient(90deg, #60A5FA, #1D4ED8);"></div>
                                </div>
                            </div>

                            <div>
                                <div style="display:flex; justify-content:space-between; font-size:0.75rem; font-weight:700; margin-bottom:4px;">
                                    <span>Bronze Starter (10% Margin)</span>
                                    <span style="color:#B45309;">52 Partners (15%)</span>
                                </div>
                                <div style="height:8px; background:#F5F2EA; border-radius:4px; overflow:hidden;">
                                    <div style="width:15%; height:100%; background:linear-gradient(90deg, #FBBF24, #B45309);"></div>
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

<script src="/Frontend/Admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
</body>
</html>
