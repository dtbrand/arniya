<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * product-form.php — Title, SKU, category and cloth details
 * DT Brand's & Jai Hanuman Tex
 *
 * Four inputs here had no column behind them and were never submitted, yet
 * three of them shipped pre-filled so they read like saved values: HSN Code
 * defaulted to "5007 (Silk Weave)" (and was marked required with a red star),
 * Subcategory to "Kanjivaram Silk" out of four hardcoded options, Brand to
 * "DT Signature", and Barcode was a permanently empty box. They are gone; when
 * `products` gains hsn / barcode / brand_id columns they can come back as real
 * fields.
 *
 * The Category select fell back to a hardcoded list of six names whenever the
 * database was unreachable, and pre-selected 'Kanjivaram Silk' on a product
 * that had no category — so an admin who never touched the dropdown filed the
 * saree under a category they had not chosen. It now shows only real rows from
 * `categories`, with an explicit "not chosen yet" state.
 *
 * "Fabric / Weave Specs" was one box writing one column, leaving
 * `products.weave` permanently NULL even though every storefront card reads it.
 * Fabric and Weave are separate fields now, and Occasion — another real column
 * with no input anywhere in the admin — is here too.
 *
 * The AI Auto-Fill importer invented what it could not find: a random SKU
 * 'KLN-SR-###', fabric 'Pure Kanjivaram Silk', border 'Authentic Gold Zari
 * Border', blouse 'Unstitched Contrast Blouse (0.8m)', price 1200, a
 * "Handcrafted ... Perfect for weddings, festivals, and royal functions."
 * description, a bullet list asserting "Saree Length: 5.5 Meters" and "Care:
 * Professional Dry Clean Only", plus all four SEO boxes — then toasted
 * "AI successfully parsed & filled all details". Pasting three lines about a
 * cotton saree produced a form full of confident claims about silk. It now
 * fills only what the pasted text actually says, and reports what it could not
 * find.
 */
