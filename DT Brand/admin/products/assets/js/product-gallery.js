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
    // 2. MULTI-VIDEO PRODUCT STUDIO HANDLERS
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

        const container = document.getElementById('dtVideoItemsContainer');
        let addedCount = 0;

        Array.from(files).forEach((file) => {
            if (!file.type.startsWith('video/')) return;

            if (file.size > 60 * 1024 * 1024) {
                if (typeof window.showToast === 'function') {
                    window.showToast(`⚠️ ${file.name} exceeds 50MB limit.`);
                }
                return;
            }

            const videoUrl = URL.createObjectURL(file);
            const sizeStr = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
            const totalVideos = document.querySelectorAll('.dt-video-item-card').length + 1;

            const card = document.createElement('div');
            card.className = 'dt-video-item-card';
            card.innerHTML = `
                <div class="dt-video-card-thumb">
                    <video controls playsinline preload="metadata" style="width:100%; height:100%; object-fit:cover;">
                        <source src="${videoUrl}" type="${file.type || 'video/mp4'}">
                    </video>
                    <span class="dt-video-hd-badge">
                        <svg viewBox="0 0 24 24" width="9" height="9" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                        VIDEO ${totalVideos}
                    </span>
                </div>
                <div class="dt-video-card-meta">
                    <div style="font-size:11.5px; font-weight:700; color:#181512; margin-bottom:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" class="dt-v-title">${file.name}</div>
                    <div style="font-size:10.5px; color:#646970; margin-bottom:4px;" class="dt-v-sub">${sizeStr} • Ready for WhatsApp &amp; PDP</div>
                    <div style="display:flex; gap:6px;">
                        <button type="button" class="dt-btn-action-sm danger" onclick="removeVideoItem(this);">
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            <span>Remove</span>
                        </button>
                    </div>
                </div>
            `;

            if (container) {
                container.appendChild(card);
            }
            addedCount++;
        });

        if (addedCount > 0) {
            if (typeof window.showToast === 'function') {
                window.showToast(`🎬 ${addedCount} product video(s) added successfully!`);
            }
            updateMediaCounts();
        }
    };

    window.removeVideoItem = function(btn) {
        const card = btn.closest('.dt-video-item-card');
        if (card) {
            const player = card.querySelector('video');
            if (player) {
                player.pause();
                player.removeAttribute('src');
            }
            card.style.opacity = '0';
            card.style.transform = 'scale(0.85)';
            card.style.transition = 'all 0.2s ease';
            setTimeout(() => {
                card.remove();
                if (typeof window.showToast === 'function') {
                    window.showToast('Video removed from product.');
                }
                updateMediaCounts();
            }, 200);
        }
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

        const container = document.getElementById('dtVideoItemsContainer');
        const totalVideos = document.querySelectorAll('.dt-video-item-card').length + 1;

        let playerHtml = '';
        let title = 'Linked Video';

        if (rawUrl.includes('youtube.com/shorts/') || rawUrl.includes('youtu.be/') || rawUrl.includes('youtube.com/watch')) {
            let ytId = '';
            if (rawUrl.includes('/shorts/')) {
                ytId = rawUrl.split('/shorts/')[1].split('?')[0].split('/')[0];
                title = 'YouTube Shorts Reel';
            } else if (rawUrl.includes('youtu.be/')) {
                ytId = rawUrl.split('youtu.be/')[1].split('?')[0].split('/')[0];
                title = 'YouTube Walkthrough';
            } else if (rawUrl.includes('v=')) {
                ytId = rawUrl.split('v=')[1].split('&')[0];
                title = 'YouTube Video';
            }

            if (ytId) {
                playerHtml = `<iframe width="100%" height="100%" src="https://www.youtube.com/embed/${ytId}?autoplay=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="border:none;"></iframe>`;
            }
        } else if (rawUrl.endsWith('.mp4') || rawUrl.endsWith('.webm') || rawUrl.endsWith('.mov')) {
            playerHtml = `<video controls playsinline style="width:100%; height:100%; object-fit:cover; background:#000;"><source src="${rawUrl}" type="video/mp4"></video>`;
            title = 'Cloud MP4 Video';
        } else {
            playerHtml = `<div style="display:flex; flex-direction:column; align-items:center; justify-content:center; height:100%; color:#FAF5E8; text-align:center; padding:8px; background:#181512;">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#D4AF37" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>
                <div style="font-size:10px; font-weight:700; color:#FDE047; margin-top:2px;">Reel Link</div>
            </div>`;
            title = 'Instagram Reel Video';
        }

        const card = document.createElement('div');
        card.className = 'dt-video-item-card';
        card.innerHTML = `
            <div class="dt-video-card-thumb">
                ${playerHtml}
                <span class="dt-video-hd-badge">
                    <svg viewBox="0 0 24 24" width="9" height="9" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                    URL VIDEO
                </span>
            </div>
            <div class="dt-video-card-meta">
                <div style="font-size:11.5px; font-weight:700; color:#181512; margin-bottom:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;" class="dt-v-title">${title} (${totalVideos})</div>
                <div style="font-size:10px; color:#646970; margin-bottom:4px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" class="dt-v-sub">${rawUrl}</div>
                <div style="display:flex; gap:6px;">
                    <button type="button" class="dt-btn-action-sm danger" onclick="removeVideoItem(this);">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                        <span>Remove</span>
                    </button>
                </div>
            </div>
        `;

        if (container) {
            container.appendChild(card);
        }

        input.value = '';
        if (typeof window.showToast === 'function') {
            window.showToast('🎬 Video link added successfully!');
        }
        // Switch back to upload tab to see list
        switchVideoTab('upload');
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

        const videoCards = document.querySelectorAll('.dt-video-item-card').length;

        const textEl = document.getElementById('dtMediaCountText');
        if (textEl) {
            const videoText = videoCards === 0 ? 'No Video' : `${videoCards} Video${videoCards === 1 ? '' : 's'} Ready`;
            textEl.textContent = `${totalPhotos} Photo${totalPhotos === 1 ? '' : 's'} • ${videoText}`;
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

