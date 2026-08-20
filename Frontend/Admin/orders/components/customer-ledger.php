<?php
/**
 * customer-ledger.php — B2B Wholesale Customer Financial Ledger Modal
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ══ Customer Financial Ledger Modal ══ -->
<div id="customerLedgerModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.65); z-index:999999; backdrop-filter:blur(5px); align-items:center; justify-content:center; padding:16px;" onclick="if(event.target===this)window.DT_ORDER_VIEW.closeLedgerModal()">
    <div style="background:#FFFFFF; border:1px solid #D4AF37; border-radius:12px; width:100%; max-width:860px; max-height:90vh; display:flex; flex-direction:column; box-shadow:0 12px 40px rgba(0,0,0,0.35); overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif; animation:dtModalFadeIn 0.2s ease-out;">
        
        <!-- Modal Header -->
        <div style="padding:14px 20px; background:#FAF8F4; border-bottom:1px solid #E2DFD7; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:36px; height:36px; border-radius:8px; background:linear-gradient(135deg, #FAF5E8 0%, #F5EDD6 100%); border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F; box-shadow:0 2px 6px rgba(212,175,55,0.25);">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                </div>
                <div>
                    <div style="display:flex; align-items:center; gap:6px;">
                        <h2 style="margin:0; font-size:15px; font-weight:800; color:#181512;">Customer Financial Ledger Statement</h2>
                        <span class="dt-kpi-badge up" style="font-size:9.5px; padding:1px 6px;">Verified B2B Reseller</span>
                    </div>
                    <p style="margin:2px 0 0 0; font-size:11px; color:#64748B;">Account Statement • Surat Wholesale Hub</p>
                </div>
            </div>
            <button type="button" onclick="window.DT_ORDER_VIEW.closeLedgerModal()" style="width:30px; height:30px; border-radius:50%; border:1px solid #E2E8F0; background:#FFFFFF; color:#64748B; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:13px; transition:all 0.15s ease;" title="Close Ledger">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>

        <!-- Scrollable Modal Content -->
        <div style="flex:1; overflow-y:auto; padding:18px 20px; display:flex; flex-direction:column; gap:16px;">
            
            <!-- Customer Profile Strip -->
            <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:8px; padding:14px; display:grid; grid-template-columns:auto 1fr auto; gap:14px; align-items:center; box-shadow:0 1px 4px rgba(0,0,0,0.02);">
                <div style="width:48px; height:48px; border-radius:50%; background:linear-gradient(135deg, #181512 0%, #2A241E 100%); color:#D4AF37; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:16px; border:1px solid #8A681F; box-shadow:0 2px 8px rgba(0,0,0,0.15); flex-shrink:0;">
                    <span id="ledgerAvatarInitials">RA</span>
                </div>
                <div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span id="ledgerCustomerName" style="font-size:15px; font-weight:800; color:#181512;">Rajesh Kumar (Vardhman Tex)</span>
                        <span style="font-size:10px; background:#EFF6FF; border:1px solid #BFDBFE; color:#1D4ED8; font-weight:700; padding:1px 6px; border-radius:4px;">GST: 24AAECJ1928K1Z5</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:14px; font-size:11.5px; color:#64748B; margin-top:4px; flex-wrap:wrap;">
                        <span style="display:flex; align-items:center; gap:4px;">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <span id="ledgerPhoneText">+91 98220 19283</span>
                        </span>
                        <span style="display:flex; align-items:center; gap:4px;">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            <span id="ledgerEmailText">rajesh@vardhmantex.com</span>
                        </span>
                        <span style="display:flex; align-items:center; gap:4px;">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            <span>Ring Road, Surat (GJ)</span>
                        </span>
                    </div>
                </div>
                <div>
                    <a id="ledgerWhatsAppBtn" href="https://wa.me/919822019283" target="_blank" class="dt-btn dt-btn-emerald" style="height:32px; font-size:11.5px; padding:0 12px;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <span>WhatsApp Connect</span>
                    </a>
                </div>
            </div>

            <!-- 4-Card Financial Metrics Ribbon -->
            <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:10px;">
                <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:12px;">
                    <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase;">Lifetime Business</div>
                    <div style="display:flex; align-items:center; gap:2px; font-size:16px; font-weight:800; color:#181512; margin-top:4px;">
                        <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="13" height="13"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        <span>8,42,500</span>
                    </div>
                    <div style="font-size:10px; color:#64748B; margin-top:2px;">14 Consignments</div>
                </div>

                <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:12px;">
                    <div style="font-size:10px; font-weight:800; color:#15803D; text-transform:uppercase;">Total Settled</div>
                    <div style="display:flex; align-items:center; gap:2px; font-size:16px; font-weight:800; color:#15803D; margin-top:4px;">
                        <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="13" height="13"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        <span>8,42,500</span>
                    </div>
                    <div style="font-size:10px; color:#16A34A; margin-top:2px;">100% Paid / Cleared</div>
                </div>

                <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:12px;">
                    <div style="font-size:10px; font-weight:800; color:#64748B; text-transform:uppercase;">Outstanding Balance</div>
                    <div style="display:flex; align-items:center; gap:2px; font-size:16px; font-weight:800; color:#181512; margin-top:4px;">
                        <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="13" height="13"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        <span>0.00</span>
                    </div>
                    <div style="font-size:10px; color:#15803D; font-weight:700; margin-top:2px;">All Invoices Settled</div>
                </div>

                <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:12px;">
                    <div style="font-size:10px; font-weight:800; color:#8A681F; text-transform:uppercase;">Wholesale Credit Limit</div>
                    <div style="display:flex; align-items:center; gap:2px; font-size:16px; font-weight:800; color:#8A681F; margin-top:4px;">
                        <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="13" height="13"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        <span>15,00,000</span>
                    </div>
                    <div style="font-size:10px; color:#64748B; margin-top:2px;">Net 15 Days Term</div>
                </div>
            </div>

            <!-- Transaction Ledger Table -->
            <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:8px; overflow:hidden;">
                <div style="padding:10px 14px; background:#FAF8F4; border-bottom:1px solid #E2DFD7; display:flex; justify-content:space-between; align-items:center;">
                    <div style="font-size:12px; font-weight:800; color:#181512; text-transform:uppercase; letter-spacing:0.5px;">Transaction Statement Log</div>
                    <div style="font-size:10.5px; color:#64748B;">Fiscal Year 2026-27 • Live Sync</div>
                </div>

                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse; font-size:11.5px;">
                        <thead>
                            <tr style="background:#FAF8F4; border-bottom:1px solid #E2DFD7; color:#475569; font-size:10.5px; text-transform:uppercase;">
                                <th style="padding:8px 12px; text-align:left;">Date</th>
                                <th style="padding:8px 12px; text-align:left;">Reference / Order ID</th>
                                <th style="padding:8px 12px; text-align:left;">Transaction Type</th>
                                <th style="padding:8px 12px; text-align:right;">Debit (₹)</th>
                                <th style="padding:8px 12px; text-align:right;">Credit (₹)</th>
                                <th style="padding:8px 12px; text-align:right;">Balance (₹)</th>
                                <th style="padding:8px 12px; text-align:center;">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-bottom:1px solid #F1EFE9;">
                                <td style="padding:9px 12px; color:#64748B; font-size:11px;">21 Aug 2026</td>
                                <td style="padding:9px 12px;"><a href="/Frontend/Admin/orders/view.php?id=DTB-001624" style="font-weight:800; color:#8A681F; text-decoration:none;">DTB-001624</a></td>
                                <td style="padding:9px 12px; color:#181512; font-weight:600;">Consignment Invoice (Kanjivaram Silk 25pcs)</td>
                                <td style="padding:9px 12px; text-align:right; font-weight:800; color:#181512;">1,12,250</td>
                                <td style="padding:9px 12px; text-align:right; color:#94A3B8;">—</td>
                                <td style="padding:9px 12px; text-align:right; font-weight:800; color:#181512;">1,12,250</td>
                                <td style="padding:9px 12px; text-align:center;"><span class="dt-status-badge pending" style="font-size:9.5px; padding:1px 6px;">Billed</span></td>
                            </tr>
                            <tr style="border-bottom:1px solid #F1EFE9; background:#FAFBF8;">
                                <td style="padding:9px 12px; color:#64748B; font-size:11px;">21 Aug 2026</td>
                                <td style="padding:9px 12px; font-family:monospace; color:#0F172A; font-weight:700;">UTR-9821039812</td>
                                <td style="padding:9px 12px; color:#15803D; font-weight:600;">Bank Wire / RTGS Settlement</td>
                                <td style="padding:9px 12px; text-align:right; color:#94A3B8;">—</td>
                                <td style="padding:9px 12px; text-align:right; font-weight:800; color:#15803D;">1,12,250</td>
                                <td style="padding:9px 12px; text-align:right; font-weight:800; color:#15803D;">0.00</td>
                                <td style="padding:9px 12px; text-align:center;"><span class="dt-pay-badge paid" style="font-size:9.5px;">PAID</span></td>
                            </tr>
                            <tr style="border-bottom:1px solid #F1EFE9;">
                                <td style="padding:9px 12px; color:#64748B; font-size:11px;">10 Aug 2026</td>
                                <td style="padding:9px 12px;"><a href="/Frontend/Admin/orders/view.php?id=DTB-001605" style="font-weight:800; color:#8A681F; text-decoration:none;">DTB-001605</a></td>
                                <td style="padding:9px 12px; color:#181512; font-weight:600;">Banarasi Silk Lot Consignment (40pcs)</td>
                                <td style="padding:9px 12px; text-align:right; font-weight:800; color:#181512;">2,45,000</td>
                                <td style="padding:9px 12px; text-align:right; color:#94A3B8;">—</td>
                                <td style="padding:9px 12px; text-align:right; font-weight:800; color:#181512;">2,45,000</td>
                                <td style="padding:9px 12px; text-align:center;"><span class="dt-status-badge delivered" style="font-size:9.5px; padding:1px 6px;">Delivered</span></td>
                            </tr>
                            <tr style="border-bottom:1px solid #F1EFE9; background:#FAFBF8;">
                                <td style="padding:9px 12px; color:#64748B; font-size:11px;">11 Aug 2026</td>
                                <td style="padding:9px 12px; font-family:monospace; color:#0F172A; font-weight:700;">UTR-882910398</td>
                                <td style="padding:9px 12px; color:#15803D; font-weight:600;">RTGS ICICI Bank Full Settlement</td>
                                <td style="padding:9px 12px; text-align:right; color:#94A3B8;">—</td>
                                <td style="padding:9px 12px; text-align:right; font-weight:800; color:#15803D;">2,45,000</td>
                                <td style="padding:9px 12px; text-align:right; font-weight:800; color:#15803D;">0.00</td>
                                <td style="padding:9px 12px; text-align:center;"><span class="dt-pay-badge paid" style="font-size:9.5px;">PAID</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Modal Footer -->
        <div style="padding:12px 20px; background:#FAF8F4; border-top:1px solid #E2DFD7; display:flex; justify-content:space-between; align-items:center; flex-shrink:0;">
            <div style="display:flex; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="window.print()" style="height:32px; font-size:11px;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    <span>Print Ledger Statement</span>
                </button>
                <button type="button" class="dt-btn dt-btn-pale" onclick="if(window.DT_ORDERS)window.DT_ORDERS.showToast('📥 Customer ledger downloaded as CSV statement');" style="height:32px; font-size:11px;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Export CSV</span>
                </button>
            </div>
            <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_ORDER_VIEW.closeLedgerModal()" style="height:32px; font-size:11px; padding:0 18px;">
                <span>Close Ledger</span>
            </button>
        </div>

    </div>
</div>

<style>
@keyframes dtModalFadeIn {
    from { opacity: 0; transform: scale(0.96); }
    to { opacity: 1; transform: scale(1); }
}
</style>
