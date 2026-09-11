<?php
/**
 * customers.php — DT Brand's & Jai Hanuman Tex Customers & Lifetime Value Analytics
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

$roleFilter = isset($_GET['role']) ? trim($_GET['role']) : 'all';
$custData = ReportManager::getCustomersReport($roleFilter);

$page_title = "Customers & Lifetime Value";
$active_nav = "reports";
$current_subnav = "customers";

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
                        <span>Customers &amp; Lifetime Value (LTV)</span>
                        <span class="dt-badge emerald">VIP Ledger</span>
                    </h1>
                    <p class="adm-page-subtitle">Track wholesale buyers, retail shoppers, and boutique reseller networks by order frequency, lifetime spend, and geographic region.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:10px; align-items:center;">
                    <a href="/admin/reports/" class="dt-btn dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        All Reports
                    </a>
                    <button type="button" class="dt-btn dt-btn-gold" data-export-type="customers" data-export-format="csv">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        Export Customers CSV
                    </button>
                </div>
            </div>

            <!-- Toolbar -->
            <div class="dt-report-toolbar">
                <div class="dt-report-toolbar-left">
                    <span style="font-size:0.8rem; font-weight:700; color:#64748B;">Role Filter:</span>
                    <div class="dt-report-pill-group">
                        <a href="?role=all" class="dt-report-pill <?= $roleFilter === 'all' ? 'active' : '' ?>">All Roles</a>
                        <a href="?role=wholesaler" class="dt-report-pill <?= $roleFilter === 'wholesaler' ? 'active' : '' ?>">Wholesalers</a>
                        <a href="?role=retailer" class="dt-report-pill <?= $roleFilter === 'retailer' ? 'active' : '' ?>">Retailers</a>
                        <a href="?role=reseller" class="dt-report-pill <?= $roleFilter === 'reseller' ? 'active' : '' ?>">Resellers</a>
                        <a href="?role=customer" class="dt-report-pill <?= $roleFilter === 'customer' ? 'active' : '' ?>">Retail Shoppers</a>
                    </div>
                </div>
                <div class="dt-report-toolbar-right">
                    <button type="button" class="dt-btn dt-btn-pale dt-print-trigger" style="padding:6px 12px; font-size:0.75rem;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                        Print Sheet
                    </button>
                </div>
            </div>

            <!-- Geographic Distribution Ribbon -->
            <?php if (!empty($custData['state_distribution'])): ?>
            <div style="display:flex; gap:12px; flex-wrap:wrap; margin-bottom:20px;">
                <?php foreach ($custData['state_distribution'] as $st): ?>
                <div style="background:#FFFFFF; border:1px solid #E2E8F0; border-radius:8px; padding:10px 16px; display:flex; align-items:center; gap:10px; box-shadow:0 1px 3px rgba(0,0,0,0.03);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    <div>
                        <div style="font-weight:700; font-size:0.84rem; color:#111827;"><?= htmlspecialchars($st['st']) ?></div>
                        <div style="font-size:0.72rem; color:#64748B;"><?= number_format($st['cnt']) ?> Registered Buyers</div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Customer Lifetime Value Table -->
            <div class="dt-report-table-card">
                <div class="dt-report-table-header">
                    <div class="dt-report-table-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        <span>Top High-Value Buyers &amp; Lifetime Spend</span>
                    </div>
                    <span class="dt-badge emerald"><?= count($custData['customers']) ?> Accounts Listed</span>
                </div>
                <div class="adm-table-responsive" style="overflow-x:auto;">
                    <table class="dt-report-table">
                        <thead>
                            <tr>
                                <th>Buyer &amp; Firm Name</th>
                                <th>Role</th>
                                <th>Contact &amp; Location</th>
                                <th style="text-align:center;">Orders Placed</th>
                                <th style="text-align:right;">Lifetime Spend</th>
                                <th style="text-align:right;">Last Order Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($custData['customers'] as $c): 
                                $rBadge = 'blue';
                                if ($c['role'] === 'wholesaler') $rBadge = 'gold';
                                elseif ($c['role'] === 'retailer') $rBadge = 'amber';
                                elseif ($c['role'] === 'reseller') $rBadge = 'emerald';
                            ?>
                            <tr>
                                <td>
                                    <div style="font-weight:700; color:#111827;"><?= htmlspecialchars($c['name']) ?></div>
                                    <div style="font-size:0.75rem; color:#64748B;"><?= htmlspecialchars($c['company_name']) ?></div>
                                </td>
                                <td>
                                    <span class="dt-badge <?= $rBadge ?>"><?= ucfirst(htmlspecialchars($c['role'])) ?></span>
                                </td>
                                <td>
                                    <div style="font-weight:600; color:#334155;"><?= htmlspecialchars($c['city']) ?>, <?= htmlspecialchars($c['state']) ?></div>
                                    <div style="font-size:0.75rem; color:#64748B;"><?= htmlspecialchars($c['phone']) ?></div>
                                </td>
                                <td style="text-align:center; font-weight:800;"><?= number_format($c['order_count']) ?></td>
                                <td style="text-align:right; font-weight:800; color:#15803D;"><?= $rupeeSvg ?> <?= number_format($c['total_spent']) ?></td>
                                <td style="text-align:right; color:#64748B; font-size:0.78rem;"><?= htmlspecialchars($c['last_order_date'] ?: '—') ?></td>
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
