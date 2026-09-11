<?php
/**
 * admin/marketing/share-templates.php — DT Brand's Reseller & WhatsApp Share Templates Studio
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

$page_title = "Reseller & WhatsApp Share Templates";
$active_nav = "marketing";
$active_subnav = "share-templates";

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = trim((string)($_POST['action'] ?? ''));

    if ($action === 'create_template') {
        $data = [
            'template_key' => trim((string)($_POST['template_key'] ?? '')),
            'title' => trim((string)($_POST['title'] ?? '')),
            'channel' => trim((string)($_POST['channel'] ?? 'whatsapp')),
            'content_body' => trim((string)($_POST['content_body'] ?? '')),
            'status' => 'active',
        ];

        if ($data['template_key'] === '' || $data['content_body'] === '') {
            $error = "Template key and content body are required.";
        } else {
            $newId = ContentManager::createShareTemplate($data);
            if ($newId > 0) {
                $message = "Share template '{$data['title']}' created successfully!";
            } else {
                $error = "Failed to create share template.";
            }
        }
    } elseif ($action === 'update_template') {
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'title' => trim((string)($_POST['title'] ?? '')),
            'channel' => trim((string)($_POST['channel'] ?? 'whatsapp')),
            'content_body' => trim((string)($_POST['content_body'] ?? '')),
        ];

        if ($id > 0 && $data['content_body'] !== '') {
            ContentManager::updateShareTemplate($id, $data);
            $message = "Template #{$id} updated successfully!";
        }
    } elseif ($action === 'delete_template') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            ContentManager::deleteShareTemplate($id);
            $message = "Template #{$id} deleted.";
        }
    }
}

$templates = ContentManager::getShareTemplates(false);

// Demo data for simulator
$sampleVars = [
    'product_title' => 'Pure Paithani Silk Saree — Peacock Border Zari',
    'mrp' => '4,999',
    'reseller_price' => '2,450',
    'reseller_margin' => '2,549',
    'shop_url' => 'https://jaihanumantex.in/shop/pure-paithani-silk',
    'order_link' => 'https://jaihanumantex.in/checkout?direct=1',
    'phone' => '+91 70463 63528'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reseller &amp; WhatsApp Share Templates — DT Brand's Admin</title>
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

        .dt-wa-bubble {
            background: #DCF8C6;
            border-radius: 8px;
            padding: 12px 14px;
            color: #111827;
            font-size: 13px;
            line-height: 1.45;
            white-space: pre-wrap;
            box-shadow: 0 1px 2px rgba(0,0,0,0.15);
            position: relative;
            max-width: 480px;
        }
        .dt-wa-time {
            text-align: right;
            font-size: 10px;
            color: #64748B;
            margin-top: 4px;
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
        .dt-btn-emerald {
            background: linear-gradient(135deg, #15803D 0%, #16A34A 100%);
            border: 1px solid #14532D;
            color: #FFFFFF;
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
                        <span>Reseller &amp; WhatsApp Share Templates</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?php echo count($templates); ?> Templates</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Create standardized copy formats for 1-click customer catalog shares and reseller dropship marketing.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/marketing/social.php" class="dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                        <span>Social Channels</span>
                    </a>
                    <button type="button" class="dt-btn-gold" onclick="openAddTemplateModal()">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add Template</span>
                    </button>
                </div>
            </div>

            <!-- Templates List & Simulators -->
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap:18px;">
                <?php foreach ($templates as $t): ?>
                    <?php
                        $tId = (int)($t['id'] ?? 0);
                        $tKey = htmlspecialchars($t['template_key'] ?? '');
                        $tTitle = htmlspecialchars($t['title'] ?? '');
                        $tChannel = htmlspecialchars($t['channel'] ?? 'whatsapp');
                        $tBody = $t['content_body'] ?? '';
                        $rendered = ContentManager::renderShareTemplate($tBody, $sampleVars);
                        $waUrl = 'https://api.whatsapp.com/send?text=' . rawurlencode($rendered);
                    ?>
                    <div class="adm-card" style="padding:18px; display:flex; flex-direction:column; justify-content:space-between; gap:14px;">
                        <div>
                            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:10px;">
                                <div>
                                    <h3 style="margin:0; font-size:15px; font-weight:800; color:#111827;"><?php echo $tTitle; ?></h3>
                                    <code style="font-size:11px; color:#64748B;"><?php echo $tKey; ?></code>
                                </div>
                                <span class="adm-badge gold" style="font-size:10.5px; text-transform:uppercase;"><?php echo $tChannel; ?></span>
                            </div>

                            <!-- WhatsApp Simulated Bubble -->
                            <div style="background:#E5DDD5; padding:12px; border-radius:8px; border:1px solid #D1D5DB;">
                                <div class="dt-wa-bubble">
                                    <?php echo htmlspecialchars($rendered); ?>
                                    <div class="dt-wa-time">10:30 AM &bull; Double Tick</div>
                                </div>
                            </div>
                        </div>

                        <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid #F1F5F9; padding-top:10px; margin-top:6px;">
                            <a href="<?php echo $waUrl; ?>" target="_blank" class="dt-btn-emerald" style="font-size:11px;">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                <span>Test on WhatsApp</span>
                            </a>
                            <div style="display:inline-flex; gap:6px;">
                                <button type="button" class="dt-btn-pale" style="font-size:11px;" onclick='openEditTemplateModal(<?php echo json_encode($t); ?>)'>Edit</button>
                                <form method="POST" style="margin:0;" onsubmit="return confirm('Delete this share template?');">
                                    <input type="hidden" name="action" value="delete_template">
                                    <input type="hidden" name="id" value="<?php echo $tId; ?>">
                                    <button type="submit" class="dt-btn-danger" style="font-size:11px;">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Modal for Add/Edit Template -->
<div id="tplModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="background:#FFFFFF; border-radius:12px; width:95%; max-width:540px; padding:22px; border:1.5px solid var(--dt-gold);">
        <h3 id="tplModalHeading" style="margin:0 0 14px 0; font-size:1.15rem; font-weight:800; color:#181512;">Add Share Template</h3>
        <form method="POST" id="tplForm">
            <input type="hidden" name="action" id="tplFormAction" value="create_template">
            <input type="hidden" name="id" id="tplId" value="">
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div id="divTplKey">
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Template Key * (e.g. reseller_product_card)</label>
                    <input type="text" name="template_key" id="tplKey" required style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Title *</label>
                    <input type="text" name="title" id="tplTitle" required style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Channel</label>
                    <select name="channel" id="tplChannel" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 8px; font-weight:600;">
                        <option value="whatsapp">WhatsApp Business</option>
                        <option value="telegram">Telegram</option>
                        <option value="catalog">PDF / Catalog Sheet</option>
                        <option value="sms">SMS Text</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:flex; justify-content:space-between; margin-bottom:4px;">
                        <span>Template Body *</span>
                        <span style="font-size:11px; color:#64748B;">Click tag to insert:</span>
                    </label>
                    <div style="display:flex; gap:4px; flex-wrap:wrap; margin-bottom:6px;">
                        <button type="button" class="dt-btn-pale" style="font-size:10px; padding:2px 6px;" onclick="insertTag('{product_title}')">{product_title}</button>
                        <button type="button" class="dt-btn-pale" style="font-size:10px; padding:2px 6px;" onclick="insertTag('{mrp}')">{mrp}</button>
                        <button type="button" class="dt-btn-pale" style="font-size:10px; padding:2px 6px;" onclick="insertTag('{reseller_price}')">{reseller_price}</button>
                        <button type="button" class="dt-btn-pale" style="font-size:10px; padding:2px 6px;" onclick="insertTag('{reseller_margin}')">{reseller_margin}</button>
                        <button type="button" class="dt-btn-pale" style="font-size:10px; padding:2px 6px;" onclick="insertTag('{shop_url}')">{shop_url}</button>
                        <button type="button" class="dt-btn-pale" style="font-size:10px; padding:2px 6px;" onclick="insertTag('{phone}')">{phone}</button>
                    </div>
                    <textarea name="content_body" id="tplBody" required rows="6" style="width:100%; border:1.5px solid #CBD5E1; border-radius:6px; padding:8px 10px; font-weight:600; box-sizing:border-box; font-family:monospace;"></textarea>
                </div>
            </div>
            <div style="margin-top:16px; display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" class="dt-btn-pale" onclick="closeTemplateModal()">Cancel</button>
                <button type="submit" class="dt-btn-gold" id="btnTplSubmit">Save Template</button>
            </div>
        </form>
    </div>
</div>

<script>
function insertTag(tag) {
    const area = document.getElementById('tplBody');
    area.value += tag;
    area.focus();
}

function openAddTemplateModal() {
    document.getElementById('tplModalHeading').textContent = 'Add Share Template';
    document.getElementById('tplFormAction').value = 'create_template';
    document.getElementById('tplId').value = '';
    document.getElementById('divTplKey').style.display = 'block';
    document.getElementById('tplKey').value = '';
    document.getElementById('tplTitle').value = '';
    document.getElementById('tplChannel').value = 'whatsapp';
    document.getElementById('tplBody').value = '';
    document.getElementById('btnTplSubmit').textContent = 'Create Template';
    document.getElementById('tplModal').style.display = 'flex';
}

function openEditTemplateModal(tpl) {
    document.getElementById('tplModalHeading').textContent = 'Edit Template #' + (tpl.id || '');
    document.getElementById('tplFormAction').value = 'update_template';
    document.getElementById('tplId').value = tpl.id || '';
    document.getElementById('divTplKey').style.display = 'none';
    document.getElementById('tplTitle').value = tpl.title || '';
    document.getElementById('tplChannel').value = tpl.channel || 'whatsapp';
    document.getElementById('tplBody').value = tpl.content_body || '';
    document.getElementById('btnTplSubmit').textContent = 'Update Template';
    document.getElementById('tplModal').style.display = 'flex';
}

function closeTemplateModal() {
    document.getElementById('tplModal').style.display = 'none';
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
