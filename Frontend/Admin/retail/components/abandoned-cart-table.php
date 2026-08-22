<?php
/**
 * abandoned-cart-table.php — DT Brand's & Jai Hanuman Tex
 * Retail Abandoned Carts Table Component with 1-Click WhatsApp Recovery
 */
require_once __DIR__ . '/retail-data.php';
$carts = getRetailAbandonedCarts();
?>

<div class="dt-retail-card">
    <div class="dt-retail-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            <h4 class="dt-retail-card-title">Abandoned Shopping Bags &amp; Recovery Studio</h4>
        </div>
        <span class="dt-status-pill-clean amber">128 Carts (₹4.2L Potential)</span>
    </div>

    <div style="overflow-x:auto; width:100%;">
        <table class="dt-retail-table">
            <thead>
                <tr>
                    <th>Cart ID</th>
                    <th>Customer Name</th>
                    <th>Cart Contents</th>
                    <th style="text-align:right;">Bag Value (₹)</th>
                    <th>Abandoned Time</th>
                    <th>Reason / Drop Stage</th>
                    <th style="text-align:right;">Recovery Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($carts as $c): ?>
                    <tr>
                        <td><span style="font-family:monospace; font-weight:800; color:#8A681F;"><?php echo $c['id']; ?></span></td>
                        <td><strong style="color:#181512; font-size:0.8rem;"><?php echo htmlspecialchars($c['customer']); ?></strong></td>
                        <td><span style="font-size:0.75rem; color:#4B5563; font-weight:600;"><?php echo htmlspecialchars($c['items']); ?></span></td>
                        <td style="text-align:right; font-weight:900; color:#181512; font-size:0.85rem;">₹<?php echo number_format($c['value']); ?></td>
                        <td style="font-size:0.72rem; color:#78716C;"><?php echo $c['created']; ?></td>
                        <td><span class="dt-status-pill-clean <?php echo $c['badge']; ?>"><?php echo $c['status']; ?></span></td>
                        <td style="text-align:right; white-space:nowrap;">
                            <button type="button" class="dt-btn dt-btn-emerald dt-btn-sm" onclick="triggerAbandonedCartRecovery('<?php echo addslashes($c['customer']); ?>', '<?php echo $c['phone']; ?>', '₹<?php echo number_format($c['value']); ?>', '<?php echo addslashes($c['items']); ?>')">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#FFFFFF" stroke-width="2.3"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                <span>Recover via WhatsApp</span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
