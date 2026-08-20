<?php
/**
 * export.php — Order Export Studio
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Export Orders Studio";
$active_nav = "orders";
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/orders.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/order-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-orders-container">
                <div class="dt-orders-head">
                    <div class="dt-orders-title-group">
                        <h1 class="dt-orders-title">
                            <span>Order Export Studio</span>
                            <span class="dt-kpi-badge up" style="font-size:10px; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37;">CSV • Excel • Tally XML</span>
                        </h1>
                        <p class="dt-orders-subtitle">Export filtered order manifests, GST tax ledgers, and logistics dispatch sheets.</p>
                    </div>
                    <div class="dt-orders-actions">
                        <a href="/Frontend/Admin/orders/index.php" class="dt-btn dt-btn-pale">← Back to Orders</a>
                    </div>
                </div>

                <div class="dt-detail-card" style="max-width:680px; margin:0 auto;">
                    <div class="dt-detail-card-head">
                        <h3 class="dt-detail-card-title">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                            <span>Configure Export Dataset</span>
                        </h3>
                    </div>
                    <div class="dt-detail-card-body" style="display:flex; flex-direction:column; gap:14px;">
                        <div>
                            <label style="font-size:11.5px; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Export Scope</label>
                            <select class="dt-order-search-input" style="height:36px; font-weight:600;">
                                <option value="all">All Orders in Database (1,624 Records)</option>
                                <option value="shipped">Only Shipped &amp; Delivered Orders</option>
                                <option value="pending">Pending Dispatch Consignments</option>
                                <option value="returns">Returns &amp; Refunded Items</option>
                            </select>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                            <div>
                                <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:4px;">Date From</label>
                                <input type="date" value="2026-08-01" class="dt-order-search-input" style="height:34px;">
                            </div>
                            <div>
                                <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:4px;">Date To</label>
                                <input type="date" value="2026-08-21" class="dt-order-search-input" style="height:34px;">
                            </div>
                        </div>

                        <div>
                            <label style="font-size:11.5px; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Output File Format</label>
                            <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:10px;">
                                <label style="border:1.5px solid #8A681F; background:#FAF5E8; border-radius:6px; padding:10px; display:flex; flex-direction:column; gap:4px; cursor:pointer;">
                                    <input type="radio" name="exportFormat" value="csv" checked style="accent-color:#8A681F;">
                                    <strong style="font-size:12px; color:#181512;">Excel / CSV</strong>
                                    <small style="color:#64748B; font-size:10px;">Raw Spreadsheet</small>
                                </label>
                                <label style="border:1px solid #CBD5E1; background:#FFFFFF; border-radius:6px; padding:10px; display:flex; flex-direction:column; gap:4px; cursor:pointer;">
                                    <input type="radio" name="exportFormat" value="pdf" style="accent-color:#8A681F;">
                                    <strong style="font-size:12px; color:#181512;">PDF Report</strong>
                                    <small style="color:#64748B; font-size:10px;">Printable Summary</small>
                                </label>
                                <label style="border:1px solid #CBD5E1; background:#FFFFFF; border-radius:6px; padding:10px; display:flex; flex-direction:column; gap:4px; cursor:pointer;">
                                    <input type="radio" name="exportFormat" value="xml" style="accent-color:#8A681F;">
                                    <strong style="font-size:12px; color:#181512;">Tally GST XML</strong>
                                    <small style="color:#64748B; font-size:10px;">Accounting Import</small>
                                </label>
                            </div>
                        </div>

                        <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:8px;">
                            <a href="/Frontend/Admin/orders/index.php" class="dt-btn dt-btn-pale">Cancel</a>
                            <button type="button" class="dt-btn dt-btn-gold" onclick="if(window.DT_ORDERS) window.DT_ORDERS.showToast('📥 Generating and downloading order dataset...');">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                <span>Download Export File</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
</body>
</html>
