<?php
/**
 * credit.php — DT Brand's & Jai Hanuman Tex
 * Wholesale Revolving Credit Hub & Double-Entry Ledger
 */
$page_title = "Wholesale Credit Hub";
$active_nav = "wholesalers";
$active_subnav = "credit";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesale Credit Hub - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/wholesale/assets/css/wholesale.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/wholesale/assets/css/wholesale-credit.css?v=<?php echo time(); ?>">
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
                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:4px;">
                    <div>
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span>Wholesale Revolving Credit Hub</span>
                            <span class="dt-cust-badge gold" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:800;">₹28.5L Active Facilities</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Manage B2B credit limits, record NEFT/RTGS settlements, and issue certified digital vouchers.</p>
                    </div>
                </div>

                <?php include __DIR__ . '/components/wholesale-credit.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ══ CREDIT ADJUSTMENT MODAL ══ -->
<div id="dtCreditAdjustmentModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:12px; width:95%; max-width:460px; padding:20px; box-shadow:0 20px 50px rgba(0,0,0,0.4);">
        <h3 style="font-size:1.1rem; font-weight:900; color:#181512; margin:0 0 6px 0;">Adjust Sanctioned Credit Limit</h3>
        <input type="hidden" id="adjustWholesaleId">
        <form onsubmit="submitCreditAdjustment(event)" style="display:flex; flex-direction:column; gap:12px;">
            <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:10px; display:flex; justify-content:space-between; font-size:0.75rem;">
                <div>
                    <span style="color:#78716C; display:block;">Current Limit:</span>
                    <strong id="adjustCurrentLimitDisplay" style="color:#8A681F; font-size:0.9rem;">₹5,00,000</strong>
                </div>
                <div>
                    <span style="color:#78716C; display:block;">Utilized Credit:</span>
                    <strong id="adjustCurrentUtilizedDisplay" style="color:#181512; font-size:0.9rem;">₹2,10,000</strong>
                </div>
            </div>
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">New Sanctioned Limit (₹)</label>
                <input type="number" id="adjustNewLimitInput" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.85rem; font-weight:800; padding:0 10px; box-sizing:border-box;">
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
        <form onsubmit="submitRecordSettlement(event)" style="display:flex; flex-direction:column; gap:12px;">
            <div style="background:#FAF8F4; border:1px solid #EAE5D9; border-radius:8px; padding:10px; font-size:0.75rem;">
                <span style="color:#78716C;">Current Outstanding Due:</span>
                <strong id="settleCurrentDueDisplay" style="color:#DC2626; font-size:0.9rem; margin-left:8px;">₹2,10,000</strong>
            </div>
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Settlement Amount (₹)</label>
                <input type="number" id="settleAmountInput" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.85rem; font-weight:800; padding:0 10px; box-sizing:border-box;">
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

<script src="/Frontend/Admin/wholesale/assets/js/wholesale.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/wholesale/assets/js/wholesale-credit.js?v=<?php echo time(); ?>"></script>
</body>
</html>
