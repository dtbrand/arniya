<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * brands/add.php — Add New House Label
 * DT Brand's & Jai Hanuman Tex
 *
 * The old page rendered an unsaved form whose "Save Brand" button only fired
 * a toast. It now POSTs to /api/brands.php (the same endpoint the modal on
 * brands/index.php uses) and redirects back to the list on success.
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
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
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
function submitAddBrand(ev) {
    ev.preventDefault();
    const name = document.getElementById('brandName').value.trim();
    if (!name) { return false; }

    const params = new URLSearchParams();
    params.append('action', 'create');
    params.append('name', name);
    params.append('slug', document.getElementById('brandSlug').value.trim());
    params.append('tier', document.getElementById('brandTier').value);
    params.append('description', document.getElementById('brandDesc').value.trim());

    fetch('/api/brands.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(r => r.json())
        .then(() => { window.location.href = '/admin/products/brands/'; })
        .catch(() => { window.location.href = '/admin/products/brands/'; });
    return false;
}
</script>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>