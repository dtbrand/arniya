<?php
/**
 * view.php — DT Brand's & Jai Hanuman Tex
 * Master Wholesale Partner 360 Profile & Commercial Dossier (100% Dynamic)
 */
$page_title = "Wholesale Partner Profile";
$active_nav = "wholesalers";
$active_subnav = "all";

require_once __DIR__ . '/components/wholesale-data.php';

$whl_id = isset($_GET['id']) ? $_GET['id'] : 'WHL-8012';
$wholesale = getWholesalePartner($whl_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($wholesale['id'] . ' - ' . $wholesale['name']); ?> - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/DT%20Brand/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/wholesale/assets/css/wholesale.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/wholesale/assets/css/wholesale-view.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/wholesale/assets/css/wholesale-credit.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/DT%20Brand/admin/wholesale/assets/css/wholesale-pricing.css?v=<?php echo time(); ?>">
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
                    <a href="/DT%20Brand/admin/wholesale/index.php" class="dt-btn dt-btn-pale dt-btn-sm">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Back to Wholesalers</span>
                    </a>
                    <div style="display:flex; gap:8px;">
                        <a href="/DT%20Brand/admin/wholesale/edit.php?id=<?php echo $wholesale['id']; ?>" class="dt-btn dt-btn-pale dt-btn-sm">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                            <span>Edit Profile</span>
                        </a>
                        <a href="/DT%20Brand/admin/wholesale/orders.php?id=<?php echo $wholesale['id']; ?>" class="dt-btn dt-btn-gold dt-btn-sm">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                            <span>View Orders</span>
                        </a>
                    </div>
                </div>

                <!-- 360 Partner Profile Component -->
                <?php include __DIR__ . '/components/wholesale-profile.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ══ CREDIT ADJUSTMENT MODAL ══ -->
<div id="dtCreditAdjustmentModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:12px; width:95%; max-width:460px; padding:20px; box-shadow:0 20px 50px rgba(0,0,0,0.4);">
        <h3 style="font-size:1.1rem; font-weight:900; color:#181512; margin:0 0 6px 0;">Adjust Sanctioned Credit Limit</h3>
        <p style="font-size:0.75rem; color:#78716C; margin:0 0 14px 0;">Underwrite new revolving credit headroom for wholesale partner.</p>
        <input type="hidden" id="adjustWholesaleId" value="<?php echo $wholesale['id']; ?>">
        <form onsubmit="submitCreditAdjustment(event)" style="display:flex; flex-direction:column; gap:12px;">
            <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:10px; display:flex; justify-content:space-between; font-size:0.75rem;">
                <div>
                    <span style="color:#78716C; display:block;">Current Limit:</span>
                    <strong id="adjustCurrentLimitDisplay" style="color:#8A681F; font-size:0.9rem;">₹<?php echo number_format($wholesale['sanctioned_limit']); ?></strong>
                </div>
                <div>
                    <span style="color:#78716C; display:block;">Utilized Credit:</span>
                    <strong id="adjustCurrentUtilizedDisplay" style="color:#181512; font-size:0.9rem;">₹<?php echo number_format($wholesale['utilized_credit']); ?></strong>
                </div>
            </div>
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">New Sanctioned Limit (₹)</label>
                <input type="number" id="adjustNewLimitInput" value="<?php echo $wholesale['sanctioned_limit']; ?>" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.85rem; font-weight:800; padding:0 10px; box-sizing:border-box;">
            </div>
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Underwriting Reason / Note</label>
                <input type="text" id="adjustReasonInput" placeholder="e.g. Pre-Booking Line Enhancement" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.78rem; padding:0 10px; box-sizing:border-box;">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:6px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtCreditAdjustmentModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">Confirm Credit Adjustment</button>
            </div>
        </form>
    </div>
</div>

<!-- ══ RECORD SETTLEMENT MODAL ══ -->
<div id="dtRecordSettlementModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:#FFFFFF; border:2px solid #15803D; border-radius:12px; width:95%; max-width:460px; padding:20px; box-shadow:0 20px 50px rgba(0,0,0,0.4);">
        <h3 style="font-size:1.1rem; font-weight:900; color:#15803D; margin:0 0 6px 0;">Record Credit Settlement Payment</h3>
        <p style="font-size:0.75rem; color:#78716C; margin:0 0 14px 0;">Credit bank NEFT/RTGS receipts against partner's utilized revolving credit.</p>
        <form onsubmit="submitRecordSettlement(event)" style="display:flex; flex-direction:column; gap:12px;">
            <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:10px; font-size:0.75rem;">
                <span style="color:#78716C;">Current Outstanding Due:</span>
                <strong id="settleCurrentDueDisplay" style="color:#DC2626; font-size:0.9rem; margin-left:8px;">₹<?php echo number_format($wholesale['utilized_credit']); ?></strong>
            </div>
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Settlement Amount (₹)</label>
                <input type="number" id="settleAmountInput" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.85rem; font-weight:800; padding:0 10px; box-sizing:border-box;" placeholder="e.g. 50000">
            </div>
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Bank Settlement Mode &amp; UTR Ref</label>
                <input type="text" id="settleUtrInput" placeholder="e.g. HDFC RTGS UTR #998812347" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.78rem; padding:0 10px; box-sizing:border-box;">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:6px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtRecordSettlementModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-emerald">Record Settlement</button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     CERTIFIED DIGITAL WHOLESALE CREDIT VOUCHER MODAL
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
                        <strong id="voucherPartnerName" style="color:#181512; font-weight:800;"><?php echo htmlspecialchars($wholesale['name']); ?></strong>
                        <div id="voucherPartnerSub" style="color:#78716C; font-size:0.7rem; font-family:monospace;">ID: <?php echo $wholesale['id']; ?> • GSTIN: <?php echo $wholesale['gstin']; ?></div>
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

<!-- ══ EDIT CATEGORY MARGIN MODAL ══ -->
<div id="dtEditCategoryMarginModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:12px; width:95%; max-width:440px; padding:22px; box-shadow:0 20px 50px rgba(0,0,0,0.4); position:relative;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:14px;">
            <div>
                <h3 style="font-size:1.15rem; font-weight:900; color:#181512; margin:0 0 3px 0;">Edit Category Wholesale Margin</h3>
                <p id="editMarginCatName" style="font-size:0.82rem; color:#8A681F; font-weight:800; margin:0;">Category Name</p>
            </div>
            <button type="button" class="dt-drawer-close" onclick="closeWholesaleModal('dtEditCategoryMarginModal')">✕</button>
        </div>
        <input type="hidden" id="editMarginRowId">
        <form onsubmit="submitCategoryMarginEdit(event)" style="display:flex; flex-direction:column; gap:14px;">
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Wholesale Margin Discount (%)</label>
                <input type="number" id="editCategoryMarginInput" class="dt-wholesale-input" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-size:0.88rem; font-weight:800; padding:0 12px; box-sizing:border-box;">
            </div>
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Minimum Order Lot (MOQ in pcs)</label>
                <input type="number" id="editCategoryMoqInput" class="dt-wholesale-input" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-size:0.88rem; font-weight:800; padding:0 12px; box-sizing:border-box;">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtEditCategoryMarginModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">Update Margin</button>
            </div>
        </form>
    </div>
</div>

<!-- ══ ADD NEW CATEGORY RULE MODAL ══ -->
<div id="dtAddCategoryMarginModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:12px; width:95%; max-width:460px; padding:22px; box-shadow:0 20px 50px rgba(0,0,0,0.4); position:relative;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:14px;">
            <div>
                <h3 style="font-size:1.15rem; font-weight:900; color:#181512; margin:0 0 3px 0;">Add Fabric Margin Rule</h3>
                <p style="font-size:0.78rem; color:#78716C; margin:0;">Configure dynamic wholesale discount and MOQ for a new catalog category.</p>
            </div>
            <button type="button" class="dt-drawer-close" onclick="closeWholesaleModal('dtAddCategoryMarginModal')">✕</button>
        </div>
        <form onsubmit="submitAddCategoryRule(event)" style="display:flex; flex-direction:column; gap:14px;">
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Fabric / Category Name</label>
                <input type="text" id="addCategoryNameInput" class="dt-wholesale-input" placeholder="e.g. Chanderi Jacquard Silk" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-size:0.85rem; font-weight:700; padding:0 12px; box-sizing:border-box;">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                <div>
                    <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Discount Margin (%)</label>
                    <input type="number" id="addCategoryMarginInput" class="dt-wholesale-input" value="32" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-size:0.88rem; font-weight:800; padding:0 12px; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Min Lot (MOQ)</label>
                    <input type="number" id="addCategoryMoqInput" class="dt-wholesale-input" value="20" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-size:0.88rem; font-weight:800; padding:0 12px; box-sizing:border-box;">
                </div>
            </div>
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Sample Retail MRP (₹)</label>
                <input type="number" id="addCategoryMrpInput" class="dt-wholesale-input" value="2400" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; font-size:0.88rem; font-weight:800; padding:0 12px; box-sizing:border-box;">
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtAddCategoryMarginModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Save Category Rule</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script src="/DT%20Brand/admin/wholesale/assets/js/wholesale.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/wholesale/assets/js/wholesale-view.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/wholesale/assets/js/wholesale-credit.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/wholesale/assets/js/wholesale-pricing.js?v=<?php echo time(); ?>"></script>
<script src="/DT%20Brand/admin/wholesale/assets/js/wholesale-orders.js?v=<?php echo time(); ?>"></script>
</body>
</html>

