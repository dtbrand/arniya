<?php
/**
 * brands/edit.php — DT Brand's Edit House Label Studio (Wholesale Dashboard & Luxury Shop Standard)
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Edit Brand";
$active_nav = "products";
$active_subnav = "brands";
$brand_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$brand_data = [
    1 => ['name' => 'DT Signature', 'tier' => 'Primary Flagship', 'skus' => '680 SKUs', 'valuation' => '₹28.40 Lakhs', 'tagline' => 'Primary Flagship Handloom & Pure Silk Sarees Collection'],
    2 => ['name' => 'Arniya Heritage', 'tier' => 'Heritage Brocade', 'skus' => '420 SKUs', 'valuation' => '₹14.20 Lakhs', 'tagline' => 'Authentic Varanasi Brocades & Traditional Katan Silks'],
    3 => ['name' => 'DT Couture', 'tier' => 'Bridal Luxury', 'skus' => '140 SKUs', 'valuation' => '₹6.00 Lakhs', 'tagline' => 'Handcrafted Bridal Zardosi Lehengas & Luxury Reception Wear'],
];

$cur_brand = isset($brand_data[$brand_id]) ? $brand_data[$brand_id] : $brand_data[1];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Brand ‹ <?php echo htmlspecialchars($cur_brand['name']); ?> ‹ DT Brand's Admin</title>
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
    .dt-brand-avatar-lg {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2A2010 0%, #443416 50%, #1C150B 100%);
        color: #FFE57F;
        font-family: 'Cinzel', serif;
        font-weight: 800;
        font-size: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #D4AF37;
        box-shadow: 0 2px 10px rgba(212,175,55,0.35);
        overflow: hidden;
    }
    .dt-brand-avatar-lg img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 16px 20px;">

            <!-- 1. Header Toolbar with Luxury Brand Gold Buttons -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:16px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Edit Brand</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px;">ID: #<?php echo $brand_id; ?></span>
                    <span class="adm-badge" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-weight:700; font-size:11px;"><?php echo htmlspecialchars($cur_brand['name']); ?></span>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px;"><?php echo htmlspecialchars($cur_brand['skus']); ?></span>
                </div>

                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <a href="/Frontend/Admin/products/brands/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Back to Brands</span>
                    </a>
                    <a href="/Frontend/Shop/shop.php?brand=<?php echo urlencode($cur_brand['name']); ?>" target="_blank" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#EFF6FF; border:1px solid #93C5FD; color:#1D4ED8;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#1D4ED8" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <span>View on Shop</span>
                    </a>
                    <button type="button" class="wp-button primary" onclick="handleSaveBrand()" style="background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F; padding:0 16px; height:32px; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Save &amp; Update Brand</span>
                    </button>
                </div>
            </div>

            <!-- 2. Dual Column Master Brand Studio Layout -->
            <form id="editBrandForm" onsubmit="event.preventDefault(); handleSaveBrand();">
                <div class="dt-edit-grid">
                    
                    <!-- LEFT / MAIN COLUMN -->
                    <div>
                        
                        <!-- Core Brand Details Card -->
                        <div class="dt-card">
                            <div class="dt-card-header">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#D4AF37" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                    <h3 style="margin:0; font-size:14px; font-weight:800; color:#FAF5E8;">Brand Identity &amp; Specifications</h3>
                                </div>
                                <span style="font-size:11px; color:#D4AF37; font-weight:700;">Surat Central Looms</span>
                            </div>
                            <div class="dt-card-body">
                                <div class="dt-form-group">
                                    <label>Brand Name <span style="color:#b32d2e;">*</span></label>
                                    <input type="text" id="editBrandName" class="dt-form-input" value="<?php echo htmlspecialchars($cur_brand['name']); ?>" required oninput="updateBrandSlugLive(this.value)">
                                </div>

                                <div class="dt-form-group">
                                    <label>Brand Tier</label>
                                    <select id="editBrandTier" class="dt-form-select">
                                        <option <?php if($cur_brand['tier']=='Primary Flagship') echo 'selected'; ?>>Primary Flagship</option>
                                        <option <?php if($cur_brand['tier']=='Heritage Brocade') echo 'selected'; ?>>Heritage Brocade</option>
                                        <option <?php if($cur_brand['tier']=='Bridal Luxury') echo 'selected'; ?>>Bridal Luxury</option>
                                        <option>Mill Volume B2B</option>
                                    </select>
                                </div>

                                <div class="dt-form-group">
                                    <label>Tagline / Motto</label>
                                    <input type="text" id="editBrandTagline" class="dt-form-input" value="<?php echo htmlspecialchars($cur_brand['tagline']); ?>">
                                </div>

                                <div class="dt-form-group">
                                    <label>Brand Story / Manifesto</label>
                                    <textarea id="editBrandStory" class="dt-form-textarea" rows="3">Crafting exquisite heritage weaves direct from Surat looms. Preserving 500-year-old Zari and Brocade handloom traditions for modern Indian elegance.</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- SEO & Metadata Card -->
                        <div class="dt-card">
                            <div class="dt-card-header">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#D4AF37" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                    <h3 style="margin:0; font-size:14px; font-weight:800; color:#FAF5E8;">Brand Search Engine Optimization (SEO)</h3>
                                </div>
                                <button type="button" class="wp-button" onclick="autoGenerateBrandSeo()" style="height:26px; font-size:11px; padding:0 8px; background:#FAF5E8; border-color:#D4AF37; color:#8A681F; font-weight:700;">⚡ Auto SEO</button>
                            </div>
                            <div class="dt-card-body">
                                <div class="dt-form-group">
                                    <label>SEO Meta Title</label>
                                    <input type="text" id="brandSeoTitle" class="dt-form-input" value="<?php echo htmlspecialchars($cur_brand['name']); ?> Online Collection | DT Brand's Factory Surat">
                                </div>
                                <div class="dt-form-group">
                                    <label>Meta Description</label>
                                    <textarea id="brandSeoDesc" class="dt-form-textarea" rows="2">Explore official <?php echo htmlspecialchars($cur_brand['name']); ?> catalog at factory wholesale prices from DT Brand's &amp; Jai Hanuman Tex Surat. Express India dispatch.</textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT COLUMN: Media & Wholesale Insights -->
                    <div>
                        
                        <!-- Emblem Media Card -->
                        <div class="dt-card">
                            <div class="dt-card-header">
                                <h3 style="margin:0; font-size:14px; font-weight:800; color:#FAF5E8;">Brand Emblem &amp; Assets</h3>
                            </div>
                            <div class="dt-card-body" style="text-align:center;">
                                <div style="display:flex; justify-content:center; margin-bottom:12px;">
                                    <div class="dt-brand-avatar-lg" id="editPageAvatarPreview">DT</div>
                                </div>
                                <input type="file" id="editPageEmblemInput" style="display:none;" accept="image/*" onchange="handleEditPageLogoUpload(this)">
                                <button type="button" class="wp-button" onclick="document.getElementById('editPageEmblemInput').click()" style="height:32px; font-size:11.5px; font-weight:700; width:100%; justify-content:center; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; display:flex; align-items:center; gap:6px;">
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                    <span>Upload New Emblem Logo</span>
                                </button>
                            </div>
                        </div>

                        <!-- Wholesale KPI Insights -->
                        <div class="dt-card">
                            <div class="dt-card-header">
                                <h3 style="margin:0; font-size:14px; font-weight:800; color:#FAF5E8;">Wholesale B2B Insights</h3>
                            </div>
                            <div class="dt-card-body" style="padding:12px 16px;">
                                <div class="dt-kpi-item">
                                    <span style="color:#646970;">Catalog SKUs</span>
                                    <strong style="color:#181512; font-size:13px;"><?php echo htmlspecialchars($cur_brand['skus']); ?></strong>
                                </div>
                                <div class="dt-kpi-item">
                                    <span style="color:#646970;">B2B Valuation</span>
                                    <strong style="color:#15803D; font-size:13px;"><?php echo htmlspecialchars($cur_brand['valuation']); ?></strong>
                                </div>
                                <div class="dt-kpi-item">
                                    <span style="color:#646970;">Surat Mill Stock</span>
                                    <strong style="color:#1D4ED8; font-size:13px;">4,800 Units Ready</strong>
                                </div>
                                <div class="dt-kpi-item">
                                    <span style="color:#646970;">Average Resale Margin</span>
                                    <strong style="color:#8A681F; font-size:13px;">+38% Wholesale</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Publishing Actions -->
                        <div class="dt-card">
                            <div class="dt-card-header">
                                <h3 style="margin:0; font-size:14px; font-weight:800; color:#FAF5E8;">Publishing Actions</h3>
                            </div>
                            <div class="dt-card-body">
                                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
                                    <span style="font-size:12px; color:#646970;">Status:</span>
                                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11px;">🟢 Active &amp; Live</span>
                                </div>
                                <button type="submit" class="wp-button primary" style="width:100%; height:36px; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F; margin-bottom:8px; display:flex; align-items:center; justify-content:center; gap:6px;">
                                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#181512" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    <span>Save Changes</span>
                                </button>
                                <a href="/Frontend/Admin/products/?brand=<?php echo urlencode($cur_brand['name']); ?>" class="wp-button" style="width:100%; height:32px; justify-content:center; text-decoration:none; margin-bottom:8px; font-size:12px; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-weight:700; display:flex; align-items:center; gap:6px;">
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                    <span>View Products in Label (<?php echo htmlspecialchars($cur_brand['skus']); ?>)</span>
                                </a>
                                <button type="button" class="wp-button" style="width:100%; height:30px; justify-content:center; color:#DC2626; background:#FEF2F2; border:1px solid #FECACA; font-size:11.5px; font-weight:600; display:flex; align-items:center; gap:6px;" onclick="if(confirm('Are you sure you want to delete this brand?')) { if(window.showToast) window.showToast('Brand moved to trash'); window.location.href = '/admin/products/brands/'; }">
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#DC2626" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    <span>Move Brand to Trash</span>
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
function handleEditPageLogoUpload(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('editPageAvatarPreview');
            if (preview) {
                preview.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
            }
            if (typeof window.showToast === 'function') window.showToast('📷 Brand emblem updated successfully!');
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function updateBrandSlugLive(name) {
    const slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    const titleEl = document.getElementById('brandSeoTitle');
    if (titleEl && !titleEl.dataset.customized) {
        titleEl.value = `${name} Online Collection | DT Brand's Factory Surat`;
    }
}

function autoGenerateBrandSeo() {
    const name = document.getElementById('editBrandName')?.value || 'Brand';
    document.getElementById('brandSeoTitle').value = `${name} Online Collection | DT Brand's Factory Surat`;
    document.getElementById('brandSeoDesc').value = `Explore official ${name} catalog at factory wholesale prices from DT Brand's & Jai Hanuman Tex Surat. High quality craftsmanship with fast dispatch.`;
    if (typeof window.showToast === 'function') window.showToast('✨ Auto SEO tags generated!');
}

function handleSaveBrand() {
    const name = document.getElementById('editBrandName')?.value || 'Brand';
    if (typeof window.showToast === 'function') window.showToast(`✨ Brand "${name}" updated successfully!`);
}
</script>
</body>
</html>
