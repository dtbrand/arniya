/**
 * catalogue.js — Master JavaScript Controller for DT Brand's Catalogue Module
 * DT Brand's & Jai Hanuman Tex
 */

window.DT_CATALOGUE = {
    // Show Toast notification using Admin Toast or fallback
    showToast: function(msg, type = 'gold') {
        if (typeof window.showToast === 'function') {
            window.showToast(msg);
            return;
        }
        let container = document.getElementById('dtToastContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'dtToastContainer';
            container.style.cssText = 'position:fixed; bottom:20px; right:20px; z-index:999999; display:flex; flex-direction:column; gap:8px;';
            document.body.appendChild(container);
        }
        const toast = document.createElement('div');
        toast.style.cssText = 'background:#181512; color:#fff; border:1px solid #D4AF37; border-radius:6px; padding:10px 16px; font-size:12px; font-weight:700; box-shadow:0 4px 14px rgba(0,0,0,0.25); display:flex; align-items:center; gap:8px; animation:fadeIn 0.2s ease;';
        toast.innerHTML = `<span style="color:#D4AF37;">✦</span> <span>${msg}</span>`;
        container.appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    },

    // Real-time table filter with 1-tap clear button
    filterTable: function(inputId, tableId, clearBtnId) {
        const input = document.getElementById(inputId);
        const table = document.getElementById(tableId);
        const clearBtn = clearBtnId ? document.getElementById(clearBtnId) : null;
        if (!input || !table) return;

        const val = input.value.toLowerCase().trim();
        if (clearBtn) {
            clearBtn.style.display = val.length > 0 ? 'inline' : 'none';
        }

        const rows = table.querySelectorAll('tbody tr');
        let matches = 0;
        rows.forEach(r => {
            const txt = r.textContent.toLowerCase();
            if (txt.includes(val)) {
                r.style.display = '';
                matches++;
            } else {
                r.style.display = 'none';
            }
        });
    },

    // Clear search
    clearSearch: function(inputId, tableId, clearBtnId) {
        const input = document.getElementById(inputId);
        if (input) {
            input.value = '';
            this.filterTable(inputId, tableId, clearBtnId);
            input.focus();
        }
    },

    // Master Select All Checkboxes
    toggleSelectAll: function(master, childClass = 'dt-row-check') {
        const checks = document.querySelectorAll('.' + childClass);
        checks.forEach(c => c.checked = master.checked);
    },

    // Apply Bulk Actions
    applyBulkAction: function(selectId, checkClass) {
        const select = document.getElementById(selectId);
        if (!select || !select.value) {
            this.showToast('Please select a bulk action from the dropdown.');
            return;
        }
        const action = select.value;
        const checkedBoxes = Array.from(document.querySelectorAll('.' + checkClass + ':checked'));
        if (checkedBoxes.length === 0) {
            this.showToast('Please select at least one item first.');
            return;
        }

        const count = checkedBoxes.length;
        if (action === 'activate') {
            checkedBoxes.forEach(chk => {
                const row = chk.closest('tr');
                if (row) {
                    row.setAttribute('data-status', 'active');
                    const badge = row.querySelector('.dt-badge.red, .dt-badge.gray');
                    if (badge) {
                        badge.className = 'dt-badge green';
                        badge.textContent = 'Active';
                    }
                }
            });
            this.showToast(`✅ Activated ${count} selected categories!`);
        } else if (action === 'deactivate') {
            checkedBoxes.forEach(chk => {
                const row = chk.closest('tr');
                if (row) {
                    row.setAttribute('data-status', 'inactive');
                    const badge = row.querySelector('.dt-badge.green');
                    if (badge) {
                        badge.className = 'dt-badge gray';
                        badge.textContent = 'Inactive';
                    }
                }
            });
            this.showToast(`⏸️ Deactivated ${count} selected categories!`);
        } else if (action === 'feature') {
            checkedBoxes.forEach(chk => {
                const row = chk.closest('tr');
                if (row) {
                    const starBtn = row.querySelector('.wp-star-btn');
                    if (starBtn) {
                        starBtn.classList.add('active');
                        starBtn.style.color = '#D4AF37';
                    }
                }
            });
            this.showToast(`⭐ Marked ${count} categories as Featured!`);
        } else if (action === 'delete') {
            if (!confirm(`Are you sure you want to delete ${count} selected categories?`)) return;
            checkedBoxes.forEach(chk => {
                const row = chk.closest('tr');
                if (row) {
                    row.style.transition = 'all 0.25s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(20px)';
                    setTimeout(() => row.remove(), 250);
                }
            });
            this.showToast(`🗑️ Deleted ${count} selected categories!`);
        }
    },

    // Delete row with smooth animation
    deleteRow: function(rowId, itemName) {
        if (!confirm(`Are you sure you want to delete "${itemName}"?`)) return;
        const row = document.getElementById(rowId);
        if (!row) return;

        row.style.transition = 'all 0.25s ease';
        row.style.opacity = '0';
        row.style.transform = 'translateX(20px)';
        setTimeout(() => {
            row.remove();
            this.showToast(`🗑️ "${itemName}" deleted successfully!`);
        }, 250);
    },

    // Image preview helper for file inputs
    previewImage: function(input, targetImgId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById(targetImgId);
                if (img) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    },

    // Auto Slug Generator
    generateSlug: function(sourceInputId, targetSlugId) {
        const src = document.getElementById(sourceInputId);
        const tgt = document.getElementById(targetSlugId);
        if (src && tgt) {
            tgt.value = src.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-');
        }
    },

    // ════ AI SEO Auto-Generator ════
    generateAiSeo: function(catName, catSlug) {
        const titleInput = document.getElementById('seoTitleInput');
        const descInput = document.getElementById('seoDescInput');
        const titleDisplay = document.getElementById('serpTitleDisplay');
        const descDisplay = document.getElementById('serpDescDisplay');
        const titleCount = document.getElementById('seoTitleCount');
        const descCount = document.getElementById('seoDescCount');

        const cleanName = catName || 'Silk Sarees & Handlooms';
        const cleanSlug = catSlug || cleanName.toLowerCase().replace(/[^a-z0-9]+/g, '-');

        const aiTitles = [
            `Pure ${cleanName} Wholesale | Direct Surat Factory Rates`,
            `Buy Authentic ${cleanName} Wholesale Catalogues | DT Brand's`,
            `Surat ${cleanName} Central Depot Wholesale Ready Stock Lots`
        ];

        const aiDescriptions = [
            `Buy authentic pure ${cleanName.toLowerCase()} at direct Surat factory wholesale rates. Certified handloom and luxury weaves with fast 24h ready depot dispatch across India.`,
            `Explore Surat's finest ${cleanName.toLowerCase()} collection. Exclusive wholesale lot deals, GST invoicing, verified Silk Mark quality, and instant WhatsApp support.`,
            `Premium ${cleanName.toLowerCase()} wholesale assortment from Surat central depot. Best reseller profit margins, low MOQ lot bundles, and express doorstep delivery.`
        ];

        const selectedTitle = aiTitles[Math.floor(Math.random() * aiTitles.length)];
        const selectedDesc = aiDescriptions[Math.floor(Math.random() * aiDescriptions.length)];

        if (titleInput) {
            titleInput.value = selectedTitle;
            if (titleDisplay) titleDisplay.textContent = selectedTitle;
            if (titleCount) titleCount.textContent = selectedTitle.length + ' / 60';
        }

        if (descInput) {
            descInput.value = selectedDesc;
            if (descDisplay) descDisplay.textContent = selectedDesc;
            if (descCount) descCount.textContent = selectedDesc.length + ' / 160';
        }

        this.showToast(`✨ AI SEO Meta Generated for "${cleanName}"!`);
    },

    // ════ AI Category Description Auto-Generator ════
    generateAiCategoryDesc: function(targetTextareaId, catName) {
        const textarea = document.getElementById(targetTextareaId);
        if (!textarea) return;

        const cleanName = catName || 'Silk Sarees & Handlooms';
        const aiDescs = [
            `Surat central depot master collection of pure ${cleanName.toLowerCase()}. Sourced directly from registered master weavers with certified zari purity, authentic border weaving, and 24-hour priority dispatch for wholesale buyers and boutiques.`,
            `Handcrafted and premium powerloom ${cleanName.toLowerCase()} manufactured in Surat textile hub. High colorfastness, rich pallu motifs, standard wholesale bundle packaging, and verified reseller price margins.`,
            `Exclusive festive and bridal ${cleanName.toLowerCase()} assortment featuring heavy zari embroidery, soft drape fabrics, and Silk Mark certified handloom lots tailored for top retail boutiques.`
        ];

        const selected = aiDescs[Math.floor(Math.random() * aiDescs.length)];
        textarea.value = selected;
        this.showToast(`✨ AI Generated Description for "${cleanName}"!`);
    },

    // ════ Interactive Device Preview Switcher (Desktop vs Mobile) ════
    switchDevicePreview: function(device) {
        const btnDesk = document.getElementById('btnPrevDesk');
        const btnMob = document.getElementById('btnPrevMob');
        const boxDesk = document.getElementById('prevBoxDesk');
        const boxMob = document.getElementById('prevBoxMob');

        if (device === 'mob') {
            if (btnDesk) btnDesk.classList.remove('active');
            if (btnMob) btnMob.classList.add('active');
            if (boxDesk) boxDesk.style.display = 'none';
            if (boxMob) boxMob.style.display = 'block';
        } else {
            if (btnMob) btnMob.classList.remove('active');
            if (btnDesk) btnDesk.classList.add('active');
            if (boxMob) boxMob.style.display = 'none';
            if (boxDesk) boxDesk.style.display = 'block';
        }
    },

    // ════ Banner Ratio Change Handler ════
    updateBannerRatio: function(type, ratio) {
        if (type === 'desk') {
            const deskImg = document.getElementById('deskBannerPreview');
            const liveDeskImg = document.getElementById('liveDeskImg');
            if (deskImg) {
                if (ratio === '1-1') deskImg.style.height = '180px';
                else if (ratio === '4-1') deskImg.style.height = '70px';
                else deskImg.style.height = '90px';
            }
            if (liveDeskImg) {
                if (ratio === '1-1') liveDeskImg.style.height = '180px';
                else if (ratio === '4-1') liveDeskImg.style.height = '70px';
                else liveDeskImg.style.height = '90px';
            }
            this.showToast(`🖥️ Desktop banner aspect ratio set to ${ratio}!`);
        } else {
            const mobImg = document.getElementById('mobileBannerPreview');
            if (mobImg) {
                if (ratio === '1-1') { mobImg.style.width = '140px'; mobImg.style.height = '140px'; }
                else if (ratio === '9-16') { mobImg.style.width = '110px'; mobImg.style.height = '190px'; }
                else if (ratio === '2-1') { mobImg.style.width = '180px'; mobImg.style.height = '80px'; }
                else { mobImg.style.width = '120px'; mobImg.style.height = '150px'; }
            }
            this.showToast(`📱 Mobile banner aspect ratio set to ${ratio}!`);
        }
    },

    // ════ AI Banner Copy Auto-Generator ════
    generateAiBannerCopy: function() {
        const titleInput = document.getElementById('bannerTitle');
        const subInput = document.getElementById('bannerSubtitle');
        const ctaInput = document.getElementById('bannerCta');

        const headlines = [
            {
                title: "Surat Central Depot Mega Festival 2026",
                sub: "Authentic Pure Silk & Handloom Sarees • Direct Weaver Wholesale Pricing",
                cta: "Explore Wholesale Catalogues"
            },
            {
                title: "Royal Bridal & Velvet Heritage Edit",
                sub: "Heavy Hand Embroidered Zardosi Lehengas for Boutique Collections",
                cta: "View Bridal Assortment"
            },
            {
                title: "Reseller Low MOQ Deals (MOQ 4)",
                sub: "High Profit Resale Bundles • 24-Hour Express Depot Dispatch Across India",
                cta: "Order Wholesale Lots"
            }
        ];

        const chosen = headlines[Math.floor(Math.random() * headlines.length)];
        if (titleInput) titleInput.value = chosen.title;
        if (subInput) subInput.value = chosen.sub;
        if (ctaInput) ctaInput.value = chosen.cta;

        this.showToast(`✨ AI Generated Banner Headlines & CTA!`);
    }
};
