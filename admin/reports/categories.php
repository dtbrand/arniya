<?php
/**
 * categories.php — DT Brand's & Jai Hanuman Tex Category Sales & Margins
 * Section 33: Reports / Analytics & Export Suite
 */

/* DT admin access guard */
$__dtg = __DIR__ . '/../includes/adminguard.php';
if (!is_file($__dtg)) {
    $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php';
}
if (is_file($__dtg)) {
    require_once $__dtg;
}

require_once __DIR__ . '/../../src/ReportManager.php';
use DTBrand\ReportManager;

$catData = ReportManager::getCategoriesReport();

$page_title = "Category Sales & Margins";
$active_nav = "reports";
$current_subnav = "categories";

$rupeeSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1.5px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?= time() ?>">
    <link rel="stylesheet" href="/admin/reports/reports.css?v=<?= time() ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Category Sales &amp; Margins</span>
                        <span class="dt-badge gold">Product Mix</span>
                    </h1>
                    <p class="adm-page-subtitle">Understand product pillar revenue distribution across Handloom Silk Sarees, Kurtis, Festive Lehengas, and Wedding lines.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px; align-items:center;">
                    <a href="/admin/reports/" class="dt-btn dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        All Reports
                    </a>
                    <button type="button" class="dt-btn dt-btn-gold" data-export-type="categories" data-export-format="csv">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Export Categories CSV
                    </button>
                </div>
            </div>

            <!-- Summary KPI Ribbon -->
            <div class="dt-report-kpi-grid">
                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Total Catalog GMV</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $rupeeSvg ?> <?= number_format($catData['total_gmv']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge emerald"><?= count($catData['categories']) ?> Active Pillars</span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Top Category Pillar</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        </div>
                    </div>
                    <?php $topCat = !empty($catData['categories']) ? $catData['categories'][0] : null; ?>
                    <div class="dt-report-kpi-val"><?= $topCat ? htmlspecialchars($topCat['name']) : 'Silk Sarees' ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge gold"><?= $topCat ? $topCat['share_pct'] : 84.9 ?>% Market Share</span>
                    </div>
                </div>
            </div>

            <!-- Categories Table Card -->
            <div class="dt-report-table-card">
                <div class="dt-report-table-header">
                    <div class="dt-report-table-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>Category Pillars &amp; Commercial Breakdown</span>
                    </div>
                </div>
                <div class="adm-table-responsive" style="overflow-x:auto;">
                    <table class="dt-report-table">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th style="text-align:center;">Active SKUs</th>
                                <th style="text-align:center;">Units Sold</th>
                                <th style="text-align:right;">Average Price Point</th>
                                <th style="text-align:right;">Gross GMV Generated</th>
                                <th style="text-align:center;">Revenue Share</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($catData['categories'] as $c): ?>
                            <tr>
                                <td style="font-weight:700; color:#111827;"><?= htmlspecialchars($c['name']) ?></td>
                                <td style="text-align:center; font-weight:700;"><?= number_format($c['products_count']) ?></td>
                                <td style="text-align:center; font-weight:800;"><?= number_format($c['units_sold']) ?></td>
                                <td style="text-align:right; color:#475569;"><?= $rupeeSvg ?> <?= number_format($c['avg_price']) ?></td>
                                <td style="text-align:right; font-weight:800; color:#111827;"><?= $rupeeSvg ?> <?= number_format($c['gmv']) ?></td>
                                <td style="text-align:center;">
                                    <div style="display:flex; align-items:center; gap:8px; justify-content:center;">
                                        <div class="dt-progress-bar-wrap" style="width:90px;">
                                            <div class="dt-progress-bar-fill" style="width:<?= $c['share_pct'] ?>%;"></div>
                                        </div>
                                        <span style="font-size:0.78rem; font-weight:800;"><?= $c['share_pct'] ?>%</span>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?= time() ?>"></script>
<script src="/admin/reports/reports.js?v=<?= time() ?>"></script>
</body>
</html>
