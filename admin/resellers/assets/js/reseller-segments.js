/**
 * reseller-segments.js — DT Brand's & Jai Hanuman Tex
 * Reseller Cohort Filtering, Partner Directory & Broadcast Studio
 */

(function () {
    'use strict';

    const cohortNames = {
        'elite': { name: 'Elite Power Reseller', color: 'gold' },
        'dropship': { name: 'High-Frequency Dropshipper', color: 'emerald' },
        'boutique': { name: 'Social Boutique Seller', color: 'blue' },
        'dormant': { name: 'Credit Watch & Dormant', color: 'amber' }
    };

    // ── Filter by Cohort Card Click ──
    window.filterByCohort = function (cohortId, cohortName) {
        document.querySelectorAll('.dt-cohort-card').forEach((card) => {
            card.classList.remove('active-cohort');
        });

        const activeCard = document.getElementById('cohortCard_' + cohortId);
        if (activeCard) activeCard.classList.add('active-cohort');

        const filterSelect = document.getElementById('partnerCohortFilter');
        if (filterSelect) filterSelect.value = cohortId;

        const badge = document.getElementById('activeCohortBadge');
        if (badge) {
            badge.innerText = `Showing: ${cohortName}`;
            badge.className = `dt-status-pill-clean ${cohortNames[cohortId]?.color || 'gold'}`;
        }

        applyDirectoryFilters();

        const section = document.getElementById('cohortDirectorySection');
        if (section) {
            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    };

    // ── Show All Cohorts ──
    window.showAllCohorts = function () {
        document.querySelectorAll('.dt-cohort-card').forEach((card) => {
            card.classList.remove('active-cohort');
        });

        const filterSelect = document.getElementById('partnerCohortFilter');
        if (filterSelect) filterSelect.value = 'all';

        const searchInput = document.getElementById('partnerSearchInput');
        if (searchInput) searchInput.value = '';

        const badge = document.getElementById('activeCohortBadge');
        if (badge) {
            badge.innerText = 'Showing All Cohorts (348)';
            badge.className = 'dt-status-pill-clean gold';
        }

        applyDirectoryFilters();
    };

    // ── Dropdown Change ──
    window.onCohortFilterChange = function () {
        const filterVal = document.getElementById('partnerCohortFilter')?.value || 'all';

        document.querySelectorAll('.dt-cohort-card').forEach((card) => {
            card.classList.remove('active-cohort');
        });

        if (filterVal !== 'all') {
            const activeCard = document.getElementById('cohortCard_' + filterVal);
            if (activeCard) activeCard.classList.add('active-cohort');

            const badge = document.getElementById('activeCohortBadge');
            if (badge) {
                badge.innerText = `Showing: ${cohortNames[filterVal]?.name || filterVal}`;
                badge.className = `dt-status-pill-clean ${cohortNames[filterVal]?.color || 'gold'}`;
            }
        } else {
            const badge = document.getElementById('activeCohortBadge');
            if (badge) {
                badge.innerText = 'Showing All Cohorts (348)';
                badge.className = 'dt-status-pill-clean gold';
            }
        }

        applyDirectoryFilters();
    };

    // ── Live Search Filter ──
    window.filterPartnerDirectory = function () {
        applyDirectoryFilters();
    };

    function applyDirectoryFilters() {
        const query = (document.getElementById('partnerSearchInput')?.value || '').toLowerCase().trim();
        const cohortFilter = document.getElementById('partnerCohortFilter')?.value || 'all';

        const rows = document.querySelectorAll('#partnerDirectoryTbody .partner-dir-row');

        rows.forEach((row) => {
            const rowCohort = row.getAttribute('data-cohort') || '';
            const idText = (row.querySelector('.partner-id-cell')?.innerText || '').toLowerCase();
            const nameText = (row.querySelector('.partner-name-cell')?.innerText || '').toLowerCase();
            const cohortText = (row.querySelector('.partner-cohort-cell')?.innerText || '').toLowerCase();

            const matchesQuery = !query || idText.includes(query) || nameText.includes(query) || cohortText.includes(query);
            const matchesCohort = (cohortFilter === 'all') || (rowCohort === cohortFilter);

            if (matchesQuery && matchesCohort) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // ── Create Segment Modal ──
    window.openCreateSegmentModal = function () {
        const modal = document.getElementById('dtCreateSegmentModal');
        if (modal) modal.style.display = 'flex';
    };

    window.submitCreateSegment = function (event) {
        if (event) event.preventDefault();
        const name = document.getElementById('newSegmentName').value.trim();
        window.closeSegmentModal('dtCreateSegmentModal');
        window.showToast(`✅ New Cohort "${name}" created and automated classification activated!`);
    };

    // ── Re-assign Partner Cohort Modal ──
    window.openReassignModal = function (partnerId, partnerName, currentCohort) {
        document.getElementById('reassignPartnerId').value = partnerId;
        document.getElementById('reassignPartnerName').innerText = `${partnerName} (${partnerId})`;
        document.getElementById('reassignTargetCohortSelect').value = currentCohort || 'elite';

        const modal = document.getElementById('dtReassignCohortModal');
        if (modal) modal.style.display = 'flex';
    };

    window.submitReassignCohort = function (event) {
        if (event) event.preventDefault();
        const partnerId = document.getElementById('reassignPartnerId').value;
        const targetCohort = document.getElementById('reassignTargetCohortSelect').value;

        const row = document.getElementById(partnerId);
        if (row) {
            row.setAttribute('data-cohort', targetCohort);
            const cohortCell = row.querySelector('.partner-cohort-cell');
            const targetInfo = cohortNames[targetCohort] || { name: targetCohort, color: 'gold' };

            if (cohortCell) {
                cohortCell.innerHTML = `<span class="dt-status-pill-clean ${targetInfo.color}">${targetInfo.name}</span>`;
            }
        }

        window.closeSegmentModal('dtReassignCohortModal');
        window.showToast(`✅ Partner "${partnerId}" re-assigned to "${cohortNames[targetCohort]?.name || targetCohort}"!`);
    };

    // ── WhatsApp Cohort Broadcast Modal ──
    window.openCohortBroadcastModal = function (cohortId, cohortName, count) {
        document.getElementById('broadcastCohortId').value = cohortId;
        document.getElementById('broadcastCohortTitle').innerText = cohortName;
        document.getElementById('broadcastCohortCount').innerText = `${count} Verified WhatsApp Partners`;

        const modal = document.getElementById('dtBroadcastCohortModal');
        if (modal) modal.style.display = 'flex';
    };

    window.submitCohortBroadcast = function (event) {
        if (event) event.preventDefault();
        const title = document.getElementById('broadcastCohortTitle').innerText;
        window.closeSegmentModal('dtBroadcastCohortModal');
        window.showToast(`🚀 WhatsApp Broadcast launched to all ${title} partners!`);
    };

    // ── Close Modals ──
    window.closeSegmentModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.style.display = 'none';
    };

})();
