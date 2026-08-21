/**
 * customer-list.js — Dynamic Table, Search, Sorting & Pagination Controller
 * DT Brand's & Jai Hanuman Tex — Luxury Master Design System
 */

(function () {
    'use strict';

    // Master Customer Data Model (Enterprise B2C Shoppers)
    const masterCustomers = [
        {
            id: 'CUST-1042',
            name: 'Pooja Sharma',
            initial: 'PS',
            avatarColor: 'gold',
            email: 'pooja.sharma92@gmail.com',
            phone: '+91 98110 29381',
            type: 'Retail Verified',
            city: 'Delhi, DL',
            orders: 6,
            spent: 28450,
            aov: 4741,
            lastOrder: 'Today, 11:20 AM',
            joined: '12 Jan 2025',
            status: 'active',
            tags: ['VIP', 'Saree Lover', 'Frequent Buyer']
        },
        {
            id: 'CUST-1041',
            name: 'Ananya Roy',
            initial: 'AR',
            avatarColor: 'emerald',
            email: 'ananya.roy.kolkata@yahoo.com',
            phone: '+91 97118 23901',
            type: 'Retail Verified',
            city: 'Kolkata, WB',
            orders: 4,
            spent: 19800,
            aov: 4950,
            lastOrder: 'Yesterday, 16:45',
            joined: '04 Mar 2025',
            status: 'active',
            tags: ['Silk Certified', 'High Value']
        },
        {
            id: 'CUST-1040',
            name: 'Ritu Rajvansh',
            initial: 'RR',
            avatarColor: 'purple',
            email: 'ritu.rajvansh@outlook.com',
            phone: '+91 94250 88219',
            type: 'Retail Verified',
            city: 'Jaipur, RJ',
            orders: 8,
            spent: 42900,
            aov: 5362,
            lastOrder: '19 Apr 2026',
            joined: '18 Nov 2024',
            status: 'active',
            tags: ['VIP', 'Bridal Lehenga', 'Top 1%']
        },
        {
            id: 'CUST-1039',
            name: 'Meera Deshmukh',
            initial: 'MD',
            avatarColor: 'amber',
            email: 'meera.deshmukh@gmail.com',
            phone: '+91 98220 44912',
            type: 'Direct Shopper',
            city: 'Pune, MH',
            orders: 2,
            spent: 7600,
            aov: 3800,
            lastOrder: '15 Apr 2026',
            joined: '10 Feb 2026',
            status: 'active',
            tags: ['Cotton Kurtis']
        },
        {
            id: 'CUST-1038',
            name: 'Sunita Agarwal',
            initial: 'SA',
            avatarColor: 'gold',
            email: 'sunita.agarwal.ahd@gmail.com',
            phone: '+91 99042 11980',
            type: 'Direct Shopper',
            city: 'Ahmedabad, GJ',
            orders: 1,
            spent: 3450,
            aov: 3450,
            lastOrder: '02 Apr 2026',
            joined: '28 Mar 2026',
            status: 'new',
            tags: ['New Customer']
        },
        {
            id: 'CUST-1037',
            name: 'Kavita Patel',
            initial: 'KP',
            avatarColor: 'emerald',
            email: 'kavita.patel.surat@gmail.com',
            phone: '+91 98790 33411',
            type: 'Retail Verified',
            city: 'Surat, GJ',
            orders: 5,
            spent: 22100,
            aov: 4420,
            lastOrder: '28 Mar 2026',
            joined: '05 Jan 2025',
            status: 'active',
            tags: ['Surat Local', 'Frequent Buyer']
        },
        {
            id: 'CUST-1036',
            name: 'Deepika Sen',
            initial: 'DS',
            avatarColor: 'purple',
            email: 'deepika.sen.blr@gmail.com',
            phone: '+91 98450 77123',
            type: 'Direct Shopper',
            city: 'Bengaluru, KA',
            orders: 0,
            spent: 0,
            aov: 0,
            lastOrder: 'Never',
            joined: '14 Apr 2026',
            status: 'new',
            tags: ['New Registration', 'No Orders']
        },
        {
            id: 'CUST-1035',
            name: 'Sneha Kulkarni',
            initial: 'SK',
            avatarColor: 'amber',
            email: 'sneha.kulkarni@yahoo.co.in',
            phone: '+91 98200 99451',
            type: 'Direct Shopper',
            city: 'Mumbai, MH',
            orders: 1,
            spent: 4200,
            aov: 4200,
            lastOrder: '10 Jan 2026',
            joined: '15 Oct 2024',
            status: 'inactive',
            tags: ['Dormant > 90 Days']
        },
        {
            id: 'CUST-1034',
            name: 'Bhavna Chawla',
            initial: 'BC',
            avatarColor: 'gold',
            email: 'bhavna.chawla@gmail.com',
            phone: '+91 98101 66320',
            type: 'Retail Verified',
            city: 'Chandigarh, PB',
            orders: 7,
            spent: 36800,
            aov: 5257,
            lastOrder: '12 Apr 2026',
            joined: '20 Aug 2024',
            status: 'active',
            tags: ['VIP', 'High Value', 'Unstitched Suits']
        },
        {
            id: 'CUST-1033',
            name: 'Priyanka Ghosh',
            initial: 'PG',
            avatarColor: 'emerald',
            email: 'priyanka.ghosh@hotmail.com',
            phone: '+91 98310 55432',
            type: 'Direct Shopper',
            city: 'Kolkata, WB',
            orders: 3,
            spent: 11400,
            aov: 3800,
            lastOrder: '08 Mar 2026',
            joined: '12 Dec 2024',
            status: 'active',
            tags: ['Chanderi Saree']
        },
        {
            id: 'CUST-1032',
            name: 'Archana Joshi',
            initial: 'AJ',
            avatarColor: 'purple',
            email: 'archana.joshi.indore@gmail.com',
            phone: '+91 94251 12389',
            type: 'Direct Shopper',
            city: 'Indore, MP',
            orders: 0,
            spent: 0,
            aov: 0,
            lastOrder: 'Never',
            joined: '01 Nov 2024',
            status: 'inactive',
            tags: ['Dormant Account', 'No Orders']
        },
        {
            id: 'CUST-1031',
            name: 'Farida Khan',
            initial: 'FK',
            avatarColor: 'amber',
            email: 'farida.khan.hyd@gmail.com',
            phone: '+91 98490 11244',
            type: 'Account Suspended',
            city: 'Hyderabad, TS',
            orders: 1,
            spent: 2800,
            aov: 2800,
            lastOrder: '05 Sep 2025',
            joined: '10 Aug 2025',
            status: 'suspended',
            tags: ['RTO Return Abuse', 'Suspended']
        }
    ];

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
            tbody.innerHTML = `
                <tr>
                    <td colspan="10" style="padding:0;">
                        <div class="dt-cust-empty-state">
                            <div class="dt-cust-empty-icon">
                                <svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            </div>
                            <h4 class="dt-cust-empty-title">No Customers Found</h4>
                            <p class="dt-cust-empty-sub">Try changing your search keywords or resetting the active filters.</p>
                            <button type="button" class="dt-btn dt-btn-pale" onclick="window.resetCustomerFilters()">Reset Filters</button>
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
            const statusLabel = c.status === 'active' ? 'Active' : (c.status === 'suspended' ? 'Suspended' : (c.status === 'new' ? 'New Account' : 'Inactive'));

            html += `
                <tr class="${isChecked ? 'selected' : ''}" data-cust-id="${c.id}">
                    <td style="width:36px; text-align:center;">
                        <input type="checkbox" class="dt-cust-row-chk" onchange="window.toggleCustomerRowSelection('${c.id}', this.checked)" ${isChecked ? 'checked' : ''}>
                    </td>
                    <td>
                        <div class="dt-cust-avatar-cell">
                            <div class="dt-cust-avatar ${c.avatarColor}">${c.initial}</div>
                            <div class="dt-cust-name-wrap">
                                <div class="dt-cust-name-row">
                                    <a href="/Frontend/Admin/customers/view.php?id=${c.id}" class="dt-cust-name">${c.name}</a>
                                    ${c.tags.includes('VIP') ? '<span class="dt-status-pill vip" style="font-size:0.6rem; padding:1px 5px;">VIP</span>' : ''}
                                </div>
                                <span class="dt-cust-id-badge">#${c.id} • ${c.city}</span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="dt-cust-contact-cell">
                            <span class="dt-cust-phone">${c.phone}</span>
                            <span class="dt-cust-email">${c.email}</span>
                        </div>
                    </td>
                    <td><span class="dt-status-pill" style="background:#FAF8F4; border:1px solid #EAE5D9; color:#4B5563;">${c.type}</span></td>
                    <td style="text-align:center; font-weight:800; color:#181512;">${c.orders} Orders</td>
                    <td>
                        <div class="dt-cust-money">${formatRupee(c.spent)}</div>
                        <small style="color:#78716C; font-size:0.65rem;">AOV: ${formatRupee(c.aov)}</small>
                    </td>
                    <td style="color:#645D54; font-size:0.72rem; font-weight:600;">${c.lastOrder}</td>
                    <td style="color:#78716C; font-size:0.72rem;">${c.joined}</td>
                    <td>
                        <span class="dt-status-pill ${statusClass}">
                            <span style="width:6px; height:6px; border-radius:50%; background:currentColor; display:inline-block;"></span>
                            ${statusLabel}
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <div class="dt-cust-actions-cell">
                            <a href="https://wa.me/${c.phone.replace(/[^0-9]/g, '')}?text=Hello%20${encodeURIComponent(c.name)}%2C%20welcome%20to%20DT%20Brand%27s" target="_blank" class="dt-cust-act-btn wa" title="1-Click WhatsApp Connect">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                            </a>
                            <a href="/Frontend/Admin/customers/view.php?id=${c.id}" class="dt-cust-act-btn" title="View 360° Profile">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>
                            <a href="/Frontend/Admin/customers/edit.php?id=${c.id}" class="dt-cust-act-btn" title="Edit Customer">
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
            info.innerHTML = `Showing <strong>${start}–${end}</strong> of <strong>${total}</strong> Customers`;
        }
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
                    c.id.toLowerCase().includes(query) ||
                    c.city.toLowerCase().includes(query) ||
                    c.tags.some(t => t.toLowerCase().includes(query))
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
    window.filterCustomersByStatus = function (statusKey, btnElement) {
        if (btnElement) {
            document.querySelectorAll('.dt-cust-pill-btn').forEach(b => b.classList.remove('active'));
            btnElement.classList.add('active');
        }

        if (statusKey === 'all') {
            currentList = [...masterCustomers];
        } else if (statusKey === 'active') {
            currentList = masterCustomers.filter(c => c.status === 'active');
        } else if (statusKey === 'inactive') {
            currentList = masterCustomers.filter(c => c.status === 'inactive' || c.status === 'suspended');
        } else if (statusKey === 'new') {
            currentList = masterCustomers.filter(c => c.status === 'new' || c.orders === 0);
        } else if (statusKey === 'vip') {
            currentList = masterCustomers.filter(c => c.tags.includes('VIP') || c.spent >= 25000);
        } else if (statusKey === 'has_orders') {
            currentList = masterCustomers.filter(c => c.orders > 0);
        } else if (statusKey === 'no_orders') {
            currentList = masterCustomers.filter(c => c.orders === 0);
        }
        window.renderCustomersTable(1);
    };

    // Sorting
    window.sortCustomersBy = function (column) {
        if (currentSort.col === column) {
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
        window.clearCustomerSearch();
        window.filterCustomersByStatus('all');
        window.showToast('✓ Filters reset to default');
    };

    // Auto-init on DOM load
    document.addEventListener('DOMContentLoaded', function () {
        window.renderCustomersTable(1);
    });

})();
