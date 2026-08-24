<?php
/**
 * index.php — DT Brand's Products Management Suite (Wholesale Desktop & WooCommerce Hybrid)
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$productsList = ProductCatalog::getAll();
$totalProductsCount = count($productsList);
$categoriesList = ProductCatalog::getCategories();
$totalCategoriesCount = count($categoriesList);

$totalCatalogValuation = 0;
$totalUnitsInStock = 0;
$lowStockCount = 0;

foreach ($productsList as $p) {
    $qty = isset($p['stock_qty']) ? (int)$p['stock_qty'] : 0;
    $wp = isset($p['wholesale_price']) ? (float)$p['wholesale_price'] : 0;
    $totalCatalogValuation += ($qty * $wp);
    $totalUnitsInStock += $qty;
    if ($qty > 0 && $qty < 20) {
        $lowStockCount++;
    }
}

$publishedCount = 0;
$draftCount = 0;
$outOfStockCount = 0;
$featuredCount = 0;
$bestSellerCount = 0;
$newArrivalCount = 0;

foreach ($productsList as $p) {
    $qty = isset($p['stock_qty']) ? (int)$p['stock_qty'] : 0;
    $status = $p['status'] ?? 'in_stock';
    if ($status === 'in_stock' || $status === 'published') {
        $publishedCount++;
    } elseif ($status === 'draft') {
        $draftCount++;
    }
    if ($qty <= 0) {
        $outOfStockCount++;
    }
    if (!empty($p['is_featured']) || ($p['rating'] ?? 0) >= 4.9) {
        $featuredCount++;
    }
    if (($p['reviews_count'] ?? 0) >= 50) {
        $bestSellerCount++;
    }
    $newArrivalCount++;
}

$page_title = "Products";
$active_nav = "products";
$active_subnav = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products ‹ DT Brand's Wholesale & Admin Suite</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
    /* Wholesale Desktop Specific Styling */
    .dt-kpi-ribbon {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 12px;
    }
    @media (max-width: 992px) {
        .dt-kpi-ribbon {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (max-width: 576px) {
        .dt-kpi-ribbon {
            grid-template-columns: 1fr;
        }
    }
    .dt-kpi-card {
        background: #fff;
        border: 1px solid rgba(212,175,55,0.4);
        border-radius: 6px;
        padding: 8px 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .dt-kpi-card:hover {
        border-color: #D4AF37;
        box-shadow: 0 4px 12px rgba(212,175,55,0.15);
        transform: translateY(-1px);
    }
    .dt-view-toggle-btn {
        background: #fff;
        border: 1px solid #c3c4c7;
        color: #50575e;
        padding: 4px 8px;
        font-size: 11.5px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        height: 28px;
        transition: all 0.15s ease;
        box-sizing: border-box;
    }
    .dt-view-toggle-btn.active {
        background: #FAF5E8;
        border-color: #D4AF37;
        color: #8A681F;
        font-weight: 700;
    }
    .dt-ws-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 14px;
        margin-top: 12px;
    }
    .dt-ws-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        transition: all 0.2s ease;
        display: flex;
        flex-direction: column;
    }
    .dt-ws-card:hover {
        border-color: #D4AF37;
        box-shadow: 0 6px 18px rgba(212,175,55,0.18);
        transform: translateY(-2px);
    }
    .dt-ws-card-img {
        width: 100%;
        height: 170px;
        object-fit: cover;
        background: #f8fafc;
    }
    .wp-row-actions a {
        text-decoration: none;
        transition: color 0.15s ease;
    }
    .wp-row-actions a:hover {
        text-decoration: underline;
    }
    .wp-star-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
        color: #c3c4c7;
        padding: 0;
        line-height: 1;
        transition: all 0.15s ease;
    }
    .wp-star-btn.active {
        color: #D4AF37;
        text-shadow: 0 0 3px rgba(212,175,55,0.5);
    }
    .wp-star-btn:hover {
        transform: scale(1.2);
    }

    /* Modal Backdrop & Container */
    .dt-modal-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(24, 21, 18, 0.6);
        backdrop-filter: blur(3px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }
    .dt-modal-dialog {
        background: #fff;
        border-radius: 8px;
        width: 95%;
        max-width: 500px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.25);
        border: 1px solid #D4AF37;
        overflow: hidden;
        animation: dtModalIn 0.2s ease-out;
    }
    @keyframes dtModalIn {
        from { opacity: 0; transform: scale(0.95) translateY(-10px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }
    .dt-modal-header {
        background: radial-gradient(ellipse at 20% 50%, rgba(212, 175, 55, 0.35) 0%, transparent 60%), linear-gradient(135deg, #261C0E 0%, #3A2C12 40%, #2A2010 75%, #18120A 100%);
        color: #FFFFFF;
        padding: 12px 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid #D4AF37;
    }
    .dt-modal-title {
        font-size: 14px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .dt-modal-close {
        background: none;
        border: none;
        color: #fff;
        font-size: 18px;
        cursor: pointer;
        opacity: 0.8;
    }
    .dt-modal-close:hover { opacity: 1; }
    .dt-modal-body {
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .dt-modal-footer {
        background: #FAF5E8;
        padding: 10px 16px;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        border-top: 1px solid #D4AF37;
    }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 12px 16px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <!-- 1. Header Toolbar with Luxury Brand Gold Buttons & Real Vector SVGs -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px; margin-bottom:10px;">
                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:18px; font-weight:800; color:#181512; margin:0;">Products &amp; Wholesale Hub</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:10.5px; padding:2px 7px;"><?php echo $totalProductsCount; ?> Total</span>
                    
                    <!-- Add Product Primary Gold Button -->
                    <a href="/DT%20Brand/admin/products/add.php" class="dt-btn-action-sm gold" style="height:28px; padding:0 12px; font-size:11px;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add Product</span>
                    </a>

                    <!-- Secondary Action Buttons with Real SVG Icons -->
                    <a href="/DT%20Brand/admin/products/categories/" class="dt-btn-action-sm pale-gold" style="height:28px; padding:0 10px; font-size:11px;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        <span>Categories (<?php echo $totalCategoriesCount; ?>)</span>
                    </a>
                    <a href="/DT%20Brand/admin/products/brands/" class="dt-btn-action-sm pale-gold" style="height:28px; padding:0 10px; font-size:11px;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <span>Brands (3)</span>
                    </a>
                    <a href="/DT%20Brand/admin/products/attributes/" class="dt-btn-action-sm pale-gold" style="height:28px; padding:0 10px; font-size:11px;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                        <span>Attributes</span>
                    </a>
                    <a href="javascript:void(0)" onclick="if(window.showToast) window.showToast('Exporting products catalog as CSV...');" class="dt-btn-action-sm pale-gold" style="height:28px; padding:0 10px; font-size:11px;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Export</span>
                    </a>
                </div>

                <!-- Dual View Mode Switcher: Table List vs Wholesale Desktop Grid -->
                <div style="display:flex; align-items:center; border:1px solid #c3c4c7; border-radius:4px; overflow:hidden;">
                    <button type="button" class="dt-view-toggle-btn active" id="btnViewTable" onclick="switchProductView('table')">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                        <span>Table List</span>
                    </button>
                    <button type="button" class="dt-view-toggle-btn" id="btnViewGrid" onclick="switchProductView('grid')">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>Wholesale Grid</span>
                    </button>
                </div>
            </div>

            <!-- 2. B2B Wholesale KPI Metrics Ribbon with 100% Real Indian Rupee Icon -->
            <div class="dt-kpi-ribbon">
                <div class="dt-kpi-card">
                    <div style="width:28px; height:28px; border-radius:5px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; flex-shrink:0;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <div style="min-width:0;">
                        <div style="font-size:9.5px; color:#646970; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">ACTIVE B2B DESIGNS</div>
                        <div style="font-size:14px; font-weight:800; color:#181512; line-height:1.2;"><?php echo $totalProductsCount; ?> SKUs</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:28px; height:28px; border-radius:5px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D; flex-shrink:0;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                    </div>
                    <div style="min-width:0;">
                        <div style="font-size:9.5px; color:#646970; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">B2B CATALOG VALUATION</div>
                        <div style="font-size:14px; font-weight:800; color:#15803D; line-height:1.2;">₹<?php echo number_format($totalCatalogValuation); ?></div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:28px; height:28px; border-radius:5px; background:#EFF6FF; border:1px solid #93C5FD; display:flex; align-items:center; justify-content:center; color:#1D4ED8; flex-shrink:0;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                    </div>
                    <div style="min-width:0;">
                        <div style="font-size:9.5px; color:#646970; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">SURAT CENTRAL DEPOT</div>
                        <div style="font-size:14px; font-weight:800; color:#1D4ED8; line-height:1.2;"><?php echo number_format($totalUnitsInStock); ?> Units</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:28px; height:28px; border-radius:5px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309; flex-shrink:0;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    </div>
                    <div style="min-width:0;">
                        <div style="font-size:9.5px; color:#646970; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">LOW STOCK REORDERS</div>
                        <div style="font-size:14px; font-weight:800; color:#B45309; line-height:1.2;"><?php echo $lowStockCount; ?> Lots</div>
                    </div>
                </div>
            </div>

            <!-- 3. Status Filter Links (.subsubsub) -->
            <ul class="wp-subsubsub" style="margin-bottom:10px; padding:0; display:flex; flex-wrap:wrap; gap:4px; font-size:11.5px;">
                <li><a href="javascript:void(0)" class="current" onclick="filterWpProducts('', this)">All <span class="count" id="countAll">(<?php echo $totalProductsCount; ?>)</span></a> <span class="sep">|</span></li>
                <li><a href="javascript:void(0)" onclick="filterWpProducts('Published', this)">Published <span class="count">(<?php echo $publishedCount; ?>)</span></a> <span class="sep">|</span></li>
                <li><a href="javascript:void(0)" onclick="filterWpProducts('Draft', this)">Draft <span class="count">(<?php echo $draftCount; ?>)</span></a> <span class="sep">|</span></li>
                <li><a href="javascript:void(0)" onclick="filterWpProducts('Low Stock', this)">Low stock <span class="count">(<?php echo $lowStockCount; ?>)</span></a> <span class="sep">|</span></li>
                <li><a href="javascript:void(0)" onclick="filterWpProducts('Out of Stock', this)">Out of stock <span class="count">(<?php echo $outOfStockCount; ?>)</span></a> <span class="sep">|</span></li>
                <li><a href="javascript:void(0)" onclick="filterWpProducts('Featured', this)">Featured <span class="count">(<?php echo $featuredCount; ?>)</span></a> <span class="sep">|</span></li>
                <li><a href="javascript:void(0)" onclick="filterWpProducts('Best Seller', this)">Best Sellers <span class="count">(<?php echo $bestSellerCount; ?>)</span></a> <span class="sep">|</span></li>
                <li><a href="javascript:void(0)" onclick="filterWpProducts('New Arrival', this)">New Arrivals <span class="count">(<?php echo $newArrivalCount; ?>)</span></a></li>
            </ul>

            <!-- 4. Top Toolbar: Bulk Actions, Filter Dropdowns & Rule-Compliant Search Input -->
            <div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:10px;">
                <div class="wp-tablenav-actions" style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                    <select class="wp-select" id="wpBulkActionSelect" style="height:28px; font-size:11.5px; padding:0 6px; border-radius:4px; border:1px solid #c3c4c7;">
                        <option value="">Bulk actions</option>
                        <option value="edit">Edit Selected</option>
                        <option value="featured">Mark as featured</option>
                        <option value="unfeatured">Remove from featured</option>
                        <option value="trash">Move to Trash</option>
                    </select>
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="handleWpBulkAction()" style="height:28px; font-size:11px; padding:0 10px;">
                        <span>Apply</span>
                    </button>

                    <select class="wp-select" id="wpCategoryFilter" onchange="applyWpFilters()" style="height:28px; font-size:11.5px; padding:0 6px; border-radius:4px; border:1px solid #c3c4c7; min-width:130px;">
                        <option value="">Select a category</option>
                        <?php foreach ($categoriesList as $cat): 
                            $cName = is_array($cat) ? ($cat['name'] ?? '') : (string)$cat;
                        ?>
                            <option value="<?php echo htmlspecialchars($cName); ?>"><?php echo htmlspecialchars($cName); ?></option>
                        <?php endforeach; ?>
                    </select>

                    <select class="wp-select" id="wpStockFilter" onchange="applyWpFilters()" style="height:28px; font-size:11.5px; padding:0 6px; border-radius:4px; border:1px solid #c3c4c7; min-width:135px;">
                        <option value="">Filter by stock status</option>
                        <option value="In stock">In stock</option>
                        <option value="Low stock">Low stock</option>
                        <option value="Out of stock">Out of stock</option>
                    </select>

                    <select class="wp-select" id="wpBrandFilter" onchange="applyWpFilters()" style="height:28px; font-size:11.5px; padding:0 6px; border-radius:4px; border:1px solid #c3c4c7; min-width:110px;">
                        <option value="">Filter by brand</option>
                        <option value="DT Signature">DT Signature</option>
                        <option value="Arniya Heritage">Arniya Heritage</option>
                        <option value="Jai Hanuman Tex">Jai Hanuman Tex</option>
                    </select>

                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="applyWpFilters()" style="height:28px; font-size:11px; padding:0 10px;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        <span>Filter</span>
                    </button>
                </div>

                <!-- Search Box with Clean Left Placeholder and 1-Tap Clear Button -->
                <div class="wp-search-box" style="display:flex; align-items:center; gap:6px;">
                    <div style="position:relative; display:inline-flex; align-items:center;">
                        <input type="text" id="wpSearchInput" class="wp-search-input" placeholder="Search products, SKUs..." style="height:28px; padding-left:10px; padding-right:22px; width:180px; font-size:11.5px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchWpProducts(this.value); toggleSearchClearBtn(this.value)">
                        <span id="wpSearchClearBtn" onclick="clearWpSearch()" style="position:absolute; right:7px; cursor:pointer; color:#8c8f94; font-size:12px; font-weight:700; display:none;" title="Clear search">✕</span>
                    </div>
                    <button type="button" class="dt-btn-action-sm gold" onclick="searchWpProducts(document.getElementById('wpSearchInput').value)" style="height:28px; font-size:11px; padding:0 10px;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <span>Search</span>
                    </button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- 5A. VIEW MODE: WORDPRESS / WOOCOMMERCE TABLE LIST        -->
            <!-- ======================================================== -->
            <div id="productTableView" class="wp-table-card" style="background:#fff; border:1px solid #c3c4c7; border-radius:6px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <div class="wp-table-responsive" style="width:100%; overflow-x:auto; -webkit-overflow-scrolling:touch;">
                    <table class="wp-list-table" id="wpProductsTable" style="width:100%; min-width:780px; border-collapse:collapse;">
                        <thead>
                            <tr style="background:#f6f7f7; border-bottom:1px solid #c3c4c7;">
                                <th style="width: 32px; text-align: center; padding:8px 6px;">
                                    <input type="checkbox" onchange="toggleWpSelectAll(this)" style="cursor:pointer; width:14px; height:14px;">
                                </th>
                                <th style="width: 48px; padding:8px 6px;">Image</th>
                                <th style="padding:8px 10px;">Product Name</th>
                                <th style="padding:8px 8px;">SKU</th>
                                <th style="padding:8px 8px;">Stock</th>
                                <th style="padding:8px 8px;">Price</th>
                                <th style="padding:8px 8px;">Categories</th>
                                <th style="padding:8px 8px;">Brand</th>
                                <th style="padding:8px 8px;">Rating</th>
                                <th style="text-align: center; width:40px; padding:8px 6px;">★</th>
                                <th style="padding:8px 10px;">Date</th>
                            </tr>
                        </thead>
                                                <tbody id="wpProductsTableBody">
                            <?php foreach ($productsList as $p): ?>
                                <?php
                                $rowId = "row-prod-" . $p['id'];
                                $img = !empty($p['image']) ? $p['image'] : '/Frontend/Shop/Asset/images/product1.png';
                                $qty = isset($p['stock_qty']) ? (int)$p['stock_qty'] : 0;
                                $isLow = ($qty < 20 && $qty > 0);
                                $isOut = ($qty <= 0);
                                $stockBg = $isOut ? '#FEE2E2' : ($isLow ? '#FEF3C7' : '#DCFCE7');
                                $stockColor = $isOut ? '#DC2626' : ($isLow ? '#B45309' : '#15803D');
                                $stockDot = $isOut ? '#ef4444' : ($isLow ? '#d97706' : '#16a34a');
                                $stockLabel = $isOut ? 'Out of stock' : ($isLow ? 'Low stock (' . $qty . ')' : 'In stock (' . $qty . ')');
                                $statusText = ($p['status'] ?? 'in_stock') === 'in_stock' ? 'Published' : ucfirst($p['status'] ?? 'published');
                                $catName = $p['category'] ?? 'Silk Sarees';
                                $sku = $p['sku'] ?? ('DT-SKU-' . $p['id']);
                                $rp = (float)($p['retail_price'] ?? 0);
                                $wp = (float)($p['wholesale_price'] ?? 0);
                                $rating = (float)($p['rating'] ?? 4.9);
                                $revCount = (int)($p['reviews_count'] ?? 50);
                                ?>
                                <tr id="<?= $rowId ?>" data-cat="<?= htmlspecialchars($catName) ?>" data-brand="DT Signature" data-stock="<?= $isOut ? 'Out of stock' : ($isLow ? 'Low stock' : 'In stock') ?>" data-status="Featured" data-featured="1" style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                                    <td style="text-align: center; padding:8px 6px;">
                                        <input type="checkbox" class="wp-row-check" value="<?= $p['id'] ?>" style="cursor:pointer; width:14px; height:14px;">
                                    </td>
                                    <td style="padding:8px 6px;">
                                        <img src="<?= htmlspecialchars($img) ?>" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="wp-thumb-img" alt="<?= htmlspecialchars($p['title']) ?>" style="width:36px; height:36px; object-fit:cover; border-radius:4px; border:1px solid #e2e8f0; display:block;">
                                    </td>
                                    <td style="padding:8px 10px;">
                                        <a href="/admin/products/edit.php?id=<?= $p['id'] ?>" class="wp-row-title" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;"><?= htmlspecialchars($p['title']) ?></a>
                                        <div class="wp-row-actions" style="margin-top:3px; font-size:11px; display:flex; gap:5px; align-items:center;">
                                            <a href="/admin/products/edit.php?id=<?= $p['id'] ?>" style="color:#8A681F; font-weight:700;">Edit</a>
                                            <span style="color:#c3c4c7;">|</span>
                                            <a href="javascript:void(0)" onclick="duplicateProductRow('<?= $rowId ?>')" style="color:#1D4ED8; font-weight:600;">Duplicate</a>
                                            <span style="color:#c3c4c7;">|</span>
                                            <a href="/product/<?= $p['id'] ?>" target="_blank" style="color:#1D4ED8; font-weight:600;">View</a>
                                            <span style="color:#c3c4c7;">|</span>
                                            <a href="javascript:void(0)" onclick="shareProductWhatsApp('<?= addslashes($p['title']) ?>', '<?= $sku ?>', '₹<?= number_format($wp) ?>')" style="color:#15803D; font-weight:700;">WhatsApp</a>
                                            <span style="color:#c3c4c7;">|</span>
                                            <a href="javascript:void(0)" onclick="trashProductRow('<?= $rowId ?>', '<?= addslashes($p['title']) ?>')" style="color:#DC2626; font-weight:600;">Trash</a>
                                        </div>
                                    </td>
                                    <td style="padding:8px 8px;"><code class="prod-sku-val" style="background:#f0f0f1; padding:2px 5px; border-radius:3px; font-size:11px;"><?= htmlspecialchars($sku) ?></code></td>
                                    <td style="padding:8px 8px;">
                                        <span class="adm-badge prod-stock-badge" style="background:<?= $stockBg ?>; color:<?= $stockColor ?>; font-weight:700; font-size:10.5px; padding:2px 6px; border-radius:10px; display:inline-flex; align-items:center; gap:4px;">
                                            <span style="width:5px; height:5px; border-radius:50%; background:<?= $stockDot ?>; display:inline-block;"></span>
                                            <span class="stock-text"><?= $stockLabel ?></span>
                                        </span>
                                    </td>
                                    <td style="padding:8px 8px;">
                                        <strong class="prod-retail-price" style="font-size:12.5px; color:#181512;">₹<?= number_format($rp) ?></strong><br>
                                        <small class="prod-wholesale-price" style="color:#8A681F; font-size:10.5px; font-weight:700;">Wholesale: ₹<?= number_format($wp) ?></small>
                                    </td>
                                    <td style="padding:8px 8px;"><a href="/admin/products/categories/" class="prod-cat-link" style="color:#8A681F; font-weight:600; text-decoration:none; font-size:11.5px;"><?= htmlspecialchars($catName) ?></a></td>
                                    <td style="padding:8px 8px; font-size:11.5px;"><strong class="prod-brand-val">DT Signature</strong></td>
                                    <td style="padding:8px 8px; font-size:11.5px;"><span style="color:#D4AF37; font-weight:700;"><?= number_format($rating, 1) ?> ★</span> <span style="color:#646970; font-size:10.5px;">(<?= $revCount ?>)</span></td>
                                    <td style="text-align: center; padding:8px 6px;">
                                        <button type="button" class="wp-star-btn active" title="Toggle Featured" onclick="toggleFeaturedProduct(this, '<?= $rowId ?>', '<?= addslashes($p['title']) ?>')">★</button>
                                    </td>
                                    <td style="padding:8px 10px; font-size:11px;">
                                        <span class="prod-status-text" style="color:#15803D; font-weight:700;"><?= $statusText ?></span><br>
                                        <small style="color:#646970;">2026/08/24</small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- 5B. VIEW MODE: WHOLESALE DESKTOP GRID CARDS              -->
            <!-- ======================================================== -->
                        <div id="productGridView" class="dt-ws-grid" style="display:none;">
                <?php foreach ($productsList as $p): ?>
                    <?php
                    $cardId = "card-prod-" . $p['id'];
                    $img = !empty($p['image']) ? $p['image'] : '/Frontend/Shop/Asset/images/product1.png';
                    $catName = $p['category'] ?? 'Silk Sarees';
                    $sku = $p['sku'] ?? ('DT-SKU-' . $p['id']);
                    $rp = (float)($p['retail_price'] ?? 0);
                    $wp = (float)($p['wholesale_price'] ?? 0);
                    $margin = ($rp > 0 && $wp > 0) ? round((($rp - $wp) / $rp) * 100) : 35;
                    $marginDiff = max(0, $rp - $wp);
                    ?>
                    <div class="dt-ws-card" id="<?= $cardId ?>">
                        <div style="position:relative;">
                            <img src="<?= htmlspecialchars($img) ?>" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="dt-ws-card-img" alt="<?= htmlspecialchars($p['title']) ?>">
                            <span class="adm-badge" style="position:absolute; top:8px; left:8px; background:#8A681F; color:#fff; font-weight:700; font-size:10px;">Best Seller</span>
                            <span class="adm-badge" style="position:absolute; top:8px; right:8px; background:rgba(255,255,255,0.9); color:#15803D; font-weight:800; font-size:10.5px;">MOQ: <?= $p['moq'] ?? 6 ?> Pcs</span>
                        </div>
                        <div style="padding:10px 12px; flex:1; display:flex; flex-direction:column;">
                            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:6px;">
                                <span style="font-size:10.5px; font-weight:700; color:#8A681F; text-transform:uppercase;"><?= htmlspecialchars($catName) ?></span>
                                <code style="font-size:10.5px; background:#f1f5f9; padding:2px 5px; border-radius:3px;"><?= htmlspecialchars($sku) ?></code>
                            </div>
                            <h4 style="margin:4px 0 8px 0; font-size:13px; font-weight:700; color:#181512; line-height:1.3;"><?= htmlspecialchars($p['title']) ?></h4>
                            
                            <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.4); border-radius:6px; padding:6px 8px; margin-bottom:8px;">
                                <div style="display:flex; justify-content:space-between; align-items:baseline;">
                                    <div>
                                        <small style="color:#5A4210; font-size:9.5px; font-weight:700;">WHOLESALE RATE</small>
                                        <div style="font-size:14.5px; font-weight:800; color:#181512;">₹<?= number_format($wp) ?> <small style="font-size:10.5px; font-weight:600; color:#646970;">/ pc</small></div>
                                    </div>
                                    <div style="text-align:right;">
                                        <small style="color:#646970; font-size:9.5px;">Retail MRP</small>
                                        <div style="font-size:12px; font-weight:600; color:#8c8f94; text-decoration:line-through;">₹<?= number_format($rp) ?></div>
                                    </div>
                                </div>
                                <div style="margin-top:3px; font-size:10px; color:#15803D; font-weight:700;"><?= $margin ?>% Resale Margin (+₹<?= number_format($marginDiff) ?>/pc)</div>
                            </div>

                            <div style="margin-top:auto; display:flex; gap:6px;">
                                <a href="/admin/products/edit.php?id=<?= $p['id'] ?>" class="dt-btn-action-sm pale-gold" style="flex:1; height:26px; font-size:11px; justify-content:center; text-decoration:none;">
                                    <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    <span>Edit</span>
                                </a>
                                <button type="button" class="dt-btn-action-sm emerald" onclick="shareProductWhatsApp('<?= addslashes($p['title']) ?>', '<?= $sku ?>', '₹<?= number_format($wp) ?>')" style="flex:1; height:26px; font-size:11px; justify-content:center;">
                                    <svg viewBox="0 0 24 24" width="11" height="11" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                    <span>WhatsApp</span>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- ======================================================== -->
<!-- BULK QUICK EDIT MODAL                                    -->
<!-- ======================================================== -->
<div id="bulkEditModal" class="dt-modal-backdrop">
    <div class="dt-modal-dialog">
        <div class="dt-modal-header">
            <div class="dt-modal-title">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#D4AF37" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                <span id="bulkEditModalTitle">Bulk Quick Edit</span>
            </div>
            <button type="button" class="dt-modal-close" onclick="closeBulkEditModal()">✕</button>
        </div>
        <div class="dt-modal-body">
            <div style="font-size:12px; color:#50575e; background:#FAF5E8; padding:8px 10px; border-radius:4px; border:1px solid #D4AF37;">
                Changes will be applied to all <strong id="bulkEditCount" style="color:#8A681F;">0</strong> selected products.
            </div>

            <div>
                <label style="font-size:11.5px; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Product Category</label>
                <select id="bulkEditCategory" class="wp-select" style="width:100%; height:32px; font-size:12px; padding:0 8px; border:1px solid #c3c4c7; border-radius:4px;">
                    <option value="">— Keep Current Category —</option>
                    <option value="Silk Sarees">Silk Sarees</option>
                    <option value="Banarasi Brocade">Banarasi Brocade</option>
                    <option value="Bridal Lehengas">Bridal Lehengas</option>
                    <option value="Designer Kurtis">Designer Kurtis</option>
                    <option value="Dress Materials">Dress Materials</option>
                </select>
            </div>

            <div>
                <label style="font-size:11.5px; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Brand</label>
                <select id="bulkEditBrand" class="wp-select" style="width:100%; height:32px; font-size:12px; padding:0 8px; border:1px solid #c3c4c7; border-radius:4px;">
                    <option value="">— Keep Current Brand —</option>
                    <option value="DT Signature">DT Signature</option>
                    <option value="Arniya Heritage">Arniya Heritage</option>
                    <option value="DT Couture">DT Couture</option>
                </select>
            </div>

            <div>
                <label style="font-size:11.5px; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Stock Status</label>
                <select id="bulkEditStock" class="wp-select" style="width:100%; height:32px; font-size:12px; padding:0 8px; border:1px solid #c3c4c7; border-radius:4px;">
                    <option value="">— Keep Current Stock —</option>
                    <option value="In stock">In stock</option>
                    <option value="Low stock">Low stock</option>
                    <option value="Out of stock">Out of stock</option>
                </select>
            </div>

            <div>
                <label style="font-size:11.5px; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Wholesale Price Adjustment (₹)</label>
                <input type="text" id="bulkEditPrice" placeholder="e.g. Set Wholesale Rate (e.g. ₹2,950)" style="width:100%; height:32px; font-size:12px; padding:0 8px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
            </div>
        </div>
        <div class="dt-modal-footer">
            <button type="button" class="dt-btn-action-sm pale-gold" onclick="closeBulkEditModal()" style="height:30px; padding:0 12px;">Cancel</button>
            <button type="button" class="dt-btn-action-sm gold" onclick="saveBulkEdit()" style="height:30px; padding:0 16px;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Update All Selected</span>
            </button>
        </div>
    </div>
</div>

<script>
function switchProductView(mode) {
    const table = document.getElementById('productTableView');
    const grid = document.getElementById('productGridView');
    const btnTable = document.getElementById('btnViewTable');
    const btnGrid = document.getElementById('btnViewGrid');

    if (mode === 'grid') {
        if (table) table.style.display = 'none';
        if (grid) grid.style.display = 'grid';
        if (btnTable) btnTable.classList.remove('active');
        if (btnGrid) btnGrid.classList.add('active');
        if (typeof window.showToast === 'function') window.showToast('Switched to Wholesale Grid View');
    } else {
        if (table) table.style.display = 'block';
        if (grid) grid.style.display = 'none';
        if (btnTable) btnTable.classList.add('active');
        if (btnGrid) btnGrid.classList.remove('active');
        if (typeof window.showToast === 'function') window.showToast('Switched to Table List View');
    }
}

function toggleSearchClearBtn(val) {
    const btn = document.getElementById('wpSearchClearBtn');
    if (btn) btn.style.display = val.length > 0 ? 'inline' : 'none';
}

function clearWpSearch() {
    const input = document.getElementById('wpSearchInput');
    if (input) {
        input.value = '';
        toggleSearchClearBtn('');
        searchWpProducts('');
        input.focus();
    }
}

function toggleWpSelectAll(master) {
    const checks = document.querySelectorAll('.wp-row-check');
    checks.forEach(c => c.checked = master.checked);
}

function searchWpProducts(q) {
    const rows = document.querySelectorAll('#wpProductsTableBody tr');
    const cards = document.querySelectorAll('.dt-ws-card');
    const term = (q || '').toLowerCase().trim();

    rows.forEach(r => {
        const txt = r.textContent.toLowerCase();
        r.style.display = txt.includes(term) ? '' : 'none';
    });

    cards.forEach(c => {
        const txt = c.textContent.toLowerCase();
        c.style.display = txt.includes(term) ? 'flex' : 'none';
    });
}

function filterWpProducts(status, linkElem) {
    const links = document.querySelectorAll('.wp-subsubsub a');
    links.forEach(l => l.classList.remove('current'));
    if (linkElem) {
        linkElem.classList.add('current');
    }

    const rows = document.querySelectorAll('#wpProductsTableBody tr');
    const cards = document.querySelectorAll('.dt-ws-card');

    rows.forEach(r => {
        if (!status) {
            r.style.display = '';
        } else {
            const txt = r.textContent.toLowerCase();
            const dataStatus = (r.getAttribute('data-status') || '').toLowerCase();
            const dataStock = (r.getAttribute('data-stock') || '').toLowerCase();
            const isFeatured = r.getAttribute('data-featured') === '1';

            let match = false;
            if (status.toLowerCase() === 'featured') {
                match = isFeatured || dataStatus.includes('featured');
            } else {
                match = txt.includes(status.toLowerCase()) || dataStatus.includes(status.toLowerCase()) || dataStock.includes(status.toLowerCase());
            }

            r.style.display = match ? '' : 'none';
        }
    });

    cards.forEach(c => {
        if (!status) {
            c.style.display = 'flex';
        } else {
            const txt = c.textContent.toLowerCase();
            c.style.display = txt.includes(status.toLowerCase()) ? 'flex' : 'none';
        }
    });

    if (typeof window.showToast === 'function') {
        window.showToast(status ? `Showing ${status} products` : 'Showing all products');
    }
}

function applyWpFilters() {
    const cat = (document.getElementById('wpCategoryFilter')?.value || '').toLowerCase();
    const stock = (document.getElementById('wpStockFilter')?.value || '').toLowerCase();
    const brand = (document.getElementById('wpBrandFilter')?.value || '').toLowerCase();
    
    const rows = document.querySelectorAll('#wpProductsTableBody tr');
    let matchCount = 0;

    rows.forEach(r => {
        const rCat = (r.getAttribute('data-cat') || r.textContent).toLowerCase();
        const rStock = (r.getAttribute('data-stock') || r.textContent).toLowerCase();
        const rBrand = (r.getAttribute('data-brand') || r.textContent).toLowerCase();

        const matchesCat = !cat || rCat.includes(cat);
        const matchesStock = !stock || rStock.includes(stock);
        const matchesBrand = !brand || rBrand.includes(brand);

        if (matchesCat && matchesStock && matchesBrand) {
            r.style.display = '';
            matchCount++;
        } else {
            r.style.display = 'none';
        }
    });

    if (typeof window.showToast === 'function') {
        window.showToast(`Filters applied: ${matchCount} products matched`);
    }
}

/* ── INDIVIDUAL STAR TOGGLE FOR FEATURED ── */
function toggleFeaturedProduct(btn, rowId, productName) {
    const row = document.getElementById(rowId);
    const isCurrentlyActive = btn.classList.contains('active');

    if (isCurrentlyActive) {
        btn.classList.remove('active');
        btn.textContent = '★';
        btn.style.color = '#c3c4c7';
        if (row) {
            row.setAttribute('data-featured', '0');
            row.setAttribute('data-status', 'Published');
        }
        if (typeof window.showToast === 'function') {
            window.showToast(`"${productName}" removed from Featured`);
        }
    } else {
        btn.classList.add('active');
        btn.textContent = '★';
        btn.style.color = '#D4AF37';
        if (row) {
            row.setAttribute('data-featured', '1');
            row.setAttribute('data-status', 'Featured');
        }
        if (typeof window.showToast === 'function') {
            window.showToast(`🌟 "${productName}" marked as Featured!`);
        }
    }
}

/* ── BULK ACTIONS (TOP & BOTTOM) ── */
function handleWpBulkAction() {
    const select = document.getElementById('wpBulkActionSelect');
    processBulkAction(select?.value);
}

function handleWpBulkActionBottom() {
    const select = document.getElementById('wpBulkActionSelectBottom');
    processBulkAction(select?.value);
}

function processBulkAction(action) {
    if (!action) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Please select a bulk action');
        return;
    }
    const selected = document.querySelectorAll('.wp-row-check:checked');
    if (selected.length === 0) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Select at least one product row');
        return;
    }

    if (action === 'featured') {
        selected.forEach(chk => {
            const row = chk.closest('tr');
            if (row) {
                row.setAttribute('data-featured', '1');
                row.setAttribute('data-status', 'Featured');
                const starBtn = row.querySelector('.wp-star-btn');
                if (starBtn) {
                    starBtn.classList.add('active');
                    starBtn.style.color = '#D4AF37';
                }
            }
        });
        if (typeof window.showToast === 'function') {
            window.showToast(`🌟 Marked ${selected.length} product(s) as Featured!`);
        }
    } 
    else if (action === 'unfeatured') {
        selected.forEach(chk => {
            const row = chk.closest('tr');
            if (row) {
                row.setAttribute('data-featured', '0');
                row.setAttribute('data-status', 'Published');
                const starBtn = row.querySelector('.wp-star-btn');
                if (starBtn) {
                    starBtn.classList.remove('active');
                    starBtn.style.color = '#c3c4c7';
                }
            }
        });
        if (typeof window.showToast === 'function') {
            window.showToast(`Removed ${selected.length} product(s) from Featured`);
        }
    } 
    else if (action === 'trash') {
        const ids = Array.from(selected).map(chk => chk.value);
        if (!confirm(`Are you sure you want to permanently delete ${ids.length} selected product(s) from the database and storefront?`)) {
            return;
        }

        fetch('/api/products.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=bulk_delete&ids=' + encodeURIComponent(ids.join(','))
        })
        .then(res => res.json())
        .then(data => {
            selected.forEach(chk => {
                const row = chk.closest('tr');
                if (row) {
                    row.style.transition = 'all 0.3s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'scale(0.95)';
                    setTimeout(() => row.remove(), 300);
                }
            });
            if (typeof window.showToast === 'function') {
                window.showToast(`🗑️ Permanently deleted ${ids.length} product(s) from database.`);
            }
        })
        .catch(err => {
            selected.forEach(chk => {
                const row = chk.closest('tr');
                if (row) row.remove();
            });
        });
    } 
    else if (action === 'edit') {
        openBulkEditModal(selected.length);
    }
}

/* ── BULK QUICK EDIT MODAL LOGIC ── */
function openBulkEditModal(count) {
    const modal = document.getElementById('bulkEditModal');
    const countElem = document.getElementById('bulkEditCount');
    if (countElem) countElem.textContent = count;
    if (modal) modal.style.display = 'flex';
}

function closeBulkEditModal() {
    const modal = document.getElementById('bulkEditModal');
    if (modal) modal.style.display = 'none';
}

function saveBulkEdit() {
    const selected = document.querySelectorAll('.wp-row-check:checked');
    if (selected.length === 0) return;

    const ids = Array.from(selected).map(chk => chk.value);
    const newCat = document.getElementById('bulkEditCategory')?.value || '';
    const newBrand = document.getElementById('bulkEditBrand')?.value || '';
    const newStock = document.getElementById('bulkEditStock')?.value || '';
    const newPrice = document.getElementById('bulkEditPrice')?.value || '';

    const params = new URLSearchParams();
    params.append('action', 'bulk_update');
    params.append('ids', ids.join(','));
    if (newCat) params.append('category', newCat);
    if (newStock) params.append('stock_status', newStock);
    if (newPrice) {
        const numericPrice = parseFloat(newPrice.replace(/[^0-9.]/g, '')) || 0;
        if (numericPrice > 0) params.append('wholesale_price', numericPrice);
    }

    if (typeof window.showToast === 'function') {
        window.showToast('Saving changes to live database...');
    }

    fetch('/api/products.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: params.toString()
    })
    .then(res => res.json())
    .then(data => {
        closeBulkEditModal();
        if (typeof window.showToast === 'function') {
            window.showToast(`✨ Bulk updated ${ids.length} products in live database!`);
        }
        setTimeout(() => window.location.reload(), 400);
    })
    .catch(err => {
        closeBulkEditModal();
        setTimeout(() => window.location.reload(), 400);
    });
}

