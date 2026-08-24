<?php
$page_title = "Add Category";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Category — DT Brand's Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/categories.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="dt-prod-header">
                <div class="dt-prod-title-group">
                    <h1><span>Add New Category</span></h1>
                    <p>Create a root catalog taxonomy with HSN tax slabs.</p>
                </div>
                <div class="dt-prod-actions">
                    <a href="/admin/products/categories/" class="adm-btn-secondary">Cancel</a>
                    <button class="adm-btn-primary" onclick="window.showToast('Category created successfully!')">Save Category</button>
                </div>
            </div>
            <div class="adm-card">
                <div class="adm-form-grid">
                    <div class="adm-form-group">
                        <label class="adm-form-label">Category Name *</label>
                        <input type="text" class="adm-form-input" placeholder="e.g. Bandhani Sarees">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">URL Slug</label>
                        <input type="text" class="adm-form-input" placeholder="bandhani-sarees">
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">HSN Tax Slab</label>
                        <select class="adm-form-select">
                            <option>5007 — 5% Silk GST</option>
                            <option>6204 — 12% Apparel GST</option>
                            <option>5208 — 5% Cotton GST</option>
                        </select>
                    </div>
                    <div class="adm-form-group">
                        <label class="adm-form-label">Parent Taxonomy</label>
                        <select class="adm-form-select">
                            <option>None (Root Category)</option>
                            <option>Silk Sarees</option>
                            <option>Kurtis & Sets</option>
                        </select>
                    </div>
                    <div class="adm-form-group full">
                        <label class="adm-form-label">Category Description</label>
                        <textarea class="adm-form-textarea" rows="3" placeholder="Description shown on shop catalogue header."></textarea>
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
