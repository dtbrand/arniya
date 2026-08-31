
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
                gallery: p.gallery || p.images || (p.image ? [p.image] : []),
                images: p.images || p.gallery || (p.image ? [p.image] : []),
                video: p.video || (p.videos && p.videos[0]) || '',
                videos: p.videos || (p.video ? [p.video] : []),
                fabric: p.fabric || '',
                colors: Array.isArray(p.colors) ? p.colors.join(', ') : (p.color || ''),
                sizes: Array.isArray(p.size) ? p.size.join(', ') : (p.size || ''),
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
        category: window.initialCategory || 'All',
        searchQuery: window.initialSearchQuery || '',
        colors: [],
        sizes: [],
        fabrics: [],
        subcategories: (window.initialSubCategory && window.initialSubCategory !== 'All') ? [window.initialSubCategory] : [],
        minPrice: 500,
        maxPrice: 30000,
        minDiscount: 0,
        availability: [],
        sortBy: 'recommended'
    };

    /* ── Master Sub-Category Curated Dictionary & Keyword Map ── */
    var defaultSubCategoryMap = {
        'saree': [
            { label: 'Banarasi Kadwa Silk', val: 'Banarasi Kadwa Silk', keywords: ['banarasi', 'kadwa', 'varanasi', 'katan', 'silk'] },
            { label: 'Bandhani & Patola', val: 'Bandhani & Patola', keywords: ['bandhani', 'patola', 'gharchola', 'heritage'] },
            { label: 'Chanderi Cotton Silk', val: 'Chanderi Cotton Silk', keywords: ['chanderi', 'cotton silk', 'handloom'] },
            { label: 'Kanjivaram Pure Zari', val: 'Kanjivaram Pure Zari', keywords: ['kanjivaram', 'kanchipuram', 'zari', 'brocade'] },
            { label: 'Pure Organza Tissue', val: 'Pure Organza Tissue', keywords: ['organza', 'tissue', 'sheer'] },
            { label: 'Yeola Paithani Brocade', val: 'Yeola Paithani Brocade', keywords: ['paithani', 'yeola', 'maharashtra'] },
            { label: 'Georgette & Chiffon', val: 'Georgette & Chiffon', keywords: ['georgette', 'chiffon', 'daily'] }
        ],
        'lehenga': [
            { label: 'Bridal Velvet Lehengas', val: 'Bridal Velvet Lehengas', keywords: ['bridal', 'velvet', 'zardozi', 'heavy'] },
            { label: 'Organza Floral Lehengas', val: 'Organza Floral Lehengas', keywords: ['organza', 'floral', 'printed'] },
            { label: 'Georgette Festive Lehengas', val: 'Georgette Festive Lehengas', keywords: ['georgette', 'festive', 'sequin'] },
            { label: 'Silk Chaniya Choli', val: 'Silk Chaniya Choli', keywords: ['chaniya', 'choli', 'navratri', 'patola'] },
            { label: 'Party Wear Lehengas', val: 'Party Wear Lehengas', keywords: ['party', 'crop top', 'designer', 'mirror'] }
        ],
        'gown': [
            { label: 'Anarkali Silhouette', val: 'Anarkali Silhouette', keywords: ['anarkali', 'flared', 'silhouette', 'flair'] },
            { label: 'Floor-Length Georgette', val: 'Floor-Length Georgette', keywords: ['georgette', 'floor', 'drape', 'maxi'] },
            { label: 'Indo-Western Drape', val: 'Indo-Western Drape', keywords: ['indo-western', 'drape', 'fusion', 'cape'] },
            { label: 'Embroidered Silk Gowns', val: 'Embroidered Silk Gowns', keywords: ['embroidered', 'silk', 'handwork', 'zari'] },
            { label: 'Evening Party Gowns', val: 'Evening Party Gowns', keywords: ['party', 'evening', 'cocktail', 'glam'] }
        ],
        'kurti': [
            { label: '3-Piece Festive Sets', val: '3-Piece Festive Sets', keywords: ['3-piece', 'set', 'festive', 'dupatta', 'pant', 'suit'] },
            { label: 'Flared Anarkali & Angrakha', val: 'Flared Anarkali & Angrakha', keywords: ['anarkali', 'angrakha', 'flared', 'long'] },
            { label: 'Pure Cotton Daily', val: 'Pure Cotton Daily', keywords: ['cotton', 'daily', 'comfort', 'pure cotton'] },
            { label: 'Straight Cut Office Wear', val: 'Straight Cut Office Wear', keywords: ['straight', 'office', 'formal', 'tunic'] },
            { label: 'Party Wear Kurtis', val: 'Party Wear Kurtis', keywords: ['party', 'sequin', 'embroidered', 'heavy', 'festive'] }
        ]
    };

    var catSource = [];
    if (Array.isArray(window.allCategories) && window.allCategories.length > 0) {
        catSource = window.allCategories;
    } else if (Array.isArray(window.allProducts) && window.allProducts.length > 0) {
        catSource = window.allProducts.map(function (p) {
            return { name: p.category, image: (p.has_photo ? p.image : ''), has_image: !!p.has_photo };
        });
    }

    var DT_NO_IMAGE = '/assets/images/no-image.svg';

    /** Real photo for a category */
    function catCircleImage(c) {
        var img = (c && typeof c === 'object') ? String(c.image || '') : '';
        if (!img || img === DT_NO_IMAGE || c.has_image === false) { img = ''; }
        if (!img) {
            var cn = String((c && (c.name || c.title)) || '').toLowerCase();
            var hit = (window.allProducts || []).find(function (p) {
                return p && p.has_photo && String(p.category || p.category_name || '').toLowerCase() === cn;
            });
            img = hit ? hit.image : '';
        }
        return img;
    }

    /** Intelligent photo finder for subcategories */
    function getSubcategoryImage(catName, subItem) {
        var cn = String(catName || '').toLowerCase().trim();
        var subVal = String((subItem && (subItem.val || subItem.label || subItem.name)) || '').toLowerCase().trim();
        var keywords = (subItem && subItem.keywords) ? subItem.keywords : [];
        if (keywords.length === 0) {
            keywords = subVal.split(/[\s,\-\+&]+/).filter(function(k){ return k.length > 2; });
        }

        // 1. Try finding a product with photo that belongs to this category and matches subcategory
        var hit = (window.allProducts || []).find(function(p) {
            if (!p || !p.has_photo || !p.image || p.image === DT_NO_IMAGE) return false;
            var pCat = String(p.category || p.category_name || '').toLowerCase();
            if (pCat !== cn && pCat.indexOf(cn) === -1 && cn.indexOf(pCat) === -1) return false;
            
            var pSub = String(p.sub_category || p.subcategory || '').toLowerCase();
            var pFab = String(p.fabric || '').toLowerCase();
            var pName = String(p.name || p.title || '').toLowerCase();
            var pDesc = String(p.description || '').toLowerCase();
            var pAll = pSub + ' ' + pFab + ' ' + pName + ' ' + pDesc;

            if (pSub && (pSub === subVal || pSub.indexOf(subVal) !== -1 || subVal.indexOf(pSub) !== -1)) return true;
            if (pFab && (pFab === subVal || pFab.indexOf(subVal) !== -1 || subVal.indexOf(pFab) !== -1)) return true;
            return keywords.some(function(kw){ return pAll.indexOf(kw.toLowerCase()) !== -1; });
        });

        if (hit && hit.image) return hit.image;

        // 2. Fallback to first product in this category
        var catHit = (window.allProducts || []).find(function(p) {
            if (!p || !p.has_photo || !p.image || p.image === DT_NO_IMAGE) return false;
            var pCat = String(p.category || p.category_name || '').toLowerCase();
            return (pCat === cn || pCat.indexOf(cn) !== -1 || cn.indexOf(pCat) !== -1);
        });

        if (catHit && catHit.image) return catHit.image;
        return '';
    }

    /* ── Build Master Sub-Category Dictionary ── */
    var subCategoryData = {
        'All': [
            { label: 'All Items', icon: '✦', gradient: 'gradient-1', type: 'all', val: 'All' }
        ]
    };

    var uniqueCatMap = {};

    // 1. Populate 'All' with main categories
    catSource.forEach(function (c) {
        var cName = (typeof c === 'string') ? c.trim() : String((c && (c.name || c.title)) || '').trim();
        if (!cName || cName.toLowerCase() === 'all' || uniqueCatMap[cName.toLowerCase()]) { return; }
        uniqueCatMap[cName.toLowerCase()] = true;
        var cImg = (typeof c === 'string') ? catCircleImage({ name: cName }) : catCircleImage(c);
        subCategoryData['All'].push({ label: cName, img: cImg, type: 'category', val: cName });
    });

    // 2. Populate subcategories for each category
    Object.keys(uniqueCatMap).forEach(function (catKey) {
        var cName = catKey.charAt(0).toUpperCase() + catKey.slice(1);
        var origCat = (catSource.find(function(c){
            var n = (typeof c === 'string') ? c : (c.name || c.title || '');
            return n.toLowerCase() === catKey;
        }) || {});
        var displayName = (typeof origCat === 'string') ? origCat : (origCat.name || origCat.title || cName);
        var cImg = catCircleImage(origCat);

        // 1st circle: All <Category>
        var list = [
            { label: 'All ' + displayName, img: cImg, icon: '✦', type: 'cat_all', val: displayName }
        ];

        // Gather curated + live DB subcategories
        var baseSlug = catKey.replace(/s$/, '');
        var curatedSubs = defaultSubCategoryMap[baseSlug] || defaultSubCategoryMap[catKey] || [];
        var addedMap = {};

        curatedSubs.forEach(function(s) {
            addedMap[s.val.toLowerCase()] = true;
            var sImg = getSubcategoryImage(displayName, s);
            list.push({ label: s.label, val: s.val, img: sImg, type: 'subcategory', keywords: s.keywords });
        });

        // Add any distinct sub_category or fabric from live products in this category
        (window.allProducts || []).forEach(function(p) {
            if (!p) return;
            var pCat = String(p.category || p.category_name || '').toLowerCase();
            if (pCat !== catKey && pCat.indexOf(catKey) === -1 && catKey.indexOf(pCat) === -1) return;

            var pSub = String(p.sub_category || p.subcategory || '').trim();
            if (pSub && !addedMap[pSub.toLowerCase()]) {
                addedMap[pSub.toLowerCase()] = true;
                list.push({ label: pSub, val: pSub, img: (p.has_photo ? p.image : ''), type: 'subcategory', keywords: [pSub.toLowerCase()] });
            }

            var pFab = String(p.fabric || '').trim();
            if (pFab && !addedMap[pFab.toLowerCase()]) {
                addedMap[pFab.toLowerCase()] = true;
                list.push({ label: pFab, val: pFab, img: (p.has_photo ? p.image : ''), type: 'fabric', keywords: [pFab.toLowerCase()] });
            }
        });

        subCategoryData[displayName] = list;
        subCategoryData[displayName.toLowerCase()] = list;
        if (displayName.slice(-1) === 's') {
            subCategoryData[displayName.slice(0, -1)] = list;
            subCategoryData[displayName.slice(0, -1).toLowerCase()] = list;
        } else {
            subCategoryData[displayName + 's'] = list;
            subCategoryData[(displayName + 's').toLowerCase()] = list;
        }
    });

    function dtEsc(s) {
        return String(s == null ? '' : s).replace(/&/g, '&amp;').replace(/</g, '&lt;')
            .replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    /* ── Render Round Sub-Categories Slider with Auto-Conversion ── */
    window.renderSubCategories = function(mainCat) {
        var track = document.getElementById('catSliderTrack');
        if (!track) return;

        var currentSelectedCat = (window.masterFilterState && window.masterFilterState.category) ? window.masterFilterState.category.toLowerCase().trim() : 'all';
        var currentSubs = (window.masterFilterState && window.masterFilterState.subcategories) ? window.masterFilterState.subcategories.map(function(s){ return s.toLowerCase(); }) : [];
        var currentFabrics = (window.masterFilterState && window.masterFilterState.fabrics) ? window.masterFilterState.fabrics.map(function(f){ return f.toLowerCase(); }) : [];

        var list = [];
        if (!mainCat || mainCat.toLowerCase() === 'all') {
            list = subCategoryData['All'] || [];
        } else {
            list = subCategoryData[mainCat] || subCategoryData[mainCat.toLowerCase()] || subCategoryData['All'] || [];
        }

        track.innerHTML = list.map(function(item, idx) {
            var itemVal = (item.val || '').toLowerCase();
            var isAct = false;
            if (item.type === 'all') {
                isAct = (currentSelectedCat === 'all' || currentSelectedCat === '') && currentSubs.length === 0 && currentFabrics.length === 0;
            } else if (item.type === 'cat_all') {
                isAct = (currentSubs.length === 0 && currentFabrics.length === 0);
            } else if (item.type === 'category') {
                isAct = (itemVal === currentSelectedCat);
            } else if (item.type === 'subcategory') {
                isAct = currentSubs.indexOf(itemVal) !== -1;
            } else if (item.type === 'fabric') {
                isAct = currentFabrics.indexOf(itemVal) !== -1;
            }

            var circleContent = '';
            if (item.img) {
                circleContent = '<img src="' + dtEsc(item.img) + '" alt="' + dtEsc(item.label) + '" loading="lazy" onerror="this.onerror=null;this.src=\'' + DT_NO_IMAGE + '\';this.style.opacity=\'.5\';" />';
            } else {
                circleContent = '<span class="cat-icon" aria-hidden="true">' + dtEsc(item.icon || '✦') + '</span>';
            }

            return '<button class="cat-item ' + (isAct ? 'active' : '') + '" role="listitem" data-type="' + dtEsc(item.type || '') + '" data-val="' + dtEsc(item.val || '') + '" aria-pressed="' + (isAct ? 'true' : 'false') + '" aria-label="' + dtEsc(item.label) + '">' +
                '<div class="cat-ring">' +
                    '<div class="cat-circle ' + dtEsc(item.gradient || '') + '">' + circleContent + '</div>' +
                '</div>' +
                '<span class="cat-label">' + dtEsc(item.label) + '</span>' +
            '</button>';
        }).join('');

        // Bind clicks on round sub-category items
        track.querySelectorAll('.cat-item').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var type = btn.dataset.type;
                var val  = btn.dataset.val;
                var st   = window.masterFilterState;

                if (type === 'all') {
                    // Clicked 'All Items'
                    st.category = 'All';
                    st.subcategories = [];
                    st.fabrics = [];
                    window.renderSubCategories('All');
                } else if (type === 'category') {
                    // Clicked a main category circle from the All view (e.g. Saree, Lehenga, Gown, Kurti)
                    st.category = val;
                    st.subcategories = [];
                    st.fabrics = [];
                    // AUTO-CONVERT SLIDER TO THAT CATEGORY'S SUBCATEGORIES!
                    window.renderSubCategories(val);
                } else if (type === 'cat_all') {
                    // Clicked 'All <Category>' circle inside a category sub-view
                    st.subcategories = [];
                    st.fabrics = [];
                    track.querySelectorAll('.cat-item').forEach(function(b) { b.classList.remove('active'); b.setAttribute('aria-pressed','false'); });
                    btn.classList.add('active'); btn.setAttribute('aria-pressed','true');
                } else if (type === 'subcategory') {
                    // Clicked a specific subcategory circle
                    var idx = st.subcategories.indexOf(val);
                    if (idx !== -1) {
                        st.subcategories.splice(idx, 1);
                    } else {
                        st.subcategories = [val]; // select this subcategory
                    }
                    st.fabrics = [];
                    track.querySelectorAll('.cat-item').forEach(function(b) { b.classList.remove('active'); b.setAttribute('aria-pressed','false'); });
                    if (st.subcategories.length > 0) {
                        btn.classList.add('active'); btn.setAttribute('aria-pressed','true');
                    } else {
                        var firstBtn = track.querySelector('.cat-item');
                        if (firstBtn) { firstBtn.classList.add('active'); firstBtn.setAttribute('aria-pressed','true'); }
                    }
                } else if (type === 'fabric') {
                    // Clicked a specific fabric circle
                    var fIdx = st.fabrics.indexOf(val);
                    if (fIdx !== -1) {
                        st.fabrics.splice(fIdx, 1);
                    } else {
                        st.fabrics = [val];
                    }
                    st.subcategories = [];
                    track.querySelectorAll('.cat-item').forEach(function(b) { b.classList.remove('active'); b.setAttribute('aria-pressed','false'); });
                    if (st.fabrics.length > 0) {
                        btn.classList.add('active'); btn.setAttribute('aria-pressed','true');
                    }
                }

                btn.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });

                // Sync header subnav tabs
                document.querySelectorAll('.main-cat-tab').forEach(function(t){
                    var tCat = (t.dataset.cat || '').toLowerCase();
                    var isMatch = (st.category.toLowerCase() === 'all' && (tCat === 'all' || tCat === '')) || (tCat === st.category.toLowerCase());
                    t.classList.toggle('active', isMatch);
                    t.setAttribute('aria-selected', isMatch ? 'true' : 'false');
                });

                // Sync sidebar category chips
                document.querySelectorAll('.sf-chip[data-sf-type="category"]').forEach(function(ci){
                    ci.classList.toggle('active', ci.dataset.sfVal.toLowerCase() === st.category.toLowerCase());
                });

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
        var cardElems = document.querySelectorAll('.product-card');
        var total = 0;
        var targetCat = (st.category || 'All').toLowerCase().trim();

        cardElems.forEach(function(card) {
            var cardCat = (card.dataset.category || '').toLowerCase().trim();
            var catMatch = (targetCat === 'all' || targetCat === 'new arrivals' || cardCat === targetCat || cardCat.indexOf(targetCat) !== -1 || targetCat.indexOf(cardCat) !== -1);
            
            var price = parseInt(card.dataset.price) || 0;
            var priceMatch = (price >= st.minPrice && price <= st.maxPrice);

            var colorMatch = true;
            if (st.colors && st.colors.length > 0) {
                var cardColor = (card.dataset.color || '').toLowerCase();
                colorMatch = st.colors.some(function(c) {
                    return cardColor.indexOf(c.toLowerCase()) !== -1;
                });
            }

            var sizeMatch = true;
            if (st.sizes && st.sizes.length > 0) {
                var cardSizes = card.dataset.size ? card.dataset.size.split(',').map(function(s){ return s.trim().toLowerCase(); }) : [];
                sizeMatch = st.sizes.some(function(s){ return cardSizes.indexOf(s) !== -1; });
            }

            var fabricMatch = true;
            if (st.fabrics && st.fabrics.length > 0) {
                var cardFabric = (card.dataset.fabric || '').toLowerCase();
                fabricMatch = st.fabrics.some(function(f) {
                    return cardFabric.indexOf(f.toLowerCase()) !== -1 || f.toLowerCase().indexOf(cardFabric) !== -1;
                });
            }

            var subcatMatch = true;
            if (st.subcategories && st.subcategories.length > 0) {
                var cardSub = (card.dataset.subcategory || '').toLowerCase();
                var cardFab = (card.dataset.fabric || '').toLowerCase();
                var cardName = (card.querySelector('.card-name') ? card.querySelector('.card-name').textContent : '').toLowerCase();
                var cardAria = (card.getAttribute('aria-label') || '').toLowerCase();
                var cardAllText = cardName + ' ' + cardAria + ' ' + cardSub + ' ' + cardFab;

                subcatMatch = st.subcategories.some(function(subVal) {
                    var sVal = String(subVal || '').toLowerCase().trim();
                    if (!sVal) return true;
                    if (cardSub && (cardSub === sVal || cardSub.indexOf(sVal) !== -1 || sVal.indexOf(cardSub) !== -1)) return true;
                    if (cardFab && (cardFab === sVal || cardFab.indexOf(sVal) !== -1 || sVal.indexOf(cardFab) !== -1)) return true;
                    
                    var tokens = sVal.split(/[\s,\-\+&]+/).filter(function(k){ return k.length > 2 && ['and', 'pure', 'sets', 'wear'].indexOf(k) === -1; });
                    return tokens.some(function(t) {
                        return cardAllText.indexOf(t) !== -1;
                    });
                });
            }

            var discount = parseInt(card.dataset.discount || '0');
            var discountMatch = (discount >= st.minDiscount);

            var stockMatch = true;
            if (st.availability && st.availability.length > 0) {
                stockMatch = st.availability.indexOf(card.dataset.stock) !== -1;
            }

            var searchMatch = true;
            if (st.searchQuery && st.searchQuery.trim().length > 0) {
                var rawQ = st.searchQuery.toLowerCase().trim();
                rawQ = rawQ.replace(/\b(sarees|lehengas|gowns|kurtis)\b/g, function(m){
                    return m.slice(0, -1);
                });
                var tokens = rawQ.split(/[\s,\-\+]+/).filter(function(t){ return t.length > 0; });

                var cardName = (card.querySelector('.card-name') ? card.querySelector('.card-name').textContent : '').toLowerCase();
                var cardAria = (card.getAttribute('aria-label') || '').toLowerCase();
                var cardCatText = (card.dataset.category || '').toLowerCase();
                var cardSubText = (card.dataset.subcategory || '').toLowerCase();
                var cardFabricText = (card.dataset.fabric || '').toLowerCase();
                var cardColorText = (card.dataset.color || '').toLowerCase();
                var cardSku = (card.dataset.sku || '').toLowerCase();

                var corpus = cardName + ' ' + cardAria + ' ' + cardCatText + ' ' + cardSubText + ' ' + cardFabricText + ' ' + cardColorText + ' ' + cardSku;
                if (corpus.indexOf('varanasi') !== -1 || corpus.indexOf('kadwa') !== -1 || corpus.indexOf('katan') !== -1) {
                    corpus += ' banarasi banaras';
                }
                if (corpus.indexOf('kanjivaram') !== -1 || corpus.indexOf('brocade') !== -1) {
                    corpus += ' kanchipuram zari silk';
                }
                if (corpus.indexOf('paithani') !== -1) {
                    corpus += ' yeola silk maharashtra';
                }

                var matchCount = 0;
                tokens.forEach(function(token) {
                    var tokenBase = (token.length > 3 && token.slice(-1) === 's') ? token.slice(0, -1) : token;
                    if (corpus.indexOf(token) !== -1 || corpus.indexOf(tokenBase) !== -1) {
                        matchCount++;
                    }
                });

                var minReq = tokens.length === 1 ? 1 : Math.max(1, Math.ceil(tokens.length * 0.5));
                searchMatch = matchCount >= minReq;
            }

            var isMatch = catMatch && subcatMatch && priceMatch && colorMatch && sizeMatch && fabricMatch && discountMatch && stockMatch && searchMatch;

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
            if (grid) {
                var sortedCards = Array.from(cardElems);
                sortedCards.sort(function(a, b) {
                    var pA = parseInt(a.dataset.price) || 0, pB = parseInt(b.dataset.price) || 0;
                    var dA = parseInt(a.dataset.discount||'0'), dB = parseInt(b.dataset.discount||'0');
                    if (st.sortBy === 'price_asc') return pA - pB;
                    if (st.sortBy === 'price_desc') return pB - pA;
                    if (st.sortBy === 'discount') return dB - dA;
                    return parseInt(a.dataset.productId || '0') - parseInt(b.dataset.productId || '0');
                });
                sortedCards.forEach(function(c){ grid.appendChild(c); });
            }
        }

        // Show/Hide Empty State
        var noMsg = document.getElementById('noProductsMsg');
        if (noMsg) noMsg.style.display = (total === 0) ? 'block' : 'none';

        // Update product count label
        var ptbCount = document.getElementById('ptbCount');
        var totalCatalog = (window.allProducts && window.allProducts.length) ? window.allProducts.length : cardElems.length;
        if (ptbCount) {
            if (total === totalCatalog) {
                ptbCount.textContent = 'Showing ' + total + ' Products';
            } else {
                ptbCount.textContent = 'Showing ' + total + ' of ' + totalCatalog + ' Products';
            }
        }

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

        if (st.searchQuery && st.searchQuery.trim().length > 0) {
            tags.push({ label: 'Search: &ldquo;' + st.searchQuery + '&rdquo;', type: 'search' });
        }
        if (st.category && st.category !== 'All') {
            tags.push({ label: st.category, type: 'category', val: st.category });
        }
        if (st.minPrice > 500 || st.maxPrice < 30000) {
            tags.push({ label: '₹' + st.minPrice.toLocaleString('en-IN') + ' - ₹' + st.maxPrice.toLocaleString('en-IN'), type: 'price' });
        }
        if (st.colors && st.colors.length > 0) {
            st.colors.forEach(function(c){ tags.push({ label: c, type: 'color', val: c }); });
        }
        if (st.sizes && st.sizes.length > 0) {
            st.sizes.forEach(function(s){ tags.push({ label: 'Size: ' + s, type: 'size', val: s }); });
        }
        if (st.subcategories && st.subcategories.length > 0) {
            st.subcategories.forEach(function(sc){ tags.push({ label: sc, type: 'subcategory', val: sc }); });
        }
        if (st.fabrics && st.fabrics.length > 0) {
            st.fabrics.forEach(function(f){ tags.push({ label: f, type: 'fabric', val: f }); });
        }
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
        if (type === 'search') {
            st.searchQuery = '';
            var sInput = document.getElementById('searchInput');
            var mInput = document.getElementById('mobileSearchInput');
            if (sInput) sInput.value = '';
            if (mInput) mInput.value = '';
            var sClr = document.getElementById('searchClearBtn');
            var mClr = document.getElementById('mobileSearchClearBtn');
            if (sClr) sClr.style.display = 'none';
            if (mClr) mClr.style.display = 'none';
        } else if (type === 'category') {
            st.category = 'All';
            st.subcategories = [];
            st.fabrics = [];
            window.renderSubCategories('All');
            document.querySelectorAll('.sf-chip[data-sf-type="category"]').forEach(function(ci){
                ci.classList.toggle('active', ci.dataset.sfVal === 'All');
            });
            document.querySelectorAll('.main-cat-tab').forEach(function(t){
                t.classList.toggle('active', (t.dataset.cat || '').toLowerCase() === 'all');
            });
        } else if (type === 'subcategory') {
            st.subcategories = st.subcategories.filter(function(x){ return x !== val; });
            var track = document.getElementById('catSliderTrack');
            if (track) {
                var btn = track.querySelector('.cat-item[data-val="' + val + '"]');
                if (btn) { btn.classList.remove('active'); btn.setAttribute('aria-pressed', 'false'); }
                if (st.subcategories.length === 0) {
                    var firstBtn = track.querySelector('.cat-item');
                    if (firstBtn) { firstBtn.classList.add('active'); firstBtn.setAttribute('aria-pressed', 'true'); }
                }
            }
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
            var trackF = document.getElementById('catSliderTrack');
            if (trackF) {
                var btnF = trackF.querySelector('.cat-item[data-val="' + val + '"]');
                if (btnF) { btnF.classList.remove('active'); btnF.setAttribute('aria-pressed', 'false'); }
            }
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
            window.masterFilterState.subcategories = [];
            window.masterFilterState.fabrics = [];
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
                st.subcategories = [];
                st.fabrics = [];
                document.querySelectorAll('.main-cat-tab').forEach(function(t){
                    var tCat = (t.dataset.cat || '').toLowerCase();
                    var isMatch = (val.toLowerCase() === 'all' && (tCat === 'all' || tCat === '')) || (tCat === val.toLowerCase());
                    t.classList.toggle('active', isMatch);
                    t.setAttribute('aria-selected', isMatch ? 'true' : 'false');
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
            subcategories: [],
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
        st.subcategories = [];
        st.fabrics = [];
        document.querySelectorAll('.main-cat-tab').forEach(function(t){
            var tCat = (t.dataset.cat || '').toLowerCase();
            var isMatch = (catName.toLowerCase() === 'all' && (tCat === 'all' || tCat === '')) || (tCat === catName.toLowerCase());
            t.classList.toggle('active', isMatch);
            t.setAttribute('aria-selected', isMatch ? 'true' : 'false');
        });
        document.querySelectorAll('.sf-chip[data-sf-type="category"]').forEach(function(ci){
            ci.classList.toggle('active', ci.dataset.sfVal.toLowerCase() === catName.toLowerCase());
        });
        window.renderSubCategories(catName);
        window.applyMasterFilters();
        if (typeof window.syncMobileFilterUI === 'function') window.syncMobileFilterUI();
    };

    /* Initial Sub-Categories and Master Filter Execution */
    var initialCategory = window.masterFilterState.category || 'All';
    if (window.initialSearchQuery) {
        var sInput = document.getElementById('searchInput');
        var mInput = document.getElementById('mobileSearchInput');
        if (sInput) sInput.value = window.initialSearchQuery;
        if (mInput) mInput.value = window.initialSearchQuery;
        var sClr = document.getElementById('searchClearBtn');
        var mClr = document.getElementById('mobileSearchClearBtn');
        if (sClr) sClr.style.display = 'flex';
        if (mClr) mClr.style.display = 'flex';
    }

    // Sync subnav tabs
    document.querySelectorAll('.main-cat-tab').forEach(function(t){
        var tCat = (t.dataset.cat || '').toLowerCase();
        var isMatch = (initialCategory.toLowerCase() === 'all' && (tCat === 'all' || tCat === '')) || (tCat === initialCategory.toLowerCase());
        t.classList.toggle('active', isMatch);
        t.setAttribute('aria-selected', isMatch ? 'true' : 'false');
    });

    window.renderSubCategories(initialCategory);
    window.applyMasterFilters();

    // If navigated with category/subcategory/search parameter, smooth scroll to storefront
    if ((initialCategory && initialCategory !== 'All') || window.initialSubCategory || window.initialSearchQuery) {
        setTimeout(function() {
            var grid = document.getElementById('productsGrid') || document.querySelector('.products-section') || document.querySelector('.shop-layout');
            if (grid) {
                var offset = grid.getBoundingClientRect().top + window.pageYOffset - 90;
                window.scrollTo({ top: Math.max(0, offset), behavior: 'smooth' });
            }
        }, 150);
    }

})();
