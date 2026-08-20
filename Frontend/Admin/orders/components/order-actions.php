<?php
/**
 * order-actions.php — Update Status & Cancel Order Modals
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ══ Update Status Modal ══ -->
<div id="updateStatusModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); z-index:999999; backdrop-filter:blur(4px); align-items:center; justify-content:center;">
    <div style="background:#FFFFFF; border:1px solid #D4AF37; border-radius:10px; width:95%; max-width:440px; box-shadow:0 8px 30px rgba(0,0,0,0.3); overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif;">
        <div style="padding:14px 18px; background:#FAF8F4; border-bottom:1px solid #E2DFD7; display:flex; align-items:center; justify-content:space-between;">
            <h3 style="margin:0; font-size:14px; font-weight:800; color:#181512; display:flex; align-items:center; gap:6px;">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                <span>Update Order Status</span>
            </h3>
            <button type="button" onclick="window.DT_ORDER_STATUS.closeStatusModal()" style="border:none; background:transparent; font-size:14px; cursor:pointer; color:#64748B;">✕</button>
        </div>
        <div style="padding:16px; display:flex; flex-direction:column; gap:12px;">
            <div style="font-size:12px; color:#475569;">
                Order ID: <strong id="modalOrderIdText" style="color:#181512;">DTB-001624</strong>
            </div>

            <div>
                <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:4px;">Current Status</label>
                <input type="text" id="modalCurrentStatus" readonly class="dt-order-search-input" style="height:32px; background:#F1F5F9; color:#64748B;">
            </div>

            <div>
                <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:4px;">New Target Status</label>
                <select id="modalNewStatus" class="dt-order-search-input" style="height:34px; font-weight:700;">
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
            </div>

            <div>
                <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:4px;">Status Transition Reason (Optional)</label>
                <input type="text" id="modalStatusReason" placeholder="e.g. Manifest verified and passed to courier dock" class="dt-order-search-input" style="height:32px;">
            </div>
        </div>
        <div style="padding:12px 18px; background:#FAF8F4; border-top:1px solid #E2DFD7; display:flex; justify-content:flex-end; gap:8px;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_STATUS.closeStatusModal()">Cancel</button>
            <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_ORDER_STATUS.confirmStatusUpdate()">Confirm Update</button>
        </div>
    </div>
</div>

<!-- ══ Cancel Order Modal ══ -->
<div id="cancelOrderModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); z-index:999999; backdrop-filter:blur(4px); align-items:center; justify-content:center;">
    <div style="background:#FFFFFF; border:1px solid #FECACA; border-radius:10px; width:95%; max-width:440px; box-shadow:0 8px 30px rgba(0,0,0,0.3); overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif;">
        <div style="padding:14px 18px; background:#FEF2F2; border-bottom:1px solid #FECACA; display:flex; align-items:center; justify-content:space-between;">
            <h3 style="margin:0; font-size:14px; font-weight:800; color:#DC2626; display:flex; align-items:center; gap:6px;">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <span>Cancel Order Confirmation</span>
            </h3>
            <button type="button" onclick="window.DT_ORDER_STATUS.closeCancelModal()" style="border:none; background:transparent; font-size:14px; cursor:pointer; color:#64748B;">✕</button>
        </div>
        <div style="padding:16px; display:flex; flex-direction:column; gap:12px;">
            <div style="font-size:12px; color:#475569;">
                Are you sure you want to cancel order <strong id="cancelModalOrderIdText" style="color:#DC2626;">DTB-001624</strong>?
            </div>

            <div>
                <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:4px;">Cancellation Reason</label>
                <select id="cancelReasonSelect" class="dt-order-search-input" style="height:34px;">
                    <option value="Customer Request">Customer Request via WhatsApp/Phone</option>
                    <option value="Out of Stock / Weave Delay">Out of Stock / Loom Weaving Delay</option>
                    <option value="Payment Gateway Failure">Payment Gateway Failure</option>
                    <option value="Undeliverable Address">Undeliverable Pin Code / Godown Address</option>
                    <option value="Duplicate Order">Duplicate Order Placed</option>
                </select>
            </div>
        </div>
        <div style="padding:12px 18px; background:#FAF8F4; border-top:1px solid #E2DFD7; display:flex; justify-content:flex-end; gap:8px;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_STATUS.closeCancelModal()">Keep Order</button>
            <button type="button" class="dt-btn dt-btn-danger" onclick="window.DT_ORDER_STATUS.confirmCancelOrder()">Confirm Cancellation</button>
        </div>
    </div>
</div>
