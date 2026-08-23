<?php
/**
 * benchmark.php — DT Brand's Performance Benchmarking Tool
 * DT Brand's & Jai Hanuman Tex
 */

function measureEndpoint(string $url): array {
    $startTime = microtime(true);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $endTime = microtime(true);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $totalTime = ($endTime - $startTime) * 1000; // ms
    $size = strlen($response);
    curl_close($ch);

    return [
        'url' => $url,
        'http_code' => $httpCode,
        'time_ms' => round($totalTime, 2),
        'size_kb' => round($size / 1024, 2),
    ];
}

$endpoints = [
    'https://jaihanumantex.in/Frontend/Home/home.php',
    'https://jaihanumantex.in/Frontend/Shop/shop.php',
    'https://jaihanumantex.in/Frontend/Single-Product/singleproduct.php',
    'https://jaihanumantex.in/Frontend/Admin/adminlogin.php',
    'https://jaihanumantex.in/health.php',
];

echo "=== DT Brand's Endpoint Performance Benchmark ===\n";
foreach ($endpoints as $url) {
    $result = measureEndpoint($url);
    echo sprintf("[%d] %-60s | %8.2f ms | %6.2f KB\n", $result['http_code'], $result['url'], $result['time_ms'], $result['size_kb']);
}
