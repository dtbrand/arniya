<?php
/**
 * scripts/admin-master-audit.php
 *
 * Static admin integrity audit for route links, API references, duplicate
 * options, and the core responsive admin layout contract.
 */
declare(strict_types=1);

function dt_admin_audit_relative(string $root, string $path): string
{
    return str_replace('\\', '/', ltrim(substr($path, strlen($root)), DIRECTORY_SEPARATOR));
}

function dt_admin_audit_files(string $root, string $dir, array $extensions): array
{
    $base = $root . DIRECTORY_SEPARATOR . $dir;
    if (!is_dir($base)) {
        return [];
    }

    $out = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($base, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if (!$file->isFile()) {
            continue;
        }

        $ext = strtolower(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
        if (in_array($ext, $extensions, true)) {
            $out[] = $file->getPathname();
        }
    }

    sort($out);
    return $out;
}

function dt_admin_audit_normalize_local_url(string $root, string $url, string $area): ?string
{
    $path = parse_url($url, PHP_URL_PATH);
    if (!is_string($path) || $path === '') {
        return null;
    }

    $prefix = '/' . trim($area, '/');
    if ($path !== $prefix && strpos($path, $prefix . '/') !== 0) {
        return null;
    }

    $cleanPath = strtolower(rtrim($path, '/'));
    if ($area === 'admin' && $cleanPath === '/admin/logout') {
        return 'admin/logout.php';
    }
    if ($area === 'admin' && $cleanPath === '/admin/login') {
        return is_file($root . DIRECTORY_SEPARATOR . 'admin/login.php') ? 'admin/login.php' : 'adminlogin.php';
    }
    if ($area === 'api' && $cleanPath === '/api/webhooks') {
        return 'api/webhooks/index.php';
    }

    if ($path === $prefix || $path === $prefix . '/') {
        $path = $prefix . '/index.php';
    } elseif (substr($path, -1) === '/') {
        $path .= 'index.php';
    } elseif (pathinfo($path, PATHINFO_EXTENSION) === '') {
        $phpCandidate = ltrim($path . '.php', '/');
        $indexCandidate = ltrim($path . '/index.php', '/');
        if (is_file($root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $phpCandidate))) {
            return $phpCandidate;
        }
        $path = '/' . $indexCandidate;
    }

    return ltrim($path, '/');
}

function dt_admin_audit_extract_urls(string $content, string $prefix): array
{
    $quotedPrefix = preg_quote($prefix, '~');
    $urls = [];
    if (preg_match_all('~[\'"`](' . $quotedPrefix . '(?:/[^\'"`\s<>)#?]*)?)(?:[?#][^\'"`\s<>)]*)?[\'"`]~i', $content, $matches)) {
        foreach ($matches[1] as $url) {
            $urls[$url] = true;
        }
    }

    if (preg_match_all('~\b(?:href|action)\s*=\s*["\'](' . $quotedPrefix . '(?:/[^"\'>\s#?]*)?)(?:[?#][^"\'>\s]*)?["\']~i', $content, $matches)) {
        foreach ($matches[1] as $url) {
            $urls[$url] = true;
        }
    }

    return array_keys($urls);
}

function dt_admin_audit_sidebar_items(string $content): array
{
    $items = [];
    if (!preg_match_all('~<a\b[^>]*href=["\']([^"\']+)["\'][^>]*>(.*?)</a>~is', $content, $matches, PREG_SET_ORDER)) {
        return $items;
    }

    foreach ($matches as $match) {
        $href = html_entity_decode($match[1], ENT_QUOTES, 'UTF-8');
        if (strpos($href, '/admin') !== 0) {
            continue;
        }

        $label = trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($match[2]), ENT_QUOTES, 'UTF-8')) ?? '');
        $items[] = [
            'href' => $href,
            'label' => $label,
        ];
    }

    return $items;
}

function dt_admin_audit_duplicates(array $files, string $root): array
{
    $hashes = [];
    foreach ($files as $file) {
        $hash = @md5_file($file);
        if (!is_string($hash)) {
            continue;
        }
        $hashes[$hash][] = dt_admin_audit_relative($root, $file);
    }

    $duplicates = [];
    foreach ($hashes as $hash => $paths) {
        if (count($paths) > 1) {
            $duplicates[] = [
                'hash' => $hash,
                'files' => $paths,
            ];
        }
    }

    return $duplicates;
}

