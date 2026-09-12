<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * contact.php - DT Brand's Admin Contact & Showroom Info Editor
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../../src/Database.php';
use DTBrand\Database;

$page_title = "Contact & Showroom Info Editor";
$active_nav = "cms";

// Load existing contact settings from database
$contactSettings = [];
try {
    foreach (Database::query('SELECT key_name, `value` FROM settings WHERE key_name LIKE "contact_%"') as $r) {
        $contactSettings[$r['key_name']] = (string)$r['value'];
    }
} catch (\Throwable $e) {}

function getContactVal(string $k, string $def, array $settings): string {
    $v = trim((string)($settings[$k] ?? ''));
    return $v !== '' ? $v : $def;
}

$showroomAddress = getContactVal('contact_showroom_address', 'Shop #104–108, First Floor, Ring Road Textile Market, Surat, Gujarat - 395002', $contactSettings);
$whatsappHotline = getContactVal('contact_whatsapp_hotline', '+91 70463 63528', $contactSettings);
$wholesaleLine = getContactVal('contact_wholesale_line', '+91 70463 63528', $contactSettings);
$supportEmail = getContactVal('contact_support_email', 'support@jaihanumantex.in', $contactSettings);
$wholesaleEmail = getContactVal('contact_wholesale_email', 'wholesale@jaihanumantex.in', $contactSettings);
$businessHours = getContactVal('contact_business_hours', 'Mon – Sat: 10:00 AM – 8:30 PM (Sunday Closed)', $contactSettings);
$gstin = getContactVal('contact_gstin', '24AAACG1289F1Z4', $contactSettings);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact &amp; Showroom Info Editor - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        @media (max-width: 768px) {
            .dt-contact-grid {
                grid-template-columns: 1fr;
            }
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
                        <span>Contact &amp; Showroom Info Editor</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;">Direct Channel Config</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Update Surat flagship showroom address, WhatsApp customer care numbers, B2B wholesale hotlines, and GSTIN.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px;">
                    <a href="/admin/cms/" class="dt-btn dt-btn-pale" style="text-decoration:none; height:32px; font-size:12px; font-weight:700;"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="margin-right:4px;"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>CMS Hub</a>
                </div>
            </div>

            <!-- Page Editor Card -->
            <div class="adm-card" style="max-width:850px;">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 class="adm-card-title"><span style="display:inline-flex; align-items:center; gap:6px;"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>Flagship Showroom &amp; Customer Support</span></h3>
                    <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-weight:700; font-size:11.5px; display:inline-flex; align-items:center; gap:5px;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20 6L9 17l-5-5"></path></svg>Direct Database Persistence</span>
                </div>
                <form id="contactSettingsForm" onsubmit="saveContactSettings(event)" style="padding:18px 20px;">
                    <div class="dt-contact-grid">
                        <div style="grid-column: 1 / -1;">
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Surat Flagship Showroom Address *</label>
                            <input type="text" id="contact_showroom_address" name="contact_showroom_address" value="<?php echo htmlspecialchars($showroomAddress); ?>" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:600; box-sizing:border-box;">
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Official WhatsApp Concierge Hotline *</label>
                            <input type="text" id="contact_whatsapp_hotline" name="contact_whatsapp_hotline" value="<?php echo htmlspecialchars($whatsappHotline); ?>" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:700; box-sizing:border-box;">
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">B2B Wholesale Dispatch Direct Line</label>
                            <input type="text" id="contact_wholesale_line" name="contact_wholesale_line" value="<?php echo htmlspecialchars($wholesaleLine); ?>" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:700; box-sizing:border-box;">
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Support Email Address *</label>
                            <input type="email" id="contact_support_email" name="contact_support_email" value="<?php echo htmlspecialchars($supportEmail); ?>" required style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:600; box-sizing:border-box;">
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">B2B Wholesale Trade Email</label>
                            <input type="email" id="contact_wholesale_email" name="contact_wholesale_email" value="<?php echo htmlspecialchars($wholesaleEmail); ?>" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:600; box-sizing:border-box;">
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Showroom Business Hours</label>
                            <input type="text" id="contact_business_hours" name="contact_business_hours" value="<?php echo htmlspecialchars($businessHours); ?>" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:600; box-sizing:border-box;">
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Registered GSTIN Number</label>
                            <input type="text" id="contact_gstin" name="contact_gstin" value="<?php echo htmlspecialchars($gstin); ?>" style="width:100%; height:38px; border:1.5px solid #EAE5D9; border-radius:8px; padding:0 12px; font-weight:700; box-sizing:border-box;">
                        </div>
                    </div>

                    <div style="margin-top:20px; display:flex; justify-content:flex-end; gap:10px;">
                        <a href="/admin/cms/" class="dt-btn dt-btn-pale" style="text-decoration:none;">Cancel</a>
                        <button type="submit" id="btnSaveContact" class="dt-btn dt-btn-gold" style="display:inline-flex; align-items:center; gap:6px;">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#111827" stroke-width="2.8"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            <span>Save Contact Settings</span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script>
function showToastSafe(m, type) {
    if (typeof window.showToast === "function") {
        window.showToast(m, type);
    } else {
        console.warn(m);
    }
}

async function saveContactSettings(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSaveContact');
    const originalContent = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<span>Saving Settings...</span>';

    const payload = {
        contact_showroom_address: document.getElementById('contact_showroom_address').value.trim(),
        contact_whatsapp_hotline: document.getElementById('contact_whatsapp_hotline').value.trim(),
        contact_wholesale_line: document.getElementById('contact_wholesale_line').value.trim(),
        contact_support_email: document.getElementById('contact_support_email').value.trim(),
        contact_wholesale_email: document.getElementById('contact_wholesale_email').value.trim(),
        contact_business_hours: document.getElementById('contact_business_hours').value.trim(),
        contact_gstin: document.getElementById('contact_gstin').value.trim()
    };

    try {
        const res = await fetch('/api/settings.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ settings: payload })
        });
        const data = await res.json();
        if (data.success) {
            showToastSafe(data.message || 'Contact settings successfully saved.');
        } else {
            showToastSafe(data.message || 'Failed to save settings.');
        }
    } catch (err) {
        showToastSafe('Network error while saving contact settings.');
    } finally {
        btn.disabled = false;
        btn.innerHTML = originalContent;
    }
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
