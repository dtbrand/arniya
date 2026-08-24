<?php
/**
 * retail-order-table.php — DT Brand's & Jai Hanuman Tex
 * Retail Orders Table Component
 */
require_once __DIR__ . '/retail-data.php';
$orders = getRetailOrders();
?>

<div class="dt-retail-card">
    <div class="dt-retail-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
            <h4 class="dt-retail-card-title">Retail Orders &amp; Dispatches</h4>
        </div>

        <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
            <div style="position:relative; width:200px;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#78716C" stroke-width="2.2" style="position:absolute; left:9px; top:50%; transform:translateY(-50%); pointer-events:none;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" id="retailOrderSearchInput" class="dt-retail-input" style="width:100%; height:30px; padding-left:28px; font-size:0.72rem; border-radius:6px; border:1.2px solid #EAE5D9; box-sizing:border-box;" placeholder="Search Order ID, Customer, Saree..." oninput="filterRetailOrders()">
            </div>

            <select id="retailOrderStatusFilter" class="dt-retail-input" style="height:30px; font-size:0.72rem; padding:0 8px; border-radius:6px; border:1.2px solid #EAE5D9; box-sizing:border-box;" onchange="filterRetailOrders()">
                <option value="all">All Statuses</option>
                <option value="delivered">Delivered</option>
                <option value="in transit">In Transit</option>
                <option value="processing">Processing</option>
            </select>

            <a href="/DT%20Brand/admin/orders/" class="dt-btn dt-btn-pale dt-btn-sm">Full Orders Module →</a>
        </div>
    </div>

    <div style="overflow-x:auto; width:100%;">
        <table class="dt-retail-table">
            <thead>
                <tr>
                    <th style="width:30px;"><input type="checkbox" onchange="toggleAllRetailCheckboxes(this)"></th>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Ordered Sarees &amp; SKUs</th>
                    <th style="text-align:right;">Order Total (₹)</th>
                    <th>Payment Mode</th>
                    <th>Shipping Partner</th>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody id="retailOrdersTableBody">
                <?php foreach ($orders as $o): ?>
                    <tr class="retail-order-row" data-status="<?php echo strtolower($o['status']); ?>">
                        <td><input type="checkbox" class="retail-row-checkbox" onchange="updateRetailBulkActionCount()"></td>
                        <td><span class="retail-order-id-cell dt-retail-order-id"><?php echo $o['id']; ?></span></td>
                        <td><strong class="retail-order-cust-cell" style="color:#181512; font-size:0.8rem;"><?php echo htmlspecialchars($o['customer']); ?></strong></td>
                        <td><span class="retail-order-items-cell" style="font-size:0.75rem; color:#4B5563; font-weight:600;"><?php echo htmlspecialchars($o['items']); ?></span></td>
                        <td style="text-align:right; font-weight:900; color:#181512; font-size:0.85rem;">₹<?php echo number_format($o['amount']); ?></td>
                        <td style="font-size:0.72rem; color:#78716C;"><?php echo $o['payment']; ?></td>
                        <td style="font-size:0.72rem; color:#78716C;"><?php echo $o['shipping']; ?></td>
                        <td><span class="dt-status-pill-clean <?php echo $o['badge']; ?>"><?php echo $o['status']; ?></span></td>
                        <td style="font-size:0.72rem; color:#78716C;"><?php echo $o['date']; ?></td>
                        <td style="text-align:right; white-space:nowrap;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="openRetailOrderQuickView('<?php echo $o['id']; ?>', '<?php echo addslashes($o['customer']); ?>', '<?php echo addslashes($o['items']); ?>', '₹<?php echo number_format($o['amount']); ?>', '<?php echo $o['payment']; ?>', '<?php echo $o['shipping']; ?>', '<?php echo $o['status']; ?>', '<?php echo $o['date']; ?>')">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                <span>Inspect</span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Order Quick View Modal -->
<div id="dtRetailOrderModal" class="dt-modal-backdrop">
    <div class="dt-modal-dialog">
        <div class="dt-modal-head">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Retail Purchase Order Particulars</strong>
            </div>
            <button type="button" onclick="closeRetailModal('dtRetailOrderModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>
        <div class="dt-modal-body">
            <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:12px 14px; display:flex; flex-direction:column; gap:6px; font-size:0.78rem;">
                <div style="display:flex; justify-content:space-between;"><span style="color:#78716C;">Order ID:</span><strong id="quickRetailOrderId" style="font-family:monospace; color:#8A681F;">—</strong></div>
                <div style="display:flex; justify-content:space-between;"><span style="color:#78716C;">Customer:</span><strong id="quickRetailOrderCust" style="color:#181512;">—</strong></div>
                <div style="display:flex; justify-content:space-between;"><span style="color:#78716C;">Items:</span><strong id="quickRetailOrderItems" style="color:#181512;">—</strong></div>
                <div style="display:flex; justify-content:space-between;"><span style="color:#78716C;">Payment Mode:</span><strong id="quickRetailOrderPay" style="color:#181512;">—</strong></div>
                <div style="display:flex; justify-content:space-between;"><span style="color:#78716C;">Shipping Carrier:</span><strong id="quickRetailOrderShip" style="color:#181512;">—</strong></div>
                <div style="display:flex; justify-content:space-between;"><span style="color:#78716C;">Status:</span><span id="quickRetailOrderStatus" class="dt-status-pill-clean emerald">—</span></div>
            </div>
            <div style="background:linear-gradient(135deg, #181512 0%, #2A241E 100%); border:1px solid #8A681F; border-radius:8px; padding:12px 16px; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <span style="font-size:0.68rem; color:#FFE57F; font-weight:800; text-transform:uppercase;">TOTAL AMOUNT PAID</span>
                    <div id="quickRetailOrderAmt" style="font-size:1.4rem; font-weight:900; color:#FFFFFF;">₹0</div>
                </div>
                <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" onclick="sendRetailWhatsAppNotice()">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#FFFFFF" stroke-width="2.3"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    <span>WhatsApp Update</span>
                </button>
            </div>
        </div>
        <div class="dt-modal-foot">
            <button type="button" class="dt-btn dt-btn-pale" onclick="closeRetailModal('dtRetailOrderModal')">Close</button>
            <a href="/DT%20Brand/admin/orders/" class="dt-btn dt-btn-gold">Open in Orders Suite</a>
        </div>
    </div>
</div>
