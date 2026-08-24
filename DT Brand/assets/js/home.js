
(function () {
    'use strict';

    var products = window.shopProductsData || [];
    window.allProducts = products;

    /* ── Global Luxury Designer Toast Helper ── */
    window.showToast = function (msg, explicitType) {
        var container = document.getElementById('toastContainer') || document.getElementById('wsToastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        var raw = String(msg || '').trim();
        var cleanText = raw.replace(/^[\u{1F300}-\u{1FAFF}\u{2600}-\u{27BF}\u{1F1E6}-\u{1F1FF}✨✓♡❤️🛒🛍️📦🏷️👗🥻📄📁🎫💳⚡🏦📍📋🚀🎉📩\s]+/u, '').trim();
        if (!cleanText) cleanText = raw;

        var lower = raw.toLowerCase();
        var badgeType = explicitType || 'success';
        var iconSvg = '';

        if (explicitType === 'cart' || lower.indexOf('cart') !== -1 || lower.indexOf('bag') !== -1 || lower.indexOf('lot') !== -1 || lower.indexOf('pcs') !== -1) {
            badgeType = 'cart';
            iconSvg = '<svg class="toast-svg-cart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>';
        } else if (explicitType === 'wishlist' || lower.indexOf('wishlist') !== -1 || lower.indexOf('saved') !== -1 || lower.indexOf('♡') !== -1 || lower.indexOf('❤️') !== -1 || lower.indexOf('heart') !== -1) {
            badgeType = 'wishlist';
            iconSvg = '<svg class="toast-svg-heart" viewBox="0 0 24 24" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>';
        } else if (explicitType === 'filter' || lower.indexOf('filter') !== -1 || lower.indexOf('lots') !== -1 || lower.indexOf('category') !== -1 || lower.indexOf('saree') !== -1 || lower.indexOf('lehenga') !== -1 || lower.indexOf('kurti') !== -1 || lower.indexOf('available') !== -1) {
            badgeType = 'filter';
            iconSvg = '<svg class="toast-svg-sparkle" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"></path><circle cx="12" cy="12" r="3" fill="#FAF5E8"></circle></svg>';
        } else if (explicitType === 'order' || lower.indexOf('order') !== -1 || lower.indexOf('tracking') !== -1 || lower.indexOf('awb') !== -1 || lower.indexOf('pdf') !== -1 || lower.indexOf('csv') !== -1 || lower.indexOf('statement') !== -1) {
            badgeType = 'order';
            iconSvg = '<svg class="toast-svg-package" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>';
        } else {
            badgeType = 'success';
            iconSvg = '<svg class="toast-svg-check" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
        }

        var t = document.createElement('div');
        t.className = 'ws-toast toast';
        t.style.setProperty('--toast-duration', '3.2s');

        t.innerHTML = '<div class="ws-toast-icon-badge toast-icon-badge badge-' + badgeType + '">' +
            iconSvg +
            '</div>' +
            '<div class="ws-toast-msg toast-msg">' + cleanText + '</div>' +
            '<button type="button" class="ws-toast-close-btn toast-close-btn" aria-label="Close">✕</button>' +
            '<div class="ws-toast-progress toast-progress"></div>';

        var closeBtn = t.querySelector('.ws-toast-close-btn');
        if (closeBtn) {
            closeBtn.onclick = function(e) {
                e.stopPropagation();
                t.classList.add('hide');
                setTimeout(function() { t.remove(); }, 250);
            };
        }

        container.appendChild(t);

        var timer = setTimeout(function() {
            t.classList.add('hide');
            setTimeout(function() { t.remove(); }, 250);
        }, 3200);

        t.onmouseenter = function() { clearTimeout(timer); };
        t.onmouseleave = function() {
            timer = setTimeout(function() {
                t.classList.add('hide');
                setTimeout(function() { t.remove(); }, 250);
            }, 1600);
        };
    };

    /* Global Product Card Share Function (Triggers Meesho Smart Share) */
    window.shareProductCard = function(productId) {
        var p = (window.allProducts || []).find(function(item) { return Number(item.id) === Number(productId); });
        if (p && typeof window.openSmartShareModal === 'function') {
            var itemData = {
                id: p.id,
                name: p.name,
                category: p.category,
                price: p.price,
                old_price: p.old_price,
                discount: p.discount,
                image: p.image,
                fabric: p.fabric || 'Pure Silk',
                colors: Array.isArray(p.colors) ? p.colors.join(', ') : (p.color || ''),
                sizes: Array.isArray(p.size) ? p.size.join(', ') : 'Free Size',
                url: '/product.php?id=' + p.id
            };
            window.openSmartShareModal(itemData);
        } else if (p) {
            var waUrl = 'https://api.whatsapp.com/send?text=' + encodeURIComponent('Check out ' + p.name + ' at DT Brand\'s: ' + window.location.origin + '/product.php?id=' + p.id);
            window.open(waUrl, '_blank');
        }
    };

    /* ════════════════════════════════════════════════════
       MASTER FILTER ENGINE & STATE MANAGEMENT
    ════════════════════════════════════════════════════ */
    window.masterFilterState = {
        category: 'All',
        colors: [],
        sizes: [],
        fabrics: [],
        minPrice: 500,
        maxPrice: 30000,
        minDiscount: 0,
        availability: [],
        sortBy: 'recommended'
    };

    var cardElems = document.querySelectorAll('.product-card');

    /* ── Sub-Category Data for Round Circles (Dynamically Built from Live DB) ── */
    var subCategoryData = {
        'All': [
            { label: 'All Items', icon: '✦', gradient: 'gradient-1', type: 'all' }
        ]
    };

    var catSource = (Array.isArray(window.allCategories) && window.allCategories.length > 0)
        ? window.allCategories 
        : (Array.isArray(window.allProducts) ? window.allProducts.map(function(p){ return { name: p.category, image: p.image }; }) : []);

    var uniqueCatMap = {};
    catSource.forEach(function(c, i) {
        if (!c || !c.name || uniqueCatMap[c.name]) return;
        uniqueCatMap[c.name] = true;
        var cImg = c.image || ('/assets/images/product' + ((i % 6) + 1) + '.png');

        subCategoryData['All'].push({
            label: c.name,
            img: cImg,
            type: 'category',
            val: c.name
        });

        subCategoryData[c.name] = [
            { label: 'All ' + c.name, img: cImg, type: 'all_sub', val: c.name },
            { label: 'Pure Silk', img: cImg, type: 'fabric', val: 'Pure Silk' },
            { label: 'Handloom', img: '/assets/images/product2.png', type: 'fabric', val: 'Handloom Korvai' },
            { label: 'Zari Weaves', img: '/assets/images/product3.png', type: 'fabric', val: 'Zari' },
            { label: 'Festive Drop', img: '/assets/images/product4.png', type: 'fabric', val: 'Festive' }
        ];
    });

    window.renderSubCategories = function(mainCat) {
        var track = document.getElementById('catSliderTrack');
        if (!track) return;

        var list = subCategoryData[mainCat] || subCategoryData['All'];
        track.innerHTML = list.map(function(item, idx) {
            var isAct = idx === 0;
            var circleContent = '';
            if (item.img) {
                circleContent = '<img src="' + item.img + '" alt="' + item.label + '" loading="lazy" onerror="this.src=\'/assets/images/product1.png\'" />';
            } else {
                circleContent = '<span class="cat-icon" aria-hidden="true">' + (item.icon || '●') + '</span>';
            }

            return '<button class="cat-item ' + (isAct ? 'active' : '') + '" role="listitem" data-type="' + (item.type || '') + '" data-val="' + (item.val || '') + '" aria-pressed="' + (isAct ? 'true' : 'false') + '" aria-label="' + item.label + '">' +
                '<div class="cat-ring">' +
                    '<div class="cat-circle ' + (item.gradient || '') + '">' + circleContent + '</div>' +
                '</div>' +
                '<span class="cat-label">' + item.label + '</span>' +
            '</button>';
        }).join('');

        // Bind clicks on new round sub-category items
        track.querySelectorAll('.cat-item').forEach(function(btn) {
            btn.addEventListener('click', function() {
                track.querySelectorAll('.cat-item').forEach(function(b) { b.classList.remove('active'); b.setAttribute('aria-pressed','false'); });
                btn.classList.add('active'); btn.setAttribute('aria-pressed','true');
                btn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });

                var type = btn.dataset.type;
                var val  = btn.dataset.val;
                var st   = window.masterFilterState;

                if (type === 'fabric') {
                    st.fabrics = [val];
                } else if (type === 'category') {
                    st.category = val;
                    st.fabrics = [];
                } else {
                    st.fabrics = [];
                }

                window.applyMasterFilters();
                if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
            });
        });
    };

    /* Category Slider Mouse Drag on Desktop */
    function enableDragScroll(selector) {
        var tr = document.querySelector(selector);
        if (!tr) return;
        var isDown = false, startX, scrollLeft;
        tr.style.cursor = 'grab';
        tr.addEventListener('mousedown', function(e) {
            isDown = true;
            tr.style.cursor = 'grabbing';
            startX = e.pageX - tr.offsetLeft;
            scrollLeft = tr.scrollLeft;
        });
        window.addEventListener('mouseup', function() {
            isDown = false;
            if (tr) tr.style.cursor = 'grab';
        });
        tr.addEventListener('mousemove', function(e) {
            if (!isDown) return;
            e.preventDefault();
            var x = e.pageX - tr.offsetLeft;
            var walk = (x - startX) * 1.5;
            tr.scrollLeft = scrollLeft - walk;
        });
    }
    enableDragScroll('.cat-slider-track');
    enableDragScroll('.main-cat-slider-track');

    window.applyMasterFilters = function() {
        var st = window.masterFilterState;
        var total = 0;

        cardElems.forEach(function(card) {
            var catMatch = (st.category === 'All' || st.category === 'New Arrivals' || card.dataset.category === st.category);
            
            var price = parseInt(card.dataset.price);
            var priceMatch = (price >= st.minPrice && price <= st.maxPrice);

            var colorMatch = true;
            if (st.colors.length > 0) {
                colorMatch = st.colors.indexOf(card.dataset.color) !== -1;
            }

            var sizeMatch = true;
            if (st.sizes.length > 0) {
                var cardSizes = card.dataset.size ? card.dataset.size.split(',') : [];
                sizeMatch = st.sizes.some(function(s){ return cardSizes.indexOf(s) !== -1; });
            }

            var fabricMatch = true;
            if (st.fabrics.length > 0) {
                fabricMatch = st.fabrics.indexOf(card.dataset.fabric) !== -1;
            }

            var discount = parseInt(card.dataset.discount || '0');
            var discountMatch = (discount >= st.minDiscount);

            var stockMatch = true;
            if (st.availability.length > 0) {
                stockMatch = st.availability.indexOf(card.dataset.stock) !== -1;
            }

            var searchMatch = true;
            if (st.searchQuery && st.searchQuery.length > 0) {
                var q = st.searchQuery.toLowerCase();
                var cardName = (card.querySelector('.card-title') ? card.querySelector('.card-title').textContent : '').toLowerCase();
                var cardCat = (card.dataset.category || '').toLowerCase();
                var cardFabric = (card.dataset.fabric || '').toLowerCase();
                var cardColor = (card.dataset.color || '').toLowerCase();
                searchMatch = cardName.indexOf(q) !== -1 || cardCat.indexOf(q) !== -1 || cardFabric.indexOf(q) !== -1 || cardColor.indexOf(q) !== -1;
            }

            var isMatch = catMatch && priceMatch && colorMatch && sizeMatch && fabricMatch && discountMatch && stockMatch && searchMatch;

            if (isMatch) {
                card.style.display = '';
                total++;
            } else {
                card.style.display = 'none';
            }
        });

        // Handle sorting if cards are visible
        if (st.sortBy) {
            var grid = document.getElementById('productsGrid');
            var sortedCards = Array.from(cardElems);
            sortedCards.sort(function(a, b) {
                var pA = parseInt(a.dataset.price), pB = parseInt(b.dataset.price);
                var dA = parseInt(a.dataset.discount||'0'), dB = parseInt(b.dataset.discount||'0');
                if (st.sortBy === 'price_asc') return pA - pB;
                if (st.sortBy === 'price_desc') return pB - pA;
                if (st.sortBy === 'discount') return dB - dA;
                return parseInt(a.dataset.productId) - parseInt(b.dataset.productId);
            });
            sortedCards.forEach(function(c){ grid.appendChild(c); });
        }

        // Show/Hide Empty State
        var noMsg = document.getElementById('noProductsMsg');
        if (noMsg) noMsg.style.display = (total === 0) ? 'block' : 'none';

        // Update product count label
        var ptbCount = document.getElementById('ptbCount');
        if (ptbCount) ptbCount.textContent = 'Showing ' + total + ' of ' + products.length + ' Products';

        // Sync Mobile Apply button text if exists
        var mfApplyBtn = document.getElementById('mfApplyBtn');
        if (mfApplyBtn) mfApplyBtn.textContent = 'Apply Filters (' + total + ')';

        // Render Active Filter Tags
        renderActiveTags();

        // Sync Desktop Sidebar badges
        syncSidebarUI();
    };

    function renderActiveTags() {
        var bar = document.getElementById('activeFilterBar');
        var wrap = document.getElementById('activeFilterTagsWrap');
        if (!bar || !wrap) return;

        var st = window.masterFilterState;
        var tags = [];

        if (st.category !== 'All') {
            tags.push({ label: st.category, type: 'category', val: st.category });
        }
        if (st.minPrice > 500 || st.maxPrice < 30000) {
            tags.push({ label: '₹' + st.minPrice.toLocaleString() + ' - ₹' + st.maxPrice.toLocaleString(), type: 'price' });
        }
        st.colors.forEach(function(c){ tags.push({ label: c, type: 'color', val: c }); });
        st.sizes.forEach(function(s){ tags.push({ label: 'Size: ' + s, type: 'size', val: s }); });
        st.fabrics.forEach(function(f){ tags.push({ label: f, type: 'fabric', val: f }); });
        if (st.minDiscount > 0) {
            tags.push({ label: st.minDiscount + '%+ Off', type: 'discount' });
        }
        st.availability.forEach(function(a){ tags.push({ label: a, type: 'availability', val: a }); });

        if (tags.length > 0) {
            bar.classList.add('has-tags');
            wrap.innerHTML = tags.map(function(t) {
                return '<span class="active-filter-tag">' + t.label + 
                       ' <button onclick="removeFilterTag(\'' + t.type + '\', \'' + (t.val || '') + '\')" aria-label="Remove filter">✕</button></span>';
            }).join('');
        } else {
            bar.classList.remove('has-tags');
            wrap.innerHTML = '';
        }
    }

    window.removeFilterTag = function(type, val) {
        var st = window.masterFilterState;
        if (type === 'category') {
            st.category = 'All';
            catItems.forEach(function(ci){ ci.classList.toggle('active', ci.dataset.category === 'All'); });
        } else if (type === 'price') {
            st.minPrice = 500; st.maxPrice = 30000;
            var sfMin = document.getElementById('sfPriceMin'), sfMax = document.getElementById('sfPriceMax');
            if (sfMin) { sfMin.value = 500; sfMax.value = 30000; }
        } else if (type === 'color') {
            st.colors = st.colors.filter(function(x){ return x !== val; });
        } else if (type === 'size') {
            st.sizes = st.sizes.filter(function(x){ return x !== val; });
        } else if (type === 'fabric') {
            st.fabrics = st.fabrics.filter(function(x){ return x !== val; });
        } else if (type === 'discount') {
            st.minDiscount = 0;
        } else if (type === 'availability') {
            st.availability = st.availability.filter(function(x){ return x !== val; });
        }
        window.applyMasterFilters();
        if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
    };

    function syncSidebarUI() {
        var st = window.masterFilterState;
        
        // Active total count badge
        var totalActive = (st.category !== 'All' ? 1 : 0) + st.colors.length + st.sizes.length + st.fabrics.length + (st.minDiscount > 0 ? 1 : 0) + st.availability.length + ((st.minPrice > 500 || st.maxPrice < 30000) ? 1 : 0);
        var mainBadge = document.getElementById('sfActiveBadge');
        if (mainBadge) {
            mainBadge.style.display = totalActive > 0 ? 'inline-flex' : 'none';
            mainBadge.textContent = totalActive;
        }

        // Section Badges
        updateSecBadge('sec-category', 'badge-category', st.category !== 'All', st.category);
        updateSecBadge('sec-price', 'badge-price', st.minPrice > 500 || st.maxPrice < 30000, 'Custom');
        updateSecBadge('sec-color', 'badge-color', st.colors.length > 0, st.colors.length);
        updateSecBadge('sec-size', 'badge-size', st.sizes.length > 0, st.sizes.length);
        updateSecBadge('sec-fabric', 'badge-fabric', st.fabrics.length > 0, st.fabrics.length);
        updateSecBadge('sec-discount', 'badge-discount', st.minDiscount > 0, st.minDiscount + '%+');
        updateSecBadge('sec-availability', 'badge-availability', st.availability.length > 0, st.availability.length);

        // Sidebar Chips state
        document.querySelectorAll('.sf-chip').forEach(function(chip) {
            var type = chip.dataset.sfType;
            var val  = chip.dataset.sfVal;
            var isActive = false;
            if (type === 'category') isActive = (st.category === val);
            if (type === 'size') isActive = st.sizes.indexOf(val) !== -1;
            if (type === 'fabric') isActive = st.fabrics.indexOf(val) !== -1;
            if (type === 'discount') isActive = (st.minDiscount === parseInt(val));
            if (type === 'availability') isActive = st.availability.indexOf(val) !== -1;
            chip.classList.toggle('active', isActive);
            chip.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        });

        // Sidebar Swatches state
        document.querySelectorAll('.sf-swatch-wrapper').forEach(function(sw) {
            var val = sw.dataset.sfVal;
            var isActive = st.colors.indexOf(val) !== -1;
            sw.classList.toggle('active', isActive);
        });
    }

    function updateSecBadge(secId, badgeId, hasActive, text) {
        var sec = document.getElementById(secId);
        var badge = document.getElementById(badgeId);
        if (sec && badge) {
            sec.classList.toggle('has-active', hasActive);
            badge.textContent = text;
        }
    }

    /* Main Category Tabs click */
    document.querySelectorAll('.main-cat-tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.main-cat-tab').forEach(function(t){ t.classList.remove('active'); t.setAttribute('aria-selected','false'); });
            tab.classList.add('active'); tab.setAttribute('aria-selected','true');
            tab.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });

            var cat = tab.dataset.cat;
            window.masterFilterState.category = cat;
            window.masterFilterState.fabrics = []; // reset sub-filter on main category switch
            window.renderSubCategories(cat);
            window.applyMasterFilters();
            if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
        });
    });

    /* Desktop Sidebar Accordion Toggles */
    document.querySelectorAll('.sf-section-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var sec = btn.closest('.sf-section');
            sec.classList.toggle('open');
            btn.setAttribute('aria-expanded', sec.classList.contains('open') ? 'true' : 'false');
        });
    });

    /* Desktop Sidebar Chip clicks */
    document.querySelectorAll('.sf-chip').forEach(function(chip) {
        chip.addEventListener('click', function() {
            var type = chip.dataset.sfType;
            var val  = chip.dataset.sfVal;
            var st   = window.masterFilterState;

            if (type === 'category') {
                st.category = val;
                st.fabrics = [];
                document.querySelectorAll('.main-cat-tab').forEach(function(t){
                    t.classList.toggle('active', t.dataset.cat === val);
                });
                window.renderSubCategories(val);
            } else if (type === 'size') {
                var idx = st.sizes.indexOf(val);
                if (idx === -1) st.sizes.push(val); else st.sizes.splice(idx, 1);
            } else if (type === 'fabric') {
                var idx = st.fabrics.indexOf(val);
                if (idx === -1) st.fabrics.push(val); else st.fabrics.splice(idx, 1);
            } else if (type === 'discount') {
                var dVal = parseInt(val);
                st.minDiscount = (st.minDiscount === dVal) ? 0 : dVal;
            } else if (type === 'availability') {
                var idx = st.availability.indexOf(val);
                if (idx === -1) st.availability.push(val); else st.availability.splice(idx, 1);
            }

            window.applyMasterFilters();
            if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
        });
    });

    /* Desktop Sidebar Swatches clicks */
    document.querySelectorAll('.sf-swatch-wrapper').forEach(function(sw) {
        sw.addEventListener('click', function() {
            var val = sw.dataset.sfVal;
            var st  = window.masterFilterState;
            var idx = st.colors.indexOf(val);
            if (idx === -1) st.colors.push(val); else st.colors.splice(idx, 1);
            
            window.applyMasterFilters();
            if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
        });
    });

    /* Desktop Sidebar Price Range Sliders */
    var sfMin  = document.getElementById('sfPriceMin');
    var sfMax  = document.getElementById('sfPriceMax');
    var sfMinL = document.getElementById('sfPriceMinLabel');
    var sfMaxL = document.getElementById('sfPriceMaxLabel');
    var sfFill = document.getElementById('sfRangeFill');

    function updateSfRange() {
        if (!sfMin || !sfMax) return;
        var mn = parseInt(sfMin.value), mx = parseInt(sfMax.value);
        var lo = parseInt(sfMin.min),   hi = parseInt(sfMin.max);

        if (mn > mx - 500) {
            if (this === sfMin) mn = mx - 500; else mx = mn + 500;
            sfMin.value = mn; sfMax.value = mx;
        }

        sfFill.style.left  = ((mn - lo) / (hi - lo) * 100) + '%';
        sfFill.style.right = (100 - (mx - lo) / (hi - lo) * 100) + '%';
        sfMinL.textContent = '₹' + mn.toLocaleString('en-IN');
        sfMaxL.textContent = '₹' + mx.toLocaleString('en-IN');

        window.masterFilterState.minPrice = mn;
        window.masterFilterState.maxPrice = mx;

        // Sync preset chips
        document.querySelectorAll('.price-preset-chip').forEach(function(chip) {
            var cMin = parseInt(chip.dataset.min), cMax = parseInt(chip.dataset.max);
            var isMatch = (mn === cMin && mx === cMax);
            chip.classList.toggle('active', isMatch);
        });

        window.applyMasterFilters();
        if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
    }

    if (sfMin) {
        sfMin.addEventListener('input', updateSfRange);
        sfMax.addEventListener('input', updateSfRange);
    }

    /* Price Preset Chips click */
    document.querySelectorAll('.price-preset-chip').forEach(function(chip) {
        chip.addEventListener('click', function() {
            var cMin = parseInt(chip.dataset.min), cMax = parseInt(chip.dataset.max);
            if (sfMin && sfMax) {
                sfMin.value = cMin;
                sfMax.value = cMax;
                updateSfRange.call(sfMin);
            }
        });
    });

    /* Desktop Clear All */
    var sfClearAll = document.getElementById('sfClearAll');
    if (sfClearAll) {
        sfClearAll.addEventListener('click', function() {
            resetMasterFilters();
        });
    }

    /* Reset Button in Empty State */
    var npResetBtn = document.getElementById('npResetBtn');
    if (npResetBtn) {
        npResetBtn.addEventListener('click', function() {
            resetMasterFilters();
        });
    }

    function resetMasterFilters() {
        window.masterFilterState = {
            category: 'All',
            colors: [],
            sizes: [],
            fabrics: [],
            minPrice: 500,
            maxPrice: 30000,
            minDiscount: 0,
            availability: [],
            sortBy: 'recommended'
        };
        if (sfMin) { sfMin.value = 500; sfMax.value = 30000; updateSfRange.call(sfMin); }
        document.querySelectorAll('.main-cat-tab').forEach(function(t){ t.classList.toggle('active', t.dataset.cat === 'All'); });
        window.renderSubCategories('All');
        window.applyMasterFilters();
        if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
        showToast('All filters cleared');
    }

    /* Top Sort Selection */
    var ptbSort = document.getElementById('ptbSortSelect');
    if (ptbSort) {
        ptbSort.addEventListener('change', function() {
            window.masterFilterState.sortBy = ptbSort.value;
            window.applyMasterFilters();
        });
    }

    /* Wishlist toggle & Quick View from Grid Cards */
    var pGrid = document.getElementById('productsGrid');
    if (pGrid) {
        pGrid.addEventListener('click', function (e) {
            var wishBtn = e.target.closest('.card-wishlist-btn');
            if (wishBtn) {
                e.stopPropagation();
                e.preventDefault();
                var id = wishBtn.dataset.id;
                var p = products.find(function(x){ return x.id == id; });
                if (p && typeof window.toggleWishlistProduct === 'function') {
                    var added = window.toggleWishlistProduct(p);
                    wishBtn.classList.toggle('active', added);
                    wishBtn.setAttribute('aria-pressed', added ? 'true' : 'false');
                    if (typeof showToast === 'function') showToast(added ? '♡ Saved ' + p.name + ' to wishlist' : 'Removed from wishlist');
                }
                return;
            }

            var qvBtn = e.target.closest('.quick-view-btn, .card-mobile-qv-btn');
            if (qvBtn) {
                e.stopPropagation();
                e.preventDefault();
                var id = qvBtn.dataset.id;
                if (typeof window.openQV === 'function') {
                    window.openQV(id);
                }
                return;
            }
        });
    }

    /* Universal Header and Drawer Open/Close Listeners */
    document.addEventListener('click', function(e) {
        var cartTarget = e.target.closest('#cartBtn, #moreCartAction');
        if (cartTarget) {
            e.preventDefault();
            if (typeof window.openCartDrawer === 'function') window.openCartDrawer();
            return;
        }

        var wishTarget = e.target.closest('#wishlistBtn, #moreWishlistAction');
        if (wishTarget) {
            e.preventDefault();
            if (typeof window.openWishlistDrawer === 'function') window.openWishlistDrawer();
            return;
        }

        var closeCart = e.target.closest('#closeCartDrawerBtn');
        if (closeCart) {
            e.preventDefault();
            if (typeof window.closeCartDrawer === 'function') window.closeCartDrawer();
            return;
        }

        var closeWish = e.target.closest('#closeWishlistDrawerBtn');
        if (closeWish) {
            e.preventDefault();
            if (typeof window.closeWishlistDrawer === 'function') window.closeWishlistDrawer();
            return;
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (typeof window.closeCartDrawer === 'function') window.closeCartDrawer();
            if (typeof window.closeWishlistDrawer === 'function') window.closeWishlistDrawer();
            if (typeof window.closeQV === 'function') window.closeQV();
            if (typeof window.closeProductDetails === 'function') window.closeProductDetails();
            if (typeof window.closeReelsModal === 'function') window.closeReelsModal();
        }
    });

    /* ── Hero Banner Slider Controller ── */
    var bannerTrack = document.getElementById('heroBannerTrack');
    var bannerDots = document.querySelectorAll('.hero-banner-dot');
    var bannerCurrent = 0;
    var bannerTotal = 3;
    var bannerTimer = null;

    function goToBanner(idx) {
        if (!bannerTrack) return;
        bannerCurrent = (idx + bannerTotal) % bannerTotal;
        bannerTrack.style.transform = 'translateX(-' + (bannerCurrent * 100) + '%)';
        bannerDots.forEach(function(dot, dIdx) {
            dot.classList.toggle('active', dIdx === bannerCurrent);
        });
    }

    function startBannerAutoplay() {
        stopBannerAutoplay();
        bannerTimer = setInterval(function() {
            goToBanner(bannerCurrent + 1);
        }, 4500);
    }

    function stopBannerAutoplay() {
        if (bannerTimer) clearInterval(bannerTimer);
    }

    var prevBannerBtn = document.getElementById('heroBannerPrevBtn');
    var nextBannerBtn = document.getElementById('heroBannerNextBtn');
    if (prevBannerBtn) prevBannerBtn.addEventListener('click', function(e) { e.stopPropagation(); goToBanner(bannerCurrent - 1); startBannerAutoplay(); });
    if (nextBannerBtn) nextBannerBtn.addEventListener('click', function(e) { e.stopPropagation(); goToBanner(bannerCurrent + 1); startBannerAutoplay(); });

    bannerDots.forEach(function(dot) {
        dot.addEventListener('click', function(e) {
            e.stopPropagation();
            var s = parseInt(dot.dataset.slide);
            goToBanner(s);
            startBannerAutoplay();
        });
    });

    var bannerContainer = document.getElementById('heroBannerContainer');
    if (bannerContainer) {
        bannerContainer.addEventListener('mouseenter', stopBannerAutoplay);
        bannerContainer.addEventListener('mouseleave', startBannerAutoplay);
        startBannerAutoplay();
    }

    /* Mobile Touch Swipe for Banner */
    if (bannerTrack) {
        var touchStartX = 0, touchEndX = 0;
        bannerTrack.addEventListener('touchstart', function(e) {
            touchStartX = e.changedTouches[0].screenX;
            stopBannerAutoplay();
        }, { passive: true });

        bannerTrack.addEventListener('touchend', function(e) {
            touchEndX = e.changedTouches[0].screenX;
            var diff = touchStartX - touchEndX;
            if (Math.abs(diff) > 40) {
                if (diff > 0) goToBanner(bannerCurrent + 1);
                else goToBanner(bannerCurrent - 1);
            }
            startBannerAutoplay();
        }, { passive: true });
    }

    window.filterByBanner = function(catName) {
        var st = window.masterFilterState;
        st.category = catName;
        st.fabrics = [];
        document.querySelectorAll('.main-cat-tab').forEach(function(t){
            t.classList.toggle('active', t.dataset.cat === catName);
        });
        window.renderSubCategories(catName);
        window.applyMasterFilters();
        if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
    };

    /* ═════════════════════════════════════════════════════════════════
       HOME PAGE 31-SECTION CONTROLLERS
    ═════════════════════════════════════════════════════════════════ */

    /* 1. Category Navigation Filter & Smooth Scroll */
    window.filterHomeCategory = function(catName) {
        var pills = document.querySelectorAll('.home-cat-pill');
        pills.forEach(function(p) {
            var text = p.textContent.trim();
            if (catName === 'All' && text.indexOf('All') !== -1) {
                p.classList.add('active');
            } else if (text.indexOf(catName) !== -1) {
                p.classList.add('active');
            } else {
                p.classList.remove('active');
            }
        });

        var st = window.masterFilterState;
        if (st) {
            st.category = catName;
            window.applyMasterFilters();
        }

        var trendSec = document.getElementById('section-trending');
        if (trendSec) {
            trendSec.scrollIntoView({ behavior: 'smooth' });
        }

        if (typeof showToast === 'function') {
            showToast('Showing category: ' + catName, 'filter');
        }
    };

    /* 2. Sort Change Handler */
    window.handleSortChange = function(val) {
        if (window.masterFilterState) {
            window.masterFilterState.sortBy = val;
            window.applyMasterFilters();
        }
    };

    /* 3. Review Tabs Switcher */
    window.switchReviewTab = function(tabKey) {
        var btns = document.querySelectorAll('.rev-tab-btn');
        btns.forEach(function(btn) {
            btn.classList.toggle('active', btn.getAttribute('onclick').indexOf(tabKey) !== -1);
        });

        var tabCustomers = document.getElementById('tab-reviews-customers');
        var tabResellers = document.getElementById('tab-reviews-resellers');
        var tabWholesale = document.getElementById('tab-reviews-wholesale');

        if (tabCustomers) tabCustomers.style.display = tabKey === 'customers' ? 'block' : 'none';
        if (tabResellers) tabResellers.style.display = tabKey === 'resellers' ? 'block' : 'none';
        if (tabWholesale) tabWholesale.style.display = tabKey === 'wholesale' ? 'block' : 'none';
    };

    /* 4. Deal of the Day Live Countdown Timer */
    function startDealCountdown() {
        var cdHours = document.getElementById('cdHours');
        var cdMins  = document.getElementById('cdMins');
        var cdSecs  = document.getElementById('cdSecs');
        if (!cdHours || !cdMins || !cdSecs) return;

        function updateTimer() {
            var now = new Date();
            var midnight = new Date();
            midnight.setHours(23, 59, 59, 999);
            var diff = midnight.getTime() - now.getTime();

            if (diff <= 0) {
                diff = 24 * 60 * 60 * 1000;
            }

            var h = Math.floor(diff / (1000 * 60 * 60));
            var m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            var s = Math.floor((diff % (1000 * 60)) / 1000);

            cdHours.textContent = h < 10 ? '0' + h : h;
            cdMins.textContent  = m < 10 ? '0' + m : m;
            cdSecs.textContent  = s < 10 ? '0' + s : s;
        }

        updateTimer();
        setInterval(updateTimer, 1000);
    }
    startDealCountdown();

    /* 5. Recently Viewed Tracking System */
    var DEFAULT_RECENT_PRODUCTS = [
        { id: 1, name: 'Nilambari Pure Silk Paithani Saree', price: 3499, old_price: 5999, discount: '42% OFF', image: '/assets/images/product1.png', category: 'PAITHANI SAREE' },
        { id: 2, name: 'Banarasi Zari Royal Heritage Saree', price: 4299, old_price: 6999, discount: '38% OFF', image: '/assets/images/product2.png', category: 'BANARASI SILK' },
        { id: 3, name: 'Surat Designer Embroidered Anarkali', price: 2899, old_price: 4999, discount: '42% OFF', image: '/assets/images/product3.png', category: 'KURTIS & SUITS' },
        { id: 4, name: 'Bridal Velvet Heavy Zardozi Lehenga', price: 7999, old_price: 13999, discount: '43% OFF', image: '/assets/images/product4.png', category: 'BRIDAL LEHENGA' },
        { id: 5, name: 'Kanjeevaram Gold Zari Temple Saree', price: 4899, old_price: 8499, discount: '42% OFF', image: '/assets/images/product5.png', category: 'KANJEEVARAM' },
        { id: 6, name: 'Chanderi Handloom Floral Festive Saree', price: 2199, old_price: 3799, discount: '42% OFF', image: '/assets/images/product6.png', category: 'CHANDERI SILK' },
        { id: 7, name: 'Organza Pastel Mirror Work Saree', price: 2599, old_price: 4499, discount: '42% OFF', image: '/assets/images/product7.png', category: 'ORGANZA SILK' },
        { id: 8, name: 'Georgette Sequence Partywear Saree', price: 1999, old_price: 3499, discount: '43% OFF', image: '/assets/images/product8.png', category: 'GEORGETTE' }
    ];

    window.trackRecentlyViewed = function(productId) {
        var p = (window.allProducts || []).find(function(x) { return Number(x.id) === Number(productId); });
        if (!p) {
            p = DEFAULT_RECENT_PRODUCTS.find(function(x) { return Number(x.id) === Number(productId); });
        }
        if (!p) return;

        try {
            var stored = JSON.parse(localStorage.getItem('dtbrands_recently_viewed') || '[]');
            stored = stored.filter(function(x) { return Number(x.id) !== Number(p.id); });
            stored.unshift({
                id: p.id,
                name: p.name,
                price: p.price,
                old_price: p.old_price || Math.round(Number(p.price) * 1.5),
                discount: p.discount || '40% OFF',
                image: p.image,
                category: (p.category || 'ETHNIC WEAR').toUpperCase()
            });
            if (stored.length > 12) stored = stored.slice(0, 12);
            localStorage.setItem('dtbrands_recently_viewed', JSON.stringify(stored));
            renderRecentlyViewed();
        } catch (e) {}
    };

    function renderRecentlyViewed() {
        var sec = document.getElementById('section-recently-viewed');
        var track = document.getElementById('recentlyViewedTrack');
        if (!sec || !track) return;

        try {
            var items = JSON.parse(localStorage.getItem('dtbrands_recently_viewed') || 'null');
            // If empty, seed with curated 6 default trending products for immediate rich view
            if (!items || items.length === 0) {
                items = DEFAULT_RECENT_PRODUCTS.slice(0, 6);
                localStorage.setItem('dtbrands_recently_viewed', JSON.stringify(items));
            }

            sec.style.display = 'block';
            track.innerHTML = items.map(function(item) {
                var disc = item.discount || '40% OFF';
                var oldP = item.old_price ? ('₹' + Number(item.old_price).toLocaleString('en-IN')) : '';
                return '<div class="recently-viewed-card" data-product-id="' + item.id + '">' +
                    '<div class="rv-img-box">' +
                        '<a href="/product.php?id=' + item.id + '" class="rv-img-link">' +
                            '<img src="' + item.image + '" alt="' + item.name + '" class="rv-card-img" loading="lazy" />' +
                        '</a>' +
                        '<span class="rv-discount-badge">' + disc + '</span>' +
                        '<button type="button" class="rv-quick-view-btn" onclick="if(typeof window.openQuickView===\'function\'){window.openQuickView(' + item.id + ');}else{window.location.href=\'/product.php?id=' + item.id + '\';}" aria-label="Quick View">' +
                            '<svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>' +
                        '</button>' +
                    '</div>' +
                    '<div class="rv-card-body">' +
                        '<span class="rv-card-cat">' + (item.category || 'SAREES') + '</span>' +
                        '<h4 class="rv-card-title">' +
                            '<a href="/product.php?id=' + item.id + '">' + item.name + '</a>' +
                        '</h4>' +
                        '<div class="rv-price-wrap">' +
                            '<span class="rv-price-curr">₹' + Number(item.price).toLocaleString('en-IN') + '</span>' +
                            (oldP ? '<span class="rv-price-old">' + oldP + '</span>' : '') +
                        '</div>' +
                        '<button type="button" class="rv-add-btn" onclick="directAddToCart(' + item.id + '); event.stopPropagation();">' +
                            '<svg viewBox="0 0 24 24" style="width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2.2;"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>' +
                            '<span>Add</span>' +
                        '</button>' +
                    '</div>' +
                '</div>';
            }).join('');

            syncRvScrollbar();
        } catch (e) {}
    }

    window.slideRecentlyViewed = function(dir) {
        var track = document.getElementById('recentlyViewedTrack');
        if (!track) return;
        var step = track.clientWidth * 0.75;
        track.scrollBy({ left: dir * step, behavior: 'smooth' });
    };

    function syncRvScrollbar() {
        var track = document.getElementById('recentlyViewedTrack');
        var thumb = document.getElementById('rvScrollbarThumb');
        var scrollbar = document.getElementById('rvScrollbarTrack');
        if (!track || !thumb || !scrollbar) return;

        var scrollWidth = track.scrollWidth - track.clientWidth;
        if (scrollWidth <= 5) {
            scrollbar.style.display = 'none';
            return;
        }
        scrollbar.style.display = 'block';

        var percent = track.scrollLeft / scrollWidth;
        var thumbWidth = Math.max(24, (track.clientWidth / track.scrollWidth) * scrollbar.clientWidth);
        var maxMove = scrollbar.clientWidth - thumbWidth;
        thumb.style.width = thumbWidth + 'px';
        thumb.style.transform = 'translateX(' + (percent * maxMove) + 'px)';
    }

    var rvTrackEl = document.getElementById('recentlyViewedTrack');
    if (rvTrackEl) {
        rvTrackEl.addEventListener('scroll', syncRvScrollbar, { passive: true });
    }

    window.clearRecentlyViewed = function() {
        localStorage.removeItem('dtbrands_recently_viewed');
        var sec = document.getElementById('section-recently-viewed');
        if (sec) sec.style.display = 'none';
        if (typeof showToast === 'function') showToast('Recently viewed history cleared');
    };

    renderRecentlyViewed();

    /* Track clicks on product cards */
    document.addEventListener('click', function(e) {
        var card = e.target.closest('.product-card, .home-reseller-card, .home-ws-card, .recently-viewed-card, .rec-card');
        if (card && card.dataset.productId) {
            window.trackRecentlyViewed(card.dataset.productId);
        }
    });

    /* ═════════════════════════════════════════════════════════════════════
       SECTION 20: RECOMMENDED FOR YOU (2-LINE HORIZONTAL SCROLL)
    ═════════════════════════════════════════════════════════════════════ */
    var recTrack = document.getElementById('recommendedGrid');
    var recThumb = document.getElementById('recScrollbarThumb');
    var recScrollbar = document.getElementById('recScrollbarTrack');

    function syncRecScrollbar() {
        if (!recTrack || !recThumb || !recScrollbar) return;
        var maxScroll = recTrack.scrollWidth - recTrack.clientWidth;
        if (maxScroll <= 5) {
            recScrollbar.style.display = 'none';
            return;
        }
        recScrollbar.style.display = 'block';

        var percent = recTrack.scrollLeft / maxScroll;
        var thumbWidth = Math.max(28, (recTrack.clientWidth / recTrack.scrollWidth) * recScrollbar.clientWidth);
        var maxMove = recScrollbar.clientWidth - thumbWidth;
        recThumb.style.width = thumbWidth + 'px';
        recThumb.style.transform = 'translateX(' + (percent * maxMove) + 'px)';
    }

    if (recTrack) {
        recTrack.addEventListener('scroll', syncRecScrollbar, { passive: true });
        syncRecScrollbar();
    }

    window.slideRecommended = function(direction) {
        if (!recTrack) return;
        var step = recTrack.clientWidth * 0.75;
        recTrack.scrollBy({ left: direction * step, behavior: 'smooth' });
    };

    window.filterRecommendedCategory = function(cat, btn) {
        // Update active filter pill
        var pills = document.querySelectorAll('.rec-filter-pill');
        pills.forEach(function(p) { p.classList.remove('active'); });
        if (btn) btn.classList.add('active');

        // Filter cards
        var cards = document.querySelectorAll('#recommendedGrid .rec-card');
        var selectedCat = (cat || 'All').toLowerCase();
        cards.forEach(function(card) {
            var itemCat = (card.getAttribute('data-category') || '').toLowerCase();
            if (selectedCat === 'all' || itemCat.indexOf(selectedCat) !== -1 || selectedCat.indexOf(itemCat) !== -1) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });

        if (recTrack) {
            recTrack.scrollTo({ left: 0, behavior: 'smooth' });
            setTimeout(syncRecScrollbar, 200);
        }
    };

    /* ═════════════════════════════════════════════════════════════════════
       SMART SHOP BY CATEGORY CAROUSEL RAIL & FILTER CONTROLLER
    ═════════════════════════════════════════════════════════════════════ */
    var catTrack = document.getElementById('homeCatScrollTrack');
    var catPrevBtn = document.getElementById('catScrollPrevBtn');
    var catNextBtn = document.getElementById('catScrollNextBtn');
    var catThumb = document.getElementById('homeCatScrollbarThumb');

    function syncCatScrollState() {
        if (!catTrack) return;
        var scrollLeft = catTrack.scrollLeft;
        var maxScroll = catTrack.scrollWidth - catTrack.clientWidth;

        if (catPrevBtn) {
            catPrevBtn.disabled = (scrollLeft <= 5);
        }
        if (catNextBtn) {
            catNextBtn.disabled = (scrollLeft >= maxScroll - 5);
        }

        if (catThumb && maxScroll > 0) {
            var progress = (scrollLeft / maxScroll) * 100;
            catThumb.style.transform = 'translateX(' + (progress * 3) + '%)';
        }
    }

    window.scrollCatRail = function(direction) {
        if (!catTrack) return;
        var scrollAmount = Math.max(220, Math.floor(catTrack.clientWidth * 0.7));
        catTrack.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    };

    if (catTrack) {
        catTrack.addEventListener('scroll', syncCatScrollState, { passive: true });
        setTimeout(syncCatScrollState, 150);
        window.addEventListener('resize', syncCatScrollState, { passive: true });
    }

    /* Smart Category Click Filter Bridge */
    window.filterHomeCategory = function(catName) {
        if (!catName) return;

        // Update master filter state
        window.masterFilterState.category = catName;
        window.masterFilterState.fabrics = [];

        // Sync header attached subnav tabs
        document.querySelectorAll('.main-cat-tab').forEach(function(t) {
            var isMatch = (t.dataset.cat === catName);
            t.classList.toggle('active', isMatch);
            t.setAttribute('aria-selected', isMatch ? 'true' : 'false');
            if (isMatch) {
                t.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        });

        // Sync top nav pills if present
        document.querySelectorAll('.home-cat-pill').forEach(function(pill) {
            var pillText = (pill.querySelector('span:last-child') ? pill.querySelector('span:last-child').textContent.trim() : '');
            var isPillMatch = (pillText === catName || (catName === 'All' && pillText === 'All Products'));
            pill.classList.toggle('active', isPillMatch);
        });

        // Highlight selected category card in rail
        document.querySelectorAll('.home-cat-card').forEach(function(card) {
            var nameEl = card.querySelector('.home-cat-card-name');
            var isCardMatch = nameEl && (nameEl.textContent.trim() === catName);
            card.classList.toggle('active-cat-selected', isCardMatch);
        });

        // Re-render sub-categories & apply filters to grid
        window.renderSubCategories(catName);
        window.applyMasterFilters();

        // Smoothly scroll down to the product showcase
        var trendingSec = document.getElementById('section-trending');
        if (trendingSec) {
            trendingSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        if (typeof window.showToast === 'function') {
            window.showToast('✨ Filtered to ' + catName + ' Collection', 'filter');
        }
    };

    /* ═════════════════════════════════════════════════════════════════════
       SMART TRENDING NOW 1-LINE HORIZONTAL RAIL CONTROLLER
    ═════════════════════════════════════════════════════════════════════ */
    var trendingTrack = document.getElementById('productsGrid');
    var trendingPrevBtn = document.getElementById('trendingScrollPrevBtn');
    var trendingNextBtn = document.getElementById('trendingScrollNextBtn');

    function syncTrendingScrollState() {
        if (!trendingTrack) return;
        var scrollLeft = trendingTrack.scrollLeft;
        var maxScroll = trendingTrack.scrollWidth - trendingTrack.clientWidth;

        if (trendingPrevBtn) {
            trendingPrevBtn.disabled = (scrollLeft <= 6);
        }
        if (trendingNextBtn) {
            trendingNextBtn.disabled = (scrollLeft >= maxScroll - 6);
        }
    }

    window.scrollTrendingRail = function(direction) {
        if (!trendingTrack) return;
        var scrollAmount = Math.max(260, Math.floor(trendingTrack.clientWidth * 0.75));
        trendingTrack.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    };

    if (trendingTrack) {
        trendingTrack.addEventListener('scroll', syncTrendingScrollState, { passive: true });
        setTimeout(syncTrendingScrollState, 200);
        window.addEventListener('resize', syncTrendingScrollState, { passive: true });
    }

    /* ═════════════════════════════════════════════════════════════════════
       SMART DEALS OF THE DAY 1-LINE HORIZONTAL RAIL CONTROLLER
    ═════════════════════════════════════════════════════════════════════ */
    var dealsTrack = document.getElementById('homeDealsGrid');
    var dealsPrevBtn = document.getElementById('dealScrollPrevBtn');
    var dealsNextBtn = document.getElementById('dealScrollNextBtn');

    function syncDealsScrollState() {
        if (!dealsTrack) return;
        var scrollLeft = dealsTrack.scrollLeft;
        var maxScroll = dealsTrack.scrollWidth - dealsTrack.clientWidth;

        if (dealsPrevBtn) {
            dealsPrevBtn.disabled = (scrollLeft <= 6);
        }
        if (dealsNextBtn) {
            dealsNextBtn.disabled = (scrollLeft >= maxScroll - 6);
        }
    }

    window.scrollDealsRail = function(direction) {
        if (!dealsTrack) return;
        var scrollAmount = Math.max(240, Math.floor(dealsTrack.clientWidth * 0.75));
        dealsTrack.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    };

    if (dealsTrack) {
        dealsTrack.addEventListener('scroll', syncDealsScrollState, { passive: true });
        setTimeout(syncDealsScrollState, 200);
        window.addEventListener('resize', syncDealsScrollState, { passive: true });
    }

    /* ═════════════════════════════════════════════════════════════════════
       VERIFIED BUYER FEEDBACK (1-LINE HORIZONTAL SCROLL & TABS)
    ═════════════════════════════════════════════════════════════════════ */
    window.switchReviewTab = function(tabKey, btnElement) {
        // Update Active Pill
        document.querySelectorAll('.rev-tab-pill').forEach(function(pill) {
            pill.classList.remove('active');
        });
        if (btnElement) {
            btnElement.classList.add('active');
        }

        // Hide all tracks and show selected track
        var targetId = 'tab-reviews-' + tabKey;
        document.querySelectorAll('.reviews-track').forEach(function(track) {
            if (track.id === targetId) {
                track.style.display = 'flex';
                track.classList.add('active');
                track.scrollLeft = 0;
            } else {
                track.style.display = 'none';
                track.classList.remove('active');
            }
        });

        window.syncReviewsScrollbar();
    };

    window.slideReviews = function(direction) {
        var activeTrack = document.querySelector('.reviews-track.active') || document.querySelector('.reviews-track');
        if (!activeTrack) return;
        var amount = Math.max(300, Math.floor(activeTrack.clientWidth * 0.75));
        var scrollDelta = (direction === 'left' ? -amount : amount);
        activeTrack.scrollBy({ left: scrollDelta, behavior: 'smooth' });
    };

    window.syncReviewsScrollbar = function() {
        var activeTrack = document.querySelector('.reviews-track.active') || document.querySelector('.reviews-track');
        var thumb = document.getElementById('revScrollbarThumb');
        if (!activeTrack || !thumb) return;

        var scrollLeft = activeTrack.scrollLeft;
        var maxScroll = activeTrack.scrollWidth - activeTrack.clientWidth;
        if (maxScroll <= 0) {
            thumb.style.width = '100%';
            thumb.style.transform = 'translateX(0%)';
            return;
        }

        var visibleRatio = Math.max(0.15, Math.min(1, activeTrack.clientWidth / activeTrack.scrollWidth));
        thumb.style.width = (visibleRatio * 100) + '%';
        var scrollPercent = scrollLeft / maxScroll;
        var maxTranslatePercent = (1 - visibleRatio) / visibleRatio * 100;
        thumb.style.transform = 'translateX(' + (scrollPercent * maxTranslatePercent) + '%)';
    };

    document.querySelectorAll('.reviews-track').forEach(function(track) {
        track.addEventListener('scroll', window.syncReviewsScrollbar, { passive: true });
    });
    /* ═════════════════════════════════════════════════════════════════════
       REAL PRODUCT VIDEOS (1-LINE HORIZONTAL RAIL CONTROLLER)
    ═════════════════════════════════════════════════════════════════════ */
    var reelsTrack = document.getElementById('homeReelsTrack');
    var reelsThumb = document.getElementById('reelsScrollbarThumb');

    window.scrollReelsRail = function(direction) {
        if (!reelsTrack) return;
        var scrollAmount = Math.max(220, Math.floor(reelsTrack.clientWidth * 0.75));
        reelsTrack.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    };

    window.syncReelsScrollbar = function() {
        if (!reelsTrack || !reelsThumb) return;
        var scrollLeft = reelsTrack.scrollLeft;
        var maxScroll = reelsTrack.scrollWidth - reelsTrack.clientWidth;
        if (maxScroll <= 0) {
            reelsThumb.style.width = '100%';
            reelsThumb.style.transform = 'translateX(0%)';
            return;
        }
        var visibleRatio = Math.max(0.15, Math.min(1, reelsTrack.clientWidth / reelsTrack.scrollWidth));
        reelsThumb.style.width = (visibleRatio * 100) + '%';
        var scrollPercent = scrollLeft / maxScroll;
        var maxTranslatePercent = (1 - visibleRatio) / visibleRatio * 100;
        reelsThumb.style.transform = 'translateX(' + (scrollPercent * maxTranslatePercent) + '%)';
    };

    if (reelsTrack) {
        reelsTrack.addEventListener('scroll', window.syncReelsScrollbar, { passive: true });
        setTimeout(window.syncReelsScrollbar, 250);
        window.addEventListener('resize', window.syncReelsScrollbar, { passive: true });
    }

    /* Initial Sub-Categories and Master Filter Execution */
    window.renderSubCategories('All');
    window.applyMasterFilters();

})();

