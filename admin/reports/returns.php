<?php
/**
 * returns.php — DT Brand's & Jai Hanuman Tex Returns, Exchanges & Refunds Report
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

$retData = ReportManager::getReturnsReport();

$page_title = "Returns, Exchanges & Refunds";
$active_nav = "reports";
$current_subnav = "returns";

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
                        <span>Returns, Exchanges &amp; Refunds</span>
                        <span class="dt-badge crimson">Reverse Logistics</span>
                    </h1>
                    <p class="adm-page-subtitle">Granular quality audit tracking returned parcels, manufacturing defect reasons, courier damage, and customer refunds.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px; align-items:center;">
                    <a href="/admin/reports/" class="dt-btn dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        All Reports
                    </a>
                    <button type="button" class="dt-btn dt-btn-gold" data-export-type="returns" data-export-format="csv">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Export Returns CSV
                    </button>
                </div>
            </div>

            <!-- Summary KPI Ribbon -->
            <div class="dt-report-kpi-grid">
                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Return Cases Recorded</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= number_format($retData['total_returns']) ?> Cases</div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge emerald">Industry-Low Return Rate</span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Disbursed Refunds</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $rupeeSvg ?> <?= number_format($retData['total_refund_amount']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge amber">Bank / UPI Disbursed</span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Top Reason for Return</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val" style="font-size:1.2rem;">Fabric / Snag</div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge gold">Quality Control Gate</span>
                    </div>
                </div>
            </div>

            <!-- Return Reasons Grid -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px; margin-bottom:20px;">
                <?php foreach ($retData['reasons'] as $rKey => $r): ?>
                <div style="background:#FFFFFF; border:1px solid #E2E8F0; border-radius:8px; padding:12px 16px; box-shadow:0 1px 3px rgba(0,0,0,0.03);">
                    <div style="font-size:0.75rem; color:#64748B; font-weight:700; text-transform:uppercase; margin-bottom:4px;"><?= htmlspecialchars($r['label']) ?></div>
                    <div style="font-size:1.3rem; font-weight:800; color:#111827;"><?= number_format($r['count']) ?> Cases</div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Returns Ledger Table -->
            <div class="dt-report-table-card">
                <div class="dt-report-table-header">
                    <div class="dt-report-table-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                        <span>Returns &amp; Reverse Transit Activity Ledger</span>
                    </div>
                    <span class="dt-badge crimson"><?= count($retData['records']) ?> Cases Listed</span>
                </div>
                <div class="adm-table-responsive" style="overflow-x:auto;">
                    <table class="dt-report-table">
                        <thead>
                            <tr>
                                <th>Return # / Order #</th>
                                <th>Customer &amp; Phone</th>
                                <th>Resolution Type</th>
                                <th>Reported Reason</th>
                                <th style="text-align:center;">Status</th>
                                <th style="text-align:right;">Refund Amount</th>
                                <th>Courier Partner</th>
                                <th style="text-align:right;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($retData['records'] as $row): 
                                $stBadge = 'blue';
                                if ($row['status'] === 'refunded' || $row['status'] === 'replaced') $stBadge = 'emerald';
                                elseif ($row['status'] === 'rejected') $stBadge = 'crimson';
                                elseif ($row['status'] === 'approved') $stBadge = 'gold';
                            ?>
                            <tr>
                                <td>
                                    <div style="font-weight:700; color:#111827;"><?= htmlspecialchars($row['return_number']) ?></div>
                                    <div style="font-size:0.75rem; color:#64748B;">Order: <?= htmlspecialchars($row['order_number']) ?></div>
                                </td>
                                <td>
                                    <div style="font-weight:600; color:#334155;"><?= htmlspecialchars($row['customer_name']) ?></div>
                                    <div style="font-size:0.75rem; color:#64748B;"><?= htmlspecialchars($row['customer_phone'] ?: '—') ?></div>
                                </td>
                                <td>
                                    <span class="dt-badge <?= $row['return_type'] === 'replacement' ? 'blue' : 'amber' ?>">
                                        <?= ucfirst(htmlspecialchars($row['return_type'])) ?>
                                    </span>
                                </td>
                                <td style="color:#475569; font-size:0.8rem; text-transform:capitalize;">
                                    <?= str_replace('_', ' ', htmlspecialchars($row['reason'])) ?>
                                </td>
                                <td style="text-align:center;">
                                    <span class="dt-badge <?= $stBadge ?>"><?= ucfirst(htmlspecialchars($row['status'])) ?></span>
                                </td>
                                <td style="text-align:right; font-weight:800; color:#B45309;">
                                    <?= $rupeeSvg ?> <?= number_format((float)$row['refund_amount'], 2) ?>
                                </td>
                                <td style="color:#64748B; font-size:0.78rem;">
                                    <?= htmlspecialchars($row['courier_partner'] ?: 'Delhivery') ?>
                                </td>
                                <td style="text-align:right; color:#64748B; font-size:0.78rem;">
                                    <?= date('d M Y', strtotime($row['created_at'])) ?>
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
