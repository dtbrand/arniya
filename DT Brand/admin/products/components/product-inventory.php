<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-inventory.php — Inventory, Stock Status, Shop Badges & B2B Lot Sizes
 * DT Brand's & Jai Hanuman Tex — Unified Master Standard
 */
$stFeatured = !empty($prod['is_featured']);
$stBest = !empty($prod['is_bestseller']);
$stBadge = trim((string)($prod['badge'] ?? ''));

$pmLots = (array)($prod['moq_lots'] ?? []);
$pmSingle = (int)($pmLots['single'] ?? ($prod['moq_single'] ?? 1));
$pmHalf   = (int)($pmLots['half_set'] ?? ($prod['moq_half_set'] ?? 0));
$pmFull   = (int)($pmLots['full_set'] ?? ($prod['moq_full_set'] ?? 0));
$pmBale   = (int)($pmLots['master_bale'] ?? ($prod['moq_master_bale'] ?? 0));
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head" style="display:flex; justify-content:space-between; align-items:center;">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" style="color:#8A681F;"><rect x="1" y="3" width="22" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
            <span>Inventory, Stock Status &amp; B2B Lot Orders</span>
        </h3>
        <span style="font-size:10px; font-weight:700; color:#8A681F; background:#FAF5E8; border:1px solid #D4AF37; padding:2px 8px; border-radius:4px;">
            Depot Stock &amp; MOQ Rules
        </span>
    </div>
    <div class="dt-form-sec-body">
        <div class="adm-form-grid" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px; margin-bottom:12px;">
            
            <!-- 1. Stock Quantity -->
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormStock">Total Stock Quantity (Units)</label>
                <input type="number" min="0" step="1" id="pFormStock" class="adm-form-input" placeholder="e.g. 50"
                       value="<?php echo isset($prod['stock_qty']) ? (int)$prod['stock_qty'] : ''; ?>">
                <small style="font-size:10px; color:#64748B;">Central warehouse stock units.</small>
            </div>

            <!-- 2. Stock Status -->
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormStockStatus">Catalog Publishing Status</label>
                <select id="pFormStockStatus" class="adm-form-select" style="height:32px; font-weight:700;">
                    <?php $statusVal = $prod['status'] ?? 'in_stock'; ?>
                    <option value="in_stock" <?php echo ($statusVal === 'in_stock') ? 'selected' : ''; ?>>In Stock (Live on Shop)</option>
                    <option value="low_stock" <?php echo ($statusVal === 'low_stock') ? 'selected' : ''; ?>>Low Stock</option>
                    <option value="out_of_stock" <?php echo ($statusVal === 'out_of_stock') ? 'selected' : ''; ?>>Out of Stock</option>
                    <option value="draft" <?php echo ($statusVal === 'draft') ? 'selected' : ''; ?>>Draft (Hidden)</option>
                </select>
                <small style="font-size:10px; color:#64748B;">Controls product visibility.</small>
            </div>

            <!-- 3. Shop Badge -->
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormBadge">Shop Badge Ribbon</label>
                <input type="text" id="pFormBadge" class="adm-form-input" maxlength="50" list="dtBadgePresets"
                       placeholder="e.g. New Arrival" value="<?php echo htmlspecialchars($stBadge); ?>">
                <datalist id="dtBadgePresets">
                    <option value="New Arrival"></option>
                    <option value="Best Seller"></option>
                    <option value="Limited Edition"></option>
                    <option value="Wedding Special"></option>
                    <option value="Handloom Mark"></option>
                </datalist>
                <small style="font-size:10px; color:#64748B;">Ribbon tag on product card.</small>
            </div>

            <!-- 4. Featured & Bestseller Checkboxes -->
            <div class="adm-form-group">
                <label class="adm-form-label">Highlighting Tags</label>
                <div style="display:flex; gap:12px; align-items:center; padding:5px 0;">
                    <label style="display:flex; align-items:center; gap:5px; font-size:11.5px; font-weight:700; cursor:pointer; color:#181512;">
                        <input type="checkbox" id="pFormFeatured" <?php echo $stFeatured ? 'checked' : ''; ?> style="accent-color:#8A681F;">
                        <span style="color:#B8860B;">★ Featured</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:5px; font-size:11.5px; font-weight:700; cursor:pointer; color:#181512;">
                        <input type="checkbox" id="pFormBestseller" <?php echo $stBest ? 'checked' : ''; ?> style="accent-color:#8A681F;">
                        <span style="color:#EA580C;">🔥 Best Seller</span>
                    </label>
                </div>
                <small style="font-size:10px; color:#64748B;">Featured collections &amp; homepage badges.</small>
            </div>
        </div>

        <!-- B2B Lot Sizes Sub-Grid -->
        <div style="background:#FDFBF7; border:1px solid #E2DFD7; border-radius:6px; padding:10px 12px;">
            <div style="font-size:11px; font-weight:800; color:#5A4210; text-transform:uppercase; margin-bottom:8px; display:flex; align-items:center; gap:5px;">
                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.5"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                <span>Minimum Order Quantities (MOQ Lots)</span>
            </div>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(160px, 1fr)); gap:10px;">
                <div>
                    <label class="adm-form-label" for="pFormMoqSingle" style="font-size:11px;">Single Piece MOQ</label>
                    <input type="number" id="pFormMoqSingle" class="adm-form-input" min="0" step="1" value="<?php echo $pmSingle; ?>" style="height:28px; font-size:11.5px;">
                    <small style="font-size:9.5px; color:#64748B;">Guest / Customer</small>
                </div>
                <div>
                    <label class="adm-form-label" for="pFormMoqHalf" style="font-size:11px;">Half Set (Pieces)</label>
                    <input type="number" id="pFormMoqHalf" class="adm-form-input" min="0" step="1" value="<?php echo $pmHalf; ?>" style="height:28px; font-size:11.5px;">
                    <small style="font-size:9.5px; color:#64748B;">0 disables half set</small>
                </div>
                <div>
                    <label class="adm-form-label" for="pFormMoqFull" style="font-size:11px;">Full Set (Pieces)</label>
                    <input type="number" id="pFormMoqFull" class="adm-form-input" min="0" step="1" value="<?php echo $pmFull; ?>" style="height:28px; font-size:11.5px;">
                    <small style="font-size:9.5px; color:#64748B;">Boutique &amp; Reseller lot</small>
                </div>
                <div>
                    <label class="adm-form-label" for="pFormMoqBale" style="font-size:11px;">Master Bale (Pieces)</label>
                    <input type="number" id="pFormMoqBale" class="adm-form-input" min="0" step="1" value="<?php echo $pmBale; ?>" style="height:28px; font-size:11.5px;">
                    <small style="font-size:9.5px; color:#64748B;">Wholesale mill bale</small>
                </div>
            </div>
        </div>
    </div>
</div>
