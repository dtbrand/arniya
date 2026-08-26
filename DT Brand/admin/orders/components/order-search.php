<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * order-search.php — Debounced Live Search Toolbar with Action Buttons & View Options
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-order-toolbar">
    <!-- Real-Time Search Box -->
    <div class="dt-order-search-wrap">
        <input type="text" id="orderSearchInput" class="dt-order-search-input" placeholder="Search Order ID, Customer, Phone, SKU, Tracking..." style="padding-left:12px;" oninput="if(this.value.length>0){document.getElementById('orderSearchClear').classList.add('visible');}else{document.getElementById('orderSearchClear').classList.remove('visible');} window.DT_ORDER_LIST.filterTable();">
        <button type="button" id="orderSearchClear" class="dt-order-search-clear" onclick="window.DT_ORDER_LIST.clearSearch()" title="Clear search">✕</button>
    </div>

    <!-- Toolbar Filters & Actions -->
    <div class="dt-order-toolbar-right">
        <!-- Quick Status Filter -->
        <select id="statusFilterSelect" class="dt-btn dt-btn-pale" style="height:32px; padding:0 8px; font-size:11px;" onchange="window.DT_ORDER_LIST.filterTable()">
            <option value="all">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="processing">Processing</option>
            <option value="packed">Packed</option>
            <option value="shipped">Shipped</option>
            <option value="out_for_delivery">Out for Delivery</option>
            <option value="delivered">Delivered</option>
            <option value="cancelled">Cancelled</option>
            <option value="returned">Returned</option>
            <option value="refunded">Refunded</option>
        </select>

        <!-- Quick Payment Filter -->
        <select id="paymentFilterSelect" class="dt-btn dt-btn-pale" style="height:32px; padding:0 8px; font-size:11px;" onchange="window.DT_ORDER_LIST.filterTable()">
            <option value="all">All Payment Status</option>
            <option value="paid">Paid</option>
            <option value="pending">Payment Pending</option>
            <option value="failed">Failed</option>
        </select>

        <!-- Advanced Filter Trigger -->
        <button type="button" class="dt-btn dt-btn-pale" style="height:32px;" onclick="window.DT_ORDER_FILTERS.openDrawer()">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
            <span>Advanced Filters</span>
        </button>

        <!-- Export Orders -->
        <a href="/admin/orders/export.php" class="dt-btn dt-btn-pale" style="height:32px;">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            <span>Export</span>
        </a>

        <!-- Hide / Show Columns Options Dropdown -->
        <div class="dt-col-dropdown-wrap" style="position:relative;">
            <button type="button" class="dt-btn dt-btn-pale" style="height:32px;" onclick="window.DT_ORDER_LIST.toggleColumnMenu(event)" title="Show or Hide Table Columns">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2">
                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="9" y1="3" x2="9" y2="21"></line>
                    <line x1="15" y1="3" x2="15" y2="21"></line>
                </svg>
                <span>Columns</span>
                <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
            
            <div id="columnVisibilityMenu" class="dt-col-menu" style="display:none; position:absolute; right:0; top:calc(100% + 6px); width:220px; background:#FFFFFF; border:1px solid #D4AF37; border-radius:8px; box-shadow:0 8px 24px rgba(0,0,0,0.14); padding:10px 12px; z-index:99999;">
                <div style="font-size:10.5px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:8px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px dashed #E2DFD7; padding-bottom:6px;">
                    <span>Toggle Visible Columns</span>
                    <button type="button" onclick="window.DT_ORDER_LIST.resetAllColumns()" style="background:none; border:none; font-size:10px; color:#1D4ED8; font-weight:700; cursor:pointer; padding:0;">Reset All</button>
                </div>
                <div style="display:flex; flex-direction:column; gap:5px; font-size:11px; color:#1E293B;">
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-id" checked onchange="window.DT_ORDER_LIST.toggleColumn('col-id', this.checked)"> <span>Order ID</span></label>
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-date" checked onchange="window.DT_ORDER_LIST.toggleColumn('col-date', this.checked)"> <span>Date & Time</span></label>
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-customer" checked onchange="window.DT_ORDER_LIST.toggleColumn('col-customer', this.checked)"> <span>Customer Name & Phone</span></label>
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-items" checked onchange="window.DT_ORDER_LIST.toggleColumn('col-items', this.checked)"> <span>Items Summary</span></label>
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-amount" checked onchange="window.DT_ORDER_LIST.toggleColumn('col-amount', this.checked)"> <span>Amount (₹ Valuation)</span></label>
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-payment" checked onchange="window.DT_ORDER_LIST.toggleColumn('col-payment', this.checked)"> <span>Payment Status</span></label>
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-shipping" checked onchange="window.DT_ORDER_LIST.toggleColumn('col-shipping', this.checked)"> <span>Shipping & Carrier</span></label>
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-status" checked onchange="window.DT_ORDER_LIST.toggleColumn('col-status', this.checked)"> <span>Fulfillment Status</span></label>
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-source" checked onchange="window.DT_ORDER_LIST.toggleColumn('col-source', this.checked)"> <span>Channel Source</span></label>
                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-actions" checked onchange="window.DT_ORDER_LIST.toggleColumn('col-actions', this.checked)"> <span>Row Actions</span></label>
                </div>
            </div>
        </div>

        <!-- Master + Create Order Button -->
        <a href="/admin/orders/create.php" class="dt-btn dt-btn-gold" style="height:32px; font-weight:800; padding:0 12px;">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            <span>Create Order</span>
        </a>
    </div>
</div>
