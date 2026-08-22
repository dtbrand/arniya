<?php
/**
 * wholesale-filters.php — Advanced Commercial Filter Drawer
 */
?>
<div id="dtWholesaleAdvancedFiltersBox" style="display:none; padding:14px 18px; background:#FAF8F4; border-bottom:1.5px solid #EAE5D9;">
    <form id="wholesaleFilterForm" onsubmit="event.preventDefault(); filterWholesaleTable();">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:12px; margin-bottom:12px;">
            <div>
                <label style="font-size:0.7rem; font-weight:800; color:#78716C; display:block; margin-bottom:4px;">PAYMENT TERMS</label>
                <select class="dt-wholesale-select" style="width:100%; height:32px; font-size:0.74rem; border-radius:6px; border:1px solid #EAE5D9;">
                    <option value="">Any Terms</option>
                    <option>Net 30 Days</option>
                    <option>Net 45 Days</option>
                    <option>Net 15 Days</option>
                    <option>Advance 50%</option>
                    <option>Prepaid</option>
                </select>
            </div>

            <div>
                <label style="font-size:0.7rem; font-weight:800; color:#78716C; display:block; margin-bottom:4px;">KYC VERIFICATION</label>
                <select class="dt-wholesale-select" style="width:100%; height:32px; font-size:0.74rem; border-radius:6px; border:1px solid #EAE5D9;">
                    <option value="">All KYC States</option>
                    <option>Verified KYC</option>
                    <option>Pending Audit</option>
                    <option>Rejected Documents</option>
                </select>
            </div>

            <div>
                <label style="font-size:0.7rem; font-weight:800; color:#78716C; display:block; margin-bottom:4px;">MIN PURCHASE VALUE (₹)</label>
                <input type="number" class="dt-wholesale-input" placeholder="e.g. 500000" style="width:100%; height:32px; font-size:0.74rem; border-radius:6px; border:1px solid #EAE5D9;">
            </div>

            <div>
                <label style="font-size:0.7rem; font-weight:800; color:#78716C; display:block; margin-bottom:4px;">REGISTRATION STATE</label>
                <select class="dt-wholesale-select" style="width:100%; height:32px; font-size:0.74rem; border-radius:6px; border:1px solid #EAE5D9;">
                    <option value="">All India</option>
                    <option>Gujarat</option>
                    <option>Uttar Pradesh</option>
                    <option>Rajasthan</option>
                    <option>Tamil Nadu</option>
                    <option>West Bengal</option>
                    <option>Maharashtra</option>
                </select>
            </div>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:8px;">
            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="resetAdvancedFilters()">Reset</button>
            <button type="submit" class="dt-btn dt-btn-gold dt-btn-sm">Apply Filters</button>
        </div>
    </form>
</div>
