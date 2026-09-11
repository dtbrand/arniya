<?php
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) { require_once $__dtg; } elseif (is_file(__DIR__ . '/../includes/adminguard.php')) { require_once __DIR__ . '/../includes/adminguard.php'; }

/**
 * ledger.php — Central Warehouse Inventory Movement Ledger & Audit Trail
 * DT Brand's & Jai Hanuman Tex — Master Wholesale Architecture
 */

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/ProductCatalog.php';
require_once __DIR__ . '/../../src/InventoryManager.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;
use DTBrand\InventoryManager;

$page_title = "Inventory Movement Ledger & Audit Trail";
$active_nav = "inventory";
$active_subnav = "ledger";

// Filters
$filters = [
    'search' => trim($_GET['search'] ?? ''),
    'movement_type' => trim($_GET['movement_type'] ?? 'all'),
    'from_date' => trim($_GET['from_date'] ?? ''),
    'to_date' => trim($_GET['to_date'] ?? '')
];

$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 30;
$offset = ($page - 1) * $perPage;

$totalRecords = InventoryManager::getLedgerCount($filters);
$totalPages = max(1, (int)ceil($totalRecords / $perPage));
$ledgerRecords = InventoryManager::getLedger($filters, $perPage, $offset);
$metrics = InventoryManager::getSummaryMetrics();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Movement Ledger — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-badge-inward { background:#DCFCE7; color:#15803D; border:1px solid #86EFAC; font-weight:750; }
        .dt-badge-outward { background:#FEF2F2; color:#DC2626; border:1px solid #FCA5A5; font-weight:750; }
        .dt-badge-adjustment { background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:750; }
        .dt-badge-deduction { background:#FEF3C7; color:#B45309; border:1px solid #FCD34D; font-weight:750; }
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
                        <span>Inventory Movement Ledger</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?= number_format($totalRecords) ?> Audit Entries</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Real-time append-only transaction ledger for factory inward consignments, B2B parcel outbounds, and cycle reconciliations.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/inventory/export.php?type=ledger" class="dt-btn dt-btn-gold" style="text-decoration:none; height:32px; font-size:12px; font-weight:750; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                        <span>Download Ledger CSV</span>
                    </a>
                </div>
            </div>

            <!-- Submodule Navigation -->
            <?php include_once __DIR__ . '/components/nav.php'; ?>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid" style="margin-bottom:16px;">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Active Depot SKUs</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= number_format($metrics['total_skus']) ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up"><?= number_format($metrics['total_stock_units']) ?> Available Units</span>
                    </div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Inventory Valuation</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $metrics['valuation_formatted'] ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">At Wholesale Base Price</span>
                    </div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Total Audit Events</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= number_format($totalRecords) ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Append-Only Audit</span>
                    </div>
                </div>

                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Safety Alert SKUs</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $metrics['low_stock_count'] + $metrics['out_of_stock_count'] ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta down"><?= $metrics['out_of_stock_count'] ?> Out of Stock</span>
                    </div>
                </div>
            </div>

            <!-- Ledger Filter Card -->
            <div class="adm-card" style="margin-bottom:16px;">
                <form method="GET" action="/admin/inventory/ledger.php" style="padding:14px 16px; display:flex; flex-wrap:wrap; gap:12px; align-items:flex-end;">
                    <div style="flex:1; min-width:200px;">
                        <label style="font-size:11px; font-weight:750; color:#181512; display:block; margin-bottom:4px;">Search SKU / Product / Ref</label>
                        <input type="text" name="search" value="<?= htmlspecialchars($filters['search']) ?>" placeholder="e.g. DT-SR-01 or PO-9921" class="adm-form-input" style="height:36px; border:1.5px solid #EAE5D9; border-radius:6px; font-weight:600; padding:0 10px; width:100%; box-sizing:border-box;">
                    </div>

                    <div style="width:180px;">
                        <label style="font-size:11px; font-weight:750; color:#181512; display:block; margin-bottom:4px;">Movement Type</label>
                        <select name="movement_type" class="adm-form-select" style="height:36px; border:1.5px solid #EAE5D9; border-radius:6px; font-weight:600; padding:0 10px; width:100%; box-sizing:border-box;">
                            <option value="all" <?= $filters['movement_type'] === 'all' ? 'selected' : '' ?>>All Movement Types</option>
                            <option value="inward" <?= $filters['movement_type'] === 'inward' ? 'selected' : '' ?>>+ Inward (Mill Consignment)</option>
                            <option value="outward" <?= $filters['movement_type'] === 'outward' ? 'selected' : '' ?>>- Outward (Dispatch)</option>
                            <option value="order_deduction" <?= $filters['movement_type'] === 'order_deduction' ? 'selected' : '' ?>>- Order Deduction (Sale)</option>
                            <option value="adjustment" <?= $filters['movement_type'] === 'adjustment' ? 'selected' : '' ?>>Physical Reconciliation</option>
                            <option value="order_cancellation" <?= $filters['movement_type'] === 'order_cancellation' ? 'selected' : '' ?>>+ Order Cancellation Restock</option>
                        </select>
                    </div>

                    <div style="width:140px;">
                        <label style="font-size:11px; font-weight:750; color:#181512; display:block; margin-bottom:4px;">From Date</label>
                        <input type="date" name="from_date" value="<?= htmlspecialchars($filters['from_date']) ?>" class="adm-form-input" style="height:36px; border:1.5px solid #EAE5D9; border-radius:6px; font-weight:600; padding:0 8px; width:100%; box-sizing:border-box;">
                    </div>

                    <div style="width:140px;">
                        <label style="font-size:11px; font-weight:750; color:#181512; display:block; margin-bottom:4px;">To Date</label>
                        <input type="date" name="to_date" value="<?= htmlspecialchars($filters['to_date']) ?>" class="adm-form-input" style="height:36px; border:1.5px solid #EAE5D9; border-radius:6px; font-weight:600; padding:0 8px; width:100%; box-sizing:border-box;">
                    </div>

                    <div style="display:flex; gap:6px;">
                        <button type="submit" class="dt-btn dt-btn-gold" style="height:36px; padding:0 16px; font-size:12px; font-weight:800;">Filter</button>
                        <a href="/admin/inventory/ledger.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:36px; padding:0 12px; font-size:12px; font-weight:700; display:inline-flex; align-items:center;">Reset</a>
                    </div>
                </form>
            </div>

            <!-- Ledger Table Card -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title" style="display:flex; align-items:center; gap:8px;">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>Stock Movement Journal (Page <?= $page ?> of <?= $totalPages ?>)</span>
                    </h3>
                    <span class="adm-badge gold" style="font-size:11px;">Surat Central Depot</span>
                </div>
                <div class="adm-table-responsive">
                    <table class="adm-table">
                        <thead>
                            <tr>
                                <th>Timestamp</th>
                                <th>SKU &amp; Product Title</th>
                                <th>Type</th>
                                <th>Before</th>
                                <th>Movement</th>
                                <th>After</th>
                                <th>Reason / Order Reference</th>
                                <th style="text-align:right;">Auditor / Operator</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ledgerRecords)): ?>
                                <?php foreach ($ledgerRecords as $rec): ?>
                                    <?php
                                    $mtype = $rec['movement_type'];
                                    $badgeClass = match($mtype) {
                                        'inward', 'order_cancellation' => 'dt-badge-inward',
                                        'outward' => 'dt-badge-outward',
                                        'order_deduction' => 'dt-badge-deduction',
                                        default => 'dt-badge-adjustment'
                                    };
                                    $badgeLabel = match($mtype) {
                                        'inward' => 'INWARD',
                                        'outward' => 'OUTWARD',
                                        'order_deduction' => 'ORDER SALE',
                                        'order_cancellation' => 'RESTOCK',
                                        default => 'RECONCILE'
                                    };
                                    $adj = (int)$rec['adjustment_qty'];
                                    $adjFormatted = ($adj > 0 ? "+{$adj}" : (string)$adj) . ' pcs';
                                    $adjColor = $adj > 0 ? '#15803D' : ($adj < 0 ? '#DC2626' : '#64748B');
                                    ?>
                                    <tr>
                                        <td>
                                            <span style="font-weight:700; color:#181512;"><?= date('d M Y', strtotime($rec['created_at'])) ?></span><br>
                                            <small style="color:#64748B; font-size:10.5px;"><?= date('h:i:s A', strtotime($rec['created_at'])) ?></small>
                                        </td>
                                        <td>
                                            <code style="background:#FAF5E8; padding:2px 6px; border-radius:4px; color:#8A681F; font-weight:750; border:1px solid #D4AF37; font-size:11px;"><?= htmlspecialchars($rec['sku'] ?: 'DT-SKU') ?></code>
                                            <div style="font-weight:700; font-size:12px; margin-top:2px; color:#181512;"><?= htmlspecialchars($rec['product_title']) ?></div>
                                        </td>
                                        <td>
                                            <span class="adm-badge <?= $badgeClass ?>" style="padding:2px 8px; font-size:10.5px; border-radius:4px;"><?= $badgeLabel ?></span>
                                        </td>
                                        <td><span style="color:#64748B; font-weight:600;"><?= (int)$rec['previous_qty'] ?></span></td>
                                        <td>
                                            <strong style="color:<?= $adjColor ?>; font-size:12.5px;"><?= $adjFormatted ?></strong>
                                        </td>
                                        <td>
                                            <strong style="color:#181512; font-size:12.5px;"><?= (int)$rec['new_qty'] ?></strong>
                                        </td>
                                        <td>
                                            <div style="color:#181512; font-weight:600; font-size:11.5px;"><?= htmlspecialchars($rec['reason'] ?: '—') ?></div>
                                            <?php if (!empty($rec['reference_id'])): ?>
                                                <small style="color:#8A681F; font-weight:700;">Ref: #<?= htmlspecialchars($rec['reference_id']) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align:right;">
                                            <span style="color:#475569; font-weight:700; font-size:11.5px;"><?= htmlspecialchars($rec['operator'] ?: 'Surat Dock') ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="text-align:center; padding:36px; color:#64748B;">
                                        No inventory movements recorded yet matching these filters.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <div style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-size:12px; color:#64748B;">Showing page <strong><?= $page ?></strong> of <strong><?= $totalPages ?></strong> (<?= number_format($totalRecords) ?> total records)</span>
                        <div style="display:flex; gap:6px;">
                            <?php if ($page > 1): ?>
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>" class="dt-btn dt-btn-pale" style="text-decoration:none; padding:4px 10px; font-size:12px; font-weight:700;">&larr; Previous</a>
                            <?php endif; ?>
                            <?php if ($page < $totalPages): ?>
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>" class="dt-btn dt-btn-pale" style="text-decoration:none; padding:4px 10px; font-size:12px; font-weight:700;">Next &rarr;</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
