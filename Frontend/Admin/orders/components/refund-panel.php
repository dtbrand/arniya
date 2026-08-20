<?php
/**
 * refund-panel.php — Refund Management & Processing Modal Component
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ══ Refund Processing Modal Overlay ══ -->
<div id="refundDrawer" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); z-index:999999; backdrop-filter:blur(4px); align-items:center; justify-content:center;" onclick="if(event.target===this)window.DT_REFUNDS.closeRefundDrawer()">
    <div style="background:#FFFFFF; border:1px solid #D4AF37; border-radius:10px; width:95%; max-width:440px; box-shadow:0 8px 30px rgba(0,0,0,0.3); overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif;">
        <div style="padding:14px 18px; background:#FAF8F4; border-bottom:1px solid #E2DFD7; display:flex; align-items:center; justify-content:space-between;">
            <h3 style="margin:0; font-size:14px; font-weight:800; color:#181512; display:flex; align-items:center; gap:6px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                <span>Process Customer Refund</span>
            </h3>
            <button type="button" onclick="window.DT_REFUNDS.closeRefundDrawer()" style="border:none; background:transparent; font-size:14px; cursor:pointer; color:#64748B;">✕</button>
        </div>

        <div style="padding:16px; display:flex; flex-direction:column; gap:12px;">
            <div style="font-size:12px; color:#475569;">
                Order ID: <strong id="refundOrderIdText" style="color:#181512;">DTB-001624</strong>
            </div>

            <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:10px; font-size:11.5px; display:flex; flex-direction:column; gap:4px;">
                <div style="display:flex; justify-content:space-between;">
                    <span style="color:#64748B;">Total Paid:</span>
                    <strong id="refundMaxAmountDisplay" style="color:#181512;">₹1,12,250</strong>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="color:#64748B;">Already Refunded:</span>
                    <span style="color:#64748B;">₹0</span>
                </div>
                <div style="display:flex; justify-content:space-between; border-top:1px dashed #E2DFD7; padding-top:4px; margin-top:2px; font-weight:700; color:#15803D;">
                    <span>Refundable Limit:</span>
                    <span>100% Eligible (Full Reverse)</span>
                </div>
            </div>

            <div>
                <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:4px;">Refund Amount (₹ Valuation)</label>
                <div style="position:relative; display:flex; align-items:center;">
                    <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="12" height="12" style="position:absolute; left:10px;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                    <input type="number" id="refundAmountInput" class="dt-order-search-input" value="112250" style="height:34px; font-weight:800; font-size:13px; color:#181512; padding-left:26px; width:100%;">
                </div>
            </div>

            <div>
                <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:4px;">Payout Method</label>
                <select id="refundMethodSelect" class="dt-order-search-input" style="height:34px; font-weight:600; width:100%;">
                    <option value="Original Payment Gateway (Instant UPI / Card)">Original Payment Gateway (Instant UPI / Card)</option>
                    <option value="Direct RTGS Bank Transfer">Direct RTGS Bank Transfer (Corporate ICICI)</option>
                    <option value="Surat Saree Store Credit Voucher">Surat Saree Store Credit Voucher</option>
                    <option value="Manual Cash Settlement">Manual Cash Settlement</option>
                </select>
            </div>

            <div>
                <label style="font-size:11px; font-weight:700; color:#475569; display:block; margin-bottom:4px;">Internal Refund Reason</label>
                <input type="text" id="refundReasonInput" placeholder="e.g. Consignment returned to Surat depot intact" class="dt-order-search-input" style="height:32px; width:100%;">
            </div>
        </div>

        <div style="padding:12px 18px; background:#FAF8F4; border-top:1px solid #E2DFD7; display:flex; justify-content:flex-end; gap:8px;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_REFUNDS.closeRefundDrawer()">Cancel</button>
            <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_REFUNDS.confirmRefund()">Authorize Refund</button>
        </div>
    </div>
</div>
