/**
 * orders.js — Master Order Management Controller & State Engine
 * DT Brand's & Jai Hanuman Tex
 */

(function(window) {
    'use strict';

    const DT_ORDERS = {
        orders: (window.SERVER_ORDERS && Array.isArray(window.SERVER_ORDERS)) ? window.SERVER_ORDERS : [],

        showToast: function(message, _type) {
            const existing = document.getElementById('dtToastContainer');
            if (existing) existing.remove();

            const toast = document.createElement('div');
            toast.id = 'dtToastContainer';
            toast.style.cssText = 'position:fixed; bottom:24px; right:24px; background:linear-gradient(135deg, #181512 0%, #2A241E 100%); color:#FAF5E8; border:1px solid #8A681F; border-radius:8px; padding:12px 18px; font-size:12.5px; font-weight:700; display:flex; align-items:center; gap:10px; z-index:999999; box-shadow:0 6px 20px rgba(0,0,0,0.35); animation:dtToastIn 0.25s ease-out; font-family:"Plus Jakarta Sans", sans-serif;';
            
            toast.innerHTML = `
                <span style="display:inline-block; width:8px; height:8px; border-radius:50%; background:#16A34A; box-shadow:0 0 8px #16A34A;"></span>
                <span>${message}</span>
            `;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3200);
        },

        copyText: function(text, label) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text);
            } else {
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                textArea.remove();
            }
            this.showToast((label || 'Text') + ' copied to clipboard.');
        }
    };

    window.DT_ORDERS = DT_ORDERS;
})(window);
