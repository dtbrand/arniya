<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-inventory.php — Inventory & Stock Status
 *
 * Only stock_qty and status exist as columns, so only those two are offered
 * here. A "Low Stock Alert Limit" box (hardcoded to 5) and a "Primary Warehouse
 * Depot" selector used to sit in this section; neither had a column to be saved
 * into and nothing ever read them, so they recorded a warehouse choice that was
 * silently discarded on every save.
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><rect x="1" y="3" width="22" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
            <span>Inventory &amp; Availability</span>
        </h3>
    </div>
    <div class="dt-form-sec-body">
        <div class="adm-form-grid">
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormStock">Stock Quantity (Units)</label>
                <input type="number" min="0" step="1" id="pFormStock" class="adm-form-input" placeholder="e.g. 24"
                       value="<?php echo isset($prod['stock_qty']) ? (int)$prod['stock_qty'] : ''; ?>">
                <small style="font-size:10.5px; color:#646970;">Left blank this is saved as 0. It used to default to 50 units the shop did not have.</small>
            </div>
            <div class="adm-form-group full">
                <label class="adm-form-label" for="pFormStockStatus">Stock Status</label>
                <select id="pFormStockStatus" class="adm-form-select">
                    <?php $statusVal = $prod['status'] ?? 'in_stock'; ?>
                    <option value="in_stock" <?php echo ($statusVal === 'in_stock') ? 'selected' : ''; ?>>In Stock</option>
                    <option value="low_stock" <?php echo ($statusVal === 'low_stock') ? 'selected' : ''; ?>>Low Stock</option>
                    <option value="out_of_stock" <?php echo ($statusVal === 'out_of_stock') ? 'selected' : ''; ?>>Out of Stock</option>
                    <option value="draft" <?php echo ($statusVal === 'draft') ? 'selected' : ''; ?>>Draft (hidden from the shop)</option>
                </select>
            </div>
        </div>
    </div>
</div>
