<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * commissions.php — DT Brand's & Jai Hanuman Tex
 * Reseller Commissions & Weekly Settlement Hub
 */
$page_title = "Commissions & Payouts Hub";
$active_nav = "resellers";
$active_subnav = "commissions";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commissions &amp; Payouts - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/resellers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/reseller-commission.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/resellers/assets/css/reseller-list.css?v=<?php echo time(); ?>">
    <!-- html2canvas and jsPDF for High-DPI 1:1 PDF Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
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
                            <span>Commissions &amp; Payout Settlements</span>
                            <span class="dt-cust-badge emerald" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#DCFCE7; color:#15803D; border:1px solid #86EFAC; font-weight:800;">₹42,500 Disbursed</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Manage weekly payout releases, approve payout batches via ICICI Penny Drop, and download settlement reports.</p>
                    </div>
                    <div class="dt-cust-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="/admin/resellers/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            <span>Back to Resellers</span>
                        </a>
                        <button type="button" class="dt-btn dt-btn-gold" onclick="openBatchDisburseModal()">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>Disburse Weekly Payouts</span>
                        </button>
                    </div>
                </div>

                <!-- ══ COMMISSION COMPONENT ══ -->
                <?php include_once __DIR__ . '/components/reseller-commission.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     INTERACTIVE MODALS FOR COMMISSIONS HUB
══════════════════════════════════════════════════════════════ -->

