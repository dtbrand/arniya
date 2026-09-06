<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

/**
 * media/upload.php — Real media upload screen
 * DT Brand's & Jai Hanuman Tex
 *
 * The previous version fired a hardcoded "4 files uploaded successfully!"
 * toast on file selection and stored nothing. It now streams each selected
 * file to /api/upload.php — the admin-guarded endpoint that validates MIME
 * type, enforces size limits and writes under assets/images/uploads/ — and
 * shows the real per-file result.
 */
$page_title = "Upload Media";
$active_nav = "products";
$active_subnav = "media";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Media ‹ DT Brand's Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
    .upload-result { font-size: 12px; padding: 6px 10px; border-radius: 4px; margin-top: 6px; }
    .upload-result.ok { background: #DCFCE7; color: #15803D; }
    .upload-result.err { background: #FEE2E2; color: #B91C1C; }
    </style>
</head>
<body>
<div class="adm-layout">
    <?php include_once __DIR__ . '/../../includes/adminsidebar.php'; ?>
    <div class="adm-main">
        <?php include_once __DIR__ . '/../../includes/adminheader.php'; ?>
        <main class="adm-content">
            <div class="dt-prod-header">
                <div class="dt-prod-title-group">
                    <h1><span>Upload High-Res Media</span></h1>
                </div>
                <div class="dt-prod-actions">
                    <a href="/admin/products/media/" class="dt-btn dt-btn-pale" style="height:32px; padding:0 12px; font-size:12px; display:inline-flex; align-items:center; gap:6px;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                        <span>Back to Media Library</span>
                    </a>
                </div>
            </div>
            <div class="adm-card">
                <div class="dt-dropzone" id="dropzone" style="padding:40px 20px; border:2px dashed #D4AF37; border-radius:8px; text-align:center; cursor:pointer;" onclick="document.getElementById('mFile').click()">
                    <div style="margin-bottom:8px; display:flex; justify-content:center;">
                        <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    </div>
                    <h3>Click to choose photos or videos (or drop them here)</h3>
                    <p style="font-size:0.8rem; color:#7A7266; margin-top:4px;">Supported: WebP, PNG, JPG, GIF, MP4. Max 10 MB per image, 25 MB per video.</p>
                    <input type="file" id="mFile" style="display:none;" multiple accept="image/*,video/mp4">
                </div>
                <div id="uploadResults" style="margin-top:14px;"></div>
            </div>
        </main>
        <?php include_once __DIR__ . '/../../includes/adminfooter.php'; ?>
    </div>
</div>
<script>
const dropzone = document.getElementById('dropzone');
const input = document.getElementById('mFile');
const results = document.getElementById('uploadResults');

['dragover', 'dragenter'].forEach(ev => dropzone.addEventListener(ev, e => {
    e.preventDefault();
    dropzone.style.background = '#FAF5E8';
}));
['dragleave', 'drop'].forEach(ev => dropzone.addEventListener(ev, e => {
    e.preventDefault();
    dropzone.style.background = '';
}));
dropzone.addEventListener('drop', e => {
    if (e.dataTransfer && e.dataTransfer.files.length) {
        handleFiles(e.dataTransfer.files);
    }
});
input.addEventListener('change', () => {
    if (input.files.length) { handleFiles(input.files); input.value = ''; }
});

function handleFiles(fileList) {
    Array.from(fileList).forEach(file => uploadOne(file));
}

function uploadOne(file) {
    const row = document.createElement('div');
    row.className = 'upload-result';
    row.textContent = 'Uploading ' + file.name + '...';
    results.prepend(row);

    const fd = new FormData();
    fd.append('file', file);
    fetch('/api/upload.php', { method: 'POST', body: fd, credentials: 'same-origin' })
        .then(r => r.json().then(data => ({ status: r.status, data })))
        .then(({ status, data }) => {
            if (status === 200 && data && data.success) {
                row.className = 'upload-result ok';
                row.textContent = 'Uploaded: ' + file.name + ' → ' + data.url;
            } else {
                row.className = 'upload-result err';
                row.textContent = 'Failed: ' + file.name + ' — ' + ((data && data.message) || ('HTTP ' + status));
            }
        })
        .catch(() => {
            row.className = 'upload-result err';
            row.textContent = 'Failed: ' + file.name + ' — network error, retry';
        });
}
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>