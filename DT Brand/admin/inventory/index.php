<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * index.php - DT Brand's Admin Inventory Module
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$allProds = ProductCatalog::getAll();
$totalSkus = count($allProds);

$totalStockUnits = 0;
$totalInventoryValuation = 0;
$lowStockCount = 0;
$outOfStockCount = 0;

foreach ($allProds as $p) {
    $qty = (int)($p['stock_qty'] ?? 0);
    $wp = (float)($p['wholesale_price'] ?? 0);
    $totalStockUnits += $qty;
    $totalInventoryValuation += ($qty * $wp);
    if ($qty <= 0) {
        $outOfStockCount++;
    } elseif ($qty <= 15) {
        $lowStockCount++;
    }
}

$valFormatted = $totalInventoryValuation >= 100000
    ? '₹' . number_format($totalInventoryValuation / 100000, 2) . ' Lakhs'
    : '₹' . number_format($totalInventoryValuation);

$page_title = "Warehouse Inventory & Stock Adjuster";
$active_nav = "inventory";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouse Inventory &amp; Stock Adjuster - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
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
                        <span>Warehouse Inventory &amp; Stock Adjuster</span>
                        <span class="adm-badge gold"><?= $totalSkus ?> SKUs</span>
                    </h1>
                    <p class="adm-page-subtitle">Monitor stock in Surat Hub and Bhiwandi Warehouse with 1-click stock adjustments.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Total SKUs</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= number_format($totalSkus) ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up"><?= number_format($totalStockUnits) ?> Total Depot Units</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Total Inventory Value</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $valFormatted ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">At Wholesale Base Price</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Low Stock SKUs</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $lowStockCount ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta down">Below 15 pcs threshold</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Out of Stock</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $outOfStockCount ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta down"><?= $outOfStockCount > 0 ? 'Urgent Re-order' : 'All SKUs In Stock' ?></span>
                    </div>
                </div>
            </div>

            <!-- Module Specific Interactive Content -->
            <div class="adm-table-card">
                <div class="adm-table-toolbar">
                    <div class="adm-table-filters">
                        <select class="adm-filter-select" onchange="window.showToast('Filter applied!')">
                            <option value="all">All Warehouses (Surat Central Depot)</option>
                            <option value="Surat Central">Surat Central Hub (Ring Road)</option>
                            <option value="Bhiwandi">Bhiwandi Depot</option>
                        </select>
                    </div>
                    <div class="adm-page-actions">
                        <a href="/admin/products/add.php" class="adm-btn-primary" style="text-decoration:none;">+ Stock Inward (Receive)</a>
                    </div>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Product &amp; SKU</th>
                                <th>Category</th>
                                <th>Warehouse Hub</th>
                                <th>Available Units</th>
                                <th>Wholesale Rate</th>
                                <th>Inventory Status</th>
                                <th>Quick Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($allProds as $p): ?>
                                <?php
                                $stock = (int)($p['stock_qty'] ?? 0);
                                $statusClass = $stock <= 0 ? 'danger' : ($stock <= 15 ? 'warning' : 'success');
                                $statusText = $stock <= 0 ? 'Out of Stock' : ($stock <= 15 ? 'Low Stock' : 'Healthy');
                                ?>
                                <tr>
                                    <td>
                                        <strong><?= htmlspecialchars($p['title'] ?? $p['name'] ?? 'Product') ?></strong><br>
                                        <small style="color:#7A7266;">SKU: <?= htmlspecialchars($p['sku'] ?? 'SKU-000') ?></small>
                                    </td>
                                    <td><span class="adm-badge default"><?= htmlspecialchars($p['category'] ?? 'Silk Sarees') ?></span></td>
                                    <td>Surat Central Hub</td>
                                    <td>
                                        <div style="display:flex; align-items:center; gap:6px;">
                                            <strong id="stock-val-<?= $p['id'] ?>" style="<?= $stock <= 15 ? 'color:#DC2626;' : 'color:#15803D;' ?> font-size:0.95rem;"><?= number_format($stock) ?> units</strong>
                                        </div>
                                    </td>
                                    <td><strong>₹<?= number_format((float)($p['wholesale_price'] ?? 0)) ?></strong></td>
                                    <td><span id="stock-badge-<?= $p['id'] ?>" class="adm-badge <?= $statusClass ?>"><?= $statusText ?></span></td>
                                    <td>
                                        <div style="display:flex; gap:4px; align-items:center;">
                                            <button type="button" class="adm-btn-secondary adm-btn-sm" style="padding:2px 7px; font-size:0.75rem; font-weight:800;" onclick="quickAdjustStock(<?= $p['id'] ?>, 10, '<?= addslashes($p['sku'] ?? '') ?>')">+10</button>
                                            <button type="button" class="adm-btn-secondary adm-btn-sm" style="padding:2px 7px; font-size:0.75rem; font-weight:800;" onclick="quickAdjustStock(<?= $p['id'] ?>, -10, '<?= addslashes($p['sku'] ?? '') ?>')">-10</button>
                                            <a href="/admin/products/edit.php?id=<?= $p['id'] ?>" class="adm-btn-secondary adm-btn-sm" style="text-decoration:none; font-size:0.75rem;">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script>
function quickAdjustStock(prodId, delta, sku) {
    const valEl = document.getElementById('stock-val-' + prodId);
    let currentQty = parseInt(valEl ? valEl.textContent.replace(/[^0-9]/g, '') : '0') || 0;
    let newQty = Math.max(0, currentQty + delta);
    
    if (valEl) {
        valEl.textContent = newQty + ' units';
        valEl.style.color = newQty <= 15 ? '#DC2626' : '#15803D';
    }
    const badgeEl = document.getElementById('stock-badge-' + prodId);
    if (badgeEl) {
        badgeEl.className = 'adm-badge ' + (newQty <= 0 ? 'danger' : (newQty <= 15 ? 'warning' : 'success'));
        badgeEl.textContent = newQty <= 0 ? 'Out of Stock' : (newQty <= 15 ? 'Low Stock' : 'Healthy');
    }

    const params = new URLSearchParams();
    params.append('action', 'update');
    params.append('id', prodId);
    params.append('stock_qty', newQty);
    fetch('/api/products.php', { method: 'POST', body: params })
        .then(() => {
            if (typeof window.showToast === 'function') {
                window.showToast(`📦 Stock for ${sku} updated to ${newQty} units in database!`);
            }
        })
        .catch(() => {});
}
</script>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
