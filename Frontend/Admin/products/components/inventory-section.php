<?php
/**
 * inventory-section.php — Inventory & Warehouse Stock Allocation
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title"><span>🏭 Warehouse Stock Allocation</span></h3>
    </div>
    <div class="dt-form-sec-body">
        <div class="adm-form-grid">
            <div class="adm-form-group">
                <label class="adm-form-label">Total Stock (Units)</label>
                <input type="number" class="adm-form-input" value="45">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Low Stock Threshold</label>
                <input type="number" class="adm-form-input" value="5">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Primary Warehouse Hub</label>
                <select class="adm-form-select">
                    <option>Surat Central Hub (Main Depot)</option>
                    <option>Bhiwandi Textile Depot</option>
                </select>
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Stock Status</label>
                <select class="adm-form-select">
                    <option>In Stock</option>
                    <option>Low Stock</option>
                    <option>Out of Stock</option>
                    <option>Backorder Allowed</option>
                </select>
            </div>
        </div>
    </div>
</div>