$pfName = (string)($edit_product_name ?? ($prod['title'] ?? ($prod['name'] ?? '')));
$pfSku = (string)($edit_sku ?? ($prod['sku'] ?? ''));
$pfFabric = trim((string)($prod['fabric'] ?? ''));
$pfWeave = trim((string)($prod['weave'] ?? ''));
$pfOccasion = trim((string)($prod['occasion'] ?? ''));
$pfDesc = (string)($prod['description'] ?? '');
$pfCat = trim((string)($prod['category'] ?? ($prod['category_name'] ?? '')));
$pfCats = class_exists('\DTBrand\ProductCatalog') ? \DTBrand\ProductCatalog::getCategories() : [];
$pfSellingType = trim((string)($prod['selling_type'] ?? 'single_piece')) ?: 'single_piece';
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
        <h3 class="dt-form-sec-title" style="margin:0;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            <span>Basic Information &amp; Taxonomy</span>
        </h3>
        <button type="button" id="btnAiMagicGenerate" class="dt-ai-magic-btn" onclick="openAiImporterModal()" style="display:inline-flex; align-items:center; gap:6px; background:linear-gradient(135deg, #2A2010 0%, #443416 50%, #1C150B 100%); color:#FFE57F; border:1.5px solid #D4AF37; padding:5px 14px; border-radius:20px; font-size:12px; font-weight:800; cursor:pointer; box-shadow:0 2px 10px rgba(212,175,55,0.35); transition:all 0.25s ease; position:relative; overflow:hidden;">
            <svg class="dt-ai-anim-sparkle" viewBox="0 0 24 24" width="15" height="15" fill="none" style="filter:drop-shadow(0 0 3px #FCD34D);">
                <path d="M12 2L14.2 8.3L20.5 10.5L14.2 12.7L12 19L9.8 12.7L3.5 10.5L9.8 8.3L12 2Z" fill="#FCD34D" stroke="#D97706" stroke-width="1.2"/>
                <path d="M19 16L20 18.5L22.5 19.5L20 20.5L19 23L18 20.5L15.5 19.5L18 18.5L19 16Z" fill="#F59E0B"/>
            </svg>
            <span style="letter-spacing:0.3px; color:#FFFFFF; font-weight:800;">Paste &amp; Fill</span>
            <span class="dt-ai-live-pulse"></span>
        </button>
    </div>
    <div class="dt-form-sec-body">
        <!-- PRODUCT SELLING TYPE SELECTION (Compact Luxury Bar) -->
        <div class="adm-form-group full" style="background:#FAF8F2; border:1px solid #D4AF37; border-radius:6px; padding:8px 10px; margin-bottom:10px;">
            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:6px; margin-bottom:6px;">
                <label class="adm-form-label" style="font-size:11px; font-weight:800; color:#5A4210; display:inline-flex; align-items:center; gap:5px; margin:0;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" style="color:#8A681F;"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                    <span>PRODUCT SELLING TYPE</span>
                </label>
                <span style="font-size:10px; color:#8A681F; font-weight:600;">Choose single piece or full catalog bundle</span>
            </div>
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:8px;">
                <label id="dtCardSinglePiece" style="display:flex; align-items:center; gap:8px; background:#FFFFFF; border:1.5px solid <?php echo $pfSellingType === 'single_piece' ? '#8A681F' : '#E2E8F0'; ?>; padding:6px 10px; border-radius:5px; cursor:pointer; box-shadow:<?php echo $pfSellingType === 'single_piece' ? '0 1px 4px rgba(138,104,31,0.12)' : 'none'; ?>; transition:all 0.15s ease;">
                    <input type="radio" name="pFormSellingType" value="single_piece" id="pFormSellingTypeSingle" <?php echo $pfSellingType === 'single_piece' ? 'checked' : ''; ?> onchange="window.dtOnSellingTypeChange('single_piece')" style="accent-color:#8A681F; width:13px; height:13px; margin:0; cursor:pointer;">
                    <div style="display:flex; flex-direction:column; gap:1px; min-width:0;">
                        <div style="display:flex; align-items:center; gap:6px;">
                            <strong style="font-size:11.5px; color:#181512; font-weight:800;">SINGLE PIECE</strong>
                            <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:9px; padding:1px 5px; font-weight:700; border-radius:3px;">All 5 Roles</span>
                        </div>
                        <small style="font-size:10px; color:#64748B; line-height:1.2;">Customer Price + Color &rarr; Size selection</small>
                    </div>
                </label>
                <label id="dtCardFullSet" style="display:flex; align-items:center; gap:8px; background:#FFFFFF; border:1.5px solid <?php echo $pfSellingType === 'full_set' ? '#8A681F' : '#E2E8F0'; ?>; padding:6px 10px; border-radius:5px; cursor:pointer; box-shadow:<?php echo $pfSellingType === 'full_set' ? '0 1px 4px rgba(138,104,31,0.12)' : 'none'; ?>; transition:all 0.15s ease;">
                    <input type="radio" name="pFormSellingType" value="full_set" id="pFormSellingTypeFull" <?php echo $pfSellingType === 'full_set' ? 'checked' : ''; ?> onchange="window.dtOnSellingTypeChange('full_set')" style="accent-color:#8A681F; width:13px; height:13px; margin:0; cursor:pointer;">
                    <div style="display:flex; flex-direction:column; gap:1px; min-width:0;">
                        <div style="display:flex; align-items:center; gap:6px;">
                            <strong style="font-size:11.5px; color:#181512; font-weight:800;">FULL SET</strong>
                            <span class="adm-badge" style="background:#FEF3C7; color:#B45309; font-size:9px; padding:1px 5px; font-weight:700; border-radius:3px;">B2B Trade Only</span>
                        </div>
                        <small style="font-size:10px; color:#64748B; line-height:1.2;">100% active variants set (Wholesale &amp; Retailer)</small>
                    </div>
                </label>
            </div>
        </div>

        <div class="adm-form-grid">
            <div class="adm-form-group full">
                <label class="adm-form-label" for="pFormName">Product Name / Title <span style="color:#b32d2e;">*</span></label>
                <input type="text" id="pFormName" class="adm-form-input" placeholder="e.g. Kanjivaram Pure Silk Gold Zari Wedding Saree"
                       oninput="if(typeof updateGoogleSeoPreview==='function') updateGoogleSeoPreview();"
                       value="<?php echo htmlspecialchars($pfName); ?>">
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormSku">SKU Code</label>
                <input type="text" id="pFormSku" class="adm-form-input" placeholder="e.g. KLN-SR-111" value="<?php echo htmlspecialchars($pfSku); ?>">
                <small style="font-size:10.5px; color:#646970;">Leave blank and one is generated from the title. Duplicates get a suffix.</small>
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormCat">Category <span style="color:#b32d2e;">*</span></label>
                <?php if (!empty($pfCats)): ?>
                    <select class="adm-form-select" id="pFormCat">
                        <option value="" <?php echo $pfCat === '' ? 'selected' : ''; ?>>&mdash; Not chosen yet &mdash;</option>
                        <?php foreach ($pfCats as $c): ?>
                            <option value="<?php echo htmlspecialchars($c); ?>" <?php echo (strcasecmp($pfCat, $c) === 0) ? 'selected' : ''; ?>><?php echo htmlspecialchars($c); ?></option>
                        <?php endforeach; ?>
                        <?php if ($pfCat !== '' && !in_array($pfCat, $pfCats, true)): ?>
                            <option value="<?php echo htmlspecialchars($pfCat); ?>" selected><?php echo htmlspecialchars($pfCat); ?> (not in the category list)</option>
                        <?php endif; ?>
                    </select>
                    <small style="font-size:10.5px; color:#646970;">
                        Live rows from the categories table. <a href="/admin/products/categories/add.php" style="color:#8A681F; font-weight:700;">Add a category</a>
                    </small>
                <?php else: ?>
                    <input type="text" id="pFormCat" class="adm-form-input" maxlength="100"
                           placeholder="e.g. Kanjivaram Silk" value="<?php echo htmlspecialchars($pfCat); ?>">
                    <small style="font-size:10.5px; color:#b32d2e;">
                        No categories were readable, so this is a free-text box. The name is stored as typed and
                        links to a real category as soon as one with that name exists.
                        <a href="/admin/products/categories/add.php" style="color:#8A681F; font-weight:700;">Add a category</a>
                    </small>
                <?php endif; ?>
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormFabric">Fabric</label>
                <input type="text" id="pFormFabric" class="adm-form-input" maxlength="100" list="dtFabricPresets"
                       placeholder="e.g. Pure Mulberry Silk" value="<?php echo htmlspecialchars($pfFabric); ?>">
                <datalist id="dtFabricPresets">
                    <option value="Pure Mulberry Silk"></option>
                    <option value="Katan Silk"></option>
                    <option value="Tussar Silk"></option>
                    <option value="Organza Tissue"></option>
                    <option value="Georgette"></option>
                    <option value="Chanderi Cotton Silk"></option>
                    <option value="Handloom Cotton"></option>
                </datalist>
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormWeave">Weave</label>
                <input type="text" id="pFormWeave" class="adm-form-input" maxlength="100" list="dtWeavePresets"
                       placeholder="e.g. Handloom Brocade" value="<?php echo htmlspecialchars($pfWeave); ?>">
                <datalist id="dtWeavePresets">
                    <option value="Handloom Brocade"></option>
                    <option value="Powerloom Jacquard"></option>
                    <option value="Korvai Handloom"></option>
                    <option value="Jamdani"></option>
                    <option value="Glass Tissue"></option>
                    <option value="Plain Weave"></option>
                </datalist>
                <small style="font-size:10.5px; color:#646970;">Separate from Fabric because the shop shows both.</small>
            </div>
            <div class="adm-form-group">
                <label class="adm-form-label" for="pFormOccasion">Occasion</label>
                <input type="text" id="pFormOccasion" class="adm-form-input" maxlength="100" list="dtOccasionPresets"
                       placeholder="e.g. Bridal &amp; Festive" value="<?php echo htmlspecialchars($pfOccasion); ?>">
                <datalist id="dtOccasionPresets">
                    <option value="Bridal &amp; Wedding"></option>
                    <option value="Festive"></option>
                    <option value="Party Wear"></option>
                    <option value="Daily Wear"></option>
                    <option value="Office / Formal"></option>
                    <option value="Temple &amp; Pooja"></option>
                </datalist>
            </div>
            <div class="adm-form-group full">
                <label class="adm-form-label" for="pFormDesc">Full Product Description</label>
                <textarea id="pFormDesc" class="adm-form-textarea" rows="4"
                          oninput="if(typeof updateGoogleSeoPreview==='function') updateGoogleSeoPreview();"
                          placeholder="What the cloth is, how it is woven, what is included. Written by you, not filled in for you."><?php echo htmlspecialchars($pfDesc); ?></textarea>
            </div>
        </div>
    </div>
