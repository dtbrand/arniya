/**
 * customers.js — Master Controller for Module 5: Customer Management
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */

(function () {
    'use strict';

    // Global Toast Notification Helper
    window.showToast = function (message, type) {
        let container = document.getElementById('dtToastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'dtToastContainer';
            container.className = 'dt-toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = 'dt-toast';
        
        let iconSvg = '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#D4AF37" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
        if (type === 'danger' || type === 'error') {
            iconSvg = '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#EF4444" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>';
        }

        toast.innerHTML = `<span>${iconSvg}</span><span>${message}</span>`;
        container.appendChild(toast);

        setTimeout(() => {
            toast.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
            setTimeout(() => {
                if (toast.parentNode) toast.parentNode.removeChild(toast);
            }, 300);
        }, 3200);
    };

    // Quick Copy to Clipboard Utility
    window.copyToClipboard = function (text, label) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(() => {
                window.showToast(`✓ Copied ${label || 'text'} to clipboard!`);
            }).catch(() => {
                fallbackCopyTextToClipboard(text, label);
            });
        } else {
            fallbackCopyTextToClipboard(text, label);
        }
    };

    function fallbackCopyTextToClipboard(text, label) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.top = '0';
        textArea.style.left = '0';
        textArea.style.position = 'fixed';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            window.showToast(`✓ Copied ${label || 'text'} to clipboard!`);
        } catch (err) {
            window.showToast(`⚠️ Could not copy ${label}`);
        }
        document.body.removeChild(textArea);
    }

    console.log("DT Brand's Customer CRM Module 5 loaded successfully.");
})();
