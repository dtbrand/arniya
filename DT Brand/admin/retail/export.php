<?php
/**
 * export.php — DT Brand's & Jai Hanuman Tex
 * Retail Data Export Studio
 */
$page_title = "Retail Export Studio";
$active_nav = "retail";
$active_subnav = "export";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retail Export Studio - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/retail/assets/css/retail.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 18px 20px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-retail-container">
                <div class="dt-retail-head">
                    <div>
                        <h1 class="dt-retail-title">
                            <span>Retail Data Export Studio</span>
                            <span class="dt-status-pill-clean gold">Multi-Format Extraction</span>
                        </h1>
                        <p class="dt-retail-subtitle">Export retail sales, customers, orders, abandoned carts, and pricing sheets in CSV or Excel format.</p>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px, 1fr)); gap:14px;">
                    <div class="dt-retail-card" style="padding:16px; display:flex; flex-direction:column; justify-content:space-between; gap:10px;">
                        <div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                                <strong style="color:#181512; font-size:0.9rem;">Retail Customers Dossier</strong>
                            </div>
                            <p style="font-size:0.75rem; color:#78716C; margin:6px 0 0 0;">All 4,820 registered retail consumers with lifetime spend, phone numbers, and order history.</p>
                        </div>
                        <button type="button" class="dt-btn dt-btn-gold" onclick="exportRetailCsvReport('Customers')">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Download Customers CSV</span>
                        </button>
                    </div>

                    <div class="dt-retail-card" style="padding:16px; display:flex; flex-direction:column; justify-content:space-between; gap:10px;">
                        <div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#8A681F" stroke-width="2.3"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                                <strong style="color:#181512; font-size:0.9rem;">Retail Orders &amp; Dispatches</strong>
                            </div>
                            <p style="font-size:0.75rem; color:#78716C; margin:6px 0 0 0;">All 1,624 completed retail orders with line items, tracking numbers, and payment breakdown.</p>
                        </div>
                        <button type="button" class="dt-btn dt-btn-gold" onclick="exportRetailCsvReport('Orders')">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Download Orders CSV</span>
                        </button>
                    </div>

                    <div class="dt-retail-card" style="padding:16px; display:flex; flex-direction:column; justify-content:space-between; gap:10px;">
                        <div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                                <strong style="color:#181512; font-size:0.9rem;">Retail Pricing &amp; MRP Sheet</strong>
                            </div>
                            <p style="font-size:0.75rem; color:#78716C; margin:6px 0 0 0;">482 active retail SKUs with MRP, retail selling price, margins, and warehouse stock.</p>
                        </div>
                        <button type="button" class="dt-btn dt-btn-gold" onclick="exportRetailCsvReport('Pricing')">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Download Pricing Sheet</span>
                        </button>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<script src="/admin/retail/assets/js/retail.js?v=<?php echo time(); ?>"></script>
<script src="/admin/retail/assets/js/retail-analytics.js?v=<?php echo time(); ?>"></script>
</body>
</html>
