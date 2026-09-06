<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * bulk-actions.php — Floating Bulk Action Toolbar Component
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
?>

<!-- ══ FLOATING BULK ACTIONS TOOLBAR ══ -->
<!--
  The "Assign Tag" button is gone: there is no tags table and no column on
  `customers` that could hold one, so it prompted for a tag name, reported it
  assigned and stored nothing. Tier is the classification that is really saved,
  and it is edited per customer.

  "Deactivate" is now "Suspend" — customers.status is an ENUM of exactly
  active | pending | suspended, so there is no inactive state to deactivate into,
  and the button really does suspend (which blocks sign-in and trade pricing).
-->
<div id="dtCustBulkBar" class="dt-cust-bulk-bar">
    <span id="dtCustBulkCount" class="dt-cust-bulk-count">0 Customers Selected</span>

    <div style="display:flex; align-items:center; gap:8px;">
        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="bulkActivateCustomers()" title="Set status to active — the customer can sign in">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <span>Activate</span>
        </button>

        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="bulkDeactivateCustomers()" title="Set status to suspended — blocks sign-in and trade pricing">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
            <span>Suspend</span>
        </button>

        <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="bulkExportCustomers()" title="Opens the Export Studio — it exports by cohort, not by selection">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            <span>Export Studio</span>
        </button>

        <button type="button" class="dt-btn dt-btn-pale dt-modal-close-btn" onclick="clearCustomerSelection()" style="width:26px; height:26px; border-radius:6px; padding:0; display:inline-flex; align-items:center; justify-content:center; cursor:pointer;" title="Clear Selection" aria-label="Clear Selection">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
</div>