</div>
<!-- ======================================================== -->
<!-- PASTE & FILL: supplier text / WhatsApp catalog importer  -->
<!-- ======================================================== -->
<div id="aiImporterModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:680px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37; animation:dtModalFadeIn 0.25s ease-out;">
        <div style="background:radial-gradient(ellipse at 20% 50%, rgba(212, 175, 55, 0.35) 0%, transparent 60%), linear-gradient(135deg, #261C0E 0%, #3A2C12 40%, #2A2010 75%, #18120A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <div style="display:flex; align-items:center; gap:10px;">
                <div style="width:32px; height:32px; border-radius:50%; background:rgba(212,175,55,0.2); border:1.5px solid #D4AF37; display:flex; align-items:center; justify-content:center; box-shadow:0 0 10px rgba(212,175,55,0.3);">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none">
                        <path d="M12 2L14.2 8.3L20.5 10.5L14.2 12.7L12 19L9.8 12.7L3.5 10.5L9.8 8.3L12 2Z" fill="#FCD34D" stroke="#D97706" stroke-width="1.2"/>
                        <path d="M19 16L20 18.5L22.5 19.5L20 20.5L19 23L18 20.5L15.5 19.5L18 18.5L19 16Z" fill="#F59E0B"/>
                    </svg>
                </div>
                <div>
                    <h3 style="margin:0; font-size:15px; font-weight:800; letter-spacing:0.3px; color:#FFFFFF; text-shadow:0 1px 3px rgba(0,0,0,0.8);">Paste supplier text &amp; fill the form</h3>
                    <small style="color:#FFE57F; font-size:11px; font-weight:700;">WhatsApp message, catalogue line, or "Field: value" list</small>
                </div>
            </div>
            <button type="button" onclick="closeAiImporterModal()" style="background:rgba(255,255,255,0.1); border:1px solid rgba(212,175,55,0.4); border-radius:50%; width:28px; height:28px; color:#FFE57F; font-size:16px; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.2s;" onmouseover="this.style.background='rgba(179,45,46,0.3)';this.style.color='#f87171';" onmouseout="this.style.background='rgba(255,255,255,0.1)';this.style.color='#FFE57F';">&times;</button>
        </div>
        <div style="padding:16px 18px; background:#fff;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; flex-wrap:wrap; gap:6px;">
                <span style="font-size:12px; font-weight:700; color:#181512;">Paste the supplier's own words:</span>
                <button type="button" class="wp-button" style="font-size:11.5px; height:26px; padding:0 8px; color:#b32d2e; display:inline-flex; align-items:center; gap:4px;" onclick="document.getElementById('aiRawTextInput').value='';">
                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                    <span>Clear</span>
                </button>
            </div>
            <textarea id="aiRawTextInput" rows="8" style="width:100%; border:1.5px solid #D4AF37; border-radius:6px; padding:10px 12px; font-size:12px; font-family:Consolas, Monaco, monospace; line-height:1.5; outline:none; resize:vertical; background:#FDFBF7; color:#181512;" placeholder="Code: KLN-902
