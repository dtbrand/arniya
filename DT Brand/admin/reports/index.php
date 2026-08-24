<?php
/**
 * index.php - DT Brand's Admin Reports Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Financial & GST Business Intelligence";
$active_nav = "reports";
require_once __DIR__ . '/../../src/Database.php';
use DTBrand\Database;

$pdo = Database::getConnection();
$grossRevenue = 0.0;
if ($pdo !== null && !Database::isMockMode()) {
    try {
        $grossRevenue = (float)$pdo->query("SELECT COALESCE(SUM(total), 0) FROM `orders` WHERE status != 'cancelled'")->fetchColumn();
    } catch (\Exception $e) {}
}
$grossProfit = round($grossRevenue * 0.35, 2);
$netProfit = round($grossRevenue * 0.27, 2);
$gstPayable = round($grossRevenue * 0.05, 2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial & GST Business Intelligence - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
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
                        <span>Financial & GST Business Intelligence</span>
                        <span class="adm-badge gold">FY 2026-27</span>
                    </h1>
                    <p class="adm-page-subtitle">Analyze gross sales, net profit margins, channel split, and GST tax filings.</p>
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
                        <span class="adm-kpi-delta up"><?= $grossRevenue > 0 ? '↑ Live Sync' : 'Database Ready' ?></span>
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
                        <span class="adm-kpi-delta up">Margin Est.</span>
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
                        <span class="adm-kpi-delta up">Post-Tax Net</span>
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
                        <span class="adm-kpi-delta up">GSTR-1 Ready (5% Tax)</span>
                    </div>
                </div>
            </div>


            <!-- Module Specific Interactive Content -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Export Tax & Performance Reports</span></h3>
                </div>
                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
                    <div style="padding:18px; background:#FAF8F4; border:1px solid #E5E1D7; border-radius:8px; text-align:center;">
                        <div style="margin-bottom:8px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                        </div>
                        <strong>Sales Summary (CSV/PDF)</strong>
                        <p style="font-size:0.75rem; color:#7A7266; margin:4px 0 12px;">Detailed breakdown of all 1,624 orders.</p>
                        <button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Downloading Sales Report...')">Download Report</button>
                    </div>
                    <div style="padding:18px; background:#FAF8F4; border:1px solid #E5E1D7; border-radius:8px; text-align:center;">
                        <div style="margin-bottom:8px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                        </div>
                        <strong>GST GSTR-1 Filing Sheet</strong>
                        <p style="font-size:0.75rem; color:#7A7266; margin:4px 0 12px;">B2B Invoices + B2C HSN summary.</p>
                        <button class="adm-btn-primary adm-btn-sm" onclick="window.showToast('Downloading GST GSTR-1...')">Download GSTR-1</button>
                    </div>
                    <div style="padding:18px; background:#FAF8F4; border:1px solid #E5E1D7; border-radius:8px; text-align:center;">
                        <div style="margin-bottom:8px;">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        </div>
                        <strong>Reseller Commission Sheet</strong>
                        <p style="font-size:0.75rem; color:#7A7266; margin:4px 0 12px;">Weekly payout audit log.</p>
                        <button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Downloading Commission Sheet...')">Download Sheet</button>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/DT%20Brand/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
