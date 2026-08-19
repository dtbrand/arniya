<?php
/**
 * categories/index.php — DT Brand's Product Categories & Taxonomy Hub (Wholesale Dashboard & Luxury Shop Standard)
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Product Categories";
$active_nav = "products";
$active_subnav = "categories";
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
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
    .dt-kpi-card {
        background: #fff;
        border: 1px solid rgba(212,175,55,0.4);
        border-radius: 8px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        transition: all 0.2s ease;
    }
    .dt-kpi-card:hover {
        border-color: #D4AF37;
        box-shadow: 0 4px 12px rgba(212,175,55,0.15);
        transform: translateY(-1px);
    }
    .wp-cat-layout {
        display: grid;
        grid-template-columns: 310px 1fr;
        gap: 16px;
        align-items: start;
    }
    @media (max-width: 1024px) {
        .wp-cat-layout { grid-template-columns: 1fr; }
    }
    .dt-cat-form-card {
        background: #ffffff;
        border: 1.5px solid rgba(212,175,55,0.4);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .dt-cat-form-header {
        background: linear-gradient(135deg, #181512 0%, #2A241E 50%, #3D342A 100%);
        padding: 10px 14px;
        color: #FAF5E8;
        display: flex;
        align-items: center;
        gap: 8px;
        border-bottom: 2px solid #D4AF37;
    }
    .dt-cat-form-body {
        padding: 14px;
    }
    .dt-form-group {
        margin-bottom: 10px;
    }
    .dt-form-group label {
        display: block;
        font-size: 11.5px;
        font-weight: 700;
        color: #181512;
        margin-bottom: 3px;
    }
    .dt-form-group input, .dt-form-group select, .dt-form-group textarea {
        width: 100%;
        height: 30px;
        padding: 0 8px;
        font-size: 12px;
        color: #181512;
        background: #ffffff;
        border: 1px solid #c3c4c7;
        border-radius: 4px;
        box-sizing: border-box;
        outline: none;
        transition: all 0.15s ease;
    }
    .dt-form-group textarea {
        height: 44px;
        padding: 5px 8px;
        resize: none;
    }
    .dt-form-group input:focus, .dt-form-group select:focus, .dt-form-group textarea:focus {
        border-color: #8A681F;
        box-shadow: 0 0 0 1px #8A681F, 0 0 8px rgba(212,175,55,0.25);
    }
    .wp-list-table .wp-row-actions {
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.12s ease;
        font-size: 11px;
        color: #a7aaad;
        margin-top: 3px;
    }
    .wp-list-table tr:hover .wp-row-actions {
        visibility: visible;
        opacity: 1;
    }
    tr.inline-edit-row {
        background: #FAF5E8 !important;
    }
    tr.inline-edit-row td {
        padding: 12px 14px !important;
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
        <main class="adm-content" style="padding: 14px 18px;">

            <!-- 1. Top Header Toolbar with Luxury Brand Gold Buttons -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Product Categories &amp; Taxonomies</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:3px 8px;">16 Taxonomies</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <a href="/Frontend/Admin/products/" class="wp-button" style="height:32px; padding:0 11px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Products (1,240)</span>
                    </a>
                    <a href="/Frontend/Admin/products/brands/" class="wp-button" style="height:32px; padding:0 11px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <span>Brands (4)</span>
                    </a>
                    <a href="/Frontend/Admin/products/attributes/" class="wp-button" style="height:32px; padding:0 11px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line></svg>
                        <span>Attributes</span>
                    </a>
                    <a href="/Frontend/Admin/products/add.php" class="wp-button primary" style="background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F; padding:0 14px; height:32px; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35); text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add Product</span>
                    </a>
                </div>
            </div>

            <!-- 2. B2B Wholesale & Taxonomy KPI Metrics Ribbon -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:10px; margin-bottom:12px;">
                <div class="dt-kpi-card">
                    <div style="width:34px; height:34px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                    </div>
                    <div>
                        <div style="font-size:10.5px; color:#646970; font-weight:600;">ACTIVE CATEGORIES</div>
                        <div style="font-size:16px; font-weight:800; color:#181512;">16 Taxonomies</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:34px; height:34px; border-radius:6px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D;">
                        <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <div>
                        <div style="font-size:10.5px; color:#646970; font-weight:600;">ASSIGNED CATALOG SKUS</div>
                        <div style="font-size:16px; font-weight:800; color:#15803D;">1,240 Products</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:34px; height:34px; border-radius:6px; background:#EFF6FF; border:1px solid #93C5FD; display:flex; align-items:center; justify-content:center; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:10.5px; color:#646970; font-weight:600;">HSN &amp; GST TAX CLASSES</div>
                        <div style="font-size:16px; font-weight:800; color:#1D4ED8;">5007 / 6204 (5%)</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:34px; height:34px; border-radius:6px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309;">
                        <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:10.5px; color:#646970; font-weight:600;">SURAT READY STOCK</div>
                        <div style="font-size:16px; font-weight:800; color:#B45309;">8,450 Units</div>
                    </div>
                </div>
            </div>

            <!-- 3. Dual Column Layout: Add Category Form (Left) & Categories List Table (Right) -->
            <div class="wp-cat-layout">
                
                <!-- LEFT: Add New Category Form Card -->
                <div class="dt-cat-form-card">
                    <div class="dt-cat-form-header">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#D4AF37" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <h2 style="margin:0; font-size:13.5px; font-weight:800; color:#FAF5E8;">Add New Category</h2>
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
                                    <option value="silk-sarees">Silk Sarees</option>
                                    <option value="banarasi-brocade">Banarasi Brocade</option>
                                    <option value="bridal-lehengas">Bridal Lehengas</option>
                                    <option value="designer-kurtis">Designer Kurtis</option>
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
                                    <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" id="catThumbPreview" style="width:34px; height:34px; object-fit:cover; border-radius:4px; border:1px solid #c3c4c7;">
                                    <button type="button" class="wp-button" onclick="if(window.showToast) window.showToast('Upload category banner/image');" style="height:30px; font-size:11px; font-weight:600; flex:1; display:flex; align-items:center; justify-content:center; gap:5px;">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                        <span>Upload Image</span>
                                    </button>
                                </div>
                            </div>

                            <div style="margin-top:10px;">
                                <button type="submit" class="wp-button primary" style="width:100%; height:32px; background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F; display:flex; align-items:center; justify-content:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    <span>+ Add New Category</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- RIGHT: Categories Taxonomy Table Card -->
                <div class="wp-table-card" style="background:#fff; border:1px solid #c3c4c7; border-radius:6px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                    
                    <!-- Table Top Toolbar with Clean Search & Filter -->
                    <div style="padding:10px 14px; background:#f6f7f7; border-bottom:1px solid #c3c4c7; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                        <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                            <select class="wp-select" id="catBulkActionSelect" style="height:32px; font-size:12px; min-width:130px;">
                                <option value="">Bulk actions</option>
                                <option value="delete">Delete Selected</option>
                            </select>
                            <button type="button" class="wp-button" onclick="handleCatBulkAction()" style="height:32px; font-size:12px; font-weight:700; padding:0 12px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Apply</button>

                            <select class="wp-select" id="catParentFilter" onchange="filterCatByParent(this.value)" style="height:32px; font-size:12px; min-width:140px;">
                                <option value="">All Categories</option>
                                <option value="Silk Sarees">Silk Sarees</option>
                                <option value="Banarasi Brocade">Banarasi Brocade</option>
                                <option value="Bridal Lehengas">Bridal Lehengas</option>
                                <option value="Designer Kurtis">Designer Kurtis</option>
                            </select>
                        </div>

                        <!-- Rule-Compliant Search Input with Left Icon & 1-Tap Clear -->
                        <div class="wp-search-box" style="display:flex; align-items:center; gap:6px;">
                            <div style="position:relative; display:inline-flex; align-items:center;">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2" style="position:absolute; left:10px; pointer-events:none;">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                                <input type="text" id="catSearchInput" class="wp-search-input" placeholder="Search categories, HSN..." style="height:32px; padding-left:32px; padding-right:24px; width:220px; font-size:12px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchWpCategories(this.value); toggleCatSearchClearBtn(this.value)">
                                <span id="catSearchClearBtn" onclick="clearCatSearch()" style="position:absolute; right:7px; cursor:pointer; color:#8c8f94; font-size:12px; font-weight:700; display:none;" title="Clear search">✕</span>
                            </div>
                            <button type="button" class="wp-button primary" onclick="searchWpCategories(document.getElementById('catSearchInput').value)" style="height:32px; font-size:12px; font-weight:800; padding:0 14px; background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; border:1px solid #8A681F;">Search</button>
                        </div>
                    </div>

                    <table class="wp-list-table" id="categoriesTable" style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr style="background:#fafafa; border-bottom:1px solid #c3c4c7;">
                                <th style="width:36px; text-align:center; padding:10px 8px;">
                                    <input type="checkbox" onchange="toggleSelectAllCats(this)" style="cursor:pointer; width:15px; height:15px;">
                                </th>
                                <th style="width:48px; padding:10px 8px;">Image</th>
                                <th style="padding:10px 12px;">Name &amp; Actions</th>
                                <th style="padding:10px 10px;">Description</th>
                                <th style="padding:10px 10px;">Slug</th>
                                <th style="padding:10px 10px;">HSN (GST)</th>
                                <th style="text-align:right; width:70px; padding:10px 12px;">Count</th>
                            </tr>
                        </thead>
                        <tbody id="categoriesTableBody">
                            
                            <!-- Cat 1 -->
                            <tr id="cat-row-1" style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                                <td style="text-align:center; padding:10px 8px;">
                                    <input type="checkbox" class="cat-row-check" style="cursor:pointer; width:15px; height:15px;">
                                </td>
                                <td style="padding:10px 8px;">
                                    <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:38px; height:38px; object-fit:cover; border-radius:4px; border:1px solid #e2e8f0; display:block;">
                                </td>
                                <td style="padding:10px 12px;">
                                    <strong style="font-size:13px; color:#181512;"><a href="/Frontend/Admin/products/categories/edit.php?id=1" style="color:#181512; text-decoration:none;">Silk Sarees</a></strong>
                                    <div class="wp-row-actions" style="margin-top:3px; font-size:11px;">
                                        <a href="/Frontend/Admin/products/categories/edit.php?id=1" style="color:#8A681F; font-weight:700;">Edit</a> <span style="color:#c3c4c7;">|</span>
                                        <a href="#" onclick="openQuickEditCat(1, 'Silk Sarees', 'silk-sarees', 'Pure Mulberry & Kanjivaram Bridal Silks', '5007 (5% GST)'); return false;" style="color:#2271b1; font-weight:600;">Quick Edit</a> <span style="color:#c3c4c7;">|</span>
                                        <a href="#" onclick="deleteCatRow(1); return false;" style="color:#b32d2e;">Delete</a> <span style="color:#c3c4c7;">|</span>
                                        <a href="/Frontend/Shop/shop.php?category=silk-sarees" target="_blank" style="color:#15803D; font-weight:600;">View</a>
                                    </div>
                                </td>
                                <td style="padding:10px 10px; font-size:12px; color:#646970;">Pure Mulberry &amp; Kanjivaram Bridal Silks</td>
                                <td style="padding:10px 10px;"><code style="background:#FAF5E8; color:#8A681F; padding:2px 6px; border-radius:3px; font-size:11.5px; font-weight:600;">silk-sarees</code></td>
                                <td style="padding:10px 10px;"><span class="adm-badge gold" style="font-size:10.5px; padding:2px 6px;">5007 (5%)</span></td>
                                <td style="text-align:right; padding:10px 12px;">
                                    <a href="/Frontend/Admin/products/?cat=silk-sarees" style="text-decoration:none;">
                                        <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:800; font-size:11.5px; padding:2px 8px; border-radius:10px;">420</span>
                                    </a>
                                </td>
                            </tr>

                            <!-- Cat 1.1 Child -->
                            <tr id="cat-row-2" style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                                <td style="text-align:center; padding:10px 8px;">
                                    <input type="checkbox" class="cat-row-check" style="cursor:pointer; width:15px; height:15px;">
                                </td>
                                <td style="padding:10px 8px;">
                                    <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:38px; height:38px; object-fit:cover; border-radius:4px; border:1px solid #e2e8f0; display:block;">
                                </td>
                                <td style="padding:10px 12px;">
                                    <span style="color:#8A681F; font-weight:700;">— </span><strong style="font-size:13px; color:#181512;"><a href="/Frontend/Admin/products/categories/edit.php?id=2" style="color:#181512; text-decoration:none;">Kanjivaram Pure Silk</a></strong>
                                    <div class="wp-row-actions" style="margin-top:3px; font-size:11px;">
                                        <a href="/Frontend/Admin/products/categories/edit.php?id=2" style="color:#8A681F; font-weight:700;">Edit</a> <span style="color:#c3c4c7;">|</span>
                                        <a href="#" onclick="openQuickEditCat(2, 'Kanjivaram Pure Silk', 'kanjivaram-pure-silk', 'Authentic Kanchipuram Handloom Zari Weaves', '5007 (5% GST)'); return false;" style="color:#2271b1; font-weight:600;">Quick Edit</a> <span style="color:#c3c4c7;">|</span>
                                        <a href="#" onclick="deleteCatRow(2); return false;" style="color:#b32d2e;">Delete</a> <span style="color:#c3c4c7;">|</span>
                                        <a href="/Frontend/Shop/shop.php?category=kanjivaram-pure-silk" target="_blank" style="color:#15803D; font-weight:600;">View</a>
                                    </div>
                                </td>
                                <td style="padding:10px 10px; font-size:12px; color:#646970;">Authentic Kanchipuram Handloom Zari Weaves</td>
                                <td style="padding:10px 10px;"><code style="background:#FAF5E8; color:#8A681F; padding:2px 6px; border-radius:3px; font-size:11.5px; font-weight:600;">kanjivaram-pure-silk</code></td>
                                <td style="padding:10px 10px;"><span class="adm-badge gold" style="font-size:10.5px; padding:2px 6px;">5007 (5%)</span></td>
                                <td style="text-align:right; padding:10px 12px;">
                                    <a href="/Frontend/Admin/products/?cat=kanjivaram-pure-silk" style="text-decoration:none;">
                                        <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:800; font-size:11.5px; padding:2px 8px; border-radius:10px;">180</span>
                                    </a>
                                </td>
                            </tr>

                            <!-- Cat 1.2 Child -->
                            <tr id="cat-row-3" style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                                <td style="text-align:center; padding:10px 8px;">
                                    <input type="checkbox" class="cat-row-check" style="cursor:pointer; width:15px; height:15px;">
                                </td>
                                <td style="padding:10px 8px;">
                                    <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" style="width:38px; height:38px; object-fit:cover; border-radius:4px; border:1px solid #e2e8f0; display:block;">
                                </td>
                                <td style="padding:10px 12px;">
                                    <span style="color:#8A681F; font-weight:700;">— </span><strong style="font-size:13px; color:#181512;"><a href="/Frontend/Admin/products/categories/edit.php?id=3" style="color:#181512; text-decoration:none;">Soft Silk &amp; Tussar</a></strong>
                                    <div class="wp-row-actions" style="margin-top:3px; font-size:11px;">
                                        <a href="/Frontend/Admin/products/categories/edit.php?id=3" style="color:#8A681F; font-weight:700;">Edit</a> <span style="color:#c3c4c7;">|</span>
                                        <a href="#" onclick="openQuickEditCat(3, 'Soft Silk & Tussar', 'soft-silk-tussar', 'Lightweight Festive Soft Silk Sarees', '5007 (5% GST)'); return false;" style="color:#2271b1; font-weight:600;">Quick Edit</a> <span style="color:#c3c4c7;">|</span>
                                        <a href="#" onclick="deleteCatRow(3); return false;" style="color:#b32d2e;">Delete</a> <span style="color:#c3c4c7;">|</span>
                                        <a href="/Frontend/Shop/shop.php?category=soft-silk-tussar" target="_blank" style="color:#15803D; font-weight:600;">View</a>
                                    </div>
                                </td>
                                <td style="padding:10px 10px; font-size:12px; color:#646970;">Lightweight Festive Soft Silk Sarees</td>
                                <td style="padding:10px 10px;"><code style="background:#FAF5E8; color:#8A681F; padding:2px 6px; border-radius:3px; font-size:11.5px; font-weight:600;">soft-silk-tussar</code></td>
                                <td style="padding:10px 10px;"><span class="adm-badge gold" style="font-size:10.5px; padding:2px 6px;">5007 (5%)</span></td>
                                <td style="text-align:right; padding:10px 12px;">
                                    <a href="/Frontend/Admin/products/?cat=soft-silk-tussar" style="text-decoration:none;">
                                        <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:800; font-size:11.5px; padding:2px 8px; border-radius:10px;">140</span>
                                    </a>
                                </td>
                            </tr>

                            <!-- Cat 2 -->
                            <tr id="cat-row-4" style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                                <td style="text-align:center; padding:10px 8px;">
                                    <input type="checkbox" class="cat-row-check" style="cursor:pointer; width:15px; height:15px;">
                                </td>
                                <td style="padding:10px 8px;">
                                    <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" style="width:38px; height:38px; object-fit:cover; border-radius:4px; border:1px solid #e2e8f0; display:block;">
                                </td>
                                <td style="padding:10px 12px;">
                                    <strong style="font-size:13px; color:#181512;"><a href="/Frontend/Admin/products/categories/edit.php?id=4" style="color:#181512; text-decoration:none;">Banarasi Brocade</a></strong>
                                    <div class="wp-row-actions" style="margin-top:3px; font-size:11px;">
                                        <a href="/Frontend/Admin/products/categories/edit.php?id=4" style="color:#8A681F; font-weight:700;">Edit</a> <span style="color:#c3c4c7;">|</span>
                                        <a href="#" onclick="openQuickEditCat(4, 'Banarasi Brocade', 'banarasi-brocade', 'Royal Heritage Varanasi Brocades & Katan Silks', '5007 (5% GST)'); return false;" style="color:#2271b1; font-weight:600;">Quick Edit</a> <span style="color:#c3c4c7;">|</span>
                                        <a href="#" onclick="deleteCatRow(4); return false;" style="color:#b32d2e;">Delete</a> <span style="color:#c3c4c7;">|</span>
                                        <a href="/Frontend/Shop/shop.php?category=banarasi-brocade" target="_blank" style="color:#15803D; font-weight:600;">View</a>
                                    </div>
                                </td>
                                <td style="padding:10px 10px; font-size:12px; color:#646970;">Royal Heritage Varanasi Brocades &amp; Katan Silks</td>
                                <td style="padding:10px 10px;"><code style="background:#FAF5E8; color:#8A681F; padding:2px 6px; border-radius:3px; font-size:11.5px; font-weight:600;">banarasi-brocade</code></td>
                                <td style="padding:10px 10px;"><span class="adm-badge gold" style="font-size:10.5px; padding:2px 6px;">5007 (5%)</span></td>
                                <td style="text-align:right; padding:10px 12px;">
                                    <a href="/Frontend/Admin/products/?cat=banarasi-brocade" style="text-decoration:none;">
                                        <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:800; font-size:11.5px; padding:2px 8px; border-radius:10px;">280</span>
                                    </a>
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
    e.preventDefault();
    const name = document.getElementById('catName')?.value;
    if (!name) return;
    if (typeof window.showToast === 'function') window.showToast(`✨ Category "${name}" created successfully!`);
    document.getElementById('wpAddCatForm')?.reset();
}

function deleteCatRow(id) {
    const row = document.getElementById(`cat-row-${id}`);
    if (row) {
        row.remove();
        if (typeof window.showToast === 'function') window.showToast('🗑️ Category deleted');
    }
}

function handleCatBulkAction() {
    const action = document.getElementById('catBulkActionSelect')?.value;
    if (!action) return;
    const selected = document.querySelectorAll('.cat-row-check:checked');
    if (selected.length === 0) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Select at least one category');
        return;
    }
    if (typeof window.showToast === 'function') window.showToast(`Bulk action "${action}" applied to ${selected.length} categories!`);
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
            <div style="display:grid; grid-template-columns: 1fr 1fr 1fr auto; gap:10px; align-items:flex-end;">
                <div>
                    <label style="font-size:11px; font-weight:700; color:#181512; display:block; margin-bottom:2px;">Name</label>
                    <input type="text" id="qe-name-${id}" value="${name}" style="height:30px; width:100%; font-size:12px; padding:0 8px; border:1px solid #c3c4c7; border-radius:4px;">
                </div>
                <div>
                    <label style="font-size:11px; font-weight:700; color:#181512; display:block; margin-bottom:2px;">Slug</label>
                    <input type="text" id="qe-slug-${id}" value="${slug}" style="height:30px; width:100%; font-size:12px; padding:0 8px; border:1px solid #c3c4c7; border-radius:4px;">
                </div>
                <div>
                    <label style="font-size:11px; font-weight:700; color:#181512; display:block; margin-bottom:2px;">HSN / GST</label>
                    <input type="text" id="qe-hsn-${id}" value="${hsn}" style="height:30px; width:100%; font-size:12px; padding:0 8px; border:1px solid #c3c4c7; border-radius:4px;">
                </div>
                <div style="display:flex; gap:6px;">
                    <button type="button" class="wp-button primary" onclick="saveQuickEditCat(${id})" style="height:30px; font-size:11px; font-weight:800; background:linear-gradient(135deg, #8A681F, #D4AF37); color:#181512;">Update</button>
                    <button type="button" class="wp-button" onclick="this.closest('tr').remove()" style="height:30px; font-size:11px;">Cancel</button>
                </div>
            </div>
        </td>
    `;
    row.after(editTr);
}

function saveQuickEditCat(id) {
    const name = document.getElementById(`qe-name-${id}`)?.value;
    const row = document.getElementById(`cat-row-${id}`);
    if (row && name) {
        row.querySelector('td:nth-child(3) strong a').textContent = name;
        if (row.nextElementSibling && row.nextElementSibling.classList.contains('inline-edit-row')) {
            row.nextElementSibling.remove();
        }
        if (typeof window.showToast === 'function') window.showToast(`✨ Category "${name}" updated!`);
    }
}
</script>
</body>
</html>
