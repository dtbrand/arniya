<?php
$page_title = "Product Import Wizard";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Import Wizard — DT Brand's Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/products.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/imports.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="dt-prod-header">
                <div class="dt-prod-title-group">
                    <h1><span>Product Import Wizard</span><span class="adm-badge gold">7-Step Pipeline</span></h1>
                    <p>Bulk import catalog items from CSV, Excel, or ERP spreadsheets.</p>
                </div>
                <div class="dt-prod-actions">
                    <a href="/Frontend/Admin/products/" class="adm-btn-secondary">← Back to Products</a>
                </div>
            </div>

            <!-- 7-Step Stepper -->
            <div class="dt-wizard-steps">
                <div class="dt-step-node active" id="dtStepNode1"><div class="dt-step-num">1</div><div class="dt-step-lbl">Upload</div></div>
                <div class="dt-step-node" id="dtStepNode2"><div class="dt-step-num">2</div><div class="dt-step-lbl">Map</div></div>
                <div class="dt-step-node" id="dtStepNode3"><div class="dt-step-num">3</div><div class="dt-step-lbl">Validate</div></div>
                <div class="dt-step-node" id="dtStepNode4"><div class="dt-step-num">4</div><div class="dt-step-lbl">Preview</div></div>
                <div class="dt-step-node" id="dtStepNode5"><div class="dt-step-num">5</div><div class="dt-step-lbl">Errors</div></div>
                <div class="dt-step-node" id="dtStepNode6"><div class="dt-step-num">6</div><div class="dt-step-lbl">Confirm</div></div>
                <div class="dt-step-node" id="dtStepNode7"><div class="dt-step-num">7</div><div class="dt-step-lbl">Done</div></div>
            </div>

            <!-- Step 1 Pane -->
            <div class="adm-card dt-import-step-pane" id="dtImportStep1">
                <div class="adm-card-head"><h3 class="adm-card-title"><span>Step 1: Upload CSV / Excel Spreadsheet</span></h3></div>
                <div class="dt-dropzone" style="padding:50px 20px;">
                    <div style="font-size:2.5rem; margin-bottom:10px;">📊</div>
                    <h3>Drag & Drop CSV / Excel Spreadsheet Here</h3>
                    <p style="color:#7A7266; font-size:0.8rem; margin:8px 0 16px;">Download Sample CSV Template: <a href="#" style="color:#8A681F; font-weight:700;">sample_catalog.csv</a></p>
                    <button class="adm-btn-primary" onclick="window.goToImportStep(2)">Proceed to Step 2: Column Mapping →</button>
                </div>
            </div>

            <!-- Step 2 Pane -->
            <div class="adm-card dt-import-step-pane" id="dtImportStep2" style="display:none;">
                <div class="adm-card-head"><h3 class="adm-card-title"><span>Step 2: Column Mapping Matrix</span></h3></div>
                <p style="margin-bottom:16px;">Map CSV column headers to DT Brand's database schema:</p>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead><tr><th>CSV Header</th><th>Matches DT Brand's Field</th><th>Sample Value</th></tr></thead>
                        <tbody>
                            <tr><td>Product_Title</td><td><strong style="color:#8A681F;">Product Name *</strong></td><td>Kanjivaram Silk Saree</td></tr>
                            <tr><td>SKU_Code</td><td><strong style="color:#8A681F;">SKU *</strong></td><td>KLN-SR-111</td></tr>
                            <tr><td>Wholesale_Rate</td><td><strong style="color:#8A681F;">Wholesale Price *</strong></td><td>2850</td></tr>
                        </tbody>
                    </table>
                </div>
                <div style="display:flex; justify-content:space-between; margin-top:20px;">
                    <button class="adm-btn-secondary" onclick="window.goToImportStep(1)">← Back</button>
                    <button class="adm-btn-primary" onclick="window.goToImportStep(3)">Step 3: Validate & Check Errors →</button>
                </div>
            </div>

            <!-- Step 3 Pane -->
            <div class="adm-card dt-import-step-pane" id="dtImportStep3" style="display:none;">
                <div class="adm-card-head"><h3 class="adm-card-title"><span>Step 3: Validation Summary</span></h3></div>
                <p>• Total Rows in File: <strong>250</strong><br>• Valid Rows: <strong style="color:#15803D;">248</strong><br>• Warnings: <strong style="color:#B45309;">2 (Missing Fabric Info)</strong><br>• Critical Errors: <strong>0</strong></p>
                <div style="display:flex; justify-content:space-between; margin-top:20px;">
                    <button class="adm-btn-secondary" onclick="window.goToImportStep(2)">← Back</button>
                    <button class="adm-btn-primary" onclick="window.goToImportStep(7); window.showToast('✅ 248 Products Imported Successfully!')">Execute Import Now 🚀</button>
                </div>
            </div>

            <!-- Step 7 Pane -->
            <div class="adm-card dt-import-step-pane" id="dtImportStep7" style="display:none; text-align:center; padding:40px;">
                <div style="font-size:3rem; margin-bottom:12px;">🎉</div>
                <h2>Import Completed Successfully!</h2>
                <p style="color:#7A7266; margin:8px 0 20px;">248 new products have been inserted into your catalog with active stock.</p>
                <a href="/Frontend/Admin/products/" class="adm-btn-primary">View Products Catalog</a>
            </div>
        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/products/assets/js/import.js?v=<?php echo time(); ?>"></script>
</body>
</html>
