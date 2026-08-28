<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-variants.php — Colours, Sizes and the per-variant matrix
 * DT Brand's & Jai Hanuman Tex
 *
 * product_variants is the only per-product colour/size storage: one row per
 * combination holding color_name, size_name, sku, stock_qty, price and image.
 * There is no per-variant status column and only ONE price column, so the old
 * cards' "Price / Sale Price / Status" trio could never be saved — and none of
 * the generated inputs had a name, an id or a data attribute, so nothing could
 * be read out of the page even in principle. Every colour and size an admin
 * entered was discarded on save.
 *
 * The old Blouse and Border "variations" were not variants at all: the schema
 * holds a single products.blouse_piece and a single products.pallu_style, so
 * four blouse cards each with their own SKU, price and stock had nowhere to go.
 * They are one field each now.
 *
 * Also removed: the add form seeded itself with 'Crimson Red', 'Peacock Blue',
 * 'Emerald Green', 'Free Size (6.3m)', 'M (38)' and 'L (40)' on every new
 * product — each card claiming 15/20/25 units of stock and a hardcoded
 * /assets/images/product4.png photo — so a brand new saree arrived with three
 * colours and three sizes nobody had chosen.
 */
$vSeedVariants = array_values($prod['variants'] ?? []);
$vBlouse = trim((string)($prod['blouse_piece'] ?? ''));
$vPallu  = trim((string)($prod['pallu_style'] ?? ''));
$vZari   = trim((string)($prod['zari_type'] ?? ''));
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
        <h3 class="dt-form-sec-title" style="margin:0;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
            <span>Colours, Sizes &amp; Variants</span>
        </h3>
        <span style="font-size:10.5px; color:#646970;">Each row below becomes one product_variants record.</span>
    </div>
    <div class="dt-form-sec-body">
        <!-- 1. COLOURS -->
        <div style="margin-bottom:18px;">
            <div style="background:#FAF8F2; border:1px solid rgba(212,175,55,0.45); border-radius:6px; padding:10px 14px;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <span style="font-size:12px; font-weight:700; color:#5A4210;">Colours:</span>
                        <div id="dtColorChips" style="display:flex; gap:6px; align-items:center; flex-wrap:wrap;">
                            <span class="dt-empty-note" style="font-size:11px; color:#646970;">None added yet.</span>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                        <input type="color" id="varColorPicker" value="#8A681F" title="Pick a colour"
                               style="width:34px; height:30px; padding:0; border:1px solid #c3c4c7; border-radius:4px; cursor:pointer;">
                        <input type="text" id="varColorHex" value="#8A681F" spellcheck="false"
                               style="width:78px; height:30px; font-size:12px; padding:0 6px; border:1px solid #8c8f94; border-radius:3px; font-family:monospace;">
                        <input type="text" id="varColorName" placeholder="Colour name" maxlength="50"
                               style="height:30px; font-size:12px; font-weight:600; padding:0 8px; border:1px solid #8A681F; border-radius:3px; width:180px; background:#fff;">
                        <button type="button" class="dt-btn-action-sm gold" id="dtAddColorBtn">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>Add Colour</span>
                        </button>
                    </div>
                </div>
                <div style="margin-top:8px; font-size:10.5px; color:#646970;">
                    The name is what a shopper sees, so it is stored as typed. Picking a swatch suggests
                    the closest trade name — it never overwrites a name you have already typed.
                </div>
            </div>
        </div>

        <!-- 2. SIZES -->
        <div style="margin-bottom:18px;">
            <div style="background:#FAF8F2; border:1px solid rgba(212,175,55,0.45); border-radius:6px; padding:10px 14px;">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <span style="font-size:12px; font-weight:700; color:#5A4210;">Sizes:</span>
                        <div id="dtSizeChips" style="display:flex; gap:6px; align-items:center; flex-wrap:wrap;">
                            <span class="dt-empty-note" style="font-size:11px; color:#646970;">None added yet.</span>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                        <input type="text" id="varSizeName" placeholder="e.g. Free Size (6.3m)" maxlength="50"
                               style="height:30px; font-size:12px; font-weight:600; padding:0 8px; border:1px solid #8A681F; border-radius:3px; width:200px; background:#fff;">
                        <button type="button" class="dt-btn-action-sm gold" id="dtAddSizeBtn">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>Add Size</span>
                        </button>
                    </div>
                </div>
                <div id="dtSizePresets" style="display:flex; gap:6px; flex-wrap:wrap; margin-top:8px;"></div>
            </div>
        </div>
        <!-- 3. VARIANT MATRIX -->
        <div style="border-top:1px dashed rgba(212,175,55,0.6); padding-top:12px;">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:8px;">
                <strong style="font-size:12.5px; color:#181512;">Variant rows</strong>
                <div style="display:flex; gap:6px; flex-wrap:wrap;">
                    <button type="button" class="dt-btn-action-sm pale-gold" id="dtBuildMatrixBtn">
                        <span>Build rows from colours &amp; sizes</span>
                    </button>
                    <button type="button" class="dt-btn-action-sm" id="dtClearMatrixBtn" style="color:#b32d2e;">
                        <span>Clear rows</span>
                    </button>
                </div>
            </div>
            <div style="overflow-x:auto;">
                <table class="wp-list-table" style="width:100%; border-collapse:collapse; font-size:11.5px;">
                    <thead>
                        <tr style="background:#f6f7f7;">
                            <th style="text-align:left; padding:6px 8px; border-bottom:1px solid #c3c4c7;">Photo</th>
                            <th style="text-align:left; padding:6px 8px; border-bottom:1px solid #c3c4c7;">Colour</th>
                            <th style="text-align:left; padding:6px 8px; border-bottom:1px solid #c3c4c7;">Size</th>
                            <th style="text-align:left; padding:6px 8px; border-bottom:1px solid #c3c4c7;">Variant SKU</th>
                            <th style="text-align:left; padding:6px 8px; border-bottom:1px solid #c3c4c7;">Price &#8377;</th>
                            <th style="text-align:left; padding:6px 8px; border-bottom:1px solid #c3c4c7;">Stock</th>
                            <th style="border-bottom:1px solid #c3c4c7;"></th>
                        </tr>
                    </thead>
                    <tbody id="dtVariantRows"></tbody>
                </table>
            </div>
            <div id="dtVariantEmpty" style="font-size:11px; color:#646970; padding:10px 2px;">
                No variant rows. A product can be saved without any — it then has no colour or size options.
            </div>
            <div style="font-size:10.5px; color:#646970; margin-top:6px;">
                Leave Price blank to use the product's retail price. Blank SKU is generated from the
                product SKU on save. Stock here is per variant and is separate from the product's own
                stock quantity.
            </div>
        </div>
        <!-- 4. SINGLE-VALUE SAREE DETAILS (real product columns) -->
        <div style="border-top:1px dashed rgba(212,175,55,0.6); padding-top:12px; margin-top:16px;">
            <strong style="font-size:12.5px; color:#181512;">Blouse, border &amp; zari</strong>
            <div style="font-size:10.5px; color:#646970; margin:2px 0 10px;">
                One value each — these are columns on the product (blouse_piece, pallu_style,
                zari_type), not variants. They used to be four "variation" cards apiece with their own
                SKU, price and stock, none of which could be stored.
            </div>
            <div class="adm-form-grid">
                <div class="adm-form-group">
                    <label class="adm-form-label" for="pFormBlouse">Blouse Piece</label>
                    <input type="text" id="pFormBlouse" class="adm-form-input" maxlength="100"
                           list="dtBlousePresets" placeholder="e.g. Unstitched Blouse Piece (0.8m)"
                           value="<?php echo htmlspecialchars($vBlouse); ?>">
                    <datalist id="dtBlousePresets">
                        <option value="Unstitched Blouse Piece (0.8m)"></option>
                        <option value="Stitched Blouse (Ready Made)"></option>
                        <option value="Heavy Embroidered / Maggam Work"></option>
                        <option value="Running Contrast Blouse"></option>
                        <option value="Without Blouse Piece"></option>
                    </datalist>
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label" for="pFormPallu">Border / Pallu Style</label>
                    <input type="text" id="pFormPallu" class="adm-form-input" maxlength="100"
                           list="dtPalluPresets" placeholder="e.g. Broad Kaddi Big Border"
                           value="<?php echo htmlspecialchars($vPallu); ?>">
                    <datalist id="dtPalluPresets">
                        <option value="Pure Gold Zari Border"></option>
                        <option value="Silver Temple Border"></option>
                        <option value="Broad Kaddi Big Border"></option>
                        <option value="Ganga Jamuna Contrast Border"></option>
                        <option value="Cutwork Scallop Border"></option>
                        <option value="Small Meena Work Border"></option>
                    </datalist>
                </div>
                <div class="adm-form-group">
                    <label class="adm-form-label" for="pFormZari">Zari Type</label>
                    <input type="text" id="pFormZari" class="adm-form-input" maxlength="100"
                           list="dtZariPresets" placeholder="e.g. Pure Silver Tested Zari"
                           value="<?php echo htmlspecialchars($vZari); ?>">
                    <datalist id="dtZariPresets">
                        <option value="Pure Silver Tested Zari"></option>
                        <option value="Half Fine Zari"></option>
                        <option value="Imitation / Tissue Zari"></option>
                        <option value="Copper Zari"></option>
                    </datalist>
                </div>
            </div>
        </div>
<!-- DT_MARK_V4 -->
    </div>
</div>
<script>
// Real rows from product_variants for this product, or an empty list on a new
// product. variants.js renders these; nothing is seeded when there is nothing.
window.DT_VARIANT_SEED = <?php echo json_encode($vSeedVariants, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;
</script>
