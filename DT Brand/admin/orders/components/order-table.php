<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * order-table.php — Master Orders Table Component
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../../src/OrderManager.php';
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\OrderManager;
use DTBrand\Database;

$filter_status = isset($filter_status) ? $filter_status : 'all';
$orders_list = OrderManager::getAll();
?>

<!-- ══ Bulk Action Toolbar (Active on Multi-Select) ══ -->
<div class="dt-bulk-bar" id="ordersBulkBar">
    <div class="dt-bulk-info">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#D4AF37" stroke-width="2.3"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
        <span id="bulkSelectedCount" style="font-weight:800; color:#FAF5E8;">0 Orders Selected</span>
    </div>
    <div class="dt-bulk-actions-group" style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
        <!-- Batch Print All Courier Shipping Labels -->
        <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_BULK_ACTIONS.executeBulkPrintLabels()" style="height:32px; padding:0 12px; font-size:11px; font-weight:800;" title="Print Courier Shipping Barcode Labels for All Selected Orders">
            <svg viewBox="0 0 24 24" width="12.5" height="12.5" fill="none" stroke="#181512" stroke-width="2.3"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
            <span>Bulk Print Labels</span>
        </button>
        <!-- Batch Print Tax Invoices -->
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_BULK_ACTIONS.executeBulkPrintInvoices()" style="height:32px; padding:0 11px; font-size:11px; font-weight:700;" title="Batch Print Tax Invoices">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            <span>Batch Invoices</span>
        </button>
        <!-- Batch Print Packing Slips -->
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_BULK_ACTIONS.executeBulkPrintPackingSlips()" style="height:32px; padding:0 11px; font-size:11px; font-weight:700;" title="Batch Print Packing Slips">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            <span>Batch Packing Slips</span>
        </button>
        <!-- Fast Status Transitions -->
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_BULK_ACTIONS.executeBulkStatus('confirmed')" style="height:32px; padding:0 10px; font-size:11px; font-weight:700;">Mark Confirmed</button>
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_BULK_ACTIONS.executeBulkStatus('packed')" style="height:32px; padding:0 10px; font-size:11px; font-weight:700;">Mark Packed</button>
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_BULK_ACTIONS.executeBulkStatus('shipped')" style="height:32px; padding:0 10px; font-size:11px; font-weight:700;">Mark Shipped</button>
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_BULK_ACTIONS.clearSelection()" style="height:32px; padding:0 10px; font-size:11px; font-weight:700; color:#DC2626;">✕ Deselect</button>
    </div>
</div>

