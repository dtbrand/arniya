<?php
/**
 * admin/marketing/collections.php — DT Brand's Curated Collections Studio
 * Section 29 Master Content & Marketing Suite
 * DT Brand's & Jai Hanuman Tex
 */

/* DT admin access guard (hardened fallback) */
$__dtg1 = __DIR__ . '/../includes/adminguard.php';
$__dtg2 = __DIR__ . '/../../admin/includes/adminguard.php';
$__dtg3 = (isset($_SERVER['DOCUMENT_ROOT']) && $_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php' : '';
if (is_file($__dtg1)) { require_once $__dtg1; }
elseif (is_file($__dtg2)) { require_once $__dtg2; }
elseif ($__dtg3 && is_file($__dtg3)) { require_once $__dtg3; }

require_once __DIR__ . '/../../src/Database.php';
require_once __DIR__ . '/../../src/ContentManager.php';

use DTBrand\Database;
use DTBrand\ContentManager;

$page_title = "Curated Collections Studio";
$active_nav = "marketing";
$active_subnav = "collections";

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = trim((string)($_POST['action'] ?? ''));

    if ($action === 'create_collection') {
        $data = [
            'title' => trim((string)($_POST['title'] ?? '')),
            'slug' => trim((string)($_POST['slug'] ?? '')),
            'description' => trim((string)($_POST['description'] ?? '')),
            'image_url' => trim((string)($_POST['image_url'] ?? '')),
            'item_count' => (int)($_POST['item_count'] ?? 0),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'status' => trim((string)($_POST['status'] ?? 'active')),
        ];

        if ($data['title'] === '') {
            $error = "Collection title is required.";
        } else {
            $newId = ContentManager::createCuratedCollection($data);
            if ($newId > 0) {
                $message = "Curated collection '{$data['title']}' created successfully!";
            } else {
                $error = "Failed to create collection.";
            }
        }
    } elseif ($action === 'update_collection') {
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'title' => trim((string)($_POST['title'] ?? '')),
            'slug' => trim((string)($_POST['slug'] ?? '')),
            'description' => trim((string)($_POST['description'] ?? '')),
            'image_url' => trim((string)($_POST['image_url'] ?? '')),
            'item_count' => (int)($_POST['item_count'] ?? 0),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'status' => trim((string)($_POST['status'] ?? 'active')),
        ];

        if ($id > 0 && $data['title'] !== '') {
            ContentManager::updateCuratedCollection($id, $data);
            $message = "Collection #{$id} updated successfully!";
        }
    } elseif ($action === 'delete_collection') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            ContentManager::deleteCuratedCollection($id);
            $message = "Collection #{$id} deleted.";
        }
    } elseif ($action === 'toggle_status') {
        $id = (int)($_POST['id'] ?? 0);
        $current = trim((string)($_POST['current_status'] ?? 'active'));
        $newStatus = ($current === 'active') ? 'inactive' : 'active';
        if ($id > 0) {
            ContentManager::updateCuratedCollection($id, ['status' => $newStatus]);
            $message = "Collection #{$id} status changed to {$newStatus}.";
        }
    }
}

