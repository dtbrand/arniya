
(function() {
    'use strict';

    var currentProduct = window.currentProductData || {};
    window.currentPdpProduct = currentProduct;

    // ── Automatic Recently Viewed Product Recording ──
    try {
        var pToTrack = window.currentProductData || window.currentPdpProduct || {};
        if (pToTrack && pToTrack.id) {
            var storedList = JSON.parse(localStorage.getItem('dtbrands_recently_viewed') || '[]');
            if (!Array.isArray(storedList)) storedList = [];
            storedList = storedList.filter(function(x) { return x && Number(x.id) !== Number(pToTrack.id); });
            var pImg = pToTrack.image || (Array.isArray(pToTrack.images) && pToTrack.images[0]) || '/assets/images/no-image.svg';
            var pPrice = Number(pToTrack.price || pToTrack.effective_customer_price || pToTrack.customer_price) || 0;
            var pOldPrice = Number(pToTrack.old_price || pToTrack.mrp) || 0;
            var pDiscount = pToTrack.discount || (pOldPrice > pPrice && pPrice > 0 ? Math.round(((pOldPrice - pPrice) / pOldPrice) * 100) + '% OFF' : '');
            
            storedList.unshift({
                id: pToTrack.id,
                name: pToTrack.name || pToTrack.title || ('Product #' + pToTrack.id),
                price: pPrice,
                old_price: pOldPrice,
                discount: pDiscount,
                image: pImg,
                category: String(pToTrack.category || 'ETHNIC WEAR').toUpperCase(),
                fabric: pToTrack.fabric || '',
                in_stock: pToTrack.in_stock !== false
            });
            if (storedList.length > 20) storedList = storedList.slice(0, 20);
            localStorage.setItem('dtbrands_recently_viewed', JSON.stringify(storedList));
        }
    } catch {
        // Ignore localStorage quota errors silently
    }

    // ── Global Luxury Designer Toast Helper ──
    window.showToast = function (msg, explicitType) {
        var container = document.getElementById('toastContainer') || document.getElementById('wsToastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        var raw = String(msg || '').trim();
        var cleanText = raw.replace(/^[\s\u2713\u2661\u2728\p{Extended_Pictographic}]+/u, '').trim();
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
    window.showWsToast = window.showToast;

    // ═════════════════════════════════════════════════════════════
    // SMART HAND SCROLLING & AUTO-SLIDER (MAIN PRODUCT GALLERY)
    // ═════════════════════════════════════════════════════════════
    var track = document.getElementById('pdpSliderTrack');
    var counter = document.getElementById('pdpSlideCounter');
    var dotsWrap = document.getElementById('pdpGalleryDots');
    var totalSlides = window.totalSlidesCount || document.querySelectorAll(".gallery-thumb").length || 4;
    var currentSlideIdx = 0;
    var galleryAutoTimer = null;
    var galleryResumeTimeout = null;

    // Generate Gallery Dots (Pure Photos)
    function buildGalleryDots() {
        if (!dotsWrap) return;
        dotsWrap.innerHTML = '';
        var slides = document.querySelectorAll('#pdpSliderTrack .pdp-slide');
        var count = slides.length || totalSlides;
        for (var i = 0; i < count; i++) {
            var dot = document.createElement('div');
            dot.className = 'pdp-gallery-dot' + (i === 0 ? ' active' : '');
            dot.setAttribute('data-idx', i);
            dot.onclick = (function(idx) {
                return function() {
                    window.goToSlide(idx);
                };
            })(i);
            dotsWrap.appendChild(dot);
        }
    }
    buildGalleryDots();

    window.goToSlide = function(idx) {
        if (!track) return;
        currentSlideIdx = ((idx % totalSlides) + totalSlides) % totalSlides;
        var width = track.clientWidth;
        track.scrollTo({ left: currentSlideIdx * width, behavior: 'smooth' });
        updateActiveThumbnail(currentSlideIdx);
        updateActiveDots(currentSlideIdx);
        if (counter) counter.textContent = (currentSlideIdx + 1) + ' / ' + totalSlides;
        restartGalleryAutoTimer();
    };

    window.openProductVideosReel = function(productData, videoIndex) {
        var p = productData || window.currentProductData;
        var vIdx = typeof videoIndex === 'number' ? videoIndex : 0;
        if (typeof window.openReelsModal === 'function') {
            window.openReelsModal(p, vIdx);
        }
    };

    window.slidePdpGallery = function(delta) {
        window.goToSlide(currentSlideIdx + delta);
    };

    function isElementInViewport(el) {
        if (!el) return false;
        var rect = el.getBoundingClientRect();
        return (
            rect.bottom > 0 &&
            rect.top < (window.innerHeight || document.documentElement.clientHeight)
        );
    }

    function updateActiveThumbnail(idx) {
        var strip = document.getElementById('pdpThumbnailsStrip');
        document.querySelectorAll('.pdp-thumb-item').forEach(function(item, i) {
            var isActive = (i === idx);
            item.classList.toggle('active', isActive);
            if (isActive && strip) {
                var offset = item.offsetLeft - (strip.clientWidth / 2) + (item.clientWidth / 2);
                strip.scrollTo({ left: Math.max(0, offset), behavior: 'smooth' });
            }
        });
    }

    function updateActiveDots(idx) {
        if (!dotsWrap) return;
        dotsWrap.querySelectorAll('.pdp-gallery-dot').forEach(function(dot, i) {
            dot.classList.toggle('active', i === idx);
        });
    }

    function startGalleryAutoTimer() {
        if (galleryAutoTimer) clearInterval(galleryAutoTimer);
        galleryAutoTimer = setInterval(function() {
            var sliderBox = document.getElementById('pdpGallerySlider');
            if (sliderBox && !isElementInViewport(sliderBox)) return;
            window.slidePdpGallery(1);
        }, 4000);
    }

    function pauseGalleryAutoTimer() {
        if (galleryAutoTimer) {
            clearInterval(galleryAutoTimer);
            galleryAutoTimer = null;
        }
        if (galleryResumeTimeout) {
            clearTimeout(galleryResumeTimeout);
            galleryResumeTimeout = null;
        }
    }

    function restartGalleryAutoTimer() {
        pauseGalleryAutoTimer();
        galleryResumeTimeout = setTimeout(startGalleryAutoTimer, 3500);
    }

    if (track) {
        startGalleryAutoTimer();

        // A video that is left playing while the shopper scrolls to another slide
        // keeps its audio going, so each clip pauses when it leaves the viewport.
        track.querySelectorAll('video').forEach(function(vid) {
            vid.addEventListener('play', pauseGalleryAutoTimer);
        });

        // Pause on hover
        var sliderBox = document.getElementById('pdpGallerySlider');
        if (sliderBox) {
            sliderBox.addEventListener('mouseenter', pauseGalleryAutoTimer);
            sliderBox.addEventListener('mouseleave', startGalleryAutoTimer);
        }

        // Smart Touch Swipe Hand Scrolling
        var isTouchDrag = false;
        var touchStartX = 0, touchStartY = 0;
        var touchCurrentX = 0, touchCurrentY = 0;
        var touchStartScroll = 0;
        var isHorizontalSwipe = false;

        track.addEventListener('touchstart', function(e) {
            pauseGalleryAutoTimer();
            isTouchDrag = true;
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
            touchCurrentX = touchStartX;
            touchCurrentY = touchStartY;
            touchStartScroll = track.scrollLeft;
            isHorizontalSwipe = false;
        }, { passive: true });

        track.addEventListener('touchmove', function(e) {
            if (!isTouchDrag) return;
            touchCurrentX = e.touches[0].clientX;
            touchCurrentY = e.touches[0].clientY;
            var diffX = touchCurrentX - touchStartX;
            var diffY = touchCurrentY - touchStartY;

            if (!isHorizontalSwipe) {
                if (Math.abs(diffX) > 6 || Math.abs(diffY) > 6) {
                    if (Math.abs(diffX) >= Math.abs(diffY)) {
                        isHorizontalSwipe = true;
                    } else {
                        isTouchDrag = false;
                        return; // Normal vertical page scrolling
                    }
                }
            }

            if (isHorizontalSwipe) {
                if (e.cancelable) e.preventDefault();
                track.scrollLeft = touchStartScroll - diffX;
            }
        }, { passive: false });

        track.addEventListener('touchend', function() {
            if (isTouchDrag && isHorizontalSwipe) {
                var diffX = touchCurrentX - touchStartX;
                if (diffX < -40) {
                    window.slidePdpGallery(1);
                } else if (diffX > 40) {
                    window.slidePdpGallery(-1);
                } else {
                    window.goToSlide(currentSlideIdx);
                }
            }
            isTouchDrag = false;
            isHorizontalSwipe = false;
            restartGalleryAutoTimer();
        }, { passive: true });

        // Mouse Dragging on Desktop
        var isMouseDrag = false;
        var mouseStartX = 0;
        var mouseStartScroll = 0;

        track.addEventListener('mousedown', function(e) {
            pauseGalleryAutoTimer();
            isMouseDrag = true;
            mouseStartX = e.clientX;
            mouseStartScroll = track.scrollLeft;
            track.classList.add('dragging');
        });

        window.addEventListener('mousemove', function(e) {
            if (!isMouseDrag) return;
            var diffX = e.clientX - mouseStartX;
            track.scrollLeft = mouseStartScroll - diffX;
        });

        window.addEventListener('mouseup', function(e) {
            if (!isMouseDrag) return;
            isMouseDrag = false;
            track.classList.remove('dragging');
            var diffX = e.clientX - mouseStartX;
            if (diffX < -40) {
                window.slidePdpGallery(1);
            } else if (diffX > 40) {
                window.slidePdpGallery(-1);
            } else {
                window.goToSlide(currentSlideIdx);
            }
            restartGalleryAutoTimer();
        });

        // Scroll listener for syncing counter and dots
        track.addEventListener('scroll', function() {
            var width = track.clientWidth;
            if (width > 0) {
                var idx = Math.round(track.scrollLeft / width);
                if (idx !== currentSlideIdx && idx >= 0 && idx < totalSlides) {
                    currentSlideIdx = idx;
                    updateActiveThumbnail(idx);
                    updateActiveDots(idx);
                    if (counter) counter.textContent = (idx + 1) + ' / ' + totalSlides;
                }
            }
        }, { passive: true });
    }

    function syncAvailableSizesForColor(selectedColor) {
        if (!currentProduct || !Array.isArray(currentProduct.variants) || !currentProduct.variants.length) {
            return;
        }
        var normColor = String(selectedColor || '').toLowerCase().trim();
        var matchingVariants = currentProduct.variants.filter(function (v) {
            return String(v.color || '').toLowerCase().trim() === normColor;
        });

        if (!matchingVariants.length) {
            document.querySelectorAll('.pdp-size-btn').forEach(function (btn) {
                btn.style.display = '';
                btn.style.opacity = '1';
                btn.removeAttribute('disabled');
            });
            return;
        }

        var availableSizes = {};
        matchingVariants.forEach(function (v) {
            if (v.size) {
                availableSizes[String(v.size).toLowerCase().trim()] = v;
            }
        });

        var sizeButtons = document.querySelectorAll('.pdp-size-btn');
        var firstValidBtn = null;
        var currentlyActiveValid = false;

        sizeButtons.forEach(function (btn) {
            var sVal = String(btn.getAttribute('data-size') || '').toLowerCase().trim();
            if (availableSizes[sVal]) {
                btn.style.display = '';
                btn.style.opacity = '1';
                btn.removeAttribute('disabled');
                if (!firstValidBtn) firstValidBtn = btn;
                if (btn.classList.contains('active')) currentlyActiveValid = true;
            } else {
                btn.classList.remove('active');
                btn.style.display = 'none';
                btn.setAttribute('disabled', 'disabled');
            }
        });

        if (!currentlyActiveValid && firstValidBtn) {
            firstValidBtn.classList.add('active');
        }
    }

    // Colour Selector
    window.selectPdpColor = function(btn) {
        document.querySelectorAll('.pdp-color-btn').forEach(function(b) { b.classList.remove('active'); });
        btn.classList.add('active');
        var colorVal = btn.dataset.color || '';
        var nameEl = document.getElementById('pdpSelectedColorName');
        if (nameEl) nameEl.textContent = colorVal;
        syncAvailableSizesForColor(colorVal);
    };

    // Size Selector
    window.selectPdpSize = function(btn) {
        document.querySelectorAll('.pdp-size-btn').forEach(function(b) { b.classList.remove('active'); });
        btn.classList.add('active');
    };

    // Quantity Counter
    var currentQty = 1;
    window.updatePdpQty = function(delta) {
        currentQty += delta;
        if (currentQty < 1) currentQty = 1;
        if (currentQty > 50) currentQty = 50;
        var qEl = document.getElementById('pdpQtyVal');
        if (qEl) qEl.textContent = currentQty;

        var fullSetBadge = document.getElementById('pdpTotalPiecesBadge');
        if (fullSetBadge && currentProduct && currentProduct.selling_type === 'full_set') {
            var pieces = currentProduct.full_set_pieces || (currentProduct.variants ? currentProduct.variants.length : 1);
            fullSetBadge.textContent = (currentQty * pieces) + ' physical pieces';
        }
    };

    // Accordion Toggle
    window.togglePdpAcc = function(headerBtn) {
        var parentItem = headerBtn.closest('.pdp-acc-item');
        if (parentItem) {
            var isOpen = parentItem.classList.toggle('open');
            headerBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        }
    };

    // Reads the shopper's actual choice. Returns '' when the product has no size
    // or colour variants at all -- the page then shows no selector, and the old
    // 'Free Size' / 'Standard' placeholders travelled all the way into the cart
    // line, the WhatsApp message and order_items for products that never had
    // either attribute.
    function pdpSelection() {
        var activeSizeBtn = document.querySelector('.pdp-size-btn.active');
        var sizeList = Array.isArray(currentProduct.size) ? currentProduct.size : [];
        var activeColorBtn = document.querySelector('.pdp-color-btn.active');
        var colorList = Array.isArray(currentProduct.colors) ? currentProduct.colors : [];
        return {
            size: activeSizeBtn ? (activeSizeBtn.dataset.size || '') : (sizeList[0] || ''),
            color: activeColorBtn ? (activeColorBtn.dataset.color || '') : (colorList[0] || '')
        };
    }
    window.pdpSelection = pdpSelection;

    // Add To Bag Function (Integrates directly with Cart Drawer)
    window.handlePdpAddToCart = function() {
        var sel = pdpSelection();

        if (typeof window.addToCart === 'function') {
            // addToCart(product, { qty, size, color }). This used to be called as
            // (product, selSize, selColor) inside a loop, so the size string landed
            // in the qty slot (Number('M') -> NaN, giving the line a NaN quantity)
            // and the colour landed in lot_type.
            window.addToCart(currentProduct, { qty: currentQty, size: sel.size, color: sel.color });
        } else {
            // Local fallback
            try {
                var cart = JSON.parse(localStorage.getItem('dtbrands_cart') || '[]');
                cart.push({
                    id: currentProduct.id,
                    name: currentProduct.name,
                    price: currentProduct.price,
                    image: currentProduct.image,
                    size: sel.size,
                    color: sel.color,
                    qty: currentQty
                });
                localStorage.setItem('dtbrands_cart', JSON.stringify(cart));
            } catch {
                // Storage quota exceeded or disabled
            }
        }

        window.showToast('🛍️ Added ' + (currentProduct.name || 'item') + ' to Bag!');
        if (typeof window.syncPdpHeaderState === 'function') window.syncPdpHeaderState();
        if (typeof window.openCartDrawer === 'function') {
            window.openCartDrawer();
        }
    };

    // Buy Now (Instant Checkout Flow)
    window.handlePdpBuyNow = function() {
        var sel = pdpSelection();

        if (typeof window.addToCart === 'function') {
            // One call carrying the quantity, instead of currentQty separate calls
            // that each passed the size where the quantity belonged.
            window.addToCart(currentProduct, { qty: currentQty, size: sel.size, color: sel.color });
        }

        if (typeof window.syncPdpHeaderState === 'function') window.syncPdpHeaderState();

        // Close cart drawer if open
        if (typeof window.closeCartDrawer === 'function') {
            window.closeCartDrawer();
        }

        // Open checkout modal directly
        if (typeof window.openCheckout === 'function') {
            setTimeout(function() {
                window.openCheckout();
            }, 80);
        } else {
            window.location.href = 'checkout.php';
        }
    };

    // Wishlist Toggle
    window.handlePdpWishlistClick = function() {
        var wishBtn = document.getElementById('pdpMobWishBtn');
        if (typeof window.toggleWishlistProduct === 'function') {
            var added = window.toggleWishlistProduct(currentProduct);
            if (wishBtn) wishBtn.classList.toggle('active', added);
            window.showToast(added ? '♡ Saved to wishlist' : 'Removed from wishlist');
            if (typeof window.syncPdpHeaderState === 'function') window.syncPdpHeaderState();
        }
    };

    // Pincode Delivery Estimator.
    //
    // There is no serviceability data anywhere in the project -- no courier API,
    // no pincode table -- so this cannot promise a delivery date or COD. It used
    // to answer any six digits with "Fast Delivery by <today + 3 days>" and
    // "Cash on Delivery Available for <pin>", which is a delivery promise and a
    // payment-method promise the shop had not actually checked. It now states the
    // usual dispatch window as an estimate and sends the shopper to WhatsApp for
    // a confirmed date and COD availability.
    window.checkPincodeDelivery = function() {
        var input = document.getElementById('pdpPincodeInput');
        var res = document.getElementById('pdpPincodeResult');
        if (!input || !res) return;

        var pin = input.value.trim();
        if (!/^[1-9][0-9]{5}$/.test(pin)) {
            res.style.display = 'block';
            res.style.color = '#D32F2F';
            res.textContent = '⚠️ Please enter a valid 6-digit Indian pincode.';
            return;
        }

        var waNumber = window.pdpWhatsAppNumber || '917046363528';
        var askText = 'Hi, can you confirm delivery and COD for pincode ' + pin +
            (currentProduct && currentProduct.name ? ' for ' + currentProduct.name : '') + '?';
        var waHref = 'https://api.whatsapp.com/send?phone=' + encodeURIComponent(waNumber) +
            '&text=' + encodeURIComponent(askText);

        res.style.display = 'block';
        res.style.color = '#5A5348';
        res.innerHTML = 'Orders usually dispatch in 24–48 hours and reach most Indian pincodes in 3–5 working days. ' +
            'We have not checked courier serviceability for <strong>' + pin + '</strong> yet — ' +
            '<a href="' + waHref + '" target="_blank" rel="noopener" style="color:#15803D; font-weight:800;">' +
            'ask us on WhatsApp</a> and we will confirm the date and whether COD is available there.';
    };

    // ═════════════════════════════════════════════════════════════
    // NEXT-LEVEL LUXURY FULLSCREEN LIGHTBOX (PHOTOS + VIDEOS)
    // ═════════════════════════════════════════════════════════════
    var lbOverlay = null;
    var lbSlider = null;
    var lbThumbs = null;
    var lbCounter = null;
    var lbCurrentIdx = 0;
    var lbMediaList = [];
    var lbZoomScale = 1;
    var lbEventsBound = false;

    function buildLightboxMedia() {
        lbMediaList = [];
        var p = window.currentProductData || currentProduct || {};

        // Collect photos from all possible sources (gallery, images, image)
        var rawImgs = [].concat(p.gallery || [], p.images || [], p.image ? [p.image] : []);
        rawImgs.forEach(function(img) {
            var s = String(img || '').trim();
            if (s && s !== '/assets/images/no-image.svg' && s.indexOf('no-image.svg') === -1 && s.indexOf('data:') !== 0 && !lbMediaList.some(function(x) { return x.src === s; })) {
                lbMediaList.push({ kind: 'image', src: s, title: p.name || 'Photo' });
            }
        });

        // DOM Fallback for photos if media array was empty
        if (lbMediaList.length === 0) {
            document.querySelectorAll('#pdpSliderTrack .pdp-slide img').forEach(function(img) {
                var s = img.getAttribute('src') || img.src;
                if (s && s.indexOf('no-image.svg') === -1 && s.indexOf('data:') !== 0 && !lbMediaList.some(function(x) { return x.src === s; })) {
                    lbMediaList.push({ kind: 'image', src: s, title: p.name || 'Photo' });
                }
            });
        }

        var posterImg = lbMediaList[0] ? lbMediaList[0].src : '';

        // Collect uploaded MP4 videos
        var rawVids = [].concat(p.videos || [], window.pdpVideosData || [], p.video ? [p.video] : []);
        rawVids.forEach(function(v) {
            var sv = (typeof v === 'object' && v !== null && v.src) ? String(v.src).trim() : String(v || '').trim();
            if (sv && sv.indexOf('data:') !== 0 && !lbMediaList.some(function(x) { return x.src === sv; })) {
                lbMediaList.push({ kind: 'video', src: sv, poster: posterImg, title: p.name || 'HD Video' });
            }
        });

        // Collect embeds
        var rawEmbs = [].concat(p.embeds || [], p.embed ? [p.embed] : []);
        rawEmbs.forEach(function(em) {
            var sem = (typeof em === 'object' && em !== null && em.src) ? String(em.src).trim() : String(em || '').trim();
            if (sem && !lbMediaList.some(function(x) { return x.src === sem; })) {
                lbMediaList.push({ kind: 'embed', src: sem, title: p.name || 'Featured Video' });
            }
        });
    }

    window.openFullscreenImage = function(startIdx) {
        lbOverlay = document.getElementById('pdpLightboxOverlay');
        lbSlider = document.getElementById('pdpLbSlider');
        lbThumbs = document.getElementById('pdpLbThumbs');
        lbCounter = document.getElementById('pdpLbCounter');
        if (!lbOverlay || !lbSlider) return;

        buildLightboxMedia();
        if (lbMediaList.length === 0) return;

        // Build Slides
        lbSlider.innerHTML = lbMediaList.map(function(item, idx) {
            if (item.kind === 'video') {
                return '<div class="pdp-lb-slide" data-idx="' + idx + '" data-kind="video">' +
                    '<div class="pdp-lb-video-wrap">' +
                        '<video src="' + item.src + '" ' + (item.poster ? 'poster="' + item.poster + '"' : '') + ' controls autoplay playsinline preload="auto"></video>' +
                    '</div>' +
                '</div>';
            } else if (item.kind === 'embed') {
                return '<div class="pdp-lb-slide" data-idx="' + idx + '" data-kind="embed">' +
                    '<div class="pdp-lb-video-wrap">' +
                        '<iframe src="' + item.src + '" title="' + item.title + '" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' +
                    '</div>' +
                '</div>';
            } else {
                return '<div class="pdp-lb-slide" data-idx="' + idx + '" data-kind="image">' +
                    '<img src="' + item.src + '" alt="' + item.title + '" draggable="false" ondblclick="toggleLightboxZoom(this)" />' +
                '</div>';
            }
        }).join('');

        // Build Thumbs
        if (lbThumbs) {
            lbThumbs.innerHTML = lbMediaList.map(function(item, idx) {
                var thumbSrc = item.kind === 'image' ? item.src : (item.poster || (lbMediaList[0] ? lbMediaList[0].src : ''));
                var isVid = item.kind !== 'image';
                return '<div class="pdp-lb-thumb ' + (idx === 0 ? 'active' : '') + '" data-idx="' + idx + '" onclick="goToLightboxSlide(' + idx + ')">' +
                    '<img src="' + thumbSrc + '" alt="Thumb ' + (idx + 1) + '" />' +
                    (isVid ? '<div class="pdp-lb-thumb-video-badge"><svg viewBox="0 0 24 24"><polygon points="6 3 20 12 6 21 6 3"/></svg></div>' : '') +
                '</div>';
            }).join('');
        }

        var targetIdx = typeof startIdx === 'number' ? startIdx : currentSlideIdx;
        if (targetIdx < 0 || targetIdx >= lbMediaList.length) targetIdx = 0;

        lbOverlay.classList.add('open');
        lbOverlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        window.goToLightboxSlide(targetIdx);
        bindLightboxEvents();
    };

    window.closeFullscreenImage = function() {
        if (!lbOverlay) lbOverlay = document.getElementById('pdpLightboxOverlay');
        if (lbOverlay) {
            lbOverlay.classList.remove('open');
            lbOverlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';

            // Pause all videos
            if (lbSlider) {
                lbSlider.querySelectorAll('video').forEach(function(v) { v.pause(); });
                lbSlider.querySelectorAll('iframe').forEach(function(f) {
                    var s = f.src; f.src = s;
                });
            }
            window.resetLightboxZoom();
        }
    };

    window.goToLightboxSlide = function(idx) {
        if (!lbSlider || lbMediaList.length === 0) return;
        lbCurrentIdx = ((idx % lbMediaList.length) + lbMediaList.length) % lbMediaList.length;

        lbSlider.style.transform = 'translateX(-' + (lbCurrentIdx * 100) + '%)';

        if (lbCounter) {
            lbCounter.textContent = (lbCurrentIdx + 1) + ' / ' + lbMediaList.length;
        }

        // Update active thumb
        if (lbThumbs) {
            lbThumbs.querySelectorAll('.pdp-lb-thumb').forEach(function(th, i) {
                var isActive = (i === lbCurrentIdx);
                th.classList.toggle('active', isActive);
                if (isActive) {
                    var offset = th.offsetLeft - (lbThumbs.clientWidth / 2) + (th.clientWidth / 2);
                    lbThumbs.scrollTo({ left: Math.max(0, offset), behavior: 'smooth' });
                }
            });
        }

        // Manage video play/pause
        lbSlider.querySelectorAll('.pdp-lb-slide').forEach(function(sl, i) {
            var vid = sl.querySelector('video');
            if (vid) {
                if (i === lbCurrentIdx) {
                    vid.play().catch(function() {});
                } else {
                    vid.pause();
                }
            }
        });

        window.resetLightboxZoom();
    };

    window.navigateLightbox = function(delta) {
        window.goToLightboxSlide(lbCurrentIdx + delta);
    };

    window.resetLightboxZoom = function() {
        lbZoomScale = 1;
        if (!lbSlider) return;
        var activeSlide = lbSlider.querySelector('.pdp-lb-slide[data-idx="' + lbCurrentIdx + '"]');
        if (activeSlide) {
            var img = activeSlide.querySelector('img');
            if (img) {
                img.style.transform = 'scale(1)';
                img.classList.remove('zoomed');
            }
        }
    };

    window.zoomLightbox = function(delta) {
        if (!lbSlider) return;
        var activeSlide = lbSlider.querySelector('.pdp-lb-slide[data-idx="' + lbCurrentIdx + '"]');
        if (!activeSlide) return;
        var img = activeSlide.querySelector('img');
        if (!img) return;

        lbZoomScale = Math.min(3, Math.max(1, lbZoomScale + delta));
        img.style.transform = 'scale(' + lbZoomScale + ')';
        img.classList.toggle('zoomed', lbZoomScale > 1);
    };

    window.toggleLightboxZoom = function(img) {
        if (!img) return;
        if (lbZoomScale > 1) {
            window.resetLightboxZoom();
        } else {
            window.zoomLightbox(1);
        }
    };

    function bindLightboxEvents() {
        if (lbEventsBound) return;
        lbEventsBound = true;

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (!lbOverlay || !lbOverlay.classList.contains('open')) return;
            if (e.key === 'Escape') {
                window.closeFullscreenImage();
            } else if (e.key === 'ArrowRight') {
                window.navigateLightbox(1);
            } else if (e.key === 'ArrowLeft') {
                window.navigateLightbox(-1);
            }
        });

        // Touch Swipe
        var vp = document.getElementById('pdpLbViewport');
        if (vp) {
            var touchStartX = 0, touchEndX = 0;
            vp.addEventListener('touchstart', function(e) {
                touchStartX = e.touches[0].clientX;
            }, { passive: true });
            vp.addEventListener('touchend', function(e) {
                touchEndX = e.changedTouches[0].clientX;
                var diff = touchEndX - touchStartX;
                if (diff < -50) {
                    window.navigateLightbox(1);
                } else if (diff > 50) {
                    window.navigateLightbox(-1);
                }
            }, { passive: true });
        }
    }

    function restoreUserSavedAddress() {
        var nameField = document.getElementById('pdpWaName');
        var phoneField = document.getElementById('pdpWaPhone');
        var addrField = document.getElementById('pdpWaAddress');
        var cityField = document.getElementById('pdpWaCity');
        var stateField = document.getElementById('pdpWaState');
        var pinField = document.getElementById('pdpWaPincode');

        var savedAddrRaw = localStorage.getItem('dtbrands_saved_address');
        var userRaw = localStorage.getItem('dtbrands_user');

        var savedAddr = null;
        var user = null;

        try { if (savedAddrRaw) savedAddr = JSON.parse(savedAddrRaw); } catch {
            // Ignore invalid JSON in localStorage
        }
        try { if (userRaw) user = JSON.parse(userRaw); } catch {
            // Ignore invalid JSON in localStorage
        }

        var nameVal = (savedAddr && savedAddr.name) ? savedAddr.name : (user && user.name ? user.name : '');
        var phoneVal = (savedAddr && savedAddr.phone) ? savedAddr.phone : (user && user.phone ? user.phone : '');
        var addrVal = (savedAddr && savedAddr.address) ? savedAddr.address : (user && user.address ? user.address : '');
        var cityVal = (savedAddr && savedAddr.city) ? savedAddr.city : (user && user.city ? user.city : '');
        var stateVal = (savedAddr && savedAddr.state) ? savedAddr.state : (user && user.state ? user.state : '');
        var pinVal = (savedAddr && savedAddr.pincode) ? savedAddr.pincode : (user && user.pincode ? user.pincode : '');

        if (nameField && nameVal) nameField.value = nameVal;
        if (phoneField && phoneVal) {
            var cleanP = phoneVal.replace(/[^0-9]/g, '');
            phoneField.value = cleanP ? cleanP.slice(-10) : '';
        }
        if (addrField && addrVal) addrField.value = addrVal;
        if (cityField && cityVal) cityField.value = cityVal;
        if (stateField && stateVal) stateField.value = stateVal;
        if (pinField && pinVal) pinField.value = pinVal;
    }

    // WhatsApp Quick Order Checkout Modal Engine
    window.togglePdpWaAddressSection = function() {
        var body = document.getElementById('pdpWaAddrBody');
        var wrap = document.getElementById('pdpWaAddrCollapseWrap');
        if (!body || !wrap) return;

        if (body.style.display === 'none' || body.style.display === '') {
            body.style.display = 'flex';
            wrap.classList.add('open');
            var addrInput = document.getElementById('pdpWaAddress');
            if (addrInput) addrInput.focus();
        } else {
            body.style.display = 'none';
            wrap.classList.remove('open');
        }
    };

    window.openPdpWhatsAppOrderModal = function() {
        var modal = document.getElementById('pdpWhatsAppOrderModal');
        if (!modal) return;

        var sel = pdpSelection();

        // Populate Modal Preview Fields. The colour and size rows are only in the
        // markup when the product has variants, so a missing element here means
        // "this product has no such attribute", not "hide the value".
        var colEl = document.getElementById('pdpWaModalColor');
        if (colEl) colEl.textContent = sel.color;
        var sizeEl = document.getElementById('pdpWaModalSize');
        if (sizeEl) sizeEl.textContent = sel.size;
        var qtyEl = document.getElementById('pdpWaModalQty');
        if (qtyEl) qtyEl.textContent = currentQty;
        var prEl = document.getElementById('pdpWaModalPrice');
        var unitPrice = Number(currentProduct.price) || 0;
        if (prEl) prEl.textContent = unitPrice > 0
            ? '₹' + (unitPrice * currentQty).toLocaleString('en-IN')
            : 'Price on request';

        // Hide collapsible address section by default to keep form compact and clean
        var addrBody = document.getElementById('pdpWaAddrBody');
        var addrWrap = document.getElementById('pdpWaAddrCollapseWrap');
        if (addrBody) addrBody.style.display = 'none';
        if (addrWrap) addrWrap.classList.remove('open');

        // Auto-load and prefill saved user billing & delivery info
        restoreUserSavedAddress();

        modal.classList.add('open');
    };

    window.selectPdpWaPayment = function(type) {
        var codCard = document.getElementById('pdpWaPayCodCard');
        var upiCard = document.getElementById('pdpWaPayUpiCard');
        var codRadio = document.getElementById('pdpWaRadioCod');
        var upiRadio = document.getElementById('pdpWaRadioUpi');

        if (type === 'cod') {
            if (codCard) codCard.classList.add('selected');
            if (upiCard) upiCard.classList.remove('selected');
            if (codRadio) codRadio.checked = true;
        } else {
            if (upiCard) upiCard.classList.add('selected');
            if (codCard) codCard.classList.remove('selected');
            if (upiRadio) upiRadio.checked = true;
        }
    };

    window.closePdpWhatsAppOrderModal = function() {
        var modal = document.getElementById('pdpWhatsAppOrderModal');
        if (modal) modal.classList.remove('open');
    };

    window.submitPdpWhatsAppOrder = function(e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }

        var nameInput = document.getElementById('pdpWaName');
        var phoneInput = document.getElementById('pdpWaPhone');
        var addressInput = document.getElementById('pdpWaAddress');
        var cityInput = document.getElementById('pdpWaCity');
        var stateInput = document.getElementById('pdpWaState');
        var pinInput = document.getElementById('pdpWaPincode');

        var name = nameInput ? nameInput.value.trim() : '';
        var rawPhone = phoneInput ? phoneInput.value.trim() : '';
        var address = addressInput ? addressInput.value.trim() : '';
        var city = cityInput ? cityInput.value.trim() : '';
        var state = stateInput ? stateInput.value.trim() : '';
        var pincode = pinInput ? pinInput.value.trim() : '';
        var payMethodEl = document.querySelector('input[name="pdpWaPayment"]:checked');
        var paymentMethod = payMethodEl ? payMethodEl.value : 'Cash on Delivery (COD)';

        if (!name) {
            window.showToast('⚠️ Please enter Customer Full Name.');
            if (nameInput) nameInput.focus();
            return;
        }

        // Clean phone number (handles +91, spaces, 0 prefix, dashes)
        var cleanPhone = rawPhone.replace(/[^0-9]/g, '');
        if (cleanPhone.length > 10 && cleanPhone.startsWith('91')) {
            cleanPhone = cleanPhone.substring(2);
        }
        if (cleanPhone.length > 10 && cleanPhone.startsWith('0')) {
            cleanPhone = cleanPhone.substring(1);
        }

        if (cleanPhone.length < 10) {
            window.showToast('⚠️ Please enter a valid 10-digit WhatsApp mobile number.');
            if (phoneInput) phoneInput.focus();
            return;
        }

        // Save address locally if entered
        if (address || city) {
            try {
                localStorage.setItem('dtbrands_saved_address', JSON.stringify({
                    name: name,
                    phone: cleanPhone,
                    address: address,
                    city: city,
                    state: state,
                    pincode: pincode
                }));
            } catch {
                // Storage quota exceeded or disabled
            }
        }

        var sel = pdpSelection();

        var unitPrice = Number(currentProduct.price) || 0;
        var totalPrice = (unitPrice * currentQty).toLocaleString('en-IN');
        var productUrl = window.location.href;
        var fullLoc = city ? (city + (state ? (", " + state) : "") + (pincode ? (" - " + pincode) : "")) : '';

        // Build WhatsApp Message. The SKU line used to fall back to the literal
        // 'KLN-ETH-01', and Color / Size printed 'Standard' / 'Free Size' for
        // products with no such variant -- the shop then had to guess what the
        // customer had actually ordered.
        var waMessage = "🛍️ *NEW INSTANT ORDER — DT BRAND'S LUXURY ETHNIC*\n" +
            "━━━━━━━━━━━━━━━━━━━━\n" +
            "👗 *Product:* " + (currentProduct.name || 'Product') + "\n";
        if (currentProduct.sku) {
            waMessage += "🏷️ *SKU:* " + currentProduct.sku + "\n";
        }
        if (sel.color) {
            waMessage += "🎨 *Color:* " + sel.color + "\n";
        }
        if (sel.size) {
            waMessage += "📏 *Size:* " + sel.size + "\n";
        }
        waMessage += "🔢 *Quantity:* " + currentQty + "\n" +
            (unitPrice > 0
                ? "💰 *Total Amount:* ₹" + totalPrice + "\n"
                : "💰 *Total Amount:* to be confirmed\n") +
            "━━━━━━━━━━━━━━━━━━━━\n" +
            "👤 *Customer:* " + name + "\n" +
            "📱 *WhatsApp Phone:* +91 " + cleanPhone + "\n";

        if (address) {
            waMessage += "🏠 *Full Address:* " + address + "\n";
        }
        if (fullLoc) {
            waMessage += "🏙️ *Location:* " + fullLoc + "\n";
        }
        if (!address && !fullLoc) {
            waMessage += "📍 *Delivery Address:* Will share directly on WhatsApp chat\n";
        }

        waMessage += "💳 *Payment Preference:* " + paymentMethod + "\n" +
            "━━━━━━━━━━━━━━━━━━━━\n" +
            "🔗 *Item Link:* " + productUrl + "\n\n" +
            "Please confirm my order and share estimated dispatch details. Thank you! 🙏✨";

        var waNumber = window.pdpWhatsAppNumber || '917046363528';
        var waUrl = "https://api.whatsapp.com/send?phone=" + encodeURIComponent(waNumber) + "&text=" + encodeURIComponent(waMessage);

        window.closePdpWhatsAppOrderModal();
        window.showToast('🚀 Opening WhatsApp to confirm your order...');

        setTimeout(function() {
            window.open(waUrl, '_blank');
        }, 250);
    };

    // Size Guide Modal with Dynamic Highlight & Unit Switcher
    window.switchSizeUnits = function(unit) {
        var isCm = (unit === 'cm');
        var tabIn = document.getElementById('unitTabIn');
        var tabCm = document.getElementById('unitTabCm');
        if (tabIn) tabIn.classList.toggle('active', !isCm);
        if (tabCm) tabCm.classList.toggle('active', isCm);

        document.querySelectorAll('#pdpSizeTable tbody tr td[data-in]').forEach(function(cell) {
            cell.textContent = isCm ? cell.getAttribute('data-cm') : cell.getAttribute('data-in');
        });
    };

    window.openSizeGuideModal = function() {
        var modal = document.getElementById('pdpSizeChartModal') || document.getElementById('pdpSizeGuideModal');
        if (modal) {
            // Highlight current chosen size row
            var curSel = (typeof window.pdpSelection === 'function') ? window.pdpSelection() : { size: '' };
            var activeSize = String(curSel.size || '').toLowerCase().trim();
            document.querySelectorAll('#pdpSizeTable tbody tr').forEach(function(row) {
                var rowSize = String(row.getAttribute('data-size') || '').toLowerCase().trim();
                var isMatch = activeSize && (rowSize === activeSize || activeSize.indexOf(rowSize) === 0 || rowSize.indexOf(activeSize) === 0);
                row.classList.toggle('highlight-selected', !!isMatch);
            });

            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
            document.body.classList.add('pdp-popup-active');
            if (typeof window.hidePdpMobileBar === 'function') window.hidePdpMobileBar();
        }
    };
    window.closeSizeGuideModal = function() {
        var modal = document.getElementById('pdpSizeChartModal') || document.getElementById('pdpSizeGuideModal');
        if (modal) {
            modal.classList.remove('open');
            document.body.style.overflow = '';
            document.body.classList.remove('pdp-popup-active');
            if (typeof window.showPdpMobileBar === 'function') window.showPdpMobileBar();
        }
    };

    // Write Review Modal
    var currentSelectedRating = 5;
    window.openWriteReviewModal = function() {
        var modal = document.getElementById('pdpWriteReviewModal');
        if (modal) {
            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
            document.body.classList.add('pdp-popup-active');
            if (typeof window.hidePdpMobileBar === 'function') window.hidePdpMobileBar();
        }
    };
    window.closeWriteReviewModal = function() {
        var modal = document.getElementById('pdpWriteReviewModal');
        if (modal) {
            modal.classList.remove('open');
            document.body.style.overflow = '';
            document.body.classList.remove('pdp-popup-active');
            if (typeof window.showPdpMobileBar === 'function') window.showPdpMobileBar();
        }
    };

    // Close modals on overlay backdrop click
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList && e.target.classList.contains('pdp-modal-overlay')) {
            e.target.classList.remove('open');
            document.body.style.overflow = '';
            document.body.classList.remove('pdp-popup-active');
            if (typeof window.showPdpMobileBar === 'function') window.showPdpMobileBar();
        }
    });
    window.setReviewRating = function(val) {
        currentSelectedRating = val;
        var stars = document.querySelectorAll('#pdpStarRatingSelector span');
        stars.forEach(function(s, idx) {
            s.style.opacity = (idx < val) ? '1' : '0.3';
        });
    };

    // Submit a review to api/reviews.php.
    //
    // This function used to store nothing at all: it built a review card in the
    // DOM -- stamped "Verified", dated "Just now", with an invented city, an
    // invented occasion ("Festive Celebration") and a helpful count of 1 -- then
    // toasted "Thank you! Your review is now live." The review was never sent
    // anywhere, so it vanished on reload, never reached admin/reviews/pending.php,
    // and the shopper was told their review was published when it was not.
    window.submitCustomerReview = function(e) {
        e.preventDefault();

        var nameEl = document.getElementById('revName');
        var titleEl = document.getElementById('revTitle');
        var textEl = document.getElementById('revText');
        var name = nameEl ? nameEl.value.trim() : '';
        var title = titleEl ? titleEl.value.trim() : '';
        var text = textEl ? textEl.value.trim() : '';

        if (!name || !text) {
            window.showToast('Please add your name and your review.');
            return;
        }

        var productId = Number(currentProduct.id) || 0;
        if (!productId) {
            window.showToast('Could not tell which product this review is for.');
            return;
        }

        var btn = document.getElementById('revSubmitBtn');
        if (btn) { btn.disabled = true; btn.textContent = 'Submitting...'; }

        fetch('/api/reviews.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                product_id: productId,
                name: name,
                rating: currentSelectedRating,
                review_title: title,
                review_text: text
            })
        })
        .then(function(res) { return res.json().catch(function() { return {}; }); })
        .then(function(payload) {
            if (btn) { btn.disabled = false; btn.textContent = 'Submit Review'; }
            if (!payload || payload.success !== true) {
                window.showToast((payload && payload.message) || 'Could not save your review. Please try again.');
                return;
            }
            window.closeWriteReviewModal();
            var form = document.getElementById('pdpReviewForm');
            if (form) form.reset();
            window.setReviewRating(5);
            // The server decides whether the review is published or queued; report
            // whichever actually happened rather than claiming it is live.
            window.showToast(payload.message || (payload.status === 'approved'
                ? 'Thank you! Your review is now published.'
                : 'Thank you! Your review will appear once our team has checked it.'));
            if (payload.status === 'approved') {
                setTimeout(function() { window.location.reload(); }, 1200);
            }
        })
        .catch(function() {
            if (btn) { btn.disabled = false; btn.textContent = 'Submit Review'; }
            window.showToast('Network problem — your review was not saved. Please try again.');
        });
    };

    // Review Filter Pills
    window.filterReviews = function(type, btn) {
        document.querySelectorAll('.pdp-rev-filter-pill').forEach(function(p) { p.classList.remove('active'); });
        btn.classList.add('active');

        // The "With photos" filter was dropped: the reviews table has no photo
        // column, so it matched data-hasphoto="1", which nothing ever sets, and
        // hid every review on the page.
        var cards = document.querySelectorAll('.pdp-review-card');
        cards.forEach(function(card) {
            if (type === 'all') {
                card.style.display = 'flex';
            } else {
                card.style.display = (card.dataset.rating === String(type)) ? 'flex' : 'none';
            }
        });
        window.rebuildReviewDots();
    };

    // ═════════════════════════════════════════════════════════════
    // SMART HAND SCROLLING & AUTO-SLIDER (CUSTOMER REVIEWS)
    // ═════════════════════════════════════════════════════════════
    var revTrack = document.getElementById('pdpReviewsTrack');
    var revDotsWrap = document.getElementById('pdpRevDots');
    var revAutoSlideTimer = null;
    var revResumeTimeout = null;

    window.togglePdpReviewCard = function(btn) {
        var card = btn.closest('.pdp-review-card');
        if (!card) return;
        card.classList.toggle('expanded');
        var span = btn.querySelector('span');
        if (span) {
            span.textContent = card.classList.contains('expanded') ? 'Show Less' : '... Read Full';
        }
    };

    window.rebuildReviewDots = function() {
        if (!revTrack) return;
        var prevBtn = document.getElementById('pdpRevPrev');
        var nextBtn = document.getElementById('pdpRevNext');
        var needsScroll = revTrack.scrollWidth > (revTrack.clientWidth + 10);

        if (window.innerWidth > 900) {
            if (prevBtn) prevBtn.style.display = needsScroll ? 'flex' : 'none';
            if (nextBtn) nextBtn.style.display = needsScroll ? 'flex' : 'none';
        } else {
            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'none';
        }

        if (!revDotsWrap) return;
        revDotsWrap.innerHTML = '';
        var visibleCards = Array.from(revTrack.querySelectorAll('.pdp-review-card')).filter(function(c) {
            return c.style.display !== 'none';
        });

        if (!needsScroll || visibleCards.length <= 1) {
            revDotsWrap.style.display = 'none';
            return;
        }

        revDotsWrap.style.display = 'flex';
        visibleCards.forEach(function(_, idx) {
            var dot = document.createElement('div');
            dot.className = 'pdp-rev-dot ' + (idx === 0 ? 'active' : '');
            dot.onclick = function() {
                var card = visibleCards[idx];
                if (card) {
                    revTrack.scrollTo({ left: card.offsetLeft - revTrack.offsetLeft, behavior: 'smooth' });
                    restartRevAutoSlide();
                }
            };
            revDotsWrap.appendChild(dot);
        });
    };

    window.slidePdpReviews = function(direction) {
        if (!revTrack) return;
        var firstCard = revTrack.querySelector('.pdp-review-card');
        var cardWidth = firstCard ? (firstCard.clientWidth + 16) : 320;
        var maxScroll = revTrack.scrollWidth - revTrack.clientWidth;
        var newLeft = revTrack.scrollLeft + (direction * cardWidth);

        if (newLeft > maxScroll + 10) {
            revTrack.scrollTo({ left: 0, behavior: 'smooth' });
        } else if (newLeft < 0) {
            revTrack.scrollTo({ left: maxScroll, behavior: 'smooth' });
        } else {
            revTrack.scrollTo({ left: newLeft, behavior: 'smooth' });
        }
    };

    function startReviewAutoSlide() {
        if (revAutoSlideTimer) clearInterval(revAutoSlideTimer);
        if (!revTrack || revTrack.scrollWidth <= (revTrack.clientWidth + 10)) return;
        revAutoSlideTimer = setInterval(function() {
            var carouselWrap = document.getElementById('pdpRevCarouselWrap');
            if (carouselWrap && !isElementInViewport(carouselWrap)) return;
            window.slidePdpReviews(1);
        }, 5500);
    }

    function pauseReviewAutoSlide() {
        if (revAutoSlideTimer) {
            clearInterval(revAutoSlideTimer);
            revAutoSlideTimer = null;
        }
        if (revResumeTimeout) {
            clearTimeout(revResumeTimeout);
            revResumeTimeout = null;
        }
    }

    function restartRevAutoSlide() {
        pauseReviewAutoSlide();
        revResumeTimeout = setTimeout(startReviewAutoSlide, 3500);
    }

    if (revTrack) {
        setTimeout(window.rebuildReviewDots, 200);
        window.addEventListener('resize', window.rebuildReviewDots);
        startReviewAutoSlide();

        // Pause on hover
        var carouselWrap = document.getElementById('pdpRevCarouselWrap');
        if (carouselWrap) {
            carouselWrap.addEventListener('mouseenter', pauseReviewAutoSlide);
            carouselWrap.addEventListener('mouseleave', startReviewAutoSlide);
        }

        // Native Smooth Touch Scrolling on Mobile
        revTrack.addEventListener('touchstart', function() {
            pauseReviewAutoSlide();
        }, { passive: true });

        revTrack.addEventListener('touchend', function() {
            restartRevAutoSlide();
        }, { passive: true });

        // Physics-Based Momentum Drag on Desktop
        var isRevMouseDown = false;
        var revStartX = 0;
        var revStartScrollLeft = 0;
        var revVelocity = 0;
        var revLastX = 0;
        var revLastTime = 0;
        var revMomentumId = null;

        revTrack.addEventListener('mousedown', function(e) {
            pauseReviewAutoSlide();
            if (revMomentumId) cancelAnimationFrame(revMomentumId);
            isRevMouseDown = true;
            revStartX = e.pageX - revTrack.offsetLeft;
            revStartScrollLeft = revTrack.scrollLeft;
            revLastX = e.pageX;
            revLastTime = Date.now();
            revVelocity = 0;
            revTrack.classList.add('dragging');
        });

        window.addEventListener('mousemove', function(e) {
            if (!isRevMouseDown) return;
            e.preventDefault();
            var x = e.pageX - revTrack.offsetLeft;
            var walk = (x - revStartX) * 1.35;
            revTrack.scrollLeft = revStartScrollLeft - walk;

            var now = Date.now();
            var dt = now - revLastTime;
            if (dt > 0) {
                revVelocity = (e.pageX - revLastX) / dt;
                revLastX = e.pageX;
                revLastTime = now;
            }
        });

        window.addEventListener('mouseup', function() {
            if (!isRevMouseDown) return;
            isRevMouseDown = false;
            revTrack.classList.remove('dragging');

            if (Math.abs(revVelocity) > 0.2) {
                var currentVelocity = revVelocity * 15;
                function applyMomentum() {
                    if (Math.abs(currentVelocity) < 0.4) {
                        restartRevAutoSlide();
                        return;
                    }
                    revTrack.scrollLeft -= currentVelocity;
                    currentVelocity *= 0.92;
                    revMomentumId = requestAnimationFrame(applyMomentum);
                }
                revMomentumId = requestAnimationFrame(applyMomentum);
            } else {
                restartRevAutoSlide();
            }
        });

        function updateRevScrollShadows() {
            var wrap = document.getElementById('pdpRevCarouselWrap');
            if (!wrap || !revTrack) return;
            var maxScroll = revTrack.scrollWidth - revTrack.clientWidth;
            if (maxScroll <= 6) {
                wrap.classList.remove('has-left-shadow', 'has-right-shadow');
                return;
            }
            if (revTrack.scrollLeft > 10) {
                wrap.classList.add('has-left-shadow');
            } else {
                wrap.classList.remove('has-left-shadow');
            }
            if (revTrack.scrollLeft < maxScroll - 10) {
                wrap.classList.add('has-right-shadow');
            } else {
                wrap.classList.remove('has-right-shadow');
            }
        }

        setTimeout(updateRevScrollShadows, 300);
        window.addEventListener('resize', updateRevScrollShadows);

        // Real-Time Active Center Card & Scroll Kinetic Effects
        var revScrollEndTimer = null;
        revTrack.addEventListener('scroll', function() {
            updateRevScrollShadows();
            revTrack.classList.add('is-scrolling');
            if (revScrollEndTimer) clearTimeout(revScrollEndTimer);
            revScrollEndTimer = setTimeout(function() {
                revTrack.classList.remove('is-scrolling');
            }, 180);

            var cards = revTrack.querySelectorAll('.pdp-review-card');
            var trackCenter = revTrack.scrollLeft + (revTrack.clientWidth / 2);
            var closestCard = null;
            var minDiff = Infinity;
            var closestIdx = 0;

            cards.forEach(function(card, idx) {
                var cardCenter = card.offsetLeft + (card.clientWidth / 2);
                var diff = Math.abs(trackCenter - cardCenter);
                if (diff < minDiff) {
                    minDiff = diff;
                    closestCard = card;
                    closestIdx = idx;
                }
                card.classList.remove('is-active-card');
            });

            if (closestCard) {
                closestCard.classList.add('is-active-card');
            }

            var dots = document.querySelectorAll('.pdp-rev-dot');
            dots.forEach(function(d, i) {
                d.classList.toggle('active', i === closestIdx);
            });
        }, { passive: true });
    }

    // ═════════════════════════════════════════════════════════════
    // SMART HAND SCROLLING & AUTO-SLIDER (YOU MAY ALSO ADMIRE)
    // ═════════════════════════════════════════════════════════════
    var relTrack = document.getElementById('pdpRelTrack');
    var relDotsWrap = document.getElementById('pdpRelDots');
    var relAutoSlideTimer = null;
    var relResumeTimeout = null;

    window.rebuildRelDots = function() {
        if (!relTrack) return;
        var prevBtn = document.getElementById('pdpRelPrev');
        var nextBtn = document.getElementById('pdpRelNext');
        var needsScroll = relTrack.scrollWidth > (relTrack.clientWidth + 10);

        if (window.innerWidth > 900) {
            if (prevBtn) prevBtn.style.display = needsScroll ? 'flex' : 'none';
            if (nextBtn) nextBtn.style.display = needsScroll ? 'flex' : 'none';
        } else {
            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'none';
        }

        if (!relDotsWrap) return;
        relDotsWrap.innerHTML = '';
        var cards = relTrack.querySelectorAll('.pdp-rel-card');
        var step = window.innerWidth <= 767 ? 2 : 4;
        var totalDots = Math.ceil(cards.length / step);

        if (!needsScroll || totalDots <= 1) {
            relDotsWrap.style.display = 'none';
            return;
        }

        relDotsWrap.style.display = 'flex';
        for (var i = 0; i < totalDots; i++) {
            (function(idx) {
                var dot = document.createElement('div');
                dot.className = 'pdp-rel-dot ' + (idx === 0 ? 'active' : '');
                dot.onclick = function() {
                    var targetCard = cards[idx * step] || cards[cards.length - 1];
                    if (targetCard) {
                        relTrack.scrollTo({ left: targetCard.offsetLeft - relTrack.offsetLeft, behavior: 'smooth' });
                        restartRelAutoSlide();
                    }
                };
                relDotsWrap.appendChild(dot);
            })(i);
        }
    };

    window.slidePdpRelated = function(direction) {
        if (!relTrack) return;
        var firstCard = relTrack.querySelector('.pdp-rel-card');
        var cardWidth = firstCard ? (firstCard.clientWidth + 12) : 200;
        var scrollAmount = cardWidth * (window.innerWidth <= 767 ? 2 : 3);
        var maxScroll = relTrack.scrollWidth - relTrack.clientWidth;
        var newLeft = relTrack.scrollLeft + (direction * scrollAmount);

        if (newLeft > maxScroll + 10) {
            relTrack.scrollTo({ left: 0, behavior: 'smooth' });
        } else if (newLeft < 0) {
            relTrack.scrollTo({ left: maxScroll, behavior: 'smooth' });
        } else {
            relTrack.scrollTo({ left: newLeft, behavior: 'smooth' });
        }
    };

    function startRelAutoSlide() {
        if (relAutoSlideTimer) clearInterval(relAutoSlideTimer);
        if (!relTrack || relTrack.scrollWidth <= (relTrack.clientWidth + 10)) return;
        relAutoSlideTimer = setInterval(function() {
            var relWrap = document.getElementById('pdpRelCarouselWrap');
            if (relWrap && !isElementInViewport(relWrap)) return;
            window.slidePdpRelated(1);
        }, 5500);
    }

    function pauseRelAutoSlide() {
        if (relAutoSlideTimer) {
            clearInterval(relAutoSlideTimer);
            relAutoSlideTimer = null;
        }
        if (relResumeTimeout) {
            clearTimeout(relResumeTimeout);
            relResumeTimeout = null;
        }
    }

    function restartRelAutoSlide() {
        pauseRelAutoSlide();
        relResumeTimeout = setTimeout(startRelAutoSlide, 3500);
    }

    if (relTrack) {
        window.rebuildRelDots();
        startRelAutoSlide();

        var relWrap = document.getElementById('pdpRelCarouselWrap');
        if (relWrap) {
            relWrap.addEventListener('mouseenter', pauseRelAutoSlide);
            relWrap.addEventListener('mouseleave', startRelAutoSlide);
        }

        // Native Smooth Touch on Mobile
        relTrack.addEventListener('touchstart', function() {
            pauseRelAutoSlide();
        }, { passive: true });

        relTrack.addEventListener('touchend', function() {
            restartRelAutoSlide();
        }, { passive: true });

        // Physics-Based Momentum Drag on Desktop
        var isRelMouseDown = false;
        var relStartX = 0;
        var relStartScrollLeft = 0;
        var relVelocity = 0;
        var relLastX = 0;
        var relLastTime = 0;
        var relMomentumId = null;

        relTrack.addEventListener('mousedown', function(e) {
            pauseRelAutoSlide();
            if (relMomentumId) cancelAnimationFrame(relMomentumId);
            isRelMouseDown = true;
            relStartX = e.pageX - relTrack.offsetLeft;
            relStartScrollLeft = relTrack.scrollLeft;
            relLastX = e.pageX;
            relLastTime = Date.now();
            relVelocity = 0;
            relTrack.classList.add('dragging');
        });

        window.addEventListener('mousemove', function(e) {
            if (!isRelMouseDown) return;
            e.preventDefault();
            var x = e.pageX - relTrack.offsetLeft;
            var walk = (x - relStartX) * 1.35;
            relTrack.scrollLeft = relStartScrollLeft - walk;

            var now = Date.now();
            var dt = now - relLastTime;
            if (dt > 0) {
                relVelocity = (e.pageX - relLastX) / dt;
                relLastX = e.pageX;
                relLastTime = now;
            }
        });

        window.addEventListener('mouseup', function() {
            if (!isRelMouseDown) return;
            isRelMouseDown = false;
            relTrack.classList.remove('dragging');

            if (Math.abs(relVelocity) > 0.2) {
                var currentVelocity = relVelocity * 15;
                function applyRelMomentum() {
                    if (Math.abs(currentVelocity) < 0.4) {
                        restartRelAutoSlide();
                        return;
                    }
                    relTrack.scrollLeft -= currentVelocity;
                    currentVelocity *= 0.92;
                    relMomentumId = requestAnimationFrame(applyRelMomentum);
                }
                relMomentumId = requestAnimationFrame(applyRelMomentum);
            } else {
                restartRelAutoSlide();
            }
        });

        function updateRelScrollShadows() {
            var wrap = document.getElementById('pdpRelCarouselWrap');
            if (!wrap || !relTrack) return;
            var maxScroll = relTrack.scrollWidth - relTrack.clientWidth;
            if (maxScroll <= 6) {
                wrap.classList.remove('has-left-shadow', 'has-right-shadow');
                return;
            }
            if (relTrack.scrollLeft > 10) {
                wrap.classList.add('has-left-shadow');
            } else {
                wrap.classList.remove('has-left-shadow');
            }
            if (relTrack.scrollLeft < maxScroll - 10) {
                wrap.classList.add('has-right-shadow');
            } else {
                wrap.classList.remove('has-right-shadow');
            }
        }

        setTimeout(updateRelScrollShadows, 300);
        window.addEventListener('resize', updateRelScrollShadows);

        // Sync related dots, active center card, and transition shadows on scroll
        var relScrollEndTimer = null;
        relTrack.addEventListener('scroll', function() {
            updateRelScrollShadows();
            relTrack.classList.add('is-scrolling');
            if (relScrollEndTimer) clearTimeout(relScrollEndTimer);
            relScrollEndTimer = setTimeout(function() {
                relTrack.classList.remove('is-scrolling');
            }, 180);

            var cards = relTrack.querySelectorAll('.pdp-rel-card');
            var trackCenter = relTrack.scrollLeft + (relTrack.clientWidth / 2);
            var closestCard = null;
            var minDiff = Infinity;
            var closestIdx = 0;

            cards.forEach(function(card, idx) {
                var cardCenter = card.offsetLeft + (card.clientWidth / 2);
                var diff = Math.abs(trackCenter - cardCenter);
                if (diff < minDiff) {
                    minDiff = diff;
                    closestCard = card;
                    closestIdx = idx;
                }
                card.classList.remove('is-active-card');
            });

            if (closestCard) {
                closestCard.classList.add('is-active-card');
            }

            var step = window.innerWidth <= 767 ? 2 : 4;
            var activeDotIdx = Math.floor(closestIdx / step);
            var dots = document.querySelectorAll('.pdp-rel-dot');
            dots.forEach(function(d, i) {
                d.classList.toggle('active', i === activeDotIdx);
            });
        }, { passive: true });

        window.addEventListener('resize', window.rebuildRelDots, { passive: true });
    }

    // Modal background click dismiss
    var writeRevModal = document.getElementById('pdpWriteReviewModal');
    if (writeRevModal) {
        writeRevModal.addEventListener('click', function(e) {
            if (e.target === writeRevModal) window.closeWriteReviewModal();
        });
    }

    var sizeModal = document.getElementById('pdpSizeChartModal');
    if (sizeModal) {
        sizeModal.addEventListener('click', function(e) {
            if (e.target === sizeModal) window.closeSizeGuideModal();
        });
    }

})();