Fabric: Pure Handloom Kanjivaram Silk
Weave: Korvai Handloom
Border: Heavy Gold Zari Kaddi Border
Blouse: Unstitched Contrast Blouse (0.8m)
Zari: Pure Silver Tested Zari
Occasion: Bridal
Color: Rani Pink
Size: Free Size (6.3m)
Price: 1200
Description: ..."></textarea>
            <div style="background:#FAF5E8; border:1px solid rgba(212,175,55,0.6); border-radius:6px; padding:8px 12px; margin-top:10px; font-size:11.5px; color:#5A4210; line-height:1.6;">
                Reads Code/SKU, Fabric, Weave, Border, Blouse, Zari, Occasion, Colour, Size, Price and
                Description. <strong>Only fields the text actually states are filled</strong> — anything
                missing is left for you, and boxes you have already typed in are not overwritten. The
                title and the description are never invented.
            </div>
        </div>
        <div style="background:#f6f7f7; padding:12px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; align-items:center; gap:10px;">
            <button type="button" class="wp-button" onclick="closeAiImporterModal()" style="height:34px; font-size:12px; padding:0 14px;">Cancel</button>
            <button type="button" class="wp-button primary" onclick="parseAndAutoFillProductData()" style="height:34px; font-size:12.5px; font-weight:800; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); display:inline-flex; align-items:center; gap:6px; border:1px solid #8A681F; color:#111827; box-shadow:inset 0 1px 0 rgba(255,255,255,0.4), 0 3px 12px rgba(212,175,55,0.4); cursor:pointer; padding:0 16px; border-radius:6px;">
                <span>Fill what the text says</span>
            </button>
        </div>
    </div>
