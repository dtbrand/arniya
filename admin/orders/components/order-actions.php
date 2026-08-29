<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * order-actions.php — Update Status, Cancel, Invoice & Packing Slip Popup Modals
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ══ Update Status Modal (Luxury Smart Redesign) ══ -->
<div id="updateStatusModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.65); z-index:999999; backdrop-filter:blur(4px); align-items:center; justify-content:center;" onclick="if(event.target===this)window.DT_ORDER_STATUS.closeStatusModal()">
    <div style="background:#FFFFFF; border:1.5px solid #D4AF37; border-radius:12px; width:95%; max-width:540px; max-height:92vh; box-shadow:0 14px 44px rgba(0,0,0,0.35); display:flex; flex-direction:column; overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif;">
        <!-- Modal Header -->
        <div style="padding:14px 20px; background:#FAF8F4; border-bottom:1.5px solid #E2DFD7; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:34px; height:34px; border-radius:8px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; box-shadow:0 2px 6px rgba(212,175,55,0.2);">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                </div>
                <div>
                    <h3 style="margin:0; font-size:14px; font-weight:800; color:#181512;">Update Order Status &amp; Fulfillment</h3>
                    <p style="margin:2px 0 0 0; font-size:11px; color:#64748B;">Surat Central Depot Dock • Order <strong id="modalOrderIdText" style="color:#8A681F; font-weight:800;">DTB-001624</strong></p>
                </div>
            </div>
            <button type="button" onclick="window.DT_ORDER_STATUS.closeStatusModal()" style="width:28px; height:28px; border-radius:6px; border:1px solid #D4AF37; background:#FAF5E8; color:#8A681F; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:12px; font-weight:800; transition:all 0.15s ease;" title="Close Modal">✕</button>
        </div>

        <!-- Modal Scrollable Body -->
        <div style="padding:18px 20px; overflow-y:auto; display:flex; flex-direction:column; gap:14px; font-size:12px; color:#181512;">
            
            <!-- Current Status & Quick Presets -->
            <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:12px 14px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                    <span style="font-size:10.5px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.04em;">Current Lifecycle Stage</span>
                    <span id="modalCurrentStatusBadge" class="dt-status-badge shipped">
                        <span class="dt-status-dot"></span>
                        <span id="modalCurrentStatusBadgeText">SHIPPED</span>
                    </span>
                </div>
                
                <!-- Recommended 1-Click Fast Presets (100% Real Vector SVGs) -->
                <div style="font-size:11px; color:#64748B; margin-bottom:6px; font-weight:700;">Recommended Fast Transitions:</div>
                <div style="display:flex; flex-wrap:wrap; gap:6px;">
                    <button type="button" onclick="window.DT_ORDER_STATUS.selectPreset('packed', 'QC Passed - 100% Handloom Silk Mark Verified')" style="background:#FFFFFF; border:1px solid #D4AF37; color:#8A681F; padding:5px 10px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer; transition:all 0.15s ease; display:flex; align-items:center; gap:5px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                        <span>Packed &amp; QC Pass</span>
                    </button>
                    <button type="button" onclick="window.DT_ORDER_STATUS.selectPreset('shipped', 'Dispatched from Surat Dock 1 via VRL Logistics')" style="background:#FFFFFF; border:1px solid #86EFAC; color:#15803D; padding:5px 10px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer; transition:all 0.15s ease; display:flex; align-items:center; gap:5px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span>Handover to Courier</span>
                    </button>
                    <button type="button" onclick="window.DT_ORDER_STATUS.selectPreset('out_for_delivery', 'Out for local godown delivery')" style="background:#FFFFFF; border:1px solid #93C5FD; color:#1D4ED8; padding:5px 10px; border-radius:6px; font-size:11px; font-weight:700; cursor:pointer; transition:all 0.15s ease; display:flex; align-items:center; gap:5px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span>Out for Delivery</span>
                    </button>
                    <button type="button" onclick="window.DT_ORDER_STATUS.selectPreset('delivered', 'Delivered to consignee and payment cleared')" style="background:#FAF5E8; border:1.5px solid #8A681F; color:#181512; padding:5px 10px; border-radius:6px; font-size:11px; font-weight:800; cursor:pointer; transition:all 0.15s ease; display:flex; align-items:center; gap:5px; box-shadow:0 1px 3px rgba(0,0,0,0.08);">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#15803D" stroke-width="2.4"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <span>Delivered</span>
                    </button>
                </div>
            </div>

            <!-- Target Status Selector -->
            <div>
                <label style="font-size:11.5px; font-weight:750; color:#181512; display:block; margin-bottom:4px;">New Target Status</label>
                <select id="modalNewStatus" class="dt-order-search-input" style="height:38px; font-weight:750; border-radius:6px; border:1px solid #D4AF37; background:#FFFFFF; padding:0 10px; width:100%; box-sizing:border-box;">
                    <optgroup label="Warehouse &amp; Production Phase">
                        <option value="pending">Pending Verification</option>
                        <option value="confirmed">Confirmed / Payment Verified</option>
                        <option value="processing">Processing &amp; Loom Weaving</option>
                        <option value="packed">Packed &amp; QC Silk Mark Passed</option>
                    </optgroup>
                    <optgroup label="Logistics &amp; Transport Phase">
                        <option value="shipped">Shipped / In Transit (Depot Dispatch)</option>
                        <option value="out_for_delivery">Out for Godown Delivery</option>
                        <option value="delivered">Delivered</option>
                    </optgroup>
                    <optgroup label="Reverse &amp; Exceptions">
                        <option value="return_initiated">Return Initiated</option>
                        <option value="returned">Returned to Depot</option>
                        <option value="refunded">Refunded &amp; Closed</option>
                        <option value="cancelled">Cancelled</option>
                    </optgroup>
                </select>
            </div>

            <!-- Recommended Carrier & AWB Tracking Section -->
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                <div>
                    <label style="font-size:11.5px; font-weight:750; color:#181512; display:block; margin-bottom:4px;">Logistics Carrier</label>
                    <select id="modalCarrierSelect" class="dt-order-search-input" style="height:38px; border-radius:6px; border:1px solid #D4AF37; background:#FFFFFF; padding:0 10px; width:100%; box-sizing:border-box; font-weight:600;">
                        <option value="VRL Logistics Depot">VRL Logistics Depot (Surat)</option>
                        <option value="BlueDart Surface">BlueDart Surface Cargo</option>
                        <option value="Delhivery Express">Delhivery B2B Freight</option>
                        <option value="TCI Freight Godown">TCI Freight (Ring Road)</option>
                        <option value="DTDC Wholesale">DTDC Wholesale Parcel</option>
                        <option value="Safexpress Depot">Safexpress Logistics Hub</option>
                        <option value="Local Surat Depot Delivery">Local Surat Auto Delivery</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:11.5px; font-weight:750; color:#181512; display:flex; justify-content:space-between; margin-bottom:4px;">
                        <span>AWB / Tracking Number</span>
                        <a href="javascript:void(0)" onclick="window.DT_ORDER_STATUS.autoGenerateAWB()" style="color:#8A681F; font-weight:700; font-size:10.5px; text-decoration:none; display:inline-flex; align-items:center; gap:3px;">
                            <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="#8A681F" stroke-width="2.3"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                            <span>Generate</span>
                        </a>
                    </label>
                    <input type="text" id="modalTrackingInput" placeholder="e.g. VRL-99821" value="VRL-99821" class="dt-order-search-input" style="height:38px; border-radius:6px; border:1px solid #D4AF37; font-weight:750; padding:0 10px; width:100%; box-sizing:border-box;">
                </div>
            </div>

            <!-- WhatsApp Instant Notification Toggle -->
            <div style="background:#F0FDF4; border:1px solid #86EFAC; border-radius:8px; padding:10px 12px; display:flex; align-items:center; gap:10px;">
                <input type="checkbox" id="modalNotifyWhatsApp" checked style="width:16px; height:16px; accent-color:#15803D; cursor:pointer;">
                <label for="modalNotifyWhatsApp" style="cursor:pointer; font-size:11.5px; color:#15803D; font-weight:700; display:flex; align-items:center; gap:6px;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="#15803D"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
                    <span>Send 1-Click WhatsApp Live Tracking Alert to Consignee</span>
                </label>
            </div>

            <!-- Status Transition Reason / Notes -->
            <div>
                <label style="font-size:11.5px; font-weight:750; color:#181512; display:block; margin-bottom:4px;">Status Transition Reason (Optional)</label>
                <input type="text" id="modalStatusReason" placeholder="e.g. Manifest verified and passed to courier dock" value="Manifest verified and passed to courier dock" class="dt-order-search-input" style="height:38px; border-radius:6px; border:1px solid #D4AF37; font-weight:600; padding:0 10px; width:100%; box-sizing:border-box;">
                <div style="margin-top:5px; display:flex; gap:6px; flex-wrap:wrap;">
                    <span onclick="document.getElementById('modalStatusReason').value=this.textContent" style="font-size:10px; background:#FAF5E8; color:#8A681F; padding:2px 8px; border-radius:4px; cursor:pointer; border:1px solid #D4AF37; font-weight:700;">QC Passed &amp; Manifest Verified</span>
                    <span onclick="document.getElementById('modalStatusReason').value=this.textContent" style="font-size:10px; background:#FAF5E8; color:#8A681F; padding:2px 8px; border-radius:4px; cursor:pointer; border:1px solid #D4AF37; font-weight:700;">Loaded on Truck #14 (Surat Hub)</span>
                    <span onclick="document.getElementById('modalStatusReason').value=this.textContent" style="font-size:10px; background:#FAF5E8; color:#8A681F; padding:2px 8px; border-radius:4px; cursor:pointer; border:1px solid #D4AF37; font-weight:700;">Consignee E-Sign Delivered</span>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div style="padding:12px 20px; background:#FAF8F4; border-top:1.5px solid #E2DFD7; display:flex; justify-content:space-between; align-items:center; flex-shrink:0;">
            <div style="font-size:11px; color:#64748B;">Surat Wholesale Central Depot</div>
            <div style="display:flex; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_STATUS.closeStatusModal()" style="height:34px; padding:0 14px; font-size:11.5px; display:inline-flex; align-items:center; gap:5px;">
                    <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    <span>Cancel</span>
                </button>
                <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_ORDER_STATUS.confirmStatusUpdate()" style="height:34px; padding:0 16px; font-size:11.5px; font-weight:800; display:inline-flex; align-items:center; gap:5px;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.4"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Confirm &amp; Sync Status</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ══ Cancel Order Modal ══ -->
