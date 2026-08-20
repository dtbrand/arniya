/**
 * product-gallery.js — Comprehensive Product Media Engine
 * DT Brand's & Jai Hanuman Tex
 * Handles: Main Photo Upload, Video Upload / Embed, and Interactive Gallery Management
 */
(function() {
    'use strict';

    // ══════════════════════════════════════════════════════════════
    // 1. MAIN / PRIMARY PHOTO HANDLERS
    // ══════════════════════════════════════════════════════════════
    window.handleMainPhotoUpload = function(files) {
        if (!files || !files.length) return;
        const file = files[0];

        if (!file.type.startsWith('image/')) {
            if (typeof window.showToast === 'function') {
                window.showToast('⚠️ Please upload a valid image file (JPG, PNG, WebP)');
            }
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const mainImg = document.getElementById('mainPhotoImg');
            const previewWrap = document.getElementById('mainPhotoPreviewWrap');
            const dropzone = document.getElementById('mainPhotoDropzone');
            const dimLabel = document.getElementById('mainPhotoDim');

            if (mainImg) {
                mainImg.src = e.target.result;
            }
            if (previewWrap) previewWrap.style.display = 'flex';
            if (dropzone) dropzone.style.display = 'none';

            // Calculate size in KB/MB
            const sizeStr = file.size > 1024 * 1024 
                ? (file.size / (1024 * 1024)).toFixed(2) + ' MB' 
                : Math.round(file.size / 1024) + ' KB';

            if (dimLabel) {
                dimLabel.textContent = `High-Res Cover (${sizeStr})`;
            }

            if (typeof window.showToast === 'function') {
                window.showToast('⭐️ Main catalog photo updated successfully!');
            }
            updateMediaCounts();
        };
        reader.readAsDataURL(file);
    };

    window.removeMainPhoto = function() {
        const previewWrap = document.getElementById('mainPhotoPreviewWrap');
        const dropzone = document.getElementById('mainPhotoDropzone');
        const fileInput = document.getElementById('mainPhotoFileInput');
        const mainImg = document.getElementById('mainPhotoImg');

        if (mainImg) mainImg.src = '';
        if (fileInput) fileInput.value = '';
        if (previewWrap) previewWrap.style.display = 'none';
        if (dropzone) dropzone.style.display = 'block';

        if (typeof window.showToast === 'function') {
            window.showToast('Main photo removed. Please upload or set a cover photo.');
        }
        updateMediaCounts();
    };

    // ══════════════════════════════════════════════════════════════
    // 2. PRODUCT VIDEO STUDIO HANDLERS
    // ══════════════════════════════════════════════════════════════
    window.switchVideoTab = function(tab) {
        const uploadBtn = document.getElementById('vTabUploadBtn');
        const urlBtn = document.getElementById('vTabUrlBtn');
        const uploadPane = document.getElementById('videoUploadTabPane');
        const urlPane = document.getElementById('videoUrlTabPane');

        if (tab === 'upload') {
            if (uploadBtn) uploadBtn.classList.add('active');
            if (urlBtn) urlBtn.classList.remove('active');
            if (uploadPane) uploadPane.style.display = 'block';
            if (urlPane) urlPane.style.display = 'none';
        } else {
            if (urlBtn) urlBtn.classList.add('active');
            if (uploadBtn) uploadBtn.classList.remove('active');
            if (uploadPane) uploadPane.style.display = 'none';
            if (urlPane) urlPane.style.display = 'block';
        }
    };

    window.handleProductVideoUpload = function(files) {
        if (!files || !files.length) return;
        const file = files[0];

        if (!file.type.startsWith('video/')) {
            if (typeof window.showToast === 'function') {
                window.showToast('⚠️ Please upload a valid MP4, WebM, or MOV video file.');
            }
            return;
        }

        if (file.size > 60 * 1024 * 1024) {
            if (typeof window.showToast === 'function') {
                window.showToast('⚠️ Video file size exceeds 50MB limit.');
            }
            return;
        }

        const videoUrl = URL.createObjectURL(file);
        const player = document.getElementById('productVideoPlayer');
        const playerWrap = document.getElementById('videoPlayerWrap');
        const dropzone = document.getElementById('videoDropzone');
        const fileNameLabel = document.getElementById('dtVideoFileName');

        if (player) {
            player.src = videoUrl;
            player.load();
        }

        const sizeStr = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
        if (fileNameLabel) {
            fileNameLabel.textContent = `${file.name} (${sizeStr})`;
        }

        if (playerWrap) playerWrap.style.display = 'flex';
        if (dropzone) dropzone.style.display = 'none';

        if (typeof window.showToast === 'function') {
            window.showToast('🎬 HD Product Video attached & ready for playback!');
        }
        updateMediaCounts();
    };

    window.removeProductVideo = function() {
        const player = document.getElementById('productVideoPlayer');
        const playerWrap = document.getElementById('videoPlayerWrap');
        const dropzone = document.getElementById('videoDropzone');
        const fileInput = document.getElementById('productVideoFileInput');

        if (player) {
            player.pause();
            player.removeAttribute('src');
            player.load();
        }
        if (fileInput) fileInput.value = '';
        if (playerWrap) playerWrap.style.display = 'none';
        if (dropzone) dropzone.style.display = 'block';

        if (typeof window.showToast === 'function') {
            window.showToast('Product video removed.');
        }
        updateMediaCounts();
    };

    window.handleVideoUrlEmbed = function() {
        const input = document.getElementById('dtVideoUrlInput');
        if (!input) return;
        const rawUrl = (input.value || '').trim();

        if (!rawUrl) {
            if (typeof window.showToast === 'function') {
                window.showToast('⚠️ Please enter a valid video link.');
            }
            return;
        }

        const embedHolder = document.getElementById('dtVideoEmbedHolder');
        const embedFrame = document.getElementById('dtVideoEmbedFrame');

        let embedHtml = '';

        // Check for YouTube Shorts or Watch URL
        if (rawUrl.includes('youtube.com/shorts/') || rawUrl.includes('youtu.be/') || rawUrl.includes('youtube.com/watch')) {
            let ytId = '';
            if (rawUrl.includes('/shorts/')) {
                ytId = rawUrl.split('/shorts/')[1].split('?')[0].split('/')[0];
            } else if (rawUrl.includes('youtu.be/')) {
                ytId = rawUrl.split('youtu.be/')[1].split('?')[0].split('/')[0];
            } else if (rawUrl.includes('v=')) {
                ytId = rawUrl.split('v=')[1].split('&')[0];
            }

            if (ytId) {
                embedHtml = `<iframe width="100%" height="100%" src="https://www.youtube.com/embed/${ytId}?autoplay=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="border:none;"></iframe>`;
            }
        } 
        // Check for Direct MP4 / WebM URL
        else if (rawUrl.endsWith('.mp4') || rawUrl.endsWith('.webm') || rawUrl.endsWith('.mov')) {
            embedHtml = `<video controls playsinline style="width:100%; height:100%; object-fit:cover; background:#000;"><source src="${rawUrl}" type="video/mp4"></video>`;
        }
        // Instagram Reel / Generic Embed
        else {
            embedHtml = `<div style="display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%; color:#FAF5E8; text-align:center; padding:12px;">
                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="#D4AF37" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                <div style="font-size:12px; font-weight:700; margin-top:4px; color:#FDE047;">Live Stream Reel URL Linked</div>
                <div style="font-size:11px; color:#c3c4c7; max-width:85%; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">${rawUrl}</div>
            </div>`;
        }

        if (embedFrame && embedHtml) {
            embedFrame.innerHTML = embedHtml;
            if (embedHolder) embedHolder.style.display = 'block';
            if (typeof window.showToast === 'function') {
                window.showToast('🎬 Video link embedded successfully!');
            }
            updateMediaCounts();
        }
    };

    window.removeVideoUrlEmbed = function() {
        const input = document.getElementById('dtVideoUrlInput');
        const embedHolder = document.getElementById('dtVideoEmbedHolder');
        const embedFrame = document.getElementById('dtVideoEmbedFrame');

        if (input) input.value = '';
        if (embedFrame) embedFrame.innerHTML = '';
        if (embedHolder) embedHolder.style.display = 'none';

        if (typeof window.showToast === 'function') {
            window.showToast('Video URL cleared.');
        }
        updateMediaCounts();
    };

    // ══════════════════════════════════════════════════════════════
    // 3. ADDITIONAL GALLERY PHOTOS HANDLERS
    // ══════════════════════════════════════════════════════════════
    window.handleGalleryUpload = function(files) {
        if (!files || !files.length) return;

        const grid = document.getElementById('dtGalleryPreviewGrid');
        const addSlot = grid ? grid.querySelector('.dt-gallery-add-slot') : null;
        let loadedCount = 0;

        Array.from(files).forEach((file, index) => {
            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const card = document.createElement('div');
                card.className = 'dt-gallery-card';
                card.setAttribute('data-src', e.target.result);
                card.innerHTML = `
                    <div class="dt-gallery-img-wrap">
                        <img src="${e.target.result}" alt="Gallery Angle">
                        <div class="dt-gallery-card-actions">
                            <button type="button" class="dt-gaction-btn make-main" title="Set as Main Photo" onclick="setAsMainPhoto(this);">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <span>Set Main</span>
                            </button>
                            <button type="button" class="dt-gaction-btn remove" title="Delete Photo" onclick="removeGalleryPhoto(this);">
                                <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                            </button>
                        </div>
                    </div>
                    <div class="dt-gallery-card-caption">Angle ${document.querySelectorAll('.dt-gallery-card').length + 1}</div>
                `;

                if (addSlot && grid) {
                    grid.insertBefore(card, addSlot);
                } else if (grid) {
                    grid.appendChild(card);
                }

                loadedCount++;
                if (loadedCount === files.length) {
                    if (typeof window.showToast === 'function') {
                        window.showToast(`📸 ${loadedCount} gallery photo(s) added successfully!`);
                    }
                    updateMediaCounts();
                }
            };
            reader.readAsDataURL(file);
        });
    };

    window.setAsMainPhoto = function(btn) {
        const card = btn.closest('.dt-gallery-card');
        if (!card) return;

        const cardImg = card.querySelector('img');
        const newSrc = cardImg ? cardImg.src : card.getAttribute('data-src');

        const mainImg = document.getElementById('mainPhotoImg');
        const previewWrap = document.getElementById('mainPhotoPreviewWrap');
        const dropzone = document.getElementById('mainPhotoDropzone');

        if (mainImg && newSrc) {
            const oldMainSrc = mainImg.src;
            mainImg.src = newSrc;

            if (previewWrap) previewWrap.style.display = 'flex';
            if (dropzone) dropzone.style.display = 'none';

            // If previous main existed, swap it into the gallery card
            if (oldMainSrc && !oldMainSrc.includes('data:,') && cardImg) {
                cardImg.src = oldMainSrc;
                card.setAttribute('data-src', oldMainSrc);
            }

            if (typeof window.showToast === 'function') {
                window.showToast('⭐️ Photo swapped to Primary Main Cover!');
            }
            updateMediaCounts();
        }
    };

    window.removeGalleryPhoto = function(btn) {
        const card = btn.closest('.dt-gallery-card');
        if (card) {
            card.style.opacity = '0';
            card.style.transform = 'scale(0.85)';
            card.style.transition = 'all 0.2s ease';
            setTimeout(() => {
                card.remove();
                if (typeof window.showToast === 'function') {
                    window.showToast('Photo removed from gallery.');
                }
                updateMediaCounts();
            }, 200);
        }
    };

    // ══════════════════════════════════════════════════════════════
    // 4. MEDIA STATUS COUNTER HELPER
    // ══════════════════════════════════════════════════════════════
    function updateMediaCounts() {
        const mainImg = document.getElementById('mainPhotoImg');
        const mainWrap = document.getElementById('mainPhotoPreviewWrap');
        const hasMain = mainWrap && mainWrap.style.display !== 'none' && mainImg && mainImg.src && !mainImg.src.endsWith('/');

        const galleryCards = document.querySelectorAll('.dt-gallery-card').length;
        const totalPhotos = (hasMain ? 1 : 0) + galleryCards;

        const videoPlayer = document.getElementById('productVideoPlayer');
        const videoWrap = document.getElementById('videoPlayerWrap');
        const hasVideo = (videoWrap && videoWrap.style.display !== 'none' && videoPlayer && videoPlayer.src) 
                      || (document.getElementById('dtVideoEmbedHolder')?.style.display === 'block');

        const textEl = document.getElementById('dtMediaCountText');
        if (textEl) {
            textEl.textContent = `${totalPhotos} Photo${totalPhotos === 1 ? '' : 's'} • ${hasVideo ? '1 Video Ready' : 'No Video'}`;
        }
    }

    // ══════════════════════════════════════════════════════════════
    // 5. DRAG & DROP INITIALIZATION
    // ══════════════════════════════════════════════════════════════
    function setupDragAndDrop(elementId, callback) {
        const el = document.getElementById(elementId);
        if (!el) return;

        ['dragenter', 'dragover'].forEach(eventName => {
            el.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                el.classList.add('is-dragover');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            el.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                el.classList.remove('is-dragover');
            }, false);
        });

        el.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files && files.length) {
                callback(files);
            }
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

