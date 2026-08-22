<?php
/**
 * reseller-commission.php — DT Brand's & Jai Hanuman Tex
 * Reseller Commission & Weekly Settlement Hub Component
 */
$commissions = [
    [
        'id' => 'COMM-3041',
        'order_id' => 'ORD-9842',
        'rate' => '8% Dropship Incentive',
        'amount' => 3200,
        'status' => 'Pending Settlement',
        'date' => '20 Aug 2026'
    ],
    [
        'id' => 'COMM-3028',
        'order_id' => 'ORD-9831',
        'rate' => '10% Tier Bonus',
        'amount' => 6420,
        'status' => 'Paid (Bank NEFT)',
        'date' => '18 Aug 2026'
    ],
    [
        'id' => 'COMM-2994',
        'order_id' => 'ORD-9810',
        'rate' => '8% Dropship Incentive',
        'amount' => 1790,
        'status' => 'Paid (Bank NEFT)',
        'date' => '14 Aug 2026'
    ]
];
?>

<div class="dt-card">
    <div class="dt-card-head" style="padding:16px 18px; border-bottom:1.2px solid #EAE5D9;">
        <h4 class="dt-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#15803D" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
            <span>Affiliate &amp; Dropship Commission Payouts</span>
        </h4>
        <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="window.showToast('✓ Weekly Payout Batch Calculated: ₹11,410 to be disbursed via ICICI Payouts')">
            <span>Disburse Weekly Payouts</span>
        </button>
    </div>

    <div style="overflow-x:auto; width:100%;">
        <table class="dt-reseller-table">
            <thead>
                <tr>
                    <th>Commission ID</th>
                    <th>Associated Order</th>
                    <th>Commission Rate / Plan</th>
                    <th style="text-align:right;">Amount (₹)</th>
                    <th>Payout Status</th>
                    <th>Date Created</th>
                    <th style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($commissions as $c): ?>
                    <tr>
                        <td style="font-weight:800; color:#8A681F;"><?php echo $c['id']; ?></td>
                        <td style="font-weight:700;"><a href="/Frontend/Admin/orders/view.php?id=<?php echo $c['order_id']; ?>" style="color:#1D4ED8; text-decoration:none;"><?php echo $c['order_id']; ?></a></td>
                        <td style="color:#4B5563; font-size:0.75rem;"><?php echo $c['rate']; ?></td>
                        <td style="text-align:right; font-weight:900; color:#15803D;">+₹<?php echo number_format($c['amount']); ?></td>
                        <td>
                            <?php if (strpos($c['status'], 'Paid') !== false): ?>
                                <span class="dt-reseller-badge emerald">✓ <?php echo $c['status']; ?></span>
                            <?php else: ?>
                                <span class="dt-reseller-badge amber">● <?php echo $c['status']; ?></span>
                            <?php endif; ?>
                        </td>
                        <td style="color:#78716C; font-size:0.72rem;"><?php echo $c['date']; ?></td>
                        <td style="text-align:center;">
                            <?php if (strpos($c['status'], 'Pending') !== false): ?>
                                <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" onclick="settleCommissionPayout('<?php echo $c['id']; ?>', <?php echo $c['amount']; ?>)">Settle Payout</button>
                            <?php else: ?>
                                <span style="font-size:0.68rem; color:#15803D; font-weight:700;">Settled</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
