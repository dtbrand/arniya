<?php
/**
 * index.php — DT Brand's Products Management Suite (WordPress / WooCommerce Luxury Gold Edition)
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
    <title>Products ‹ DT Brand's Admin — WooCommerce Style</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 16px 20px;">

            <!-- 1. Header Toolbar with Luxury Brand Gold Buttons & SVG Icons -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Products</h1>
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
            </div>

            <!-- 2. Status Views Filter Links (.subsubsub) with Active Highlights -->
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

            <!-- 3. Top Toolbar: Bulk Actions, Filter Dropdowns & Rule-Compliant Search Input -->
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
                    <button type="button" class="wp-button primary" onclick="searchWpProducts(document.getElementById('wpSearchInput').value)" style="height:32px; font-size:12px; font-weight:600; padding:0 12px;">Search Products</button>
                </div>
            </div>

            <!-- 4. WooCommerce Style High-Craft Products Table -->
            <div class="wp-table-card" style="background:#fff; border:1px solid #c3c4c7; border-radius:6px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
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
                        
                        <!-- Row 1: Kanjivaram Silk -->
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
                                    <a href="#" onclick="window.shareProductWhatsApp(101); return false;" style="color:#15803D; font-weight:700; display:inline-flex; align-items:center; gap:2px;">
                                        <svg viewBox="0 0 24 24" width="11" height="11" fill="currentColor"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.072-1.802-.387-1.42-.589-2.339-2.029-2.41-2.124-.071-.095-.572-.761-.572-1.45 0-.69.362-1.03.49-.172.129-.143.282-.179.376-.179.094 0 .188.001.27.005.087.004.204-.033.319.244.12.289.41 1.002.446 1.075.036.073.06.159.012.255-.048.096-.072.155-.144.239-.072.084-.152.188-.217.253-.072.072-.147.15-.063.294.084.144.373.616.8 1.002.55.496 1.013.65 1.157.722.144.072.228.06.313-.036.084-.096.362-.42.459-.564.096-.144.193-.12.325-.072.133.048.844.398.989.47.144.072.24.108.276.169.036.06.036.353-.108.758z"/></svg>
                                        <span>WhatsApp</span>
                                    </a> <span style="color:#c3c4c7;">|</span>
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

                        <!-- Row 2: Banarasi Brocade -->
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
                                    <a href="#" onclick="window.shareProductWhatsApp(102); return false;" style="color:#15803D; font-weight:700; display:inline-flex; align-items:center; gap:2px;">
                                        <svg viewBox="0 0 24 24" width="11" height="11" fill="currentColor"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.072-1.802-.387-1.42-.589-2.339-2.029-2.41-2.124-.071-.095-.572-.761-.572-1.45 0-.69.362-1.03.49-.172.129-.143.282-.179.376-.179.094 0 .188.001.27.005.087.004.204-.033.319.244.12.289.41 1.002.446 1.075.036.073.06.159.012.255-.048.096-.072.155-.144.239-.072.084-.152.188-.217.253-.072.072-.147.15-.063.294.084.144.373.616.8 1.002.55.496 1.013.65 1.157.722.144.072.228.06.313-.036.084-.096.362-.42.459-.564.096-.144.193-.12.325-.072.133.048.844.398.989.47.144.072.24.108.276.169.036.06.036.353-.108.758z"/></svg>
                                        <span>WhatsApp</span>
                                    </a> <span style="color:#c3c4c7;">|</span>
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

                        <!-- Row 3: Bridal Lehenga -->
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
                                    <a href="#" onclick="window.shareProductWhatsApp(103); return false;" style="color:#15803D; font-weight:700; display:inline-flex; align-items:center; gap:2px;">
                                        <svg viewBox="0 0 24 24" width="11" height="11" fill="currentColor"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.072-1.802-.387-1.42-.589-2.339-2.029-2.41-2.124-.071-.095-.572-.761-.572-1.45 0-.69.362-1.03.49-.172.129-.143.282-.179.376-.179.094 0 .188.001.27.005.087.004.204-.033.319.244.12.289.41 1.002.446 1.075.036.073.06.159.012.255-.048.096-.072.155-.144.239-.072.084-.152.188-.217.253-.072.072-.147.15-.063.294.084.144.373.616.8 1.002.55.496 1.013.65 1.157.722.144.072.228.06.313-.036.084-.096.362-.42.459-.564.096-.144.193-.12.325-.072.133.048.844.398.989.47.144.072.24.108.276.169.036.06.036.353-.108.758z"/></svg>
                                        <span>WhatsApp</span>
                                    </a> <span style="color:#c3c4c7;">|</span>
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

                        <!-- Row 4: Designer Kurti -->
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
                                    <a href="#" onclick="window.shareProductWhatsApp(104); return false;" style="color:#15803D; font-weight:700; display:inline-flex; align-items:center; gap:2px;">
                                        <svg viewBox="0 0 24 24" width="11" height="11" fill="currentColor"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.072-1.802-.387-1.42-.589-2.339-2.029-2.41-2.124-.071-.095-.572-.761-.572-1.45 0-.69.362-1.03.49-.172.129-.143.282-.179.376-.179.094 0 .188.001.27.005.087.004.204-.033.319.244.12.289.41 1.002.446 1.075.036.073.06.159.012.255-.048.096-.072.155-.144.239-.072.084-.152.188-.217.253-.072.072-.147.15-.063.294.084.144.373.616.8 1.002.55.496 1.013.65 1.157.722.144.072.228.06.313-.036.084-.096.362-.42.459-.564.096-.144.193-.12.325-.072.133.048.844.398.989.47.144.072.24.108.276.169.036.06.036.353-.108.758z"/></svg>
                                        <span>WhatsApp</span>
                                    </a> <span style="color:#c3c4c7;">|</span>
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

            <!-- 5. Bottom Toolbar: Bulk Actions & Pagination -->
            <div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-top:12px;">
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
    const term = (q || '').toLowerCase().trim();
    rows.forEach(r => {
        const txt = r.textContent.toLowerCase();
        r.style.display = txt.includes(term) ? '' : 'none';
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
    rows.forEach(r => {
        if (!status) {
            r.style.display = '';
        } else {
            const txt = r.textContent.toLowerCase();
            r.style.display = txt.includes(status.toLowerCase()) ? '' : 'none';
        }
    });
}

function filterWpCategory(cat) {
    const rows = document.querySelectorAll('#wpProductsTableBody tr');
    rows.forEach(r => {
        if (!cat) {
            r.style.display = '';
        } else {
            const txt = r.textContent.toLowerCase();
            r.style.display = txt.includes(cat.toLowerCase()) ? '' : 'none';
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
    const text = encodeURIComponent(`Hello DT Brand's! I would like to inquire about Product ID: #${id}. https://jaihanumantex.in/Frontend/Admin/products/view.php?id=${id}`);
    window.open(`https://wa.me/919999999999?text=${text}`, '_blank');
};
</script>
</body>
</html>
