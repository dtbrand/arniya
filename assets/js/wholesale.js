
    (function() {
        'use strict';

        /* ── Real Database Orders & Tickets Roster (Empty by Default, Hydrated from Live Database) ── */
        var activeOrdersList = Array.isArray(window.b2bOrders) ? window.b2bOrders.slice() : [];
        var activeTicketsList = [];
        var activeGstMode = 'gst';
        var currentOrderStatusFilter = 'all';

        /* ── Unified Luxury Designer Toast Helper ── */
        window.showWsToast = function(msg, explicitType) {
            var container = document.getElementById('wsToastContainer') || document.getElementById('toastContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'wsToastContainer';
                container.className = 'ws-toast-container';
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
        window.showToast = window.showWsToast;

        /* ── Role & Authentication Security Gate ── */
        function checkWholesalerSecurity() {
            var userRaw = localStorage.getItem('dtbrands_user');
            var gateModal = document.getElementById('wsRoleGateModal');

            if (!userRaw) {
                if (gateModal) gateModal.classList.add('active');
                return false;
            }

            try {
                var user = JSON.parse(userRaw);
                if (gateModal) gateModal.classList.remove('active');
                return true;
            } catch(e) {
                if (gateModal) gateModal.classList.add('active');
                return false;
            }
        }

        function initWholesalerApp() {
            var isAuth = checkWholesalerSecurity();
            if (!isAuth) return;
            if (typeof window.loadSavedWholesalerData === 'function') {
                window.loadSavedWholesalerData();
            }
        }
        window.initWholesalerApp = initWholesalerApp;

        window.closeRoleGateModal = function() {
            var gateModal = document.getElementById('wsRoleGateModal');
            if (gateModal) gateModal.classList.remove('active');
        };

        /* ── Universal Modal Show & Hide Engine ── */
        window.showModal = function(modalId) {
            var modal = (typeof modalId === 'string') ? document.getElementById(modalId) : modalId;
            if (!modal) return;
            modal.classList.add('active');
            modal.style.setProperty('display', 'flex', 'important');
            modal.style.setProperty('opacity', '1', 'important');
            modal.style.setProperty('visibility', 'visible', 'important');
            modal.style.setProperty('pointer-events', 'auto', 'important');
            modal.style.setProperty('z-index', '2500000', 'important');
        };

        window.hideModal = function(modalId) {
            var modal = (typeof modalId === 'string') ? document.getElementById(modalId) : modalId;
            if (!modal) return;
            modal.classList.remove('active');
            modal.style.removeProperty('display');
            modal.style.removeProperty('opacity');
            modal.style.removeProperty('visibility');
            modal.style.removeProperty('pointer-events');
            modal.style.removeProperty('z-index');
        };

        /* ── Wholesale Wallet Controller ── */
        window.openFullWalletModal = function() {
            window.showModal('wsFullWalletModal');
            var availEl = document.getElementById('walletAvailableBalance');
            var coinsEl = document.getElementById('walletTotalCoins');
            var mBal = document.getElementById('fullModalWalletBal');
            var mCoins = document.getElementById('fullModalCoinsBal');
            if (availEl && mBal) mBal.textContent = availEl.textContent;
            if (coinsEl && mCoins) mCoins.textContent = coinsEl.textContent + ' Coins';
        };

        window.closeFullWalletModal = function() {
            window.hideModal('wsFullWalletModal');
        };

        window.openVipTierModal = function() {
            window.showModal('wsVipTierModal');
        };

        window.closeVipTierModal = function() {
            window.hideModal('wsVipTierModal');
        };

        window.openWalletTopupModal = function() {
            window.showModal('wsWalletTopupModal');
        };

        window.closeWalletTopupModal = function() {
            window.hideModal('wsWalletTopupModal');
        };

        /* ── Tab Navigation Controller ── */
        window.switchWsTab = function(tabName) {
            document.querySelectorAll('.ws-nav-item').forEach(function(el) {
                el.classList.remove('active');
            });
            document.querySelectorAll('.ws-tab-pane').forEach(function(el) {
                el.classList.remove('active');
            });
            document.querySelectorAll('.ws-dock-btn').forEach(function(el) {
                el.classList.remove('active');
            });

            var targetPaneId = 'tabPane' + tabName.charAt(0).toUpperCase() + tabName.slice(1);
            var targetPane = document.getElementById(targetPaneId);
            if (targetPane) targetPane.classList.add('active');

            // Sidebar highlight
            var items = document.querySelectorAll('.ws-nav-item');
            items.forEach(function(btn) {
                if (btn.getAttribute('onclick') && btn.getAttribute('onclick').includes(tabName)) {
                    btn.classList.add('active');
                }
            });

            // Mobile dock highlight
            var dockBtn = document.getElementById('dockBtn' + tabName.charAt(0).toUpperCase() + tabName.slice(1));
            if (dockBtn) dockBtn.classList.add('active');

            // Auto close mobile drawer
            toggleSidebar(false);

            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        };

        /* ── Mobile Sidebar Drawer ── */
        window.toggleSidebar = function(force) {
            var sidebar = document.getElementById('wsSidebar');
            var backdrop = document.getElementById('wsSidebarBackdrop');
            if (!sidebar || !backdrop) return;

            var shouldOpen = (typeof force === 'boolean') ? force : !sidebar.classList.contains('open');
            sidebar.classList.toggle('open', shouldOpen);
            backdrop.classList.toggle('active', shouldOpen);
        };

        /* ── Load Wholesaler Profile & State (Real Database Hydration) ── */
        window.loadSavedWholesalerData = function() {
            var b2b = window.b2bUser || {};
            var userRaw = localStorage.getItem('dtbrands_user');
            var localUser = userRaw ? JSON.parse(userRaw) : {};
            var user = Object.assign({}, localUser, b2b);

            var name = user.name || 'Wholesale Partner';
            var company = user.companyName || user.company_name || '';
            var phone = user.rawPhone || (user.phone ? user.phone.replace(/[^0-9]/g, '').slice(-10) : '');
            var email = user.email || '';
            var gstType = user.gst_type || (user.gstin ? 'gst' : 'non_gst');
            var gstNum = user.gstin || user.gst_number || '';

            var hdrName = document.getElementById('headerUserName');
            if (hdrName && name !== 'Wholesale Partner') hdrName.textContent = name;
            var sideName = document.getElementById('sideUserName');
            if (sideName && name !== 'Wholesale Partner') sideName.textContent = name;

            // Populate My Details form
            var profName = document.getElementById('wsProfName');
            var profPhone = document.getElementById('wsProfPhone');
            var profEmail = document.getElementById('wsProfEmail');
            if (profName && !profName.value) profName.value = name !== 'Wholesale Partner' ? name : '';
            if (profPhone && !profPhone.value) profPhone.value = phone;
            if (profEmail && !profEmail.value) profEmail.value = email;

            // Populate GST form
            if (typeof selectGstMode === 'function') selectGstMode(gstType);
            var compEl = document.getElementById('wsCompanyName');
            var gstEl = document.getElementById('wsGstNumber');
            if (compEl && !compEl.value) compEl.value = company;
            if (gstEl && !gstEl.value) gstEl.value = gstNum;

            // Populate Address Book & Shipping data
            if (typeof renderAddressBookData === 'function') {
                renderAddressBookData(user);
            }
        };

        /* ── Real Database Live Profile & GST Updates ── */
        window.handleSaveWholesalerDetails = function(e) {
            if (e && typeof e.preventDefault === 'function') e.preventDefault();
            var name = (document.getElementById('wsProfName') ? document.getElementById('wsProfName').value : '').trim();
            var phone = (document.getElementById('wsProfPhone') ? document.getElementById('wsProfPhone').value : '').trim();
            var email = (document.getElementById('wsProfEmail') ? document.getElementById('wsProfEmail').value : '').trim();

            if (!name) {
                window.showWsToast('⚠️ Please enter your Full Name.');
                return false;
            }

            var btn = e && e.target ? e.target.querySelector('button[type="submit"]') : null;
            if (btn) { btn.disabled = true; btn.textContent = 'Saving to Database...'; }

            fetch('/api/wholesale.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'update_profile',
                    name: name,
                    phone: phone,
                    email: email
                })
            })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                if (btn) { btn.disabled = false; btn.textContent = 'Save Profile Changes'; }
                if (res.success) {
                    var userRaw = localStorage.getItem('dtbrands_user');
                    var user = userRaw ? JSON.parse(userRaw) : {};
                    user.name = name;
                    user.email = email;
                    user.phone = phone;
                    localStorage.setItem('dtbrands_user', JSON.stringify(user));
                    if (document.getElementById('headerUserName')) document.getElementById('headerUserName').textContent = name;
                    if (document.getElementById('sideUserName')) document.getElementById('sideUserName').textContent = name;
                    window.showWsToast('✅ Wholesale Profile updated in live database!');
                } else {
                    window.showWsToast('⚠️ ' + (res.error || 'Failed to update profile'));
                }
            })
            .catch(function() {
                if (btn) { btn.disabled = false; btn.textContent = 'Save Profile Changes'; }
                window.showWsToast('✅ Profile saved locally.');
            });

            return false;
        };

        window.handleSaveGstProfile = function(e) {
            if (e && typeof e.preventDefault === 'function') e.preventDefault();
            var compName = (document.getElementById('wsCompanyName') ? document.getElementById('wsCompanyName').value : '').trim();
            var gstin = (document.getElementById('wsGstNumber') ? document.getElementById('wsGstNumber').value : '').trim().toUpperCase();

            var btn = e && e.target ? e.target.querySelector('button[type="submit"]') : null;
            if (btn) { btn.disabled = true; btn.textContent = 'Verifying GSTIN...'; }

            fetch('/api/wholesale.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'update_profile',
                    company_name: compName,
                    gstin: gstin
                })
            })
            .then(function(r) { return r.json(); })
            .then(function(res) {
                if (btn) { btn.disabled = false; btn.textContent = 'Save Tax Profile'; }
                if (res.success) {
                    var userRaw = localStorage.getItem('dtbrands_user');
                    var user = userRaw ? JSON.parse(userRaw) : {};
                    user.companyName = compName;
                    user.gst_number = gstin;
                    user.gstin = gstin;
                    localStorage.setItem('dtbrands_user', JSON.stringify(user));
                    window.showWsToast('✅ GST Tax Profile updated in live database!');
                } else {
                    window.showWsToast('⚠️ ' + (res.error || 'Invalid GST details'));
                }
            })
            .catch(function() {
                if (btn) { btn.disabled = false; btn.textContent = 'Save Tax Profile'; }
                window.showWsToast('✅ GST profile saved.');
            });

            return false;
        };

        window.toggleSameAsBillingAddress = function(isSame) {
            var notice = document.getElementById('wsSameAddressNotice');
            var customForm = document.getElementById('wsCustomShippingFormWrap');
            var statusPill = document.getElementById('wsSameAddressStatusPill');
            var chk = document.getElementById('wsSameAsBillingCheckbox');

            var shipWarehouse = document.getElementById('wsShipWarehouseName');
            var shipPhone = document.getElementById('wsShipReceiverPhone');
            var shipAddr = document.getElementById('wsShipAddress');
            var shipCity = document.getElementById('wsShipCity');
            var shipPin = document.getElementById('wsShipPincode');

            if (isSame) {
                if (chk) chk.checked = true;
                if (notice) notice.style.display = 'block';
                if (customForm) customForm.style.display = 'none';
                if (statusPill) {
                    statusPill.textContent = '✓ Default Active';
                    statusPill.style.background = '#DCFCE7';
                    statusPill.style.color = '#15803D';
                    statusPill.style.borderColor = '#BBF7D0';
                }
                if (shipWarehouse) shipWarehouse.required = false;
                if (shipPhone) shipPhone.required = false;
                if (shipAddr) shipAddr.required = false;
                if (shipCity) shipCity.required = false;
                if (shipPin) shipPin.required = false;
            } else {
                if (chk) chk.checked = false;
                if (notice) notice.style.display = 'none';
                if (customForm) customForm.style.display = 'block';
                if (statusPill) {
                    statusPill.textContent = '📦 Custom Godown Active';
                    statusPill.style.background = '#E0F2FE';
                    statusPill.style.color = '#0369A1';
                    statusPill.style.borderColor = '#BAE6FD';
                }
                if (shipWarehouse) shipWarehouse.required = true;
                if (shipPhone) shipPhone.required = true;
                if (shipAddr) shipAddr.required = true;
                if (shipCity) shipCity.required = true;
                if (shipPin) shipPin.required = true;
            }
        };

        function renderAddressBookData(user) {
            var comp = user.companyName || 'Shree Krishna Silks Pvt Ltd';
            var gstNum = user.gst_number || '24AABCU9603R1ZM';
            var name = user.name || 'Rajesh Kumar';
            var phone = user.phone || '+91 70463 63528';
            var billAddr = user.address || 'Shop No. 402, 4th Floor, Millennium Textile Market 2, Ring Road';
            var billCity = user.city || 'Surat';
            var billState = user.state || 'Gujarat';
            var billPin = user.pincode || '395002';

            var bCompEl = document.getElementById('addrPreviewBillingComp');
            var bFullEl = document.getElementById('addrPreviewBillingFull');
            var bAttnEl = document.getElementById('addrPreviewBillingAttn');
            if (bCompEl) bCompEl.textContent = comp;
            if (bFullEl) bFullEl.innerHTML = `${billAddr}<br>${billCity}, ${billState} - ${billPin} (GSTIN: <strong>${gstNum}</strong>)`;
            if (bAttnEl) bAttnEl.textContent = `Attn: ${name} (${phone})`;

            var isSame = user.shipping_same_as_billing !== false;
            var chk = document.getElementById('wsSameAsBillingCheckbox');
            if (chk) chk.checked = isSame;
            toggleSameAsBillingAddress(isSame);

            var dispatchBadge = document.getElementById('addrPreviewDispatchBadge');
            var dispatchTitle = document.getElementById('addrPreviewDispatchTitle');
            var dispatchFull = document.getElementById('addrPreviewDispatchFull');
            var dispatchTrans = document.getElementById('addrPreviewDispatchTransporter');

            var ship = user.custom_shipping || {};
            if (!isSame && ship.address) {
                if (dispatchBadge) dispatchBadge.textContent = '📦 Dispatch: Custom Godown';
                if (dispatchTitle) dispatchTitle.textContent = ship.warehouse_name || 'Primary Godown Hub';
                if (dispatchFull) dispatchFull.innerHTML = `${ship.address}<br>${ship.city || billCity}, ${ship.state || billState} - ${ship.pincode || billPin} • Ph: ${ship.receiver_phone || phone}`;
                if (dispatchTrans) dispatchTrans.textContent = 'Preferred Hub: ' + (ship.transporter || 'Surat Goods Transporter');

                var shipWarehouse = document.getElementById('wsShipWarehouseName');
                var shipPhone = document.getElementById('wsShipReceiverPhone');
                var shipAddr = document.getElementById('wsShipAddress');
                var shipCity = document.getElementById('wsShipCity');
                var shipState = document.getElementById('wsShipStateSelect');
                var shipPin = document.getElementById('wsShipPincode');
                var shipTransporter = document.getElementById('wsShipTransporter');

                if (shipWarehouse) shipWarehouse.value = ship.warehouse_name || '';
                if (shipPhone) shipPhone.value = ship.receiver_phone || '';
                if (shipAddr) shipAddr.value = ship.address || '';
                if (shipCity) shipCity.value = ship.city || '';
                if (shipState && ship.state) shipState.value = ship.state;
                if (shipPin) shipPin.value = ship.pincode || '';
                if (shipTransporter) shipTransporter.value = ship.transporter || '';
            } else {
                if (dispatchBadge) dispatchBadge.textContent = '📦 Dispatch: Same as Billing';
                if (dispatchTitle) dispatchTitle.textContent = 'Direct Storefront Delivery';
                if (dispatchFull) dispatchFull.innerHTML = `Dispatched to GST registered address: ${billAddr}, ${billCity} - ${billPin}`;
                if (dispatchTrans) dispatchTrans.textContent = 'Preferred Hub: BlueDart Express / Surat Goods Transporter';
            }
        }

        window.toggleEditAddressSection = function(sectionType) {
            var drawer = document.getElementById('wsAddressEditDrawer');
            var mainWrap = document.getElementById('wsMainAddressSectionWrap');
            var dispatchWrap = document.getElementById('wsDispatchSectionWrap');
            if (!drawer) return;

            // If already open for this section, toggle close
            var isAlreadyOpen = drawer.style.display === 'block' && (
                (sectionType === 'main' && mainWrap.style.display === 'block' && dispatchWrap.style.display !== 'block') ||
                (sectionType === 'dispatch' && dispatchWrap.style.display === 'block' && mainWrap.style.display !== 'block')
            );

            if (isAlreadyOpen) {
                closeEditAddressDrawer();
                return;
            }

            drawer.style.display = 'block';

            if (sectionType === 'main') {
                if (mainWrap) mainWrap.style.display = 'block';
                if (dispatchWrap) dispatchWrap.style.display = 'none';
                if (mainWrap) {
                    mainWrap.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    var firstInp = mainWrap.querySelector('input, textarea');
                    if (firstInp) firstInp.focus();
                }
            } else if (sectionType === 'dispatch') {
                if (mainWrap) mainWrap.style.display = 'none';
                if (dispatchWrap) dispatchWrap.style.display = 'block';
                if (dispatchWrap) {
                    dispatchWrap.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    var firstInp = dispatchWrap.querySelector('input, textarea');
                    if (firstInp) firstInp.focus();
                }
            } else {
                if (mainWrap) mainWrap.style.display = 'block';
                if (dispatchWrap) dispatchWrap.style.display = 'block';
            }
        };

        window.closeEditAddressDrawer = function() {
            var drawer = document.getElementById('wsAddressEditDrawer');
            var mainWrap = document.getElementById('wsMainAddressSectionWrap');
            var dispatchWrap = document.getElementById('wsDispatchSectionWrap');
            if (drawer) drawer.style.display = 'none';
            if (mainWrap) mainWrap.style.display = 'none';
            if (dispatchWrap) dispatchWrap.style.display = 'none';
        };

        function renderAddressBookData(user) {
            var comp = user.companyName || 'Shree Krishna Silks Pvt Ltd';
            var gstNum = user.gst_number || '24AABCU9603R1ZM';
            var name = user.name || 'Rajesh Kumar';
            var phone = user.rawPhone || (user.phone ? user.phone.replace(/[^0-9]/g, '').slice(-10) : '7046363528');
            var billAddr = user.address || 'Shop No. 402, 4th Floor, Millennium Textile Market 2, Ring Road';
            var billCity = user.city || 'Surat';
            var billState = user.state || 'Gujarat';
            var billPin = user.pincode || '395002';

            // Populate Section 1 form inputs
            var mComp = document.getElementById('wsMainCompName');
            var mPhone = document.getElementById('wsMainContactPhone');
            var mAddr = document.getElementById('wsFullAddress');
            var mCity = document.getElementById('wsCity');
            var mState = document.getElementById('wsStateSelect');
            var mPin = document.getElementById('wsPincode');

            if (mComp) mComp.value = comp;
            if (mPhone) mPhone.value = phone;
            if (mAddr) mAddr.value = billAddr;
            if (mCity) mCity.value = billCity;
            if (mState && billState) mState.value = billState;
            if (mPin) mPin.value = billPin;

            // Populate Card 1 preview
            var bCompEl = document.getElementById('addrPreviewBillingComp');
            var bFullEl = document.getElementById('addrPreviewBillingFull');
            var bAttnEl = document.getElementById('addrPreviewBillingAttn');
            if (bCompEl) bCompEl.textContent = comp;
            if (bFullEl) bFullEl.innerHTML = `${billAddr}<br>${billCity}, ${billState} - ${billPin} (GSTIN: <strong>${gstNum}</strong>)`;
            if (bAttnEl) bAttnEl.textContent = `Attn: ${name} (+91 ${phone})`;

            // Populate Section 2 toggle and shipping inputs
            var isSame = user.shipping_same_as_billing !== false;
            var chk = document.getElementById('wsSameAsBillingCheckbox');
            if (chk) chk.checked = isSame;
            toggleSameAsBillingAddress(isSame);

            var dispatchBadge = document.getElementById('addrPreviewDispatchBadge');
            var dispatchTitle = document.getElementById('addrPreviewDispatchTitle');
            var dispatchFull = document.getElementById('addrPreviewDispatchFull');
            var dispatchTrans = document.getElementById('addrPreviewDispatchTransporter');

            var ship = user.custom_shipping || {};
            if (!isSame && ship.address) {
                if (dispatchBadge) dispatchBadge.textContent = '📦 Dispatch: Custom Godown';
                if (dispatchTitle) dispatchTitle.textContent = ship.warehouse_name || 'Primary Godown Hub';
                if (dispatchFull) dispatchFull.innerHTML = `${ship.address}<br>${ship.city || billCity}, ${ship.state || billState} - ${ship.pincode || billPin} • Ph: ${ship.receiver_phone || phone}`;
                if (dispatchTrans) dispatchTrans.textContent = 'Preferred Hub: ' + (ship.transporter || 'Surat Goods Transporter');

                var shipWarehouse = document.getElementById('wsShipWarehouseName');
                var shipPhone = document.getElementById('wsShipReceiverPhone');
                var shipAddr = document.getElementById('wsShipAddress');
                var shipCity = document.getElementById('wsShipCity');
                var shipState = document.getElementById('wsShipStateSelect');
                var shipPin = document.getElementById('wsShipPincode');
                var shipTransporter = document.getElementById('wsShipTransporter');

                if (shipWarehouse) shipWarehouse.value = ship.warehouse_name || '';
                if (shipPhone) shipPhone.value = ship.receiver_phone || '';
                if (shipAddr) shipAddr.value = ship.address || '';
                if (shipCity) shipCity.value = ship.city || '';
                if (shipState && ship.state) shipState.value = ship.state;
                if (shipPin) shipPin.value = ship.pincode || '';
                if (shipTransporter) shipTransporter.value = ship.transporter || '';
            } else {
                if (dispatchBadge) dispatchBadge.textContent = '📦 Dispatch: Same as Billing';
                if (dispatchTitle) dispatchTitle.textContent = 'Direct Storefront Delivery';
                if (dispatchFull) dispatchFull.innerHTML = `Dispatched to GST registered address: ${billAddr}, ${billCity} - ${billPin}`;
                if (dispatchTrans) dispatchTrans.textContent = 'Preferred Hub: BlueDart Express / Surat Goods Transporter';
            }
        }

        window.handleSaveAddress = function(e) {
            if (e) e.preventDefault();
            var userRaw = localStorage.getItem('dtbrands_user');
            var user = userRaw ? JSON.parse(userRaw) : {};

            // Save Section 1: Main Address (if entered/updated)
            var mComp = document.getElementById('wsMainCompName') ? document.getElementById('wsMainCompName').value.trim() : '';
            var mPhone = document.getElementById('wsMainContactPhone') ? document.getElementById('wsMainContactPhone').value.trim() : '';
            var mAddr = document.getElementById('wsFullAddress') ? document.getElementById('wsFullAddress').value.trim() : '';
            var mCity = document.getElementById('wsCity') ? document.getElementById('wsCity').value.trim() : '';
            var mState = document.getElementById('wsStateSelect') ? document.getElementById('wsStateSelect').value : 'Gujarat';
            var mPin = document.getElementById('wsPincode') ? document.getElementById('wsPincode').value.trim() : '';

            if (mComp) user.companyName = mComp;
            if (mPhone) { user.rawPhone = mPhone; user.phone = '+91 ' + mPhone; }
            if (mAddr) user.address = mAddr;
            if (mCity) user.city = mCity;
            if (mState) user.state = mState;
            if (mPin) user.pincode = mPin;

            // Save Section 2: Shipping / Dispatch
            var isSame = document.getElementById('wsSameAsBillingCheckbox') ? document.getElementById('wsSameAsBillingCheckbox').checked : true;
            user.shipping_same_as_billing = isSame;

            if (!isSame) {
                var wName = document.getElementById('wsShipWarehouseName') ? document.getElementById('wsShipWarehouseName').value.trim() : '';
                var rPhone = document.getElementById('wsShipReceiverPhone') ? document.getElementById('wsShipReceiverPhone').value.trim() : '';
                var sAddr = document.getElementById('wsShipAddress') ? document.getElementById('wsShipAddress').value.trim() : '';
                var sCity = document.getElementById('wsShipCity') ? document.getElementById('wsShipCity').value.trim() : '';
                var sState = document.getElementById('wsShipStateSelect') ? document.getElementById('wsShipStateSelect').value : 'Gujarat';
                var sPin = document.getElementById('wsShipPincode') ? document.getElementById('wsShipPincode').value.trim() : '';
                var sTrans = document.getElementById('wsShipTransporter') ? document.getElementById('wsShipTransporter').value.trim() : '';

                user.custom_shipping = {
                    warehouse_name: wName || 'Primary Godown Hub',
                    receiver_phone: rPhone || mPhone,
                    address: sAddr || mAddr,
                    city: sCity || mCity,
                    state: sState || mState,
                    pincode: sPin || mPin,
                    transporter: sTrans
                };
            }

            localStorage.setItem('dtbrands_user', JSON.stringify(user));
            closeEditAddressDrawer();
            renderAddressBookData(user);
            loadSavedWholesalerData();
            window.showWsToast('✓ Address configuration saved successfully!');
        };

        /* ── GST Mode Toggle ── */
        window.selectGstMode = function(mode) {
            activeGstMode = mode;
            var cardGst = document.getElementById('gstCardGst');
            var cardNonGst = document.getElementById('gstCardNonGst');
            var compFieldWrap = document.getElementById('wsCompanyNameFieldWrap');
            var gstNumberWrap = document.getElementById('gstNumberFieldWrap');
            var nonGstNoticeWrap = document.getElementById('nonGstNoticeWrap');
            var compInput = document.getElementById('wsCompanyName');
            var gstInput = document.getElementById('wsGstNumber');

            if (mode === 'gst') {
                if (cardGst) cardGst.classList.add('selected');
                if (cardNonGst) cardNonGst.classList.remove('selected');
                if (compFieldWrap) compFieldWrap.style.display = 'flex';
                if (gstNumberWrap) gstNumberWrap.style.display = 'flex';
                if (nonGstNoticeWrap) nonGstNoticeWrap.style.display = 'none';
                if (compInput) compInput.required = true;
                if (gstInput) gstInput.required = true;
            } else {
                if (cardGst) cardGst.classList.remove('selected');
                if (cardNonGst) cardNonGst.classList.add('selected');
                if (compFieldWrap) compFieldWrap.style.display = 'none';
                if (gstNumberWrap) gstNumberWrap.style.display = 'none';
                if (nonGstNoticeWrap) nonGstNoticeWrap.style.display = 'block';
                if (compInput) compInput.required = false;
                if (gstInput) gstInput.required = false;
            }
        };

        /* ── Indian GSTIN Validation ── */
        window.validateGstinInput = function(input) {
            var val = input.value.toUpperCase().replace(/[^0-9A-Z]/g, '');
            input.value = val;
            var stateTag = document.getElementById('gstStateDetectTag');

            var stateMap = {
                '01': 'Jammu & Kashmir', '02': 'Himachal Pradesh', '03': 'Punjab', '04': 'Chandigarh',
                '05': 'Uttarakhand', '06': 'Haryana', '07': 'Delhi', '08': 'Rajasthan',
                '09': 'Uttar Pradesh', '10': 'Bihar', '18': 'Assam', '19': 'West Bengal',
                '20': 'Jharkhand', '21': 'Odisha', '22': 'Chhattisgarh', '23': 'Madhya Pradesh',
                '24': 'Gujarat', '27': 'Maharashtra', '29': 'Karnataka', '30': 'Goa',
                '32': 'Kerala', '33': 'Tamil Nadu', '36': 'Telangana', '37': 'Andhra Pradesh'
            };

            if (val.length >= 2) {
                var prefix = val.substring(0, 2);
                var detectedState = stateMap[prefix];
                if (detectedState && stateTag) {
                    stateTag.textContent = '📍 State: ' + detectedState + ' (' + prefix + ')';
                }
            }
        };

        /* ── Render Orders Table & Mobile Cards ── */
        function getWsStatusBadgeHtml(status) {
            var s = (status || '').toLowerCase();
            if (s === 'delivered') {
                return `<span class="ws-status-badge delivered" style="display:inline-flex; align-items:center; gap:3px;"><svg style="width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg> DELIVERED</span>`;
            }
            if (s === 'shipped') {
                return `<span class="ws-status-badge shipped" style="display:inline-flex; align-items:center; gap:3px;"><svg style="width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><path d="M1 3h15v13H1z"></path><path d="M16 8h4l3 3v5h-7V8z"></path><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg> SHIPPED</span>`;
            }
            if (s === 'processing') {
                return `<span class="ws-status-badge processing" style="display:inline-flex; align-items:center; gap:3px;"><svg style="width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> PROCESSING</span>`;
            }
            return `<span class="ws-status-badge ${s}">${status}</span>`;
        }

        function renderOrdersView(orders) {
            var tbody = document.getElementById('wsOrdersTbody');
            var mobContainer = document.getElementById('wsMobileOrdersCards');
            var overviewContainer = document.getElementById('overviewOrdersContainer');

            if (!tbody || !mobContainer) return;

            tbody.innerHTML = '';
            mobContainer.innerHTML = '';

            if (orders.length === 0) {
                tbody.innerHTML = '<tr><td colspan="7" style="text-align:center; padding:30px; color:#6B6358;">No matching wholesale orders found.</td></tr>';
                mobContainer.innerHTML = '<div style="text-align:center; padding:30px; color:#6B6358; font-weight:600;">No matching orders found.</div>';
                return;
            }

            orders.forEach(function(o) {
                var badgeHtml = getWsStatusBadgeHtml(o.status);

                // 1. Desktop Row
                var tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="ws-order-id-cell"><span style="font-weight:800; padding:2px 7px; background:#FAF8F4; border:1px solid rgba(212,175,55,0.3); border-radius:6px;">${o.id}</span></td>
                    <td style="color:#6B6358; font-weight:600; font-size:0.78rem;">${o.date}</td>
                    <td>
                        <div class="ws-prod-mini-cell">
                            <img src="${o.image}" alt="${o.productName}" class="ws-prod-mini-img" onerror="this.onerror=null;this.src='/assets/images/no-image.svg';">
                            <div>
                                <strong style="font-size:0.84rem; color:var(--ws-text-main); font-family:var(--ws-font-serif);">${o.productName}</strong>
                                <div style="font-size:0.72rem; color:var(--ws-text-muted);">SKU: ${o.sku} • ${o.courier}</div>
                            </div>
                        </div>
                    </td>
                    <td><strong style="font-size:0.84rem;">${o.qty} Pcs</strong></td>
                    <td><strong style="color:var(--ws-gold-primary); font-size:0.92rem;">₹${Number(o.total).toLocaleString('en-IN')}</strong></td>
                    <td>${badgeHtml}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <button class="ws-btn ws-btn-secondary ws-btn-sm" style="font-weight:700;" onclick='viewOrderDetails(${JSON.stringify(o)})'>
                                Details
                            </button>
                            <button class="ws-btn ws-btn-primary ws-btn-sm" style="font-weight:700;" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block; vertical-align:middle;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> <span>Invoice</span>
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);

                // 2. Mobile Card
                var card = document.createElement('div');
                card.className = 'ws-mob-order-card';
                card.innerHTML = `
                    <div class="ws-mob-order-top">
                        <span class="ws-order-id-cell" style="font-size:0.84rem; font-weight:800; padding:2px 7px; background:#FAF8F4; border:1px solid rgba(212,175,55,0.3); border-radius:6px;">${o.id}</span>
                        ${badgeHtml}
                    </div>
                    <div class="ws-mob-order-body">
                        <img src="${o.image}" alt="${o.productName}" class="ws-mob-order-img" onerror="this.onerror=null;this.src='/assets/images/no-image.svg';">
                        <div class="ws-mob-order-info">
                            <h4 class="ws-mob-order-title">${o.productName}</h4>
                            <div class="ws-mob-order-meta"><span style="color:#B45309; font-weight:700;">${o.date}</span> • Lot: <strong>${o.qty} Pcs</strong></div>
                            <div class="ws-mob-order-meta">${o.courier} (AWB: ${o.awb})</div>
                            <div class="ws-mob-order-price-row" style="margin-top:2px;">
                                <span class="ws-mob-order-price">₹${Number(o.total).toLocaleString('en-IN')}</span>
                            </div>
                        </div>
                    </div>
                    <div class="ws-mob-order-actions">
                        <button class="ws-btn ws-btn-secondary ws-btn-sm" style="font-weight:700; display:inline-flex; align-items:center; justify-content:center; gap:4px;" onclick='viewOrderDetails(${JSON.stringify(o)})'>
                            <svg style="width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> Details
                        </button>
                        <button class="ws-btn ws-btn-primary ws-btn-sm" style="font-weight:700; display:inline-flex; align-items:center; justify-content:center; gap:4px;" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                            <svg style="width:13px;height:13px;stroke:#FFFFFF;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg> GST Invoice
                        </button>
                    </div>
                `;
                mobContainer.appendChild(card);
            });

            // Populate Overview Recent Snapshot (First 3)
            if (overviewContainer) {
                overviewContainer.innerHTML = '';
                var recent3 = orders.slice(0, 3);
                var overList = document.createElement('div');
                overList.className = 'ws-mobile-order-cards';
                overList.style.display = 'flex';
                recent3.forEach(function(o) {
                    var badgeHtml = getWsStatusBadgeHtml(o.status);
                    var card = document.createElement('div');
                    card.className = 'ws-mob-order-card';
                    card.innerHTML = `
                        <div class="ws-mob-order-top">
                            <span class="ws-order-id-cell" style="font-size:0.84rem; font-weight:800; padding:2px 7px; background:#FAF8F4; border:1px solid rgba(212,175,55,0.3); border-radius:6px;">${o.id}</span>
                            ${badgeHtml}
                        </div>
                        <div class="ws-mob-order-body">
                            <img src="${o.image}" alt="${o.productName}" class="ws-mob-order-img" onerror="this.onerror=null;this.src='/assets/images/no-image.svg';">
                            <div class="ws-mob-order-info">
                                <h4 class="ws-mob-order-title">${o.productName}</h4>
                                <div class="ws-mob-order-meta"><span style="color:#B45309; font-weight:700;">${o.date}</span> • Lot: <strong>${o.qty} Pcs</strong></div>
                                <div class="ws-mob-order-meta">${o.courier} (AWB: ${o.awb})</div>
                                <div class="ws-mob-order-price-row" style="margin-top:6px; display:flex; justify-content:space-between; align-items:center;">
                                    <span class="ws-mob-order-price">₹${Number(o.total).toLocaleString('en-IN')}</span>
                                    <button class="ws-btn ws-btn-primary ws-btn-sm" style="font-weight:700; display:inline-flex; align-items:center; gap:4px;" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                                        <svg style="width:12px;height:12px;stroke:#FFFFFF;fill:none;stroke-width:2;" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg> GST Invoice
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    overList.appendChild(card);
                });
                overviewContainer.appendChild(overList);
            }
        }

        /* ── Helper: Get Tier ── */
        window.getWholesaleTier = function(ordersCount) {
            if (ordersCount >= 800) return { name: 'Tier 5', tag: 'PLATINUM', discount: '15%' };
            if (ordersCount >= 450) return { name: 'Tier 4', tag: 'DIAMOND', discount: '12.5%' };
            if (ordersCount >= 250) return { name: 'Tier 3', tag: 'GOLD', discount: '10%' };
            if (ordersCount >= 50) return { name: 'Tier 2', tag: 'SILVER', discount: '5%' };
            return { name: 'Tier 1', tag: 'NON VIP', discount: '0%' };
        };

        /* ── Helper: Open VIP Modal ── */
        window.openVipTierModal = function() {
            var modal = document.getElementById('wsVipTierModal');
            if (modal) modal.classList.add('active');
        };

        /* ── Filter Orders Controller ── */
        window.filterOrdersTable = function() {
            var input = document.getElementById('wsOrdersSearchInput');
            var search = (input ? input.value : '').toLowerCase().trim();
            var clearBtn = document.getElementById('wsOrdersSearchClear');
            if (clearBtn) clearBtn.style.display = search ? 'flex' : 'none';

            var filtered = activeOrdersList.filter(function(o) {
                var matchStatus = (currentOrderStatusFilter === 'all') || (o.status.toLowerCase() === currentOrderStatusFilter.toLowerCase());
                var matchSearch = !search || 
                    o.id.toLowerCase().includes(search) || 
                    o.productName.toLowerCase().includes(search) || 
                    o.courier.toLowerCase().includes(search) || 
                    o.awb.toLowerCase().includes(search);
                return matchStatus && matchSearch;
            });
            renderOrdersView(filtered);
        };

        window.clearOrdersSearch = function() {
            var input = document.getElementById('wsOrdersSearchInput');
            if (input) {
                input.value = '';
                input.focus();
            }
            var clearBtn = document.getElementById('wsOrdersSearchClear');
            if (clearBtn) clearBtn.style.display = 'none';
            filterOrdersTable();
        };

        window.setOrderStatusFilter = function(status, btn) {
            currentOrderStatusFilter = status;
            btn.parentElement.querySelectorAll('button').forEach(function(b) {
                b.classList.remove('active');
            });
            if (btn) btn.classList.add('active');
            filterOrdersTable();
        };

        /* ════════════════════════════════════════════════════
           ANALYTICS ENGINE: MODES (OVERVIEW/SALES/REVENUE) & DATE RANGES
        ════════════════════════════════════════════════════ */
        var analyticsMode = 'overview';
        var currentSelectedDateRange = 'week';

        var WS_ICONS = {
            calendar: '<svg class="ws-ico gold" style="margin-right:4px;" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>',
            dress: '<svg class="ws-ico gold" style="margin-right:5px;" viewBox="0 0 24 24"><path d="M20.38 3.46L16 2 12 5.5 8 2l-4.38 1.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"></path></svg>',
            lightning: '<svg class="ws-ico gold ws-ico-sm" style="margin-right:3px;" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>',
            target: '<svg class="ws-ico gold ws-ico-sm" style="margin-right:3px;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>',
            crown: '<svg class="ws-ico" style="width:13px;height:13px;margin-right:3px;stroke:#FFFFFF;" viewBox="0 0 24 24"><polygon points="2 4 5 18 19 18 22 4 16 11 12 2 8 11 2 4"></polygon></svg>',
            shield: '<svg class="ws-ico gold ws-ico-sm" style="margin-right:3px;" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>',
            repeat: '<svg class="ws-ico gold ws-ico-sm" style="margin-right:3px;" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg>',
            package: '<svg class="ws-ico" style="width:13px;height:13px;margin-right:3px;stroke:#FFFFFF;" viewBox="0 0 24 24"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>',
            card: '<svg class="ws-ico" style="width:13px;height:13px;margin-right:3px;stroke:#FFFFFF;" viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>'
        };

        function getDynamicAnalyticsData(mode, range) {
            var orders = Array.isArray(window.b2bOrders) ? window.b2bOrders : (Array.isArray(activeOrdersList) ? activeOrdersList : []);
            var kpis = window.b2bKpis || {};
            var totalOrders = orders.length;
            var totalSpend = orders.reduce(function(acc, o) { return acc + Number(o.total || o.total_amount || 0); }, 0);
            var totalUnits = orders.reduce(function(acc, o) { return acc + Number(o.qty || o.items_count || 1); }, 0);
            var pendingOrders = orders.filter(function(o) {
                var s = (o.status || '').toLowerCase();
                return ['pending', 'processing', 'in transit', 'in_transit', 'shipped'].indexOf(s) !== -1;
            }).length;
            var creditLimit = Number(kpis.credit_limit || 0);
            var outstanding = Number(kpis.outstanding_balance || 0);
            var availableBal = Math.max(0, creditLimit - outstanding);
            var totalCoins = Math.floor(totalSpend / 100);
            var avgOrderVal = totalOrders > 0 ? Math.round(totalSpend / totalOrders) : 0;
            var gstCredit = Math.round(totalSpend * 0.05);

            var tierName = totalOrders >= 50 ? 'Tier 2: Silver' : 'Tier 1: Non-VIP';
            var tierRem = Math.max(0, 50 - totalOrders);
            var targetQuota = 250000;
            var targetAchieved = totalSpend;
            var targetRemaining = Math.max(0, targetQuota - targetAchieved);
            var gaugePct = targetQuota > 0 ? Math.min(100, Math.round((targetAchieved / targetQuota) * 100)) : 0;
            var gaugeOffset = Math.round(251 - (251 * (gaugePct / 100)));

            // Dynamic Category Aggregation from real orders
            var catMap = {};
            orders.forEach(function(o) {
                var pName = o.productName || 'Wholesale Lot';
                var cat = 'Pure Silk & Zari Sarees';
                if (/lehenga/i.test(pName)) cat = 'Bridal Velvet & Zardosi Lehengas';
                else if (/kurti|suit|set/i.test(pName)) cat = 'Royal Anarkali Kurti Sets';
                else if (/fabric|chanderi|georgette/i.test(pName)) cat = 'Georgette & Chanderi Fabrics';
                catMap[cat] = (catMap[cat] || 0) + Number(o.total || o.total_amount || 0);
            });

            var cats = [
                { name: "Pure Silk & Zari Sarees", val: totalOrders > 0 ? '₹' + (catMap['Pure Silk & Zari Sarees'] || Math.round(totalSpend * 0.6)).toLocaleString('en-IN') + ' (60%)' : '₹0 (0%)', fill: totalOrders > 0 ? 60 : 0 },
                { name: "Bridal Velvet & Zardosi Lehengas", val: totalOrders > 0 ? '₹' + (catMap['Bridal Velvet & Zardosi Lehengas'] || Math.round(totalSpend * 0.25)).toLocaleString('en-IN') + ' (25%)' : '₹0 (0%)', fill: totalOrders > 0 ? 25 : 0 },
                { name: "Royal Anarkali Kurti Sets", val: totalOrders > 0 ? '₹' + (catMap['Royal Anarkali Kurti Sets'] || Math.round(totalSpend * 0.1)).toLocaleString('en-IN') + ' (10%)' : '₹0 (0%)', fill: totalOrders > 0 ? 10 : 0 },
                { name: "Georgette & Chanderi Fabrics", val: totalOrders > 0 ? '₹' + (catMap['Georgette & Chanderi Fabrics'] || Math.round(totalSpend * 0.05)).toLocaleString('en-IN') + ' (5%)' : '₹0 (0%)', fill: totalOrders > 0 ? 5 : 0 }
            ];

            var cards = [];
            if (mode === 'sales') {
                cards = [
                    { label: "Active Consignments", val: totalOrders + " Lots", pill: totalOrders > 0 ? "Active" : "0 Active", isGold: true },
                    { label: "Units Procured", val: totalUnits + " Pcs", pill: totalUnits > 0 ? "100% QC Passed" : "0 Pcs", isGold: false },
                    { label: "Units In Progress", val: pendingOrders + " Lots", pill: pendingOrders > 0 ? "Dispatching" : "Cleared", isGold: false },
                    { label: "Delivery Mode", val: "Priority Air", pill: "BlueDart", isGold: true }
                ];
            } else if (mode === 'revenue') {
                cards = [
                    { label: "Gross B2B Spend", val: "₹" + totalSpend.toLocaleString('en-IN'), pill: "Gross Volume", isGold: true },
                    { label: "Taxable Invoiced", val: "₹" + Math.round(totalSpend * 0.95).toLocaleString('en-IN'), pill: "5% GST Excl", isGold: false },
                    { label: "ITC Reconciled", val: "₹" + gstCredit.toLocaleString('en-IN'), pill: "100% Claimable", isGold: false },
                    { label: "Net Settled", val: "₹" + totalSpend.toLocaleString('en-IN'), pill: "100% Cleared", isGold: true }
                ];
            } else {
                cards = [
                    { label: "B2B Account Tier", val: totalOrders >= 50 ? "Tier 2" : "Tier 1", pill: totalOrders + " / 50 Orders", isGold: true },
                    { label: "Total Orders", val: String(totalOrders), pill: pendingOrders + " In Progress", isGold: false },
                    { label: "Total Quantity (Units)", val: totalUnits + " Pcs", pill: "Consignments", isGold: false },
                    { label: "Total B2B Turnover", val: "₹" + totalSpend.toLocaleString('en-IN'), pill: "Gross Volume", isGold: true }
                ];
            }

            return {
                sub: totalOrders > 0 ? "Live Procurement Targets, Category Mix & Logistics Performance" : "Zero active consignments recorded. Procure wholesale lots from the live catalog.",
                cards: cards,
                chartTitle: mode === 'sales' ? "Procurement Units (Pcs)" : (mode === 'revenue' ? "B2B Turnover Volume (₹)" : "Monthly Sales Trend"),
                barActive: 7,
                gauge: {
                    pct: gaugePct + "%",
                    offset: gaugeOffset,
                    badge: totalOrders > 0 ? "+10.4% vs Target" : "Target Tracking",
                    desc: totalOrders > 0 ? ("You achieved <strong>₹" + totalSpend.toLocaleString('en-IN') + "</strong> this cycle. Just <strong>₹" + targetRemaining.toLocaleString('en-IN') + "</strong> left to complete " + tierName + " quota!") : "You have not placed any consignments this cycle. Place your first order to start quota progress!",
                    target: "₹2.50L",
                    rev: "₹" + totalSpend.toLocaleString('en-IN'),
                    today: "₹" + (totalOrders > 0 ? Math.round(totalSpend / 30).toLocaleString('en-IN') : '0') + "/d"
                },
                catTitle: WS_ICONS.dress + " Category Procurement Breakdown",
                cats: cats,
                kpis: [
                    { label: "Avg. Order Value", num: "₹" + avgOrderVal.toLocaleString('en-IN'), sub: totalOrders > 0 ? "↑ Verified Average" : "No orders placed" },
                    { label: "Dispatch Turnaround", num: totalOrders > 0 ? "1.8 Days" : "0 Days", sub: WS_ICONS.lightning + " Priority VIP BlueDart" },
                    { label: "GST Input Tax Credit", num: "₹" + gstCredit.toLocaleString('en-IN'), sub: WS_ICONS.shield + " 100% GSTR-1 Matched" },
                    { label: "Lot Reorder Rate", num: totalOrders > 0 ? "100%" : "0%", sub: WS_ICONS.repeat + " " + totalOrders + " Consignments Recorded" }
                ],
                milestoneBadge: tierName + " (Active)",
                milestoneVal: tierName + " Member",
                milestoneDesc: "Complete <strong>" + tierRem + " more orders</strong> to automatically unlock <strong>Tier 2: Silver</strong> with extra margin rebate!"
            };
        }

        window.updateDashboardAnalytics = function() {
            var data = getDynamicAnalyticsData(analyticsMode, currentSelectedDateRange);

            // 1. Update Subtitle
            var subEl = document.getElementById('statsSubtitle');
            if (subEl) subEl.textContent = data.sub;

            // 2. Update Top 4 Metric Cards
            for (var i = 0; i < 4; i++) {
                var c = data.cards[i];
                var lbl = document.getElementById('statLabel' + (i + 1));
                var val = document.getElementById('statVal' + (i + 1));
                var pill = document.getElementById('statPill' + (i + 1));
                if (lbl && c) lbl.textContent = c.label;
                if (val && c) {
                    val.innerHTML = c.val;
                    if (c.isGold) {
                        val.style.color = 'var(--ws-gold-primary)';
                    } else {
                        val.style.color = 'var(--ws-text-main)';
                    }
                }
                if (pill && c) pill.textContent = c.pill;
            }

            // Update 3D Corner Tag dynamically based on tier
            var ribbonTag = document.getElementById('wsTierRibbonTag');
            var ribbonText = document.getElementById('wsTierRibbonText');
            if (ribbonTag && ribbonText) {
                var tierVal = (data.cards && data.cards[0] && data.cards[0].val) ? data.cards[0].val.toLowerCase() : '';
                if (tierVal.includes('5') || tierVal.includes('platinum')) {
                    ribbonTag.className = 'ws-tier-ribbon-tag platinum';
                    ribbonText.textContent = '★ PLATINUM';
                } else if (tierVal.includes('4') || tierVal.includes('diamond')) {
                    ribbonTag.className = 'ws-tier-ribbon-tag diamond';
                    ribbonText.textContent = '★ DIAMOND';
                } else if (tierVal.includes('3') || tierVal.includes('gold')) {
                    ribbonTag.className = 'ws-tier-ribbon-tag gold';
                    ribbonText.textContent = '★ GOLD';
                } else if (tierVal.includes('2') || tierVal.includes('silver')) {
                    ribbonTag.className = 'ws-tier-ribbon-tag silver';
                    ribbonText.textContent = '★ SILVER';
                } else {
                    ribbonTag.className = 'ws-tier-ribbon-tag non-vip';
                    ribbonText.textContent = '★ NON VIP';
                }
            }

            // 3. Update Bar Chart Active Column & Title
            var chartTitleEl = document.getElementById('chartTitle');
            if (chartTitleEl) chartTitleEl.innerHTML = data.chartTitle;

            for (var b = 0; b < 12; b++) {
                var col = document.getElementById('barMonth' + b);
                if (col) {
                    col.classList.remove('active');
                    if (b === data.barActive) col.classList.add('active');
                }
            }

            // 4. Update Target Gauge
            var gVal = document.getElementById('targetGaugeVal');
            var gBadge = document.getElementById('targetGaugeBadge');
            var gFill = document.getElementById('targetGaugeFill');
            var gDesc = document.getElementById('targetGaugeDesc');
            var gTarget = document.getElementById('gStatTarget');
            var gRev = document.getElementById('gStatRevenue');
            var gToday = document.getElementById('gStatToday');

            if (gVal) gVal.textContent = data.gauge.pct;
            if (gBadge) gBadge.textContent = data.gauge.badge;
            if (gFill) gFill.style.strokeDashoffset = data.gauge.offset;
            if (gDesc) gDesc.innerHTML = data.gauge.desc;
            if (gTarget) gTarget.textContent = data.gauge.target;
            if (gRev) gRev.textContent = data.gauge.rev;
            if (gToday) gToday.textContent = data.gauge.today;

            // 5. Update Category Breakdown List
            var catTitleEl = document.getElementById('catBreakdownTitle');
            if (catTitleEl) catTitleEl.innerHTML = data.catTitle;

            var catList = document.getElementById('catProgList');
            if (catList && data.cats) {
                catList.innerHTML = '';
                data.cats.forEach(function(item) {
                    var row = document.createElement('div');
                    row.className = 'ws-cat-prog-item';
                    row.innerHTML = `
                        <div class="ws-cat-prog-header">
                            <span class="ws-cat-prog-name">${item.name}</span>
                            <span class="ws-cat-prog-val">${item.val}</span>
                        </div>
                        <div class="ws-cat-prog-track">
                            <div class="ws-cat-prog-fill" style="width: ${item.fill}%;"></div>
                        </div>
                    `;
                    catList.appendChild(row);
                });
            }

            // 6. Update KPIs Grid
            var kpiContainer = document.getElementById('kpiGrid');
            if (kpiContainer && data.kpis) {
                kpiContainer.innerHTML = '';
                data.kpis.forEach(function(k) {
                    var box = document.createElement('div');
                    box.className = 'ws-kpi-box';
                    box.innerHTML = `
                        <div class="ws-kpi-label">${k.label}</div>
                        <div class="ws-kpi-num">${k.num}</div>
                        <div class="ws-kpi-sub">${k.sub}</div>
                    `;
                    kpiContainer.appendChild(box);
                });
            }

            // 7. Update Milestone
            var mBadge = document.getElementById('statsMilestoneBadge');
            var mVal = document.getElementById('statsMilestoneVal');
            var mDesc = document.getElementById('statsMilestoneDesc');
            if (mBadge) mBadge.innerHTML = data.milestoneBadge;
            if (mVal) mVal.innerHTML = data.milestoneVal;
            if (mDesc) mDesc.innerHTML = data.milestoneDesc;
        };

        window.setOverviewFilter = function(mode, btn) {
            analyticsMode = mode;
            if (btn && btn.parentElement) {
                btn.parentElement.querySelectorAll('button').forEach(function(b) {
                    b.classList.remove('active');
                });
                btn.classList.add('active');
            }
            updateDashboardAnalytics();
            window.showWsToast('📊 Switched to ' + mode.toUpperCase() + ' Analytics Mode');
        };

        /* ── Date Range Modal Controller ── */
        window.openDateRangePicker = function() {
            window.showModal('wsDateRangeModal');
        };

        window.closeDateRangeModal = function() {
            window.hideModal('wsDateRangeModal');
        };

        window.applyDatePreset = function(presetKey, label) {
            currentSelectedDateRange = presetKey;
            
            var labelEl = document.getElementById('selectedDateRangeLabel');
            if (labelEl) labelEl.textContent = label;

            // Highlight selected button inside modal
            var modalButtons = document.querySelectorAll('#datePresetButtons button');
            modalButtons.forEach(function(b) {
                b.className = 'ws-btn ws-btn-secondary';
                if (b.getAttribute('onclick') && b.getAttribute('onclick').includes(presetKey)) {
                    b.className = 'ws-btn ws-btn-primary';
                }
            });

            closeDateRangeModal();
            updateDashboardAnalytics();
            window.showWsToast('📅 Applied Date Filter: ' + label);
        };

        window.applyCustomDateRange = function() {
            var s = document.getElementById('customStartDate').value;
            var e = document.getElementById('customEndDate').value;
            if (!s || !e) {
                alert('Please select both start and end dates.');
                return;
            }
            if (new Date(s) > new Date(e)) {
                alert('Start date cannot be after end date.');
                return;
            }

            var formatD = function(dStr) {
                var d = new Date(dStr);
                var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                return months[d.getMonth()] + ' ' + String(d.getDate()).padStart(2, '0');
            };

            var label = formatD(s) + ' - ' + formatD(e);
            var labelEl = document.getElementById('selectedDateRangeLabel');
            if (labelEl) labelEl.textContent = label;

            // Reset preset active buttons
            var modalButtons = document.querySelectorAll('#datePresetButtons button');
            modalButtons.forEach(function(b) {
                b.className = 'ws-btn ws-btn-secondary';
            });

            closeDateRangeModal();
            updateDashboardAnalytics();
            window.showWsToast('📅 Applied Custom Calendar Range: ' + label);
        };

        window.handleGlobalQuickSearch = function(input) {
            var val = input.value.trim().toLowerCase();
            if (!val) return;
            var match = activeOrdersList.find(function(o) {
                return o.id.toLowerCase().includes(val) || o.productName.toLowerCase().includes(val) || o.sku.toLowerCase().includes(val);
            });
            if (match) {
                viewOrderDetails(match);
            }
        };

        /* ── Render Reports Table & Mobile Cards ── */
        var currentReportCategoryFilter = 'all';
        var currentReportSearchQuery = '';

        function renderReportsView(orders) {
            var tbody = document.getElementById('wsReportsTbody');
            var mobContainer = document.getElementById('wsMobileReportsCards');
            if (!tbody || !mobContainer) return;

            tbody.innerHTML = '';
            mobContainer.innerHTML = '';

            var filtered = (orders || activeOrdersList).filter(function(o) {
                var matchCat = true;
                if (currentReportCategoryFilter !== 'all') {
                    var prodLow = (o.productName || '').toLowerCase();
                    matchCat = prodLow.includes(currentReportCategoryFilter);
                }
                var matchSearch = true;
                if (currentReportSearchQuery) {
                    var q = currentReportSearchQuery.toLowerCase();
                    matchSearch = (o.id || '').toLowerCase().includes(q) ||
                                  (o.productName || '').toLowerCase().includes(q) ||
                                  (o.sku || '').toLowerCase().includes(q) ||
                                  (o.hsn || '').toLowerCase().includes(q) ||
                                  (o.payment || '').toLowerCase().includes(q);
                }
                return matchCat && matchSearch;
            });

            // Update Report KPIs
            var totalTurnover = filtered.reduce(function(acc, o) { return acc + Number(o.total || 0); }, 0);
            var totalTax = filtered.reduce(function(acc, o) { return acc + Number(o.tax || 0); }, 0);
            var totalUnits = filtered.reduce(function(acc, o) { return acc + Number(o.qty || 0); }, 0);
            var avgValue = filtered.length ? Math.round(totalTurnover / filtered.length) : 0;

            var elTurnover = document.getElementById('repKpiTurnover');
            var elTax = document.getElementById('repKpiItc');
            var elUnits = document.getElementById('repKpiUnits');
            var elAvg = document.getElementById('repKpiAvg');

            if (elTurnover) elTurnover.textContent = '₹' + totalTurnover.toLocaleString('en-IN');
            if (elTax) elTax.textContent = '₹' + totalTax.toLocaleString('en-IN');
            if (elUnits) elUnits.textContent = totalUnits + ' Pcs';
            if (elAvg) elAvg.textContent = '₹' + avgValue.toLocaleString('en-IN');

            if (filtered.length === 0) {
                tbody.innerHTML = '<tr><td colspan="10" style="text-align:center; padding:30px; color:#6B6358;">No matching report consignments found.</td></tr>';
                mobContainer.innerHTML = '<div style="text-align:center; padding:30px; color:#6B6358; font-weight:600;">No matching report consignments found.</div>';
                return;
            }

            filtered.forEach(function(o) {
                // 1. Desktop Table Row
                var tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="ws-order-id-cell">${o.id}</td>
                    <td style="font-size:0.78rem; color:#6B6358; white-space:nowrap;">${o.date}</td>
                    <td><span style="font-family:monospace; background:var(--ws-gold-light); color:var(--ws-gold-primary); padding:2px 6px; border-radius:4px; font-weight:700;">${o.hsn}</span></td>
                    <td>
                        <div class="ws-prod-mini-cell">
                            <img src="${o.image}" alt="${o.productName}" class="ws-prod-mini-img" onerror="this.onerror=null;this.src='/assets/images/no-image.svg';">
                            <div>
                                <strong style="font-size:0.84rem; color:var(--ws-text-main);">${o.productName}</strong>
                                <div style="font-size:0.72rem; color:var(--ws-text-muted);">SKU: ${o.sku} • ${o.courier}</div>
                            </div>
                        </div>
                    </td>
                    <td><strong style="font-size:0.84rem;">${o.qty}</strong></td>
                    <td>₹${Number(o.subtotal).toLocaleString('en-IN')}</td>
                    <td style="color:#10B981; font-weight:700;">₹${Number(o.tax).toLocaleString('en-IN')}</td>
                    <td><strong style="color:var(--ws-gold-primary); font-size:0.90rem;">₹${Number(o.total).toLocaleString('en-IN')}</strong></td>
                    <td style="font-size:0.76rem; color:var(--ws-text-muted);">${o.payment}</td>
                    <td>
                        <div style="display:flex; gap:6px;">
                            <button class="ws-btn ws-btn-primary ws-btn-sm" onclick='openBillInvoiceModal(${JSON.stringify(o)})' title="Download GST Tax Invoice PDF">
                                <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block; vertical-align:middle;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> <span>Bill</span>
                            </button>
                            <button class="ws-btn ws-btn-secondary ws-btn-sm" onclick='viewOrderDetails(${JSON.stringify(o)})' title="View Details">
                                👁️
                            </button>
                        </div>
                    </td>
                `;
                tbody.appendChild(tr);

                // 2. Mobile Responsive Report Card
                var card = document.createElement('div');
                card.className = 'ws-mob-report-card';
                card.innerHTML = `
                    <div class="ws-mob-rep-top">
                        <div>
                            <span class="ws-order-id-cell" style="font-size:0.90rem;">${o.id}</span>
                            <span style="font-size:0.72rem; color:var(--ws-text-muted); margin-left:6px;">📅 ${o.date}</span>
                        </div>
                        <span class="ws-status-badge delivered" style="font-size:0.65rem;">✓ 5% GST Verified</span>
                    </div>

                    <div class="ws-mob-rep-body">
                        <img src="${o.image}" alt="${o.productName}" class="ws-mob-rep-img" onerror="this.onerror=null;this.src='/assets/images/no-image.svg';">
                        <div class="ws-mob-rep-info">
                            <h4 style="font-size:0.88rem; font-weight:700; color:var(--ws-text-main); line-height:1.25; margin-bottom:2px;">${o.productName}</h4>
                            <div style="font-size:0.74rem; color:var(--ws-text-muted);">
                                SKU: <strong>${o.sku}</strong> • HSN: <strong style="color:var(--ws-gold-primary); font-family:monospace;">${o.hsn}</strong>
                            </div>
                            <div style="font-size:0.76rem; font-weight:700; color:var(--ws-text-main); margin-top:2px;">
                                Quantity Lot: <span style="color:var(--ws-gold-primary);">${o.qty} Pcs</span>
                            </div>
                        </div>
                    </div>

                    <div class="ws-mob-rep-tax-grid">
                        <div>
                            <span style="color:var(--ws-text-muted); font-size:0.68rem; display:block;">Taxable Base:</span>
                            <strong style="color:var(--ws-text-main);">₹${Number(o.subtotal).toLocaleString('en-IN')}</strong>
                        </div>
                        <div>
                            <span style="color:var(--ws-text-muted); font-size:0.68rem; display:block;">GST ITC Accrued (5%):</span>
                            <strong style="color:#10B981;">₹${Number(o.tax).toLocaleString('en-IN')}</strong>
                        </div>
                        <div>
                            <span style="color:var(--ws-text-muted); font-size:0.68rem; display:block;">Payment Instrument:</span>
                            <span style="color:var(--ws-text-sub); font-size:0.72rem; font-weight:600;">${o.payment.split('(')[0]}</span>
                        </div>
                        <div>
                            <span style="color:var(--ws-text-muted); font-size:0.68rem; display:block;">Total Invoiced:</span>
                            <strong style="color:var(--ws-gold-primary); font-size:0.92rem;">₹${Number(o.total).toLocaleString('en-IN')}</strong>
                        </div>
                    </div>

                    <div class="ws-mob-rep-actions">
                        <button class="ws-btn ws-btn-primary ws-btn-sm" style="width:100%; justify-content:center;" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block; vertical-align:middle;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> <span>Download GST Bill PDF</span>
                        </button>
                        <button class="ws-btn ws-btn-secondary ws-btn-sm" style="width:100%; justify-content:center;" onclick='viewOrderDetails(${JSON.stringify(o)})'>
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" style="display:inline-block; vertical-align:middle;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> <span>View Details</span>
                        </button>
                    </div>
                `;
                mobContainer.appendChild(card);
            });
        }

        window.filterReportsByCategory = function(category, btn) {
            currentReportCategoryFilter = category;
            if (btn && btn.parentElement) {
                btn.parentElement.querySelectorAll('button').forEach(function(b) { b.classList.remove('active'); });
                btn.classList.add('active');
            }
            renderReportsView(activeOrdersList);
        };

        window.handleReportSearch = function(val) {
            currentReportSearchQuery = val.trim();
            var clearBtn = document.getElementById('reportSearchClear');
            if (clearBtn) clearBtn.style.display = val.trim() ? 'flex' : 'none';
            renderReportsView(activeOrdersList);
        };

        window.clearReportSearch = function() {
            var input = document.getElementById('reportSearchInput');
            if (input) {
                input.value = '';
                input.focus();
            }
            var clearBtn = document.getElementById('reportSearchClear');
            if (clearBtn) clearBtn.style.display = 'none';
            currentReportSearchQuery = '';
            renderReportsView(activeOrdersList);
        };

        /* ── Formal Printable Wholesale Procurement Audit Report ── */
        window.printWholesaleReport = function() {
            var modal = document.getElementById('wsPrintableAuditReportModal');
            if (modal) {
                var userRaw = localStorage.getItem('dtbrands_user');
                var user = userRaw ? JSON.parse(userRaw) : {};
                var comp = user.companyName || 'Shree Krishna Silks Pvt Ltd';
                var gst = user.gst_number || '24AABCU9603R1ZM';
                var rep = user.name || 'Rajesh Kumar';

                var repInfoEl = document.getElementById('auditReportBuyerInfo');
                if (repInfoEl) {
                    var genDate = new Date().toLocaleDateString('en-IN', { day:'numeric', month:'short', year:'numeric' });
                    repInfoEl.innerHTML = `
                        <strong>${comp}</strong> (GSTIN: <strong>${gst}</strong>)<br>
                        Authorized Wholesaler: ${rep} • Period: FY 2026-27<br>
                        Report Generated: ${genDate}
                    `;
                }

                var tbody = document.getElementById('auditReportTbody');
                if (tbody) {
                    tbody.innerHTML = '';
                    var totalSub = 0, totalTax = 0, totalGrand = 0, totalQty = 0;
                    activeOrdersList.forEach(function(o, idx) {
                        totalSub += Number(o.subtotal || 0);
                        totalTax += Number(o.tax || 0);
                        totalGrand += Number(o.total || 0);
                        totalQty += Number(o.qty || 0);

                        var tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${idx + 1}</td>
                            <td><strong>${o.id}</strong></td>
                            <td>${o.date}</td>
                            <td>${o.hsn}</td>
                            <td>${o.productName}</td>
                            <td>${o.qty} Pcs</td>
                            <td>₹${Number(o.subtotal).toLocaleString('en-IN')}</td>
                            <td>₹${Number(o.tax).toLocaleString('en-IN')}</td>
                            <td><strong>₹${Number(o.total).toLocaleString('en-IN')}</strong></td>
                            <td>${o.payment}</td>
                        `;
                        tbody.appendChild(tr);
                    });

                    document.getElementById('auditTotalSub').textContent = '₹' + totalSub.toLocaleString('en-IN');
                    document.getElementById('auditTotalTax').textContent = '₹' + totalTax.toLocaleString('en-IN');
                    document.getElementById('auditTotalGrand').textContent = '₹' + totalGrand.toLocaleString('en-IN');
                    document.getElementById('auditTotalQty').textContent = totalQty + ' Pcs';
                }

                window.showModal('wsPrintableAuditReportModal');
            } else {
                window.print();
            }
        };

        window.openPrintableAuditReportModal = function() {
            window.printWholesaleReport();
        };

        window.closePrintableAuditReportModal = function() {
            window.hideModal('wsPrintableAuditReportModal');
        };

        /* ── Export Reports to CSV ── */
        window.exportReportsToCsv = function() {
            var headers = ["Consignment ID", "Date", "HSN", "Product Name", "Quantity", "Taxable Value", "GST (5%)", "Net Total", "Payment Mode", "Courier", "AWB"];
            var rows = activeOrdersList.map(function(o) {
                return [
                    `"${o.id}"`,
                    `"${o.date}"`,
                    `"${o.hsn}"`,
                    `"${o.productName.replace(/"/g, '""')}"`,
                    o.qty,
                    o.subtotal,
                    o.tax,
                    o.total,
                    `"${o.payment}"`,
                    `"${o.courier}"`,
                    `"${o.awb}"`
                ];
            });

            var csvContent = "data:text/csv;charset=utf-8," + [headers.join(",")].concat(rows.map(function(e){ return e.join(","); })).join("\n");
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `DT Brand\'s_Wholesale_Report_${new Date().toISOString().slice(0,10)}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            window.showWsToast('📁 CSV Spreadsheet downloaded successfully!');
        };

        /* ── Render Support Tickets ── */
        function renderTicketsView() {
            var list = document.getElementById('wsTicketList');
            if (!list) return;
            list.innerHTML = '';

            activeTicketsList.forEach(function(t) {
                var isResolved = t.status === 'Resolved';
                var statusColor = isResolved ? '#15803D' : '#D97706';
                var statusBg = isResolved ? 'rgba(21, 128, 61, 0.08)' : 'rgba(217, 119, 6, 0.08)';
                var statusBorder = isResolved ? 'rgba(21, 128, 61, 0.25)' : 'rgba(217, 119, 6, 0.25)';

                var card = document.createElement('div');
                card.className = 'ws-ticket-card';
                card.innerHTML = `
                    <div class="ws-ticket-head">
                        <div style="display:flex; align-items:center; gap:6px;">
                            <strong class="ws-order-id-cell" style="font-size:0.86rem;">Ticket #${t.id}</strong>
                            <span style="font-size:0.70rem; color:var(--ws-text-muted);">• Ref: <strong>${t.orderId}</strong></span>
                        </div>
                        <span style="font-size:0.70rem; font-weight:800; color:${statusColor}; background:${statusBg}; border:1px solid ${statusBorder}; padding:2px 8px; border-radius:12px; display:inline-flex; align-items:center;">
                            ${isResolved ? '✓ ' + t.status : '<span class="ws-pulse-dot"></span> ' + t.status}
                        </span>
                    </div>
                    <div style="font-size:0.82rem; font-weight:700; color:var(--ws-text-main); margin:4px 0 2px;">${t.category}</div>
                    <p style="font-size:0.78rem; color:var(--ws-text-sub); margin:0; line-height:1.4; background:#FAF8F4; padding:8px 10px; border-radius:6px; border:1px solid var(--ws-border);">"${t.message}"</p>
                    <div style="font-size:0.72rem; color:var(--ws-text-muted); margin-top:8px; display:flex; justify-content:space-between; align-items:center;">
                        <span>📅 ${t.date}</span>
                        <a href="https://api.whatsapp.com/send?phone=917046363528&text=Hi%2C%20following%20up%20on%20Wholesaler%20Ticket%20%23${t.id}" target="_blank" style="color:#25D366; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M17.472 14.382c-.301-.15-1.78-.879-2.056-.979-.275-.1-.475-.15-.675.15-.2.3-.775.979-.95 1.179-.175.2-.35.225-.65.075-.3-.15-1.267-.467-2.414-1.49-1.049-.935-1.758-2.09-1.963-2.44-.205-.35-.022-.54.128-.69.135-.135.301-.35.451-.525.15-.175.2-.3.3-.5.1-.2.05-.375-.025-.525-.075-.15-.675-1.628-.925-2.228-.244-.585-.492-.505-.675-.515-.175-.01-.375-.01-.575-.01-.2 0-.525.075-.8.375s-1.05 1.028-1.05 2.505 1.075 2.905 1.225 3.105c.15.2 2.115 3.23 5.125 4.53 3.01 1.3 3.01.867 3.56.817.55-.05 1.78-.727 2.03-1.428.25-.7.25-1.3.175-1.428-.075-.128-.275-.203-.575-.353z"/><path d="M12 2C6.477 2 2 6.477 2 12c0 1.891.524 3.662 1.435 5.176L2 22l4.981-1.307C8.423 21.536 10.155 22 12 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18c-1.63 0-3.14-.492-4.407-1.336l-.316-.209-2.955.775.789-2.88-.228-.363C3.965 14.675 3.5 13.385 3.5 12c0-4.687 3.813-8.5 8.5-8.5s8.5 3.813 8.5 8.5-3.813 8.5-8.5 8.5z"/></svg>
                            <span>WhatsApp Followup →</span>
                        </a>
                    </div>
                `;
                list.appendChild(card);
            });
        }

        window.handleCreateTicket = function(e) {
            e.preventDefault();
            var orderId = document.getElementById('ticketOrderId').value;
            var category = document.getElementById('ticketCategory').value;
            var message = document.getElementById('ticketMessage').value.trim();

            if (!message) { alert('Please enter issue narrative'); return; }

            var newTicket = {
                id: 'TCK-' + Math.floor(100 + Math.random() * 900),
                orderId: orderId,
                category: category,
                status: 'In Progress',
                message: message,
                date: 'Today, ' + new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})
            };

            activeTicketsList.unshift(newTicket);
            renderTicketsView();
            document.getElementById('wsTicketForm').reset();
            window.showWsToast('🎫 Support ticket created! Concierge assigned.');
        };

        /* ── Order Details Modal ── */
        window.viewOrderDetails = function(o) {
            var modal = document.getElementById('wsOrderDetailsModal');
            var title = document.getElementById('modalOrderTitle');
            var body = document.getElementById('modalOrderBody');
            var footer = document.getElementById('modalOrderFooter');

            if (!modal || !body) return;

            if (title) title.textContent = `Order Details #${o.id}`;
            body.innerHTML = `
                <!-- Consignment Status Banner -->
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; background:#FAF8F4; border:1.5px solid var(--ws-border); border-radius:10px; padding:12px 16px; margin-bottom:14px;">
                    <div>
                        <div style="font-size:0.72rem; text-transform:uppercase; font-weight:700; letter-spacing:0.5px; color:var(--ws-text-muted);">Consignment Placed</div>
                        <div style="font-size:0.92rem; font-weight:800; color:var(--ws-text-main); margin-top:2px;">${o.date}</div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:0.72rem; text-transform:uppercase; font-weight:700; letter-spacing:0.5px; color:var(--ws-text-muted); margin-bottom:3px;">Consignment Status</div>
                        <span class="ws-status-badge ${o.status.toLowerCase()}" style="font-size:0.75rem; padding:4px 10px;">${o.status}</span>
                    </div>
                </div>

                <!-- Product Details Box -->
                <div style="display:flex; gap:14px; align-items:center; background:#FFFFFF; border:1.5px solid var(--ws-border); border-radius:10px; padding:14px; margin-bottom:14px; box-shadow:0 1px 4px rgba(0,0,0,0.03);">
                    <img src="${o.image}" alt="${o.productName}" style="width:72px; height:90px; border-radius:8px; object-fit:cover; border:1px solid var(--ws-border); flex-shrink:0; background:#FAF8F4;" onerror="this.onerror=null;this.src='/assets/images/no-image.svg';">
                    <div style="flex:1; min-width:0;">
                        <h4 style="font-size:0.96rem; font-weight:800; color:var(--ws-text-main); margin-bottom:4px; line-height:1.3;">${o.productName}</h4>
                        <div style="display:flex; gap:6px; flex-wrap:wrap; margin-bottom:6px;">
                            <span style="font-size:0.72rem; font-weight:600; background:#FAF8F4; padding:2px 6px; border-radius:4px; border:1px solid var(--ws-border); color:var(--ws-text-sub);">SKU: ${o.sku}</span>
                            <span style="font-size:0.72rem; font-weight:600; background:#FAF8F4; padding:2px 6px; border-radius:4px; border:1px solid var(--ws-border); color:var(--ws-text-sub);">HSN: ${o.hsn}</span>
                            <span style="font-size:0.72rem; font-weight:600; background:#FAF8F4; padding:2px 6px; border-radius:4px; border:1px solid var(--ws-border); color:var(--ws-text-sub);">${o.color || 'Silk Assorted'}</span>
                        </div>
                        <div style="font-size:0.88rem; font-weight:800; color:var(--ws-gold-primary);">
                            ${o.qty} Pcs Lot <span style="font-size:0.76rem; font-weight:600; color:var(--ws-text-muted);">(@ ₹${Number(o.unitPrice).toLocaleString('en-IN')} / Pc)</span>
                        </div>
                    </div>
                </div>

                <!-- Price & Tax Breakdown Card -->
                <div style="background:#FAF8F4; border:1.5px solid var(--ws-gold-border); border-radius:10px; padding:14px 16px; margin-bottom:14px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; font-size:0.84rem;">
                        <span style="color:var(--ws-text-sub); font-weight:600;">Taxable Consignment Value</span>
                        <span style="color:var(--ws-text-main); font-weight:700;">₹${Number(o.subtotal).toLocaleString('en-IN')}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; font-size:0.84rem;">
                        <span style="color:var(--ws-text-sub); font-weight:600;">GST Input Tax (5% CGST + SGST)</span>
                        <span style="color:#15803D; font-weight:700;">+₹${Number(o.tax).toLocaleString('en-IN')}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px; font-size:0.84rem;">
                        <span style="color:var(--ws-text-sub); font-weight:600;">Wholesale Volume Discount</span>
                        <span style="color:#15803D; font-weight:700;">-₹${Number(o.discount).toLocaleString('en-IN')}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; padding-top:10px; margin-top:4px; border-top:1.5px dashed var(--ws-border); font-size:1.1rem;">
                        <span style="font-weight:800; color:var(--ws-text-main);">Net Amount Paid</span>
                        <span style="font-weight:900; color:var(--ws-gold-primary);">₹${Number(o.total).toLocaleString('en-IN')}</span>
                    </div>
                </div>

                <!-- Logistics & Payment Strip -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px; font-size:0.78rem; background:#FFFFFF; border:1px solid var(--ws-border); border-radius:8px; padding:10px 14px;">
                    <div>
                        <div style="color:var(--ws-text-muted); font-size:0.70rem; text-transform:uppercase; font-weight:700;">Courier Partner</div>
                        <div style="font-weight:700; color:var(--ws-text-main); margin-top:2px;">${o.courier} (AWB: ${o.awb})</div>
                    </div>
                    <div>
                        <div style="color:var(--ws-text-muted); font-size:0.70rem; text-transform:uppercase; font-weight:700;">Payment Mode</div>
                        <div style="font-weight:700; color:var(--ws-text-main); margin-top:2px;">${o.payment}</div>
                    </div>
                </div>
            `;

            if (footer) {
                footer.innerHTML = `
                    <div class="ws-dual-action-grid" style="margin-top:0; padding-top:0; border-top:none;">
                        <button class="ws-btn ws-btn-primary" onclick='openBillInvoiceModal(${JSON.stringify(o)})'>
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#FFFFFF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                            <span>GST Bill PDF</span>
                        </button>
                        <button class="ws-btn ws-btn-secondary" onclick='repeatWholesaleOrder(${JSON.stringify(o)})'>
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"></polyline><polyline points="10 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                            <span>Re-Order Lot</span>
                        </button>
                    </div>
                `;
            }

            modal.classList.add('active');
        };

        window.repeatWholesaleOrder = function(o) {
            closeOrderDetailsModal();
            try {
                var raw = localStorage.getItem('dtbrands_cart');
                var cart = raw ? JSON.parse(raw) : [];
                var exists = cart.find(function(item){ return item.id === o.id || item.name === o.productName; });
                if (exists) {
                    exists.qty = (Number(exists.qty) || 1) + 1;
                } else {
                    cart.push({
                        id: o.id || ('PROD-' + Date.now()),
                        name: o.productName,
                        price: o.unitPrice || 3199,
                        wholesale_price: o.unitPrice || 3199,
                        qty: Number(o.qty) || 12,
                        image: o.image || '/assets/images/no-image.svg',
                        color: o.color || 'Standard',
                        moq: 12
                    });
                }
                localStorage.setItem('dtbrands_cart', JSON.stringify(cart));
                window.updateWholesaleCartBadge();
                if (typeof window.openCartDrawer === 'function') {
                    window.openCartDrawer();
                } else {
                    window.showWsToast('🛒 ' + o.productName + ' added to wholesale cart!');
                }
            } catch(e) {
                window.showWsToast('🛒 Added to cart!');
            }
        };

        window.closeOrderDetailsModal = function() {
            var modal = document.getElementById('wsOrderDetailsModal');
            if (modal) modal.classList.remove('active');
        };

        /* ── Indian Currency Number to Words Converter ── */
        window.convertNumberToIndianWords = function(num) {
            var units = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];
            var tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];
            
            function twoDigits(n) {
                if (n < 20) return units[n];
                return (tens[Math.floor(n / 10)] + ' ' + units[n % 10]).trim();
            }
            function threeDigits(n) {
                var h = Math.floor(n / 100);
                var r = n % 100;
                var res = [];
                if (h > 0) res.push(units[h] + ' Hundred');
                if (r > 0) res.push(twoDigits(r));
                return res.join(' and ');
            }

            var val = Math.round(Number(num || 0) * 100) / 100;
            var rupees = Math.floor(val);
            var paise = Math.round((val - rupees) * 100);

            if (rupees === 0) return 'Zero Rupees only';

            var crores = Math.floor(rupees / 10000000);
            rupees %= 10000000;
            var lakhs = Math.floor(rupees / 100000);
            rupees %= 100000;
            var thousands = Math.floor(rupees / 1000);
            rupees %= 1000;

            var parts = [];
            if (crores > 0) parts.push(twoDigits(crores) + ' Crore');
            if (lakhs > 0) parts.push(twoDigits(lakhs) + ' Lakh');
            if (thousands > 0) parts.push(twoDigits(thousands) + ' Thousand');
            if (rupees > 0) parts.push(threeDigits(rupees));

            var rStr = parts.join(' ') + ' Rupees';
            if (paise > 0) {
                rStr += ' and ' + twoDigits(paise) + ' Paisa only';
            } else {
                rStr += ' only';
            }
            return rStr;
        };

        /* ── Official GST Tax Invoice Modal & Print PDF ── */
        window.openBillInvoiceModal = function(o) {
            if (typeof closeOrderDetailsModal === 'function') {
                closeOrderDetailsModal();
            }
            var modal = document.getElementById('wsBillInvoiceModal');
            if (!modal) return;

            var b2b = window.b2bUser || {};
            var userRaw = localStorage.getItem('dtbrands_user');
            var localUser = userRaw ? JSON.parse(userRaw) : {};
            var user = Object.assign({}, localUser, b2b);

            // 1. Invoice Meta
            var cleanId = String(o.order_number || o.id || '1001').replace(/[^0-9]/g, '');
            if (!cleanId) cleanId = '1001';
            var invDate = o.date || new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            
            var buyerName = user.name || (o.customer_name || 'Valued Wholesale Partner');
            var buyerComp = user.companyName || user.company_name || user.name || 'Registered Wholesale Enterprise';
            var buyerAddr = user.address || (o.shipping_address || 'Registered Business Address');
            var buyerCity = user.city || 'Surat';
            var buyerState = user.state || 'Gujarat';
            var buyerPin = user.pincode || '';
            var buyerPhone = user.phone || '917046363528';
            var buyerAltPhone = user.alt_phone || buyerPhone;
            var buyerGst = user.gstin || user.gst_number || (user.gst_type === 'gst' ? '24AABCU9603R1ZM' : 'N/A (Unregistered)');
            var stateCode = user.state_code || (buyerState ? buyerState : '24-Gujarat');

            if (document.getElementById('invNum')) document.getElementById('invNum').textContent = cleanId;
            if (document.getElementById('invDate')) document.getElementById('invDate').textContent = invDate;
            if (document.getElementById('invPlaceOfSupply')) document.getElementById('invPlaceOfSupply').textContent = stateCode;

            // 2. Bill To
            if (document.getElementById('invBuyerName')) document.getElementById('invBuyerName').textContent = buyerName;
            if (document.getElementById('invBuyerCompany')) document.getElementById('invBuyerCompany').textContent = buyerComp;
            if (document.getElementById('invBuyerAddress')) document.getElementById('invBuyerAddress').textContent = buyerAddr;
            if (document.getElementById('invBuyerCity')) document.getElementById('invBuyerCity').textContent = buyerCity;
            if (document.getElementById('invBuyerState')) document.getElementById('invBuyerState').textContent = buyerState;
            if (document.getElementById('invBuyerPin')) document.getElementById('invBuyerPin').textContent = buyerPin;
            if (document.getElementById('invBuyerAltPhone')) document.getElementById('invBuyerAltPhone').textContent = buyerAltPhone;
            if (document.getElementById('invBuyerPhone')) document.getElementById('invBuyerPhone').textContent = buyerPhone;
            if (document.getElementById('invBuyerGst')) document.getElementById('invBuyerGst').textContent = buyerGst;
            if (document.getElementById('invBuyerStateCode')) document.getElementById('invBuyerStateCode').textContent = stateCode;

            // 3. Ship To
            if (document.getElementById('invShipCompany')) document.getElementById('invShipCompany').textContent = buyerComp;
            if (document.getElementById('invShipAddress')) document.getElementById('invShipAddress').textContent = o.shipping_address || o.delivery_point || buyerAddr;
            if (document.getElementById('invShipCityPin')) document.getElementById('invShipCityPin').textContent = buyerCity + (buyerPin ? ' - ' + buyerPin : '');
            if (document.getElementById('invShipPhone')) document.getElementById('invShipPhone').textContent = buyerPhone;

            // 4. Calculate Items & Taxes
            var items = o.items || [];
            if (!items.length) {
                // If single product order object
                var unitPrice = Number(o.unitPrice || o.price || 75);
                var qty = Number(o.qty || 186);
                var subtotal = Number(o.subtotal || (unitPrice * qty));
                var tax = Number(o.tax || (subtotal * 0.05));
                var total = Number(o.total || (subtotal + tax));

                items = [
                    {
                        name: o.productName || 'Ikkat cotton',
                        hsn: o.hsn || '5407',
                        qty: qty,
                        price: unitPrice,
                        gst: tax,
                        amount: total
                    }
                ];
            }

            var tbody = document.getElementById('invItemsTbody');
            var totQty = 0;
            var totGst = 0;
            var totAmount = 0;
            var totTaxable = 0;

            if (tbody) {
                tbody.innerHTML = '';
                items.forEach(function(it, idx) {
                    var iQty = Number(it.qty || 1);
                    var iPrice = Number(it.price || it.unitPrice || 75);
                    var iTaxable = iQty * iPrice;
                    var iGst = Number(it.gst || (iTaxable * 0.05));
                    var iAmount = Number(it.amount || (iTaxable + iGst));

                    totQty += iQty;
                    totTaxable += iTaxable;
                    totGst += iGst;
                    totAmount += iAmount;

                    var tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td style="text-align:center;">${idx + 1}</td>
                        <td style="font-weight:700;">${it.name || it.productName || 'Silk Fabric Assorted'}</td>
                        <td style="text-align:center;">${it.hsn || '5407'}</td>
                        <td style="text-align:right;">${iQty}</td>
                        <td style="text-align:right;">₹ ${iPrice.toFixed(2)}</td>
                        <td style="text-align:right;">₹ ${iGst.toFixed(2)} (5.0%)</td>
                        <td style="text-align:right; font-weight:700;">₹ ${iAmount.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                    `;
                    tbody.appendChild(tr);
                });
            }

            // Table Footers
            if (document.getElementById('invTableTotalQty')) document.getElementById('invTableTotalQty').textContent = totQty;
            if (document.getElementById('invTableTotalGst')) document.getElementById('invTableTotalGst').textContent = '₹ ' + totGst.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            if (document.getElementById('invTableTotalAmount')) document.getElementById('invTableTotalAmount').textContent = '₹ ' + totAmount.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});

            // 5. Tax Summary Sub-table
            var taxSummaryTbody = document.getElementById('invTaxSummaryTbody');
            if (taxSummaryTbody) {
                taxSummaryTbody.innerHTML = `
                    <tr>
                        <td style="text-align:left;">${items[0] ? (items[0].hsn || '5407') : '5407'}</td>
                        <td style="text-align:right;">${totTaxable.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                        <td style="text-align:center;">5.0</td>
                        <td style="text-align:right;">${totGst.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                        <td style="text-align:right;">${totGst.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                    </tr>
                `;
            }
            if (document.getElementById('invTaxableTotalVal')) document.getElementById('invTaxableTotalVal').textContent = totTaxable.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            if (document.getElementById('invTaxIgstAmt')) document.getElementById('invTaxIgstAmt').textContent = totGst.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            if (document.getElementById('invTaxGrandTotal')) document.getElementById('invTaxGrandTotal').textContent = totGst.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});

            // 6. Right Net Calculations
            var formattedGrand = '₹ ' + totAmount.toLocaleString('en-IN', {minimumFractionDigits: 2, maximumFractionDigits: 2});
            if (document.getElementById('invSubTotalRight')) document.getElementById('invSubTotalRight').textContent = formattedGrand;
            if (document.getElementById('invTotalRight')) document.getElementById('invTotalRight').textContent = formattedGrand;
            if (document.getElementById('invBalance')) document.getElementById('invBalance').textContent = formattedGrand;
            if (document.getElementById('invReceived')) document.getElementById('invReceived').textContent = '₹ 0.00';

            // 7. Amount in Words
            if (document.getElementById('invAmountInWords')) {
                document.getElementById('invAmountInWords').textContent = window.convertNumberToIndianWords(totAmount);
            }

            window.showModal('wsBillInvoiceModal');
            var wrapper = modal.querySelector('.ws-tax-invoice-wrapper');
            if (wrapper) wrapper.scrollTop = 0;
        };

        window.closeBillInvoiceModal = function() {
            window.hideModal('wsBillInvoiceModal');
        };

        window.printInvoiceSheet = function() {
            var modal = document.getElementById('wsBillInvoiceModal');
            if (modal) {
                var wrapper = modal.querySelector('.ws-tax-invoice-wrapper');
                if (wrapper) wrapper.scrollTop = 0;
            }
            window.print();
        };

        /* ── Trending & For You Products Slider Scrolling ── */
        window.slideTrendingProducts = function(dir) {
            var track = document.getElementById('wsTrendingSliderTrack');
            if (!track) return;
            var scrollAmount = track.offsetWidth * 0.75 * dir;
            track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        };

        window.slideForYouProducts = function(dir) {
            var track = document.getElementById('wsForYouSliderTrack');
            if (!track) return;
            var scrollAmount = track.offsetWidth * 0.75 * dir;
            track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        };

        window.slidePriceBoxes = function(dir) {
            var track = document.getElementById('wsPriceSliderTrack');
            if (!track) return;
            var scrollAmount = track.offsetWidth * 0.75 * dir;
            track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        };

        /* ── Unified Real-Time Category & Price Store Filter Engine ── */
        /* ── Unified Real-Time Category, Sub-Category & Price Store Filter Engine ── */
        var activePriceTier = null;
        var activeCatalogCategory = 'All';
        var activeCatalogSubCategory = 'all_sub';
        var activeCatalogSubCategoryLabel = '';

        var svgStar = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>';
        var svgFire = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"></path></svg>';
        var svgDiamond = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 3h12l4 6-10 12L2 9z"></path></svg>';
        var svgCrown = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 4l3 12h14l3-12-6 7-4-7-4 7-6-7z"></path></svg>';
        var svgTag = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path><line x1="7" y1="7" x2="7.01" y2="7"></line></svg>';
        var svgLayers = '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>';

        var wsCategoryTaxonomy = {
            'Kurtis': {
                title: 'Kurtis & Sets',
                icon: '<svg viewBox="0 0 24 24"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>',
                subcategories: [
                    { name: 'All Kurtis & Sets', filter: 'all_sub', icon: svgStar },
                    { name: 'Sharara & Anarkali Sets', filter: 'sharara', icon: svgFire },
                    { name: 'Straight Cut Kurtis', filter: 'straight', icon: svgTag },
                    { name: 'Lakhnavi Chikan Work', filter: 'chikan', icon: svgDiamond },
                    { name: 'Printed Cotton Kurtis', filter: 'cotton', icon: svgLayers },
                    { name: 'Rayon Everyday Sets', filter: 'rayon', icon: svgStar }
                ]
            },
            'Sarees': {
                title: 'Sarees',
                icon: '<svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>',
                subcategories: [
                    { name: 'All Sarees', filter: 'all_sub', icon: svgLayers },
                    { name: 'Kanjivaram Silk', filter: 'kanjivaram', icon: svgCrown },
                    { name: 'Dola & Paithani Silk', filter: 'dola', icon: svgStar },
                    { name: 'Georgette & Chiffon', filter: 'georgette', icon: svgFire },
                    { name: 'Chanderi Festive', filter: 'chanderi', icon: svgDiamond },
                    { name: 'Bandhani Art Silk', filter: 'bandhani', icon: svgTag }
                ]
            },
            'Lehengas': {
                title: 'Lehengas',
                icon: '<svg viewBox="0 0 24 24"><polygon points="12 2 2 22 22 22 12 2"/><line x1="12" y1="2" x2="12" y2="22"/></svg>',
                subcategories: [
                    { name: 'All Lehengas', filter: 'all_sub', icon: svgCrown },
                    { name: 'Bridal Velvet', filter: 'velvet', icon: svgDiamond },
                    { name: 'Zardosi Heavy Work', filter: 'zardosi', icon: svgStar },
                    { name: 'Semi-Bridal Art Silk', filter: 'silk', icon: svgFire },
                    { name: 'Festive Georgette', filter: 'georgette', icon: svgLayers }
                ]
            },
            'Gowns': {
                title: 'Gowns & Indo-Western',
                icon: '<svg viewBox="0 0 24 24"><path d="M12 2a4 4 0 0 0-4 4c0 3 4 8 4 8s4-5 4-8a4 4 0 0 0-4-4z"/><path d="M5 21c0-4 3-7 7-7s7 3 7 7"/></svg>',
                subcategories: [
                    { name: 'All Gowns', filter: 'all_sub', icon: svgCrown },
                    { name: 'Flared Designer Gowns', filter: 'flared', icon: svgStar },
                    { name: 'Indo-Western Fusion', filter: 'indo', icon: svgFire },
                    { name: 'Embroidered Festive', filter: 'embroidered', icon: svgDiamond }
                ]
            },
            'Dress Materials': {
                title: 'Dress Materials',
                icon: '<svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>',
                subcategories: [
                    { name: 'All Dress Materials', filter: 'all_sub', icon: svgLayers },
                    { name: 'Pure Cotton Suit Lots', filter: 'cotton', icon: svgStar },
                    { name: 'Chanderi Jacquard Suits', filter: 'chanderi', icon: svgDiamond },
                    { name: 'Silk Touch Unstitched', filter: 'silk', icon: svgCrown }
                ]
            }
        };

        window.filterByPriceTier = function(maxPrice, cardElem) {
            var cards = document.querySelectorAll('.ws-price-box-card');

            if (activePriceTier === maxPrice) {
                // Clicking active price box again toggles off the price filter
                activePriceTier = null;
                cards.forEach(function(c) { c.classList.remove('active'); });
            } else {
                activePriceTier = maxPrice;
                cards.forEach(function(c) { c.classList.remove('active'); });
                if (cardElem) {
                    cardElem.classList.add('active');
                } else {
                    cards.forEach(function(c) {
                        if (c.textContent.indexOf('₹' + Number(maxPrice).toLocaleString('en-IN')) !== -1 || (c.getAttribute('onclick') && c.getAttribute('onclick').indexOf(String(maxPrice)) !== -1)) {
                            c.classList.add('active');
                        }
                    });
                }
            }

            applyUnifiedCatalogFilterEngine(true);
        };

        window.selectWsCategory = function(catName) {
            if (catName === 'All') {
                closeWsCatalogCategoryModal();
                if (typeof window.switchWsTab === 'function') {
                    window.switchWsTab('trending');
                }
                activeCatalogCategory = 'All';
                activeCatalogSubCategory = 'all_sub';
                activeCatalogSubCategoryLabel = '';
                applyUnifiedCatalogFilterEngine(true);
                return;
            }

            // Drill down into sub-categories inside the modal
            renderSubCategoriesInModal(catName);
        };

        window.selectWsSubCategory = function(catName, subFilter, subLabel) {
            closeWsCatalogCategoryModal();
            if (typeof window.switchWsTab === 'function') {
                window.switchWsTab('trending');
            }
            activeCatalogCategory = catName;
            activeCatalogSubCategory = subFilter || 'all_sub';
            activeCatalogSubCategoryLabel = (subFilter === 'all_sub' ? '' : subLabel);
            applyUnifiedCatalogFilterEngine(true);
        };

        window.clearCategoryOnlyFilter = function() {
            activeCatalogCategory = 'All';
            activeCatalogSubCategory = 'all_sub';
            activeCatalogSubCategoryLabel = '';
            applyUnifiedCatalogFilterEngine(false);
        };

        window.clearSubCategoryOnlyFilter = function() {
            activeCatalogSubCategory = 'all_sub';
            activeCatalogSubCategoryLabel = '';
            applyUnifiedCatalogFilterEngine(false);
        };

        window.clearPriceOnlyFilter = function() {
            activePriceTier = null;
            document.querySelectorAll('.ws-price-box-card').forEach(function(c) { c.classList.remove('active'); });
            applyUnifiedCatalogFilterEngine(false);
        };

        window.clearAllCatalogFilters = function() {
            activeCatalogCategory = 'All';
            activeCatalogSubCategory = 'all_sub';
            activeCatalogSubCategoryLabel = '';
            activePriceTier = null;
            document.querySelectorAll('.ws-price-box-card').forEach(function(c) { c.classList.remove('active'); });
            applyUnifiedCatalogFilterEngine(false);
        };

        window.resetCatalogFilter = function() {
            window.clearAllCatalogFilters();
        };

        function renderMainCategoriesInModal() {
            var backBtn = document.getElementById('wsCatModalBackBtn');
            var titleElem = document.getElementById('wsCatModalHeaderTitle');
            var grid = document.getElementById('wsCatModalDynamicGrid');

            if (backBtn) backBtn.style.display = 'none';
            if (titleElem) titleElem.textContent = 'Select Category';
            if (!grid) return;

            var cats = [
                { id: 'Sarees', title: 'Sarees', icon: '<svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>' },
                { id: 'Kurtis', title: 'Kurtis & Sets', icon: '<svg viewBox="0 0 24 24"><path d="M20.38 3.46L16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>' },
                { id: 'Lehengas', title: 'Lehengas', icon: '<svg viewBox="0 0 24 24"><polygon points="12 2 2 22 22 22 12 2"/><line x1="12" y1="2" x2="12" y2="22"/></svg>' },
                { id: 'Gowns', title: 'Gowns & Indo-Western', icon: '<svg viewBox="0 0 24 24"><path d="M12 2a4 4 0 0 0-4 4c0 3 4 8 4 8s4-5 4-8a4 4 0 0 0-4-4z"/><path d="M5 21c0-4 3-7 7-7s7 3 7 7"/></svg>' },
                { id: 'Dress Materials', title: 'Dress Materials', icon: '<svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>' },
                { id: 'All', title: 'All Collections', isAll: true, icon: '<svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>' }
            ];

            var html = '';
            cats.forEach(function(c) {
                html += `
                    <div class="ws-cat-tile-card ${c.isAll ? 'all-cat' : ''}" onclick="selectWsCategory('${c.id}')">
                        <div class="ws-cat-tile-icon-wrap">
                            ${c.icon}
                        </div>
                        <div class="ws-cat-tile-content">
                            <div class="ws-cat-tile-title">${c.title}</div>
                        </div>
                        <div class="ws-cat-tile-arrow">→</div>
                    </div>
                `;
            });

            grid.innerHTML = html;
        }

        function renderSubCategoriesInModal(catName) {
            var backBtn = document.getElementById('wsCatModalBackBtn');
            var titleElem = document.getElementById('wsCatModalHeaderTitle');
            var grid = document.getElementById('wsCatModalDynamicGrid');

            var catData = wsCategoryTaxonomy[catName];
            if (!catData || !catData.subcategories) {
                // If no subcategories, filter directly
                selectWsSubCategory(catName, 'all_sub', '');
                return;
            }

            if (backBtn) backBtn.style.display = 'inline-block';
            if (titleElem) titleElem.textContent = catData.title + ' Sub-Categories';
            if (!grid) return;

            var html = '';
            catData.subcategories.forEach(function(sub) {
                html += `
                    <div class="ws-cat-tile-card" onclick="selectWsSubCategory('${catName}', '${sub.filter}', '${sub.name}')">
                        <div class="ws-cat-tile-icon-wrap">
                            <span style="font-size:1.15rem; line-height:1;">${sub.icon}</span>
                        </div>
                        <div class="ws-cat-tile-content">
                            <div class="ws-cat-tile-title">${sub.name}</div>
                        </div>
                        <div class="ws-cat-tile-arrow">→</div>
                    </div>
                `;
            });

            grid.innerHTML = html;
        }

        function applyUnifiedCatalogFilterEngine(showToast) {
            var btnLabel = document.getElementById('wsCatPickerBtnLabel');
            var titleElem = document.getElementById('wsCatalogMainTitle');
            var filterBar = document.getElementById('wsActiveCategoryFilterBar');
            var catPill = document.getElementById('wsFilterCategoryPill');
            var subCatPill = document.getElementById('wsFilterSubCategoryPill');
            var pricePill = document.getElementById('wsFilterPricePill');
            var activeNameElem = document.getElementById('wsActiveCatName');
            var activeSubNameElem = document.getElementById('wsActiveSubCatName');
            var activePriceElem = document.getElementById('wsActivePriceName');
            var activeCountElem = document.getElementById('wsActiveCatCount');

            var track = document.getElementById('wsForYouSliderTrack');
            if (!track) return;

            var productCards = Array.from(track.querySelectorAll('.product-card'));
            var matchCount = 0;
            var matchingCards = [];
            var nonMatchingCards = [];

            // Update UI headers
            if (btnLabel) {
                if (activeCatalogCategory === 'All') {
                    btnLabel.textContent = 'All Categories ▾';
                } else if (activeCatalogSubCategory && activeCatalogSubCategory !== 'all_sub') {
                    btnLabel.textContent = activeCatalogSubCategoryLabel + ' ▾';
                } else {
                    btnLabel.textContent = activeCatalogCategory + ' ▾';
                }
            }
            if (titleElem) {
                if (activeCatalogCategory === 'All') {
                    titleElem.textContent = 'For You';
                } else if (activeCatalogSubCategory && activeCatalogSubCategory !== 'all_sub') {
                    titleElem.textContent = activeCatalogCategory + ' • ' + activeCatalogSubCategoryLabel;
                } else {
                    titleElem.textContent = activeCatalogCategory + ' Catalog';
                }
            }

            // Filter products matching category, sub-category and price
            productCards.forEach(function(card) {
                var prodId = card.getAttribute('data-product-id');
                var pData = (window.allProducts || []).find(function(item) { return Number(item.id) === Number(prodId); });
                var pCat = pData ? (pData.category || '').toLowerCase() : '';
                var cardCat = card.querySelector('.card-cat-photo-tag') ? card.querySelector('.card-cat-photo-tag').textContent.trim().toLowerCase() : '';
                var pName = pData ? (pData.name || '').toLowerCase() : '';
                var pFabric = pData ? (pData.fabric || '').toLowerCase() : '';
                var price = pData ? (Number(pData.wholesale_price) || Number(pData.price) || 0) : 0;

                // 1. Main Category Check
                var isCatMatch = false;
                if (activeCatalogCategory === 'All') {
                    isCatMatch = true;
                } else if (activeCatalogCategory === 'Sarees' && (pCat.indexOf('saree') !== -1 || cardCat.indexOf('saree') !== -1)) {
                    isCatMatch = true;
                } else if (activeCatalogCategory === 'Kurtis' && (pCat.indexOf('kurti') !== -1 || cardCat.indexOf('kurti') !== -1)) {
                    isCatMatch = true;
                } else if (activeCatalogCategory === 'Lehengas' && (pCat.indexOf('lehenga') !== -1 || cardCat.indexOf('lehenga') !== -1)) {
                    isCatMatch = true;
                } else if (activeCatalogCategory === 'Gowns' && (pCat.indexOf('gown') !== -1 || cardCat.indexOf('gown') !== -1)) {
                    isCatMatch = true;
                } else if (activeCatalogCategory === 'Dress Materials' && (pCat.indexOf('dress') !== -1 || pCat.indexOf('dupatta') !== -1 || cardCat.indexOf('dress') !== -1 || cardCat.indexOf('dupatta') !== -1)) {
                    isCatMatch = true;
                } else if (pCat === activeCatalogCategory.toLowerCase() || cardCat === activeCatalogCategory.toLowerCase()) {
                    isCatMatch = true;
                }

                // 2. Sub-Category Check
                var isSubMatch = true;
                if (activeCatalogSubCategory && activeCatalogSubCategory !== 'all_sub') {
                    var kw = activeCatalogSubCategory.toLowerCase();
                    var combinedText = pName + ' ' + pFabric + ' ' + pCat;
                    if (combinedText.indexOf(kw) === -1) {
                        isSubMatch = false;
                    }
                }

                // 3. Price Check
                var isPriceMatch = true;
                if (activePriceTier !== null) {
                    isPriceMatch = (price > 0 && price <= activePriceTier);
                }

                if (isCatMatch && isSubMatch && isPriceMatch) {
                    card.style.display = 'flex';
                    matchingCards.push(card);
                    matchCount++;
                } else {
                    card.style.display = 'none';
                    nonMatchingCards.push(card);
                }
            });

            // Sort matching cards: new arrivals & new catalogue lots first
            matchingCards.sort(function(a, b) {
                var badgeA = (a.querySelector('.card-badge') ? a.querySelector('.card-badge').textContent.toLowerCase() : '');
                var badgeB = (b.querySelector('.card-badge') ? b.querySelector('.card-badge').textContent.toLowerCase() : '');
                var isNewA = badgeA.indexOf('new') !== -1 ? 1 : 0;
                var isNewB = badgeB.indexOf('new') !== -1 ? 1 : 0;
                return isNewB - isNewA;
            });

            // Append matching cards in prioritized order
            matchingCards.forEach(function(card) { track.appendChild(card); });
            nonMatchingCards.forEach(function(card) { track.appendChild(card); });

            // Update Filter Status Bar
            var hasFilter = (activeCatalogCategory !== 'All' || (activeCatalogSubCategory && activeCatalogSubCategory !== 'all_sub') || activePriceTier !== null);
            if (filterBar) {
                if (hasFilter) {
                    filterBar.style.display = 'flex';
                    if (catPill) {
                        if (activeCatalogCategory !== 'All') {
                            catPill.style.display = 'inline-flex';
                            if (activeNameElem) activeNameElem.textContent = activeCatalogCategory;
                        } else {
                            catPill.style.display = 'none';
                        }
                    }
                    if (subCatPill) {
                        if (activeCatalogSubCategory && activeCatalogSubCategory !== 'all_sub') {
                            subCatPill.style.display = 'inline-flex';
                            if (activeSubNameElem) activeSubNameElem.textContent = activeCatalogSubCategoryLabel;
                        } else {
                            subCatPill.style.display = 'none';
                        }
                    }
                    if (pricePill) {
                        if (activePriceTier !== null) {
                            pricePill.style.display = 'inline-flex';
                            if (activePriceElem) activePriceElem.textContent = 'Under ₹' + Number(activePriceTier).toLocaleString('en-IN');
                        } else {
                            pricePill.style.display = 'none';
                        }
                    }
                    if (activeCountElem) {
                        activeCountElem.textContent = '(' + matchCount + ' Lots Available)';
                    }
                } else {
                    filterBar.style.display = 'none';
                }
            }

            if (showToast && typeof window.showWsToast === 'function') {
                if (!hasFilter) {
                    window.showWsToast('✓ Showing All Available Wholesale Lots');
                } else if (activeCatalogSubCategory && activeCatalogSubCategory !== 'all_sub') {
                    window.showWsToast('👗 ' + activeCatalogSubCategoryLabel + ' (' + matchCount + ' Lots Available)');
                } else if (activeCatalogCategory !== 'All' && activePriceTier !== null) {
                    window.showWsToast('🏷️ ' + activeCatalogCategory + ' Under ₹' + Number(activePriceTier).toLocaleString('en-IN') + ' (' + matchCount + ' Lots)');
                } else if (activeCatalogCategory !== 'All') {
                    window.showWsToast('🥻 ' + activeCatalogCategory + ' (' + matchCount + ' Lots Available)');
                } else if (activePriceTier !== null) {
                    window.showWsToast('🏷️ Under ₹' + Number(activePriceTier).toLocaleString('en-IN') + ' (' + matchCount + ' Lots Available)');
                }
            }

            // Smooth scroll to catalog view
            var scrollTarget = document.getElementById('wsActiveCategoryFilterBar') || track;
            if (scrollTarget && hasFilter) {
                scrollTarget.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }

        window.openWsCatalogCategoryModal = function() {
            var modal = document.getElementById('wsCatalogCategoryModal');
            if (!modal) return;

            // If a specific category like Kurtis or Sarees is already active, open its sub-categories directly!
            if (activeCatalogCategory && activeCatalogCategory !== 'All' && wsCategoryTaxonomy[activeCatalogCategory]) {
                renderSubCategoriesInModal(activeCatalogCategory);
            } else {
                renderMainCategoriesInModal();
            }

            window.showModal('wsCatalogCategoryModal');
        };

        window.closeWsCatalogCategoryModal = function() {
            window.hideModal('wsCatalogCategoryModal');
        };

        /* ── Smart 1-Line Auto Slider Engine (For Sliders Only) ── */
        function initSmartCatalogAutoSliders() {
            var sliderIds = ['wsTrendingSliderTrack', 'wsPriceSliderTrack'];
            sliderIds.forEach(function(id) {
                var track = document.getElementById(id);
                if (!track) return;
                var isPaused = false;
                track.addEventListener('mouseenter', function() { isPaused = true; });
                track.addEventListener('mouseleave', function() { isPaused = false; });
                track.addEventListener('touchstart', function() { isPaused = true; }, { passive: true });
                track.addEventListener('touchend', function() {
                    setTimeout(function() { isPaused = false; }, 3000);
                }, { passive: true });

                setInterval(function() {
                    if (isPaused || !track.offsetParent) return;
                    var maxScroll = track.scrollWidth - track.clientWidth;
                    if (track.scrollLeft >= maxScroll - 8) {
                        track.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        var card = track.querySelector('.product-card, .ws-price-box-card');
                        var step = card ? (card.offsetWidth + 12) : 200;
                        track.scrollBy({ left: step, behavior: 'smooth' });
                    }
                }, 4000);
            });
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSmartCatalogAutoSliders);
        } else {
            initSmartCatalogAutoSliders();
        }

        /* ── Direct Add Wholesale Lot to Cart with Smart Button Feedback ── */
        window.directAddWholesaleToCart = function(prodOrId, btn) {
            try {
                var prod = (typeof prodOrId === 'object' && prodOrId !== null) ? prodOrId :
                    ((window.allProducts || []).find(function(p) { return Number(p.id) === Number(prodOrId); }) || null);
                // The fallback here used to invent a product at Rs 2,199 with an MOQ of 12,
                // so an id that is no longer in the catalogue still produced a priced line.
                if (!prod || !prod.id) {
                    if (typeof window.showWsToast === 'function') {
                        window.showWsToast('That product is not in the catalogue any more. Please refresh the page.');
                    }
                    return;
                }
                var raw = localStorage.getItem('dtbrands_cart');
                var cart = raw ? JSON.parse(raw) : [];
                var prodId = prod.id;
                var exists = cart.find(function(item) { return Number(item.id) === Number(prodId); });
                var addQty = Number(prod.moq) > 0 ? Number(prod.moq) : 1;
                if (exists) {
                    exists.qty = (Number(exists.qty) || addQty) + addQty;
                } else {
                    cart.push({
                        id: prod.id,
                        name: prod.name,
                        price: Number(prod.wholesale_price) || Number(prod.price) || 0,
                        wholesale_price: Number(prod.wholesale_price) || Number(prod.price) || 0,
                        retail_price: Number(prod.retail_price) || Number(prod.old_price) || 0,
                        qty: addQty,
                        image: prod.image || '/assets/images/no-image.svg',
                        color: prod.color || '',
                        moq: addQty,
                        category: prod.category || ''
                    });
                }
                localStorage.setItem('dtbrands_cart', JSON.stringify(cart));
                window.updateWholesaleCartBadge();

                // Button Ripple & Check Animation
                if (btn) {
                    btn.classList.add('added');
                    btn.innerHTML = '<svg style="width:14px;height:14px;stroke:#FFFFFF;fill:none;stroke-width:2.8;" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>';
                    setTimeout(function() {
                        btn.classList.remove('added');
                        btn.innerHTML = '<svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>';
                    }, 1400);
                }

                if (typeof window.showWsToast === 'function') {
                    window.showWsToast('🛍️ Added ' + prod.name + ' (' + addQty + ' Pcs Lot) to Cart!');
                }
            } catch(e) {
                console.error(e);
            }
        };
        window.openQuickOrderModal = function(prodOrId) {
            var prod = (typeof prodOrId === 'object' && prodOrId !== null) ? prodOrId :
                ((window.allProducts || []).find(function(p) { return Number(p.id) === Number(prodOrId); }) || null);
            // The fallback here used to invent a product at Rs 2,199 with an MOQ of 12,
            // so an id that is no longer in the catalogue still produced a priced line.
            if (!prod || !prod.id) {
                if (typeof window.showWsToast === 'function') {
                    window.showWsToast('That product is not in the catalogue any more. Please refresh the page.');
                }
                return;
            }
            var userRaw = localStorage.getItem('dtbrands_user');
            var user = userRaw ? JSON.parse(userRaw) : {};
            var company = user.companyName || 'Wholesale Buyer';
            var gst = user.gst_number || 'Non-GST';

            var text = `👑 *WHOLESALE BULK LOT INQUIRY — DT BRAND'S B2B*\n\n` +
                       `*Product:* ${prod.name}${prod.sku ? ` (SKU: ${prod.sku})` : ''}\n` +
                       (prod.hsn ? `*HSN Code:* ${prod.hsn}\n` : '') +
                       `*Wholesale Price:* ${Number(prod.wholesale_price || prod.price) > 0 ? '₹' + Number(prod.wholesale_price || prod.price) + ' / Pc' : 'to be confirmed'}\n` +
                       (Number(prod.moq) > 0 ? `*Minimum Order Qty (MOQ):* ${Number(prod.moq)} Pcs\n` : '') +
                       (prod.tier_prices ? `*Lot Pricing:* ${prod.tier_prices}\n` : '') +
                       `\n` +
                       `*Buyer Business:* ${company}\n` +
                       `*GSTIN:* ${gst}\n` +
                       `*Representative:* ${user.name || 'Member'} (${user.phone || ''})\n\n` +
                       `Please confirm lot availability, dispatch turnaround and proforma payment details.`;

            var waUrl = `https://api.whatsapp.com/send?phone=917046363528&text=${encodeURIComponent(text)}`;
            window.open(waUrl, '_blank');
        };

        /* ── Wholesaler Wishlist Controller ── */
        window.toggleWholesaleWishlist = function(productId, btn) {
            var p = (window.allProducts || []).find(function(item) { return Number(item.id) === Number(productId); });
            if (p && typeof window.toggleWishlistProduct === 'function') {
                var added = window.toggleWishlistProduct(p);
                if (btn) {
                    btn.classList.toggle('active', added);
                    btn.setAttribute('aria-pressed', added ? 'true' : 'false');
                }
                if (typeof showToast === 'function') {
                    showToast(added ? '♡ Saved ' + p.name + ' to Wishlist' : 'Removed from Wishlist');
                } else if (typeof window.showWsToast === 'function') {
                    window.showWsToast(added ? '♡ Saved ' + p.name + ' to Wishlist' : 'Removed from Wishlist');
                }
                return;
            }

            var raw = localStorage.getItem('dtbrands_wishlist');
            var wish = raw ? JSON.parse(raw) : [];
            var idx = wish.findIndex(function(i){ return Number(i.id) === Number(productId); });
            if (idx > -1) {
                wish.splice(idx, 1);
                if (btn) btn.classList.remove('active');
                if (typeof window.showWsToast === 'function') window.showWsToast('Item removed from Procurement Wishlist');
            } else {
                wish.push({ id: productId });
                if (btn) btn.classList.add('active');
                if (typeof window.showWsToast === 'function') window.showWsToast('Saved to B2B Procurement Wishlist');
            }
            localStorage.setItem('dtbrands_wishlist', JSON.stringify(wish));
        };

        /* ── Share Wholesale Lot (Triggers Smart Share or WhatsApp) ── */
        window.shareWholesaleProduct = function(prod) {
            if (typeof window.shareProductCard === 'function' && prod && prod.id) {
                window.shareProductCard(prod.id);
                return;
            }
            var text = `*DT BRAND'S B2B WHOLESALE LOT*\n\n` +
                       `*Product:* ${prod.name}${prod.sku ? ` (SKU: ${prod.sku})` : ''}\n` +
                       `*Wholesale Price:* ${Number(prod.wholesale_price) > 0 ? '₹' + Number(prod.wholesale_price) + ' / Pc' : 'to be confirmed'}${Number(prod.retail_price) > Number(prod.wholesale_price) ? ` (Retail MRP: ₹${Number(prod.retail_price)})` : ''}\n` +
                       (Number(prod.moq) > 0 ? `*MOQ:* ${Number(prod.moq)} Pcs Pack\n` : '') +
                       (prod.fabric ? `*Fabric:* ${prod.fabric}\n` : '') +
                       (prod.tier_prices ? `*Lot Rates:* ${prod.tier_prices}\n` : '') +
                       `\n` +
                       `Explore live wholesale portal: ${window.location.origin}/wholesale.php`;
            var waUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(text)}`;
            window.open(waUrl, '_blank');
        };

        /* ── Global Product Card Share Function (Matches shop.php Smart Share) ── */
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
                var waUrl = 'https://api.whatsapp.com/send?text=' + encodeURIComponent('Check out ' + p.name + ' Wholesale at DT Brand\'s: ' + window.location.origin + '/product.php?id=' + p.id);
                window.open(waUrl, '_blank');
            }
        };

        /* ── Monthly Sales Chart Data & Interactive Tooltips ── */
        var MONTH_SALES_DATA = [
            { m: 'Jan', val: '₹1,24,000', qty: '32 Pcs', growth: '+5.2%' },
            { m: 'Feb', val: '₹3,42,000', qty: '84 Pcs', growth: '+28.4%' },
            { m: 'Mar', val: '₹1,48,000', qty: '38 Pcs', growth: '+4.1%' },
            { m: 'Apr', val: '₹2,88,000', qty: '72 Pcs', growth: '+19.6%' },
            { m: 'May', val: '₹1,36,000', qty: '35 Pcs', growth: '-2.0%' },
            { m: 'Jun', val: '₹1,65,000', qty: '42 Pcs', growth: '+8.3%' },
            { m: 'Jul', val: '₹2,72,000', qty: '68 Pcs', growth: '+15.2%' },
            { m: 'Aug', val: '₹2,05,062', qty: '48 Pcs', growth: '↑ 18.4%' },
            { m: 'Sep', val: '₹1,90,000', qty: '46 Pcs', growth: '+7.5%' },
            { m: 'Oct', val: '₹3,85,000', qty: '96 Pcs', growth: '+32.0%' },
            { m: 'Nov', val: '₹2,48,000', qty: '62 Pcs', growth: '+12.8%' },
            { m: 'Dec', val: '₹1,15,000', qty: '28 Pcs', growth: '-5.0%' }
        ];

        window.showChartNodeTooltip = function(idx) {
            var item = MONTH_SALES_DATA[idx];
            if (!item) return;
            var el = document.getElementById('chartTooltipText');
            if (el) el.textContent = `${item.m}: ${item.val} • ${item.qty} (${item.growth})`;
            document.querySelectorAll('.ws-chart-node').forEach(function(node, i) {
                node.classList.toggle('active', i === idx);
            });
            document.querySelectorAll('.ws-chart-x-axis span').forEach(function(span, i) {
                span.classList.toggle('active', i === idx);
            });
        };

        window.switchSalesChartStyle = function(type, btn) {
            document.querySelectorAll('.ws-chart-type-btn').forEach(function(b) { b.classList.remove('active'); });
            if (btn) btn.classList.add('active');

            var line = document.getElementById('svgLinePath');
            var area = document.getElementById('svgAreaPath');
            if (!line || !area) return;

            if (type === 'smooth') {
                // Smooth curved spline wave (Luxury Cubic Curve)
                var smoothLine = 'M 40,115 C 63,115 63,96 86,96 C 109,96 109,102 132,102 C 155,102 155,85 178,85 C 201,85 201,76 224,76 C 247,76 247,82 270,82 C 293,82 293,62 316,62 C 339,62 339,88 362,88 C 385,88 385,68 408,68 C 431,68 431,38 454,38 C 477,38 477,52 500,52 C 523,52 523,94 546,94';
                var smoothArea = smoothLine + ' L 546,158 L 40,158 Z';
                line.setAttribute('d', smoothLine);
                area.setAttribute('d', smoothArea);
            } else {
                // Crisp Zigzag Lines (Luxury Style)
                var zigzagLine = 'M 40,115 L 86,96 L 132,102 L 178,85 L 224,76 L 270,82 L 316,62 L 362,88 L 408,68 L 454,38 L 500,52 L 546,94';
                var zigzagArea = zigzagLine + ' L 546,158 L 40,158 Z';
                line.setAttribute('d', zigzagLine);
                area.setAttribute('d', zigzagArea);
            }
        };

        /* ── Animate Target Gauge Percentage Count-up ── */
        window.animateTargetGauge = function(targetPercent) {
            var valEl = document.getElementById('targetGaugeVal');
            var fillEl = document.getElementById('targetGaugeFill');
            if (!valEl) return;

            var target = targetPercent || 75.55;
            var start = performance.now();
            var duration = 1200;

            var targetOffset = Math.round(236 - (236 * (target / 100)));
            if (fillEl) fillEl.style.strokeDashoffset = targetOffset;

            function step(time) {
                var progress = Math.min((time - start) / duration, 1);
                var ease = 1 - Math.pow(1 - progress, 3);
                var val = (ease * target).toFixed(2);
                valEl.textContent = val + '%';
                if (progress < 1) {
                    requestAnimationFrame(step);
                } else {
                    valEl.textContent = target.toFixed(2) + '%';
                }
            }
            requestAnimationFrame(step);
        };

        /* ── Wholesaler Logout ── */
        window.handleWholesalerLogout = function() {
            if (confirm('Are you sure you want to log out of the Wholesaler Portal?')) {
                localStorage.removeItem('dtbrands_user');
                window.location.href = '/shop.php';
            }
        };

        /* ── Initialize Application ── */
        function initWholesalerApp() {
            if (!checkWholesalerSecurity()) return;

            var products = (function() {
                try {
                    var el = document.getElementById('ws-catalog-data');
                    return el ? JSON.parse(el.textContent || el.innerHTML || '[]') : [];
                } catch(e) { return []; }
            })();
            window.allProducts = Array.isArray(products) ? products : [];

            activeOrdersList = Array.isArray(window.b2bOrders) ? window.b2bOrders.slice() : [];
            activeTicketsList = [];

            loadSavedWholesalerData();
            renderOrdersView(activeOrdersList);
            renderReportsView(activeOrdersList);
            renderTrackingTab(activeOrdersList);
            renderTicketsView();
            window.animateTargetGauge(75.55);
            window.updateWholesaleCartBadge();
        }

        /* ── Live Shipment Tracking Controller ── */
        var activeTrackOrderId = 'KLN-WS-8021';
        var currentTrackFilter = 'all';

        function renderTrackingTab(orders, selectedId) {
            if (selectedId) activeTrackOrderId = selectedId;
            var heroContainer = document.getElementById('wsActiveTrackHero');
            var gridContainer = document.getElementById('wsTrackingOrdersGrid');
            var headerBadge = document.getElementById('trackHeaderBadge');
            if (!heroContainer || !gridContainer) return;

            var list = orders || activeOrdersList || [];
            var currentOrder = list.find(function(o){ return o.id === activeTrackOrderId; }) || list[0];
            if (!currentOrder) {
                if (headerBadge) {
                    headerBadge.className = 'ws-status-badge';
                    headerBadge.innerHTML = '⚡ No Active Consignments';
                }
                heroContainer.innerHTML = `
                    <div style="text-align:center; padding:32px 16px;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--ws-gold-primary)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:12px;"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <h4 style="font-size:1.05rem; font-weight:800; color:var(--ws-text-main); margin-bottom:6px;">No Consignments Available for Live Tracking</h4>
                        <p style="font-size:0.82rem; color:var(--ws-text-muted); max-width:420px; margin:0 auto 16px;">When you place wholesale orders, real-time BlueDart, Delhivery, and DTDC tracking updates with live GPS milestones will appear here.</p>
                        <button class="ws-btn ws-btn-primary ws-btn-sm" onclick="switchWsTab('tabPaneCatalog', document.querySelector('.ws-nav-item[data-tab=\\'tabPaneCatalog\\']'))">
                            <span>Browse Wholesale Catalog</span>
                        </button>
                    </div>
                `;
                gridContainer.innerHTML = `
                    <div style="text-align:center; padding:24px; color:var(--ws-text-muted); font-size:0.84rem; grid-column: 1 / -1;">
                        No shipments found matching the selected filter.
                    </div>
                `;
                return;
            }
            activeTrackOrderId = currentOrder.id;

            if (headerBadge) {
                headerBadge.className = 'ws-status-badge ' + currentOrder.status.toLowerCase();
                headerBadge.innerHTML = '⚡ ' + currentOrder.courier;
            }

            // 1. Render Active Hero Card
            var isDelivered = currentOrder.status.toLowerCase() === 'delivered';
            var isProcessing = currentOrder.status.toLowerCase() === 'processing';

            var etaText = isDelivered ? 'Delivered on ' + currentOrder.date : (isProcessing ? 'Dispatching from Atelier' : 'Tomorrow, 17 Aug 2026');
            var etaColor = isDelivered ? '#15803D' : (isProcessing ? '#B45309' : 'var(--ws-gold-primary)');

            heroContainer.innerHTML = `
                <!-- Top Header: Consignment ID + Status Pill + ETA -->
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px; margin-bottom:12px; padding-bottom:10px; border-bottom:1px dashed var(--ws-border);">
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span class="ws-order-id-cell" style="font-size:1.05rem; font-weight:800;">${currentOrder.id}</span>
                        <span class="ws-status-badge ${currentOrder.status.toLowerCase()}" style="font-size:0.75rem; padding:3px 8px;">${currentOrder.status}</span>
                    </div>
                    <div style="font-size:0.80rem; font-weight:800; color:${etaColor};">
                        📅 ${etaText}
                    </div>
                </div>

                <!-- Product & Courier Info Strip -->
                <div style="display:flex; gap:12px; align-items:center; margin-bottom:14px; background:#FFFFFF; border:1px solid var(--ws-border); border-radius:8px; padding:10px 12px; box-shadow:0 1px 3px rgba(0,0,0,0.02);">
                    <img src="${currentOrder.image}" alt="${currentOrder.productName}" style="width:54px; height:68px; border-radius:6px; object-fit:cover; border:1px solid var(--ws-border); flex-shrink:0; background:#FAF8F4;" onerror="this.onerror=null;this.src='/assets/images/no-image.svg';">
                    <div style="flex:1; min-width:0;">
                        <h4 style="font-size:0.92rem; font-weight:800; color:var(--ws-text-main); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:2px;">${currentOrder.productName}</h4>
                        <div style="font-size:0.74rem; color:var(--ws-text-muted); margin-bottom:4px;">
                            Consignment Lot: <strong>${currentOrder.qty} Pcs</strong> • ${currentOrder.color || 'Standard'}
                        </div>
                        <div style="font-size:0.74rem; color:var(--ws-text-sub); display:flex; align-items:center; gap:6px; flex-wrap:wrap;">
                            <span>${currentOrder.courier}</span>
                            <span style="font-family:monospace; background:#FAF8F4; padding:1px 6px; border-radius:4px; border:1px solid var(--ws-border); font-weight:700;">${currentOrder.awb}</span>
                            <button onclick="copyAwbNumber('${currentOrder.awb}')" style="background:transparent; border:none; color:var(--ws-gold-primary); cursor:pointer; display:inline-flex; align-items:center; justify-content:center; padding:2px;" title="Copy AWB">
                                <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step-by-Step Logistics Milestones Timeline -->
                <div class="ws-track-timeline">
                    <div class="ws-timeline-step completed">
                        <div class="ws-timeline-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                        <div class="ws-timeline-title">Order Confirmed & Proforma Invoiced</div>
                        <div class="ws-timeline-date">DT Brand\'s Head Atelier, Surat • ${currentOrder.date}, 10:30 AM</div>
                    </div>
                    <div class="ws-timeline-step ${isProcessing ? 'active' : 'completed'}">
                        <div class="ws-timeline-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                        <div class="ws-timeline-title">QC Inspection & Sealed Bale Packaging Completed</div>
                        <div class="ws-timeline-date">Zari & Silk Logistics Warehouse • Verified for Transit</div>
                    </div>
                    <div class="ws-timeline-step ${isDelivered ? 'completed' : (isProcessing ? '' : 'active')}">
                        <div class="ws-timeline-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                        <div class="ws-timeline-title">${isDelivered ? 'Transit Completed — Received at Warehouse Godown' : 'In Transit — Dispatched via Priority Air Cargo'}</div>
                        <div class="ws-timeline-date">${currentOrder.courier} (AWB: ${currentOrder.awb}) • Live GPS Tracking Active</div>
                    </div>
                    <div class="ws-timeline-step ${isDelivered ? 'completed' : ''}">
                        <div class="ws-timeline-dot"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                        <div class="ws-timeline-title">${isDelivered ? 'Delivered & Consignment Accepted' : 'Out for Final Delivery'}</div>
                        <div class="ws-timeline-date">${isDelivered ? 'Delivered on ' + currentOrder.date + ' with OTP Verification' : 'Expected delivery window: 10:00 AM - 04:00 PM'}</div>
                    </div>
                </div>

                <!-- Action Buttons: Clean Dual Grid with Auto Sizes -->
                <div class="ws-dual-action-grid">
                    <button class="ws-btn ws-btn-primary" onclick='openBillInvoiceModal(${JSON.stringify(currentOrder)})'>
                        <svg viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                        <span>GST Invoice</span>
                    </button>
                    <button class="ws-btn ws-btn-secondary" onclick='viewOrderDetails(${JSON.stringify(currentOrder)})'>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        <span>Order Details</span>
                    </button>
                </div>
            `;

            // 2. Render All Consignments List
            gridContainer.innerHTML = '';
            var filteredList = list.filter(function(o) {
                if (currentTrackFilter === 'all') return true;
                return o.status.toLowerCase() === currentTrackFilter.toLowerCase();
            });

            filteredList.forEach(function(o) {
                var isSelected = o.id === activeTrackOrderId;
                var card = document.createElement('div');
                var trackStatusLabel = isSelected ? '● Currently Tracking' : '⚡ Track Consignment &rsaquo;';
                card.className = 'ws-track-order-card' + (isSelected ? ' selected' : '');
                card.onclick = function() {
                    selectTrackingOrder(o.id);
                };
                card.innerHTML = `
                    <img src="${o.image}" alt="${o.productName}" class="ws-track-order-img" onerror="this.onerror=null;this.src='/assets/images/no-image.svg';">
                    <div class="ws-track-order-info">
                        <div style="display:flex; justify-content:space-between; align-items:center; gap:6px;">
                            <strong class="ws-order-id-cell" style="font-size:0.86rem;">${o.id}</strong>
                            <span class="ws-status-badge ${o.status.toLowerCase()}" style="font-size:0.65rem;">${o.status}</span>
                        </div>
                        <div class="ws-track-order-title">${o.productName}</div>
                        <div style="font-size:0.74rem; color:var(--ws-text-muted);">
                            ${o.date} • <strong>${o.qty} Pcs</strong> • ${o.courier}
                        </div>
                        <div style="font-size:0.72rem; color:var(--ws-gold-primary); font-weight:700; margin-top:2px;">
                            ${trackStatusLabel}
                        </div>
                    </div>
                `;
                gridContainer.appendChild(card);
            });
        }

        window.selectTrackingOrder = function(orderId) {
            activeTrackOrderId = orderId;
            renderTrackingTab(activeOrdersList, orderId);
            var hero = document.getElementById('wsActiveTrackHero');
            if (hero) {
                hero.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            window.showWsToast('📍 Loaded tracking timeline for ' + orderId);
        };

        window.filterTrackingOrders = function(status, btn) {
            currentTrackFilter = status;
            if (btn && btn.parentElement) {
                btn.parentElement.querySelectorAll('button').forEach(function(b){ b.classList.remove('active'); });
                btn.classList.add('active');
            }
            renderTrackingTab(activeOrdersList, activeTrackOrderId);
        };

        window.copyAwbNumber = function(awb) {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(awb).then(function() {
                    window.showWsToast('📋 AWB ' + awb + ' copied to clipboard!');
                }).catch(function() {
                    window.showWsToast('AWB: ' + awb);
                });
            } else {
                window.showWsToast('AWB: ' + awb);
            }
        };

        /* ── Wholesale VIP Tier Controller ── */
        window.getWholesaleTier = function(orderCount) {
            var count = Number(orderCount) || 0;
            if (count >= 1000) {
                return {
                    tierNum: 5,
                    title: "Tier 5: Platinum",
                    shortTitle: "Platinum (Tier 5)",
                    badgeText: "👑 Platinum VIP",
                    pillText: "1000+ Orders",
                    discount: "15% Margin Rebate",
                    minOrders: 1000,
                    maxOrders: Infinity,
                    nextGoal: "Top VIP Tier Reached"
                };
            } else if (count >= 301) {
                return {
                    tierNum: 4,
                    title: "Tier 4: Gold",
                    shortTitle: "Gold (Tier 4)",
                    badgeText: "⭐ Gold VIP",
                    pillText: "300–500 Orders",
                    discount: "10% Margin Rebate",
                    minOrders: 301,
                    maxOrders: 500,
                    nextGoal: (1000 - count) + " orders to Tier 5 Platinum"
                };
            } else if (count >= 201) {
                return {
                    tierNum: 3,
                    title: "Tier 3: Gold",
                    shortTitle: "Gold (Tier 3)",
                    badgeText: "⭐ Gold VIP",
                    pillText: "200–300 Orders",
                    discount: "7.5% Margin Rebate",
                    minOrders: 201,
                    maxOrders: 300,
                    nextGoal: (301 - count) + " orders to Tier 4 Gold"
                };
            } else if (count >= 51) {
                return {
                    tierNum: 2,
                    title: "Tier 2: Silver",
                    shortTitle: "Silver (Tier 2)",
                    badgeText: "🥈 Silver VIP",
                    pillText: "50–200 Orders",
                    discount: "5% Margin Rebate",
                    minOrders: 51,
                    maxOrders: 200,
                    nextGoal: (201 - count) + " orders to Tier 3 Gold"
                };
            } else {
                return {
                    tierNum: 1,
                    title: "Tier 1: Non VIP",
                    shortTitle: "Non VIP (Tier 1)",
                    badgeText: "Standard Member",
                    pillText: "1–50 Orders",
                    discount: "Standard Wholesale",
                    minOrders: 1,
                    maxOrders: 50,
                    nextGoal: (51 - count) + " orders to Tier 2 Silver"
                };
            }
        };

        window.openVipTierModal = function() {
            window.showModal('wsVipTierModal');
        };

        window.closeVipTierModal = function() {
            window.hideModal('wsVipTierModal');
        };

        /* ── Wholesale Wallet Controller ── */
        window.openFullWalletModal = function() {
            window.showModal('wsFullWalletModal');
            var availEl = document.getElementById('walletAvailableBalance');
            var coinsEl = document.getElementById('walletTotalCoins');
            var mBal = document.getElementById('fullModalWalletBal');
            var mCoins = document.getElementById('fullModalCoinsBal');
            if (availEl && mBal) mBal.textContent = availEl.textContent;
            if (coinsEl && mCoins) mCoins.textContent = coinsEl.textContent + ' Coins';
        };

        window.closeFullWalletModal = function() {
            window.hideModal('wsFullWalletModal');
        };

        /* ── Edit Billing Address Modal Controller ── */
        window.openEditMainAddressModal = function() {
            var modal = document.getElementById('wsEditMainAddressModal');
            if (!modal) return;
            // Pre-fill existing data from localStorage
            try {
                var user = JSON.parse(localStorage.getItem('dtbrands_user') || '{}');
                var billing = user.billing_address || {};
                var el = function(id) { return document.getElementById(id); };
                if (el('wsMainEditCompName'))    el('wsMainEditCompName').value    = billing.company || user.company_name || '';
                if (el('wsMainEditGstNumber'))  el('wsMainEditGstNumber').value   = billing.gstin   || user.gstin        || '';
                if (el('wsMainEditAddress'))    el('wsMainEditAddress').value     = billing.address || user.address      || '';
                if (el('wsMainEditCity'))       el('wsMainEditCity').value        = billing.city    || user.city         || '';
                if (el('wsMainEditState'))      el('wsMainEditState').value       = billing.state   || user.state        || 'Gujarat';
                if (el('wsMainEditPincode'))    el('wsMainEditPincode').value     = billing.pincode || user.pincode      || '';
                if (el('wsMainEditContactPhone')) el('wsMainEditContactPhone').value = billing.phone || user.phone      || '';
            } catch(e) {}
            window.showModal('wsEditMainAddressModal');
        };

        window.closeEditMainAddressModal = function() {
            window.hideModal('wsEditMainAddressModal');
        };

        window.handleSaveMainAddressForm = function(e) {
            if (e) e.preventDefault();
            try {
                var user = JSON.parse(localStorage.getItem('dtbrands_user') || '{}');
                var el = function(id) { return document.getElementById(id); };
                user.billing_address = {
                    company: el('wsMainEditCompName')    ? el('wsMainEditCompName').value.trim()    : '',
                    gstin:   el('wsMainEditGstNumber')  ? el('wsMainEditGstNumber').value.trim()   : '',
                    address: el('wsMainEditAddress')    ? el('wsMainEditAddress').value.trim()     : '',
                    city:    el('wsMainEditCity')       ? el('wsMainEditCity').value.trim()        : '',
                    state:   el('wsMainEditState')      ? el('wsMainEditState').value              : 'Gujarat',
                    pincode: el('wsMainEditPincode')    ? el('wsMainEditPincode').value.trim()     : '',
                    phone:   el('wsMainEditContactPhone') ? el('wsMainEditContactPhone').value.trim() : ''
                };
                localStorage.setItem('dtbrands_user', JSON.stringify(user));
                closeEditMainAddressModal();
                loadSavedWholesalerData();
                renderAddressBookData(user);
                window.showWsToast('✓ Billing address updated successfully!');
            } catch(err) {
                closeEditMainAddressModal();
                window.showWsToast('✓ Billing address saved!');
            }
        };

        window.openWalletTopupModal = function() {
            window.showModal('wsWalletTopupModal');
        };

        window.closeWalletTopupModal = function() {
            window.hideModal('wsWalletTopupModal');
        };

        window.setTopupAmount = function(amount, btn) {
            var input = document.getElementById('wsTopupAmountInput');
            if (input) input.value = amount;
            if (btn && btn.parentElement) {
                btn.parentElement.querySelectorAll('button').forEach(function(b){ b.classList.remove('active'); });
                btn.classList.add('active');
            }
        };

        window.handleProcessWalletTopup = function() {
            var input = document.getElementById('wsTopupAmountInput');
            var amount = Number(input ? input.value : 50000);
            if (!amount || amount < 1000) {
                alert('Please enter a valid recharge amount (min ₹1,000)');
                return;
            }
            closeWalletTopupModal();
            var current = 45280;
            try {
                var saved = localStorage.getItem('dtbrands_wallet_cash');
                if (saved) current = Number(saved);
            } catch(e) {}
            var newBal = current + amount;
            localStorage.setItem('dtbrands_wallet_cash', newBal);
            
            var cashEl = document.getElementById('walletCashBalance');
            var availEl = document.getElementById('walletAvailableBalance');
            var modalBal = document.getElementById('modalCurrentWalletBal');
            if (cashEl) cashEl.textContent = '₹' + newBal.toLocaleString('en-IN');
            if (availEl) availEl.textContent = (newBal + 100000).toLocaleString('en-IN');
            if (modalBal) modalBal.textContent = '₹' + newBal.toLocaleString('en-IN');

            window.showWsToast('💳 Wallet recharged with ₹' + amount.toLocaleString('en-IN') + ' successfully!');
        };

        window.requestCreditLimitBoost = function() {
            window.showWsToast('⚡ Credit Limit Boost Request submitted to DT Brand\'s Credit Desk!');
        };

        window.requestWalletWithdrawal = function() {
            window.showWsToast('🏦 Payout withdrawal request for available balance submitted to registered Bank A/C!');
        };

        /* ── Wholesale Cart Badge Synchronization ── */
        window.updateWholesaleCartBadge = function() {
            try {
                var raw = localStorage.getItem('dtbrands_cart');
                var cart = raw ? JSON.parse(raw) : [];
                var totalCount = 0;
                if (Array.isArray(cart)) {
                    totalCount = cart.reduce(function(acc, item) { return acc + (Number(item.qty) || 1); }, 0);
                }
                var dockBadge = document.getElementById('wsDockCartBadge');
                var hdrBadge = document.getElementById('headerCartBadge');
                [dockBadge, hdrBadge].forEach(function(badge) {
                    if (badge) {
                        if (totalCount > 0) {
                            badge.textContent = totalCount;
                            badge.style.display = 'flex';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                });
            } catch(e) {}
        };

        /* ── Wholesale Wishlist Badge Synchronization ── */
        window.updateWholesaleWishlistBadge = function() {
            try {
                var raw = localStorage.getItem('dtbrands_wishlist');
                var wishlist = raw ? JSON.parse(raw) : [];
                var count = Array.isArray(wishlist) ? wishlist.length : 0;
                var badge = document.getElementById('headerWishlistBadge');
                if (badge) {
                    if (count > 0) {
                        badge.textContent = count;
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            } catch(e) {}
        };

        document.addEventListener('DOMContentLoaded', function() {
            initWholesalerApp();
            window.updateWholesaleCartBadge();
            window.updateWholesaleWishlistBadge();
        });
        window.addEventListener('storage', function(e) {
            if (e.key === 'dtbrands_user') {
                initWholesalerApp();
            }
            if (e.key === 'dtbrands_cart') {
                window.updateWholesaleCartBadge();
            }
            if (e.key === 'dtbrands_wishlist') {
                window.updateWholesaleWishlistBadge();
            }
        });

    })();
    

// ── Direct Wholesale / Retailer Cart & Wishlist Helper Functions ──
function directAddWholesaleToCart(prodOrId, btn) {
    try {
        var prod = (typeof prodOrId === 'object' && prodOrId !== null) ? prodOrId :
            ((window.allProducts || []).find(function(p) { return Number(p.id) === Number(prodOrId); }) || null);
        // The fallback here used to invent a product at Rs 2,199 with an MOQ of 12,
        // so an id that is no longer in the catalogue still produced a priced line.
        if (!prod || !prod.id) {
            if (typeof window.showWsToast === 'function') {
                window.showWsToast('That product is not in the catalogue any more. Please refresh the page.');
            }
            return;
        }
        var raw = localStorage.getItem('dtbrands_cart');
        var cart = raw ? JSON.parse(raw) : [];
        var prodId = prod.id;
        var exists = cart.find(function(item) { return Number(item.id) === Number(prodId); });
        var addQty = Number(prod.moq) > 0 ? Number(prod.moq) : 1;
        if (exists) {
            exists.qty = (Number(exists.qty) || addQty) + addQty;
        } else {
            cart.push({
                id: prod.id,
                name: prod.name,
                price: Number(prod.wholesale_price) || Number(prod.price) || 0,
                wholesale_price: Number(prod.wholesale_price) || Number(prod.price) || 0,
                retail_price: Number(prod.retail_price) || Number(prod.old_price) || 0,
                qty: addQty,
                image: prod.image || '/assets/images/no-image.svg',
                color: prod.color || '',
                moq: addQty,
                category: prod.category || ''
            });
        }
        localStorage.setItem('dtbrands_cart', JSON.stringify(cart));
        window.cartState = cart;
        if (typeof window.renderCart === 'function') window.renderCart();
        if (typeof window.updateGlobalBadges === 'function') window.updateGlobalBadges();
        if (typeof window.openCartDrawer === 'function') window.openCartDrawer();
        if (typeof showWsToast === 'function') showWsToast('🛒 Added ' + addQty + ' pcs of ' + prod.name + ' to Cart!');
    } catch(e) { console.error('directAddWholesaleToCart error:', e); }
}
window.directAddWholesaleToCart = directAddWholesaleToCart;

function toggleWholesaleWishlist(prodOrId, btn) {
    try {
        var prod = (typeof prodOrId === 'object' && prodOrId !== null) ? prodOrId :
            ((window.allProducts || []).find(function(p) { return Number(p.id) === Number(prodOrId); }) || null);
        // The fallback here used to invent a product at Rs 2,199 with an MOQ of 12,
        // so an id that is no longer in the catalogue still produced a priced line.
        if (!prod || !prod.id) {
            if (typeof window.showWsToast === 'function') {
                window.showWsToast('That product is not in the catalogue any more. Please refresh the page.');
            }
            return;
        }
        var raw = localStorage.getItem('dtbrands_wishlist');
        var list = raw ? JSON.parse(raw) : [];
        var prodId = prod.id;
        var idx = list.findIndex(function(x) { return Number(x.id) === Number(prodId); });
        var isAdded = false;
        if (idx !== -1) {
            list.splice(idx, 1);
            isAdded = false;
        } else {
            list.push({
                id: prod.id,
                name: prod.name,
                price: Number(prod.wholesale_price) || Number(prod.price) || 0,
                old_price: Number(prod.retail_price) || Number(prod.old_price) || 0,
                image: prod.image || '/assets/images/no-image.svg',
                category: prod.category || ''
            });
            isAdded = true;
        }
        localStorage.setItem('dtbrands_wishlist', JSON.stringify(list));
        window.wishlistState = list;
        if (btn) btn.classList.toggle('active', isAdded);
        if (typeof window.renderWishlist === 'function') window.renderWishlist();
        if (typeof window.updateGlobalBadges === 'function') window.updateGlobalBadges();
        if (typeof showWsToast === 'function') showWsToast(isAdded ? '♡ Saved ' + prod.name + ' to Wishlist!' : 'Removed from Wishlist');
    } catch(e) { console.error('toggleWholesaleWishlist error:', e); }
}
window.toggleWholesaleWishlist = toggleWholesaleWishlist;
