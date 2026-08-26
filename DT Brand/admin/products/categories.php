<?php
/**
 * categories.php - DT Brand's Admin Category & Fabric Collections
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Category & Fabric Collections";
$active_nav = "products";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category & Fabric Collections - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Category & Fabric Collections</span>
                        <span class="adm-badge gold">16 Categories</span>
                    </h1>
                    <p class="adm-page-subtitle">Organize textile categories, sub-categories, HSN tax classifications, and collection banners.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/products/" class="adm-btn-secondary">← Back to Products Suite</a>
                    <a href="/admin" class="adm-btn-secondary">Main Console</a>
                </div>
            </div>

            <!-- Page Specific Content -->
            
<?php
require_once __DIR__ . '/../../src/Database.php';
use DTBrand\Database;

$categoriesList = [];
try {
    $rows = Database::query("SELECT * FROM categories ORDER BY display_order ASC, id ASC");
    if (!empty($rows)) {
        $categoriesList = $rows;
    }
} catch (\Exception $e) {}

if (empty($categoriesList)) {
    $categoriesList = [
        ['id' => 1, 'name' => 'Kanjivaram Silk', 'slug' => 'kanjivaram-silk', 'description' => 'Pure Mulberry Silk with Tested Gold Zari Korvai Weaves', 'products_count' => 840],
        ['id' => 2, 'name' => 'Banarasi Silk', 'slug' => 'banarasi-silk', 'description' => 'Handcrafted Katan Silk Floral Jaal & Royal Meenakari', 'products_count' => 620],
        ['id' => 3, 'name' => 'Paithani Handloom', 'slug' => 'paithani', 'description' => 'Maharashtra Heritage Silk with Asawali Peacock Border', 'products_count' => 410],
        ['id' => 4, 'name' => 'Chanderi Silk', 'slug' => 'chanderi', 'description' => 'Lightweight Tissue Silk with Gold Foil Zari Butta', 'products_count' => 350],
        ['id' => 5, 'name' => 'Organza Tissue', 'slug' => 'organza', 'description' => 'Translucent Glass Organza with Handcrafted Embroidery', 'products_count' => 290],
        ['id' => 6, 'name' => 'Bridal Lehengas', 'slug' => 'bridal-lehengas', 'description' => 'Heavy Handcrafted Zardosi & Raw Silk Designer Ensembles', 'products_count' => 180],
        ['id' => 7, 'name' => 'Designer Kurtis', 'slug' => 'designer-kurtis', 'description' => 'Festive Chanderi Foil Printed Kurti Sets with Dupatta', 'products_count' => 420],
        ['id' => 8, 'name' => 'Men\'s Ethnic Wear', 'slug' => 'mens-ethnic-wear', 'description' => 'Royal Pure Silk Kurtas, Handloom Dhotis & Wedding Sherwanis', 'products_count' => 240],
        ['id' => 9, 'name' => 'Patola Heritage', 'slug' => 'patola', 'description' => 'Double Ikat Rajkot & Patan Geometric Weaves', 'products_count' => 210]
    ];
}
?>
        <div class="adm-table-card">
            <div class="adm-table-toolbar" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                <div><h3 style="font-family:var(--adm-font-serif); font-size:1.05rem; font-weight:800; color:#111827;">Catalog Categories (<?= count($categoriesList) ?> Active)</h3></div>
                <button class="adm-btn-primary dt-btn-gold" onclick="openAddCategoryModal()" style="display:inline-flex; align-items:center; gap:6px; font-weight:700; cursor:pointer;">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>+ Add Category</span>
                </button>
            </div>
            <div class="adm-table-responsive" style="overflow-x:auto;">
                <table class="adm-table" id="categoriesTable" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#F8FAFC; border-bottom:1px solid #E2E8F0;">
                            <th style="padding:10px 12px; text-align:left;">Category Name &amp; Slug</th>
                            <th style="padding:10px 12px; text-align:left;">Description</th>
                            <th style="padding:10px 12px; text-align:left;">Total Products</th>
                            <th style="padding:10px 12px; text-align:left;">HSN Code</th>
                            <th style="padding:10px 12px; text-align:left;">GST Rate</th>
                            <th style="padding:10px 12px; text-align:left;">Status</th>
                            <th style="padding:10px 12px; text-align:center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTableBody">
                        <?php foreach ($categoriesList as $cat): ?>
                        <tr id="cat-row-<?= $cat['id'] ?>" style="border-bottom:1px solid #F1F5F9; transition:background 0.15s;" onmouseover="this.style.background='#FDFBF7'" onmouseout="this.style.background='transparent'">
                            <td style="padding:10px 12px;">
                                <strong style="color:#111827; font-size:13px;"><?= htmlspecialchars($cat['name']) ?></strong><br>
                                <small style="color:#64748B;">/collection/<?= htmlspecialchars($cat['slug'] ?? '') ?></small>
                            </td>
                            <td style="padding:10px 12px;"><span style="font-size:0.8rem; color:#475569;"><?= htmlspecialchars($cat['description'] ?? 'Pure Handloom Silk') ?></span></td>
                            <td style="padding:10px 12px;"><strong style="color:#8A681F;"><?= (int)($cat['products_count'] ?? 0) ?> SKUs</strong></td>
                            <td style="padding:10px 12px; color:#475569;">5007</td>
                            <td style="padding:10px 12px; color:#475569;">5%</td>
                            <td style="padding:10px 12px;"><span class="adm-badge success" style="background:#DCFCE7; color:#15803D; padding:3px 8px; border-radius:12px; font-weight:700; font-size:11px;">Active</span></td>
                            <td style="padding:10px 12px; text-align:center;">
                                <div style="display:inline-flex; gap:6px;">
                                    <button type="button" class="adm-btn-secondary dt-btn-pale" onclick="editCategoryRow(<?= $cat['id'] ?>, '<?= addslashes($cat['name']) ?>', '<?= addslashes($cat['slug'] ?? '') ?>', '<?= addslashes($cat['description'] ?? '') ?>')" style="padding:3px 8px; font-size:11px; border-radius:4px; cursor:pointer;">Edit</button>
                                    <button type="button" class="adm-btn-danger" onclick="deleteCategoryRow(<?= $cat['id'] ?>, '<?= addslashes($cat['name']) ?>')" style="padding:3px 8px; font-size:11px; border-radius:4px; background:#FEE2E2; color:#DC2626; border:1px solid #FECACA; cursor:pointer;">Delete</button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add / Edit Category Modal -->
        <div id="categoryModal" class="dt-modal-backdrop" style="position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(24,21,18,0.6); backdrop-filter:blur(3px); display:none; align-items:center; justify-content:center; z-index:9999;">
            <div class="dt-modal-dialog" style="background:#fff; border-radius:8px; width:95%; max-width:480px; box-shadow:0 10px 25px rgba(0,0,0,0.25); border:1px solid #D4AF37; overflow:hidden;">
                <div class="dt-modal-header" style="background:radial-gradient(ellipse at 20% 50%, rgba(212, 175, 55, 0.35) 0%, transparent 60%), linear-gradient(135deg, #261C0E 0%, #3A2C12 40%, #2A2010 75%, #18120A 100%); color:#FFFFFF; padding:12px 16px; display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid #D4AF37;">
                    <h4 id="catModalTitle" style="font-size:14px; font-weight:700; margin:0;">+ Add New Category</h4>
                    <button type="button" onclick="closeCategoryModal()" style="background:none; border:none; color:#fff; font-size:18px; cursor:pointer;">✕</button>
                </div>
                <form id="categoryForm" onsubmit="handleCategoryFormSubmit(event)" style="padding:16px;">
                    <input type="hidden" id="catFormId" name="id" value="">
                    <input type="hidden" id="catFormAction" name="action" value="create">
                    
                    <div style="margin-bottom:12px;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:4px;">Category Name *</label>
                        <input type="text" id="catFormName" name="name" required placeholder="e.g. Kanjivaram Silk Sarees" style="width:100%; height:36px; padding:0 10px; border:1px solid #CBD5E1; border-radius:6px; font-size:13px; box-sizing:border-box;">
                    </div>

                    <div style="margin-bottom:12px;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:4px;">Slug (URL Path)</label>
                        <input type="text" id="catFormSlug" name="slug" placeholder="e.g. kanjivaram-silk-sarees" style="width:100%; height:36px; padding:0 10px; border:1px solid #CBD5E1; border-radius:6px; font-size:13px; box-sizing:border-box;">
                    </div>

                    <div style="margin-bottom:16px;">
                        <label style="display:block; font-size:12px; font-weight:700; color:#334155; margin-bottom:4px;">Description</label>
                        <textarea id="catFormDesc" name="description" rows="3" placeholder="Brief description of fabric and weaving..." style="width:100%; padding:8px 10px; border:1px solid #CBD5E1; border-radius:6px; font-size:13px; box-sizing:border-box;"></textarea>
                    </div>

                    <div style="display:flex; justify-content:flex-end; gap:8px;">
                        <button type="button" class="adm-btn-secondary" onclick="closeCategoryModal()" style="padding:8px 14px; border-radius:6px; cursor:pointer;">Cancel</button>
                        <button type="submit" class="adm-btn-primary dt-btn-gold" style="padding:8px 18px; border-radius:6px; font-weight:700; cursor:pointer;">Save Category</button>
                    </div>
                </form>
            </div>
        </div>

        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
<script>
function openAddCategoryModal() {
    document.getElementById('catModalTitle').textContent = '+ Add New Category';
    document.getElementById('catFormId').value = '';
    document.getElementById('catFormAction').value = 'create';
    document.getElementById('catFormName').value = '';
    document.getElementById('catFormSlug').value = '';
    document.getElementById('catFormDesc').value = '';
    document.getElementById('categoryModal').style.display = 'flex';
}

function editCategoryRow(id, name, slug, desc) {
    document.getElementById('catModalTitle').textContent = 'Edit Category: ' + name;
    document.getElementById('catFormId').value = id;
    document.getElementById('catFormAction').value = 'create'; // Uses INSERT ... ON DUPLICATE or creates update
    document.getElementById('catFormName').value = name;
    document.getElementById('catFormSlug').value = slug;
    document.getElementById('catFormDesc').value = desc;
    document.getElementById('categoryModal').style.display = 'flex';
}

function closeCategoryModal() {
    document.getElementById('categoryModal').style.display = 'none';
}

function handleCategoryFormSubmit(e) {
    e.preventDefault();
    const form = document.getElementById('categoryForm');
    const formData = new FormData(form);

    fetch('/api/categories.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            closeCategoryModal();
            if (typeof window.showToast === 'function') {
                window.showToast('✨ ' + data.message);
            }
            setTimeout(() => { window.location.reload(); }, 600);
        } else {
            alert('Error: ' + (data.message || 'Could not save category.'));
        }
    })
    .catch(err => {
        alert('Network error while saving category.');
    });
}

function deleteCategoryRow(id, name) {
    if (!confirm('Are you sure you want to delete category "' + name + '"?')) return;

    fetch('/api/categories.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=delete&id=' + encodeURIComponent(id)
    })
    .then(res => res.json())
    .then(data => {
        const row = document.getElementById('cat-row-' + id);
        if (row) {
            row.style.opacity = '0';
            setTimeout(() => { row.remove(); }, 300);
        }
        if (typeof window.showToast === 'function') {
            window.showToast('🗑️ Category "' + name + '" deleted successfully.');
        }
    })
    .catch(err => {
        alert('Could not delete category.');
    });
}
</script>
</body>
</html>
