<?php
/**
 * admin/marketing/banners.php — DT Brand's Promotional Banners & Hero Sliders Studio
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

$page_title = "Promotional Banners & Hero Studio";
$active_nav = "marketing";
$active_subnav = "banners";

$message = '';
$error = '';

// Handle POST actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = trim((string)($_POST['action'] ?? ''));

    if ($action === 'create_banner') {
        $data = [
            'title' => trim((string)($_POST['title'] ?? '')),
            'subtitle' => trim((string)($_POST['subtitle'] ?? '')),
            'placement' => trim((string)($_POST['placement'] ?? 'hero')),
            'image_url' => trim((string)($_POST['image_url'] ?? '')),
            'image_mobile_url' => trim((string)($_POST['image_mobile_url'] ?? '')),
            'link_url' => trim((string)($_POST['link_url'] ?? '')),
            'button_text' => trim((string)($_POST['button_text'] ?? 'Explore Now')),
            'badge_text' => trim((string)($_POST['badge_text'] ?? '')),
            'bg_color' => trim((string)($_POST['bg_color'] ?? '#181512')),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'status' => trim((string)($_POST['status'] ?? 'active')),
        ];

        if ($data['title'] === '' || $data['image_url'] === '') {
            $error = "Banner title and image URL are required.";
        } else {
            $newId = ContentManager::createBanner($data);
            if ($newId > 0) {
                $message = "Banner '{$data['title']}' created successfully!";
            } else {
                $error = "Failed to create banner. Please try again.";
            }
        }
    } elseif ($action === 'update_banner') {
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'title' => trim((string)($_POST['title'] ?? '')),
            'subtitle' => trim((string)($_POST['subtitle'] ?? '')),
            'placement' => trim((string)($_POST['placement'] ?? 'hero')),
            'image_url' => trim((string)($_POST['image_url'] ?? '')),
            'image_mobile_url' => trim((string)($_POST['image_mobile_url'] ?? '')),
            'link_url' => trim((string)($_POST['link_url'] ?? '')),
            'button_text' => trim((string)($_POST['button_text'] ?? 'Explore Now')),
            'badge_text' => trim((string)($_POST['badge_text'] ?? '')),
            'bg_color' => trim((string)($_POST['bg_color'] ?? '#181512')),
            'display_order' => (int)($_POST['display_order'] ?? 0),
            'status' => trim((string)($_POST['status'] ?? 'active')),
        ];

        if ($id <= 0 || $data['title'] === '' || $data['image_url'] === '') {
            $error = "Valid banner ID, title, and image URL are required.";
        } else {
            $ok = ContentManager::updateBanner($id, $data);
            if ($ok) {
                $message = "Banner #{$id} updated successfully!";
            } else {
                $error = "Failed to update banner #{$id}.";
            }
        }
    } elseif ($action === 'delete_banner') {
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            $ok = ContentManager::deleteBanner($id);
            if ($ok) {
                $message = "Banner #{$id} removed successfully.";
            } else {
                $error = "Failed to delete banner #{$id}.";
            }
        }
    } elseif ($action === 'toggle_status') {
        $id = (int)($_POST['id'] ?? 0);
        $currentStatus = trim((string)($_POST['current_status'] ?? 'active'));
        $newStatus = ($currentStatus === 'active') ? 'inactive' : 'active';
        if ($id > 0) {
            ContentManager::updateBanner($id, ['status' => $newStatus]);
            $message = "Banner #{$id} status changed to {$newStatus}.";
        }
    }
}

// Fetch banners from ContentManager
$selectedPlacement = trim((string)($_GET['placement'] ?? ''));
$banners = ContentManager::getBanners(false, $selectedPlacement !== '' ? $selectedPlacement : null);

// Metric calculations
$allBanners = ContentManager::getBanners(false);
$totalBanners = count($allBanners);
$activeBanners = 0;
$heroBanners = 0;
$promoBanners = 0;

foreach ($allBanners as $b) {
    if (($b['status'] ?? 'active') === 'active') {
        $activeBanners++;
    }
    $p = $b['placement'] ?? 'hero';
    if ($p === 'hero') $heroBanners++;
    if ($p === 'promo_strip') $promoBanners++;
}

$rupeeSvg = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1.5px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotional Banners &amp; Sliders Studio — DT Brand's Admin</title>
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

        @property --dt-border-angle {
            syntax: "<angle>";
            inherits: false;
            initial-value: 0deg;
        }
        @keyframes dtBorderRotate {
            to { --dt-border-angle: 360deg; }
        }
        @keyframes dtGoldPlatinumGlow {
            0% { box-shadow: 0 0 8px rgba(212, 175, 55, 0.3), 0 0 16px rgba(226, 232, 240, 0.2); }
            100% { box-shadow: 0 0 16px rgba(212, 175, 55, 0.6), 0 0 24px rgba(255, 255, 255, 0.4); }
        }

        input:focus, select:focus, textarea:focus {
            outline: none !important;
            border: 2px solid transparent !important;
            background: linear-gradient(#FFFFFF, #FFFFFF) padding-box,
                        conic-gradient(from var(--dt-border-angle), #D4AF37 0deg, #FFFFFF 60deg, #E2E8F0 120deg, #D4AF37 180deg, #FFFFFF 240deg, #B8860B 300deg, #D4AF37 360deg) border-box !important;
            animation: dtBorderRotate 2s linear infinite, dtGoldPlatinumGlow 1.5s ease-in-out infinite alternate !important;
            color: #111827 !important;
        }

        .dt-kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 14px;
            margin-bottom: 20px;
        }
        .dt-kpi-card {
            background: #FFFFFF;
            border: 1.5px solid var(--dt-border);
            border-radius: 12px;
            padding: 16px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 6px rgba(0,0,0,0.03);
            transition: all 0.2s ease;
        }
        .dt-kpi-card:hover {
            border-color: var(--dt-gold);
            transform: translateY(-1.5px);
            box-shadow: 0 6px 16px rgba(184,134,11,0.1);
        }
        .dt-kpi-val {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--dt-obsidian);
            letter-spacing: -0.02em;
            line-height: 1.1;
        }
        .dt-kpi-lbl {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            margin-top: 4px;
        }
        .dt-kpi-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #FAF5E8;
            color: var(--dt-gold-dark);
            flex-shrink: 0;
        }

        .dt-banner-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 18px;
        }
        .dt-banner-card {
            border: 1.5px solid var(--dt-border);
            border-radius: 12px;
            overflow: hidden;
            background: #FFFFFF;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            transition: all 0.22s ease;
        }
        .dt-banner-card:hover {
            border-color: var(--dt-gold);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(184,134,11,0.12);
        }
        .dt-banner-preview {
            height: 160px;
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            align-items: flex-end;
            padding: 14px;
            background-color: #181512;
        }
        .dt-banner-preview::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0.15) 0%, rgba(0,0,0,0.75) 100%);
        }
        .dt-banner-preview-content {
            position: relative;
            z-index: 2;
            color: #FFFFFF;
            width: 100%;
        }
        .dt-banner-badge {
            display: inline-block;
            background: var(--dt-gold);
            color: #111827;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            padding: 2px 8px;
            border-radius: 4px;
            letter-spacing: 0.05em;
            margin-bottom: 4px;
        }
        .dt-banner-title {
            font-weight: 800;
            font-size: 15px;
            color: #FFFFFF;
            text-shadow: 0 1px 4px rgba(0,0,0,0.8);
            margin: 0;
            line-height: 1.25;
        }
        .dt-banner-sub {
            font-size: 11.5px;
            color: rgba(255,255,255,0.85);
            margin: 2px 0 0 0;
        }
        .dt-banner-meta {
            padding: 14px 16px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            flex: 1;
            justify-content: space-between;
        }
        .dt-banner-props {
            display: flex;
            flex-direction: column;
            gap: 5px;
            font-size: 12px;
            color: #475569;
        }
        .dt-prop-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dt-banner-actions {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            border-top: 1px solid #F1F5F9;
            padding-top: 10px;
            margin-top: 4px;
        }

        .dt-pill-nav {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }
        .dt-pill {
            padding: 6px 14px;
            border-radius: 30px;
            border: 1px solid var(--dt-border);
            background: #FFFFFF;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.15s ease;
        }
        .dt-pill.active, .dt-pill:hover {
            background: #FAF5E8;
            border-color: var(--dt-gold);
            color: var(--dt-gold-dark);
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
        .dt-btn-gold:hover {
            background: linear-gradient(135deg, #C59312 0%, #DFC04E 50%, #F0D77B 100%);
            transform: translateY(-1px);
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
        .dt-btn-pale:hover {
            background: #F5ECCE;
            color: #5A4210;
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
            padding: 6px 10px;
            font-size: 12px;
            cursor: pointer;
        }
        .dt-btn-danger:hover {
            background: #FEE2E2;
        }

        .dt-modal-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            backdrop-filter: blur(4px);
            z-index: 99999;
            align-items: center;
            justify-content: center;
        }
        .dt-modal-card {
            background: #FFFFFF;
            border-radius: 12px;
            width: 95%;
            max-width: 580px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 22px;
            border: 1.5px solid var(--dt-gold);
            box-shadow: 0 16px 40px rgba(0,0,0,0.25);
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <!-- Alert Notifications -->
            <?php if (!empty($message)): ?>
                <div style="background:#DCFCE7; border:1px solid #86EFAC; color:#15803D; padding:10px 14px; border-radius:8px; margin-bottom:14px; font-weight:700; font-size:13px; display:flex; align-items:center; gap:8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <span><?php echo htmlspecialchars($message); ?></span>
                </div>
            <?php endif; ?>
            <?php if (!empty($error)): ?>
                <div style="background:#FEF2F2; border:1px solid #FCA5A5; color:#DC2626; padding:10px 14px; border-radius:8px; margin-bottom:14px; font-weight:700; font-size:13px; display:flex; align-items:center; gap:8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php endif; ?>

            <!-- Page Header -->
            <div class="adm-page-head" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:16px;">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title" style="display:flex; align-items:center; gap:8px; margin:0; font-size:1.45rem; font-weight:800; color:#111827;">
                        <span>Promotional Banners &amp; Sliders</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?php echo $activeBanners; ?> Active</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Configure homepage hero slides, festive promo strips, responsive banners, and deep-link click targets.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/marketing/sliders.php" class="dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                        <span>Hero Slider Studio</span>
                    </a>
                    <a href="/admin/marketing/homepage.php" class="dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>Homepage Layout</span>
                    </a>
                    <button type="button" class="dt-btn-gold" onclick="openBannerModal()">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>+ Add New Banner</span>
                    </button>
                </div>
            </div>

            <!-- KPI Ribbon -->
            <div class="dt-kpi-grid">
                <div class="dt-kpi-card">
                    <div>
                        <div class="dt-kpi-val"><?php echo $totalBanners; ?></div>
                        <div class="dt-kpi-lbl">Total Banners</div>
                    </div>
                    <div class="dt-kpi-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    </div>
                </div>
                <div class="dt-kpi-card">
                    <div>
                        <div class="dt-kpi-val" style="color:#15803D;"><?php echo $activeBanners; ?></div>
                        <div class="dt-kpi-lbl">Active Live</div>
                    </div>
                    <div class="dt-kpi-icon" style="background:#DCFCE7; color:#15803D;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </div>
                </div>
                <div class="dt-kpi-card">
                    <div>
                        <div class="dt-kpi-val"><?php echo $heroBanners; ?></div>
                        <div class="dt-kpi-lbl">Hero Slides</div>
                    </div>
                    <div class="dt-kpi-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                    </div>
                </div>
                <div class="dt-kpi-card">
                    <div>
                        <div class="dt-kpi-val"><?php echo $promoBanners; ?></div>
                        <div class="dt-kpi-lbl">Promo Strips</div>
                    </div>
                    <div class="dt-kpi-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="4" y1="9" x2="20" y2="9"></line><line x1="4" y1="15" x2="20" y2="15"></line><rect x="2" y="3" width="20" height="18" rx="2"></rect></svg>
                    </div>
                </div>
            </div>

            <!-- Placement Filter Pills -->
            <div class="dt-pill-nav">
                <a href="/admin/marketing/banners.php" class="dt-pill <?php echo $selectedPlacement === '' ? 'active' : ''; ?>">All Placements (<?php echo $totalBanners; ?>)</a>
                <a href="/admin/marketing/banners.php?placement=hero" class="dt-pill <?php echo $selectedPlacement === 'hero' ? 'active' : ''; ?>">Hero Sliders (<?php echo $heroBanners; ?>)</a>
                <a href="/admin/marketing/banners.php?placement=promo_strip" class="dt-pill <?php echo $selectedPlacement === 'promo_strip' ? 'active' : ''; ?>">Promo Strips (<?php echo $promoBanners; ?>)</a>
                <a href="/admin/marketing/banners.php?placement=sidebar" class="dt-pill <?php echo $selectedPlacement === 'sidebar' ? 'active' : ''; ?>">Sidebar</a>
                <a href="/admin/marketing/banners.php?placement=popup" class="dt-pill <?php echo $selectedPlacement === 'popup' ? 'active' : ''; ?>">Promotional Popup</a>
            </div>

            <!-- Active Banners Grid -->
            <div class="dt-banner-grid">
                <?php if (empty($banners)): ?>
                    <div style="grid-column: 1 / -1; background:#FFFFFF; border:1.5px dashed var(--dt-border); border-radius:12px; padding:36px; text-align:center; color:#64748B;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94A3B8" stroke-width="1.8" style="margin-bottom:8px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        <h4 style="margin:0 0 4px 0; color:#1E293B;">No banners found for this placement.</h4>
                        <p style="margin:0; font-size:13px;">Click "+ Add New Banner" to create your first visual campaign.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($banners as $b): ?>
                        <?php
                            $bId = (int)($b['id'] ?? 0);
                            $bTitle = htmlspecialchars($b['title'] ?? '');
                            $bSubtitle = htmlspecialchars($b['subtitle'] ?? '');
                            $bImg = htmlspecialchars($b['image_url'] ?? '/assets/images/hero-banner.png');
                            $bMobImg = htmlspecialchars($b['image_mobile_url'] ?? '');
                            $bLink = htmlspecialchars($b['link_url'] ?? '/shop');
                            $bPlacement = htmlspecialchars($b['placement'] ?? 'hero');
                            $bBadge = htmlspecialchars($b['badge_text'] ?? '');
                            $bBg = htmlspecialchars($b['bg_color'] ?? '#181512');
                            $bStatus = $b['status'] ?? 'active';
                            $bOrder = (int)($b['display_order'] ?? 0);
                            $bBtnText = htmlspecialchars($b['button_text'] ?? 'Explore Now');
                        ?>
                        <div class="dt-banner-card">
                            <div class="dt-banner-preview" style="background-image: url('<?php echo $bImg; ?>'); background-color: <?php echo $bBg; ?>;">
                                <div class="dt-banner-preview-content">
                                    <?php if ($bBadge !== ''): ?>
                                        <span class="dt-banner-badge"><?php echo $bBadge; ?></span>
                                    <?php endif; ?>
                                    <h3 class="dt-banner-title"><?php echo $bTitle; ?></h3>
                                    <?php if ($bSubtitle !== ''): ?>
                                        <p class="dt-banner-sub"><?php echo $bSubtitle; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="dt-banner-meta">
                                <div class="dt-banner-props">
                                    <div class="dt-prop-row">
                                        <span style="font-weight:700; color:#1E293B;">Placement:</span>
                                        <span class="adm-badge gold" style="font-size:10.5px; text-transform:uppercase;"><?php echo $bPlacement; ?></span>
                                    </div>
                                    <div class="dt-prop-row">
                                        <span style="font-weight:700; color:#1E293B;">Display Order:</span>
                                        <span style="font-weight:800; color:#8A681F;">#<?php echo $bOrder; ?></span>
                                    </div>
                                    <div class="dt-prop-row">
                                        <span style="font-weight:700; color:#1E293B;">Target URL:</span>
                                        <code style="font-size:11px; background:#F8FAFC; padding:2px 6px; border-radius:4px;"><?php echo $bLink; ?></code>
                                    </div>
                                    <div class="dt-prop-row">
                                        <span style="font-weight:700; color:#1E293B;">Status:</span>
                                        <?php if ($bStatus === 'active'): ?>
                                            <span style="display:inline-flex; align-items:center; gap:4px; font-weight:700; color:#15803D; font-size:11.5px;">
                                                <span style="width:7px; height:7px; border-radius:50%; background:#15803D;"></span> Active
                                            </span>
                                        <?php else: ?>
                                            <span style="display:inline-flex; align-items:center; gap:4px; font-weight:700; color:#94A3B8; font-size:11.5px;">
                                                <span style="width:7px; height:7px; border-radius:50%; background:#94A3B8;"></span> Inactive
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="dt-banner-actions">
                                    <!-- Toggle Status -->
                                    <form method="POST" style="margin:0;">
                                        <input type="hidden" name="action" value="toggle_status">
                                        <input type="hidden" name="id" value="<?php echo $bId; ?>">
                                        <input type="hidden" name="current_status" value="<?php echo $bStatus; ?>">
                                        <button type="submit" class="dt-btn-pale" style="font-size:11.5px;" title="Toggle active status">
                                            <?php echo $bStatus === 'active' ? 'Deactivate' : 'Activate'; ?>
                                        </button>
                                    </form>

                                    <!-- Edit Button -->
                                    <button type="button" class="dt-btn-pale" style="font-size:11.5px;" onclick='openEditBannerModal(<?php echo json_encode($b); ?>)'>
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        <span>Edit</span>
                                    </button>

                                    <!-- Delete Button -->
                                    <form method="POST" style="margin:0;" onsubmit="return confirm('Are you sure you want to delete this banner?');">
                                        <input type="hidden" name="action" value="delete_banner">
                                        <input type="hidden" name="id" value="<?php echo $bId; ?>">
                                        <button type="submit" class="dt-btn-danger" style="font-size:11.5px;" title="Delete banner">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>

<!-- Add / Edit Banner Modal -->
<div class="dt-modal-backdrop" id="bannerModal">
    <div class="dt-modal-card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; border-bottom:1px solid #F1F5F9; padding-bottom:10px;">
            <h3 id="modalHeading" style="margin:0; font-size:1.15rem; font-weight:800; color:#181512; display:flex; align-items:center; gap:8px;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                <span>Add Promotional Banner</span>
            </h3>
            <button type="button" onclick="closeBannerModal()" style="background:none; border:none; cursor:pointer; color:#64748B; font-size:18px; font-weight:700;">&times;</button>
        </div>
        <form method="POST" id="bannerForm">
            <input type="hidden" name="action" id="formAction" value="create_banner">
            <input type="hidden" name="id" id="bannerId" value="">

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                <div style="grid-column: 1 / -1;">
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Banner Headline / Title *</label>
                    <input type="text" name="title" id="inpTitle" required placeholder="e.g. Pure Paithani Silk Mela 2026" style="width:100%; height:38px; border:1.5px solid var(--dt-border); border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>

                <div style="grid-column: 1 / -1;">
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Subtitle / Tagline</label>
                    <input type="text" name="subtitle" id="inpSubtitle" placeholder="e.g. Direct Loom Wholesale Rates for Boutiques" style="width:100%; height:38px; border:1.5px solid var(--dt-border); border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Placement *</label>
                    <select name="placement" id="inpPlacement" style="width:100%; height:38px; border:1.5px solid var(--dt-border); border-radius:6px; padding:0 8px; font-weight:600;">
                        <option value="hero">Hero Slider (Top)</option>
                        <option value="promo_strip">Promotional Strip</option>
                        <option value="sidebar">Sidebar Banner</option>
                        <option value="popup">Promotional Popup</option>
                    </select>
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Badge Text (Optional)</label>
                    <input type="text" name="badge_text" id="inpBadge" placeholder="e.g. 40% OFF or FESTIVE" style="width:100%; height:38px; border:1.5px solid var(--dt-border); border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>

                <div style="grid-column: 1 / -1;">
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Desktop Image URL *</label>
                    <input type="text" name="image_url" id="inpImageUrl" required placeholder="/assets/images/hero-banner.png" style="width:100%; height:38px; border:1.5px solid var(--dt-border); border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>

                <div style="grid-column: 1 / -1;">
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Mobile Image URL (Optional)</label>
                    <input type="text" name="image_mobile_url" id="inpMobImageUrl" placeholder="/assets/images/hero-banner-mobile.png" style="width:100%; height:38px; border:1.5px solid var(--dt-border); border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Target Click URL</label>
                    <input type="text" name="link_url" id="inpLinkUrl" placeholder="/shop?category=paithani" style="width:100%; height:38px; border:1.5px solid var(--dt-border); border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Button CTA Text</label>
                    <input type="text" name="button_text" id="inpBtnText" placeholder="Explore Collection" style="width:100%; height:38px; border:1.5px solid var(--dt-border); border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Display Order</label>
                    <input type="number" name="display_order" id="inpOrder" value="1" min="0" max="999" style="width:100%; height:38px; border:1.5px solid var(--dt-border); border-radius:6px; padding:0 10px; font-weight:600; box-sizing:border-box;">
                </div>

                <div>
                    <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Status</label>
                    <select name="status" id="inpStatus" style="width:100%; height:38px; border:1.5px solid var(--dt-border); border-radius:6px; padding:0 8px; font-weight:600;">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div style="margin-top:20px; display:flex; justify-content:flex-end; gap:8px; border-top:1px solid #F1F5F9; padding-top:12px;">
                <button type="button" class="dt-btn-pale" onclick="closeBannerModal()">Cancel</button>
                <button type="submit" class="dt-btn-gold" id="btnSubmitModal">Save Banner</button>
            </div>
        </form>
    </div>
</div>

<script>
function openBannerModal() {
    document.getElementById('modalHeading').innerHTML = '<span>Add Promotional Banner</span>';
    document.getElementById('formAction').value = 'create_banner';
    document.getElementById('bannerId').value = '';
    document.getElementById('inpTitle').value = '';
    document.getElementById('inpSubtitle').value = '';
    document.getElementById('inpPlacement').value = 'hero';
    document.getElementById('inpBadge').value = '';
    document.getElementById('inpImageUrl').value = '/assets/images/hero-banner.png';
    document.getElementById('inpMobImageUrl').value = '';
    document.getElementById('inpLinkUrl').value = '/shop';
    document.getElementById('inpBtnText').value = 'Explore Now';
    document.getElementById('inpOrder').value = '1';
    document.getElementById('inpStatus').value = 'active';
    document.getElementById('btnSubmitModal').textContent = 'Create Banner';
    document.getElementById('bannerModal').style.display = 'flex';
}

function openEditBannerModal(banner) {
    document.getElementById('modalHeading').innerHTML = '<span>Edit Banner #' + (banner.id || '') + '</span>';
    document.getElementById('formAction').value = 'update_banner';
    document.getElementById('bannerId').value = banner.id || '';
    document.getElementById('inpTitle').value = banner.title || '';
    document.getElementById('inpSubtitle').value = banner.subtitle || '';
    document.getElementById('inpPlacement').value = banner.placement || 'hero';
    document.getElementById('inpBadge').value = banner.badge_text || '';
    document.getElementById('inpImageUrl').value = banner.image_url || '';
    document.getElementById('inpMobImageUrl').value = banner.image_mobile_url || '';
    document.getElementById('inpLinkUrl').value = banner.link_url || '';
    document.getElementById('inpBtnText').value = banner.button_text || 'Explore Now';
    document.getElementById('inpOrder').value = banner.display_order || '0';
    document.getElementById('inpStatus').value = banner.status || 'active';
    document.getElementById('btnSubmitModal').textContent = 'Update Banner';
    document.getElementById('bannerModal').style.display = 'flex';
}

function closeBannerModal() {
    document.getElementById('bannerModal').style.display = 'none';
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
