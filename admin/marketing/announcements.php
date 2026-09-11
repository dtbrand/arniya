<?php
/**
 * admin/marketing/announcements.php — DT Brand's Announcements & Notification Marquee Studio
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

$page_title = "Store Announcements & Marquee Studio";
$active_nav = "marketing";
$active_subnav = "announcements";

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = trim((string)($_POST['action'] ?? ''));

    if ($action === 'create_announcement') {
        $data = [
            'title' => trim((string)($_POST['title'] ?? '')),
            'message' => trim((string)($_POST['message'] ?? '')),
            'link_url' => trim((string)($_POST['link_url'] ?? '')),
            'placement' => trim((string)($_POST['placement'] ?? 'topbar')),
            'bg_color' => trim((string)($_POST['bg_color'] ?? '#8A681F')),
            'text_color' => trim((string)($_POST['text_color'] ?? '#FFFFFF')),
            'starts_at' => !empty($_POST['starts_at']) ? $_POST['starts_at'] : null,
            'ends_at' => !empty($_POST['ends_at']) ? $_POST['ends_at'] : null,
            'status' => trim((string)($_POST['status'] ?? 'active')),
        ];

        if ($data['message'] === '') {
            $error = "Announcement text is required.";
        } else {
            $newId = ContentManager::createAnnouncement($data);
            if ($newId > 0) {
                $message = "Announcement marquee created successfully!";
            } else {
                $error = "Failed to create announcement.";
            }
        }
    } elseif ($action === 'update_announcement') {
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'title' => trim((string)($_POST['title'] ?? '')),
            'message' => trim((string)($_POST['message'] ?? '')),
            'link_url' => trim((string)($_POST['link_url'] ?? '')),
            'placement' => trim((string)($_POST['placement'] ?? 'topbar')),
            'bg_color' => trim((string)($_POST['bg_color'] ?? '#8A681F')),
            'text_color' => trim((string)($_POST['text_color'] ?? '#FFFFFF')),
            'starts_at' => !empty($_POST['starts_at']) ? $_POST['starts_at'] : null,
            'ends_at' => !empty($_POST['ends_at']) ? $_POST['ends_at'] : null,
            'status' => trim((string)($_POST['status'] ?? 'active')),
        ];

        if ($id > 0 && $data['message'] !== '') {
            ContentManager::updateAnnouncement($id, $data);
            $message = "Announcement #{$id} updated successfully!";
        }
    } elseif ($action === 'delete_announcement') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            ContentManager::deleteAnnouncement($id);
            $message = "Announcement #{$id} deleted.";
        }
    } elseif ($action === 'toggle_status') {
        $id = (int)($_POST['id'] ?? 0);
        $current = trim((string)($_POST['current_status'] ?? 'active'));
        $newStatus = ($current === 'active') ? 'inactive' : 'active';
        if ($id > 0) {
            ContentManager::updateAnnouncement($id, ['status' => $newStatus]);
            $message = "Announcement #{$id} status changed to {$newStatus}.";
        }
    }
}

$announcements = ContentManager::getAnnouncements(false);
$activeAnnouncements = array_filter($announcements, fn($a) => ($a['status'] ?? 'active') === 'active');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Announcements &amp; Marquee Studio — DT Brand's Admin</title>
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

        .dt-marquee-preview-box {
            background: #181512;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 22px;
            border: 1.5px solid var(--dt-gold);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        .dt-marquee-bar {
            height: 38px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            padding: 0 16px;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.2);
            transition: all 0.3s ease;
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
                        <span>Store Announcements &amp; Marquee</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?php echo count($activeAnnouncements); ?> Active</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Broadcast storewide alerts, festive dispatch notices, and free shipping triggers across the top bar.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px; flex-wrap:wrap;">
                    <button type="button" class="dt-btn-gold" onclick="openAddAnnounceModal()">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add Announcement</span>
                    </button>
                </div>
            </div>

            <!-- Live Simulator Box -->
            <div class="dt-marquee-preview-box">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; color:#FAF5E8; font-size:12px; font-weight:800;">
                    <span>LIVE STOREFRONT TOP-BAR SIMULATOR</span>
                    <span style="color:#A1A1AA;">Public View Render</span>
                </div>
                <?php
                    $firstActive = !empty($activeAnnouncements) ? reset($activeAnnouncements) : null;
                    $prevBg = $firstActive['bg_color'] ?? '#8A681F';
                    $prevText = $firstActive['text_color'] ?? '#FFFFFF';
                    $prevMsg = $firstActive['message'] ?? 'Direct Loom Wholesale Hub: Festive Silk Saree Booking Open! WhatsApp: +91 70463 63528';
                ?>
                <div class="dt-marquee-bar" style="background:<?php echo htmlspecialchars($prevBg); ?>; color:<?php echo htmlspecialchars($prevText); ?>;">
                    <span style="display:inline-flex; align-items:center; gap:8px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        <span><?php echo htmlspecialchars($prevMsg); ?></span>
                    </span>
                </div>
            </div>

            <!-- Announcements Table -->
            <div class="adm-card">
                <div class="adm-card-head" style="padding:14px 18px; border-bottom:1px solid #EAE5D9;">
                    <h3 class="adm-card-title" style="margin:0; font-size:1.1rem; font-weight:800; color:#181512; display:flex; align-items:center; gap:8px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        <span>Active Marquee List</span>
                    </h3>
                </div>
                <div class="adm-table-responsive" style="overflow-x:auto;">
                    <table class="adm-table" style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr style="background:#F8FAFC; border-bottom:1px solid #E2E8F0; text-align:left; font-size:11.5px; color:#475569; text-transform:uppercase;">
                                <th style="padding:10px 14px; width:60px;">ID</th>
                                <th style="padding:10px 14px;">Style Preview</th>
                                <th style="padding:10px 14px;">Message Text</th>
                                <th style="padding:10px 14px;">Target Link</th>
                                <th style="padding:10px 14px;">Placement</th>
                                <th style="padding:10px 14px;">Status</th>
                                <th style="padding:10px 14px; text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($announcements)): ?>
                                <tr>
                                    <td colspan="7" style="padding:24px; text-align:center; color:#64748B;">No announcements created.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($announcements as $a): ?>
                                    <?php
                                        $aId = (int)($a['id'] ?? 0);
                                        $aTitle = htmlspecialchars($a['title'] ?? '');
                                        $aMsg = htmlspecialchars($a['message'] ?? '');
                                        $aLink = htmlspecialchars($a['link_url'] ?? '');
                                        $aPlacement = htmlspecialchars($a['placement'] ?? 'topbar');
                                        $aBg = htmlspecialchars($a['bg_color'] ?? '#8A681F');
                                        $aTxt = htmlspecialchars($a['text_color'] ?? '#FFFFFF');
                                        $aStatus = $a['status'] ?? 'active';
                                    ?>
                                    <tr style="border-bottom:1px solid #F1F5F9; font-size:12.5px;">
                                        <td style="padding:10px 14px; font-weight:800; color:#8A681F;">#<?php echo $aId; ?></td>
                                        <td style="padding:10px 14px;">
                                            <div style="display:inline-block; padding:3px 8px; border-radius:4px; font-size:11px; font-weight:700; background:<?php echo $aBg; ?>; color:<?php echo $aTxt; ?>;">Sample</div>
                                        </td>
                                        <td style="padding:10px 14px;">
                                            <div style="font-weight:700; color:#1E293B;"><?php echo $aTitle ? "<strong>{$aTitle}:</strong> " : ''; ?><?php echo $aMsg; ?></div>
                                        </td>
                                        <td style="padding:10px 14px;">
                                            <?php if ($aLink): ?>
                                                <code style="font-size:11px; background:#F8FAFC; padding:2px 6px; border-radius:4px;"><?php echo $aLink; ?></code>
                                            <?php else: ?>
                                                <span style="color:#94A3B8; font-size:11px;">None</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="padding:10px 14px;">
                                            <span class="adm-badge gold" style="font-size:10.5px;"><?php echo $aPlacement; ?></span>
                                        </td>
                                        <td style="padding:10px 14px;">
                                            <?php if ($aStatus === 'active'): ?>
                                                <span class="adm-badge success" style="font-size:10.5px;">Active</span>
                                            <?php else: ?>
                                                <span class="adm-badge" style="background:#F1F5F9; color:#64748B; font-size:10.5px;">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="padding:10px 14px; text-align:right;">
                                            <div style="display:inline-flex; gap:6px;">
                                                <button type="button" class="dt-btn-pale" style="font-size:11px;" onclick='openEditAnnounceModal(<?php echo json_encode($a); ?>)'>Edit</button>
                                                <form method="POST" style="margin:0;">
                                                    <input type="hidden" name="action" value="toggle_status">
                                                    <input type="hidden" name="id" value="<?php echo $aId; ?>">
                                                    <input type="hidden" name="current_status" value="<?php echo $aStatus; ?>">
                                                    <button type="submit" class="dt-btn-pale" style="font-size:11px;"><?php echo $aStatus === 'active' ? 'Disable' : 'Enable'; ?></button>
                                                </form>
                                                <form method="POST" style="margin:0;" onsubmit="return confirm('Delete this announcement?');">
                                                    <input type="hidden" name="action" value="delete_announcement">
                                                    <input type="hidden" name="id" value="<?php echo $aId; ?>">
                                                    <button type="submit" class="dt-btn-danger" style="font-size:11px;">Delete</button>
                                                </form>
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
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Modal for Announcement -->
<div id="annModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="background:#FFFFFF; border-radius:12px; width:95%; max-width:500px; padding:22px; border:1.5px solid var(--dt-gold);">
        <h3 id="annModalHeading" style="margin:0 0 14px 0; font-size:1.15rem; font-weight:800; color:#181512;">Add Store Announcement</h3>
        <form method="POST" id="annForm">
            <input type="hidden" name="action" id="annFormAction" value="create_announcement">
            <input type="hidden" name="id" id="annId" value="">
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Title (Internal or Label)</label>
                    <input type="text" name="title" id="annTitle" placeholder="e.g. Free Shipping Alert" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Announcement Message *</label>
                    <textarea name="message" id="annMsg" required rows="2" placeholder="e.g. Free Loom Delivery across India on orders above ₹10,000!" style="width:100%; border:1.5px solid #CBD5E1; border-radius:6px; padding:8px 10px; font-weight:600; box-sizing:border-box;"></textarea>
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Click-Through Link</label>
                    <input type="text" name="link_url" id="annLink" placeholder="/shop" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Background Color</label>
                        <input type="color" name="bg_color" id="annBg" value="#8A681F" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:2px; box-sizing:border-box; cursor:pointer;">
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Text Color</label>
                        <input type="color" name="text_color" id="annTxt" value="#FFFFFF" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:2px; box-sizing:border-box; cursor:pointer;">
                    </div>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Placement</label>
                        <select name="placement" id="annPlacement" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 8px; font-weight:600;">
                            <option value="topbar">Storefront Top-Bar</option>
                            <option value="cart_drawer">Cart Drawer</option>
                            <option value="checkout">Checkout Summary</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Status</label>
                        <select name="status" id="annStatus" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 8px; font-weight:600;">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            <div style="margin-top:16px; display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" class="dt-btn-pale" onclick="closeAnnounceModal()">Cancel</button>
                <button type="submit" class="dt-btn-gold" id="btnAnnSubmit">Save Announcement</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddAnnounceModal() {
    document.getElementById('annModalHeading').textContent = 'Add Store Announcement';
    document.getElementById('annFormAction').value = 'create_announcement';
    document.getElementById('annId').value = '';
    document.getElementById('annTitle').value = '';
    document.getElementById('annMsg').value = '';
    document.getElementById('annLink').value = '';
    document.getElementById('annBg').value = '#8A681F';
    document.getElementById('annTxt').value = '#FFFFFF';
    document.getElementById('annPlacement').value = 'topbar';
    document.getElementById('annStatus').value = 'active';
    document.getElementById('btnAnnSubmit').textContent = 'Create Announcement';
    document.getElementById('annModal').style.display = 'flex';
}

function openEditAnnounceModal(ann) {
    document.getElementById('annModalHeading').textContent = 'Edit Announcement #' + (ann.id || '');
    document.getElementById('annFormAction').value = 'update_announcement';
    document.getElementById('annId').value = ann.id || '';
    document.getElementById('annTitle').value = ann.title || '';
    document.getElementById('annMsg').value = ann.message || '';
    document.getElementById('annLink').value = ann.link_url || '';
    document.getElementById('annBg').value = ann.bg_color || '#8A681F';
    document.getElementById('annTxt').value = ann.text_color || '#FFFFFF';
    document.getElementById('annPlacement').value = ann.placement || 'topbar';
    document.getElementById('annStatus').value = ann.status || 'active';
    document.getElementById('btnAnnSubmit').textContent = 'Update Announcement';
    document.getElementById('annModal').style.display = 'flex';
}

function closeAnnounceModal() {
    document.getElementById('annModal').style.display = 'none';
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
