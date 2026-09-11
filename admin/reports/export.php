<?php
/**
 * export.php — DT Brand's & Jai Hanuman Tex Unified Export Studio & Executive Print Hub
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

$hasExportPermission = ReportManager::checkExportPermission();

$reportType = isset($_GET['type']) ? strtolower(trim($_GET['type'])) : 'sales';
$range = isset($_GET['range']) ? trim($_GET['range']) : 'all';
$format = isset($_GET['format']) ? strtolower(trim($_GET['format'])) : '';

// Direct trigger download if format is provided
if (!empty($format) && in_array($format, ['csv', 'excel'], true)) {
    if (!$hasExportPermission) {
        die("Permission Denied: You do not have authorization to download exports.");
    }

    if ($format === 'excel') {
        ReportManager::exportToExcel($reportType, $range);
    } else {
        ReportManager::exportToCsv($reportType, $range);
    }
    exit;
}

$page_title = "Unified Export Studio & Print Hub";
$active_nav = "reports";
$current_subnav = "export";

$reportCatalog = [
    'sales'      => ['name' => 'Sales & Channel Analytics',     'desc' => 'D2C, Wholesale, Retailer, and Reseller volume breakdown.'],
    'orders'     => ['name' => 'Orders Funnel & Status SLAs',   'desc' => 'Processing, packed, in transit, delivered, and cancellations.'],
    'revenue'    => ['name' => 'Revenue & P&L Statement',       'desc' => 'Manufacturing COGS, gross trading profit, and EBITDA net.'],
    'products'   => ['name' => 'Product Sales Performance',     'desc' => 'SKU-level units sold, gross GMV, margins, and stock velocity.'],
    'categories' => ['name' => 'Category Sales & Margins',     'desc' => 'Product mix share: Silk Sarees, Kurtis, and Festive Wear.'],
    'inventory'  => ['name' => 'Inventory Valuation Ledger',    'desc' => 'Wholesale cost valuation vs expected retail MRP liquidation.'],
    'customers'  => ['name' => 'Customer Lifetime Value (LTV)', 'desc' => 'VIP buyers, purchase frequency, and geographic distribution.'],
    'roles'      => ['name' => 'Role Distribution Matrix',      'desc' => 'Guest, Customer, Retailer, Reseller, Wholesaler commercial split.'],
    'payments'   => ['name' => 'Payment Gateway Reconciliation','desc' => 'Instant UPI, Razorpay, Cashfree, COD, and Wire settlement.'],
    'shipping'   => ['name' => 'Shipping & Carrier Logistics',  'desc' => 'Delhivery, BlueDart, and TCI Freight delivery SLAs and RTOs.'],
    'coupons'    => ['name' => 'Coupons & Discount Efficiency', 'desc' => 'Campaign redemptions, discount disbursement, and ROI multiple.'],
    'returns'    => ['name' => 'Returns, Exchanges & Refunds',  'desc' => 'Reverse transit tracking, reported defect reasons, and refunds.'],
];
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
                        <span>Unified Export Studio &amp; Print Hub</span>
                        <span class="dt-badge gold">Data Exporter</span>
                    </h1>
                    <p class="adm-page-subtitle">Permission-controlled bulk data export suite supporting RFC-4180 CSV, Excel MIME format, and clean executive printable PDF sheets.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/reports/" class="dt-btn dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        Back to BI Hub
                    </a>
                </div>
            </div>

            <!-- Permission Notice -->
            <div style="background:#FAF5E8; border:1px solid #D4AF37; border-radius:10px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:12px;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    <div>
                        <div style="font-weight:800; font-size:0.9rem; color:#111827;">Export Security &amp; Permission Status</div>
                        <div style="font-size:0.78rem; color:#705114;">Exports are restricted to authenticated admin and managerial sessions. Formula injection sanitization is active.</div>
                    </div>
                </div>
                <span class="dt-badge emerald" style="font-weight:800;">Authorized Session</span>
            </div>

            <!-- Export Form Card -->
            <div class="dt-report-table-card" style="padding:24px; margin-bottom:24px;">
                <h2 style="font-size:1.1rem; font-weight:800; margin-bottom:16px; color:#111827;">Configure Custom Report Export</h2>
                
                <form method="GET" action="/admin/reports/export.php" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px; align-items:end;">
                    <div>
                        <label style="display:block; font-size:0.75rem; font-weight:700; color:#475569; text-transform:uppercase; margin-bottom:6px;">Select Report Entity</label>
                        <select name="type" class="dt-report-select" style="width:100%; height:40px; padding:8px 12px; border:1px solid #CBD5E1; border-radius:8px; font-size:0.85rem; font-weight:600; color:#111827; background:#FFFFFF;">
                            <?php foreach ($reportCatalog as $key => $r): ?>
                            <option value="<?= $key ?>" <?= $reportType === $key ? 'selected' : '' ?>><?= htmlspecialchars($r['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label style="display:block; font-size:0.75rem; font-weight:700; color:#475569; text-transform:uppercase; margin-bottom:6px;">Time Window Filter</label>
                        <select name="range" class="dt-report-select" style="width:100%; height:40px; padding:8px 12px; border:1px solid #CBD5E1; border-radius:8px; font-size:0.85rem; font-weight:600; color:#111827; background:#FFFFFF;">
                            <option value="all" <?= $range === 'all' ? 'selected' : '' ?>>All Time (Complete Ledger)</option>
                            <option value="today" <?= $range === 'today' ? 'selected' : '' ?>>Today</option>
                            <option value="7d" <?= $range === '7d' ? 'selected' : '' ?>>Last 7 Days</option>
                            <option value="30d" <?= $range === '30d' ? 'selected' : '' ?>>Last 30 Days</option>
                            <option value="mtd" <?= $range === 'mtd' ? 'selected' : '' ?>>This Month (MTD)</option>
                            <option value="ytd" <?= $range === 'ytd' ? 'selected' : '' ?>>This Financial Year (YTD)</option>
                        </select>
                    </div>

                    <div>
                        <label style="display:block; font-size:0.75rem; font-weight:700; color:#475569; text-transform:uppercase; margin-bottom:6px;">Target Format</label>
                        <select name="format" class="dt-report-select" style="width:100%; height:40px; padding:8px 12px; border:1px solid #CBD5E1; border-radius:8px; font-size:0.85rem; font-weight:600; color:#111827; background:#FFFFFF;">
                            <option value="csv">Standard CSV (RFC-4180 + UTF-8 BOM)</option>
                            <option value="excel">Microsoft Excel Compatible (.xls / .csv)</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="dt-btn dt-btn-gold" style="width:100%; height:40px; justify-content:center;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            Generate &amp; Download
                        </button>
                    </div>
                </form>
            </div>

            <!-- Quick Export Directory Table -->
            <div class="dt-report-table-card">
                <div class="dt-report-table-header">
                    <div class="dt-report-table-title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Direct 1-Click Export Station</span>
                    </div>
                </div>
                <div class="adm-table-responsive" style="overflow-x:auto;">
                    <table class="dt-report-table">
                        <thead>
                            <tr>
                                <th>Report Domain</th>
                                <th>Report Scope &amp; Contents</th>
                                <th style="text-align:center;">Download CSV</th>
                                <th style="text-align:center;">Download Excel</th>
                                <th style="text-align:center;">Live View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reportCatalog as $key => $r): ?>
                            <tr>
                                <td style="font-weight:700; color:#111827;"><?= htmlspecialchars($r['name']) ?></td>
                                <td style="color:#64748B; font-size:0.78rem;"><?= htmlspecialchars($r['desc']) ?></td>
                                <td style="text-align:center;">
                                    <a href="/api/reports.php?action=export&type=<?= $key ?>&format=csv" class="dt-btn dt-btn-pale" style="padding:4px 10px; font-size:0.72rem;">CSV</a>
                                </td>
                                <td style="text-align:center;">
                                    <a href="/api/reports.php?action=export&type=<?= $key ?>&format=excel" class="dt-btn dt-btn-gold" style="padding:4px 10px; font-size:0.72rem;">Excel</a>
                                </td>
                                <td style="text-align:center;">
                                    <a href="/admin/reports/<?= $key ?>.php" class="dt-btn dt-btn-pale" style="padding:4px 8px; font-size:0.72rem;">View &rarr;</a>
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
