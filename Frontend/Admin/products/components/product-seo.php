<?php
/**
 * product-seo.php — Search Engine Optimization & Google Search Preview
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
        <h3 class="dt-form-sec-title" style="margin:0;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <span>Search Engine Optimization (SEO)</span>
        </h3>
        <button type="button" class="wp-button" onclick="autoGenerateProductSeo()" style="height:26px; font-size:11px; font-weight:700; color:#8A681F; border-color:#D4AF37; background:#FAF5E8; display:inline-flex; align-items:center; gap:5px;">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 2L14.2 8.3L20.5 10.5L14.2 12.7L12 19L9.8 12.7L3.5 10.5L9.8 8.3L12 2Z"/></svg>
            <span>⚡ AI Generate SEO</span>
        </button>
    </div>
    <div class="dt-form-sec-body">
        <div class="adm-form-grid">
            <div class="adm-form-group full">
                <label class="adm-form-label">SEO Meta Title</label>
                <input type="text" id="pFormSeoTitle" class="adm-form-input" placeholder="e.g. Pure Silk Sarees Online - Surat Weaving | DT Brand's" oninput="if(typeof updateGoogleSeoPreview==='function') updateGoogleSeoPreview();">
            </div>
            <div class="adm-form-group full">
                <label class="adm-form-label">Meta Description</label>
                <textarea id="pFormSeoDesc" class="adm-form-textarea" rows="2" placeholder="Handcrafted pure silk sarees woven with authentic zari border. Order wholesale lots or single pieces directly from Surat mills." oninput="if(typeof updateGoogleSeoPreview==='function') updateGoogleSeoPreview();"></textarea>
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">URL Slug</label>
                <input type="text" id="pFormSlug" class="adm-form-input" placeholder="kanjivaram-pure-silk-saree" oninput="if(typeof updateGoogleSeoPreview==='function') updateGoogleSeoPreview();">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label">Focus Keywords</label>
                <input type="text" id="pFormKeywords" class="adm-form-input" placeholder="pure silk saree, wholesale surat, banarasi zari">
            </div>
        </div>

        <div style="margin-top:12px;">
            <label class="adm-form-label" style="margin-bottom:6px; display:block;">Google Search Snippet Preview</label>
            <div class="dt-google-snippet" style="background:#f8f9fa; border:1px solid #dfe1e5; border-radius:6px; padding:12px;">
                <div class="dt-google-url" id="dtGoogleUrlPreview" style="font-size:12px; color:#202124;">https://jaihanumantex.in/product/kanjivaram-pure-silk-saree</div>
                <div class="dt-google-title" id="dtGoogleTitlePreview" style="font-size:15px; color:#1a0dab; font-weight:500; margin:2px 0;">Kanjivaram Pure Silk Gold Zari Saree | DT Brand's Luxury Ethnic</div>
                <div class="dt-google-desc" id="dtGoogleDescPreview" style="font-size:12px; color:#4d5156;">Handcrafted pure silk sarees woven with authentic zari border. Order wholesale lots or single pieces directly from Surat mills.</div>
            </div>
        </div>
    </div>
</div>

<script>
window.autoGenerateProductSeo = function() {
    const titleVal = document.getElementById('pFormName')?.value || 'Kanjivaram Pure Silk Saree';
    const skuVal = document.getElementById('pFormSku')?.value || '';
    const fabricVal = document.getElementById('pFormFabric')?.value || 'Pure Silk';

    const seoTitle = document.getElementById('pFormSeoTitle');
    const seoDesc = document.getElementById('pFormSeoDesc');
    const seoSlug = document.getElementById('pFormSlug');
    const seoKeywords = document.getElementById('pFormKeywords');

    if (seoTitle) {
        seoTitle.value = titleVal + " | DT Brand's Luxury Ethnic";
    }

    if (seoDesc) {
        seoDesc.value = "Shop authentic " + titleVal + (skuVal ? " (" + skuVal + ")" : "") + ". Handcrafted in Surat with pure zari weave, certified fabrics & factory direct prices.";
    }

    if (seoSlug) {
        const slug = titleVal.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
        seoSlug.value = slug;
    }

    if (seoKeywords) {
        seoKeywords.value = "pure silk saree, " + fabricVal.toLowerCase().split('|')[0].trim() + ", surat sarees, wholesale ethnic wear, bridal silk";
    }

    if (typeof window.updateGoogleSeoPreview === 'function') {
        window.updateGoogleSeoPreview();
    }

    if (typeof window.showToast === 'function') {
        window.showToast('✨ SEO Meta Title, Description & Keywords generated!');
    }
};

window.updateGoogleSeoPreview = function() {
    const title = document.getElementById('pFormSeoTitle')?.value || document.getElementById('pFormName')?.value || "Kanjivaram Pure Silk Gold Zari Saree";
    const desc = document.getElementById('pFormSeoDesc')?.value || document.getElementById('pFormDesc')?.value || "Handcrafted pure silk sarees woven with authentic zari border. Order wholesale lots or single pieces directly from Surat mills.";
    const slug = document.getElementById('pFormSlug')?.value || "product-url-slug";

    const titleEl = document.getElementById('dtGoogleTitlePreview');
    const descEl = document.getElementById('dtGoogleDescPreview');
    const urlEl = document.getElementById('dtGoogleUrlPreview');

    if (titleEl) titleEl.textContent = title.includes("DT Brand") ? title : title + " | DT Brand's Luxury Ethnic";
    if (descEl) descEl.textContent = desc.slice(0, 160);
    if (urlEl) urlEl.textContent = "https://jaihanumantex.in/product/" + slug.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
};
</script>
