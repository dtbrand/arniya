/**
 * bulk-actions.js — Multi-Customer Bulk Operations Handler
 * DT Brand's & Jai Hanuman Tex — Live Production Standard
 *
 * Every bulk action here reported success and changed nothing, for two
 * independent reasons:
 *
 *   1. It read the selection with `.cust-row-check:checked, input[name="cust_ids[]"]:checked`.
 *      The table renders `class="dt-cust-row-chk"` and no name attribute, so the
 *      NodeList was always empty — and because the toast interpolated
 *      `${selected.length || 'Selected'}`, zero rows printed as the word
 *      "Selected" rather than "0", hiding the fact that nothing was picked up.
 *   2. The checkbox has no value attribute at all — the customer id lives in its
 *      onchange closure — so `c.value` would have posted "on" as the id even if
 *      the selector had matched.
 *
 * The fetch was also fire-and-forget with `.catch(() => {})`, so a rejected
 * write was indistinguishable from a stored one, and the row badge was repainted
 * to ACTIVE before any response came back.
 *
 * This matters more than a wrong badge: status is the sign-in and trade-pricing
 * gate. An admin suspending a defaulting wholesale buyer in bulk was told it was
 * done while that buyer kept ordering at mill rates.
 */

(function () {
    'use strict';

    function toast(message) {
        if (typeof window.showToast === 'function') { window.showToast(message); }
    }

    function selectedIds() {
        if (typeof window.getSelectedCustomerIds !== 'function') return null;
        return window.getSelectedCustomerIds();
    }

    function plural(n, word) {
        return n + ' ' + word + (n === 1 ? '' : 's');
    }

    // One POST per customer, and the response is read. api/customers.php answers
    // {"success":true} only when a row really changed (or already held that
    // status), so a 400 here is a genuine failure and is counted as one.
    function postStatus(id, status) {
        var params = new URLSearchParams();
        params.append('action', 'update_status');
        params.append('id', String(id));
        params.append('status', status);

        return fetch('/api/customers.php', {
            method: 'POST',
            body: params,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(function (res) { return res.json().catch(function () { return null; }); })
            .then(function (json) { return !!(json && json.success); })
            .catch(function () { return false; });
    }

    function repaintRow(id, status) {
        if (typeof window.setCustomerRowStatus === 'function') {
            window.setCustomerRowStatus(id, status);
        }
    }

    // Disable the toolbar for the duration of the request. Leaving it live let an
    // impatient admin fire Activate and then Suspend over the same rows, and
    // whichever POST happened to land last decided the stored status.
    function setBusy(busy) {
        var bar = document.getElementById('dtCustBulkBar');
        if (!bar) return;
        bar.querySelectorAll('button').forEach(function (b) { b.disabled = busy; });
    }

    function runBulkStatus(status, verb) {
        var ids = selectedIds();
        if (ids === null) {
            toast('⚠ The customer list is not ready — reload the page and try again.');
            return;
        }
        if (!ids.length) {
            toast('Select at least one customer first.');
            return;
        }

        setBusy(true);
        toast('Updating ' + plural(ids.length, 'customer') + '…');

        Promise.all(ids.map(function (id) {
            return postStatus(id, status).then(function (ok) {
                if (ok) repaintRow(id, status);
                return ok;
            });
        })).then(function (results) {
            setBusy(false);

            var done = results.filter(Boolean).length;
            var failed = results.length - done;

            if (done === 0) {
                toast('⚠ Nothing was ' + verb + ' — none of the ' + plural(results.length, 'customer') + ' could be updated.');
                return;
            }

            if (typeof window.clearCustomerSelection === 'function') {
                window.clearCustomerSelection();
            } else if (typeof window.renderCustomersTable === 'function') {
                window.renderCustomersTable(1);
            }

            if (failed > 0) {
                toast('⚠ ' + plural(done, 'customer') + ' ' + verb + ', but ' + failed + ' failed. Reload to see the stored state.');
            } else {
                toast('✓ ' + plural(done, 'customer') + ' ' + verb + '.');
            }
        });
    }

    window.bulkActivateCustomers = function () {
        runBulkStatus('active', 'activated');
    };

    window.bulkDeactivateCustomers = function () {
        runBulkStatus('suspended', 'suspended');
    };

    window.bulkExportCustomers = function () {
        // This does not export the selection — export.php builds its file from a
        // cohort dropdown, not from checked rows. Say so rather than let a "0 of
        // 12 selected" file land on disk.
        var ids = selectedIds();
        if (ids && ids.length) {
            toast('The Export Studio exports by cohort, not by selection — pick a cohort there.');
        }
        window.location.href = '/admin/customers/export.php';
    };

    // There is no tags table in this database, and no column on `customers` that
    // could hold one. The old handler prompted for a tag name, toasted
    // '✓ Tag "..." Assigned to Selected Customers!' and stored nothing — so an
    // admin who segmented their base by tag was building on nothing. Tier is the
    // one classification that is really stored.
    window.bulkAddTagModal = function () {
        var ids = selectedIds();
        var n = ids ? ids.length : 0;
        toast(n > 0
            ? '⚠ Tags are not stored anywhere in this database. Use the Tier field on each customer instead — Edit → Classification.'
            : '⚠ Tags are not stored anywhere in this database. Use the Tier field on each customer instead.');
    };

})();
