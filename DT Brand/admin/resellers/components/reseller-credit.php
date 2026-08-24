<?php
/**
 * reseller-credit.php — DT Brand's & Jai Hanuman Tex
 * Master Luxury Credit Limit, Wallet Balance & Ledger Audit Component
 */
$sanctioned_limit = 150000;
$utilized_credit = 65000;
$available_credit = $sanctioned_limit - $utilized_credit;
$utilization_pct = round(($utilized_credit / $sanctioned_limit) * 100, 1);
$available_pct = round(100 - $utilization_pct, 1);

$credit_logs = [
    [
        'id' => 'TXN-8821',
        'date' => '20 Aug 2026, 04:30 PM',
        'category' => 'debit',
        'type' => 'Debit (Order ORD-9842)',
        'order_ref' => 'ORD-9842',
        'amount' => -14800,
        'balance' => 65000,
        'available' => 85000,
        'status' => 'Completed',
        'actor' => 'Automated Order Checkout'
    ],
    [
        'id' => 'TXN-8790',
        'date' => '15 Aug 2026, 11:15 AM',
        'category' => 'credit',
        'type' => 'Credit Settlement (ICICI Bank Transfer)',
        'order_ref' => 'UTR #ICIC99824102',
        'amount' => 50000,
        'balance' => 50200,
        'available' => 99800,
        'status' => 'Settled',
        'actor' => 'Staff Rajesh (Accountant)'
    ],
    [
        'id' => 'TXN-8765',
        'date' => '10 Aug 2026, 02:45 PM',
        'category' => 'debit',
        'type' => 'Debit (Order ORD-9780 - Silk Lot)',
        'order_ref' => 'ORD-9780',
        'amount' => -38200,
        'balance' => 100200,
        'available' => 49800,
        'status' => 'Completed',
        'actor' => 'B2B Wholesale Portal'
    ],
    [
        'id' => 'TXN-8740',
        'date' => '05 Aug 2026, 05:20 PM',
        'category' => 'credit',
        'type' => 'Advance RTGS Settlement (HDFC)',
        'order_ref' => 'UTR #HDFC22910488',
        'amount' => 40000,
        'balance' => 62000,
        'available' => 88000,
        'status' => 'Settled',
        'actor' => 'Finance Desk'
    ],
    [
        'id' => 'TXN-8712',
        'date' => '01 Aug 2026, 12:00 AM',
        'category' => 'renewal',
        'type' => 'Monthly Revolving Limit Renewal',
        'order_ref' => 'SYS-CYCLE-08',
        'amount' => 150000,
        'balance' => 0,
        'available' => 150000,
        'status' => 'Completed',
        'actor' => 'System Cron'
    ]
];
?>

