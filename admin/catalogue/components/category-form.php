<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * category-form.php — Master Category Add/Edit Form Component
 * DT Brand's & Jai Hanuman Tex
 */
$cat = isset($category_data) ? $category_data : [
    'name' => '',
    'slug' => '',
    'parent' => '',
    'desc' => '',
    'short_desc' => '',
    'image' => '/assets/images/product1.png',
    'banner' => '',
    'display_style' => 'banner_grid',
    'active' => 1,
    'featured' => 1,
    'show_menu' => 1,
    'show_home' => 1,
    'show_search' => 1,
    'show_filters' => 1
];
?>
<form onsubmit="return window.DT_CATEGORIES.saveCategoryForm(event)" class="dt-form-grid">
    <!-- Left 2-Col Main Section -->
    <div>
        <div class="dt-form-card">
            <h4 class="dt-form-card-title">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                <span>Basic Category Information</span>
            </h4>

            <div class="dt-form-group">
                <label class="dt-form-label" for="catName">Category Name <span style="color:#DC2626;">*</span></label>
                <input type="text" id="catName" class="dt-form-input" value="<?php echo htmlspecialchars($cat['name']); ?>" required placeholder="e.g. Silk Sarees & Handlooms" oninput="window.DT_CATALOGUE.generateSlug('catName', 'catSlug')">
            </div>

            <div class="dt-form-group">
                <label class="dt-form-label" for="catSlug">URL Slug</label>
                <input type="text" id="catSlug" class="dt-form-input" value="<?php echo htmlspecialchars($cat['slug']); ?>" placeholder="e.g. silk-sarees">
                <small style="font-size:10.5px; color:#64748b;">Unique URL identifier in shop: <code>/shop/category/slug</code></small>
            </div>

            <div class="dt-form-group">
                <label class="dt-form-label" for="catParent">Parent Category</label>
                <select id="catParent" class="dt-form-select">
                    <option value="">— None (Top Level Root Category) —</option>
                    <option value="Silk Sarees" <?php echo $cat['parent'] === 'Silk Sarees' ? 'selected' : ''; ?>>Silk Sarees</option>
                    <option value="Bridal Lehengas" <?php echo $cat['parent'] === 'Bridal Lehengas' ? 'selected' : ''; ?>>Bridal Lehengas</option>
                    <option value="Designer Kurtis" <?php echo $cat['parent'] === 'Designer Kurtis' ? 'selected' : ''; ?>>Designer Kurtis</option>
                    <option value="Dress Materials" <?php echo $cat['parent'] === 'Dress Materials' ? 'selected' : ''; ?>>Dress Materials</option>
                </select>
            </div>

            <div class="dt-form-group">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:5px;">
                    <label class="dt-form-label" for="catDesc" style="margin-bottom:0;">Detailed Description</label>
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_CATALOGUE.generateAiCategoryDesc('catDesc', document.getElementById('catName').value)" style="height:22px; padding:0 8px; font-size:10.5px;" title="AI Auto-Generate Wholesale Description">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <span>AI Write Description</span>
                    </button>
                </div>
                <textarea id="catDesc" class="dt-form-textarea" rows="4" placeholder="Rich wholesale catalog description, fabric specifications, Surat depot stock info..."><?php echo htmlspecialchars($cat['desc']); ?></textarea>
            </div>

            <div class="dt-form-group">
                <label class="dt-form-label" for="catShortDesc">Short Summary / Tagline</label>
                <input type="text" id="catShortDesc" class="dt-form-input" value="<?php echo htmlspecialchars($cat['short_desc']); ?>" placeholder="e.g. Authentic Surat Jacquard Pure Silk Weaves with Zari Border">
            </div>
        </div>

        <!-- Media Assets Card -->
        <div class="dt-form-card">
            <h4 class="dt-form-card-title">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                <span>Category Media &amp; Banners</span>
            </h4>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
                <div class="dt-form-group">
                    <label class="dt-form-label">Category Thumbnail (1:1 Ratio)</label>
                    <div class="dt-upload-zone" onclick="document.getElementById('catThumbUpload').click()">
                        <img id="catThumbPreview" src="<?php echo $cat['image'] ? $cat['image'] : '/assets/images/product1.png'; ?>" class="dt-preview-thumb" style="margin:0 auto 8px auto; display:block;">
                        <input type="file" id="catThumbUpload" style="display:none;" onchange="window.DT_CATALOGUE.previewImage(this, 'catThumbPreview')">
                        <span style="font-size:11px; font-weight:700; color:#8A681F;">Click to Upload Thumbnail</span>
                    </div>
                </div>

                <div class="dt-form-group">
                    <label class="dt-form-label">Category Hero Banner (Desktop / Mobile)</label>
                    <div class="dt-upload-zone" onclick="document.getElementById('catBannerUpload').click()">
                        <img id="catBannerPreview" src="/assets/images/product2.png" style="width:100%; height:60px; object-fit:cover; border-radius:4px; margin-bottom:8px; display:block;">
                        <input type="file" id="catBannerUpload" style="display:none;" onchange="window.DT_CATALOGUE.previewImage(this, 'catBannerPreview')">
                        <span style="font-size:11px; font-weight:700; color:#8A681F;">Click to Upload Hero Banner</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right 1-Col Settings Section -->
    <div>
        <!-- Publish & Visibility Card -->
        <div class="dt-form-card">
            <h4 class="dt-form-card-title">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                <span>Publishing &amp; Visibility</span>
            </h4>

            <div style="display:flex; flex-direction:column; gap:10px;">
                <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                    <input type="checkbox" checked style="width:15px; height:15px;">
                    <span>Active Status (Live on Store)</span>
                </label>
                <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                    <input type="checkbox" checked style="width:15px; height:15px;">
                    <span>Featured Category (Homepage Gold Ribbon)</span>
                </label>
                <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                    <input type="checkbox" checked style="width:15px; height:15px;">
                    <span>Show in Header Mega Menu</span>
                </label>
                <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                    <input type="checkbox" checked style="width:15px; height:15px;">
                    <span>Show in Shop Sidebar Filters</span>
                </label>
            </div>

            <hr style="border:none; border-top:1px solid #f1f5f9; margin:14px 0;">

            <div class="dt-form-group">
                <label class="dt-form-label">Catalogue Display Style</label>
                <select class="dt-form-select">
                    <option value="banner_grid">Banner + 4-Column Product Grid</option>
                    <option value="grid">Standard High-Density Grid</option>
                    <option value="list">Wholesale B2B Lot Table List</option>
                    <option value="custom">Custom Brand Landing Layout</option>
                </select>
            </div>

            <div style="margin-top:16px; display:flex; flex-direction:column; gap:8px;">
                <button type="submit" class="dt-btn-action-sm gold" style="height:34px; justify-content:center; font-size:12px;">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Save Category</span>
                </button>
                <a href="/admin/catalogue/categories/" class="dt-btn-action-sm pale-gold" style="height:32px; justify-content:center; font-size:11.5px; text-decoration:none;">Cancel &amp; Return</a>
            </div>
        </div>
    </div>
</form>
