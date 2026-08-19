<?php
/**
 * product-form.php — Basic Product Information Form with Animated AI Generator
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
        <button type="button" id="btnAiMagicGenerate" class="dt-ai-magic-btn" onclick="triggerAiMagicGenerate()" style="display:inline-flex; align-items:center; gap:6px; background:linear-gradient(135deg, #1e1b4b 0%, #312e81 40%, #4f46e5 100%); color:#fff; border:1px solid rgba(165,180,252,0.4); padding:4px 11px; border-radius:20px; font-size:11.5px; font-weight:700; cursor:pointer; box-shadow:0 2px 10px rgba(79,70,229,0.35); transition:all 0.25s ease; position:relative; overflow:hidden;">
            <!-- Real Animated Multi-Sparkle SVG Icon -->
            <svg class="dt-ai-anim-sparkle" viewBox="0 0 24 24" width="15" height="15" fill="none" style="filter:drop-shadow(0 0 4px #a5b4fc);">
                <path d="M12 2L14.2 8.3L20.5 10.5L14.2 12.7L12 19L9.8 12.7L3.5 10.5L9.8 8.3L12 2Z" fill="#FCD34D" stroke="#F59E0B" stroke-width="1.2" stroke-linejoin="round"/>
                <path d="M19 16L20 18.5L22.5 19.5L20 20.5L19 23L18 20.5L15.5 19.5L18 18.5L19 16Z" fill="#60A5FA" stroke="#3B82F6" stroke-width="1" stroke-linejoin="round"/>
                <path d="M5 2L5.8 4L7.8 4.8L5.8 5.6L5 7.6L4.2 5.6L2.2 4.8L4.2 4L5 2Z" fill="#F472B6" stroke="#EC4899" stroke-width="0.8" stroke-linejoin="round"/>
            </svg>
            <span style="letter-spacing:0.2px; background:linear-gradient(90deg, #FFFFFF, #E0E7FF); -webkit-background-clip:text; -webkit-text-fill-color:transparent;">AI Assistant</span>
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
</style>

<script>
function triggerAiMagicGenerate() {
    const titleInput = document.getElementById('pFormName');
    const descInput = document.getElementById('pFormDesc');
    const fabricInput = document.getElementById('pFormFabric');
    const skuInput = document.getElementById('pFormSku');
    const btn = document.getElementById('btnAiMagicGenerate');

    if (btn) {
        btn.style.opacity = '0.7';
        btn.innerHTML = `
            <svg class="dt-ai-anim-sparkle" viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#FCD34D" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>
            <span>Generating...</span>
        `;
    }

    setTimeout(() => {
        if (!titleInput.value) {
            titleInput.value = "Handwoven Kanjivaram Pure Silk Saree with Authentic Gold Zari Border";
        }
        if (!skuInput.value) {
            skuInput.value = "KLN-SR-" + Math.floor(100 + Math.random() * 900);
        }
        if (!fabricInput.value) {
            fabricInput.value = "100% Pure Mulberry Silk | Heavy 3-Ply Gold Zari Weave | 650 GSM";
        }
        if (!descInput.value) {
            descInput.value = `Indulge in timeless luxury with this authentic Surat-woven Kanjivaram silk masterpiece. Meticulously handcrafted from 100% pure mulberry silk threads, this saree showcases intricate traditional temple motifs along a majestic gold zari border and opulent contrast pallu.

• Fabric: Premium Mulberry Silk (Silk Mark Certified)
• Zari: Micro-finished rich metallic gold brocade
• Saree Length: 5.5 Meters | Blouse Piece: 0.8 Meter (Unstitched)
• Occasion: Bridal, Festive, Royal Ceremonies & Weddings
• Care: Professional Dry Clean Only`;
        }

        if (btn) {
            btn.style.opacity = '1';
            btn.innerHTML = `
                <svg class="dt-ai-anim-sparkle" viewBox="0 0 24 24" width="15" height="15" fill="none" style="filter:drop-shadow(0 0 4px #a5b4fc);">
                    <path d="M12 2L14.2 8.3L20.5 10.5L14.2 12.7L12 19L9.8 12.7L3.5 10.5L9.8 8.3L12 2Z" fill="#FCD34D" stroke="#F59E0B" stroke-width="1.2" stroke-linejoin="round"/>
                </svg>
                <span>AI Generated!</span>
                <span class="dt-ai-live-pulse"></span>
            `;
        }

        if (typeof updateGoogleSeoPreview === 'function') {
            updateGoogleSeoPreview();
        }

        if (typeof window.showToast === 'function') {
            window.showToast('✨ AI successfully generated rich product details & descriptions!');
        }
    }, 450);
}
</script>
