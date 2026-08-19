<?php
/**
 * index.php - DT Brand's Admin Products Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Product Catalog Management";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalog Management - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Product Catalog Management</span>
                        <span class="adm-badge gold">1,240 SKUs</span>
                    </h1>
                    <p class="adm-page-subtitle">Manage Surat Pure Silk Sarees, Banarasi Brocades, Lehengas & Kurtis catalog.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Total Products</span>
                <div class="adm-kpi-icon-box">👗</div>
            </div>
            <div class="adm-kpi-val">1,240</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">16 Categories</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Active in Stock</span>
                <div class="adm-kpi-icon-box">🟢</div>
            </div>
            <div class="adm-kpi-val">1,185</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">95.5% In Stock</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Low Stock Alert</span>
                <div class="adm-kpi-icon-box">⚠️</div>
            </div>
            <div class="adm-kpi-val">14</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta down">< 5 pcs remaining</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Out of Stock</span>
                <div class="adm-kpi-icon-box">🛑</div>
            </div>
            <div class="adm-kpi-val">41</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta down">Restock Pending</span>
            </div>
        </div>
        
            </div>

            <!-- Module Specific Interactive Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div class="adm-table-filters">
                    <select class="adm-filter-select" id="prodCatFilter" onchange="filterModuleTable(this.value, 'cat')">
                        <option value="all">All Categories</option>
                        <option value="Sarees">Silk Sarees</option>
                        <option value="Banarasi">Banarasi Brocade</option>
                        <option value="Lehengas">Bridal Lehengas</option>
                        <option value="Kurtis">Designer Kurtis</option>
                        <option value="Dress Materials">Dress Materials</option>
                    </select>
                    <select class="adm-filter-select" id="prodStockFilter" onchange="filterModuleTable(this.value, 'status')">
                        <option value="all">All Stock Status</option>
                        <option value="In Stock">In Stock</option>
                        <option value="Low Stock">Low Stock</option>
                        <option value="Out of Stock">Out of Stock</option>
                    </select>
                </div>
                <div class="adm-page-actions">
                    <button class="adm-btn-secondary" onclick="window.showToast('Exporting catalog CSV...')">📥 Export CSV</button>
                    <button class="adm-btn-primary" onclick="openAddProductModal()">+ Add New Product</button>
                </div>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table" id="moduleDataTable">
                    <thead>
                        <tr>
                            <th>Product & SKU</th>
                            <th>Category</th>
                            <th>Pricing (Retail / B2B)</th>
                            <th>MOQ</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="adm-table-prod-cell">
                                    <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="adm-prod-thumb" alt="Saree">
                                    <div class="adm-prod-meta">
                                        <span class="adm-prod-title">Kanjivaram Pure Silk Gold Zari Saree</span>
                                        <span class="adm-prod-sub">SKU: KLN-SR-111 • HSN: 5007 • Pure Silk</span>
                                    </div>
                                </div>
                            </td>
                            <td><strong>Silk Sarees</strong></td>
                            <td><strong>₹4,490</strong> (Retail)<br><span style="font-size:0.72rem; color:#8A681F; font-weight:700;">₹2,850/pc (Wholesale)</span></td>
                            <td><span style="background:#FAF5E8; color:#8A681F; padding:2px 8px; border-radius:6px; font-weight:700;">8 pcs</span></td>
                            <td><strong>45 units</strong></td>
                            <td><span class="adm-badge success">In Stock</span></td>
                            <td>
                                <div class="adm-action-btn-group">
                                    <button class="adm-action-btn" title="Edit" onclick="openAddProductModal()">✏️</button>
                                    <button class="adm-action-btn wa" title="Share WA" onclick="window.showToast('Shared to WhatsApp!')">💬</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="adm-table-prod-cell">
                                    <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" class="adm-prod-thumb" alt="Saree">
                                    <div class="adm-prod-meta">
                                        <span class="adm-prod-title">Banarasi Royal Brocade Weave Saree</span>
                                        <span class="adm-prod-sub">SKU: BNR-SR-204 • HSN: 5007 • Katan Silk</span>
                                    </div>
                                </div>
                            </td>
                            <td><strong>Banarasi</strong></td>
                            <td><strong>₹4,990</strong> (Retail)<br><span style="font-size:0.72rem; color:#8A681F; font-weight:700;">₹3,200/pc (Wholesale)</span></td>
                            <td><span style="background:#FAF5E8; color:#8A681F; padding:2px 8px; border-radius:6px; font-weight:700;">8 pcs</span></td>
                            <td><strong>28 units</strong></td>
                            <td><span class="adm-badge success">In Stock</span></td>
                            <td>
                                <div class="adm-action-btn-group">
                                    <button class="adm-action-btn" title="Edit" onclick="openAddProductModal()">✏️</button>
                                    <button class="adm-action-btn wa" title="Share WA" onclick="window.showToast('Shared to WhatsApp!')">💬</button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="adm-table-prod-cell">
                                    <img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" class="adm-prod-thumb" alt="Lehenga">
                                    <div class="adm-prod-meta">
                                        <span class="adm-prod-title">Crimson Bridal Handcrafted Zardosi Lehenga</span>
                                        <span class="adm-prod-sub">SKU: BRD-LH-902 • HSN: 6204 • Velvet Silk</span>
                                    </div>
                                </div>
                            </td>
                            <td><strong>Bridal Lehengas</strong></td>
                            <td><strong>₹16,490</strong> (Retail)<br><span style="font-size:0.72rem; color:#8A681F; font-weight:700;">₹11,500/pc (Wholesale)</span></td>
                            <td><span style="background:#FAF5E8; color:#8A681F; padding:2px 8px; border-radius:6px; font-weight:700;">2 pcs</span></td>
                            <td><strong style="color:#D97706;">4 units</strong></td>
                            <td><span class="adm-badge warning">Low Stock</span></td>
                            <td>
                                <div class="adm-action-btn-group">
                                    <button class="adm-action-btn" title="Edit" onclick="openAddProductModal()">✏️</button>
                                    <button class="adm-action-btn wa" title="Share WA" onclick="window.showToast('Shared to WhatsApp!')">💬</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/Frontend/Admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
