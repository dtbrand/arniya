/**
 * order-view.js — Single Order Details, Address Copy & Admin Notes
 * DT Brand's & Jai Hanuman Tex
 */

(function() {
    'use strict';

    window.DT_ORDER_VIEW = {
        addNote: function() {
            const input = document.getElementById('newAdminNoteInput');
            if (!input || !input.value.trim()) {
                if (window.DT_ORDERS) window.DT_ORDERS.showToast('⚠️ Please enter note text first');
                return;
            }

            const noteList = document.getElementById('adminNotesList');
            if (noteList) {
                const now = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                const noteEl = document.createElement('div');
                noteEl.className = 'dt-note-item';
                noteEl.innerHTML = `
                    <div class="dt-note-header">
                        <span>👤 Admin (You)</span>
                        <span>${now} • Just Now</span>
                    </div>
                    <div class="dt-note-text">${input.value.trim()}</div>
                `;
                noteList.prepend(noteEl);
                input.value = '';
                if (window.DT_ORDERS) window.DT_ORDERS.showToast('✅ Internal note added successfully');
            }
        },

        copyAddress: function(elementId, label) {
            const el = document.getElementById(elementId);
            if (el && window.DT_ORDERS) {
                window.DT_ORDERS.copyText(el.innerText, label);
            }
        }
    };
})();
