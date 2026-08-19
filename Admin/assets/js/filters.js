/**
 * filters.js — ARNIYA Admin Global Date & Metric Filters Controller
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        initDatePills();
    });

    function initDatePills() {
        const pills = document.querySelectorAll('.adm-date-pill');
        pills.forEach(function(pill) {
            pill.addEventListener('click', function() {
                pills.forEach(function(p) { p.classList.remove('active'); });
                this.classList.add('active');

                const range = this.getAttribute('data-range') || '30d';
                if (window.updateDashboardDateRange) {
                    window.updateDashboardDateRange(range);
                }
                window.showToast('📅 Filter applied: ' + this.innerText, 'info');
            });
        });
    }

})();
