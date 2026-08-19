<?php
/**
 * product-gallery.php — Media Dropzone & High-Res Gallery Studio
 */
?>
<div class="dt-form-section">
    <div class="dt-form-sec-head">
        <h3 class="dt-form-sec-title"><span>📸 Product Media &amp; High-Res Photos</span></h3>
    </div>
    <div class="dt-form-sec-body">
        <div class="dt-dropzone" onclick="document.getElementById('dtMediaFileInput').click()">
            <div style="font-size:2.2rem; margin-bottom:8px;">📤</div>
            <h4 style="font-weight:800; margin-bottom:4px;">Drag &amp; Drop Product Photos or Click to Browse</h4>
            <p style="font-size:0.75rem; color:#7A7266;">Supports WebP, PNG, JPG (High resolution recommended. Web-optimized automatically).</p>
            <input type="file" id="dtMediaFileInput" style="display:none;" multiple onchange="if(typeof handleImageUpload==='function') handleImageUpload(this.files);">
        </div>

        <div class="dt-gallery-preview-grid">
            <div class="dt-gallery-item is-main">
                <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" alt="Main Photo">
                <span class="dt-gallery-main-tag">PRIMARY</span>
            </div>
            <div class="dt-gallery-item">
                <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" alt="Angle 2">
            </div>
            <div class="dt-gallery-item">
                <img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" alt="Angle 3">
            </div>
        </div>
    </div>
</div>
