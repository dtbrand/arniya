<?php
/**
 * admin/marketing/seo.php — DT Brand's Search Engine Optimization & OpenGraph Studio
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

$page_title = "SEO & OpenGraph Studio";
$active_nav = "marketing";
$active_subnav = "seo";

$routes = [
    '/' => 'Homepage (/)',
    '/shop' => 'Saree Catalog (/shop)',
    '/wholesale' => 'B2B Wholesale Portal (/wholesale)',
    '/reseller' => 'VIP Reseller Hub (/reseller)'
];

$currentRoute = trim((string)($_GET['route'] ?? '/'));
if (!array_key_exists($currentRoute, $routes)) {
    $currentRoute = '/';
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = trim((string)($_POST['action'] ?? ''));

    if ($action === 'save_seo') {
        $route = trim((string)($_POST['page_route'] ?? '/'));
        $data = [
            'meta_title' => trim((string)($_POST['meta_title'] ?? '')),
            'meta_description' => trim((string)($_POST['meta_description'] ?? '')),
            'meta_keywords' => trim((string)($_POST['meta_keywords'] ?? '')),
            'canonical_url' => trim((string)($_POST['canonical_url'] ?? '')),
            'og_title' => trim((string)($_POST['og_title'] ?? '')),
            'og_description' => trim((string)($_POST['og_description'] ?? '')),
            'og_image_url' => trim((string)($_POST['og_image_url'] ?? '')),
        ];

        ContentManager::setSeoMetadata($route, $data);
        $message = "SEO metadata for '{$route}' saved successfully!";
    }
}

$seo = ContentManager::getSeoMetadata($currentRoute);
$metaTitle = $seo['meta_title'] ?? 'DT Brand\'s & Jai Hanuman Tex — Direct Loom Pure Silk Sarees Wholesale';
$metaDesc = $seo['meta_description'] ?? 'Wholesale manufacturer & direct loom exporter of authentic Paithani, Banarasi, Kanjivaram and South Silk sarees. Surat, India.';
$metaKeywords = $seo['meta_keywords'] ?? 'silk sarees, wholesale sarees surat, paithani saree, banarasi silk, direct loom';
$canonicalUrl = $seo['canonical_url'] ?? 'https://jaihanumantex.in' . $currentRoute;
$ogTitle = $seo['og_title'] ?? $metaTitle;
$ogDesc = $seo['og_description'] ?? $metaDesc;
$ogImage = $seo['og_image_url'] ?? '/assets/images/hero-banner.png';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEO &amp; OpenGraph Studio — DT Brand's Admin</title>
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

        .dt-route-pills {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .dt-route-pill {
            padding: 8px 16px;
            border-radius: 24px;
            font-size: 12.5px;
            font-weight: 700;
            background: #FFFFFF;
            border: 1px solid var(--dt-border);
            color: #475569;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .dt-route-pill.active {
            background: #FAF5E8;
            border-color: var(--dt-gold);
            color: var(--dt-gold-dark);
        }

        .dt-serp-preview {
            background: #FFFFFF;
            border: 1.5px solid var(--dt-border);
            border-radius: 12px;
            padding: 18px 22px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
            margin-bottom: 24px;
            font-family: Arial, sans-serif;
        }
        .dt-serp-cite {
            font-size: 12px;
            color: #202124;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 4px;
        }
        .dt-serp-title {
            font-size: 19px;
            color: #1a0dab;
            line-height: 1.3;
            text-decoration: none;
            cursor: pointer;
            margin-bottom: 4px;
            display: inline-block;
            font-weight: 400;
        }
        .dt-serp-title:hover {
            text-decoration: underline;
        }
        .dt-serp-desc {
            font-size: 13.5px;
            color: #4d5156;
            line-height: 1.5;
        }

        .dt-btn-gold {
            background: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%);
            border: 1px solid #8A681F;
            color: #111827;
            font-weight: 800;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 12.5px;
            cursor: pointer;
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.4), 0 2px 8px rgba(184,134,11,0.35);
            display: inline-flex;
            align-items: center;
            gap: 6px;
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
                        <span>SEO &amp; OpenGraph Studio</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?php echo htmlspecialchars($currentRoute); ?></span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Fine-tune metadata, search engine snippets, and social sharing OpenGraph previews.</p>
                </div>
            </div>

            <!-- Route Selection Pills -->
            <div class="dt-route-pills">
                <?php foreach ($routes as $rUri => $rLabel): ?>
                    <a href="/admin/marketing/seo.php?route=<?php echo urlencode($rUri); ?>" class="dt-route-pill <?php echo $currentRoute === $rUri ? 'active' : ''; ?>">
                        <?php echo $rLabel; ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Live Google SERP Simulator -->
            <div class="dt-serp-preview">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px; border-bottom:1px solid #F1F5F9; padding-bottom:8px;">
                    <div style="font-size:11px; font-weight:800; color:#64748B; text-transform:uppercase; letter-spacing:0.04em;">Google Search Engine Simulator</div>
                    <div style="font-size:11px; color:#10B981; font-weight:700;">Live Preview</div>
                </div>
                <div class="dt-serp-cite">
                    <span>https://jaihanumantex.in</span>
                    <span>&rsaquo;</span>
                    <span><?php echo ltrim($currentRoute, '/') ?: 'home'; ?></span>
                </div>
                <a href="#" class="dt-serp-title" id="serpPreviewTitle" onclick="return false;">
                    <?php echo htmlspecialchars($metaTitle); ?>
                </a>
                <div class="dt-serp-desc" id="serpPreviewDesc">
                    <?php echo htmlspecialchars($metaDesc); ?>
                </div>
            </div>

            <!-- SEO Editor Form -->
            <div class="adm-card" style="padding:22px;">
                <form method="POST">
                    <input type="hidden" name="action" value="save_seo">
                    <input type="hidden" name="page_route" value="<?php echo htmlspecialchars($currentRoute); ?>">

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                        <div style="grid-column: 1 / -1;">
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:flex; justify-content:space-between; margin-bottom:4px;">
                                <span>Meta Title Tag *</span>
                                <span id="titleCount" style="color:#64748B; font-weight:500;">0 / 60 chars</span>
                            </label>
                            <input type="text" name="meta_title" id="inpMetaTitle" value="<?php echo htmlspecialchars($metaTitle); ?>" required style="width:100%; height:38px; border:1.5px solid var(--dt-border); border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                        </div>

                        <div style="grid-column: 1 / -1;">
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:flex; justify-content:space-between; margin-bottom:4px;">
                                <span>Meta Description *</span>
                                <span id="descCount" style="color:#64748B; font-weight:500;">0 / 160 chars</span>
                            </label>
                            <textarea name="meta_description" id="inpMetaDesc" rows="3" required style="width:100%; border:1.5px solid var(--dt-border); border-radius:6px; padding:8px 10px; font-weight:600; box-sizing:border-box;"><?php echo htmlspecialchars($metaDesc); ?></textarea>
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Meta Keywords</label>
                            <input type="text" name="meta_keywords" value="<?php echo htmlspecialchars($metaKeywords); ?>" placeholder="comma separated keywords" style="width:100%; height:38px; border:1.5px solid var(--dt-border); border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Canonical URL</label>
                            <input type="url" name="canonical_url" value="<?php echo htmlspecialchars($canonicalUrl); ?>" style="width:100%; height:38px; border:1.5px solid var(--dt-border); border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">OpenGraph Social Title</label>
                            <input type="text" name="og_title" value="<?php echo htmlspecialchars($ogTitle); ?>" style="width:100%; height:38px; border:1.5px solid var(--dt-border); border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                        </div>

                        <div>
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">OpenGraph Social Image URL</label>
                            <input type="text" name="og_image_url" value="<?php echo htmlspecialchars($ogImage); ?>" style="width:100%; height:38px; border:1.5px solid var(--dt-border); border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                        </div>

                        <div style="grid-column: 1 / -1;">
                            <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">OpenGraph Social Description</label>
                            <textarea name="og_description" rows="2" style="width:100%; border:1.5px solid var(--dt-border); border-radius:6px; padding:8px 10px; font-weight:600; box-sizing:border-box;"><?php echo htmlspecialchars($ogDesc); ?></textarea>
                        </div>
                    </div>

                    <div style="margin-top:20px; display:flex; justify-content:flex-end;">
                        <button type="submit" class="dt-btn-gold">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.8"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                            <span>Save SEO &amp; OpenGraph Settings</span>
                        </button>
                    </div>
                </form>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<script>
const titleInput = document.getElementById('inpMetaTitle');
const descInput = document.getElementById('inpMetaDesc');
const titlePreview = document.getElementById('serpPreviewTitle');
const descPreview = document.getElementById('serpPreviewDesc');
const titleCount = document.getElementById('titleCount');
const descCount = document.getElementById('descCount');

function updateCounters() {
    const tLen = titleInput.value.length;
    const dLen = descInput.value.length;
    titleCount.textContent = tLen + ' / 60 chars';
    descCount.textContent = dLen + ' / 160 chars';
    titleCount.style.color = tLen > 60 ? '#DC2626' : '#64748B';
    descCount.style.color = dLen > 160 ? '#DC2626' : '#64748B';
    titlePreview.textContent = titleInput.value || 'DT Brand\'s Direct Loom Silk Sarees';
    descPreview.textContent = descInput.value || 'Wholesale silk sarees manufacturer.';
}

titleInput.addEventListener('input', updateCounters);
descInput.addEventListener('input', updateCounters);
document.addEventListener('DOMContentLoaded', updateCounters);
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
