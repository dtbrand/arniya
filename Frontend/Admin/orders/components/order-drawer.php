<?php
/**
 * order-drawer.php — Smart Slide-Out Quick View Drawer for Order Inspection
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ══ Slide-Out Quick View Order Drawer ══ -->
<div id="orderQuickViewDrawer" class="dt-modal-overlay" style="display:none; justify-content:flex-end; align-items:stretch; padding:0; background:rgba(24, 21, 18, 0.45);" onclick="if(event.target===this)window.DT_ORDER_VIEW.closeDrawer()">
    <div style="width:100%; max-width:480px; height:100vh; background:#FFFFFF; box-shadow:-6px 0 24px rgba(0,0,0,0.15); display:flex; flex-direction:column; animation:dtSlideInRight 0.25s cubic-bezier(0.4, 0, 0.2, 1); box-sizing:border-box;">
        
        <!-- Drawer Header -->
        <div style="padding:14px 18px; border-bottom:1px solid #E2DFD7; background:#FAF8F4; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:30px; height:30px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </div>
                <div>
                    <h3 id="drawerOrderId" style="margin:0; font-size:14px; font-weight:800; color:#181512; display:flex; align-items:center; gap:6px;">
                        <span>DTB-001624</span>
                    </h3>
                    <p id="drawerOrderDate" style="margin:0; font-size:10.5px; color:#64748B;">21 Aug 2026, 11:20 AM</p>
                </div>
            </div>
            <div style="display:flex; align-items:center; gap:6px;">
                <span id="drawerStatusBadge" class="dt-status-badge shipped">Shipped</span>
                <button type="button" class="dt-action-btn" onclick="window.DT_ORDER_VIEW.closeDrawer()" style="width:28px; height:28px; border-radius:50%;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
        </div>

        <!-- Drawer Body (Scrollable) -->
        <div style="flex:1; overflow-y:auto; padding:16px 18px; display:flex; flex-direction:column; gap:14px;">
            
            <!-- Quick Action Bar -->
            <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap; background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:8px 10px;">
                <a id="drawerInvoiceLink" href="#" target="_blank" class="dt-btn dt-btn-emerald" style="height:28px; font-size:10.5px; padding:0 10px;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    <span>Tax Invoice</span>
                </a>
                <a id="drawerWhatsAppLink" href="#" target="_blank" class="dt-btn dt-btn-emerald" style="height:28px; font-size:10.5px; padding:0 10px; background:#25D366; border-color:#1EBE5D;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    <span>WhatsApp</span>
                </a>
                <a id="drawerViewFullLink" href="#" class="dt-btn dt-btn-pale" style="height:28px; font-size:10.5px; padding:0 10px;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    <span>Full Details Page</span>
                </a>
            </div>

            <!-- Customer Card -->
            <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:8px; padding:12px 14px;">
                <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:6px;">Customer &amp; Dispatch Account</div>
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <div id="drawerCustomerName" style="font-size:13px; font-weight:800; color:#0F172A;">Rajesh Kumar (Vardhman Tex)</div>
                        <div id="drawerCustomerPhone" style="font-size:11px; color:#64748B; margin-top:2px;">+91 98220 19283</div>
                        <div id="drawerCustomerEmail" style="font-size:10.5px; color:#94A3B8;">rajesh@vardhmantex.com</div>
                    </div>
                    <span id="drawerCustomerType" class="dt-kpi-badge up" style="font-size:10px;">Wholesale B2B</span>
                </div>
            </div>

            <!-- Shipping & Depot Details -->
            <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:8px; padding:12px 14px;">
                <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:6px;">Logistics &amp; Delivery Destination</div>
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <div style="display:flex; justify-content:space-between; font-size:11.5px;">
                        <span style="color:#64748B;">Carrier:</span>
                        <span id="drawerCarrier" style="font-weight:700; color:#0F172A;">VRL Logistics (Surat Central)</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; font-size:11.5px;">
                        <span style="color:#64748B;">Tracking AWB:</span>
                        <span id="drawerTracking" style="font-weight:800; color:#1D4ED8; font-family:monospace; background:#EFF6FF; padding:1px 6px; border-radius:4px;">VRL-SURAT-99821</span>
                    </div>
                    <div style="font-size:11px; color:#334155; border-top:1px dashed #E2E8F0; padding-top:6px; margin-top:2px;">
                        <strong>Delivery Address:</strong>
                        <div id="drawerShippingAddress" style="color:#64748B; margin-top:2px; line-height:1.4;">Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002</div>
                    </div>
                </div>
            </div>

            <!-- Order Items Manifest -->
            <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:8px; padding:12px 14px;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.04em;">Order Items (<span id="drawerItemsCount">25</span>)</div>
                    <span id="drawerItemsTotal" style="font-size:12px; font-weight:800; color:#181512;">₹1,12,250</span>
                </div>
                <div id="drawerItemsList" style="display:flex; flex-direction:column; gap:8px;">
                    <!-- Items rendered dynamically -->
                </div>
            </div>

            <!-- Payment Summary -->
            <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:12px 14px;">
                <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:6px;">Payment Breakdown</div>
                <div style="display:flex; flex-direction:column; gap:4px; font-size:11px;">
                    <div style="display:flex; justify-content:space-between; color:#64748B;">
                        <span>Payment Method:</span>
                        <span id="drawerPayMethod" style="font-weight:700; color:#0F172A;">Bank Wire / RTGS</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; color:#64748B;">
                        <span>Payment Status:</span>
                        <span id="drawerPayStatus" class="dt-pay-badge paid">PAID</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; color:#64748B;">
                        <span>Transaction Ref / UTR:</span>
                        <span id="drawerPayRef" style="font-family:monospace; color:#0F172A;">UTR-9821039812</span>
                    </div>
                    <div style="border-top:1px solid #E2DFD7; margin-top:4px; padding-top:6px; display:flex; justify-content:space-between; font-size:12.5px; font-weight:800; color:#181512;">
                        <span>Total Payable (incl. 5% GST):</span>
                        <span id="drawerPayTotal" style="color:#8A681F;">₹1,12,250</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Drawer Footer -->
        <div style="padding:12px 18px; border-top:1px solid #E2DFD7; background:#FAF8F4; display:flex; align-items:center; justify-content:space-between; gap:8px;">
            <button type="button" class="dt-btn dt-btn-dark" onclick="window.DT_ORDER_VIEW.closeDrawer()" style="flex:1;">Close Drawer</button>
            <button type="button" id="drawerUpdateStatusBtn" class="dt-btn dt-btn-gold" style="flex:1;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                <span>Update Status</span>
            </button>
        </div>

    </div>
</div>

<style>
@keyframes dtSlideInRight {
    from { transform: translateX(100%); }
    to { transform: translateX(0); }
}
</style>
