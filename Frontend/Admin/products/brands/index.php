<?php
/**
 * brands/index.php — DT Brand's House Labels & Brand Suite (Wholesale Dashboard & Luxury Shop Standard)
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Brands & House Labels";
$active_nav = "products";
$active_subnav = "brands";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brands &amp; House Labels ‹ DT Brand's Admin</title>
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
    .dt-brand-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, #181512, #3D342A);
        color: #D4AF37;
        font-family: 'Cinzel', serif;
        font-weight: 800;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #D4AF37;
        box-shadow: 0 2px 8px rgba(212,175,55,0.25);
        flex-shrink: 0;
        overflow: hidden;
    }
    .dt-brand-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .dt-btn-action-pill {
        height: 28px;
        padding: 0 10px;
        font-size: 11.5px;
        font-weight: 700;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .dt-btn-action-pill:hover {
        transform: translateY(-1px);
    }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 16px 20px;">

            <!-- 1. Header Toolbar with Luxury Brand Gold Buttons -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Brands &amp; House Labels</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:3px 8px;">4 Luxury Labels</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <a href="/Frontend/Admin/products/" class="wp-button" style="height:32px; padding:0 11px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Products (1,240)</span>
                    </a>
                    <a href="/Frontend/Admin/products/categories/" class="wp-button" style="height:32px; padding:0 11px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        <span>Categories (16)</span>
                    </a>
                    <a href="/Frontend/Admin/products/attributes/" class="wp-button" style="height:32px; padding:0 11px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"></line><line x1="4" y1="10" x2="4" y2="3"></line><line x1="12" y1="21" x2="12" y2="12"></line><line x1="12" y1="8" x2="12" y2="3"></line><line x1="20" y1="21" x2="20" y2="16"></line><line x1="20" y1="12" x2="20" y2="3"></line></svg>
                        <span>Attributes</span>
                    </a>
                    <button type="button" class="wp-button primary" onclick="openAddBrandModal()" style="background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F; padding:0 14px; height:32px; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add Brand</span>
                    </button>
                </div>
            </div>

            <!-- 2. B2B Wholesale KPI Metrics Ribbon -->
            <div class="dt-kpi-ribbon">
                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">ACTIVE HOUSE LABELS</div>
                        <div style="font-size:17px; font-weight:800; color:#181512;">4 Luxury Brands</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">CATALOG ASSIGNED SKUS</div>
                        <div style="font-size:17px; font-weight:800; color:#15803D;">1,240 Products</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#EFF6FF; border:1px solid #93C5FD; display:flex; align-items:center; justify-content:center; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">B2B CATALOG VALUATION</div>
                        <div style="font-size:17px; font-weight:800; color:#1D4ED8;">₹48.60 Lakhs</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">SURAT CENTRAL READY STOCK</div>
                        <div style="font-size:17px; font-weight:800; color:#B45309;">8,450 Units</div>
                    </div>
                </div>
            </div>

            <!-- 3. Top Toolbar: Bulk Actions & Rule-Compliant Search Input -->
            <div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                <div class="wp-tablenav-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <select class="wp-select" id="brandBulkActionSelect" style="height:34px; font-size:12px; min-width:140px;">
                        <option value="">Bulk actions</option>
                        <option value="active">Mark as Active</option>
                        <option value="delete">Move to Trash</option>
                    </select>
                    <button type="button" class="wp-button" onclick="handleBrandBulkAction()" style="height:34px; font-size:12px; font-weight:700; padding:0 12px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Apply</button>

                    <select class="wp-select" id="brandTierFilter" onchange="filterBrandByTier(this.value)" style="height:34px; font-size:12px; min-width:160px;">
                        <option value="">Filter by Brand Tier</option>
                        <option value="Flagship">Primary Flagship</option>
                        <option value="Heritage">Heritage Brocade</option>
                        <option value="Bridal">Bridal Luxury</option>
                        <option value="Volume">Mill Volume B2B</option>
                    </select>
                </div>

                <!-- Mandatory Left-Aligned Search Icon with 1-Tap Clear Button -->
                <div class="wp-search-box" style="display:flex; align-items:center; gap:6px;">
                    <div style="position:relative; display:inline-flex; align-items:center;">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.2" style="position:absolute; left:12px; pointer-events:none;">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" id="brandSearchInput" class="wp-search-input" placeholder="Search brands, house labels..." style="height:34px; padding-left:36px; padding-right:28px; width:220px; font-size:12px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchBrands(this.value); toggleBrandSearchClearBtn(this.value)">
                        <span id="brandSearchClearBtn" onclick="clearBrandSearch()" style="position:absolute; right:8px; cursor:pointer; color:#8c8f94; font-size:13px; font-weight:700; display:none;" title="Clear search">✕</span>
                    </div>
                    <button type="button" class="wp-button primary" onclick="searchBrands(document.getElementById('brandSearchInput').value)" style="height:34px; font-size:12px; font-weight:800; padding:0 14px; background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; border:1px solid #8A681F;">Search</button>
                </div>
            </div>

            <!-- 4. High-Craft Brands Table Card -->
            <div class="wp-table-card" style="background:#fff; border:1px solid #c3c4c7; border-radius:6px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <table class="wp-list-table" id="brandsTable" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f6f7f7; border-bottom:1px solid #c3c4c7;">
                            <th style="width: 36px; text-align: center; padding:10px 8px;">
                                <input type="checkbox" onchange="toggleSelectAllBrands(this)" style="cursor:pointer; width:15px; height:15px;">
                            </th>
                            <th style="width: 60px; padding:10px 10px;">Emblem</th>
                            <th style="padding:10px 12px;">House Label &amp; Description</th>
                            <th style="padding:10px 10px;">Brand Tier</th>
                            <th style="padding:10px 10px;">Catalog SKUs</th>
                            <th style="padding:10px 10px;">B2B Valuation</th>
                            <th style="padding:10px 10px;">Status</th>
                            <th style="width: 160px; text-align: right; padding:10px 12px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="brandsTableBody">

                        <!-- Brand 1: DT Signature -->
                        <tr id="brand-row-1" style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                            <td style="text-align: center; padding:12px 8px;">
                                <input type="checkbox" class="brand-row-check" style="cursor:pointer; width:15px; height:15px;">
                            </td>
                            <td style="padding:12px 10px;">
                                <div class="dt-brand-avatar" id="brand-avatar-1">DT</div>
                            </td>
                            <td style="padding:12px 12px;">
                                <strong style="font-size:14px; color:#181512; display:block;" id="brand-title-1">DT Signature</strong>
                                <span style="font-size:12px; color:#646970;" id="brand-tagline-1">Primary Flagship Handloom &amp; Pure Silk Sarees Collection</span>
                            </td>
                            <td style="padding:12px 10px;">
                                <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:3px 8px;" id="brand-tier-1">👑 Primary Flagship</span>
                            </td>
                            <td style="padding:12px 10px;">
                                <a href="/Frontend/Admin/products/?brand=DT+Signature" style="text-decoration:none;">
                                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:800; font-size:12px; padding:3px 8px; border-radius:10px;">680 SKUs</span>
                                </a>
                            </td>
                            <td style="padding:12px 10px;">
                                <strong style="color:#181512; font-size:13px;">₹28.40 Lakhs</strong>
                            </td>
                            <td style="padding:12px 10px;">
                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px;">🟢 Active &amp; Live</span>
                            </td>
                            <td style="padding:12px 12px; text-align:right;">
                                <div style="display:flex; gap:5px; justify-content:flex-end;">
                                    <button type="button" class="dt-btn-action-pill" onclick="openEditBrandModal(1, 'DT Signature', 'Primary Flagship', 'Primary Flagship Handloom & Pure Silk Sarees Collection', 'DT')" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        <span>Edit</span>
                                    </button>
                                    <a href="/Frontend/Shop/shop.php?brand=DT+Signature" target="_blank" class="dt-btn-action-pill" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#1D4ED8" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        <span>View</span>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Brand 2: Arniya Heritage -->
                        <tr id="brand-row-2" style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                            <td style="text-align: center; padding:12px 8px;">
                                <input type="checkbox" class="brand-row-check" style="cursor:pointer; width:15px; height:15px;">
                            </td>
                            <td style="padding:12px 10px;">
                                <div class="dt-brand-avatar" id="brand-avatar-2" style="background:linear-gradient(135deg, #1e3a8a, #172554); border-color:#60a5fa; color:#93c5fd;">AH</div>
                            </td>
                            <td style="padding:12px 12px;">
                                <strong style="font-size:14px; color:#181512; display:block;" id="brand-title-2">Arniya Heritage</strong>
                                <span style="font-size:12px; color:#646970;" id="brand-tagline-2">Authentic Varanasi Brocades &amp; Traditional Katan Silks</span>
                            </td>
                            <td style="padding:12px 10px;">
                                <span class="adm-badge" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; font-weight:700; font-size:11px; padding:3px 8px;" id="brand-tier-2">💎 Heritage Brocade</span>
                            </td>
                            <td style="padding:12px 10px;">
                                <a href="/Frontend/Admin/products/?brand=Arniya+Heritage" style="text-decoration:none;">
                                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:800; font-size:12px; padding:3px 8px; border-radius:10px;">420 SKUs</span>
                                </a>
                            </td>
                            <td style="padding:12px 10px;">
                                <strong style="color:#181512; font-size:13px;">₹14.20 Lakhs</strong>
                            </td>
                            <td style="padding:12px 10px;">
                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px;">🟢 Active &amp; Live</span>
                            </td>
                            <td style="padding:12px 12px; text-align:right;">
                                <div style="display:flex; gap:5px; justify-content:flex-end;">
                                    <button type="button" class="dt-btn-action-pill" onclick="openEditBrandModal(2, 'Arniya Heritage', 'Heritage Brocade', 'Authentic Varanasi Brocades & Traditional Katan Silks', 'AH')" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        <span>Edit</span>
                                    </button>
                                    <a href="/Frontend/Shop/shop.php?brand=Arniya+Heritage" target="_blank" class="dt-btn-action-pill" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#1D4ED8" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        <span>View</span>
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Brand 3: DT Couture -->
                        <tr id="brand-row-3" style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                            <td style="text-align: center; padding:12px 8px;">
                                <input type="checkbox" class="brand-row-check" style="cursor:pointer; width:15px; height:15px;">
                            </td>
                            <td style="padding:12px 10px;">
                                <div class="dt-brand-avatar" id="brand-avatar-3" style="background:linear-gradient(135deg, #831843, #500724); border-color:#f472b6; color:#fbcfe8;">DC</div>
                            </td>
                            <td style="padding:12px 12px;">
                                <strong style="font-size:14px; color:#181512; display:block;" id="brand-title-3">DT Couture</strong>
                                <span style="font-size:12px; color:#646970;" id="brand-tagline-3">Handcrafted Bridal Zardosi Lehengas &amp; Luxury Reception Wear</span>
                            </td>
                            <td style="padding:12px 10px;">
                                <span class="adm-badge" style="background:#FDF2F8; border:1px solid #F472B6; color:#9D174D; font-weight:700; font-size:11px; padding:3px 8px;" id="brand-tier-3">👑 Bridal Luxury</span>
                            </td>
                            <td style="padding:12px 10px;">
                                <a href="/Frontend/Admin/products/?brand=DT+Couture" style="text-decoration:none;">
                                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:800; font-size:12px; padding:3px 8px; border-radius:10px;">140 SKUs</span>
                                </a>
                            </td>
                            <td style="padding:12px 10px;">
                                <strong style="color:#181512; font-size:13px;">₹6.00 Lakhs</strong>
                            </td>
                            <td style="padding:12px 10px;">
                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px;">🟢 Active &amp; Live</span>
                            </td>
                            <td style="padding:12px 12px; text-align:right;">
                                <div style="display:flex; gap:5px; justify-content:flex-end;">
                                    <button type="button" class="dt-btn-action-pill" onclick="openEditBrandModal(3, 'DT Couture', 'Bridal Luxury', 'Handcrafted Bridal Zardosi Lehengas & Luxury Reception Wear', 'DC')" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        <span>Edit</span>
                                    </button>
                                    <a href="/Frontend/Shop/shop.php?brand=DT+Couture" target="_blank" class="dt-btn-action-pill" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#1D4ED8" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        <span>View</span>
                                    </a>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: INSTANT EDIT BRAND & LOGO UPLOAD                  -->
<!-- ======================================================== -->
<div id="editBrandModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:540px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37;">
        <div style="background:linear-gradient(135deg, #181512 0%, #2A241E 50%, #3D342A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="#D4AF37" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <h3 style="margin:0; font-size:15px; font-weight:800; color:#FAF5E8;">Edit House Label: <span id="modalBrandTitleName" style="color:#D4AF37;">DT Signature</span></h3>
            </div>
            <button type="button" onclick="closeEditBrandModal()" style="background:none; border:none; color:#FAF5E8; font-size:22px; cursor:pointer; line-height:1;">&times;</button>
        </div>
        <div style="padding:18px 22px;">
            <input type="hidden" id="editModalBrandId" value="1">
            
            <!-- Logo Upload Row -->
            <div style="display:flex; align-items:center; gap:16px; padding:12px 14px; background:#FAF5E8; border:1.5px dashed #D4AF37; border-radius:8px; margin-bottom:16px;">
                <div id="modalLogoPreview" style="width:56px; height:56px; border-radius:50%; background:linear-gradient(135deg, #181512, #3D342A); color:#D4AF37; font-family:'Cinzel',serif; font-weight:800; font-size:18px; display:flex; align-items:center; justify-content:center; border:2px solid #D4AF37; flex-shrink:0; overflow:hidden; box-shadow:0 2px 8px rgba(212,175,55,0.3);">
                    DT
                </div>
                <div style="flex:1;">
                    <div style="font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Brand Logo / Emblem</div>
                    <input type="file" id="modalLogoFileInput" style="display:none;" accept="image/*" onchange="handleLogoUploadPreview(this)">
                    <button type="button" class="wp-button" onclick="document.getElementById('modalLogoFileInput').click()" style="height:30px; font-size:11.5px; font-weight:700; background:#ffffff; border:1px solid #D4AF37; color:#8A681F; display:inline-flex; align-items:center; gap:5px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        <span>Upload / Change Logo</span>
                    </button>
                    <small style="display:block; color:#646970; font-size:10.5px; margin-top:3px;">Supported: PNG, JPG, WebP (1:1 Ratio)</small>
                </div>
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Brand Name <span style="color:#b32d2e;">*</span></label>
                <input type="text" id="modalBrandName" style="width:100%; height:36px; padding:0 12px; font-size:13px; color:#181512; background:#ffffff; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box; outline:none;" required>
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Brand Tier</label>
                <select id="modalBrandTier" style="width:100%; height:36px; padding:0 12px; font-size:13px; color:#181512; background:#ffffff; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box; outline:none;">
                    <option value="Primary Flagship">Primary Flagship</option>
                    <option value="Heritage Brocade">Heritage Brocade</option>
                    <option value="Bridal Luxury">Bridal Luxury</option>
                    <option value="Mill Volume B2B">Mill Volume B2B</option>
                </select>
            </div>

            <div style="margin-bottom:10px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Tagline / Manifesto</label>
                <input type="text" id="modalBrandTagline" style="width:100%; height:36px; padding:0 12px; font-size:13px; color:#181512; background:#ffffff; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box; outline:none;">
            </div>
        </div>
        <div style="background:#f6f7f7; padding:14px 22px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" class="wp-button" onclick="closeEditBrandModal()" style="height:34px; font-size:12px; font-weight:700; padding:0 14px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Cancel</button>
            <button type="button" class="wp-button primary" onclick="submitEditBrandModal()" style="height:34px; font-size:12px; font-weight:800; padding:0 18px; background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; border:1px solid #8A681F; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Save &amp; Update Brand</span>
            </button>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: ADD NEW HOUSE LABEL (PERFECT FULL-WIDTH STYLED)    -->
<!-- ======================================================== -->
<div id="addBrandModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:540px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37;">
        <div style="background:linear-gradient(135deg, #181512 0%, #2A241E 50%, #3D342A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="17" height="17" fill="none" stroke="#D4AF37" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <h3 style="margin:0; font-size:15px; font-weight:800; color:#FAF5E8;">Add New House Label</h3>
            </div>
            <button type="button" onclick="closeAddBrandModal()" style="background:none; border:none; color:#FAF5E8; font-size:22px; cursor:pointer; line-height:1;">&times;</button>
        </div>
        <div style="padding:18px 22px;">
            
            <!-- Logo Upload Row -->
            <div style="display:flex; align-items:center; gap:16px; padding:12px 14px; background:#FAF5E8; border:1.5px dashed #D4AF37; border-radius:8px; margin-bottom:16px;">
                <div id="newBrandLogoPreview" style="width:56px; height:56px; border-radius:50%; background:linear-gradient(135deg, #181512, #3D342A); color:#D4AF37; font-family:'Cinzel',serif; font-weight:800; font-size:18px; display:flex; align-items:center; justify-content:center; border:2px solid #D4AF37; flex-shrink:0; overflow:hidden; box-shadow:0 2px 8px rgba(212,175,55,0.3);">
                    JH
                </div>
                <div style="flex:1;">
                    <div style="font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Brand Logo / Emblem</div>
                    <input type="file" id="newBrandLogoFileInput" style="display:none;" accept="image/*" onchange="handleNewLogoUploadPreview(this)">
                    <button type="button" class="wp-button" onclick="document.getElementById('newBrandLogoFileInput').click()" style="height:30px; font-size:11.5px; font-weight:700; background:#ffffff; border:1px solid #D4AF37; color:#8A681F; display:inline-flex; align-items:center; gap:5px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        <span>Upload Logo / Emblem</span>
                    </button>
                    <small style="display:block; color:#646970; font-size:10.5px; margin-top:3px;">Supported: PNG, JPG, WebP (1:1 Ratio)</small>
                </div>
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Brand Name <span style="color:#b32d2e;">*</span></label>
                <input type="text" id="newBrandName" placeholder="e.g. Jai Hanuman Fab" style="width:100%; height:36px; padding:0 12px; font-size:13px; color:#181512; background:#ffffff; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box; outline:none;" required>
            </div>

            <div style="margin-bottom:14px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Brand Tier</label>
                <select id="newBrandTier" style="width:100%; height:36px; padding:0 12px; font-size:13px; color:#181512; background:#ffffff; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box; outline:none;">
                    <option value="Primary Flagship">Primary Flagship</option>
                    <option value="Heritage Brocade">Heritage Brocade</option>
                    <option value="Bridal Luxury">Bridal Luxury</option>
                    <option value="Mill Volume B2B">Mill Volume B2B</option>
                </select>
            </div>

            <div style="margin-bottom:10px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Tagline / Manifesto</label>
                <input type="text" id="newBrandTagline" placeholder="e.g. Surat Central Mill Direct Weaves" style="width:100%; height:36px; padding:0 12px; font-size:13px; color:#181512; background:#ffffff; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box; outline:none;">
            </div>
        </div>
        <div style="background:#f6f7f7; padding:14px 22px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" class="wp-button" onclick="closeAddBrandModal()" style="height:34px; font-size:12px; font-weight:700; padding:0 14px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Cancel</button>
            <button type="button" class="wp-button primary" onclick="submitNewBrand()" style="height:34px; font-size:12px; font-weight:800; padding:0 18px; background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; border:1px solid #8A681F; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>+ Save &amp; Create Label</span>
            </button>
        </div>
    </div>
</div>

<script>
let lastUploadedLogoUrl = null;
let lastNewBrandLogoUrl = null;

function handleLogoUploadPreview(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            lastUploadedLogoUrl = e.target.result;
            const preview = document.getElementById('modalLogoPreview');
            if (preview) {
                preview.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
            }
            if (typeof window.showToast === 'function') window.showToast('📷 Brand logo uploaded successfully!');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function handleNewLogoUploadPreview(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            lastNewBrandLogoUrl = e.target.result;
            const preview = document.getElementById('newBrandLogoPreview');
            if (preview) {
                preview.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
            }
            if (typeof window.showToast === 'function') window.showToast('📷 Brand logo uploaded successfully!');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function openEditBrandModal(id, name, tier, tagline, initials) {
    document.getElementById('editModalBrandId').value = id;
    document.getElementById('modalBrandTitleName').textContent = name;
    document.getElementById('modalBrandName').value = name;
    document.getElementById('modalBrandTier').value = tier;
    document.getElementById('modalBrandTagline').value = tagline;
    
    const preview = document.getElementById('modalLogoPreview');
    if (preview) {
        if (lastUploadedLogoUrl) {
            preview.innerHTML = `<img src="${lastUploadedLogoUrl}" style="width:100%; height:100%; object-fit:cover;">`;
        } else {
            preview.innerHTML = initials || 'DT';
        }
    }

    const m = document.getElementById('editBrandModal');
    if (m) m.style.display = 'flex';
}

function closeEditBrandModal() {
    const m = document.getElementById('editBrandModal');
    if (m) m.style.display = 'none';
}

function submitEditBrandModal() {
    const id = document.getElementById('editModalBrandId').value;
    const name = document.getElementById('modalBrandName').value;
    const tier = document.getElementById('modalBrandTier').value;
    const tagline = document.getElementById('modalBrandTagline').value;

    if (name) {
        const titleEl = document.getElementById(`brand-title-${id}`);
        if (titleEl) titleEl.textContent = name;

        const taglineEl = document.getElementById(`brand-tagline-${id}`);
        if (taglineEl) taglineEl.textContent = tagline;

        const tierEl = document.getElementById(`brand-tier-${id}`);
        if (tierEl) tierEl.textContent = tier;

        if (lastUploadedLogoUrl) {
            const avatarEl = document.getElementById(`brand-avatar-${id}`);
            if (avatarEl) avatarEl.innerHTML = `<img src="${lastUploadedLogoUrl}" style="width:100%; height:100%; object-fit:cover;">`;
        }

        closeEditBrandModal();
        if (typeof window.showToast === 'function') window.showToast(`✨ Brand "${name}" updated successfully!`);
    }
}

function toggleBrandSearchClearBtn(val) {
    const btn = document.getElementById('brandSearchClearBtn');
    if (btn) btn.style.display = val.length > 0 ? 'inline' : 'none';
}

function clearBrandSearch() {
    const input = document.getElementById('brandSearchInput');
    if (input) {
        input.value = '';
        toggleBrandSearchClearBtn('');
        searchBrands('');
        input.focus();
    }
}

function toggleSelectAllBrands(master) {
    const checks = document.querySelectorAll('.brand-row-check');
    checks.forEach(c => c.checked = master.checked);
}

function searchBrands(q) {
    const rows = document.querySelectorAll('#brandsTableBody tr');
    const term = (q || '').toLowerCase().trim();
    rows.forEach(r => {
        const txt = r.textContent.toLowerCase();
        r.style.display = txt.includes(term) ? '' : 'none';
    });
}

function filterBrandByTier(tier) {
    const rows = document.querySelectorAll('#brandsTableBody tr');
    rows.forEach(r => {
        if (!tier) {
            r.style.display = '';
        } else {
            const txt = r.textContent.toLowerCase();
            r.style.display = txt.includes(tier.toLowerCase()) ? '' : 'none';
        }
    });
}

function openAddBrandModal() {
    const m = document.getElementById('addBrandModal');
    if (m) m.style.display = 'flex';
}

function closeAddBrandModal() {
    const m = document.getElementById('addBrandModal');
    if (m) m.style.display = 'none';
}

function submitNewBrand() {
    const name = document.getElementById('newBrandName')?.value || 'House Label';
    closeAddBrandModal();
    if (typeof window.showToast === 'function') window.showToast(`✨ Brand "${name}" created successfully!`);
}

function handleBrandBulkAction() {
    const action = document.getElementById('brandBulkActionSelect')?.value;
    if (!action) return;
    const selected = document.querySelectorAll('.brand-row-check:checked');
    if (selected.length === 0) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Select at least one brand');
        return;
    }
    if (typeof window.showToast === 'function') window.showToast(`Bulk action "${action}" applied to ${selected.length} brands!`);
}
</script>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
