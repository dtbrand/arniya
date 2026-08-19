<?php
/**
 * product-table.php — 16-Column Desktop Data Table with Vector SVG Action Buttons
 */
?>
<div class="dt-table-wrap">
    <table class="dt-data-table" id="dtProductMasterTable">
        <thead>
            <tr>
                <th style="width:36px; text-align:center;">
                    <input type="checkbox" onchange="window.toggleBulkSelectAll(this)" style="cursor:pointer;" title="Select All">
                </th>
                <th>Image</th>
                <th>Product Name &amp; SKU</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Variants</th>
                <th>MRP</th>
                <th>Retail Price</th>
                <th>Reseller Price</th>
                <th>Wholesale (B2B)</th>
                <th>Stock</th>
                <th>Rating</th>
                <th>Status</th>
                <th>Updated</th>
                <th style="text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody id="dtProductTableBody">
            <!-- Row 1 -->
            <tr>
                <td style="text-align:center;">
                    <input type="checkbox" class="dt-prod-row-check" onchange="window.handleRowSelect()" style="cursor:pointer;">
                </td>
                <td>
                    <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="dt-prod-img" alt="Saree">
                </td>
                <td>
                    <a href="/Frontend/Admin/products/view.php?id=101" class="dt-prod-info-name">Kanjivaram Pure Silk Gold Zari Saree</a>
                    <span class="dt-prod-info-sku">SKU: KLN-SR-111 • Barcode: 8901234500111</span>
                </td>
                <td><strong>Silk Sarees</strong></td>
                <td><span style="font-size:0.75rem; color:#8A681F; font-weight:700;">DT Signature</span></td>
                <td><span style="background:#FAF5E8; padding:2px 6px; border-radius:4px; font-size:0.72rem; font-weight:700; color:#5A4210;">3 Colors</span></td>
                <td><del style="color:#7A7266; font-size:0.75rem;">₹5,990</del></td>
                <td><strong style="color:#181512;">₹4,490</strong></td>
                <td><strong style="color:#7E22CE;">₹3,450</strong></td>
                <td><strong style="color:#8A681F;">₹2,850/pc</strong><br><small style="color:#7A7266;">MOQ: 8 pcs</small></td>
                <td><strong>45 units</strong></td>
                <td><span style="color:#F59E0B; font-weight:800;">5.0 ★</span> <small style="color:#7A7266;">(128)</small></td>
                <td><span class="adm-badge success">Active</span></td>
                <td><small style="color:#7A7266;">Today, 11:20 AM</small></td>
                <td style="text-align:right;">
                    <div class="adm-action-btn-group" style="justify-content:flex-end;">
                        <a href="/Frontend/Admin/products/view.php?id=101" class="adm-action-btn" title="View Details">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </a>
                        <a href="/Frontend/Admin/products/edit.php?id=101" class="adm-action-btn" title="Edit">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </a>
                        <a href="/Frontend/Admin/products/duplicate.php?id=101" class="adm-action-btn" title="Duplicate">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        </a>
                        <button type="button" class="adm-action-btn wa" title="Share via WhatsApp" onclick="window.shareProductWhatsApp(101)">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        </button>
                    </div>
                </td>
            </tr>

            <!-- Row 2 -->
            <tr>
                <td style="text-align:center;">
                    <input type="checkbox" class="dt-prod-row-check" onchange="window.handleRowSelect()" style="cursor:pointer;">
                </td>
                <td>
                    <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" class="dt-prod-img" alt="Saree">
                </td>
                <td>
                    <a href="/Frontend/Admin/products/view.php?id=102" class="dt-prod-info-name">Banarasi Royal Brocade Weave Saree</a>
                    <span class="dt-prod-info-sku">SKU: BNR-SR-204 • Barcode: 8901234500204</span>
                </td>
                <td><strong>Banarasi</strong></td>
                <td><span style="font-size:0.75rem; color:#8A681F; font-weight:700;">Arniya Heritage</span></td>
                <td><span style="background:#FAF5E8; padding:2px 6px; border-radius:4px; font-size:0.72rem; font-weight:700; color:#5A4210;">4 Colors</span></td>
                <td><del style="color:#7A7266; font-size:0.75rem;">₹6,490</del></td>
                <td><strong style="color:#181512;">₹4,990</strong></td>
                <td><strong style="color:#7E22CE;">₹3,850</strong></td>
                <td><strong style="color:#8A681F;">₹3,200/pc</strong><br><small style="color:#7A7266;">MOQ: 8 pcs</small></td>
                <td><strong>28 units</strong></td>
                <td><span style="color:#F59E0B; font-weight:800;">4.9 ★</span> <small style="color:#7A7266;">(94)</small></td>
                <td><span class="adm-badge success">Active</span></td>
                <td><small style="color:#7A7266;">Yesterday</small></td>
                <td style="text-align:right;">
                    <div class="adm-action-btn-group" style="justify-content:flex-end;">
                        <a href="/Frontend/Admin/products/view.php?id=102" class="adm-action-btn" title="View Details">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </a>
                        <a href="/Frontend/Admin/products/edit.php?id=102" class="adm-action-btn" title="Edit">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </a>
                        <a href="/Frontend/Admin/products/duplicate.php?id=102" class="adm-action-btn" title="Duplicate">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        </a>
                        <button type="button" class="adm-action-btn wa" title="Share via WhatsApp" onclick="window.shareProductWhatsApp(102)">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        </button>
                    </div>
                </td>
            </tr>

            <!-- Row 3 -->
            <tr>
                <td style="text-align:center;">
                    <input type="checkbox" class="dt-prod-row-check" onchange="window.handleRowSelect()" style="cursor:pointer;">
                </td>
                <td>
                    <img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" class="dt-prod-img" alt="Lehenga">
                </td>
                <td>
                    <a href="/Frontend/Admin/products/view.php?id=103" class="dt-prod-info-name">Crimson Bridal Handcrafted Zardosi Lehenga</a>
                    <span class="dt-prod-info-sku">SKU: BRD-LH-902 • Barcode: 8901234500902</span>
                </td>
                <td><strong>Bridal Lehengas</strong></td>
                <td><span style="font-size:0.75rem; color:#8A681F; font-weight:700;">DT Couture</span></td>
                <td><span style="background:#FAF5E8; padding:2px 6px; border-radius:4px; font-size:0.72rem; font-weight:700; color:#5A4210;">Free Size</span></td>
                <td><del style="color:#7A7266; font-size:0.75rem;">₹21,990</del></td>
                <td><strong style="color:#181512;">₹16,490</strong></td>
                <td><strong style="color:#7E22CE;">₹13,200</strong></td>
                <td><strong style="color:#8A681F;">₹11,500/pc</strong><br><small style="color:#7A7266;">MOQ: 2 pcs</small></td>
                <td><strong style="color:#DC2626;">4 units</strong></td>
                <td><span style="color:#F59E0B; font-weight:800;">5.0 ★</span> <small style="color:#7A7266;">(42)</small></td>
                <td><span class="adm-badge warning">Low Stock</span></td>
                <td><small style="color:#7A7266;">2 days ago</small></td>
                <td style="text-align:right;">
                    <div class="adm-action-btn-group" style="justify-content:flex-end;">
                        <a href="/Frontend/Admin/products/view.php?id=103" class="adm-action-btn" title="View Details">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </a>
                        <a href="/Frontend/Admin/products/edit.php?id=103" class="adm-action-btn" title="Edit">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </a>
                        <a href="/Frontend/Admin/products/duplicate.php?id=103" class="adm-action-btn" title="Duplicate">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                        </a>
                        <button type="button" class="adm-action-btn wa" title="Share via WhatsApp" onclick="window.shareProductWhatsApp(103)">
                            <svg viewBox="0 0 24 24" width="13" height="13" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
