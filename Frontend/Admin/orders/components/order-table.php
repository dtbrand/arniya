<?php
/**
 * order-table.php — Master Orders Table Component
 * DT Brand's & Jai Hanuman Tex
 */
$filter_status = isset($filter_status) ? $filter_status : 'all';

// Realistic Order Data Model matching Wholesale + Retail Commerce
$orders_list = [
    [
        'id' => 'DTB-001624',
        'customer' => 'Rajesh Kumar (Vardhman Tex)',
        'customer_type' => 'Wholesale B2B',
        'phone' => '+91 98220 19283',
        'date' => '21 Aug 2026, 11:20 AM',
        'items_count' => '25 pcs',
        'items_summary' => 'Kanjivaram Pure Zari (x25)',
        'amount' => 112250,
        'payment' => 'Bank Wire / RTGS',
        'payment_status' => 'paid',
        'shipping' => 'VRL Logistics Depot',
        'tracking' => 'VRL-99821',
        'status' => 'shipped',
        'source' => 'B2B Portal',
        'updated' => '10 mins ago'
    ],
    [
        'id' => 'DTB-001623',
        'customer' => 'Pooja Sharma',
        'customer_type' => 'Retail Customer (B2C)',
        'phone' => '+91 98110 29381',
        'date' => '21 Aug 2026, 10:45 AM',
        'items_count' => '1 pc',
        'items_summary' => 'Banarasi Brocade Silk (x1)',
        'amount' => 4990,
        'payment' => 'UPI / PhonePe',
        'payment_status' => 'paid',
        'shipping' => 'BlueDart Express Air',
        'tracking' => 'BD-88291',
        'status' => 'delivered',
        'source' => 'Online Shop',
        'updated' => '30 mins ago'
    ],
    [
        'id' => 'DTB-001622',
        'customer' => 'Siddhi Boutique (Anjali Patel)',
        'customer_type' => 'Retailer / Boutique',
        'phone' => '+91 98765 43210',
        'date' => '21 Aug 2026, 09:30 AM',
        'items_count' => '10 pcs',
        'items_summary' => 'Paithani Peacock (x10)',
        'amount' => 38900,
        'payment' => 'Net Banking / HDFC',
        'payment_status' => 'paid',
        'shipping' => 'DTDC Priority',
        'tracking' => 'DTDC-4491',
        'status' => 'packed',
        'source' => 'B2B Portal',
        'updated' => '1 hour ago'
    ],
    [
        'id' => 'DTB-001621',
        'customer' => 'Meera Textiles',
        'customer_type' => 'WhatsApp Reseller',
        'phone' => '+91 98450 11223',
        'date' => '20 Aug 2026, 04:15 PM',
        'items_count' => '6 pcs',
        'items_summary' => 'Chanderi Zari Tissue (x6)',
        'amount' => 14940,
        'payment' => 'Razorpay / Card',
        'payment_status' => 'paid',
        'shipping' => 'Delhivery Surface',
        'tracking' => 'DLV-9982',
        'status' => 'processing',
        'source' => 'WhatsApp Order',
        'updated' => 'Yesterday'
    ],
    [
        'id' => 'DTB-001620',
        'customer' => 'Kalyan Sarees Wholesale',
        'customer_type' => 'Wholesale B2B',
        'phone' => '+91 98330 99881',
        'date' => '20 Aug 2026, 02:00 PM',
        'items_count' => '50 pcs',
        'items_summary' => 'Pure Tussar Silk (x50)',
        'amount' => 149500,
        'payment' => 'Bank Transfer / NEFT',
        'payment_status' => 'pending',
        'shipping' => 'Surat Cargo Transport',
        'tracking' => 'SC-1029',
        'status' => 'pending',
        'source' => 'B2B Portal',
        'updated' => 'Yesterday'
    ],
    [
        'id' => 'DTB-001619',
        'customer' => 'Ritu Varma',
        'customer_type' => 'Retail Customer (B2C)',
        'phone' => '+91 98190 77665',
        'date' => '19 Aug 2026, 11:10 AM',
        'items_count' => '1 pc',
        'items_summary' => 'Kalamkari Silk (x1)',
        'amount' => 3290,
        'payment' => 'Cash On Delivery',
        'payment_status' => 'failed',
        'shipping' => 'Delhivery COD',
        'tracking' => 'DLV-9918',
        'status' => 'cancelled',
        'source' => 'Online Shop',
        'updated' => '2 days ago'
    ]
];
?>

