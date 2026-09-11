/**
 * reports.js — DT Brand's & Jai Hanuman Tex Reports & Analytics UI Interactive Script
 * Section 33: Reports / Analytics & Export Suite
 */

(function() {
    'use strict';

    // Auto-bind date range pill buttons
    document.addEventListener('DOMContentLoaded', function() {
        var pills = document.querySelectorAll('.dt-report-pill');
        pills.forEach(function(pill) {
            pill.addEventListener('click', function(e) {
                var range = this.getAttribute('data-range');
                if (!range) return;

                var currentUrl = new URL(window.location.href);
                currentUrl.searchParams.set('range', range);
                window.location.href = currentUrl.toString();
            });
        });

        // Quick Print Trigger
        var printBtns = document.querySelectorAll('.dt-print-trigger');
        printBtns.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                window.print();
            });
        });

        // Instant Export Trigger
        var exportTriggers = document.querySelectorAll('[data-export-type]');
        exportTriggers.forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                var type = this.getAttribute('data-export-type');
                var format = this.getAttribute('data-export-format') || 'csv';
                var currentUrl = new URL(window.location.href);
                var range = currentUrl.searchParams.get('range') || 'all';

                var exportUrl = '/api/reports.php?action=export&type=' + encodeURIComponent(type) + '&range=' + encodeURIComponent(range) + '&format=' + encodeURIComponent(format);
                window.location.href = exportUrl;
            });
        });
    });
})();
