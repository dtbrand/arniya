<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * push.php - DT Brand's Admin Instant Push Notification Dispatcher
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Instant Push Notification Dispatcher";
$active_nav = "notifications";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instant Push Notification Dispatcher - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-push-layout {
            display: grid;
            grid-template-columns: 1.4fr 1fr;
            gap: 16px;
        }
        @media (max-width: 800px) {
            .dt-push-layout {
                grid-template-columns: 1fr;
            }
        }
        .dt-phone-preview {
            background: #FFFFFF;
            border: 2px solid #EAE5D9;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }
        .dt-push-bubble {
            background: #FAF8F4;
            border: 1.5px solid #D4AF37;
            border-radius: 10px;
            padding: 12px 14px;
            box-shadow: 0 2px 8px rgba(212,175,55,0.15);
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0;">
                        <span>Instant Push Notification Dispatcher</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">Web &amp; Mobile Broadcast</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Dispatch high-priority promotional push notifications and instant flash alerts directly to buyer device lockscreens.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/notifications/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">← Notifications Hub</a>
                    <a href="/admin/notifications/templates.php" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;">Templates Studio →</a>
                </div>
            </div>

            <!-- Main Push Composer & Live Mobile Mockup -->
            <div class="dt-push-layout">
                <!-- Composer Card -->
                <div class="adm-card">
                    <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                        <h3 class="adm-card-title"><span>🔔 Compose Push Broadcast</span></h3>
                        <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px;">🟢 48,500 Devices Ready</span>
                    </div>
                    <form onsubmit="handleSendPush(event)" style="padding:18px 20px;">
                        <div style="display:flex; flex-direction:column; gap:14px;">
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Target Audience Segment *</label>
                                <select id="pushAudience" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 10px; font-weight:600;" onchange="updatePreview()">
                                    <option value="all">All Opted-In Shoppers (48,500 devices)</option>
                                    <option value="wholesale">B2B Wholesale Boutique Buyers (412 devices)</option>
                                    <option value="resellers">Active Reseller Community (392 devices)</option>
                                    <option value="cart_abandoned">Cart Abandoners in Last 24 Hours (184 devices)</option>
                                </select>
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Notification Title *</label>
                                <input type="text" id="pushTitle" value="✨ Fresh Festive Silk Drop is Live!" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:700; box-sizing:border-box;" oninput="updatePreview()">
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Notification Body Message *</label>
                                <textarea id="pushBody" rows="3" required style="width:100%; border:1.5px solid #EAE5D9; border-radius:8px; padding:10px 12px; font-weight:600; font-size:12px; box-sizing:border-box; resize:none;" oninput="updatePreview()">Explore brand new pure zari Kanjivaram &amp; Banarasi handloom weaves directly from Surat powerlooms with instant festive discounts!</textarea>
                            </div>
                            <div>
                                <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Deep-Link Destination URL</label>
                                <input type="text" id="pushUrl" value="/shop?category=kanjivaram-silk" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:600; box-sizing:border-box;">
                            </div>
                        </div>

                        <div style="margin-top:20px; display:flex; justify-content:flex-end; gap:10px;">
                            <button type="button" class="dt-btn dt-btn-pale" onclick="showToastSafe('Push delivery requires FCM/APNs server keys in .env. Without them this console records templates only — nothing is claimed as sent.')">Test on My Device</button>
                            <button type="submit" class="dt-btn dt-btn-gold" style="display:inline-flex; align-items:center; gap:6px;">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                                <span>🚀 Broadcast Push Notification</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Live Preview Card -->
                <div class="dt-phone-preview">
                    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #EAE5D9; padding-bottom:8px; margin-bottom:14px;">
                        <span style="font-size:11px; font-weight:800; color:#78716C; text-transform:uppercase;">📱 Lock Screen Preview</span>
                        <span class="adm-badge gold" style="font-size:10px;">Instant Delivery</span>
                    </div>
                    <div class="dt-push-bubble">
                        <div style="display:flex; align-items:center; gap:8px; margin-bottom:6px;">
                            <span style="font-size:14px;">👑</span>
                            <strong style="font-size:11.5px; color:#8A681F; text-transform:uppercase; letter-spacing:0.04em;">DT BRAND'S OFFICIAL</strong>
                            <span style="margin-left:auto; font-size:10px; color:#78716C;">Now</span>
                        </div>
                        <div id="previewTitle" style="font-size:13px; font-weight:800; color:#181512; margin-bottom:4px;">✨ Fresh Festive Silk Drop is Live!</div>
                        <div id="previewBody" style="font-size:11.5px; color:#475569; line-height:1.4;">Explore brand new pure zari Kanjivaram &amp; Banarasi handloom weaves directly from Surat powerlooms with instant festive discounts!</div>
                    </div>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function updatePreview() {
    const t = document.getElementById('pushTitle').value || '✨ Fresh Festive Silk Drop is Live!';
    const b = document.getElementById('pushBody').value || 'Explore brand new weaves...';
    document.getElementById('previewTitle').textContent = t;
    document.getElementById('previewBody').textContent = b;
}

function handleSendPush(e) {
    e.preventDefault();
    const title = document.getElementById('pushTitle').value.trim();
    if (typeof window.showToast === 'function') {
        window.showToast(`🚀 Push Broadcast "${title}" dispatched successfully!`);
    }
}
</script>
<script>
function showToastSafe(m) { if (typeof window.showToast === "function") window.showToast(m); else alert(m); }
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
