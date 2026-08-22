<?php
/**
 * analytics.php — DT Brand's & Jai Hanuman Tex
 * Reseller Growth, GMV Velocity & Payout Analytics Studio
 */
$page_title = "Reseller Analytics & Intelligence Studio";
$active_nav = "resellers";
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
        <main class="adm-content">

            <div class="dt-resellers-container">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                    <div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <h1 style="font-size:1.35rem; font-weight:900; color:#181512; margin:0;">Reseller Analytics &amp; GMV Intelligence</h1>
                            <span class="dt-reseller-badge gold">Executive Dashboard</span>
                        </div>
                        <p style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Gross sales velocity, cohort repeat rates, payout burn, and tier distributions.</p>
                    </div>
                    <a href="/Frontend/Admin/resellers/index.php" class="dt-btn dt-btn-pale">← Back to Resellers Directory</a>
                </div>

                <!-- 4-Card Master KPI Ribbon -->
                <div class="dt-reseller-kpi-grid">
                    <div class="dt-reseller-kpi-card">
                        <div class="dt-reseller-kpi-top">
                            <span class="dt-reseller-kpi-label">Active Network GMV</span>
                            <div class="dt-reseller-kpi-icon gold">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                            </div>
                        </div>
                        <div class="dt-reseller-kpi-val">₹48.6 Lakhs</div>
                        <div class="dt-reseller-kpi-bot"><span class="dt-reseller-kpi-delta">↑ +24.8% vs Last Quarter</span></div>
                    </div>

                    <div class="dt-reseller-kpi-card">
                        <div class="dt-reseller-kpi-top">
                            <span class="dt-reseller-kpi-label">Average Order Value (AOV)</span>
                            <div class="dt-reseller-kpi-icon emerald">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#15803D" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                            </div>
                        </div>
                        <div class="dt-reseller-kpi-val">₹14,200</div>
                        <div class="dt-reseller-kpi-bot"><span class="dt-reseller-kpi-delta">↑ High Wholesale Density</span></div>
                    </div>

                    <div class="dt-reseller-kpi-card">
                        <div class="dt-reseller-kpi-top">
                            <span class="dt-reseller-kpi-label">Monthly Repeat Rate</span>
                            <div class="dt-reseller-kpi-icon blue">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#1D4ED8" stroke-width="2.3"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                            </div>
                        </div>
                        <div class="dt-reseller-kpi-val">84.2%</div>
                        <div class="dt-reseller-kpi-bot"><span class="dt-reseller-kpi-delta">↑ High Partner Stickiness</span></div>
                    </div>

                    <div class="dt-reseller-kpi-card">
                        <div class="dt-reseller-kpi-top">
                            <span class="dt-reseller-kpi-label">Commission Disbursed</span>
                            <div class="dt-reseller-kpi-icon purple">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#7E22CE" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                            </div>
                        </div>
                        <div class="dt-reseller-kpi-val">₹5.82 Lakhs</div>
                        <div class="dt-reseller-kpi-bot"><span style="color:#78716C;">100% On-Time Disbursed</span></div>
                    </div>
                </div>

                <!-- 2. Dual Analytics Cards -->
                <div class="dt-reseller-analytics-grid">
                    <!-- GMV Growth Chart -->
                    <div class="dt-card" style="padding:18px;">
                        <div class="dt-card-head" style="margin-bottom:14px;">
                            <h4 class="dt-card-title">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.5"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                                <span>Reseller GMV Revenue Growth (6-Month Trend)</span>
                            </h4>
                            <span class="dt-reseller-badge gold">Monthly Velocity</span>
                        </div>
                        <canvas id="resellerGmvChart" style="width:100%; height:220px;"></canvas>
                    </div>

                    <!-- Tier Distribution -->
                    <div class="dt-card" style="padding:18px;">
                        <h4 class="dt-card-title" style="margin-bottom:14px;">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                            <span>Partner Tier Distribution (348 Total)</span>
                        </h4>

                        <div style="display:flex; flex-direction:column; gap:12px; margin-top:8px;">
                            <div>
                                <div style="display:flex; justify-content:space-between; font-size:0.75rem; font-weight:700; margin-bottom:4px;">
                                    <span>★ Platinum Elite (30% Margin)</span>
                                    <span style="color:#8A681F; font-weight:800;">42 Partners (12.1%)</span>
                                </div>
                                <div style="height:8px; background:#F0ECE1; border-radius:4px; overflow:hidden;">
                                    <div style="width:12.1%; height:100%; background:linear-gradient(90deg, #8A681F, #D4AF37);"></div>
                                </div>
                            </div>

                            <div>
                                <div style="display:flex; justify-content:space-between; font-size:0.75rem; font-weight:700; margin-bottom:4px;">
                                    <span>★ Gold Partners (22% Margin)</span>
                                    <span style="color:#8A681F; font-weight:800;">94 Partners (27.0%)</span>
                                </div>
                                <div style="height:8px; background:#F0ECE1; border-radius:4px; overflow:hidden;">
                                    <div style="width:27%; height:100%; background:linear-gradient(90deg, #D4AF37, #FFE57F);"></div>
                                </div>
                            </div>

                            <div>
                                <div style="display:flex; justify-content:space-between; font-size:0.75rem; font-weight:700; margin-bottom:4px;">
                                    <span>★ Silver Growth (15% Margin)</span>
                                    <span style="color:#8A681F; font-weight:800;">160 Partners (46.0%)</span>
                                </div>
                                <div style="height:8px; background:#F0ECE1; border-radius:4px; overflow:hidden;">
                                    <div style="width:46%; height:100%; background:#94A3B8;"></div>
                                </div>
                            </div>

                            <div>
                                <div style="display:flex; justify-content:space-between; font-size:0.75rem; font-weight:700; margin-bottom:4px;">
                                    <span>★ Bronze Starters (10% Margin)</span>
                                    <span style="color:#8A681F; font-weight:800;">52 Partners (14.9%)</span>
                                </div>
                                <div style="height:8px; background:#F0ECE1; border-radius:4px; overflow:hidden;">
                                    <div style="width:14.9%; height:100%; background:#FCD34D;"></div>
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
<script>
document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('resellerGmvChart');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    canvas.width = canvas.parentElement.clientWidth;
    canvas.height = 220;

    const data = [28, 32, 36, 41, 45, 48.6];
    const labels = ['Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'];
    const max = 60;

    // Draw gradient
    const grad = ctx.createLinearGradient(0, 0, 0, 200);
    grad.addColorStop(0, 'rgba(212, 175, 55, 0.45)');
    grad.addColorStop(1, 'rgba(212, 175, 55, 0.0)');

    ctx.beginPath();
    const step = (canvas.width - 40) / (data.length - 1);
    data.forEach((val, i) => {
        const x = 20 + (i * step);
        const y = 190 - ((val / max) * 160);
        if (i === 0) ctx.moveTo(x, y);
        else ctx.lineTo(x, y);
    });
    ctx.lineTo(canvas.width - 20, 200);
    ctx.lineTo(20, 200);
    ctx.closePath();
    ctx.fillStyle = grad;
    ctx.fill();

    // Draw stroke line
    ctx.beginPath();
    ctx.strokeStyle = '#8A681F';
    ctx.lineWidth = 3;
    data.forEach((val, i) => {
        const x = 20 + (i * step);
        const y = 190 - ((val / max) * 160);
        if (i === 0) ctx.moveTo(x, y);
        else ctx.lineTo(x, y);
    });
    ctx.stroke();

    // Draw Points
    data.forEach((val, i) => {
        const x = 20 + (i * step);
        const y = 190 - ((val / max) * 160);
        ctx.beginPath();
        ctx.arc(x, y, 5, 0, Math.PI * 2);
        ctx.fillStyle = '#FFFFFF';
        ctx.fill();
        ctx.lineWidth = 2.5;
        ctx.strokeStyle = '#8A681F';
        ctx.stroke();

        ctx.fillStyle = '#181512';
        ctx.font = 'bold 11px Plus Jakarta Sans, sans-serif';
        ctx.fillText(`₹${val}L`, x - 12, y - 10);
        ctx.fillStyle = '#78716C';
        ctx.fillText(labels[i], x - 10, 212);
    });
});
</script>
</body>
</html>
