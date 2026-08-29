/**
 * customer-list.js — Dynamic Table, Search, Sorting & Pagination Controller
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */

(function () {
    'use strict';

    // Master customer list, mapped straight from the MySQL rows that
    // index.php serialised into window.dbCustomersData.
    //
    // There is deliberately NO sample roster fallback. This file used to carry
    // twelve invented customers with real-format Indian mobile numbers, served
    // whenever the query returned nothing -- and each row renders a live
    // wa.me/ link, so "1-Click WhatsApp Connect" would have messaged a
    // stranger. An empty directory is the honest answer.
    function esc(v) {
        return String(v == null ? '' : v).replace(/[&<>"']/g, function (ch) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ch];
        });
    }

    // "12 Feb 2026" from a MySQL DATETIME, without inventing one when absent.
    function fmtJoined(raw) {
        if (!raw) return '—';
        var d = new Date(String(raw).replace(' ', 'T'));
        if (isNaN(d.getTime())) return '—';
        return d.toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' });
    }

    var sourceRows = Array.isArray(window.dbCustomersData) ? window.dbCustomersData : [];

    const masterCustomers = sourceRows.map(function (c) {
        var name = (c.name || '').trim();
        var parts = name.split(/\s+/);
        var initial = ((parts[0] ? parts[0][0] : '') + (parts[1] ? parts[1][0] : '')).toUpperCase();
        var orders = parseInt(c.total_orders, 10) || 0;
        var spent = parseFloat(c.lifetime_spend) || 0;
        var place = [c.city, c.state].filter(function (x) { return x && String(x).trim(); }).join(', ');
        var type = (c.type || 'retail').toString();

        return {
            // Numeric id, because view.php / edit.php read it as an integer.
            // Prefixing it with "CUST-" here used to make every one of those
            // links resolve to id 0.
            id: parseInt(c.id, 10) || 0,
            ref: 'CUST-' + (parseInt(c.id, 10) || 0),
            name: name || 'Unnamed customer',
            initial: initial || '?',
            avatarColor: 'gold',
            email: (c.email || '').trim(),
            phone: (c.phone || '').trim(),
            type: type.charAt(0).toUpperCase() + type.slice(1),
            city: place,
            orders: orders,
            spent: spent,
            aov: orders > 0 ? Math.round(spent / orders) : 0,
            // getAll() carries no per-customer last-order date, so this is not
            // guessed. It stays blank until an orders join provides it.
            lastOrder: '—',
            joined: fmtJoined(c.created_at),
            // Raw registration timestamp, kept so the advanced filter can match
            // on a date range instead of parsing the formatted string back.
            joinedTs: c.created_at ? Date.parse(String(c.created_at).replace(' ', 'T')) : NaN,
            status: (c.status || 'active').toString(),
            // city above is "City, State" for display; the advanced filter needs
            // the state on its own.
            state: (c.state || '').toString().trim(),
            tier: (c.tier || '').trim(),
            // Kept so the cohort deep links from the Labels & Cohorts page can
            // filter on them without a second round trip.
            gstin: (c.gstin || '').toString().trim(),
            balance: parseFloat(c.outstanding_balance) || 0,
            tags: (c.tier || '').trim() ? [String(c.tier).trim()] : []
        };
    });

    let currentList = [...masterCustomers];
    let selectedIds = new Set();
    let currentPage = 1;
    let pageSize = 10;
    let currentSort = { col: 'id', dir: 'desc' };

    // Format Currency Helper
    function formatRupee(num) {
        if (!num || isNaN(num)) return '₹0';
        return '₹' + Number(num).toLocaleString('en-IN');
    }

    // Render Table Rows Dynamically
    window.renderCustomersTable = function (page = 1) {
        currentPage = page;
        const tbody = document.getElementById('dtCustomersTableBody');
        if (!tbody) return;

        const startIdx = (currentPage - 1) * pageSize;
        const endIdx = startIdx + pageSize;
        const pageItems = currentList.slice(startIdx, endIdx);

        if (pageItems.length === 0) {
            // An empty directory and a filter that matched nothing need
            // different messages -- telling an admin with zero customers to
            // "change your search keywords" sends them looking for a typo.
            const directoryEmpty = masterCustomers.length === 0;
            tbody.innerHTML = `
                <tr>
                    <td colspan="10" style="padding:0;">
                        <div class="dt-cust-empty-state">
                            <div class="dt-cust-empty-icon">
                                <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            </div>
                            <h4 class="dt-cust-empty-title">${directoryEmpty ? 'No Customers Yet' : 'No Matching Customers'}</h4>
                            <p class="dt-cust-empty-sub">${directoryEmpty
                                ? 'Nobody has registered yet. New shoppers appear here as soon as they create an account.'
                                : 'No customer matches the current search or filters.'}</p>
                            ${directoryEmpty
                                ? '<a href="/admin/customers/new.php" class="dt-btn dt-btn-pale">Add a Customer</a>'
                                : '<button type="button" class="dt-btn dt-btn-pale" onclick="window.resetCustomerFilters()">Reset Filters</button>'}
                        </div>
                    </td>
                </tr>
            `;
            updatePaginationInfo(0, 0, 0);
            return;
        }

        let html = '';
        pageItems.forEach(c => {
            const isChecked = selectedIds.has(c.id);
            const statusClass = c.status === 'active' ? 'active' : (c.status === 'suspended' ? 'suspended' : 'inactive');
            const statusLabel = c.status === 'active' ? 'Active' : (c.status === 'suspended' ? 'Suspended' : (c.status === 'pending' ? 'Pending Approval' : 'Inactive'));

            // Every value below goes through esc(). Names and emails are typed
            // by customers at registration, so an unescaped one would execute
            // in the admin's own logged-in browser.
            const waDigits = c.phone.replace(/[^0-9]/g, '');
            const waBtn = waDigits
                ? `<a href="https://wa.me/${waDigits}?text=${encodeURIComponent('Hello ' + c.name + ', welcome to DT Brand\'s')}" target="_blank" rel="noopener" class="dt-cust-act-btn wa" title="1-Click WhatsApp Connect">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            </a>`
                : `<span class="dt-cust-act-btn" style="opacity:0.35; cursor:not-allowed;" title="No phone number on file">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            </span>`;

            html += `
                <tr class="${isChecked ? 'selected' : ''}" data-cust-id="${c.id}">
                    <td style="width:36px; text-align:center;">
                        <input type="checkbox" class="dt-cust-row-chk" onchange="window.toggleCustomerRowSelection(${c.id}, this.checked)" ${isChecked ? 'checked' : ''}>
                    </td>
                    <td>
                        <div class="dt-cust-avatar-cell">
                            <div class="dt-cust-avatar ${c.avatarColor}">${esc(c.initial)}</div>
                            <div class="dt-cust-name-wrap">
                                <div class="dt-cust-name-row">
                                    <a href="/admin/customers/view.php?id=${c.id}" class="dt-cust-name">${esc(c.name)}</a>
                                    ${/vip/i.test(c.tier) ? '<span class="dt-status-pill vip" style="font-size:0.6rem; padding:1px 5px;">VIP</span>' : ''}
                                </div>
                                <span class="dt-cust-id-badge">${esc(c.ref)}${c.city ? ' • ' + esc(c.city) : ''}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="dt-cust-contact-cell">
                            <span class="dt-cust-phone">${c.phone ? esc(c.phone) : '—'}</span>
                            <span class="dt-cust-email">${c.email ? esc(c.email) : '—'}</span>
                        </div>
                    </td>
                    <td><span class="dt-status-pill" style="background:#FAF8F4; border:1px solid #EAE5D9; color:#4B5563;">${esc(c.type)}</span></td>
                    <td style="text-align:center; font-weight:800; color:#181512;">${c.orders} Orders</td>
                    <td>
                        <div class="dt-cust-money">${formatRupee(c.spent)}</div>
                        <small style="color:#78716C; font-size:0.65rem;">AOV: ${formatRupee(c.aov)}</small>
                    </td>
                    <td style="color:#645D54; font-size:0.72rem; font-weight:600;">${esc(c.lastOrder)}</td>
                    <td style="color:#78716C; font-size:0.72rem;">${esc(c.joined)}</td>
                    <td>
                        <span class="dt-status-pill ${statusClass}">
                            <span style="width:6px; height:6px; border-radius:50%; background:currentColor; display:inline-block;"></span>
                            ${statusLabel}
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <div class="dt-cust-actions-cell">
                            ${waBtn}
                            <a href="/admin/customers/view.php?id=${c.id}" class="dt-cust-act-btn view" title="View 360° Profile">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>
                            <a href="/admin/customers/edit.php?id=${c.id}" class="dt-cust-act-btn edit" title="Edit Customer">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
        updatePaginationInfo(startIdx + 1, Math.min(endIdx, currentList.length), currentList.length);
    };

    function updatePaginationInfo(start, end, total) {
        const info = document.getElementById('dtCustPaginationInfo');
        if (info) {
            info.innerHTML = total === 0
                ? 'No customers to show'
                : `Showing <strong>${start}–${end}</strong> of <strong>${total}</strong> Customers`;
        }
        renderPageButtons(total);
    }

    // Build one button per real page. The markup used to ship fixed buttons for
    // pages 1 and 2, so with more than 20 customers the rest were unreachable.
    function renderPageButtons(total) {
        const wrap = document.getElementById('dtCustPagesWrap');
        if (!wrap) return;

        const pageCount = Math.ceil(total / pageSize);
        if (pageCount <= 1) {
            wrap.innerHTML = '';
            return;
        }

        // Window the numbers so a few thousand customers cannot produce a few
        // hundred buttons.
        const span = 2;
        let from = Math.max(1, currentPage - span);
        let to = Math.min(pageCount, currentPage + span);
        if (currentPage <= span) to = Math.min(pageCount, 1 + span * 2);
        if (currentPage > pageCount - span) from = Math.max(1, pageCount - span * 2);

        let out = '';
        const btn = (page, label, title, extraClass) =>
            `<button type="button" class="dt-cust-page-btn ${extraClass || ''}" onclick="window.renderCustomersTable(${page})"${title ? ` title="${title}"` : ''}>${label}</button>`;

        if (currentPage > 1) out += btn(1, '«', 'First page');
        if (currentPage > 1) out += btn(currentPage - 1, '‹', 'Previous page');
        if (from > 1) out += '<span class="dt-cust-page-btn" style="pointer-events:none; border:none;">…</span>';
        for (let p = from; p <= to; p++) {
            out += btn(p, String(p), '', p === currentPage ? 'active' : '');
        }
        if (to < pageCount) out += '<span class="dt-cust-page-btn" style="pointer-events:none; border:none;">…</span>';
        if (currentPage < pageCount) out += btn(currentPage + 1, '›', 'Next page');
        if (currentPage < pageCount) out += btn(pageCount, '»', 'Last page');

        wrap.innerHTML = out;
    }

    // Debounced Live Search
    let searchDebounceTimer = null;
    window.handleCustomerSearch = function (keyword) {
        clearTimeout(searchDebounceTimer);
        searchDebounceTimer = setTimeout(() => {
            const query = (keyword || '').trim().toLowerCase();
            const clearBtn = document.getElementById('dtCustSearchClear');
            if (clearBtn) {
                clearBtn.style.display = query.length > 0 ? 'block' : 'none';
            }

            if (!query) {
                currentList = [...masterCustomers];
            } else {
                currentList = masterCustomers.filter(c =>
                    c.name.toLowerCase().includes(query) ||
                    c.email.toLowerCase().includes(query) ||
                    c.phone.includes(query) ||
                    // c.id is the numeric database id now, so match the display
                    // reference ("CUST-42") rather than calling a string method
                    // on a number.
                    c.ref.toLowerCase().includes(query) ||
                    c.city.toLowerCase().includes(query) ||
                    c.tier.toLowerCase().includes(query)
                );
            }
            window.renderCustomersTable(1);
        }, 220);
    };

    window.clearCustomerSearch = function () {
        const input = document.getElementById('dtCustSearchInput');
        if (input) {
            input.value = '';
            window.handleCustomerSearch('');
            input.focus();
        }
    };

    // Filter by Tab/Status
    // The KPI cards in customer-stats.php are the filter tabs. Their gold
    // highlight was written by PHP at page load and never moved, so a filtered
    // list sat under the wrong highlighted card. 'inactive' is not a status the
    // ENUM can hold; the card that reads "Suspended" answers to both names.
    function highlightFilterCard(statusKey) {
        var key = String(statusKey || 'all').toLowerCase();
        if (key === 'inactive') key = 'suspended';
        var cards = document.querySelectorAll('.dt-cust-kpi-card[data-filter]');
        if (!cards.length) return;
        cards.forEach(function (card) {
            card.classList.toggle('active', card.getAttribute('data-filter') === key);
        });
    }

    // Which cohort this page opens on: index.php 'all', active.php 'active',
    // inactive.php 'inactive'. Reset returns here rather than to everyone, so
    // "Reset Filters" on the Active Customers page does not quietly start
    // listing suspended accounts.
    function pageDefaultFilter() {
        var grid = document.querySelector('.dt-cust-kpi-grid[data-default-filter]');
        var v = grid ? String(grid.getAttribute('data-default-filter')).trim().toLowerCase() : '';
        return v || 'all';
    }

    /* ── Cohort deep links ──────────────────────────────────────────────────
       The Labels & Cohorts page links here as index.php?cohort=wholesale or
       index.php?tier=Gold. Without this the link landed on an unfiltered
       directory, so a cohort reported as 14 customers opened onto all of them
       and the count looked wrong. Every predicate below reads a column the row
       really carries; there is no cohort key for dormancy because getAll()
       brings no last-order date. */
    var COHORT_LABELS = {
        vip: 'VIP / high-value',
        frequent: 'Repeat buyers (3+ orders)',
        no_orders: 'Never ordered',
        gujarat: 'Gujarat buyers',
        wholesale: 'Wholesale accounts',
        reseller: 'Reseller accounts',
        retail: 'Retail shoppers',
        pending: 'Awaiting approval',
        suspended: 'Suspended accounts',
        gstin: 'GSTIN on file',
        balance: 'Outstanding balance',
        untiered: 'No tier set'
    };

    function cohortPredicate(key) {
        switch (key) {
            case 'vip':       return function (c) { return /vip/i.test(c.tier) || c.spent >= 25000; };
            case 'frequent':  return function (c) { return c.orders >= 3; };
            case 'no_orders': return function (c) { return c.orders === 0; };
            case 'gujarat':   return function (c) { var s = c.state.toUpperCase(); return s === 'GJ' || s === 'GUJARAT'; };
            case 'wholesale':
            case 'reseller':
            case 'retail':    return function (c) { return c.type.toLowerCase() === key; };
            case 'pending':
            case 'suspended': return function (c) { return c.status === key; };
            case 'gstin':     return function (c) { return c.gstin !== ''; };
            case 'balance':   return function (c) { return c.balance > 0; };
            case 'untiered':  return function (c) { return c.tier === ''; };
            default:          return null;
        }
    }

    function clearCohortBanner() {
        var el = document.getElementById('dtCustCohortBanner');
        if (el) el.remove();
    }

    function showCohortBanner(label, shown) {
        clearCohortBanner();
        var anchor = document.querySelector('.dt-cust-toolbar-card');
        if (!anchor || !anchor.parentNode) return;
        var div = document.createElement('div');
        div.id = 'dtCustCohortBanner';
        div.style.cssText = 'display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;'
            + 'background:#FDF9EF; border:1.2px solid #E7D9AE; border-left:3px solid #B8860B; border-radius:10px;'
            + 'padding:10px 14px; margin-bottom:12px; font-size:0.8rem; color:#181512;';
        div.innerHTML = '<span><strong>' + esc(label) + '</strong> &mdash; showing ' + shown
            + ' of ' + masterCustomers.length + ' customer' + (masterCustomers.length === 1 ? '' : 's') + '.</span>'
            + '<button type="button" class="dt-btn dt-btn-pale dt-btn-sm" style="padding:3px 10px; font-size:0.72rem;"'
            + ' onclick="window.resetCustomerFilters()">Show all customers</button>';
        anchor.parentNode.insertBefore(div, anchor.nextSibling);
    }

    // Reads ?cohort= / ?tier= once, on load. Returns true when a cohort was
    // applied, so the caller does not then render the unfiltered list over it.
    function applyDeepLinkCohort() {
        // active.php and inactive.php force their own cohort a moment later; a
        // deep link there would be overwritten and the banner left lying.
        if (pageDefaultFilter() !== 'all') return false;

        var params;
        try { params = new URLSearchParams(window.location.search); } catch (e) { return false; }

        var tier = (params.get('tier') || '').trim();
        if (tier) {
            var want = tier.toLowerCase();
            var n = window.applyCustomerListFilter(function (c) { return c.tier.toLowerCase() === want; });
            showCohortBanner('Tier: ' + tier, n);
            return true;
        }

        var key = (params.get('cohort') || '').trim().toLowerCase();
        if (key) {
            var pred = cohortPredicate(key);
            if (!pred) return false;
            var count = window.applyCustomerListFilter(pred);
            showCohortBanner(COHORT_LABELS[key] || key, count);
            return true;
        }
        return false;
    }

    window.filterCustomersByStatus = function (statusKey, btnElement) {
        if (btnElement) {
            document.querySelectorAll('.dt-cust-pill-btn').forEach(b => b.classList.remove('active'));
            btnElement.classList.add('active');
        }
        highlightFilterCard(statusKey);
        // The banner names the cohort the deep link asked for. Any other filter
        // replaces the list, so leaving it up would mislabel what is on screen.
        clearCohortBanner();

        // customers.status is an ENUM of exactly active | pending | suspended.
        // The old branches tested for 'new' and 'inactive', which no row can
        // ever hold, and there were no branches at all for the Wholesale and
        // Reseller pills -- so those two highlighted themselves and then left
        // whatever list was already on screen.
        const byType = t => masterCustomers.filter(c => c.type.toLowerCase() === t);

        if (statusKey === 'active') {
            currentList = masterCustomers.filter(c => c.status === 'active');
        } else if (statusKey === 'pending') {
            currentList = masterCustomers.filter(c => c.status === 'pending');
        } else if (statusKey === 'inactive' || statusKey === 'suspended') {
            currentList = masterCustomers.filter(c => c.status === 'suspended');
        } else if (statusKey === 'wholesale' || statusKey === 'reseller' || statusKey === 'retail') {
            currentList = byType(statusKey);
        } else if (statusKey === 'new') {
            currentList = masterCustomers.filter(c => c.orders === 0);
        } else if (statusKey === 'vip') {
            currentList = masterCustomers.filter(c => /vip/i.test(c.tier) || c.spent >= 25000);
        } else if (statusKey === 'has_orders') {
            currentList = masterCustomers.filter(c => c.orders > 0);
        } else if (statusKey === 'no_orders') {
            currentList = masterCustomers.filter(c => c.orders === 0);
        } else {
            // Includes 'all'. Never leave a stale list behind an unknown key.
            currentList = [...masterCustomers];
        }
        window.renderCustomersTable(1);
    };

    /* Lets the advanced-filter modal narrow the same list the tabs and search
       operate on. customer-filters.js used to close the modal and toast
       "Advanced Filters Applied (12 Matches)" -- a fixed number, with no
       filtering performed at all, so an admin believed they were looking at 12
       matching customers while the table still showed everyone. Returns the real
       match count so the caller can report it truthfully. */
    window.applyCustomerListFilter = function (predicate) {
        clearCohortBanner();
        if (typeof predicate !== 'function') {
            currentList = [...masterCustomers];
            highlightFilterCard('all');
        } else {
            currentList = masterCustomers.filter(predicate);
            // The advanced filter is a cohort no KPI card stands for. Leaving a
            // card highlighted would label the result with the wrong cohort.
            document.querySelectorAll('.dt-cust-kpi-card[data-filter]')
                .forEach(function (card) { card.classList.remove('active'); });
        }
        window.renderCustomersTable(1);
        return currentList.length;
    };

    window.getCustomerListTotal = function () {
        return masterCustomers.length;
    };

    // The row checkbox carries no value attribute -- the id lives in its onchange
    // closure and in selectedIds -- so bulk-actions.js had no way to read the
    // selection out of the DOM. It tried, with `.cust-row-check:checked`, a class
    // this table has never rendered, so every bulk action ran over an empty list
    // and still reported that the customers had been updated.
    window.getSelectedCustomerIds = function () {
        return Array.from(selectedIds);
    };

    // Keep the in-memory row in step with a status change that the server has
    // confirmed, so re-rendering or re-filtering does not resurrect the old
    // badge. Returns false if that id is not in the list.
    window.setCustomerRowStatus = function (id, status) {
        var row = masterCustomers.find(function (c) { return c.id === id; });
        if (row) { row.status = status; }
        return !!row;
    };

    // Sorting
    window.sortCustomersBy = function (column) {        if (currentSort.col === column) {
            currentSort.dir = currentSort.dir === 'asc' ? 'desc' : 'asc';
        } else {
            currentSort.col = column;
            currentSort.dir = 'desc';
        }

        currentList.sort((a, b) => {
            let valA = a[column];
            let valB = b[column];
            if (typeof valA === 'string') valA = valA.toLowerCase();
            if (typeof valB === 'string') valB = valB.toLowerCase();

            if (valA < valB) return currentSort.dir === 'asc' ? -1 : 1;
            if (valA > valB) return currentSort.dir === 'asc' ? 1 : -1;
            return 0;
        });

        window.renderCustomersTable(currentPage);
    };

    // Row Checkbox & Selection
    window.toggleCustomerRowSelection = function (id, isChecked) {
        if (isChecked) {
            selectedIds.add(id);
        } else {
            selectedIds.delete(id);
        }
        updateBulkBar();
    };

    window.toggleCustomerSelectAll = function (selectAllChecked) {
        const checkboxes = document.querySelectorAll('.dt-cust-row-chk');
        checkboxes.forEach(chk => {
            chk.checked = selectAllChecked;
        });

        if (selectAllChecked) {
            currentList.forEach(c => selectedIds.add(c.id));
        } else {
            selectedIds.clear();
        }
        window.renderCustomersTable(currentPage);
        updateBulkBar();
    };

    function updateBulkBar() {
        const bar = document.getElementById('dtCustBulkBar');
        const countSpan = document.getElementById('dtCustBulkCount');
        if (!bar || !countSpan) return;

        if (selectedIds.size > 0) {
            countSpan.innerText = `${selectedIds.size} Customers Selected`;
            bar.classList.add('visible');
        } else {
            bar.classList.remove('visible');
        }
    }

    window.clearCustomerSelection = function () {
        selectedIds.clear();
        const selectAllChk = document.getElementById('dtCustSelectAll');
        if (selectAllChk) selectAllChk.checked = false;
        window.renderCustomersTable(currentPage);
        updateBulkBar();
    };

    window.resetCustomerFilters = function () {
        // Clearing the table but leaving the advanced-filter modal populated
        // meant reopening it showed criteria that were no longer applied, and
        // reset also jumped every page to "all" -- so on active.php the Active
        // card stayed highlighted while suspended accounts appeared underneath.
        if (typeof window.clearCustomerFilterInputs === 'function') {
            window.clearCustomerFilterInputs();
        }
        var input = document.getElementById('dtCustSearchInput');
        if (input) input.value = '';
        var clearBtn = document.getElementById('dtCustSearchClear');
        if (clearBtn) clearBtn.style.display = 'none';
        // The search is debounced by 220ms. Calling clearCustomerSearch() here
        // would queue a callback that lands after this reset and overwrite the
        // list with every customer, undoing the page default.
        clearTimeout(searchDebounceTimer);

        var def = pageDefaultFilter();
        window.filterCustomersByStatus(def);
        window.showToast(def === 'all'
            ? 'Filters cleared — showing all ' + masterCustomers.length + ' customers.'
            : 'Filters cleared — showing ' + currentList.length + ' of ' + masterCustomers.length + ' customers.');
    };

    // Auto-init on DOM load
    document.addEventListener('DOMContentLoaded', function () {
        // applyDeepLinkCohort() renders the table itself when it matches, so
        // this only draws the full list when there was no ?cohort= / ?tier=.
        if (!applyDeepLinkCohort()) {
            window.renderCustomersTable(1);
        }
    });

})();
