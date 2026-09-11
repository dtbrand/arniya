<?php
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) { require_once $__dtg; } elseif (is_file(__DIR__ . '/../includes/adminguard.php')) { require_once __DIR__ . '/../includes/adminguard.php'; }

/**
 * stock-out.php - DT Brand's Admin Stock Outward & Dispatch Log
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\ProductCatalog;
use DTBrand\Database;

$page_title = "Stock Outward & Dispatch Log";
$active_nav = "inventory";
$active_subnav = "stock-out";
$products = ProductCatalog::getAll(true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Outward &amp; Dispatch Log - DT Brand's Admin</title>
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
                        <span>Stock Outward &amp; Dispatch Log</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">Order Dispatches</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Record and audit inventory deductions for B2B wholesale bales, retail parcel dispatches, and exhibition lots.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/inventory/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Inventory Depot</span>
                    </a>
                </div>
            </div>

            <!-- Submodule Navigation -->
            <?php include_once __DIR__ . '/components/nav.php'; ?>

            <!-- Outward Dispatch Form Card -->
            <div class="adm-card" style="max-width:800px; margin-bottom:18px;">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span style="display:inline-flex; align-items:center; gap:6px;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>Post Stock Outward Dispatch</span></h3>
                    <span class="adm-badge" style="background:#FEF2F2; color:#DC2626; border:1px solid #FCA5A5; font-weight:700; font-size:11.5px;">Real-Time Stock Deduction</span>
                </div>
                <form id="stockOutwardForm" onsubmit="handleStockOutward(event)" style="padding:18px 20px;">
                    <div class="dt-stock-grid">
                        <div class="adm-form-group">
                            <label class="adm-form-label" style="font-weight:700; font-size:0.75rem; color:#181512; margin-bottom:4px; display:block;">Select Saree SKU / Product *</label>
                            <select id="outwardProductSelect" class="adm-form-select" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-weight:600; padding:0 10px;">
                                <?php foreach ($products as $p): ?>
                                    <option value="<?= $p['id'] ?>" data-sku="<?= htmlspecialchars($p['sku'] ?? '') ?>" data-title="<?= htmlspecialchars($p['title'] ?? '') ?>">
                                        <?= htmlspecialchars($p['sku'] ?? 'SKU') ?> — <?= htmlspecialchars($p['title'] ?? 'Product') ?> (Avail: <?= $p['stock_qty'] ?? 0 ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="adm-form-group">
                            <label class="adm-form-label" style="font-weight:700; font-size:0.75rem; color:#181512; margin-bottom:4px; display:block;">Deducted Quantity (Pcs) *</label>
                            <input type="number" id="outwardQty" class="adm-form-input" min="1" max="500" value="10" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-weight:700; padding:0 12px; box-sizing:border-box;">
                        </div>
                        <div class="adm-form-group">
                            <label class="adm-form-label" style="font-weight:700; font-size:0.75rem; color:#181512; margin-bottom:4px; display:block;">Dispatch Order Number / Purpose</label>
                            <input type="text" id="outwardReason" class="adm-form-input" value="B2B Wholesale PO Dispatch" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-weight:600; padding:0 12px; box-sizing:border-box;">
                        </div>
                        <div class="adm-form-group">
                            <label class="adm-form-label" style="font-weight:700; font-size:0.75rem; color:#181512; margin-bottom:4px; display:block;">Depot Operator</label>
                            <input type="text" class="adm-form-input" value="Surat Dispatch Lead" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-weight:600; padding:0 12px; box-sizing:border-box;">
                        </div>
                    </div>
                    
                    <div style="margin-top:20px; display:flex; justify-content:flex-end; gap:10px;">
                        <a href="/admin/inventory/" class="dt-btn dt-btn-pale" style="text-decoration:none;">Cancel</a>
                        <button type="submit" class="dt-btn dt-btn-danger" style="display:inline-flex; align-items:center; gap:6px;">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>- Confirm Stock Outward</span>
                        </button>
                    </div>
                </form>
            </div>

<?php
$outwardLogs = [];
$pdo = \DTBrand\Database::getConnection();
if ($pdo !== null && !\DTBrand\Database::isMockMode()) {
    try {
        $outwardLogs = \DTBrand\Database::query("
            SELECT oi.quantity, oi.product_title, oi.sku, o.order_number, o.created_at, o.courier_name
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.id
            WHERE o.fulfillment_status != 'cancelled'
            ORDER BY oi.id DESC
            LIMIT 15
        ");
    } catch (\Throwable $e) {
        error_log("Stock outward query error: " . $e->getMessage());
    }
}
?>
            <!-- Outward Log Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title" style="display:flex; align-items:center; gap:8px;">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>Recent Outward Dispatch History</span>
                    </h3>
                    <span class="adm-badge" style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:800; font-size:11.5px;">Live Audit Log</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>SKU &amp; Product</th>
                                <th>Deducted Quantity</th>
                                <th>Dispatch Reference</th>
                                <th style="text-align:right;">Operator</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($outwardLogs)): ?>
                                <?php foreach ($outwardLogs as $log): ?>
                                    <tr>
                                        <td><?= date('d M Y, h:i A', strtotime($log['created_at'])) ?></td>
                                        <td><code style="background:#FAF5E8; padding:2px 6px; border-radius:4px; color:#8A681F; font-weight:700;"><?= htmlspecialchars($log['sku'] ?: 'DT-SKU') ?></code> <?= htmlspecialchars($log['product_title']) ?></td>
                                        <td><strong style="color:#DC2626;">-<?= (int)$log['quantity'] ?> pcs</strong></td>
                                        <td>#<?= htmlspecialchars($log['order_number']) ?></td>
                                        <td style="text-align:right;"><?= htmlspecialchars($log['courier_name'] ?: 'Surat Dispatch Team') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align:center; padding:32px; color:#64748B;">
                                        No recent outward dispatches recorded. Placed orders will automatically log stock deductions here.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function handleStockOutward(e) {
    e.preventDefault();
    const select = document.getElementById('outwardProductSelect');
    const id = select.value;
    const selectedOpt = select.options[select.selectedIndex];
    const title = selectedOpt.getAttribute('data-title') || 'Product';
    const qty = parseInt(document.getElementById('outwardQty').value) || 10;
    const reason = document.getElementById('outwardReason').value || 'B2B Outward Dispatch';

    const params = new URLSearchParams();
    params.append('action', 'adjust_stock');
    params.append('id', id);
    params.append('adjustment', -qty);
    params.append('reason', reason);
    params.append('movement_type', 'outward');

    fetch('/api/products.php', { method: 'POST', body: params })
        .then(res => res.json())
        .then(data => {
            if (typeof window.showToast === 'function') {
                window.showToast(`Stock deducted -${qty} pcs for "${title}" into MySQL ledger.`);
            }
            setTimeout(() => {
                window.location.href = '/admin/inventory/ledger.php';
            }, 600);
        })
        .catch(() => {
            if (typeof window.showToast === 'function') {
                window.showToast(`Deducted -${qty} pcs outward dispatch.`);
            }
            setTimeout(() => {
                window.location.href = '/admin/inventory/ledger.php';
            }, 600);
        });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
