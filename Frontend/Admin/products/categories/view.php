<?php
$page_title = "Category Details";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Category Details — DT Brand's Admin</title>
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
                    <h1><span>Category: Silk Sarees</span><span class="adm-badge gold">420 Active SKUs</span></h1>
                </div>
                <div class="dt-prod-actions">
                    <a href="/Frontend/Admin/products/categories/" class="adm-btn-secondary">← Back to Categories</a>
                    <a href="/Frontend/Admin/products/categories/edit.php?id=1" class="adm-btn-primary">Edit Category</a>
                </div>
            </div>
            <div class="adm-card">
                <p>HSN Code: <strong>5007</strong> • GST Tax Rate: <strong>5%</strong></p>
            </div>
        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
