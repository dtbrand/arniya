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
$pfSubCat = trim((string)($prod['subcategory'] ?? ($prod['subcategory_name'] ?? '')));
$pfSubCatId = (int)($prod['subcategory_id'] ?? 0);
$pfCats = class_exists('\DTBrand\ProductCatalog') ? \DTBrand\ProductCatalog::getCategories(false) : [];
if (empty($pfCats) && class_exists('\DTBrand\Database')) {
    try {
        $dbCats = \DTBrand\Database::query("SELECT id, name FROM categories ORDER BY display_order ASC, name ASC");
        if (!empty($dbCats)) {
            $catNames = [];
            foreach ($dbCats as $row) {
                $n = trim((string)($row['name'] ?? ''));
                if ($n !== '' && !in_array($n, $catNames, true)) {
                    $catNames[] = $n;
                }
            }
            if (!empty($catNames)) {
                $pfCats = array_values(array_unique(array_merge($pfCats, $catNames)));
            }
        }
    } catch (\Throwable $e) {}
}
if (class_exists('\DTBrand\Database')) {
    try {
        $prodCats = \DTBrand\Database::query("SELECT DISTINCT category_name FROM products WHERE category_name IS NOT NULL AND TRIM(category_name) != '' ORDER BY category_name ASC");
        if (!empty($prodCats)) {
            foreach ($prodCats as $pcr) {
                $pcn = trim((string)($pcr['category_name'] ?? ''));
                if ($pcn !== '' && !in_array($pcn, $pfCats, true)) {
                    $pfCats[] = $pcn;
                }
            }
        }
    } catch (\Throwable $e) {}
}
$pfAllSubCats = class_exists('\DTBrand\ProductCatalog') ? \DTBrand\ProductCatalog::getSubcategories(0, false) : [];
if (empty($pfAllSubCats) && class_exists('\DTBrand\Database')) {
    try {
        $pfAllSubCats = \DTBrand\Database::query("SELECT s.id, s.category_id, s.name, s.slug, s.status, c.name AS category_name FROM subcategories s LEFT JOIN categories c ON c.id = s.category_id ORDER BY s.name ASC");
    } catch (\Throwable $e) {}
}
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
                        <small style="font-size:10px; color:#64748B; line-height:1.2;">Customer Price + Color <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block; vertical-align:middle;"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg> Size selection</small>
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
            <div class="adm-form-group">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:4px; flex-wrap:wrap; gap:6px;">
                    <label class="adm-form-label" for="pFormCat" style="margin:0;">Category <span style="color:#b32d2e;">*</span></label>
                    <div style="display:inline-flex; align-items:center; gap:6px;">
                        <button type="button" onclick="dtReloadCategoryOptions()" title="Reload categories from live database" style="background:transparent; border:none; cursor:pointer; color:#8A681F; padding:2px 4px; display:inline-flex; align-items:center; font-size:11px; font-weight:700; text-decoration:none;" id="btnReloadCats">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" style="margin-right:3px;"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/></svg>
                            <span>Refresh</span>
                        </button>
                        <button type="button" onclick="dtOpenQuickAddCategoryModal()" class="adm-btn-secondary" style="height:22px; padding:0 8px; font-size:10.5px; border-radius:4px; color:#8A681F; border-color:#D4AF37; background:#FAF5E8; display:inline-flex; align-items:center; gap:4px; font-weight:700; cursor:pointer;">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>+ Add Category</span>
                        </button>
                    </div>
                </div>
                <select class="adm-form-select" id="pFormCat" onchange="if(window.dtOnCategoryChanged) window.dtOnCategoryChanged();">
                    <option value="" <?php echo $pfCat === '' ? 'selected' : ''; ?>>&mdash; Not chosen yet &mdash;</option>
                    <?php foreach ($pfCats as $c): ?>
                        <option value="<?php echo htmlspecialchars($c); ?>" <?php echo (strcasecmp($pfCat, $c) === 0) ? 'selected' : ''; ?>><?php echo htmlspecialchars($c); ?></option>
                    <?php endforeach; ?>
                    <?php if ($pfCat !== '' && !in_array($pfCat, $pfCats, true)): ?>
                        <option value="<?php echo htmlspecialchars($pfCat); ?>" selected><?php echo htmlspecialchars($pfCat); ?> (Current category)</option>
                    <?php endif; ?>
                </select>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:3px; font-size:10.5px; color:#646970;">
                    <span>Live categories (<b id="dtCatCountBadge"><?php echo count($pfCats); ?></b> available). <a href="javascript:void(0)" onclick="dtOpenQuickAddCategoryModal()" style="color:#8A681F; font-weight:700;">+ Quick Add</a></span>
                    <a href="/admin/products/categories/" target="_blank" style="color:#8A681F; font-weight:700; text-decoration:none;">Manage Categories &nearr;</a>
                </div>
            </div>
            <div class="adm-form-group">
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:4px; flex-wrap:wrap; gap:6px;">
                    <label class="adm-form-label" for="pFormSubCat" style="margin:0;">Subcategory</label>
                    <div style="display:inline-flex; align-items:center; gap:6px;">
                        <button type="button" onclick="dtReloadSubcategoryOptions()" title="Reload subcategories from live database" style="background:transparent; border:none; cursor:pointer; color:#8A681F; padding:2px 4px; display:inline-flex; align-items:center; font-size:11px; font-weight:700; text-decoration:none;" id="btnReloadSubCats">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" style="margin-right:3px;"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/></svg>
                            <span>Refresh</span>
                        </button>
                        <button type="button" onclick="dtOpenQuickAddSubcategoryModal()" class="adm-btn-secondary" style="height:22px; padding:0 8px; font-size:10.5px; border-radius:4px; color:#8A681F; border-color:#D4AF37; background:#FAF5E8; display:inline-flex; align-items:center; gap:4px; font-weight:700; cursor:pointer;">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>+ Add Subcategory</span>
                        </button>
                    </div>
                </div>
                <select class="adm-form-select" id="pFormSubCat">
                    <option value="" <?php echo $pfSubCat === '' ? 'selected' : ''; ?>>&mdash; None / Choose Subcategory &mdash;</option>
                    <?php 
                    $hasMatchedSubCat = false;
                    foreach ($pfAllSubCats as $sc): 
                        $scName = $sc['name'] ?? '';
                        $scCatName = $sc['category_name'] ?? '';
                        $scLabel = $scName . ($scCatName ? " ({$scCatName})" : '');
                        $scIsSelected = (strcasecmp($pfSubCat, $scName) === 0 || ($pfSubCatId > 0 && (int)($sc['id'] ?? 0) === $pfSubCatId));
                        if ($scIsSelected) $hasMatchedSubCat = true;
                    ?>
                        <option value="<?php echo htmlspecialchars($scName); ?>" data-cat="<?php echo htmlspecialchars(strtolower($scCatName)); ?>" data-cat-id="<?php echo (int)($sc['category_id'] ?? 0); ?>" data-id="<?php echo (int)($sc['id'] ?? 0); ?>" <?php echo $scIsSelected ? 'selected' : ''; ?>><?php echo htmlspecialchars($scLabel); ?></option>
                    <?php endforeach; ?>
                    <?php if ($pfSubCat !== '' && !$hasMatchedSubCat): ?>
                        <option value="<?php echo htmlspecialchars($pfSubCat); ?>" selected><?php echo htmlspecialchars($pfSubCat); ?> (Current subcategory)</option>
                    <?php endif; ?>
                </select>
                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:3px; font-size:10.5px; color:#646970;">
                    <span>Live subcategories (<b id="dtSubCatCountBadge"><?php echo count($pfAllSubCats); ?></b> available). <a href="javascript:void(0)" onclick="dtOpenQuickAddSubcategoryModal()" style="color:#8A681F; font-weight:700;">+ Quick Add</a></span>
                    <a href="/admin/products/subcategories/" target="_blank" style="color:#8A681F; font-weight:700; text-decoration:none;">Manage Subcategories &nearr;</a>
                </div>
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
            <button type="button" class="dt-btn dt-btn-dark dt-modal-close-btn" onclick="closeAiImporterModal()" aria-label="Close modal" style="display:inline-flex; align-items:center; justify-content:center; width:30px; height:30px; padding:0; border-radius:6px; cursor:pointer;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div style="padding:16px 18px; background:#fff;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; flex-wrap:wrap; gap:6px;">
                <span style="font-size:12px; font-weight:700; color:#181512;">Paste the supplier's own words:</span>
                <button type="button" class="dt-btn dt-btn-pale" style="font-size:11.5px; height:26px; padding:0 8px; color:#b32d2e; display:inline-flex; align-items:center; gap:4px;" onclick="document.getElementById('aiRawTextInput').value='';">
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
            <button type="button" class="dt-btn dt-btn-pale" onclick="closeAiImporterModal()" style="height:34px; font-size:12px; padding:0 14px;">Cancel</button>
            <button type="button" class="dt-btn dt-btn-gold" onclick="parseAndAutoFillProductData()" style="height:34px; font-size:12.5px; font-weight:800; display:inline-flex; align-items:center; gap:6px; padding:0 16px;">
                <span>Fill what the text says</span>
            </button>
        </div>
    </div>
