<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-filters.php — Advanced Filter Modal / Drawer Component
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
?>

<!-- ══ ADVANCED FILTERS MODAL ══ -->
<div id="dtCustFiltersModal" class="dt-modal-backdrop" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(3px);">
    <div class="dt-card" style="width:95%; max-width:520px; max-height:90vh; overflow-y:auto; margin:auto; border-radius:12px; border:1.5px solid var(--dt-gold-primary); box-shadow:0 12px 36px rgba(0,0,0,0.3);">
        <div class="dt-card-head" style="border-bottom:1.5px solid #F1ECE1; padding-bottom:10px; margin-bottom:14px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:28px; height:28px; border-radius:7px; background:var(--dt-gold-pale); border:1px solid var(--dt-gold-radiant); display:flex; align-items:center; justify-content:center; color:var(--dt-gold-primary);">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.3">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                </div>
                <h3 class="dt-card-title" style="font-size:1.05rem;">Filter Customer CRM</h3>
            </div>
            <button type="button" onclick="closeCustomerFiltersModal()" style="background:none; border:none; font-size:1.2rem; cursor:pointer; color:#78716C;">✕</button>
        </div>

        <?php /*
         * Every control in this modal was unnamed and unread. Apply closed the
         * modal and toasted "Advanced Filters Applied (12 Matches)" -- a constant,
         * with no filtering done -- so the table still listed every customer while
         * the admin believed they were looking at twelve matches. The controls now
         * carry ids and customer-filters.js narrows the real list and reports the
         * real count.
         *
         * Status offered "Inactive / Dormant", which the ENUM (active | pending |
         * suspended) cannot hold, and had no option for pending -- the state every
         * unapproved trade application sits in.
         */ ?>
        <form onsubmit="applyCustomerAdvancedFilters(event)" style="display:flex; flex-direction:column; gap:14px;">
            <!-- Status & Tier -->
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                <div>
                    <label style="font-size:0.74rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Account Status</label>
                    <select id="dtFilterStatus" class="dt-cust-select" style="width:100%;">
                        <option value="all">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="pending">Pending Approval</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:0.74rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Account Type</label>
                    <select id="dtFilterType" class="dt-cust-select" style="width:100%;">
                        <option value="all">All Types</option>
                        <option value="retail">Retail</option>
                        <option value="wholesale">Wholesale</option>
                        <option value="reseller">Reseller</option>
                    </select>
                </div>
            </div>

            <div>
                <label style="font-size:0.74rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Customer Tier</label>
                <input type="text" id="dtFilterTier" class="dt-cust-search-input" style="padding-left:12px;" placeholder="e.g. VIP, Diamond Elite &mdash; blank for all">
            </div>

            <!-- Orders Count & Spend Range -->
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                <div>
                    <label style="font-size:0.74rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Minimum Orders</label>
                    <input type="number" id="dtFilterMinOrders" class="dt-cust-search-input" style="padding-left:12px;" placeholder="e.g. 3" min="0">
                </div>
                <div>
                    <label style="font-size:0.74rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Min Spent (&#8377;)</label>
                    <input type="number" id="dtFilterMinSpent" class="dt-cust-search-input" style="padding-left:12px;" placeholder="e.g. 10000" min="0">
                </div>
            </div>

            <!-- Location State -->
            <div>
                <label style="font-size:0.74rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Customer Location (City or State)</label>
                <?php /* Was a fixed list of eight state codes. customers.state is a
                         free-text VARCHAR that may hold "Gujarat" or "GJ" or nothing,
                         so a match on either field is the only reliable filter. */ ?>
                <input type="text" id="dtFilterPlace" class="dt-cust-search-input" style="padding-left:12px;" placeholder="e.g. Surat, GJ, Maharashtra &mdash; blank for all">
            </div>

            <!-- Date Presets -->
            <div>
                <label style="font-size:0.74rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Registered In</label>
                <?php /* These four buttons had no onclick at all, and "Last 30 Days"
                         was pre-marked active -- implying the directory was already
                         date-filtered when it never was. */ ?>
                <div style="display:flex; flex-wrap:wrap; gap:6px;" id="dtFilterDatePills">
                    <button type="button" class="dt-cust-pill-btn" style="font-size:0.7rem; padding:4px 8px;" data-days="7" onclick="setCustomerFilterDays(this)">Last 7 Days</button>
                    <button type="button" class="dt-cust-pill-btn" style="font-size:0.7rem; padding:4px 8px;" data-days="30" onclick="setCustomerFilterDays(this)">Last 30 Days</button>
                    <button type="button" class="dt-cust-pill-btn" style="font-size:0.7rem; padding:4px 8px;" data-days="365" onclick="setCustomerFilterDays(this)">Last 12 Months</button>
                    <button type="button" class="dt-cust-pill-btn active" style="font-size:0.7rem; padding:4px 8px;" data-days="0" onclick="setCustomerFilterDays(this)">All Time</button>
                </div>
            </div>

            <!-- Modal Action Buttons -->
            <div style="display:flex; align-items:center; justify-content:flex-end; gap:8px; border-top:1.5px solid #F1ECE1; padding-top:12px; margin-top:6px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="resetCustomerAdvancedFilters()">Reset</button>
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeCustomerFiltersModal()">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">Apply Filters</button>
            </div>
        </form>
    </div>
</div>
