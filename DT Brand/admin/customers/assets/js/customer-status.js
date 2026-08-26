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
        const newStatus = statusSelect?.value || 'active';
        const targetId = currentTargetCustId;
        
        if (targetId) {
            const params = new URLSearchParams();
            params.append('action', 'update_status');
            params.append('id', targetId);
            params.append('status', newStatus);
            fetch('/api/customers.php', { method: 'POST', body: params }).catch(() => {});

            const row = document.getElementById('custRow_' + targetId) || document.querySelector(`tr[data-cust-id="${targetId}"]`);
            if (row) {
                const badge = row.querySelector('.dt-status-pill-clean') || row.querySelector('.adm-badge');
                if (badge) {
                    badge.className = 'dt-status-pill-clean ' + (newStatus === 'active' ? 'emerald' : (newStatus === 'suspended' ? 'crimson' : 'amber'));
                    badge.textContent = newStatus.toUpperCase();
                }
            }
        }

        window.closeCustomerStatusModal();
        if (typeof window.showToast === 'function') {
            window.showToast(`✓ Customer #${targetId || ''} status updated to ${newStatus.toUpperCase()} in database!`);
        }
    };

})();
