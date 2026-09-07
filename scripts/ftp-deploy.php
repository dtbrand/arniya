<?php
/**
 * scripts/ftp-deploy.php — FTP Deploy to Hostinger Live Server
 * DT Brand's & Jai Hanuman Tex
 * 
 * Uploads all modified/new files to the live server via FTP.
 * Usage: php scripts/ftp-deploy.php
 */

declare(strict_types=1);

// ─── FTP CONFIGURATION (from AGENTS.md) ───
$ftpConfig = [
    'host'      => '147.93.99.134',
    'port'      => 21,
    'user'      => 'u602484543.jaihanumantex.in',
    'pass'      => 'Gautam@9006',
    'remoteDir' => '/public_html',
    'localDir'  => dirname(__DIR__), // C:\Users\sai\Desktop\DT Reseller HUB
];

// ─── Files to DEPLOY (from git status - all M = modified, ?? = new) ───
$deployItems = [
    // Modified Shared
    'Shared/Auth/logout.php',
    
    // Modified Admin
    'admin/includes/adminheader.php',
    'admin/index.php',
    'admin/login.php',
    'admin/orders/assets/js/order-status.js',
    'admin/orders/index.php',
    'admin/products/index.php',
    
    // Modified API - Core
    'api/attributes.php',
    'api/auth.php',
    'api/auth/index.php',
    'api/brands.php',
    'api/cart.php',
    'api/categories.php',
    'api/coupons.php',
    'api/customers.php',
    'api/download_product_media.php',
    'api/notifications.php',
    'api/orders.php',
    'api/payment/verify.php',
    'api/payments.php',
    'api/products.php',
    'api/reseller.php',
    'api/retailer.php',
    'api/reviews.php',
    'api/search.php',
    'api/shipping.php',
    'api/upload.php',
    'api/users.php',
    'api/variants.php',
    'api/whatsapp.php',
    'api/wholesale.php',
    'api/wishlist.php',
    
    // New API files
    'api/cors.php',
    'api/payments/cashfree_webhook.php',
    'api/payments/razorpay_webhook.php',
    'api/payments/upi_status.php',
    'api/payments/upi_verify.php',
    
    // Modified Config
    'config/database.php',
    
    // Modified Migrations
    'database/migrations/2026_08_30_000001_add_brands_and_admin_tables.sql',
    'database/migrations/2026_09_02_000001_create_payment_gateways_and_webhooks.sql',
    'database/migrations/2026_09_07_000001_add_missing_columns_indexes_and_fixes.sql',
    
    // Modified Root files
    'install.php',
    'logout.php',
    
    // Modified Scripts
    'scripts/benchmark.php',
    'scripts/build-deploy-folder.php',
    'scripts/uptime-check.php',
    
    // Modified Source
    'src/Auth.php',
    'src/Database.php',
    
    // New files
    'config/session.php',
    'db_reset_migrations.php',
    'dt_debug.php',
    'dt_install_direct.php',
    'includes/bootstrap.php',
    'scripts/build-deploy-zip.php',
    'scripts/build-deploy-zip.ps1',
    'scripts/ftp-deploy.ps1',
    'scripts/test-paths.ps1',
    'src/RateLimiter.php',
    
    // New scripts (this one)
    'scripts/ftp-deploy.php',
    'scripts/comprehensive-test.php',
];

// ─── Directories to ensure exist on remote ───
$remoteDirs = [
    '/public_html/Shared/Auth',
    '/public_html/admin/includes',
    '/public_html/admin/orders/assets/js',
    '/public_html/admin/orders',
    '/public_html/admin/products',
    '/public_html/api/auth',
    '/public_html/api/payment',
    '/public_html/api/payments',
    '/public_html/api',
    '/public_html/config',
    '/public_html/database/migrations',
    '/public_html/scripts',
    '/public_html/src',
    '/public_html/includes',
];

echo "═══════════════════════════════════════════════════════════════\n";
echo " DT BRAND'S FTP DEPLOYMENT TO HOSTINGER LIVE SERVER\n";
echo "═══════════════════════════════════════════════════════════════\n\n";
echo "Target: {$ftpConfig['user']}@{$ftpConfig['host']}:{$ftpConfig['port']}\n";
echo "Remote: {$ftpConfig['remoteDir']}\n";
echo "Local:  {$ftpConfig['localDir']}\n\n";

// ─── Connect to FTP ───
echo "Connecting to FTP...\n";
$conn = ftp_connect($ftpConfig['host'], $ftpConfig['port'], 30);
if (!$conn) {
    die("❌ Failed to connect to FTP server.\n");
}

echo "Logging in...\n";
if (!ftp_login($conn, $ftpConfig['user'], $ftpConfig['pass'])) {
    ftp_close($conn);
    die("❌ FTP login failed. Check credentials.\n");
}

ftp_pasv($conn, true);
echo "✅ Connected and logged in successfully.\n\n";

// ─── Ensure remote directories exist ───
echo "Creating remote directories...\n";
foreach ($remoteDirs as $dir) {
    // Try to create directory recursively
    $parts = explode('/', trim($dir, '/'));
    $current = '';
    foreach ($parts as $part) {
        $current .= '/' . $part;
        // Try to chdir - if fails, create
        if (!@ftp_chdir($conn, $current)) {
            if (!@ftp_mkdir($conn, $current)) {
                echo "  ⚠ Could not create: {$current}\n";
            } else {
                echo "  ✓ Created: {$current}\n";
            }
        }
    }
    // Reset to root
    ftp_chdir($conn, '/');
}
echo "\n";

// ─── Upload files ───
$uploaded = 0;
$failed = 0;
$skipped = 0;

echo "Uploading files...\n";
foreach ($deployItems as $item) {
    $localPath = $ftpConfig['localDir'] . '/' . $item;
    $remotePath = $ftpConfig['remoteDir'] . '/' . $item;
    
    if (!file_exists($localPath)) {
        echo "  ⏭ Skipped (not found locally): {$item}\n";
        $skipped++;
        continue;
    }
    
    // Ensure remote directory exists
    $remoteDir = dirname($remotePath);
    $parts = explode('/', trim($remoteDir, '/'));
    $current = '';
    foreach ($parts as $part) {
        $current .= '/' . $part;
        @ftp_chdir($conn, $current) || @ftp_mkdir($conn, $current);
    }
    ftp_chdir($conn, '/');
    
    // Upload
    if (ftp_put($conn, $remotePath, $localPath, FTP_BINARY)) {
        echo "  ✓ Uploaded: {$item}\n";
        $uploaded++;
    } else {
        echo "  ❌ Failed: {$item}\n";
        $failed++;
    }
}

ftp_close($conn);

echo "\n═══════════════════════════════════════════════════════════════\n";
echo " FTP DEPLOYMENT COMPLETE\n";
echo "═══════════════════════════════════════════════════════════════\n";
echo "Uploaded: {$uploaded} files\n";
echo "Failed:   {$failed} files\n";
echo "Skipped:  {$skipped} files (not found locally)\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

if ($failed > 0) {
    echo "⚠ Some files failed to upload. Check FTP connection and permissions.\n";
    exit(1);
}

echo "✅ All files deployed successfully to live server!\n";
echo "\nNext steps:\n";
echo "  1. Visit https://jaihanumantex.in/install.php (if first deploy)\n";
echo "  2. Or run database migrations if updating\n";
echo "  3. Clear browser cache and test all flows\n";
echo "  4. Verify WhatsApp CRM at /admin/whatsapp/\n";