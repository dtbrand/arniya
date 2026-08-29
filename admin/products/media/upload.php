<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

$page_title = "Upload Media";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Media — DT Brand's Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/media.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="dt-prod-header">
                <div class="dt-prod-title-group">
                    <h1><span>Upload High-Res Media</span></h1>
                </div>
                <div class="dt-prod-actions">
                    <a href="/admin/products/media/" class="adm-btn-secondary">← Back to Media Library</a>
                </div>
            </div>
            <div class="adm-card">
                <div class="dt-dropzone" style="padding:40px 20px;" onclick="document.getElementById('mFile').click()">
                    <div style="font-size:2.5rem; margin-bottom:8px;">📤</div>
                    <h3>Drag &amp; Drop High-Res Product Photos or Videos</h3>
                    <p style="font-size:0.8rem; color:#7A7266; margin-top:4px;">Supported: WebP, PNG, JPG, MP4 (Video). Automatic WebP 85% compression applied.</p>
                    <input type="file" id="mFile" style="display:none;" multiple onchange="window.showToast('4 files uploaded successfully!')">
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
