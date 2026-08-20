<?php
/**
 * order-search.php — Debounced Live Search Toolbar with Action Buttons & View Options
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-order-toolbar">
    <!-- Real-Time Search Box -->
    <div class="dt-order-search-wrap">
        <svg class="dt-order-search-icon" viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2">
            <circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line>
        </svg>
        <input type="text" id="orderSearchInput" class="dt-order-search-input" placeholder="Search Order ID, Customer, Phone, SKU, Tracking..." oninput="if(this.value.length>0){document.getElementById('orderSearchClear').classList.add('visible');}else{document.getElementById('orderSearchClear').classList.remove('visible');} window.DT_ORDER_LIST.filterTable();">
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
        <a href="/Frontend/Admin/orders/export.php" class="dt-btn dt-btn-pale" style="height:32px;">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            <span>Export</span>
        </a>

        <!-- Master Create B2B Order Button -->
        <button type="button" class="dt-btn dt-btn-gold" style="height:32px;" onclick="window.location.href='/Frontend/Admin/orders/index.php?action=new_order'">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.4"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            <span>+ Create Order</span>
        </button>
    </div>
</div>
