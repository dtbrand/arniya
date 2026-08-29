<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * order-filters.php — Advanced Filter Drawer Component
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ══ Advanced Filters Drawer ══ -->
<aside class="dt-filter-drawer" id="orderFilterDrawer">
    <div class="dt-drawer-head">
        <h3 class="dt-drawer-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
            <span>Advanced Order Filters</span>
        </h3>
        <button type="button" class="dt-drawer-close" onclick="window.DT_ORDER_FILTERS.closeDrawer()" title="Close Drawer">✕</button>
    </div>

    <form id="orderFilterForm" class="dt-drawer-body">
        <!-- Quick Date Range Presets -->
        <div>
            <label style="font-size:11.5px; font-weight:700; color:#1E293B; margin-bottom:6px; display:block;">Quick Date Range</label>
            <div style="display:flex; gap:4px; flex-wrap:wrap;">
                <button type="button" class="dt-btn dt-btn-pale" style="height:26px; padding:0 8px; font-size:10.5px;" onclick="window.DT_ORDER_FILTERS.setDatePreset('today')">Today</button>
                <button type="button" class="dt-btn dt-btn-pale" style="height:26px; padding:0 8px; font-size:10.5px;" onclick="window.DT_ORDER_FILTERS.setDatePreset('yesterday')">Yesterday</button>
                <button type="button" class="dt-btn dt-btn-pale" style="height:26px; padding:0 8px; font-size:10.5px;" onclick="window.DT_ORDER_FILTERS.setDatePreset('last7')">Last 7 Days</button>
                <button type="button" class="dt-btn dt-btn-pale" style="height:26px; padding:0 8px; font-size:10.5px;" onclick="window.DT_ORDER_FILTERS.setDatePreset('last30')">Last 30 Days</button>
            </div>
        </div>

        <!-- Custom Date Range -->
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
            <div>
                <label style="font-size:11px; font-weight:700; color:#475569;">Start Date</label>
                <input type="date" id="filterStartDate" class="dt-order-search-input" style="height:32px;">
            </div>
            <div>
                <label style="font-size:11px; font-weight:700; color:#475569;">End Date</label>
                <input type="date" id="filterEndDate" class="dt-order-search-input" style="height:32px;">
            </div>
        </div>

        <!-- Customer Type / Channel -->
        <div>
            <label style="font-size:11px; font-weight:700; color:#475569;">Customer Segment</label>
            <select class="dt-order-search-input" style="height:34px;">
                <option value="all">All Channels &amp; Segments</option>
                <option value="b2b">Wholesale B2B Buyer</option>
                <option value="b2c">Retail Customer (B2C)</option>
                <option value="reseller">WhatsApp Reseller</option>
                <option value="retailer">Retailer / Boutique</option>
            </select>
        </div>

        <!-- Payment Method -->
        <div>
            <label style="font-size:11px; font-weight:700; color:#475569;">Payment Method</label>
            <select class="dt-order-search-input" style="height:34px;">
                <option value="all">All Payment Methods</option>
                <option value="upi">UPI / QR Code</option>
                <option value="bank">Bank Transfer / NEFT / RTGS</option>
                <option value="card">Credit / Debit Card</option>
                <option value="cod">Cash On Delivery (COD)</option>
            </select>
        </div>

        <!-- Shipping Courier -->
        <div>
            <label style="font-size:11px; font-weight:700; color:#475569;">Courier &amp; Logistics Partner</label>
            <select class="dt-order-search-input" style="height:34px;">
                <option value="all">All Couriers &amp; Transporters</option>
                <option value="vrl">VRL Logistics Depot Cargo</option>
                <option value="bluedart">BlueDart Express Air</option>
                <option value="delhivery">Delhivery Surface / Air</option>
                <option value="dtdc">DTDC Express</option>
            </select>
        </div>

        <!-- Column Visibility Toggles -->
        <div>
            <label style="font-size:11.5px; font-weight:700; color:#1E293B; margin-bottom:6px; display:block;">Column Visibility</label>
            <div style="display:flex; flex-direction:column; gap:6px; background:#FAF8F4; padding:10px; border-radius:6px; border:1px solid #E2DFD7;">
                <label style="display:flex; align-items:center; gap:6px; font-size:11px; cursor:pointer;">
                    <input type="checkbox" checked onchange="window.DT_ORDER_LIST.toggleColumn('col-items', this.checked)"> Items Preview
                </label>
                <label style="display:flex; align-items:center; gap:6px; font-size:11px; cursor:pointer;">
                    <input type="checkbox" checked onchange="window.DT_ORDER_LIST.toggleColumn('col-payment', this.checked)"> Payment Method
                </label>
                <label style="display:flex; align-items:center; gap:6px; font-size:11px; cursor:pointer;">
                    <input type="checkbox" checked onchange="window.DT_ORDER_LIST.toggleColumn('col-shipping', this.checked)"> Shipping Partner
                </label>
                <label style="display:flex; align-items:center; gap:6px; font-size:11px; cursor:pointer;">
                    <input type="checkbox" checked onchange="window.DT_ORDER_LIST.toggleColumn('col-source', this.checked)"> Order Source
                </label>
            </div>
        </div>
    </form>

    <div class="dt-drawer-foot">
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_FILTERS.resetFilters()">Reset</button>
        <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_ORDER_FILTERS.applyFilters()">Apply Filters</button>
    </div>
</aside>
