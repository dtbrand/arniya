<?php
/**
 * index.php — DT Brand's Products Management Suite (Wholesale Desktop & WooCommerce Hybrid)
 * DT Brand's & Jai Hanuman Tex
 */
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
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
    /* Wholesale Desktop Specific Styling */
    .dt-kpi-card {
        background: #fff;
        border: 1px solid rgba(212,175,55,0.4);
        border-radius: 8px;
        padding: 12px 16px;
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
    .dt-view-toggle-btn {
        background: #fff;
        border: 1px solid #c3c4c7;
        color: #50575e;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.15s ease;
    }
    .dt-view-toggle-btn.active {
        background: #FAF5E8;
        border-color: #D4AF37;
        color: #8A681F;
        font-weight: 700;
    }
    .dt-ws-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
        margin-top: 14px;
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
        height: 180px;
        object-fit: cover;
        background: #f8fafc;
    }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 16px 20px;">

            <!-- 1. Header Toolbar with Luxury Brand Gold Buttons & Real Vector SVGs -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Products &amp; Wholesale Hub</h1>
                    <span class="adm-badge" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-weight:700; font-size:11px;">1,240 Total</span>
                    
                    <!-- + Add Product Primary Gold Button -->
                    <a href="/Frontend/Admin/products/add.php" class="wp-button primary" style="background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F; padding:0 14px; height:32px; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35); text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add Product</span>
                    </a>

                    <!-- Secondary Action Buttons with Real SVG Icons -->
                    <a href="/Frontend/Admin/products/imports/" class="wp-button" style="height:32px; padding:0 11px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Import</span>
                    </a>
                    <a href="/Frontend/Admin/products/exports/" class="wp-button" onclick="if(window.exportCurrentTable) window.exportCurrentTable('dt_products_catalog'); return false;" style="height:32px; padding:0 11px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        <span>Export</span>
                    </a>
                    <a href="/Frontend/Admin/products/categories/" class="wp-button" style="height:32px; padding:0 11px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        <span>Categories (16)</span>
                    </a>
                    <a href="/Frontend/Admin/products/attributes/" class="wp-button" style="height:32px; padding:0 11px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line><line x1="1" y1="14" x2="7" y2="14"></line><line x1="9" y1="8" x2="15" y2="8"></line><line x1="17" y1="16" x2="23" y2="16"></line></svg>
                        <span>Attributes</span>
                    </a>
                </div>

                <!-- Dual View Mode Switcher: Table List vs Wholesale Desktop Grid -->
                <div style="display:flex; align-items:center; border:1px solid #c3c4c7; border-radius:4px; overflow:hidden;">
                    <button type="button" class="dt-view-toggle-btn active" id="btnViewTable" onclick="switchProductView('table')">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                        <span>Table List</span>
                    </button>
                    <button type="button" class="dt-view-toggle-btn" id="btnViewGrid" onclick="switchProductView('grid')">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>Wholesale Desktop Grid</span>
                    </button>
                </div>
            </div>

            <!-- 2. B2B Wholesale KPI Metrics Ribbon -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px; margin-bottom:14px;">
                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">ACTIVE B2B DESIGNS</div>
                        <div style="font-size:17px; font-weight:800; color:#181512;">1,240 SKUs</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">B2B CATALOG VALUATION</div>
                        <div style="font-size:17px; font-weight:800; color:#15803D;">₹48.60 Lakhs</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#EFF6FF; border:1px solid #93C5FD; display:flex; align-items:center; justify-content:center; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">SURAT CENTRAL DEPOT</div>
                        <div style="font-size:17px; font-weight:800; color:#1D4ED8;">8,450 Units</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">LOW STOCK REORDERS</div>
                        <div style="font-size:17px; font-weight:800; color:#B45309;">14 Lots</div>
                    </div>
                </div>
            </div>

            <!-- 3. Status Filter Links (.subsubsub) -->
            <ul class="wp-subsubsub" style="margin-bottom:12px;">
                <li><a href="#" class="current" onclick="filterWpProducts(''); return false;">All <span class="count">(1,240)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterWpProducts('Active'); return false;">Published <span class="count">(1,185)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterWpProducts('Draft'); return false;">Draft <span class="count">(14)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterWpProducts('Low Stock'); return false;">Low stock <span class="count">(14)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterWpProducts('Out of Stock'); return false;">Out of stock <span class="count">(41)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterWpProducts('Featured'); return false;">Featured <span class="count">(48)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterWpProducts('Best Seller'); return false;">Best Sellers <span class="count">(32)</span></a> <span class="sep">|</span></li>
                <li><a href="#" onclick="filterWpProducts('New Arrival'); return false;">New Arrivals <span class="count">(64)</span></a></li>
            </ul>

            <!-- 4. Top Toolbar: Bulk Actions, Filter Dropdowns & Rule-Compliant Search Input -->
            <div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                <div class="wp-tablenav-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <select class="wp-select" id="wpBulkActionSelect" style="height:32px; font-size:12px;">
                        <option value="">Bulk actions</option>
                        <option value="edit">Edit Selected</option>
                        <option value="featured">Mark as featured</option>
                        <option value="unfeatured">Remove from featured</option>
                        <option value="trash">Move to Trash</option>
                    </select>
                    <button type="button" class="wp-button" onclick="handleWpBulkAction()" style="height:32px; font-size:12px; font-weight:600; padding:0 12px; display:inline-flex; align-items:center; gap:4px;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Apply</span>
                    </button>

                    <select class="wp-select" id="wpCategoryFilter" onchange="filterWpCategory(this.value)" style="height:32px; font-size:12px;">
                        <option value="">Select a category</option>
                        <option value="Silk Sarees">Silk Sarees (420)</option>
                        <option value="Banarasi Brocade">Banarasi Brocade (280)</option>
                        <option value="Bridal Lehengas">Bridal Lehengas (160)</option>
                        <option value="Designer Kurtis">Designer Kurtis (240)</option>
                        <option value="Dress Materials">Dress Materials (140)</option>
                    </select>

                    <select class="wp-select" id="wpStockFilter" onchange="filterWpStock(this.value)" style="height:32px; font-size:12px;">
                        <option value="">Filter by stock status</option>
                        <option value="In stock">In stock</option>
                        <option value="Low stock">Low stock</option>
                        <option value="Out of stock">Out of stock</option>
                    </select>

                    <select class="wp-select" id="wpBrandFilter" onchange="filterWpBrand(this.value)" style="height:32px; font-size:12px;">
                        <option value="">Filter by brand</option>
                        <option value="DT Signature">DT Signature (680)</option>
                        <option value="Arniya Heritage">Arniya Heritage (420)</option>
                        <option value="DT Couture">DT Couture (140)</option>
                    </select>

                    <button type="button" class="wp-button" onclick="applyWpFilters()" style="height:32px; font-size:12px; font-weight:600; padding:0 12px; display:inline-flex; align-items:center; gap:5px;">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                        <span>Filter</span>
                    </button>
                </div>

                <!-- Mandatory Left-Aligned Search Icon with 1-Tap Clear Button -->
                <div class="wp-search-box" style="display:flex; align-items:center; gap:6px;">
                    <div style="position:relative; display:inline-flex; align-items:center;">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.2" style="position:absolute; left:12px; pointer-events:none;">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" id="wpSearchInput" class="wp-search-input" placeholder="Search products, SKUs..." style="height:32px; padding-left:36px; padding-right:28px; width:220px; font-size:12px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchWpProducts(this.value); toggleSearchClearBtn(this.value)">
                        <span id="wpSearchClearBtn" onclick="clearWpSearch()" style="position:absolute; right:8px; cursor:pointer; color:#8c8f94; font-size:13px; font-weight:700; display:none;" title="Clear search">✕</span>
                    </div>
                    <button type="button" class="wp-button primary" onclick="searchWpProducts(document.getElementById('wpSearchInput').value)" style="height:32px; font-size:12px; font-weight:600; padding:0 12px;">Search</button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- 5A. VIEW MODE: WORDPRESS / WOOCOMMERCE TABLE LIST        -->
            <!-- ======================================================== -->
            <div id="productTableView" class="wp-table-card" style="background:#fff; border:1px solid #c3c4c7; border-radius:6px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <table class="wp-list-table" id="wpProductsTable" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f6f7f7; border-bottom:1px solid #c3c4c7;">
                            <th style="width: 36px; text-align: center; padding:10px 8px;">
                                <input type="checkbox" onchange="toggleWpSelectAll(this)" style="cursor:pointer; width:15px; height:15px;">
                            </th>
                            <th style="width: 54px; padding:10px 8px;">Image</th>
                            <th style="padding:10px 12px;">Product Name</th>
                            <th style="padding:10px 10px;">SKU</th>
                            <th style="padding:10px 10px;">Stock</th>
                            <th style="padding:10px 10px;">Price</th>
                            <th style="padding:10px 10px;">Categories</th>
                            <th style="padding:10px 10px;">Brand</th>
                            <th style="padding:10px 10px;">Rating</th>
                            <th style="text-align: center; width:45px; padding:10px 8px;">★</th>
                            <th style="padding:10px 12px;">Date</th>
                        </tr>
                    </thead>
                    <tbody id="wpProductsTableBody">
                        
                        <!-- Row 1 -->
                        <tr style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                            <td style="text-align: center; padding:10px 8px;">
                                <input type="checkbox" class="wp-row-check" style="cursor:pointer; width:15px; height:15px;">
                            </td>
                            <td style="padding:10px 8px;">
                                <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="wp-thumb-img" alt="Saree" style="width:42px; height:42px; object-fit:cover; border-radius:4px; border:1px solid #e2e8f0; display:block;">
                            </td>
                            <td style="padding:10px 12px;">
                                <a href="/Frontend/Admin/products/edit.php?id=101" class="wp-row-title" style="font-weight:700; color:#181512; text-decoration:none; font-size:13px;">Kanjivaram Pure Silk Gold Zari Saree</a>
                                <div class="wp-row-actions" style="margin-top:4px; font-size:11.5px;">
                                    <a href="/Frontend/Admin/products/edit.php?id=101" style="color:#8A681F; font-weight:600;">Edit</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="/Frontend/Admin/products/duplicate.php?id=101" style="color:#2271b1;">Duplicate</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="/Frontend/Admin/products/view.php?id=101" style="color:#2271b1;">View</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="#" onclick="window.shareProductWhatsApp(101); return false;" style="color:#15803D; font-weight:700;">WhatsApp</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="#" class="trash" onclick="if(window.showToast) window.showToast('Moved to Trash'); return false;" style="color:#b32d2e;">Trash</a>
                                </div>
                            </td>
                            <td style="padding:10px 10px;"><code style="background:#f0f0f1; padding:2px 6px; border-radius:3px; font-size:12px;">KLN-SR-111</code></td>
                            <td style="padding:10px 10px;">
                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px; display:inline-flex; align-items:center; gap:4px;">
                                    <span style="width:6px; height:6px; border-radius:50%; background:#16a34a; display:inline-block;"></span>
                                    <span>In stock (45)</span>
                                </span>
                            </td>
                            <td style="padding:10px 10px;">
                                <strong style="font-size:13px; color:#181512;">₹4,490</strong><br>
                                <small style="color:#8A681F; font-size:11px; font-weight:600;">Wholesale: ₹2,850</small>
                            </td>
                            <td style="padding:10px 10px;"><a href="/Frontend/Admin/products/categories/view.php?id=1" style="color:#8A681F; font-weight:600; text-decoration:none;">Silk Sarees</a></td>
                            <td style="padding:10px 10px;"><strong>DT Signature</strong></td>
                            <td style="padding:10px 10px;"><span style="color:#D4AF37; font-weight:700;">5.0 ★</span> <span style="color:#646970; font-size:11px;">(128)</span></td>
                            <td style="text-align: center; padding:10px 8px;">
                                <button type="button" class="wp-star-btn active" title="Toggle Featured" onclick="this.classList.toggle('active')" style="background:none; border:none; cursor:pointer; font-size:16px; color:#D4AF37;">★</button>
                            </td>
                            <td style="padding:10px 12px; font-size:12px;">
                                <span style="color:#15803D; font-weight:600;">Published</span><br>
                                <small style="color:#646970;">2026/08/20</small>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                            <td style="text-align: center; padding:10px 8px;">
                                <input type="checkbox" class="wp-row-check" style="cursor:pointer; width:15px; height:15px;">
                            </td>
                            <td style="padding:10px 8px;">
                                <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" class="wp-thumb-img" alt="Saree" style="width:42px; height:42px; object-fit:cover; border-radius:4px; border:1px solid #e2e8f0; display:block;">
                            </td>
                            <td style="padding:10px 12px;">
                                <a href="/Frontend/Admin/products/edit.php?id=102" class="wp-row-title" style="font-weight:700; color:#181512; text-decoration:none; font-size:13px;">Banarasi Royal Brocade Weave Saree</a>
                                <div class="wp-row-actions" style="margin-top:4px; font-size:11.5px;">
                                    <a href="/Frontend/Admin/products/edit.php?id=102" style="color:#8A681F; font-weight:600;">Edit</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="/Frontend/Admin/products/duplicate.php?id=102" style="color:#2271b1;">Duplicate</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="/Frontend/Admin/products/view.php?id=102" style="color:#2271b1;">View</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="#" onclick="window.shareProductWhatsApp(102); return false;" style="color:#15803D; font-weight:700;">WhatsApp</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="#" class="trash" onclick="if(window.showToast) window.showToast('Moved to Trash'); return false;" style="color:#b32d2e;">Trash</a>
                                </div>
                            </td>
                            <td style="padding:10px 10px;"><code style="background:#f0f0f1; padding:2px 6px; border-radius:3px; font-size:12px;">BNR-SR-204</code></td>
                            <td style="padding:10px 10px;">
                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px; display:inline-flex; align-items:center; gap:4px;">
                                    <span style="width:6px; height:6px; border-radius:50%; background:#16a34a; display:inline-block;"></span>
                                    <span>In stock (28)</span>
                                </span>
                            </td>
                            <td style="padding:10px 10px;">
                                <strong style="font-size:13px; color:#181512;">₹4,990</strong><br>
                                <small style="color:#8A681F; font-size:11px; font-weight:600;">Wholesale: ₹3,200</small>
                            </td>
                            <td style="padding:10px 10px;"><a href="/Frontend/Admin/products/categories/view.php?id=2" style="color:#8A681F; font-weight:600; text-decoration:none;">Banarasi Brocade</a></td>
                            <td style="padding:10px 10px;"><strong>Arniya Heritage</strong></td>
                            <td style="padding:10px 10px;"><span style="color:#D4AF37; font-weight:700;">4.9 ★</span> <span style="color:#646970; font-size:11px;">(94)</span></td>
                            <td style="text-align: center; padding:10px 8px;">
                                <button type="button" class="wp-star-btn active" title="Toggle Featured" onclick="this.classList.toggle('active')" style="background:none; border:none; cursor:pointer; font-size:16px; color:#D4AF37;">★</button>
                            </td>
                            <td style="padding:10px 12px; font-size:12px;">
                                <span style="color:#15803D; font-weight:600;">Published</span><br>
                                <small style="color:#646970;">2026/08/19</small>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                            <td style="text-align: center; padding:10px 8px;">
                                <input type="checkbox" class="wp-row-check" style="cursor:pointer; width:15px; height:15px;">
                            </td>
                            <td style="padding:10px 8px;">
                                <img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" class="wp-thumb-img" alt="Lehenga" style="width:42px; height:42px; object-fit:cover; border-radius:4px; border:1px solid #e2e8f0; display:block;">
                            </td>
                            <td style="padding:10px 12px;">
                                <a href="/Frontend/Admin/products/edit.php?id=103" class="wp-row-title" style="font-weight:700; color:#181512; text-decoration:none; font-size:13px;">Crimson Bridal Handcrafted Zardosi Lehenga</a>
                                <div class="wp-row-actions" style="margin-top:4px; font-size:11.5px;">
                                    <a href="/Frontend/Admin/products/edit.php?id=103" style="color:#8A681F; font-weight:600;">Edit</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="/Frontend/Admin/products/duplicate.php?id=103" style="color:#2271b1;">Duplicate</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="/Frontend/Admin/products/view.php?id=103" style="color:#2271b1;">View</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="#" onclick="window.shareProductWhatsApp(103); return false;" style="color:#15803D; font-weight:700;">WhatsApp</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="#" class="trash" onclick="if(window.showToast) window.showToast('Moved to Trash'); return false;" style="color:#b32d2e;">Trash</a>
                                </div>
                            </td>
                            <td style="padding:10px 10px;"><code style="background:#f0f0f1; padding:2px 6px; border-radius:3px; font-size:12px;">BRD-LH-902</code></td>
                            <td style="padding:10px 10px;">
                                <span class="adm-badge" style="background:#FEF3C7; color:#B45309; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px; display:inline-flex; align-items:center; gap:4px;">
                                    <span style="width:6px; height:6px; border-radius:50%; background:#d97706; display:inline-block;"></span>
                                    <span>Low stock (4)</span>
                                </span>
                            </td>
                            <td style="padding:10px 10px;">
                                <strong style="font-size:13px; color:#181512;">₹16,490</strong><br>
                                <small style="color:#8A681F; font-size:11px; font-weight:600;">Wholesale: ₹11,500</small>
                            </td>
                            <td style="padding:10px 10px;"><a href="/Frontend/Admin/products/categories/view.php?id=3" style="color:#8A681F; font-weight:600; text-decoration:none;">Bridal Lehengas</a></td>
                            <td style="padding:10px 10px;"><strong>DT Couture</strong></td>
                            <td style="padding:10px 10px;"><span style="color:#D4AF37; font-weight:700;">5.0 ★</span> <span style="color:#646970; font-size:11px;">(42)</span></td>
                            <td style="text-align: center; padding:10px 8px;">
                                <button type="button" class="wp-star-btn active" title="Toggle Featured" onclick="this.classList.toggle('active')" style="background:none; border:none; cursor:pointer; font-size:16px; color:#D4AF37;">★</button>
                            </td>
                            <td style="padding:10px 12px; font-size:12px;">
                                <span style="color:#15803D; font-weight:600;">Published</span><br>
                                <small style="color:#646970;">2026/08/18</small>
                            </td>
                        </tr>

                        <!-- Row 4 -->
                        <tr style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                            <td style="text-align: center; padding:10px 8px;">
                                <input type="checkbox" class="wp-row-check" style="cursor:pointer; width:15px; height:15px;">
                            </td>
                            <td style="padding:10px 8px;">
                                <img src="/Shared/Asset/images/product4.png" onerror="this.src='/Frontend/Shop/Asset/images/product4.png';" class="wp-thumb-img" alt="Kurti" style="width:42px; height:42px; object-fit:cover; border-radius:4px; border:1px solid #e2e8f0; display:block;">
                            </td>
                            <td style="padding:10px 12px;">
                                <a href="/Frontend/Admin/products/edit.php?id=104" class="wp-row-title" style="font-weight:700; color:#181512; text-decoration:none; font-size:13px;">Chanderi Foil Printed Festive Kurti Set</a>
                                <div class="wp-row-actions" style="margin-top:4px; font-size:11.5px;">
                                    <a href="/Frontend/Admin/products/edit.php?id=104" style="color:#8A681F; font-weight:600;">Edit</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="/Frontend/Admin/products/duplicate.php?id=104" style="color:#2271b1;">Duplicate</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="/Frontend/Admin/products/view.php?id=104" style="color:#2271b1;">View</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="#" onclick="window.shareProductWhatsApp(104); return false;" style="color:#15803D; font-weight:700;">WhatsApp</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="#" class="trash" onclick="if(window.showToast) window.showToast('Moved to Trash'); return false;" style="color:#b32d2e;">Trash</a>
                                </div>
                            </td>
                            <td style="padding:10px 10px;"><code style="background:#f0f0f1; padding:2px 6px; border-radius:3px; font-size:12px;">KRT-CH-401</code></td>
                            <td style="padding:10px 10px;">
                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px; display:inline-flex; align-items:center; gap:4px;">
                                    <span style="width:6px; height:6px; border-radius:50%; background:#16a34a; display:inline-block;"></span>
                                    <span>In stock (62)</span>
                                </span>
                            </td>
                            <td style="padding:10px 10px;">
                                <strong style="font-size:13px; color:#181512;">₹2,290</strong><br>
                                <small style="color:#8A681F; font-size:11px; font-weight:600;">Wholesale: ₹1,450</small>
                            </td>
                            <td style="padding:10px 10px;"><a href="/Frontend/Admin/products/categories/view.php?id=4" style="color:#8A681F; font-weight:600; text-decoration:none;">Designer Kurtis</a></td>
                            <td style="padding:10px 10px;"><strong>DT Signature</strong></td>
                            <td style="padding:10px 10px;"><span style="color:#D4AF37; font-weight:700;">4.8 ★</span> <span style="color:#646970; font-size:11px;">(68)</span></td>
                            <td style="text-align: center; padding:10px 8px;">
                                <button type="button" class="wp-star-btn active" title="Toggle Featured" onclick="this.classList.toggle('active')" style="background:none; border:none; cursor:pointer; font-size:16px; color:#D4AF37;">★</button>
                            </td>
                            <td style="padding:10px 12px; font-size:12px;">
                                <span style="color:#15803D; font-weight:600;">Published</span><br>
                                <small style="color:#646970;">2026/08/17</small>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- ======================================================== -->
            <!-- 5B. VIEW MODE: WHOLESALE DESKTOP GRID CARDS              -->
            <!-- ======================================================== -->
            <div id="productGridView" class="dt-ws-grid" style="display:none;">
                
                <!-- WS Card 1 -->
                <div class="dt-ws-card">
                    <div style="position:relative;">
                        <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="dt-ws-card-img" alt="Kanjivaram Saree">
                        <span class="adm-badge" style="position:absolute; top:8px; left:8px; background:#8A681F; color:#fff; font-weight:700; font-size:10px;">✨ Best Seller</span>
                        <span class="adm-badge" style="position:absolute; top:8px; right:8px; background:rgba(255,255,255,0.9); color:#15803D; font-weight:800; font-size:10.5px;">MOQ: 6 Pcs</span>
                    </div>
                    <div style="padding:12px 14px; flex:1; display:flex; flex-direction:column;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:6px;">
                            <span style="font-size:11px; font-weight:700; color:#8A681F;">SILK SAREES</span>
                            <code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">KLN-SR-111</code>
                        </div>
                        <h4 style="margin:4px 0 8px 0; font-size:14px; font-weight:700; color:#181512; line-height:1.3;">Kanjivaram Pure Silk Gold Zari Saree</h4>
                        
                        <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.4); border-radius:6px; padding:8px 10px; margin-bottom:10px;">
                            <div style="display:flex; justify-content:space-between; align-items:baseline;">
                                <div>
                                    <small style="color:#5A4210; font-size:10px; font-weight:700;">WHOLESALE RATE</small>
                                    <div style="font-size:16px; font-weight:800; color:#181512;">₹2,850 <small style="font-size:11px; font-weight:600; color:#646970;">/ pc</small></div>
                                </div>
                                <div style="text-align:right;">
                                    <small style="color:#646970; font-size:10px;">Retail MRP</small>
                                    <div style="font-size:13px; font-weight:600; color:#8c8f94; text-decoration:line-through;">₹4,490</div>
                                </div>
                            </div>
                            <div style="margin-top:4px; font-size:10.5px; color:#15803D; font-weight:700;">⚡ 36% Resale Margin (+₹1,640/pc)</div>
                        </div>

                        <div style="margin-top:auto; display:flex; gap:6px;">
                            <a href="/Frontend/Admin/products/edit.php?id=101" class="wp-button" style="flex:1; height:30px; font-size:11.5px; font-weight:600; justify-content:center; text-decoration:none;">✏️ Edit</a>
                            <button type="button" class="wp-button primary" onclick="window.shareProductWhatsApp(101)" style="flex:1; height:30px; font-size:11.5px; font-weight:700; background:#15803D; border-color:#15803D; color:#fff; justify-content:center;">💬 WhatsApp</button>
                        </div>
                    </div>
                </div>

                <!-- WS Card 2 -->
                <div class="dt-ws-card">
                    <div style="position:relative;">
                        <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" class="dt-ws-card-img" alt="Banarasi Saree">
                        <span class="adm-badge" style="position:absolute; top:8px; left:8px; background:#D4AF37; color:#181512; font-weight:800; font-size:10px;">🔥 New Arrival</span>
                        <span class="adm-badge" style="position:absolute; top:8px; right:8px; background:rgba(255,255,255,0.9); color:#15803D; font-weight:800; font-size:10.5px;">MOQ: 8 Pcs</span>
                    </div>
                    <div style="padding:12px 14px; flex:1; display:flex; flex-direction:column;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:6px;">
                            <span style="font-size:11px; font-weight:700; color:#8A681F;">BANARASI BROCADE</span>
                            <code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">BNR-SR-204</code>
                        </div>
                        <h4 style="margin:4px 0 8px 0; font-size:14px; font-weight:700; color:#181512; line-height:1.3;">Banarasi Royal Brocade Weave Saree</h4>
                        
                        <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.4); border-radius:6px; padding:8px 10px; margin-bottom:10px;">
                            <div style="display:flex; justify-content:space-between; align-items:baseline;">
                                <div>
                                    <small style="color:#5A4210; font-size:10px; font-weight:700;">WHOLESALE RATE</small>
                                    <div style="font-size:16px; font-weight:800; color:#181512;">₹3,200 <small style="font-size:11px; font-weight:600; color:#646970;">/ pc</small></div>
                                </div>
                                <div style="text-align:right;">
                                    <small style="color:#646970; font-size:10px;">Retail MRP</small>
                                    <div style="font-size:13px; font-weight:600; color:#8c8f94; text-decoration:line-through;">₹4,990</div>
                                </div>
                            </div>
                            <div style="margin-top:4px; font-size:10.5px; color:#15803D; font-weight:700;">⚡ 35% Resale Margin (+₹1,790/pc)</div>
                        </div>

                        <div style="margin-top:auto; display:flex; gap:6px;">
                            <a href="/Frontend/Admin/products/edit.php?id=102" class="wp-button" style="flex:1; height:30px; font-size:11.5px; font-weight:600; justify-content:center; text-decoration:none;">✏️ Edit</a>
                            <button type="button" class="wp-button primary" onclick="window.shareProductWhatsApp(102)" style="flex:1; height:30px; font-size:11.5px; font-weight:700; background:#15803D; border-color:#15803D; color:#fff; justify-content:center;">💬 WhatsApp</button>
                        </div>
                    </div>
                </div>

                <!-- WS Card 3 -->
                <div class="dt-ws-card">
                    <div style="position:relative;">
                        <img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" class="dt-ws-card-img" alt="Bridal Lehenga">
                        <span class="adm-badge" style="position:absolute; top:8px; left:8px; background:#B91C1C; color:#fff; font-weight:700; font-size:10px;">👑 Luxury Bridal</span>
                        <span class="adm-badge" style="position:absolute; top:8px; right:8px; background:rgba(255,255,255,0.9); color:#B45309; font-weight:800; font-size:10.5px;">MOQ: 2 Pcs</span>
                    </div>
                    <div style="padding:12px 14px; flex:1; display:flex; flex-direction:column;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:6px;">
                            <span style="font-size:11px; font-weight:700; color:#8A681F;">BRIDAL LEHENGAS</span>
                            <code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">BRD-LH-902</code>
                        </div>
                        <h4 style="margin:4px 0 8px 0; font-size:14px; font-weight:700; color:#181512; line-height:1.3;">Crimson Bridal Handcrafted Zardosi Lehenga</h4>
                        
                        <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.4); border-radius:6px; padding:8px 10px; margin-bottom:10px;">
                            <div style="display:flex; justify-content:space-between; align-items:baseline;">
                                <div>
                                    <small style="color:#5A4210; font-size:10px; font-weight:700;">WHOLESALE RATE</small>
                                    <div style="font-size:16px; font-weight:800; color:#181512;">₹11,500 <small style="font-size:11px; font-weight:600; color:#646970;">/ pc</small></div>
                                </div>
                                <div style="text-align:right;">
                                    <small style="color:#646970; font-size:10px;">Retail MRP</small>
                                    <div style="font-size:13px; font-weight:600; color:#8c8f94; text-decoration:line-through;">₹16,490</div>
                                </div>
                            </div>
                            <div style="margin-top:4px; font-size:10.5px; color:#15803D; font-weight:700;">⚡ 30% Resale Margin (+₹4,990/pc)</div>
                        </div>

                        <div style="margin-top:auto; display:flex; gap:6px;">
                            <a href="/Frontend/Admin/products/edit.php?id=103" class="wp-button" style="flex:1; height:30px; font-size:11.5px; font-weight:600; justify-content:center; text-decoration:none;">✏️ Edit</a>
                            <button type="button" class="wp-button primary" onclick="window.shareProductWhatsApp(103)" style="flex:1; height:30px; font-size:11.5px; font-weight:700; background:#15803D; border-color:#15803D; color:#fff; justify-content:center;">💬 WhatsApp</button>
                        </div>
                    </div>
                </div>

                <!-- WS Card 4 -->
                <div class="dt-ws-card">
                    <div style="position:relative;">
                        <img src="/Shared/Asset/images/product4.png" onerror="this.src='/Frontend/Shop/Asset/images/product4.png';" class="dt-ws-card-img" alt="Festive Kurti">
                        <span class="adm-badge" style="position:absolute; top:8px; left:8px; background:#0F766E; color:#fff; font-weight:700; font-size:10px;">⚡ Super Value</span>
                        <span class="adm-badge" style="position:absolute; top:8px; right:8px; background:rgba(255,255,255,0.9); color:#15803D; font-weight:800; font-size:10.5px;">MOQ: 12 Pcs</span>
                    </div>
                    <div style="padding:12px 14px; flex:1; display:flex; flex-direction:column;">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:6px;">
                            <span style="font-size:11px; font-weight:700; color:#8A681F;">DESIGNER KURTIS</span>
                            <code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">KRT-CH-401</code>
                        </div>
                        <h4 style="margin:4px 0 8px 0; font-size:14px; font-weight:700; color:#181512; line-height:1.3;">Chanderi Foil Printed Festive Kurti Set</h4>
                        
                        <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.4); border-radius:6px; padding:8px 10px; margin-bottom:10px;">
                            <div style="display:flex; justify-content:space-between; align-items:baseline;">
                                <div>
                                    <small style="color:#5A4210; font-size:10px; font-weight:700;">WHOLESALE RATE</small>
                                    <div style="font-size:16px; font-weight:800; color:#181512;">₹1,450 <small style="font-size:11px; font-weight:600; color:#646970;">/ pc</small></div>
                                </div>
                                <div style="text-align:right;">
                                    <small style="color:#646970; font-size:10px;">Retail MRP</small>
                                    <div style="font-size:13px; font-weight:600; color:#8c8f94; text-decoration:line-through;">₹2,290</div>
                                </div>
                            </div>
                            <div style="margin-top:4px; font-size:10.5px; color:#15803D; font-weight:700;">⚡ 37% Resale Margin (+₹840/pc)</div>
                        </div>

                        <div style="margin-top:auto; display:flex; gap:6px;">
                            <a href="/Frontend/Admin/products/edit.php?id=104" class="wp-button" style="flex:1; height:30px; font-size:11.5px; font-weight:600; justify-content:center; text-decoration:none;">✏️ Edit</a>
                            <button type="button" class="wp-button primary" onclick="window.shareProductWhatsApp(104)" style="flex:1; height:30px; font-size:11.5px; font-weight:700; background:#15803D; border-color:#15803D; color:#fff; justify-content:center;">💬 WhatsApp</button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- 6. Bottom Toolbar: Bulk Actions & Pagination -->
            <div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-top:14px;">
                <div class="wp-tablenav-actions" style="display:flex; align-items:center; gap:8px;">
                    <select class="wp-select" id="wpBulkActionSelectBottom" style="height:32px; font-size:12px;">
                        <option value="">Bulk actions</option>
                        <option value="edit">Edit Selected</option>
                        <option value="trash">Move to Trash</option>
                    </select>
                    <button type="button" class="wp-button" onclick="handleWpBulkActionBottom()" style="height:32px; font-size:12px; font-weight:600; padding:0 12px;">Apply</button>
                </div>

                <div class="wp-pagination" style="display:flex; align-items:center; gap:6px; font-size:12px;">
                    <span style="color:#646970; font-weight:600; margin-right:6px;">1,240 items</span>
                    <button type="button" class="wp-button" style="height:28px; width:28px; padding:0; display:flex; align-items:center; justify-content:center;" disabled>&laquo;</button>
                    <button type="button" class="wp-button" style="height:28px; width:28px; padding:0; display:flex; align-items:center; justify-content:center;" disabled>&lsaquo;</button>
                    <button type="button" class="wp-button" style="height:28px; width:28px; padding:0; display:flex; align-items:center; justify-content:center; background:#8A681F; color:#fff; border-color:#8A681F; font-weight:700;">1</button>
                    <button type="button" class="wp-button" style="height:28px; width:28px; padding:0; display:flex; align-items:center; justify-content:center;">2</button>
                    <button type="button" class="wp-button" style="height:28px; width:28px; padding:0; display:flex; align-items:center; justify-content:center;">3</button>
                    <span style="color:#8c8f94; padding:0 2px;">…</span>
                    <button type="button" class="wp-button" style="height:28px; width:28px; padding:0; display:flex; align-items:center; justify-content:center;">50</button>
                    <button type="button" class="wp-button" style="height:28px; width:28px; padding:0; display:flex; align-items:center; justify-content:center;">&rsaquo;</button>
                    <button type="button" class="wp-button" style="height:28px; width:28px; padding:0; display:flex; align-items:center; justify-content:center;">&raquo;</button>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
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
        if (typeof window.showToast === 'function') window.showToast('🔲 Switched to Wholesale Desktop Grid View');
    } else {
        if (table) table.style.display = 'block';
        if (grid) grid.style.display = 'none';
        if (btnTable) btnTable.classList.add('active');
        if (btnGrid) btnGrid.classList.remove('active');
        if (typeof window.showToast === 'function') window.showToast('📋 Switched to Table List View');
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

function filterWpProducts(status) {
    const links = document.querySelectorAll('.wp-subsubsub a');
    links.forEach(l => l.classList.remove('current'));
    if (event && event.target) {
        const targetA = event.target.closest('a');
        if (targetA) targetA.classList.add('current');
    }

    const rows = document.querySelectorAll('#wpProductsTableBody tr');
    const cards = document.querySelectorAll('.dt-ws-card');

    rows.forEach(r => {
        if (!status) {
            r.style.display = '';
        } else {
            const txt = r.textContent.toLowerCase();
            r.style.display = txt.includes(status.toLowerCase()) ? '' : 'none';
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
}

function filterWpCategory(cat) {
    const rows = document.querySelectorAll('#wpProductsTableBody tr');
    const cards = document.querySelectorAll('.dt-ws-card');

    rows.forEach(r => {
        if (!cat) {
            r.style.display = '';
        } else {
            const txt = r.textContent.toLowerCase();
            r.style.display = txt.includes(cat.toLowerCase()) ? '' : 'none';
        }
    });

    cards.forEach(c => {
        if (!cat) {
            c.style.display = 'flex';
        } else {
            const txt = c.textContent.toLowerCase();
            c.style.display = txt.includes(cat.toLowerCase()) ? 'flex' : 'none';
        }
    });
}

function filterWpStock(stock) {
    const rows = document.querySelectorAll('#wpProductsTableBody tr');
    rows.forEach(r => {
        if (!stock) {
            r.style.display = '';
        } else {
            const txt = r.textContent.toLowerCase();
            r.style.display = txt.includes(stock.toLowerCase()) ? '' : 'none';
        }
    });
}

function filterWpBrand(brand) {
    const rows = document.querySelectorAll('#wpProductsTableBody tr');
    rows.forEach(r => {
        if (!brand) {
            r.style.display = '';
        } else {
            const txt = r.textContent.toLowerCase();
            r.style.display = txt.includes(brand.toLowerCase()) ? '' : 'none';
        }
    });
}

function applyWpFilters() {
    const cat = document.getElementById('wpCategoryFilter')?.value || '';
    const stock = document.getElementById('wpStockFilter')?.value || '';
    const brand = document.getElementById('wpBrandFilter')?.value || '';
    
    const rows = document.querySelectorAll('#wpProductsTableBody tr');
    rows.forEach(r => {
        const txt = r.textContent.toLowerCase();
        const matchesCat = !cat || txt.includes(cat.toLowerCase());
        const matchesStock = !stock || txt.includes(stock.toLowerCase());
        const matchesBrand = !brand || txt.includes(brand.toLowerCase());
        r.style.display = (matchesCat && matchesStock && matchesBrand) ? '' : 'none';
    });

    if (typeof window.showToast === 'function') window.showToast('🔍 Filters applied!');
}

function handleWpBulkAction() {
    const action = document.getElementById('wpBulkActionSelect')?.value;
    if (!action) return;
    const selected = document.querySelectorAll('.wp-row-check:checked');
    if (selected.length === 0) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Select at least one product');
        return;
    }
    if (typeof window.showToast === 'function') window.showToast(`Bulk action "${action}" applied to ${selected.length} items!`);
}

function handleWpBulkActionBottom() {
    const action = document.getElementById('wpBulkActionSelectBottom')?.value;
    if (!action) return;
    const selected = document.querySelectorAll('.wp-row-check:checked');
    if (selected.length === 0) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Select at least one product');
        return;
    }
    if (typeof window.showToast === 'function') window.showToast(`Bulk action "${action}" applied to ${selected.length} items!`);
}

window.shareProductWhatsApp = function(id) {
    const text = encodeURIComponent(`Hello DT Brand's! I would like to inquire about Wholesale Lot for Product ID: #${id}. https://jaihanumantex.in/Frontend/Admin/products/view.php?id=${id}`);
    window.open(`https://wa.me/919999999999?text=${text}`, '_blank');
};
</script>
</body>
</html>
