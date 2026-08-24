<?php
/**
 * DT Brand/includes/subnav.php — Amazon-Style Attached Luxury Gold Sub-Navigation Bar
 * DT Brand's & Jai Hanuman Tex
 */
require_once __DIR__ . '/../src/ProductCatalog.php';
$subnavCategories = \DTBrand\ProductCatalog::getCategories();
$currentCat = isset($selectedCategory) ? $selectedCategory : (isset($_GET['category']) ? $_GET['category'] : 'All');
?>
<nav class="dt-attached-subnav" id="dtAttachedSubnav" aria-label="Attached categories navigation">
    <div class="dt-subnav-scroll-track" id="dtMainCatSliderTrack" role="tablist">
        <a href="/" class="dt-subnav-item <?= (empty($currentCat) || strtolower($currentCat) === 'all') && basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">
            <svg class="dt-subnav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            <span>Home</span>
        </a>
        <a href="/shop.php" class="dt-subnav-item <?= (empty($currentCat) || strtolower($currentCat) === 'all') && basename($_SERVER['PHP_SELF']) === 'shop.php' ? 'active' : '' ?>">
            <svg class="dt-subnav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            <span>Shop All</span>
        </a>
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
            <span>🎥 Reels Feed</span>
        </button>
    </div>
</nav>
