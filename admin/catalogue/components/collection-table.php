<?php
/* DT admin access guard (auto-inserted) */ $__dtg = $_SERVER['DOCUMENT_ROOT'] . '/admin/Includes/adminguard.php'; if (is_file($__dtg)) require_once $__dtg;

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
        <div style="display:flex; gap:6px; align-items:center;">
            <a href="/admin/catalogue/collections/add.php" class="dt-btn-action-sm gold" style="height:28px; padding:0 12px; font-size:11px;">
                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.8"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Add Collection</span>
            </a>
        </div>
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
                <!-- Row 1 -->
                <tr id="coll-row-1" data-status="active">
                    <td style="text-align:center;"><input type="checkbox" class="coll-row-chk" value="1"></td>
                    <td><img src="/assets/images/product1.png" onerror="this.src='/assets/images/product1.png';" style="width:40px; height:28px; border-radius:3px; object-fit:cover;"></td>
                    <td>
                        <a href="/admin/catalogue/collections/view.php?id=1" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;">Surat Heritage Silk Festival</a>
                        <div style="font-size:11px; color:#64748b;">Exclusive Festive Wholesale Assortment</div>
                    </td>
                    <td><code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">surat-heritage-silk</code></td>
                    <td><strong>64 SKUs</strong></td>
                    <td><span class="dt-badge gold">Featured</span></td>
                    <td><small style="color:#64748b;">2026/08/01 – 2026/11/30</small></td>
                    <td><span class="dt-badge green">Active</span></td>
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:4px;">
                            <a href="/admin/catalogue/collections/view.php?id=1" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                            <a href="/admin/catalogue/collections/edit.php?id=1" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('coll-row-1', 'Surat Heritage Silk Festival')" style="height:24px; padding:0 6px;" title="Delete Collection">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Row 2 -->
                <tr id="coll-row-2" data-status="active">
                    <td style="text-align:center;"><input type="checkbox" class="coll-row-chk" value="2"></td>
                    <td><img src="/assets/images/product6.png" onerror="this.src='/assets/images/product3.png';" style="width:40px; height:28px; border-radius:3px; object-fit:cover;"></td>
                    <td>
                        <a href="/admin/catalogue/collections/view.php?id=2" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;">Royal Bridal Grandeur 2026</a>
                        <div style="font-size:11px; color:#64748b;">Luxury Zardosi &amp; Velvet Lehengas</div>
                    </td>
                    <td><code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">royal-bridal-2026</code></td>
                    <td><strong>38 SKUs</strong></td>
                    <td><span class="dt-badge gold">Featured</span></td>
                    <td><small style="color:#64748b;">All Season</small></td>
                    <td><span class="dt-badge green">Active</span></td>
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:4px;">
                            <a href="/admin/catalogue/collections/view.php?id=2" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                            <a href="/admin/catalogue/collections/edit.php?id=2" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('coll-row-2', 'Royal Bridal Grandeur 2026')" style="height:24px; padding:0 6px;" title="Delete Collection">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Row 3 -->
                <tr id="coll-row-3" data-status="active">
                    <td style="text-align:center;"><input type="checkbox" class="coll-row-chk" value="3"></td>
                    <td><img src="/assets/images/product2.png" onerror="this.src='/assets/images/product2.png';" style="width:40px; height:28px; border-radius:3px; object-fit:cover;"></td>
                    <td>
                        <a href="/admin/catalogue/collections/view.php?id=3" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;">Diwali Festive Handloom Edit</a>
                        <div style="font-size:11px; color:#64748b;">Pure Katan &amp; Chanderi Weaves</div>
                    </td>
                    <td><code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">diwali-festive-edit</code></td>
                    <td><strong>52 SKUs</strong></td>
                    <td><span class="dt-badge gold">Featured</span></td>
                    <td><small style="color:#64748b;">2026/09/15 – 2026/11/15</small></td>
                    <td><span class="dt-badge green">Active</span></td>
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:4px;">
                            <a href="/admin/catalogue/collections/view.php?id=3" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                            <a href="/admin/catalogue/collections/edit.php?id=3" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('coll-row-3', 'Diwali Festive Handloom Edit')" style="height:24px; padding:0 6px;" title="Delete Collection">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Row 4 -->
                <tr id="coll-row-4" data-status="active">
                    <td style="text-align:center;"><input type="checkbox" class="coll-row-chk" value="4"></td>
                    <td><img src="/assets/images/product4.png" onerror="this.src='/assets/images/product4.png';" style="width:40px; height:28px; border-radius:3px; object-fit:cover;"></td>
                    <td>
                        <a href="/admin/catalogue/collections/view.php?id=4" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;">Summer Daily Wear Kurtis</a>
                        <div style="font-size:11px; color:#64748b;">Breathable Rayon &amp; Mulmul Sets</div>
                    </td>
                    <td><code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">summer-daily-kurtis</code></td>
                    <td><strong>45 SKUs</strong></td>
                    <td><span class="dt-badge blue">Standard</span></td>
                    <td><small style="color:#64748b;">All Season</small></td>
                    <td><span class="dt-badge green">Active</span></td>
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:4px;">
                            <a href="/admin/catalogue/collections/view.php?id=4" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                            <a href="/admin/catalogue/collections/edit.php?id=4" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('coll-row-4', 'Summer Daily Wear Kurtis')" style="height:24px; padding:0 6px;" title="Delete Collection">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Row 5 -->
                <tr id="coll-row-5" data-status="active">
                    <td style="text-align:center;"><input type="checkbox" class="coll-row-chk" value="5"></td>
                    <td><img src="/assets/images/product5.png" onerror="this.src='/assets/images/product5.png';" style="width:40px; height:28px; border-radius:3px; object-fit:cover;"></td>
                    <td>
                        <a href="/admin/catalogue/collections/view.php?id=5" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;">Surat Central Depot Ready Stock</a>
                        <div style="font-size:11px; color:#64748b;">Fast Dispatch Wholesale Catalog Lots</div>
                    </td>
                    <td><code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">surat-ready-stock</code></td>
                    <td><strong>120 SKUs</strong></td>
                    <td><span class="dt-badge gold">Featured</span></td>
                    <td><small style="color:#64748b;">Priority Lot</small></td>
                    <td><span class="dt-badge green">Active</span></td>
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:4px;">
                            <a href="/admin/catalogue/collections/view.php?id=5" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                            <a href="/admin/catalogue/collections/edit.php?id=5" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('coll-row-5', 'Surat Central Depot Ready Stock')" style="height:24px; padding:0 6px;" title="Delete Collection">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Row 6 -->
                <tr id="coll-row-6" data-status="active">
                    <td style="text-align:center;"><input type="checkbox" class="coll-row-chk" value="6"></td>
                    <td><img src="/assets/images/product1.png" onerror="this.src='/assets/images/product1.png';" style="width:40px; height:28px; border-radius:3px; object-fit:cover;"></td>
                    <td>
                        <a href="/admin/catalogue/collections/view.php?id=6" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;">Silk Mark Certified Heritage Sarees</a>
                        <div style="font-size:11px; color:#64748b;">Authentic Govt. Certified Pure Silk Weaves</div>
                    </td>
                    <td><code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">silk-mark-certified</code></td>
                    <td><strong>40 SKUs</strong></td>
                    <td><span class="dt-badge gold">Featured</span></td>
                    <td><small style="color:#64748b;">All Season</small></td>
                    <td><span class="dt-badge green">Active</span></td>
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:4px;">
                            <a href="/admin/catalogue/collections/view.php?id=6" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                            <a href="/admin/catalogue/collections/edit.php?id=6" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('coll-row-6', 'Silk Mark Certified Heritage Sarees')" style="height:24px; padding:0 6px;" title="Delete Collection">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Row 7 -->
                <tr id="coll-row-7" data-status="active">
                    <td style="text-align:center;"><input type="checkbox" class="coll-row-chk" value="7"></td>
                    <td><img src="/assets/images/product3.png" onerror="this.src='/assets/images/product3.png';" style="width:40px; height:28px; border-radius:3px; object-fit:cover;"></td>
                    <td>
                        <a href="/admin/catalogue/collections/view.php?id=7" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;">Reseller Low MOQ Deals (MOQ 4)</a>
                        <div style="font-size:11px; color:#64748b;">Fast Moving Catalogues for WhatsApp Resellers</div>
                    </td>
                    <td><code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">reseller-low-moq</code></td>
                    <td><strong>75 SKUs</strong></td>
                    <td><span class="dt-badge blue">Standard</span></td>
                    <td><small style="color:#64748b;">Reseller Special</small></td>
                    <td><span class="dt-badge green">Active</span></td>
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:4px;">
                            <a href="/admin/catalogue/collections/view.php?id=7" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                            <a href="/admin/catalogue/collections/edit.php?id=7" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('coll-row-7', 'Reseller Low MOQ Deals (MOQ 4)')" style="height:24px; padding:0 6px;" title="Delete Collection">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Row 8 -->
                <tr id="coll-row-8" data-status="active">
                    <td style="text-align:center;"><input type="checkbox" class="coll-row-chk" value="8"></td>
                    <td><img src="/assets/images/product6.png" onerror="this.src='/assets/images/product6.png';" style="width:40px; height:28px; border-radius:3px; object-fit:cover;"></td>
                    <td>
                        <a href="/admin/catalogue/collections/view.php?id=8" style="font-weight:700; color:#181512; text-decoration:none; font-size:12.5px;">Wedding Trousseau Master Box</a>
                        <div style="font-size:11px; color:#64748b;">Complete Bridal &amp; Family Festive Assortments</div>
                    </td>
                    <td><code style="font-size:11px; background:#f1f5f9; padding:2px 5px; border-radius:3px;">wedding-trousseau-box</code></td>
                    <td><strong>30 SKUs</strong></td>
                    <td><span class="dt-badge gold">Featured</span></td>
                    <td><small style="color:#64748b;">Wedding Season</small></td>
                    <td><span class="dt-badge green">Active</span></td>
                    <td style="text-align:right;">
                        <div style="display:inline-flex; gap:4px;">
                            <a href="/admin/catalogue/collections/view.php?id=8" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">View</a>
                            <a href="/admin/catalogue/collections/edit.php?id=8" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                            <button type="button" class="dt-btn-action-sm danger" onclick="window.DT_CATALOGUE.deleteRow('coll-row-8', 'Wedding Trousseau Master Box')" style="height:24px; padding:0 6px;" title="Delete Collection">
                                <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
