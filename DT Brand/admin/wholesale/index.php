<?php
/**
 * index.php — DT Brand's & Jai Hanuman Tex
 * Master Wholesale B2B Corporate Hub & Accounts Directory
 */
require_once __DIR__ . '/../../src/CustomerManager.php';
require_once __DIR__ . '/../../src/Database.php';

use DTBrand\CustomerManager;
use DTBrand\Database;

$wholesalersList = CustomerManager::getByType('wholesale');
$totalWholesalersCount = count($wholesalersList);

$page_title = "Wholesale Corporate Management";
$active_nav = "wholesalers";
$active_subnav = "all";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesale Management - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/wholesale/assets/css/wholesale.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/wholesale/assets/css/wholesale-list.css?v=<?php echo time(); ?>">
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
                <!-- ══ TOP HEADER ══ -->
                <div class="dt-cust-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:4px;">
                    <div class="dt-cust-title-group">
                        <h1 class="dt-cust-title" style="font-size:1.35rem; font-weight:900; color:#181512; margin:0; display:flex; align-items:center; gap:8px;">
                            <span>Wholesale Corporate Management</span>
                            <span class="dt-cust-badge gold" style="font-size:0.72rem; padding:3px 8px; border-radius:6px; background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37; font-weight:800;">B2B VIP Central</span>
                        </h1>
                        <p class="dt-cust-subtitle" style="font-size:0.78rem; color:#78716C; margin:3px 0 0 0;">Manage DT Brands wholesale accounts, pricing tiers, revolving credit lines, and high-volume purchase agreements.</p>
                    </div>
                    <div class="dt-cust-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <a href="/admin/wholesale/applications.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            <span>Applications (14)</span>
                        </a>
                        <a href="/admin/wholesale/pricing.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                            <span>Pricing &amp; Margins</span>
                        </a>
                        <a href="/admin/wholesale/edit.php?id=new" class="dt-btn dt-btn-gold">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>Add Wholesale Account</span>
                        </a>
                    </div>
                </div>

                <!-- 8-Card Master KPI Ribbon -->
                <?php include __DIR__ . '/components/wholesale-stats.php'; ?>

                <!-- Master Wholesale Accounts Table -->
                <?php include __DIR__ . '/components/wholesale-table.php'; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ══ APPROVE MODAL ══ -->
<div id="dtApproveWholesaleModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:#FFFFFF; border:2px solid #D4AF37; border-radius:12px; width:95%; max-width:480px; padding:20px; box-shadow:0 20px 50px rgba(0,0,0,0.4);">
        <h3 style="font-size:1.1rem; font-weight:900; color:#181512; margin:0 0 6px 0;">Approve Wholesale Application</h3>
        <p id="approveBusinessNameDisplay" style="font-size:0.78rem; color:#8A681F; font-weight:700; margin:0 0 14px 0;">Business Name (WHL-8012)</p>
        <input type="hidden" id="approveWhlId">
        <form onsubmit="submitApproveWholesale(event)" style="display:flex; flex-direction:column; gap:12px;">
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Approved Margin Tier</label>
                <select id="approvedTierSelect" class="dt-wholesale-select" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.8rem; font-weight:700;">
                    <option value="Platinum">Platinum Wholesale (35% Margin)</option>
                    <option value="Gold">Gold Distributor (28% Margin)</option>
                    <option value="Silver">Silver Bulk Partner (20% Margin)</option>
                    <option value="Bronze">Bronze Starter (12% Margin)</option>
                </select>
            </div>
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Approved Revolving Credit Limit (₹)</label>
                <input type="number" id="approveCreditLimit" value="200000" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.8rem; padding:0 10px; box-sizing:border-box;">
            </div>
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Payment Terms</label>
                <select id="approvePaymentTerms" class="dt-wholesale-select" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.8rem; font-weight:700;">
                    <option value="Net 30 Days">Net 30 Days</option>
                    <option value="Net 45 Days">Net 45 Days</option>
                    <option value="Net 15 Days">Net 15 Days</option>
                    <option value="Advance 50%">Advance 50%</option>
                </select>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtApproveWholesaleModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">Confirm Approval</button>
            </div>
        </form>
    </div>
</div>

<!-- ══ REJECT MODAL ══ -->
<div id="dtRejectWholesaleModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6); backdrop-filter:blur(4px); z-index:99999; align-items:center; justify-content:center;">
    <div style="background:#FFFFFF; border:2px solid #DC2626; border-radius:12px; width:95%; max-width:440px; padding:20px; box-shadow:0 20px 50px rgba(0,0,0,0.4);">
        <h3 style="font-size:1.1rem; font-weight:900; color:#DC2626; margin:0 0 6px 0;">Reject Wholesale Application</h3>
        <p id="rejectBusinessNameDisplay" style="font-size:0.78rem; color:#78716C; margin:0 0 14px 0;">Business Name</p>
        <input type="hidden" id="rejectWhlId">
        <form onsubmit="submitRejectWholesale(event)" style="display:flex; flex-direction:column; gap:12px;">
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Rejection Reason</label>
                <select id="rejectReasonSelect" class="dt-wholesale-select" style="width:100%; height:36px; border:1.2px solid #EAE5D9; border-radius:8px; font-size:0.8rem; font-weight:700;">
                    <option value="Invalid GSTIN / Tax Portal Mismatch">Invalid GSTIN / Tax Portal Mismatch</option>
                    <option value="Incomplete KYC Identification">Incomplete KYC Identification</option>
                    <option value="Below Minimum Volume Criteria">Below Minimum Volume Criteria</option>
                    <option value="Duplicate Corporate Account">Duplicate Corporate Account</option>
                </select>
            </div>
            <div>
                <label style="font-size:0.72rem; font-weight:800; color:#181512; text-transform:uppercase; display:block; margin-bottom:4px;">Internal Memorandum / Notes</label>
                <textarea rows="2" style="width:100%; padding:8px 10px; font-size:0.78rem; border:1.2px solid #EAE5D9; border-radius:8px; box-sizing:border-box;" placeholder="Add mandatory internal audit reason..."></textarea>
            </div>
            <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:8px;">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeWholesaleModal('dtRejectWholesaleModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-danger">Confirm Rejection</button>
            </div>
        </form>
    </div>
</div>

<script>
    window.dbWholesalersData = <?= json_encode($wholesalersList) ?>;
</script>
<script src="/admin/wholesale/assets/js/wholesale.js?v=<?php echo time(); ?>"></script>
<script src="/admin/wholesale/assets/js/wholesale-list.js?v=<?php echo time(); ?>"></script>
<script src="/admin/wholesale/assets/js/wholesale-filters.js?v=<?php echo time(); ?>"></script>
<script src="/admin/wholesale/assets/js/wholesale-status.js?v=<?php echo time(); ?>"></script>
<script src="/admin/wholesale/assets/js/bulk-actions.js?v=<?php echo time(); ?>"></script>
</body>
</html>
