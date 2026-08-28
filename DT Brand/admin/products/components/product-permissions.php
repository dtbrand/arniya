<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-permissions.php — Who can buy this product, and in what lot sizes
 * DT Brand's & Jai Hanuman Tex
 *
 * This section used to be four checkboxes — Customers, Resellers, Retailers,
 * Wholesalers — every one of them hardcoded `checked`, none with an id or a
 * name, and with no per-channel column anywhere on `products` to store them.
 * Unticking Wholesalers changed nothing: wholesale.php, reseller.php and
 * retailer.php each list the whole catalogue. The "Deselect All" button called
 * toggleAllChannelPermissions(), which toasted "All channels enabled" without
 * writing anything, so the panel reported a save it had not performed.
 *
 * What IS per-channel and real: the four price columns (retail / wholesale /
 * reseller, against MRP) in the Pricing section, and the four minimum-order
 * lots below — moq_single, moq_half_set, moq_full_set and moq_master_bale are
 * genuine columns that ProductCatalog::create() and update() both write, and
 * mapRow() exposes as $prod['moq_lots']. They had no inputs anywhere in the
 * admin until now, so every product silently kept the schema defaults.
 *
 * Real per-channel visibility would need a new column plus a filter in each
 * channel's query. Flagged, not invented.
 */
$pmLots = (array)($prod['moq_lots'] ?? []);
$pmSingle = (int)($pmLots['single'] ?? ($prod['moq_single'] ?? 1));
$pmHalf   = (int)($pmLots['half_set'] ?? ($prod['moq_half_set'] ?? 0));
$pmFull   = (int)($pmLots['full_set'] ?? ($prod['moq_full_set'] ?? 0));
$pmBale   = (int)($pmLots['master_bale'] ?? ($prod['moq_master_bale'] ?? 0));
$pmRow = static function (string $id, string $label, int $value, string $hint): void {
    ?>
    <div class="adm-form-group">
        <label class="adm-form-label" for="<?php echo htmlspecialchars($id); ?>"><?php echo htmlspecialchars($label); ?></label>
        <input type="number" id="<?php echo htmlspecialchars($id); ?>" class="adm-form-input"
               min="0" step="1" value="<?php echo $value; ?>">
        <small style="font-size:10.5px; color:#646970;"><?php echo htmlspecialchars($hint); ?></small>
    </div>
    <?php
};
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><rect x="1" y="3" width="22" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
            <span>B2B Lot Sizes</span>
        </h3>
    </div>
    <div class="dt-form-sec-body">
        <div class="adm-form-grid">
            <?php
            $pmRow('pFormMoqSingle', 'Single piece MOQ', $pmSingle, 'Retail customers. 1 for a normal saree.');
            $pmRow('pFormMoqHalf', 'Half set (pieces)', $pmHalf, '0 hides the half-set option.');
            $pmRow('pFormMoqFull', 'Full set (pieces)', $pmFull, 'The reseller / retailer lot.');
            $pmRow('pFormMoqBale', 'Master bale (pieces)', $pmBale, 'Wholesale mill lot.');
            ?>
        </div>
        <p style="font-size:10.5px; color:#646970; margin:10px 0 0; line-height:1.55;">
            All four channels — customers, resellers, retailers and wholesalers — can see every product.
            What changes per channel is the price (Pricing section) and the lot size above. There is no
            per-product channel switch in the database, so the four always-ticked checkboxes that used to
            sit here were removed rather than left looking functional.
        </p>
    </div>
</div>
