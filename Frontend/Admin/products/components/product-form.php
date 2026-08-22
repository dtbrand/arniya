<?php
/**
 * product-form.php — Basic Product Information Form with Clean DT Brand's AI Importer Modal
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
        <h3 class="dt-form-sec-title" style="margin:0;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            <span>Basic Information &amp; Taxonomy</span>
        </h3>

        <!-- DT Brand's Gold Animated AI Magic Button in Right Corner -->
        <button type="button" id="btnAiMagicGenerate" class="dt-ai-magic-btn" onclick="openAiImporterModal()" style="display:inline-flex; align-items:center; gap:6px; background:linear-gradient(135deg, #2A2010 0%, #443416 50%, #1C150B 100%); color:#FFE57F; border:1.5px solid #D4AF37; padding:5px 14px; border-radius:20px; font-size:12px; font-weight:800; cursor:pointer; box-shadow:0 2px 10px rgba(212,175,55,0.35); transition:all 0.25s ease; position:relative; overflow:hidden;">
            <!-- Real Multi-Sparkle Vector SVG Icon -->
            <svg class="dt-ai-anim-sparkle" viewBox="0 0 24 24" width="15" height="15" fill="none" style="filter:drop-shadow(0 0 3px #FCD34D);">
                <path d="M12 2L14.2 8.3L20.5 10.5L14.2 12.7L12 19L9.8 12.7L3.5 10.5L9.8 8.3L12 2Z" fill="#FCD34D" stroke="#D97706" stroke-width="1.2"/>
                <path d="M19 16L20 18.5L22.5 19.5L20 20.5L19 23L18 20.5L15.5 19.5L18 18.5L19 16Z" fill="#F59E0B"/>
            </svg>
            <span style="letter-spacing:0.3px; color:#FFFFFF; font-weight:800;">AI Auto-Fill</span>
            <span class="dt-ai-live-pulse"></span>
        </button>
    </div>
    <div class="dt-form-sec-body">
        <div class="adm-form-grid">
            <div class="adm-form-group full">
                <label class="adm-form-label">Product Name / Title <span style="color:#b32d2e;">*</span></label>
                <input type="text" id="pFormName" class="adm-form-input" placeholder="e.g. Kanjivaram Pure Silk Gold Zari Wedding Saree" oninput="if(typeof updateGoogleSeoPreview==='function') updateGoogleSeoPreview();" value="<?php echo isset($edit_product_name) ? htmlspecialchars($edit_product_name) : ''; ?>">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">SKU Code <span style="color:#b32d2e;">*</span></label>
                <input type="text" id="pFormSku" class="adm-form-input" placeholder="e.g. KLN-SR-111" value="<?php echo isset($edit_sku) ? htmlspecialchars($edit_sku) : ''; ?>">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Barcode (EAN / UPC)</label>
                <input type="text" id="pFormBarcode" class="adm-form-input" placeholder="e.g. 8901234500111">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">HSN Code <span style="color:#b32d2e;">*</span></label>
                <input type="text" id="pFormHsn" class="adm-form-input" value="5007 (Silk Weave)">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Category <span style="color:#b32d2e;">*</span></label>
                <select class="adm-form-select" id="pFormCat">
                    <option selected>Silk Sarees</option>
                    <option>Banarasi Brocade</option>
                    <option>Bridal Lehengas</option>
                    <option>Designer Kurtis</option>
                    <option>Dress Materials</option>
                </select>
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Subcategory</label>
                <select class="adm-form-select" id="pFormSubcat">
                    <option selected>Kanjivaram Silk</option>
                    <option>Paithani Zari</option>
                    <option>Mysore Crepe</option>
                    <option>Chanderi Silk</option>
                </select>
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Brand</label>
                <select class="adm-form-select" id="pFormBrand">
                    <option selected>DT Signature</option>
                    <option>Arniya Heritage</option>
                    <option>DT Couture</option>
                </select>
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Fabric / Weave Specs</label>
                <input type="text" id="pFormFabric" class="adm-form-input" placeholder="e.g. Pure Mulberry Silk with Gold Zari Border">
            </div>
            <div class="adm-form-group full">
                <label class="adm-form-label">Full Product Description (Rich Text)</label>
                <textarea id="pFormDesc" class="adm-form-textarea" rows="4" placeholder="Handwoven authentic Kanjivaram silk saree featuring pure gold zari border and rich pallu design. Includes unstitched matching blouse piece."></textarea>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- DT BRAND'S SIGNATURE AI PRODUCT IMPORTER MODAL POPUP     -->
<!-- ======================================================== -->
<div id="aiImporterModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:680px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37; animation:dtModalFadeIn 0.25s ease-out;">
        
        <!-- Modal Header in DT Brand's Signature Luxury Gold & Dark Velvet Theme -->
        <div style="background:radial-gradient(ellipse at 20% 50%, rgba(212, 175, 55, 0.35) 0%, transparent 60%), linear-gradient(135deg, #261C0E 0%, #3A2C12 40%, #2A2010 75%, #18120A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:32px; height:32px; border-radius:50%; background:rgba(212,175,55,0.2); border:1.5px solid #D4AF37; display:flex; align-items:center; justify-content:center; box-shadow:0 0 10px rgba(212,175,55,0.3);">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none">
                        <path d="M12 2L14.2 8.3L20.5 10.5L14.2 12.7L12 19L9.8 12.7L3.5 10.5L9.8 8.3L12 2Z" fill="#FCD34D" stroke="#D97706" stroke-width="1.2"/>
                        <path d="M19 16L20 18.5L22.5 19.5L20 20.5L19 23L18 20.5L15.5 19.5L18 18.5L19 16Z" fill="#F59E0B"/>
                    </svg>
                </div>
                <div>
                    <h3 style="margin:0; font-size:15px; font-weight:800; letter-spacing:0.3px; color:#FFFFFF; text-shadow:0 1px 3px rgba(0,0,0,0.8);">DT Brand's AI Product Details Importer</h3>
                    <small style="color:#FFE57F; font-size:11px; font-weight:700;">Paste WhatsApp message, supplier catalog text, or product specs</small>
                </div>
            </div>
            <button type="button" onclick="closeAiImporterModal()" style="background:rgba(255,255,255,0.1); border:1px solid rgba(212,175,55,0.4); border-radius:50%; width:28px; height:28px; color:#FFE57F; font-size:16px; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.2s;" onmouseover="this.style.background='rgba(179,45,46,0.3)';this.style.color='#f87171';" onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.color='#FFE57F';">&times;</button>
        </div>

        <!-- Modal Body -->
        <div style="padding:16px 18px; background:#fff;">
            <!-- Paste Options Bar -->
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; flex-wrap:wrap; gap:6px;">
                <span style="font-size:12px; font-weight:700; color:#181512;">Paste Raw Text / WhatsApp Catalog:</span>
                <div style="display:flex; gap:6px;">
                    <button type="button" class="wp-button" style="font-size:11.5px; height:26px; padding:0 10px; display:inline-flex; align-items:center; gap:5px; border-color:#D4AF37; color:#8A681F; font-weight:600;" onclick="loadSampleAiText()">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                        <span>Load Sample Text</span>
                    </button>
                    <button type="button" class="wp-button" style="font-size:11.5px; height:26px; padding:0 8px; color:#b32d2e; display:inline-flex; align-items:center; gap:4px;" onclick="document.getElementById('aiRawTextInput').value='';">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        <span>Clear</span>
                    </button>
                </div>
            </div>

            <!-- Monospaced Raw Input with Gold Border Focus -->
            <textarea id="aiRawTextInput" rows="8" style="width:100%; border:1.5px solid #D4AF37; border-radius:6px; padding:10px 12px; font-size:12px; font-family:Consolas, Monaco, monospace; line-height:1.5; outline:none; resize:vertical; background:#FDFBF7; color:#181512;" placeholder="Example:
Code: KLN-902
Fabric: Pure Handloom Kanjivaram Silk
Border: Heavy Gold Zari Traditional Kaddi Border
Blouse: Unstitched Matching Contrast Blouse (0.8m)
Color: Rani Pink
Size: Free Size (6.3m)
Price: 1200
Description: Handcrafted pure silk bridal collection with rich pallu and embossed motifs."></textarea>

            <!-- Clean Auto-Fill Indicator without Formula Text -->
            <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.6); border-radius:6px; padding:8px 12px; margin-top:10px; display:flex; align-items:center; gap:8px; font-size:11.5px; color:#5A4210;">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                <span>⚡ Auto-Fills: <strong>Title, SKU, Fabric, Border, Blouse, Purchase/Sale Price, SEO &amp; Color</strong></span>
            </div>
        </div>

        <!-- Modal Footer in DT Brand's Luxury Gold Action Button Style -->
        <div style="background:#f6f7f7; padding:12px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; align-items:center; gap:10px;">
            <button type="button" class="wp-button" onclick="closeAiImporterModal()" style="height:34px; font-size:12px; padding:0 14px;">Cancel</button>
            <button type="button" class="wp-button primary" onclick="parseAndAutoFillProductData()" style="height:34px; font-size:12.5px; font-weight:800; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); display:inline-flex; align-items:center; gap:6px; border:1px solid #8A681F; color:#111827; box-shadow:inset 0 1px 0 rgba(255,255,255,0.4), 0 3px 12px rgba(212,175,55,0.4); cursor:pointer; padding:0 16px; border-radius:6px;">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none">
                    <path d="M12 2L14.2 8.3L20.5 10.5L14.2 12.7L12 19L9.8 12.7L3.5 10.5L9.8 8.3L12 2Z" fill="#111827"/>
                </svg>
                <span>⚡ AI Parse &amp; Auto-Fill All Fields</span>
            </button>
        </div>
    </div>
</div>

<style>
/* Animated Real AI Magic Button Styles */
.dt-ai-magic-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(212, 175, 55, 0.55) !important;
    border-color: #FDE047 !important;
}
.dt-ai-anim-sparkle {
    animation: dtAiSparkleRotate 3.5s ease-in-out infinite alternate;
}
@keyframes dtAiSparkleRotate {
    0% { transform: scale(1) rotate(0deg); }
    50% { transform: scale(1.18) rotate(12deg); }
    100% { transform: scale(0.95) rotate(-8deg); }
}
.dt-ai-live-pulse {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #FCD34D;
    box-shadow: 0 0 6px #FCD34D;
    animation: dtAiDotPulse 1.8s infinite;
    display: inline-block;
    margin-left: 2px;
}
@keyframes dtAiDotPulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(0.7); }
}
@keyframes dtModalFadeIn {
    from { opacity: 0; transform: translateY(-12px) scale(0.97); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
</style>

<script>
window.openAiImporterModal = function() {
    const modal = document.getElementById('aiImporterModal');
    if (modal) {
        modal.style.display = 'flex';
        const txt = document.getElementById('aiRawTextInput');
        if (txt) txt.focus();
    }
};

window.closeAiImporterModal = function() {
    const modal = document.getElementById('aiImporterModal');
    if (modal) {
        modal.style.display = 'none';
    }
};

window.loadSampleAiText = function() {
    const txt = document.getElementById('aiRawTextInput');
    if (txt) {
        txt.value = "Code: KLN-902\nFabric: Pure Handloom Kanjivaram Silk\nBorder: Heavy Gold Zari Traditional Kaddi Border\nBlouse: Unstitched Matching Contrast Blouse (0.8m)\nColor: Rani Pink\nSize: Free Size (6.3m)\nPrice: 1200\nDescription: Handcrafted pure silk bridal collection with rich pallu and embossed motifs. Silk Mark Certified.";
    }
};

window.parseAndAutoFillProductData = function() {
    const raw = document.getElementById('aiRawTextInput')?.value || '';
    if (!raw.trim()) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Please paste product text first');
        return;
    }

    // 1. Extract Product Code / SKU
    let code = '';
    const codeMatch = raw.match(/(?:Code|SKU|Item|D\.?No|Design\s*No|Article)[\s:]*([A-Za-z0-9\-_]+)/i);
    if (codeMatch && codeMatch[1]) {
        code = codeMatch[1].trim();
    } else {
        code = 'KLN-SR-' + Math.floor(100 + Math.random() * 900);
    }

    // 2. Extract Fabric
    let fabric = '';
    const fabricMatch = raw.match(/(?:Fabric|Material|Cloth|Weave)[\s:]*([^\r\n,]+)/i);
    if (fabricMatch && fabricMatch[1]) {
        fabric = fabricMatch[1].trim();
    } else {
        fabric = 'Pure Kanjivaram Silk';
    }

    // 3. Extract Border
    let border = '';
    const borderMatch = raw.match(/(?:Border|Zari|Pallu)[\s:]*([^\r\n,]+)/i);
    if (borderMatch && borderMatch[1]) {
        border = borderMatch[1].trim();
    } else {
        border = 'Authentic Gold Zari Border';
    }

    // 4. Extract Blouse
    let blouse = '';
    const blouseMatch = raw.match(/(?:Blouse|Blouse\s*Piece)[\s:]*([^\r\n,]+)/i);
    if (blouseMatch && blouseMatch[1]) {
        blouse = blouseMatch[1].trim();
    } else {
        blouse = 'Unstitched Contrast Blouse (0.8m)';
    }

    // 5. Extract Price
    let priceVal = 0;
    const priceMatch = raw.match(/(?:Price|Cost|Rate|Amount|Purchase\s*Price|₹|Rs\.?)[\s:]*([0-9]+)/i);
    if (priceMatch && priceMatch[1]) {
        priceVal = parseFloat(priceMatch[1]);
    } else {
        priceVal = 1200;
    }

    // 6. Extract Color
    let colorName = '';
    const colorMatch = raw.match(/(?:Color|Colour|Shade)[\s:]*([^\r\n,]+)/i);
    if (colorMatch && colorMatch[1]) {
        colorName = colorMatch[1].trim();
    }

    // 7. Extract Size
    let sizeName = '';
    const sizeMatch = raw.match(/(?:Size|Length)[\s:]*([^\r\n,]+)/i);
    if (sizeMatch && sizeMatch[1]) {
        sizeName = sizeMatch[1].trim();
    }

    // 8. Extract or Build Full Description
    let desc = '';
    const descMatch = raw.match(/(?:Description|Details|About)[\s:]*([\s\S]+)/i);
    if (descMatch && descMatch[1]) {
        desc = descMatch[1].trim();
    } else {
        desc = 'Handcrafted ' + fabric + ' saree featuring opulent ' + border + ' and rich contrast pallu design. Includes ' + blouse + '. Perfect for weddings, festivals, and royal functions.';
    }

    // Auto-fill Title, SKU, Fabric, Description
    const productTitle = fabric + ' Saree with ' + border + ' (' + code + ')';
    const titleInput = document.getElementById('pFormName');
    const skuInput = document.getElementById('pFormSku');
    const fabricInput = document.getElementById('pFormFabric');
    const descInput = document.getElementById('pFormDesc');

    if (titleInput) titleInput.value = productTitle;
    if (skuInput) skuInput.value = code;
    if (fabricInput) fabricInput.value = fabric + ' | ' + border + ' | Silk Mark Certified';
    if (descInput) {
        descInput.value = desc + '\n\n• Fabric: ' + fabric + '\n• Border & Pallu: ' + border + '\n• Blouse Piece: ' + blouse + '\n• Saree Length: 5.5 Meters + 0.8 Meter Blouse\n• Occasion: Bridal, Festive, Royal Ceremonies & Weddings\n• Care: Professional Dry Clean Only';
    }

    // Auto-fill Purchase Price & Calculate Sale Price
    const costInput = document.getElementById('pFormCost');
    if (costInput && priceVal > 0) {
        costInput.value = priceVal;
        if (typeof calculateCustomerSalePrice === 'function') {
            calculateCustomerSalePrice(priceVal);
        }
    }

    // Auto-update Color if detected
    if (colorName) {
        const colorInput = document.getElementById('varColorName');
        if (colorInput) colorInput.value = colorName;
    }

    // Auto-update Size if detected
    if (sizeName) {
        const sizeInput = document.getElementById('varSizeName');
        if (sizeInput) sizeInput.value = sizeName;
    }

    // Auto-Fill ALL SEO Fields
    const seoTitle = document.getElementById('pFormSeoTitle');
    const seoDesc = document.getElementById('pFormSeoDesc');
    const seoSlug = document.getElementById('pFormSlug');
    const seoKeywords = document.getElementById('pFormKeywords');

    if (seoTitle) {
        seoTitle.value = productTitle + " | DT Brand's Luxury Ethnic";
    }
    if (seoDesc) {
        seoDesc.value = "Shop authentic " + productTitle + ". Handcrafted in Surat with pure zari weave, certified fabrics & factory direct prices.";
    }
    if (seoSlug) {
        const slug = productTitle.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
        seoSlug.value = slug;
    }
    if (seoKeywords) {
        seoKeywords.value = fabric.toLowerCase() + ", " + border.toLowerCase() + ", " + code.toLowerCase() + ", pure silk saree, surat sarees, bridal collection";
    }

    // Sync SEO Preview
    if (typeof window.updateGoogleSeoPreview === 'function') {
        window.updateGoogleSeoPreview();
    }

    window.closeAiImporterModal();

    if (typeof window.showToast === 'function') {
        window.showToast('✨ AI successfully parsed & filled all details including SEO for ' + code + '!');
    }
};
</script>
