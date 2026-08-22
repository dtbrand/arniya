/**
 * wholesale-status.js — DT Brand's & Jai Hanuman Tex
 * Wholesale Partner Status Transitions (Approve, Suspend, Activate, Reject)
 */

(function () {
    'use strict';

    window.openApproveModal = function (whlId, businessName, requestedTier) {
        document.getElementById('approveWhlId').value = whlId;
        document.getElementById('approveBusinessNameDisplay').innerText = `${businessName} (${whlId})`;
        document.getElementById('approvedTierSelect').value = requestedTier || 'Gold';
        window.openWholesaleModal('dtApproveWholesaleModal');
    };

    window.submitApproveWholesale = function (event) {
        if (event) event.preventDefault();
        const whlId = document.getElementById('approveWhlId').value;
        const tier = document.getElementById('approvedTierSelect').value;

        const row = document.getElementById('whlRow_' + whlId);
        if (row) {
            row.setAttribute('data-status', 'approved');
            const statusCell = row.querySelector('.whl-status-cell');
            if (statusCell) {
                statusCell.innerHTML = `<span class="dt-status-pill-clean emerald">✓ APPROVED</span>`;
            }
        }

        window.closeWholesaleModal('dtApproveWholesaleModal');
        window.showToast(`✅ Wholesale Partner "${whlId}" approved on ${tier} Tier!`);
    };

    window.openRejectModal = function (whlId, businessName) {
        document.getElementById('rejectWhlId').value = whlId;
        document.getElementById('rejectBusinessNameDisplay').innerText = `${businessName} (${whlId})`;
        window.openWholesaleModal('dtRejectWholesaleModal');
    };

    window.submitRejectWholesale = function (event) {
        if (event) event.preventDefault();
        const whlId = document.getElementById('rejectWhlId').value;
        const reason = document.getElementById('rejectReasonSelect').value;

        const row = document.getElementById('whlRow_' + whlId);
        if (row) {
            row.setAttribute('data-status', 'rejected');
            const statusCell = row.querySelector('.whl-status-cell');
            if (statusCell) {
                statusCell.innerHTML = `<span class="dt-status-pill-clean crimson">✕ REJECTED</span>`;
            }
        }

        window.closeWholesaleModal('dtRejectWholesaleModal');
        window.showToast(`⚠️ Application "${whlId}" rejected (${reason})`);
    };

})();
