<?php
/**
 * reseller-credit.php — DT Brand's & Jai Hanuman Tex
 * Reseller Credit Limit, Wallet Balance & Ledger Component
 */
$credit_logs = [
    [
        'id' => 'TXN-8821',
        'date' => '20 Aug 2026',
        'type' => 'Debit (Order ORD-9842)',
        'amount' => -14800,
        'balance' => 65000,
        'actor' => 'Automated Order Checkout'
    ],
    [
        'id' => 'TXN-8790',
        'date' => '15 Aug 2026',
        'type' => 'Credit Settlement (ICICI Bank Transfer)',
        'amount' => 50000,
        'balance' => 50200,
        'actor' => 'Staff Rajesh (UTR #99824)'
    ],
    [
        'id' => 'TXN-8712',
        'date' => '01 Aug 2026',
        'type' => 'Monthly Limit Renewal',
        'amount' => 150000,
        'balance' => 0,
        'actor' => 'System Cron'
    ]
];
?>

<div style="display:flex; flex-direction:column; gap:16px;">
    <!-- Master Credit Banner -->
    <div class="dt-credit-banner">
        <div>
            <span style="font-size:0.7rem; font-weight:800; color:#F5ECCE; text-transform:uppercase; letter-spacing:0.04em;">Reseller B2B Credit Facility</span>
            <h3 style="font-size:1.2rem; font-weight:900; color:#FFFFFF; margin:3px 0 0 0;">30-Day Revolving Working Capital Line</h3>
            <p style="font-size:0.75rem; color:#FEE685; margin:4px 0 0 0;">Status: 100% On-Time Payment History • Zero Default Risk</p>
        </div>

        <div style="display:flex; align-items:center; gap:24px;">
            <div style="text-align:right;">
                <div style="font-size:0.65rem; color:#F5ECCE; font-weight:800; text-transform:uppercase;">Sanctioned Limit</div>
                <div style="font-size:1.4rem; font-weight:900; color:#FFFFFF;">₹1,50,000</div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:0.65rem; color:#F5ECCE; font-weight:800; text-transform:uppercase;">Utilized Credit</div>
                <div class="dt-credit-balance-val">₹65,000</div>
            </div>
            <button type="button" class="dt-btn dt-btn-gold" onclick="openCreditAdjustmentModal('RES-1048', 150000, 65000)">
                <span>Adjust Credit / Limit</span>
            </button>
        </div>
    </div>

    <!-- Ledger Table -->
    <div class="dt-card">
        <div class="dt-card-head" style="padding:14px 18px; border-bottom:1.2px solid #EAE5D9;">
            <h4 class="dt-card-title">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.5"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                <span>Transaction &amp; Credit Ledger Audit</span>
            </h4>
            <span class="dt-reseller-badge emerald">Real-Time Sync</span>
        </div>

        <div style="overflow-x:auto; width:100%;">
            <table class="dt-credit-ledger-table">
                <thead>
                    <tr>
                        <th>Txn ID</th>
                        <th>Date &amp; Time</th>
                        <th>Description / Transaction Note</th>
                        <th style="text-align:right;">Amount (₹)</th>
                        <th style="text-align:right;">Running Balance</th>
                        <th>Authorized By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($credit_logs as $l): ?>
                        <tr>
                            <td style="font-family:monospace; font-weight:700; color:#8A681F;"><?php echo $l['id']; ?></td>
                            <td style="color:#78716C; font-size:0.72rem;"><?php echo $l['date']; ?></td>
                            <td style="font-weight:700; color:#181512;"><?php echo htmlspecialchars($l['type']); ?></td>
                            <td style="text-align:right; font-weight:800; color:<?php echo $l['amount'] < 0 ? '#DC2626' : '#15803D'; ?>;">
                                <?php echo ($l['amount'] > 0 ? '+' : '') . '₹' . number_format($l['amount']); ?>
                            </td>
                            <td style="text-align:right; font-weight:800; color:#181512;">₹<?php echo number_format($l['balance']); ?></td>
                            <td style="color:#78716C; font-size:0.72rem;"><?php echo htmlspecialchars($l['actor']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
