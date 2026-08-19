<?php
/**
 * index.php - DT Brand's Admin Reports Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Financial & GST Business Intelligence";
$active_nav = "reports";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial & GST Business Intelligence - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
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
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Total Gross Revenue</span>
                <div class="adm-kpi-icon-box">💰</div>
            </div>
            <div class="adm-kpi-val">₹42,85,900</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">↑ +18.4% vs last mo</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Gross Profit (34.8%)</span>
                <div class="adm-kpi-icon-box">📊</div>
            </div>
            <div class="adm-kpi-val">₹14,92,400</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">↑ +15.2% Margin</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Net Profit (26.7%)</span>
                <div class="adm-kpi-icon-box">💎</div>
            </div>
            <div class="adm-kpi-val">₹11,45,200</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">Post-Tax Net</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">GST Tax Payable</span>
                <div class="adm-kpi-icon-box">🧾</div>
            </div>
            <div class="adm-kpi-val">₹2,14,295</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">GSTR-1 Ready (5% & 12%)</span>
            </div>
        </div>
        
            </div>

            <!-- Module Specific Interactive Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>📈 Export Tax & Performance Reports</span></h3>
            </div>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px;">
                <div style="padding:18px; background:#FAF8F4; border:1px solid #E5E1D7; border-radius:8px; text-align:center;">
                    <div style="font-size:1.8rem; margin-bottom:6px;">📊</div>
                    <strong>Sales Summary (CSV/PDF)</strong>
                    <p style="font-size:0.75rem; color:#7A7266; margin:4px 0 12px;">Detailed breakdown of all 1,624 orders.</p>
                    <button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Downloading Sales Report...')">Download Report</button>
                </div>
                <div style="padding:18px; background:#FAF8F4; border:1px solid #E5E1D7; border-radius:8px; text-align:center;">
                    <div style="font-size:1.8rem; margin-bottom:6px;">🧾</div>
                    <strong>GST GSTR-1 Filing Sheet</strong>
                    <p style="font-size:0.75rem; color:#7A7266; margin:4px 0 12px;">B2B Invoices + B2C HSN summary.</p>
                    <button class="adm-btn-primary adm-btn-sm" onclick="window.showToast('Downloading GST GSTR-1...')">Download GSTR-1</button>
                </div>
                <div style="padding:18px; background:#FAF8F4; border:1px solid #E5E1D7; border-radius:8px; text-align:center;">
                    <div style="font-size:1.8rem; margin-bottom:6px;">🤝</div>
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
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