<div id="cancelOrderModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); z-index:999999; backdrop-filter:blur(4px); align-items:center; justify-content:center;" onclick="if(event.target===this)window.DT_ORDER_STATUS.closeCancelModal()">
    <div style="background:#FFFFFF; border:1px solid #FECACA; border-radius:12px; width:95%; max-width:460px; box-shadow:0 8px 30px rgba(0,0,0,0.3); overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif;">
        <div style="padding:14px 18px; background:#FEF2F2; border-bottom:1px solid #FECACA; display:flex; align-items:center; justify-content:space-between;">
            <h3 style="margin:0; font-size:14px; font-weight:800; color:#DC2626; display:flex; align-items:center; gap:6px;">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <span>Cancel Order Confirmation</span>
            </h3>
            <button type="button" onclick="window.DT_ORDER_STATUS.closeCancelModal()" style="border:none; background:transparent; font-size:16px; cursor:pointer; color:#64748B; padding:0 4px;" title="Close Modal">
                <svg viewBox="0 0 24 24" width="12.5" height="12.5" fill="none" stroke="currentColor" stroke-width="2.3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div style="padding:16px 18px; display:flex; flex-direction:column; gap:12px; font-size:12px;">
            <div style="color:#475569;">
                Are you sure you want to cancel order <strong id="cancelModalOrderIdText" style="color:#DC2626;">DTB-001624</strong>?
            </div>

            <div>
                <label style="font-size:11.5px; font-weight:700; color:#475569; display:block; margin-bottom:4px;">Cancellation Reason</label>
                <select id="cancelReasonSelect" class="dt-order-search-input" style="height:36px; border-radius:6px;">
                    <option value="Customer Request">Customer Request via WhatsApp/Phone</option>
                    <option value="Out of Stock / Weave Delay">Out of Stock / Loom Weaving Delay</option>
                    <option value="Payment Gateway Failure">Payment Gateway Failure</option>
                    <option value="Undeliverable Address">Undeliverable Pin Code / Godown Address</option>
                    <option value="Duplicate Order">Duplicate Order Placed</option>
                </select>
            </div>
        </div>
        <div style="padding:12px 18px; background:#FAF8F4; border-top:1px solid #E2DFD7; display:flex; justify-content:flex-end; gap:8px;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_STATUS.closeCancelModal()" style="height:34px; padding:0 14px; font-size:11.5px;">Keep Order</button>
            <button type="button" class="dt-btn dt-btn-danger" onclick="window.DT_ORDER_STATUS.confirmCancelOrder()" style="height:34px; padding:0 16px; font-size:11.5px; font-weight:700; display:inline-flex; align-items:center; gap:5px;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                <span>Confirm Cancellation</span>
            </button>
        </div>
    </div>
