<#>
.SYNOPSIS
    Build Production Deployment ZIP for DT Brand's & Jai Hanuman Tex
.DESCRIPTION
    Creates a clean, production-ready ZIP package for Hostinger deployment.
    Includes all source code, migrations, install.php, and assets.
    Excludes dev files, tests, node_modules, vendor, backups, etc.
.EXAMPLE
    powershell -ExecutionPolicy Bypass -File scripts\build-deploy-zip.ps1
#>

param()

$scriptDir = Split-Path $PSScriptRoot
$basePath = Split-Path $scriptDir  # Project root (parent of scripts folder)
$timestamp = Get-Date -Format "yyyyMMdd_HHmmss"
$deployName = "DT_Brand_Deploy_$timestamp"
$zipPath = "C:\Users\sai\Desktop\$deployName.zip"

# ─── Exclusion lists (script-level variables) ───
$script:excludeDirs = @(
    'node_modules',
    'vendor',
    '.git',
    'backups',
    'scratch',
    'logs',
    'test-results',
    '.vscode',
    '.uix',
    '.agents',
    '.github'
)

$script:excludeFiles = @(
    'README.md',
    'phpstan.neon',
    'phpunit.xml',
    'eslint.config.js',
    '.stylelintrc.json',
    '.prettierrc',
    '.prettierignore',
    '.hintrc',
    '.shellcheckrc',
    'commitlint.config.js',
    'release-please-config.json',
    'renovate.json',
    'lighthouserc.js',
    '.release-please-manifest.json',
    '.hadolint.yaml',
    '.browserslistrc',
    '.editorconfig',
    '.gitignore',
    'CSP_CONFIG.md',
    'DT_BRAND_MASTER_DESIGN_SYSTEM.md',
    'GEMINI.md',
    'MASTER_ARCHITECTURE_AUDIT.md',
    'DT_Brand_Deployment_*.zip',
    'image.png',
    'AGENTS.md'
)

$script:excludeExtensions = @('log', 'tmp', 'cache', 'bak', 'orig', 'map')

function Should-Skip {
    param($relPath, $baseName)
    foreach ($pattern in $script:excludeFiles) {
        if ($pattern -eq $baseName) { return $true }
        if ($pattern -like '*' -and $baseName -like $pattern) { return $true }
    }
    $ext = [System.IO.Path]::GetExtension($baseName).TrimStart('.').ToLower()
    if ($script:excludeExtensions -contains $ext) { return $true }
    return $false
}

# ─── Main ───
Write-Host "═══════════════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host " DT BRAND'S DEPLOYMENT ZIP BUILDER" -ForegroundColor Cyan
Write-Host "═══════════════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""

$basePath = $scriptDir
$timestamp = Get-Date -Format "yyyyMMdd_HHmmss"
$deployName = "DT_Brand_Deploy_$timestamp"
$zipPath = "C:\Users\sai\Desktop\$deployName.zip"

Write-Host "Source: $basePath" -ForegroundColor Gray
Write-Host "Output: $zipPath" -ForegroundColor Gray
Write-Host ""

# ─── Cleanup any existing ZIP ───
if (Test-Path $zipPath) {
    Remove-Item $zipPath -Force
    Write-Host "Removed existing ZIP." -ForegroundColor Yellow
}

# ─── Files/Directories to INCLUDE ───
$includeDirs = @(
    'admin',
    'api',
    'assets',
    'config',
    'database',
    'includes',
    'src',
    'Shared',
    'storage',
    'public'
)

$rootFiles = @(
    'index.php',
    'about-us.php',
    'account.php',
    'cart.php',
    'checkout.php',
    'contact.php',
    'health.php',
    'install.php',
    'logout.php',
    'privacy.php',
    'product.php',
    'reseller.php',
    'retailer.php',
    'shipping.php',
    'shop.php',
    'terms.php',
    'wholesale.php',
    'wishlist.php',
    '.env.example',
    '.htaccess',
    'README.md',
    'composer.json',
    'composer.lock'
)

$script:count = 0
$script:bytes = 0
$script:skipped = 0

# ─── Create temporary directory structure ───
$tempDir = [System.IO.Path]::Combine([System.IO.Path]::GetTempPath(), "dt_deploy_$timestamp")
if (Test-Path $tempDir) { Remove-Item $tempDir -Recurse -Force }
New-Item -ItemType Directory -Path $tempDir | Out-Null

Write-Host "Building deployment package..." -ForegroundColor Cyan

