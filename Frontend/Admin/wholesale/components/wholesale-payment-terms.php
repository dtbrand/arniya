<?php
/**
 * wholesale-payment-terms.php — DT Brand's & Jai Hanuman Tex
 * Payment Terms, Due Period Engine & Grace Days Rules
 */
$terms_matrix = [
    ['term' => 'Net 45 Days', 'due_days' => 45, 'grace' => '5 Days', 'eligible' => 'Platinum Wholesale VIP Only', 'interest' => '1.5% / month after grace', 'status' => 'Active', 'badge' => 'emerald'],
    ['term' => 'Net 30 Days', 'due_days' => 30, 'grace' => '3 Days', 'eligible' => 'Platinum & Gold Tier', 'interest' => '1.5% / month after grace', 'status' => 'Active', 'badge' => 'emerald'],
    ['term' => 'Net 15 Days', 'due_days' => 15, 'grace' => '2 Days', 'eligible' => 'Gold & Silver Tier', 'interest' => '2.0% / month after grace', 'status' => 'Active', 'badge' => 'emerald'],
    ['term' => 'Advance 50% / Balance Dispatch', 'due_days' => 0, 'grace' => '0 Days', 'eligible' => 'Silver & Bronze Tier', 'interest' => 'N/A', 'status' => 'Active', 'badge' => 'emerald'],
    ['term' => '100% Upfront Prepaid', 'due_days' => 0, 'grace' => '0 Days', 'eligible' => 'All New Unverified Accounts', 'interest' => 'N/A', 'status' => 'Active', 'badge' => 'emerald']
];
?>

<div class="dt-card">
    <div class="dt-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            <h4 class="dt-card-title">Commercial Payment Terms &amp; Settlement Schedules</h4>
        </div>
        <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="window.showToast('Payment Term Configurator Opened')">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            <span>Add Payment Term</span>
        </button>
    </div>

    <div style="overflow-x:auto; width:100%;">
        <table class="dt-wholesale-table">
            <thead>
                <tr>
                    <th style="white-space:nowrap;">Payment Term Name</th>
                    <th style="text-align:center; white-space:nowrap;">Credit Days</th>
                    <th style="text-align:center; white-space:nowrap;">Grace Period</th>
                    <th style="white-space:nowrap;">Eligibility Tier</th>
                    <th style="white-space:nowrap;">Overdue Penalty</th>
                    <th style="white-space:nowrap;">Status</th>
                    <th style="text-align:right; white-space:nowrap;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($terms_matrix as $t): ?>
                    <tr style="border-bottom:1px solid #F1ECE1;">
                        <td style="font-weight:800; color:#181512; white-space:nowrap;"><?php echo $t['term']; ?></td>
                        <td style="text-align:center; font-weight:800; color:#8A681F; white-space:nowrap;"><?php echo $t['due_days']; ?> Days</td>
                        <td style="text-align:center; font-weight:700; color:#15803D; white-space:nowrap;"><?php echo $t['grace']; ?></td>
                        <td style="white-space:nowrap;"><span class="dt-status-pill-clean gold"><?php echo $t['eligible']; ?></span></td>
                        <td style="font-size:0.75rem; color:#78716C; white-space:nowrap;"><?php echo $t['interest']; ?></td>
                        <td style="white-space:nowrap;"><span class="dt-status-pill-clean <?php echo $t['badge']; ?>">✓ <?php echo $t['status']; ?></span></td>
                        <td style="text-align:right; white-space:nowrap;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('Term configured')">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
