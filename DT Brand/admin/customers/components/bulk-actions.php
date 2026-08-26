<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * bulk-actions.php — Floating Bulk Action Toolbar Component
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
?>

<!-- ══ FLOATING BULK ACTIONS TOOLBAR ══ -->
<div id="dtCustBulkBar" class="dt-cust-bulk-bar">
    <span id="dtCustBulkCount" class="dt-cust-bulk-count">0 Customers Selected</span>
    
    <div style="display:flex; align-items:center; gap:8px;">
        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="bulkAddTagModal()">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
            <span>Assign Tag</span>
        </button>

        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="bulkActivateCustomers()">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <span>Activate</span>
        </button>

        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="bulkDeactivateCustomers()">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            <span>Deactivate</span>
        </button>

        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="bulkExportCustomers()">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            <span>Export CSV</span>
        </button>

        <button type="button" onclick="clearCustomerSelection()" style="background:none; border:none; color:#9CA3AF; font-size:1.1rem; cursor:pointer; padding:2px 6px;" title="Clear Selection">✕</button>
    </div>
</div>
