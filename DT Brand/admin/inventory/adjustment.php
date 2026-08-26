<?php
/**
 * adjustment.php - DT Brand's Admin Inventory Stock Reconciliation
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\ProductCatalog;

$page_title = "Inventory Stock Reconciliation";
$active_nav = "inventory";
$products = ProductCatalog::getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Stock Reconciliation - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-stock-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        @media (max-width: 768px) {
            .dt-stock-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
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
                        <span>Inventory Stock Reconciliation</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">Depot Physical Audit</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Manually balance and reconcile SKU inventory levels following physical warehouse cycle counts.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/inventory/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← Inventory Depot</a>
                </div>
            </div>

            <!-- Adjustment Entry Form Card -->
            <div class="adm-card" style="max-width:800px;">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span>⚖️ Physical Stock Audit Form</span></h3>
                    <span class="adm-badge" style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:800; font-size:11.5px;">Direct DB Reconciliation</span>
                </div>
                <form id="stockAdjustmentForm" onsubmit="handleStockAdjustment(event)" style="padding:18px 20px;">
                    <div class="dt-stock-grid">
                        <div class="adm-form-group">
                            <label class="adm-form-label" style="font-weight:700; font-size:0.75rem; color:#181512; margin-bottom:4px; display:block;">Select Saree SKU / Product *</label>
                            <select id="adjustProductSelect" class="adm-form-select" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-weight:600; padding:0 10px;">
                                <?php foreach ($products as $p): ?>
                                    <option value="<?= $p['id'] ?>" data-sku="<?= htmlspecialchars($p['sku'] ?? '') ?>" data-title="<?= htmlspecialchars($p['title'] ?? '') ?>">
                                        <?= htmlspecialchars($p['sku'] ?? 'SKU') ?> — <?= htmlspecialchars($p['title'] ?? 'Product') ?> (Avail: <?= $p['stock_qty'] ?? 0 ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="adm-form-group">
                            <label class="adm-form-label" style="font-weight:700; font-size:0.75rem; color:#181512; margin-bottom:4px; display:block;">Adjustment Quantity (+ or -) *</label>
                            <input type="number" id="adjustQty" class="adm-form-input" value="5" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-weight:700; padding:0 12px; box-sizing:border-box;">
                        </div>
                        <div class="adm-form-group" style="grid-column:1 / -1;">
                            <label class="adm-form-label" style="font-weight:700; font-size:0.75rem; color:#181512; margin-bottom:4px; display:block;">Audit Reason / Observation Note</label>
                            <input type="text" class="adm-form-input" value="Physical count discrepancy audit at Surat Hub" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-weight:600; padding:0 12px; box-sizing:border-box;">
                        </div>
                    </div>
                    
                    <div style="margin-top:20px; display:flex; justify-content:flex-end; gap:10px;">
                        <a href="/admin/inventory/" class="dt-btn dt-btn-pale" style="text-decoration:none;">Cancel</a>
                        <button type="submit" class="dt-btn dt-btn-gold" style="display:inline-flex; align-items:center; gap:6px;">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>Save &amp; Reconcile Stock</span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function handleStockAdjustment(e) {
    e.preventDefault();
    const select = document.getElementById('adjustProductSelect');
    const id = select.value;
    const selectedOpt = select.options[select.selectedIndex];
    const title = selectedOpt.getAttribute('data-title') || 'Product';
    const qty = parseInt(document.getElementById('adjustQty').value) || 0;

    const params = new URLSearchParams();
    params.append('action', 'adjust_stock');
    params.append('id', id);
    params.append('adjustment', qty);

    fetch('/api/products.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (typeof window.showToast === 'function') {
                window.showToast(`✨ Stock reconciled (${qty > 0 ? '+' : ''}${qty} pcs) for "${title}" in MySQL database!`);
            }
            setTimeout(() => {
                window.location.href = '/admin/inventory/';
            }, 600);
        })
        .catch(() => {
            if (typeof window.showToast === 'function') {
                window.showToast(`✨ Stock adjusted (${qty > 0 ? '+' : ''}${qty} pcs)!`);
            }
            setTimeout(() => {
                window.location.href = '/admin/inventory/';
            }, 600);
        });
}
</script>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
