<?php
/**
 * collection-table.php — Collections List Table Component
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-cat-card">
    <div class="dt-cat-card-header">
        <h3 class="dt-cat-card-title">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="#8A681F" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
            <span>Curated Collections (8 Active)</span>
        </h3>
        <a href="/Frontend/Admin/catalogue/collections/add.php" class="dt-btn-action-sm gold" style="height:28px; padding:0 12px; font-size:11px;">
            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            <span>Add Collection</span>
        </a>
    </div>

    <div class="dt-cat-table-wrap">
        <table class="dt-cat-table" id="collListTable">
            <thead>
                <tr>
                    <th style="width:30px; text-align:center;"><input type="checkbox" onchange="window.DT_CATALOGUE.toggleSelectAll(this, 'coll-row-chk')" style="cursor:pointer;"></th>
                    <th style="width:50px;">Banner</th>
                    <th>Collection Name</th>
                    <th>Slug</th>
                    <th>Assigned Products</th>
                    <th>Featured</th>
                    <th>Schedule</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr id="coll-row-1">
                    <td style="text-align:center;"><input type="checkbox" class="coll-row-chk" value="1"></td>
                    <td><img src="/Frontend/Shop/Asset/images/product1.png" onerror="this.src='/Shared/Asset/images/product1.png';" style="width:40px; height:28px; border-radius:3px; object-fit:cover;"></td>
                    <td>
                        <a href="/Frontend/Admin/catalogue/collections/view.php?id=1" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;">Surat Heritage Silk Festival</a>
                        <div style="font-size:11px; color:#64748b;">Exclusive Festive Wholesale Assortment</div>
                    </td>
                    <td><code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">surat-heritage-silk</code></td>
                    <td><strong>64 SKUs</strong></td>
                    <td><span class="dt-badge gold">Featured</span></td>
                    <td><small style="color:#64748b;">2026/08/01 – 2026/11/30</small></td>
                    <td><span class="dt-badge green">Active</span></td>
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:4px;">
                            <a href="/Frontend/Admin/catalogue/collections/view.php?id=1" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                            <a href="/Frontend/Admin/catalogue/collections/edit.php?id=1" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('coll-row-1', 'Surat Heritage Silk Festival')" style="height:24px; padding:0 6px;">✕</button>
                        </div>
                    </td>
                </tr>

                <tr id="coll-row-2">
                    <td style="text-align:center;"><input type="checkbox" class="coll-row-chk" value="2"></td>
                    <td><img src="/Frontend/Shop/Asset/images/product6.png" onerror="this.src='/Shared/Asset/images/product3.png';" style="width:40px; height:28px; border-radius:3px; object-fit:cover;"></td>
                    <td>
                        <a href="/Frontend/Admin/catalogue/collections/view.php?id=2" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;">Royal Bridal Grandeur 2026</a>
                        <div style="font-size:11px; color:#64748b;">Luxury Zardosi &amp; Velvet Lehengas</div>
                    </td>
                    <td><code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">royal-bridal-2026</code></td>
                    <td><strong>38 SKUs</strong></td>
                    <td><span class="dt-badge gold">Featured</span></td>
                    <td><small style="color:#64748b;">All Season</small></td>
                    <td><span class="dt-badge green">Active</span></td>
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:4px;">
                            <a href="/Frontend/Admin/catalogue/collections/view.php?id=2" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                            <a href="/Frontend/Admin/catalogue/collections/edit.php?id=2" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('coll-row-2', 'Royal Bridal Grandeur 2026')" style="height:24px; padding:0 6px;">✕</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
