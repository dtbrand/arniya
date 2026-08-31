<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * subcategories/index.php — Subcategory Management List
 * DT Brand's & Jai Hanuman Tex
 *
 * The previous revision rendered three hard-coded rows (Kanjivaram Silk,
 * Banarasi Brocade, Zardosi Velvet Lehengas) and a "42 Active" counter that
 * existed nowhere in the database. The list is now a real SELECT over
 * subcategories ⨝ categories with a live product count per parent line.
 */
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\Database;

$page_title = "Subcategories";
$active_nav = "catalogue";
$active_subnav = "subcategories";

$subcats = [];
$pdoScIdx = Database::getConnection();
if ($pdoScIdx !== null && !Database::isMockMode()) {
    try {
        $subcats = Database::query(
            'SELECT s.id, s.name, s.slug, s.category_id, s.status,
                    c.name AS parent_name,
                    (SELECT COUNT(*) FROM products p WHERE p.category_id = s.category_id) AS sku_count
             FROM subcategories s
             LEFT JOIN categories c ON s.category_id = c.id
             ORDER BY c.display_order ASC, s.id ASC'
        );
    } catch (\Throwable $e) {
        $subcats = [];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subcategories ‹ DT Brand's Catalogue</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/catalogue/assets/css/catalogue.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 14px 18px; width: 100%; max-width: 100%; box-sizing: border-box;">

            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div>
                    <h1 class="wp-heading-inline" style="font-size:20px; font-weight:800; color:#181512; margin:0;">Subcategories (<?php echo count($subcats); ?> Live)</h1>
                    <p style="font-size:12px; color:#64748b; margin:2px 0 0 0;">Manage specific weaves, fabric types, and nested sub-classifications.</p>
                </div>
                <div style="display:flex; gap:6px;">
                    <a href="/admin/catalogue/subcategories/add.php" class="dt-btn-action-sm gold" style="height:30px; padding:0 12px; font-size:11.5px;">+ Add Subcategory</a>
                    <a href="/admin/catalogue/subcategories/reorder.php" class="dt-btn-action-sm pale-gold" style="height:30px; padding:0 10px; font-size:11.5px;">Reorder</a>
                </div>
            </div>

            <!-- Subcategories Table -->
            <div class="dt-cat-card">
                <div class="dt-cat-table-wrap">
                    <table class="dt-cat-table" id="subcatTable">
                        <thead>
                            <tr>
                                <th style="width:30px; text-align:center;"><input type="checkbox" onchange="window.DT_CATALOGUE.toggleSelectAll(this, 'subcat-chk')" style="cursor:pointer;"></th>
                                <th style="width:40px;">Image</th>
                                <th>Subcategory Name</th>
                                <th>Parent Category</th>
                                <th>Products</th>
                                <th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (empty($subcats)): ?>
                            <tr>
                                <td colspan="7" style="padding:24px; text-align:center; color:#64748B;">
                                    No subcategories yet. Click <strong>Add Subcategory</strong> to create the first sub-line.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($subcats as $s): ?>
                                <tr id="subcat-<?php echo (int)$s['id']; ?>">
                                    <td style="text-align:center;"><input type="checkbox" class="subcat-chk" value="<?php echo (int)$s['id']; ?>"></td>
                                    <td><img src="/assets/images/no-image.svg" onerror="this.onerror=null;" style="width:32px; height:32px; border-radius:4px; object-fit:cover;"></td>
                                    <td><strong><?php echo htmlspecialchars((string)$s['name']); ?></strong></td>
                                    <td><a href="/admin/catalogue/categories/view.php?id=<?php echo (int)$s['category_id']; ?>" style="color:#8A681F; font-weight:700; text-decoration:none;"><?php echo htmlspecialchars((string)($s['parent_name'] ?? '—')); ?></a></td>
                                    <td><strong><?php echo (int)($s['sku_count'] ?? 0); ?> SKUs</strong></td>
                                    <td><span class="dt-badge <?php echo (($s['status'] ?? 'active') === 'active') ? 'green' : 'gray'; ?>"><?php echo htmlspecialchars((string)($s['status'] ?? 'active')); ?></span></td>
                                    <td style="text-align:right;">
                                        <div style="display:inline-flex; gap:4px;">
                                            <a href="/admin/catalogue/subcategories/view.php?id=<?php echo (int)$s['id']; ?>" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                                            <a href="/admin/catalogue/subcategories/edit.php?id=<?php echo (int)$s['id']; ?>" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                                            <button type="button" class="dt-btn-action-sm danger" onclick="if(confirm('Delete subcategory &quot;<?php echo htmlspecialchars(addslashes((string)$s['name'])); ?>&quot;?')) { fetch('/api/categories.php', { method: 'DELETE', credentials:'same-origin', headers:{'Content-Type':'application/json'}, body: JSON.stringify({action:'delete_subcategory', id: <?php echo (int)$s['id']; ?>}) }).then(() => window.location.reload()); }" style="height:24px; padding:0 6px;">✕</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script src="/admin/catalogue/assets/js/catalogue.js?v=<?php echo time(); ?>"></script>
</body>
</html>