
(function() {
    'use strict';

    var currentProduct = window.currentProductData || {};
    window.currentPdpProduct = currentProduct;

    // Toast helper
    window.showToast = function(msg) {
        var c = document.getElementById('toastContainer');
        if (!c) return;
        var t = document.createElement('div');
        t.className = 'toast';
        t.textContent = msg;
        c.appendChild(t);
        requestAnimationFrame(function() {
            requestAnimationFrame(function() { t.classList.add('show'); });
        });
        setTimeout(function() {
            t.classList.remove('show');
            setTimeout(function() { t.remove(); }, 350);
        }, 2200);
    };

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

    // Generate Gallery Dots
    function buildGalleryDots() {
        if (!dotsWrap) return;
        dotsWrap.innerHTML = '';
        for (var i = 0; i < totalSlides; i++) {
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

    window.slidePdpGallery = function(delta) {
        window.goToSlide(currentSlideIdx + delta);
    };

    function updateActiveThumbnail(idx) {
        document.querySelectorAll('.pdp-thumb-item').forEach(function(item, i) {
            item.classList.toggle('active', i === idx);
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
            window.slidePdpGallery(1);
        }, 3600);
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

        track.addEventListener('touchend', function(e) {
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

    // Color Selector
    window.selectPdpColor = function(btn) {
        document.querySelectorAll('.pdp-color-btn').forEach(function(b) { b.classList.remove('active'); });
        btn.classList.add('active');
        var nameEl = document.getElementById('pdpSelectedColorName');
        if (nameEl) nameEl.textContent = btn.dataset.color;
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
        if (currentQty > 10) currentQty = 10;
        var qEl = document.getElementById('pdpQtyVal');
        if (qEl) qEl.textContent = currentQty;
    };

    // Accordion Toggle
    window.togglePdpAcc = function(headerBtn) {
        var parentItem = headerBtn.closest('.pdp-acc-item');
        if (parentItem) {
            var isOpen = parentItem.classList.toggle('open');
            headerBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        }
    };

    // Add To Bag Function (Integrates directly with Cart Drawer)
    window.handlePdpAddToCart = function() {
        var activeSizeBtn = document.querySelector('.pdp-size-btn.active');
        var selSize = activeSizeBtn ? activeSizeBtn.dataset.size : (currentProduct.size[0] || 'Free Size');

        var activeColorBtn = document.querySelector('.pdp-color-btn.active');
        var selColor = activeColorBtn ? activeColorBtn.dataset.color : (currentProduct.colors[0] || 'Standard');

        if (typeof window.addToCart === 'function') {
            for (var i = 0; i < currentQty; i++) {
                window.addToCart(currentProduct, selSize, selColor);
            }
        } else {
            // Local fallback
            try {
                var cart = JSON.parse(localStorage.getItem('dtbrands_cart') || '[]');
                cart.push({
                    id: currentProduct.id,
                    name: currentProduct.name,
                    price: currentProduct.price,
                    image: currentProduct.image,
                    size: selSize,
                    color: selColor,
                    qty: currentQty
                });
                localStorage.setItem('dtbrands_cart', JSON.stringify(cart));
            } catch(e) {}
        }

        window.showToast('🛍️ Added ' + currentProduct.name + ' to Bag!');
        if (typeof window.syncPdpHeaderState === 'function') window.syncPdpHeaderState();
        if (typeof window.openCartDrawer === 'function') {
            window.openCartDrawer();
        }
    };

    // Buy Now (Instant Checkout Flow)
    window.handlePdpBuyNow = function() {
        var activeSizeBtn = document.querySelector('.pdp-size-btn.active');
        var selSize = activeSizeBtn ? activeSizeBtn.dataset.size : (currentProduct.size[0] || 'Free Size');

        var activeColorBtn = document.querySelector('.pdp-color-btn.active');
        var selColor = activeColorBtn ? activeColorBtn.dataset.color : (currentProduct.colors[0] || 'Standard');

        if (typeof window.addToCart === 'function') {
            for (var i = 0; i < currentQty; i++) {
                window.addToCart(currentProduct, selSize, selColor);
            }
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

    // Pincode Delivery Estimator
    window.checkPincodeDelivery = function() {
        var input = document.getElementById('pdpPincodeInput');
        var res = document.getElementById('pdpPincodeResult');
        if (!input || !res) return;

        var pin = input.value.trim();
        if (pin.length !== 6 || isNaN(pin)) {
            res.style.display = 'block';
            res.style.color = '#D32F2F';
            res.textContent = '⚠️ Please enter a valid 6-digit Indian pincode.';
            return;
        }

        var d = new Date();
        d.setDate(d.getDate() + 3);
        var dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var dateString = dayNames[d.getDay()] + ', ' + d.getDate() + ' ' + monthNames[d.getMonth()];

        res.style.display = 'block';
        res.style.color = '#2E7D32';
        res.innerHTML = '✅ <strong>Fast Delivery by ' + dateString + '</strong><br />⚡ Fast Express Delivery • 💎 7-Day Fast Exchange • Cash on Delivery Available for ' + pin;
    };

    // Fullscreen Image Lightbox
    window.openFullscreenImage = function() {
        var activeSlide = document.querySelector('.pdp-slide[data-idx="' + currentSlideIdx + '"] img');
        if (activeSlide) {
            window.open(activeSlide.src, '_blank');
        }
    };

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

        try { if (savedAddrRaw) savedAddr = JSON.parse(savedAddrRaw); } catch(e) {}
        try { if (userRaw) user = JSON.parse(userRaw); } catch(e) {}

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

        var activeSizeBtn = document.querySelector('.pdp-size-btn.active');
        var selSize = activeSizeBtn ? activeSizeBtn.dataset.size : (currentProduct.size[0] || 'Free Size');

        var activeColorBtn = document.querySelector('.pdp-color-btn.active');
        var selColor = activeColorBtn ? activeColorBtn.dataset.color : (currentProduct.colors[0] || 'Standard');

        // Populate Modal Preview Fields
        var colEl = document.getElementById('pdpWaModalColor');
        if (colEl) colEl.textContent = selColor;
        var sizeEl = document.getElementById('pdpWaModalSize');
        if (sizeEl) sizeEl.textContent = selSize;
        var qtyEl = document.getElementById('pdpWaModalQty');
        if (qtyEl) qtyEl.textContent = currentQty;
        var prEl = document.getElementById('pdpWaModalPrice');
        if (prEl) prEl.textContent = '₹' + Number(currentProduct.price * currentQty).toLocaleString('en-IN');

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
            } catch(err) {}
        }

        var activeSizeBtn = document.querySelector('.pdp-size-btn.active');
        var selSize = activeSizeBtn ? activeSizeBtn.dataset.size : (currentProduct.size[0] || 'Free Size');

        var activeColorBtn = document.querySelector('.pdp-color-btn.active');
        var selColor = activeColorBtn ? activeColorBtn.dataset.color : (currentProduct.colors[0] || 'Standard');

        var totalPrice = Number(currentProduct.price * currentQty).toLocaleString('en-IN');
        var productUrl = window.location.href;
        var fullLoc = city ? (city + (state ? (", " + state) : "") + (pincode ? (" - " + pincode) : "")) : '';

        // Build WhatsApp Message
        var waMessage = "🛍️ *NEW INSTANT ORDER — DT BRAND'S LUXURY ETHNIC*\n" +
            "━━━━━━━━━━━━━━━━━━━━\n" +
            "👗 *Product:* " + currentProduct.name + "\n" +
            "🏷️ *SKU:* " + (currentProduct.sku || 'KLN-ETH-01') + "\n" +
            "🎨 *Color:* " + selColor + "\n" +
            "📏 *Size:* " + selSize + "\n" +
            "🔢 *Quantity:* " + currentQty + "\n" +
            "💰 *Total Amount:* ₹" + totalPrice + " (Free Fast Delivery 3–5 Days)\n" +
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

        var waUrl = "https://api.whatsapp.com/send?phone=919876543210&text=" + encodeURIComponent(waMessage);

        window.closePdpWhatsAppOrderModal();
        window.showToast('🚀 Opening WhatsApp to confirm your order...');

        setTimeout(function() {
            window.open(waUrl, '_blank');
        }, 250);
    };

    // Size Guide Modal
    window.openSizeGuideModal = function() {
        var modal = document.getElementById('pdpSizeChartModal');
        if (modal) modal.classList.add('open');
    };
    window.closeSizeGuideModal = function() {
        var modal = document.getElementById('pdpSizeChartModal');
        if (modal) modal.classList.remove('open');
    };

    // Write Review Modal
    var currentSelectedRating = 5;
    window.openWriteReviewModal = function() {
        var modal = document.getElementById('pdpWriteReviewModal');
        if (modal) modal.classList.add('open');
    };
    window.closeWriteReviewModal = function() {
        var modal = document.getElementById('pdpWriteReviewModal');
        if (modal) modal.classList.remove('open');
    };

    // Close modals on overlay backdrop click
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList && e.target.classList.contains('pdp-modal-overlay')) {
            e.target.classList.remove('open');
        }
    });
    window.setReviewRating = function(val) {
        currentSelectedRating = val;
        var stars = document.querySelectorAll('#pdpStarRatingSelector span');
        stars.forEach(function(s, idx) {
            s.style.opacity = (idx < val) ? '1' : '0.3';
        });
    };

    window.submitCustomerReview = function(e) {
        e.preventDefault();
        var name = document.getElementById('revName').value.trim();
        var city = document.getElementById('revCity').value.trim() || 'India';
        var occasion = document.getElementById('revOccasion').value.trim() || 'Festive Celebration';
        var text = document.getElementById('revText').value.trim();

        if (!name || !text) return;

        var track = document.getElementById('pdpReviewsTrack');
        if (track) {
            var card = document.createElement('article');
            card.className = 'pdp-review-card';
            card.dataset.rating = currentSelectedRating;
            card.dataset.hasphoto = '0';
            card.innerHTML = 
                '<div class="pdp-rc-top">' +
                    '<div class="pdp-rc-avatar">' + name.charAt(0).toUpperCase() + '</div>' +
                    '<div class="pdp-rc-meta">' +
                        '<div class="pdp-rc-name">' +
                            '<span>' + name + '</span>' +
                        '</div>' +
                        '<span class="pdp-rc-loc-date">' + city + ' • Just now</span>' +
                    '</div>' +
                    '<div class="pdp-rc-rating-right">' +
                        '<span class="pdp-verified-badge">✓ Verified</span>' +
                        '<div class="pdp-rc-stars">' + '★'.repeat(currentSelectedRating) + '</div>' +
                    '</div>' +
                '</div>' +
                '<span class="pdp-rc-occasion">✨ ' + occasion + '</span>' +
                '<p class="pdp-rc-text">"' + text + '"</p>' +
                '<div class="pdp-rc-bottom">' +
                    '<span>Helpful?</span>' +
                    '<button class="pdp-rc-helpful-btn" onclick="toggleHelpful(this, 1)"><span>👍</span><span>(1)</span></button>' +
                '</div>';
            track.insertBefore(card, track.firstChild);
            track.scrollTo({ left: 0, behavior: 'smooth' });
        }

        window.closeWriteReviewModal();
        window.showToast('✨ Thank you! Your review is now live.');
        document.getElementById('pdpReviewForm').reset();
        window.rebuildReviewDots();
    };

    // Helpful upvote button
    window.toggleHelpful = function(btn, currentCount) {
        if (btn.classList.contains('voted')) return;
        btn.classList.add('voted');
        btn.innerHTML = '<span>👍</span><span>(' + (currentCount + 1) + ')</span>';
        window.showToast('❤️ Thank you for your feedback!');
    };

    // Review Filter Pills
    window.filterReviews = function(type, btn) {
        document.querySelectorAll('.pdp-rev-filter-pill').forEach(function(p) { p.classList.remove('active'); });
        btn.classList.add('active');

        var cards = document.querySelectorAll('.pdp-review-card');
        cards.forEach(function(card) {
            if (type === 'all') {
                card.style.display = 'flex';
            } else if (type === '5') {
                card.style.display = (card.dataset.rating === '5') ? 'flex' : 'none';
            } else if (type === 'photo') {
                card.style.display = (card.dataset.hasphoto === '1') ? 'flex' : 'none';
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

    window.rebuildReviewDots = function() {
        if (!revDotsWrap || !revTrack) return;
        revDotsWrap.innerHTML = '';
        var visibleCards = Array.from(revTrack.querySelectorAll('.pdp-review-card')).filter(function(c) {
            return c.style.display !== 'none';
        });

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
        revAutoSlideTimer = setInterval(function() {
            window.slidePdpReviews(1);
        }, 4200);
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
        window.rebuildReviewDots();
        startReviewAutoSlide();

        // Pause on hover
        var carouselWrap = document.getElementById('pdpRevCarouselWrap');
        if (carouselWrap) {
            carouselWrap.addEventListener('mouseenter', pauseReviewAutoSlide);
            carouselWrap.addEventListener('mouseleave', startReviewAutoSlide);
        }

        // Smart Touch Hand Scrolling
        var isRevTouch = false;
        var revTouchStartX = 0, revTouchStartY = 0;
        var revTouchCurrentX = 0;
        var revTouchStartScroll = 0;
        var isRevHorizontal = false;

        revTrack.addEventListener('touchstart', function(e) {
            pauseReviewAutoSlide();
            isRevTouch = true;
            revTouchStartX = e.touches[0].clientX;
            revTouchStartY = e.touches[0].clientY;
            revTouchCurrentX = revTouchStartX;
            revTouchStartScroll = revTrack.scrollLeft;
            isRevHorizontal = false;
        }, { passive: true });

        revTrack.addEventListener('touchmove', function(e) {
            if (!isRevTouch) return;
            revTouchCurrentX = e.touches[0].clientX;
            var diffX = revTouchCurrentX - revTouchStartX;
            var diffY = e.touches[0].clientY - revTouchStartY;

            if (!isRevHorizontal) {
                if (Math.abs(diffX) > 6 || Math.abs(diffY) > 6) {
                    if (Math.abs(diffX) >= Math.abs(diffY)) {
                        isRevHorizontal = true;
                    } else {
                        isRevTouch = false;
                        return;
                    }
                }
            }

            if (isRevHorizontal) {
                if (e.cancelable) e.preventDefault();
                revTrack.scrollLeft = revTouchStartScroll - diffX;
            }
        }, { passive: false });

        revTrack.addEventListener('touchend', function() {
            isRevTouch = false;
            isRevHorizontal = false;
            restartRevAutoSlide();
        }, { passive: true });

        // Mouse Drag on Desktop
        var isRevMouse = false;
        var revMouseStartX = 0;
        var revMouseStartScroll = 0;

        revTrack.addEventListener('mousedown', function(e) {
            pauseReviewAutoSlide();
            isRevMouse = true;
            revMouseStartX = e.clientX;
            revMouseStartScroll = revTrack.scrollLeft;
            revTrack.classList.add('dragging');
        });

        window.addEventListener('mousemove', function(e) {
            if (!isRevMouse) return;
            var diffX = e.clientX - revMouseStartX;
            revTrack.scrollLeft = revMouseStartScroll - diffX;
        });

        window.addEventListener('mouseup', function() {
            if (!isRevMouse) return;
            isRevMouse = false;
            revTrack.classList.remove('dragging');
            restartRevAutoSlide();
        });

        // Sync review dots on scroll
        revTrack.addEventListener('scroll', function() {
            var firstCard = revTrack.querySelector('.pdp-review-card');
            if (!firstCard) return;
            var cardWidth = firstCard.clientWidth + 16;
            var activeIdx = Math.round(revTrack.scrollLeft / cardWidth);
            var dots = document.querySelectorAll('.pdp-rev-dot');
            dots.forEach(function(d, i) {
                d.classList.toggle('active', i === activeIdx);
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
        if (!relDotsWrap || !relTrack) return;
        relDotsWrap.innerHTML = '';
        var cards = relTrack.querySelectorAll('.pdp-rel-card');
        var step = window.innerWidth <= 767 ? 2 : 4;
        var totalDots = Math.ceil(cards.length / step);

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
        relAutoSlideTimer = setInterval(function() {
            window.slidePdpRelated(1);
        }, 4600);
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

        // Smart Touch Hand Scrolling
        var isRelTouch = false;
        var relTouchStartX = 0, relTouchStartY = 0;
        var relTouchCurrentX = 0;
        var relTouchStartScroll = 0;
        var isRelHorizontal = false;

        relTrack.addEventListener('touchstart', function(e) {
            pauseRelAutoSlide();
            isRelTouch = true;
            relTouchStartX = e.touches[0].clientX;
            relTouchStartY = e.touches[0].clientY;
            relTouchCurrentX = relTouchStartX;
            relTouchStartScroll = relTrack.scrollLeft;
            isRelHorizontal = false;
        }, { passive: true });

        relTrack.addEventListener('touchmove', function(e) {
            if (!isRelTouch) return;
            relTouchCurrentX = e.touches[0].clientX;
            var diffX = relTouchCurrentX - relTouchStartX;
            var diffY = e.touches[0].clientY - relTouchStartY;

            if (!isRelHorizontal) {
                if (Math.abs(diffX) > 6 || Math.abs(diffY) > 6) {
                    if (Math.abs(diffX) >= Math.abs(diffY)) {
                        isRelHorizontal = true;
                    } else {
                        isRelTouch = false;
                        return;
                    }
                }
            }

            if (isRelHorizontal) {
                if (e.cancelable) e.preventDefault();
                relTrack.scrollLeft = relTouchStartScroll - diffX;
            }
        }, { passive: false });

        relTrack.addEventListener('touchend', function() {
            isRelTouch = false;
            isRelHorizontal = false;
            restartRelAutoSlide();
        }, { passive: true });

        // Mouse Drag on Desktop
        var isRelMouse = false;
        var relMouseStartX = 0;
        var relMouseStartScroll = 0;

        relTrack.addEventListener('mousedown', function(e) {
            pauseRelAutoSlide();
            isRelMouse = true;
            relMouseStartX = e.clientX;
            relMouseStartScroll = relTrack.scrollLeft;
            relTrack.classList.add('dragging');
        });

        window.addEventListener('mousemove', function(e) {
            if (!isRelMouse) return;
            var diffX = e.clientX - relMouseStartX;
            relTrack.scrollLeft = relMouseStartScroll - diffX;
        });

        window.addEventListener('mouseup', function() {
            if (!isRelMouse) return;
            isRelMouse = false;
            relTrack.classList.remove('dragging');
            restartRelAutoSlide();
        });

        // Sync related dots on scroll
        relTrack.addEventListener('scroll', function() {
            var firstCard = relTrack.querySelector('.pdp-rel-card');
            if (!firstCard) return;
            var cardWidth = firstCard.clientWidth + 12;
            var step = window.innerWidth <= 767 ? 2 : 4;
            var activeIdx = Math.round(relTrack.scrollLeft / (cardWidth * step));
            var dots = document.querySelectorAll('.pdp-rel-dot');
            dots.forEach(function(d, i) {
                d.classList.toggle('active', i === activeIdx);
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
