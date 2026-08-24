/**
 * retail.js — DT Brand's & Jai Hanuman Tex
 * Retail Management Core JavaScript Engine
 */

(function () {
    'use strict';

    // ── Global Toast Notification ──
    if (typeof window.showToast !== 'function') {
        window.showToast = function (msg, isError) {
            let toast = document.getElementById('dtAdminGlobalToast');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'dtAdminGlobalToast';
                toast.style.cssText = 'position:fixed; bottom:24px; right:24px; background:#181512; color:#FAF5E8; border:1px solid #D4AF37; padding:12px 18px; border-radius:8px; font-size:0.82rem; font-weight:700; z-index:999999; box-shadow:0 10px 30px rgba(0,0,0,0.4); display:none; transition:all 0.3s cubic-bezier(0.16, 1, 0.3, 1);';
                document.body.appendChild(toast);
            }
            toast.innerText = msg;
            toast.style.borderColor = isError ? '#DC2626' : '#D4AF37';
            toast.style.display = 'block';
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';

            clearTimeout(window.__toastTimer);
            window.__toastTimer = setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(10px)';
                setTimeout(() => { toast.style.display = 'none'; }, 300);
            }, 3500);
        };
    }

    // ── Modal Open / Close Helpers ──
    window.openRetailModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            const firstInput = modal.querySelector('input, select, textarea');
            if (firstInput) firstInput.focus();
        }
    };

    window.closeRetailModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    };

    // Close on Escape or Backdrop click
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.dt-modal-backdrop').forEach(modal => {
                if (modal.style.display === 'flex') {
                    modal.style.display = 'none';
                    document.body.style.overflow = '';
                }
            });
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('dt-modal-backdrop')) {
            e.target.style.display = 'none';
            document.body.style.overflow = '';
        }
    });

})();
