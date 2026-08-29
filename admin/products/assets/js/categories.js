/**
 * categories.js — Category create / update / delete, for real
 * DT Brand's & Jai Hanuman Tex
 *
 * This file used to be ten lines:
 *
 *     window.saveCategory = function () {
 *         window.showToast('Category saved successfully!');
 *     };
 *
 * add.php's only Save button called nothing at all — its onclick was an inline
 * showToast('Category created successfully!') — and none of that form's five
 * inputs had an id, a name or a wrapping <form>, so a category typed there was
 * never sent anywhere. The admin was told it had been created.
 *
 * Everything here posts to /api/categories.php (admin-guarded) and only reports
 * success when the server says success. Thumbnails and banners are uploaded
 * through /api/upload.php, which returns a real URL under
 * /assets/images/uploads — the old edit form put a base64 FileReader data URL
 * into the `image` field, which cannot fit VARCHAR(255) and so silently blanked
 * the category's photo.
 */
(function () {
    'use strict';

    var pending = 0;

    function toast(msg) {
        if (typeof window.showToast === 'function') { window.showToast(msg); }
        else { alert(msg); }
    }

    function el(id) { return document.getElementById(id); }

    function val(id) {
        var e = el(id);
        return e ? String(e.value == null ? '' : e.value).trim() : '';
    }

    window.dtCatSlugify = function (s) {
        return String(s || '').toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
    };
    /** POST to the category API; rejects unless the server reports success. */
    function post(payload) {
        return fetch('/api/categories.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify(payload)
        }).then(function (r) {
            return r.json().catch(function () {
                throw new Error((r.status === 401 || r.status === 403)
                    ? 'You are signed out of the admin — sign in again and retry.'
                    : 'The server did not return a valid response (HTTP ' + r.status + ').');
            });
        }).then(function (res) {
            if (!res || res.success !== true) {
                throw new Error((res && res.message) ? res.message : 'The server rejected the request.');
            }
            return res;
        });
    }

    // Exposed so the category list page can reuse one honest POST helper for its
    // quick-edit and bulk-delete rows instead of hand-rolling fetch handlers
    // whose .catch() reported success.
    window.dtCatPost = post;

    /** Real upload: returns the stored public URL, never a data: URL. */
    function upload(file) {
        var fd = new FormData();
        fd.append('file', file);
        return fetch('/api/upload.php', {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            body: fd
        }).then(function (r) {
            return r.json().catch(function () {
                throw new Error((r.status === 401 || r.status === 403)
                    ? 'You are signed out of the admin — sign in again and retry.'
                    : 'Upload failed (HTTP ' + r.status + ').');
            });
        }).then(function (res) {
            if (!res || res.success !== true || !res.url) {
                throw new Error((res && res.message) ? res.message : 'The file was not stored.');
            }
            return res.url;
        });
    }
    /**
     * Wires one image picker: file input -> upload -> preview + hidden field
     * holding the stored URL. The preview only changes once the file is on the
     * server, so what you see is what is saved.
     */
    window.dtCatBindUpload = function (fileId, previewId, hiddenId, label) {
        var fileEl = el(fileId);
        if (!fileEl) { return; }
        fileEl.addEventListener('change', function () {
            var f = fileEl.files && fileEl.files[0];
            if (!f) { return; }
            pending++;
            toast('Uploading ' + label + '…');
            upload(f).then(function (url) {
                pending--;
                var hidden = el(hiddenId);
                if (hidden) { hidden.value = url; }
                var prev = el(previewId);
                if (prev) {
                    if (prev.tagName === 'IMG') { prev.src = url; prev.style.display = ''; }
                    else { prev.style.backgroundImage = 'url("' + url + '")'; }
                }
                var note = el(previewId + 'Note');
                if (note) { note.textContent = url; }
                toast(label + ' uploaded.');
            }).catch(function (err) {
                pending--;
                fileEl.value = '';
                toast(err && err.message ? err.message : (label + ' was not uploaded.'));
            });
        });
    };

    /** Slug follows the name until the admin edits the slug box themselves. */
    window.dtCatBindSlug = function () {
        var nameEl = el('catName');
        var slugEl = el('catSlug');
        if (!nameEl || !slugEl) { return; }
        var touched = String(slugEl.value || '').trim() !== '';
        slugEl.addEventListener('input', function () { touched = true; paintSlug(); });
        nameEl.addEventListener('input', function () {
            if (!touched) { slugEl.value = window.dtCatSlugify(nameEl.value); }
            paintSlug();
        });
        paintSlug();
    };

    function paintSlug() {
        var out = el('catSlugLive');
        if (out) { out.textContent = val('catSlug') || window.dtCatSlugify(val('catName')) || '...'; }
    }
    /**
     * Save. Mode and id come from the page's own hidden fields, so add.php and
     * edit.php share this one function.
     */
    window.saveCategory = function () {
        var name = val('catName');
        if (!name) {
            toast('Enter the category name before saving.');
            var n = el('catName');
            if (n) { n.focus(); }
            return;
        }
        if (pending > 0) {
            toast('An image is still uploading. Wait for it to finish, then save.');
            return;
        }

        var id = parseInt(val('catId'), 10) || 0;
        var isUpdate = (val('catMode') === 'update' && id > 0);

        var payload = {
            action: isUpdate ? 'update' : 'create',
            name: name,
            slug: val('catSlug') || window.dtCatSlugify(name),
            description: val('catDesc'),
            status: val('catStatus') || 'active'
        };
        if (isUpdate) { payload.id = id; }
        // Only real columns are sent. The old edit form also posted a Parent
        // Category, a Display Type, an HSN code and two SEO boxes; `categories`
        // has none of those, so they were dropped server-side while the page
        // reported everything saved.
        var order = val('catOrder');
        if (order !== '') { payload.display_order = parseInt(order, 10) || 0; }
        // An empty image field is sent on update so clearing a photo works, but
        // never on create (there is nothing to clear).
        var img = el('catImage');
        var ban = el('catBanner');
        if (img && (isUpdate || val('catImage') !== '')) { payload.image = val('catImage'); }
        if (ban && (isUpdate || val('catBanner') !== '')) { payload.banner_image = val('catBanner'); }

        var btns = document.querySelectorAll('[data-dt-cat-save]');
        for (var i = 0; i < btns.length; i++) { btns[i].disabled = true; }

        post(payload).then(function (res) {
            toast(res.message || (isUpdate ? 'Category updated.' : 'Category created.'));
            setTimeout(function () { window.location.href = '/admin/products/categories/'; }, 700);
        }).catch(function (err) {
            for (var j = 0; j < btns.length; j++) { btns[j].disabled = false; }
            toast(err && err.message ? err.message : 'The category was not saved.');
        });
    };
    /**
     * Delete. The API refuses while products are still filed under the category
     * and returns the blocking count; that reason is shown instead of a generic
     * failure, and the list is only reloaded when the row really went away.
     */
    window.dtCatDelete = function (id) {
        var catId = parseInt(id, 10) || 0;
        if (catId <= 0) {
            toast('That category has no id, so it cannot be deleted.');
            return;
        }
        if (!window.confirm('Delete this category? Products filed under it must be moved first.')) {
            return;
        }
        post({ action: 'delete', id: catId }).then(function (res) {
            toast(res.message || 'Category deleted.');
            setTimeout(function () { window.location.href = '/admin/products/categories/'; }, 700);
        }).catch(function (err) {
            toast(err && err.message ? err.message : 'The category was not deleted.');
        });
    };

    function wire() {
        window.dtCatBindSlug();
        window.dtCatBindUpload('catImageFile', 'catImagePreview', 'catImage', 'Thumbnail');
        window.dtCatBindUpload('catBannerFile', 'catBannerPreview', 'catBanner', 'Banner');
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', wire);
    } else {
        wire();
    }
})();
