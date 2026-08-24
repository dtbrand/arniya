<?php
/**
 * banners.php - DT Brand's Admin Homepage Banners & Sliders
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Homepage Banners & Sliders";
$active_nav = "marketing";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Banners & Sliders - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
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
                        <span>Homepage Banners & Sliders</span>
                        <span class="adm-badge gold">Hero Creatives</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage top rotating promotional banners, mobile banners, and click URLs.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/marketing/" class="adm-btn-secondary">← Back to Marketing Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>🖼️ Active Homepage Hero Sliders</span></h3>
                <button class="adm-btn-primary" onclick="window.showToast('Upload Banner Dialog...')">+ Add New Banner</button>
            </div>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:16px;">
                <div style="border:1px solid #E5E1D7; border-radius:8px; overflow:hidden; background:#FAF8F4;">
                    <div style="height:120px; background:#8A681F; color:#FFF; display:flex; align-items:center; justify-content:center; font-weight:800;">Festive Silk Mela 2026</div>
                    <div style="padding:10px; display:flex; justify-content:space-between; align-items:center;">
                        <span>Banner #1 (Active)</span>
                        <button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Editing Banner...')">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
