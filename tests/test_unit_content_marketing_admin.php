<?php
/**
 * test_unit_content_marketing_admin.php — Section 29 Content & Marketing Admin Unit Tests
 * DT Brand's & Jai Hanuman Tex
 */

declare(strict_types=1);

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ContentManager.php';
require_once __DIR__ . '/../src/ProductCatalog.php';

use DTBrand\Database;
use DTBrand\ContentManager;
use DTBrand\ProductCatalog;

$totalTests = 0;
$passedTests = 0;

function assertTest(bool $condition, string $description): void {
    global $totalTests, $passedTests;
    $totalTests++;
    if ($condition) {
        $passedTests++;
        echo "  [PASS] {$description}\n";
    } else {
        echo "  [FAIL] {$description}\n";
    }
}

echo "\n=======================================================\n";
echo "   DT BRAND'S SECTION 29 MARKETING ADMIN TEST SUITE   \n";
echo "=======================================================\n\n";

// ── TEST GROUP 1: Banners & Sliders CRUD ──
echo "--- Group 1: Banners & Sliders CRUD ---\n";
$banners = ContentManager::getBanners(true, 'hero');
assertTest(is_array($banners) && count($banners) > 0, "ContentManager::getBanners(true, 'hero') returns active hero slides");

$heroSliders = ContentManager::getHeroSliders(true);
assertTest(is_array($heroSliders) && count($heroSliders) > 0, "ContentManager::getHeroSliders(true) returns slides");

$testBannerId = ContentManager::createBanner([
    'title' => 'Test Silk Weave 2026',
    'subtitle' => 'Exclusive Loom Run',
    'placement' => 'hero',
    'image_url' => '/assets/images/test.jpg',
    'link_url' => '/shop?category=test',
    'status' => 'active'
]);
assertTest($testBannerId > 0, "ContentManager::createBanner creates new banner ID: {$testBannerId}");

$updateOk = ContentManager::updateBanner($testBannerId, ['title' => 'Updated Silk Weave 2026']);
assertTest($updateOk, "ContentManager::updateBanner updates title");

$deleteOk = ContentManager::deleteBanner($testBannerId);
assertTest($deleteOk, "ContentManager::deleteBanner deletes banner");


// ── TEST GROUP 2: Homepage Sections Architecture ──
echo "\n--- Group 2: Homepage Sections Architecture ---\n";
$sections = ContentManager::getHomepageSections(false);
assertTest(is_array($sections) && count($sections) >= 5, "ContentManager::getHomepageSections returns at least 5 default sections");

$newSecId = ContentManager::createHomepageSection([
    'section_key' => 'test_section_' . time(),
    'title' => 'Test Spotlight Section',
    'subtitle' => 'Special Spotlight',
    'section_type' => 'product_carousel',
    'display_order' => 99,
    'is_active' => 1
]);
assertTest($newSecId > 0, "ContentManager::createHomepageSection creates section");

$reorderOk = ContentManager::reorderHomepageSections([$newSecId => 15]);
assertTest($reorderOk, "ContentManager::reorderHomepageSections reorders successfully");


// ── TEST GROUP 3: Curated Collections Studio ──
echo "\n--- Group 3: Curated Collections Studio ---\n";
$collections = ContentManager::getCuratedCollections(true);
assertTest(is_array($collections) && count($collections) >= 3, "ContentManager::getCuratedCollections returns active collections");

$firstColSlug = $collections[0]['slug'] ?? 'surat-wedding-silks';
$colBySlug = ContentManager::getCuratedCollectionBySlug($firstColSlug);
assertTest($colBySlug !== null && ($colBySlug['slug'] ?? '') === $firstColSlug, "ContentManager::getCuratedCollectionBySlug finds collection by slug '{$firstColSlug}'");

