<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * bulk-actions.php — Sticky Multi-Selection Bulk Actions Bar with Vector SVGs
 */
?>
<div class="dt-bulk-strip" id="dtBulkActionStrip">
    <div style="display:flex; align-items:center; gap:10px;">
        <span style="font-weight:800; color:#C5A859; display:flex; align-items:center; gap:6px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span><span id="dtSelectedCount">0</span> Selected</span>
        </span>
    </div>
    <div class="dt-bulk-btns">
        <button type="button" class="dt-bulk-btn" onclick="window.executeBulkAction('Activate')">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#22C55E" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <span>Activate</span>
        </button>
        <button type="button" class="dt-bulk-btn" onclick="window.executeBulkAction('Deactivate')">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#E2E8F0" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="10" y1="15" x2="10" y2="9"></line><line x1="14" y1="15" x2="14" y2="9"></line></svg>
            <span>Deactivate</span>
        </button>
        <button type="button" class="dt-bulk-btn" onclick="window.executeBulkAction('Mark Featured')">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#F59E0B" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            <span>Feature</span>
        </button>
        <button type="button" class="dt-bulk-btn" onclick="window.executeBulkAction('Mark Best Seller')">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#EC4899" stroke-width="2"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
            <span>Best Seller</span>
        </button>
        <button type="button" class="dt-bulk-btn" onclick="window.executeBulkAction('Change Category')">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
            <span>Category</span>
        </button>
        <button type="button" class="dt-bulk-btn" onclick="window.exportCurrentTable('selected_products')">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            <span>Export</span>
        </button>
        <button type="button" class="dt-bulk-btn danger" onclick="window.executeBulkAction('Delete')">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            <span>Delete</span>
        </button>
    </div>
</div>
