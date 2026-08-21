<?php
/**
 * adminheader.php — Luxury Top Header with Shop-Style Clean Desktop & Full-Width Mobile Search Bar
 * DT Brand's & Jai Hanuman Tex
 */
if (!headers_sent()) {
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
}
?>
<header class="adm-header" id="admHeaderMain">
    <!-- ══ Normal Header View (Desktop & Mobile Default) ══ -->
    <div class="adm-header-normal-view">
        <div class="adm-header-left">
            <!-- Mobile Toggle Hamburger Button -->
            <button type="button" class="adm-mobile-menu-btn" id="admMobileMenuBtn" onclick="if(typeof window.toggleAdmMobileSidebar==='function') window.toggleAdmMobileSidebar(event);" title="Toggle Navigation Menu">
                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2.4" fill="none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>

            <!-- Mobile Brand Logo Link -->
            <a href="/Frontend/Admin/admin.php" class="adm-mobile-brand-link" title="DT Brand's Admin CRM">
                <img src="/Shared/Asset/images/logo.png" onerror="this.src='/Frontend/Shop/Asset/images/logo.png';" alt="DT Brand's" class="adm-mobile-logo-img">
                <span class="adm-mobile-brand-title">DT Brand's</span>
            </a>

            <!-- ── Clean Luxury Search Bar with Live Results Dropdown (Desktop) ── -->
            <div class="adm-header-search-container" id="admHeaderSearchContainer">
                <div class="adm-search-amazon-bar" id="admDesktopSearchBox">
                    <svg class="adm-search-icon-left" viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.3">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>

                    <div class="adm-search-input-wrap">
                        <input type="text" id="admGlobalSearch" class="adm-search-input-amazon" placeholder="Search orders, sarees, customers, SKUs (e.g. KLN-SR-111)..." autocomplete="off">
                        <button type="button" id="admGlobalSearchClear" class="adm-search-clear-btn" title="Clear Search">✕</button>
                    </div>

                    <button type="button" class="adm-search-submit-btn" id="admGlobalSearchSubmitBtn" aria-label="Search" onclick="if(typeof window.executeGlobalSearch==='function') window.executeGlobalSearch(document.getElementById('admGlobalSearch').value)">
                        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </button>
                </div>

                <!-- Next-Level Live Search Dropdown Popup List -->
                <div class="adm-live-search-dropdown" id="admGlobalSearchResults"></div>
            </div>
        </div>

        <div class="adm-header-right">
            <!-- Mobile Search Trigger Icon Button (Visible on <= 1024px) -->
            <button type="button" class="adm-mobile-search-trigger-btn" id="admMobileSearchTriggerBtn" onclick="window.openAdmMobileSearch()" title="Search Admin CRM">
                <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2.3" fill="none"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>

            <!-- Live WhatsApp CRM Status Indicator -->
            <div class="adm-live-wa-pill" title="WhatsApp Business Cloud Gateway Connected">
                <span class="adm-pulse-dot"></span>
                <span class="adm-wa-text">WhatsApp Live</span>
            </div>

            <!-- Fast Action: ⚡ Clear Cache & Purge Asset Memory -->
            <button type="button" class="adm-hdr-btn" id="admClearCacheBtn" onclick="window.dtAutoClearCache()" title="Purge Cache & Reload Fresh Assets">
                <svg viewBox="0 0 24 24" width="15" height="15" stroke="currentColor" stroke-width="2.2" fill="none"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
            </button>

            <!-- Notification Bell -->
            <button type="button" class="adm-hdr-btn" title="Notifications" onclick="if(typeof window.showToast==='function') window.showToast('🔔 3 new wholesale orders received today!')">
                <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2.2" fill="none"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                <span class="adm-hdr-badge">3</span>
            </button>

            <!-- Fast Action: + Add Product -->
            <a href="/Frontend/Admin/products/add.php" class="adm-btn-primary" title="Add Product">
                <svg viewBox="0 0 24 24" width="13" height="13" stroke="#181512" stroke-width="2.8" fill="none"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span class="adm-btn-text">Add Product</span>
            </a>

            <!-- Fast Action: Broadcast -->
            <button type="button" class="adm-btn-secondary" onclick="if(typeof switchAdmTab==='function') switchAdmTab('whatsapp'); else window.location.href='/Frontend/Admin/whatsapp/';" title="Broadcast">
                <svg viewBox="0 0 24 24" width="13" height="13" stroke="currentColor" stroke-width="2.2" fill="none"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                <span>Broadcast</span>
            </button>

            <!-- Admin Profile Pill -->
            <div class="adm-hdr-profile" onclick="if(typeof switchAdmTab==='function') switchAdmTab('settings');" title="Super Admin">
                <img src="/Shared/Asset/images/profile.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" alt="Gautam Sethi" class="adm-hdr-avatar">
                <div class="adm-hdr-user-text">
                    <span class="adm-hdr-name">Gautam Sethi</span>
                    <span class="adm-hdr-title">Super Admin</span>
                </div>
                <svg viewBox="0 0 24 24" width="12" height="12" stroke="currentColor" stroke-width="2.2" fill="none" class="adm-hdr-caret"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </div>
        </div>
    </div>

    <!-- ══ Mobile Full-Header Search Bar Overlay (Exact Shop Page Header Style) ══ -->
    <div class="adm-mobile-full-search-bar" id="admMobileFullSearchBar">
        <div class="adm-mobile-search-input-wrap">
            <button type="button" class="adm-mobile-search-submit-icon-btn" onclick="if(typeof window.executeGlobalSearch==='function') window.executeGlobalSearch(document.getElementById('admMobileGlobalSearch').value)">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            </button>
            <input type="text" id="admMobileGlobalSearch" class="adm-mobile-search-input-field" placeholder="Search orders, sarees, customers, SKUs..." autocomplete="off">
            <button type="button" id="admMobileGlobalSearchClear" class="adm-mobile-search-clear-btn" title="Clear Search">✕</button>
        </div>
        <button type="button" class="adm-mobile-search-close-btn" onclick="window.closeAdmMobileSearch()" title="Close Search">
            <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
        <!-- Mobile Live Search Dropdown Popup List -->
        <div class="adm-mobile-live-search-dropdown" id="admMobileGlobalSearchResults"></div>
    </div>