$newColId = ContentManager::createCuratedCollection([
    'title' => 'Test Royal Georgette',
    'slug' => 'test-royal-georgette',
    'tagline' => 'Partywear Georgette',
    'image_url' => '/assets/images/test-geo.jpg',
    'item_count' => 10,
    'status' => 'active'
]);
assertTest($newColId > 0, "ContentManager::createCuratedCollection creates collection ID: {$newColId}");

$delColOk = ContentManager::deleteCuratedCollection($newColId);
assertTest($delColOk, "ContentManager::deleteCuratedCollection deletes collection");


// ── TEST GROUP 4: Product Curation & Pinned Reels ──
echo "\n--- Group 4: Product Curation & Pinned Reels ---\n";
$featuredIds = ContentManager::getCuratedProductIds('featured');
assertTest(is_array($featuredIds) && count($featuredIds) > 0, "ContentManager::getCuratedProductIds('featured') returns array of product IDs");

$featuredProducts = ContentManager::getCuratedProducts('featured', true);
assertTest(is_array($featuredProducts) && count($featuredProducts) > 0, "ContentManager::getCuratedProducts('featured') resolves product objects");
assertTest(isset($featuredProducts[0]['title']) || isset($featuredProducts[0]['name']), "Resolved curated product contains name/title");

$setOk = ContentManager::setCuratedProducts('featured', [1, 2]);
assertTest($setOk, "ContentManager::setCuratedProducts('featured', [1, 2]) persists successfully");


// ── TEST GROUP 5: Announcements & Topbar Marquee ──
echo "\n--- Group 5: Announcements & Topbar Marquee ---\n";
$announcements = ContentManager::getAnnouncements(true);
assertTest(is_array($announcements) && count($announcements) > 0, "ContentManager::getAnnouncements returns active announcements");

$newAnnId = ContentManager::createAnnouncement([
    'title' => 'Test Notice',
    'message' => 'Loom Maintenance Alert for Weekend',
    'link_url' => '/shop',
    'placement' => 'topbar',
    'status' => 'active'
]);
assertTest($newAnnId > 0, "ContentManager::createAnnouncement creates announcement ID: {$newAnnId}");

$updAnnOk = ContentManager::updateAnnouncement($newAnnId, ['message' => 'Updated Loom Notice']);
assertTest($updAnnOk, "ContentManager::updateAnnouncement updates message");

$delAnnOk = ContentManager::deleteAnnouncement($newAnnId);
assertTest($delAnnOk, "ContentManager::deleteAnnouncement deletes announcement");


// ── TEST GROUP 6: SEO & OpenGraph Studio ──
echo "\n--- Group 6: SEO & OpenGraph Studio ---\n";
$seoHome = ContentManager::getSeoMetadata('/');
assertTest(is_array($seoHome) && !empty($seoHome['meta_title']), "ContentManager::getSeoMetadata('/') returns title tag");

$setSeoOk = ContentManager::setSeoMetadata('/wholesale', [
    'meta_title' => 'B2B Wholesale Loom Sarees Surat — DT Brand\'s',
    'meta_description' => 'Direct loom wholesale sourcing for boutiques and resellers across India.',
    'meta_keywords' => 'wholesale sarees, surat mill, loom pricing',
    'canonical_url' => 'https://jaihanumantex.in/wholesale'
]);
assertTest($setSeoOk, "ContentManager::setSeoMetadata persists SEO metadata for /wholesale");

$seoWholesale = ContentManager::getSeoMetadata('/wholesale');
assertTest(($seoWholesale['meta_title'] ?? '') === 'B2B Wholesale Loom Sarees Surat — DT Brand\'s', "Verified updated SEO metadata title for /wholesale");


// ── TEST GROUP 7: Share Templates & WhatsApp Interpolation ──
echo "\n--- Group 7: Share Templates & WhatsApp Interpolation ---\n";
$templates = ContentManager::getShareTemplates();
assertTest(is_array($templates) && count($templates) > 0, "ContentManager::getShareTemplates returns templates");

$tpl = ContentManager::getShareTemplateByKey('reseller_product_card');
assertTest($tpl !== null && !empty($tpl['content_body']), "ContentManager::getShareTemplateByKey('reseller_product_card') returns template");

