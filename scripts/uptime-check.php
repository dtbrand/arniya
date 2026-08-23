<?php
/**
 * uptime-check.php — Production Uptime & Endpoint Readiness Health Sentinel
 * DT Brand's & Jai Hanuman Tex
 */

$endpoints = [
    'Homepage' => 'https://jaihanumantex.in/Frontend/Home/home.php',
    'Shop Catalog' => 'https://jaihanumantex.in/Frontend/Shop/shop.php',
    'Single Saree' => 'https://jaihanumantex.in/Frontend/Single-Product/singleproduct.php',
    'Admin Portal' => 'https://jaihanumantex.in/Frontend/Admin/adminlogin.php',
    'Health Check' => 'https://jaihanumantex.in/health.php',
];

$failed = [];
echo "=== DT Brand's Production Uptime Sentinel ===\n";

foreach ($endpoints as $name => $url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $body = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($status === 200) {
        echo " [OK 200] {$name} ({$url})\n";
    } else {
        echo " [FAIL {$status}] {$name} ({$url})\n";
        $failed[] = "{$name} (HTTP {$status})";
    }
}

if (!empty($failed)) {
    echo "ALERT: " . count($failed) . " endpoint(s) failed health verification!\n";
    exit(1);
} else {
    echo "SUCCESS: All endpoints responding healthy (100% Uptime).\n";
    exit(0);
}