</div>

<!-- ══ GST Tax Invoice Preview Modal ══ -->
<div id="orderInvoiceModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.65); z-index:999999; backdrop-filter:blur(4px); align-items:center; justify-content:center;" onclick="if(event.target===this)window.DT_ORDER_VIEW.closeInvoiceModal()">
    <div style="background:#FFFFFF; border:1.5px solid #D4AF37; border-radius:12px; width:95%; max-width:700px; max-height:90vh; box-shadow:0 12px 40px rgba(0,0,0,0.3); display:flex; flex-direction:column; overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif; position:relative;">
        <span id="invoiceModalOrderId" style="display:none;">DTB-001624</span>
        
        <!-- Top Action Controls (Fixed Luxury Full Page Box) -->
        <div style="position:absolute; top:16px; right:18px; z-index:20;">
            <a id="invoiceModalFullPageLink" href="#" target="_blank" style="display:inline-flex; align-items:center; gap:5px; height:28px; padding:0 10px; font-size:11px; font-weight:700; color:#8A681F; background:#FAF5E8; border:1px solid #D4AF37; border-radius:6px; text-decoration:none; box-shadow:0 1px 4px rgba(212,175,55,0.18); transition:all 0.15s ease;" title="Open Tax Invoice in Full Tab">
                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                <span>Full Page ↗</span>
            </a>
        </div>

        <!-- Modal Scrollable Content -->
        <div id="invoiceModalBody" style="flex:1; overflow-y:auto; padding:20px 22px 14px 22px; font-size:12px; color:#181512; background:#FFFFFF;">
            <!-- Loaded dynamically by JS -->
        </div>

        <!-- Modal Footer -->
        <div style="padding:10px 18px; background:#FAF8F4; border-top:1px solid #E2DFD7; display:flex; justify-content:space-between; align-items:center; flex-shrink:0; flex-wrap:wrap; gap:8px;">
            <div style="font-size:11px; color:#64748B;">Surat Central Depot • GSTIN: 24AAECJ1928K1Z5</div>
            <div style="display:flex; gap:8px; align-items:center;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_VIEW.closeInvoiceModal()" style="height:32px; padding:0 12px; font-size:11.5px;">✕ Close</button>
                <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_ORDER_VIEW.downloadInvoicePDF()" style="height:32px; padding:0 14px; font-size:11.5px;" title="Download PDF Tax Invoice">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Download PDF</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ══ Warehouse Packing Slip Preview Modal ══ -->
