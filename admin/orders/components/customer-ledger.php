<?php
/* DT admin access guard */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) { require_once $__dtg; } elseif (is_file(__DIR__ . '/../../includes/adminguard.php')) { require_once __DIR__ . '/../../includes/adminguard.php'; }

/**
 * customer-ledger.php — B2B Wholesale Customer Financial Ledger Modal
 * DT Brand's & Jai Hanuman Tex
 */
?>
<!-- ══ Customer Financial Ledger Modal ══ -->
<div id="customerLedgerModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.65); z-index:999999; backdrop-filter:blur(6px); align-items:center; justify-content:center; padding:16px;" onclick="if(event.target===this)window.DT_ORDER_VIEW.closeLedgerModal()">
    <div style="background:#FFFFFF; border:1px solid #D4AF37; border-radius:12px; width:95%; max-width:920px; max-height:92vh; display:flex; flex-direction:column; box-shadow:0 16px 48px rgba(0,0,0,0.35); overflow:hidden; font-family:'Plus Jakarta Sans', sans-serif; animation:dtModalFadeIn 0.2s ease-out;">
        
        <!-- Modal Header -->
        <div style="padding:12px 20px; background:#FAF8F4; border-bottom:1px solid #E2DFD7; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <div style="display:flex; align-items:center; gap:12px;">
                <img src="/assets/images/logo.png" onerror="this.onerror=null; this.src='/assets/images/logo.png';" alt="DT Brand's Logo" style="height:38px; width:auto; max-width:120px; object-fit:contain; display:block; flex-shrink:0;">
                <div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <h2 style="margin:0; font-size:15px; font-weight:800; color:#181512;">Customer Financial Ledger Statement</h2>
                        <span class="dt-kpi-badge up" style="font-size:9.5px; padding:1px 6px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Verified B2B Reseller</span>
                    </div>
                    <p style="margin:2px 0 0 0; font-size:11px; color:#64748B;">Surat Central Wholesale Depot • Real-Time Financial Sync</p>
                </div>
            </div>
            <button type="button" class="dt-btn dt-btn-pale dt-modal-close-btn" onclick="window.DT_ORDER_VIEW.closeLedgerModal()" style="width:30px; height:30px; border-radius:50%; padding:0; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:13px;" title="Close Ledger">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>

        <!-- Modal Content Body -->
        <div style="padding:14px 20px; display:flex; flex-direction:column; gap:12px; overflow:hidden;">
            
            <!-- Customer Profile Strip -->
            <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:8px; padding:10px 14px; display:grid; grid-template-columns:auto 1fr auto; gap:12px; align-items:center; box-shadow:0 1px 4px rgba(0,0,0,0.02); flex-shrink:0;">
                <div style="width:44px; height:44px; border-radius:50%; background:linear-gradient(135deg, #2A2010 0%, #443416 50%, #1C150B 100%); color:#FFE57F; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:16px; border:1.5px solid #D4AF37; box-shadow:0 2px 10px rgba(212,175,55,0.3); flex-shrink:0;">
                    <span id="ledgerAvatarInitials">--</span>
                </div>
                <div>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span id="ledgerCustomerName" style="font-size:14.5px; font-weight:800; color:#181512;">--</span>
                        <span id="ledgerGstinBadge" style="font-size:10px; background:#EFF6FF; border:1px solid #BFDBFE; color:#1D4ED8; font-weight:700; padding:1px 6px; border-radius:4px;">GSTIN: —</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:14px; font-size:11px; color:#64748B; margin-top:3px; flex-wrap:wrap;">
                        <span style="display:flex; align-items:center; gap:4px;">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <span id="ledgerPhoneText">—</span>
                        </span>
                        <span style="display:flex; align-items:center; gap:4px;">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            <span id="ledgerEmailText">—</span>
                        </span>
                        <span style="display:flex; align-items:center; gap:4px;">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            <span id="ledgerCityText">—</span>
                        </span>
                    </div>
                </div>
                <div>
                    <a id="ledgerWhatsAppBtn" href="https://wa.me/917046363528" target="_blank" class="dt-btn dt-btn-emerald" style="height:30px; font-size:11px; padding:0 12px; display:inline-flex; align-items:center; gap:5px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                        <span>WhatsApp Connect</span>
                    </a>
                </div>
            </div>

            <!-- 4-Card Financial Metrics Ribbon -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:10px; flex-shrink:0;">
                <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:10px 12px;">
                    <div style="font-size:9.5px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.5px;">Lifetime Business</div>
                    <div style="display:flex; align-items:center; gap:2px; font-size:16px; font-weight:800; color:#181512; margin-top:2px;">
                        <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="12" height="12" style="stroke:currentColor; fill:none; stroke-width:2.4;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        <span id="ledgerLifetimeBusiness">0.00</span>
                    </div>
                    <div id="ledgerConsignmentsCount" style="font-size:10px; color:#64748B; margin-top:1px;">0 Consignments</div>
                </div>

                <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:10px 12px;">
                    <div style="font-size:9.5px; font-weight:800; color:#15803D; text-transform:uppercase; letter-spacing:0.5px;">Total Settled</div>
                    <div style="display:flex; align-items:center; gap:2px; font-size:16px; font-weight:800; color:#15803D; margin-top:2px;">
                        <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="12" height="12" style="stroke:currentColor; fill:none; stroke-width:2.4;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        <span id="ledgerTotalSettled">0.00</span>
                    </div>
                    <div id="ledgerSettledPercent" style="font-size:10px; color:#16A34A; margin-top:1px; font-weight:700;">100% Paid / Cleared</div>
                </div>

                <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:10px 12px;">
                    <div style="font-size:9.5px; font-weight:800; color:#64748B; text-transform:uppercase; letter-spacing:0.5px;">Outstanding Balance</div>
                    <div style="display:flex; align-items:center; gap:2px; font-size:16px; font-weight:800; color:#181512; margin-top:2px;">
                        <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="12" height="12" style="stroke:currentColor; fill:none; stroke-width:2.4;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        <span id="ledgerOutstandingBalance">0.00</span>
                    </div>
                    <div id="ledgerBalanceStatus" style="font-size:10px; color:#15803D; font-weight:700; margin-top:1px;">All Invoices Settled</div>
                </div>

                <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:8px; padding:10px 12px;">
                    <div style="font-size:9.5px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.5px;">Wholesale Credit Limit</div>
                    <div style="display:flex; align-items:center; gap:2px; font-size:16px; font-weight:800; color:#8A681F; margin-top:2px;">
                        <svg class="dt-rupee-svg" viewBox="0 0 24 24" width="12" height="12" style="stroke:currentColor; fill:none; stroke-width:2.4;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                        <span id="ledgerCreditLimit">—</span>
                    </div>
                    <div style="font-size:10px; color:#64748B; margin-top:1px;">Standard B2B Term</div>
                </div>
            </div>

            <!-- Transaction Ledger Table Container with Dedicated Styled Scrollbar -->
            <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:8px; overflow:hidden; box-shadow:0 1px 4px rgba(0,0,0,0.02); display:flex; flex-direction:column;">
                
                <!-- Table Card Header -->
                <div style="padding:10px 16px; background:#FAF8F4; border-bottom:1px solid #E2DFD7; display:flex; justify-content:space-between; align-items:center; flex-shrink:0;">
                    <div style="display:flex; align-items:center; gap:6px;">
                        <span style="width:6px; height:6px; border-radius:50%; background:#15803D; display:inline-block;"></span>
                        <span style="font-size:12px; font-weight:800; color:#181512; text-transform:uppercase; letter-spacing:0.5px;">Transaction Statement Log</span>
                    </div>
                    <div style="font-size:10.5px; color:#64748B; font-weight:600;">Live Accounting Sync</div>
                </div>

                <!-- Scrollable Table Body with Fixed Sticky Header -->
                <div class="dt-ledger-table-scroll" style="max-height:220px; overflow-y:auto; overflow-x:auto; -webkit-overflow-scrolling:touch;">
                    <table style="width:100%; border-collapse:collapse; font-size:11.5px; min-width:720px;">
                        <thead style="position:sticky; top:0; z-index:10; background:#FAF8F4; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                            <tr style="border-bottom:1px solid #E2DFD7; color:#475569; font-size:10px; text-transform:uppercase; letter-spacing:0.5px;">
                                <th style="padding:9px 12px; text-align:left; background:#FAF8F4;">Date</th>
                                <th style="padding:9px 12px; text-align:left; background:#FAF8F4;">Reference / Order ID</th>
                                <th style="padding:9px 12px; text-align:left; background:#FAF8F4;">Transaction Type</th>
                                <th style="padding:9px 12px; text-align:right; background:#FAF8F4;">Debit (₹)</th>
                                <th style="padding:9px 12px; text-align:right; background:#FAF8F4;">Credit (₹)</th>
                                <th style="padding:9px 12px; text-align:right; background:#FAF8F4;">Balance (₹)</th>
                                <th style="padding:9px 12px; text-align:center; background:#FAF8F4;">Status</th>
                            </tr>
                        </thead>
                        <tbody id="customerLedgerTableBody">
                            <tr id="ledgerEmptyRow">
                                <td colspan="7" style="padding:24px; text-align:center; color:#64748B;">No ledger transactions loaded.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Modal Footer -->
        <div class="dt-ledger-modal-footer" style="padding:12px 20px; background:#FAF8F4; border-top:1px solid #E2DFD7; display:flex; justify-content:space-between; align-items:center; flex-shrink:0;">
            <div style="display:flex; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_VIEW.printLedger()" style="height:32px; font-size:11px;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    <span>Print Ledger</span>
                </button>
                <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_VIEW.exportLedgerCSV()" style="height:32px; font-size:11px;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Export Excel (.xls)</span>
                </button>
                <a id="ledgerFullPageLink" href="/admin/orders/ledger.php?id=<?php echo urlencode($order['id'] ?? ''); ?>" target="_blank" class="dt-btn dt-btn-pale" style="height:32px; font-size:11px; text-decoration:none;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                    <span>Full Ledger Page</span>
                </a>
            </div>
            <button type="button" class="dt-btn dt-btn-gold" onclick="window.DT_ORDER_VIEW.closeLedgerModal()" style="height:32px; font-size:11px; padding:0 20px;">
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

