<?php
/**
 * index.php — DT Brand's Products Management Master Suite
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Products Management";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/products.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/product-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <!-- 1. Header Section -->
            <div class="dt-prod-header">
                <div class="dt-prod-title-group">
                    <h1>
                        <span>Products</span>
                        <span class="adm-badge gold">1,240 SKUs</span>
                    </h1>
                    <p>Manage your DT Brand's product catalogue, stock levels, and multi-tier pricing.</p>
                </div>
                <div class="dt-prod-actions">
                    <a href="/Frontend/Admin/products/imports/" class="adm-btn-secondary">📥 Import Products</a>
                    <a href="/Frontend/Admin/products/exports/" class="adm-btn-secondary" onclick="window.exportCurrentTable('dt_products_catalog'); return false;">📤 Export CSV</a>
                    <a href="/Frontend/Admin/products/add.php" class="adm-btn-primary">+ Add Product</a>
                </div>
            </div>

            <!-- 2. Product Summary Metric Cards (9 Cards) -->
            <?php include_once __DIR__ . '/components/product-stats.php'; ?>

            <!-- 3. Master Product Table Card -->
            <div class="dt-table-card">
                <!-- Toolbar: Search & Action Buttons -->
                <div class="dt-toolbar">
                    <?php include_once __DIR__ . '/components/product-search.php'; ?>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <a href="/Frontend/Admin/products/categories/" class="adm-btn-secondary" style="font-size:0.75rem;">📁 Categories</a>
                        <a href="/Frontend/Admin/products/attributes/" class="adm-btn-secondary" style="font-size:0.75rem;">🎨 Attributes</a>
                        <button type="button" class="adm-btn-secondary" style="font-size:0.75rem;" onclick="window.showToast('Column customizer opened!')">⚙️ Columns</button>
                    </div>
                </div>

                <!-- Advanced Filters -->
                <?php include_once __DIR__ . '/components/product-filters.php'; ?>

                <!-- Bulk Actions Sticky Strip -->
                <?php include_once __DIR__ . '/components/bulk-actions.php'; ?>

                <!-- Product Data Table -->
                <?php include_once __DIR__ . '/components/product-table.php'; ?>

                <!-- Pagination -->
                <div class="dt-pagination">
                    <div class="dt-page-info">
                        Showing <strong>1 – 5</strong> of <strong>1,240</strong> products • Per page:
                        <select class="dt-filter-pill-select" style="height:28px; padding:0 8px; margin-left:6px;">
                            <option>10</option>
                            <option selected>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                    </div>
                    <div class="dt-page-nav">
                        <button type="button" class="dt-page-btn" disabled>«</button>
                        <button type="button" class="dt-page-btn active">1</button>
                        <button type="button" class="dt-page-btn">2</button>
                        <button type="button" class="dt-page-btn">3</button>
                        <button type="button" class="dt-page-btn">»</button>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/products/assets/js/products.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/products/assets/js/product-list.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/products/assets/js/bulk-actions.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/products/assets/js/filters.js?v=<?php echo time(); ?>"></script>
</body>
</html>
