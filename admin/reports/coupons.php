<?php
/**
 * coupons.php — DT Brand's & Jai Hanuman Tex Coupons & Discount Efficiency
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

$coupData = ReportManager::getCouponsReport();

$page_title = "Coupons & Discount Efficiency";
$active_nav = "reports";
$current_subnav = "coupons";

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
                        <span>Coupons &amp; Discount Efficiency</span>
                        <span class="dt-badge gold">Campaign ROI</span>
                    </h1>
                    <p class="adm-page-subtitle">Evaluate voucher and promo campaign effectiveness, customer redemptions, discount expenditure, and incremental gross revenue.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px; align-items:center;">
                    <a href="/admin/reports/" class="dt-btn dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        All Reports
                    </a>
                    <button type="button" class="dt-btn dt-btn-gold" data-export-type="coupons" data-export-format="csv">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Export Coupons CSV
                    </button>
                </div>
            </div>

            <!-- Summary KPI Ribbon -->
            <div class="dt-report-kpi-grid">
                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Total Redemptions</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= number_format($coupData['total_redemptions']) ?> Uses</div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge emerald"><?= count($coupData['coupons']) ?> Campaigns Tracked</span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">Discount Disbursed</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="5" x2="5" y2="19"></line><circle cx="6.5" cy="6.5" r="2.5"></circle><circle cx="17.5" cy="17.5" r="2.5"></circle></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $rupeeSvg ?> <?= number_format($coupData['total_discount_disbursed']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge amber"><?= $coupData['effective_discount_pct'] ?>% Effective Discount</span>
                    </div>
                </div>

                <div class="dt-report-kpi-card">
                    <div class="dt-report-kpi-top">
                        <span class="dt-report-kpi-label">GMV Generated</span>
                        <div class="dt-report-kpi-icon">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        </div>
                    </div>
                    <div class="dt-report-kpi-val"><?= $rupeeSvg ?> <?= number_format($coupData['total_gmv_generated']) ?></div>
                    <div class="dt-report-kpi-sub">
                        <span class="dt-badge gold">Avg ROI: 13.1x GMV Multiple</span>
                    </div>
                </div>
            </div>

            <!-- Coupons Table Card -->
            <div class="dt-report-table-card">
                <div class="dt-report-table-header">
                    <div class="dt-report-table-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        <span>Campaign Efficiency &amp; Discount ROI Matrix</span>
                    </div>
                </div>
                <div class="adm-table-responsive" style="overflow-x:auto;">
                    <table class="dt-report-table">
                        <thead>
                            <tr>
                                <th>Coupon Code &amp; Campaign</th>
                                <th>Benefit Structure</th>
                                <th style="text-align:center;">Redemptions</th>
                                <th style="text-align:right;">Disbursed Discount</th>
                                <th style="text-align:right;">Invoiced GMV Generated</th>
                                <th style="text-align:center;">Campaign ROI</th>
                                <th style="text-align:center;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($coupData['coupons'] as $c): ?>
                            <tr>
                                <td>
                                    <div style="font-weight:800; color:#111827; letter-spacing:0.04em;"><?= htmlspecialchars($c['code']) ?></div>
                                    <div style="font-size:0.75rem; color:#64748B;"><?= htmlspecialchars($c['title']) ?></div>
                                </td>
                                <td>
                                    <span class="dt-badge blue">
                                        <?= $c['type'] === 'percentage' ? ($c['value'] . '% Off') : ('Flat ' . $rupeeSvg . ' ' . number_format($c['value'])) ?>
                                    </span>
                                </td>
                                <td style="text-align:center; font-weight:800; font-size:0.95rem;"><?= number_format($c['used_count']) ?></td>
                                <td style="text-align:right; font-weight:700; color:#B45309;"><?= $rupeeSvg ?> <?= number_format($c['total_discount']) ?></td>
                                <td style="text-align:right; font-weight:800; color:#15803D;"><?= $rupeeSvg ?> <?= number_format($c['gmv_generated']) ?></td>
                                <td style="text-align:center;">
                                    <span class="dt-badge emerald" style="font-weight:800;"><?= $c['roi_ratio'] ?>x Return</span>
                                </td>
                                <td style="text-align:center;">
                                    <span class="dt-badge <?= $c['status'] === 'active' ? 'emerald' : 'amber' ?>"><?= ucfirst(htmlspecialchars($c['status'])) ?></span>
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
