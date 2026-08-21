<?php
/**
 * analytics.php — Customer Growth, Retention & Cohort Analytics
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
$page_title = "Customer Analytics & Growth";
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
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customer-analytics.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-customers-container">
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Customer Analytics &amp; Growth Studio</span>
                            <span class="dt-cust-badge gold">LTV &amp; Cohort Trends</span>
                        </h1>
                        <p class="dt-cust-subtitle">Track new customer acquisition rate, repeat purchase intervals, and lifetime value trajectory.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/Frontend/Admin/customers/index.php" class="dt-btn dt-btn-pale">← Back to Directory</a>
                    </div>
                </div>

                <!-- Analytics Cards Grid -->
                <div class="dt-analytics-grid">
                    <!-- Growth Waveform Chart -->
                    <div class="dt-analytics-card">
                        <div class="dt-analytics-head">
                            <div>
                                <h3 class="dt-card-title">New vs Returning Shopper Growth</h3>
                                <p style="font-size:0.72rem; color:#78716C; margin:2px 0 0 0;">Monthly registration and reorder velocity (2025–2026)</p>
                            </div>
                        </div>

                        <div class="dt-analytics-canvas-wrap">
                            <canvas id="dtCustGrowthCanvas" width="480" height="200"></canvas>
                        </div>

                        <div class="dt-analytics-legend">
                            <div style="display:flex; align-items:center; gap:6px;">
                                <span class="dt-analytics-dot" style="background:#8A681F;"></span>
                                <span>New Shoppers (+348/mo)</span>
                            </div>
                            <div style="display:flex; align-items:center; gap:6px;">
                                <span class="dt-analytics-dot" style="background:#15803D;"></span>
                                <span>Repeat Reorders (38.4%)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Cohort Retention Heatmap -->
                    <div class="dt-analytics-card">
                        <div class="dt-analytics-head">
                            <div>
                                <h3 class="dt-card-title">Customer Cohort Retention Matrix</h3>
                                <p style="font-size:0.72rem; color:#78716C; margin:2px 0 0 0;">Percentage of shoppers returning in subsequent months</p>
                            </div>
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
                                        <td><strong>Nov 2025</strong></td>
                                        <td>420</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7;">100%</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7;">42.8%</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7;">36.1%</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7;">31.4%</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7;">28.9%</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Dec 2025</strong></td>
                                        <td>580</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7;">100%</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7;">46.2%</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7;">39.0%</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7;">34.5%</td>
                                        <td style="color:#9CA3AF;">—</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Jan 2026</strong></td>
                                        <td>610</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7;">100%</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7;">44.1%</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7;">37.8%</td>
                                        <td style="color:#9CA3AF;">—</td>
                                        <td style="color:#9CA3AF;">—</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Feb 2026</strong></td>
                                        <td>540</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7;">100%</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7;">48.5%</td>
                                        <td style="color:#9CA3AF;">—</td>
                                        <td style="color:#9CA3AF;">—</td>
                                        <td style="color:#9CA3AF;">—</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mar 2026</strong></td>
                                        <td>690</td>
                                        <td class="dt-cohort-cell" style="background:#DCFCE7;">100%</td>
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
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('dtCustGrowthCanvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    const dpr = window.devicePixelRatio || 1;
    const w = canvas.parentElement.clientWidth || 440;
    const h = 200;
    canvas.width = w * dpr;
    canvas.height = h * dpr;
    canvas.style.width = w + 'px';
    canvas.style.height = h + 'px';
    ctx.scale(dpr, dpr);

    const labels = ['Nov', 'Dec', 'Jan', 'Feb', 'Mar', 'Apr'];
    const newCust = [420, 580, 610, 540, 690, 720];
    const repeatCust = [180, 268, 270, 262, 330, 360];
    const maxVal = 800;

    const padL = 30, padR = 20, padT = 15, padB = 25;
    const cW = w - padL - padR;
    const cH = h - padT - padB;

    // Grid lines
    ctx.strokeStyle = '#F0ECE1';
    ctx.lineWidth = 1;
    ctx.setLineDash([3, 3]);
    for (let i = 1; i <= 3; i++) {
        const y = padT + (cH / 3) * i;
        ctx.beginPath();
        ctx.moveTo(padL, y);
        ctx.lineTo(w - padR, y);
        ctx.stroke();
    }
    ctx.setLineDash([]);

    // Draw Smooth Line 1 (New Shoppers)
    ctx.strokeStyle = '#8A681F';
    ctx.lineWidth = 2.5;
    ctx.beginPath();
    labels.forEach((lbl, i) => {
        const x = padL + (i * (cW / (labels.length - 1)));
        const y = h - padB - ((newCust[i] / maxVal) * cH);
        if (i === 0) ctx.moveTo(x, y);
        else ctx.lineTo(x, y);
    });
    ctx.stroke();

    // Draw Smooth Line 2 (Repeat Shoppers)
    ctx.strokeStyle = '#15803D';
    ctx.lineWidth = 2.5;
    ctx.beginPath();
    labels.forEach((lbl, i) => {
        const x = padL + (i * (cW / (labels.length - 1)));
        const y = h - padB - ((repeatCust[i] / maxVal) * cH);
        if (i === 0) ctx.moveTo(x, y);
        else ctx.lineTo(x, y);
    });
    ctx.stroke();

    // X-Axis Labels
    ctx.fillStyle = '#78716C';
    ctx.font = '700 10px Plus Jakarta Sans, sans-serif';
    ctx.textAlign = 'center';
    labels.forEach((lbl, i) => {
        const x = padL + (i * (cW / (labels.length - 1)));
        ctx.fillText(lbl, x, h - padB + 16);
    });
});
</script>
</body>
</html>
