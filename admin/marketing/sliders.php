<?php
/**
 * admin/marketing/sliders.php — DT Brand's Dedicated Hero Slider Studio & Carousel Simulator
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

$page_title = "Hero Slider Studio & Simulator";
$active_nav = "marketing";
$active_subnav = "sliders";

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = trim((string)($_POST['action'] ?? ''));

    if ($action === 'create_slide') {
        $data = [
            'title' => trim((string)($_POST['title'] ?? '')),
            'subtitle' => trim((string)($_POST['subtitle'] ?? '')),
            'placement' => 'hero',
            'image_url' => trim((string)($_POST['image_url'] ?? '')),
            'image_mobile_url' => trim((string)($_POST['image_mobile_url'] ?? '')),
            'link_url' => trim((string)($_POST['link_url'] ?? '')),
            'button_text' => trim((string)($_POST['button_text'] ?? 'Explore Now')),
            'badge_text' => trim((string)($_POST['badge_text'] ?? '')),
            'bg_color' => trim((string)($_POST['bg_color'] ?? '#181512')),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'status' => 'active',
        ];

        if ($data['title'] === '' || $data['image_url'] === '') {
            $error = "Slide headline and image URL are required.";
        } else {
            $newId = ContentManager::createBanner($data);
            if ($newId > 0) {
                $message = "Hero slide '{$data['title']}' added to rotation!";
            } else {
                $error = "Failed to add hero slide.";
            }
        }
    } elseif ($action === 'reorder_slide') {
        $id = (int)($_POST['id'] ?? 0);
        $newOrder = (int)($_POST['display_order'] ?? 0);
        if ($id > 0) {
            ContentManager::updateBanner($id, ['display_order' => $newOrder]);
            $message = "Slide #{$id} display order set to {$newOrder}.";
        }
    } elseif ($action === 'toggle_status') {
        $id = (int)($_POST['id'] ?? 0);
        $current = trim((string)($_POST['current_status'] ?? 'active'));
        $newStatus = ($current === 'active') ? 'inactive' : 'active';
        if ($id > 0) {
            ContentManager::updateBanner($id, ['status' => $newStatus]);
            $message = "Slide #{$id} status updated to {$newStatus}.";
        }
    } elseif ($action === 'delete_slide') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            ContentManager::deleteBanner($id);
            $message = "Slide #{$id} deleted.";
        }
    }
}

$heroSlides = ContentManager::getHeroSliders(false);
$activeSlides = array_filter($heroSlides, fn($s) => ($s['status'] ?? 'active') === 'active');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hero Slider Studio &amp; Simulator — DT Brand's Admin</title>
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

        .dt-slider-simulator-wrap {
            background: #181512;
            border-radius: 14px;
            padding: 20px;
            border: 1.5px solid var(--dt-gold);
            box-shadow: 0 10px 30px rgba(0,0,0,0.35);
            margin-bottom: 24px;
        }
        .dt-sim-viewport {
            position: relative;
            height: 320px;
            border-radius: 10px;
            overflow: hidden;
            background: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        .dt-sim-viewport.mobile-view {
            max-width: 380px;
            height: 480px;
            margin: 0 auto;
            border: 4px solid #334155;
        }
        .dt-sim-slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 0.6s ease-in-out;
            display: flex;
            align-items: flex-end;
            padding: 30px;
            box-sizing: border-box;
        }
        .dt-sim-slide.active {
            opacity: 1;
            z-index: 2;
        }
        .dt-sim-slide::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.85) 100%);
        }
        .dt-sim-content {
            position: relative;
            z-index: 3;
            color: #FFFFFF;
            max-width: 580px;
        }
        .dt-sim-badge {
            background: var(--dt-gold);
            color: #111827;
            font-weight: 800;
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 4px;
            display: inline-block;
            margin-bottom: 8px;
            letter-spacing: 0.04em;
        }
        .dt-sim-title {
            font-size: 1.7rem;
            font-weight: 900;
            margin: 0 0 6px 0;
            line-height: 1.2;
            text-shadow: 0 2px 8px rgba(0,0,0,0.7);
        }
        .dt-sim-sub {
            font-size: 0.95rem;
            color: #E2E8F0;
            margin: 0 0 14px 0;
        }
        .dt-sim-btn {
            background: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%);
            border: 1px solid #8A681F;
            color: #111827;
            font-weight: 800;
            padding: 8px 18px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            text-decoration: none;
        }
        .dt-sim-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.5);
            border: 1px solid rgba(212,175,55,0.4);
            color: #FFFFFF;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.2s ease;
        }
        .dt-sim-nav:hover {
            background: rgba(212,175,55,0.8);
            color: #111827;
        }
        .dt-sim-nav.prev { left: 14px; }
        .dt-sim-nav.next { right: 14px; }

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
                        <span>Hero Slider Studio &amp; Simulator</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?php echo count($activeSlides); ?> Live Slides</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Fine-tune hero slide transitions, auto-rotation pacing, reorder sequences, and test responsive viewports.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px; flex-wrap:wrap;">
                    <button type="button" class="dt-btn-pale" onclick="toggleViewportMode()" id="btnToggleViewport">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg>
                        <span id="txtViewport">Switch to Mobile View</span>
                    </button>
                    <a href="/admin/marketing/banners.php" class="dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        <span>All Banners</span>
                    </a>
                    <button type="button" class="dt-btn-gold" onclick="openAddSlideModal()">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add Hero Slide</span>
                    </button>
                </div>
            </div>

            <!-- Interactive Carousel Simulator -->
            <div class="dt-slider-simulator-wrap">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; color:#FAF5E8;">
                    <div style="font-weight:800; font-size:13px; display:flex; align-items:center; gap:6px;">
                        <span style="width:8px; height:8px; border-radius:50%; background:#10B981; display:inline-block;"></span>
                        <span>LIVE STOREFRONT HERO CAROUSEL SIMULATOR</span>
                    </div>
                    <div style="font-size:11.5px; color:#A1A1AA;">Auto-rotating every 5.0s &bull; Click arrows to inspect slides</div>
                </div>

                <div class="dt-sim-viewport" id="simViewport">
                    <button type="button" class="dt-sim-nav prev" onclick="prevSimSlide()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                    </button>
                    <button type="button" class="dt-sim-nav next" onclick="nextSimSlide()">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </button>

                    <?php if (empty($heroSlides)): ?>
                        <div style="color:#FFF; text-align:center;">No hero slides active. Click "+ Add Hero Slide" below.</div>
                    <?php else: ?>
                        <?php $sIdx = 0; foreach ($heroSlides as $slide): ?>
                            <?php
                                $isActive = ($sIdx === 0) ? 'active' : '';
                                $sImg = htmlspecialchars($slide['image_url'] ?? '/assets/images/hero-banner.png');
                                $sTitle = htmlspecialchars($slide['title'] ?? '');
                                $sSub = htmlspecialchars($slide['subtitle'] ?? '');
                                $sBadge = htmlspecialchars($slide['badge_text'] ?? 'PREMIUM COLLECTION');
                                $sBtn = htmlspecialchars($slide['button_text'] ?? 'Shop Now');
                            ?>
                            <div class="dt-sim-slide <?php echo $isActive; ?>" id="simSlide-<?php echo $sIdx; ?>" style="background-image: url('<?php echo $sImg; ?>');">
                                <div class="dt-sim-content">
                                    <?php if ($sBadge !== ''): ?>
                                        <span class="dt-sim-badge"><?php echo $sBadge; ?></span>
                                    <?php endif; ?>
                                    <h2 class="dt-sim-title"><?php echo $sTitle; ?></h2>
                                    <?php if ($sSub !== ''): ?>
                                        <p class="dt-sim-sub"><?php echo $sSub; ?></p>
                                    <?php endif; ?>
                                    <a href="#" class="dt-sim-btn" onclick="return false;"><?php echo $sBtn; ?> &rarr;</a>
                                </div>
                            </div>
                            <?php $sIdx++; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Slide Sequence & Management Table -->
            <div class="adm-card">
                <div class="adm-card-head" style="display:flex; justify-content:space-between; align-items:center; padding:14px 18px; border-bottom:1px solid #EAE5D9;">
                    <h3 class="adm-card-title" style="margin:0; font-size:1.1rem; font-weight:800; color:#181512; display:flex; align-items:center; gap:8px;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                        <span>Hero Slide Rotation Queue</span>
                    </h3>
                    <span class="adm-badge gold" style="font-size:11px;"><?php echo count($heroSlides); ?> Slides in Database</span>
                </div>
                <div class="adm-table-responsive" style="overflow-x:auto;">
                    <table class="adm-table" style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr style="background:#F8FAFC; border-bottom:1px solid #E2E8F0; text-align:left; font-size:11.5px; color:#475569; text-transform:uppercase;">
                                <th style="padding:10px 14px; width:60px;">Order</th>
                                <th style="padding:10px 14px;">Preview</th>
                                <th style="padding:10px 14px;">Headline &amp; Subtitle</th>
                                <th style="padding:10px 14px;">Target URL</th>
                                <th style="padding:10px 14px;">Status</th>
                                <th style="padding:10px 14px; text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($heroSlides)): ?>
                                <tr>
                                    <td colspan="6" style="padding:24px; text-align:center; color:#64748B;">No slides configured.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($heroSlides as $slide): ?>
                                    <?php
                                        $sId = (int)($slide['id'] ?? 0);
                                        $sOrder = (int)($slide['display_order'] ?? 0);
                                        $sTitle = htmlspecialchars($slide['title'] ?? '');
                                        $sSub = htmlspecialchars($slide['subtitle'] ?? '');
                                        $sImg = htmlspecialchars($slide['image_url'] ?? '');
                                        $sLink = htmlspecialchars($slide['link_url'] ?? '/shop');
                                        $sStatus = $slide['status'] ?? 'active';
                                    ?>
                                    <tr style="border-bottom:1px solid #F1F5F9; font-size:12.5px;">
                                        <td style="padding:10px 14px; font-weight:800; color:#8A681F;">
                                            <form method="POST" style="display:flex; align-items:center; gap:4px; margin:0;">
                                                <input type="hidden" name="action" value="reorder_slide">
                                                <input type="hidden" name="id" value="<?php echo $sId; ?>">
                                                <input type="number" name="display_order" value="<?php echo $sOrder; ?>" min="0" max="99" style="width:48px; height:28px; text-align:center; border:1px solid #CBD5E1; border-radius:4px; font-weight:800;" onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td style="padding:10px 14px;">
                                            <div style="width:70px; height:42px; border-radius:6px; background-size:cover; background-position:center; border:1px solid #CBD5E1; background-image:url('<?php echo $sImg; ?>');"></div>
                                        </td>
                                        <td style="padding:10px 14px;">
                                            <div style="font-weight:700; color:#1E293B;"><?php echo $sTitle; ?></div>
                                            <div style="font-size:11px; color:#64748B;"><?php echo $sSub; ?></div>
                                        </td>
                                        <td style="padding:10px 14px;">
                                            <code style="font-size:11px; background:#F8FAFC; padding:2px 6px; border-radius:4px;"><?php echo $sLink; ?></code>
                                        </td>
                                        <td style="padding:10px 14px;">
                                            <?php if ($sStatus === 'active'): ?>
                                                <span class="adm-badge success" style="font-size:10.5px;">Active</span>
                                            <?php else: ?>
                                                <span class="adm-badge" style="background:#F1F5F9; color:#64748B; font-size:10.5px;">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="padding:10px 14px; text-align:right;">
                                            <div style="display:inline-flex; gap:6px;">
                                                <form method="POST" style="margin:0;">
                                                    <input type="hidden" name="action" value="toggle_status">
                                                    <input type="hidden" name="id" value="<?php echo $sId; ?>">
                                                    <input type="hidden" name="current_status" value="<?php echo $sStatus; ?>">
                                                    <button type="submit" class="dt-btn-pale" style="font-size:11px; padding:4px 8px;">
                                                        <?php echo $sStatus === 'active' ? 'Disable' : 'Enable'; ?>
                                                    </button>
                                                </form>
                                                <form method="POST" style="margin:0;" onsubmit="return confirm('Delete this hero slide?');">
                                                    <input type="hidden" name="action" value="delete_slide">
                                                    <input type="hidden" name="id" value="<?php echo $sId; ?>">
                                                    <button type="submit" class="dt-btn-danger" style="font-size:11px; padding:4px 8px;">Delete</button>
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

<!-- Modal for New Hero Slide -->
<div id="slideModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:99999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div style="background:#FFFFFF; border-radius:12px; width:95%; max-width:520px; padding:22px; border:1.5px solid var(--dt-gold);">
        <h3 style="margin:0 0 14px 0; font-size:1.15rem; font-weight:800; color:#181512; display:flex; align-items:center; gap:8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
            <span>Add Hero Slide</span>
        </h3>
        <form method="POST">
            <input type="hidden" name="action" value="create_slide">
            <div style="display:flex; flex-direction:column; gap:12px;">
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Headline *</label>
                    <input type="text" name="title" required placeholder="e.g. Royal Pure Silk Paithani 2026" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Subtitle</label>
                    <input type="text" name="subtitle" placeholder="e.g. Direct Loom Wholesale Sourcing" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Desktop Image URL *</label>
                    <input type="text" name="image_url" required value="/assets/images/hero-banner.png" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Mobile Image URL</label>
                    <input type="text" name="image_mobile_url" placeholder="/assets/images/hero-banner-mobile.png" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Click Target</label>
                        <input type="text" name="link_url" value="/shop" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Display Order</label>
                        <input type="number" name="display_order" value="1" min="0" max="99" style="width:100%; height:36px; border:1.5px solid #CBD5E1; border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                    </div>
                </div>
            </div>
            <div style="margin-top:16px; display:flex; justify-content:flex-end; gap:8px;">
                <button type="button" class="dt-btn-pale" onclick="closeAddSlideModal()">Cancel</button>
                <button type="submit" class="dt-btn-gold">Add Slide</button>
            </div>
        </form>
    </div>
</div>

<script>
let curSlide = 0;
const totalSlides = <?php echo count($heroSlides); ?>;
let autoPlayInterval = null;

function showSlide(idx) {
    if (totalSlides <= 0) return;
    for (let i = 0; i < totalSlides; i++) {
        const el = document.getElementById('simSlide-' + i);
        if (el) el.classList.remove('active');
    }
    curSlide = (idx + totalSlides) % totalSlides;
    const activeEl = document.getElementById('simSlide-' + curSlide);
    if (activeEl) activeEl.classList.add('active');
}

function nextSimSlide() {
    showSlide(curSlide + 1);
}

function prevSimSlide() {
    showSlide(curSlide - 1);
}

function startAutoPlay() {
    if (autoPlayInterval) clearInterval(autoPlayInterval);
    autoPlayInterval = setInterval(nextSimSlide, 5000);
}

function toggleViewportMode() {
    const vp = document.getElementById('simViewport');
    const txt = document.getElementById('txtViewport');
    if (vp.classList.contains('mobile-view')) {
        vp.classList.remove('mobile-view');
        txt.textContent = 'Switch to Mobile View';
    } else {
        vp.classList.add('mobile-view');
        txt.textContent = 'Switch to Desktop View';
    }
}

function openAddSlideModal() {
    document.getElementById('slideModal').style.display = 'flex';
}
function closeAddSlideModal() {
    document.getElementById('slideModal').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', function() {
    startAutoPlay();
});
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
