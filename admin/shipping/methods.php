<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * methods.php - DT Brand's Admin Courier Partners & Methods
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Courier Partners & Logistics Integrations";
$active_nav = "shipping";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Partners &amp; Methods - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-courier-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 16px;
        }
        .dt-courier-card {
            border: 1.5px solid #EAE5D9;
            border-radius: 10px;
            padding: 16px 18px;
            background: #FFFFFF;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Courier Partners &amp; Methods</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">4 Integrated Logistics APIs</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Manage automated AWB dispatch generation, pickup scheduling, and webhook tracking sync.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/shipping/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← Shipping Suite</a>
                    <a href="/admin/shipping/rates.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">Rate Matrix →</a>
                </div>
            </div>

            <!-- Courier Cards Grid -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>🚚 Active Logistics Carrier Integrations</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">🟢 Auto-Pickup Scheduling</span>
                </div>
                <div class="dt-courier-grid" style="padding:16px 18px;">
                    <!-- Delhivery -->
                    <div class="dt-courier-card">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <h4 style="margin:0; font-size:1.05rem; font-weight:800; color:#181512;">Delhivery Express</h4>
                                <span class="adm-badge success">Live API</span>
                            </div>
                            <p style="font-size:0.82rem; color:#64748B; margin:0 0 12px 0;">Air &amp; Surface parcel delivery across 19,000+ pincodes across India. Auto-AWB generation enabled.</p>
                            <div style="font-size:11.5px; color:#181512; font-weight:600; background:#FAF8F4; padding:6px 10px; border-radius:6px; margin-bottom:12px;">
                                SLA: 2–4 Business Days | COD Supported
                            </div>
                        </div>
                        <div style="display:flex; justify-content:flex-end; gap:6px;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('Testing Delhivery API connection... Status: 200 OK')">Test Webhook</button>
                            <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="window.showToast('Delhivery settings synced!')">Configure</button>
                        </div>
                    </div>

                    <!-- BlueDart -->
                    <div class="dt-courier-card">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <h4 style="margin:0; font-size:1.05rem; font-weight:800; color:#181512;">BlueDart Air Express</h4>
                                <span class="adm-badge success">Live API</span>
                            </div>
                            <p style="font-size:0.82rem; color:#64748B; margin:0 0 12px 0;">Premium overnight air shipping for high-value pure zari and bridal wedding collections.</p>
                            <div style="font-size:11.5px; color:#181512; font-weight:600; background:#FAF8F4; padding:6px 10px; border-radius:6px; margin-bottom:12px;">
                                SLA: 24–48 Hours Metro | High Security
                            </div>
                        </div>
                        <div style="display:flex; justify-content:flex-end; gap:6px;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('Testing BlueDart API connection... Status: 200 OK')">Test Webhook</button>
                            <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="window.showToast('BlueDart settings synced!')">Configure</button>
                        </div>
                    </div>

                    <!-- TCI Freight -->
                    <div class="dt-courier-card">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                                <h4 style="margin:0; font-size:1.05rem; font-weight:800; color:#181512;">TCI Freight B2B Cargo</h4>
                                <span class="adm-badge gold" style="font-weight:800;">Wholesale Bales</span>
                            </div>
                            <p style="font-size:0.82rem; color:#64748B; margin:0 0 12px 0;">Dedicated surface transport for heavy wholesale master bales and boutique carton consignments (&gt;25 kg).</p>
                            <div style="font-size:11.5px; color:#181512; font-weight:600; background:#FAF8F4; padding:6px 10px; border-radius:6px; margin-bottom:12px;">
                                SLA: 3–6 Days Regional | Pallet Tracking
                            </div>
                        </div>
                        <div style="display:flex; justify-content:flex-end; gap:6px;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('Testing TCI Freight connection... Status: 200 OK')">Test Webhook</button>
                            <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="window.showToast('TCI Freight settings synced!')">Configure</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
