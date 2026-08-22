<?php
/**
 * analytics.php — DT Brand's & Jai Hanuman Tex
 * Wholesale Growth & GMV Velocity Analytics
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
                </div>

                <div class="dt-analytics-grid">
                    <!-- Monthly GMV Velocity Chart -->
                    <div class="dt-card">
                        <div class="dt-card-head">
                            <h4 class="dt-card-title">Monthly Wholesale GMV Velocity (₹ Lakhs)</h4>
                            <span class="dt-status-pill-clean gold">₹1.42 Cr Total</span>
                        </div>
                        <div style="padding:16px;">
                            <div class="dt-chart-bars-wrap">
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
                            <div style="display:flex; flex-direction:column; gap:10px;">
                                <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 10px; background:#FAF8F4; border-radius:8px; border:1px solid #EAE5D9;">
                                    <div>
                                        <strong style="font-size:0.82rem; color:#181512;">#1 Shree Balaji Textile Emporium</strong>
                                        <small style="font-size:0.7rem; color:#78716C; display:block;">Surat, Gujarat • 64 Orders</small>
                                    </div>
                                    <strong style="font-size:0.95rem; color:#8A681F; font-weight:900;">₹24,50,000</strong>
                                </div>

                                <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 10px; background:#FFFFFF; border-radius:8px; border:1px solid #EAE5D9;">
                                    <div>
                                        <strong style="font-size:0.82rem; color:#181512;">#2 Varanasi Weaves &amp; Silks</strong>
                                        <small style="font-size:0.7rem; color:#78716C; display:block;">Varanasi, UP • 48 Orders</small>
                                    </div>
                                    <strong style="font-size:0.95rem; color:#181512; font-weight:900;">₹18,90,000</strong>
                                </div>

                                <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 10px; background:#FFFFFF; border-radius:8px; border:1px solid #EAE5D9;">
                                    <div>
                                        <strong style="font-size:0.82rem; color:#181512;">#3 Jaipur Royal Saree Distributors</strong>
                                        <small style="font-size:0.7rem; color:#78716C; display:block;">Jaipur, Rajasthan • 36 Orders</small>
                                    </div>
                                    <strong style="font-size:0.95rem; color:#181512; font-weight:900;">₹12,40,000</strong>
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
</body>
</html>
