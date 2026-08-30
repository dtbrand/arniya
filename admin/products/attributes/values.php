<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * values.php — DT Brand's Attribute Terms & Swatches Studio
 * DT Brand's & Jai Hanuman Tex
 *
 * The previous revision rendered eight invented color terms ("Crimson Red,
 * 142 SKUs") regardless of which attribute was opened, and Add/Remove only
 * mutated the DOM. It now reads the attribute's values_json from the live
 * product_attributes table and persists Add/Remove through
 * /api/attributes.php actions add_term / remove_term (admin-guarded).
 */
require_once __DIR__ . '/../../../src/Database.php';

use DTBrand\Database;

$page_title = "Manage Attribute Terms";
$active_nav = "products";
$active_subnav = "attributes";

$attr_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$attr = null;
$terms = [];
$pdoTerms = Database::getConnection();
if ($pdoTerms !== null && !Database::isMockMode() && $attr_id > 0) {
    try {
        $attr = Database::fetchOne('SELECT id, name, type, values_json FROM product_attributes WHERE id = ? LIMIT 1', [$attr_id]);
        if ($attr) {
            $decoded = json_decode((string)($attr['values_json'] ?? '[]'), true);
            if (is_array($decoded)) {
                $terms = $decoded;
            }
        }
    } catch (\Throwable $e) {
        $attr = null;
    }
}

if ($attr === null) {
    header('Location: /admin/products/attributes/');
    exit;
}
$attr_name = (string)$attr['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configure <?= htmlspecialchars($attr_name) ?> ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
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
    .dt-kpi-card:hover {
        border-color: #D4AF37;
        box-shadow: 0 4px 12px rgba(212,175,55,0.15);
    }
    .dt-swatch-box {
        background: #fff;
        border: 1px solid #c3c4c7;
        border-radius: 6px;
        padding: 12px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s ease;
    }
    .dt-swatch-box:hover {
        border-color: #D4AF37;
        box-shadow: 0 4px 12px rgba(212,175,55,0.12);
    }
    .dt-swatch-preview {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 1.5px solid rgba(0,0,0,0.15);
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        flex-shrink: 0;
    }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 16px 20px;">

            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;"><?= htmlspecialchars($attr_name) ?> Terms</h1>
                    <span class="adm-badge gold" id="termsCountBadge" style="font-weight:700; font-size:11px; padding:3px 8px;"><?= count($terms) ?> Saved Terms</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px;">
                    <a href="/admin/products/attributes/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Back to Attributes</span>
                    </a>
                    <button type="button" class="wp-button primary" onclick="openAddTermModal()" style="background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F; padding:0 14px; height:32px; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add New Term</span>
                    </button>
                </div>
            </div>

            <div id="swatchesGrid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:12px; margin-bottom:20px;">
                <?php if (empty($terms)): ?>
                    <div style="grid-column:1/-1; padding:24px; text-align:center; color:#64748B; border:1.5px dashed #D4AF37; border-radius:8px;">
                        No terms saved yet for this attribute. Click <strong>Add New Term</strong> to create the first one.
                    </div>
                <?php else: ?>
                    <?php foreach ($terms as $t): ?>
                    <?php $hex = (string)($t['hex'] ?? ''); ?>
                    <div class="dt-swatch-box">
                        <div style="display:flex; align-items:center; gap:10px;">
                            <?php if ($hex !== ''): ?>
                                <div class="dt-swatch-preview" style="background:<?= htmlspecialchars($hex) ?>;"></div>
                            <?php else: ?>
                                <div class="dt-swatch-preview" style="background:#F1F5F9;"></div>
                            <?php endif; ?>
                            <div>
                                <strong style="font-size:13px; color:#181512; display:block;"><?= htmlspecialchars((string)($t['name'] ?? '—')) ?></strong>
                                <?php if ($hex !== ''): ?>
                                <code style="font-size:10.5px; color:#646970;"><?= htmlspecialchars($hex) ?></code>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div style="display:flex; align-items:center; gap:6px;">
                            <button type="button" style="background:none; border:none; color:#dc2626; cursor:pointer; font-size:16px; font-weight:700; padding:0 4px;" onclick="removeTerm('<?= htmlspecialchars(addslashes((string)($t['name'] ?? ''))) ?>', '<?= htmlspecialchars($hex) ?>')">&times;</button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- MODAL: ADD TERM -->
<div id="addTermModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:440px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37;">
        <div style="background:linear-gradient(135deg, #261C0E 0%, #3A2C12 40%, #18120A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <h3 style="margin:0; font-size:15px; font-weight:800; color:#FFFFFF;">Add Swatch / Term</h3>
            <button type="button" onclick="closeAddTermModal()" style="background:none; border:none; color:#FFE57F; font-size:22px; cursor:pointer;">&times;</button>
        </div>
        <div style="padding:18px 20px;">
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Term Name <span style="color:#b32d2e;">*</span></label>
                <input type="text" id="termName" placeholder="e.g. Royal Wine Purple" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Color Swatch (Hex Code, optional)</label>
                <div style="display:flex; gap:8px;">
                    <input type="color" id="termColorPicker" value="#6b21a8" style="width:40px; height:34px; padding:0; border:1px solid #c3c4c7; border-radius:4px; cursor:pointer;">
                    <input type="text" id="termHex" value="#6b21a8" style="flex:1; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;" oninput="document.getElementById('termColorPicker').value = this.value">
                </div>
            </div>
        </div>
        <div style="background:#f6f7f7; padding:12px 18px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:10px;">
            <button type="button" class="wp-button" onclick="closeAddTermModal()" style="height:32px; font-size:12px; font-weight:700; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Cancel</button>
            <button type="button" class="wp-button primary" onclick="submitTerm()" style="height:32px; font-size:12px; font-weight:800; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F;">+ Save Term</button>
        </div>
    </div>
</div>

<script>
document.getElementById('termColorPicker')?.addEventListener('input', function() {
    document.getElementById('termHex').value = this.value;
});

function openAddTermModal() {
    const m = document.getElementById('addTermModal');
    if (m) m.style.display = 'flex';
    document.getElementById('termName')?.focus();
}

function closeAddTermModal() {
    const m = document.getElementById('addTermModal');
    if (m) m.style.display = 'none';
}

function postTermAction(action, termName, hex) {
    const params = new URLSearchParams();
    params.append('action', action);
    params.append('id', <?= (int)$attr_id ?>);
    params.append('term_name', termName);
    params.append('hex', hex);
    return fetch('/api/attributes.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => {
            if (data && data.success === false) {
                if (typeof window.showToast === 'function') window.showToast('⚠️ ' + (data.message || 'Action failed'));
                return false;
            }
            window.location.reload();
            return true;
        })
        .catch(() => {
            if (typeof window.showToast === 'function') window.showToast('⚠️ Could not reach the server');
            return false;
        });
}

function submitTerm() {
    const nameInput = document.getElementById('termName');
    const name = nameInput?.value.trim();
    if (!name) {
        if (typeof window.showToast === 'function') window.showToast('⚠️ Please enter a term name');
        return;
    }
    const hex = document.getElementById('termHex')?.value.trim() || '';
    postTermAction('add_term', name, hex);
}

function removeTerm(name, hex) {
    if (!confirm('Remove term "' + name + '" from this attribute?')) return;
    postTermAction('remove_term', name, hex);
}
</script>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>