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

        if (!targetId) {
            window.closeCustomerStatusModal();
            toast('⚠ No customer was selected, so nothing was changed.');
            return;
        }

        const params = new URLSearchParams();
        params.append('action', 'update_status');
        params.append('id', targetId);
        params.append('status', newStatus);

        /* The badge and the toast must follow the server, not precede it.
           /api/customers.php requires an admin session and answers 401 once it
           expires; the old fire-and-forget call repainted the row and announced
           "updated in database" either way, so a rejected change looked done
           until the page was reloaded. */
        fetch('/api/customers.php', { method: 'POST', body: params })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                window.closeCustomerStatusModal();
                if (data && data.success) {
                    paintRowStatus(targetId, newStatus);
                    toast('✓ Customer #' + targetId + ' is now ' + newStatus.toUpperCase() + '.');
                } else {
                    toast('⚠ ' + ((data && data.message) || 'Customer #' + targetId + ' was NOT updated.'));
                }
            })
            .catch(function () {
                window.closeCustomerStatusModal();
                toast('⚠ Network error — customer #' + targetId + ' was NOT updated.');
            });
    };

    function paintRowStatus(targetId, newStatus) {
        const row = document.getElementById('custRow_' + targetId) || document.querySelector(`tr[data-cust-id="${targetId}"]`);
        if (!row) return;
        const badge = row.querySelector('.dt-status-pill-clean') || row.querySelector('.adm-badge');
        if (!badge) return;
        badge.className = 'dt-status-pill-clean ' + (newStatus === 'active' ? 'emerald' : (newStatus === 'suspended' ? 'crimson' : 'amber'));
        badge.textContent = newStatus.toUpperCase();
    }

    function toast(message) {
        if (typeof window.showToast === 'function') { window.showToast(message); }
        else { alert(message); }
    }

})();
