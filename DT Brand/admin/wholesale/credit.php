<?php
/**
 * credit.php — DT Brand's & Jai Hanuman Tex
 * Wholesale Revolving Credit Hub & Double-Entry Ledger (100% Dynamic)
 */
$page_title = "Wholesale Credit Hub";
$active_nav = "wholesalers";
$active_subnav = "credit";

require_once __DIR__ . '/components/wholesale-data.php';

$whl_id = isset($_GET['id']) ? $_GET['id'] : null;
$wholesale = $whl_id ? getWholesalePartner($whl_id) : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $wholesale ? htmlspecialchars($wholesale['id'] . ' Credit - ' . $wholesale['name']) : 'Wholesale Credit Hub'; ?> - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/wholesale/assets/css/wholesale.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/wholesale/assets/css/wholesale-credit.css?v=<?php echo time(); ?>">
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

            <div class="dt-wholesale-container">
                <!-- Top Breadcrumb & Return Nav -->
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <a href="/admin/wholesale/index.php" class="dt-btn dt-btn-pale dt-btn-sm">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            <span>All Wholesalers</span>
                        </a>
                        <?php if ($wholesale): ?>
                            <a href="/admin/wholesale/view.php?id=<?php echo $wholesale['id']; ?>" class="dt-btn dt-btn-pale dt-btn-sm">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span>Back to <?php echo htmlspecialchars($wholesale['id']); ?> Dossier</span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <?php if ($wholesale): ?>
                        <div style="display:flex; gap:8px;">
                            <a href="/admin/wholesale/orders.php?id=<?php echo $wholesale['id']; ?>" class="dt-btn dt-btn-pale dt-btn-sm">
                                <span>View Orders</span>
                            </a>
                            <a href="/admin/wholesale/edit.php?id=<?php echo $wholesale['id']; ?>" class="dt-btn dt-btn-gold dt-btn-sm">
                                <span>Edit Profile</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:4px;">
                    <div>
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span><?php echo $wholesale ? htmlspecialchars($wholesale['name']) . ' — Credit Hub' : 'Wholesale Revolving Credit Hub'; ?></span>
                            <?php if ($wholesale): ?>
                                <span class="dt-status-pill-clean <?php echo $wholesale['tier_badge']; ?>"><?php echo $wholesale['tier_short']; ?></span>
                            <?php else: ?>
                                <span class="dt-cust-badge gold" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:800;">₹28.5L Active Facilities</span>
                            <?php endif; ?>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">
                            <?php echo $wholesale ? 'Manage revolving credit limits, record NEFT/RTGS settlements, and issue certified digital vouchers for ' . htmlspecialchars($wholesale['legal_name']) . '.' : 'Manage B2B credit limits, record NEFT/RTGS settlements, and issue certified digital vouchers.'; ?>
                        </p>
                    </div>
                </div>

                <?php include __DIR__ . '/components/wholesale-credit.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     INTERACTIVE MODALS FOR WHOLESALE CREDIT HUB
══════════════════════════════════════════════════════════════ -->

