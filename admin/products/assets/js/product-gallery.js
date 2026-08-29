/**
 * product-gallery.js — Product Media Studio (cover photo, gallery, video, video links)
 * DT Brand's & Jai Hanuman Tex
 *
 * Every file picked here is uploaded to /api/upload.php, and the URL the server
 * returns is the only value the save path reads (window.dtCollectMedia).
 *
 * The previous version never uploaded a video at all: it made a local blob with
 * URL.createObjectURL(file) and toasted "video(s) added successfully", so the
 * clip existed only until the page was closed. The gallery kept its base64
 * preview when an upload failed, which the form then posted into a
 * VARCHAR(255) column. Both are fixed here: nothing is reported as attached
 * unless the server confirmed it.
 */
(function () {
    'use strict';

    // api/upload.php allows exactly these, so the browser refuses the rest up
    // front instead of after a wasted upload.
    var IMAGE_TYPES = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    var IMAGE_MAX = 10 * 1024 * 1024;   // 10 MB  — $maxBytes for images
    var VIDEO_MAX = 25 * 1024 * 1024;   // 25 MB  — $maxBytes for video

    function toast(msg) {
        if (typeof window.showToast === 'function') { window.showToast(msg); }
    }

    function sizeLabel(bytes) {
        return bytes > 1024 * 1024
            ? (bytes / (1024 * 1024)).toFixed(2) + ' MB'
            : Math.round(bytes / 1024) + ' KB';
    }

    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    /** POST one file to the upload endpoint. Resolves with the stored URL. */
    function dtUpload(file) {
        var fd = new FormData();
        fd.append('file', file);
        return fetch('/api/upload.php', { method: 'POST', body: fd, credentials: 'same-origin' })
            .then(function (r) {
                return r.json().catch(function () {
                    throw new Error((r.status === 401 || r.status === 403)
                        ? 'You are signed out of the admin — sign in again and retry.'
                        : 'The server did not return a valid response (HTTP ' + r.status + ').');
                });
            })
            .then(function (res) {
                if (!res || !res.success || !res.url) {
                    throw new Error((res && res.message) ? res.message : 'The server rejected the file.');
                }
                return res.url;
            });
    }
    window.dtUploadMedia = dtUpload;
    function rejectImage(file) {
        if (IMAGE_TYPES.indexOf(file.type) === -1) {
            return file.name + ': only JPG, PNG, WebP or GIF can be stored.';
        }
        if (file.size > IMAGE_MAX) {
            return file.name + ' is ' + sizeLabel(file.size) + ' — the limit is 10 MB.';
        }
        return '';
    }

    function rejectVideo(file) {
        // The server's allowlist holds one video type. The old gate said "50MB"
        // in the message while testing for 60 MB, against an endpoint that
        // refuses anything over 25 MB and refuses .mov and .webm outright —
        // which is most of why video upload looked broken.
        if (file.type !== 'video/mp4') {
            return file.name + ': only MP4 video can be stored ('
                + (file.type || 'unknown type') + ' is refused by the server).';
        }
        if (file.size > VIDEO_MAX) {
            return file.name + ' is ' + sizeLabel(file.size) + ' — the limit is 25 MB.';
        }
        return '';
    }

    var EMBED_HOSTS = ['youtube.com', 'youtu.be', 'instagram.com', 'vimeo.com', 'facebook.com', 'fb.watch', 'dailymotion.com'];
    var VIDEO_EXT = /\.(mp4|webm|ogg|ogv|mov|m4v)(\?|#|$)/i;

    function hostOf(raw) {
        try {
            return new URL(raw, window.location.origin).hostname.toLowerCase().replace(/^www\./, '');
        } catch (e) {
            return '';
        }
    }

    function isDirectVideoUrl(raw) {
        return VIDEO_EXT.test(raw) && EMBED_HOSTS.indexOf(hostOf(raw)) === -1;
    }
    /**
     * Browser mirror of ProductCatalog::embedUrl(). Returns a player URL, or ''
     * when the link cannot be embedded — an <iframe src> pointing at
     * youtube.com/watch is refused by YouTube itself.
     */
    function playerUrl(raw) {
        var u;
        try { u = new URL(raw, window.location.origin); } catch (e) { return ''; }
        var host = u.hostname.toLowerCase().replace(/^www\./, '');
        var m;

        if (host === 'youtu.be') {
            var id = u.pathname.replace(/^\//, '').split('/')[0];
            return id ? 'https://www.youtube.com/embed/' + encodeURIComponent(id) : '';
        }
        if (host === 'youtube.com' || host === 'm.youtube.com') {
            var v = u.searchParams.get('v');
            if (v) { return 'https://www.youtube.com/embed/' + encodeURIComponent(v); }
            m = u.pathname.match(/\/(shorts|embed|live)\/([^/?&]+)/);
            return m ? 'https://www.youtube.com/embed/' + encodeURIComponent(m[2]) : '';
        }
        if (host === 'instagram.com') {
            m = u.pathname.match(/\/(reel|reels|p|tv)\/([^/?&]+)/);
            if (!m) { return ''; }
            return 'https://www.instagram.com/' + (m[1] === 'reels' ? 'reel' : m[1])
                + '/' + encodeURIComponent(m[2]) + '/embed';
        }
        if (host === 'vimeo.com' || host === 'player.vimeo.com') {
            m = u.pathname.match(/(\d+)/);
            return m ? 'https://player.vimeo.com/video/' + m[1] : '';
        }
        return '';
    }
    var TRASH_SVG = '<svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5">'
        + '<polyline points="3 6 5 6 21 6"></polyline>'
        + '<path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>';

    function videoBadge(label) {
        return '<span class="dt-video-hd-badge">'
            + '<svg viewBox="0 0 24 24" width="9" height="9" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg> '
            + esc(label || 'VIDEO') + '</span>';
    }

    function buildVideoCard(opts) {
        var card = document.createElement('div');
        card.className = 'dt-video-item-card';
        card.innerHTML =
            '<div class="dt-video-card-thumb">' + opts.thumb + videoBadge(opts.badge) + '</div>'
            + '<div class="dt-video-card-meta">'
            + '<div class="dt-v-title" style="font-size:11.5px;font-weight:700;color:#181512;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">'
            + esc(opts.title) + '</div>'
            + '<div class="dt-v-sub" style="font-size:10.5px;color:#646970;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">'
            + esc(opts.sub) + '</div>'
            + '<div style="display:flex;gap:6px;">'
            + '<button type="button" class="dt-btn-action-sm danger" onclick="removeVideoItem(this);">'
            + TRASH_SVG + '<span>Remove</span></button></div></div>';
        return card;
    }

    function buildGalleryCard(src) {
        var card = document.createElement('div');
        card.className = 'dt-gallery-card';
        card.innerHTML =
            '<div class="dt-gallery-img-wrap">'
            + '<img src="' + esc(src || '') + '" alt="Product angle">'
            + '<div class="dt-gallery-card-actions">'
            + '<button type="button" class="dt-gaction-btn make-main" title="Set as cover photo" onclick="setAsMainPhoto(this);">'
            + '<svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>'
            + '<span>Set Main</span></button>'
            + '<button type="button" class="dt-gaction-btn remove" title="Delete photo" onclick="removeGalleryPhoto(this);">'
            + '<svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>'
            + '</button></div></div>'
            + '<div class="dt-gallery-card-caption">Uploading…</div>';
        return card;
    }
    // ── 1. Cover photo ───────────────────────────────────────────────
    window.handleMainPhotoUpload = function (files) {
        if (!files || !files.length) { return; }
        var file = files[0];
        var why = rejectImage(file);
        if (why) { toast('Not uploaded — ' + why); return; }

        var mainImg = document.getElementById('mainPhotoImg');
        var previewWrap = document.getElementById('mainPhotoPreviewWrap');
        var dropzone = document.getElementById('mainPhotoDropzone');
        var dimLabel = document.getElementById('mainPhotoDim');
        var sizeStr = sizeLabel(file.size);

        var reader = new FileReader();
        reader.onload = function (e) {
            // Preview only. It is deliberately never written to data-server-url,
            // so a failed upload cannot be posted as if it were a stored photo.
            if (mainImg && !mainImg.getAttribute('data-server-url')) { mainImg.src = e.target.result; }
            if (previewWrap) { previewWrap.style.display = 'flex'; }
            if (dropzone) { dropzone.style.display = 'none'; }
        };
        reader.readAsDataURL(file);
        if (dimLabel) { dimLabel.textContent = 'Cover (' + sizeStr + ') - uploading...'; }

        dtUpload(file).then(function (url) {
            if (mainImg) {
                mainImg.src = url;
                mainImg.setAttribute('data-server-url', url);
            }
            if (dimLabel) { dimLabel.textContent = 'Cover (' + sizeStr + ') - saved on the server'; }
            toast('Cover photo uploaded.');
            updateMediaCounts();
        }).catch(function (err) {
            window.removeMainPhoto(true);
            toast('Cover photo was NOT saved. ' + err.message);
        });
        updateMediaCounts();
    };

    window.removeMainPhoto = function (silent) {
        var previewWrap = document.getElementById('mainPhotoPreviewWrap');
        var dropzone = document.getElementById('mainPhotoDropzone');
        var fileInput = document.getElementById('mainPhotoFileInput');
        var mainImg = document.getElementById('mainPhotoImg');
        var dimLabel = document.getElementById('mainPhotoDim');

        if (mainImg) { mainImg.removeAttribute('src'); mainImg.removeAttribute('data-server-url'); }
        if (fileInput) { fileInput.value = ''; }
        if (previewWrap) { previewWrap.style.display = 'none'; }
        if (dropzone) { dropzone.style.display = 'block'; }
        if (dimLabel) { dimLabel.textContent = 'No cover photo yet'; }
        if (silent !== true) { toast('Cover photo removed. Upload one before saving.'); }
        updateMediaCounts();
    };
    // ── 2. Video studio ─────────────────────────────────────────────
    window.switchVideoTab = function (tab) {
        var uploadBtn = document.getElementById('vTabUploadBtn');
        var urlBtn = document.getElementById('vTabUrlBtn');
        var uploadPane = document.getElementById('videoUploadTabPane');
        var urlPane = document.getElementById('videoUrlTabPane');
        var onUpload = (tab === 'upload');

        if (uploadBtn) { uploadBtn.classList.toggle('active', onUpload); }
        if (urlBtn) { urlBtn.classList.toggle('active', !onUpload); }
        if (uploadPane) { uploadPane.style.display = onUpload ? 'block' : 'none'; }
        if (urlPane) { urlPane.style.display = onUpload ? 'none' : 'block'; }
    };

    window.handleProductVideoUpload = function (files) {
        if (!files || !files.length) { return; }
        var container = document.getElementById('dtVideoItemsContainer');

        Array.prototype.forEach.call(files, function (file) {
            var why = rejectVideo(file);
            if (why) { toast('Not uploaded — ' + why); return; }

            var card = buildVideoCard({
                title: file.name,
                sub: sizeLabel(file.size) + ' - uploading...',
                badge: 'UPLOADING',
                thumb: '<div style="display:flex;align-items:center;justify-content:center;height:100%;'
                    + 'background:#181512;color:#FDE047;font-size:10px;font-weight:700;">UPLOADING...</div>'
            });
            card.setAttribute('data-uploading', '1');
            if (container) { container.appendChild(card); }
            updateMediaCounts();

            dtUpload(file).then(function (url) {
                card.removeAttribute('data-uploading');
                card.setAttribute('data-video-url', url);
                var thumb = card.querySelector('.dt-video-card-thumb');
                if (thumb) {
                    thumb.innerHTML = '<video controls playsinline preload="metadata" '
                        + 'style="width:100%;height:100%;object-fit:cover;background:#000;">'
                        + '<source src="' + esc(url) + '" type="video/mp4"></video>'
                        + videoBadge('VIDEO');
                }
                var sub = card.querySelector('.dt-v-sub');
                if (sub) { sub.textContent = sizeLabel(file.size) + ' - saved on the server'; }
                toast('Video uploaded. It is attached when you save the product.');
                updateMediaCounts();
            }).catch(function (err) {
                // No blob preview is left behind: the file is not on the server,
                // so there is nothing to attach and nothing to show.
                card.remove();
                toast(file.name + ' was NOT saved. ' + err.message);
                updateMediaCounts();
            });
        });
    };
    window.removeVideoItem = function (btn) {
        var card = btn.closest('.dt-video-item-card');
        if (!card) { return; }
        var player = card.querySelector('video');
        if (player) { player.pause(); player.removeAttribute('src'); }
        card.style.transition = 'all 0.2s ease';
        card.style.opacity = '0';
        card.style.transform = 'scale(0.85)';
        setTimeout(function () {
            card.remove();
            toast('Video removed. Save the product to apply it.');
            updateMediaCounts();
        }, 200);
    };

    window.handleVideoUrlEmbed = function () {
        var input = document.getElementById('dtVideoUrlInput');
        if (!input) { return; }
        var raw = (input.value || '').trim();
        if (!raw) { toast('Paste a video link first.'); return; }

        var container = document.getElementById('dtVideoItemsContainer');
        var card;

        if (isDirectVideoUrl(raw)) {
            card = buildVideoCard({
                title: 'Direct video file',
                sub: raw,
                badge: 'LINKED FILE',
                thumb: '<video controls playsinline preload="metadata" '
                    + 'style="width:100%;height:100%;object-fit:cover;background:#000;">'
                    + '<source src="' + esc(raw) + '"></video>'
            });
            card.setAttribute('data-video-url', raw);
        } else {
            var player = playerUrl(raw);
            if (!player) {
                // The old handler accepted anything and drew an "Instagram Reel"
                // tile for it, so a mistyped link looked attached while storing
                // nothing playable.
                toast('That link cannot be embedded. Use a YouTube, Instagram or Vimeo link, or a direct .mp4 URL.');
                return;
            }
            card = buildVideoCard({
                title: hostOf(raw) || 'Linked video',
                sub: raw,
                badge: 'VIDEO LINK',
                thumb: '<iframe src="' + esc(player) + '" width="100%" height="100%" frameborder="0" '
                    + 'loading="lazy" allowfullscreen referrerpolicy="strict-origin-when-cross-origin" '
                    + 'style="border:none;"></iframe>'
            });
            card.setAttribute('data-embed-url', raw);
        }

        if (container) { container.appendChild(card); }
        input.value = '';
        toast('Video link attached. It is stored when you save the product.');
        if (typeof window.switchVideoTab === 'function') { window.switchVideoTab('upload'); }
        updateMediaCounts();
    };
    // ── 3. Gallery photos ───────────────────────────────────────────
    window.handleGalleryUpload = function (files) {
        if (!files || !files.length) { return; }
        var grid = document.getElementById('dtGalleryPreviewGrid');
        var addSlot = grid ? grid.querySelector('.dt-gallery-add-slot') : null;
        var jobs = [];

        Array.prototype.forEach.call(files, function (file) {
            var why = rejectImage(file);
            if (why) { toast('Not uploaded — ' + why); return; }

            var card = buildGalleryCard('');
            card.setAttribute('data-uploading', '1');
            if (addSlot && grid) { grid.insertBefore(card, addSlot); }
            else if (grid) { grid.appendChild(card); }

            var reader = new FileReader();
            reader.onload = function (e) {
                var img = card.querySelector('img');
                if (img && !card.getAttribute('data-server-url')) { img.src = e.target.result; }
            };
            reader.readAsDataURL(file);

            jobs.push(dtUpload(file).then(function (url) {
                card.removeAttribute('data-uploading');
                card.setAttribute('data-server-url', url);
                var img = card.querySelector('img');
                if (img) { img.src = url; }
                renumberGallery();
                return true;
            }).catch(function (err) {
                // Removed rather than left showing a base64 preview: that string
                // is not a stored photo and does not fit primary_image anyway.
                card.remove();
                toast(file.name + ' was NOT saved. ' + err.message);
                return false;
            }));
        });

        if (!jobs.length) { return; }
        // The old toast fired from a `loadedCount === files.length` test inside
        // the FileReader callback, so one non-image in the batch meant the
        // counter never reached the total and no confirmation ever appeared.
        Promise.all(jobs).then(function (results) {
            var ok = results.filter(Boolean).length;
            if (ok > 0) { toast(ok + ' gallery photo(s) uploaded.'); }
            renumberGallery();
            updateMediaCounts();
        });
    };

    function renumberGallery() {
        var n = 0;
        document.querySelectorAll('.dt-gallery-card').forEach(function (c) {
            var cap = c.querySelector('.dt-gallery-card-caption');
            if (!cap) { return; }
            cap.textContent = c.getAttribute('data-server-url') ? 'Angle ' + (++n) : 'Uploading...';
        });
    }
    window.setAsMainPhoto = function (btn) {
        var card = btn.closest('.dt-gallery-card');
        if (!card) { return; }
        var newUrl = card.getAttribute('data-server-url');
        if (!newUrl) { toast('That photo is still uploading — try again in a moment.'); return; }

        var mainImg = document.getElementById('mainPhotoImg');
        if (!mainImg) { return; }
        var previewWrap = document.getElementById('mainPhotoPreviewWrap');
        var dropzone = document.getElementById('mainPhotoDropzone');
        var dimLabel = document.getElementById('mainPhotoDim');
        var oldUrl = mainImg.getAttribute('data-server-url') || '';

        mainImg.src = newUrl;
        mainImg.setAttribute('data-server-url', newUrl);
        if (previewWrap) { previewWrap.style.display = 'flex'; }
        if (dropzone) { dropzone.style.display = 'none'; }
        if (dimLabel) { dimLabel.textContent = 'Cover photo - saved on the server'; }

        if (oldUrl) {
            // The displaced cover keeps this slot, so no photo is lost in a swap.
            var cardImg = card.querySelector('img');
            card.setAttribute('data-server-url', oldUrl);
            if (cardImg) { cardImg.src = oldUrl; }
        } else {
            card.remove();
        }
        renumberGallery();
        toast('Cover photo updated. Save the product to store it.');
        updateMediaCounts();
    };

    window.removeGalleryPhoto = function (btn) {
        var card = btn.closest('.dt-gallery-card');
        if (!card) { return; }
        card.style.transition = 'all 0.2s ease';
        card.style.opacity = '0';
        card.style.transform = 'scale(0.85)';
        setTimeout(function () {
            card.remove();
            renumberGallery();
            toast('Photo removed. Save the product to apply it.');
            updateMediaCounts();
        }, 200);
    };
    // ── 4. What the save path reads ─────────────────────────────────
    /**
     * The single source of truth for the product form. Only URLs the server
     * confirmed are returned — a base64 preview or a blob: URL is not a stored
     * file, and posting one wrote a truncated, permanently broken image path.
     */
    window.dtCollectMedia = function () {
        var mainImg = document.getElementById('mainPhotoImg');
        var primary = mainImg ? (mainImg.getAttribute('data-server-url') || '') : '';
        var gallery = [];
        var videos = [];
        var embeds = [];

        document.querySelectorAll('.dt-gallery-card').forEach(function (c) {
            var u = c.getAttribute('data-server-url');
            if (u && gallery.indexOf(u) === -1) { gallery.push(u); }
        });
        document.querySelectorAll('.dt-video-item-card').forEach(function (c) {
            var v = c.getAttribute('data-video-url');
            var e = c.getAttribute('data-embed-url');
            if (v && videos.indexOf(v) === -1) { videos.push(v); }
            if (e && embeds.indexOf(e) === -1) { embeds.push(e); }
        });
        if (primary && gallery.indexOf(primary) === -1) { gallery.unshift(primary); }

        return {
            primary_image: primary,
            gallery: gallery,
            videos: videos,
            embeds: embeds,
            pending: document.querySelectorAll('[data-uploading="1"]').length
        };
    };

    /**
     * Seed the studio with what the product already has on file, so opening the
     * edit form and saving it does not replace a full gallery with an empty one.
     */
    window.dtPrefillMedia = function (data) {
        if (!data) { return; }
        var grid = document.getElementById('dtGalleryPreviewGrid');
        var addSlot = grid ? grid.querySelector('.dt-gallery-add-slot') : null;
        var container = document.getElementById('dtVideoItemsContainer');
        var primary = String(data.primary_image || '');

        if (primary) {
            var mainImg = document.getElementById('mainPhotoImg');
            var previewWrap = document.getElementById('mainPhotoPreviewWrap');
            var dropzone = document.getElementById('mainPhotoDropzone');
            var dimLabel = document.getElementById('mainPhotoDim');
            if (mainImg) { mainImg.src = primary; mainImg.setAttribute('data-server-url', primary); }
            if (previewWrap) { previewWrap.style.display = 'flex'; }
            if (dropzone) { dropzone.style.display = 'none'; }
            if (dimLabel) { dimLabel.textContent = 'Cover photo on file'; }
        }
        (data.gallery || []).forEach(function (url) {
            if (!url || url === primary) { return; }
            var card = buildGalleryCard(url);
            card.setAttribute('data-server-url', url);
            if (addSlot && grid) { grid.insertBefore(card, addSlot); }
            else if (grid) { grid.appendChild(card); }
        });

        (data.videos || []).forEach(function (url) {
            if (!url) { return; }
            var card = buildVideoCard({
                title: 'Video on file',
                sub: url,
                badge: 'VIDEO',
                thumb: '<video controls playsinline preload="metadata" '
                    + 'style="width:100%;height:100%;object-fit:cover;background:#000;">'
                    + '<source src="' + esc(url) + '"></video>'
            });
            card.setAttribute('data-video-url', url);
            if (container) { container.appendChild(card); }
        });

        (data.embeds || []).forEach(function (url) {
            if (!url) { return; }
            var player = playerUrl(url);
            var card = buildVideoCard({
                title: hostOf(url) || 'Linked video',
                sub: url,
                badge: 'VIDEO LINK',
                thumb: player
                    ? '<iframe src="' + esc(player) + '" width="100%" height="100%" frameborder="0" '
                        + 'loading="lazy" allowfullscreen referrerpolicy="strict-origin-when-cross-origin" '
                        + 'style="border:none;"></iframe>'
                    : '<div style="display:flex;align-items:center;justify-content:center;height:100%;'
                        + 'background:#181512;color:#FDE047;font-size:10px;font-weight:700;">LINK</div>'
            });
            card.setAttribute('data-embed-url', url);
            if (container) { container.appendChild(card); }
        });

        renumberGallery();
        updateMediaCounts();
    };
    // ── 5. Counters and drag & drop ─────────────────────────────────
    function updateMediaCounts() {
        var media = window.dtCollectMedia();
        var photos = media.gallery.length;
        var clips = media.videos.length + media.embeds.length;

        var textEl = document.getElementById('dtMediaCountText');
        if (textEl) {
            var parts = [photos + ' Photo' + (photos === 1 ? '' : 's')];
            parts.push(clips === 0 ? 'No Video' : clips + ' Video' + (clips === 1 ? '' : 's'));
            if (media.pending > 0) { parts.push(media.pending + ' uploading...'); }
            textEl.textContent = parts.join(' • ');
        }
    }
    window.dtUpdateMediaCounts = updateMediaCounts;

    function setupDragAndDrop(elementId, callback) {
        var el = document.getElementById(elementId);
        if (!el) { return; }

        ['dragenter', 'dragover'].forEach(function (name) {
            el.addEventListener(name, function (e) {
                e.preventDefault();
                e.stopPropagation();
                el.classList.add('is-dragover');
            }, false);
        });
        ['dragleave', 'drop'].forEach(function (name) {
            el.addEventListener(name, function (e) {
                e.preventDefault();
                e.stopPropagation();
                el.classList.remove('is-dragover');
            }, false);
        });
        el.addEventListener('drop', function (e) {
            var files = e.dataTransfer ? e.dataTransfer.files : null;
            if (files && files.length) { callback(files); }
        }, false);
    }

    function initMediaDropzones() {
        setupDragAndDrop('mainPhotoDropzone', window.handleMainPhotoUpload);
        setupDragAndDrop('videoDropzone', window.handleProductVideoUpload);
        setupDragAndDrop('galleryDropzone', window.handleGalleryUpload);
        updateMediaCounts();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMediaDropzones);
    } else {
        initMediaDropzones();
    }
})();
