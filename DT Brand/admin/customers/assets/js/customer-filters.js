/**
 * customer-filters.js — Advanced Multi-Criteria Filter Modal Controller
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 *
 * applyCustomerAdvancedFilters used to close the modal and raise
 * "✓ Advanced Filters Applied (12 Matches)" — a hardcoded count, with no
 * filtering performed. The table kept showing every customer while the admin
 * believed they were looking at twelve matches, so any decision taken from that
 * screen ("only 12 wholesale buyers in Gujarat") was taken from nothing.
 *
 * The criteria are now read from the modal and handed to
 * window.applyCustomerListFilter() in customer-list.js, which narrows the same
 * list the tabs and the search box use and returns the true match count.
 */

(function () {
    'use strict';

    // Days for the "Registered In" preset; 0 means all time.
    var filterDays = 0;

    function toast(message) {
        if (typeof window.showToast === 'function') { window.showToast(message); }
    }

    function val(id) {
        var el = document.getElementById(id);
        return el ? String(el.value).trim() : '';
    }

    function num(id) {
        var raw = val(id);
        if (raw === '') return null;
        var n = Number(raw);
        return isNaN(n) ? null : n;
    }

    window.openCustomerFiltersModal = function () {
        var modal = document.getElementById('dtCustFiltersModal');
        if (modal) {
            modal.style.display = 'flex';
        }
    };

    window.closeCustomerFiltersModal = function () {
        var modal = document.getElementById('dtCustFiltersModal');
        if (modal) {
            modal.style.display = 'none';
        }
    };

    window.setCustomerFilterDays = function (btn) {
        if (!btn) return;
        var wrap = document.getElementById('dtFilterDatePills');
        if (wrap) {
            wrap.querySelectorAll('.dt-cust-pill-btn').forEach(function (b) { b.classList.remove('active'); });
        }
        btn.classList.add('active');
        filterDays = parseInt(btn.getAttribute('data-days'), 10) || 0;
    };

    window.applyCustomerAdvancedFilters = function (e) {
        if (e) e.preventDefault();

        if (typeof window.applyCustomerListFilter !== 'function') {
            toast('⚠ The customer list is not ready — reload the page and try again.');
            return;
        }

        var status = val('dtFilterStatus') || 'all';
        var type = val('dtFilterType') || 'all';
        var tier = val('dtFilterTier').toLowerCase();
        var place = val('dtFilterPlace').toLowerCase();
        var minOrders = num('dtFilterMinOrders');
        var minSpent = num('dtFilterMinSpent');
        var cutoff = filterDays > 0 ? (Date.now() - filterDays * 86400000) : null;

        var count = window.applyCustomerListFilter(function (c) {
            if (status !== 'all' && String(c.status).toLowerCase() !== status) return false;
            if (type !== 'all' && String(c.type).toLowerCase() !== type) return false;
            if (tier && String(c.tier).toLowerCase().indexOf(tier) === -1) return false;
            if (place) {
                // c.city is the "City, State" display string; c.state is the raw
                // column, which may hold either a code or a full name.
                var hay = (String(c.city) + ' ' + String(c.state)).toLowerCase();
                if (hay.indexOf(place) === -1) return false;
            }
            if (minOrders !== null && Number(c.orders) < minOrders) return false;
            if (minSpent !== null && Number(c.spent) < minSpent) return false;
            if (cutoff !== null) {
                // A row with no parseable registration date cannot be shown to be
                // inside the window, so a date filter excludes it rather than
                // counting it as a match.
                if (isNaN(c.joinedTs) || c.joinedTs < cutoff) return false;
            }
            return true;
        });

        window.closeCustomerFiltersModal();

        var total = typeof window.getCustomerListTotal === 'function' ? window.getCustomerListTotal() : null;
        if (count === 0) {
            toast('No customer matches those filters.');
        } else if (total !== null) {
            toast('Showing ' + count + ' of ' + total + ' customer' + (total === 1 ? '' : 's') + '.');
        } else {
            toast('Showing ' + count + ' customer' + (count === 1 ? '' : 's') + '.');
        }
    };

    // Blank every control and drop back to All Time, without touching the table
    // or raising a toast. customer-list.js's "Reset Filters" button calls this
    // too, so the modal cannot sit there showing criteria that are no longer
    // applied to the list behind it.
    function clearInputs() {
        ['dtFilterStatus', 'dtFilterType'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el) el.value = 'all';
        });
        ['dtFilterTier', 'dtFilterPlace', 'dtFilterMinOrders', 'dtFilterMinSpent'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el) el.value = '';
        });

        var wrap = document.getElementById('dtFilterDatePills');
        if (wrap) {
            wrap.querySelectorAll('.dt-cust-pill-btn').forEach(function (b) {
                b.classList.toggle('active', b.getAttribute('data-days') === '0');
            });
        }
        filterDays = 0;
    }

    window.clearCustomerFilterInputs = clearInputs;

    window.resetCustomerAdvancedFilters = function () {
        clearInputs();

        if (typeof window.applyCustomerListFilter === 'function') {
            var total = window.applyCustomerListFilter(null);
            toast('Filters cleared — showing all ' + total + ' customer' + (total === 1 ? '' : 's') + '.');
        } else {
            toast('Filters cleared.');
        }
    };

})();
