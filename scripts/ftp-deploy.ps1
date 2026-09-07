<#>
.SYNOPSIS
    FTP Deploy to Hostinger Live Server for DT Brand's & Jai Hanuman Tex
.DESCRIPTION
    Uploads all modified/new files to the live server via FTP using FtpWebRequest for better control.
    Usage: powershell -ExecutionPolicy Bypass -File scripts\ftp-deploy.ps1
#>

# ─── FTP CONFIGURATION (Updated for harmitethnic.com) ───
$ftpConfig = @{
    Host      = '147.93.99.134'
    Port      = 21
    User      = 'u602484543.harmitethnic.com'
    Pass      = 'Gautam@9006'
    RemoteDir = '/'        # FTP root IS public_html on this server
    LocalDir  = 'C:\Users\sai\Desktop\DT Reseller HUB'
}

# ─── Files to DEPLOY (from git status + new files) ───
$deployItems = @(
    'Shared/Auth/logout.php'
    'admin/includes/adminheader.php'
    'admin/index.php'
    'admin/login.php'
    'admin/orders/assets/js/order-status.js'
    'admin/orders/index.php'
    'admin/products/index.php'
    'api/attributes.php'
    'api/auth.php'
    'api/auth/index.php'
    'api/brands.php'
    'api/cart.php'
    'api/categories.php'
    'api/coupons.php'
    'api/customers.php'
    'api/download_product_media.php'
    'api/notifications.php'
    'api/orders.php'
    'api/payment/verify.php'
    'api/payments.php'
    'api/products.php'
    'api/reseller.php'
    'api/retailer.php'
    'api/reviews.php'
    'api/search.php'
    'api/shipping.php'
    'api/upload.php'
    'api/users.php'
    'api/variants.php'
    'api/whatsapp.php'
    'api/wholesale.php'
    'api/wishlist.php'
    'api/cors.php'
    'api/payments/cashfree_webhook.php'
    'api/payments/razorpay_webhook.php'
    'api/payments/upi_status.php'
    'api/payments/upi_verify.php'
    'database/migrations/2026_08_30_000001_add_brands_and_admin_tables.sql'
    'database/migrations/2026_09_02_000001_create_payment_gateways_and_webhooks.sql'
    'database/migrations/2026_09_07_000001_add_missing_columns_indexes_and_fixes.sql'
    'install.php'
    'logout.php'
    'src/Auth.php'
    'config/session.php'
    'scripts/build-deploy-zip.php'
    'scripts/build-deploy-zip.ps1'
    'scripts/test-paths.ps1'
    'src/RateLimiter.php'
    'db_reset_migrations.php'
)

$cred = New-Object System.Net.NetworkCredential($ftpConfig.User, $ftpConfig.Pass)
$baseUrl = "ftp://$($ftpConfig.Host):$($ftpConfig.Port)$($ftpConfig.RemoteDir)"

function Ftp-MakeDir {
    param($dirUrl)
    try {
        $req = [System.Net.FtpWebRequest]::Create($dirUrl)
        $req.Credentials = $cred
        $req.Method = [System.Net.WebRequestMethods+Ftp]::MakeDirectory
        $req.UsePassive = $true
        $req.UseBinary = $true
        $req.GetResponse().Close()
        return $true
    } catch {
        return $false
    }
}

function Ftp-UploadFile {
    param($remoteUrl, $localPath)
    try {
        $req = [System.Net.FtpWebRequest]::Create($remoteUrl)
        $req.Credentials = $cred
        $req.Method = [System.Net.WebRequestMethods+Ftp]::UploadFile
        $req.UsePassive = $true
        $req.UseBinary = $true
        $fileContent = [System.IO.File]::ReadAllBytes($localPath)
        $req.ContentLength = $fileContent.Length
        $stream = $req.GetRequestStream()
        $stream.Write($fileContent, 0, $fileContent.Length)
        $stream.Close()
        $req.GetResponse().Close()
        return $true
    } catch {
        return $false
    }
}

# ─── Pre-create required directories ───
$requiredDirs = @(
    '/scripts/'
    '/api/payments/'
    '/api/payment/'
    '/admin/orders/assets/js/'
    '/admin/includes/'
    '/Shared/Auth/'
    '/database/migrations/'
    '/config/'
    '/src/'
)

Write-Host "============================================================" -ForegroundColor Cyan
Write-Host " DT BRAND'S FTP DEPLOYMENT TO HOSTINGER (harmitethnic.com)" -ForegroundColor Cyan
Write-Host "============================================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Target: $($ftpConfig.User)@$($ftpConfig.Host):$($ftpConfig.Port)" -ForegroundColor Gray
Write-Host "Remote: $($ftpConfig.RemoteDir) (FTP root = public_html)" -ForegroundColor Gray
Write-Host "Local:  $($ftpConfig.LocalDir)" -ForegroundColor Gray
Write-Host ""

Write-Host "Pre-creating required directories..." -ForegroundColor Cyan
foreach ($dir in $requiredDirs) {
    $dirUrl = $baseUrl + $dir
    if (Ftp-MakeDir $dirUrl) {
        Write-Host "  Created: $dir" -ForegroundColor Green
    } else {
        Write-Host "  Exists: $dir" -ForegroundColor Gray
    }
}
Write-Host ""

$uploaded = 0; $failed = 0; $skipped = 0
Write-Host "Uploading files..." -ForegroundColor Cyan

foreach ($item in $deployItems) {
    $localPath = Join-Path $ftpConfig.LocalDir $item
    $remotePath = $baseUrl + $item
    
    if (-not (Test-Path $localPath -PathType Leaf)) {
        Write-Host "  Skip: $item" -ForegroundColor Yellow; $skipped++; continue
    }
    
    Write-Host "  $item" -NoNewline
    if (Ftp-UploadFile $remotePath $localPath) {
        Write-Host " OK" -ForegroundColor Green; $uploaded++
    } else {
        Write-Host " FAIL" -ForegroundColor Red; $failed++
    }
}

Write-Host ""
Write-Host "============================================================" -ForegroundColor Cyan
Write-Host " FTP DEPLOYMENT COMPLETE" -ForegroundColor Green
Write-Host "============================================================" -ForegroundColor Cyan
Write-Host "Uploaded: $uploaded  Failed: $failed  Skipped: $skipped"
Write-Host "============================================================" -ForegroundColor Cyan

if ($failed -gt 0) { Write-Host "Some uploads failed." -ForegroundColor Red; exit 1 }
Write-Host "All deployed! Next: visit /install.php, test /admin/whatsapp/" -ForegroundColor Green