<?php
/**
 * wholesale-filters.php — DT Brand's & Jai Hanuman Tex
 * Luxury Slide-Over Right Filter Drawer Component
 */
?>
<!-- ══ Backdrop Blur Overlay ══ -->
<div id="dtWholesaleDrawerBackdrop" class="dt-drawer-backdrop" onclick="toggleAdvancedFilters(false)"></div>

<!-- ══ Slide-Over Right Filter Drawer ══ -->
<aside class="dt-filter-drawer" id="dtWholesaleFilterDrawer">
    <div class="dt-drawer-head">
        <h3 class="dt-drawer-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
            <span>Advanced Wholesale Filters</span>
        </h3>
        <button type="button" class="dt-drawer-close" onclick="toggleAdvancedFilters(false)" title="Close Filters">✕</button>
    </div>

    <form id="wholesaleFilterForm" class="dt-drawer-body" onsubmit="applyAdvancedWholesaleFilters(event)">
        <!-- 1. Wholesale Tier -->
        <div>
            <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px; text-transform:uppercase;">Wholesale Partner Tier</label>
            <select id="drawerFilterTier" class="dt-wholesale-select" style="width:100%; height:36px; font-size:0.8rem; border-radius:8px; border:1.2px solid #EAE5D9;">
                <option value="all">All Wholesale Tiers</option>
                <option value="platinum wholesale">Platinum Wholesale (35% Margin)</option>
                <option value="gold distributor">Gold Distributor (28% Margin)</option>
                <option value="silver bulk partner">Silver Bulk Partner (20% Margin)</option>
                <option value="bronze starter">Bronze Starter (12% Margin)</option>
            </select>
        </div>

        <!-- 2. Account Status -->
        <div>
            <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px; text-transform:uppercase;">Account Standing</label>
            <select id="drawerFilterStatus" class="dt-wholesale-select" style="width:100%; height:36px; font-size:0.8rem; border-radius:8px; border:1.2px solid #EAE5D9;">
                <option value="all">All Account Standings</option>
                <option value="approved">Active &amp; Approved</option>
                <option value="pending">Pending Application Review</option>
                <option value="suspended">Suspended / Credit Breach</option>
            </select>
        </div>

        <!-- 3. Payment Terms -->
        <div>
            <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px; text-transform:uppercase;">Payment Terms &amp; Settlement Horizon</label>
            <select id="drawerFilterTerms" class="dt-wholesale-select" style="width:100%; height:36px; font-size:0.8rem; border-radius:8px; border:1.2px solid #EAE5D9;">
                <option value="all">Any Payment Terms</option>
                <option value="net 30">Net 30 Days Credit</option>
                <option value="net 45">Net 45 Days Credit</option>
                <option value="net 15">Net 15 Days Credit</option>
                <option value="advance 50%">Advance 50% / Balance Dispatch</option>
                <option value="prepaid">Prepaid / Proforma</option>
            </select>
        </div>

        <!-- 4. KYC Verification -->
        <div>
            <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px; text-transform:uppercase;">KYC &amp; GSTIN Verification Status</label>
            <select id="drawerFilterKyc" class="dt-wholesale-select" style="width:100%; height:36px; font-size:0.8rem; border-radius:8px; border:1.2px solid #EAE5D9;">
                <option value="all">All Verification States</option>
                <option value="verified">Verified GSTIN &amp; Aadhaar/PAN</option>
                <option value="pending">Pending Document Audit</option>
                <option value="rejected">Rejected / Incomplete</option>
            </select>
        </div>

        <!-- 5. Minimum Purchase GMV (₹) -->
        <div>
            <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px; text-transform:uppercase;">Minimum Sourced Purchase (₹)</label>
            <input type="number" id="drawerFilterMinPurchase" class="dt-wholesale-input" placeholder="e.g. 500000" style="width:100%; height:36px; font-size:0.8rem; border-radius:8px; border:1.2px solid #EAE5D9; padding:0 12px; box-sizing:border-box;">
        </div>

        <!-- 6. State / Region -->
        <div>
            <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px; text-transform:uppercase;">Business State / Territory</label>
            <select id="drawerFilterState" class="dt-wholesale-select" style="width:100%; height:36px; font-size:0.8rem; border-radius:8px; border:1.2px solid #EAE5D9;">
                <option value="all">All India (National)</option>
                <option value="gujarat">Gujarat (Surat / Ahmedabad / Rajkot)</option>
                <option value="uttar pradesh">Uttar Pradesh (Varanasi / Lucknow)</option>
                <option value="rajasthan">Rajasthan (Jaipur / Suratgarh)</option>
                <option value="tamil nadu">Tamil Nadu (Chennai / Kanchipuram)</option>
                <option value="west bengal">West Bengal (Kolkata / Shantipur)</option>
                <option value="maharashtra">Maharashtra (Mumbai / Ichalkaranji)</option>
            </select>
        </div>
    </form>

    <div class="dt-drawer-foot">
        <button type="button" class="dt-btn dt-btn-pale" onclick="resetAdvancedFilters()">Reset All</button>
        <button type="button" class="dt-btn dt-btn-gold" onclick="applyAdvancedWholesaleFilters()">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span>Apply Filters</span>
        </button>
    </div>
</aside>
