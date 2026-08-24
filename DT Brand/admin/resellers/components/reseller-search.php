<?php
/**
 * reseller-search.php — Live Debounced Search, Filter Toolbar, Columns Dropdown & Actions
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
?>

<!-- ══ SEARCH & FILTERS TOOLBAR CARD ══ -->
<div class="dt-cust-toolbar-card">
    <div class="dt-cust-search-wrap">
        <input 
            type="text" 
            id="dtResellerSearchInput" 
            class="dt-cust-search-input" 
            placeholder="Search by Reseller Name, Phone, Email, City or ID..." 
            oninput="handleResellerSearch(this)" 
            autocomplete="off"
            style="padding-left:12px;"
        >
        <button type="button" id="dtResellerSearchClearBtn" class="dt-cust-search-clear" onclick="clearResellerSearch()" title="Clear Search">✕</button>
    </div>

    <div class="dt-cust-toolbar-right">
        <!-- Sort Dropdown -->
        <select class="dt-cust-select" onchange="handleResellerSort(this)" title="Sort Reseller Records">
            <option value="newest">Sort: Newest First</option>
            <option value="name-asc">Sort: Name (A–Z)</option>
            <option value="purchase-high">Sort: Highest Lifetime GMV</option>
            <option value="orders-high">Sort: Most Orders Placed</option>
        </select>

        <!-- Advanced Filters Button -->
        <button type="button" class="dt-btn dt-btn-pale" onclick="openResellerFiltersDrawer()">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3">
                <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
            </svg>
            <span>Advanced Filters</span>
        </button>

        <!-- Export Link -->
        <a href="/DT%20Brand/admin/resellers/export.php" class="dt-btn dt-btn-pale">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            <span>Export Studio</span>
        </a>

        <!-- ══ TOGGLE VISIBLE COLUMNS DROPDOWN ══ -->
        <div class="dt-col-dropdown-wrap" style="position:relative;">
            <button type="button" class="dt-btn dt-btn-pale" id="btnToggleResellerCols" onclick="toggleResellerColumnMenu(event)" title="Show or Hide Table Columns">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="9" y1="3" x2="9" y2="21"></line>
                    <line x1="15" y1="3" x2="15" y2="21"></line>
                </svg>
                <span>Columns</span>
                <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            
            <div id="dtResellerColumnMenu" class="dt-col-menu" style="display:none; position:absolute; right:0; top:calc(100% + 6px); width:230px; background:#FFFFFF; border:1.5px solid #D4AF37; border-radius:10px; box-shadow:0 10px 30px rgba(0,0,0,0.18); padding:12px 14px; z-index:99999;">
                <div style="font-size:11px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:10px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px dashed #E2DFD7; padding-bottom:6px;">
                    <span>Toggle Visible Columns</span>
                    <button type="button" onclick="resetAllResellerColumns()" style="background:none; border:none; font-size:10.5px; color:#1D4ED8; font-weight:800; cursor:pointer; padding:0;">Reset All</button>
                </div>
                <div style="display:flex; flex-direction:column; gap:6px; font-size:11.5px; color:#111827; font-weight:600;">
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;"><input type="checkbox" data-col="col-profile" checked onchange="toggleResellerColumn('col-profile', this.checked)" style="accent-color:#8A681F; cursor:pointer;"> <span>Reseller Profile</span></label>
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;"><input type="checkbox" data-col="col-contact" checked onchange="toggleResellerColumn('col-contact', this.checked)" style="accent-color:#8A681F; cursor:pointer;"> <span>Contact Details</span></label>
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;"><input type="checkbox" data-col="col-tier" checked onchange="toggleResellerColumn('col-tier', this.checked)" style="accent-color:#8A681F; cursor:pointer;"> <span>Tier &amp; Margin</span></label>
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;"><input type="checkbox" data-col="col-orders" checked onchange="toggleResellerColumn('col-orders', this.checked)" style="accent-color:#8A681F; cursor:pointer;"> <span>Orders Count</span></label>
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;"><input type="checkbox" data-col="col-gmv" checked onchange="toggleResellerColumn('col-gmv', this.checked)" style="accent-color:#8A681F; cursor:pointer;"> <span>Lifetime GMV &amp; Credit</span></label>
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;"><input type="checkbox" data-col="col-lastorder" checked onchange="toggleResellerColumn('col-lastorder', this.checked)" style="accent-color:#8A681F; cursor:pointer;"> <span>Last Order Date</span></label>
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;"><input type="checkbox" data-col="col-joined" checked onchange="toggleResellerColumn('col-joined', this.checked)" style="accent-color:#8A681F; cursor:pointer;"> <span>Joined Date</span></label>
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;"><input type="checkbox" data-col="col-status" checked onchange="toggleResellerColumn('col-status', this.checked)" style="accent-color:#8A681F; cursor:pointer;"> <span>Account Status</span></label>
                    <label style="display:flex; align-items:center; gap:8px; cursor:pointer;"><input type="checkbox" data-col="col-actions" checked onchange="toggleResellerColumn('col-actions', this.checked)" style="accent-color:#8A681F; cursor:pointer;"> <span>Quick Actions</span></label>
                </div>
            </div>
        </div>

        <!-- Add Reseller Button -->
        <a href="/DT%20Brand/admin/resellers/edit.php?action=new" class="dt-btn dt-btn-gold">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.6">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span>+ Add Reseller</span>
        </a>
    </div>
</div>