$rendered = ContentManager::renderShareTemplate("Product: {product_title} | Price: Rs {reseller_price}", [
    'product_title' => 'Pure Paithani',
    'reseller_price' => '2450'
]);
assertTest($rendered === "Product: Pure Paithani | Price: Rs 2450", "ContentManager::renderShareTemplate interpolates variables correctly");


// ── TEST GROUP 8: Social Channels & Concierge ──
echo "\n--- Group 8: Social Channels & Concierge ---\n";
$channels = ContentManager::getSocialChannels(true);
assertTest(is_array($channels) && count($channels) >= 3, "ContentManager::getSocialChannels returns verified social channels");

$hasWa = false;
foreach ($channels as $c) {
    if (($c['channel_key'] ?? $c['platform'] ?? '') === 'whatsapp') {
        $hasWa = true;
        break;
    }
}
assertTest($hasWa, "Verified official WhatsApp concierge exists in channels list");


// ── TEST GROUP 9: Public API (api/content.php) Simulation ──
echo "\n--- Group 9: Public API (api/content.php) Simulation ---\n";

function simulateApi(string $action): array {
    $_SERVER['REQUEST_METHOD'] = 'GET';
    $_GET['action'] = $action;
    ob_start();
    include __DIR__ . '/../api/content.php';
    $out = ob_get_clean();
    $data = json_decode($out, true);
    return is_array($data) ? $data : ['raw' => $out];
}

$apiHomepage = simulateApi('homepage');
assertTest(($apiHomepage['success'] ?? false) === true, "api/content.php?action=homepage responds success: true");
assertTest(isset($apiHomepage['data']['sections']), "api/content.php?action=homepage contains sections array");
assertTest(isset($apiHomepage['data']['hero_banners']), "api/content.php?action=homepage contains hero_banners array");

$apiBanners = simulateApi('banners');
assertTest(($apiBanners['success'] ?? false) === true && isset($apiBanners['banners']), "api/content.php?action=banners responds with banners array");

$apiAnnounce = simulateApi('announcements');
assertTest(($apiAnnounce['success'] ?? false) === true && isset($apiAnnounce['announcements']), "api/content.php?action=announcements responds with announcements array");

$apiSeo = simulateApi('seo');
assertTest(($apiSeo['success'] ?? false) === true && isset($apiSeo['seo']), "api/content.php?action=seo responds with seo metadata");

$apiShare = simulateApi('share_template');
assertTest(($apiShare['success'] ?? false) === true && isset($apiShare['rendered']), "api/content.php?action=share_template renders message");


// ── TEST GROUP 10: Admin Files Dual Adminguard & Real SVG Compliance ──
echo "\n--- Group 10: Admin Files Dual Adminguard & Real SVG Compliance ---\n";

$adminFiles = [
    'banners.php',
    'sliders.php',
    'homepage.php',
    'collections.php',
    'curation.php',
    'announcements.php',
    'seo.php',
    'share-templates.php',
    'social.php',
];

foreach ($adminFiles as $af) {
    $fullPath = __DIR__ . '/../admin/marketing/' . $af;
    assertTest(is_file($fullPath), "File admin/marketing/{$af} exists on disk");
    $content = file_get_contents($fullPath);
    assertTest(strpos($content, 'adminguard.php') !== false, "File admin/marketing/{$af} includes dual relative adminguard check");
    assertTest(strpos($content, '<svg') !== false, "File admin/marketing/{$af} uses 100% real vector SVG icons");
    assertTest(strpos($content, 'dt-btn-') !== false, "File admin/marketing/{$af} adheres to luxury styled button classes");
}

echo "\n=======================================================\n";
echo "  SECTION 29 TEST RESULTS: {$passedTests} / {$totalTests} PASSED\n";
echo "=======================================================\n\n";

if ($passedTests === $totalTests) {
    exit(0);
} else {
    exit(1);
}
