<?php
/**
 * bulk-actions.php — Sticky Multi-Selection Bulk Actions Bar
 */
?>
<div class="dt-bulk-strip" id="dtBulkActionStrip">
    <div style="display:flex; align-items:center; gap:10px;">
        <span style="font-weight:800; color:#C5A859;">✓ <span id="dtSelectedCount">0</span> Products Selected</span>
    </div>
    <div class="dt-bulk-btns">
        <button type="button" class="dt-bulk-btn" onclick="window.executeBulkAction('Activate')">🟢 Activate</button>
        <button type="button" class="dt-bulk-btn" onclick="window.executeBulkAction('Deactivate')">⏸️ Deactivate</button>
        <button type="button" class="dt-bulk-btn" onclick="window.executeBulkAction('Mark Featured')">⭐️ Feature</button>
        <button type="button" class="dt-bulk-btn" onclick="window.executeBulkAction('Mark Best Seller')">🔥 Best Seller</button>
        <button type="button" class="dt-bulk-btn" onclick="window.executeBulkAction('Mark New Arrival')">✨ New Arrival</button>
        <button type="button" class="dt-bulk-btn" onclick="window.executeBulkAction('Change Category')">📁 Category</button>
        <button type="button" class="dt-bulk-btn" onclick="window.exportCurrentTable('selected_products')">📥 Export Selected</button>
        <button type="button" class="dt-bulk-btn danger" onclick="window.executeBulkAction('Delete')">🗑️ Delete</button>
    </div>
</div>