</header>

<script>
(function() {
    'use strict';

    // Fallback Mock Data for Universal Global Search across all Admin pages
    window.DT_GLOBAL_PRODS = [
        { id: 111, sku: 'KLN-SR-111', name: 'Pure Dola Silk Meenakari Saree', category: 'Sarees', wholesale_price: 1399, retail_price: 3499, stock: 95, image: '/Frontend/Shop/Asset/images/product2.png' },
        { id: 109, sku: 'KLN-KT-109', name: 'Party Festive Sharara Suit Set', category: 'Kurtis', wholesale_price: 989, retail_price: 2699, stock: 125, image: '/Frontend/Shop/Asset/images/product5.png' },
        { id: 110, sku: 'KLN-SR-110', name: 'Paithani Rich Pallu Saree', category: 'Sarees', wholesale_price: 1249, retail_price: 3199, stock: 110, image: '/Frontend/Shop/Asset/images/product1.png' },
        { id: 106, sku: 'KLN-SR-106', name: 'Chanderi Silk Festive Saree', category: 'Sarees', wholesale_price: 649, retail_price: 1599, stock: 190, image: '/Frontend/Shop/Asset/images/product1.png' },
        { id: 6,   sku: 'KLN-LH-006', name: 'Bridal Zardosi Lehenga Set', category: 'Lehengas', wholesale_price: 16499, retail_price: 24999, stock: 35, image: '/Frontend/Shop/Asset/images/product6.png' },
        { id: 114, sku: 'KLN-GW-114', name: 'Indo-Western Embroidered Gown', category: 'Gowns', wholesale_price: 1999, retail_price: 4599, stock: 65, image: '/Frontend/Shop/Asset/images/product6.png' },
        { id: 116, sku: 'KLN-DM-116', name: 'Pure Cotton Unstitched Suit Lot', category: 'Dress Materials', wholesale_price: 599, retail_price: 1499, stock: 180, image: '/Frontend/Shop/Asset/images/product3.png' }
    ];

    window.DT_GLOBAL_ORDERS = [
        { id: 'DTB-001620', customer: 'Surat Central Depot (Wholesale Consignee)', city: 'Surat, Gujarat', amount: 54900, status: 'Processing' },
        { id: 'ORD-9842',   customer: 'Shree Balaji Sarees (Kolkata Wholesaler)', city: 'Kolkata, WB', amount: 62450, status: 'Processing' },
        { id: 'DTB-001624', customer: 'Kalyan Brocade Hub (Bangalore Depot)', city: 'Bangalore, KA', amount: 38200, status: 'Delivered' },
        { id: 'DTB-001618', customer: 'Mahalakshmi Silk Mart (Varanasi)', city: 'Varanasi, UP', amount: 48900, status: 'Delivered' }
    ];

    window.DT_GLOBAL_PARTNERS = [
        { name: 'Kalyan Brocade Hub', city: 'Surat / Bangalore', phone: '+91 98220 19283', tier: 'Verified Wholesaler' },
        { name: 'Shree Balaji Sarees', city: 'Kolkata Central Market', phone: '+91 98450 11223', tier: 'Gold Distributor' },
        { name: 'Radha Krishna Silks', city: 'Ahmedabad Ring Road', phone: '+91 97120 44556', tier: 'VIP Partner' }
    ];

    // ════ ⚡ UNIVERSAL AUTO CLEAR CACHE ENGINE ════
    window.dtAutoClearCache = function() {
        try {
            // 1. Clear Web Application Cache Storage
            if ('caches' in window) {
                caches.keys().then(function(cacheNames) {
                    return Promise.all(cacheNames.map(function(cName) { return caches.delete(cName); }));
                });
            }
            // 2. Clear Session Storage
            sessionStorage.clear();

            // 3. Clear transient Local Storage while preserving sidebar toggle pref
            const savedSidebarPref = localStorage.getItem('dt_adm_sidebar_collapsed');
            localStorage.clear();
            if (savedSidebarPref !== null) {
                localStorage.setItem('dt_adm_sidebar_collapsed', savedSidebarPref);
            }
            localStorage.setItem('dt_cache_bust', Date.now().toString());

            // 4. Show Instant Feedback Toast
            if (typeof window.showToast === 'function') {
                window.showToast('🧹 Cache successfully purged! Reloading fresh assets...');
            }

            // 5. Force Browser to Request Fresh Uncached Assets with Timestamp
            setTimeout(() => {
                const url = new URL(window.location.href);
                url.searchParams.set('v_fresh', Date.now().toString());
                window.location.href = url.toString();
            }, 350);
        } catch(err) {
            console.error('Cache purge error:', err);
            window.location.reload();
        }
    };

    window.openAdmMobileSearch = function() {
        const header = document.getElementById('admHeaderMain') || document.querySelector('.adm-header');
        if (header) {
            header.classList.add('mobile-search-active');
            setTimeout(() => {
                const input = document.getElementById('admMobileGlobalSearch');
                if (input) {
                    input.focus();
                    input.select();
                }
            }, 60);
        }
    };

    window.closeAdmMobileSearch = function() {
        const header = document.getElementById('admHeaderMain') || document.querySelector('.adm-header');
        if (header) {
            header.classList.remove('mobile-search-active');
            const input = document.getElementById('admMobileGlobalSearch');
            if (input) input.value = '';
            const clearBtn = document.getElementById('admMobileGlobalSearchClear');
            if (clearBtn) clearBtn.style.display = 'none';
            const res = document.getElementById('admMobileGlobalSearchResults');
            if (res) res.style.display = 'none';
        }
    };

    window.handleAdmHeaderLiveSearch = function(query, isMobile) {
        const targetContainer = isMobile 
            ? document.getElementById('admMobileGlobalSearchResults') 
            : document.getElementById('admGlobalSearchResults');

        if (!targetContainer) return;

        if (!query || query.trim().length === 0) {
            targetContainer.style.display = 'none';
            targetContainer.innerHTML = '';
            return;
        }

        const q = query.trim().toLowerCase();
        const prods = (window.products || window.DT_GLOBAL_PRODS || []).filter(p => 
            (p.name && p.name.toLowerCase().includes(q)) || 
            (p.sku && p.sku.toLowerCase().includes(q)) ||
            (p.category && p.category.toLowerCase().includes(q))
        ).slice(0, 4);

        const ords = (window.orders || window.DT_GLOBAL_ORDERS || []).filter(o => 
            (o.id && o.id.toLowerCase().includes(q)) || 
            (o.customer && o.customer.toLowerCase().includes(q)) ||
            (o.city && o.city.toLowerCase().includes(q))
        ).slice(0, 3);

        const parts = (window.partners || window.DT_GLOBAL_PARTNERS || []).filter(pt => 
            (pt.name && pt.name.toLowerCase().includes(q)) || 
            (pt.city && pt.city.toLowerCase().includes(q)) ||
            (pt.phone && pt.phone.toLowerCase().includes(q))
        ).slice(0, 3);

        const totalMatches = prods.length + ords.length + parts.length;

        if (totalMatches === 0) {
            targetContainer.innerHTML = `
                <div class="adm-live-search-empty">
                    <div style="font-size:22px; margin-bottom:6px;">🔍</div>
                    <div style="font-weight:700; color:#181512; margin-bottom:3px;">No direct records for "${query}"</div>
                    <div style="font-size:11px; color:#64748B;">Try searching <i>Saree</i>, <i>KLN-SR-111</i>, or <i>DTB-001620</i>.</div>
                </div>
            `;
            targetContainer.style.display = 'block';
            return;
        }

        let html = `
            <div class="adm-live-search-header">
                <span>🔍 Live Results for "<b>${query}</b>"</span>
                <span class="adm-live-search-count-badge">${totalMatches} Record${totalMatches === 1 ? '' : 's'}</span>
            </div>
        `;

        if (prods.length > 0) {
            html += `
                <div class="adm-live-search-group">
                    <div class="adm-live-search-group-title">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        <span>Products &amp; SKUs (${prods.length})</span>
                    </div>
            `;
            prods.forEach(p => {
                html += `
                    <div class="adm-live-search-item" onclick="window.selectSearchProduct('${p.id}', '${p.sku}')">
                        <img src="${p.image}" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" alt="${p.name}" class="adm-live-search-thumb">
                        <div class="adm-live-search-info">
                            <div class="adm-live-search-title">${p.name}</div>
                            <div class="adm-live-search-sub">
                                <span style="font-weight:700; color:#8A681F;">${p.sku}</span>
                                <span>•</span>
                                <span>${p.category}</span>
                                <span>•</span>
                                <span style="color:#15803D; font-weight:700;">₹${(p.wholesale_price || 0).toLocaleString()} (Wholesale)</span>
                            </div>
                        </div>
                        <span class="adm-live-search-badge" style="background:#DCFCE7; color:#15803D; border:1px solid #BBF7D0;">${p.stock} in Stock</span>
                    </div>
                `;
            });
            html += `</div>`;
        }

        if (ords.length > 0) {
            html += `
                <div class="adm-live-search-group">
                    <div class="adm-live-search-group-title">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                        <span>Wholesale Orders (${ords.length})</span>
                    </div>
            `;
            ords.forEach(o => {
                const statusColor = o.status === 'Delivered' ? '#15803D' : (o.status === 'Processing' ? '#B45309' : '#1D4ED8');
                const statusBg = o.status === 'Delivered' ? '#DCFCE7' : (o.status === 'Processing' ? '#FEF3C7' : '#EFF6FF');
                html += `
                    <div class="adm-live-search-item" onclick="window.selectSearchOrder('${o.id}')">
                        <div class="adm-live-search-avatar" style="border-radius:6px; font-size:10px;">📦</div>
                        <div class="adm-live-search-info">
                            <div class="adm-live-search-title">Order #${o.id} — ${o.customer}</div>
                            <div class="adm-live-search-sub">
                                <span>${o.city || 'Surat Central Depot'}</span>
                                <span>•</span>
                                <span style="font-weight:700; color:#181512;">₹${(o.amount || 0).toLocaleString()}</span>
                            </div>
                        </div>
                        <span class="adm-live-search-badge" style="background:${statusBg}; color:${statusColor}; border:1px solid ${statusColor}33;">${o.status}</span>
                    </div>
                `;
            });
            html += `</div>`;
        }

        if (parts.length > 0) {
            html += `
                <div class="adm-live-search-group">
                    <div class="adm-live-search-group-title">
                        <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span>Wholesalers &amp; Partners (${parts.length})</span>
                    </div>
            `;
            parts.forEach(pt => {
                const initials = pt.name ? pt.name.split(' ').map(w => w[0]).join('').substring(0,2).toUpperCase() : 'PT';
                html += `
                    <div class="adm-live-search-item" onclick="window.selectSearchPartner('${pt.name}')">
                        <div class="adm-live-search-avatar">${initials}</div>
                        <div class="adm-live-search-info">
                            <div class="adm-live-search-title">${pt.name}</div>
                            <div class="adm-live-search-sub">
                                <span>${pt.city}</span>
                                <span>•</span>
                                <span>${pt.phone}</span>
                            </div>
                        </div>
                        <span class="adm-live-search-badge" style="background:#FAF5E8; color:#8A681F; border:1px solid #D4AF37;">${pt.tier || 'Verified Wholesaler'}</span>
                    </div>
                `;
            });
            html += `</div>`;
        }

        html += `
            <div class="adm-live-search-footer">
                <span>Click any record to open</span>
                <span style="color:#8A681F; font-weight:800; cursor:pointer;" onclick="window.executeGlobalSearch('${query}')">View in CRM ➔</span>
            </div>
        `;

        targetContainer.innerHTML = html;
        targetContainer.style.display = 'block';
    };

    window.selectSearchProduct = function(prodId, sku) {
        hideAllLiveSearchResults();
        if (typeof window.switchAdmTab === 'function') {
            window.switchAdmTab('products');
            const searchBox = document.getElementById('admProdSearch');
            if (searchBox) {
                searchBox.value = sku || '';
                if (typeof filterProducts === 'function') filterProducts();
            }
        } else {
            window.location.href = `/Frontend/Admin/admin.php#products`;
        }
        if (window.showToast) window.showToast(`👗 Navigated to Product SKU: ${sku}`);
    };

    window.selectSearchOrder = function(orderId) {
        hideAllLiveSearchResults();
        window.location.href = `/Frontend/Admin/orders/view.php?id=${encodeURIComponent(orderId)}`;
    };

    window.selectSearchPartner = function(partnerName) {
        hideAllLiveSearchResults();
        if (typeof window.switchAdmTab === 'function') {
            window.switchAdmTab('partners');
            const searchBox = document.getElementById('admPartnerSearch');
            if (searchBox) {
                searchBox.value = partnerName || '';
                if (typeof filterPartners === 'function') filterPartners();
            }
        } else {
            window.location.href = `/Frontend/Admin/admin.php#partners`;
        }
        if (window.showToast) window.showToast(`👤 Navigated to Partner: ${partnerName}`);
    };

    window.executeGlobalSearch = function(query) {
        hideAllLiveSearchResults();
        if (!query || !query.trim()) return;
        const q = query.trim().toLowerCase();

        // Check matching order ID
        const ords = (window.orders || window.DT_GLOBAL_ORDERS || []);
        const foundOrder = ords.find(o => o.id.toLowerCase().includes(q) || o.customer.toLowerCase().includes(q));
        if (foundOrder) {
            window.location.href = `/Frontend/Admin/orders/view.php?id=${encodeURIComponent(foundOrder.id)}`;
            return;
        }

        // Check products
        const prods = (window.products || window.DT_GLOBAL_PRODS || []);
        const foundProd = prods.find(p => p.name.toLowerCase().includes(q) || p.sku.toLowerCase().includes(q));
        if (foundProd) {
            if (typeof window.switchAdmTab === 'function') {
                window.switchAdmTab('products');
                const searchBox = document.getElementById('admProdSearch');
                if (searchBox) {
                    searchBox.value = query;
                    if (typeof filterProducts === 'function') filterProducts();
                }
            } else {
                window.location.href = `/Frontend/Admin/admin.php#products`;
            }
            return;
        }

        // Default redirect to Orders or Admin
        if (typeof window.switchAdmTab === 'function') {
            window.switchAdmTab('orders');
            const searchBox = document.getElementById('admOrderSearch');
            if (searchBox) {
                searchBox.value = query;
                if (typeof filterOrders === 'function') filterOrders();
            }
        } else {
            window.location.href = `/Frontend/Admin/orders/view.php?id=DTB-001620`;
        }
    };

    function hideAllLiveSearchResults() {
        const d = document.getElementById('admGlobalSearchResults');
        if (d) d.style.display = 'none';
        const md = document.getElementById('admMobileGlobalSearchResults');
        if (md) md.style.display = 'none';
    }

    // Auto-setup listeners when DOM is loaded
    function setupHeaderSearchEngine() {
        const desktopInput = document.getElementById('admGlobalSearch');
        const desktopClear = document.getElementById('admGlobalSearchClear');
        const mobileInput = document.getElementById('admMobileGlobalSearch');
        const mobileClear = document.getElementById('admMobileGlobalSearchClear');

        if (desktopInput) {
            desktopInput.addEventListener('input', function() {
                if (desktopClear) desktopClear.style.display = this.value.trim() ? 'flex' : 'none';
                window.handleAdmHeaderLiveSearch(this.value, false);
            });
            desktopInput.addEventListener('focus', function() {
                if (this.value.trim().length > 0) window.handleAdmHeaderLiveSearch(this.value, false);
            });
            desktopInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    window.executeGlobalSearch(this.value);
                }
            });
        }

        if (desktopClear) {
            desktopClear.addEventListener('click', function() {
                if (desktopInput) {
                    desktopInput.value = '';
                    desktopClear.style.display = 'none';
                    desktopInput.focus();
                    window.handleAdmHeaderLiveSearch('', false);
                }
            });
        }

        if (mobileInput) {
            mobileInput.addEventListener('input', function() {
                if (mobileClear) mobileClear.style.display = this.value.trim() ? 'flex' : 'none';
                window.handleAdmHeaderLiveSearch(this.value, true);
            });
            mobileInput.addEventListener('focus', function() {
                if (this.value.trim().length > 0) window.handleAdmHeaderLiveSearch(this.value, true);
            });
            mobileInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    window.executeGlobalSearch(this.value);
                }
            });
        }

        if (mobileClear) {
            mobileClear.addEventListener('click', function() {
                if (mobileInput) {
                    mobileInput.value = '';
                    mobileClear.style.display = 'none';
                    mobileInput.focus();
                    window.handleAdmHeaderLiveSearch('', true);
                }
            });
        }

        // Dismiss on Click outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#admHeaderSearchContainer') && !e.target.closest('#admMobileFullSearchBar')) {
                hideAllLiveSearchResults();
            }
        });

        // Dismiss on Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                hideAllLiveSearchResults();
                window.closeAdmMobileSearch();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupHeaderSearchEngine);
    } else {
        setupHeaderSearchEngine();
    }
})();
</script>

