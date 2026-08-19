<?php
/**
 * categories.php - DT Brand's Admin Category & Fabric Collections
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Category & Fabric Collections";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category & Fabric Collections - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
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
                        <span>Category & Fabric Collections</span>
                        <span class="adm-badge gold">16 Categories</span>
                    </h1>
                    <p class="adm-page-subtitle">Organize textile categories, sub-categories, HSN tax classifications, and collection banners.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/products/" class="adm-btn-secondary">← Back to Products Suite</a>
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800;">Catalog Categories</h3></div>
                <button class="adm-btn-primary" onclick="window.showToast('Opening Category Builder...')">+ Add Category</button>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Total SKUs</th>
                            <th>HSN Code</th>
                            <th>GST Rate</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Silk Sarees</strong><br><small style="color:#7A7266;">Kanjivaram, Mysore, Paithani</small></td>
                            <td><strong>420 SKUs</strong></td>
                            <td>5007</td>
                            <td>5%</td>
                            <td><span class="adm-badge success">Active</span></td>
                            <td><button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Editing Category...')">Edit</button></td>
                        </tr>
                        <tr>
                            <td><strong>Banarasi Brocade</strong><br><small style="color:#7A7266;">Katan, Tanchoi, Organza</small></td>
                            <td><strong>280 SKUs</strong></td>
                            <td>5007</td>
                            <td>5%</td>
                            <td><span class="adm-badge success">Active</span></td>
                            <td><button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Editing Category...')">Edit</button></td>
                        </tr>
                        <tr>
                            <td><strong>Bridal Lehengas</strong><br><small style="color:#7A7266;">Velvet, Silk, Zardosi</small></td>
                            <td><strong>160 SKUs</strong></td>
                            <td>6204</td>
                            <td>12%</td>
                            <td><span class="adm-badge success">Active</span></td>
                            <td><button class="adm-btn-secondary adm-btn-sm" onclick="window.showToast('Editing Category...')">Edit</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
