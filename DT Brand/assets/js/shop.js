/**
 * DT Brand/assets/js/shop.js — Master Shop Filter, Sort, Category Rail & Grid Synchronization
 * DT Brand's & Jai Hanuman Tex
 */

(function () {
    'use strict';

    var currentFilters = {
        category: 'All',
        fabric: '',
        color: '',
        size: '',
        minPrice: 0,
        maxPrice: 35000,
        sort: 'recommended'
    };

    // Initialize from URL params
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('category')) {
        currentFilters.category = urlParams.get('category');
    }
    if (urlParams.has('search')) {
        currentFilters.search = urlParams.get('search');
    }

    // 1. Dynamic Master Filter Execution
    window.applyMasterFilters = function () {
        var cards = document.querySelectorAll('.dt-product-card');
        var visibleCount = 0;
        var totalCount = cards.length;

        cards.forEach(function (card) {
            var cat = (card.dataset.category || '').toLowerCase();
            var fabric = (card.dataset.fabric || '').toLowerCase();
            var price = parseFloat(card.dataset.price || '0');
            var colors = (card.dataset.colors || '').toLowerCase();
            var sizes = (card.dataset.sizes || '').toLowerCase();
            var title = (card.dataset.title || '').toLowerCase();
            var sku = (card.dataset.sku || '').toLowerCase();

            var matchCat = (!currentFilters.category || currentFilters.category.toLowerCase() === 'all' || cat === currentFilters.category.toLowerCase() || cat.indexOf(currentFilters.category.toLowerCase()) !== -1);
            var matchFabric = (!currentFilters.fabric || fabric.indexOf(currentFilters.fabric.toLowerCase()) !== -1);
            var matchPrice = (price >= currentFilters.minPrice && price <= currentFilters.maxPrice);
            var matchColor = (!currentFilters.color || colors.indexOf(currentFilters.color.toLowerCase()) !== -1);
            var matchSize = (!currentFilters.size || sizes.indexOf(currentFilters.size.toLowerCase()) !== -1);
            var matchSearch = (!currentFilters.search || title.indexOf(currentFilters.search.toLowerCase()) !== -1 || sku.indexOf(currentFilters.search.toLowerCase()) !== -1);

            if (matchCat && matchFabric && matchPrice && matchColor && matchSize && matchSearch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Update count text
        var countEl = document.getElementById('dtPtbCount');
        if (countEl) {
            countEl.textContent = 'Showing ' + visibleCount + ' of ' + totalCount + ' Products';
        }

        // Render Active Filter Tags
        renderActiveFilterTags();
    };

    // 2. Render Active Tags Bar
    function renderActiveFilterTags() {
        var bar = document.getElementById('dtActiveTagsBar');
        if (!bar) return;

        var tags = [];
        if (currentFilters.category && currentFilters.category.toLowerCase() !== 'all') {
            tags.push({ key: 'category', label: 'Category: ' + currentFilters.category });
        }
        if (currentFilters.fabric) {
            tags.push({ key: 'fabric', label: 'Fabric: ' + currentFilters.fabric });
        }
        if (currentFilters.color) {
            tags.push({ key: 'color', label: 'Color: ' + currentFilters.color });
        }
        if (currentFilters.size) {
            tags.push({ key: 'size', label: 'Size: ' + currentFilters.size });
        }
        if (currentFilters.maxPrice < 35000) {
            tags.push({ key: 'maxPrice', label: 'Under ₹' + currentFilters.maxPrice.toLocaleString('en-IN') });
        }
        if (currentFilters.search) {
            tags.push({ key: 'search', label: 'Search: "' + currentFilters.search + '"' });
        }

        if (tags.length === 0) {
            bar.classList.remove('has-tags');
            bar.innerHTML = '';
            return;
        }

        var html = '<span style="font-size:0.75rem; font-weight:700; color:#6B7280;">Active Filters:</span>';
        tags.forEach(function (t) {
            html += '<div class="dt-active-tag"><span>' + t.label + '</span><button type="button" onclick="removeFilterTag(\'' + t.key + '\')">✕</button></div>';
        });
        html += '<button type="button" class="dt-sf-clear-btn" style="margin-left:8px;" onclick="clearAllFilters()">Clear All</button>';

        bar.innerHTML = html;
        bar.classList.add('has-tags');
    }

    window.removeFilterTag = function (key) {
        if (key === 'category') {
            currentFilters.category = 'All';
            document.querySelectorAll('.dt-cat-circle-item, .main-cat-tab').forEach(function (el) {
                el.classList.toggle('active', el.dataset.cat === 'All');
            });
        } else if (key === 'maxPrice') {
            currentFilters.maxPrice = 35000;
            var slider = document.getElementById('dtPriceRange');
            if (slider) slider.value = 35000;
            var disp = document.getElementById('dtPriceMaxDisplay');
            if (disp) disp.textContent = '₹35,000';
        } else {
            currentFilters[key] = '';
        }
        window.applyMasterFilters();
    };

    window.clearAllFilters = function () {
        currentFilters = {
            category: 'All',
            fabric: '',
            color: '',
            size: '',
            minPrice: 0,
            maxPrice: 35000,
            sort: 'recommended'
        };
        var slider = document.getElementById('dtPriceRange');
        if (slider) slider.value = 35000;
        var disp = document.getElementById('dtPriceMaxDisplay');
        if (disp) disp.textContent = '₹35,000';

        document.querySelectorAll('.dt-sf-chip, .dt-swatch-pill').forEach(function (el) { el.classList.remove('active'); });
        document.querySelectorAll('.dt-cat-circle-item, .main-cat-tab').forEach(function (el) {
            el.classList.toggle('active', el.dataset.cat === 'All');
        });
        window.applyMasterFilters();
    };

    // Filter by Banner / Subnav / Category Rail click
    window.filterByBanner = function (catName) {
        currentFilters.category = catName;
        document.querySelectorAll('.dt-cat-circle-item').forEach(function (el) {
            el.classList.toggle('active', el.dataset.cat && el.dataset.cat.toLowerCase() === catName.toLowerCase());
        });
        document.querySelectorAll('.main-cat-tab').forEach(function (el) {
            el.classList.toggle('active', el.dataset.cat && el.dataset.cat.toLowerCase() === catName.toLowerCase());
        });
        window.applyMasterFilters();
    };

    // Event listeners on DOM Load
    document.addEventListener('DOMContentLoaded', function () {
        // Chip Filters
        document.querySelectorAll('.dt-sf-chip').forEach(function (chip) {
            chip.addEventListener('click', function () {
                var group = this.dataset.group;
                var val = this.dataset.val;
                if (currentFilters[group] === val) {
                    currentFilters[group] = '';
                    this.classList.remove('active');
                } else {
                    this.parentElement.querySelectorAll('.dt-sf-chip').forEach(function (c) { c.classList.remove('active'); });
                    this.classList.add('active');
                    currentFilters[group] = val;
                }
                window.applyMasterFilters();
            });
        });

        // Swatch Filters
        document.querySelectorAll('.dt-swatch-pill').forEach(function (pill) {
            pill.addEventListener('click', function () {
                var col = this.dataset.color;
                if (currentFilters.color === col) {
                    currentFilters.color = '';
                    this.classList.remove('active');
                } else {
                    document.querySelectorAll('.dt-swatch-pill').forEach(function (p) { p.classList.remove('active'); });
                    this.classList.add('active');
                    currentFilters.color = col;
                }
                window.applyMasterFilters();
            });
        });

        // Price Slider
        var priceSlider = document.getElementById('dtPriceRange');
        var priceDisplay = document.getElementById('dtPriceMaxDisplay');
        if (priceSlider) {
            priceSlider.addEventListener('input', function () {
                var val = Number(this.value);
                currentFilters.maxPrice = val;
                if (priceDisplay) priceDisplay.textContent = '₹' + val.toLocaleString('en-IN');
                window.applyMasterFilters();
            });
        }

        // Sorting
        var sortSelect = document.getElementById('dtPtbSortSelect');
        if (sortSelect) {
            sortSelect.addEventListener('change', function () {
                var sortVal = this.value;
                var grid = document.getElementById('dtProductsGrid');
                if (!grid) return;
                var cards = Array.from(grid.querySelectorAll('.dt-product-card'));
                cards.sort(function (a, b) {
                    var pA = parseFloat(a.dataset.price || '0');
                    var pB = parseFloat(b.dataset.price || '0');
                    if (sortVal === 'price_asc') return pA - pB;
                    if (sortVal === 'price_desc') return pB - pA;
                    if (sortVal === 'discount') return parseFloat(b.dataset.discount || '0') - parseFloat(a.dataset.discount || '0');
                    return 0;
                });
                cards.forEach(function (card) { grid.appendChild(card); });
            });
        }

        window.applyMasterFilters();
    });

})();
