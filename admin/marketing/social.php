<?php
/**
 * admin/marketing/social.php — DT Brand's Official Social Channels & WhatsApp Concierge Studio
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

$page_title = "Social Channels & Concierge Studio";
$active_nav = "marketing";
$active_subnav = "social";

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = trim((string)($_POST['action'] ?? ''));

    if ($action === 'create_channel') {
        $data = [
            'channel_key' => trim((string)($_POST['channel_key'] ?? '')),
            'title' => trim((string)($_POST['title'] ?? '')),
            'handle' => trim((string)($_POST['handle'] ?? '')),
            'url' => trim((string)($_POST['url'] ?? '')),
            'icon_svg' => trim((string)($_POST['icon_svg'] ?? '')),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'status' => 'active',
        ];

        if ($data['channel_key'] === '' || $data['url'] === '') {
            $error = "Channel key and URL are required.";
        } else {
            $newId = ContentManager::createSocialChannel($data);
            if ($newId > 0) {
                $message = "Channel '{$data['title']}' added successfully!";
            } else {
                $error = "Failed to add social channel.";
            }
        }
    } elseif ($action === 'update_channel') {
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'title' => trim((string)($_POST['title'] ?? '')),
            'handle' => trim((string)($_POST['handle'] ?? '')),
            'url' => trim((string)($_POST['url'] ?? '')),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'status' => trim((string)($_POST['status'] ?? 'active')),
        ];

        if ($id > 0 && $data['url'] !== '') {
            ContentManager::updateSocialChannel($id, $data);
            $message = "Channel #{$id} updated successfully!";
        }
    } elseif ($action === 'delete_channel') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            ContentManager::deleteSocialChannel($id);
            $message = "Channel #{$id} removed.";
        }
    }
}

$channels = ContentManager::getSocialChannels(false);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Channels &amp; Concierge Studio — DT Brand's Admin</title>
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

        .dt-channel-card {
            background: #FFFFFF;
            border: 1.5px solid var(--dt-border);
            border-radius: 12px;
            padding: 16px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
            transition: all 0.2s ease;
            margin-bottom: 12px;
        }
        .dt-channel-card:hover {
            border-color: var(--dt-gold);
            transform: translateY(-1.5px);
        }
        .dt-channel-icon {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: #FAF5E8;
            color: var(--dt-gold-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(212,175,55,0.4);
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
                        <span>Social Channels &amp; Concierge Studio</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?php echo count($channels); ?> Channels</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Manage official WhatsApp Business master numbers, Instagram showcase, and verified brand socials.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px; flex-wrap:wrap;">
                    <button type="button" class="dt-btn-gold" onclick="openAddChannelModal()">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add Channel</span>
                    </button>
                </div>
            </div>

            <!-- Channels List -->
            <div>
                <?php foreach ($channels as $c): ?>
                    <?php
                        $cId = (int)($c['id'] ?? 0);
                        $cKey = htmlspecialchars($c['channel_key'] ?? '');
                        $cTitle = htmlspecialchars($c['title'] ?? '');
                        $cHandle = htmlspecialchars($c['handle'] ?? '');
                        $cUrl = htmlspecialchars($c['url'] ?? '');
                        $cStatus = $c['status'] ?? 'active';
                        $cOrder = (int)($c['display_order'] ?? 0);
                    ?>
                    <div class="dt-channel-card">
                        <div class="dt-channel-icon">
                            <?php if ($cKey === 'whatsapp'): ?>
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            <?php elseif ($cKey === 'instagram'): ?>
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                            <?php elseif ($cKey === 'facebook'): ?>
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                            <?php elseif ($cKey === 'youtube'): ?>
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
                            <?php else: ?>
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                            <?php endif; ?>
                        </div>
                        <div style="flex:1;">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <h4 style="margin:0; font-size:14px; font-weight:800; color:#111827;"><?php echo $cTitle; ?></h4>
                                <span class="adm-badge gold" style="font-size:10px; text-transform:uppercase;"><?php echo $cKey; ?></span>
                            </div>
                            <div style="font-size:12px; color:#475569; margin-top:2px;">
                                <strong>Handle:</strong> <?php echo $cHandle ?: 'Direct Link'; ?> &bull; 
                                <code style="font-size:11px;"><?php echo $cUrl; ?></code>
                            </div>
                        </div>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <a href="<?php echo $cUrl; ?>" target="_blank" class="dt-btn-pale" style="font-size:11.5px;">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                                <span>Verify Link</span>
                            </a>
                            <button type="button" class="dt-btn-pale" style="font-size:11.5px;" onclick='openEditChannelModal(<?php echo json_encode($c); ?>)'>Edit</button>
                            <form method="POST" style="margin:0;" onsubmit="return confirm('Remove this social channel?');">
                                <input type="hidden" name="action" value="delete_channel">
                                <input type="hidden" name="id" value="<?php echo $cId; ?>">
                                <button type="submit" class="dt-btn-danger" style="font-size:11.5px;">Delete</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Modal for Add/Edit Channel -->
<div id="chanModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="background:#FFFFFF; border-radius:12px; width:95%; max-width:480px; padding:22px; border:1.5px solid var(--dt-gold);">
        <h3 id="chanModalHeading" style="margin:0 0 14px 0; font-size:1.15rem; font-weight:800; color:#181512;">Add Social Channel</h3>
        <form method="POST" id="chanForm">
            <input type="hidden" name="action" id="chanFormAction" value="create_channel">
            <input type="hidden" name="id" id="chanId" value="">
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div id="divChanKey">
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Channel Key</label>
                    <select name="channel_key" id="chanKey" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 8px; font-weight:600;">
                        <option value="whatsapp">WhatsApp Business</option>
                        <option value="instagram">Instagram</option>
                        <option value="facebook">Facebook</option>
                        <option value="youtube">YouTube</option>
                        <option value="telegram">Telegram</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Display Title *</label>
                    <input type="text" name="title" id="chanTitle" required placeholder="e.g. Official WhatsApp Concierge" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Handle / Username</label>
                    <input type="text" name="handle" id="chanHandle" placeholder="e.g. +91 70463 63528" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Target URL *</label>
                    <input type="url" name="url" id="chanUrl" required placeholder="https://wa.me/917046363528" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Display Order</label>
                        <input type="number" name="display_order" id="chanOrder" value="1" min="0" max="99" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Status</label>
                        <select name="status" id="chanStatus" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 8px; font-weight:600;">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div style="margin-top:16px; display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" class="dt-btn-pale" onclick="closeChannelModal()">Cancel</button>
                <button type="submit" class="dt-btn-gold" id="btnChanSubmit">Save Channel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddChannelModal() {
    document.getElementById('chanModalHeading').textContent = 'Add Social Channel';
    document.getElementById('chanFormAction').value = 'create_channel';
    document.getElementById('chanId').value = '';
    document.getElementById('divChanKey').style.display = 'block';
    document.getElementById('chanTitle').value = '';
    document.getElementById('chanHandle').value = '';
    document.getElementById('chanUrl').value = '';
    document.getElementById('chanOrder').value = '1';
    document.getElementById('chanStatus').value = 'active';
    document.getElementById('btnChanSubmit').textContent = 'Create Channel';
    document.getElementById('chanModal').style.display = 'flex';
}

function openEditChannelModal(chan) {
    document.getElementById('chanModalHeading').textContent = 'Edit Channel #' + (chan.id || '');
    document.getElementById('chanFormAction').value = 'update_channel';
    document.getElementById('chanId').value = chan.id || '';
    document.getElementById('divChanKey').style.display = 'none';
    document.getElementById('chanTitle').value = chan.title || '';
    document.getElementById('chanHandle').value = chan.handle || '';
    document.getElementById('chanUrl').value = chan.url || '';
    document.getElementById('chanOrder').value = chan.display_order || '0';
    document.getElementById('chanStatus').value = chan.status || 'active';
    document.getElementById('btnChanSubmit').textContent = 'Update Channel';
    document.getElementById('chanModal').style.display = 'flex';
}

function closeChannelModal() {
    document.getElementById('chanModal').style.display = 'none';
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