<!-- ══ Responsive Orders Table Card ══ -->
<div class="dt-order-table-card">
    <div class="dt-table-responsive">
        <table class="dt-order-table">
            <thead>
                <tr>
                    <th class="col-check" style="width:36px; text-align:center;">
                        <input type="checkbox" class="dt-checkbox" onchange="window.DT_BULK_ACTIONS.toggleSelectAll(this)" title="Select all orders">
                    </th>
                    <th class="col-id" style="width:105px;">Order ID</th>
                    <th class="col-date" style="width:105px;">Date</th>
                    <th class="col-customer" style="width:155px;">Customer</th>
                    <th class="col-items" style="width:65px;">Items</th>
                    <th class="col-amount" style="width:90px;">Amount</th>
                    <th class="col-payment" style="width:105px;">Payment</th>
                    <th class="col-shipping" style="width:105px;">Shipping</th>
                    <th class="col-status" style="width:85px;">Status</th>
                    <th class="col-source" style="width:75px;">Source</th>
                    <th class="col-actions" style="width:145px; text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody id="ordersTableBody">
                <?php foreach ($orders_list as $o): ?>
                <?php
                    if ($filter_status !== 'all' && $o['status'] !== $filter_status) continue;
                ?>
                <tr class="dt-order-row" data-id="<?php echo $o['id']; ?>" data-customer="<?php echo htmlspecialchars($o['customer']); ?>" data-phone="<?php echo htmlspecialchars($o['phone']); ?>" data-status="<?php echo $o['status']; ?>" data-payment="<?php echo $o['payment_status']; ?>">
                    <td class="col-check" style="text-align:center;">
                        <input type="checkbox" class="dt-checkbox dt-order-check" onchange="window.DT_BULK_ACTIONS.onRowCheckChange(this)">
                    </td>
                    <td class="col-id">
                        <div style="display:flex; align-items:center; gap:4px;">
                            <button type="button" class="dt-expand-btn" onclick="window.DT_ORDER_VIEW.toggleRowDetails('<?php echo $o['id']; ?>', this)" title="Quick Expand Row" style="background:none; border:none; padding:0; cursor:pointer; color:#64748B; display:flex; align-items:center; transition:transform 0.15s ease;">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </button>
                            <a href="/admin/orders/view.php?id=<?php echo $o['id']; ?>" class="dt-order-id-link"><?php echo $o['id']; ?></a>
                        </div>
                    </td>
                    <td class="col-date" style="white-space:nowrap; font-size:11px; color:#64748B;">
                        <?php echo str_replace(' 2026', '', $o['date']); ?>
                    </td>
                    <td class="col-customer">
                        <div class="dt-customer-cell">
                            <span class="dt-customer-name" title="<?php echo htmlspecialchars($o['customer']); ?>"><?php echo htmlspecialchars($o['customer']); ?></span>
                            <span class="dt-customer-phone"><?php echo htmlspecialchars($o['phone']); ?></span>
                        </div>
                    </td>
                    <td class="col-items">
                        <span class="dt-items-pill" title="<?php echo htmlspecialchars($o['items_summary']); ?>">
                            <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="#8A681F" stroke-width="2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline></svg>
                            <span><?php echo $o['items_count']; ?></span>
                        </span>
                    </td>
                    <td class="col-amount">
                        <div class="dt-amount-cell">
                            <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="10" height="10"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                            <span><?php echo number_format($o['amount']); ?></span>
                        </div>
                    </td>
                    <td class="col-payment">
                        <div style="display:flex; flex-direction:column; gap:1px;">
                            <span class="dt-pay-badge <?php echo $o['payment_status']; ?>"><?php echo strtoupper($o['payment_status']); ?></span>
                            <span style="font-size:9.5px; color:#64748B; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:95px;"><?php echo $o['payment']; ?></span>
                        </div>
                    </td>
                    <td class="col-shipping">
                        <div style="display:flex; flex-direction:column; gap:1px;">
                            <span style="font-weight:700; font-size:10.5px; color:#334155; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:95px;"><?php echo $o['shipping']; ?></span>
                            <span style="font-size:9.5px; color:#64748B; font-family:monospace;"><?php echo $o['tracking']; ?></span>
                        </div>
                    </td>
                    <td class="col-status">
                        <span id="statusBadge_<?php echo $o['id']; ?>" class="dt-status-badge <?php echo $o['status']; ?>">
                            <span class="dt-status-dot"></span>
                            <span><?php echo str_replace('_', ' ', $o['status']); ?></span>
                        </span>
                    </td>
                    <td class="col-source">
                        <span class="dt-kpi-badge up" style="font-size:9.5px; padding:1px 5px; background:#F8FAFC; border:1px solid #E2E8F0; color:#475569; white-space:nowrap;"><?php echo $o['source']; ?></span>
                    </td>
                    <td class="col-actions" style="text-align:right;">
                        <div class="dt-row-actions" style="justify-content:flex-end; gap:3px;">
                            <!-- 1. Quick View Drawer Popup -->
                            <button type="button" class="dt-action-btn view" onclick="window.DT_ORDER_VIEW.openDrawer('<?php echo $o['id']; ?>')" title="Quick View Drawer Popup">
                                <svg viewBox="0 0 24 24" width="12.5" height="12.5" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </button>
                            <!-- 2. Edit / Update Status Modal Popup -->
                            <button type="button" class="dt-action-btn edit" onclick="window.DT_ORDER_STATUS.openStatusModal('<?php echo $o['id']; ?>', '<?php echo $o['status']; ?>')" title="Update Status & Tracking Popup">
                                <svg viewBox="0 0 24 24" width="12.5" height="12.5" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </button>
                            <!-- 3. GST Tax Invoice Modal Popup -->
                            <button type="button" class="dt-action-btn invoice" onclick="window.DT_ORDER_VIEW.openInvoiceModal('<?php echo $o['id']; ?>')" title="GST Tax Invoice Popup">
                                <svg viewBox="0 0 24 24" width="12.5" height="12.5" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                            </button>
                            <!-- 4. Courier Shipping Label & Box Barcode Popup -->
                            <button type="button" class="dt-action-btn packing" onclick="window.DT_ORDER_VIEW.openShippingLabelModal('<?php echo $o['id']; ?>')" title="Print Courier Shipping Label & Box Barcode">
                                <svg viewBox="0 0 24 24" width="12.5" height="12.5" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                            </button>
                            <!-- 5. Cancel / Trash Action Modal Popup -->
                            <?php if ($o['status'] !== 'cancelled' && $o['status'] !== 'delivered'): ?>
                            <button type="button" class="dt-action-btn danger" onclick="window.DT_ORDER_STATUS.openCancelModal('<?php echo $o['id']; ?>')" title="Cancel Consignment Popup">
                                <svg viewBox="0 0 24 24" width="12.5" height="12.5" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>

                <!-- Expandable Inline Details Row -->
                <tr id="detailsRow_<?php echo $o['id']; ?>" class="dt-details-row" style="display:none; background:#FAF8F4;">
                    <td colspan="11" style="padding:10px 14px; border-bottom:1.5px solid #E2DFD7;">
                        <div style="display:grid; grid-template-columns: 1.5fr 1fr 1fr auto; gap:12px; align-items:center; background:#FFFFFF; border:1px solid #E2DFD7; border-radius:6px; padding:10px 12px;">
                            <div>
                                <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase;">Items Summary</div>
                                <div style="font-size:11.5px; font-weight:700; color:#0F172A; margin-top:2px;"><?php echo htmlspecialchars($o['items_summary']); ?></div>
                                <div style="font-size:10px; color:#64748B;">Total Qty: <?php echo $o['items_count']; ?> • Valuation: ₹<?php echo number_format($o['amount']); ?></div>
                            </div>
                            <div>
                                <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase;">Carrier &amp; Dispatch</div>
                                <div style="font-size:11px; font-weight:700; color:#334155; margin-top:2px;"><?php echo $o['shipping']; ?></div>
                                <div style="font-size:10px; color:#1D4ED8; font-family:monospace;">AWB: <?php echo $o['tracking']; ?></div>
                            </div>
                            <div>
                                <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase;">Customer Contact</div>
                                <div style="font-size:11px; font-weight:700; color:#334155; margin-top:2px;"><?php echo htmlspecialchars($o['customer_type']); ?></div>
                                <div style="font-size:10px; color:#64748B;"><?php echo htmlspecialchars($o['phone']); ?></div>
                            </div>
                            <div style="display:flex; gap:6px;">
                                <a href="/admin/orders/view.php?id=<?php echo $o['id']; ?>" class="dt-btn dt-btn-pale" style="height:26px; font-size:10px; padding:0 8px;">Full Details</a>
                                <a href="/admin/orders/invoice.php?id=<?php echo $o['id']; ?>" class="dt-btn dt-btn-emerald" style="height:26px; font-size:10px; padding:0 8px;">Tax Invoice</a>
                            </div>
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
