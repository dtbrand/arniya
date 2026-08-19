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
                    <a href="/Frontend/Admin/products/imports/" class="adm-btn-secondary">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Import</span>
                    </a>
                    <a href="/Frontend/Admin/products/exports/" class="adm-btn-secondary" onclick="window.exportCurrentTable('dt_products_catalog'); return false;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        <span>Export</span>
                    </a>
                    <a href="/Frontend/Admin/products/add.php" class="adm-btn-primary">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add Product</span>
                    </a>
                </div>
            </div>

            <!-- 2. Sub-Navigation Quick Access Strip (Real SVG Vector Icons) -->
            <div class="dt-prod-subnav-strip">
                <a href="/Frontend/Admin/products/" class="dt-prod-pill active">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span>All Products</span>
                    <span class="dt-prod-pill-badge">1,240</span>
                </a>
                <a href="/Frontend/Admin/products/add.php" class="dt-prod-pill">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Add Product</span>
                </a>
                <a href="/Frontend/Admin/products/categories/" class="dt-prod-pill">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                    <span>Categories</span>
                    <span class="dt-prod-pill-badge">16</span>
                </a>
                <a href="/Frontend/Admin/products/subcategories/" class="dt-prod-pill">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"></path></svg>
                    <span>Subcategories</span>
                    <span class="dt-prod-pill-badge">34</span>
                </a>
                <a href="/Frontend/Admin/products/brands/" class="dt-prod-pill">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><circle cx="7.5" cy="7.5" r="1.5"></circle></svg>
                    <span>Brands</span>
                    <span class="dt-prod-pill-badge">4</span>
                </a>
                <a href="/Frontend/Admin/products/attributes/" class="dt-prod-pill">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path></svg>
                    <span>Attributes</span>
                </a>
                <a href="/Frontend/Admin/products/variants/" class="dt-prod-pill">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 3 21 3 21 8"></polyline><line x1="4" y1="20" x2="21" y2="3"></line><polyline points="21 16 21 21 16 21"></polyline><line x1="15" y1="15" x2="21" y2="21"></line></svg>
                    <span>Variants Matrix</span>
                </a>
                <a href="/Frontend/Admin/products/media/" class="dt-prod-pill">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    <span>Media</span>
                </a>
                <a href="/Frontend/Admin/products/featured/" class="dt-prod-pill">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    <span>Featured</span>
                    <span class="dt-prod-pill-badge">48</span>
                </a>
                <a href="/Frontend/Admin/products/best-sellers/" class="dt-prod-pill">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
                    <span>Best Sellers</span>
                    <span class="dt-prod-pill-badge">32</span>
                </a>
                <a href="/Frontend/Admin/products/new-arrivals/" class="dt-prod-pill">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15 8 21 9 17 14 18 20 12 17 6 20 7 14 3 9 9 8 12 2"></polygon></svg>
                    <span>New Arrivals</span>
                    <span class="dt-prod-pill-badge">64</span>
                </a>
                <a href="/Frontend/Admin/products/reviews/" class="dt-prod-pill">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    <span>Reviews</span>
                </a>
                <a href="/Frontend/Admin/products/imports/" class="dt-prod-pill">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Import Wizard</span>
                </a>
                <a href="/Frontend/Admin/products/exports/" class="dt-prod-pill">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    <span>Export Studio</span>
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
                        <a href="/Frontend/Admin/products/categories/" class="adm-btn-secondary" style="font-size:0.75rem; height:36px; padding:0 12px;">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                            <span>Categories</span>
                        </a>
                        <a href="/Frontend/Admin/products/attributes/" class="adm-btn-secondary" style="font-size:0.75rem; height:36px; padding:0 12px;">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path></svg>
                            <span>Attributes</span>
                        </a>
                        <button type="button" class="adm-btn-secondary" style="font-size:0.75rem; height:36px; padding:0 12px;" onclick="window.showToast('Column customizer ready!')">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                            <span>Columns</span>
                        </button>
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
