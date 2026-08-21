<?php
/**
 * export.php — Customer Export Studio (CSV / Excel / PDF)
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
$page_title = "Customer Export Studio";
$active_nav = "customers";
$active_subnav = "export";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/customers/assets/css/customer-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-customers-container">
                <div class="dt-cust-head">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title">
                            <span>Customer Export Studio</span>
                            <span class="dt-cust-badge gold">Data Reports</span>
                        </h1>
                        <p class="dt-cust-subtitle">Generate downloadable CSV spreadsheets, Excel workbooks, or PDF printable dossiers with custom column selection.</p>
                    </div>
                    <div class="dt-cust-actions">
                        <a href="/Frontend/Admin/customers/index.php" class="dt-btn dt-btn-pale">← Back to Directory</a>
                    </div>
                </div>

                <!-- Export Wizard Card -->
                <div class="dt-card" style="max-width:820px; margin:0 auto; width:100%;">
                    <div class="dt-card-head" style="border-bottom:1.5px solid #F1ECE1; padding-bottom:10px;">
                        <h3 class="dt-card-title">Configure Customer Export Parameters</h3>
                    </div>

                    <form onsubmit="event.preventDefault(); window.showToast('📥 Exporting data file... Download will start automatically.');" style="display:flex; flex-direction:column; gap:16px; margin-top:12px;">
                        <!-- Format Selection -->
                        <div>
                            <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:8px;">1. Select Export Format</label>
                            <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:10px;">
                                <label style="display:flex; align-items:center; gap:8px; padding:10px; background:#FAF8F4; border:1.5px solid var(--dt-gold-primary); border-radius:8px; cursor:pointer;">
                                    <input type="radio" name="export_format" value="csv" checked>
                                    <div>
                                        <strong style="font-size:0.8rem; display:block; color:#181512;">CSV Spreadsheet</strong>
                                        <small style="font-size:0.65rem; color:#78716C;">Universal .csv text</small>
                                    </div>
                                </label>

                                <label style="display:flex; align-items:center; gap:8px; padding:10px; background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; cursor:pointer;">
                                    <input type="radio" name="export_format" value="excel">
                                    <div>
                                        <strong style="font-size:0.8rem; display:block; color:#181512;">Excel Workbook</strong>
                                        <small style="font-size:0.65rem; color:#78716C;">Microsoft .xlsx format</small>
                                    </div>
                                </label>

                                <label style="display:flex; align-items:center; gap:8px; padding:10px; background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; cursor:pointer;">
                                    <input type="radio" name="export_format" value="pdf">
                                    <div>
                                        <strong style="font-size:0.8rem; display:block; color:#181512;">Printable PDF</strong>
                                        <small style="font-size:0.65rem; color:#78716C;">Formatted Dossier Document</small>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Data Scope -->
                        <div>
                            <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">2. Audience Scope</label>
                            <select class="dt-cust-select" style="width:100%;">
                                <option value="all">All Registered Customers (4,820 Shoppers)</option>
                                <option value="active">Active Verified Accounts (4,180 Shoppers)</option>
                                <option value="vip">VIP High-Value Spenders (312 Shoppers)</option>
                                <option value="dormant">Dormant Accounts > 60 Days (640 Shoppers)</option>
                            </select>
                        </div>

                        <!-- Included Columns Checkboxes -->
                        <div>
                            <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:8px;">3. Fields &amp; Attributes to Include</label>
                            <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:8px; font-size:0.75rem; font-weight:700; color:#181512;">
                                <label style="display:flex; align-items:center; gap:6px;"><input type="checkbox" checked> Customer ID</label>
                                <label style="display:flex; align-items:center; gap:6px;"><input type="checkbox" checked> Full Name</label>
                                <label style="display:flex; align-items:center; gap:6px;"><input type="checkbox" checked> Phone Number</label>
                                <label style="display:flex; align-items:center; gap:6px;"><input type="checkbox" checked> Email Address</label>
                                <label style="display:flex; align-items:center; gap:6px;"><input type="checkbox" checked> Total Orders</label>
                                <label style="display:flex; align-items:center; gap:6px;"><input type="checkbox" checked> Lifetime Spend (₹)</label>
                                <label style="display:flex; align-items:center; gap:6px;"><input type="checkbox" checked> City &amp; State</label>
                                <label style="display:flex; align-items:center; gap:6px;"><input type="checkbox" checked> Joined Date</label>
                                <label style="display:flex; align-items:center; gap:6px;"><input type="checkbox" checked> Assigned Tags</label>
                            </div>
                        </div>

                        <div style="display:flex; align-items:center; justify-content:flex-end; gap:8px; border-top:1.5px solid #F1ECE1; padding-top:14px;">
                            <a href="/Frontend/Admin/customers/index.php" class="dt-btn dt-btn-pale">Cancel</a>
                            <button type="submit" class="dt-btn dt-btn-gold">Generate &amp; Download File</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/customers/assets/js/customers.js?v=<?php echo time(); ?>"></script>
</body>
</html>
