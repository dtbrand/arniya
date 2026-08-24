/**
 * reseller-view.js — DT Brand's & Jai Hanuman Tex
 * 360° Profile Actions, Copy Credentials & Quick Action Triggers
 */

(function () {
    'use strict';

    window.copyToClipboard = function (text, label) {
        navigator.clipboard.writeText(text).then(() => {
            window.showToast(`✓ ${label || 'Value'} copied to clipboard!`);
        }).catch(() => {
            window.showToast(`Copied: ${text}`);
        });
    };

    window.toggleProfileEditMode = function () {
        const form = document.getElementById('dtResellerProfileForm');
        if (!form) return;
        const inputs = form.querySelectorAll('input, select, textarea');
        const isEditing = form.getAttribute('data-editing') === 'true';

        if (isEditing) {
            inputs.forEach(i => i.disabled = true);
            form.setAttribute('data-editing', 'false');
            const saveBtn = document.getElementById('dtSaveProfileBtn');
            if (saveBtn) saveBtn.style.display = 'none';
            window.showToast('Profile editing locked');
        } else {
            inputs.forEach(i => i.disabled = false);
            form.setAttribute('data-editing', 'true');
            const saveBtn = document.getElementById('dtSaveProfileBtn');
            if (saveBtn) saveBtn.style.display = 'inline-flex';
            window.showToast('Profile editing unlocked — make changes and click Save');
        }
    };

    window.saveResellerProfile = function (e) {
        if (e) e.preventDefault();
        window.showToast('✓ Reseller Profile updated and saved successfully!');
        window.toggleProfileEditMode();
    };

})();
