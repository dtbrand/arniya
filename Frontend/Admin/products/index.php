<?php
/**
 * index.php — DT Brand's Products Management Master Suite
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Products Management";
$active_nav = "products";
$active_subnav = "";
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
                    <a href="/Frontend/Admin/products/imports/" class="adm-btn-secondary">📥 Import</a>
                    <a href="/Frontend/Admin/products/exports/" class="adm-btn-secondary" onclick="window.exportCurrentTable('dt_products_catalog'); return false;">📤 Export</a>
                    <a href="/Frontend/Admin/products/add.php" class="adm-btn-primary">+ Add Product</a>
                </div>
            </div>

            <!-- 2. Sub-Navigation Quick Access Strip (All 14 Sub-Suites) -->
            <div class="dt-prod-subnav-strip">
                <a href="/Frontend/Admin/products/" class="dt-prod-pill active">
                    <span>👗 All Products</span>
                    <span class="dt-prod-pill-badge">1,240</span>
                </a>
                <a href="/Frontend/Admin/products/add.php" class="dt-prod-pill">
                    <span>➕ Add Product</span>
                </a>
                <a href="/Frontend/Admin/products/categories/" class="dt-prod-pill">
                    <span>📁 Categories</span>
                    <span class="dt-prod-pill-badge">16</span>
                </a>
                <a href="/Frontend/Admin/products/subcategories/" class="dt-prod-pill">
                    <span>📂 Subcategories</span>
                    <span class="dt-prod-pill-badge">34</span>
                </a>
                <a href="/Frontend/Admin/products/brands/" class="dt-prod-pill">
                    <span>🏷️ Brands</span>
                    <span class="dt-prod-pill-badge">4</span>
                </a>
                <a href="/Frontend/Admin/products/attributes/" class="dt-prod-pill">
                    <span>🎨 Attributes</span>
                </a>
                <a href="/Frontend/Admin/products/variants/" class="dt-prod-pill">
                    <span>🔀 Variants Matrix</span>
                </a>
                <a href="/Frontend/Admin/products/media/" class="dt-prod-pill">
                    <span>🖼️ Media Gallery</span>
                </a>
                <a href="/Frontend/Admin/products/featured/" class="dt-prod-pill">
                    <span>⭐️ Featured</span>
                    <span class="dt-prod-pill-badge">48</span>
                </a>
                <a href="/Frontend/Admin/products/best-sellers/" class="dt-prod-pill">
                    <span>🔥 Best Sellers</span>
                    <span class="dt-prod-pill-badge">32</span>
                </a>
                <a href="/Frontend/Admin/products/new-arrivals/" class="dt-prod-pill">
                    <span>✨ New Arrivals</span>
                    <span class="dt-prod-pill-badge">64</span>
                </a>
                <a href="/Frontend/Admin/products/reviews/" class="dt-prod-pill">
                    <span>💬 Reviews</span>
                </a>
                <a href="/Frontend/Admin/products/imports/" class="dt-prod-pill">
                    <span>📥 Import Wizard</span>
                </a>
                <a href="/Frontend/Admin/products/exports/" class="dt-prod-pill">
                    <span>📤 Export Studio</span>
                </a>
            </div>

            <!-- 3. Product Summary Metric Cards (9 KPI Cards) -->
            <?php include_once __DIR__ . '/components/product-stats.php'; ?>

            <!-- 4. Master Product Table Card -->
            <div class="dt-table-card">
                <!-- Toolbar: Search & Action Buttons -->
                <div class="dt-toolbar">
                    <?php include_once __DIR__ . '/components/product-search.php'; ?>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <a href="/Frontend/Admin/products/categories/" class="adm-btn-secondary" style="font-size:0.75rem; height:34px;">📁 Categories</a>
                        <a href="/Frontend/Admin/products/attributes/" class="adm-btn-secondary" style="font-size:0.75rem; height:34px;">🎨 Attributes</a>
                        <button type="button" class="adm-btn-secondary" style="font-size:0.75rem; height:34px;" onclick="window.showToast('Column customizer ready!')">⚙️ Columns</button>
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
