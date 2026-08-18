
(function () {
    'use strict';

    var products = window.shopProductsData || [];
    window.allProducts = products;

    /* Global Toast helper */
    window.showToast = function (msg) {
        var c = document.getElementById('toastContainer');
        var t = document.createElement('div');
        t.className = 'toast';
        t.textContent = msg;
        c.appendChild(t);
        requestAnimationFrame(function () {
            requestAnimationFrame(function () { t.classList.add('show'); });
        });
        setTimeout(function () {
            t.classList.remove('show');
            setTimeout(function () { t.remove(); }, 400);
        }, 2200);
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
                url: '../Single-Product/singleproduct.php?id=' + p.id
            };
            window.openSmartShareModal(itemData);
        } else if (p) {
            var waUrl = 'https://api.whatsapp.com/send?text=' + encodeURIComponent('Check out ' + p.name + ' at DT Brand\'s: ' + window.location.origin + '/../Single-Product/singleproduct.php?id=' + p.id);
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

    /* ── Sub-Category Data for Round Circles ── */
    var subCategoryData = {
        'All': [
            { label: 'All Items', icon: '✦', gradient: 'gradient-1', type: 'all' },
            { label: 'Banarasi', img: '/Frontend/Shop/Asset/images/product1.png', type: 'fabric', val: 'Pure Silk' },
            { label: 'Kanjeevaram', img: '/Frontend/Shop/Asset/images/product2.png', type: 'fabric', val: 'Art Silk' },
            { label: 'Chanderi', img: '/Frontend/Shop/Asset/images/product3.png', type: 'fabric', val: 'Cotton' },
            { label: 'Anarkali', img: '/Frontend/Shop/Asset/images/product5.png', type: 'category', val: 'Kurtis' },
            { label: 'Lehengas', img: '/Frontend/Shop/Asset/images/product6.png', type: 'category', val: 'Lehengas' },
            { label: 'Royal Gowns', img: '/Frontend/Shop/Asset/images/product8.png', type: 'category', val: 'Gowns' },
            { label: 'Straight Cut', img: '/Frontend/Shop/Asset/images/product7.png', type: 'fabric', val: 'Georgette' }
        ],
        'Sarees': [
            { label: 'All Sarees', img: '/Frontend/Shop/Asset/images/product1.png', type: 'all_sub' },
            { label: 'Banarasi Silk', img: '/Frontend/Shop/Asset/images/product1.png', type: 'fabric', val: 'Pure Silk' },
            { label: 'Kanjeevaram', img: '/Frontend/Shop/Asset/images/product2.png', type: 'fabric', val: 'Art Silk' },
            { label: 'Chanderi', img: '/Frontend/Shop/Asset/images/product3.png', type: 'fabric', val: 'Cotton' },
            { label: 'Organza', img: '/Frontend/Shop/Asset/images/product4.png', type: 'fabric', val: 'Organza' },
            { label: 'Georgette', img: '/Frontend/Shop/Asset/images/product1.png', type: 'fabric', val: 'Georgette' },
            { label: 'Silk Blend', img: '/Frontend/Shop/Asset/images/product2.png', type: 'fabric', val: 'Silk Blend' }
        ],
        'Kurtis': [
            { label: 'All Kurtis', img: '/Frontend/Shop/Asset/images/product5.png', type: 'all_sub' },
            { label: 'Anarkali Sets', img: '/Frontend/Shop/Asset/images/product5.png', type: 'fabric', val: 'Georgette' },
            { label: 'Straight Cut', img: '/Frontend/Shop/Asset/images/product7.png', type: 'fabric', val: 'Cotton' },
            { label: 'Silk Festive', img: '/Frontend/Shop/Asset/images/product5.png', type: 'fabric', val: 'Pure Silk' },
            { label: 'Chiffon Print', img: '/Frontend/Shop/Asset/images/product7.png', type: 'fabric', val: 'Chiffon' }
        ],
        'Gowns': [
            { label: 'All Gowns', img: '/Frontend/Shop/Asset/images/product8.png', type: 'all_sub' },
            { label: 'Indo-Western', img: '/Frontend/Shop/Asset/images/product8.png', type: 'fabric', val: 'Georgette' },
            { label: 'Party Wear', img: '/Frontend/Shop/Asset/images/product8.png', type: 'fabric', val: 'Silk Blend' },
            { label: 'Zardozi Work', img: '/Frontend/Shop/Asset/images/product8.png', type: 'fabric', val: 'Velvet' }
        ],
        'Lehengas': [
            { label: 'All Lehengas', img: '/Frontend/Shop/Asset/images/product6.png', type: 'all_sub' },
            { label: 'Bridal Velvet', img: '/Frontend/Shop/Asset/images/product6.png', type: 'fabric', val: 'Velvet' },
            { label: 'Silk Festive', img: '/Frontend/Shop/Asset/images/product6.png', type: 'fabric', val: 'Pure Silk' },
            { label: 'Georgette', img: '/Frontend/Shop/Asset/images/product6.png', type: 'fabric', val: 'Georgette' }
        ],
        'New Arrivals': [
            { label: '★ All New In', icon: '★', gradient: 'gradient-6', type: 'all_sub' },
            { label: 'Silk Sarees', img: '/Frontend/Shop/Asset/images/product1.png', type: 'category', val: 'Sarees' },
            { label: 'Bridal Sets', img: '/Frontend/Shop/Asset/images/product6.png', type: 'category', val: 'Lehengas' },
            { label: 'Designer Gowns', img: '/Frontend/Shop/Asset/images/product8.png', type: 'category', val: 'Gowns' },
            { label: 'Anarkalis', img: '/Frontend/Shop/Asset/images/product5.png', type: 'category', val: 'Kurtis' }
        ]
    };

    window.renderSubCategories = function(mainCat) {
        var track = document.getElementById('catSliderTrack');
        if (!track) return;

        var list = subCategoryData[mainCat] || subCategoryData['All'];
        track.innerHTML = list.map(function(item, idx) {
            var isAct = idx === 0;
            var circleContent = '';
            if (item.img) {
                circleContent = '<img src="' + item.img + '" alt="' + item.label + '" loading="lazy" onerror="this.src=\'/Frontend/Shop/Asset/images/product1.png\'" />';
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

    /* Initial Sub-Categories and Master Filter Execution */
    window.renderSubCategories('All');
    window.applyMasterFilters();

})();
