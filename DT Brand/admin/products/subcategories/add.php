<?php
$page_title = "Add Subcategory";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Subcategory — DT Brand's Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="dt-prod-header">
                <div class="dt-prod-title-group">
                    <h1><span>Add Subcategory</span></h1>
                </div>
                <div class="dt-prod-actions">
                    <a href="/admin/products/subcategories/" class="adm-btn-secondary">Cancel</a>
                    <button class="adm-btn-primary" onclick="window.showToast('Subcategory created!')">Save Subcategory</button>
                </div>
            </div>
            <div class="adm-card">
                <div class="adm-form-grid">
                    <div class="adm-form-group">
                        <label class="adm-form-label">Subcategory Name</label>
                        <input type="text" class="adm-form-input" placeholder="e.g. Chanderi Pure Silk">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Parent Category</label>
                        <select class="adm-form-select">
                            <option>Silk Sarees</option>
                            <option>Banarasi Brocade</option>
                            <option>Bridal Lehengas</option>
                        </select>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
