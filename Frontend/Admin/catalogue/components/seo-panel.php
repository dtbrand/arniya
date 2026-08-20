<?php
/**
 * seo-panel.php — Category & Collection Search Engine Optimization Panel Component
 * DT Brand's & Jai Hanuman Tex
 */
$seo_cat_name = isset($cat['name']) ? $cat['name'] : (isset($cat_name) ? $cat_name : 'Silk Sarees & Handlooms');
$seo_cat_slug = isset($cat['slug']) ? $cat['slug'] : 'silk-sarees';
$seo_title = "Pure {$seo_cat_name} Wholesale | DT Brand's Surat";
$seo_desc = "Buy authentic pure {$seo_cat_name} at direct Surat factory wholesale rates. Certified handloom and luxury weaves with fast depot dispatch.";
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
                    <input type="text" id="seoTitleInput" class="dt-form-input" value="<?php echo htmlspecialchars($seo_title); ?>" oninput="document.getElementById('serpTitleDisplay').textContent = this.value; document.getElementById('seoTitleCount').textContent = this.value.length + ' / 60';">
                    <div class="dt-char-meter ok">
                        <span>Optimal length: 50–60 characters</span>
                        <span id="seoTitleCount"><?php echo mb_strlen($seo_title); ?> / 60</span>
                    </div>
                </div>

                <div class="dt-form-group">
                    <label class="dt-form-label">Meta Description</label>
                    <textarea id="seoDescInput" class="dt-form-textarea" rows="3" oninput="document.getElementById('serpDescDisplay').textContent = this.value; document.getElementById('seoDescCount').textContent = this.value.length + ' / 160';"><?php echo htmlspecialchars($seo_desc); ?></textarea>
                    <div class="dt-char-meter ok">
                        <span>Optimal length: 140–160 characters</span>
                        <span id="seoDescCount"><?php echo mb_strlen($seo_desc); ?> / 160</span>
                    </div>
                </div>

                <div class="dt-form-group">
                    <label class="dt-form-label">Focus SEO Keywords</label>
                    <input type="text" class="dt-form-input" value="<?php echo strtolower($seo_cat_name); ?> wholesale, surat textile depot, bulk lot price, dt brands surat">
                </div>
            </div>

            <!-- Google SERP Live Snippet Box -->
            <div>
                <label class="dt-form-label">Google Search Result Preview (SERP)</label>
                <div class="dt-serp-preview">
                    <div class="dt-serp-header">
                        <div class="dt-serp-favicon">DT</div>
                        <div class="dt-serp-meta">
                            <div class="dt-serp-sitename">DT Brand's &amp; Jai Hanuman Tex</div>
                            <div class="dt-serp-url">https://jaihanumantex.in › shop › <?php echo htmlspecialchars($seo_cat_slug); ?></div>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="dt-serp-title" id="serpTitleDisplay"><?php echo htmlspecialchars($seo_title); ?></a>
                    <div class="dt-serp-snippet" id="serpDescDisplay">
                        <?php echo htmlspecialchars($seo_desc); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
