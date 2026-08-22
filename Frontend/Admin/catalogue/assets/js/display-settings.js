/**
 * display-settings.js — DT Brand's Storefront Display Settings & Real-Time Simulator
 * DT Brand's & Jai Hanuman Tex
 */
(function() {
    'use strict';

    // Default configuration state
    const defaultSettings = {
        desktopCols: '4',
        tabletCols: '2',
        mobileCols: '2',
        aspectRatio: '3-4',
        hoverEffect: 'flip',
        borderRadius: '8',
        perPage: '24',
        paginationMode: 'loadmore',
        sidebarPlacement: 'left',
        showDiscount: true,
        showMoq: true,
        showMargin: true,
        showDispatch: true,
        showRating: true,
        showFabricTag: true,
        showWhatsAppBtn: true,
        showQuickView: true,
        guestPriceMode: 'wholesale_blur'
    };

    let currentSettings = Object.assign({}, defaultSettings);

    // Initialize from localStorage if exists
    function loadSavedSettings() {
        try {
            const saved = localStorage.getItem('dt_cat_display_settings');
            if (saved) {
                currentSettings = Object.assign({}, defaultSettings, JSON.parse(saved));
            }
        } catch(e) {}
    }

    // Apply settings to form inputs and simulator
    function syncFormAndSimulator() {
        // Sync Desktop Cols Tiles
        document.querySelectorAll('.dt-tile-opt[data-target="desktopCols"]').forEach(el => {
            el.classList.toggle('active', el.getAttribute('data-val') === currentSettings.desktopCols);
        });

        // Sync Aspect Ratio Tiles
        document.querySelectorAll('.dt-tile-opt[data-target="aspectRatio"]').forEach(el => {
            el.classList.toggle('active', el.getAttribute('data-val') === currentSettings.aspectRatio);
        });

        // Sync Hover Effect Tiles
        document.querySelectorAll('.dt-tile-opt[data-target="hoverEffect"]').forEach(el => {
            el.classList.toggle('active', el.getAttribute('data-val') === currentSettings.hoverEffect);
        });

        // Sync Sidebar Placement Tiles
        document.querySelectorAll('.dt-tile-opt[data-target="sidebarPlacement"]').forEach(el => {
            el.classList.toggle('active', el.getAttribute('data-val') === currentSettings.sidebarPlacement);
        });

        // Sync Pagination Mode Tiles
        document.querySelectorAll('.dt-tile-opt[data-target="paginationMode"]').forEach(el => {
            el.classList.toggle('active', el.getAttribute('data-val') === currentSettings.paginationMode);
        });

        // Sync Select Dropdowns
        const selTablet = document.getElementById('selTabletCols');
        if (selTablet) selTablet.value = currentSettings.tabletCols;

        const selMobile = document.getElementById('selMobileCols');
        if (selMobile) selMobile.value = currentSettings.mobileCols;

        const selPerPage = document.getElementById('selPerPage');
        if (selPerPage) selPerPage.value = currentSettings.perPage;

        const selGuest = document.getElementById('selGuestPriceMode');
        if (selGuest) selGuest.value = currentSettings.guestPriceMode;

        // Sync Toggle Switches
        const toggleMap = {
            'chkShowDiscount': 'showDiscount',
            'chkShowMoq': 'showMoq',
            'chkShowMargin': 'showMargin',
            'chkShowDispatch': 'showDispatch',
            'chkShowRating': 'showRating',
            'chkShowFabricTag': 'showFabricTag',
            'chkShowWhatsAppBtn': 'showWhatsAppBtn',
            'chkShowQuickView': 'showQuickView'
        };

        for (const [id, key] of Object.entries(toggleMap)) {
            const chk = document.getElementById(id);
            if (chk) chk.checked = !!currentSettings[key];
        }

        // Update Simulator DOM
        updateSimulatorDOM();
    }

    // Update Simulator preview elements
    function updateSimulatorDOM() {
        const grid = document.getElementById('dtSimGrid');
        if (!grid) return;

        // Active viewport mode
        const activeTab = document.querySelector('.dt-sim-tab-btn.active');
        const mode = activeTab ? activeTab.getAttribute('data-mode') : 'desktop';

        // Apply grid column class based on active viewport
        grid.className = 'dt-sim-grid';
        if (mode === 'desktop') {
            grid.classList.add('cols-' + currentSettings.desktopCols);
        } else if (mode === 'tablet') {
            grid.classList.add('cols-' + currentSettings.tabletCols);
        } else if (mode === 'mobile') {
            grid.classList.add('cols-' + currentSettings.mobileCols);
        }

        // Apply image aspect ratio
        document.querySelectorAll('.dt-sim-img-wrap').forEach(el => {
            el.className = 'dt-sim-img-wrap ratio-' + currentSettings.aspectRatio;
        });

        // Toggle Badges Visibility in Simulator
        document.querySelectorAll('.dt-sim-badge-discount').forEach(el => {
            el.style.display = currentSettings.showDiscount ? 'block' : 'none';
        });

        document.querySelectorAll('.dt-sim-badge-moq').forEach(el => {
            el.style.display = currentSettings.showMoq ? 'block' : 'none';
        });

        document.querySelectorAll('.dt-sim-badge-dispatch').forEach(el => {
            el.style.display = currentSettings.showDispatch ? 'block' : 'none';
        });

        document.querySelectorAll('.dt-sim-margin-tag').forEach(el => {
            el.style.display = currentSettings.showMargin ? 'inline-block' : 'none';
        });

        document.querySelectorAll('.dt-sim-rating-row').forEach(el => {
            el.style.display = currentSettings.showRating ? 'flex' : 'none';
        });

        document.querySelectorAll('.dt-sim-cat-tag').forEach(el => {
            el.style.display = currentSettings.showFabricTag ? 'block' : 'none';
        });

        document.querySelectorAll('.dt-sim-btn-wa').forEach(el => {
            el.style.display = currentSettings.showWhatsAppBtn ? 'flex' : 'none';
        });

        // Update Stat Banner values
        const statCols = document.getElementById('statActiveCols');
        if (statCols) statCols.textContent = currentSettings.desktopCols + '-Column Grid';

        const statRatio = document.getElementById('statActiveRatio');
        if (statRatio) {
            const ratioLabels = {
                '1-1': '1:1 Square',
                '3-4': '3:4 Saree Fashion',
                '4-5': '4:5 Luxury Catalog',
                '9-16': '9:16 Mobile Reel'
            };
            statRatio.textContent = ratioLabels[currentSettings.aspectRatio] || currentSettings.aspectRatio;
        }
    }

    // Bind event listeners
    function initEvents() {
        // Tile click handlers
        document.querySelectorAll('.dt-tile-opt').forEach(tile => {
            tile.addEventListener('click', function() {
                const target = this.getAttribute('data-target');
                const val = this.getAttribute('data-val');
                if (target && val) {
                    currentSettings[target] = val;
                    syncFormAndSimulator();
                }
            });
        });

        // Select change handlers
        const selTablet = document.getElementById('selTabletCols');
        if (selTablet) {
            selTablet.addEventListener('change', function() {
                currentSettings.tabletCols = this.value;
                updateSimulatorDOM();
            });
        }

        const selMobile = document.getElementById('selMobileCols');
        if (selMobile) {
            selMobile.addEventListener('change', function() {
                currentSettings.mobileCols = this.value;
                updateSimulatorDOM();
            });
        }

        const selPerPage = document.getElementById('selPerPage');
        if (selPerPage) {
            selPerPage.addEventListener('change', function() {
                currentSettings.perPage = this.value;
            });
        }

        const selGuest = document.getElementById('selGuestPriceMode');
        if (selGuest) {
            selGuest.addEventListener('change', function() {
                currentSettings.guestPriceMode = this.value;
            });
        }

        // Toggle switch handlers
        const toggleMap = {
            'chkShowDiscount': 'showDiscount',
            'chkShowMoq': 'showMoq',
            'chkShowMargin': 'showMargin',
            'chkShowDispatch': 'showDispatch',
            'chkShowRating': 'showRating',
            'chkShowFabricTag': 'showFabricTag',
            'chkShowWhatsAppBtn': 'showWhatsAppBtn',
            'chkShowQuickView': 'showQuickView'
        };

        for (const [id, key] of Object.entries(toggleMap)) {
            const chk = document.getElementById(id);
            if (chk) {
                chk.addEventListener('change', function() {
                    currentSettings[key] = this.checked;
                    updateSimulatorDOM();
                });
            }
        }

        // Viewport Switcher in Simulator Header
        document.querySelectorAll('.dt-sim-tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.dt-sim-tab-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const stage = document.querySelector('.dt-sim-stage-wrap');
                const mode = this.getAttribute('data-mode');
                if (stage) {
                    if (mode === 'mobile') {
                        stage.style.maxWidth = '360px';
                        stage.style.margin = '0 auto';
                    } else if (mode === 'tablet') {
                        stage.style.maxWidth = '600px';
                        stage.style.margin = '0 auto';
                    } else {
                        stage.style.maxWidth = '100%';
                        stage.style.margin = '0';
                    }
                }
                updateSimulatorDOM();
            });
        });
    }

    // Save Display Settings to localStorage & trigger toast
    window.saveDisplaySettings = function() {
        try {
            localStorage.setItem('dt_cat_display_settings', JSON.stringify(currentSettings));
        } catch(e) {}

        if (typeof window.showToast === 'function') {
            window.showToast('✨ Storefront Display Settings saved & synced successfully!');
        } else if (window.DT_CATALOGUE && typeof window.DT_CATALOGUE.showToast === 'function') {
            window.DT_CATALOGUE.showToast('✨ Storefront Display Settings saved & synced successfully!');
        } else {
            alert('Storefront Display Settings saved successfully!');
        }
    };

    // Reset Defaults
    window.resetDisplayDefaults = function() {
        if (!confirm('Are you sure you want to reset all storefront display settings to factory defaults?')) {
            return;
        }
        currentSettings = Object.assign({}, defaultSettings);
        try {
            localStorage.removeItem('dt_cat_display_settings');
        } catch(e) {}
        syncFormAndSimulator();

        if (typeof window.showToast === 'function') {
            window.showToast('🔄 Display settings restored to default layout.');
        }
    };

    // Copy JSON configuration
    window.copyDisplayJson = function() {
        const jsonStr = JSON.stringify(currentSettings, null, 2);
        navigator.clipboard.writeText(jsonStr).then(() => {
            if (typeof window.showToast === 'function') {
                window.showToast('📋 Display Configuration JSON copied to clipboard!');
            }
        });
    };

    // Initialize on DOM Ready
    document.addEventListener('DOMContentLoaded', function() {
        loadSavedSettings();
        syncFormAndSimulator();
        initEvents();
    });

})();
