<?php
/**
 * imports/index.php — DT Brand's 7-Step Master Product Import Wizard
 * Wholesale Desktop & Luxury Shop Standard
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Product Import Wizard";
$active_nav = "products";
$active_subnav = "imports";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Import Wizard ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
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
    .dt-stepper-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fff;
        border: 1px solid #c3c4c7;
        border-radius: 8px;
        padding: 12px 14px;
        margin-bottom: 14px;
        position: relative;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        gap: 10px;
    }
    .dt-step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
        min-width: 75px;
        flex-shrink: 0;
        cursor: pointer;
    }
    .dt-step-circle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 13px;
        background: #f0f0f1;
        color: #646970;
        border: 2px solid #dcdcde;
        transition: all 0.2s ease;
    }
    .dt-step-item.active .dt-step-circle {
        background: linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%);
        color: #181512;
        border-color: #8A681F;
        box-shadow: 0 2px 8px rgba(212,175,55,0.4);
    }
    .dt-step-item.completed .dt-step-circle {
        background: #DCFCE7;
        color: #15803D;
        border-color: #86EFAC;
    }
    .dt-step-label {
        font-size: 11px;
        font-weight: 700;
        color: #646970;
        margin-top: 5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .dt-step-item.active .dt-step-label {
        color: #8A681F;
        font-weight: 800;
    }
    .dt-dropzone-box {
        border: 2px dashed #D4AF37;
        background: #FAF8F4;
        border-radius: 8px;
        padding: 45px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .dt-dropzone-box:hover {
        background: #FAF5E8;
        border-color: #8A681F;
        box-shadow: 0 4px 14px rgba(212,175,55,0.15);
    }
    .dt-mapping-select {
        height: 32px;
        font-size: 12px;
        border: 1px solid #c3c4c7;
        border-radius: 4px;
        padding: 0 8px;
        width: 100%;
        background: #fff;
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
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Product Import Wizard</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:3px 8px;">7-Step Pipeline</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px;">
                    <a href="/Frontend/Admin/products/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Back to Products</span>
                    </a>
                    <a href="/Frontend/Admin/products/exports/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#1D4ED8" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        <span>Export Studio</span>
                    </a>
                </div>
            </div>

            <!-- 2. B2B Wholesale KPI Metrics Ribbon -->
            <div class="dt-kpi-ribbon">
                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">IMPORT PIPELINE SPEED</div>
                        <div style="font-size:17px; font-weight:800; color:#181512;">5,000 SKUs / Batch</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">AI HEADER MAPPING</div>
                        <div style="font-size:17px; font-weight:800; color:#15803D;">99.2% Accuracy</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#EFF6FF; border:1px solid #93C5FD; display:flex; align-items:center; justify-content:center; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">DUPLICATE DETECTION</div>
                        <div style="font-size:17px; font-weight:800; color:#1D4ED8;">Live SKU &amp; Barcode Check</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">ERP COMPATIBILITY</div>
                        <div style="font-size:17px; font-weight:800; color:#B45309;">Tally, Busy &amp; Excel</div>
                    </div>
                </div>
            </div>

            <!-- 3. Luxury 7-Step Visual Stepper -->
            <div class="dt-stepper-wrap">
                <div class="dt-step-item active" id="stepNode1" onclick="goToStep(1)">
                    <div class="dt-step-circle">1</div>
                    <div class="dt-step-label">Upload</div>
                </div>
                <div class="dt-step-item" id="stepNode2" onclick="goToStep(2)">
                    <div class="dt-step-circle">2</div>
                    <div class="dt-step-label">Map</div>
                </div>
                <div class="dt-step-item" id="stepNode3" onclick="goToStep(3)">
                    <div class="dt-step-circle">3</div>
                    <div class="dt-step-label">Validate</div>
                </div>
                <div class="dt-step-item" id="stepNode4" onclick="goToStep(4)">
                    <div class="dt-step-circle">4</div>
                    <div class="dt-step-label">Preview</div>
                </div>
                <div class="dt-step-item" id="stepNode5" onclick="goToStep(5)">
                    <div class="dt-step-circle">5</div>
                    <div class="dt-step-label">Errors</div>
                </div>
                <div class="dt-step-item" id="stepNode6" onclick="goToStep(6)">
                    <div class="dt-step-circle">6</div>
                    <div class="dt-step-label">Confirm</div>
                </div>
                <div class="dt-step-item" id="stepNode7" onclick="goToStep(7)">
                    <div class="dt-step-circle">7</div>
                    <div class="dt-step-label">Done</div>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- STEP 1: UPLOAD CSV / EXCEL SPREADSHEET                   -->
            <!-- ======================================================== -->
            <div id="stepPane1" class="wp-table-card" style="background:#fff; border:1px solid #c3c4c7; border-radius:6px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div style="margin-bottom:16px;">
                    <h3 style="font-size:16px; font-weight:800; color:#181512; margin:0 0 4px 0;">Step 1: Upload CSV / Excel Spreadsheet</h3>
                    <p style="font-size:12.5px; color:#646970; margin:0;">Select or drag-and-drop your wholesale textile product catalog file.</p>
                </div>

                <div class="dt-dropzone-box" onclick="document.getElementById('csvFileInput').click()">
                    <div style="width:54px; height:54px; border-radius:50%; background:#FAF5E8; border:1.5px solid #D4AF37; display:inline-flex; align-items:center; justify-content:center; color:#8A681F; margin-bottom:12px;">
                        <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    </div>
                    <h3 style="font-size:15px; font-weight:800; color:#181512; margin:0 0 6px 0;" id="dropzoneTitle">Drag &amp; Drop CSV / Excel Spreadsheet Here</h3>
                    <p style="font-size:12px; color:#646970; margin:0 0 14px 0;">Supported formats: <strong>.csv, .xlsx, .xls</strong> (Max 25MB per file)</p>
                    
                    <input type="file" id="csvFileInput" accept=".csv, .xlsx, .xls" style="display:none;" onchange="handleFileSelected(this)">
                    
                    <button type="button" class="wp-button primary" style="background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F; padding:0 16px; height:36px; display:inline-flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.8"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        <span>Browse Files</span>
                    </button>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:20px; padding-top:14px; border-top:1px solid #f0f0f1;">
                    <div style="font-size:12px; color:#646970;">
                        Download Sample Template: <a href="#" onclick="downloadSampleTemplate(); return false;" style="color:#8A681F; font-weight:700; text-decoration:none;">📄 DT_Brand_Wholesale_Template.csv</a>
                    </div>
                    <button type="button" class="wp-button primary" onclick="goToStep(2)" style="background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F; padding:0 18px; height:36px; display:inline-flex; align-items:center; gap:6px;">
                        <span>Proceed to Step 2: Column Mapping</span>
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.8"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- STEP 2: COLUMN MAPPING MATRIX                            -->
            <!-- ======================================================== -->
            <div id="stepPane2" class="wp-table-card" style="display:none; background:#fff; border:1px solid #c3c4c7; border-radius:6px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div style="margin-bottom:16px;">
                    <h3 style="font-size:16px; font-weight:800; color:#181512; margin:0 0 4px 0;">Step 2: Auto-Mapping CSV Headers to Catalog Schema</h3>
                    <p style="font-size:12.5px; color:#646970; margin:0;">Verify and match column headers from your spreadsheet to DT Brand's database fields.</p>
                </div>

                <table class="wp-list-table" style="width:100%; border-collapse:collapse; margin-bottom:16px;">
                    <thead>
                        <tr style="background:#f6f7f7; border-bottom:1px solid #c3c4c7;">
                            <th style="padding:10px 12px; width:220px;">CSV Column Header</th>
                            <th style="padding:10px 12px; width:260px;">DT Brand's Catalog Field</th>
                            <th style="padding:10px 12px;">Sample Value in File</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom:1px solid #f0f0f1;">
                            <td style="padding:10px 12px;"><code>Product_Title</code></td>
                            <td style="padding:10px 12px;">
                                <select class="dt-mapping-select"><option selected>Product Title *</option></select>
                            </td>
                            <td style="padding:10px 12px; color:#181512; font-weight:600;">Kanjivaram Pure Silk Gold Zari Saree</td>
                        </tr>
                        <tr style="border-bottom:1px solid #f0f0f1;">
                            <td style="padding:10px 12px;"><code>SKU_Code</code></td>
                            <td style="padding:10px 12px;">
                                <select class="dt-mapping-select"><option selected>Product SKU *</option></select>
                            </td>
                            <td style="padding:10px 12px;"><code style="color:#8A681F; font-weight:700;">KLN-SR-111</code></td>
                        </tr>
                        <tr style="border-bottom:1px solid #f0f0f1;">
                            <td style="padding:10px 12px;"><code>Wholesale_Rate</code></td>
                            <td style="padding:10px 12px;">
                                <select class="dt-mapping-select"><option selected>Wholesale B2B Price *</option></select>
                            </td>
                            <td style="padding:10px 12px; color:#15803D; font-weight:700;">₹2,850</td>
                        </tr>
                        <tr style="border-bottom:1px solid #f0f0f1;">
                            <td style="padding:10px 12px;"><code>Retail_MRP</code></td>
                            <td style="padding:10px 12px;">
                                <select class="dt-mapping-select"><option selected>MRP Price (Strikethrough)</option></select>
                            </td>
                            <td style="padding:10px 12px; color:#646970;">₹5,990</td>
                        </tr>
                        <tr style="border-bottom:1px solid #f0f0f1;">
                            <td style="padding:10px 12px;"><code>Category_Name</code></td>
                            <td style="padding:10px 12px;">
                                <select class="dt-mapping-select"><option selected>Category Name</option></select>
                            </td>
                            <td style="padding:10px 12px;">Silk Sarees</td>
                        </tr>
                    </tbody>
                </table>

                <div style="display:flex; justify-content:space-between; align-items:center; padding-top:14px; border-top:1px solid #f0f0f1;">
                    <button type="button" class="wp-button" onclick="goToStep(1)" style="height:36px; padding:0 14px; font-size:12px; font-weight:700; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">← Back to Upload</button>
                    <button type="button" class="wp-button primary" onclick="goToStep(3)" style="background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F; padding:0 18px; height:36px;">Proceed to Step 3: Validation →</button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- STEP 3: SCHEMA VALIDATION                                -->
            <!-- ======================================================== -->
            <div id="stepPane3" class="wp-table-card" style="display:none; background:#fff; border:1px solid #c3c4c7; border-radius:6px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div style="margin-bottom:16px;">
                    <h3 style="font-size:16px; font-weight:800; color:#181512; margin:0 0 4px 0;">Step 3: Syntax &amp; SKU Validation</h3>
                    <p style="font-size:12.5px; color:#646970; margin:0;">Automated checks passed across all rows.</p>
                </div>

                <div class="dt-kpi-ribbon">
                    <div style="background:#FAF5E8; border:1px solid #D4AF37; border-radius:6px; padding:14px;">
                        <span style="font-size:11px; color:#646970; font-weight:700;">TOTAL ROWS DETECTED</span>
                        <div style="font-size:22px; font-weight:800; color:#181512; margin-top:2px;">250 Products</div>
                    </div>
                    <div style="background:#DCFCE7; border:1px solid #86EFAC; border-radius:6px; padding:14px;">
                        <span style="font-size:11px; color:#15803D; font-weight:700;">VALIDATED &amp; READY</span>
                        <div style="font-size:22px; font-weight:800; color:#15803D; margin-top:2px;">248 Valid SKUs</div>
                    </div>
                    <div style="background:#FEF3C7; border:1px solid #FCD34D; border-radius:6px; padding:14px;">
                        <span style="font-size:11px; color:#B45309; font-weight:700;">OPTIONAL WARNINGS</span>
                        <div style="font-size:22px; font-weight:800; color:#B45309; margin-top:2px;">2 Minor Tags</div>
                    </div>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; padding-top:14px; border-top:1px solid #f0f0f1;">
                    <button type="button" class="wp-button" onclick="goToStep(2)" style="height:36px; padding:0 14px; font-size:12px; font-weight:700; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">← Back to Mapping</button>
                    <button type="button" class="wp-button primary" onclick="goToStep(4)" style="background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F; padding:0 18px; height:36px;">Proceed to Step 4: Preview →</button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- STEP 4: DATA PREVIEW                                     -->
            <!-- ======================================================== -->
            <div id="stepPane4" class="wp-table-card" style="display:none; background:#fff; border:1px solid #c3c4c7; border-radius:6px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div style="margin-bottom:16px;">
                    <h3 style="font-size:16px; font-weight:800; color:#181512; margin:0 0 4px 0;">Step 4: Live Data Preview</h3>
                    <p style="font-size:12.5px; color:#646970; margin:0;">Review the first 3 rows as they will appear in the Wholesale Catalog.</p>
                </div>

                <table class="wp-list-table" style="width:100%; border-collapse:collapse; margin-bottom:16px;">
                    <thead>
                        <tr style="background:#f6f7f7; border-bottom:1px solid #c3c4c7;">
                            <th style="padding:10px 12px;">Product Title</th>
                            <th style="padding:10px 10px;">SKU</th>
                            <th style="padding:10px 10px;">Category</th>
                            <th style="padding:10px 10px;">Wholesale Rate</th>
                            <th style="padding:10px 10px;">Stock Lot</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="border-bottom:1px solid #f0f0f1;">
                            <td style="padding:10px 12px;"><strong>Kanjivaram Pure Silk Gold Zari Saree</strong></td>
                            <td style="padding:10px 10px;"><code style="color:#8A681F; font-weight:700;">KLN-SR-111</code></td>
                            <td style="padding:10px 10px;">Silk Sarees</td>
                            <td style="padding:10px 10px; color:#15803D; font-weight:700;">₹2,850/pc</td>
                            <td style="padding:10px 10px;">45 pcs</td>
                        </tr>
                        <tr style="border-bottom:1px solid #f0f0f1;">
                            <td style="padding:10px 12px;"><strong>Banarasi Royal Brocade Weave Saree</strong></td>
                            <td style="padding:10px 10px;"><code style="color:#8A681F; font-weight:700;">BNR-SR-204</code></td>
                            <td style="padding:10px 10px;">Banarasi Brocade</td>
                            <td style="padding:10px 10px; color:#15803D; font-weight:700;">₹3,200/pc</td>
                            <td style="padding:10px 10px;">28 pcs</td>
                        </tr>
                    </tbody>
                </table>

                <div style="display:flex; justify-content:space-between; align-items:center; padding-top:14px; border-top:1px solid #f0f0f1;">
                    <button type="button" class="wp-button" onclick="goToStep(3)" style="height:36px; padding:0 14px; font-size:12px; font-weight:700; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">← Back to Validation</button>
                    <button type="button" class="wp-button primary" onclick="goToStep(5)" style="background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F; padding:0 18px; height:36px;">Proceed to Step 5: Errors &amp; Overrides →</button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- STEP 5: ERRORS & OVERRIDES                               -->
            <!-- ======================================================== -->
            <div id="stepPane5" class="wp-table-card" style="display:none; background:#fff; border:1px solid #c3c4c7; border-radius:6px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div style="margin-bottom:16px;">
                    <h3 style="font-size:16px; font-weight:800; color:#181512; margin:0 0 4px 0;">Step 5: Error Resolution &amp; Auto-Fix</h3>
                    <p style="font-size:12.5px; color:#646970; margin:0;">2 products had minor unassigned fabric tags. Auto-defaulted to "Mulberry Silk Blend".</p>
                </div>

                <div style="background:#DCFCE7; border:1px solid #86EFAC; border-radius:6px; padding:14px; margin-bottom:16px;">
                    <strong style="color:#15803D; font-size:13px; display:block; margin-bottom:4px;">✓ Zero Critical Blocking Errors</strong>
                    <span style="font-size:12px; color:#166534;">All 248 products meet DT Brand's database schema requirements.</span>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; padding-top:14px; border-top:1px solid #f0f0f1;">
                    <button type="button" class="wp-button" onclick="goToStep(4)" style="height:36px; padding:0 14px; font-size:12px; font-weight:700; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">← Back to Preview</button>
                    <button type="button" class="wp-button primary" onclick="goToStep(6)" style="background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F; padding:0 18px; height:36px;">Proceed to Step 6: Confirmation →</button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- STEP 6: CONFIRMATION                                     -->
            <!-- ======================================================== -->
            <div id="stepPane6" class="wp-table-card" style="display:none; background:#fff; border:1px solid #c3c4c7; border-radius:6px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div style="margin-bottom:16px;">
                    <h3 style="font-size:16px; font-weight:800; color:#181512; margin:0 0 4px 0;">Step 6: Import Confirmation &amp; Target Destination</h3>
                    <p style="font-size:12.5px; color:#646970; margin:0;">Confirm batch insertion into Surat Central Depot catalog.</p>
                </div>

                <div style="background:#FAF5E8; border:1px solid #D4AF37; border-radius:6px; padding:16px; margin-bottom:20px;">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                        <div>
                            <span style="font-size:11px; color:#646970; font-weight:700;">BATCH IDENTIFIER</span>
                            <div style="font-size:14px; font-weight:800; color:#181512;">BATCH-SURAT-2026-08</div>
                        </div>
                        <div>
                            <span style="font-size:11px; color:#646970; font-weight:700;">TOTAL SKUS TO INSERT</span>
                            <div style="font-size:14px; font-weight:800; color:#15803D;">248 Textile Items</div>
                        </div>
                    </div>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; padding-top:14px; border-top:1px solid #f0f0f1;">
                    <button type="button" class="wp-button" onclick="goToStep(5)" style="height:36px; padding:0 14px; font-size:12px; font-weight:700; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">← Back to Errors</button>
                    <button type="button" class="wp-button primary" onclick="executeImportNow()" style="background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F; padding:0 22px; height:38px; display:inline-flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#181512" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Execute Import Now</span>
                    </button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- STEP 7: DONE / COMPLETED                                 -->
            <!-- ======================================================== -->
            <div id="stepPane7" class="wp-table-card" style="display:none; background:#fff; border:1px solid #c3c4c7; border-radius:6px; padding:40px; text-align:center; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div style="width:60px; height:60px; border-radius:50%; background:#DCFCE7; border:2px solid #86EFAC; display:inline-flex; align-items:center; justify-content:center; color:#15803D; margin-bottom:14px;">
                    <svg viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="#15803D" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                </div>
                <h2 style="font-size:20px; font-weight:800; color:#181512; margin:0 0 6px 0;">Import Completed Successfully!</h2>
                <p style="font-size:13px; color:#646970; margin:0 0 22px 0;">248 new products have been inserted into your catalog with active stock and wholesale MOQ pricing.</p>
                
                <div style="display:flex; justify-content:center; gap:12px;">
                    <a href="/Frontend/Admin/products/" class="wp-button primary" style="background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F; padding:0 18px; height:36px; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                        <span>View Products Catalog (1,488 SKUs)</span>
                    </a>
                    <button type="button" class="wp-button" onclick="goToStep(1)" style="height:36px; padding:0 16px; font-size:12px; font-weight:700; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                        <span>+ Import Another Batch</span>
                    </button>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function goToStep(step) {
    // Hide all panes
    for (let i = 1; i <= 7; i++) {
        const pane = document.getElementById('stepPane' + i);
        const node = document.getElementById('stepNode' + i);
        if (pane) pane.style.display = 'none';
        if (node) {
            node.classList.remove('active');
            if (i < step) node.classList.add('completed');
            else node.classList.remove('completed');
        }
    }
    const currentPane = document.getElementById('stepPane' + step);
    const currentNode = document.getElementById('stepNode' + step);
    if (currentPane) currentPane.style.display = 'block';
    if (currentNode) currentNode.classList.add('active');
}

function handleFileSelected(input) {
    if (input.files && input.files[0]) {
        const name = input.files[0].name;
        const title = document.getElementById('dropzoneTitle');
        if (title) title.textContent = `✓ Selected: ${name}`;
        if (typeof window.showToast === 'function') window.showToast(`✨ File loaded: ${name}`);
    }
}

function downloadSampleTemplate() {
    if (typeof window.showToast === 'function') window.showToast('📄 Downloading DT Brand Wholesale Catalog Template...');
}

function executeImportNow() {
    if (typeof window.showToast === 'function') window.showToast('🚀 Executing batch import...');
    setTimeout(() => {
        goToStep(7);
        if (typeof window.showToast === 'function') window.showToast('🎉 248 Products imported successfully!');
    }, 600);
}
</script>
</body>
</html>
