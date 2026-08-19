<?php
/**
 * product-seo.php — Search Engine Optimization & Google Search Preview
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head"><h3 class="dt-form-sec-title"><span>🔍 Search Engine Optimization (SEO)</span></h3></div>
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

        <div style="margin-top:16px;">
            <label class="adm-form-label" style="margin-bottom:6px; display:block;">Google Search Snippet Preview</label>
            <div class="dt-google-snippet">
                <div class="dt-google-url" id="dtGoogleUrlPreview">https://jaihanumantex.in/product/kanjivaram-pure-silk-saree</div>
                <div class="dt-google-title" id="dtGoogleTitlePreview">Kanjivaram Pure Silk Gold Zari Saree | DT Brand's Luxury Ethnic</div>
                <div class="dt-google-desc" id="dtGoogleDescPreview">Handcrafted pure silk sarees woven with authentic zari border. Order wholesale lots or single pieces directly from Surat mills.</div>
            </div>
        </div>
    </div>
</div>