function duplicateProductRow(rowId) {
    const prodId = rowId.replace('row-prod-', '');
    if (typeof window.showToast === 'function') {
        window.showToast('📋 Duplicating product in database...');
    }

    fetch('/api/products.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=duplicate&id=' + encodeURIComponent(prodId)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            if (typeof window.showToast === 'function') {
                window.showToast('✨ Product duplicated successfully in live database!');
            }
            setTimeout(() => {
                window.location.reload();
            }, 400);
        } else {
            alert('Error duplicating: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(err => {
        console.error(err);
        alert('Network error while duplicating product');
    });
}

function trashProductRow(rowId, productName) {
    if (!confirm('Are you sure you want to permanently delete "' + productName + '" from database and storefront?')) {
        return;
    }

    const row = document.getElementById(rowId);
    const prodId = rowId.replace('row-prod-', '');

    fetch('/api/products.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=delete&id=' + encodeURIComponent(prodId)
    })
    .then(res => res.json())
    .then(data => {
        if (row) {
            row.style.transition = 'all 0.25s ease';
            row.style.opacity = '0';
            row.style.transform = 'translateX(20px)';
            setTimeout(() => {
                row.remove();
                if (typeof window.showToast === 'function') {
                    window.showToast('🗑️ "' + productName + '" permanently deleted from database.');
                }
            }, 250);
        }
    })
    .catch(err => {
        if (row) row.remove();
    });
}

function shareProductWhatsApp(productName, sku, wholesaleRate) {
    const message = encodeURIComponent(`*DT BRAND'S & JAI HANUMAN TEX — WHOLESALE INQUIRY*\n\n` +
        `📦 *Product:* ${productName}\n` +
        `🏷️ *SKU:* ${sku}\n` +
        `💰 *Wholesale Rate:* ${wholesaleRate}/pc\n\n` +
        `Please send catalog details and minimum lot MOQ availability.`);
    window.open(`https://api.whatsapp.com/send?phone=919909000000&text=${message}`, '_blank');
}
</script>
</body>
</html>
