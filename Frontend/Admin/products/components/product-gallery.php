<?php
/**
 * product-gallery.php — Comprehensive Product Media Studio
 * Dedicated Main Photo (Cover), Product Video Studio (Upload & URL Embed), & Multi-Angle Gallery
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-form-section dt-media-studio-section">
    <div class="dt-form-sec-head" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
        <h3 class="dt-form-sec-title" style="margin:0;">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
            <span>Product Media, High-Res Photos &amp; Video Studio</span>
        </h3>
        <div style="display:flex; align-items:center; gap:8px;">
            <span class="dt-media-status-pill" id="dtMediaCountBadge">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                <span id="dtMediaCountText">3 Photos • 1 Video Ready</span>
            </span>
        </div>
    </div>

    <div class="dt-form-sec-body">
        
        <!-- Top Row: Main Photo Uploader + Product Video Studio (Side-by-Side on Desktop, Auto-Stacked on Mobile) -->
        <div class="dt-media-top-grid">
            
            <!-- ════════════ 1. MAIN / PRIMARY PHOTO (COVER IMAGE) ════════════ -->
            <div class="dt-media-card dt-main-photo-box">
                <div class="dt-media-card-header">
                    <div style="display:flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="#8A681F" stroke-width="2.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                        <strong style="font-size:12.5px; color:#181512; font-weight:800;">Main Photo (Primary Cover)</strong>
                    </div>
                    <span class="dt-primary-tag">
                        <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        PRIMARY
                    </span>
                </div>

                <div class="dt-media-card-body">
                    <!-- Main Photo Preview Container -->
                    <div class="dt-main-photo-preview-wrap" id="mainPhotoPreviewWrap">
                        <div class="dt-main-photo-img-holder">
                            <img id="mainPhotoImg" src="<?php echo isset($prod['primary_image']) ? htmlspecialchars($prod['primary_image']) : '/Frontend/Shop/Asset/images/product1.png'; ?>" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" alt="Main Product Photo">
                            
                            <!-- Overlay on Hover -->
                            <div class="dt-main-photo-overlay">
                                <button type="button" class="dt-media-pill-btn gold" onclick="document.getElementById('mainPhotoFileInput').click();">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                    <span>Change</span>
                                </button>
                                <button type="button" class="dt-media-pill-btn danger" onclick="removeMainPhoto();">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    <span>Remove</span>
                                </button>
                            </div>
                        </div>

                        <!-- Main Photo Metadata Info -->
                        <div class="dt-main-photo-info">
                            <div class="dt-meta-row">
                                <span class="dt-meta-label">Display:</span>
                                <span class="dt-meta-val" id="mainPhotoDim">Storefront Cover (3:4 HD)</span>
                            </div>
                            <div class="dt-meta-row">
                                <span class="dt-meta-label">Format:</span>
                                <span class="dt-meta-val">WebP / JPG Optimized</span>
                            </div>
                            <div class="dt-meta-row">
                                <span class="dt-meta-label">Status:</span>
                                <span class="dt-meta-val" style="color:#15803D;">Catalog Live</span>
                            </div>
                            <div style="margin-top:8px;">
                                <button type="button" class="dt-btn-action-sm gold" onclick="document.getElementById('mainPhotoFileInput').click();" style="width:100%; justify-content:center;">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                    <span>Upload Main Photo</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Empty State Dropzone for Main Photo (Shows if removed) -->
                    <div class="dt-main-photo-dropzone" id="mainPhotoDropzone" style="display:none;" onclick="document.getElementById('mainPhotoFileInput').click();">
                        <div class="dt-drop-icon">
                            <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="#8A681F" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        </div>
                        <h4 style="margin:4px 0; font-size:12.5px; color:#181512; font-weight:700;">Drop Main Cover Photo Here</h4>
                        <p style="margin:0; font-size:11px; color:#646970;">or click to browse from device (JPG, PNG, WebP)</p>
                    </div>

                    <!-- Hidden Input File -->
                    <input type="file" id="mainPhotoFileInput" accept="image/*" style="display:none;" onchange="handleMainPhotoUpload(this.files)">
                </div>
            </div>

            <!-- ════════════ 2. MULTI-VIDEO PRODUCT STUDIO (MULTIPLE MP4 & REELS) ════════════ -->
            <div class="dt-media-card dt-video-studio-box">
                <div class="dt-media-card-header">
                    <div style="display:flex; align-items:center; gap:6px;">
                        <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.5"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>
                        <strong style="font-size:12.5px; color:#181512; font-weight:800;">Product Video Studio</strong>
                    </div>

                    <!-- Clean Tab Switcher -->
                    <div class="dt-video-tabs">
                        <button type="button" class="dt-vtab-btn active" id="vTabUploadBtn" onclick="switchVideoTab('upload')">
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            <span>Upload MP4</span>
                        </button>
                        <button type="button" class="dt-vtab-btn" id="vTabUrlBtn" onclick="switchVideoTab('url')">
                            <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
                            <span>Reel / Link</span>
                        </button>
                    </div>
                </div>

                <div class="dt-media-card-body">
                    
                    <!-- TAB 1: Direct MP4 Multi-Video Upload View -->
                    <div id="videoUploadTabPane" class="dt-vtab-pane active">
                        
                        <!-- Dynamic List of Uploaded Videos -->
                        <div class="dt-video-items-list" id="dtVideoItemsContainer">
                            
                            <!-- Video Item 1 (Primary Model Draping Walkthrough) -->
                            <div class="dt-video-item-card" data-video-id="1">
                                <div class="dt-video-card-thumb">
                                    <video controls playsinline preload="metadata" poster="/Shared/Asset/images/product1.png">
                                        <source src="https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4" type="video/mp4">
                                    </video>
                                    <span class="dt-video-hd-badge">
                                        <svg viewBox="0 0 24 24" width="8" height="8" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                                        HD 1080P
                                    </span>
                                </div>

                                <div class="dt-video-card-meta">
                                    <div class="dt-v-title">Video 1: Saree Draping Walkthrough</div>
                                    <div class="dt-v-sub">1080p HD • Ready for WhatsApp &amp; PDP</div>
                                    <div style="display:flex; gap:6px; margin-top:3px;">
                                        <button type="button" class="dt-btn-action-sm danger" onclick="removeVideoItem(this);" style="padding:2px 8px; font-size:10.5px;">
                                            <svg viewBox="0 0 24 24" width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                            <span>Remove</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Dropzone to Add More Videos -->
                        <div class="dt-video-dropzone" id="videoDropzone" onclick="document.getElementById('productVideoFileInput').click();">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="#8A681F" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>
                            <span style="font-size:11.5px; font-weight:700; color:#181512;">+ Upload Another Video</span>
                            <span style="font-size:10px; color:#646970;">(MP4 / WebM up to 50MB)</span>
                        </div>

                        <!-- Hidden Multi-Video File Input -->
                        <input type="file" id="productVideoFileInput" accept="video/mp4,video/webm,video/quicktime" multiple style="display:none;" onchange="handleProductVideoUpload(this.files)">
                    </div>

                    <!-- TAB 2: Video / Instagram Reels / YouTube URL Embed -->
                    <div id="videoUrlTabPane" class="dt-vtab-pane" style="display:none;">
                        <div style="padding:4px 0;">
                            <label class="dt-form-label" style="font-size:11px; margin-bottom:4px;">Paste Video Link (YouTube Shorts / Watch, Instagram Reel, or Direct MP4):</label>
                            <div style="display:flex; gap:6px;">
                                <input type="url" id="dtVideoUrlInput" class="dt-form-input" placeholder="e.g. https://www.youtube.com/shorts/... or https://instagram.com/reel/..." style="flex:1; font-size:11.5px;">
                                <button type="button" class="dt-btn-action-sm gold" onclick="handleVideoUrlEmbed();">
                                    <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    <span>Add Link</span>
                                </button>
                            </div>
                            <span style="font-size:10px; color:#646970; display:block; margin-top:4px;">Add multiple video links (Reels, Shorts, Draping walkthroughs).</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- ════════════ 3. ADDITIONAL GALLERY PHOTOS & MULTI-ANGLE SHOTS ════════════ -->
        <div class="dt-gallery-section" style="margin-top:14px; border-top:1px solid #e2e4e7; padding-top:12px;">
            <div style="margin-bottom:8px;">
                <strong style="font-size:12.5px; color:#181512; font-weight:800;">Additional Product Photos &amp; Angle Shots</strong>
                <span style="font-size:11px; color:#646970; margin-left:6px;">(Back angle, Pallu close-up, Blouse embroidery, Model shoot)</span>
            </div>

            <!-- Multi-Image Dropzone -->
            <div class="dt-dropzone dt-gallery-dropzone" id="galleryDropzone" onclick="document.getElementById('dtGalleryFileInput').click();">
                <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="#8A681F" stroke-width="1.8" style="margin-bottom:3px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                <h4 style="font-weight:700; font-size:12px; color:#1d2327; margin:0 0 2px 0;">Drag &amp; Drop Additional Photos or Click to Browse</h4>
                <p style="font-size:10.5px; color:#646970; margin:0;">Supports multiple WebP, PNG, JPG files • Click "Set Main" on any photo to switch.</p>
                <input type="file" id="dtGalleryFileInput" style="display:none;" multiple accept="image/*" onchange="handleGalleryUpload(this.files)">
            </div>

            <!-- Dynamic Gallery Thumbnails Grid -->
            <div class="dt-gallery-preview-grid" id="dtGalleryPreviewGrid" style="margin-top:10px;">
                
                <!-- Gallery Item 1 (Angle 2) -->
                <div class="dt-gallery-card" data-src="/Shared/Asset/images/product2.png">
                    <div class="dt-gallery-img-wrap">
                        <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" alt="Angle 2">
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
                    <div class="dt-gallery-card-caption">Angle 2 (Pallu)</div>
                </div>

                <!-- Gallery Item 2 (Angle 3) -->
                <div class="dt-gallery-card" data-src="/Shared/Asset/images/product3.png">
                    <div class="dt-gallery-img-wrap">
                        <img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" alt="Angle 3">
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
                    <div class="dt-gallery-card-caption">Angle 3 (Detail)</div>
                </div>

                <!-- Quick "Add Photo" Drop Slot -->
                <div class="dt-gallery-add-slot" onclick="document.getElementById('dtGalleryFileInput').click();" title="Click to upload more photos">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="#8A681F" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Add Photo</span>
                </div>

            </div>
        </div>

    </div>
</div>

