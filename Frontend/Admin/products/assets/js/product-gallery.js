/**
 * product-gallery.js — Drag & Drop Media Upload Simulation
 */
(function() {
    'use strict';

    window.handleImageUpload = function(files) {
        if (!files || !files.length) return;
        window.showToast(`📸 ${files.length} product images uploaded successfully!`);
    };

    window.setMainImage = function(btn) {
        document.querySelectorAll('.dt-gallery-item').forEach(el => el.classList.remove('is-main'));
        const item = btn.closest('.dt-gallery-item');
        if (item) {
            item.classList.add('is-main');
            window.showToast('⭐️ Set as primary catalog image.');
        }
    };
})();
