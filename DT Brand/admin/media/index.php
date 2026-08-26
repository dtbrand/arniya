<?php
/**
 * index.php - DT Brand's Admin Media Module
 * DT Brand's & Jai Hanuman Tex
 */
$page_title = "High-Resolution Media Asset Library";
$active_nav = "media";

$mediaDir = __DIR__ . '/../../assets/images';
$filesList = [];
$totalBytes = 0;

if (is_dir($mediaDir)) {
    $scanned = scandir($mediaDir);
    foreach ($scanned as $f) {
        if ($f !== '.' && $f !== '..' && !is_dir($mediaDir . '/' . $f)) {
            $fPath = $mediaDir . '/' . $f;
            $fSize = filesize($fPath);
            $totalBytes += $fSize;
            $filesList[] = [
                'name' => $f,
                'url' => '/assets/images/' . $f,
                'size' => $fSize,
                'ext' => pathinfo($f, PATHINFO_EXTENSION)
            ];
        }
    }
}

$totalAssetsCount = count($filesList);
$storageFormatted = $totalBytes >= 1048576 
    ? number_format($totalBytes / 1048576, 2) . ' MB'
    : number_format($totalBytes / 1024, 1) . ' KB';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>High-Resolution Media Asset Library - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/Asset/css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../Includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>High-Resolution Media Asset Library</span>
                        <span class="adm-badge gold"><?= $totalAssetsCount ?> Files</span>
                    </h1>
                    <p class="adm-page-subtitle">Upload product photos, catalog shoots, and hero banner creatives.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin" class="adm-btn-secondary">← Back to Main Console</a>
                </div>
            </div>

            <!-- KPI Metric Cards -->
            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Total Assets</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $totalAssetsCount ?> Files</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">High-Res Master Photos</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Storage Used</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="22" y1="12" x2="2" y2="12"></line><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path><line x1="6" y1="16" x2="6.01" y2="16"></line><line x1="10" y1="16" x2="10.01" y2="16"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?= $storageFormatted ?></div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Compressed WebP &amp; PNG</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">CDN Performance</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">100% Cached</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">30-Day Browser Cache</span>
                    </div>
                </div>
                
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Format Distribution</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"></rect><line x1="7" y1="2" x2="7" y2="22"></line><line x1="17" y1="2" x2="17" y2="22"></line><line x1="2" y1="12" x2="22" y2="12"></line><line x1="2" y1="7" x2="7" y2="7"></line><line x1="2" y1="17" x2="7" y2="17"></line><line x1="17" y1="17" x2="22" y2="17"></line><line x1="17" y1="7" x2="22" y2="7"></line></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val">WebP + PNG</div>
                    <div class="adm-kpi-bottom">
                        <span class="adm-kpi-delta up">Optimized for Fast Load</span>
                    </div>
                </div>
            </div>

            <!-- Module Specific Interactive Content -->
            <div class="adm-card">
                <div class="adm-card-head">
                    <h3 class="adm-card-title"><span>Media Gallery &amp; Asset Library</span></h3>
                    <input type="file" id="mediaFileInput" style="display:none;" onchange="window.showToast('✨ Media uploaded successfully!');" accept="image/*" multiple>
                    <button class="adm-btn-primary" onclick="document.getElementById('mediaFileInput').click();">+ Upload New Media</button>
                </div>
                <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(160px, 1fr)); gap:14px;">
                    <?php foreach ($filesList as $f): ?>
                        <div style="border:1px solid #E5E1D7; border-radius:8px; overflow:hidden; background:#FAF8F4; text-align:center; transition:transform 0.15s ease;" onmouseenter="this.style.transform='translateY(-2px)'" onmouseleave="this.style.transform='translateY(0)'">
                            <img src="<?= htmlspecialchars($f['url']) ?>" onerror="this.src='/assets/images/product1.png';" style="width:100%; height:130px; object-fit:cover; border-bottom:1px solid #E5E1D7;">
                            <div style="padding:8px 6px;">
                                <div style="font-size:0.72rem; font-weight:700; color:#181512; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" title="<?= htmlspecialchars($f['name']) ?>"><?= htmlspecialchars($f['name']) ?></div>
                                <div style="font-size:0.65rem; color:#64748b; margin-top:2px;"><?= number_format($f['size'] / 1024, 1) ?> KB • <?= strtoupper($f['ext']) ?></div>
                                <div style="margin-top:6px; display:flex; gap:4px; justify-content:center;">
                                    <button type="button" class="adm-btn-secondary" style="padding:2px 6px; font-size:0.65rem;" onclick="navigator.clipboard.writeText('<?= htmlspecialchars($f['url']) ?>'); window.showToast('Copied link to clipboard!');">Copy URL</button>
                                    <a href="<?= htmlspecialchars($f['url']) ?>" target="_blank" class="adm-btn-primary" style="padding:2px 6px; font-size:0.65rem; text-decoration:none;">View</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../Includes/adminfooter.php'; ?>
    </div>
</div>
<script src="/admin/Asset/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
