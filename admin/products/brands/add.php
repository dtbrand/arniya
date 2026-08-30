<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * brands/add.php — Add New House Label
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Add Brand";
$active_nav = "products";
$active_subnav = "brands";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Brand ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
    .dt-form-input:focus, .dt-form-select:focus, .dt-form-textarea:focus {
        border-color: #D4AF37 !important;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.18) !important;
        outline: none;
    }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding:16px 20px; max-width:760px;">
            <form id="addBrandForm" onsubmit="return submitAddBrand(event);">
                <div class="dt-prod-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                    <div class="dt-prod-title-group">
                        <h1 style="font-size:22px; font-weight:800; color:#181512; margin:0;">Add House Brand</h1>
                    </div>
                    <div class="dt-prod-actions" style="display:flex; gap:8px;">
                        <a href="/admin/products/brands/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; text-decoration:none; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-weight:700;">Cancel</a>
                        <button type="submit" class="wp-button primary" style="height:32px; padding:0 16px; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F; box-shadow:0 2px 8px rgba(212,175,55,0.35);">Save Brand</button>
                    </div>
                </div>

                <div class="adm-card" style="background:#fff; border:1px solid #E2E8F0; border-radius:8px; padding:18px;">
                    <!-- Brand Logo Upload Section -->
                    <div style="margin-bottom:16px; padding:14px; background:#FAF5E8; border:1px dashed #D4AF37; border-radius:8px;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:8px;">Brand Logo / House Emblem</label>
                        <div style="display:flex; align-items:center; gap:14px;">
                            <div id="addPageLogoPreview" style="width:58px; height:58px; border-radius:50%; background:linear-gradient(135deg, #181512, #3D342A); color:#D4AF37; font-family:'Cinzel', serif; font-weight:800; font-size:20px; display:flex; align-items:center; justify-content:center; border:2px solid #D4AF37; box-shadow:0 2px 8px rgba(212,175,55,0.3); flex-shrink:0; overflow:hidden;">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#D4AF37" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            </div>
                            <div style="flex:1;">
                                <input type="file" id="brandLogoFile" accept="image/*" style="display:none;" onchange="previewAddPageLogo(this)">
                                <button type="button" class="wp-button" onclick="document.getElementById('brandLogoFile').click()" style="height:32px; font-size:11.5px; font-weight:700; background:#FFFFFF; border:1px solid #D4AF37; color:#8A681F; display:inline-flex; align-items:center; gap:6px; cursor:pointer; padding:0 12px; border-radius:5px;">
                                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                    <span>Upload Brand Logo (PNG, JPG, WebP, SVG)</span>
                                </button>
                                <div style="font-size:11px; color:#64748B; margin-top:4px;">Square logo recommended (min 200x200px)</div>
                            </div>
                        </div>
                    </div>

                    <div class="dt-form-group" style="margin-bottom:14px;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Brand Name <span style="color:#b32d2e;">*</span></label>
                        <input type="text" id="brandName" class="dt-form-input" placeholder="e.g. DT Prêt" required style="width:100%; height:36px; padding:0 12px; font-size:13px; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box;">
                    </div>
                    <div class="dt-form-group" style="margin-bottom:14px;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Brand Slug</label>
                        <input type="text" id="brandSlug" class="dt-form-input" placeholder="auto-generated from name" style="width:100%; height:36px; padding:0 12px; font-size:13px; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box;">
                    </div>
                    <div class="dt-form-group" style="margin-bottom:14px;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Brand Tier</label>
                        <select id="brandTier" class="dt-form-select" style="width:100%; height:36px; padding:0 12px; font-size:13px; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box;">
                            <option value="Primary Flagship">Primary Flagship</option>
                            <option value="Heritage Brocade">Heritage Brocade</option>
                            <option value="Bridal Luxury">Bridal Luxury</option>
                            <option value="Mill Volume B2B">Mill Volume B2B</option>
                        </select>
                    </div>
                    <div class="dt-form-group" style="margin-bottom:0;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Tagline / Description</label>
                        <textarea id="brandDesc" class="dt-form-textarea" rows="3" placeholder="What this label stands for" style="width:100%; padding:8px 12px; font-size:13px; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box; resize:vertical;"></textarea>
                    </div>
                </div>
            </form>
        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function previewAddPageLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('addPageLogoPreview');
            if (preview) {
                preview.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function submitAddBrand(ev) {
    ev.preventDefault();
    const name = document.getElementById('brandName').value.trim();
    if (!name) { return false; }

    const formData = new FormData();
    formData.append('action', 'create');
    formData.append('name', name);
    formData.append('slug', document.getElementById('brandSlug').value.trim());
    formData.append('tier', document.getElementById('brandTier').value);
    formData.append('description', document.getElementById('brandDesc').value.trim());

    const fileInput = document.getElementById('brandLogoFile');
    if (fileInput && fileInput.files && fileInput.files[0]) {
        formData.append('logo', fileInput.files[0]);
    }

    fetch('/api/brands.php', { method: 'POST', body: formData, credentials: 'same-origin' })
        .then(r => r.json())
        .then(() => { window.location.href = '/admin/products/brands/'; })
        .catch(() => { window.location.href = '/admin/products/brands/'; });
    return false;
}
</script>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>