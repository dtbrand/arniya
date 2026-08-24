<?php
/**
 * reseller-commission.php — DT Brand's & Jai Hanuman Tex
 * Reseller Commission & Weekly Settlement Hub Component
 */
$total_disbursed = 42500;
$pending_settlement = 3200;
$avg_rate = "8.8%";
$settled_count = 14;

$commissions = [
    [
        'id' => 'COMM-3041',
        'order_id' => 'ORD-9842',
        'order_amount' => '₹40,000',
        'rate' => '8% Dropship Incentive',
        'amount' => 3200,
        'status' => 'Pending Settlement',
        'status_type' => 'pending',
        'date' => '20 Aug 2026, 04:30 PM',
        'bank_ref' => 'ICICI A/C: 002105018291'
    ],
    [
        'id' => 'COMM-3028',
        'order_id' => 'ORD-9831',
        'order_amount' => '₹64,200',
        'rate' => '10% Tier Bonus',
        'amount' => 6420,
        'status' => 'Paid (Bank NEFT)',
        'status_type' => 'paid',
        'date' => '18 Aug 2026, 11:20 AM',
        'bank_ref' => 'UTR #NEFT998241029'
    ],
    [
        'id' => 'COMM-2994',
        'order_id' => 'ORD-9810',
        'order_amount' => '₹22,375',
        'rate' => '8% Dropship Incentive',
        'amount' => 1790,
        'status' => 'Paid (Bank NEFT)',
        'status_type' => 'paid',
        'date' => '14 Aug 2026, 02:45 PM',
        'bank_ref' => 'UTR #NEFT881920341'
    ],
    [
        'id' => 'COMM-2950',
        'order_id' => 'ORD-9780',
        'order_amount' => '₹1,25,000',
        'rate' => '12% Bulk Volume Booster',
        'amount' => 15000,
        'status' => 'Paid (Bank NEFT)',
        'status_type' => 'paid',
        'date' => '07 Aug 2026, 05:10 PM',
        'bank_ref' => 'UTR #NEFT771239845'
    ],
    [
        'id' => 'COMM-2912',
        'order_id' => 'ORD-9745',
        'order_amount' => '₹1,60,900',
        'rate' => '10% Tier Bonus',
        'amount' => 16090,
        'status' => 'Paid (Bank NEFT)',
        'status_type' => 'paid',
        'date' => '01 Aug 2026, 03:00 PM',
        'bank_ref' => 'UTR #NEFT662391048'
    ]
];
?>

