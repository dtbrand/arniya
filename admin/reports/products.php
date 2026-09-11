<?php
/**
 * products.php — DT Brand's & Jai Hanuman Tex Product Sales Performance
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

$limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 50;
$products = ReportManager::getProductsPerformanceReport($limit);

$page_title = "Product Sales Performance";
$active_nav = "reports";
$current_subnav = "products";

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
                        <span>Product Sales Performance</span>
                        <span class="dt-badge gold">Catalog Intelligence</span>
                    </h1>
                    <p class="adm-page-subtitle">Granular SKU-level analytics tracking units sold, gross merchandise value (GMV), stock turn velocity, and gross margins.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px; align-items:center;">
                    <a href="/admin/reports/" class="dt-btn dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        All Reports
                    </a>
                    <button type="button" class="dt-btn dt-btn-gold" data-export-type="products" data-export-format="csv">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Export Products CSV
                    </button>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="dt-report-toolbar">
                <div class="dt-report-toolbar-left">
                    <span style="font-size:0.8rem; font-weight:700; color:#64748B;">Showing Top:</span>
                    <div class="dt-report-pill-group">
                        <a href="?limit=25" class="dt-report-pill <?= $limit === 25 ? 'active' : '' ?>">Top 25</a>
                        <a href="?limit=50" class="dt-report-pill <?= $limit === 50 ? 'active' : '' ?>">Top 50</a>
                        <a href="?limit=100" class="dt-report-pill <?= $limit === 100 ? 'active' : '' ?>">Top 100</a>
                    </div>
                </div>
                <div class="dt-report-toolbar-right">
                    <button type="button" class="dt-btn dt-btn-pale dt-print-trigger" style="padding:6px 12px; font-size:0.75rem;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                        Print Sheet
                    </button>
                </div>
            </div>

            <!-- Performance Table Card -->
            <div class="dt-report-table-card">
                <div class="dt-report-table-header">
                    <div class="dt-report-table-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                        <span>Product Performance Rankings (By GMV)</span>
                    </div>
                    <span class="dt-badge gold"><?= count($products) ?> SKUs Listed</span>
                </div>
                <div class="adm-table-responsive" style="overflow-x:auto;">
                    <table class="dt-report-table">
                        <thead>
                            <tr>
                                <th>Product Details</th>
                                <th>Category</th>
                                <th style="text-align:right;">Retail Price</th>
                                <th style="text-align:right;">Wholesale Cost</th>
                                <th style="text-align:center;">Margin %</th>
                                <th style="text-align:center;">Live Stock</th>
                                <th style="text-align:center;">Units Sold</th>
                                <th style="text-align:right;">Total GMV</th>
                                <th style="text-align:center;">Velocity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $idx => $p): 
                                $velClass = 'gold';
                                if ($p['velocity'] === 'Fast Mover') $velClass = 'emerald';
                                elseif ($p['velocity'] === 'Slow Mover') $velClass = 'crimson';
                            ?>
                            <tr>
                                <td>
                                    <div style="font-weight:700; color:#111827;"><?= htmlspecialchars($p['title']) ?></div>
                                    <div style="font-size:0.75rem; color:#64748B;">SKU: <?= htmlspecialchars($p['sku']) ?></div>
                                </td>
                                <td>
                                    <span class="dt-badge blue"><?= htmlspecialchars($p['category']) ?></span>
                                </td>
                                <td style="text-align:right; font-weight:700; color:#111827;"><?= $rupeeSvg ?> <?= number_format($p['price']) ?></td>
                                <td style="text-align:right; color:#64748B;"><?= $rupeeSvg ?> <?= number_format($p['cost_price']) ?></td>
                                <td style="text-align:center; font-weight:800; color:#15803D;"><?= $p['margin_pct'] ?>%</td>
                                <td style="text-align:center;">
                                    <?php if ($p['stock'] <= 0): ?>
                                        <span class="dt-badge crimson">Out of Stock</span>
                                    <?php elseif ($p['stock'] <= 5): ?>
                                        <span class="dt-badge amber"><?= $p['stock'] ?> Left</span>
                                    <?php else: ?>
                                        <span class="dt-badge emerald"><?= $p['stock'] ?> in stock</span>
                                    <?php endif; ?>
                                </td>
                                <td style="text-align:center; font-weight:800; font-size:0.95rem;"><?= number_format($p['units_sold']) ?></td>
                                <td style="text-align:right; font-weight:800; color:#111827;"><?= $rupeeSvg ?> <?= number_format($p['total_gmv']) ?></td>
                                <td style="text-align:center;">
                                    <span class="dt-badge <?= $velClass ?>"><?= htmlspecialchars($p['velocity']) ?></span>
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
