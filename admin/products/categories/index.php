<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * categories/index.php — Product Categories
 * DT Brand's & Jai Hanuman Tex
 *
 * The list itself was real, but several columns were not:
 *   - The per-category Count came from categories.products_count, which the
 *     schema seeds with numbers like 840 and no write path ever updates, so a
 *     brand new empty category could show hundreds of products.
 *   - Every row showed "5007 (5%)" in an HSN (GST) column. `categories` has no
 *     hsn column; the value was typed into the markup, and the Add form's HSN
 *     box and Display Type / Parent Category selects were dropped server-side.
 *   - A missing photo fell back to /assets/images/product1.png, so categories
 *     with no image looked like they had one.
 *   - handleAddNewCategory() posted the <img> src (a stock path, or a base64
 *     data: URL after the never-wired "Upload Image" button) as `image`, and
 *     its .catch() toasted 'Category "X" created!' when the request had failed.
 *   - deleteCatRow() and the bulk delete removed the row from the table in
 *     .catch() and on any response, so a refusal ("products are still filed
 *     here") or a 401 still looked like a deletion until the page reloaded.
 *   - saveQuickEditCat() repainted the row first and reported success
 *     unconditionally afterwards.
 *   - A dead DOMContentLoaded handler bound a second search filter to
 *     '#the-list', an id this page does not have.
 *
 * Saving, deleting and uploading are now all handled by assets/js/categories.js.
 */
require_once __DIR__ . '/../../../src/ProductCatalog.php';
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$page_title = "Product Categories";
$active_nav = "products";
$active_subnav = "categories";

// Drafts count for the admin: this is a stock-room view, not the shop.
$allProducts = ProductCatalog::getAll(true);
$totalProductCount = count($allProducts);
$totalReadyStock = 0;
foreach ($allProducts as $p) {
    $totalReadyStock += (int)($p['stock_qty'] ?? 0);
}

// activeOnly = false: an inactive category must still be visible here, and the
// product counts come from the products table rather than products_count.
$dbCategories = ProductCatalog::getCategoriesWithDetails(false);
$totalCategoryCount = count($dbCategories);

$catInactiveCount = 0;
$catEmptyCount = 0;
$catNextOrder = 0;
foreach ($dbCategories as $c) {
    if (strtolower((string)($c['status'] ?? 'active')) !== 'active') { $catInactiveCount++; }
    if ((int)($c['products_count'] ?? 0) === 0) { $catEmptyCount++; }
    $catNextOrder = max($catNextOrder, (int)($c['display_order'] ?? 0));
}
$catNextOrder++;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Categories ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
    /* ── Compact & Auto-Sizing Layout Architecture ── */
    .dt-kpi-ribbon {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 12px;
    }
    @media (max-width: 1024px) {
        .dt-kpi-ribbon { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 600px) {
        .dt-kpi-ribbon { grid-template-columns: 1fr; }
    }
    .dt-kpi-card {
        background: #fff;
        border: 1px solid rgba(212,175,55,0.4);
        border-radius: 6px;
        padding: 8px 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        transition: all 0.2s ease;
    }
    .dt-kpi-card:hover {
        border-color: #D4AF37;
        box-shadow: 0 3px 10px rgba(212,175,55,0.15);
        transform: translateY(-1px);
    }
    .wp-cat-layout {
        display: grid;
        grid-template-columns: 280px minmax(0, 1fr);
        gap: 12px;
        align-items: start;
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
    }
    @media (max-width: 1024px) {
        .wp-cat-layout { grid-template-columns: 1fr; }
    }
    .dt-cat-form-card {
        background: #ffffff;
        border: 1px solid rgba(212,175,55,0.4);
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    .dt-cat-form-header {
        background: radial-gradient(ellipse at 20% 50%, rgba(212, 175, 55, 0.35) 0%, transparent 60%), linear-gradient(135deg, #261C0E 0%, #3A2C12 40%, #2A2010 75%, #18120A 100%);
        padding: 8px 12px;
        color: #FFFFFF;
        display: flex;
        align-items: center;
        gap: 6px;
        border-bottom: 2px solid #D4AF37;
    }
    .dt-cat-form-body {
        padding: 10px 12px;
    }
    .dt-form-group {
        margin-bottom: 8px;
    }
    .dt-form-group label {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #181512;
        margin-bottom: 2px;
    }
    .dt-form-group input, .dt-form-group select {
        width: 100%;
        height: 28px;
        padding: 0 8px;
        font-size: 11.5px;
        color: #181512;
        background: #ffffff;
        border: 1px solid #c3c4c7;
        border-radius: 4px;
        box-sizing: border-box;
        outline: none;
        transition: all 0.15s ease;
    }
    .dt-form-group textarea {
        width: 100%;
        height: 52px;
        padding: 6px 8px;
        font-size: 11.5px;
        color: #181512;
        background: #ffffff;
        border: 1px solid #c3c4c7;
        border-radius: 4px;
        box-sizing: border-box;
        resize: vertical;
    }
    .dt-form-group input:focus, .dt-form-group select:focus, .dt-form-group textarea:focus {
        border-color: #8A681F;
        box-shadow: 0 0 0 1px #8A681F, 0 0 6px rgba(212,175,55,0.25);
    }
    .wp-table-card {
        background: #fff;
        border: 1px solid #c3c4c7;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }
    .wp-table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .wp-list-table {
        width: 100%;
        min-width: 600px;
        border-collapse: collapse;
    }
    .wp-list-table th {
        background: #f6f7f7;
        font-size: 11.5px;
        font-weight: 700;
        color: #2c3338;
        border-bottom: 1px solid #c3c4c7;
        text-align: left;
    }
    .wp-list-table td {
        padding: 7px 8px;
        border-bottom: 1px solid #f0f0f1;
        font-size: 11.5px;
        vertical-align: middle;
    }
    .wp-list-table .wp-row-actions {
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.12s ease;
        font-size: 10.5px;
        color: #a7aaad;
        margin-top: 2px;
    }
    .wp-list-table tr:hover .wp-row-actions {
        visibility: visible;
        opacity: 1;
    }
    tr.inline-edit-row {
        background: #FAF5E8 !important;
    }
    tr.inline-edit-row td {
        padding: 10px 12px !important;
        border-top: 1.5px solid #D4AF37 !important;
        border-bottom: 1.5px solid #D4AF37 !important;
    }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 12px 16px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <!-- 1. Top Header Toolbar with Luxury Brand Gold Buttons -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px; margin-bottom:10px;">
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:18px; font-weight:800; color:#181512; margin:0;">Product Categories &amp; Taxonomies</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:10.5px; padding:2px 7px;"><?php echo $totalCategoryCount; ?> Categories</span>
                </div>

                <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                    <a href="/admin/products/" class="dt-btn-action-sm pale-gold" style="height:28px; padding:0 10px; font-size:11px;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Products (<?php echo $totalProductCount; ?>)</span>
                    </a>
                    <a href="/admin/products/attributes/" class="dt-btn-action-sm pale-gold" style="height:28px; padding:0 10px; font-size:11px;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path></svg>
                        <span>Attributes</span>
                    </a>
                    <a href="/admin/products/add.php" class="dt-btn-action-sm gold" style="height:28px; padding:0 12px; font-size:11px;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add Product</span>
                    </a>
                </div>
            </div>

            <!-- 2. B2B Wholesale & Taxonomy KPI Metrics Ribbon -->
            <div class="dt-kpi-ribbon">
                <div class="dt-kpi-card">
                    <div style="width:28px; height:28px; border-radius:5px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; flex-shrink:0;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    </div>
                    <div style="min-width:0;">
                        <div style="font-size:9.5px; color:#646970; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">ACTIVE CATEGORIES</div>
                        <div style="font-size:14px; font-weight:800; color:#181512; line-height:1.2;"><?php echo $totalCategoryCount; ?> Categories</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:28px; height:28px; border-radius:5px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D; flex-shrink:0;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <div style="min-width:0;">
                        <div style="font-size:9.5px; color:#646970; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">ASSIGNED SKUS</div>
                        <div style="font-size:14px; font-weight:800; color:#15803D; line-height:1.2;"><?php echo $totalProductCount; ?> Products</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:28px; height:28px; border-radius:5px; background:#EFF6FF; border:1px solid #93C5FD; display:flex; align-items:center; justify-content:center; color:#1D4ED8; flex-shrink:0;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    </div>
                    <div style="min-width:0;">
                        <div style="font-size:9.5px; color:#646970; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">EMPTY / HIDDEN</div>
                        <div style="font-size:14px; font-weight:800; color:#1D4ED8; line-height:1.2;"><?php echo $catEmptyCount; ?> empty &middot; <?php echo $catInactiveCount; ?> hidden</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:28px; height:28px; border-radius:5px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309; flex-shrink:0;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                    </div>
                    <div style="min-width:0;">
                        <div style="font-size:9.5px; color:#646970; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">READY STOCK</div>
                        <div style="font-size:14px; font-weight:800; color:#B45309; line-height:1.2;"><?php echo number_format($totalReadyStock); ?> Units</div>
                    </div>
                </div>
            </div>

            <!-- 3. Dual Column Layout: Add Category Form (Left) & Categories List Table (Right) -->
            <div class="wp-cat-layout">
                
                <!-- LEFT: Add New Category Form Card -->
                <div class="dt-cat-form-card">
                    <div class="dt-cat-form-header">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#D4AF37" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <h2 style="margin:0; font-size:12.5px; font-weight:800; color:#FAF5E8;">Add New Category</h2>
                    </div>
                    <div class="dt-cat-form-body">
                        <input type="hidden" id="catMode" value="create">
                        <input type="hidden" id="catId" value="0">
                        <div class="dt-form-group">
                            <label for="catName">Name <span style="color:#b32d2e;">*</span></label>
                            <input type="text" id="catName" placeholder="e.g. Pure Silk Sarees" autocomplete="off">
                        </div>

                        <div class="dt-form-group">
                            <label for="catSlug">Slug</label>
                            <input type="text" id="catSlug" placeholder="pure-silk-sarees" autocomplete="off">
                            <div style="font-size:10.5px; color:#8A681F; margin-top:2px;">/shop?category=<b id="catSlugLive">...</b></div>
                        </div>

                        <div class="dt-form-group">
                            <label for="catDesc">Description</label>
                            <textarea id="catDesc" placeholder="Shown on the shop catalogue header for this category."></textarea>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                            <div class="dt-form-group">
                                <label for="catStatus">Status</label>
                                <select id="catStatus">
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Hidden</option>
                                </select>
                            </div>
                            <div class="dt-form-group">
                                <label for="catOrder">Order</label>
                                <input type="number" id="catOrder" min="0" step="1" value="<?php echo (int)$catNextOrder; ?>">
                            </div>
                        </div>

                        <div class="dt-form-group">
                            <label for="catImageFile">Thumbnail</label>
                            <img id="catImagePreview" src="" alt="" style="display:none; width:56px; height:56px; object-fit:cover; border-radius:4px; border:1px solid #D4AF37; margin-bottom:6px;">
                            <input type="file" id="catImageFile" accept="image/jpeg,image/png,image/webp,image/gif" style="height:auto; padding:4px; font-size:10.5px;">
                            <input type="hidden" id="catImage" value="">
                            <small id="catImagePreviewNote" style="font-size:10px; color:#646970; word-break:break-all; display:block;">Uploaded to the server as soon as you pick it.</small>
                        </div>

                        <div style="margin-top:10px;">
                            <button type="button" class="dt-btn-action-sm gold" data-dt-cat-save onclick="saveCategory()" style="width:100%; height:30px; justify-content:center; font-size:11.5px;">
                                <span>Add New Category</span>
                            </button>
                        </div>
                        <small style="font-size:10px; color:#646970; display:block; margin-top:8px;">Parent category, display type and an HSN/GST class have no columns in the categories table, so those boxes were removed. GST is applied at 5% on the order, not per category.</small>
                    </div>
                </div>

                <!-- RIGHT: Categories Taxonomy Table Card -->
                <div class="wp-table-card">
                    
                    <!-- Table Top Toolbar with Clean Search & Filter -->
                    <div style="padding:8px 12px; background:#f6f7f7; border-bottom:1px solid #c3c4c7; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                        <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                            <select class="wp-select" id="catBulkActionSelect" style="height:28px; font-size:11.5px; min-width:110px; border-radius:4px; border:1px solid #c3c4c7; padding:0 6px;">
                                <option value="">Bulk actions</option>
                                <option value="delete">Delete Selected</option>
                            </select>
                            <button type="button" class="dt-btn-action-sm pale-gold" onclick="handleCatBulkAction()" style="height:28px; font-size:11px; padding:0 10px;">Apply</button>

                            <select class="wp-select" id="catStatusFilter" onchange="filterCatByStatus(this.value)" style="height:28px; font-size:11.5px; min-width:125px; border-radius:4px; border:1px solid #c3c4c7; padding:0 6px;">
                                <option value="">All statuses</option>
                                <option value="active">Active only</option>
                                <option value="inactive">Hidden only</option>
                                <option value="empty">Empty only</option>
                            </select>
                        </div>

                        <div class="wp-search-box" style="display:flex; align-items:center; gap:5px;">
                            <div style="position:relative; display:inline-flex; align-items:center;">
                                <input type="text" id="catSearchInput" class="wp-search-input" placeholder="Search categories..." style="height:28px; padding-left:10px; padding-right:20px; width:180px; font-size:11.5px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchWpCategories(this.value); toggleCatSearchClearBtn(this.value)">
                                <span id="catSearchClearBtn" onclick="clearCatSearch()" style="position:absolute; right:6px; cursor:pointer; color:#8c8f94; font-size:11px; font-weight:700; display:none;" title="Clear search">✕</span>
                            </div>
                            <button type="button" class="dt-btn-action-sm gold" onclick="searchWpCategories(document.getElementById('catSearchInput').value)" style="height:28px; font-size:11px; padding:0 10px;">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <span>Search</span>
                            </button>
                        </div>
                    </div>

                    <div class="wp-table-responsive">
                        <table class="wp-list-table" id="categoriesTable">
                            <thead>
                                <tr>
                                    <th style="width:30px; text-align:center; padding:7px 6px;">
                                        <input type="checkbox" onchange="toggleSelectAllCats(this)" style="cursor:pointer; width:14px; height:14px;">
                                    </th>
                                    <th style="width:42px; padding:7px 6px;">Image</th>
                                    <th style="padding:7px 10px;">Name &amp; Actions</th>
                                    <th style="padding:7px 8px;">Description</th>
                                    <th style="padding:7px 8px;">Slug</th>
                                    <th style="padding:7px 8px;">Status</th>
                                    <th style="text-align:right; width:65px; padding:7px 10px;">Products</th>
                                </tr>
                            </thead>
                            <tbody id="categoriesTableBody">
                                <?php if (empty($dbCategories)): ?>
                                    <tr>
                                        <td colspan="7" style="text-align:center; padding:30px 10px; color:#64748B;">
                                            No categories found. Use the form on the left to add your first category.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($dbCategories as $cat):
                                        $catId = (int)($cat['id'] ?? 0);
                                        $catRowName = (string)($cat['name'] ?? '');
                                        $catRowSlug = (string)($cat['slug'] ?? '');
                                        $catRowDesc = trim((string)($cat['description'] ?? ''));
                                        $catHasImg = !empty($cat['has_image']);
                                        $catRowImg = $catHasImg ? (string)$cat['image'] : '';
                                        $catRowCount = (int)($cat['products_count'] ?? 0);
                                        $catRowStatus = strtolower(trim((string)($cat['status'] ?? 'active'))) === 'inactive' ? 'inactive' : 'active';
                                    ?>
                                    <tr id="cat-row-<?= $catId ?>" data-cat-status="<?= $catRowStatus ?>" data-cat-count="<?= $catRowCount ?>" data-cat-name="<?= htmlspecialchars($catRowName, ENT_QUOTES) ?>" data-cat-slug="<?= htmlspecialchars($catRowSlug, ENT_QUOTES) ?>" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                                        <td style="text-align:center; padding:7px 6px;">
                                            <input type="checkbox" class="cat-row-check" value="<?= $catId ?>" style="cursor:pointer; width:14px; height:14px;">
                                        </td>
                                        <td style="padding:7px 6px;">
                                            <?php if ($catHasImg): ?>
                                                <img src="<?= htmlspecialchars($catRowImg) ?>" alt="" style="width:32px; height:32px; object-fit:cover; border-radius:3px; border:1px solid #e2e8f0; display:block;">
                                            <?php else: ?>
                                                <span title="No image set" style="width:32px; height:32px; border-radius:3px; border:1px dashed #c3c4c7; display:flex; align-items:center; justify-content:center; font-size:9px; color:#a7aaad;">none</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="padding:7px 10px;">
                                            <strong style="font-size:12.5px; color:#181512;"><a href="/admin/products/categories/edit.php?id=<?= $catId ?>" style="color:#181512; text-decoration:none;"><?= htmlspecialchars($catRowName) ?></a></strong>
                                            <div class="wp-row-actions">
                                                <a href="/admin/products/categories/edit.php?id=<?= $catId ?>" style="color:#8A681F; font-weight:700; text-decoration:none;">Edit</a> <span style="color:#c3c4c7;">|</span>
                                                <a href="#" onclick="openQuickEditCat(<?= $catId ?>); return false;" style="color:#1D4ED8; font-weight:600; text-decoration:none;">Quick Edit</a> <span style="color:#c3c4c7;">|</span>
                                                <a href="#" onclick="dtCatDelete(<?= $catId ?>); return false;" style="color:#DC2626; text-decoration:none;">Delete</a> <span style="color:#c3c4c7;">|</span>
                                                <a href="/shop?category=<?= urlencode($catRowSlug) ?>" target="_blank" rel="noopener" style="color:#15803D; font-weight:600; text-decoration:none;">View on shop</a>
                                            </div>
                                        </td>
                                        <td style="padding:7px 8px; font-size:11.5px; color:#646970; max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= $catRowDesc !== '' ? htmlspecialchars($catRowDesc) : '<span style="color:#a7aaad;">No description</span>' ?></td>
                                        <td style="padding:7px 8px;"><code style="background:#FAF5E8; color:#8A681F; padding:1px 5px; border-radius:3px; font-size:11px; font-weight:600;"><?= htmlspecialchars($catRowSlug) ?></code></td>
                                        <td style="padding:7px 8px;">
                                            <?php if ($catRowStatus === 'active'): ?>
                                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-size:10px; padding:1px 5px; font-weight:700;">Active</span>
                                            <?php else: ?>
                                                <span class="adm-badge" style="background:#F3F4F6; color:#646970; font-size:10px; padding:1px 5px; font-weight:700;">Hidden</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align:right; padding:7px 10px;">
                                            <span class="adm-badge" style="background:<?= $catRowCount > 0 ? '#DCFCE7' : '#F3F4F6' ?>; color:<?= $catRowCount > 0 ? '#15803D' : '#646970' ?>; font-weight:800; font-size:11px; padding:1.5px 6px; border-radius:8px;"><?= $catRowCount ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </main>
        <?php include_once __DIR__ . '/../../includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
<script src="/admin/products/assets/js/categories.js?v=<?php echo time(); ?>"></script>
<script>
function dtCatToast(msg) {
    if (typeof window.showToast === 'function') { window.showToast(msg); } else { alert(msg); }
}

function toggleCatSearchClearBtn(val) {
    var btn = document.getElementById('catSearchClearBtn');
    if (btn) { btn.style.display = (val && val.length > 0) ? 'inline' : 'none'; }
}

function clearCatSearch() {
    var input = document.getElementById('catSearchInput');
    if (!input) { return; }
    input.value = '';
    toggleCatSearchClearBtn('');
    searchWpCategories('');
    input.focus();
}

function toggleSelectAllCats(master) {
    var checks = document.querySelectorAll('.cat-row-check');
    for (var i = 0; i < checks.length; i++) { checks[i].checked = master.checked; }
}

function dtCatRows() {
    return document.querySelectorAll('#categoriesTableBody tr[id^="cat-row-"]');
}

function searchWpCategories(q) {
    var term = String(q || '').toLowerCase().trim();
    var rows = dtCatRows();
    for (var i = 0; i < rows.length; i++) {
        rows[i].style.display = rows[i].textContent.toLowerCase().indexOf(term) !== -1 ? '' : 'none';
    }
}

/** Status filter on real row data, not on a text match against the whole row. */
function filterCatByStatus(mode) {
    var rows = dtCatRows();
    for (var i = 0; i < rows.length; i++) {
        var r = rows[i];
        var show = true;
        if (mode === 'active' || mode === 'inactive') {
            show = (r.getAttribute('data-cat-status') === mode);
        } else if (mode === 'empty') {
            show = (parseInt(r.getAttribute('data-cat-count'), 10) || 0) === 0;
        }
        r.style.display = show ? '' : 'none';
    }
}

/**
 * Quick edit: name, slug and status only, because those are the columns this
 * row shows. The row is repainted from the server's response, after it confirms
 * the update — it used to be repainted first and reported saved regardless.
 */
function openQuickEditCat(id) {
    var row = document.getElementById('cat-row-' + id);
    if (!row) { return; }
    var next = row.nextElementSibling;
    if (next && next.classList.contains('inline-edit-row')) { next.remove(); return; }

    var name = row.getAttribute('data-cat-name') || '';
    var slug = row.getAttribute('data-cat-slug') || '';
    var status = row.getAttribute('data-cat-status') || 'active';

    var tr = document.createElement('tr');
    tr.className = 'inline-edit-row';
    var td = document.createElement('td');
    td.colSpan = 7;
    td.innerHTML =
        '<div style="display:grid; grid-template-columns:1fr 1fr 120px auto; gap:8px; align-items:flex-end; padding:10px 14px;">'
        + '<div><label style="font-size:10.5px; font-weight:700; display:block; margin-bottom:2px;">Category Name</label>'
        + '<input type="text" id="qe-name-' + id + '" style="height:28px; width:100%; font-size:11.5px; padding:0 8px; border:1px solid #8A681F; border-radius:4px; box-sizing:border-box;"></div>'
        + '<div><label style="font-size:10.5px; font-weight:700; display:block; margin-bottom:2px;">URL Slug</label>'
        + '<input type="text" id="qe-slug-' + id + '" style="height:28px; width:100%; font-size:11.5px; padding:0 8px; border:1px solid #8A681F; border-radius:4px; box-sizing:border-box;"></div>'
        + '<div><label style="font-size:10.5px; font-weight:700; display:block; margin-bottom:2px;">Status</label>'
        + '<select id="qe-status-' + id + '" style="height:28px; width:100%; font-size:11.5px; border:1px solid #8A681F; border-radius:4px;">'
        + '<option value="active">Active</option><option value="inactive">Hidden</option></select></div>'
        + '<div style="display:flex; gap:5px;">'
        + '<button type="button" class="dt-btn-action-sm gold" id="qe-save-' + id + '" style="height:28px; font-size:11px; padding:0 12px; font-weight:700;">Update</button>'
        + '<button type="button" class="dt-btn-action-sm" id="qe-cancel-' + id + '" style="height:28px; font-size:11px; padding:0 10px; background:#f6f7f7; border:1px solid #c3c4c7; color:#3B352E;">Cancel</button>'
        + '</div></div>';
    tr.appendChild(td);
    row.after(tr);

    // Values are set as properties, never interpolated into HTML, so a quote or
    // an angle bracket in a category name cannot break out of the markup.
    document.getElementById('qe-name-' + id).value = name;
    document.getElementById('qe-slug-' + id).value = slug;
    document.getElementById('qe-status-' + id).value = (status === 'inactive') ? 'inactive' : 'active';
    document.getElementById('qe-cancel-' + id).addEventListener('click', function () { tr.remove(); });
    document.getElementById('qe-save-' + id).addEventListener('click', function () { saveQuickEditCat(id); });
}

function saveQuickEditCat(id) {
    var nameEl = document.getElementById('qe-name-' + id);
    var slugEl = document.getElementById('qe-slug-' + id);
    var statusEl = document.getElementById('qe-status-' + id);
    var saveBtn = document.getElementById('qe-save-' + id);
    var row = document.getElementById('cat-row-' + id);
    if (!nameEl || !row) { return; }

    var name = String(nameEl.value || '').trim();
    if (!name) { dtCatToast('Enter the category name.'); nameEl.focus(); return; }
    if (typeof window.dtCatPost !== 'function') {
        dtCatToast('The category script did not load, so nothing was saved. Reload the page.');
        return;
    }

    var status = statusEl ? statusEl.value : 'active';
    if (saveBtn) { saveBtn.disabled = true; }

    window.dtCatPost({
        action: 'update',
        id: id,
        name: name,
        slug: String(slugEl ? slugEl.value : '').trim(),
        status: status
    }).then(function (res) {
        dtCatToast(res.message || 'Category updated.');
        // Renaming re-labels products and can change counts, so the list is
        // reloaded from the database rather than patched in place.
        setTimeout(function () { window.location.reload(); }, 700);
    }).catch(function (err) {
        if (saveBtn) { saveBtn.disabled = false; }
        dtCatToast(err && err.message ? err.message : 'The category was not updated.');
    });
}

/**
 * Bulk delete. The API keeps any category that still holds products and returns
 * both counts, so the page reloads from the database instead of removing the
 * checked rows optimistically — the old version removed them even from .catch().
 */
function handleCatBulkAction() {
    var sel = document.getElementById('catBulkActionSelect');
    var action = sel ? sel.value : '';
    if (!action) { dtCatToast('Choose a bulk action first.'); return; }

    var checked = document.querySelectorAll('.cat-row-check:checked');
    if (checked.length === 0) { dtCatToast('Select at least one category.'); return; }

    var ids = [];
    for (var i = 0; i < checked.length; i++) { ids.push(parseInt(checked[i].value, 10) || 0); }

    if (action !== 'delete') { dtCatToast('"' + action + '" is not a bulk action this page supports.'); return; }
    if (!window.confirm('Delete ' + ids.length + ' categor' + (ids.length === 1 ? 'y' : 'ies') + '? Any that still hold products will be kept.')) { return; }
    if (typeof window.dtCatPost !== 'function') {
        dtCatToast('The category script did not load, so nothing was deleted. Reload the page.');
        return;
    }

    window.dtCatPost({ action: 'bulk_delete', ids: ids }).then(function (res) {
        dtCatToast(res.message || 'Done.');
        setTimeout(function () { window.location.reload(); }, 900);
    }).catch(function (err) {
        dtCatToast(err && err.message ? err.message : 'No categories were deleted.');
    });
}
</script>
</body>
</html>
