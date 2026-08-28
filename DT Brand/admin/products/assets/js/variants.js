/**
 * variants.js — Colour / size palette and the product_variants matrix
 * DT Brand's & Jai Hanuman Tex
 *
 * This file used to be ten lines: window.generateVariantMatrix() toasted
 * "Generated 6 SKU variants based on Color & Size combinations!" and generated
 * nothing. It was also never loaded on add.php or edit.php, so the variants
 * section had no behaviour behind it at all.
 *
 * What is real: one product_variants row per (colour, size) pair holding
 * color_name, size_name, sku, stock_qty, price and image. There is no
 * per-variant status column and only one price column, so this collector emits
 * exactly those fields and nothing else.
 */
(function () {
    'use strict';

    var PALETTE = [
        { name: 'Crimson Red', hex: '#991b1b' }, { name: 'Ruby Red', hex: '#dc2626' },
        { name: 'Deep Maroon', hex: '#831843' }, { name: 'Wine / Burgundy', hex: '#701a75' },
        { name: 'Rani Pink', hex: '#db2777' }, { name: 'Rose Pink', hex: '#f43f5e' },
        { name: 'Baby Pink', hex: '#f472b6' }, { name: 'Magenta', hex: '#c026d3' },
        { name: 'Rust Orange', hex: '#c2410c' }, { name: 'Tangerine', hex: '#ea580c' },
        { name: 'Mustard Yellow', hex: '#d97706' }, { name: 'Golden Yellow', hex: '#eab308' },
        { name: 'Bottle Green', hex: '#166534' }, { name: 'Emerald Green', hex: '#15803d' },
        { name: 'Parrot Green', hex: '#22c55e' }, { name: 'Mehendi Olive', hex: '#65a30d' },
        { name: 'Peacock Teal', hex: '#0f766e' }, { name: 'Sea Green', hex: '#14b8a6' },
        { name: 'Cyan Aqua', hex: '#06b6d4' }, { name: 'Royal Blue', hex: '#1e40af' },
        { name: 'Navy Blue', hex: '#1e3a8a' }, { name: 'Sky Blue', hex: '#38bdf8' },
        { name: 'Indigo Blue', hex: '#3730a3' }, { name: 'Lavender Purple', hex: '#9333ea' },
        { name: 'Violet / Plum', hex: '#581c87' }, { name: 'Jet Black', hex: '#18181b' },
        { name: 'Charcoal Grey', hex: '#3f3f46' }, { name: 'Silver Grey', hex: '#9ca3af' },
        { name: 'Pearl White', hex: '#ffffff' }, { name: 'Off White / Cream', hex: '#fef9c3' },
        { name: 'Beige / Biscuit', hex: '#d6d3d1' }, { name: 'Chocolate Brown', hex: '#78350f' }
    ];

    var SIZE_PRESETS = [
        'Free Size (6.3m)', 'Standard (5.5m + Blouse)', 'Semi-Stitched', 'Unstitched 2.5m',
        'S (36)', 'M (38)', 'L (40)', 'XL (42)', 'XXL (44)'
    ];

    var colours = [];   // [{ name, hex }]
    var sizes = [];     // [name]

    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    function toast(msg) {
        if (typeof window.showToast === 'function') { window.showToast(msg); } else { alert(msg); }
    }

    function el(id) { return document.getElementById(id); }
    function hexToRgb(hex) {
        var h = String(hex || '').replace(/^#/, '');
        if (h.length === 3) { h = h[0] + h[0] + h[1] + h[1] + h[2] + h[2]; }
        var n = parseInt(h, 16);
        if (!isFinite(n)) { return null; }
        return { r: (n >> 16) & 255, g: (n >> 8) & 255, b: n & 255 };
    }

    /** Closest trade name to a picked swatch. Only ever a suggestion. */
    function closestColourName(hex) {
        var t = hexToRgb(hex);
        if (!t) { return ''; }
        var best = '', bestD = Infinity;
        for (var i = 0; i < PALETTE.length; i++) {
            var c = hexToRgb(PALETTE[i].hex);
            var d = Math.pow(t.r - c.r, 2) + Math.pow(t.g - c.g, 2) + Math.pow(t.b - c.b, 2);
            if (d < bestD) { bestD = d; best = PALETTE[i].name; }
        }
        return best;
    }

    function renderColourChips() {
        var box = el('dtColorChips');
        if (!box) { return; }
        if (!colours.length) {
            box.innerHTML = '<span class="dt-empty-note" style="font-size:11px; color:#646970;">None added yet.</span>';
            return;
        }
        box.innerHTML = colours.map(function (c, i) {
            return '<span class="adm-badge gold" style="display:inline-flex; align-items:center; gap:5px;'
                + ' font-size:11px; padding:3px 8px;">'
                + '<span style="width:10px; height:10px; border-radius:50%; background:' + esc(c.hex)
                + '; display:inline-block; border:1px solid #fff;"></span>'
                + '<span>' + esc(c.name) + '</span>'
                + '<button type="button" data-drop-colour="' + i + '" title="Remove"'
                + ' style="border:0; background:none; cursor:pointer; font-size:13px; line-height:1;'
                + ' color:#b32d2e; padding:0 0 0 2px;">&times;</button></span>';
        }).join('');
    }

    function renderSizeChips() {
        var box = el('dtSizeChips');
        if (!box) { return; }
        if (!sizes.length) {
            box.innerHTML = '<span class="dt-empty-note" style="font-size:11px; color:#646970;">None added yet.</span>';
            return;
        }
        box.innerHTML = sizes.map(function (s, i) {
            return '<span class="adm-badge gold" style="font-size:11px; padding:3px 8px;">' + esc(s)
                + '<button type="button" data-drop-size="' + i + '" title="Remove"'
                + ' style="border:0; background:none; cursor:pointer; font-size:13px; line-height:1;'
                + ' color:#b32d2e; padding:0 0 0 4px;">&times;</button></span>';
        }).join('');
    }
    function rowKey(colour, size) {
        return String(colour || '').toLowerCase() + '|' + String(size || '').toLowerCase();
    }

    function buildRow(v) {
        var tr = document.createElement('tr');
        tr.setAttribute('data-vrow', '1');
        tr.setAttribute('data-vcolour', v.colour || '');
        tr.setAttribute('data-vsize', v.size || '');
        tr.setAttribute('data-vhex', v.hex || '');
        if (v.image) { tr.setAttribute('data-vimage', v.image); }
        var thumb = v.image
            ? '<img src="' + esc(v.image) + '" alt="" style="width:38px; height:38px; object-fit:cover;'
              + ' border-radius:4px; border:1px solid #c3c4c7;">'
            : '<span style="display:inline-block; width:38px; height:38px; border-radius:4px;'
              + ' border:1px dashed #c3c4c7; background:' + esc(v.hex || '#f6f7f7') + ';"></span>';
        tr.innerHTML =
            '<td style="padding:6px 8px; border-bottom:1px solid #e5e5e5;">'
              + '<span data-vthumb>' + thumb + '</span>'
              + '<input type="file" accept="image/*" data-vfile style="display:none;">'
              + '<button type="button" data-vupload style="display:block; margin-top:3px; font-size:9.5px;'
              + ' border:1px solid #c3c4c7; background:#f6f7f7; border-radius:3px; cursor:pointer;'
              + ' padding:1px 4px;">Photo</button></td>'
            + '<td style="padding:6px 8px; border-bottom:1px solid #e5e5e5; font-weight:700;">'
              + (v.colour ? esc(v.colour) : '<span style="color:#646970; font-weight:400;">—</span>') + '</td>'
            + '<td style="padding:6px 8px; border-bottom:1px solid #e5e5e5;">'
              + (v.size ? esc(v.size) : '<span style="color:#646970;">—</span>') + '</td>'
            + '<td style="padding:6px 8px; border-bottom:1px solid #e5e5e5;">'
              + '<input type="text" data-vfield="sku" class="adm-form-input" maxlength="50"'
              + ' placeholder="auto" value="' + esc(v.sku || '') + '"'
              + ' style="height:26px; font-size:11px; width:130px;"></td>'
            + '<td style="padding:6px 8px; border-bottom:1px solid #e5e5e5;">'
              + '<input type="number" min="0" step="1" data-vfield="price" class="adm-form-input"'
              + ' placeholder="retail" value="' + esc(v.price == null ? '' : v.price) + '"'
              + ' style="height:26px; font-size:11px; width:90px;"></td>'
            + '<td style="padding:6px 8px; border-bottom:1px solid #e5e5e5;">'
              + '<input type="number" min="0" step="1" data-vfield="stock" class="adm-form-input"'
              + ' value="' + esc(v.stock_qty == null ? 0 : v.stock_qty) + '"'
              + ' style="height:26px; font-size:11px; width:78px;"></td>'
            + '<td style="padding:6px 8px; border-bottom:1px solid #e5e5e5;">'
              + '<button type="button" data-vdrop class="dt-btn-action-sm danger"'
              + ' style="padding:2px 7px; font-size:10.5px;">Remove</button></td>';
        return tr;
    }

    function refreshEmptyNote() {
        var note = el('dtVariantEmpty');
        var body = el('dtVariantRows');
        if (note && body) { note.style.display = body.children.length ? 'none' : 'block'; }
        if (typeof window.dtRecalculateFullSetPreview === 'function') {
            window.dtRecalculateFullSetPreview();
        }
    }
    /** Read what is currently on screen, so rebuilding keeps typed values. */
    function currentRows() {
        var out = {};
        var rows = document.querySelectorAll('#dtVariantRows tr[data-vrow]');
        for (var i = 0; i < rows.length; i++) {
            var r = rows[i];
            var colour = r.getAttribute('data-vcolour') || '';
            var size = r.getAttribute('data-vsize') || '';
            out[rowKey(colour, size)] = {
                colour: colour,
                size: size,
                hex: r.getAttribute('data-vhex') || '',
                image: r.getAttribute('data-vimage') || '',
                sku: fieldVal(r, 'sku'),
                price: fieldVal(r, 'price'),
                stock_qty: fieldVal(r, 'stock')
            };
        }
        return out;
    }

    function fieldVal(row, name) {
        var input = row.querySelector('[data-vfield="' + name + '"]');
        return input ? String(input.value == null ? '' : input.value).trim() : '';
    }

    /**
     * Cross the colour and size lists. With only one list filled, the rows carry
     * that attribute alone — a saree sold in three colours and one length is
     * three rows, not nine.
     */
    function buildMatrix() {
        var body = el('dtVariantRows');
        if (!body) { return; }
        if (!colours.length && !sizes.length) {
            toast('Add at least one colour or size first.');
            return;
        }
        var keep = currentRows();
        var pairs = [];
        if (colours.length && sizes.length) {
            colours.forEach(function (c) {
                sizes.forEach(function (s) { pairs.push({ colour: c.name, hex: c.hex, size: s }); });
            });
        } else if (colours.length) {
            colours.forEach(function (c) { pairs.push({ colour: c.name, hex: c.hex, size: '' }); });
        } else {
            sizes.forEach(function (s) { pairs.push({ colour: '', hex: '', size: s }); });
        }

        body.innerHTML = '';
        pairs.forEach(function (p) {
            var prev = keep[rowKey(p.colour, p.size)] || {};
            body.appendChild(buildRow({
                colour: p.colour, size: p.size, hex: p.hex || prev.hex || '',
                image: prev.image || '', sku: prev.sku || '',
                price: prev.price || '', stock_qty: prev.stock_qty || 0
            }));
        });
        refreshEmptyNote();
    }
    function addColour() {
        var nameEl = el('varColorName');
        var hexEl = el('varColorHex');
        var hex = (hexEl && /^#[0-9a-fA-F]{3,6}$/.test(hexEl.value.trim())) ? hexEl.value.trim() : '#8A681F';
        var name = nameEl ? nameEl.value.trim() : '';
        if (!name) {
            // No silent invention: an unnamed swatch gets the closest palette
            // name only because the admin left the box empty on purpose.
            name = closestColourName(hex);
        }
        if (!name) { toast('Type a colour name.'); return; }
        for (var i = 0; i < colours.length; i++) {
            if (colours[i].name.toLowerCase() === name.toLowerCase()) {
                toast('"' + name + '" is already on the list.');
                return;
            }
        }
        colours.push({ name: name.slice(0, 50), hex: hex });
        if (nameEl) { nameEl.value = ''; }
        renderColourChips();
        buildMatrix();
    }

    function addSize(value) {
        var input = el('varSizeName');
        var name = String(value == null ? (input ? input.value : '') : value).trim();
        if (!name) { toast('Type a size.'); return; }
        for (var i = 0; i < sizes.length; i++) {
            if (sizes[i].toLowerCase() === name.toLowerCase()) {
                toast('"' + name + '" is already on the list.');
                return;
            }
        }
        sizes.push(name.slice(0, 50));
        if (input && value == null) { input.value = ''; }
        renderSizeChips();
        buildMatrix();
    }

    function uploadRowPhoto(row, file) {
        if (typeof window.dtUploadMedia !== 'function') {
            toast('The uploader is not loaded on this page.');
            return;
        }
        var thumb = row.querySelector('[data-vthumb]');
        if (thumb) { thumb.innerHTML = '<span style="font-size:9.5px; color:#646970;">Uploading…</span>'; }
        row.setAttribute('data-uploading', '1');
        window.dtUploadMedia(file).then(function (url) {
            row.removeAttribute('data-uploading');
            row.setAttribute('data-vimage', url);
            if (thumb) {
                thumb.innerHTML = '<img src="' + esc(url) + '" alt="" style="width:38px; height:38px;'
                    + ' object-fit:cover; border-radius:4px; border:1px solid #c3c4c7;">';
            }
        }).catch(function (err) {
            row.removeAttribute('data-uploading');
            row.removeAttribute('data-vimage');
            if (thumb) { thumb.innerHTML = '<span style="font-size:9.5px; color:#b32d2e;">Failed</span>'; }
            toast(err && err.message ? err.message : 'The variant photo was not uploaded.');
        });
    }
    /** The contract with product-form.js. Only real, storable fields. */
    window.dtCollectVariants = function () {
        var out = [];
        var rows = document.querySelectorAll('#dtVariantRows tr[data-vrow]');
        for (var i = 0; i < rows.length; i++) {
            var r = rows[i];
            var colour = r.getAttribute('data-vcolour') || '';
            var size = r.getAttribute('data-vsize') || '';
            if (colour === '' && size === '') { continue; }
            var price = fieldVal(r, 'price');
            out.push({
                color: colour,
                hex: r.getAttribute('data-vhex') || '',
                size: size,
                sku: fieldVal(r, 'sku'),
                // Blank price means "use the product price", so it is sent as
                // null rather than 0 — a 0 would be stored as a free variant.
                price: (price !== '' && parseFloat(price) > 0) ? parseFloat(price) : null,
                stock_qty: Math.max(0, parseInt(fieldVal(r, 'stock'), 10) || 0),
                image: r.getAttribute('data-vimage') || ''
            });
        }
        return out;
    };

    window.dtVariantsPending = function () {
        return document.querySelectorAll('#dtVariantRows tr[data-uploading="1"]').length;
    };

    /** Rebuild the whole section from stored rows. Safe to call twice. */
    window.dtPrefillVariants = function (list) {
        var body = el('dtVariantRows');
        if (!body || !Array.isArray(list)) { return; }
        colours = [];
        sizes = [];
        body.innerHTML = '';
        list.forEach(function (v) {
            var colour = String(v.color || v.colour || '').trim();
            var size = String(v.size || '').trim();
            if (colour === '' && size === '') { return; }
            if (colour) {
                var known = false;
                for (var i = 0; i < colours.length; i++) {
                    if (colours[i].name.toLowerCase() === colour.toLowerCase()) { known = true; break; }
                }
                if (!known) { colours.push({ name: colour, hex: closestHexFor(colour) }); }
            }
            if (size && sizes.indexOf(size) === -1) { sizes.push(size); }
            body.appendChild(buildRow({
                colour: colour, size: size, hex: closestHexFor(colour),
                image: v.image || '', sku: v.sku || '',
                price: (v.price === null || v.price === undefined || v.price === '') ? '' : v.price,
                stock_qty: v.stock_qty == null ? 0 : v.stock_qty
            }));
        });
        renderColourChips();
        renderSizeChips();
        refreshEmptyNote();
    };

    /** A stored variant keeps only its colour NAME, so the swatch is looked up. */
    function closestHexFor(name) {
        var n = String(name || '').toLowerCase();
        for (var i = 0; i < PALETTE.length; i++) {
            if (PALETTE[i].name.toLowerCase() === n) { return PALETTE[i].hex; }
        }
        return '';
    }

    /** Live calculation of Full Set pieces and included component breakdown */
    window.dtRecalculateFullSetPreview = function () {
        var rows = document.querySelectorAll('#dtVariantRows tr[data-vrow]');
        var colorsSet = {};
        var validVariants = [];

        for (var i = 0; i < rows.length; i++) {
            var r = rows[i];
            var colour = r.getAttribute('data-vcolour') || '';
            var size = r.getAttribute('data-vsize') || '';
            if (colour === '' && size === '') { continue; }
            if (colour) { colorsSet[colour.toLowerCase()] = colour; }
            var stock = parseInt(fieldVal(r, 'stock'), 10);
            if (isNaN(stock) || stock < 0) { stock = 0; }
            var hex = r.getAttribute('data-vhex') || closestHexFor(colour) || '#8A681F';

            validVariants.push({
                colour: colour || 'Standard',
                size: size || 'Standard',
                stock: stock,
                hex: hex
            });
        }

        var colCount = Object.keys(colorsSet).length;
        var varCount = validVariants.length;
        var pieceCount = varCount; // 1 full set = count of active distinct color-size variants

        var elCol = el('dtFsPreviewColorsCount');
        var elVar = el('dtFsPreviewVariantsCount');
        var elBadge = el('dtFsPreviewPieceBadge');
        var elList = el('dtFsPreviewItemsList');

        if (elCol) { elCol.textContent = colCount; }
        if (elVar) { elVar.textContent = varCount; }
        if (elBadge) { elBadge.textContent = pieceCount + ' Piece' + (pieceCount === 1 ? '' : 's') + ' / Set'; }

        if (elList) {
            if (!validVariants.length) {
                elList.innerHTML = '<span style="font-size:11px; color:#A8A29E;">No active variants created yet.</span>';
            } else {
                elList.innerHTML = validVariants.map(function (v) {
                    return '<div style="display:flex; align-items:center; gap:6px; background:rgba(255,255,255,0.06); border:1px solid rgba(212,175,55,0.3); border-radius:4px; padding:4px 8px; font-size:11px;">'
                        + '<span style="color:#22C55E; font-weight:800;">&#10003;</span>'
                        + '<span style="width:8px; height:8px; border-radius:50%; background:' + esc(v.hex) + '; display:inline-block; border:1px solid #fff;"></span>'
                        + '<strong style="color:#FAF5E8;">' + esc(v.colour) + '</strong>'
                        + '<span style="color:#D4AF37;">/</span>'
                        + '<span style="color:#D6D3D1;">' + esc(v.size) + '</span>'
                        + '<span style="margin-left:auto; font-size:9.5px; color:' + (v.stock > 0 ? '#86EFAC' : '#F87171') + '; font-weight:700;">'
                        + (v.stock > 0 ? ('Stock: ' + v.stock) : 'Out of stock') + '</span>'
                        + '</div>';
                }).join('');
            }
        }
    };

    /** Selling type change switcher */
    window.dtOnSellingTypeChange = function (type) {
        var isFullSet = (type === 'full_set');
        var cardSingle = el('dtCardSinglePiece');
        var cardFull = el('dtCardFullSet');
        var radSingle = el('pFormSellingTypeSingle');
        var radFull = el('pFormSellingTypeFull');

        if (radSingle) { radSingle.checked = !isFullSet; }
        if (radFull) { radFull.checked = isFullSet; }

        if (cardSingle) {
            cardSingle.style.borderColor = !isFullSet ? '#8A681F' : '#E2E8F0';
            cardSingle.style.boxShadow = !isFullSet ? '0 2px 8px rgba(138,104,31,0.15)' : 'none';
        }
        if (cardFull) {
            cardFull.style.borderColor = isFullSet ? '#8A681F' : '#E2E8F0';
            cardFull.style.boxShadow = isFullSet ? '0 2px 8px rgba(138,104,31,0.15)' : 'none';
        }

        var grpCustPrice = el('pGroupCustomerPrice');
        var inpCustPrice = el('pFormCustomerPrice');
        var noteFullSet = el('pGroupFullSetPriceNote');

        if (grpCustPrice) { grpCustPrice.style.display = isFullSet ? 'none' : ''; }
        if (inpCustPrice) { inpCustPrice.disabled = isFullSet; }
        if (noteFullSet) { noteFullSet.style.display = isFullSet ? '' : 'none'; }

        window.dtRecalculateFullSetPreview();
    };

    // The old name is kept because the toolbar still calls it, but it now
    // builds the rows instead of toasting a count of variants it never made.
    window.generateVariantMatrix = buildMatrix;

    function wire() {
        var picker = el('varColorPicker');
        var hexEl = el('varColorHex');
        var nameEl = el('varColorName');

        if (picker && hexEl) {
            picker.addEventListener('input', function () {
                hexEl.value = picker.value;
                if (nameEl && !nameEl.value.trim()) { nameEl.value = closestColourName(picker.value); }
            });
        }
        if (hexEl && picker) {
            hexEl.addEventListener('input', function () {
                var v = hexEl.value.trim();
                if (/^#[0-9a-fA-F]{6}$/.test(v)) {
                    picker.value = v;
                    if (nameEl && !nameEl.value.trim()) { nameEl.value = closestColourName(v); }
                }
            });
        }
        if (nameEl) {
            nameEl.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') { e.preventDefault(); addColour(); }
            });
        }
        var sizeEl = el('varSizeName');
        if (sizeEl) {
            sizeEl.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') { e.preventDefault(); addSize(); }
            });
        }

        var addC = el('dtAddColorBtn');
        if (addC) { addC.addEventListener('click', addColour); }
        var addS = el('dtAddSizeBtn');
        if (addS) { addS.addEventListener('click', function () { addSize(); }); }
        var build = el('dtBuildMatrixBtn');
        if (build) { build.addEventListener('click', buildMatrix); }
        var clear = el('dtClearMatrixBtn');
        if (clear) {
            clear.addEventListener('click', function () {
                var body = el('dtVariantRows');
                if (body) { body.innerHTML = ''; }
                refreshEmptyNote();
            });
        }

        var presets = el('dtSizePresets');
        if (presets) {
            presets.innerHTML = SIZE_PRESETS.map(function (s) {
                return '<button type="button" class="dt-btn-action-sm pale-gold" data-size-preset="'
                    + esc(s) + '" style="cursor:pointer;">' + esc(s) + '</button>';
            }).join('');
        }
        // One delegated listener for every generated control: chips and rows are
        // rebuilt constantly, so per-element handlers would leak.
        document.addEventListener('click', function (e) {
            var t = e.target;
            if (!t || !t.closest) { return; }

            var preset = t.closest('[data-size-preset]');
            if (preset) { addSize(preset.getAttribute('data-size-preset')); return; }

            var dropC = t.closest('[data-drop-colour]');
            if (dropC) {
                colours.splice(parseInt(dropC.getAttribute('data-drop-colour'), 10), 1);
                renderColourChips();
                buildMatrix();
                return;
            }
            var dropS = t.closest('[data-drop-size]');
            if (dropS) {
                sizes.splice(parseInt(dropS.getAttribute('data-drop-size'), 10), 1);
                renderSizeChips();
                buildMatrix();
                return;
            }
            var drop = t.closest('[data-vdrop]');
            if (drop) {
                var row = drop.closest('tr[data-vrow]');
                if (row) { row.remove(); }
                refreshEmptyNote();
                return;
            }
            var up = t.closest('[data-vupload]');
            if (up) {
                var r2 = up.closest('tr[data-vrow]');
                var f = r2 ? r2.querySelector('[data-vfile]') : null;
                if (f) { f.click(); }
            }
        });

        document.addEventListener('input', function (e) {
            var t = e.target;
            if (!t || !t.hasAttribute || !t.hasAttribute('data-vfield')) { return; }
            if (t.getAttribute('data-vfield') === 'stock') {
                if (typeof window.dtRecalculateFullSetPreview === 'function') {
                    window.dtRecalculateFullSetPreview();
                }
            }
        });

        document.addEventListener('change', function (e) {
            var t = e.target;
            if (!t || !t.hasAttribute || !t.hasAttribute('data-vfile')) { return; }
            var row = t.closest('tr[data-vrow]');
            if (row && t.files && t.files[0]) { uploadRowPhoto(row, t.files[0]); }
            t.value = '';
        });

        if (Array.isArray(window.DT_VARIANT_SEED) && window.DT_VARIANT_SEED.length) {
            window.dtPrefillVariants(window.DT_VARIANT_SEED);
        } else {
            refreshEmptyNote();
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', wire);
    } else {
        wire();
    }
})();
