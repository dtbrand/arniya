<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * subcategories/index.php — DT Brand's Master Subcategories Hierarchy
 * Wholesale Dashboard & Luxury Shop Standard
 * DT Brand's & Jai Hanuman Tex
 *
 * Previously shipped five invented subcategory rows, a "34 Subcategories"
 * badge and buttons whose Edit / Add / Bulk handlers only raised toasts.
 * The list is now a real join over subcategories ⨝ categories with live
 * per-parent SKU counts and valuation, and every action navigates to the
 * working add/edit pages or calls /api/categories.php.
 */
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\Database;

$page_title = "Subcategories Hierarchy";
$active_nav = "products";
$active_subnav = "subcategories";

$subcategories_list = [];
$activeSubcatCount = 0;

$pdoSub = Database::getConnection();
if ($pdoSub !== null && !Database::isMockMode()) {
    try {
        $subcategories_list = Database::query(
            'SELECT s.id, s.name, s.slug, s.status, s.category_id,
                    c.name AS parent_name,
                    (SELECT COUNT(*) FROM products p WHERE p.category_id = s.category_id) AS sku_count,
                    (SELECT COALESCE(SUM(p2.stock_qty * p2.wholesale_price), 0) FROM products p2 WHERE p2.category_id = s.category_id) AS valuation
             FROM subcategories s
             LEFT JOIN categories c ON s.category_id = c.id
             ORDER BY c.display_order ASC, s.name ASC'
        );
        $cnt = Database::fetchOne("SELECT COUNT(*) AS c FROM subcategories WHERE status = 'active'");
        $activeSubcatCount = (int)($cnt['c'] ?? 0);
    } catch (\Throwable $e) {
        $subcategories_list = [];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subcategories Hierarchy ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
    .dt-kpi-card {
        background: #fff;
        border: 1px solid rgba(212,175,55,0.4);
        border-radius: 8px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        transition: all 0.2s ease;
    }
    .dt-kpi-card:hover { border-color: #D4AF37; }
    .dt-action-pill {
        height: 28px;
        padding: 0 8px;
        font-size: 11.5px;
        font-weight: 700;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .dt-action-pill:hover { transform: translateY(-1px); }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 16px 20px;">

            <!-- 1. Header Toolbar -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Subcategories Hierarchy</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:3px 8px;"><?php echo count($subcategories_list); ?> Live Subcategories</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/products/categories/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>
                        <span>Parent Categories</span>
                    </a>
                    <a href="/admin/products/subcategories/add.php" class="wp-button primary" style="background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F; padding:0 14px; height:32px; display:inline-flex; align-items:center; gap:6px; text-decoration:none; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add Subcategory</span>
                    </a>
                </div>
            </div>

            <!-- 3. Toolbar: search + parent filter -->
            <div class="wp-tablenav" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:12px;">
                <div class="wp-tablenav-actions" style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                    <select class="wp-select" id="parentFilter" onchange="filterSubcatByParent(this.value)" style="height:34px; font-size:12px; min-width:160px;">
                        <option value="">All Parent Categories</option>
                        <?php
                        $seenParents = [];
                        foreach ($subcategories_list as $s) {
                            $pn = (string)($s['parent_name'] ?? '');
                            if ($pn !== '' && !isset($seenParents[$pn])) {
                                $seenParents[$pn] = true;
                                echo '<option value="' . htmlspecialchars($pn) . '">' . htmlspecialchars($pn) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="wp-search-box" style="display:flex; align-items:center; gap:6px;">
                    <input type="text" id="subcatSearchInput" class="wp-search-input" placeholder="Search subcategory, parent..." style="height:34px; padding-left:12px; width:230px; font-size:12px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchSubcats(this.value)">
                </div>
            </div>

            <!-- 4. Subcategories Table -->
            <div class="wp-table-card" style="background:#fff; border:1px solid #c3c4c7; border-radius:6px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                <table class="wp-list-table" id="subcategoriesTable" style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f6f7f7; border-bottom:1px solid #c3c4c7;">
                            <th style="padding:10px 12px;">Subcategory &amp; Slug</th>
                            <th style="padding:10px 10px;">Parent Category</th>
                            <th style="padding:10px 10px;">Active SKUs</th>
                            <th style="padding:10px 10px;">B2B Valuation</th>
                            <th style="padding:10px 10px;">Status</th>
                            <th style="width:150px; text-align:right; padding:10px 12px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="subcategoriesTableBody">
                    <?php if (empty($subcategories_list)): ?>
                        <tr><td colspan="6" style="padding:24px; text-align:center; color:#64748B;">No subcategories yet. Click <strong>Add Subcategory</strong> to create the first sub-line.</td></tr>
                    <?php else: ?>
                        <?php foreach ($subcategories_list as $sub): ?>
                        <?php
                            $val = (float)($sub['valuation'] ?? 0);
                            $valTxt = $val >= 100000 ? ('₹' . number_format($val / 100000, 2) . ' Lakhs') : ('₹' . number_format($val, 2));
                            $status = (string)($sub['status'] ?? 'active');
                        ?>
                        <tr data-parent="<?= htmlspecialchars((string)($sub['parent_name'] ?? '')) ?>" style="border-bottom:1px solid #f0f0f1;">
                            <td style="padding:12px 12px;">
                                <strong style="font-size:13.5px; color:#181512; display:block; margin-bottom:2px;"><?= htmlspecialchars((string)$sub['name']) ?></strong>
                                <code style="font-size:11px; color:#646970; background:#f0f0f1; padding:1px 5px; border-radius:3px;"><?= htmlspecialchars((string)$sub['slug']) ?></code>
                            </td>
                            <td style="padding:12px 10px;">
                                <a href="/admin/catalogue/categories/view.php?id=<?= (int)($sub['category_id'] ?? 0) ?>" style="text-decoration:none;">
                                    <span class="adm-badge" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; font-size:11px; font-weight:700;"><?= htmlspecialchars((string)($sub['parent_name'] ?? '—')) ?></span>
                                </a>
                            </td>
                            <td style="padding:12px 10px;">
                                <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:800; font-size:11.5px; padding:3px 8px; border-radius:10px;"><?= (int)($sub['sku_count'] ?? 0) ?> SKUs</span>
                            </td>
                            <td style="padding:12px 10px;"><strong style="color:#181512; font-size:13px;"><?= $valTxt ?></strong></td>
                            <td style="padding:12px 10px;">
                                <span class="adm-badge" style="background:<?= $status === 'active' ? '#DCFCE7; color:#15803D' : '#F1F5F9; color:#64748B' ?>; font-weight:700; font-size:11px; padding:3px 8px; border-radius:12px;"><?= htmlspecialchars(ucfirst($status)) ?></span>
                            </td>
                            <td style="padding:12px 12px; text-align:right;">
                                <div style="display:flex; gap:5px; justify-content:flex-end;">
                                    <a href="/admin/products/subcategories/edit.php?id=<?= (int)$sub['id'] ?>" class="dt-action-pill" style="background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F; text-decoration:none;">
                                        <span>Edit</span>
                                    </a>
                                    <button type="button" class="dt-action-pill" style="background:#FEF2F2; border:1px solid #FECACA; color:#DC2626;" onclick="deleteSubcat(<?= (int)$sub['id'] ?>, '<?= htmlspecialchars(addslashes((string)$sub['name'])) ?>')">
                                        <span>Delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function searchSubcats(q) {
    const term = (q || '').toLowerCase().trim();
    document.querySelectorAll('#subcategoriesTableBody tr').forEach(r => {
        r.style.display = r.textContent.toLowerCase().includes(term) ? '' : 'none';
    });
}

function filterSubcatByParent(parent) {
    document.querySelectorAll('#subcategoriesTableBody tr').forEach(r => {
        if (!parent) { r.style.display = ''; return; }
        r.style.display = (r.dataset.parent || '').toLowerCase() === parent.toLowerCase() ? '' : 'none';
    });
}

function deleteSubcat(id, name) {
    if (!confirm('Delete subcategory "' + name + '"? This cannot be undone.')) return;
    const params = new URLSearchParams();
    params.append('action', 'delete_subcategory');
    params.append('id', id);
    fetch('/api/categories.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => {
            if (data && data.success === false) {
                if (typeof window.showToast === 'function') window.showToast('⚠️ ' + (data.message || 'Could not delete'));
                return;
            }
            window.location.reload();
        })
        .catch(() => window.location.reload());
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>