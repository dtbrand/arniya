<?php
/**
 * hierarchy-tree.php — Category Hierarchy Tree Component
 * DT Brand's & Jai Hanuman Tex
 */
?>
<div class="dt-tree-container">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:14px; padding-bottom:10px; border-bottom:1px solid #e2e8f0; flex-wrap:wrap; gap:8px;">
        <div>
            <h3 style="font-size:14px; font-weight:800; color:#181512; margin:0;">Master Category Tree &amp; Taxonomy</h3>
            <p style="font-size:11.5px; color:#64748b; margin:2px 0 0 0;">Drag &amp; reorder parent and child categories. Real-time product counts linked.</p>
        </div>
        <div style="display:flex; gap:6px;">
            <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_HIERARCHY.expandAll()" style="height:26px; padding:0 10px; font-size:11px;">Expand All</button>
            <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_HIERARCHY.collapseAll()" style="height:26px; padding:0 10px; font-size:11px;">Collapse All</button>
        </div>
    </div>

    <ul class="dt-tree-root">
        <!-- Node 1: Silk Sarees -->
        <li class="dt-tree-node" id="node-sarees">
            <div class="dt-tree-item level-0">
                <div style="display:flex; align-items:center; gap:10px;">
                    <span class="dt-tree-drag-handle" title="Drag to reorder with mouse">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="6" r="1.5"></circle><circle cx="15" cy="6" r="1.5"></circle><circle cx="9" cy="12" r="1.5"></circle><circle cx="15" cy="12" r="1.5"></circle><circle cx="9" cy="18" r="1.5"></circle><circle cx="15" cy="18" r="1.5"></circle></svg>
                    </span>
                    <button type="button" class="dt-tree-toggle" onclick="window.DT_HIERARCHY.toggleNode(this, 'children-sarees')">−</button>
                    <img src="/Frontend/Shop/Asset/images/product1.png" onerror="this.src='/Shared/Asset/images/product1.png';" style="width:26px; height:26px; border-radius:4px; object-fit:cover;">
                    <div>
                        <a href="/DT%20Brand/admin/catalogue/categories/view.php?id=1" style="color:#181512; text-decoration:none; font-size:12.5px; font-weight:700;">Silk Sarees &amp; Handlooms</a>
                        <span class="dt-badge gold" style="font-size:9.5px; margin-left:6px;">Featured</span>
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <span class="dt-badge green">420 SKUs</span>
                    <span class="dt-badge blue">Active</span>
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_HIERARCHY.moveUp('node-sarees')" title="Move Up" style="height:24px; padding:0 6px;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"></polyline></svg>
                    </button>
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_HIERARCHY.moveDown('node-sarees')" title="Move Down" style="height:24px; padding:0 6px;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </button>
                    <a href="/DT%20Brand/admin/catalogue/categories/edit.php?id=1" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                </div>
            </div>

            <!-- Subchildren -->
            <ul class="dt-tree-children" id="children-sarees">
                <li class="dt-tree-node" id="node-kanjivaram">
                    <div class="dt-tree-item level-1">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="dt-tree-drag-handle" title="Drag to reorder with mouse">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="6" r="1.5"></circle><circle cx="15" cy="6" r="1.5"></circle><circle cx="9" cy="12" r="1.5"></circle><circle cx="15" cy="12" r="1.5"></circle><circle cx="9" cy="18" r="1.5"></circle><circle cx="15" cy="18" r="1.5"></circle></svg>
                    </span>
                            <img src="/Frontend/Shop/Asset/images/product1.png" onerror="this.src='/Shared/Asset/images/product1.png';" style="width:22px; height:22px; border-radius:3px; object-fit:cover;">
                            <span style="font-weight:600; font-size:12px;">Kanjivaram Silk</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:6px;">
                            <span class="dt-badge green">160 SKUs</span>
                            <a href="/DT%20Brand/admin/catalogue/subcategories/edit.php?id=101" class="dt-btn-action-sm pale-gold" style="height:22px; padding:0 6px; font-size:10.5px;">Edit</a>
                        </div>
                    </div>
                </li>
                <li class="dt-tree-node" id="node-banarasi">
                    <div class="dt-tree-item level-1">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="dt-tree-drag-handle" title="Drag to reorder with mouse">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="6" r="1.5"></circle><circle cx="15" cy="6" r="1.5"></circle><circle cx="9" cy="12" r="1.5"></circle><circle cx="15" cy="12" r="1.5"></circle><circle cx="9" cy="18" r="1.5"></circle><circle cx="15" cy="18" r="1.5"></circle></svg>
                    </span>
                            <img src="/Frontend/Shop/Asset/images/product2.png" onerror="this.src='/Shared/Asset/images/product2.png';" style="width:22px; height:22px; border-radius:3px; object-fit:cover;">
                            <span style="font-weight:600; font-size:12px;">Banarasi Brocade</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:6px;">
                            <span class="dt-badge green">140 SKUs</span>
                            <a href="/DT%20Brand/admin/catalogue/subcategories/edit.php?id=102" class="dt-btn-action-sm pale-gold" style="height:22px; padding:0 6px; font-size:10.5px;">Edit</a>
                        </div>
                    </div>
                </li>
                <li class="dt-tree-node" id="node-chanderi">
                    <div class="dt-tree-item level-1">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="dt-tree-drag-handle" title="Drag to reorder with mouse">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="6" r="1.5"></circle><circle cx="15" cy="6" r="1.5"></circle><circle cx="9" cy="12" r="1.5"></circle><circle cx="15" cy="12" r="1.5"></circle><circle cx="9" cy="18" r="1.5"></circle><circle cx="15" cy="18" r="1.5"></circle></svg>
                    </span>
                            <img src="/Frontend/Shop/Asset/images/product3.png" onerror="this.src='/Shared/Asset/images/product3.png';" style="width:22px; height:22px; border-radius:3px; object-fit:cover;">
                            <span style="font-weight:600; font-size:12px;">Chanderi &amp; Tussar</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:6px;">
                            <span class="dt-badge green">120 SKUs</span>
                            <a href="/DT%20Brand/admin/catalogue/subcategories/edit.php?id=103" class="dt-btn-action-sm pale-gold" style="height:22px; padding:0 6px; font-size:10.5px;">Edit</a>
                        </div>
                    </div>
                </li>
            </ul>
        </li>

        <!-- Node 2: Bridal Lehengas -->
        <li class="dt-tree-node" id="node-lehengas" style="margin-top:10px;">
            <div class="dt-tree-item level-0">
                <div style="display:flex; align-items:center; gap:10px;">
                    <span class="dt-tree-drag-handle" title="Drag to reorder with mouse">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="6" r="1.5"></circle><circle cx="15" cy="6" r="1.5"></circle><circle cx="9" cy="12" r="1.5"></circle><circle cx="15" cy="12" r="1.5"></circle><circle cx="9" cy="18" r="1.5"></circle><circle cx="15" cy="18" r="1.5"></circle></svg>
                    </span>
                    <button type="button" class="dt-tree-toggle" onclick="window.DT_HIERARCHY.toggleNode(this, 'children-lehengas')">−</button>
                    <img src="/Frontend/Shop/Asset/images/product6.png" onerror="this.src='/Shared/Asset/images/product3.png';" style="width:26px; height:26px; border-radius:4px; object-fit:cover;">
                    <div>
                        <a href="/DT%20Brand/admin/catalogue/categories/view.php?id=2" style="color:#181512; text-decoration:none; font-size:12.5px; font-weight:700;">Bridal &amp; Festive Lehengas</a>
                        <span class="dt-badge gold" style="font-size:9.5px; margin-left:6px;">Featured</span>
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <span class="dt-badge green">280 SKUs</span>
                    <span class="dt-badge blue">Active</span>
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_HIERARCHY.moveUp('node-lehengas')" title="Move Up" style="height:24px; padding:0 6px;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"></polyline></svg>
                    </button>
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_HIERARCHY.moveDown('node-lehengas')" title="Move Down" style="height:24px; padding:0 6px;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </button>
                    <a href="/DT%20Brand/admin/catalogue/categories/edit.php?id=2" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                </div>
            </div>

            <!-- Subchildren -->
            <ul class="dt-tree-children" id="children-lehengas">
                <li class="dt-tree-node">
                    <div class="dt-tree-item level-1">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="dt-tree-drag-handle" title="Drag to reorder with mouse">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="6" r="1.5"></circle><circle cx="15" cy="6" r="1.5"></circle><circle cx="9" cy="12" r="1.5"></circle><circle cx="15" cy="12" r="1.5"></circle><circle cx="9" cy="18" r="1.5"></circle><circle cx="15" cy="18" r="1.5"></circle></svg>
                    </span>
                            <span style="font-weight:600; font-size:12px;">Zardosi Velvet Lehengas</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:6px;">
                            <span class="dt-badge green">120 SKUs</span>
                        </div>
                    </div>
                </li>
                <li class="dt-tree-node">
                    <div class="dt-tree-item level-1">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="dt-tree-drag-handle" title="Drag to reorder with mouse">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="6" r="1.5"></circle><circle cx="15" cy="6" r="1.5"></circle><circle cx="9" cy="12" r="1.5"></circle><circle cx="15" cy="12" r="1.5"></circle><circle cx="9" cy="18" r="1.5"></circle><circle cx="15" cy="18" r="1.5"></circle></svg>
                    </span>
                            <span style="font-weight:600; font-size:12px;">Semi-Stitched Festive Sets</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:6px;">
                            <span class="dt-badge green">160 SKUs</span>
                        </div>
                    </div>
                </li>
            </ul>
        </li>

        <!-- Node 3: Designer Kurtis -->
        <li class="dt-tree-node" id="node-kurtis" style="margin-top:10px;">
            <div class="dt-tree-item level-0">
                <div style="display:flex; align-items:center; gap:10px;">
                    <span class="dt-tree-drag-handle" title="Drag to reorder with mouse">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="6" r="1.5"></circle><circle cx="15" cy="6" r="1.5"></circle><circle cx="9" cy="12" r="1.5"></circle><circle cx="15" cy="12" r="1.5"></circle><circle cx="9" cy="18" r="1.5"></circle><circle cx="15" cy="18" r="1.5"></circle></svg>
                    </span>
                    <button type="button" class="dt-tree-toggle" onclick="window.DT_HIERARCHY.toggleNode(this, 'children-kurtis')">−</button>
                    <img src="/Frontend/Shop/Asset/images/product4.png" onerror="this.src='/Shared/Asset/images/product4.png';" style="width:26px; height:26px; border-radius:4px; object-fit:cover;">
                    <div>
                        <a href="/DT%20Brand/admin/catalogue/categories/view.php?id=3" style="color:#181512; text-decoration:none; font-size:12.5px; font-weight:700;">Designer Kurtis &amp; Tunics</a>
                    </div>
                </div>
                <div style="display:flex; align-items:center; gap:8px;">
                    <span class="dt-badge green">310 SKUs</span>
                    <span class="dt-badge blue">Active</span>
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_HIERARCHY.moveUp('node-kurtis')" title="Move Up" style="height:24px; padding:0 6px;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"></polyline></svg>
                    </button>
                    <button type="button" class="dt-btn-action-sm pale-gold" onclick="window.DT_HIERARCHY.moveDown('node-kurtis')" title="Move Down" style="height:24px; padding:0 6px;">
                        <svg viewBox="0 0 24 24" width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </button>
                    <a href="/DT%20Brand/admin/catalogue/categories/edit.php?id=3" class="dt-btn-action-sm pale-gold" style="height:24px; padding:0 8px; font-size:11px;">Edit</a>
                </div>
            </div>

            <!-- Subchildren -->
            <ul class="dt-tree-children" id="children-kurtis">
                <li class="dt-tree-node">
                    <div class="dt-tree-item level-1">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="dt-tree-drag-handle" title="Drag to reorder with mouse">
                        <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="9" cy="6" r="1.5"></circle><circle cx="15" cy="6" r="1.5"></circle><circle cx="9" cy="12" r="1.5"></circle><circle cx="15" cy="12" r="1.5"></circle><circle cx="9" cy="18" r="1.5"></circle><circle cx="15" cy="18" r="1.5"></circle></svg>
                    </span>
                            <span style="font-weight:600; font-size:12px;">Anarkali Kurti Sets</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:6px;">
                            <span class="dt-badge green">180 SKUs</span>
                        </div>
                    </div>
                </li>
                <li class="dt-tree-node">
                    <div class="dt-tree-item level-1">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span class="dt-tree-drag-handle">☰</span>
                            <span style="font-weight:600; font-size:12px;">Straight Cut Foil Prints</span>
                        </div>
                        <div style="display:flex; align-items:center; gap:6px;">
                            <span class="dt-badge green">130 SKUs</span>
                        </div>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</div>