<div style="display:flex; flex-direction:column; gap:16px;">
    <!-- ══════════════════════════════════════════════════════════════
         4-CARD KPI RIBBON
    ══════════════════════════════════════════════════════════════ -->
    <div class="dt-commission-kpi-grid">
        <!-- Card 1: Total Disbursed -->
        <div class="dt-comm-stat-card">
            <div class="dt-comm-stat-icon emerald">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
            </div>
            <div>
                <span style="font-size:0.7rem; color:#78716C; font-weight:700; text-transform:uppercase;">Total Disbursed</span>
                <strong id="kpiTotalDisbursed" style="font-size:1.25rem; font-weight:900; color:#15803D; display:block;">₹<?php echo number_format($total_disbursed); ?></strong>
            </div>
        </div>

        <!-- Card 2: Pending Settlement -->
        <div class="dt-comm-stat-card">
            <div class="dt-comm-stat-icon amber">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
            </div>
            <div>
                <span style="font-size:0.7rem; color:#78716C; font-weight:700; text-transform:uppercase;">Pending Payouts</span>
                <strong id="kpiPendingSettlement" style="font-size:1.25rem; font-weight:900; color:#B45309; display:block;">₹<?php echo number_format($pending_settlement); ?></strong>
            </div>
        </div>

        <!-- Card 3: Avg Commission Rate -->
        <div class="dt-comm-stat-card">
            <div class="dt-comm-stat-icon">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            </div>
            <div>
                <span style="font-size:0.7rem; color:#78716C; font-weight:700; text-transform:uppercase;">Avg Commission Rate</span>
                <strong style="font-size:1.25rem; font-weight:900; color:#8A681F; display:block;"><?php echo $avg_rate; ?></strong>
            </div>
        </div>

        <!-- Card 4: Settled Count -->
        <div class="dt-comm-stat-card">
            <div class="dt-comm-stat-icon emerald">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <div>
                <span style="font-size:0.7rem; color:#78716C; font-weight:700; text-transform:uppercase;">Settled Transactions</span>
                <strong style="font-size:1.25rem; font-weight:900; color:#181512; display:block;"><?php echo $settled_count; ?> Disbursed</strong>
            </div>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════════════
         AFFILIATE & DROPSHIP COMMISSION PAYOUTS CARD
    ══════════════════════════════════════════════════════════════ -->
    <div class="dt-card" style="background:#FFFFFF; border:1.5px solid #EAE5D9; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.02); overflow:hidden;">
        
        <!-- Toolbar Header -->
        <div style="padding:14px 18px; border-bottom:1.5px solid #EAE5D9; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; background:#FAF8F4;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:30px; height:30px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.4"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                </div>
                <div>
                    <h4 style="font-size:0.92rem; font-weight:800; color:#181512; margin:0;">Affiliate &amp; Dropship Commission Payouts</h4>
                    <p style="font-size:0.7rem; color:#78716C; margin:1px 0 0 0;">Automatic margin rewards &amp; incentive payouts per B2B saree order fulfillment.</p>
                </div>
            </div>

            <!-- Filter & Search Controls -->
            <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                <!-- Live Search Box -->
                <div style="position:relative; width:220px;">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#78716C" stroke-width="2.2" style="position:absolute; left:9px; top:50%; transform:translateY(-50%); pointer-events:none;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" id="commSearchInput" class="dt-cust-search-input" style="width:100%; height:32px; padding-left:28px; font-size:0.74rem;" placeholder="Search Comm ID, Order, Plan..." oninput="filterCommissions()">
                </div>

                <!-- Status Filter -->
                <select id="commStatusFilter" class="dt-cust-select" style="height:32px; font-size:0.74rem; padding:0 8px; border-radius:6px;" onchange="filterCommissions()">
                    <option value="all">All Payout Statuses</option>
                    <option value="pending">Pending Settlement</option>
                    <option value="paid">Paid (Bank NEFT)</option>
                </select>

                <!-- Batch Disburse Button -->
                <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="openBatchDisburseModal()">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Disburse Weekly Payouts</span>
                </button>
            </div>
        </div>

        <!-- Commission Table -->
        <div style="overflow-x:auto; width:100%;">
            <table class="dt-commission-table">
                <thead>
                    <tr>
                        <th style="white-space:nowrap;">Commission ID</th>
                        <th style="white-space:nowrap;">Associated Order</th>
                        <th style="white-space:nowrap;">Commission Rate / Plan</th>
                        <th style="text-align:right; white-space:nowrap;">Payout Amount (₹)</th>
                        <th style="white-space:nowrap;">Payout Status</th>
                        <th style="white-space:nowrap;">Date Created</th>
                        <th style="text-align:right; white-space:nowrap;">Action</th>
                    </tr>
                </thead>
                <tbody id="commissionTbody">
                    <?php foreach ($commissions as $c): ?>
                        <tr id="<?php echo $c['id']; ?>" class="comm-row-item" data-status="<?php echo $c['status_type']; ?>" style="border-bottom:1px solid #F1ECE1;">
                            <td class="comm-id-cell" style="font-family:monospace; font-weight:800; color:#8A681F; white-space:nowrap;"><?php echo $c['id']; ?></td>
                            <td class="comm-order-cell" style="font-weight:700; white-space:nowrap;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="font-family:monospace; color:#1D4ED8; background:#EFF6FF; border:1px solid #BFDBFE; padding:2px 6px; border-radius:4px; font-weight:800;">
                                        <?php echo $c['order_id']; ?>
                                    </span>
                                    <small style="color:#78716C; font-size:0.72rem;">(<?php echo $c['order_amount']; ?>)</small>
                                </div>
                            </td>
                            <td class="comm-rate-cell" style="color:#181512; font-weight:600; white-space:nowrap;"><?php echo $c['rate']; ?></td>
                            <td class="comm-amount-cell" style="text-align:right; font-weight:900; font-size:0.88rem; color:#15803D; white-space:nowrap;">
                                +₹<?php echo number_format($c['amount']); ?>
                            </td>
                            <td class="comm-status-cell" style="white-space:nowrap;">
                                <?php if ($c['status_type'] === 'paid'): ?>
                                    <span class="dt-status-pill-clean emerald">
                                        <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                        <span>PAID (BANK NEFT)</span>
                                    </span>
                                <?php else: ?>
                                    <span class="dt-status-pill-clean amber">
                                        <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                                        <span>PENDING SETTLEMENT</span>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td style="color:#78716C; font-size:0.72rem; white-space:nowrap;"><?php echo $c['date']; ?></td>
                            <td class="comm-action-cell" style="text-align:right; white-space:nowrap;">
                                <?php if ($c['status_type'] === 'pending'): ?>
                                    <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" onclick="openSettleCommissionModal('<?php echo $c['id']; ?>', '<?php echo $c['order_id']; ?>', '<?php echo $c['amount']; ?>', '<?php echo addslashes($c['rate']); ?>')">
                                        <span>Settle Payout</span>
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="viewPayoutAdvice('<?php echo $c['id']; ?>', '<?php echo $c['order_id']; ?>', '<?php echo $c['amount']; ?>', '<?php echo $c['date']; ?>', '<?php echo addslashes($c['rate']); ?>', '<?php echo addslashes($c['bank_ref']); ?>')">
                                        <span>Payout Advice</span>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
