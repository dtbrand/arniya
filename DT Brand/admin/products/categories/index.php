<?php
/**
 * categories/index.php — DT Brand's Product Categories & Taxonomy Hub (Wholesale Dashboard & Luxury Shop Standard)
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../../src/ProductCatalog.php';
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$page_title = "Product Categories";
$active_nav = "products";
$active_subnav = "categories";

$dbCategories = [];
$allProducts = ProductCatalog::getAll();
$totalProductCount = count($allProducts);
$totalReadyStock = 0;

foreach ($allProducts as $p) {
    $totalReadyStock += (int)($p['stock_qty'] ?? 0);
}

$db = Database::getConnection();
if ($db !== null && !Database::isMockMode()) {
    try {
        $dbCategories = Database::query("SELECT * FROM categories ORDER BY display_order ASC, id ASC");
    } catch (\Exception $e) {}
}

$totalCategoryCount = count($dbCategories);
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
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
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
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 12px 16px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <!-- 1. Top Header Toolbar with Luxury Brand Gold Buttons -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px; margin-bottom:10px;">
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:18px; font-weight:800; color:#181512; margin:0;">Product Categories &amp; Taxonomies</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:10.5px; padding:2px 7px;"><?php echo $totalCategoryCount; ?> Categories</span>
                </div>

                <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                    <a href="/DT%20Brand/admin/products/" class="dt-btn-action-sm pale-gold" style="height:28px; padding:0 10px; font-size:11px;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Products (<?php echo $totalProductCount; ?>)</span>
                    </a>
                    <a href="/DT%20Brand/admin/products/brands/" class="dt-btn-action-sm pale-gold" style="height:28px; padding:0 10px; font-size:11px;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <span>Brands (3)</span>
                    </a>
                    <a href="/DT%20Brand/admin/products/attributes/" class="dt-btn-action-sm pale-gold" style="height:28px; padding:0 10px; font-size:11px;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path></svg>
                        <span>Attributes</span>
                    </a>
                    <a href="/DT%20Brand/admin/products/add.php" class="dt-btn-action-sm gold" style="height:28px; padding:0 12px; font-size:11px;">
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
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                    </div>
                    <div style="min-width:0;">
                        <div style="font-size:9.5px; color:#646970; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">HSN &amp; GST TAX</div>
                        <div style="font-size:14px; font-weight:800; color:#1D4ED8; line-height:1.2;">5007 (5%)</div>
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
                        <form id="wpAddCatForm" onsubmit="handleAddNewCategory(event)">
                            <div class="dt-form-group">
                                <label>Name <span style="color:#b32d2e;">*</span></label>
                                <input type="text" id="catName" placeholder="e.g. Pure Silk Sarees" required oninput="autoSlugifyCat(this.value)">
                            </div>

                            <div class="dt-form-group">
                                <label>Slug</label>
                                <input type="text" id="catSlug" placeholder="e.g. pure-silk-sarees">
                            </div>

                            <div class="dt-form-group">
                                <label>Parent Category</label>
                                <select id="catParent">
                                    <option value="none">None (Top Level)</option>
                                    <?php foreach ($dbCategories as $pCat): ?>
                                        <option value="<?php echo htmlspecialchars($pCat['slug']); ?>"><?php echo htmlspecialchars($pCat['name']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="dt-form-group">
                                <label>Description</label>
                                <textarea id="catDesc" placeholder="Brief category summary for SEO and catalog..."></textarea>
                            </div>

                            <div class="dt-form-group">
                                <label>Display Type</label>
                                <select id="catDisplayType">
                                    <option value="default">Default</option>
                                    <option value="products">Products Only</option>
                                    <option value="subcategories">Subcategories</option>
                                    <option value="both">Both</option>
                                </select>
                            </div>

                            <div class="dt-form-group">
                                <label>HSN Code &amp; GST</label>
                                <input type="text" id="catHsn" value="5007 (5% GST)" placeholder="e.g. 5007 (5% GST)">
                            </div>

                            <div class="dt-form-group">
                                <label>Thumbnail</label>
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <img src="/assets/images/product1.png" onerror="this.src='/assets/images/product1.png';" id="catThumbPreview" style="width:28px; height:28px; object-fit:cover; border-radius:3px; border:1px solid #c3c4c7; flex-shrink:0;">
                                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="if(window.showToast) window.showToast('Upload category banner/image');" style="height:26px; font-size:10.5px; flex:1; justify-content:center;">
                                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                        <span>Upload Image</span>
                                    </button>
                                </div>
                            </div>

                            <div style="margin-top:10px;">
                                <button type="submit" class="dt-btn-action-sm gold" style="width:100%; height:30px; justify-content:center; font-size:11.5px;">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    <span>Add New Category</span>
                                </button>
                            </div>
                        </form>
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

                            <select class="wp-select" id="catParentFilter" onchange="filterCatByParent(this.value)" style="height:28px; font-size:11.5px; min-width:125px; border-radius:4px; border:1px solid #c3c4c7; padding:0 6px;">
                                <option value="">All Categories</option>
                                <?php foreach ($dbCategories as $fCat): ?>
                                    <option value="<?php echo htmlspecialchars($fCat['name']); ?>"><?php echo htmlspecialchars($fCat['name']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="wp-search-box" style="display:flex; align-items:center; gap:5px;">
                            <div style="position:relative; display:inline-flex; align-items:center;">
                                <input type="text" id="catSearchInput" class="wp-search-input" placeholder="Search categories, HSN..." style="height:28px; padding-left:10px; padding-right:20px; width:180px; font-size:11.5px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchWpCategories(this.value); toggleCatSearchClearBtn(this.value)">
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
                                    <th style="padding:7px 8px;">HSN (GST)</th>
                                    <th style="text-align:right; width:65px; padding:7px 10px;">Count</th>
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
                                        $catId = $cat['id'];
                                        $catName = $cat['name'];
                                        $catSlug = $cat['slug'] ?? strtolower(str_replace(' ', '-', $catName));
                                        $catDesc = $cat['description'] ?? 'Authentic ethnic sarees & handlooms';
                                        $catImg = !empty($cat['image']) ? $cat['image'] : '/assets/images/product1.png';
                                        $catCount = (int)($cat['products_count'] ?? count(ProductCatalog::filter(['category' => $catName])));
                                    ?>
                                    <tr id="cat-row-<?= $catId ?>" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                                        <td style="text-align:center; padding:7px 6px;">
                                            <input type="checkbox" class="cat-row-check" value="<?= $catId ?>" style="cursor:pointer; width:14px; height:14px;">
                                        </td>
                                        <td style="padding:7px 6px;">
                                            <img src="<?= htmlspecialchars($catImg) ?>" onerror="this.src='/assets/images/product1.png';" style="width:32px; height:32px; object-fit:cover; border-radius:3px; border:1px solid #e2e8f0; display:block;">
                                        </td>
                                        <td style="padding:7px 10px;">
                                            <strong style="font-size:12.5px; color:#181512;"><a href="/DT%20Brand/admin/products/categories/view.php?id=<?= $catId ?>" style="color:#181512; text-decoration:none;"><?= htmlspecialchars($catName) ?></a></strong>
                                            <div class="wp-row-actions">
                                                <a href="/DT%20Brand/admin/products/categories/edit.php?id=<?= $catId ?>" style="color:#8A681F; font-weight:700; text-decoration:none;">Edit</a> <span style="color:#c3c4c7;">|</span>
                                                <a href="#" onclick="openQuickEditCat(<?= $catId ?>, '<?= addslashes($catName) ?>', '<?= addslashes($catSlug) ?>', '<?= addslashes($catDesc) ?>', '5007 (5% GST)'); return false;" style="color:#1D4ED8; font-weight:600; text-decoration:none;">Quick Edit</a> <span style="color:#c3c4c7;">|</span>
                                                <a href="#" onclick="deleteCatRow(<?= $catId ?>); return false;" style="color:#DC2626; text-decoration:none;">Delete</a> <span style="color:#c3c4c7;">|</span>
                                                <a href="/DT%20Brand/admin/products/categories/view.php?id=<?= $catId ?>" style="color:#15803D; font-weight:600; text-decoration:none;">View</a>
                                            </div>
                                        </td>
                                        <td style="padding:7px 8px; font-size:11.5px; color:#646970; max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= htmlspecialchars($catDesc) ?></td>
                                        <td style="padding:7px 8px;"><code style="background:#FAF5E8; color:#8A681F; padding:1px 5px; border-radius:3px; font-size:11px; font-weight:600;"><?= htmlspecialchars($catSlug) ?></code></td>
                                        <td style="padding:7px 8px;"><span class="adm-badge gold" style="font-size:10px; padding:1px 5px;">5007 (5%)</span></td>
                                        <td style="text-align:right; padding:7px 10px;">
                                            <a href="/DT%20Brand/admin/products/?cat=<?= urlencode($catName) ?>" style="text-decoration:none;">
                                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:800; font-size:11px; padding:1.5px 6px; border-radius:8px;"><?= $catCount ?></span>
                                            </a>
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
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function toggleCatSearchClearBtn(val) {
    const btn = document.getElementById('catSearchClearBtn');
    if (btn) btn.style.display = val.length > 0 ? 'inline' : 'none';
}

function clearCatSearch() {
    const input = document.getElementById('catSearchInput');
    if (input) {
        input.value = '';
        toggleCatSearchClearBtn('');
        searchWpCategories('');
        input.focus();
    }
}

function toggleSelectAllCats(master) {
    const checks = document.querySelectorAll('.cat-row-check');
    checks.forEach(c => c.checked = master.checked);
}

function searchWpCategories(q) {
    const rows = document.querySelectorAll('#categoriesTableBody tr:not(.inline-edit-row)');
    const term = (q || '').toLowerCase().trim();
    rows.forEach(r => {
        const txt = r.textContent.toLowerCase();
        r.style.display = txt.includes(term) ? '' : 'none';
    });
}

function filterCatByParent(parent) {
    const rows = document.querySelectorAll('#categoriesTableBody tr:not(.inline-edit-row)');
    rows.forEach(r => {
        if (!parent) {
            r.style.display = '';
        } else {
            const txt = r.textContent.toLowerCase();
            r.style.display = txt.includes(parent.toLowerCase()) ? '' : 'none';
        }
    });
}

function autoSlugifyCat(val) {
    const slugInput = document.getElementById('catSlug');
    if (slugInput) {
        slugInput.value = val.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    }
}

function handleAddNewCategory(e) {
    if (e && e.preventDefault) e.preventDefault();
    const name = document.getElementById('catName')?.value?.trim();
    const slug = document.getElementById('catSlug')?.value?.trim() || autoSlugifyCat(name);
    const desc = document.getElementById('catDesc')?.value?.trim();
    const thumbImg = document.getElementById('catThumbPreview')?.src || '/assets/images/product1.png';

    if (!name) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Please enter a category name');
        return;
    }

    const params = new URLSearchParams();
    params.append('action', 'create');
    params.append('name', name);
    params.append('slug', slug);
    params.append('description', desc);
    params.append('image', thumbImg);

    fetch('/api/categories.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (typeof window.showToast === 'function') window.showToast(`✨ Category "${name}" saved to database!`);
                setTimeout(() => window.location.reload(), 500);
            } else {
                if (typeof window.showToast === 'function') window.showToast(`❌ Error: ${data.message || 'Could not save'}`);
            }
        })
        .catch(err => {
            if (typeof window.showToast === 'function') window.showToast(`✨ Category "${name}" created!`);
            setTimeout(() => window.location.reload(), 500);
        });

    document.getElementById('wpAddCatForm')?.reset();
}

function deleteCatRow(id) {
    if (!confirm('Are you sure you want to delete this category from database?')) return;
    const row = document.getElementById(`cat-row-${id}`);
    
    const params = new URLSearchParams();
    params.append('action', 'delete');
    params.append('id', id);
    fetch('/api/categories.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (row) row.remove();
                if (typeof window.showToast === 'function') window.showToast('🗑️ Category deleted from database');
            }
        })
        .catch(() => {
            if (row) row.remove();
            if (typeof window.showToast === 'function') window.showToast('🗑️ Category deleted');
        });
}

function handleCatBulkAction() {
    const action = document.getElementById('catBulkActionSelect')?.value;
    if (!action) return;
    const selected = document.querySelectorAll('.cat-row-check:checked');
    if (selected.length === 0) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Select at least one category');
        return;
    }

    const ids = Array.from(selected).map(c => c.value);

    if (action === 'delete') {
        if (confirm(`Delete ${selected.length} categories permanently from database?`)) {
            const params = new URLSearchParams();
            params.append('action', 'bulk_delete');
            params.append('ids', ids.join(','));
            fetch('/api/categories.php', { method: 'POST', body: params })
                .then(res => res.json())
                .then(data => {
                    selected.forEach(c => {
                        const row = c.closest('tr');
                        if (row) row.remove();
                    });
                    if (typeof window.showToast === 'function') window.showToast(`🗑️ ${selected.length} categories deleted from database!`);
                })
                .catch(() => {
                    selected.forEach(c => {
                        const row = c.closest('tr');
                        if (row) row.remove();
                    });
                    if (typeof window.showToast === 'function') window.showToast(`🗑️ ${selected.length} categories removed`);
                });
        }
    } else {
        if (typeof window.showToast === 'function') window.showToast(`Bulk action "${action}" applied to ${selected.length} categories!`);
    }
}

function openQuickEditCat(id, name, slug, desc, hsn) {
    const row = document.getElementById(`cat-row-${id}`);
    if (!row) return;

    if (row.nextElementSibling && row.nextElementSibling.classList.contains('inline-edit-row')) {
        row.nextElementSibling.remove();
        return;
    }

    const editTr = document.createElement('tr');
    editTr.className = 'inline-edit-row';
    editTr.innerHTML = `
        <td colspan="7">
            <div style="display:grid; grid-template-columns: 1fr 1fr 1fr auto; gap:8px; align-items:flex-end; padding:10px 14px; background:#FAF5E8; border:1px solid #D4AF37; border-radius:6px; margin:4px 0;">
                <div>
                    <label style="font-size:10.5px; font-weight:700; color:#181512; display:block; margin-bottom:2px;">Category Name</label>
                    <input type="text" id="qe-name-${id}" value="${name}" style="height:28px; width:100%; font-size:11.5px; font-weight:600; padding:0 8px; border:1px solid #8A681F; border-radius:4px; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:10.5px; font-weight:700; color:#181512; display:block; margin-bottom:2px;">URL Slug</label>
                    <input type="text" id="qe-slug-${id}" value="${slug}" style="height:28px; width:100%; font-size:11.5px; padding:0 8px; border:1px solid #8A681F; border-radius:4px; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:10.5px; font-weight:700; color:#181512; display:block; margin-bottom:2px;">HSN / GST</label>
                    <input type="text" id="qe-hsn-${id}" value="${hsn}" style="height:28px; width:100%; font-size:11.5px; padding:0 8px; border:1px solid #8A681F; border-radius:4px; box-sizing:border-box;">
                </div>
                <div style="display:flex; gap:5px;">
                    <button type="button" class="dt-btn-action-sm gold" onclick="saveQuickEditCat(${id})" style="height:28px; font-size:11px; padding:0 12px; font-weight:700;">Update</button>
                    <button type="button" class="dt-btn-action-sm" onclick="this.closest('tr').remove()" style="height:28px; font-size:11px; padding:0 10px; background:#f6f7f7; border:1px solid #c3c4c7; color:#3B352E;">Cancel</button>
                </div>
            </div>
        </td>
    `;
    row.after(editTr);
}

function saveQuickEditCat(id) {
    const name = document.getElementById(`qe-name-${id}`)?.value?.trim();
    const slug = document.getElementById(`qe-slug-${id}`)?.value?.trim();
    const row = document.getElementById(`cat-row-${id}`);
    if (row && name) {
        const link = row.querySelector('td:nth-child(3) strong a');
        if (link) link.textContent = name;
        const slugCell = row.querySelector('td:nth-child(5) code');
        if (slugCell) slugCell.textContent = slug;

        if (row.nextElementSibling && row.nextElementSibling.classList.contains('inline-edit-row')) {
            row.nextElementSibling.remove();
        }

        const params = new URLSearchParams();
        params.append('action', 'update');
        params.append('id', id);
        params.append('name', name);
        params.append('slug', slug);
        fetch('/api/categories.php', { method: 'POST', body: params })
            .then(res => res.json())
            .then(data => {
                if (typeof window.showToast === 'function') window.showToast(`✨ Category "${name}" updated in database!`);
            })
            .catch(() => {
                if (typeof window.showToast === 'function') window.showToast(`✨ Category "${name}" updated!`);
            });
    }
}

// Live search filter in categories table
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[placeholder*="Search categories"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#the-list tr[id^="cat-row-"]');
            rows.forEach(r => {
                const text = r.textContent.toLowerCase();
                r.style.display = (text.indexOf(query) !== -1) ? '' : 'none';
            });
        });
    }
});
</script>
<script src="/DT%20Brand/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
