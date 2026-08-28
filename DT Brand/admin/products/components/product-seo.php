<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-seo.php — The product URL, and what Google will actually show
 * DT Brand's & Jai Hanuman Tex
 *
 * Of the four boxes this section used to hold, exactly one is stored:
 * `products.slug`. There is no meta_title, meta_description or meta_keywords
 * column anywhere in the schema, and nothing on the storefront prints a
 * <meta name="description"> per product — so SEO Meta Title, Meta Description
 * and Focus Keywords were typed, previewed, and dropped. Worse, they opened
 * pre-filled: Meta Title with "<product title> | DT Brand's", Meta Description
 * with the first 160 characters of the description, Keywords with
 * "<category>, pure silk, wholesale surat" — values an admin would reasonably
 * read as saved. They are gone; the slug stays, and the snippet preview now
 * shows what Google would really see (title tag + the product description).
 *
 * The "AI Generate SEO" button wrote the same invented sentence for every
 * product — "Handcrafted in Surat with pure zari weave, certified fabrics &
 * factory direct prices" — plus a keyword list, then toasted that all three
 * were generated. It is replaced by a slug button that does something real and
 * storable: derive the URL from the title.
 *
 * This file also used to redefine window.updateGoogleSeoPreview, competing with
 * the copy in product-form.js. Only product-form.js owns it now.
 */
$seoSlug = trim((string)($prod['slug'] ?? ''));
$seoTitle = trim((string)($prod['title'] ?? ($prod['name'] ?? '')));
$seoDesc = trim((string)($prod['description'] ?? ''));
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
        <h3 class="dt-form-sec-title" style="margin:0;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            <span>Product URL &amp; Search Preview</span>
        </h3>
        <button type="button" class="wp-button" onclick="dtSlugFromTitle()" style="height:26px; font-size:11px; font-weight:700; color:#8A681F; border-color:#D4AF37; background:#FAF5E8;">
            <span>Build slug from title</span>
        </button>
    </div>
    <div class="dt-form-sec-body">
        <div class="adm-form-group">
            <label class="adm-form-label" for="pFormSlug">URL Slug</label>
            <input type="text" id="pFormSlug" class="adm-form-input" spellcheck="false"
                   placeholder="kanjivaram-pure-silk-saree" value="<?php echo htmlspecialchars($seoSlug); ?>"
                   oninput="if(typeof updateGoogleSeoPreview==='function') updateGoogleSeoPreview();">
            <small style="font-size:10.5px; color:#646970;">
                Stored on the product. Leave blank and it is built from the title; a clash gets a numeric suffix.
                Changing it on a live product changes its link.
            </small>
        </div>

        <div style="margin-top:12px;">
            <label class="adm-form-label" style="margin-bottom:6px; display:block;">Google Search Snippet Preview</label>
            <div class="dt-google-snippet" style="background:#f8f9fa; border:1px solid #dfe1e5; border-radius:6px; padding:12px;">
                <div class="dt-google-url" id="dtGoogleUrlPreview" style="font-size:12px; color:#202124;">https://jaihanumantex.in/product/<?php echo htmlspecialchars($seoSlug !== '' ? $seoSlug : '...'); ?></div>
                <div class="dt-google-title" id="dtGoogleTitlePreview" style="font-size:15px; color:#1a0dab; font-weight:500; margin:2px 0;"><?php echo $seoTitle !== '' ? htmlspecialchars($seoTitle . " | DT Brand's") : 'Product title not set'; ?></div>
                <div class="dt-google-desc" id="dtGoogleDescPreview" style="font-size:12px; color:#4d5156;"><?php echo $seoDesc !== '' ? htmlspecialchars(mb_substr($seoDesc, 0, 160)) : 'No description yet — Google will pick its own snippet.'; ?></div>
            </div>
            <p style="font-size:10.5px; color:#646970; margin:8px 0 0; line-height:1.55;">
                A preview, not a stored record: the shop has no per-product meta description, so the snippet
                comes from the product description above. The Meta Title, Meta Description and Focus Keyword
                boxes that used to sit here had no column behind them and were never saved.
            </p>
        </div>
    </div>
</div>

<script>
window.dtSlugFromTitle = function () {
    var nameEl = document.getElementById('pFormName');
    var slugEl = document.getElementById('pFormSlug');
    if (!nameEl || !slugEl) { return; }
    var name = String(nameEl.value || '').trim();
    if (!name) {
        if (typeof window.showToast === 'function') { window.showToast('Enter the product title first.'); }
        return;
    }
    slugEl.value = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
    if (typeof window.updateGoogleSeoPreview === 'function') { window.updateGoogleSeoPreview(); }
};
</script>
