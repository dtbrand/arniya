/**
 * returns.js — Return Authorization, Inspection & Approval
 * DT Brand's & Jai Hanuman Tex
 */

(function() {
    'use strict';

    window.DT_RETURNS = {
        approveReturn: function(returnId) {
            const row = document.getElementById(`returnRow_${returnId}`);
            if (row) {
                const badge = row.querySelector('.dt-status-badge');
                if (badge) {
                    badge.className = 'dt-status-badge confirmed';
                    badge.innerHTML = '<span class="dt-status-dot"></span><span>Approved</span>';
                }
            }
            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`✅ Return Request ${returnId} approved for reverse pickup`);
            }
        },

        rejectReturn: function(returnId) {
            const row = document.getElementById(`returnRow_${returnId}`);
            if (row) {
                const badge = row.querySelector('.dt-status-badge');
                if (badge) {
                    badge.className = 'dt-status-badge cancelled';
                    badge.innerHTML = '<span class="dt-status-dot"></span><span>Rejected</span>';
                }
            }
            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`🛑 Return Request ${returnId} rejected`);
            }
        },

        markReceived: function(returnId) {
            const row = document.getElementById(`returnRow_${returnId}`);
            if (row) {
                const badge = row.querySelector('.dt-status-badge');
                if (badge) {
                    badge.className = 'dt-status-badge shipped';
                    badge.innerHTML = '<span class="dt-status-dot"></span><span>Received in Depot</span>';
                }
            }
            if (window.DT_ORDERS) {
                window.DT_ORDERS.showToast(`📦 Item for Return ${returnId} marked as received at Surat Depot`);
            }
        }
    };
})();