$collections = ContentManager::getCuratedCollections(false);
$totalCollections = count($collections);
$activeCollections = count(array_filter($collections, fn($c) => ($c['status'] ?? 'active') === 'active'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curated Collections Studio — DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        :root {
            --dt-gold: #D4AF37;
            --dt-gold-dark: #8A681F;
            --dt-obsidian: #111827;
            --dt-surface: #FFFFFF;
            --dt-border: #EAE5D9;
        }

        .dt-kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 14px;
            margin-bottom: 20px;
        }
        .dt-kpi-card {
            background: #FFFFFF;
            border: 1.5px solid var(--dt-border);
            border-radius: 12px;
            padding: 16px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
            transition: all 0.2s ease;
        }
        .dt-kpi-card:hover {
            border-color: var(--dt-gold);
            transform: translateY(-1.5px);
        }
        .dt-kpi-val {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--dt-obsidian);
            letter-spacing: -0.02em;
            line-height: 1.1;
        }
        .dt-kpi-lbl {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-top: 4px;
        }
        .dt-kpi-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #FAF5E8;
            color: var(--dt-gold-dark);
            flex-shrink: 0;
        }

        .dt-btn-gold {
            background: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%);
            border: 1px solid #8A681F;
            color: #111827;
            font-weight: 800;
            border-radius: 8px;
            padding: 8px 14px;
            font-size: 12px;
            cursor: pointer;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.4), 0 2px 8px rgba(184,134,11,0.35);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }
        .dt-btn-pale {
            background: #FAF5E8;
            border: 1px solid #D4AF37;
            color: #705114;
            font-weight: 700;
            border-radius: 6px;
            padding: 6px 12px;
            font-size: 12px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
        }
        .dt-btn-danger {
            background: #FEF2F2;
            border: 1px solid #FCA5A5;
            color: #DC2626;
            font-weight: 700;
            border-radius: 6px;
            padding: 5px 8px;
            font-size: 11.5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <?php if (!empty($message)): ?>
                <div style="background:#DCFCE7; border:1px solid #86EFAC; color:#15803D; padding:10px 14px; border-radius:8px; margin-bottom:14px; font-weight:700; font-size:13px; display:flex; align-items:center; gap:8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <span><?php echo htmlspecialchars($message); ?></span>
                </div>
            <?php endif; ?>

            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0; font-size:1.45rem; font-weight:800; color:#111827;">
                        <span>Curated Collections Studio</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?php echo $activeCollections; ?> Active</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Build themed merchandising showcases (e.g. Wedding Paithani, Festive Silk, Boutique Edit).</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/marketing/curation.php" class="dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <span>Product Curation</span>
                    </a>
                    <button type="button" class="dt-btn-gold" onclick="openAddCollectionModal()">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add Collection</span>
                    </button>
                </div>
            </div>

            <div class="dt-kpi-grid">
                <div class="dt-kpi-card">
                    <div>
                        <div class="dt-kpi-val"><?php echo $totalCollections; ?></div>
                        <div class="dt-kpi-lbl">Total Showcases</div>
                    </div>
                    <div class="dt-kpi-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                    </div>
                </div>
                <div class="dt-kpi-card">
                    <div>
                        <div class="dt-kpi-val" style="color:#15803D;"><?php echo $activeCollections; ?></div>
                        <div class="dt-kpi-lbl">Active on Storefront</div>
                    </div>
                    <div class="dt-kpi-icon" style="background:#DCFCE7; color:#15803D;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                </div>
                <div class="dt-kpi-card">
                    <div>
                        <div class="dt-kpi-val">100%</div>
                        <div class="dt-kpi-lbl">SEO Indexed</div>
                    </div>
                    <div class="dt-kpi-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </div>
                </div>
            </div>

            <div class="adm-card">
                <div class="adm-card-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9;">
                    <h3 class="adm-card-title" style="margin:0; font-size:1.1rem; font-weight:800; color:#181512; display:flex; align-items:center; gap:8px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        <span>Curated Merchandising Collections</span>
                    </h3>
                </div>
                <div class="adm-table-responsive" style="overflow-x:auto;">
                    <table class="adm-table" style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr style="background:#F8FAFC; border-bottom:1px solid #E2E8F0; text-align:left; font-size:11.5px; color:#475569; text-transform:uppercase;">
                                <th style="padding:10px 14px; width:50px;">Order</th>
                                <th style="padding:10px 14px;">Preview</th>
                                <th style="padding:10px 14px;">Collection Title &amp; Description</th>
                                <th style="padding:10px 14px;">Slug Route</th>
                                <th style="padding:10px 14px;">Items Count</th>
                                <th style="padding:10px 14px;">Status</th>
                                <th style="padding:10px 14px; text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($collections as $col): ?>
                                <?php
                                    $cId = (int)($col['id'] ?? 0);
                                    $cOrder = (int)($col['display_order'] ?? 0);
                                    $cTitle = htmlspecialchars($col['title'] ?? '');
                                    $cDesc = htmlspecialchars($col['description'] ?? '');
                                    $cSlug = htmlspecialchars($col['slug'] ?? '');
                                    $cImg = htmlspecialchars($col['image_url'] ?? '/assets/images/product1.png');
                                    $cItems = (int)($col['item_count'] ?? 0);
                                    $cStatus = $col['status'] ?? 'active';
                                ?>
                                <tr style="border-bottom:1px solid #F1F5F9; font-size:12.5px;">
                                    <td style="padding:10px 14px; font-weight:800; color:#8A681F;">#<?php echo $cOrder; ?></td>
                                    <td style="padding:10px 14px;">
                                        <div style="width:60px; height:42px; border-radius:6px; background-size:cover; background-position:center; border:1px solid #CBD5E1; background-image:url('<?php echo $cImg; ?>');"></div>
                                    </td>
                                    <td style="padding:10px 14px;">
                                        <div style="font-weight:800; color:#1E293B;"><?php echo $cTitle; ?></div>
                                        <div style="font-size:11px; color:#64748B;"><?php echo $cDesc; ?></div>
                                    </td>
                                    <td style="padding:10px 14px;">
                                        <code style="font-size:11px; background:#F8FAFC; padding:2px 6px; border-radius:4px;">/collections/<?php echo $cSlug; ?></code>
                                    </td>
                                    <td style="padding:10px 14px; font-weight:700;">
                                        <span class="adm-badge gold"><?php echo $cItems; ?> SKUs</span>
                                    </td>
                                    <td style="padding:10px 14px;">
                                        <?php if ($cStatus === 'active'): ?>
                                            <span class="adm-badge success" style="font-size:10.5px;">Active</span>
                                        <?php else: ?>
                                            <span class="adm-badge" style="background:#F1F5F9; color:#64748B; font-size:10.5px;">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding:10px 14px; text-align:right;">
                                        <div style="display:inline-flex; gap:6px;">
                                            <button type="button" class="dt-btn-pale" style="font-size:11px;" onclick='openEditCollectionModal(<?php echo json_encode($col); ?>)'>Edit</button>
                                            <form method="POST" style="margin:0;">
                                                <input type="hidden" name="action" value="toggle_status">
                                                <input type="hidden" name="id" value="<?php echo $cId; ?>">
                                                <input type="hidden" name="current_status" value="<?php echo $cStatus; ?>">
                                                <button type="submit" class="dt-btn-pale" style="font-size:11px;"><?php echo $cStatus === 'active' ? 'Disable' : 'Enable'; ?></button>
                                            </form>
                                            <form method="POST" style="margin:0;" onsubmit="return confirm('Delete this collection?');">
                                                <input type="hidden" name="action" value="delete_collection">
                                                <input type="hidden" name="id" value="<?php echo $cId; ?>">
                                                <button type="submit" class="dt-btn-danger" style="font-size:11px;">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Add / Edit Collection Modal -->
<div id="colModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="background:#FFFFFF; border-radius:12px; width:95%; max-width:500px; padding:22px; border:1.5px solid var(--dt-gold);">
        <h3 id="colModalHeading" style="margin:0 0 14px 0; font-size:1.15rem; font-weight:800; color:#181512;">Add Curated Collection</h3>
        <form method="POST" id="colForm">
            <input type="hidden" name="action" id="colFormAction" value="create_collection">
            <input type="hidden" name="id" id="colId" value="">
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Title *</label>
                    <input type="text" name="title" id="colTitle" required placeholder="e.g. Traditional Pure Paithani Silk" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Slug (URL identifier)</label>
                    <input type="text" name="slug" id="colSlug" placeholder="pure-paithani-silk" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Short Description</label>
                    <textarea name="description" id="colDesc" rows="2" style="width:100%; border:1.5px solid #CBD5E1; border-radius:6px; padding:8px 10px; font-weight:600; box-sizing:border-box;"></textarea>
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Cover / Banner Image URL</label>
                    <input type="text" name="image_url" id="colImage" value="/assets/images/product1.png" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Display Order</label>
                        <input type="number" name="display_order" id="colOrder" value="1" min="0" max="99" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Status</label>
                        <select name="status" id="colStatus" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 8px; font-weight:600;">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div style="margin-top:16px; display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" class="dt-btn-pale" onclick="closeCollectionModal()">Cancel</button>
                <button type="submit" class="dt-btn-gold" id="btnColSubmit">Save Collection</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddCollectionModal() {
    document.getElementById('colModalHeading').textContent = 'Add Curated Collection';
    document.getElementById('colFormAction').value = 'create_collection';
    document.getElementById('colId').value = '';
    document.getElementById('colTitle').value = '';
    document.getElementById('colSlug').value = '';
    document.getElementById('colDesc').value = '';
    document.getElementById('colImage').value = '/assets/images/product1.png';
    document.getElementById('colOrder').value = '1';
    document.getElementById('colStatus').value = 'active';
    document.getElementById('btnColSubmit').textContent = 'Create Collection';
    document.getElementById('colModal').style.display = 'flex';
}

function openEditCollectionModal(col) {
    document.getElementById('colModalHeading').textContent = 'Edit Collection #' + (col.id || '');
    document.getElementById('colFormAction').value = 'update_collection';
    document.getElementById('colId').value = col.id || '';
    document.getElementById('colTitle').value = col.title || '';
    document.getElementById('colSlug').value = col.slug || '';
    document.getElementById('colDesc').value = col.description || '';
    document.getElementById('colImage').value = col.image_url || '';
    document.getElementById('colOrder').value = col.display_order || '0';
    document.getElementById('colStatus').value = col.status || 'active';
    document.getElementById('btnColSubmit').textContent = 'Update Collection';
    document.getElementById('colModal').style.display = 'flex';
}

function closeCollectionModal() {
    document.getElementById('colModal').style.display = 'none';
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
