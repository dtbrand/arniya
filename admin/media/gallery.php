<?php
declare(strict_types=1);

/* DT admin access guard */ $__dtg = ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/admin/includes/adminguard.php'; if (is_file($__dtg)) { require_once $__dtg; } elseif (is_file(__DIR__ . '/../includes/adminguard.php')) { require_once __DIR__ . '/../includes/adminguard.php'; }

/**
 * gallery.php - Folder-aware media gallery for the admin console.
 */

$page_title = 'Gallery Folders';
$active_nav = 'media';
$active_subnav = 'gallery';

function dt_gallery_format_bytes(int $bytes): string
{
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    }
    if ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    }
    return number_format(max($bytes, 0) / 1024, 1) . ' KB';
}

function dt_gallery_public_url(string $relativePath): string
{
    $segments = array_map('rawurlencode', explode('/', str_replace('\\', '/', $relativePath)));
    return '/assets/images/' . implode('/', $segments);
}

$mediaRoot = realpath(__DIR__ . '/../../assets/images');
$allowedExtensions = ['avif', 'gif', 'jpg', 'jpeg', 'mp4', 'png', 'svg', 'webp'];
$assets = [];
$folders = [];
$totalBytes = 0;
$deletableCount = 0;

if ($mediaRoot !== false && is_dir($mediaRoot)) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($mediaRoot, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if (!$file->isFile()) {
            continue;
        }

        $filename = $file->getFilename();
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if ($filename === '.htaccess' || !in_array($extension, $allowedExtensions, true)) {
            continue;
        }

        $path = $file->getPathname();
        $relative = str_replace('\\', '/', substr($path, strlen($mediaRoot) + 1));
        $folder = dirname($relative);
        $folderKey = $folder === '.' ? 'Root Gallery' : $folder;
        $size = (int)$file->getSize();
        $isDeletableUpload = strpos($relative, 'uploads/') === 0 && substr_count($relative, '/') === 1;

        $assets[] = [
            'name' => $filename,
            'relative' => $relative,
            'folder' => $folderKey,
            'url' => dt_gallery_public_url($relative),
            'size' => $size,
            'extension' => strtoupper($extension),
            'is_video' => $extension === 'mp4',
            'deletable' => $isDeletableUpload,
        ];

        $totalBytes += $size;
        $deletableCount += $isDeletableUpload ? 1 : 0;

        if (!isset($folders[$folderKey])) {
            $folders[$folderKey] = [
                'name' => $folderKey,
                'count' => 0,
                'bytes' => 0,
            ];
        }
        $folders[$folderKey]['count']++;
        $folders[$folderKey]['bytes'] += $size;
    }
}

usort($assets, static function (array $a, array $b): int {
    return [$a['folder'], $a['name']] <=> [$b['folder'], $b['name']];
});
ksort($folders);

