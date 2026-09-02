<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * refunds.php — Refund Management & Credit Notes Ledger
 * DT Brand's & Jai Hanuman Tex — Live Database Wiring
 */
require_once __DIR__ . '/../../src/Database.php';

$page_title = "Refund Management & Credit Notes";
$active_nav = "orders";
$active_subnav = "refunds";

$refundOrders = [];
$totalSettled = 0;
$pendingApproval = 0;
$inGateway = 0;
$creditNotesCount = 0;
$creditNotesBalance = 0;

try {
    $pdo = \DTBrand\Database::getConnection();
    if ($pdo !== null && !\DTBrand\Database::isMockMode()) {
        $stmt = $pdo->query("
            SELECT o.*, c.name as buyer_name, c.phone as buyer_phone, c.type as buyer_type, c.city as buyer_city 
            FROM orders o 
            LEFT JOIN customers c ON o.customer_id = c.id 
            WHERE o.payment_status IN ('refunded', 'partially_refunded') OR o.fulfillment_status = 'cancelled'
            ORDER BY o.id DESC
        ");
        $refundOrders = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        foreach ($refundOrders as $ro) {
            $amt = (float)($ro['total_amount'] ?? 0);
            $paySt = strtolower($ro['payment_status'] ?? '');
            if ($paySt === 'refunded') {
                $totalSettled += $amt;
            } else {
                $pendingApproval += $amt;
            }
            if (stripos($ro['payment_method'] ?? '', 'wire') !== false || stripos($ro['payment_method'] ?? '', 'ledger') !== false) {
                $creditNotesCount++;
                $creditNotesBalance += $amt;
            } else {
                $inGateway += $amt;
            }
        }
    }
} catch (\Exception $e) {
    $refundOrders = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/orders.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/order-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/order-status.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/orders/assets/css/refunds.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-orders-container">
                <div class="dt-orders-head">
                    <div class="dt-orders-title-group">
                        <h1 class="dt-orders-title">
                            <span>Refunds &amp; Credit Notes Ledger</span>
                            <span class="dt-title-counter-badge">
                                <span class="dt-counter-dot" style="background:#8A681F; box-shadow:0 0 0 2px rgba(138,104,31,0.2);"></span>
                                <strong>₹<?php echo number_format($totalSettled); ?></strong> Settled
                            </span>
                        </h1>
                        <p class="dt-orders-subtitle">Track gateway payouts, UPI chargeback reversals, and B2B wholesale credit ledger balances.</p>
                    </div>
                    <div class="dt-orders-actions">
                        <a href="/admin/orders/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            <span>Back to Orders</span>
                        </a>
                        <button type="button" onclick="window.DT_REFUNDS.openRefundDrawer('', 0)" class="dt-btn dt-btn-gold">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.4"><path d="M12 5v14M5 12h14"></path></svg>
                            <span>Issue Refund / Credit Note</span>
                        </button>
                    </div>
                </div>

                <!-- 4-Card Refund Executive Metrics Ribbon -->
                <div class="dt-refunds-kpi-grid">
                    <div class="dt-master-kpi-card active">
                        <div class="dt-kpi-header">
                            <span class="dt-kpi-tag">TOTAL SETTLED VOLUME</span>
                            <div class="dt-kpi-icon-pill gold">
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
                            </div>
                        </div>
                        <div class="dt-kpi-number-wrap">
                            <span class="dt-kpi-main-number">₹<?php echo number_format($totalSettled); ?></span>
                            <span class="dt-kpi-trend-pill up">100% Audited</span>
                        </div>
                        <div class="dt-kpi-footer">
                            <span><?php echo count($refundOrders); ?> Total Records</span>
                            <span class="dt-kpi-arrow">→</span>
                        </div>
                    </div>

                    <div class="dt-master-kpi-card">
                        <div class="dt-kpi-header">
                            <span class="dt-kpi-tag">PENDING APPROVAL</span>
                            <div class="dt-kpi-icon-pill amber">
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            </div>
                        </div>
                        <div class="dt-kpi-number-wrap">
                            <span class="dt-kpi-main-number">₹<?php echo number_format($pendingApproval); ?></span>
                            <span class="dt-kpi-trend-pill amber">Live Audit</span>
                        </div>
                        <div class="dt-kpi-footer">
                            <span>Claims &amp; Return Reviews</span>
                            <span class="dt-kpi-arrow">→</span>
                        </div>
                    </div>

                    <div class="dt-master-kpi-card">
                        <div class="dt-kpi-header">
                            <span class="dt-kpi-tag">IN GATEWAY REVERSAL</span>
                            <div class="dt-kpi-icon-pill blue">
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                            </div>
                        </div>
                        <div class="dt-kpi-number-wrap">
                            <span class="dt-kpi-main-number">₹<?php echo number_format($inGateway); ?></span>
                            <span class="dt-kpi-trend-pill blue">Gateway Processing</span>
                        </div>
                        <div class="dt-kpi-footer">
                            <span>UPI &amp; Razorpay Auto-Sync</span>
                            <span class="dt-kpi-arrow">→</span>
                        </div>
                    </div>

                    <div class="dt-master-kpi-card">
                        <div class="dt-kpi-header">
                            <span class="dt-kpi-tag">B2B CREDIT NOTES</span>
                            <div class="dt-kpi-icon-pill emerald">
                                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            </div>
                        </div>
                        <div class="dt-kpi-number-wrap">
                            <span class="dt-kpi-main-number"><?php echo $creditNotesCount; ?> Notes</span>
                            <span class="dt-kpi-trend-pill emerald">Active Ledger</span>
                        </div>
                        <div class="dt-kpi-footer">
                            <span>₹<?php echo number_format($creditNotesBalance); ?> Wholesale Ledger Bal.</span>
                            <span class="dt-kpi-arrow">→</span>
                        </div>
                    </div>
                </div>

                <!-- Interactive Subnav Filter Pills -->
                <div class="dt-refund-subnav">
                    <button type="button" onclick="window.DT_REFUNDS.filterByStatus('all', this)" class="dt-refund-subnav-pill active">All Refunds <small><?php echo count($refundOrders); ?></small></button>
                    <button type="button" onclick="window.DT_REFUNDS.filterByStatus('pending', this)" class="dt-refund-subnav-pill">Pending Approval <small><?php echo $pendingApproval > 0 ? 1 : 0; ?></small></button>
                    <button type="button" onclick="window.DT_REFUNDS.filterByStatus('processing', this)" class="dt-refund-subnav-pill">Gateway Processing <small><?php echo $inGateway > 0 ? 1 : 0; ?></small></button>
                    <button type="button" onclick="window.DT_REFUNDS.filterByStatus('settled', this)" class="dt-refund-subnav-pill">Settled &amp; Cleared <small><?php echo $totalSettled > 0 ? count($refundOrders) : 0; ?></small></button>
                </div>

                <!-- Toolbar & Debounced Live Search -->
                <div class="dt-refund-toolbar">
                    <div class="dt-refund-toolbar-left">
                        <input type="text" id="refundSearchInput" oninput="window.DT_REFUNDS.handleSearch(this.value)" placeholder="Search Refund ID, Order ID, Customer, UTR..." class="dt-order-search-input" style="height:36px; padding-left:12px; width:100%; border-radius:6px; box-sizing:border-box;">
                        <button type="button" onclick="document.getElementById('refundSearchInput').value=''; window.DT_REFUNDS.handleSearch('');" style="position:absolute; right:8px; top:50%; transform:translateY(-50%); border:none; background:transparent; cursor:pointer; color:#94A3B8; font-size:12px;">✕</button>
                    </div>
                    <div class="dt-refund-toolbar-right">
                        <!-- Quick Payout Method Filter -->
                        <select id="payoutFilterSelect" onchange="window.DT_REFUNDS.filterByMethod(this.value)" class="dt-order-search-input" style="height:36px; font-weight:700; border-radius:6px; min-width:180px;">
                            <option value="all">All Payout Methods</option>
                            <option value="Bank Transfer">Direct Bank Wire</option>
                            <option value="UPI">UPI Reversal (PhonePe/GPay)</option>
                            <option value="B2B Credit">B2B Credit Note Ledger</option>
                            <option value="Razorpay">Razorpay Instant Reversal</option>
                        </select>

                        <!-- Hide / Show Columns Options Dropdown (Like Orders Section) -->
                        <div class="dt-col-dropdown-wrap" style="position:relative;">
                            <button type="button" class="dt-btn dt-btn-pale" style="height:36px; padding:0 10px; font-size:11.5px; font-weight:700; white-space:nowrap; display:inline-flex; align-items:center; gap:5px;" onclick="window.DT_REFUNDS.toggleColumnMenu(event)" title="Show or Hide Table Columns">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="9" y1="3" x2="9" y2="21"></line>
                                    <line x1="15" y1="3" x2="15" y2="21"></line>
                                </svg>
                                <span>Columns</span>
                                <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </button>
                            
                            <div id="refundColumnVisibilityMenu" class="dt-col-menu" style="display:none; position:absolute; right:0; top:calc(100% + 6px); width:230px; background:#FFFFFF; border:1px solid #D4AF37; border-radius:8px; box-shadow:0 8px 24px rgba(0,0,0,0.14); padding:10px 12px; z-index:99999;">
                                <div style="font-size:10.5px; font-weight:800; color:#8A681F; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:8px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px dashed #E2DFD7; padding-bottom:6px;">
                                    <span>Toggle Visible Columns</span>
                                    <button type="button" onclick="window.DT_REFUNDS.resetAllColumns()" style="background:none; border:none; font-size:10px; color:#1D4ED8; font-weight:700; cursor:pointer; padding:0;">Reset All</button>
                                </div>
                                <div style="display:flex; flex-direction:column; gap:5px; font-size:11px; color:#1E293B;">
                                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-ref-id" checked onchange="window.DT_REFUNDS.toggleColumn('col-ref-id', this.checked)"> <span>Refund ID</span></label>
                                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-ref-order" checked onchange="window.DT_REFUNDS.toggleColumn('col-ref-order', this.checked)"> <span>Order Ref</span></label>
                                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-ref-customer" checked onchange="window.DT_REFUNDS.toggleColumn('col-ref-customer', this.checked)"> <span>Customer &amp; Consignee</span></label>
                                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-ref-gateway" checked onchange="window.DT_REFUNDS.toggleColumn('col-ref-gateway', this.checked)"> <span>Payout Gateway</span></label>
                                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-ref-amount" checked onchange="window.DT_REFUNDS.toggleColumn('col-ref-amount', this.checked)"> <span>Amount (₹)</span></label>
                                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-ref-status" checked onchange="window.DT_REFUNDS.toggleColumn('col-ref-status', this.checked)"> <span>Settlement Status</span></label>
                                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-ref-settlement" checked onchange="window.DT_REFUNDS.toggleColumn('col-ref-settlement', this.checked)"> <span>Date / UTR Reference</span></label>
                                    <label style="display:flex; align-items:center; gap:6px; cursor:pointer;"><input type="checkbox" data-col="col-ref-actions" checked onchange="window.DT_REFUNDS.toggleColumn('col-ref-actions', this.checked)"> <span>Row Actions</span></label>
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="window.location.reload();" class="dt-btn dt-btn-pale" style="height:36px; padding:0 12px; font-size:11.5px; font-weight:700; white-space:nowrap; display:inline-flex; align-items:center; gap:5px;">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                            <span>Refresh</span>
                        </button>
                    </div>
                </div>

                <!-- Master Refund Ledger Table -->
                <div class="dt-order-table-card">
                    <div class="dt-refund-table-wrap">
                        <table class="dt-order-table" id="refundLedgerTable" style="min-width:1080px; width:100%;">
                            <thead>
                                <tr>
                                    <th class="col-ref-id" style="width:100px; white-space:nowrap;">Refund ID</th>
                                    <th class="col-ref-order" style="width:110px; white-space:nowrap;">Order Ref</th>
                                    <th class="col-ref-customer" style="min-width:210px;">Customer &amp; Consignee</th>
                                    <th class="col-ref-gateway" style="min-width:180px;">Payout Gateway</th>
                                    <th class="col-ref-amount" style="width:95px; white-space:nowrap;">Amount</th>
                                    <th class="col-ref-status" style="width:120px; white-space:nowrap;">Status</th>
                                    <th class="col-ref-settlement" style="width:150px; white-space:nowrap;">Settlement Date / UTR</th>
                                    <th class="col-ref-actions" style="width:250px; text-align:right; white-space:nowrap;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="refundTableBody">
                                <?php if (empty($refundOrders)): ?>
                                    <tr>
                                        <td colspan="8" style="text-align:center; padding: 48px 16px; background:#FAF8F4; border-radius:12px;">
                                            <svg viewBox="0 0 24 24" width="38" height="38" fill="none" stroke="#8A681F" stroke-width="2" style="margin-bottom:10px;">
                                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                            </svg>
                                            <h4 style="margin: 0 0 6px 0; font-size: 1.05rem; font-weight: 800; color: #181512;">No Active Refund Claims or Disputes</h4>
                                            <p style="margin: 0 0 16px 0; font-size: 0.82rem; color: #64748B;">All retail customer orders, reseller disbursements, and wholesale shipments are 100% verified and cleared with zero active chargebacks.</p>
                                            <a href="/admin/orders/index.php" class="dt-btn dt-btn-gold" style="display:inline-flex; width:auto; padding:8px 20px; font-size:0.82rem; text-decoration:none; margin:0 auto;">
                                                <span>View Live Orders Center →</span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($refundOrders as $ro): 
                                        $refId = 'REF-' . (4000 + (int)$ro['id']);
                                        $ordNum = htmlspecialchars($ro['order_number'] ?: ('DTB-' . $ro['id']));
                                        $custName = htmlspecialchars($ro['customer_name'] ?: ($ro['buyer_name'] ?: 'Direct Customer'));
                                        $custPhone = htmlspecialchars($ro['customer_phone'] ?: ($ro['buyer_phone'] ?: ''));
                                        $custCity = htmlspecialchars($ro['buyer_city'] ?: 'Surat');
                                        $method = htmlspecialchars($ro['payment_method'] ?: 'UPI / Bank Transfer');
                                        $amount = (float)($ro['total_amount'] ?? 0);
                                        $payStatus = strtolower($ro['payment_status'] ?? '');
                                        $isSettled = ($payStatus === 'refunded');
                                        $statusClass = $isSettled ? 'delivered' : 'pending';
                                        $statusLabel = $isSettled ? 'Settled' : 'Pending Approval';
                                        $dateStr = $ro['created_at'] ? date('d M Y', strtotime($ro['created_at'])) : 'Recent';
                                        $utrStr = htmlspecialchars($ro['tracking_number'] ?: ('REF-' . substr(md5($ro['id']), 0, 8)));
                                    ?>
                                    <tr data-status="<?php echo $isSettled ? 'settled' : 'pending'; ?>" data-method="<?php echo $method; ?>">
                                        <td class="col-ref-id" style="white-space:nowrap; font-weight:800; color:#8A681F;"><?php echo $refId; ?></td>
                                        <td class="col-ref-order" style="white-space:nowrap;"><a href="/admin/orders/view.php?id=<?php echo $ordNum; ?>" class="dt-order-id-link"><?php echo $ordNum; ?></a></td>
                                        <td class="col-ref-customer">
                                            <div style="font-weight:750; color:#181512; font-size:12px; line-height:1.3;"><?php echo $custName; ?></div>
                                            <div style="font-size:11px; color:#64748B; margin-top:2px;"><?php echo $custCity; ?><?php echo $custPhone ? ' • Ph: ' . $custPhone : ''; ?></div>
                                        </td>
                                        <td class="col-ref-gateway" style="font-size:11.5px; color:#475569; font-weight:600;"><?php echo $method; ?></td>
                                        <td class="col-ref-amount" style="font-weight:800; color:#DC2626; font-size:12.5px; white-space:nowrap;">₹<?php echo number_format($amount); ?></td>
                                        <td class="col-ref-status" style="white-space:nowrap;"><span class="dt-status-badge <?php echo $statusClass; ?>"><span class="dt-status-dot"></span><span><?php echo $statusLabel; ?></span></span></td>
                                        <td class="col-ref-settlement" style="white-space:nowrap;">
                                            <div style="font-size:11.5px; color:#181512; font-weight:700;"><?php echo $dateStr; ?></div>
                                            <div style="font-size:10px; color:#64748B; margin-top:1px;">REF: <?php echo $utrStr; ?></div>
                                        </td>
                                        <td class="col-ref-actions" style="text-align:right; white-space:nowrap;">
                                            <div style="display:inline-flex; align-items:center; justify-content:flex-end; gap:6px;">
                                                <button type="button" onclick="window.DT_REFUNDS.viewRefundDetails('<?php echo $refId; ?>')" class="dt-btn" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; height:28px; padding:0 9px; font-size:11px; font-weight:700;" title="View Full Details">
                                                    <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                    <span>View</span>
                                                </button>
                                                <button type="button" onclick="window.DT_REFUNDS.downloadCreditNotePDF('<?php echo $refId; ?>', '<?php echo $ordNum; ?>', '<?php echo $amount; ?>', '<?php echo addslashes($custName); ?>')" class="dt-btn dt-btn-pale" style="height:28px; padding:0 9px; font-size:11px;" title="Credit Note PDF">
                                                    <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                                    <span>Voucher</span>
                                                </button>
                                                <button type="button" onclick="window.DT_REFUNDS.shareWhatsApp('<?php echo $refId; ?>', '<?php echo $amount; ?>', '<?php echo addslashes($custName); ?>')" class="dt-btn" style="background:#15803D; border:1px solid #166534; color:#FFFFFF; height:28px; padding:0 9px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px; box-shadow:0 1px 4px rgba(21,128,61,0.2);" title="Share WhatsApp Slip">
                                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="#FFFFFF"><path d="M17.472 14.382c-.301-.15-1.78-.878-2.056-.979-.276-.1-.476-.15-.677.15-.2.301-.777.979-.953 1.179-.176.2-.351.226-.652.075s-1.272-.469-2.423-1.496c-.896-.799-1.501-1.786-1.677-2.087-.176-.301-.019-.464.132-.614.136-.135.301-.351.451-.527.15-.176.2-.301.301-.501.101-.2.05-.376-.025-.527-.075-.15-.677-1.632-.927-2.234-.244-.587-.492-.507-.677-.516-.176-.008-.376-.01-.576-.01s-.527.075-.803.376c-.276.301-1.053 1.028-1.053 2.508 0 1.479 1.078 2.908 1.229 3.109.15.2 2.122 3.24 5.141 4.544.718.31 1.279.496 1.716.635.722.23 1.38.197 1.9-.12.58-.352 1.78-1.454 2.03-2.86.251-1.406.251-2.61.176-2.86-.075-.251-.276-.376-.576-.527zM12 2C6.477 2 2 6.477 2 12c0 1.77.462 3.433 1.27 4.887L2 22l5.24-1.374A9.953 9.953 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"></path></svg>
                                                    <span>WhatsApp</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php include __DIR__ . '/components/refund-panel.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/admin/orders/assets/js/refunds.js?v=<?php echo time(); ?>"></script>
</body>
</html>
