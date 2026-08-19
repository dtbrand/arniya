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
                    <h1><span>Brands Management</span></h1>
                </div>
                <div class="dt-prod-actions">
                    <a href="/Frontend/Admin/products/" class="adm-btn-secondary">← Back to Products</a>
                    <button class="adm-btn-primary" onclick="window.showToast('Add Brand Dialog...')">+ Add Brand</button>
                </div>
            </div>
            <div class="adm-table-card">
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Brand Logo</th>
                                <th>Brand Name</th>
                                <th>Total SKUs</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><div class="adm-wa-avatar" style="background:#FAF5E8; color:#8A681F; font-weight:800;">DT</div></td>
                                <td><strong>DT Signature</strong></td>
                                <td>680 SKUs</td>
                                <td><span class="adm-badge gold">Primary Brand</span></td>
                            </tr>
                            <tr>
                                <td><div class="adm-wa-avatar" style="background:#FAF5E8; color:#8A681F; font-weight:800;">AH</div></td>
                                <td><strong>Arniya Heritage</strong></td>
                                <td>420 SKUs</td>
                                <td><span class="adm-badge success">Active</span></td>
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