<!-- 1. Individual Settle Commission Modal -->
<div id="dtSettleCommissionModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #15803D; border-radius:14px; width:95%; max-width:500px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#15803D" stroke-width="2.4"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Approve &amp; Settle Commission Payout</strong>
            </div>
            <button type="button" onclick="closeCommModal('dtSettleCommissionModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <form onsubmit="submitSettleCommission(event)">
            <input type="hidden" id="settleCommId">
            <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
                <div style="background:#FAF8F4; padding:12px; border-radius:8px; border:1px solid #EAE5D9; display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                    <div>
                        <span style="font-size:0.7rem; color:#78716C; font-weight:700;">COMMISSION RECORD:</span>
                        <strong id="settleCommIdDisplay" style="font-family:monospace; color:#8A681F; font-size:0.95rem; display:block;">COMM-3041</strong>
                        <small id="settleOrderDisplay" style="color:#78716C; font-size:0.7rem;">Order: ORD-9842</small>
                    </div>
                    <div style="text-align:right;">
                        <span style="font-size:0.7rem; color:#78716C; font-weight:700;">PAYOUT AMOUNT:</span>
                        <strong id="settleAmountDisplay" style="color:#15803D; font-size:1.25rem; font-weight:900; display:block;">₹3,200</strong>
                    </div>
                </div>

                <div style="background:#EFF6FF; padding:10px 12px; border-radius:8px; border:1px solid #BFDBFE;">
                    <span style="font-size:0.7rem; color:#1D4ED8; font-weight:800; display:block;">BENEFICIARY BANK DETAILS (VERIFIED KYC):</span>
                    <strong style="font-size:0.82rem; color:#181512; display:block; margin-top:2px;">Arniya Silk Heritage (ICICI Bank)</strong>
                    <div style="font-family:monospace; font-size:0.74rem; color:#3B82F6;">A/C: 002105018291 • IFSC: ICIC0000021</div>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Bank Settlement Reference / UTR Number *</label>
                    <input type="text" id="settleUtrInput" class="dt-cust-search-input" style="width:100%; height:38px; font-family:monospace;" placeholder="e.g. NEFT998241029" required>
                </div>
            </div>

            <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeCommModal('dtSettleCommissionModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-emerald">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#FFFFFF" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Confirm Bank Transfer</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Disburse Weekly Batch Modal -->
<div id="dtDisburseBatchModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; width:95%; max-width:480px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Weekly Payout Batch Disbursement</strong>
            </div>
            <button type="button" onclick="closeCommModal('dtDisburseBatchModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
            <p style="font-size:0.85rem; color:#181512; margin:0; line-height:1.5;">
                Disburse all pending weekly affiliate &amp; dropship commission payouts via automated ICICI Payout Gateway?
            </p>
            <div style="background:#FAF8F4; padding:12px; border-radius:8px; border:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <span style="font-size:0.7rem; color:#78716C; font-weight:700;">TOTAL PENDING BATCH:</span>
                    <strong style="font-size:1.15rem; color:#15803D; display:block; font-weight:900;">₹3,200 (1 Payout)</strong>
                </div>
                <span class="dt-reseller-badge gold" style="font-size:0.72rem; font-weight:800;">✓ Automated NEFT</span>
            </div>
        </div>

        <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="closeCommModal('dtDisburseBatchModal')">Cancel</button>
            <button type="button" class="dt-btn dt-btn-gold" onclick="executeBatchDisbursement()">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Approve &amp; Disburse Batch</span>
            </button>
        </div>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     3. NEXT-LEVEL CERTIFIED PAYOUT ADVICE MODAL
══════════════════════════════════════════════════════════════ -->
<div id="dtPayoutAdviceModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(6px); padding:16px;">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; width:95%; max-width:580px; box-shadow:0 24px 60px rgba(0,0,0,0.45); overflow:hidden; max-height:92vh; display:flex; flex-direction:column;">
        
        <div class="dt-modal-head" style="padding:12px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Official Commission Settlement Advice</strong>
            </div>
            <button type="button" onclick="closeCommModal('dtPayoutAdviceModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <div class="dt-modal-body" style="padding:14px 16px; overflow-y:auto; background:#FAF8F4; flex:1;">
            <!-- ══ PRINTABLE ADVICE BOX ══ -->
            <div id="dtPrintableAdvice" class="dt-advice-card">
                
                <!-- Advice Header Strip -->
                <div class="dt-advice-header">
                    <div>
                        <div style="font-size:0.65rem; color:#FFE57F; font-weight:800; text-transform:uppercase; letter-spacing:0.05em;">DT BRAND'S &amp; JAI HANUMAN TEX</div>
                        <h4 style="font-size:1.05rem; font-weight:900; color:#FFFFFF; margin:2px 0 0 0;">Commission Settlement Advice</h4>
                        <small style="font-size:0.68rem; color:#F5ECCE;">ISO 9001:2015 B2B Wholesale Affiliate Payout Division</small>
                    </div>
                    <div style="text-align:right;">
                        <span class="dt-reseller-badge emerald" style="font-size:0.68rem; font-weight:800;">
                            ✓ PAID &amp; SETTLED
                        </span>
                        <div id="adviceCommId" style="font-family:monospace; color:#FFE57F; font-size:0.85rem; font-weight:800; margin-top:4px;">COMM-3028</div>
                    </div>
                </div>

                <!-- Reseller Details -->
                <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:10px 14px; display:grid; grid-template-columns:1fr 1fr; gap:8px; font-size:0.75rem;">
                    <div>
                        <span style="color:#78716C; font-weight:600; display:block;">Beneficiary Partner:</span>
                        <strong style="color:#181512; font-weight:800;">Arniya Silk Heritage</strong>
                        <div style="color:#78716C; font-size:0.7rem; font-family:monospace;">ID: RES-1048 • PAN: AAAPL1234F</div>
                    </div>
                    <div style="text-align:right;">
                        <span style="color:#78716C; font-weight:600; display:block;">Disbursement Date:</span>
                        <strong id="adviceDate" style="color:#181512; font-weight:800;">18 Aug 2026</strong>
                        <div style="color:#15803D; font-weight:800; font-size:0.7rem;">✓ Bank Settled</div>
                    </div>
                </div>

                <!-- Particulars Breakdown -->
                <div style="background:#FFFFFF; border:1px solid #EAE5D9; border-radius:8px; padding:12px 14px; display:flex; flex-direction:column; gap:8px; font-size:0.78rem;">
                    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px dashed #F1ECE1; padding-bottom:6px;">
                        <span style="color:#78716C; font-weight:600;">Associated Saree Order:</span>
                        <strong id="adviceOrder" style="font-family:monospace; color:#1D4ED8; font-weight:800;">ORD-9831</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px dashed #F1ECE1; padding-bottom:6px;">
                        <span style="color:#78716C; font-weight:600;">Incentive Plan / Tier Bonus:</span>
                        <strong id="advicePlan" style="color:#181512; font-weight:800;">10% Tier Bonus</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#78716C; font-weight:600;">Bank Settlement Ref / UTR:</span>
                        <strong id="adviceBankRef" style="font-family:monospace; color:#8A681F; font-weight:800;">UTR #NEFT998241029</strong>
                    </div>
                </div>

                <!-- Total Amount Disbursed -->
                <div style="background:#FAF8F4; border:1.5px dashed #15803D; border-radius:10px; padding:12px 18px; display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <span style="font-size:0.7rem; color:#78716C; font-weight:800; text-transform:uppercase;">NET COMMISSION DISBURSED</span>
                        <div id="adviceAmount" style="font-size:1.6rem; font-weight:900; color:#15803D; line-height:1.1; margin-top:2px;">
                            +₹6,420
                        </div>
                    </div>
                    <div class="dt-advice-stamp">
                        <span>DT BRAND'S</span>
                        <span style="font-size:0.5rem; color:#15803D;">✓ SETTLED</span>
                        <span>FINANCE</span>
                    </div>
                </div>

                <!-- Security Hash -->
                <div style="border-top:1px solid #EAE5D9; padding-top:8px; display:flex; justify-content:space-between; align-items:center; font-size:0.68rem; color:#78716C;">
                    <span>🔒 Digital Audit Hash: <code style="font-family:monospace; color:#8A681F;">7b1e4c9f0a2d...</code></span>
                    <span>Direct Bank Credit • TDS 5% Deducted u/s 194H</span>
                </div>

            </div>
        </div>

        <div class="dt-modal-foot" style="padding:12px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="closeCommModal('dtPayoutAdviceModal')">Close</button>
            <div style="display:flex; align-items:center; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="printAdvice()">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    <span>Print Advice</span>
                </button>
                <button type="button" class="dt-btn dt-btn-gold" onclick="downloadAdvicePdf()">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Download Advice PDF</span>
                </button>
            </div>
        </div>

    </div>
</div>

<script src="/admin/resellers/assets/js/resellers.js?v=<?php echo time(); ?>"></script>
<script src="/admin/resellers/assets/js/reseller-commission.js?v=<?php echo time(); ?>"></script>
</body>
</html>
