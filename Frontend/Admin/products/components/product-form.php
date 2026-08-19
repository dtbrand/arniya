<?php
/**
 * product-form.php — Basic Product Information Form
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            <span>Basic Information &amp; Taxonomy</span>
        </h3>
    </div>
    <div class="dt-form-sec-body">
        <div class="adm-form-grid">
            <div class="adm-form-group full">
                <label class="adm-form-label">Product Name / Title <span style="color:#b32d2e;">*</span></label>
                <input type="text" id="pFormName" class="adm-form-input" placeholder="e.g. Kanjivaram Pure Silk Gold Zari Wedding Saree" oninput="if(typeof updateGoogleSeoPreview==='function') updateGoogleSeoPreview();" value="<?php echo isset($edit_product_name) ? htmlspecialchars($edit_product_name) : ''; ?>">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">SKU Code <span style="color:#b32d2e;">*</span></label>
                <input type="text" class="adm-form-input" placeholder="e.g. KLN-SR-111" value="<?php echo isset($edit_sku) ? htmlspecialchars($edit_sku) : ''; ?>">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Barcode (EAN / UPC)</label>
                <input type="text" class="adm-form-input" placeholder="e.g. 8901234500111">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">HSN Code <span style="color:#b32d2e;">*</span></label>
                <input type="text" class="adm-form-input" value="5007 (Silk Weave)">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Category <span style="color:#b32d2e;">*</span></label>
                <select class="adm-form-select">
                    <option selected>Silk Sarees</option>
                    <option>Banarasi Brocade</option>
                    <option>Bridal Lehengas</option>
                    <option>Designer Kurtis</option>
                    <option>Dress Materials</option>
                </select>
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Subcategory</label>
                <select class="adm-form-select">
                    <option selected>Kanjivaram Silk</option>
                    <option>Paithani Zari</option>
                    <option>Mysore Crepe</option>
                </select>
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Brand</label>
                <select class="adm-form-select">
                    <option selected>DT Signature</option>
                    <option>Arniya Heritage</option>
                    <option>DT Couture</option>
                </select>
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Fabric / Weave Specs</label>
                <input type="text" class="adm-form-input" placeholder="e.g. Pure Mulberry Silk with Gold Zari Border">
            </div>
            <div class="adm-form-group full">
                <label class="adm-form-label">Full Product Description (Rich Text)</label>
                <textarea class="adm-form-textarea" rows="4" placeholder="Handwoven authentic Kanjivaram silk saree featuring pure gold zari border and rich pallu design. Includes unstitched matching blouse piece."></textarea>
            </div>
        </div>
    </div>
</div>
