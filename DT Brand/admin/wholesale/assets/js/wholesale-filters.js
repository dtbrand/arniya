/**
 * wholesale-filters.js — DT Brand's & Jai Hanuman Tex
 * Luxury Slide-Over Right Filter Drawer & Real-Time Filter Engine
 */

(function () {
    'use strict';

    window.toggleAdvancedFilters = function (forceState) {
        const drawer = document.getElementById('dtWholesaleFilterDrawer');
        const backdrop = document.getElementById('dtWholesaleDrawerBackdrop');
        if (!drawer || !backdrop) return;

        const shouldOpen = typeof forceState === 'boolean' ? forceState : !drawer.classList.contains('open');

        if (shouldOpen) {
            drawer.classList.add('open');
            backdrop.classList.add('open');
            document.body.style.overflow = 'hidden';
        } else {
            drawer.classList.remove('open');
            backdrop.classList.remove('open');
            document.body.style.overflow = '';
        }
    };

    window.applyAdvancedWholesaleFilters = function (event) {
        if (event) event.preventDefault();

        const tierVal = (document.getElementById('drawerFilterTier')?.value || 'all').toLowerCase();
        const statusVal = (document.getElementById('drawerFilterStatus')?.value || 'all').toLowerCase();
        const termsVal = (document.getElementById('drawerFilterTerms')?.value || 'all').toLowerCase();
        const kycVal = (document.getElementById('drawerFilterKyc')?.value || 'all').toLowerCase();
        const minPurchaseVal = parseFloat(document.getElementById('drawerFilterMinPurchase')?.value || '0');
        const stateVal = (document.getElementById('drawerFilterState')?.value || 'all').toLowerCase();

        // Sync with search bar quick dropdowns
        const quickTier = document.getElementById('wholesaleTierFilter');
        if (quickTier && tierVal !== 'all') quickTier.value = tierVal;

        const quickStatus = document.getElementById('wholesaleStatusFilter');
        if (quickStatus && statusVal !== 'all') quickStatus.value = statusVal;

        const rows = document.querySelectorAll('#wholesaleTableBody tr.wholesale-row-item');
        let visibleCount = 0;

        rows.forEach(function (row) {
            const rowTier = (row.getAttribute('data-tier') || '').toLowerCase();
            const rowStatus = (row.getAttribute('data-status') || '').toLowerCase();
            const textContent = (row.innerText || '').toLowerCase();

            const matchesTier = (tierVal === 'all') || rowTier.includes(tierVal) || (tierVal.includes(rowTier) && rowTier.length > 0);
            const matchesStatus = (statusVal === 'all') || (rowStatus === statusVal);
            const matchesTerms = (termsVal === 'all') || textContent.includes(termsVal);
            const matchesKyc = (kycVal === 'all') || textContent.includes(kycVal);
            const matchesState = (stateVal === 'all') || textContent.includes(stateVal);

            let matchesMinPurchase = true;
            if (minPurchaseVal > 0) {
                const purchaseCell = row.querySelector('.col-whl-purchase')?.innerText || '';
                const purchaseNum = parseFloat(purchaseCell.replace(/[^0-9.]/g, '')) || 0;
                matchesMinPurchase = purchaseNum >= minPurchaseVal;
            }

            if (matchesTier && matchesStatus && matchesTerms && matchesKyc && matchesState && matchesMinPurchase) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        const countBadge = document.getElementById('wholesaleVisibleCountBadge');
        if (countBadge) {
            countBadge.innerText = `Showing ${visibleCount} Wholesalers`;
        }

        window.toggleAdvancedFilters(false);
        if (window.showToast) {
            window.showToast(`✓ Filter criteria applied (${visibleCount} results)`);
        }
    };

    window.resetAdvancedFilters = function () {
        const form = document.getElementById('wholesaleFilterForm');
        if (form) form.reset();

        const quickTier = document.getElementById('wholesaleTierFilter');
        if (quickTier) quickTier.value = 'all';

        const quickStatus = document.getElementById('wholesaleStatusFilter');
        if (quickStatus) quickStatus.value = 'all';

        const searchInput = document.getElementById('wholesaleSearchInput');
        if (searchInput) searchInput.value = '';

        const rows = document.querySelectorAll('#wholesaleTableBody tr.wholesale-row-item');
        rows.forEach(function (row) {
            row.style.display = '';
        });

        const countBadge = document.getElementById('wholesaleVisibleCountBadge');
        if (countBadge) {
            countBadge.innerText = `Showing ${rows.length} Wholesalers`;
        }

        window.toggleAdvancedFilters(false);
        if (window.showToast) {
            window.showToast('✓ All filter criteria cleared');
        }
    };

    // Close on ESC key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const drawer = document.getElementById('dtWholesaleFilterDrawer');
            if (drawer && drawer.classList.contains('open')) {
                window.toggleAdvancedFilters(false);
            }
        }
    });

})();
