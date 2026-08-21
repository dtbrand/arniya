<?php
/**
 * refund-panel.php — Refund Management & Processing Modal Component
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ══ View Refund Details Modal Overlay ══ -->
<div id="viewRefundModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.65); z-index:999999; backdrop-filter:blur(4px); align-items:center; justify-content:center;" onclick="if(event.target===this)window.DT_REFUNDS.closeViewRefundModal()">
    <div style="background:#FFFFFF; border:1.5px solid #D4AF37; border-radius:12px; width:95%; max-width:680px; max-height:90vh; box-shadow:0 12px 40px rgba(0,0,0,0.32); display:flex; flex-direction:column; overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif;">
        <!-- Modal Header -->
        <div style="padding:14px 20px; background:#FAF8F4; border-bottom:1.5px solid #E2DFD7; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:30px; height:30px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center;">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <div>
                    <h3 style="margin:0; font-size:14px; font-weight:800; color:#181512;">Refund Voucher &amp; Credit Settlement</h3>
                    <p style="margin:2px 0 0 0; font-size:11px; color:#64748B;">Surat Central Depot • Voucher <strong id="viewRefundIdText" style="color:#8A681F;">REF-4012</strong></p>
                </div>
            </div>
        </div>

        <!-- Modal Body Content -->
        <div id="viewRefundModalBody" style="padding:18px 20px; overflow-y:auto; display:flex; flex-direction:column; gap:14px; font-size:12px; color:#181512;">
            <!-- Loaded dynamically by JS -->
        </div>

        <!-- Modal Footer -->
        <div style="padding:12px 20px; background:#FAF8F4; border-top:1.5px solid #E2DFD7; display:flex; justify-content:space-between; align-items:center; flex-shrink:0; flex-wrap:wrap; gap:8px;">
            <div style="font-size:11px; color:#64748B;">GSTIN: 24AAECJ1928K1Z5 • 100% Verified Ledger</div>
            <div style="display:flex; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_REFUNDS.closeViewRefundModal()" style="height:32px; padding:0 12px; font-size:11.5px;">✕ Close</button>
                <button type="button" id="viewRefundWhatsAppBtn" class="dt-btn" style="background:#DCFCE7; border:1px solid #86EFAC; color:#15803D; height:32px; padding:0 12px; font-size:11.5px; font-weight:700;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="#15803D"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
                    <span>WhatsApp Slip</span>
                </button>
                <button type="button" id="viewRefundDownloadBtn" class="dt-btn dt-btn-gold" style="height:32px; padding:0 14px; font-size:11.5px; font-weight:800;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Download Voucher</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ══ Refund Processing Modal Overlay ══ -->
<div id="refundDrawer" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.65); z-index:999999; backdrop-filter:blur(4px); align-items:center; justify-content:center;" onclick="if(event.target===this)window.DT_REFUNDS.closeRefundDrawer()">
    <div style="background:#FFFFFF; border:1.5px solid #D4AF37; border-radius:12px; width:95%; max-width:480px; box-shadow:0 12px 40px rgba(0,0,0,0.32); overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif;">
        <div style="padding:14px 20px; background:#FAF8F4; border-bottom:1.5px solid #E2DFD7; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:30px; height:30px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center;">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                </div>
                <div>
                    <h3 style="margin:0; font-size:14px; font-weight:800; color:#181512;">Issue Customer Refund / Credit Note</h3>
                    <p style="margin:2px 0 0 0; font-size:11px; color:#64748B;">Surat Central Depot • Order <strong id="refundOrderIdText" style="color:#8A681F;">DTB-001624</strong></p>
                </div>
            </div>
        </div>

        <div style="padding:18px 20px; display:flex; flex-direction:column; gap:12px; font-size:12px;">
            <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:12px; font-size:11.5px; display:flex; flex-direction:column; gap:5px;">
                <div style="display:flex; justify-content:space-between;">
                    <span style="color:#64748B;">Original Paid Amount:</span>
                    <strong id="refundMaxAmountDisplay" style="color:#181512;">₹1,12,250</strong>
                </div>
                <div style="display:flex; justify-content:space-between;">
                    <span style="color:#64748B;">Previous Refunds:</span>
                    <span style="color:#64748B;">₹0</span>
                </div>
                <div style="display:flex; justify-content:space-between; border-top:1px dashed #E2DFD7; padding-top:5px; margin-top:2px; font-weight:750; color:#15803D;">
                    <span>Eligibility:</span>
                    <span>100% Eligible (Verified QC Return)</span>
                </div>
            </div>

            <div>
                <label style="font-size:11.5px; font-weight:750; color:#181512; display:block; margin-bottom:4px;">Refund Valuation (₹ INR)</label>
                <div style="position:relative; display:flex; align-items:center;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.4" style="position:absolute; left:10px;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                    <input type="number" id="refundAmountInput" class="dt-order-search-input" value="14940" style="height:36px; font-weight:800; font-size:13px; color:#181512; padding-left:28px; width:100%; border-radius:6px;">
                </div>
            </div>

            <div>
                <label style="font-size:11.5px; font-weight:750; color:#181512; display:block; margin-bottom:4px;">Payout Channel</label>
                <select id="refundMethodSelect" class="dt-order-search-input" style="height:36px; font-weight:700; border-radius:6px;">
                    <option value="Direct RTGS Bank Transfer">Direct RTGS Bank Transfer (Corporate ICICI)</option>
                    <option value="UPI Reversal (PhonePe/GPay)">UPI Reversal (PhonePe/GPay Instant)</option>
                    <option value="B2B Wholesale Credit Ledger">B2B Wholesale Credit Ledger Voucher</option>
                    <option value="Razorpay Instant Reversal">Razorpay Payment Gateway Reversal</option>
                </select>
            </div>

            <div>
                <label style="font-size:11.5px; font-weight:750; color:#181512; display:block; margin-bottom:4px;">Internal Remarks / QC Reference</label>
                <input type="text" id="refundReasonInput" placeholder="e.g. Consignment returned to Surat depot intact" value="Consignment returned to Surat depot intact and passed QC" class="dt-order-search-input" style="height:36px; border-radius:6px;">
            </div>
        </div>

        <div style="padding:12px 20px; background:#FAF8F4; border-top:1.5px solid #E2DFD7; display:flex; justify-content:flex-end; gap:8px;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_REFUNDS.closeRefundDrawer()" style="height:34px; padding:0 14px; font-size:11.5px;">✕ Cancel</button>
            <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_REFUNDS.confirmRefund()" style="height:34px; padding:0 16px; font-size:11.5px; font-weight:800; display:inline-flex; align-items:center; gap:5px;">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.4"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Authorize &amp; Issue</span>
            </button>
        </div>
    </div>
</div>

