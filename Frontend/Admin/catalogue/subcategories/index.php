<?php
/**
 * subcategories/index.php — Subcategory Management List
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Subcategories";
$active_nav = "catalogue";
$active_subnav = "subcategories";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subcategories ‹ DT Brand's Catalogue</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/catalogue/assets/css/catalogue.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div>
                    <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;">Subcategories (42 Active)</h1>
                    <p style="font-size:12px; color:#64748b; margin:2px 0 0 0;">Manage specific weaves, fabric types, and nested sub-classifications.</p>
                </div>
                <div style="display:flex; gap:6px;">
                    <a href="/Frontend/Admin/catalogue/subcategories/add.php" class="dt-btn-action-sm gold" style="height:30px; padding:0 12px; font-size:11.5px;">+ Add Subcategory</a>
                    <a href="/Frontend/Admin/catalogue/subcategories/reorder.php" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 10px; font-size:11.5px;">Reorder</a>
                </div>
            </div>

            <!-- Subcategories Table -->
            <div class="dt-cat-card">
                <div class="dt-cat-table-wrap">
                    <table class="dt-cat-table" id="subcatTable">
                        <thead>
                            <tr>
                                <th style="width:30px; text-align:center;"><input type="checkbox" onchange="window.DT_CATALOGUE.toggleSelectAll(this, 'subcat-chk')" style="cursor:pointer;"></th>
                                <th style="width:40px;">Image</th>
                                <th>Subcategory Name</th>
                                <th>Parent Category</th>
                                <th>Products</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="subcat-1">
                                <td style="text-align:center;"><input type="checkbox" class="subcat-chk" value="101"></td>
                                <td><img src="/Frontend/Shop/Asset/images/product1.png" style="width:32px; height:32px; border-radius:4px; object-fit:cover;"></td>
                                <td><strong>Kanjivaram Silk</strong></td>
                                <td><a href="/Frontend/Admin/catalogue/categories/view.php?id=1" style="color:#8A681F; font-weight:700; text-decoration:none;">Silk Sarees</a></td>
                                <td><strong>160 SKUs</strong></td>
                                <td>#1</td>
                                <td><span class="dt-badge green">Active</span></td>
                                <td style="text-align:right;">
                                    <div style="display:inline-flex; gap:4px;">
                                        <a href="/Frontend/Admin/catalogue/subcategories/view.php?id=101" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                                        <a href="/Frontend/Admin/catalogue/subcategories/edit.php?id=101" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                                        <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('subcat-1', 'Kanjivaram Silk')" style="height:24px; padding:0 6px;">✕</button>
                                    </div>
                                </td>
                            </tr>
                            <tr id="subcat-2">
                                <td style="text-align:center;"><input type="checkbox" class="subcat-chk" value="102"></td>
                                <td><img src="/Frontend/Shop/Asset/images/product2.png" style="width:32px; height:32px; border-radius:4px; object-fit:cover;"></td>
                                <td><strong>Banarasi Brocade</strong></td>
                                <td><a href="/Frontend/Admin/catalogue/categories/view.php?id=1" style="color:#8A681F; font-weight:700; text-decoration:none;">Silk Sarees</a></td>
                                <td><strong>140 SKUs</strong></td>
                                <td>#2</td>
                                <td><span class="dt-badge green">Active</span></td>
                                <td style="text-align:right;">
                                    <div style="display:inline-flex; gap:4px;">
                                        <a href="/Frontend/Admin/catalogue/subcategories/view.php?id=102" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                                        <a href="/Frontend/Admin/catalogue/subcategories/edit.php?id=102" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                                        <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('subcat-2', 'Banarasi Brocade')" style="height:24px; padding:0 6px;">✕</button>
                                    </div>
                                </td>
                            </tr>
                            <tr id="subcat-3">
                                <td style="text-align:center;"><input type="checkbox" class="subcat-chk" value="103"></td>
                                <td><img src="/Frontend/Shop/Asset/images/product6.png" style="width:32px; height:32px; border-radius:4px; object-fit:cover;"></td>
                                <td><strong>Zardosi Velvet Lehengas</strong></td>
                                <td><a href="/Frontend/Admin/catalogue/categories/view.php?id=2" style="color:#8A681F; font-weight:700; text-decoration:none;">Bridal Lehengas</a></td>
                                <td><strong>120 SKUs</strong></td>
                                <td>#1</td>
                                <td><span class="dt-badge green">Active</span></td>
                                <td style="text-align:right;">
                                    <div style="display:inline-flex; gap:4px;">
                                        <a href="/Frontend/Admin/catalogue/subcategories/view.php?id=103" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                                        <a href="/Frontend/Admin/catalogue/subcategories/edit.php?id=103" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                                        <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('subcat-3', 'Zardosi Velvet Lehengas')" style="height:24px; padding:0 6px;">✕</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/Frontend/Admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
</body>
</html>
