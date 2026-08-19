<?php
$page_title = "Add Brand";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Brand — DT Brand's Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="dt-prod-header">
                <div class="dt-prod-title-group">
                    <h1><span>Add House Brand</span></h1>
                </div>
                <div class="dt-prod-actions">
                    <a href="/Frontend/Admin/products/brands/" class="adm-btn-secondary">Cancel</a>
                    <button class="adm-btn-primary" onclick="window.showToast('Brand added!')">Save Brand</button>
                </div>
            </div>
            <div class="adm-card">
                <div class="adm-form-grid">
                    <div class="adm-form-group">
                        <label class="adm-form-label">Brand Name</label>
                        <input type="text" class="adm-form-input" placeholder="e.g. DT Prêt">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Brand Slug</label>
                        <input type="text" class="adm-form-input" placeholder="dt-pret">
                    </div>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
