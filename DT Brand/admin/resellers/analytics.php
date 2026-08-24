<?php
/**
 * analytics.php — DT Brand's & Jai Hanuman Tex
 * Reseller Analytics & GMV Growth Studio
 */
$page_title = "Reseller Analytics Studio";
$active_nav = "resellers";
$active_subnav = "analytics";

$top_partners = [
    [
        'rank' => 1,
        'id' => 'RES-1048',
        'name' => 'Arniya Silk Heritage',
        'city' => 'Surat, Gujarat',
        'gmv' => '₹6,45,000',
        'orders' => '38 Orders',
        'tier' => 'Platinum Elite (30%)',
        'badge' => 'gold',
        'health' => '100% On-Time'
    ],
    [
        'rank' => 2,
        'id' => 'RES-1050',
        'name' => 'Royal Banarasi Heritage',
        'city' => 'Varanasi, Uttar Pradesh',
        'gmv' => '₹5,90,000',
        'orders' => '32 Orders',
        'tier' => 'Platinum Elite (30%)',
        'badge' => 'gold',
        'health' => '100% On-Time'
    ],
    [
        'rank' => 3,
        'id' => 'RES-1049',
        'name' => 'Surat Fab Sarees Hub',
        'city' => 'Surat, Gujarat',
        'gmv' => '₹3,80,000',
        'orders' => '29 Orders',
        'tier' => 'Gold Dropshipper (22%)',
        'badge' => 'emerald',
        'health' => '98% On-Time'
    ],
    [
        'rank' => 4,
        'id' => 'RES-1052',
        'name' => 'Jaipur Block Handloom Hub',
        'city' => 'Jaipur, Rajasthan',
        'gmv' => '₹2,40,000',
        'orders' => '22 Orders',
        'tier' => 'Gold Dropshipper (22%)',
        'badge' => 'emerald',
        'health' => '95% On-Time'
    ],
    [
        'rank' => 5,
        'id' => 'RES-1051',
        'name' => 'Kanchipuram Silk Palace',
        'city' => 'Chennai, Tamil Nadu',
        'gmv' => '₹1,65,000',
        'orders' => '12 Orders',
        'tier' => 'Silver Boutique (15%)',
        'badge' => 'blue',
        'health' => '100% On-Time'
    ]
];
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
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/resellers/assets/css/resellers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/resellers/assets/css/reseller-analytics.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/resellers/assets/css/reseller-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 18px 20px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-customers-container" style="display:flex; flex-direction:column; gap:16px; margin-bottom:24px;">
                <!-- ══ TOP HEADER ══ -->
                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:4px;">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span>Reseller Growth &amp; GMV Velocity Analytics</span>
                            <span class="dt-cust-badge gold" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:800;">₹48.6L Volume</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Inspect network expansion metrics, commission payouts burn rate, and top grossing partner stores.</p>
                    </div>
                    <div class="dt-cust-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="/DT%20Brand/admin/resellers/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            <span>Back to Resellers</span>
                        </a>
                        <button type="button" class="dt-btn dt-btn-gold" onclick="exportAnalyticsReport()">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Export Report</span>
                        </button>
                    </div>
                </div>

                <!-- 8-Card KPI Ribbon & Flow Filter Pills -->
                <?php include __DIR__ . '/components/reseller-stats.php'; ?>

                <!-- ══ ANALYTICS STUDIO CHARTS GRID ══ -->
                <div class="dt-reseller-analytics-grid">
                    
                    <!-- Chart 1: Visual Monthly GMV Growth -->
                    <div class="dt-analytics-chart-card">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                            <div>
                                <h4 style="font-size:0.92rem; font-weight:800; color:#181512; margin:0;">Monthly Network GMV Growth</h4>
                                <small style="font-size:0.7rem; color:#78716C;">Network B2B wholesale saree transaction volume (Last 6 Months)</small>
                            </div>
                            <span class="dt-cust-badge emerald" style="font-size:0.7rem; font-weight:800; background:#DCFCE7; color:#15803D; border:1px solid #86EFAC; padding:2px 8px; border-radius:6px;">
                                +18.4% MoM
                            </span>
                        </div>

                        <!-- Bar Chart Canvas -->
                        <div class="dt-chart-bars-wrap">
                            <div class="dt-chart-bar-group">
                                <span class="dt-chart-bar-val">₹28.4L</span>
                                <div class="dt-chart-bar-pill" style="height:55%;"></div>
                                <span class="dt-chart-bar-label">Nov</span>
                            </div>
                            <div class="dt-chart-bar-group">
                                <span class="dt-chart-bar-val">₹33.2L</span>
                                <div class="dt-chart-bar-pill" style="height:65%;"></div>
                                <span class="dt-chart-bar-label">Dec</span>
                            </div>
                            <div class="dt-chart-bar-group">
                                <span class="dt-chart-bar-val">₹37.5L</span>
                                <div class="dt-chart-bar-pill" style="height:74%;"></div>
                                <span class="dt-chart-bar-label">Jan</span>
                            </div>
                            <div class="dt-chart-bar-group">
                                <span class="dt-chart-bar-val">₹39.0L</span>
                                <div class="dt-chart-bar-pill" style="height:78%;"></div>
                                <span class="dt-chart-bar-label">Feb</span>
                            </div>
                            <div class="dt-chart-bar-group">
                                <span class="dt-chart-bar-val">₹43.8L</span>
                                <div class="dt-chart-bar-pill" style="height:88%;"></div>
                                <span class="dt-chart-bar-label">Mar</span>
                            </div>
                            <div class="dt-chart-bar-group">
                                <span class="dt-chart-bar-val" style="color:#8A681F; font-weight:900; background:#FAF5E8; border-color:#D4AF37;">₹48.6L</span>
                                <div class="dt-chart-bar-pill active" style="height:100%;"></div>
                                <span class="dt-chart-bar-label" style="color:#8A681F; font-weight:900;">Apr (Peak)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Chart 2: Tier Distribution & Margin Split -->
                    <div class="dt-analytics-chart-card">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                            <div>
                                <h4 style="font-size:0.92rem; font-weight:800; color:#181512; margin:0;">Tier Distribution &amp; Margin Split</h4>
                                <small style="font-size:0.7rem; color:#78716C;">Partner volume distribution across wholesale discount tiers</small>
                            </div>
                            <span class="dt-cust-badge gold" style="font-size:0.7rem; font-weight:800; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; padding:2px 8px; border-radius:6px;">
                                348 Total
                            </span>
                        </div>

                        <div style="display:flex; flex-direction:column; gap:12px; background:#FAF8F4; padding:14px; border-radius:10px; border:1.2px solid #EAE5D9;">
                            <!-- Tier 1: Platinum Elite -->
                            <div>
                                <div style="display:flex; justify-content:space-between; font-size:0.75rem; font-weight:800; margin-bottom:4px;">
                                    <span style="color:#181512;">Platinum Elite (30% Margin)</span>
                                    <span style="color:#8A681F;">42 Partners (12%)</span>
                                </div>
                                <div style="height:8px; background:#EAE5D9; border-radius:4px; overflow:hidden;">
                                    <div style="width:12%; height:100%; background:linear-gradient(90deg, #D4AF37, #B8860B); border-radius:4px;"></div>
                                </div>
                            </div>

                            <!-- Tier 2: Gold Partner -->
                            <div>
                                <div style="display:flex; justify-content:space-between; font-size:0.75rem; font-weight:800; margin-bottom:4px;">
                                    <span style="color:#181512;">Gold Partner (22% Margin)</span>
                                    <span style="color:#15803D;">124 Partners (36%)</span>
                                </div>
                                <div style="height:8px; background:#EAE5D9; border-radius:4px; overflow:hidden;">
                                    <div style="width:36%; height:100%; background:linear-gradient(90deg, #16A34A, #15803D); border-radius:4px;"></div>
                                </div>
                            </div>

                            <!-- Tier 3: Silver Growth -->
                            <div>
                                <div style="display:flex; justify-content:space-between; font-size:0.75rem; font-weight:800; margin-bottom:4px;">
                                    <span style="color:#181512;">Silver Growth (15% Margin)</span>
                                    <span style="color:#1D4ED8;">130 Partners (37%)</span>
                                </div>
                                <div style="height:8px; background:#EAE5D9; border-radius:4px; overflow:hidden;">
                                    <div style="width:37%; height:100%; background:linear-gradient(90deg, #3B82F6, #1D4ED8); border-radius:4px;"></div>
                                </div>
                            </div>

                            <!-- Tier 4: Bronze Starter -->
                            <div>
                                <div style="display:flex; justify-content:space-between; font-size:0.75rem; font-weight:800; margin-bottom:4px;">
                                    <span style="color:#181512;">Bronze Starter (10% Margin)</span>
                                    <span style="color:#B45309;">52 Partners (15%)</span>
                                </div>
                                <div style="height:8px; background:#EAE5D9; border-radius:4px; overflow:hidden;">
                                    <div style="width:15%; height:100%; background:linear-gradient(90deg, #F59E0B, #B45309); border-radius:4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ══════════════════════════════════════════════════════════════
                     TOP 5 GROSSING RESELLER PARTNERS LEADERBOARD
                ══════════════════════════════════════════════════════════════ -->
                <div class="dt-card" style="background:#FFFFFF; border:1.5px solid #EAE5D9; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.02); overflow:hidden;">
                    <div style="padding:14px 18px; border-bottom:1.5px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; background:#FAF8F4;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:30px; height:30px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.4"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            </div>
                            <div>
                                <h4 style="font-size:0.92rem; font-weight:800; color:#181512; margin:0;">Top Grossing Reseller Partners Leaderboard</h4>
                                <p style="font-size:0.7rem; color:#78716C; margin:1px 0 0 0;">Highest GMV contributing wholesale &amp; dropship saree stores.</p>
                            </div>
                        </div>
                        <a href="/DT%20Brand/admin/resellers/index.php" class="dt-btn dt-btn-pale dt-btn-sm">
                            <span>View All 348 Resellers</span>
                        </a>
                    </div>

                    <div style="overflow-x:auto; width:100%;">
                        <table class="dt-leaderboard-table">
                            <thead>
                                <tr>
                                    <th style="width:60px; text-align:center; white-space:nowrap;">Rank</th>
                                    <th style="white-space:nowrap;">Partner Store &amp; Hub</th>
                                    <th style="text-align:right; white-space:nowrap;">Quarterly GMV (₹)</th>
                                    <th style="white-space:nowrap;">Order Frequency</th>
                                    <th style="white-space:nowrap;">Assigned Tier</th>
                                    <th style="white-space:nowrap;">Credit Health</th>
                                    <th style="text-align:right; white-space:nowrap;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($top_partners as $p): ?>
                                    <tr style="border-bottom:1px solid #F1ECE1;">
                                        <td style="text-align:center; white-space:nowrap;">
                                            <span class="dt-rank-badge rank-<?php echo $p['rank']; ?> rank-def">
                                                <?php echo $p['rank']; ?>
                                            </span>
                                        </td>
                                        <td style="white-space:nowrap;">
                                            <a href="/DT%20Brand/admin/resellers/view.php?id=<?php echo $p['id']; ?>" style="color:#181512; text-decoration:none; font-weight:800; font-size:0.82rem;">
                                                <?php echo htmlspecialchars($p['name']); ?>
                                            </a>
                                            <div style="font-size:0.7rem; color:#78716C;"><?php echo htmlspecialchars($p['city']); ?> • <span style="font-family:monospace;"><?php echo $p['id']; ?></span></div>
                                        </td>
                                        <td style="text-align:right; font-weight:900; color:#181512; font-size:0.88rem; white-space:nowrap;">
                                            <?php echo $p['gmv']; ?>
                                        </td>
                                        <td style="color:#181512; font-weight:600; font-size:0.75rem; white-space:nowrap;"><?php echo $p['orders']; ?></td>
                                        <td style="white-space:nowrap;">
                                            <span class="dt-status-pill-clean <?php echo $p['badge']; ?>">
                                                <?php echo $p['tier']; ?>
                                            </span>
                                        </td>
                                        <td style="color:#15803D; font-weight:700; font-size:0.72rem; white-space:nowrap;">
                                            ✓ <?php echo $p['health']; ?>
                                        </td>
                                        <td style="text-align:right; white-space:nowrap;">
                                            <a href="/DT%20Brand/admin/resellers/view.php?id=<?php echo $p['id']; ?>" class="dt-btn dt-btn-pale dt-btn-sm">
                                                <span>Profile</span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/DT%20Brand/admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
