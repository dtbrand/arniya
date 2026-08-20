<?php
/**
 * display-settings.php — Catalogue Display Grid & Column Configuration Component
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-cat-card">
    <div class="dt-cat-card-header">
        <h3 class="dt-cat-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
            <span>Catalogue Storefront Display &amp; Grid Settings</span>
        </h3>
        <button type="button" class="dt-btn-action-sm gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('✅ Display settings saved!')" style="height:28px; padding:0 12px; font-size:11px;">Save Display Settings</button>
    </div>

    <div style="padding:16px;">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:16px;">
            <div class="dt-form-group">
                <label class="dt-form-label">Desktop Grid Columns</label>
                <select class="dt-form-select">
                    <option value="4" selected>4 Columns (Recommended Wholesale)</option>
                    <option value="3">3 Columns (Luxury Large Cards)</option>
                    <option value="5">5 Columns (Compact)</option>
                    <option value="6">6 Columns (Ultra High-Density)</option>
                </select>
            </div>

            <div class="dt-form-group">
                <label class="dt-form-label">Products Per Page (Pagination)</label>
                <select class="dt-form-select">
                    <option value="24" selected>24 Products / Page</option>
                    <option value="48">48 Products / Page</option>
                    <option value="96">96 Products / Page</option>
                </select>
            </div>

            <div class="dt-form-group">
                <label class="dt-form-label">Image Aspect Ratio</label>
                <select class="dt-form-select">
                    <option value="3:4" selected>3:4 Vertical Portrait (Ethnic Standard)</option>
                    <option value="1:1">1:1 Square</option>
                </select>
            </div>
        </div>

        <hr style="border:none; border-top:1px solid #f1f5f9; margin:16px 0;">

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px;">
            <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                <input type="checkbox" checked style="width:15px; height:15px;">
                <span>Show Star Ratings</span>
            </label>
            <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                <input type="checkbox" checked style="width:15px; height:15px;">
                <span>Show Wholesale B2B Rate</span>
            </label>
            <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                <input type="checkbox" checked style="width:15px; height:15px;">
                <span>Show Resale Margin %</span>
            </label>
            <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                <input type="checkbox" checked style="width:15px; height:15px;">
                <span>Show 1-Click WhatsApp Lot Action</span>
            </label>
        </div>
    </div>
</div>