</div>

<!-- QUICK ADD CATEGORY MODAL (WordPress/TailAdmin Luxury Standard) -->
<div id="dtQuickAddCatModal" style="display:none; position:fixed; inset:0; background:rgba(17,24,39,0.7); backdrop-filter:blur(4px); z-index:999999; align-items:center; justify-content:center; padding:16px;">
    <div style="background:#FFFFFF; border:1.5px solid #D4AF37; border-radius:10px; width:100%; max-width:480px; box-shadow:0 10px 30px rgba(0,0,0,0.35); overflow:hidden; animation:dtModalFadeIn 0.25s ease;">
        <div style="background:linear-gradient(135deg, #181512 0%, #2A241E 100%); border-bottom:1.5px solid #D4AF37; padding:12px 18px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:28px; height:28px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.6"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                </div>
                <div>
                    <h3 style="margin:0; font-size:13.5px; font-weight:800; color:#FAF5E8; font-family:'Plus Jakarta Sans',sans-serif;">Add New Category</h3>
                    <p style="margin:0; font-size:10.5px; color:#D4AF37; font-weight:600;">Immediately available in all product forms and shop filters</p>
                </div>
            </div>
            <button type="button" class="dt-btn dt-btn-dark dt-modal-close-btn" onclick="dtCloseQuickAddCategoryModal()" aria-label="Close modal" style="display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; padding:0; border-radius:5px; cursor:pointer;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div style="padding:16px 18px; background:#FFFFFF;">
            <div style="margin-bottom:12px;">
                <label class="adm-form-label" for="dtQuickCatName" style="font-size:11.5px; font-weight:700; color:#181512; margin-bottom:4px; display:block;">Category Name <span style="color:#b32d2e;">*</span></label>
                <input type="text" id="dtQuickCatName" class="adm-form-input" placeholder="e.g. Pure Silk Sarees, Cotton Suits, Lehenga Choli" style="width:100%;" autocomplete="off" oninput="dtAutoGenerateQuickCatSlug()">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:12px;">
                <div>
                    <label class="adm-form-label" for="dtQuickCatSlug" style="font-size:11.5px; font-weight:700; color:#181512; margin-bottom:4px; display:block;">URL Slug</label>
                    <input type="text" id="dtQuickCatSlug" class="adm-form-input" placeholder="pure-silk-sarees" style="width:100%;" autocomplete="off">
                </div>
                <div>
                    <label class="adm-form-label" for="dtQuickCatStatus" style="font-size:11.5px; font-weight:700; color:#181512; margin-bottom:4px; display:block;">Status</label>
                    <select id="dtQuickCatStatus" class="adm-form-select" style="width:100%;">
                        <option value="active" selected>Active (Visible)</option>
                        <option value="inactive">Hidden (Draft)</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="adm-form-label" for="dtQuickCatDesc" style="font-size:11.5px; font-weight:700; color:#181512; margin-bottom:4px; display:block;">Description (Optional)</label>
                <textarea id="dtQuickCatDesc" class="adm-form-textarea" rows="2" placeholder="Brief category description for shop catalogue..." style="width:100%; resize:vertical;"></textarea>
            </div>
        </div>
        <div style="background:#F8FAFC; padding:12px 18px; border-top:1px solid #E2E8F0; display:flex; justify-content:flex-end; align-items:center; gap:10px;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="dtCloseQuickAddCategoryModal()" style="height:32px; font-size:11.5px; padding:0 14px;">Cancel</button>
            <button type="button" id="btnSaveQuickCategory" class="dt-btn dt-btn-gold" onclick="dtSaveQuickCategory()" style="height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px; padding:0 16px;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Save &amp; Select</span>
            </button>
        </div>
    </div>
