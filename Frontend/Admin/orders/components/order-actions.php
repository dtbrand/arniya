<?php
/**
 * order-actions.php — Update Status, Cancel, Invoice & Packing Slip Popup Modals
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ══ Update Status Modal ══ -->
<div id="updateStatusModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); z-index:999999; backdrop-filter:blur(4px); align-items:center; justify-content:center;" onclick="if(event.target===this)window.DT_ORDER_STATUS.closeStatusModal()">
    <div style="background:#FFFFFF; border:1px solid #D4AF37; border-radius:10px; width:95%; max-width:440px; box-shadow:0 8px 30px rgba(0,0,0,0.3); overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif;">
        <div style="padding:14px 18px; background:#FAF8F4; border-bottom:1px solid #E2DFD7; display:flex; align-items:center; justify-content:space-between;">
            <h3 style="margin:0; font-size:14px; font-weight:800; color:#181512; display:flex; align-items:center; gap:6px;">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                <span>Update Order Status</span>
            </h3>
            <button type="button" onclick="window.DT_ORDER_STATUS.closeStatusModal()" style="border:none; background:transparent; font-size:16px; cursor:pointer; color:#64748B; padding:0 4px;" title="Close Modal">✕</button>
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
<div id="cancelOrderModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); z-index:999999; backdrop-filter:blur(4px); align-items:center; justify-content:center;" onclick="if(event.target===this)window.DT_ORDER_STATUS.closeCancelModal()">
    <div style="background:#FFFFFF; border:1px solid #FECACA; border-radius:10px; width:95%; max-width:440px; box-shadow:0 8px 30px rgba(0,0,0,0.3); overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif;">
        <div style="padding:14px 18px; background:#FEF2F2; border-bottom:1px solid #FECACA; display:flex; align-items:center; justify-content:space-between;">
            <h3 style="margin:0; font-size:14px; font-weight:800; color:#DC2626; display:flex; align-items:center; gap:6px;">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <span>Cancel Order Confirmation</span>
            </h3>
            <button type="button" onclick="window.DT_ORDER_STATUS.closeCancelModal()" style="border:none; background:transparent; font-size:16px; cursor:pointer; color:#64748B; padding:0 4px;" title="Close Modal">✕</button>
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

<!-- ══ GST Tax Invoice Preview Modal ══ -->
<div id="orderInvoiceModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.65); z-index:999999; backdrop-filter:blur(4px); align-items:center; justify-content:center;" onclick="if(event.target===this)window.DT_ORDER_VIEW.closeInvoiceModal()">
    <div style="background:#FFFFFF; border:1.5px solid #D4AF37; border-radius:12px; width:95%; max-width:700px; max-height:90vh; box-shadow:0 12px 40px rgba(0,0,0,0.3); display:flex; flex-direction:column; overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif; position:relative;">
        <span id="invoiceModalOrderId" style="display:none;">DTB-001624</span>
        
        <!-- Top Action Controls (Clean Floating Top-Right) -->
        <div style="position:absolute; top:12px; right:14px; z-index:20; display:flex; align-items:center; gap:6px;">
            <a id="invoiceModalFullPageLink" href="#" target="_blank" class="dt-btn dt-btn-pale" style="height:26px; padding:0 8px; font-size:10.5px; background:#FAF5E8;" title="Open in Full Tab">
                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                <span>Full Page ↗</span>
            </a>
            <button type="button" onclick="window.DT_ORDER_VIEW.closeInvoiceModal()" style="width:26px; height:26px; border-radius:50%; border:1px solid #CBD5E1; background:#FFFFFF; color:#64748B; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:13px; transition:all 0.15s ease;" title="Close Modal">✕</button>
        </div>

        <!-- Modal Scrollable Content -->
        <div id="invoiceModalBody" style="flex:1; overflow-y:auto; padding:20px 22px 14px 22px; font-size:12px; color:#181512; background:#FFFFFF;">
            <!-- Loaded dynamically by JS -->
        </div>

        <!-- Modal Footer -->
        <div style="padding:10px 18px; background:#FAF8F4; border-top:1px solid #E2DFD7; display:flex; justify-content:space-between; align-items:center; flex-shrink:0; flex-wrap:wrap; gap:8px;">
            <div style="font-size:11px; color:#64748B;">Surat Central Depot • GSTIN: 24AAECJ1928K1Z5</div>
            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_VIEW.closeInvoiceModal()" style="height:32px; padding:0 10px; font-size:11px;">✕ Close</button>
                <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_VIEW.downloadInvoiceExcel()" style="height:32px; padding:0 10px; font-size:11px; color:#15803D; border-color:#86EFAC; background:#DCFCE7;" title="Download Formatted Excel Invoice">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="8" y1="13" x2="16" y2="13"></line><line x1="8" y1="17" x2="16" y2="17"></line></svg>
                    <span>Excel (.xls)</span>
                </button>
                <button type="button" class="dt-btn dt-btn-emerald" onclick="window.DT_ORDER_VIEW.downloadInvoicePDF()" style="height:32px; padding:0 12px; font-size:11px;" title="Download PDF Tax Invoice">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Download PDF</span>
                </button>
                <button type="button" class="dt-btn dt-btn-gold" onclick="window.print()" style="height:32px; padding:0 12px; font-size:11px;" title="Direct Print">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    <span>Print Invoice</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ══ Warehouse Packing Slip Preview Modal ══ -->
<div id="orderPackingSlipModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.65); z-index:999999; backdrop-filter:blur(4px); align-items:center; justify-content:center;" onclick="if(event.target===this)window.DT_ORDER_VIEW.closePackingSlipModal()">
    <div style="background:#FFFFFF; border:1.5px solid #D4AF37; border-radius:12px; width:95%; max-width:700px; max-height:90vh; box-shadow:0 12px 40px rgba(0,0,0,0.3); display:flex; flex-direction:column; overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif; position:relative;">
        <span id="packingModalOrderId" style="display:none;">DTB-001624</span>
        
        <!-- Top Action Controls (Clean Floating Top-Right) -->
        <div style="position:absolute; top:12px; right:14px; z-index:20; display:flex; align-items:center; gap:6px;">
            <a id="packingModalFullPageLink" href="#" target="_blank" class="dt-btn dt-btn-pale" style="height:26px; padding:0 8px; font-size:10.5px; background:#FAF5E8;" title="Open in Full Tab">
                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                <span>Full Page ↗</span>
            </a>
            <button type="button" onclick="window.DT_ORDER_VIEW.closePackingSlipModal()" style="width:26px; height:26px; border-radius:50%; border:1px solid #CBD5E1; background:#FFFFFF; color:#64748B; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:13px; transition:all 0.15s ease;" title="Close Modal">✕</button>
        </div>

        <!-- Modal Scrollable Content -->
        <div id="packingModalBody" style="flex:1; overflow-y:auto; padding:20px 22px 14px 22px; font-size:12px; color:#181512; background:#FFFFFF;">
            <!-- Loaded dynamically by JS -->
        </div>

        <!-- Modal Footer -->
        <div style="padding:10px 18px; background:#FAF8F4; border-top:1px solid #E2DFD7; display:flex; justify-content:space-between; align-items:center; flex-shrink:0; flex-wrap:wrap; gap:8px;">
            <div style="font-size:11px; color:#64748B;">Internal Depot Manifest • QC Pass Verified</div>
            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_VIEW.closePackingSlipModal()" style="height:32px; padding:0 10px; font-size:11px;">✕ Close</button>
                <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_VIEW.downloadPackingSlipExcel()" style="height:32px; padding:0 10px; font-size:11px; color:#B45309; border-color:#FCD34D; background:#FEF3C7;" title="Download Formatted Excel Manifest">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="8" y1="13" x2="16" y2="13"></line><line x1="8" y1="17" x2="16" y2="17"></line></svg>
                    <span>Excel (.xls)</span>
                </button>
                <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_ORDER_VIEW.downloadPackingSlipPDF()" style="height:32px; padding:0 12px; font-size:11px;" title="Download PDF Manifest">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Download PDF</span>
                </button>
                <button type="button" class="dt-btn dt-btn-emerald" onclick="window.print()" style="height:32px; padding:0 12px; font-size:11px;" title="Direct Print">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    <span>Print Manifest</span>
                </button>
            </div>
        </div>
    </div>
</div>
