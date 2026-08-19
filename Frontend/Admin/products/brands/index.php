<?php
$page_title = "Brands Management";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Brands — DT Brand's Admin</title>
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
                    <h1><span>Brands &amp; House Labels</span><span class="adm-badge gold">4 Brands</span></h1>
                </div>
                <div class="dt-prod-actions">
                    <a href="/Frontend/Admin/products/" class="adm-btn-secondary">← Back to Products</a>
                    <a href="/Frontend/Admin/products/brands/add.php" class="adm-btn-primary">+ Add Brand</a>
                </div>
            </div>
            <div class="adm-table-card">
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Brand Logo</th>
                                <th>Brand Name</th>
                                <th>Catalog SKUs</th>
                                <th>Tier</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><div class="adm-wa-avatar" style="background:#FAF5E8; color:#8A681F; font-weight:800;">DT</div></td>
                                <td><strong>DT Signature</strong></td>
                                <td>680 SKUs</td>
                                <td><span class="adm-badge gold">Primary Flagship</span></td>
                                <td><span class="adm-badge success">Active</span></td>
                                <td><a href="/Frontend/Admin/products/brands/edit.php?id=1" class="adm-btn-secondary adm-btn-sm">Edit</a></td>
                            </tr>
                            <tr>
                                <td><div class="adm-wa-avatar" style="background:#FAF5E8; color:#8A681F; font-weight:800;">AH</div></td>
                                <td><strong>Arniya Heritage</strong></td>
                                <td>420 SKUs</td>
                                <td><span class="adm-badge">Heritage Brocade</span></td>
                                <td><span class="adm-badge success">Active</span></td>
                                <td><a href="/Frontend/Admin/products/brands/edit.php?id=2" class="adm-btn-secondary adm-btn-sm">Edit</a></td>
                            </tr>
                            <tr>
                                <td><div class="adm-wa-avatar" style="background:#FAF5E8; color:#8A681F; font-weight:800;">DC</div></td>
                                <td><strong>DT Couture</strong></td>
                                <td>140 SKUs</td>
                                <td><span class="adm-badge purple">Bridal Luxury</span></td>
                                <td><span class="adm-badge success">Active</span></td>
                                <td><a href="/Frontend/Admin/products/brands/edit.php?id=3" class="adm-btn-secondary adm-btn-sm">Edit</a></td>
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
