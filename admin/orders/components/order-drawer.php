<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * order-drawer.php — Smart Slide-Out Quick View Drawer for Order Inspection
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ══ Slide-Out Quick View Order Drawer ══ -->
<div id="orderQuickViewDrawer" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); z-index:999999; backdrop-filter:blur(4px); justify-content:flex-end; align-items:stretch;" onclick="if(event.target===this)window.DT_ORDER_VIEW.closeDrawer()">
    <div style="width:100%; max-width:520px; height:100vh; background:#FFFFFF; box-shadow:-8px 0 32px rgba(0,0,0,0.25); display:flex; flex-direction:column; animation:dtSlideInRight 0.22s cubic-bezier(0.4, 0, 0.2, 1); box-sizing:border-box; font-family:'Plus Jakarta Sans', sans-serif;">
        
        <!-- Drawer Header -->
        <div style="padding:14px 18px; border-bottom:1px solid #E2DFD7; background:#FAF8F4; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:36px; height:36px; border-radius:8px; background:linear-gradient(135deg, #FAF5E8 0%, #F5EDD6 100%); border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; box-shadow:0 2px 6px rgba(212,175,55,0.2);">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                </div>
                <div>
                    <div style="display:flex; align-items:center; gap:6px;">
                        <span id="drawerOrderId" style="font-size:15px; font-weight:800; color:#181512; letter-spacing:-0.01em;">DTB-001624</span>
                        <span id="drawerCustomerType" class="dt-kpi-badge up" style="font-size:9.5px; padding:1px 6px;">Wholesale B2B</span>
                    </div>
                    <p id="drawerOrderDate" style="margin:2px 0 0 0; font-size:11px; color:#64748B;">21 Aug 2026 • 11:20 AM</p>
                </div>
            </div>
            <div style="display:flex; align-items:center; gap:8px;">
                <span id="drawerStatusBadge" class="dt-status-badge shipped">
                    <span class="dt-status-dot"></span>
                    <span id="drawerStatusBadgeText">Shipped</span>
                </span>
                <button type="button" onclick="window.DT_ORDER_VIEW.closeDrawer()" style="width:30px; height:30px; border-radius:50%; border:1px solid #E2E8F0; background:#FFFFFF; color:#64748B; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:13px; transition:all 0.15s ease;" title="Close Drawer">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
        </div>

        <!-- Drawer Body (Scrollable) -->
        <div style="flex:1; overflow-y:auto; padding:16px 18px; display:flex; flex-direction:column; gap:12px;">
            
            <!-- Quick Action 1-Tap Row -->
            <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:6px; background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:8px;">
                <a id="drawerInvoiceLink" href="#" target="_blank" class="dt-btn dt-btn-emerald" style="height:30px; font-size:11px; padding:0 8px;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    <span>Tax Invoice</span>
                </a>
                <a id="drawerWhatsAppLink" href="#" target="_blank" class="dt-btn dt-btn-emerald" style="height:30px; font-size:11px; padding:0 8px; background:#15803D; border-color:#16A34A;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                    <span>WhatsApp</span>
                </a>
                <a id="drawerViewFullLink" href="#" class="dt-btn dt-btn-pale" style="height:30px; font-size:11px; padding:0 8px;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    <span>Full View</span>
                </a>
            </div>

            <!-- Fulfillment Progression Stepper -->
            <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:10px 12px;">
                <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:8px;">Fulfillment Stage Tracker</div>
                <div id="drawerStepper" style="display:flex; align-items:center; justify-content:space-between; font-size:9.5px; font-weight:700; color:#64748B;">
                    <div style="text-align:center; color:#15803D;">● Placed</div>
                    <div style="flex:1; height:2px; background:#16A34A; margin:0 4px;"></div>
                    <div id="stepConfirmed" style="text-align:center; color:#15803D;">● Confirmed</div>
                    <div style="flex:1; height:2px; background:#16A34A; margin:0 4px;"></div>
                    <div id="stepPacked" style="text-align:center; color:#15803D;">● Packed</div>
                    <div style="flex:1; height:2px; background:#D4AF37; margin:0 4px;"></div>
                    <div id="stepTransit" style="text-align:center; color:#8A681F;">🚚 In Transit</div>
                    <div style="flex:1; height:2px; background:#E2E8F0; margin:0 4px;"></div>
                    <div id="stepDelivered" style="text-align:center; color:#94A3B8;">○ Delivered</div>
                </div>
            </div>

            <!-- Customer Account Details -->
            <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:8px; padding:12px 14px; box-shadow:0 1px 3px rgba(0,0,0,0.02);">
                <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:8px; display:flex; justify-content:space-between; align-items:center;">
                    <span>Customer Account</span>
                    <span id="drawerCustomerChannel" style="color:#64748B; font-weight:600; font-size:9.5px;">B2B Wholesale Portal</span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <div id="drawerCustomerName" style="font-size:13px; font-weight:800; color:#0F172A;">Rajesh Kumar (Vardhman Tex)</div>
                        <div id="drawerCustomerPhone" style="font-size:11.5px; color:#475569; margin-top:2px; font-weight:600;">+91 70463 63528</div>
                        <div id="drawerCustomerEmail" style="font-size:10.5px; color:#94A3B8; margin-top:1px;">rajesh@vardhmantex.com</div>
                    </div>
                    <button type="button" onclick="if(window.DT_ORDERS)window.DT_ORDERS.copyText(document.getElementById('drawerCustomerPhone').innerText, 'Phone Number')" class="dt-btn dt-btn-pale" style="height:24px; font-size:10px; padding:0 6px;">
                        <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        <span>Copy</span>
                    </button>
                </div>
            </div>

            <!-- Dispatch & Logistics Destination -->
            <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:8px; padding:12px 14px; box-shadow:0 1px 3px rgba(0,0,0,0.02);">
                <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:8px;">Logistics &amp; Delivery Destination</div>
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <div style="display:flex; justify-content:space-between; font-size:11.5px;">
                        <span style="color:#64748B;">Carrier Courier:</span>
                        <span id="drawerCarrier" style="font-weight:700; color:#0F172A;">VRL Logistics (Surat Central)</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; font-size:11.5px;">
                        <span style="color:#64748B;">Tracking AWB:</span>
                        <div style="display:flex; align-items:center; gap:4px;">
                            <span id="drawerTracking" style="font-weight:800; color:#1D4ED8; font-family:monospace; background:#EFF6FF; border:1px solid #BFDBFE; padding:2px 8px; border-radius:4px;">VRL-SURAT-99821</span>
                            <button type="button" onclick="if(window.DT_ORDERS)window.DT_ORDERS.copyText(document.getElementById('drawerTracking').innerText, 'Tracking AWB')" class="dt-action-btn" style="width:22px; height:22px;" title="Copy AWB">
                                <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                            </button>
                        </div>
                    </div>
                    <div style="font-size:11px; color:#334155; border-top:1px dashed #E2E8F0; padding-top:6px; margin-top:2px;">
                        <div style="font-weight:700; color:#475569; margin-bottom:2px;">Godown / Delivery Destination:</div>
                        <div id="drawerShippingAddress" style="color:#64748B; line-height:1.4;">Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002</div>
                    </div>
                </div>
            </div>

            <!-- Order Items Manifest -->
            <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:8px; padding:12px 14px; box-shadow:0 1px 3px rgba(0,0,0,0.02);">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.05em;">Order Items (<span id="drawerItemsCount">25</span>)</div>
                    <div style="display:flex; align-items:center; gap:2px; font-size:12.5px; font-weight:800; color:#181512;">
                        <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="11" height="11"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        <span id="drawerItemsTotal">1,12,250</span>
                    </div>
                </div>
                <div id="drawerItemsList" style="display:flex; flex-direction:column; gap:8px;">
                    <!-- Items populated dynamically with 100% Vector SVGs -->
                </div>
            </div>

            <!-- Payment Summary -->
            <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:12px 14px;">
                <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:6px;">Payment Breakdown</div>
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
                    <div style="border-top:1px solid #E2DFD7; margin-top:4px; padding-top:6px; display:flex; justify-content:space-between; align-items:center; font-size:13px; font-weight:800; color:#181512;">
                        <span>Total Valuation (incl. 5% GST):</span>
                        <div style="display:flex; align-items:center; gap:2px; color:#8A681F;">
                            <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="12" height="12"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                            <span id="drawerPayTotal">1,12,250</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Internal Admin Quick Note Box -->
            <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:8px; padding:10px 12px;">
                <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:6px;">Internal Dispatch Note</div>
                <div style="display:flex; gap:6px;">
                    <input type="text" id="drawerQuickNoteInput" placeholder="Add warehouse or courier note..." class="dt-order-search-input" style="height:30px; font-size:11px; flex:1;">
                    <button type="button" onclick="window.DT_ORDER_VIEW.addDrawerNote()" class="dt-btn dt-btn-pale" style="height:30px; font-size:10.5px; padding:0 10px;">
                        Add Note
                    </button>
                </div>
            </div>

        </div>

        <!-- Drawer Footer -->
        <div style="padding:12px 18px; border-top:1px solid #E2DFD7; background:#FAF8F4; display:flex; align-items:center; justify-content:space-between; gap:8px; flex-shrink:0;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_VIEW.closeDrawer()" style="flex:1;">Close</button>
            <button type="button" id="drawerUpdateStatusBtn" class="dt-btn dt-btn-gold" style="flex:1.2;">
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