# ─── Process directories ───
foreach ($dir in $includeDirs) {
    $from = Join-Path $basePath $dir
    if (-not (Test-Path $from -PathType Container)) {
        Write-Host "  WARNING: Directory not found: $dir" -ForegroundColor Yellow
        continue
    }
    
    $files = Get-ChildItem -Path $from -Recurse -File | Where-Object { -not $_.PSIsContainer }
    
    foreach ($file in $files) {
        $rel = $dir + '/' + ($file.FullName.Substring($from.Length + 1)).Replace('\', '/')
        $base = $file.Name
        $parent = Split-Path $rel
        
        # Skip dev docs inside module subfolders
        if ($base -eq 'README.md' -and $parent -ne $dir) { continue }
        
        # Skip excluded directories
        $pathParts = $rel.Split('/')
        $skipDir = $false
        foreach ($part in $pathParts) {
            if ($script:excludeDirs -contains $part) {
                $skipDir = $true
                break
            }
        }
        if ($skipDir) { $script:skipped++; continue }
        
        # Check file exclusion
        $baseName = $file.Name
        $skipFile = $false
        foreach ($pattern in $script:excludeFiles) {
            if ($pattern -eq $baseName) { $skipFile = $true; break }
            if ($pattern -like '*' -and $baseName -like $pattern) { $skipFile = $true; break }
        }
        if ($skipFile) { $script:skipped++; continue }
        
        $ext = [System.IO.Path]::GetExtension($baseName).TrimStart('.').ToLower()
        if ($script:excludeExtensions -contains $ext) { $script:skipped++; continue }
        
        $target = Join-Path $tempDir $rel
        $targetDir = Split-Path $target
        if (-not (Test-Path $targetDir)) { New-Item -ItemType Directory -Path $targetDir | Out-Null }
        
        Copy-Item $file.FullName -Destination $target -Force
        $script:count++
        $script:bytes += $file.Length
    }
}

# ─── Root-level files ───
foreach ($name in $rootFiles) {
    $from = Join-Path $basePath $name
    if (Test-Path $from -PathType Leaf) {
        $skipFile = $false
        foreach ($pattern in $script:excludeFiles) {
            if ($pattern -eq $name) { $skipFile = $true; break }
            if ($pattern -like '*' -and $name -like $pattern) { $skipFile = $true; break }
        }
        if ($skipFile) { $script:skipped++; continue }
        
        $target = Join-Path $tempDir $name
        Copy-Item $from -Destination $target -Force
        $script:count++
        $script:bytes += (Get-Item $from).Length
    } else {
        Write-Host "  WARNING: Root file not found: $name" -ForegroundColor Yellow
    }
}

# ─── Create writable runtime directories with .gitkeep ───
$writableDirs = @('storage/logs', 'assets/images/uploads')
foreach ($w in $writableDirs) {
    $targetDir = Join-Path $tempDir $w
    New-Item -ItemType Directory -Path $targetDir -Force | Out-Null
    New-Item -ItemType File -Path (Join-Path $targetDir '.gitkeep') -Force | Out-Null
    $script:count += 2
}

# ─── Create ZIP using .NET ZipFile (System.IO.Compression) ───
Write-Host "Creating ZIP archive..." -ForegroundColor Cyan

# Load the compression assembly
Add-Type -AssemblyName System.IO.Compression.FileSystem

# Create ZIP using .NET ZipFile class - most reliable method
[System.IO.Compression.ZipFile]::CreateFromDirectory($tempDir, $zipPath, [System.IO.Compression.CompressionLevel]::Optimal, $false)

# Cleanup temp directory
Remove-Item $tempDir -Recurse -Force -ErrorAction SilentlyContinue

$sizeMB = [Math]::Round($script:bytes / 1048576, 2)

Write-Host ""
Write-Host "═══════════════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host " BUILD COMPLETE" -ForegroundColor Green
Write-Host "═══════════════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host "Files included: $($script:count)"
Write-Host "Files skipped:  $($script:skipped)"
Write-Host "Total size:     $sizeMB MB"
Write-Host "Output:         $zipPath"
Write-Host "══════════════════════════════════════════════════════════════" -ForegroundColor Cyan
Write-Host ""

Write-Host "DEPLOYMENT CHECKLIST:" -ForegroundColor Cyan
Write-Host "  1. Upload $deployName.zip to Hostinger public_html"
Write-Host "  2. Extract ZIP in public_html"
Write-Host "  3. Ensure storage/ and assets/images/uploads/ are writable (755)"
Write-Host "  4. Visit https://yourdomain.com/install.php"
Write-Host "  5. Complete the 5-step installation wizard"
Write-Host "  6. DELETE install.php after successful installation"
Write-Host "  7. Configure SSL certificate"
Write-Host "  8. Set up Razorpay/Cashfree webhooks"
Write-Host "  9. Test all checkout flows"
Write-Host ""
Write-Host "ZIP READY FOR DEPLOYMENT [OK]" -ForegroundColor Green