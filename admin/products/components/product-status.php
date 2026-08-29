<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-status.php — Visibility flags and the shop badge
 *
 * Everything here used to be decorative: none of the three checkboxes had an id
 * and all three were hardcoded `checked`, so every product looked Featured, a
 * Best Seller and a New Arrival while `is_featured` and `is_bestseller` were
 * never written. The "Catalog Status" select offered "Inactive / Paused" and
 * "Scheduled Release", neither of which the products.status ENUM can hold
 * (in_stock, low_stock, out_of_stock, draft) — and status is already edited in
 * the Inventory section, so a second control for the same column could only
 * disagree with the first.
 *
 * "New Arrival" is dropped: there is no such column. The Badge field below is
 * the real one, and "New Arrival" is a perfectly good badge to type into it.
 */
$stFeatured = !empty($prod['is_featured']);
$stBest = !empty($prod['is_bestseller']);
$stBadge = trim((string)($prod['badge'] ?? ''));
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
            <span>Visibility &amp; Highlighting</span>
        </h3>
    </div>
    <div class="dt-form-sec-body">
        <div class="adm-form-group" style="margin-bottom:12px;">
            <label class="adm-form-label" for="pFormBadge">Shop Badge</label>
            <input type="text" id="pFormBadge" class="adm-form-input" maxlength="50" list="dtBadgePresets"
                   placeholder="e.g. New Arrival" value="<?php echo htmlspecialchars($stBadge); ?>">
            <datalist id="dtBadgePresets">
                <option value="New Arrival"></option>
                <option value="Best Seller"></option>
                <option value="Limited Edition"></option>
                <option value="Wedding Special"></option>
                <option value="Handloom Mark"></option>
            </datalist>
            <small style="font-size:10.5px; color:#646970;">Printed on the product card. Blank means no badge.</small>
        </div>
        <div style="display:flex; flex-direction:column; gap:10px;">
            <label style="display:flex; align-items:center; gap:8px; font-size:12.5px; font-weight:600; cursor:pointer; color:#1d2327;">
                <input type="checkbox" id="pFormFeatured" <?php echo $stFeatured ? 'checked' : ''; ?>>
                <svg viewBox="0 0 24 24" width="14" height="14" fill="#DBA617" stroke="#DBA617" stroke-width="1"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <span>Featured product</span>
            </label>
            <label style="display:flex; align-items:center; gap:8px; font-size:12.5px; font-weight:600; cursor:pointer; color:#1d2327;">
                <input type="checkbox" id="pFormBestseller" <?php echo $stBest ? 'checked' : ''; ?>>
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#EA580C" stroke-width="2"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>
                <span>Best seller</span>
            </label>
        </div>
        <p style="font-size:10.5px; color:#646970; margin:12px 0 0;">
            Published or draft is set by <strong>Stock Status</strong> in the Inventory section below.
        </p>
    </div>
</div>