<div id="orderPackingSlipModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.65); z-index:999999; backdrop-filter:blur(4px); align-items:center; justify-content:center;" onclick="if(event.target===this)window.DT_ORDER_VIEW.closePackingSlipModal()">
    <div style="background:#FFFFFF; border:1.5px solid #D4AF37; border-radius:12px; width:95%; max-width:700px; max-height:90vh; box-shadow:0 12px 40px rgba(0,0,0,0.3); display:flex; flex-direction:column; overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif; position:relative;">
        <span id="packingModalOrderId" style="display:none;">DTB-001624</span>
        
        <!-- Top Action Controls (Fixed Luxury Full Page Box) -->
        <div style="position:absolute; top:16px; right:18px; z-index:20;">
            <a id="packingModalFullPageLink" href="#" target="_blank" style="display:inline-flex; align-items:center; gap:5px; height:28px; padding:0 10px; font-size:11px; font-weight:700; color:#8A681F; background:#FAF5E8; border:1px solid #D4AF37; border-radius:6px; text-decoration:none; box-shadow:0 1px 4px rgba(212,175,55,0.18); transition:all 0.15s ease;" title="Open Packing Manifest in Full Tab">
                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                <span>Full Page ↗</span>
            </a>
        </div>

        <!-- Modal Scrollable Content -->
        <div id="packingModalBody" style="flex:1; overflow-y:auto; padding:20px 22px 14px 22px; font-size:12px; color:#181512; background:#FFFFFF;">
            <!-- Loaded dynamically by JS -->
        </div>

        <!-- Modal Footer -->
        <div style="padding:10px 18px; background:#FAF8F4; border-top:1px solid #E2DFD7; display:flex; justify-content:space-between; align-items:center; flex-shrink:0; flex-wrap:wrap; gap:8px;">
            <div style="font-size:11px; color:#64748B;">Internal Depot Manifest • QC Pass Verified</div>
            <div style="display:flex; gap:8px; align-items:center;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_VIEW.closePackingSlipModal()" style="height:32px; padding:0 12px; font-size:11.5px;">✕ Close</button>
                <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_ORDER_VIEW.downloadPackingSlipPDF()" style="height:32px; padding:0 14px; font-size:11.5px;" title="Download PDF Manifest">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Download PDF</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ══ Courier Shipping Label & Box Barcode Preview Modal ══ -->
