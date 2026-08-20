<?php
/**
 * collection-form.php — Collection Create/Edit & Product Assignment Form
 * DT Brand's & Jai Hanuman Tex
 */
?>
<form onsubmit="return window.DT_CATEGORIES.saveCategoryForm(event)" class="dt-form-grid">
    <div>
        <div class="dt-form-card">
            <h4 class="dt-form-card-title">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                <span>Collection Details</span>
            </h4>

            <div class="dt-form-group">
                <label class="dt-form-label">Collection Title <span style="color:#DC2626;">*</span></label>
                <input type="text" id="collTitle" class="dt-form-input" required placeholder="e.g. Surat Heritage Silk Festival" oninput="window.DT_CATALOGUE.generateSlug('collTitle', 'collSlug')">
            </div>

            <div class="dt-form-group">
                <label class="dt-form-label">URL Slug</label>
                <input type="text" id="collSlug" class="dt-form-input" placeholder="e.g. surat-heritage-silk">
            </div>

            <div class="dt-form-group">
                <label class="dt-form-label">Description &amp; Highlights</label>
                <textarea class="dt-form-textarea" rows="3" placeholder="Collection narrative and merchandising focus..."></textarea>
            </div>
        </div>

        <!-- Product Assignment Dual-Box Section -->
        <div class="dt-form-card">
            <h4 class="dt-form-card-title">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                <span>Assigned Products</span>
            </h4>

            <div class="dt-assign-wrap">
                <!-- Available Catalog Products -->
                <div>
                    <label class="dt-form-label">Available Catalog SKUs (Click to Add)</label>
                    <div class="dt-assign-box">
                        <div class="dt-assign-item" onclick="window.DT_COLLECTIONS.addProductToCollection(101, 'Kanjivaram Silk Saree', 'KLN-SR-111', '₹2,850', '/Frontend/Shop/Asset/images/product1.png')">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <img src="/Frontend/Shop/Asset/images/product1.png" style="width:28px; height:28px; border-radius:4px; object-fit:cover;">
                                <div>
                                    <strong>Kanjivaram Silk Saree</strong>
                                    <div style="font-size:10px; color:#64748b;">KLN-SR-111 • ₹2,850</div>
                                </div>
                            </div>
                            <span class="dt-btn-action-sm pale-gold" style="height:20px; padding:0 6px; font-size:10px;">+ Add</span>
                        </div>

                        <div class="dt-assign-item" onclick="window.DT_COLLECTIONS.addProductToCollection(102, 'Banarasi Brocade Saree', 'BNR-SR-204', '₹3,200', '/Frontend/Shop/Asset/images/product2.png')">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <img src="/Frontend/Shop/Asset/images/product2.png" style="width:28px; height:28px; border-radius:4px; object-fit:cover;">
                                <div>
                                    <strong>Banarasi Brocade Saree</strong>
                                    <div style="font-size:10px; color:#64748b;">BNR-SR-204 • ₹3,200</div>
                                </div>
                            </div>
                            <span class="dt-btn-action-sm pale-gold" style="height:20px; padding:0 6px; font-size:10px;">+ Add</span>
                        </div>

                        <div class="dt-assign-item" onclick="window.DT_COLLECTIONS.addProductToCollection(103, 'Zardosi Bridal Lehenga', 'BRD-LH-902', '₹11,500', '/Frontend/Shop/Asset/images/product6.png')">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <img src="/Frontend/Shop/Asset/images/product6.png" style="width:28px; height:28px; border-radius:4px; object-fit:cover;">
                                <div>
                                    <strong>Zardosi Bridal Lehenga</strong>
                                    <div style="font-size:10px; color:#64748b;">BRD-LH-902 • ₹11,500</div>
                                </div>
                            </div>
                            <span class="dt-btn-action-sm pale-gold" style="height:20px; padding:0 6px; font-size:10px;">+ Add</span>
                        </div>
                    </div>
                </div>

                <!-- Assigned to Collection -->
                <div>
                    <label class="dt-form-label">Products in Collection</label>
                    <div class="dt-assign-box" id="assignedProductsList">
                        <div class="dt-assign-item" id="assigned-prod-101">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <img src="/Frontend/Shop/Asset/images/product1.png" style="width:28px; height:28px; border-radius:4px; object-fit:cover;">
                                <div>
                                    <strong>Kanjivaram Silk Saree</strong>
                                    <div style="font-size:10px; color:#64748b;">KLN-SR-111 • ₹2,850</div>
                                </div>
                            </div>
                            <button type="button" class="dt-btn-action-sm danger" onclick="this.closest('.dt-assign-item').remove()" style="height:22px; padding:0 6px; font-size:10px;">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Settings Column -->
    <div>
        <div class="dt-form-card">
            <h4 class="dt-form-card-title">
                <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                <span>Collection Scheduling &amp; Rules</span>
            </h4>

            <div class="dt-form-group">
                <label class="dt-form-label">Start Date</label>
                <input type="date" class="dt-form-input" value="2026-08-01">
            </div>

            <div class="dt-form-group">
                <label class="dt-form-label">End Date (Optional)</label>
                <input type="date" class="dt-form-input" value="2026-11-30">
            </div>

            <div style="display:flex; flex-direction:column; gap:8px; margin:14px 0;">
                <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                    <input type="checkbox" checked style="width:15px; height:15px;">
                    <span>Active Live</span>
                </label>
                <label style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:600; cursor:pointer;">
                    <input type="checkbox" checked style="width:15px; height:15px;">
                    <span>Featured in Home Ribbon</span>
                </label>
            </div>

            <div style="display:flex; flex-direction:column; gap:8px;">
                <button type="submit" class="dt-btn-action-sm gold" style="height:34px; justify-content:center; font-size:12px;">Save Collection</button>
                <a href="/Frontend/Admin/catalogue/collections/" class="dt-btn-action-sm pale-gold" style="height:32px; justify-content:center; font-size:11.5px; text-decoration:none;">Cancel</a>
            </div>
        </div>
    </div>
</form>
