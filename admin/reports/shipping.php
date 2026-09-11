<?php
/**
 * shipping.php — DT Brand's & Jai Hanuman Tex Shipping & Carrier Logistics SLA
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
$shipData = ReportManager::getShippingReport($range);

$page_title = "Shipping & Carrier Logistics SLA";
$active_nav = "reports";
$current_subnav = "shipping";

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
                        <span>Shipping &amp; Carrier Logistics SLA</span>
                        <span class="dt-badge blue">Transit Intel</span>
                    </h1>
                    <p class="adm-page-subtitle">Monitor courier partner SLAs, delivery speed, Return to Origin (RTO) rates, and freight expenditure across India.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px; align-items:center;">
                    <a href="/admin/reports/" class="dt-btn dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        All Reports
                    </a>
                    <button type="button" class="dt-btn dt-btn-gold" data-export-type="shipping" data-export-format="csv">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Export Shipping CSV
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
                        <span class="dt-report-kpi-label">Dispatched Parcels</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= number_format($shipData['total_dispatched']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge emerald">Origin: <?= htmlspecialchars($shipData['origin_hub']) ?></span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Express Air Turnaround</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val">2.1 Days</div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge blue">BlueDart Air Priority</span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Average RTO Rate</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val">1.8%</div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge emerald">Ultra-Low Transit Failure</span>
                    </div>
                </div>
            </div>

            <!-- Carrier Table Card -->
            <div class="dt-report-table-card">
                <div class="dt-report-table-header">
                    <div class="dt-report-table-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span>Carrier Partner SLAs &amp; Dispatch Performance</span>
                    </div>
                </div>
                <div class="adm-table-responsive" style="overflow-x:auto;">
                    <table class="dt-report-table">
                        <thead>
                            <tr>
                                <th>Carrier Partner</th>
                                <th style="text-align:center;">Dispatched</th>
                                <th style="text-align:center;">Delivered</th>
                                <th style="text-align:center;">RTO Count</th>
                                <th style="text-align:center;">Avg Transit Days</th>
                                <th style="text-align:center;">Delivery Success Rate</th>
                                <th style="text-align:right;">Freight Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($shipData['carriers'] as $cid => $c): ?>
                            <tr>
                                <td>
                                    <div style="font-weight:700; color:#111827;"><?= htmlspecialchars($c['name']) ?></div>
                                    <div style="font-size:0.75rem; color:#64748B;">Routing Code: <?= htmlspecialchars($cid) ?></div>
                                </td>
                                <td style="text-align:center; font-weight:700;"><?= number_format($c['orders']) ?></td>
                                <td style="text-align:center; font-weight:800; color:#15803D;"><?= number_format($c['delivered']) ?></td>
                                <td style="text-align:center; font-weight:700; color:#DC2626;"><?= number_format($c['rto']) ?></td>
                                <td style="text-align:center; color:#475569;"><?= $c['avg_days'] ?> Days</td>
                                <td style="text-align:center;">
                                    <div style="display:flex; align-items:center; gap:8px; justify-content:center;">
                                        <div class="dt-progress-bar-wrap" style="width:70px;">
                                            <div class="dt-progress-bar-fill" style="width:<?= $c['success_rate'] ?>%; background:#15803D;"></div>
                                        </div>
                                        <span style="font-size:0.78rem; font-weight:800; color:#15803D;"><?= $c['success_rate'] ?>%</span>
                                    </div>
                                </td>
                                <td style="text-align:right; font-weight:800; color:#111827;"><?= $rupeeSvg ?> <?= number_format($c['cost']) ?></td>
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
