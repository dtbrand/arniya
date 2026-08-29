/**
 * resellers.js — DT Brand's & Jai Hanuman Tex
 * Global Toast Notifications, Modal Utilities, and Tab Switching
 */

(function () {
    'use strict';

    // ── Global Toast Function ──
    window.showToast = function (message) {
        let container = document.getElementById('dtToastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'dtToastContainer';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = 'dt-toast';
        toast.innerHTML = `
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#D4AF37" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
            <span>${message}</span>
        `;
        container.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3200);
    };

    // ── Generic Modal Controls ──
    window.openModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
    };

    window.closeModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('open');
            document.body.style.overflow = '';
        }
    };

    // ── Global Tab Switching ──
    window.switchResellerTab = function (tabKey, btn) {
        document.querySelectorAll('.dt-reseller-tab-link').forEach(l => l.classList.remove('active'));
        if (btn) btn.classList.add('active');

        document.querySelectorAll('.dt-reseller-tab-pane').forEach(p => p.style.display = 'none');
        const target = document.getElementById(`tabPane-${tabKey}`);
        if (target) {
            target.style.display = 'block';
        }
    };

    // Close modal on Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.dt-modal-backdrop.open').forEach(m => {
                m.classList.remove('open');
            });
            document.body.style.overflow = '';
        }
    });

})();
