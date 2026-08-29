/**
 * retail-cart.js — DT Brand's & Jai Hanuman Tex
 * Retail Live Cart Sessions & 1-Click WhatsApp Recovery
 */

(function () {
    'use strict';

    window.triggerAbandonedCartRecovery = function (customerName, phone, cartValue, items) {
        const msg = encodeURIComponent(
            `✨ *DT BRAND'S EXCLUSIVE OFFER FOR YOUR SAVED CART*\n\n` +
            `Namaste *${customerName}*,\n` +
            `We noticed you left *${items}* (Total: ${cartValue}) in your shopping bag.\n\n` +
            `Use code *RETAIL5* for an instant *5% EXTRA DISCOUNT* on completing your order today!\n` +
            `👉 Complete your purchase at https://jaihanumantex.in/`
        );

        const cleanPhone = '91' + phone.replace(/[^0-9]/g, '');
        window.open(`https://api.whatsapp.com/send?phone=${cleanPhone}&text=${msg}`, '_blank');
        
        const params = new URLSearchParams();
        params.append('action', 'broadcast');
        params.append('audience', 'retail');
        params.append('message', `[ABANDONED CART RECOVERY: ${customerName}] ${items} (${cartValue})`);
        fetch('/api/whatsapp.php', { method: 'POST', body: params }).catch(() => {});

        if (typeof window.showToast === 'function') {
            window.showToast(`🚀 WhatsApp Recovery Sent to ${customerName}!`);
        }
    };

})();
