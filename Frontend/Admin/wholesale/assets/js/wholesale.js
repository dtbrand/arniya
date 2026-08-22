/**
 * wholesale.js — DT Brand's & Jai Hanuman Tex
 * Core Wholesale Global Controller, Toasts & Modal Helpers
 */

(function () {
    'use strict';

    // Global Toast Notification Helper
    window.showToast = function (message, duration = 3000) {
        let toast = document.getElementById('dtWholesaleToast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'dtWholesaleToast';
            toast.style.cssText = `
                position: fixed;
                bottom: 24px;
                right: 24px;
                background: linear-gradient(135deg, #181512 0%, #2A241E 100%);
                border: 1.5px solid #D4AF37;
                color: #FFE57F;
                padding: 12px 20px;
                border-radius: 10px;
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-size: 0.82rem;
                font-weight: 800;
                box-shadow: 0 10px 30px rgba(0,0,0,0.4), 0 0 15px rgba(212,175,55,0.3);
                z-index: 999999;
                display: flex;
                align-items: center;
                gap: 10px;
                transform: translateY(100px);
                opacity: 0;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            `;
            document.body.appendChild(toast);
        }

        toast.innerHTML = `<span>${message}</span>`;
        toast.style.transform = 'translateY(0)';
        toast.style.opacity = '1';

        clearTimeout(window._toastTimeout);
        window._toastTimeout = setTimeout(() => {
            toast.style.transform = 'translateY(100px)';
            toast.style.opacity = '0';
        }, duration);
    };

    // Close Modal Helper
    window.closeWholesaleModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.style.display = 'none';
    };

    // Open Modal Helper
    window.openWholesaleModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.style.display = 'flex';
    };

})();
