/**
 * customer-view.js — 360° Customer Profile Tab Controller & Quick Tools
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */

(function () {
    'use strict';

    function toast(message, kind) {
        if (typeof window.showToast === 'function') { window.showToast(message, kind); }
        else { console.warn(message); }
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
       This used to prepend a card to the DOM and toast "Internal Note Saved!"
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
            toast('Please enter a note description.', 'danger');
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
            toast('Cannot tell which customer this note belongs to.', 'danger');
            return;
        }

        const submitBtn = form ? form.querySelector('button[type="submit"]') : null;
        if (submitBtn) { submitBtn.disabled = true; }

        (window.dtAdminFetch || fetch)('/api/customer_notes.php', {
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
                    toast('' + ((data && data.message) || 'The note could not be saved.'), 'danger');
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
                                ? '<span class="dt-status-pill suspended" style="font-size:0.6rem; padding:1px 5px; display:inline-flex; align-items:center; gap:4px;"><svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><span>Important</span></span>'
                                : '<span style="font-size:0.65rem; color:#78716C;">General Note</span>') +
                        '</div>' +
                        // esc() matters here: the note text is typed by staff but
                        // rendered straight back into the admin's own page.
                        '<div class="dt-cust-note-body">' + esc(noteText).replace(/\n/g, '<br>') + '</div>';
                    stream.prepend(noteCard);
                }

                if (textarea) textarea.value = '';
                if (importantChk) importantChk.checked = false;
                toast('Note saved.');
            })
            .catch(() => toast('Could not reach the server, so the note was not saved.', 'danger'))
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
            toast('This customer has no phone number on file.', 'danger');
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
        toast('Email reset is not available — use "Send Reset Link on WhatsApp" instead.', 'danger');
    };

    /* ── Customer Address Book Admin Controller ── */
    window.openAdminAddAddressModal = function (customerId) {
        var modal = document.getElementById('dtAdminAddressModal');
        if (!modal) return;
        var el = function (id) { return document.getElementById(id); };

        var title = el('dtAdminAddressModalTitle');
        if (title) {
            title.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg> <span>+ Add Customer Address</span>';
        }

        if (el('dtAdminAddrId')) el('dtAdminAddrId').value = '';
        if (el('dtAdminAddrCustId')) el('dtAdminAddrCustId').value = customerId || '';
        if (el('dtAdminAddrType')) el('dtAdminAddrType').value = 'shipping';
        if (el('dtAdminAddrRecipient')) el('dtAdminAddrRecipient').value = '';
        if (el('dtAdminAddrPhone')) el('dtAdminAddrPhone').value = '';
        if (el('dtAdminAddrGst')) el('dtAdminAddrGst').value = '';
        if (el('dtAdminAddrLine1')) el('dtAdminAddrLine1').value = '';
        if (el('dtAdminAddrLine2')) el('dtAdminAddrLine2').value = '';
        if (el('dtAdminAddrCity')) el('dtAdminAddrCity').value = 'Surat';
        if (el('dtAdminAddrState')) el('dtAdminAddrState').value = 'Gujarat';
        if (el('dtAdminAddrPin')) el('dtAdminAddrPin').value = '395002';
        if (el('dtAdminAddrDefault')) el('dtAdminAddrDefault').checked = false;

        modal.style.display = 'flex';
    };

    window.openAdminEditAddressModal = function (addr) {
        if (typeof addr === 'string') {
            try { addr = JSON.parse(addr); } catch { return; }
        } else if (addr && typeof addr.getAttribute === 'function') {
            try { addr = JSON.parse(addr.getAttribute('data-addr') || '{}'); } catch { return; }
        }
        var modal = document.getElementById('dtAdminAddressModal');
        if (!modal || !addr) return;
        var el = function (id) { return document.getElementById(id); };

        var title = el('dtAdminAddressModalTitle');
        if (title) {
            title.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#8A681F" stroke-width="2.3"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg> <span>Edit Customer Address</span>';
        }

        if (el('dtAdminAddrId')) el('dtAdminAddrId').value = addr.id || '';
        if (el('dtAdminAddrCustId')) el('dtAdminAddrCustId').value = addr.customer_id || '';
        if (el('dtAdminAddrType')) el('dtAdminAddrType').value = addr.address_type || 'shipping';
        if (el('dtAdminAddrRecipient')) el('dtAdminAddrRecipient').value = addr.recipient_name || '';
        if (el('dtAdminAddrPhone')) el('dtAdminAddrPhone').value = addr.phone || '';
        if (el('dtAdminAddrGst')) el('dtAdminAddrGst').value = addr.gstin || '';
        if (el('dtAdminAddrLine1')) el('dtAdminAddrLine1').value = addr.address_line1 || '';
        if (el('dtAdminAddrLine2')) el('dtAdminAddrLine2').value = addr.address_line2 || '';
        if (el('dtAdminAddrCity')) el('dtAdminAddrCity').value = addr.city || 'Surat';
        if (el('dtAdminAddrState')) el('dtAdminAddrState').value = addr.state || 'Gujarat';
        if (el('dtAdminAddrPin')) el('dtAdminAddrPin').value = addr.pincode || '395002';
        if (el('dtAdminAddrDefault')) el('dtAdminAddrDefault').checked = !!addr.is_default;

        modal.style.display = 'flex';
    };

    window.closeAdminAddressModal = function () {
        var modal = document.getElementById('dtAdminAddressModal');
        if (modal) modal.style.display = 'none';
    };

    window.handleAdminAddrTypeChange = function (type) {
        var defaultChk = document.getElementById('dtAdminAddrDefault');
        if (type === 'billing' && defaultChk) {
            defaultChk.checked = true;
        }
    };

    window.handleAdminSaveAddress = function (e) {
        if (e && typeof e.preventDefault === 'function') e.preventDefault();
        var el = function (id) { return document.getElementById(id); };

        var addrId = parseInt(el('dtAdminAddrId') ? el('dtAdminAddrId').value : '0', 10) || 0;
        var customerId = parseInt(el('dtAdminAddrCustId') ? el('dtAdminAddrCustId').value : '0', 10) || 0;
        var type = el('dtAdminAddrType') ? el('dtAdminAddrType').value : 'shipping';
        var recipient = el('dtAdminAddrRecipient') ? el('dtAdminAddrRecipient').value.trim() : '';
        var phone = el('dtAdminAddrPhone') ? el('dtAdminAddrPhone').value.trim() : '';
        var gstin = el('dtAdminAddrGst') ? el('dtAdminAddrGst').value.trim().toUpperCase() : '';
        var addr1 = el('dtAdminAddrLine1') ? el('dtAdminAddrLine1').value.trim() : '';
        var addr2 = el('dtAdminAddrLine2') ? el('dtAdminAddrLine2').value.trim() : '';
        var city = el('dtAdminAddrCity') ? el('dtAdminAddrCity').value.trim() : '';
        var state = el('dtAdminAddrState') ? el('dtAdminAddrState').value : 'Gujarat';
        var pin = el('dtAdminAddrPin') ? el('dtAdminAddrPin').value.trim() : '';
        var isDefault = el('dtAdminAddrDefault') && el('dtAdminAddrDefault').checked ? 1 : 0;

        if (!customerId) {
            toast('Invalid customer ID.', 'danger');
            return false;
        }
        if (!addr1 || !city || !pin) {
            toast('Please enter address line 1, city, and 6-digit PIN code.', 'danger');
            return false;
        }

        var saveBtn = document.getElementById('dtAdminAddrSaveBtn');
        var oldBtnHtml = saveBtn ? saveBtn.innerHTML : '';
        if (saveBtn) {
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2.5" style="animation: dtSpin 1s linear infinite;"><circle cx="12" cy="12" r="10" stroke-opacity="0.25" stroke="currentColor"></circle><path d="M12 2a10 10 0 0 1 10 10" stroke="currentColor"></path></svg> <span>Saving...</span>';
        }

        (window.dtAdminFetch || fetch)('/api/customer_addresses.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin',
            body: JSON.stringify({
                action: 'save',
                id: addrId,
                is_new: addrId <= 0 ? 1 : 0,
                customer_id: customerId,
                address_type: type,
                recipient_name: recipient,
                phone: phone,
                gstin: gstin,
                address_line1: addr1,
                address_line2: addr2,
                city: city,
                state: state,
                pincode: pin,
                is_default: isDefault
            })
        })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (saveBtn) {
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = oldBtnHtml;
                }
                if (!res || !res.success) {
                    toast(res && res.message ? res.message : 'Failed to save address.', 'danger');
                    return;
                }
                toast(res.message || 'Address saved successfully!', 'success');
                window.closeAdminAddressModal();
                setTimeout(function () { window.location.reload(); }, 600);
            })
            .catch(function () {
                if (saveBtn) {
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = oldBtnHtml;
                }
                toast('Server connection failed while saving address.', 'danger');
            });

        return false;
    };

    window.setCustomerDefaultShipping = function (addrId, customerId) {
        if (!addrId || !customerId) return;
        (window.dtAdminFetch || fetch)('/api/customer_addresses.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin',
            body: JSON.stringify({
                action: 'set_default_shipping',
                id: addrId,
                customer_id: customerId
            })
        })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (!res || !res.success) {
                    toast(res && res.message ? res.message : 'Could not set default shipping.', 'danger');
                    return;
                }
                toast('Default shipping address updated successfully!', 'success');
                setTimeout(function () { window.location.reload(); }, 600);
            })
            .catch(function () {
                toast('Could not connect to server.', 'danger');
            });
    };

    window.setCustomerDefaultBilling = function (addrId, customerId) {
        if (!addrId || !customerId) return;
        (window.dtAdminFetch || fetch)('/api/customer_addresses.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin',
            body: JSON.stringify({
                action: 'set_default_billing',
                id: addrId,
                customer_id: customerId
            })
        })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (!res || !res.success) {
                    toast(res && res.message ? res.message : 'Could not update billing address.', 'danger');
                    return;
                }
                toast('Registered GST Billing Address updated successfully!', 'success');
                setTimeout(function () { window.location.reload(); }, 600);
            })
            .catch(function () {
                toast('Could not connect to server.', 'danger');
            });
    };

    window.deleteCustomerAddress = function (addrId, customerId) {
        if (!addrId || !customerId) return;
        if (!confirm('Are you sure you want to remove this saved address?')) return;

        (window.dtAdminFetch || fetch)('/api/customer_addresses.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            credentials: 'same-origin',
            body: JSON.stringify({
                action: 'delete',
                id: addrId,
                customer_id: customerId
            })
        })
            .then(function (r) { return r.json(); })
            .then(function (res) {
                if (!res || !res.success) {
                    toast(res && res.message ? res.message : 'Could not delete address.', 'danger');
                    return;
                }
                toast('Address removed successfully.', 'success');
                var card = document.getElementById('dtAdminAddrCard-' + addrId);
                if (card) {
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.9)';
                    setTimeout(function () { card.remove(); }, 300);
                } else {
                    setTimeout(function () { window.location.reload(); }, 600);
                }
            })
            .catch(function () {
                toast('Could not connect to server.', 'danger');
            });
    };

    // Auto switch tab from URL hash or query param if present
    document.addEventListener('DOMContentLoaded', function () {
        var hash = (window.location.hash || '').replace('#', '');
        var urlTab = new URLSearchParams(window.location.search).get('tab') || hash;
        if (urlTab) {
            var targetBtn = document.querySelector('.dt-cust-tab-btn[onclick*="\'' + urlTab + '\'"]');
            if (targetBtn) {
                window.switchCustomerTab(urlTab, targetBtn);
            }
        }
    });

})();
