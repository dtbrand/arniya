<?php
/**
 * includes/subnav.php — Amazon-Style Attached Luxury Gold Sub-Navigation Bar
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../src/ProductCatalog.php';
$subnavCategories = \DTBrand\ProductCatalog::getCategories();
$currentCat = isset($selectedCategory) ? $selectedCategory : (isset($_GET['category']) ? $_GET['category'] : 'All');
?>
<nav class="dt-attached-subnav" id="dtAttachedSubnav" aria-label="Attached categories navigation">
    <div class="dt-subnav-scroll-track" id="dtMainCatSliderTrack">
        <button type="button" class="dt-subnav-item main-cat-tab <?= empty($currentCat) || strtolower($currentCat) === 'all' ? 'active' : '' ?>" data-cat="All" <?= empty($currentCat) || strtolower($currentCat) === 'all' ? 'aria-current="page"' : '' ?> onclick="if(typeof window.filterByBanner==='function'){window.filterByBanner('All');}else{window.location.href='/shop.php?category=all';}">
            <svg class="dt-subnav-icon" viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            <span>All Categories</span>
        </button>
        <?php foreach ($subnavCategories as $hCat): 
            $isCatActive = (strtolower($currentCat) === strtolower($hCat) || strtolower(str_replace('-', ' ', $currentCat)) === strtolower($hCat));
        ?>
        <button type="button" class="dt-subnav-item main-cat-tab <?= $isCatActive ? 'active' : '' ?>" data-cat="<?= htmlspecialchars($hCat) ?>" <?= $isCatActive ? 'aria-current="page"' : '' ?> onclick="if(typeof window.filterByBanner==='function'){window.filterByBanner('<?= htmlspecialchars(addslashes($hCat)) ?>');}else{window.location.href='/shop.php?category=<?= urlencode($hCat) ?>';}"><?= htmlspecialchars($hCat) ?></button>
        <?php endforeach; ?>
        <a href="/wholesale.php" class="dt-subnav-item" style="color:#FFE699; font-weight:800; display:inline-flex; align-items:center; gap:6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            <span>Wholesale Lots</span>
        </a>
        <a href="/reseller.php" class="dt-subnav-item" style="color:#FFE699; font-weight:800; display:inline-flex; align-items:center; gap:6px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12M6 8h12M6 13l8.5 8M6 13h3a4 4 0 0 0 0-8"></path></svg>
            <span>Reseller Portal</span>
        </a>
        <button type="button" class="dt-subnav-item subnav-reels-btn" onclick="if(typeof window.openReelsModal==='function') window.openReelsModal(0);" aria-label="Watch Video Reels">
            <span class="reel-3d-icon-wrap">
                <svg class="reel-3d-svg" viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <circle cx="12" cy="12" r="3" fill="#D4AF37"></circle>
                    <circle cx="12" cy="6" r="1.5" fill="#D4AF37"></circle>
                    <circle cx="12" cy="18" r="1.5" fill="#D4AF37"></circle>
                    <circle cx="6" cy="12" r="1.5" fill="#D4AF37"></circle>
                    <circle cx="18" cy="12" r="1.5" fill="#D4AF37"></circle>
                </svg>
                <span class="reel-live-dot"></span>
            </span>
            <span>Reels</span>
        </button>
    </div>
</nav>
