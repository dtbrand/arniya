/**
 * customer-status.js — Customer Status Update & Suspension Modal Handler
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */

(function () {
    'use strict';

    let currentTargetCustId = null;

    window.openCustomerStatusModal = function (custId, currentStatus) {
        currentTargetCustId = custId;
        const modal = document.getElementById('dtCustStatusModal');
        const custIdSpan = document.getElementById('dtCustStatusTargetId');
        const statusSelect = document.getElementById('dtCustNewStatusSelect');
        
        if (custIdSpan) custIdSpan.innerText = '#' + custId;
        if (statusSelect && currentStatus) statusSelect.value = currentStatus;
        if (modal) modal.style.display = 'flex';
    };

    window.closeCustomerStatusModal = function () {
        const modal = document.getElementById('dtCustStatusModal');
        if (modal) modal.style.display = 'none';
        currentTargetCustId = null;
    };

    window.submitCustomerStatusChange = function (e) {
        if (e) e.preventDefault();
        const statusSelect = document.getElementById('dtCustNewStatusSelect');
        const reasonInput = document.getElementById('dtCustStatusReasonInput');
        const newStatus = statusSelect?.value || 'active';
        
        window.closeCustomerStatusModal();
        window.showToast(`✓ Customer ${currentTargetCustId || ''} status updated to ${newStatus.toUpperCase()}!`);
    };

})();
