<?php
/**
 * product-table.php — Complete Desktop Products Data Table
 */
?>
<div class="dt-table-wrap">
    <table class="dt-data-table" id="dtProductMasterTable">
        <thead>
            <tr>
                <th style="width:36px; text-align:center;">
                    <input type="checkbox" onchange="window.toggleBulkSelectAll(this)" style="cursor:pointer;">
                </th>
                <th>Product & SKU</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Variants</th>
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
            <tr>
                <td style="text-align:center;">
                    <input type="checkbox" class="dt-prod-row-check" onchange="window.handleRowSelect()" style="cursor:pointer;">
                </td>
                <td>
                    <div class="dt-prod-cell">
                        <img src="/Shared/Asset/images/product1.png" onerror="this.src='/Frontend/Shop/Asset/images/product1.png';" class="dt-prod-img" alt="Saree">
                        <div>
                            <a href="/Frontend/Admin/products/view.php?id=101" class="dt-prod-info-name">Kanjivaram Pure Silk Gold Zari Saree</a>
                            <span class="dt-prod-info-sku">SKU: KLN-SR-111 • HSN: 5007</span>
                        </div>
                    </div>
                </td>
                <td><strong>Silk Sarees</strong></td>
                <td><span style="font-size:0.75rem; color:#8A681F; font-weight:700;">DT Signature</span></td>
                <td><span style="background:#FAF5E8; padding:2px 6px; border-radius:4px; font-size:0.72rem; font-weight:700;">3 Colors</span></td>
                <td><strong>₹4,490</strong></td>
                <td><strong style="color:#7E22CE;">₹3,450</strong></td>
                <td><strong style="color:#8A681F;">₹2,850/pc</strong><br><small style="color:#7A7266;">MOQ: 8 pcs</small></td>
                <td><strong>45 units</strong></td>
                <td><span style="color:#F59E0B; font-weight:800;">5.0 ★</span> <small style="color:#7A7266;">(128)</small></td>
                <td><span class="adm-badge success">Active</span></td>
                <td><small style="color:#7A7266;">Today, 11:20 AM</small></td>
                <td style="text-align:right;">
                    <div class="adm-action-btn-group" style="justify-content:flex-end;">
                        <a href="/Frontend/Admin/products/view.php?id=101" class="adm-action-btn" title="View Details">👁️</a>
                        <a href="/Frontend/Admin/products/edit.php?id=101" class="adm-action-btn" title="Edit">✏️</a>
                        <a href="/Frontend/Admin/products/duplicate.php?id=101" class="adm-action-btn" title="Duplicate">📋</a>
                        <button type="button" class="adm-action-btn wa" title="Share WhatsApp" onclick="window.shareProductWhatsApp(101)">💬</button>
                    </div>
                </td>
            </tr>

            <tr>
                <td style="text-align:center;">
                    <input type="checkbox" class="dt-prod-row-check" onchange="window.handleRowSelect()" style="cursor:pointer;">
                </td>
                <td>
                    <div class="dt-prod-cell">
                        <img src="/Shared/Asset/images/product2.png" onerror="this.src='/Frontend/Shop/Asset/images/product2.png';" class="dt-prod-img" alt="Saree">
                        <div>
                            <a href="/Frontend/Admin/products/view.php?id=102" class="dt-prod-info-name">Banarasi Royal Brocade Weave Saree</a>
                            <span class="dt-prod-info-sku">SKU: BNR-SR-204 • HSN: 5007</span>
                        </div>
                    </div>
                </td>
                <td><strong>Banarasi</strong></td>
                <td><span style="font-size:0.75rem; color:#8A681F; font-weight:700;">Arniya Heritage</span></td>
                <td><span style="background:#FAF5E8; padding:2px 6px; border-radius:4px; font-size:0.72rem; font-weight:700;">4 Colors</span></td>
                <td><strong>₹4,990</strong></td>
                <td><strong style="color:#7E22CE;">₹3,850</strong></td>
                <td><strong style="color:#8A681F;">₹3,200/pc</strong><br><small style="color:#7A7266;">MOQ: 8 pcs</small></td>
                <td><strong>28 units</strong></td>
                <td><span style="color:#F59E0B; font-weight:800;">4.9 ★</span> <small style="color:#7A7266;">(94)</small></td>
                <td><span class="adm-badge success">Active</span></td>
                <td><small style="color:#7A7266;">Yesterday</small></td>
                <td style="text-align:right;">
                    <div class="adm-action-btn-group" style="justify-content:flex-end;">
                        <a href="/Frontend/Admin/products/view.php?id=102" class="adm-action-btn" title="View Details">👁️</a>
                        <a href="/Frontend/Admin/products/edit.php?id=102" class="adm-action-btn" title="Edit">✏️</a>
                        <a href="/Frontend/Admin/products/duplicate.php?id=102" class="adm-action-btn" title="Duplicate">📋</a>
                        <button type="button" class="adm-action-btn wa" title="Share WhatsApp" onclick="window.shareProductWhatsApp(102)">💬</button>
                    </div>
                </td>
            </tr>

            <tr>
                <td style="text-align:center;">
                    <input type="checkbox" class="dt-prod-row-check" onchange="window.handleRowSelect()" style="cursor:pointer;">
                </td>
                <td>
                    <div class="dt-prod-cell">
                        <img src="/Shared/Asset/images/product3.png" onerror="this.src='/Frontend/Shop/Asset/images/product3.png';" class="dt-prod-img" alt="Lehenga">
                        <div>
                            <a href="/Frontend/Admin/products/view.php?id=103" class="dt-prod-info-name">Crimson Bridal Handcrafted Zardosi Lehenga</a>
                            <span class="dt-prod-info-sku">SKU: BRD-LH-902 • HSN: 6204</span>
                        </div>
                    </div>
                </td>
                <td><strong>Bridal Lehengas</strong></td>
                <td><span style="font-size:0.75rem; color:#8A681F; font-weight:700;">DT Couture</span></td>
                <td><span style="background:#FAF5E8; padding:2px 6px; border-radius:4px; font-size:0.72rem; font-weight:700;">Free Size</span></td>
                <td><strong>₹16,490</strong></td>
                <td><strong style="color:#7E22CE;">₹13,200</strong></td>
                <td><strong style="color:#8A681F;">₹11,500/pc</strong><br><small style="color:#7A7266;">MOQ: 2 pcs</small></td>
                <td><strong style="color:#DC2626;">4 units</strong></td>
                <td><span style="color:#F59E0B; font-weight:800;">5.0 ★</span> <small style="color:#7A7266;">(42)</small></td>
                <td><span class="adm-badge warning">Low Stock</span></td>
                <td><small style="color:#7A7266;">2 days ago</small></td>
                <td style="text-align:right;">
                    <div class="adm-action-btn-group" style="justify-content:flex-end;">
                        <a href="/Frontend/Admin/products/view.php?id=103" class="adm-action-btn" title="View Details">👁️</a>
                        <a href="/Frontend/Admin/products/edit.php?id=103" class="adm-action-btn" title="Edit">✏️</a>
                        <a href="/Frontend/Admin/products/duplicate.php?id=103" class="adm-action-btn" title="Duplicate">📋</a>
                        <button type="button" class="adm-action-btn wa" title="Share WhatsApp" onclick="window.shareProductWhatsApp(103)">💬</button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
