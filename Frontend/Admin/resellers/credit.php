<?php
/**
 * credit.php — DT Brand's & Jai Hanuman Tex
 * Reseller Credit & Wallet Management Hub
 */
$page_title = "Reseller Credit & Wallet Hub";
$active_nav = "resellers";
$active_subnav = "credit";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit &amp; Wallet Hub - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/resellers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/reseller-credit.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/resellers/assets/css/reseller-list.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 18px 20px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="dt-customers-container" style="display:flex; flex-direction:column; gap:16px; margin-bottom:24px;">
                <!-- ══ TOP HEADER ══ -->
                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:4px;">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span>Reseller Credit &amp; Wallet Ledger</span>
                            <span class="dt-cust-badge gold" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:800;">₹1.50 Lakh Limit</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Manage revolving credit limits, track order debits, wallet balance top-ups, and adjustment history.</p>
                    </div>
                    <div class="dt-cust-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="/Frontend/Admin/resellers/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            <span>Back to Resellers</span>
                        </a>
                        <button type="button" class="dt-btn dt-btn-gold" onclick="openRecordSettlementModal('RES-1048', 65000)">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>Record Settlement</span>
                        </button>
                    </div>
                </div>

                <!-- ══ CREDIT COMPONENT ══ -->
                <?php include_once __DIR__ . '/components/reseller-credit.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     INTERACTIVE MODALS FOR CREDIT HUB
══════════════════════════════════════════════════════════════ -->

