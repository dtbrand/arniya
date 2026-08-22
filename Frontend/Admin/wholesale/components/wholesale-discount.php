<?php
/**
 * wholesale-discount.php — DT Brand's & Jai Hanuman Tex
 * Seasonal Wholesale Discount Rules & Kickback Matrix
 */
$discounts = [
    ['name' => 'Diwali 2026 Pre-Booking Incentive', 'type' => 'Volume Kickback', 'value' => '5.0% Rebate', 'tier' => 'Platinum & Gold', 'valid' => '01 Sep 2026 - 31 Oct 2026', 'status' => 'Active', 'badge' => 'emerald'],
    ['name' => 'Full Upfront NEFT Instant Cash Discount', 'type' => 'Payment Mode Discount', 'value' => '2.5% Instant Off', 'tier' => 'All Wholesalers', 'valid' => 'Permanent Rule', 'status' => 'Active', 'badge' => 'emerald'],
    ['name' => 'Off-Season Jacquard Stock Clearance', 'type' => 'Category Discount', 'value' => '8.0% Extra Off', 'tier' => 'Silver & Bronze', 'valid' => 'Expired 30 Jun', 'status' => 'Expired', 'badge' => 'crimson']
];
?>

<div class="dt-card">
    <div class="dt-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            <h4 class="dt-card-title">Seasonal Wholesale Rebates &amp; Cash Discounts</h4>
        </div>
        <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="openCreateDiscountModal()">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#181512" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            <span>+ Create Discount Rule</span>
        </button>
    </div>

    <div style="overflow-x:auto; width:100%;">
        <table class="dt-wholesale-table">
            <thead>
                <tr>
                    <th style="white-space:nowrap;">Campaign / Rule Name</th>
                    <th style="white-space:nowrap;">Discount Type</th>
                    <th style="white-space:nowrap;">Rebate Value</th>
                    <th style="white-space:nowrap;">Eligible Tiers</th>
                    <th style="white-space:nowrap;">Validity Window</th>
                    <th style="white-space:nowrap;">Rule Status</th>
                    <th style="text-align:right; white-space:nowrap;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($discounts as $d): ?>
                    <tr style="border-bottom:1px solid #F1ECE1;">
                        <td style="font-weight:800; color:#181512; white-space:nowrap;"><?php echo htmlspecialchars($d['name']); ?></td>
                        <td style="color:#78716C; font-size:0.75rem; white-space:nowrap;"><?php echo $d['type']; ?></td>
                        <td style="font-weight:900; color:#15803D; font-size:0.85rem; white-space:nowrap;"><?php echo $d['value']; ?></td>
                        <td style="white-space:nowrap;"><span class="dt-status-pill-clean gold"><?php echo $d['tier']; ?></span></td>
                        <td style="color:#78716C; font-size:0.72rem; white-space:nowrap;"><?php echo $d['valid']; ?></td>
                        <td style="white-space:nowrap;"><span class="dt-status-pill-clean <?php echo $d['badge']; ?>"><?php echo $d['status']; ?></span></td>
                        <td style="text-align:right; white-space:nowrap;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="window.showToast('Discount Rule Configured')">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
