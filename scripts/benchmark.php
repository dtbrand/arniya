<?php
/**
 * benchmark.php — DT Brand's Performance Benchmarking Tool
 * DT Brand's & Jai Hanuman Tex
 */

function measureEndpoint(string $url): array {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (BenchmarkTool)');
    
    $startTime = microtime(true);
    $response = curl_exec($ch);
    $endTime = microtime(true);
    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $totalTimeMs = round(curl_getinfo($ch, CURLINFO_TOTAL_TIME) * 1000, 2);
    $ttfbMs = round(curl_getinfo($ch, CURLINFO_STARTTRANSFER_TIME) * 1000, 2);
    $connectTimeMs = round(curl_getinfo($ch, CURLINFO_CONNECT_TIME) * 1000, 2);
    $size = strlen($response);
    curl_close($ch);

    return [
        'url' => $url,
        'http_code' => $httpCode,
        'ttfb_ms' => $ttfbMs,
        'connect_ms' => $connectTimeMs,
        'total_ms' => $totalTimeMs,
        'size_kb' => round($size / 1024, 2),
    ];
}

$sampleProductId = 13;
if (file_exists(__DIR__ . '/../src/ProductCatalog.php')) {
    require_once __DIR__ . '/../src/ProductCatalog.php';
    try {
        $all = \DTBrand\ProductCatalog::getAll();
        if (!empty($all[0]['id'])) {
            $sampleProductId = (int)$all[0]['id'];
        }
    } catch (\Throwable $e) {}
}

$baseUrl = getenv('BASE_URL') ?: 'https://jaihanumantex.in';

$endpoints = [
    'Homepage (Storefront)'      => "{$baseUrl}/index.php",
    'Shop Product Grid'          => "{$baseUrl}/shop.php",
    'Single Product Saree (PDP)' => "{$baseUrl}/product.php?id={$sampleProductId}",
    'Wholesale B2B Portal'       => "{$baseUrl}/wholesale.php",
    'Retailer B2B Portal'        => "{$baseUrl}/retailer.php",
    'Reseller B2B Portal'        => "{$baseUrl}/reseller.php",
    'Shopping Cart'              => "{$baseUrl}/cart.php",
    'Checkout Gateway'           => "{$baseUrl}/checkout.php",
    'Admin Login Console'        => "{$baseUrl}/admin/login/",
    'System Health Endpoint'     => "{$baseUrl}/health.php",
];

echo "\n========================================================================================\n";
echo "           👑 DT BRAND'S LIVE PRODUCTION ENDPOINT PERFORMANCE BENCHMARK\n";
echo "========================================================================================\n";
printf("%-28s | %-6s | %10s | %10s | %10s\n", "Endpoint Name", "HTTP", "TTFB (ms)", "Total (ms)", "Size (KB)");
echo "-----------------------------+--------+------------+------------+------------\n";

$times = [];
$sizes = [];

foreach ($endpoints as $name => $url) {
    $res = measureEndpoint($url);
    $times[] = $res['total_ms'];
    $sizes[] = $res['size_kb'];
    printf(
        "%-28s | %-6d | %8.2f ms | %8.2f ms | %8.2f KB\n",
        $name,
        $res['http_code'],
        $res['ttfb_ms'],
        $res['total_ms'],
        $res['size_kb']
    );
}

$avgTime = count($times) > 0 ? array_sum($times) / count($times) : 0;
$minTime = count($times) > 0 ? min($times) : 0;
$maxTime = count($times) > 0 ? max($times) : 0;
$totalKb = array_sum($sizes);

echo "========================================================================================\n";
printf("Summary: Endpoints Tested: %d | Avg Latency: %.2f ms (Min: %.2f ms, Max: %.2f ms)\n", count($endpoints), $avgTime, $minTime, $maxTime);
printf("Total Transferred Payload: %.2f KB across all audited routes\n", $totalKb);
echo "========================================================================================\n\n";
