<?php
$page_title = "Subcategories Hierarchy";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Subcategories — DT Brand's Admin</title>
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
                    <h1><span>Subcategories Hierarchy</span><span class="adm-badge gold">34 Subcategories</span></h1>
                </div>
                <div class="dt-prod-actions">
                    <a href="/Frontend/Admin/products/" class="adm-btn-secondary">← Back to Products</a>
                    <a href="/Frontend/Admin/products/subcategories/add.php" class="adm-btn-primary">+ Add Subcategory</a>
                </div>
            </div>
            <div class="adm-table-card">
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Subcategory Name</th>
                                <th>Parent Category</th>
                                <th>Active SKUs</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Kanjivaram Silk</strong></td>
                                <td>Silk Sarees</td>
                                <td>142 SKUs</td>
                                <td><span class="adm-badge success">Active</span></td>
                                <td><a href="/Frontend/Admin/products/subcategories/edit.php?id=1" class="adm-btn-secondary adm-btn-sm">Edit</a></td>
                            </tr>
                            <tr>
                                <td><strong>Paithani Zari</strong></td>
                                <td>Silk Sarees</td>
                                <td>98 SKUs</td>
                                <td><span class="adm-badge success">Active</span></td>
                                <td><a href="/Frontend/Admin/products/subcategories/edit.php?id=2" class="adm-btn-secondary adm-btn-sm">Edit</a></td>
                            </tr>
                            <tr>
                                <td><strong>Zardosi Bridal</strong></td>
                                <td>Bridal Lehengas</td>
                                <td>84 SKUs</td>
                                <td><span class="adm-badge success">Active</span></td>
                                <td><a href="/Frontend/Admin/products/subcategories/edit.php?id=3" class="adm-btn-secondary adm-btn-sm">Edit</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
