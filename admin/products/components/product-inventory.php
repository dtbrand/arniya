<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-inventory.php — Publishing, Stock & Shop Highlighting Controls
 * DT Brand's & Jai Hanuman Tex — Unified Master Standard
 */
$stFeatured = !empty($prod['is_featured']);
$stBest = !empty($prod['is_bestseller']);
$stBadge = trim((string)($prod['badge'] ?? ''));
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head" style="display:flex; justify-content:space-between; align-items:center;">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" style="color:#8A681F;"><rect x="1" y="3" width="22" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
            <span>Publishing &amp; Stock</span>
        </h3>
        <span style="font-size:10px; font-weight:700; color:#8A681F; background:#FAF5E8; border:1px solid #D4AF37; padding:2px 8px; border-radius:4px;">
            Catalog Control
        </span>
    </div>
    <div class="dt-form-sec-body">
        <div style="display:flex; flex-direction:column; gap:12px;">
            
            <!-- 1. Stock Status -->
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormStockStatus">Catalog Publishing Status</label>
                <select id="pFormStockStatus" class="adm-form-select" style="height:34px; font-weight:700; color:#181512; border-color:#D4AF37;">
                    <?php $statusVal = $prod['status'] ?? 'in_stock'; ?>
                    <option value="in_stock" <?php echo ($statusVal === 'in_stock') ? 'selected' : ''; ?>>🟢 In Stock (Live on Shop)</option>
                    <option value="low_stock" <?php echo ($statusVal === 'low_stock') ? 'selected' : ''; ?>>🟡 Low Stock</option>
                    <option value="out_of_stock" <?php echo ($statusVal === 'out_of_stock') ? 'selected' : ''; ?>>🔴 Out of Stock</option>
                    <option value="draft" <?php echo ($statusVal === 'draft') ? 'selected' : ''; ?>>⚪ Draft (Hidden)</option>
                </select>
                <small style="font-size:10px; color:#64748B;">Controls live customer &amp; wholesale visibility.</small>
            </div>

            <!-- 2. Stock Quantity -->
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormStock">Total Available Stock (Units)</label>
                <input type="number" min="0" step="1" id="pFormStock" class="adm-form-input" placeholder="e.g. 50"
                       value="<?php echo isset($prod['stock_qty']) ? (int)$prod['stock_qty'] : ''; ?>" style="font-weight:700;">
                <small style="font-size:10px; color:#64748B;">Central warehouse units in stock.</small>
            </div>

            <!-- 3. Shop Ribbon Badge -->
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormBadge">Shop Ribbon Badge (Optional)</label>
                <input type="text" id="pFormBadge" class="adm-form-input" maxlength="50" list="dtBadgePresets"
                       placeholder="e.g. New Arrival, Best Seller" value="<?php echo htmlspecialchars($stBadge); ?>" style="font-weight:600;">
                <datalist id="dtBadgePresets">
                    <option value="New Arrival"></option>
                    <option value="Best Seller"></option>
                    <option value="Limited Edition"></option>
                    <option value="Wedding Special"></option>
                    <option value="Handloom Pure Silk"></option>
                    <option value="Hot Trending"></option>
                </datalist>
                <small style="font-size:10px; color:#64748B;">Gold ribbon tag displayed over product photo.</small>
            </div>

            <!-- 4. Highlighting Tags (Featured & Bestseller) -->
            <div class="adm-form-group" style="background:#FAF8F2; border:1px solid #E2DFD7; border-radius:6px; padding:10px 12px;">
                <label class="adm-form-label" style="font-size:11px; font-weight:800; color:#5A4210; margin-bottom:6px;">STOREFRONT HIGHLIGHTS</label>
                <div style="display:flex; flex-direction:column; gap:8px;">
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:700; cursor:pointer; color:#181512;">
                        <input type="checkbox" id="pFormFeatured" <?php echo $stFeatured ? 'checked' : ''; ?> style="accent-color:#8A681F; width:15px; height:15px;">
                        <span style="color:#B8860B;">★ Featured on Homepage</span>
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:700; cursor:pointer; color:#181512;">
                        <input type="checkbox" id="pFormBestseller" <?php echo $stBest ? 'checked' : ''; ?> style="accent-color:#8A681F; width:15px; height:15px;">
                        <span style="color:#EA580C;">🔥 Best Seller Collection</span>
                    </label>
                </div>
            </div>

        </div>
    </div>
</div>
