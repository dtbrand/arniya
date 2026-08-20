<?php
/**
 * seo-panel.php — Category & Collection Search Engine Optimization Panel Component
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-cat-card">
    <div class="dt-cat-card-header">
        <h3 class="dt-cat-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <span>Search Engine Optimization &amp; Google Rich Snippets</span>
        </h3>
        <button type="button" class="dt-btn-action-sm gold" onclick="if(window.DT_CATALOGUE) window.DT_CATALOGUE.showToast('✅ SEO Meta tags updated live!')" style="height:28px; padding:0 12px; font-size:11px;">Save SEO Settings</button>
    </div>

    <div style="padding:16px;">
        <div style="display:grid; grid-template-columns:1.2fr 1fr; gap:18px;">
            <!-- Inputs -->
            <div>
                <div class="dt-form-group">
                    <label class="dt-form-label">SEO Title (Title Tag)</label>
                    <input type="text" id="seoTitleInput" class="dt-form-input" value="Pure Silk Sarees & Handlooms Wholesale | DT Brand's Surat" oninput="document.getElementById('serpTitleDisplay').textContent = this.value">
                    <div class="dt-char-meter ok"><span>Optimal length: 50-60 characters</span><span>58 / 60</span></div>
                </div>

                <div class="dt-form-group">
                    <label class="dt-form-label">Meta Description</label>
                    <textarea id="seoDescInput" class="dt-form-textarea" rows="3" oninput="document.getElementById('serpDescDisplay').textContent = this.value">Buy authentic pure silk sarees and handlooms at direct Surat wholesale rates. Kanjivaram, Banarasi brocade, and festive weaves with ready depot dispatch.</textarea>
                    <div class="dt-char-meter ok"><span>Optimal length: 140-160 characters</span><span>154 / 160</span></div>
                </div>

                <div class="dt-form-group">
                    <label class="dt-form-label">Focus SEO Keywords</label>
                    <input type="text" class="dt-form-input" value="silk sarees wholesale, surat saree depot, kanjivaram zari saree, dt brands silk">
                </div>
            </div>

            <!-- Google SERP Live Snippet Box -->
            <div>
                <label class="dt-form-label">Google Search Result Preview (SERP)</label>
                <div class="dt-serp-preview">
                    <div class="dt-serp-url">
                        <span>https://jaihanumantex.in</span> › shop › silk-sarees
                    </div>
                    <a href="javascript:void(0)" class="dt-serp-title" id="serpTitleDisplay">Pure Silk Sarees &amp; Handlooms Wholesale | DT Brand's Surat</a>
                    <div class="dt-serp-snippet" id="serpDescDisplay">
                        Buy authentic pure silk sarees and handlooms at direct Surat wholesale rates. Kanjivaram, Banarasi brocade, and festive weaves with ready depot dispatch.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
