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
    <div class="dt-subnav-scroll-track" id="dtMainCatSliderTrack" role="tablist">
        <button type="button" class="dt-subnav-item main-cat-tab <?= empty($currentCat) || strtolower($currentCat) === 'all' ? 'active' : '' ?>" role="tab" data-cat="All" aria-selected="<?= empty($currentCat) || strtolower($currentCat) === 'all' ? 'true' : 'false' ?>" onclick="if(typeof window.filterByBanner==='function'){window.filterByBanner('All');}else{window.location.href='/shop.php?category=all';}">
            <svg class="dt-subnav-icon" viewBox="0 0 24 24"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            <span>All Categories</span>
        </button>
        <?php foreach ($subnavCategories as $hCat): 
            $isCatActive = (strtolower($currentCat) === strtolower($hCat) || strtolower(str_replace('-', ' ', $currentCat)) === strtolower($hCat));
        ?>
        <button type="button" class="dt-subnav-item main-cat-tab <?= $isCatActive ? 'active' : '' ?>" role="tab" data-cat="<?= htmlspecialchars($hCat) ?>" aria-selected="<?= $isCatActive ? 'true' : 'false' ?>" onclick="if(typeof window.filterByBanner==='function'){window.filterByBanner('<?= htmlspecialchars(addslashes($hCat)) ?>');}else{window.location.href='/shop.php?category=<?= urlencode($hCat) ?>';}"><?= htmlspecialchars($hCat) ?></button>
        <?php endforeach; ?>
        <a href="/wholesale.php" class="dt-subnav-item" style="color:#FFE699; font-weight:800;">
            <span>📦 Wholesale Lots</span>
        </a>
        <a href="/reseller.php" class="dt-subnav-item" style="color:#FFE699; font-weight:800;">
            <span>💰 Reseller Portal</span>
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
