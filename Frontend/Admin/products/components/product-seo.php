<?php
/**
 * product-seo.php — Search Engine Optimization & Google Search Preview
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <span>Search Engine Optimization (SEO)</span>
        </h3>
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
                <input type="text" class="adm-form-input" placeholder="pure silk saree, wholesale surat, banarasi zari">
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
