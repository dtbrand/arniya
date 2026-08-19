<?php
/**
 * kyc.php - DT Brand's Admin Wholesalers Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = 'Wholesalers - Kyc';
$active_nav = 'wholesalers';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesalers - Kyc - DT Brand's Admin</title>
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
                        <span>Wholesalers - Kyc</span>
                        <span class="adm-badge gold">WHOLESALERS</span>
                    </h1>
                    <p class="adm-page-subtitle">Separate modular management for DT Brand's wholesalers.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Back to Main Dashboard</a>
                    <button type="button" class="adm-btn-primary" onclick="window.showToast('Action saved successfully!')">+ New Action</button>
                </div>
            </div>

            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Wholesalers - Kyc Suite</span></h3>
                    <button type="button" class="adm-btn-secondary" onclick="window.showToast('Exporting data...')">Export</button>
                </div>
                <div style="padding:36px 20px; text-align:center; background:#FAF8F4; border-radius:8px; border:1px dashed #E5E1D7;">
                    <div style="font-size:2.2rem; margin-bottom:10px;">📦</div>
                    <h3 style="font-size:1.15rem; font-weight:800; color:#181512;">Wholesalers - Kyc</h3>
                    <p style="font-size:0.82rem; color:#7A7266; max-width:540px; margin:6px auto 18px;">
                        Dedicated modular view for <strong>Wholesalers</strong>. Ready to connect to MySQL backend and live CRM endpoints.
                    </p>
                    <div style="display:flex; justify-content:center; gap:10px;">
                        <a href="/Frontend/Admin/admin.php" class="adm-btn-primary">Go to Main Dashboard</a>
                        <button type="button" class="adm-btn-secondary" onclick="window.showToast('Module synced!')">Refresh Data</button>
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