$totalAssets = count($assets);
$totalFolders = count($folders);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Folders - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-gallery-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 14px;
        }
        .dt-gallery-tabs {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            min-width: 0;
        }
        .dt-filter-chip {
            min-height: 34px;
            padding: 7px 11px;
            border: 1px solid #D4AF37;
            border-radius: 8px;
            background: #FAF5E8;
            color: #705114;
            cursor: pointer;
            font: 800 12px 'Inter', 'Plus Jakarta Sans', sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: transform 0.15s ease, background 0.15s ease, color 0.15s ease;
            max-width: 100%;
        }
        .dt-filter-chip:hover,
        .dt-filter-chip.active {
            background: linear-gradient(135deg, #B8860B 0%, #D4AF37 50%, #E6CA65 100%);
            border-color: #8A681F;
            color: #111827;
            transform: translateY(-1px);
        }
        .dt-gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 14px;
            min-width: 0;
        }
        .dt-asset-card {
            min-width: 0;
            overflow: hidden;
            border: 1px solid #E5E1D7;
            border-radius: 8px;
            background: #FFFFFF;
            box-shadow: 0 2px 10px rgba(17, 24, 39, 0.06);
        }
        .dt-asset-preview {
            position: relative;
            aspect-ratio: 4 / 3;
            background: #FAF8F4;
            border-bottom: 1px solid #E5E1D7;
            overflow: hidden;
        }
        .dt-asset-preview img,
        .dt-asset-preview video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .dt-asset-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            padding: 4px 7px;
            border-radius: 999px;
            background: rgba(250, 245, 232, 0.94);
            border: 1px solid rgba(212, 175, 55, 0.65);
            color: #705114;
            font: 800 10px 'Inter', sans-serif;
            text-transform: uppercase;
        }
        .dt-asset-body {
            padding: 10px;
            min-width: 0;
        }
        .dt-asset-name {
            color: #111827;
            font: 800 12px 'Inter', 'Plus Jakarta Sans', sans-serif;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .dt-asset-meta {
            margin-top: 4px;
            color: #64748B;
            font: 700 11px 'Inter', sans-serif;
            overflow-wrap: anywhere;
        }
        .dt-asset-actions {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 6px;
            margin-top: 10px;
        }
        .dt-mini-action {
            min-width: 0;
            min-height: 30px;
            padding: 5px 7px;
            border-radius: 8px;
            justify-content: center;
            font-size: 11px;
            text-decoration: none;
        }
        .dt-mini-action svg {
            width: 13px;
            height: 13px;
            flex: 0 0 auto;
        }
        .dt-mini-action[disabled] {
            opacity: 0.58;
            cursor: not-allowed;
            transform: none;
        }
        .dt-gallery-empty {
            padding: 32px;
            border: 1px dashed #D4AF37;
            border-radius: 8px;
            background: #FAF8F4;
            color: #64748B;
            text-align: center;
            font-weight: 700;
        }
        @media (max-width: 720px) {
            .dt-gallery-toolbar {
                align-items: stretch;
            }
            .dt-gallery-tabs,
            .dt-gallery-toolbar .adm-page-actions {
                width: 100%;
            }
            .dt-filter-chip {
                flex: 1 1 150px;
                justify-content: center;
            }
            .dt-gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }
            .dt-asset-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="adm-page-head">
                <div class="adm-page-title-group">
                    <h1 class="adm-page-title">
                        <span>Gallery Folders</span>
                        <span class="adm-badge gold"><?php echo $totalFolders; ?> Folders</span>
                    </h1>
                    <p class="adm-page-subtitle">Folder-level view of catalog photos, upload assets, and web image formats.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/media/upload.php" class="dt-btn dt-btn-gold">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        <span>Upload Media</span>
                    </a>
                    <a href="/admin/media/" class="dt-btn dt-btn-pale">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Media</span>
                    </a>
                </div>
            </div>

            <div class="adm-kpi-grid">
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Total Assets</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?php echo $totalAssets; ?> Files</div>
                    <div class="adm-kpi-bottom"><span class="adm-kpi-delta up">Catalog image library</span></div>
                </div>
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Folders</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?php echo $totalFolders; ?></div>
                    <div class="adm-kpi-bottom"><span class="adm-kpi-delta up">Root and nested groups</span></div>
                </div>
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Storage</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><line x1="22" y1="12" x2="2" y2="12"></line><path d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?php echo dt_gallery_format_bytes($totalBytes); ?></div>
                    <div class="adm-kpi-bottom"><span class="adm-kpi-delta up">Image assets scanned</span></div>
                </div>
                <div class="adm-kpi-card">
                    <div class="adm-kpi-top">
                        <span class="adm-kpi-label">Upload Deletion</span>
                        <div class="adm-kpi-icon-box">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M3 6h18"></path><path d="M8 6V4h8v2"></path><path d="M19 6l-1 14H6L5 6"></path></svg>
                        </div>
                    </div>
                    <div class="adm-kpi-val"><?php echo $deletableCount; ?> Files</div>
                    <div class="adm-kpi-bottom"><span class="adm-kpi-delta up">Guarded upload cleanup</span></div>
                </div>
            </div>

            <div class="dt-gallery-toolbar">
                <div class="dt-gallery-tabs" role="tablist" aria-label="Media folders">
                    <button type="button" class="dt-filter-chip active" data-filter="__all">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        <span>All Folders</span>
                    </button>
                    <?php foreach ($folders as $folder): ?>
                        <button type="button" class="dt-filter-chip" data-filter="<?php echo htmlspecialchars($folder['name'], ENT_QUOTES, 'UTF-8'); ?>">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                            <span><?php echo htmlspecialchars($folder['name'], ENT_QUOTES, 'UTF-8'); ?> (<?php echo (int)$folder['count']; ?>)</span>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if ($totalAssets === 0): ?>
                <div class="dt-gallery-empty">No media assets were found in assets/images.</div>
            <?php else: ?>
                <div class="dt-gallery-grid" id="dtGalleryGrid">
                    <?php foreach ($assets as $asset): ?>
                        <article class="dt-asset-card" data-folder="<?php echo htmlspecialchars($asset['folder'], ENT_QUOTES, 'UTF-8'); ?>">
                            <div class="dt-asset-preview">
                                <?php if (!empty($asset['is_video'])): ?>
                                    <video src="<?php echo htmlspecialchars($asset['url'], ENT_QUOTES, 'UTF-8'); ?>" muted preload="metadata"></video>
                                <?php else: ?>
                                    <img src="<?php echo htmlspecialchars($asset['url'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($asset['name'], ENT_QUOTES, 'UTF-8'); ?>" loading="lazy" onerror="this.src='/assets/images/no-image.svg';">
                                <?php endif; ?>
                                <span class="dt-asset-badge"><?php echo htmlspecialchars($asset['extension'], ENT_QUOTES, 'UTF-8'); ?></span>
                            </div>
                            <div class="dt-asset-body">
                                <div class="dt-asset-name" title="<?php echo htmlspecialchars($asset['name'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($asset['name'], ENT_QUOTES, 'UTF-8'); ?></div>
                                <div class="dt-asset-meta"><?php echo htmlspecialchars($asset['folder'], ENT_QUOTES, 'UTF-8'); ?> · <?php echo dt_gallery_format_bytes((int)$asset['size']); ?></div>
                                <div class="dt-asset-actions">
                                    <button type="button" class="dt-btn dt-btn-pale dt-mini-action" onclick="dtGalleryCopy('<?php echo htmlspecialchars($asset['url'], ENT_QUOTES, 'UTF-8'); ?>')">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="9" y="9" width="13" height="13" rx="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                        <span>Copy</span>
                                    </button>
                                    <a class="dt-btn dt-btn-dark dt-mini-action" href="<?php echo htmlspecialchars($asset['url'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                        <span>View</span>
                                    </a>
                                    <?php if ($asset['deletable']): ?>
                                        <button type="button" class="dt-btn dt-btn-pale dt-mini-action" data-filename="<?php echo htmlspecialchars($asset['name'], ENT_QUOTES, 'UTF-8'); ?>" onclick="dtGalleryDelete(this)">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M3 6h18"></path><path d="M8 6V4h8v2"></path><path d="M19 6l-1 14H6L5 6"></path></svg>
                                            <span>Remove</span>
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="dt-btn dt-btn-pale dt-mini-action" disabled title="Core catalog asset is protected">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                                            <span>Protected</span>
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script>
function dtGalleryToast(message, isError) {
    if (typeof window.showToast === 'function') {
        window.showToast(message, isError ? 'error' : 'success');
        return;
    }
    alert(message);
}

function dtGalleryCopy(url) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(url).then(function () {
            dtGalleryToast('Media URL copied.', false);
        }).catch(function () {
            dtGalleryToast('Unable to copy the media URL.', true);
        });
        return;
    }

    var input = document.createElement('input');
    input.value = url;
    document.body.appendChild(input);
    input.select();
    document.execCommand('copy');
    document.body.removeChild(input);
    dtGalleryToast('Media URL copied.', false);
}

