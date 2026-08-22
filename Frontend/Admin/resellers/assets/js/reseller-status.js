/**
 * reseller-status.js — Approval, Rejection, and Status Transition Controller
 */

(function () {
    'use strict';

    let currentTargetResellerId = null;

    window.openApprovalModal = function (resellerId, name, requestedTier) {
        currentTargetResellerId = resellerId;
        const nameEl = document.getElementById('dtApproveResellerName');
        const idEl = document.getElementById('dtApproveResellerId');
        const tierSelect = document.getElementById('dtApproveTierSelect');

        if (nameEl) nameEl.innerText = name;
        if (idEl) idEl.innerText = resellerId;
        if (tierSelect && requestedTier) tierSelect.value = requestedTier;

        window.openModal('dtApproveResellerModal');
    };

    window.confirmResellerApproval = function (e) {
        if (e) e.preventDefault();
        const tier = document.getElementById('dtApproveTierSelect')?.value || 'Silver';
        window.closeModal('dtApproveResellerModal');
        window.showToast(`✓ Reseller ${currentTargetResellerId} Approved successfully as ${tier} Tier!`);
    };

    window.openRejectionModal = function (resellerId, name) {
        currentTargetResellerId = resellerId;
        const nameEl = document.getElementById('dtRejectResellerName');
        const idEl = document.getElementById('dtRejectResellerId');

        if (nameEl) nameEl.innerText = name;
        if (idEl) idEl.innerText = resellerId;

        window.openModal('dtRejectResellerModal');
    };

    window.confirmResellerRejection = function (e) {
        if (e) e.preventDefault();
        const reason = document.getElementById('dtRejectReasonSelect')?.value || 'Incomplete Information';
        window.closeModal('dtRejectResellerModal');
        window.showToast(`Reseller application ${currentTargetResellerId} marked as Rejected (${reason})`);
    };

    window.toggleResellerSuspension = function (resellerId, currentStatus) {
        if (currentStatus === 'Suspended') {
            if (confirm(`Reactivate Reseller ${resellerId}?`)) {
                window.showToast(`✓ Reseller ${resellerId} Reactivated to Active Standing`);
            }
        } else {
            if (confirm(`Suspend Reseller ${resellerId}? Ordering and credit wallet will be temporarily locked.`)) {
                window.showToast(`⚠️ Reseller ${resellerId} has been Suspended`);
            }
        }
    };

})();
