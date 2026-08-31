<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * subcategories/add.php — Create a Subcategory
 * DT Brand's & Jai Hanuman Tex
 *
 * The old page collected a name and showed a hard-coded parent list; its
 * Save button only raised a toast. It now loads the real categories for the
 * parent dropdown and POSTs to /api/categories.php (admin-guarded).
 */
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\Database;

$page_title = "Add Subcategory";
$active_nav = "products";
$active_subnav = "subcategories";

$parents = [];
$pdoAdd = Database::getConnection();
if ($pdoAdd !== null && !Database::isMockMode()) {
    try {
        $parents = Database::query("SELECT id, name FROM categories WHERE status = 'active' ORDER BY display_order ASC, name ASC");
    } catch (\Throwable $e) {
        $parents = [];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subcategory ‹ DT Brand's Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
    .dt-form-input:focus, .dt-form-select:focus {
        border-color: #D4AF37 !important;
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.18) !important;
        outline: none;
    }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../includes/adminheader.php'; ?>
        <main class="adm-content" style="padding:16px 20px; max-width:760px;">
            <form id="addSubcatForm" onsubmit="return submitAddSubcat(event);">
                <div class="dt-prod-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                    <div class="dt-prod-title-group">
                        <h1 style="font-size:22px; font-weight:800; color:#181512; margin:0;">Add Subcategory</h1>
                    </div>
                    <div class="dt-prod-actions" style="display:flex; gap:8px;">
                        <a href="/admin/products/subcategories/" class="adm-btn-secondary">Cancel</a>
                        <button type="submit" class="adm-btn-primary">Save Subcategory</button>
                    </div>
                </div>
                <div class="adm-card" style="background:#fff; border:1px solid #E2E8F0; border-radius:8px; padding:18px;">
                    <div class="dt-form-group" style="margin-bottom:14px;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Subcategory Name <span style="color:#b32d2e;">*</span></label>
                        <input type="text" id="subcatName" class="dt-form-input" placeholder="e.g. Chanderi Pure Silk" required style="width:100%; height:36px; padding:0 12px; font-size:13px; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box;">
                    </div>
                    <div class="dt-form-group" style="margin-bottom:0;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:5px;">Parent Category <span style="color:#b32d2e;">*</span></label>
                        <select id="subcatParent" class="dt-form-select" required style="width:100%; height:36px; padding:0 12px; font-size:13px; border:1px solid #c3c4c7; border-radius:6px; box-sizing:border-box;">
                            <?php if (empty($parents)): ?>
                                <option value="">No categories yet — create one first</option>
                            <?php else: ?>
                                <?php foreach ($parents as $p): ?>
                                    <option value="<?= (int)$p['id'] ?>"><?= htmlspecialchars((string)$p['name']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
            </form>
        </main>
        <?php include_once __DIR__ . '/../../includes/adminfooter.php'; ?>
    </div>
</div>
<script>
function submitAddSubcat(ev) {
    ev.preventDefault();
    const name = document.getElementById('subcatName').value.trim();
    const parentId = document.getElementById('subcatParent').value;
    if (!name || !parentId) { return false; }

    const params = new URLSearchParams();
    params.append('action', 'create_subcategory');
    params.append('name', name);
    params.append('category_id', parentId);
    fetch('/api/categories.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => {
            if (data && data.success === false) {
                if (typeof window.showToast === 'function') window.showToast('⚠️ ' + (data.message || 'Could not save'));
                return;
            }
            window.location.href = '/admin/products/subcategories/';
        })
        .catch(() => { window.location.href = '/admin/products/subcategories/'; });
    return false;
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>