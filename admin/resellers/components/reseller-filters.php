<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * reseller-filters.php — DT Brand's & Jai Hanuman Tex
 * Advanced Multi-Dimension Filter Modal
 */
?>

<div id="dtResellerFiltersModal" class="dt-modal-backdrop">
    <div class="dt-modal-dialog">
        <div class="dt-modal-head">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.5"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                <strong style="font-size:0.9rem; font-weight:800; color:#181512;">Advanced Reseller Filters</strong>
            </div>
            <button type="button" onclick="closeModal('dtResellerFiltersModal')" style="background:none; border:none; color:#78716C; font-size:18px; cursor:pointer; font-weight:bold;">✕</button>
        </div>

        <form id="dtAdvancedFiltersForm" onsubmit="applyResellerAdvancedFilters(event)">
            <div class="dt-modal-body" style="display:flex; flex-direction:column; gap:14px;">
                <!-- 1. Standing Tier -->
                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Reseller Tier</label>
                    <select class="dt-reseller-select" style="width:100%; height:38px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.8rem;">
                        <option value="">All Tiers (Platinum, Gold, Silver, Bronze)</option>
                        <option value="Platinum">Platinum Elite (Highest Margin)</option>
                        <option value="Gold">Gold Partner</option>
                        <option value="Silver">Silver Growth</option>
                        <option value="Bronze">Bronze Starter</option>
                    </select>
                </div>

                <!-- 2. KYC Status -->
                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">KYC &amp; Verification Status</label>
                    <select class="dt-reseller-select" style="width:100%; height:38px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.8rem;">
                        <option value="">All Verification States</option>
                        <option value="Verified">Verified Documents Only</option>
                        <option value="Needs Review">Needs Staff Review</option>
                        <option value="Pending">Pending Document Upload</option>
                    </select>
                </div>

                <!-- 3. State / Region -->
                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">State / Region</label>
                    <select class="dt-reseller-select" style="width:100%; height:38px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.8rem;">
                        <option value="">All States (Pan-India)</option>
                        <option value="Gujarat">Gujarat (Surat / Ahmedabad / Rajkot)</option>
                        <option value="Rajasthan">Rajasthan (Jaipur / Jodhpur)</option>
                        <option value="Maharashtra">Maharashtra (Mumbai / Pune)</option>
                        <option value="Delhi">Delhi &amp; NCR</option>
                        <option value="Madhya Pradesh">Madhya Pradesh (Indore / Bhopal)</option>
                        <option value="West Bengal">West Bengal (Kolkata)</option>
                    </select>
                </div>

                <!-- 4. Credit Risk Condition -->
                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Credit Condition</label>
                    <select class="dt-reseller-select" style="width:100%; height:38px; border:1.2px solid #EAE5D9; border-radius:8px; padding:0 12px; font-size:0.8rem;">
                        <option value="">All Credit Profiles</option>
                        <option value="exceeded">Exceeded Credit Limit</option>
                        <option value="near_limit">Near Limit (&gt; 80%)</option>
                        <option value="zero">Zero Outstanding (Clean)</option>
                    </select>
                </div>
            </div>

            <div class="dt-modal-foot">
                <button type="button" class="dt-btn dt-btn-pale" onclick="resetResellerFilters()">Reset</button>
                <button type="submit" class="dt-btn dt-btn-gold">Apply Filters</button>
            </div>
        </form>
    </div>
</div>