</div>
<style>
.dt-ai-magic-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(212, 175, 55, 0.55) !important;
    border-color: #FDE047 !important;
}
.dt-ai-anim-sparkle { animation: dtAiSparkleRotate 3.5s ease-in-out infinite alternate; }
@keyframes dtAiSparkleRotate {
    0% { transform: scale(1) rotate(0deg); }
    50% { transform: scale(1.18) rotate(12deg); }
    100% { transform: scale(0.95) rotate(-8deg); }
}
.dt-ai-live-pulse {
    width: 6px; height: 6px; border-radius: 50%;
    background: #FCD34D; box-shadow: 0 0 6px #FCD34D;
    animation: dtAiDotPulse 1.8s infinite; display: inline-block; margin-left: 2px;
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
(function () {
    'use strict';

    function toast(msg) {
        if (typeof window.showToast === 'function') { window.showToast(msg); }
        else { alert(msg); }
    }

    window.openAiImporterModal = function () {
        var modal = document.getElementById('aiImporterModal');
        if (!modal) { return; }
        modal.style.display = 'flex';
        var txt = document.getElementById('aiRawTextInput');
        if (txt) { txt.focus(); }
    };

    window.closeAiImporterModal = function () {
        var modal = document.getElementById('aiImporterModal');
        if (modal) { modal.style.display = 'none'; }
    };

    /** Value after a "Label: ..." marker, or '' when the text does not say. */
    function grab(raw, labels) {
        var re = new RegExp('(?:^|[\\r\\n|,])\\s*(?:' + labels + ')\\s*[:\\-=]\\s*([^\\r\\n|]+)', 'i');
        var m = raw.match(re);
        if (!m || !m[1]) { return ''; }
        return m[1].trim().replace(/[\s,;.]+$/, '');
    }

    /**
     * Writes a parsed value into a box, but only when the text really carried it
     * and the admin has not already typed something there. Returns true when it
     * wrote, so the toast can name exactly what changed.
     */
    function fill(id, value, label, filled) {
        if (!value) { return false; }
        var el = document.getElementById(id);
        if (!el) { return false; }
        if (el.tagName === 'SELECT') {
            var hit = null;
            for (var i = 0; i < el.options.length; i++) {
                if (el.options[i].value.toLowerCase() === value.toLowerCase()) { hit = el.options[i].value; break; }
            }
            if (hit === null) { return false; }
            if (String(el.value || '').trim() !== '') { return false; }
            el.value = hit;
        } else {
            if (String(el.value || '').trim() !== '') { return false; }
            el.value = value;
        }
        filled.push(label);
        return true;
    }
    window.parseAndAutoFillProductData = function () {
        var box = document.getElementById('aiRawTextInput');
        var raw = box ? String(box.value || '') : '';
        if (!raw.trim()) {
            toast('Paste the supplier text first.');
            return;
        }

        var found = {
            sku: grab(raw, 'Code|SKU|Item|D\\.?\\s*No|Design\\s*No|Article'),
            fabric: grab(raw, 'Fabric|Material|Cloth'),
            weave: grab(raw, 'Weave|Weaving'),
            border: grab(raw, 'Border|Pallu'),
            blouse: grab(raw, 'Blouse(?:\\s*Piece)?'),
            zari: grab(raw, 'Zari'),
            occasion: grab(raw, 'Occasion|Use|Wear'),
            colour: grab(raw, 'Colou?r|Shade'),
            size: grab(raw, 'Size|Length'),
            title: grab(raw, 'Title|Product|Name'),
            description: grab(raw, 'Description|Details|About')
        };
        var priceTxt = grab(raw, 'Price|Cost|Rate|Amount|Purchase\\s*Price|MRP');
        var priceNum = parseFloat(String(priceTxt).replace(/[^0-9.]/g, ''));

        var filled = [];
        fill('pFormName', found.title, 'Title', filled);
        fill('pFormSku', found.sku, 'SKU', filled);
        // Category is only set when the text names one explicitly, and fill()
        // rejects a name with no matching option, so a paste can never file the
        // saree under a category nobody created — nor guess one from the fabric.
        fill('pFormCat', grab(raw, 'Category'), 'Category', filled);
        fill('pFormFabric', found.fabric, 'Fabric', filled);
        fill('pFormWeave', found.weave, 'Weave', filled);
        fill('pFormOccasion', found.occasion, 'Occasion', filled);
        fill('pFormDesc', found.description, 'Description', filled);
        fill('pFormPallu', found.border, 'Border / pallu', filled);
        fill('pFormBlouse', found.blouse, 'Blouse piece', filled);
        fill('pFormZari', found.zari, 'Zari', filled);
        // Colour and size go into the variant editor's own add boxes. They are
        // not turned into variant rows here: only the admin decides which
        // colour/size combinations this product is actually stocked in.
        fill('varColorName', found.colour, 'Colour (ready to add)', filled);
        fill('varSizeName', found.size, 'Size (ready to add)', filled);

        // A supplier's rate is a purchase cost, not a shop price, so it goes to
        // the calculator box. The old importer wrote 1200 whenever it found no
        // price at all and then derived a "sale price" from it.
        if (isFinite(priceNum) && priceNum > 0 && fill('pFormCost', String(priceNum), 'Purchase cost', filled)) {
            if (typeof window.dtSuggestFromCost === 'function') { window.dtSuggestFromCost(priceNum); }
        }
        // The SEO boxes are deliberately left alone. They used to be written with
        // invented marketing copy ("Handcrafted in Surat with pure zari weave,
        // certified fabrics & factory direct prices"), and products has no meta_*
        // columns to store any of it anyway.
        if (typeof window.updateGoogleSeoPreview === 'function') { window.updateGoogleSeoPreview(); }
        if (typeof window.calcPricePreview === 'function') { window.calcPricePreview(); }

        window.closeAiImporterModal();

        if (!filled.length) {
            toast('Nothing was filled: the text has no "Fabric: ...", "Code: ...", "Price: ..." style lines, '
                + 'or every matching box already has something in it.');
            return;
        }
        toast('Filled from the pasted text: ' + filled.join(', ') + '. Check each one before saving.');
    };
})();
</script>
