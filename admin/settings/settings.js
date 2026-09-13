// settings.js — DT Brand's Store Settings Interactive Engine

(function() {
    'use strict';

    function dtCloseConfirmModal() {
        var overlay = document.getElementById('dtConfirmModal');
        if (overlay) overlay.classList.remove('active');
    }
    window.dtCloseConfirmModal = dtCloseConfirmModal;

    // Global Confirm Modal API (Replaces window.confirm)
    window.dtShowConfirmModal = function(opts) {
        opts = opts || {};
        var overlay = document.getElementById('dtConfirmModal');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.id = 'dtConfirmModal';
            overlay.className = 'dt-modal-overlay';
            overlay.innerHTML = [
                '<div class="dt-modal-card">',
                '  <div class="dt-modal-head">',
                '    <div class="dt-modal-title">',
                '      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#D4AF37" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>',
                '      <span id="dtConfirmModalTitle">Confirm Action</span>',
                '    </div>',
                '    <button type="button" class="dt-modal-close" onclick="window.dtCloseConfirmModal()">&times;</button>',
                '  </div>',
                '  <div class="dt-modal-body" id="dtConfirmModalBody">Are you sure you want to proceed?</div>',
                '  <div class="dt-modal-foot">',
                '    <button type="button" class="dt-btn dt-btn-pale" style="padding:6px 14px; font-size:12px; font-weight:700;" onclick="window.dtCloseConfirmModal()">Cancel</button>',
                '    <button type="button" class="dt-btn dt-btn-gold" id="dtConfirmModalBtn" style="padding:6px 16px; font-size:12px; font-weight:800;">Confirm</button>',
                '  </div>',
                '</div>'
            ].join('');
            document.body.appendChild(overlay);

            overlay.addEventListener('click', function(e) {
                if (e.target === overlay) dtCloseConfirmModal();
            });
        }

        document.getElementById('dtConfirmModalTitle').innerText = opts.title || 'Confirm Action';
        document.getElementById('dtConfirmModalBody').innerHTML = opts.message || 'Are you sure you want to proceed?';
        var btn = document.getElementById('dtConfirmModalBtn');
        btn.innerText = opts.confirmText || 'Confirm';

        // Clear previous click handlers
        var newBtn = btn.cloneNode(true);
        btn.parentNode.replaceChild(newBtn, btn);

        newBtn.addEventListener('click', function() {
            dtCloseConfirmModal();
            if (typeof opts.onConfirm === 'function') {
                opts.onConfirm();
            }
        });

        overlay.classList.add('active');
    };

    // Keyboard shortcut for saving (Ctrl+S / Cmd+S)
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && (e.key === 's' || e.key === 'S')) {
            var saveBtn = document.querySelector('.dt-btn-gold[onclick*="dtSettingsSave"], button[name="save_settings"], button[type="submit"].dt-btn-gold');
            if (saveBtn && !saveBtn.disabled) {
                e.preventDefault();
                saveBtn.click();
            }
        }
    });

    // Auto-dismiss banners / alerts after transition
    document.addEventListener('DOMContentLoaded', function() {
        // Highlight active nav card if matching current location
        var path = window.location.pathname;
        var cards = document.querySelectorAll('.dt-settings-nav-card');
        cards.forEach(function(card) {
            var href = card.getAttribute('href');
            if (href && (path === href || path.endsWith(href))) {
                card.classList.add('active');
            }
        });
    });
})();
