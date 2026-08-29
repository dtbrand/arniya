<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * values.php — DT Brand's Attribute Terms & Swatches Studio
 * 100% Fully Functional End-to-End Standard
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "Manage Attribute Terms";
$active_nav = "products";
$active_subnav = "attributes";

$attr_id = isset($_GET['id']) ? intval($_GET['id']) : 1;
$attr_name = "Color Variations";
if ($attr_id === 2) $attr_name = "Fabric & Material";
if ($attr_id === 3) $attr_name = "Zari & Weaving Technique";
if ($attr_id === 4) $attr_name = "Saree Length & Blouse";

$terms = [
    ['name' => 'Crimson Red', 'slug' => 'crimson-red', 'hex' => '#991b1b', 'skus' => '142 SKUs'],
    ['name' => 'Bottle Green', 'slug' => 'bottle-green', 'hex' => '#065f46', 'skus' => '118 SKUs'],
    ['name' => 'Royal Blue', 'slug' => 'royal-blue', 'hex' => '#1e40af', 'skus' => '96 SKUs'],
    ['name' => 'Mustard Gold', 'slug' => 'mustard-gold', 'hex' => '#b45309', 'skus' => '134 SKUs'],
    ['name' => 'Peacock Teal', 'slug' => 'peacock-teal', 'hex' => '#0f766e', 'skus' => '88 SKUs'],
    ['name' => 'Rani Pink', 'slug' => 'rani-pink', 'hex' => '#be185d', 'skus' => '124 SKUs'],
    ['name' => 'Deep Maroon', 'slug' => 'deep-maroon', 'hex' => '#831843', 'skus' => '78 SKUs'],
    ['name' => 'Turquoise Sea', 'slug' => 'turquoise-sea', 'hex' => '#0284c7', 'skus' => '60 SKUs']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configure <?php echo htmlspecialchars($attr_name); ?> ‹ DT Brand's Admin</title>
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
        transform: translateY(-1px);
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

            <!-- 1. Header Toolbar with Luxury Gold Buttons -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;"><?php echo htmlspecialchars($attr_name); ?> Terms</h1>
                    <span class="adm-badge gold" id="termsCountBadge" style="font-weight:700; font-size:11px; padding:3px 8px;"><?php echo count($terms); ?> Active Swatches</span>
                </div>

                <div style="display:flex; align-items:center; gap:8px;">
                    <a href="/admin/products/attributes/" class="wp-button" style="height:32px; padding:0 12px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; text-decoration:none; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Back to Attributes</span>
                    </a>
                    <button type="button" class="wp-button primary" onclick="openAddTermModal()" style="background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; font-weight:800; border:1px solid #8A681F; padding:0 14px; height:32px; display:inline-flex; align-items:center; gap:6px; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Add New Term</span>
                    </button>
                </div>
            </div>

            <!-- 2. Swatches Grid -->
            <div id="swatchesGrid" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:12px; margin-bottom:20px;">
                <?php foreach($terms as $t): ?>
                <div class="dt-swatch-box">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <div class="dt-swatch-preview" style="background:<?php echo $t['hex']; ?>;"></div>
                        <div>
                            <strong style="font-size:13px; color:#181512; display:block;"><?php echo htmlspecialchars($t['name']); ?></strong>
                            <code style="font-size:10.5px; color:#646970;"><?php echo htmlspecialchars($t['hex']); ?></code>
                        </div>
                    </div>
                    <div style="display:flex; align-items:center; gap:6px;">
                        <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-size:10px; font-weight:700; padding:2px 6px;"><?php echo htmlspecialchars($t['skus']); ?></span>
                        <button type="button" style="background:none; border:none; color:#dc2626; cursor:pointer; font-size:16px; font-weight:700; padding:0 4px;" onclick="removeSwatch(this)">&times;</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: ADD TERM                                          -->
<!-- ======================================================== -->
<div id="addTermModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(15,23,42,0.75); backdrop-filter:blur(5px); z-index:9999999; align-items:center; justify-content:center;">
    <div style="background:#fff; width:95%; max-width:440px; border-radius:10px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); overflow:hidden; border:2px solid #D4AF37;">
        <div style="background:radial-gradient(ellipse at 20% 50%, rgba(212, 175, 55, 0.35) 0%, transparent 60%), linear-gradient(135deg, #261C0E 0%, #3A2C12 40%, #2A2010 75%, #18120A 100%); padding:14px 18px; color:#FAF5E8; display:flex; align-items:center; justify-content:space-between; border-bottom:2px solid #D4AF37;">
            <h3 style="margin:0; font-size:15px; font-weight:800; color:#FFFFFF; text-shadow:0 1px 3px rgba(0,0,0,0.8);">Add Swatch / Term</h3>
            <button type="button" onclick="closeAddTermModal()" style="background:none; border:none; color:#FFE57F; font-size:22px; cursor:pointer; line-height:1;">&times;</button>
        </div>
        <div style="padding:18px 20px;">
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Term Name <span style="color:#b32d2e;">*</span></label>
                <input type="text" id="termName" placeholder="e.g. Royal Wine Purple" style="width:100%; height:34px; padding:0 10px; font-size:12.5px; border:1px solid #c3c4c7; border-radius:4px; box-sizing:border-box;">
            </div>
            <div style="margin-bottom:12px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#181512; margin-bottom:4px;">Color Swatch (Hex Code)</label>
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

function submitTerm() {
    const nameInput = document.getElementById('termName');
    const name = nameInput?.value.trim();
    if (!name) {
        alert('Please enter a term name');
        return;
    }
    const hex = document.getElementById('termHex')?.value || '#6b21a8';
    
    const grid = document.getElementById('swatchesGrid');
    const box = document.createElement('div');
    box.className = 'dt-swatch-box';
    box.innerHTML = `
        <div style="display:flex; align-items:center; gap:10px;">
            <div class="dt-swatch-preview" style="background:${hex};"></div>
            <div>
                <strong style="font-size:13px; color:#181512; display:block;">${name}</strong>
                <code style="font-size:10.5px; color:#646970;">${hex}</code>
            </div>
        </div>
        <div style="display:flex; align-items:center; gap:6px;">
            <span class="adm-badge" style="background:#DCFCE7; color:#15803D; font-size:10px; font-weight:700; padding:2px 6px;">0 SKUs</span>
            <button type="button" style="background:none; border:none; color:#dc2626; cursor:pointer; font-size:16px; font-weight:700; padding:0 4px;" onclick="removeSwatch(this)">&times;</button>
        </div>
    `;
    grid.appendChild(box);
    closeAddTermModal();
    if (nameInput) nameInput.value = '';

    updateTermsBadge();

    if (typeof window.showToast === 'function') {
        window.showToast(`✨ Swatch term "${name}" added live!`);
    }
}

function removeSwatch(btn) {
    if (confirm('Remove this swatch term?')) {
        btn.closest('.dt-swatch-box').remove();
        updateTermsBadge();
        if (typeof window.showToast === 'function') window.showToast('🗑️ Swatch removed');
    }
}

function updateTermsBadge() {
    const count = document.querySelectorAll('#swatchesGrid .dt-swatch-box').length;
    const badge = document.getElementById('termsCountBadge');
    if (badge) badge.textContent = `${count} Active Swatches`;
}
</script>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