</div>

<!-- QUICK ADD SUBCATEGORY MODAL (WordPress/TailAdmin Luxury Standard) -->
<div id="dtQuickAddSubCatModal" style="display:none; position:fixed; inset:0; background:rgba(17,24,39,0.7); backdrop-filter:blur(4px); z-index:999999; align-items:center; justify-content:center; padding:16px;">
    <div style="background:#FFFFFF; border:1.5px solid #D4AF37; border-radius:10px; width:100%; max-width:480px; box-shadow:0 10px 30px rgba(0,0,0,0.35); overflow:hidden; animation:dtModalFadeIn 0.25s ease;">
        <div style="background:linear-gradient(135deg, #181512 0%, #2A241E 100%); border-bottom:1.5px solid #D4AF37; padding:12px 18px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:28px; height:28px; border-radius:6px; background:#FAF5E8; border:1px solid #D4AF37; display:flex; align-items:center; justify-content:center; color:#8A681F;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.6"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                </div>
                <div>
                    <h3 style="margin:0; font-size:13.5px; font-weight:800; color:#FAF5E8; font-family:'Plus Jakarta Sans',sans-serif;">Add New Subcategory</h3>
                    <p style="margin:0; font-size:10.5px; color:#D4AF37; font-weight:600;">Linked to parent category and instantly selectable</p>
                </div>
            </div>
            <button type="button" class="dt-btn dt-btn-dark dt-modal-close-btn" onclick="dtCloseQuickAddSubcategoryModal()" aria-label="Close modal" style="display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; padding:0; border-radius:5px; cursor:pointer;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        <div style="padding:16px 18px; background:#FFFFFF;">
            <div style="margin-bottom:12px;">
                <label class="adm-form-label" for="dtQuickSubCatParent" style="font-size:11.5px; font-weight:700; color:#181512; margin-bottom:4px; display:block;">Parent Category <span style="color:#b32d2e;">*</span></label>
                <select id="dtQuickSubCatParent" class="adm-form-select" style="width:100%;">
                    <?php foreach ($pfCats as $c): ?>
                        <option value="<?php echo htmlspecialchars($c); ?>" <?php echo (strcasecmp($pfCat, $c) === 0) ? 'selected' : ''; ?>><?php echo htmlspecialchars($c); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="margin-bottom:12px;">
                <label class="adm-form-label" for="dtQuickSubCatName" style="font-size:11.5px; font-weight:700; color:#181512; margin-bottom:4px; display:block;">Subcategory Name <span style="color:#b32d2e;">*</span></label>
                <input type="text" id="dtQuickSubCatName" class="adm-form-input" placeholder="e.g. Kanjivaram Pure Zari, Banarasi Kadwa Silk, Anarkali Suits" style="width:100%;" autocomplete="off" oninput="dtAutoGenerateQuickSubCatSlug()">
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-bottom:12px;">
                <div>
                    <label class="adm-form-label" for="dtQuickSubCatSlug" style="font-size:11.5px; font-weight:700; color:#181512; margin-bottom:4px; display:block;">URL Slug</label>
                    <input type="text" id="dtQuickSubCatSlug" class="adm-form-input" placeholder="kanjivaram-pure-zari" style="width:100%;" autocomplete="off">
                </div>
                <div>
                    <label class="adm-form-label" for="dtQuickSubCatStatus" style="font-size:11.5px; font-weight:700; color:#181512; margin-bottom:4px; display:block;">Status</label>
                    <select id="dtQuickSubCatStatus" class="adm-form-select" style="width:100%;">
                        <option value="active" selected>Active (Visible)</option>
                        <option value="inactive">Hidden (Draft)</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="adm-form-label" for="dtQuickSubCatDesc" style="font-size:11.5px; font-weight:700; color:#181512; margin-bottom:4px; display:block;">Description (Optional)</label>
                <textarea id="dtQuickSubCatDesc" class="adm-form-textarea" rows="2" placeholder="Brief subcategory details for catalogue..." style="width:100%; resize:vertical;"></textarea>
            </div>
        </div>
        <div style="background:#F8FAFC; padding:12px 18px; border-top:1px solid #E2E8F0; display:flex; justify-content:flex-end; align-items:center; gap:10px;">
            <button type="button" class="dt-btn dt-btn-pale" onclick="dtCloseQuickAddSubcategoryModal()" style="height:32px; font-size:11.5px; padding:0 14px;">Cancel</button>
            <button type="button" id="btnSaveQuickSubCategory" class="dt-btn dt-btn-gold" onclick="dtSaveQuickSubcategory()" style="height:32px; font-size:12px; font-weight:800; display:inline-flex; align-items:center; gap:6px; padding:0 16px;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span>Save &amp; Select</span>
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

    function toast(msg, type) {
        if (typeof window.showToast === 'function') { window.showToast(msg, type); }
        else { console.warn(msg); }
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
        fill('pFormSubCat', grab(raw, 'Subcategory|Sub\\s*Category|Sub-Category'), 'Subcategory', filled);
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

    window.dtOpenQuickAddCategoryModal = function () {
        var m = document.getElementById('dtQuickAddCatModal');
        if (!m) return;
        m.style.display = 'flex';
        var nameInput = document.getElementById('dtQuickCatName');
        if (nameInput) {
            nameInput.value = '';
            setTimeout(function () { nameInput.focus(); }, 50);
        }
        var slugInput = document.getElementById('dtQuickCatSlug');
        if (slugInput) slugInput.value = '';
        var descInput = document.getElementById('dtQuickCatDesc');
        if (descInput) descInput.value = '';
    };

    window.dtCloseQuickAddCategoryModal = function () {
        var m = document.getElementById('dtQuickAddCatModal');
        if (m) m.style.display = 'none';
    };

    window.dtAutoGenerateQuickCatSlug = function () {
        var n = document.getElementById('dtQuickCatName');
        var s = document.getElementById('dtQuickCatSlug');
        if (!n || !s) return;
        s.value = String(n.value || '').toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
    };

    window.dtSaveQuickCategory = function () {
        var nameInput = document.getElementById('dtQuickCatName');
        var name = nameInput ? String(nameInput.value || '').trim() : '';
        if (!name) {
            toast('Please enter a category name.', 'error');
            if (nameInput) nameInput.focus();
            return;
        }
        var slugInput = document.getElementById('dtQuickCatSlug');
        var slug = slugInput ? String(slugInput.value || '').trim() : '';
        if (!slug) {
            slug = String(name).toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
        }
        var statusInput = document.getElementById('dtQuickCatStatus');
        var status = statusInput ? String(statusInput.value || 'active').trim() : 'active';
        var descInput = document.getElementById('dtQuickCatDesc');
        var desc = descInput ? String(descInput.value || '').trim() : '';

        var btn = document.getElementById('btnSaveQuickCategory');
        if (btn) { btn.disabled = true; btn.textContent = 'Saving...'; }

        fetch('/api/categories.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                action: 'create',
                name: name,
                slug: slug,
                status: status,
                description: desc
            })
        }).then(function (r) {
            return r.json().catch(function () {
                throw new Error('Server returned invalid response (HTTP ' + r.status + ')');
            });
        }).then(function (res) {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6"><polyline points="20 6 9 17 4 12"></polyline></svg><span>Save &amp; Select</span>';
            }
            if (!res || !res.success) {
                throw new Error((res && res.message) ? res.message : 'Failed to create category.');
            }
            var select = document.getElementById('pFormCat');
            if (select) {
                if (select.tagName !== 'SELECT') {
                    var newSel = document.createElement('select');
                    newSel.id = 'pFormCat';
                    newSel.className = 'adm-form-select';
                    select.parentNode.replaceChild(newSel, select);
                    select = newSel;
                }
                var found = false;
                for (var i = 0; i < select.options.length; i++) {
                    if (select.options[i].value.toLowerCase() === name.toLowerCase()) {
                        select.selectedIndex = i;
                        found = true;
                        break;
                    }
                }
                if (!found) {
                    var opt = new Option(name, name, true, true);
                    select.add(opt);
                }
            }
            var countBadge = document.getElementById('dtCatCountBadge');
            if (countBadge && select) {
                var c = 0;
                for (var j = 0; j < select.options.length; j++) {
                    if (select.options[j].value !== '') c++;
                }
                countBadge.textContent = c;
            }
            window.dtCloseQuickAddCategoryModal();
            toast(res.message || ('Category "' + name + '" created and selected!'), 'success');
        }).catch(function (err) {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6"><polyline points="20 6 9 17 4 12"></polyline></svg><span>Save &amp; Select</span>';
            }
            toast(err && err.message ? err.message : 'Error creating category.', 'error');
        });
    };

    window.dtReloadCategoryOptions = function () {
        var btn = document.getElementById('btnReloadCats');
        if (btn) {
            btn.style.opacity = '0.5';
            btn.style.pointerEvents = 'none';
        }
        var select = document.getElementById('pFormCat');
        var currentVal = select ? select.value : '';

        fetch('/api/categories.php?all=1', {
            method: 'GET',
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).then(function (r) { return r.json(); })
        .then(function (data) {
            if (btn) {
                btn.style.opacity = '1';
                btn.style.pointerEvents = 'auto';
            }
            if (!data || !data.success) {
                toast('Could not reload categories: ' + (data.message || 'API error'), 'error');
                return;
            }
            var names = data.category_names || [];
            if (!names.length && data.categories) {
                names = data.categories.map(function (c) { return c.name; });
            }
            if (!names.length && data.raw_categories) {
                names = data.raw_categories.map(function (c) { return c.name; });
            }
            if (select && select.tagName === 'SELECT') {
                select.innerHTML = '<option value="">&mdash; Not chosen yet &mdash;</option>';
                var hasCurrent = false;
                names.forEach(function (n) {
                    var opt = new Option(n, n);
                    if (currentVal && n.toLowerCase() === currentVal.toLowerCase()) {
                        opt.selected = true;
                        hasCurrent = true;
                    }
                    select.add(opt);
                });
                if (currentVal && !hasCurrent) {
                    var curOpt = new Option(currentVal + ' (Current)', currentVal, true, true);
                    select.add(curOpt);
                }
            }
            var countBadge = document.getElementById('dtCatCountBadge');
            if (countBadge) {
                countBadge.textContent = names.length;
            }
            toast('Live categories reloaded (' + names.length + ' available).', 'success');
        }).catch(function (e) {
            if (btn) {
                btn.style.opacity = '1';
                btn.style.pointerEvents = 'auto';
            }
            toast('Error reloading categories from database.', 'error');
        });
    };

    window.DT_ALL_SUBCATEGORIES = <?php echo json_encode($pfAllSubCats, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?> || [];
    window.DT_CURRENT_SUBCAT = <?php echo json_encode($pfSubCat); ?>;

    window.dtFilterSubcategoriesByCategory = function (catName, retainVal) {
        var subSelect = document.getElementById('pFormSubCat');
        if (!subSelect) return;
        var currentVal = (typeof retainVal !== 'undefined') ? retainVal : (subSelect.value || window.DT_CURRENT_SUBCAT || '');
        var catClean = String(catName || '').trim().toLowerCase();

        subSelect.innerHTML = '<option value="">&mdash; None / Choose Subcategory &mdash;</option>';

        var all = window.DT_ALL_SUBCATEGORIES || [];
        var matching = [];
        var other = [];

        for (var i = 0; i < all.length; i++) {
            var item = all[i];
            var itemCat = String(item.category_name || '').trim().toLowerCase();
            if (!catClean || itemCat === catClean) {
                matching.push(item);
            } else {
                other.push(item);
            }
        }

        var foundCurrent = false;

        // Render matching subcategories
        if (matching.length > 0) {
            var optGroupMain = (!catClean) ? null : document.createElement('optgroup');
            if (optGroupMain) {
                optGroupMain.label = (catName || 'Selected Category') + ' Subcategories (' + matching.length + ')';
            }
            for (var m = 0; m < matching.length; m++) {
                var s = matching[m];
                var opt = document.createElement('option');
                opt.value = s.name;
                opt.textContent = s.name + (!catClean && s.category_name ? (' (' + s.category_name + ')') : '');
                opt.setAttribute('data-id', s.id);
                opt.setAttribute('data-cat', (s.category_name || '').toLowerCase());
                opt.setAttribute('data-cat-id', s.category_id || 0);
                if (currentVal && String(s.name).toLowerCase() === currentVal.toLowerCase()) {
                    opt.selected = true;
                    foundCurrent = true;
                }
                if (optGroupMain) {
                    optGroupMain.appendChild(opt);
                } else {
                    subSelect.appendChild(opt);
                }
            }
            if (optGroupMain) {
                subSelect.appendChild(optGroupMain);
            }
        }

        // Render other subcategories in an optgroup if a category filter is active
        if (catClean && other.length > 0) {
            var optGroupOther = document.createElement('optgroup');
            optGroupOther.label = 'Other Categories';
            for (var o = 0; o < other.length; o++) {
                var os = other[o];
                var oopt = document.createElement('option');
                oopt.value = os.name;
                oopt.textContent = os.name + (os.category_name ? (' (' + os.category_name + ')') : '');
                oopt.setAttribute('data-id', os.id);
                oopt.setAttribute('data-cat', (os.category_name || '').toLowerCase());
                oopt.setAttribute('data-cat-id', os.category_id || 0);
                if (currentVal && String(os.name).toLowerCase() === currentVal.toLowerCase()) {
                    oopt.selected = true;
                    foundCurrent = true;
                }
                optGroupOther.appendChild(oopt);
            }
            subSelect.appendChild(optGroupOther);
        }

        // If currentVal was set but not in any list, append it as custom option
        if (currentVal && !foundCurrent) {
            var curOpt = document.createElement('option');
            curOpt.value = currentVal;
            curOpt.textContent = currentVal + ' (Current subcategory)';
            curOpt.selected = true;
            subSelect.appendChild(curOpt);
        }

        // Update count badge
        var countBadge = document.getElementById('dtSubCatCountBadge');
        if (countBadge) {
            countBadge.textContent = catClean ? (matching.length + ' in ' + catName) : all.length;
        }
    };

    window.dtOnCategoryChanged = function () {
        var catSelect = document.getElementById('pFormCat');
        var catName = catSelect ? catSelect.value : '';
        window.dtFilterSubcategoriesByCategory(catName);
        var modalParent = document.getElementById('dtQuickSubCatParent');
        if (modalParent && catName) {
            for (var i = 0; i < modalParent.options.length; i++) {
                if (modalParent.options[i].value.toLowerCase() === catName.toLowerCase()) {
                    modalParent.selectedIndex = i;
                    break;
                }
            }
        }
    };

    window.dtOpenQuickAddSubcategoryModal = function () {
        var m = document.getElementById('dtQuickAddSubCatModal');
        if (!m) return;
        m.style.display = 'flex';
        var catSelect = document.getElementById('pFormCat');
        var modalParent = document.getElementById('dtQuickSubCatParent');
        if (modalParent && catSelect && catSelect.value) {
            for (var i = 0; i < modalParent.options.length; i++) {
                if (modalParent.options[i].value.toLowerCase() === catSelect.value.toLowerCase()) {
                    modalParent.selectedIndex = i;
                    break;
                }
            }
        }
        var nameInput = document.getElementById('dtQuickSubCatName');
        if (nameInput) {
            nameInput.value = '';
            setTimeout(function () { nameInput.focus(); }, 50);
        }
        var slugInput = document.getElementById('dtQuickSubCatSlug');
        if (slugInput) slugInput.value = '';
        var descInput = document.getElementById('dtQuickSubCatDesc');
        if (descInput) descInput.value = '';
    };

    window.dtCloseQuickAddSubcategoryModal = function () {
        var m = document.getElementById('dtQuickAddSubCatModal');
        if (m) m.style.display = 'none';
    };

    window.dtAutoGenerateQuickSubCatSlug = function () {
        var n = document.getElementById('dtQuickSubCatName');
        var s = document.getElementById('dtQuickSubCatSlug');
        if (!n || !s) return;
        s.value = String(n.value || '').toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
    };

    window.dtSaveQuickSubcategory = function () {
        var nameInput = document.getElementById('dtQuickSubCatName');
        var name = nameInput ? String(nameInput.value || '').trim() : '';
        if (!name) {
            toast('Please enter a subcategory name.', 'error');
            if (nameInput) nameInput.focus();
            return;
        }
        var parentSelect = document.getElementById('dtQuickSubCatParent');
        var parentCatName = parentSelect ? String(parentSelect.value || '').trim() : '';
        if (!parentCatName) {
            toast('Please select a parent category.', 'error');
            if (parentSelect) parentSelect.focus();
            return;
        }
        var slugInput = document.getElementById('dtQuickSubCatSlug');
        var slug = slugInput ? String(slugInput.value || '').trim() : '';
        if (!slug) {
            slug = String(name).toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
        }
        var statusInput = document.getElementById('dtQuickSubCatStatus');
        var status = statusInput ? String(statusInput.value || 'active').trim() : 'active';
        var descInput = document.getElementById('dtQuickSubCatDesc');
        var desc = descInput ? String(descInput.value || '').trim() : '';

        var btn = document.getElementById('btnSaveQuickSubCategory');
        if (btn) { btn.disabled = true; btn.textContent = 'Saving...'; }

        fetch('/api/categories.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                action: 'create_subcategory',
                name: name,
                category_name: parentCatName,
                slug: slug,
                status: status,
                description: desc
            })
        }).then(function (r) {
            return r.json().catch(function () {
                throw new Error('Server returned invalid response (HTTP ' + r.status + ')');
            });
        }).then(function (res) {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6"><polyline points="20 6 9 17 4 12"></polyline></svg><span>Save &amp; Select</span>';
            }
            if (!res || !res.success) {
                throw new Error((res && res.message) ? res.message : 'Failed to create subcategory.');
            }

            // Sync parent category to #pFormCat if not set or different
            var pCatSelect = document.getElementById('pFormCat');
            if (pCatSelect && (!pCatSelect.value || pCatSelect.value.toLowerCase() !== parentCatName.toLowerCase())) {
                for (var ci = 0; ci < pCatSelect.options.length; ci++) {
                    if (pCatSelect.options[ci].value.toLowerCase() === parentCatName.toLowerCase()) {
                        pCatSelect.selectedIndex = ci;
                        break;
                    }
                }
            }

            // Add new subcategory to window.DT_ALL_SUBCATEGORIES if not present
            var newSubObj = {
                id: res.id || 0,
                name: name,
                slug: slug,
                status: status,
                category_name: parentCatName,
                category_id: res.category_id || 0
            };
            var exists = false;
            for (var si = 0; si < window.DT_ALL_SUBCATEGORIES.length; si++) {
                if (window.DT_ALL_SUBCATEGORIES[si].name.toLowerCase() === name.toLowerCase()) {
                    exists = true;
                    break;
                }
            }
            if (!exists) {
                window.DT_ALL_SUBCATEGORIES.push(newSubObj);
            }

            // Re-filter and select the new subcategory
            window.DT_CURRENT_SUBCAT = name;
            window.dtFilterSubcategoriesByCategory(parentCatName, name);

            window.dtCloseQuickAddSubcategoryModal();
            toast(res.message || ('Subcategory "' + name + '" created and selected!'), 'success');
        }).catch(function (err) {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6"><polyline points="20 6 9 17 4 12"></polyline></svg><span>Save &amp; Select</span>';
            }
            toast(err && err.message ? err.message : 'Error creating subcategory.', 'error');
        });
    };

    window.dtReloadSubcategoryOptions = function () {
        var btn = document.getElementById('btnReloadSubCats');
        if (btn) {
            btn.style.opacity = '0.5';
            btn.style.pointerEvents = 'none';
        }
        var pCat = document.getElementById('pFormCat');
        var catName = pCat ? pCat.value : '';

        fetch('/api/categories.php?all=1', {
            method: 'GET',
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).then(function (r) { return r.json(); })
        .then(function (data) {
            if (btn) {
                btn.style.opacity = '1';
                btn.style.pointerEvents = 'auto';
            }
            if (!data || !data.success) {
                toast('Could not reload subcategories: ' + (data.message || 'API error'), 'error');
                return;
            }
            if (data.subcategories && Array.isArray(data.subcategories)) {
                window.DT_ALL_SUBCATEGORIES = data.subcategories;
                window.dtFilterSubcategoriesByCategory(catName);
                toast('Live subcategories reloaded (' + data.subcategories.length + ' available).', 'success');
            }
        }).catch(function (e) {
            if (btn) {
                btn.style.opacity = '1';
                btn.style.pointerEvents = 'auto';
            }
            toast('Error reloading subcategories from database.', 'error');
        });
    };

    // Initial filter run on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            var initialCat = document.getElementById('pFormCat') ? document.getElementById('pFormCat').value : '';
            window.dtFilterSubcategoriesByCategory(initialCat);
        });
    } else {
        var initialCat = document.getElementById('pFormCat') ? document.getElementById('pFormCat').value : '';
        window.dtFilterSubcategoriesByCategory(initialCat);
    }
})();
</script>