<div id="orderShippingLabelModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.65); z-index:999999; backdrop-filter:blur(4px); align-items:center; justify-content:center;" onclick="if(event.target===this)window.DT_ORDER_VIEW.closeShippingLabelModal()">
    <div style="background:#FFFFFF; border:1.5px solid #D4AF37; border-radius:12px; width:95%; max-width:540px; max-height:92vh; box-shadow:0 14px 44px rgba(0,0,0,0.35); display:flex; flex-direction:column; overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif; position:relative;">
        <span id="shippingLabelModalOrderId" style="display:none;">DTB-001624</span>
        
        <!-- Top Action Controls -->
        <div style="position:absolute; top:14px; right:16px; z-index:20;">
            <a id="shippingLabelModalFullPageLink" href="#" target="_blank" style="display:inline-flex; align-items:center; gap:5px; height:28px; padding:0 10px; font-size:11px; font-weight:700; color:#8A681F; background:#FAF5E8; border:1px solid #D4AF37; border-radius:6px; text-decoration:none; box-shadow:0 1px 4px rgba(212,175,55,0.18); transition:all 0.15s ease;" title="Open Label in Full Tab">
                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                <span>Full Page ↗</span>
            </a>
        </div>

        <!-- Modal Header -->
        <div style="padding:14px 18px 8px 18px; background:#FAF8F4; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:34px; height:34px; border-radius:8px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                </div>
                <div>
                    <h3 style="margin:0; font-size:14px; font-weight:800; color:#181512;">Shipping Label &amp; Packing Manifest</h3>
                    <p style="margin:2px 0 0 0; font-size:11px; color:#64748B;">Surat Central Depot • Order <strong id="shippingLabelOrderIdTitle" style="color:#8A681F;">DTB-001624</strong></p>
                </div>
            </div>
        </div>

        <!-- Mode Switcher Tabs (Shipping Barcode vs Warehouse Manifest) -->
        <div style="display:flex; gap:6px; padding:0 18px; background:#FAF8F4; border-bottom:1.5px solid #E2DFD7;">
            <button type="button" id="tabBtnShippingLabel" onclick="window.DT_ORDER_VIEW.switchDocTab('shipping')" style="flex:1; height:30px; font-size:11px; font-weight:800; border-radius:6px 6px 0 0; border:1px solid #D4AF37; border-bottom:none; cursor:pointer; background:#FFFFFF; color:#8A681F; display:flex; align-items:center; justify-content:center; gap:5px;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                <span>4×6 Courier Shipping Label</span>
            </button>
            <button type="button" id="tabBtnPackingSlip" onclick="window.DT_ORDER_VIEW.switchDocTab('packing')" style="flex:1; height:30px; font-size:11px; font-weight:700; border-radius:6px 6px 0 0; border:1px solid #CBD5E1; border-bottom:none; cursor:pointer; background:#F1F5F9; color:#64748B; display:flex; align-items:center; justify-content:center; gap:5px;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                <span>Warehouse Packing Manifest</span>
            </button>
        </div>

        <!-- Modal Scrollable Content -->
        <div id="shippingLabelModalBody" style="flex:1; overflow-y:auto; padding:18px 20px; font-size:12px; color:#181512; background:#FFFFFF;">
            <!-- Loaded dynamically by JS -->
        </div>

        <!-- Modal Footer -->
        <div style="padding:12px 18px; background:#FAF8F4; border-top:1.5px solid #E2DFD7; display:flex; justify-content:space-between; align-items:center; flex-shrink:0; flex-wrap:wrap; gap:8px;">
            <div id="shippingLabelFooterNote" style="font-size:11px; color:#64748B;">Official Courier AWB Barcode • 4×6 Standard Label</div>
            <div style="display:flex; gap:8px; align-items:center;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_VIEW.closeShippingLabelModal()" style="height:34px; padding:0 12px; font-size:11.5px;">✕ Close</button>
                <button type="button" id="shippingLabelDirectPrintBtn" class="dt-btn dt-btn-gold" onclick="window.DT_ORDER_VIEW.printShippingLabelDirect()" style="height:34px; padding:0 16px; font-size:11.5px; font-weight:800;" title="Direct Print Label">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.3"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    <span id="shippingLabelDirectPrintBtnText">Print 4×6 Label</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ══ Edit Order Delivery & Billing Addresses Modal (Luxury Redesign) ══ -->
