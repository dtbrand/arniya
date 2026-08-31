<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * media/index.php — DT Brand's Master Product Media Library
 * Wholesale Dashboard & Luxury Shop Standard
 * DT Brand's & Jai Hanuman Tex
 *
 * The previous revision shipped twelve invented assets pointing at a CDN
 * (cdn.jaihanumantex.in) that does not exist, and a Delete button that only
 * removed the DOM node. The gallery now lists the real contents of
 * assets/images/uploads/ (where /api/upload.php writes), with sizes straight
 * from filesystem stat. Delete actually unlinks the file behind an
 * admin-guarded POST to /api/media/delete.php.
 */
$page_title = "Product Media Library";
$active_nav = "products";
$active_subnav = "media";

$uploadDir = dirname(__DIR__, 3) . '/assets/images/uploads';
$media_assets = [];

if (is_dir($uploadDir)) {
    foreach (scandir($uploadDir) ?: [] as $fname) {
        if ($fname === '.' || $fname === '..' || $fname === '.htaccess') {
            continue;
        }
        $full = $uploadDir . '/' . $fname;
        if (!is_file($full)) {
            continue;
        }
        $ext = strtolower(pathinfo($fname, PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'mp4'], true)) {
            continue;
        }
        $bytes = (int)filesize($full);
        $media_assets[] = [
            'filename' => $fname,
            'url' => '/assets/images/uploads/' . rawurlencode($fname),
            'format' => strtoupper($ext),
            'size' => $bytes >= 1048576
                ? number_format($bytes / 1048576, 1) . ' MB'
                : number_format($bytes / 1024, 0) . ' KB',
            'bytes' => $bytes,
            'date' => date('d M Y', (int)filemtime($full)),
            'is_video' => $ext === 'mp4',
        ];
    }
}
// Newest first (timestamped filenames sort chronologically).
usort($media_assets, static function (array $a, array $b): int {
    return strcmp($b['filename'], $a['filename']);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Media Library ‹ DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Cinzel:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/admin/products/assets/css/wordpress-style.css?v=<?php echo time(); ?>">
    <style>
    .dt-kpi-card {
        background: #fff;
        border: 1px solid rgba(212,175,55,0.4);
        border-radius: 8px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .dt-media-gallery-grid {
        display: grid;
        gap: 12px;
        grid-template-columns: repeat(4, 1fr);
    }
    @media (max-width: 1100px) { .dt-media-gallery-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 768px)  { .dt-media-gallery-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px)  { .dt-media-gallery-grid { grid-template-columns: 1fr; } }
    .dt-media-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.2s ease;
    }
    .dt-media-card:hover { border-color: #D4AF37; box-shadow: 0 4px 12px rgba(212,175,55,0.15); }
    .dt-media-card-img { width: 100%; height: 160px; object-fit: cover; display: block; }
    .dt-media-card-content { padding: 10px 12px; }
    .dt-media-badge-format {
        position: absolute; top: 8px; left: 8px;
        background: #181512; color: #D4AF37; font-size: 9.5px; font-weight: 800;
        padding: 2px 6px; border-radius: 3px;
    }
    .dt-media-badge-size {
        position: absolute; top: 8px; right: 8px;
        background: rgba(255,255,255,0.92); color: #15803D; font-size: 9.5px; font-weight: 800;
        padding: 2px 6px; border-radius: 3px;
    }
    .dt-media-card-img-wrap { position: relative; }
    .dt-media-btn-pill {
        height: 24px; padding: 0 8px; font-size: 10.5px; font-weight: 700;
        border-radius: 4px; border: 1px solid; cursor: pointer;
        display: inline-flex; align-items: center; gap: 3px; text-decoration: none;
    }
    .dt-media-actions-bar { display: flex; gap: 5px; margin-top: 8px; flex-wrap: wrap; }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../Includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../Includes/adminheader.php'; ?>
        <main class="adm-content" style="padding: 16px 20px;">

            <!-- 1. Header -->
            <div class="wp-heading-wrap" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; margin-bottom:14px;">
                <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                    <h1 class="wp-heading-inline" style="font-size:22px; font-weight:800; color:#181512; margin:0;">Product Media Library</h1>
                    <span class="adm-badge gold" style="font-weight:700; font-size:11px; padding:3px 8px;"><?php echo count($media_assets); ?> Files On Disk</span>
                </div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <a href="/admin/products/" class="wp-button" style="height:32px; padding:0 11px; display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:600; text-decoration:none; background:#FAF5E8; border:1px solid #D4AF37; color:#8A681F;">Back to Products</a>
                    <a href="/admin/products/media/upload.php" class="wp-button primary" style="height:32px; padding:0 14px; display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:800; text-decoration:none; background:linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%); color:#111827; border:1px solid #8A681F; box-shadow:0 2px 8px rgba(212,175,55,0.35);">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="#181512" stroke-width="2.8"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        <span>Upload Media</span>
                    </a>
                </div>
            </div>

            <!-- 2. KPI -->
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:10px; margin-bottom:14px;">
                <div class="dt-kpi-card">
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">FILES ON DISK</div>
                        <div style="font-size:17px; font-weight:800; color:#181512;"><?php echo count($media_assets); ?></div>
                    </div>
                </div>
                <div class="dt-kpi-card">
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">TOTAL SIZE</div>
                        <?php $totalBytes = array_sum(array_column($media_assets, 'bytes')); ?>
                        <div style="font-size:17px; font-weight:800; color:#15803D;"><?php echo number_format($totalBytes / 1048576, 2); ?> MB</div>
                    </div>
                </div>
                <div class="dt-kpi-card">
                    <div>
                        <div style="font-size:11px; color:#646970; font-weight:600;">STORAGE LOCATION</div>
                        <div style="font-size:13px; font-weight:800; color:#1D4ED8;">/assets/images/uploads/</div>
                    </div>
                </div>
            </div>

            <!-- 3. Search -->
            <div class="wp-search-box" style="display:flex; align-items:center; gap:6px; margin-bottom:12px;">
                <input type="text" id="mediaSearchInput" class="wp-search-input" placeholder="Search file names…" style="height:32px; padding-left:12px; width:260px; font-size:12px; border:1px solid #c3c4c7; border-radius:4px; outline:none;" oninput="searchMedia(this.value)">
            </div>

            <!-- 4. Grid -->
            <div class="dt-media-gallery-grid" id="mediaGridContainer">
                <?php if (empty($media_assets)): ?>
                    <div style="grid-column:1/-1; padding:32px; text-align:center; color:#64748B; border:1.5px dashed #D4AF37; border-radius:8px;">
                        No media uploaded yet. Click <strong>Upload Media</strong> to add the first file — uploads go to
                        <code>/assets/images/uploads/</code> and appear here instantly.
                    </div>
                <?php else: ?>
                    <?php foreach ($media_assets as $asset): ?>
                    <div class="dt-media-card" data-title="<?= htmlspecialchars($asset['filename']) ?>">
                        <div class="dt-media-card-img-wrap">
                            <?php if (!$asset['is_video']): ?>
                                <img src="<?= htmlspecialchars($asset['url']) ?>" alt="<?= htmlspecialchars($asset['filename']) ?>" class="dt-media-card-img" onerror="this.src='/assets/images/no-image.svg';">
                            <?php else: ?>
                                <video src="<?= htmlspecialchars($asset['url']) ?>" class="dt-media-card-img" muted></video>
                            <?php endif; ?>
                            <span class="dt-media-badge-format"><?= htmlspecialchars($asset['format']) ?></span>
                            <span class="dt-media-badge-size"><?= htmlspecialchars($asset['size']) ?></span>
                        </div>
                        <div class="dt-media-card-content">
                            <strong style="font-size:11.5px; color:#181512; display:block; line-height:1.25; margin-bottom:2px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="<?= htmlspecialchars($asset['filename']) ?>"><?= htmlspecialchars($asset['filename']) ?></strong>
                            <span style="font-size:10px; color:#8c8f94;"><?= htmlspecialchars($asset['date']) ?></span>
                            <div class="dt-media-actions-bar">
                                <a href="<?= htmlspecialchars($asset['url']) ?>" target="_blank" class="dt-media-btn-pill" style="background:#EFF6FF; border-color:#93C5FD; color:#1D4ED8;">View</a>
                                <button type="button" class="dt-media-btn-pill" onclick="copyMediaUrl('<?= htmlspecialchars($asset['url']) ?>')" style="background:#FAF5E8; border-color:#D4AF37; color:#8A681F;">Copy URL</button>
                                <button type="button" class="dt-media-btn-pill" onclick="deleteMediaFile('<?= htmlspecialchars(addslashes($asset['filename'])) ?>', this)" style="background:#FEF2F2; border-color:#FECACA; color:#DC2626;">Delete</button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </main>
        <?php include_once __DIR__ . '/../../Includes/adminfooter.php'; ?>
    </div>
</div>

<script>
function searchMedia(q) {
    const term = (q || '').toLowerCase().trim();
    document.querySelectorAll('#mediaGridContainer .dt-media-card').forEach(card => {
        card.style.display = (card.dataset.title || '').toLowerCase().includes(term) ? '' : 'none';
    });
}

function copyMediaUrl(url) {
    const abs = location.origin + url;
    if (navigator.clipboard) {
        navigator.clipboard.writeText(abs).then(() => {
            if (typeof window.showToast === 'function') window.showToast('📋 URL copied: ' + url);
        });
    }
}

function deleteMediaFile(filename, btn) {
    if (!confirm('Permanently delete "' + filename + '" from the server?')) return;
    const params = new URLSearchParams();
    params.append('filename', filename);
    fetch('/api/media/delete.php', { method: 'POST', body: params, credentials: 'same-origin' })
        .then(r => r.json())
        .then(data => {
            if (data && data.success === false) {
                if (typeof window.showToast === 'function') window.showToast('⚠️ ' + (data.message || 'Delete failed'));
                return;
            }
            const card = btn.closest('.dt-media-card');
            if (card) card.remove();
            if (typeof window.showToast === 'function') window.showToast('🗑️ "' + filename + '" deleted');
        })
        .catch(() => {
            if (typeof window.showToast === 'function') window.showToast('⚠️ Could not reach the server');
        });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>