/* ════ DEDICATED LUXURY TABLE SCROLLBAR ════ */
.dt-ledger-table-scroll {
    scrollbar-width: thin;
    scrollbar-color: #D4AF37 #FAF8F4;
}
.dt-ledger-table-scroll::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
.dt-ledger-table-scroll::-webkit-scrollbar-track {
    background: #FAF8F4;
    border-radius: 4px;
}
.dt-ledger-table-scroll::-webkit-scrollbar-thumb {
    background: #D4AF37;
    border-radius: 4px;
}
.dt-ledger-table-scroll::-webkit-scrollbar-thumb:hover {
    background: #8A681F;
}

/* ════ PRINT STYLES FOR FINANCIAL LEDGER ════ */
@media print {
    body.is-printing-ledger .adm-layout > *:not(.adm-main),
    body.is-printing-ledger .adm-sidebar,
    body.is-printing-ledger .adm-header,
    body.is-printing-ledger .adm-footer,
    body.is-printing-ledger .dt-order-header,
    body.is-printing-ledger .dt-stepper-wrap,
    body.is-printing-ledger .dt-view-grid,
    body.is-printing-ledger .dt-doc-actions-bar,
    body.is-printing-ledger #orderActionsDrawer,
    body.is-printing-ledger #refundDrawer,
    body.is-printing-ledger .dt-ledger-modal-footer,
    body.is-printing-ledger button {
        display: none !important;
    }

    body.is-printing-ledger {
        background: #FFFFFF !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    body.is-printing-ledger #customerLedgerModal {
        display: block !important;
        position: static !important;
        background: transparent !important;
        backdrop-filter: none !important;
        padding: 0 !important;
        margin: 0 !important;
        z-index: 99999999 !important;
        box-shadow: none !important;
        width: 100% !important;
        max-width: 100% !important;
    }

    body.is-printing-ledger #customerLedgerModal > div {
        border: 1.5px solid #8A681F !important;
        border-radius: 6px !important;
        box-shadow: none !important;
        max-width: 100% !important;
        width: 100% !important;
        max-height: none !important;
        overflow: visible !important;
    }

    body.is-printing-ledger .dt-ledger-table-scroll {
        max-height: none !important;
        overflow: visible !important;
    }
}
</style>
