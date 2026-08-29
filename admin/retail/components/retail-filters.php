<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * retail-filters.php — DT Brand's & Jai Hanuman Tex
 * Retail Advanced Multi-Attribute Filter Drawer Component
 */
?>

<div id="dtRetailFilterDrawer" class="dt-modal-backdrop">
    <div class="dt-modal-dialog" style="max-width:440px;">
        <div class="dt-modal-head">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Filter Retail Activity</strong>
            </div>
            <button type="button" onclick="toggleRetailFilterDrawer()" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <div class="dt-modal-body">
            <div>
                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Date Range</label>
                <select class="dt-retail-input dt-retail-filter-input" style="width:100%; height:34px; border:1.2px solid #EAE5D9; border-radius:6px; padding:0 8px; font-size:0.78rem;">
                    <option value="all">All Time</option>
                    <option value="today">Today</option>
                    <option value="7d">Last 7 Days</option>
                    <option value="30d">Last 30 Days</option>
                    <option value="this_month">This Month</option>
                </select>
            </div>

            <div>
                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Fulfillment Status</label>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:6px; font-size:0.75rem;">
                    <label style="display:flex; align-items:center; gap:6px;"><input type="checkbox" class="dt-retail-filter-input"> Delivered</label>
                    <label style="display:flex; align-items:center; gap:6px;"><input type="checkbox" class="dt-retail-filter-input"> In Transit</label>
                    <label style="display:flex; align-items:center; gap:6px;"><input type="checkbox" class="dt-retail-filter-input"> Processing</label>
                    <label style="display:flex; align-items:center; gap:6px;"><input type="checkbox" class="dt-retail-filter-input"> Returned</label>
                </div>
            </div>

            <div>
                <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Minimum Order Value (₹)</label>
                <input type="number" class="dt-retail-input dt-retail-filter-input" placeholder="e.g. 2000" style="width:100%; height:34px; border:1.2px solid #EAE5D9; border-radius:6px; padding:0 8px; font-size:0.78rem;">
            </div>
        </div>

        <div class="dt-modal-foot">
            <button type="button" class="dt-btn dt-btn-pale" onclick="resetRetailFilters()">Reset</button>
            <button type="button" class="dt-btn dt-btn-gold" onclick="applyRetailFilters()">Apply Filters</button>
        </div>
    </div>
</div>
