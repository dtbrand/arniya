<?php
/**
 * sitemap.php — Dynamic Enterprise XML Sitemap Generator
 * DT Brand's & Jai Hanuman Tex — Production SEO Engine
 *
 * Fully compliant with Google & Bing XML Sitemap 0.9 schema.
 * Dynamically resolves canonical domain (jaihanumantex.in / harmitethnic.com)
 * Includes active public products, collections, and core storefront landing pages.
 * Section 64 Compliant: Zero role-specific confidential pricing leakage in structured feeds.
 */

// ── 1. Bootstrap Environment & Headers ──
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/ProductCatalog.php';

use DTBrand\Database;
use DTBrand\ProductCatalog;

// Set XML headers with 1-hour client/CDN cache
header('Content-Type: application/xml; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Cache-Control: public, max-age=3600');

// ── 2. Determine Canonical Base URL ──
$host = $_SERVER['HTTP_HOST'] ?? 'jaihanumantex.in';
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
    || (isset($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443);
$proto = $isHttps ? 'https://' : 'http://';
$baseUrl = rtrim($proto . $host, '/');

// ── 3. Static Core Storefront Routes ──
$today = date('Y-m-d');
$staticPages = [
    ['loc' => '/',           'priority' => '1.0', 'changefreq' => 'daily',   'lastmod' => $today],
    ['loc' => '/shop',       'priority' => '0.9', 'changefreq' => 'daily',   'lastmod' => $today],
    ['loc' => '/about-us',   'priority' => '0.6', 'changefreq' => 'monthly', 'lastmod' => $today],
    ['loc' => '/contact',    'priority' => '0.6', 'changefreq' => 'monthly', 'lastmod' => $today],
    ['loc' => '/shipping',   'priority' => '0.5', 'changefreq' => 'monthly', 'lastmod' => $today],
    ['loc' => '/privacy',    'priority' => '0.5', 'changefreq' => 'monthly', 'lastmod' => $today],
    ['loc' => '/terms',      'priority' => '0.5', 'changefreq' => 'monthly', 'lastmod' => $today],
];

// ── 4. Retrieve Public Active Products ──
$products = [];
try {
    $rawProducts = ProductCatalog::filter(['role' => 'guest']);
    foreach ($rawProducts as $p) {
        // Exclude full_set products from public guest index (Section 5, 7, 64)
        if (($p['selling_type'] ?? 'single_piece') === 'full_set') {
            continue;
        }
        $pId = (int)($p['id'] ?? 0);
        if ($pId <= 0) {
            continue;
        }

        // Format ISO 8601 date
        $modDate = $today;
        if (!empty($p['updated_at'])) {
            $ts = strtotime($p['updated_at']);
            if ($ts !== false) {
                $modDate = date('Y-m-d', $ts);
            }
        } elseif (!empty($p['created_at'])) {
            $ts = strtotime($p['created_at']);
            if ($ts !== false) {
                $modDate = date('Y-m-d', $ts);
            }
        }

        $products[] = [
            'loc' => '/product/' . $pId,
            'priority' => '0.8',
            'changefreq' => 'weekly',
            'lastmod' => $modDate
        ];
    }
} catch (\Throwable $e) {
    // Graceful fallback if database read encounters an issue
    error_log('[SITEMAP] Product fetch error: ' . $e->getMessage());
}

// ── 5. Generate XML Output ──
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($staticPages as $page): ?>
    <url>
        <loc><?= htmlspecialchars($baseUrl . $page['loc'], ENT_XML1, 'UTF-8') ?></loc>
        <lastmod><?= htmlspecialchars($page['lastmod'], ENT_XML1, 'UTF-8') ?></lastmod>
        <changefreq><?= htmlspecialchars($page['changefreq'], ENT_XML1, 'UTF-8') ?></changefreq>
        <priority><?= htmlspecialchars($page['priority'], ENT_XML1, 'UTF-8') ?></priority>
    </url>
<?php endforeach; ?>
<?php foreach ($products as $prod): ?>
    <url>
        <loc><?= htmlspecialchars($baseUrl . $prod['loc'], ENT_XML1, 'UTF-8') ?></loc>
        <lastmod><?= htmlspecialchars($prod['lastmod'], ENT_XML1, 'UTF-8') ?></lastmod>
        <changefreq><?= htmlspecialchars($prod['changefreq'], ENT_XML1, 'UTF-8') ?></changefreq>
        <priority><?= htmlspecialchars($prod['priority'], ENT_XML1, 'UTF-8') ?></priority>
    </url>
<?php endforeach; ?>
</urlset>