<!-- ══ Bulk Action Toolbar (Active on Multi-Select) ══ -->
<div class="dt-bulk-bar" id="ordersBulkBar">
    <div class="dt-bulk-info">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
        <span id="bulkSelectedCount">0 Orders Selected</span>
    </div>
    <div class="dt-bulk-actions-group">
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_BULK_ACTIONS.executeBulkStatus('confirmed')">Mark Confirmed</button>
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_BULK_ACTIONS.executeBulkStatus('processing')">Mark Processing</button>
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_BULK_ACTIONS.executeBulkStatus('packed')">Mark Packed</button>
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_BULK_ACTIONS.executeBulkStatus('shipped')">Mark Shipped</button>
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_BULK_ACTIONS.executeBulkPrint()">Print Selected Invoices</button>
        <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_BULK_ACTIONS.executeBulkExport()">Export Selected</button>
    </div>
</div>

<!-- ══ Responsive Orders Table Card ══ -->
<div class="dt-order-table-card">
    <div class="dt-table-responsive">
        <table class="dt-order-table">
            <thead>
                <tr>
                    <th style="width:34px; text-align:center;">
                        <input type="checkbox" class="dt-checkbox" onchange="window.DT_BULK_ACTIONS.toggleSelectAll(this)" title="Select all orders">
                    </th>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th class="col-items">Items</th>
                    <th>Amount</th>
                    <th class="col-payment">Payment</th>
                    <th class="col-shipping">Shipping</th>
                    <th>Status</th>
                    <th class="col-source">Source</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody id="ordersTableBody">
                <?php foreach ($orders_list as $o): ?>
                <?php
                    if ($filter_status !== 'all' && $o['status'] !== $filter_status) continue;
                ?>
                <tr class="dt-order-row" data-id="<?php echo $o['id']; ?>" data-customer="<?php echo htmlspecialchars($o['customer']); ?>" data-phone="<?php echo htmlspecialchars($o['phone']); ?>" data-status="<?php echo $o['status']; ?>" data-payment="<?php echo $o['payment_status']; ?>">
                    <td style="text-align:center;">
                        <input type="checkbox" class="dt-checkbox dt-order-check" onchange="window.DT_BULK_ACTIONS.onRowCheckChange(this)">
                    </td>
                    <td>
                        <a href="/Frontend/Admin/orders/view.php?id=<?php echo $o['id']; ?>" class="dt-order-id-link">
                            <span><?php echo $o['id']; ?></span>
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg>
                        </a>
                    </td>
                    <td style="white-space:nowrap; font-size:11px; color:#64748B;">
                        <?php echo $o['date']; ?>
                    </td>
                    <td>
                        <div class="dt-customer-cell">
                            <span class="dt-customer-name"><?php echo htmlspecialchars($o['customer']); ?></span>
                            <span class="dt-customer-phone"><?php echo htmlspecialchars($o['phone']); ?></span>
                        </div>
                    </td>
                    <td class="col-items">
                        <span class="dt-items-pill" title="<?php echo htmlspecialchars($o['items_summary']); ?>">
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="#8A681F" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline></svg>
                            <span><?php echo $o['items_count']; ?></span>
                        </span>
                    </td>
                    <td>
                        <div class="dt-amount-cell">
                            <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="11" height="11"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                            <span><?php echo number_format($o['amount']); ?></span>
                        </div>
                    </td>
                    <td class="col-payment">
                        <div style="display:flex; flex-direction:column; gap:2px;">
                            <span class="dt-pay-badge <?php echo $o['payment_status']; ?>"><?php echo strtoupper($o['payment_status']); ?></span>
                            <span style="font-size:10px; color:#64748B;"><?php echo $o['payment']; ?></span>
                        </div>
                    </td>
                    <td class="col-shipping">
                        <div style="display:flex; flex-direction:column; gap:2px;">
                            <span style="font-weight:700; font-size:11px; color:#334155;"><?php echo $o['shipping']; ?></span>
                            <span style="font-size:10px; color:#64748B; font-family:monospace;"><?php echo $o['tracking']; ?></span>
                        </div>
                    </td>
                    <td>
                        <span id="statusBadge_<?php echo $o['id']; ?>" class="dt-status-badge <?php echo $o['status']; ?>">
                            <span class="dt-status-dot"></span>
                            <span><?php echo str_replace('_', ' ', $o['status']); ?></span>
                        </span>
                    </td>
                    <td class="col-source">
                        <span class="dt-kpi-badge up" style="font-size:10px; background:#F8FAFC; border:1px solid #E2E8F0; color:#475569;"><?php echo $o['source']; ?></span>
                    </td>
                    <td style="text-align:right;">
                        <div class="dt-row-actions" style="justify-content:flex-end;">
                            <a href="/Frontend/Admin/orders/view.php?id=<?php echo $o['id']; ?>" class="dt-action-btn" title="View Order Details">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>
                            <button type="button" class="dt-action-btn" onclick="window.DT_ORDER_STATUS.openStatusModal('<?php echo $o['id']; ?>', '<?php echo $o['status']; ?>')" title="Update Status">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </button>
                            <a href="/Frontend/Admin/orders/invoice.php?id=<?php echo $o['id']; ?>" class="dt-action-btn" title="Print Invoice">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                            </a>
                            <?php if ($o['status'] !== 'cancelled' && $o['status'] !== 'delivered'): ?>
                            <button type="button" class="dt-action-btn danger" onclick="window.DT_ORDER_STATUS.openCancelModal('<?php echo $o['id']; ?>')" title="Cancel Order">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                            </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Empty State -->
    <div id="ordersEmptyState" style="display:none; padding:36px; text-align:center;">
        <svg viewBox="0 0 24 24" width="36" height="36" fill="none" stroke="#94A3B8" stroke-width="1.8" style="margin-bottom:8px;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
        <h4 style="margin:0 0 4px 0; color:#1E293B; font-size:14px; font-weight:800;">No Matching Orders Found</h4>
        <p style="margin:0 0 12px 0; color:#64748B; font-size:12px;">Try adjusting your search criteria or resetting filters.</p>
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_LIST.clearSearch()">Clear Filters</button>
    </div>

    <!-- Pagination Bar -->
    <div class="dt-pagination-bar">
        <div class="dt-pagination-info" id="ordersCountDisplay">Showing 1–6 of 1,624 Orders</div>
        <div class="dt-pagination-controls">
            <button type="button" class="dt-page-btn" disabled>«</button>
            <button type="button" class="dt-page-btn" disabled>‹ Prev</button>
            <button type="button" class="dt-page-btn active">1</button>
            <button type="button" class="dt-page-btn" onclick="if(window.DT_ORDERS) window.DT_ORDERS.showToast('📄 Loaded Page 2');">2</button>
            <button type="button" class="dt-page-btn" onclick="if(window.DT_ORDERS) window.DT_ORDERS.showToast('📄 Loaded Page 3');">3</button>
            <button type="button" class="dt-page-btn" onclick="if(window.DT_ORDERS) window.DT_ORDERS.showToast('📄 Loaded Next Page');">Next ›</button>
            <button type="button" class="dt-page-btn" onclick="if(window.DT_ORDERS) window.DT_ORDERS.showToast('📄 Loaded Last Page');">»</button>
        </div>
    </div>
</div>
