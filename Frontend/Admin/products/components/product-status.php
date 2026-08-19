<?php
/**
 * product-status.php — Status & Visibility Flags
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head"><h3 class="dt-form-sec-title"><span>👁️ Visibility &amp; Publishing</span></h3></div>
    <div class="dt-form-sec-body">
        <div class="adm-form-group" style="margin-bottom:12px;">
            <label class="adm-form-label">Catalog Status</label>
            <select class="adm-form-select">
                <option selected>Published (Live in Shop &amp; B2B)</option>
                <option>Draft (Admin View Only)</option>
                <option>Inactive / Paused</option>
                <option>Scheduled Release</option>
            </select>
        </div>
        <div style="display:flex; flex-direction:column; gap:10px; margin-top:14px;">
            <label style="display:flex; align-items:center; gap:8px; font-size:0.82rem; font-weight:700; cursor:pointer;">
                <input type="checkbox" checked> ⭐️ Mark as Featured Product
            </label>
            <label style="display:flex; align-items:center; gap:8px; font-size:0.82rem; font-weight:700; cursor:pointer;">
                <input type="checkbox" checked> 🔥 Mark as Best Seller
            </label>
            <label style="display:flex; align-items:center; gap:8px; font-size:0.82rem; font-weight:700; cursor:pointer;">
                <input type="checkbox" checked> ✨ Mark as New Arrival
            </label>
        </div>
    </div>
</div>
