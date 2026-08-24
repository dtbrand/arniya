<?php
/**
 * methods.php - DT Brand's Admin Courier Partners & Methods
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Courier Partners & Methods";
$active_nav = "shipping";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courier Partners & Methods - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
                        <span>Courier Partners & Methods</span>
                        <span class="adm-badge gold">Integrated</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage automated integrations with Delhivery, BlueDart, and TCI Freight.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/DT%20Brand/admin/shipping/" class="adm-btn-secondary">← Back to Shipping Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>🚚 Active Courier Integrations</span></h3>
            </div>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:16px;">
                <div style="padding:16px; background:#FAF8F4; border:1px solid #E5E1D7; border-radius:8px;">
                    <h4>Delhivery Express</h4>
                    <p style="font-size:0.8rem; color:#7A7266;">Air & Surface parcel delivery across 19,000+ pincodes.</p>
                    <span class="adm-badge success">Connected</span>
                </div>
                <div style="padding:16px; background:#FAF8F4; border:1px solid #E5E1D7; border-radius:8px;">
                    <h4>TCI Freight Cargo</h4>
                    <p style="font-size:0.8rem; color:#7A7266;">Heavy surface B2B consignment transport (> 20 kg).</p>
                    <span class="adm-badge success">Connected</span>
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
