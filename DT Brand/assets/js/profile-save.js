/**
 * assets/js/profile-save.js
 * DT Brand's & Jai Hanuman Tex — B2B dashboard "Profile Edit" save handler.
 *
 * retailer.php, wholesale.php and reseller.php all render a profile form with
 * onsubmit="handleSaveWholesalerDetails(event)", but that function was never
 * defined anywhere. The inline handler threw a ReferenceError, the submit was
 * never cancelled, and the browser fell through to a native form submit — so the
 * page just reloaded and nothing was ever saved.
 *
 * This wires the form to the real API:
 *   POST /api/auth.php?action=update_profile   (name, email)
 *   POST /api/auth.php?action=change_password  (only when both fields are filled)
 *
 * The customer id is never sent from here — api/auth.php takes it from the
 * server session, so a visitor cannot edit somebody else's profile.
 */
(function () {
    'use strict';

    var USER_KEY = 'dtbrands_user';

    function toast(msg, type) {
        if (typeof window.showWsToast === 'function') { window.showWsToast(msg, type); return; }
        if (typeof window.showToast === 'function') { window.showToast(msg); return; }
        alert(msg);
    }

    function readStoredUser() {
        try { return JSON.parse(localStorage.getItem(USER_KEY)) || {}; }
        catch (e) { return {}; }
    }

    function roleFromType(type) {
        var t = String(type || 'retail').toLowerCase();
        if (t === 'wholesale') return 'Wholesaler';
        if (t === 'reseller') return 'Reseller';
        return 'Retailer';
    }

    /* Merge the server's copy of the customer over whatever is cached locally,
       keeping local-only extras (company name, address book, GST prefs). */
    function persistUser(serverUser) {
        var stored = readStoredUser();
        if (serverUser && typeof serverUser === 'object') {
            if (serverUser.id) stored.id = serverUser.id;
            if (serverUser.name) stored.name = serverUser.name;
            if (serverUser.phone) {
                stored.phone = serverUser.phone;
                stored.rawPhone = String(serverUser.phone).replace(/[^0-9]/g, '').slice(-10);
            }
            if (serverUser.email) stored.email = serverUser.email;
            if (serverUser.city) stored.city = serverUser.city;
            if (serverUser.state) stored.state = serverUser.state;
            if (serverUser.tier) stored.tier = serverUser.tier;
            if (serverUser.gstin) stored.gst_number = serverUser.gstin;
            if (serverUser.type) stored.role = roleFromType(serverUser.type);
        }
        localStorage.setItem(USER_KEY, JSON.stringify(stored));
        try { window.dispatchEvent(new Event('storage')); } catch (e) {}
        return stored;
    }

    function repaint(user) {
        var hdr = document.getElementById('headerUserName');
        if (hdr && user.name) hdr.textContent = user.name;

        var nameEl = document.getElementById('wsProfName');
        var emailEl = document.getElementById('wsProfEmail');
        if (nameEl && user.name) nameEl.value = user.name;
        if (emailEl && user.email) emailEl.value = user.email;

        // Let the page's own loader re-render cards if it exposes one.
        ['loadSavedRetailerData', 'loadSavedWholesalerData', 'loadSavedResellerData'].forEach(function (fn) {
            if (typeof window[fn] === 'function') {
                try { window[fn](); } catch (e) {}
            }
        });
    }

    function post(action, fields) {
        var params = new URLSearchParams();
        params.append('action', action);
        Object.keys(fields).forEach(function (k) { params.append(k, fields[k]); });

        return fetch('/api/auth.php?action=' + encodeURIComponent(action), {
            method: 'POST',
            credentials: 'same-origin',
            body: params
        }).then(function (res) {
            return res.json().catch(function () {
                throw new Error('The server sent an unexpected response.');
            });
        });
    }

    window.handleSaveWholesalerDetails = function (event) {
        if (event && typeof event.preventDefault === 'function') event.preventDefault();

        var nameEl = document.getElementById('wsProfName');
        var phoneEl = document.getElementById('wsProfPhone');
        var emailEl = document.getElementById('wsProfEmail');
        var curPassEl = document.getElementById('wsCurrentPass');
        var newPassEl = document.getElementById('wsNewPass');

        var name = nameEl ? nameEl.value.trim() : '';
        var phone = phoneEl ? phoneEl.value.trim().replace(/[^0-9]/g, '') : '';
        var email = emailEl ? emailEl.value.trim() : '';
        var curPass = curPassEl ? curPassEl.value : '';
        var newPass = newPassEl ? newPassEl.value : '';

        if (!name) {
            toast('Please enter your full name.');
            if (nameEl) nameEl.focus();
            return false;
        }
        if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            toast('Please enter a valid email address.');
            if (emailEl) emailEl.focus();
            return false;
        }
        if ((curPass || newPass) && newPass.length < 6) {
            toast('Your new password must be at least 6 characters.');
            if (newPassEl) newPassEl.focus();
            return false;
        }
        if (newPass && !curPass) {
            toast('Please enter your current password to set a new one.');
            if (curPassEl) curPassEl.focus();
            return false;
        }

        // The mobile number is the login identity, so it is not editable here.
        var stored = readStoredUser();
        var storedPhone = String(stored.rawPhone || stored.phone || '').replace(/[^0-9]/g, '').slice(-10);
        var phoneChanged = (phone && storedPhone && phone !== storedPhone);

        var btn = document.querySelector('#wsDetailsForm button[type="submit"]');
        var btnLabel = btn ? btn.innerHTML : '';
        if (btn) { btn.disabled = true; btn.innerHTML = 'Saving…'; }

        function restoreBtn() {
            if (btn) { btn.disabled = false; btn.innerHTML = btnLabel; }
        }

        post('update_profile', { name: name, email: email })
            .then(function (data) {
                if (!data || !data.success) {
                    throw new Error((data && data.message) || 'We could not save your profile.');
                }
                var user = persistUser(data.user);
                repaint(user);

                if (!newPass) {
                    restoreBtn();
                    toast('Profile saved successfully.');
                    if (phoneChanged) {
                        toast('Your mobile number is your login ID — contact us on WhatsApp to change it.');
                    }
                    return null;
                }

                return post('change_password', {
                    current_password: curPass,
                    new_password: newPass
                }).then(function (pw) {
                    restoreBtn();
                    if (pw && pw.success) {
                        if (curPassEl) curPassEl.value = '';
                        if (newPassEl) newPassEl.value = '';
                        toast('Profile and password updated successfully.');
                    } else {
                        // Profile did save; be explicit that the password did not.
                        toast('Profile saved, but the password was not changed: ' +
                              ((pw && pw.message) || 'please check your current password.'));
                    }
                    if (phoneChanged) {
                        toast('Your mobile number is your login ID — contact us on WhatsApp to change it.');
                    }
                    return null;
                });
            })
            .catch(function (err) {
                restoreBtn();
                toast(err && err.message ? err.message : 'We could not reach the server. Please try again.');
            });

        return false;
    };
})();
