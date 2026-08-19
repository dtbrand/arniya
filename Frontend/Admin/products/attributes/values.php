<?php
$page_title = "Manage Attribute Values";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attribute Values — DT Brand's Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/variants.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="dt-prod-header">
                <div class="dt-prod-title-group">
                    <h1><span>Manage Color Values</span><span class="adm-badge gold">12 Colors</span></h1>
                </div>
                <div class="dt-prod-actions">
                    <a href="/Frontend/Admin/products/attributes/" class="adm-btn-secondary">← Back to Attributes</a>
                    <button class="adm-btn-primary" onclick="window.showToast('Add Color Value Dialog...')">+ Add Value</button>
                </div>
            </div>
            <div class="adm-card">
                <div style="display:flex; flex-wrap:wrap; gap:8px;">
                    <span class="dt-attr-chip" style="font-size:0.85rem; padding:6px 14px;">Crimson Red ✕</span>
                    <span class="dt-attr-chip" style="font-size:0.85rem; padding:6px 14px;">Bottle Green ✕</span>
                    <span class="dt-attr-chip" style="font-size:0.85rem; padding:6px 14px;">Royal Blue ✕</span>
                    <span class="dt-attr-chip" style="font-size:0.85rem; padding:6px 14px;">Mustard Gold ✕</span>
                    <span class="dt-attr-chip" style="font-size:0.85rem; padding:6px 14px;">Rani Pink ✕</span>
                    <span class="dt-attr-chip" style="font-size:0.85rem; padding:6px 14px;">Peacock Teal ✕</span>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