<div style="display:flex; flex-direction:column; gap:14px;">
    <!-- ══════════════════════════════════════════════════════════════
         MASTER LUXURY GOLD & SILVER AMBIENT GLASS HERO BANNER
    ══════════════════════════════════════════════════════════════ -->
    <div class="dt-credit-luxury-hero">
        <div class="dt-credit-metrics-strip">
            <!-- Left Info -->
            <div style="flex:1; min-width:240px;">
                <div style="display:flex; align-items:center; gap:6px; margin-bottom:3px;">
                    <span class="dt-cust-badge gold" style="font-size:0.68rem; padding:2px 8px; border-radius:4px; background:rgba(212,175,55,0.15); color:#FFE57F; border:1px solid #D4AF37; font-weight:800;">
                        RESELLER B2B CREDIT FACILITY
                    </span>
                </div>
                <h3 style="font-size:1.15rem; font-weight:900; color:#FFFFFF; margin:0; text-shadow:0 2px 4px rgba(0,0,0,0.5);">
                    30-Day Revolving Working Capital Line
                </h3>
                <p style="font-size:0.72rem; color:#FEE685; margin:3px 0 0 0; font-weight:600;">
                    ✓ 100% On-Time Payment Record • Zero Default Risk
                </p>
            </div>

            <!-- 3 Stat Cards -->
            <div class="dt-credit-boxes-group">
                <!-- Sanctioned -->
                <div class="dt-credit-stat-card">
                    <span style="font-size:0.62rem; color:#F5ECCE; font-weight:800; text-transform:uppercase;">Sanctioned</span>
                    <strong id="heroSanctionedLimit" style="font-size:1.15rem; font-weight:900; color:#FFFFFF; line-height:1.2;">₹<?php echo number_format($sanctioned_limit); ?></strong>
                </div>

                <!-- Utilized -->
                <div class="dt-credit-stat-card">
                    <span style="font-size:0.62rem; color:#F5ECCE; font-weight:800; text-transform:uppercase;">Utilized</span>
                    <strong id="heroUtilizedCredit" style="font-size:1.15rem; font-weight:900; color:#FFE57F; line-height:1.2;">₹<?php echo number_format($utilized_credit); ?></strong>
                </div>

                <!-- Available -->
                <div class="dt-credit-stat-card emerald">
                    <span style="font-size:0.62rem; color:#86EFAC; font-weight:800; text-transform:uppercase;">Available</span>
                    <strong id="heroAvailableCredit" style="font-size:1.15rem; font-weight:900; color:#86EFAC; line-height:1.2;">₹<?php echo number_format($available_credit); ?></strong>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display:flex; align-items:center; gap:8px;">
                <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="openCreditAdjustmentModal('RES-1048', <?php echo $sanctioned_limit; ?>, <?php echo $utilized_credit; ?>)">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    <span>Adjust Limit</span>
                </button>
                <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" onclick="openRecordSettlementModal('RES-1048', <?php echo $utilized_credit; ?>)">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#FFFFFF" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Record Settlement</span>
                </button>
            </div>
        </div>

        <!-- Visual Utilization Progress Bar -->
        <div style="display:flex; flex-direction:column; gap:5px; border-top:1px solid rgba(212, 175, 55, 0.2); padding-top:10px;">
            <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.72rem;">
                <span style="color:#F5ECCE; font-weight:700;">Credit Line Utilization: <strong id="progressPctText" style="color:#FFE57F;"><?php echo $utilization_pct; ?>% Used</strong></span>
                <span style="color:#86EFAC; font-weight:700;">Available Headroom: <strong id="progressAvailText"><?php echo $available_pct; ?>% (₹<?php echo number_format($available_credit); ?>)</strong></span>
            </div>
            <div class="dt-credit-progress-wrap">
                <div id="creditUtilizationProgressBar" class="dt-credit-progress-bar" style="width:<?php echo $utilization_pct; ?>%;"></div>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════════
         TRANSACTION & CREDIT LEDGER AUDIT CARD
    ══════════════════════════════════════════════════════════════ -->
    <div class="dt-card" style="background:#FFFFFF; border:1.5px solid #EAE5D9; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.02); overflow:hidden;">
        <!-- Toolbar Header -->
        <div style="padding:12px 16px; border-bottom:1.5px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:28px; height:28px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.4"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                </div>
                <div>
                    <h4 style="font-size:0.9rem; font-weight:800; color:#181512; margin:0;">Transaction &amp; Credit Ledger Audit</h4>
                    <p style="font-size:0.7rem; color:#78716C; margin:1px 0 0 0;">Immutable double-entry log of order debits, settlements, and credit renewals.</p>
                </div>
            </div>

            <!-- Filter & Search Controls -->
            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                <!-- Live Search Box -->
                <div style="position:relative; width:200px;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#78716C" stroke-width="2.2" style="position:absolute; left:9px; top:50%; transform:translateY(-50%); pointer-events:none;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" id="ledgerSearchInput" class="dt-cust-search-input" style="width:100%; height:30px; padding-left:28px; font-size:0.72rem;" placeholder="Search Txn, Order, UTR..." oninput="filterCreditLedger()">
                </div>

                <!-- Type Filter -->
                <select id="ledgerTypeFilter" class="dt-cust-select" style="height:30px; font-size:0.72rem; padding:0 8px; border-radius:6px;" onchange="filterCreditLedger()">
                    <option value="all">All Types</option>
                    <option value="debit">Debits (Orders)</option>
                    <option value="credit">Credits (Settlements)</option>
                    <option value="renewal">Limit Renewals</option>
                </select>

                <!-- Export Button -->
                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="exportLedgerStatement()">
                    <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    <span>Export</span>
                </button>
            </div>
        </div>

        <!-- Ledger Table -->
        <div style="overflow-x:auto; width:100%;">
            <table class="dt-credit-ledger-table">
                <thead>
                    <tr>
                        <th style="white-space:nowrap;">Txn ID</th>
                        <th style="white-space:nowrap;">Date &amp; Time</th>
                        <th style="white-space:nowrap;">Description / Reference</th>
                        <th style="text-align:right; white-space:nowrap;">Amount (₹)</th>
                        <th style="text-align:right; white-space:nowrap;">Running Utilized</th>
                        <th style="text-align:right; white-space:nowrap;">Available Credit</th>
                        <th style="white-space:nowrap;">Status</th>
                        <th style="white-space:nowrap;">Authorized By</th>
                        <th style="text-align:right; white-space:nowrap;">Action</th>
                    </tr>
                </thead>
                <tbody id="creditLedgerTbody">
                    <?php foreach ($credit_logs as $l): ?>
                        <tr class="ledger-row-item" data-type="<?php echo $l['category']; ?>" style="border-bottom:1px solid #F1ECE1;">
                            <td class="ledger-id-cell" style="font-family:monospace; font-weight:800; color:#8A681F; white-space:nowrap;"><?php echo $l['id']; ?></td>
                            <td style="color:#78716C; font-size:0.72rem; white-space:nowrap;"><?php echo $l['date']; ?></td>
                            <td class="ledger-desc-cell" style="font-weight:700; color:#181512; white-space:nowrap;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span><?php echo htmlspecialchars($l['type']); ?></span>
                                    <small style="font-size:0.68rem; color:#78716C; font-weight:600; font-family:monospace; background:#FAF5E8; padding:1px 6px; border-radius:4px; border:1px solid #EAE5D9;"><?php echo htmlspecialchars($l['order_ref']); ?></small>
                                </div>
                            </td>
                            <td style="text-align:right; font-weight:800; font-size:0.85rem; color:<?php echo $l['amount'] < 0 ? '#DC2626' : '#15803D'; ?>; white-space:nowrap;">
                                <?php echo ($l['amount'] > 0 ? '+' : '-') . '₹' . number_format(abs($l['amount'])); ?>
                            </td>
                            <td style="text-align:right; font-weight:800; color:#181512; white-space:nowrap;">₹<?php echo number_format($l['balance']); ?></td>
                            <td style="text-align:right; font-weight:800; color:#15803D; white-space:nowrap;">₹<?php echo number_format($l['available']); ?></td>
                            <td style="white-space:nowrap;">
                                <span class="dt-status-pill-clean emerald">
                                    <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    <span><?php echo strtoupper($l['status']); ?></span>
                                </span>
                            </td>
                            <td style="color:#78716C; font-size:0.72rem; white-space:nowrap;"><?php echo htmlspecialchars($l['actor']); ?></td>
                            <td style="text-align:right; white-space:nowrap;">
                                <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="viewTxnVoucher('<?php echo $l['id']; ?>', '<?php echo addslashes($l['type']); ?>', '<?php echo ($l['amount'] > 0 ? '+' : '-') . '₹' . number_format(abs($l['amount'])); ?>', '<?php echo $l['date']; ?>', '<?php echo addslashes($l['order_ref']); ?>', '<?php echo addslashes($l['actor']); ?>')">
                                    <span>Voucher</span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