function dtGalleryDelete(button) {
    var filename = button.getAttribute('data-filename') || '';
    if (!filename || !confirm('Delete this uploaded media file?')) {
        return;
    }

    button.disabled = true;
    fetch('/api/media/delete.php', {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({ filename: filename })
    }).then(function (response) {
        return response.json().then(function (payload) {
            if (!response.ok || !payload.success) {
                throw new Error(payload.message || 'The media file could not be deleted.');
            }
            return payload;
        });
    }).then(function () {
        var card = button.closest('.dt-asset-card');
        if (card) {
            card.remove();
        }
        dtGalleryToast('Uploaded media file deleted.', false);
    }).catch(function (error) {
        button.disabled = false;
        dtGalleryToast(error.message || 'The media file could not be deleted.', true);
    });
}

document.querySelectorAll('.dt-filter-chip').forEach(function (chip) {
    chip.addEventListener('click', function () {
        var filter = chip.getAttribute('data-filter') || '__all';
        document.querySelectorAll('.dt-filter-chip').forEach(function (item) {
            item.classList.toggle('active', item === chip);
        });
        document.querySelectorAll('.dt-asset-card').forEach(function (card) {
            card.hidden = filter !== '__all' && card.getAttribute('data-folder') !== filter;
        });
    });
});
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
