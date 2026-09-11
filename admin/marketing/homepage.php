<?php
/**
 * admin/marketing/homepage.php — DT Brand's Homepage Layout & Section Architecture Manager
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

$page_title = "Homepage Layout & Sections Manager";
$active_nav = "marketing";
$active_subnav = "homepage";

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = trim((string)($_POST['action'] ?? ''));

    if ($action === 'create_section') {
        $data = [
            'section_key' => trim((string)($_POST['section_key'] ?? '')),
            'title' => trim((string)($_POST['title'] ?? '')),
            'subtitle' => trim((string)($_POST['subtitle'] ?? '')),
            'section_type' => trim((string)($_POST['section_type'] ?? 'product_carousel')),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_active' => (int)($_POST['is_active'] ?? 1),
        ];

        if ($data['section_key'] === '' || $data['title'] === '') {
            $error = "Section key and title are required.";
        } else {
            $newId = ContentManager::createHomepageSection($data);
            if ($newId > 0) {
                $message = "Homepage section '{$data['title']}' created successfully!";
            } else {
                $error = "Failed to create homepage section.";
            }
        }
    } elseif ($action === 'update_section') {
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'title' => trim((string)($_POST['title'] ?? '')),
            'subtitle' => trim((string)($_POST['subtitle'] ?? '')),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'is_active' => (int)($_POST['is_active'] ?? 1),
        ];

        if ($id > 0) {
            ContentManager::updateHomepageSection($id, $data);
            $message = "Section #{$id} updated successfully.";
        }
    } elseif ($action === 'toggle_active') {
        $id = (int)($_POST['id'] ?? 0);
        $current = (int)($_POST['current_active'] ?? 1);
        $newActive = ($current === 1) ? 0 : 1;
        if ($id > 0) {
            ContentManager::updateHomepageSection($id, ['is_active' => $newActive]);
            $message = "Section status toggled.";
        }
    } elseif ($action === 'save_orders') {
        $orders = $_POST['order'] ?? [];
        if (is_array($orders)) {
            $orderMap = [];
            foreach ($orders as $secId => $ordVal) {
                $orderMap[(int)$secId] = (int)$ordVal;
            }
            ContentManager::reorderHomepageSections($orderMap);
            $message = "Homepage section layout order saved!";
        }
    }
}

$sections = ContentManager::getHomepageSections(false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Layout &amp; Sections — DT Brand's Admin</title>
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

        .dt-section-card {
            background: #FFFFFF;
            border: 1.5px solid var(--dt-border);
            border-radius: 12px;
            padding: 16px 18px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
            transition: all 0.2s ease;
        }
        .dt-section-card:hover {
            border-color: var(--dt-gold);
            transform: translateX(2px);
            box-shadow: 0 4px 14px rgba(184,134,11,0.08);
        }
        .dt-section-card.inactive {
            opacity: 0.6;
            background: #F8FAFC;
        }
        .dt-order-handle {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            background: #FAF5E8;
            color: var(--dt-gold-dark);
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
            border: 1px solid rgba(212,175,55,0.4);
        }
        .dt-section-body {
            flex: 1;
        }
        .dt-section-title {
            font-size: 14px;
            font-weight: 800;
            color: #111827;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dt-section-sub {
            font-size: 11.5px;
            color: #64748B;
            margin: 2px 0 0 0;
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
                        <span>Homepage Layout Architecture</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?php echo count($sections); ?> Sections</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Arrange, toggle, and reorder dynamic components displayed on the public storefront homepage.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/marketing/collections.php" class="dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        <span>Curated Collections</span>
                    </a>
                    <a href="/admin/marketing/curation.php" class="dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <span>Product Curation</span>
                    </a>
                    <button type="button" class="dt-btn-gold" onclick="openAddSectionModal()">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add Section</span>
                    </button>
                </div>
            </div>

            <form method="POST">
                <input type="hidden" name="action" value="save_orders">

                <div style="margin-bottom: 16px; display:flex; justify-content:space-between; align-items:center;">
                    <div style="font-size:12px; color:#64748B;">Change the order numbers below and click <strong>Save Layout Order</strong> to update the live storefront hierarchy.</div>
                    <button type="submit" class="dt-btn-gold">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                        <span>Save Layout Order</span>
                    </button>
                </div>

                <?php foreach ($sections as $sec): ?>
                    <?php
                        $sId = (int)($sec['id'] ?? 0);
                        $sOrder = (int)($sec['display_order'] ?? 0);
                        $sKey = htmlspecialchars($sec['section_key'] ?? '');
                        $sTitle = htmlspecialchars($sec['title'] ?? '');
                        $sSub = htmlspecialchars($sec['subtitle'] ?? '');
                        $sType = htmlspecialchars($sec['section_type'] ?? 'product_carousel');
                        $sActive = (int)($sec['is_active'] ?? 1);
                    ?>
                    <div class="dt-section-card <?php echo $sActive === 1 ? '' : 'inactive'; ?>">
                        <div class="dt-order-handle">
                            #<?php echo $sOrder; ?>
                        </div>
                        <div style="width:70px;">
                            <input type="number" name="order[<?php echo $sId; ?>]" value="<?php echo $sOrder; ?>" min="0" max="99" style="width:100%; height:32px; text-align:center; border:1px solid #CBD5E1; border-radius:6px; font-weight:800; font-size:13px;">
                        </div>
                        <div class="dt-section-body">
                            <h4 class="dt-section-title">
                                <span><?php echo $sTitle; ?></span>
                                <span class="adm-badge gold" style="font-size:10px;"><?php echo $sKey; ?></span>
                                <span class="adm-badge" style="background:#EFF6FF; color:#1D4ED8; font-size:10px;"><?php echo $sType; ?></span>
                            </h4>
                            <p class="dt-section-sub"><?php echo $sSub ?: 'No subtitle specified'; ?></p>
                        </div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <button type="button" class="dt-btn-pale" style="font-size:11.5px;" onclick='openEditSectionModal(<?php echo json_encode($sec); ?>)'>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                <span>Edit</span>
                            </button>
                            <button type="submit" form="formToggle-<?php echo $sId; ?>" class="dt-btn-pale" style="font-size:11.5px;">
                                <?php echo $sActive === 1 ? 'Disable' : 'Enable'; ?>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </form>

            <?php foreach ($sections as $sec): ?>
                <?php $sId = (int)($sec['id'] ?? 0); $sActive = (int)($sec['is_active'] ?? 1); ?>
                <form id="formToggle-<?php echo $sId; ?>" method="POST" style="display:none;">
                    <input type="hidden" name="action" value="toggle_active">
                    <input type="hidden" name="id" value="<?php echo $sId; ?>">
                    <input type="hidden" name="current_active" value="<?php echo $sActive; ?>">
                </form>
            <?php endforeach; ?>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Add / Edit Section Modal -->
<div id="sectionModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="background:#FFFFFF; border-radius:12px; width:95%; max-width:480px; padding:22px; border:1.5px solid var(--dt-gold);">
        <h3 id="secModalHeading" style="margin:0 0 14px 0; font-size:1.15rem; font-weight:800; color:#181512; display:flex; align-items:center; gap:8px;">
            <span>Add Homepage Section</span>
        </h3>
        <form method="POST" id="secForm">
            <input type="hidden" name="action" id="secFormAction" value="create_section">
            <input type="hidden" name="id" id="secId" value="">
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div id="divSecKey">
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Section Key * (Unique Identifier)</label>
                    <input type="text" name="section_key" id="secKey" required placeholder="e.g. wedding_silks_reel" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Display Title *</label>
                    <input type="text" name="title" id="secTitle" required placeholder="e.g. Royal Wedding Silks" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Subtitle</label>
                    <input type="text" name="subtitle" id="secSubtitle" placeholder="e.g. Pure Zari & Traditional Weaves" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div id="divSecType">
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Section Type</label>
                    <select name="section_type" id="secType" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 8px; font-weight:600;">
                        <option value="product_carousel">Product Carousel Reel</option>
                        <option value="collection_grid">Curated Collection Grid</option>
                        <option value="banner">Promotional Banner</option>
                        <option value="hero_slider">Hero Slider</option>
                        <option value="custom_html">Custom Block</option>
                    </select>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Display Order</label>
                        <input type="number" name="display_order" id="secOrder" value="1" min="0" max="99" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Status</label>
                        <select name="is_active" id="secActive" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 8px; font-weight:600;">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div style="margin-top:16px; display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" class="dt-btn-pale" onclick="closeSectionModal()">Cancel</button>
                <button type="submit" class="dt-btn-gold" id="btnSecSubmit">Save Section</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddSectionModal() {
    document.getElementById('secModalHeading').innerHTML = '<span>Add Homepage Section</span>';
    document.getElementById('secFormAction').value = 'create_section';
    document.getElementById('secId').value = '';
    document.getElementById('divSecKey').style.display = 'block';
    document.getElementById('divSecType').style.display = 'block';
    document.getElementById('secKey').value = '';
    document.getElementById('secTitle').value = '';
    document.getElementById('secSubtitle').value = '';
    document.getElementById('secOrder').value = '10';
    document.getElementById('secActive').value = '1';
    document.getElementById('btnSecSubmit').textContent = 'Create Section';
    document.getElementById('sectionModal').style.display = 'flex';
}

function openEditSectionModal(sec) {
    document.getElementById('secModalHeading').innerHTML = '<span>Edit Section: ' + (sec.title || '') + '</span>';
    document.getElementById('secFormAction').value = 'update_section';
    document.getElementById('secId').value = sec.id || '';
    document.getElementById('divSecKey').style.display = 'none';
    document.getElementById('divSecType').style.display = 'none';
    document.getElementById('secTitle').value = sec.title || '';
    document.getElementById('secSubtitle').value = sec.subtitle || '';
    document.getElementById('secOrder').value = sec.display_order || '0';
    document.getElementById('secActive').value = sec.is_active || '1';
    document.getElementById('btnSecSubmit').textContent = 'Update Section';
    document.getElementById('sectionModal').style.display = 'flex';
}

function closeSectionModal() {
    document.getElementById('sectionModal').style.display = 'none';
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
