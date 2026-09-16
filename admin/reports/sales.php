<?php
/**
 * sales.php — DT Brand's & Jai Hanuman Tex Sales & Channel Analytics
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

$range = isset($_GET['range']) ? trim($_GET['range']) : 'all';
$channel = isset($_GET['channel']) ? trim($_GET['channel']) : 'all';

$sales = ReportManager::getSalesReport($range, $channel);

$page_title = "Sales & Channel Analytics";
$active_nav = "reports";
$current_subnav = "sales";

$rupeeSvg = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1.5px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> — DT Brand's Admin</title>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#8A681F">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?= @filemtime(__DIR__ . '/../assets/css/admin.css') ?: '3.2.1' ?>">
    <link rel="stylesheet" href="/admin/reports/reports.css?v=<?= @filemtime(__DIR__ . '/reports.css') ?: '3.2.1' ?>">
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
                        <span>Sales &amp; Channel Analytics</span>
                        <span class="dt-badge gold">Channel Intelligence</span>
                    </h1>
                    <p class="adm-page-subtitle">Real-time revenue attribution across B2B Wholesale, B2B Retailer trade, Reseller networks, and Direct Storefront.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px; align-items:center;">
                    <a href="/admin/reports/" class="dt-btn dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        All Reports
                    </a>
                    <button type="button" class="dt-btn dt-btn-gold" data-export-type="sales" data-export-format="csv">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Export Sales CSV
                    </button>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="dt-report-toolbar">
                <div class="dt-report-toolbar-left">
                    <span style="font-size:0.8rem; font-weight:700; color:#64748B;">Date Range:</span>
                    <div class="dt-report-pill-group">
                        <button type="button" class="dt-report-pill <?= $range === 'all' ? 'active' : '' ?>" data-range="all">All Time</button>
                        <button type="button" class="dt-report-pill <?= $range === 'today' ? 'active' : '' ?>" data-range="today">Today</button>
                        <button type="button" class="dt-report-pill <?= $range === '7d' ? 'active' : '' ?>" data-range="7d">Last 7 Days</button>
                        <button type="button" class="dt-report-pill <?= $range === '30d' ? 'active' : '' ?>" data-range="30d">Last 30 Days</button>
                        <button type="button" class="dt-report-pill <?= $range === 'mtd' ? 'active' : '' ?>" data-range="mtd">This Month</button>
                    </div>
                </div>
                <div class="dt-report-toolbar-right">
                    <button type="button" class="dt-btn dt-btn-pale dt-print-trigger" style="padding:6px 12px; font-size:0.75rem;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                        Print Sheet
                    </button>
                </div>
            </div>

            <!-- Summary KPI Ribbon -->
            <div class="dt-report-kpi-grid">
                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Total Invoiced Sales</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $rupeeSvg ?> <?= number_format($sales['total_revenue']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge emerald"><?= number_format($sales['total_orders']) ?> Orders Recorded</span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">B2B Wholesale Share</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $rupeeSvg ?> <?= number_format($sales['channels']['wholesale']['revenue']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge gold"><?= $sales['channels']['wholesale']['share'] ?>% of Total Sales</span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Retailer Trade</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $rupeeSvg ?> <?= number_format($sales['channels']['retailer']['revenue']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge amber"><?= $sales['channels']['retailer']['count'] ?> Orders Placed</span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Reseller &amp; Social</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $rupeeSvg ?> <?= number_format($sales['channels']['reseller']['revenue']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge emerald">AOV: <?= $rupeeSvg ?> <?= number_format($sales['channels']['reseller']['aov']) ?></span>
                    </div>
                </div>
            </div>

            <!-- Channels Detail Table -->
            <div class="dt-report-table-card">
                <div class="dt-report-table-header">
                    <div class="dt-report-table-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        <span>Channel Matrix &amp; Unit Economics</span>
                    </div>
                </div>
                <div class="adm-table-responsive" style="overflow-x:auto;">
                    <table class="dt-report-table">
                        <thead>
                            <tr>
                                <th>Channel</th>
                                <th style="text-align:center;">Orders</th>
                                <th style="text-align:right;">Gross Volume</th>
                                <th style="text-align:right;">Average Order Value (AOV)</th>
                                <th style="text-align:center;">Contribution Share</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sales['channels'] as $code => $ch): ?>
                            <tr>
                                <td>
                                    <div style="font-weight:700; color:#111827;"><?= htmlspecialchars($ch['name']) ?></div>
                                    <div style="font-size:0.75rem; color:#64748B;">Identifier: <?= htmlspecialchars($code) ?></div>
                                </td>
                                <td style="text-align:center; font-weight:700;"><?= number_format($ch['count']) ?></td>
                                <td style="text-align:right; font-weight:800; color:#111827;"><?= $rupeeSvg ?> <?= number_format($ch['revenue']) ?></td>
                                <td style="text-align:right; color:#475569; font-weight:600;"><?= $rupeeSvg ?> <?= number_format($ch['aov']) ?></td>
                                <td style="text-align:center;">
                                    <div style="display:flex; align-items:center; gap:8px; justify-content:center;">
                                        <div class="dt-progress-bar-wrap" style="width:80px;">
                                            <div class="dt-progress-bar-fill" style="width:<?= $ch['share'] ?>%; background:<?= $ch['color'] ?>;"></div>
                                        </div>
                                        <span style="font-size:0.78rem; font-weight:800;"><?= $ch['share'] ?>%</span>
                                    </div>
                                </td>
                                <td style="text-align:center;">
                                    <a href="/api/reports.php?action=export&type=sales&channel=<?= urlencode($code) ?>&format=csv" class="dt-btn dt-btn-pale" style="padding:4px 8px; font-size:0.72rem;">CSV</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Daily Run Rate Trend Table -->
            <?php if (!empty($sales['trend'])): ?>
            <div class="dt-report-table-card">
                <div class="dt-report-table-header">
                    <div class="dt-report-table-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
                        <span>Daily Run Rate Trend Ledger</span>
                    </div>
                </div>
                <div class="adm-table-responsive" style="overflow-x:auto; max-height:360px;">
                    <table class="dt-report-table">
                        <thead>
                            <tr>
                                <th>Transaction Date</th>
                                <th style="text-align:center;">Orders Placed</th>
                                <th style="text-align:right;">Gross Sales Invoiced</th>
                                <th style="text-align:right;">Day AOV</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_reverse($sales['trend']) as $t): 
                                $dayAov = $t['cnt'] > 0 ? round($t['rev'] / $t['cnt'], 2) : 0;
                            ?>
                            <tr>
                                <td style="font-weight:700; color:#111827;"><?= htmlspecialchars($t['dt']) ?></td>
                                <td style="text-align:center; font-weight:700;"><?= number_format($t['cnt']) ?></td>
                                <td style="text-align:right; font-weight:800; color:#111827;"><?= $rupeeSvg ?> <?= number_format($t['rev']) ?></td>
                                <td style="text-align:right; color:#475569;"><?= $rupeeSvg ?> <?= number_format($dayAov) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?= @filemtime(__DIR__ . '/../assets/js/admin.js') ?: '3.2.1' ?>"></script>
<script src="/admin/reports/reports.js?v=<?= @filemtime(__DIR__ . '/reports.js') ?: '3.2.1' ?>"></script>
</body>
</html>
