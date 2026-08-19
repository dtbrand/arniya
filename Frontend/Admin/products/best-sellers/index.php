<?php
/**
 * index.php — DT Brand's Best Sellers (Wholesale Desktop & WooCommerce Hybrid)
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Best Sellers";
$active_nav = "products";
$active_subnav = "best-sellers";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Sellers ‹ DT Brand's Admin</title>
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
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 16px 20px;">

            <!-- 1. Header Toolbar -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Best Sellers</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:3px 8px;">★ Top Trending Lots</span>
                    
                    <a href="/Frontend/Admin/products/add.php" class="wp-button primary" style="background:linear-gradient(135deg, #8A681F 0%, #B8860B 50%, #D4AF37 100%); color:#181512; font-weight:800; border:1px solid #8A681F; padding:0 14px; height:32px; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35); text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add Product</span>
                    </a>

                    <a href="/Frontend/Admin/products/" class="wp-button" style="height:32px; padding:0 11px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Products (1,240)</span>
                    </a>
                </div>

                <!-- Dual View Mode Switcher -->
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

            <!-- 2. KPI Metrics Ribbon -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px; margin-bottom:14px;">
                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">BEST SELLING LOTS</div>
                        <div style="font-size:17px; font-weight:800; color:#181512;">32 SKUs</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#DCFCE7; border:1px solid #86EFAC; display:flex; align-items:center; justify-content:center; color:#15803D;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">AVERAGE RESALE MARGIN</div>
                        <div style="font-size:17px; font-weight:800; color:#15803D;">+38% Wholesale</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#EFF6FF; border:1px solid #93C5FD; display:flex; align-items:center; justify-content:center; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">DEPOT STOCK</div>
                        <div style="font-size:17px; font-weight:800; color:#1D4ED8;">Ready Dispatch</div>
                    </div>
                </div>

                <div class="dt-kpi-card">
                    <div style="width:36px; height:36px; border-radius:6px; background:#FEF3C7; border:1px solid #FCD34D; display:flex; align-items:center; justify-content:center; color:#B45309;">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    </div>
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">VISIBILITY</div>
                        <div style="font-size:17px; font-weight:800; color:#B45309;">Live in B2B &amp; Shop</div>
                    </div>
                </div>
            </div>

            <!-- 3. Top Toolbar: Filter Dropdowns & Rule-Compliant Search Input -->
            <div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                <div class="wp-tablenav-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <select class="wp-select" id="wpCategoryFilter" onchange="filterWpCategory(this.value)" style="height:32px; font-size:12px;">
                        <option value="">All Categories</option>
                        <option value="Silk Sarees">Silk Sarees</option>
                        <option value="Banarasi Brocade">Banarasi Brocade</option>
                        <option value="Bridal Lehengas">Bridal Lehengas</option>
                        <option value="Designer Kurtis">Designer Kurtis</option>
                    </select>

                    <select class="wp-select" id="wpStockFilter" onchange="filterWpStock(this.value)" style="height:32px; font-size:12px;">
                        <option value="">All Stock Status</option>
                        <option value="In stock">In stock</option>
                        <option value="Low stock">Low stock</option>
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
                        <input type="text" id="wpSearchInput" class="wp-search-input" placeholder="Search best sellers..." style="height:32px; padding-left:36px; padding-right:28px; width:220px; font-size:12px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchWpProducts(this.value); toggleSearchClearBtn(this.value)">
                        <span id="wpSearchClearBtn" onclick="clearWpSearch()" style="position:absolute; right:8px; cursor:pointer; color:#8c8f94; font-size:13px; font-weight:700; display:none;" title="Clear search">✕</span>
                    </div>
                    <button type="button" class="wp-button primary" onclick="searchWpProducts(document.getElementById('wpSearchInput').value)" style="height:32px; font-size:12px; font-weight:600; padding:0 12px;">Search</button>
                </div>
            </div>

            <!-- 4A. Table View -->
            <div id="productTableView" class="wp-table-card" style="background:#fff; border:1px solid #c3c4c7; border-radius:6px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <table class="wp-list-table" id="wpProductsTable" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f6f7f7; border-bottom:1px solid #c3c4c7;">
                            <th style="width: 54px; padding:10px 8px;">Image</th>
                            <th style="padding:10px 12px;">Product Name</th>
                            <th style="padding:10px 10px;">SKU</th>
                            <th style="padding:10px 10px;">Stock</th>
                            <th style="padding:10px 10px;">Price</th>
                            <th style="padding:10px 10px;">Categories</th>
                            <th style="padding:10px 10px;">Brand</th>
                            <th style="padding:10px 10px;">Rating</th>
                            <th style="text-align: right; padding:10px 12px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="wpProductsTableBody">
                        
                        <!-- Row 1 -->
                        <tr style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                            <td style="padding:10px 8px;">
                                <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="wp-thumb-img" alt="Saree" style="width:42px; height:42px; object-fit:cover; border-radius:4px; border:1px solid #e2e8f0; display:block;">
                            </td>
                            <td style="padding:10px 12px;">
                                <a href="/Frontend/Admin/products/edit.php?id=101" class="wp-row-title" style="font-weight:700; color:#181512; text-decoration:none; font-size:13px;">Kanjivaram Pure Silk Gold Zari Saree</a>
                                <div class="wp-row-actions" style="margin-top:4px; font-size:11.5px;">
                                    <a href="/Frontend/Admin/products/edit.php?id=101" style="color:#8A681F; font-weight:600;">Edit</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="/Frontend/Admin/products/duplicate.php?id=101" style="color:#2271b1;">Duplicate</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="/Frontend/Admin/products/view.php?id=101" style="color:#2271b1;">View</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="#" onclick="window.shareProductWhatsApp(101); return false;" style="color:#15803D; font-weight:700;">WhatsApp</a>
                                </div>
                            </td>
                            <td style="padding:10px 10px;"><code style="background:#f0f0f1; padding:2px 6px; border-radius:3px; font-size:12px;">KLN-SR-111</code></td>
                            <td style="padding:10px 10px;">
                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px;">In stock (45)</span>
                            </td>
                            <td style="padding:10px 10px;">
                                <strong style="font-size:13px; color:#181512;">₹4,490</strong><br>
                                <small style="color:#8A681F; font-size:11px; font-weight:600;">Wholesale: ₹2,850</small>
                            </td>
                            <td style="padding:10px 10px;"><strong style="color:#8A681F;">Silk Sarees</strong></td>
                            <td style="padding:10px 10px;"><strong>DT Signature</strong></td>
                            <td style="padding:10px 10px;"><span style="color:#D4AF37; font-weight:700;">5.0 ★</span> (128)</td>
                            <td style="text-align: right; padding:10px 12px;">
                                <a href="/Frontend/Admin/products/edit.php?id=101" class="wp-button" style="height:26px; font-size:11px; padding:0 8px; text-decoration:none;">✏️ Edit</a>
                            </td>
                        </tr>

                        <!-- Row 2 -->
                        <tr style="border-bottom:1px solid #f0f0f1; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                            <td style="padding:10px 8px;">
                                <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" class="wp-thumb-img" alt="Saree" style="width:42px; height:42px; object-fit:cover; border-radius:4px; border:1px solid #e2e8f0; display:block;">
                            </td>
                            <td style="padding:10px 12px;">
                                <a href="/Frontend/Admin/products/edit.php?id=102" class="wp-row-title" style="font-weight:700; color:#181512; text-decoration:none; font-size:13px;">Banarasi Royal Brocade Weave Saree</a>
                                <div class="wp-row-actions" style="margin-top:4px; font-size:11.5px;">
                                    <a href="/Frontend/Admin/products/edit.php?id=102" style="color:#8A681F; font-weight:600;">Edit</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="/Frontend/Admin/products/duplicate.php?id=102" style="color:#2271b1;">Duplicate</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="/Frontend/Admin/products/view.php?id=102" style="color:#2271b1;">View</a> <span style="color:#c3c4c7;">|</span>
                                    <a href="#" onclick="window.shareProductWhatsApp(102); return false;" style="color:#15803D; font-weight:700;">WhatsApp</a>
                                </div>
                            </td>
                            <td style="padding:10px 10px;"><code style="background:#f0f0f1; padding:2px 6px; border-radius:3px; font-size:12px;">BNR-SR-204</code></td>
                            <td style="padding:10px 10px;">
                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px;">In stock (28)</span>
                            </td>
                            <td style="padding:10px 10px;">
                                <strong style="font-size:13px; color:#181512;">₹4,990</strong><br>
                                <small style="color:#8A681F; font-size:11px; font-weight:600;">Wholesale: ₹3,200</small>
                            </td>
                            <td style="padding:10px 10px;"><strong style="color:#8A681F;">Banarasi Brocade</strong></td>
                            <td style="padding:10px 10px;"><strong>Arniya Heritage</strong></td>
                            <td style="padding:10px 10px;"><span style="color:#D4AF37; font-weight:700;">4.9 ★</span> (94)</td>
                            <td style="text-align: right; padding:10px 12px;">
                                <a href="/Frontend/Admin/products/edit.php?id=102" class="wp-button" style="height:26px; font-size:11px; padding:0 8px; text-decoration:none;">✏️ Edit</a>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- 4B. Wholesale Desktop Grid Cards View -->
            <div id="productGridView" class="dt-ws-grid" style="display:none;">
                <div class="dt-ws-card">
                    <div style="position:relative;">
                        <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="dt-ws-card-img" alt="Kanjivaram Saree">
                        <span class="adm-badge" style="position:absolute; top:8px; left:8px; background:#8A681F; color:#fff; font-weight:700; font-size:10px;">★ Top Trending Lots</span>
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

                <div class="dt-ws-card">
                    <div style="position:relative;">
                        <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" class="dt-ws-card-img" alt="Banarasi Saree">
                        <span class="adm-badge" style="position:absolute; top:8px; left:8px; background:#D4AF37; color:#181512; font-weight:800; font-size:10px;">★ Top Trending Lots</span>
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
            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
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
    } else {
        if (table) table.style.display = 'block';
        if (grid) grid.style.display = 'none';
        if (btnTable) btnTable.classList.add('active');
        if (btnGrid) btnGrid.classList.remove('active');
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

function applyWpFilters() {
    const cat = document.getElementById('wpCategoryFilter')?.value || '';
    const stock = document.getElementById('wpStockFilter')?.value || '';
    const rows = document.querySelectorAll('#wpProductsTableBody tr');
    rows.forEach(r => {
        const txt = r.textContent.toLowerCase();
        const matchesCat = !cat || txt.includes(cat.toLowerCase());
        const matchesStock = !stock || txt.includes(stock.toLowerCase());
        r.style.display = (matchesCat && matchesStock) ? '' : 'none';
    });
    if (typeof window.showToast === 'function') window.showToast('🔍 Filters applied!');
}

window.shareProductWhatsApp = function(id) {
    const text = encodeURIComponent(`Hello DT Brand's! Inquiring about Best Sellers ID: #${id}. https://jaihanumantex.in/Frontend/Admin/products/view.php?id=${id}`);
    window.open(`https://wa.me/919999999999?text=${text}`, '_blank');
};
</script>
</body>
</html>
