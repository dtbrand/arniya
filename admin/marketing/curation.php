<?php
/**
 * admin/marketing/curation.php — DT Brand's Product Curation & Pinned Reels Console
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
require_once __DIR__ . '/../../src/ProductCatalog.php';

use DTBrand\Database;
use DTBrand\ContentManager;
use DTBrand\ProductCatalog;

$page_title = "Product Curation & Pinned Reels Console";
$active_nav = "marketing";
$active_subnav = "curation";

$currentType = trim((string)($_GET['type'] ?? 'featured'));
if (!in_array($currentType, ['featured', 'bestseller', 'new_arrival', 'trending'], true)) {
    $currentType = 'featured';
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = trim((string)($_POST['action'] ?? ''));

    if ($action === 'add_product') {
        $pId = (int)($_POST['product_id'] ?? 0);
        if ($pId > 0) {
            $existing = ContentManager::getCuratedProducts($currentType, false);
            $ids = array_map(fn($p) => (int)$p['id'], $existing);
            if (!in_array($pId, $ids, true)) {
                $ids[] = $pId;
                ContentManager::setCuratedProducts($currentType, $ids);
                $message = "Product #{$pId} pinned to " . ucfirst($currentType) . " reel!";
            } else {
                $error = "Product #{$pId} is already in this reel.";
            }
        }
    } elseif ($action === 'remove_product') {
        $pId = (int)($_POST['product_id'] ?? 0);
        if ($pId > 0) {
            $existing = ContentManager::getCuratedProducts($currentType, false);
            $ids = array_filter(array_map(fn($p) => (int)$p['id'], $existing), fn($id) => $id !== $pId);
            ContentManager::setCuratedProducts($currentType, array_values($ids));
            $message = "Product #{$pId} removed from " . ucfirst($currentType) . " reel.";
        }
    }
}

$curatedList = ContentManager::getCuratedProducts($currentType, false);
$allProducts = ProductCatalog::getAll(true);

$rupeeSvg = '<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-1.5px; display:inline-block;"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Curation &amp; Pinned Reels — DT Brand's Admin</title>
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

        .dt-tabs {
            display: flex;
            gap: 8px;
            border-bottom: 2px solid #E2E8F0;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .dt-tab {
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 700;
            color: #64748B;
            text-decoration: none;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }
        .dt-tab.active {
            color: var(--dt-gold-dark);
            border-bottom-color: var(--dt-gold);
        }

        .dt-product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 16px;
        }
        .dt-prod-card {
            background: #FFFFFF;
            border: 1.5px solid var(--dt-border);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
            display: flex;
            align-items: center;
            padding: 12px;
            gap: 12px;
            transition: all 0.2s ease;
        }
        .dt-prod-card:hover {
            border-color: var(--dt-gold);
            transform: translateY(-1.5px);
        }
        .dt-prod-thumb {
            width: 58px;
            height: 58px;
            border-radius: 8px;
            background-size: cover;
            background-position: center;
            border: 1px solid #E2E8F0;
            flex-shrink: 0;
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
                        <span>Product Curation &amp; Pinned Reels</span>
                        <span class="adm-badge gold" style="font-size:0.68rem;"><?php echo count($curatedList); ?> SKUs Pinned</span>
                    </h1>
                    <p class="adm-page-subtitle" style="margin:4px 0 0 0; color:#64748B; font-size:0.82rem;">Select and sequence VIP products spotlighted across featured storefront reels and best-seller feeds.</p>
                </div>
                <div class="adm-page-actions" style="display:flex; gap:8px; flex-wrap:wrap;">
                    <a href="/admin/marketing/homepage.php" class="dt-btn-pale">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>Layout Order</span>
                    </a>
                </div>
            </div>

            <!-- List Type Tabs -->
            <div class="dt-tabs">
                <a href="/admin/marketing/curation.php?type=featured" class="dt-tab <?php echo $currentType === 'featured' ? 'active' : ''; ?>">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                    <span>Featured Showcase</span>
                </a>
                <a href="/admin/marketing/curation.php?type=bestseller" class="dt-tab <?php echo $currentType === 'bestseller' ? 'active' : ''; ?>">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                    <span>Best Sellers Reel</span>
                </a>
                <a href="/admin/marketing/curation.php?type=new_arrival" class="dt-tab <?php echo $currentType === 'new_arrival' ? 'active' : ''; ?>">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
                    <span>New Arrivals (Fresh Looms)</span>
                </a>
                <a href="/admin/marketing/curation.php?type=trending" class="dt-tab <?php echo $currentType === 'trending' ? 'active' : ''; ?>">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                    <span>Trending Reseller Picks</span>
                </a>
            </div>

            <!-- Quick Add Product Card -->
            <div class="adm-card" style="margin-bottom:20px; padding:16px 20px;">
                <form method="POST" style="display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap; margin:0;">
                    <input type="hidden" name="action" value="add_product">
                    <div style="flex:1; min-width:240px;">
                        <label style="font-size:0.75rem; font-weight:700; color:#181512; display:block; margin-bottom:4px;">Pin Product to <?php echo ucfirst($currentType); ?> Reel</label>
                        <select name="product_id" required style="width:100%; height:38px; border:1.5px solid var(--dt-border); border-radius:6px; padding:0 10px; font-weight:600;">
                            <option value="">-- Choose a Product from Catalog --</option>
                            <?php foreach ($allProducts as $prod): ?>
                                <?php
                                    $pId = (int)($prod['id'] ?? 0);
                                    $pTitle = htmlspecialchars($prod['name'] ?? $prod['title'] ?? '');
                                    $pSku = htmlspecialchars($prod['sku'] ?? '');
                                    $pPrice = (float)($prod['wholesale_price'] ?? $prod['price'] ?? 0);
                                ?>
                                <option value="<?php echo $pId; ?>">#<?php echo $pId; ?> - <?php echo $pTitle; ?> (<?php echo $pSku; ?>) - Rs. <?php echo number_format($pPrice, 0); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="dt-btn-gold" style="height:38px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>Pin to Reel</span>
                    </button>
                </form>
            </div>

            <!-- Pinned Products Grid -->
            <div class="dt-product-grid">
                <?php if (empty($curatedList)): ?>
                    <div style="grid-column:1 / -1; background:#FFFFFF; border:1.5px dashed var(--dt-border); border-radius:12px; padding:36px; text-align:center; color:#64748B;">
                        No products currently pinned to this reel. Select one above.
                    </div>
                <?php else: ?>
                    <?php $pos = 1; foreach ($curatedList as $p): ?>
                        <?php
                            $pId = (int)($p['id'] ?? 0);
                            $pTitle = htmlspecialchars($p['name'] ?? $p['title'] ?? '');
                            $pSku = htmlspecialchars($p['sku'] ?? 'SKU-'.$pId);
                            $pImg = htmlspecialchars($p['image_url'] ?? $p['featured_image'] ?? '/assets/images/product1.png');
                            $pPrice = (float)($p['price'] ?? $p['wholesale_price'] ?? 0);
                        ?>
                        <div class="dt-prod-card">
                            <div style="font-weight:900; color:#8A681F; font-size:13px; width:22px;">#<?php echo $pos++; ?></div>
                            <div class="dt-prod-thumb" style="background-image:url('<?php echo $pImg; ?>');"></div>
                            <div style="flex:1; min-width:0;">
                                <div style="font-weight:700; font-size:13px; color:#1E293B; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?php echo $pTitle; ?></div>
                                <div style="font-size:11px; color:#64748B;">SKU: <?php echo $pSku; ?></div>
                                <div style="font-weight:800; color:#8A681F; font-size:12.5px; margin-top:2px;">
                                    <?php echo $rupeeSvg; ?><?php echo number_format($pPrice, 2); ?>
                                </div>
                            </div>
                            <div>
                                <form method="POST" style="margin:0;">
                                    <input type="hidden" name="action" value="remove_product">
                                    <input type="hidden" name="product_id" value="<?php echo $pId; ?>">
                                    <button type="submit" class="dt-btn-danger" title="Unpin from reel">&times;</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
