<?php
/**
 * edit.php — DT Brand's Edit Category Suite (Wholesale & Luxury Shop Standard)
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Edit Category";
$active_nav = "products";
$active_subnav = "categories";
$cat_id = isset($_GET['id']) ? intval($_GET['id']) : 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category ‹ Silk Sarees ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Frontend/Admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/Frontend/Admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
    .dt-edit-grid {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 18px;
        align-items: start;
    }
    @media (max-width: 1024px) {
        .dt-edit-grid { grid-template-columns: 1fr; }
    }
    .dt-card {
        background: #ffffff;
        border: 1.5px solid rgba(212,175,55,0.4);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        margin-bottom: 18px;
    }
    .dt-card-header {
        background: radial-gradient(ellipse at 20% 50%, rgba(212, 175, 55, 0.35) 0%, transparent 60%), linear-gradient(135deg, #261C0E 0%, #3A2C12 40%, #2A2010 75%, #18120A 100%);
        padding: 12px 16px;
        color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 2px solid #D4AF37;
    }
    .dt-card-body {
        padding: 16px;
    }
    .dt-form-group {
        margin-bottom: 14px;
    }
    .dt-form-group label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #181512;
        margin-bottom: 4px;
    }
    .dt-form-input, .dt-form-select, .dt-form-textarea {
        width: 100%;
        height: 34px;
        padding: 0 10px;
        font-size: 12.5px;
        color: #181512;
        background: #ffffff;
        border: 1px solid #c3c4c7;
        border-radius: 4px;
        box-sizing: border-box;
        outline: none;
        transition: all 0.15s ease;
    }
    .dt-form-textarea {
        height: 70px;
        padding: 8px 10px;
        resize: vertical;
    }
    .dt-form-input:focus, .dt-form-select:focus, .dt-form-textarea:focus {
        border-color: #8A681F;
        box-shadow: 0 0 0 1px #8A681F, 0 0 8px rgba(212,175,55,0.25);
    }
    .dt-kpi-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 12px;
    }
    .dt-kpi-item:last-child {
        border-bottom: none;
    }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 16px 20px;">

            <!-- 1. Header Toolbar -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:16px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Edit Category</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px;">ID: #<?php echo $cat_id; ?></span>
                    <span class="adm-badge" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-weight:700; font-size:11px;">Silk Sarees</span>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px;">420 Active SKUs</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <a href="/Frontend/Admin/products/categories/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Product Categories</span>
                    </a>
                    <a href="/Frontend/Shop/shop.php?category=silk-sarees" target="_blank" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; text-decoration:none;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <span>View on Shop</span>
                    </a>
                    <button type="button" class="wp-button primary" onclick="handleSaveCategory()" style="background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F; padding:0 14px; height:32px; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Save &amp; Update Category</span>
                    </button>
                </div>
            </div>

            <!-- 2. Dual Column Master Edit Layout -->
            <form id="editCategoryForm" onsubmit="event.preventDefault(); handleSaveCategory();">
                <div class="dt-edit-grid">
                    
                    <!-- LEFT / MAIN COLUMN -->
                    <div>
                        
                        <!-- Core Details Card -->
                        <div class="dt-card">
                            <div class="dt-card-header">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#D4AF37" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    <h3 style="margin:0; font-size:14px; font-weight:800; color:#FAF5E8;">Category Taxonomy &amp; Specifications</h3>
                                </div>
                                <span style="font-size:11px; color:#D4AF37; font-weight:700;">Silk Mark Certified</span>
                            </div>
                            <div class="dt-card-body">
                                <div class="dt-form-group">
                                    <label>Category Name <span style="color:#b32d2e;">*</span></label>
                                    <input type="text" id="editName" class="dt-form-input" value="Silk Sarees" required oninput="updateSlugPreview(this.value)">
                                    <small style="color:#646970; font-size:11px; margin-top:3px; display:block;">Public title displayed on wholesale catalog &amp; retail shop.</small>
                                </div>

                                <div class="dt-form-group">
                                    <label>URL Slug</label>
                                    <input type="text" id="editSlug" class="dt-form-input" value="silk-sarees">
                                    <div style="margin-top:4px; font-size:11px; color:#8A681F;">
                                        <strong>Live URL:</strong> <code>https://jaihanumantex.in/category/<span id="slugLiveText">silk-sarees</span></code>
                                    </div>
                                </div>

                                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                                    <div class="dt-form-group">
                                        <label>Parent Category</label>
                                        <select id="editParent" class="dt-form-select">
                                            <option value="none" selected>None (Top Level Root Category)</option>
                                            <option value="banarasi-brocade">Banarasi Brocade</option>
                                            <option value="bridal-lehengas">Bridal Lehengas</option>
                                            <option value="designer-kurtis">Designer Kurtis</option>
                                        </select>
                                    </div>

                                    <div class="dt-form-group">
                                        <label>Display Type</label>
                                        <select id="editDisplay" class="dt-form-select">
                                            <option value="default" selected>Default</option>
                                            <option value="products">Products Only</option>
                                            <option value="subcategories">Subcategories</option>
                                            <option value="both">Both (Products &amp; Subcategories)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="dt-form-group">
                                    <label>HSN Code &amp; GST Tax Class</label>
                                    <input type="text" id="editHsn" class="dt-form-input" value="5007 (5% Silk GST)">
                                    <small style="color:#646970; font-size:11px; margin-top:3px; display:block;">HSN 5007 for Silk Fabric with 5% GST rate.</small>
                                </div>

                                <div class="dt-form-group">
                                    <label>Category Description</label>
                                    <textarea id="editDesc" class="dt-form-textarea" rows="3">Pure Mulberry &amp; Kanjivaram Bridal Silks with 24K Gold Zari Weaves direct from Surat factory central looms.</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- SEO & Metadata Card -->
                        <div class="dt-card">
                            <div class="dt-card-header">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#D4AF37" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                    <h3 style="margin:0; font-size:14px; font-weight:800; color:#FAF5E8;">Search Engine Optimization (SEO)</h3>
                                </div>
                                <button type="button" class="wp-button" onclick="autoGenerateCatSeo()" style="height:26px; font-size:11px; padding:0 8px; background:#FAF5E8; border-color:#D4AF37; color:#8A681F; font-weight:700;">⚡ Auto SEO</button>
                            </div>
                            <div class="dt-card-body">
                                <div class="dt-form-group">
                                    <label>SEO Meta Title</label>
                                    <input type="text" id="seoTitle" class="dt-form-input" value="Pure Silk Sarees Online — Wholesale &amp; Bridal Collection | DT Brand's">
                                </div>
                                <div class="dt-form-group">
                                    <label>Meta Description</label>
                                    <textarea id="seoDesc" class="dt-form-textarea" rows="2">Buy authentic Kanjivaram and pure silk sarees at wholesale factory prices from DT Brand's &amp; Jai Hanuman Tex. Express dispatch across India.</textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT COLUMN: Media & Wholesale Insights -->
                    <div>
                        
                        <!-- Media Card -->
                        <div class="dt-card">
                            <div class="dt-card-header">
                                <h3 style="margin:0; font-size:14px; font-weight:800; color:#FAF5E8;">Category Media</h3>
                            </div>
                            <div class="dt-card-body">
                                <label style="font-size:12px; font-weight:700; color:#181512; display:block; margin-bottom:6px;">Thumbnail Icon</label>
                                <div style="display:flex; align-items:center; gap:12px; margin-bottom:14px;">
                                    <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" id="editThumbPreview" style="width:70px; height:70px; object-fit:cover; border-radius:6px; border:1.5px solid #D4AF37;">
                                    <input type="file" id="editFileInput" style="display:none;" accept="image/*" onchange="if(this.files&&this.files[0]){const r=new FileReader(); r.onload=e=>document.getElementById('editThumbPreview').src=e.target.result; r.readAsDataURL(this.files[0]); if(window.showToast) window.showToast('Thumbnail updated!');}">
                                    <button type="button" class="wp-button" onclick="document.getElementById('editFileInput').click()" style="height:32px; font-size:11.5px; font-weight:600;">
                                        Upload Image
                                    </button>
                                </div>

                                <label style="font-size:12px; font-weight:700; color:#181512; display:block; margin-bottom:6px;">Category Hero Banner (16:9)</label>
                                <div style="border:1px dashed #c3c4c7; border-radius:6px; padding:12px; text-align:center; background:#FAF5E8;">
                                    <small style="color:#8A681F; font-weight:600; display:block; margin-bottom:6px;">Recommended: 1200 x 400 px</small>
                                    <button type="button" class="wp-button primary" onclick="if(window.showToast) window.showToast('Banner upload modal opened');" style="height:28px; font-size:11px; background:linear-gradient(135deg, #8A681F, #D4AF37); color:#181512; font-weight:700;">+ Choose Banner</button>
                                </div>
                            </div>
                        </div>

                        <!-- Wholesale KPI Insights -->
                        <div class="dt-card">
                            <div class="dt-card-header">
                                <h3 style="margin:0; font-size:14px; font-weight:800; color:#FAF5E8;">Wholesale B2B Insights</h3>
                            </div>
                            <div class="dt-card-body" style="padding:12px 16px;">
                                <div class="dt-kpi-item">
                                    <span style="color:#646970;">Assigned Designs</span>
                                    <strong style="color:#181512; font-size:13px;">420 SKUs</strong>
                                </div>
                                <div class="dt-kpi-item">
                                    <span style="color:#646970;">B2B Valuation</span>
                                    <strong style="color:#15803D; font-size:13px;">₹18.40 Lakhs</strong>
                                </div>
                                <div class="dt-kpi-item">
                                    <span style="color:#646970;">Surat Mill Stock</span>
                                    <strong style="color:#1D4ED8; font-size:13px;">3,200 Units Ready</strong>
                                </div>
                                <div class="dt-kpi-item">
                                    <span style="color:#646970;">Average Resale Margin</span>
                                    <strong style="color:#8A681F; font-size:13px;">+36% Profit</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Publishing & Actions -->
                        <div class="dt-card">
                            <div class="dt-card-header">
                                <h3 style="margin:0; font-size:14px; font-weight:800; color:#FAF5E8;">Publishing Actions</h3>
                            </div>
                            <div class="dt-card-body">
                                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                                    <span style="font-size:12px; color:#646970;">Status:</span>
                                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px;">🟢 Published &amp; Active</span>
                                </div>
                                <button type="submit" class="wp-button primary" style="width:100%; height:36px; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F; margin-bottom:8px;">
                                    Save Changes
                                </button>
                                <a href="/Frontend/Admin/products/?cat=silk-sarees" class="wp-button" style="width:100%; height:32px; justify-content:center; text-decoration:none; margin-bottom:8px; font-size:12px;">
                                    📦 View Products in Category (420)
                                </a>
                                <button type="button" class="wp-button" style="width:100%; height:30px; justify-content:center; color:#b32d2e; border-color:#fca5a5; font-size:11.5px;" onclick="if(confirm('Are you sure you want to delete this category?')) { if(window.showToast) window.showToast('Category moved to trash'); window.location.href = '/admin/products/categories/'; }">
                                    🗑️ Move Category to Trash
                                </button>
                            </div>
                        </div>

                    </div>

                </div>
            </form>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function updateSlugPreview(name) {
    const slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    document.getElementById('editSlug').value = slug;
    document.getElementById('slugLiveText').textContent = slug;
}

function autoGenerateCatSeo() {
    const name = document.getElementById('editName')?.value || 'Category';
    document.getElementById('seoTitle').value = `${name} Online — Wholesale & Bridal Collection | DT Brand's`;
    document.getElementById('seoDesc').value = `Explore authentic ${name} at factory wholesale prices from DT Brand's & Jai Hanuman Tex Surat. High quality craftsmanship with fast dispatch.`;
    if (typeof window.showToast === 'function') window.showToast('✨ Auto SEO tags generated!');
}

function handleSaveCategory() {
    const name = document.getElementById('editName')?.value || 'Category';
    if (typeof window.showToast === 'function') window.showToast(`✨ Category "${name}" updated successfully!`);
}
</script>
</body>
</html>
