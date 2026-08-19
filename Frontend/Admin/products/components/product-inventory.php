<?php
/**
 * product-inventory.php — Inventory & Warehouse Stock Matrix
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><rect x="1" y="3" width="22" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
            <span>Warehouse Stock Allocation</span>
        </h3>
    </div>
    <div class="dt-form-sec-body">
        <div class="adm-form-grid">
            <div class="adm-form-group">
                <label class="adm-form-label">Total Stock Quantity (Units)</label>
                <input type="number" class="adm-form-input" value="45">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Low Stock Alert Limit</label>
                <input type="number" class="adm-form-input" value="5">
            </div>
            <div class="adm-form-group full">
                <label class="adm-form-label">Primary Warehouse Depot</label>
                <select class="adm-form-select">
                    <option>Surat Central Hub (Mill Depot)</option>
                    <option>Bhiwandi Textile Depot</option>
                </select>
            </div>
            <div class="adm-form-group full">
                <label class="adm-form-label">Stock Status</label>
                <select class="adm-form-select">
                    <option selected>In Stock</option>
                    <option>Low Stock</option>
                    <option>Out of Stock</option>
                    <option>Backorder Allowed</option>
                </select>
            </div>
        </div>
    </div>
</div>
