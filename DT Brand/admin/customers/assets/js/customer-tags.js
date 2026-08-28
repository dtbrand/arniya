/**
 * customer-tags.js - Label & cohort table search
 * DT Brand's & Jai Hanuman Tex - Live Production Standard
 *
 * This file used to hold three handlers, and two of them stored nothing:
 *
 *   addCustomerTag()        prepended a chip and a table row, then toasted
 *                           'Tag "X" created successfully!'. There is no tags
 *                           table and no column on `customers` that could hold
 *                           a free-form label, so the tag existed until the
 *                           next reload and never reached the database. It also
 *                           interpolated the typed name straight into an
 *                           onclick attribute and into innerHTML, so a name
 *                           containing a quote broke the row and a name
 *                           containing markup ran as script.
 *   removeTagChip()         asked for confirmation, removed the chip from the
 *                           DOM and reported the tag removed.
 *   broadcastToTaggedGroup()toasted 'Preparing 1-Click WhatsApp Broadcast to
 *                           1,850 customers tagged "Frequent Buyer"...'. There
 *                           is no broadcast integration anywhere in this
 *                           codebase, and that cohort was a PHP literal.
 *
 * All three are gone with the markup that called them. What is left is the one
 * thing that always worked: filtering the rendered rows.
 */

(function () {
    'use strict';

    // Both tables on the page mark their rows .dt-tag-row, so one box filters
    // stored tier labels and derived cohorts together.
    window.filterTagsTable = function (query) {
        var q = String(query == null ? '' : query).toLowerCase().trim();

        var input = document.getElementById('dtTagSearchInput');
        if (input && input.value !== query) { input.value = q ? query : ''; }

        var clearBtn = document.getElementById('dtTagSearchClearBtn');
        if (clearBtn) { clearBtn.style.display = q ? 'flex' : 'none'; }

        var rows = document.querySelectorAll('.dt-tag-row');
        var shown = 0;
        rows.forEach(function (row) {
            var haystack = (row.getAttribute('data-tag-name') || row.innerText || '').toLowerCase();
            var match = !q || haystack.indexOf(q) !== -1;
            row.style.display = match ? '' : 'none';
            if (match) shown++;
        });

        // Report the real match count. A search that hides every row otherwise
        // looks like a page that failed to load.
        var counter = document.getElementById('dtTagSearchCount');
        if (counter) {
            if (!q) {
                counter.textContent = '';
            } else if (shown === 0) {
                counter.textContent = 'No match';
            } else {
                counter.textContent = shown + ' of ' + rows.length + ' shown';
            }
        }
    };

})();
