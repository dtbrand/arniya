/**
 * customer-view.js — 360° Customer Profile Tab Controller & Quick Tools
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */

(function () {
    'use strict';

    function toast(message, kind) {
        if (typeof window.showToast === 'function') { window.showToast(message, kind); }
        else { alert(message); }
    }

    function esc(v) {
        return String(v == null ? '' : v).replace(/[&<>"']/g, function (ch) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ch];
        });
    }

    window.switchCustomerTab = function (tabName, btnElement) {
        document.querySelectorAll('.dt-cust-tab-btn').forEach(b => b.classList.remove('active'));
        if (btnElement) btnElement.classList.add('active');

        document.querySelectorAll('.dt-cust-tab-pane').forEach(p => p.style.display = 'none');
        const activePane = document.getElementById('dtCustTabPane-' + tabName);
        if (activePane) {
            activePane.style.display = 'block';
        }
    };

    /* Saves the note to customer_notes via /api/customer_notes.php.
       This used to prepend a card to the DOM and toast "✓ Internal Note Saved!"
       without contacting the server at all — there was no notes table and no
       endpoint, so every memo was lost on the next page load while the admin
       had been told it was stored. The card is only rendered after the server
       confirms the insert. */
    window.addCustomerQuickNote = function (e) {
        if (e) e.preventDefault();

        const form = e && e.target && e.target.closest ? e.target.closest('form') : null;
        const textarea = document.getElementById('dtCustNewNoteText');
        const importantChk = document.getElementById('dtCustNoteImportantChk');
        const isImportant = !!(importantChk && importantChk.checked);
        const noteText = textarea ? textarea.value.trim() : '';

        if (!noteText) {
            toast('⚠ Please enter a note description.', 'danger');
            return;
        }

        // The id comes from the form's data attribute, which view.php filled
        // from the resolved customer, with the query string as a fallback.
        let customerId = form ? parseInt(form.getAttribute('data-customer-id'), 10) : 0;
        if (!customerId) {
            const fromUrl = new URLSearchParams(window.location.search).get('id') || '';
            customerId = parseInt(String(fromUrl).replace(/[^0-9]/g, ''), 10) || 0;
        }
        if (!customerId) {
            toast('⚠ Cannot tell which customer this note belongs to.', 'danger');
            return;
        }

        const submitBtn = form ? form.querySelector('button[type="submit"]') : null;
        if (submitBtn) { submitBtn.disabled = true; }

        fetch('/api/customer_notes.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin',
            body: JSON.stringify({
                customer_id: customerId,
                note_text: noteText,
                is_important: isImportant ? 1 : 0
            })
        })
            .then(r => r.json().catch(() => ({ success: false, message: 'The server did not return a valid response.' })))
            .then(data => {
                if (!data || data.success !== true) {
                    toast('⚠ ' + ((data && data.message) || 'The note could not be saved.'), 'danger');
                    return;
                }

                const stream = document.getElementById('dtCustNotesStream');
                if (stream) {
                    const emptyMsg = document.getElementById('dtCustNotesEmpty');
                    if (emptyMsg) emptyMsg.remove();

                    const saved = data.note || {};
                    const noteCard = document.createElement('div');
                    noteCard.className = 'dt-cust-note-card ' + (isImportant ? 'important' : '');
                    noteCard.innerHTML =
                        '<div class="dt-cust-note-head">' +
                            '<span>' + esc(saved.author_name || 'Admin') + ' • Just now</span>' +
                            (isImportant
                                ? '<span class="dt-status-pill suspended" style="font-size:0.6rem; padding:1px 5px;">★ Important</span>'
                                : '<span style="font-size:0.65rem; color:#78716C;">General Note</span>') +
                        '</div>' +
                        // esc() matters here: the note text is typed by staff but
                        // rendered straight back into the admin's own page.
                        '<div class="dt-cust-note-body">' + esc(noteText).replace(/\n/g, '<br>') + '</div>';
                    stream.prepend(noteCard);
                }

                if (textarea) textarea.value = '';
                if (importantChk) importantChk.checked = false;
                toast('✓ Note saved.');
            })
            .catch(() => toast('⚠ Could not reach the server, so the note was not saved.', 'danger'))
            .finally(() => { if (submitBtn) submitBtn.disabled = false; });
    };

    /* Hands the reset off over WhatsApp, which is a channel this site actually
       has. The previous version took an email address and toasted "Secure
       password reset email link dispatched!" without sending anything — there is
       no outbound mail sender configured anywhere in the project. Matches
       dtSendResetLink() in edit.php. */
    window.sendCustomerResetLink = function (customerId, phone, name) {
        let digits = String(phone || '').replace(/\D+/g, '');
        if (digits.length === 10) { digits = '91' + digits; }
        if (!digits) {
            toast('⚠ This customer has no phone number on file.', 'danger');
            return;
        }
        const msg = 'Namaste ' + (name || 'ji') + ', this is DT Brand\'s & Jai Hanuman Tex. '
            + 'To reset your account password, please reply here and our team will help you set a new one.';
        window.open('https://wa.me/' + digits + '?text=' + encodeURIComponent(msg), '_blank');
        toast('WhatsApp opened — send the message to start the reset.');
    };

    /* Kept so any older markup that still calls it cannot silently claim an
       email was sent. */
    window.triggerPasswordResetEmail = function () {
        toast('⚠ Email reset is not available — use "Send Reset Link on WhatsApp" instead.', 'danger');
    };

})();