<!-- 1. Adjust Sanctioned Credit Limit Modal -->
<div id="dtCreditAdjustmentModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.65); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; width:95%; max-width:500px; box-shadow:0 20px 50px rgba(0,0,0,0.4); overflow:hidden;">
        <div class="dt-modal-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Adjust Sanctioned Credit Limit</strong>
            </div>
            <button type="button" onclick="closeWholesaleModal('dtCreditAdjustmentModal')" class="dt-drawer-close" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <form onsubmit="submitCreditAdjustment(event)">
            <input type="hidden" id="adjustWholesaleId">
            <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div style="background:#FAF8F4; padding:10px 12px; border-radius:8px; border:1px solid #EAE5D9;">
                        <span style="font-size:0.7rem; color:#78716C; font-weight:700; display:block;">CURRENT SANCTIONED:</span>
                        <strong id="adjustCurrentLimitDisplay" style="font-size:1.1rem; color:#181512; font-weight:900;">₹5,00,000</strong>
                    </div>
                    <div style="background:#FAF8F4; padding:10px 12px; border-radius:8px; border:1px solid #EAE5D9;">
                        <span style="font-size:0.7rem; color:#78716C; font-weight:700; display:block;">CURRENT UTILIZED:</span>
                        <strong id="adjustCurrentUtilizedDisplay" style="font-size:1.1rem; color:#8A681F; font-weight:900;">₹2,10,000</strong>
                    </div>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">New Sanctioned Limit (₹) *</label>
                    <input type="number" id="adjustNewLimitInput" class="dt-wholesale-input" style="width:100%; height:38px; font-weight:800; font-size:0.95rem; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; box-sizing:border-box;" min="10000" step="10000" required>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Adjustment Reason / Authorization Note *</label>
                    <input type="text" id="adjustReasonInput" class="dt-wholesale-input" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; box-sizing:border-box;" placeholder="e.g. Festival Season Wholesaler Facility Expansion" required>
                </div>
            </div>

            <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtCreditAdjustmentModal')">Cancel</button>
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
            <button type="button" onclick="closeWholesaleModal('dtRecordSettlementModal')" class="dt-drawer-close" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <form onsubmit="submitRecordSettlement(event)">
            <div class="dt-modal-body" style="padding:18px; display:flex; flex-direction:column; gap:12px;">
                <div style="background:#FAF8F4; padding:10px 12px; border-radius:8px; border:1px solid #EAE5D9;">
                    <span style="font-size:0.7rem; color:#78716C; font-weight:700; display:block;">OUTSTANDING DUE (UTILIZED):</span>
                    <strong id="settleCurrentDueDisplay" style="font-size:1.2rem; color:#DC2626; font-weight:900;">₹2,10,000</strong>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Settlement Amount (₹) *</label>
                        <input type="number" id="settleAmountInput" class="dt-wholesale-input" style="width:100%; height:38px; font-weight:800; font-size:0.95rem; color:#15803D; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; box-sizing:border-box;" min="500" step="500" required>
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Payment Channel</label>
                        <select id="settleModeSelect" class="dt-wholesale-input" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 10px; font-size:0.85rem; font-weight:700; box-sizing:border-box;">
                            <option value="NEFT/RTGS">Bank NEFT / RTGS</option>
                            <option value="UPI">Direct UPI Transfer</option>
                            <option value="Cheque">Cheque Clearance</option>
                            <option value="Cash">Cash at Surat Hub</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:6px;">Bank UTR / Transaction Reference *</label>
                    <input type="text" id="settleUtrInput" class="dt-wholesale-input" style="width:100%; height:38px; font-family:monospace; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; box-sizing:border-box;" placeholder="e.g. HDFC0098241029" required>
                </div>
            </div>

            <div class="dt-modal-foot" style="padding:14px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:flex-end; gap:8px; background:#FAF8F4;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtRecordSettlementModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-emerald">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#FFFFFF" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Credit to Wholesaler Ledger</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     3. NEXT-LEVEL CERTIFIED DIGITAL WHOLESALE CREDIT VOUCHER MODAL
