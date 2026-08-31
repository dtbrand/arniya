<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * refunds.php — Refund Management & Credit Notes Ledger
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Refund Management & Credit Notes";
$active_nav = "orders";
$active_subnav = "refunds";
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
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">
            
            <div class="dt-orders-container">
                <div class="dt-orders-head">
                    <div class="dt-orders-title-group">
                        <h1 class="dt-orders-title">
                            <span>Refunds &amp; Credit Notes Ledger</span>
                            <span class="dt-title-counter-badge">
                                <span class="dt-counter-dot" style="background:#8A681F; box-shadow:0 0 0 2px rgba(138,104,31,0.2);"></span>
                                <strong>₹24,420</strong> Settled
                            </span>
                        </h1>
                        <p class="dt-orders-subtitle">Track gateway payouts, UPI chargeback reversals, and B2B wholesale credit ledger balances.</p>
                    </div>
                    <div class="dt-orders-actions">
                        <a href="/admin/orders/index.php" class="dt-btn dt-btn-pale">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="15 18 9 12 15 6"></polyline></svg>
                            <span>Back to Orders</span>
                        </a>
                        <button type="button" onclick="window.DT_REFUNDS.openRefundDrawer('DTB-001624', 112250)" class="dt-btn dt-btn-gold">
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
                            <span class="dt-kpi-main-number">₹24,420</span>
                            <span class="dt-kpi-trend-pill up">100% Audited</span>
                        </div>
                        <div class="dt-kpi-footer">
                            <span>6 Total Claims • 0 Disputes</span>
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
                            <span class="dt-kpi-main-number">₹4,490</span>
                            <span class="dt-kpi-trend-pill amber">1 Action Req.</span>
                        </div>
                        <div class="dt-kpi-footer">
                            <span>Kalyan Sarees • Defect Review</span>
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
                            <span class="dt-kpi-main-number">₹8,840</span>
                            <span class="dt-kpi-trend-pill blue">2 Processing</span>
                        </div>
                        <div class="dt-kpi-footer">
                            <span>PhonePe UPI &amp; Razorpay</span>
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
                            <span class="dt-kpi-main-number">3 Notes</span>
                            <span class="dt-kpi-trend-pill emerald">Active Ledger</span>
                        </div>
                        <div class="dt-kpi-footer">
                            <span>₹33,140 Wholesale Ledger Bal.</span>
                            <span class="dt-kpi-arrow">→</span>
                        </div>
                    </div>
                </div>

                <!-- Interactive Subnav Filter Pills -->
                <div class="dt-refund-subnav">
                    <button type="button" onclick="window.DT_REFUNDS.filterByStatus('all', this)" class="dt-refund-subnav-pill active">All Refunds <small>6</small></button>
                    <button type="button" onclick="window.DT_REFUNDS.filterByStatus('pending', this)" class="dt-refund-subnav-pill">Pending Approval <small>1</small></button>
                    <button type="button" onclick="window.DT_REFUNDS.filterByStatus('processing', this)" class="dt-refund-subnav-pill">Gateway Processing <small>2</small></button>
                    <button type="button" onclick="window.DT_REFUNDS.filterByStatus('settled', this)" class="dt-refund-subnav-pill">Settled &amp; Cleared <small>3</small></button>
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
                            <option value="ICICI Direct Bank Transfer">ICICI Direct Bank Wire</option>
                            <option value="UPI Reversal">UPI Reversal (PhonePe/GPay)</option>
                            <option value="B2B Wholesale Credit Ledger">B2B Credit Note Ledger</option>
                            <option value="Razorpay Instant Reversal">Razorpay Instant Reversal</option>
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
                                <tr data-status="settled" data-method="ICICI Direct Bank Transfer">
                                    <td class="col-ref-id" style="white-space:nowrap; font-weight:800; color:#8A681F;">REF-4012</td>
                                    <td class="col-ref-order" style="white-space:nowrap;"><a href="/admin/orders/view.php?id=DTB-001612" class="dt-order-id-link">DTB-001612</a></td>
                                    <td class="col-ref-customer">
                                        <div style="font-weight:750; color:#181512; font-size:12px; line-height:1.3;">Meenakshi Silk House</div>
                                        <div style="font-size:11px; color:#64748B; margin-top:2px;">Surat Depot • Ph: +91 70463 63528</div>
                                    </td>
                                    <td class="col-ref-gateway" style="font-size:11.5px; color:#475569; font-weight:600;">ICICI Direct Bank Transfer</td>
                                    <td class="col-ref-amount" style="font-weight:800; color:#DC2626; font-size:12.5px; white-space:nowrap;">₹14,940</td>
                                    <td class="col-ref-status" style="white-space:nowrap;"><span class="dt-status-badge delivered"><span class="dt-status-dot"></span><span>Settled</span></span></td>
                                    <td class="col-ref-settlement" style="white-space:nowrap;">
                                        <div style="font-size:11.5px; color:#181512; font-weight:700;">20 Aug 2026</div>
                                        <div style="font-size:10px; color:#64748B; margin-top:1px;">UTR: ICICR52026082001</div>
                                    </td>
                                    <td class="col-ref-actions" style="text-align:right; white-space:nowrap;">
                                        <div style="display:inline-flex; align-items:center; justify-content:flex-end; gap:6px;">
                                            <button type="button" onclick="window.DT_REFUNDS.viewRefundDetails('REF-4012')" class="dt-btn" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; height:28px; padding:0 9px; font-size:11px; font-weight:700;" title="View Full Details">
                                                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <span>View</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.downloadCreditNotePDF('REF-4012', 'DTB-001612', '14940', 'Meenakshi Silk House')" class="dt-btn dt-btn-pale" style="height:28px; padding:0 9px; font-size:11px;" title="Credit Note PDF">
                                                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                                <span>Voucher</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.shareWhatsApp('REF-4012', '14940', 'Meenakshi Silk House')" class="dt-btn" style="background:#15803D; border:1px solid #166534; color:#FFFFFF; height:28px; padding:0 9px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px; box-shadow:0 1px 4px rgba(21,128,61,0.2);" title="Share WhatsApp Slip">
                                                <svg viewBox="0 0 24 24" width="12" height="12" fill="#FFFFFF"><path d="M17.472 14.382c-.301-.15-1.78-.878-2.056-.979-.276-.1-.476-.15-.677.15-.2.301-.777.979-.953 1.179-.176.2-.351.226-.652.075s-1.272-.469-2.423-1.496c-.896-.799-1.501-1.786-1.677-2.087-.176-.301-.019-.464.132-.614.136-.135.301-.351.451-.527.15-.176.2-.301.301-.501.101-.2.05-.376-.025-.527-.075-.15-.677-1.632-.927-2.234-.244-.587-.492-.507-.677-.516-.176-.008-.376-.01-.576-.01s-.527.075-.803.376c-.276.301-1.053 1.028-1.053 2.508 0 1.479 1.078 2.908 1.229 3.109.15.2 2.122 3.24 5.141 4.544.718.31 1.279.496 1.716.635.722.23 1.38.197 1.9-.12.58-.352 1.78-1.454 2.03-2.86.251-1.406.251-2.61.176-2.86-.075-.251-.276-.376-.576-.527zM12 2C6.477 2 2 6.477 2 12c0 1.77.462 3.433 1.27 4.887L2 22l5.24-1.374A9.953 9.953 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"></path></svg>
                                                <span>WhatsApp</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr data-status="processing" data-method="UPI Reversal">
                                    <td class="col-ref-id" style="white-space:nowrap; font-weight:800; color:#8A681F;">REF-4011</td>
                                    <td class="col-ref-order" style="white-space:nowrap;"><a href="/admin/orders/view.php?id=DTB-001609" class="dt-order-id-link">DTB-001609</a></td>
                                    <td class="col-ref-customer">
                                        <div style="font-weight:750; color:#181512; font-size:12px; line-height:1.3;">Shweta Joshi</div>
                                        <div style="font-size:11px; color:#64748B; margin-top:2px;">Ahmedabad Order • Ph: +91 70463 63528</div>
                                    </td>
                                    <td class="col-ref-gateway" style="font-size:11.5px; color:#475569; font-weight:600;">UPI Reversal (PhonePe)</td>
                                    <td class="col-ref-amount" style="font-weight:800; color:#DC2626; font-size:12.5px; white-space:nowrap;">₹4,990</td>
                                    <td class="col-ref-status" style="white-space:nowrap;"><span class="dt-status-badge processing"><span class="dt-status-dot"></span><span>In Gateway</span></span></td>
                                    <td class="col-ref-settlement" style="white-space:nowrap;">
                                        <div style="font-size:11.5px; color:#181512; font-weight:700;">19 Aug 2026</div>
                                        <div style="font-size:10px; color:#64748B; margin-top:1px;">REF: UPI-291084-IN</div>
                                    </td>
                                    <td class="col-ref-actions" style="text-align:right; white-space:nowrap;">
                                        <div style="display:inline-flex; align-items:center; justify-content:flex-end; gap:6px;">
                                            <button type="button" onclick="window.DT_REFUNDS.viewRefundDetails('REF-4011')" class="dt-btn" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; height:28px; padding:0 9px; font-size:11px; font-weight:700;" title="View Full Details">
                                                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <span>View</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.downloadCreditNotePDF('REF-4011', 'DTB-001609', '4990', 'Shweta Joshi')" class="dt-btn dt-btn-pale" style="height:28px; padding:0 9px; font-size:11px;" title="Credit Note PDF">
                                                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                                <span>Voucher</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.shareWhatsApp('REF-4011', '4990', 'Shweta Joshi')" class="dt-btn" style="background:#15803D; border:1px solid #166534; color:#FFFFFF; height:28px; padding:0 9px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px; box-shadow:0 1px 4px rgba(21,128,61,0.2);" title="Share WhatsApp Slip">
                                                <svg viewBox="0 0 24 24" width="12" height="12" fill="#FFFFFF"><path d="M17.472 14.382c-.301-.15-1.78-.878-2.056-.979-.276-.1-.476-.15-.677.15-.2.301-.777.979-.953 1.179-.176.2-.351.226-.652.075s-1.272-.469-2.423-1.496c-.896-.799-1.501-1.786-1.677-2.087-.176-.301-.019-.464.132-.614.136-.135.301-.351.451-.527.15-.176.2-.301.301-.501.101-.2.05-.376-.025-.527-.075-.15-.677-1.632-.927-2.234-.244-.587-.492-.507-.677-.516-.176-.008-.376-.01-.576-.01s-.527.075-.803.376c-.276.301-1.053 1.028-1.053 2.508 0 1.479 1.078 2.908 1.229 3.109.15.2 2.122 3.24 5.141 4.544.718.31 1.279.496 1.716.635.722.23 1.38.197 1.9-.12.58-.352 1.78-1.454 2.03-2.86.251-1.406.251-2.61.176-2.86-.075-.251-.276-.376-.576-.527zM12 2C6.477 2 2 6.477 2 12c0 1.77.462 3.433 1.27 4.887L2 22l5.24-1.374A9.953 9.953 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"></path></svg>
                                                <span>WhatsApp</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr data-status="pending" data-method="B2B Wholesale Credit Ledger">
                                    <td class="col-ref-id" style="white-space:nowrap; font-weight:800; color:#8A681F;">REF-4010</td>
                                    <td class="col-ref-order" style="white-space:nowrap;"><a href="/admin/orders/view.php?id=DTB-001605" class="dt-order-id-link">DTB-001605</a></td>
                                    <td class="col-ref-customer">
                                        <div style="font-weight:750; color:#181512; font-size:12px; line-height:1.3;">Kalyan Sarees Wholesale</div>
                                        <div style="font-size:11px; color:#64748B; margin-top:2px;">Loom Defect Claim • Ph: +91 70463 63528</div>
                                    </td>
                                    <td class="col-ref-gateway" style="font-size:11.5px; color:#475569; font-weight:600;">B2B Wholesale Credit Ledger</td>
                                    <td class="col-ref-amount" style="font-weight:800; color:#DC2626; font-size:12.5px; white-space:nowrap;">₹4,490</td>
                                    <td class="col-ref-status" style="white-space:nowrap;"><span class="dt-status-badge pending"><span class="dt-status-dot"></span><span>Pending Approval</span></span></td>
                                    <td class="col-ref-settlement" style="white-space:nowrap;">
                                        <div style="font-size:11.5px; color:#181512; font-weight:700;">18 Aug 2026</div>
                                        <div style="font-size:10px; color:#B45309; font-weight:700; margin-top:1px;">Action Req.</div>
                                    </td>
                                    <td class="col-ref-actions" style="text-align:right; white-space:nowrap;">
                                        <div style="display:inline-flex; align-items:center; justify-content:flex-end; gap:6px;">
                                            <button type="button" onclick="window.DT_REFUNDS.approveClaim('REF-4010', '4490', 'Kalyan Sarees Wholesale')" class="dt-btn dt-btn-gold" style="height:28px; padding:0 10px; font-size:11px;" title="Approve & Credit Balance">
                                                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="#181512" stroke-width="2.4"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                <span>Approve</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.viewRefundDetails('REF-4010')" class="dt-btn" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; height:28px; padding:0 9px; font-size:11px; font-weight:700;" title="View Full Details">
                                                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <span>View</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.downloadCreditNotePDF('REF-4010', 'DTB-001605', '4490', 'Kalyan Sarees Wholesale')" class="dt-btn dt-btn-pale" style="height:28px; padding:0 9px; font-size:11px;" title="Credit Note PDF">
                                                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                                <span>Voucher</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.shareWhatsApp('REF-4010', '4490', 'Kalyan Sarees Wholesale')" class="dt-btn" style="background:#15803D; border:1px solid #166534; color:#FFFFFF; height:28px; padding:0 9px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px; box-shadow:0 1px 4px rgba(21,128,61,0.2);" title="Share WhatsApp Slip">
                                                <svg viewBox="0 0 24 24" width="12" height="12" fill="#FFFFFF"><path d="M17.472 14.382c-.301-.15-1.78-.878-2.056-.979-.276-.1-.476-.15-.677.15-.2.301-.777.979-.953 1.179-.176.2-.351.226-.652.075s-1.272-.469-2.423-1.496c-.896-.799-1.501-1.786-1.677-2.087-.176-.301-.019-.464.132-.614.136-.135.301-.351.451-.527.15-.176.2-.301.301-.501.101-.2.05-.376-.025-.527-.075-.15-.677-1.632-.927-2.234-.244-.587-.492-.507-.677-.516-.176-.008-.376-.01-.576-.01s-.527.075-.803.376c-.276.301-1.053 1.028-1.053 2.508 0 1.479 1.078 2.908 1.229 3.109.15.2 2.122 3.24 5.141 4.544.718.31 1.279.496 1.716.635.722.23 1.38.197 1.9-.12.58-.352 1.78-1.454 2.03-2.86.251-1.406.251-2.61.176-2.86-.075-.251-.276-.376-.576-.527zM12 2C6.477 2 2 6.477 2 12c0 1.77.462 3.433 1.27 4.887L2 22l5.24-1.374A9.953 9.953 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"></path></svg>
                                                <span>WhatsApp</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr data-status="settled" data-method="HDFC Bank Wire Transfer">
                                    <td class="col-ref-id" style="white-space:nowrap; font-weight:800; color:#8A681F;">REF-4009</td>
                                    <td class="col-ref-order" style="white-space:nowrap;"><a href="/admin/orders/view.php?id=DTB-001598" class="dt-order-id-link">DTB-001598</a></td>
                                    <td class="col-ref-customer">
                                        <div style="font-weight:750; color:#181512; font-size:12px; line-height:1.3;">Vardhman Tex Godown</div>
                                        <div style="font-size:11px; color:#64748B; margin-top:2px;">Surat Central Depot • Ph: +91 70463 63528</div>
                                    </td>
                                    <td class="col-ref-gateway" style="font-size:11.5px; color:#475569; font-weight:600;">HDFC Direct Bank Wire</td>
                                    <td class="col-ref-amount" style="font-weight:800; color:#DC2626; font-size:12.5px; white-space:nowrap;">₹22,500</td>
                                    <td class="col-ref-status" style="white-space:nowrap;"><span class="dt-status-badge delivered"><span class="dt-status-dot"></span><span>Settled</span></span></td>
                                    <td class="col-ref-settlement" style="white-space:nowrap;">
                                        <div style="font-size:11.5px; color:#181512; font-weight:700;">17 Aug 2026</div>
                                        <div style="font-size:10px; color:#64748B; margin-top:1px;">UTR: HDFCR52026081702</div>
                                    </td>
                                    <td class="col-ref-actions" style="text-align:right; white-space:nowrap;">
                                        <div style="display:inline-flex; align-items:center; justify-content:flex-end; gap:6px;">
                                            <button type="button" onclick="window.DT_REFUNDS.viewRefundDetails('REF-4009')" class="dt-btn" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; height:28px; padding:0 9px; font-size:11px; font-weight:700;" title="View Full Details">
                                                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <span>View</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.downloadCreditNotePDF('REF-4009', 'DTB-001598', '22500', 'Vardhman Tex Godown')" class="dt-btn dt-btn-pale" style="height:28px; padding:0 9px; font-size:11px;" title="Credit Note PDF">
                                                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                                <span>Voucher</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.shareWhatsApp('REF-4009', '22500', 'Vardhman Tex Godown')" class="dt-btn" style="background:#15803D; border:1px solid #166534; color:#FFFFFF; height:28px; padding:0 9px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px; box-shadow:0 1px 4px rgba(21,128,61,0.2);" title="Share WhatsApp Slip">
                                                <svg viewBox="0 0 24 24" width="12" height="12" fill="#FFFFFF"><path d="M17.472 14.382c-.301-.15-1.78-.878-2.056-.979-.276-.1-.476-.15-.677.15-.2.301-.777.979-.953 1.179-.176.2-.351.226-.652.075s-1.272-.469-2.423-1.496c-.896-.799-1.501-1.786-1.677-2.087-.176-.301-.019-.464.132-.614.136-.135.301-.351.451-.527.15-.176.2-.301.301-.501.101-.2.05-.376-.025-.527-.075-.15-.677-1.632-.927-2.234-.244-.587-.492-.507-.677-.516-.176-.008-.376-.01-.576-.01s-.527.075-.803.376c-.276.301-1.053 1.028-1.053 2.508 0 1.479 1.078 2.908 1.229 3.109.15.2 2.122 3.24 5.141 4.544.718.31 1.279.496 1.716.635.722.23 1.38.197 1.9-.12.58-.352 1.78-1.454 2.03-2.86.251-1.406.251-2.61.176-2.86-.075-.251-.276-.376-.576-.527zM12 2C6.477 2 2 6.477 2 12c0 1.77.462 3.433 1.27 4.887L2 22l5.24-1.374A9.953 9.953 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"></path></svg>
                                                <span>WhatsApp</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr data-status="processing" data-method="Razorpay Instant Reversal">
                                    <td class="col-ref-id" style="white-space:nowrap; font-weight:800; color:#8A681F;">REF-4008</td>
                                    <td class="col-ref-order" style="white-space:nowrap;"><a href="/admin/orders/view.php?id=DTB-001590" class="dt-order-id-link">DTB-001590</a></td>
                                    <td class="col-ref-customer">
                                        <div style="font-weight:750; color:#181512; font-size:12px; line-height:1.3;">Pooja Sharma</div>
                                        <div style="font-size:11px; color:#64748B; margin-top:2px;">Mumbai Online Shop • Ph: +91 70463 63528</div>
                                    </td>
                                    <td class="col-ref-gateway" style="font-size:11.5px; color:#475569; font-weight:600;">Razorpay Instant Reversal</td>
                                    <td class="col-ref-amount" style="font-weight:800; color:#DC2626; font-size:12.5px; white-space:nowrap;">₹3,850</td>
                                    <td class="col-ref-status" style="white-space:nowrap;"><span class="dt-status-badge processing"><span class="dt-status-dot"></span><span>In Gateway</span></span></td>
                                    <td class="col-ref-settlement" style="white-space:nowrap;">
                                        <div style="font-size:11.5px; color:#181512; font-weight:700;">16 Aug 2026</div>
                                        <div style="font-size:10px; color:#64748B; margin-top:1px;">REF: RZP-REF-771920</div>
                                    </td>
                                    <td class="col-ref-actions" style="text-align:right; white-space:nowrap;">
                                        <div style="display:inline-flex; align-items:center; justify-content:flex-end; gap:6px;">
                                            <button type="button" onclick="window.DT_REFUNDS.viewRefundDetails('REF-4008')" class="dt-btn" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; height:28px; padding:0 9px; font-size:11px; font-weight:700;" title="View Full Details">
                                                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <span>View</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.downloadCreditNotePDF('REF-4008', 'DTB-001590', '3850', 'Pooja Sharma')" class="dt-btn dt-btn-pale" style="height:28px; padding:0 9px; font-size:11px;" title="Credit Note PDF">
                                                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                                <span>Voucher</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.shareWhatsApp('REF-4008', '3850', 'Pooja Sharma')" class="dt-btn" style="background:#15803D; border:1px solid #166534; color:#FFFFFF; height:28px; padding:0 9px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px; box-shadow:0 1px 4px rgba(21,128,61,0.2);" title="Share WhatsApp Slip">
                                                <svg viewBox="0 0 24 24" width="12" height="12" fill="#FFFFFF"><path d="M17.472 14.382c-.301-.15-1.78-.878-2.056-.979-.276-.1-.476-.15-.677.15-.2.301-.777.979-.953 1.179-.176.2-.351.226-.652.075s-1.272-.469-2.423-1.496c-.896-.799-1.501-1.786-1.677-2.087-.176-.301-.019-.464.132-.614.136-.135.301-.351.451-.527.15-.176.2-.301.301-.501.101-.2.05-.376-.025-.527-.075-.15-.677-1.632-.927-2.234-.244-.587-.492-.507-.677-.516-.176-.008-.376-.01-.576-.01s-.527.075-.803.376c-.276.301-1.053 1.028-1.053 2.508 0 1.479 1.078 2.908 1.229 3.109.15.2 2.122 3.24 5.141 4.544.718.31 1.279.496 1.716.635.722.23 1.38.197 1.9-.12.58-.352 1.78-1.454 2.03-2.86.251-1.406.251-2.61.176-2.86-.075-.251-.276-.376-.576-.527zM12 2C6.477 2 2 6.477 2 12c0 1.77.462 3.433 1.27 4.887L2 22l5.24-1.374A9.953 9.953 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"></path></svg>
                                                <span>WhatsApp</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr data-status="settled" data-method="B2B Wholesale Credit Ledger">
                                    <td class="col-ref-id" style="white-space:nowrap; font-weight:800; color:#8A681F;">REF-4007</td>
                                    <td class="col-ref-order" style="white-space:nowrap;"><a href="/admin/orders/view.php?id=DTB-001582" class="dt-order-id-link">DTB-001582</a></td>
                                    <td class="col-ref-customer">
                                        <div style="font-weight:750; color:#181512; font-size:12px; line-height:1.3;">Ananya Silks Bangalore</div>
                                        <div style="font-size:11px; color:#64748B; margin-top:2px;">B2B Wholesale • Ph: +91 70463 63528</div>
                                    </td>
                                    <td class="col-ref-gateway" style="font-size:11.5px; color:#475569; font-weight:600;">B2B Wholesale Credit Ledger</td>
                                    <td class="col-ref-amount" style="font-weight:800; color:#DC2626; font-size:12.5px; white-space:nowrap;">₹18,200</td>
                                    <td class="col-ref-status" style="white-space:nowrap;"><span class="dt-status-badge delivered"><span class="dt-status-dot"></span><span>Settled</span></span></td>
                                    <td class="col-ref-settlement" style="white-space:nowrap;">
                                        <div style="font-size:11.5px; color:#181512; font-weight:700;">15 Aug 2026</div>
                                        <div style="font-size:10px; color:#64748B; margin-top:1px;">UTR: CR-NOTE-SURAT-099</div>
                                    </td>
                                    <td class="col-ref-actions" style="text-align:right; white-space:nowrap;">
                                        <div style="display:inline-flex; align-items:center; justify-content:flex-end; gap:6px;">
                                            <button type="button" onclick="window.DT_REFUNDS.viewRefundDetails('REF-4007')" class="dt-btn" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; height:28px; padding:0 9px; font-size:11px; font-weight:700;" title="View Full Details">
                                                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <span>View</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.downloadCreditNotePDF('REF-4007', 'DTB-001582', '18200', 'Ananya Silks Bangalore')" class="dt-btn dt-btn-pale" style="height:28px; padding:0 9px; font-size:11px;" title="Credit Note PDF">
                                                <svg viewBox="0 0 24 24" width="11.5" height="11.5" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                                <span>Voucher</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.shareWhatsApp('REF-4007', '18200', 'Ananya Silks Bangalore')" class="dt-btn" style="background:#15803D; border:1px solid #166534; color:#FFFFFF; height:28px; padding:0 9px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px; box-shadow:0 1px 4px rgba(21,128,61,0.2);" title="Share WhatsApp Slip">
                                                <svg viewBox="0 0 24 24" width="12" height="12" fill="#FFFFFF"><path d="M17.472 14.382c-.301-.15-1.78-.878-2.056-.979-.276-.1-.476-.15-.677.15-.2.301-.777.979-.953 1.179-.176.2-.351.226-.652.075s-1.272-.469-2.423-1.496c-.896-.799-1.501-1.786-1.677-2.087-.176-.301-.019-.464.132-.614.136-.135.301-.351.451-.527.15-.176.2-.301.301-.501.101-.2.05-.376-.025-.527-.075-.15-.677-1.632-.927-2.234-.244-.587-.492-.507-.677-.516-.176-.008-.376-.01-.576-.01s-.527.075-.803.376c-.276.301-1.053 1.028-1.053 2.508 0 1.479 1.078 2.908 1.229 3.109.15.2 2.122 3.24 5.141 4.544.718.31 1.279.496 1.716.635.722.23 1.38.197 1.9-.12.58-.352 1.78-1.454 2.03-2.86.251-1.406.251-2.61.176-2.86-.075-.251-.276-.376-.576-.527zM12 2C6.477 2 2 6.477 2 12c0 1.77.462 3.433 1.27 4.887L2 22l5.24-1.374A9.953 9.953 0 0 0 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"></path></svg>
                                                <span>WhatsApp</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php include __DIR__ . '/components/refund-panel.php'; ?>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/admin/orders/assets/js/refunds.js?v=<?php echo time(); ?>"></script>
</body>
</html>
