/**
 * DT Brand/assets/js/header.js — Header Search Autocomplete, Mobile Search & Ticker Logic
 * DT Brand's & Jai Hanuman Tex
 */

(function () {
    'use strict';

    // 1. Top Announcement Ticker Auto-Slide
    var tickerIndex = 0;
    var tickerTimer = null;

    window.slideDtTicker = function (dir) {
        var slides = document.querySelectorAll('#dtTickerTrack .dt-ticker-slide');
        if (!slides.length) return;

        slides[tickerIndex].classList.remove('active');
        slides[tickerIndex].classList.add('exit-up');

        var prevIndex = tickerIndex;
        tickerIndex = (tickerIndex + dir + slides.length) % slides.length;

        setTimeout(function () {
            slides[prevIndex].classList.remove('exit-up');
        }, 500);

        slides[tickerIndex].classList.add('active');
    };

    function startTickerAuto() {
        if (tickerTimer) clearInterval(tickerTimer);
        tickerTimer = setInterval(function () {
            window.slideDtTicker(1);
        }, 4000);
    }

    // 2. Desktop Amazon-Style Search Autocomplete
    function initSearch() {
        var searchInput = document.getElementById('dtSearchInput');
        var catSelect = document.getElementById('dtSearchCatSelect');
        var suggestionsBox = document.getElementById('dtSearchSuggestions');
        var clearBtn = document.getElementById('dtSearchClear');
        var submitBtn = document.getElementById('dtSearchSubmit');

        if (!searchInput) return;

        var debounceTimeout = null;

        function performSearch(q) {
            var cat = catSelect ? catSelect.value : 'All';
            if (!q && (!cat || cat === 'All')) {
                suggestionsBox.style.display = 'none';
                return;
            }

            fetch('/api/search.php?q=' + encodeURIComponent(q) + '&cat=' + encodeURIComponent(cat))
                .then(function (r) { return r.json(); })
                .then(function (res) {
                    if (!res.success || !res.results || (!res.results.products.length && !res.results.categories.length)) {
                        suggestionsBox.innerHTML = '<div style="padding:12px; font-size:0.8rem; color:#6B7280; text-align:center;">No matching products found.</div>';
                        suggestionsBox.style.display = 'block';
                        return;
                    }

                    var html = '';
                    if (res.results.categories && res.results.categories.length) {
                        html += '<div style="padding:6px 12px; background:#FAF8F4; font-size:0.7rem; font-weight:800; color:#8A681F;">CATEGORIES</div>';
                        res.results.categories.forEach(function (c) {
                            html += '<a href="/shop.php?category=' + encodeURIComponent(c.name) + '" class="dt-suggestion-item">' +
                                '<svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:#8A681F;fill:none;"><polyline points="9 18 15 12 9 6"></polyline></svg>' +
                                '<span>' + c.name + '</span>' +
                                '</a>';
                        });
                    }

                    if (res.results.products && res.results.products.length) {
                        html += '<div style="padding:6px 12px; background:#FAF8F4; font-size:0.7rem; font-weight:800; color:#8A681F;">PRODUCTS</div>';
                        res.results.products.forEach(function (p) {
                            html += '<a href="' + p.url + '" class="dt-suggestion-item">' +
                                '<img src="' + p.image + '" class="dt-suggestion-thumb" alt="' + p.name + '" />' +
                                '<div style="flex:1; overflow:hidden;">' +
                                '<div style="font-weight:700; font-size:0.82rem; white-space:nowrap; text-overflow:ellipsis; overflow:hidden;">' + p.name + '</div>' +
                                '<div style="font-size:0.75rem; color:#8A681F; font-weight:800;">₹' + Number(p.price).toLocaleString('en-IN') + '</div>' +
                                '</div>' +
                                '</a>';
                        });
                    }

                    suggestionsBox.innerHTML = html;
                    suggestionsBox.style.display = 'block';
                })
                .catch(function () {
                    suggestionsBox.style.display = 'none';
                });
        }

        searchInput.addEventListener('input', function () {
            var val = this.value.trim();
            if (clearBtn) clearBtn.style.display = val.length ? 'flex' : 'none';

            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(function () {
                performSearch(val);
            }, 250);
        });

        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                searchInput.value = '';
                this.style.display = 'none';
                suggestionsBox.style.display = 'none';
                searchInput.focus();
            });
        }

        if (submitBtn) {
            submitBtn.addEventListener('click', function () {
                var q = searchInput.value.trim();
                var cat = catSelect ? catSelect.value : 'All';
                window.location.href = '/shop.php?search=' + encodeURIComponent(q) + '&category=' + encodeURIComponent(cat);
            });
        }

        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                if (submitBtn) submitBtn.click();
            }
        });

        // Close suggestions on outside click
        document.addEventListener('click', function (e) {
            if (!e.target.closest('#dtSearchAmazon')) {
                suggestionsBox.style.display = 'none';
            }
        });
    }

    // 3. Mobile Search Overlay Toggle
    function initMobileSearch() {
        var trigger = document.getElementById('dtMobileSearchTrigger');
        var bar = document.getElementById('dtMobileSearchBar');
        var closeBtn = document.getElementById('dtMobileSearchClose');
        var input = document.getElementById('dtMobileSearchInput');
        var submitBtn = document.getElementById('dtMobileSearchSubmit');

        if (!trigger || !bar) return;

        trigger.addEventListener('click', function () {
            bar.classList.add('active');
            if (input) input.focus();
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                bar.classList.remove('active');
            });
        }

        if (submitBtn && input) {
            submitBtn.addEventListener('click', function () {
                var q = input.value.trim();
                if (q) window.location.href = '/shop.php?search=' + encodeURIComponent(q);
            });
            input.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') submitBtn.click();
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        startTickerAuto();
        initSearch();
        initMobileSearch();
    });

})();
