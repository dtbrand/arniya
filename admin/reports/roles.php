<?php
/**
 * roles.php — DT Brand's & Jai Hanuman Tex Role Distribution & B2B Channel Intelligence
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

$activeRole = isset($_GET['view']) ? strtolower(trim($_GET['view'])) : 'all';

$roleDist = ReportManager::getRoleDistributionReport();
$roleDetail = null;
if (in_array($activeRole, ['retailer', 'reseller', 'wholesaler'], true)) {
    $roleDetail = ReportManager::getRoleSpecificReport($activeRole);
}

$page_title = "Role Distribution & B2B Analytics";
$active_nav = "reports";
$current_subnav = "roles";

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
                        <span>Role Distribution &amp; B2B Analytics</span>
                        <span class="dt-badge gold">5 Official Roles</span>
                    </h1>
                    <p class="adm-page-subtitle">Commercial performance across the 5 official platform roles: Guest, Customer, Retailer, Reseller, and Wholesaler.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px; align-items:center;">
                    <a href="/admin/reports/" class="dt-btn dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        All Reports
                    </a>
                    <button type="button" class="dt-btn dt-btn-gold" data-export-type="roles" data-export-format="csv">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Export Roles CSV
                    </button>
                </div>
            </div>

            <!-- Toolbar View Tabs -->
            <div class="dt-report-toolbar">
                <div class="dt-report-toolbar-left">
                    <span style="font-size:0.8rem; font-weight:700; color:#64748B;">Analytics Focus:</span>
                    <div class="dt-report-pill-group">
                        <a href="?view=all" class="dt-report-pill <?= $activeRole === 'all' ? 'active' : '' ?>">All 5 Roles Overview</a>
                        <a href="?view=wholesaler" class="dt-report-pill <?= $activeRole === 'wholesaler' ? 'active' : '' ?>">Wholesale Deep-Dive</a>
                        <a href="?view=retailer" class="dt-report-pill <?= $activeRole === 'retailer' ? 'active' : '' ?>">Retailer Deep-Dive</a>
                        <a href="?view=reseller" class="dt-report-pill <?= $activeRole === 'reseller' ? 'active' : '' ?>">Reseller Deep-Dive</a>
                    </div>
                </div>
                <div class="dt-report-toolbar-right">
                    <button type="button" class="dt-btn dt-btn-pale dt-print-trigger" style="padding:6px 12px; font-size:0.75rem;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                        Print Sheet
                    </button>
                </div>
            </div>

            <!-- 5-Role Overview Table -->
            <div class="dt-report-table-card">
                <div class="dt-report-table-header">
                    <div class="dt-report-table-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" y1="8" x2="19" y2="14"></line><line x1="22" y1="11" x2="16" y2="11"></line></svg>
                        <span>Role Breakdown: Guest, Customer, Retailer, Reseller, Wholesaler</span>
                    </div>
                </div>
                <div class="adm-table-responsive" style="overflow-x:auto;">
                    <table class="dt-report-table">
                        <thead>
                            <tr>
                                <th>Role Entity</th>
                                <th style="text-align:center;">Registered Accounts</th>
                                <th style="text-align:center;">Orders Placed</th>
                                <th style="text-align:right;">Gross Revenue</th>
                                <th style="text-align:right;">Average Order Value (AOV)</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($roleDist['roles'] as $rKey => $r): ?>
                            <tr>
                                <td>
                                    <div style="font-weight:700; color:#111827;"><?= htmlspecialchars($r['name']) ?></div>
                                    <div style="font-size:0.75rem; color:#64748B;">Role Code: <?= htmlspecialchars($rKey) ?></div>
                                </td>
                                <td style="text-align:center; font-weight:700;"><?= number_format($r['users_count']) ?></td>
                                <td style="text-align:center; font-weight:800;"><?= number_format($r['orders_count']) ?></td>
                                <td style="text-align:right; font-weight:800; color:#111827;"><?= $rupeeSvg ?> <?= number_format($r['revenue']) ?></td>
                                <td style="text-align:right; color:#475569; font-weight:600;"><?= $rupeeSvg ?> <?= number_format($r['aov']) ?></td>
                                <td style="text-align:center;">
                                    <?php if (in_array($rKey, ['wholesaler', 'retailer', 'reseller'], true)): ?>
                                        <a href="?view=<?= $rKey ?>" class="dt-btn dt-btn-pale" style="padding:4px 8px; font-size:0.72rem;">Inspect</a>
                                    <?php else: ?>
                                        <span style="color:#94A3B8; font-size:0.72rem;">Direct D2C</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Deep-Dive Table (When Selected) -->
            <?php if ($roleDetail): ?>
            <div class="dt-report-table-card" style="border:1.5px solid #D4AF37;">
                <div class="dt-report-table-header" style="background:#FAF8F4;">
                    <div class="dt-report-table-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <span><?= ucfirst(htmlspecialchars($roleDetail['role'])) ?> Deep Dive: Top Buyers Ledger</span>
                    </div>
                    <div style="font-size:0.82rem; font-weight:700; color:#8A681F;">
                        Total Volume: <?= $rupeeSvg ?> <?= number_format($roleDetail['total_revenue']) ?> (<?= $roleDetail['total_orders'] ?> Orders)
                    </div>
                </div>
                <div class="adm-table-responsive" style="overflow-x:auto;">
                    <table class="dt-report-table">
                        <thead>
                            <tr>
                                <th>Buyer / Company Name</th>
                                <th>Contact Details</th>
                                <th>Depot Hub / City</th>
                                <th style="text-align:center;">Orders Placed</th>
                                <th style="text-align:right;">Gross Volume</th>
                                <th style="text-align:right;">Last Order Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($roleDetail['buyers'] as $b): ?>
                            <tr>
                                <td>
                                    <div style="font-weight:700; color:#111827;"><?= htmlspecialchars($b['name']) ?></div>
                                    <div style="font-size:0.75rem; color:#64748B;"><?= htmlspecialchars($b['company_name'] ?: 'Wholesale Account') ?></div>
                                </td>
                                <td>
                                    <div style="font-weight:600; color:#334155;"><?= htmlspecialchars($b['phone'] ?: '—') ?></div>
                                </td>
                                <td>
                                    <div style="color:#475569;"><?= htmlspecialchars($b['city'] ?: 'Surat') ?>, <?= htmlspecialchars($b['state'] ?: 'Gujarat') ?></div>
                                </td>
                                <td style="text-align:center; font-weight:800;"><?= number_format($b['order_count']) ?></td>
                                <td style="text-align:right; font-weight:800; color:#15803D;"><?= $rupeeSvg ?> <?= number_format($b['total_revenue']) ?></td>
                                <td style="text-align:right; color:#64748B; font-size:0.78rem;"><?= htmlspecialchars($b['last_order_date']) ?></td>
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
<script src="/admin/assets/js/admin.js?v=<?= time() ?>"></script>
<script src="/admin/reports/reports.js?v=<?= time() ?>"></script>
</body>
</html>
