<?php
/**
 * index.php - DT Brand's Admin Inventory Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Warehouse Inventory & Stock Adjuster";
$active_nav = "inventory";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Inventory & Stock Adjuster - DT Brand's Admin</title>
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
                        <span>Warehouse Inventory & Stock Adjuster</span>
                        <span class="adm-badge gold">1,240 SKUs</span>
                    </h1>
                    <p class="adm-page-subtitle">Monitor stock in Surat Hub and Bhiwandi Warehouse with 1-click stock adjustments.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/Frontend/Admin/admin.php" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Total SKUs</span>
                <div class="adm-kpi-icon-box">🏭</div>
            </div>
            <div class="adm-kpi-val">1,240</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">Surat Central Hub</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Total Inventory Value</span>
                <div class="adm-kpi-icon-box">💰</div>
            </div>
            <div class="adm-kpi-val">₹84,20,000</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta up">At Wholesale Cost</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Low Stock SKUs</span>
                <div class="adm-kpi-icon-box">⚠️</div>
            </div>
            <div class="adm-kpi-val">14</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta down">Below 5 pcs threshold</span>
            </div>
        </div>
        
        <div class="adm-kpi-card">
            <div class="adm-kpi-top">
                <span class="adm-kpi-label">Out of Stock</span>
                <div class="adm-kpi-icon-box">🛑</div>
            </div>
            <div class="adm-kpi-val">41</div>
            <div class="adm-kpi-bottom">
                <span class="adm-kpi-delta down">Urgent Re-order</span>
            </div>
        </div>
        
            </div>

            <!-- Module Specific Interactive Content -->
            
        <div class="adm-table-card">
            <div class="adm-table-toolbar">
                <div class="adm-table-filters">
                    <select class="adm-filter-select" onchange="filterModuleTable(this.value, 'warehouse')">
                        <option value="all">All Warehouses</option>
                        <option value="Surat Central">Surat Central Hub (Main)</option>
                        <option value="Bhiwandi">Bhiwandi Depot</option>
                    </select>
                </div>
                <div class="adm-page-actions">
                    <button class="adm-btn-primary" onclick="window.showToast('Opening Stock Inward Form...')">+ Stock Inward (Receive)</button>
                </div>
            </div>
            <div class="adm-table-responsive">
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Product & SKU</th>
                            <th>Warehouse Hub</th>
                            <th>Available Units</th>
                            <th>Reserved for Orders</th>
                            <th>Min. Threshold</th>
                            <th>Inventory Status</th>
                            <th>Quick Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Kanjivaram Silk Saree</strong><br><small style="color:#7A7266;">SKU: KLN-SR-111</small></td>
                            <td>Surat Central Hub</td>
                            <td><strong>45 units</strong></td>
                            <td>12 units</td>
                            <td>10 units</td>
                            <td><span class="adm-badge success">Healthy</span></td>
                            <td><button class="adm-btn-secondary" style="padding:4px 8px; font-size:0.72rem;" onclick="window.showToast('Stock Adjusted +10!')">+ Add Stock</button></td>
                        </tr>
                        <tr>
                            <td><strong>Chanderi Cotton Saree</strong><br><small style="color:#7A7266;">SKU: CHD-CT-109</small></td>
                            <td>Surat Central Hub</td>
                            <td><strong style="color:#DC2626;">2 units</strong></td>
                            <td>4 units</td>
                            <td>10 units</td>
                            <td><span class="adm-badge danger">Critical Low</span></td>
                            <td><button class="adm-btn-primary" style="padding:4px 8px; font-size:0.72rem;" onclick="window.showToast('Purchase Order created!')">⚡ Re-Order</button></td>
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
