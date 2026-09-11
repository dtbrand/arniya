<?php
/**
 * inventory.php — DT Brand's & Jai Hanuman Tex Inventory Valuation & Stock Turn
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

$inv = ReportManager::getInventoryReport();

$page_title = "Inventory Valuation & Stock Turn";
$active_nav = "reports";
$current_subnav = "inventory";

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
                        <span>Inventory Valuation &amp; Stock Turn</span>
                        <span class="dt-badge amber">Asset Audit</span>
                    </h1>
                    <p class="adm-page-subtitle">Real-time asset audit balancing physical warehouse units in Surat against wholesale acquisition cost and expected retail liquidation value.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px; align-items:center;">
                    <a href="/admin/reports/" class="dt-btn dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        All Reports
                    </a>
                    <button type="button" class="dt-btn dt-btn-gold" data-export-type="inventory" data-export-format="csv">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Export Inventory CSV
                    </button>
                </div>
            </div>

            <!-- Summary KPI Ribbon -->
            <div class="dt-report-kpi-grid">
                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Wholesale Cost Valuation</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $rupeeSvg ?> <?= number_format($inv['cost_valuation']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge gold"><?= number_format($inv['total_units']) ?> Total Units</span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Retail MRP Valuation</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $rupeeSvg ?> <?= number_format($inv['retail_valuation']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge emerald"><?= $inv['margin_potential_pct'] ?>% Margin Potential</span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Stock Health Balance</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= number_format($inv['in_stock_count']) ?> Healthy</div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge amber"><?= $inv['low_stock_count'] ?> Low Stock</span>
                        <span class="dt-badge crimson"><?= $inv['out_of_stock_count'] ?> Out of Stock</span>
                    </div>
                </div>
            </div>

            <!-- Inventory Valuation Table -->
            <div class="dt-report-table-card">
                <div class="dt-report-table-header">
                    <div class="dt-report-table-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                        <span>Inventory Ledger &amp; Valuation Sheet</span>
                    </div>
                </div>
                <div class="adm-table-responsive" style="overflow-x:auto;">
                    <table class="dt-report-table">
                        <thead>
                            <tr>
                                <th>SKU &amp; Product Title</th>
                                <th>Category</th>
                                <th style="text-align:center;">Warehouse Stock</th>
                                <th style="text-align:right;">Unit Cost</th>
                                <th style="text-align:right;">Unit Retail</th>
                                <th style="text-align:right;">Total Cost Value</th>
                                <th style="text-align:right;">Total Retail Value</th>
                                <th style="text-align:center;">Health Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($inv['ledger'] as $row): 
                                $badgeClass = 'emerald';
                                if ($row['status'] === 'Low Stock') $badgeClass = 'amber';
                                elseif ($row['status'] === 'Out of Stock') $badgeClass = 'crimson';
                            ?>
                            <tr>
                                <td>
                                    <div style="font-weight:700; color:#111827;"><?= htmlspecialchars($row['title']) ?></div>
                                    <div style="font-size:0.75rem; color:#64748B;">SKU: <?= htmlspecialchars($row['sku']) ?></div>
                                </td>
                                <td>
                                    <span class="dt-badge blue"><?= htmlspecialchars($row['category']) ?></span>
                                </td>
                                <td style="text-align:center; font-weight:800; font-size:0.95rem;"><?= number_format($row['stock']) ?></td>
                                <td style="text-align:right; color:#64748B;"><?= $rupeeSvg ?> <?= number_format($row['cost_price']) ?></td>
                                <td style="text-align:right; font-weight:700; color:#111827;"><?= $rupeeSvg ?> <?= number_format($row['retail_price']) ?></td>
                                <td style="text-align:right; font-weight:800; color:#B45309;"><?= $rupeeSvg ?> <?= number_format($row['total_cost_value']) ?></td>
                                <td style="text-align:right; font-weight:800; color:#15803D;"><?= $rupeeSvg ?> <?= number_format($row['total_retail_value']) ?></td>
                                <td style="text-align:center;">
                                    <span class="dt-badge <?= $badgeClass ?>"><?= htmlspecialchars($row['status']) ?></span>
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
