/**
 * customer-view.js — 360° Customer Profile Tab Controller & Quick Tools
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */

(function () {
    'use strict';

    window.switchCustomerTab = function (tabName, btnElement) {
        document.querySelectorAll('.dt-cust-tab-btn').forEach(b => b.classList.remove('active'));
        if (btnElement) btnElement.classList.add('active');

        document.querySelectorAll('.dt-cust-tab-pane').forEach(p => p.style.display = 'none');
        const activePane = document.getElementById('dtCustTabPane-' + tabName);
        if (activePane) {
            activePane.style.display = 'block';
        }
    };

    window.addCustomerQuickNote = function (e) {
        if (e) e.preventDefault();
        const textarea = document.getElementById('dtCustNewNoteText');
        const isImportant = document.getElementById('dtCustNoteImportantChk')?.checked;
        if (!textarea || !textarea.value.trim()) {
            window.showToast('⚠️ Please enter a note description.', 'danger');
            return;
        }

        const notesStream = document.getElementById('dtCustNotesStream');
        if (notesStream) {
            const noteCard = document.createElement('div');
            noteCard.className = `dt-cust-note-card ${isImportant ? 'important' : ''}`;
            noteCard.innerHTML = `
                <div class="dt-cust-note-head">
                    <span>Staff Admin • Just Now</span>
                    ${isImportant ? '<span class="dt-status-pill suspended" style="font-size:0.6rem; padding:1px 5px;">★ Urgent Note</span>' : ''}
                </div>
                <div class="dt-cust-note-body">${textarea.value.trim()}</div>
            `;
            notesStream.prepend(noteCard);
            textarea.value = '';
            window.showToast('✓ Internal Note Saved!');
        }
    };

    window.triggerPasswordResetEmail = function (customerEmail) {
        window.showToast(`✓ Secure password reset email link dispatched to ${customerEmail || 'customer'}!`);
    };

})();
