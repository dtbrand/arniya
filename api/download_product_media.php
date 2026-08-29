<?php
/**
 * api/download_product_media.php — High-Performance Product Media ZIP Downloader
 * DT Brand's & Jai Hanuman Tex
 * 
 * Bundles all HD product photos, videos, and product details into a single
 * downloadable ZIP package in 1 click (or provides JSON metadata).
 */

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if (empty($_GET) && !empty($_SERVER['QUERY_STRING'])) {
    parse_str($_SERVER['QUERY_STRING'], $_GET);
}

$mode = isset($_GET['mode']) ? trim($_GET['mode']) : 'zip'; // 'zip' or 'json'

try {
    require_once __DIR__ . '/../src/Database.php';
    require_once __DIR__ . '/../src/ProductCatalog.php';

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $sku = isset($_GET['sku']) ? trim($_GET['sku']) : '';

    $product = null;
    if ($id > 0) {
        $product = \DTBrand\ProductCatalog::getById($id);
    } elseif (!empty($sku)) {
        $product = \DTBrand\ProductCatalog::getBySku($sku);
    }

    if (!$product) {
        if ($mode === 'json') {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Product not found']);
            exit;
        }
        http_response_code(404);
        die('Product not found.');
    }

    // ── Collect all photos & videos ──
    $name = (string)($product['name'] ?? 'Product');
    $slug = preg_replace('/[^a-z0-9]+/i', '-', strtolower(trim($name)));
    $slug = trim($slug, '-') ?: 'product';

    $images = [];
    $videos = [];

    // Raw images
    $rawImages = array_merge(
        (array)($product['gallery'] ?? []),
        (array)($product['images'] ?? []),
        [!empty($product['image']) ? $product['image'] : '']
    );

    foreach ($rawImages as $img) {
        $img = trim((string)$img);
        if ($img === '' || strpos($img, 'no-image.svg') !== false || substr($img, 0, 5) === 'data:') {
            continue;
        }
        if (!in_array($img, $images, true)) {
            $images[] = $img;
        }
    }

    // Raw videos
    $rawVideos = array_merge(
        (array)($product['videos'] ?? []),
        [!empty($product['video']) ? $product['video'] : '']
    );

    foreach ($rawVideos as $vid) {
        $vid = trim((string)$vid);
        if ($vid === '' || substr($vid, 0, 5) === 'data:') {
            continue;
        }
        if (!in_array($vid, $videos, true)) {
            $videos[] = $vid;
        }
    }

    // Build text details content
    $price = (float)($product['price'] ?? 0);
    $oldPrice = (float)($product['old_price'] ?? 0);
    $discount = (int)($product['discount'] ?? 0);

    $txt = "========================================================\r\n";
    $txt .= "👑 DT BRAND'S — ETHNIC LUXURY COUTURE\r\n";
    $txt .= "========================================================\r\n\r\n";
    $txt .= "✨ Product Name: " . $name . "\r\n";
    if (!empty($product['sku'])) $txt .= "🏷️ SKU: " . $product['sku'] . "\r\n";
    if (!empty($product['category'])) $txt .= "📂 Category: " . $product['category'] . "\r\n";
    if ($price > 0) {
        $txt .= "💰 Deal Price: Rs. " . number_format($price);
        if ($oldPrice > $price) {
            $txt .= " (MRP: Rs. " . number_format($oldPrice) . ")";
            if ($discount > 0) $txt .= " [" . $discount . "% OFF]";
        }
        $txt .= "\r\n";
    } else {
        $txt .= "💰 Price: On Request\r\n";
    }
    if (!empty($product['fabric'])) $txt .= "🧵 Fabric: " . $product['fabric'] . "\r\n";
    if (!empty($product['colors'])) {
        $colorsStr = is_array($product['colors']) ? implode(', ', $product['colors']) : $product['colors'];
        $txt .= "🎨 Colors: " . $colorsStr . "\r\n";
    }
    if (!empty($product['sizes'])) {
        $sizesStr = is_array($product['sizes']) ? implode(', ', $product['sizes']) : $product['sizes'];
        $txt .= "📏 Sizes: " . $sizesStr . "\r\n";
    }
    if (!empty($product['description'])) {
        $txt .= "\r\n📝 Description:\r\n" . strip_tags($product['description']) . "\r\n";
    }

    $txt .= "\r\n--------------------------------------------------------\r\n";
    $txt .= "🌟 Highlights:\r\n";
    $txt .= "• 100% Original Certified Handloom Heritage\r\n";
    $txt .= "• Fast Express Delivery (Dispatched in 24-48 Hours)\r\n";
    $txt .= "• 7-Day Fast Doorstep Exchange\r\n";
    $txt .= "• Complimentary Royal Box Packaging\r\n";
    $txt .= "--------------------------------------------------------\r\n";
    $txt .= "🔗 View Online: https://jaihanumantex.in/product.php?id=" . (int)$product['id'] . "\r\n";
    $txt .= "💬 Order on WhatsApp: +91 70463 63528\r\n";

    if ($mode === 'json') {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => true,
            'id' => (int)$product['id'],
            'name' => $name,
            'slug' => $slug,
            'images' => $images,
            'videos' => $videos,
            'total_media' => count($images) + count($videos),
            'details_text' => $txt
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    // ── Build & Stream ZIP Archive ──
    $zipFilename = $slug . '-Catalog-Media.zip';
    $rootDir = realpath(__DIR__ . '/..');

    if (class_exists('ZipArchive')) {
        $zip = new \ZipArchive();
        $tmpFile = tempnam(sys_get_temp_dir(), 'dt_media_');

        if ($zip->open($tmpFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            // Add product details text
            $zip->addFromString('Product-Details.txt', $txt);

            // Helper to resolve and add media
            $addMediaFile = function($url, $suggestedName) use ($zip, $rootDir) {
                $cleanUrl = strtok($url, '?');
                $ext = strtolower(pathinfo($cleanUrl, PATHINFO_EXTENSION));
                if (!$ext) $ext = 'jpg';

                $entryName = $suggestedName . '.' . $ext;

                // Try local file path first
                $localPath = null;
                if (substr($url, 0, 1) === '/') {
                    $candidate = $rootDir . $cleanUrl;
                    if (file_exists($candidate) && is_readable($candidate)) {
                        $localPath = $candidate;
                    }
                } elseif (substr($url, 0, 7) !== 'http://' && substr($url, 0, 8) !== 'https://') {
                    $candidate = $rootDir . '/' . ltrim($cleanUrl, '/');
                    if (file_exists($candidate) && is_readable($candidate)) {
                        $localPath = $candidate;
                    }
                }

                if ($localPath) {
                    $zip->addFile($localPath, $entryName);
                    return true;
                }

                // Fetch via HTTP if remote
                if (substr($url, 0, 7) === 'http://' || substr($url, 0, 8) === 'https://') {
                    $ctx = stream_context_create([
                        'http' => ['timeout' => 5, 'ignore_errors' => true],
                        'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
                    ]);
                    $content = @file_get_contents($url, false, $ctx);
                    if ($content !== false && strlen($content) > 0) {
                        $zip->addFromString($entryName, $content);
                        return true;
                    }
                }
                return false;
            };

            // Add photos
            foreach ($images as $idx => $imgUrl) {
                $addMediaFile($imgUrl, $slug . '-' . ($idx + 1));
            }

            // Add videos
            foreach ($videos as $idx => $vidUrl) {
                $addMediaFile($vidUrl, $slug . '-video-' . ($idx + 1));
            }

            $zip->close();

            if (file_exists($tmpFile) && filesize($tmpFile) > 0) {
                header('Content-Type: application/zip');
                header('Content-Disposition: attachment; filename="' . $zipFilename . '"');
                header('Content-Length: ' . filesize($tmpFile));
                header('Cache-Control: no-cache, no-store, must-revalidate');
                header('Pragma: no-cache');
                header('Expires: 0');
                readfile($tmpFile);
                @unlink($tmpFile);
                exit;
            }
        }
    }

    // Fallback: If only 1 image, redirect to it
    if (count($images) === 1 && empty($videos)) {
        $targetImg = $images[0];
        if (substr($targetImg, 0, 1) === '/') {
            $proto = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
            $targetImg = $proto . '://' . $_SERVER['HTTP_HOST'] . $targetImg;
        }
        header('Location: ' . $targetImg);
        exit;
    }

    // Output JSON list of media if ZIP couldn't be generated
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
        'success' => true,
        'id' => (int)$product['id'],
        'name' => $name,
        'slug' => $slug,
        'images' => $images,
        'videos' => $videos,
        'details_text' => $txt
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

} catch (\Throwable $e) {
    if ($mode === 'json') {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Internal server error: ' . $e->getMessage()
        ], JSON_PRETTY_PRINT);
        exit;
    }
    http_response_code(500);
    die('Error processing download request.');
}
