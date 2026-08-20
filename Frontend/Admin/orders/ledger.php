<?php
/**
 * ledger.php — Printable B2B Customer Account & Financial Ledger Statement
 * DT Brand's & Jai Hanuman Tex
 */
$order_id = isset($_GET['id']) ? trim($_GET['id']) : 'DTB-001624';
$auto_print = isset($_GET['print']) && $_GET['print'] === '1';

$customer_name = 'Rajesh Kumar (Vardhman Tex)';
$gstin = '24AAECJ1928K1Z5';
$phone = '+91 98220 19283';
$email = 'rajesh@vardhmantex.com';
$address = 'Shop 42, Textile Market, Ring Road, Surat, Gujarat - 395002';
$account_tier = 'Verified Wholesale VIP';
$credit_limit = '15,00,000 (Net 15 Days)';

$page_title = "Financial Ledger — " . $customer_name;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> ‹ DT Brand's</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/orders.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/documents.css?v=<?php echo time(); ?>">
    <style>
        .dt-ledger-doc {
            max-width: 860px;
            margin: 0 auto;
            background: #FFFFFF;
            border: 1.5px solid #8A681F;
            border-radius: 8px;
            padding: 28px 32px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #181512;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .dt-rupee-svg {
            display: inline-block;
            vertical-align: middle;
            stroke: currentColor;
            fill: none;
            stroke-width: 2.4;
        }
        @media print {
            body {
                background: #FFFFFF !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            body * {
                visibility: hidden;
            }
            .dt-ledger-doc, .dt-ledger-doc * {
                visibility: visible !important;
            }
            .dt-doc-actions-bar {
                display: none !important;
            }
            .dt-ledger-doc {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                max-width: 100% !important;
                border: 1.5px solid #000000 !important;
                box-shadow: none !important;
                padding: 16px !important;
                margin: 0 !important;
                border-radius: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body style="background:#F1F5F9; padding:24px 0;">

<!-- Actions Bar -->
<div class="dt-doc-actions-bar" style="max-width:860px; margin:0 auto 16px auto; display:flex; justify-content:space-between; align-items:center;">
    <a href="/Frontend/Admin/orders/view.php?id=<?php echo htmlspecialchars($order_id); ?>" class="dt-btn dt-btn-pale">
        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
        <span>Back to Order</span>
    </a>
    <div style="display:flex; gap:8px;">
        <button type="button" class="dt-btn dt-btn-pale" onclick="window.DT_ORDER_VIEW ? window.DT_ORDER_VIEW.exportLedgerCSV() : window.print()">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
            <span>Export Excel (.xls)</span>
        </button>
        <button type="button" class="dt-btn dt-btn-gold" onclick="window.print()">
            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
            <span>Print Statement</span>
        </button>
    </div>
</div>

<!-- Ledger Document Container -->
<div class="dt-doc-container dt-ledger-doc">
    
    <!-- Letterhead Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #8A681F; padding-bottom:14px; margin-bottom:16px;">
        <div style="display:flex; align-items:center; gap:14px;">
            <div style="width:52px; height:52px; border-radius:8px; background:linear-gradient(135deg, #181512 0%, #2A241E 100%); border:1.5px solid #8A681F; display:flex; align-items:center; justify-content:center; padding:3px; box-shadow:0 2px 8px rgba(0,0,0,0.12); flex-shrink:0;">
                <img src="/Shared/Asset/images/logo.png" onerror="this.onerror=null; this.src='/Frontend/Shop/Asset/images/logo.png';" alt="DT Brand's Logo" style="max-width:100%; max-height:100%; object-fit:contain;">
            </div>
            <div>
                <h1 style="margin:0; font-size:19px; font-weight:800; color:#181512; letter-spacing:-0.02em; line-height:1.2;">DT BRAND'S &amp; JAI HANUMAN TEX</h1>
                <div style="font-size:11px; color:#64748B; margin-top:3px; line-height:1.35;">
                    Surat Central Textile Depot, Ring Road, Surat, Gujarat - 395002<br>
                    GSTIN: <strong>24AAECJ1928K1Z5</strong> • Silk Mark Certified Wholesale Handlooms
                </div>
            </div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:16px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.5px;">ACCOUNT LEDGER</div>
            <div style="font-size:11px; color:#64748B; margin-top:2px;">Statement Period: <strong>FY 2026-27</strong></div>
            <div style="font-size:11px; color:#64748B;">Date: <strong><?php echo date('d M Y'); ?></strong></div>
        </div>
    </div>

    <!-- Customer Overview Box -->
    <div style="background:#FAF8F4; border:1px solid #E2DFD7; border-radius:6px; padding:12px 16px; margin-bottom:16px; display:grid; grid-template-columns:1fr 1fr; gap:12px; font-size:11.5px; line-height:1.5;">
        <div>
            <div style="font-size:10px; font-weight:800; text-transform:uppercase; color:#8A681F; margin-bottom:3px;">Account Holder:</div>
            <strong style="font-size:14px; color:#181512;"><?php echo htmlspecialchars($customer_name); ?></strong><br>
            <span style="color:#475569;"><?php echo htmlspecialchars($address); ?></span><br>
            <strong>GSTIN:</strong> <?php echo htmlspecialchars($gstin); ?> | <strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?>
        </div>
        <div style="border-left:1px dashed #D4AF37; padding-left:16px;">
            <div style="font-size:10px; font-weight:800; text-transform:uppercase; color:#8A681F; margin-bottom:3px;">Wholesale Terms:</div>
            <strong>Account Tier:</strong> <?php echo htmlspecialchars($account_tier); ?><br>
            <strong>Credit Limit:</strong> ₹ <?php echo htmlspecialchars($credit_limit); ?><br>
            <strong>Ledger Balance:</strong> <strong style="color:#15803D;">₹ 0.00 (All Invoices Settled)</strong>
        </div>
    </div>

    <!-- 4 Metrics Ribbon -->
    <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:10px; margin-bottom:16px;">
        <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:6px; padding:8px 12px;">
            <div style="font-size:9.5px; font-weight:800; color:#8A681F; text-transform:uppercase;">Lifetime Business</div>
            <div style="font-size:15px; font-weight:800; color:#181512; margin-top:2px;">₹ 8,42,500.00</div>
            <div style="font-size:9.5px; color:#64748B;">14 Consignments</div>
        </div>
        <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:6px; padding:8px 12px;">
            <div style="font-size:9.5px; font-weight:800; color:#15803D; text-transform:uppercase;">Total Settled</div>
            <div style="font-size:15px; font-weight:800; color:#15803D; margin-top:2px;">₹ 8,42,500.00</div>
            <div style="font-size:9.5px; color:#16A34A; font-weight:700;">100% Paid / Cleared</div>
        </div>
        <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:6px; padding:8px 12px;">
            <div style="font-size:9.5px; font-weight:800; color:#64748B; text-transform:uppercase;">Current Balance</div>
            <div style="font-size:15px; font-weight:800; color:#181512; margin-top:2px;">₹ 0.00</div>
            <div style="font-size:9.5px; color:#15803D; font-weight:700;">All Cleared</div>
        </div>
        <div style="background:#FFFFFF; border:1px solid #E2DFD7; border-radius:6px; padding:8px 12px;">
            <div style="font-size:9.5px; font-weight:800; color:#8A681F; text-transform:uppercase;">Credit Facility</div>
            <div style="font-size:15px; font-weight:800; color:#8A681F; margin-top:2px;">₹ 15,00,000</div>
            <div style="font-size:9.5px; color:#64748B;">Net 15 Days Term</div>
        </div>
    </div>

    <!-- Transaction Table -->
    <table style="width:100%; border-collapse:collapse; font-size:11.5px; margin-bottom:16px;">
        <thead>
            <tr style="background:#181512; color:#FAF5E8;">
                <th style="padding:8px 10px; text-align:left; font-size:10px; text-transform:uppercase;">Date</th>
                <th style="padding:8px 10px; text-align:left; font-size:10px; text-transform:uppercase;">Reference ID</th>
                <th style="padding:8px 10px; text-align:left; font-size:10px; text-transform:uppercase;">Transaction Description</th>
                <th style="padding:8px 10px; text-align:right; font-size:10px; text-transform:uppercase;">Debit (₹)</th>
                <th style="padding:8px 10px; text-align:right; font-size:10px; text-transform:uppercase;">Credit (₹)</th>
                <th style="padding:8px 10px; text-align:right; font-size:10px; text-transform:uppercase;">Balance (₹)</th>
                <th style="padding:8px 10px; text-align:center; font-size:10px; text-transform:uppercase;">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr style="border-bottom:1px solid #E2E8F0;">
                <td style="padding:7px 10px;">21-Aug-2026</td>
                <td style="padding:7px 10px; font-weight:800; color:#8A681F;">DTB-001624</td>
                <td style="padding:7px 10px;">Consignment Invoice (Kanjivaram Silk 25pcs)</td>
                <td style="padding:7px 10px; text-align:right; font-weight:700;">1,12,250.00</td>
                <td style="padding:7px 10px; text-align:right; color:#94A3B8;">—</td>
                <td style="padding:7px 10px; text-align:right; font-weight:700;">1,12,250.00</td>
                <td style="padding:7px 10px; text-align:center; font-weight:700; color:#B45309;">Billed</td>
            </tr>
            <tr style="border-bottom:1px solid #E2E8F0; background:#F8FAFC;">
                <td style="padding:7px 10px;">21-Aug-2026</td>
                <td style="padding:7px 10px; font-family:monospace; font-weight:700;">UTR-9821039812</td>
                <td style="padding:7px 10px; color:#15803D; font-weight:600;">Bank Wire / RTGS Full Settlement</td>
                <td style="padding:7px 10px; text-align:right; color:#94A3B8;">—</td>
                <td style="padding:7px 10px; text-align:right; font-weight:700; color:#15803D;">1,12,250.00</td>
                <td style="padding:7px 10px; text-align:right; font-weight:700; color:#15803D;">0.00</td>
                <td style="padding:7px 10px; text-align:center; font-weight:700; color:#15803D;">PAID</td>
            </tr>
            <tr style="border-bottom:1px solid #E2E8F0;">
                <td style="padding:7px 10px;">10-Aug-2026</td>
                <td style="padding:7px 10px; font-weight:800; color:#8A681F;">DTB-001605</td>
                <td style="padding:7px 10px;">Banarasi Silk Lot Consignment (40pcs)</td>
                <td style="padding:7px 10px; text-align:right; font-weight:700;">2,45,000.00</td>
                <td style="padding:7px 10px; text-align:right; color:#94A3B8;">—</td>
                <td style="padding:7px 10px; text-align:right; font-weight:700;">2,45,000.00</td>
                <td style="padding:7px 10px; text-align:center; font-weight:700; color:#15803D;">Delivered</td>
            </tr>
            <tr style="border-bottom:1px solid #E2E8F0; background:#F8FAFC;">
                <td style="padding:7px 10px;">11-Aug-2026</td>
                <td style="padding:7px 10px; font-family:monospace; font-weight:700;">UTR-882910398</td>
                <td style="padding:7px 10px; color:#15803D; font-weight:600;">RTGS ICICI Bank Full Settlement</td>
                <td style="padding:7px 10px; text-align:right; color:#94A3B8;">—</td>
                <td style="padding:7px 10px; text-align:right; font-weight:700; color:#15803D;">2,45,000.00</td>
                <td style="padding:7px 10px; text-align:right; font-weight:700; color:#15803D;">0.00</td>
                <td style="padding:7px 10px; text-align:center; font-weight:700; color:#15803D;">PAID</td>
            </tr>
            <tr style="border-bottom:1px solid #E2E8F0;">
                <td style="padding:7px 10px;">25-Jul-2026</td>
                <td style="padding:7px 10px; font-weight:800; color:#8A681F;">DTB-001582</td>
                <td style="padding:7px 10px;">Chanderi &amp; Tussar Festive Catalog (35pcs)</td>
                <td style="padding:7px 10px; text-align:right; font-weight:700;">1,85,250.00</td>
                <td style="padding:7px 10px; text-align:right; color:#94A3B8;">—</td>
                <td style="padding:7px 10px; text-align:right; font-weight:700;">1,85,250.00</td>
                <td style="padding:7px 10px; text-align:center; font-weight:700; color:#15803D;">Delivered</td>
            </tr>
            <tr style="border-bottom:1px solid #E2E8F0; background:#F8FAFC;">
                <td style="padding:7px 10px;">26-Jul-2026</td>
                <td style="padding:7px 10px; font-family:monospace; font-weight:700;">UTR-771829301</td>
                <td style="padding:7px 10px; color:#15803D; font-weight:600;">HDFC NetBanking Direct Settlement</td>
                <td style="padding:7px 10px; text-align:right; color:#94A3B8;">—</td>
                <td style="padding:7px 10px; text-align:right; font-weight:700; color:#15803D;">1,85,250.00</td>
                <td style="padding:7px 10px; text-align:right; font-weight:700; color:#15803D;">0.00</td>
                <td style="padding:7px 10px; text-align:center; font-weight:700; color:#15803D;">PAID</td>
            </tr>
            <tr style="border-bottom:1px solid #E2E8F0;">
                <td style="padding:7px 10px;">08-Jul-2026</td>
                <td style="padding:7px 10px; font-weight:800; color:#8A681F;">DTB-001550</td>
                <td style="padding:7px 10px;">Paithani Heritage Zari Collection (20pcs)</td>
                <td style="padding:7px 10px; text-align:right; font-weight:700;">1,42,000.00</td>
                <td style="padding:7px 10px; text-align:right; color:#94A3B8;">—</td>
                <td style="padding:7px 10px; text-align:right; font-weight:700;">1,42,000.00</td>
                <td style="padding:7px 10px; text-align:center; font-weight:700; color:#15803D;">Delivered</td>
            </tr>
            <tr style="border-bottom:1px solid #E2E8F0; background:#F8FAFC;">
                <td style="padding:7px 10px;">09-Jul-2026</td>
                <td style="padding:7px 10px; font-family:monospace; font-weight:700;">UTR-662918274</td>
                <td style="padding:7px 10px; color:#15803D; font-weight:600;">SBI Corporate Direct Wire Transfer</td>
                <td style="padding:7px 10px; text-align:right; color:#94A3B8;">—</td>
                <td style="padding:7px 10px; text-align:right; font-weight:700; color:#15803D;">1,42,000.00</td>
                <td style="padding:7px 10px; text-align:right; font-weight:700; color:#15803D;">0.00</td>
                <td style="padding:7px 10px; text-align:center; font-weight:700; color:#15803D;">PAID</td>
            </tr>
        </tbody>
        <tfoot>
            <tr style="background:#FAF5E8; font-weight:800; border-top:2px solid #8A681F; border-bottom:2px solid #8A681F;">
                <td colspan="3" style="padding:10px; text-align:right; color:#181512; text-transform:uppercase;">RECONCILED TOTALS:</td>
                <td style="padding:10px; text-align:right; color:#181512;">₹ 6,84,500.00</td>
                <td style="padding:10px; text-align:right; color:#15803D;">₹ 6,84,500.00</td>
                <td style="padding:10px; text-align:right; color:#15803D;">₹ 0.00</td>
                <td style="padding:10px; text-align:center; color:#15803D;">ALL CLEAR</td>
            </tr>
        </tfoot>
    </table>

    <!-- Footer Stamp -->
    <div style="display:flex; justify-content:space-between; align-items:flex-end; border-top:1px solid #E2DFD7; padding-top:14px; font-size:10.5px; color:#64748B;">
        <div>
            This is a computer-generated B2B accounting statement from DT Brand's &amp; Jai Hanuman Tex Surat Central Depot.<br>
            Direct Inquiries: accounts@jaihanumantex.in | Central Helpline: +91 98251 00000
        </div>
        <div style="text-align:right; font-weight:700; color:#181512;">
            Authorized Accounting Signatory<br>
            <span style="font-weight:400; font-size:9.5px; color:#8A681F;">Surat Central Depot Dock HQ</span>
        </div>
    </div>

</div>

<script src="/Frontend/Admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/orders/assets/js/order-view.js?v=<?php echo time(); ?>"></script>
<?php if ($auto_print): ?>
<script>
window.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        window.print();
    }, 400);
});
</script>
<?php endif; ?>
</body>
</html>
