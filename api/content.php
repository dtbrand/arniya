<?php
/**
 * api/content.php — Storefront Dynamic Content & Marketing Hydration API
 * DT Brand's & Jai Hanuman Tex
 * 
 * Central public REST endpoint powering dynamic storefront rendering:
 * - Homepage layout & sections
 * - Hero sliders & promotional banners
 * - Announcements marquee
 * - Curated collections & pinned product lists
 * - SEO metadata & OpenGraph tags
 * - Reseller / WhatsApp share templates with placeholder resolution
 * - Social channels & official WhatsApp concierge
 */

declare(strict_types=1);

require_once __DIR__ . '/cors.php';
cors_preflight();
cors_headers();

if (!headers_sent()) {
    header('Content-Type: application/json; charset=UTF-8');
}

require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/ContentManager.php';
require_once __DIR__ . '/../src/ProductCatalog.php';

use DTBrand\ContentManager;
use DTBrand\ProductCatalog;

$action = trim((string)($_GET['action'] ?? 'homepage'));

try {
    switch ($action) {
        case 'homepage':
            $sections = ContentManager::getHomepageSections(true);
            $banners = ContentManager::getBanners(true, 'hero');
            $promoBanners = ContentManager::getBanners(true, 'promo_strip');
            $announcements = ContentManager::getAnnouncements(true, 'topbar');
            $collections = ContentManager::getCuratedCollections(true);
            $featuredProducts = ContentManager::getCuratedProducts('featured', true);
            $bestSellers = ContentManager::getCuratedProducts('bestseller', true);
            $newArrivals = ContentManager::getCuratedProducts('new_arrival', true);
            $seo = ContentManager::getSeoMetadata('/');
            $socials = ContentManager::getSocialChannels(true);

            echo json_encode([
                'success' => true,
                'data' => [
                    'sections' => $sections,
                    'hero_banners' => $banners,
                    'promo_banners' => $promoBanners,
                    'announcements' => $announcements,
                    'collections' => $collections,
                    'curated_products' => [
                        'featured' => $featuredProducts,
                        'bestseller' => $bestSellers,
                        'new_arrival' => $newArrivals,
                    ],
                    'seo' => $seo,
                    'social_channels' => $socials,
                ],
                'timestamp' => time()
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        case 'banners':
            $placement = isset($_GET['placement']) && $_GET['placement'] !== '' ? (string)$_GET['placement'] : null;
            $banners = ContentManager::getBanners(true, $placement);
            echo json_encode([
                'success' => true,
                'placement' => $placement ?? 'all',
                'count' => count($banners),
                'banners' => $banners
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        case 'sliders':
            $sliders = ContentManager::getHeroSliders(true);
            echo json_encode([
                'success' => true,
                'count' => count($sliders),
                'sliders' => $sliders
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        case 'sections':
            $sections = ContentManager::getHomepageSections(true);
            echo json_encode([
                'success' => true,
                'count' => count($sections),
                'sections' => $sections
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        case 'collections':
            $slug = trim((string)($_GET['slug'] ?? ''));
            if ($slug !== '') {
                $collection = ContentManager::getCuratedCollectionBySlug($slug);
                if (!$collection) {
                    http_response_code(404);
                    echo json_encode(['success' => false, 'error' => 'Collection not found'], JSON_UNESCAPED_SLASHES);
                    exit;
                }
                echo json_encode(['success' => true, 'collection' => $collection], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            } else {
                $collections = ContentManager::getCuratedCollections(true);
                echo json_encode([
                    'success' => true,
                    'count' => count($collections),
                    'collections' => $collections
                ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            }
            break;

        case 'curated_products':
            $listType = trim((string)($_GET['type'] ?? 'featured'));
            $products = ContentManager::getCuratedProducts($listType, true);
            echo json_encode([
                'success' => true,
                'type' => $listType,
                'count' => count($products),
                'products' => $products
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        case 'announcements':
            $placement = trim((string)($_GET['placement'] ?? 'topbar'));
            $announcements = ContentManager::getAnnouncements(true, $placement);
            echo json_encode([
                'success' => true,
                'placement' => $placement,
                'count' => count($announcements),
                'announcements' => $announcements
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        case 'seo':
            $pageRoute = trim((string)($_GET['route'] ?? '/'));
            $seo = ContentManager::getSeoMetadata($pageRoute);
            echo json_encode([
                'success' => true,
                'route' => $pageRoute,
                'seo' => $seo
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        case 'share_template':
            $templateKey = trim((string)($_GET['key'] ?? 'reseller_product_card'));
            $template = ContentManager::getShareTemplateByKey($templateKey);
            if (!$template) {
                http_response_code(404);
                echo json_encode(['success' => false, 'error' => 'Share template not found'], JSON_UNESCAPED_SLASHES);
                exit;
            }

            // Optional placeholder replacements
            $vars = [
                'product_title' => (string)($_GET['product_title'] ?? 'Banarasi Silk Saree'),
                'mrp' => (string)($_GET['mrp'] ?? '3499'),
                'reseller_price' => (string)($_GET['reseller_price'] ?? '1899'),
                'reseller_margin' => (string)($_GET['reseller_margin'] ?? '1600'),
                'shop_url' => (string)($_GET['shop_url'] ?? 'https://jaihanumantex.in/shop'),
                'order_link' => (string)($_GET['order_link'] ?? 'https://jaihanumantex.in/shop?ref=reseller'),
                'phone' => (string)($_GET['phone'] ?? '+91 70463 63528'),
            ];

            $rendered = ContentManager::renderShareTemplate($template['content_body'] ?? '', $vars);

            echo json_encode([
                'success' => true,
                'template' => $template,
                'rendered' => $rendered,
                'whatsapp_url' => 'https://api.whatsapp.com/send?text=' . rawurlencode($rendered)
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        case 'social_links':
            $socials = ContentManager::getSocialChannels(true);
            echo json_encode([
                'success' => true,
                'count' => count($socials),
                'channels' => $socials
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
            break;

        default:
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'Invalid action parameter',
                'supported_actions' => [
                    'homepage', 'banners', 'sliders', 'sections',
                    'collections', 'curated_products', 'announcements',
                    'seo', 'share_template', 'social_links'
                ]
            ], JSON_UNESCAPED_SLASHES);
            break;
    }
} catch (\Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Server error: ' . $e->getMessage()
    ], JSON_UNESCAPED_SLASHES);
}
