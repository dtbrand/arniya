<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * customer-table.php — High-Density Responsive Customer Table
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */
?>

<!-- ══ MASTER CUSTOMER TABLE CONTAINER ══ -->
<div class="dt-cust-table-wrap">
    <table class="dt-cust-table">
        <thead>
            <tr>
                <th style="width:36px; text-align:center;">
                    <input type="checkbox" id="dtCustSelectAll" onchange="toggleCustomerSelectAll(this.checked)" title="Select All Customers">
                </th>
                <th class="sortable" onclick="sortCustomersBy('name')">
                    Customer Profile ↕
                </th>
                <th>Contact Details</th>
                <th>Account Type</th>
                <th style="text-align:center;" class="sortable" onclick="sortCustomersBy('orders')">
                    Orders ↕
                </th>
                <th class="sortable" onclick="sortCustomersBy('spent')">
                    Lifetime Spend ↕
                </th>
                <th>Last Order</th>
                <th>Joined Date</th>
                <th>Status</th>
                <th style="text-align:right;">Quick Actions</th>
            </tr>
        </thead>
        <tbody id="dtCustomersTableBody">
            <!-- Dynamically populated by customer-list.js -->
            <tr>
                <td colspan="10" style="text-align:center; padding:40px; color:#8C8478;">
                    <div style="display:inline-flex; align-items:center; gap:8px; font-weight:700;">
                        <span>Loading DT Brand's Shopper Directory...</span>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- ══ PAGINATION CONTROLS ══ -->
    <div class="dt-cust-pagination">
        <div id="dtCustPaginationInfo">
            Showing <strong>1–10</strong> of <strong>4,820</strong> Customers
        </div>
        <div class="dt-cust-pages-wrap">
            <button type="button" class="dt-cust-page-btn" onclick="renderCustomersTable(1)" title="First Page">«</button>
            <button type="button" class="dt-cust-page-btn active" onclick="renderCustomersTable(1)">1</button>
            <button type="button" class="dt-cust-page-btn" onclick="renderCustomersTable(2)">2</button>
            <button type="button" class="dt-cust-page-btn" onclick="renderCustomersTable(1)" title="Next Page">»</button>
        </div>
    </div>
</div>