<div id="orderAddressEditModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.65); z-index:999999; backdrop-filter:blur(4px); align-items:center; justify-content:center;" onclick="if(event.target===this)window.DT_ORDER_VIEW.closeAddressEditModal()">
    <div style="background:#FFFFFF; border:1.5px solid #D4AF37; border-radius:12px; width:95%; max-width:640px; max-height:90vh; box-shadow:0 16px 48px rgba(0,0,0,0.35); display:flex; flex-direction:column; overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif;">
        <!-- Fixed Modal Header -->
        <div style="padding:14px 20px; background:#FAF8F4; border-bottom:1.5px solid #E2DFD7; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:34px; height:34px; border-radius:8px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; box-shadow:0 2px 6px rgba(212,175,55,0.2); flex-shrink:0;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                </div>
                <div>
                    <h3 style="margin:0; font-size:14px; font-weight:800; color:#181512;">Edit Shipping &amp; Billing Addresses</h3>
                    <p style="margin:2px 0 0 0; font-size:11px; color:#64748B;">Consignment Destination • Order <strong id="editAddressModalOrderIdText" style="color:#8A681F; font-weight:800;">DTB-001620</strong></p>
                </div>
            </div>
            <button type="button" onclick="window.DT_ORDER_VIEW.closeAddressEditModal()" style="width:28px; height:28px; border-radius:6px; border:1px solid #D4AF37; background:#FAF5E8; color:#8A681F; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:12px; font-weight:800; transition:all 0.15s ease;" title="Close Modal">✕</button>
        </div>

        <!-- Scrollable Form Body -->
        <div id="orderAddressEditFormScroll" style="flex:1 1 auto; overflow-y:auto; padding:16px 20px; display:flex; flex-direction:column; gap:14px; background:#FFFFFF;">
            <input type="hidden" id="editAddressOrderId" value="">

            <!-- SECTION 1: Shipping & Delivery Destination -->
            <div style="background:#FAF8F4; border:1.5px solid #E2DFD7; border-radius:8px; padding:14px 16px;">
                <div style="display:flex; align-items:center; gap:6px; margin-bottom:12px;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.3"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                    <span style="font-size:11.5px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.4px;">1. Shipping / Godown Destination</span>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:10px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:700; color:#334155; margin-bottom:4px;">Recipient / Consignee Name *</label>
                        <input type="text" id="editShippingRecipient" class="dt-input" style="width:100%; height:36px; padding:0 10px; border:1.5px solid #CBD5E1; border-radius:6px; font-size:12px; font-weight:600; box-sizing:border-box; background:#FFFFFF; outline:none;" placeholder="e.g. Kalyan Sarees Wholesale">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:700; color:#334155; margin-bottom:4px;">Contact Mobile Number *</label>
                        <input type="text" id="editShippingPhone" class="dt-input" style="width:100%; height:36px; padding:0 10px; border:1.5px solid #CBD5E1; border-radius:6px; font-size:12px; font-weight:600; box-sizing:border-box; background:#FFFFFF; outline:none;" placeholder="e.g. +91 70463 63528">
                    </div>
                </div>

                <div style="margin-bottom:10px;">
                    <label style="display:block; font-size:11px; font-weight:700; color:#334155; margin-bottom:4px;">Address Line 1 (Shop / Godown / Building) *</label>
                    <input type="text" id="editShippingLine1" class="dt-input" style="width:100%; height:36px; padding:0 10px; border:1.5px solid #CBD5E1; border-radius:6px; font-size:12px; box-sizing:border-box; background:#FFFFFF; outline:none;" placeholder="e.g. Godown 12, Sector C, Transport Nagar">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:700; color:#334155; margin-bottom:4px;">City *</label>
                        <input type="text" id="editShippingCity" class="dt-input" style="width:100%; height:36px; padding:0 10px; border:1.5px solid #CBD5E1; border-radius:6px; font-size:12px; box-sizing:border-box; background:#FFFFFF; outline:none;" placeholder="Surat">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:700; color:#334155; margin-bottom:4px;">State *</label>
                        <input type="text" id="editShippingState" class="dt-input" style="width:100%; height:36px; padding:0 10px; border:1.5px solid #CBD5E1; border-radius:6px; font-size:12px; box-sizing:border-box; background:#FFFFFF; outline:none;" placeholder="Gujarat">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:700; color:#334155; margin-bottom:4px;">Pincode *</label>
                        <input type="text" id="editShippingPincode" class="dt-input" style="width:100%; height:36px; padding:0 10px; border:1.5px solid #CBD5E1; border-radius:6px; font-size:12px; box-sizing:border-box; background:#FFFFFF; outline:none;" placeholder="395010">
                    </div>
                </div>
            </div>

            <!-- SECTION 2: GST Invoicing Billing Address -->
            <div style="background:#FAF8F4; border:1.5px solid #E2DFD7; border-radius:8px; padding:14px 16px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                    <div style="display:flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M3 21h18"></path><path d="M5 21V7l8-4v18"></path><path d="M19 21V11l-6-4"></path><path d="M9 9h1"></path><path d="M9 13h1"></path><path d="M9 17h1"></path></svg>
                        <span style="font-size:11.5px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.4px;">2. GST Invoicing Billing Address</span>
                    </div>
                    <label style="display:flex; align-items:center; gap:6px; font-size:11px; font-weight:700; color:#8A681F; cursor:pointer; user-select:none;">
                        <input type="checkbox" id="sameAsShippingCheckbox" onchange="window.DT_ORDER_VIEW.copyShippingToBilling()" style="cursor:pointer; accent-color:#8A681F;">
                        <span>Same as Shipping</span>
                    </label>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:10px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:700; color:#334155; margin-bottom:4px;">Billing Firm / Entity Name *</label>
                        <input type="text" id="editBillingFirm" class="dt-input" style="width:100%; height:36px; padding:0 10px; border:1.5px solid #CBD5E1; border-radius:6px; font-size:12px; font-weight:600; box-sizing:border-box; background:#FFFFFF; outline:none;" placeholder="e.g. Vardhman Tex Private Limited">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:700; color:#334155; margin-bottom:4px;">GSTIN (Tax ID)</label>
                        <input type="text" id="editBillingGstin" class="dt-input" style="width:100%; height:36px; padding:0 10px; border:1.5px solid #CBD5E1; border-radius:6px; font-size:12px; font-weight:700; font-family:monospace; box-sizing:border-box; background:#FFFFFF; outline:none;" placeholder="24AAECJ1928K1Z5">
                    </div>
                </div>

                <div style="margin-bottom:10px;">
                    <label style="display:block; font-size:11px; font-weight:700; color:#334155; margin-bottom:4px;">Billing Street Address *</label>
                    <input type="text" id="editBillingLine1" class="dt-input" style="width:100%; height:36px; padding:0 10px; border:1.5px solid #CBD5E1; border-radius:6px; font-size:12px; box-sizing:border-box; background:#FFFFFF; outline:none;" placeholder="e.g. Shop 42, Textile Market, Ring Road">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:10px;">
                    <div>
                        <label style="display:block; font-size:11px; font-weight:700; color:#334155; margin-bottom:4px;">City *</label>
                        <input type="text" id="editBillingCity" class="dt-input" style="width:100%; height:36px; padding:0 10px; border:1.5px solid #CBD5E1; border-radius:6px; font-size:12px; box-sizing:border-box; background:#FFFFFF; outline:none;" placeholder="Surat">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:700; color:#334155; margin-bottom:4px;">State *</label>
                        <input type="text" id="editBillingState" class="dt-input" style="width:100%; height:36px; padding:0 10px; border:1.5px solid #CBD5E1; border-radius:6px; font-size:12px; box-sizing:border-box; background:#FFFFFF; outline:none;" placeholder="Gujarat">
                    </div>
                    <div>
                        <label style="display:block; font-size:11px; font-weight:700; color:#334155; margin-bottom:4px;">Pincode *</label>
                        <input type="text" id="editBillingPincode" class="dt-input" style="width:100%; height:36px; padding:0 10px; border:1.5px solid #CBD5E1; border-radius:6px; font-size:12px; box-sizing:border-box; background:#FFFFFF; outline:none;" placeholder="395002">
                    </div>
                </div>
            </div>
        </div>

        <!-- Fixed Modal Footer -->
        <div style="padding:12px 20px; background:#FAF8F4; border-top:1.5px solid #E2DFD7; display:flex; justify-content:space-between; align-items:center; flex-shrink:0; flex-wrap:wrap; gap:8px;">
            <div style="font-size:11px; color:#64748B;">Surat Central Depot • Auto-syncs to Invoice &amp; Manifest</div>
            <div style="display:flex; gap:8px; align-items:center;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_VIEW.closeAddressEditModal()" style="height:34px; padding:0 14px; font-size:12px;">Cancel</button>
                <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_ORDER_VIEW.saveAddressChanges()" style="height:34px; padding:0 18px; font-size:12px; font-weight:800;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Save Address Changes</span>
                </button>
            </div>
        </div>
    </div>
</div>

