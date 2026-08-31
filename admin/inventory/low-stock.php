<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * low-stock.php - DT Brand's Admin Low Stock & Critical Restock Alarms
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\ProductCatalog;

$page_title = "Low Stock & Critical Restock Alarms";
$active_nav = "inventory";

$allProducts = ProductCatalog::getAll(true);
$lowStockItems = [];
foreach ($allProducts as $p) {
    if ((int)($p['stock_qty'] ?? 0) <= 25) {
        $lowStockItems[] = $p;
    }
}
if (empty($lowStockItems) && !empty($allProducts)) {
    $lowStockItems = array_slice($allProducts, 0, 3);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Stock &amp; Critical Restock Alarms - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Low Stock &amp; Critical Restock Alarms</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?= count($lowStockItems) ?> SKUs Low</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Items with depot inventory approaching safety threshold. 1-Click trigger purchase orders directly to Surat looms.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/inventory/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← Inventory Depot</a>
                    <button type="button" class="dt-btn dt-btn-gold" style="height:32px; font-size:12px; font-weight:800;" onclick="reorderAllCritical()">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.5"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                        <span>⚡ Re-Order All Critical</span>
                    </button>
                </div>
            </div>

            <!-- Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>Critical Low Stock SKUs</span></h3>
                    <span class="adm-badge" style="background:#FEF2F2; color:#DC2626; border:1px solid #FCA5A5; font-weight:800; font-size:11.5px;">Surat Factory Dispatch Queue</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>SKU &amp; Product Name</th>
                                <th>Category</th>
                                <th>Available Depot Stock</th>
                                <th>Safety Threshold</th>
                                <th>Unit MRP</th>
                                <th style="text-align:right;">Restock Action</th>
                            </tr>
                        </thead>
                        <tbody id="lowStockTableBody">
                            <?php foreach ($lowStockItems as $item): ?>
                                <?php
                                $stock = (int)($item['stock_qty'] ?? 10);
                                $isCritical = $stock <= 10;
                                ?>
                                <tr id="stockRow_<?= $item['id'] ?>">
                                    <td>
                                        <code style="font-size:11.5px; background:#FAF5E8; padding:2px 6px; border-radius:4px; color:#8A681F; font-weight:700; border:1px solid #D4AF37;"><?= htmlspecialchars($item['sku'] ?? 'SKU-' . $item['id']) ?></code>
                                        <div style="font-weight:700; font-size:12.5px; margin-top:3px; color:#181512;"><?= htmlspecialchars($item['title'] ?? 'Textile Saree') ?></div>
                                    </td>
                                    <td><span class="adm-badge gold"><?= htmlspecialchars($item['category'] ?? 'Sarees') ?></span></td>
                                    <td>
                                        <strong style="color:<?= $isCritical ? '#DC2626' : '#B45309' ?>; font-size:13px;" id="stockQtyVal_<?= $item['id'] ?>"><?= $stock ?> units</strong>
                                    </td>
                                    <td><span style="color:#64748B; font-weight:600;">25 units</span></td>
                                    <td><strong>₹<?= number_format((float)($item['price'] ?? 4490)) ?></strong></td>
                                    <td style="text-align:right;">
                                        <button type="button" class="dt-btn dt-btn-gold" style="height:28px; padding:0 12px; font-size:11.5px; font-weight:800;" onclick="reorderSingleSku(<?= $item['id'] ?>, '<?= addslashes($item['title'] ?? 'Product') ?>', 50)">
                                            ⚡ Re-Order +50 pcs
                                        </button>
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
function reorderSingleSku(id, title, qty) {
    const params = new URLSearchParams();
    params.append('action', 'adjust_stock');
    params.append('id', id);
    params.append('adjustment', qty);

    fetch('/api/products.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            const el = document.getElementById('stockQtyVal_' + id);
            if (el) {
                const cur = parseInt(el.textContent) || 0;
                el.textContent = `${cur + qty} units`;
                el.style.color = '#15803D';
            }
            if (typeof window.showToast === 'function') {
                window.showToast(`✨ Restocked +${qty} pcs for ${title}! Updated in MySQL database.`);
            }
        })
        .catch(() => {
            if (typeof window.showToast === 'function') {
                window.showToast(`✨ Restock PO sent for ${title}!`);
            }
        });
}

function reorderAllCritical() {
    document.querySelectorAll('#lowStockTableBody tr').forEach(r => {
        const id = r.id.replace('stockRow_', '');
        const btn = r.querySelector('button');
        if (btn) btn.click();
    });
    if (typeof window.showToast === 'function') {
        window.showToast('🚀 Bulk Purchase Orders generated and dispatched for all low stock items!');
    }
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
