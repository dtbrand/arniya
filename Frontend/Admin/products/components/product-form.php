<?php
/**
 * product-form.php — Basic Product Information Form
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title"><span>👗 Basic Information &amp; Taxonomy</span></h3>
    </div>
    <div class="dt-form-sec-body">
        <div class="adm-form-grid">
            <div class="adm-form-group full">
                <label class="adm-form-label">Product Name / Title *</label>
                <input type="text" id="pFormName" class="adm-form-input" placeholder="e.g. Kanjivaram Pure Silk Gold Zari Wedding Saree" oninput="if(typeof updateGoogleSeoPreview==='function') updateGoogleSeoPreview();" value="<?php echo isset($edit_product_name) ? htmlspecialchars($edit_product_name) : ''; ?>">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">SKU Code *</label>
                <input type="text" class="adm-form-input" placeholder="e.g. KLN-SR-111" value="<?php echo isset($edit_sku) ? htmlspecialchars($edit_sku) : ''; ?>">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Barcode (EAN / UPC)</label>
                <input type="text" class="adm-form-input" placeholder="e.g. 8901234500111">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">HSN Code *</label>
                <input type="text" class="adm-form-input" value="5007 (Silk Weave)">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Category *</label>
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
            <div class="adm-form-group full">
                <label class="adm-form-label">Short Description (For WhatsApp Sharing &amp; Quickview)</label>
                <input type="text" class="adm-form-input" placeholder="e.g. Authentic Surat pure silk saree with royal gold zari pallu.">
            </div>
        </div>
    </div>
</div>
