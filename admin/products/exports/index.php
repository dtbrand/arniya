<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * exports/index.php — DT Brand's Master Product Export Studio
 * Wholesale Desktop & Luxury Shop Standard
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Product Export Studio";
$active_nav = "products";
$active_subnav = "exports";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Export Studio ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
    .dt-kpi-card {
        background: #fff;
        border: 1px solid rgba(212,175,55,0.4);
        border-radius: 8px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        transition: all 0.2s ease;
    }
    .dt-kpi-card:hover {
        border-color: #D4AF37;
        box-shadow: 0 4px 12px rgba(212,175,55,0.15);
        transform: translateY(-1px);
    }
    .dt-export-card {
        background: #fff;
        border: 1px solid #c3c4c7;
        border-radius: 8px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.2s ease;
    }
    .dt-export-card:hover {
        border-color: #D4AF37;
        box-shadow: 0 6px 18px rgba(212,175,55,0.18);
        transform: translateY(-2px);
    }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 16px 20px;">

            <!-- 1. Header Toolbar with Luxury Gold Buttons -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Product Export Studio</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:3px 8px;">Multi-Format Engine</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px;">
                    <a href="/admin/products/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Back to Products</span>
                    </a>
                    <a href="/admin/products/imports/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#1D4ED8" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Import Wizard</span>
                    </a>
                </div>
            </div>

            <!-- 2. B2B Wholesale KPI Metrics Ribbon -->
            <div class="dt-kpi-ribbon">
                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">EXPORTABLE CATALOG</div>
                        <div style="font-size:17px; font-weight:800; color:#181512;">1,240 Total SKUs</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">AVAILABLE FORMATS</div>
                        <div style="font-size:17px; font-weight:800; color:#15803D;">CSV, Excel, PDF</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#EFF6FF; border:1px solid #93C5FD; display:flex; align-items:center; justify-content:center; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">B2B PRICE LISTS</div>
                        <div style="font-size:17px; font-weight:800; color:#1D4ED8;">Custom Wholesale Rates</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">GST &amp; HSN TAX MATRIX</div>
                        <div style="font-size:17px; font-weight:800; color:#B45309;">100% Compliant</div>
                    </div>
                </div>
            </div>

            <!-- 3. Export Scope Cards -->
            <div class="dt-kpi-ribbon">
                
                <!-- Card 1: Full Catalog -->
                <div class="dt-export-card">
                    <div>
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <span class="adm-badge gold" style="font-size:10.5px; font-weight:700;">Complete Master Catalog</span>
                            <span style="font-size:11.5px; color:#15803D; font-weight:700;">1,240 SKUs</span>
                        </div>
                        <h3 style="font-size:15px; font-weight:800; color:#181512; margin:0 0 6px 0;">All Active Products &amp; Prices</h3>
                        <p style="font-size:12px; color:#646970; margin:0 0 16px 0; line-height:1.45;">
                            Export entire catalog with SKU, Category, Brand, MRP, Wholesale Rates, MOQ, and active Surat inventory counts.
                        </p>
                    </div>
                    <div style="display:flex; gap:8px;">
                        <button type="button" class="wp-button primary" onclick="triggerExport('all', 'csv')" style="flex:1; height:36px; font-size:12px; font-weight:800; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F; display:inline-flex; align-items:center; justify-content:center; gap:6px; box-shadow:inset 0 1px 0 rgba(255,255,255,0.4), 0 2px 8px rgba(184,134,11,0.35); border-radius:6px; cursor:pointer;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            <span>Download CSV</span>
                        </button>
                        <button type="button" class="wp-button" onclick="triggerExport('all', 'xlsx')" style="height:36px; padding:0 14px; font-size:12px; font-weight:700; background:#FAF5E8; border:1px solid #D4AF37; color:#705114; border-radius:6px; cursor:pointer;">
                            Excel
                        </button>
                    </div>
                </div>

                <!-- Card 2: Wholesale B2B Rate Sheet -->
                <div class="dt-export-card">
                    <div>
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-size:10.5px; font-weight:700;">Wholesale Reseller Sheet</span>
                            <span style="font-size:11.5px; color:#8A681F; font-weight:700;">MOQ Matrix</span>
                        </div>
                        <h3 style="font-size:15px; font-weight:800; color:#181512; margin:0 0 6px 0;">B2B Price List &amp; MOQ Lots</h3>
                        <p style="font-size:12px; color:#646970; margin:0 0 16px 0; line-height:1.45;">
                            Clean wholesale rate sheet for boutique owners and volume buyers with Tier pricing and carton MOQ specifications.
                        </p>
                    </div>
                    <div style="display:flex; gap:8px;">
                        <button type="button" class="wp-button primary" onclick="triggerExport('wholesale', 'pdf')" style="flex:1; height:36px; font-size:12px; font-weight:800; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F; display:inline-flex; align-items:center; justify-content:center; gap:6px; box-shadow:inset 0 1px 0 rgba(255,255,255,0.4), 0 2px 8px rgba(184,134,11,0.35); border-radius:6px; cursor:pointer;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                            <span>Download PDF Catalog</span>
                        </button>
                        <button type="button" class="wp-button" onclick="triggerExport('wholesale', 'csv')" style="height:36px; padding:0 14px; font-size:12px; font-weight:700; background:#FAF5E8; border:1px solid #D4AF37; color:#705114; border-radius:6px; cursor:pointer;">
                            CSV
                        </button>
                    </div>
                </div>

                <!-- Card 3: Inventory Stock & Reorder Report -->
                <div class="dt-export-card">
                    <div>
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                            <span class="adm-badge" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; font-size:10.5px; font-weight:700;">Surat Mill Stock</span>
                            <span style="font-size:11.5px; color:#DC2626; font-weight:700;">Low Stock (14)</span>
                        </div>
                        <h3 style="font-size:15px; font-weight:800; color:#181512; margin:0 0 6px 0;">Warehouse Stock &amp; Reorders</h3>
                        <p style="font-size:12px; color:#646970; margin:0 0 16px 0; line-height:1.45;">
                            Export inventory counts across all color and size variant combinations with reorder alerts for weaving mills.
                        </p>
                    </div>
                    <div style="display:flex; gap:8px;">
                        <button type="button" class="wp-button primary" onclick="triggerExport('inventory', 'csv')" style="flex:1; height:36px; font-size:12px; font-weight:800; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F; display:inline-flex; align-items:center; justify-content:center; gap:6px; box-shadow:inset 0 1px 0 rgba(255,255,255,0.4), 0 2px 8px rgba(184,134,11,0.35); border-radius:6px; cursor:pointer;">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            <span>Download Stock CSV</span>
                        </button>
                        <button type="button" class="wp-button" onclick="triggerExport('inventory', 'xlsx')" style="height:36px; padding:0 14px; font-size:12px; font-weight:700; background:#FAF5E8; border:1px solid #D4AF37; color:#705114; border-radius:6px; cursor:pointer;">
                            Excel
                        </button>
                    </div>
                </div>

            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function triggerExport(scope, format) {
    if (typeof window.showToast === 'function') {
        window.showToast(`📊 Generating ${scope.toUpperCase()} export in ${format.toUpperCase()} format...`);
    }
}
</script>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