══════════════════════════════════════════════════════════════ -->
<div id="dtVoucherModal" class="dt-modal-backdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(6px); padding:16px;">
    <div class="dt-modal-dialog" style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:14px; width:95%; max-width:580px; box-shadow:0 24px 60px rgba(0,0,0,0.45); overflow:hidden; max-height:92vh; display:flex; flex-direction:column;">
        
        <!-- Modal Top Bar -->
        <div class="dt-modal-head" style="padding:12px 18px; border-bottom:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Official Digital Wholesale Credit Voucher</strong>
            </div>
            <button type="button" onclick="closeWholesaleModal('dtVoucherModal')" class="dt-drawer-close" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>

        <!-- Scrollable Modal Body containing Printable Voucher Box -->
        <div class="dt-modal-body" style="padding:18px; overflow-y:auto; background:#FAF8F4; flex:1;">
            
            <!-- ══ PRINTABLE CERTIFIED VOUCHER INNER BOX ══ -->
            <div id="dtPrintableVoucher" class="dt-voucher-card">
                
                <!-- Voucher Header Strip -->
                <div class="dt-voucher-header">
                    <div>
                        <div style="font-size:0.65rem; color:#FFE57F; font-weight:800; text-transform:uppercase; letter-spacing:0.05em;">DT BRAND'S &amp; JAI HANUMAN TEX</div>
                        <h4 style="font-size:1.05rem; font-weight:900; color:#FFFFFF; margin:2px 0 0 0; letter-spacing:-0.01em;">B2B Wholesale Credit Settlement Voucher</h4>
                        <small style="font-size:0.68rem; color:#F5ECCE;">ISO 9001:2015 Certified Wholesale Textile Network • Surat Hub</small>
                    </div>
                    <div style="text-align:right;">
                        <span class="dt-status-pill-clean gold" style="font-size:0.68rem; font-weight:800; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37;">
                            OFFICIAL AUDIT COPY
                        </span>
                        <div id="voucherTxnId" style="font-family:monospace; color:#FFE57F; font-size:0.85rem; font-weight:800; margin-top:4px;">TXN-WHL-8912</div>
                    </div>
                </div>

                <!-- Wholesaler & Account Details Strip -->
                <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:10px 14px; display:grid; grid-template-columns:1fr 1fr; gap:8px; font-size:0.75rem;">
                    <div>
                        <span style="color:#78716C; font-weight:600; display:block;">Partner Wholesaler:</span>
                        <strong id="voucherPartnerName" style="color:#181512; font-weight:800;"><?php echo $wholesale ? htmlspecialchars($wholesale['name']) : 'Shree Balaji Silk Mills'; ?></strong>
                        <div id="voucherPartnerSub" style="color:#78716C; font-size:0.7rem; font-family:monospace;">ID: <?php echo $wholesale ? $wholesale['id'] : 'WHL-8012'; ?> • GSTIN: <?php echo $wholesale ? $wholesale['gstin'] : '24AABCS1429B1Z2'; ?></div>
                    </div>
                    <div style="text-align:right;">
                        <span style="color:#78716C; font-weight:600; display:block;">Date &amp; Timestamp:</span>
                        <strong id="voucherDate" style="color:#181512; font-weight:800;">22 Aug 2026, 05:15 PM</strong>
                        <div style="color:#15803D; font-weight:800; font-size:0.7rem;">✓ Digitally Verified</div>
                    </div>
                </div>

                <!-- Particulars & Details -->
                <div style="background:#FFFFFF; border:1px solid #EAE5D9; border-radius:8px; padding:12px 14px; display:flex; flex-direction:column; gap:8px; font-size:0.78rem;">
                    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px dashed #F1ECE1; padding-bottom:6px;">
                        <span style="color:#78716C; font-weight:600;">Transaction Type:</span>
                        <strong id="voucherType" style="color:#181512; font-weight:800;">Wholesale Saree Dispatch Debit (Order ORD-WHL-8112)</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px dashed #F1ECE1; padding-bottom:6px;">
                        <span style="color:#78716C; font-weight:600;">Reference / UTR / Order No:</span>
                        <strong id="voucherRef" style="font-family:monospace; color:#8A681F; font-weight:800;">ORD-WHL-8112</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#78716C; font-weight:600;">Authorized By:</span>
                        <strong id="voucherActor" style="color:#181512; font-weight:700;">Wholesale Finance Desk</strong>
                    </div>
                </div>

                <!-- Amount Box & Security Stamp -->
                <div class="dt-voucher-amount-box">
                    <div>
                        <span style="font-size:0.7rem; color:#78716C; font-weight:800; text-transform:uppercase;">TOTAL TRANSACTION AMOUNT</span>
                        <div id="voucherAmount" style="font-size:1.6rem; font-weight:900; color:#DC2626; line-height:1.1; margin-top:2px;">
                            -₹84,500
                        </div>
                    </div>
                    <div class="dt-voucher-stamp">
                        <span>DT BRAND'S</span>
                        <span style="font-size:0.5rem; color:#15803D;">✓ VERIFIED</span>
                        <span>FINANCE</span>
                    </div>
                </div>

                <!-- Footer Security Hash -->
                <div style="border-top:1px solid #EAE5D9; padding-top:8px; display:flex; justify-content:space-between; align-items:center; font-size:0.68rem; color:#78716C;">
                    <span>🔒 SHA-256: <code style="font-family:monospace; color:#8A681F;">8c9f1e3a7b5d204e...</code></span>
                    <span>System Generated • No Physical Signature Required</span>
                </div>

            </div>
        </div>

        <!-- Modal Bottom Actions -->
        <div class="dt-modal-foot" style="padding:12px 18px; border-top:1px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; background:#FAF8F4;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtVoucherModal')">Close</button>
            <div style="display:flex; align-items:center; gap:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="printCurrentVoucher()">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                    <span>Print Voucher</span>
                </button>
                <button type="button" class="dt-btn dt-btn-gold" onclick="downloadWholesaleVoucherPdf()">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Download Voucher PDF</span>
                </button>
            </div>
        </div>

    </div>
</div>

<script src="/admin/wholesale/assets/js/wholesale.js?v=<?php echo time(); ?>"></script>
<script src="/admin/wholesale/assets/js/wholesale-credit.js?v=<?php echo time(); ?>"></script>
</body>
</html>
