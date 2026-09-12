<?php
declare(strict_types=1);

/* DT admin access guard */ $__dtg = ($_SERVER['DOCUMENT_ROOT'] ?? '') . '/admin/includes/adminguard.php'; if (is_file($__dtg)) { require_once $__dtg; } elseif (is_file(__DIR__ . '/../includes/adminguard.php')) { require_once __DIR__ . '/../includes/adminguard.php'; }

/**
 * upload.php - Real media uploader for the admin media module.
 */

$page_title = 'Upload Media';
$active_nav = 'media';
$active_subnav = 'upload';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Media - DT Brand's Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/admin/assets/css/admin.css?v=<?php echo time(); ?>">
    <style>
        .dt-upload-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(280px, 0.9fr);
            gap: 16px;
            align-items: start;
        }
        .dt-dropzone {
            min-height: 250px;
            padding: 34px 20px;
            border: 2px dashed #D4AF37;
            border-radius: 8px;
            background: #FAF8F4;
            text-align: center;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: border-color 0.15s ease, background 0.15s ease, transform 0.15s ease;
        }
        .dt-dropzone.dragging {
            background: #FAF5E8;
            border-color: #8A681F;
            transform: translateY(-1px);
        }
        .dt-dropzone-icon {
            width: 58px;
            height: 58px;
            border-radius: 8px;
            border: 1px solid #D4AF37;
            background: #FFFFFF;
            color: #8A681F;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .dt-dropzone h3 {
            margin: 0;
            color: #111827;
            font: 800 18px 'Inter', 'Plus Jakarta Sans', sans-serif;
        }
        .dt-dropzone p {
            margin: 0;
            max-width: 460px;
            color: #64748B;
            font: 600 13px/1.55 'Inter', sans-serif;
        }
        .dt-upload-results {
            display: flex;
            flex-direction: column;
            gap: 8px;
            min-height: 120px;
        }
        .dt-upload-row {
            border: 1px solid #E5E1D7;
            border-radius: 8px;
            background: #FFFFFF;
            padding: 10px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
            align-items: center;
            min-width: 0;
        }
        .dt-upload-row.ok {
            border-color: #BBF7D0;
            background: #F0FDF4;
        }
        .dt-upload-row.err {
            border-color: #FECACA;
            background: #FEF2F2;
        }
        .dt-upload-name {
            color: #111827;
            font: 800 12px 'Inter', sans-serif;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .dt-upload-message {
            margin-top: 3px;
            color: #64748B;
            font: 700 11px 'Inter', sans-serif;
            overflow-wrap: anywhere;
        }
        .dt-upload-actions {
            display: flex;
            gap: 6px;
            align-items: center;
        }
        .dt-upload-actions .dt-btn {
            min-height: 30px;
            padding: 5px 8px;
            border-radius: 8px;
            font-size: 11px;
            text-decoration: none;
        }
        .dt-upload-empty {
            padding: 20px;
            border: 1px dashed #D4AF37;
            border-radius: 8px;
            background: #FAF8F4;
            color: #64748B;
            font-weight: 700;
            text-align: center;
        }
        @media (max-width: 900px) {
            .dt-upload-grid {
                grid-template-columns: 1fr;
            }
        }
        @media (max-width: 560px) {
            .dt-upload-row {
                grid-template-columns: 1fr;
            }
            .dt-upload-actions {
                width: 100%;
            }
            .dt-upload-actions .dt-btn {
                flex: 1;
                justify-content: center;
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
                        <span>Upload Media</span>
                        <span class="adm-badge gold">Secure Upload</span>
                    </h1>
                    <p class="adm-page-subtitle">Add validated catalog images and media files into the protected uploads folder.</p>
                </div>
                <div class="adm-page-actions">
                    <a href="/admin/media/gallery.php" class="dt-btn dt-btn-gold">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                        <span>Gallery Folders</span>
                    </a>
                    <a href="/admin/media/" class="dt-btn dt-btn-pale">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>All Media</span>
                    </a>
                </div>
            </div>

            <div class="dt-upload-grid">
                <section class="adm-card">
                    <div class="adm-card-head">
                        <h3 class="adm-card-title">Batch Upload</h3>
                    </div>
                    <div class="dt-dropzone" id="dtDropzone">
                        <div class="dt-dropzone-icon">
                            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        </div>
                        <h3>Select or Drop Files</h3>
                        <p>Supported formats: WebP, PNG, JPG, GIF, and MP4. Images can be up to 10 MB, and videos can be up to 25 MB.</p>
                        <button type="button" class="dt-btn dt-btn-gold" id="dtBrowseButton">
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
                            <span>Browse Files</span>
                        </button>
                        <input type="file" id="dtMediaInput" hidden multiple accept="image/*,video/mp4">
                    </div>
                </section>

                <section class="adm-card">
                    <div class="adm-card-head">
                        <h3 class="adm-card-title">Upload Results</h3>
                    </div>
                    <div id="dtUploadResults" class="dt-upload-results">
                        <div class="dt-upload-empty" id="dtUploadEmpty">No upload has been started in this session.</div>
                    </div>
                </section>
            </div>
        </main>
        <?php include_once __DIR__ . '/../includes/adminfooter.php'; ?>
    </div>
</div>
<script>
const dtDropzone = document.getElementById('dtDropzone');
const dtBrowseButton = document.getElementById('dtBrowseButton');
const dtMediaInput = document.getElementById('dtMediaInput');
const dtUploadResults = document.getElementById('dtUploadResults');
const dtUploadEmpty = document.getElementById('dtUploadEmpty');

function dtUploadToast(message, isError) {
    if (typeof window.showToast === 'function') {
        window.showToast(message, isError ? 'error' : 'success');
        return;
    }
    if (isError) {
        alert(message);
    }
}

function dtHandleUploadFiles(fileList) {
    Array.from(fileList || []).forEach(function (file) {
        dtUploadOne(file);
    });
}

function dtUploadOne(file) {
    if (dtUploadEmpty) {
        dtUploadEmpty.remove();
    }

    const row = document.createElement('div');
    row.className = 'dt-upload-row';
    row.innerHTML = '<div><div class="dt-upload-name"></div><div class="dt-upload-message">Uploading...</div></div><div class="dt-upload-actions"></div>';
    row.querySelector('.dt-upload-name').textContent = file.name;
    dtUploadResults.prepend(row);

    const formData = new FormData();
    formData.append('file', file);

    fetch('/api/upload.php', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin',
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).then(function (response) {
        return response.json().then(function (payload) {
            if (!response.ok || !payload.success) {
                throw new Error(payload.message || 'Upload failed.');
            }
            return payload;
        });
    }).then(function (payload) {
        row.classList.add('ok');
        row.querySelector('.dt-upload-message').textContent = payload.url || 'Uploaded successfully.';
        row.querySelector('.dt-upload-actions').innerHTML =
            '<a class="dt-btn dt-btn-dark" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z"></path><circle cx="12" cy="12" r="3"></circle></svg><span>View</span></a>' +
            '<a class="dt-btn dt-btn-pale" href="/admin/media/gallery.php"><svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg><span>Gallery</span></a>';
        row.querySelector('.dt-upload-actions a').href = payload.url;
        dtUploadToast('Uploaded ' + file.name + '.', false);
    }).catch(function (error) {
        row.classList.add('err');
        row.querySelector('.dt-upload-message').textContent = error.message || 'Upload failed.';
        dtUploadToast(error.message || 'Upload failed.', true);
    });
}

dtBrowseButton.addEventListener('click', function (event) {
    event.stopPropagation();
    dtMediaInput.click();
});
dtDropzone.addEventListener('click', function () {
    dtMediaInput.click();
});
dtMediaInput.addEventListener('change', function () {
    dtHandleUploadFiles(dtMediaInput.files);
    dtMediaInput.value = '';
});
['dragenter', 'dragover'].forEach(function (eventName) {
    dtDropzone.addEventListener(eventName, function (event) {
        event.preventDefault();
        dtDropzone.classList.add('dragging');
    });
});
['dragleave', 'drop'].forEach(function (eventName) {
    dtDropzone.addEventListener(eventName, function (event) {
        event.preventDefault();
        dtDropzone.classList.remove('dragging');
    });
});
dtDropzone.addEventListener('drop', function (event) {
    if (event.dataTransfer && event.dataTransfer.files.length) {
        dtHandleUploadFiles(event.dataTransfer.files);
    }
});
</script>
<script src="/admin/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>
