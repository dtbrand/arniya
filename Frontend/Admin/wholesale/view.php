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
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/wholesale/assets/css/wholesale.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/wholesale/assets/css/wholesale-view.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/wholesale/assets/css/wholesale-credit.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/wholesale/assets/css/wholesale-pricing.css?v=<?php echo time(); ?>">
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
                    <a href="/Frontend/Admin/wholesale/index.php" class="dt-btn dt-btn-pale dt-btn-sm">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Back to Wholesalers</span>
                    </a>
                    <div style="display:flex; gap:8px;">
                        <a href="/Frontend/Admin/wholesale/edit.php?id=<?php echo $wholesale['id']; ?>" class="dt-btn dt-btn-pale dt-btn-sm">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                            <span>Edit Profile</span>
                        </a>
                        <a href="/Frontend/Admin/wholesale/orders.php?id=<?php echo $wholesale['id']; ?>" class="dt-btn dt-btn-gold dt-btn-sm">
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

<!-- ══ CERTIFIED VOUCHER MODAL ══ -->
<div id="dtVoucherModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.65); backdrop-filter:blur(4px); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:12px; width:95%; max-width:540px; padding:20px; box-shadow:0 20px 50px rgba(0,0,0,0.4);">
        <div id="dtPrintableVoucher" style="background:#FFFFFF; padding:16px; border:1px solid #EAE5D9; border-radius:8px;">
            <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1.5px solid #D4AF37; padding-bottom:10px; margin-bottom:12px;">
                <div>
                    <h3 style="font-size:1rem; font-weight:900; color:#181512; margin:0;">DT BRAND'S &amp; JAI HANUMAN TEX</h3>
                    <small style="font-size:0.68rem; color:#8A681F; font-weight:700;">Official Wholesale Credit Voucher • ISO 9001:2015</small>
                </div>
                <span style="font-size:0.7rem; font-weight:800; color:#15803D; background:#DCFCE7; border:1px solid #86EFAC; padding:2px 8px; border-radius:4px;">CERTIFIED</span>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; font-size:0.75rem; margin-bottom:14px;">
                <div>
                    <span style="color:#78716C; display:block;">Partner Trade Name:</span>
                    <strong id="voucherPartnerName" style="color:#181512;"><?php echo htmlspecialchars($wholesale['name']); ?></strong>
                </div>
                <div>
                    <span style="color:#78716C; display:block;">Wholesale ID:</span>
                    <strong id="voucherWholesaleId" style="font-family:monospace; color:#8A681F;"><?php echo $wholesale['id']; ?></strong>
                </div>
                <div>
                    <span style="color:#78716C; display:block;">Voucher Txn ID:</span>
                    <strong id="voucherTxnId" style="font-family:monospace; color:#8A681F;">TXN-WHL-9912</strong>
                </div>
                <div>
                    <span style="color:#78716C; display:block;">Date &amp; Time:</span>
                    <strong id="voucherDate">22 Aug 2026, 05:15 PM</strong>
                </div>
            </div>

            <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:12px; margin-bottom:12px;">
                <div id="voucherType" style="font-size:0.82rem; font-weight:800; color:#181512; margin-bottom:8px;">Wholesale Saree Dispatch Debit</div>
                <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px dashed #EAE5D9; padding-top:6px;">
                    <span style="font-size:0.75rem; font-weight:700; color:#78716C;">Transaction Value:</span>
                    <strong id="voucherAmount" style="font-size:1.15rem; font-weight:900; color:#DC2626;">-₹84,500</strong>
                </div>
            </div>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:14px;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtVoucherModal')">Close</button>
            <button type="button" class="dt-btn dt-btn-gold" onclick="downloadWholesaleVoucherPdf()">Download PDF</button>
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

<script src="/Frontend/Admin/wholesale/assets/js/wholesale.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/wholesale/assets/js/wholesale-view.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/wholesale/assets/js/wholesale-credit.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/wholesale/assets/js/wholesale-pricing.js?v=<?php echo time(); ?>"></script>
</body>
</html>

