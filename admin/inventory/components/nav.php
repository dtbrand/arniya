<?php
/**
 * nav.php — Reusable Inventory Module Sub-Navigation Bar
 * DT Brand's & Jai Hanuman Tex — Master Wholesale Architecture
 */
$current_page = basename($_SERVER['PHP_SELF'] ?? 'index.php');
?>
<div class="dt-inv-nav-bar" style="display:flex; align-items:center; gap:8px; overflow-x:auto; padding:6px 0 16px 0; margin-bottom:16px; border-bottom:1px solid #EAE5D9;">
    <a href="/admin/inventory/index.php" class="dt-btn <?= $current_page === 'index.php' ? 'dt-btn-gold' : 'dt-btn-pale' ?>" style="text-decoration:none; height:32px; font-size:12px; font-weight:750; display:inline-flex; align-items:center; gap:6px; white-space:nowrap; padding:0 12px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
        <span>Stock Overview</span>
    </a>
    <a href="/admin/inventory/stock-in.php" class="dt-btn <?= $current_page === 'stock-in.php' ? 'dt-btn-gold' : 'dt-btn-pale' ?>" style="text-decoration:none; height:32px; font-size:12px; font-weight:750; display:inline-flex; align-items:center; gap:6px; white-space:nowrap; padding:0 12px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
        <span>+ Stock Inward</span>
    </a>
    <a href="/admin/inventory/stock-out.php" class="dt-btn <?= $current_page === 'stock-out.php' ? 'dt-btn-gold' : 'dt-btn-pale' ?>" style="text-decoration:none; height:32px; font-size:12px; font-weight:750; display:inline-flex; align-items:center; gap:6px; white-space:nowrap; padding:0 12px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
        <span>- Stock Outward</span>
    </a>
    <a href="/admin/inventory/adjustment.php" class="dt-btn <?= $current_page === 'adjustment.php' ? 'dt-btn-gold' : 'dt-btn-pale' ?>" style="text-decoration:none; height:32px; font-size:12px; font-weight:750; display:inline-flex; align-items:center; gap:6px; white-space:nowrap; padding:0 12px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect><path d="M9 14l2 2 4-4"></path></svg>
        <span>Reconciliation</span>
    </a>
    <a href="/admin/inventory/low-stock.php" class="dt-btn <?= $current_page === 'low-stock.php' ? 'dt-btn-gold' : 'dt-btn-pale' ?>" style="text-decoration:none; height:32px; font-size:12px; font-weight:750; display:inline-flex; align-items:center; gap:6px; white-space:nowrap; padding:0 12px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
        <span>Low Stock Alarms</span>
    </a>
    <a href="/admin/inventory/ledger.php" class="dt-btn <?= $current_page === 'ledger.php' ? 'dt-btn-gold' : 'dt-btn-pale' ?>" style="text-decoration:none; height:32px; font-size:12px; font-weight:750; display:inline-flex; align-items:center; gap:6px; white-space:nowrap; padding:0 12px;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
        <span>Inventory Ledger</span>
    </a>
    <a href="/admin/inventory/export.php" class="dt-btn <?= $current_page === 'export.php' ? 'dt-btn-gold' : 'dt-btn-pale' ?>" style="text-decoration:none; height:32px; font-size:12px; font-weight:750; display:inline-flex; align-items:center; gap:6px; white-space:nowrap; padding:0 12px; margin-left:auto;">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
        <span>Export Stock CSV</span>
    </a>
</div>
