<?php
/**
 * product-gallery.php — Media Dropzone & High-Res Gallery Studio
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" style="color:#8A681F;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
            <span>Product Media &amp; High-Res Photos</span>
        </h3>
    </div>
    <div class="dt-form-sec-body">
        <div class="dt-dropzone" onclick="document.getElementById('dtMediaFileInput').click()" style="cursor:pointer; text-align:center; padding:20px; border:2px dashed #c3c4c7; border-radius:6px; background:#fbfbfb;">
            <svg viewBox="0 0 24 24" width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.8" style="color:#8A681F; margin-bottom:6px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
            <h4 style="font-weight:700; font-size:13px; color:#1d2327; margin:0 0 4px 0;">Drag &amp; Drop Product Photos or Click to Browse</h4>
            <p style="font-size:11.5px; color:#646970; margin:0;">Supports WebP, PNG, JPG (Auto-optimized for mobile &amp; wholesale catalog).</p>
            <input type="file" id="dtMediaFileInput" style="display:none;" multiple onchange="if(typeof handleImageUpload==='function') handleImageUpload(this.files);">
        </div>

        <div class="dt-gallery-preview-grid" style="display:flex; gap:10px; margin-top:12px;">
            <div class="dt-gallery-item is-main" style="position:relative; width:80px; height:80px; border-radius:4px; overflow:hidden; border:2px solid #8A681F;">
                <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" style="width:100%!important; height:100%!important; object-fit:cover!important;" alt="Main Photo">
                <span class="dt-gallery-main-tag" style="position:absolute; bottom:0; left:0; right:0; background:#8A681F; color:#fff; font-size:9px; font-weight:700; text-align:center; padding:1px 0;">PRIMARY</span>
            </div>
            <div class="dt-gallery-item" style="width:80px; height:80px; border-radius:4px; overflow:hidden; border:1px solid #c3c4c7;">
                <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" style="width:100%!important; height:100%!important; object-fit:cover!important;" alt="Angle 2">
            </div>
            <div class="dt-gallery-item" style="width:80px; height:80px; border-radius:4px; overflow:hidden; border:1px solid #c3c4c7;">
                <img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" style="width:100%!important; height:100%!important; object-fit:cover!important;" alt="Angle 3">
            </div>
        </div>
    </div>
</div>
