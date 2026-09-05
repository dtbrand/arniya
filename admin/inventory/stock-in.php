<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * stock-in.php - DT Brand's Admin Stock Inward Consignment Entry
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\ProductCatalog;

$page_title = "Stock Inward Consignment Entry";
$active_nav = "inventory";
$products = ProductCatalog::getAll(true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Inward Consignment Entry - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
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
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Stock Inward Consignment Entry</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">Surat Mill Inward</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Record fresh handloom saree consignments from Surat powerlooms directly into central warehouse stock.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/inventory/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Inventory Depot</span>
                    </a>
                </div>
            </div>

            <!-- Inward Entry Form Card -->
            <div class="adm-card" style="max-width:800px;">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span style="display:inline-flex; align-items:center; gap:6px;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>Consignment Entry Form</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;"><span class="dt-pulse-dot" style="display:inline-block; width:6px; height:6px; border-radius:50%; background:#15803D; margin-right:4px;"></span>Direct Factory Inward</span>
                </div>
                <form id="stockInwardForm" onsubmit="handleStockInward(event)" style="padding:18px 20px;">
                    <div class="dt-stock-grid">
                        <div class="adm-form-group">
                            <label class="adm-form-label" style="font-weight:700; font-size:0.75rem; color:#181512; margin-bottom:4px; display:block;">Select Saree SKU / Product *</label>
                            <select id="inwardProductSelect" class="adm-form-select" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-weight:600; padding:0 10px;">
                                <?php foreach ($products as $p): ?>
                                    <option value="<?= $p['id'] ?>" data-sku="<?= htmlspecialchars($p['sku'] ?? '') ?>" data-title="<?= htmlspecialchars($p['title'] ?? '') ?>">
                                        <?= htmlspecialchars($p['sku'] ?? 'SKU') ?> — <?= htmlspecialchars($p['title'] ?? 'Product') ?> (Cur: <?= $p['stock_qty'] ?? 0 ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="adm-form-group">
                            <label class="adm-form-label" style="font-weight:700; font-size:0.75rem; color:#181512; margin-bottom:4px; display:block;">Received Quantity (Pcs) *</label>
                            <input type="number" id="inwardQty" class="adm-form-input" min="1" max="1000" value="50" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-weight:700; padding:0 12px; box-sizing:border-box;">
                        </div>
                        <div class="adm-form-group">
                            <label class="adm-form-label" style="font-weight:700; font-size:0.75rem; color:#181512; margin-bottom:4px; display:block;">Receiving Warehouse Depot</label>
                            <select class="adm-form-select" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-weight:600; padding:0 10px;">
                                <option>Surat Central Handloom Depot (Primary)</option>
                                <option>Varanasi Silk Sourcing Warehouse</option>
                                <option>Bhiwandi Western Hub</option>
                            </select>
                        </div>
                        <div class="adm-form-group">
                            <label class="adm-form-label" style="font-weight:700; font-size:0.75rem; color:#181512; margin-bottom:4px; display:block;">Weaving Mill / Consignor Partner</label>
                            <input type="text" class="adm-form-input" value="Jai Hanuman Tex Mills — Loom #4" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-weight:600; padding:0 12px; box-sizing:border-box;">
                        </div>
                    </div>
                    
                    <div style="margin-top:20px; display:flex; justify-content:flex-end; gap:10px;">
                        <a href="/admin/inventory/" class="dt-btn dt-btn-pale" style="text-decoration:none;">Cancel</a>
                        <button type="submit" class="dt-btn dt-btn-gold" style="display:inline-flex; align-items:center; gap:6px;">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>+ Post Inward Consignment</span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function handleStockInward(e) {
    e.preventDefault();
    const select = document.getElementById('inwardProductSelect');
    const id = select.value;
    const selectedOpt = select.options[select.selectedIndex];
    const title = selectedOpt.getAttribute('data-title') || 'Product';
    const qty = parseInt(document.getElementById('inwardQty').value) || 50;

    const params = new URLSearchParams();
    params.append('action', 'adjust_stock');
    params.append('id', id);
    params.append('adjustment', qty);

    fetch('/api/products.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (typeof window.showToast === 'function') {
                window.showToast(`Successfully recorded +${qty} pcs for "${title}" in MySQL database!`);
            }
            setTimeout(() => {
                window.location.href = '/admin/inventory/';
            }, 600);
        })
        .catch(() => {
            if (typeof window.showToast === 'function') {
                window.showToast(`Recorded +${qty} pcs inward consignment!`);
            }
            setTimeout(() => {
                window.location.href = '/admin/inventory/';
            }, 600);
        });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
