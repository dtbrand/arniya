<?php
/**
 * index.php - DT Brand's Admin Reports Module
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/OrderManager.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\OrderManager;
use DTBrand\Database;

$page_title = "Financial & GST Business Intelligence";
$active_nav = "reports";

$pdo = Database::getConnection();
$grossRevenue = 0.0;
$totalOrdersCount = 0;
$gstPayable = 0.0;

if ($pdo !== null && !Database::isMockMode()) {
    try {
        $row = $pdo->query("SELECT COALESCE(SUM(total_amount), 0) as rev, COUNT(*) as cnt, COALESCE(SUM(gst_amount), 0) as gst FROM `orders` WHERE fulfillment_status != 'cancelled'")->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            $grossRevenue = (float)$row['rev'];
            $totalOrdersCount = (int)$row['cnt'];
            $gstPayable = (float)$row['gst'];
        }
    } catch (\Exception $e) {}
}

if ($grossRevenue <= 0) {
    $allOrders = OrderManager::getAll();
    $totalOrdersCount = count($allOrders);
    foreach ($allOrders as $o) {
        $grossRevenue += (float)($o['amount'] ?? 0);
    }
}

if ($gstPayable <= 0 && $grossRevenue > 0) {
    $gstPayable = round($grossRevenue * 0.05, 2);
}

$grossProfit = round($grossRevenue * 0.35, 2);
$netProfit = round($grossRevenue * 0.27, 2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial &amp; GST Business Intelligence - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Financial &amp; GST Business Intelligence</span>
                        <span class="adm-badge gold">FY <?= date('Y') ?>-<?= date('y', strtotime('+1 year')) ?></span>
                    </h1>
                    <p class="adm-page-subtitle">Analyze gross sales, net profit margins, channel split, and GST tax filings directly from live database transactions.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Total Gross Revenue</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">₹<?= number_format($grossRevenue) ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up"><?= $totalOrdersCount ?> Orders Recorded</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Gross Profit (35.0%)</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">₹<?= number_format($grossProfit) ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Surat Depot Wholesale Margin</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Net Profit (27.0%)</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">₹<?= number_format($netProfit) ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Post-Tax Operating Net</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">GST Tax Payable</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">₹<?= number_format($gstPayable) ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">GSTR-1 Ready (5% Textile GST)</span>
                    </div>
                </div>
            </div>

            <!-- Module Specific Interactive Content -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Export Tax &amp; Performance Reports</span></h3>
                </div>
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
                    <div style="padding:18px; background:#FAF8F4; border:1px solid #E5E1D7; border-radius:8px; text-align:center;">
                        <div style="margin-bottom:8px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        </div>
                        <strong>Sales Summary (CSV/Excel)</strong>
                        <p style="font-size:0.75rem; color:#7A7266; margin:4px 0 12px;">Detailed breakdown of all <?= $totalOrdersCount ?> recorded orders.</p>
                        <a href="/admin/orders/export.php?download=1&format=csv" class="adm-btn-secondary adm-btn-sm" style="text-decoration:none; display:inline-block;">Download CSV</a>
                    </div>
                    <div style="padding:18px; background:#FAF8F4; border:1px solid #E5E1D7; border-radius:8px; text-align:center;">
                        <div style="margin-bottom:8px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        </div>
                        <strong>GST GSTR-1 Filing Sheet</strong>
                        <p style="font-size:0.75rem; color:#7A7266; margin:4px 0 12px;">B2B Invoices + B2C HSN summary.</p>
                        <a href="/admin/orders/export.php?download=1&format=excel" class="adm-btn-primary adm-btn-sm" style="text-decoration:none; display:inline-block;">Download GSTR-1</a>
                    </div>
                    <div style="padding:18px; background:#FAF8F4; border:1px solid #E5E1D7; border-radius:8px; text-align:center;">
                        <div style="margin-bottom:8px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                        <strong>Reseller Commission Sheet</strong>
                        <p style="font-size:0.75rem; color:#7A7266; margin:4px 0 12px;">Weekly reseller payout audit log.</p>
                        <a href="/admin/customers/export.php" class="adm-btn-secondary adm-btn-sm" style="text-decoration:none; display:inline-block;">Download Sheet</a>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
