<?php
/**
 * product-form.php — Basic Product Information Form with Smart AI Importer Modal
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
        <h3 class="dt-form-sec-title" style="margin:0;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            <span>Basic Information &amp; Taxonomy</span>
        </h3>

        <!-- Animated Real AI Magic Button in Right Corner -->
        <button type="button" id="btnAiMagicGenerate" class="dt-ai-magic-btn" onclick="openAiImporterModal()" style="display:inline-flex; align-items:center; gap:6px; background:linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4f46e5 100%); color:#fff; border:1px solid rgba(165,180,252,0.4); padding:4px 12px; border-radius:20px; font-size:11.5px; font-weight:700; cursor:pointer; box-shadow:0 2px 10px rgba(79,70,229,0.35); transition:all 0.25s ease; position:relative; overflow:hidden;">
            <!-- Real Animated Multi-Sparkle SVG Icon -->
            <svg class="dt-ai-anim-sparkle" viewBox="0 0 24 24" width="15" height="15" fill="none" style="filter:drop-shadow(0 0 4px #a5b4fc);">
                <path d="M12 2L14.2 8.3L20.5 10.5L14.2 12.7L12 19L9.8 12.7L3.5 10.5L9.8 8.3L12 2Z" fill="#FCD34D" stroke="#F59E0B" stroke-width="1.2" stroke-linejoin="round"/>
                <path d="M19 16L20 18.5L22.5 19.5L20 20.5L19 23L18 20.5L15.5 19.5L18 18.5L19 16Z" fill="#60A5FA" stroke="#3B82F6" stroke-width="1" stroke-linejoin="round"/>
                <path d="M5 2L5.8 4L7.8 4.8L5.8 5.6L5 7.6L4.2 5.6L2.2 4.8L4.2 4L5 2Z" fill="#F472B6" stroke="#EC4899" stroke-width="0.8" stroke-linejoin="round"/>
            </svg>
            <span style="letter-spacing:0.2px; background:linear-gradient(90deg, #FFFFFF, #E0E7FF); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">AI Auto-Fill</span>
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
<!-- SMART AI FAST PRODUCT IMPORTER & AUTO-FILL MODAL POPUP  -->
<!-- ======================================================== -->
<div id="aiImporterModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(15,23,42,0.65); backdrop-filter:blur(4px); z-index:999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:680px; border-radius:10px; box-shadow:0 20px 40px rgba(0,0,0,0.3); overflow:hidden; border:1px solid rgba(212,175,55,0.4); animation:dtModalFadeIn 0.25s ease-out;">
        
        <!-- Modal Header -->
        <div style="background:linear-gradient(135deg, #1e1b4b 0%, #312e81 60%, #4338ca 100%); padding:14px 18px; color:#fff; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:8px;">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none">
                    <path d="M12 2L14.2 8.3L20.5 10.5L14.2 12.7L12 19L9.8 12.7L3.5 10.5L9.8 8.3L12 2Z" fill="#FCD34D" stroke="#F59E0B" stroke-width="1.2"/>
                    <path d="M19 16L20 18.5L22.5 19.5L20 20.5L19 23L18 20.5L15.5 19.5L18 18.5L19 16Z" fill="#60A5FA"/>
                </svg>
                <div>
                    <h3 style="margin:0; font-size:15px; font-weight:700; letter-spacing:0.3px; color:#FFFFFF;">AI Fast Product Details Importer</h3>
                    <small style="color:#C7D2FE; font-size:11px;">Paste WhatsApp message, supplier catalog text, or product specs</small>
                </div>
            </div>
            <button type="button" onclick="closeAiImporterModal()" style="background:none; border:none; color:#C7D2FE; font-size:20px; cursor:pointer; line-height:1; font-weight:700;">&times;</button>
        </div>

        <!-- Modal Body -->
        <div style="padding:16px 18px;">
            <!-- Paste Options Bar -->
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; flex-wrap:wrap; gap:6px;">
                <span style="font-size:12px; font-weight:700; color:#1d2327;">Paste Raw Text / WhatsApp Catalog:</span>
                <div style="display:flex; gap:6px;">
                    <button type="button" class="wp-button" style="font-size:11px; height:24px; padding:0 8px;" onclick="loadSampleAiText()">📋 Load Sample Text</button>
                    <button type="button" class="wp-button" style="font-size:11px; height:24px; padding:0 8px; color:#b32d2e;" onclick="document.getElementById('aiRawTextInput').value='';">✕ Clear</button>
                </div>
            </div>

            <textarea id="aiRawTextInput" rows="8" style="width:100%; border:1px solid #c3c4c7; border-radius:6px; padding:10px 12px; font-size:12px; font-family:monospace; line-height:1.5; outline:none; resize:vertical; background:#F8FAFC;" placeholder="Example:
Code: KLN-902
Fabric: Pure Handloom Kanjivaram Silk
Border: Heavy Gold Zari Traditional Kaddi Border
Blouse: Unstitched Matching Contrast Blouse (0.8m)
Color: Rani Pink
Size: Free Size (6.3m)
Purchase Price: 1200
Description: Handcrafted pure silk bridal collection with rich pallu and embossed motifs."></textarea>

            <!-- Auto-Fill Preview Indicators -->
            <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.4); border-radius:6px; padding:8px 12px; margin-top:10px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:6px; font-size:11.5px;">
                <span style="color:#5A4210;">⚡ Auto-Fills: <strong>Title, SKU, Fabric, Border, Blouse, Purchase/Sale Price, SEO &amp; Color</strong></span>
                <span class="adm-badge gold" style="font-size:10.5px;">Auto Markup Rule Applied</span>
            </div>
        </div>

        <!-- Modal Footer -->
        <div style="background:#f6f7f7; padding:12px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; align-items:center; gap:10px;">
            <button type="button" class="wp-button" onclick="closeAiImporterModal()" style="height:32px; font-size:12px;">Cancel</button>
            <button type="button" class="wp-button primary" onclick="parseAndAutoFillProductData()" style="height:32px; font-size:12px; font-weight:700; background:linear-gradient(135deg, #1e1b4b 0%, #4338ca 100%); display:inline-flex; align-items:center; gap:6px; border:none; color:#fff; box-shadow:0 2px 8px rgba(67,56,202,0.4);">
                <svg viewBox="0 0 24 24" width="14" height="14" fill="none">
                    <path d="M12 2L14.2 8.3L20.5 10.5L14.2 12.7L12 19L9.8 12.7L3.5 10.5L9.8 8.3L12 2Z" fill="#FCD34D"/>
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
    box-shadow: 0 4px 14px rgba(99, 102, 241, 0.55) !important;
    border-color: #a5b4fc !important;
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
    background: #34d399;
    box-shadow: 0 0 6px #34d399;
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
function openAiImporterModal() {
    const modal = document.getElementById('aiImporterModal');
    if (modal) {
        modal.style.display = 'flex';
        document.getElementById('aiRawTextInput').focus();
    }
}

function closeAiImporterModal() {
    const modal = document.getElementById('aiImporterModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

function loadSampleAiText() {
    document.getElementById('aiRawTextInput').value = `Code: KLN-902
Fabric: Pure Handloom Kanjivaram Silk
Border: Heavy Gold Zari Traditional Kaddi Border
Blouse: Unstitched Matching Contrast Blouse (0.8m)
Color: Rani Pink
Size: Free Size (6.3m)
Price: 1200
Description: Handcrafted pure silk bridal collection with rich pallu and embossed motifs. Silk Mark Certified.`;
}

function parseAndAutoFillProductData() {
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
    const fabricMatch = raw.match(/(?:Fabric|Material|Cloth|Weave)[\s:]*([^
,]+)/i);
    if (fabricMatch && fabricMatch[1]) {
        fabric = fabricMatch[1].trim();
    } else {
        fabric = 'Pure Kanjivaram Silk';
    }

    // 3. Extract Border
    let border = '';
    const borderMatch = raw.match(/(?:Border|Zari|Pallu)[\s:]*([^
,]+)/i);
    if (borderMatch && borderMatch[1]) {
        border = borderMatch[1].trim();
    } else {
        border = 'Authentic Gold Zari Border';
    }

    // 4. Extract Blouse
    let blouse = '';
    const blouseMatch = raw.match(/(?:Blouse|Blouse\s*Piece)[\s:]*([^
,]+)/i);
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
    const colorMatch = raw.match(/(?:Color|Colour|Shade)[\s:]*([^
,]+)/i);
    if (colorMatch && colorMatch[1]) {
        colorName = colorMatch[1].trim();
    }

    // 7. Extract Size
    let sizeName = '';
    const sizeMatch = raw.match(/(?:Size|Length)[\s:]*([^
,]+)/i);
    if (sizeMatch && sizeMatch[1]) {
        sizeName = sizeMatch[1].trim();
    }

    // 8. Extract or Build Full Description
    let desc = '';
    const descMatch = raw.match(/(?:Description|Details|About)[\s:]*([\s\S]+)/i);
    if (descMatch && descMatch[1]) {
        desc = descMatch[1].trim();
    } else {
        desc = `Handcrafted ${fabric} saree featuring opulent ${border} and rich contrast pallu design. Includes ${blouse}. Perfect for weddings, festivals, and royal functions.`;
    }

    // ============================================
    // AUTO-FILL INTO DOM FORM FIELDS
    // ============================================

    // Title & SKU
    const productTitle = `${fabric} Saree with ${border} (${code})`;
    const titleInput = document.getElementById('pFormName');
    const skuInput = document.getElementById('pFormSku');
    const fabricInput = document.getElementById('pFormFabric');
    const descInput = document.getElementById('pFormDesc');

    if (titleInput) titleInput.value = productTitle;
    if (skuInput) skuInput.value = code;
    if (fabricInput) fabricInput.value = `${fabric} | ${border} | Silk Mark Certified`;
    if (descInput) {
        descInput.value = `${desc}

• Fabric: ${fabric}
• Border & Pallu: ${border}
• Blouse Piece: ${blouse}
• Saree Length: 5.5 Meters + 0.8 Meter Blouse
• Occasion: Bridal, Festive, Royal Ceremonies & Weddings
• Care: Professional Dry Clean Only`;
    }

    // Purchase Price & Auto-Calculated Customer Sale Price
    const costInput = document.getElementById('pFormCost');
    if (costInput && priceVal > 0) {
        costInput.value = priceVal;
        if (typeof calculateCustomerSalePrice === 'function') {
            calculateCustomerSalePrice(priceVal);
        }
    }

    // Auto-update Color Studio if color detected
    if (colorName) {
        const colorInput = document.getElementById('varColorName');
        if (colorInput) colorInput.value = colorName;
    }

    // Auto-update Size Studio if size detected
    if (sizeName) {
        const sizeInput = document.getElementById('varSizeName');
        if (sizeInput) sizeInput.value = sizeName;
    }

    // Sync SEO Preview
    if (typeof updateGoogleSeoPreview === 'function') {
        updateGoogleSeoPreview();
    }

    closeAiImporterModal();

    if (typeof window.showToast === 'function') {
        window.showToast(`✨ AI successfully parsed & filled all details for "${code}"!`);
    }
}
</script>
