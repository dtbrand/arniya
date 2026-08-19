<?php
/**
 * bulk-actions.php — Sticky Bulk Action Bar for Selected Products
 */
?>
<div class="dt-bulk-strip" id="dtBulkActionStrip">
    <div style="display:flex; align-items:center; gap:8px;">
        <span style="font-weight:800; color:#C5A859;">✓ <span id="dtSelectedCount">0</span> Products Selected</span>
    </div>
    <div class="dt-bulk-btns">
        <button type="button" class="dt-bulk-btn" onclick="window.executeBulkAction('Activate')">Activate</button>
        <button type="button" class="dt-bulk-btn" onclick="window.executeBulkAction('Deactivate')">Deactivate</button>
        <button type="button" class="dt-bulk-btn" onclick="window.executeBulkAction('Mark Featured')">Mark Featured</button>
        <button type="button" class="dt-bulk-btn" onclick="window.executeBulkAction('Change Category')">Change Category</button>
        <button type="button" class="dt-bulk-btn" onclick="window.exportCurrentTable('selected_products')">Export Selected</button>
        <button type="button" class="dt-bulk-btn danger" onclick="window.executeBulkAction('Delete')">🗑️ Delete</button>
    </div>
</div>
