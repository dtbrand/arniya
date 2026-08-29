<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * retail-discounts.php — DT Brand's & Jai Hanuman Tex
 * Retail Promo Codes & Coupon Vouchers Component
 */
require_once __DIR__ . '/retail-data.php';
$discounts = getRetailDiscounts();
?>

<div class="dt-retail-card">
    <div class="dt-retail-card-head">
        <div style="display:flex; align-items:center; gap:8px;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.3"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><circle cx="9.5" cy="9.5" r="1.5"></circle><circle cx="14.5" cy="14.5" r="1.5"></circle></svg>
            <h4 class="dt-retail-card-title">Retail Promotional Codes &amp; Coupons</h4>
        </div>
        <button type="button" class="dt-btn dt-btn-gold dt-btn-sm" onclick="openCreateDiscountModal()">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.6"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            <span>Create Promo Code</span>
        </button>
    </div>

    <div style="overflow-x:auto; width:100%;">
        <table class="dt-retail-table">
            <thead>
                <tr>
                    <th>Coupon / Campaign Name</th>
                    <th>Promo Code</th>
                    <th>Discount Type</th>
                    <th style="text-align:right;">Benefit Value</th>
                    <th>Applies To</th>
                    <th>Validity Period</th>
                    <th style="text-align:right;">Usage Count</th>
                    <th>Status</th>
                    <th style="text-align:right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($discounts as $d): ?>
                    <tr>
                        <td><strong style="color:#181512; font-size:0.8rem;"><?php echo htmlspecialchars($d['name']); ?></strong></td>
                        <td><span class="dt-discount-voucher-code"><?php echo $d['code']; ?></span></td>
                        <td style="font-size:0.75rem; color:#78716C;"><?php echo $d['type']; ?></td>
                        <td style="text-align:right; font-weight:800; color:#15803D;"><?php echo $d['value']; ?></td>
                        <td style="font-size:0.75rem; color:#78716C;"><?php echo $d['applies_to']; ?></td>
                        <td style="font-size:0.72rem; color:#78716C;"><?php echo $d['dates']; ?></td>
                        <td style="text-align:right; font-weight:700; color:#181512;"><?php echo $d['usage']; ?></td>
                        <td><span class="dt-status-pill-clean <?php echo $d['badge']; ?>"><?php echo $d['status']; ?></span></td>
                        <td style="text-align:right; white-space:nowrap;">
                            <button type="button" class="dt-btn dt-btn-pale dt-btn-sm" onclick="toggleDiscountStatus('<?php echo $d['code']; ?>', '<?php echo $d['status']; ?>')">
                                <span>Toggle Status</span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Create Discount Modal -->
<div id="dtCreateDiscountModal" class="dt-modal-backdrop">
    <div class="dt-modal-dialog" style="max-width:440px;">
        <div class="dt-modal-head">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.4"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                <strong style="font-size:0.95rem; font-weight:800; color:#181512;">Create Retail Promo Coupon</strong>
            </div>
            <button type="button" onclick="closeRetailModal('dtCreateDiscountModal')" style="background:none; border:none; font-size:20px; font-weight:bold; color:#78716C; cursor:pointer;">✕</button>
        </div>
        <form onsubmit="submitCreateDiscount(event)">
            <div class="dt-modal-body">
                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Coupon Code</label>
                    <input type="text" id="newDiscountCode" class="dt-retail-input" required placeholder="e.g. DIWALI15" style="width:100%; height:34px; border:1.2px solid #EAE5D9; border-radius:6px; padding:0 8px; font-size:0.85rem; font-family:monospace; text-transform:uppercase; font-weight:800;">
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Discount Type</label>
                        <select class="dt-retail-input" style="width:100%; height:34px; border:1.2px solid #EAE5D9; border-radius:6px; padding:0 8px; font-size:0.78rem;">
                            <option value="percentage">Percentage (%)</option>
                            <option value="fixed">Fixed Amount (₹)</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Discount Value</label>
                        <input type="number" id="newDiscountVal" class="dt-retail-input" required placeholder="e.g. 15" style="width:100%; height:34px; border:1.2px solid #EAE5D9; border-radius:6px; padding:0 8px; font-size:0.85rem; font-weight:800;">
                    </div>
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:800; color:#181512; display:block; margin-bottom:4px;">Applicable Category</label>
                    <select class="dt-retail-input" style="width:100%; height:34px; border:1.2px solid #EAE5D9; border-radius:6px; padding:0 8px; font-size:0.78rem;">
                        <option value="all">All Sarees &amp; Fabrics</option>
                        <option value="kanjeevaram">Kanjeevaram Silk</option>
                        <option value="banarasi">Banarasi Silk</option>
                        <option value="organza">Organza Sarees</option>
                    </select>
                </div>
            </div>
            <div class="dt-modal-foot">
                <button type="button" class="dt-btn dt-btn-pale" onclick="closeRetailModal('dtCreateDiscountModal')">Cancel</button>
                <button type="submit" class="dt-btn dt-btn-gold">Publish Promo Code</button>
            </div>
        </form>
    </div>
</div>
