<?php
/**
 * upload.php - DT Brand's Admin Media Asset Batch Uploader
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Media Asset Batch Uploader";
$active_nav = "media";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Asset Batch Uploader - DT Brand's Admin</title>
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
                        <span>Media Asset Batch Uploader</span>
                        <span class="adm-badge gold">Uploader</span>
                    </h1>
                    <p class="adm-page-subtitle">Drag and drop high-resolution saree photos and catalog banners.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/DT%20Brand/admin/media/" class="adm-btn-secondary">← Back to Media Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-card">
            <div class="adm-card-head">
                <h3 class="adm-card-title"><span>📤 Drag & Drop Asset Uploader</span></h3>
            </div>
            <div style="padding:40px; border:2px dashed #D5A021; border-radius:8px; text-align:center; background:#FAF8F4;">
                <div style="font-size:2.5rem; margin-bottom:10px;">📁</div>
                <h4>Drag high-res WebP / PNG / JPG images here</h4>
                <p style="color:#7A7266; font-size:0.8rem; margin:8px 0 16px;">Files are automatically optimized to WebP format for high-speed page loads.</p>
                <button class="adm-btn-primary" onclick="window.showToast('Choose Files...')">Browse Files</button>
            </div>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/DT%20Brand/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