<!-- 1. Adjust Sanctioned Credit Limit Modal -->
<div id="dtCreditAdjustmentModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; width:95%; max-width:500px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Adjust Sanctioned Credit Limit</strong>
            </div>
            <button type="button" onclick="closeCreditModal('dtCreditAdjustmentModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <form onsubmit="submitCreditAdjustment(event)">
            <input type="hidden" id="adjustResellerId">
            <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div style="background:#FAF8F4; padding:10px 12px; border-radius:8px; border:1px solid #EAE5D9;">
                        <span style="font-size:0.7rem; color:#78716C; font-weight:700; display:block;">CURRENT SANCTIONED:</span>
                        <strong id="adjustCurrentLimitDisplay" style="font-size:1.1rem; color:#181512; font-weight:900;">₹1,50,000</strong>
                    </div>
                    <div style="background:#FAF8F4; padding:10px 12px; border-radius:8px; border:1px solid #EAE5D9;">
                        <span style="font-size:0.7rem; color:#78716C; font-weight:700; display:block;">CURRENT UTILIZED:</span>
                        <strong id="adjustCurrentUtilizedDisplay" style="font-size:1.1rem; color:#8A681F; font-weight:900;">₹65,000</strong>
                    </div>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">New Sanctioned Limit (₹) *</label>
                    <input type="number" id="adjustNewLimitInput" class="dt-cust-search-input" style="width:100%; height:38px; font-weight:800; font-size:0.95rem;" min="10000" step="5000" required>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Adjustment Reason / Authorization Note *</label>
                    <input type="text" id="adjustReasonInput" class="dt-cust-search-input" style="width:100%; height:38px;" placeholder="e.g. Diwali Season Credit Expansion / Director Approval" required>
                </div>
            </div>

            <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeCreditModal('dtCreditAdjustmentModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Update Sanctioned Limit</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Record Payment / Settlement Modal -->
<div id="dtRecordSettlementModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #15803D; border-radius:14px; width:95%; max-width:500px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#15803D" stroke-width="2.4"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Record Credit Payment / Settlement</strong>
            </div>
            <button type="button" onclick="closeCreditModal('dtRecordSettlementModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <form onsubmit="submitRecordSettlement(event)">
            <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
                <div style="background:#FAF8F4; padding:10px 12px; border-radius:8px; border:1px solid #EAE5D9;">
                    <span style="font-size:0.7rem; color:#78716C; font-weight:700; display:block;">OUTSTANDING DUE (UTILIZED):</span>
                    <strong id="settleCurrentDueDisplay" style="font-size:1.2rem; color:#DC2626; font-weight:900;">₹65,000</strong>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Settlement Amount (₹) *</label>
                        <input type="number" id="settleAmountInput" class="dt-cust-search-input" style="width:100%; height:38px; font-weight:800; font-size:0.95rem; color:#15803D;" min="500" step="500" required>
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Payment Channel</label>
                        <select id="settleModeSelect" class="dt-cust-select" style="width:100%; height:38px; border-radius:8px;">
                            <option value="NEFT/RTGS">Bank NEFT / RTGS</option>
                            <option value="UPI">Direct UPI Transfer</option>
                            <option value="Cheque">Cheque Clearance</option>
                            <option value="Cash">Cash at Surat Hub</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Bank UTR / Transaction Reference *</label>
                    <input type="text" id="settleUtrInput" class="dt-cust-search-input" style="width:100%; height:38px; font-family:monospace;" placeholder="e.g. ICIC0098241029" required>
                </div>
            </div>

            <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeCreditModal('dtRecordSettlementModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-emerald">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#FFFFFF" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Credit to Reseller Ledger</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 3. Digital Audit Voucher Modal -->
<div id="dtVoucherModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; width:95%; max-width:460px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Digital Credit Ledger Voucher</strong>
            </div>
            <button type="button" onclick="closeCreditModal('dtVoucherModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <div class="dt-modal-body" style="padding:20px; display:flex; flex-direction:column; gap:12px; background:#FAF8F4;">
            <div style="background:#FFFFFF; border:1.2px solid #EAE5D9; border-radius:10px; padding:16px; display:flex; flex-direction:column; gap:10px;">
                <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #F3EFE6; padding-bottom:8px;">
                    <span style="font-size:0.75rem; color:#78716C; font-weight:700;">TRANSACTION ID:</span>
                    <strong id="voucherTxnId" style="font-family:monospace; color:#8A681F; font-size:0.9rem;">TXN-8821</strong>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:0.75rem; color:#78716C; font-weight:700;">TYPE &amp; PARTICULARS:</span>
                    <span id="voucherType" style="font-weight:800; color:#181512; font-size:0.8rem; text-align:right;">Debit (Order ORD-9842)</span>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:0.75rem; color:#78716C; font-weight:700;">AMOUNT:</span>
                    <strong id="voucherAmount" style="font-size:1.1rem; color:#15803D; font-weight:900;">-₹14,800</strong>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:0.75rem; color:#78716C; font-weight:700;">DATE &amp; TIME:</span>
                    <span id="voucherDate" style="color:#78716C; font-size:0.75rem; font-weight:600;">20 Aug 2026</span>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:0.75rem; color:#78716C; font-weight:700;">REFERENCE / UTR:</span>
                    <span id="voucherRef" style="font-family:monospace; color:#181512; font-size:0.75rem; font-weight:700;">ORD-9842</span>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid #F3EFE6; padding-top:8px;">
                    <span style="font-size:0.75rem; color:#78716C; font-weight:700;">AUTHORIZED BY:</span>
                    <span id="voucherActor" style="color:#181512; font-size:0.75rem; font-weight:800;">Automated Order Checkout</span>
                </div>
            </div>

            <div style="text-align:center; font-size:0.68rem; color:#78716C; font-weight:600;">
                🔒 Digitally Signed &amp; Audited by DT Brand's &amp; Jai Hanuman Tex Compliance Gateway
            </div>
        </div>

        <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="closeCreditModal('dtVoucherModal')">Close</button>
            <button type="button" class="dt-btn dt-btn-gold" onclick="window.print()">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                <span>Print Voucher</span>
            </button>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/components/reseller-status.php'; ?>
<script src="/Frontend/Admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/resellers/assets/js/reseller-credit.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/resellers/assets/js/reseller-status.js?v=<?php echo time(); ?>"></script>
</body>
</html>
