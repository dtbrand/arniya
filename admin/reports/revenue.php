<?php
/**
 * revenue.php — DT Brand's & Jai Hanuman Tex Master Revenue & Net Profit Statement Engine
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

// Handle Direct CSV Export if requested
if (isset($_GET['download']) && in_array($_GET['download'], ['pnl', 'csv', 'excel'], true)) {
    if ($_GET['download'] === 'excel') {
        ReportManager::exportToExcel('revenue', $range);
    } else {
        ReportManager::exportToCsv('revenue', $range);
    }
    exit;
}

$revData = ReportManager::getRevenueReport($range);

$page_title = "Revenue & Net Profit Statement";
$active_nav = "reports";
$current_subnav = "revenue";

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
                        <span>Revenue &amp; Net Profit Statement</span>
                        <span class="dt-badge emerald">P&amp;L Ledger</span>
                    </h1>
                    <p class="adm-page-subtitle">Comprehensive manufacturing P&amp;L analysis: raw silk lots, metallurgy zari, weaver wages, transit freight, and net operating margins.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px; align-items:center;">
                    <a href="/admin/reports/" class="dt-btn dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        All Reports
                    </a>
                    <a href="/admin/reports/revenue.php?download=pnl&range=<?= urlencode($range) ?>" class="dt-btn dt-btn-gold">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Download P&amp;L Statement
                    </a>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="dt-report-toolbar">
                <div class="dt-report-toolbar-left">
                    <span style="font-size:0.8rem; font-weight:700; color:#64748B;">Time Window:</span>
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
                        Print Statement
                    </button>
                </div>
            </div>

            <!-- Summary KPI Ribbon -->
            <div class="dt-report-kpi-grid">
                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Gross Billed Sales</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $rupeeSvg ?> <?= number_format($revData['gross_revenue']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge emerald">100.0% Gross Baseline</span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Total Manufacturing COGS</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $rupeeSvg ?> <?= number_format($revData['total_cogs']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge amber">Direct Material &amp; Labor</span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Gross Trading Margin</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $rupeeSvg ?> <?= number_format($revData['gross_profit']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge gold"><?= $revData['gross_margin_pct'] ?>% Wholesale Margin</span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">EBITDA Net Retained Profit</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $rupeeSvg ?> <?= number_format($revData['net_profit']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge emerald"><?= $revData['net_margin_pct'] ?>% Net Operating Surplus</span>
                    </div>
                </div>
            </div>

            <!-- Detailed Statement Ledger Table -->
            <div class="dt-report-table-card">
                <div class="dt-report-table-header">
                    <div class="dt-report-table-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        <span>Executive Profit &amp; Loss Statement Ledger</span>
                    </div>
                </div>
                <div class="adm-table-responsive" style="overflow-x:auto;">
                    <table class="dt-report-table">
                        <thead>
                            <tr>
                                <th>Ledger Account / Expense Category</th>
                                <th>Operational Description</th>
                                <th style="text-align:right;">Amount (INR)</th>
                                <th style="text-align:center;">Share of Revenue</th>
                                <th style="text-align:center;">Accounting Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="background:#F8FAFC; font-weight:800;">
                                <td style="color:#111827;">GROSS BILLED REVENUE</td>
                                <td style="color:#64748B;">B2B Wholesale + D2C Retail Invoiced Volume</td>
                                <td style="text-align:right; color:#111827;"><?= $rupeeSvg ?> <?= number_format($revData['gross_revenue'], 2) ?></td>
                                <td style="text-align:center;"><span class="dt-badge gold">100.0%</span></td>
                                <td style="text-align:center;"><span class="dt-badge emerald">Realized</span></td>
                            </tr>
                            <?php foreach ($revData['cogs_items'] as $item): ?>
                            <tr>
                                <td style="padding-left:28px; font-weight:600; color:#334155;"><?= htmlspecialchars($item['name']) ?></td>
                                <td style="color:#64748B; font-size:0.78rem;"><?= htmlspecialchars($item['desc']) ?></td>
                                <td style="text-align:right; color:#B45309; font-weight:700;">- <?= $rupeeSvg ?> <?= number_format($item['amount'], 2) ?></td>
                                <td style="text-align:center; color:#64748B;"><?= $item['pct'] ?>%</td>
                                <td style="text-align:center;"><span class="dt-badge blue">Disbursed</span></td>
                            </tr>
                            <?php endforeach; ?>
                            <tr style="background:#FAF8F4; font-weight:800; border-top:2px solid #E6CA65;">
                                <td style="color:#8A681F;">TOTAL COST OF GOODS SOLD (COGS)</td>
                                <td style="color:#64748B;">Direct textile procurement &amp; artisanal production</td>
                                <td style="text-align:right; color:#B45309;"><?= $rupeeSvg ?> <?= number_format($revData['total_cogs'], 2) ?></td>
                                <td style="text-align:center;"><?= round(100 - $revData['gross_margin_pct'], 1) ?>%</td>
                                <td style="text-align:center;"><span class="dt-badge amber">Settled</span></td>
                            </tr>
                            <tr style="background:#F0FDF4; font-weight:800;">
                                <td style="color:#15803D;">GROSS TRADING PROFIT</td>
                                <td style="color:#64748B;">Surat Depot Wholesale Trading Surplus</td>
                                <td style="text-align:right; color:#15803D;"><?= $rupeeSvg ?> <?= number_format($revData['gross_profit'], 2) ?></td>
                                <td style="text-align:center;"><span class="dt-badge gold"><?= $revData['gross_margin_pct'] ?>%</span></td>
                                <td style="text-align:center;"><span class="dt-badge emerald">Retained</span></td>
                            </tr>
                            <tr>
                                <td style="padding-left:28px; font-weight:600; color:#334155;">Operating &amp; Depot Overheads</td>
                                <td style="color:#64748B; font-size:0.78rem;">Surat depot lease, electricity, administrative staff, IT servers</td>
                                <td style="text-align:right; color:#DC2626; font-weight:700;">- <?= $rupeeSvg ?> <?= number_format($revData['operating_expenses'], 2) ?></td>
                                <td style="text-align:center; color:#64748B;">8.0%</td>
                                <td style="text-align:center;"><span class="dt-badge blue">Paid</span></td>
                            </tr>
                            <tr style="background:#ECFDF5; font-weight:800; font-size:0.95rem; border-top:2px solid #15803D;">
                                <td style="color:#111827;">NET RETAINED PROFIT (EBITDA)</td>
                                <td style="color:#64748B;">Post-Operational Retained Net Earnings</td>
                                <td style="text-align:right; color:#15803D;"><?= $rupeeSvg ?> <?= number_format($revData['net_profit'], 2) ?></td>
                                <td style="text-align:center;"><span class="dt-badge emerald"><?= $revData['net_margin_pct'] ?>%</span></td>
                                <td style="text-align:center;"><span class="dt-badge emerald">Surplus</span></td>
                            </tr>
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
