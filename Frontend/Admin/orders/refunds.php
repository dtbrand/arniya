<?php
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
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/orders.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/order-list.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/order-status.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/orders/assets/css/refunds.css?v=<?php echo time(); ?>">
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
                        <a href="/Frontend/Admin/orders/index.php" class="dt-btn dt-btn-pale">
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
                    <div style="display:flex; align-items:center; gap:8px; flex:1; min-width:260px;">
                        <div style="position:relative; width:100%;">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#64748B" stroke-width="2.3" style="position:absolute; left:10px; top:50%; transform:translateY(-50%);"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" id="refundSearchInput" oninput="window.DT_REFUNDS.handleSearch(this.value)" placeholder="Search Refund ID, Order ID, Customer, UTR..." class="dt-order-search-input" style="height:34px; padding-left:30px; width:100%; border-radius:6px;">
                            <button type="button" onclick="document.getElementById('refundSearchInput').value=''; window.DT_REFUNDS.handleSearch('');" style="position:absolute; right:8px; top:50%; transform:translateY(-50%); border:none; background:transparent; cursor:pointer; color:#94A3B8; font-size:12px;">✕</button>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <select id="payoutFilterSelect" onchange="window.DT_REFUNDS.filterByMethod(this.value)" class="dt-order-search-input" style="height:34px; font-weight:700; border-radius:6px;">
                            <option value="all">All Payout Methods</option>
                            <option value="ICICI Direct Bank Transfer">ICICI Direct Bank Wire</option>
                            <option value="UPI Reversal">UPI Reversal (PhonePe/GPay)</option>
                            <option value="B2B Wholesale Credit Ledger">B2B Credit Note Ledger</option>
                            <option value="Razorpay Instant Reversal">Razorpay Instant Reversal</option>
                        </select>
                        <button type="button" onclick="window.location.reload();" class="dt-btn dt-btn-pale" style="height:34px;">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                            <span>Refresh</span>
                        </button>
                    </div>
                </div>

                <!-- Master Refund Ledger Table -->
                <div class="dt-order-table-card">
                    <div class="dt-table-responsive" style="overflow-x:auto;">
                        <table class="dt-order-table" style="min-width:920px;" id="refundLedgerTable">
                            <thead>
                                <tr>
                                    <th>Refund ID</th>
                                    <th>Order Ref</th>
                                    <th>Customer &amp; Consignee</th>
                                    <th>Payout Gateway</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Settlement Date / UTR</th>
                                    <th style="text-align:right;">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="refundTableBody">
                                <tr data-status="settled" data-method="ICICI Direct Bank Transfer">
                                    <td style="font-weight:800; color:#8A681F;">REF-4012</td>
                                    <td><a href="/Frontend/Admin/orders/view.php?id=DTB-001612" class="dt-order-id-link">DTB-001612</a></td>
                                    <td>
                                        <div style="font-weight:750; color:#181512;">Meenakshi Silk House</div>
                                        <div style="font-size:10.5px; color:#64748B;">Surat Depot Consignment • Ph: +91 98221 00192</div>
                                    </td>
                                    <td style="font-size:11.5px; color:#475569; font-weight:600;">ICICI Direct Bank Transfer</td>
                                    <td style="font-weight:800; color:#DC2626; font-size:12.5px;">₹14,940</td>
                                    <td><span class="dt-status-badge delivered"><span class="dt-status-dot"></span><span>Settled</span></span></td>
                                    <td>
                                        <div style="font-size:11.5px; color:#181512; font-weight:700;">20 Aug 2026</div>
                                        <div style="font-size:10px; color:#64748B;">UTR: ICICR52026082001</div>
                                    </td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:5px;">
                                            <button type="button" onclick="window.DT_REFUNDS.viewRefundDetails('REF-4012')" class="dt-btn" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; height:28px; padding:0 8px; font-size:10.5px; font-weight:700;" title="View Full Details">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <span>View</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.downloadCreditNotePDF('REF-4012', 'DTB-001612', '14940', 'Meenakshi Silk House')" class="dt-btn dt-btn-pale" style="height:28px; padding:0 8px; font-size:10.5px;" title="Credit Note PDF">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                                <span>Voucher</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.shareWhatsApp('REF-4012', '14940', 'Meenakshi Silk House')" class="dt-btn" style="background:#DCFCE7; border:1px solid #86EFAC; color:#15803D; height:28px; padding:0 8px; font-size:10.5px;" title="WhatsApp Slip">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="#15803D"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr data-status="processing" data-method="UPI Reversal">
                                    <td style="font-weight:800; color:#8A681F;">REF-4011</td>
                                    <td><a href="/Frontend/Admin/orders/view.php?id=DTB-001609" class="dt-order-id-link">DTB-001609</a></td>
                                    <td>
                                        <div style="font-weight:750; color:#181512;">Shweta Joshi</div>
                                        <div style="font-size:10.5px; color:#64748B;">Ahmedabad Retail Order • Ph: +91 98765 43210</div>
                                    </td>
                                    <td style="font-size:11.5px; color:#475569; font-weight:600;">UPI Reversal (PhonePe)</td>
                                    <td style="font-weight:800; color:#DC2626; font-size:12.5px;">₹4,990</td>
                                    <td><span class="dt-status-badge processing"><span class="dt-status-dot"></span><span>In Gateway</span></span></td>
                                    <td>
                                        <div style="font-size:11.5px; color:#181512; font-weight:700;">19 Aug 2026</div>
                                        <div style="font-size:10px; color:#64748B;">REF: UPI-291084-IN</div>
                                    </td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:5px;">
                                            <button type="button" onclick="window.DT_REFUNDS.viewRefundDetails('REF-4011')" class="dt-btn" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; height:28px; padding:0 8px; font-size:10.5px; font-weight:700;" title="View Full Details">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <span>View</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.downloadCreditNotePDF('REF-4011', 'DTB-001609', '4990', 'Shweta Joshi')" class="dt-btn dt-btn-pale" style="height:28px; padding:0 8px; font-size:10.5px;" title="Credit Note PDF">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                                <span>Voucher</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.shareWhatsApp('REF-4011', '4990', 'Shweta Joshi')" class="dt-btn" style="background:#DCFCE7; border:1px solid #86EFAC; color:#15803D; height:28px; padding:0 8px; font-size:10.5px;" title="WhatsApp Slip">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="#15803D"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr data-status="pending" data-method="B2B Wholesale Credit Ledger">
                                    <td style="font-weight:800; color:#8A681F;">REF-4010</td>
                                    <td><a href="/Frontend/Admin/orders/view.php?id=DTB-001605" class="dt-order-id-link">DTB-001605</a></td>
                                    <td>
                                        <div style="font-weight:750; color:#181512;">Kalyan Sarees Wholesale</div>
                                        <div style="font-size:10.5px; color:#64748B;">Loom Defect Claim • Ph: +91 98330 99881</div>
                                    </td>
                                    <td style="font-size:11.5px; color:#475569; font-weight:600;">B2B Wholesale Credit Ledger</td>
                                    <td style="font-weight:800; color:#DC2626; font-size:12.5px;">₹4,490</td>
                                    <td><span class="dt-status-badge pending"><span class="dt-status-dot"></span><span>Pending Approval</span></span></td>
                                    <td>
                                        <div style="font-size:11.5px; color:#181512; font-weight:700;">18 Aug 2026</div>
                                        <div style="font-size:10px; color:#B45309; font-weight:700;">Action Req.</div>
                                    </td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:5px;">
                                            <button type="button" onclick="window.DT_REFUNDS.approveClaim('REF-4010', '4490', 'Kalyan Sarees Wholesale')" class="dt-btn dt-btn-gold" style="height:28px; padding:0 10px; font-size:10.5px;" title="Approve & Credit Balance">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="#181512" stroke-width="2.4"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                                <span>Approve</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.viewRefundDetails('REF-4010')" class="dt-btn" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; height:28px; padding:0 8px; font-size:10.5px; font-weight:700;" title="View Full Details">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <span>View</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.downloadCreditNotePDF('REF-4010', 'DTB-001605', '4490', 'Kalyan Sarees Wholesale')" class="dt-btn dt-btn-pale" style="height:28px; padding:0 8px; font-size:10.5px;" title="Credit Note PDF">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr data-status="settled" data-method="HDFC Bank Wire Transfer">
                                    <td style="font-weight:800; color:#8A681F;">REF-4009</td>
                                    <td><a href="/Frontend/Admin/orders/view.php?id=DTB-001598" class="dt-order-id-link">DTB-001598</a></td>
                                    <td>
                                        <div style="font-weight:750; color:#181512;">Vardhman Tex Godown</div>
                                        <div style="font-size:10.5px; color:#64748B;">Surat Central Depot • Ph: +91 98220 19283</div>
                                    </td>
                                    <td style="font-size:11.5px; color:#475569; font-weight:600;">HDFC Direct Bank Wire</td>
                                    <td style="font-weight:800; color:#DC2626; font-size:12.5px;">₹22,500</td>
                                    <td><span class="dt-status-badge delivered"><span class="dt-status-dot"></span><span>Settled</span></span></td>
                                    <td>
                                        <div style="font-size:11.5px; color:#181512; font-weight:700;">17 Aug 2026</div>
                                        <div style="font-size:10px; color:#64748B;">UTR: HDFCR52026081702</div>
                                    </td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:5px;">
                                            <button type="button" onclick="window.DT_REFUNDS.viewRefundDetails('REF-4009')" class="dt-btn" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; height:28px; padding:0 8px; font-size:10.5px; font-weight:700;" title="View Full Details">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <span>View</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.downloadCreditNotePDF('REF-4009', 'DTB-001598', '22500', 'Vardhman Tex Godown')" class="dt-btn dt-btn-pale" style="height:28px; padding:0 8px; font-size:10.5px;" title="Credit Note PDF">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                                <span>Voucher</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.shareWhatsApp('REF-4009', '22500', 'Vardhman Tex Godown')" class="dt-btn" style="background:#DCFCE7; border:1px solid #86EFAC; color:#15803D; height:28px; padding:0 8px; font-size:10.5px;" title="WhatsApp Slip">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="#15803D"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr data-status="processing" data-method="Razorpay Instant Reversal">
                                    <td style="font-weight:800; color:#8A681F;">REF-4008</td>
                                    <td><a href="/Frontend/Admin/orders/view.php?id=DTB-001590" class="dt-order-id-link">DTB-001590</a></td>
                                    <td>
                                        <div style="font-weight:750; color:#181512;">Pooja Sharma</div>
                                        <div style="font-size:10.5px; color:#64748B;">Mumbai Online Shop • Ph: +91 91981 10001</div>
                                    </td>
                                    <td style="font-size:11.5px; color:#475569; font-weight:600;">Razorpay Instant Reversal</td>
                                    <td style="font-weight:800; color:#DC2626; font-size:12.5px;">₹3,850</td>
                                    <td><span class="dt-status-badge processing"><span class="dt-status-dot"></span><span>In Gateway</span></span></td>
                                    <td>
                                        <div style="font-size:11.5px; color:#181512; font-weight:700;">16 Aug 2026</div>
                                        <div style="font-size:10px; color:#64748B;">REF: RZP-REF-771920</div>
                                    </td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:5px;">
                                            <button type="button" onclick="window.DT_REFUNDS.viewRefundDetails('REF-4008')" class="dt-btn" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; height:28px; padding:0 8px; font-size:10.5px; font-weight:700;" title="View Full Details">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <span>View</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.downloadCreditNotePDF('REF-4008', 'DTB-001590', '3850', 'Pooja Sharma')" class="dt-btn dt-btn-pale" style="height:28px; padding:0 8px; font-size:10.5px;" title="Credit Note PDF">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                                <span>Voucher</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.shareWhatsApp('REF-4008', '3850', 'Pooja Sharma')" class="dt-btn" style="background:#DCFCE7; border:1px solid #86EFAC; color:#15803D; height:28px; padding:0 8px; font-size:10.5px;" title="WhatsApp Slip">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="#15803D"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr data-status="settled" data-method="B2B Wholesale Credit Ledger">
                                    <td style="font-weight:800; color:#8A681F;">REF-4007</td>
                                    <td><a href="/Frontend/Admin/orders/view.php?id=DTB-001582" class="dt-order-id-link">DTB-001582</a></td>
                                    <td>
                                        <div style="font-weight:750; color:#181512;">Ananya Silks Bangalore</div>
                                        <div style="font-size:10.5px; color:#64748B;">B2B Wholesale Lot • Ph: +91 98450 11223</div>
                                    </td>
                                    <td style="font-size:11.5px; color:#475569; font-weight:600;">B2B Wholesale Credit Ledger</td>
                                    <td style="font-weight:800; color:#DC2626; font-size:12.5px;">₹18,200</td>
                                    <td><span class="dt-status-badge delivered"><span class="dt-status-dot"></span><span>Settled</span></span></td>
                                    <td>
                                        <div style="font-size:11.5px; color:#181512; font-weight:700;">15 Aug 2026</div>
                                        <div style="font-size:10px; color:#64748B;">UTR: CR-NOTE-SURAT-099</div>
                                    </td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:5px;">
                                            <button type="button" onclick="window.DT_REFUNDS.viewRefundDetails('REF-4007')" class="dt-btn" style="background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8; height:28px; padding:0 8px; font-size:10.5px; font-weight:700;" title="View Full Details">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                <span>View</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.downloadCreditNotePDF('REF-4007', 'DTB-001582', '18200', 'Ananya Silks Bangalore')" class="dt-btn dt-btn-pale" style="height:28px; padding:0 8px; font-size:10.5px;" title="Credit Note PDF">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                                <span>Voucher</span>
                                            </button>
                                            <button type="button" onclick="window.DT_REFUNDS.shareWhatsApp('REF-4007', '18200', 'Ananya Silks Bangalore')" class="dt-btn" style="background:#DCFCE7; border:1px solid #86EFAC; color:#15803D; height:28px; padding:0 8px; font-size:10.5px;" title="WhatsApp Slip">
                                                <svg viewBox="0 0 24 24" width="11" height="11" fill="#15803D"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2z"></path></svg>
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

<script src="/Frontend/Admin/orders/assets/js/orders.js?v=<?php echo time(); ?>"></script>
<script src="/Frontend/Admin/orders/assets/js/refunds.js?v=<?php echo time(); ?>"></script>
</body>
</html>
