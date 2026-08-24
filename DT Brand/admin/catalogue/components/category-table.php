<?php
/**
 * category-table.php — Category Table Component
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-cat-card">
    <div class="dt-cat-card-header">
        <h3 class="dt-cat-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
            <span>Primary Categories (16 Nodes)</span>
        </h3>
        <div style="display:flex; gap:6px; align-items:center;">
            <a href="/DT%20Brand/admin/catalogue/categories/add.php" class="dt-btn-action-sm gold" style="height:28px; padding:0 12px; font-size:11px;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Add Category</span>
            </a>
            <a href="/DT%20Brand/admin/catalogue/categories/reorder.php" class="dt-btn-action-sm pale-gold" style="height:28px; padding:0 10px; font-size:11px;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2"><polyline points="7 11 12 6 17 11"></polyline><polyline points="17 13 12 18 7 13"></polyline></svg>
                <span>Reorder</span>
            </a>
        </div>
    </div>

    <div class="dt-cat-table-wrap">
        <table class="dt-cat-table" id="catListTable">
            <thead>
                <tr>
                    <th style="width:30px; text-align:center;"><input type="checkbox" onchange="window.DT_CATALOGUE.toggleSelectAll(this, 'cat-row-chk')" style="cursor:pointer;"></th>
                    <th style="width:50px;">Image</th>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Subcategories</th>
                    <th>Products</th>
                    <th>Featured</th>
                    <th>Display Style</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Cat 1 -->
                <tr id="cat-row-1" data-status="active">
                    <td style="text-align:center;"><input type="checkbox" class="cat-row-chk" value="1"></td>
                    <td><img src="/Frontend/Shop/Asset/images/product1.png" onerror="this.src='/Shared/Asset/images/product1.png';" style="width:36px; height:36px; border-radius:4px; object-fit:cover; border:1px solid #e2e8f0;"></td>
                    <td>
                        <a href="/DT%20Brand/admin/catalogue/categories/view.php?id=1" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;">Silk Sarees</a>
                        <div style="font-size:11px; color:#64748b; margin-top:2px;">Surat Central Depot Master Line</div>
                    </td>
                    <td><code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">silk-sarees</code></td>
                    <td><span class="dt-badge blue">3 Sub-types</span></td>
                    <td><strong>420 SKUs</strong></td>
                    <td><button type="button" class="wp-star-btn active" onclick="window.DT_CATEGORIES.toggleFeatured(this, 1, 'Silk Sarees')">★</button></td>
                    <td><span class="dt-badge gold">Banner + Grid</span></td>
                    <td><span class="dt-badge green">Active</span></td>
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:4px;">
                            <a href="/DT%20Brand/admin/catalogue/categories/view.php?id=1" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                            <a href="/DT%20Brand/admin/catalogue/categories/edit.php?id=1" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('cat-row-1', 'Silk Sarees')" style="height:24px; padding:0 6px;">✕</button>
                        </div>
                    </td>
                </tr>

                <!-- Cat 2 -->
                <tr id="cat-row-2" data-status="active">
                    <td style="text-align:center;"><input type="checkbox" class="cat-row-chk" value="2"></td>
                    <td><img src="/Frontend/Shop/Asset/images/product6.png" onerror="this.src='/Shared/Asset/images/product3.png';" style="width:36px; height:36px; border-radius:4px; object-fit:cover; border:1px solid #e2e8f0;"></td>
                    <td>
                        <a href="/DT%20Brand/admin/catalogue/categories/view.php?id=2" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;">Bridal Lehengas</a>
                        <div style="font-size:11px; color:#64748b; margin-top:2px;">Handcrafted Heritage Zardosi</div>
                    </td>
                    <td><code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">bridal-lehengas</code></td>
                    <td><span class="dt-badge blue">2 Sub-types</span></td>
                    <td><strong>280 SKUs</strong></td>
                    <td><button type="button" class="wp-star-btn active" onclick="window.DT_CATEGORIES.toggleFeatured(this, 2, 'Bridal Lehengas')">★</button></td>
                    <td><span class="dt-badge gold">Grid</span></td>
                    <td><span class="dt-badge green">Active</span></td>
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:4px;">
                            <a href="/DT%20Brand/admin/catalogue/categories/view.php?id=2" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                            <a href="/DT%20Brand/admin/catalogue/categories/edit.php?id=2" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('cat-row-2', 'Bridal Lehengas')" style="height:24px; padding:0 6px;">✕</button>
                        </div>
                    </td>
                </tr>

                <!-- Cat 3 -->
                <tr id="cat-row-3" data-status="active">
                    <td style="text-align:center;"><input type="checkbox" class="cat-row-chk" value="3"></td>
                    <td><img src="/Frontend/Shop/Asset/images/product4.png" onerror="this.src='/Shared/Asset/images/product4.png';" style="width:36px; height:36px; border-radius:4px; object-fit:cover; border:1px solid #e2e8f0;"></td>
                    <td>
                        <a href="/DT%20Brand/admin/catalogue/categories/view.php?id=3" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;">Designer Kurtis</a>
                        <div style="font-size:11px; color:#64748b; margin-top:2px;">Foil Prints &amp; Chanderi Sets</div>
                    </td>
                    <td><code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">designer-kurtis</code></td>
                    <td><span class="dt-badge blue">2 Sub-types</span></td>
                    <td><strong>310 SKUs</strong></td>
                    <td><button type="button" class="wp-star-btn" onclick="window.DT_CATEGORIES.toggleFeatured(this, 3, 'Designer Kurtis')">★</button></td>
                    <td><span class="dt-badge gold">Grid</span></td>
                    <td><span class="dt-badge green">Active</span></td>
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:4px;">
                            <a href="/DT%20Brand/admin/catalogue/categories/view.php?id=3" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                            <a href="/DT%20Brand/admin/catalogue/categories/edit.php?id=3" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('cat-row-3', 'Designer Kurtis')" style="height:24px; padding:0 6px;">✕</button>
                        </div>
                    </td>
                </tr>

                <!-- Cat 4 -->
                <tr id="cat-row-4" data-status="active">
                    <td style="text-align:center;"><input type="checkbox" class="cat-row-chk" value="4"></td>
                    <td><img src="/Frontend/Shop/Asset/images/product5.png" onerror="this.src='/Shared/Asset/images/product5.png';" style="width:36px; height:36px; border-radius:4px; object-fit:cover; border:1px solid #e2e8f0;"></td>
                    <td>
                        <a href="/DT%20Brand/admin/catalogue/categories/view.php?id=4" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;">Dress Materials</a>
                        <div style="font-size:11px; color:#64748b; margin-top:2px;">Unstitched Premium Cotton &amp; Silk</div>
                    </td>
                    <td><code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">dress-materials</code></td>
                    <td><span class="dt-badge blue">4 Sub-types</span></td>
                    <td><strong>230 SKUs</strong></td>
                    <td><button type="button" class="wp-star-btn" onclick="window.DT_CATEGORIES.toggleFeatured(this, 4, 'Dress Materials')">★</button></td>
                    <td><span class="dt-badge gold">Grid</span></td>
                    <td><span class="dt-badge green">Active</span></td>
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:4px;">
                            <a href="/DT%20Brand/admin/catalogue/categories/view.php?id=4" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                            <a href="/DT%20Brand/admin/catalogue/categories/edit.php?id=4" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('cat-row-4', 'Dress Materials')" style="height:24px; padding:0 6px;">✕</button>
                        </div>
                    </td>
                </tr>

                <!-- Cat 5 -->
                <tr id="cat-row-5" data-status="active">
                    <td style="text-align:center;"><input type="checkbox" class="cat-row-chk" value="5"></td>
                    <td><img src="/Frontend/Shop/Asset/images/product2.png" onerror="this.src='/Shared/Asset/images/product2.png';" style="width:36px; height:36px; border-radius:4px; object-fit:cover; border:1px solid #e2e8f0;"></td>
                    <td>
                        <a href="/DT%20Brand/admin/catalogue/categories/view.php?id=5" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;">Banarasi Brocades</a>
                        <div style="font-size:11px; color:#64748b; margin-top:2px;">Kadhwa &amp; Meenakari Zari Borders</div>
                    </td>
                    <td><code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">banarasi-brocades</code></td>
                    <td><span class="dt-badge blue">3 Sub-types</span></td>
                    <td><strong>185 SKUs</strong></td>
                    <td><button type="button" class="wp-star-btn active" onclick="window.DT_CATEGORIES.toggleFeatured(this, 5, 'Banarasi Brocades')">★</button></td>
                    <td><span class="dt-badge gold">Banner + Grid</span></td>
                    <td><span class="dt-badge green">Active</span></td>
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:4px;">
                            <a href="/DT%20Brand/admin/catalogue/categories/view.php?id=5" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                            <a href="/DT%20Brand/admin/catalogue/categories/edit.php?id=5" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('cat-row-5', 'Banarasi Brocades')" style="height:24px; padding:0 6px;">✕</button>
                        </div>
                    </td>
                </tr>

                <!-- Cat 6 -->
                <tr id="cat-row-6" data-status="inactive">
                    <td style="text-align:center;"><input type="checkbox" class="cat-row-chk" value="6"></td>
                    <td><img src="/Frontend/Shop/Asset/images/product3.png" onerror="this.src='/Shared/Asset/images/product3.png';" style="width:36px; height:36px; border-radius:4px; object-fit:cover; border:1px solid #e2e8f0;"></td>
                    <td>
                        <a href="/DT%20Brand/admin/catalogue/categories/view.php?id=6" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;">Festive Dupattas</a>
                        <div style="font-size:11px; color:#64748b; margin-top:2px;">Bandhani &amp; Banarasi Rich Stoles</div>
                    </td>
                    <td><code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">festive-dupattas</code></td>
                    <td><span class="dt-badge blue">2 Sub-types</span></td>
                    <td><strong>95 SKUs</strong></td>
                    <td><button type="button" class="wp-star-btn" onclick="window.DT_CATEGORIES.toggleFeatured(this, 6, 'Festive Dupattas')">★</button></td>
                    <td><span class="dt-badge gold">Grid</span></td>
                    <td><span class="dt-badge gray">Inactive</span></td>
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:4px;">
                            <a href="/DT%20Brand/admin/catalogue/categories/view.php?id=6" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                            <a href="/DT%20Brand/admin/catalogue/categories/edit.php?id=6" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('cat-row-6', 'Festive Dupattas')" style="height:24px; padding:0 6px;">✕</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
