<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-status.php — Status & Visibility Flags
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            <span>Visibility &amp; Publishing</span>
        </h3>
    </div>
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
        <div style="display:flex; flex-direction:column; gap:10px; margin-top:12px;">
            <label style="display:flex; align-items:center; gap:8px; font-size:12.5px; font-weight:600; cursor:pointer; color:#1d2327;">
                <input type="checkbox" checked>
                <svg viewBox="0 0 24 24" width="14" height="14" fill="#DBA617" stroke="#DBA617" stroke-width="1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <span>Mark as Featured Product</span>
            </label>
            <label style="display:flex; align-items:center; gap:8px; font-size:12.5px; font-weight:600; cursor:pointer; color:#1d2327;">
                <input type="checkbox" checked>
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#EA580C" stroke-width="2"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
                <span>Mark as Best Seller</span>
            </label>
            <label style="display:flex; align-items:center; gap:8px; font-size:12.5px; font-weight:600; cursor:pointer; color:#1d2327;">
                <input type="checkbox" checked>
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#0284C7" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <span>Mark as New Arrival</span>
            </label>
        </div>
    </div>
</div>