function dt_admin_master_audit(?string $root = null): array
{
    $root = $root ? rtrim($root, "/\\") : dirname(__DIR__);
    $adminFiles = dt_admin_audit_files($root, 'admin', ['php', 'js']);
    $apiFiles = dt_admin_audit_files($root, 'api', ['php']);
    $cssFiles = dt_admin_audit_files($root, 'admin', ['css']);

    $adminUrls = [];
    $apiUrls = [];
    foreach ($adminFiles as $file) {
        $rel = dt_admin_audit_relative($root, $file);
        $content = (string)@file_get_contents($file);
        foreach (dt_admin_audit_extract_urls($content, '/admin') as $url) {
            $adminUrls[$url][$rel] = true;
        }
        foreach (dt_admin_audit_extract_urls($content, '/api') as $url) {
            $apiUrls[$url][$rel] = true;
        }
    }

    $missingAdminLinks = [];
    foreach ($adminUrls as $url => $sources) {
        $relTarget = dt_admin_audit_normalize_local_url($root, $url, 'admin');
        if ($relTarget === null) {
            continue;
        }
        if (!is_file($root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relTarget))) {
            $missingAdminLinks[] = [
                'url' => $url,
                'target' => $relTarget,
                'sources' => array_keys($sources),
            ];
        }
    }

    $missingApiRefs = [];
    foreach ($apiUrls as $url => $sources) {
        $relTarget = dt_admin_audit_normalize_local_url($root, $url, 'api');
        if ($relTarget === null) {
            continue;
        }
        if (!is_file($root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relTarget))) {
            $missingApiRefs[] = [
                'url' => $url,
                'target' => $relTarget,
                'sources' => array_keys($sources),
            ];
        }
    }

    $expectedApiMap = [
        '/api/admin_security.php',
        '/api/attributes.php',
        '/api/audit.php',
        '/api/brands.php',
        '/api/categories.php',
        '/api/content.php',
        '/api/coupons.php',
        '/api/customer_addresses.php',
        '/api/customer_notes.php',
        '/api/customers.php',
        '/api/health.php',
        '/api/integrations.php',
        '/api/media/delete.php',
        '/api/media/index.php',
        '/api/notifications.php',
        '/api/orders.php',
        '/api/payment/create_order.php',
        '/api/payment/verify.php',
        '/api/payments.php',
        '/api/products.php',
        '/api/reports.php',
        '/api/reviews.php',
        '/api/settings.php',
        '/api/shipping.php',
        '/api/system.php',
        '/api/upload.php',
        '/api/users.php',
        '/api/variants.php',
        '/api/whatsapp.php',
    ];

    $missingExpectedApi = [];
    foreach ($expectedApiMap as $url) {
        $relTarget = dt_admin_audit_normalize_local_url($root, $url, 'api');
        if ($relTarget === null || !is_file($root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relTarget))) {
            $missingExpectedApi[] = $url;
        }
    }

    $sidebarPath = $root . DIRECTORY_SEPARATOR . 'admin/includes/adminsidebar.php';
    $sidebarContent = is_file($sidebarPath) ? (string)file_get_contents($sidebarPath) : '';
    $sidebarItems = dt_admin_audit_sidebar_items($sidebarContent);
    $sidebarOptionCounts = [];
    foreach ($sidebarItems as $item) {
        $key = strtolower($item['href'] . '|' . $item['label']);
        $sidebarOptionCounts[$key][] = $item;
    }
    $duplicateSidebarOptions = array_values(array_filter($sidebarOptionCounts, static fn(array $items): bool => count($items) > 1));

    $layoutCss = '';
    foreach ($cssFiles as $file) {
        $layoutCss .= "\n" . (string)@file_get_contents($file);
    }
    $requiredCssSignals = [
        '.adm-layout',
        '.adm-sidebar',
        '.adm-main',
        '@media',
        'overflow-x: auto',
        'min-width: 0',
        'grid-template-columns',
        'flex-wrap',
    ];
    $missingCssSignals = [];
    foreach ($requiredCssSignals as $signal) {
        if (strpos($layoutCss, $signal) === false) {
            $missingCssSignals[] = $signal;
        }
    }

    $duplicateFiles = dt_admin_audit_duplicates(array_merge($adminFiles, $apiFiles), $root);

    $criticalCount = count($missingAdminLinks) + count($missingApiRefs) + count($missingExpectedApi) + count($missingCssSignals);

    return [
        'generated_at' => date('c'),
        'admin_files_scanned' => count($adminFiles),
        'api_files_scanned' => count($apiFiles),
        'css_files_scanned' => count($cssFiles),
        'admin_urls_seen' => count($adminUrls),
        'api_urls_seen' => count($apiUrls),
        'sidebar_options_seen' => count($sidebarItems),
        'missing_admin_links' => $missingAdminLinks,
        'missing_api_references' => $missingApiRefs,
        'missing_expected_api_files' => $missingExpectedApi,
        'missing_responsive_css_signals' => $missingCssSignals,
        'duplicate_sidebar_options' => $duplicateSidebarOptions,
        'duplicate_file_groups' => $duplicateFiles,
        'critical_count' => $criticalCount,
        'status' => $criticalCount === 0 ? 'pass' : 'fail',
    ];
}

if (realpath($_SERVER['SCRIPT_FILENAME'] ?? '') === __FILE__) {
    $result = dt_admin_master_audit();
    echo "DT Admin Master Audit\n";
    echo "Status: " . strtoupper((string)$result['status']) . "\n";
    echo "Admin files scanned: " . $result['admin_files_scanned'] . "\n";
    echo "API files scanned: " . $result['api_files_scanned'] . "\n";
    echo "CSS files scanned: " . $result['css_files_scanned'] . "\n";
    echo "Admin URLs seen: " . $result['admin_urls_seen'] . "\n";
    echo "API URLs seen: " . $result['api_urls_seen'] . "\n";
    echo "Sidebar options seen: " . $result['sidebar_options_seen'] . "\n";
    echo "Missing admin links: " . count($result['missing_admin_links']) . "\n";
    echo "Missing API references: " . count($result['missing_api_references']) . "\n";
    echo "Missing expected API files: " . count($result['missing_expected_api_files']) . "\n";
    echo "Missing responsive CSS signals: " . count($result['missing_responsive_css_signals']) . "\n";
    echo "Duplicate sidebar options: " . count($result['duplicate_sidebar_options']) . "\n";
    echo "Duplicate file groups: " . count($result['duplicate_file_groups']) . "\n";

    if ($result['critical_count'] > 0) {
        echo "\nCritical findings:\n";
        foreach (['missing_admin_links', 'missing_api_references', 'missing_expected_api_files', 'missing_responsive_css_signals'] as $key) {
            foreach ($result[$key] as $finding) {
                echo "- {$key}: " . (is_array($finding) ? json_encode($finding, JSON_UNESCAPED_SLASHES) : $finding) . "\n";
            }
        }
    }

    exit($result['critical_count'] === 0 ? 0 : 1);
}
