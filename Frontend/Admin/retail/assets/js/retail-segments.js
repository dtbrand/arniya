/**
 * retail-segments.js — DT Brand's & Jai Hanuman Tex
 * Retail Behavioral Customer Cohorts & WhatsApp Campaigns
 */

(function () {
    'use strict';

    window.openCreateRetailSegmentModal = function () {
        window.openRetailModal('dtCreateRetailSegmentModal');
    };

    window.submitCreateRetailSegment = function (event) {
        if (event) event.preventDefault();
        const name = document.getElementById('newSegmentName')?.value;
        window.closeRetailModal('dtCreateRetailSegmentModal');
        window.showToast(`✅ Created Retail Customer Segment: "${name}"!`);
    };

    window.broadcastToRetailSegment = function (segmentName, count) {
        const msg = encodeURIComponent(
            `👑 *DT BRAND'S VIP RETAIL PRIVILEGE ALERT*\n\n` +
            `Namaste Valued Patron,\n` +
            `New festive bridal saree arrivals are exclusively open for our *${segmentName}* members.\n` +
            `Explore now at https://jaihanumantex.in/`
        );
        window.open(`https://api.whatsapp.com/send?phone=919876543210&text=${msg}`, '_blank');
        window.showToast(`🚀 Dispatched WhatsApp Campaign to ${count} ${segmentName} customers!`);
    };

})();