<script>
function exportAnalyticsReport() {
    const rows = [
        ['Rank', 'Reseller ID', 'Partner Store', 'City', 'Quarterly GMV (INR)', 'Order Velocity', 'Tier Plan'],
        ['1', 'RES-1048', 'Arniya Silk Heritage', 'Surat, Gujarat', '645000', '38 Orders/Mo', 'Platinum Elite (30%)'],
        ['2', 'RES-1050', 'Royal Banarasi Heritage', 'Varanasi, UP', '590000', '32 Orders/Mo', 'Platinum Elite (30%)'],
        ['3', 'RES-1049', 'Surat Fab Sarees Hub', 'Surat, Gujarat', '380000', '29 Orders/Mo', 'Gold Dropshipper (22%)'],
        ['4', 'RES-1052', 'Jaipur Block Handloom Hub', 'Jaipur, Rajasthan', '240000', '22 Orders/Mo', 'Gold Dropshipper (22%)'],
        ['5', 'RES-1051', 'Kanchipuram Silk Palace', 'Chennai, Tamil Nadu', '165000', '12 Orders/Mo', 'Silver Boutique (15%)']
    ];

    let csvContent = 'data:text/csv;charset=utf-8,' + rows.map(e => e.join(',')).join('\n');
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement('a');
    link.setAttribute('href', encodedUri);
    link.setAttribute('download', 'Reseller_Growth_Analytics_Report_Aug2026.csv');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    if (window.showToast) {
        window.showToast('📥 Downloading "Reseller_Growth_Analytics_Report_Aug2026.csv"...');
    }
}
</script>
</body>
</html>
