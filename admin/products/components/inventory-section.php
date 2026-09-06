<?php
/**
 * inventory-section.php — Inventory & Warehouse Stock Allocation
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title" style="display:flex; align-items:center; gap:8px;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 20a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8l-7 5V8l-7 5V4a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><path d="M18 17h2"></path><path d="M18 13h2"></path><path d="M14 17h2"></path><path d="M14 13h2"></path></svg>
            <span>Warehouse Stock Allocation</span>
        </h3>
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
